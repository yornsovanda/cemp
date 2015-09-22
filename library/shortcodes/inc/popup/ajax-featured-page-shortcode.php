<?php

add_action('wp_ajax_sp_featured_page_shortcode', 'sp_featured_page_shortcode_ajax' );

function sp_featured_page_shortcode_ajax(){
	$defaults = array(
		'featured_page' => null
	);
	$args = array_merge( $defaults, $_GET );
	?>

	<div id="sc-featured_page-form">
			<table id="sc-featured_page-table" class="form-table">
				<tr>
					<?php $field = 'parent_page_id'; ?>
					<th><label for="<?php echo $field; ?>"><?php _e( 'Parent page', 'sptheme_admin' ); ?></label></th>
					<td>
						<?php wp_dropdown_pages( array( 'name' => $field ) ); ?>
					</td>
				</tr>
				<tr>
					<?php $field = 'column'; ?>
					<th><label for="<?php echo $field; ?>"><?php _e( 'Columns', 'sptheme_admin' ); ?></label></th>
					<td>
						<select name="<?php echo $field; ?>" id="<?php echo $field; ?>">
							<option value="" selected>None</option>
							<option value="2">2</option>
							<option value="3">3</option>
							<option value="4">4</option>
						</select>
					</td>
				</tr>
			</table>
			<p class="submit">
				<input type="button" id="option-submit" class="button-primary" value="<?php _e( 'Add Featured Page', 'sptheme_admin' ) ; ?>" name="submit" />
			</p>
	</div>			

	<?php
	exit();	
}
?>