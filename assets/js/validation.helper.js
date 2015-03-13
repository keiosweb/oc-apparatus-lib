;
(function ($, window, document, undefined) {

    "use strict";

    var defaults = {
        messageClass: 'validation-message',
        debug: true
    };

    function ValidationHelper() {
        var self = this;
        this.errorFieldsCache = {};
        this.$window = $(window);

        var configurationEvent = $.Event('apparatus.validation.configure');
        this.$window.trigger(configurationEvent);

        if (!configurationEvent.config) {
            configurationEvent.config = {};
        }

        this.config = $.extend({}, defaults, configurationEvent.config);

        this.$window.on('oc.beforeRequest', function () {
            self.clearValidationErrors();
        });

        // kill alert
        this.$window.on('ajaxErrorMessage', function (event) {
            event.preventDefault();
        });

        this.$window.on('ajaxError', function (event, context, textString, jqXHR) {
            // show errors other than validation in console
            if (self.config.debug && jqXHR.hasOwnProperty('responseJSON') && jqXHR['responseJSON'].hasOwnProperty('X_OCTOBER_ERROR_MESSAGE')) {
                console.log(jqXHR['responseJSON']['X_OCTOBER_ERROR_MESSAGE']);
            }
        });

        this.$window.on('ajaxInvalidField', function (event, fieldElement, fieldName, fieldMessages, isFirstInvalidField) {
            self.handleInvalidField(fieldElement, fieldName, fieldMessages, isFirstInvalidField);
        });
    }

    ValidationHelper.prototype.clearValidationErrors = function () {
        for (var field in this.errorFieldsCache) {
            if (this.errorFieldsCache.hasOwnProperty(field)) {
                this.errorFieldsCache[field].empty();
            }
        }
    };

    ValidationHelper.prototype.getErrorContainer = function (fieldName, refresh) {
        if (this.errorFieldsCache.hasOwnProperty(fieldName) && !refresh) {
            return this.errorFieldsCache[fieldName];
        } else {
            this.errorFieldsCache[fieldName] = $('#' + fieldName + '_validation');
            return this.errorFieldsCache[fieldName];
        }
    };

    ValidationHelper.prototype.handleInvalidField = function (fieldElement, fieldName, fieldMessages, isFirstInvalidField) {
        var container = this.getErrorContainer(fieldName);
        var self = this;

        fieldMessages.forEach(function (message) {
            container.append('<p class="' + self.config.messageClass + '">' + message + '</p>');
        });

        if (isFirstInvalidField){
            fieldElement.focus();
        }
    };

    $.validation = new ValidationHelper();

})(jQuery, window, document);

