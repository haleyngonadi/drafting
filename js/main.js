jQuery(document).ready( function() {

var activeclass = $('#content').attr('data-active');

if  (activeclass = 1){
var arr = [];
$(".w_one span.won-count").each(function(index, elem){
    arr.push("span" +index+ "_" + $(this).text());
});
}

foreach($arr as $num) {
    $hourly[$num]++;
}

console.log($arr);

})