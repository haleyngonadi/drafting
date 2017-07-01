<?php
/* Template Name: Leaderboard */

get_header(); ?>


	<div id="primary" class="content-area">
		<div id="content" class="site-content" role="main">

<header class="pages-header">
<?php the_title( '<h3 class="point-name">', '</h3>' ); ?>
<?php custom_breadcrumbs(); ?>
</header><!-- .entry-header -->


<figure class="tabBlock">
  <div class="tabBlock-tabs row">
    <div class="tabBlock-tab col-md-6">All Time</div>
    <div class="tabBlock-tab is-active col-md-6">This Week</div>
  </div>
  <div class="tabBlock-content">


        <div class="tabBlock-pane">
      <?php

$args = array(
	'exclude' => array( 1 ),
    'meta_key' => 'totals',
    'orderby'  => 'meta_value',
    'order'    => 'ASC',
    'number'         => '10',
    

);

add_action( 'pre_user_query', 'wpse_149342_pre_user_query' );

$user_query = new WP_User_Query( $args ); ?>

<?php if ( ! empty( $user_query->results ) ) : ?>

	<?php foreach ( $user_query->results as $user ) : ?>
		
		<div class="row leader-row">
			<div class="leader-photo col-sm-2">


					<?php $imageurl = get_user_meta($user->ID, 'avatar_image_url', true);

		if (!empty($imageurl)) {
			echo '<img id="user-pic" src="'.$imageurl.'">';
		}

		else {
			echo '<img id="user-pic" src="'.esc_url( get_avatar_url( $user->ID ) ).'">';

		}

		?>

				

			</div>
			
				<div class="col-sm-10 row">
	<div class="col-sm-9">

					<?php 	
		$permalink_base = um_get_option('permalink_base');
		$profile_slug = get_user_meta( $user->ID, "um_user_profile_url_slug_{$permalink_base}", true );

		?>

			<a class="leader-title" href="<?php echo get_site_url()?>/player/<?php echo $profile_slug?>"> <?php echo $user->first_name ;?></a>


				<b class="random-name"> Drafts:</b> 



			<?php
			$likedposts = get_user_meta( $user->ID,'_drafted', 'true');

			$like_query = new WP_Query( array( 'post_type' => 'houseguests', 'post__in' => $likedposts ) );

			if ( $like_query->have_posts() ) : ?>
			<p class="the-drafts">
			<?php while ( $like_query->have_posts() ) : $like_query->the_post(); 
			echo $sep; ?><a href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>"><?php the_title(); ?></a>
			<?php
			$sep = ' &middot; ';
			endwhile; 
			?>
			</p>
			<?php else : ?>
			<p><?php _e( 'You have not drafted any players yet.', 'YourThemeTextDomain' ); ?></p>
			<?php 
			endif; 
			?>
	</div>

	<div class="col-sm-3" style="text-align: center">


	
			<span class="week-total"><?php echo get_user_meta( $user->ID, 'totals', true );?></span>


	</div>
			</div>



			</div>


	<?php endforeach;?>


<?php else : 
echo 'No users found.';?>

<?php endif; ?>

    </div>

        <div class="tabBlock-pane">
      <?php

$args = array(
    'meta_key' => 'totals',
    'orderby'  => 'meta_value',
    'order'    => 'ASC',
    'number'         => '10',
    'exclude' => array( 1 ),

);

add_action( 'pre_user_query', 'wpse_149342_pre_user_query' );

$user_query = new WP_User_Query( $args ); ?>

<?php if ( ! empty( $user_query->results ) ) : ?>

	<?php foreach ( $user_query->results as $user ) : ?>
		
		<div class="row leader-row" data-id="<?php echo $user->ID ?>">
			<div class="leader-photo col-sm-2">
								<?php $imageurl = get_user_meta($user->ID, 'avatar_image_url', true);

		if (!empty($imageurl)) {
			echo '<img id="user-pic" src="'.$imageurl.'">';
		}

		else {
			echo '<img id="user-pic" src="'.esc_url( get_avatar_url( $user->ID ) ).'">';

		}

		?>
				

			</div>
			
				<div class="col-sm-10 row">
	<div class="col-sm-9">

		<?php 	
		$permalink_base = um_get_option('permalink_base');
		$profile_slug = get_user_meta( $user->ID, "um_user_profile_url_slug_{$permalink_base}", true );

		?>

			<a class="leader-title" href="<?php echo get_site_url()?>/player/<?php echo $profile_slug?>"> <?php echo $user->first_name ;?></a>
				<b class="random-name"> Drafts:</b> 



			<?php
			$likedposts = get_user_meta( $user->ID,'_drafted', 'true');

			$like_query = new WP_Query( array( 'post_type' => 'houseguests', 'post__in' => $likedposts ) );

			if ( $like_query->have_posts() ) : ?>
			<p class="the-drafts">
			<?php while ( $like_query->have_posts() ) : $like_query->the_post(); 
			echo $sep; ?><a href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>"><?php the_title(); ?></a>
			<?php
			$sep = ' &middot; ';
			endwhile; 
			?>
			</p>
			<?php else : ?>
			<p><?php _e( 'You have not drafted any players yet.', 'YourThemeTextDomain' ); ?></p>
			<?php 
			endif; 
			?>
	</div>

	<div class="col-sm-3" style="text-align: center">


	
			<span class="week-total"><?php echo get_user_meta( $user->ID, 'total_week_one', true );?></span>


	</div>
			</div>



			</div>


	<?php endforeach;?>


<?php else : 
echo 'No users found.';?>

<?php endif; ?>

    </div>


  </div>
</figure>





	</div></div>

<?php

get_footer();
