jQuery(document).ready( function() {

	var result = $(".entry-content").height();

	$(".hg-photo").height(result-63);


var activeclass = $('#content').attr('data-active');

if  (activeclass = 1){
var arr = [];

if( $('.w_one').length )         
{

	var all = [];
$('.won-value').each(function(index, elem){
    all.push($(this).text());
});


 $('.points-all').countTo({from: 0, to: eval(all.join("+"))});


    $(".w_one").find('.won-value').each(function(index, elem){
    arr.push($(this).text());

});
}
 else if( $('.week_one').length ){

 	var all = [];
$('.list-value').each(function(index, elem){
    all.push($(this).text());
});



 $('.points-all').countTo({from: 0, to: eval(all.join("+"))});



   $(".week_one").find('.list-value').each(function(index, elem){
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


})