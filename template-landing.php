<?php
/*
Template Name: Landing page
*/?>

<?php get_header(); ?>

<?php echo do_shortcode('[slideshow slide_number="5" slide_effect="fade" ]'); ?>



	<?php // get all home meta
		$home_meta  = get_post_meta( $post->ID ); ?>

	<div class="welcome">	
		<div class="container clearfix">
	<?php
		// Start welcome message
		while ( have_posts() ) : the_post(); ?>
			
			<?php the_content(); ?>
			
	<?php endwhile; ?>
		</div>
	</div>

	<!-- Start Service highlight -->
	<div class="service-section">
		<div class="container clearfix">
		<h3 class="section-title"><?php echo $home_meta['sp_service_title'][0]; ?></h3>
		<p class="desc"><?php echo $home_meta['sp_service_desc'][0]; ?></p>
		<?php 
			$parent_page_id = $home_meta['sp_service_page_id'][0];
			$args = array ( 'child_of' => $parent_page_id, 'sort_column' => 'menu_order' ); 
			echo sp_grid_featured_page( $args, 2 );
		?>
		</div>
	</div> <!-- .services -->

	<!-- Start Project Gallery -->
	<div class="project-section">
		<header>
			<div class="container clearfix">
			<h3 class="section-title"><?php echo $home_meta['sp_project_title'][0]; ?></h3>
			<p class="desc"><?php echo $home_meta['sp_project_desc'][0]; ?></p>
			</div>
		</header>
		<div class="container clearfix">
		<?php
			echo sp_grid_cover_albums('', 3);
		?>
		</div>
	</div> <!-- .projects -->

	<!-- Start Parnter -->
	<div class="partner-section">
		<div class="container clearfix">
			<h3 class="section-title"><?php echo $home_meta['sp_partner_title'][0]; ?></h3>
			<?php echo sp_get_partner_post(); ?>
		</div>
	</div> <!-- .partner -->

	<!-- Start Client -->
	<div class="client-section">
		<div class="container clearfix">
			<h3 class="section-title"><?php echo $home_meta['sp_client_title'][0]; ?></h3>
			<?php echo sp_client_posts_slide(); ?>
		</div>
	</div> <!-- .client -->






	
<?php get_footer(); ?>