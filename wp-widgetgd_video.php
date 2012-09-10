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
 
    echo $before_widget;
    $titulo = empty($instance['titulo']) ? ' ' : apply_filters('widget_title', $instance['titulo']);
 
    if (!empty($titulo))
      echo $before_title . $titulo . $after_title;
 	
    echo 'COLUNAS: ' . $instance['colunas'];
    echo '<br>';
    echo 'ID URL: ' . $instance['id_url'];
    echo '<br>';
    echo 'CLASSE: ' . $instance['css_class'];
 
 
    echo $after_widget;
  }
 
}
add_action( 'widgets_init', create_function('', 'return register_widget("VideoWidget");') );

/*

class RandomPostWidget extends WP_Widget
{
	function RandomPostWidget()
	{
		$widget_ops = array('classname' => 'RandomPostWidget', 'description' => 'Displays a random post with thumbnail' );
		$this->WP_Widget('RandomPostWidget', 'Random Post and Thumbnail', $widget_ops);
	}

	function form($instance)
	{
		$instance = wp_parse_args( (array) $instance, array( 'title' => '' ) );
		$title = $instance['title'];
		?>
  <p><label for="<?php echo $this->get_field_id('title'); ?>">Title: <input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo attribute_escape($title); ?>" /></label></p>
<?php
  }
 
  function update($new_instance, $old_instance)
  {
    $instance = $old_instance;
    $instance['title'] = $new_instance['title'];
    return $instance;
  }
 
  function widget($args, $instance)
  {
    extract($args, EXTR_SKIP);
 
    echo $before_widget;
    $title = empty($instance['title']) ? ' ' : apply_filters('widget_title', $instance['title']);
 
    if (!empty($title))
      echo $before_title . $title . $after_title;;
 
   query_posts('');
	if (have_posts()) : 
		echo "<ul>";
		while (have_posts()) : the_post(); 
			echo "<li><a href='".get_permalink()."'>".get_the_title()."</a></li>";
	 
		endwhile;
		echo "</ul>";
	endif; 
	wp_reset_query();
 
    echo $after_widget;
  }
 
}
add_action( 'widgets_init', create_function('', 'return register_widget("RandomPostWidget");') );?>
*/

?>