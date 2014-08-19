/* Table Of Contents
------------------------------------------
Pagetop
Head Navigation
Global Navigation Hover
------------------------------------------ */

/* =================================================================

	Pagetop

================================================================= */
$(function(){
	var dispSpeed = 50;
	var imgSlideSpeed = 200;
	var dispEasing = "linear";
	var imgSlideEasing = "easeOutQuart";
	var ptElem = $(".pagetop");
	var footElem = $("#footerArea");
	var ptElemWidth = ptElem.width();
	var footHeight = footElem.innerHeight();
	var rightVal = 30;
	var bottomVal = 30;
	var scrollHeight;
	var scrollPosition;
	var sc;

	ptElem.css({
		right: -ptElemWidth + "px",
		visibility: "visible"
	});

	$(window).on("scroll", function() {
		sc = $(window).scrollTop();
		scrollHeight = $(document).height();
		scrollPosition = $(window).height() + sc;
		footHeight = footElem.innerHeight();

		if (sc >= 100) {
			ptElem.stop().animate({
				right: rightVal + "px"
			}, dispSpeed, dispEasing );
		} else {
			ptElem.stop().animate({
				right: -ptElemWidth + "px"
			}, dispSpeed, dispEasing );
		}

		if (scrollHeight - scrollPosition <= footHeight) {
			ptElem.css({
				bottom: footHeight - (scrollHeight - scrollPosition) + bottomVal + "px"
			});
		} else {
			ptElem.css({
				bottom: bottomVal + "px"
			});
		}
	});
});

/* =================================================================

	Head Navigation

================================================================= */
$(function(){
	// スクロールスピード
	var scSpeed = 500;

	// ナビゲーション表示スピード
	var showSpeed = 200;

	// ナビゲーション表示イージング
	var showEasing = "swing";

	// 内部処理変数
	var hnavElem = $("#headNav");
	var firstNav = $("#mainVisualNav");
	var secElem = $(".secElem:not(.navNonAct)");
	var curElem;
	var secObjs = {};
	var secId;
	var navId;
	var hnavHeight = hnavElem.outerHeight();
	var sc = Math.floor($(window).scrollTop());
	var navClickFlg = 0;

	// 各セクションオブジェクトのデータ取得
	var getSecData = function() {
		secElem.each(function(i) {
			secId = $(this).attr("id").split("Sec")[0];  
			secObjs[secId] = {};
			secObjs[secId]["id"] = secId;
			secObjs[secId]["top"] = Math.floor($(this).offset().top);
			secObjs[secId]["obj"] = $(this);
		});
	}
	getSecData();

	// ナビゲーション表示イベント
	var hnavDispEvent = {
		show: function() {
			hnavElem.show().stop().animate({
				top: 0
			}, showSpeed, showEasing );
		},
		hide: function() {
			hnavElem.stop().animate({
				top: -hnavHeight + "px"
			}, showSpeed, showEasing, function() {
				$(this).show();
			});
		},
		navScroll: function() {
			var target = $("#" + navId + "Sec");
			var position = $(target).offset().top;
			var html = navigator.userAgent.match(/Chrome|Safari/) ? "body" : "html";

			$(html).animate({
				scrollTop: position
			}, scSpeed, "easeOutQuart", function() {
				navClickFlg = 0;
			});
		},
		navCurrent: function() {
			if (!navClickFlg) {
				hnavElem.find("li").not(firstNav).not("#shopNav").each(function() {
					navId = $(this).attr("id").split("Nav")[0];

					if (sc >= secObjs[navId].top) {
						$(this).addClass("current");
						hnavElem.find("li").not($(this)).removeClass("current");
					} else {
						$(this).removeClass("current");
					}
				});
			} else {
				hnavElem.find("li").not(firstNav).removeClass("current");
				curElem.addClass("current");
			}
		}
	}

	// ナビクリックイベント
	hnavElem.find("a").on("click", function() {
		curElem = $(this).parent();
		navId = curElem.attr("id").split("Nav")[0];

		if ($(this).parent().is(firstNav)) {	
			hnavDispEvent.navScroll();
		} else if (!navClickFlg && !$(this).parent().is("#shopNav")) {
			navClickFlg = 1;
	
			hnavDispEvent.navScroll();
			hnavDispEvent.navCurrent();
		}
	});

	// ウィンドウスクロールイベント
	$(window).scroll(function() {
		sc = Math.floor($(this).scrollTop());

		getSecData();

		if (navClickFlg) return;

		hnavDispEvent.navCurrent();

		if (sc >= secObjs.outline.top) {
			hnavDispEvent.show();
		} else {
			hnavDispEvent.hide();
		}
	});
});

/* =================================================================

	Global Navigation Hover

================================================================= */
$(function(){
	var dispSpeed = 200;
	var dispEasing = "easeInOutQuad";
	var gnavElem = $("#mainVisualSec .gnav");
	var backImgElem = $("#mainVisualSec .gnav .backImg");
	var backImgHeight = backImgElem.height();
	var curElem;

	var gnavFunc = {
		mOver: function() {
			curElem.find(backImgElem).stop(true, false)
			.animate({
				top: -backImgHeight + "px"
			}, dispSpeed, dispEasing )
			.animate({
				top: -backImgHeight + 10 + "px"
			}, dispSpeed, dispEasing );
		},
		mOut: function() {
			curElem.find(backImgElem)
			.animate({
				top: 0
			}, dispSpeed, dispEasing );
		}
	}

	gnavElem.find("a").hover(function() {
		curElem = $(this).closest("li");
		gnavFunc.mOver();
	},
	function() {
		gnavFunc.mOut();
	});

});

