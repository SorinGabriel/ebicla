
$(window).load(function(){
    $('#lowest-price').on('keypress', function(e){
        if (e.which == 13) {
            priceRedirect();
        }
    });
    $('#highest-price').on('keypress', function(e){
        if (e.which == 13) {
            priceRedirect();
        }
    });
    $('#price-filter').on('click', function(e){
        priceRedirect();
    });
    $('#sort-select').on('change', function(){
        goToLink($(this).val());
    })
    $('.input-go').on('click', function(){
        goToLink($(this).parent().find('a').attr('href'));
    })
    $('#filters h3').on('click', function(){
        if (window.matchMedia("(max-width: 991px)").matches) {
            if ($(this).find('i').hasClass('fa-caret-down')) {
                $(this).find('i').addClass('fa-caret-up');
                $(this).find('i').removeClass('fa-caret-down');
                $(this).parent().find('.row').each(function(){
                    $(this).fadeIn();
                })
            } else {
                $(this).find('i').removeClass('fa-caret-up');
                $(this).find('i').addClass('fa-caret-down');
                $(this).parent().find('.row').each(function(){
                    $(this).fadeOut();
                })
            }
        }
    })
})

function validation() {
    if (parseFloat($('#highest-price').val()) < parseFloat($('#lowest-price').val())) {
        $('.validation-message.validation-price').show();
        return false;
    }
    return true;
}

function priceRedirect() {
    if (validation()) {
        goToLink($('#price-filter').parent().find('.url-value')
                                            .val()
                                            .replace('/pret-maxim/#pret_max#', ($('#highest-price').val().length > 0 ? '/pret-maxim/' + $('#highest-price').val() : ''))
                                            .replace('/pret-minim/#pret_min#', ($('#lowest-price').val().length > 0 ? '/pret-minim/' + $('#lowest-price').val() : '')));
    }
}