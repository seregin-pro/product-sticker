<?php
defined( 'ABSPATH' ) || exit;

final class ProductStickerAdmin {
	public function __construct() {
		$this->init_hooks();
	}
	
	public function plugin_action_links($links) {
		$action_links = array(
			'settings' => 
			'<a href="options-general.php?page=product-sticker" aria-label="' . esc_attr__( 'Settings', 'product-sticker' ) . '">' . esc_html__( 'Settings', 'product-sticker' ) . '</a>',
		);

		return array_merge($action_links, $links);
	}
	
	private function init_hooks() {
		add_filter('plugin_action_links_product-sticker/product-sticker.php', array($this, 'plugin_action_links'), 10, 1);
		
		add_action( 'admin_menu', array( $this, 'admin_menu' ) );
		add_action( 'plugins_loaded', array( $this, 'languages' ) );
		add_action( 'admin_enqueue_scripts', array( $this, 'add_media_script' ) );
	}
	
	function add_media_script( $hook_suffix ) {
		wp_enqueue_media();
	}
	
  	public function admin_menu() {
  		add_options_page(esc_html__( 'WooCommerce Stickers', 'product-sticker' ), esc_html__( 'WooCommerce Stickers', 'product-sticker' ), 'manage_options', 'product-sticker', array($this, 'settings_page'));
    }
	
	public function settings_page() {
		include_once plugin_dir_path( __FILE__ ) . '/sps-admin.php';
    }
	
	public function languages() {
		load_plugin_textdomain('product-sticker', false, 'product-sticker/languages/'); 
	}
}

new ProductStickerAdmin();