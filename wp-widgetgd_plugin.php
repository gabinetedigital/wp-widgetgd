<?php
/*
Plugin Name: Widget Gabinete Digital
Plugin URI: http://www.gabinetedigital.rs.gov.br
Description: Plugin para os widgets utilizados na capa do site do Gabinete Digital.
Version: 1.0.5
Author: Cristiane | Felipe | Leo 
Author URI: http://www.procergs.rs.gov.br
*/

/*  Copyright 2012

This program is free software; you can redistribute it and/or modify
it under the terms of the GNU General Public License, version 2, as
published by the Free Software Foundation.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with this program; if not, write to the Free Software
Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
*/

include_once('wp-widgetgd_noticias.php');
include_once('wp-widgetgd_noticiacompleta.php');
include_once('wp-widgetgd_fotodia.php');
include_once('wp-widgetgd_feed.php');
include_once('wp-widgetgd_twitter.php');
include_once('wp-widgetgd_video.php');
include_once('wp-widgetgd_banner.php');

add_action( 'admin_menu', 'wp_widgetgd_options_menu' );
//call register settings function
add_action( 'admin_init', 'register_mysettings' );

function wp_widgetgd_options_menu() {
  add_options_page( 'WP-WidgetGD Options', 'WP-WidgetGD', 'manage_options', 'wp-widgetsgd', 'wp_widgetgd_options' );
}

function register_mysettings() {
  //register our settings
  register_setting( 'wp-widgets-options-group', 'thumbor_url' );
  register_setting( 'wp-widgets-options-group', 'thumbor_skey' );
}

function wp_widgetgd_options() {
  if ( !current_user_can( 'manage_options' ) )  {
    wp_die( __( 'You do not have sufficient permissions to access this page.' ) );
  }
?>

	<div class="wrap">
	<h2>WP-Widget GD Options</h2>
	<p>Configurações disponíveis para o plugin WP Widget do Gabinete Digital. Altere conforme sua necessidade e clique em 'Salvar alterações'.</p>

	<form method="post" action="options.php">
	    <?php settings_fields( 'wp-widgets-options-group' ); ?>
	    <?php do_settings_fields( 'wp-widgets-options-group' ); ?>
	    <table class="form-table">
	        <tr valign="top">
	        	<th scope="row">Thumbor Url</th>
	        	<td><input type="text" name="thumbor_url" value="<?php echo get_option('thumbor_url'); ?>" style="width:500px;" /></td>
	        </tr>
	        <tr valign="top">
	        	<th scope="row">Thumbor Secret Key</th>
	        	<td><input type="text" name="thumbor_skey" value="<?php echo get_option('thumbor_skey'); ?>" style="width:500px;" /></td>
	        </tr>
	    </table>

	    <?php submit_button(); ?>

	</form>
	</div>

<?php } ?>
