jQuery(document).ready(function($){
  $('.cards--carousel').each(function() {
    var container = $(this).find('.cards--carousel--container');

    //button class names need to be unique to have multiple carousels on one page.
    var prevClass = $(this).find('button[class^="slick-prev"]');
    var nextClass = $(this).find('button[class^="slick-next"]');

    /**
      * different types of carousels need different args
    **/

    //carousel on city page overlaying map
    if($(this).data("carousel-init") == "cardsCarouselPageMap") {
      container.slick({
        dots: true,
        infinite: false,
        speed: 300,
        mobileFirst: true,
        slidesToShow: 1,
        slidesToScroll: 1,
        responsive: [
          {
            breakpoint: 640,
            settings: {
              slidesToShow: 2,
              slidesToScroll: 1,
              dots: true
            }
          },
          {
            breakpoint: 768,
            settings: {
              slidesToShow: 2,
              slidesToScroll: 1,
              dots: true
            }
          },
          {
            breakpoint: 992,
            settings: {
              slidesToShow: 4,
              slidesToScroll: 1,
              dots: true
            }
          },
          {
            breakpoint: 1366,
            settings: {
              slidesToShow: 6,
              slidesToScroll: 1,
              dots: true
            }
          }
          // You can unslick at a given breakpoint now by adding:
          // settings: "unslick"
          // instead of a settings object
        ],
        nextArrow: $(nextClass),
        prevArrow: $(prevClass)
      });
    }

    //carousels in middle column of restaurant page
    if($(this).data("carousel-init") == "cardsCarouselPageRestaurant") {
      container.slick({
        dots: true,
        infinite: false,
        speed: 300,
        slidesToShow: 3,
        slidesToScroll: 1,
        responsive: [
          {
            breakpoint: 992,
            settings: {
              slidesToShow: 2,
              slidesToScroll: 1,
              dots: true
            }
          },
          {
            breakpoint: 640,
            settings: {
              slidesToShow: 1,
              slidesToScroll: 1

            }
          }
          // You can unslick at a given breakpoint now by adding:
          // settings: "unslick"
          // instead of a settings object
        ],
        nextArrow: $(nextClass),
        prevArrow: $(prevClass)
      });
    }
  });

});