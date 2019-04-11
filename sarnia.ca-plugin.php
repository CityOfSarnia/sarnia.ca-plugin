<?php
/*Plugin Name: Sarnia.ca Plugin
* Description: This plugin contains the functionality code required for the sarnia.ca website
* Version: 0.2
* Author: City of Sarnia
* Author URI: http://sarnia.ca
*/

define( 'SARNIA_PLUGIN_PATH', plugin_dir_path( __FILE__ ) );

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
add_action( 'wp_head', 'sarnia_add_analytics' );

function fb_filter_query( $query, $error = true ) {

	if ( is_search() ) {
		$query->is_search = false;
		$query->query_vars = false;
		$query->query = false;

		// to error
		if ( $error == true )
			$query->is_404 = true;
	}
}

add_action( 'parse_query', 'fb_filter_query' );
add_filter( 'get_search_form', function() { return null;} );
