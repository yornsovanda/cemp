    <aside id="footer-widget">
        <div class="container clearfix">
        <div class="quick-contact">
            <?php
                $page = get_post( ot_get_option( 'quick-contact' ) );
                $content = apply_filters('the_content', $page->post_content);
            ?>
            <h3><?php echo $page->post_title; ?></h3>
            <?php echo $content; ?>
        </div> <!-- .quick-contact -->    
        </div><!-- .container -->
    </aside><!-- #footer-widget -->

	<footer id="footer">
        <div class="container clearfix">
        	<nav id="footer-nav" class="clearfix">
	        	<?php echo sp_footer_navigation(); ?>
        	</nav>
            <p class="copyright">
                <?php if ( ot_get_option( 'copyright' ) ): ?>
                    <?php echo ot_get_option( 'copyright' ); ?>
                <?php else: ?>
                    <?php bloginfo(); ?> &copy; <?php echo date( 'Y' ); ?>. <?php _e( 'All Rights Reserved.', SP_TEXT_DOMAIN ); ?>
                <?php endif; ?>
            </p><!--/.copyright-->
            
        </div><!-- .container .clearfix -->
    </footer><!-- #footer -->

	</div> <!-- end #content-container -->
</div> <!-- #wrapper -->

<?php wp_footer(); ?>

</body>
</html>