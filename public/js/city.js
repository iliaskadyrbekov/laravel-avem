$(document).ready(function() {
    $('#scrollRight').on('click', function (event) {
        event.preventDefault();
        let unit_width = $('#caruselUnit').outerWidth();
        let carusel = $('#carusel');
        let n_scrolled = (carusel.scrollLeft()/unit_width).toFixed();
        let delta = (carusel.scrollLeft() - n_scrolled * unit_width).toFixed(3);

        carusel.animate({
            scrollLeft: `+=${unit_width - delta}`
        }, "medium");
    });

    $('#scrollLeft').on('click', function (event) {
        event.preventDefault();

        let unit_width = $('#caruselUnit').outerWidth();
        let carusel = $('#carusel');
        let n_scrolled = (carusel.scrollLeft()/unit_width).toFixed();
        let delta = (-carusel.scrollLeft() + n_scrolled * unit_width).toFixed(3);

        carusel.animate({
            scrollLeft: `-=${unit_width - delta}`
        }, "medium");
    });
});


