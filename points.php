<?php
/* Template Name: Points Page */

get_header(); ?>

<div id="main-content" class="main-content">


	<div id="primary" class="content-area">
		<div id="content" class="site-content" role="main">

<?php

		the_title( '<header class="pages-header"><h3 class="point-name">', '</h3></header><!-- .entry-header -->' );
	?>

<div class="row point-row">

	<?php 
$args = array(
	'post_type' => 'points',
	'posts_per_page'=>-1,
	'orderby' => 'date'
	
);
$the_query = new WP_Query( $args ); ?>

<?php if ( $the_query->have_posts() ) : ?>

	<!-- pagination here -->

	<!-- the loop -->
	<?php while ( $the_query->have_posts() ) : $the_query->the_post(); ?>
		<div class="col-sm-4"><div id="points-title"><a href="<?php the_permalink(); ?>" title="Click for more."><?php the_title(); ?></a></div><span title="<?php the_title()?> is worth <?php echo get_post_meta(get_the_id(), '_point_value', true);?> points."> <?php echo get_post_meta(get_the_id(), '_point_value', true);?> Point(s)</span></div>
	<?php endwhile; ?>
	<!-- end of the loop -->

	<!-- pagination here -->

	<?php wp_reset_postdata(); ?>

<?php else : ?>
	<p><?php _e( 'Sorry, no posts matched your criteria.' ); ?></p>
<?php endif; ?>

</div>

		</div><!-- #content -->
	</div><!-- #primary -->
	
</div><!-- #main-content -->

<?php

get_footer();
