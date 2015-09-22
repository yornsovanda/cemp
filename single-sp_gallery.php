<?php
/**
 * The template for displaying all gallery custom post.
 */

get_header(); ?>
<?php do_action( 'sp_start_content_wrap_html' ); ?>
    <div id="main" class="main">
		<?php
			// Start the Loop.
			while ( have_posts() ) : the_post(); 
		?>

				<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
			
					<header class="entry-header">
						<h1 class="entry-title">
							<?php the_title(); ?>
						</h1>
						<div class="entry-meta">
							<span class="album-attr"><?php echo get_the_date('F j, Y'); ?></span>
        					<span class="album-attr">, <?php echo get_post_meta( get_the_ID(), 'sp_album_location', true); ?></span>
						</div>
					</header>

					<div class="entry-content">
						<?php the_content(); ?>
						<?php
							$postnum = -1;
							$column = get_post_meta( $post->ID, 'sp_col_thumb', true ); 
							echo sp_photo_by_album( $post->ID, $postnum, $column ); 
						?>
						
					</div><!-- .entry-content -->

				</article><!-- #post -->

		<?php		
				// If comments are open or we have at least one comment, load up the comment template.
				if ( comments_open() || get_comments_number() ) {
					comments_template();
				}
			endwhile;
		?>
		
	</div><!-- #main -->
	<?php get_sidebar();?>
<?php do_action( 'sp_end_content_wrap_html' ); ?>
<?php get_footer(); ?>