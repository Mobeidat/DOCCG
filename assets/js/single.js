/**
 * Theme custom JS.
 *
 * Single menu
 * Single toggle
 * Comment toggle
 *
 * @package TingBiao Wang
 */

/*global $*/
$(document).ready(function () {
	"use strict";

	// Single menu
	var documentHeight = 0;
	var topPadding = 15;
	$(function () {
		var offset = $("#single-float").offset();
		documentHeight = $(document).height();
		$(window).scroll(function () {
			var sideBarHeight = $("#single-float").height();
			if ($(window).scrollTop() > offset.top) {
				var newPosition = ($(window).scrollTop() - offset.top) + topPadding;
				var maxPosition = documentHeight - (sideBarHeight + 368);
				if (newPosition > maxPosition) {
					newPosition = maxPosition;
				}
				$("#single-float").stop().animate({
					marginTop: newPosition
				});
			} else {
				$("#single-float").stop().animate({
					marginTop: 0
				});
			}
		})
	});

	// Single toggle
	$("a#single-toggle").on("click", function (event) {
		$("nav.single-menu").slideToggle();
		event.stoppropagation();
	});

	// Comment toggle
	$("a.comment-toggle").on("click", function (event) {
		$("footer.single-foo").toggleClass("comment-open");
		event.stoppropagation();
	});

})
