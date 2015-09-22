<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<?php
		$is_page_title = get_post_meta( $post->ID, 'sp_is_page_title', true );

		// Page thumbnail and title.
		if ( $is_page_title == 'on' ) :
			the_title( '<header class="entry-header"><h1 class="entry-title">', '</h1></header><!-- .entry-header -->' );
		endif;
	?>

	<div class="entry-content">
		<?php the_content(); ?>
	</div><!-- .entry-content -->
</article><!-- #post-## -->