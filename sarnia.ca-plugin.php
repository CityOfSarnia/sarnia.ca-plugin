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

add_action('acf/init', 'sarnia_register_acf_gutenberg_blocks');

function sarnia_register_acf_gutenberg_blocks() {

	// check function exists
	if( function_exists('acf_register_block') ) {

		// register a banner block
		acf_register_block(array(
			'name'            => 'banner',
			'title'           => __('Banner'),
			'description'     => __('A banner block.'),
			'render_callback' => 'my_acf_block_render_callback',
			'category'        => 'formatting',
			'icon'            => 'id',
			'keywords'        => array( 'banner', 'menu', 'nav' ),
			'supports'        => array( 'align' => array( 'full' ) ),
		));

		// register a post card block
		acf_register_block(array(
			'name'            => 'post-card',
			'title'           => __('Post Card'),
			'description'     => __('A post or page card block.'),
			'render_callback' => 'my_acf_block_render_callback',
			'category'        => 'formatting',
			'icon'            => 'media-default',
			'keywords'        => array( 'post', 'card' ),
			'supports'        => array( 'align' => false ),
		));

		// register a custom card block
		acf_register_block(array(
			'name'            => 'custom-card',
			'title'           => __('Custom Card'),
			'description'     => __('A custom card block.'),
			'render_callback' => 'my_acf_block_render_callback',
			'category'        => 'formatting',
			'icon'            => 'media-text',
			'keywords'        => array( 'custom', 'card' ),
			'supports'        => array( 'align' => false ),
		));

		// register a notifications block
		acf_register_block(array(
			'name'            => 'notifications',
			'title'           => __('Notifications'),
			'description'     => __('A notifications block.'),
			'render_callback' => 'my_acf_block_render_callback',
			'category'        => 'formatting',
			'icon'            => 'star-filled',
			'keywords'        => array( 'notifications' ),
			'supports'        => array( 'align' => array( 'full' ) ),
		));

		// register a recent posts block
		acf_register_block(array(
			'name'            => 'recent-posts',
			'title'           => __('Recent Posts'),
			'description'     => __('Recent posts by category block.'),
			'render_callback' => 'my_acf_block_render_callback',
			'category'        => 'formatting',
			'icon'            => 'admin-page',
			'keywords'        => array( 'recent', 'posts', 'news' ),
			'supports'        => array( 'align' => array( 'wide' ) ),
		));

		// register a navigation block
		acf_register_block(array(
			'name'            => 'navigation',
			'title'           => __('Navigation'),
			'description'     => __('A navigation block.'),
			'render_callback' => 'my_acf_block_render_callback',
			'category'        => 'formatting',
			'icon'            => 'list-view',
			'keywords'        => array( 'navigation', 'menu', 'nav' ),
			'supports'        => array( 'align' => false ),
		));

	}
}

// Register Options Page
if( function_exists('acf_add_options_page') ) {
	acf_add_options_page();
}

