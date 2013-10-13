<?php

class ObrasWidget extends WP_Widget
{
	function ObrasWidget()
	{
		$widget_ops = array('classname' => 'ObrasWidget', 'description' => 'De Olho nas Obras Gabinete Digital.' );
    $this->WP_Widget('ObrasWidget', 'Gabinete Digital - De Olho nas Obras', $widget_ops);
    //$widget_controls = array( 'width' => 600 );
		//$this->WP_Widget('ObrasWidget', 'Gabinete Digital - De Olho nas Obras', $widget_ops, $widget_controls);
    
	}

	function form($instance)
	{
		$instance = wp_parse_args( (array) $instance, array( 'titulo' => '', 'colunas' => '3', 'css_class'=>'', 'id_obras' => '', 'chk_imagem'=> 0, 'chk_titulo'=> 0, 'chk_descricao'=> 0) );
		$titulo = $instance['titulo'];    
		$colunas = $instance['colunas'];		
		$css_class = $instance['css_class'];
    $id_obras = $instance['id_obras'];
    $chk_imagem = $instance['chk_imagem'];
    $chk_titulo = $instance['chk_titulo'];
    $chk_descricao = $instance['chk_descricao'];

		?>
  		<p><label for="<?php echo $this->get_field_id('titulo'); ?>">Título: <input class="widefat" id="<?php echo $this->get_field_id('titulo'); ?>" name="<?php echo $this->get_field_name('titulo'); ?>" type="text" value="<?php echo attribute_escape($titulo); ?>" /></label></p>
      
      <p><label for="<?php echo $this->get_field_id('id_obras'); ?>">ID Obras: <input class="widefat" id="<?php echo $this->get_field_id('id_obras'); ?>" name="<?php echo $this->get_field_name('id_obras'); ?>" type="text" value="<?php echo attribute_escape($id_obras); ?>" /></label></p>

      <p><input type="checkbox" name="<?php echo $this->get_field_name('chk_imagem'); ?>" id="<?php echo $this->get_field_id('chk_imagem'); ?>" value="1" <?php if ( $chk_imagem ) { echo 'checked="checked"'; } ?> /><label for="<?php echo $this->get_field_id('chk_imagem'); ?>">&nbsp;Exibir Imagem </label></p>

      <p><input type="checkbox" name="<?php echo $this->get_field_name('chk_titulo'); ?>" id="<?php echo $this->get_field_id('chk_titulo'); ?>" value="1" <?php if ( $chk_titulo ) { echo 'checked="checked"'; } ?> /><label for="<?php echo $this->get_field_id('chk_titulo'); ?>">&nbsp;Exibir Título </label></p>

      <p><input type="checkbox" name="<?php echo $this->get_field_name('chk_descricao'); ?>" id="<?php echo $this->get_field_id('chk_descricao'); ?>" value="1" <?php if ( $chk_descricao ) { echo 'checked="checked"'; } ?> /><label for="<?php echo $this->get_field_id('chk_descricao'); ?>">&nbsp;Exibir Descrição </label></p>

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
    $instance['id_obras'] = $new_instance['id_obras'];
    $instance['chk_imagem'] = $new_instance['chk_imagem'];
    $instance['chk_titulo'] = $new_instance['chk_titulo'];
    $instance['chk_descricao'] = $new_instance['chk_descricao'];
    return $instance;
  }

  function widget($args, $instance)
  {
    extract($args, EXTR_SKIP);

  	$titulo = empty($instance['titulo']) ? ' ' : apply_filters('widget_title', $instance['titulo']);
    $colunas = $instance['colunas'];    
    $css_class = $instance['css_class'];
    $id_obras = $instance['id_obras'];
    $chk_imagem = $instance['chk_imagem'];
    $imagem_obra = '';
    $chk_titulo = $instance['chk_titulo'];
    $titulo_obra = '';
    $chk_descricao = $instance['chk_descricao'];
    $descricao_obra = '';
    $descricao_completa_obra = '';
  	
    //***************************************************************
    //BUSCAR IMAGEM, TITULO, DESCRICAO CONFORME O ID DA OBRA
    //BUSCAR NOS POSTS
    //***************************************************************
    
    $args_query_post = '';
    $args_query_post = 'p='.$id_obras;
    query_posts($args_query_post);

    if (have_posts()) {
      $titulo_obra = get_the_title();
      $descricao_obra = get_the_excerpt();
      $descricao_completa_obra = get_the_content();
    }
    
    /*
    IMAGEM 

    get_the_post_thumbnail($post_id);                  // without parameter -> Thumbnail

    get_the_post_thumbnail($post_id, 'thumbnail');     // Thumbnail
    get_the_post_thumbnail($post_id, 'medium');        // Medium resolution
    get_the_post_thumbnail($post_id, 'large');         // Large resolution
    get_the_post_thumbnail($post_id, 'full');          // Original resolution

    get_the_post_thumbnail($post_id, array(100,100) ); // Other resolutions

    */

    wp_reset_query();
    //***************************************************************

    $txtreturn = "";
  	$txtreturn .= "<li class='span".$colunas."'>";
    if($chk_titulo){ $txtreturn .= "<div class='titulo_obra'>".$titulo_obra."</div>";}
    if($chk_imagem){ $txtreturn .= "<div class='imagem_obra'>".get_the_post_thumbnail($id_obras, 'thumbnail')."</div>";}
    if($chk_descricao){ $txtreturn .= "<div class='descricao_obra'>".$descricao_obra."</div>";}
    $txtreturn .= "</li>";

    echo $txtreturn;
  }

}
add_action( 'widgets_init', create_function('', 'return register_widget("ObrasWidget");') );

?>
