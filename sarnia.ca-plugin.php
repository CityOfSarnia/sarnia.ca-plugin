<?php
/*Plugin Name: Sarnia.ca Plugin
* Description: This plugin contains the functionality code required for the sarnia.ca website
* Version: 0.2
* Author: City of Sarnia
* Author URI: http://sarnia.ca
*/
add_action( 'wp_head', 'sarnia_add_analytics' );
function sarnia_add_analytics() {
  ?>
  <!-- Global Site Tag (gtag.js) - Google Analytics -->
  <script async src="https://www.googletagmanager.com/gtag/js?id=<?=getenv('google.analytics.trackingID')?>"></script>
  <script>
    window.dataLayer = window.dataLayer || [];
    function gtag(){dataLayer.push(arguments);}
    gtag('js', new Date());

    gtag('config', '<?=getenv('google.analytics.trackingID')?>');
  </script>
  <?php
}
