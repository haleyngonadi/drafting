<?php
/* Template Name: Home */
get_header(); ?>

<div id="main-content" class="main-content">


	<div id="primary" class="content-area">
		<div id="content" class="site-content" role="main">

			
<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

<header class="pages-header"><h3 class="point-name">
	

	<?php
	global $current_user;
      get_currentuserinfo();
if ( is_user_logged_in() ) {
    echo  'Welcome, ' . $current_user->display_name . "!";
} else {
    echo 'Hi There!';
}
?>

</h3></header>

	<div class="entry-content">

			<?php if ( is_user_logged_in() ) : ?>


					


			<?php
			$types = get_post_types( array( 'public' => true ) );
			$args = array(
			  'numberposts' => -1,
			  'post_type' => $types,
			  'meta_query' => array (
				array (
				  'key' => '_user_liked',
				  'value' => $current_user->ID,
				  'compare' => 'LIKE'
				)
			  ) );		
			$sep = '';
			$like_query = new WP_Query( $args );
			if ( $like_query->have_posts() ) : ?>
			<h3 class="point-name"> Your Drafts</h3>
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
			
				<h3 class="point-name">How it works</h3>

	<p>Upon <a href="/login">logging in</a> or <a href="/register">registering</a>, you'd be awarded the opportunity of drafting <b>FOUR</b> unique players, all of whom will either earn or cost you a few points depending on the each week's activities. So, choose wisely.</p>

		<h3 class="point-name">Points</h3>

			<p>You will earn or lose <a href="/points">points< based on the following and more:</p>

			<div class="row point-row">

	<?php 
$args = array(
	'post_type' => 'points',
		'posts_per_page'=> 6,
		'post__not_in' => array( 96, 95, 94, 93, 92, 91, 90, 89, 97, 102, 101, 100, 110,111, 112  )
	
);
$the_query = new WP_Query( $args ); ?>

<?php if ( $the_query->have_posts() ) : ?>

	<!-- pagination here -->

	<!-- the loop -->
	<?php while ( $the_query->have_posts() ) : $the_query->the_post(); ?>
		<div class="col-sm-4"><div id="points-title"><a href="<?php the_permalink(); ?>" title="Click for more."><?php the_title(); ?></a></div><span title="<?php the_title()?> is worth <?php echo get_post_meta(get_the_id(), '_point_value', true);?> points."> <?php echo get_post_meta(get_the_id(), '_point_value', true);?> Points</span></div>
	<?php endwhile; ?>
	<!-- end of the loop -->

	<!-- pagination here -->

	<?php wp_reset_postdata(); ?>

<?php else : ?>
	<p><?php _e( 'Sorry, no posts matched your criteria.' ); ?></p>
<?php endif; ?>

</div>


	<h3 class="point-name">Why Play?</h3>
	<p>In addition to the game being fun and you earning MAJOR bragging rights for choosely your drafts wisely, the <b>TOP 3</b> people with the most points at the end of this season of Big Brother America, will be awarded something special and BB-related. Stay tuned! </p>
				

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

$user_last = get_user_meta( $current_user->ID, $getit, true ); 
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


<?php else : ?>


	<h3 class="point-name">How it works</h3>

	<p>Upon <a href="">logging in</a> or registering, you'd be awarded the opportunity of drafting <b>FOUR</b> unique players, all of whom will either earn or cost you a few points depending on the each week's activities. So, choose wisely.</p>

		<h3 class="point-name">Points</h3>

						<p>You will earn or lose <a href="/points">points< based on the following and more:</p>

			<div class="row point-row">

	<?php 
$args = array(
	'post_type' => 'points',
		'posts_per_page'=> 6,
		'post__not_in' => array( 96, 95, 94, 93, 92, 91, 90, 89, 97, 102, 101, 100, 110,111, 112  )
	
);
$the_query = new WP_Query( $args ); ?>

<?php if ( $the_query->have_posts() ) : ?>

	<!-- pagination here -->

	<!-- the loop -->
	<?php while ( $the_query->have_posts() ) : $the_query->the_post(); ?>
		<div class="col-sm-4"><div id="points-title"><a href="<?php the_permalink(); ?>" title="Click for more."><?php the_title(); ?></a></div><span title="<?php the_title()?> is worth <?php echo get_post_meta(get_the_id(), '_point_value', true);?> points."> <?php echo get_post_meta(get_the_id(), '_point_value', true);?> Points</span></div>
	<?php endwhile; ?>
	<!-- end of the loop -->

	<!-- pagination here -->

	<?php wp_reset_postdata(); ?>

<?php else : ?>
	<p><?php _e( 'Sorry, no posts matched your criteria.' ); ?></p>
<?php endif; ?>

</div>


	<h3 class="point-name">Why Play?</h3>
	<p>In addition to the game being fun and you earning MAJOR bragging rights for choosely your drafts wisely, the <b>TOP 3</b> people with the most points at the end of this season of Big Brother America, will be awarded something special and BB-related. Stay tuned! </p>
				
			<?php endif; ?>

		

	</div><!-- .entry-content -->
</article><!-- #post-## -->

		</div><!-- #content -->
	</div><!-- #primary -->
</div><!-- #main-content -->

<?php
get_footer();
