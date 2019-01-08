
$(window).load(function () {
    /* burger effect */
    $('.navbar-toggle').on('click', function () {
        $(this).toggleClass('active');
    });

    /* burger for categories */    
    $('#categories-burger').on('click', function(){
        if ($('.mobile-not-visible').length > 0) {
            $('.mobile-not-visible').each(function(){
                $(this).show('fast', function(){
                    $(this).removeClass('mobile-not-visible');
                })
            })
        } else {
            $('#categoriesNavbar li:not(.categories-button)').each(function(){
                $(this).hide('fast', function(){
                    $(this).addClass('mobile-not-visible');
                })
            })
        }
    })

});