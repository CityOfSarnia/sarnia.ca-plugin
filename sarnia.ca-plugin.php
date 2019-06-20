<?php
/*Plugin Name: Sarnia.ca Plugin
* Description: This plugin contains the functionality code required for the sarnia.ca website
* Version: 0.1.3
* Author: City of Sarnia
* Author URI: http://sarnia.ca
*/

define( 'SARNIA_PLUGIN_PATH', plugin_dir_path( __FILE__ ) );

add_action( 'wp_head', 'sarnia_add_analytics' );
function sarnia_add_analytics() {
  ?>
  <!-- Global Site Tag (gtag.js) - Google Analytics -->
  <script async src="https://www.googletagmanager.com/gtag/js?id=<?=env('GOOGLE_ANALYTICS_TRACKINGID')?>"></script>
  <script>
    window.dataLayer = window.dataLayer || [];
    function gtag(){dataLayer.push(arguments);}
    gtag('js', new Date());

    gtag('config', '<?=env('GOOGLE_ANALYTICS_TRACKINGID')?>');
  </script>
  <?php
}

add_filter( 'gform_field_value_refurl', 'populate_referral_url');

function populate_referral_url( $form ){
    // Grab URL from HTTP Server Var and put it into a variable
    $refurl = $_SERVER['HTTP_REFERER'];

    // Return that value to the form
    return esc_url_raw($refurl);
}

add_filter( 'gform_field_value_reftitle', 'populate_page_title');

function populate_page_title( $form ){
    $back_id = url_to_postid($_SERVER['HTTP_REFERER']);
    if( $back_id > 0 ) $back_title = get_the_title( $back_id );
    // Return that value to the form
    return $back_title;
}

add_filter( 'gform_ip_address', 'filter_gform_ip_address' );

function filter_gform_ip_address( $ip ) {
    // Return the IP address set by the proxy.
    // E.g. $_SERVER['HTTP_X_FORWARDED_FOR'] or $_SERVER['HTTP_CLIENT_IP']
    return $_SERVER['HTTP_X_FORWARDED_FOR'];
}

define('GF_LICENSE_KEY',env('GF_LICENSE_KEY'));
