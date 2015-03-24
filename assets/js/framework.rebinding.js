;
$(function () {
    $(window).on('ajaxUpdateComplete', function () {

        $(document).off('change', 'select[data-request], input[type=radio][data-request], input[type=checkbox][data-request]')
            .on('change', 'select[data-request], input[type=radio][data-request], input[type=checkbox][data-request]', function () {
                $(this).request();
            });

        $(document).off('click', 'a[data-request], button[data-request], input[type=button][data-request], input[type=submit][data-request]')
            .on('click', 'a[data-request], button[data-request], input[type=button][data-request], input[type=submit][data-request]', function () {
                $(this).request();
                return false
            });

        $(document).off('keydown', 'input[type=text][data-request], input[type=submit][data-request], input[type=password][data-request]')
            .on('keydown', 'input[type=text][data-request], input[type=submit][data-request], input[type=password][data-request]', function (e) {
                if (e.keyCode == 13) {
                    if (this.dataTrackInputTimer !== undefined)
                        window.clearTimeout(this.dataTrackInputTimer);

                    $(this).request();
                    return false
                }
            });

        $(document).off('keyup', 'input[type=text][data-request][data-track-input], input[type=password][data-request][data-track-input]')
            .on('keyup', 'input[type=text][data-request][data-track-input], input[type=password][data-request][data-track-input]', function (e) {
                var
                    $el = $(this),
                    lastValue = $el.data('oc.lastvalue');

                if (lastValue !== undefined && lastValue == this.value)
                    return;

                $el.data('oc.lastvalue', this.value);

                if (this.dataTrackInputTimer !== undefined)
                    window.clearTimeout(this.dataTrackInputTimer);

                var interval = $(this).data('track-input');
                if (!interval)
                    interval = 300;

                var self = this;
                this.dataTrackInputTimer = window.setTimeout(function () {
                    $(self).request()
                }, interval)
            });

        $(document).off('submit', '[data-request]')
            .on('submit', '[data-request]', function () {
                $(this).request();
                return false
            })
    });
});