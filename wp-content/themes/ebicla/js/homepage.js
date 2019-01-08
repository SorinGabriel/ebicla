
$(window).load(function(){

    /* making divs clickable */
    $('.category').on('click', function(){
        goToLink($(this).find('a').attr('href'));
    })

})

/* carousel on swipe */
$('#homepageCarousel').swipe({

    swipe: function(event, direction, distance, duration, fingerCount, fingerData) {

        if (direction == 'left') $(this).carousel('next');
        if (direction == 'right') $(this).carousel('prev');

    },
    allowPageScroll:'vertical'

});