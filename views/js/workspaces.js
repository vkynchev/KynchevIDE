$(document).ready(function(){
  $('.home-btn').click(function(){
    window.location.replace(location.protocol + '//' + location.host + '/');
  });
  passwordCheck();
});

function passwordCheck() {
  var formId;
  var passwordVal;
  $('.delete-form').submit(function() {
   formId = $(this).attr('id');
   $('.overlay').addClass('visible');
   return false;
  });
  
  $('.check-pass').submit(function() {
   return false;
  });
  
  $('.exit-btn').click(function(){
    $('.overlay').removeClass('visible');
  });
  
  $('.password-check-btn').click(function(){
    passwordVal = $('.password-check').val();
    $.get( 
                  "/",
                  { passwordCheck: passwordVal },
                  function(data) {
                     if(data == "true"){
                       var form = '#'+formId;
                       var formData = {
	                 'workspace'              : $(''+form+' input[name=workspace]').val()
	               };
                       $.ajax({
	                 url: $(form).attr('action'),
	                 type: 'POST',
	                 data: formData,
	                 success: function(result) {
	                   location.reload();
	                   $('.overlay').removeClass('visible');
	                 }
	               });
                     } else {
                       $('.password-check').css('background-color', 'rgba(231, 76, 60, 0.1)');
                     }
                  }
               );
    });
}