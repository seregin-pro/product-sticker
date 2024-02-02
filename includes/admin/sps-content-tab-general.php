<?php $general = ( array ) get_option( 'general' ); ?>
<?php $style_custom_id = 1 + get_option( 'style_custom_id' ); ?>
<table class="form-table">
	<tr valign="top">
		<th scope="row"><?php echo esc_html__( 'Status', 'product-sticker' ); ?></th>
		<td>
			<select name="general[status]">
				<option <?php if ( $general['status'] ) { ?>selected="selected" <?php } ?>value="1"><?php echo esc_html__( 'Enabled', 'product-sticker' ); ?></option>
				<option <?php if ( ! $general['status'] ) { ?>selected="selected" <?php } ?>value="0"><?php echo esc_html__( 'Disabled', 'product-sticker' ); ?></option>
			</select>
		</td>
	</tr>
	<tr valign="top">
		<th scope="row"><?php echo esc_html__( 'Custom CSS', 'product-sticker' ); ?></th>
		<td>
			<textarea name="general[css]" rows="4" cols="50"><?php echo esc_html($general['css']); ?></textarea>
		</td>
	</tr>
</table>
<input type="hidden" name="style_custom_id" value="<?php echo esc_html($style_custom_id); ?>" />
<input type="hidden" name="page_options" value="general,style_custom_id" />