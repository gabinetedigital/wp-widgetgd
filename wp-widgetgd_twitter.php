<?php

class Tweetview_Widget extends WP_Widget {

	function Tweetview_Widget() {

		add_action('wp_footer', array($this,'tweetview_javascript'));
		$widget_ops = array('classname' => 'tweetview_widget','description' => 'Widget com lista de tweet.');

		$this->WP_Widget('tweetview_widget', 'Gabinete Digital - Twitter', $widget_ops);

		if(!is_admin()) {
			wp_enqueue_script('jquery');
			add_action('wp_head', array($this,'tweetview_head'));
		}
	}

	function form($instance) {
		$instance = wp_parse_args((array) $instance, array( 'tweetview_title' => '', 'tweetview_username' => '', 'tweetview_no_tweets' => '5', 'colunas'=>'3', 'css_class' => ''));

		$tweetview_title = $instance['tweetview_title'];
		$tweetview_username = $instance['tweetview_username'];
		$tweetview_no_tweets = $instance['tweetview_no_tweets'];
		$colunas = $instance['colunas'];
		$css_class = $instance['css_class'];

		?>
		<p><label for="<?php echo $this->get_field_id('tweetview_title'); ?>">Titulo: <input class="widefat" id="<?php echo $this->get_field_id('tweetview_title'); ?>" name="<?php echo $this->get_field_name('tweetview_title'); ?>" type="text" value="<?php echo attribute_escape($tweetview_title); ?>" /></label></p>
		<p><label for="<?php echo $this->get_field_id('tweetview_username'); ?>">Conta do Twitter: <input class="widefat" id="<?php echo $this->get_field_id('tweetview_username'); ?>" name="<?php echo $this->get_field_name('tweetview_username'); ?>" type="text" value="<?php echo attribute_escape($tweetview_username); ?>" /></label></p>
		<p><label for="<?php echo $this->get_field_id('tweetview_no_tweets'); ?>">Numero de tweets: <input class="widefat" id="<?php echo $this->get_field_id('tweetview_no_tweets'); ?>" name="<?php echo $this->get_field_name('tweetview_no_tweets'); ?>" type="text" value="<?php echo attribute_escape($tweetview_no_tweets); ?>" /></label></p>
		<p><label for="<?php echo $this->get_field_id('colunas'); ?>">Colunas: <input class="widefat" id="<?php echo $this->get_field_id('colunas'); ?>" name="<?php echo $this->get_field_name('colunas'); ?>" type="text" value="<?php echo attribute_escape($colunas); ?>" /></label></p>
		<p><label for="<?php echo $this->get_field_id('css_class'); ?>">Classe CSS: <input class="widefat" id="<?php echo $this->get_field_id('css_class'); ?>" name="<?php echo $this->get_field_name('css_class'); ?>" type="text" value="<?php echo attribute_escape($css_class); ?>" /></label></p>
		<?php
	}

	function update($new_instance, $old_instance) {
		$instance = $old_instance;
		$instance['tweetview_title'] = $new_instance['tweetview_title'];
		$instance['tweetview_username'] = $new_instance['tweetview_username'];
		$instance['tweetview_no_tweets'] = $new_instance['tweetview_no_tweets'];
		$instance['colunas'] = $new_instance['colunas'];
		$instance['css_class'] = $new_instance['css_class'];
		return $instance;
	}

	function widget($args, $instance) {
		extract($args);

	    echo "<li class='span".$instance['colunas']."'>";
	    echo "<div class='thumbnail lasttweet ".$instance['css_class']."'>";
		$title = (empty($instance['tweetview_title'])) ? '' : apply_filters('widget_title', $instance['tweetview_title']);


		$url = 'https://api.twitter.com/1.1/statuses/user_timeline.json';
		$getfield = "?screen_name=".$instance['tweetview_username']."&include_rts=true&count=" . $instance['tweetview_no_tweets'];
		// $getfield = '?screen_name=j7mbo';
		$requestMethod = 'GET';

		$twitter_consumer_key = get_option("gd_twitter_consumer_key");
        $twitter_consumer_secret = get_option("gd_twitter_consumer_secret");
        $twitter_access_token = get_option("gd_twitter_access_token");
    	$twitter_access_token_secret = get_option("gd_twitter_access_token_secret");
    	error_log("Com as configurações do WP ============================================================= >");
		$settings = array(
		    'oauth_access_token' => $twitter_access_token,
		    'oauth_access_token_secret' => $twitter_access_token_secret,
		    'consumer_key' => $twitter_consumer_key,
		    'consumer_secret' => $twitter_consumer_secret
		);
		// $settings = array(
		//     'oauth_access_token' => "252530217-o7nvCnfDssJp0MN3SLPwkJWenx2POIM9l4EXe05P",
		//     'oauth_access_token_secret' => "PsLckKAAgwKm3SN6bMI56bNMEW5B9r5dq0VrF7Jif8",
		//     'consumer_key' => "ScQDqmWRfhLh2Mu2ZqIolw",
		//     'consumer_secret' => "jCRJQQDrvXWg3Mhmr1VQLJ3x4ACJBjgXYZW6xmdbI"
		// );
		$twitter = new TwitterAPIExchange($settings);
		$response = $twitter->setGetfield($getfield)
		                    ->buildOauth($url, $requestMethod)
		                    ->performRequest();
		// error_log("TWITTSSSSSSSSS");
		// error_log(print_r(json_decode($response),true));

		// $TWITTER_JSON_TIMELINE_URL =
  //   		"http://api.twitter.com/1.1/statuses/user_timeline.rss?screen_name=".$instance['tweetview_username']."&include_rts=true&count=" . $instance['tweetview_no_tweets'];

    	// $doc    = new DOMDocument();
		// if($doc->load($TWITTER_JSON_TIMELINE_URL)) {
		if( $response != null ){
		    // The retrieving logic goes here
		    echo $this->tweetview_output($response);
		}

		if(!empty($title)) {
			echo "<h4><a href='http://twitter.com/".$title."'>" . $title . "</a></h4>";
		}
                echo "</div></li>";
	}

	function tweetview_output($response){
		$html = "";

		foreach (json_decode($response) as $key => $node) {
			# fetch the title from the RSS feed.
			# Note: 'pubDate' and 'link' are also useful
			$tweet 		= $node->{'text'};
			$pubDate	= $node->{'created_at'};
			$link		= "http://twitter.com/".$node->{'user'}->{'screen_name'}."/status/".$node->{'id'};

			// Here you can do various formatting to your results. Have a look at the following two lines.

			// OPTIONAL: the title of each tweet starts with "username: " which I want to keep
			//$tweet = substr($tweet, stripos($tweet, ':') + 1);

			// DateTime conversion
			$pubDate = strtotime($pubDate);

			$html .= "<a href=\"" . $link . "\" target=\"_blank\">" ;
			$html .= "<div class='box'>";
			$html .= $tweet;
			$html .= "</div>";
			$html .= "</a>";

		}

		return $html;
	}

	function tweetview_output_old($args = array(), $position) {
		echo '<script type="text/javascript">var tweetview_username = "' . $args['tweetview_username'] . '"; var tweetview_number_of_tweets = "' . $args['tweetview_no_tweets'] . '";</script>';
		echo '<ul id="tweetview_tweetlist"><li>Carregando os tweets...</li></ul>';
		echo '<ul><li>Siga <a href="http://twitter.com/' . $args['tweetview_username'] . '">@' . $args['tweetview_username'] . '</a> no twitter.</li></ul>';
	}

	function tweetview_head() {

		$array_widgetOptions = get_option('widget_tweetview-widget');

		if(is_array($array_widgetOptions)) {
			foreach((array) $array_widgetOptions as $key => $value) {
				if($value['own-css']) {
					$var_sOwnCSS = $value['own-css'];
					break;
				}
			}
			if(isset($var_sOwnCSS) && $var_sOwnCSS != '') {

				echo "\n" . '<!-- CSS for Tweetview Widget by H.-Peter Pfeufer [http://ppfeufer.de | http://blog.ppfeufer.de] -->' . "\n" . '<style type="text/css">' . "\n" . $var_sOwnCSS . "\n" . '</style>' . "\n" . '<!-- END of CSS for Talos Tweetview Widget -->' . "\n\n";
			}
		}
	}

	/**
	 * Injecting the footer with the javascript
	 *
	 * @since 1.4
	 * @author ppfeufer
	 */
	function tweetview_javascript() {
		if(!is_page() || !is_attachment()) {
			wp_register_script('tweetview-js', plugin_dir_url(__FILE__) . 'js/tweetview-min.js', array(
			// 				wp_register_script('tweetview-js', plugin_dir_url(__FILE__) . 'js/tweetview.js', array(
					'jquery'
			), $this->var_sPluginVersion, true);
			wp_enqueue_script('tweetview-js');
			wp_localize_script('tweetview-js', 'localizing_tweetview_js', array(
					'second' => __('segundo', $this->var_sTextdomain),
					'seconds' => __('segundos', $this->var_sTextdomain),
					'minute' => __('minuto', $this->var_sTextdomain),
					'minutes' => __('minutos', $this->var_sTextdomain),
					'hour' => __('hora', $this->var_sTextdomain),
					'hours' => __('horas', $this->var_sTextdomain),
					'day' => __('dia', $this->var_sTextdomain),
					'days' => __('dias', $this->var_sTextdomain),
					'ago' => __('atras', $this->var_sTextdomain)
			));

			echo '<script type="text/javascript">jQuery(document).ready(function() {if((typeof tweetview_username != \'undefined\') && ( typeof tweetview_number_of_tweets != \'undefined\')) {twitter.load(tweetview_username, tweetview_number_of_tweets)}});</script>';
		} // END if(!is_page() || !is_attachment())
	} // END function tweetview_javascript()


	/**
	 * Helper for cURL
	 *
	 * <[[ NOTE ]]>
	 * We are not using wp_remote_get(); it will not work propper on every system.
	 * So we are using a simple cURL-call here. Make sure your PHP is compiled with cURL.
	 *
	 * @since 1.4
	 * @author ppfeufer
	 *
	 * @param string $var_sUrl
	 * @return mixed
	 */
	private function _helper_curl($var_sUrl = '') {
		if(ini_get('allow_url_fopen')) {
			$cUrl_Data = file_get_contents($var_sUrl);
		} else {
			if(function_exists('curl_init')) {
				$cUrl_Channel = curl_init($var_sUrl);
				curl_setopt($cUrl_Channel, CURLOPT_RETURNTRANSFER, true);
				curl_setopt($cUrl_Channel, CURLOPT_HEADER, 0);

				// EDIT your domain to the next line:
				curl_setopt($cUrl_Channel, CURLOPT_USERAGENT, $this->var_sUserAgent);
				curl_setopt($cUrl_Channel, CURLOPT_TIMEOUT, 10);

				$cUrl_Data = curl_exec($cUrl_Channel);

				if(curl_errno($cUrl_Channel) !== 0 || curl_getinfo($cUrl_Channel, CURLINFO_HTTP_CODE) !== 200) {
					$cUrl_Data === false;
				} // END if(curl_errno($ch) !== 0 || curl_getinfo($ch, CURLINFO_HTTP_CODE) !== 200)

				curl_close($cUrl_Channel);
			}
		}

		return $cUrl_Data;
	} // END private function helper_curl($var_sUrl = '')
}


add_action('widgets_init', create_function('', 'return register_widget("Tweetview_Widget");'));

?>
