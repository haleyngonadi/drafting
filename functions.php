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
		'Basic Information',     // The title of your metabox section
		'basic_callback',  // The metabox callback function (below)
		'houseguests',
		'side'                 
	);
}
add_action( 'add_meta_boxes', 'my_url_add_metabox' );

/**
 * Print the metabox content.
 */

function basic_callback( $post ) {

   // Create a nonce field.
	wp_nonce_field( 'my_url_metabox', 'my_url_metabox_nonce' );

	// Retrieve a previously saved value, if available.
	$url = get_post_meta( $post->ID, '_my_url', true );

   // Create the metabox field mark-up.
   ?>
      <p>
         <label>Sex </label><input style="width: 20em;" type="text" name="my_url" value="<?php echo esc_url( $url ); ?>" size="30" class="regular-text" />
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

   $url = esc_url_raw( $_POST['my_url'] );

   // Update the meta fields in the database, or clean up after ourselves.
   if ( empty( $url ) ) {
      delete_post_meta( $post_id, '_my_url' );
   } else {
      update_post_meta( $post_id, '_my_url', $url );
   }
}
add_action( 'save_post', 'my_url_save_metabox' );



add_action("admin_init", "users_meta_init");
function users_meta_init()
{
  add_meta_box("users-meta", "Week 1", "users", "houseguests", "normal", "high");
}
// function to display list of authors in select box in post
function users()
{
  global $post;
  $authors = array(
    array(
        'label'=> 'Game Servers',
        'id'    => 'gameservers',
    ),
    array(
        'label'=> 'Voice Servers',
        'id'    => 'voiceservers',
    ),
    array(
        'label'=> 'VPS Hosting',
        'id'    => 'vpshosting',
    ),
    array(
        'label'=> 'Web Hosting',
        'id'    => 'webhosting',
    ),

);

  $output = '';
  if (!empty($authors)) {
    $output.= '<ul class="categorychecklist form-no-clear">';
    foreach($authors as $author) {
      $author_info = $author['id'];
      $authors_array = explode(",", get_post_meta($post->ID, 'week_one', true));
      if (in_array($author_info, $authors_array)) {
        $author_selected = 'checked';
      }
      else {
        $author_selected = '';
      }
      $output.= '<li>';
      $output.= '<label class="selectit">';
      $output.= '<input type="checkbox" name="contributor[]" value="' .$author['id']. '" ' . $author_selected . '>' .$author['label']. ' ' ;
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
  if (isset($_POST["contributor"]) && !empty($_POST["contributor"])) {
    update_post_meta($post->ID, "week_one", implode(",", $_POST["contributor"]));}

    else {
      delete_post_meta($post->ID, "week_one", implode(",", $_POST["contributor"]));
    }


    $args = array(
    'meta_query' => array(
        array(
            'key'     => 'wp_user_drafts',
            'value' => $post->ID,
            'compare' => 'LIKE'
        )
    )
 );
$user_query = new WP_User_Query( $args );
// Get the results
$users = $user_query->get_results();


  if ( in_array( 'voiceservers',$_POST["contributor"] ) ) {
   $_POST["contributor"]['voiceservers'] = '234';
  }

  if ( in_array( 'gameservers',$_POST["contributor"] ) ) {
   // unset($_POST['contributor'][array_search( 'gameservers', $_POST['contributor'] )]);

    $_POST['contributor'][array_search( 'gameservers', $_POST['contributor'] )] = '456';


  // $_POST["contributor"]['gameservers'] = '678';
  }

  if ( in_array( 'vpshosting',$_POST["contributor"] ) ) {
   $_POST["contributor"]['vpshosting'] = '097';
  }


  if (!empty($users)) {

foreach($users as $user) {

  $data1 = "week_1_";
$data2 = $post->ID;
$result = $data1 . '' . $data2;


  if((isset($_POST["contributor"])) && (!empty($_POST["contributor"]))){


 update_user_meta($user->ID, $result, $_POST["contributor"]);}

 else {
   delete_user_meta($user->ID, $result, $_POST["contributor"]);

 }


}




}

}