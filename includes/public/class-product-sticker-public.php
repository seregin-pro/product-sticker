<?php
defined( 'ABSPATH' ) || exit;

class ProductStickerPublic {
	
	public function __construct() {
		
		$this->general     	      = (array) get_option( 'general' );
		$this->sticker_sale       = (array) get_option( 'sticker_sale' );
		$this->sticker_new        = (array) get_option( 'sticker_new' );
		$this->sticker_soldout    = (array) get_option( 'sticker_soldout' );
		$this->sticker_bestseller = (array) get_option( 'sticker_bestseller' );
		
		if ( $this->general['status'] ) {
			$this->init_hooks();
		}
		
		wp_enqueue_style( 'product-sticker', plugin_dir_url( __FILE__ ) . 'css/product-sticker.css', array(), SPS_VERSION, 'all' );
	}
	
	private function init_hooks() {
		add_action( 'woocommerce_product_thumbnails_columns', array( $this, 'product_sticker' ) );
		add_action( 'woocommerce_before_shop_loop_item', array( $this, 'product_sticker' ) );
		add_action( 'wp_head', array( $this, 'generate_css' ) );
	}
	
	public function product_sticker() {
		global $product;
		
		$sticker_data = array(
			'left'  => array(),
			'right' => array(),
		);
		
		// Sale
		if ( $product->is_on_sale() && $this->sticker_sale['status'] ) {
			
			if ( $this->sticker_sale['label'] == 'text' || ! (float) $product->get_sale_price( $this ) ) {
				$class = '';
				$text  = esc_html__( 'Sale', 'product-sticker' );
			} else {
				$class = ' sticker-percent';
				$text  = $this->getPercent( (float) $product->get_regular_price( $this ), (float) $product->get_sale_price( $this ) );
			}
			
			$sticker_data[$this->sticker_sale['position']][] = array(
				'class' 	 => 'sticker-sale sticker-' . esc_html($this->sticker_sale['type'] . $class),
				'text'  	 => $text,
				'sort_order' => $this->sticker_sale['sort_order']
			);
		}
		
		// New
		if ( $this->sticker_new['status'] ) {
			$date_added = ( time() - strtotime( $product->get_date_created( $this ) ) ) / 86400;
			
			if ( (int) $date_added <= (int)$this->sticker_new['day'] ) {
				$sticker_data[$this->sticker_new['position']][] = array(
					'class' 	 => 'sticker-new sticker-' . esc_html($this->sticker_new['type']),
					'text'  	 => esc_html__( 'New', 'product-sticker' ),
					'sort_order' => $this->sticker_new['sort_order']
				);
			}
		}
		
		// soldout
		if ( $this->sticker_soldout['status'] && ! $product->is_in_stock() ) {
			
			$sticker_data[$this->sticker_soldout['position']][] = array(
				'class' 	 => 'sticker-soldout sticker-' . esc_html($this->sticker_soldout['type']),
				'text'  	 => esc_html__( 'Out of stock', 'product-sticker' ),
				'sort_order' => $this->sticker_soldout['sort_order']
			);
		}
		
		if ( $this->sticker_bestseller['status'] ) {
			$total_order = $product->get_total_sales( $this );
			
			if ( (int) $this->sticker_bestseller['sale'] && $total_order && $total_order >= $this->sticker_bestseller['sale']) {
				$sticker_data[$this->sticker_bestseller['position']][] = array(
					'class' 	 => 'sticker-bestseller sticker-' . esc_html($this->sticker_bestseller['type']),
					'text'  	 => esc_html__( 'Best Seller', 'product-sticker' ),
					'sort_order' => $this->sticker_bestseller['sort_order']
				);
			}
		}
		
		// Show stickers
		if ( $sticker_data ) {
			$sort_order = array();
			
			if ( $sticker_data['left'] ) {
			
				foreach ( $sticker_data['left'] as $key => $value ) {
					$sort_order['left'][$key] = $value['sort_order'];
				}
				
				array_multisort( $sort_order['left'], SORT_ASC, $sticker_data['left'] );
				
				echo '<div class="sticker-catalog sticker-left">';
				
				foreach ( $sticker_data['left'] as $sticker ) {	
					echo '<div class="' . esc_html($sticker['class']) . '">';
					echo '<div>' . esc_html($sticker['text']) . '</div>';
					echo '</div>';
				}
				
				echo '</div>';
			}

			if ( $sticker_data['right'] ) {
			
				foreach ( $sticker_data['right'] as $key => $value ) {
					$sort_order['right'][$key] = $value['sort_order'];
				}
				
				array_multisort( $sort_order['right'], SORT_ASC, $sticker_data['right'] );
				
				echo '<div class="sticker-catalog sticker-right">';
				
				foreach ( $sticker_data['right'] as $sticker ) {
					echo '<div class="' . esc_html($sticker['class']) . '">';
					echo '<div>' . esc_html($sticker['text']) . '</div>';
					echo '</div>';
				}
				
				echo '</div>';
			}
		}
	}
	
	public function special($product) {
		$price = $product->get_regular_price( $this );
		$sale = $product->get_sale_price( $this );
	}
	
	private function getPercent($price_old, $price_new) {
		return '-' . round(($price_old - $price_new) / ($price_old / 100)) . '%';
	}
	
	function generate_css() {
		$css_folder = plugin_dir_url( __FILE__ ) . 'css/image/';
		
		echo "<style type=\"text/css\">\n";
		
		if ( $this->sticker_sale['status'] ) {
			$image = $this->sticker_sale['image'] ? $this->sticker_sale['image'] : $css_folder . $this->sticker_sale['type'] . '/sticker-sale.png';
			echo ".sticker-sale{ background: url('" . esc_url($image) . "'); }\n";
		}
		
		if ( $this->sticker_new['status'] ) {
			$image = $this->sticker_new['image'] ? $this->sticker_new['image'] : $css_folder . $this->sticker_new['type'] . '/sticker-new.png';
			echo ".sticker-new{ background: url('" . esc_url($image) . "'); }\n";
		}
		
		if ( $this->sticker_soldout['status'] ) {
			$image = $this->sticker_soldout['image'] ? $this->sticker_soldout['image'] : $css_folder . $this->sticker_soldout['type'] . '/sticker-soldout.png';
			echo ".sticker-soldout{ background: url('" . esc_url($image) . "'); }\n";
		}
		
		if ( $this->sticker_bestseller['status'] ) {
			$image = $this->sticker_bestseller['image'] ? $this->sticker_bestseller['image'] : $css_folder . $this->sticker_bestseller['type'] . '/sticker-bestseller.png';
			echo ".sticker-bestseller{ background: url('" . esc_url($image) . "'); }\n";
		}
		
		echo esc_html($this->general['css']);
		
		echo "\n</style>\n";
	}
}

new ProductStickerPublic();