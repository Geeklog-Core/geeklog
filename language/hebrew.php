<?php

###############################################################################
# hebrew.php # last Update  07/03/2004 23:35
# this is "hebrew.php" Written by Tal Vizel tal-hebrew-lang-gl@1212.co.il
# This is the Hebrew language page for GeekLog!
# Special thanks to Mischa Polivanov for his work on this project
#
# Copyright (C) 2000 Jason Whittenburg
# jwhitten@securitygeeks.com
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

$LANG_CHARSET = 'utf-8';

###############################################################################
# Array Format:
# $LANGXX[YY]:  $LANG - variable name
#               XX    - file id number
#               YY    - phrase id number
###############################################################################

###############################################################################
# USER PHRASES - These are file phrases used in end user scripts
###############################################################################

###############################################################################
# lib-common.php

$LANG01 = array(
    1 => 'נכתב על-ידי',
    2 => 'פרטים נוספים',
    3 => 'תגובות',
    4 => 'עריכה',
    5 => 'סקר השבוע',
    6 => 'תוצאות',
    7 => 'תוצאות הסקר',
    8 => 'קולות',
    9 => 'אדמיניסטרציה',
    10 => 'לוח בקרה',
    11 => 'מאמרים',
    12 => 'קוביות מידע',
    13 => 'נושאים',
    14 => 'קישורים',
    15 => 'אירועים',
    16 => 'סקרים',
    17 => 'משתמשים',
    18 => 'שאילתת SQL',
    19 => 'התנתק',
    20 => 'פרטי משתמש',
    21 => 'שם משתמש',
    22 => 'קוד משתמש',
    23 => 'רמת אבטחה',
    24 => 'אורח/ת באתר',
    25 => 'תגובה',
    26 => 'אין אתר זה אחרי לחומר הנכתב בו. האחריות על על כותבי ההודעות בלבד!',
    27 => 'ההודעה החדשה ביותר',
    28 => 'מחק',
    29 => 'לא נרשמו תגובות',
    30 => 'מאמרים ישנים',
    31 => 'אפשר כתיבת HTML',
    32 => 'הודעת שגיאה, חסר שם משתמש!',
    33 => 'הודעת שגיאה, לא מצליח לכתוב לקובץ log',
    34 => 'ישנה שגיאה! Error',
    35 => 'התנתק Logout',
    36 => 'בשעה:',
    37 => 'טרם נכתבו הודעות  ',
    38 => '38',
    39 => 'רענן',
    40 => '40',
    41 => 'אורח',
    42 => 'נכתב על-ידי:',
    43 => 'הוסף תגובה',
    44 => 'ראשי',
    45 => 'מספר הודעת שגיאה של MySQL:',
    46 => 'הודעת שגיאה של MySQL:',
    47 => 'אפשרויות משתמש',
    48 => 'פרטי חשבון',
    49 => 'מאפיני תצוגה',
    50 => 'Error with SQL statement',
    51 => 'עזרה',
    52 => 'חדש',
    53 => 'Admin Home',
    54 => 'לא מצליח לפתוח את הקובץ!',
    55 => 'שגיאה ב-',
    56 => 'הצבע',
    57 => 'סיסמה',
    58 => 'כניסה',
    59 => "אם אין לך עדיין חשבון, זה הזמן <a href=\"{$_CONF['site_url']}/users.php?mode=new\">להרשם</a> לאתר",
    60 => 'הוסף תגובה',
    61 => 'צור חשבון חדש',
    62 => 'מילים',
    63 => 'מאפיני תגובה',
    64 => 'שלח את המאמר לחבר',
    65 => 'גרסא להדפסה',
    66 => 'היומן שלי',
    67 => 'ברוך הבא ל',
    68 => 'בית',
    69 => 'קשר',
    70 => 'חיפוש',
    71 => 'הוסף הודעה',
    72 => 'לינקים',
    73 => 'מאגר הסקרים',
    74 => 'יומן',
    75 => 'חיפוש מתקדם',
    76 => 'סטטיסטיקה',
    77 => 'הרחבות לGeeklog',
    78 => 'אירועים צפויים',
    79 => 'חדש באתר',
    80 => 'stories in last',
    81 => 'הודעות ב',
    82 => 'שעות',
    83 => 'תגובות',
    84 => 'קישורים',
    85 => 'ב 48 השעות האחרונות',
    86 => 'אין תגובות חדשות',
    87 => 'בשבועיים האחרונים',
    88 => 'אין קישורים חדשים',
    89 => 'אין אירועים צפויים',
    90 => 'דף הבית',
    91 => 'דף זה נוצר ב',
    92 => 'שניות',
    93 => 'זכויות יוצרים',
    94 => 'כל זכויות היוצרים בדף זה שייכים לכותבים',
    95 => 'מופעל על-ידי',
    96 => 'קבוצות',
    97 => 'רשימה בינלאומית',
    98 => 'תוספים והרחבות',
    99 => 'מאמרים',
    100 => 'אין מאמרים חדשים',
    101 => 'האירועים שלך',
    102 => 'אירועים כלליים',
    103 => 'יצירת גיבוי',
    104 => 'על-ידי',
    105 => 'משתמשי דואר',
    106 => 'נצפה',
    107 => 'GL Version Test',
    108 => 'Clear Cache',
    109 => 'Report abuse',
    110 => 'Report this post to the site admin',
    111 => 'View PDF Version',
    112 => 'Registered Users',
    113 => 'Documentation'
);

###############################################################################
# calendar.php

$LANG02 = array(
    1 => 'יומן אירועים',
    2 => 'אין אירועים חדשים להצגה',
    3 => 'מתי',
    4 => 'איפה',
    5 => 'תיאור',
    6 => 'הוסף אירוע',
    7 => 'אירועים צפויים',
    8 => 'על-ידי הוספת אירוע זה ליומנך יתאפשר לך לצפות בקלות רק באירועים המענינים אותך על-ידי לחיצה על "היומן שלי" מאזור "אפשרויות המשתמש" .',
    9 => 'הוסף ליומן שלי',
    10 => 'הסר מהיומן שלי',
    11 => "הוספת אירוע ליומן של {$_USER['username']}",
    12 => 'אירוע',
    13 => 'מתחיל ב',
    14 => 'מסתיים ב',
    15 => 'חזרה ליומן'
);

###############################################################################
# comment.php

$LANG03 = array(
    1 => 'הוסף הערה',
    2 => 'מאפיין הוספה',
    3 => 'התנתק',
    4 => 'צור חשבון',
    5 => 'שם משתמש',
    6 => 'כדי לכתוב הודעות באתר זה עליך להתחבר תחילה. אם אין לך עדיין חשבון, ניתן ליצור חשבון חדש על-ידי השדות הנמצאים מטה, תודה. ',
    7 => 'הודעתך האחרונה הייתה: ',
    8 => "שניות מההודעה האחרונה שלך. באתר זה יש מגבלה והזמן המינימלי הנדרש בין שני ההודעות הוא: {$_CONF['commentspeedlimit']}",
    9 => 'הערה',
    10 => '10 LANG03',
    11 => 'הוסף תגובה',
    12 => 'חובה למלא את שדות הכותרת והתגובה על-מנת להעלות הודעה.',
    13 => 'המידע שלך',
    14 => 'צפייה לפני ההוספה',
    15 => '15 LANG03 ריק ',
    16 => 'כותרת',
    17 => 'שגיאה',
    18 => 'דברים חשובים',
    19 => 'נא להשתדל להגיב על נושא ההודעה ולא להעלות נושאים חדשים, תודה.',
    20 => 'נא להגיב על הודעות קודמות ולא לפתוח נושאים חדשים, תודה.',
    21 => 'נא לקרוא את התגובות שנכתבו לפניך, בכדי לא לחזור על דברים שכבר נאמרו, תודה.',
    22 => 'השתמש בכותרת שתתאר בבירור את נושא ההודעה/מאמר שלך.',
    23 => 'האימיל שלך לא יוצג לגולשים באתר',
    24 => 'משתמש חסוי',
    25 => 'Are you sure you want to report this post to the site admin?',
    26 => '%s reported the following abusive comment post:',
    27 => 'Abuse report'
);

###############################################################################
# users.php

$LANG04 = array(
    1 => 'פרופיל משתמש של',
    2 => 'שם משתמש',
    3 => 'שם ושם משפחה',
    4 => 'סיסמה',
    5 => 'דואל',
    6 => 'אתר בית',
    7 => 'פרטים אישיים:',
    8 => 'מפתח PGP',
    9 => 'שמור נתונים',
    10 => 'עשרת התגובות האחרונות של',
    11 => 'אין תגובות',
    12 => 'מאפיני המשתמש של',
    13 => 'Email Nightly Digest',
    14 => 'סיסמה זו נוצרה בצורה רנדומלית, אולם מומלץ לשנות אותה מוקדם ככל האפשר. על מנת לעשות זאת, כנס/י לחשבונך הקליד/י על מאפייני החשבון, מתפריט שנמצא בחשבונך.',
    15 => "יצירת חשבונך ב{$_CONF['site_name']} הושלם בהצלחה!. כעת, על-מנת להשתמש בו עליך להכניס בכניסה את שם המשתמש שלך ואת הסיסמא שקיבלת כאן. מומלץ לשמור את האימייל הזה במקום נגיש כדי להקל עליך כניסות עתידיות לחשבונך.",
    16 => 'פרטי חשבונך: ',
    17 => 'החשבון לא קיים',
    18 => 'כתובת האימייל שהוקלד לא תקני!',
    19 => 'שם המשתמש או הסיסמא שהוקלדו תפוסים!',
    20 => 'כתובת האימייל שהוקלד לא תקני!',
    21 => 'שגיאה!',
    22 => "רישום ב{$_CONF['site_name']}!",
    23 => "יצירת חשבון באתר {$_CONF['site_name']}, תאפשר לך ליהנות ממגוון אפשרויות ושירותים מתקדמים. למי שלא יהיה חשבון יוכל לפרסם הודעות  כמשתמש אנונימי בלבד וללא יכולת קבלת תגובות למייל או שימוש שפונקציות מתקדמות. לידיעתך, כתובת הדואל שתימסר באתר <b>לא</b> תתפרסם או תהיה גלויה באתר.",
    24 => 'סיסמתך תשלח לכתובת האימייל שהכנסת.',
    25 => 'האם שחכת את הסיסמה?',
    26 => 'הכנס את שם המשתמש שלך ולחץ על <b> שלח סיסמה חדשה לאימייל </b> וסיסמה חדשה תישלח לאימייל שרשום במערכת.',
    27 => 'הרשם/מי עכשיו!',
    28 => 'שלח סיסמה חדשה לאימייל',
    29 => 'התנתק/י מ',
    30 => 'התחבר מה',
    31 => 'הפונקציה שבחרת לעשות דורשת התחברות לאתר על-ידי הכנסת שם משתמש וסיסמה',
    32 => 'תוספת טקסט להודעות',
    33 => 'לא להציג בפומבי',
    34 => 'זה שמך האמתי',
    35 => 'הכנס/י סיסמה חדשה (הסיסמה הישנה תשתנה לסיסמה זו)',
    36 => 'לא לשכוח להכניס http://',
    37 => 'אשר/י את תגובתך',
    38 => 'הכל באחריותך, כולם יכולים לקרא זאת!',
    39 => 'מפתח ה PGP הפומבי שלך',
    40 => 'בטל הצגת איקון המדור',
    41 => 'Willing to Moderate',
    42 => 'תצורת הצגת התאריך',
    43 => 'מקסימום הודעות לדף',
    44 => 'בטל הצגת קוביות מידע',
    45 => 'מאפייני תצוגה של',
    46 => 'Excluded Items for',
    47 => 'News box Configuration for',
    48 => 'הודאות/מאמרים',
    49 => 'לא יוצג האייקון המופיע לצד ההודעה',
    50 => 'בטל/י סימון אם אנך מעוניין בפונקציה זו',
    51 => 'יופיעו רק הודעות ללא הקוביות בצדדים',
    52 => 'ברירת המחדל היא 10',
    53 => 'Receive the days stories every night',
    54 => 'Check the boxes for the topics and authors you don\'t want to see.',
    55 => 'If you leave these all unchecked, it means you want the default selection of boxes. If you start selecting boxes, remember to set all of them that you want because the default selection will be ignored. Default entries are displayed in bold.',
    56 => 'כותבים',
    57 => 'תצורת התצוגה',
    58 => 'סדר ההודעות/מאמרים',
    59 => 'הגבלת תגובות',
    60 => 'איך את/ה רוצה שהתגובות יוצגו?',
    61 => 'קודם הודעות חדשות או ישנות?',
    62 => 'ברירת המחדל היא 100',
    63 => "הסיסמה נשלחה אליך באמצעות המייל ואתה אמור לקבל אותה בכל רגע. אנא עקוב אחר ההוראות שבמייל. ברכות על הצתרפותך ל\n{$_CONF['site_name']}",
    64 => 'מאפייני תגובה של',
    65 => 'נסה/י להכנס שוב',
    66 => "You may have mistyped your login credentials.  Please try logging in again below. Are you a <a href=\"{$_CONF['site_url']}/users.php?mode=new\">new user</a>?",
    67 => 'חברים חדשים מאז',
    68 => 'שהמערכת תזכור אותי ל',
    69 => 'לכמה זמן את/ה רוצה שהמערכת תזכור אותך לאחר שתכנס/י לאתר?',
    70 => "בחר/י את מראה האתר ואופן תצורת התוכן ל{$_CONF['site_name']}",
    71 => "אחת מהאפשרויות של אתר {$_CONF['site_name']} היא להתאים את תוכן האתר לטעמך האישי, הן התוכן והן במראה.על מנת להינות מיתרונות אלו, עליך <a href=\"{$_CONF['site_url']}/users.php?mode=new\">להירשם</a> with {$_CONF['site_name']}. אם אתה כבר רשום באתר אז תכניס/י שם משתמש וסיסמה והתחל להנות מהיותך רשום/ה",
    72 => 'מראה האתר',
    73 => 'שפה',
    74 => 'שנה את מראה האתר!',
    75 => 'קבלת הודעות/מאמרים באימייל',
    76 => 'בחירה באחת מהאפשרויות הרשומות מטה תאפשר לך לקבל, בסוף כל יום, את כל ההודעות החדשות שייתווספו להודעה או מאמר זה. מומלץ לבחור רק בנושאים המעניינים אותך ביכדי להמנע מקבלת הודעות רבות מדי באימייל',
    77 => 'תמונה',
    78 => 'הוסף תמונה של עצמך',
    79 => 'לחץ/י כאן בכדי למחוק את התמונה',
    80 => 'התחבר',
    81 => 'שלח דואל',
    82 => 'עשרת ההודעות האחרונות של ',
    83 => 'הצג סטטיסטיקה למשתמש ',
    84 => 'סהכ הודעות:',
    85 => 'סהכ  תגובות:',
    86 => 'מצא הודעות שנכתבו על-ידי ',
    87 => 'שם המשתמש שלך הוא ',
    88 => "Someone (possibly you) has requested a new password for your account \"%s\" on {$_CONF['site_name']}, <{$_CONF['site_url']}>.\n\nIf you really want this action to be taken, please click on the following link:\n\n",
    89 => "If you do not want this action to be taken, simply ignore this message and the request will be disregarded (your password will remain unchanged).\n\n",
    90 => 'הכנס את סיסמתך החדשה בדף זה. לידיעתך סיסמתך הישנה תישאר בתוקף עד שתלחץ על אישור בדף זה.',
    91 => 'שנה סיסמה',
    92 => 'הכנס סיסמה חדשה ',
    93 => 'הבקשה האחרונה שלך לקבלת סיסמה חדשה הייתה לפני%d  שניות. מסיבות אבטחה דרוש להמתין לפחות%d  שניות.',
    94 => 'מחק את חשבון של  מהמערכת',
    95 => 'Click the "delete account" button below to remove your account from our database. Please note that any stories and comments you posted under this account will <strong>not</strong> be deleted but show up as being posted by "Anonymous".',
    96 => 'מחק חשבון זה',
    97 => 'Confirm Account Deletion',
    98 => 'Are you sure you want to delete your account? By doing so, you will not be able to log into this site again (unless you create a new account). If you are sure, click "delete account" again on the form below.',
    99 => 'דרישות הפרטיות של',
    100 => 'קבלת הודעות מהאדמיניסטראטור',
    101 => 'אשר קבלת הודעות במייל ממנהל האתר ',
    102 => 'קבלת הודעות ממשתמשים',
    103 => 'אישר קבלת הודעות ממשתמשים באתר',
    104 => 'הצג מי נמצא באתר',
    105 => 'מציג את כל מי שנמצא באתר',
    106 => 'Location',
    107 => 'Shown in your public profile'
);

###############################################################################
# index.php

$LANG05 = array(
    1 => 'אין הודעות/כתבות חדשות להצגה',
    2 => 'There are no news stories to display.  There may be no news for this topic or your user preferences may be too restrictive.',
    3 => 'עבודר נושא %s ',
    4 => 'הודעות/כתבות שנכתבו היום',
    5 => 'הבא',
    6 => 'הקודם',
    7 => 'First',
    8 => 'Last'
);

###############################################################################
# links.php

$LANG06 = array(
    1 => 'פרטים',
    2 => 'אין פרטים להצגה',
    3 => 'הוסף קישור'
);

###############################################################################
# pollbooth.php

$LANG07 = array(
    1 => 'הצבעתך נרשמה',
    2 => 'הצבעתך התווספה לסקר',
    3 => 'הצבע',
    4 => 'סקרים במערכת',
    5 => 'הצביעו',
    6 => 'צפה בסקרים נוספים'
);

###############################################################################
# profiles.php

$LANG08 = array(
    1 => 'הרעה שגיאה במשלוח ההודעה, אנא נסה/י שוב',
    2 => 'ההודעה נשלחה בהצלחה',
    3 => 'וודא שהמייל לקבלת תגובה יהיה נכון',
    4 => 'אנא מלא את השדות הבאים',
    5 => 'שגיאה, אין משתמש בשם שבחרת',
    6 => 'ההודעה לא נשלחה בהצלחה עקב שגיאה.',
    7 => 'פרופיל המשתמש ל',
    8 => 'שם השולח',
    9 => 'אתר הביית',
    10 => 'שלח הודעה ל:',
    11 => 'שמך',
    12 => 'מייל לקבלת תגובה',
    13 => 'נושא',
    14 => 'הודעה:',
    15 => 'HTML לא יתורגם',
    16 => 'שלח',
    17 => 'שלח את ההודעה/מאמר לחבר',
    18 => 'שם הנמען',
    19 => 'כתובת המייל של הנמען',
    20 => 'שם השולח',
    21 => 'כתובת המייל של השולח',
    22 => 'חובה למלא את כל השדות',
    23 => "This email was sent to you by %s at %s because they thought you might be interested in this article from {$_CONF['site_url']}.  This is not SPAM and the email addresses involved in this transaction were not saved to a list or stored for later use.",
    24 => 'Comment on this story at',
    25 => 'You must be logged in to user this feature.  By having you log in, it helps us prevent misuse of the system',
    26 => 'חובה למלא את <b>כל</b>  השדות אחרת ההודעה <b>לא</b> תישלח.',
    27 => 'כתוב הודעה קצרה',
    28 => '%s wrote: ',
    29 => "This is the daily digest from {$_CONF['site_name']} for ",
    30 => ' Daily Newsletter for ',
    31 => 'כותרת',
    32 => 'תאריך',
    33 => 'ההודעה/מאמר המלא נמצא בכתובת:',
    34 => 'סוף ההודעה',
    35 => 'Sorry, this user prefers not to receive any emails.'
);

###############################################################################
# search.php

$LANG09 = array(
    1 => 'חיפוש מתקדם',
    2 => 'מילות מפתח',
    3 => 'כותרת',
    4 => 'הכל',
    5 => 'סוג',
    6 => 'מאמר/הודעה',
    7 => 'תגובות',
    8 => 'כותבים',
    9 => 'הכל',
    10 => 'חיפוש',
    11 => 'תוצאות החיפוש',
    12 => 'תואמים',
    13 => 'תוצאות החיפוש: לא נמצאו מחרוזות תואמות',
    14 => 'לא נמצאו התאמות לחיפושך',
    15 => 'אנא נסה/י שוב',
    16 => 'כותרת',
    17 => 'תאריך',
    18 => 'נכתב על-ידי',
    19 => "חפש בכל מאגר המידע של {$_CONF['site_name']} כולל בהודעות חדשות",
    20 => 'תאריך',
    21 => 'דואל',
    22 => '(Date Format MM-DD-YYYY)',
    23 => 'תוצאות',
    24 => 'נמצאו',
    25 => 'מתאימים ל',
    26 => 'פריטים',
    27 => 'שניות',
    28 => ' לא נמצאו מאמרים/הודעות או תגובות המתאימים לחיפוש שלך',
    29 => 'תוצאות החיפוש',
    30 => 'לא נמצאו קישורים תואמים',
    31 => 'This plug-in returned no matches',
    32 => 'אירוע',
    33 => 'URL',
    34 => 'מיקום',
    35 => 'יום שלם',
    36 => 'לא נמצאו אירועים המתאימים לחיפושך',
    37 => 'האירועים שנמצאו הם',
    38 => 'הקישורים שנמצאו הם',
    39 => 'קישורים',
    40 => 'אירועים',
    41 => 'חובה להכניס לפחות 3 תווים.',
    42 => 'Please use a date formatted as YYYY-MM-DD (year-month-day).',
    43 => 'בדיוק כפי שהוקלד (חייבת להיות התאמה מדויקת של המחרוזת כדי שתהיה תוצאה)',
    44 => 'כל המילים יחד (כל המילים חייבות להופיע אבל לא בהכרח בסדר כתיבתם)',
    45 => 'כל אחת מהמילים (יהיו תוצאות גם אם רק מילה אחת תופיע)',
    46 => 'הבא',
    47 => 'הקודם',
    48 => 'הכותב',
    49 => 'תאריך',
    50 => 'כניסות',
    51 => 'קישור',
    52 => 'מיקום',
    53 => 'Story Results',
    54 => 'Comment Results',
    55 => 'the phrase',
    56 => 'סיום',
    57 => 'או'
);

###############################################################################
# stats.php

$LANG10 = array(
    1 => 'סיכום סטטיסטי לאתר',
    2 => 'כניסות למערכת',
    3 => 'Stories(Comments) in the System',
    4 => 'Polls(Answers) in the System',
    5 => 'Links(Clicks) in the System',
    6 => 'Events in the System',
    7 => 'עשרת ההודעות הנצפות ביותר',
    8 => 'כותרת ההודעה:',
    9 => 'Views',
    10 => 'It appears that there are no stories on this site or no one has ever viewed them.',
    11 => 'Top Ten Commented Stories',
    12 => 'Comments',
    13 => 'It appears that there are no stories on this site or no one has ever posted a comment on them.',
    14 => 'עשרת הסקרים הנצפים ביותר:',
    15 => 'Poll Question',
    16 => 'הצבעות',
    17 => 'It appears that there are no polls on this site or no one has ever voted.',
    18 => 'עשרת הלינקים הנצפים ביותר:',
    19 => 'לינקים',
    20 => 'כניסות',
    21 => 'It appears that there are no links on this site or no one has ever clicked on one.',
    22 => 'Top Ten Emailed Stories',
    23 => 'אימיילים',
    24 => 'It appears that no one has emaild a story on this site'
);

###############################################################################
# article.php

$LANG11 = array(
    1 => 'לינקים בהודעה זו',
    2 => 'שלח את ההודעה/מאמר לחבר',
    3 => 'גרסה להדפסה',
    4 => 'אפשרויות להודעה זו:',
    5 => 'PDF Story Format'
);

###############################################################################
# submit.php

$LANG12 = array(
    1 => 'על-מנת לבצע %s עליך להיות משתמש רשום במערכת',
    2 => 'כניסה',
    3 => 'משתמש חדש',
    4 => 'אשר אירוע',
    5 => 'אשר קישור',
    6 => 'אשר מאמר',
    7 => 'פעולה זו זמינה למשתמשים רשומים בלבד!',
    8 => 'אישור',
    9 => 'When submitting information for use on this site we ask that you follow the following suggestions...<ul><li>Fill in all the fields, they\'re required<li>Provide complete and accurate information<li>Double check those URLs</ul>',
    10 => 'כותרת',
    11 => 'קשור',
    12 => 'תאריך התחלה',
    13 => 'תאריך סיום',
    14 => 'מיקום',
    15 => 'פרטים',
    16 => 'אם יש פרטים נוספים, אנא הכנס/י אותם',
    17 => 'קטגוריה',
    18 => 'אחר',
    19 => 'קרא לפני הוספה',
    20 => 'חסרה קטגוריה!!',
    21 => 'כאשר בוחרים <b>אחר</b> חיבים להכניס שם של קטגוריה',
    22 => 'יש שדות ריקים שלא מולאו, עליך להשלים אותם ולאשר מחדש',
    23 => 'יש למלא את <b>כל</b> השדות בטופס זה!',
    24 => 'Submission Saved',
    25 => 'Your %s submission has been saved successfully.',
    26 => 'Speed Limit',
    27 => 'שם משתמש',
    28 => 'נושא',
    29 => 'מאמר',
    30 => 'הודעתך האחרונה הייתה לפני',
    31 => "נדרשים לפחות {$_CONF['speedlimit']}שניות בין הודעה אחת לשניה.",
    32 => 'תצוגה מקדימה',
    33 => 'תצוגה מקדימה של המאמר',
    34 => 'התנתקות',
    35 => 'לא ניתן להשתמש ב HTML',
    36 => 'Post Mode',
    37 => "Submitting an event to {$_CONF['site_name']} will put your event on the master calendar where users can optionally add your event to their personal calendar. This feature is <b>NOT</b> meant to store your personal events such as birthdays and anniversaries.<br><br>Once you submit your event it will be sent to our administrators and if approved, your event will appear on the master calendar.",
    38 => 'הוסף אירוע ל',
    39 => 'יומן ציבורי',
    40 => 'יומן פרטי',
    41 => 'שעת סיום',
    42 => 'שעת התחלה',
    43 => 'אירוע שנמשך יום שלם',
    44 => 'שורת כתובת 1',
    45 => 'שורת כתובת 2',
    46 => 'ישוב/עיר',
    47 => 'מדינה',
    48 => 'מיקוד',
    49 => 'סוג אירוע',
    50 => 'ערוך סוג אירוע',
    51 => 'מיקום',
    52 => 'מחק',
    53 => 'Create Account'
);

###############################################################################
# ADMIN PHRASES - These are file phrases used in admin scripts
###############################################################################

###############################################################################
# admin/auth.inc.php

$LANG20 = array(
    1 => 'נדרשים פרטי זיהוי משתמש',
    2 => 'פרטי משתמש אינם נכונים!',
    3 => 'חסרה סיסמא',
    4 => 'שם משתמש',
    5 => 'סיסמא',
    6 => 'All access to administrative portions of this web site are logged and reviewed.<br>This page is for the use of authorized personnel only.',
    7 => 'כניסה'
);

###############################################################################
# admin/block.php

$LANG21 = array(
    1 => 'Insufficient Admin Rights',
    2 => 'You do not have the necessary rights to edit this block.',
    3 => 'Block Editor',
    4 => 'There was a problem reading this feed (see error.log for details).',
    5 => 'Block Title',
    6 => 'Topic',
    7 => 'All',
    8 => 'Block Security Level',
    9 => 'Block Order',
    10 => 'סוג קוביה',
    11 => 'Portal Block',
    12 => 'Normal Block',
    13 => 'אפשרויות לקוביות המידע',
    14 => 'RDF URL',
    15 => 'Last RDF Update',
    16 => 'Normal Block Options',
    17 => 'תוכן הקוביה',
    18 => 'Please fill in the Block Title, Security Level and Content fields',
    19 => 'Block Manager',
    20 => 'כותרת',
    21 => 'Block SecLev',
    22 => 'סוג קוביה',
    23 => 'סדר הצגת בקוביות',
    24 => 'נושא',
    25 => 'To modify or delete a block, click on that block below.  To create a new block click on new block above.',
    26 => 'Layout Block',
    27 => 'PHP Block',
    28 => 'PHP Block Options',
    29 => 'Block Function',
    30 => 'If you would like to have one of your blocks use PHP code, enter the name of the function above.  Your function name must start with the prefix "phpblock_" (e.g. phpblock_getweather).  If it does not have this prefix, your function will NOT be called.  We do this to keep people who may have hacked your Geeklog installation from putting arbitrary function calls that may be harmful to your system.  Be sure not to put empty parenthisis "()" after your function name.  Finally, it is recommended that you put all your PHP Block code in /path/to/geeklog/system/lib-custom.php.  That will allow the code to stay with you even when you upgrade to a newer version of Geeklog.',
    31 => 'Error in PHP Block.  Function, %s, does not exist.',
    32 => 'Error Missing Field(s)',
    33 => 'You must enter the URL to the .rdf file for portal blocks',
    34 => 'You must enter the title and the function for PHP blocks',
    35 => 'You must enter the title and the content for normal blocks',
    36 => 'You must enter the content for layout blocks',
    37 => 'Bad PHP block function name',
    38 => 'Functions for PHP Blocks must have the prefix \'phpblock_\' (e.g. phpblock_getweather).  The \'phpblock_\' prefix is required for security reasons to prevent the execution of arbitrary code.',
    39 => 'צד',
    40 => 'ימין',
    41 => 'שמאל',
    42 => 'You must enter the blockorder and security level for Geeklog default blocks',
    43 => 'דף בית בלבד',
    44 => 'אישור כניסה נדחה!',
    45 => "You are trying to access a block that you don't have rights to.  This attempt has been logged. Please <a href=\"{$_CONF['site_url']}/admin/block.php\">go back to the block administration screen</a>.",
    46 => 'קוביה חדשה',
    47 => 'Admin Home',
    48 => 'שם קוביה',
    49 => 'השם חייב להיות ייחודי ובלי רווחים',
    50 => 'כתובת URL של קבצי עזרה',
    51 => '(חובה לכלול גם<b>  http://</b>(',
    52 => 'אם משאירים ריק צלמית עזרה לא תופיע!',
    53 => 'אפשר',
    54 => 'שמור',
    55 => 'ביטול',
    56 => 'מחיקה',
    57 => 'Move Block Down',
    58 => 'Move Block Up',
    59 => 'Move block to the right side',
    60 => 'Move block to the left side'
);

###############################################################################
# admin/event.php

$LANG22 = array(
    1 => 'עריכת אירוע',
    2 => 'Error',
    3 => 'כותרת אירוע',
    4 => 'כתובת אינטרנטית של האירוע',
    5 => 'תאריך התחלת האירוע',
    6 => 'תאריך סיום האירוע',
    7 => 'מיקום האירוע',
    8 => 'תיאור האירוע',
    9 => '(חובה לכלול גם<b>  http://</b>(',
    10 => 'חיבים למלא את השדות של תאריך האירוע/שעות האירוע תיאור האירוע ומיקומו ',
    11 => 'מרכז האירוע',
    12 => 'To modify or delete a event, click on that event below.  To create a new event click on new event above.',
    13 => 'כותרת האירוע',
    14 => 'מתחיל בתאריך',
    15 => 'מסתיים בתאריך',
    16 => 'אין הרשאות גישה למידע זה',
    17 => "You are trying to access an event that you don't have rights to.  This attempt has been logged. Please <a href=\"{$_CONF['site_url']}/admin/event.php\">go back to the event administration screen</a>.",
    18 => 'אירוע חדש',
    19 => 'אתר אדמיניסטרטור',
    20 => 'שמירה',
    21 => 'ביטול',
    22 => 'מחיקה',
    23 => 'Bad start date.',
    24 => 'Bad end date.',
    25 => 'End date is before start date.'
);

###############################################################################
# admin/link.php

$LANG23 = array(
    1 => 'עריכת לינק:',
    2 => '',
    3 => 'כותרת',
    4 => 'כתובת הURL של הלינק',
    5 => 'קטגוריה',
    6 => 'חובה לכלול גם<b>  http://</b>',
    7 => 'בחר קטגוריה',
    8 => 'כניסות ללינק',
    9 => 'הכנס כמה מילים על הלינק',
    10 => 'שכחת למלא שדה אחד או יותר!  הינך חייב למלא את<b> כל השדות</b> בכדי שהמערכת תקלוט את הלינק החדש. השדות האפשריים הם: <b>כותרת</b>,  <b>כתובת URL</b>,  <b>וכמה מילים על הלינק</b>, כמו-כן, בדוק אם קיימת קטגוריה שתחתיה אפשר לשים את הלינק החדש ורק אם אין, צור/י לינק חדש, תודה.',
    11 => 'מנהל הלינק',
    12 => 'To modify or delete a link, click on that link below.  To create a new link click new link above.',
    13 => 'שם הלינק',
    14 => 'קטגוריה',
    15 => 'קישור URL',
    16 => 'אין לך הרשאות כניסה',
    17 => "You are trying to access a link that you don't have rights to.  This attempt has been logged. Please <a href=\"{$_CONF['site_admin_url']}/link.php\">go back to the link administration screen</a>.",
    18 => 'הוסף קישור',
    19 => 'Admin Home',
    20 => 'לקטגוריה חדשה, הכנס כאן',
    21 => 'שמור',
    22 => 'ביטול',
    23 => 'מחק'
);

###############################################################################
# admin/story.php

$LANG24 = array(
    1 => 'מאמר קודם',
    2 => 'למאמר הבא',
    3 => 'מצב',
    4 => 'מצב כתיבה',
    5 => 'דף עריכת הודעה/מאמר',
    6 => 'There are no stories in the system',
    7 => 'נכתב על-ידי',
    8 => 'שמור',
    9 => 'צפייה מוקדמת',
    10 => 'ביטול',
    11 => 'מחק',
    12 => '12',
    13 => 'כותרת',
    14 => 'נושא',
    15 => 'תאריך',
    16 => 'תמצית המאמר',
    17 => 'גוף המאמר',
    18 => 'כניסות',
    19 => 'תגובות',
    20 => '20',
    21 => '21',
    22 => 'רשימת מאמרים',
    23 => 'To modify or delete a story, click on that story\'s number below. To view a story, click on the title of the story you wish to view. To create a new story click on new story above.',
    24 => '24',
    25 => '25',
    26 => 'תצוגה מקדימה של המאמר',
    27 => '27',
    28 => '28',
    29 => '29',
    30 => '30',
    31 => 'Please fill in the Author, Title and Intro Text fields',
    32 => 'Featured',
    33 => 'There can only be one featured story',
    34 => 'טיוטה',
    35 => 'כן',
    36 => 'לא',
    37 => 'תגובה נוספת על-ידי',
    38 => 'עוד מ',
    39 => 'כתובות דואל',
    40 => 'Access Denied',
    41 => "You are trying to access a story that you don't have rights to.  This attempt has been logged.  You may view the article in read-only below. Please <a href=\"{$_CONF['site_url']}/admin/story.php\">go back to the story administration screen</a> when you are done.",
    42 => "You are trying to access a story that you don't have rights to.  This attempt has been logged.  Please <a href=\"{$_CONF['site_url']}/admin/story.php\">go back to the story administration screen</a>.",
    43 => 'מאמר חדש',
    44 => 'Admin Home',
    45 => 'הרשאות',
    46 => '<b>NOTE:</b> if you modify this date to be in the future, this article will not be published until that date.  That also means the story will not be included in your RDF headline feed and it will be ignored by the search and statistics pages.',
    47 => 'תמונות',
    48 => 'תמונה',
    49 => 'שמאל',
    50 => 'ימין',
    51 => 'To add one of the images you are attaching to this article you need to insert specially formated text.  The specially formated text is [imageX], [imageX_right] or [imageX_left] where X is the number of the image you have attached.  NOTE: You must use the images you attach.  If you do not you will be unable to save your story.<BR><P><B>PREVIEWING</B>: Previewing a story with images attached is best done by saving the article as a draft INSTEAD OF hitting the preview button.  Use the preview button only when images are not attached.',
    52 => 'מחיקה',
    53 => 'was not used.  You must include this image in the intro or body before you can save your changes',
    54 => 'Attached Images Not Used',
    55 => 'The following errors occured while trying to save your story.  Please correct these errors before saving',
    56 => 'הראה צלמית כותרת',
    57 => 'View unscaled image',
    58 => 'Story Management',
    59 => 'Option',
    60 => 'Enabled',
    61 => 'Auto Archive',
    62 => 'Auto Delete'
);

###############################################################################
# admin/poll.php

$LANG25 = array(
    1 => 'מצב',
    2 => '2  LANG25',
    3 => 'תאריך יצירת הסקר',
    4 => 'הסקר %s נשמר',
    5 => 'דף יצירת סקר',
    6 => 'שם/מקט סקר',
    7 => 'לא לעשות רווחים בין המילים!',
    8 => 'הצג סקר באתר',
    9 => 'שאלת הסקר',
    10 => 'תשובות אפשריות לסקר',
    11 => 'There was an error getting poll answer data about the poll %s',
    12 => 'There was an error getting poll question data about the poll %s',
    13 => 'יצירת סקר חדש',
    14 => 'save',
    15 => 'cancel',
    16 => 'delete',
    17 => 'Please enter a Poll ID',
    18 => 'רשימת סקרים',
    19 => 'כדי לשנות או למחוק סקר פשוט סמן אותו. כדי ליצור סקר חדש לחץ על<b> צור סקר</b>',
    20 => 'משתתפים',
    21 => 'אין גישה!',
    22 => "You are trying to access a poll that you don't have rights to.  This attempt has been logged. Please <a href=\"{$_CONF['site_url']}/admin/poll.php\">go back to the poll administration screen</a>.",
    23 => 'יצירת סקר חדש',
    24 => 'Admin Home',
    25 => 'כן',
    26 => 'לא'
);

###############################################################################
# admin/topic.php

$LANG27 = array(
    1 => 'עורך ההודעה/מאמר',
    2 => 'מקט ההודעה/מאמר',
    3 => 'כותרת ההודעה/מאמר',
    4 => 'תמונות ההודעה/מאמר',
    5 => 'לא לעשות רווחים בין המילים!',
    6 => 'Deleting a topic deletes all stories and blocks associated with it',
    7 => 'Please fill in the Topic ID and Topic Name fields',
    8 => 'Topic Manager',
    9 => 'To modify or delete a topic, click on that topic.  To create a new topic click the new topic button to the left. You will find your access level for each topic in parenthesis',
    10 => 'סדר מיון',
    11 => 'Stories/Page',
    12 => 'Access Denied',
    13 => "You are trying to access a topic that you don't have rights to.  This attempt has been logged. Please <a href=\"{$_CONF['site_url']}/admin/topic.php\">go back to the topic administration screen</a>.",
    14 => 'שיטת מיון',
    15 => 'לפי הא-ב',
    16 => 'ברירת המחדל היא',
    17 => 'New Topic',
    18 => 'Admin Home',
    19 => 'save',
    20 => 'cancel',
    21 => 'delete',
    22 => 'Default',
    23 => 'make this the default topic for new story submissions',
    24 => '(*)',
    25 => 'Archive Topic',
    26 => 'make this the default topic for archived stories. Only one topic allowed.'
);

###############################################################################
# admin/user.php

$LANG28 = array(
    1 => 'עריכת מאפיני משתמש',
    2 => 'מספר זיהוי משתמש',
    3 => 'שם משתמש',
    4 => 'שם מלא',
    5 => 'סיסמא',
    6 => 'רמת אבטחה',
    7 => 'כתובת דואל',
    8 => 'אתר בית',
    9 => 'אסור לעשות רווחים בשדה זה!',
    10 => 'אנא מלא את השדות הבאים: שם משתמש, שם מלא, רמת אבטחה וכתובת דואל',
    11 => 'מרכז בקרה למשתמש',
    12 => 'To modify or delete a user, click on that user below.  To create a new user click the new user button to the left. You can do simple searches by entering parts of a username,email address or fullname (e.g.*son* or *.edu) in the form below.',
    13 => 'SecLev',
    14 => 'Reg. Date',
    15 => 'משתמש חדש',
    16 => 'Admin Home',
    17 => 'שנֶה סיסמה',
    18 => 'ביטול',
    19 => 'מחק',
    20 => 'שמור',
    21 => 'שם המשתמש שהכנסת כבר קיים במערכת',
    22 => 'שגיאה!',
    23 => 'Batch Add',
    24 => 'Batch Import of Users',
    25 => 'You can import a batch of users into Geeklog.  The import file must a tab-delimited text file and must have the fields in the following order: full name, username, email address.  Each user you import will be emailed with a random password.  You must have one user entered per line.  Failure to follow these instructions will cause problems that may require manual work so double check your entries!',
    26 => 'חיפוש',
    27 => 'סנן תוצאות',
    28 => 'סמן כאן למחיקת התמונה',
    29 => 'Path',
    30 => 'Import',
    31 => 'New Users',
    32 => 'Done processing. Imported %d and encountered %d failures',
    33 => 'submit',
    34 => 'Error: You must specify a file to upload.',
    35 => 'Last Login',
    36 => '(never)'
);

###############################################################################
# admin/moderation.php

$LANG29 = array(
    1 => 'אישור',
    2 => 'מחק',
    3 => 'עריכה',
    4 => 'פרופיל',
    10 => 'כותרת',
    11 => 'תאריך התחלה',
    12 => 'URL',
    13 => 'קטגוריה',
    14 => 'תאריך',
    15 => 'נושא',
    16 => 'User name',
    17 => 'Full name',
    18 => 'Email',
    34 => 'Command and Control',
    35 => 'הוספת מאמר',
    36 => 'אשר קישור',
    37 => 'אשר אירוע',
    38 => 'אישור',
    39 => 'There are no submissions to moderate at this time',
    40 => 'User Submissions'
);

###############################################################################
# calendar.php

$LANG30 = array(
    1 => 'א',
    2 => 'ב',
    3 => 'ג',
    4 => 'ד',
    5 => 'ה',
    6 => 'ו',
    7 => 'שבת',
    8 => 'הוסף אירוע',
    9 => 'אירוע לינוקס',
    10 => 'יתקיים',
    11 => 'יומן ראשי',
    12 => 'יומן אישי',
    13 => 'ינואר',
    14 => 'פברואר',
    15 => 'מרץ',
    16 => 'אפריל',
    17 => 'מאי',
    18 => 'יוני',
    19 => 'יולי',
    20 => 'אוגוסט',
    21 => 'ספטמבר',
    22 => 'אוקטובר',
    23 => 'נובמבר',
    24 => 'דצמבר',
    25 => 'חזרה ל',
    26 => 'יום שלם',
    27 => 'חודש',
    28 => 'יומן אישי של',
    29 => 'יומן',
    30 => 'מחק אירוע',
    31 => 'הוסף',
    32 => 'אירוע',
    33 => 'מחק',
    34 => 'שעה',
    35 => 'הוספה מהירה',
    36 => 'אישור',
    37 => 'מצטערים, האפשרות ליומן אישי לא קיימת באתר זה.',
    38 => 'עריכת יומן אישי',
    39 => 'יום',
    40 => 'שבוע',
    41 => 'Month'
);

###############################################################################
# admin/mail.php

$LANG31 = array(
    1 => "{$_CONF['site_name']} Mail Utility",
    2 => 'מ',
    3 => 'השב ל',
    4 => 'נושא',
    5 => 'גוף ההודעה',
    6 => 'שלך ל',
    7 => 'כל המשתמשים',
    8 => 'אדמיניסטרטור',
    9 => 'אפשרויות',
    10 => 'HTML',
    11 => 'הודעה דחופה',
    12 => 'שלח',
    13 => 'מחק והתחל מחדש',
    14 => 'התעלם מהגדרות משתמש',
    15 => 'ארעה שגיעה במשלוח ההודעה ל',
    16 => 'הודעה נשלחה בהצלחה ל',
    17 => "<a href={$_CONF['site_url']}/admin/mail.php>Send another message</a>",
    18 => 'כתובת דואל',
    19 => 'NOTE: if you wish to send a message to all site members, select the Logged-in Users group from the drop down.',
    20 => "Successfully sent <successcount> messages and unsuccessfully sent <failcount> messages.  If you need them, the details of each message attempts is below.  Otherwise you can <a href=\"{$_CONF['site_url']}/admin/mail.php\">Send another message</a> or you can <a href=\"{$_CONF['site_url']}/admin/moderation.php\">go back to the administration page</a>.",
    21 => 'כישלון',
    22 => 'בהצלחה',
    23 => 'אין כישלונות',
    24 => 'אין הצלחות',
    25 => '-- בחר קבוצה--',
    26 => 'Please fill in all the fields on the form and select a group of users from the drop down.'
);

###############################################################################
# admin/plugins.php

$LANG32 = array(
    1 => 'Installing plugins could possibly cause damage to your Geeklog installation and, possibly, to your system.  It is important that you only install plugins downloaded from the <a href="http://www.geeklog.net" target="_blank">Geeklog Homepage</a> as we thoroughly test all plugins submitted to our site on a variety of operating systems.  It is important that you understand that the plugin installation process will require the execution of a few filesystem commands which could lead to security problems particularly if you use plugins from third party sites.  Even with this warning you are getting, we do not gaurantee the success of any installation nor are we liable for damage caused by installing a Geeklog plugin.  In other words, install at your own risk.  For the wary, directions on how to manually install a plugin is included with each plugin package.',
    2 => 'Plug-in Installation Disclaimer',
    3 => 'Plug-in Installation Form',
    4 => 'Plug-in File',
    5 => 'Plug-in List',
    6 => 'Warning: Plug-in Already Installed!',
    7 => 'The plug-in you are trying to install already exists.  Please delete the plugin before re-installing it',
    8 => 'Plugin Compatibility Check Failed',
    9 => 'This plugin requires a newer version of Geeklog. Either upgrade your copy of <a href="http://www.geeklog.net">Geeklog</a> or get a newer version of the plug-in.',
    10 => '<br><b>There are no plugins currently installed.</b><br><br>',
    11 => 'To modify or delete a plug-in, click on that plug-in\'s number below. To learn more about a plug-in, click the plug-in name and you will be directed to that plug-in\'s website. To install or upgrade a plug-in please consult it\'s documentation.',
    12 => 'no plugin name provided to plugineditor()',
    13 => 'Plugin Editor',
    14 => 'New Plug-in',
    15 => 'Admin Home',
    16 => 'Plug-in Name',
    17 => 'Plug-in Version',
    18 => 'גרסה',
    19 => 'אפשר',
    20 => 'כן',
    21 => 'לא',
    22 => 'התקן',
    23 => 'שמור',
    24 => 'ביטול',
    25 => 'מחק',
    26 => 'Plug-in Name',
    27 => 'Plug-in Homepage',
    28 => 'Plug-in Version',
    29 => 'גרסה',
    30 => 'Delete Plug-in?',
    31 => 'Are you sure you want to delete this plug-in?  By doing so you will remove all the data and data structures that this plug-in uses.  If you are sure, click delete again on the form below.',
    32 => '<p><b>Error AutoLink tag not correct format</b></p>',
    33 => 'Code Version',
    34 => 'Update'
);

###############################################################################
# admin/syndication.php

$LANG33 = array(
    1 => 'create feed',
    2 => 'save',
    3 => 'delete',
    4 => 'cancel',
    10 => 'Content Syndication',
    11 => 'New Feed',
    12 => 'Admin Home',
    13 => 'To modify or delete a feed, click on the feed\'s title below. To create a new feed, click on New Feed above.',
    14 => 'Title',
    15 => 'Type',
    16 => 'Filename',
    17 => 'Format',
    18 => 'last updated',
    19 => 'Enabled',
    20 => 'Yes',
    21 => 'No',
    22 => '<i>(no feeds)</i>',
    23 => 'all Stories',
    24 => 'Feed Editor',
    25 => 'Feed Title',
    26 => 'Limit',
    27 => 'Length of entries',
    28 => '(0 = no text, 1 = full text, other = limit to that number of chars.)',
    29 => 'Description',
    30 => 'Last Update',
    31 => 'Character Set',
    32 => 'Language',
    33 => 'Contents',
    34 => 'Entries',
    35 => 'Hours',
    36 => 'Select type of feed',
    37 => 'You have at least one plugin installed that supports content syndication. Below you will need to select whether you want to create a Geeklog feed or a feed from one of the plugins.',
    38 => 'Error: Missing Fields',
    39 => 'Please fill in the Feed Title, Description, and Filename.',
    40 => 'Please enter a  number of entries or number of hours.',
    41 => 'Links',
    42 => 'Events'
);

###############################################################################
# confirmation and error messages

$MESSAGE = array(
    1 => "Your password has been emailed to you and should arrive momentarily. Please follow the directions in the message and we thank-you for using {$_CONF['site_name']}",
    2 => "Thank-you for submitting your story to {$_CONF['site_name']}.  It has been submitted to our staff for approval. If approved, your story will be available for others to read on our site.",
    3 => "Thank-you for submitting a link to {$_CONF['site_name']}.  It has been submitted to our staff for approval.  If approved, your link will be seen in the <a href={$_CONF['site_url']}/links.php>links</a> section.",
    4 => "Thank-you for submitting an event to {$_CONF['site_name']}.  It has been submitted to our staff for approval.  If approved, your event will be seen in our <a href={$_CONF['site_url']}/calendar.php>calendar</a> section.",
    5 => 'Your account information has been successfully saved.',
    6 => 'Your display preferences have been successfully saved.',
    7 => 'Your comment preferences have been successfully saved.',
    8 => 'יצאת מהמערכת בהצלחה.',
    9 => 'ההודעה שלך נשמרה בהצלחה',
    10 => 'The story has been successfully deleted.',
    11 => 'Your block has been successfully saved.',
    12 => 'The block has been successfully deleted.',
    13 => 'Your topic has been successfully saved.',
    14 => 'The topic and all it\'s stories and blocks have been successfully deleted.',
    15 => 'Your link has been successfully saved.',
    16 => 'The link has been successfully deleted.',
    17 => 'Your event has been successfully saved.',
    18 => 'The event has been successfully deleted.',
    19 => 'Your poll has been successfully saved.',
    20 => 'The poll has been successfully deleted.',
    21 => 'The new user has been successfully saved.',
    22 => 'The user has been successfully deleted',
    23 => 'Error trying to add an event to your calendar. There was no event id passed.',
    24 => 'The event has been saved to your calendar',
    25 => 'Cannot open your personal calendar until you login',
    26 => 'Event was successfully removed from your personal calendar',
    27 => 'ההודעה נשלחה בהצלחה!',
    28 => 'The plug-in has been successfully saved',
    29 => 'Sorry, personal calendars are not enabled on this site',
    30 => 'Access Denied',
    31 => 'Sorry, you do not have access to the story administration page.  Please note that all attempts to access unauthorized features are logged',
    32 => 'Sorry, you do not have access to the topic administration page.  Please note that all attempts to access unauthorized features are logged',
    33 => 'Sorry, you do not have access to the block administration page.  Please note that all attempts to access unauthorized features are logged',
    34 => 'Sorry, you do not have access to the link administration page.  Please note that all attempts to access unauthorized features are logged',
    35 => 'Sorry, you do not have access to the event administration page.  Please note that all attempts to access unauthorized features are logged',
    36 => 'Sorry, you do not have access to the poll administration page.  Please note that all attempts to access unauthorized features are logged',
    37 => 'Sorry, you do not have access to the user administration page.  Please note that all attempts to access unauthorized features are logged',
    38 => 'Sorry, you do not have access to the plugin administration page.  Please note that all attempts to access unauthorized features are logged',
    39 => 'Sorry, you do not have access to the mail administration page.  Please note that all attempts to access unauthorized features are logged',
    40 => 'הודעת מערכת',
    41 => 'Sorry, you do not have access to the word replacement page.  Please note that all attempts to access unauthorized features are logged',
    42 => 'Your word has been successfully saved.',
    43 => 'The word has been successfully deleted.',
    44 => 'The plug-in was successfully installed!',
    45 => 'The plug-in was successfully deleted.',
    46 => 'Sorry, you do not have access to the database backup utility.  Please note that all attempts to access unauthorized features are logged',
    47 => 'This functionality only works under *nix.  If you are running *nix as your operating system then your cache has been successfully cleared. If you are on Windows, you will need to search for files name adodb_*.php and remove them manually.',
    48 => "Thank you for applying for a membership with {$_CONF['site_name']}. Our team will review your application. If approved, your password will be emailed to you at the email address you just entered.",
    49 => 'Your group has been successfully saved.',
    50 => 'The group has been successfully deleted.',
    51 => 'This username is already in use. Please choose another one.',
    52 => 'The email address provided does not appear to be a valid email address.',
    53 => 'Your new password has been accepted. Please use your new password below to log in now.',
    54 => 'Your request for a new password has expired. Please try again below.',
    55 => 'An email has been sent to you and should arrive momentarily. Please follow the directions in the message to set a new password for your account.',
    56 => 'The email address provided is already in use for another account.',
    57 => 'Your account has been successfully deleted.',
    58 => 'Your feed has been successfully saved.',
    59 => 'The feed has been successfully deleted.',
    60 => 'The plugin was successfully updated',
    61 => 'Plugin %s: Unknown message placeholder'
);

###############################################################################

$LANG_ACCESS = array(
    'access' => 'Access',
    'ownerroot' => 'Owner/Root',
    'group' => 'Group',
    'readonly' => 'Read-Only',
    'accessrights' => 'Access Rights',
    'owner' => 'Owner',
    'grantgrouplabel' => 'Grant Above Group Edit Rights',
    'permmsg' => 'NOTE: members is all logged in members of the site and anonymous is all users browsing the site that aren\'t logged in.',
    'securitygroups' => 'Security Groups',
    'editrootmsg' => "Even though you are a User Administrator, you can't edit a root user without first being a root user yourself.  You can edit all other users except root users. Please note that all attempts to illegally edit root users are logged.  Please go back to the <a href=\"{$_CONF['site_admin_url']}/user.php\">User Administration page</a>.",
    'securitygroupsmsg' => 'Select the checkboxes for the groups you want the user to belong to.',
    'groupeditor' => 'Group Editor',
    'description' => 'Description',
    'name' => 'Name',
    'rights' => 'Rights',
    'missingfields' => 'Missing Fields',
    'missingfieldsmsg' => 'You must supply the name and a description for a group',
    'groupmanager' => 'Group Manager',
    'newgroupmsg' => 'To modify or delete a group, click on that group below. To create a new group click new group above. Please note that core groups cannot be deleted because they are used in the system.',
    'groupname' => 'Group Name',
    'coregroup' => 'Core Group',
    'yes' => 'Yes',
    'no' => 'No',
    'corerightsdescr' => "This group is a core {$_CONF['site_name']} Group.  Therefore the rights for this group cannot be edited.  Below is a read-only list of the rights this group has access to.",
    'groupmsg' => 'Security Groups on this site are hierarchical.  By adding this group to any of the groups below you will giving this group the same rights that those groups have.  Where possible it is encouraged you use the groups below to give rights to a group.  If you need this group to have custom rights then you can select the rights to various site features in the section below called \'Rights\'.  To add this group to any of the ones below simply check the box next to the group(s) that you want.',
    'coregroupmsg' => "This group is a core {$_CONF['site_name']} Group.  Therefore the groups that this groups belongs to cannot be edited.  Below is a read-only list of the groups this group belongs to.",
    'rightsdescr' => 'A groups access to a certain right below can be given directly to the group OR to a different group that this group is a part of.  The ones you see below without a checkbox are the rights that have been given to this group because it belongs to another group with that right.  The rights with checkboxes below are rights that can be given directly to this group.',
    'lock' => 'נעולה',
    'members' => 'חברים רשומים באתר',
    'anonymous' => 'אורח/ת באתר',
    'permissions' => 'הרשאה',
    'permissionskey' => 'R = read, E = edit, edit rights assume read rights',
    'edit' => 'עריכה',
    'none' => 'אין',
    'accessdenied' => 'אין לך הרשאות כניסה!',
    'storydenialmsg' => "You do not have access to view this story.  This could be because you aren't a member of {$_CONF['site_name']}.  Please <a href=users.php?mode=new> become a member</a> of {$_CONF['site_name']} to receive full membership access!",
    'eventdenialmsg' => "You do not have access to view this event.  This could be because you aren't a member of {$_CONF['site_name']}.  Please <a href=users.php?mode=new> become a member</a> of {$_CONF['site_name']} to receive full membership access!",
    'nogroupsforcoregroup' => 'This group doesn\'t belong to any of the other groups',
    'grouphasnorights' => 'This group doesn\'t have access to any of the administrative features of this site',
    'newgroup' => 'New Group',
    'adminhome' => 'Admin Home',
    'save' => 'save',
    'cancel' => 'cancel',
    'delete' => 'delete',
    'canteditroot' => 'You have tried to edit the Root group but you are not in the Root group yourself therefore your access to this group is denied.  Please contact the system administrator if you feel this is an error',
    'listusers' => 'List Users',
    'listthem' => 'list',
    'usersingroup' => 'Users in group %s',
    'usergroupadmin' => 'User Group Administration',
    'add' => 'Add',
    'remove' => 'Remove',
    'availmembers' => 'Available Members',
    'groupmembers' => 'Group Members',
    'canteditgroup' => 'To edit this group, you have to be a member of the group. Please contact the system administrator if you feel this is an error.',
    'cantlistgroup' => 'To see the members of this group, you have to be a member yourself. Please contact the system administrator if you feel this is an error.'
);

###############################################################################
# admin/database.php

$LANG_DB_BACKUP = array(
    'last_ten_backups' => 'Last 10 Back-ups',
    'do_backup' => 'Do Backup',
    'backup_successful' => 'Database back up was successful.',
    'no_backups' => 'No backups in the system',
    'db_explanation' => 'To create a new backup of your Geeklog system, hit the button below',
    'not_found' => "Incorrect path or mysqldump utility not executable.<br>Check <strong>$_DB_mysqldump_path</strong> definition in config.php.<br>Variable currently defined as: <var>{$_DB_mysqldump_path}</var>",
    'zero_size' => 'Backup Failed: Filesize was 0 bytes',
    'path_not_found' => "{$_CONF['backup_path']} does not exist or is not a directory",
    'no_access' => "ERROR: Directory {$_CONF['backup_path']} is not accessible.",
    'backup_file' => 'Backup file',
    'size' => 'Size',
    'bytes' => 'Bytes',
    'total_number' => 'Total number of backups: %d'
);

###############################################################################

$LANG_BUTTONS = array(
    1 => 'דף הבית',
    2 => 'צור קשר',
    3 => 'כתיבת הודעה/מאמר',
    4 => 'קישורים',
    5 => 'סקרים',
    6 => 'יומן',
    7 => 'סטטיסטיקה',
    8 => 'התאמה אישית',
    9 => 'חיפוש',
    10 => 'חיפוש מתקדם'
);

###############################################################################
# 404.php

$LANG_404 = array(
    1 => '404 Error',
    2 => 'Gee, I\'ve looked everywhere but I can not find <b>%s</b>.',
    3 => "<p>We're sorry, but the file you have requested does not exist. Please feel free to check the <a href=\"{$_CONF['site_url']}\">main page</a> or the <a href=\"{$_CONF['site_url']}/search.php\">search page</a> to see if you can find what you lost."
);

###############################################################################
# login form

$LANG_LOGIN = array(
    1 => 'כדי לבצע פעולה זו הנך נדרש להתחבר',
    2 => 'כדי להיכנס לאזור זה, הנך נדרש/ת להתחבר כמשתמש',
    3 => 'כניסה',
    4 => 'משתמש חדש'
);

###############################################################################
# pdfgenerator.php

$LANG_PDF = array(
    1 => 'The PDF feature has been disabled',
    2 => 'The document provided was not rendered. The document was received but could not be processed.  Please make sure to submit only html formatted documents that have been written to the xHTML standard. Please note that overly complex html documents may not render correctly or at all.The document resulting from your attempt was 0 bytes in length, and has been deleted. If you\'re sure that your document should render fine, please re-submit it.',
    3 => 'Unknown error during PDF generation',
    4 => "No page data was given or you want to use the ad-hoc PDF generation tool below.  If you think you are getting this page\n          in error then please contact the system administrator.  Otherwise, you may use the form below to generate PDF's in an ad-hoc fashion.",
    5 => 'Loading your document.',
    6 => 'Please wait while your document is loaded.',
    7 => 'You may right click the button below and choose \'save target...\' or \'save link location...\' to save a copy of your document.',
    8 => "The path given in the configuration file to the HTMLDoc binary is invalid or this system cannot execute it.  Please contact the site administrator if this problem\n          persists.",
    9 => 'PDF Generator',
    10 => "This is the Ad-hoc PDF Generation tool. It will attempt to convert any URL you give into a PDF.  Please note that some web pages will not render properly with this feature.  This\n           is a limitation of the HTMLDoc PDF generation tool and such errors should not be reported to the administrators of this site",
    11 => 'URL',
    12 => 'Generate PDF!',
    13 => 'The PHP configuration on this server does not allow URLs to be used with the fopen() command.  The system administrator must edit the php.ini file and set allow_url_fopen to On',
    14 => 'The PDF you requested either does not exist or you tried to illegally access a file.'
);

?>