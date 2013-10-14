<?php

class VideoDestaqueWidget extends WP_Widget
{
	function VideoDestaqueWidget()
	{
		$widget_ops = array('classname' => 'VideoDestaqueWidget', 'description' => 'Video Destaque Gabinete Digital.' );
    $this->WP_Widget('VideoDestaqueWidget', 'Gabinete Digital - Video Destaque', $widget_ops);
    //$widget_controls = array( 'width' => 600 );
		//$this->WP_Widget('ObrasWidget', 'Gabinete Digital - De Olho nas Obras', $widget_ops, $widget_controls);
    
	}

	function form($instance)
	{
		$instance = wp_parse_args( (array) $instance, array( 'titulo' => '', 'colunas' => '3', 'css_class'=>'', 'qtd_video' => '', 'chk_legenda_externa' => 0) );
		$titulo = $instance['titulo'];    
		$colunas = $instance['colunas'];		
		$css_class = $instance['css_class'];
    $qtd_video = $instance['qtd_video'];
    $chk_legenda_externa = $instance['chk_legenda_externa'];

		?>
  		<p><label for="<?php echo $this->get_field_id('titulo'); ?>">Titulo: <input class="widefat" id="<?php echo $this->get_field_id('titulo'); ?>" name="<?php echo $this->get_field_name('titulo'); ?>" type="text" value="<?php echo attribute_escape($titulo); ?>" /></label></p>
      <p><label for="<?php echo $this->get_field_id('qtd_video'); ?>">Quantidade de Videos: <input class="widefat" id="<?php echo $this->get_field_id('qtd_video'); ?>" name="<?php echo $this->get_field_name('qtd_video'); ?>" type="text" value="<?php echo attribute_escape($qtd_video); ?>" /></label></p>
      <p><input type="checkbox" name="<?php echo $this->get_field_name('chk_legenda_externa'); ?>" id="<?php echo $this->get_field_id('chk_legenda_externa'); ?>" value="1" <?php if ( $chk_legenda_externa ) { echo 'checked="checked"'; } ?> /><label for="<?php echo $this->get_field_id('chk_legenda_externa'); ?>">&nbsp;Legenda Externa </label></p>
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
    $instance['qtd_video'] = $new_instance['qtd_video'];
    $instance['chk_legenda_externa'] = $new_instance['chk_legenda_externa'];
    return $instance;
  }

  function widget($args, $instance)
  {
    extract($args, EXTR_SKIP);

  	$titulo = empty($instance['titulo']) ? ' ' : apply_filters('widget_title', $instance['titulo']);
    $colunas = $instance['colunas'];    
    $css_class = $instance['css_class'];
    $qtd_video = $instance['qtd_video'];
  	
    $txtreturn = "";
  	$txtreturn .= "<li class='span".$colunas."'>";
  	$txtreturn .= "<div class='texto_simples ".$css_class."'>";
  	$txtreturn .= "<h4>".$titulo."</h4>";
    $txtreturn .= "</div>";
    $txtreturn .= "<div class='texto_simples ".$css_class."'>";
    $txtreturn .= "<h3>".$qtd_video."</h3>";
    $txtreturn .= "</div>";
    $txtreturn .= "</li>";

    echo $txtreturn;
  }

}
add_action( 'widgets_init', create_function('', 'return register_widget("VideoDestaqueWidget");') );

?>
