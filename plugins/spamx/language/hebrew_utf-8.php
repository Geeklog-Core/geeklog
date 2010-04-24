<?php

/**
* File: hebrew_utf-8.php
 * This is the Hebrew language file for the Geeklog Spam-X plugin
* Copyright (C) 2009
 * http://lior.weissbrod.com
 * Version 1.6#1
 * 
 * Licensed under GNU General Public License
 *
 * $Id: english.php,v 1.23 2008/04/13 11:59:08 dhaun Exp $
 */

global $LANG32;

$LANG_SX00 = array(
    'inst1' => '<p>אם תעשו זאת, אז אחרים ',
    'inst2' => 'יוכלו לראות ולייבא את הרשימה השחורה שלכם ואנו נוכל ליצור ',
    'inst3' => 'מאגר נתונים מופץ יותר אפקטיבי.</p><p>אם שלחתם את האתר שלכם ואז החלטתם שאינכם מעוניינים שהאתר שלכם יישאר ברשימה ',
    'inst4' => 'שילחו אימייל ל-<a href="mailto:spamx@pigstye.net">spamx@pigstye.net</a> ותגידו לי. ',
    'inst5' => 'כל הבקשות יכובדו.',
    'submit' => 'שליחה',
    'subthis' => 'של מידע זה למאגר הנתונים המרכזי של Spam-X',
    'secbut' => 'הכפתור השני יוצר הזנת RDF כך שאחרים יוכלו לייבא את הרשימה שלכם.',
    'sitename' => 'שם האתר: ',
    'URL' => 'כתובת לרשימת Spam-X: ',
    'RDF' => 'כתובת RDF: ',
    'impinst1a' => 'לפני שתשתמשו בכלי חוסם תגובות הספאם של Spam-X כדי לצפות ולייבא רשימות שחורות אישיות מאתרים',
    'impinst1b' => ' אחרים, אני מבקש שתלחצו על שני הכפתורים הבאים (הנכם חייבים ללחוץ על האחרון).',
    'impinst2' => 'הראשון שולח את האתר שלכם לאתר של Gplugs/Spam-X כדי שהוא יוכל להיתווסף לרשימת העל של ',
    'impinst2a' => 'אתרים שחולקים את הרשימות השחורות שלהם (שימו לב: אם יש לכם כמה אתרים אולי תרצו לבחור אחד שיהיה ',
    'impinst2b' => 'הנציג ורק לשלוח את שמו. זה יאפשר לכם לעדכן את האתרים בקלות ולשמור על רשימה קטנה יותר) ',
    'impinst2c' => 'אחרי שתילצו על כפתור השליחה, ליחצו על חזרה בדפדפן שלכם כדי לחזור לכאן.',
    'impinst3' => 'הערכים הבאים ישלחו: (הנכם יכולים לערוך אותם אם טעיתם).',
    'availb' => 'רשימות שחורות זמינות',
    'clickv' => 'ליחצו כדי לראות את הרשימה השחורה',
    'clicki' => 'ליחצו כדי לייבא את הרשימה השחורה',
    'ok' => 'אישור',
    'rsscreated' => 'נוצרה הזנת RSS',
    'add1' => 'הוספו ',
    'add2' => ' פריטים מ: ',
    'add3' => 'מהרשימה השחורה שלו.',
    'adminc' => 'פקודות ניהול:',
    'mblack' => 'הרשימה השחורה שלי:',
    'rlinks' => 'קישורים רבלנטיים:',
    'e3' => 'כדי להוסיף את המילים מרשימת הצנזורה של התוכנה, ליחצו על הכפתור:',
    'addcen' => 'הוסיפו את רשימת הצינזור',
    'addentry' => 'הוסיפו את הפריט',
    'e1' => 'כדי למחוק פריט, ליחצו עליו.',
    'e2' => 'כדי להוסיף פריט, הכניסו אותו לתיבה וליחצו על הוספה.  הפריטים יכולים להשתמש באופן מלא ב-Regular Expressions של Perl.',
    'pblack' => 'הרשימה השחורה האישית של Spam-X',
    'conmod' => 'כוונו את מודול השימוש של Spam-X',
    'acmod' => 'מודולי הפעולה של Spam-X',
    'exmod' => 'מודולי הבחינה של Spam-X',
    'actmod' => 'מודולים פעילים',
    'avmod' => 'מודולים אפשריים',
    'coninst' => '<hr' . XHTML . '>ליחצו על מודול פעיל בשביל להסיר אותו, ליחצו את מודול אפשרי כדי להוסיף אותו.<br' . XHTML . '>המודולים מבוצעים לפי סדר הצגתם.',
    'fsc' => 'נמצאה תגובת ספאם מתאימה ',
    'fsc1' => ' נשלח על ידי המשתמש ',
    'fsc2' => ' מכתובת ה-IP ',
    'uMTlist' => 'עידכון MT-Blacklist',
    'uMTlist2' => ': הוספו ',
    'uMTlist3' => ' פריטים ונמחקו ',
    'entries' => ' פריטים.',
    'uPlist' => 'עידכון רשימה שחורה אישית',
    'entriesadded' => 'פריטים נוספו',
    'entriesdeleted' => 'פריטים נמחקו',
    'viewlog' => 'צפו ביומן של Spam-X',
    'clearlog' => 'נקו את קובץ היומן',
    'logcleared' => '- קובץ היומן של Spam-X נוקה',
    'plugin' => 'Plugin',
    'access_denied' => 'הגישה לא אושרה',
    'access_denied_msg' => 'רק מנהלים יכולים לגשת לעמוד זה.  שם המשתמש שלך וכתובת ה-IP תועדו.',
    'admin' => 'ניהול ה-Plugin',
    'install_header' => 'התקינו/הסירו Plugin',
    'installed' => 'ה-Plugin מותקן',
    'uninstalled' => 'ה-Plugin לא מותקן',
    'install_success' => 'ההתקנה הצליחה',
    'install_failed' => 'ההתקנה נכשלה -- ראו את יומן השגיאות של השרת כדי להבין למה.',
    'uninstall_msg' => 'ה-Plugin הוסר בהצלחה',
    'install' => 'התקנה',
    'uninstall' => 'הסרה',
    'warning' => 'אזהרה! ה-Plugin עדיין מאופשר',
    'enabled' => 'נטרלו את ה-plugin לפני ההסרה.',
    'readme' => '*עיצרו!* לפני שאתם לוחצים על התקנה קיראו את ',
    'installdoc' => 'מסמך ההקתנה.',
    'spamdeleted' => 'נמחקה תגובת ספאם',
    'foundspam' => 'נמצאה תגובת ספאם שמתאימה ל: ',
    'foundspam2' => ' נשלח על ידי המשתמש ',
    'foundspam3' => ' מכתובת ה-IP ',
    'deletespam' => 'מחיקת ספאם',
    'numtocheck' => 'מספר התגובות שיבדקו',
    'note1' => '<p>שימו לב: מחיקה המונית מטרתה לעזור לכם כאשר אתם מוצפים על ידי',
    'note2' => ' תגובות ספאם ו-Spam-X לא מצליח לתפוס אותן. </p><ul><li>קודם כל, מיצאו את הקישור/ים או משהו אחר ',
    'note3' => 'שמזוהה עם תגובת ספאם זו והוסיפו זאת לרשימה השחורה האישית שלכם.</li><li>אז ',
    'note4' => 'חיזרו לכאן ותנו ל-Spam-X לבדוק את התגובות האחרונות בשביל ספאם.</li></ul>התגובות ',
    'note5' => 'נבדקות מהחדשות לישנות -- ככל שיבדקו יותר תגובות ',
    'note6' => 'זמן הבדיקה יהיה ארוך יותר.</p>',
    'masshead' => '<hr' . XHTML . '><h1 align="center">מחיקה המונית של הפניות ספאם</h1>',
    'masstb' => '<hr' . XHTML . '><h1 align="center">מחיקה המונית של הפניות ספאם</h1>',
    'comdel' => ' תגובות נמחקו.',
    'initial_Pimport' => '<p>יבוא רשימה שחורה אישית"',
    'initial_import' => 'יבוא רשימת MT-Blacklist ראשונית',
    'import_success' => '<p>יובאו בהצלחה %d פרטי רשימות שחורות.',
    'import_failure' => '<p><strong>שגיאה:</strong> לא נמצאו פריטים.',
    'allow_url_fopen' => '<p>מצטערים, כיוון השרת שלכם לא מרשה לקרוא קבצים לא מקומיים (<code>allow_url_fopen</code> הוא במצב off). אנא הורידו את הרשימה השחורה מהכתובת הבאה והעלו אותה לספריית ה-"data" של התוכנה, <tt>%s</tt>, לפנו שתנסו שוב:',
    'documentation' => 'הדוקומנטציה של ה-Spam-X Plugin',
    'emailmsg' => "פריט ספאם חדש נשלח ב: \"%s\"\nקוד זיהוי משתמש: \"%s\"\n\nתוכן:\"%s\"",
    'emailsubject' => 'פריט ספאם ב: %s',
    'ipblack' => 'הרשימה השחורה של כתובות IP של Spam-X',
    'ipofurlblack' => 'הרשימה השחורה של כתובות ה-IP של כתובות אתרים של Spam-X',
    'headerblack' => 'הרשימה השחורה של HTTP Headers של Spam-X',
    'headers' => 'Request headers:',
    'stats_headline' => 'הסטטיסטיקה של Spam-X',
    'stats_page_title' => 'רשימה שחורה',
    'stats_entries' => 'פריטים',
    'stats_mtblacklist' => 'MT-Blacklist',
    'stats_pblacklist' => 'רשימה שחורה אישית',
    'stats_ip' => 'כתובות IP חסומות',
    'stats_ipofurl' => 'נחסם על ידי כתובת ה-IP של כתובת אתר',
    'stats_header' => 'HTTP headers',
    'stats_deleted' => 'פריטים שנמחקו כספאם',
    'plugin_name' => 'Spam-X',
    'slvwhitelist' => 'SLV Whitelist'
);

// Define Messages that are shown when Spam-X module action is taken
$PLG_spamx_MESSAGE128 = 'זוהה ספאם והתגובה או ההודעה נמחקו.';
$PLG_spamx_MESSAGE8 = 'זוהה ספאם. אימייל נשלח למנהלים.';

// Messages for the plugin upgrade
$PLG_spamx_MESSAGE3001 = 'אין תמיכה בשידרוג ה-plugin.';
$PLG_spamx_MESSAGE3002 = $LANG32[9];

// Localization of the Admin Configuration UI
$LANG_configsections['spamx'] = array(
    'label' => 'Spam-X',
    'title' => 'כיוון Spam-X'
);

$LANG_confignames['spamx'] = array(
    'action' => 'פעולות Spam-X',
    'notification_email' => 'התרעה בהודעת אימייל',
    'logging' => 'איפשור לוג',
    'timeout' => 'פקיעת זמן מוקצב'
);

$LANG_configsubgroups['spamx'] = array(
    'sg_main' => 'הגדרות ראשיות'
);

$LANG_fs['spamx'] = array(
    'fs_main' => 'ההגדרות הראשיות של Spam-X'
);

// Note: entries 0, 1, 9, and 12 are the same as in $LANG_configselects['Core']
$LANG_configselects['spamx'] = array(
    0 => array('כן' => 1, 'לא' => 0),
    1 => array('כן' => true, 'לא' => false)
);

?>
