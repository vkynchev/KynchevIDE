$(document).ready(function(){
  $('.home-btn').click(function(){
    window.location.replace(location.protocol + '//' + location.host + '/');
  });
  generateInvite();
  changeStars();
});

function generateInvite() {

  $('.invite-link').click(function(){
    $('.overlay').addClass('visible');
  });
  
  $('.generate-form').submit(function() {
   return false;
  });

  $('.exit-btn').click(function(){
    $('.overlay').removeClass('visible');
    $('.generate-field').val('');
  });
  
  $('.generate-field-btn').click(function(){
    $.get( 
                  "/register/",
                  { generateLink: 'true' },
                  function(data) {
                     $('.generate-field').val(data);
                  }
               );
    });
}

function changeStars() {
  $('.star-position.notcurrent').click(function(){
    var user = $(this).prop('id');
    $.get( 
                  "/people/",
                  { changePosition: user },
                  function(data) {
                     if(data != '') {
                     
                     toastr.options = {
		       "closeButton": true,
		       "debug": false,
		       "newestOnTop": true,
		       "progressBar": false,
		       "positionClass": "toast-bottom-left",
		       "preventDuplicates": false,
		       "onclick": null,
		       "showDuration": "300",
		       "hideDuration": "1000",
		       "timeOut": "2000",
		       "extendedTimeOut": "1000",
		       "showEasing": "swing",
		       "hideEasing": "linear",
		       "showMethod": "fadeIn",
		       "hideMethod": "fadeOut"
		     }
		     
                       if (data == 'developer') {
                         $('#'+user).empty();
                         $('#'+user).append('<i class="fa fa-star"></i>');
                         toastr["info"]("User position was updated successfully.", "Update Successful")
                       } else if (data == 'jr_developer') {
                         $('#'+user).empty();
                         $('#'+user).append('<i class="fa fa-star-half-o"></i>');
                         toastr["info"]("User position was updated successfully.", "Update Successful")
                       } else if (data == 'read_only') {
                         $('#'+user).empty();
                         $('#'+user).append('<i class="fa fa-star-o"></i>');
                         toastr["info"]("User position was updated successfully.", "Update Successful")
                       }
                     }
                  }
    );
  });
}