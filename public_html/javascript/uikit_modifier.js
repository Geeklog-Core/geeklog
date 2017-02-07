(function(UI) {

    "use strict";

    // Based on UIkit 2.27.2 tab.js
    UI.component('tab', {

        defaults: {
            target    : '>li:not(.uk-tab-responsive, .uk-disabled)',
            connect   : false,
            active    : 0,
            animation : false,
            duration  : 200,
            swiping   : true
        },

        boot: function() {

            // init code
            UI.ready(function(context) {

                UI.$('[data-uk-tab]', context).each(function() {

                    var tab = UI.$(this);

                    if (!tab.data('tab')) {
                        var obj = UI.tab(tab, UI.Utils.options(tab.attr('data-uk-tab')));
                    }
                });
            });
        },

        init: function() {

            var $this = this;

            this.current = false;

            this.on('click.uk.tab', this.options.target, function(e) {

                // Modified for Geeklog
                if (UI.$(this).find('a:first').attr('href') == '#') {
                    e.preventDefault();
                }

                if ($this.switcher && $this.switcher.animating) {
                    return;
                }

                var current = $this.find($this.options.target).not(this);

                current.removeClass('uk-active').blur();

                $this.trigger('change.uk.tab', [UI.$(this).addClass('uk-active'), $this.current]);

                $this.current = UI.$(this);

                // Update ARIA
                if (!$this.options.connect) {
                    current.attr('aria-expanded', 'false');
                    UI.$(this).attr('aria-expanded', 'true');
                }
            });

            if (this.options.connect) {
                this.connect = UI.$(this.options.connect);
            }

            // init responsive tab
            this.responsivetab = UI.$('<li class="uk-tab-responsive uk-active"><a></a></li>').append('<div class="uk-dropdown uk-dropdown-small"><ul class="uk-nav uk-nav-dropdown"></ul><div>');

            this.responsivetab.dropdown = this.responsivetab.find('.uk-dropdown');
            this.responsivetab.lst      = this.responsivetab.dropdown.find('ul');
            this.responsivetab.caption  = this.responsivetab.find('a:first');

            if (this.element.hasClass('uk-tab-bottom')) this.responsivetab.dropdown.addClass('uk-dropdown-up');

            // handle click
            this.responsivetab.lst.on('click.uk.tab', 'a', function(e) {

                e.preventDefault();
                e.stopPropagation();

                var link = UI.$(this);

                $this.element.children('li:not(.uk-tab-responsive)').eq(link.data('index')).trigger('click');
            });

            this.on('show.uk.switcher change.uk.tab', function(e, tab) {
                $this.responsivetab.caption.html(tab.text());
            });

            this.element.append(this.responsivetab);

            // init UIkit components
            if (this.options.connect) {
                
                this.switcher = UI.switcher(this.element, {
                    toggle    : '>li:not(.uk-tab-responsive)',
                    connect   : this.options.connect,
                    active    : this.options.active,
                    animation : this.options.animation,
                    duration  : this.options.duration,
                    swiping   : this.options.swiping
                });
            }

            UI.dropdown(this.responsivetab, {mode: 'click', preventflip: 'y'});

            // init
            $this.trigger('change.uk.tab', [this.element.find(this.options.target).not('.uk-tab-responsive').filter('.uk-active')]);

            this.check();

            UI.$win.on('resize orientationchange', UI.Utils.debounce(function(){
                if ($this.element.is(':visible'))  $this.check();
            }, 100));

            this.on('display.uk.check', function(){
                if ($this.element.is(':visible'))  $this.check();
            });
        },

        check: function() {

            var children = this.element.children('li:not(.uk-tab-responsive)').removeClass('uk-hidden');

            if (!children.length) {
                this.responsivetab.addClass('uk-hidden');
                return;
            }

            var top          = (children.eq(0).offset().top + Math.ceil(children.eq(0).height()/2)),
                doresponsive = false,
                item, link, clone;

            this.responsivetab.lst.empty();

            children.each(function(){

                if (UI.$(this).offset().top > top) {
                    doresponsive = true;
                }
            });

            if (doresponsive) {

                for (var i = 0; i < children.length; i++) {

                    item  = UI.$(children.eq(i));
                    link  = item.find('a');

                    if (item.css('float') != 'none' && !item.attr('uk-dropdown')) {

                        if (!item.hasClass('uk-disabled')) {

                            clone = UI.$(item[0].outerHTML);
                            clone.find('a').data('index', i);

                            this.responsivetab.lst.append(clone);
                        }

                        item.addClass('uk-hidden');
                    }
                }
            }

            this.responsivetab[this.responsivetab.lst.children('li').length ? 'removeClass':'addClass']('uk-hidden');
        }
    });

    UI.modal.confirm = function(content, onconfirm, oncancel) {

        var options = arguments.length > 1 && arguments[arguments.length-1] ? arguments[arguments.length-1] : {};

        onconfirm = UI.$.isFunction(onconfirm) ? onconfirm : function(){};
        oncancel  = UI.$.isFunction(oncancel) ? oncancel : function(){};
        options   = UI.$.extend(true, {bgclose:false, keyboard:false, modal:false, labels:UI.modal.labels}, UI.$.isFunction(options) ? {}:options);

        var button = (options.labels.Cancel == '')
            ? '<div class="uk-modal-footer uk-text-right"><button class="uk-button uk-button-primary js-modal-confirm">'+options.labels.Ok+'</button></div>'
            : '<div class="uk-modal-footer uk-text-right"><button class="uk-button js-modal-confirm-cancel">'+options.labels.Cancel+'</button> <button class="uk-button uk-button-primary js-modal-confirm">'+options.labels.Ok+'</button></div>';

        var modal = UI.modal.dialog(([
            '<div class="uk-margin uk-modal-content">'+String(content)+'</div>',
            button
        ]).join(""), options);

        modal.element.find(".js-modal-confirm, .js-modal-confirm-cancel").on("click", function(){
            UI.$(this).is('.js-modal-confirm') ? onconfirm() : oncancel();
            modal.hide();
        });

        modal.on('show.uk.modal', function(){
            setTimeout(function(){
                modal.element.find('.js-modal-confirm').focus();
            }, 50);
        });

        return modal.show();
    };

})(UIkit);