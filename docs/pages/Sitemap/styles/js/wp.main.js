$(document).ready(function() {

function annouce() {
  $('#announcement i.fa.fa-times').on('click', function() {
    $('.announcement').animate({'height': '0', 'padding' : '0'});
    $(this).css({
      'transform' : 'rotate(45deg)',
      '-webkit-transform' : 'rotate(45deg)',
      '-ms-transform' : 'rotate(45deg)'
    })
  });
}
annouce();


});
