<div class="um <?php echo $this->get_class( $mode ); ?> um-<?php echo $form_id; ?> um-role-<?php echo um_user('role'); ?> ">

	<div class="um-form">
	
		


		<?php
// Set the Current Author Variable $curauth
$curauth = um_profile_id();

?>

	<div class="row author-row">
					<div class="col-sm-3">


	<div class="author-photo" data-name="<?php echo get_user_meta($curauth, 'first_name', 'true');?>">
		
		<?php $imageurl = get_user_meta($curauth, 'avatar_image_url', true);

		if (!empty($imageurl)) {
			echo '<div id="img" style="background-image: url('.$imageurl.')"></div>';
		}

		else {
			echo '<div id="img" style="background-image: url('.esc_url( get_avatar_url( $curauth ) ).')"></div>';

		}

		?>


		

		<?php 
		$nonce = wp_create_nonce( 'new-avatar-nonce' );
		if($curauth == get_current_user_id()) : ?>
		   <form class="upload-button" action="">
    	<label for="upload"><div class="spinner"></div> <span class="change" data-nonce="<?php echo $nonce;?>"></span>
      	<input type='file' id="upload"></label>

  		</form>

  		<div class="success"></div>
		<?php endif; ?>


	</div>



	</div>

	<div class="col-sm-9">

	<header class="entry-header">
	<h1 class="entry-title"> <?php 
	if (!empty(um_user('first_name'))) {
	 echo um_user('first_name'); }
	 else {
	 	echo um_user('display_name');
	 }
	 ?></h1>


		<?php 
		if($curauth == get_current_user_id()) : ?>

	<ul class="socials">


	<li> <a href="#" data-type="twitter" data-url="<?php echo um_user_profile_url()?>" data-via="bigbrotherdraft" class="prettySocial" data-description="Check out my #BB19 drafts:"><i class="fa fa-twitter-square" aria-hidden="true"></i></a></li>
	<li> <a href="#" data-type="facebook" data-title="Big Brother Draft" data-description="Check out my #BB19 drafts:" data-url="<?php echo um_user_profile_url()?>" class="prettySocial"><i class="fa fa-facebook-square" aria-hidden="true"></i></a></li>
	</ul>


	<?php endif; ?>


	</header>




	 <?php 

	if (!empty(um_user('description'))) {
		echo '<p class="about-me">';
		echo um_user('description'); echo '</p>'; }?>
		
		<div class="row points-row">
<div class="col-sm-4 inner-point">


	<span class="point-big draft-count">

	<?php 

	$countoflikes = get_user_meta( get_the_ID(), 'wp__user_like_count', true );
	if(!empty($countoflikes)) {
		echo $countoflikes;
	}
	else {
		echo '0';
	}
	?></span>
	<span class="point-small">draft(s)</span>

</div>

<div class="col-sm-4 inner-point">
	<span class="point-big point-week">0</span>
	<span class="point-small">this week</span>

</div>

<div class="col-sm-4 inner-point">
	<span class="point-big points-all">0</span>
	<span class="point-small">all time</span>

</div>

</div>


	</div>
	</div>

	
	</div>


<!-- 		<h3 class="point-name"> <?php echo um_user('display_name'); ?>'s Drafts</h3>
 -->
			




			<?php
			$likedposts = get_user_meta(  $curauth,'_drafted', 'true');


			$like_query = new WP_Query( array( 'post_type' => 'houseguests', 'post__in' => $likedposts ) );

			if ( !empty($likedposts) &&$like_query->have_posts() ) : ?>

			<?php 

	$countoflikes = get_user_meta( $curauth , 'draft_name', true );
	if(!empty($countoflikes)) {

		echo '<h3 class="point-name">Team ';
		echo $countoflikes;
		echo '</h3>';
	}
	else {
		echo '<h3 class="point-name">';
		echo um_user('first_name');
		echo "'s Drafts";
		echo '</h3>';
	}
	?>


			<div class="row">
			<?php while ( $like_query->have_posts() ) : $like_query->the_post(); 
			 ?>

			 <div class="col-sm-3">

			 <a href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>">

			 	<div class="draft-photo" style=" background-image:url('<?php the_post_thumbnail_url();?>')"></div>

			<span class="draft-name"><?php the_title(); ?></span></a>

			</div>

			<?php
			endwhile; 
			?>
			</div>
			<?php else : ?>
			

			<p class="um-profile-note" style="display: block;"><i class="um-faicon-frown-o"></i><span><?php the_title(); ?> has not drafted any houseguests yet.</span></p>


			<?php 
			endif; 
			wp_reset_postdata(); 
			?>


<div class="the_weeks row">

<?php 

$feature_meta_fields = array(
    array(
        'meta_id'=>  1,
        'title'  => 'Week 1',
        'callback' => 'week_one',
    ),
    array(
        'meta_id'=>  2,
        'title'  => 'Week 2',
        'callback' => 'week_two',
    ),
    array(
        'meta_id'=>  3,
        'title'  => 'Week 3',
        'callback' => 'week_three',
    ),
    array(
         'meta_id'=>  4,
        'title'  => 'Week 4',
        'callback' => 'week_four',
    ),
    array(
        'meta_id'=>  5,
        'title'  => 'Week 5',
        'callback' => 'week_five',
    ),
    array(
         'meta_id'=>  6,
        'title'  => 'Week 6',
        'callback' => 'week_six',
    ),
        array(
        'meta_id'=>  7,
        'title'  => 'Week 7',
        'callback' => 'week_seven',
    ),
    array(
        'meta_id'=>  8,
        'title'  => 'Week 8',
        'callback' => 'week_eight',
    ),
    array(
        'meta_id'=>  9,
        'title'  => 'Week 9',
        'callback' => 'week_nine',
    ),
    array(
         'meta_id'=>  10,
        'title'  => 'Week 10',
        'callback' => 'week_ten',
    ),
    array(
        'meta_id'=>  11,
        'title'  => 'Week 11',
        'callback' => 'week_eleven',
    ),
    array(
         'meta_id'=>  12,
        'title'  => 'Week 12',
        'callback' => 'week_twelve',
    )
);

foreach ( $feature_meta_fields as $fields ) : ?>




<?php 

$getit = $fields['callback'];


$user_last = get_user_meta( $curauth , $fields['callback'], true ); 
   	 $array = array_map( 'trim', explode( ',', $user_last ) ); 


?>

<?php if ( !empty( $array) ) : 


$args = array('post__in' => $array, 'post_type' => 'points' );

$the_query = new WP_Query( $args ); ?>


<?php if ( $the_query->have_posts() ) : ?>

		<section class="weeks <?php echo $fields['callback'];?>" data-value="<?php echo $fields['meta_id'];?>">


<?php $meta = get_user_meta(1, 'active', true );
    if ($fields['meta_id'] == $meta) {
        echo '<div class="week-active" title="Active Week">';
    } else {
        echo '<div class="week-not">';
      }
	
?>
	
<div class="week-header">
<span class="circle-span">stats</span>
<h3 class="cute-circle"><?php echo $fields['title'];?> </h3>
</div>

	<!-- pagination here -->

	<!-- the loop -->
	<div class="scored row">
	<?php while ( $the_query->have_posts() ) : $the_query->the_post(); ?>
		<div class="col-sm-3">

		<ul class="listed">
		<li><span class="list-value"><?php echo get_post_meta( get_the_ID(), '_point_value', true ); ?></span></li>
		<li><span class="list-title"><?php the_title(); ?></span></li>
		<li><span class="list-who"><?php 

		$data1 = "points_";
		$data2 = $fields['callback'];
		$result = $data1 . '' . $data2;

		echo get_post_meta( get_the_ID(), $result, true ); ?></span></li>

		</ul>

		</div>
	<?php endwhile; ?></div>
	<!-- end of the loop -->
</div></section>
	<!-- pagination here -->

	<?php wp_reset_postdata(); ?>


<?php endif; ?>

<?php endif; ?>

<?php endforeach; ?>

</div>
	
</div>