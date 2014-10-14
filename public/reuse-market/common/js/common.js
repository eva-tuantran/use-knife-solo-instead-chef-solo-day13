/* Table Of Contents
------------------------------------------
IE Dotted Line Link Canceller
Smooth Scroll
------------------------------------------ */

/* =================================================================

	IE Dotted Line Link Canceller

================================================================= */
$(function(){
	$("a").on("focus", function(){
		if (this.blur) this.blur();
	});
});

/* =================================================================

	Smooth Scroll

================================================================= */
$(function(){
	var scSpeed = 700;
	var html = "html";

	var self;
	var href;
	var target;
	var position;

	$("a[href^=#]").click(function() {
		self = $(this);
		smoothScroll();
		return false;
	});

	function smoothScroll() {
		href= self.attr("href");
		target = href == "#" || href == "" ? "body" : href

		position = $(target).offset().top;

		if (navigator.userAgent.match(/Chrome|Safari/)) {
			html = "body";
		}
		$(html).stop(false, true).animate({scrollTop:position}, scSpeed, "easeOutQuart");
	}
});

