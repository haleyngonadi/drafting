<?php
/**
 * The template for displaying all pages
 *
 * This is the template that displays all pages by default.
 * Please note that this is the WordPress construct of pages and that
 * other 'pages' on your WordPress site will use a different template.
 *
 * @package WordPress
 * @subpackage Twenty_Fourteen
 * @since Twenty Fourteen 1.0
 */

get_header(); ?>

<div id="main-content" class="main-content">



<!--?php 
$mydata = get_user_meta( 2, "wp_user_drafts", true );
echo implode(", ", $mydata)

?-->

	<div id="primary" class="content-area">
		<div id="content" class="site-content" role="main">

<article id="houseguest-<?php the_ID(); ?>" <?php post_class(); ?>>
		<?php while ( have_posts() ) : the_post(); ?>

	<?php
		// Page thumbnail and title.
		the_post_thumbnail();
		the_title( '<header class="entry-header"><h1 class="entry-title">', '</h1></header><!-- .entry-header -->' );
	?>

	<div class="entry-content">
		<?php the_content();?>


		<?php echo get_simple_likes_button( get_the_ID() );?>
go felicidad away!!!



<ul>
<?php

global $post;

  $user_id = get_current_user_id();
  $key = 'wp__user_post';
  $single = true;
  $user_last = get_user_meta( $user_id, $key, $single ); 
  echo '<p>The '. $key . ' value for user id ' . $user_id . ' is: ' . $user_last . '</p>'; 


//$array = array_map( 'trim', explode( ', ', $user_last ) ); 

$args = array('meta_key' => 'week_one', 'post_type' => 'houseguests' );
$lastposts = get_posts( $args );

$string = '';

foreach ( $lastposts as $post ):

  $key_1_value = get_post_meta($post->ID, 'week_one', true );
  if ( ! empty( $key_1_value ) ) {
     $string .= $key_1_value.', ';
  }

  endforeach;

$string =  rtrim($string, ', ');

 echo $string;

$authors_array = explode(", ", $string);
       

$array = array(
    'key1' => 'value1',
    'key2' => 'value2',
);

 $authors_array = explode(", ", $string);


if (in_array('gameservers', $authors_array)) {
    $array['gameservers']['score'] = 5;
    $array['gameservers']['houseguests'] = 'Christmas';

}



$multiarray[] = $array;


$json = json_encode($array);

//echo $json;



?>

</ul>

		<?php endwhile; // end of the loop. ?>
	</div><!-- .entry-content -->
</article><!-- #post-## -->

		</div><!-- #content -->
	</div><!-- #primary -->
	
</div><!-- #main-content -->

<?php get_footer();?>
