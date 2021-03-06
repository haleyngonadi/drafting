<?php
/**
 * The template for displaying all pages
 *
 * This is the template that displays all pages by default.
 * Please note that this is the WordPress construct of pages and that
 * other 'pages' on your WordPress site will use a different template.
 *
 * @package WordPress
 * @subpackage Drafting
 * @since Drafting 1.0
 */

get_header(); ?>


<div class="site-content" data-active="<?php echo get_user_meta(1, 'active', true );?>">

<?php
// Set the Current Author Variable $curauth
$curauth = (isset($_GET['author_name'])) ? get_user_by('slug', $author_name) : get_userdata(intval($author));
?>

	<div class="row author-row">
					<div class="col-sm-3">

	<div class="author-photo"><?php echo get_avatar($curauth->user_email, '300', $avatar); ?></div>



	</div>

	<div class="col-sm-9">

	<header class="entry-header"><h1 class="entry-title"> <?php echo $curauth->nickname; ?></h1></header>




	<p> <?php echo nl2br(get_the_author_meta('description')); ?></p>
		
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

	<h3 class="point-name"> Your Drafts</h3>



			<?php
			$types = get_post_types( array( 'public' => true ) );
			$args = array(
			  'numberposts' => -1,
			  'post_type' => $types,
			  'meta_query' => array (
				array (
				  'key' => '_user_liked',
				  'value' => $curauth->ID,
				  'compare' => 'LIKE'
				)
			  ) );		
			$sep = '';
			$like_query = new WP_Query( $args );
			if ( $like_query->have_posts() ) : ?>
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
			<p><?php _e( 'You have not drafted any players yet.'); ?></p>
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

$user_last = get_user_meta( $curauth->ID, $getit, true ); 
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
<?php get_footer();?>
