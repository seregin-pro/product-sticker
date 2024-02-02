<?php
/*
Plugin Name: Product Sticker
Plugin URI: https://wordpress.org/plugins/product-sticker
Description: Product stickers for WooCommerce
Version: 1.0.0
Author: sereginpro
Author URI: https://seregin-pro.ru/
License: GPLv2 or later
Text Domain: product-sticker
*/

defined( 'ABSPATH' ) || exit;

if (in_array ( 'woocommerce/woocommerce.php', apply_filters ( 'active_plugins', get_option ( 'active_plugins' ) ) ) ) {
	
	define ( 'SPS_VERSION', '1.0.0' );
	
	// New comment

	if ( ! class_exists( 'ProductSticker', false ) ) {
		include_once plugin_dir_path( __FILE__ ) . '/includes/class-product-sticker.php';
	}
}
