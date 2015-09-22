<?php

add_action( 'widgets_init', 'sp_featured_page_widget' );
function sp_featured_page_widget() {
	register_widget( 'sp_widget_featured_page' );
}

/*
*****************************************************
*      WIDGET CLASS
*****************************************************
*/

class sp_widget_featured_page extends WP_Widget {
	/*
	*****************************************************
	* widget constructor
	*****************************************************
	*/
	function __construct() {
		$id     = 'sp-widget-featured-page';
		$prefix = SP_THEME_NAME . ': ';
		$name   = '<span>' . $prefix . __( 'Featured Page', 'sptheme_widget' ) . '</span>';
		$widget_ops = array(
			'classname'   => 'sp-widget-featured-page',
			'description' => __( 'A widget that allows to view sub page of another to be hihlight','sptheme_widget' )
			);
		$control_ops = array();

		//$this->WP_Widget( $id, $name, $widget_ops, $control_ops );
		parent::__construct( $id, $name, $widget_ops, $control_ops );
		
	}
		
		
	function widget( $args, $instance) {
		extract ($args);

		global $post;
		
		/* Our variables from the widget settings. */
		$title = apply_filters('widget_title', $instance['title']);
		$style = $instance['style'];
		$parent_page_id = $instance['parent_page_id'];

		$current_parent_page = wp_get_post_parent_id( $post->ID );

		if ( $current_parent_page != $parent_page_id ) {
		
			/* Before widget (defined by themes). */
			$out = $before_widget;

			/* Title of widget (before and after define by theme). */
			if ( $title )
				$out .= $before_title . $title . $after_title;

			$args = array ( 'child_of' => $parent_page_id ); 

			if ( $style == 'slide' ) {
				$out .= sp_slide_featured_page( $args );
			} else {
				$out .= sp_list_featured_page( $args );
			}

		
			/* After widget (defined by themes). */		
			$out .= $after_widget;

			echo $out;

		}
	}	
	
	/**
	 * Update the widget settings.
	 */	
	function update( $new_instance, $old_instance ) {
		$instance = $old_instance;
		
		/* Strip tags for title and name to remove HTML (important for text inputs). */
		$instance['title'] = strip_tags( $new_instance['title'] );
		$instance['style'] = strip_tags( $new_instance['style'] );
		$instance['parent_page_id'] = strip_tags( $new_instance['parent_page_id'] );
		
		return $instance;
	}
	
	/**
	 * Displays the widget settings controls on the widget panel.
	 * Make use of the get_field_id() and get_field_name() function
	 * when creating your form elements. This handles the confusing stuff.
	 */	
	function form( $instance ) {
		/* Set up some default widget settings. */
		$defaults = array( 'title' => 'Page Featured', 'style' => 'list', 'parent_page_id' => '');
		$instance = wp_parse_args( (array) $instance, $defaults); ?>
		
		<p>
		<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e('Title:', 'sptheme_widget') ?></label>
		<input type="text" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" value="<?php echo $instance['title']; ?>"  class="widefat">
		</p>

		<p>
		<label for="<?php echo $this->get_field_id( 'parent_page_id' ); ?>"><?php _e('Select parent page', 'sptheme_widget') ?></label>
		<?php 
			$args = array(
					'name'		=> $this->get_field_name( 'parent_page_id' ),
					'id'		=> $this->get_field_id( 'parent_page_id' ),
					'selected'	=> $instance['parent_page_id']
				);
			wp_dropdown_pages($args); 
		?>
		</p>

		<p>
		<label for="<?php echo $this->get_field_id( 'style' ); ?>"><?php _e('Style', 'sptheme_widget') ?></label>
		<select id="<?php echo $this->get_field_id( 'style' ); ?>" name="<?php echo $this->get_field_name( 'style' ); ?>">
			<option value="list"<?php echo ($instance['style']=='list')?' selected':' selected'; ?>>List</option>
			<option value="slide"<?php echo ($instance['style']=='slide')?' selected':''; ?>>Slide</option>
		</select>
		</p>

        
	   <?php 
    }
} //end class
?>