/*!
 * sprintf.js (namespaced by WebSharks, Inc.); copyright (c) 2007-2013 Alexandru Marasteanu
 * 3 clause BSD license <https://github.com/alexei/sprintf.js>
 */
(function () {
    if (typeof window["xd-v141226-dev->sprintf"] !== "function") {
        var b = {
            not_string: /[^s]/,
            number: /[def]/,
            text: /^[^\x25]+/,
            modulo: /^\x25{2}/,
            placeholder: /^\x25(?:([1-9]\d*)\$|\(([^\)]+)\))?(\+)?(0|'[^$])?(-)?(\d+)?(?:\.(\d+))?([b-fosuxX])/,
            key: /^([a-z_][a-z_\d]*)/i,
            key_access: /^\.([a-z_][a-z_\d]*)/i,
            index_access: /^\[(\d+)\]/,
            sign: /^[\+\-]/
        };

        function e() {
            var g = arguments[0], f = e.cache;
            if (!(f[g] && f.hasOwnProperty(g))) {
                f[g] = e.parse(g)
            }
            return e.format.call(null, f[g], arguments)
        }

        e.format = function (q, p) {
            var u = 1, s = q.length, m = "", v, g = [], n, j, o, h, r, t, l = true, f = "";
            for (n = 0; n < s; n++) {
                m = a(q[n]);
                if (m === "string") {
                    g[g.length] = q[n]
                } else {
                    if (m === "array") {
                        o = q[n];
                        if (o[2]) {
                            v = p[u];
                            for (j = 0; j < o[2].length; j++) {
                                if (!v.hasOwnProperty(o[2][j])) {
                                    throw new Error(e("[sprintf] property '%s' does not exist", o[2][j]))
                                }
                                v = v[o[2][j]]
                            }
                        } else {
                            if (o[1]) {
                                v = p[o[1]]
                            } else {
                                v = p[u++]
                            }
                        }
                        if (a(v) == "function") {
                            v = v()
                        }
                        if (b.not_string.test(o[8]) && (a(v) != "number" && isNaN(v))) {
                            throw new TypeError(e("[sprintf] expecting number but found %s", a(v)))
                        }
                        if (b.number.test(o[8])) {
                            l = v >= 0
                        }
                        switch (o[8]) {
                            case"b":
                                v = v.toString(2);
                                break;
                            case"c":
                                v = String.fromCharCode(v);
                                break;
                            case"d":
                                v = parseInt(v, 10);
                                break;
                            case"e":
                                v = o[7] ? v.toExponential(o[7]) : v.toExponential();
                                break;
                            case"f":
                                v = o[7] ? parseFloat(v).toFixed(o[7]) : parseFloat(v);
                                break;
                            case"o":
                                v = v.toString(8);
                                break;
                            case"s":
                                v = ((v = String(v)) && o[7] ? v.substring(0, o[7]) : v);
                                break;
                            case"u":
                                v = v >>> 0;
                                break;
                            case"x":
                                v = v.toString(16);
                                break;
                            case"X":
                                v = v.toString(16).toUpperCase();
                                break
                        }
                        if (!l || (b.number.test(o[8]) && o[3])) {
                            f = l ? "+" : "-";
                            v = v.toString().replace(b.sign, "")
                        }
                        r = o[4] ? o[4] == "0" ? "0" : o[4].charAt(1) : " ";
                        t = o[6] - (f + v).length;
                        h = o[6] ? c(r, t) : "";
                        g[g.length] = o[5] ? f + v + h : (r == 0 ? f + h + v : h + f + v)
                    }
                }
            }
            return g.join("")
        };
        e.cache = {};
        e.parse = function (f) {
            var i = f, j = [], l = [], k = 0;
            while (i) {
                if ((j = b.text.exec(i)) !== null) {
                    l[l.length] = j[0]
                } else {
                    if ((j = b.modulo.exec(i)) !== null) {
                        l[l.length] = "%"
                    } else {
                        if ((j = b.placeholder.exec(i)) !== null) {
                            if (j[2]) {
                                k |= 1;
                                var m = [], h = j[2], g = [];
                                if ((g = b.key.exec(h)) !== null) {
                                    m[m.length] = g[1];
                                    while ((h = h.substring(g[0].length)) !== "") {
                                        if ((g = b.key_access.exec(h)) !== null) {
                                            m[m.length] = g[1]
                                        } else {
                                            if ((g = b.index_access.exec(h)) !== null) {
                                                m[m.length] = g[1]
                                            } else {
                                                throw new SyntaxError("[sprintf] failed to parse named argument key")
                                            }
                                        }
                                    }
                                } else {
                                    throw new SyntaxError("[sprintf] failed to parse named argument key")
                                }
                                j[2] = m
                            } else {
                                k |= 2
                            }
                            if (k === 3) {
                                throw new Error("[sprintf] mixing positional and named placeholders is not (yet) supported")
                            }
                            l[l.length] = j
                        } else {
                            throw new SyntaxError("[sprintf] unexpected placeholder")
                        }
                    }
                }
                i = i.substring(j[0].length)
            }
            return l
        };
        var d = function (g, f, h) {
            h = (f || []).slice(0);
            h.splice(0, 0, g);
            return e.apply(null, h)
        };

        function a(f) {
            return Object.prototype.toString.call(f).slice(8, -1).toLowerCase()
        }

        function c(f, g) {
            return Array(g + 1).join(f)
        }

        window["xd-v141226-dev->sprintf"] = e;
        window["xd-v141226-dev->vsprintf"] = d
    }
})();
/*!
 * jQuery.ScrollTo (namespaced by WebSharks, Inc.); copyright (c) 2007-2014 Ariel Flesler
 * MIT license <http://flesler.blogspot.com/2007/10/jqueryscrollto.html>
 */
(function (c) {
    if (typeof c["xd-v141226-dev->scrollTo"] !== "function") {
        var a = c["xd-v141226-dev->scrollTo"] = function (f, e, d) {
            return c(window)["xd-v141226-dev->scrollTo"](f, e, d)
        };
        a.defaults = {axis: "xy", duration: parseFloat(c.fn.jquery) >= 1.3 ? 0 : 1, limit: true};
        a.window = function (d) {
            return c(window)["xd-v141226-dev->_scrollable"]()
        };
        c.fn["xd-v141226-dev->_scrollable"] = function () {
            return this.map(function () {
                var e = this, d = !e.nodeName || c.inArray(e.nodeName.toLowerCase(), ["iframe", "#document", "html", "body"]) != -1;
                if (!d) {
                    return e
                }
                var f = (e.contentWindow || e).document || e.ownerDocument || e;
                return /webkit/i.test(navigator.userAgent) || f.compatMode == "BackCompat" ? f.body : f.documentElement
            })
        };
        c.fn["xd-v141226-dev->scrollTo"] = function (f, e, d) {
            if (typeof e == "object") {
                d = e;
                e = 0
            }
            if (typeof d == "function") {
                d = {onAfter: d}
            }
            if (f == "max") {
                f = 9000000000
            }
            d = c.extend({}, a.defaults, d);
            e = e || d.duration;
            d.queue = d.queue && d.axis.length > 1;
            if (d.queue) {
                e /= 2
            }
            d.offset = b(d.offset);
            d.over = b(d.over);
            return this["xd-v141226-dev->_scrollable"]().each(function () {
                if (f == null) {
                    return
                }
                var l = this, j = c(l), k = f, i, g = {}, m = j.is("html,body");
                switch (typeof k) {
                    case"number":
                    case"string":
                        if (/^([+-]=?)?\d+(\.\d+)?(px|%)?$/.test(k)) {
                            k = b(k);
                            break
                        }
                        k = m ? c(k) : c(k, this);
                        if (!k.length) {
                            return
                        }
                    case"object":
                        if (k.is || k.style) {
                            i = (k = c(k)).offset()
                        }
                }
                var n = c.isFunction(d.offset) && d.offset(l, k) || d.offset;
                c.each(d.axis.split(""), function (r, s) {
                    var t = s == "x" ? "Left" : "Top", v = t.toLowerCase(), q = "scroll" + t, p = l[q], o = a.max(l, s);
                    if (i) {
                        g[q] = i[v] + (m ? 0 : p - j.offset()[v]);
                        if (d.margin) {
                            g[q] -= parseInt(k.css("margin" + t)) || 0;
                            g[q] -= parseInt(k.css("border" + t + "Width")) || 0
                        }
                        g[q] += n[v] || 0;
                        if (d.over[v]) {
                            g[q] += k[s == "x" ? "width" : "height"]() * d.over[v]
                        }
                    } else {
                        var u = k[v];
                        g[q] = u.slice && u.slice(-1) == "%" ? parseFloat(u) / 100 * o : u
                    }
                    if (d.limit && /^\d+$/.test(g[q])) {
                        g[q] = g[q] <= 0 ? 0 : Math.min(g[q], o)
                    }
                    if (!r && d.queue) {
                        if (p != g[q]) {
                            h(d.onAfterFirst)
                        }
                        delete g[q]
                    }
                });
                h(d.onAfter);
                function h(o) {
                    j.animate(g, e, d.easing, o && function () {
                        o.call(this, k, d)
                    })
                }
            }).end()
        };
        a.max = function (j, i) {
            var h = i == "x" ? "Width" : "Height", e = "scroll" + h;
            if (!c(j).is("html,body")) {
                return j[e] - c(j)[h.toLowerCase()]()
            }
            var g = "client" + h, f = j.ownerDocument.documentElement, d = j.ownerDocument.body;
            return Math.max(f[e], d[e]) - Math.min(f[g], d[g])
        };
        function b(d) {
            return c.isFunction(d) || typeof d == "object" ? d : {top: d, left: d}
        }
    }
})(jQuery);
/*!
 * HTML5 Sortable jQuery Plugin (namespaced by WebSharks, Inc.).
 * MIT license <https://github.com/voidberg/html5sortable>
 */
(function (c) {
    if (typeof c.fn["xd-v141226-dev->sortable"] !== "function") {
        // FIXME Firefox not selecting input bug is in here
        var dragging, draggingHeight, placeholders = c();
        c.fn["xd-v141226-dev->sortable"] = function(options) {
            var method = String(options);

            options = c.extend({
                connectWith: false,
                placeholder: null,
                dragImage: null
            }, options);

            return this.each(function () {

                var index, items = c(this).children(options.items), handles = options.handle ? items.find(options.handle) : items;

                if (method === 'reload') {
                    c(this).children(options.items).off('dragstart.h5s dragend.h5s selectstart.h5s dragover.h5s dragenter.h5s drop.h5s');
                }
                if (/^enable|disable|destroy$/.test(method)) {
                    var citems = c(this).children(c(this).data('items')).attr('draggable', method === 'enable');
                    if (method === 'destroy') {
                        c(this).off('sortupdate');
                        c(this).removeData('opts');
                        citems.add(this).removeData('connectWith items')
                            .off('dragstart.h5s dragend.h5s dragover.h5s dragenter.h5s drop.h5s').off('sortupdate');
                        handles.off('selectstart.h5s');
                    }
                    return;
                }

                var soptions = c(this).data('opts');

                if (typeof soptions === 'undefined') {
                    c(this).data('opts', options);
                }
                else {
                    options = soptions;
                }

                var startParent, newParent;
                var placeholder = ( options.placeholder === null ) ? c('<' + (/^ul|ol$/i.test(this.tagName) ? 'li' : 'div') + ' class="sortable-placeholder"/>') : c(options.placeholder).addClass('sortable-placeholder');

                c(this).data('items', options.items);
                placeholders = placeholders.add(placeholder);
                if (options.connectWith) {
                    c(options.connectWith).add(this).data('connectWith', options.connectWith);
                }

                items.attr('role', 'option');
                items.attr('aria-grabbed', 'false');

                // Setup drag handles
                handles.attr('draggable', 'true').not('a[href], img').on('selectstart.h5s', function() {
                    if (this.dragDrop) {
                        this.dragDrop();
                    }
                    return false;
                }).end();

                // Handle drag events on draggable items
                items.on('dragstart.h5s', function(e) {
                    var dt = e.originalEvent.dataTransfer;
                    dt.effectAllowed = 'move';
                    dt.setData('text', '');

                    if (options.dragImage && dt.setDragImage) {
                        dt.setDragImage(options.dragImage, 0, 0);
                    }

                    index = (dragging = c(this)).addClass('sortable-dragging').attr('aria-grabbed', 'true').index();
                    draggingHeight = dragging.outerHeight();
                    startParent = c(this).parent();
                    dragging.parent().triggerHandler('sortstart', {item: dragging, startparent: startParent});
                }).on('dragend.h5s',function () {
                    if (!dragging) {
                        return;
                    }
                    dragging.removeClass('sortable-dragging').attr('aria-grabbed', 'false').show();
                    placeholders.detach();
                    newParent = c(this).parent();
                    if (index !== dragging.index() || startParent.get(0) !== newParent.get(0)) {
                        dragging.parent().triggerHandler('sortupdate', {item: dragging, oldindex: index, startparent: startParent, endparent: newParent});
                    }
                    dragging = null;
                    draggingHeight = null;
                }).add([this, placeholder]).on('dragover.h5s dragenter.h5s drop.h5s', function(e) {
                    if (!items.is(dragging) && options.connectWith !== c(dragging).parent().data('connectWith')) {
                        return true;
                    }
                    if (e.type === 'drop') {
                        e.stopPropagation();
                        placeholders.filter(':visible').after(dragging);
                        dragging.trigger('dragend.h5s');
                        return false;
                    }
                    e.preventDefault();
                    e.originalEvent.dataTransfer.dropEffect = 'move';
                    if (items.is(this)) {
                        var thisHeight = c(this).outerHeight();
                        if (options.forcePlaceholderSize) {
                            placeholder.height(draggingHeight);
                        }

                        // Check if c(this) is bigger than the draggable. If it is, we have to define a dead zone to prevent flickering
                        if (thisHeight > draggingHeight) {
                            // Dead zone?
                            var deadZone = thisHeight - draggingHeight, offsetTop = c(this).offset().top;
                            if (placeholder.index() < c(this).index() && e.originalEvent.pageY < offsetTop + deadZone) {
                                return false;
                            }
                            else if (placeholder.index() > c(this).index() && e.originalEvent.pageY > offsetTop + thisHeight - deadZone) {
                                return false;
                            }
                        }

                        dragging.hide();
                        c(this)[placeholder.index() < c(this).index() ? 'after' : 'before'](placeholder);
                        placeholders.not(placeholder).detach();
                    } else if (!placeholders.is(this) && !c(this).children(options.items).length) {
                        placeholders.detach();
                        c(this).append(placeholder);
                    }
                    return false;
                });
            });
        };
    }
})(jQuery);
/*!
 * Bootstrap v3.1.1 (namespaced by WebSharks, Inc.); copyright 2011-2014 Twitter, Inc.
 * MIT license <https://github.com/twbs/bootstrap/blob/master/LICENSE>
 */
(function (b, a) {
    if (typeof b[a + "->bs"] !== "function") {
        b[a + "->bs"] = function () {
        };
        +function (d) {
            function c() {
                var g = document.createElement("div");
                var f = {
                    WebkitTransition: "webkitTransitionEnd",
                    MozTransition: "transitionend",
                    OTransition: "oTransitionEnd otransitionend",
                    transition: "transitionend"
                };
                for (var e in f) {
                    if (g.style[e] !== undefined) {
                        return {end: f[e]}
                    }
                }
                return false
            }

            d.fn[a + "->emulateTransitionEnd"] = function (g) {
                var f = false, e = this;
                d(this).one(d.support.transition.end, function () {
                    f = true
                });
                var h = function () {
                    if (!f) {
                        d(e).trigger(d.support.transition.end)
                    }
                };
                setTimeout(h, g);
                return this
            };
            d(function () {
                d.support.transition = c()
            })
        }(jQuery);
        +function (f) {
            var e = '[data-dismiss="' + a + '-alert"]';
            var d = function (g) {
                f(g).on("click", e, this.close)
            };
            d.prototype.close = function (k) {
                var j = f(this);
                var h = j.attr("data-target");
                if (!h) {
                    h = j.attr("href");
                    h = h && h.replace(/.*(?=#[^\s]*$)/, "")
                }
                var i = f(h);
                if (k) {
                    k.preventDefault()
                }
                if (!i.length) {
                    i = j.hasClass("alert") ? j : j.parent()
                }
                i.trigger(k = f.Event("close." + a + "-bs.alert"));
                if (k.isDefaultPrevented()) {
                    return
                }
                i.removeClass("in");
                function g() {
                    i.trigger("closed." + a + "-bs.alert").remove()
                }

                f.support.transition && i.hasClass("fade") ? i.one(f.support.transition.end, g)[a + "->emulateTransitionEnd"](150) : g()
            };
            var c = f.fn[a + "->alert"];
            f.fn[a + "->alert"] = function (g) {
                return this.each(function () {
                    var i = f(this);
                    var h = i.data(a + "-bs.alert");
                    if (!h) {
                        i.data(a + "-bs.alert", (h = new d(this)))
                    }
                    if (typeof g == "string") {
                        h[g].call(i)
                    }
                })
            };
            f.fn[a + "->alert"].Constructor = d;
            f.fn[a + "->alert"].noConflict = function () {
                f.fn[a + "->alert"] = c;
                return this
            };
            f(document).on("click." + a + "-bs.alert.data-" + a + "-api", "." + a + " " + e, d.prototype.close)
        }(jQuery);
        +function (e) {
            var d = function (g, f) {
                this.$element = e(g);
                this.options = e.extend({}, d.DEFAULTS, f);
                this.isLoading = false
            };
            d.DEFAULTS = {loadingText: "loading..."};
            d.prototype.setState = function (h) {
                var j = "disabled";
                var f = this.$element;
                var i = f.is("input") ? "val" : "html";
                var g = f.data();
                h = h + "Text";
                if (!g.resetText) {
                    f.data("resetText", f[i]())
                }
                f[i](g[h] || this.options[h]);
                setTimeout(e.proxy(function () {
                    if (h == "loadingText") {
                        this.isLoading = true;
                        f.addClass(j).attr(j, j)
                    } else {
                        if (this.isLoading) {
                            this.isLoading = false;
                            f.removeClass(j).removeAttr(j)
                        }
                    }
                }, this), 0)
            };
            d.prototype.toggle = function () {
                var g = true;
                var f = this.$element.closest('[data-toggle="' + a + '-buttons"]');
                if (f.length) {
                    var h = this.$element.find("input");
                    if (h.prop("type") == "radio") {
                        if (h.prop("checked") && this.$element.hasClass("active")) {
                            g = false
                        } else {
                            f.find(".active").removeClass("active")
                        }
                    }
                    if (g) {
                        h.prop("checked", !this.$element.hasClass("active")).trigger("change")
                    }
                }
                if (g) {
                    this.$element.toggleClass("active")
                }
            };
            var c = e.fn[a + "->button"];
            e.fn[a + "->button"] = function (f) {
                return this.each(function () {
                    var i = e(this);
                    var h = i.data(a + "-bs.button");
                    var g = typeof f == "object" && f;
                    if (!h) {
                        i.data(a + "-bs.button", (h = new d(this, g)))
                    }
                    if (f == "toggle") {
                        h.toggle()
                    } else {
                        if (f) {
                            h.setState(f)
                        }
                    }
                })
            };
            e.fn[a + "->button"].Constructor = d;
            e.fn[a + "->button"].noConflict = function () {
                e.fn[a + "->button"] = c;
                return this
            };
            e(document).on("click." + a + "-bs.button.data-" + a + "-api", "." + a + " [data-toggle^=" + a + "-button]", function (g) {
                var f = e(g.target);
                if (!f.hasClass("btn")) {
                    f = f.closest(".btn")
                }
                f[a + "->button"]("toggle");
                g.preventDefault()
            })
        }(jQuery);
        +function (d) {
            var e = function (g, f) {
                this.$element = d(g);
                this.$indicators = this.$element.find(".carousel-indicators");
                this.options = f;
                this.paused = this.sliding = this.interval = this.$active = this.$items = null;
                this.options.pause == "hover" && this.$element.on("mouseenter", d.proxy(this.pause, this)).on("mouseleave", d.proxy(this.cycle, this))
            };
            e.DEFAULTS = {interval: 5000, pause: "hover", wrap: true};
            e.prototype.cycle = function (f) {
                f || (this.paused = false);
                this.interval && clearInterval(this.interval);
                this.options.interval && !this.paused && (this.interval = setInterval(d.proxy(this.next, this), this.options.interval));
                return this
            };
            e.prototype.getActiveIndex = function () {
                this.$active = this.$element.find(".item.active");
                this.$items = this.$active.parent().children();
                return this.$items.index(this.$active)
            };
            e.prototype.to = function (h) {
                var g = this;
                var f = this.getActiveIndex();
                if (h > (this.$items.length - 1) || h < 0) {
                    return
                }
                if (this.sliding) {
                    return this.$element.one("slid." + a + "-bs.carousel", function () {
                        g.to(h)
                    })
                }
                if (f == h) {
                    return this.pause().cycle()
                }
                return this.slide(h > f ? "next" : "prev", d(this.$items[h]))
            };
            e.prototype.pause = function (f) {
                f || (this.paused = true);
                if (this.$element.find(".next, .prev").length && d.support.transition) {
                    this.$element.trigger(d.support.transition.end);
                    this.cycle(true)
                }
                this.interval = clearInterval(this.interval);
                return this
            };
            e.prototype.next = function () {
                if (this.sliding) {
                    return
                }
                return this.slide("next")
            };
            e.prototype.prev = function () {
                if (this.sliding) {
                    return
                }
                return this.slide("prev")
            };
            e.prototype.slide = function (l, g) {
                var n = this.$element.find(".item.active");
                var f = g || n[l]();
                var k = this.interval;
                var m = l == "next" ? "left" : "right";
                var h = l == "next" ? "first" : "last";
                var i = this;
                if (!f.length) {
                    if (!this.options.wrap) {
                        return
                    }
                    f = this.$element.find(".item")[h]()
                }
                if (f.hasClass("active")) {
                    return this.sliding = false
                }
                var j = d.Event("slide." + a + "-bs.carousel", {relatedTarget: f[0], direction: m});
                this.$element.trigger(j);
                if (j.isDefaultPrevented()) {
                    return
                }
                this.sliding = true;
                k && this.pause();
                if (this.$indicators.length) {
                    this.$indicators.find(".active").removeClass("active");
                    this.$element.one("slid." + a + "-bs.carousel", function () {
                        var o = d(i.$indicators.children()[i.getActiveIndex()]);
                        o && o.addClass("active")
                    })
                }
                if (d.support.transition && this.$element.hasClass("slide")) {
                    f.addClass(l);
                    f[0].offsetWidth;
                    n.addClass(m);
                    f.addClass(m);
                    n.one(d.support.transition.end, function () {
                        f.removeClass([l, m].join(" ")).addClass("active");
                        n.removeClass(["active", m].join(" "));
                        i.sliding = false;
                        setTimeout(function () {
                            i.$element.trigger("slid." + a + "-bs.carousel")
                        }, 0)
                    })[a + "->emulateTransitionEnd"](n.css("transition-duration").slice(0, -1) * 1000)
                } else {
                    n.removeClass("active");
                    f.addClass("active");
                    this.sliding = false;
                    this.$element.trigger("slid." + a + "-bs.carousel")
                }
                k && this.cycle();
                return this
            };
            var c = d.fn[a + "->carousel"];
            d.fn[a + "->carousel"] = function (f) {
                return this.each(function () {
                    var j = d(this);
                    var i = j.data(a + "-bs.carousel");
                    var g = d.extend({}, e.DEFAULTS, j.data(), typeof f == "object" && f);
                    var h = typeof f == "string" ? f : g.slide;
                    if (!i) {
                        j.data(a + "-bs.carousel", (i = new e(this, g)))
                    }
                    if (typeof f == "number") {
                        i.to(f)
                    } else {
                        if (h) {
                            i[h]()
                        } else {
                            if (g.interval) {
                                i.pause().cycle()
                            }
                        }
                    }
                })
            };
            d.fn[a + "->carousel"].Constructor = e;
            d.fn[a + "->carousel"].noConflict = function () {
                d.fn[a + "->carousel"] = c;
                return this
            };
            d(document).on("click." + a + "-bs.carousel.data-" + a + "-api", "." + a + " [data-" + a + "-slide], ." + a + " [data-" + a + "-slide-to]", function (k) {
                var j = d(this), g;
                var f = d(j.attr("data-target") || (g = j.attr("href")) && g.replace(/.*(?=#[^\s]+$)/, ""));
                var h = d.extend({}, f.data(), j.data());
                var i = j.attr("data-slide-to");
                if (i) {
                    h.interval = false
                }
                f[a + "->carousel"](h);
                if (i = j.attr("data-slide-to")) {
                    f.data(a + "-bs.carousel").to(i)
                }
                k.preventDefault()
            });
            d(window).on("load", function () {
                d('[data-ride="' + a + '-carousel"]').each(function () {
                    var f = d(this);
                    f[a + "->carousel"](f.data())
                })
            })
        }(jQuery);
        +function (d) {
            var e = function (g, f) {
                this.$element = d(g);
                this.options = d.extend({}, e.DEFAULTS, f);
                this.transitioning = null;
                if (this.options.parent) {
                    this.$parent = d(this.options.parent)
                }
                if (this.options.toggle) {
                    this.toggle()
                }
            };
            e.DEFAULTS = {toggle: true};
            e.prototype.dimension = function () {
                var f = this.$element.hasClass("width");
                return f ? "width" : "height"
            };
            e.prototype.show = function () {
                if (this.transitioning || this.$element.hasClass("in")) {
                    return
                }
                var g = d.Event("show." + a + "-bs.collapse");
                this.$element.trigger(g);
                if (g.isDefaultPrevented()) {
                    return
                }
                var j = this.$parent && this.$parent.find("> .panel > .in");
                if (j && j.length) {
                    var h = j.data(a + "-bs.collapse");
                    if (h && h.transitioning) {
                        return
                    }
                    j[a + "->collapse"]("hide");
                    h || j.data(a + "-bs.collapse", null)
                }
                var k = this.dimension();
                this.$element.removeClass("collapse").addClass("collapsing")[k](0);
                this.transitioning = 1;
                this.$element.prev(".panel-heading").find("> .panel-title i.fa-caret-down").removeClass("fa-caret-down").addClass("fa-caret-up");
                var f = function () {
                    this.$element.removeClass("collapsing").addClass("collapse in")[k]("auto");
                    this.transitioning = 0;
                    this.$element.trigger("shown." + a + "-bs.collapse")
                };
                if (!d.support.transition) {
                    return f.call(this)
                }
                var i = d.camelCase(["scroll", k].join("-"));
                this.$element.one(d.support.transition.end, d.proxy(f, this))[a + "->emulateTransitionEnd"](350)[k](this.$element[0][i])
            };
            e.prototype.hide = function () {
                if (this.transitioning || !this.$element.hasClass("in")) {
                    return
                }
                var g = d.Event("hide." + a + "-bs.collapse");
                this.$element.trigger(g);
                if (g.isDefaultPrevented()) {
                    return
                }
                var h = this.dimension();
                this.$element[h](this.$element[h]())[0].offsetHeight;
                this.$element.addClass("collapsing").removeClass("collapse").removeClass("in");
                this.transitioning = 1;
                this.$element.prev(".panel-heading").find("> .panel-title i.fa-caret-up").removeClass("fa-caret-up").addClass("fa-caret-down");
                var f = function () {
                    this.transitioning = 0;
                    this.$element.trigger("hidden." + a + "-bs.collapse").removeClass("collapsing").addClass("collapse")
                };
                if (!d.support.transition) {
                    return f.call(this)
                }
                this.$element[h](0).one(d.support.transition.end, d.proxy(f, this))[a + "->emulateTransitionEnd"](350)
            };
            e.prototype.toggle = function () {
                this[this.$element.hasClass("in") ? "hide" : "show"]()
            };
            var c = d.fn[a + "->collapse"];
            d.fn[a + "->collapse"] = function (f) {
                return this.each(function () {
                    var i = d(this);
                    var h = i.data(a + "-bs.collapse");
                    var g = d.extend({}, e.DEFAULTS, i.data(), typeof f == "object" && f);
                    if (!h && g.toggle && f == "show") {
                        f = !f
                    }
                    if (!h) {
                        i.data(a + "-bs.collapse", (h = new e(this, g)))
                    }
                    if (typeof f == "string") {
                        h[f]()
                    }
                })
            };
            d.fn[a + "->collapse"].Constructor = e;
            d.fn[a + "->collapse"].noConflict = function () {
                d.fn[a + "->collapse"] = c;
                return this
            };
            d(document).on("click." + a + "-bs.collapse.data-" + a + "-api", "." + a + " [data-toggle=" + a + "-collapse]", function (k) {
                k.preventDefault();
                var m = d(this), f;
                var l = m.attr("data-target") || k.preventDefault() || (f = m.attr("href")) && f.replace(/.*(?=#[^\s]+$)/, "");
                var g = d(l);
                var i = g.data(a + "-bs.collapse");
                var j = i ? "toggle" : m.data();
                var n = m.attr("data-parent");
                var h = n && d(n);
                if (!i || !i.transitioning) {
                    if (h) {
                        h.find("[data-toggle=" + a + '-collapse][data-parent="' + n + '"]').not(m).addClass("collapsed")
                    }
                    m[g.hasClass("in") ? "addClass" : "removeClass"]("collapsed")
                }
                g[a + "->collapse"](j)
            })
        }(jQuery);
        +function (i) {
            var g = "." + a + "-dropdown-backdrop";
            var d = "[data-toggle=" + a + "-dropdown]";
            var c = function (j) {
                i(j).on("click." + a + "-bs.dropdown", this.toggle)
            };
            c.prototype.toggle = function (n) {
                var m = i(this);
                if (m.is(".disabled, :disabled")) {
                    return
                }
                var l = h(m);
                var k = l.hasClass("open");
                f();
                if (!k) {
                    if ("ontouchstart" in document.documentElement && !l.closest(".navbar-nav").length) {
                        i('<div class="dropdown-backdrop"/>').insertAfter(i(this)).on("click", f)
                    }
                    var j = {relatedTarget: this};
                    l.trigger(n = i.Event("show." + a + "-bs.dropdown", j));
                    if (n.isDefaultPrevented()) {
                        return
                    }
                    l.toggleClass("open").trigger("shown." + a + "-bs.dropdown", j);
                    m.focus()
                }
                return false
            };
            c.prototype.keydown = function (n) {
                if (!/(38|40|27)/.test(n.keyCode)) {
                    return
                }
                var m = i(this);
                n.preventDefault();
                n.stopPropagation();
                if (m.is(".disabled, :disabled")) {
                    return
                }
                var l = h(m);
                var k = l.hasClass("open");
                if (!k || (k && n.keyCode == 27)) {
                    if (n.which == 27) {
                        l.find(d).focus()
                    }
                    return m.click()
                }
                var o = " li:not(.divider):visible a";
                var p = l.find("[role=menu]" + o + ", [role=listbox]" + o);
                if (!p.length) {
                    return
                }
                var j = p.index(p.filter(":focus"));
                if (n.keyCode == 38 && j > 0) {
                    j--
                }
                if (n.keyCode == 40 && j < p.length - 1) {
                    j++
                }
                if (!~j) {
                    j = 0
                }
                p.eq(j).focus()
            };
            function f(j) {
                i("." + a + " " + g).remove();
                i("." + a + " " + d).each(function () {
                    var l = h(i(this));
                    var k = {relatedTarget: this};
                    if (!l.hasClass("open")) {
                        return
                    }
                    l.trigger(j = i.Event("hide." + a + "-bs.dropdown", k));
                    if (j.isDefaultPrevented()) {
                        return
                    }
                    l.removeClass("open").trigger("hidden." + a + "-bs.dropdown", k)
                })
            }

            function h(l) {
                var j = l.attr("data-target");
                if (!j) {
                    j = l.attr("href");
                    j = j && /#[A-Za-z]/.test(j) && j.replace(/.*(?=#[^\s]*$)/, "")
                }
                var k = j && i(j);
                return k && k.length ? k : l.parent()
            }

            var e = i.fn[a + "->dropdown"];
            i.fn[a + "->dropdown"] = function (j) {
                return this.each(function () {
                    var l = i(this);
                    var k = l.data(a + "-bs.dropdown");
                    if (!k) {
                        l.data(a + "-bs.dropdown", (k = new c(this)))
                    }
                    if (typeof j == "string") {
                        k[j].call(l)
                    }
                })
            };
            i.fn[a + "->dropdown"].Constructor = c;
            i.fn[a + "->dropdown"].noConflict = function () {
                i.fn[a + "->dropdown"] = e;
                return this
            };
            i(document).on("click." + a + "-bs.dropdown.data-" + a + "-api", f).on("click." + a + "-bs.dropdown.data-" + a + "-api", "." + a + " .dropdown form", function (j) {
                j.stopPropagation()
            }).on("click." + a + "-bs.dropdown.data-" + a + "-api", "." + a + " " + d, c.prototype.toggle).on("keydown." + a + "-bs.dropdown.data-" + a + "-api", "." + a + " " + d + ", ." + a + " [role=menu], ." + a + " [role=listbox]", c.prototype.keydown);
            i(window).on("load", function () {
                if (typeof i.fn.dropdown === "function" && typeof i.fn.dropdown.Constructor.prototype.keydown === "function" && typeof i.fn.emulateTransitionEnd === "function") {
                    i(document).off("keydown.bs.dropdown.data-api").on("keydown.bs.dropdown.data-api", "[data-toggle=dropdown], [role=menu]:not(." + a + " [role=menu]), [role=listbox]:not(." + a + " [role=listbox])", i.fn.dropdown.Constructor.prototype.keydown)
                }
            })
        }(jQuery);
        +function (e) {
            var d = function (g, f) {
                this.options = f;
                this.$element = e(g);
                this.$backdrop = this.isShown = null;
                if (this.options.remote) {
                    this.$element.find(".modal-content").load(this.options.remote, e.proxy(function () {
                        this.$element.trigger("loaded." + a + "-bs.modal")
                    }, this))
                }
            };
            d.DEFAULTS = {backdrop: true, keyboard: true, show: true};
            d.prototype.toggle = function (f) {
                return this[!this.isShown ? "show" : "hide"](f)
            };
            d.prototype.show = function (h) {
                var f = this;
                var g = e.Event("show." + a + "-bs.modal", {relatedTarget: h});
                this.$element.trigger(g);
                if (this.isShown || g.isDefaultPrevented()) {
                    return
                }
                this.isShown = true;
                this.escape();
                this.$element.on("click.dismiss." + a + "-bs.modal", '[data-dismiss="' + a + '-modal"]', e.proxy(this.hide, this));
                this.backdrop(function () {
                    var j = e.support.transition && f.$element.hasClass("fade");
                    if (!f.$element.parent().length) {
                        f.$element.appendTo(document.body)
                    }
                    f.$element.show().scrollTop(0);
                    if (j) {
                        f.$element[0].offsetWidth
                    }
                    f.$element.addClass("in").attr("aria-hidden", false);
                    f.enforceFocus();
                    var i = e.Event("shown." + a + "-bs.modal", {relatedTarget: h});
                    j ? f.$element.find(".modal-dialog").one(e.support.transition.end, function () {
                        f.$element.focus().trigger(i)
                    })[a + "->emulateTransitionEnd"](300) : f.$element.focus().trigger(i)
                })
            };
            d.prototype.hide = function (f) {
                if (f) {
                    f.preventDefault()
                }
                f = e.Event("hide." + a + "-bs.modal");
                this.$element.trigger(f);
                if (!this.isShown || f.isDefaultPrevented()) {
                    return
                }
                this.isShown = false;
                this.escape();
                e(document).off("focusin." + a + "-bs.modal");
                this.$element.removeClass("in").attr("aria-hidden", true).off("click.dismiss." + a + "-bs.modal");
                e.support.transition && this.$element.hasClass("fade") ? this.$element.one(e.support.transition.end, e.proxy(this.hideModal, this))[a + "->emulateTransitionEnd"](300) : this.hideModal()
            };
            d.prototype.enforceFocus = function () {
                e(document).off("focusin." + a + "-bs.modal").on("focusin." + a + "-bs.modal", e.proxy(function (f) {
                    if (this.$element[0] !== f.target && !this.$element.has(f.target).length) {
                        this.$element.focus()
                    }
                }, this))
            };
            d.prototype.escape = function () {
                if (this.isShown && this.options.keyboard) {
                    this.$element.on("keyup.dismiss." + a + "-bs.modal", e.proxy(function (f) {
                        f.which == 27 && this.hide()
                    }, this))
                } else {
                    if (!this.isShown) {
                        this.$element.off("keyup.dismiss." + a + "-bs.modal")
                    }
                }
            };
            d.prototype.hideModal = function () {
                var f = this;
                this.$element.hide();
                this.backdrop(function () {
                    f.removeBackdrop();
                    f.$element.trigger("hidden." + a + "-bs.modal")
                })
            };
            d.prototype.removeBackdrop = function () {
                this.$backdrop && this.$backdrop.remove();
                this.$backdrop = null
            };
            d.prototype.backdrop = function (h) {
                var g = this.$element.hasClass("fade") ? "fade" : "";
                if (this.isShown && this.options.backdrop) {
                    var f = e.support.transition && g;
                    this.$backdrop = e('<div class="' + a + "-modal-backdrop " + g + '" />').appendTo(document.body);
                    this.$element.on("click.dismiss." + a + "-bs.modal", e.proxy(function (i) {
                        if (i.target !== i.currentTarget) {
                            return
                        }
                        this.options.backdrop == "static" ? this.$element[0].focus.call(this.$element[0]) : this.hide.call(this)
                    }, this));
                    if (f) {
                        this.$backdrop[0].offsetWidth
                    }
                    this.$backdrop.addClass("in");
                    if (!h) {
                        return
                    }
                    f ? this.$backdrop.one(e.support.transition.end, h)[a + "->emulateTransitionEnd"](150) : h()
                } else {
                    if (!this.isShown && this.$backdrop) {
                        this.$backdrop.removeClass("in");
                        e.support.transition && this.$element.hasClass("fade") ? this.$backdrop.one(e.support.transition.end, h)[a + "->emulateTransitionEnd"](150) : h()
                    } else {
                        if (h) {
                            h()
                        }
                    }
                }
            };
            var c = e.fn[a + "->modal"];
            e.fn[a + "->modal"] = function (f, g) {
                return this.each(function () {
                    var j = e(this);
                    var i = j.data(a + "-bs.modal");
                    var h = e.extend({}, d.DEFAULTS, j.data(), typeof f == "object" && f);
                    if (!i) {
                        j.data(a + "-bs.modal", (i = new d(this, h)))
                    }
                    if (typeof f == "string") {
                        i[f](g)
                    } else {
                        if (h.show) {
                            i.show(g)
                        }
                    }
                })
            };
            e.fn[a + "->modal"].Constructor = d;
            e.fn[a + "->modal"].noConflict = function () {
                e.fn[a + "->modal"] = c;
                return this
            };
            e(document).on("click." + a + "-bs.modal.data-" + a + "-api", "." + a + ' [data-toggle="' + a + '-modal"]', function (j) {
                var i = e(this);
                var g = i.attr("href");
                var f = e(i.attr("data-target") || (g && g.replace(/.*(?=#[^\s]+$)/, "")));
                var h = f.data(a + "-bs.modal") ? "toggle" : e.extend({remote: !/#/.test(g) && g}, f.data(), i.data());
                if (i.is("a")) {
                    j.preventDefault()
                }
                f[a + "->modal"](h, this).one("hide", function () {
                    i.is(":visible") && i.focus()
                })
            });
            e(document).on("show." + a + "-bs.modal", "." + a + " .modal", function () {
                e(document.body).addClass(a + "-modal-open")
            }).on("hidden." + a + "-bs.modal", "." + a + " .modal", function () {
                e(document.body).removeClass(a + "-modal-open")
            });
            e(document).on("ready", function () {
                var f = "." + a + "-modal-open{overflow:hidden}";
                f += "." + a + "-modal-backdrop{position:fixed;top:0;right:0;bottom:0;left:0;z-index:1040;background-color:#000}." + a + "-modal-backdrop.fade{opacity:0;filter:alpha(opacity=0)}." + a + "-modal-backdrop.in{opacity:.5;filter:alpha(opacity=50)}";
                e("body").append('<style type="text/css">' + f + "</style>")
            })
        }(jQuery);
        +function (e) {
            var d = function (g, f) {
                this.type = this.options = this.enabled = this.timeout = this.hoverState = this.$element = null;
                this.init("tooltip", g, f)
            };
            d.DEFAULTS = {
                animation: true,
                placement: "top",
                selector: false,
                template: '<div class="tooltip"><div class="tooltip-arrow"></div><div class="tooltip-inner"></div></div>',
                trigger: "hover focus",
                title: "",
                delay: 0,
                html: false,
                container: false
            };
            d.prototype.init = function (m, k, h) {
                this.enabled = true;
                this.type = m;
                this.$element = e(k);
                this.options = this.getOptions(h);
                var l = this.options.trigger.split(" ");
                for (var j = l.length; j--;) {
                    var g = l[j];
                    if (g == "click") {
                        this.$element.on("click." + this.type, this.options.selector, e.proxy(this.toggle, this))
                    } else {
                        if (g != "manual") {
                            var n = g == "hover" ? "mouseenter" : "focusin";
                            var f = g == "hover" ? "mouseleave" : "focusout";
                            this.$element.on(n + "." + this.type, this.options.selector, e.proxy(this.enter, this));
                            this.$element.on(f + "." + this.type, this.options.selector, e.proxy(this.leave, this))
                        }
                    }
                }
                this.options.selector ? (this._options = e.extend({}, this.options, {
                    trigger: "manual",
                    selector: ""
                })) : this.fixTitle()
            };
            d.prototype.getDefaults = function () {
                return d.DEFAULTS
            };
            d.prototype.getOptions = function (f) {
                f = e.extend({}, this.getDefaults(), this.$element.data(), f);
                if (f.delay && typeof f.delay == "number") {
                    f.delay = {show: f.delay, hide: f.delay}
                }
                return f
            };
            d.prototype.getDelegateOptions = function () {
                var f = {};
                var g = this.getDefaults();
                this._options && e.each(this._options, function (h, i) {
                    if (g[h] != i) {
                        f[h] = i
                    }
                });
                return f
            };
            d.prototype.enter = function (g) {
                var f = g instanceof this.constructor ? g : e(g.currentTarget)[this.type](this.getDelegateOptions()).data(a + "-bs." + this.type);
                clearTimeout(f.timeout);
                f.hoverState = "in";
                if (!f.options.delay || !f.options.delay.show) {
                    return f.show()
                }
                f.timeout = setTimeout(function () {
                    if (f.hoverState == "in") {
                        f.show()
                    }
                }, f.options.delay.show)
            };
            d.prototype.leave = function (g) {
                var f = g instanceof this.constructor ? g : e(g.currentTarget)[this.type](this.getDelegateOptions()).data(a + "-bs." + this.type);
                clearTimeout(f.timeout);
                f.hoverState = "out";
                if (!f.options.delay || !f.options.delay.hide) {
                    return f.hide()
                }
                f.timeout = setTimeout(function () {
                    if (f.hoverState == "out") {
                        f.hide()
                    }
                }, f.options.delay.hide)
            };
            d.prototype.show = function () {
                var q = e.Event("show." + a + "-bs." + this.type);
                if (this.hasContent() && this.enabled) {
                    this.$element.trigger(q);
                    if (q.isDefaultPrevented()) {
                        return
                    }
                    var p = this;
                    var l = this.tip();
                    this.setContent();
                    if (this.options.animation) {
                        l.addClass("fade")
                    }
                    var k = typeof this.options.placement == "function" ? this.options.placement.call(this, l[0], this.$element[0]) : this.options.placement;
                    var u = /\s?auto?\s?/i;
                    var v = u.test(k);
                    if (v) {
                        k = k.replace(u, "") || "top"
                    }
                    l.detach().css({top: 0, left: 0, display: "block"}).addClass(k);
                    this.options.container ? l.appendTo(this.options.container) : l.insertAfter(this.$element);
                    var r = this.getPosition();
                    var f = l[0].offsetWidth;
                    var n = l[0].offsetHeight;
                    if (v) {
                        var j = this.$element.parent();
                        var i = k;
                        var s = document.documentElement.scrollTop || document.body.scrollTop;
                        var t = this.options.container == "body" ? window.innerWidth : j.outerWidth();
                        var o = this.options.container == "body" ? window.innerHeight : j.outerHeight();
                        var m = this.options.container == "body" ? 0 : j.offset().left;
                        k = k == "bottom" && r.top + r.height + n - s > o ? "top" : k == "top" && r.top - s - n < 0 ? "bottom" : k == "right" && r.right + f > t ? "left" : k == "left" && r.left - f < m ? "right" : k;
                        l.removeClass(i).addClass(k)
                    }
                    var h = this.getCalculatedOffset(k, r, f, n);
                    this.applyPlacement(h, k);
                    this.hoverState = null;
                    var g = function () {
                        p.$element.trigger("shown." + a + "-bs." + p.type)
                    };
                    e.support.transition && this.$tip.hasClass("fade") ? l.one(e.support.transition.end, g)[a + "->emulateTransitionEnd"](150) : g()
                }
            };
            d.prototype.applyPlacement = function (k, l) {
                var i;
                var m = this.tip();
                var h = m[0].offsetWidth;
                var p = m[0].offsetHeight;
                var g = parseInt(m.css("margin-top"), 10);
                var j = parseInt(m.css("margin-left"), 10);
                if (isNaN(g)) {
                    g = 0
                }
                if (isNaN(j)) {
                    j = 0
                }
                k.top = k.top + g;
                k.left = k.left + j;
                e.offset.setOffset(m[0], e.extend({
                    using: function (q) {
                        m.css({top: Math.round(q.top), left: Math.round(q.left)})
                    }
                }, k), 0);
                m.addClass("in");
                var f = m[0].offsetWidth;
                var n = m[0].offsetHeight;
                if (l == "top" && n != p) {
                    i = true;
                    k.top = k.top + p - n
                }
                if (/bottom|top/.test(l)) {
                    var o = 0;
                    if (k.left < 0) {
                        o = k.left * -2;
                        k.left = 0;
                        m.offset(k);
                        f = m[0].offsetWidth;
                        n = m[0].offsetHeight
                    }
                    this.replaceArrow(o - h + f, f, "left")
                } else {
                    this.replaceArrow(n - p, n, "top")
                }
                if (i) {
                    m.offset(k)
                }
            };
            d.prototype.replaceArrow = function (h, g, f) {
                this.arrow().css(f, h ? (50 * (1 - h / g) + "%") : "")
            };
            d.prototype.setContent = function () {
                var g = this.tip();
                var f = this.getTitle();
                g.find(".tooltip-inner")[this.options.html ? "html" : "text"](f);
                g.removeClass("fade in top bottom left right")
            };
            d.prototype.hide = function () {
                var g = this;
                var i = this.tip();
                var h = e.Event("hide." + a + "-bs." + this.type);

                function f() {
                    if (g.hoverState != "in") {
                        i.detach()
                    }
                    g.$element.trigger("hidden." + a + "-bs." + g.type)
                }

                this.$element.trigger(h);
                if (h.isDefaultPrevented()) {
                    return
                }
                i.removeClass("in");
                e.support.transition && this.$tip.hasClass("fade") ? i.one(e.support.transition.end, f)[a + "->emulateTransitionEnd"](150) : f();
                this.hoverState = null;
                return this
            };
            d.prototype.fixTitle = function () {
                var f = this.$element;
                if (f.attr("title") || typeof(f.attr("data-original-title")) != "string") {
                    f.attr("data-original-title", f.attr("title") || "").attr("title", "")
                }
            };
            d.prototype.hasContent = function () {
                return this.getTitle()
            };
            d.prototype.getPosition = function () {
                var f = this.$element[0];
                return e.extend({}, (typeof f.getBoundingClientRect == "function") ? f.getBoundingClientRect() : {
                    width: f.offsetWidth,
                    height: f.offsetHeight
                }, this.$element.offset())
            };
            d.prototype.getCalculatedOffset = function (f, i, g, h) {
                return f == "bottom" ? {
                    top: i.top + i.height,
                    left: i.left + i.width / 2 - g / 2
                } : f == "top" ? {
                    top: i.top - h,
                    left: i.left + i.width / 2 - g / 2
                } : f == "left" ? {
                    top: i.top + i.height / 2 - h / 2,
                    left: i.left - g
                } : {top: i.top + i.height / 2 - h / 2, left: i.left + i.width}
            };
            d.prototype.getTitle = function () {
                var h;
                var f = this.$element;
                var g = this.options;
                h = f.attr("data-original-title") || (typeof g.title == "function" ? g.title.call(f[0]) : g.title);
                return h
            };
            d.prototype.tip = function () {
                return this.$tip = this.$tip || e(this.options.template)
            };
            d.prototype.arrow = function () {
                return this.$arrow = this.$arrow || this.tip().find(".tooltip-arrow")
            };
            d.prototype.validate = function () {
                if (!this.$element[0].parentNode) {
                    this.hide();
                    this.$element = null;
                    this.options = null
                }
            };
            d.prototype.enable = function () {
                this.enabled = true
            };
            d.prototype.disable = function () {
                this.enabled = false
            };
            d.prototype.toggleEnabled = function () {
                this.enabled = !this.enabled
            };
            d.prototype.toggle = function (g) {
                var f = g ? e(g.currentTarget)[this.type](this.getDelegateOptions()).data(a + "-bs." + this.type) : this;
                f.tip().hasClass("in") ? f.leave(f) : f.enter(f)
            };
            d.prototype.destroy = function () {
                clearTimeout(this.timeout);
                this.hide().$element.off("." + this.type).removeData(a + "-bs." + this.type)
            };
            var c = e.fn[a + "->tooltip"];
            e.fn[a + "->tooltip"] = function (f) {
                return this.each(function () {
                    var i = e(this);
                    var h = i.data(a + "-bs.tooltip");
                    var g = typeof f == "object" && f;
                    if (!h && f == "destroy") {
                        return
                    }
                    if (!h) {
                        i.data(a + "-bs.tooltip", (h = new d(this, g)))
                    }
                    if (typeof f == "string") {
                        h[f]()
                    }
                })
            };
            e.fn[a + "->tooltip"].Constructor = d;
            e.fn[a + "->tooltip"].noConflict = function () {
                e.fn[a + "->tooltip"] = c;
                return this
            }
        }(jQuery);
        +function (e) {
            var d = function (g, f) {
                this.init("popover", g, f)
            };
            if (!e.fn[a + "->tooltip"]) {
                throw new Error("Popover requires the tooltip extension.")
            }
            d.DEFAULTS = e.extend({}, e.fn[a + "->tooltip"].Constructor.DEFAULTS, {
                placement: "right",
                trigger: "click",
                content: "",
                template: '<div class="popover"><div class="arrow"></div><h3 class="popover-title"></h3><div class="popover-content"></div></div>'
            });
            d.prototype = e.extend({}, e.fn[a + "->tooltip"].Constructor.prototype);
            d.prototype.constructor = d;
            d.prototype.getDefaults = function () {
                return d.DEFAULTS
            };
            d.prototype.setContent = function () {
                var h = this.tip();
                var g = this.getTitle();
                var f = this.getContent();
                h.find(".popover-title")[this.options.html ? "html" : "text"](g);
                h.find(".popover-content")[this.options.html ? (typeof f == "string" ? "html" : "append") : "text"](f);
                h.removeClass("fade top bottom left right in");
                if (!h.find(".popover-title").html()) {
                    h.find(".popover-title").hide()
                }
            };
            d.prototype.hasContent = function () {
                return this.getTitle() || this.getContent()
            };
            d.prototype.getContent = function () {
                var f = this.$element;
                var g = this.options;
                return f.attr("data-content") || (typeof g.content == "function" ? g.content.call(f[0]) : g.content)
            };
            d.prototype.arrow = function () {
                return this.$arrow = this.$arrow || this.tip().find(".arrow")
            };
            d.prototype.tip = function () {
                if (!this.$tip) {
                    this.$tip = e(this.options.template)
                }
                return this.$tip
            };
            var c = e.fn[a + "->popover"];
            e.fn[a + "->popover"] = function (f) {
                return this.each(function () {
                    var i = e(this);
                    var h = i.data(a + "-bs.popover");
                    var g = typeof f == "object" && f;
                    if (!h && f == "destroy") {
                        return
                    }
                    if (!h) {
                        i.data(a + "-bs.popover", (h = new d(this, g)))
                    }
                    if (typeof f == "string") {
                        h[f]()
                    }
                })
            };
            e.fn[a + "->popover"].Constructor = d;
            e.fn[a + "->popover"].noConflict = function () {
                e.fn[a + "->popover"] = c;
                return this
            }
        }(jQuery);
        +function (e) {
            var d = function (f) {
                this.element = e(f)
            };
            d.prototype.show = function () {
                var k = this.element;
                var h = k.closest("ul:not(.dropdown-menu)");
                var g = k.data("target");
                if (!g) {
                    g = k.attr("href");
                    g = g && g.replace(/.*(?=#[^\s]*$)/, "")
                }
                if (k.parent("li").hasClass("active")) {
                    return
                }
                var i = h.find(".active:last a")[0];
                var j = e.Event("show." + a + "-bs.tab", {relatedTarget: i});
                k.trigger(j);
                if (j.isDefaultPrevented()) {
                    return
                }
                var f = e(g);
                this.activate(k.parent("li"), h);
                this.activate(f, f.parent(), function () {
                    k.trigger({type: "shown." + a + "-bs.tab", relatedTarget: i})
                })
            };
            d.prototype.activate = function (h, g, k) {
                var f = g.find("> .active");
                var j = k && e.support.transition && f.hasClass("fade");

                function i() {
                    f.removeClass("active").find("> .dropdown-menu > .active").removeClass("active");
                    h.addClass("active");
                    if (j) {
                        h[0].offsetWidth;
                        h.addClass("in")
                    } else {
                        h.removeClass("fade")
                    }
                    if (h.parent(".dropdown-menu")) {
                        h.closest("li.dropdown").addClass("active")
                    }
                    k && k()
                }

                j ? f.one(e.support.transition.end, i)[a + "->emulateTransitionEnd"](150) : i();
                f.removeClass("in")
            };
            var c = e.fn[a + "->tab"];
            e.fn[a + "->tab"] = function (f) {
                return this.each(function () {
                    var h = e(this);
                    var g = h.data(a + "-bs.tab");
                    if (!g) {
                        h.data(a + "-bs.tab", (g = new d(this)))
                    }
                    if (typeof f == "string") {
                        g[f]()
                    }
                })
            };
            e.fn[a + "->tab"].Constructor = d;
            e.fn[a + "->tab"].noConflict = function () {
                e.fn[a + "->tab"] = c;
                return this
            };
            e(document).on("click." + a + "-bs.tab.data-" + a + "-api", "." + a + ' [data-toggle="' + a + '-tab"], .' + a + ' [data-toggle="' + a + '-pill"]', function (f) {
                f.preventDefault();
                e(this)[a + "->tab"]("show")
            })
        }(jQuery);
        +function (e) {
            var d = function (g, f) {
                this.options = e.extend({}, d.DEFAULTS, f);
                this.$window = e(window).on("scroll." + a + "-bs.affix.data-" + a + "-api", e.proxy(this.checkPosition, this)).on("click." + a + "-bs.affix.data-" + a + "-api", e.proxy(this.checkPositionWithEventLoop, this));
                this.$element = e(g);
                this.affixed = this.unpin = this.pinnedOffset = null;
                this.checkPosition()
            };
            d.RESET = "affix affix-top affix-bottom";
            d.DEFAULTS = {offset: 0};
            d.prototype.getPinnedOffset = function () {
                if (this.pinnedOffset) {
                    return this.pinnedOffset
                }
                this.$element.removeClass(d.RESET).addClass("affix");
                var g = this.$window.scrollTop();
                var f = this.$element.offset();
                return (this.pinnedOffset = f.top - g)
            };
            d.prototype.checkPositionWithEventLoop = function () {
                setTimeout(e.proxy(this.checkPosition, this), 1)
            };
            d.prototype.checkPosition = function () {
                if (!this.$element.is(":visible")) {
                    return
                }
                var n = e(document).height();
                var f = this.$window.scrollTop();
                var k = this.$element.offset();
                var i = this.options.offset;
                var g = i.top;
                var h = i.bottom;
                if (this.affixed == "top") {
                    k.top += f
                }
                if (typeof i != "object") {
                    h = g = i
                }
                if (typeof g == "function") {
                    g = i.top(this.$element)
                }
                if (typeof h == "function") {
                    h = i.bottom(this.$element)
                }
                var j = this.unpin != null && (f + this.unpin <= k.top) ? false : h != null && (k.top + this.$element.height() >= n - h) ? "bottom" : g != null && (f <= g) ? "top" : false;
                if (this.affixed === j) {
                    return
                }
                if (this.unpin) {
                    this.$element.css("top", "")
                }
                var m = "affix" + (j ? "-" + j : "");
                var l = e.Event(m + "." + a + "-bs.affix");
                this.$element.trigger(l);
                if (l.isDefaultPrevented()) {
                    return
                }
                this.affixed = j;
                this.unpin = j == "bottom" ? this.getPinnedOffset() : null;
                this.$element.removeClass(d.RESET).addClass(m).trigger(e.Event(m.replace("affix", "affixed")));
                if (j == "bottom") {
                    this.$element.offset({top: n - h - this.$element.height()})
                }
            };
            var c = e.fn[a + "->affix"];
            e.fn[a + "->affix"] = function (f) {
                return this.each(function () {
                    var i = e(this);
                    var h = i.data(a + "-bs.affix");
                    var g = typeof f == "object" && f;
                    if (!h) {
                        i.data(a + "-bs.affix", (h = new d(this, g)))
                    }
                    if (typeof f == "string") {
                        h[f]()
                    }
                })
            };
            e.fn[a + "->affix"].Constructor = d;
            e.fn[a + "->affix"].noConflict = function () {
                e.fn[a + "->affix"] = c;
                return this
            };
            e(window).on("load", function () {
                e("." + a + ' [data-spy="' + a + '-affix"]').each(function () {
                    var g = e(this);
                    var f = g.data();
                    f.offset = f.offset || {};
                    if (f.offsetBottom) {
                        f.offset.bottom = f.offsetBottom
                    }
                    if (f.offsetTop) {
                        f.offset.top = f.offsetTop
                    }
                    g[a + "->affix"](f)
                })
            })
        }(jQuery)
    }
})(jQuery, "xd-v141226-dev");
/*!
 * WebSharks Core™; copyright 2014 WebSharks, Inc.
 * GPL license <https://github.com/websharks/core>
 */
(function (b) {
    window.$$xd_v141226_dev = window.$$xd_v141226_dev || {};
    var a = window.$$xd_v141226_dev;
    if (typeof a.$$ === "function") {
        return
    }
    a.$$ = function (d, e) {
        var c = "xd_v141226_dev";
        if (typeof d !== "string" || !d) {
            d = c
        }
        if (typeof e !== "string" || !e) {
            e = "$"
        }
        this.___is_type_checks = {
            string: "is_string",
            "!string": "is_string",
            "string:!empty": "is_string",
            "boolean": "is_boolean",
            "!boolean": "is_boolean",
            "boolean:!empty": "is_boolean",
            bool: "is_boolean",
            "!bool": "is_boolean",
            "bool:!empty": "is_boolean",
            integer: "is_integer",
            "!integer": "is_integer",
            "integer:!empty": "is_integer",
            "float": "is_float",
            "!float": "is_float",
            "float:!empty": "is_float",
            number: "is_number",
            "!number": "is_number",
            "number:!empty": "is_number",
            numeric: "is_numeric",
            "!numeric": "is_numeric",
            "numeric:!empty": "is_numeric",
            array: "is_array",
            "!array": "is_array",
            "array:!empty": "is_array",
            "function": "is_function",
            "!function": "is_function",
            "function:!empty": "is_function",
            xml: "is_xml",
            "!xml": "is_xml",
            "xml:!empty": "is_xml",
            object: "is_object",
            "!object": "is_object",
            "object:!empty": "is_object",
            "null": "is_null",
            "!null": "is_null",
            "null:!empty": "is_null",
            "undefined": "is_undefined",
            "!undefined": "is_undefined",
            "undefined:!empty": "is_undefined"
        };
        this.___public_type = "___public_type___";
        this.___protected_type = "___protected_type___";
        this.___private_type = "___private_type___";
        this.cache = {};
        this.___plugin_root_namespaces = [];
        if (d === c && e === "$") {
            if (typeof window["$" + c + "___plugin_root_namespaces"] === "object") {
                if (window["$" + c + "___plugin_root_namespaces"] instanceof Array) {
                    this.___plugin_root_namespaces = window["$" + c + "___plugin_root_namespaces"]
                }
            }
        }
        this.___instance = {plugin_js_extension_ns: e};
        if (typeof window["$" + c + "___instance"] === "object") {
            b.extend(this.___instance, window["$" + c + "___instance"])
        }
        if (typeof window["$" + d + "___instance"] === "object") {
            b.extend(this.___instance, window["$" + d + "___instance"])
        }
        this.___i18n = {};
        if (typeof window["$" + c + "___i18n"] === "object") {
            b.extend(this.___i18n, window["$" + c + "___i18n"])
        }
        if (typeof window["$" + c + "__" + e + "___i18n"] === "object") {
            b.extend(this.___i18n, window["$" + c + "__" + e + "___i18n"])
        }
        if (typeof window["$" + d + "___i18n"] === "object") {
            b.extend(this.___i18n, window["$" + d + "___i18n"])
        }
        if (typeof window["$" + d + "__" + e + "___i18n"] === "object") {
            b.extend(this.___i18n, window["$" + d + "__" + e + "___i18n"])
        }
        this.___verifiers = {};
        if (typeof window["$" + d + "___verifiers"] === "object") {
            b.extend(this.___verifiers, window["$" + d + "___verifiers"])
        }
        if (typeof window["$" + d + "__" + e + "___verifiers"] === "object") {
            b.extend(this.___verifiers, window["$" + d + "__" + e + "___verifiers"])
        }
    };
    a.$$.prototype.extension_class = function (c, d) {
        this.check_arg_types("string", "string:!empty", arguments, 2);
        if (!this.is_default_core_extension()) {
            throw this.sprintf(this.__("core_only_failure"), "extension_class")
        }
        if (c && c !== this.instance("core_ns")) {
            window["$$" + c] = window["$$" + c] || {};
            window["$$" + c]["$$" + d] = function () {
            };
            window["$$" + c]["$$" + d].prototype = new a.$$(c, d);
            window["$$" + c]["$$" + d].prototype.constructor = window["$$" + c]["$$" + d];
            return window["$$" + c]["$$" + d]
        } else {
            if (d !== "$") {
                a["$$" + d] = function () {
                };
                a["$$" + d].prototype = new a.$$("", d);
                a["$$" + d].prototype.constructor = a["$$" + d];
                return a["$$" + d]
            }
        }
        throw"extension === $"
    };
    a.$$.prototype.instance = function (c) {
        if (typeof this.___instance[c] === "string") {
            return this.___instance[c]
        }
        throw this.sprintf(this.__("instance__failure"), c)
    };
    a.$$.prototype.core = function (c) {
        if (!this.cache.core_ns_with_dashes) {
            this.cache.core_ns_with_dashes = this.instance("core_ns_with_dashes")
        }
        return this.cache.core_ns_with_dashes + c
    };
    a.$$.prototype.sprintf = function () {
        return window[this.core("->sprintf")].apply(window, arguments)
    };
    a.$$.prototype.vsprintf = function () {
        return window[this.core("->vsprintf")].apply(window, arguments)
    };
    a.$$.prototype.verifier = function (c) {
        if (typeof this.___verifiers[c] === "string") {
            return this.___verifiers[c]
        }
        throw this.sprintf(this.__("verifier__failure"), c)
    };
    a.$$.prototype.__ = function (c) {
        if (typeof this.___i18n[c] === "string") {
            return this.___i18n[c]
        }
        throw this.sprintf(this.___i18n.____failure, c)
    };
    a.$$.prototype.is_string = function (c) {
        return (typeof c === "string")
    };
    a.$$.prototype.is_boolean = function (c) {
        return (typeof c === "boolean")
    };
    a.$$.prototype.is_integer = function (c) {
        return (typeof c === "number" && !isNaN(c) && String(c).indexOf(".") === -1)
    };
    a.$$.prototype.is_float = function (c) {
        return (typeof c === "number" && !isNaN(c) && String(c).indexOf(".") !== -1)
    };
    a.$$.prototype.is_number = function (c) {
        return (typeof c === "number" && !isNaN(c))
    };
    a.$$.prototype.is_numeric = function (c) {
        return ((typeof(c) === "number" || typeof(c) === "string") && c !== "" && !isNaN(c))
    };
    a.$$.prototype.is_array = function (c) {
        return (c instanceof Array)
    };
    a.$$.prototype.is_function = function (c) {
        return (typeof c === "function")
    };
    a.$$.prototype.is_xml = function (c) {
        return (typeof c === "xml")
    };
    a.$$.prototype.is_object = function (c) {
        return (typeof c === "object")
    };
    a.$$.prototype.is_null = function (c) {
        return (typeof c === "null")
    };
    a.$$.prototype.is_undefined = function (c) {
        return (typeof c === "undefined")
    };
    a.$$.prototype.isset = function () {
        for (var c = 0; c < arguments.length; c++) {
            if (arguments[c] === undefined || arguments[c] === null) {
                return false
            }
        }
        return true
    };
    a.$$.prototype.empty = function () {
        empty:for (var d = 0, c; d < arguments.length; d++) {
            if (arguments[d] === "" || arguments[d] === 0 || arguments[d] === "0" || arguments[d] === null || arguments[d] === false) {
                return true
            } else {
                if (typeof arguments[d] === "undefined") {
                    return true
                } else {
                    if (arguments[d] instanceof Array && !arguments[d].length) {
                        return true
                    } else {
                        if (typeof arguments[d] == "object") {
                            for (c in arguments[d]) {
                                continue empty
                            }
                            return true
                        }
                    }
                }
            }
        }
        return false
    };
    a.$$.prototype.is_default_core_extension = function () {
        return (this.instance("plugin_root_ns") === this.instance("core_ns") && this.instance("plugin_js_extension_ns") === "$")
    };
    a.$$.prototype.preg_quote = function (d, c) {
        this.check_arg_types("string", "string", arguments, 1);
        c = c ? "\\" + c : "";
        return d.replace(new RegExp("[.\\\\+*?[\\^\\]$(){}=!<>|:\\-" + c + "]", "g"), "\\$&")
    };
    a.$$.prototype.esc_html = a.$$.prototype.esc_attr = function (c) {
        this.check_arg_types("string", arguments, 1);
        if (/[&<>"']/.test(c)) {
            c = c.replace(/&/g, "&amp;");
            c = c.replace(/</g, "&lt;").replace(/>/g, "&gt;");
            c = c.replace(/"/g, "&quot;").replace(/'/g, "&#039;")
        }
        return c
    };
    a.$$.prototype.esc_jq_attr = function (c) {
        this.check_arg_types("string", arguments, 1);
        return c.replace(/([.:\[\]])/g, "\\$1")
    };
    a.$$.prototype.with_dashes = function (c) {
        this.check_arg_types("string", arguments, 1);
        c = c.replace(/\\/g, "--");
        c = c.replace(/[^a-z0-9]/gi, "-");
        return c
    };
    a.$$.prototype.with_underscores = function (c) {
        this.check_arg_types("string", arguments, 1);
        c = c.replace(/\\/g, "__");
        c = c.replace(/[^a-z0-9]/gi, "_");
        return c
    };
    a.$$.prototype.browser = function () {
        if (this.cache.browser) {
            return this.cache.browser
        }
        var d = function () {
            var f = navigator.userAgent.toLowerCase();
            var e = /(chrome)[ \/]([\w.]+)/.exec(f) || /(webkit)[ \/]([\w.]+)/.exec(f) || /(opera)(?:.*version|)[ \/]([\w.]+)/.exec(f) || /(msie) ([\w.]+)/.exec(f) || f.indexOf("compatible") === -1 && /(mozilla)(?:.*? rv:([\w.]+)|)/.exec(f) || [];
            return {browser: e[1] || "", version: e[2] || "0"}
        };
        var c = d();
        this.cache.browser = {};
        if (c.browser) {
            this.cache.browser[c.browser] = true;
            this.cache.browser.version = c.version
        }
        if (this.cache.browser.chrome) {
            this.cache.browser.webkit = true
        } else {
            if (this.cache.browser.webkit) {
                this.cache.browser.safari = true
            }
        }
        return this.cache.browser
    };
    a.$$.prototype.closest_theme_class_to = function (d) {
        this.check_arg_types(["object", "string:!empty"], arguments, 1);
        var f = "", e = this.instance("core_ns_with_dashes"), c = this.instance("plugin_root_ns_with_dashes");
        b(d).add(b(d).parents("." + c)).each(function () {
            b.each(String(b(this).attr("class")).split(/\s+/), function (h, g) {
                if (g.indexOf(c + "--t--") === 0) {
                    f = g.replace(c + "--t--", "")
                }
                return (f) ? false : true
            });
            return (f) ? false : true
        });
        if (f) {
            return e + "--t--" + f + " " + c + "--t--" + f
        }
        return ""
    };
    a.$$.prototype.enhance_forms = function () {
        var c = this, f = b("." + c.instance("plugin_root_ns_with_dashes") + " form");
        if (c.browser().webkit) {
            var d = {interval_time: 100, intervals: 0, max_intervals: 50};
            d.interval = setInterval((d.handler = function () {
                d.intervals++;
                if ((!d.$fields || !d.$fields.length) && (d.$fields = f.find("input:-webkit-autofill").filter('[autocomplete="off"]')).length) {
                    clearInterval(d.interval), d.$fields.each(function () {
                        var i = b(this), h = i.clone(true);
                        var g = h.val(), j = h.data("initial-value");
                        if (g && j !== undefined && j === "") {
                            h.val("")
                        }
                        if (h.attr("type") === "password") {
                            h.attr("type", "text").css({"-webkit-text-security": "disc"})
                        }
                        i.after(h).remove()
                    })
                }
                if (d.intervals > d.max_intervals) {
                    clearInterval(d.interval)
                }
            }), d.interval_time);
            setTimeout(d.handler, 50)
        }
        var e = function (i, g) {
            c.check_arg_types("string", "string", arguments, 2);
            var h = 0;
            if ((i != g) && g.length > 0) {
                return "mismatch"
            } else {
                if (i.length < 1) {
                    return "empty"
                } else {
                    if (i.length < 6) {
                        return "short"
                    }
                }
            }
            if (/[0-9]/.test(i)) {
                h += 10
            }
            if (/[a-z]/.test(i)) {
                h += 10
            }
            if (/[A-Z]/.test(i)) {
                h += 10
            }
            if (/[^0-9a-zA-Z]/.test(i)) {
                h = (h === 30) ? h + 20 : h + 10
            }
            if (h < 30) {
                return "weak"
            }
            if (h < 50) {
                return "good"
            }
            return "strong"
        };
        f.find(':input[type="password"][data-confirm="true"]').each(function () {
            var h = {
                empty: "",
                "short": "danger",
                weak: "warning",
                good: "info",
                strong: "success",
                mismatch: "warning"
            };
            var k = b(this), j = k.next(':input[type="password"][data-confirm!="true"]');
            var g = b('<div class="progress clear em-t-margin text-center"><div class="width-100"></div></div>');
            var i = g.find("> div");
            j.closest(".form-group").append(g), k.add(j).keyup(function () {
                var l = e(b.trim(String(k.val())), b.trim(String(j.val())));
                if (l === "empty") {
                    i.attr("class", "progress-bar no-bg color-inherit width-100").html(c.__("password_strength_status__" + l))
                } else {
                    i.attr("class", "progress-bar progress-bar-" + h[l] + " width-100").html(c.__("password_strength_status__" + l))
                }
            }).trigger("keyup")
        });
        f.each(function () {
            var g = b(this), h = g.prevAll(".responses.errors");
            h.find("> ul > li[data-form-field-code]").each(function () {
                var l = b(this), k, m, j, i;
                if (!(k = l.attr("data-form-field-code"))) {
                    return
                }
                if (!(m = g.find(':input[name="' + c.esc_jq_attr(k) + '"],:input[name$="' + c.esc_jq_attr("[" + k + "]") + '"],:input[name$="' + c.esc_jq_attr("[" + k + "][]") + '"]').first()).length) {
                    return
                }
                if (!(j = m.closest(".form-group")).length) {
                    return
                }
                if ((i = j.find(".validation-errors")).length) {
                    l.clone().appendTo(i.find("> ul"));
                    l.remove()
                } else {
                    i = b('<div class="validation-errors alert alert-danger em-x-margin em-padding font-90"><ul></ul></div>');
                    l.clone().appendTo(i.find("> ul"));
                    l.remove();
                    c.expand_collapsible_parents_of(j);
                    if (j.has(".input-group").length === 1) {
                        j.find(".input-group").after(i)
                    } else {
                        j.append(i)
                    }
                }
            });
            h.find("> ul:empty").append('<li><i class="fa fa-exclamation-triangle"></i> ' + c.__("validate_form__check_issues_below") + "</li>")
        });
        f.attr({novalidate: "novalidate"}).on("submit", function () {
            return c.validate_form(this)
        })
    };
    a.$$.prototype.validate_form = function (d) {
        this.check_arg_types(["object", "string:!empty"], arguments, 1);
        var o = this;
        var j = {}, e = {}, h = {}, k = {}, m = {};
        b("div.validation-errors", d).remove();
        b(':input[data-confirm="true"]', d).each(function () {
            var u = b(this), x = u, w = x.next(':input[data-confirm!="true"]');
            if (!x.length || !w.length) {
                throw"!$field1.length || !$field2.length"
            }
            if (x.attr("readonly") || w.attr("readonly")) {
                return
            }
            if (x.attr("disabled") || w.attr("disabled")) {
                return
            }
            var q = x.attr("id");
            if (!q || !o.is_string(q)) {
                return
            } else {
                q = q.replace(/\-{3}[0-9]+$/, "")
            }
            j[q] = j[q] || [];
            var p = x.attr("name");
            if (!p || !o.is_string(p)) {
                return
            }
            var r = x.prop("tagName");
            if (!r || !o.is_string(r)) {
                return
            } else {
                r = r.toLowerCase()
            }
            var v = x.attr("type");
            if (r === "input") {
                if (!v || !o.is_string(v)) {
                    return
                } else {
                    v = v.toLowerCase()
                }
            }
            if (b.inArray(r, ["button"]) !== -1) {
                return
            }
            if (r === "input" && b.inArray(v, ["hidden", "file", "radio", "checkbox", "image", "button", "reset", "submit"]) !== -1) {
                return
            }
            var t = x.val();
            if (o.is_number(t)) {
                t = String(t)
            }
            if (o.is_string(t)) {
                t = b.trim(t)
            }
            var s = w.val();
            if (o.is_number(s)) {
                s = String(s)
            }
            if (o.is_string(s)) {
                s = b.trim(s)
            }
            if (t !== s) {
                j[q].push(o.__("validate_form__mismatch_fields"))
            }
        });
        b(":input[data-unique]", d).each(function () {
            var s = b(this);
            if (s.attr("readonly") || s.attr("disabled")) {
                return
            }
            var v = s.attr("id");
            if (!v || !o.is_string(v)) {
                return
            } else {
                v = v.replace(/\-{3}[0-9]+$/, "")
            }
            e[v] = e[v] || [];
            var p = s.attr("name");
            if (!p || !o.is_string(p)) {
                return
            }
            var t = s.prop("tagName");
            if (!t || !o.is_string(t)) {
                return
            } else {
                t = t.toLowerCase()
            }
            var q = s.attr("type");
            if (t === "input") {
                if (!q || !o.is_string(q)) {
                    return
                } else {
                    q = q.toLowerCase()
                }
            }
            if (b.inArray(t, ["button", "select"]) !== -1) {
                return
            }
            if (t === "input" && b.inArray(q, ["file", "radio", "checkbox", "image", "button", "reset", "submit"]) !== -1) {
                return
            }
            var u = s.attr("data-unique-callback");
            if (!u || !o.is_string(u) || typeof window[u] !== "function") {
                return
            }
            var r = s.val();
            if (o.is_number(r)) {
                r = String(r)
            }
            if (o.is_string(r)) {
                r = b.trim(r)
            }
            if (r && o.is_string(r) && !window[u](r)) {
                e[v].push(o.__("validate_form__unique_field"))
            }
        });
        b(":input[data-required]", d).each(function () {
            var w = b(this);
            if (w.attr("readonly") || w.attr("disabled")) {
                return
            }
            var r = w.attr("id");
            if (!r || !o.is_string(r)) {
                return
            } else {
                r = r.replace(/\-{3}[0-9]+$/, "")
            }
            h[r] = h[r] || [];
            k[r] = k[r] || [];
            var q = w.attr("name");
            if (!q || !o.is_string(q)) {
                return
            }
            var s = w.prop("tagName");
            if (!s || !o.is_string(s)) {
                return
            } else {
                s = s.toLowerCase()
            }
            var x = w.attr("type");
            if (s === "input") {
                if (!x || !o.is_string(x)) {
                    return
                } else {
                    x = x.toLowerCase()
                }
            }
            if (b.inArray(s, ["button"]) !== -1) {
                return
            }
            if (s === "input" && b.inArray(x, ["image", "button", "reset", "submit"]) !== -1) {
                return
            }
            var z = w.val();
            if (o.is_number(z)) {
                z = String(z)
            }
            if (o.is_string(z)) {
                z = b.trim(z)
            }
            var A, u, t = null;
            var v, p, y;
            switch (s) {
                case"select":
                    if (w.attr("multiple")) {
                        if (w.attr("data-validation-name-0")) {
                            for (v = 0; v <= 24; v++) {
                                A = w.attr("data-validation-minimum-" + v);
                                A = (o.is_numeric(A)) ? Number(A) : null;
                                u = w.attr("data-validation-min-max-type-" + v);
                                if (u === "array_length" && o.isset(A) && A > 1) {
                                    if (!o.isset(t) || A < t) {
                                        t = A
                                    }
                                }
                            }
                            if (o.isset(t) && (!o.is_array(z) || z.length < t)) {
                                h[r].push(o.sprintf(o.__("validate_form__required_select_at_least"), t))
                            }
                        }
                        if (!h[r].length && (!o.is_array(z) || z.length < 1)) {
                            h[r].push(o.__("validate_form__required_select_at_least_one"))
                        }
                    } else {
                        if (!o.is_string(z) || z.length < 1) {
                            h[r].push(o.__("validate_form__required_field"))
                        }
                    }
                    break;
                case"input":
                    switch (x) {
                        case"file":
                            if (w.attr("multiple")) {
                                p = w.prop("files");
                                if (w.attr("data-validation-name-0")) {
                                    for (v = 0; v <= 24; v++) {
                                        A = w.attr("data-validation-minimum-" + v);
                                        A = (o.is_numeric(A)) ? Number(A) : null;
                                        u = w.attr("data-validation-min-max-type-" + v);
                                        if (u === "array_length" && o.isset(A) && A > 1) {
                                            if (!o.isset(t) || A < t) {
                                                t = A
                                            }
                                        }
                                    }
                                    if (o.isset(t) && (!(p instanceof FileList) || p.length < t)) {
                                        h[r].push(o.sprintf(o.__("validate_form__required_file_at_least"), t))
                                    }
                                }
                                if (!h[r].length && (!(p instanceof FileList) || p.length < 1)) {
                                    h[r].push(o.__("validate_form__required_file_at_least_one"))
                                }
                            } else {
                                if (!o.is_string(z) || z.length < 1) {
                                    h[r].push(o.__("validate_form__required_file"))
                                }
                            }
                            break;
                        case"radio":
                            y = b('input[id^="' + o.esc_jq_attr(r) + '"]:checked', d).length;
                            if (y < 1) {
                                if (!k[r].length) {
                                    h[r].push(o.__("validate_form__required_radio"))
                                }
                                k[r].push(o.__("validate_form__required_radio"))
                            }
                            break;
                        case"checkbox":
                            y = b('input[id^="' + o.esc_jq_attr(r) + '"]:checked', d).length;
                            if (b('input[id^="' + o.esc_jq_attr(r) + '"]', d).length > 1) {
                                if (w.attr("data-validation-name-0")) {
                                    for (v = 0; v <= 24; v++) {
                                        A = w.attr("data-validation-minimum-" + v);
                                        A = (o.is_numeric(A)) ? Number(A) : null;
                                        u = w.attr("data-validation-min-max-type-" + v);
                                        if (u === "array_length" && o.isset(A) && A > 1) {
                                            if (!o.isset(t) || A < t) {
                                                t = A
                                            }
                                        }
                                    }
                                    if (o.isset(t) && y < t) {
                                        if (!k[r].length) {
                                            h[r].push(o.sprintf(o.__("validate_form__required_check_at_least"), t))
                                        }
                                        k[r].push(o.sprintf(o.__("validate_form__required_check_at_least"), t))
                                    }
                                }
                                if (!h[r].length && y < 1) {
                                    if (!k[r].length) {
                                        h[r].push(o.__("validate_form__required_check_at_least_one"))
                                    }
                                    k[r].push(o.__("validate_form__required_check_at_least_one"))
                                }
                            } else {
                                if (y < 1) {
                                    h[r].push(o.__("validate_form__required_checkbox"))
                                }
                            }
                            break;
                        default:
                            if (!o.is_string(z) || z.length < 1) {
                                h[r].push(o.__("validate_form__required_field"))
                            }
                            break
                    }
                    break;
                default:
                    if (!o.is_string(z) || z.length < 1) {
                        h[r].push(o.__("validate_form__required_field"))
                    }
                    break
            }
        });
        b(":input[data-validation-name-0]", d).each(function () {
            var y = b(this);
            if (y.attr("readonly") || y.attr("disabled")) {
                return
            }
            var C = y.attr("id");
            if (!C || !o.is_string(C)) {
                return
            } else {
                C = C.replace(/\-{3}[0-9]+$/, "")
            }
            m[C] = m[C] || [];
            var N = y.attr("name");
            if (!N || !o.is_string(N)) {
                return
            }
            var K = y.prop("tagName");
            if (!K || !o.is_string(K)) {
                return
            } else {
                K = K.toLowerCase()
            }
            var u = y.attr("type");
            if (K === "input") {
                if (!u || !o.is_string(u)) {
                    return
                } else {
                    u = u.toLowerCase()
                }
            }
            if (b.inArray(K, ["button"]) !== -1) {
                return
            }
            if (K === "input" && b.inArray(u, ["image", "button", "reset", "submit"]) !== -1) {
                return
            }
            var E = y.val();
            if (o.is_number(E)) {
                E = String(E)
            }
            if (o.is_string(E)) {
                E = b.trim(E)
            }
            if (typeof E === "undefined" || typeof E.length === "undefined" || !E.length) {
                if (!o.isset(y.attr("data-required"))) {
                    return
                } else {
                    m[C].push(o.__("validate_form__required_field"));
                    return
                }
            }
            var r, L, s;
            var H, p, M, x;
            var I, J, F, w, t;
            var G, A;
            var q, D, v, B, z;
            for (G = [], A = [], q = 0; q <= 24; q++) {
                if (G.length) {
                    r = o.__("validate_form__or_validation_description_prefix")
                } else {
                    r = o.__("validate_form__validation_description_prefix")
                }
                L = y.attr("data-validation-name-" + q);
                if (!L || !o.is_string(L)) {
                    continue
                }
                x = y.attr("data-validation-description-" + q);
                if (!x || !o.is_string(x)) {
                    continue
                }
                s = y.attr("data-validation-regex-" + q);
                if (!s || !o.is_string(s)) {
                    s = "/[\\s\\S]*/"
                }
                H = y.attr("data-validation-minimum-" + q);
                H = (o.isset(H)) ? Number(H) : null;
                p = y.attr("data-validation-maximum-" + q);
                p = (o.isset(p)) ? Number(p) : null;
                M = y.attr("data-validation-min-max-type-" + q);
                if ((I = s.indexOf("/")) !== 0) {
                    continue
                }
                if ((J = s.lastIndexOf("/")) < 2) {
                    continue
                }
                F = s.substr(I + 1, J - 1);
                w = s.substr(J + 1);
                t = new RegExp(F, w);
                if (typeof G[q] === "undefined") {
                    switch (K) {
                        case"input":
                            switch (u) {
                                case"file":
                                    if (y.attr("multiple") && (v = y.prop("files")) instanceof FileList) {
                                        for (D = 0; D < v.length; D++) {
                                            if (!o.is_string(v[D].name) || !t.test(v[D].name)) {
                                                G[q] = r + " " + x;
                                                break
                                            }
                                        }
                                    } else {
                                        if (!y.attr("multiple")) {
                                            if (!o.is_string(E) || !t.test(E)) {
                                                G[q] = r + " " + x
                                            }
                                        }
                                    }
                                    break;
                                default:
                                    if (b.inArray(u, ["radio", "checkbox"]) === -1) {
                                        if (!o.is_string(E) || !t.test(E)) {
                                            G[q] = r + " " + x
                                        }
                                    }
                                    break
                            }
                            break;
                        default:
                            if (K !== "select") {
                                if (!o.is_string(E) || !t.test(E)) {
                                    G[q] = r + " " + x
                                }
                            }
                            break
                    }
                }
                if (typeof G[q] === "undefined" && (o.isset(H) || o.isset(p))) {
                    switch (M) {
                        case"numeric_value":
                            switch (K) {
                                case"input":
                                    switch (u) {
                                        default:
                                            if (b.inArray(u, ["file", "radio", "checkbox"]) === -1) {
                                                if (o.isset(H) && (!o.is_string(E) || !E.length || isNaN(E) || Number(E) < H)) {
                                                    G[q] = r + " " + x
                                                } else {
                                                    if (o.isset(p) && (!o.is_string(E) || !E.length || isNaN(E) || Number(E) > p)) {
                                                        G[q] = r + " " + x
                                                    }
                                                }
                                            }
                                            break
                                    }
                                    break;
                                default:
                                    if (K !== "select") {
                                        if (o.isset(H) && (!o.is_string(E) || !E.length || isNaN(E) || Number(E) < H)) {
                                            G[q] = r + " " + x
                                        } else {
                                            if (o.isset(p) && (!o.is_string(E) || !E.length || isNaN(E) || Number(E) > p)) {
                                                G[q] = r + " " + x
                                            }
                                        }
                                    }
                                    break
                            }
                            break;
                        case"file_size":
                            switch (K) {
                                case"input":
                                    switch (u) {
                                        case"file":
                                            if ((v = y.prop("files")) instanceof FileList) {
                                                for (B = 0, D = 0; D < v.length; D++) {
                                                    B += v[D].size
                                                }
                                                if (o.isset(H) && B < H) {
                                                    G[q] = r + " " + x
                                                } else {
                                                    if (o.isset(p) && B > p) {
                                                        G[q] = r + " " + x
                                                    }
                                                }
                                            }
                                            break
                                    }
                                    break
                            }
                            break;
                        case"string_length":
                            switch (K) {
                                case"input":
                                    switch (u) {
                                        default:
                                            if (b.inArray(u, ["file", "radio", "checkbox"]) === -1) {
                                                if (o.isset(H) && (!o.is_string(E) || E.length < H)) {
                                                    G[q] = r + " " + x
                                                } else {
                                                    if (o.isset(p) && (!o.is_string(E) || E.length > p)) {
                                                        G[q] = r + " " + x
                                                    }
                                                }
                                            }
                                            break
                                    }
                                    break;
                                default:
                                    if (K !== "select") {
                                        if (o.isset(H) && (!o.is_string(E) || E.length < H)) {
                                            G[q] = r + " " + x
                                        } else {
                                            if (o.isset(p) && (!o.is_string(E) || E.length > p)) {
                                                G[q] = r + " " + x
                                            }
                                        }
                                    }
                                    break
                            }
                            break;
                        case"array_length":
                            switch (K) {
                                case"select":
                                    if (y.attr("multiple")) {
                                        if (o.isset(H) && (!o.is_array(E) || E.length < H)) {
                                            G[q] = r + " " + x
                                        } else {
                                            if (o.isset(p) && (!o.is_array(E) || E.length > p)) {
                                                G[q] = r + " " + x
                                            }
                                        }
                                    }
                                    break;
                                case"input":
                                    switch (u) {
                                        case"file":
                                            if (y.attr("multiple")) {
                                                v = y.prop("files");
                                                if (o.isset(H) && (!(v instanceof FileList) || v.length < H)) {
                                                    G[q] = r + " " + x
                                                } else {
                                                    if (o.isset(p) && (!(v instanceof FileList) || v.length > p)) {
                                                        G[q] = r + " " + x
                                                    }
                                                }
                                            }
                                            break;
                                        case"checkbox":
                                            if (b('input[id^="' + o.esc_jq_attr(C) + '"]', d).length > 1) {
                                                z = b('input[id^="' + o.esc_jq_attr(C) + '"]:checked', d).length;
                                                if (o.isset(H) && z < H) {
                                                    if (!A.length) {
                                                        G[q] = r + " " + x
                                                    }
                                                    A[q] = r + " " + x
                                                } else {
                                                    if (o.isset(p) && z > p) {
                                                        if (!A.length) {
                                                            G[q] = r + " " + x
                                                        }
                                                        A[q] = r + " " + x
                                                    }
                                                }
                                            }
                                            break
                                    }
                                    break
                            }
                            break
                    }
                }
                if (typeof G[q] === "undefined" && typeof A[q] === "undefined") {
                    G = [], A = []
                }
            }
            m[C] = m[C].concat(G)
        });
        var c, n = {}, g, l, f, i;
        for (c in j) {
            if (j.hasOwnProperty(c)) {
                n[c] = n[c] || [], n[c] = n[c].concat(j[c])
            }
        }
        for (c in e) {
            if (e.hasOwnProperty(c)) {
                n[c] = n[c] || [], n[c] = n[c].concat(e[c])
            }
        }
        for (c in h) {
            if (h.hasOwnProperty(c)) {
                n[c] = n[c] || [], n[c] = n[c].concat(h[c])
            }
        }
        for (c in m) {
            if (m.hasOwnProperty(c)) {
                n[c] = n[c] || [], n[c] = n[c].concat(m[c])
            }
        }
        for (c in n) {
            if (!n.hasOwnProperty(c) || !n[c].length) {
                continue
            }
            g = true;
            if (!(l = b("#" + c, d)).length) {
                l = b("#" + c + "---0", d)
            }
            if (!l.length) {
                throw"!$input.length"
            }
            if (!(f = l.closest(".form-group")).length) {
                throw"!$closest_form_group.length"
            }
            i = b('<div class="validation-errors alert alert-danger em-x-margin em-padding font-90"><ul><li><i class="fa fa-exclamation-triangle"></i> ' + n[c].join('</li><li><i class="fa fa-exclamation-triangle"></i> ') + "</li></ul></div>");
            o.expand_collapsible_parents_of(f);
            if (f.has(".input-group").length === 1) {
                f.find(".input-group").after(i)
            } else {
                f.append(i)
            }
        }
        if (g) {
            b[o.core("->scrollTo")](b(".validation-errors", d).closest(".form-group"), {
                offset: {top: -100, left: 0},
                duration: 500
            })
        }
        return g ? false : true
    };
    a.$$.prototype.get_query_var = function (d) {
        this.check_arg_types("string:!empty", arguments, 1);
        var f = [];
        if (location.hash.substr(0, 2) === "#!") {
            f = f.concat(location.hash.substr(2).split("&"))
        }
        f = f.concat(location.search.substr(1).split("&"));
        for (var e = 0, c; e < f.length; e++) {
            c = f[e].split("=", 2);
            if (c.length === 2 && decodeURIComponent(c[0]) === d) {
                return b.trim(decodeURIComponent(c[1].replace(/\+/g, " ")))
            }
        }
        return ""
    };
    a.$$.prototype.is_admin = function () {
        return /\/wp\-admin(?:[\/?#]|$)/.test(location.href)
    };
    a.$$.prototype.is_plugin_menu_page = function (e, c) {
        this.check_arg_types(["string", "array"], "boolean", arguments, 0);
        var g, f, d, k;
        var j = this.instance("plugin_root_ns_stub_with_dashes");
        var h = this.preg_quote(j);
        var i = new RegExp("^" + h + "(?:\\-\\-(.+))?$");
        if (this.is_admin() && (g = this.get_query_var("page")) && (f = i.exec(g)) && f.length) {
            d = (f.length >= 2 && f[1]) ? f[1] : j;
            if (c) {
                if (d === j) {
                    k = "main_page"
                } else {
                    k = this.with_underscores(d)
                }
            }
            if (this.empty(e) || (this.is_string(e) && d === e) || (this.is_array(e) && b.inArray(d, e) !== -1)) {
                return c && k ? k : d
            }
        }
        return ""
    };
    a.$$.prototype.expand_collapsible_parents_of = function (c) {
        this.check_arg_types(["object", "string:!empty"], arguments, 1);
        b(c).parents(".collapse")[this.core("->collapse")]({toggle: false})[this.core("->collapse")]("show")
    };
    a.$$.prototype.select_all = function (d) {
        this.check_arg_types(["object", "string:!empty"], arguments, 1);
        if ((d = b(d)[0]) && document.implementation.hasFeature("Range", "2.0")) {
            var e, c;
            e = getSelection(), e.removeAllRanges();
            c = document.createRange(), c.selectNodeContents(d);
            e.addRange(c)
        }
    };
    a.$$.prototype.view_source = function (c) {
        this.check_arg_types(["object", "string:!empty"], arguments, 1);
        var e = b(c), g, f, d = '* { list-style:none; font-size:12px; font-family:"Menlo","Monaco","Consolas",monospace; }';
        if ((g = this.win_open("", 750, 500)) && (f = g.document) && f.open()) {
            f.write("<!DOCTYPE html>");
            f.write("<html>");
            f.write("<head>");
            f.write("<title>" + this.__("view_source__doc_title") + "</title>");
            f.write('<style type="text/css" media="all">' + d + "</style>");
            f.write("</head>");
            f.write("<body><pre>" + e.html() + "</pre></body>");
            f.write("</html>");
            f.close(), g.blur(), g.focus()
        }
    };
    a.$$.prototype.win_open = function (e, f, c, d) {
        this.check_arg_types("string", "integer", "integer", "string", arguments, 1);
        f = (f) ? f : 1000, c = (c) ? c : 700, d = (d) ? d : "_win_open";
        var g, h = "scrollbars=yes,resizable=yes,centerscreen=yes,modal=yes,width=" + f + ",height=" + c + ",top=" + ((screen.height - c) / 2) + ",screenY=" + ((screen.height - c) / 2) + ",left=" + ((screen.width - f) / 2) + ",screenX=" + ((screen.width - f) / 2);
        if (!(g = open(e, d, h))) {
            alert(this.__("win_open__turn_off_popup_blockers"))
        } else {
            g.blur(), g.focus()
        }
        return g
    };
    a.$$.prototype.mt_rand = function (d, c) {
        this.check_arg_types("integer", "integer", arguments, 0);
        d = d ? d : 0, c = c ? c : 2147483647;
        return Math.floor(Math.random() * (c - d + 1)) + d
    };
    a.$$.prototype.add_query_arg = function (d, e, c) {
        this.check_arg_types("string:!empty", "string", "string", arguments, 3);
        c += (c.indexOf("?") === -1) ? "?" : "&";
        c += encodeURIComponent(d) + "=" + encodeURIComponent(e);
        return c
    };
    a.$$.prototype.get_call_verifier = function (d, c) {
        this.check_arg_types("string:!empty", "string:!empty", arguments, 2);
        return this.verifier(c + "::" + d)
    };
    a.$$.prototype.ajax = function (i, g, f, e, h) {
        this.check_arg_types("string:!empty", "string:!empty", "string:!empty", "array", "object", arguments, 3);
        var d = this.instance("wp_load_url");
        var c = this.instance("plugin_var_ns");
        h = (h) ? h : {};
        h.type = i, h.url = d, h.data = {};
        h.data[c + "[a][s]"] = "ajax";
        h.data[c + "[a][c]"] = g;
        h.data[c + "[a][t]"] = f;
        h.data[c + "[a][v]"] = this.get_call_verifier(g, f);
        if (e && e.length) {
            h.data[c + "[a][a]"] = JSON.stringify(e)
        }
        if (!(h.complete instanceof Array)) {
            h.complete = (h.complete) ? [h.complete] : []
        }
        h.complete.push(function (k, j) {
            if (j !== "success") {
                console.log(k)
            }
        });
        b.ajax(h)
    };
    a.$$.prototype.get = function (e, d, c, g) {
        this.check_arg_types("string:!empty", "string:!empty", "array", "object", arguments, 2);
        var f = b.makeArray(arguments);
        f.unshift("GET"), this.ajax.apply(this, f)
    };
    a.$$.prototype.post = function (e, d, c, g) {
        this.check_arg_types("string:!empty", "string:!empty", "array", "object", arguments, 2);
        var f = b.makeArray(arguments);
        f.unshift("POST"), this.ajax.apply(this, f)
    };
    a.$$.prototype.check_arg_types = function () {
        var o = b.makeArray(arguments);
        var u = Number(o.pop());
        var c = b.makeArray(o.pop());
        var p = o;
        var t = c.length;
        var g = t - 1;
        var e, h;
        var q, k, r, d, f;
        var m, s, n, j, i, l;
        if (t < u) {
            n = this.__("check_arg_types__caller");
            throw this.sprintf(this.__("check_arg_types__missing_args"), n, u, t)
        } else {
            if (t === 0) {
                return true
            }
        }
        main_loop:for (e = 0; e < p.length; e++) {
            h = p[e];
            q = !this.is_array(h) ? [h] : h;
            if (e > g) {
                continue
            }
            r = -1;
            types_loop:for (k = 0; k < q.length; k++) {
                d = q[k];
                switch_handler:switch (d) {
                    case"":
                        break types_loop;
                    case":!empty":
                        if (this.empty(c[e])) {
                            if (r === -1) {
                                r = q.length - 1
                            }
                            if (k === r) {
                                m = {types: q, position: e, value: c[e], empty: this.empty(c[e])};
                                break main_loop
                            }
                        } else {
                            break types_loop
                        }
                        break switch_handler;
                    case"string":
                    case"boolean":
                    case"bool":
                    case"integer":
                    case"float":
                    case"number":
                    case"numeric":
                    case"array":
                    case"function":
                    case"xml":
                    case"object":
                    case"null":
                    case"undefined":
                        f = this[this.___is_type_checks[d]];
                        if (!f(c[e])) {
                            if (r === -1) {
                                r = q.length - 1
                            }
                            if (k === r) {
                                m = {types: q, position: e, value: c[e], empty: this.empty(c[e])};
                                break main_loop
                            }
                        } else {
                            break types_loop
                        }
                        break switch_handler;
                    case"!string":
                    case"!boolean":
                    case"!bool":
                    case"!integer":
                    case"!float":
                    case"!number":
                    case"!numeric":
                    case"!array":
                    case"!function":
                    case"!xml":
                    case"!object":
                    case"!null":
                    case"!undefined":
                        f = this[this.___is_type_checks[d]];
                        if (f(c[e])) {
                            if (r === -1) {
                                r = q.length - 1
                            }
                            if (k === r) {
                                m = {types: q, position: e, value: c[e], empty: this.empty(c[e])};
                                break main_loop
                            }
                        } else {
                            break types_loop
                        }
                        break switch_handler;
                    case"string:!empty":
                    case"boolean:!empty":
                    case"bool:!empty":
                    case"integer:!empty":
                    case"float:!empty":
                    case"number:!empty":
                    case"numeric:!empty":
                    case"array:!empty":
                    case"function:!empty":
                    case"xml:!empty":
                    case"object:!empty":
                    case"null:!empty":
                    case"undefined:!empty":
                        f = this[this.___is_type_checks[d]];
                        if (!f(c[e]) || this.empty(c[e])) {
                            if (r === -1) {
                                r = q.length - 1
                            }
                            if (k === r) {
                                m = {types: q, position: e, value: c[e], empty: this.empty(c[e])};
                                break main_loop
                            }
                        } else {
                            break types_loop
                        }
                        break switch_handler;
                    default:
                        if (!this.is_function(d) || !(c[e] instanceof d)) {
                            if (r === -1) {
                                r = q.length - 1
                            }
                            if (k === r) {
                                m = {types: q, position: e, value: c[e], empty: this.empty(c[e])};
                                break main_loop
                            }
                        } else {
                            break types_loop
                        }
                        break switch_handler
                }
            }
        }
        if (m) {
            s = m.position + 1;
            l = b.type(m.value);
            i = (m.empty) ? this.__("check_arg_types__empty") + " " : "";
            if (m.types.length && this.is_string(m.types[0])) {
                j = m.types.join("|")
            } else {
                j = this.__("check_arg_types__diff_object_type")
            }
            n = this.__("check_arg_types__caller");
            throw this.sprintf(this.__("check_arg_types__invalid_arg"), s, n, j, i, l)
        }
        return true
    }
})(jQuery);
(function (b) {
    window.$xd_v141226_dev = window.$xd_v141226_dev || {};
    var a = $$xd_v141226_dev;
    var c = $xd_v141226_dev;
    if (typeof c.$ === "object") {
        return
    }
    c.$ = new a.$$();
    if (!c.___did_globals) {
        b.each(c.$.___plugin_root_namespaces, function (e, d) {
            window["$" + d] = window["$" + d] || {}
        });
        c.___did_globals = true
    }
    if (!c.___did_enhance_forms) {
        b.each(c.$.___plugin_root_namespaces, function (f, d) {
            var g = c.$.extension_class(d, "enhance_forms");
            window["$" + d].$enhance_forms = new g();
            var e = window["$" + d].$enhance_forms;
            b(document).on("ready", e.enhance_forms.bind(e))
        });
        c.___did_enhance_forms = true
    }
})(jQuery);