<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$current_tab = empty( $_GET['tab'] ) ? 'general' : sanitize_title( wp_unslash( $_GET['tab'] ) );

$tabs = array(
	'general' 	 => esc_html__( 'General', 'product-sticker' ),
	'sale' 		 => esc_html__( 'Sale', 'product-sticker' ),
	'new' 		 => esc_html__( 'New', 'product-sticker' ),
	'soldout' 	 => esc_html__( 'Sold Out', 'product-sticker' ),
	'bestseller' => esc_html__( 'Bestseller', 'product-sticker' ),
);

?>
<div class="wrap">
	<h2><?php echo esc_html__( 'WooCommerce Stickers Settings', 'product-sticker' ); ?></h2>
	<form method="post" action="options.php">
		<?php wp_nonce_field('update-options'); ?>
		<nav class="nav-tab-wrapper">
			<?php
			foreach ( $tabs as $slug => $label ) {
				echo '<a href="' . esc_html( admin_url( 'admin.php?page=product-sticker&tab=' . esc_attr( $slug ) ) ) . '" class="nav-tab ' . ( $current_tab === $slug ? 'nav-tab-active' : '' ) . '">' . esc_html( $label ) . '</a>';
			}
			?>
		</nav>
		<?php include_once plugin_dir_path( __FILE__ ) . '/sps-content-tab-' . esc_html($current_tab) . '.php';  ?> 
		<input type="hidden" name="action" value="update" />
		<p class="submit">
			<input type="submit" class="button-primary" value="<?php _e('Save Changes'); ?>" />
		</p>
	</form>
</div>
