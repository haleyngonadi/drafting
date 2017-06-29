<?php get_header(); ?>

	<div id="content" class="clearfix site-content">
	
		<?php while ( have_posts() ) : the_post(); ?>
						
			<div class="pages-header"><h3 class="point-name"><?php the_title(); ?></h3></div>

			<?php the_content(); ?>
			

		<?php endwhile; ?>
		
	</div>
	<!-- /#content -->
		
	
<?php get_footer(); ?>