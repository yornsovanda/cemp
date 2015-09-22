<?php
/*
*****************************************************
* Slideshow custom post
*
* CONTENT:
* - 1) Actions and filters
* - 2) Creating a custom post
* - 3) Custom post list in admin
*****************************************************
*/





/*
*****************************************************
*      1) ACTIONS AND FILTERS
*****************************************************
*/
	//ACTIONS
		//Registering CP
		add_action( 'init', 'sp_slideshow_cp_init' );
		//CP list table columns
		add_action( 'manage_posts_custom_column', 'sp_slideshow_cp_custom_column' );

	//FILTERS
		//CP list table columns
		add_filter( 'manage_edit-slideshow_columns', 'sp_slideshow_cp_columns' );




/*
*****************************************************
*      2) CREATING A CUSTOM POST
*****************************************************
*/
	/*
	* Custom post registration
	*/
	if ( ! function_exists( 'sp_slideshow_cp_init' ) ) {
		function sp_slideshow_cp_init() {
			global $cp_menu_position;

			$labels = array(
				'name'               => __( 'Slideshows', 'sptheme_admin' ),
				'singular_name'      => __( 'Slideshow', 'sptheme_admin' ),
				'add_new'            => __( 'Add New', 'sptheme_admin' ),
				'all_items'          => __( 'All Slides', 'sptheme_admin' ),
				'add_new_item'       => __( 'Add New Slide', 'sptheme_admin' ),
				'new_item'           => __( 'Add New Slide', 'sptheme_admin' ),
				'edit_item'          => __( 'Edit Slide', 'sptheme_admin' ),
				'view_item'          => __( 'View Slide', 'sptheme_admin' ),
				'search_items'       => __( 'Search Slide', 'sptheme_admin' ),
				'not_found'          => __( 'No Slide found', 'sptheme_admin' ),
				'not_found_in_trash' => __( 'No Slide found in trash', 'sptheme_admin' ),
				'parent_item_colon'  => __( 'Parent Slide', 'sptheme_admin' ),
			);	

			$role     = 'post'; // page
			$slug     = 'slideshows';
			$supports = array('title', 'editor', 'thumbnail'); // 'title', 'editor', 'thumbnail'

			$args = array(
				'labels' 				=> $labels,
				'rewrite'               => array( 'slug' => $slug ),
				'menu_position'         => $cp_menu_position['menu_slideshow'],
				'menu_icon'           	=> 'dashicons-welcome-view-site',
				'supports'              => $supports,
				'capability_type'     	=> $role,
				'query_var'           	=> true,
				'hierarchical'          => false,
				'public'                => true,
				'show_ui'               => true,
				'show_in_nav_menus'	    => false,
				'publicly_queryable'	=> true,
				'exclude_from_search'   => true,
				'has_archive'			=> false,
				'can_export'			=> true
			);
			register_post_type( 'slideshow' , $args );
		}
	} 


/*
*****************************************************
*      3) CUSTOM POST LIST IN ADMIN
*****************************************************
*/
	/*
	* Registration of the table columns
	*
	* $Cols = ARRAY [array of columns]
	*/
	if ( ! function_exists( 'sp_slideshow_cp_columns' ) ) {
		function sp_slideshow_cp_columns( $columns ) {
			
			$columns['cb']                   	= '<input type="checkbox" />';
			$columns['slideshow_thumbnail'] 	= __( 'Thumbnail', 'sptheme_admin' );
			$columns['title']                	= __( 'Slide Name', 'sptheme_admin' );
			$columns['date'] 					= __( 'Date', 'sptheme_admin' );

			return $columns;
		}
	} // /gallery_cp_columns

	/*
	* Outputting values for the custom columns in the table
	*
	* $Col = TEXT [column id for switch]
	*/
	if ( ! function_exists( 'sp_slideshow_cp_custom_column' ) ) {
		function sp_slideshow_cp_custom_column( $column ) {
			global $post;
			
			switch ( $column ) {
					
				case "slideshow_thumbnail":

					$img_url = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), 'medium' );
					echo '<img src="' . $img_url[0] . '" width="150">';
					
				break;
				
				default:
				break;
			}
		}
	} // /sp_slideshow_cp_custom_column

	
	