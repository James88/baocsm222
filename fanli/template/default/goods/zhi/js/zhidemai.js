(function(a) {
	a.fn.sidebar = function(b) {
		b = a.extend({
			min: 1,
			fadeSpeed: 200,
			position: "bottom",
			ieOffset: 10,
			anchorOffset: 0,
			relative: false,
			relativeWidth: 960,
			backToTop: false,
			backContainer: "#backToTop",
			smooth: ".smooth",
			overlay: false,
			once: false,
			load: false,
			onShow: null
		},
		b);
		return this.each(function() {
			var i = a(this),
			m = a.browser,
			c = a(window),
			d = a(document),
			h = a("body, html"),
			l = b.fadeSpeed,
			f = (c.height() == d.height()) && !b.backToTop;
			var e = function() {
				if ( !! window.ActiveXObject && !window.XMLHttpRequest) {
					i.css({
						position: "absolute"
					});
					if (b.position == "bottom") {
						i.css({
							top: c.scrollTop() + c.height() - i.height() - b.ieOffset
						})
					}
					if (b.position == "top") {
						i.css({
							top: c.scrollTop() + b.ieOffset
						})
					}
				}
				if (!b.load && c.scrollTop() >= b.min || f) {
					i.fadeIn(l);
					if (typeof(b.onShow) === "function") {
						b.onShow()
					}
				} else {
					if (!b.once) {
						i.fadeOut(l)
					}
				}
			};
			if (b.min == 0 || f) {
				e()
			}
			c.on("scroll.sidebar",
			function() {
				e()
			});
			if (b.relative) {
				var k = b.relativeWidth,
				g = i.width(),
				j = (c.width() + k) / 2;
				i.css("left", j);
				c.on("resize.sidebar scroll.sidebar",
				function() {
					var n = c.width();
					if (b.overlay) {
						j = (n - g * 2 > k) ? ((n + k) / 2) : (n - g)
					} else {
						j = (n + k) / 2
					}
					i.css("left", j)
				})
			}
			if (b.backToTop) {
				a(b.backContainer).click(function() {
					h.animate({
						scrollTop: 0
					},
					100);
					return false
				})
			}
			i.find(b.smooth).click(function() {
				h.animate({
					scrollTop: a(a(this).attr("href")).offset().top - b.anchorOffset
				},
				100);
				return false
			})
		})
	}
})(jQuery);

(function(a) {
	a.fn.sticky = function(b) {
		b = a.extend({
			min: 1,
			max: null,
			top: 0,
			stickyClass: "stickybox",
			zIndex: 999
		},
		b);
		return this.each(function() {
			var d = a(this),
			c = a.browser,
			e = a(window),
			g = !!window.ActiveXObject && !window.XMLHttpRequest;
			function f() {
				var h = e.scrollTop();
				if ((b.max == null && h >= b.min) || (b.max != null && h >= b.min && h < b.max)) {
					d.addClass(b.stickyClass);
					if (!g) {
						d.css({
							position: "fixed",
							top: b.top,
							"z-index": b.zIndex
						})
					} else {
						d.css({
							position: "absolute",
							top: e.scrollTop(),
							"z-index": b.zIndex
						})
					}
				} else {
					d.removeClass(b.stickyClass).removeAttr("style")
				}
			}
			e.on("scroll.sticky",
			function() {
				f()
			})
		})
	}
})(jQuery);