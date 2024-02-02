<?php $sticker_bestseller = ( array ) get_option ( 'sticker_bestseller' ); ?>
<?php $style_custom_id = 1 + get_option( 'style_custom_id' ); ?>
<table class="form-table">
	<tr valign="top">
		<th scope="row"><?php echo esc_html__( 'Status', 'product-sticker' ); ?></th>
		<td>
			<select name="sticker_bestseller[status]">
				<option <?php if ( $sticker_bestseller['status'] ) { ?>selected="selected" <?php } ?>value="1"><?php echo esc_html__( 'Enabled', 'product-sticker' ); ?></option>
				<option <?php if ( ! $sticker_bestseller['status'] ) { ?>selected="selected" <?php } ?>value="0"><?php echo esc_html__( 'Disabled', 'product-sticker' ); ?></option>
			</select>
		</td>
	</tr>
	<tr valign="top">
		<th scope="row"><?php echo esc_html__( 'Bestseller Products (quantity of sales)', 'product-sticker' ); ?></th>
		<td>
			<input type="text" name="sticker_bestseller[sale]" placeholder="<?php echo esc_attr__( 'Bestseller Products (quantity of sales)', 'product-sticker' ); ?>" value="<?php echo esc_html($sticker_bestseller['sale']); ?>">
		</td>
	</tr>
	<tr valign="top">
		<th scope="row"><?php echo esc_html__( 'Position', 'product-sticker' ); ?></th>
		<td>
			<select name="sticker_bestseller[position]">
				<option <?php if ( $sticker_bestseller['position'] == 'left' ) { ?>selected="selected" <?php } ?>value="left"><?php echo esc_html__( 'Left', 'product-sticker' ); ?></option>
				<option <?php if ( $sticker_bestseller['position'] == 'right' ) { ?>selected="selected" <?php } ?>value="right"><?php echo esc_html__( 'Right', 'product-sticker' ); ?></option>
			</select>
		</td>
	</tr>
	<tr valign="top">
		<th scope="row"><?php echo esc_html__( 'Sort order', 'product-sticker' ); ?></th>
		<td>
			<input type="text" name="sticker_bestseller[sort_order]" placeholder="<?php echo esc_attr__( 'Sort order', 'product-sticker' ); ?>" value="<?php echo esc_html($sticker_bestseller['sort_order']); ?>">
		</td>
	</tr>
		<tr valign="top">
		<th scope="row"><?php echo esc_html__( 'Type', 'product-sticker' ); ?></th>
		<td>
			<select name="sticker_bestseller[type]">
				<option <?php if ( $sticker_bestseller['type'] == 'star' ) { ?>selected="selected" <?php } ?>value="star"><?php echo esc_attr__( 'Star', 'product-sticker' ); ?></option>
				<option <?php if ( $sticker_bestseller['type'] == 'ribbon' ) { ?>selected="selected" <?php } ?>value="ribbon"><?php echo esc_attr__( 'Ribbon', 'product-sticker' ); ?></option>
				<option <?php if ( $sticker_bestseller['type'] == 'diagonal' ) { ?>selected="selected" <?php } ?>value="diagonal"><?php echo esc_attr__( 'Diagonal', 'product-sticker' ); ?></option>
			</select>
		</td>
	</tr>
	<tr valign="top">
		<th scope="row"><?php echo esc_html__( 'Image', 'product-sticker' ); ?></th>
		<td>
			<div id="meta-box-product-sticker">
				<?php $placeholder = plugin_dir_url( __FILE__ ) . '/image/placeholder.png'; ?>
				<img src="<?php echo esc_url($sticker_bestseller['image'] ? $sticker_bestseller['image'] : $placeholder); ?>" alt="" />
				<button type="button" class="btn button button-delete <?php if ( ! $sticker_bestseller['image'] ) { echo 'hidden'; } ?>"><?php echo esc_html__( 'Remove', 'product-sticker' ); ?></button>
				<input name="sticker_bestseller[image]" type="hidden" value="<?php echo esc_url($sticker_bestseller['image']); ?>" />
			</div>
		</td>
	</tr>
</table>
<input type="hidden" name="style_custom_id" value="<?php echo esc_html($style_custom_id); ?>" />
<input type="hidden" name="page_options" value="sticker_bestseller, style_custom_id" />
<style>
	#meta-box-product-sticker {
		width: 100px;
	}
	#meta-box-product-sticker img {
		cursor: pointer;
		margin-bottom: 15px;
	}
	#meta-box-product-sticker img, #meta-box-product-sticker button {
		width: 100%;
	}
</style>
<script>
jQuery(function($) {
	frame = false;
	metaBox = $( '#meta-box-product-sticker' );
	imageUpload = metaBox.find( 'img' );
	buttonDelete = metaBox.find( '.button-delete' );
	imageSticker = metaBox.find( 'img' );
	input = metaBox.find( 'input' );
  
	imageUpload.on( 'click', function( event ) {
		if ( frame ) {
			frame.open();
			return;
		}
		
		frame = wp.media({
			multiple: false
		});
		
		frame.on( 'select', function() {
			var attachment = frame.state().get('selection').first().toJSON();
			
			imageSticker.attr( 'src', attachment.url );
			input.val( attachment.url );
			buttonDelete.removeClass( 'hidden' );
		});

		frame.open();
	});
  
	buttonDelete.on( 'click', function( event ) {
		imageSticker.attr( 'src', '<?php echo esc_url($placeholder); ?>' );
		input.val( '' );
		buttonDelete.addClass( 'hidden' );
	});
});
</script>