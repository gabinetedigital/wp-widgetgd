<?php

class TextoSimplesWidget extends WP_Widget
{
	function TextoSimplesWidget()
	{
		$widget_ops = array('classname' => 'TextoSimplesWidget', 'description' => 'Texto Simples Gabinete Digital.' );
    $widget_controls = array( 'width' => 600 );
		$this->WP_Widget('TextoSimplesWidget', 'Gabinete Digital - Texto Simples', $widget_ops, $widget_controls);
	}

	function form($instance)
	{
		$instance = wp_parse_args( (array) $instance, array( 'titulo' => '', 'colunas' => '3', 'css_class'=>'', 'texto' => '') );
		$titulo = $instance['titulo'];    
		$colunas = $instance['colunas'];		
		$css_class = $instance['css_class'];
    $texto = $instance['texto'];

		?>
  		<p><label for="<?php echo $this->get_field_id('titulo'); ?>">Titulo: <input class="widefat" id="<?php echo $this->get_field_id('titulo'); ?>" name="<?php echo $this->get_field_name('titulo'); ?>" type="text" value="<?php echo attribute_escape($titulo); ?>" /></label></p>
      
      <p><label for="<?php echo $this->get_field_id('texto'); ?>">Texto: <textarea class='widefat' rows="10" id="<?php echo $this->get_field_id('texto'); ?>" name="<?php echo $this->get_field_name('texto'); ?>"><?php echo attribute_escape($texto); ?></textarea></label></p>

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
    $instance['texto'] = $new_instance['texto'];
    return $instance;
  }

  function widget($args, $instance)
  {
    extract($args, EXTR_SKIP);

  	$titulo = empty($instance['titulo']) ? ' ' : apply_filters('widget_title', $instance['titulo']);
    $colunas = $instance['colunas'];    
    $css_class = $instance['css_class'];
    $texto = $instance['texto'];
  	
    $txtreturn = "";
  	$txtreturn .= "<li class='span".$colunas."'>";
  	$txtreturn .= "<div class='texto_simples ".$css_class."'>";
  	$txtreturn .= "<h4>".$titulo."</h4>";
    $txtreturn .= "<h3>".$texto."</h3>";
    $txtreturn .= "</div>";
    $txtreturn .= "</li>";

    echo $txtreturn;
  }

}
add_action( 'widgets_init', create_function('', 'return register_widget("TextoSimplesWidget");') );

?>
