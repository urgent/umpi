//alert("dffd");
var $ = jQuery();
(function ($) {
  var ajaxurl = ajax_obj.ajax_url;
  $(".button.set-lfeatured").on("click", function (e) {
    e.preventDefault();
    var postid = $(this).data("id");
    //alert(postid);
    $.post(ajaxurl, {
      action: "resido_save_listing_featured",
      post_id: postid,
    }).done(function (s) {
      if (s == "added") {
        $("#f_added_" + postid).html("Featured");
        //$(".as-lfeatured"+ postid).html("Featured");
      } else {
        //$("#f_added_" + postid).html("Set as featured");
        $("#f_added_" + postid).html("Set as featured");
      }
    });
  });

  $(".button.set-lverified").on("click", function (e) {
    e.preventDefault();
    var postid = $(this).data("id");
    //alert(postid);
    $.post(ajaxurl, {
      action: "resido_add_listing_varified",
      post_id: postid,
    }).done(function (s) {
      if (s == "added") {
        $("#v_added_" + postid).html("Verified");
      } else {
        $("#v_added_" + postid).html("Verify");
      }
    });
  });

  // Input field edit on change api map
  
  $("input#rlisting_map_coordinates").on("change", function (event) {
    event.preventDefault();
    setTimeout( function(){ 
      var rlisting_map_value = $("input#rlisting_map_coordinates").val();
      var rlisting_map_latitude = rlisting_map_value.split(',')[0];
      var rlisting_map_longitude = rlisting_map_value.split(',')[1];
      $('.rwmb-input #rlisting_latitude').val(rlisting_map_latitude);
      $('.rwmb-input #rlisting_longitude').val(rlisting_map_longitude);
    }  , 1000 );
    
  });

  $(".rwmb-input #rlisting_latitude" ).on("change", function (event) {
    event.preventDefault();
    setTimeout(function () {
      var rlisting_map_latitude = $(".rwmb-input #rlisting_latitude").val();
      var rlisting_map_longitude = $('.rwmb-input #rlisting_longitude').val();
      $("input#rlisting_map_coordinates").val(rlisting_map_latitude +','+rlisting_map_longitude+',15');
    }  , 1000 );
  });

  $(".rwmb-input #rlisting_longitude" ).on("change", function (event) {
    event.preventDefault();
    setTimeout(function () {
      var rlisting_map_latitude = $(".rwmb-input #rlisting_latitude").val();
      var rlisting_map_longitude = $('.rwmb-input #rlisting_longitude').val();
      $("input#rlisting_map_coordinates").val(rlisting_map_latitude +','+rlisting_map_longitude+',15');
    }  , 1000 );
  });

})(jQuery);
