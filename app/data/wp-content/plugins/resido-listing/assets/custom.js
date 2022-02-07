(function ($) {
  ("use strict");
  var ajaxurl = ajax_obj.ajax_url;
  $("#listing-equiry-form form").on("submit", function (e) {
    e.preventDefault();
    var data = $(this).serialize();
    $.post(ajaxurl, data, function (response) {
      if (response.success) {
        $("#message").html(
          '<div class="alert alert-success" role="alert">' +
            response.data.message +
            "</div>"
        );
      } else {
        $("#message").html(
          '<div class="alert alert-warning" role="alert">' +
            response.data.message +
            "</div>"
        );
      }
    }).fail(function () {
      $("#message").html(
        '<div class="alert alert-warning" role="alert">' +
          response.data.message +
          "</div>"
      );
    });
  });

  $("#resido-registration-form").submit(function (e) {
    e.preventDefault();
    var data = $(this).serialize();
    var redirect_to = $('[name="redirect_to"]').val();
    $.post(ajax_obj.ajax_url, data, function (response) {
      if (response.success) {
        var success_smg = response.data.message;
        //Successfully registered. Check your email address for the password.
        $("#res_message").html(
          '<div class="alert alert-success" role="alert">' +
            success_smg +
            "</div>"
        );
        setTimeout(function () {
          window.location = redirect_to;
        }, 2000);
      } else {
        var err_msgd = response.data.error;
        var myObject = JSON.parse(err_msgd);
        $("#res_message").html(
          '<div class="alert alert-warning" role="alert">' +
            myObject.error_msg +
            "</div>"
        );
      }
    }).fail(function (e) {
      var err_msgd = response.data.error;
      var myObject = JSON.parse(err_msgd);
      $("#res_message").html(
        '<div class="alert alert-warning" role="alert">' +
          myObject.error_msg +
          "</div>"
      );
    });
  });

  $("#myForm").submit(function (e) {
    e.preventDefault();
    var data = $(this).serialize();
    var redirect_to = $('[name="redirect_to"]').val();
    $.post(ajax_obj.ajax_url, data, function (response) {
      if (response.success) {
        $("#log_message").html(
          '<div class="alert alert-success" role="alert">' +
            response.data.message +
            "</div>"
        );
        setTimeout(function () {
          window.location = redirect_to;
        }, 2000);
      } else {
        $("#log_message").html(
          '<div class="alert alert-warning" role="alert">' +
            response.data.message +
            "</div>"
        );
      }
    }).fail(function (e) {
      $("#log_message").html(
        '<div class="alert alert-warning" role="alert">' +
          response.data.message +
          "</div>"
      );
    });
  });

  $("#resistration_to_login").on("click", function (e) {
    $("#signup").modal("hide");
  });

  $("#forgot_pass").on("click", function (e) {
    $("#login").modal("hide");
    $("#reset").modal("show");
  });

  $("#login_to_resistration").on("click", function (e) {
    $("#login").modal("hide");
    $("#signup").modal("show");
  });

  // Perform AJAX forget password on form submit
  $("form#forgot_password").on("submit", function (e) {
    e.preventDefault();
    $("p.status", this).show().text("Sending...");
    var ctrl = $(this);
    $.ajax({
      type: "POST",
      dataType: "json",
      url: ajax_obj.ajax_url,
      data: {
        action: "ajaxforgotpassword",
        user_login: $("#user_login").val(),
        security: $("#forgotsecurity").val(),
      },
      success: function (data) {
        $("p.status").text(data.message);
      },
    });
    //e.preventDefault();
    return false;
  });

  $(".add-to-favorite").on("click", function (e) {
    e.preventDefault();
    //var postid = $(this).data('postid').val();
    var postid = $(this).data("postid");
    var userid = $(this).data("userid");
    //alert(postid);
    $.post(ajaxurl, {
      action: "resido_save_listing_bookmark",
      post_id: postid,
      user_id: userid,
    }).done(function (s) {
      if (s == "added") {
        $(".add-to-favorite").addClass("like-bitt");
      } else {
        $(".add-to-favorite").removeClass("like-bitt");
      }
    });
  });

  $(".banner_fav").on("click", function (e) {
    e.preventDefault();
    //var postid = $(this).data('postid').val();
    var postid = $(this).data("postid");
    var userid = $(this).data("userid");
    //alert(postid);
    $.post(ajaxurl, {
      action: "resido_save_listing_bookmark",
      post_id: postid,
      user_id: userid,
    }).done(function (s) {
      if (s == "added") {
        $( "#like_listing" + postid ).html("<i class='save_class_sdbr fas fa-heart'></i>");
      } else {
        $( "#like_listing" + postid ).html("<i class='save_class_sdbr far fa-heart'></i>");
      }
    });
  });

  $(".live_single_2").on("click", function (e) {
    e.preventDefault();
    //var postid = $(this).data('postid').val();
    var postid = $(this).data("postid");
    var userid = $(this).data("userid");
    //alert(postid);
    $.post(ajaxurl, {
      action: "resido_save_listing_bookmark",
      post_id: postid,
      user_id: userid,
    }).done(function (s) {
      if (s == "added") {
        $( "#like_listing" + postid ).html("<i class='save_class_sdbr fas fa-heart'></i>Saved");
      } else {
        $( "#like_listing" + postid ).html("<i class='save_class_sdbr far fa-heart'></i>Save");
      }
    });
  });

  $(".like-listing").on("click", function (e) {
    e.preventDefault();
    //var postid = $(this).data('postid').val();
    var postid = $(this).data("postid");
    var userid = $(this).data("userid");
    //alert(postid);
    $.post(ajaxurl, {
      action: "resido_save_listing_bookmark",
      post_id: postid,
      user_id: userid,
    }).done(function (s) {
      if (s == "added") {
        $("#like_listing" + postid).addClass("active");
      } else {
        $("#like_listing" + postid).removeClass("active");
      }
    });
  });

  $(".tag_t").on("click", function (e) {
    e.preventDefault();
    //var postid = $(this).data('postid').val();
    var postid = $(this).data("postid");
    var userid = $(this).data("userid");
    //alert(postid);
    $.post(ajaxurl, {
      action: "resido_save_listing_bookmark",
      post_id: postid,
      user_id: userid,
    }).done(function (s) {
      if (s == "added") {
        $("#tag_t" + postid).addClass("active");
      } else {
        $("#tag_t" + postid).removeClass("active");
      }
    });
  });

  $(".book_marked").on("click", function (e) {
    e.preventDefault();
    //var postid = $(this).data('postid').val();
    var postid = $(this).data("postid");
    var userid = $(this).data("userid");
    //alert(postid);
    $.post(ajaxurl, {
      action: "resido_save_listing_bookmark",
      post_id: postid,
      user_id: userid,
    }).done(function (s) {
      if (s == "added") {
        $("#tag_t" + postid).addClass("active");
      } else {
        $("#bookmarked_" + postid).remove();
      }
    });
  });

  var slider = document.getElementById("search_distance");
  if (slider !== null) {
    var output = document.getElementById("distance");
    output.innerHTML = slider.value; // Display the default slider value
    // Update the current slider value (each time you drag the slider handle)
    slider.oninput = function () {
      output.innerHTML = this.value;
    };
  }

  $(".add-to-cart-custom").on("click", function () {
    var id = $(this).data("product_id");
    var quantity = 1;
    var price = $(this).attr("data-price");
    var service = $(this).attr("data-service-title");
    $.ajax({
      type: "POST",
      url: ajax_obj.ajax_url,
      data: {
        action: "product_add_to_cart",
        product_id: id,
        price: price,
        quantity: quantity,
        service: service,
      },
      success: function (res) {
        if (res == "success") {
          window.location = ajax_obj.site_url + "/cart";
        } else {
          alert("Something wrong goes here");
        }
      },
    });
  });

  $(".delete-message").on("click", function () {
    var id = $(this).data("message-id");
    $.ajax({
      type: "POST",
      url: ajax_obj.ajax_url,
      data: {
        action: "resido-delete-message",
        message_id: id,
      },
      success: function (res) {
        if (res) {
          window.location = window.location.href;
        } else {
          alert("Something wrong goes here");
        }
      },
    });
  });

  $("a#delete-listing").on("click", function (e) {
    var id = $(this).data("listing-id");
    $.ajax({
      type: "POST",
      url: ajax_obj.ajax_url,
      data: {
        action: "resido-delete-listing",
        listing_id: id,                                                                       
      },
      success: function (res) {
        //window.location = window.location.href;
        if (res) {
          window.location = window.location.href;
        } else {
          alert("Something wrong goes here");
        }
      },
    });
  });

  $("a#make-featured").on("click", function (e) {
    var id = $(this).data("listing-id");
    $.ajax({
      type: "POST",
      url: ajax_obj.ajax_url,
      data: {
        action: "resido-make-featured",
        listing_id: id,                                                                       
      },
      success: function (res) {
        //window.location = window.location.href;
        if (res) {
          alert(res);
          window.location = window.location.href;
        } else {
          alert("Something wrong goes here");
        }
      },
    });
  });

  $("#country").on("change", function (e) {
    var country = $("#country").val();
    $.ajax({
      type: "POST",
      url: ajax_obj.ajax_url,
      data: {
        action: "resido_state_by_country",
        country: country,
      },
      beforeSend: function (xhr) {
        $("#lcity").addClass("loading-area");
      },
      success: function (res) {
        var resObj = JSON.parse(res);
        $("#lcity").html(resObj);
        $("#lcity").removeClass("loading-area");
      },
    });
  });

  $("#commentform input").on("change", function () {
    var rservice = $("input[name=rservice]:checked", "#commentform").val();
    var rmoney = $("input[name=rmoney]:checked", "#commentform").val();
    var rcleanliness = $(
      "input[name=rcleanliness]:checked",
      "#commentform"
    ).val();
    var rlocation = $("input[name=rlocation]:checked", "#commentform").val();

    if (rservice && rmoney && rcleanliness && rlocation) {
      var tatal =
        parseInt(rservice) +
        parseInt(rmoney) +
        parseInt(rcleanliness) +
        parseInt(rlocation);
      var avg = tatal / 4;
    } else if (rservice && rmoney && rcleanliness) {
      var tatal =
        parseInt(rservice) + parseInt(rmoney) + parseInt(rcleanliness);
      var avg = tatal / 3;
      var avg = avg.toFixed(2);
    } else if (rservice && rmoney) {
      var tatal = parseInt(rservice) + parseInt(rmoney);
      var avg = tatal / 2;
    } else {
      var tatal = parseInt(rservice);
      var avg = tatal;
    }
    $(".user_commnet_avg_rate").text(avg);
  });

  $(".remove-uploaded-img").click(function () {
    var gimage = $(this).data("gimage");
    var postid = $(this).data("postid");
    $.post(ajaxurl, {
      action: "resido_delete_gallery_image",
      gimage: gimage,
      postid: postid,
    }).done(function (s) {
      if (s == "added") {
        $("#deletegimage" + gimage).remove();
        $("#delete_icon" + gimage).remove();
      }
    });
  });
})(jQuery);

jQuery(document).ready(function ($) {
  var myplugin_media_upload;
  $("#myplugin-change-image").click(function (e) {
    e.preventDefault();
    // If the uploader object has already been created, reopen the dialog
    if (myplugin_media_upload) {
      myplugin_media_upload.open();
      return;
    }

    myplugin_media_upload = wp.media.frames.file_frame = wp.media({
      title: $(this).data("uploader_title"),
      button: {
        text: $(this).data("uploader_button_text"),
      },
      multiple: true, // set this to true for multiple file selection
    });

    /**
     *THE KEY BUSINESS
     *When multiple images are selected, get the multiple attachment objects
     *and convert them into a usable array of attachments
     */
    myplugin_media_upload.on("select", function () {
      var attachments = myplugin_media_upload
        .state()
        .get("selection")
        .map(function (attachment) {
          attachment.toJSON();
          return attachment;
        });
      //loop through the array and do things with each attachment
      var i;
      for (i = 0; i < attachments.length; ++i) {
        //sample function 1: add image preview
        $("#myplugin-placeholder").after(
          '<div class="myplugin-image-preview"><img width="200px" src="' +
            attachments[i].attributes.url +
            '" ></div>'
        );
        //sample function 2: add hidden input for each image
        $("#myplugin-placeholder").after(
          '<input id="myplugin-image-input' +
            attachments[i].id +
            '" type="hidden" name="resido_attachment_id_array[]"  value="' +
            attachments[i].id +
            '">'
        );
      }
    });
    myplugin_media_upload.open();
  });
});


jQuery(document).ready(function ($) {
  var myplugin_media_upload;
  $("#frontend_rlvideoimg").click(function (e) {
    e.preventDefault();
    // If the uploader object has already been created, reopen the dialog
    if (myplugin_media_upload) {
      myplugin_media_upload.open();
      return;
    }

    myplugin_media_upload = wp.media.frames.file_frame = wp.media({
      title: $(this).data("uploader_title"),
      button: {
        text: $(this).data("uploader_button_text"),
      },
      multiple: false, // set this to true for multiple file selection
    });

    /**
     *THE KEY BUSINESS
     *When multiple images are selected, get the multiple attachment objects
     *and convert them into a usable array of attachments
     */
    myplugin_media_upload.on("select", function () {
      var attachments = myplugin_media_upload
        .state()
        .get("selection")
        .map(function (attachment) {
          attachment.toJSON();
          return attachment;
        });
      //loop through the array and do things with each attachment
      var i;
      for (i = 0; i < attachments.length; ++i) {
        //sample function 1: add image preview
        $("#rlvideoimg-placeholder").after(
          '<div class="myplugin-image-preview"><img width="200px" src="' +
            attachments[i].attributes.url +
            '" ></div>'
        );
        //sample function 2: add hidden input for each image
        $("#rlvideoimg-placeholder").after(
          '<input id="myplugin-image-input' +
            attachments[i].id +
            '" type="hidden" name="frontend_rlvideoimg_array"  value="' +
            attachments[i].id +
            '">'
        );
      }
    });
    myplugin_media_upload.open();
  });
});


(function ($) {
  $(document).ready(function () {
    var floor_img; // variable for the wp.media file_frame


    // attach a click event (or whatever you want) to some element on your page
    $(".rlfloor-btn").on("click", function (event) {
      event.preventDefault();
      var dat_id = $(this).data('id');
      console.log(dat_id);

      floor_img = wp.media.frames.floor_img = wp.media({
        title: $(this).data("uploader_title"),
        button: {
          text: $(this).data("uploader_button_text"),
        },
        multiple: false, // set this to true for multiple file selection
      });

      floor_img.on("select", function () {
        attachment = floor_img.state().get("selection").first().toJSON();
        $("#rlfloor-image").attr("src", attachment.url);
        $('#' + dat_id).val(attachment.id);
        console.log(dat_id);
      });

      floor_img.open();
    });
  });
})(jQuery);



(function ($) {
  $(document).ready(function () {
    var file_frame; // variable for the wp.media file_frame

    // attach a click event (or whatever you want) to some element on your page
    $("#frontend-button").on("click", function (event) {
      event.preventDefault();

      // if the file_frame has already been created, just reuse it
      if (file_frame) {
        file_frame.open();
        return;
      }

      file_frame = wp.media.frames.file_frame = wp.media({
        title: $(this).data("uploader_title"),
        button: {
          text: $(this).data("uploader_button_text"),
        },
        multiple: false, // set this to true for multiple file selection
      });

      file_frame.on("select", function () {
        attachment = file_frame.state().get("selection").first().toJSON();
        // do something with the file here
        //$("#frontend-button").hide();
        $("#frontend-image").attr("src", attachment.url);
        $("#frontend_rlfeaturedimg").val(attachment.id);
      });

      file_frame.open();
    });
  });

  // $("#archive_loop").append(
  //   '<div class="text-center listing-loader"><div class="spinner-grow text-danger" role="status"><span class="sr-only">Loading...</span></div><div class="spinner-grow text-warning" role="status"><span class="sr-only">Loading...</span></div><div class="spinner-grow text-success" role="status"><span class="sr-only">Loading...</span></div></div>'
  // );
})(jQuery);

(function ($) {
  $(document).ready(function () {
    var file_frame; // variable for the wp.media file_frame

    // attach a click event (or whatever you want) to some element on your page
    $("#frontend-avatar").on("click", function (event) {
      event.preventDefault();
      // if the file_frame has already been created, just reuse it
      if (file_frame) {
        file_frame.open();
        return;
      }

      file_frame = wp.media.frames.file_frame = wp.media({
        title: $(this).data("uploader_title"),
        button: {
          text: $(this).data("uploader_button_text"),
        },
        multiple: false, // set this to true for multiple file selection
      });

      file_frame.on("select", function () {
        attachment = file_frame.state().get("selection").first().toJSON();
        $("#files_featured").attr("src", attachment.url);
        $("#user_avt").val(attachment.id);
      });

      file_frame.open();
    });
  });
})(jQuery);

// Calculation Widget Portion
(function ($) {

  $('#dash_nav_eng').on('click', function() {
    document.getElementById("filter_search").style.display = "block";
  });
  
  $('#dash_nav_dis').on('click', function() {
    document.getElementById("filter_search").style.display = "none";
  });

    $(".login-attri").on("click", function(e) {
    $(".login-attri .dropdown-menu").addClass("show");
      e.stopPropagation()
    });
    $(document).on("click", function(e) {
      if ($(e.target).is(".login-attri .dropdown-menu") === false) {
        $(".login-attri .dropdown-menu").removeClass("show");
      }
    });

})(jQuery);



(function ($) {

$('#calc_price').on('change', function() {
  if( !$("#calc_price").val() ) {
    $( ".btn_calculator" ).fadeOut( 500 );
  } else{
    $( ".btn_calculator" ).fadeIn( 500 );
  }
});



if ($('.calculator_area').length) {
      $('.btn_calculator').on('click', function(e) {
          e.preventDefault();
          var fields = $(this).closest('#calculate_form')
          var data = [];
          var flag = 1;
          fields = fields.serializeArray();
          $.each(fields, function(i, field) {
              if (field.value == '') {
                  $('input[name="' + field.name + '"]').focus();
                  flag = 0;
                  return false;
              }
              data[field.name] = field.value;
          });
          if (flag == 1) {
              $(".monthly_result").empty();
              $(".tot__down_result").empty();
              $(".tot_result").empty();
              $(".interest_result").empty();
              console.log(fields);

              var property_price = parseFloat(data["calc_price"]);
              var down_payment = parseFloat(data["down_payment"]);
              var interest_rate = parseFloat(data["interest_rate"]);
              if (isNaN(interest_rate) || interest_rate == "") {
                  interest_rate = 0;
              }

              console.log(interest_rate);
              interest_rate = interest_rate / 1200;
              var period = parseFloat(data["period"]);
              var currency = $( "#compare_get_currency" ).val();
              var monthly = 0;
              var interest = 0;
              var total = 0;
              var total_d = 0;

              if (interest_rate == 0) {
                  monthly = (property_price - down_payment) / period;
                  total = down_payment + (monthly * period);
                  total = down_payment + (monthly * period);
                  total = total.toFixed(2);
                  total_d = (monthly * period);
                  total_d = total_d.toFixed(2);
              } else {
                  monthly = (property_price - down_payment) * interest_rate * Math.pow(1 + interest_rate, period);
                  monthly = monthly / ((Math.pow(1 + interest_rate, period)) - 1);
                  monthly = monthly.toFixed(2);
                  total = down_payment + (monthly * period);
                  total = total.toFixed(2);
                  total_d = (monthly * period);
                  total_d = total_d.toFixed(2);
                  interest = total - property_price;
                  interest = interest.toFixed(2);
              }

              $(".monthly_result").append(currency + monthly);
              $(".tot__down_result").append(currency + total_d);
              $(".tot_result").append(currency + total);
              $(".interest_result").append(currency + interest);
              $('.calculator_box,.calculator_area').addClass('open');

              return false;
          }
      });
      $('.calculator_area').on('click', function() {
          $('.calculator_box,.calculator_area').removeClass('open')
      })
  }
})(jQuery);
// Calculation Widget Portion



(function ($) {
  $( document ).ready(function() {
  $(".resido_loadmore").click(function () {
    var button = $(this),
      loc = typeof locations_obj !== "undefined" ? locations_obj : "",
      data = {
        action: "loadmore",
        layout: resido_loadmore_params.layout,
        query: resido_loadmore_params.posts, // that's how we get params from wp_localize_script() function
        page: resido_loadmore_params.current_page,
        locations_obj: loc,
        length: loc.length,
      };
    $.ajax({
      // you can also use $.post here
      url: resido_loadmore_params.ajaxurl, // AJAX handler
      data: data,
      type: "POST",
      beforeSend: function (xhr) {
        $("#archive_loop").addClass("loading-area");
      },
      success: function (data) {
        var obj = JSON.parse(data);
        if (obj.data) {
          $("#archive_loop").append(obj.data);
          $("#archive_loop").removeClass("loading-area");
          button.text("Load More");
          $(".left-column.pull-left h4").remove();
          resido_loadmore_params.current_page++;
          if (
            resido_loadmore_params.current_page ==
            resido_loadmore_params.max_page
          ) {
            button.remove(); // if last page, remove the button
          }
          if (loc !== "" && typeof obj.loc != "undefined") {
            dloc = obj.loc;
            setTimeout(function () {
              objmapsjava(dloc);
            }, 100);
          }
        } else {
          button.remove(); // if no data, remove the button as well
        }
      },
      error: function () {},
    });
  });
  });
})(jQuery);

(function ($) {
  $(document).ready(function () {
    var file_frame; // variable for the wp.media file_frame
    // attach a click event (or whatever you want) to some element on your page
    $(".frontend-menu-image").on("click", function (event) {
      event.preventDefault();
      // if the file_frame has already been created, just reuse it
      if (file_frame) {
        file_frame.open();
        return;
      }

      file_frame = wp.media.frames.file_frame = wp.media({
        title: $(this).data("uploader_title"),
        button: {
          text: $(this).data("uploader_button_text"),
        },
        multiple: false, // set this to true for multiple file selection
      });

      file_frame.on("select", function () {
        attachment = file_frame.state().get("selection").first().toJSON();
        $(".files_featured").attr("src", attachment.url);
        $(".listing-product-image").val(attachment.id);
      });

      file_frame.open();
    });
  });
})(jQuery);

(function ($) {
  $(document).ready(function(){

    $('.shorting-list .grid-view').click(function(){
        setCookie('shorting_layout',"grid",1);
        $(".shorting-list .grid-view").addClass("active");
        $(".shorting-list .list-view").removeClass("active");
        $("#layout").val("grid");
    });
    $('.shorting-list .list-view').click(function(){
        setCookie('shorting_layout',"list",1);
        $(".shorting-list .grid-view").removeClass("active");
        $(".shorting-list .list-view").addClass("active");
        $("#layout").val("list");
    });
    $('.shorting-by #sort_by_order').change(function(){
        setCookie('sort_by_order',$("#sort_by_order").val(),1);
    });

});

function setCookie(name,value,days) {
    var expires = "";
    if (days) {
        var date = new Date();
        date.setTime(date.getTime() + (days*24*60*60*1000));
        expires = "; expires=" + date.toUTCString();
    }
    document.cookie = name + "=" + (value || "")  + expires + "; path=/";
}
})(jQuery);

(function ($) {
  $(document).ready(function () {
    $('#list_loc').select2({
      placeholder: "All Cities",
      allowClear: true
    });
  });
})(jQuery);