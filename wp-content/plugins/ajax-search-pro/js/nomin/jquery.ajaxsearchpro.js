/*! Ajax Search pro 4.9.0 js */
(function ($) {
    var instData = [];
    var w;

    var methods = {

        "errors": {
            "noui": {
                "msg": "Warning: Seems like you are using sliders in search settings,\n" +
                "but NoUI Slider script is not loaded!\n\n" +
                "Go to Ajax Search Pro -> Compatibility settings submenu to enable it!",
                "raised": false,
                "repeat": false
            },
            "isotope": {
                "msg": "Warning: Seems like you are using isotopic layout,\n" +
                "but the Isotope JS script is not enabled!\n\n" +
                "Go to Ajax Search Pro -> Compatibility settings submenu to enable it!",
                "raised": false,
                "repeat": false
            },
            "polaroid": {
                "msg": "Warning: Seems like you are using polaroid layout,\n" +
                "but the Ploaroid gallery JS script is not enabled!\n\n" +
                "Go to Ajax Search Pro -> Compatibility settings submenu to enable it!",
                "raised": false,
                "repeat": false
            },
            "datepicker": {
                "msg": "Warning: Seems like you are using datepicker in search settings,\n" +
                "but the UI DatePicker script is not loaded!\n\n" +
                "Go to Ajax Search Pro -> Compatibility settings submenu to enable it!",
                "raised": false,
                "repeat": false
            },
            "missing_response": {
                "msg": "Warning: The response data is missing from the ajax request!\n" +
                "This could mean a server related issue.\n\n" +
                "Check your .htaccess configuration and try disabling all other plugins to see if the problem persists.",
                "raised": false,
                "repeat": true
            }
        },

        raiseError: function( error ) {
            var $this = this;

            // Prevent alert and console flooding
            if ( !$this.errors[error].raised || $this.errors[error].repeat ) {
                alert($this.errors[error].msg);
                console.log($this.errors[error].msg);
                $this.errors[error].raised = true;
            }
        },

        init: function (options, elem) {
            var $this = this;

            this.elem = elem;
            this.$elem = $(elem);

            $this.searching = false;
            $this.o = $.extend({}, options);
            $this.n = {};
            $this.n.container =  $(this.elem);
            $this.n.c =  $this.n.container;

            var idArr = $this.n.container.attr('id').match(/^ajaxsearchpro(.*)_(.*)/);
            $this.o.rid = idArr[1] + "_" + idArr[2];
            $this.o.iid = idArr[2];
            $this.o.id = idArr[1];

            instData[$this.o.rid] = this;
            $this.n.probox = $('.probox', $this.n.container);
            $this.n.proinput = $('.proinput', $this.n.container);
            $this.n.text = $('.proinput input.orig', $this.n.container);
            $this.n.textAutocomplete = $('.proinput input.autocomplete', $this.n.container);
            $this.n.loading = $('.proinput .loading', $this.n.container);
            $this.n.proloading = $('.proloading', $this.n.container);
            $this.n.proclose = $('.proclose', $this.n.container);
            $this.n.promagnifier = $('.promagnifier', $this.n.container);
            $this.n.prosettings = $('.prosettings', $this.n.container);
            $this.n.searchsettings = $('#ajaxsearchprosettings' + $this.o.rid);
            $this.n.trythis = $("#asp-try-" + $this.o.rid);
            $this.o.blocking = false;
            $this.resultsOpened = false;
            if ($this.n.searchsettings.length <= 0) {
                $this.n.searchsettings = $('#ajaxsearchprobsettings' + $this.o.rid);
                $this.o.blocking = true;
            }
            $this.n.resultsDiv = $('#ajaxsearchprores' + $this.o.rid);
            $this.n.hiddenContainer = $('#asp_hidden_data');
            $this.n.aspItemOverlay = $('.asp_item_overlay', $this.n.hiddenContainer);

            $this.resizeTimeout = null;
            $this.dontTriggerResize = false;

            if ( typeof($.browser) != 'undefined' &&
                typeof($.browser.mozilla) != 'undefined' &&
                typeof($.browser.version) != 'undefined' &&
                parseInt($.browser.version) > 13
            )
                $this.n.searchsettings.addClass('asp_firefox');

            $this.n.showmore = $('.showmore', $this.n.resultsDiv);
            $this.n.items = $('.item', $this.n.resultsDiv);
            $this.n.results = $('.results', $this.n.resultsDiv);
            $this.n.resdrg = $('.resdrg', $this.n.resultsDiv);

            // Mobile changes
            if ( isMobile() ) {
                $this.o.triggerontype = $this.o.mobile.trigger_on_type;
                $this.o.triggeronclick = $this.o.mobile.trigger_on_click;
            }

            // Move the try-this keywords to the correct position
            $this.n.trythis.detach().insertAfter($this.n.container);

            // Isotopic Layout variables
            $this.il = {
                columns: 3,
                rows: $this.o.iiRows,
                itemsPerPage: 6
            };

            // An object to store various timeout events across methods
            $this.timeouts = {
                "compactBeforeOpen": null,
                "compactAfterOpen": null
            };

            $this.firstClick = true;
            $this.post = null;
            $this.postAuto = null;
            $this.cleanUp();
            //$this.n.text.val($this.o.defaultsearchtext);
            $this.n.textAutocomplete.val('');
            $this.o.resultitemheight = parseInt($this.o.resultitemheight);
            $this.scroll = new Object();
            $this.is_scroll = typeof $.fn.mCustScr != "undefined";
            // Force noscroll on minified version
            if ( typeof ASP.scrollbar != "undefined" && ASP.scrollbar == 0 )
                $this.is_scroll = false;
            $this.settScroll = null;
            $this.n.resultsAppend = $('#wpdreams_asp_results_' + $this.o.id);
            $this.n.settingsAppend = $('#wpdreams_asp_settings_' + $this.o.id);
            $this.currentPage = 1;
            $this.isotopic = null;
            $this.sIsotope = null;
            $this.lastSuccesfulPhrase = ''; // Holding the last phrase that returned results
            $this.supportTransform = getSupportedTransform();

            // Repetitive call related
            $this.call_num = 0;
            $this.results_num = 0;

            // Make parsing the animation settings easier
            if ( isMobile() )
                $this.animOptions = $this.o.animations.mob;
            else
                $this.animOptions = $this.o.animations.pc;

            // A weird way of fixing HTML entity decoding from the parameter
            $this.o.redirect_url = $('<textarea />').html($this.o.redirect_url).text();

            /**
             * Default animation opacity. 0 for IN types, 1 for all the other ones. This ensures the fluid
             * animation. Wrong opacity causes flashes.
             * @type {number}
             */
            $this.animationOpacity = $this.animOptions.items.indexOf("In") < 0 ? "opacityOne" : "opacityZero";

            $this.filterFns = {
                number: function () {
                    var $parent = $(this).parent();
                    while (!$parent.hasClass('isotopic')) {
                        $parent = $parent.parent();
                    }
                    var number = $(this).attr('data-itemnum');
                    //var currentPage = parseInt($('nav>ul li.asp_active span', $parent).html(), 10);
                    var currentPage = $this.currentPage;
                    //var itemsPerPage = parseInt($parent.data("itemsperpage"));
                    var itemsPerPage = $this.il.itemsPerPage;

                    if ( ( number % ($this.il.columns * $this.il.rows) ) < ($this.il.columns * ($this.il.rows-1) ))
                        $(this).addClass('asp_gutter_bottom');
                    else
                        $(this).removeClass('asp_gutter_bottom');

                    return (
                    (parseInt(number, 10) < itemsPerPage * currentPage) &&
                    (parseInt(number, 10) >= itemsPerPage * (currentPage - 1))
                    );
                }
            };

            if ( $this.o.compact.overlay == 1 && $("#asp_absolute_overlay").length <= 0 )
                $("<div id='asp_absolute_overlay'></div>").appendTo("body");

            $this.disableMobileScroll = false;

            // Fixes the fixed layout mode if compact mode is active and touch device fixes
            $this.initCompact();

            // Make corrections if needed for the settings box
            $this.initSettingsBox();

            // Make corrections if needed for the results box
            $this.initResultsBox();

            // Sets $this.dragging to true if the user is dragging on a touch device
            $this.monitorTouchMove();

            // Yea, go figure...
            if (detectOldIE())
                $this.n.container.addClass('asp_msie');

            // Calculates the settings animation attributes
            $this.initSettingsAnimations();

            // Calculates the results animation attributes
            $this.initResultsAnimations();

            // Rest of the events
            $this.initEvents();

            // Auto populate init
            $this.initAutop();

            // Etc stuff..
            $this.initEtc();

            return this;
        },

        initCompact: function() {
            var $this = this;

            // Reset the overlay no matter what, if the is not fixed
            if ( $this.o.compact.enabled == 1 && $this.o.compact.position != 'fixed' )
                $this.o.compact.overlay = 0;

            if ( $this.o.compact.enabled == 1 && $this.o.compact.position != 'static' )
                $this.n.trythis.css({
                    display: "none"
                });

            if ( $this.o.compact.enabled == 1 && $this.o.compact.position == 'fixed' ) {

                /**
                 * If the conditional CSS loader is enabled, the required
                 * search CSS file is not present when this code is executed.
                 * Therefore the search box is not in position and the
                 * originalContainerOffTop will equal 0
                 * The solution is to run this code in intervals and check
                 * if the container position is changed to fixed. If so, the
                 * search CSS is loaded.
                 */
                var iv = setInterval( function() {

                    // Not fixed yet, the CSS file is not loaded, continue
                    if ( $this.n.container.css('position') != "fixed" )
                        return;

                    $this.n.container.detach().appendTo("body");
                    $this.n.trythis.detach().appendTo("body");

                    /**
                     * In case of a touch device we need to move the position to absolute to prevent
                     * fixed screen and virtual keyboard issues.
                     */
                    if ( isMobile() ) {
                        $this.n.container.css('position', 'absolute');
                        $this.n.trythis.css('position', 'absolute');

                        var originalContainerOffTop = $this.n.container.offset().top;

                        $(window).scroll(function() {
                            if ($this.resultsOpened && $this.dragging) return;
                            clearTimeout($.data(this, 'xscrollTimer'));
                            $.data(this, 'xscrollTimer', setTimeout(function() {
                                $this.n.container.css({
                                    'top': $(window).scrollTop() + originalContainerOffTop
                                });
                                $this.n.trythis.css({
                                    'top': $(window).scrollTop() + originalContainerOffTop + $this.n.container.outerHeight()
                                });
                            }, 130));
                        });
                    }

                    // If we get here, it is time to abort this execution
                    clearInterval(iv);

                }, 200);

            }
        },

        initSettingsBox: function() {
            var $this = this;

            if ( isMobile() && $this.o.mobile.force_sett_hover == 1) {
                $this.n.searchsettings.attr(
                    "id",
                    $this.n.searchsettings.attr("id").replace('probsettings', 'prosettings')
                );
                $this.n.searchsettings.detach().appendTo("body");
                $this.o.blocking = false;
                return true;
            }

            if ($this.n.settingsAppend.length > 0) {
                /*
                 When the search settings is set to hovering, but the settings
                 shortcode is used, we need to force the blocking behavior,
                 since the user expects it.
                 */
                if ($this.o.blocking == false) {
                    $this.n.searchsettings.attr(
                        "id",
                        $this.n.searchsettings.attr("id").replace('prosettings', 'probsettings')
                    );
                    $this.o.blocking = true;
                }
                $this.n.searchsettings.detach().appendTo($this.n.settingsAppend);
            } else if ($this.o.blocking == false) {
                $this.n.searchsettings.detach().appendTo("body");
            }
        },

        initResultsBox: function() {
            var $this = this;

            if ( isMobile() && $this.o.mobile.force_sett_hover == 1) {
                $this.o.resultsposition = 'hover';
                $this.n.resultsDiv.detach().appendTo("body");
            } else {
                // Move the results div to the correct position
                if ($this.o.resultsposition == 'hover' && $this.n.resultsAppend.length <= 0) {
                    $this.n.resultsDiv.detach().appendTo("body");
                } else if ($this.n.resultsAppend.length > 0) {
                    $this.o.resultsposition = 'block';
                    $this.n.resultsDiv.css({
                        'position': 'static'
                    });
                    $this.n.resultsDiv.detach().appendTo($this.n.resultsAppend);
                } else {
                    $this.o.resultsposition = 'block';
                    $this.n.resultsDiv.css({
                        'position': 'static'
                    });
                    $this.n.resultsDiv.detach().insertAfter($this.n.container);
                }
            }

            // Generate scrollbars for vertical and horizontal
            if ($this.o.resultstype == 'horizontal') {
                $this.createHorizontalScroll();
            } else if ($this.o.resultstype == 'vertical') {
                $this.createVerticalScroll();
            }

            if ($this.o.resultstype == 'polaroid')
                $this.n.results.addClass('photostack');
        },

        monitorTouchMove: function() {
            var $this = this;
            $this.dragging = false;
            $("body").on("touchmove", function(){
                $this.dragging = true;
            });
            $("body").on("touchstart", function(){
                $this.dragging = false;
            });
        },

        duplicateCheck: function() {
            var $this = this;
            var duplicateChk = {};

            $('div[id*=ajaxsearchpro]').each (function () {
                if (duplicateChk.hasOwnProperty(this.id)) {
                    $(this).remove();
                } else {
                    duplicateChk[this.id] = 'true';
                }
            });
        },

        analytics: function(term) {
            var $this = this;

            // YOAST uses __gaTracker, if not defined check for ga, if nothing go null, FUN EH??
            var fun = typeof __gaTracker == "function" ? __gaTracker : (typeof ga == "function" ? ga : null);

            if (fun != null && $this.o.analytics && $this.o.analyticsString != '') {
                fun('send', 'pageview', {
                    'page': '/' + $this.o.analyticsString.replace("{asp_term}", term),
                    'title': 'Ajax Search'
                });
            }
        },

        createVerticalScroll: function () {
            var $this = this;

            if ($this.is_scroll) {
                $this.scroll = $this.n.results.mCustScr({
                    contentTouchScroll: true,
                    scrollButtons: {
                        enable: true
                    },
                    callbacks: {
                        onScroll: function () {
                            if (isMobile()) return;
                            var top = parseInt($('.mCSBap_container', $this.n.results).position().top);
                            var drg = $('.mCSBap_container .resdrg', $this.n.results);
                            var children = $('.mCSBap_container .resdrg', $this.n.results).children();

                            // Prevent scrolling, when close to the bottom element
                            if (
                                drg.height() - (Math.abs(top) + $this.n.results.height() ) <
                                ($('.resdrg .item', $this.n.results).last().height() * 1.2)
                            )
                                return;

                            var overall = 0;
                            var prev = 3000;
                            var diff = 4000;
                            var s_diff = 10000;
                            var s_overall = 10000;
                            var $last = null;
                            children.each(function () {
                                diff = Math.abs((Math.abs(top) - overall));
                                if (diff < prev) {
                                    s_diff = diff;
                                    s_overall = overall;
                                    $last = $(this);
                                }
                                overall += $(this).outerHeight(true);
                                prev = diff;
                            });
                            if ($last.hasClass('group'))
                                s_overall = s_overall + ($last.outerHeight(true));

                            $this.scroll.mCustScr("scrollTo", $last, {
                                scrollInertia: 200,
                                callbacks: false
                            });
                        }
                    }
                });
            }
        },

        createHorizontalScroll: function () {
            var $this = this;

            if ($this.is_scroll) {
                $this.scroll = $this.n.results.mCustScr({
                    axis: "x",
                    scrollButtons: {
                        enable: true
                    }
                });
            }
        },

        initAutop: function () {
            var $this = this;

            if ( $this.o.autop.state == "disabled" ) return false;

            var i = 0;
            var x = setInterval(function(){
                if ( ASP.css_loaded == true ) {
                    if ($this.o.autop.state == "phrase") {
                        $this.n.text.val($this.o.autop.phrase);
                        $this.search($this.o.autop.count);
                    } else {
                        $this.search($this.o.autop.count, 1);
                    }
                    clearInterval(x);
                }

                i++;
                if ( i > 6 )
                    clearInterval(x);
            }, 500);
        },

        initEtc: function() {
            var $this = this;
            // Mark last visible options
            $('fieldset' ,$this.n.searchsettings).each(function(){
                $('.asp_option:not(.hiddend)', this).last().addClass("asp-o-last");
            });

            // Select all checkboxes
            $('.asp_option_cat input[type="checkbox"]', $this.n.searchsettings).click(function(e){
                var className = $(this).data("targetclass");
                $("input." + className).prop("checked", $(this).prop("checked"));
            });

            // Category level automatic checking
            $('.asp_option_cat input[type="checkbox"]', $this.n.searchsettings).click(function(){
                var _this = $(this);
                var parent = $(this).parent();
                var i = 0;
                while (!parent.hasClass("asp_option_cat")) {
                    parent = parent.parent();
                    i++;
                    if ( i > 5) break; // safety first
                }
                var lvl = parseInt(parent.data("lvl")) + 1;
                i = 0;
                while (true) {
                    parent = parent.next();
                    if ( parent.length > 0 &&
                        typeof parent.data("lvl") != "undefined" &&
                        parseInt(parent.data("lvl")) >= lvl
                    )
                        $('input[type="checkbox"]', parent).prop("checked", _this.prop("checked"));
                    else
                        break;
                    i++;
                    if ( i > 400 ) break; // safety first
                }
            });
        },

        initEvents: function () {
            var $this = this;

            // Some kind of crazy rev-slider fix
            $this.n.text.click(function(e){
                $(this).focus();
            });

            $($this.n.text.parent()).submit(function (e, args) {
                e.preventDefault();
                if (isMobile() || (typeof(args) != 'undefined' && args == 'ajax') )
                    $this.search();
            });

            $this.n.resultsDiv.css({
                opacity: 0
            });
            $(document).bind("click", function (e) {
                var $parent = $(e.target).parent();
                var stop = 5;
                while (!$parent.hasClass('ui-datepicker') && stop > 0) {
                    $parent = $parent.parent();
                    stop--;
                }
                if ($this.o.blocking == false && stop <= 0) $this.hideSettings();

                if ($this.o.compact.enabled) {
                    var compact = $this.n.container.attr('asp-compact')  || 'closed';
                    if ($this.o.compact.closeOnDocument == 1 && compact == 'open' && !$this.resultsOpened) {
                        $this.closeCompact();
                        if ($this.post != null) $this.post.abort();
                        $this.hideLoader();
                    }
                } else {
                    if ($this.resultsOpened == false || $this.o.closeOnDocClick != 1) return;
                }

                if (!$this.dragging) {
                    $this.hideResults();
                }
            });
            $this.n.proclose.bind("click touchend", function () {
                if ($this.resultsOpened == false) return;
                $this.n.text.val("");
                $this.n.textAutocomplete.val("");
                $this.hideResults();
                $this.n.text.focus();
            });
            $($this.elem).bind("click touchend", function (e) {
                e.stopImmediatePropagation();
            });

            // Isotope results swipe event
            if ( $this.o.resultstype == "isotopic" && typeof $this.n.resultsDiv.swipe != "undefined" ) {
                $this.n.resultsDiv.swipe({
                    //Generic swipe handler for all directions
                    excludedElements: "button, input, select, textarea, .noSwipe",
                    preventDefaultEvents: !detectIOS(),
                    swipeLeft: function (e, direction, distance, duration, fingerCount, fingerData) {
                        $("a.asp_next", $this.n.resultsDiv).click();
                    },
                    swipeRight: function (e, direction, distance, duration, fingerCount, fingerData) {
                        $("a.asp_prev", $this.n.resultsDiv).click();
                    }
                });
            }
            $this.n.resultsDiv.bind("click", function (e) {
                e.stopImmediatePropagation();
            });
            $this.n.searchsettings.bind("click touchend", function (e) {
                e.stopImmediatePropagation();
            });

            /*
             * Memorize the focus status
             */
            var focused = false;
            $this.n.text.focus(function(){
                focused = true;
            });

            var trEvent = "touchend";
            if ( $this.n.results.hasClass("mCustScr") )
                trEvent = "mousedown";
            $this.n.resultsDiv.bind(trEvent, function (e) {
                if (isMobile() && focused) {
                    /*
                     * This will make sure that if the user clicked on the results
                     * then nothing happens.
                     */
                    e.preventDefault();
                    e.stopPropagation();
                    e.stopImmediatePropagation();

                    // Tell the isotope pagination to not trigger a resize this time
                    $this.dontTriggerResize = true;

                    /**
                     * mcustomScrollbar catches all events and prevents them.
                     * So instead we cancel the first click on the result URL, preventing
                     * accidental clicks or clicks intended to just hide the keyboard.
                     * This is not needed for Isotopic and Polaroid results.
                     */
                    if ( $this.n.results.hasClass("mCustScr") ) {
                        $this.n.resultsDiv.one("click", "a.asp_res_url", function(e) {
                            e.preventDefault();
                            e.stopPropagation();
                            e.stopImmediatePropagation();
                            return false;
                        });
                    }

                    // Hinde the mobile keyboard
                    document.activeElement.blur();
                    focused = false;
                    return false;
                }
            });

            $this.n.prosettings.on("click", function () {
                if ($this.n.prosettings.data('opened') == 0) {
                    $this.showSettings();
                } else {
                    $this.hideSettings();
                }
            });

            if ( isMobile() && $this.o.mobile.force_sett_hover == 1 ) {
                if ( $this.o.mobile.force_sett_state == "open" )
                    $this.n.prosettings.click();
            } else if ($this.o.settingsVisible == 1) {
                $this.n.prosettings.click();
            }

            // jQuery bind not working!
            /*$(document).bind('touchmove', function (e) {
             if ($this.disableMobileScroll == true)
             e.preventDefault();
             });*/

            var resizeTimer;
            $(window).on("resize", function () {
                clearTimeout(resizeTimer);
                resizeTimer = setTimeout(function() {
                    $this.resize();
                }, 250);
            });

            var scrollTimer;
            $(window).on("scroll", function () {
                clearTimeout(scrollTimer);
                scrollTimer = setTimeout(function() {
                    $this.scrolling(false);
                }, 250);
            });


            $this.initNavigationEvent();

            $(window).trigger('resize');
            $(window).trigger('scroll');

            $this.initMagnifierEvent();
            $this.initAutocompleteEvent();
            $this.initPagerEvent();
            $this.initOverlayEvent();
            $this.initNoUIEvents();
            $this.initDatePicker();
            $this.initCFDatePicker();
            $this.initFacetEvents();

        },

        initNavigationEvent: function () {
            var $this = this;

            $($this.n.resultsDiv).on('mouseenter', '.item',
                function () {
                    $('.item', $this.n.resultsDiv).removeClass('hovered');
                    $(this).addClass('hovered');
                }
            );
            $($this.n.resultsDiv).on('mouseleave', '.item',
                function () {
                    $('.item', $this.n.resultsDiv).removeClass('hovered');
                }
            );

            $(document).keydown(function (e) {

                if (window.event) {
                    var keycode = window.event.keyCode;
                    var ktype = window.event.type;
                } else if (e) {
                    var keycode = e.which;
                    var ktype = e.type;
                }

                if (
                    $('.item', $this.n.resultsDiv).length > 0 && $this.n.resultsDiv.css('display') != 'none' &&
                    $this.o.resultstype == "vertical"
                ) {
                    if (keycode == 40) {
                        e.stopPropagation();
                        e.preventDefault();
                        $this.n.text.blur();

                        if ($this.post != null) $this.post.abort();
                        if ($('.item.hovered', $this.n.resultsDiv).length == 0) {
                            $('.item', $this.n.resultsDiv).first().addClass('hovered');
                        } else {
                            $('.item.hovered', $this.n.resultsDiv).removeClass('hovered').next().next('.item').addClass('hovered');
                        }
                        if ($this.is_scroll) {
                            $this.scroll.mCustScr("scrollTo", ".resdrg .item.hovered",{
                                scrollInertia: 200,
                                callbacks: false
                            });
                        }
                    }
                    if (keycode == 38) {
                        e.stopPropagation();
                        e.preventDefault();
                        $this.n.text.blur();

                        if ($this.post != null) $this.post.abort();
                        if ($('.item.hovered', $this.n.resultsDiv).length == 0) {
                            $('.item', $this.n.resultsDiv).last().addClass('hovered');
                        } else {
                            $('.item.hovered', $this.n.resultsDiv).removeClass('hovered').prev().prev('.item').addClass('hovered');

                            if ($this.is_scroll) {
                                $this.scroll.mCustScr("scrollTo", ".resdrg .item.hovered", {
                                    scrollInertia: 200,
                                    callbacks: false
                                });
                            }
                        }
                    }

                    // Trigger click on return key
                    if ( keycode == 13 && $('.item.hovered', $this.n.resultsDiv).length > 0 ) {
                        e.stopPropagation();
                        e.preventDefault();
                        $('.item.hovered a.asp_res_url', $this.n.resultsDiv).get(0).click();
                    }

                }
            });
        },

        initMagnifierEvent: function () {
            var $this = this;

            if ($this.o.compact.enabled == 1)
                $this.initCompactEvents();

            var t;

            $this.n.promagnifier.add($this.n.text).bind('click keyup', function (e) {
                if (window.event) {
                    $this.keycode = window.event.keyCode;
                    $this.ktype = window.event.type;
                } else if (e) {
                    $this.keycode = e.which;
                    $this.ktype = e.type;
                }
                // Ignore arrows
                if ($this.keycode >= 37 && $this.keycode <= 40) return;
                if ($(this).hasClass('orig') && $this.ktype == 'click') return;

                // Click on magnifier in opened compact mode, when closeOnMagnifier enabled
                if (
                    $this.o.compact.enabled == 1 &&
                    ($this.ktype == 'click' || $this.ktype == 'touchend') &&
                    $this.o.compact.closeOnMagnifier == 1
                ) return;

                // Click on magnifier in closed compact mode, when closeOnMagnifier disabled
                var compact = $this.n.container.attr('asp-compact')  || 'closed';
                if (
                    $this.o.compact.enabled == 1 &&
                    ($this.ktype == 'click' || $this.ktype == 'touchend') &&
                    compact == 'closed'
                ) return;


                // If redirection is set to the results page, or custom URL
                if (
                    $this.n.text.val().length >= $this.o.charcount && (
                    ($this.o.redirectonclick == 1 && $this.ktype == 'click' && $this.o.redirectClickTo == 'results_page' ) ||
                    ($this.o.redirect_on_enter == 1 && $this.ktype == 'keyup' && $this.keycode == 13 && $this.o.redirectEnterTo == 'results_page' )
                    )
                ) {
                    var plus = '';
                    var url = $this.o.redirect_url.replace('{phrase}', $this.n.text.val());

                    if ($this.o.overridewpdefault) {
                        if ( $this.o.override_method == "post") {
                            asp_submit_to_url($this.o.homeurl + url, 'post', {
                                asp_active: 1,
                                p_asid: $this.o.id,
                                p_asp_data: $('form', $this.n.searchsettings).serialize()
                            });
                        } else {
                            location.href = $this.o.homeurl + url + "&asp_active=1&p_asid=" + $this.o.id + "&p_asp_data=" + Base64.encode($('form', $this.n.searchsettings).serialize());
                        }
                    } else {
                        // The method is not important, just send the data to memorize settings
                        asp_submit_to_url($this.o.homeurl + url, 'post', {
                            np_asid: $this.o.id,
                            np_asp_data: $('form', $this.n.searchsettings).serialize()
                        });
                    }

                    $this.n.proloading.css('display', 'none');
                    $this.hideLoader();
                    if ($this.o.blocking == false) $this.hideSettings();
                    $this.hideResults();
                    if ($this.post != null) $this.post.abort();
                    clearTimeout(t);

                    return;
                }


                if ($this.o.triggeronclick == 0 && $this.ktype == 'click') {
                    return;
                }

                if ($this.ktype == 'keyup') {
                    if ($this.o.triggerontype == 0 && $this.keycode != '13')
                        return;
                    if ($this.o.triggeronreturn == 0 && $this.keycode == '13')
                        return;
                }

                //if (($this.o.triggerontype == 0 && $this.ktype == 'keyup') || ($this.ktype == 'keyup' && is_touch_device())) return;

                if ($this.n.text.val().length < $this.o.charcount) {
                    if ( $this.keycode == '8' && !isMobile() ) {
                        $this.n.proloading.css('display', 'none');
                        if ($this.o.blocking == false) $this.hideSettings();
                        $this.hideResults();
                        if ($this.post != null) $this.post.abort();
                        clearTimeout(t);
                    }
                    return;
                }

                if ($this.post != null) $this.post.abort();
                clearTimeout(t);
                $this.n.proloading.css('display', 'none');
                t = setTimeout(function () {
                    // If the user types and deletes, while the last results are open
                    if ($this.n.text.val() != $this.lastSuccesfulPhrase || !$this.resultsOpened)
                        $this.search();
                    else
                        $this.n.proclose.css('display', 'block');
                }, $this.o.trigger.delay);
            });
        },

        initCompactEvents: function () {
            var $this = this;

            var scrollTopx = 0;

            $this.n.promagnifier.click(function(){
                var compact = $this.n.container.attr('asp-compact')  || 'closed';

                scrollTopx = $(window).scrollTop();
                $this.hideSettings();
                $this.hideResults();

                if (compact == 'closed') {
                    $this.openCompact();
                    $this.n.text.focus();
                } else {
                    if ($this.o.compact.closeOnMagnifier != 1) return;
                    $this.closeCompact();
                    if ($this.post != null) $this.post.abort();
                    $this.n.proloading.css('display', 'none');
                }
            });

        },

        openCompact: function() {
            var $this = this;

            if ( !$this.n.container.is("[asp-compact-w]") ) {
                $this.n.probox.attr('asp-compact-w', $this.n.probox.width());
                $this.n.container.attr('asp-compact-w', $this.n.container.width());
            }

            if ($this.o.compact.enabled == 1 && $this.o.compact.position != 'static') {
                $this.n.trythis.css({
                    top: $this.n.container.position().top + $this.n.container.outerHeight(true),
                    left: $this.n.container.offset().left
                });

                // In case of a mobile device, the top needs to be adjusted as well
                // because the mobile browser shows the top-bar which might cause
                // shifting upwards
                if ( isMobile() )
                    $this.n.container.css({
                        top: $this.n.container.position().top
                    });
            }

            $this.n.container.css({
                "width": $this.n.container.width()
            });

            $this.n.probox.css({width: "auto"});

            // halftime delay on showing the input, etc.. for smoother animation
            setTimeout(function(){
                $('>:not(.promagnifier)', $this.n.probox).removeClass('hiddend');
            }, 80);

            // Clear this timeout first, in case of fast clicking..
            clearTimeout($this.timeouts.compactBeforeOpen);
            $this.timeouts.compactBeforeOpen = setTimeout(function(){

                $this.n.container.css({
                    "max-width": $this.o.compact.width,
                    "width": $this.o.compact.width
                });

                if ($this.o.compact.overlay == 1) {
                    $this.n.container.css('z-index', 999999);
                    $this.n.searchsettings.css('z-index', 999999);
                    $this.n.resultsDiv.css('z-index', 999999);
                    $this.n.trythis.css('z-index', 999998);
                    $('#asp_absolute_overlay').css({
                        'opacity': 1,
                        'width': "100%",
                        "height": "100%",
                        "z-index": 999990
                    });
                }


            }, 50);

            // Clear this timeout first, in case of fast clicking..
            clearTimeout($this.timeouts.compactAfterOpen);
            $this.timeouts.compactAfterOpen = setTimeout(function(){
                $this.resize();
                if ($this.n.container.css('position') != 'static') {
                    $this.n.trythis.css({
                        display: 'block'
                    });
                }
                $this.n.text.focus();
                $this.scrolling();
            }, 500);


            $this.n.container.attr('asp-compact', 'open');
        },

        closeCompact: function() {
            var $this = this;

            /**
             * Clear every timeout from the opening script to prevent issues
             */
            clearTimeout($this.timeouts.compactBeforeOpen);
            clearTimeout($this.timeouts.compactAfterOpen);

            $('>:not(.promagnifier)', $this.n.probox).addClass('hiddend');

            $this.n.container.css({width: "auto"});
            $this.n.probox.css({width: $this.n.probox.attr('asp-compact-w')});
            //$this.n.container.velocity({width: $this.n.container.attr('asp-compact-w')}, 300);
            if ($this.n.container.css('position') != 'static') {
                $this.n.trythis.css({
                    left: $this.n.container.position().left,
                    display: "none"
                });
            }

            if ($this.o.compact.overlay == 1) {
                $this.n.container.css('z-index', '');
                $this.n.searchsettings.css('z-index', '');
                $this.n.resultsDiv.css('z-index', '');
                $this.n.trythis.css('z-index', '');
                $('#asp_absolute_overlay').css({
                    'opacity': 0,
                    'width': 0,
                    "height": 0,
                    "z-index": 0
                });
            }

            $this.n.container.attr('asp-compact', 'closed');
        },

        initAutocompleteEvent: function () {
            var $this = this;

            var tt;
            if (
                ($this.o.autocomplete.enabled == 1 && !isMobile()) ||
                ($this.o.autocomplete.mobile == 1 && isMobile())
            ) {
                $this.n.text.keyup(function (e) {
                    if (window.event) {
                        $this.keycode = window.event.keyCode;
                        $this.ktype = window.event.type;
                    } else if (e) {
                        $this.keycode = e.which;
                        $this.ktype = e.type;
                    }

                    var thekey = 39;
                    // Lets change the keykode if the direction is rtl
                    if ($('body').hasClass('rtl'))
                        thekey = 37;
                    if ($this.keycode == thekey && $this.n.textAutocomplete.val() != "") {
                        e.preventDefault();
                        $this.n.text.val($this.n.textAutocomplete.val());
                        if ($this.post != null) $this.post.abort();
                        $this.search();
                    } else {
                        clearTimeout(tt);
                        if ($this.postAuto != null) $this.postAuto.abort();
                        //This delay should be greater than the post-result delay..
                        //..so the
                        if ($this.o.autocomplete.googleOnly == 1) {
                            $this.autocompleteGoogleOnly();
                        } else {
                            tt = setTimeout(function () {
                                $this.autocomplete();
                                tt = null;
                            }, $this.o.trigger.autocomplete_delay);
                        }
                    }
                });
            }
        },

        initPagerEvent: function () {
            var $this = this;
            $this.n.resultsDiv.on('click', 'nav>a', function (e) {
                e.preventDefault();
                if ($(this).hasClass('asp_prev')) {
                    $this.currentPage = $this.currentPage == 1 ? Math.ceil($this.n.items.length / $this.il.itemsPerPage) : --$this.currentPage;
                } else {
                    $this.currentPage = $this.currentPage == Math.ceil($this.n.items.length / $this.il.itemsPerPage) ? 1 : ++$this.currentPage;
                }
                $('nav>ul li', $this.n.resultsDiv).removeClass('asp_active');
                $($('nav>ul li', $this.n.resultsDiv).get($this.currentPage - 1)).addClass('asp_active');
                $this.isotopic.arrange({filter: $this.filterFns['number']});

                $this.isotopicPagerScroll();
                $this.removeAnimation();
            });
            $this.n.resultsDiv.on('click', 'nav>ul li', function (e) {
                e.preventDefault();
                $this.currentPage = parseInt($('span', this).html(), 10);
                $('nav>ul li', $this.n.resultsDiv).removeClass('asp_active');
                $($('nav>ul li', $this.n.resultsDiv).get($this.currentPage - 1)).addClass('asp_active');
                $this.isotopic.arrange({filter: $this.filterFns['number']});
                $this.isotopicPagerScroll();
                $this.removeAnimation();
            });
        },

        isotopicPagerScroll: function () {
            var $this = this;

            if ( $('nav>ul li.asp_active', $this.n.resultsDiv).length <= 0 )
                return false;

            var $activeLeft = $('nav>ul li.asp_active', $this.n.resultsDiv).offset().left;
            var $activeWidth = $('nav>ul li.asp_active', $this.n.resultsDiv).outerWidth(true);
            var $nextLeft = $('nav>a.asp_next', $this.n.resultsDiv).offset().left;
            var $prevLeft = $('nav>a.asp_prev', $this.n.resultsDiv).offset().left;

            if ( $activeWidth <= 0) return;

            var toTheLeft = Math.ceil( ( $prevLeft - $activeLeft + 2 * $activeWidth ) / $activeWidth );

            if (toTheLeft > 0) {

                // If the active is the first, go to the beginning
                if ( $('nav>ul li.asp_active', $this.n.resultsDiv).prev().length == 0) {

                    $('nav>ul', $this.n.resultsDiv).css({
                        "left": $activeWidth + "px"
                    });

                    return;
                }

                // Otherwise go left
                $('nav>ul', $this.n.resultsDiv).css({
                    "left": "+=" + $activeWidth * toTheLeft + "px"
                });
            } else {

                // One step if it is the last element, 2 steps for any other
                if ( $('nav>ul li.asp_active', $this.n.resultsDiv).next().length == 0 )
                    var toTheRight = Math.ceil( ( $activeLeft - $nextLeft + $activeWidth ) / $activeWidth );
                else
                    var toTheRight = Math.ceil( ( $activeLeft - $nextLeft + 2 * $activeWidth ) / $activeWidth );

                if (toTheRight > 0) {
                    $('nav>ul', $this.n.resultsDiv).css({
                        "left": "-=" + $activeWidth * toTheRight + "px"
                    });
                }
            }
        },

        initOverlayEvent: function () {
            var $this = this;
            if ($this.o.resultstype == "isotopic") {
                if ($this.o.iishowOverlay) {
                    $this.n.resultsDiv.on('mouseenter', 'div.item', function (e) {
                        $('.asp_item_overlay', this).fadeIn();
                        if ($(".asp_item_img", this).length>0) {
                            if ($this.o.iiblurOverlay)
                                $('.asp_item_overlay_img', this).fadeIn();
                            if ($this.o.iihideContent)
                                $('.asp_content', this).slideUp(100);
                        }
                    });
                    $this.n.resultsDiv.on('mouseleave', 'div.item', function (e) {
                        $('.asp_item_overlay', this).fadeOut();
                        if ($(".asp_item_img", this).length>0) {
                            if ($this.o.iiblurOverlay)
                                $('.asp_item_overlay_img', this).fadeOut();
                            if ($this.o.iihideContent && $(".asp_item_img", this).length>0)
                                $('.asp_content', this).slideDown(100);
                        }
                    });
                    $this.n.resultsDiv.on('mouseenter', 'div.asp_item_inner', function (e) {
                        $(this).addClass('animated pulse');
                    });
                    $this.n.resultsDiv.on('mouseleave', 'div.asp_item_inner', function (e) {
                        $(this).removeClass('animated pulse');
                    });

                    $this.n.resultsDiv.on('click', '.asp_item_overlay', function(){
                        // Method to preserve _blank, jQuery click() method only triggers event handlers
                        var link = $('.asp_content h3 a', $(this).parent()).get(0);
                        if (typeof link != "undefined")
                            link.click();
                    });
                }

                $(window).on('resize', function () {
                    // If the mobile keyboard was just hidden no resize is required
                    if ( $this.dontTriggerResize ) {
                        $this.dontTriggerResize = false;
                        return false;
                    }
                    if ($this.resizeTimeout != null) clearTimeout($this.resizeTimeout);
                    $this.resizeTimeout = setTimeout(function () {
                        $this.calculateIsotopeRows();
                        $this.showPagination(true);
                        $this.removeAnimation();
                        if ($this.isotopic != null)
                            $this.isotopic.arrange({filter: $this.filterFns['number']});
                    }, 200);
                });
            }

        },

        initNoUIEvents: function () {
            var $this = this;

            $(".noui-slider-json" + $this.o.rid).each(function(index, el){

                var uid = $(this).attr('id').match(/^noui-slider-json(.*)/)[1];
                var jsonData = $(this).data("aspnoui");
                if (typeof jsonData === "undefined") return false;

                jsonData = Base64.decode(jsonData);
                if (typeof jsonData === "undefined" || jsonData == "") return false;

                var args = JSON.parse(jsonData);
                if ( $(args.node).length > 0 )
                    var slider = $(args.node).get(0);

                // Initialize the main
                if (typeof noUiSlider !== 'undefined') {
                    noUiSlider.create(slider, args.main);
                } else {
                    // NoUiSlider is not included within the scripts, alert the user!
                    $this.raiseError( "noui");
                    return false;
                }

                slider.noUiSlider.on('update', function( values, handle ) {
                    var value = values[handle];
                    if ( handle ) { // true when 1, if upper
                        args.links.forEach(function(el, i, arr){
                            var wn = wNumb(el.wNumb);
                            if ( el.handle == "upper") {
                                if ( $(el.target).is('input') )
                                    $(el.target).val(value);
                                else
                                    $(el.target).html( wn.to(parseFloat(value)) );
                            }
                            $(args.node).on('slide', function(e) { e.preventDefault(); } );
                        });
                    } else {        // 0, lower
                        args.links.forEach(function(el, i, arr){
                            var wn = wNumb(el.wNumb);
                            if ( el.handle == "lower") {
                                if ( $(el.target).is('input') )
                                    $(el.target).val(value);
                                else
                                    $(el.target).html( wn.to(parseFloat(value)) );
                            }
                            $(args.node).on('slide', function(e) { e.preventDefault(); } );
                        });
                    }
                });
            });

        },

        initDatePicker: function() {
            var $this = this;
            // We need jQuery UI here, pure jQuery scope
            var _$ = window.jQuery;

            if ( _$(".asp_datepicker", $this.n.searchsettings).length > 0 &&
                typeof(_$.fn.datepicker) == "undefined" )
            {
                // Datepicker is not included within the scripts, alert the user!
                $this.raiseError("datepicker");
                return false;
            }

            function onSelectEvent( dateText, inst, _this, nochange ) {
                if ( typeof(_this) != "undefined" && _this != null )
                    var obj = _$(_this);
                else
                    var obj = _$("#" + inst.id);

                // Trigger change event. $ scope is used ON PURPOSE
                // ..otherwise scoped version would not trigger!
                if ( typeof(nochage) == "undefined" || nochange == null )
                    $(obj).change();
            }

            _$(".asp_datepicker", $this.n.searchsettings).each(function(){
                var _this = this;
                var origValue = _$(this).val();

                _$(this).datepicker({
                    changeMonth: true,
                    changeYear: true,
                    dateFormat: "yy-mm-dd",
                    onSelect: onSelectEvent,
                    beforeShow: function(input, inst) {
                        _$('#ui-datepicker-div').addClass("asp-ui");
                    }
                });
                // Set the current date if the field is empty
                if ( origValue == "")
                    _$(this).datepicker("setDate", "+0");
                else
                    _$(this).datepicker("setDate", origValue );

                // Call the selec event to refresh the date pick value
                onSelectEvent(null, null, _this, true);
            });
        },

        initCFDatePicker: function() {
            var $this = this;
            // We need jQuery UI here, pure jQuery scope
            var _$ = window.jQuery;

            if ( _$(".asp_datepicker_field", $this.n.searchsettings).length > 0 &&
                typeof(_$.fn.datepicker) == "undefined" )
            {
                // Datepicker is not included within the scripts, alert the user!
                $this.raiseError("datepicker");
                return false;
            }

            // Define a global to the function
            //var _this = null;
            function onSelectEvent( dateText, inst, _this, nochange ) {
                if ( _this != null )
                    var obj = _$(_this);
                else
                    var obj = _$("#" + inst.id);
                var d = String( obj.datepicker("getDate") );
                var date = new Date(d.match(/(.*?)00\:/)[1].trim() + " GMT+0000");
                var year = String( date.getFullYear() );
                var month = ("0" + (date.getMonth() + 1)).slice(-2);
                var day = ("0" + String(date.getDate()) ).slice(-2);
                _$(".asp_datepicker_hidden", _$(obj).parent()).val(year + month + day);

                // Trigger change event. $ scope is used ON PURPOSE
                // ..otherwise scoped version would not trigger!
                if ( typeof(nochage) == "undefined" || nochange == null )
                    $(obj).change();
            }

            _$(".asp_datepicker_field", $this.n.searchsettings).each(function(){
                var format = _$(".asp_datepicker_format", _$(this).parent()).val();
                var _this = this;
                var origValue = _$(this).val();

                _$(this).datepicker({
                    changeMonth: true,
                    changeYear: true,
                    dateFormat: format,
                    onSelect: onSelectEvent,
                    beforeShow: function(input, inst) {
                        _$('#ui-datepicker-div').addClass("asp-ui");
                    }
                });
                // Set the current date if the field is empty
                if ( origValue == "")
                    _$(this).datepicker("setDate", "+0");
                else
                    _$(this).datepicker("setDate", origValue );
                // Call the selec event to refresh the date pick value
                onSelectEvent(null, null, _this, true);
            });
        },

        initFacetEvents: function() {
            var $this = this;

            if ($this.o.triggerOnFacetChange == 0) return;
            $('input, select', $this.n.searchsettings).on('change slidechange', function(){
                if ($this.n.text.val().length < $this.o.charcount) return;
                if ($this.post != null) $this.post.abort();
                $this.search();
            });
            $('div[id*="-handles"]', $this.n.searchsettings).each(function(){
                if ( typeof this.noUiSlider != 'undefined') {
                    this.noUiSlider.on('change', function () {
                        if ($this.n.text.val().length < $this.o.charcount) return;
                        if ($this.post != null) $this.post.abort();
                        $this.search();
                    });
                }
            });
        },

        destroy: function () {
            return this.each(function () {
                var $this = $.extend({}, this, methods);
                $(window).unbind($this);
            })
        },

        searchfor: function (phrase) {
            $(".proinput input", this).val(phrase).trigger("keyup");
        },

        autocomplete: function () {
            var $this = this;

            var val = $this.n.text.val();
            if ($this.n.text.val() == '') {
                $this.n.textAutocomplete.val('');
                return;
            }
            var autocompleteVal = $this.n.textAutocomplete.val();
            if (autocompleteVal != '' && autocompleteVal.indexOf(val) == 0) {
                return;
            } else {
                $this.n.textAutocomplete.val('');
            }
            var data = {
                action: 'ajaxsearchpro_autocomplete',
                asid: $this.o.id,
                sauto: $this.n.text.val()
            };
            $this.postAuto = $.post(ASP.ajaxurl, data, function (response) {
                if (response.length > 0) {
                    response = $('<textarea />').html(response).text();
                    var part1 = val;
                    var part2 = response.substr(val.length);
                    response = part1 + part2;
                }
                $this.n.textAutocomplete.val(response);
            });
        },

        // If only google source is used, this is much faster..
        autocompleteGoogleOnly: function () {
            var $this = this;

            var val = $this.n.text.val();
            if ($this.n.text.val() == '') {
                $this.n.textAutocomplete.val('');
                return;
            }
            var autocompleteVal = $this.n.textAutocomplete.val();
            if (autocompleteVal != '' && autocompleteVal.indexOf(val) == 0) {
                return;
            } else {
                $this.n.textAutocomplete.val('');
            }

            $.ajax({
                url: 'https://clients1.google.com/complete/search',
                dataType: 'jsonp',
                data: {
                    q: val,
                    hl: $this.o.autocomplete.lang,
                    nolabels: 't',
                    client: 'hp',
                    ds: ''
                },
                success: function(data) {
                    if (data[1].length > 0) {
                        response = data[1][0][0].replace(/(<([^>]+)>)/ig,"");
                        response = $('<textarea />').html(response).text();
                        response = response.substr(val.length);
                        $this.n.textAutocomplete.val(val + response);
                    }
                }
            });
        },

        search: function ( count, order, recall ) {
            var $this = this;
            var isAutop = false;

            if ( typeof recall == "undefined" )
                recall = false;

            $this.n.c.trigger("asp_search_start", [$this.o.id, $this.o.iid, $this.n.text.val()]);

            $this.searching = true;

            $this.n.proclose.css({
                display: "none"
            });

            $this.showLoader();

            // If blocking, or hover but facetChange activated, dont hide the settings for better UI
            if ( $this.o.blocking == false && $this.o.triggerOnFacetChange == 0 ) $this.hideSettings();

            // Removed in 4.0, better visual experience
            //$this.hideResults();

            var data = {
                action: 'ajaxsearchpro_search',
                aspp: $this.n.text.val(),
                asid: $this.o.id,
                asp_inst_id: $this.o.rid,
                options: $('form', $this.n.searchsettings).serialize()
            };
            if ( recall ) {
                $this.call_num++;
                data.asp_call_num = $this.call_num;
            } else {
                $this.call_num = 0;
            }
            var asp_preview_options = "";
            if ( $('#asp_preview_options').length > 0 ) {
                asp_preview_options = $('#asp_preview_options').html();
                if ( asp_preview_options != "" )
                    data.asp_preview_options = asp_preview_options;
            }

            if ( typeof count != "undefined" && count !== false ) {
                data.options += "&force_count=" + parseInt(count);
                isAutop = true;
            }
            if ( typeof order != "undefined" && order !== false ) {
                data.options += "&force_order=1";
                isAutop = true;
            }

            $this.analytics($this.n.text.val());
            $this.post = $.post(ASP.ajaxurl, data, function (response) {
                response = response.replace(/^\s*[\r\n]/gm, "");
                var html_response = response.match(/!!ASPSTART_HTML!!(.*[\s\S]*)!!ASPEND_HTML!!/);
                var data_response = response.match(/!!ASPSTART_DATA!!(.*[\s\S]*)!!ASPEND_DATA!!/);

                if (html_response == null || typeof(html_response) != "object" || typeof(html_response[1]) == "undefined") {
                    $this.hideLoader();
                    $this.raiseError("missing_response");
                    return false;
                } else {
                    html_response = html_response[1];
                }
                data_response = JSON.parse(data_response[1]);

                $this.n.c.trigger("asp_search_end", [$this.o.id, $this.o.iid, $this.n.text.val(), data_response]);

                if ( !recall ) {
                    $this.n.resdrg.html("");
                    $this.n.resdrg.html(html_response);
                    $this.results_num = data_response.results_count;
                } else {
                    $this.n.resdrg.html($this.n.resdrg.html() + html_response);
                    $this.results_num += data_response.results_count;
                }
                $(".asp_keyword", $this.n.resdrg).bind('click', function () {
                    $this.n.text.val($(this).html());
                    $('input.orig', $this.n.container).val($(this).html()).keydown();
                    $('form', $this.n.container).trigger('submit', 'ajax');
                });
                $this.n.items = $('.item', $this.n.resultsDiv);

                if (
                    $('.asp_res_url', $this.n.resultsDiv).length > 0 &&
                    ($this.o.redirectonclick == 1 && $this.ktype == 'click' && $this.o.redirectClickTo != 'results_page' ) ||
                    ($this.o.redirect_on_enter == 1 && $this.ktype == 'keyup' && $this.keycode == 13 && $this.o.redirectEnterTo != 'results_page' )
                ) {
                    location.href = $( $('.asp_res_url', $this.n.resultsDiv).get(0)).attr('href');
                    return false;
                }
                $this.hideLoader();
                $this.showResults();
                $this.scrollToResults();
                $this.lastSuccesfulPhrase = $this.n.text.val();

                if ($this.n.showmore != null) {
                    var url = $this.o.show_more.url.replace('{phrase}', $this.n.text.val());
                    url = $('<textarea />').html(url).text();

                    if (
                        $('span', $this.n.showmore).length > 0 &&
                        (data_response.full_results_count - $this.results_num) > 0 &&
                        !isAutop
                    ) {
                        $this.n.showmore.css("display", "block");
                        $('span', $this.n.showmore).html("(" + (data_response.full_results_count - $this.results_num) + ")");

                        $('a', $this.n.showmore).attr('href', "#");
                        $('a', $this.n.showmore).off();
                        $('a', $this.n.showmore).on('click', function(e){
                            if ( $this.o.show_more.action == "ajax") {
                                e.preventDefault();
                                $this.search(false, false, true);
                            } else {
                                if ($this.o.overridewpdefault) {
                                    if ( $this.o.override_method == "post") {
                                        asp_submit_to_url($this.o.homeurl + url, 'post', {
                                            asp_active: 1,
                                            p_asid: $this.o.id,
                                            p_asp_data: $('form', $this.n.searchsettings).serialize()
                                        });
                                    } else {
                                        location.href = $this.o.homeurl + url + "&asp_active=1&p_asid=" + $this.o.id + "&p_asp_data=" + Base64.encode($('form', $this.n.searchsettings).serialize());
                                    }
                                } else {
                                    // The method is not important, just send the data to memorize settings
                                    asp_submit_to_url($this.o.homeurl + url, 'post', {
                                        np_asid: $this.o.id,
                                        np_asp_data: $('form', $this.n.searchsettings).serialize()
                                    });
                                }
                            }
                        });
                    } else {
                        $this.n.showmore.css("display", "none");
                        $('span', $this.n.showmore).html("");
                    }
                }
            }, "text");
        },

        showResults: function( ) {
            var $this = this;
            switch ($this.o.resultstype) {
                case 'horizontal':
                    $this.showHorizontalResults();
                    break;
                case 'vertical':
                    $this.showVerticalResults();
                    break;
                case 'polaroid':
                    $this.showPolaroidResults();
                    //$this.disableMobileScroll = true;
                    break;
                case 'isotopic':
                    $this.showIsotopicResults();
                    break;
                default:
                    $this.showHorizontalResults();
                    break;
            }

            $this.hideLoader();

            $this.n.proclose.css({
                display: "block"
            });

            if ($this.n.showmore != null) {
                if ($this.n.items.length > 0) {
                    $this.n.showmore.css({
                        'display': 'block'
                    });
                } else {
                    $this.n.showmore.css({
                        'display': 'none'
                    });
                }
            }

            if (isMobile() && $this.o.mobile.hide_keyboard)
                document.activeElement.blur();

            $this.resultsOpened = true;
        },

        hideResults: function( ) {
            var $this = this;

            if ( !$this.resultsOpened ) return false;

            $this.n.resultsDiv.removeClass($this.resAnim.showClass).addClass($this.resAnim.hideClass);
            setTimeout(function(){
                $this.n.resultsDiv.css($this.resAnim.hideCSS);
            }, $this.resAnim.duration);

            $this.n.proclose.css({
                display: "none"
            });
            if ($this.n.showmore != null) {
                $this.n.showmore.css({
                    'display': 'none'
                });
            }

            if (isMobile())
                document.activeElement.blur();

            $this.resultsOpened = false;
            // Re-enable mobile scrolling, in case it was disabled
            //$this.disableMobileScroll = false;

            if ( typeof $this.ptstack != "undefined" )
                delete $this.ptstack;
        },

        showLoader: function( ) {
            var $this = this;

            if ( $this.o.loaderLocation == "none" ) return;

            if ( !$this.n.container.hasClass("hiddend")  && ( $this.o.loaderLocation != "results" )  ) {
                $this.n.proloading.css({
                    display: "block"
                });
            }

            if ( ( $this.n.container.hasClass("hiddend") && $this.o.loaderLocation != "search" ) ||
                ( !$this.n.container.hasClass("hiddend") && ( $this.o.loaderLocation == "both" || $this.o.loaderLocation == "results" ) )
            ) {
                $this.showResultsBox();
                $(".asp_res_loader", $this.n.resultsDiv).removeClass("hiddend");
                $this.n.results.css("display", "none");
                $this.n.showmore.css("display", "none");
                $this.hidePagination();
            }
        },

        hideLoader: function( ) {
            var $this = this;

            $this.n.proloading.css({
                display: "none"
            });
            $(".asp_res_loader", $this.n.resultsDiv).addClass("hiddend");
            $this.n.results.css("display", "");
        },


        scrollToResults: function( ) {
            $this = this;
            if (this.o.scrollToResults!=1 || this.$elem.parent().hasClass("asp_preview_data") || this.o.compact.enabled == 1) return;
            if ($this.o.resultsposition == "hover")
                var stop = $this.n.probox.offset().top - 20;
            else
                var stop = $this.n.resultsDiv.offset().top - 20;
            if ($("#wpadminbar").length > 0)
                stop -= $("#wpadminbar").height();
            stop = stop < 0 ? 0 : stop;
            $('body, html').animate({
                "scrollTop": stop
            }, {
                duration: 500
            });
        },

        showVerticalResults: function () {
            var $this = this;

            $this.showResultsBox();

            if ($this.n.items.length > 0) {
                var count = (($this.n.items.length < $this.o.itemscount) ? $this.n.items.length : $this.o.itemscount);
                var groups = $('.asp_group_header', $this.n.resultsDiv);
                var spacers = $('.asp_spacer', $this.n.resultsDiv);

                // So if the result list is short, we dont even need to do the math
                if ($this.n.items.length <= $this.o.itemscount) {
                    $this.n.results.css({
                        height: 'auto'
                    });
                } else {

                    // Set the height to a fictive value to refresh the scrollbar
                    // .. otherwise the height is not calculated correctly, because of the scrollbar width.
                    if ( $this.call_num < 1 )
                        $this.n.results.css({
                            height: 30
                        });
                    if ( $this.call_num < 1 && ($this.is_scroll) )
                        $this.scroll.mCustScr('update');
                    $this.resize();

                    if ( $this.call_num < 1 ) {
                        // Here now we have the correct item height values with the scrollbar enabled
                        var i = 0;
                        var h = 0;
                        var final_h = 0;
                        var highest = 0;

                        $this.n.items.each(function () {
                            h += $(this).outerHeight(true);
                            if ($(this).outerHeight(true) > highest)
                                highest = $(this).outerHeight(true);
                            i++;
                        });

                        // Get an initial height based on the highest item x viewport
                        final_h = highest * count;
                        // Reduce the final height to the overall height if exceeds it
                        if (final_h > h)
                            final_h = h;

                        // Count the average height * viewport size
                        i = i < 1 ? 1 : i;
                        h = h / i * count;

                        /*
                         Groups need a bit more calculation
                         - determine group position by index and occurence
                         - one group consists of group header, items + item spacers per item
                         - only groups within the viewport are calculated
                         */
                        if (groups.length > 0) {
                            groups.each(function (occurence) {
                                // -1 for the spacer
                                var group_position = $(this).index() - occurence - Math.floor($(this).index() / 3);
                                if (group_position < count) {
                                    final_h += $(this).outerHeight(true);
                                }
                            });
                        }

                        $this.n.results.css({
                            height: final_h
                        });
                    }
                }

                window.sscroll = $this.scroll;

                if ($this.is_scroll) {
                    // Disable the scrollbar first, to avoid glitches
                    if ($this.call_num < 1)
                        $this.scroll.mCustScr('disable', true);

                    // After making the changes trigger an update to re-enable
                    if ($this.call_num < 1)
                        $this.scroll.mCustScr('update');
                }

                // ..then all the other math stuff from the resize event
                $this.resize();

                if ($this.is_scroll) {
                    // .. and finally scroll back to the first item nicely
                    if ($this.call_num < 1)
                        $this.scroll.mCustScr('scrollTo', 0);
                }


                if ($this.o.highlight == 1) {
                    var wholew = (($this.o.highlightwholewords == 1) ? true : false);
                    $("div.item", $this.n.resultsDiv).highlight($this.n.text.val().split(" "), { element: 'span', className: 'highlighted', wordsOnly: wholew });
                }

            }
            $this.resize();
            if ($this.n.items.length == 0) {
                var h = ($('.nores', $this.n.results).outerHeight(true) > ($this.o.resultitemheight) ? ($this.o.resultitemheight) : $('.nores', $this.n.results).outerHeight(true));
                if ($this.is_scroll) {
                    $this.n.results.css({
                        height: 11110
                    });
                    $this.scroll.mCustScr('update');
                    $this.n.results.css({
                        height: 'auto'
                    });
                } else {
                    $this.n.results.css({
                        height: 'auto'
                    });
                }
            }

            if (!$this.is_scroll) {
                $this.n.results.css({
                    'overflowY': 'auto'
                });
            }

            $this.addAnimation();
            $this.scrolling(true);
            $this.searching = false;

        },

        showHorizontalResults: function () {
            var $this = this;

            $this.n.resultsDiv.css('display', 'block');
            $this.scrolling(true);

            $this.n.items.css("opacity", $this.animationOpacity);

            if ($('.asp_nores', $this.n.results).size() > 0) {
                $(".mCSBap_container", $this.n.resultsDiv).css({
                    width: 'auto',
                    left: 0
                });
            } else {
                if ( $this.call_num < 1 )
                    $(".mCSBap_container", $this.n.resultsDiv).css({
                        width: ($this.n.resdrg.children().size() * $($this.n.resdrg.children()[0]).outerWidth(true)),
                        left: 0
                    });
                else
                    $(".mCSBap_container", $this.n.resultsDiv).css({
                        width: ($this.n.resdrg.children().size() * $($this.n.resdrg.children()[0]).outerWidth(true))
                    });
            }
            if ($this.o.resultsposition == 'hover') {
                $this.n.resultsDiv.css('width', $this.n.container.width() - ($this.n.resultsDiv.outerWidth(true) - $this.n.resultsDiv.innerWidth()));
            }

            if ( $this.call_num < 1 && ($this.is_scroll) ) {
                $this.scroll.data({
                    "scrollButtons_scrollAmount": parseInt($this.n.items.outerWidth(true)),
                    "mouseWheelPixels": parseInt($this.n.items.outerWidth(true))
                }).mCustScr("update");
                // 0 does not work..
                $this.scroll.mCustScr("scrollTo", 0.1, {
                    scrollInertia: 200,
                    callbacks: false
                });
            }

            if ( !$this.is_scroll ) {
                if ($this.n.items.length > 0) {
                    var el_m = parseInt($this.n.items.css("marginLeft"));
                    var el_w = $this.n.items.outerWidth() + el_m * 2;
                    $this.n.results.css("overflowX", "auto");
                    $this.n.resdrg.css("width", $this.n.items.length * el_w + el_m * 2 + "px");
                } else {
                    $this.n.results.css("overflowX", "hidden");
                    $this.n.resdrg.css("width", "auto");
                }
            }

            if ($this.o.highlight == 1) {
                var wholew = (($this.o.highlightwholewords == 1) ? true : false);
                $("div.item", $this.n.resultsDiv).highlight($this.n.text.val().split(" "), { element: 'span', className: 'highlighted', wordsOnly: wholew });
            }

            $this.showResultsBox();
            $this.addAnimation();
        },

        showIsotopicResults: function () {
            var $this = this;
            var itemsPerPage = $this.o.iitemsPerPage;

            $this.preProcessIsotopicResults();
            $this.showResultsBox();

            if ($this.n.items.length > 0) {
                $this.n.results.css({
                    height: "auto"
                });
                if ($this.o.highlight == 1) {
                    var wholew = (($this.o.highlightwholewords == 1) ? true : false);
                    $("div.item", $this.n.resultsDiv).highlight($this.n.text.val().split(" "), { element: 'span', className: 'highlighted', wordsOnly: wholew });
                }

            }

            $this.calculateIsotopeRows();
            $this.showPagination();
            if ($this.n.items.length == 0) {
                var h = ($('.nores', $this.n.results).outerHeight(true) > ($this.o.resultitemheight) ? ($this.o.resultitemheight) : $('.nores', $this.n.results).outerHeight(true));
                $this.n.results.css({
                    height: 11110
                });
                $this.n.results.css({
                    height: 'auto'
                });
                $this.n.resdrg.css({
                    height: 'auto'
                });
            } else {
                // Initialize the main
                if (typeof rpp_isotope !== 'undefined') {
                    $this.isotopic = new rpp_isotope('#ajaxsearchprores' + $this.o.rid + " .resdrg", {
                        // options
                        itemSelector: 'div.item',
                        layoutMode: 'masonry',
                        filter: $this.filterFns['number'],
                        masonry: {
                            "gutter": $this.o.iiGutter
                        }
                    });
                } else {
                    // Isotope is not included within the scripts, alert the user!
                    $this.raiseError("isotope");
                    return false;
                }
            }
            $this.addAnimation();
            $this.searching = false;
        },

        preProcessIsotopicResults: function() {
            var $this = this;
            var j = 0;
            var overlay = "";

            // In some cases the hidden data is not present for some reason..
            if ($this.o.iishowOverlay && $this.n.aspItemOverlay.length > 0)
                overlay = $this.n.aspItemOverlay[0].outerHTML;

            $.grep($this.n.items, function (el, i) {
                var image = "";
                var overlayImage = "";
                var hasImage = $('.asp_item_img', el).length > 0 ? true : false;
                var $img = $('.asp_item_img', el);

                if (hasImage) {
                    var src = $img.attr('imgsrc');
                    if ($this.o.iiblurOverlay && !isMobile())
                        var filter = "aspblur";
                    else
                        var filter = "no_aspblur";
                    overlayImage = "<div filter='url(#" + filter + ")' style='background-image:url(" + src + ");filter: url(#" + filter + ");-webkit-filter: url(#" + filter + ");-moz-filter: url(#" + filter + ");-o-filter: url(#" + filter + ");-ms-filter: url(#" + filter + ");' class='asp_item_overlay_img'></div>";
                } else {
                    switch ($this.o.iifNoImage) {
                        case "description":
                            break;
                        case "removeres":
                            return false;
                            break;
                        case "defaultimage":
                            if ($this.o.defaultImage != "") {
                                image = "<div class='asp_item_img' style='background-image:url(" + $this.o.defaultImage + ");'>";
                                if ($this.o.iiblurOverlay && !isMobile())
                                    var filter = "aspblur";
                                else
                                    var filter = "no_aspblur";
                                overlayImage = "<div filter='url(#" + filter + ")' style='background-image:url(" + $this.o.defaultImage + ");filter: url(#" + filter + ");-webkit-filter: url(#" + filter + ");-moz-filter: url(#" + filter + ");-o-filter: url(#" + filter + ");-ms-filter: url(#" + filter + ");' class='asp_item_overlay_img'></div>";
                            }
                            break;
                    }
                }

                $(overlayImage + overlay + image).prependTo(el);
                $(el).attr('data-itemnum', j);

                j++;
            });

        },

        showPagination: function ( force_refresh ) {
            var $this = this;
            force_refresh = typeof force_refresh !== 'undefined' ? force_refresh : false;

            if ( $this.call_num < 1 || force_refresh)
                $('nav.asp_navigation ul li', $this.n.resultsDiv).remove();
            $('nav.asp_navigation', $this.n.resultsDiv).css('display', 'none');

            $('nav.asp_navigation ul', $this.n.resultsDiv).removeAttr("style");

            var oldSize = $('nav.asp_navigation ul li', $this.n.resultsDiv).length;
            oldSize = oldSize < 1 ? 1 : oldSize;

            if ($this.n.items.length > 0) {
                var start = 1;
                if ($this.call_num > 0 && !force_refresh) {
                    start = $('nav.asp_navigation ul li', $this.n.resultsDiv).length + 1;
                }
                var pages = Math.ceil($this.n.items.length / $this.il.itemsPerPage);
                if (pages > 1) {
                    for (var i = start; i <= pages; i++) {
                        if (i == 1)
                            $('nav.asp_navigation ul', $this.n.resultsDiv).append("<li class='asp_active'><span>" + i + "</span></li>");
                        else
                            $('nav.asp_navigation ul', $this.n.resultsDiv).append("<li><span>" + i + "</span></li>");
                    }
                    $('nav.asp_navigation', $this.n.resultsDiv).css('display', 'block');
                    if ($this.call_num > 0 && !force_refresh) {
                        // Has to be delayed, or it freezes the browser.. (??)
                        setTimeout(function(){
                            if ( typeof $('nav.asp_navigation ul li', $this.n.resultsDiv).get(oldSize) != "undefined")
                                $('nav.asp_navigation ul li', $this.n.resultsDiv).get(oldSize).click();
                            else
                                $('nav.asp_navigation ul li', $this.n.resultsDiv).last().click();
                        }, 120);
                    }
                }
            }
        },

        hidePagination: function () {
            var $this = this;

            $('nav.asp_navigation', $this.n.resultsDiv).css('display', 'none');
        },


        calculateIsotopeRows: function () {
            var $this = this;
            var containerWidth = parseFloat($this.n.results.innerWidth());
            var realColumnCount = containerWidth / $this.o.iitemsWidth;
            var gutterWidth = $this.o.iiGutter;
            var floorColumnCount = Math.floor(realColumnCount);
            if (floorColumnCount <= 0)
                floorColumnCount = 1;

            if (Math.abs(containerWidth / floorColumnCount - $this.o.iitemsWidth) >
                Math.abs(containerWidth / (floorColumnCount + 1) - $this.o.iitemsWidth)) {
                floorColumnCount++;
            }

            var newItemW = containerWidth / floorColumnCount - ( (floorColumnCount-1) * gutterWidth  / floorColumnCount );
            var newItemH = (newItemW / $this.o.iitemsWidth) * $this.o.iitemsHeight;

            $this.il.columns = floorColumnCount;
            $this.il.itemsPerPage = floorColumnCount * $this.o.iiRows;

            // This data needs do be written to the DOM, because the isotope arrange can't see the changes
            $this.n.resultsDiv.data({
                "colums": $this.il.columns,
                "itemsperpage": $this.il.itemsPerPage
            });

            $this.currentPage = 1;

            $this.n.items.css({
                width: Math.floor(newItemW),
                height: Math.floor(newItemH)
            });
        },

        showPolaroidResults: function () {
            var $this = this;

            $('.photostack>nav', $this.n.resultsDiv).remove();
            var figures = $('figure', $this.n.resultsDiv);
            $this.n.resultsDiv.css({
                display: 'block',
                height: 'auto'
            });

            $this.showResultsBox();

            if (figures.length > 0) {
                $this.n.results.css({
                    height: $this.o.prescontainerheight
                });

                if ($this.o.highlight == 1) {
                    var wholew = (($this.o.highlightwholewords == 1) ? true : false);
                    $("figcaption", $this.n.resultsDiv).highlight($this.n.text.val().split(" "), { element: 'span', className: 'highlighted', wordsOnly: wholew });
                }

                // Initialize the main
                if (typeof Photostack !== 'undefined') {
                    $this.ptstack = new Photostack($this.n.results.get(0), {
                        callback: function (item) {
                        }
                    });
                } else {
                    // PhotoStack is not included within the scripts, alert the user!
                    $this.raiseError("polaroid");
                    return false;
                }


            }
            //$this.resize();
            if (figures.length == 0) {
                var h = ($('.nores', $this.n.results).outerHeight(true) > ($this.o.resultitemheight) ? ($this.o.resultitemheight) : $('.nores', $this.n.results).outerHeight(true));
                $this.n.results.css({
                    height: 11110
                });
                $this.n.results.css({
                    height: "auto"
                });
            }
            $this.addAnimation();
            $this.scrolling(true);
            $this.searching = false;
            $this.initPolaroidEvents(figures);


        },

        initPolaroidEvents: function (figures) {
            var $this = this;

            var i = 1;
            figures.each(function () {
                if (i > 1)
                    $(this).removeClass('photostack-current');
                $(this).attr('idx', i);
                i++;
            });

            figures.click(function (e) {
                if ($(this).hasClass("photostack-current")) return;
                e.preventDefault();
                var idx = $(this).attr('idx');
                $('.photostack>nav span:nth-child(' + idx + ')', $this.n.resultsDiv).click();
            });

            figures.bind('mousewheel', function (event, delta) {
                event.preventDefault();
                if (delta >= 1) {
                    if ($('.photostack>nav span.current', $this.n.resultsDiv).next().length > 0) {
                        $('.photostack>nav span.current', $this.n.resultsDiv).next().click();
                    } else {
                        $('.photostack>nav span:nth-child(1)', $this.n.resultsDiv).click();
                    }
                } else {
                    if ($('.photostack>nav span.current', $this.n.resultsDiv).prev().length > 0) {
                        $('.photostack>nav span.current', $this.n.resultsDiv).prev().click();
                    } else {
                        $('.photostack>nav span:nth-last-child(1)', $this.n.resultsDiv).click();
                    }
                }
            });

            if ( typeof figures.swipe != "undefined" )
                $this.n.resultsDiv.swipe( {
                    //Generic swipe handler for all directions
                    excludedElements: "button, input, select, textarea, .noSwipe",
                    preventDefaultEvents: !detectIOS(),
                    swipeLeft: function(e, direction, distance, duration, fingerCount, fingerData) {
                        if ($('.photostack>nav span.current', $this.n.resultsDiv).next().length > 0) {
                            $('.photostack>nav span.current', $this.n.resultsDiv).next().click();
                        } else {
                            $('.photostack>nav span:nth-child(1)', $this.n.resultsDiv).click();
                        }
                    },
                    swipeRight:function(e, direction, distance, duration, fingerCount, fingerData) {
                        if ($('.photostack>nav span.current', $this.n.resultsDiv).prev().length > 0) {
                            $('.photostack>nav span.current', $this.n.resultsDiv).prev().click();
                        } else {
                            $('.photostack>nav span:nth-last-child(1)', $this.n.resultsDiv).click();
                        }
                    }
                });
        },

        addAnimation: function () {
            var $this = this;

            var i = 0;
            var j = 1;

            // No animation for the new elements via more results link
            if ($this.call_num > 0) {
                $this.n.items.removeClass("opacityZero").removeClass("asp_an_" + $this.animOptions.items);
                return false;
            }

            $this.n.items.each(function () {
                var x = this;

                if ($this.o.resultstype == 'isotopic' && j>$this.il.itemsPerPage) {
                    // Remove this from the ones not affected by the animation
                    $(x).removeClass("opacityZero");
                    return;
                }

                setTimeout(function () {
                    $(x).addClass("asp_an_" + $this.animOptions.items);
                    /**
                     * The opacityZero class must be removed just a little bit after
                     * the animation starts. This way the opacity is not reset to 1 yet,
                     * and not causing flashing effect on the results.
                     *
                     * If the opacityZero is not removed, the after the removeAnimation()
                     * call the opacity flashes back to 0 - window rezise or pagination events
                     */
                    $(x).removeClass("opacityZero");
                }, i);
                i = i + 80;
                j++;
            });

        },

        removeAnimation: function () {
            var $this = this;
            $this.n.items.each(function () {
                var x = this;
                $(x).removeClass("asp_an_" + $this.animOptions.items);
            });
        },

        initSettingsAnimations: function() {
            var $this = this;

            $this.settAnim = {
                "showClass": "",
                "showCSS": {
                    "visibility": "visible",
                    "display": "block",
                    "opacity": 1,
                    "animation-duration": $this.animOptions.settings.dur
                },
                "hideClass": "",
                "hideCSS": {
                    "visibility": "hidden",
                    "opacity": 0,
                    "display": "none"
                },
                "duration": $this.animOptions.settings.dur
            };

            if ($this.animOptions.settings.anim == "fade") {
                $this.settAnim.showClass = "asp_an_fadeIn";
                $this.settAnim.hideClass = "asp_an_fadeOut";
            }

            if ($this.animOptions.settings.anim == "fadedrop" &&
                !$this.o.blocking &&
                $this.supportTransform != false ) {
                $this.settAnim.showClass = "asp_an_fadeInDrop";
                $this.settAnim.hideClass = "asp_an_fadeOutDrop";
            } else if ( $this.animOptions.settings.anim == "fadedrop" ) {
                // If does not support transitio, or it is blocking layout
                // .. fall back to fade
                $this.settAnim.showClass = "asp_an_fadeIn";
                $this.settAnim.hideClass = "asp_an_fadeOut";
            }

            $this.n.searchsettings.css({
                "-webkit-animation-duration": $this.settAnim.duration + "ms",
                "animation-duration": $this.settAnim.duration + "ms"
            });
        },

        initResultsAnimations: function() {
            var $this = this;

            $this.resAnim = {
                "showClass": "",
                "showCSS": {
                    "visibility": "visible",
                    "display": "block",
                    "opacity": 1,
                    "animation-duration": $this.animOptions.results.dur
                },
                "hideClass": "",
                "hideCSS": {
                    "visibility": "hidden",
                    "opacity": 0,
                    "display": "none"
                },
                "duration": $this.animOptions.results.dur
            };

            if ($this.animOptions.results.anim == "fade") {
                $this.resAnim.showClass = "asp_an_fadeIn";
                $this.resAnim.hideClass = "asp_an_fadeOut";
            }

            if ($this.animOptions.results.anim == "fadedrop" &&
                !$this.o.blocking &&
                $this.supportTransform != false ) {
                $this.resAnim.showClass = "asp_an_fadeInDrop";
                $this.resAnim.hideClass = "asp_an_fadeOutDrop";
            } else if ( $this.animOptions.settings.anim == "fadedrop" ) {
                // If does not support transitio, or it is blocking layout
                // .. fall back to fade
                $this.resAnim.showClass = "asp_an_fadeIn";
                $this.resAnim.hideClass = "asp_an_fadeOut";
            }

            $this.n.resultsDiv.css({
                "-webkit-animation-duration": $this.settAnim.duration + "ms",
                "animation-duration": $this.settAnim.duration + "ms"
            });
        },

        showSettings: function () {
            var $this = this;

            $this.n.c.trigger("asp_settings_show", [$this.o.id, $this.o.iid]);

            $this.scrolling(true);
            $this.n.searchsettings.css($this.settAnim.showCSS);
            $this.n.searchsettings.removeClass($this.settAnim.hideClass).addClass($this.settAnim.showClass);

            if ($this.settScroll == null && ($this.is_scroll) ) {
                $this.settScroll = $('.asp_sett_scroll', $this.n.searchsettings).mCustScr({
                    contentTouchScroll: true
                });
            }

            if ( $this.o.fss_layout == "masonry" && $this.sIsotope == null ) {
                if (typeof rpp_isotope !== 'undefined') {
                    setTimeout(function () {
                        $(".searchsettings").css("width", "100%");
                        $this.sIsotope = new rpp_isotope(".searchsettings form", {
                            itemSelector: 'fieldset',
                            layoutMode: 'masonry',
                            transitionDuration: 0
                        });
                    }, $this.settAnim.duration);
                } else {
                    // Isotope is not included within the scripts, alert the user!
                    $this.raiseError("isotope");
                    return false;
                }
            }

            $this.n.prosettings.data('opened', 1);
            $this.fixSettingsWidth();
        },

        showResultsBox: function() {
            var $this = this;

            $this.n.c.trigger("asp_results_show", [$this.o.id, $this.o.iid]);

            $this.n.resultsDiv.css({
                display: 'block',
                height: 'auto'
            });
            $this.n.items.addClass($this.animationOpacity);

            $this.scrolling(true);
            $this.n.resultsDiv.css($this.resAnim.showCSS);
            $this.n.resultsDiv.removeClass($this.resAnim.hideClass).addClass($this.resAnim.showClass);
        },

        hideSettings: function () {
            var $this = this;

            $this.n.c.trigger("asp_settings_hide", [$this.o.id, $this.o.iid]);

            $this.n.searchsettings.removeClass($this.settAnim.showClass).addClass($this.settAnim.hideClass);
            setTimeout(function(){
                $this.n.searchsettings.css($this.settAnim.hideCSS);
            }, $this.settAnim.duration);

            $this.n.prosettings.data('opened', 0);

            if ( $this.sIsotope != null ) {
                setTimeout(function () {
                    $this.sIsotope.destroy();
                    $this.sIsotope = null;
                }, $this.settAnim.duration);
            }
        },

        fixSettingsWidth: function () {
            var $this = this;

            if ( $this.o.blocking || $this.o.fss_layout == 'masonry') return;

            $this.n.searchsettings.css({"width": "100%"});
            if ( ($this.n.searchsettings.innerWidth() % $("fieldset", $this.n.searchsettings).outerWidth(true)) > 10 ) {
                var newColumnCount = parseInt( $this.n.searchsettings.innerWidth() / $("fieldset", $this.n.searchsettings).outerWidth(true) );
                newColumnCount = newColumnCount <= 0 ? 1 : newColumnCount;
                $this.n.searchsettings.css({
                    "width": newColumnCount * $("fieldset", $this.n.searchsettings).outerWidth(true) + 8
                });
            }
        },

        cleanUp: function () {
            var $this = this;

            if ($('.searchsettings', $this.n.container).length > 0) {
                $('body>#ajaxsearchprosettings' + $this.o.rid).remove();
                $('body>#ajaxsearchprores' + $this.o.rid).remove();
            }
        },
        resize: function () {
            var $this = this;
            var bodyTop = 0;

            if ( $("body").css("position") != "static" )
                bodyTop = $("body").offset().top;

            if ( detectOldIE() ) {
                $this.n.proinput.css({
                    width: ($this.n.probox.width() - 8 - ($this.n.proinput.outerWidth(false) - $this.n.proinput.width()) - $this.n.proloading.outerWidth(true) - $this.n.prosettings.outerWidth(true) - $this.n.promagnifier.outerWidth(true) - 10)
                });
                $this.n.text.css({
                    width: $this.n.proinput.width() - 2 + $this.n.proloading.outerWidth(true),
                    //position: 'absolute',
                    zIndex: 2
                });
                $this.n.textAutocomplete.css({
                    width: $this.n.proinput.width() - 2 + $this.n.proloading.outerWidth(true),
                    /*position: 'absolute',
                     top: $this.n.text.position().top,
                     left: $this.n.text.position().left,*/
                    opacity: 0.25,
                    zIndex: 1
                });
            }

            if ($this.n.prosettings.data('opened') != 0 && $this.o.blocking != true) {

                if ($this.o.settingsimagepos == 'left') {
                    $this.n.searchsettings.css({
                        display: "block",
                        top: $this.n.prosettings.offset().top + $this.n.prosettings.height() - 2 - bodyTop,
                        left: $this.n.prosettings.offset().left
                    });
                } else {
                    $this.n.searchsettings.css({
                        display: "block",
                        top: $this.n.prosettings.offset().top + $this.n.prosettings.height() - 2 - bodyTop,
                        left: $this.n.prosettings.offset().left + $this.n.prosettings.width() - $this.n.searchsettings.width()
                    });
                }

                $this.fixSettingsWidth();
            }
            if ($this.n.resultsDiv.css('visibility') != 'hidden') {

                if ($this.o.resultsposition != 'block') {
                    var cwidth = $this.n.container.width() - ($this.n.resultsDiv.outerWidth(true) - $this.n.resultsDiv.width());
                    var rwidth = cwidth < 240 ? 240 : cwidth;
                    $this.n.resultsDiv.css({
                        width: rwidth,
                        top: $this.n.container.offset().top + $this.n.container.outerHeight(true) + 10 - bodyTop,
                        left: $this.n.container.offset().left
                    });
                }
            }

            if ($this.n.container.css('position') == 'fixed') {
                $this.n.trythis.css({
                    top: $this.n.container.position().top + $this.n.container.outerHeight(true)
                });
                if ( isMobile() )
                    $this.n.container.css({
                        top: $this.n.container.position().top
                    });
            }
            $this.n.trythis.css({
                left: $this.n.container.position().left
            });
        },

        scrolling: function (ignoreVisibility) {
            var $this = this;
            var bodyTop = 0;

            if ( $("body").css("position") != "static" )
                bodyTop = $("body").offset().top;

            if ( (ignoreVisibility == true || $this.n.searchsettings.css('visibility') == 'visible') && $this.o.blocking == false ) {
                if ($this.o.settingsimagepos == 'left') {
                    $this.n.searchsettings.css({
                        display: "block",
                        top: $this.n.prosettings.offset().top + $this.n.prosettings.height() - 2 - bodyTop,
                        left: $this.n.prosettings.offset().left
                    });
                } else {
                    $this.n.searchsettings.css({
                        display: "block",
                        top: $this.n.prosettings.offset().top + $this.n.prosettings.height() - 2 - bodyTop,
                        left: $this.n.prosettings.offset().left + $this.n.prosettings.width() - $this.n.searchsettings.width()
                    });
                }
            }

            if ((ignoreVisibility == true || $this.n.resultsDiv.css('visibility') == 'visible')) {
                var cwidth = $this.n.container.width() - ($this.n.resultsDiv.outerWidth(true) - $this.n.resultsDiv.width());
                var rwidth = cwidth < 240 ? 240 : cwidth;
                if ( ($this.o.resultsposition != 'hover' && $this.n.resultsAppend.length > 0) || $this.n.container.hasClass("hiddend"))
                    rwidth = 'auto';
                $this.n.resultsDiv.css({
                    width: rwidth,
                    top: $this.n.container.offset().top + $this.n.container.outerHeight(true) + 10 - bodyTop,
                    left: $this.n.container.offset().left
                });
            }
        },

        // -----------------------------------------------------------------------
        // ---------------------- SEARCH JS API METHODS --------------------------
        // -----------------------------------------------------------------------
        searchFor: function( phrase ) {
            var rid = $(this).attr('id').match(/^ajaxsearchpro(.*)/)[1];
            if ( typeof instData[rid] != 'undefined' ) {
                var $this = instData[rid];
                $this.n.text.val(phrase);
                $this.search();
            } else {
                console.log('This instance: ' + rid + ' does not exist :(');
            }
        },

        toggleSettings: function( state ) {
            var rid = $(this).attr('id').match(/^ajaxsearchpro(.*)/)[1];
            if ( typeof instData[rid] != 'undefined' ) {
                var $this = instData[rid];

                // state explicitly given, force behavior
                if (typeof state != 'undefined') {
                    if ( state == "show") {
                        $this.showSettings();
                    } else {
                        $this.hideSettings();
                    }
                } else {
                    if ( $this.n.prosettings.data('opened') ) {
                        $this.hideSettings();
                    } else {
                        $this.showSettings();
                    }
                }
            } else {
                console.log('This instance: ' + rid + ' does not exist :(');
            }
        },

        closeResults: function() {
            var rid = $(this).attr('id').match(/^ajaxsearchpro(.*)/)[1];
            if ( typeof instData[rid] != 'undefined' ) {
                var $this = instData[rid];
                $this.hideResults();
            } else {
                console.log('This instance: ' + rid + ' does not exist :(');
            }
        }
    };

    function asp_submit_to_url(action, method, input) {
        'use strict';
        var form;
        form = $('<form />', {
            action: action,
            method: method,
            style: 'display: none;'
        });
        if (typeof input !== 'undefined' && input !== null) {
            $.each(input, function (name, value) {
                $('<input />', {
                    type: 'hidden',
                    name: name,
                    value: value
                }).appendTo(form);
            });
        }
        form.appendTo('body').submit();
    }

    function is_touch_device() {
        return !!("ontouchstart" in window) ? 1 : 0;
    }

    function detectIE() {
        var ua = window.navigator.userAgent;
        var msie = ua.indexOf('MSIE ');
        var trident = ua.indexOf('Trident/');

        if (msie > 0 || trident > 0)
            return true;

        // other browser
        return false;
    }

    function detectIOS() {
        if (
            typeof window.navigator != "undefined" &&
            typeof window.navigator.userAgent != "undefined"
        )
            return window.navigator.userAgent.match(/(iPod|iPhone|iPad)/) != null;
        return false;
    }

    function detectOldIE() {
        var ua = window.navigator.userAgent;

        var msie = ua.indexOf('MSIE ');
        if (msie > 0) {
            return true;
        }

        return false;
    }

    function getSupportedTransform() {
        var prefixes = 'transform WebkitTransform MozTransform OTransform msTransform'.split(' ');
        var div = document.createElement('div');
        for(var i = 0; i < prefixes.length; i++) {
            if(div && div.style[prefixes[i]] !== undefined) {
                return prefixes[i];
            }
        }
        return false;
    }

    function tSeparated(x, y) {
        var parts = x.toString().split(".");
        parts[0] = parts[0].replace(/\B(?=(\d{3})+(?!\d))/g, y);
        return parts.join(".");
    }

    // Object.create support test, and fallback for browsers without it
    if (typeof Object.create !== 'function') {
        Object.create = function (o) {
            function F() {
            }

            F.prototype = o;
            return new F();
        };
    }

    /* Mobile detection - Touch desktop device safe! */
    function isMobile() {
        try{ document.createEvent("TouchEvent"); return true; }
        catch(e){ return false; }
    }


    // Create a plugin based on a defined object
    $.plugin = function (name, object) {
        $.fn[name] = function (options) {
            if ( typeof(options) != 'undefined' && object[options] ) {
                return object[options].apply( this, Array.prototype.slice.call( arguments, 1 ));
            } else {
                return this.each(function () {
                    if (!$.data(this, name)) {
                        $.data(this, name, Object.create(object).init(
                            options, this));
                    }
                });
            }

        };
    };

    $.plugin('ajaxsearchpro', methods);

    $.fn.mobileFix = function (options) {
        var $parent = $(this),
            $fixedElements = $(options.fixedElements);

        $(document)
            .on('focus', options.inputElements, function(e) {
                $parent.addClass(options.addClass);
            })
            .on('blur', options.inputElements, function(e) {
                $parent.removeClass(options.addClass);

                // Fix for some scenarios where you need to start scrolling
                setTimeout(function() {
                    $(document).scrollTop($(document).scrollTop())
                }, 1);
            });

        return this; // Allowing chaining
    };

    /**
     *
     *  Base64 encode / decode
     *  http://www.webtoolkit.info/
     *
     **/
    var Base64 = {

// private property
        _keyStr : "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789+/=",

// public method for encoding
        encode : function (input) {
            var output = "";
            var chr1, chr2, chr3, enc1, enc2, enc3, enc4;
            var i = 0;

            input = Base64._utf8_encode(input);

            while (i < input.length) {

                chr1 = input.charCodeAt(i++);
                chr2 = input.charCodeAt(i++);
                chr3 = input.charCodeAt(i++);

                enc1 = chr1 >> 2;
                enc2 = ((chr1 & 3) << 4) | (chr2 >> 4);
                enc3 = ((chr2 & 15) << 2) | (chr3 >> 6);
                enc4 = chr3 & 63;

                if (isNaN(chr2)) {
                    enc3 = enc4 = 64;
                } else if (isNaN(chr3)) {
                    enc4 = 64;
                }

                output = output +
                this._keyStr.charAt(enc1) + this._keyStr.charAt(enc2) +
                this._keyStr.charAt(enc3) + this._keyStr.charAt(enc4);

            }

            return output;
        },

// public method for decoding
        decode : function (input) {
            var output = "";
            var chr1, chr2, chr3;
            var enc1, enc2, enc3, enc4;
            var i = 0;

            input = input.replace(/[^A-Za-z0-9\+\/\=]/g, "");

            while (i < input.length) {

                enc1 = this._keyStr.indexOf(input.charAt(i++));
                enc2 = this._keyStr.indexOf(input.charAt(i++));
                enc3 = this._keyStr.indexOf(input.charAt(i++));
                enc4 = this._keyStr.indexOf(input.charAt(i++));

                chr1 = (enc1 << 2) | (enc2 >> 4);
                chr2 = ((enc2 & 15) << 4) | (enc3 >> 2);
                chr3 = ((enc3 & 3) << 6) | enc4;

                output = output + String.fromCharCode(chr1);

                if (enc3 != 64) {
                    output = output + String.fromCharCode(chr2);
                }
                if (enc4 != 64) {
                    output = output + String.fromCharCode(chr3);
                }

            }

            output = Base64._utf8_decode(output);

            return output;

        },

// private method for UTF-8 encoding
        _utf8_encode : function (string) {
            string = string.replace(/\r\n/g,"\n");
            var utftext = "";

            for (var n = 0; n < string.length; n++) {

                var c = string.charCodeAt(n);

                if (c < 128) {
                    utftext += String.fromCharCode(c);
                }
                else if((c > 127) && (c < 2048)) {
                    utftext += String.fromCharCode((c >> 6) | 192);
                    utftext += String.fromCharCode((c & 63) | 128);
                }
                else {
                    utftext += String.fromCharCode((c >> 12) | 224);
                    utftext += String.fromCharCode(((c >> 6) & 63) | 128);
                    utftext += String.fromCharCode((c & 63) | 128);
                }

            }

            return utftext;
        },

// private method for UTF-8 decoding
        _utf8_decode : function (utftext) {
            var string = "";
            var i = 0;
            var c = c1 = c2 = 0;

            while ( i < utftext.length ) {

                c = utftext.charCodeAt(i);

                if (c < 128) {
                    string += String.fromCharCode(c);
                    i++;
                }
                else if((c > 191) && (c < 224)) {
                    c2 = utftext.charCodeAt(i+1);
                    string += String.fromCharCode(((c & 31) << 6) | (c2 & 63));
                    i += 2;
                }
                else {
                    c2 = utftext.charCodeAt(i+1);
                    c3 = utftext.charCodeAt(i+2);
                    string += String.fromCharCode(((c & 15) << 12) | ((c2 & 63) << 6) | (c3 & 63));
                    i += 3;
                }

            }

            return string;
        }

    }
})(jQuery);