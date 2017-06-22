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



		<?php endwhile; // end of the loop. ?>
	</div><!-- .entry-content -->
</article><!-- #post-## -->

		</div><!-- #content -->
	</div><!-- #primary -->
	
</div><!-- #main-content -->

<?php get_footer();?>
