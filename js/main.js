jQuery(document).ready( function() {

    $('.prettySocial').prettySocial();

	var result = $(".entry-content").height();

	$(".hg-photo").height(result-63);


var activeclass = $('#content').attr('data-active');

if  (activeclass = 1){
var arr = [];


if( $('.week_seven').length )         
{
    $('.week_seven .week-not').removeClass('week-not').addClass('week-active');
    
}

if( $('.w_seven').length )         
{

    $('.w_seven .week-not').removeClass('week-not').addClass('week-active');


	var all = [];
$('.won-value').each(function(index, elem){
    all.push($(this).text());
});


 $('.points-all').countTo({from: 0, to: eval(all.join("+"))});


    $(".w_seven").find('.won-value').each(function(index, elem){
    arr.push($(this).text());

});
}
 else if( $('.week_seven').length ){

 	var all = [];
$('.list-value').each(function(index, elem){
    all.push($(this).text());
});



 $('.points-all').countTo({from: 0, to: eval(all.join("+"))});



   $(".week_seven").find('.list-value').each(function(index, elem){
    arr.push($(this).text());

    });
}

 $('.point-week').countTo({from: 0, to: eval(arr.join("+"))});


}


var TabBlock = {
    s: {
        animLen: 200
    },

    init: function() {
        TabBlock.bindUIActions();
        TabBlock.hideInactive();
    },

    bindUIActions: function() {
        $('.tabBlock-tabs').on('click', '.tabBlock-tab', function() {
            TabBlock.switchTab($(this));
        });
    },

    hideInactive: function() {
        var $tabBlocks = $('.tabBlock');

        $tabBlocks.each(function(i) {
            var
            $tabBlock = $($tabBlocks[i]),
                $panes = $tabBlock.find('.tabBlock-pane'),
                $activeTab = $tabBlock.find('.tabBlock-tab.is-active');

            $panes.hide();
            $($panes[$activeTab.index()]).show();
        });
    },

    switchTab: function($tab) {
        var $context = $tab.closest('.tabBlock');

        if (!$tab.hasClass('is-active')) {
            $tab.siblings().removeClass('is-active');
            $tab.addClass('is-active');

            TabBlock.showPane($tab.index(), $context);
        }
    },

    showPane: function(i, $context) {
        var $panes = $context.find('.tabBlock-pane');

        // Normally I'd frown at using jQuery over CSS animations, but we can't transition between unspecified variable heights, right? If you know a better way, I'd love a read it in the comments or on Twitter @johndjameson
        $panes.slideUp(TabBlock.s.animLen);
        $($panes[i]).slideDown(TabBlock.s.animLen);
    }
};

$(function() {
    TabBlock.init();
});


function preview(input) {
  if (input.files && input.files[0]) {
    var reader = new FileReader();
    reader.onload = function (e) { $('#img').attr('src', e.target.result); 

    $('#img').css("background-image", "url("+e.target.result+")");  



    reader.fileName = input.name;

      var imageData = e.target.result;
      var imgurData = imageData.replace(/^data:image\/(png|jpg|gif|jpeg);base64,/, '');
      var getname = $('.author-photo').attr('data-name');



      var clientId = '73ba01156def0e2';
      var access_token = '717a61824e7fb1d3aed91a9054d420b71656842b';

  $.ajax({
    url: 'https://api.imgur.com/3/image',
    headers: {
      'Authorization': 'Client-ID ' + clientId,
      'Authorization': 'Bearer ' + access_token,
      'Accept': 'application/json'
    },
    type: 'POST',
    data: {
      'image': imgurData,
      'type': 'base64',
      'album': 'aFs8E',
      'title': getname

    },
    beforeSend: function() {
        // setting a timeout
        $('.spinner').addClass('active');
        $('.success').addClass('active');

         $('.success').html('<div class="spinner"></div> UPLOADING...');

    },
        error: function() {
        // setting a timeout
        $('.spinner').removeClass('active');
         $('.success').html('UPLOAD ERROR');

    },
    success: function success(res) {
        $('.success').removeClass('active');

        var security = $('.change').attr('data-nonce');

        var geturl = res.data.link;
        geturl.replace('http://','https://');

        $.ajax({
        type:'POST',
        url: ajax_var.url,
        data: {
            action: 'my_action_callback',
            value: geturl.replace('http://','https://'),
            nonce : security,
        },
        success: function(data){
         //   console.log(data);
        },
        error : function (jqXHR, textStatus, errorThrown) {
           // console.log(jqXHR + ' :: ' + textStatus + ' :: ' + errorThrown);
        },
    });

    }
  });
     }
    reader.readAsDataURL(input.files[0]);     }   }

$("#upload").change(function(){
  $("#img").css({top: 0, left: 0});
    preview(this);
   
});


$( ".ns-close" ).on( "click", function() {

        var notify = $('.ns-box').attr('data-notify');
        
        var security = $('.ns-box').attr('data-nonce');



        $.ajax({
        type:'POST',
        url: ajax_var.url,
        data: {
            action: 'save_notification',
            seen: notify,
            nonce : security,
        },
        success: function(data){
          //  console.log(data);
            $('.ns-box').addClass('ns-hide').removeClass('ns-show');
             $('.ns-hide').remove();

        },
        error : function (jqXHR, textStatus, errorThrown) {
           // console.log(jqXHR + ' :: ' + textStatus + ' :: ' + errorThrown);
        },
    });


    });
})