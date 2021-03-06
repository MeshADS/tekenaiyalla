/* ============================================================
 * Demo
 * Try various layout options available in Pages
 * For DEMO purposes only.
 * ============================================================ */
(function($) {

    'use strict';

    // DEMO MODALS SIZE TOGGLER

    $('#btnToggleSlideUpSize').click(function() {
        var size = $('input[name=slideup_toggler]:checked').val()
        var modalElem = $('#modalSlideUp');
        if (size == "mini") {
            $('#modalSlideUpSmall').modal('show')
        } else {
            $('#modalSlideUp').modal('show')
            if (size == "default") {
                modalElem.children('.modal-dialog').removeClass('modal-lg');
            } else if (size == "full") {
                modalElem.children('.modal-dialog').addClass('modal-lg');
            }
        }
    });

    $('#btnStickUpSizeToggler').click(function() {
        var size = $('input[name=stickup_toggler]:checked').val()
        var modalElem = $('#myModal');
        if (size == "mini") {
            $('#modalStickUpSmall').modal('show')
        } else {
            $('#myModal').modal('show')
            if (size == "default") {
                modalElem.children('.modal-dialog').removeClass('modal-lg');
            } else if (size == "full") {
                modalElem.children('.modal-dialog').addClass('modal-lg');
            }
        }
    });

    // Only for fillin modals so that the backdrop action is still there
    $('#modalFillIn').on('show.bs.modal', function(e) {
        $('body').addClass('fill-in-modal');
    })
    $('#modalFillIn').on('hidden.bs.modal', function(e) {
        $('body').removeClass('fill-in-modal');
    })

    //END 

    //Typo Platform
    if ($('#platform').length) {
        var p = $.Pages.getUserPlatform();
        $('#platform').html('<strong>' + $.Pages.getUserPlatform() + '</strong>');
        var fontName;
        if (navigator.appVersion.indexOf("Win") != -1) fontName = "SegeoUI";
        if (navigator.appVersion.indexOf("Mac") != -1) fontName = "Helvetica Neue";
        if (navigator.appVersion.indexOf("X11") != -1) fontName = "Ubuntu";
        if (navigator.appVersion.indexOf("Linux") != -1) fontName = "Ubuntu";
        $('#font_name').text(fontName);
    }

    // START BUILDER


    var resetMenu = function() {
        $('body').removeClass(function(index, css) {
            return (css.match(/(^|\s)menu-\S+/g) || []).join(' ');
        });
    }
    var resetContent = function() {
        $('.page-content-wrapper').removeClass('active');
    }

    var changeTheme = function(name) {
        if (name == null) {
            $('.main-stylesheet').attr('href', 'pages/css/pages.css');
            return;
        }
        $('.main-stylesheet').attr('href', 'pages/css/themes/' + name + '.min.css');
    }

    $('.btn-toggle-layout').click(function() {
        $('.btn-toggle-layout').removeClass('active');
        var action = $(this).attr('data-action');
        $(this).addClass('active');
        switch (action) {
            case 'menuDefault':
                resetMenu();
                break;
            case 'menuPinned':
                resetMenu();
                $('body').addClass('menu-pin');
                break;
            case 'menuBelow':
                resetMenu();
                $('body').addClass('menu-behind');
                break;
            case 'menuPinnedBelow':
                resetMenu();
                $('body').addClass('menu-pin menu-behind');
                break;
        }
    });

    $('.btn-toggle-theme').click(function() {
        $('.btn-toggle-theme').removeClass('active');
        var action = $(this).attr('data-action');
        $(this).addClass('active');
        switch (action) {
            case 'default':
                changeTheme();
                break;
            case 'corporate':
                changeTheme('corporate')
                break;
            case 'retro':
                changeTheme('retro');
                break;
            case 'unlax':
                changeTheme('unlax');
                break;
            case 'vibes':
                changeTheme('vibes');
                break;
            case 'abstract':
                changeTheme('abstract');
                break;
        }
    });

    $('.btn-toggle-content').click(function() {
        $('.btn-toggle-content').removeClass('active');
        var action = $(this).attr('data-action');
        $(this).addClass('active');
        switch (action) {
            case 'plainContent':
                resetContent();
                $('#plainContent').addClass('active');
                break;
            case 'parallaxCoverpage':
                resetContent();
                $('#parallaxCoverpage').addClass('active');
                break;
            case 'fullheightParallax':
                resetContent();
                $('#fullheightParallax').addClass('active');
                $('#builder').toggleClass('open');
                break;
            case 'titleParallax':
                resetContent();
                $('#titleParallax').addClass('active');
                break;
            case 'columns-3-9':
                resetContent();
                $('#columns-3-9').addClass('active');
                break;
            case 'columns-9-3':
                resetContent();
                $('#columns-9-3').addClass('active');
                $('#builder').toggleClass('open');
                break;
            case 'columns-6-6':
                resetContent();
                $('#columns-6-6').addClass('active');
                $('#builder').toggleClass('open');
                break;
        }
    });
    // END BUILDER

})(window.jQuery);