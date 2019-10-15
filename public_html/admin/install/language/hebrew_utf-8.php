<?php

/* Reminder: always indent with 4 spaces (no tabs). */
// +---------------------------------------------------------------------------+
// | Geeklog 2.2                                                               |
// +---------------------------------------------------------------------------+
// | hebrew_utf-8.php                                                          |
// |                                                                           |
// | Hebrew language file for the Geeklog installation script                  |
// +---------------------------------------------------------------------------+
// | Copyright (C) 2008-2019                                                   |
// | http://lior.weissbrod.com                                                 |
// +---------------------------------------------------------------------------+
// |                                                                           |
// | This program is free software; you can redistribute it and/or             |
// | modify it under the terms of the GNU General Public License               |
// | as published by the Free Software Foundation; either version 2            |
// | of the License, or (at your option) any later version.                    |
// |                                                                           |
// | This program is distributed in the hope that it will be useful,           |
// | but WITHOUT ANY WARRANTY; without even the implied warranty of            |
// | MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the             |
// | GNU General Public License for more details.                              |
// |                                                                           |
// | You should have received a copy of the GNU General Public License         |
// | along with this program; if not, write to the Free Software Foundation,   |
// | Inc., 59 Temple Place - Suite 330, Boston, MA  02111-1307, USA.           |
// |                                                                           |
// +---------------------------------------------------------------------------+

// +---------------------------------------------------------------------------+

$LANG_CHARSET = 'utf-8';
$LANG_DIRECTION = 'rtl';

// +---------------------------------------------------------------------------+
// | Array Format:                                                             |
// | $LANG_NAME[XX]: $LANG - variable name                                     |
// |                 NAME  - where array is used                               |
// |                 XX    - phrase id number                                  |
// +---------------------------------------------------------------------------+

// +---------------------------------------------------------------------------+
// install.php

$LANG_INSTALL = array(
    0 => 'Geeklog - The secure CMS.',
    1 => 'תמיכת התקנה',
    2 => '<span dir="ltr">The secure CMS.</span>',
    3 => 'התקנת Geeklog',
    4 => 'דרוש PHP %s',
    5 => 'מצטערים, אבל Geeklog דורש לפחות PHP %s בשביל לרוץ (לכם יש גירסה ',
    6 => '). אנא <a href="http://www.php.net/downloads.php">שדרגו את גירסת ה-PHP שלכם</a> או בקשו ממארחי השרת שלכם לעשות זאת בשבילכם.',
    7 => 'לא אותרו הקבצים של Geeklog',
    8 => 'ההתקנה לא הצליחה לאתר את הקבצים החשובים של Geeklog. זה כנראה מפני שהיזזתם אותם ממיקום ברירת המחדל שלהם. אנא ציינו את הנתיבים לקבצים ולספריות להלן:',
    9 => 'ברוכים הבאים ותודה לכם שבחרתם Geeklog!',
    10 => 'קובץ/ספרייה',
    11 => 'הרשאות',
    12 => 'שנו ל',
    13 => 'כרגע',
    14 => '',
    15 => 'ייצוא הכותרות ב-Geeklog מכובה. ספריית ה-<code>backend</code> לא נבדקה',
    16 => 'נדידת אתר',
    17 => 'התמונות של המשתמשים מנוטרלים. ספריית ה-<code>userphotos</code> לא נבדקה',
    18 => 'התמונות במאמרים מנוטרלים. ספריית ה-<code>articles</code> לא נבדקה',
    19 => 'כדי לפעול כמו שצריך Geeklog צריך שקבצים וספריות מסוימים יהיו ניתנים לכתיבה על ידי שרת הרשת. להלן רשימת הרשאות קבצים וספריות שעליכם לשנות לפני שתמשיכו עם ההתקנה.',
    20 => 'אזהרה!',
    21 => 'המערכת לניהול תוכן והאתר לא יעבדו כמו שצריך עד שיתוקנו הבעיות המצוינות לעיל. כישלון בקיום הצעד הזה הוא הסיבה מספר אחת שאנשים מקבלים שגיאות כשהם מנסים בפעם הראשונה להריץ את Geeklog. אנא בצעו את השינויים הדרושים לפני שהנכם ממשיכים.',
    22 => 'לא ידוע',
    23 => 'ביחרו את שיטת ההתקנה שלכם:',
    24 => 'התקנה חדשה',
    25 => 'שידרוג',
    26 => 'השינוי לא מצליח',
    27 => '. האם וידאתם שהקובץ ניתן לכתיבה על ידי השרת?',
    28 => 'siteconfig.php. האם וידאתם שהקובץ ניתן לכתיבה על ידי השרת?',
    29 => 'אתר Geeklog',
    30 => 'עוד אתר מעניין של Geeklog',
    31 => 'מידע הגדרות הכרחיות',
    32 => 'שם האתר',
    33 => 'סלוגן האתר',
    34 => 'סוג מאגר המידע',
    35 => 'MySQL',
    36 => 'MySQL עם תמיכה בטבלת InnoDB',
    37 => 'Microsoft SQL',
    38 => 'שגיאה',
    39 => 'שם השרת של מאגר המידע',
    40 => 'שם מאגר המידע',
    41 => 'שם המשתמש של מאגר המידע',
    42 => 'הסיסמה למאגר המידע',
    43 => 'תחילית הטבלאות במאגר המידע',
    44 => 'הגדרות אופציונליות',
    45 => 'כתובת האתר',
    46 => '(ללא לוכסן בסוף)',
    47 => 'נתיב ספריית ה-admin',
    48 => 'כתובת האימייל של האתר',
    49 => 'כתובת האימייל של No-Reply',
    50 => 'התקנה',
    51 => 'נדרש MySQL %s או יותר חדש',
    52 => 'מצטערים, אך Geeklog דורש לפחות MySQL %s כדי לרוץ (לכם יש גירסה ',
    53 => '). אנא <a href="http://dev.mysql.com/downloads/mysql/">שדרגו את גירסת ה-MySQL שלכם</a> או בקשו ממארחי השרת שלכם לעשות זאת בשבילכם.',
    54 => 'מידע מאגר המידע אינו נכון',
    55 => 'מצטערים, אך מידע מאגר המידע שציינתם נראה שגוי. אנא חיזרו ונסו שוב.',
    56 => 'החיבור למאגר המידע נכשל',
    57 => 'מצטערים, אך ההתקנה לא הצליחה למצוא את מאגר המידע שציינתם. מאגר המידע אינו קיים או ששגיתם באיות שמו. אנא חיזרו ונסו שוב.',
    58 => '. האם וידאתם שהקובץ ניתן לכתיבה על ידי השרת?',
    59 => 'הערה',
    60 => 'טבלאות InnoDB אינן נתמכות על ידי גירסת ה-MySQL שלכם. האם תרצו להמשיך את ההתקנה ללא תמיכה ב-InnoDB?',
    61 => 'חזרה',
    62 => 'המשך',
    63 => 'כבר מותקן מאגר מידע של Geeklog. ההתקנה לא תאפשר לכם להריץ התקנה חדשה על מאגר מידע Geeklog קיים. כדי להמשיך הנכם חייבים לעשות אחד מהדברים הבאים:',
    64 => 'מיחקו את הטבלאות ממאגר המידע הקיים. או פשוט מיחקו את מאגר המידע וצרו אותו צחדש. ליחצו על "נסיון חוזר" שלהלן.',
    65 => 'בצעו שידרוג למאגר מידע (לגירסת Geeklog חדשה) על ידי בחירת אופציית השידרוג שלהלן.',
    66 => 'נסיון חוזר',
    67 => 'שגיאה בהקמת מאגר המידע של Geeklog',
    68 => 'מאגר המידע אינו ריק. אנא מיחקו את כל הטבלאות במאגר המידע והתחילו מחדש.',
    69 => 'שידרוג Geeklog',
    70 => 'לפני שנתחיל חשוב שתגבו את מאגר המידע של Geeklog הנוכחי שלכם. ההתקנה תשנה את מאגר המידע של Geeklog כך שאם משהו ישתבש ותאולצו להתחיל מחדש את תהליך השידרוג, תצטרכו גיבוי של מאגר המידע המקורי. *ראו הוזהרתם!*',
    71 => 'אנא ודאו שבחרתם את הגירסה הנכונה של Geeklog שאותה תרצו לשדרג. ההתקנה משדרגת בשלבים לפי כל גרסה החל מהגירסה שבחרתם (כלומר תוכלו לשדרג ישירות מכל גירסה ישנה היישר אל ',
    72 => ').',
    73 => 'אנא שימו לב שההתקנה לא תשדרג שום גרסת בטה או גרסה מועמדת לשיחרור של Geeklog.',
    74 => 'מאגר המידע כבר מעודכן!',
    75 => 'נראה שמאגר המידע שלכם כבר מעודכן. כנראה שהרצתם כבר שדרוג. אם אתם צריכים להריץ את השידרוג מחדש, אנא התקינו מחדש את גיבוי מאגר המידע שלכם ונסו שוב.',
    76 => 'בחירת גרסת ה-Geeklog הנוכחית שלכם',
    77 => 'ההתקנה לא הצליחה לזהות את הגירסה הנוכחית שלכם של Geeklog, אנא ביחרו אותה מהרשימה שלהלן:',
    78 => 'תקלה בשידרוג',
    79 => 'חלה תקלה בזמן השידרוג של התקנת Geeklog שלכם.',
    80 => 'שינוי',
    81 => 'הפסיקו!',
    82 => 'חשוב מאוד שתשנו את הרשאות הקבצים הרשומים להלן. Geeklog לא יצליח לעבור התקנה עד שתעשו זאת.',
    83 => 'תקלה בהתקנה',
    84 => 'הנתיב ',
    85 => '" נראה שאינו נכון. אנא חיזרו ונסו שוב.',
    86 => 'שפה',
    87 => 'https://www.geeklog.net/forum/index.php?forum=1',
    88 => 'שינוי הספרייה והקבצים שבה ל',
    89 => 'גירסה נוכחית:',
    90 => 'מאגר מידע ריק?',
    91 => 'נראה שמאגר המידע שלכם ריק או שהגדרות ההזדהות שציינתם בשבילו אינן נכונות. או שאולי התכוונתם לבצע התקנה חדשה (ולא שידרוג)? אנא חיזרו ונסו שוב.',
    92 => 'שימוש ב-UTF-8',
    93 => 'הצלחה',
    94 => 'הנה כמה טיפים למצוא את הנתיב הנכון:',
    95 => 'הנתיב המלא לקובץ זה (סקריפט ההתקנה) הוא:',
    96 => 'ההתקנה חיפשה את %s ב:',
    97 => 'הגדרת הרשאות קבצים',
    98 => 'משתמשים מתקדמים',
    99 => 'אם יש לכם ממשק שורת פקודה (SSH) לשרת הרשת שלכם אז תוכלו פשוט להעתיק ולהדביק את הפקודה הבאה למעטפת הפקודה שלכם:',
    100 => 'סופק מצב לא נכון',
    101 => 'שלב',
    102 => 'הכניסו את מידע הכיוון',
    103 => '',
    104 => 'נתיב בספריית ניהול לא נכון',
    105 => 'מצטערים, אבל נתיב ספריית הניהול שהכנסתם אינו נראה נכון. אנא חיזרו אחורה ונסו שנית.',
    106 => 'PostgreSQL',
    107 => 'נחוצה סיסמת מאגר מידע לאתרים שבאוויר.',
    108 => 'לא נבחרו מנועי מאגר מידע!',
    109 => 'כלי סיוע חירום',
    110 => 'The permissions seem to be correct but the install script still cannot write to the Geeklog directory. If you happen to be on SELinux, make sure the httpd process has write permissions for the same, try this out:',
    111 => 'Geeklog Version',
    112 => 'Install (includes all plugins)',
    113 => 'Install (then select plugins to install)',
    114 => 'Only plugins that support being auto installed will be installed (all core plugins do). The plugins that don\'t support this can be installed via the Plugins Administration from the Geeklog Command & Control.',
    115 => 'Upgrade',
    116 => 'Clicking the "Upgrade" button will upgrade Geeklog to the latest version including all core plugins (if required).',
    117 => 'Cancel',
    118 => 'Change Language',
    119 => 'Copyright © 2019 <a href="https://www.geeklog.net/">Geeklog</a>'
);

// +---------------------------------------------------------------------------+
// success.php

$LANG_SUCCESS = array(
    0 => 'ההתקנה הושלמה',
    1 => 'ההתקנה של Geeklog ',
    2 => ' הושלמה!',
    3 => 'כל הכבוד, הצלחתם ',
    4 => ' Geeklog. אנא קחו רגע כדי לקרוא את המידע המצוין להלן.',
    5 => 'כדי להזדהות באתר ה-Geeklog החדש שלכם, אנא השתמשו בחשבון זה:',
    6 => 'שם משתמש:',
    7 => 'Admin',
    8 => 'סיסמה:',
    9 => 'password',
    10 => 'אזהרת אבטחה',
    11 => 'אל תשכחו לבצע',
    12 => 'דברים',
    13 => 'להסיר או לשנות את שם ספריית ההתקנה,',
    14 => 'לשנות ל-',
    15 => 'את סיסמת החשבון.',
    16 => 'לשנות את ההרשאות של',
    17 => 'וגם של',
    18 => 'בחזרה ל:',
    19 => '<strong>שימו לב:</strong> עקב כך ששונה מודל האבטחה, יצרנו חשבון חדש עם ההרשאות שהנכם זקוקים להן כדי לנהל את אתרכם החדש.  שם המשתמש של חשבון חדש זה הוא <b>NewAdmin</b> והסיסמה היא <b>password</b>',
    20 => 'להתקין את',
    21 => 'לשדרג את',
    22 => 'נדדה',
    23 => 'Would you like to delete all the files and directories used during the installation?',
    24 => 'Yes, please.',
    25 => 'No, thanks.  I will manually delete them afterwards.'
);

// +---------------------------------------------------------------------------+
// migration

$LANG_MIGRATE = array(
    0 => 'תהליך הנדידה ישכתב כל מידע קיים במאגר המידע.',
    1 => 'לפני שתמשיכו',
    2 => 'היו בטוחים שכל plugin שהותקן בעבר הועתק לשרתכם החדש.',
    3 => 'היו בטוחים שכל התמונות מ-<code dir="ltr">public_html/images/articles/</code>, <code dir="ltr">public_html/images/topics/</code>, ו-<code dir="ltr">public_html/images/userphotos/</code>, הועתקו לשרתכם החדש.',
    4 => 'אם הנכם משדרגים מגירסת Geeklog ישנה יותר מ-<strong>1.5.0</strong>, אז היו בטוחים שהעתקתם כל קבצי ה-<code>config.php</code> כדי שהנדידה תוכל למצוא את הגדרותיכם.',
    5 => 'אם הנכם משדרגים לגרסת Geeklog חדשה, אז אל תעלו את ה-theme שלכם עדיין. השתמשו ב-theme ברירת המחדל הכלול עד שתוכלו להיות בטוחים שאתרכם שנדד עובד כמו שצריך.',
    6 => 'ביחרו גיבוי קיים',
    7 => 'ביחרו קובץ...',
    8 => 'מספריית הגיבויים של שרתכם',
    9 => 'מהמחשב שלכם',
    10 => 'ביחרו קובץ...',
    11 => 'לא מצאו קבצי גיבוי.',
    12 => 'גבול ההעלאה לשרת זה הוא ',
    13 => '. אם קובץ הגיבוי שלכם גדול מ ',
    14 => ' או אם נתקלתם בהודעת זמן אזל, אז עליכם להעלות את הקובץ לספריית הגיבויים של Geeklog דרך FTP.',
    15 => 'ספריית הגיבויים שלכם אינה ניתנת לכתיבה על ידי שרת הרשת. ההרשאות צריכות להיות 777.',
    16 => 'נדידה',
    17 => 'נדידה מתוך גיבוי',
    18 => 'לא נבחר קובץ גיבוי',
    19 => 'השמירה נכשלה ',
    20 => ' אל ',
    21 => 'הקובץ',
    22 => 'כבר קיים. האם תרצו להחליפו?',
    23 => 'כן',
    24 => 'לא',
    25 => '',
    26 => 'הערת נדידה: ',
    27 => 'ה-"',
    28 => '" plugin חסר ונוטרל. תוכלו להתקינו ולהפעילו מחדש בכל זמן מאיזור הניהול.',
    29 => 'התמונה "',
    30 => '" שרשומה בטבלה"',
    31 => '" לא נמצאה בתוך ',
    32 => 'קובץ מאגר המידע הכיל מידע מ-plugin אחד או יותר שסקריפט הנדידה לא הצליח למצוא בספרייה ',
    33 => 'שלכם. ה-plugins נוטרלו. תוכלו להתקינם ולהפעילם מחדש בכל זמן מאיזור הניהול.',
    34 => 'קובץ מאגר המידע הכיל מידע מקובץ אחד או יותר שסקריפט הנדידה לא הצליח למצוא בספרייה',
    35 => 'שלכם. בדיקו את <code>error.log</code> לפרטים נוספים.',
    36 => 'תוכלו לתקן זאת בכל זמן.',
    37 => 'הנדידה הושלמה',
    38 => 'תהליך הנדידה הושלם. עם זאת, סקריפט ההתקנה מצא את הדברים הבאים:',
    39 => 'נכשלה הגדרת נתיב PEAR include. מצטערים, אין דרך לטפל בגיבויי מאגר מידע מכווצים בלי PEAR.',
    40 => 'הארכיון "s$1%" לא נראה שהוא הכיל קבצי SQL. כדי לנסות שוב, לחץ על <a href="s$2%\"> </a> זה ',
    41 => 'שגיאה בהוצאת גיבוי מאגר המידע \'%s\' מתוך קובץ הגיבוי המכווץ.',
    42 => 'קובץ הגיבוי \'%s\' פשוט נעלם ...',
    43 => 'היבוא בוטל. הקובץ  \'%s\' לא נראה כמו SQL dump.',
    44 => 'שגיאה חמורה: יבוא מאגר המידע נראה שנכשל. לא ברור איך להמשיך.',
    45 => 'לא היה אפשר לזהות את גרסת מאגר המידע. אנא בצעו עדכון ידני.',
    46 => '',
    47 => 'שדרוג מאגר המידע מגירסה %s לגירסה %s נכשל.',
    48 => 'אחד או יותר מה-plugins לא הצליח להתעדכן והיה אילוץ לנטרלו.',
    49 => 'השתמשו בתוכן מאגר המידע הנוכחי'
);

// +---------------------------------------------------------------------------+
// install-plugins.php

$LANG_PLUGINS = array(
    1 => 'התקנת Plugin',
    2 => 'שלב',
    3 => 'ה-plugins של Geeklpg הם תוספות המאפשרות שימושיות חדשה ומניפות את השירותים הפנימיים של Geeklog. כברירת מחדל, Geeklog כולל כמה plugins שימושיים שאולי תרצו להתקין.',
    4 => 'תוכלו גם לבחור להעלות plugins נוספים.',
    5 => 'הקובץ שהעלתם אינו קובץ ZIP או GZip מכווץ.',
    6 => 'ה-plugin שהעלתם כבר קיים!',
    7 => 'הצלחה!',
    8 => 'ה-plugin %s הועלה בהצלחה.',
    9 => 'העלאת plugin',
    10 => 'בחירת קובץ plugin',
    11 => 'העלאה',
    12 => 'ביחרו אילו plugins להתקין',
    13 => 'להתקין?',
    14 => 'Plugin',
    15 => 'גירסה',
    16 => 'לא ידוע',
    17 => 'הערה',
    18 => 'plugin זה דורש הפעלה ידנית מפאנל הניהול של ה-plugins.',
    19 => 'רענון',
    20 => 'אין plugins חדשים להתקנה.'
);

// +---------------------------------------------------------------------------+
// bigdump.php

$LANG_BIGDUMP = array(
    0 => 'התחלת יבוא',
    1 => ' מ ',
    2 => ' אל ',
    3 => ' ב ',
    4 => 'לא יכול לחפש ב ',
    5 => 'לא יכול להיפתח ',
    6 => ' ליבוא.',
    7 => '*לא צפוי*: ערכים לא מספריים להתחלה ולאוף-סט.',
    8 => 'מעבד את הקובץ:',
    9 => 'לא יכול להגדיר סמן קובץ אחרי סוף הקובץ.',
    10 => 'לא יכול לקבוע את סמן הקובץ לאופ-סט: ',
    11 => 'אין סיומת MySQL זמינה בהתקנת ה-PHP שלכם.',
    14 => 'נעצר בשורה ',
    15 => '. במקום זה המשוב הנוכחי כולל יותר מאשר ',
    16 => ' שורות dump. זה יכול לקרות אם קובץ ה-dump שלכם נוצר על ידי כלי שלא שם נקודה פסיק ואז עובר שורה בסוף של כל משוב, או שה-dump שלכם כולל הכנסות מורחבות. אנא קיראו את השאלות השכיחות של BigDump למידע נוסף.',
    17 => 'שגיאה בשורה ',
    18 => 'משוב: ',
    19 => 'MySQL: ',
    20 => 'לא מצליח לקרוא את האופ-סט של סמן הקובץ.',
    21 => 'לא אפשרי לקבצי gzip',
    22 => 'התקדמות',
    23 => 'נדידת מאגר המידע הושלמה בהצלחה! אתם תופנו בעוד רגע.',
    24 => 'מחכה ',
    25 => ' מילישניות</b> לפני המשך למהלך הבא...',
    26 => 'ליחצו כאן',
    27 => 'לביטול היבוא',
    28 => 'או חכו!',
    29 => 'התרחשה שגיאה.',
    30 => 'מתחיל מההתחלה',
    31 => '(DROP את הטבלאות הישנות לפני התחלה מחדש)'
);

// +---------------------------------------------------------------------------+
// Error Messages

$LANG_ERROR = array(
    0 => 'הקובץ שהועלה עובר את הוראת ה-upload_max_filesize ב-php.ini. אנא העלו את קובץ הגיבוי בשיטה אחרת, למשל FTP.',
    1 => 'הקובץ שהועלה עובר את הוראת MAX_FILE_SIZE שצוינה בטופס ה-HTML. אנא העלו את קובץ הגיבוי בשיטה אחרת, למשל FTP.',
    2 => 'הקובץ שהועלה הועלה רק באופן חלקי.',
    3 => 'שום קובץ לא הועלה.',
    4 => 'חסרה ספרייה זמנית.',
    5 => 'נכשלה כתיבת הקובץ לכונן.',
    6 => 'העלאת הקובץ נעצרה לפי הסיומת.',
    7 => 'הקובץ שהועלה עובר את הוראת post_max_size ב-php.ini. אנא העלו את קובץ מאגר המידע שלכם בשיטה אחרת, למשל FTP.',
    8 => 'שגיאה',
    9 => 'כשל בחיבור למאגר המידע שלכם עם השגיאה: ',
    10 => 'בידקו את הגדרות מאגר המידע שלכם',
    11 => 'Warning',
    12 => 'Information',
    14 => 'Upgrade Notices',
    15 => 'Topic IDs and Names max length have changed from 128 to 75. This may cause issues when topic ids are truncated (if id is larger than 75 characters) during the upgrade. Please double check your topic ids that are larger than 75 characters will be unique when the max length is changed.',
    16 => 'Topic IDs and Names have changed from 128 to 75. It has been detected you need to modify 1 or more topic ids before this upgrade can proceed.',
    17 => 'Professional Theme support has been dropped from Geeklog. If you are currently using the Professional theme or Professional_css theme from Geeklog 2.1.1 or older your website may not function properly.',
    18 => 'Comment Signatures',
    19 => "Comment Signatures before Geeklog 2.2.0 where stored with the comment. Now they are added when the comment is viewed. For backwards compatibility the upgrade will remove all comment signatures stored directly\n    with the comment  (so comment signatures will not display twice).",
    20 => 'Plugin Compatibility',
    21 => 'Geeklog internally has undergone some changes which may affect compatibility of some older plugins which have not been updated in a while. Please make sure all the plugins you have installed have been updated to the latest version before upgrading Geeklog to v2.2.0.<br><br>If you still wish to upgrade Geeklog to v2.2.0 and you are not sure about a plugin please post a question about it on our <a href="https://www.geeklog.net/forum/index.php?forum=2" target="_blank">Geeklog Forum</a>. Else, you can also disable or uninstall the plugin and then perform the Geeklog upgrade.<br><br>If you do perform the upgrade and run into problems you can then use the <a href="/admin/install/rescue.php">Geeklog Emergency Rescue Tool</a> to disable the plugin with the issue.',
    22 => 'Default Security Group Assignments',
    23 => 'User security group assignments for groups "Root" and "All Users" will be fixed along with the security group assignments for the "Admin" (2) user. The "Admin" user had duplicate permissions in some cases and these will be removed after this upgrade.<br><br>Please Note: The issue that caused duplicate permissions has been fixed but it does mean any user that you may have edited in the Admin User Editor before Geeklog v2.2.1 may have been affected. This only really affects permissions when you have security groups within security groups. While these permissions at the time of saving the user are correct if you modified security groups since then these users may still have access to groups they may have been removed from now. As each site is setup differently, the only way to fix this is for the Admin to review each user manually and confirm their security privileges.',
    24 => 'FCKEditor Removed',
    25 => 'The Advanced Editor FCKEditor has been removed from Geeklog since development for it has been stopped. If your Geeklog website is currently set to use the FCKEditor it will be updated to use the editor which currently ships with Geeklog called the CKEditor.',
    26 => 'Google+ OAuth Login',
    27 => 'The <a href="https://support.google.com/plus/answer/9195133" target="_blank">Google+ service shut down on April 2, 2019</a>. As of Geeklog v2.2.1 we will move from the Google+ OAuth authentication method and scope to the Google OAuth authentication method and scope. Because of this change and depending on when you created your Google API keys, you may need to update these keys in the Geeklog configuration or users who use this login method may receive an error.<br><br>Geeklog now offers the option to convert remote accounts to local accounts. If you have any remote accounts (like Google OAuth, Facebook OAuth, OpenID, etc..) you want to convert, edit the user account from the User Manager and then check off the "convert from remote to a local account" option and click on save. At this point the account will be converted to a local account and a random password will be generated. If the account has an email address and the status is set to "Active" an email will be automatically sent to the user about how to access their account. If not, you will manually have to fill in this information and let the user know how they can access their local account.',
    28 => 'Duplicate Usernames & Usernames with Trailing Spaces',
    29 => 'In some cases through remote accounts blank or duplicate usernames (some may have had trailing spaces) could be created. Blank username accounts are the results of remote account login errors so they will be deleted. Accounts that have duplicate names (could include local accounts) will have their accounts renamed. Some local account users may need to use the "Forget Your Password" to retrieve their new username.<br><br>Please note: This issue is a very rare occurrence and can only happen if you have remote user accounts. Most users will be unaffected.',
    30 => 'Submitted Articles with Incorrect Permissions',
    31 => 'Since Geeklog v2.0.0 the default article permissions and the Story Admin Group where not used for the default permissions when a submitted article was approved or brought up in the Article Editor. Instead the Topic Admin group and the default topic permissions for the article was used. This has now been fixed but you must manually go through and check any previously submitted articles and update their permissions if needed.<br><br>If you want all articles to belong to the Story Admin group set using your current article default permissions this can be easily done. Please check out the <a href="https://www.geeklog.net/forum/viewtopic.php?showtopic=97115" target="_blank">Geeklog Support Forum</a> for more information.',
    32 => 'Static Pages Search Results Fix',
    33 => 'If you use Static Pages with PHP or templates the search results returned by Geeklog could show any code embedded in the page. This has now been fixed as all pages that use these features will now save a cached copy of the final executed page. This cached page is generated on the save of the page in the editor and (if cache enabled) when a new cached file of the page is made. This means that all users that have access to the page will use the same search cache.  If autotags, PHP, or the is device_mobile template variable is used by the page this may generate different contents depending on the user. Since the search cache is only one view of the page it will be the one searched. Therefore what the search result returns may be slighyly different than what the user will see when they visit the page. Please take this short coming into consideration when using template and php pages and having the Include in Search config option set to true.<br><br><em>Before upgrading Geeklog (and the Static Pages Plugin) you must ensure all non draft Static Pages that use templates or execute PHP are able to evaluate without error (ie you can view them on the website). If they do not, this will cause <strong>the Static Pages Upgrade to error out and the Geeklog Upgrade to fail</strong> when it attempts to update the search cache for these pages.</em>'
);

// +---------------------------------------------------------------------------+
// help.php

$LANG_HELP = array(
    0 => 'תמיכה בהתקנת Geeklog',
    'site_name' => 'שם האתר שלכם.',
    'site_slogan' => 'תיאור פשוט של האתר שלכם.',
    'db_type' => 'Geeklog יכול להיות מותקן בעזרת שימוש במאגר מידע של MySQL, של PostgreSQL או של Microsoft SQL. אם אינכם בטוחים איזו אופצייה לבחור עליכם ליצור קשר עם מארחי השרת שלכם.</p><p class="indent"><strong>שימו לב:</strong> טבלאות InnoDB עשויות לשפר את הביצועים באתרים (מאוד) גדולים, אך גם להפוך את גיבויי מאגר המידע ליותר מסובכים.',
    'db_host' => 'שם הרשת (או כתובת ה-IP) של שרת מאגר המידע שלכם. בדרך כלל זהו "localhost". אם אינכם בטוחים צרו קשר אם מארחי השרת שלכם.',
    'db_name' => 'שם מאגר המידע שלכם. אם אינכם בטוחים מהו צרו קשר עם מארחי השרת שלכם.',
    'db_user' => 'שם המשתמש של מאגר המידע שלכם. אם אינכם בטוחים מהו צרו קשר עם מארחי השרת שלכם.',
    'db_pass' => 'סיסמת מאגר המידע שלכם. אם אינכם בטוחים מהי צרו קשר עם מארחי השרת שלכם.',
    'db_prefix' => 'חלק מהמשתמשים מעוניינים להתקין העתקים מרובים של Geeklog על אותו מאגר מידע. כדי שכל עותק של Geeklog יוכל לתפקד כמו שצריך הוא חייב שתהיה לו תחילית טבלה ייחודית (כלומר gl1_, gl2_, וכדומה).',
    'site_url' => 'ודאו שזוהי הכתובת הנכונה של האתר שלכם. כלומר, איפה שהקובץ של Geeklog בשם <code>index.php</code> נמצא (ללא לוכסן בסוף).',
    'site_admin_url' => 'לחלק ממארחי השרתים יש ספריית ניהול מוגדרת מראש. במקרה זה, תצטרכו לשנות את שם ספריית ה-admin של Geeklog למשהו כמו "myadmin" ולשנות את הכתובת שלהלן בהתאם. אל תעשו זאת אלא אם תיתקלו בבעיות כשתנסו לגשת לתפריט הניהול של Geeklog.',
    'site_mail' => 'זוהי הכתובת החוזרת בכל הודעות האימייל שישלחו מ-Geeklog ובמידע צרו קשר שמוצג בהזנות סינדיקציה.',
    'noreply_mail' => 'זוהי כתובת השולח של הודעות אימייל שנשלחות על ידי המערכת כשמשתמשים נרשמים וכדומה. היא צריכה להיות זהה לכתובת האימייל של האתר או להיות כתובת שלא מקבלת הודעות כדי למנוע מספאמרים להשיג את כתובת האימייל שלכם על ידי הרשמה לאתר. אם היא לא זהה לכתובת הרגילה, תהיה הודעה בהודעות שישלחו שלא מומלץ לענות להן.',
    'utf8' => 'ציינו האם להשתמש ב-UTF-8 בתור קידוד ברירת המחדל של האתר שלכם. מומלץ בעיקר להתקנות רב לשוניות.',
    'migrate_file' => 'ביחרו את קובץ הגיבוי שברצונכם שינדוד. הוא יכול להיות קובץ קיים בספריית "backups" שלכם או שתוכלו להעלות קובץ מהמחשב שלכם. לחילופין, הנכם יכולים גם לנייד את התכנים הנוכחיים של מאגר המידע.',
    'plugin_upload' => 'ביחרו ארכיון plugin (בצורת zip, tar.gz או tgz) בשביל להעלות ולהתקין.'
);

// +---------------------------------------------------------------------------+
// rescue.php

$LANG_RESCUE = array(
    0 => 'הכניסה למערכת הצליחה',
    1 => 'כלי סיוע חירום של Geeklog',
    2 => 'התקנת Geeklog',
    3 => 'כלי סיוע חירום של Geeklog',
    4 => 'אל תשכחו <strong>למחוק את הקובץ {{SELF}} הזה ואת ספריית ההתקנה ברגע שתסיימו!</strong> אם משתמשים אחרים ינחשו את הססמה, הם יוכלו לפגוע בצורה חמורה בהתקנת ה-Geeklog שלכם!',
    5 => 'סטטוס',
    6 => 'הנכם מנסים לגשת למקום מאובטח. לא תוכלו להמשיך עד שתעברו את בדיקת האבטחה.',
    7 => 'כדי לוודא את זהותכם, אנו דורשים שתקלידו את ססמת מאגר המידע שםכם. זוהי הססמה שרשומה בקובץ geeklog\'s db-config.php',
    8 => 'ססמה',
    9 => 'וודאו אותי',
    10 => 'הססמה לא נכונה!',
    11 => 'איפשור ',
    12 => 'ניטרול ',
    13 => 'הצלחה ',
    14 => 'שגיאה ',
    15 => 'חלה שגיאה בעדכון הכיוונים',
    16 => 'עדכון הכיוונים הסתיימה בהצלחה',
    17 => 'חלה שגיאה בעדכון ססמתכם',
    18 => 'בקשת ססמת Geeklog',
    19 => 'בוקשה ססמה',
    20 => 'מישהי (בתקווה אתם) ניגש לטופס בקשת ססמת חירום וססמה חדשה:"%s" לחשבונכם "%s" שבתוך %s, נוצרה.',
    21 => 'אם זה לא הייתם אתם, אנא בידקו את אבטחת אתרכם. בידקו שהסרתם את טופס סיוע החירום /admin/rescue.php',
    22 => 'ססמה חדשה נשלחה לכתובת האימייל הרשומה',
    23 => 'חלה שגיאה בשליחת אימייל עם הנושא: ',
    24 => 'מידע PHP',
    25 => 'חזרה למסך הראשי',
    26 => 'מידע מערכת',
    27 => 'גרסת PHP',
    28 => 'גרסה Geeklog',
    29 => 'אפשרויות',
    30 => 'אם יצא לכם להתקין plugin או תוסף שהפיל את אתר ה-Geeklog שלכם, תוכלו לתקן את הבעיה בעזרת האפשרויות שלהלן.',
    31 => 'איפשרו/ניטרול plugins',
    32 => 'איפשרו/ניטרול קוביות מידע',
    33 => 'עריכת ערכי $_CONF נבחרים',
    34 => 'איפוס ססמת ניהול',
    35 => 'כאן תוכלו לאפשר/לנטרל כל plugin שכרגע מותקן באתר ה-Geeklog שלכם.',
    36 => 'בחירת plugin',
    37 => 'איפשור',
    38 => 'ניטרול',
    39 => 'כאן תוכלו לאפשר/לנטרל כל קוביית מידע (חוץ מדינמית) שכרגע מותקמת באתר ה-Geeklog שלכם.',
    40 => 'בחירת קוביית מידע',
    41 => 'אישור',
    42 => 'תוכלו לערוך כמה אפשרויות $_CONF מרכזיות.',
    43 => 'כאן תוכלו לאפס את הססמה הראשית/הניהולית של Geeklog שלכם.',
    44 => 'שליחת הססמה באימייל',
    45 => 'Geeklog appears not to be installed or the install did not complete properly as core information is missing in the Geeklog database. Therefore this rescue tool cannot be used.'
);

// which texts to use as labels, so they don't have to be translated again
$LANG_LABEL = array(
    'site_name'      => $LANG_INSTALL[32],
    'site_slogan'    => $LANG_INSTALL[33],
    'db_type'        => $LANG_INSTALL[34],
    'db_host'        => $LANG_INSTALL[39],
    'db_name'        => $LANG_INSTALL[40],
    'db_user'        => $LANG_INSTALL[41],
    'db_pass'        => $LANG_INSTALL[42],
    'db_prefix'      => $LANG_INSTALL[43],
    'site_url'       => $LANG_INSTALL[45],
    'site_admin_url' => $LANG_INSTALL[47],
    'site_mail'      => $LANG_INSTALL[48],
    'noreply_mail'   => $LANG_INSTALL[49],
    'utf8'           => $LANG_INSTALL[92],
    'migrate_file'   => $LANG_MIGRATE[6],
    'plugin_upload'  => $LANG_PLUGINS[10]
);
