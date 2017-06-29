<div class="um <?php echo $this->get_class( $mode ); ?> um-<?php echo $form_id; ?> um-role-<?php echo um_user('role'); ?> ">

	<div class="um-form">
	
		<?php do_action('um_profile_before_header', $args ); ?>
		
		<?php if ( um_is_on_edit_profile() ) { ?><form method="post" action=""><?php } ?>
		
			<?php do_action('um_profile_header_cover_area', $args ); ?>
			
			<?php do_action('um_profile_header', $args ); ?>
			
			<?php do_action('um_profile_navbar', $args ); ?>
			
			<?php
				
			$nav = $ultimatemember->profile->active_tab;
			$subnav = ( get_query_var('subnav') ) ? get_query_var('subnav') : 'default';
				
			print "<div class='um-profile-body $nav $nav-$subnav'>";
				
				// Custom hook to display tabbed content
				do_action("um_profile_content_{$nav}", $args);
				do_action("um_profile_content_{$nav}_{$subnav}", $args);
				
			print "</div>";
				
			?>
		
		<?php if ( um_is_on_edit_profile() ) { ?></form><?php } ?>


		<?php
// Set the Current Author Variable $curauth
$curauth = um_profile_id();

?>

	<div class="row author-row">
					<div class="col-sm-3">

	<div class="author-photo"><?php echo get_avatar($curauth->user_email, '300', $avatar); ?></div>



	</div>

	<div class="col-sm-9">

	<header class="entry-header"><h1 class="entry-title"> <?php echo um_name(); ?></h1></header>




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

	
	</div>
	
</div>