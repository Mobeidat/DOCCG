/*global $*/
$(document).ready(function () {
    "use strict";

    var WindowTop = 0,
        SubMenu = $("ul.sub-menu"),
        Totop = $("a#totop");

    /* Menu toggle */
    $("a#menu-toggle i").on("click", function (event) {
        $("nav#nav").slideToggle();
        if ($(this).hasClass("fa-bars")) {
            $(this).removeClass("fa-bars").addClass("fa-times").parent("a").css("opacity", "1");
        } else {
            $(this).removeClass("fa-times").addClass("fa-bars").parent("a").css("opacity", ".6");
        }
        return false;
    });

    /* submenu */
    SubMenu.siblings("a").after('<i class="fa fa-angle-down"></i>');
    SubMenu.siblings("i").on("click", function (event) {
        $(this).siblings("ul").slideToggle();
        $(this).parent("li").toggleClass("sub-menu-open");
        if ($(this).hasClass("fa-angle-down")) {
            $(this).switchClass("fa-angle-down", "fa-angle-up");
        } else {
            $(this).switchClass("fa-angle-up", "fa-angle-down");
        }
        return false;
    });

    /* Totop scroll */
    $(window).scroll(function () {
        var Scrolls = $(this).scrollTop();
        if (Scrolls > 100) {
            Totop.fadeIn();
        } else {
            Totop.fadeOut();
        }
    });
    Totop.on("click", function (event) {
        $("html, body").animate({
            scrollTop: 0
        }, "slow");
        return false;
    });

});
