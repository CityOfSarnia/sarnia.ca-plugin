<?php
/*
 *  Plugin Name: Sarnia.ca Plugin
 *  Plugin URI:  https://github.com/CityOfSarnia/sarnia.ca-plugin
 *  Description: This plugin contains the functionality code required for the sarnia.ca website
 *  Version:     1.12.0
 *  Author URI:  https://www.sarnia.ca
 *  License:     MIT License
 */

define('SARNIA_PLUGIN_PATH', plugin_dir_path(__FILE__));
define('GF_LICENSE_KEY', env('GF_LICENSE_KEY'));
define('GF_RECAPTCHA_PUBLIC_KEY', env('GF_RECAPTCHA_PUBLIC_KEY'));
define('GF_RECAPTCHA_PRIVATE_KEY', env('GF_RECAPTCHA_PRIVATE_KEY'));

add_filter('bedrock/stage_switcher_visibility', function ($visibility) {
    return true;
});

function get_notifications($request)
{
    $data = get_posts(array(
        'post_type' => 'notifications',
        'post_status' => 'publish',
        'posts_per_page' => 20,
    ));

    return new WP_REST_Response($data, 200);
}

/*
 * Add a new notifications
 *
 * @param WP_REST_Request $request Full data about the request.
 * @return WP_Error|WP_REST_Request
 */
function create_notifications($request)
{
    $params = $request->get_json_params();

    $post_id = wp_insert_post(array(
        'post_title' => sanitize_text_field(isset($params['title']) ? $params['title'] : 'Untitled notification'),
        'post_content' => sanitize_text_field(isset($params['body']) ? $params['body'] : ''),
        'post_type' => 'notifications',
        'post_status' => 'publish',
    ));

    update_field('notification_date', get_the_date('M j, Y \a\t g:i a', $post_id), $post_id);

    return new WP_REST_Response($post_id, 200);
}

/**
 * This is our callback function that embeds our resource in a WP_REST_Response
 */
function permissions_check($request)
{
    // Restrict endpoint to only users who have the edit_posts capability.
    if (!current_user_can('publish_posts')) {
        return new WP_Error('rest_forbidden', esc_html__('Permission Denied', 'sarnia.ca/v1'), array('status' => 401));
    }

    // This is a black-listing approach. You could alternatively do this via white-listing, by returning false here and changing the permissions check.
    return true;
}

/*
 * Register the routes for the objects of the controller.
 */
function register_endpoints()
{
    // endpoints will be registered here
    register_rest_route('sarnia.ca-plugin/v1', '/notifications', array(
        'methods' => WP_REST_Server::READABLE,
        'callback' => 'get_notifications',
    ));
    register_rest_route('sarnia.ca-plugin/v1', '/notifications', array(
        'methods' => WP_REST_Server::CREATABLE,
        'callback' => 'create_notifications',
        'permission_callback' => 'permissions_check',
    ));
}
add_action('rest_api_init', 'register_endpoints');

function sarnia_request($query_string)
{
    if (isset($query_string['page'])) {
        if ('' != $query_string['page']) {
            if (isset($query_string['name'])) {
                unset($query_string['name']);
            }
        }
    }
    return $query_string;
}
add_filter('request', 'sarnia_request');

add_action('pre_get_posts', 'sarnia_pre_get_posts');
function sarnia_pre_get_posts($query)
{
    if ($query->is_main_query() && !$query->is_feed() && !$query->is_search()) {
        $query->set('paged', str_replace('/', '', get_query_var('page')));
    }
}

// Force Gravity Forms to init scripts in the footer and ensure that the DOM is loaded before scripts are executed
add_filter('gform_init_scripts_footer', '__return_true');
add_filter('gform_cdata_open', 'wrap_gform_cdata_open', 1);
function wrap_gform_cdata_open($content = '')
{
    if ((defined('DOING_AJAX') && DOING_AJAX) || isset($_POST['gform_ajax'])) {
        return $content;
    }
    $content = 'document.addEventListener( "DOMContentLoaded", function() { ';
    return $content;
}
add_filter('gform_cdata_close', 'wrap_gform_cdata_close', 99);
function wrap_gform_cdata_close($content = '')
{
    if ((defined('DOING_AJAX') && DOING_AJAX) || isset($_POST['gform_ajax'])) {
        return $content;
    }
    $content = ' }, false );';
    return $content;
}

// Return the IP address set by the proxy.
add_filter('gform_ip_address', 'filter_gform_ip_address');
function filter_gform_ip_address($ip) {
    if( isset( $_SERVER['HTTP_X_FORWARDED_FOR'] ) )
        return $_SERVER['HTTP_X_FORWARDED_FOR'];
    else  
        return FALSE;
}
