
$(window).load(function(){

    $('.gallery-image').on('mouseover', function(){
        $('.main-image img').attr('src', $(this).children('img').attr('src'));
        $('.gallery-image.selected').first().removeClass('selected');
        $(this).addClass('selected');
    })
    
    $('.variation-attribute').each(function(){
        $(this).on('change', function(){
            var array = {};
            $('.variation-attribute').each(function(){
                array['attribute_' + $(this).attr('name')] = $(this).val();
            })
            var info = getInfo(available_variations, array)[0];
            $('.price-new .sale-price').each(function(){
                $(this).html(info.display_price);
            })
            $('.price-new .regular-price').each(function(){
                $(this).html(info.display_regular_price);
            })
            $('#stock_quantity').attr('class', 'no-stock ' + stockClass(info.max_qty));
            $('#stock_quantity').html(info.max_qty);
            $('#quantity').attr('max', info.max_qty);
            $('#quantity').attr('min', info.min_qty);
        })
    })

    $('.facebook-share').click(function(){
        elem = $(this);
        postToFeed(elem.data('title'), elem.data('desc'), elem.prop('href'), elem.data('image'));
        return false;
    });

});

function stockClass(quantity) {
    if (quantity > 20) {
        return 'info';
    } else if (quantity > 10) {
        return 'warning';
    } else {
        return 'danger';
    }
}

function getInfo(available_variations, queryArray) {
    available_variations = available_variations.filter(function(value){
        return (JSON.stringify(value.attributes) === JSON.stringify(queryArray));
    });
    return available_variations;
}

window.fbAsyncInit = function(){
    FB.init({
        appId: '2151716371755724', status: true, cookie: true, xfbml: true }); 
    };
    (function(d, debug){var js, id = 'facebook-jssdk', ref = d.getElementsByTagName('script')[0];
        if(d.getElementById(id)) {return;}
        js = d.createElement('script'); js.id = id; 
        js.async = true;js.src = "//connect.facebook.net/en_US/all" + (debug ? "/debug" : "") + ".js";
        ref.parentNode.insertBefore(js, ref);}(document, /*debug*/ false));
    function postToFeed(title, desc, url, image){
    var obj = {method: 'feed',link: url, picture: image,name: title,description: desc};
    function callback(response){}
    FB.ui(obj, callback);
}