<?php

class VideoWidget extends WP_Widget
{
	function VideoWidget()
	{
		$widget_ops = array('classname' => 'VideoWidget', 'description' => 'Video Gabinete Digital, id ou url do video.' );
		$this->WP_Widget('VideoWidget', 'Gabinete Digital - Videos', $widget_ops);
	}

	function form($instance)
	{
		$instance = wp_parse_args( (array) $instance, array( 'titulo' => '', 'colunas' => '3', 'id_url' => '' ) );
		$titulo = $instance['titulo'];
		$colunas = $instance['colunas'];
		$id_url = $instance['id_url'];
		$embed = $instance['embed'];
		$css_class = $instance['css_class'];

		?>
  		<p><label for="<?php echo $this->get_field_id('titulo'); ?>">Titulo: <input class="widefat" id="<?php echo $this->get_field_id('titulo'); ?>" name="<?php echo $this->get_field_name('titulo'); ?>" type="text" value="<?php echo attribute_escape($titulo); ?>" /></label></p>
  		<p><label for="<?php echo $this->get_field_id('colunas'); ?>">Colunas: <input class="widefat" id="<?php echo $this->get_field_id('colunas'); ?>" name="<?php echo $this->get_field_name('colunas'); ?>" type="text" value="<?php echo attribute_escape($colunas); ?>" /></label></p>
  		<p><label for="<?php echo $this->get_field_id('id_url'); ?>">ID/URL: <input class="widefat" id="<?php echo $this->get_field_id('id_url'); ?>" name="<?php echo $this->get_field_name('id_url'); ?>" type="text" value="<?php echo attribute_escape($id_url); ?>" /></label></p>
  		<p><label for="<?php echo $this->get_field_id('embed'); ?>">EMBED: <textarea class="widefat" id="<?php echo $this->get_field_id('embed'); ?>" name="<?php echo $this->get_field_name('embed'); ?>"><?php echo attribute_escape($embed); ?></textarea>
  		<p><label for="<?php echo $this->get_field_id('css_class'); ?>">Classe CSS: <input class="widefat" id="<?php echo $this->get_field_id('css_class'); ?>" name="<?php echo $this->get_field_name('css_class'); ?>" type="text" value="<?php echo attribute_escape($css_class); ?>" /></label></p>
<?php
  }

  function update($new_instance, $old_instance)
  {
    $instance = $old_instance;
    $instance['titulo'] = $new_instance['titulo'];
    $instance['colunas'] = $new_instance['colunas'];
    $instance['id_url'] = $new_instance['id_url'];
	$instance['embed'] = $new_instance['embed'];
    $instance['css_class'] = $new_instance['css_class'];
    return $instance;
  }

  function widget($args, $instance)
  {
    extract($args, EXTR_SKIP);
	$txtreturn = '';
	$date    = new DateTime();
	$titulo = empty($instance['titulo']) ? ' ' : apply_filters('widget_title', $instance['titulo']);
    $colunas = $instance['colunas'];
    $id_url  = $instance['id_url'];
	$embed   = $instance['embed'];
    $css_class = $instance['css_class'];
	$idcontainer = $date->getTimestamp() . $id_url;
	$pos = strpos($id_url, "http://");

	$txtreturn .= "<li class='span".$colunas."'>";
	$txtreturn .= "<div class='thumbnail video ".$css_class."'>";
	$txtreturn .= "<h4><a id=\"title-$idcontainer\" href='/videos/".$id_url."'>".$titulo."</a></h4>";

	if(!empty($id_url)){
		if ($pos === false) {
			$video = wpgd_videos_get_video($id_url);
    		$sources = wpgd_videos_get_sources($id_url);

			foreach ( $sources as $s ){
				if( strpos( $s['format'] ,'ogg') > 0 ){
					$url_video_ogg = $s['url'];
			  	}
			  	if( strpos( $s['format'] ,'mp4') > 0 ){
					$url_video_mp4 = $s['url'];
			  	}
			  	if( strpos( $s['format'] ,'webm') > 0 ){
					$url_video_webm = $s['url'];
			  	}
			}


      $txtreturn .= "    <video width=\"320\" height=\"240\" id=\"container$idcontainer\" style=\"width: 100%; height: 100%; max-width: 100%; max-height: 100%\" poster=\"".$video['thumbnail']."\" controls=\"controls\" preload=\"none\">\n";
      $txtreturn .= "      <source type=\"video/mp4\" src=\"".$url_video_mp4."\" />\n";
      $txtreturn .= "      <source type=\"video/webm\" src=\"".$url_video_webm."\" />\n";
      $txtreturn .= "      <object width=\"".$video['video_width']."\" height=\"".$video['video_height']."\" type=\"application/x-shockwave-flash\"\n";
      $txtreturn .= "        data=\"static/me/build/flashmediaelement.swf\">\n";
      $txtreturn .= "        <param name=\"movie\" value=\"static/me/build/flashmediaelement.swf\" /> \n";
      $txtreturn .= "        <param name=\"flashvars\" value=\"controls=true&amp;file=".$url_video_mp4."\" /> \n";
      $txtreturn .= "        <img src=\"".$video['thumbnail']."\" width=\"".$video['video_width']."\" height=\"".$video['video_height']."\" alt=\"Here we are\" \n";
      $txtreturn .= "          title=\"No video playback capabilities\" />\n";
      $txtreturn .= "      </object>\n";
      $txtreturn .= "    </video>\n";
      $txtreturn .= "    <script type=\"text/javascript\">\n";
      $txtreturn .= "      $('#container$idcontainer').mediaelementplayer({\n";
      $txtreturn .= "        enableAutosize: false,\n";
      $txtreturn .= "        enableKeyboard: true,\n";
      $txtreturn .= "        alwaysShowControls: true,\n";
      $txtreturn .= "        success: function(media, node, player) { ; \n";
      $txtreturn .= "           media.addEventListener('play', function(e) {\n";
      $txtreturn .= "             $('#title-$idcontainer').fadeOut();\n";
      $txtreturn .= "           },false);\n";
      $txtreturn .= "           media.addEventListener('pause', function(e) {\n";
      $txtreturn .= "             $('#title-$idcontainer').fadeIn();\n";
      $txtreturn .= "           });\n";
      $txtreturn .= "           media.addEventListener('ended', function(e) {\n";
      $txtreturn .= "             $('#title-$idcontainer').fadeIn();\n";
      $txtreturn .= "           });\n";
      $txtreturn .= "        }\n";
      $txtreturn .= "      });\n";
      $txtreturn .= "    </script>\n";

		} else {
			$txtreturn .= "<iframe src='$id_url' width='100' height='100'</iframe> ";
		}
	} elseif (!empty($embed)) {
		$txtreturn .= $embed;
	}

    /* if (!empty($titulo)) */
    /*   echo "<h4>" . $titulo . "</h4>"; */

	$txtreturn .= "</div>";
    $txtreturn .= "</li>";

	echo $txtreturn;
  }

}
add_action( 'widgets_init', create_function('', 'return register_widget("VideoWidget");') );

?>
