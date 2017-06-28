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
        'labels' => array(
        'name' => __( 'Points' ) ),
        'menu_icon' => 'dashicons-portfolio',
        'supports' => array( 'title', 'thumbnail' ),
        'has_archive' => true,
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
       'supports'           => array( 'title', 'thumbnail',  'comments' ),
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
         <label>Week 1: </label><input style="width: 20em;" type="text" name="my_url" value="<?php echo get_post_meta( $post->ID, 'points_week_one', true ); ?>" size="30" disabled />
      </p>

            <p>
         <label>Week 2: </label><input style="width: 20em;" type="text" name="my_url" value="<?php echo get_post_meta( $post->ID, 'points_week_two', true ); ?>" size="30" disabled />
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





function about_add_metabox() {
   add_meta_box(
    'info_section',           // The HTML id attribute for the metabox section
    'About Houseguest',     // The title of your metabox section
    'about_callback',  // The metabox callback function (below)
    'houseguests',
    'side'
  );
}

add_action( 'add_meta_boxes', 'about_add_metabox' );



function about_callback( $post ) {

   // Create a nonce field.
  wp_nonce_field( 'about_metabox', 'about_metabox_nonce' );


   ?>
      <p>
         <label>Age </label><br>
         <input type="number" name="the_age" value="<?php echo get_post_meta( $post->ID, 'get_age', true ); ?>"  />
      </p>

             <p>
         <label>From </label><br>
             <input type="" style="width: 100%"  name="the_from" id="meta-textarea" value="<?php echo get_post_meta( $post->ID, 'get_from', true ); ?>">
      </p>

       <p>
         <label>Occupation </label><br>
         <input type="text"  name="the_gender" value="<?php echo get_post_meta( $post->ID, 'get_gender', true ); ?>"  />
      </p>


       <p>
         <label>Adjectives </label><br>
             <textarea style="width: 100%" name="the_abject" id="meta-textarea"><?php echo get_post_meta( $post->ID, 'get_aject', true ); ?></textarea>

      </p>

       <p>
         <label>Fun Facts </label><br>
             <textarea style="width: 100%"  name="the_fun" id="meta-textarea"><?php echo get_post_meta( $post->ID, 'get_fun', true ); ?></textarea>
      </p>


       <p>
         <label>Motto </label><br>
             <textarea style="width: 100%"  name="the_motto" id="meta-textarea"><?php echo get_post_meta( $post->ID, 'get_motto', true ); ?></textarea>
      </p>

   <?php
}


function about_save_metabox( $post_id ) {
   // Check if our nonce is set.
   if ( ! isset( $_POST['about_metabox_nonce'] ) ) {
      return;
   }

   $nonce = $_POST['about_metabox_nonce'];

   // Verify that the nonce is valid.
   if ( ! wp_verify_nonce( $nonce, 'about_metabox' ) ) {
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
   if ( ! isset( $_POST['the_age'] ) ) {
      return;
   }

    if ( ! isset( $_POST['the_gender'] ) ) {
      return;
   }

    if ( ! isset( $_POST['the_abject'] ) ) {
      return;
   }

    if ( ! isset( $_POST['the_fun'] ) ) {
      return;
   }

     if ( ! isset( $_POST['the_motto'] ) ) {
      return;
   }

        if ( ! isset( $_POST['the_from'] ) ) {
      return;
   }

   $age = $_POST['the_age'] ;
   $gender = $_POST['the_gender'] ;
   $adject = $_POST['the_abject'] ;
   $fun = $_POST['the_fun'] ;
      $motto = $_POST['the_motto'] ;
            $from= $_POST['the_from'] ;



   // Update the meta fields in the database, or clean up after ourselves.
   if ( empty( $age ) ) {
      delete_post_meta( $post_id, 'get_age' );
   } else {
      update_post_meta( $post_id, 'get_age', $age );
   }

      if ( empty( $gender ) ) {
      delete_post_meta( $post_id, 'get_gender' );
   } else {
      update_post_meta( $post_id, 'get_gender', $gender );
   }

      if ( empty( $adject ) ) {
      delete_post_meta( $post_id, 'get_aject' );
   } else {
      update_post_meta( $post_id, 'get_aject', $adject );
   }

      if ( empty( $fun ) ) {
      delete_post_meta( $post_id, 'get_fun' );
   } else {
      update_post_meta( $post_id, 'get_fun', $fun );
   }


         if ( empty( $motto ) ) {
      delete_post_meta( $post_id, 'get_motto' );
   } else {
      update_post_meta( $post_id, 'get_motto', $fun );
   }

            if ( empty( $from ) ) {
      delete_post_meta( $post_id, 'get_from' );
   } else {
      update_post_meta( $post_id, 'get_from', $from );
   }



}
add_action( 'save_post', 'about_save_metabox' );




/**** Weeekly Shenanigans****/




add_action("admin_init", "users_meta_init");

  # code...

function users_meta_init()
{

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


  foreach ($feature_meta_fields as $arr) {

      add_meta_box($arr['meta_id'],$arr['title'], $arr['callback'], "houseguests", "normal", "high");

}



}
// function to display list of authors in select box in post
function weekly_one()
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
add_action('save_post', 'save_one');
function save_one()
{
  global $post;
  if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
    return $post->ID;
  }


  if (isset($_POST["contributor"]) && !empty($_POST["contributor"])) {
    update_post_meta($post->ID, "week_one", implode(",", $_POST["contributor"]));
     update_post_meta($post->ID, "w_one", $_POST["contributor"]);

     foreach ($_POST["contributor"] as $getID) {
     update_post_meta($getID, "points_week_one", $post->post_title);
      }


  }

    else {
      delete_post_meta($post->ID, "week_one", implode(",", $_POST["contributor"]));
      delete_post_meta($post->ID, "w_one", $_POST["contributor"]);
      foreach ($_POST["contributor"] as $getID) {
     delete_post_meta($getID, "points_week_one", $post->post_title);
      }

    }


$args = array(
    'meta_query' => array(
        array(
            'key'     => 'wp__user_like_count',
            'compare' => 'EXISTS'
        )
    )
 );
$user_query = new WP_User_Query( $args );
// Get the results
$users = $user_query->get_results();


  if (!empty($users)) {

foreach($users as $user) {


        $query_posts = array(
        'numberposts' => -1,
        'post_type' => 'houseguests',
        'fields' => 'ids',
        'meta_query' => array (
        array (
          'key' => '_user_liked',
          'value' => $user->ID,
          'compare' => 'LIKE'
        )
        ) );    

  $posts_ids = get_posts($query_posts);

  update_user_meta($user->ID, 'test', $posts_ids);


$args = array('meta_key' => 'week_one', 'post_type' => 'houseguests', 'post__in' => $posts_ids);
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



/**** Week Two ***/


function weekly_two( $post)
{

  wp_nonce_field( basename( __FILE__ ), 'prfx_nonce' );

  $args = array('post_type' => 'points', 'order'=> 'DESC');
  $authors = get_posts( $args );


  $output = '';
  if (!empty($authors)) {
    $output.= '<ul class="categorychecklist form-no-clear">';
    foreach($authors as $author) {
      $author_info = $author->ID;
      $authors_array = explode(",", get_post_meta($post->ID, 'week_two', true));
      if (in_array($author_info, $authors_array)) {
        $author_selected = 'checked';
      }
      else {
        $author_selected = '';
      }
      $output.= '<li>';
      $output.= '<label class="selectit">';
      $output.= '<input type="checkbox" name="two[]" value="' .$author->ID. '" ' . $author_selected . '>' .$author->post_title. ' ' ;
      $output.= '</label></li>';
    }
    $output.= '</ul>';
  }
  else {
    $output.= _x('No Contributor found.', 'rtPanel');
  }
  echo $output;
}


add_action('save_post', 'save_two');

function save_two($post_id)
{
  // Checks save status
    $is_autosave = wp_is_post_autosave( $post_id );
    $is_revision = wp_is_post_revision( $post_id );
    $is_valid_nonce = ( isset( $_POST[ 'prfx_nonce' ] ) && wp_verify_nonce( $_POST[ 'prfx_nonce' ], basename( __FILE__ ) ) ) ? 'true' : 'false';
 
    // Exits script depending on save status
    if ( $is_autosave || $is_revision || !$is_valid_nonce ) {
        return;
    }

        if( isset( $_POST[ 'two' ] ) ) {
        update_post_meta( $post_id, 'week_two', implode(",", $_POST["two"]) );
        update_post_meta($post_id, "w_two", $_POST["two"]);

        foreach ($_POST["two"] as $getID) {
        update_post_meta($getID, "points_week_two", get_the_title( $post_id ));}
       
       }

       else {
         delete_post_meta( $post_id, 'week_two', implode(",", $_POST["two"]) );
        delete_post_meta($post_id, "w_two", $_POST["two"]);
        

        foreach ($_POST["two"] as $getID) {
        delete_post_meta($getID, "points_week_two", get_the_title( $post_id ));
         update_post_meta(4, "test", $getID);
       
       }


         }


         $args = array(
    'meta_query' => array(
        array(
            'key'     => 'wp__user_like_count',
            'compare' => 'EXISTS'
        )
    )
 );
$user_query = new WP_User_Query( $args );
// Get the results
$users = $user_query->get_results();


  if (!empty($users)) {

foreach($users as $user) {


        $query_posts = array(
        'numberposts' => -1,
        'post_type' => 'houseguests',
        'fields' => 'ids',
        'meta_query' => array (
        array (
          'key' => '_user_liked',
          'value' => $user->ID,
          'compare' => 'LIKE'
        )
        ) );    

  $posts_ids = get_posts($query_posts);

  update_user_meta($user->ID, 'test', $posts_ids);


$args = array('meta_key' => 'week_one', 'post_type' => 'houseguests', 'post__in' => $posts_ids);
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
