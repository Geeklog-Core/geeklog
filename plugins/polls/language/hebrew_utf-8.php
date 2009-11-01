<?php

###############################################################################
# hebrew_utf-8.php
#
# This is the Hebrew language file for the Geeklog Polls plugin
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

$LANG_POLLS = array(
    'polls' => 'סקרים',
    'results' => 'תוצאות',
    'pollresults' => 'תוצאות סקרים',
    'votes' => 'הצבעות',
    'vote' => 'הצבעה',
    'pastpolls' => 'סקרי עבר',
    'savedvotetitle' => 'ההצבעה נשמרה',
    'savedvotemsg' => 'הצבעתם נשמרה בסקר',
    'pollstitle' => 'סקרים במערכת',
    'polltopics' => 'סקרים נוספים',
    'stats_top10' => 'עשרת הסקרים הגדולים',
    'stats_topics' => 'נושא הסקר',
    'stats_votes' => 'הצבעות',
    'stats_none' => 'נראה שאין סקרים באתר זה או שאף אחד עוד לא הצביע.',
    'stats_summary' => 'סקרים (תשובות) במערכת',
    'open_poll' => 'פתוח להצבעה',
    'answer_all' => 'אנא ענו על כל השאלות שנותרו',
    'not_saved' => 'התוצאות לא נשמרו',
    'upgrade1' => 'התקנתם גרסה חדשה של plugins הסקרים. אנא',
    'upgrade2' => 'שדרגו',
    'editinstructions' => 'אנא מלאו את קוד הזיהוי של הסקר, לפחות שאלה אחת ושתי תשובות לה.',
    'pollclosed' => 'This poll is closed for voting.',
    'pollhidden' => 'You have already voted. This poll results will only be shown when voting is closed.',
    'start_poll' => 'התחילו את הסקר'
);

###############################################################################
# admin/plugins/polls/index.php

$LANG25 = array(
    1 => 'מצב',
    2 => 'אנא הכניסו נושא, לפחות שאלה אחת ולפחות תשובה אחת לה.',
    3 => 'הסקר נוצר',
    4 => 'הסקר %s נשמר',
    5 => 'עריכת הסקר',
    6 => 'קוד זיהוי סקר',
    7 => '(אל תשתמשו ברווחים)',
    8 => 'הופעה בקוביית המידע של סקרים',
    9 => 'נושא',
    10 => 'תשובות / הצבעות / הערות',
    11 => 'חלה שגיאה בהוצאת מידע על תשובות הסקר לגבי הסקר %s',
    12 => 'חלה שגיאה בהוצאת מידע על שאלת הסקר לגבי הסקר %s',
    13 => 'צרו סקר',
    14 => 'שמירה',
    15 => 'ביטול',
    16 => 'מחיקה',
    17 => 'אנא הכניסו קוד זיהוי סקר',
    18 => 'רשימת הסקרים',
    19 => 'כדי לשנות או למחוק סקר, ליחצו על אייקון העריכה של הסקר.  כדי ליצור סקר חדש, ליחצו על "צרו חדש" שלעיל.',
    20 => 'מצביעים',
    21 => 'הגישה לא אושרה',
    22 => "הנכם מנסים לגשת לסקר שאין לכם גישה אליו.  נסיון זה נרשם ביומן. אנא <a href=\"{$_CONF['site_admin_url']}/plugins/links/index.php\">חיזרו למסך ניהול הסקרים</a>.",
    23 => 'סקר חדש',
    24 => 'דף הניהול הראשי',
    25 => 'כן',
    26 => 'לא',
    27 => 'עריכה',
    28 => 'שליחה',
    29 => 'חיפוש',
    30 => 'הגבלת תוצאות',
    31 => 'שאלה',
    32 => 'כדי למחוק שאלה זו מהסקר, מיחקו את טקסט השאלה',
    33 => 'פתוח להצבעות',
    34 => 'נושא הסקר:',
    35 => 'לסקר זה יש',
    36 => 'שאלות נוספות.',
    37 => 'החבאת תוצאות כל זמן שהסקר פתוח',
    38 => 'בזמן שהסקר פתוח, רק יוצריו והמנהלים הראשיים יוכלו לצפות בתוצאות',
    39 => 'הנושא יוצג רק אם יש יותר משאלה אחת.',
    40 => 'צפו בכל התשובות של סקר זה'
);

$PLG_polls_MESSAGE15 = 'תגובתכם נשלחה לסקירה ותפורסם כאשר תאושר על ידי המשגיחים.';
$PLG_polls_MESSAGE19 = 'הסקר שלכם נשמר בהצלחה.';
$PLG_polls_MESSAGE20 = 'הסקר שלכם נמחק בהצלחה.';

// Messages for the plugin upgrade
$PLG_polls_MESSAGE3001 = 'אין תמיכה בשדרוג ה-plugin.';
$PLG_polls_MESSAGE3002 = $LANG32[9];

// Localization of the Admin Configuration UI
$LANG_configsections['polls'] = array(
    'label' => 'סקרים',
    'title' => 'ניהול הסקרים'
);

$LANG_confignames['polls'] = array(
    'pollsloginrequired' => 'נדרשת הזדהות בשביל צפייה בסקרים?',
    'hidepollsmenu' => 'החבאת ההפנייה לסקרים בתפריט?',
    'maxquestions' => 'כמות השאלות המקסימלית בסקר',
    'maxanswers' => 'כמות האפשרויות המקסימלית לכל שאלה',
    'answerorder' => 'מיון תוצאות ...',
    'pollcookietime' => 'עוגיית המצביעים תקיפה עד',
    'polladdresstime' => 'כתובת ה-IP של המצביעים תקיפה עד',
    'delete_polls' => 'מחיקת הסקרים עם יוצריהם?',
    'aftersave' => 'לאחר שמירת סקר',
    'default_permissions' => 'הרשאות ברירת המחדל של סקר',
    'meta_tags' => 'Enable Meta Tags'
);

$LANG_configsubgroups['polls'] = array(
    'sg_main' => 'הגדרות ראשיות'
);

$LANG_fs['polls'] = array(
    'fs_main' => 'General Polls Settings',
    'fs_permissions' => 'Default Permissions'
);

// Note: entries 0, 1, and 12 are the same as in $LANG_configselects['Core']
$LANG_configselects['polls'] = array(
    0 => array('כן' => 1, 'לא' => 0),
    1 => array('כן' => true, 'לא' => false),
    2 => array('לפי סדר שליחה' => 'submitorder', 'לפי הצבעות' => 'voteorder'),
    9 => array('הפניה לסקר' => 'item', 'הצגת רשימת הניהול' => 'list', 'הצגת רשימה ציבורית' => 'plugin', 'הצגת דף הבית' => 'home', 'הצגת דף הניהול' => 'admin'),
    12 => array('אין גישה' => 0, 'קריאה בלבד' => 2, 'קריאה וכתיבה' => 3)
);

?>
