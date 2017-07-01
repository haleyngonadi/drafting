jQuery(document).ready(function() {
	jQuery('body').on('click','.jm-post-like',function(event){
		event.preventDefault();
		heart = jQuery(this);
		post_id = heart.data("post_id");
		heart.html("<i class='linecon-icon-heart'></i>&nbsp;<i class='icon-cog icon-spin'></i>");
		jQuery.ajax({
			type: "post",
			url: ajax_var.url,
			data: "action=jm-post-like&nonce="+ajax_var.nonce+"&jm_post_like=&post_id="+post_id,
			success: function(count){
				if( count.indexOf( "already" ) !== -1 )
				{
					var lecount = count.replace("already","");
					if (lecount == 0)
					{
						var lecount = "Like";
						$('.draft-count').html('0');
					}

					else {$('.draft-count').html(lecount);}


					heart.prop('title', 'Draft');
					heart.removeClass("liked");
					heart.html("Draft");
					$('.jm-load').hide();


							
				}
				else
				{
					heart.prop('title', 'Un-Draft');
					heart.addClass("liked");
					heart.html("DRAFTED");
					$('.draft-count').html(count);
					$('.jm-load').hide();

					$('.jm-post-like').unbind('click', false);
				}
			}
		});
	});
});
