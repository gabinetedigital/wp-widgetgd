<?php

class ObrasWidget extends WP_Widget
{
	function ObrasWidget()
	{
		$widget_ops = array('classname' => 'ObrasWidget', 'description' => 'De Olho nas Obras Gabinete Digital.' );
    $this->WP_Widget('ObrasWidget', 'Gabinete Digital - De Olho nas Obras', $widget_ops);
    
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
		
		wp_reset_query();
		query_posts( array( 'post_type' => 'gdobra',
							'post_status' => 'publish', 
							'post_parent' => '0', 
							'orderby' => 'title', 
							'order' => 'ASC' ) );
		
		$id_obras_selec = attribute_escape($id_obras);

		?>
  		<p><label for="<?php echo $this->get_field_id('titulo'); ?>">Título: <input class="widefat" id="<?php echo $this->get_field_id('titulo'); ?>" name="<?php echo $this->get_field_name('titulo'); ?>" type="text" value="<?php echo attribute_escape($titulo); ?>" /></label></p>
      
      	<p>
      		<label for="<?php echo $this->get_field_id('id_obras'); ?>">ID Obras:
				<select name="<?php echo $this->get_field_name('id_obras'); ?>" id="<?php echo $this->get_field_id('id_obras'); ?>" class="widefat">
  					<option value="">Selecione uma Obra</option>id_obras
  					<?php
  						if (have_posts()) {
  							while ( have_posts() ) {
	  							the_post();
  								if ($id_obras_selec == get_the_ID())
  									echo "<option value='".get_the_ID()."' selected=selected>".get_the_title()."</option>";
								else
									echo "<option value='".get_the_ID()."'>".get_the_title()."</option>";
							}
						}
						wp_reset_query();
					?>
				</select>
			</label>
      	
      </p>

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
	wp_reset_query();
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
    query_posts( array( 'post' => $id_obras ) );

    if (have_posts()) {
    	the_post();
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
