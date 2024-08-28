jQuery(document).ready(function ($) {
  // Tab switching functionality
  // $(".nav-tab").on("click", function (e) {
  //   e.preventDefault();

  //   $(".nav-tab").removeClass("nav-tab-active");
  //   $(this).addClass("nav-tab-active");

  //   var tab = $(this).attr("href");
  //   $(".tab-content").hide();
  //   $(tab).show();
  // });

  $(".kek-color-field").wpColorPicker({
    change: function (event, ui) {
      var color = ui.color.toString();
      var rgb = ui.color.toRgb();

      // Update RGB field hidden input if needed
      $('input[name="kek_options[kek_setting_color_rgb]"]').val(rgb);
    },
  });
});
