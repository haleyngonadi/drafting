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





function week_one_metabox() {
   add_meta_box(
    'one_section',           // The HTML id attribute for the metabox section
    'Week 1',     // The title of your metabox section
    'one_callback',  // The metabox callback function (below)
    'houseguests',
    'normal',
    'high'                 
  );
}
add_action( 'add_meta_boxes', 'week_one_metabox' );

$prefix = 'location_';
$location_meta_fields = array(
    array(
        'label'=> 'Game Servers',
        'desc'  => 'Display this location in the Game Servers List page sidebar',
        'id'    => 'gameservers',
        'type'  => 'checkbox'
    ),
    array(
        'label'=> 'Voice Servers',
        'desc'  => 'Display this location in the Voice Servers List page sidebar',
        'id'    => 'voiceservers',
        'type'  => 'checkbox'
    ),
    array(
        'label'=> 'VPS Hosting',
        'desc'  => 'Display this location in the VPS Hosting sidebar',
        'id'    => 'vpshosting',
        'type'  => 'checkbox'
    ),
    array(
        'label'=> 'Web Hosting',
        'desc'  => 'Display this location in the Web Hosting sidebar',
        'id'    => 'webhosting',
        'type'  => 'checkbox'
    ),

);


function one_callback( $post ) {

    global $location_meta_fields, $post;
    // Use nonce for verification
    echo '<input type="hidden" name="location_meta_box_nonce" value="'.wp_create_nonce(basename(__FILE__)).'" />';
    // Begin the field table and loop
    echo '<table class="form-table">';
    foreach ($location_meta_fields as $field) {
        // get value of this field if it exists for this post
        $meta = get_post_meta($post->ID, $field['id'], true);
        // begin a table row with
        echo '<tr>
                <th><label for="'.$field['id'].'">'.$field['label'].'</label></th>
                <td>';
        switch($field['type']) {
            // text
            case 'text':
                echo '<input type="text" name="'.$field['id'].'" id="'.$field['id'].'" value="'.$meta.'" size="30" />
                    <br /><span class="description">'.$field['desc'].'</span>';
                break;
            // checkbox
            case 'checkbox':
                echo '<input type="checkbox" name="'.$field['id'].'" id="'.$field['id'].'" ',$meta ? ' checked="checked"' : '','/>
                    <label for="'.$field['id'].'">'.$field['desc'].'</label>';
                break;
        } //end switch
        echo '</td></tr>';
    } // end foreach
    echo '</table>'; // end table
}

// Save the Data
function save_location_meta($post_id) {
    global $location_meta_fields;
    // verify nonce
    if (!isset($_POST['location_meta_box_nonce']) || !wp_verify_nonce($_POST['location_meta_box_nonce'], basename(__FILE__)))
        return $post_id;
    // check autosave
    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE)
        return $post_id;
    // check permissions
    if ('page' == $_POST['post_type']) {
        if (!current_user_can('edit_page', $post_id))
            return $post_id;
    } elseif (!current_user_can('edit_post', $post_id)) {
        return $post_id;
    }
    // loop through fields and save the data
    foreach ($location_meta_fields as $field) {
        $old = get_post_meta($post_id, $field['id'], true);
        $new = $_POST[$field['id']];
        if($new == '' && !$old && array_key_exists('default',$field)){
            $new = $field['default'];
        }
        if ($new != '' && $new != $old) {
            update_post_meta($post_id, $field['id'], $new);

            $post_users = get_weekly_stats( $post_id, $field['id'], $new );

            if ( $post_users ) {
             update_post_meta($post_id,'test', $post_users);
           }


        } elseif ($new == '' && $old != '') {

          $post_users = get_weekly_stats( $post_id, $field['id'], $old );

          $uid_key = array_search( $field['id'], $post_users);

          unset( $post_users[$uid_key] );

          update_post_meta( $post_id, "_test_one", $uid_key );

            update_post_meta( $post_id, "test", $post_users );



            delete_post_meta($post_id, $field['id'], $old);

        }
    } // end foreach
}
add_action('save_post', 'save_location_meta');




function get_weekly_stats( $post_id, $actions, $week ) {
  $post_users = '';
  $post_meta_users = get_post_meta( $post_id, $actions, $week  );
  if ( count( $post_meta_users ) != 0 ) {
    $post_users = $post_meta_users[0];
  }
  if ( !is_array( $post_users ) ) {
    $post_users = array();
  }
  if ( !in_array( $actions, $post_users ) ) {
    $post_users['user-' . $actions] = $actions;
  }
  return $post_users;
}