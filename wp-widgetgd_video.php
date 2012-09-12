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
		$css_class = $instance['css_class'];

		?>
  		<p><label for="<?php echo $this->get_field_id('titulo'); ?>">Titulo: <input class="widefat" id="<?php echo $this->get_field_id('titulo'); ?>" name="<?php echo $this->get_field_name('titulo'); ?>" type="text" value="<?php echo attribute_escape($titulo); ?>" /></label></p>
  		<p><label for="<?php echo $this->get_field_id('colunas'); ?>">Colunas: <input class="widefat" id="<?php echo $this->get_field_id('colunas'); ?>" name="<?php echo $this->get_field_name('colunas'); ?>" type="text" value="<?php echo attribute_escape($colunas); ?>" /></label></p>
  		<p><label for="<?php echo $this->get_field_id('id_url'); ?>">ID/URL: <input class="widefat" id="<?php echo $this->get_field_id('id_url'); ?>" name="<?php echo $this->get_field_name('id_url'); ?>" type="text" value="<?php echo attribute_escape($id_url); ?>" /></label></p>
  		<p><label for="<?php echo $this->get_field_id('css_class'); ?>">Classe CSS: <input class="widefat" id="<?php echo $this->get_field_id('css_class'); ?>" name="<?php echo $this->get_field_name('css_class'); ?>" type="text" value="<?php echo attribute_escape($css_class); ?>" /></label></p>
<?php
  }

  function update($new_instance, $old_instance)
  {
    $instance = $old_instance;
    $instance['titulo'] = $new_instance['titulo'];
    $instance['colunas'] = $new_instance['colunas'];
    $instance['id_url'] = $new_instance['id_url'];
    $instance['css_class'] = $new_instance['css_class'];
    return $instance;
  }

  function widget($args, $instance)
  {
    extract($args, EXTR_SKIP);

    $date = new DateTime();
    $idcontainer = $date->getTimestamp() . $instance['id_url'];

    echo "<li class='vvv span".$instance['colunas']."'>";
    echo "<div class='thumbnail video ".$instance['css_class']."'>";

    $titulo = empty($instance['titulo']) ? ' ' : apply_filters('widget_title', $instance['titulo']);

    $video = wpgd_videos_get_video($instance['id_url']);
    $sources = wpgd_videos_get_sources($instance['id_url']);

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

    echo "<video";
    //echo " src=\"".$url_video_ogg."\"";
    echo " height=\"".$video['video_height']."\"";
    echo " id=\"container".$idcontainer."\"";
    echo " poster=\"".$video['thumbnail']."\"";
    echo " width=\"".$video['video_width']."\">";

    echo "<source src=\"".$url_video_ogg."\" type=\"video/ogg\" />";
    echo "<source src=\"".$url_video_mp4."\" type=\"video/mp4\" />";
    echo "<source src=\"".$url_video_webm."\" type=\"video/webm\" />";
    echo "Your browser does not support the video tag.";

    echo "</video>";

    $jscript  = "<script type=\"text/javascript\">";
    $jscript .= "jwplayer(\"container".$idcontainer."\").setup({";
    $jscript .= "  skin: \"/static/jw/whotube/whotube.xml\",";
    $jscript .= "  width: '98%',";
    $jscript .= "  modes: [";
    $jscript .= "    { type: \"html5\" },";
    $jscript .= "    { type: \"flash\", src: \"//static/jw/player.swf\" },";
    $jscript .= "    { type: \"download\" }";
    $jscript .= "  ]";
    $jscript .= "});";
    $jscript .= "</script>";

    echo $jscript;

    // echo print_r($sources[0]['url'], true);
    //echo print_r($video, true);
    if (!empty($titulo))
      echo "<h4>" . $titulo . "</h4>";


    echo "</div>";
    echo "</li>";
  }

}
add_action( 'widgets_init', create_function('', 'return register_widget("VideoWidget");') );

?>
