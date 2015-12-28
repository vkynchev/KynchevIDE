$(document).ready(function(){
  menuToggle();
});



function menuToggle() {  
  $('html').click(function() {
    $('.right-menu').removeClass('visible');
    $('.right-menu-toggle').removeClass('visible');
  });

  $('.menus').click(function(event){
    event.stopPropagation();
  });
  
  $('.right-menu-toggle').click(function(event){
    event.stopPropagation();
  });

  $('.right-menu-toggle').click(function(event){
    $('.right-menu').toggleClass('visible');
    $('.right-menu-toggle').toggleClass('visible');
  });
}