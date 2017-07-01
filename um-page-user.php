<?php get_header(); ?>

	<div id="content" class="clearfix site-content">
	
		<?php while ( have_posts() ) : the_post(); ?>
						
			

			<?php the_content(); ?>
			

		<?php endwhile; ?>
		
	</div>
	<!-- /#content -->
		
	
<?php get_footer(); ?>