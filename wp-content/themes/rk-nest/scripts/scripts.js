var isMobile = {
    Android: function () {
        return navigator.userAgent.match(/Android/i);
    },
    BlackBerry: function () {
        return navigator.userAgent.match(/BlackBerry/i);
    },
    iOS: function () {
        return navigator.userAgent.match(/iPhone|iPod|iPad/i);
    },
    Opera: function () {
        return navigator.userAgent.match(/Opera Mini/i);
    },
    Windows: function () {
        return navigator.userAgent.match(/IEMobile/i);
    },
    any: function () {
        return (
            isMobile.Android() ||
                isMobile.BlackBerry() ||
                isMobile.iOS() ||
                isMobile.Opera() ||
                isMobile.Windows() );
    }
};

var handleClick = (isMobile.any() !== null) ? "touchstart" : "click";

$ = jQuery;
var functions = {
    emailReplace: function () {
        /** Use JavaScript to replace <a> with a mail link, to reduce potential spam**/
        var _varPre = "mailto:",
            _selector = ".js-replacer-text";

        if ($(_selector).length > 0) {
            $(_selector).each(function () {
                var _varUpdate = $(this).data('update'),
                    _varEnd = $(this).data('domain'),
                    _varMid = $(this).data('extra'),
                    _varText = $(this).data('text');
                $(this).attr('href', _varPre + _varMid + '@' + _varEnd);
                if (typeof _varUpdate == 'boolean' && _varUpdate != true) {


                } else {
                    if (typeof _varText !== 'undefined') {
                        $(this).html(_varText);
                    } else {
                        $(this).text(_varMid + '@' + _varEnd);
                    }
                }
            });
        }
    },
    externalLinks: function () {
        $('a').each(function () {
            var href = $(this).attr('href');
            if (href && href.indexOf(window.location.hostname) === -1) {
                $(this).attr('target', '_blank');
            }
        });
    }
};

(function ($) {

    $(document).ready(function () {

        functions.emailReplace();
        functions.externalLinks();

		// Burger Menu
    	$('.js-menu-button').on('click touchstart', function (event) {
    		event.preventDefault();
    		$('body').toggleClass('is-active');
    	});

        // Checklist
        $('.js-checklist li').on('click touchstart', function (event) {
            event.preventDefault();
            $(this).toggleClass('active');
        });

        // Sharing links
        $('.social-links a:not(.mail)').on('click', function (event) {
            event.preventDefault();
            var link = $(this).attr('data-link');
            if (isMobile.any() !== null) {
                window.open(link, '_blank', 'width=700, height=500');
            } else {
                window.location.href = link;
            }
        });

    });

}(jQuery));
