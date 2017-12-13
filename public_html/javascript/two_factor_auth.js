// Hide QR code
var geeklog;

geeklog = geeklog || {};
geeklog.tfa = {
    imageTag: document.getElementById('qrcode_data'),
    init: function () {
        'use strict';
        var self = this;

        // Hide QR code for the first time
        this.hideQRCodeImage();

        // Show/Hide QR code image
        document.getElementById('enable_tfa').addEventListener('change', function (ev) {
            if (ev.target.value === '0') {
                self.hideQRCodeImage();
            } else {
                self.showQRCodeImage();
            }
        }, false);
    },
    showQRCodeImage: function () {
        'use strict';
        this.imageTag.style.display = '';
    },
    hideQRCodeImage: function () {
        'use strict';
        this.imageTag.style.display = 'none';
    }
};

geeklog.tfa.init();
