<?php
/*
 *  Plugin Name: Sarnia.ca Plugin
 *  Plugin URI:  https://github.com/CityOfSarnia/sarnia.ca-plugin
 *  Description: This plugin contains the functionality code required for the sarnia.ca website
 *  Version:     2.2.0
 *  Author URI:  https://www.sarnia.ca
 *  License:     MIT License
 */

define('SARNIA_PLUGIN_PATH', plugin_dir_path(__FILE__));

require_once(SARNIA_PLUGIN_PATH .'includes/gravity_forms.php');
require_once(SARNIA_PLUGIN_PATH .'includes/notifications.php');
require_once(SARNIA_PLUGIN_PATH .'includes/post_types.php');

SarniaPostTypes::init(); // load before notifications
SarniaNotifications::init();
SarniaGForms::init();

add_filter('bedrock/stage_switcher_visibility', function ($visibility) {
    return true;
});

use function \Sober\Intervention\intervention;

if (function_exists('\Sober\Intervention\intervention')) {
    // now you can use the function to call the required modules and their params
    intervention('remove-menu-items', 'plugins', ['editor', 'author']);
    //intervention('remove-menu-items', 'plugins', 'all');
    intervention('remove-emoji');
    // Removes howdy and replaces with Hello.
    intervention('remove-howdy', 'Hello');
}

function card_colour()
{
	global $card_count;

	$card_count++;

	switch ($card_count) {
		case 1:
			$colour = 'card--blue';
			break;
		case 2:
			$colour = 'card--red';
			break;
		case 3:
			$colour = 'card--yellow';
			$card_count = 0;
			break;
		default:
			$card_count = 0;
	}

	return $colour;
}

add_image_size('home-banner', 1000, 900, true);
add_image_size('banner', 1600, 600, true);
add_image_size('card', 780, 200, true);

// Add support for page excerpts
add_post_type_support('page', 'excerpt');

function create_my_post_types()
{
    register_post_type(
        'notifications',
        array(
            'labels' => array(
                'name' => __('Notifications'),
                'singular_name' => __('Notification')
            ),
            'public' => true,
            'menu_icon' => 'dashicons-star-filled',
            'supports' => array('title', 'editor', 'excerpt', 'thumbnail'),
            'exclude_from_search' => true,
            'show_in_admin_bar'   => false,
            'show_in_nav_menus'   => false,
            'publicly_queryable'  => true,
            'query_var'           => false,
        )
    );
}
add_action('init', 'create_my_post_types');

function build_taxonomies()
{
    register_taxonomy(
        'filter',
        array('notifications'),
        array(
            'hierarchical' => true,
            'label' => 'Filter',
            'query_var' => true,
        )
    );
    register_taxonomy(
        'notification-icon',
        array('notifications'),
        array(
            'hierarchical' => true,
            'label' => 'Notification Icon',
            'query_var' => true,
        )
    );
}
// Create Custom Taxonomies
add_action('init', 'build_taxonomies', 0);

// Register Options Page
if (function_exists('acf_add_options_page')) {
    acf_add_options_page();
}

function my_acf_json_load_point($paths)
{
    // remove original path (optional)
    unset($paths[0]);
    $paths[] = SARNIA_PLUGIN_PATH . '/assets/acf-json';

    return   $paths;
}
add_filter('acf/settings/load_json', 'my_acf_json_load_point');

function my_acf_json_save_point($path)
{
    // update path
    $path = SARNIA_PLUGIN_PATH . '/assets/acf-json';

    // return
    return $path;
}
add_filter('acf/settings/save_json', 'my_acf_json_save_point');

function my_acf_block_render_callback($block)
{

    // convert name ("acf/testimonial") into path friendly slug ("testimonial")
    $slug = str_replace('acf/', '', $block['name']);

    // include a template part from within the "includes/block" folder
    if (file_exists(SARNIA_PLUGIN_PATH . "includes/block/block-{$slug}.php")) {
        include(SARNIA_PLUGIN_PATH . "/includes/block/block-{$slug}.php");
    }
}

function my_acf_init()
{

    // check function exists
    if (function_exists('acf_register_block')) {

        // register a post card block
        acf_register_block(array(
            'name'                        => 'post-card',
            'title'                        => __('Post Card'),
            'description'            => __('A post or page card block.'),
            'render_callback'    => 'my_acf_block_render_callback',
            'category'                => 'formatting',
            'icon'                        => 'media-default',
            'keywords'                => array('post', 'card'),
            'supports'                 => array('align' => false),
        ));

        // register a custom card block
        acf_register_block(array(
            'name'                        => 'custom-card',
            'title'                        => __('Custom Card'),
            'description'            => __('A custom card block.'),
            'render_callback'    => 'my_acf_block_render_callback',
            'category'                => 'formatting',
            'icon'                        => 'media-text',
            'keywords'                => array('custom', 'card'),
            'supports'                 => array('align' => false),
        ));

        // register an accordion block
        acf_register_block(array(
            'name'                        => 'accordion',
            'title'                        => __('Accordion'),
            'description'            => __('An accordion block.'),
            'render_callback'    => 'my_acf_block_render_callback',
            'category'                => 'formatting',
            'icon'                        => 'plus',
            'keywords'                => array('accordion', 'toggle', 'dropdown'),
            'supports'                 => array('align' => false),
        ));

        // register a recent posts block
        acf_register_block(array(
            'name'                        => 'recent-posts',
            'title'                        => __('Recent Posts'),
            'description'            => __('Recent posts by category block.'),
            'render_callback'    => 'my_acf_block_render_callback',
            'category'                => 'formatting',
            'icon'                        => 'admin-page',
            'keywords'                => array('recent', 'posts', 'news'),
            'supports'                 => array('align' => array('wide')),
        ));

        // register a navigation block
        acf_register_block(array(
            'name'                        => 'navigation',
            'title'                        => __('Navigation'),
            'description'            => __('A navigation block.'),
            'render_callback'    => 'my_acf_block_render_callback',
            'category'                => 'formatting',
            'icon'                        => 'list-view',
            'keywords'                => array('navigation', 'menu', 'nav'),
            'supports'                 => array('align' => false),
        ));

        // register the shortcut-menu block
        acf_register_block(array(
            'name'                        => 'shortcut-menu',
            'title'                        => __('Shortcut Menu'),
            'description'            => __('A navigation block.'),
            'render_callback'    => 'my_acf_block_render_callback',
            'category'                => 'formatting',
            'icon'                        => 'list-view',
            'keywords'                => array('icon', 'menu', 'shortcut'),
            'supports'                 => array('align' => false),
        ));
    }
}
add_action('acf/init', 'my_acf_init');

function my_acf_post_id()
{
	if (is_admin() && function_exists('acf_maybe_get_POST')) :
		return intval(acf_maybe_get_POST('post_id'));
	else :
		global   $post;
		return   $post->ID;
	endif;
}

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
        $query->set('paged', str_replace('/', '', get_query_var('paged')));
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
function filter_gform_ip_address($ip)
{
    if (isset($_SERVER['HTTP_X_FORWARDED_FOR']))
        return $_SERVER['HTTP_X_FORWARDED_FOR'];
    else
        return FALSE;
}

function wpb_hook_javascript_footer() {
?>
<script type="text/javascript">
    window._monsido = window._monsido || {
        token: "<?=env('MONSIDO_TOKEN');?>",
        statistics: {
            enabled: true,
            documentTracking: {
                enabled: false,
                documentCls: "monsido_download",
                documentIgnoreCls: "monsido_ignore_download",
                documentExt: [],
            },
        },
    };
</script>
<script type="text/javascript" async src="https://app-script.monsido.com/v2/monsido-script.js"></script>
<?php
}
add_action('wp_footer', 'wpb_hook_javascript_footer');
