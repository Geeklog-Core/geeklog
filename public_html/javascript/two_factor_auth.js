// This script is loaded only when two factor authentication is enabled
var geeklog;

geeklog = geeklog || {};

geeklog.tfa = {
    elements: document.getElementsByClassName('tfa'),

    /**
     * Initialize the Two Factor Auth handlers
     */
    init: function () {
        'use strict';
        var self = this;

        // Hide QR code and backup codes at first
        this.hideTFAElements();

        // Show/Hide QR code image and backup codes
        document.getElementById('enable_tfa').addEventListener('change', function (ev) {
            if (ev.target.value === '0') {
                self.hideTFAElements();
            } else {
                self.showTFAElements();
            }
        }, false);

        // Show/Hide QR code image
        document.getElementById('tfa_flip_qrcode').addEventListener('click', function (ev) {
            self.showHide(document.getElementById('tfa_qrcode'));
            ev.preventDefault();
        }, false);

        // Show/Hide Backup codes
        document.getElementById('tfa_flip_backupcodes').addEventListener('click', function (ev) {
            self.showHide(document.getElementById('tfa_backupcodes'));
            ev.preventDefault();
        }, false);
    },

    /**
     * Show / Hide an element
     *
     * @param elem
     */
    showHide: function (elem) {
        'use strict';
        elem.style.display = (elem.style.display === '') ? 'none' : '';
    },

    /**
     * Show / Hide elements
     * @param elements
     * @param style
     */
    common: function (elements, style) {
        'use strict';
        var i;
        for (i = 0; i <elements.length; i++) {
            elements[i].style.display = style;
        }
    },

    /**
     * Show elements with "tfa" class
     */
    showTFAElements: function () {
        'use strict';
        this.common(this.elements, '');
    },

    /**
     * Hide elements with "tfa" class
     */
    hideTFAElements: function () {
        'use strict';
        this.common(this.elements, 'none');
    }
};

geeklog.tfa.init();
