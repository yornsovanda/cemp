<?php

add_action('wp_ajax_sp_branch_shortcode', 'sp_branch_shortcode_ajax' );

function sp_branch_shortcode_ajax(){
	$defaults = array(
		'branch' => null
	);
	$args = array_merge( $defaults, $_GET );
	?>

	<div id="sc-branch-form">
			<table id="sc-branch-table" class="form-table">
				<tr>
					<?php $field = 'category_id'; ?>
					<th><label for="<?php echo $field; ?>"><?php _e( 'Select branch location', 'sptheme_admin' ); ?></label></th>
					<td>
						<?php $args = array(
									//'show_option_none' => 'Select category',
									'name' => $field,
									'taxonomy' => 'branch_location'
								);
							wp_dropdown_categories( $args ); ?>
					</td>
				</tr>
				<tr>
					<?php $field = 'zoomlevel'; ?>
					<th><label for="<?php echo $field; ?>"><?php _e( 'Zoom level', 'sptheme_admin' ); ?></label></th>
					<td>
						<input type="text" name="<?php echo $field; ?>" id="<?php echo $field; ?>" value="14" />
					</td>
				</tr>
				<tr>
					<?php $field = 'post_num'; ?>
					<th><label for="<?php echo $field; ?>"><?php _e( 'Number of marker', 'sptheme_admin' ); ?></label></th>
					<td>
						<input type="text" name="<?php echo $field; ?>" id="<?php echo $field; ?>" value="-1" /> <smal>(-1 for show all)</small>
					</td>
				</tr>
			</table>
			<p class="submit">
				<input type="button" id="option-submit" class="button-primary" value="<?php _e( 'Add Branch', 'sptheme_admin' ) ; ?>" name="submit" />
			</p>
	</div>			

	<?php
	exit();	
}
?>