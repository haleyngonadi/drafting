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


})