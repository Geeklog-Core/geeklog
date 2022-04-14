<?php

namespace Geeklog;

use HTTP_Request2;
use HTTP_Request2_Exception;
use HTTP_Request2_LogicException;
use RobThree\Auth\Providers\Qr\IQRCodeProvider;
use RobThree\Auth\Providers\Qr\QRException;

/**
 * Class QRCodeProvider
 *
 * @package Geeklog
 * @note This class is a substitute for RobThree\Auth\Providers\Qr\QRServerProvider since it requires cURL.
 */
class QRCodeProvider implements IQRCodeProvider
{
    protected $verifyssl;
    public $errorcorrectionlevel;
    public $margin;
    public $qzone;
    public $bgcolor;
    public $color;
    public $format;

    /**
     * QRCodeProvider constructor.
     *
     * @param  bool    $verifyssl
     * @param  string  $errorcorrectionlevel
     * @param  int     $margin
     * @param  int     $qzone
     * @param  string  $bgcolor
     * @param  string  $color
     * @param  string  $format
     * @throws QRException
     */
    function __construct($verifyssl = false, $errorcorrectionlevel = 'L', $margin = 4, $qzone = 1, $bgcolor = 'ffffff', $color = '000000', $format = 'png')
    {
        if (!is_bool($verifyssl))
            throw new QRException('VerifySSL must be bool');

        $this->verifyssl = $verifyssl;

        $this->errorcorrectionlevel = $errorcorrectionlevel;
        $this->margin = $margin;
        $this->qzone = $qzone;
        $this->bgcolor = $bgcolor;
        $this->color = $color;
        $this->format = $format;
    }

    /**
     * @param  string  $url
     * @return bool|string
     */
    public function getContent($url)
    {
        global $_CONF;

        $req = new HTTP_Request2($url, HTTP_Request2::METHOD_GET);
        $options = [
            'connect_timeout' => 10,
            'timeout'         => 10,
            'ssl_verify_peer' => $this->verifyssl,
        ];

        if (!is_readable(@ini_get('openssl.cafile')) &&
                !is_dir(@ini_get('openssl.capath'))) {
            $options['ssl_cafile'] = $_CONF['path_data'] . 'cacert.pem';
        }

        try {
            $req->setConfig($options);
            $req->setHeader('User-Agent', 'TwoFactorAuth');
        } catch (HTTP_Request2_LogicException $e) {
        }

        try {
            $response = $req->send();
            $status = $response->getStatus();

            if ($status == 200) {
                return $response->getBody();
            } else {
                return false;
            }
        } catch (HTTP_Request2_Exception $e) {
            Log::error($e->getMessage());

            return false;
        }
    }

    /**
     * @return string
     * @throws QRException
     */
    public function getMimeType()
    {
        switch (strtolower($this->format))
        {
            case 'png':
                return 'image/png';
            case 'gif':
                return 'image/gif';
            case 'jpg':
            case 'jpeg':
                return 'image/jpeg';
            case 'svg':
                return 'image/svg+xml';
            case 'eps':
                return 'application/postscript';
        }
        throw new QRException(sprintf('Unknown MIME-type: %s', $this->format));
    }

    /**
     * @param $qrtext
     * @param $size
     * @return bool|string
     */
    public function getQRCodeImage($qrtext, $size)
    {
        return $this->getContent($this->getUrl($qrtext, $size));
    }

    /**
     * @param $value
     * @return string
     */
    private function decodeColor($value)
    {
        return vsprintf('%d-%d-%d', sscanf($value, "%02x%02x%02x"));
    }

    /**
     * @param $qrtext
     * @param $size
     * @return string
     */
    public function getUrl($qrtext, $size)
    {
        return 'https://api.qrserver.com/v1/create-qr-code/'
            . '?size=' . $size . 'x' . $size
            . '&ecc=' . strtoupper($this->errorcorrectionlevel)
            . '&margin=' . $this->margin
            . '&qzone=' . $this->qzone
            . '&bgcolor=' . $this->decodeColor($this->bgcolor)
            . '&color=' . $this->decodeColor($this->color)
            . '&format=' . strtolower($this->format)
            . '&data=' . rawurlencode($qrtext);
    }
}
