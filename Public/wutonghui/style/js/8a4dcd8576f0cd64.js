/*!
 * Bootstrap v3.3.2 (http://getbootstrap.com)
 * Copyright 2011-2015 Twitter, Inc.
 * Licensed under MIT (https://github.com/twbs/bootstrap/blob/master/LICENSE)
 */
if (typeof jQuery == "undefined") throw new Error("Bootstrap's JavaScript requires jQuery"); + 
function(e) {
    "use strict";
    var t = e.fn.jquery.split(" ")[0].split(".");
    if (t[0] < 2 && t[1] < 9 || t[0] == 1 && t[1] == 9 && t[2] < 1) throw new Error("Bootstrap's JavaScript requires jQuery version 1.9.1 or higher")
} (jQuery),
+
function(e) {
    "use strict";
    function t() {
        var e = document.createElement("bootstrap"),
        t = {
            WebkitTransition: "webkitTransitionEnd",
            MozTransition: "transitionend",
            OTransition: "oTransitionEnd otransitionend",
            transition: "transitionend"
        };
        for (var n in t) if (e.style[n] !== undefined) return {
            end: t[n]
        };
        return ! 1
    }
    e.fn.emulateTransitionEnd = function(t) {
        var n = !1,
        r = this;
        e(this).one("bsTransitionEnd", 
        function() {
            n = !0
        });
        var i = function() {
            n || e(r).trigger(e.support.transition.end)
        };
        return setTimeout(i, t),
        this
    },
    e(function() {
        e.support.transition = t();
        if (!e.support.transition) return;
        e.event.special.bsTransitionEnd = {
            bindType: e.support.transition.end,
            delegateType: e.support.transition.end,
            handle: function(t) {
                if (e(t.target).is(this)) return t.handleObj.handler.apply(this, arguments)
            }
        }
    })
} (jQuery),
+
function(e) {
    "use strict";
    function r(t) {
        return this.each(function() {
            var r = e(this),
            i = r.data("bs.alert");
            i || r.data("bs.alert", i = new n(this)),
            typeof t == "string" && i[t].call(r)
        })
    }
    var t = '[data-dismiss="alert"]',
    n = function(n) {
        e(n).on("click", t, this.close)
    };
    n.VERSION = "3.3.2",
    n.TRANSITION_DURATION = 150,
    n.prototype.close = function(t) {
        function o() {
            s.detach().trigger("closed.bs.alert").remove()
        }
        var r = e(this),
        i = r.attr("data-target");
        i || (i = r.attr("href"), i = i && i.replace(/.*(?=#[^\s]*$)/, ""));
        var s = e(i);
        t && t.preventDefault(),
        s.length || (s = r.closest(".alert")),
        s.trigger(t = e.Event("close.bs.alert"));
        if (t.isDefaultPrevented()) return;
        s.removeClass("in"),
        e.support.transition && s.hasClass("fade") ? s.one("bsTransitionEnd", o).emulateTransitionEnd(n.TRANSITION_DURATION) : o()
    };
    var i = e.fn.alert;
    e.fn.alert = r,
    e.fn.alert.Constructor = n,
    e.fn.alert.noConflict = function() {
        return e.fn.alert = i,
        this
    },
    e(document).on("click.bs.alert.data-api", t, n.prototype.close)
} (jQuery),
+
function(e) {
    "use strict";
    function n(n) {
        return this.each(function() {
            var r = e(this),
            i = r.data("bs.button"),
            s = typeof n == "object" && n;
            i || r.data("bs.button", i = new t(this, s)),
            n == "toggle" ? i.toggle() : n && i.setState(n)
        })
    }
    var t = function(n, r) {
        this.$element = e(n),
        this.options = e.extend({},
        t.DEFAULTS, r),
        this.isLoading = !1
    };
    t.VERSION = "3.3.2",
    t.DEFAULTS = {
        loadingText: "loading..."
    },
    t.prototype.setState = function(t) {
        var n = "disabled",
        r = this.$element,
        i = r.is("input") ? "val": "html",
        s = r.data();
        t += "Text",
        s.resetText == null && r.data("resetText", r[i]()),
        setTimeout(e.proxy(function() {
            r[i](s[t] == null ? this.options[t] : s[t]),
            t == "loadingText" ? (this.isLoading = !0, r.addClass(n).attr(n, n)) : this.isLoading && (this.isLoading = !1, r.removeClass(n).removeAttr(n))
        },
        this), 0)
    },
    t.prototype.toggle = function() {
        var e = !0,
        t = this.$element.closest('[data-toggle="buttons"]');
        if (t.length) {
            var n = this.$element.find("input");
            n.prop("type") == "radio" && (n.prop("checked") && this.$element.hasClass("active") ? e = !1: t.find(".active").removeClass("active")),
            e && n.prop("checked", !this.$element.hasClass("active")).trigger("change")
        } else this.$element.attr("aria-pressed", !this.$element.hasClass("active"));
        e && this.$element.toggleClass("active")
    };
    var r = e.fn.button;
    e.fn.button = n,
    e.fn.button.Constructor = t,
    e.fn.button.noConflict = function() {
        return e.fn.button = r,
        this
    },
    e(document).on("click.bs.button.data-api", '[data-toggle^="button"]', 
    function(t) {
        var r = e(t.target);
        r.hasClass("btn") || (r = r.closest(".btn")),
        n.call(r, "toggle"),
        t.preventDefault()
    }).on("focus.bs.button.data-api blur.bs.button.data-api", '[data-toggle^="button"]', 
    function(t) {
        e(t.target).closest(".btn").toggleClass("focus", /^focus(in)?$/.test(t.type))
    })
} (jQuery),
+
function(e) {
    "use strict";
    function n(n) {
        return this.each(function() {
            var r = e(this),
            i = r.data("bs.carousel"),
            s = e.extend({},
            t.DEFAULTS, r.data(), typeof n == "object" && n),
            o = typeof n == "string" ? n: s.slide;
            i || r.data("bs.carousel", i = new t(this, s)),
            typeof n == "number" ? i.to(n) : o ? i[o]() : s.interval && i.pause().cycle()
        })
    }
    var t = function(t, n) {
        this.$element = e(t),
        this.$indicators = this.$element.find(".carousel-indicators"),
        this.options = n,
        this.paused = this.sliding = this.interval = this.$active = this.$items = null,
        this.options.keyboard && this.$element.on("keydown.bs.carousel", e.proxy(this.keydown, this)),
        this.options.pause == "hover" && !("ontouchstart" in document.documentElement) && this.$element.on("mouseenter.bs.carousel", e.proxy(this.pause, this)).on("mouseleave.bs.carousel", e.proxy(this.cycle, this))
    };
    t.VERSION = "3.3.2",
    t.TRANSITION_DURATION = 600,
    t.DEFAULTS = {
        interval: 5e3,
        pause: "hover",
        wrap: !0,
        keyboard: !0
    },
    t.prototype.keydown = function(e) {
        if (/input|textarea/i.test(e.target.tagName)) return;
        switch (e.which) {
        case 37:
            this.prev();
            break;
        case 39:
            this.next();
            break;
        default:
            return
        }
        e.preventDefault()
    },
    t.prototype.cycle = function(t) {
        return t || (this.paused = !1),
        this.interval && clearInterval(this.interval),
        this.options.interval && !this.paused && (this.interval = setInterval(e.proxy(this.next, this), this.options.interval)),
        this
    },
    t.prototype.getItemIndex = function(e) {
        return this.$items = e.parent().children(".item"),
        this.$items.index(e || this.$active)
    },
    t.prototype.getItemForDirection = function(e, t) {
        var n = this.getItemIndex(t),
        r = e == "prev" && n === 0 || e == "next" && n == this.$items.length - 1;
        if (r && !this.options.wrap) return t;
        var i = e == "prev" ? -1: 1,
        s = (n + i) % this.$items.length;
        return this.$items.eq(s)
    },
    t.prototype.to = function(e) {
        var t = this,
        n = this.getItemIndex(this.$active = this.$element.find(".item.active"));
        if (e > this.$items.length - 1 || e < 0) return;
        return this.sliding ? this.$element.one("slid.bs.carousel", 
        function() {
            t.to(e)
        }) : n == e ? this.pause().cycle() : this.slide(e > n ? "next": "prev", this.$items.eq(e))
    },
    t.prototype.pause = function(t) {
        return t || (this.paused = !0),
        this.$element.find(".next, .prev").length && e.support.transition && (this.$element.trigger(e.support.transition.end), this.cycle(!0)),
        this.interval = clearInterval(this.interval),
        this
    },
    t.prototype.next = function() {
        if (this.sliding) return;
        return this.slide("next")
    },
    t.prototype.prev = function() {
        if (this.sliding) return;
        return this.slide("prev")
    },
    t.prototype.slide = function(n, r) {
        var i = this.$element.find(".item.active"),
        s = r || this.getItemForDirection(n, i),
        o = this.interval,
        u = n == "next" ? "left": "right",
        a = this;
        if (s.hasClass("active")) return this.sliding = !1;
        var f = s[0],
        l = e.Event("slide.bs.carousel", {
            relatedTarget: f,
            direction: u
        });
        this.$element.trigger(l);
        if (l.isDefaultPrevented()) return;
        this.sliding = !0,
        o && this.pause();
        if (this.$indicators.length) {
            this.$indicators.find(".active").removeClass("active");
            var c = e(this.$indicators.children()[this.getItemIndex(s)]);
            c && c.addClass("active")
        }
        var h = e.Event("slid.bs.carousel", {
            relatedTarget: f,
            direction: u
        });
        return e.support.transition && this.$element.hasClass("slide") ? (s.addClass(n), s[0].offsetWidth, i.addClass(u), s.addClass(u), i.one("bsTransitionEnd", 
        function() {
            s.removeClass([n, u].join(" ")).addClass("active"),
            i.removeClass(["active", u].join(" ")),
            a.sliding = !1,
            setTimeout(function() {
                a.$element.trigger(h)
            },
            0)
        }).emulateTransitionEnd(t.TRANSITION_DURATION)) : (i.removeClass("active"), s.addClass("active"), this.sliding = !1, this.$element.trigger(h)),
        o && this.cycle(),
        this
    };
    var r = e.fn.carousel;
    e.fn.carousel = n,
    e.fn.carousel.Constructor = t,
    e.fn.carousel.noConflict = function() {
        return e.fn.carousel = r,
        this
    };
    var i = function(t) {
        var r,
        i = e(this),
        s = e(i.attr("data-target") || (r = i.attr("href")) && r.replace(/.*(?=#[^\s]+$)/, ""));
        if (!s.hasClass("carousel")) return;
        var o = e.extend({},
        s.data(), i.data()),
        u = i.attr("data-slide-to");
        u && (o.interval = !1),
        n.call(s, o),
        u && s.data("bs.carousel").to(u),
        t.preventDefault()
    };
    e(document).on("click.bs.carousel.data-api", "[data-slide]", i).on("click.bs.carousel.data-api", "[data-slide-to]", i),
    e(window).on("load", 
    function() {
        e('[data-ride="carousel"]').each(function() {
            var t = e(this);
            n.call(t, t.data())
        })
    })
} (jQuery),
+
function(e) {
    "use strict";
    function n(t) {
        var n,
        r = t.attr("data-target") || (n = t.attr("href")) && n.replace(/.*(?=#[^\s]+$)/, "");
        return e(r)
    }
    function r(n) {
        return this.each(function() {
            var r = e(this),
            i = r.data("bs.collapse"),
            s = e.extend({},
            t.DEFAULTS, r.data(), typeof n == "object" && n); ! i && s.toggle && n == "show" && (s.toggle = !1),
            i || r.data("bs.collapse", i = new t(this, s)),
            typeof n == "string" && i[n]()
        })
    }
    var t = function(n, r) {
        this.$element = e(n),
        this.options = e.extend({},
        t.DEFAULTS, r),
        this.$trigger = e(this.options.trigger).filter('[href="#' + n.id + '"], [data-target="#' + n.id + '"]'),
        this.transitioning = null,
        this.options.parent ? this.$parent = this.getParent() : this.addAriaAndCollapsedClass(this.$element, this.$trigger),
        this.options.toggle && this.toggle()
    };
    t.VERSION = "3.3.2",
    t.TRANSITION_DURATION = 350,
    t.DEFAULTS = {
        toggle: !0,
        trigger: '[data-toggle="collapse"]'
    },
    t.prototype.dimension = function() {
        var e = this.$element.hasClass("width");
        return e ? "width": "height"
    },
    t.prototype.show = function() {
        if (this.transitioning || this.$element.hasClass("in")) return;
        var n,
        i = this.$parent && this.$parent.children(".panel").children(".in, .collapsing");
        if (i && i.length) {
            n = i.data("bs.collapse");
            if (n && n.transitioning) return
        }
        var s = e.Event("show.bs.collapse");
        this.$element.trigger(s);
        if (s.isDefaultPrevented()) return;
        i && i.length && (r.call(i, "hide"), n || i.data("bs.collapse", null));
        var o = this.dimension();
        this.$element.removeClass("collapse").addClass("collapsing")[o](0).attr("aria-expanded", !0),
        this.$trigger.removeClass("collapsed").attr("aria-expanded", !0),
        this.transitioning = 1;
        var u = function() {
            this.$element.removeClass("collapsing").addClass("collapse in")[o](""),
            this.transitioning = 0,
            this.$element.trigger("shown.bs.collapse")
        };
        if (!e.support.transition) return u.call(this);
        var a = e.camelCase(["scroll", o].join("-"));
        this.$element.one("bsTransitionEnd", e.proxy(u, this)).emulateTransitionEnd(t.TRANSITION_DURATION)[o](this.$element[0][a])
    },
    t.prototype.hide = function() {
        if (this.transitioning || !this.$element.hasClass("in")) return;
        var n = e.Event("hide.bs.collapse");
        this.$element.trigger(n);
        if (n.isDefaultPrevented()) return;
        var r = this.dimension();
        this.$element[r](this.$element[r]())[0].offsetHeight,
        this.$element.addClass("collapsing").removeClass("collapse in").attr("aria-expanded", !1),
        this.$trigger.addClass("collapsed").attr("aria-expanded", !1),
        this.transitioning = 1;
        var i = function() {
            this.transitioning = 0,
            this.$element.removeClass("collapsing").addClass("collapse").trigger("hidden.bs.collapse")
        };
        if (!e.support.transition) return i.call(this);
        this.$element[r](0).one("bsTransitionEnd", e.proxy(i, this)).emulateTransitionEnd(t.TRANSITION_DURATION)
    },
    t.prototype.toggle = function() {
        this[this.$element.hasClass("in") ? "hide": "show"]()
    },
    t.prototype.getParent = function() {
        return e(this.options.parent).find('[data-toggle="collapse"][data-parent="' + this.options.parent + '"]').each(e.proxy(function(t, r) {
            var i = e(r);
            this.addAriaAndCollapsedClass(n(i), i)
        },
        this)).end()
    },
    t.prototype.addAriaAndCollapsedClass = function(e, t) {
        var n = e.hasClass("in");
        e.attr("aria-expanded", n),
        t.toggleClass("collapsed", !n).attr("aria-expanded", n)
    };
    var i = e.fn.collapse;
    e.fn.collapse = r,
    e.fn.collapse.Constructor = t,
    e.fn.collapse.noConflict = function() {
        return e.fn.collapse = i,
        this
    },
    e(document).on("click.bs.collapse.data-api", '[data-toggle="collapse"]', 
    function(t) {
        var i = e(this);
        i.attr("data-target") || t.preventDefault();
        var s = n(i),
        o = s.data("bs.collapse"),
        u = o ? "toggle": e.extend({},
        i.data(), {
            trigger: this
        });
        r.call(s, u)
    })
} (jQuery),
+
function(e) {
    "use strict";
    function i(r) {
        if (r && r.which === 3) return;
        e(t).remove(),
        e(n).each(function() {
            var t = e(this),
            n = s(t),
            i = {
                relatedTarget: this
            };
            if (!n.hasClass("open")) return;
            n.trigger(r = e.Event("hide.bs.dropdown", i));
            if (r.isDefaultPrevented()) return;
            t.attr("aria-expanded", "false"),
            n.removeClass("open").trigger("hidden.bs.dropdown", i)
        })
    }
    function s(t) {
        var n = t.attr("data-target");
        n || (n = t.attr("href"), n = n && /#[A-Za-z]/.test(n) && n.replace(/.*(?=#[^\s]*$)/, ""));
        var r = n && e(n);
        return r && r.length ? r: t.parent()
    }
    function o(t) {
        return this.each(function() {
            var n = e(this),
            i = n.data("bs.dropdown");
            i || n.data("bs.dropdown", i = new r(this)),
            typeof t == "string" && i[t].call(n)
        })
    }
    var t = ".dropdown-backdrop",
    n = '[data-toggle="dropdown"]',
    r = function(t) {
        e(t).on("click.bs.dropdown", this.toggle)
    };
    r.VERSION = "3.3.2",
    r.prototype.toggle = function(t) {
        var n = e(this);
        if (n.is(".disabled, :disabled")) return;
        var r = s(n),
        o = r.hasClass("open");
        i();
        if (!o) {
            "ontouchstart" in document.documentElement && !r.closest(".navbar-nav").length && e('<div class="dropdown-backdrop"/>').insertAfter(e(this)).on("click", i);
            var u = {
                relatedTarget: this
            };
            r.trigger(t = e.Event("show.bs.dropdown", u));
            if (t.isDefaultPrevented()) return;
            n.trigger("focus").attr("aria-expanded", "true"),
            r.toggleClass("open").trigger("shown.bs.dropdown", u)
        }
        return ! 1
    },
    r.prototype.keydown = function(t) {
        if (!/(38|40|27|32)/.test(t.which) || /input|textarea/i.test(t.target.tagName)) return;
        var r = e(this);
        t.preventDefault(),
        t.stopPropagation();
        if (r.is(".disabled, :disabled")) return;
        var i = s(r),
        o = i.hasClass("open");
        if (!o && t.which != 27 || o && t.which == 27) return t.which == 27 && i.find(n).trigger("focus"),
        r.trigger("click");
        var u = " li:not(.divider):visible a",
        a = i.find('[role="menu"]' + u + ', [role="listbox"]' + u);
        if (!a.length) return;
        var f = a.index(t.target);
        t.which == 38 && f > 0 && f--,
        t.which == 40 && f < a.length - 1 && f++,
        ~f || (f = 0),
        a.eq(f).trigger("focus")
    };
    var u = e.fn.dropdown;
    e.fn.dropdown = o,
    e.fn.dropdown.Constructor = r,
    e.fn.dropdown.noConflict = function() {
        return e.fn.dropdown = u,
        this
    },
    e(document).on("click.bs.dropdown.data-api", i).on("click.bs.dropdown.data-api", ".dropdown form", 
    function(e) {
        e.stopPropagation()
    }).on("click.bs.dropdown.data-api", n, r.prototype.toggle).on("keydown.bs.dropdown.data-api", n, r.prototype.keydown).on("keydown.bs.dropdown.data-api", '[role="menu"]', r.prototype.keydown).on("keydown.bs.dropdown.data-api", '[role="listbox"]', r.prototype.keydown)
} (jQuery),
+
function(e) {
    "use strict";
    function n(n, r) {
        return this.each(function() {
            var i = e(this),
            s = i.data("bs.modal"),
            o = e.extend({},
            t.DEFAULTS, i.data(), typeof n == "object" && n);
            o.animate || (t.TRANSITION_DURATION = 0, t.BACKDROP_TRANSITION_DURATION = 0),
            s || i.data("bs.modal", s = new t(this, o)),
            typeof n == "string" ? s[n](r) : o.show && s.show(r)
        })
    }
    var t = function(t, n) {
        this.options = n,
        this.$body = e(document.body),
        this.$element = e(t),
        this.$backdrop = this.isShown = null,
        this.scrollbarWidth = 0,
        this.options.remote && this.$element.find(".modal-content").load(this.options.remote, e.proxy(function() {
            this.$element.trigger("loaded.bs.modal")
        },
        this))
    };
    t.VERSION = "3.3.2",
    t.TRANSITION_DURATION = 300,
    t.BACKDROP_TRANSITION_DURATION = 150,
    t.DEFAULTS = {
        backdrop: !0,
        keyboard: !0,
        show: !0,
        animate: !0,
        verticalAlign: "auto"
    },
    t.prototype.toggle = function(e) {
        return this.isShown ? this.hide() : this.show(e)
    },
    t.prototype.show = function(n) {
        var r = this,
        i = e.Event("show.bs.modal", {
            relatedTarget: n
        });
        this.$element.trigger(i);
        if (this.isShown || i.isDefaultPrevented()) return;
        this.isShown = !0,
        this.checkScrollbar(),
        this.setScrollbar(),
        this.$body.addClass("modal-open"),
        this.escape(),
        this.resize(),
        this.$element.on("click.dismiss.bs.modal", '[data-dismiss="modal"]', e.proxy(this.hide, this)),
        this.backdrop(function() {
            var i = e.support.transition && r.$element.hasClass("fade");
            r.$element.parent().length || r.$element.appendTo(r.$body),
            r.$element.show().scrollTop(0),
            r.options.backdrop && r.adjustBackdrop(),
            r.adjustDialog(),
            i && r.$element[0].offsetWidth,
            r.$element.addClass("in").attr("aria-hidden", !1),
            r.enforceFocus();
            var s = e.Event("shown.bs.modal", {
                relatedTarget: n
            });
            i ? r.$element.find(".modal-dialog").one("bsTransitionEnd", 
            function() {
                r.$element.trigger("focus").trigger(s)
            }).emulateTransitionEnd(t.TRANSITION_DURATION) : r.$element.trigger("focus").trigger(s)
        })
    },
    t.prototype.hide = function(n) {
        n && n.preventDefault(),
        n = e.Event("hide.bs.modal"),
        this.$element.trigger(n);
        if (!this.isShown || n.isDefaultPrevented()) return;
        this.isShown = !1,
        this.escape(),
        this.resize(),
        e(document).off("focusin.bs.modal"),
        this.$element.removeClass("in").attr("aria-hidden", !0).off("click.dismiss.bs.modal"),
        e.support.transition && this.$element.hasClass("fade") ? this.$element.one("bsTransitionEnd", e.proxy(this.hideModal, this)).emulateTransitionEnd(t.TRANSITION_DURATION) : this.hideModal()
    },
    t.prototype.enforceFocus = function() {
        e(document).off("focusin.bs.modal").on("focusin.bs.modal", e.proxy(function(e) {
            this.$element[0] !== e.target && !this.$element.has(e.target).length && this.$element.trigger("focus")
        },
        this))
    },
    t.prototype.escape = function() {
        this.isShown && this.options.keyboard ? this.$element.on("keydown.dismiss.bs.modal", e.proxy(function(e) {
            e.which == 27 && this.hide()
        },
        this)) : this.isShown || this.$element.off("keydown.dismiss.bs.modal")
    },
    t.prototype.resize = function() {
        this.isShown ? e(window).on("resize.bs.modal", e.proxy(this.handleUpdate, this)) : e(window).off("resize.bs.modal")
    },
    t.prototype.hideModal = function() {
        var e = this;
        this.$element.hide(),
        this.backdrop(function() {
            e.$body.removeClass("modal-open"),
            e.resetAdjustments(),
            e.resetScrollbar(),
            e.$element.trigger("hidden.bs.modal")
        })
    },
    t.prototype.removeBackdrop = function() {
        this.$backdrop && this.$backdrop.remove(),
        this.$backdrop = null
    },
    t.prototype.backdrop = function(n) {
        var r = this,
        i = this.$element.hasClass("fade") ? "fade": "";
        if (this.isShown && this.options.backdrop) {
            var s = e.support.transition && i;
            this.$backdrop = e('<div class="modal-backdrop ' + i + '" />').prependTo(this.$element).on("click.dismiss.bs.modal", e.proxy(function(e) {
                if (e.target !== e.currentTarget) return;
                this.options.backdrop == "static" ? this.$element[0].focus.call(this.$element[0]) : this.hide.call(this)
            },
            this)),
            s && this.$backdrop[0].offsetWidth,
            this.$backdrop.addClass("in");
            if (!n) return;
            s ? this.$backdrop.one("bsTransitionEnd", n).emulateTransitionEnd(t.BACKDROP_TRANSITION_DURATION) : n()
        } else if (!this.isShown && this.$backdrop) {
            this.$backdrop.removeClass("in");
            var o = function() {
                r.removeBackdrop(),
                n && n()
            };
            e.support.transition && this.$element.hasClass("fade") ? this.$backdrop.one("bsTransitionEnd", o).emulateTransitionEnd(t.BACKDROP_TRANSITION_DURATION) : o()
        } else n && n()
    },
    t.prototype.handleUpdate = function() {
        this.options.backdrop && this.adjustBackdrop(),
        this.adjustDialog()
    },
    t.prototype.adjustBackdrop = function() {
        this.$backdrop.css("height", 0).css("height", Math.max(this.$element[0].scrollHeight, this.$element[0].clientHeight))
    },
    t.prototype.adjustDialog = function() {
        var e = this,
        t = this.$element[0].scrollHeight > document.documentElement.clientHeight;
        this.$element.css({
            paddingLeft: !this.bodyIsOverflowing && t ? this.scrollbarWidth: "",
            paddingRight: this.bodyIsOverflowing && !t ? this.scrollbarWidth: ""
        }),
        e.options.verticalAlign == "middle" && this.$element.find(".modal-dialog").css({
            "margin-top": function() {
                var t = Math.max((e.$element.height() - e.$element.find(".modal-dialog").height()) / 2, 0);
                return t
            }
        })
    },
    t.prototype.resetAdjustments = function() {
        this.$element.css({
            paddingLeft: "",
            paddingRight: ""
        })
    },
    t.prototype.checkScrollbar = function() {
        this.bodyIsOverflowing = document.body.scrollHeight > document.documentElement.clientHeight,
        this.scrollbarWidth = this.measureScrollbar()
    },
    t.prototype.setScrollbar = function() {
        var e = parseInt(this.$body.css("padding-right") || 0, 10);
        this.bodyIsOverflowing && this.$body.css("padding-right", e + this.scrollbarWidth)
    },
    t.prototype.resetScrollbar = function() {
        this.$body.css("padding-right", "")
    },
    t.prototype.measureScrollbar = function() {
        var e = document.createElement("div");
        e.className = "modal-scrollbar-measure",
        this.$body.append(e);
        var t = e.offsetWidth - e.clientWidth;
        return this.$body[0].removeChild(e),
        t
    };
    var r = e.fn.modal;
    e.fn.modal = n,
    e.fn.modal.Constructor = t,
    e.fn.modal.noConflict = function() {
        return e.fn.modal = r,
        this
    },
    e(document).on("click.bs.modal.data-api", '[data-toggle="modal"]', 
    function(t) {
        var r = e(this),
        i = r.attr("href"),
        s = e(r.attr("data-target") || i && i.replace(/.*(?=#[^\s]+$)/, "")),
        o = s.data("bs.modal") ? "toggle": e.extend({
            remote: !/#/.test(i) && i
        },
        s.data(), r.data());
        r.is("a") && t.preventDefault(),
        s.one("show.bs.modal", 
        function(e) {
            if (e.isDefaultPrevented()) return;
            s.one("hidden.bs.modal", 
            function() {
                r.is(":visible") && r.trigger("focus")
            })
        }),
        n.call(s, o, this)
    })
} (jQuery),
+
function(e) {
    "use strict";
    function n(n) {
        return this.each(function() {
            var r = e(this),
            i = r.data("bs.tooltip"),
            s = typeof n == "object" && n;
            if (!i && n == "destroy") return;
            i || r.data("bs.tooltip", i = new t(this, s)),
            typeof n == "string" && i[n]()
        })
    }
    var t = function(e, t) {
        this.type = this.options = this.enabled = this.timeout = this.hoverState = this.$element = null,
        this.init("tooltip", e, t)
    };
    t.VERSION = "3.3.2",
    t.TRANSITION_DURATION = 150,
    t.DEFAULTS = {
        animation: !0,
        placement: "top",
        selector: !1,
        template: '<div class="tooltip" role="tooltip"><div class="tooltip-arrow"></div><div class="tooltip-inner"></div></div>',
        trigger: "hover focus",
        title: "",
        delay: 0,
        html: !1,
        container: !1,
        viewport: {
            selector: "body",
            padding: 0
        }
    },
    t.prototype.init = function(t, n, r) {
        this.enabled = !0,
        this.type = t,
        this.$element = e(n),
        this.options = this.getOptions(r),
        this.$viewport = this.options.viewport && e(this.options.viewport.selector || this.options.viewport);
        var i = this.options.trigger.split(" ");
        for (var s = i.length; s--;) {
            var o = i[s];
            if (o == "click") this.$element.on("click." + this.type, this.options.selector, e.proxy(this.toggle, this));
            else if (o != "manual") {
                var u = o == "hover" ? "mouseenter": "focusin",
                a = o == "hover" ? "mouseleave": "focusout";
                this.$element.on(u + "." + this.type, this.options.selector, e.proxy(this.enter, this)),
                this.$element.on(a + "." + this.type, this.options.selector, e.proxy(this.leave, this))
            }
        }
        this.options.selector ? this._options = e.extend({},
        this.options, {
            trigger: "manual",
            selector: ""
        }) : this.fixTitle()
    },
    t.prototype.getDefaults = function() {
        return t.DEFAULTS
    },
    t.prototype.getOptions = function(t) {
        return t = e.extend({},
        this.getDefaults(), this.$element.data(), t),
        t.delay && typeof t.delay == "number" && (t.delay = {
            show: t.delay,
            hide: t.delay
        }),
        t
    },
    t.prototype.getDelegateOptions = function() {
        var t = {},
        n = this.getDefaults();
        return this._options && e.each(this._options, 
        function(e, r) {
            n[e] != r && (t[e] = r)
        }),
        t
    },
    t.prototype.enter = function(t) {
        var n = t instanceof this.constructor ? t: e(t.currentTarget).data("bs." + this.type);
        if (n && n.$tip && n.$tip.is(":visible")) {
            n.hoverState = "in";
            return
        }
        n || (n = new this.constructor(t.currentTarget, this.getDelegateOptions()), e(t.currentTarget).data("bs." + this.type, n)),
        clearTimeout(n.timeout),
        n.hoverState = "in";
        if (!n.options.delay || !n.options.delay.show) return n.show();
        n.timeout = setTimeout(function() {
            n.hoverState == "in" && n.show()
        },
        n.options.delay.show)
    },
    t.prototype.leave = function(t) {
        var n = t instanceof this.constructor ? t: e(t.currentTarget).data("bs." + this.type);
        n || (n = new this.constructor(t.currentTarget, this.getDelegateOptions()), e(t.currentTarget).data("bs." + this.type, n)),
        clearTimeout(n.timeout),
        n.hoverState = "out";
        if (!n.options.delay || !n.options.delay.hide) return n.hide();
        n.timeout = setTimeout(function() {
            n.hoverState == "out" && n.hide()
        },
        n.options.delay.hide)
    },
    t.prototype.show = function() {
        var n = e.Event("show.bs." + this.type);
        if (this.hasContent() && this.enabled) {
            this.$element.trigger(n);
            var r = e.contains(this.$element[0].ownerDocument.documentElement, this.$element[0]);
            if (n.isDefaultPrevented() || !r) return;
            var i = this,
            s = this.tip(),
            o = this.getUID(this.type);
            this.setContent(),
            s.attr("id", o),
            this.$element.attr("aria-describedby", o),
            this.options.animation && s.addClass("fade");
            var u = typeof this.options.placement == "function" ? this.options.placement.call(this, s[0], this.$element[0]) : this.options.placement,
            a = /\s?auto?\s?/i,
            f = a.test(u);
            f && (u = u.replace(a, "") || "top"),
            s.detach().css({
                top: 0,
                left: 0,
                display: "block"
            }).addClass(u).data("bs." + this.type, this),
            this.options.container ? s.appendTo(this.options.container) : s.insertAfter(this.$element);
            var l = this.getPosition(),
            c = s[0].offsetWidth,
            h = s[0].offsetHeight;
            if (f) {
                var p = u,
                d = this.options.container ? e(this.options.container) : this.$element.parent(),
                v = this.getPosition(d);
                u = u == "bottom" && l.bottom + h > v.bottom ? "top": u == "top" && l.top - h < v.top ? "bottom": u == "right" && l.right + c > v.width ? "left": u == "left" && l.left - c < v.left ? "right": u,
                s.removeClass(p).addClass(u)
            }
            var m = this.getCalculatedOffset(u, l, c, h);
            this.applyPlacement(m, u);
            var g = function() {
                var e = i.hoverState;
                i.$element.trigger("shown.bs." + i.type),
                i.hoverState = null,
                e == "out" && i.leave(i)
            };
            e.support.transition && this.$tip.hasClass("fade") ? s.one("bsTransitionEnd", g).emulateTransitionEnd(t.TRANSITION_DURATION) : g()
        }
    },
    t.prototype.applyPlacement = function(t, n) {
        var r = this.tip(),
        i = r[0].offsetWidth,
        s = r[0].offsetHeight,
        o = parseInt(r.css("margin-top"), 10),
        u = parseInt(r.css("margin-left"), 10);
        isNaN(o) && (o = 0),
        isNaN(u) && (u = 0),
        t.top = t.top + o,
        t.left = t.left + u,
        e.offset.setOffset(r[0], e.extend({
            using: function(e) {
                r.css({
                    top: Math.round(e.top),
                    left: Math.round(e.left)
                })
            }
        },
        t), 0),
        r.addClass("in");
        var a = r[0].offsetWidth,
        f = r[0].offsetHeight;
        n == "top" && f != s && (t.top = t.top + s - f);
        var l = this.getViewportAdjustedDelta(n, t, a, f);
        l.left ? t.left += l.left: t.top += l.top;
        var c = /top|bottom/.test(n),
        h = c ? l.left * 2 - i + a: l.top * 2 - s + f,
        p = c ? "offsetWidth": "offsetHeight";
        r.offset(t),
        this.replaceArrow(h, r[0][p], c)
    },
    t.prototype.replaceArrow = function(e, t, n) {
        this.arrow().css(n ? "left": "top", 50 * (1 - e / t) + "%").css(n ? "top": "left", "")
    },
    t.prototype.setContent = function() {
        var e = this.tip(),
        t = this.getTitle();
        e.find(".tooltip-inner")[this.options.html ? "html": "text"](t),
        e.removeClass("fade in top bottom left right")
    },
    t.prototype.hide = function(n) {
        function o() {
            r.hoverState != "in" && i.detach(),
            r.$element.removeAttr("aria-describedby").trigger("hidden.bs." + r.type),
            n && n()
        }
        var r = this,
        i = this.tip(),
        s = e.Event("hide.bs." + this.type);
        this.$element.trigger(s);
        if (s.isDefaultPrevented()) return;
        return i.removeClass("in"),
        e.support.transition && this.$tip.hasClass("fade") ? i.one("bsTransitionEnd", o).emulateTransitionEnd(t.TRANSITION_DURATION) : o(),
        this.hoverState = null,
        this
    },
    t.prototype.fixTitle = function() {
        var e = this.$element; (e.attr("title") || typeof e.attr("data-original-title") != "string") && e.attr("data-original-title", e.attr("title") || "").attr("title", "")
    },
    t.prototype.hasContent = function() {
        return this.getTitle()
    },
    t.prototype.getPosition = function(t) {
        t = t || this.$element;
        var n = t[0],
        r = n.tagName == "BODY",
        i = n.getBoundingClientRect();
        i.width == null && (i = e.extend({},
        i, {
            width: i.right - i.left,
            height: i.bottom - i.top
        }));
        var s = r ? {
            top: 0,
            left: 0
        }: t.offset(),
        o = {
            scroll: r ? document.documentElement.scrollTop || document.body.scrollTop: t.scrollTop()
        },
        u = r ? {
            width: e(window).width(),
            height: e(window).height()
        }: null;
        return e.extend({},
        i, o, u, s)
    },
    t.prototype.getCalculatedOffset = function(e, t, n, r) {
        return e == "bottom" ? {
            top: t.top + t.height,
            left: t.left + t.width / 2 - n / 2
        }: e == "top" ? {
            top: t.top - r,
            left: t.left + t.width / 2 - n / 2
        }: e == "left" ? {
            top: t.top + t.height / 2 - r / 2,
            left: t.left - n
        }: {
            top: t.top + t.height / 2 - r / 2,
            left: t.left + t.width
        }
    },
    t.prototype.getViewportAdjustedDelta = function(e, t, n, r) {
        var i = {
            top: 0,
            left: 0
        };
        if (!this.$viewport) return i;
        var s = this.options.viewport && this.options.viewport.padding || 0,
        o = this.getPosition(this.$viewport);
        if (/right|left/.test(e)) {
            var u = t.top - s - o.scroll,
            a = t.top + s - o.scroll + r;
            u < o.top ? i.top = o.top - u: a > o.top + o.height && (i.top = o.top + o.height - a)
        } else {
            var f = t.left - s,
            l = t.left + s + n;
            f < o.left ? i.left = o.left - f: l > o.width && (i.left = o.left + o.width - l)
        }
        return i
    },
    t.prototype.getTitle = function() {
        var e,
        t = this.$element,
        n = this.options;
        return e = t.attr("data-original-title") || (typeof n.title == "function" ? n.title.call(t[0]) : n.title),
        e
    },
    t.prototype.getUID = function(e) {
        do e += ~~ (Math.random() * 1e6);
        while (document.getElementById(e));
        return e
    },
    t.prototype.tip = function() {
        return this.$tip = this.$tip || e(this.options.template)
    },
    t.prototype.arrow = function() {
        return this.$arrow = this.$arrow || this.tip().find(".tooltip-arrow")
    },
    t.prototype.enable = function() {
        this.enabled = !0
    },
    t.prototype.disable = function() {
        this.enabled = !1
    },
    t.prototype.toggleEnabled = function() {
        this.enabled = !this.enabled
    },
    t.prototype.toggle = function(t) {
        var n = this;
        t && (n = e(t.currentTarget).data("bs." + this.type), n || (n = new this.constructor(t.currentTarget, this.getDelegateOptions()), e(t.currentTarget).data("bs." + this.type, n))),
        n.tip().hasClass("in") ? n.leave(n) : n.enter(n)
    },
    t.prototype.destroy = function() {
        var e = this;
        clearTimeout(this.timeout),
        this.hide(function() {
            e.$element.off("." + e.type).removeData("bs." + e.type)
        })
    };
    var r = e.fn.tooltip;
    e.fn.tooltip = n,
    e.fn.tooltip.Constructor = t,
    e.fn.tooltip.noConflict = function() {
        return e.fn.tooltip = r,
        this
    }
} (jQuery),
+
function(e) {
    "use strict";
    function n(n) {
        return this.each(function() {
            var r = e(this),
            i = r.data("bs.popover"),
            s = typeof n == "object" && n;
            if (!i && n == "destroy") return;
            i || r.data("bs.popover", i = new t(this, s)),
            typeof n == "string" && i[n]()
        })
    }
    var t = function(e, t) {
        this.init("popover", e, t)
    };
    if (!e.fn.tooltip) throw new Error("Popover requires tooltip.js");
    t.VERSION = "3.3.2",
    t.DEFAULTS = e.extend({},
    e.fn.tooltip.Constructor.DEFAULTS, {
        placement: "right",
        trigger: "click",
        content: "",
        template: '<div class="popover" role="tooltip"><div class="arrow"></div><h3 class="popover-title"></h3><div class="popover-content"></div></div>'
    }),
    t.prototype = e.extend({},
    e.fn.tooltip.Constructor.prototype),
    t.prototype.constructor = t,
    t.prototype.getDefaults = function() {
        return t.DEFAULTS
    },
    t.prototype.setContent = function() {
        var e = this.tip(),
        t = this.getTitle(),
        n = this.getContent();
        e.find(".popover-title")[this.options.html ? "html": "text"](t),
        e.find(".popover-content").children().detach().end()[this.options.html ? typeof n == "string" ? "html": "append": "text"](n),
        e.removeClass("fade top bottom left right in"),
        e.find(".popover-title").html() || e.find(".popover-title").hide()
    },
    t.prototype.hasContent = function() {
        return this.getTitle() || this.getContent()
    },
    t.prototype.getContent = function() {
        var e = this.$element,
        t = this.options;
        return e.attr("data-content") || (typeof t.content == "function" ? t.content.call(e[0]) : t.content)
    },
    t.prototype.arrow = function() {
        return this.$arrow = this.$arrow || this.tip().find(".arrow")
    },
    t.prototype.tip = function() {
        return this.$tip || (this.$tip = e(this.options.template)),
        this.$tip
    };
    var r = e.fn.popover;
    e.fn.popover = n,
    e.fn.popover.Constructor = t,
    e.fn.popover.noConflict = function() {
        return e.fn.popover = r,
        this
    }
} (jQuery),
+
function(e) {
    "use strict";
    function t(n, r) {
        var i = e.proxy(this.process, this);
        this.$body = e("body"),
        this.$scrollElement = e(n).is("body") ? e(window) : e(n),
        this.options = e.extend({},
        t.DEFAULTS, r),
        this.selector = (this.options.target || "") + " .nav li > a",
        this.offsets = [],
        this.targets = [],
        this.activeTarget = null,
        this.scrollHeight = 0,
        this.$scrollElement.on("scroll.bs.scrollspy", i),
        this.refresh(),
        this.process()
    }
    function n(n) {
        return this.each(function() {
            var r = e(this),
            i = r.data("bs.scrollspy"),
            s = typeof n == "object" && n;
            i || r.data("bs.scrollspy", i = new t(this, s)),
            typeof n == "string" && i[n]()
        })
    }
    t.VERSION = "3.3.2",
    t.DEFAULTS = {
        offset: 10
    },
    t.prototype.getScrollHeight = function() {
        return this.$scrollElement[0].scrollHeight || Math.max(this.$body[0].scrollHeight, document.documentElement.scrollHeight)
    },
    t.prototype.refresh = function() {
        var t = "offset",
        n = 0;
        e.isWindow(this.$scrollElement[0]) || (t = "position", n = this.$scrollElement.scrollTop()),
        this.offsets = [],
        this.targets = [],
        this.scrollHeight = this.getScrollHeight();
        var r = this;
        this.$body.find(this.selector).map(function() {
            var r = e(this),
            i = r.data("target") || r.attr("href"),
            s = /^#./.test(i) && e(i);
            return s && s.length && s.is(":visible") && [[s[t]().top + n, i]] || null
        }).sort(function(e, t) {
            return e[0] - t[0]
        }).each(function() {
            r.offsets.push(this[0]),
            r.targets.push(this[1])
        })
    },
    t.prototype.process = function() {
        var e = this.$scrollElement.scrollTop() + this.options.offset,
        t = this.getScrollHeight(),
        n = this.options.offset + t - this.$scrollElement.height(),
        r = this.offsets,
        i = this.targets,
        s = this.activeTarget,
        o;
        this.scrollHeight != t && this.refresh();
        if (e >= n) return s != (o = i[i.length - 1]) && this.activate(o);
        if (s && e < r[0]) return this.activeTarget = null,
        this.clear();
        for (o = r.length; o--;) s != i[o] && e >= r[o] && (!r[o + 1] || e <= r[o + 1]) && this.activate(i[o])
    },
    t.prototype.activate = function(t) {
        this.activeTarget = t,
        this.clear();
        var n = this.selector + '[data-target="' + t + '"],' + this.selector + '[href="' + t + '"]',
        r = e(n).parents("li").addClass("active");
        r.parent(".dropdown-menu").length && (r = r.closest("li.dropdown").addClass("active")),
        r.trigger("activate.bs.scrollspy")
    },
    t.prototype.clear = function() {
        e(this.selector).parentsUntil(this.options.target, ".active").removeClass("active")
    };
    var r = e.fn.scrollspy;
    e.fn.scrollspy = n,
    e.fn.scrollspy.Constructor = t,
    e.fn.scrollspy.noConflict = function() {
        return e.fn.scrollspy = r,
        this
    },
    e(window).on("load.bs.scrollspy.data-api", 
    function() {
        e('[data-spy="scroll"]').each(function() {
            var t = e(this);
            n.call(t, t.data())
        })
    })
} (jQuery),
+
function(e) {
    "use strict";
    function n(n) {
        return this.each(function() {
            var r = e(this),
            i = r.data("bs.tab");
            i || r.data("bs.tab", i = new t(this)),
            typeof n == "string" && i[n]()
        })
    }
    var t = function(t) {
        this.element = e(t)
    };
    t.VERSION = "3.3.2",
    t.TRANSITION_DURATION = 150,
    t.prototype.show = function() {
        var t = this.element,
        n = t.closest("ul:not(.dropdown-menu)"),
        r = t.data("target");
        r || (r = t.attr("href"), r = r && r.replace(/.*(?=#[^\s]*$)/, ""));
        if (t.parent("li").hasClass("active")) return;
        var i = n.find(".active:last a"),
        s = e.Event("hide.bs.tab", {
            relatedTarget: t[0]
        }),
        o = e.Event("show.bs.tab", {
            relatedTarget: i[0]
        });
        i.trigger(s),
        t.trigger(o);
        if (o.isDefaultPrevented() || s.isDefaultPrevented()) return;
        var u = e(r);
        this.activate(t.closest("li"), n),
        this.activate(u, u.parent(), 
        function() {
            i.trigger({
                type: "hidden.bs.tab",
                relatedTarget: t[0]
            }),
            t.trigger({
                type: "shown.bs.tab",
                relatedTarget: i[0]
            })
        })
    },
    t.prototype.activate = function(n, r, i) {
        function u() {
            s.removeClass("active").find("> .dropdown-menu > .active").removeClass("active").end().find('[data-toggle="tab"]'
            ).attr("aria-expanded", !1),
            n.addClass("active").find('[data-toggle="tab"]').attr("aria-expanded", !0),
            o ? (n[0].offsetWidth, n.addClass("in")) : n.removeClass("fade"),
            n.parent(".dropdown-menu") && n.closest("li.dropdown").addClass("active").end().find('[data-toggle="tab"]').attr("aria-expanded", !0),
            i && i()
        }
        var s = r.find("> .active"),
        o = i && e.support.transition && (s.length && s.hasClass("fade") || !!r.find("> .fade").length);
        s.length && o ? s.one("bsTransitionEnd", u).emulateTransitionEnd(t.TRANSITION_DURATION) : u(),
        s.removeClass("in")
    };
    var r = e.fn.tab;
    e.fn.tab = n,
    e.fn.tab.Constructor = t,
    e.fn.tab.noConflict = function() {
        return e.fn.tab = r,
        this
    };
    var i = function(t) {
        t.preventDefault(),
        n.call(e(this), "show")
    };
    e(document).on("click.bs.tab.data-api", '[data-toggle="tab"]', i).on("click.bs.tab.data-api", '[data-toggle="pill"]', i)
} (jQuery),
+
function(e) {
    "use strict";
    function n(n) {
        return this.each(function() {
            var r = e(this),
            i = r.data("bs.affix"),
            s = typeof n == "object" && n;
            i || r.data("bs.affix", i = new t(this, s)),
            typeof n == "string" && i[n]()
        })
    }
    var t = function(n, r) {
        this.options = e.extend({},
        t.DEFAULTS, r),
        this.$target = e(this.options.target).on("scroll.bs.affix.data-api", e.proxy(this.checkPosition, this)).on("click.bs.affix.data-api", e.proxy(this.checkPositionWithEventLoop, this)),
        this.$element = e(n),
        this.affixed = this.unpin = this.pinnedOffset = null,
        this.checkPosition()
    };
    t.VERSION = "3.3.2",
    t.RESET = "affix affix-top affix-bottom",
    t.DEFAULTS = {
        offset: 0,
        target: window
    },
    t.prototype.getState = function(e, t, n, r) {
        var i = this.$target.scrollTop(),
        s = this.$element.offset(),
        o = this.$target.height();
        if (n != null && this.affixed == "top") return i < n ? "top": !1;
        if (this.affixed == "bottom") return n != null ? i + this.unpin <= s.top ? !1: "bottom": i + o <= e - r ? !1: "bottom";
        var u = this.affixed == null,
        a = u ? i: s.top,
        f = u ? o: t;
        return n != null && i <= n ? "top": r != null && a + f >= e - r ? "bottom": !1
    },
    t.prototype.getPinnedOffset = function() {
        if (this.pinnedOffset) return this.pinnedOffset;
        this.$element.removeClass(t.RESET).addClass("affix");
        var e = this.$target.scrollTop(),
        n = this.$element.offset();
        return this.pinnedOffset = n.top - e
    },
    t.prototype.checkPositionWithEventLoop = function() {
        setTimeout(e.proxy(this.checkPosition, this), 1)
    },
    t.prototype.checkPosition = function() {
        if (!this.$element.is(":visible")) return;
        var n = this.$element.height(),
        r = this.options.offset,
        i = r.top,
        s = r.bottom,
        o = e("body").height();
        typeof r != "object" && (s = i = r),
        typeof i == "function" && (i = r.top(this.$element)),
        typeof s == "function" && (s = r.bottom(this.$element));
        var u = this.getState(o, n, i, s);
        if (this.affixed != u) {
            this.unpin != null && this.$element.css("top", "");
            var a = "affix" + (u ? "-" + u: ""),
            f = e.Event(a + ".bs.affix");
            this.$element.trigger(f);
            if (f.isDefaultPrevented()) return;
            this.affixed = u,
            this.unpin = u == "bottom" ? this.getPinnedOffset() : null,
            this.$element.removeClass(t.RESET).addClass(a).trigger(a.replace("affix", "affixed") + ".bs.affix")
        }
        u == "bottom" && this.$element.offset({
            top: o - n - s
        })
    };
    var r = e.fn.affix;
    e.fn.affix = n,
    e.fn.affix.Constructor = t,
    e.fn.affix.noConflict = function() {
        return e.fn.affix = r,
        this
    },
    e(window).on("load", 
    function() {
        e('[data-spy="affix"]').each(function() {
            var t = e(this),
            r = t.data();
            r.offset = r.offset || {},
            r.offsetBottom != null && (r.offset.bottom = r.offsetBottom),
            r.offsetTop != null && (r.offset.top = r.offsetTop),
            n.call(t, r)
        })
    })
} (jQuery),
function(e) {
    typeof define == "function" && define.amd ? define(["jquery"], e) : typeof exports == "object" ? module.exports = e: e(jQuery)
} (function(e) {
    function a(t) {
        var n = t || window.event,
        o = r.call(arguments, 1),
        a = 0,
        c = 0,
        h = 0,
        p = 0,
        d = 0,
        v = 0;
        t = e.event.fix(n),
        t.type = "mousewheel",
        "detail" in n && (h = n.detail * -1),
        "wheelDelta" in n && (h = n.wheelDelta),
        "wheelDeltaY" in n && (h = n.wheelDeltaY),
        "wheelDeltaX" in n && (c = n.wheelDeltaX * -1),
        "axis" in n && n.axis === n.HORIZONTAL_AXIS && (c = h * -1, h = 0),
        a = h === 0 ? c: h,
        "deltaY" in n && (h = n.deltaY * -1, a = h),
        "deltaX" in n && (c = n.deltaX, h === 0 && (a = c * -1));
        if (h === 0 && c === 0) return;
        if (n.deltaMode === 1) {
            var m = e.data(this, "mousewheel-line-height");
            a *= m,
            h *= m,
            c *= m
        } else if (n.deltaMode === 2) {
            var g = e.data(this, "mousewheel-page-height");
            a *= g,
            h *= g,
            c *= g
        }
        p = Math.max(Math.abs(h), Math.abs(c));
        if (!s || p < s) s = p,
        l(n, p) && (s /= 40);
        l(n, p) && (a /= 40, c /= 40, h /= 40),
        a = Math[a >= 1 ? "floor": "ceil"](a / s),
        c = Math[c >= 1 ? "floor": "ceil"](c / s),
        h = Math[h >= 1 ? "floor": "ceil"](h / s);
        if (u.settings.normalizeOffset && this.getBoundingClientRect) {
            var y = this.getBoundingClientRect();
            d = t.clientX - y.left,
            v = t.clientY - y.top
        }
        return t.deltaX = c,
        t.deltaY = h,
        t.deltaFactor = s,
        t.offsetX = d,
        t.offsetY = v,
        t.deltaMode = 0,
        o.unshift(t, a, c, h),
        i && clearTimeout(i),
        i = setTimeout(f, 200),
        (e.event.dispatch || e.event.handle).apply(this, o)
    }
    function f() {
        s = null
    }
    function l(e, t) {
        return u.settings.adjustOldDeltas && e.type === "mousewheel" && t % 120 === 0
    }
    var t = ["wheel", "mousewheel", "DOMMouseScroll", "MozMousePixelScroll"],
    n = "onwheel" in document || document.documentMode >= 9 ? ["wheel"] : ["mousewheel", "DomMouseScroll", "MozMousePixelScroll"],
    r = Array.prototype.slice,
    i,
    s;
    if (e.event.fixHooks) for (var o = t.length; o;) e.event.fixHooks[t[--o]] = e.event.mouseHooks;
    var u = e.event.special.mousewheel = {
        version: "3.1.12",
        setup: function() {
            if (this.addEventListener) for (var t = n.length; t;) this.addEventListener(n[--t], a, !1);
            else this.onmousewheel = a;
            e.data(this, "mousewheel-line-height", u.getLineHeight(this)),
            e.data(this, "mousewheel-page-height", u.getPageHeight(this))
        },
        teardown: function() {
            if (this.removeEventListener) for (var t = n.length; t;) this.removeEventListener(n[--t], a, !1);
            else this.onmousewheel = null;
            e.removeData(this, "mousewheel-line-height"),
            e.removeData(this, "mousewheel-page-height")
        },
        getLineHeight: function(t) {
            var n = e(t),
            r = n["offsetParent" in e.fn ? "offsetParent": "parent"]();
            return r.length || (r = e("body")),
            parseInt(r.css("fontSize"), 10) || parseInt(n.css("fontSize"), 10) || 16
        },
        getPageHeight: function(t) {
            return e(t).height()
        },
        settings: {
            adjustOldDeltas: !0,
            normalizeOffset: !0
        }
    };
    e.fn.extend({
        mousewheel: function(e) {
            return e ? this.bind("mousewheel", e) : this.trigger("mousewheel")
        },
        unmousewheel: function(e) {
            return this.unbind("mousewheel", e)
        }
    })
}),
window.IX = function() {
    var e = "1.0";
    "defaultView" in document || (document.defaultView = {});
    var t = function(e) {
        return e === undefined || e === null || e === ""
    },
    n = {
        object: Object,
        "function": Function,
        string: String,
        "boolean": Boolean,
        number: Number
    },
    r = function(e) {
        var r = function(r) {
            return ! t(r) && (typeof r == e || r instanceof n[e])
        };
        return r
    },
    i = {
        isEmpty: t,
        isBoolean: r("boolean"),
        isObject: r("object"),
        isString: r("string"),
        isNumber: r("number"),
        isFn: r("function"),
        isArray: function(e) {
            return !! e && e instanceof Array
        },
        isElement: function(e) {
            return e.nodeType === 1
        },
        getClass: function(e) {
            return Object.prototype.toString.call(e).match(/^\[object\s(.*)\]$/)[1].toLowerCase()
        }
    },
    s = {
        versions: function() {
            var e = navigator.userAgent,
            t = navigator.appVersion;
            return {
                trident: e.indexOf("Trident") > -1,
                presto: e.indexOf("Presto") > -1,
                webKit: e.indexOf("AppleWebKit") > -1,
                gecko: e.indexOf("Gecko") > -1 && e.indexOf("KHTML") == -1,
                mobile: !!e.match(/AppleWebKit.*Mobile.*/) || !!e.match(/Windows Phone/) || !!e.match(/Android/) || !!e.match(/MQQBrowser/),
                ios: !!e.match(/\(i[^;]+;( U;)? CPU.+Mac OS X/),
                android: e.indexOf("Android") > -1 || e.indexOf("Linux") > -1,
                iPhone: e.indexOf("iPhone") > -1 || e.indexOf("Mac") > -1,
                iPad: e.indexOf("iPad") > -1,
                webApp: e.indexOf("Safari") == -1
            }
        } (),
        language: (navigator.browserLanguage || navigator.language).toLowerCase()
    },
    o = function(e, t, n, r, i, s) {
        if (e == null || e.length == 0) return r;
        var o = e.length;
        n = n == -1 ? o: n;
        if (t >= n) return r;
        var u = r,
        a = Math.max(0, t),
        f = Math.min(o, n),
        l = o - 1;
        for (var c = 0; c <= l; c += 1) {
            var h = s ? c: l - c;
            h >= a && h < f && h in e && (u = i(u, e[h], h))
        }
        return u
    },
    u = function(e, n) {
        if (t(e)) return;
        var r = e.length;
        for (var i = 0; i < r; i += 1) n(e[i], i)
    },
    a = {
        iterate: u,
        fnIterate: function(e, t) {
            u(e, 
            function(e) {
                t in e && i.isFn(e[t]) && e[t]()
            })
        },
        loop: function(e, t, n) {
            return o(e, 0, -1, t, n, !0)
        },
        loopbreak: function(e, t) {
            try {
                o(e, 0, -1, 0, t, !0)
            } catch(n) {}
        },
        partLoop: function(e, t, n, r, i) {
            return o(e, t, n, r, i, !0)
        },
        loopDsc: function(e, t, n) {
            return o(e, 0, -1, t, n, !1)
        },
        map: function(e, t) {
            return o(e, 0, -1, [], 
            function(e, n, r) {
                return e.push(t(n, r)),
                e
            },
            !0)
        },
        each: function(e, t, n) {
            var r = t,
            i = "",
            s = 0;
            for (i in e) r = n(r, e[i], i, s),
            s += 1;
            return r
        }
    },
    f = {
        cvtToArray: function(e) {
            if (!e) return [];
            if (e.toArray) return e.toArray();
            var t = [],
            n = e.length;
            for (var r = 0; r < n; r++) t.push(e[r]);
            return t
        }
    },
    l = function(e) {
        var t;
        if (i.isArray(e)) {
            t = [];
            for (var n = 0; n < e.length; n++) t[n] = l(e[n]);
            return t
        }
        if (e === null || typeof e != "object" || e instanceof String || e instanceof Number || e instanceof Boolean || e instanceof Date || e instanceof RegExp) return e;
        t = new e.constructor;
        for (var r in e) {
            var s = e[r];
            t[r] = l(s)
        }
        return t
    },
    c = function(e, t) {
        if (t == null || e == null || t == undefined || e == undefined) return t == e;
        for (p in e) {
            if (! (p in t && typeof t[p] != "undefined")) return ! 1;
            if (e[p]) {
                if (typeof t[p] != typeof e[p]) return ! 1;
                switch (typeof e[p]) {
                case "object":
                    if (!c(e[p], t[p])) return ! 1;
                    break;
                case "function":
                    if (typeof t[p] == "undefined" || e[p].toString() != t[p].toString()) return ! 1;
                    break;
                default:
                    if (e[p] != t[p]) return ! 1
                }
            } else if (t[p]) return ! 1
        }
        for (p in t) if (! (p in e) || typeof e[p] == "undefined") return ! 1;
        return ! 0
    },
    h = {
        hasProperty: function(e, t) {
            if (!e) return ! 1;
            try {
                if (t in e) return ! 0
            } catch(n) {}
            var r = t.split("."),
            i = e,
            s = r.length;
            for (var o = 0; o < s; o++) try {
                if (! (i && r[o] in i)) return ! 1;
                i = i[r[o]]
            } catch(u) {
                return ! 1
            }
            return ! 0
        },
        getProperty: function(e, t, n) {
            var r = n != undefined ? n: null;
            if (e == null) return r;
            try {
                if (t in e) return e[t]
            } catch(i) {}
            var s = t.split("."),
            o = e,
            u = s.length;
            for (var a = 0; a < u; a++) try {
                if (! (o && s[a] in o)) return r;
                o = o[s[a]]
            } catch(f) {
                return r
            }
            return o
        },
        setProperty: function(e, t, n) {
            try {
                if (t in e) {
                    e[t] = n;
                    return
                }
            } catch(r) {}
            var i = t.split("."),
            s = e,
            o = i.pop(),
            u = i.length;
            for (var a = 0; a < u; a++) {
                var f = i[a];
                try {
                    if (! (f in s) || !s[f] || typeof s[f] != "object") s[f] = {}
                } catch(l) {
                    s[f] = {}
                }
                s = s[f]
            }
            s[o] = n
        },
        getPropertyAsFunction: function(e, t) {
            var n = IX.getProperty(e, t);
            return IX.isFn(n) ? n: IX.emptyFn
        },
        clone: l,
        deepCompare: c
    },
    d = function(e, t) {
        var n = e.split(".");
        n[0] == "window" && n.shift();
        var r = window,
        i = !0,
        s = 0,
        o = n.length;
        while (s < o && i) {
            var u = n[s];
            i = t(u, r),
            i && (r = r[u]),
            s++
        }
        return i
    },
    v = {
        ns: function(e) {
            d(e, 
            function(e, t) {
                return e in t || (t[e] = {}),
                !0
            })
        },
        nsExisted: function(e) {
            return d(e, 
            function(e, t) {
                return t && e in t
            })
        },
        setNS: function(e, t) {
            var n = e.split(".");
            n[0] == "window" && n.shift();
            if (n.length == 0 || IX.isEmpty(n[0])) return;
            var r = window,
            i = n.length;
            for (var s = 0; s < i - 1; s++) {
                var o = n[s];
                o in r || (r[o] = {}),
                r = r[o]
            }
            r[n[i - 1]] = t
        },
        getNS: function(e) {
            return d(e, 
            function(e, t) {
                return e in t ? t[e] : !1
            })
        }
    },
    m = function(e, t) {
        if (e == null || e == undefined) e = {};
        for (var n in t) e[n] = t[n];
        return e
    },
    g = {
        extend: m,
        inherit: function() {
            return a.loop(f.cvtToArray(arguments), {},
            function(e, t) {
                return m(e, t)
            })
        }
    },
    y = function() {
        return (new Date).getTime()
    },
    b = navigator.userAgent.toLowerCase(),
    w = function(e) {
        return b.indexOf(e) != -1
    },
    E = "addEventListener" in window,
    S = function(e) {
        var t = function(t) {
            var n = t || window.event;
            return "target" in n || (n.target = n.srcElement),
            e(n)
        };
        return t
    },
    x = function(e, t, n, r) {
        if (!e) return;
        n && (e._EVENTNAMES || (e._EVENTNAMES = {})),
        IX.iterate(["click", "dblclick", "focus", "blur", "keyup", "keydown", "mouseover", "mouseout", "resize", "scroll", "mousedown", "mousemove", "mouseup", "touchstart", "touchend", "touchmove"], 
        function(i) {
            if (i in t) {
                if (n) {
                    if (r && e._EVENTNAMES[i]) return;
                    e._EVENTNAMES[i] = !0
                }
                IX[n ? "attachEvent": "detachEvent"](e, i, S(t[i]))
            }
        })
    },
    T = {
        isMSIE7: document.all && w("msie 7.0"),
        isSafari: window.openDatabase && w("safari"),
        isMSIE: w("msie") && !w("opera"),
        isOpera: w("opera"),
        isChrome: w("chrome"),
        isFirefox: w("firefox") && !w("webkit"),
        isYunfisClient: w("Yunfis") || !w("yunfis"),
        isMSWin: w("windows"),
        getTimeInMS: y,
        getComputedStyle: "getComputedStyle" in document.defaultView ? 
        function(e) {
            return document.defaultView.getComputedStyle(e)
        }: function(e) {
            return e.currentStyle || e.style
        },
        getUrlParam: function(e, t) {
            var n = window.location.search.substring(1).split("&"),
            r = n.length;
            for (var i = 0; i < r; i += 1) {
                var s = n[i];
                if (s.indexOf(e + "=") == 0) return s.substring(e.length + 1)
            }
            return t
        },
        listen: function(e, t, n, r) {
            var i = E ? {
                fname: e == "detach" ? "removeEventListener": "addEventListener",
                etype: n
            }: {
                fname: e + "Event",
                etype: "on" + n
            };
            t[i.fname](i.etype, r, !1)
        },
        attachEvent: E ? 
        function(e, t, n) {
            e.addEventListener(t, n, !1)
        }: function(e, t, n) {
            e.attachEvent("on" + t, n)
        },
        detachEvent: E ? 
        function(e, t, n) {
            e.removeEventListener(t, n, !1)
        }: function(e, t, n) {
            e.detachEvent("on" + t, n)
        },
        bind: function(e, t) {
            x(e, t, !0)
        },
        bindOnce: function(e, t) {
            x(e, t, !0, !0)
        },
        on: function(e, t, n) {
            e["on" + t] = n
        }
    },
    N = {
        toAnchor: function(e) {
            window.location.hash = "#" + e
        }
    },
    C = function() {},
    k = function(e) {
        return e
    },
    L = function(e, t, n, r) {
        function a() {
            e() ? t() : s != null && y() - u > s ? o() : setTimeout(a, i)
        }
        var i = Math.max(20, n || 100),
        s = $XP(r, "maxAge", null),
        o = $XF(r, "expire"),
        u = null;
        isNaN(s) && (s = null),
        s != null && (u = y()),
        a()
    },
    A = {
        emptyFn: C,
        selfFn: k,
        safeExec: function(e) {
            e()
        },
        execute: function(e, t) {
            var n = v.getNS(e);
            i.isFn(n) && n.apply(null, t)
        },
        checkReady: L,
        tryFn: function(e) {
            return i.isFn(e) ? e() : C()
        }
    },
    O = {
        decodeTXT: function(e) {
            return e ? (e + "").replaceAll("&nbsp;", " ").replaceAll("&lt;", "<").replaceAll("&gt;", ">").replaceAll("&amp;", "&") : ""
        },
        encodeTXT: function(e) {
            return e ? (e + "").replaceAll("&", "&amp;").replaceAll("<", "&lt;").replaceAll(">", "&gt;").replaceAll(" ", "&nbsp;") : ""
        },
        createDiv: function(e, t) {
            var n = document.createElement("div");
            return IX.isEmpty(t) || (n.className = t),
            n.id = e,
            document.body.appendChild(n),
            n
        },
        get: function(e) {
            return IX.isEmpty(e) ? null: i.isString(e) || i.isNumber(e) ? document.getElementById(e) : "ownerDocument" in e ? e: null
        }
    },
    M = {
        err: function(e) {
            alert(e)
        }
    },
    _ = {
        inRange: function(e, t, n) {
            return (e - t) * (e - n) <= 0
        }
    },
    D = 0,
    P = {
        id: function() {
            return D++,
            "ix" + D
        }
    },
    H = function(e, t) {
        return Math.abs(e.maxx + e.minx - t.minx - t.maxx) <= t.maxx - t.minx + e.maxx - e.minx && Math.abs(e.maxy + e.miny - t.miny - t.maxy) <= t.maxy - t.miny + e.maxy - e.miny
    };
    return g.inherit(i, f, h, v, a, g, T, N, A, O, M, _, P, {
        version: e,
        ifRectIntersect: H,
        browser: s
    })
} (),
$X = IX.get,
$XA = IX.cvtToArray,
$XE = IX.err,
$XP = IX.getProperty,
$XF = IX.getPropertyAsFunction,
IX.Test = function() {
    var e = function(e, t, n) {
        var r = 0;
        return IX.each(e, "", 
        function(e, i, s) {
            try {
                if (t(i, s)) return r += 1,
                n(e, s, i) + (r % 5 == 4 ? "\r\n": "")
            } catch(o) {
                alert(o)
            }
            return e
        })
    },
    t = function(t, n, r) {
        if (r != "fun" && IX.isString(t)) return "String:" + t.toString();
        var i = r == "fun";
        return (i ? "Funcs:": "Props:") + e(t, 
        function(e) {
            return ! i && !IX.isFn(e) || i && IX.isFn(e)
        },
        function(e, t, n) {
            return [e, t, i ? "": [':"', ("" + n).trunc(60), '" '].join(""), ", "].join("")
        })
    };
    return {
        listProp: function(e, n) {
            return t(e, n, "")
        },
        listFun: function(e, n) {
            return t(e, n, "fun")
        }
    }
} (),
window.log = "IXDEBUG" in window ? 
function(e) {
    console && console.log(e)
}: IX.emptyFn,
IX.Array = function() {
    var e = function(e) {
        return IX.isFn(e) ? e: function(e, t) {
            return IX.isObject(e) && "equal" in e && IX.isFn(e.equal) ? e.equal(t) : e == t
        }
    },
    t = function(e, t, n) {
        if (t == null || t.length == 0) return ! 1;
        for (var r = t.length - 1; r >= 0; r--) if (n(e, t[r])) return ! 0;
        return ! 1
    },
    n = function(e, t, r) {
        var i = e || [],
        s = t || [],
        o = 0,
        u = 0,
        a = 0,
        f = [],
        l = i.length,
        c = s.length;
        for (o = 0; o < c; o++) for (u = 0; u < l; u++) if (r(s[o], i[u])) {
            for (a = 0; a < o; a++) f.push(s.shift());
            s.shift();
            for (a = 0; a <= u; a++) f.push(i.shift());
            return f.concat(n(i, s, r))
        }
        return f.concat(i, s)
    },
    r = null;
    return r = {
        init: function(e, t) {
            var n = [];
            for (var r = 0; r < e; r++) n[r] = IX.clone(t);
            return n
        },
        isFound: function(n, r, i) {
            return t(n, r, e(i))
        },
        toSet: function(t, n) {
            var i = e(n);
            return IX.loop(t, [], 
            function(e, t) {
                return r.isFound(t, e, i) || e.push(t),
                e
            })
        },
        sort: function(e, t) {
            var n = IX.map(e, 
            function(e) {
                return e
            });
            return n.sort(t)
        },
        sortArray: function(e, t) {
            var n;
            t = t || 
            function(e, t) {
                return e > t
            };
            for (var r = 0, i; r < e.length; r++) for (i = e.length - 1; i > r; i--) t(e[r], e[i]) && (n = e[r], e[r] = e[i], e[i] = n)
        },
        isSameSet: function(n, i, s) {
            var o = r.toSet(n),
            u = r.toSet(i);
            if (o == null && u == null) return ! 0;
            if (o == null || u == null || o.length != u.length) return ! 1;
            if (o.length == 0 && u.length == 0) return ! 0;
            var a = e(s);
            for (var f = o.length - 1; f >= 0; f--) if (!t(o[f], u, a)) return ! 1;
            return ! 0
        },
        compact: function(e, t) {
            var n = IX.isFn(t) ? t: function(e) {
                return e
            };
            return IX.loop(e, [], 
            function(e, t) {
                return n(t) && e.push(t),
                e
            })
        },
        remove: function(t, n, r) {
            var i = e(r);
            return IX.loop(t, [], 
            function(e, t) {
                return i(n, t) || e.push(t),
                e
            })
        },
        pushx: function(e, t) {
            return e.push(t),
            e
        },
        flat: function(e) {
            return IX.isArray(e) ? IX.loop(e, [], 
            function(e, t) {
                return e.concat(r.flat(t))
            }) : [e]
        },
        indexOf: function(e, t) {
            if (!e || e.length == 0) return - 1;
            var n = e.length;
            for (var r = 0; r < n; r++) if (t(e[r])) return r;
            return - 1
        },
        splice: function(e, t, n, r) {
            var i = isNaN(n) ? 1: n,
            s = e.length;
            if (t < 0 || t > s || i < 0 || t + i > s) return [];
            var o = r ? r: [];
            return [].concat(e.slice(0, t), o, e.slice(t + i))
        },
        merge: function(t, r, i) {
            return n(t, r, e(i))
        }
    },
    r
} (),
IX.IState = function() {
    return {
        toggle: function(e, t) {
            return t == undefined ? !e: t
        }
    }
} (),
IX.IManager = function() {
    var e = {};
    return {
        isRegistered: function(t) {
            return t in e && e[t]
        },
        register: function(t, n) {
            e[t] = n
        },
        unregister: function(t) {
            e[t] = null
        },
        get: function(t) {
            return t in e ? e[t] : null
        },
        clear: function() {
            e = {}
        },
        destroy: function() {
            delete e
        }
    }
},
IX.IList = function() {
    var e = [],
    t = IX.Array,
    n = function(n) {
        return n ? t.indexOf(e, 
        function(e) {
            return e == n
        }) : -1
    },
    r = function(t) {
        t >= 0 && t < e.length && (e = e.slice(0, t).concat(e.slice(t + 1)))
    },
    i = function(t) {
        if (!e || e.length == 0) e = [t];
        else {
            var i = n(t);
            r(i),
            e.push(t)
        }
    };
    return {
        isEmpty: function() {
            return e.length == 0
        },
        isLast: function(t) {
            return e.length > 0 && t == e[e.length - 1]
        },
        getList: function() {
            return e
        },
        getSize: function() {
            return e.length
        },
        indexOf: n,
        remove: r,
        tryRemove: function(e) {
            r(n(e))
        },
        append: i,
        tryAdd: function(t) { ! e || e.length == 0 ? e = [t] : n(t) < 0 && e.push(t)
        },
        insertBefore: function(t, s) {
            var o = n(s);
            if (o == -1) {
                i(t);
                return
            }
            var u = n(t);
            if (u != -1 && o - u == 1) return;
            u >= 0 && (r(u), o = n(s)),
            e = e.slice(0, o).concat([t], e.slice(u))
        },
        clear: function() {
            e = []
        },
        destroy: function() {
            delete e
        }
    }
},
IX.I1ToNManager = function(e) {
    var t = IX.isFn(e) ? e: function(e, t) {
        return e == t
    },
    n = new IX.IManager,
    r = function(e) {
        var t = n.get(e);
        return t && t.length > 0
    },
    i = function(e, n) {
        return IX.Array.indexOf(e, 
        function(e) {
            return t(e, n)
        })
    };
    return IX.inherit(n, {
        hasValue: r,
        put: function(e, t) {
            if (!r(e)) {
                n.register(e, [t]);
                return
            }
            var s = n.get(e);
            i(s, t) == -1 && n.register(e, s.concat(t))
        },
        remove: function(e, t) {
            var r = n.get(e),
            s = i(r, t);
            s >= 0 && n.register(e, IX.Array.splice(r, s))
        }
    })
},
IX.IListManager = function() {
    var e = new IX.IManager,
    t = new IX.IList,
    n = function(n, r) {
        e.register(n, r);
        var i = t.indexOf(n);
        r ? i == -1 && t.append(n) : t.remove(i)
    },
    r = function(t) {
        return IX.map(t, 
        function(t) {
            return e.get(t)
        })
    };
    return IX.inherit(e, {
        register: n,
        unregister: function(e) {
            n(e)
        },
        isEmpty: function() {
            return t.isEmpty()
        },
        getSize: function() {
            return t.getSize()
        },
        hasKey: e.isRegistered,
        isLastKey: function(e) {
            return t.isLast(e)
        },
        getKeys: function() {
            return t.getList()
        },
        getByKeys: function(e) {
            return r(e)
        },
        getAll: function() {
            return r(t.getList())
        },
        iterate: function(n) {
            IX.iterate(t.getList(), 
            function(t) {
                n(e.get(t))
            })
        },
        getFirst: function() {
            var n = t.getList();
            if (!n || n.length == 0) return null;
            var r = n.length;
            for (var i = 0; i < r; i++) {
                var s = e.get(n[i]);
                if (s) return s
            }
            return null
        },
        append: t.append,
        insertBefore: t.insertBefore,
        remove: function(e) {
            n(e)
        },
        clear: function() {
            e.clear(),
            t.clear()
        },
        destroy: function() {
            e.destroy(),
            delete e,
            t.destroy(),
            delete t
        }
    })
},
IX.DataStore = function(e) {
    var t = $XP(e, "items", []);
    if (t.length > 0 && $XP(e, "type", "json") != "json") {
        var n = $XP(e, "fields", []);
        t = IX.map(t, 
        function(e) {
            return IX.loop(n, {},
            function(t, n, r) {
                return t[n] = IX.isArray(e) ? e[r] : e[n],
                t
            })
        })
    }
    return IX.map(t, 
    function(e) {
        var t = $XP(e, "id");
        return IX.isEmpty(t) && (e.id = IX.id()),
        e
    })
},
IX.Date = function() {
    var e = !1,
    t = ["FullYear", "Month", "Date"],
    n = ["Hours", "Minutes", "Seconds"],
    r = "-",
    i = ":",
    s = function(e, t) {
        return IX.isEmpty(e) ? "": (e = e.split(t, 3), IX.map(t == r ? [4, 2, 2] : [2, 2, 2], 
        function(t, n) {
            var r = e.length > n ? e[n] : "";
            return ("0".multi(t) + r).substr(r.length, t)
        }).join(t))
    },
    o = function(t, n, r) {
        var i = "get" + (e ? "UTC": ""),
        o = IX.map(n, 
        function(e) {
            return t[i + e]() * 1 + (e == "Month" ? 1: 0)
        }).join(r);
        return s(o, r)
    },
    u = function(e, s) {
        return s == "Date" ? o(e, t, r) : s == "Time" ? o(e, n, i) : o(e, t, r) + " " + o(e, n, i)
    },
    a = function(e, t, n) {
        return e || isNaN(t) || t.indexOf(".") >= 0 || n == 0 && t.length != 4 || n > 0 && t.length > 2
    },
    f = function(e, t, n) {
        return e || isNaN(t) || t.indexOf(".") >= 0 || t.length > 2
    },
    l = function(e, t) {
        var n = t == "Date",
        s = e.split(n ? r: i, 3);
        if (s.length != 3 || IX.loop(s, !1, n ? a: f)) return ! 1;
        if (n) {
            var o = s[1] * 1,
            u = s[2] * 1;
            return ! (o <= 0 || o > 12 || u <= 0 || u > 31)
        }
        var l = s[0] * 1,
        o = s[1] * 1,
        c = s[2] * 1;
        return ! (l < 0 || l > 23 || o < 0 || o > 59 || c < 0 || c > 59)
    };
    return {
        setDS: function(e) {
            r = e
        },
        setTS: function(e) {
            i = e
        },
        setUTC: function(t) {
            e = t
        },
        getDS: function() {
            return r
        },
        getTS: function() {
            return i
        },
        isUTC: function() {
            return e
        },
        format: u,
        formatDate: function(e) {
            return u(e, "Date")
        },
        formatTime: function(e) {
            return u(e, "Time")
        },
        formatStr: function(e) {
            return e = (e + " ").split(" "),
            s(e[0], r) + " " + s(e[1], i)
        },
        formatDateStr: function(e) {
            return s(e, r)
        },
        formatTimeStr: function(e) {
            return s(e, i)
        },
        getDateText: function(e, t) {
            var n = t - e;
            return n < 10 ? "\u521a\u624d": n < 60 ? Math.round(n) + "\u79d2\u949f\u524d": (n /= 60, n < 60 ? Math.round(n) + "\u5206\u949f\u524d": (n /= 60, n < 24 ? Math.round(n) + "\u5c0f\u65f6\u524d": (n /= 24, n < 7 ? Math.round(n) + "\u5929\u524d": (n /= 7, n < 4.33 ? Math.round(n) + "\u5468\u524d": (n /= 4.33, n < 12 ? Math.round(n) + "\u4e2a\u6708\u524d": Math.round(n / 12) + "\u5e74\u524d")))))
        },
        isValid: function(e, t) {
            var n = e.split(" ");
            return t == "Date" || t == "Time" ? n.length == 1 && l(n[0], t) : n.length == 2 && l(n[0], "Date") && l(n[1], "Time")
        },
        getDateByFormat: function(e, t, n) {
            n = n == undefined ? !0: n;
            try {
                if (e == null || e === "") return "";
                var r = typeof e == "number" ? new Date(e) : typeof e == "string" ? new Date((e + "").replace(/-/g, "/")) : e,
                i = t || "yyyy-MM-dd HH:mm:ss";
                i = i.replace("yyyy", r.getFullYear());
                var s = r.getMonth() + 1,
                o = r.getDate(),
                u = r.getHours(),
                a = r.getMinutes(),
                f = r.getSeconds();
                return i = i.replace("MM", s > 9 ? s: (n ? "0": "") + s),
                i = i.replace("dd", o > 9 ? o: (n ? "0": "") + o),
                i = i.replace("HH", u > 9 ? u: (n ? "0": "") + u),
                i = i.replace("mm", a > 9 ? a: "0" + a),
                i = i.replace("ss", f > 9 ? f: "0" + f),
                i
            } catch(l) {
                return e
            }
        },
        getTimeTickInSec: function(e) {
            var t = IX.Date.getDateByFormat(e, "yyyy/MM/dd HH:mm:ss");
            return parseInt((new Date(t)).getTime() / 1e3)
        },
        getDateDiff: function(e, t) {
            var n = t - e,
            r = Math.floor(n / 864e5),
            i = n % 864e5,
            s = Math.floor(i / 36e5),
            o = i % 36e5,
            u = Math.floor(o / 6e4),
            a = o % 6e4,
            f = Math.floor(a / 1e3);
            return {
                days: r,
                hours: s,
                minutes: u,
                seconds: f
            }
        }
    }
} (),
IX.Net = function() {
    var e = document.getElementsByTagName("head")[0],
    t = function() {
        return "XMLHttpRequest" in window ? new XMLHttpRequest: "ActiveXObject" in window ? new ActiveXObject("Microsoft.XMLHTTP") : null
    },
    n = function(e, n) {
        var r = t();
        if (!r) {
            $XE("unsupport AJAX. Failed");
            return
        }
        r.onreadystatechange = function() {
            r.readyState == 4 && (r.status == 200 ? IX.isFn(n) && n(r.responseText) : $XE("There was an error: (" + r.status + ") " + r.statusText))
        },
        r.open("GET", e, !0),
        r.send("")
    },
    r = function(t, n) {
        var r = document.createElement("script");
        r.type = "text/javascript",
        r.src = t,
        IX.isFn(n) && (r.readyState ? r.onreadystatechange = function() {
            log("STATE: [" + t + "]:" + this.readyState);
            if (r.readyState == "complete" || r.readyState == "loaded") r.onreadystatechange = null,
            n()
        }: r.onload = n),
        e.appendChild(r)
    },
    i = function(e, t) {
        var n = IX.isFn(t) ? t: IX.emptyFn;
        if (!e || e.length == 0) return n();
        var i = e.length,
        s = 0,
        o = function() {
            r(e[s], 
            function() {
                return s += 1,
                s < i ? o() : n()
            })
        };
        o()
    },
    s = function(t) {
        var n = document.createElement("link");
        n.type = "text/css",
        n.rel = "stylesheet",
        n.href = t,
        n.media = "screen",
        e.appendChild(n)
    };
    return {
        loadFile: n,
        loadCss: s,
        loadJsFiles: function(e, t, n) {
            i(e, t)
        },
        tryFn: function(e, t, n) {
            var r = function() {
                IX.execute(e, t),
                IX.tryFn(n.afterFn)
            };
            if (!IX.nsExisted(e)) {
                if (!n) return;
                var o = n;
                IX.tryFn(o.beforeFn),
                IX.iterate(o.cssFiles, s);
                var u = o.delay || 100;
                i(o.jsFiles, 
                function() {
                    setTimeout(r, u)
                })
            } else r()
        }
    }
} (),
IX.win = function() {
    var e = {},
    t = {},
    n = IX.I1ToNManager(),
    r = 0,
    i = function() {
        return "f_" + r++
    },
    s = "addEventListener" in window,
    o = s ? 
    function(e, t, n) {
        e.addEventListener(t, n, !1)
    }: function(e, t, n) {
        e.attachEvent("on" + t, n)
    },
    u = s ? 
    function(e, t, n) {
        e.removeEventListener(t, n, !1)
    }: function(e, t, n) {
        e.detachEvent("on" + t, n)
    },
    a = function(t, r) {
        IX.iterate(n.get(t), 
        function(t) {
            IX.isFn(e[t]) && e[t](r)
        })
    },
    f = function(r, s) {
        var u = i();
        return s._key || (s._key = u, e[u] = s, n.put(r, u)),
        r in t ? u: (t[r] = function(e) {
            var t = e || window.event;
            return "target" in t || (t.target = t.srcElement),
            a(r, t)
        },
        o(window, r, t[r]), u)
    },
    l = function(r, i) {
        e[i] = null,
        n.remove(r, i);
        if (n.hasValue(r)) return;
        u(window, r, t[r]),
        t[r] = null
    },
    c = function(e, t) {
        var n = t ? f: l,
        r = IX.loop(["click", "resize", "scroll", "mousedown", "mouseover", "mouseout"], {},
        function(t, r) {
            return r in e && (t[r] = n(r, e[r])),
            t
        });
        if (t) return r
    };
    return {
        bind: function(e) {
            return c(e, !0)
        },
        unbind: function(e) {
            c(e, !1)
        },
        scrollTo: function(e, t) {
            window.scrollTo(e, t),
            a("scroll", null)
        }
    }
} (),
$Xw = IX.win,
function() {
    function e(e, t) {
        return t
    }
    function t(e, t) {
        IX.isFn(t) && t(e)
    }
    function n(e, t, n) {
        var r = $XP(e, t);
        return IX.isFn(r) ? r: n
    }
    function r(r) {
        return {
            channel: $XP(r, "channel", r.name + IX.UUID.generate()),
            type: $XP(r, "type", "POST"),
            dataType: $XP(r, "dataType", "form"),
            onsuccess: n(r, "onsuccess", t),
            preAjax: n(r, "preAjax", e),
            postAjax: $XF(r, "postAjax"),
            onfail: n(r, "onfail", t)
        }
    }
    function i(e, t) {
        var n = $XP(e, "url");
        if (IX.isEmpty(n)) return null;
        var i = t ? r(e) : {};
        return i.url = n,
        i.urlType = $XP(e, "urlType", "base") + "Url",
        i
    }
    function s(e, t) {
        return IX.loop(e, {},
        function(e, n) {
            var r = $XP(n, "name");
            if (IX.isEmpty(r)) return e;
            var s = i(n, t);
            return s && (e[r] = s),
            e
        })
    }
    function o(e, t) {
        var n = s(e),
        r = function(e, r) {
            return t.genUrl(n[e], r)
        };
        return r
    }
    function u(e) {
        var t = "ajaxChannel_" + e;
        return $X(t) ? !1: (IX.createDiv(t, "ajax-channel"), !0)
    }
    function a(e) {
        var t = $X("ajaxChannel_" + e);
        t && t.parentNode.removeChild(t)
    }
    function f(e, t, n, r) {
        var i = s(e, !0),
        o = function(e, s, o, f) {
            var l = i[e];
            if (!l) return;
            var c = s && s._channel_ ? s._channel_: l.channel;
            $XP(s, "_t") || (s = IX.inherit(s, {
                _t: ""
            }));
            if (!u(c)) {
                l.onfail({
                    retCode: 0,
                    err: "channel in using:" + c
                },
                f, s);
                return
            }
            var h = IX.isFn(o) ? o: IX.emptyFn,
            p = l.dataType == "json" ? "application/json": "application/x-www-form-urlencoded",
            d = l.preAjax(e, s);
            d = l.dataType == "json" ? JSON.stringify(d) : d,
            n({
                url: r.genUrl(l, s),
                type: l.type,
                contentType: p,
                data: d,
                _action: {
                    type: t,
                    name: e
                },
                success: function(n) {
                    a(c),
                    l.onsuccess(n, h, s),
                    Entos.EventRoute && Entos.EventRoute.fire(t + "_" + e, {
                        requestParams: s,
                        data: n
                    })
                },
                fail: function(e) {
                    a(c),
                    l.onfail(e, f, s)
                },
                error: function(e) {
                    a(c),
                    l.onfail(e, f, s)
                }
            }),
            l.postAjax(e, s, h)
        };
        return o
    }
    function l() {
        var e = {},
        t = function(t, n) {
            if (!t) return "";
            var r = t.url,
            i = IX.isFn(r) ? r(n) : r.replaceByParams(n),
            s = t.urlType in e ? e[t.urlType] : e.baseUrl;
            return (s || "") + i
        };
        return {
            init: function(t) {
                e = IX.inherit(e, t)
            },
            genUrl: t
        }
    }
    function c(e) {
        var t = null,
        n = new l,
        r = function(r) {
            e && IX.isFn(r.ajaxFn) && (t = r.ajaxFn),
            n.init(r)
        };
        return IX.inherit({
            init: r,
            reset: r,
            createRouter: function(e) {
                return new o(e, n)
            }
        },
        e ? {
            createCaller: function(e, r) {
                return new f(e, r, 
                function(e) {
                    IX.isFn(t) && t(e)
                },
                n)
            }
        }: {})
    }
    IX.urlEngine = new c,
    IX.ajaxEngine = new c(!0)
} (),
IX.Xml = function() {
    return {
        parser: function(e) {
            e = IX.isString(e) ? e: "";
            var t = null;
            return "DOMParser" in window ? t = (new DOMParser).parseFromString(e, "text/xml") : "ActiveXObject" in window ? (t = new ActiveXObject("Microsoft.XMLDOM"), t.async = "false", t.loadXML(e)) : $XE("this browser can't support XML parser."),
            t
        },
        getXmlString: function(e) {
            return ! e == null ? "": IX.nsExisted("document.implementation.createDocument") ? (new XMLSerializer).serializeToString(e) : "ActiveXObject" in window ? e.xml: ($XE("this browser can't support XML parser."), "")
        },
        duplicate: function(e) {
            return this.parser(this.getXmlString(e))
        }
    }
} (),
IX.Dom = function() {
    var e = function(e, t, n, r) {
        if (!e) return r(null);
        var i = "firstChild" in e ? e[t == "first" ? "firstChild": "nextSibling"] : null;
        while (i != null && !n(i)) i = i.nextSibling;
        return r(i)
    },
    t = function(t, n, r) {
        return IX.isString(n) ? e(t, r, 
        function(e) {
            return e.nodeName.toLowerCase() == n
        },
        function(e) {
            return e
        }) : null
    },
    n = IX.isMSIE ? 
    function(e) {
        return e ? e.innerText: ""
    }: function(e) {
        return e ? e.textContent: ""
    },
    r = function(t) {
        return t ? e(t, "first", 
        function(e) {
            return e.nodeType == 4
        },
        function(e) {
            return e ? e.nodeValue: ""
        }) : ""
    },
    i = function(e, n) {
        return t(e, n, "first")
    },
    s = function(e, t, n) {
        var r = IX.loop(n, [], 
        function(e, t) {
            return e.concat(" ", t[0], '="', t[1], '"')
        }),
        i = [].concat("<", e, r, ">", t, "</", e, ">");
        return i.join("")
    },
    o = function(e, t, n) {
        return s(e, ["<![CDATA[", t, "]]>"].join(""), n)
    },
    u = function(e, t) {
        if (!e) return "";
        var n = e.getAttribute(t);
        return IX.isEmpty(n) ? "": n
    },
    a = function(e, t, n) {
        if (!e) return;
        n ? e.setAttribute(t, n) : e.removeAttribute(t)
    };
    return {
        first: i,
        next: function(e, n) {
            return t(e, n, "next")
        },
        cdata: function(e, t) {
            return r(i(e, t))
        },
        text: function(e, t) {
            return n(i(e, t))
        },
        attr: u,
        setAttr: a,
        dataAttr: function(e, t) {
            return u(e, "data-" + t)
        },
        setDataAttr: function(e, t, n) {
            a(e, "data-" + t, n)
        },
        remove: function(e) {
            e && e.parentNode && e.parentNode.removeChild(e)
        },
        isAncestor: function(e, t) {
            var n = e;
            while (n) {
                if (n == t) return ! 0;
                var r = n.nodeName.toLowerCase();
                n = r == "body" ? null: n.parentNode
            }
            return ! 1
        },
        ancestor: function(e, t) {
            if (!e) return null;
            var n = e;
            while (n) {
                var r = n.nodeName.toLowerCase();
                if (r == t) break;
                n = r == "body" ? null: n.parentNode
            }
            return n
        },
        is: function(e, t) {
            return e.nodeName.toLowerCase() == t
        },
        inTag: s,
        inPureTag: o
    }
} (),
$XD = IX.Dom,
IX.HtmlDocument = function() {
    var e = function(e, t) {
        return e != null && "className" in e && IX.Array.isFound(t, (e.className + "").split(" "))
    },
    t = function(e, t) {
        if (!e) return;
        var n = IX.Array.remove(e.className.split(" "), t);
        e.className = n.join(" ")
    },
    n = function(e, t) {
        if (!e) return;
        var n = IX.Array.toSet(e.className.split(" ").concat(t));
        e.className = n.join(" ")
    },
    r = function(t, n) {
        if (!t) return null;
        var r = t.nextSibling;
        while (r) {
            if (e(r, n)) return r;
            r = r.nextSibling
        }
        return r
    },
    i = function(e, t) {
        var n = null,
        r = IX.get(e);
        t = t != "float" ? t: document.defaultView ? "float": "styleFloat";
        if (t == "opacity") if (r.filters) if (r.filters.length > 0) try {
            n = r.filters["DXImageTransform.Microsoft.Alpha"].opacity / 100
        } catch(i) {
            try {
                n = r.filters("alpha").opacity
            } catch(s) {}
        } else n = "1";
        else n = r.style.opacity;
        else {
            n = r.style[t] || r.style[t.camelize()];
            if (!n) if (document.defaultView && document.defaultView.getComputedStyle) {
                var o = document.defaultView.getComputedStyle(r, null);
                n = o ? o.getPropertyValue(t) : null
            } else r.currentStyle && (n = r.currentStyle[t.camelize()]);
            n == "auto" && IX.Array.indexOf(["width", "height"], 
            function(e) {
                return t == e
            }) > -1 && r.style.display != "none" && (n = r["offset" + t.capitalize()] + "px")
        }
        return n == "auto" ? null: n
    };
    return {
        getStyle: i,
        hasClass: e,
        removeClass: t,
        addClass: n,
        toggleClass: function(r, i) {
            if (!r) return;
            e(r, i) ? t(r, i) : n(r, i)
        },
        next: r,
        first: function(t, n) {
            if (!t) return null;
            var i = t.firstChild;
            return e(i, n) ? i: r(i, n)
        },
        isAncestor: function(e, t) {
            if (!e) return ! 1;
            var n = e;
            while (n != null) {
                if (n == t) return ! 0;
                n = n.parentNode;
                if (n && n.nodeName.toLowerCase() == "body") break
            }
            return ! 1
        },
        ancestor: function(t, n) {
            if (!t) return null;
            var r = t;
            while (r != null && !e(r, n)) r = r.parentNode,
            r && r.nodeName.toLowerCase() == "body" && (r = null);
            return r
        },
        getWindowScreen: function() {
            var e = IX.isFirefox ? document.documentElement: document.body,
            t = window,
            n = "scrollX" in t ? t.scrollX: e.scrollLeft,
            r = "scrollX" in t ? t.scrollY: e.scrollTop;
            return {
                scroll: [n, r, e.scrollWidth, e.scrollHeight],
                size: [e.clientWidth, e.clientHeight]
            }
        },
        getScroll: function(e) {
            if (e && e.nodeType != 9) return {
                scrollTop: e.scrollTop,
                scrollLeft: e.scrollLeft
            };
            var t = e ? e.defaultView || e.parentWindow: window;
            return {
                scrollTop: t.pageYOffset || t.document.documentElement.scrollTop || t.document.body.scrollTop || 0,
                scrollLeft: t.pageXOffset || t.document.documentElement.scrollLeft || t.document.body.scrollLeft || 0
            }
        },
        getZIndex: function(e) {
            var t = null,
            n = null;
            while (e && e.tagName.toLowerCase() != "body") {
                t = IX.getComputedStyle(e);
                if (t.zIndex != "auto") return t.zIndex - 0;
                e = e.offsetParent
            }
            return 0
        },
        rect: function(e, t) {
            IX.iterate(["left", "top", "width", "height"], 
            function(n, r) {
                t[r] != null && (e.style[n] = t[r] + "px")
            })
        },
        getWindowScrollTop: function() {
            return window.pageYOffset || document.documentElement.scrollTop || document.body.scrollTop || 0
        },
        getPosition: function(e, t) {
            var n = e.getBoundingClientRect(),
            r = document.documentElement || document.body;
            return [n.left + (t ? 0: window.scrollX || r.scrollLeft), n.top + (t ? 0: window.scrollY || r.scrollTop), e.offsetWidth, e.offsetHeight]
        }
    }
} (),
$XH = IX.HtmlDocument,
IX.Cookie = function() {
    var e = function(e) {
        if (!e) return [];
        var t = [];
        if (e.expires && (typeof e.expires == "number" || e.expires.toUTCString)) {
            var n;
            typeof e.expires == "number" ? (n = new Date, n.setTime(n.getTime() + e.expires * 24 * 60 * 60 * 1e3)) : n = e.expires,
            t.push("; expires=" + n.toUTCString())
        }
        return "path" in e && t.push("; path=" + e.path),
        "domain" in e && t.push("; domain=" + e.domain),
        "secure" in e && t.push("; secure=" + e.secure),
        t.push(";HttpOnly"),
        t
    },
    t = function(t, n, r) {
        var i = [t, "=", encodeURIComponent(n)].concat(e(r));
        document.cookie = i.join("")
    };
    return {
        get: function(e) {
            if (IX.isEmpty(document.cookie)) return "";
            var t = document.cookie.split(";");
            for (var n = 0; n < t.length; n++) {
                var r = t[n].trim();
                if (r.substring(0, e.length + 1) == e + "=") return decodeURIComponent(r.substring(e.length + 1))
            }
            return ""
        },
        set: t,
        remove: function(e) {
            t(e, "", {
                expires: -1
            })
        }
    }
} (),
IX.Task = function(e, t, n) {
    function f() {
        if (!s) return;
        e(o),
        o++;
        if (u > 0 && o >= u) return;
        var n = a();
        i = setTimeout(f, r + 2 * t - n),
        r = n
    }
    var r = -1,
    i = null,
    s = !1,
    o = 0,
    u = isNaN(n) ? -1: n,
    a = IX.getTimeInMS;
    return {
        start: function() {
            r = a(),
            s = !0,
            o = 0,
            i = setTimeout(f, t)
        },
        stop: function() {
            s = !1,
            clearTimeout(i),
            i = null,
            r = -1
        }
    }
},
function() {
    var e = new RegExp("(?:<tpl.*?>)|(?:</tpl>)", "img"),
    t = /([#\{])([\u4E00-\u9FA5\w\.-]+)[#\}]/g,
    n = /['"]/,
    r = function(e, t) {
        var n = [],
        r = e.match(t),
        i = r ? r.length: 0;
        for (var s = 0; s < i; s++) {
            var o = r[s],
            u = e.indexOf(o);
            if (u == -1) continue;
            n.push(e.substring(0, u)),
            e = e.substring(u + o.length)
        }
        return n.push(e),
        {
            separate: n,
            arr: r
        }
    },
    i = function(r) {
        var i = {},
        s = function(e, t) {
            i[e] = {
                name: e,
                tpl: [t]
            }
        },
        o = function(e, t) {
            i[e].tpl.push(t)
        },
        u = function(e) {
            var n = i[e],
            r = n.tpl.join("");
            n.tpl = r,
            n.list = IX.Array.toSet(r.match(t)).sort()
        },
        a = function(e, t, n) {
            var r = e[0] + "." + t;
            return o(e[0], "#" + t + "#"),
            e.unshift(r),
            s(r, n),
            e
        },
        f = function(e, t) {
            return u(e[0]),
            e.shift(),
            o(e[0], t),
            e
        },
        l = r.regSplit(e),
        c = l.arr,
        h = l.separate;
        s("root", h[0]);
        var p = IX.loop(c, ["root"], 
        function(e, t, r) {
            if (t == "</tpl>") return f(e, h[r + 1]);
            var i = t.split(n);
            return a(e, i[1], h[r + 1])
        });
        return u("root"),
        p.length == 1 && p[0] == "root" ? i: null
    },
    s = {
        render: function() {
            return ""
        },
        renderData: function() {
            return ""

        },
        destroy: function() {},
        getTpl: function() {
            return ""
        }
    };
    IX.ITemplate = function(e) {
        var t = $XP(e, "tpl", []);
        t = [].concat(t).join("");
        if (IX.isEmpty(t)) return s;
        var n = i(t);
        if (!n) return alert("unformated Tpl: " + t),
        s;
        var r = $XP(e, "tplDataFn");
        IX.isFn(r) || (r = function() {
            return null
        });
        var o = function(e, t) {
            if (!IX.hasProperty(e, t)) return null;
            var n = $XP(e, t);
            return IX.isEmpty(n) ? "": n
        },
        u = function(e, t) {
            var r = n[e];
            if (!r) return alert("can't find templete by name: " + e),
            "";
            var i = r.tpl,
            s = IX.loop(r.list, [], 
            function(n, r) {
                var i = r.charAt(0),
                s = r.substring(1, r.length - 1);
                if (i == "{") {
                    var a = o(t, s);
                    a != null && n.push([r, a])
                } else if (i == "#") {
                    var f = IX.map($XP(t, s, []), 
                    function(t, n) {
                        var r = IX.inherit(t, {
                            idx: n
                        });
                        return u(e + "." + s, r)
                    }).join("");
                    n.push([r, f])
                }
                return n
            });
            return i.loopReplace(s)
        },
        a = function(e, t) {
            var n = "root";
            return IX.isEmpty(e) || (n = e.indexOf("root") == 0 ? e: "root." + e),
            u(n, t ? t: r(n)).replace(/\[(\{|\})\]/g, "$1")
        };
        return IX.inherit({
            render: function(e) {
                return a(e)
            },
            renderData: function(e, t) {
                return a(e, t)
            },
            destroy: function() {
                n.destroy(),
                n = null
            },
            getTpl: function(e) {
                if (!e) return t;
                var r = function(t) {
                    var i = n["root." + t];
                    if (!i) return "";
                    var s = t.split("."),
                    o = i.tpl,
                    u;
                    if (!i.list || i.list.length == 0) return t == e ? o: "<tpl id = '" + s[s.length - 1] + "'>" + o + "</tpl>";
                    for (var a = 0; a < i.list.length; a++) u = i.list[a].replace(/#/g, ""),
                    o = o.replace(new RegExp("#" + u + "#", "img"), r(t + "." + u));
                    return o
                };
                return r(e)
            }
        })
    };
    var o = function(e, t) {
        var n = [],
        r = /[^\u0020-\u007A]/g,
        i = e.length,
        s = (e.match(/[\u0020-\u007A]/g) || []).length,
        o = e.substring(0, t);
        if ((o.match(r) || []).length) {
            var u = 0;
            for (var a = 0; a < t; a++) {
                var f = e[a];
                if (f === undefined || u >= t) {
                    a < t - 1 && a < i && n.push("..");
                    break
                }
                u += f.match(r) ? 2: 1,
                n.push(f)
            }
        } else n.push(o);
        return {
            reString: n.join(""),
            reLength: i > t ? t: i,
            stringLength: (i - s) * 2 + s
        }
    },
    u = /\w+:\/\/[\w.]+[^\s\"\'\<\>\{\}]*/g,
    a = /^1[3|5][0-9]\d{4,8}$/,
    f = /^[_a-zA-Z0-9.]+[\-_a-zA-Z0-9.]*@(?:[_a-zA-Z0-9]+\.)+[a-zA-Z0-9]{2,4}$/,
    l = new RegExp("(?:<script.*?>)((\n|\r|.)*?)(?:</script>)", "img"),
    c = new RegExp("(?:<form.*?>)|(?:</form>)", "img"),
    h = /(^\s*)|\r/g,
    p = /{[^{}]*}/g;
    IX.extend(String.prototype, {
        camelize: function() {
            return this.replace(/\-(\w)/ig, 
            function(e, t) {
                return t.toUpperCase()
            })
        },
        capitalize: function() {
            return this.charAt(0).toUpperCase() + _str.substring(1).toLowerCase()
        },
        replaceAll: function(e, t) {
            return this.replace(new RegExp(e, "gm"), t)
        },
        loopReplace: function(e) {
            return IX.loop(e, this, 
            function(e, t) {
                return e.replaceAll(t[0], t[1])
            })
        },
        trim: function() {
            var e = this.replace(h, ""),
            t = e.length - 1,
            n = /\s/;
            while (n.test(e.charAt(t))) t--;
            return e.substring(0, t + 1)
        },
        trimLeft: function() {
            return this.replace(/(^\s*)/g, "")
        },
        trimRight: function() {
            return this.replace(/(\s*$)/g, "")
        },
        stripTags: function() {
            return this.replace(/<\/?[^>]+>/gi, "")
        },
        stripScripts: function() {
            return this.replace(l, "")
        },
        stripFormTag: function() {
            return this.replace(c, "")
        },
        strip: function() {
            return this.replace(/^\s+/, "").replace(/\s+$/, "")
        },
        substrByLength: function(e) {
            return o(this.toString(), e)
        },
        isSpaces: function() {
            return this.replace(/(\n)|(\r)|(\t)/g, "").strip().length == 0
        },
        isPassword: function() {
            return this.length > 5 && this.length < 21
        },
        isEmail: function() {
            return ! IX.isEmpty(this) && f.exec(this)
        },
        isPhone: function() {
            return ! IX.isEmpty(this) && a.exec(this)
        },
        trunc: function(e) {
            return this.length > e ? this.substring(0, e - 3) + "...": this
        },
        tail: function(e) {
            return this.length > e ? this.substring(this.length - e) : this
        },
        dehtml: function() {
            return this.loopReplace([["&", "&amp;"], ["<", "&lt;"], ['"', "&quot;"]])
        },
        enhtml: function() {
            return this.loopReplace([["&lt;", "<"], ["&quot;", '"'], ["&amp;", "&"]])
        },
        multi: function(e) {
            return IX.Array.init(e, this).join("")
        },
        pickUrls: function() {
            return this.match(u)
        },
        replaceUrls: function(e, t) {
            return this.replace(e || u, t || 
            function(e) {
                return '<a href="' + e + '" target="_blank">' + e + "</a>"
            })
        },
        regSplit: function(e) {
            return r(this, e)
        },
        pick4Replace: function() {
            return this.match(p)
        },
        replaceByParams: function(e) {
            var t = IX.Array.compact(this.match(p));
            return IX.loop(t, this, 
            function(t, n) {
                var r = n.slice(1, -1);
                return IX.isEmpty(r) ? t: t.replaceAll(n, $XP(e, r, ""))
            })
        },
        inPureTag: function(e, t) {
            return IX.Dom.inPureTag(e, this, t)
        },
        inTag: function(e, t) {
            return IX.Dom.inTag(e, this, t)
        },
        toSafe: function() {
            return this.replace(/\$/g, "&#36;")
        },
        matchTags: function() {
            return this.match(/#(.+?)#/g) || []
        }
    }),
    Function.prototype.bind = function() {
        var e = this,
        t = $XA(arguments),
        n = t.shift();
        return function() {
            return e.apply(n, t.concat($XA(arguments)))
        }
    }
} (),
IX.UUID = function() {
    var e = "0123456789ABCDEF";
    return {
        generate: function() {
            var t = new Array,
            n = 0;
            for (n = 0; n < 36; n++) t[n] = Math.floor(Math.random() * 16);
            t[14] = 4,
            t[19] = t[19] & 3 | 8;
            for (n = 0; n < 36; n++) t[n] = e[t[n]];
            return t[8] = t[13] = t[18] = t[23] = "",
            t.join("")
        }
    }
} (),
IX.ns("IX.Util"),
IX.Util.Image = function() {
    var e = function(e, t, n, r, i) {
        var s = document.createElement("canvas");
        s.width = t,
        s.height = n;
        var o = s.getContext("2d");
        o.drawImage(e, (t - r) / 2, (n - i) / 2, r, i);
        var u = s.toDataURL("image/png");
        return delete s,
        u
    },
    t = function(e, t, n, r) {
        var i = e / n,
        s = t / r;
        return i >= 1 && s >= 1 ? [n, r] : (i = Math.min(i, s), [n * i, r * i])
    },
    n = function(n, r) {
        if (!n) return null;
        var i = new Image;
        i.src = n.src;
        var s = t($XP(r, "width", i.width), $XP(r, "height", i.height), i.width, i.height);
        if (s[0] * s[1] == 0) return null;
        var o = e(i, s[0], s[1], s[0], s[1]);
        return delete i,
        {
            url: n.src,
            w: s[0],
            h: s[1],
            data: o
        }
    },
    r = function(n, r, i) {
        if (!n) return;
        var s = new Image;
        s.src = r.data;
        var o = i ? n: s,
        u = t(o.width, o.height, s.width, s.height),
        a = e(s, o.width, o.height, u[0], u[1]);
        delete s,
        n.src = a
    };
    return {
        getData: n,
        setData: r
    }
} (),
IX.Util.Date = function(e) {
    var t = new Date(e * 1e3),
    n = function(e) {
        var t = "get" + (IX.Date.isUTC() ? "UTC": "");
        return IX.map(["FullYear", "Month", "Date", "Hours", "Minutes", "Day"], 
        function(n) {
            var r = e[t + n]() - (n == "Month" ? -1: 0);
            if (n != "Hours" && n != "Minutes") return r;
            var i = "00" + r;
            return i.substring(i.length - 2)
        })
    },
    r = function(e, t) {
        var n = "" + e,
        r = t || 2;
        return ("0".multi(r) + n).substr(n.length, r)
    },
    i = n(t);
    return {
        toText: function() {
            return IX.Date.format(t)
        },
        toWeek: function() {
            return i[5]
        },
        toDate: function(e) {
            var t = n(new Date);
            return e = e || t[0] > i[0],
            [e ? i[0] : "", e ? "\u5e74": "", i[1], "\u6708", i[2], "\u65e5"].join("")
        },
        toTime: function() {
            return [i[3], i[4]].join(":")
        },
        toShort: function() {
            var e = IX.Date.getDS(),
            t = IX.Date.getTS(),
            s = n(new Date),
            o = new Array,
            u = !1;
            i[0] != s[0] && (u = !0, o.push(r(i[0], 4)), o.push(e));
            if (u || i[1] != s[1] || i[2] != s[2]) o.push(r(i[1])),
            o.push(e),
            o.push(r(i[2])),
            o.push(" ");
            return o.push(r(i[3])),
            o.push(t),
            o.push(r(i[4])),
            o.join("")
        },
        toInterval: function(t) {
            var s = t ? new Date(t * 1e3) : new Date,
            o = s.getTime() / 1e3 - e;
            if (o >= 0) {
                if (o < 10) return "\u521a\u624d";
                if (o < 60) return Math.round(o) + "\u79d2\u4e4b\u524d";
                if (o < 3600) return Math.round(o / 60) + "\u5206\u949f\u524d"
            }
            var u = "/",
            a = ":",
            f = n(s),
            l = new Array,
            c = !1;
            i[0] != f[0] && (c = !0, l.push(r(i[0], 4)), l.push(u)),
            c || i[1] != f[1] || i[2] != f[2] ? (l.push(r(i[1])), l.push(u), l.push(r(i[2])), l.push(" ")) : l.push("\u4eca\u5929");
            if (i[3] != "00" || i[4] != "00") l.push(r(i[3])),
            l.push(a),
            l.push(r(i[4]));
            return l.join("")
        },
        toSimpleInterval: function() {
            return IX.Date.getDateText(e, IX.getTimeInMS() / 1e3)
        }
    }
},
IX.Util.Event = {
    target: function(e) {
        return e.target || e.srcElement
    },
    stopPropagation: function(e) {
        e && e.stopPropagation ? e.stopPropagation() : window.event.cancelBubble = !0
    },
    preventDefault: function(e) {
        return e && e.preventDefault ? e.preventDefault() : window.event.returnValue = !1,
        !1
    },
    stop: function(e) {
        IX.Util.Event.preventDefault(e),
        IX.Util.Event.stopPropagation(e)
    }
};
var getIXScriptEl = function() {
    if ("scripts" in document) {
        var e = document.scripts;
        for (var t = 0; t < e.length; t++) if (e[t].src.indexOf("ixutils.js") >= 0) return e[t]
    }
    var n = $XD.first(document.documentElement, "head"),
    r = $XD.first(n, "script");
    while (r) {
        if (r.src.indexOf("ixutils.js") >= 0) break;
        r = $XD.next(r, "script")
    }
    return r
}; (function() {
    var e = getIXScriptEl(),
    t = e ? e.src: "";
    IX.SELF_PATH = t,
    IX.SCRIPT_ROOT = t.substring(0, t.indexOf("lib/ixutils.js"))
})(),
function() {
    var e = "http://down.360safe.com/jia/360camera_android_2.7.0.1.apk",
    //t = ['<div id="roll_top" class="roll_top"></div>', '<div class="top-opacity" style="opacity:.8;"></div>', '<div class="top-wrap" id="top_wrap">', '<div class="top">', '<div class="menu">', '<a href="main.html">\u9996\u9875</a>', '<a href="param.html">\u4ea7\u54c1</a>', '<a href="app.html">\u8f6f\u4ef6</a>', '<div href="#" id="qrcode" class="soft">', '<div class="qrcode">', '<div class="qrbg"></div>', '<div class="qrc">', '<div class="left">', '<img class="img" src="http://p0.qhimg.com/t011b2313a1d298cea6.png" />', "</div>", '<div class="right">', '<div class="title" id="qr1">\u626b\u63cf\u4e8c\u7ef4\u7801\u4e0b\u8f7dAPP</div>', '<div class="text">\u652f\u6301iOS7.0\u53ca\u4ee5\u4e0a\u7248\u672c</div>', '<div class="text">Android4.0\u53ca\u4ee5\u4e0a\u7248\u672c</div>', "<a href = '" + e + "'>Android\u5ba2\u6237\u7aef\u4e0b\u8f7d\u5230\u672c\u5730</a>", "</div>", "</div>", "</div>", "APP\u4e0b\u8f7d</div>", '<a href="product.html">\u4ea7\u54c1\u53c2\u6570</a>', '<a href="question.html">\u5e38\u89c1\u95ee\u9898</a>', '<a href="http://bbs.360safe.com/forum-2145-1.html">\u8bba\u575b</a>', "</div>", "<h3>360\u667a\u80fd\u6444\u50cf\u673a</h3>", "</div>", "</div>"].join(""),
    t = '';
    n = ['<div class="footer-wrap1">', '<div class="anchors">', '<div class="chor-wrap">', '<a href="main.html" class="anchor">\u9996\u9875<i class="icon"></i></a>', "</div>", '<div class="chor-wrap">', '<a href="param.html" class="anchor">\u4ea7\u54c1<i class="icon"></i></a>', "</div>", '<div class="chor-wrap">', '<a href="app.html" class="anchor">\u8f6f\u4ef6<i class="icon"></i></a>', "</div>", '<div class="chor-wrap">', '<a href="product.html" class="anchor">\u4ea7\u54c1\u53c2\u6570<i class="icon"></i></a>', "</div>", '<div class="chor-wrap">', '<a href="question.html" class="anchor">\u5e38\u89c1\u95ee\u9898<i class="icon"></i></a>', "</div>", '<div class="chor-wrap last">', '<a href="http://bbs.360safe.com/forum-2145-1.html" class="anchor">\u8bba\u575b<i class="icon"></i></a>', "</div>", "</div>", "</div>", '<div class="footer-wrap2">', '<div class="right">', '<div class="blank"></div>', '<div class="link-wrap">', '<div class="links first">', '<div class="title">\u5173\u6ce8\u6211\u4eec</div>', '<div class="link"><a href="http://weibo.com/360jia" target="_blank">\u65b0\u6d6a\u5fae\u535a</a></div>', '<div class="link"><a href="javascript:(void);" target="_blank">\u5b98\u65b9\u5fae\u4fe1<div class="weixin"></div></a></div>', "</div>", '<div class="links">', '<div class="title">\u5e2e\u52a9\u4e2d\u5fc3</div>', '<div class="link"><a href="http://bbs.360safe.com/forum-2145-1.html" target="_blank">\u5b98\u65b9\u8bba\u575b</a></div>', '<div class="link"><a href="question.html" target="_blank">\u5e38\u89c1\u95ee\u9898</a></div>', "</div>", '<div class="links">', '<div class="title">\u76f8\u5173\u7f51\u7ad9</div>', '<div class="link"><a href="http://baby.360.cn" target="_blank">360\u513f\u7ae5\u536b\u58eb</a></div>', '<div class="link"><a href="http://luyou.360.cn" target="_blank">360\u5b89\u5168\u8def\u7531</a></div>', "</div>", "</div>", "</div>", '<div class="left">', '<div class="tel pic-tel"></div>', '<div class="copyright">Copyright \u00a92005-2015 360.cn All Rights Reserved. 360\u5b89\u5168\u4e2d\u5fc3</div>', "</div>", "</div>"].join(""),
    r = new IX.ITemplate({
        tpl: ["<div class = 'login-template'>", "<h3>360\u667a\u80fd\u6444\u50cf\u673a</h3>", "<fieldset>", "<legend>\u4f7f\u7528360\u8d26\u53f7\u767b\u9646</legend>", "<input placeholder='360\u8d26\u53f7' class = 'login-user' type = 'text' />", "<input placeholder='\u5bc6\u7801' class = 'login-pwd' type = 'password' />", "<a class = 'ok'>\u767b\u5f55</a>", "<div class = 'exts'>", "<a class = 'forgetpwd'>\u5fd8\u8bb0\u5bc6\u7801&gt;&gt;</a>", "<span>\u8fd8\u6ca1\u6709360\u8d26\u53f7\uff1f</span>", "<a class = 'regist'>\u70b9\u51fb\u6ce8\u518c&gt;&gt;</a>", "</div>", "</fieldset>", "</div>"]
    }),
    i = function(e) {},
    s = function() {
        $("#qr1").click(function() {
            return window.open(e, "newwindow"),
            !1
        }),
        $("a.login").click(function() {
            var e = new ZBase.UI.Dialog({
                html: r.renderData("", {}),
                title: ""
            });
            e.show(),
            e.$.find("a.ok").click(function() {
                var t = e.find("input.login-user").val().trim(),
                n = e.find("input.login-pwd").val();
                if (t.length == 0 || n.length == 0) return;
                $.ajax({
                    url: "",
                    data: {
                        userName: t,
                        password: n
                    },
                    success: function(t) {
                        e.remove(),
                        i(t)
                    }
                })
            })
        })
    },
    o = function(e) {
        var r = IX.inherit({
            footerContainer: document.body,
            headerContainer: document.body
        },
        e),
        i = $(r.footerContainer),
        o = $(r.headerContainer);
        i.append(n),
        o.prepend(t),
        $("a[href='" + Global.mode.replace("_ie", "") + ".html']").addClass("hot"),
        s()
    };
    IX.ns("Static.Layout"),
    Static.Layout.init = o
} (),
function() {
    var e = {
        versions: function() {
            var e = navigator.userAgent,
            t = navigator.appVersion;
            return {
                trident: e.indexOf("Trident") > -1,
                presto: e.indexOf("Presto") > -1,
                webKit: e.indexOf("AppleWebKit") > -1,
                gecko: e.indexOf("Gecko") > -1 && e.indexOf("KHTML") == -1,
                mobile: !!e.match(/AppleWebKit.*Mobile.*/) || !!e.match(/Windows Phone/) || !!e.match(/Android/) || !!e.match(/MQQBrowser/),
                ios: !!e.match(/\(i[^;]+;( U;)? CPU.+Mac OS X/),
                android: e.indexOf("Android") > -1 || e.indexOf("Linux") > -1,
                iPhone: e.indexOf("iPhone") > -1 || e.indexOf("Mac") > -1,
                iPad: e.indexOf("iPad") > -1,
                webApp: e.indexOf("Safari") == -1
            }
        } (),
        language: (navigator.browserLanguage || navigator.language).toLowerCase()
    };
    if (e.versions.mobile && Global.wapSite != "self") {
        window.location.href = "/wap/" + Global.mode + ".html";
        return
    }
    var t = function() {
        var t = navigator.userAgent.toLocaleLowerCase().indexOf("msie") !== -1,
        n = t && !+[1],
        r = document.documentMode,
        i,
        s,
        o,
        u,
        a,
        f,
        l;
        r ? (i = r === 5, s = r === 6, o = r === 7, u = r === 8, a = r === 9, f = r === 10, l = r === 11) : (i = n && (!document.compatMode || document.compatMode === "BackCompat"), s = n && !i && !XMLHttpRequest, o = n && !s && !document.documentMode, u = n && document.documentMode, a = !n && 
        function() {
            "use strict";
            return !! this
        } (), f = t && !!document.attachEvent && 
        function() {
            "use strict";
            return ! this
        } (), l = t && !document.attachEvent);
        var c = i || s || o || u || a || t && document.compatMode !== "CSS1Compat";
        return {
            isQuirks: document.compatMode !== "CSS1Compat",
            isIE: t,
            isIE5: i,
            isIE6: s,
            isIE7: o,
            isIE8: u,
            isIE9: a,
            isIE10: f,
            isIE11: l,
            isLtIE9: c
        }
    } (),
    n = function() {
        var n = Global.mode; ! Global.noLayout && !e.versions.mobile && Static.Layout.init(),
        Static[n] && Static[n].init(t, e.versions.mobile),
        window.monitor && monitor.setProject("360_jia_web").getTrack().getClickAndKeydown()
    };
    $(function() {
        n(t)
    })
} (),
function() {
    var e = new IX.ITemplate({
        tpl: ['<div id="nav" class="nav {clz}">', '<tpl id="items">', '<a href="#section{num}" class="discwrap {first}" _index = "{num}">', '<i class="disc {hot}"></i>', '<span class="disc-info disc-info{num}">{desc}</span>', "</a>", "</tpl>", "</div>"]
    }),
    t = function(t) {
        var n = IX.inherit({
            count: 1,
            items: [],
            container: $(document.body),
            begin: 1,
            onClick: function(e, t) {},
            onChanged: function() {}
        },
        t),
        r,
        i,
        s,
        o,
        u = function(e) {
            if (e >= o) return;
            var t = i.find(".hot").parent(),
            r = i.find("a[_index='" + e + "']");
            return t.find("i").removeClass("hot"),
            r.find("i").addClass("hot"),
            n.onChanged(e),
            Number(t.attr("_index"))
        },
        a = function(e, t) {
            if (e >= o) return;
            var r = u(e);
            n.onClick.apply(null, [r, Number(e), t])
        },
        f = function() {
            i.find("a").click(function() {
                a(Number(this.getAttribute("_index")))
            })
        },
        l = function() {
            var t = [],
            u = "";
            s = n.begin;
            if (n.items && n.items.length > 0) {
                o = n.items.length + s,
                u = "show-desc";
                for (var a = 0, f, l = s; a < n.items.length; a++) f = n.items[a],
                t.push({
                    num: l,
                    desc: f.desc,
                    first: l == n.begin ? "first": "",
                    hot: l == n.begin ? "hot": ""
                }),
                l++
            } else {
                o = n.count + n.begin;
                for (var a = s; a < o; a++) t.push({
                    num: a,
                    desc: "",
                    first: a == n.begin ? "first": "",
                    hot: a == n.begin ? "hot": ""
                })
            }
            i = $(e.renderData("", {
                clz: u,
                items: t
            })),
            r.append(i)
        },
        c = function() {
            r = n.container,
            l(),
            f()
        },
        h = {
            remove: function() {
                i.remove()
            },
            jumpTo: a,
            selected: u,
            changeClassType: function(e) {
                e == 1 ? i.addClass("gray") : i.removeClass("gray")
            }
        };
        return c(),
        h
    };
    IX.ns("Static.ScreenNav"),
    Static.ScreenNav = t
} (),
function() {
    var e = new IX.ITemplate({
        tpl: ['<div class="text2">\u6bcf\u5468\u4e09\u4e0a\u534811:00&nbsp;\u51c6\u65f6\u5f00\u653e\u8d2d\u4e70</div>', "<div class = 'beforebuy'>", "<div class = 'times'><span>\u8ddd\u4e0b\u8f6e\u8d2d\u4e70\u8fd8\u6709\uff1a</span></div>", "<a class = 'bt'>\u5373\u5c06\u5f00\u59cb</a>", "</div>", "<div class = 'inbuy'>", "<div class = 'price'>149<span>\u5143</span></div>", "<a href='http://www.qikoo.com/shop/item?item_id=54aa09e158d4a60425000031' class='bt'>\u7acb\u5373\u8d2d\u4e70</a>", "</div>"]
    }),
    t = new IX.ITemplate({
        tpl: ["<div class = 'inbuy'>", "<div class = 'price'>149<span>\u5143</span></div>", "<a href='http://item.m.jd.com/ware/view.action?wareId=1224596' target = '_blank' class='bt'>\u7acb\u5373\u9884\u7ea6</a>", "<a href='http://www.qikoo.com/shop/camerabuy' class='ft'>F\u7801\u8d2d\u4e70\u901a\u9053</a>", "</div>", "<div class = 'beforebuy'>", "<div class = 'times'><span>\u8ddd\u4e0b\u8f6e\u8d2d\u4e70\u8fd8\u6709\uff1a</span></div>", "</div>", '<div class="text2">\u6bcf\u5468\u4e09\u4e0a\u534811:00&nbsp;\u51c6\u65f6\u5f00\u653e\u8d2d\u4e70</div>']
    }),
    n = new IX.ITemplate({
        tpl: ["<p class = 'saletime'>", "<span>{hp}</span>", "<span>{hc}</span>\u5c0f\u65f6", "<span>{mp}</span>", "<span>{mc}</span>\u5206\u949f", "<span>{sp}</span>", "<span>{sc}</span>\u79d2", "</p>"]
    }),
    r = new IX.ITemplate({
        tpl: ['<div class="content1" id="rushend">', '<img class="img" src="http://p3.qhimg.com/t018f9274a6f8da9400.png" />', "</div>"]
    }),
    i = new IX.ITemplate({
        tpl: ['<div class="content2" id="thank">', '<div class="text2">360\u667a\u80fd\u6444\u50cf\u673a</div>', '<div class="text2">\u611f\u8c22\u6709\u4f60</div>', '<div class="img">', '<img class="img1" src="http://p2.qhimg.com/t01349efe4787ada19b.png" />', '<img class="img2" src="http://p8.qhimg.com/t01a28db76d97df368b.png" />', "</div>", '<div class="text1">\u5168\u90e8\u552e\u7f44</div>', "</div>"]
    }),
    s = new IX.ITemplate({
        tpl: ["<div class = 'mobile-reminder'>", "<div class = 'input'>", "<p>\u8bf7\u586b\u5199\u5e76\u63d0\u4ea4\u60a8\u7684\u624b\u673a\u53f7\u7801</p>", "<p>\u6211\u4eec\u5c06\u5728\u53d1\u552e\u524d\u4ee5\u77ed\u4fe1\u5f62\u5f0f\u901a\u77e5\u60a8\u53c2\u4e0e\u62a2\u8d2d\uff01</p>", "<div>", "<label>\u624b\u673a\u53f7\u7801</label>", "<input type = 'text' placeholder = '\u63a5\u6536\u5230\u8d27\u63d0\u9192\u77ed\u4fe1' />", "<p class = 'error'></p>", "</div>", "<a class = 'ok'>\u63d0\u4ea4\u4fe1\u606f</a>", "</div>", "<div class = 'result'>", "<p>\u606d\u559c\uff01\u63d0\u4ea4\u6210\u529f\uff01</p>", "<p class = 'note'>\u6211\u4eec\u5c06\u5728\u53d1\u552e\u524d\u4ee5\u77ed\u4fe1\u5f62\u5f0f\u901a\u77e5\u60a8\u53c2\u4e0e\u62a2\u8d2d\uff01</p>", "<div></div>", "<p class = 'n'>[\u6e29\u99a8\u63d0\u793a]</p>", "<p class = 'n n1'>\u5230\u8d27\u63d0\u9192\u4ec5\u5728\u672c\u8f6e\u62a2\u8d2d\u751f\u6548\uff0c\u5982\u672c\u8f6e\u62a2\u8d2d\u672a\u6210\u529f\uff0c\u60a8\u53ef\u518d\u6b21\u5f00\u542f\u5230\u8d27\u63d0\u9192\u670d\u52a1\u3002</p>", "</div>", "</div>"]
    }),
    o = function(e) {
        var r = IX.inherit({
            container: null,
            currentTime: (new Date).getTime(),
            onStepChanged: function() {},
            isMobile: !1
        },
        e),
        i,
        o,
        u,
        a,
        f,
        l,
        c,
        h = [(new Date("2015/03/04 11:00:00")).getTime(), (new Date("2015/03/11 11:00:00")).getTime(), (new Date("2015/03/18 11:00:00")).getTime(), (new Date("2015/03/25 11:00:00")).getTime(), (new Date("2015/04/01 11:00:00")).getTime(), (new Date("2015/04/08 11:00:00")).getTime(), (new Date("2015/04/15 11:00:00")).getTime()],
        p = function() {
            var e = IX.Date.getDateDiff(i, o);
            return e.hours = e.days * 24 + e.hours,
            n.renderData("", {
                hp: e.hours == 0 ? 0: (e.hours + "").length == 1 ? 0: Math.floor(e.hours / 10),
                hc: e.hours == 0 ? 0: e.hours % 10,
                mp: e.minutes == 0 ? 0: (e.minutes + "").length == 1 ? 0: Math.floor(e.minutes / 10),
                mc: e.minutes == 0 ? 0: e.minutes % 10,
                sp: e.seconds == 0 ? 0: (e.seconds + "").length == 1 ? 0: Math.floor(e.seconds / 10),
                sc: e.seconds == 0 ? 0: e.seconds % 10
            })
        },
        d = function() {
            var e = 2;
            return m(),
            i >= u && i <= u + 6e5 ? 1: i >= o - 36e5 && i < o ? 5: i < o - 36e5 && o - i <= 828e5 ? 2: i >= u + 6e5 && i <= u + 36e5 ? 4: 3
        },
        v = function() {
            var e = d();
            c.find("div.beforebuy").hide(),
            c.find(".text2").hide();
            return
        },
        m = function(e, t) {
            i = e || i;
            for (var n = 0, r; r = h[n]; n++) if (r > i) {
                o = r,
                u = n == 0 ? r: h[n - 1];
                break
            }
            o = o,
            u = u,
            f && f()
        },
        g,
        y = function() {
            if (g) return;
            g = new ZBase.UI.Dialog({
                html: s.renderData("", {}),
                noHeader: !1,
                noFooter: !0,
                width: r.isMobile ? null: 600,
                title: "",
                afterHide: function() {
                    g = null
                },
                className: r.isMobile ? "mobile": ""
            }),
            g.show();
            var e = g.$.find("input"),
            t = g.$.find("p.error");
            g.$.find("a.ok").click(function() {
                var n = e.val().replace(/ /g, ""),
                r;
                t.html("");
                if (n.length == 0 || !/^(13|15|18)\d{9}$/.test(n)) r = "\u624b\u673a\u53f7\u7801\u8f93\u5165\u6709\u8bef\uff0c\u8bf7\u91cd\u65b0\u8f93\u5165\uff01";
                r ? t.html(r) : $.ajax({
                    url: "https://q.jia.360.cn/site/submitPhoneInfo",
                    dataType: "jsonp",
                    jsonp: "callback",
                    data: {
                        taskid: IX.UUID.generate(),
                        phoneNum: n
                    },
                    success: function(e) {
                        e.errorCode === 0 ? (g.$.find("div.input").hide(), g.$.find("div.result").show()) : e.errorCode == 547 ? t.html("\u624b\u673a\u4fe1\u606f\u5df2\u63d0\u4ea4\uff0c\u8bf7\u8010\u5fc3\u7b49\u5f85\u6211\u4eec\u7684\u77ed\u4fe1\u901a\u77e5\uff01") : t.html(e.errorMsg)
                    },
                    error: function() {
                        t.html("\u63d0\u4ea4\u5931\u8d25\uff0c\u8bf7\u7a0d\u5019\u5237\u65b0\u91cd\u8bd5\uff01")
                    }
                })
            }).focus(function() {
                t.html("")
            }),
            r.isMobile && g.$.find("input").blur(function() {
                document.body.scrollTop = 0
            })
        },
        b = function(e) {
            m(e),
            c = $(r.container),
            c.html(t.renderData("", {})),
            c.find("div.inbuy").find("a.bt").click(function() {
                var e = d();
                e == 3 || e == 4 || e == 2
            }),
            v()
        },
        w = function() {
            $.ajax({
                url: "http://www.qikoo.com/preordersubmit/getservertime",
                success: function(e) {
                    b(e.curr_time * 1e3)
                },
                error: function() {
                    b((new Date).getTime())
                },
                dataType: "jsonp",
                jsonp: "callback"
            })
        },
        E = {
            begin: function(e) {
                f = e,
                w()
            },
            getCurrentTime: function() {
                return i
            }
        };
        return E
    };
    IX.ns("Static.CameraSale"),
    Static.CameraSale = o
} (),
function() {
    var e = "<input type = 'button' class = '{clz}' value = '{name}' />",
    t = new IX.ITemplate({
        tpl: ["<div class = 'modal fade zbase-ui autodialog {clz} nofade' id = '{id}'>", '<!--[if lte IE 7]><div class = "ie7-clearfix" style = "height:0;"></div><![endif]-->', '<div class="modal-dialog">', '<div class="modal-content">', '<div class="modal-header">', '<button class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>', '<h4 class="modal-title">{title}</h4>', "</div>", '<div class="modal-body">', "</div>", '<div class="modal-footer">', '<button type="button" class="btn btn-default" data-dismiss="modal">\u5173\u95ed</button>', "</div>", "</div>", "</div>", "</div>"]
    }),
    n = function(e) {
        var n = $.extend(!0, {
            html: "",
            title: "",
            className: "",
            noHeader: !1,
            noFooter: !1,
            isFadeIn: !0,
            animate: !1,
            verticalAlign: "middle",
            afterHide: function() {}
        },
        e),
        r,
        i,
        s = function() {
            i = IX.id(),
            r = $(t.renderData("", {
                title: n.title,
                id: i,
                clz: n.className + (n.noHeader ? " noheader": "") + (n.noFooter ? " nofooter": "")
            })).appendTo("body"),
            r.find(".modal-body").append(n.html).attr("id", "ad_" + IX.id()),
            n.height && r.find(".modal-dialog").height(n.height),
            n.width && r.find(".modal-dialog").width(n.width),
            f.$ = r.find(".modal-body"),
            f._.con = r,
            r.find(".ie7-clearfix").length == 0 && document.documentMode == 7 && r.prepend('<div class = "ie7-clearfix" style = "height:0;"></div>'),
            o()
        },
        o = function() {
            r.on("hidden.bs.modal", 
            function(e) {
                a(),
                n.afterHide()
            })
        },
        u = function() {
            r.modal({
                keyboard: !1,
                animate: n.animate,
                verticalAlign: n.verticalAlign
            }),
            document.body.style[IX.getClass(document.body.style) != "object" ? "removeProperty": "removeAttribute"]("padding-right")
        },
        a = function() {
            r.remove()
        },
        f = {
            show: u,
            remove: a,
            $: null,
            _: {}
        };
        return s(),
        f
    };
    IX.ns("ZBase.UI"),
    ZBase.UI.Dialog = n
} (),
function() {
    var e = function(e) {
        var t = IX.inherit({
            header: null,
            container: null,
            block: ".block",
            footer: null,
            cbs: null,
            time: 900,
            screenNav: null,
            beforeRun: null,
            afterRun: null
        },
        e),
        n,
        r,
        i = $(document),
        s = $(window),
        o,
        u,
        a = !1,
        f = 0,
        l = 0,
        c = 0,
        h = !1,
        p = !1,
        d = 0,
        v = navigator.userAgent,
        m = !1,
        g = {
            x: 0,
            y: 0
        },
        y = {
            x: 0,
            y: 0
        },
        b = function() {
            if (!t.container) throw "Static.Scroll container can not be null";
            n = $.type(t.container) === "string" ? $(t.container) : t.container,
            n.addClass("SCROLL-WRAP"),
            d = n.height();
            if (n.size() != 1) throw "container just be one";
            r = $.type(t.block) === "string" ? n.children(t.block) : t.block;
            if (t.cbs && r.size() != t.cbs.length) throw "cbs must be equals block size";
            o = $.type(t.header) === "string" ? $(t.header) : t.header,
            o && o.each(function() {
                l += $(this).height()
            }),
            u = $.type(t.footer) === "string" ? $(t.footer) : t.footer,
            u && u.each(function() {
                c += $(this).height()
            }),
            m = !!v.match(/AppleWebKit.*Mobile.*/) || !!v.match(/Windows Phone/) || !!v.match(/Android/) || !!v.match(/MQQBrowser/)
        },
        w = function(e) {
            return e *= -100,
            {
                transform: "translateY(" + e + "%)",
                "-ms-transform": "translateY(" + e + "%)",
                "-moz-transform": "translateY(" + e + "%)",
                "-webkit-transform": "translateY(" + e + "%)",
                "-o-transform": "translateY(" + e + "%)"
            }
        },
        E = function(e, i) {
            if (a) return ! 1;
            a = !0,
            setTimeout(function() {
                a = !1
            },
            t.time);
            if (i < 0) {
                if (t.cbs && t.cbs[f] && t.cbs[f].next && !t.cbs[f].next()) return;
                if (f == 0 && l && p) {
                    p = !1,
                    o.css("margin-top", "0px");
                    return
                }
                if (f + 1 == r.size()) {
                    c && !h && (h = !0, $("#wrap").css("margin-top", -c + "px"));
                    return
                }++f
            } else {
                if (f == 0) {
                    l && !p && (p = !0, o.css("margin-top", -l + "px"));
                    return
                }
                if (f + 1 == r.size() && c && h) {
                    h = !1,
                    n.css("margin-top", "0px");
                    return
                }
                if (t.cbs && t.cbs[f] && t.cbs[f].pre && !t.cbs[f].pre()) return; --f
            }
            S(f)
        },
        S = function(e) {
            p = !1,
            h = !1,
            l && o.css("magrin-top", -l + "px"),
            c && n.css("margin-top", "0px"),
            n.css(w(e)),
            f = e,
            t.beforeRun && t.beforeRun.call(r.eq(f)),
            t.screenNav && t.screenNav.selected && t.screenNav.selected(f + 1),
            t.cbs && t.cbs[f] && (t.cbs[f].go && t.cbs[f].go() || t.cbs[f].call(r.eq(f))),
            setTimeout(function() {
                t.afterRun && t.afterRun()
            },
            t.time)
        },
        x = function(e) {
            if (e.keyCode == 38) B();
            else if (e.keyCode == 40) H();
            else if (e.keyCode == 9) return ! 1
        },
        T = function() {
            n.height(s.height())
        },
        N = function(e) {
            if ($(e.target).closest(".SCROLL-WRAP")[0] != n[0]) {
                g.y = null;
                return
            }
            var t = e.touches[0],
            r = Number(t.pageY);
            y.y = g.y = r
        },
        C = function(e) {
            e.stopPropagation(),
            e.preventDefault();
            var t = e.touches[0];
            y.y = Number(t.pageY)
        },
        k = function(e) {
            if (g.y == null) return;
            y.y - g.y < -50 ? E(e, -1) : y.y - g.y > 50 && E(e, 1)
        },
        L = function() {
            i.bind("mousewheel", E),
            i.bind("keydown", x),
            s.bind("resize", T),
            document.addEventListener && (document.addEventListener("touchstart", N, !1), document.addEventListener("touchmove", C, !1), document.addEventListener("touchend", k, !1))
        },
        A = function() {
            i.unbind("mousewheel", E),
            i.unbind("keydown", x),
            s.unbind("resize", T),
            document.removeEventListener && (document.removeEventListener("touchstart", N, !1), document.removeEventListener("touchmove", C, !1), document.removeEventListener("touchend", k, !1))
        },
        O = function() { ! l && t.beforeRun && t.beforeRun.call(r.eq(0)),
            n.height(s.height())
        },
        M = function() {
            d == 0 && n.css("height", "auto"),
            A()
        },
        _ = function() {
            b(),
            O(),
            L(),
            T()
        },
        D = function() {
            M()
        },
        P = function() {
            return f
        },
        H = function() {
            E({},
            -1)
        },
        B = function() {
            E({},
            1)
        };
        return _(),
        {
            turnTo: S,
            destroy: D,
            getPageIndex: P,
            rollDown: H,
            rollUp: B
        }
    };
    IX.ns("Static.Scroll"),
    Static.Scroll = e
} (),
function(e, t) {
    var n = function(t) {
        if (t.isIE5 || t.isIE6 || t.isIE7 || t.isIE8 || t.isIE9 || t.isIE && t.isQuirks) return e("body").addClass("ie"),
        !1;
        var n = new Static.ScreenNav({
            items: [{
                desc: "\u603b\u8ff0"
            },
            {
                desc: "\u9ad8\u6e05\u5206\u8fa8\u7387"
            },
            {
                desc: "\u5fae\u5149\u591c\u89c6"
            },
            {
                desc: "\u753b\u9762\u6e05\u6670\u900f\u4eae"
            },
            {
                desc: "\u9ad8\u4fdd\u771f\u53cc\u5411\u8bed\u97f3"
            },
            {
                desc: "\u4fbf\u6377\u5b89\u88c5"
            },
            {
                desc: "\u78c1\u529b\u5438\u9644\u5e95\u5ea7"
            },
            {
                desc: "\u58f0\u6ce2\u7ed1\u5b9a\u624b\u673a"
            },
            {
                desc: "360\u00b0\u8f6c\u8f74"
            },
            {
                desc: "360\u4e91\u5e73\u53f0"
            },
            {
                desc: "\u4e91\u76f4\u64ad\u6280\u672f"
            }],
            onClick: function(e, t, n) {
                i.turnTo(t - 1)
            },
            onChanged: function(e) {
                e == 1 || e == 2 || e == 4 || e == 5 || e == 6 || e == 9 || e == 10 || e == 11 ? n.changeClassType(1) : n.changeClassType(2)
            }
        });
        n.changeClassType(1);
        var r = new Array(11);
        r[1] = function() { (new Image).src = "http://p4.qhimg.com/t011108d1fbe559fc9f.png",
            setTimeout(function() {
                e("#hand").addClass("handopen"),
                setTimeout(function() {
                    e("#screen").addClass("screenscale")
                },
                50)
            },
            1500)
        },
        r[3] = function() {
            setTimeout(function() {
                e("#video")[0].play()
            },
            900)
        },
        r[8] = function() {
            setTimeout(function() {
                e("#video360")[0].play()
            },
            900)
        };
        var i = Static.Scroll({
            cbs: r,
            container: e("#wrap"),
            footer: ".footer-wrap1,.footer-wrap2",
            screenNav: n,
            beforeRun: function() {
                this.addClass("active")
            },
            afterRun: function() {
                i.getPageIndex() == 0 ? e("#roll_top").fadeOut() : e("#roll_top").fadeIn()
            }
        });
        e("#roll_top").click(function() {
            i.turnTo(0)
        }),
        window.location.hash.indexOf("section") > -1 && i.turnTo(Number(window.location.hash.split("section").pop()) - 1)
    };
    IX.ns("Static.param"),
    Static.param.init = function(e) {
        n(e)
    }
} (jQuery),
function() {
    var e,
    t,
    n,
    r,
    i,
    s = !1,
    o,
    u = 300,
    a = 6,
    f = u / a,
    l,
    c,
    h = 0,
    p,
    d = "",
    v,
    m,
    g,
    y = {
        1: {
            "do": function(e) {
                e()
            }
        },
        2: {
            "do": function(e) {
                e()
            }
        },
        3: {
            "do": function(e) {
                e()
            }
        },
        4: {
            "do": function(e) {
                e()
            }
        },
        5: {
            "do": function(e) {
                e()
            }
        },
        6: {
            "do": function(e) {
                e()
            }
        },
        7: {
            "do": function(e) {
                e()
            }
        },
        8: {
            "do": function(e) {
                e()
            }
        },
        9: {
            "do": function(e) {
                e()
            }
        },
        10: {
            "do": function(e) {
                e()
            }
        },
        11: {
            "do": function(e) {
                e()
            }
        }
    },
    b = function(e, t, n) {
        y[e] && y[e].next && y[e].next(),
        y[t]["do"] = y[t]["do"] || 
        function(e) {
            e()
        },
        y[t]["do"](n),
        t == 1 ? m.fadeOut() : m.fadeIn()
    },
    w = function(e, i) {
        if (s || t.find(".section.show.start").length > 1 || e != null && Math.abs(i) > 1) return;
        s = !0;
        var u = t.find(".section.show"),
        a = Number(u.attr("_index"));
        u.length == 0 && (a = o);
        var f = e == null ? i: i > 0 ? Math.max(a - 1, 1) : Math.min(a + 1, o);
        if (f == a) {
            s = !1;
            return
        }
        if (f == o) {
            u.removeClass("show"),
            h = -(l * (f - 2)) - p,
            n.css("margin-top", h + "px"),
            r[0].className += " section" + o,
            s = !1;
            return
        }
        var c = t.find(".section.section" + f);
        u.removeClass("show"),
        c.addClass("show start"),
        v.selected(f),
        h = -(l * (f - 1));
        var m = ["imgconfix", d];
        for (var g = 0; g <= f; g++) m.push("section" + g);
        Math.abs(a - f) > 1 ? (m.push("quick"), r[0].className = m.join(" "), m.pop(), m.push("start" + f), n.css("margin-top", h + "px"), setTimeout(function() {
            r[0].className = m.join(" "),
            b(a, f, 
            function() {
                setTimeout(function() {
                    c.removeClass("start"),
                    s = !1
                },
                500)
            })
        },
        200)) : (m.push("start" + f), r[0].className = m.join(" "), n.css("margin-top", h + "px"), b(a, f, 
        function() {
            setTimeout(function() {
                c.removeClass("start"),
                s = !1
            },
            500)
        }))
    },
    E = function() {
        l = document.documentElement.clientHeight > 0 ? document.documentElement.clientHeight: document.body.clientHeight,
        g.each(function(e) {
            g.eq(e).height(l)
        });
        var e = t.find(".section.show"),
        r = Number(e.attr("_index"));
        h = -(l * (r - 1)),
        n.css("margin-top", h + "px")
    },
    S = function() {
        IX.isMSIE && Number($.browser.version.split(".")[0]) <= 9 && (d = "ie"),
        v = new Static.ScreenNav({
            items: [{
                desc: "\u9996\u9875"
            },
            {
                desc: "\u9002\u7528\u5404\u79cd\u7f51\u7edc"
            },
            {
                desc: "\u5168\u5c4f\u76f4\u64ad"
            },
            {
                desc: "8\u500d\u53d8\u7126"
            },
            {
                desc: "\u4e00\u952e\u62cd\u7167"
            },
            {
                desc: "\u6309\u4f4f\u8bf4\u8bdd"
            },
            {
                desc: "\u5f55\u50cf"
            },
            {
                desc: "\u548c\u5bb6\u4eba\u5206\u4eab"
            },
            {
                desc: "\u79c0\u7ed9\u5927\u5bb6\u770b"
            },
            {
                desc: "\u89e6\u53ca\u5168\u4e16\u754c"
            },
            {
                desc: "\u5bb6\u5ead\u5b89\u5168\u4fdd\u62a4"
            }],
            onClick: function(e, t, n) {
                w(null, t)
            }
        }),
        v.changeClassType(1),
        e = $(document),
        t = $(".wrap"),
        n = t.find(".scroll"),
        r = t.find(".imgconfix"),
        i = $("#nav a"),
        o = t.find(".section").length + 1,
        p = $(".footer-wrap1").outerHeight() + $(".footer-wrap2").outerHeight(),
        m = $("#roll_top"),
        g = t.find(".section").each(function(e, t) {
            $(this).attr("_index", e + 1),
            i.eq(e).attr("_index", e + 1)
        }),
        i.click(function() {
            if (s || t.find(".section.show.start").length > 1) return;
            var e = Number($(this).attr("_index"));
            w(null, e)
        }),
        m.click(function() {
            i.eq(0).click()
        }),
        e.mousewheel(w),
        e.keydown(function(e) {
            if (e.keyCode == 38) w({},
            1);
            else if (e.keyCode == 40) w({},
            -1);
            else if (e.keyCode == 9) return ! 1
        }),
        E(),
        window.onresize = E;
        var u = Number(document.location.hash.replace("#section", ""));
        y[u] && w(null, u)
    };
    IX.ns("Static.app"),
    Static.app.init = S
} (),
function(e, t) {
    var n,
    r,
    i = function(t) {
        var i = [{
            desc: "\u68a7\u6850\u6c47"	//"梧桐汇"
        },
        {
            desc: "\u0043\u00b7\u004b\u8336\u5496"	//"C·K茶咖"
        },
        {
            desc: "\u68a7\u6850\u9ad8\u5c14\u592b\u002f\u5065\u8eab"	//"梧桐高尔夫/健身"
        },
        {
            desc: "\u68a7\u6850\u82b1\u56ed\u9910\u5385"	//"梧桐花园餐厅"
        },
        {
            desc: "\u51e4\u51f0\u827a\u672f\u9986"	//"凤凰艺术馆"
        },
        {
            desc: "\u51e4\u51f0\u79c1\u4eab\u4f1a"	//"凤凰私享会"
        },
        {
            desc: "\u68a7\u6850\u521b\u4e1a\u5b75\u5316\u57fa\u5730"	//"梧桐创业孵化基地"
        },
        {
            desc: "\u68a7\u6850\u5c4b\u9876\u82b1\u56ed"	//"梧桐屋顶花园"
        },
        {
            desc: "\u626b\u6211"	//"扫我"
        }],
        s = [new Function, new Function, new Function, new Function, new Function, new Function, new Function, new Function, new Function];
        s[s.length - 1] = {
            scene: new Array(7),
            pre: function() {
                for (var t = this.scene.length - 1; t > 0; t--) if (this.scene[t]) break;
                return t != 0 ? (this.scene[t] = !1, e("#block8 .scene").eq(t - 1).removeClass("after"), e("#block8 .scene").eq(t).removeClass("active"), !1) : (e("#block8 .scene").eq(0).removeClass("active"), !0)
            },
            next: function() {
                for (var t = 0; t < this.scene.length; t++) if (!this.scene[t]) break;
                return t != this.scene.length ? (this.scene[t] = !0, e("#block8 .scene").eq(t - 1).addClass("after"), e("#block8 .scene").eq(t).addClass("active"), !1) : !0
            },
            go: function() {
                return this.scene[0] = !0,
                e("#block8 .scene").eq(0).addClass("active"),
                !0
            }
        },
        s[2].changeType = !0,
        s[3].changeType = !0,
        s[4].changeType = !0,
        s[6].changeType = !0,
        s[7].changeType = !0;
        var o = function() {
            r.turnTo(0)
        },
        u = function() {
            r.rollDown()
        },
        a = function() {
            e("#block8 .scene .b").height(e(window).height() - 205)
        },
        f = function() {
            e("#roll_top").bind("click", o),
            e("#arrow_ani").bind("click", u),
            e(window).bind("resize", a)
        },
        l = function() {
            e("#roll_top").unbind("click", o),
            e("#arrow_ani").unbind("click", u),
            e(window).unbind("resize", a)
        },
        c = function() {
            n = new Static.ScreenNav({
                items: i,
                onClick: function(e, t, n) {
                    r.turnTo(t - 1)
                },
                onChanged: function(e) {
                    s[e - 1].changeType ? n.changeClassType(1) : n.changeClassType(2)
                }
            }),
            r = Static.Scroll({
                container: e("#wrap"),
                //footer: ".footer-wrap1,.footer-wrap2",
                screenNav: n,
                cbs: s,
                beforeRun: function() {
                    this.addClass("active")
                },
                afterRun: function() {
                    r.getPageIndex() == 0 ? e("#roll_top").fadeOut() : e("#roll_top").fadeIn()
                }
            }),
            a(),
            f()
        },
        h = function() {
            n.remove(),
            r.destroy(),
            l()
        };
        c();
        var p = new Static.CameraSale({
            container: e("div.camerasale"),
            onStepChanged: function(e, t) {
                e == 555 && (window.location.href = window.location.href, window.location.reload())
            }
        });
        p.begin();
        if (t.isLtIE9) return e("body").addClass("ie"),
        h(),
        !1;
        window.location.hash.indexOf("section") > -1 && r.turnTo(Number(window.location.hash.split("section").pop()) - 1),
        e("a.video").click(function() {
            var e = new ZBase.UI.Dialog({
                width: 640,
                height: 390,
                noFooter: !0,
                className: "main-dialog",
                html: "<iframe width='100%' height='390' border='no' frameborder='no' src = 'http://yuntv.letv.com/bcloud.swf?uu=789b624579&vu=a3212461c0&auto_play=1&gpcflag=1'></iframe>"

            });
            return e.show(),
            !1
        })
    };
    IX.ns("Static.main"),
    Static.main.init = function(e) {
        i(e)
    }
} (jQuery),
function(e, t) {
    var n,
    r,
    i,
    s = e("div.l"),
    o = e("div.r"),
    u = [[(new Date("2015/02/10 00:00:00")).valueOf(), "http://yuntv.letv.com/bcloud.html?uu=789b624579&vu=54cfa10fed&auto_play=0&gpcflag=1&width={width}&height=100", !1, "\u9884\u544a\u7bc7"], [(new Date("2015/02/13 00:00:00")).valueOf(), "http://yuntv.letv.com/bcloud.html?uu=789b624579&vu=4ce7bd29d9&auto_play=0&gpcflag=1&width={width}&height=100", !1, "\u513f\u7ae5\u7bc7"], [(new Date("2015/02/15 00:00:00")).valueOf(), "http://yuntv.letv.com/bcloud.html?uu=789b624579&vu=328919e8d4&auto_play=0&gpcflag=1&width={width}&height=100", !1, "\u767d\u9886\u7bc7"], [(new Date("2015/02/17 00:00:00")).valueOf(), "http://yuntv.letv.com/bcloud.html?uu=789b624579&vu=60e9cf3769&auto_play=0&gpcflag=1&width={width}&height=100", !1, "\u5317\u6f02\u7bc7"]],
    a = new IX.ITemplate({
        tpl: ["<div class = 'vitem {clz}' _index = {i}>", "<div class = 'v'>", "<div class = 'modal'><div></div></div>", "<iframe src = '{url}' width='100%' height='100%'></iframe>", "</div>", "<p class = 'd'>{d}</p>", "</div>"]
    }),
    f = function() {
        var e = !1;
        for (var t = u.length - 1, n; n = u[t]; t--) n[0] < Static.CameraSale.currentTime && (u[t][2] = !0, e === !1 && (e = t)),
        u[t][4] = a.renderData("", {
            url: n[1],
            d: n[3],
            clz: u[t][2] ? "": "disabled",
            i: t
        });
        return e
    },
    l = function(e) {
        i = e,
        s.html(u[e][4]).find("video").attr("controls", "controls"),
        s.find("div.v").height(s.height() - s.find("p").outerHeight());
        var t = s.find("iframe");
        t.attr("src", u[i][1].replace("{width}", t.width()).replace("100", t.height())),
        o.html("");
        for (var n = 0, r; r = u[n]; n++) {
            if (n == e) continue;
            o.append(r[4])
        }
    },
    c = function() {
        e("div.videos div.r").click(function(t) {
            var n = e(t.target || t.srcElement).closest("div.vitem:not(.disabled)");
            if (n.length == 0) return;
            l(n.attr("_index"))
        }),
        window.onresize = onResize = function() {
            s.height(e("div.videos").height()),
            s.find("div.v").height(s.height() - s.find("p").outerHeight());
            var t = s.find("iframe");
            t.attr("src", u[i][1].replace("{width}", t.width()).replace("100", t.height()))
        },
        onResize(),
        setTimeout(function() {
            onResize()
        },
        500)
    },
    h = function(t) {
        i = f(),
        s = e("div.l"),
        o = e("div.r"),
        l(i),
        c()
    };
    IX.ns("Static.index"),
    Static.index.init = function(e) {
        h(e)
    }
} (jQuery),
function() {
    var e = function(e, t) {
        t && (document.body.className += " mobile")
    };
    IX.ns("Static.newyearparty"),
    Static.newyearparty.init = function(t, n) {
        window.location.href = "main.html",
        e(t, n)
    }
} (),
function($, undefined) {
    var verifyInit = function() {
        $("#verifyCodeBtn").click(function() {
            var verifyCode = $("#verifyCode").val(),
            Lcode = $("#LCode").val(),
            url = "/lexchange/CheckLCode/",
            params = {
                Lcode: Lcode,
                actionCode: verifyCode
            };
            $.get(url, params, 
            function(data) {
                var json = eval("(" + data + ")"),
                errorCode = json.Error.toLocaleUpperCase();
                $(".layer").hide(),
                $(".layer-text1").hide(),
                $(".layer-text2").hide(),
                errorCode == "0X0005" ? (showLayer("#errorOper"), refreshVerifyCode()) : errorCode == "0X0004" ? (showLayer("#errorVerifyCode"), refreshVerifyCode()) : errorCode == "0X0001" ? (showLayer("#errorLCode"), refreshVerifyCode()) : errorCode == "0X0002" ? (showLayer("#employLCode"), refreshVerifyCode()) : errorCode == "0X0003" && (location.href = "/verifyuserinfo.html?Lcode=" + Lcode + "&actionCode=" + verifyCode)
            })
        }),
        $("#userBtn").click(function() {
            var Lcode = getQueryString("Lcode"),
            verifyCode = getQueryString("actionCode");
            proving(Lcode, 
            function(Lcode) {
                var url = "/lexchange/NoteUserInfo/",
                username = $("#username").val(),
                phone = $("#phone").val(),
                addr = $("#address").val(),
                zipCode = $("#zipCode").val(),
                params = {
                    Code: Lcode,
                    Username: username,
                    Tele_number: phone,
                    Addr_user: addr,
                    Zip_code: zipCode,
                    actionCode: verifyCode
                };
                $.get(url, params, 
                function(data) {
                    var json = eval("(" + data + ")"),
                    errorCode = json.Error.toLocaleUpperCase();
                    errorCode == "0X0005" ? showLayer("#oper_error") : errorCode == "0X0004" ? showLayer("#verifyCode_error") : errorCode == "SUCCESS" ? location.href = "/lexchange/NoteSuccess": errorCode == "BE_USED" && showLayer("#LCode_error")
                })
            })
        }),
        $("#L_verifyCode img").click(function() {
            refreshVerifyCode()
        });
        var refreshVerifyCode = function() {
            var e = document.getElementById("IVerifyCode");
            e.setAttribute("src", "/lexchange/BuildActionCode/?" + Math.random())
        },
        proving = function(e, t) {
            var n = $("#username").val(),
            r = $("#phone").val(),
            i = $("#address").val(),
            s = $("#zipCode").val(),
            o = /^1\d{10}$/,
            u = /^[0-9]{6}$/;
            if (n == null || n == "") return showLayer("#username_null"),
            !1;
            if (r == null || r == "") return showLayer("#phone_null"),
            !1;
            if (!o.test(r)) return showLayer("#phone_error"),
            !1;
            if (i == null || i == "") return showLayer("#addr_null"),
            !1;
            if (s == null || s == "") return showLayer("#zipCode_null"),
            !1;
            if (!u.test(s)) return showLayer("#zipCode_error"),
            !1;
            t(e)
        },
        showLayer = function(e) {
            alert($(e + " .mes-td").eq(0).html())
        },
        getQueryString = function(e) {
            var t = new RegExp("(^|&)" + e + "=([^&]*)(&|$)", "i"),
            n = window.location.search.substr(1).match(t);
            return n != null ? unescape(n[2]) : null
        }
    };
    IX.ns("Static.verify"),
    Static.verify.init = function(e) {
        verifyInit(e)
    }
} (jQuery);