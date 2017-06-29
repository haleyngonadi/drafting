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

        <?php if ( is_single('112')) : ?>
       <h3 class="point-name">Have Not</h3>
       <?php elseif ( is_single('110')) : ?>
       <h3 class="point-name">Nominated</h3>
       <?php elseif ( is_single('111')) : ?>
       <h3 class="point-name">VETO Player</h3>
      <?php else:?>
        <h3 class="point-name"><?php the_title()?></h3>
      <?php endif; ?>



			
				<?php while ( have_posts() ) : the_post(); ?>

					<table class="point-system">
  <tr>
    <th>When</th>
    <th>Who</th>
  </tr>
  <tr>
    <td>Week 1</td>

    <?php if ( is_single('112')) : ?>

      <!---Get Have nots -->

          <td><?php $have_one = get_post_meta(97, 'points_week_one', true);
    $haveaid = $wpdb->get_var( "SELECT ID FROM $wpdb->posts WHERE post_title = '" . $have_one . "'" );
    echo '<a href="'.get_permalink($haveaid).'">'.$have_one.'</a>';
    ?>
    <?php $have_two = get_post_meta(100, 'points_week_one', true);
    $havid = $wpdb->get_var( "SELECT ID FROM $wpdb->posts WHERE post_title = '" . $have_two . "'" );
    echo '<a href="'.get_permalink($havid).'">'.$have_two.'</a>';
    ?> 
    <?php $have_three = get_post_meta(101, 'points_week_one', true);
    $havbid = $wpdb->get_var( "SELECT ID FROM $wpdb->posts WHERE post_title = '" . $have_three . "'" );
    echo '<a href="'.get_permalink($hav3id).'">'.$have_three.'</a>';
    ?>
    <?php $have_four = get_post_meta(102, 'points_week_one', true);
    $havedid = $wpdb->get_var( "SELECT ID FROM $wpdb->posts WHERE post_title = '" . $have_four . "'" );
    echo '<a href="'.get_permalink($havedid).'">'.$have_four.'</a>';
    ?></td>

<!---Get Noms -->

        <?php elseif ( is_single('110')) : ?>

                    <td><?php $nom_one = get_post_meta(89, 'points_week_one', true);
    $nomaid = $wpdb->get_var( "SELECT ID FROM $wpdb->posts WHERE post_title = '" . $nom_one . "'" );
    echo '<a href="'.get_permalink($nomaid).'">'.$nom_one.'</a>';
    ?><?php $nom_two = get_post_meta(90, 'points_week_one', true);
    $nombid = $wpdb->get_var( "SELECT ID FROM $wpdb->posts WHERE post_title = '" . $nom_two . "'" );
    echo '<a href="'.get_permalink($nombid).'">'.$nom_two.'</a>';
    ?></td>

<!---Get Veto Players -->

        <?php elseif ( is_single('11')) : ?>

           <td>

  <?php $veto_one = get_post_meta(91, 'points_week_one', true);
    $vetof = $wpdb->get_var( "SELECT ID FROM $wpdb->posts WHERE post_title = '" . $nom_one . "'" );
    echo '<a href="'.get_permalink($vetof).'">'.$nom_one.'</a>';
    ?>
    <?php $veto_two = get_post_meta(92, 'points_week_one', true);
    $vetoa = $wpdb->get_var( "SELECT ID FROM $wpdb->posts WHERE post_title = '" . $veto_two . "'" );
    echo '<a href="'.get_permalink($vetoa).'">'.$veto_two.'</a>';
    ?>

  <?php $veto_three = get_post_meta(93, 'points_week_one', true);
    $vetob = $wpdb->get_var( "SELECT ID FROM $wpdb->posts WHERE post_title = '" . $veto_three . "'" );
    echo '<a href="'.get_permalink($vetob).'">'.$veto_three.'</a>';
    ?>

  <?php $veto_four = get_post_meta(94, 'points_week_one', true);
    $vetoc = $wpdb->get_var( "SELECT ID FROM $wpdb->posts WHERE post_title = '" . $veto_four . "'" );
    echo '<a href="'.get_permalink($vetoc).'">'.$veto_four.'</a>';
    ?>

  <?php $veto_five = get_post_meta(95, 'points_week_one', true);
    $videod = $wpdb->get_var( "SELECT ID FROM $wpdb->posts WHERE post_title = '" . $veto_five . "'" );
    echo '<a href="'.get_permalink($videod).'">'.$veto_five.'</a>';
    ?>

        <?php $veto_six = get_post_meta(96, 'points_week_one', true);
    $vetoe = $wpdb->get_var( "SELECT ID FROM $wpdb->posts WHERE post_title = '" . $veto_six . "'" );
   echo '<a href="'.get_permalink($vetoe).'">'.$veto_six.'</a>';
    ?>


    </td>




  <?php else:?>
    <td><?php $sham = get_post_meta(get_the_id(), 'points_week_one', true);
    $postid = $wpdb->get_var( "SELECT ID FROM $wpdb->posts WHERE post_title = '" . $sham . "'" );
		echo '<a href="'.get_permalink($postid).'">'.$sham.'</a>';
    ?></td>

    <?php endif; ?>
  </tr>

  </table>

					<nav id="nav-single">
						<h3 class="assistive-text"><?php _e( 'Navigation', 'twentyeleven' ); ?></h3>

            <?php 
  $p = get_adjacent_post(false, '', true);
  if(!empty($p)) echo '<span class="meta-nav">&larr;</span> <span class="prev"><a href="' . get_permalink($p->ID) . '" title="' . $p->post_title . '">' . $p->post_title . '</a></span>';

  $n = get_adjacent_post(false, '', false);
  if(!empty($n)) echo '<span class="next"><a href="' . get_permalink($n->ID) . '" title="' . $n->post_title . '">' . $n->post_title . ' <span class="meta-nav">&rarr;</span></a></span>'; 
?>


					</nav><!-- #nav-single -->


				<?php endwhile; // end of the loop. ?>

			</div><!-- #content -->
		</div><!-- #primary -->

<?php get_footer(); ?>