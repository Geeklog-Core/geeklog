/* Reminder: always indent with 4 spaces (no tabs). */
// +---------------------------------------------------------------------------+
// | Geeklog 2.0                                                               |
// +---------------------------------------------------------------------------+
// | jQuery UI datepicker utility                                              |
// +---------------------------------------------------------------------------+
// | Copyright (C) 2013 by the following authors:                              |
// |                                                                           |
// |            Kenji ITO - mystralkk AT gmail DOT com                         |
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

geeklog.datepicker = {
    /**
    * Returns a date from the year/month/day dropdowns
    *
    * @param   string  selectorName    the common part of dropdown names
    * @return  string                  the selected date ("YYYY-MM-DD")
    */
    getDateFromSelectors: function (selectorName) {
        var y = $("select[name='" + selectorName + "_year']").val(),
            m = '0' + $("select[name='" + selectorName + "_month']").val(),
            d = '0' + $("select[name='" + selectorName + "_day']").val();

            m = m.substr(m.length - 2, 2);
            d = d.substr(d.length - 2, 2);

        return y + '-' + m + '-' + d;	// YYYY-MM-DD
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
        var $ = jQuery, inputId;

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

        // Set default options for datepickers
        $.datepicker.setDefaults({
            autoSize: true,
            buttonImage: imgUrl,
            buttonImageOnly: true,
            buttonText: toolTip,
            dateFormat: 'yy-mm-dd',
            showOn: 'button'
        });

        // Creates an invisible input field for a datepicker
        inputId = selectorName + '_value_hidden';
        $("select[name='" + selectorName + "_month']")
            .before('<span>&nbsp;</span><input type="text" id="' + inputId + '" style="display: none;" value="' + this.getDateFromSelectors(selectorName) + '" />&nbsp;');

        // Attaches a datepicker to the input field
        $('#' + inputId).datepicker();

        // Sets default locale
        $.datepicker.setDefaults($.datepicker.regional[langCode]);

        // Resets date format to 'YYYY-MM-DD'
        $.datepicker.setDefaults({
            dateFormat: 'yy-mm-dd'
        });

        // When a date is selected, then it is reflected back to the selectors
        $('#' + inputId).change(function () {
            var inputId = $(this).attr('id');
            var selectorName = inputId.substr(0, inputId.indexOf('_value_hidden'));
            var d = $(this).val();

            $("select[name='" + selectorName + "_month']").val(parseInt(d.substr(5, 2), 10));
            $("select[name='" + selectorName + "_year']").val(parseInt(d.substr(0, 4)), 10);
            $("select[name='" + selectorName + "_day']").val(d.substr(8, 2));
        });

        // When the month, day or year selectors is changed, then their values
        // are reflected back to the input field
        $("select[name^='" + selectorName + "_']").change(function () {
            var selectorName = $(this).attr('name'),
                inputId, d;

            selectorName = selectorName.substr(0, selectorName.lastIndexOf('_'));
            inputId = selectorName + '_value_hidden';
            d = geeklog.datepicker.getDateFromSelectors(selectorName);
            $('#' + inputId).val(d);
            $('#' + inputId).datepicker('setDate', d);
        });
    }
};
