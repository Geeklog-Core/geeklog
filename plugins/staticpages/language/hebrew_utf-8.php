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
    'title_error_saving' => 'Error Saving Page',
    'template_xml_error' => 'You have an <em>error in your XML markup</em>. This page is set to use another page as a template and therefore requires template variables to be defined using XML markup. Please see our <a href="http://wiki.geeklog.net/Static_Pages_Plugin#Template_Static_Pages" target="_blank">Geeklog Wiki</a> for more information on how to do this as it must be corrected before the page can be saved.',
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
    'likes' => 'Likes',
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
    'show_on_page' => 'Show on Page',
    'show_on_page_disabled' => 'Note: This is currently disabled for all pages in the Staticpage Configuration.',
    'cache_time' => 'Cache Time',
    'cache_time_desc' => 'This staticpage content will be cached for no longer than this many seconds. If 0 caching is disabled. If -1 cached until page is edited again. Staticpages with PHP enabled or are a template will not be cached. (3600 = 1 hour,  86400 = 1 day)',
    'autotag_desc_staticpage' => '[staticpage: id alternate title] - מציג קישור לעמוד סטטי בעזרת כותרת העמוד הסטטי בתור הכותרת. ניתן לציין כותרת אלטרנטיבית אך זו לא חובה.',
    'autotag_desc_staticpage_content' => '[staticpage_content: id alternate title] - מציג את תכני העמוד הסטטי.',
    'autotag_desc_page' => '[page: id alternate title] - Displays a link to a page (from the Static Page plugin) using the page title as the title. An alternate title may be specified but is not required.',
    'autotag_desc_page_content' => '[page_content: id] - Displays the contents of a page. (from Static Page plugin)',
    'yes' => 'Yes',
    'used_by' => 'This template is assigned to %s page(s). It is possible this template is used more than specified here if the template is being retrieved via an autotag in another template.',
    'prev_page' => 'Previous page',
    'next_page' => 'Next page',
    'parent_page' => 'Parent page',
    'page_desc' => 'Setting a previous and/or next page will add HTML link elements rel=”next” and rel=”prev” to the header to indicate the relationship between pages in a paginated series. Actual page navigation links are not added to the page. You have to add these yourself. NOTE: Parent page is currently not being used.',
    'num_pages' => '%s Page(s)',
    'search_desc' => 'Control if page appears in search. Default depends on setting in Configuration and depends on page type (if it is a Center Block, Uses a Template, or Uses PHP).',
    'likes_desc' => 'Determines if and how likes control appears on page. Default depends on setting in Plugin Configuration. Pages displayed in a Center Blocks will not display a likes control. Pages that are a template do not use this setting.'
);

$LANG_staticpages_search = array(
    0 => 'Excluded',
    1 => 'Use Default',
    2 => 'Included'
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
    'enable_eval_php_save' => 'Parse PHP on Save of Page',
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
    'likes_pages' => 'Page Likes',
    'comment_code' => 'ברירת המחדל של תגובות',
    'structured_data_type_default' => 'Structured Data Type Default',
    'draft_flag' => 'ברירת המחדל של סימון כטיוטה',
    'disable_breadcrumbs_staticpages' => 'ניטרול הצגת מיקום',
    'default_cache_time' => 'Default Cache Time',
    'newstaticpagesinterval' => 'מרווח עמוד סטטי חדש',
    'hidenewstaticpages' => 'החביאו עמודים סטטיים חדשים',
    'title_trim_length' => 'אורך קיצוץ כותרות',
    'includecenterblocks' => 'כיללו עמודים סטטיים בקוביות מידע מרכזיות',
    'includephp' => 'כיללו עמודים סטטיים עם PHP',
    'includesearch' => 'אפשרו עמודים סטטיים בחיפוש',
    'includesearchcenterblocks' => 'כיללו עמודים סטטיים בקוביות מידע מרכזיות',
    'includesearchphp' => 'כיללו עמודים סטטיים עם PHP',
    'includesearchtemplate' => 'Include Template Static Pages'
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
