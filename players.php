<?php 

/* Template Name: Players */


get_header(); ?>

	<div id="content" class="clearfix site-content">
	
		<?php while ( have_posts() ) : the_post(); ?>
						
			<div class="pages-header"><h3 class="point-name"><?php the_title(); ?></h3></div>			

		<?php endwhile; ?>

<div class="row">


		<?php
$blogusers = get_users( array( 'exclude' => array('1'), 'orderby' => 'rand', 'number' => -1 ) );


// Array of WP_User objects.
foreach ( $blogusers as $user ) : ?>


<div class="col-md-4">

<div class="item">

<?php $permalink_base = um_get_option('permalink_base');
		$profile_slug = get_user_meta( $user->ID, "um_user_profile_url_slug_{$permalink_base}", true );?>

			<a href="<?php echo get_site_url()?>/player/<?php echo $profile_slug?>">
		<?php $imageurl = get_user_meta($user->ID, 'avatar_image_url', true);

		if (!empty($imageurl)) {
			echo '<div class="player-image" style="background-image: url('.$imageurl.')"></div>';
		}

		else {
			echo '<div class="player-image" style="background-image: url('.esc_url( get_avatar_url( $curauth ) ).')"></div>';

		}

		?>
		</a>

		<div class="player-name">
			
		<?php 
	if (!empty(get_user_meta($user->ID, 'first_name', true))) {
	 echo get_user_meta($user->ID, 'first_name', true); }
	 else {
	 	echo get_user_meta($user->ID, 'nickname', true);
	 }
	 ?>

		</div>


<div class="row cirt">
<div class="col-md-6">
	
<span class="user-big">
	
	<?php $countoflikes = get_user_meta( $user->ID, 'wp__user_like_count', true );

	if (!empty($countoflikes)){
	echo $countoflikes;}

	else {
		echo 0;
	}
	?>

</span>
	<span class="user-small">Draft(s)</span>

</div>

<div class="col-md-6">
	<span class="user-big">
		
			<?php $pointscount = get_user_meta( $user->ID, 'totals', true );

	if (!empty($pointscount)){
	echo $pointscount;}

	else {
		echo 0;
	}
	?>

	</span>
	<span class="user-small">Point(s)</span>

</div>

</div>

</div></div>



<?php endforeach; ?>
		

</div>
	</div>
	<!-- /#content -->
		
	
<?php get_footer(); ?>