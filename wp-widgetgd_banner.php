<?php

class BannerWidget extends WP_Widget
{
	function BannerWidget()
	{
		$widget_ops = array('classname' => 'BannerWidget', 'description' => 'Banner do Gabinente Digital.' );		
		$this->WP_Widget('BannerWidget', 'Gabinete Digital - Banner', $widget_ops);
	}

	function form($instance)
	{
		$instance = wp_parse_args( (array) $instance, array( 'titulo' => '', 'imagem' => '', 'link'=>'', 'colunas' => '3', 'css_class'=>'' ) );
		$titulo = $instance['titulo'];
		$imagem = $instance['imagem'];
		$link = $instance['link'];
		$colunas = $instance['colunas'];
		$css_class = $instance['css_class'];

		?>
  		<p><label for="<?php echo $this->get_field_id('titulo'); ?>">Titulo: <input class="widefat" id="<?php echo $this->get_field_id('titulo'); ?>" name="<?php echo $this->get_field_name('titulo'); ?>" type="text" value="<?php echo attribute_escape($titulo); ?>" /></label></p>
  		<p><label for="<?php echo $this->get_field_id('imagem'); ?>">Imagem: <input class="widefat" id="<?php echo $this->get_field_id('imagem'); ?>" name="<?php echo $this->get_field_name('imagem'); ?>" type="text" value="<?php echo attribute_escape($imagem); ?>" /></label></p>
  		<p><label for="<?php echo $this->get_field_id('imagem'); ?>">Link: <input class="widefat" id="<?php echo $this->get_field_id('imagem'); ?>" name="<?php echo $this->get_field_name('link'); ?>" type="text" value="<?php echo attribute_escape($link); ?>" /></label></p>
  		<p><label for="<?php echo $this->get_field_id('colunas'); ?>">Colunas: <input class="widefat" id="<?php echo $this->get_field_id('colunas'); ?>" name="<?php echo $this->get_field_name('colunas'); ?>" type="text" value="<?php echo attribute_escape($colunas); ?>" /></label></p>
  		<p><label for="<?php echo $this->get_field_id('css_class'); ?>">Classe CSS: <input class="widefat" id="<?php echo $this->get_field_id('css_class'); ?>" name="<?php echo $this->get_field_name('css_class'); ?>" type="text" value="<?php echo attribute_escape($css_class); ?>" /></label></p>

<?php
  }

  function update($new_instance, $old_instance)
  {
    $instance = $old_instance;
    $instance['titulo'] = $new_instance['titulo'];
    $instance['imagem'] = $new_instance['imagem'];
    $instance['link'] = $new_instance['link'];
    $instance['colunas'] = $new_instance['colunas'];
    $instance['css_class'] = $new_instance['css_class'];
    return $instance;
  }

  function widget($args, $instance)
  {
    extract($args, EXTR_SKIP);
	
	$linke = $instance['link'];
	
	if (!empty($linke)){
		$pos = strpos($linke, "http://");
		$pos1 = strpos(substr($linke, 0,1), "/");
		if ($pos === false && $pos1 === false) {
			$linke = "http://".$linke;
		} 
	}

    echo "<li class='span".$instance['colunas']."'>";
    echo "<div class='thumbnail banner ".$instance['css_class']."'>";
	if(!empty($linke)){
    	echo "	<a href='" . $linke . "'>";
	}
    echo "	<img src='" . $instance['imagem'] . "' width='100%'>";
	if(!empty($linke)){
    	echo "	</a>";
	}
    echo "</div>";
    echo "</li>";
  }

}
add_action( 'widgets_init', create_function('', 'return register_widget("BannerWidget");') );


?>
