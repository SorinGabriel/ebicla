
$(window).load(states());

$(window).on('popstate', function(event){
    loadNewPage(location.origin + window.history.state.url, window.history.state.url, false);
})

var loaderHTML = '<div style="display:none" class="backdrop-loader"><div class="loader"></div></div>';

function states() {
    $('a').on('click', goToState);
}

function validationState(anchor, event) {
    var response = {
        'result': false,
        'addToCart': false
    };
    if (anchor[0].hostname !== 'ebicla.ro') {
        return response;
    }
    if (anchor.attr('href').indexOf('#') == 0) {
        return response;
    }
    var target = $(event.target);
    if (target.hasClass('add-to-cart') && !target.hasClass('not-directly')) {
        response.addToCart = true;
        return response;
    }
    response.result = true;
    return response;
}

function goToState(event) {
    if (!$(this).hasClass('not-spa')) {
        var anchor = $(this);
        var validation = validationState(anchor, event);
        if (validation.result === true) {
            event.preventDefault();
            loadNewPage(anchor.attr('href'), anchor[0].pathname);
        } else if (validation.addToCart === true) {
            event.preventDefault();
        }
    }
}

function loadNewPage(url, path, push = true) {
    $('.backdrop-loader').show();
    $.get(url, function(data){
        $('html').hide();
        document.documentElement.innerHTML = data;
        $('html').fadeIn('slow');
        $(window).scrollTop(0);
        var title = $('title').html();
        if (push) {
            window.history.pushState({'title':title, 'url':path}, title, path);
        }
        $('html').find('script[type!="application/ld+json"]').each(function() {
            Function($(this).text())();
        });
        var evt = document.createEvent('Event');  
        evt.initEvent('load', false, false);  
        window.dispatchEvent(evt);
        states();
    }).fail(function(){
        loadNewPage(url, path, push);
    });
}

function goToLink(href = location.href) {
    var anchor = document.createElement('a');
    anchor.href = href;
    document.body.appendChild(anchor);
    states();
    anchor.click();    
}