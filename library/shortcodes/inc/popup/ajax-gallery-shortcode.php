<?php

add_action('wp_ajax_sp_gallery_shortcode', 'sp_gallery_shortcode_ajax' );

function sp_gallery_shortcode_ajax(){
	$defaults = array(
		'gallery' => null
	);
	$args = array_merge( $defaults, $_GET );
	?>

	<div id="sc-gallery-form">
			<table id="sc-gallery-table" class="form-table">
				<tr>
					<?php $field = 'album_id'; ?>
					<th><label for="<?php echo $field; ?>"><?php _e( 'Select album: ', 'sptheme_admin' ); ?></label></th>
					<td>
						<select name="<?php echo $field; ?>" id="<?php echo $field; ?>">
							<option class="level-0" value="-1"><?php _e( 'All albums', 'sptheme_admin' ); ?></option>
							<?php
							$args = (array(
								'post_type' => 'sp_gallery',
								'post_per_pages' => -1
							));
							$posts = get_posts( $args );
							foreach ( $posts as $post ) {
								echo '<option class="level-0" value="' . $post->ID . '">' . $post->post_title . '</option>';
							}
							?>
						</select>
					</td>
				</tr>
				<tr>
					<?php $field = 'album_category'; ?>
					<th><label for="<?php echo $field; ?>"><?php _e( 'Select category: ', 'sptheme_admin' ); ?></label></th>
					<td>
						<?php 
							$args = array(
									//'show_option_none' => 'Select category',
									'name' => $field,
									'taxonomy' => 'gallery_category'
								);
							wp_dropdown_categories( $args ); ?>
					</td>
				</tr>
				<tr>
					<?php $field = 'post_num'; ?>
					<th><label for="<?php echo $field; ?>"><?php _e( 'Number of album/photo: ', 'sptheme_admin' ); ?></label></th>
					<td>
						<input type="text" name="<?php echo $field; ?>" id="<?php echo $field; ?>" value="-1" /> <smal>(-1 for show all)</small>
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
				<input type="button" id="option-submit" class="button-primary" value="<?php _e( 'Add Gallery', 'sptheme_admin' ); ?>" name="submit" />
			</p>
	</div>			

	<?php
	exit();	
}
?>