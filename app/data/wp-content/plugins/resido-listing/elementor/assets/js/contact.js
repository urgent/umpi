

(function ($) {

    $(document).ready(function () {
        $("form[name='registration']").validate({
            submitHandler: function(form) {
             
              var formdata =$("form[name='registration']").serializeArray();
      
              var nonce = $("#venus_nonce").val();
            $.post(venus.ajax_url, { action: 'venus_contact', nonce: nonce, 'formdata': formdata }, function (data) {
              $(".ele-form-messages").html('<div class="alert alert-success alert-dismissible fade show" role="alert">Message Sent Successfully!<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button></div>');
            });
            return false;
            }
        });    
    });
})(jQuery);






