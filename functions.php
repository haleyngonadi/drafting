<?php

/**
 * Drafting functions and definitions
 *
 * @package WordPress
 * @subpackage Drafting
 * @since Drafting 1.0
 */


include('new-like.php');



if ( ! isset( $content_width ) ) {
	$content_width = 800;
}


/*** Basic Fuctions***/

add_theme_support( 'post-thumbnails' );
add_image_size( 'homepage-thumb', 400, 400, true );
add_image_size( 'hg-thumb', 300, 300, array( 'center', 'top' ) );


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

/*** Register Menu ***/


function register_my_menus() {
  register_nav_menus(
    array(
      'header-menu' => __( 'Header Menu' ),
       'right-menu' => __( 'Right Menu' ),
     )
   );
 }
 add_action( 'init', 'register_my_menus' );




/*** Post Type ***/


function book_setup_post_type() {
    $args = array(
        'public'    => true,
        'labels' => array(
        'name' => __( 'Points' ) ),
        'menu_icon' => 'dashicons-portfolio',
        'supports' => array( 'title'),
        'has_archive' => false,
    );
    register_post_type( 'points', $args );
}
add_action( 'init', 'book_setup_post_type' );



function notify_type() {
    $args = array(
        'public'    => true,
        'labels' => array(
        'name' => __( 'Notifications' ),
        'new_item'              => __( 'New Notification' ),
        'edit_item'             => __( 'Edit Notification' ),
        'view_item'             => __( 'View Notification' ),
        'all_items'             => __( 'All Notifications' ),
        'add_new'               => __( 'Add Notification'),
        'add_new_item'          => __( 'Add Notification') ),
        'menu_icon' => 'dashicons-format-status',
        'supports' => array( 'title', 'editor'),
        'has_archive' => true,
    );
    register_post_type( 'notification', $args );
}
add_action( 'init', 'notify_type' );




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
      'has_archive' => false,
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


function drafts_metabox() {
   add_meta_box(
		'drafts_section',           // The HTML id attribute for the metabox section
		'Drafted By:',     // The title of your metabox section
		'drafts_callback',  // The metabox callback function (below)
		'houseguests',
		'side'                 
	);
}
add_action( 'add_meta_boxes', 'drafts_metabox' );


/**
 * Print the metabox content.
 */

function drafts_callback( $post ) {

   // Create a nonce field.
	wp_nonce_field( 'drafts_metabox', 'drafts_metabox_nonce' );

	// Retrieve a previously saved value, if available.
	$getdrafts = get_post_meta( $post->ID, '_user_drafted', true );

$blogusers = get_users( array( 'include' => $getdrafts ) );
// Array of WP_User objects.
foreach ( $blogusers as $user ) :
   ?>

      <p>
         <label><b>Name</b>: </label><?php echo '<span>' . esc_html( $user->first_name ) . '</span>';?><br>
          <label><b>ID</b>: </label><?php echo ' <span>' . esc_html( $user->ID ) . '</span>';?>
      </p>



    
   <?php endforeach;
}





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

       <p>
         <label>Week 3: </label><input style="width: 20em;" type="text" name="my_url" value="<?php echo get_post_meta( $post->ID, 'points_week_three', true ); ?>" size="30" disabled />
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

  $prfx_stored_meta = get_post_meta( $post->ID );


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


             <p>
         <label>Status </label><br>
             
              <div class="prfx-row-content">
        <label for="meta-radio-one">
            <input type="radio" name="meta-radio" id="meta-radio-one" value="evicted" <?php if ( isset ( $prfx_stored_meta['meta-radio'] ) ) checked( $prfx_stored_meta['meta-radio'][0], 'evicted' ); ?>>
            <?php _e( 'Evicted', 'prfx-textdomain' )?>
        </label>
        <label for="meta-radio-two">
            <input type="radio" name="meta-radio" id="meta-radio-two" value="game" <?php if ( isset ( $prfx_stored_meta['meta-radio'] ) ) checked( $prfx_stored_meta['meta-radio'][0], 'game' ); ?>>
            <?php _e( 'In The Game', 'prfx-textdomain' )?>
        </label>
    </div>

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
      update_post_meta( $post_id, 'get_motto', $motto );
   }

            if ( empty( $from ) ) {
      delete_post_meta( $post_id, 'get_from' );
   } else {
      update_post_meta( $post_id, 'get_from', $from );
   }

if( isset( $_POST[ 'meta-radio' ] ) ) {
    update_post_meta( $post_id, 'meta-radio', $_POST[ 'meta-radio' ] );
}



}
add_action( 'save_post', 'about_save_metabox' );




/**** Weeekly Shenanigans****/




add_action("admin_init", "users_meta_init");

  # code...

function users_meta_init()
{


add_meta_box('boxes', 'Weekly', 'weekly_callback', "houseguests", "normal", "high");

}
// function to display list of authors in select box in post
function weekly_callback()
{
  global $post;

  $args = array('post_type' => 'points', 'order'=> 'ASC', 'posts_per_page'=>-1);
  $authors = get_posts( $args );


$prefix = 'week_';
$feature_meta_fields = array(
    array(
        'meta_id'=>  $prefix.'1',
        'title'  => 'Week 1',
        'callback' => 'weekly_one',
        'get' => 'one[]',
        'week' => 'week_one',


    ),
    array(
        'meta_id'=>  $prefix.'2',
        'title'  => 'Week 2',
        'callback' => 'weekly_two',
        'get' => 'two[]',
        'week' => 'week_two',
    ),
    array(
        'meta_id'=>  $prefix.'3',
        'title'  => 'Week 3',
        'callback' => 'weekly_three',
        'get' => 'three[]',
        'week' => 'week_three',
    ),
    array(
         'meta_id'=>  $prefix.'4',
        'title'  => 'Week 4',
        'callback' => 'weekly_four',
        'get' => 'four[]',
        'week' => 'week_four',
    ),
    array(
        'meta_id'=>  $prefix.'5',
        'title'  => 'Week 5',
        'callback' => 'weekly_five',
        'get' => 'five[]',
        'week' => 'week_five',
    ),
    array(
         'meta_id'=>  $prefix.'6',
        'title'  => 'Week 6',
        'callback' => 'weekly_six',
        'get' => 'six[]',
        'week' => 'week_six',
    ),
        array(
        'meta_id'=>  $prefix.'7',
        'title'  => 'Week 7',
        'callback' => 'weekly_seven',
        'get' => 'seven[]',
        'week' => 'week_seven',
    ),
        array(
        'meta_id'=>  $prefix.'double',
        'title'  => 'Double Eviction',
        'callback' => 'double_eviction',
        'get' => 'double[]',
        'week' => 'double_week',
    ),
    array(
        'meta_id'=>  $prefix.'8',
        'title'  => 'Week 8',
        'callback' => 'weekly_eight',
        'get' => 'eight[]',
        'week' => 'week_eight',
    ),
    array(
        'meta_id'=>  $prefix.'9',
        'title'  => 'Week 9',
        'callback' => 'weekly_nine',
        'get' => 'nine[]',
        'week' => 'week_nine',
    ),
    array(
         'meta_id'=>  $prefix.'10',
        'title'  => 'Week 10',
        'callback' => 'weekly_ten',
        'get' => 'ten[]',
        'week' => 'week_ten',
    ),
    array(
        'meta_id'=>  $prefix.'11',
        'title'  => 'Week 11',
        'callback' => 'weekly_eleven',
        'get' => 'eleven[]',
        'week' => 'week_eleven',
    ),
    array(
         'meta_id'=>  $prefix.'12',
        'title'  => 'Week 12',
        'callback' => 'weekly_twelve',
        'get' => 'twelve[]',
        'week' => 'week_twelve',
    )
);

foreach ($feature_meta_fields as $fields) {

  $output = '';
  if (!empty($authors)) {
    $output.= '<ul class="categorychecklist form-no-clear">';
      $output.= '<h3>' .$fields['title']. '</h3>';

    foreach($authors as $author) {
      $author_info = $author->ID;
      $authors_array = explode(",", get_post_meta($post->ID, $fields['week'], true));
      if (in_array($author_info, $authors_array)) {
        $author_selected = 'checked';
      }
      else {
        $author_selected = '';
      }

      $output.= '<li>';
      $output.= '<label class="selectit">';
      $output.= '<input type="checkbox" name="' .$fields['get']. '" value="' .$author->ID. '" ' . $author_selected . '>' .$author->post_title. ' ' ;
      $output.= '</label></li>';

    }


    $output.= '</ul>';
  }
  else {
    $output.= _x('No Contributor found.', 'rtPanel');
  }
  echo $output;

}


}


// Save Meta Details
add_action('save_post', 'save_one');
function save_one()
{
  global $post;
  if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
    return $post->ID;
  }

     // Check the user's permissions.
    if ( ! current_user_can( 'edit_post', $post->ID ) ) {
      return;
   }

  $prefix = 'week_';
$feature_meta_fields = array(
    array(
        'meta_id'=>  $prefix.'1',
        'title'  => 'Week 1',
        'callback' => 'weekly_one',
        'get' => 'one[]',
        'week' => 'week_one',
        'final' => 'one',
    ),
    array(
        'meta_id'=>  $prefix.'2',
        'title'  => 'Week 2',
        'callback' => 'weekly_two',
        'get' => 'two[]',
        'week' => 'week_two',
        'final' => 'two',

    ),
    array(
        'meta_id'=>  $prefix.'3',
        'title'  => 'Week 3',
        'callback' => 'weekly_three',
        'get' => 'three[]',
        'week' => 'week_three',
        'final' => 'three',

    ),
    array(
         'meta_id'=>  $prefix.'4',
        'title'  => 'Week 4',
        'callback' => 'weekly_four',
        'get' => 'four[]',
        'week' => 'week_four',
        'final' => 'four',

    ),
    array(
        'meta_id'=>  $prefix.'5',
        'title'  => 'Week 5',
        'callback' => 'weekly_five',
        'get' => 'five[]',
        'week' => 'week_five',
        'final' => 'five',

    ),
    array(
         'meta_id'=>  $prefix.'6',
        'title'  => 'Week 6',
        'callback' => 'weekly_six',
        'get' => 'six[]',
        'week' => 'week_six',
        'final' => 'six',

    ),
        array(
        'meta_id'=>  $prefix.'7',
        'title'  => 'Week 7',
        'callback' => 'weekly_seven',
        'get' => 'seven[]',
        'week' => 'week_seven',
        'final' => 'seven',

    ),
        array(
        'meta_id'=>  $prefix.'double',
        'title'  => 'Double Eviction',
        'callback' => 'doubly_eviction',
        'get' => 'double[]',
        'week' => 'double_week',
        'final' => 'double',
    ),

    array(
        'meta_id'=>  $prefix.'8',
        'title'  => 'Week 8',
        'callback' => 'weekly_eight',
        'get' => 'eight[]',
        'week' => 'week_eight',
        'final' => 'eight',

    ),
    array(
        'meta_id'=>  $prefix.'9',
        'title'  => 'Week 9',
        'callback' => 'weekly_nine',
        'get' => 'nine[]',
        'week' => 'week_nine',
        'final' => 'nine',

    ),
    array(
         'meta_id'=>  $prefix.'10',
        'title'  => 'Week 10',
        'callback' => 'weekly_ten',
        'get' => 'ten[]',
        'week' => 'week_ten',
        'final' => 'ten',

    ),
    array(
        'meta_id'=>  $prefix.'11',
        'title'  => 'Week 11',
        'callback' => 'weekly_eleven',
        'get' => 'eleven[]',
        'week' => 'week_eleven',
        'final' => 'eleven',

    ),
    array(
         'meta_id'=>  $prefix.'12',
        'title'  => 'Week 12',
        'callback' => 'weekly_twelve',
        'get' => 'twelve[]',
        'week' => 'week_twelve',
        'final' => 'twelve',

    )
);




foreach ($feature_meta_fields as $fields) {







    if (isset($_POST[$fields['final']]) && !empty($_POST[$fields['final']])) {


    update_post_meta($post->ID, $fields['week'], implode(",", $_POST[$fields['final']]));

    $data1 = "w_"; $data2 = $fields['final']; $fin = $data1 . '' . $data2;


     update_post_meta($post->ID, $fin, $_POST[$fields['final']]);

    $data3 = "points_"; $data4 = $fields['week']; $end = $data3 . '' . $data4;


     foreach ($_POST[$fields['final']] as $getID) {
      update_post_meta($getID, $end, $post->post_title);
    }


    }

    else {
      delete_post_meta($post->ID, $fields['week'], $_POST[$fields['final']]);

      $data1 = "w_"; $data2 = $fields['final']; $fin = $data1 . '' . $data2;

      delete_post_meta($post->ID, $fin, $_POST[$fields['final']]);


    }



$args = array(
    'meta_query' => array(
        array(
            'key'     => '_user_draft_count',
            'compare' => 'EXISTS'
        )
    )
 );
$user_query = new WP_User_Query( $args );
$users = $user_query->get_results();



foreach($users as $user) {
  

      $likedposts = get_user_meta( $user->ID,'_drafted', 'true');


$draftquery = array('meta_key' => $fields['week'], 'post_type' => 'houseguests', 'post__in' => $likedposts);
$getalldrafts = get_posts( $draftquery );
$string = '';

foreach ( $getalldrafts as $thedrafts ) {
  $key_1_value =get_post_meta($thedrafts->ID, $fields['week'], true );
  if ( ! empty( $key_1_value ) ) {
     $string .= $key_1_value.', ';
  }

}
$string =  rtrim($string, ', ');

  if (!empty($string)) {

  	update_user_meta($user->ID, $fields['week'], $string);

$array = array_map( 'trim', explode( ',', $string ) );


	$args = array('post_type' => 'points', 'post__in' => $array);
	$the_query = get_posts( $args );


		$sum = '';
		foreach ( $the_query as $points ) {
		$key_1_value =get_post_meta($points->ID, '_point_value', true );
		if ( ! empty( $key_1_value ) ) {
		$sum+=  $key_1_value;
		}

	}


		$data1 = "total_"; $data2 = $fields['week']; $sim = $data1 . '' . $data2;
		update_user_meta($user->ID, $sim, $sum);

		$totalvalues = array(
    	array('final' => 'total_week_one'),
    	array('final' => 'total_week_two'),
    	array('final' => 'total_week_three'),
		array('final' => 'total_week_four'),
    	array('final' => 'total_week_five'),
    	array('final' => 'total_week_six'),
    	array('final' => 'total_week_seven'),
    	array('final' => 'total_week_eight'),
    	array('final' => 'total_week_nine'),
		array('final' => 'total_week_ten'),
    	array('final' => 'total_week_eleven'),
    	array('final' => 'total_week_twelve'),
      array('final' => 'total_double_week')

    	);

		$add = '';
		foreach ( $totalvalues as $gettotal ) {
		$figure =get_user_meta($user->ID, $gettotal['final'], true );
		if ( ! empty( $figure ) ) {
		$add+=  $figure;
		}

		}



	 update_user_meta($user->ID, 'totals', $add); 


} /*** end if string ***/

}/*** end for each user ***/




}







}




function wpse_149342_pre_user_query( $query )
{
    remove_action( current_action(), __FUNCTION__ );

    $query->query_orderby = str_replace( 
        'meta_value', 
        'meta_value+0', 
        $query->query_orderby 
    );
}



/*** Breadcrumbs ***/

// Breadcrumbs
function custom_breadcrumbs() {
       
    // Settings
    $separator          = '&gt;';
    $breadcrums_id      = 'breadcrumbs';
    $breadcrums_class   = 'breadcrumbs';
    $home_title         = 'Homepage';
      
    // If you have any custom post types with custom taxonomies, put the taxonomy name below (e.g. product_cat)
    $custom_taxonomy    = 'product_cat';
       
    // Get the query & post information
    global $post,$wp_query;
       
    // Do not display on the homepage
    if ( !is_front_page() ) {
       
        // Build the breadcrums
        echo '<ul id="' . $breadcrums_id . '" class="' . $breadcrums_class . '">';
           
        // Home page
        echo '<li class="item-home"><a class="bread-link bread-home" href="' . get_home_url() . '" title="' . $home_title . '">' . $home_title . '</a></li>';
        echo '<li class="separator separator-home"> ' . $separator . ' </li>';
           
        if ( is_archive() && !is_tax() && !is_category() && !is_tag() ) {
              
            echo '<li class="item-current item-archive"><strong class="bread-current bread-archive">' . post_type_archive_title($prefix, false) . '</strong></li>';
              
        } else if ( is_archive() && is_tax() && !is_category() && !is_tag() ) {
              
            // If post is a custom post type
            $post_type = get_post_type();
              
            // If it is a custom post type display name and link
            if($post_type != 'post') {
                  
                $post_type_object = get_post_type_object($post_type);
                $post_type_archive = get_post_type_archive_link($post_type);
              
                echo '<li class="item-cat item-custom-post-type-' . $post_type . '"><a class="bread-cat bread-custom-post-type-' . $post_type . '" href="' . $post_type_archive . '" title="' . $post_type_object->labels->name . '">' . $post_type_object->labels->name . '</a></li>';
                echo '<li class="separator"> ' . $separator . ' </li>';
              
            }
              
            $custom_tax_name = get_queried_object()->name;
            echo '<li class="item-current item-archive"><strong class="bread-current bread-archive">' . $custom_tax_name . '</strong></li>';
              
        } else if ( is_single() ) {
              
            // If post is a custom post type
            $post_type = get_post_type();
              
            // If it is a custom post type display name and link
            if($post_type != 'post') {
                  
                $post_type_object = get_post_type_object($post_type);
                $post_type_archive = get_post_type_archive_link($post_type);
              
                echo '<li class="item-cat item-custom-post-type-' . $post_type . '"><a class="bread-cat bread-custom-post-type-' . $post_type . '" href="' . $post_type_archive . '" title="' . $post_type_object->labels->name . '">' . $post_type_object->labels->name . '</a></li>';
                echo '<li class="separator"> ' . $separator . ' </li>';
              
            }
              
            // Get post category info
            $category = get_the_category();
             
            if(!empty($category)) {
              
                // Get last category post is in
                $last_category = end(array_values($category));
                  
                // Get parent any categories and create array
                $get_cat_parents = rtrim(get_category_parents($last_category->term_id, true, ','),',');
                $cat_parents = explode(',',$get_cat_parents);
                  
                // Loop through parent categories and store in variable $cat_display
                $cat_display = '';
                foreach($cat_parents as $parents) {
                    $cat_display .= '<li class="item-cat">'.$parents.'</li>';
                    $cat_display .= '<li class="separator"> ' . $separator . ' </li>';
                }
             
            }
              
            // If it's a custom post type within a custom taxonomy
            $taxonomy_exists = taxonomy_exists($custom_taxonomy);
            if(empty($last_category) && !empty($custom_taxonomy) && $taxonomy_exists) {
                   
                $taxonomy_terms = get_the_terms( $post->ID, $custom_taxonomy );
                $cat_id         = $taxonomy_terms[0]->term_id;
                $cat_nicename   = $taxonomy_terms[0]->slug;
                $cat_link       = get_term_link($taxonomy_terms[0]->term_id, $custom_taxonomy);
                $cat_name       = $taxonomy_terms[0]->name;
               
            }
              
            // Check if the post is in a category
            if(!empty($last_category)) {
                echo $cat_display;
                echo '<li class="item-current item-' . $post->ID . '"><strong class="bread-current bread-' . $post->ID . '" title="' . get_the_title() . '">' . get_the_title() . '</strong></li>';
                  
            // Else if post is in a custom taxonomy
            } else if(!empty($cat_id)) {
                  
                echo '<li class="item-cat item-cat-' . $cat_id . ' item-cat-' . $cat_nicename . '"><a class="bread-cat bread-cat-' . $cat_id . ' bread-cat-' . $cat_nicename . '" href="' . $cat_link . '" title="' . $cat_name . '">' . $cat_name . '</a></li>';
                echo '<li class="separator"> ' . $separator . ' </li>';
                echo '<li class="item-current item-' . $post->ID . '"><strong class="bread-current bread-' . $post->ID . '" title="' . get_the_title() . '">' . get_the_title() . '</strong></li>';
              
            } else {
                  
                echo '<li class="item-current item-' . $post->ID . '"><strong class="bread-current bread-' . $post->ID . '" title="' . get_the_title() . '">' . get_the_title() . '</strong></li>';
                  
            }
              
        } else if ( is_category() ) {
               
            // Category page
            echo '<li class="item-current item-cat"><strong class="bread-current bread-cat">' . single_cat_title('', false) . '</strong></li>';
               
        } else if ( is_page() ) {
               
            // Standard page
            if( $post->post_parent ){
                   
                // If child page, get parents 
                $anc = get_post_ancestors( $post->ID );
                   
                // Get parents in the right order
                $anc = array_reverse($anc);
                   
                // Parent page loop
                if ( !isset( $parents ) ) $parents = null;
                foreach ( $anc as $ancestor ) {
                    $parents .= '<li class="item-parent item-parent-' . $ancestor . '"><a class="bread-parent bread-parent-' . $ancestor . '" href="' . get_permalink($ancestor) . '" title="' . get_the_title($ancestor) . '">' . get_the_title($ancestor) . '</a></li>';
                    $parents .= '<li class="separator separator-' . $ancestor . '"> ' . $separator . ' </li>';
                }
                   
                // Display parent pages
                echo $parents;
                   
                // Current page
                echo '<li class="item-current item-' . $post->ID . '"><strong title="' . get_the_title() . '"> ' . get_the_title() . '</strong></li>';
                   
            } else {
                   
                // Just display current page if not parents
                echo '<li class="item-current item-' . $post->ID . '"><strong class="bread-current bread-' . $post->ID . '"> ' . get_the_title() . '</strong></li>';
                   
            }
               
        } else if ( is_tag() ) {
               
            // Tag page
               
            // Get tag information
            $term_id        = get_query_var('tag_id');
            $taxonomy       = 'post_tag';
            $args           = 'include=' . $term_id;
            $terms          = get_terms( $taxonomy, $args );
            $get_term_id    = $terms[0]->term_id;
            $get_term_slug  = $terms[0]->slug;
            $get_term_name  = $terms[0]->name;
               
            // Display the tag name
            echo '<li class="item-current item-tag-' . $get_term_id . ' item-tag-' . $get_term_slug . '"><strong class="bread-current bread-tag-' . $get_term_id . ' bread-tag-' . $get_term_slug . '">' . $get_term_name . '</strong></li>';
           
        } elseif ( is_day() ) {
               
            // Day archive
               
            // Year link
            echo '<li class="item-year item-year-' . get_the_time('Y') . '"><a class="bread-year bread-year-' . get_the_time('Y') . '" href="' . get_year_link( get_the_time('Y') ) . '" title="' . get_the_time('Y') . '">' . get_the_time('Y') . ' Archives</a></li>';
            echo '<li class="separator separator-' . get_the_time('Y') . '"> ' . $separator . ' </li>';
               
            // Month link
            echo '<li class="item-month item-month-' . get_the_time('m') . '"><a class="bread-month bread-month-' . get_the_time('m') . '" href="' . get_month_link( get_the_time('Y'), get_the_time('m') ) . '" title="' . get_the_time('M') . '">' . get_the_time('M') . ' Archives</a></li>';
            echo '<li class="separator separator-' . get_the_time('m') . '"> ' . $separator . ' </li>';
               
            // Day display
            echo '<li class="item-current item-' . get_the_time('j') . '"><strong class="bread-current bread-' . get_the_time('j') . '"> ' . get_the_time('jS') . ' ' . get_the_time('M') . ' Archives</strong></li>';
               
        } else if ( is_month() ) {
               
            // Month Archive
               
            // Year link
            echo '<li class="item-year item-year-' . get_the_time('Y') . '"><a class="bread-year bread-year-' . get_the_time('Y') . '" href="' . get_year_link( get_the_time('Y') ) . '" title="' . get_the_time('Y') . '">' . get_the_time('Y') . ' Archives</a></li>';
            echo '<li class="separator separator-' . get_the_time('Y') . '"> ' . $separator . ' </li>';
               
            // Month display
            echo '<li class="item-month item-month-' . get_the_time('m') . '"><strong class="bread-month bread-month-' . get_the_time('m') . '" title="' . get_the_time('M') . '">' . get_the_time('M') . ' Archives</strong></li>';
               
        } else if ( is_year() ) {
               
            // Display year archive
            echo '<li class="item-current item-current-' . get_the_time('Y') . '"><strong class="bread-current bread-current-' . get_the_time('Y') . '" title="' . get_the_time('Y') . '">' . get_the_time('Y') . ' Archives</strong></li>';
               
        } else if ( is_author() ) {
               
            // Auhor archive
               
            // Get the author information
            global $author;
            $userdata = get_userdata( $author );
               
            // Display author name
            echo '<li class="item-current item-current-' . $userdata->user_nicename . '"><strong class="bread-current bread-current-' . $userdata->user_nicename . '" title="' . $userdata->display_name . '">' . 'Author: ' . $userdata->display_name . '</strong></li>';
           
        } else if ( get_query_var('paged') ) {
               
            // Paginated archives
            echo '<li class="item-current item-current-' . get_query_var('paged') . '"><strong class="bread-current bread-current-' . get_query_var('paged') . '" title="Page ' . get_query_var('paged') . '">'.__('Page') . ' ' . get_query_var('paged') . '</strong></li>';
               
        } else if ( is_search() ) {
           
            // Search results page
            echo '<li class="item-current item-current-' . get_search_query() . '"><strong class="bread-current bread-current-' . get_search_query() . '" title="Search results for: ' . get_search_query() . '">Search results for: ' . get_search_query() . '</strong></li>';
           
        } elseif ( is_404() ) {
               
            // 404 page
            echo '<li>' . 'Error 404' . '</li>';
        }
       
        echo '</ul>';
           
    }
       
}

/***
  *** @profile header
  ***/
  add_action('profile_header', 'profile_header', 9 );
  function profile_header( $args ) {
    global $ultimatemember;

    $classes = null;

    if ( !$args['cover_enabled'] ) {
      $classes .= ' no-cover';
    }

    $default_size = str_replace( 'px', '', $args['photosize'] );

    $overlay = '<span class="um-profile-photo-overlay">
      <span class="um-profile-photo-overlay-s">
        <ins>
          <i class="um-faicon-camera"></i>
        </ins>
      </span>
    </span>';

    ?>

      <div class="um-header<?php echo $classes; ?>">

        <?php do_action('um_pre_header_editprofile', $args); ?>

        <div class="um-profile-photo" data-user_id="<?php echo um_profile_id(); ?>">

          <a href="<?php echo um_user_profile_url(); ?>" class="um-profile-photo-img" title="<?php echo um_user('display_name'); ?>"><?php echo $overlay . get_avatar( um_user('ID'), $default_size ); ?></a>

          <?php

          if ( !isset( $ultimatemember->user->cannot_edit ) ) {

            $ultimatemember->fields->add_hidden_field( 'profile_photo' );

            if ( !um_profile('profile_photo') ) { // has profile photo

              $items = array(
                '<a href="#" class="um-manual-trigger" data-parent=".um-profile-photo" data-child=".um-btn-auto-width">'.__('Upload photo','ultimate-member').'</a>',
                '<a href="#" class="um-dropdown-hide">'.__('Cancel','ultimate-member').'</a>',
              );

              $items = apply_filters('um_user_photo_menu_view', $items );

              echo $ultimatemember->menu->new_ui( 'bc', 'div.um-profile-photo', 'click', $items );

            } else if ( $ultimatemember->fields->editing == true ) {

              $items = array(
                '<a href="#" class="um-manual-trigger" data-parent=".um-profile-photo" data-child=".um-btn-auto-width">'.__('Change photo','ultimate-member').'</a>',
                '<a href="#" class="um-reset-profile-photo" data-user_id="'.um_profile_id().'" data-default_src="'.um_get_default_avatar_uri().'">'.__('Remove photo','ultimate-member').'</a>',
                '<a href="#" class="um-dropdown-hide">'.__('Cancel','ultimate-member').'</a>',
              );

              $items = apply_filters('um_user_photo_menu_edit', $items );

              echo $ultimatemember->menu->new_ui( 'bc', 'div.um-profile-photo', 'click', $items );

            }

          }

          ?>

        </div>

        <div class="um-profile-meta">

          <div class="um-main-meta">

            <?php if ( $args['show_name'] ) { ?>
            <div class="um-name">

              <a href="<?php echo um_user_profile_url(); ?>" title="<?php echo um_user('display_name'); ?>"><?php echo um_user('display_name', 'html'); ?></a>

              <?php do_action('um_after_profile_name_inline', $args ); ?>

            </div>
            <?php } ?>

            <div class="um-clear"></div>

            <?php do_action('um_after_profile_header_name_args', $args ); ?>
            <?php do_action('um_after_profile_header_name'); ?>

          </div>

          <?php if ( isset( $args['metafields'] ) && !empty( $args['metafields'] ) ) { ?>
          <div class="um-meta">

            <?php echo $ultimatemember->profile->show_meta( $args['metafields'] ); ?>

          </div>
          <?php } ?>

          <?php if ( $ultimatemember->fields->viewing == true && um_user('description') && $args['show_bio'] ) { ?>

          <div class="um-meta-text">
            <?php 
            
            $description = get_user_meta( um_user('ID') , 'description', true);
              if( um_get_option( 'profile_show_html_bio' ) ) : ?>
              <?php echo make_clickable( wpautop( wp_kses_post( $description ) ) ); ?>
            <?php else : ?>
              <?php echo esc_html( $description ); ?>
            <?php endif; ?>
          </div>

          <?php } else if ( $ultimatemember->fields->editing == true  && $args['show_bio'] ) { ?>

          <div class="um-meta-text">
            <textarea id="um-meta-bio" data-character-limit="<?php echo um_get_option('profile_bio_maxchars'); ?>" placeholder="<?php _e('Tell us a bit about yourself...','ultimate-member'); ?>" name="<?php echo 'description-' . $args['form_id']; ?>" id="<?php echo 'description-' . $args['form_id']; ?>"><?php if ( um_user('description') ) { echo um_user('description'); } ?></textarea>
            <span class="um-meta-bio-character um-right"><span class="um-bio-limit"><?php echo um_get_option('profile_bio_maxchars'); ?></span></span>
            <?php 
              if ( $ultimatemember->fields->is_error('description') ) {
                echo $ultimatemember->fields->field_error( $ultimatemember->fields->show_error('description'), true ); 
              }
            ?>

          </div>

          <?php } ?>

          <div class="um-profile-status <?php echo um_user('account_status'); ?>">
            <span><?php printf(__('This user account status is %s','ultimate-member'), um_user('account_status_name') ); ?></span>
          </div>

          <?php do_action('um_after_header_meta', um_user('ID'), $args ); ?>

        </div><div class="um-clear"></div>
   
            <?php
            if ( $ultimatemember->fields->is_error( 'profile_photo' ) ) {
                echo $ultimatemember->fields->field_error( $ultimatemember->fields->show_error('profile_photo'), 'force_show' );
            }
            ?>

        <?php do_action('um_after_header_info', um_user('ID'), $args); ?>

      </div>

    <?php
  }

  /*** Custom Avatar ***/

  add_action( 'wp_ajax_nopriv_my_action_callback', 'my_action_callback' );
  add_action( 'wp_ajax_my_action_callback', 'my_action_callback' );

function my_action_callback() {
    global $wpdb;
    $user_id = get_current_user_id();

    $completed = $_POST['value'];
    update_user_meta( $user_id, 'avatar_image_url', $completed );
    die();
}


/*** Notifications ***/

  add_action( 'wp_ajax_nopriv_save_notification', 'save_notification' );
  add_action( 'wp_ajax_save_notification', 'save_notification' );

function save_notification() {
    global $wpdb;
    $user_id = get_current_user_id();

    $seen = $_POST['seen'];

    update_user_meta( $user_id, $seen, 'seen' );
    die();
}




add_action( 'pre_user_query', 'my_random_user_query' );

function my_random_user_query( $class ) {
    if( 'rand' == $class->query_vars['orderby'] )
        $class->query_orderby = str_replace( 'user_login', 'RAND()', $class->query_orderby );

    return $class;
}