<?php

class FotoWidget extends WP_Widget
{
	function FotoWidget()
	{
		$widget_ops = array('classname' => 'FotoWidget', 'description' => 'Foto do dia, conforme a galeria escolhida' );
		$this->WP_Widget('FotoWidget', 'Gabinete Digital - Foto do dia', $widget_ops);
	}

	function form($instance)
	{
		$instance = wp_parse_args( (array) $instance, array( 'titulo'=> '', 'id_galeria' => '', 'chk_rand' => 0, 'colunas' => '3', 'css_class' => '' ) );
		$titulo = $instance['titulo'];
		$id_galeria = $instance['id_galeria'];
		$chk_rand = $instance['chk_rand'];
		$colunas = $instance['colunas'];
		$css_class = $instance['css_class'];
		
		?>
		
		<p><label for="<?php echo $this->get_field_id('titulo'); ?>">Titulo: <input class="widefat" id="<?php echo $this->get_field_id('titulo'); ?>" name="<?php echo $this->get_field_name('titulo'); ?>" type="text" value="<?php echo attribute_escape($titulo); ?>" /></label></p>
  		<p><label for="<?php echo $this->get_field_id('id_galeria'); ?>">ID Galeria: <input class="widefat" id="<?php echo $this->get_field_id('id_galeria'); ?>" name="<?php echo $this->get_field_name('id_galeria'); ?>" type="text" value="<?php echo attribute_escape($id_galeria); ?>" /></label></p>
  		<p><label for="<?php echo $this->get_field_id('chk_rand'); ?>"><input type="checkbox" name="<?php echo $this->get_field_name('chk_rand'); ?>" id="<?php echo $this->get_field_id('chk_rand'); ?>" value="1" <?php if ( $chk_rand ) { echo 'checked="checked"'; } ?> /> Foto randomica</label></p>
  		<p><label for="<?php echo $this->get_field_id('colunas'); ?>">Colunas: <input class="widefat" id="<?php echo $this->get_field_id('colunas'); ?>" name="<?php echo $this->get_field_name('colunas'); ?>" type="text" value="<?php echo attribute_escape($colunas); ?>" /></label></p>
  		<p><label for="<?php echo $this->get_field_id('css_class'); ?>">Classe CSS: <input class="widefat" id="<?php echo $this->get_field_id('css_class'); ?>" name="<?php echo $this->get_field_name('css_class'); ?>" type="text" value="<?php echo attribute_escape($css_class); ?>" /></label></p>
<?php
  }
 
  function update($new_instance, $old_instance)
  {
    $instance = $old_instance;
    $instance['titulo'] = $new_instance['titulo'];
    $instance['id_galeria'] = $new_instance['id_galeria'];
    $instance['chk_rand'] = $new_instance['chk_rand'];
    $instance['colunas'] = $new_instance['colunas'];
    $instance['css_class'] = $new_instance['css_class'];
    return $instance;
  }
 
  function widget($args, $instance)
  {
    extract($args, EXTR_SKIP);
    
    echo $before_widget;
    $titulo = empty($instance['titulo']) ? ' ' : apply_filters('widget_title', $instance['titulo']);
    
    echo $before_title . $titulo . $after_title;;
    
    echo 'GALERIA: ' . $instance['id_galeria'];
    echo '<br>';
    echo 'COLUNAS: ' . $instance['colunas'];
    echo '<br>';
    echo 'CLASSE : ' . $instance['css_class'];
 
    echo $after_widget;
  }
 
}
add_action( 'widgets_init', create_function('', 'return register_widget("FotoWidget");') );

?>