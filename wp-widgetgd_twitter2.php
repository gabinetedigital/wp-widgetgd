<?php

class TwitterGD extends WP_Widget
{
  function TwitterGD()
  {
    $widget_ops = array('classname' => 'TwitterGD', 'description' => 'Widgdet do Twitter para o Gabinete Digital' );
    $this->WP_Widget('TwitterGD', 'Gabinete Digital - Twitter', $widget_ops);
  }

  function form($instance)
  {
    $instance = wp_parse_args( (array) $instance, array( 'titulo' => '', 'widget_id' => '', 'twitter_user' => '', 'colunas' => '3', 'css_class'=>'' ) );
    $titulo = $instance['titulo'];    
    $widget_id = $instance['widget_id'];
    $twitter_user = $instance['twitter_user'];
    $colunas = $instance['colunas'];
    $css_class = $instance['css_class'];

    ?>
      <p><label for="<?php echo $this->get_field_id('titulo'); ?>">Titulo: <input class="widefat" id="<?php echo $this->get_field_id('titulo'); ?>" name="<?php echo $this->get_field_name('titulo'); ?>" type="text" value="<?php echo attribute_escape($titulo); ?>" /></label></p>
      
      <p><label for="<?php echo $this->get_field_id('widget_id'); ?>">ID Widget: <input class="widefat" id="<?php echo $this->get_field_id('widget_id'); ?>" name="<?php echo $this->get_field_name('widget_id'); ?>" type="text" value="<?php echo attribute_escape($widget_id); ?>" /></label></p>
      <p><label for="<?php echo $this->get_field_id('twitter_user'); ?>">Twitter User: <input class="widefat" id="<?php echo $this->get_field_id('twitter_user'); ?>" name="<?php echo $this->get_field_name('twitter_user'); ?>" type="text" value="<?php echo attribute_escape($twitter_user); ?>"/></label></p>
      <p><label for="<?php echo $this->get_field_id('colunas'); ?>">Colunas: <input class="widefat" id="<?php echo $this->get_field_id('colunas'); ?>" name="<?php echo $this->get_field_name('colunas'); ?>" type="text" value="<?php echo attribute_escape($colunas); ?>" /></label></p>
      <p><label for="<?php echo $this->get_field_id('css_class'); ?>">Classe CSS: <input class="widefat" id="<?php echo $this->get_field_id('css_class'); ?>" name="<?php echo $this->get_field_name('css_class'); ?>" type="text" value="<?php echo attribute_escape($css_class); ?>" /></label></p>
<?php
  }

  function update($new_instance, $old_instance)
  {
    $instance = $old_instance;
    $instance['titulo'] = $new_instance['titulo'];    
    $instance['widget_id'] = $new_instance['widget_id'];
    $instance['twitter_user'] = $new_instance['twitter_user'];
    $instance['colunas'] = $new_instance['colunas'];
    $instance['css_class'] = $new_instance['css_class'];
    return $instance;
  }

  function widget($args, $instance)
  {
    extract($args, EXTR_SKIP);
    $txtreturn = '';
    
    $titulo = empty($instance['titulo']) ? ' ' : apply_filters('widget_title', $instance['titulo']);    
    $widget_id  = $instance['widget_id'];
    $twitter_user   = $instance['twitter_user'];
    $colunas = $instance['colunas'];
    $css_class = $instance['css_class'];    
	
	$txtreturn = '';
	$txtreturn .= "<li class='span".$instance['colunas']."'>";
	$txtreturn .= "<div class='".$css_class."'>";
    $txtreturn .= '<a class="twitter-timeline"  href="https://twitter.com/' . $twitter_user.'"  data-widget-id="'.$widget_id.'">Tweets de @'.$twitter_user.'</a>';
    $txtreturn .= '<script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0],p=/^http:/.test(d.location)?\'http\':\'https\';if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src=p+"://platform.twitter.com/widgets.js";fjs.parentNode.insertBefore(js,fjs);}}(document,"script","twitter-wjs");</script>';
	$txtreturn .= "</div>";
	$txtreturn .= "</li>";
	
    echo $txtreturn;    

  }

}
add_action( 'widgets_init', create_function('', 'return register_widget("TwitterGD");') );

?>
