<!-- <?php //if ( is_user_logged_in() ) { ?>


          <?php  $user_id //= get_current_user_id();

    $total //= get_user_meta($user_id,"_user_draft_count", true ); 
    $likedposts //= get_user_meta( $user_id,'_drafted', 'true');

    // if (in_array(get_the_id(), $likedposts)) {
    //     echo getPostLikeLink( get_the_ID() );
    // }

    // else {


       /* if ($total ==4) {
            echo '<a class="sl-button se-button"> Your Draft Is Full</a>';
        }

        else {
            echo getPostLikeLink( get_the_ID() );
        }*/

    }

     ?>


<?php } //else {

// echo '<a class="sl-button se-button" href="/login">Login To Draft</a>';
 ?>


<?php } ?>

 --> 


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
