<?php
/**
 * Template for displaying all single posts
 *
 * @package WordPress
 * @subpackage Twenty_Eleven
 * @since Twenty Eleven 1.0
 */

get_header(); ?>

		<div id="primary">
			<div id="content" role="main" class="point-single">
			<h3 class="point-name"><?php the_title()?></h3>
				<?php while ( have_posts() ) : the_post(); ?>

					<table class="point-system">
  <tr>
    <th>When</th>
    <th>Who</th>
  </tr>
  <tr>
    <td>Week 1</td>
    <td><?php $sham = get_post_meta(get_the_id(), 'points_week_one', true);
    $postid = $wpdb->get_var( "SELECT ID FROM $wpdb->posts WHERE post_title = '" . $sham . "'" );
		echo '<a href="'.get_permalink($postid).'">'.$sham.'</a>';
    ?></td>
  </tr>
    <tr>
    <td>Week 2</td>
        <td><?php $sham = get_post_meta(get_the_id(), 'points_week_two', true);
    $postid = $wpdb->get_var( "SELECT ID FROM $wpdb->posts WHERE post_title = '" . $sham . "'" );
		echo '<a href="'.get_permalink($postid).'">'.$sham.'</a>';
    ?></td>

    </tr>

    <tr>

    <td>Week 3</td>
        <td><?php $sham = get_post_meta(get_the_id(), 'points_week_three', true);
    $postid = $wpdb->get_var( "SELECT ID FROM $wpdb->posts WHERE post_title = '" . $sham . "'" );
    echo '<a href="'.get_permalink($postid).'">'.$sham.'</a>';
    ?></td>
  </tr>

  </table>

					<nav id="nav-single">
						<h3 class="assistive-text"><?php _e( 'Post navigation', 'twentyeleven' ); ?></h3>
						<span class="nav-previous"><?php previous_post_link( '%link', __( '<span class="meta-nav">&larr;</span> Previous', 'twentyeleven' ) ); ?></span>
						<span class="nav-next"><?php next_post_link( '%link', __( 'Next <span class="meta-nav">&rarr;</span>', 'twentyeleven' ) ); ?></span>
					</nav><!-- #nav-single -->


				<?php endwhile; // end of the loop. ?>

			</div><!-- #content -->
		</div><!-- #primary -->

<?php get_footer(); ?>