<?php
/*
Plugin Name: Sarnia.ca Plugin
Plugin URI:  https://github.com/CityOfSarnia/sarnia.ca-plugin
Description: This plugin contains the functionality code required for the sarnia.ca website
Version:     1.5.0
Author:      City of Sarnia
Author URI:  https://www.sarnia.ca
License:     MIT License
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

add_filter( 'gform_ip_address', 'filter_gform_ip_address' );

function filter_gform_ip_address( $ip ) {
    // Return the IP address set by the proxy.
    // E.g. $_SERVER['HTTP_X_FORWARDED_FOR'] or $_SERVER['HTTP_CLIENT_IP']
    return $_SERVER['HTTP_X_FORWARDED_FOR'];
}

define('GF_LICENSE_KEY', env('GF_LICENSE_KEY'));
define('GF_RECAPTCHA_PUBLIC_KEY', env('GF_RECAPTCHA_PUBLIC_KEY'));
define('GF_RECAPTCHA_PRIVATE_KEY', env('GF_RECAPTCHA_PRIVATE_KEY'));

add_filter('bedrock/stage_switcher_visibility', function($visibility) {
  return true;
});
