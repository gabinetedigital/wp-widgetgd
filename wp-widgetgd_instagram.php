<?php

class InstagramWidget extends WP_Widget
{
	function InstagramWidget()
	{
		$widget_ops = array('classname' => 'InstagramWidget', 'description' => 'Instagram Gabinete Digital.' );
    $this->WP_Widget('InstagramWidget', 'Gabinete Digital - Instagram', $widget_ops);
    //$widget_controls = array( 'width' => 600 );
		//$this->WP_Widget('ObrasWidget', 'Gabinete Digital - De Olho nas Obras', $widget_ops, $widget_controls);
    
	}

	function form($instance)
	{
		$instance = wp_parse_args( (array) $instance, array( 'titulo' => '', 'colunas' => '3', 'css_class'=>'', 'id_client' => '') );
		$titulo = $instance['titulo'];    
		$colunas = $instance['colunas'];		
		$css_class = $instance['css_class'];
    $id_client = $instance['id_client'];

		?>
  		<p><label for="<?php echo $this->get_field_id('titulo'); ?>">Titulo: <input class="widefat" id="<?php echo $this->get_field_id('titulo'); ?>" name="<?php echo $this->get_field_name('titulo'); ?>" type="text" value="<?php echo attribute_escape($titulo); ?>" /></label></p>
      
      <p><label for="<?php echo $this->get_field_id('id_client'); ?>">ID Client: <input class="widefat" id="<?php echo $this->get_field_id('id_client'); ?>" name="<?php echo $this->get_field_name('id_client'); ?>" type="text" value="<?php echo attribute_escape($id_client); ?>" /></label></p>

      <p><label for="<?php echo $this->get_field_id('colunas'); ?>">Colunas: <input class="widefat" id="<?php echo $this->get_field_id('colunas'); ?>" name="<?php echo $this->get_field_name('colunas'); ?>" type="text" value="<?php echo attribute_escape($colunas); ?>" /></label></p>
  		<p><label for="<?php echo $this->get_field_id('css_class'); ?>">Classe CSS: <input class="widefat" id="<?php echo $this->get_field_id('css_class'); ?>" name="<?php echo $this->get_field_name('css_class'); ?>" type="text" value="<?php echo attribute_escape($css_class); ?>" /></label></p>
<?php
  }

  function update($new_instance, $old_instance)
  {
    $instance = $old_instance;
    $instance['titulo'] = $new_instance['titulo'];    
    $instance['colunas'] = $new_instance['colunas'];    
    $instance['css_class'] = $new_instance['css_class'];
    $instance['id_client'] = $new_instance['id_client'];
    return $instance;
  }

  function widget($args, $instance)
  {
    extract($args, EXTR_SKIP);

  	$titulo = empty($instance['titulo']) ? ' ' : apply_filters('widget_title', $instance['titulo']);
    $colunas = $instance['colunas'];    
    $css_class = $instance['css_class'];
    $id_obras = $instance['id_client'];
  	
    $txtreturn = "";
  	$txtreturn .= "<li class='span".$colunas."'>";
  	$txtreturn .= "<div class='texto_simples ".$css_class."'>";
  	$txtreturn .= "<h4>".$titulo."</h4>";
    $txtreturn .= "</div>";
    $txtreturn .= "<div class='texto_simples ".$css_class."'>";
    $txtreturn .= "<h3>".$id_client."</h3>";
    $txtreturn .= "</div>";
    $txtreturn .= "</li>";

    echo $txtreturn;
  }

}
add_action( 'widgets_init', create_function('', 'return register_widget("InstagramWidget");') );

?>
