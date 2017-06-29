<?php get_header(); ?>		

	<div id="content" class="clearfix">
		
		<?php // the loop ?>
		<?php if (have_posts()) : ?>
		
			<?php while (have_posts()) : the_post(); ?>
	
				<?php get_template_part( 'includes/loop' , 'index'); ?>
	
			<?php endwhile; ?>
							
			<?php get_template_part( 'includes/pagination'); ?>
		
		<?php else : ?>
	
			<p><?php _e( 'Sorry, nothing found.', 'themify' ); ?></p>
	
		<?php endif; ?>			
	
	</div>
	<!-- /#content -->

<?php get_sidebar(); ?>

<?php get_footer(); ?>