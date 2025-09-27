(function($){
    $(function(){
         // init isotope
        var $grid = $('.bni-gallery').isotope({
            itemSelector: '.bni-item',
            layoutMode: 'fitRows'
        });

        // filter buttons
        $('.bni-filter-btns').on('click', 'button', function () {
            var filterValue = $(this).attr('data-filter');
            $grid.isotope({ filter: filterValue });

            // active button
            $('.bni-filter-btns button').removeClass('active');
            $(this).addClass('active');
        });
    });


    const bniSwiper = new Swiper('.bni-swiper', {
        slidesPerView: 2,
        spaceBetween: 16,
        loop: true,
        autoplay: { delay: 3000, disableOnInteraction: false },
        pagination: { el: '.swiper-pagination', clickable: true },
        breakpoints: {
          640:  { slidesPerView: 2, spaceBetween: 20 },
          0:  { slidesPerView: 1, spaceBetween: 10 },
        }
      });

    $('.bni-next').on('click', function () { bniSwiper.slideNext(); });
    $('.bni-prev').on('click', function () { bniSwiper.slidePrev(); });


    const bniEventSlider = new Swiper('.bni-event-slider', {
        slidesPerView: 2,
        spaceBetween: 16,
        loop: true,
        autoplay: { delay: 3000, disableOnInteraction: false },
        pagination: { el: '.swiper-pagination', clickable: true },
        breakpoints: {
          640:  { slidesPerView: 2, spaceBetween: 20 },
          0:  { slidesPerView: 1, spaceBetween: 10 },
        }
      });

    $('.bni-event-next').on('click', function () { bniEventSlider.slideNext(); });
    $('.bni-event-prev').on('click', function () { bniEventSlider.slidePrev(); });


    $('.bni-next').on('click', function () { bniSwiper.slideNext(); });
    $('.bni-prev').on('click', function () { bniSwiper.slidePrev(); });


    const bniCollSlider = new Swiper('.bni-col-slider', {
        slidesPerView: 1,     
        grid: {
            rows: 2,              
            fill: 'row'             
        },
        spaceBetween: 16,
        loop: true,
        autoplay: { delay: 3000, disableOnInteraction: false },

        breakpoints: {
            0: {
            slidesPerView: 1,
            grid: { rows: 2 },
            spaceBetween: 10
            },
            768: {
            slidesPerView: 1,
            grid: { rows: 2 },
            spaceBetween: 16
            }
        }
        });

    // External nav buttons (jQuery)
    $('.bni-event-next').on('click', function () { bniCollSlider.slideNext(); });
    $('.bni-event-prev').on('click', function () { bniCollSlider.slidePrev(); });

})(jQuery);