
function showLoadingScreen() {
    $('.backdrop-loader').show();
}

function hideLoadingScreen() {
    $('.backdrop-loader').hide();
}

$(window).load(function(){

    $('.add-to-cart').not('.not-directly').each(function(){
        $(this).click(function(event){
            event.preventDefault();
            showLoadingScreen();
            var variations = "";
            $(this).closest('.buy').find('.variation-attribute').each(function(){
                variations += '&attribute_' + $(this).attr('name') + '=' + $(this).val();
            });
            $.get('?add-to-cart=' + $(this).closest('.buy').find('.product-id').val() + 
                    '&quantity=' + $(this).closest('.buy').find('.quantity').val() + variations, function(){
                hideLoadingScreen();
                goToLink();
            });
        })
    });

    /* search functionality */
    $('#search-form').on('submit', function(e){
        e.preventDefault();
        search($('#search-term').val());
    });

    $('.woocommerce-error, .woocommerce-info, .woocommerce-message').click(function(){
        $(this).fadeOut();
    })
    
})

function search(term) {
    var currentUrlSplit = window.location.href.split('/');
    var index = currentUrlSplit.indexOf('cautare');
    if (index >= 0) {
        currentUrlSplit.splice(index, 2);
    }
    if ($('body').hasClass('archive')) {
        var redirect = currentUrlSplit.slice(0, 3).join('/') + 
        (term ? '/cautare/' + term : '') + '/' + 
        currentUrlSplit.slice(3, currentUrlSplit.length).join('/');
    } else {
        var redirect = currentUrlSplit.slice(0, 3).join('/') + 
        (term ? '/cautare/' + term : '');
    }
    goToLink(redirect);
}