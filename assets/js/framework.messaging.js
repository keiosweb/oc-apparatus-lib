;
$(function () {

    "use strict";

    if (!$.apparatus) {
        $.apparatus = {};
    }

    var defaults = {
        noty: {
            layout: 'top',
            theme: 'bootstrapTheme', // or 'relax'
            type: 'alert',
            text: '', // can be html or string
            dismissQueue: true, // If you want to use queue feature set this true
            template: '<div class="noty_message"><span class="noty_text"></span><div class="noty_close"></div></div>',
            animation: {
                open: 'animated bounceInLeft',
                close: 'animated bounceOutLeft'
            },
            timeout: false, // delay for closing event. Set false for sticky notifications
            force: false, // adds notification to the beginning of queue when set to true
            modal: false,
            maxVisible: 5, // you can set max visible notification for dismissQueue true option,
            killer: false, // for close all notifications before show
            closeWith: ['click'], // ['click', 'button', 'hover', 'backdrop'] // backdrop click will close all notifications
            callback: {
                onShow: function () {
                },
                afterShow: function () {
                },
                onClose: function () {
                },
                afterClose: function () {
                },
                onCloseClick: function () {
                }
            },
            buttons: false // an array of buttons
        }
    };

    var Messaging = function () {

        if (!window.noty) {
            return;
        }

        var self = this;

        var configEl = $('[data-messaging-config]');

        if (configEl.length) {
            configEl = configEl.first();
        }

        var config = this.makeConfig(configEl);

        this.config = $.extend(true, {}, defaults, config);

        // kill alert
        $(window).on('ajaxErrorMessage', function (event, message) {
            event.preventDefault();
            self.handleMessage({type: 'error', text: message});
        });
    };

    Messaging.prototype.handleMessage = function (options) {
        noty($.extend(true, {}, this.config.noty, options));
    };

    Messaging.prototype.handleFlashMessage = function (type, message) {
        this.handleMessage({type: this.parseFlashMessageType(type), text: message});
    };

    Messaging.prototype.parseFlashMessageType = function (flashMessageType) {
        switch (flashMessageType) {
            case 'info':
                return 'information';
                break;
            default:
                return flashMessageType;
                break;
        }
    };

    Messaging.prototype.makeConfig = function (configEl) {
        if (!configEl.data) {
            return {};
        }

        return {
            noty: {
                layout: configEl.data('msgLayout') ? configEl.data('msgLayout') : defaults.noty.layout,
                theme: configEl.data('msgTheme') ? configEl.data('msgTheme') : defaults.noty.theme,
                dismissQueue: configEl.data('msgDismissQueue'),
                template: configEl.data('msgTemplate') ? configEl.data('msgTemplate') : defaults.noty.template,
                animation: {
                    open: configEl.data('msgAnimationOpen') ? configEl.data('msgAnimationOpen') : defaults.noty.animation.open,
                    close: configEl.data('msgAnimationClose') ? configEl.data('msgAnimationClose') : defaults.noty.animation.close
                },
                timeout: configEl.data('msgTimeout') ? configEl.data('msgTimeout') : defaults.noty.timeout,
                force: configEl.data('msgForce') ? configEl.data('msgForce') : defaults.noty.force,
                modal: configEl.data('msgModal') ? configEl.data('msgModal') : defaults.noty.modal,
                maxVisible: configEl.data('msgMaxVisible') ? configEl.data('msgMaxVisible') : defaults.noty.maxVisible
            }
        };
    };

    $.apparatus.messaging = new Messaging();
});