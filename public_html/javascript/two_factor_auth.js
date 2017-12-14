// Hide QR code
var geeklog;

geeklog = geeklog || {};

geeklog.tfa = {
    elements: document.getElementsByClassName('tfa'),
    init: function () {
        'use strict';
        var self = this;

        // Hide QR code and backup codes at first
        this.hideTFAElements();

        // Show/Hide QR code image
        document.getElementById('enable_tfa').addEventListener('change', function (ev) {
            if (ev.target.value === '0') {
                self.hideTFAElements();
            } else {
                self.showTFAElements();
            }
        }, false);
    },
    showTFAElements: function () {
        'use strict';
        var i;
        for (i = 0; i < this.elements.length; i++) {
            this.elements[i].style.display = '';
        }
    },
    hideTFAElements: function () {
        'use strict';
        var i;
        for (i = 0; i < this.elements.length; i++) {
            this.elements[i].style.display = 'none';
        }
    }
};

geeklog.tfa.init();
