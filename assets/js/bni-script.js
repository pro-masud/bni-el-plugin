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
})(jQuery);