<?php

/*  Initialize the meta boxes.
/* ------------------------------------ */
add_action( 'admin_init', '_custom_meta_boxes' );

function _custom_meta_boxes() {

	$prefix = 'sp_';
  
/*  Custom meta boxes
/* ------------------------------------ */
$page_layout_options = array(
	'id'          => 'page-options',
	'title'       => 'Page Options',
	'desc'        => '',
	'pages'       => array( 'page', 'post' ),
	'context'     => 'normal',
	'priority'    => 'default',
	'fields'      => array(
		array(
			'label'		=> 'Primary Sidebar',
			'id'		=> $prefix . 'sidebar_primary',
			'type'		=> 'sidebar-select',
			'desc'		=> 'Overrides default'
		),
		array(
			'label'		=> 'Layout',
			'id'		=> $prefix . 'layout',
			'type'		=> 'radio-image',
			'desc'		=> 'Overrides the default layout option',
			'std'		=> 'inherit',
			'choices'	=> array(
				array(
					'value'		=> 'inherit',
					'label'		=> 'Inherit Layout',
					'src'		=> SP_ASSETS . '/images/admin/layout-off.png'
				),
				array(
					'value'		=> 'col-1c',
					'label'		=> '1 Column',
					'src'		=> SP_ASSETS . '/images/admin/col-1c.png'
				),
				array(
					'value'		=> 'col-2cl',
					'label'		=> '2 Column Left',
					'src'		=> SP_ASSETS . '/images/admin/col-2cl.png'
				),
				array(
					'value'		=> 'col-2cr',
					'label'		=> '2 Column Right',
					'src'		=> SP_ASSETS . '/images/admin/col-2cr.png'
				)
			)
		)
	)
);

/* ---------------------------------------------------------------------- */
/*	Post and page meta
/* ---------------------------------------------------------------------- */

$masthead_options = array(
	'id'          => 'masthead-setting',
	'title'       => 'Masthead meta',
	'desc'        => '',
	'pages'       => array( 'post', 'page' ),
	'context'     => 'normal',
	'priority'    => 'high',
	'fields'      => array(
		array(
			'label'		=> 'Show page title',
			'id'		=> $prefix . 'is_page_title',
			'desc'		=> 'Option to enable and disable page title',
			'std'		=> 'on',
			'type'		=> 'on-off'
		),
		array(
			'label'		=> 'Show masthead',
			'id'		=> $prefix . 'is_masthead',
			'desc'		=> 'Option to enable and disable masthead',
			'std'		=> 'on',
			'type'		=> 'on-off'
		),
		array(
			'label'		=> 'Custom masthead',
			'id'		=> $prefix . 'is_custom',
			'desc'		=> 'On: will upload new custom masthead, if Off: will use random 7 masthead images.',
			'std'		=> 'off',
			'type'		=> 'on-off',
			'condition' => 'sp_is_masthead:is(on)'
		),
		array(
			'label'		=> 'Upload masthead image',
			'id'		=> $prefix . 'custom_masthead',
			'type'		=> 'upload',
			'desc'		=> 'Image size would be 1024px by 214px',
			'condition' => 'sp_is_custom:is(on)'
		)
	)
);

/* ---------------------------------------------------------------------- */
/*	Post Format: video
/* ---------------------------------------------------------------------- */
$post_format_video = array(
	'id'          => 'format-video',
	'title'       => 'Format: Video',
	'desc'        => 'These settings enable you to embed videos into your posts.',
	'pages'       => array( 'post' ),
	'context'     => 'normal',
	'priority'    => 'high',
	'fields'      => array(
		array(
			'label'		=> 'Video URL',
			'id'		=> $prefix . 'video_url',
			'type'		=> 'text',
			'desc'		=> 'Enter Video Embed URL from youtube, vimeo or dailymotion'
		)
	)
);

/* ---------------------------------------------------------------------- */
/*	Post Format: Audio
/* ---------------------------------------------------------------------- */
$post_format_audio = array(
	'id'          => 'format-audio',
	'title'       => 'Format: Audio',
	'desc'        => 'These settings enable you to embed audio into your posts. You must provide both .mp3 and .ogg/.oga file formats in order for self hosted audio to function accross all browsers.',
	'pages'       => array( 'post' ),
	'context'     => 'normal',
	'priority'    => 'high',
	'fields'      => array(
		array(
			'label'		=> 'Audio URL',
			'id'		=> $prefix . 'audio_url',
			'type'		=> 'upload',
			'desc'		=> 'You can get sound or audio URL from soundcloud'
		)
	)
);

/* ---------------------------------------------------------------------- */
/*	Post Format: Gallery
/* ---------------------------------------------------------------------- */
$post_format_gallery = array(
	'id'          => 'format-gallery',
	'title'       => 'Format: Gallery',
	'desc'        => 'Standard post galleries.</i>',
	'pages'       => array( 'post' ),
	'context'     => 'normal',
	'priority'    => 'high',
	'fields'      => array(
		array(
			'label'		=> 'Upload photo',
			'id'		=> $prefix . 'post_gallery',
			'type'		=> 'gallery',
			'desc'		=> 'Upload photos'
		)
	)
);

/* ---------------------------------------------------------------------- */
/*	Post Format: Chat
/* ---------------------------------------------------------------------- */
$post_format_chat = array(
	'id'          => 'format-chat',
	'title'       => 'Format: Chat',
	'desc'        => 'Input chat dialogue.',
	'pages'       => array( 'post' ),
	'context'     => 'normal',
	'priority'    => 'high',
	'fields'      => array(
		array(
			'label'		=> 'Chat Text',
			'id'		=> $prefix . 'chat',
			'type'		=> 'textarea',
			'rows'		=> '2'
		)
	)
);
/* ---------------------------------------------------------------------- */
/*	Post Format: Link
/* ---------------------------------------------------------------------- */
$post_format_link = array(
	'id'          => 'format-link',
	'title'       => 'Format: Link',
	'desc'        => 'Input your link.',
	'pages'       => array( 'post' ),
	'context'     => 'normal',
	'priority'    => 'high',
	'fields'      => array(
		array(
			'label'		=> 'Link Title',
			'id'		=> $prefix . 'link_title',
			'type'		=> 'text'
		),
		array(
			'label'		=> 'Link URL',
			'id'		=> $prefix . 'link_url',
			'type'		=> 'text'
		)
	)
);

/* ---------------------------------------------------------------------- */
/*	Post Format: quote
/* ---------------------------------------------------------------------- */
$post_format_quote = array(
	'id'          => 'format-quote',
	'title'       => 'Format: Quote',
	'desc'        => 'Input your quote.',
	'pages'       => array( 'post' ),
	'context'     => 'normal',
	'priority'    => 'high',
	'fields'      => array(
		array(
			'label'		=> 'Quote',
			'id'		=> $prefix . 'quote',
			'type'		=> 'textarea',
			'rows'		=> '2'
		),
		array(
			'label'		=> 'Quote Author',
			'id'		=> $prefix . 'quote_author',
			'type'		=> 'text'
		)
	)
);

/* ---------------------------------------------------------------------- */
/*	Home Sliders post type
/* ---------------------------------------------------------------------- */
$post_type_slideshow = array(
	'id'          => 'slideshow-setting',
	'title'       => 'Slideshow meta',
	'desc'        => '',
	'pages'       => array( 'slideshow' ),
	'context'     => 'normal',
	'priority'    => 'high',
	'fields'      => array(
		array(
			'label'		=> 'Link button',
			'id'		=> $prefix . 'slide_btn_name',
			'type'		=> 'text',
			'std'		=> '',
			'desc'		=> 'Name of button link e.g: Learn more'
		),
		array(
			'label'		=> 'Slide URL/Link',
			'id'		=> $prefix . 'slide_btn_url',
			'type'		=> 'text',
			'std'		=> '',
			'desc'		=> 'Enter slide URL'
		)
	)
);

/* ---------------------------------------------------------------------- */
/*	Gallery post type
/* ---------------------------------------------------------------------- */
$post_type_gallery = array(
	'id'          => 'gallery-setting',
	'title'       => 'Upload photos',
	'desc'        => 'These settings enable you to upload photos.',
	'pages'       => array( 'sp_gallery' ),
	'context'     => 'normal',
	'priority'    => 'high',
	'fields'      => array(
		array(
			'label'		=> 'Location',
			'id'		=> $prefix . 'album_location',
			'type'		=> 'text',
			'desc'		=> 'Where this album take photos'
		),
		array(
			'label'		=> 'Upload photo',
			'id'		=> $prefix . 'cp_gallery',
			'type'		=> 'gallery',
			'desc'		=> 'Upload photos'
		),
		array(
			'label'		=> 'Column',
			'id'		=> $prefix . 'col_thumb',
			'type'		=> 'text',
			'std'		=> 2,
			'desc'		=> 'Column number of photo thumbnail'
		)
	)
);

/* ---------------------------------------------------------------------- */
/*	Partner post type
/* ---------------------------------------------------------------------- */
$post_type_partner = array(
	'id'          => 'partner-setting',
	'title'       => 'Partner meta',
	'desc'        => '',
	'pages'       => array( 'sp_partner' ),
	'context'     => 'normal',
	'priority'    => 'high',
	'fields'      => array(
		array(
			'label'		=> 'Logo link',
			'id'		=> $prefix . 'partner_link',
			'type'		=> 'text',
			'desc'		=> 'Enter website address of parnter\' logo'
		)
	)
);

/* ---------------------------------------------------------------------- */
/*	Client post type
/* ---------------------------------------------------------------------- */
$post_type_client = array(
	'id'          => 'client-setting',
	'title'       => 'Client meta',
	'desc'        => '',
	'pages'       => array( 'sp_client' ),
	'context'     => 'normal',
	'priority'    => 'high',
	'fields'      => array(
		array(
			'label'		=> 'Client Cite',
			'id'		=> $prefix . 'client_cite',
			'type'		=> 'text',
			'desc'		=> 'e.g: Manging Director'
		),
		array(
			'label'		=> 'Client Cite Subtext',
			'id'		=> $prefix . 'client_cite_subtext',
			'type'		=> 'text',
			'desc'		=> '(optional) Can be company/organization name e.g: Naga World Hotel'
		)
	)
);

/* ---------------------------------------------------------------------- */
/*	Branch
/* ---------------------------------------------------------------------- */
$post_type_branch = array(
	'id'          => 'branch-meta',
	'title'       => 'Branch meta',
	'desc'        => '',
	'pages'       => array( 'sp_branch' ),
	'context'     => 'normal',
	'priority'    => 'high',
	'fields'      => array(
		array(
			'label'		=> 'Latitude and Longitude',
			'id'		=> $prefix . 'lat_long',
			'type'		=> 'text',
			'desc'		=> 'e.g. 11.544873,104.892167. You can get this value from <a href="http://itouchmap.com/latlong.html" target="_blank">itouchmap</a>'
		),
		array(
			'label'		=> 'Adress',
			'id'		=> $prefix . 'branch_address',
			'type'		=> 'textarea',
			'rows'		=> '2'
		),
		array(
			'label'		=> 'Tel',
			'id'		=> $prefix . 'branch_tel',
			'type'		=> 'text',
			'desc'		=> 'e.g. (+855)-23-990 225 / 10 8888 76'
		),
		array(
			'label'		=> 'E-mail',
			'id'		=> $prefix . 'branch_email',
			'type'		=> 'text',
			'desc'		=> 'e.g. info@domainname.com'
		),
	)
);

/* ---------------------------------------------------------------------- */
/*	Metabox for Home template
/* ---------------------------------------------------------------------- */
$page_template_home = array(
	'id'          => 'home-settings',
	'title'       => 'Home settings',
	'desc'        => '',
	'pages'       => array( 'page' ),
	'context'     => 'normal',
	'priority'    => 'high',
	'fields'      => array(
		array(
			'label'		=> 'Slideshow',
			'id'		=> $prefix . 'slide_options',
			'type'		=> 'tab'
		),
		array(
			'label'		=> 'Number of Slide to show',
			'id'		=> $prefix . 'slide_num',
			'type'		=> 'text',
			'std'		=> '5',
			'desc'		=> 'Enter number of slide e.g. 5'
		),
		array(
			'label'		=> 'Number of Slide to show',
			'id'		=> $prefix . 'slide_effect',
			'type'		=> 'select',
			'std'		=> '',
			'desc'		=> '',
			'choices'     => array( 
	          array(
	            'value'       => 'fade',
	            'label'       => 'Fade',
	            'src'         => ''
	          ),
	          array(
	            'value'       => 'slide',
	            'label'       => 'Slide',
	            'src'         => ''
	          )
	        )
		),
		/*array(
			'label'		=> 'Welcome',
			'id'		=> $prefix . 'welcome_options',
			'type'		=> 'tab'
		), 
		array(
			'label'		=> 'Select Welcome page',
			'id'		=> $prefix . 'welcome_page_id',
			'type'		=> 'page-select',
			'std'		=> '',
			'desc'		=> 'Page that descript welcome or greeting message'
		),*/
		array(
			'label'		=> 'Services',
			'id'		=> $prefix . 'service_options',
			'type'		=> 'tab'
		), 
		array(
			'label'		=> 'Select Service page',
			'id'		=> $prefix . 'service_page_id',
			'type'		=> 'page-select',
			'std'		=> '',
			'desc'		=> 'Page that containe all sub service pages'
		),
		array(
			'label'		=> 'Section title',
			'id'		=> $prefix . 'service_title',
			'type'		=> 'text',
			'std'		=> 'Explore Our Products and Services'
		),
		array(
			'label'		=> 'Description',
			'id'		=> $prefix . 'service_desc',
			'type'		=> 'textarea',
			'rows'      => '2',
			'std'		=> ''
		),
		array(
			'label'		=> 'Number of sub service page to show',
			'id'		=> $prefix . 'service_num',
			'type'		=> 'text',
			'std'		=> '-1',
			'desc'		=> 'Enter number of service e.g. 5'
		),
		/*array(
			'label'		=> 'Background image',
			'id'		=> $prefix . 'process_bg',
			'type'		=> 'upload',
			'std'		=> SP_ASSETS . '/images/bg-business.jpg',
			'desc'		=> 'Upload partern/image background. max.'
		),*/

		array(
			'label'		=> 'Projects',
			'id'		=> $prefix . 'project_options',
			'type'		=> 'tab'
		), 
		array(
			'label'		=> 'Section title',
			'id'		=> $prefix . 'project_title',
			'type'		=> 'text',
			'std'		=> 'Projects'
		),
		array(
			'label'		=> 'Description',
			'id'		=> $prefix . 'project_desc',
			'type'		=> 'textarea',
			'rows'      => '1',
			'std'		=> 'We bring a personal and effective approach to every projects we work on.'
		),
		array(
			'label'		=> 'Partners',
			'id'		=> $prefix . 'partner_options',
			'type'		=> 'tab'
		), 
		array(
			'label'		=> 'Section title',
			'id'		=> $prefix . 'partner_title',
			'type'		=> 'text',
			'std'		=> 'Partners We have Working On'
		),
		array(
			'label'		=> 'Number of parnter\'s logo',
			'id'		=> $prefix . 'partner_num',
			'type'		=> 'text',
			'std'		=> '-1',
			'desc'		=> 'Enter number of logo e.g. 10'
		),
		array(
			'label'		=> 'Clients',
			'id'		=> $prefix . 'client_options',
			'type'		=> 'tab'
		), 
		array(
			'label'		=> 'Section title',
			'id'		=> $prefix . 'client_title',
			'type'		=> 'text',
			'std'		=> 'Happy Clients'
		),
		array(
			'label'		=> 'Client page',
			'id'		=> $prefix . 'client_page_id',
			'type'		=> 'page-select'
		),
		array(
			'label'		=> 'Number of partner\'s logo',
			'id'		=> $prefix . 'client_num',
			'type'		=> 'text',
			'std'		=> '-1',
			'desc'		=> 'Enter number of client message e.g. 10'
		)
	)
);

/* ---------------------------------------------------------------------- */
/*	Return meta box option base on page template selected
/* ---------------------------------------------------------------------- */
function rw_maybe_include() {
	// Include in back-end only
	if ( ! defined( 'WP_ADMIN' ) || ! WP_ADMIN ) {
		return false;
	}

	// Always include for ajax
	if ( defined( 'DOING_AJAX' ) && DOING_AJAX ) {
		return true;
	}

	if ( isset( $_GET['post'] ) ) {
		$post_id = $_GET['post'];
	}
	elseif ( isset( $_POST['post_ID'] ) ) {
		$post_id = $_POST['post_ID'];
	}
	else {
		$post_id = false;
	}

	$post_id = (int) $post_id;
	$post    = get_post( $post_id );

	$template = get_post_meta( $post_id, '_wp_page_template', true );

	return $template;
}

/*  Register meta boxes
/* ------------------------------------ */
	ot_register_meta_box( $post_format_audio );
	ot_register_meta_box( $post_format_chat );
	ot_register_meta_box( $post_format_gallery );
	ot_register_meta_box( $post_format_link );
	ot_register_meta_box( $post_format_quote );
	ot_register_meta_box( $post_format_video );
	ot_register_meta_box( $post_type_slideshow );
	ot_register_meta_box( $post_type_gallery );
	ot_register_meta_box( $post_type_partner );
	ot_register_meta_box( $post_type_client );
	ot_register_meta_box( $post_type_branch );

	$template_file = rw_maybe_include();
	if ( $template_file == 'template-landing.php' ) {
	    ot_register_meta_box( $page_template_home );
	} else {
		ot_register_meta_box( $masthead_options );
		ot_register_meta_box( $page_layout_options );
	}
}