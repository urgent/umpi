// for button style

jQuery(function ($) {
  // use jQuery code inside this to avoid "$ is not defined" error
  // $(".resido_loadmore").click(function () {
  //   var button = $(this),
  //     data = {
  //       action: "loadmore",
  //       layout: resido_loadmore_params.layout,
  //       query: resido_loadmore_params.posts, // that's how we get params from wp_localize_script() function
  //       page: resido_loadmore_params.current_page,
  //     };
  //   $.ajax({
  //     // you can also use $.post here
  //     url: resido_loadmore_params.ajaxurl, // AJAX handler
  //     data: data,
  //     type: "POST",
  //     beforeSend: function (xhr) {
  //       button.text("Loading..."); // change the button text, you can also add a preloader image
  //     },
  //     success: function (data) {
  //       if (data) {
  //         $("#archive_loop").append(data);
  //         button.text("Read More");
  //         resido_loadmore_params.current_page++;
  //         if (
  //           resido_loadmore_params.current_page ==
  //           resido_loadmore_params.max_page
  //         )
  //            alert(5)
  //       mainMap();
  //           button.remove(); // if last page, remove the button
  //       } else {
  //         button.remove(); // if no data, remove the button as well
  //       }
  //     },
  //   });
  // });
});

// jQuery(function ($) {
//   var canBeLoaded = true, // this param allows to initiate the AJAX call only if necessary
//     bottomOffset = 2000; // the distance (in px) from the page bottom when you want to load more posts
//   $(window).scroll(function () {
//     //  if ($("#ajax_scroll_loadmore").length > 0) {
//     var data = {
//       action: "loadmore",
//       query: resido_loadmore_params.posts,
//       page: resido_loadmore_params.current_page,
//     };
//     if (
//       $(document).scrollTop() > $(document).height() - bottomOffset &&
//       canBeLoaded == true
//     ) {
//       $.ajax({
//         url: resido_loadmore_params.ajaxurl,
//         data: data,
//         type: "POST",
//         beforeSend: function (xhr) {
//           //button.text("Loading...");
//           $("#loading_tag").html(
//             '<div class="spinner-grow text-danger" role="status"><span class="sr-only">Loading...</span></div><div class="spinner-grow text-warning" role="status"><span class="sr-only">Loading...</span></div><div class="spinner-grow text-success" role="status"><span class="sr-only">Loading...</span></div>'
//           );
//           canBeLoaded = false;
//         },
//         success: function (data) {
//           if (data) {
//             $("#archive_loop").append(data);
//             //$("#archive_loop").find("article:last-of-type").after(data); // where to insert posts
//             canBeLoaded = true; // the ajax is completed, now we can run it again
//             resido_loadmore_params.current_page++;
//           } else {
//             $("#loading_tag").html("");
//           }
//         },
//       });
//     }
//     // }
//   });
// });