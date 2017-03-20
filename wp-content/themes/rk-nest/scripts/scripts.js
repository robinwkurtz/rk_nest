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
    }
};

(function ($) {

    $(document).ready(function () {

        // Email Replace
        functions.emailReplace();

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
        $('.social-links a:not(.mail)').on('click', function (e) {
            e.preventDefault();
            var link = $(this).attr('data-link');
            if (!that.isMobile()) {
                window.open(link, 'newwindow', 'width=700, height=500');
            } else {
                window.location.href = link;
            }
        });

    });

}(jQuery));
