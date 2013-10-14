<?php

class FacebookGD extends WP_Widget
{
  function FacebookGD()
  {
    $widget_ops = array('classname' => 'FacebookGD', 'description' => 'Widgdet do Facebook para o Gabinete Digital' );
    $this->WP_Widget('FacebookGD', 'Gabinete Digital - Facebook', $widget_ops);
  }

  function form($instance)
  {
    $instance = wp_parse_args( (array) $instance, array( 'titulo' => '', 'fanpage' => '', 'largura' => '', 'altura' => '', 'cor' => '#ffffff', 'faces' => 0, 'header' => 0, 'border' => 0, 'posts' => 0, 'colunas' => '3', 'css_class'=>'' ) );
    $titulo = $instance['titulo'];    
    $fanpage = $instance['fanpage'];
    $largura = $instance['largura'];
    $altura = $instance['altura'];
    $cor = $instance['cor'];
    $faces = $instance['faces'];
    $header = $instance['header'];
    $border = $instance['border'];
    $posts = $instance['posts'];
    $colunas = $instance['colunas'];
    $css_class = $instance['css_class'];

    ?>
      <p><label for="<?php echo $this->get_field_id('titulo'); ?>">Titulo: <input class="widefat" id="<?php echo $this->get_field_id('titulo'); ?>" name="<?php echo $this->get_field_name('titulo'); ?>" type="text" value="<?php echo attribute_escape($titulo); ?>" /></label></p>
      
      <p><label for="<?php echo $this->get_field_id('fanpage'); ?>">Fanpage: <input class="widefat" id="<?php echo $this->get_field_id('fanpage'); ?>" name="<?php echo $this->get_field_name('fanpage'); ?>" type="text" value="<?php echo attribute_escape($fanpage); ?>" /></label></p>

      <p><label for="<?php echo $this->get_field_id('largura'); ?>">Largura do LikeBox: <input class="widefat" id="<?php echo $this->get_field_id('largura'); ?>" name="<?php echo $this->get_field_name('largura'); ?>" type="text" value="<?php echo attribute_escape($largura); ?>"/></label>em branco = default</p>

      <p><label for="<?php echo $this->get_field_id('altura'); ?>">Altura do LikeBox: <input class="widefat" id="<?php echo $this->get_field_id('altura'); ?>" name="<?php echo $this->get_field_name('altura'); ?>" type="text" value="<?php echo attribute_escape($altura); ?>"/></label>em branco = default</p>

      <p><label for="<?php echo $this->get_field_id('cor'); ?>">Cor do LikeBox: <input class="widefat" id="<?php echo $this->get_field_id('cor'); ?>" name="<?php echo $this->get_field_name('cor'); ?>" type="text" value="<?php echo attribute_escape($cor); ?>"/></label>Colocar hexadecimal. Ex: #ffffff</p>

      <p><input type="checkbox" name="<?php echo $this->get_field_name('faces'); ?>" id="<?php echo $this->get_field_id('faces'); ?>" value="1" <?php if ( $faces ) { echo 'checked="checked"'; } ?> /><label for="<?php echo $this->get_field_id('faces'); ?>">&nbsp;Friend Faces</label></p>

      <p><input type="checkbox" name="<?php echo $this->get_field_name('header'); ?>" id="<?php echo $this->get_field_id('header'); ?>" value="1" <?php if ( $header ) { echo 'checked="checked"'; } ?> /><label for="<?php echo $this->get_field_id('header'); ?>">&nbsp;Header</label></p>

      <p><input type="checkbox" name="<?php echo $this->get_field_name('border'); ?>" id="<?php echo $this->get_field_id('border'); ?>" value="1" <?php if ( $border ) { echo 'checked="checked"'; } ?> /><label for="<?php echo $this->get_field_id('border'); ?>">&nbsp;Border</label></p>

      <p><input type="checkbox" name="<?php echo $this->get_field_name('posts'); ?>" id="<?php echo $this->get_field_id('posts'); ?>" value="1" <?php if ( $posts ) { echo 'checked="checked"'; } ?> /><label for="<?php echo $this->get_field_id('posts'); ?>">&nbsp;Posts</label></p>    

      <p><label for="<?php echo $this->get_field_id('colunas'); ?>">Colunas: <input class="widefat" id="<?php echo $this->get_field_id('colunas'); ?>" name="<?php echo $this->get_field_name('colunas'); ?>" type="text" value="<?php echo attribute_escape($colunas); ?>" /></label></p>
      <p><label for="<?php echo $this->get_field_id('css_class'); ?>">Classe CSS: <input class="widefat" id="<?php echo $this->get_field_id('css_class'); ?>" name="<?php echo $this->get_field_name('css_class'); ?>" type="text" value="<?php echo attribute_escape($css_class); ?>" /></label></p>
<?php
  }

  function update($new_instance, $old_instance)
  {
    $instance = $old_instance;
    $instance['titulo'] = $new_instance['titulo'];    
    $instance['fanpage'] = $new_instance['fanpage'];
    $instance['largura'] = $new_instance['largura'];
    $instance['altura'] = $new_instance['altura'];
    $instance['cor'] = $new_instance['cor'];
    $instance['faces'] = $new_instance['faces'];
    $instance['header'] = $new_instance['header'];
    $instance['border'] = $new_instance['border'];
    $instance['posts'] = $new_instance['posts'];
    $instance['colunas'] = $new_instance['colunas'];
    $instance['css_class'] = $new_instance['css_class'];
    return $instance;
  }

  function widget($args, $instance)
  {
    extract($args, EXTR_SKIP);
    $txtreturn = '';
    
    $titulo = empty($instance['titulo']) ? ' ' : apply_filters('widget_title', $instance['titulo']);
    $fanpage = $instance['fanpage'];
    $largura = $instance['largura'];
    $altura = $instance['altura'];
    $cor = $instance['cor'];
    $faces = $instance['faces'];
    $header = $instance['header'];
    $border = $instance['border'];
    $posts = $instance['posts'];
    $colunas = $instance['colunas'];
    $css_class = $instance['css_class'];    

	if (!$largura)
		if($instance['colunas'] == 1) 
			$largura = 70;
		else
			$largura = 70+($instance['colunas']*100);
			
	$txtreturn = "";
	$txtreturn .= "<li class='span".$instance['colunas']."'>";
    $txtreturn .= '<div id="fb-root"></div><script>(function(d, s, id) {var js, fjs = d.getElementsByTagName(s)[0]; if (d.getElementById(id)) return; js = d.createElement(s); js.id = id; js.src = "//connect.facebook.net/pt_BR/all.js#xfbml=1"; fjs.parentNode.insertBefore(js, fjs);}(document, \'script\', \'facebook-jssdk\'));</script>';
    $txtreturn .= '<div class="fb-like-box" ';
    $txtreturn .= ' data-href="https://www.facebook.com/'.$fanpage.'"';
    if($largura != ''){$txtreturn .= ' data-width="'.$largura.'"';}
    if($altura != ''){$txtreturn .= ' data-height="'.$altura.'"';}
    //$txtreturn .= ' data-colorscheme="'.$cor.'"';
    if($faces){$txtreturn .= ' data-show-faces="true"';}    else{$txtreturn .= ' data-show-faces="false"';}
    if($header){$txtreturn .= ' data-header="true"';}       else{$txtreturn .= ' data-header="false"';}
    if($posts){$txtreturn .= ' data-stream="true"';}        else{$txtreturn .= ' data-stream="false"';}
    if($border){$txtreturn .= ' data-show-border="true"';}  else{$txtreturn .= ' data-show-border="false"';}
    $txtreturn .= '></div>';
	$txtreturn .= '<style> .fb_iframe_widget {background-color:'.$cor.';}</style>';
	$txtreturn .= "</li>";
	
    echo $txtreturn;    

  }

}
add_action( 'widgets_init', create_function('', 'return register_widget("FacebookGD");') );

?>
