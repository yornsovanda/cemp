<?php

/**
 * ----------------------------------------------------------------------------------------
 * Set up register menus
 * ----------------------------------------------------------------------------------------
 */
if ( ! function_exists( 'sp_menus_setup' ) ) {
	function sp_menus_setup() {

		/**
		 * Register nav menus.
		 */
		register_nav_menus(
			array(
				'mobile'	=> __( 'Mobile Navigation', SP_TEXT_DOMAIN ),
				'primary'	=> __( 'Main Navigation', SP_TEXT_DOMAIN ),
				'footer'  	=> __( 'Footer Navigation', SP_TEXT_DOMAIN )
			)
		);

	}

	add_action( 'after_setup_theme', 'sp_menus_setup' );
}


/**
 * ----------------------------------------------------------------------------------------
 * Mobile navigation
 * ----------------------------------------------------------------------------------------
 */
if( !function_exists('sp_mobile_navigation')) {

	function sp_mobile_navigation() {
		
		// set default main menu if wp_nav_menu not active
		if ( function_exists ( 'wp_nav_menu' ) ):
			$menu = wp_nav_menu( array(
					'container'      => false,
					'menu_id'		 => 'menu-mobile',
					'menu_class'	 => 'mobile-nav',
					'theme_location' => 'mobile',
					'fallback_cb' 	 => 'sp_mobile_nav_fallback',
					'echo'           => false,
					) );
			/* Adding "+" buttons for dropdown menus */
			$search = '<ul class="sub-menu">';
			$replace = '<span class="nav-child-container"><span class="nav-child-trigger"></span></span>
						<ul class="sub-menu" style="height: 0;">';
			return str_replace($search, $replace, $menu);		
		else:
			sp_mobile_nav_fallback();	
		endif;
	}
}

if (!function_exists('sp_mobile_nav_fallback')) {
	
	function sp_mobile_nav_fallback() {
    	
		$menu_html = '<ul id="menu-mobile" class="mobile-nav">';
		$menu_html .= '<li><a href="'.admin_url('nav-menus.php').'">'.esc_html__('Add Mobile menu', SP_TEXT_DOMAIN).'</a></li>';
		$menu_html .= '</ul>';
		echo $menu_html;
		
	}
	
}

/**
 * ----------------------------------------------------------------------------------------
 * Main navigation
 * ----------------------------------------------------------------------------------------
 */
if( !function_exists('sp_main_navigation')) {

	function sp_main_navigation() {
		
		// set default main menu if wp_nav_menu not active
		if ( function_exists ( 'wp_nav_menu' ) )
			wp_nav_menu( array(
				'container'      => false,
				'menu_id'	 	 => 'menu-primary',
				'menu_class'	 => 'primary-nav',
				'theme_location' => 'primary',
				'fallback_cb' 	 => 'sp_main_nav_fallback'
				) );
		else
			sp_main_nav_fallback();	
	}
}

if (!function_exists('sp_main_nav_fallback')) {
	
	function sp_main_nav_fallback() {
    	
		$menu_html = '<ul class="primary-nav">';
		$menu_html .= '<li><a href="'.admin_url('nav-menus.php').'">'.esc_html__('Add Main menu', SP_TEXT_DOMAIN).'</a></li>';
		$menu_html .= '</ul>';
		echo $menu_html;
		
	}
	
}

/**
 * ----------------------------------------------------------------------------------------
 * Footer navigation
 * ----------------------------------------------------------------------------------------
 */
if( !function_exists('sp_footer_navigation')) {

	function sp_footer_navigation() {
		
		// set default footer menu if wp_nav_menu not active
		if ( function_exists ( 'wp_nav_menu' ) )
			wp_nav_menu( array(
				'container'      => false,
				'menu_id'		 => 'menu-footer',
				'menu_class'	 => 'footer-nav',
				'theme_location' => 'footer',
				'fallback_cb' => 'sp_footer_nav_fallback'
				) );
		else
			sp_footer_nav_fallback();	
	}
}

if (!function_exists('sp_footer_nav_fallback')) {
	
	function sp_footer_nav_fallback() {
    	
		$menu_html = '<ul class="footer-nav">';
		$menu_html .= '<li><a href="'.admin_url('nav-menus.php').'">'.esc_html__('Add footer menu', SP_TEXT_DOMAIN).'</a></li>';
		$menu_html .= '</ul>';
		echo $menu_html;
		
	}
	
}

