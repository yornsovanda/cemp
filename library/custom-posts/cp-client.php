<?php
/*
*****************************************************
* Client custom post
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
		add_action( 'init', 'sp_client_cp_init' );
		//CP list table columns
		add_action( 'manage_posts_custom_column', 'sp_client_cp_custom_column' );

	//FILTERS
		//CP list table columns
		add_filter( 'manage_edit-sp_client_columns', 'sp_client_cp_columns' );




/*
*****************************************************
*      2) CREATING A CUSTOM POST
*****************************************************
*/
	/*
	* Custom post registration
	*/
	if ( ! function_exists( 'sp_client_cp_init' ) ) {
		function sp_client_cp_init() {
			global $cp_menu_position;

			$labels = array(
				'name'               => __( 'Clients', 'sptheme_admin' ),
				'singular_name'      => __( 'Client', 'sptheme_admin' ),
				'add_new'            => __( 'Add New', 'sptheme_admin' ),
				'all_items'          => __( 'Client', 'sptheme_admin' ),
				'add_new_item'       => __( 'Add New Client', 'sptheme_admin' ),
				'new_item'           => __( 'Add New Client', 'sptheme_admin' ),
				'edit_item'          => __( 'Edit Client', 'sptheme_admin' ),
				'view_item'          => __( 'View Client', 'sptheme_admin' ),
				'search_items'       => __( 'Search Client', 'sptheme_admin' ),
				'not_found'          => __( 'No Client found', 'sptheme_admin' ),
				'not_found_in_trash' => __( 'No Client found in trash', 'sptheme_admin' ),
				'parent_item_colon'  => __( 'Parent Client', 'sptheme_admin' ),
			);	

			$role     = 'post'; // page
			$slug     = 'client';
			$supports = array('title', 'editor'); // 'title', 'editor', 'thumbnail'

			$args = array(
				'labels' 				=> $labels,
				'rewrite'               => array( 'slug' => $slug ),
				'menu_position'         => $cp_menu_position['menu_client'],
				'menu_icon'           	=> 'dashicons-format-quote',
				'supports'              => $supports,
				'capability_type'     	=> $role,
				'query_var'           	=> true,
				'hierarchical'          => false,
				'public'                => true,
				'show_ui'               => true,
				'show_in_nav_menus'	    => false,
				'publicly_queryable'	=> true,
				'exclude_from_search'   => false,
				'has_archive'			=> false,
				'can_export'			=> true
			);
			register_post_type( 'sp_client' , $args );
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
	if ( ! function_exists( 'sp_client_cp_columns' ) ) {
		function sp_client_cp_columns( $columns ) {
			
			$columns['cb']                   	= '<input type="checkbox" />';
			$columns['title']                	= __( 'Title', 'sptheme_admin' );
			$columns['date']		 			= __( 'Date', 'sptheme_admin' );

			return $columns;
			
		}
	}

	/*
	* Outputting values for the custom columns in the table
	*
	* $Col = TEXT [column id for switch]
	*/
	if ( ! function_exists( 'sp_client_cp_custom_column' ) ) {
		function sp_client_cp_custom_column( $column ) {
			global $post;
			
			switch ( $column ) {
				/*case "client_thumbnail":
					echo get_the_post_thumbnail( $post->ID, array(50, 50) );
				break;*/
				
				default:
				break;
			}
		}
	} // /sp_client_cp_custom_column

	
	