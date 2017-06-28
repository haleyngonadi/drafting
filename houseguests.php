<?php
/* Template Name: Houseguests */

get_header(); ?>

<div id="main-content" class="main-content">


	<div id="primary" class="content-area">
		<div id="content" class="site-content" role="main">

<?php

		the_title( '<header class="pages-header"><h3 class="point-name">', '</h3></header><!-- .entry-header -->' );
	?>

<div class="row hg-row">

	<?php 
$args = array(
	'post_type' => 'houseguests',
	
);
$the_query = new WP_Query( $args ); ?>

<?php if ( $the_query->have_posts() ) : ?>

	<!-- pagination here -->

	<!-- the loop -->
	<?php while ( $the_query->have_posts() ) : $the_query->the_post(); ?>
		<div class="col-sm-4"><a href="<?php the_permalink(); ?>" title="Click for more."><?php the_post_thumbnail('homepage-thumb'); ?></a>
		<div id="house-title"><span class="the-hg"><?php the_title(); ?></span>	<span class="hg-drafted" title="Drafts">

	<?php 

	$countoflikes = get_post_meta( get_the_ID(), '_post_like_count', true );
	if(!empty($countoflikes)) {
		echo $countoflikes;
	}
	else {
		echo '0';
	}
	?></span></div></div>
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
