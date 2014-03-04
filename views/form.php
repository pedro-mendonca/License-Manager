<?php
if ( ! defined( 'ABSPATH' ) ) {
	header( 'HTTP/1.0 403 Forbidden' );
	die;
} 
?>
<h3>
	<?php printf( __( "%s: License Settings", $this->text_domain ), $this->item_name ); ?>&nbsp; &nbsp; 
</h3>
<?php 

// Output form tags if we're not embedded in another form
if( ! $embedded ) { 
	echo '<form method="post" action="">';
}

wp_nonce_field( $nonce_name, $nonce_name ); ?>
<table class="form-table" id="yoast-license-form">
	<tbody>
		<tr valign="top">
			<th scope="row" valign="top"><?php _e( 'License status', $this->text_domain ); ?></th>
			<td>
				<?php if( $this->license_is_valid() ) { ?>
				<span style="color: white; background: limegreen; padding:3px 6px;">ACTIVE</span> &nbsp; - &nbsp; you are receiving updates.
				<?php } else { ?>
				<span style="color:white; background: red; padding: 3px 6px;">INACTIVE</span> &nbsp; - &nbsp; you are <strong>not</strong> receiving updates.
				<?php } ?>
			</td>
		</tr>
		<tr valign="top">
			<th scope="row" valign="top"><?php _e('Toggle license status', $this->text_domain ); ?></th>
			<td id="yoast-license-toggler">

				<?php if( $this->license_is_valid() ) { ?>
					<button name="<?php echo esc_attr( $action_name ); ?>" type="submit" class="button-secondary yoast-license-deactivate" value="deactivate"><?php echo esc_html_e( 'Deactivate License', $this->text_domain ); ?></button> &nbsp; 
					<small><?php _e( '(deactivate your license so you can activate it on another WordPress site)', $this->text_domain ); ?></small>
				<?php } else { 

					if( $this->get_license_key() !== '') { ?>
						<button name="<?php echo esc_attr( $action_name ); ?>" type="submit" class="button-secondary yoast-license-activate" value="activate" /><?php echo esc_html_e('Activate License', $this->text_domain ); ?></button> &nbsp; 
					<?php } else {
						_e( 'Please enter a license key in the field below first.', $this->text_domain );
					} 

				} ?>

			</td>
		</tr>
		<tr valign="top">
			<th scope="row" valign="top"><?php _e( 'License Key', $this->text_domain ); ?></th>
			<td>
				<input id="yoast-license-key-field" name="<?php echo esc_attr( $key_name ); ?>" type="text" class="regular-text <?php if( $obfuscate ) { ?>yoast-license-obfuscate<?php } ?>" value="<?php echo esc_attr( $visible_license_key ); ?>" placeholder="<?php echo esc_attr( sprintf( __( 'Paste your %s license key here..', $this->text_domain ), $this->item_name ) ); ?>" <?php if( $readonly ) { echo 'readonly="readonly"'; } ?> />
				<?php if( $this->license_constant_is_defined ) { ?>
				<p class="help"><?php printf( __( "You defined your license key using the %s PHP constant.", $this->text_domain ), '<code>' . $this->license_constant_name . '</code>' ); ?></p>
				<?php } ?>
			</td>
		</tr>

	</tbody>
</table>

<?php 	
// Only show a "Save Changes" button and end form if we're not embedded in another form.
if( ! $embedded ) {

	// only show "Save Changes" button if license is not activated and not defined with a constant
	if( $readonly === false ) {
		submit_button();
	} 

	echo '</form>';
}
