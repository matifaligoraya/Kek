jQuery(document).ready(function ($) {
  $(".slick-slider").slick({
    slidesToShow: 5,
    infinite: true,
    slidesToScroll: 3,
    speed: 200,
    autoplay: false,
    dots: false,
    arrows: true,
    centerMode: false,
    centerPadding: "60px",
  });
});
