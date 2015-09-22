<?php

/**
 * ----------------------------------------------------------------------------------------
 * Makes some changes to the <title> tag, by filtering the output of wp_title()
 * ----------------------------------------------------------------------------------------
 */
if( !function_exists('sp_filter_wp_title')) {

	function sp_filter_wp_title( $title, $separator ) {

		if ( is_feed() ) return $title;

		global $paged, $page;

		if ( is_search() ) {
			$title = sprintf(__('Search results for %s', SP_TEXT_DOMAIN), '"' . get_search_query() . '"');

			if ( $paged >= 2 )
				$title .= " $separator " . sprintf(__('Page %s', SP_TEXT_DOMAIN), $paged);

			$title .= " $separator " . get_bloginfo('name', 'display');

			return $title;
		}

		$title .= get_bloginfo('name', 'display');
		$site_description = get_bloginfo('description', 'display');

		if ( $site_description && ( is_home() || is_front_page() ) )
			$title .= " $separator " . $site_description;

		if ( $paged >= 2 || $page >= 2)
			$title .= " $separator " . sprintf(__('Page %s', SP_TEXT_DOMAIN), max($paged, $page) );

		return $title;

	}
	add_filter('wp_title', 'sp_filter_wp_title', 10, 2);

}

/**
 * ----------------------------------------------------------------------------------------
 * Start content wrap
 * ----------------------------------------------------------------------------------------
 */
if ( !function_exists('sp_start_content_wrap') ) {

	add_action( 'sp_start_content_wrap_html', 'sp_start_content_wrap' );

	function sp_start_content_wrap() {
		echo '<section id="content">' . "\n";
		echo '<div class="container clearfix">' . "\n";
	}
	
}

/**
 * ----------------------------------------------------------------------------------------
 * End content wrap
 * ----------------------------------------------------------------------------------------
 */
if ( !function_exists('sp_end_content_wrap') ) {

	add_action( 'sp_end_content_wrap_html', 'sp_end_content_wrap' );

	function sp_end_content_wrap() {
		echo '</div>' . "\n";
		echo '</section> <!-- #content .container .clearfix -->';
	}

}

/**
 * ----------------------------------------------------------------------------------------
 * Displays a page pagination
 * ----------------------------------------------------------------------------------------
 */

if ( !function_exists('sp_pagination') ) {

	function sp_pagination( $pages = '', $range = 2 ) {

		$showitems = ( $range * 2 ) + 1;

		global $paged, $wp_query;

		if( empty( $paged ) )
			$paged = 1;

		if( $pages == '' ) {

			$pages = $wp_query->max_num_pages;

			if( !$pages )
				$pages = 1;

		}

		if( 1 != $pages ) {

			$output = '<nav class="pagination">';

			// if( $paged > 2 && $paged >= $range + 1 /*&& $showitems < $pages*/ )
				// $output .= '<a href="' . get_pagenum_link( 1 ) . '" class="next">&laquo; ' . __('First', 'sptheme_admin') . '</a>';

			if( $paged > 1 /*&& $showitems < $pages*/ )
				$output .= '<a href="' . get_pagenum_link( $paged - 1 ) . '" class="next">&larr; ' . __('Previous', SP_TEXT_DOMAIN) . '</a>';

			for ( $i = 1; $i <= $pages; $i++ )  {

				if ( 1 != $pages && ( !( $i >= $paged + $range + 1 || $i <= $paged - $range - 1) || $pages <= $showitems ) )
					$output .= ( $paged == $i ) ? '<span class="current">' . $i . '</span>' : '<a href="' . get_pagenum_link( $i ) . '">' . $i . '</a>';

			}

			if ( $paged < $pages /*&& $showitems < $pages*/ )
				$output .= '<a href="' . get_pagenum_link( $paged + 1 ) . '" class="prev">' . __('Next', SP_TEXT_DOMAIN) . ' &rarr;</a>';

			// if ( $paged < $pages - 1 && $paged + $range - 1 <= $pages /*&& $showitems < $pages*/ )
				// $output .= '<a href="' . get_pagenum_link( $pages ) . '" class="prev">' . __('Last', 'sptheme_admin') . ' &raquo;</a>';

			$output .= '</nav>';

			return $output;

		}

	}

}

/**
 * ----------------------------------------------------------------------------------------
 * Comment Template
 * ----------------------------------------------------------------------------------------
 */
if ( ! function_exists( 'sp_comment_template' ) ) {

	function sp_comment_template( $comment, $args, $depth ) {
		global $retina;
		$GLOBALS['comment'] = $comment;
		switch ( $comment->comment_type ) :
			case '' :
		?>

		<li id="comment-<?php comment_ID(); ?>" class="comment clearfix">

			<?php $av_size = isset($retina) && $retina === 'true' ? 96 : 48; ?>
			
			<div class="user"><?php echo get_avatar( $comment, $av_size, $default=''); ?></div>

			<div class="message">
				
				<?php comment_reply_link( array_merge( $args, array( 'depth' => $depth, 'max_depth' => 3 ) ) ); ?>

				<div class="info">
					<h4><?php echo (get_comment_author_url() != '' ? comment_author_link() : comment_author()); ?></h4>
					<span class="meta"><?php echo comment_date('F jS, Y \a\t g:i A'); ?></span>
				</div>

				<?php comment_text(); ?>
				
				<?php if ( $comment->comment_approved == '0' ) : ?>
					<em class="await"><?php _e( 'Your comment is awaiting moderation.', 'goodwork' ); ?></em>
				<?php endif; ?>

			</div>

		</li>

		<?php
			break;
			case 'pingback'  :
			case 'trackback' :
		?>
		
		<li class="post pingback">
			<p><?php _e( 'Pingback:', 'goodwork' ); ?> <?php comment_author_link(); ?><?php edit_comment_link( __('(Edit)', 'goodwork'), ' ' ); ?></p></li>
		<?php
				break;
		endswitch;
	}
	
}

/**
 * ----------------------------------------------------------------------------------------
 * Ajaxify Comments
 * ----------------------------------------------------------------------------------------
 */

add_action('comment_post', 'ajaxify_comments',20, 2);
function ajaxify_comments($comment_ID, $comment_status){
	if(!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest'){
	//If AJAX Request Then
		switch($comment_status){
			case '0':
				//notify moderator of unapproved comment
				wp_notify_moderator($comment_ID);
			case '1': //Approved comment
				echo "success";
				$commentdata=&get_comment($comment_ID, ARRAY_A);
				$post=&get_post($commentdata['comment_post_ID']); 
				wp_notify_postauthor($comment_ID, $commentdata['comment_type']);
			break;
			default:
				echo "error";
		}
		exit;
	}
}

/**
 * ----------------------------------------------------------------------------------------
 * Get thumbnail post
 * ----------------------------------------------------------------------------------------
 */
if( !function_exists('sp_post_thumbnail') ) {

	function sp_post_thumbnail( $size = 'thumbnail'){
			global $post;
			$thumb = '';

			//get the post thumbnail;
			$thumb_id = get_post_thumbnail_id($post->ID);
			$thumb_url = wp_get_attachment_image_src($thumb_id, $size);
			$thumb = $thumb_url[0];
			if ($thumb) return $thumb;
	}		

}

/**
 * ----------------------------------------------------------------------------------------
 * Get images attached info by attached id
 * ----------------------------------------------------------------------------------------
 */
if ( !function_exists('sp_get_post_attachment') ) {

	function sp_get_post_attachment( $attachment_id ) {

		$attachment = get_post( $attachment_id );
		return array(
			'alt' => get_post_meta( $attachment->ID, '_wp_attachment_image_alt', true ),
			'caption' => $attachment->post_excerpt,
			'description' => $attachment->post_content,
			'href' => get_permalink( $attachment->ID ),
			'src' => $attachment->guid,
			'title' => $attachment->post_title
		);
	}

}

/**
 * ----------------------------------------------------------------------------------------
 * Switch column number to grid base class
 * ----------------------------------------------------------------------------------------
 */
if ( ! function_exists( 'sp_column_class' ) ) {
	function sp_column_class( $column = 'none' ){
		switch ( $column ) {
			case 2:
				$out = 'two-fourth';
				break;
			case 3:
				$out = 'one-third';
				break;
			case 4:
				$out = 'one-fourth';
				break;	
			default:
				$out = 'column-none';	
		}

		return $out;
	}
}

/**
 * ----------------------------------------------------------------------------------------
 * Excerpt ending
 * ----------------------------------------------------------------------------------------
 */
if ( ! function_exists( 'sp_excerpt_more' ) ) {

	add_filter( 'excerpt_more', 'sp_excerpt_more' );

	function sp_excerpt_more( $more ) {
		global $post;
   		$out = ' &#46;&#46;&#46;';
   		$out .= '<a class="more" href="'. get_permalink($post->ID) . '">' . __( 'Read More', SP_TEXT_DOMAIN ) . '</a>';

   		return $out;
	}
	
}

/**
 * ----------------------------------------------------------------------------------------
 * Excerpt length
 * ----------------------------------------------------------------------------------------
 */
if ( ! function_exists( 'sp_excerpt_length' ) ) {

	add_filter( 'excerpt_length', 'sp_excerpt_length', 999 );

	function sp_excerpt_length( $length ) {
		return ot_get_option('excerpt-length',$length);
	}
	
}

/**
 * ----------------------------------------------------------------------------------------
 * Print HTML with meta information for the current post-date/time and author
 * ----------------------------------------------------------------------------------------
 */
if ( !function_exists('sp_meta_posted_on') ) {

	function sp_meta_posted_on() {
		printf( __( '<i class="icon icon-calendar-1"></i><a href="%1$s" title="%2$s"><time class="entry-date" datetime="%3$s"> %4$s</time></a><span class="by-author"> by </span><span class="author vcard"><a class="url fn n" href="%5$s" title="%6$s" rel="author">%7$s</a></span><span class="posted-in"> in </span><i class="icon icon-tag"> </i> %8$s ', SP_TEXT_DOMAIN ),
			esc_url( get_permalink() ),
			esc_attr( get_the_time() ),
			esc_attr( get_the_date( 'c' ) ),
			esc_html( get_the_date() ),
			esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ),
			esc_attr( sprintf( __( 'View all posts by %s', SP_TEXT_DOMAIN ), get_the_author() ) ),
			get_the_author(),
			get_the_category_list( ', ' )
		);
		if ( ! post_password_required() && ( comments_open() || get_comments_number() ) )  : ?>
				<span class="with-comments"><?php _e( ' with ', SP_TEXT_DOMAIN ); ?></span>
				<span class="comments-link"><?php comments_popup_link( '<span class="leave-reply">' . __( '0 Comments', SP_TEXT_DOMAIN ) . '</span>', __( '1 Comment', SP_TEXT_DOMAIN ), __( '<i class="icon icon-comment-1"></i> % Comments', SP_TEXT_DOMAIN ) ); ?></span>
		<?php endif; // End if comments_open() ?>
		<?php edit_post_link( __( 'Edit', SP_TEXT_DOMAIN ), '<span class="sep"> | </span><span class="edit-link">', '</span>' );
	}
}

/**
 * ----------------------------------------------------------------------------------------
 * Embeded add video from youtube, vimeo and dailymotion
 * ----------------------------------------------------------------------------------------
 */
function sp_get_video_img($url) {
	
	$video_url = @parse_url($url);
	$output = '';

	if ( $video_url['host'] == 'www.youtube.com' || $video_url['host']  == 'youtube.com' ) {
		parse_str( @parse_url( $url, PHP_URL_QUERY ), $my_array_of_vars );
		$video_id =  $my_array_of_vars['v'] ;
		$output .= 'http://img.youtube.com/vi/'.$video_id.'/0.jpg';
	}elseif( $video_url['host'] == 'www.youtu.be' || $video_url['host']  == 'youtu.be' ){
		$video_id = substr(@parse_url($url, PHP_URL_PATH), 1);
		$output .= 'http://img.youtube.com/vi/'.$video_id.'/0.jpg';
	}
	elseif( $video_url['host'] == 'www.vimeo.com' || $video_url['host']  == 'vimeo.com' ){
		$video_id = (int) substr(@parse_url($url, PHP_URL_PATH), 1);
		$hash = unserialize(file_get_contents("http://vimeo.com/api/v2/video/$video_id.php"));
		$output .=$hash[0]['thumbnail_large'];
	}
	elseif( $video_url['host'] == 'www.dailymotion.com' || $video_url['host']  == 'dailymotion.com' ){
		$video = substr(@parse_url($url, PHP_URL_PATH), 7);
		$video_id = strtok($video, '_');
		$output .='http://www.dailymotion.com/thumbnail/video/'.$video_id;
	}

	return $output;
	
}

/**
 * ----------------------------------------------------------------------------------------
 * Embeded add video from youtube, vimeo and dailymotion
 * ----------------------------------------------------------------------------------------
 */
function sp_add_video ($url, $width = 620, $height = 349) {

	$video_url = @parse_url($url);
	$output = '';

	if ( $video_url['host'] == 'www.youtube.com' || $video_url['host']  == 'youtube.com' ) {
		parse_str( @parse_url( $url, PHP_URL_QUERY ), $my_array_of_vars );
		$video =  $my_array_of_vars['v'] ;
		$output .='<iframe width="'.$width.'" height="'.$height.'" src="http://www.youtube.com/embed/'.$video.'?rel=0" frameborder="0" allowfullscreen></iframe>';
	}
	elseif( $video_url['host'] == 'www.youtu.be' || $video_url['host']  == 'youtu.be' ){
		$video = substr(@parse_url($url, PHP_URL_PATH), 1);
		$output .='<iframe width="'.$width.'" height="'.$height.'" src="http://www.youtube.com/embed/'.$video.'?rel=0" frameborder="0" allowfullscreen></iframe>';
	}
	elseif( $video_url['host'] == 'www.vimeo.com' || $video_url['host']  == 'vimeo.com' ){
		$video = (int) substr(@parse_url($url, PHP_URL_PATH), 1);
		$output .='<iframe src="http://player.vimeo.com/video/'.$video.'" width="'.$width.'" height="'.$height.'" frameborder="0" webkitAllowFullScreen mozallowfullscreen allowFullScreen></iframe>';
	}
	elseif( $video_url['host'] == 'www.dailymotion.com' || $video_url['host']  == 'dailymotion.com' ){
		$video = substr(@parse_url($url, PHP_URL_PATH), 7);
		$video_id = strtok($video, '_');
		$output .='<iframe frameborder="0" width="'.$width.'" height="'.$height.'" src="http://www.dailymotion.com/embed/video/'.$video_id.'"></iframe>';
	}

	return $output;
}

/**
 * ----------------------------------------------------------------------------------------
 * Embeded soundcloud
 * ----------------------------------------------------------------------------------------
 */

function sp_soundcloud($url , $autoplay = 'false' ) {
	return '<iframe width="100%" height="166" scrolling="no" frameborder="no" src="https://w.soundcloud.com/player/?url='.$url.'&amp;auto_play='.$autoplay.'&amp;show_artwork=true"></iframe>';
}

function sp_portfolio_grid( $col = 'list', $posts_per_page = 5 ) {
	
	$temp ='';
	$output = '';
	
	$args = array(
			'posts_per_page' => (int) $posts_per_page,
			'post_type' => 'portfolio',
			);
			
	$post_list = new WP_Query($args);
		
	ob_start();
	if ($post_list && $post_list->have_posts()) {
		
		$output .= '<ul class="portfolio ' . $col . '">';
		
		while ($post_list->have_posts()) : $post_list->the_post();
		
		$output .= '<li>';
		$output .= '<div class="two-fourth"><div class="post-thumbnail">';
		$output .= '<a href="'.get_permalink().'"><img src="' . sp_post_thumbnail('portfolio-2col') . '" /></a>';
		$output .= '</div></div>';
		
		$output .= '<div class="two-fourth last">';
		$output .= '<a href="'.get_permalink().'" class="port-'. $col .'-title">' . get_the_title() .'</a>';
		$output .= '</div>';	
		
		$output .= '</li>';	
		endwhile;
		
		$output .= '</ul>';
		
	}
	$temp = ob_get_clean();
	$output .= $temp;
	
	wp_reset_postdata();
	
	return $output;
	
}

/**
 * ----------------------------------------------------------------------------------------
 * Get Most Racent posts from Category
 * ----------------------------------------------------------------------------------------
 */
if ( ! function_exists( 'sp_last_posts_cat' ) ) {
	function sp_last_posts_cat( $post_num = 5 , $thumb = true , $category = 1 ) {

		global $post;
		
		$out = '';
		if ( is_singular() ) :
			$args = array( 'cat' => $category, 'posts_per_page' => (int) $post_num, 'post__not_in' => array($post->ID) );	
		else : 
			$args = array( 'cat' => $category, 'posts_per_page' => (int) $post_num, 'post__not_in' => get_option( 'sticky_posts' ) );
		endif;
		

		$custom_query = new WP_Query( $args );

		$out .= '<section class="custom-posts clearfix">';
		if( $custom_query->have_posts() ) :
			while ( $custom_query->have_posts() ) : $custom_query->the_post();

			$out .= '<article>';
			$out .= '<a href="' . get_permalink() . '" class="clearfix">';
			if ( $thumb ) :
				if ( has_post_thumbnail() ) {
					$out .= get_the_post_thumbnail();
				} else {
					$out .= '<img class="wp-image-placeholder" src="' . SP_ASSETS .'/images/placeholder/thumbnail-300x225.gif">';	
				}
			endif;
			$out .= '<h5>' . get_the_title() . '</h5>';
			$out .= '<span class="time">' . get_the_time('j M, Y') . '</span>';
			$out .= '</a>';
			$out .= '</article>';

			endwhile; wp_reset_postdata();
		endif;
		$out .= '<a href="' . esc_url(get_category_link( $category )) . '" class="more">' . __('More news', SP_TEXT_DOMAIN) .'</a>';
		$out .= '</section>';

		return $out;
	}
}	

/**
 * ----------------------------------------------------------------------------------------
 * Render HTML Featured Page
 * ----------------------------------------------------------------------------------------
 */

/**
 * Render Featured Page as Grid Style
 *
 * @return 	string
 *
 */

if ( ! function_exists( 'sp_grid_featured_page' ) ) {
	function sp_grid_featured_page( $args, $column = 2 ){
		global $post;

		$defaults = array(
				'child_of' => 0,
				'sort_column' => 'menu_order'
			);
		$args = wp_parse_args( $args, $defaults );
		extract( $args );

		$featured_pages = get_pages( $args );

		if ( $featured_pages ) :

		$out = '<div class="featured-page clearfix sp-grid">';	

		foreach ( $featured_pages as $page ) {
			$thumb_url = wp_get_attachment_image_src( get_post_thumbnail_id( $page->ID ), 'large' );
            $image_url = aq_resize( $thumb_url[0], '580', '390', true);

			$out .= '<figure class="' . sp_column_class($column) . ' effect-vanda">';
			$out .= '<img src="' . $image_url . '">';
			$out .= '<figcaption>';
			$out .= '<div>';
			$out .= '<h4>' . $page->post_title . '</h4>';
			$out .= '</div>';
			$out .= '<a href="'.get_permalink( $page->ID ).'"><span>View more</span></a>';
			$out .= '</figcpation>';
			$out .= '</figure>';
		}

		$out .= '</div>';

		endif;

		return $out;	
	}
}

/**
 * Render Featured Page as List Style
 *
 * @return 	string
 *
 */

if ( ! function_exists( 'sp_list_featured_page' ) ) {
	function sp_list_featured_page( $args ){
		global $post;

		$defaults = array(
				'child_of' 		=> 0,
				'sort_column' 	=> 'menu_order',
				'exclude'		=> $post->ID
			);
		$args = wp_parse_args( $args, $defaults );
		extract( $args );

		$featured_pages = get_pages( $args );

		if ( $featured_pages ) :

		$out = '<div class="featured-page clearfix sp-grid">';	

		foreach ( $featured_pages as $page ) {
			$thumb_url = wp_get_attachment_image_src( get_post_thumbnail_id( $page->ID ), 'large' );
            $image_url = aq_resize( $thumb_url[0], '580', '290', true);

			$out .= '<figure class="effect-vanda">';
			$out .= '<img src="' . $image_url . '">';
			$out .= '<figcaption>';
			$out .= '<div>';
			$out .= '<h4>' . $page->post_title . '</h4>';
			$out .= '</div>';
			$out .= '<a href="'.get_permalink( $page->ID ).'"><span>View more</span></a>';
			$out .= '</figcpation>';
			$out .= '</figure>';
		}

		$out .= '</div>';

		endif;

		return $out;	
	}
}

/**
 * Render Featured Page as slideshow
 *
 * @return 	string
 *
 */

if ( ! function_exists( 'sp_slide_featured_page' ) ) {
	function sp_slide_featured_page( $args ){
		global $post;

		$defaults = array(
				'child_of' 		=> 0,
				'sort_column' 	=> 'menu_order',
				'exclude'		=> $post->ID
			);
		$args = wp_parse_args( $args, $defaults );
		extract( $args );

		$out = '';
		$featured_pages = get_pages( $args );

		if ( $featured_pages ) : 

		$out .='<script type="text/javascript">
			jQuery(document).ready(function($){
				$("#featured-page").flexslider({
					animation: "slide",
					slideshowSpeed: 5000,
					animationDuration: 200,
					animationLoop: true,
					pauseOnAction: true,
					pauseOnHover: true,
					controlNav: false
				});
			});		
		</script>';

		
		$out .= '<div id="featured-page" class="featured-page clearfix sp-grid flexslider">';	
		$out .= '<ul class="slides">';
		foreach ( $featured_pages as $page ) {
			$thumb_url = wp_get_attachment_image_src( get_post_thumbnail_id( $page->ID ), 'large' );
            $image_url = aq_resize( $thumb_url[0], '580', '290', true);

            $out .= '<li>';
			$out .= '<figure class="effect-vanda">';
			$out .= '<img src="' . $image_url . '">';
			$out .= '<figcaption>';
			$out .= '<div>';
			$out .= '<h4>' . $page->post_title . '</h4>';
			$out .= '</div>';
			$out .= '<a href="'.get_permalink( $page->ID ).'"><span>View more</span></a>';
			$out .= '</figcpation>';
			$out .= '</figure>';
			$out .= '</li>';
		}
		$out .= '</ul>';
		$out .= '</div>';

		endif;

		return $out;	
	}
}

/**
 * ----------------------------------------------------------------------------------------
 * Render HTML Slideshow post type
 * ----------------------------------------------------------------------------------------
 *
 * @return 	string
 *
 */

if ( ! function_exists( 'sp_get_slideshow_post' ) ) {
	function sp_get_slideshow_post( $args = array(), $effect = 'fade' ) {
		global $post;

		$post_slides = get_posts( $args ); ?>
		<script type="text/javascript">
			jQuery(document).ready(function($){
				$("#home-slider").flexslider({
					animation: "<?php echo $effect; ?>",
					slideshowSpeed: 5000,
					animationDuration: 200,
					animationLoop: true,
					pauseOnAction: true,
					pauseOnHover: true,
					controlNav: false,
					before: function(slider) {
                    $(".flex-caption").delay(100).fadeOut(100);
                    },
                    after: function(slider) {
                      $(".flex-active-slide").find(".flex-caption").delay(200).fadeIn(400);
                    }	
				});
			});		
		</script>
		<?php
	    $out = '<div id="home-slider" class="flexslider">';
	    $out .= '<ul class="slides">';
	    foreach ($post_slides as $post ) : setup_postdata( $post ); 
	        
	        $learn_more_btn = get_post_meta( $post->ID, 'sp_slide_btn_name', true );
	        $learn_more_link = get_post_meta( $post->ID, 'sp_slide_btn_url', true );

	        $thumb_url = sp_post_thumbnail('large');
	        $image_url = aq_resize( $thumb_url, '1280', '567', true);
	        
	        $caption = get_the_content();

	        $out .= '<li>';
	        $out .= '<img src="' . $image_url . '">';
	        if ( !empty($caption) ) {
	        $out .= '<div class="flex-caption clearfix">';
	        $out .= '<div class="caption-inner">';
	        $out .= '<div class="caption-holder">';
	        $out .= '<h2>' . get_the_title() . '</h2>';
	        $out .= wpautop(get_the_content());
	        $out .= '<a class="learn-more button" href="' . $learn_more_link . '">' . $learn_more_btn . '</a>';
	        $out .= '</div>';
	        $out .= '</div>';
	        $out .= '</div>';
	    	}
	        $out .= '</li>';
	    endforeach;
	    wp_reset_postdata();

	    $out .= '</ul>';
	    $out .= '</div>';

		return $out;	
	}
}

/**
 * ----------------------------------------------------------------------------------------
 * Render Gallery Post Type
 * ----------------------------------------------------------------------------------------
 */

/**
 * Render Cover Albums as Grid Style
 *
 * @return 	string
 *
 */
 
if ( ! function_exists( 'sp_grid_cover_albums' ) ) {
	function sp_grid_cover_albums( $args = array(), $column = 2 ) {

		$defaults = array(
				'post_type' 		=> 'sp_gallery',
				'posts_per_page'	=> -1
			);
		$args = wp_parse_args( $args, $defaults );
		extract( $args );

		$custom_query = new WP_Query($args);

		if ( $custom_query->have_posts() ):
			$out = '<div class="clearfix sp-grid">';
			while ( $custom_query->have_posts() ) : $custom_query->the_post();

				$thumb_url = sp_post_thumbnail('large');
	        	$image_url = aq_resize( $thumb_url, '470', '316', true);

				$out .= '<figure class="' . sp_column_class($column) . ' effect-soda">';
				$out .= '<img src="' . $image_url . '">';
				$out .= '<figcaption>';
				$out .= '<h4>' . get_the_title() . '</h4>';
				$out .= '<p>';
				$out .= get_post_meta( get_the_ID(), 'sp_album_location', true);
				$out .= '<br>' . get_the_date('F j, Y');
				$out .= '</p>'; 
				$out .= '<a href="'.get_permalink().'"><span>View more</span></a>';
				$out .= '</figcpation>';
				$out .= '</figure>';

			endwhile;
			wp_reset_postdata();
			$out .= '</div>';
		endif;

		return $out;
	}
}

/**
 * Render Cover Albums as List Style
 *
 * @return 	string
 *
 */
 
if ( ! function_exists( 'sp_list_cover_albums' ) ) {
	function sp_list_cover_albums( $args = array() ) {

		$defaults = array(
				'post_type' 		=> 'sp_gallery',
				'posts_per_page'	=> -1
			);
		$args = wp_parse_args( $args, $defaults );
		extract( $args );

		$custom_query = new WP_Query($args);

		if ( $custom_query->have_posts() ):
			$out = '';
			while ( $custom_query->have_posts() ) : $custom_query->the_post();

				$thumb_url = sp_post_thumbnail('large');
	        	$image_url = aq_resize( $thumb_url, '470', '316', true);

				$out .= '<figure class="effect-soda">';
				$out .= '<img src="' . $image_url . '">';
				$out .= '<figcaption>';
				$out .= '<h4>' . get_the_title() . '</h4>';
				$out .= '<p>';
				$out .= get_post_meta( get_the_ID(), 'sp_album_location', true);
				$out .= '<br>' . get_the_date('F j, Y');
				$out .= '</p>'; 
				$out .= '<a href="'.get_permalink().'"><span>View more</span></a>';
				$out .= '</figcpation>';
				$out .= '</figure>';

			endwhile;
			wp_reset_postdata();
		endif;

		return $out;
	}
}

/**
 * Render All photos by Album 
 *
 * @return 	string
 *
 */
 
if ( ! function_exists( 'sp_photo_by_album' ) ) {
	function sp_photo_by_album( $album_id = '', $post_num = 10, $column = 4 ) {

		global $post;

		$out = '';
		$gallery = explode( ',', get_post_meta( $album_id, 'sp_cp_gallery', true ) );

		/*$album_post = get_post( $album_id );
		$content = $album_post->post_content;
		$content = apply_filters('the_content', $content);
		$out .= $content;*/

		$count = 0;
		if ( $gallery ) :
			$out .= '<div class="gallery-post gallery clearfix sp-grid">';
			foreach ( $gallery as $image ) :
				if ( $post_num > $count ) {
					$thumb_url = wp_get_attachment_image_src($image, 'large');
					$image_url = aq_resize( $thumb_url[0], '470', '316', true);

					$out .= '<figure class="' . sp_column_class($column) . ' effect-pepsi">';
					$out .= '<img src="' . $image_url . '">';
					$out .= '<figcaption>';
					$out .= '<a href="' . wp_get_attachment_url($image) . '"><span>View more</span></a>';
					$out .= '</figcaption>';
					$out .= '</figure>';
				}

				$count++;
			endforeach; 
			$out .= '</div>';
		else : 
			$out .= __( 'Sorry there is no image for this album.', SP_TEXT_DOMAIN );
		endif;

		return $out;
	}
}

/**
 * ----------------------------------------------------------------------------------------
 * Render Partner Post Type 
 * ----------------------------------------------------------------------------------------
 *
 * @return 	string
 *
 */
 
if ( !function_exists('sp_get_partner_post') ) {
	function sp_get_partner_post( $args = array() ) {

		$defaults = array(
				'post_type' => 'sp_partner',
				'posts_per_page' => -1
			);
		$args = wp_parse_args( $args, $defaults );
		extract( $args );

		$custom_query = new WP_Query($args);

		if ( $custom_query->have_posts() ):
			$out = '<div class="partner-post">';
			while ( $custom_query->have_posts() ) : $custom_query->the_post();
				
				$partner_url = get_post_meta( get_the_ID(), 'sp_partner_link', true );
				$thumb_url = sp_post_thumbnail('medium');
		        $image_url = aq_resize( $thumb_url, '132' );
				
				$out .= '<article id="post-' . get_the_ID() . '">';
				if ( $partner_url ) {
					$out .= '<a href="'.$partner_url.'" target="_blank"><img src="' . $image_url . '" /></a>';
				} else {
					$out .= '<img src="' . $image_url . '" />';
				}
				$out .= '</article>';

			endwhile;
			wp_reset_postdata();
			$out .= '</div>';
		endif;

		return $out;
	}	
}


/**
 * ----------------------------------------------------------------------------------------
 * Render Client Post Type
 * ----------------------------------------------------------------------------------------
 */

/**
 * Render client posts as slideshow 
 *
 * @return 	string
 *
 */
if ( !function_exists('sp_client_posts_slide') ) {
	function sp_client_posts_slide( $args = array() ) {

		$defaults = array(
				'post_type' => 'sp_client',
				'posts_per_page' => -1
			);
		$args = wp_parse_args( $args, $defaults );
		extract( $args );

		$custom_query = new WP_Query($args);

		if ( $custom_query->have_posts() ): ?>

		<script type="text/javascript">
			jQuery(document).ready(function($){
				$("#client-post").flexslider({
					animation: "fade",
					slideshowSpeed: 5000,
					animationDuration: 200,
					animationLoop: true,
					pauseOnAction: true,
					pauseOnHover: true,
				});
			});		
		</script>

		<?php 
			$out = '<div id="client-post" class="client-post flexslider">';
			$out .= '<ul class="slides">';
			while ( $custom_query->have_posts() ) : $custom_query->the_post();
				
				$post_id = get_the_ID();
				$title = get_the_title();
				$content = get_the_content();
				$post_meta = get_post_meta( get_the_ID() );
				
				$out .= '<li>';
				$out .= client_post_content( $post_id, $title, $content,  $post_meta );
				$out .= '</li>';

			endwhile;
			wp_reset_postdata();
			$out .= '</ul>';
			$out .= '</div>';
		endif;

		return $out;
	}	
}


/**
 * Render client posts as list view
 *
 * @return 	string
 *
 */
if ( !function_exists('sp_client_posts_list') ) {
	function sp_client_posts_list( $args = array() ) {

		$defaults = array(
				'post_type' => 'sp_client',
				'posts_per_page' => -1
			);
		$args = wp_parse_args( $args, $defaults );
		extract( $args );

		$custom_query = new WP_Query($args);

		if ( $custom_query->have_posts() ): 

			$out = '<div class="client-post">';
			while ( $custom_query->have_posts() ) : $custom_query->the_post();
				
				$post_id = get_the_ID();
				$title = get_the_title();
				$content = get_the_content();
				$post_meta = get_post_meta( get_the_ID() );

				$out .= client_post_content( $post_id, $title, $content,  $post_meta );

			endwhile;
			wp_reset_postdata();
			$out .= '</div>';
		endif;

		return $out;
	}	
}



/**
 * Render HTML of single client content
 *
 * @return 	string
 *
 */
if ( !function_exists('client_post_content') ) {
	function client_post_content( $post_id = '', $title = '', $content = '',  $post_meta = array() ) {

		$out = '<article id="post-' . $post_id . '">';
		$out .= '<p class="client-say">' . $content . '</p>';
		$out .= '<span class="client-name">' . $title . '</span>';
		$out .= '<span class="client-position">' . $post_meta['sp_client_cite'][0] . '</span>, ';
		$out .= '<span class="client-company">' . $post_meta['sp_client_cite_subtext'][0] . '</span>';
		$out .= '</article>';

		return $out;
	}
}

/**
 * ----------------------------------------------------------------------------------------
 * Render Branch posts in Google Map
 * ----------------------------------------------------------------------------------------
 *
 * @return 	string
 *
 */

if ( ! function_exists( 'map_branch_by_location' ) ) {
	function map_branch_by_location ( $category_id, $post_num, $zoom = 12 ){
		global $post;
		?>

	    <script type="text/javascript" src="http://maps.google.com/maps/api/js?sensor=false"></script>
		<script type="text/javascript">					
		  jQuery(document).ready(function ($)
			{
				var locations = [ 
			<?php
			$args = array(
				 'post_type' =>	'sp_branch',
	             'posts_per_page' => $post_num,
	             'post_status' => 'publish',
	             'tax_query' => array(
	                    array(
	                        'taxonomy' => 'branch_location',
	                        'field' => 'id',
	                        'terms' => array($category_id)
	                    )
	                )
	        );
	        $custom_query = new WP_Query( $args );

			while ( $custom_query->have_posts() ) : $custom_query->the_post();
				
        		$thumb_url = sp_post_thumbnail('medium');
		        $image_url = aq_resize( $thumb_url, 135, 90, true );

				echo '[';
				echo '\'<div class="map-item-info clearfix">';
				if ( has_post_thumbnail() ) :
					echo '<img class="left wp-image-placeholder" src="' . $image_url . '">';
				else :
					echo '<img class="wp-image-placeholder" src="' . SP_ASSETS_THEME .'images/placeholder/thumbnail-300x225.gif" width="135" height="90">';	
				endif;
				echo '<ul class="branch-info">';
				echo '<li class="name"><h5>' . get_the_title() . '</h5></li>';
				echo '<li class="address">' . get_post_meta( get_the_ID(), 'sp_branch_address', true) . '</li>';
				echo '<li>';
				echo '<span class="left">' . __('Tel:', SP_TEXT_DOMAIN ) . '</span><span class="right">' . get_post_meta( get_the_ID(), 'sp_branch_tel', true) . '</span>';
				echo '</li>';
				echo '<li>';
				echo '<span class="left">' . __('E-mail:', SP_TEXT_DOMAIN ) . '</span><span class="right"><a href="mailto:' . antispambot(get_post_meta( get_the_ID(), 'sp_branch_email', true)) . '">' . antispambot(get_post_meta( get_the_ID(), 'sp_branch_email', true)) . '</a></span>';
				echo '</li>';
				echo '</ul></div>\'';
				echo ', ' . get_post_meta( get_the_ID(), 'sp_lat_long', true);
				echo '],';
			endwhile; wp_reset_postdata();
			?>	
		        ];
				
				var map = new google.maps.Map(document.getElementById('branch-map'), {
					  mapTypeId: google.maps.MapTypeId.ROADMAP
				});
				
				var infowindow = new google.maps.InfoWindow();
				var bounds = new google.maps.LatLngBounds();
				var marker, i;

				for (i = 0; i < locations.length; i++) {  
				  marker = new google.maps.Marker({
					position: new google.maps.LatLng(locations[i][1], locations[i][2]),
					map: map,
					travelMode: google.maps.TravelMode["Driving"], //Driving or Walking or Bicycling or Transit
					animation: google.maps.Animation.DROP,
				  });

				  bounds.extend(marker.position);

				  google.maps.event.addListener(marker, 'click', (function(marker, i) {
					return function() {
					  map.panTo(marker.getPosition());	
					  infowindow.setContent(locations[i][0]);
					  infowindow.open(map, marker);
					}
				  })(marker, i));
				
				    google.maps.event.addListener(map, "click", function(){
					  infowindow.close();
					});
				};

				map.fitBounds(bounds);

				//(optional) restore the zoom level after the map is done scaling
				var listener = google.maps.event.addListener(map, "idle", function () {
				    map.setZoom(<?php echo $zoom; ?>);
				    google.maps.event.removeListener(listener);
				});
			});
		</script>
		<div id="branch-map"></div>

	<?php
	}
}


