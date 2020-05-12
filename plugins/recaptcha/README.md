# Install/Uninstall/Upgrade instruction for the Geeklog reCAPTCHA plugin

* Repository: https://github.com/Geeklog-Core/geeklog
* Version: 1.2.4
* License: GPL v2 or later

## What is reCAPTCHA?

reCAPTCHA(R) is a free anti-bot service providing powerful CAPTCHA(Completely Automated Public Turing test to tell Computers and Humans Apart).  This plugin makes it easy to use reCAPTCHA with Geeklog.

## System Requirements

* Geeklog-2.2.2+

## INSTALL

In the following descriptions

* <geeklog_dir> is the directory where the system config.php file resides
* <admin> is the directory where the administration files reside (usually, under <public_html>)

1.  Uncompress the recaptcha plugin archive while in the <geeklog_dir>/plugins directory. The archive will create a directory called recaptcha in the plugins directory.
2.  Create the admin directory. Under your <admin>/plugins/ directory, create a directory called recaptcha.
3.  Change to your <geeklog_dir>/plugins/recaptcha/ directory. Copy the files in the admin directory to the <admin>/plugins/recaptcha/ directory your created in step 2.
4.  Log in to your Geeklog as a root user, go to the plugin editor and click on reCAPTCHA. If the install failed, examine Geeklog system errorlog for possible problems.
5.  **Important**: Set up API keys. Go to the Configuration and enter reCAPTCHA API Public Key and Private Key that you can get at [https://www.google.com/recaptcha/admin/create](https://www.google.com/recaptcha/admin/create). **It is not until you set the API keys that you can use reCAPTCHA service.**

## UNINSTALL

1.  Log in to your Geeklog website as a root user, go to the plugin editor and click on reCAPTCHA.  If the unstall failed, examine Geeklog system errorlog for possible problems.
2.  Delete the two plugin directories created in the installation process: <geeklog-dir>/plugins/recaptcha/ and <admin>/plugins/recaptcha/.

## UPGRADE

1.  Log in to your Geeklog website as a root user, go to the plugin editor and disable the reCAPTCHA plugin.
2.  Uncompress the recaptcha plugin archive and upload the resulting files as you did when you installed the plugin.
3.  Go to the plugin editor and Enable the reCAPTCHA plugin. Then, upgrade the plugin.

## REVISION HISTORY

| Version | Date(YYYY-MM-DD) |Description                                                                         |
|:-------:|-----------------:|------------------------------------------------------------------------------------|
|   1.2.4 |       2020-??-?? |* Added support for reCAPTCHA V3.                                                   |
|   1.2.3 |       ****-**-** |* (Not released)                                                                    |
|   1.2.2 |       2020-02-26 |* Added support for the Forum plugin.                                               |
|   1.2.1 |       2019-xx-xx |* Dropped the parts of "Integration with Geeklog" configuration related to plugins.  Now, the reCAPTCHA plugin gets information through calling plugin_supportsRecaptcha_xxx. |
|   1.2.0 |       2017-12-02 |* Added support for Invisible reCAPTCHA.                                            |
|   1.1.6 |       2017-11-28 |* Added support for Login Form.                                                     |
|         |                  |* Added support for Forget Password Form.                                           |
|         |                  |* Added support for the demo mode introduced in Geeklog 2.2.0.                      |
|   1.1.5 |       2017-04-12 |* Fixed a bug where reCAPTCHA failed to check for input when $_RECAPTCHA_CONF['logging'] is set to off.  |
|   1.1.4 |       2017-01-18 |* Small bug fix.                                                                    |
|   1.1.3 |       2016-08-12 |* Replaced COM_siteHeader and COM_siteFooter with COM_createHTMLDocument.           |
|   1.1.2 |       2016-02-20 |* Modified to use reCAPTCHA v1.1.2 library.                                         |
|   1.1.0 |       2015-07-03 |* Upgraded to Google reCAPTCHA v2.                                                  |
|         |                  |* Added an error code to a log file(logs/recaptch.log) entry. Patch provided by Tom.|
|   1.0.1 |       2014-01-26 |* Added a <div> tag to enclose the reCAPTCHA code. Patch provided by Tom.           |
|         |                  |* Changed to write log entries into "logs/recaptch.log". Patch provided by Tom.     |
|   1.0.0 |       2014-01-24 |* Initial release                                                                   |
