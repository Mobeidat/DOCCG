/**
 * Theme custom JS.
 *
 * Menu toggle
 * Submenu toggle
 * Comment toggle
 * Totop scroll click
 * 
 * @package TingBiao Wang
 */
/*global $*/
$(document).ready(function () {
	"use strict";

	var SubMenu = $("ul.sub-menu"),
		Totop = $("a#totop");

	// Menu toggle
	$("a#menu-toggle i").on("click", function (event) {
		$("nav#nav").slideToggle();
		if ($(this).hasClass("fa-bars")) {
			$(this).removeClass("fa-bars").addClass("fa-times").parent("a").css("opacity", "1");
		} else {
			$(this).removeClass("fa-times").addClass("fa-bars").parent("a").css("opacity", ".6");
		}
		event.stoppropagation();
	});

	// Submenu toggle
	SubMenu.siblings("a").after('<i class="fa fa-angle-down"></i>');
	SubMenu.siblings("i").on("click", function (event) {
		$(this).next().slideToggle();
		$(this).parent().toggleClass("sub-menu-open");
		if ($(this).hasClass("fa-angle-down")) {
			$(this).removeClass("fa-angle-down").addClass("fa-angle-up");
			$(this).parent().siblings().removeClass("sub-menu-open").children("ul").slideUp();
			$(this).parent().siblings().children("i").removeClass("fa-angle-up").addClass("fa-angle-down");
		} else {
			$(this).removeClass("fa-angle-up").addClass("fa-angle-down");
		}
		event.stoppropagation();
	});

	// Comment toggle
	$("a.comment-toggle").on("click", function (event) {
		$("footer.single-foo").toggleClass("comment-open");
		event.stoppropagation();
	});

	// Totop scroll click
	$(window).scroll(function () {
		var Scrolls = $(this).scrollTop();
		if (Scrolls > 100) {
			Totop.show();
		} else {
			Totop.hide();
		}
	});
	Totop.on("click", function (event) {
		$("html, body").animate({
			scrollTop: 0
		}, "slow");
		event.stoppropagation();
	});

})
