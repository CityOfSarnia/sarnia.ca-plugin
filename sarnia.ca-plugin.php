<?php
/*
Plugin Name: Sarnia.ca Plugin
Plugin URI:  https://github.com/CityOfSarnia/sarnia.ca-plugin
Description: This plugin contains the functionality code required for the sarnia.ca website
Version:     1.6.0
Author:      City of Sarnia
Author URI:  https://www.sarnia.ca
License:     MIT License
*/

define( 'SARNIA_PLUGIN_PATH', plugin_dir_path( __FILE__ ) );
define('GF_LICENSE_KEY', env('GF_LICENSE_KEY'));
define('GF_RECAPTCHA_PUBLIC_KEY', env('GF_RECAPTCHA_PUBLIC_KEY'));
define('GF_RECAPTCHA_PRIVATE_KEY', env('GF_RECAPTCHA_PRIVATE_KEY'));

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
add_action( 'wp_head', 'sarnia_add_analytics' );

function filter_gform_ip_address( $ip ) {
    // Return the IP address set by the proxy.
    // E.g. $_SERVER['HTTP_X_FORWARDED_FOR'] or $_SERVER['HTTP_CLIENT_IP']
    return $_SERVER['HTTP_X_FORWARDED_FOR'];
}
add_filter( 'gform_ip_address', 'filter_gform_ip_address' );


add_filter('bedrock/stage_switcher_visibility', function($visibility) {
  return true;
});

function get_notifications( $request ) {
  $data = get_posts( array(
    'post_type'      => 'notifications',
    'post_status'    => 'publish',
    'posts_per_page' => 20,
  ) );

  return new WP_REST_Response( $data, 200 );
}

/*
* Add a new notifications
*
* @param WP_REST_Request $request Full data about the request.
* @return WP_Error|WP_REST_Request
*/
function create_notifications( $request ) {
  $params = $request->get_json_params();

  $post_id = wp_insert_post( array(
    'post_title'    => isset( $params['title'] ) ? $params['title'] : 'Untitled notification',
    'post_content'  => isset( $params['body'] ) ? $params['body'] : '',
    'post_type'     => 'notifications',
    'post_status'   => 'publish',
  ) );

  return new WP_REST_Response( $post_id, 200 );
}

/**
 * This is our callback function that embeds our resource in a WP_REST_Response
 */
function permissions_check( $request ) {
  // Restrict endpoint to only users who have the edit_posts capability.
  if ( ! current_user_can( 'publish_posts' ) ) {
      return new WP_Error( 'rest_forbidden', esc_html__( 'Permission Denied', 'sarnia.ca/v1' ), array( 'status' => 401 ) );
  }

  // This is a black-listing approach. You could alternatively do this via white-listing, by returning false here and changing the permissions check.
  return true;
}

/*
* Register the routes for the objects of the controller.
*/
function register_endpoints() {
  // endpoints will be registered here
  register_rest_route( 'sarnia.ca-plugin/v1', '/notifications', array(
    'methods' => WP_REST_Server::READABLE,
    'callback' => 'get_notifications',
  ) );
  register_rest_route( 'sarnia.ca-plugin/v1', '/notifications', array(
    'methods' => WP_REST_Server::CREATABLE,
    'callback' => 'create_notifications',
    'permission_callback' => 'permissions_check',
  ) );
}
add_action( 'rest_api_init', 'register_endpoints' );
