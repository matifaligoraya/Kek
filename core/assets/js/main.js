function numberMask(num) {
  if (typeof num === "undefined") {
    return "-";
  }
  if (typeof num !== "number") {
    return num;
  }
  let parts = num.toString().split(".");
  parts[0] = parts[0].replace(/\B(?=(\d{3})+(?!\d))/g, ",");
  return parts.join(".");
}
function isEmpty(obj) {
  for (let key in obj) {
    return !1;
  }
  return !0;
}
function addLanguagePrefix(url) {
  if (url.startsWith("/")) {
    url = url.substring(1);
  }
  if (!isEmpty(window.current_language) && window.current_language !== "en") {
    return "/" + window.current_language + "/" + url;
  } else {
    return "/" + url;
  }
}
function addUrlParameterToHistory(channelUrl) {
  const state = "";
  const title = "";
  const url = `?url=${encodeURIComponent(channelUrl)}`;
  history.pushState(state, title, url);
}
function sleep(time) {
  return new Promise((resolve) => {
    setTimeout(() => {
      resolve();
    }, time);
  });
}
async function loadScript(src, wait = !1) {
  var head = document.getElementsByTagName("head")[0];
  var script = document.createElement("script");
  script.type = "text/javascript";
  script.src = src;
  head.appendChild(script);
  if (wait) {
    await sleep(wait);
  }
}
async function loadStyle(src, wait = !1) {
  var head = document.getElementsByTagName("head")[0];
  var script = document.createElement("link");
  script.type = "text/css";
  script.rel = "stylesheet";
  script.href = src;
  head.prepend(script);
  if (wait) {
    await sleep(wait);
  }
}
async function loadCaptcha() {
  await loadScript(
    `https://www.google.com/recaptcha/api.js?render=${Views4YouConfig.recaptcha_key}`
  );
  do {
    await sleep(100);
  } while (typeof grecaptcha === "undefined");
}
jQuery(document).ready(async function ($) {
  $(".menu-btn").on("click", function (e) {
    $(this).toggleClass("active");
    $(".header").toggleClass("menu-open");
    $("body").toggleClass("overflow");
    e.preventDefault();
  });
  $(".menu-inner > li").hover(
    function () {
      $(this)
        .closest(".menu-outer")
        .find("span")
        .addClass("active")
        .css({
          left: $(this).offset().left - $(".menu-inner").offset().left,
          width: $(this).outerWidth(),
        });
    },
    function () {
      $(this)
        .closest(".menu-outer")
        .find("span")
        .removeClass("active")
        .css({ left: 0, width: "100%" });
    }
  );
  if ($(".wcl-custom-form-select").length > 0) {
    $(".wcl-custom-form-select").selectpicker();
  }
  if ($(".owl-carousel").length > 0) {
    do {
      await sleep(10);
    } while (typeof jQuery.fn.owlCarousel === "undefined");
    $(".section-reviews .owl-carousel").owlCarousel({
      loop: !1,
      margin: 0,
      nav: !1,
      dots: !0,
      dotsContainer: "#carousel-custom-dots",
      responsive: { 0: { items: 1 }, 768: { items: 2 }, 1200: { items: 3 } },
      onInitialized: function () {
        $(".section-reviews .owl-carousel .item").removeClass("d-none");
      },
    });
    const product_banner_carousel = $(
      ".section-banner .banner-box .owl-carousel"
    );
    product_banner_carousel.each(function (index) {
      const num_slides = $(this).find(".item").length;
      if (num_slides > 1) {
        $(this).owlCarousel({
          loop: !1,
          margin: 0,
          nav: !0,
          dots: !1,
          responsive: {
            0: { items: 1 },
            992: { items: 1 },
            1000: { items: 1 },
          },
          onInitialized: function () {
            $(this).removeClass("loading");
            $(".section-banner .banner-box .owl-carousel .item").removeClass(
              "d-none"
            );
          },
        });
      }
    });
    $(".section-login .owl-carousel").owlCarousel({
      loop: !1,
      margin: 40,
      nav: !1,
      dots: !0,
      dotsContainer: "#carousel-custom-dots",
      responsive: { 0: { items: 1 }, 768: { items: 2 }, 1200: { items: 1 } },
      onInitialized: function () {
        $(".section-reviews .owl-carousel .item").removeClass("d-none");
      },
    }); $(".kek-subheader-slider .owl-carousel").owlCarousel({
      loop: !1,
      margin: 40,
      nav: !1,
      dots: !0,
      dotsContainer: "#carousel-custom-dots",
      responsive: { 0: { items: 1 }, 768: { items: 2 }, 1200: { items: 1 } },
      onInitialized: function () {
        $(".section-reviews .owl-carousel .item").removeClass("d-none");
      },
    });
    setTimeout(() => {
      $(".owl-dots").each(function () {
        $(this)
          .find(".owl-dot")
          .each(function (index) {
            $(this).attr("aria-label", index + 1);
          });
      });
    }, 100);
    $(".kek-subheader-slider .owl-carousel").owlCarousel({
      nav: !0,
      dots: !1,
      items: 5,
      responsive: {
        0: { items: 1 },
        576: { items: 2 },
        767: { items: 3 },
        1024: { items: 5 },
      },
      onInitialized: function () {
        $(".kek-subheader-slider").removeClass("loading");
      },
    });
    setTimeout(() => {
      $(".owl-dots").each(function () {
        $(this)
          .find(".owl-dot")
          .each(function (index) {
            $(this).attr("aria-label", index + 1);
          });
      });
    }, 100);
  }
  let commentsReviewsSwiper = new Swiper(".swiper-reviews-comments", {
    slidesPerView: 3,
    slidesPerGroup: 3,
    loopFillGroupWithBlank: !0,
    breakpoints: {
      0: { slidesPerView: 1, slidesPerGroup: 1 },
      768: { slidesPerView: 2, slidesPerGroup: 2 },
      1200: { slidesPerView: 3, slidesPerGroup: 3 },
    },
    pagination: {
      el: ".wcl-swiper-pagination",
      clickable: !0,
      type: "custom",
      renderCustom: function (swiper, current, total) {
        let html = "";
        if (total < 8) {
          for (let index = 1; index <= total; index++) {
            let classes = "wcl-pagination-bullet";
            if (index === current) {
              classes += " wcl-pagination-bullet-active";
            }
            html += `<span class="${classes}" data-index="${index}">${index}</span>`;
          }
        } else {
          for (let index = 0; index < total; index++) {
            let classes = "wcl-pagination-bullet";
            if (index == 0) {
              if (current != 1) {
                html += `<span class="${classes} wcl-pagination-bullet-chevron-left" data-index="${
                  current - 1
                }"><i class="bi bi-chevron-left"></i></span>`;
              } else {
                classes += " wcl-pagination-bullet-active";
              }
              html += `<span class="${classes}" data-index="1">1</span>`;
            }
            if (index > 0) {
              if (current <= 3) {
                if (current > 1) {
                  if (current == 3 && index + 1 == current - 1) {
                    html += `<span class="${classes}" data-index="${
                      current - 1
                    }">${current - 1}</span>`;
                  }
                  if (index + 1 == current) {
                    classes += " wcl-pagination-bullet-active";
                    html += `<span class="${classes}" data-index="${current}">${current}</span>`;
                  }
                }
                if (index + 1 == current + 1) {
                  html += `<span class="${classes}" data-index="${
                    current + 1
                  }">${current + 1}</span>`;
                }
                if (index == current + 1) {
                  html += `<span class="${classes} wcl-pagination-bullet-dots">...</span>`;
                }
              } else if (current > 3 && current < total - 2) {
                if (index + 1 >= current - 1 && index + 1 <= current + 1) {
                  if (index + 1 == current) {
                    classes += " wcl-pagination-bullet-active";
                    html += `<span class="${classes}" data-index="${current}">${current}</span>`;
                  } else if (index + 1 == current - 1) {
                    html += `<span class="${classes} wcl-pagination-bullet-dots">...</span>`;
                    html += `<span class="${classes}" data-index="${
                      current - 1
                    }">${current - 1}</span>`;
                  } else if (index + 1 == current + 1) {
                    html += `<span class="${classes}" data-index="${
                      current + 1
                    }">${current + 1}</span>`;
                    html += `<span class="${classes} wcl-pagination-bullet-dots">...</span>`;
                  }
                }
              } else if (current >= total - 2) {
                if (index == current - 1) {
                  html += `<span class="${classes} wcl-pagination-bullet-dots">...</span>`;
                  html += `<span class="${classes}" data-index="${
                    current - 1
                  }">${current - 1}</span>`;
                }
                if (current != total && index + 1 == current) {
                  classes += " wcl-pagination-bullet-active";
                  html += `<span class="${classes}" data-index="${current}">${current}</span>`;
                }
                if (current == total - 2 && index == current) {
                  html += `<span class="${classes}" data-index="${
                    current + 1
                  }">${current + 1}</span>`;
                }
              }
            }
            if (index + 1 == total) {
              if (current == total) {
                classes += " wcl-pagination-bullet-active";
              }
              html += `<span class="${classes}" data-index="${total}">${total}</span>`;
              classes = classes.replace(/ .*/, "");
              if (current != total) {
                html += `<span class="${classes} wcl-pagination-bullet-chevron-right" data-index="${
                  current + 1
                }"><i class="bi bi-chevron-right"></i></span>`;
              }
            }
          }
        }
        return html;
      },
    },
  });
  $(".section-reviews-comments").on(
    "click",
    ".wcl-pagination-bullet:not(.wcl-pagination-bullet-dots)",
    function () {
      let pageIndex = $(this).data("index");
      let groupIndex = commentsReviewsSwiper.params.slidesPerGroup;
      let itemIndex = 0;
      if (groupIndex == 1) {
        itemIndex = pageIndex - 1;
      } else {
        itemIndex = groupIndex * (pageIndex - 1) + 1;
      }
      commentsReviewsSwiper.slideTo(itemIndex, 700);
    }
  );
  $(".tooltip-icon").on("mouseover", function () {
    $(this).siblings(".tooltip").addClass("show");
  });
  $(".tooltip-icon").on("mouseout", function () {
    $(this).siblings(".tooltip").removeClass("show");
  });
  if ($("#section-buy-campaign").length) {
    var a = 0;
    $(window).scroll(function () {
      var oTop = $("#section-buy-campaign").offset().top - 200;
      if (a == 0 && $(window).scrollTop() > oTop) {
        $(".counter .number").each(function () {
          var $this = $(this),
            countTo = $this.attr("data-number");
          $({ countNum: $this.text() }).animate(
            { countNum: countTo },
            {
              duration: 2000,
              easing: "swing",
              step: function () {
                $this
                  .children("span")
                  .text(Math.ceil(this.countNum).toLocaleString("en"));
              },
              complete: function () {
                $this
                  .children("span")
                  .text(Math.ceil(this.countNum).toLocaleString("en"));
              },
            }
          );
        });
        a = 1;
      }
    });
  }
  function numberMask(x) {
    var parts = x.toString().split(".");
    parts[0] = parts[0].replace(/\B(?=(\d{3})+(?!\d))/g, ",");
    return parts.join(".");
  }
});
wow = new WOW({
  boxClass: "wow",
  animateClass: "animated",
  offset: 0,
  mobile: !1,
  live: !0,
});
wow.init();
function copyYoutubeTitleCreatorText(button) {
  if (!button.hasAttribute("data-original-text")) {
    button.setAttribute("data-original-text", button.textContent);
  }
  var textToCopy = button.textContent;
  navigator.clipboard
    .writeText(textToCopy)
    .then(function () {
      button.textContent = "✔ Copied to clipboard!";
      button.classList.add("copied");
      setTimeout(function () {
        button.textContent = button.getAttribute("data-original-text");
        button.classList.remove("copied");
      }, 1000);
    })
    .catch(function (error) {
      console.error("Copy Error: ", error);
    });
}
function copyYoutubeTitleCreatorTextAll() {
  let titles = document.querySelectorAll(
    ".results.title-generator-results .wcl-create-title-response"
  );
  let textToCopy = "";
  titles.forEach(function (title) {
    textToCopy += title.textContent + "\n";
  });
  let textArea = document.createElement("textarea");
  textArea.value = textToCopy;
  document.body.appendChild(textArea);
  textArea.select();
  document.execCommand("Copy");
  textArea.remove();
  let copyButton = document.querySelector(".copy-to-all-btn-title");
  let originalText = copyButton.textContent;
  copyButton.textContent = "✔ Copied to clipboard!";
  setTimeout(function () {
    copyButton.textContent = originalText;
  }, 1000);
}
