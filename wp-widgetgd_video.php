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

    echo "<li class='span".$instance['colunas']."'>";
    echo "<div class='thumbnail video ".$instance['css_class']."'>";

    $titulo = empty($instance['titulo']) ? ' ' : apply_filters('widget_title', $instance['titulo']);

    $video = wpgd_videos_get_video($instance['id_url']);

    echo "<img src='" . $video['thumbnail'] . "' width='100%' title='".$video['title']."'>";

    if (!empty($titulo))
      echo "<h4>" . $titulo . "</h4>";


    echo "</div>";
    echo "</li>";
  }

}
add_action( 'widgets_init', create_function('', 'return register_widget("VideoWidget");') );

?>
