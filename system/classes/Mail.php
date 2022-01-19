<?php

namespace Geeklog;

use GLText;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

/**
 * Class Mail
 *
 * @package Geeklog
 */
class Mail
{
    const NEW_LINE = "\r\n";

    /**
     * Strip a new line to prevent injecting new lines
     *
     * @param  string|array  $item
     * @return string|array
     */
    public static function stripControlCharacters($item)
    {
        if (is_array($item)) {
            reset($item);

            return [self::stripControlCharacters(key($item)) => self::stripControlCharacters(current($item))];
        } else {
            $item = substr($item, 0, strcspn($item, self::NEW_LINE));
            $item = preg_replace('/[[:cntrl:]]/', '', $item);
        }

        return $item;
    }

    /**
     * Replace placeholders in the mail body with their actual values
     *
     * @param  string  $address
     * @param  string  $subject
     * @param  string  $body
     * @return void
     */
    private static function replacePlaceHolders($address, &$subject, &$body)
    {
        global $_CONF, $_TABLES;

        $address = DB_escapeString($address);
        $sql = <<<SQL
          SELECT u.*, i.location, i.lastgranted, i.lastlogin FROM {$_TABLES['users']} AS u 
            LEFT JOIN {$_TABLES['userinfo']} AS i 
              ON u.uid = i.uid
            WHERE u.email = '$address' 
SQL;
        $resultSet = DB_query($sql);

        if (!DB_error()) {
            $A = DB_fetchArray($resultSet, false);

            if (is_array($A) && (count($A) > 0)) {
                $search = [
                    // From database
                    '{uid}', '{username}', '{fullname}', '{email}', '{homepage}', '{theme}',
                    '{language}', '{location}', '{lastgranted}', '{lastlogin}',

                    // From $_CONF
                    '{site_url}', '{site_name}', '{site_slogan}', '{owner_name}',
                    '{copyrightyear}',
                    '{site_mail}', '{noreply_mail}',
                ];
                $replace = [
                    // From database
                    $A['uid'], $A['username'], $A['fullname'], $A['email'], $A['homepage'], $A['theme'],
                    $A['language'], $A['location'], $A['lastgranted'], $A['lastlogin'],

                    // From $_CONF
                    $_CONF['site_url'], $_CONF['site_name'], $_CONF['site_slogan'], $_CONF['owner_name'],
                    (isset($_CONF['copyrightyear']) ? $_CONF['copyrightyear'] : date('Y')),
                    $_CONF['site_mail'], $_CONF['noreply_mail'],
                ];

                $subject = str_replace($search, $replace, $subject);
                $body = str_replace($search, $replace, $body);
            }
        }
    }

    /**
     * Send an email
     *
     * All emails sent by Geeklog are sent through this function.
     * NOTE: Please note that using CC: will expose the email addresses of
     *       all recipients. Use with care.
     *
     * @param  string|array  $to           recipients name and email address
     * @param  string        $subject      subject of the email
     * @param  string        $body         the text of the email
     * @param  string|array  $from         (optional) sender of the email
     * @param  bool          $html         (optional) true if to be sent as HTML email
     * @param  int           $priority     (optional) add X-Priority header, if > 0
     * @param  mixed         $optional     (optional) other headers or CC:
     * @param  array         $attachments  (optional) attachment files
     * @return bool                        true if successful,  otherwise false
     */
    public static function send($to, $subject, $body, $from = '', $html = false, $priority = 0, $optional = null, array $attachments = [])
    {
        global $_CONF;

        if (empty($to)) {
            COM_errorLog(__METHOD__ . ": To address was empty.", 1);

            return false;
        }

        // Remove new lines
        $to = self::stripControlCharacters($to);
        $from = self::stripControlCharacters($from);
        $subject = self::stripControlCharacters($subject);

        $mail = new PHPMailer(true);    // error mode = exception

        try {
            // Set up transport
            switch ($_CONF['mail_settings']['backend']) {
                case 'smtp':
                case 'smtps':
                    $mail->isSMTP();
                    $mail->Host = $_CONF['mail_settings']['host'];

                    if (empty($_CONF['mail_settings']['auth'])) {
                        $mail->SMTPAuth = false;
                    } else {
                        $mail->SMTPAuth = true;
                        $mail->Username = $_CONF['mail_settings']['username'];
                        $mail->Password = $_CONF['mail_settings']['password'];
                    }

                    if ($_CONF['mail_settings']['backend'] === 'smtps') {
                        $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
                    } else {
                        $mail->SMTPSecure = '';
                    }

                    $mail->Port = $_CONF['mail_settings']['port'];
                    break;

                case 'sendmail':
                    $mail->isSendmail();
                    $mail->Sendmail = $_CONF['mail_settings']['sendmail_path'];
                    // PHPMailer doesn't accept optional sendmail args ($_CONF['mail_settings']['sendmail_args'])
                    break;

                case 'mail':
                default:
                    $mail->isMail();
                    break;
            }

            // Set sender
            if (empty($from)) {
                $mail->setFrom($_CONF['site_mail'], $_CONF['site_name']);
            } else {
                if (is_array($from)) {
                    reset($from);
                    $mail->setFrom(key($from), current($from));
                } else {
                    $mail->setFrom($from);
                }
            }

            // Set recipient
            if (is_array($to)) {
                reset($to);
                $mail->addAddress(key($to), current($to));
            } else {
                $mail->addAddress($to);
            }

            // Add Cc and Bcc
            if (!empty($optional) && !is_array($optional)) {
                // assume old (optional) CC: header
                $optional = self::stripControlCharacters($optional);
                $mail->addCC($optional);
            }
            if (is_array($optional) && (count($optional) > 0)) {
                foreach ($optional as $key => $value) {
                    if (strcasecmp($key, 'Cc') === 0) {
                        $mail->addCC($value);
                    } elseif (strcasecmp($key, 'Bcc') === 0) {
                        $mail->addBCC($value);
                    } else {
                        $mail->addCustomHeader($key, $value);
                    }
                }
            }

            // Set attachments
            if (count($attachments) > 0) {
                foreach ($attachments as $attachment) {
                    $mail->addAttachment($attachment);
                }
            }

            // Set charset
            if (empty($_CONF['mail_charset'])) {
                $mail->CharSet = COM_getCharset();
            } else {
                $mail->CharSet = $_CONF['mail_charset'];
            }

            // Set body
            $mail->isHTML($html);

            // Replace placeholders based on the email address
            if (is_array($to)) {
                reset($to);
                $address = key($to);
            } else {
                $address = $to;
            }

            // Replace placeholders
            self::replacePlaceHolders($address, $subject, $body);

			// Ready Plain Text version of email
			// bug #430
			$altbody = GLText::removeAllHTMLTagsAndAttributes($body);
			// bug #1000
			// Need to do this since htmLawed not only strips the tags it converts html special chars to entities which we do not want
			$altbody = htmlspecialchars_decode($altbody, ENT_QUOTES);

            if (!$html) {
				$mail->Body = $altbody;
            } else {
				$mail->Body = $body;
				$mail->AltBody = $body; // Only include this for HTML emails
			}

            // Set subject
            $mail->Subject = $subject;

            // Set priority
            if ($priority > 0) {
                $mail->Priority = (int) $priority;
            }

            // Add additional headers
            $mail->addCustomHeader('X-Mailer', 'Geeklog ' . VERSION);

            if (!empty(IP::getIPAddress()) && !empty($_SERVER['SERVER_ADDR'])
                && (IP::getIPAddress() !== $_SERVER['SERVER_ADDR'])) {
                $url = COM_getCurrentURL();

                if (substr($url, 0, strlen($_CONF['site_admin_url'])) !== $_CONF['site_admin_url']) {
                    $mail->addCustomHeader('X-Originating-IP', IP::getIPAddress());
                }
            }

            // Send a message
            $mail->send();

            return true;
        } catch (Exception $e) {
            if (is_array($to)) {
                reset($to);
                $address = key($to) . ' ' . current($to);
            } else {
                $address = $to;
            }

            COM_errorLog(__METHOD__ . ": Failed to send an email to $address.  Error message: {$e->getMessage()}");

            return false;
        }
    }
}
