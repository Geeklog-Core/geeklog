<?php

###############################################################################
# hebrew_utf-8.php
# This is the Hebrew language file for the Geeklog Static Page plugin
#
# Copyright (C) 2013
# http://lior.weissbrod.com
# Version 2.0.0#1
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
    'page_title' => 'כותרת עמוד',
    'content' => 'תוכן',
    'hits' => 'לחיצות',
    'staticpagelist' => 'רשימת עמודים סטטיים',
    'url' => 'כתובת',
    'edit' => 'עריכה',
    'lastupdated' => 'עודכן לאחרונה ב',
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
    'no_title_or_content' => 'הנכם חייבם לפחות למלא את שדות <b>הכותרת</b> <b>והתוכן</b>, כמו גם לבצע בחירת <b>נושא</b>.',
    'title_error_saving' => 'שגיאה בשמירת הדף',
    'template_xml_error' => 'יש <em>שגיאה בסימון ה-XML</em>. דף זה מוגדר להשתמש בדף אחר כתבנית ולכן משתני התבנית חייבים להיות מוגדרים באמצעות XML. מידע נוסף זמין ב-<a href="http://wiki.geeklog.net/Static_Pages_Plugin#Template_Static_Pages" target="_blank">Geeklog Wiki</a>. יש לתקן את השגיאה לפני שמירת הדף.',
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
    'centerblock_msg' => 'כאשר מסומן, עמוד סטטי זה יוצג כקוביית מידע מרכזית בעמוד האינדקס של הנושאים שהעמוד משויך אליכם.',
    'topic' => 'נושא',
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
    'select_php_return' => 'בצע PHP (ב-return)',
    'select_php_free' => 'בצע PHP',
    'php_not_activated' => "השימוש ב-PHP בעמודים סטטיים לא מופעל. אנא ראו את <a href=\"{$_CONF['site_url']}/docs/english/staticpages.html#php\">הדוקומנטציה</a> בשביל פרטים.",
    'printable_format' => 'פורמט להדפסה',
    'copy' => 'העתקה',
    'limit_results' => 'הגבלת תוצאות',
    'search' => 'חיפוש',
    'likes' => 'אהבתי',
    'submit' => 'שליחה',
    'no_new_pages' => 'אין עמודים חדשים',
    'pages' => 'עמודים',
    'comments' => 'תגובות',
    'template' => 'תבנית',
    'use_template' => 'שימוש כתבנית',
    'template_msg' => 'כאשר מופעל, עמוד סטטי זה יסומן כתבנית.',
    'none' => 'אף אחד',
    'use_template_msg' => 'אם עמוד סטטי זה אינו תבנית, תוכלו לתת לו תבנית להשתמש בה. אם תבחרו כך זיכרו שתוכן עמוד זה חייב להיות בפורמט תקין של XML.',
    'draft' => 'טיוטה',
    'draft_yes' => 'כן',
    'draft_no' => 'לא',
    'show_on_page' => 'הצג בדף',
    'show_on_page_disabled' => 'הערה: אפשרות זו מושבתת כעת עבור כל הדפים בהגדרות הדפים הסטטיים.',
    'cache_time' => 'זמן מטמון',
    'cache_time_desc' => 'תוכן הדף הסטטי יישמר במטמון לכל היותר למשך מספר השניות הזה. 0 מבטל מטמון ו--1 שומר עד לעריכת הדף מחדש. דפים עם PHP או תבניות אינם נשמרים במטמון. (3600 = שעה, 86400 = יום)',
    'autotag_desc_staticpage' => '[staticpage: id alternate title] - מציג קישור לעמוד סטטי בעזרת כותרת העמוד הסטטי בתור הכותרת. ניתן לציין כותרת אלטרנטיבית אך זו לא חובה.',
    'autotag_desc_staticpage_content' => '[staticpage_content: id alternate title] - מציג את תכני העמוד הסטטי.',
    'autotag_desc_page' => '[page: id כותרת חלופית] - מציג קישור לדף מתוך תוסף הדפים הסטטיים באמצעות כותרת הדף. ניתן לציין כותרת חלופית.',
    'autotag_desc_page_content' => '[page_content: id] - מציג את תוכן הדף מתוך תוסף הדפים הסטטיים.',
    'yes' => 'כן',
    'used_by' => 'תבנית זו מוקצית ל-%s דפים. ייתכן שהיא משמשת דפים נוספים אם היא נטענת באמצעות autotag בתבנית אחרת.',
    'prev_page' => 'הדף הקודם',
    'next_page' => 'הדף הבא',
    'parent_page' => 'דף אב',
    'page_desc' => 'Setting a previous and/or next page will add HTML link elements rel=”next” and rel=”prev” to the header to indicate the relationship between pages in a paginated series. Actual page navigation links are not added to the page. You have to add these yourself. NOTE: Parent page is currently not being used.',
    'num_pages' => '%s דפים',
    'search_desc' => 'Control if page appears in search. Default depends on setting in Configuration and depends on page type (if it is a Center Block, Uses a Template, or Uses PHP).',
    'likes_desc' => 'קובע אם וכיצד יוצגו סימוני אהבתי בדף. ברירת המחדל תלויה בהגדרות התוסף. דפים המוצגים כבלוק מרכזי אינם מציגים בקרה זו. תבניות אינן משתמשות בהגדרה זו.'
);

$LANG_staticpages_search = array(
    0  => 'לא נכלל',
    1  => 'השתמש בברירת מחדל',
    2  => 'נכלל'
);

$LANG_staticpages_likes = array(
    -1 => 'השתמש בברירת מחדל',
    0  => 'מושבת',
    1  => 'אהבתי ולא אהבתי',
    2  => 'אהבתי בלבד',
);

$PLG_staticpages_MESSAGE15 = 'תגובתכם נשלחה לסקירה ותפורסם כאשר תאושר על ידי המשגיחים.';
$PLG_staticpages_MESSAGE19 = 'העמוד שלכם נשמר בהצלחה.';
$PLG_staticpages_MESSAGE20 = 'העמוד שלכם נמחק בהצלחה.';
$PLG_staticpages_MESSAGE21 = 'עמוד זה לא קיים עדיין. כדי ליצור את העמוד, נא מלאו את הטופס שלהלן. אם הגעתם לכאן בטעות, ליחצו על כפתור הביטול.';
$PLG_staticpages_MESSAGE22 = 'You could not delete the page. It is a template staticpage and it is currently assigned to 1 or more staticpages.';

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
    'enable_eval_php_save' => 'נתח PHP בעת שמירת הדף',
    'sort_by' => 'מיון קוביות מידע מרכזיות לפי',
    'sort_menu_by' => 'מיון פריטים בתפריט לפי',
    'sort_list_by' => 'מיון רשימת ניהול לפי',
    'delete_pages' => 'מחיקת עמודים עם יוצריהם?',
    'in_block' => 'עטיפת העמודים בקוביית מידע?',
    'show_hits' => 'הצגת כמות לחיצות?',
    'show_date' => 'הצגת תאריך?',
    'filter_html' => 'סינון HTML?',
    'censor' => 'צינזור תוכן?',
    'default_permissions' => 'הרשאות ברירת המחדל של עמוד',
    'autotag_permissions_staticpage' => '[staticpage: ] הרשאות',
    'autotag_permissions_staticpage_content' => '[staticpage_content: ] הרשאות',
    'aftersave' => 'לאחר שמירת עמוד',
    'atom_max_items' => 'הכמות המקסימלית של עמודים בהזנת שירותי רשת',
    'meta_tags' => 'אפשרו תגיות Meta',
    'likes_pages' => 'אהבתי בדפים',
    'comment_code' => 'ברירת המחדל של תגובות',
    'structured_data_type_default' => 'סוג ברירת מחדל לנתונים מובנים',
    'draft_flag' => 'ברירת המחדל של סימון כטיוטה',
    'disable_breadcrumbs_staticpages' => 'ניטרול הצגת מיקום',
    'default_cache_time' => 'זמן מטמון ברירת מחדל',
    'newstaticpagesinterval' => 'מרווח עמוד סטטי חדש',
    'hidenewstaticpages' => 'החביאו עמודים סטטיים חדשים',
    'title_trim_length' => 'אורך קיצוץ כותרות',
    'includecenterblocks' => 'כיללו עמודים סטטיים בקוביות מידע מרכזיות',
    'includephp' => 'כיללו עמודים סטטיים עם PHP',
    'includesearch' => 'אפשרו עמודים סטטיים בחיפוש',
    'includesearchcenterblocks' => 'כיללו עמודים סטטיים בקוביות מידע מרכזיות',
    'includesearchphp' => 'כיללו עמודים סטטיים עם PHP',
    'includesearchtemplate' => 'כלול דפי תבנית'
);

$LANG_configsubgroups['staticpages'] = array(
    'sg_main' => 'הגדרות ראשיות'
);

$LANG_tab['staticpages'] = array(
    'tab_main' => 'הגדרות כלליות של עמודים סטטיים',
    'tab_whatsnew' => 'קוביית המידע מה חדש',
    'tab_search' => 'תוצאות חיפוש',
    'tab_permissions' => 'הרשאות ברירת המחדל',
    'tab_autotag_permissions' => 'הרשאות שימוש ב-Autotag'
);

$LANG_fs['staticpages'] = array(
    'fs_main' => 'הגדרות ראשיות של עמודים סטטיים',
    'fs_whatsnew' => 'קוביית המידע של מה חדש',
    'fs_search' => 'תוצאות חיפוש',
    'fs_permissions' => 'הרשאות ברירת המחדל',
    'fs_autotag_permissions' => 'הרשאות שימוש ב-Autotag'
);

// Note: entries 0, 1, 9, 12, 17 are the same as in $LANG_configselects['Core']
$LANG_configselects['staticpages'] = array(
    0 => array('כן' => 1, 'לא' => 0),
    1 => array('כן' => true, 'לא' => false),
    2 => array('תאריך' => 'date', 'קוד זיהוי עמוד' => 'id', 'כותרת' => 'title'),
    3 => array('תאריך' => 'date', 'קוד זיהוי עמוד' => 'id', 'כותרת' => 'title', 'תווית' => 'label'),
    4 => array('תאריך' => 'date', 'קוד זיהוי עמוד' => 'id', 'כותרת' => 'title', 'היוצר' => 'author'),
    5 => array('החבאה' => 'hide', 'הצגה - שימוש בתאריך העדכון' => 'modified', 'הצגה - שימוש בתאריך היצירה' => 'created'),
    9 => array('הפנייה לעמוד' => 'item', 'הצגת רשימה' => 'list', 'הצגת דף הבית' => 'home', 'הצגת דף הניהול' => 'admin'),
    12 => array('אין גישה' => 0, 'קריאה בלבד' => 2, 'קריאה וכתיבה' => 3),
    13 => array('אין גישה' => 0, 'מותר לשימוש' => 2),
    17 => array('איפשור תגובות' => 0, 'ניטרול תגובות' => -1),
    39 => array('None' => '', 'WebPage' => 'core-webpage', 'Article' => 'core-article', 'NewsArticle' => 'core-newsarticle', 'BlogPosting' => 'core-blogposting'),
    41 => array('False' => 0, 'Likes and Dislikes' => 1, 'Likes Only' => 2)
);
