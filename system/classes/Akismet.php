<?php

namespace Geeklog;

use InvalidArgumentException;

class Akismet
{
    // Akismet class version
    const VERSION = '1.0.0';

    // User Agent string
    const UA = 'Geeklog/%s | Akismet %s';

    /**
     * Comment types
     *
     * @see https://akismet.com/development/api/#comment-check
     * @see https://blog.akismet.com/2012/06/19/pro-tip-tell-us-your-comment_type/
     */
    const COMMENT_TYPE_COMMENT = 'comment';
    const COMMENT_TYPE_FORUM_POST = 'forum-post';
    const COMMENT_TYPE_BLOG_POST = 'blog-post';
    const COMMENT_TYPE_CONTACT_FORM = 'contact-form';
    const COMMENT_TYPE_SIGNUP = 'signup';
    const COMMENT_TYPE_MESSAGE = 'message';
    const COMMENT_TYPE_TRACKBACK = 'trackback';
    const COMMENT_TYPE_EVENT = 'event';
    const COMMENT_TYPE_LINK = 'link';
    const COMMENT_TYPE_PROFILE = 'profile';

    // Result types
    const RESULT_HAM = 0;           // = PLG_SPAM_NOT_FOUND
    const RESULT_SPAM = 1;          // = PLG_SPAM_FOUND
    const RESULT_MAYBE_SPAM = 2;    // = PLG_SPAM_UNSURE

    // Time out in seconds when $_SPX_CONF['timeout'] is not set
    const STREAM_TIMEOUT = 5;

    /**
     * API key
     *
     * @var string
     */
    private $APIKey;

    /**
     * Site URL
     *
     * @var
     */
    private $siteURL;

    /**
     * @var bool
     */
    private $isAPIKeyVerified = false;

    /**
     * Akismet constructor.
     *
     * @param  string $APIKey
     * @param  string $siteURL
     * @throws InvalidArgumentException
     */
    public function __construct($APIKey, $siteURL)
    {
        $APIKey = trim($APIKey);
        $siteURL = trim($siteURL);

        if (empty($APIKey)) {
            throw new InvalidArgumentException('You have to set a valid API key for Akismet.');
        }

        if (empty($siteURL)) {
            throw new InvalidArgumentException('You have to set your site URL.');
        }

        $this->APIKey = $APIKey;
        $this->siteURL = $siteURL;
        $this->isAPIKeyVerified = $this->verifyAPIKey();
    }

    /**
     * Write into error log
     *
     * @param  string $entry
     */
    private function log($entry)
    {
        if (is_callable('COM_errorLog')) {
            COM_errorLog($entry);
        } else {
            log($entry);
        }
    }

    /**
     * Return User Agent string
     *
     * @return string
     */
    private function getUAString()
    {
        return sprintf(self::UA, VERSION, self::VERSION);
    }

    /**
     * Send request to Akismet server
     *
     * @param  string $path
     * @param  array  $data
     * @return array|false in case of success, return an array of (0 => 'response headers', 1 => 'result'),
     *                      otherwise false
     */
    private function send($path, array $data)
    {
        global $_SPX_CONF;

        $data = http_build_query($data, '', '&');
        $host = $http_host = $this->APIKey . '.rest.akismet.com';
        $port = 443;
        $akismetUA = $this->getUAString();
        $contentLength = strlen($data);
        $httpRequest = "POST {$path} HTTP/1.0\r\n"
            . "Host: {$host}\r\n"
            . "Content-Type: application/x-www-form-urlencoded\r\n"
            . "Content-Length: {$contentLength}\r\n"
            . "User-Agent: {$akismetUA}\r\n"
            . "\r\n"
            . $data;

        // Set time out
        $timeout = self::STREAM_TIMEOUT;
        if (isset($_SPX_CONF['timeout']) && is_numeric($_SPX_CONF['timeout'])) {
            if ((int) $_SPX_CONF['timeout'] >= 1) {
                $timeout = (int) $_SPX_CONF['timeout'];
            }
        }

        if (($fs = @fsockopen('ssl://' . $http_host, $port, $errNo, $errStr, $timeout)) !== false) {
            stream_set_timeout($fs, $timeout);
            fwrite($fs, $httpRequest);
            $response = '';

            while (!feof($fs)) {
                $response .= fgets($fs, 1160);
            }

            fclose($fs);
            $response = explode("\r\n\r\n", $response, 2);
        } else {
            $this->log(sprintf('Code: %d  Message: %s', $errNo, $errStr));
            $response = false;
        }

        return $response;
    }

    /**
     * Extract a value from response text
     *
     * @param  string $haystack response text
     * @param  string $needle   field name
     * @return string
     */
    private function extractValueFromResponse($haystack, $needle)
    {
        $haystack = trim(str_replace(array("\r\n", "\r"), "\n", $haystack));

        foreach (explode("\n", $haystack) as $line) {
            if (stripos($line, $needle) === 0) {
                $colon = strpos($line, ':');

                return trim(substr($line, $colon + 1));
            }
        }

        return '';
    }

    /**
     * Check if your API key is valid
     *
     * @see https://akismet.com/development/api/#verify-key
     * @return bool true = valid, false otherwise
     */
    public function verifyAPIKey()
    {
        if (!isset($this->siteURL, $this->APIKey)) {
            return false;
        }

        $path = '/1.1/verify-key';
        $data = array(
            'key'  => $this->APIKey,
            'blog' => $this->siteURL,
        );
        $response = $this->send($path, $data);

        if (is_array($response) && ($response[1] === 'valid')) {
            return true;
        } else {
            if (is_array($response)) {
                $this->log(
                    sprintf(
                        'Verification failed.  The following is the response from the server: \\n%s',
                        $response[0]
                    )
                );
            }

            return false;
        }
    }

    /**
     * Prepare common data for APIs
     *
     * @param  string $content
     * @param  string $permanentLink
     * @param  string $commentType
     * @param  string $commentAuthor
     * @param  string $commentAuthorEmail
     * @param  string $commentAuthorURL
     * @param  bool   $isTest
     * @return array
     */
    private function prepareData($content, $permanentLink, $commentType, $commentAuthor, $commentAuthorEmail, $commentAuthorURL, $isTest)
    {
        global $LANG01;

        $data = array(
            'blog'            => $this->siteURL,
            'blog_charset'    => COM_getCharset(),
            'blog_lang'       => COM_getLangIso639Code(),
            'user_ip'         => Input::server('REMOTE_ADDR'),
            'user_agent'      => Input::server('HTTP_USER_AGENT'),
            'referrer'        => Input::server('HTTP_REFERER'),
            'permalink'       => $permanentLink,
            'comment_content' => $content,
            'comment_type'    => $commentType,
        );

        if (!empty($commentAuthor) && ($commentAuthor !== $LANG01[24])) {   // Anonymous
            $data['comment_author'] = $commentAuthor;
        }
        if (!empty($commentAuthorEmail)) {
            $data['comment_author_email'] = $commentAuthorEmail;
        }
        if (!empty($commentAuthorURL)) {
            $data['comment_author_url'] = $commentAuthorURL;
        }
        if ($isTest) {
            $data['is_test'] = 1;
        }

        return $data;
    }

    /**
     * Check for spam
     *
     * @see https://akismet.com/development/api/#comment-check
     * @param  string $content
     * @param  string $permanentLink
     * @param  string $commentType
     * @param  string $commentAuthor
     * @param  string $commentAuthorEmail
     * @param  string $commentAuthorURL
     * @param  bool   $isTest
     * @return int either RESULT_HAM, RESULT_SPAM or RESULT_MAYBE_SPAM
     */
    public function checkForSpam($content, $permanentLink = null, $commentType = self::COMMENT_TYPE_COMMENT,
                                 $commentAuthor = null, $commentAuthorEmail = null, $commentAuthorURL = null, $isTest = false)
    {
        if (!$this->isAPIKeyVerified) {
            // Doesn't check
            return false;
        }

        $path = '/1.1/comment-check';
        $data = $this->prepareData(
            $content, $permanentLink, $commentType, $commentAuthor, $commentAuthorEmail, $commentAuthorURL, $isTest
        );
        $response = $this->send($path, $data);

        if (!is_array($response)) {
            return false;
        }

        switch ($response[1]) {
            case 'false':
                // Not a spam
                return self::RESULT_HAM;
                break;

            case 'true':
                // Spam
                if ($this->extractValueFromResponse($response[0], 'X-akismet-pro-tip') === 'discard') {
                    // Blatant spam
                    return self::RESULT_SPAM;
                } else {
                    // Maybe spam
                    return self::RESULT_MAYBE_SPAM;
                }

                break;

            case 'invalid':
                $this->log('Invalid request:' . $this->extractValueFromResponse($response[0], 'X-akismet-debug-help'));

                return self::RESULT_HAM;
                break;

            default:
                $this->log('Unknown result code "' . $response[1] . '" returned.');

                return self::RESULT_HAM;
                break;
        }
    }

    /**
     * Submit a spam
     *
     * @see https://akismet.com/development/api/#submit-spam
     * @param  string $content
     * @param  string $permanentLink
     * @param  string $commentType
     * @param  string $commentAuthor
     * @param  string $commentAuthorEmail
     * @param  string $commentAuthorURL
     * @param  bool   $isTest
     * @return bool true on success, false otherwise
     */
    public function submitSpam($content, $permanentLink = null, $commentType = self::COMMENT_TYPE_COMMENT,
                               $commentAuthor = null, $commentAuthorEmail = null, $commentAuthorURL = null, $isTest = false)
    {
        if (!$this->isAPIKeyVerified) {
            // Doesn't check
            return false;
        }

        $path = '/1.1/submit-spam';
        $data = $this->prepareData(
            $content, $permanentLink, $commentType, $commentAuthor, $commentAuthorEmail, $commentAuthorURL, $isTest
        );
        $response = $this->send($path, $data);

        if (is_array($response) && ($response[1]) === 'Thanks for making the web a better place.') {
            return true;
        } else {
            return false;
        }
    }

    /**
     * Submit a ham
     *
     * @see https://akismet.com/development/api/#submit-ham
     * @param  string $content
     * @param  string $permanentLink
     * @param  string $commentType
     * @param  string $commentAuthor
     * @param  string $commentAuthorEmail
     * @param  string $commentAuthorURL
     * @param  bool   $isTest
     * @return bool true on success, false otherwise
     */
    public function submitHam($content, $permanentLink = null, $commentType = self::COMMENT_TYPE_COMMENT,
                              $commentAuthor = null, $commentAuthorEmail = null, $commentAuthorURL = null, $isTest = false)
    {
        if (!$this->isAPIKeyVerified) {
            // Doesn't check
            return false;
        }

        $path = '/1.1/submit-ham';
        $data = $this->prepareData(
            $content, $permanentLink, $commentType, $commentAuthor, $commentAuthorEmail, $commentAuthorURL, $isTest
        );
        $response = $this->send($path, $data);

        if (is_array($response) && ($response[1]) === 'Thanks for making the web a better place.') {
            return true;
        } else {
            return false;
        }
    }
}
