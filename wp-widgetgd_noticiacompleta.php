<?php

include_once('wp-widgetgd_func.php');

class NoticiaCompletaWidget extends WP_Widget
{
	function NoticiaCompletaWidget()
	{
		$widget_ops = array('classname' => 'NoticiaCompletaWidget', 'description' => 'Noticia do Gabinente Digital, apenas o post da noticia em questao.' );
		$control_ops = array( 'width' => 700, 'height' => 580 );
		$this->WP_Widget('NoticiaCompletaWidget', 'Gabinete Digital - Noticia Única', $widget_ops);
	}

	function form($instance)
	{
		$instance = wp_parse_args( (array) $instance, array( 'titulo' => '', 'id_post' => '', 'imagem' => '', 'legenda' => '', 'thumborsize' => '', 'chk_legenda' => 0, 'colunas' => '3', 'css_class'=>'' ) );
		$titulo = $instance['titulo'];
		$id_post = $instance['id_post'];
		$imagem = $instance['imagem'];
    $legenda = $instance['legenda'];
		$thumborsize = $instance['thumborsize'];
		$chk_legenda = $instance['chk_legenda'];
		$colunas = $instance['colunas'];
		$css_class = $instance['css_class'];

		?>
  		<p><label for="<?php echo $this->get_field_id('titulo'); ?>">Titulo: <input class="widefat" id="<?php echo $this->get_field_id('titulo'); ?>" name="<?php echo $this->get_field_name('titulo'); ?>" type="text" value="<?php echo attribute_escape($titulo); ?>" /></label></p>
  		<p><label for="<?php echo $this->get_field_id('id_post'); ?>">Post ID: <input class="widefat" id="<?php echo $this->get_field_id('id_post'); ?>" name="<?php echo $this->get_field_name('id_post'); ?>" type="text" value="<?php echo attribute_escape($id_post); ?>" /></label></p>
  		<p><label for="<?php echo $this->get_field_id('imagem'); ?>">Imagem: <input class="widefat" id="<?php echo $this->get_field_id('imagem'); ?>" name="<?php echo $this->get_field_name('imagem'); ?>" type="text" value="<?php echo attribute_escape($imagem); ?>" /></label></p>
  		<p><label for="<?php echo $this->get_field_id('thumborsize'); ?>">Thumbor Size (WxH): <input class="widefat" id="<?php echo $this->get_field_id('thumborsize'); ?>" name="<?php echo $this->get_field_name('thumborsize'); ?>" type="text" value="<?php echo attribute_escape($thumborsize); ?>" /></label></p>
      <p><label for="<?php echo $this->get_field_id('legenda'); ?>">Legenda: <input class="widefat" id="<?php echo $this->get_field_id('legenda'); ?>" name="<?php echo $this->get_field_name('legenda'); ?>" type="text" value="<?php echo attribute_escape($legenda); ?>" /></label></p>
  		<p><label for="<?php echo $this->get_field_id('chk_legenda'); ?>">Legenda excerpt <input type="checkbox" name="<?php echo $this->get_field_name('chk_legenda'); ?>" id="<?php echo $this->get_field_id('chk_legenda'); ?>" value="1" <?php if ( $chk_legenda ) { echo 'checked="checked"'; } ?> /></label></p>
  		<p><label for="<?php echo $this->get_field_id('colunas'); ?>">Colunas: <input class="widefat" id="<?php echo $this->get_field_id('colunas'); ?>" name="<?php echo $this->get_field_name('colunas'); ?>" type="text" value="<?php echo attribute_escape($colunas); ?>" /></label></p>
  		<p><label for="<?php echo $this->get_field_id('css_class'); ?>">Classe CSS: <input class="widefat" id="<?php echo $this->get_field_id('css_class'); ?>" name="<?php echo $this->get_field_name('css_class'); ?>" type="text" value="<?php echo attribute_escape($css_class); ?>" /></label></p>

<?php
  }

  function update($new_instance, $old_instance)
  {
    $instance = $old_instance;
    $instance['titulo'] = $new_instance['titulo'];
    $instance['id_post'] = $new_instance['id_post'];
    $instance['imagem'] = $new_instance['imagem'];
    $instance['thumborsize'] = $new_instance['thumborsize'];
    $instance['legenda'] = $new_instance['legenda'];
    $instance['chk_legenda'] = $new_instance['chk_legenda'];
    $instance['colunas'] = $new_instance['colunas'];
    $instance['css_class'] = $new_instance['css_class'];
    return $instance;
  }

  function widget($args, $instance)
  {
    extract($args, EXTR_SKIP);

    echo "<li class='span".$instance['colunas']."'>";
    $query = 'p=' . $instance['id_post'];
    $queryObject = new WP_Query($query);

    if ($queryObject->have_posts()) {
    	$queryObject->the_post();
      echo "<a href=\"" . get_permalink() . "\">";
      $idd = str_replace(' ','',str_replace('.','',microtime()));
      echo "<div id=\"".$idd."\" class='thumbnail news1 ".$instance['css_class']."'>";
	  if(!empty($instance['imagem'])){
        if( !empty($instance['thumborsize']) ){
          echo "<img src='" . thumbor($instance['imagem'], $instance['thumborsize']) . "' data-image=\"".str_replace('http://','',$instance['imagem'])."\" alt='". $instance['legenda'] ."'>";
        }else{
          echo "<img src='" . $instance['imagem'] . "' data-image=\"".str_replace('http://','',$instance['imagem'])."\" alt='". $instance['legenda'] ."'>";
        }
        
	  } else {
            if ( has_post_thumbnail() ) {
  			echo the_post_thumbnail('src=$src');
		}
	  }
      if ($instance['chk_legenda'])
        echo '<h4>' . get_the_excerpt() . '</a></h4>';
      else
        echo "<h4>" . $instance['legenda'] . "</h4>";
      echo "</div>";
      echo "</a>";

    }
    echo "</li>";
  }

}
add_action( 'widgets_init', create_function('', 'return register_widget("NoticiaCompletaWidget");') );

?>
