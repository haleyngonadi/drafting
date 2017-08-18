<?php get_header(); ?>

	<?php while ( have_posts() ) : the_post(); ?>
		

			<!--?php echo get_the_id()?-->

				<div id="primary" class="content-area">
		<div id="content" class="site-content" role="main" data-active="<?php echo get_user_meta(1, 'active', true );?>">

	<article id="houseguest-<?php the_ID(); ?>" <?php post_class('row'); ?>>
		
					<div class="col-sm-4">
	<div class="hg-photo" style=" background-image:url('<?php the_post_thumbnail_url();?>')"></div>

     <a class="sl-button se-button">
        <?php $status = get_post_meta(get_the_ID(), 'meta-radio', true);

             if ($status == 'evicted') {
                echo 'Evicted';
             }

             else {
                echo 'In The Game';
             }

        ?>

    </a>




	</div>

	<div class="entry-content col-sm-8">

		<?php the_title( '<header class="entry-header"><h1 class="entry-title">', '</h1></header><!-- .entry-header -->' );?>

<p>
<?php the_title();?> is a <?php echo get_post_meta(get_the_id(), "get_age", true);?> year old <u><?php echo get_post_meta(get_the_id(), "get_gender", true);?></u> from <strong><?php echo get_post_meta(get_the_id(), "get_from", true);?></strong>! The three adjectives that best describe 
<?php 
$name = get_the_title();
echo strtok($name, " ");?> are: <?php echo get_post_meta(get_the_id(), "get_aject", true);?></p>

<p><u>A fun fact about <?php the_title();?> </u>: "<?php echo get_post_meta(get_the_id(), "get_fun", true);?>."</p>

<p><u>Life Motto</u>: <?php echo get_post_meta(get_the_id(), "get_motto", true);?>.</p>


		


<div class="row points-row">
<div class="col-sm-4 inner-point">


	<span class="point-big draft-count">

	<?php 

	$countoflikes = get_post_meta( get_the_ID(), '_draft_count', true );
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

		
	</div><!-- .entry-content -->


		</article>

		<div class="the_weeks row">


<?php 

$prefix = '';
$feature_meta_fields = array(
    array(
        'meta_id'=>  1,
        'title'  => 'Week 1',
        'callback' => 'w_one',
    ),
    array(
        'meta_id'=>  2,
        'title'  => 'Week 2',
        'callback' => 'w_two',
    ),
    array(
        'meta_id'=>  3,
        'title'  => 'Week 3',
        'callback' => 'w_three',
    ),
    array(
         'meta_id'=>  4,
        'title'  => 'Week 4',
        'callback' => 'w_four',
    ),
    array(
        'meta_id'=>  5,
        'title'  => 'Week 5',
        'callback' => 'w_five',
    ),
    array(
         'meta_id'=>  6,
        'title'  => 'Week 6',
        'callback' => 'w_six',
    ),
        array(
        'meta_id'=>  7,
        'title'  => 'Week 7',
        'callback' => 'w_seven',
    ),
         array(
        'meta_id'=>  25,
        'title'  => 'Double Eviction [Aug 17]',
        'callback' => 'w_double',
    ),
    array(
        'meta_id'=>  8,
        'title'  => 'Week 8',
        'callback' => 'w_eight',
    ),
    array(
        'meta_id'=>  9,
        'title'  => 'Week 9',
        'callback' => 'w_nine',
    ),
    array(
         'meta_id'=>  10,
        'title'  => 'Week 10',
        'callback' => 'w_ten',
    ),
    array(
        'meta_id'=>  11,
        'title'  => 'Week 11',
        'callback' => 'w_eleven',
    ),
    array(
         'meta_id'=>  12,
        'title'  => 'Week 12',
        'callback' => 'w_twelve',
    )
);

foreach ( $feature_meta_fields as $fields ) : ?>




<?php 

$getit = $fields['callback'];

$user_last = get_post_meta( get_the_ID(), $getit , true ); ?>

<?php if ( !empty( $user_last) ) : 

$args = array('post__in' => $user_last, 'post_type' => 'points' );

$the_query = new WP_Query( $args ); ?>


<?php if ( $the_query->have_posts() ) : ?>

		<section class="weeks <?php echo $fields['callback'];?> col-sm-4" data-value="<?php echo $fields['meta_id'];?>">


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
	<ul class="won">
	<?php while ( $the_query->have_posts() ) : $the_query->the_post(); ?>
		<li><span class="won-value"><?php echo get_post_meta( get_the_ID(), '_point_value', true ); ?></span><span class="won-title"><?php the_title(); ?></span></li>
	<?php endwhile; ?></ul>
	<!-- end of the loop -->
</div></section>
	<!-- pagination here -->

	<?php wp_reset_postdata(); ?>

<?php else : ?>
	<p><?php _e( 'Sorry, no posts matched your criteria.' ); ?></p>
<?php endif; ?>

<?php endif; ?>

<?php endforeach; ?>

</div>

		</div></div>
	<?php endwhile; ?>

<?php get_footer(); ?>