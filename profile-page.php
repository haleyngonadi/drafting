<?php 

/* Template Name: Profile */
get_header(); ?>

	<div id="content" class="clearfix">
	
		<?php while ( have_posts() ) : the_post(); ?>
						
			<?php the_content(); ?>
			

		<?php endwhile; ?>
		
	</div>
	<!-- /#content -->
		
	
<?php get_footer(); ?>