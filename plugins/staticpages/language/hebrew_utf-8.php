<?php

###############################################################################
# hebrew_utf-8.php
# This is the Hebrew language file for the Geeklog Static Page plugin
#
# Copyright (C) 2009
# http://lior.weissbrod.com
# Version 1.6#1
#
# This program is free software; you can redistribute it and/or
# modify it under the terms of the GNU General Public License
# as published by the Free Software Foundation; either version 2
# of the License, or (at your option) any later version.
#
# This program is distributed in the hope that it will be useful,
# but WITHOUT ANY WARRANTY; without even the implied warranty of
# MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
# GNU General Public License for more details.
#
# You should have received a copy of the GNU General Public License
# along with this program; if not, write to the Free Software
# Foundation, Inc., 59 Temple Place - Suite 330, Boston, MA  02111-1307, USA.
#
###############################################################################

global $LANG32;

###############################################################################
# Array Format:
# $LANGXX[YY]:  $LANG - variable name
#               XX    - file id number
#               YY    - phrase id number
###############################################################################

$LANG_STATIC = array(
    'newpage' => 'דף חדש',
    'adminhome' => 'עמוד הניהול הראשי',
    'staticpages' => 'עמודים סטטיים',
    'staticpageeditor' => 'עריכת עמודים סטטיים',
    'writtenby' => 'נכתב על ידי',
    'date' => 'עידכון אחרון',
    'title' => 'כותרת',
    'content' => 'תוכן',
    'hits' => 'לחיצות',
    'staticpagelist' => 'רשימת עמודים סטטיים',
    'url' => 'כתובת',
    'edit' => 'עריכה',
    'lastupdated' => 'עודכן לאחרונה ב:',
    'pageformat' => 'פורמט העמוד',
    'leftrightblocks' => 'קוביות מידע ימניות ושמאליות',
    'blankpage' => 'עמוד ריק',
    'noblocks' => 'ללא קוביות מידע',
    'leftblocks' => 'קוביות מידע שמאליות [ימניות במצב שפה RTL]',
    'addtomenu' => 'הוספה לתפריט',
    'label' => 'תווית',
    'nopages' => 'אין עדיין עמודים סטטיים במערכת',
    'save' => 'שמירה',
    'preview' => 'תצוגה מקדימה',
    'delete' => 'מחיקה',
    'cancel' => 'ביטול',
    'access_denied' => 'הגישה לא אושרה',
    'access_denied_msg' => 'הנכם מנסים לגשת לאחד מעמודי הניהול של העמודים הסטטיים.  אנא שימו לב שכל הנסיונות לגישה לא מורשית לעמוד זה נרשמות ביומן',
    'all_html_allowed' => 'כל HTML באשר הוא מותר',
    'results' => 'תוצאות עמודים סטטיים',
    'author' => 'יוצר',
    'no_title_or_content' => 'הנכם חייבם לפחות למלא את שדות <b>הכותרת</b> <b>והתוכן</b>.',
    'no_such_page_anon' => 'אנא הזדהו במערכת..',
    'no_page_access_msg' => "זה עשוי להיות מפני שלא הזדהיתם במערכת, או שאינכם חברים ב-{$_CONF['site_name']}. אנא <a href=\"{$_CONF['site_url']}/users.php?mode=new\"> תירשמו כחברים</a> ב-{$_CONF['site_name']} כדי לקבל גישה מלאה של מנויים",
    'php_msg' => 'PHP: ',
    'php_warn' => 'אזהרה: קוד ה-PHP בעמודכם יורץ אם תפעילו אפשרות זו. השתמשו בזהירות !!',
    'exit_msg' => 'סוג יציאה: ',
    'exit_info' => 'אפשרו זאת כדי שתופיע הודעת דרישת הזדהות. השאירו לא מסומן בשביל בדיקת והודעת הרשאות רגילות.',
    'deny_msg' => 'הגישה לעמוד זה לא אושרה.  עמוד זה הוזז/נמחק או שאין לכן הרשאות מספיקות.',
    'stats_headline' => 'עשרת העמודים הסטטיים הגדולים',
    'stats_page_title' => 'כותרת העמוד',
    'stats_hits' => 'לחיצות',
    'stats_no_hits' => 'נראה שאין עמודים סטטיים באתר זה או שאף אחד עוד לא צפה בהם.',
    'id' => 'קוד זיהוי',
    'duplicate_id' => 'קוד הזיהוי שבחרתם לעמוד סטטי זה כבר נמצא בשימוש. אנא ביחרו קוד אחר.',
    'instructions' => 'כדי לשנות או למחוק עמוד סטטי, ליחצו על אייקון העריכה שלו להלן. כדי לצפות בעמוד סטטי, ליחצו על כותרת העמוד שברצונכם לצפות בו. כדי ליצור עמוד סטטי חדש, ליחצו על "צרו חדש" לעיל. ליחצו על אייקון ההעתקה כדי ליצור עותק של עמוד קיים.',
    'centerblock' => 'קוביית מידע מרכזית: ',
    'centerblock_msg' => 'כאשר מסומן, עמוד סטטי זה יוצג כקוביית מידע מרכזית בעמוד האינדקס.',
    'topic' => 'נושא: ',
    'position' => 'מקום: ',
    'all_topics' => 'בהכל',
    'no_topic' => 'רק בדף הבית',
    'position_top' => 'ראש העמוד',
    'position_feat' => 'אחרי המאמר הראשי',
    'position_bottom' => 'בתחתית העמוד',
    'position_entire' => 'בכל העמוד',
    'head_centerblock' => 'קוביית מידע מרכזית',
    'centerblock_no' => 'לא',
    'centerblock_top' => 'בראש',
    'centerblock_feat' => 'מאמר ראשי',
    'centerblock_bottom' => 'בתחתית',
    'centerblock_entire' => 'בכל העמוד',
    'inblock_msg' => 'בקוביית מידע: ',
    'inblock_info' => 'הציבו את העמוד הסטטי בתוך קוביית מידע.',
    'title_edit' => 'עריכת עמוד',
    'title_copy' => 'יצירת עותק של עמוד זה',
    'title_display' => 'הציגו את העמוד',
    'select_php_none' => 'אל תבצע PHP',
    'select_php_return' => 'בצע PHP (return)',
    'select_php_free' => 'בצע PHP',
    'php_not_activated' => "השימוש ב-PHP בעמודים סטטיים לא מופעל. אנא ראו את <a href=\"{$_CONF['site_url']}/docs/english/staticpages.html#php\">הדוקומנטציה</a> בשביל פרטים.",
    'printable_format' => 'פורמט להדפסה',
    'copy' => 'העתקה',
    'limit_results' => 'הגבלת תוצאות',
    'search' => 'חיפוש',
    'submit' => 'שליחה',
    'no_new_pages' => 'No new pages',
    'pages' => 'Pages'
);

$PLG_staticpages_MESSAGE15 = 'תגובתכם נשלחה לסקירה ותפורסם כאשר תאושר על ידי המשגיחים.';
$PLG_staticpages_MESSAGE19 = 'העמוד שלכם נשמר בהצלחה.';
$PLG_staticpages_MESSAGE20 = 'העמוד שלכם נמחק בהצלחה.';

// Messages for the plugin upgrade
$PLG_staticpages_MESSAGE3001 = 'אין תמיכה בשידרוג ה-plugin.';
$PLG_staticpages_MESSAGE3002 = $LANG32[9];

// Localization of the Admin Configuration UI
$LANG_configsections['staticpages'] = array(
    'label' => 'עמודים סטטיים',
    'title' => 'כיוון עמודים סטטיים'
);

$LANG_confignames['staticpages'] = array(
    'allow_php' => 'איפשור PHP?',
    'sort_by' => 'מיון קוביות מידע מרכזיות לפי',
    'sort_menu_by' => 'מיון פריטים בתפריט לפי',
    'delete_pages' => 'מחיקת עמודים עם יוצריהם?',
    'in_block' => 'עטיפת העמודים בקוביית מידע?',
    'show_hits' => 'הצגת כמות לחיצות?',
    'show_date' => 'הצגת תאריך?',
    'filter_html' => 'סינון HTML?',
    'censor' => 'צינזור תוכן?',
    'default_permissions' => 'הרשאות ברירת המחדל של עמוד',
    'aftersave' => 'לאחר שמירת עמוד',
    'atom_max_items' => 'הכמות המקסימלית של עמודים בהזנת שירותי רשת',
    'meta_tags' => 'Enable Meta Tags',
    'newstaticpagesinterval' => 'New Static Page Interval',
    'hidenewstaticpages' => 'Hide New Static Pages',
    'title_trim_length' => 'Title Trim Length',
    'includecenterblocks' => 'Include Center Block Static Pages',
    'includephp' => 'Include Static Pages with PHP',
    'includesearch' => 'Enable Static Pages in Search',
    'includesearchcenterblocks' => 'Include Center Block Static Pages',
    'includesearchphp' => 'Include Static Pages with PHP'
);

$LANG_configsubgroups['staticpages'] = array(
    'sg_main' => 'הגדרות ראשיות'
);

$LANG_fs['staticpages'] = array(
    'fs_main' => 'הגדרות ראשיות של עמודים סטטיים',
    'fs_whatsnew' => 'What\'s New Block',
    'fs_search' => 'Search Results',
    'fs_permissions' => 'הרשאות ברירת המחדל'
);

// Note: entries 0, 1, 9, and 12 are the same as in $LANG_configselects['Core']
$LANG_configselects['staticpages'] = array(
    0 => array('True' => 1, 'False' => 0),
    1 => array('True' => true, 'False' => false),
    2 => array('Date' => 'date', 'Page ID' => 'id', 'Title' => 'title'),
    3 => array('Date' => 'date', 'Page ID' => 'id', 'Title' => 'title', 'Label' => 'label'),
    9 => array('Forward to page' => 'item', 'Display List' => 'list', 'Display Home' => 'home', 'Display Admin' => 'admin'),
    12 => array('No access' => 0, 'Read-Only' => 2, 'Read-Write' => 3)
);

?>
