# Install/Uninstall/Upgrade instruction for the Geeklog reCAPTCHA plugin

* Repository: https://github.com/mystralkk/recaptcha
* Version: 1.1.4
* License: GPL v2 or later

## What is reCAPTCHA?

ReCAPTCHA(R) is a free anti-bot service providing powerful CAPTCHA(Completely Automated Public Turing test to tell Computers and Humans Apart).  This plugin makes it easy to use reCAPTCHA with Geeklog.

## System Requirements

* Geeklog-1.6.0+
* PHP-5.3.2+.  Maybe PHP-5-3.0 or PHP-5.3.1 will do, but I am not sure.

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

1.  Log in to your Geeklog web site as a root user, go to the plugin editor and click on reCAPTCHA.  If the unstall failed, examine Geeklog system errorlog for possible problems.
2.  Delete the two plugin directories created in the install process: <geeklog-dir>/plugins/recaptcha/ and <admin>/plugins/recaptcha/.

## UPGRADE

1.  Log in to your Geeklog web site as a root user, go to the plugin editor and disable the reCAPTCHA plugin.
2.  Uncompress the recaptcha plugin archive and upload the resulting files as you did when you installed the plugin.
3.  Go to the plugin editor and Enable the reCAPTCHA plugin. Then, upgrade the plugin.

## REVISION HISTORY

| Version | Date(YYYY-MM-DD) |Description                                                                         |
|:-------:|-----------------:|------------------------------------------------------------------------------------|
|   1.1.4 |       2017-01-18 |* Small bug fix.                                                                    |
|   1.1.3 |       2016-08-12 |* Replaced COM_siteHeader and COM_siteFooter with COM_createHTMLDocument.           |
|   1.1.2 |       2016-02-20 |* Modified to use reCAPTCHA v1.1.2 library.                                         |
|   1.1.0 |       2015-07-03 |* Upgraded to Google reCAPTCHA v2.                                                  |
|         |                  |* Added an error code to a log file(logs/recaptch.log) entry. Patch provided by Tom.|
|   1.0.1 |       2014-01-26 |* Added a <div> tag to enclose the reCAPTCHA code. Patch provided by Tom.           |
|         |                  |* Changed to write log entries into "logs/recaptch.log". Patch provided by Tom.     |
|   1.0.0 |       2014-01-24 |* Initial release                                                                   |
