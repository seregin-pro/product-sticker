<?php
defined( 'ABSPATH' ) || exit;

final class ProductSticker {
	public function __construct() {
		$this->init();
	}
	
	private function init() {
		include_once plugin_dir_path( __FILE__ ) . 'admin/class-product-sticker-admin.php';
		include_once plugin_dir_path( __FILE__ ) . 'public/class-product-sticker-public.php';
	}
}

new ProductSticker();