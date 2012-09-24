<?php

###############################################################################
# hebrew_utf-8.php
# This is the Hebrew language page for the Geeklog Calendar Plug-in!
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

# index.php
$LANG_CAL_1 = array(
    1 => 'יומן אירועים',
    2 => 'מצטערים, אין אירועים להצגה.',
    3 => 'מתי',
    4 => 'איפה',
    5 => 'תיאור',
    6 => 'הוספת אירוע',
    7 => 'אירועים קרובים',
    8 => 'על ידי הוספת אירוע זה ליומן שלכם הנכם יכולים לצפות במהירות רק באירועים שמעניינים אתכם על ידי לחיצה על "היומן שלי" באיזור אפשרויות המשתמש.',
    9 => 'הוספה ליומן שלי',
    10 => 'הסרה מהיומן שלי',
    11 => 'מוסיף את האירוע ליומן של %s',
    12 => 'אירוע',
    13 => 'סטטיסטיקות',
    14 => 'מסתיים',
    15 => 'בחזרה ליומן',
    16 => 'יומן',
    17 => 'תאריך התחלה',
    18 => 'תאריך סיום',
    19 => 'הוספות ליומן',
    20 => 'כותרת',
    21 => 'תאריך התחלה',
    22 => 'כתובת קישור',
    23 => 'האירועים שלך',
    24 => 'האירועים של האתר',
    25 => 'אין שום אירועים קרובים',
    26 => 'הגשת אירוע',
    27 => "הגשת אירוע ל-{$_CONF['site_name']} תשים את האירוע שלכם ביומן הראשי ממנו משתמשים יכולים להוסיף את האירוע שלכם ליומן האישי שלהם. אופציה זו <b>*אינה*</b> אמורה לשמש לשמירת האירועים הפרטיים שלכם כמו ימי הולדת וימי שנה.<br" . XHTML . "><br" . XHTML . ">ברגע שתגישו את האירוע שלכם הוא ישלח למנהלים ואם יאושר, האירוע שלכם יופיע ביומן הראשי.",
    28 => 'כותרת',
    29 => 'זמן סיום',
    30 => 'זמן התחלה',
    31 => 'אירוע של יום שלם',
    32 => 'שורת כתובת 1',
    33 => 'שורת כתובת 2',
    34 => 'עיר/ישוב',
    35 => 'מחוז',
    36 => 'מיקוד',
    37 => 'סוג אירוע',
    38 => 'עריכת סוגי אירועים',
    39 => 'מיקום',
    40 => 'הוספת אירוע אל',
    41 => 'היומן הראשי',
    42 => 'היומן האישי',
    43 => 'קישור',
    44 => 'תוויות HTML אינן מאופשרות',
    45 => 'הגשה',
    46 => 'אירועים במערכת',
    47 => 'עשרת האירועים הגדולים',
    48 => 'לחיצות',
    49 => 'נראה שאין שום אירועים באתר זה או שאף אחד עוד לא לחץ על אחד מהם.',
    50 => 'אירועים',
    51 => 'מחיקה',
    'autotag_desc_event' => '[event: id alternate title] - Displays a link to an Event Link from the Calendar using the Event Title as the title. An alternate title may be specified but is not required.'
);

$_LANG_CAL_SEARCH = array(
    'results' => 'תוצאות מהיומן',
    'title' => 'כותרת',
    'date_time' => 'זמן ושעה',
    'location' => 'מיקום',
    'description' => 'תיאור'
);

###############################################################################
# calendar.php ($LANG30)

$LANG_CAL_2 = array(
    8 => 'הוספת אירוע אישי',
    9 => 'אירוע %s',
    10 => 'אירועים עבור',
    11 => 'יומן ראשי',
    12 => 'היומן שלי',
    25 => 'בחזרה אל ',
    26 => 'כל היום',
    27 => 'שבוע',
    28 => 'יומן אישי עבור',
    29 => 'יומן ציבורי',
    30 => 'מחיקת אירוע',
    31 => 'הוספה',
    32 => 'אירוע',
    33 => 'תאריך',
    34 => 'שעה',
    35 => 'הוספה מהירה',
    36 => 'הגשה',
    37 => 'מצטערים, אופציית היומן האישי אינה מאופשרת באתר זה',
    38 => 'עורך האירועים האישיים',
    39 => 'יום',
    40 => 'שבוע',
    41 => 'חודש',
    42 => 'הוספת אירוע ראשי',
    43 => 'הגשות אירועים'
);

###############################################################################
# admin/plugins/calendar/index.php, formerly admin/event.php ($LANG22)

$LANG_CAL_ADMIN = array(
    1 => 'עורך אירועים',
    2 => 'שגיאה',
    3 => 'מצב כתיבה',
    4 => 'כתובת הקישור לאירוע',
    5 => 'תאריך התחלת אירוע',
    6 => 'תאריך סיום אירוע',
    7 => 'מיקום האירוע',
    8 => 'תיאור האירוע',
    9 => '(כולל <span dir="ltr">http://</span>)',
    10 => 'הנכם חייבים לספק את התאריכים/הזמנים, כותרת האירוע והתיאור',
    11 => 'מנהל היומנים',
    12 => 'כדי לערוך או למחוק אירוע, ליחצו על האייקון למטה של עריכת אותו אירוע. כדי ליצור אירוע חדש, ליחצו על "צרו חדש" למעלה. ליחצו את אייקון ההעתקה כדי ליצור עותק של אירוע קיים.',
    13 => 'יוצר',
    14 => 'תאריך התחלה',
    15 => 'תאריך סיום',
    16 => '',
    17 => "הנכם מנסים לגשת לאירוע שאין לכם הרשאות אליו. נסיון זה נרשם ביומן. אנא <a href=\"{$_CONF['site_admin_url']}/plugins/calendar/index.php\">חיזרו למסך ניהול האירועים</a>.",
    18 => '',
    19 => '',
    20 => 'שמירה',
    21 => 'ביטול',
    22 => 'מחיקה',
    23 => 'תאריך התחלה שגוי.',
    24 => 'תאריך סיום שגוי.',
    25 => 'תאריך הסיום הוא מלפני תאריך ההתחלה.',
    26 => 'מחיקת פריטים ישנים',
    27 => 'אלו האירועים אשר יותר ישנים מאשר ',
    28 => ' חודשים. אנא ליחצו על אייקון האשפה כדי למחוק אותם, או סמנו תקופת זמן שונה:<br' . XHTML . '>חפשו את כל האירועים אשר יותר ישנים מאשר ',
    29 => ' חודשים.',
    30 => 'רשימת עדכונים',
    31 => 'האם הנכם בטוחים שאתם מעוניינים למחוק באופן סופי את *כל* המשתמשים המסומנים?',
    32 => 'רשימה של הכל',
    33 => 'שום אירועים לא סומנו למחיקה',
    34 => 'קוד זיהוי אירוע',
    35 => 'לא הצליח להימחק',
    36 => 'נמחק בהצלחה'
);

$LANG_CAL_MESSAGE = array(
    'save' => 'האירוע שלכם נשמר בהצלחה.',
    'delete' => 'האירוע נשמר בהצלחה.',
    'private' => 'האירוע נשמר ביומן שלכם',
    'login' => 'אי אפשר לפתוח את יומנך האישי עד שתזדהה במערכת',
    'removed' => 'האירוע הוסר בהצלחה מיומנך האישי',
    'noprivate' => 'מצטערים, יומנים אישיים אינם מאופשרים באתר זה',
    'unauth' => 'מצטערים, אין לכם גישה לעמוד ניהול האירועים. אנא שימו לב שכל הנסיונות לגשת ליכולות לא מורשות נרשמות ביומן'
);

$PLG_calendar_MESSAGE4 = "תודה לכם על הגשת האירוע ל-{$_CONF['site_name']}. הוא הוגש לצוות שלנו למען אישור. אם יאושר, האירוע שלכם יופיע כאן, <a href=\"{$_CONF['site_url']}/calendar/index.php\">ביומן</a> שלנו.";
$PLG_calendar_MESSAGE17 = 'האירוע שלכם נשמר בהצלחה.';
$PLG_calendar_MESSAGE18 = 'האירוע נמחק בהצלחה.';
$PLG_calendar_MESSAGE24 = 'האירוע נשמר ביומן שלכם.';
$PLG_calendar_MESSAGE26 = 'האירוע נמחק בהצלחה.';

// Messages for the plugin upgrade
$PLG_calendar_MESSAGE3001 = 'אין תמיכה בשדרוג ה-plugin.';
$PLG_calendar_MESSAGE3002 = $LANG32[9];

// Localization of the Admin Configuration UI
$LANG_configsections['calendar'] = array(
    'label' => 'יומן',
    'title' => 'כיוון היומן'
);

$LANG_confignames['calendar'] = array(
    'calendarloginrequired' => 'נדרשת הזדהות בשביל היומן?',
    'hidecalendarmenu' => 'להחביא את היומן מהתפריט?',
    'personalcalendars' => 'לאפשר יומנים אישיים?',
    'eventsubmission' => 'לאפשר תור הגשות?',
    'showupcomingevents' => 'להציג אירועים קרובים?',
    'upcomingeventsrange' => 'טווח אירועים קרובים',
    'event_types' => 'סוגי אירוע',
    'hour_mode' => 'מצב שעה',
    'notification' => 'הודעת תזכורת באימייל?',
    'delete_event' => 'מחיקת אירועים ביחד עם שולחיהם?',
    'aftersave' => 'לאחר שמירת האירוע',
    'default_permissions' => 'אישורי ברירת המחדל של אירוע',
    'autotag_permissions_event' => '[event: ] Permissions',
    'block_enable' => 'Enabled',
    'block_isleft' => 'Display Block on Left',
    'block_order' => 'Block Order',
    'block_topic_option' => 'Topic Options',
    'block_topic' => 'Topic',
    'block_group_id' => 'Group',
    'block_permissions' => 'Permissions'
);

$LANG_configsubgroups['calendar'] = array(
    'sg_main' => 'הגדרות מרכזיות'
);

$LANG_tab['calendar'] = array(
    'tab_main' => 'General Calendar Settings',
    'tab_permissions' => 'Default Permissions',
    'tab_autotag_permissions' => 'Autotag Usage Permissions',
    'tab_events_block' => 'Events Block'
);

$LANG_fs['calendar'] = array(
    'fs_main' => 'הגדרות יומן כללי',
    'fs_permissions' => 'הרשאות ברירת המחדל',
    'fs_autotag_permissions' => 'Autotag Usage Permissions',
    'fs_block_settings' => 'Block Settings',
    'fs_block_permissions' => 'Block Permissions'
);

// Note: entries 0, 1, 6, 9, 12 are the same as in $LANG_configselects['Core']
$LANG_configselects['calendar'] = array(
    0 => array('כן' => 1, 'לא' => 0),
    1 => array('כן' => true, 'לא' => false),
    6 => array('12' => 12, '24' => 24),
    9 => array('הפנייה לאירוע' => 'item', 'הצגת רשימת הניהול' => 'list', 'הצגת היומן' => 'plugin', 'הצגת דף הבית' => 'home', 'הצגת דף הניהול' => 'admin'),
    12 => array('אין גישה' => 0, 'קריאה בלבד' => 2, 'קריאה וכתיבה' => 3),
    13 => array('No access' => 0, 'Use' => 2),
    14 => array('No access' => 0, 'Read-Only' => 2),
    15 => array('All' => 'TOPIC_ALL_OPTION', 'Homepage Only' => 'TOPIC_HOMEONLY_OPTION', 'Select Topics' => 'TOPIC_SELECTED_OPTION')
);

?>
