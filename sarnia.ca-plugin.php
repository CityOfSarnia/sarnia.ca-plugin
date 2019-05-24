<?php
/*Plugin Name: Sarnia.ca Plugin
* Description: This plugin contains the functionality code required for the sarnia.ca website
* Version: 0.2
* Author: City of Sarnia
* Author URI: http://sarnia.ca
*/

define( 'SARNIA_PLUGIN_PATH', plugin_dir_path( __FILE__ ) );

add_filter( 'gform_field_value_refurl', 'populate_referral_url');
 
function populate_referral_url( $form ){
    // Grab URL from HTTP Server Var and put it into a variable
    $refurl = $_SERVER['HTTP_REFERER'];
 
    // Return that value to the form
    return esc_url_raw($refurl);
}