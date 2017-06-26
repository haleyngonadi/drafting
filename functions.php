<?php

/**
 * Drafting functions and definitions
 *
 * @package WordPress
 * @subpackage Drafting
 * @since Drafting 1.0
 */


include('post-like.php');



if ( ! isset( $content_width ) ) {
	$content_width = 474;
}


/*** Basic Fuctions***/

add_theme_support( 'post-thumbnails' );

/*** Enqueue Styles and Scripts ***/


function wpb_adding_styles() {
wp_register_script('my_stylesheet', plugins_url('my-stylesheet.css', __FILE__));
wp_enqueue_script('my_stylesheet');
}

//add_action( 'wp_enqueue_scripts', 'wpb_adding_styles' );  



function wpb_adding_scripts() {
wp_register_script('main_js', get_template_directory_uri() . '/js/main.js', array('jquery'),'1.2', true);
wp_enqueue_script('main_js');
}

add_action( 'wp_enqueue_scripts', 'wpb_adding_scripts' );  



/*** Post Type ***/


function book_setup_post_type() {
    $args = array(
        'public'    => true,
        'label'     => __( 'Points' ),
        'menu_icon' => 'dashicons-portfolio',
        'supports'           => array( 'title' ),
    );
    register_post_type( 'points', $args );
}
add_action( 'init', 'book_setup_post_type' );



add_action( 'init', 'create_post_type' );
function create_post_type() {
  register_post_type( 'houseguests',
    array(
      'labels' => array(
        'name' => __( 'Houseguests' ),
        'singular_name' => __( 'Houseguest' ),
        'new_item'              => __( 'New Houseguest' ),
        'edit_item'             => __( 'Edit Houseguest' ),
        'view_item'             => __( 'View Houseguest' ),
        'all_items'             => __( 'All Houseguests' ),
        'menu_name'             => _x( 'Houseguests', 'Admin Menu text'),
        'name_admin_bar'        => _x( 'Houseguests', 'Add New on Toolbar'),
        'add_new'               => __( 'Add Houseguest'),
        'add_new_item'          => __( 'Add Houseguest'),
         'featured_image'        => _x( 'Houseguest Photo', 'Overrides the “Featured Image” phrase for this post type. Added in 4.3' )

      ),
      'public' => true,
      'has_archive' => true,
       'menu_icon' => 'dashicons-groups',
       'supports'           => array( 'title', 'editor', 'thumbnail',  'comments' ),
    )
  );
}

/**
 * Add the metabox.
 */

function my_url_add_metabox() {
   add_meta_box(
		'basic_section',           // The HTML id attribute for the metabox section
		'Information',     // The title of your metabox section
		'basic_callback',  // The metabox callback function (below)
		'points',
		'normal'                 
	);
}
add_action( 'add_meta_boxes', 'my_url_add_metabox' );


function points_add_metabox() {
   add_meta_box(
    'points_section',           // The HTML id attribute for the metabox section
    'Weekly',     // The title of your metabox section
    'week_callback',  // The metabox callback function (below)
    'points',
    'normal'                 
  );
}
add_action( 'add_meta_boxes', 'points_add_metabox' );

/**
 * Print the metabox content.
 */

function basic_callback( $post ) {

   // Create a nonce field.
	wp_nonce_field( 'my_url_metabox', 'my_url_metabox_nonce' );

	// Retrieve a previously saved value, if available.
	$url = get_post_meta( $post->ID, '_point_value', true );

   // Create the metabox field mark-up.
   ?>
      <p>
         <label>Score </label><input type="number" name="my_url" value="<?php echo $url; ?>"  />
      </p>
   <?php
}


function week_callback( $post ) {

   // Create a nonce field.
  wp_nonce_field( 'points_add_metabox', 'points_add_metabox_nonce' );

   ?>
      <p>
         <label>Week 1: </label><input style="width: 20em;" type="text" name="my_url" value="<?php echo get_post_meta( $post->ID, 'week_one', true ); ?>" size="30" disabled />
      </p>
   <?php
}

/**
 * Save the metabox.
 */

function my_url_save_metabox( $post_id ) {
   // Check if our nonce is set.
   if ( ! isset( $_POST['my_url_metabox_nonce'] ) ) {
      return;
   }

   $nonce = $_POST['my_url_metabox_nonce'];

   // Verify that the nonce is valid.
   if ( ! wp_verify_nonce( $nonce, 'my_url_metabox' ) ) {
      return;
   }

   // If this is an autosave, our form has not been submitted, so we don't want to do anything.
   if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
      return;
   }

   // Check the user's permissions.
    if ( ! current_user_can( 'edit_post', $post_id ) ) {
      return;
   }

   // Check for and sanitize user input.
   if ( ! isset( $_POST['my_url'] ) ) {
      return;
   }

   $url = $_POST['my_url'] ;

   // Update the meta fields in the database, or clean up after ourselves.
   if ( empty( $url ) ) {
      delete_post_meta( $post_id, '_point_value' );
   } else {
      update_post_meta( $post_id, '_point_value', $url );
   }
}
add_action( 'save_post', 'my_url_save_metabox' );



/**** Weeekly Shenanigans****/


$prefix = 'week_';
$feature_meta_fields = array(
    array(
        'meta_id'=>  $prefix.'1',
        'title'  => 'Week 1',
        'callback' => 'weekly_one',
    ),
    array(
        'meta_id'=>  $prefix.'2',
        'title'  => 'Week 2',
        'callback' => 'weekly_two',
    ),
    array(
        'meta_id'=>  $prefix.'3',
        'title'  => 'Week 3',
        'callback' => 'weekly_three',
    ),
    array(
         'meta_id'=>  $prefix.'4',
        'title'  => 'Week 4',
        'callback' => 'weekly_four',
    ),
    array(
        'meta_id'=>  $prefix.'5',
        'title'  => 'Week 5',
        'callback' => 'weekly_five',
    ),
    array(
         'meta_id'=>  $prefix.'6',
        'title'  => 'Week 6',
        'callback' => 'weekly_six',
    ),
        array(
        'meta_id'=>  $prefix.'7',
        'title'  => 'Week 7',
        'callback' => 'weekly_seven',
    ),
    array(
        'meta_id'=>  $prefix.'8',
        'title'  => 'Week 8',
        'callback' => 'weekly_eight',
    ),
    array(
        'meta_id'=>  $prefix.'9',
        'title'  => 'Week 9',
        'callback' => 'weekly_nine',
    ),
    array(
         'meta_id'=>  $prefix.'10',
        'title'  => 'Week 10',
        'callback' => 'weekly_ten',
    ),
    array(
        'meta_id'=>  $prefix.'11',
        'title'  => 'Week 11',
        'callback' => 'weekly_eleven',
    ),
    array(
         'meta_id'=>  $prefix.'12',
        'title'  => 'Week 12',
        'callback' => 'weekly_twelve',
    )
);


add_action("admin_init", "users_meta_init");

  # code...

function users_meta_init()
{

print_r($feature_meta_fields);
  foreach ($feature_meta_fields as $feature) {
    # code...
  
  add_meta_box($feature->meta_id, $feature->title, "users", "houseguests", "normal", "high");

}
}
// function to display list of authors in select box in post
function users()
{
  global $post;

  $args = array('post_type' => 'points', 'order'=> 'DESC');
  $authors = get_posts( $args );


  $output = '';
  if (!empty($authors)) {
    $output.= '<ul class="categorychecklist form-no-clear">';
    foreach($authors as $author) {
      $author_info = $author->ID;
      $authors_array = explode(",", get_post_meta($post->ID, 'week_one', true));
      if (in_array($author_info, $authors_array)) {
        $author_selected = 'checked';
      }
      else {
        $author_selected = '';
      }
      $output.= '<li>';
      $output.= '<label class="selectit">';
      $output.= '<input type="checkbox" name="contributor[]" value="' .$author->ID. '" ' . $author_selected . '>' .$author->post_title. ' ' ;
      $output.= '</label></li>';
    }
    $output.= '</ul>';
  }
  else {
    $output.= _x('No Contributor found.', 'rtPanel');
  }
  echo $output;
}
// Save Meta Details
add_action('save_post', 'save_userlist');
function save_userlist()
{
  global $post;
  if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
    return $post->ID;
  }


  //   if ( in_array( 'gameservers',$_POST["contributor"] ) ) {
  // // unset($_POST['contributor'][array_search( 'gameservers', $_POST['contributor'] )]);
  //  $_POST["contributor"]['billons']['value'] = '678';
  //  $_POST["contributor"]['billons']['houseguest'] = $post->title;
  //  $_POST["contributor"]['billons']['post_id'] = $post->ID;
  // }




  if (isset($_POST["contributor"]) && !empty($_POST["contributor"])) {
    update_post_meta($post->ID, "week_one", implode(",", $_POST["contributor"]));
     update_post_meta($post->ID, "w_one", $_POST["contributor"]);



     update_post_meta(implode("", $_POST["contributor"]), "week_one", $post->post_title);


  }

    else {
      delete_post_meta($post->ID, "week_one", implode(",", $_POST["contributor"]));
      delete_post_meta($post->ID, "w_one", $_POST["contributor"]);
     delete_post_meta(implode("", $_POST["contributor"]), "week_one", $post->post_title);

    }


$args = array(
    'meta_query' => array(
        array(
            'key'     => 'wp_user_drafts',
            'compare' => 'EXISTS'
        )
    )
 );
$user_query = new WP_User_Query( $args );
// Get the results
$users = $user_query->get_results();


  if (!empty($users)) {

foreach($users as $user) {



  $the_posts = get_user_meta($user->ID, 'wp__user_post', true);
    $array = array_map( 'trim', explode( ',', $the_posts ) ); 


$args = array('meta_key' => 'week_one', 'post_type' => 'houseguests', 'post__in' => $array);
$lastposts = get_posts( $args );

$string = '';

foreach ( $lastposts as $post ) {


  $key_1_value = get_post_meta($post->ID, 'week_one', true );
  if ( ! empty( $key_1_value ) ) {
     $string .= $key_1_value.', ';
  }

}
$string =  rtrim($string, ', ');


update_user_meta($user->ID, 'week_one', $string);


}

}


}
