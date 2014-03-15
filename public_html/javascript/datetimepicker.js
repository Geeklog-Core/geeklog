/* Reminder: always indent with 4 spaces (no tabs). */
// +---------------------------------------------------------------------------+
// | Geeklog 2.1                                                               |
// +---------------------------------------------------------------------------+
// | jQuery UI datetimepicker utility                                          |
// +---------------------------------------------------------------------------+
// | Copyright (C) 2013-2014 by the following authors:                         |
// |                                                                           |
// | Authors: Kenji ITO        - mystralkk AT gmail DOT com                    |
// |          Yoshinori Tahara - taharaxp AT gmail DOT com                     |
// +---------------------------------------------------------------------------+
// |                                                                           |
// | This program is free software; you can redistribute it and/or             |
// | modify it under the terms of the GNU General Public License               |
// | as published by the Free Software Foundation; either version 2            |
// | of the License, or (at your option) any later version.                    |
// |                                                                           |
// | This program is distributed in the hope that it will be useful,           |
// | but WITHOUT ANY WARRANTY; without even the implied warranty of            |
// | MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the             |
// | GNU General Public License for more details.                              |
// |                                                                           |
// | You should have received a copy of the GNU General Public License         |
// | along with this program; if not, write to the Free Software Foundation,   |
// | Inc., 59 Temple Place - Suite 330, Boston, MA  02111-1307, USA.           |
// |                                                                           |
// +---------------------------------------------------------------------------+

if (!window.jQuery) {
    throw 'jQuery is not loaded';
}

var geeklog;

geeklog = geeklog || {};

geeklog.datetimepicker = {
    /**
    * Returns a date from the year/month/day dropdowns
    *
    * @param   string  selectorName    the common part of dropdown names
    * @return  string                  the selected date ("YYYY-MM-DD")
    */
    getDateTimeFromSelectors: function (selectorName) {
        var year, month, day, hour, minute, ampm, d, t;

        year  =       $("select[name='" + selectorName + "_year']").val(),
        month = '0' + $("select[name='" + selectorName + "_month']").val(),
        day   = '0' + $("select[name='" + selectorName + "_day']").val();

        month = month.substr(month.length - 2, 2);
        day   = day.substr(day.length - 2, 2);

        d = year + '-' + month + '-' + day; // YYYY-MM-DD

        hour   = '0' + $("select[name='" + selectorName + "_hour']").val();
        minute = '0' + $("select[name='" + selectorName + "_minute']").val();

        hour   = hour.substr(hour.length - 2, 2);
        minute = minute.substr(minute.length - 2, 2);

        t = hour + ':' + minute; // HH:mm

        if (geeklog.hour_mode == 12) {
            ampm = $("select[name='" + selectorName + "_ampm']").val();
            t = t + ' ' + ampm; // hh:mm tt
        }

        return d + ' ' + t;
    },

    /**
    * Converts ISO-639-1 code to that used in jQuery UI datepicker
    *
    * @param   string  langCode    language code (in ISO-639-1)
    * @return  string              language code (in jQuery UI)
    */
    fixLangCode: function (langCode) {
        switch (langCode) {
            case 'en':
                langCode = 'en-GB';
                break;

            case 'fr-ca':
                langCode = 'fr';
                break;

            case 'nb':
                langCode = 'no';
                break;

            case 'pt-br':
                langCode = 'pt-BR';
                break;

            case 'zh-cn':
                langCode = 'zh-CN';
                break;

            case 'zh':
                langCode = 'zh-TW';
                break;
        }

        return langCode;
    },

    options: {
        // for datepickers
        autoSize: true,
        buttonImage: '',
        buttonImageOnly: true,
        buttonText: '...',
        dateFormat: 'yy-mm-dd', // YYYY-MM-DD
        showOn: 'button',

        // for timepickers
//        addSliderAccess: true,
//        sliderAccessArgs: { touchonly: false },
        timeFormat: 'HH:mm',
        stepHour: 1,
        stepMinute: 1
    },

    /**
    * Adds a jQuery UI datepicker to year/month/day dropdowns
    *
    * The dropdowns must be named like '{common_part}_year', '{common_part}_month',
    * '{common_part}_day'.
    *
    * @param   string  selectorName    the common part of dropdown names
    * @param   string  langCode        ISO-639-1 language code
    * @param   string  toolTip         a tooltip string when the mouse cursor
    *                                  is over the calendar icon
    * @param   string  imgUrl          the URL of a calendar icon
    * @return  (void)
    */
    set: function (selectorName, langCode, toolTip, imgUrl) {
        var $ = jQuery, inputId, dt, tt;

        // Checks parameters
        if (!selectorName) {
            throw 'Selector name must not be empty';
        }

        if (!imgUrl) {
            throw 'Image URL must not be empty';
        }

        langCode = langCode || 'en';
        toolTip  = toolTip || geeklog.lang.tooltip_select_date;

        // Fixes language code for jQuery UI
        langCode = this.fixLangCode(langCode);

        // Sets default locale
        $.datepicker.setDefaults($.datepicker.regional[langCode]);
        $.timepicker.setDefaults($.timepicker.regional[langCode]);

        // Set options for datetimepickers
        this.options.buttonImage = imgUrl;
        this.options.buttonText = toolTip;
        this.options.timeFormat = (geeklog.hour_mode == 12) ? 'hh:mm tt' : 'HH:mm';

        // Creates an invisible input field for a datetimepicker
        inputId = selectorName + '_value_hidden';

        $("select[name='" + selectorName + "_month']")
            .before('<input type="text" id="' + inputId + '" style="display:none;" value=""' + geeklog.xhtml + '>&nbsp;');

        // Attaches a datetimepicker to the input field
        $('#' + inputId).datetimepicker(this.options);

        dt = this.getDateTimeFromSelectors(selectorName);
        $('#' + inputId).val(dt);

        // When a date is selected, then it is reflected back to the selectors
        $('#' + inputId).change(function () {
            var inputId = $(this).attr('id');
            var selectorName = inputId.substr(0, inputId.indexOf('_value_hidden'));
            var dt = $(this).val();

            $("select[name='" + selectorName + "_month']").val(parseInt(dt.substr(5, 2), 10));
            $("select[name='" + selectorName + "_year']").val(parseInt(dt.substr(0, 4)), 10);
            $("select[name='" + selectorName + "_day']").val(dt.substr(8, 2));
            $("select[name='" + selectorName + "_hour']").val(dt.substr(11, 2));
            $("select[name='" + selectorName + "_minute']").val(dt.substr(14, 2));
            if (geeklog.hour_mode == 12) {
                tt = dt.substr(17);
                if (tt != 'am' && tt != 'pm') {
                    tt = ($.inArray(tt, $.timepicker._defaults.amNames) == -1) ? 'pm' : 'am';
                }
                $("select[name='" + selectorName + "_ampm']").val(tt);
            }
        });

        // When the month, day or year selectors is changed, then their values
        // are reflected back to the input field
        $("select[name^='" + selectorName + "_']").change(function () {
            var selectorName = $(this).attr('name'),
                inputId, dt;

            selectorName = selectorName.substr(0, selectorName.lastIndexOf('_'));
            inputId = selectorName + '_value_hidden';
            dt = geeklog.datetimepicker.getDateTimeFromSelectors(selectorName);
            $('#' + inputId).val(dt);
        });
    }
};
