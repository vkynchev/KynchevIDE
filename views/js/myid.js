$(document).ready(function(){
  btnsClick();
  saveUserData();
});

function btnsClick() {
  $('.back').click(function(){
    window.history.back();
  });
  
  $('.logout').click(function(){
    window.location.href = "?logout";
  });
}

function saveUserData() {
  $('input').blur(function(){
    var value = $(this).val();
    var updateThing = $(this).prop('name');
    
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
    
    $.get( 
       "/my-id/",
       { updateProfile: 'true',
         value: value,
         updateThing: updateThing },
       function(data) {
        if(data == 'true'){
          //Success
          toastr["info"]("Your profile was updated successfully.", "Update Successful")
        } else {
          //Error
          toastr["error"]("Your profile wasn't updated. Please, try again later.", "Update Unsuccessful")
        }
      }
    );
  });
}