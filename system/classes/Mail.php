<?php

namespace Geeklog;

use Exception;
use GLText;
use Swift_Attachment;
use Swift_Mailer;
use Swift_MailTransport;
use Swift_Message;
use Swift_Mime_ContentEncoder_Base64ContentEncoder;
use Swift_Plugins_DecoratorPlugin;
use Swift_RfcComplianceException;
use Swift_SendmailTransport;
use Swift_SmtpTransport;

/**
 * Class Mail
 *
 * @package Geeklog
 */
class Mail
{
    const NEW_LINE = "\r\n";

    /**
     * Strip a new line
     *
     * @param  string|array $item
     * @return string|array
     */
    public static function stripControlCharacters($item)
    {
        if (is_array($item)) {
            return array_map('\Geeklog\Mail::stripControlCharacters', $item);
        } else {
            $item = substr($item, 0, strcspn($item, self::NEW_LINE));
            $item = preg_replace('/[[:cntrl:]]/', '', $item);
        }

        return $item;
    }

    /**
     * Send an email.
     * All emails sent by Geeklog are sent through this function.
     * NOTE: Please note that using CC: will expose the email addresses of
     *       all recipients. Use with care.
     *
     * @param    string|array $to          recipients name and email address
     * @param    string       $subject     subject of the email
     * @param    string       $body        the text of the email
     * @param    string|array $from        (optional) sender of the the email
     * @param    bool         $html        (optional) true if to be sent as HTML email
     * @param    int          $priority    (optional) add X-Priority header, if > 0
     * @param    mixed        $optional    (optional) other headers or CC:
     * @param    array        $attachments (optional) attachment files
     * @return   bool                      true if successful,  otherwise false
     */
    public static function send($to, $subject, $body, $from = '', $html = false, $priority = 0, $optional = null, array $attachments = [])
    {
        global $_CONF;

        if (empty($to)) {
            COM_errorLog("Invalid To address '{$to}' sent to COM_Mail.", 1);

            return false;
        }

        // Remove new lines
        $to = self::stripControlCharacters($to);
        $from = self::stripControlCharacters($from);
        $subject = self::stripControlCharacters($subject);

        // Set up transport
        switch ($_CONF['mail_settings']['backend']) {
            case 'sendmail':
                $arg = $_CONF['mail_settings']['sendmail_path'] . ' ' . $_CONF['mail_settings']['sendmail_args'];
                $transport = Swift_SendmailTransport::newInstance($arg);
                break;

            case 'smtp':
                $transport = Swift_SmtpTransport::newInstance($_CONF['mail_settings']['host'], $_CONF['mail_settings']['port']);

                if (!empty($_CONF['mail_settings']['auth'])) {
                    $transport->setUsername($_CONF['mail_settings']['username']);
                    $transport->setPassword($_CONF['mail_settings']['password']);
                }

                break;

            case 'smtps':
                $transport = Swift_SmtpTransport::newInstance($_CONF['mail_settings']['host'], $_CONF['mail_settings']['port'], 'ssl');

                if (!empty($_CONF['mail_settings']['auth'])) {
                    $transport->setUsername($_CONF['mail_settings']['username']);
                    $transport->setPassword($_CONF['mail_settings']['password']);
                }

                break;

            case 'mail':
            default:
                $transport = Swift_MailTransport::newInstance();
                break;
        }

        $mailer = Swift_Mailer::newInstance($transport);

        // Set up replacements
        $decorator = new Swift_Plugins_DecoratorPlugin(new MailReplacements());
        $mailer->registerPlugin($decorator);

        // Create a message
        $message = Swift_Message::newInstance();

        // Avoid double dots problem
        $message->setEncoder(new Swift_Mime_ContentEncoder_Base64ContentEncoder());

        if (!empty($_CONF['mail_charset'])) {
            $message->setCharset($_CONF['mail_charset']);
        } else {
            $message->setCharset(COM_getCharset());
        }

        // Set subject
        $message->setSubject($subject);

        // Set from
        if (empty($from)) {
            $message->setFrom([$_CONF['site_mail'] => $_CONF['site_name']]);
        } else {
            $message->setFrom($from);
        }

        // Set to
        $message->setTo($to);

        if (!empty($optional) && !is_array($optional)) {
            $optional = self::stripControlCharacters($optional);
        }

        if (!empty($optional) && !is_array($optional)) {
            // assume old (optional) CC: header
            $message->setCc($optional);
        }

        // Set body
        if (!$html) {
            // bug #430
            $body = GLText::removeAllHTMLTagsAndAttributes($body);

            // bug #1000
            // Need to do this since htmLawed not only strips the tags it converts html special chars to entities which we do not want
            $body = htmlspecialchars_decode($body, ENT_QUOTES);
        }

        $message->setBody($body);

        if ($html) {
            $message->setContentType('text/html');
            $message->addPart($body, 'text/plain');
        } else {
            $message->setContentType('text/plain');
        }

        // Set priority
        if ($priority > 0) {
            $message->setPriority($priority);
        }

        // Add additional headers
        $headers = $message->getHeaders();
        $headers->addTextHeader('X-Mailer', 'Geeklog ' . VERSION);

        if (!empty(IP::getIPAddress()) && !empty($_SERVER['SERVER_ADDR']) &&
            (IP::getIPAddress() !== $_SERVER['SERVER_ADDR'])
        ) {
            $url = COM_getCurrentURL();

            if (substr($url, 0, strlen($_CONF['site_admin_url']))
                != $_CONF['site_admin_url']
            ) {
                $headers->addTextHeader('X-Originating-IP', \Geeklog\IP::getIPAddress());
            }
        }

        if (is_array($optional) && (count($optional) > 0)) {
            foreach ($optional as $h => $v) {
                if (strcasecmp($h, 'Cc') === 0) {
                    $message->setCc($v);
                } elseif (strcasecmp($h, 'Bcc') === 0) {
                    $message->setBcc($v);
                } else {
                    $headers->addTextHeader($h, $v);
                }
            }
        }

        // Set attachments
        if (count($attachments) > 0) {
            foreach ($attachments as $attachment) {
                $message->attach(Swift_Attachment::fromPath($attachment));
            }
        }

        // Send a message
        $numSent = 0;

        try {
            $numSent = (int) $mailer->send($message, $failures);

            if ($numSent !== 1) {
                COM_errorLog(__METHOD__ . ': failed to send an email to ' . @$failures[0]);
            }
        } catch (Exception $e) {
            COM_errorLog(__METHOD__ . 'Failed to send an email to ' . $to . '.  Error message: ' . $e->getMessage());
        }

        return ($numSent === 1);
    }
}
