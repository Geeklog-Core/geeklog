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

$LANG_CHARSET = "utf-8";

###############################################################################
# Array Format:
# $LANGXX[YY]:	$LANG - variable name
#		  	XX - file id number
#			YY - phrase id number
###############################################################################

###############################################################################
# USER PHRASES - These are file phrases used in end user scripts
###############################################################################

###############################################################################
# common.php

$LANG01 = array(
	1 => "נכתב על-ידי", # "Contributed by:",
	2 => "פרטים נוספים", # "read more",
	3 => "תגובות", # "comments",
	4 => "עריכה", # "Edit",
	5 => "סקר השבוע", #"Vote",
	6 => "תוצאות", #"Results",
	7 => "תוצאות הסקר", #"Poll Results",
	8 => "קולות", #"votes",
	9 => "אדמיניסטרציה", # "Admin Functions:",
	10 => "לוח בקרה", # "Submissions",
	11 => "מאמרים", #"Stories",
	12 => "קוביות מידע", #"Blocks",
	13 => "נושאים", #"Topics",
	14 => "קישורים", #"Links",
	15 => "אירועים", #"Events",
	16 => "סקרים", #"Polls",
	17 => "משתמשים", #"Users",
	18 => "שאילתת SQL", #"SQL Query",
	19 => "התנתק", #"Log Out",
	20 => "פרטי משתמש", # "User Information:",
	21 => "שם משתמש", #"Username",
	22 => "קוד משתמש", # "User ID",
	23 => "רמת אבטחה", # "Security Level",
	24 => "אורח/ת באתר", # "Anonymous",
	25 => "תגובה", # "Reply",
	26 => "אין אתר זה אחרי לחומר הנכתב בו. האחריות על על כותבי ההודעות בלבד!", # "The following comments are owned by whoever posted them. This site is not responsible for what they say.",
	27 => "ההודעה החדשה ביותר", # "Most Recent Post",
	28 => "מחק", # "Delete",
	29 => "לא נרשמו תגובות", # "No user comments.",
	30 => "מאמרים ישנים", # "Older Stories",
	31 => "אפשר כתיבת HTML", # "Allowed HTML Tags:",
	32 => "הודעת שגיאה, חסר שם משתמש!", # "Error, invalid username",
	33 => "הודעת שגיאה, לא מצליח לכתוב לקובץ log", # "Error, could not write to the log file",
	34 => "ישנה שגיאה! Error", # "Error",
	35 => "התנתק Logout", # "Logout",
	36 => "בשעה:", # "on",
	37 => "טרם נכתבו הודעות  ", # "No user stories",

	38 => "38",
	39 => "רענן", # "Refresh",
	40 => "40",
	41 => "אורח", # "Guest Users",
	42 => "נכתב על-ידי:", # "Authored by:",
	43 => "הוסף תגובה", # "Reply to This",
	44 => "ראשי", # "Parent",
	45 => "מספר הודעת שגיאה של MySQL:", #  "MySQL Error Number",
	46 => "הודעת שגיאה של MySQL:", # "MySQL Error Message",
	47 => "אפשרויות משתמש", # "User Functions",
	48 => "פרטי חשבון", # "Account Information",
	49 => "מאפיני תצוגה", # "Display Preferences",
	50 => "Error with SQL statement",
	51 => "עזרה", # "help",
	52 => "חדש", # "New",
	53 => "Admin Home",
	54 => "לא מצליח לפתוח את הקובץ!", # "Could not open the file.",
	55 => "שגיאה ב-", # "Error at",
	56 => "הצבע", # "Vote",
	57 => "סיסמה", # "Password",
	58 => "כניסה", # "Login",
	59 => "אם אין לך עדיין חשבון, זה הזמן <a href=\"{$_CONF['site_url']}/users.php?mode=new\">להרשם</a> לאתר", # "Don't have an account yet?  Sign up as a <a href=\"{$_CONF['site_url']}/users.php?mode=new\">New User</a>",
	60 => "הוסף תגובה", # "Post a comment",
	61 => "צור חשבון חדש", # "Create New Account",
	62 => "מילים", # "words",
	63 => "מאפיני תגובה", # "Comment Preferences",
	64 => "שלח את המאמר לחבר", # "Email Article To a Friend",
	65 => "גרסא להדפסה", # "View Printable Version",
	66 => "היומן שלי", # "My Calendar",
	67 => "ברוך הבא ל", # "Welcome to ",
	68 => "בית", # "home",
	69 => "קשר", # "contact",
	70 => "חיפוש", # "search",
	71 => "הוסף הודעה", # "contribute",
	72 => "לינקים", # "web resources",
	73 => "מאגר הסקרים", # "past polls",
	74 => "יומן", # "calendar",
	75 => "חיפוש מתקדם", # "advanced search",
	76 => "סטטיסטיקה", # "site statistics",
	77 => "הרחבות לGeeklog", # "Plugins",
	78 => "אירועים צפויים", # "Upcoming Events",
	79 => "חדש באתר", # "What's New",
	80 => "stories in last",
	81 => "הודעות ב", # "story in last",
	82 => "שעות", # "hours",
	83 => "תגובות", # "COMMENTS",
	84 => "קישורים", # "LINKS",
	85 => "ב 48 השעות האחרונות", # "last 48 hrs",
	86 => "אין תגובות חדשות", # "No new comments",
	87 => "בשבועיים האחרונים", # "last 2 wks",
	88 => "אין קישורים חדשים", # "No recent new links",
	89 => "אין אירועים צפויים", # "There are no upcoming events",
	90 => "דף הבית", # "Home",
	91 => "דף זה נוצר ב", # "Created this page in",
	92 => "שניות", # "seconds",
	93 => "זכויות יוצרים", # "Copyright",
	94 => "כל זכויות היוצרים בדף זה שייכים לכותבים", # "All trademarks and copyrights on this page are owned by their respective owners.",
	95 => "מופעל על-ידי", # "Powered By",
	96 => "קבוצות", # "Groups",
	97 => "רשימה בינלאומית", # "Word List",
	98 => "תוספים והרחבות", # "Plug-ins",
	99 => "מאמרים", # "STORIES",
    100 => "אין מאמרים חדשים", # "No new stories",
    101 => 'האירועים שלך', # 'Your Events',
    102 => 'אירועים כלליים', # 'Site Events',
    103 => 'יצירת גיבוי', # 'DB Backups',
    104 => 'על-ידי', # 'by',
    105 => 'משתמשי דואר', # 'Mail Users',
    106 => 'נצפה', # 'Views'
    107 => 'GL Version Test',
    108 => 'Clear Cache'
);

###############################################################################
# calendar.php

$LANG02 = array(
	1 => "יומן אירועים", # "Calendar of Events",
	2 => "אין אירועים חדשים להצגה", # "I'm Sorry, there are no events to display.",
	3 => "מתי", # "When",
	4 => "איפה", # "Where",
	5 => "תיאור", # "Description",
	6 => "הוסף אירוע", # "Add A Event",
	7 => "אירועים צפויים", # "Upcoming Events",
	8 => 'על-ידי הוספת אירוע זה ליומנך יתאפשר לך לצפות בקלות רק באירועים המענינים אותך על-ידי לחיצה על "היומן שלי" מאזור "אפשרויות המשתמש" .', # 'By adding this event to your calendar you can quickly view only the events you are interested in by clicking "My Calendar" from the User Functions area.',
	9 => "הוסף ליומן שלי", # "Add to My Calendar",
	10 => "הסר מהיומן שלי", # "Remove from My Calendar",
	11 => "הוספת אירוע ליומן של {$_USER['username']}", # "Adding Event to {$_USER['username']}'s Calendar",

	12 => "אירוע", # "Event",
	13 => "מתחיל ב", # "Starts",
	14 => "מסתיים ב", # "Ends",
        15 => "חזרה ליומן", # "Back to Calendar"
);

###############################################################################
# comment.php

$LANG03 = array(
	1 => "הוסף הערה", # "Post a Comment",
	2 => "מאפיין הוספה", # "Post Mode",
	3 => "התנתק", # "Logout",
	4 => "צור חשבון", # "Create Account",
	5 => "שם משתמש", # "Username",
	6 => "כדי לכתוב הודעות באתר זה עליך להתחבר תחילה. אם אין לך עדיין חשבון, ניתן ליצור חשבון חדש על-ידי השדות הנמצאים מטה, תודה. ", # "This site requires you to be logged in to post a comment, please log in.  If you do not have an account you can use the form below to create one.",
	7 => "הודעתך האחרונה הייתה: ", # "Your last comment was ",
	8 => "שניות מההודעה האחרונה שלך. באתר זה יש מגבלה והזמן המינימלי הנדרש בין שני ההודעות הוא: {$_CONF["commentspeedlimit"]}", # " seconds ago.  This site requires at least {$_CONF["commentspeedlimit"]} seconds between comments",
	9 => "הערה", # "Comment",
	10 => "10 LANG03",
	11 => "הוסף תגובה", # "Submit Comment",
	12 => "חובה למלא את שדות הכותרת והתגובה על-מנת להעלות הודעה.", # "Please fill in the Title and Comment fields, as they are necessary for your submission of a comment.",
	13 => "המידע שלך", # "Your Information",
	14 => "צפייה לפני ההוספה", # "Preview",
	15 => "15 LANG03 ריק ",
	16 => "כותרת", # "Title",
	17 => "שגיאה", # "Error",

	18 => 'דברים חשובים', # 'Important Stuff',
	19 => 'נא להשתדל להגיב על נושא ההודעה ולא להעלות נושאים חדשים, תודה.', # 'Please try to keep posts on topic.',
	20 => 'נא להגיב על הודעות קודמות ולא לפתוח נושאים חדשים, תודה.', # 'Try to reply to other people comments instead of starting new threads.',
	21 => 'נא לקרוא את התגובות שנכתבו לפניך, בכדי לא לחזור על דברים שכבר נאמרו, תודה.', # 'Read other people\"s messages before posting your own to avoid simply duplicating what has already been said.',
	22 => 'השתמש בכותרת שתתאר בבירור את נושא ההודעה/מאמר שלך.', # 'Use a clear subject that describes what your message is about.',
	23 => 'האימיל שלך לא יוצג לגולשים באתר', # 'Your email address will NOT be made public.',
	24 => 'משתמש חסוי', # 'Anonymous User'
);

###############################################################################
# users.php

$LANG04 = array(
	1 => "פרופיל משתמש של", # "User Profile for",
	2 => "שם משתמש", # "User Name",
	3 => "שם ושם משפחה", # "Full Name",
	4 => "סיסמה", # "Password",
	5 => "דואל", # "Email",
	6 => "אתר בית", # "Homepage",
	7 => "פרטים אישיים:", # "Bio",
	8 => "מפתח PGP", # "PGP Key",
	9 => "שמור נתונים", # "Save Information",
	10 => "עשרת התגובות האחרונות של", # "Last 10 comments for user",
	11 => "אין תגובות", # "No User Comments",
	12 => "מאפיני המשתמש של", # "User Preferences for",
	13 => "Email Nightly Digest",
	14 => "סיסמה זו נוצרה בצורה רנדומלית, אולם מומלץ לשנות אותה מוקדם ככל האפשר. על מנת לעשות זאת, כנס/י לחשבונך הקליד/י על מאפייני החשבון, מתפריט שנמצא בחשבונך.", # "This password is generated by a randomizer. It is recommended that you change this password immediately. To change your password, log in and then click Account Information from the User Functions menu.",
	15 => "יצירת חשבונך ב{$_CONF["site_name"]} הושלם בהצלחה!. כעת, על-מנת להשתמש בו עליך להכניס בכניסה את שם המשתמש שלך ואת הסיסמא שקיבלת כאן. מומלץ לשמור את האימייל הזה במקום נגיש כדי להקל עליך כניסות עתידיות לחשבונך.", # "Your {$_CONF["site_name"]} account has been created successfully. To be able to use it, you must login using the information below. Please save this mail for further reference.",
	16 => "פרטי חשבונך: ", # "Your Account Information",
	17 => "החשבון לא קיים", # "Account does not exist",
	18 => "כתובת האימייל שהוקלד לא תקני!", # "The email address provided does not appear to be a valid email address",
	19 => "שם המשתמש או הסיסמא שהוקלדו תפוסים!", # "The username or email address provided already exists",
	20 => "כתובת האימייל שהוקלד לא תקני!", # "The email address provided does not appear to be a valid email address",
	21 => "שגיאה!", # "Error",
	22 => "רישום ב{$_CONF['site_name']}!", # "Register with {$_CONF['site_name']}!",
	23 => "יצירת חשבון באתר {$_CONF['site_name']}, תאפשר לך ליהנות ממגוון אפשרויות ושירותים מתקדמים. למי שלא יהיה חשבון יוכל לפרסם הודעות  כמשתמש אנונימי בלבד וללא יכולת קבלת תגובות למייל או שימוש שפונקציות מתקדמות. לידיעתך, כתובת הדואל שתימסר באתר <b>לא</b> תתפרסם או תהיה גלויה באתר.", # "Creating a user account will give you all the benefits of {$_CONF['site_name']} membership and it will allow you to post comments and submit items as yourself. If you don't have an account, you will only be able to post anonymously. Please note that your email address will <b><i>never</i></b> be publicly displayed on this site.",
	24 => "סיסמתך תשלח לכתובת האימייל שהכנסת.", # "Your password will be sent to the email address you enter.",
	25 => "האם שחכת את הסיסמה?", # "Did You Forget Your Password?",
	26 => "הכנס את שם המשתמש שלך ולחץ על <b> שלח סיסמה חדשה לאימייל </b> וסיסמה חדשה תישלח לאימייל שרשום במערכת.", # "Enter your username and click Email Password and a new password will be mailed to the email address on record.",
	27 => "הרשם/מי עכשיו!", # "Register Now!",
	28 => "שלח סיסמה חדשה לאימייל", # "Email Password",
	29 => "התנתק/י מ", # "logged out from",
	30 => "התחבר מה", # "logged in from",
	31 => "הפונקציה שבחרת לעשות דורשת התחברות לאתר על-ידי הכנסת שם משתמש וסיסמה", # "The function you have selected requires you to be logged in",
	32 => "תוספת טקסט להודעות", # "Signature",
	33 => "לא להציג בפומבי", # "Never publicly displayed",
	34 => "זה שמך האמתי" , # "This is your real name",
	35 => "הכנס/י סיסמה חדשה (הסיסמה הישנה תשתנה לסיסמה זו)", # "Enter password to change it",
	36 => "לא לשכוח להכניס http://", # "Begins with http://",
	37 => "אשר/י את תגובתך", # "Applied to your comments",
	38 => "הכל באחריותך, כולם יכולים לקרא זאת!", # "It's all about you! Everyone can read this",
	39 => "מפתח ה PGP הפומבי שלך", # "Your public PGP key to share",
	40 => "בטל הצגת איקון המדור", # "No Topic Icons",
	41 => "Willing to Moderate",
	42 => "תצורת הצגת התאריך", # "Date Format",
	43 => "מקסימום הודעות לדף", # "Maximum Stories",
	44 => "בטל הצגת קוביות מידע", # "No boxes",
	45 => "מאפייני תצוגה של", # "Display Preferences for",
	46 => "Excluded Items for",
	47 => "News box Configuration for",
	48 => "הודאות/מאמרים", # "Topics",
	49 => "לא יוצג האייקון המופיע לצד ההודעה" , # "No icons in stories",
	50 => "בטל/י סימון אם אנך מעוניין בפונקציה זו", # "Uncheck this if you aren't interested",
	51 => "יופיעו רק הודעות ללא הקוביות בצדדים", # "Just the news stories",
	52 => "ברירת המחדל היא 10", # "The default is 10",
	53 => "Receive the days stories every night",
	54 => "Check the boxes for the topics and authors you don't want to see.",
	55 => "If you leave these all unchecked, it means you want the default selection of boxes. If you start selecting boxes, remember to set all of them that you want because the default selection will be ignored. Default entries are displayed in bold.",
	56 => "כותבים", # "Authors",
	57 => "תצורת התצוגה", # "Display Mode",
	58 => "סדר ההודעות/מאמרים", # "Sort Order",
	59 => "הגבלת תגובות", # "Comment Limit",
	60 => "איך את/ה רוצה שהתגובות יוצגו?", # "How do you like your comments displayed?",
	61 => "קודם הודעות חדשות או ישנות?", # "Newest or oldest first?",
	62 => "ברירת המחדל היא 100", # "The default is 100",
	63 => "הסיסמה נשלחה אליך באמצעות המייל ואתה אמור לקבל אותה בכל רגע. אנא עקוב אחר ההוראות שבמייל. ברכות על הצתרפותך ל
" . $_CONF["site_name"], # "Your password has been emailed to you and should arrive momentarily. Please follow the directions in the message and we thank-you for using " . $_CONF["site_name"],
	64 => "מאפייני תגובה של", # "Comment Preferences for",
	65 => "נסה/י להכנס שוב", # "Try Logging in Again",
	66 => "You may have mistyped your login credentials.  Please try logging in again below. Are you a <a href=\"{$_CONF['site_url']}/users.php?mode=new\">new user</a>?",
	67 => "חברים חדשים מאז", # "Member Since",
	68 => "שהמערכת תזכור אותי ל", # "Remember Me For",
	69 => "לכמה זמן את/ה רוצה שהמערכת תזכור אותך לאחר שתכנס/י לאתר?", # "How long should we remember you after logging in?",
	70 => "בחר/י את מראה האתר ואופן תצורת התוכן ל{$_CONF['site_name']}", # "Customize the layout and content of {$_CONF['site_name']}",
	71 => "אחת מהאפשרויות של אתר {$_CONF['site_name']} היא להתאים את תוכן האתר לטעמך האישי, הן התוכן והן במראה.על מנת להינות מיתרונות אלו, עליך <a href=\"{$_CONF['site_url']}/users.php?mode=new\">להירשם</a> with {$_CONF['site_name']}. אם אתה כבר רשום באתר אז תכניס/י שם משתמש וסיסמה והתחל להנות מהיותך רשום/ה", # "One of the great features of {$_CONF['site_name']} is you can customize the content you get and you can change the overall layout of this site.  In order to take advantage of these great features you must first <a href=\"{$_CONF['site_url']}/users.php?mode=new\">register</a> with {$_CONF['site_name']}.  Are you already a member?  Then use the login form to the left to log in!",
    72 => "מראה האתר", # "Theme",
    73 => "שפה", # "Language",
    74 => "שנה את מראה האתר!", # "Change what this site looks like!",
    75 => "קבלת הודעות/מאמרים באימייל", # "Emailed Topics for",
    76 => "בחירה באחת מהאפשרויות הרשומות מטה תאפשר לך לקבל, בסוף כל יום, את כל ההודעות החדשות שייתווספו להודעה או מאמר זה. מומלץ לבחור רק בנושאים המעניינים אותך ביכדי להמנע מקבלת הודעות רבות מדי באימייל", # "If you select a topic from the list below you will receive any new stories posted to that topic at the end of each day.  Choose only the topics that interest you!",
    77 => "תמונה", # "Photo",
    78 => "הוסף תמונה של עצמך", # "Add a picture of yourself!",
    79 => "לחץ/י כאן בכדי למחוק את התמונה", # "Check here to delete this picture"
    80 => "התחבר", #"Login",
    81 => "שלח דואל", #"Send Email",
    82 => 'עשרת ההודעות האחרונות של ', # 'Last 10 stories for user',
    83 => 'הצג סטטיסטיקה למשתמש ', # 'Posting  statistics for user',
    84 => 'סהכ הודעות:', # 'Total number of  articles:',
    85 => 'סהכ  תגובות:', # 'Total number of  comments:',
    86 => 'מצא הודעות שנכתבו על-ידי ', # 'Find all  postings by',
    87 => 'שם המשתמש שלך הוא ', # 'Your login name',
    88 => 'Someone (possibly you) has requested a new password for your account "%s" on ' . $_CONF['site_name'] . ', <' . $_CONF['site_url'] . ">.\n\nIf you really want this action to be taken, please click on the following link:\n\n",
    89 => "If you do not want this action to be taken, simply ignore this message and the request will be disregarded (your password will remain unchanged).\n\n",
    90 => 'הכנס את סיסמתך החדשה בדף זה. לידיעתך סיסמתך הישנה תישאר בתוקף עד שתלחץ על אישור בדף זה.', # 'You can enter a new password for your account below. Please note that your old password is still valid until you submit this form.',
    91 => 'שנה סיסמה', # 'Set New Password',
    92 => 'הכנס סיסמה חדשה ', # 'Enter New Password',
    93 => 'הבקשה האחרונה שלך לקבלת סיסמה חדשה הייתה לפני%d  שניות. מסיבות אבטחה דרוש להמתין לפחות%d  שניות.', # 'Your last request for a new password was %d seconds ago. This site requires at least %d seconds between password requests.',
    94 => 'מחק את חשבון של  מהמערכת', # 'Delete Account "%s"',
    95 => 'Click the "delete account" button below to remove your account from our database. Please note that any stories and comments you posted under this account will <strong>not</strong> be deleted but show up as being posted by "Anonymous".',
    96 => 'מחק חשבון זה', # 'delete account',
    97 => 'Confirm Account Deletion',
    98 => 'Are you sure you want to delete your account? By doing so, you will not be able to log into this site again (unless you create a new account). If you are sure, click "delete account" again on the form below.',
    99 => 'דרישות הפרטיות של', # 'Privacy Options for',
    100 => 'קבלת הודעות מהאדמיניסטראטור', # 'Email from Admin',
    101 => 'אשר קבלת הודעות במייל ממנהל האתר ', # 'Allow email from Site Admins',
    102 => 'קבלת הודעות ממשתמשים', # 'Email from Users',
    103 => 'אישר קבלת הודעות ממשתמשים באתר', # 'Allow email from other users',
    104 => 'הצג מי נמצא באתר', # 'Show Online Status',
    105 => 'מציג את כל מי שנמצא באתר', # 'Show up in Who\'s Online block'
);

###############################################################################
# index.php

$LANG05 = array(
	1 => "אין הודעות/כתבות חדשות להצגה", # "No News to Display",
	2 => "There are no news stories to display.  There may be no news for this topic or your user preferences may be too restrictive.",
	3 => "עבודר נושא %s ", # "for topic %s",
	4 => "הודעות/כתבות שנכתבו היום", # "Today's Featured Article",
	5 => "הבא", # "Next",
	6 => "הקודם", # "Previous"
);

###############################################################################
# links.php

$LANG06 = array(
	1 => "פרטים", # "Web Resources",
	2 => "אין פרטים להצגה", # "There are no resources to display.",
	3 => "הוסף קישור", # "Add A Link"
);

###############################################################################
# pollbooth.php

$LANG07 = array(
	1 => "הצבעתך נרשמה", # "Vote Saved",
	2 => "הצבעתך התווספה לסקר", # "Your vote was saved for the poll",
	3 => "הצבע", # "Vote",
	4 => "סקרים במערכת", # "Polls in System",
	5 => "הצביעו", # "Votes"
	6 => "צפה בסקרים נוספים", #"View other poll questions"
);

###############################################################################
# profiles.php

$LANG08 = array(
	1 => "הרעה שגיאה במשלוח ההודעה, אנא נסה/י שוב", # "There was an error sending your message. Please try again.",
	2 => "ההודעה נשלחה בהצלחה", # "Message sent successfully.",
	3 => "וודא שהמייל לקבלת תגובה יהיה נכון", # "Please make sure you use a valid email address in the Reply To field.",
	4 => "אנא מלא את השדות הבאים", # "Please fill in the Your Name, Reply To, Subject and Message fields",
	5 => "שגיאה, אין משתמש בשם שבחרת", # "Error: No such user.",
	6 => "ההודעה לא נשלחה בהצלחה עקב שגיאה.", # "There was an error.",
	7 => "פרופיל המשתמש ל", # "User Profile for",
	8 => "שם השולח", # "User Name",
	9 => "אתר הביית", # "User URL",
	10 => "שלח הודעה ל:", # "Send mail to",
	11 => "שמך", # "Your Name:",
	12 => "מייל לקבלת תגובה", # "Reply To:",
	13 => "נושא", # "Subject:",
	14 => "הודעה:", # "Message:",
	15 => "HTML לא יתורגם", # "HTML will not be translated.",
	16 => "שלח", # "Send Message",
	17 => "שלח את ההודעה/מאמר לחבר", # "Mail Story to a Friend",
	18 => "שם הנמען", # "To Name",
	19 => "כתובת המייל של הנמען", # "To Email Address",
	20 => "שם השולח", # "From Name",
	21 => "כתובת המייל של השולח", # "From Email Address",
	22 => "חובה למלא את כל השדות", # "All fields are required",
	23 => "This email was sent to you by %s at %s because they thought you might be interested in this article from {$_CONF["site_url"]}.  This is not SPAM and the email addresses involved in this transaction were not saved to a list or stored for later use.",
	24 => "Comment on this story at",
	25 => "You must be logged in to user this feature.  By having you log in, it helps us prevent misuse of the system",
	26 => "חובה למלא את <b>כל</b>  השדות אחרת ההודעה <b>לא</b> תישלח.", # "This form will allow you to send an email to the selected user.  All fields are required.",
	27 => "כתוב הודעה קצרה", # "Short message",
	28 => "%s wrote: ",
    29 => "This is the daily digest from {$_CONF['site_name']} for ",
    30 => " Daily Newsletter for ",
    31 => "כותרת", # "Title",
    32 => "תאריך", # "Date",
    33 => "ההודעה/מאמר המלא נמצא בכתובת:", # "Read the full article at",
    34 => "סוף ההודעה", # "End of Message"
    35 => 'Sorry, this user prefers not to receive any emails.'
);

###############################################################################
# search.php

$LANG09 = array(
	1 => "חיפוש מתקדם", # "Advanced Search",
	2 => "מילות מפתח", # "Key Words",
	3 => "כותרת", # "Topic",
	4 => "הכל", # "All",
	5 => "סוג", # "Type",
	6 => "מאמר/הודעה", # "Stories",
	7 => "תגובות", # "Comments",
	8 => "כותבים", # "Authors",
	9 => "הכל", # "All",
	10 => "חיפוש", # "Search",
	11 => "תוצאות החיפוש", # "Search Results",
	12 => "תואמים", # "matches",
	13 => "תוצאות החיפוש: לא נמצאו מחרוזות תואמות", # "Search Results: No matches",
	14 => "לא נמצאו התאמות לחיפושך", # "There were no matches for your search on",
	15 => "אנא נסה/י שוב", # "Please try again.",
	16 => "כותרת", # "Title",
	17 => "תאריך", # "Date",
	18 => "נכתב על-ידי", # "Author",
	19 => "חפש בכל מאגר המידע של {$_CONF["site_name"]} כולל בהודעות חדשות", # "Search the entire {$_CONF["site_name"]} database of current and past news stories",
	20 => "תאריך", # "Date",
	21 => "דואל", # "to",
	22 => "(Date Format MM-DD-YYYY)",
	23 => "תוצאות", # "Hits",
	24 => "נמצאו", # "Found",
	25 => "מתאימים ל", # "matches for",
	26 => "פריטים", # "items in",
	27 => "שניות", # "seconds",
    28 => ' לא נמצאו מאמרים/הודעות או תגובות המתאימים לחיפוש שלך', # 'No story or comment matches for your search',
    29 => 'תוצאות החיפוש', # 'Story and Comment Results',
    30 => 'לא נמצאו קישורים תואמים', # 'No links matched your search',
    31 => 'This plug-in returned no matches',
    32 => 'אירוע', # 'Event',
    33 => 'URL',
    34 => 'מיקום', # 'Location',
    35 => 'יום שלם', # 'All Day',
    36 => 'לא נמצאו אירועים המתאימים לחיפושך', # 'No events matched your search',
    37 => 'האירועים שנמצאו הם', # 'Event Results',
    38 => 'הקישורים שנמצאו הם', # 'Link Results',
    39 => 'קישורים', # 'Links',
    40 => 'אירועים', # 'Events'
    41 => 'חובה להכניס לפחות 3 תווים.', # 'Your query string should have at least 3 characters.',
    42 => 'Please use a date formatted as YYYY-MM-DD (year-month-day).',
    42 => 'Please use a date formatted as YYYY-MM-DD (year-month-day).',
    43 => 'בדיוק כפי שהוקלד (חייבת להיות התאמה מדויקת של המחרוזת כדי שתהיה תוצאה)', # 'exact phrase',
    44 => 'כל המילים יחד (כל המילים חייבות להופיע אבל לא בהכרח בסדר כתיבתם)', # 'all of these words',
    45 => 'כל אחת מהמילים (יהיו תוצאות גם אם רק מילה אחת תופיע)', # 'any of these words',
    46 => 'הבא', # 'Next',
    47 => 'הקודם', # 'Previous',
    48 => 'הכותב', # 'Author',
    49 => 'תאריך', # 'Date',
    50 => 'כניסות', # 'Hits',
    51 => 'קישור', # 'Link',
    52 => 'מיקום', # 'Location',
    53 => 'Story Results',
    54 => 'Comment Results',
    55 => 'the phrase',
    56 => 'סיום', 'AND',
    57 => 'או', # 'OR'
);

###############################################################################
# stats.php

$LANG10 = array(
	1 => "סיכום סטטיסטי לאתר", #  "Site Statistics",
	2 => "כניסות למערכת", # "Total Hits to the System",
	3 => "Stories(Comments) in the System",
	4 => "Polls(Answers) in the System",
	5 => "Links(Clicks) in the System",
	6 => "Events in the System",
	7 => "עשרת ההודעות הנצפות ביותר", # "Top Ten Viewed Stories",
	8 => "כותרת ההודעה:", # "Story Title",
	9 => "Views",
	10 => "It appears that there are no stories on this site or no one has ever viewed them.",
	11 => "Top Ten Commented Stories",
	12 => "Comments",
	13 => "It appears that there are no stories on this site or no one has ever posted a comment on them.",
	14 => "עשרת הסקרים הנצפים ביותר:", # "Top Ten Polls",
	15 => "Poll Question",
	16 => "הצבעות", # "Votes",
	17 => "It appears that there are no polls on this site or no one has ever voted.",
	18 => "עשרת הלינקים הנצפים ביותר:", # "Top Ten Links",
	19 => "לינקים", # "Links",
	20 => "כניסות", # "Hits",
	21 => "It appears that there are no links on this site or no one has ever clicked on one.",
	22 => "Top Ten Emailed Stories",
	23 => "אימיילים", # "Emails",
	24 => "It appears that no one has emaild a story on this site"
);

###############################################################################
# article.php

$LANG11 = array(
	1 => "לינקים בהודעה זו", # "What's Related",
	2 => "שלח את ההודעה/מאמר לחבר", # "Mail Story to a Friend",
	3 => "גרסה להדפסה", # "Printable Story Format",
	4 => "אפשרויות להודעה זו:", # "Story Options"
);

###############################################################################
# submit.php

$LANG12 = array(
	1 => "על-מנת לבצע %s עליך להיות משתמש רשום במערכת", # "To submit a %s you are required to be logged in as a user.",
	2 => "כניסה", # "Login",
	3 => "משתמש חדש",# "New User",
	4 => "אשר אירוע",# "Submit a Event",
	5 => "אשר קישור",# "Submit a Link",
	6 => "אשר מאמר",# "Submit a Story",
	7 => "פעולה זו זמינה למשתמשים רשומים בלבד!",# "Login is Required",
	8 => "אישור",# "Submit",
	9 => "When submitting information for use on this site we ask that you follow the following suggestions...<ul><li>Fill in all the fields, they're required<li>Provide complete and accurate information<li>Double check those URLs</ul>",
	10 => "כותרת",# "Title",
	11 => "קשור",# "Link",
	12 => "תאריך התחלה",# "Start Date",
	13 => "תאריך סיום",# "End Date",
	14 => "מיקום",# "Location",
	15 => "פרטים",# "Description",
	16 => "אם יש פרטים נוספים, אנא הכנס/י אותם",# "If other, please specify",
	17 => "קטגוריה",# "Category",
	18 => "אחר",# "Other",
	19 => "קרא לפני הוספה",# "Read First",
	20 => "חסרה קטגוריה!!",# "Error: Missing Category",
	21 => "כאשר בוחרים <b>אחר</b> חיבים להכניס שם של קטגוריה",# "When selecting \"Other\" please also provide a category name",
	22 => "יש שדות ריקים שלא מולאו, עליך להשלים אותם ולאשר מחדש",# "Error: Missing Fields",
	23 => "יש למלא את <b>כל</b> השדות בטופס זה!",# "Please fill in all the fields on the form.  All fields are required.",
	24 => "Submission Saved",
	25 => "Your %s submission has been saved successfully.",
	26 => "Speed Limit",
	27 => "שם משתמש",# "Username",
	28 => "נושא",# "Topic",
	29 => "מאמר",# "Story",
	30 => "הודעתך האחרונה הייתה לפני",# "Your last submission was ",
	31 => "נדרשים לפחות {$_CONF["speedlimit"]}שניות בין הודעה אחת לשניה.",# " seconds ago.  This site requires at least {$_CONF["speedlimit"]} seconds between submissions",
	32 => "תצוגה מקדימה", # "Preview",
	33 => "תצוגה מקדימה של המאמר", # "Story Preview",
	34 => "התנתקות", # "Log Out",
	35 => "לא ניתן להשתמש ב HTML", # "HTML tags are not allowed",
	36 => "Post Mode",
	37 => "Submitting an event to {$_CONF["site_name"]} will put your event on the master calendar where users can optionally add your event to their personal calendar. This feature is <b>NOT</b> meant to store your personal events such as birthdays and anniversaries.<br><br>Once you submit your event it will be sent to our administrators and if approved, your event will appear on the master calendar.",
    	38 => "הוסף אירוע ל", # "Add Event To",
	39 => "יומן ציבורי", # "Master Calendar",
 	40 => "יומן פרטי", # "Personal Calendar",
 	41 => "שעת סיום", # "End Time",
 	42 => "שעת התחלה", # "Start Time",
 	43 => "אירוע שנמשך יום שלם", # "All Day Event",
 	44 => 'שורת כתובת 1', # 'Address Line 1',
 	45 => 'שורת כתובת 2', # 'Address Line 2',
 	46 => 'ישוב/עיר', # 'City/Town',
 	47 => 'מדינה', # 'State',
 	48 => 'מיקוד', # 'Zip Code',
	49 => 'סוג אירוע', # 'Event Type',
	50 => 'ערוך סוג אירוע', # 'Edit Event Types',
	51 => 'מיקום', # 'Location',
	52 => 'מחק', # 'Delete'
    53 => 'Create Account',
);


###############################################################################
# ADMIN PHRASES - These are file phrases used in end admin scripts
###############################################################################

###############################################################################
# auth.inc.php

$LANG20 = array(
	1 => "נדרשים פרטי זיהוי משתמש", # "Authentication Required",
	2 => "פרטי משתמש אינם נכונים!", # "Denied! Incorrect Login Information",
	3 => "חסרה סיסמא", # "Invalid password for user",
	4 => "שם משתמש", # "Username:",
	5 => "סיסמא", # "Password:",
	6 => "All access to administrative portions of this web site are logged and reviewed.<br>This page is for the use of authorized personnel only.",
	7 => "כניסה", # "login"
);

###############################################################################
# block.php

$LANG21 = array(
	1 => "Insufficient Admin Rights",
	2 => "You do not have the necessary rights to edit this block.",
	3 => "Block Editor",
	4 => "",
	5 => "Block Title",
	6 => "Topic",
	7 => "All",
	8 => "Block Security Level",
	9 => "Block Order",
	10 => "סוג קוביה", # "Block Type",
	11 => "Portal Block",
	12 => "Normal Block",
	13 => "אפשרויות לקוביות המידע", # "Portal Block Options",
	14 => "RDF URL",
	15 => "Last RDF Update",
	16 => "Normal Block Options",
	17 => "תוכן הקוביה", # "Block Content",
	18 => "Please fill in the Block Title, Security Level and Content fields",
	19 => "Block Manager",
	20 => "כותרת", # "Block Title",
	21 => "Block SecLev",
	22 => "סוג קוביה", # "Block Type",
	23 => "סדר הצגת בקוביות", # "Block Order",
	24 => "נושא", # "Block Topic",
	25 => "To modify or delete a block, click on that block below.  To create a new block click on new block above.",
	26 => "Layout Block",
	27 => "PHP Block",
    28 => "PHP Block Options",
    29 => "Block Function",
    30 => "If you would like to have one of your blocks use PHP code, enter the name of the function above.  Your function name must start with the prefix \"phpblock_\" (e.g. phpblock_getweather).  If it does not have this prefix, your function will NOT be called.  We do this to keep people who may have hacked your Geeklog installation from putting arbitrary function calls that may be harmful to your system.  Be sure not to put empty parenthisis \"()\" after your function name.  Finally, it is recommended that you put all your PHP Block code in /path/to/geeklog/system/lib-custom.php.  That will allow the code to stay with you even when you upgrade to a newer version of Geeklog.",
    31 => "Error in PHP Block.  Function, %s, does not exist.",
    32 => "Error Missing Field(s)",
    33 => "You must enter the URL to the .rdf file for portal blocks",
    34 => "You must enter the title and the function for PHP blocks",
    35 => "You must enter the title and the content for normal blocks",
    36 => "You must enter the content for layout blocks",
    37 => "Bad PHP block function name",
    38 => "Functions for PHP Blocks must have the prefix 'phpblock_' (e.g. phpblock_getweather).  The 'phpblock_' prefix is required for security reasons to prevent the execution of arbitrary code.",
	39 => "צד", # "Side",
	40 => "ימין", # "Left",
	41 => "שמאל", # "Right",
	42 => "You must enter the blockorder and security level for Geeklog default blocks",
	43 => "דף בית בלבד", # "Homepage Only",
	44 => "אישור כניסה נדחה!", # "Access Denied",
	45 => "You are trying to access a block that you don't have rights to.  This attempt has been logged. Please <a href=\"{$_CONF["site_url"]}/admin/block.php\">go back to the block administration screen</a>.",
	46 => 'קוביה חדשה', # 'New Block',
	47 => 'Admin Home',
    48 => 'שם קוביה', # 'Block Name',
    49 => 'השם חייב להיות ייחודי ובלי רווחים', # ' (no spaces and must be unique)',
    50 => 'כתובת URL של קבצי עזרה', # 'Help File URL',
    51 => '(חובה לכלול גם<b>  http://</b>(', # 'include http://',
    52 => 'אם משאירים ריק צלמית עזרה לא תופיע!', # 'If you leave this blank the help icon for this block will not be displayed',
    53 => 'אפשר', # 'Enabled'
    54 => 'שמור', # 'save',
    55 => 'ביטול', # 'cancel',
    56 => 'מחיקה', # 'delete'
);

###############################################################################
# event.php

$LANG22 = array(
	1 => "עריכת אירוע", # "Event Editor",
	2 => "",
	3 => "כותרת אירוע", # "Event Title",
	4 => "כתובת אינטרנטית של האירוע", # "Event URL",
	5 => "תאריך התחלת האירוע", # "Event Start Date",
	6 => "תאריך סיום האירוע", # "Event End Date",
	7 => "מיקום האירוע", # "Event Location",
	8 => "תיאור האירוע", # "Event Description",
	9 => "(חובה לכלול גם<b>  http://</b>(", # "(include http://)",
	10 => "חיבים למלא את השדות של תאריך האירוע/שעות האירוע תיאור האירוע ומיקומו ", # "You must provide the dates/times, description and event location!",
	11 => "מרכז האירוע", # "Event Manager",
	12 => "To modify or delete a event, click on that event below.  To create a new event click on new event above.",
	13 => "כותרת האירוע", # "Event Title",
	14 => "מתחיל בתאריך", # "Start Date",
	15 => "מסתיים בתאריך", # "End Date",
	16 => "אין הרשאות גישה למידע זה", # "Access Denied",
	17 => "You are trying to access an event that you don't have rights to.  This attempt has been logged. Please <a href=\"{$_CONF["site_url"]}/admin/event.php\">go back to the event administration screen</a>.",
	18 => 'אירוע חדש', # 'New Event',
	19 => 'אתר אדמיניסטרטור', # 'Admin Home'
    20 => 'שמירה', # 'save',
    21 => 'ביטול', # 'cancel',
    22 => 'מחיקה', # 'delete'
);

###############################################################################
# link.php

$LANG23 = array(
	1 => "עריכת לינק:", # "Link Editor",
	2 => "",
	3 => "כותרת", # "Link Title",
	4 => "כתובת הURL של הלינק", # "Link URL",

	5 => "קטגוריה", # "Category",
	6 => "חובה לכלול גם<b>  http://</b>", # "(include http://)",
	7 => "בחר קטגוריה", # "Other",
	8 => "כניסות ללינק", # "Link Hits",
	9 => "הכנס כמה מילים על הלינק", # "Link Description",
	10 => "שכחת למלא שדה אחד או יותר!  הינך חייב למלא את<b> כל השדות</b> בכדי שהמערכת תקלוט את הלינק החדש. השדות האפשריים הם: <b>כותרת</b>,  <b>כתובת URL</b>,  <b>וכמה מילים על הלינק</b>, כמו-כן, בדוק אם קיימת קטגוריה שתחתיה אפשר לשים את הלינק החדש ורק אם אין, צור/י לינק חדש, תודה.", # "You need to provide a link Title, URL and Description.",
	11 => "מנהל הלינק", # "Link Manager",
	12 => "To modify or delete a link, click on that link below.  To create a new link click new link above.",
	13 => "שם הלינק", # "Link Title",
	14 => "קטגוריה", # "Link Category",
	15 => "קישור URL", # "Link URL",
	16 => "אין לך הרשאות כניסה", # "Access Denied",
	17 => "You are trying to access a link that you don't have rights to.  This attempt has been logged. Please <a href=\"{$_CONF["site_admin_url"]}/link.php\">go back to the link administration screen</a>.",
	18 => 'הוסף קישור', # 'New Link',
	19 => 'Admin Home',
	20 => 'לקטגוריה חדשה, הכנס כאן', # 'If other, specify',
    21 => 'שמור', # 'save',
    22 => 'ביטול', # 'cancel',
    23 => 'מחק', # 'delete'
);

###############################################################################
# story.php

$LANG24 = array(
	1 => "מאמר קודם", # "Previous Stories",
	2 => "למאמר הבא", # "Next Stories",
	3 => "מצב", # "Mode",
	4 => "מצב כתיבה", # "Post Mode",
	5 => "דף עריכת הודעה/מאמר", # "Story Editor",
	6 => "",
	7 => "נכתב על-ידי", # "Author",
	8 => "שמור", # "save",
	9 => "צפייה מוקדמת", # "preview",
	10 => "ביטול", #"cancel",
	11 => "מחק", #"delete",
	12 => "12",
	13 => "כותרת", # "Title",
	14 => "נושא", # "Topic",
	15 => "תאריך", # "Date",
	16 => "תמצית המאמר", # "Intro Text",
	17 => "גוף המאמר", # "Body Text",
	18 => "כניסות", # "Hits",
	19 => "תגובות", # "Comments",
	20 => "20",
	21 => "21",
	22 => "רשימת מאמרים", # "Story List",
	23 => "To modify or delete a story, click on that story's number below. To view a story, click on the title of the story you wish to view. To create a new story click on new story above.",
	24 => "24",
	25 => "25",
	26 => "תצוגה מקדימה של המאמר", # "Story Preview",
	27 => "27",
	28 => "28",
	29 => "29",
	30 => "30",
	31 => "Please fill in the Author, Title and Intro Text fields",
	32 => "Featured",
	33 => "There can only be one featured story",
	34 => "טיוטה", # "Draft",
	35 => "כן", # "Yes",
	36 => "לא", # "No",
	37 => "תגובה נוספת על-ידי", # "More by",
	38 => "עוד מ", # "More from",
	39 => "כתובות דואל", # "Emails",
	40 => "Access Denied",
	41 => "You are trying to access a story that you don't have rights to.  This attempt has been logged.  You may view the article in read-only below. Please <a href=\"{$_CONF["site_url"]}/admin/story.php\">go back to the story administration screen</a> when you are done.",
	42 => "You are trying to access a story that you don't have rights to.  This attempt has been logged.  Please <a href=\"{$_CONF["site_url"]}/admin/story.php\">go back to the story administration screen</a>.",
	43 => 'מאמר חדש', # 'New Story',
	44 => 'Admin Home',
	45 => 'הרשאות', # 'Access',
    46 => '<b>NOTE:</b> if you modify this date to be in the future, this article will not be published until that date.  That also means the story will not be included in your RDF headline feed and it will be ignored by the search and statistics pages.',
    47 => 'תמונות', # 'Images',
    48 => 'תמונה', # 'image',
    49 => 'שמאל', # 'right',
    50 => 'ימין', # 'left',
    51 => 'To add one of the images you are attaching to this article you need to insert specially formated text.  The specially formated text is [imageX], [imageX_right] or [imageX_left] where X is the number of the image you have attached.  NOTE: You must use the images you attach.  If you do not you will be unable to save your story.<BR><P><B>PREVIEWING</B>: Previewing a story with images attached is best done by saving the article as a draft INSTEAD OF hitting the preview button.  Use the preview button only when images are not attached.',
    52 => 'מחיקה', # 'Delete',
    53 => 'was not used.  You must include this image in the intro or body before you can save your changes',
    54 => 'Attached Images Not Used',
    55 => 'The following errors occured while trying to save your story.  Please correct these errors before saving',
    56 => 'הראה צלמית כותרת', # 'Show Topic Icon'
    57 => 'View unscaled image'
);

###############################################################################
# poll.php

$LANG25 = array(
	1 => "מצב", # "Mode",
	2 => "2  LANG25",
	3 => "תאריך יצירת הסקר", # "Poll Created",
	4 => "הסקר %s נשמר", # "Poll %s saved",
	5 => "דף יצירת סקר", # "Edit Poll",
	6 => "שם/מקט סקר", # "Poll ID",
	7 => "לא לעשות רווחים בין המילים!", # "(do not use spaces)",
	8 => "הצג סקר באתר", # "Appears on Homepage",
	9 => "שאלת הסקר", # "Question",
	10 => "תשובות אפשריות לסקר", # "Answers / Votes",
	11 => "There was an error getting poll answer data about the poll %s",
	12 => "There was an error getting poll question data about the poll %s",
	13 => "יצירת סקר חדש", # "Create Poll",
	14 => "save",
	15 => "cancel",
	16 => "delete",
	17 => 'Please enter a Poll ID',
	18 => "רשימת סקרים", # "Poll List",
	19 => "כדי לשנות או למחוק סקר פשוט סמן אותו. כדי ליצור סקר חדש לחץ על<b> צור סקר</b>", # "To modify or delete a poll, click on that poll.  To create a new poll click on new poll above.",
	20 => "משתתפים", # "Voters",
	21 => "אין גישה!", # "Access Denied",
	22 => "You are trying to access a poll that you don't have rights to.  This attempt has been logged. Please <a href=\"{$_CONF["site_url"]}/admin/poll.php\">go back to the poll administration screen</a>.",
	23 => 'יצירת סקר חדש', # 'New Poll',
	24 => 'Admin Home',
	25 => 'כן', # 'Yes',
	26 => 'לא', # 'No'
);

###############################################################################
# topic.php

$LANG27 = array(
	1 => "עורך ההודעה/מאמר", # "Topic Editor",
	2 => "מקט ההודעה/מאמר", # "Topic ID",
	3 => "כותרת ההודעה/מאמר", # "Topic Name",
	4 => "תמונות ההודעה/מאמר", # "Topic Image",
	5 => "לא לעשות רווחים בין המילים!", # "(do not use spaces)",
	6 => "Deleting a topic deletes all stories and blocks associated with it",
	7 => "Please fill in the Topic ID and Topic Name fields",
	8 => "Topic Manager",
	9 => "To modify or delete a topic, click on that topic.  To create a new topic click the new topic button to the left. You will find your access level for each topic in parenthesis",
	10=> "סדר מיון", # "Sort Order",
	11 => "Stories/Page",
	12 => "Access Denied",
	13 => "You are trying to access a topic that you don't have rights to.  This attempt has been logged. Please <a href=\"{$_CONF["site_url"]}/admin/topic.php\">go back to the topic administration screen</a>.",
	14 => "שיטת מיון", # "Sort Method",
	15 => "לפי הא-ב", # "alphabetical",
	16 => "ברירת המחדל היא", # "default is",
	17 => "New Topic",
	18 => "Admin Home",
	19 => "save",
	20 => "cancel",
	21 => "delete",
    22 => 'Default',
    23 => 'make this the default topic for new story submissions',
    24 => '(*)'
);

###############################################################################
# user.php

$LANG28 = array(
	1 => "עריכת מאפיני משתמש", # "User Editor",
	2 => "מספר זיהוי משתמש", # "User ID",
	3 => "שם משתמש", # "User Name",
	4 => "שם מלא", # "Full Name",
	5 => "סיסמא", # "Password",
	6 => "רמת אבטחה", # "Security Level",
	7 => "כתובת דואל", # "Email Address",
	8 => "אתר בית", # "Homepage",
	9 => "אסור לעשות רווחים בשדה זה!", # "(do not use spaces)",
	10 => "אנא מלא את השדות הבאים: שם משתמש, שם מלא, רמת אבטחה וכתובת דואל", # "Please fill in the Username, Full name, Security Level and Email Address fields",
	11 => "מרכז בקרה למשתמש", # "User Manager",
	12 => "To modify or delete a user, click on that user below.  To create a new user click the new user button to the left. You can do simple searches by entering parts of a username,email address or fullname (e.g.*son* or *.edu) in the form below.",
	13 => "SecLev",
	14 => "Reg. Date",
	15 => 'משתמש חדש', # 'New User',
	16 => 'Admin Home',
	17 => 'שנֶה סיסמה', # 'changepw',
	18 => 'ביטול', # 'cancel',
	19 => 'מחק', # 'delete',
	20 => 'שמור', # 'save',
	18 => 'ביטול', # 'cancel',
	19 => 'מחק', # 'delete',
	20 => 'שמור', # 'save',
    21 => 'שם המשתמש שהכנסת כבר קיים במערכת', # 'The username you tried saving already exists.',
    22 => 'שגיאה!', # 'Error',
    23 => 'Batch Add',
    24 => 'Batch Import of Users',
    25 => 'You can import a batch of users into Geeklog.  The import file must a tab-delimited text file and must have the fields in the following order: full name, username, email address.  Each user you import will be emailed with a random password.  You must have one user entered per line.  Failure to follow these instructions will cause problems that may require manual work so double check your entries!',
    26 => 'חיפוש', # 'Search',
    27 => 'סנן תוצאות', # 'Limit Results',
    28 => 'סמן כאן למחיקת התמונה', # 'Check here to delete this picture'
    29 => 'Path',
    30 => 'Import',
    31 => 'New Users',
    32 => 'Done processing. Imported %d and encountered %d failures',
    33 => 'submit',
    34 => 'Error: You must specify a file to upload.',
    35 => 'Last Login',
    36 => '(never)',
);


###############################################################################
# moderation.php

$LANG29 = array(
	1 => "אישור", # "Approve",
	2 => "מחק", # "Delete",
	3 => "עריכה", # "Edit",
	4 => 'פרופיל', # 'Profile',
  10 => "כותרת", # "Title",
  11 => "תאריך התחלה", # "Start Date",
  12 => "URL",
  13 => "קטגוריה", # "Category",
  14 => "תאריך", # "Date",
  15 => "נושא", # "Topic",
  34 => "Command and Control",
  35 => "הוספת מאמר", # "Story Submissions",
  36 => "אשר קישור", # "Link Submissions",
  37 => "אשר אירוע", # "Event Submissions",
  38 => "אישור", # "Submit",
  39 => "There are no submissions to moderate at this time",
  40 => "User Submissions",
);

###############################################################################
# calendar.php

$LANG30 = array(
	1 => "א", # "Sunday",
	2 => "ב", # "Monday",
	3 => "ג", # "Tuesday",
	4 => "ד", # "Wednesday",
	5 => "ה", # "Thursday",
	6 => "ו", # "Friday",
	7 => "שבת", # "Saturday",
	8 => "הוסף אירוע", # "Add Event",
	9 => "אירוע לינוקס", # "Geeklog Event",
	10 => "יתקיים", # "Events for",
	11 => "יומן ראשי", # "Master Calendar",
	12 => "יומן אישי", # "My Calendar",
	13 => "ינואר", # "January",
	14 => "פברואר", # "February",
	15 => "מרץ", # "March",
	16 => "אפריל", # "April",
	17 => "מאי", # "May",
	18 => "יוני", # "June",
	19 => "יולי", # "July",
	20 => "אוגוסט", # "August",
	21 => "ספטמבר", # "September",
	22 => "אוקטובר", # "October",
	23 => "נובמבר", # "November",
	24 => "דצמבר", # "December",
	25 => "חזרה ל", # "Back to ",
    26 => "יום שלם", # "All Day",
    27 => "חודש", # "Week",
    28 => "יומן אישי של", # "Personal Calendar for",
    29 => "יומן", # "Public Calendar",
    30 => "מחק אירוע", # "delete event",
    31 => "הוסף", # "Add",
    32 => "אירוע", # "Event",
    33 => "מחק", # "Date",
    34 => "שעה", # "Time",
    35 => "הוספה מהירה", # "Quick Add",
    36 => "אישור", # "Submit",
    37 => "מצטערים, האפשרות ליומן אישי לא קיימת באתר זה.", # "Sorry, the personal calendar feature is not enabled on this site",
    38 => "עריכת יומן אישי", # "Personal Event Editor"
    39 => 'יום', # 'Day',
    40 => 'שבוע', # 'Week',
    41 => '', # חודש'Month'
);

###############################################################################
# admin/mail.php
$LANG31 = array(
	1 => $_CONF['site_name'] . " Mail Utility",
 	2 => "מ", # "From",
 	3 => "השב ל", # "Reply-to",

 	4 => "נושא", # "Subject",
 	5 => "גוף ההודעה", # "Body",
 	6 => "שלך ל", # "Send to:",
 	7 => "כל המשתמשים", # "All users",
 	8 => "אדמיניסטרטור", # "Admin",
	9 => "אפשרויות", # "Options",
	10 => "HTML",
 	11 => "הודעה דחופה", # "Urgent message!",
 	12 => "שלח", # "Send",
 	13 => "מחק והתחל מחדש", # "Reset",
 	14 => "התעלם מהגדרות משתמש", # "Ignore user settings",
 	15 => "ארעה שגיעה במשלוח ההודעה ל", # "Error when sending to: ",
	16 => "הודעה נשלחה בהצלחה ל", # "Successfully sent messages to: ",
	17 => "<a href=" . $_CONF["site_url"] . "/admin/mail.php>Send another message</a>",
    18 => "כתובת דואל", # "To",
    19 => "NOTE: if you wish to send a message to all site members, select the Logged-in Users group from the drop down.",
    20 => "Successfully sent <successcount> messages and unsuccessfully sent <failcount> messages.  If you need them, the details of each message attempts is below.  Otherwise you can <a href=\"" . $_CONF['site_url'] . "/admin/mail.php\">Send another message</a> or you can <a href=\"" . $_CONF['site_url'] . "/admin/moderation.php\">go back to the administration page</a>.",
    21 => 'כישלון', # 'Failures',
    22 => 'בהצלחה', # 'Successes',
    23 => 'אין כישלונות', # 'No failures',
    24 => 'אין הצלחות', # 'No successes'
    25 => '-- בחר קבוצה--', # '-- Select Group --',
26 => "Please fill in all the fields on the form and select a group of users from the drop down."
);


###############################################################################
# confirmation and error messages

$MESSAGE = array (
	1 => "Your password has been emailed to you and should arrive momentarily. Please follow the directions in the message and we thank-you for using " . $_CONF["site_name"],
	2 => "Thank-you for submitting your story to {$_CONF["site_name"]}.  It has been submitted to our staff for approval. If approved, your story will be available for others to read on our site.",
	3 => "Thank-you for submitting a link to {$_CONF["site_name"]}.  It has been submitted to our staff for approval.  If approved, your link will be seen in the <a href={$_CONF["site_url"]}/links.php>links</a> section.",
	4 => "Thank-you for submitting an event to {$_CONF["site_name"]}.  It has been submitted to our staff for approval.  If approved, your event will be seen in our <a href={$_CONF["site_url"]}/calendar.php>calendar</a> section.",
	5 => "Your account information has been successfully saved.",
	6 => "Your display preferences have been successfully saved.",
	7 => "Your comment preferences have been successfully saved.",
	8 => "יצאת מהמערכת בהצלחה.", # "You have been successfully logged out.",
	9 => "ההודעה שלך נשמרה בהצלחה", # "Your story has been successfully saved.",
	10 => "The story has been successfully deleted.",
	11 => "Your block has been successfully saved.",
	12 => "The block has been successfully deleted.",
	13 => "Your topic has been successfully saved.",
	14 => "The topic and all it's stories and blocks have been successfully deleted.",
	15 => "Your link has been successfully saved.",
	16 => "The link has been successfully deleted.",
	17 => "Your event has been successfully saved.",
	18 => "The event has been successfully deleted.",
	19 => "Your poll has been successfully saved.",
	20 => "The poll has been successfully deleted.",
	21 => "The new user has been successfully saved.",
	22 => "The user has been successfully deleted",
	23 => "Error trying to add an event to your calendar. There was no event id passed.",
	24 => "The event has been saved to your calendar",
	25 => "Cannot open your personal calendar until you login",
	26 => "Event was successfully removed from your personal calendar",
	27 => "ההודעה נשלחה בהצלחה!", # "Message successfully sent.",
	28 => "The plug-in has been successfully saved",
	29 => "Sorry, personal calendars are not enabled on this site",
	30 => "Access Denied",
	31 => "Sorry, you do not have access to the story administration page.  Please note that all attempts to access unauthorized features are logged",
	32 => "Sorry, you do not have access to the topic administration page.  Please note that all attempts to access unauthorized features are logged",
	33 => "Sorry, you do not have access to the block administration page.  Please note that all attempts to access unauthorized features are logged",
	34 => "Sorry, you do not have access to the link administration page.  Please note that all attempts to access unauthorized features are logged",
	35 => "Sorry, you do not have access to the event administration page.  Please note that all attempts to access unauthorized features are logged",
	36 => "Sorry, you do not have access to the poll administration page.  Please note that all attempts to access unauthorized features are logged",
	37 => "Sorry, you do not have access to the user administration page.  Please note that all attempts to access unauthorized features are logged",
	38 => "Sorry, you do not have access to the plugin administration page.  Please note that all attempts to access unauthorized features are logged",
	39 => "Sorry, you do not have access to the mail administration page.  Please note that all attempts to access unauthorized features are logged",
	40 => "הודעת מערכת", # "System Message",
    41 => "Sorry, you do not have access to the word replacement page.  Please note that all attempts to access unauthorized features are logged",
    42 => "Your word has been successfully saved.",
	43 => "The word has been successfully deleted.",
    44 => 'The plug-in was successfully installed!',
    45 => 'The plug-in was successfully deleted.',
    46 => "Sorry, you do not have access to the database backup utility.  Please note that all attempts to access unauthorized features are logged",
    47 => "This functionality only works under *nix.  If you are running *nix as your operating system then your cache has been successfully cleared. If you are on Windows, you will need to search for files name adodb_*.php and remove them manually.",
    48 => 'Thank you for applying for a membership with ' . $_CONF['site_name'] . '. Our team will review your application. If approved, your password will be emailed to you at the email address you just entered.',
    49 => "Your group has been successfully saved.",
    50 => "The group has been successfully deleted.",
    51 => 'This username is already in use. Please choose another one.',
    52 => 'The email address provided does not appear to be a valid email address.',
    53 => 'Your new password has been accepted. Please use your new password below to log in now.',
    54 => 'Your request for a new password has expired. Please try again below.',
    55 => 'An email has been sent to you and should arrive momentarily. Please follow the directions in the message to set a new password for your account.',
    56 => 'The email address provided is already in use for another account.',
    57 => 'Your account has been successfully deleted.'
);

// for plugins.php

$LANG32 = array (
	1 => "Installing plugins could possibly cause damage to your Geeklog installation and, possibly, to your system.  It is important that you only install plugins downloaded from the <a href=\"http://www.geeklog.net\" target=\"_blank\">Geeklog Homepage</a> as we thoroughly test all plugins submitted to our site on a variety of operating systems.  It is important that you understand that the plugin installation process will require the execution of a few filesystem commands which could lead to security problems particularly if you use plugins from third party sites.  Even with this warning you are getting, we do not gaurantee the success of any installation nor are we liable for damage caused by installing a Geeklog plugin.  In other words, install at your own risk.  For the wary, directions on how to manually install a plugin is included with each plugin package.",
	2 => "Plug-in Installation Disclaimer",
	3 => "Plug-in Installation Form",
	4 => "Plug-in File",
	5 => "Plug-in List",
	6 => "Warning: Plug-in Already Installed!",
	7 => "The plug-in you are trying to install already exists.  Please delete the plugin before re-installing it",
	8 => "Plugin Compatibility Check Failed",
	9 => "This plugin requires a newer version of Geeklog. Either upgrade your copy of <a href=\"http://www.geeklog.net\">Geeklog</a> or get a newer version of the plug-in.",
	10 => "<br><b>There are no plugins currently installed.</b><br><br>",
	11 => "To modify or delete a plug-in, click on that plug-in's number below. To learn more about a plug-in, click the plug-in name and you will be directed to that plug-in's website. To install or upgrade a plug-in please consult it's documentation.",
	12 => 'no plugin name provided to plugineditor()',
	13 => 'Plugin Editor',
	14 => 'New Plug-in',
	15 => 'Admin Home',
	16 => 'Plug-in Name',
	17 => 'Plug-in Version',
		18 => 'גרסה', # 'Geeklog Version',
	19 => 'אפשר', # 'Enabled',
	20 => 'כן', # 'Yes',
	21 => 'לא', # 'No',
	22 => 'התקן', # 'Install',
    23 => 'שמור', # 'Save',
    24 => 'ביטול', # 'Cancel',
    25 => 'מחק', # 'Delete',
    26 => 'Plug-in Name',
    27 => 'Plug-in Homepage',
    28 => 'Plug-in Version',
    29 => 'גרסה', # 'Geeklog Version',
    30 => 'Delete Plug-in?',
    31 => 'Are you sure you want to delete this plug-in?  By doing so you will remove all the data and data structures that this plug-in uses.  If you are sure, click delete again on the form below.'
);

$LANG_ACCESS = array(
	access => "Access",
    ownerroot => "Owner/Root",
    group => "Group",
    readonly => "Read-Only",
	accessrights => "Access Rights",
	owner => "Owner",
	grantgrouplabel => "Grant Above Group Edit Rights",
	permmsg => "NOTE: members is all logged in members of the site and anonymous is all users browsing the site that aren't logged in.",
	securitygroups => "Security Groups",
	editrootmsg => "Even though you are a User Administrator, you can't edit a root user without first being a root user yourself.  You can edit all other users except root users. Please note that all attempts to illegally edit root users are logged.  Please go back to the <a href=\"{$_CONF["site_admin_url"]}/user.php\">User Administration page</a>.",
	securitygroupsmsg => "Select the checkboxes for the groups you want the user to belong to.",
	groupeditor => "Group Editor",
	description => "Description",
	name => "Name",
 	rights => "Rights",
	missingfields => "Missing Fields",
	missingfieldsmsg => "You must supply the name and a description for a group",
	groupmanager => "Group Manager",
	newgroupmsg => "To modify or delete a group, click on that group below. To create a new group click new group above. Please note that core groups cannot be deleted because they are used in the system.",
	groupname => "Group Name",
	coregroup => "Core Group",
	yes => "Yes",
	no => "No",
	corerightsdescr => "This group is a core {$_CONF["site_name"]} Group.  Therefore the rights for this group cannot be edited.  Below is a read-only list of the rights this group has access to.",
	groupmsg => "Security Groups on this site are hierarchical.  By adding this group to any of the groups below you will giving this group the same rights that those groups have.  Where possible it is encouraged you use the groups below to give rights to a group.  If you need this group to have custom rights then you can select the rights to various site features in the section below called 'Rights'.  To add this group to any of the ones below simply check the box next to the group(s) that you want.",
	coregroupmsg => "This group is a core {$_CONF["site_name"]} Group.  Therefore the groups that this groups belongs to cannot be edited.  Below is a read-only list of the groups this group belongs to.",
	rightsdescr => "A groups access to a certain right below can be given directly to the group OR to a different group that this group is a part of.  The ones you see below without a checkbox are the rights that have been given to this group because it belongs to another group with that right.  The rights with checkboxes below are rights that can be given directly to this group.",
	lock => "נעולה", # "Lock",
	members => "חברים רשומים באתר", # "Members",
	anonymous => "אורח/ת באתר", # "Anonymous",
	permissions => "הרשאה", # "Permissions",
	permissionskey => "R = read, E = edit, edit rights assume read rights",
	edit => "עריכה", # "Edit",
	none => "אין", # "None",
	accessdenied => "אין לך הרשאות כניסה!", # "Access Denied",
	storydenialmsg => "You do not have access to view this story.  This could be because you aren't a member of {$_CONF["site_name"]}.  Please <a href=users.php?mode=new> become a member</a> of {$_CONF["site_name"]} to receive full membership access!",
	eventdenialmsg => "You do not have access to view this event.  This could be because you aren't a member of {$_CONF["site_name"]}.  Please <a href=users.php?mode=new> become a member</a> of {$_CONF["site_name"]} to receive full membership access!",
	nogroupsforcoregroup => "This group doesn't belong to any of the other groups",
	grouphasnorights => "This group doesn't have access to any of the administrative features of this site",
	newgroup => 'New Group',
	adminhome => 'Admin Home',
	save => 'save',
	cancel => 'cancel',
	delete => 'delete',
	canteditroot => 'You have tried to edit the Root group but you are not in the Root group yourself therefore your access to this group is denied.  Please contact the system administrator if you feel this is an error',
    listusers => 'List Users',
    listthem => 'list',
    usersingroup => 'Users in group %s'
);

#admin/word.php
$LANG_WORDS = array(
    editor => "Word Replacment editor",
    wordid => "Word ID",
    intro => "To modify or delete a word, click on that word.  To create a new word replacement click the new word button to the left.",
    wordmanager => "Word Manager",
    word => "Word",
    replacmentword => "Replacment Word",
    newword => "New Word"
);

$LANG_DB_BACKUP = array(
    last_ten_backups => 'Last 10 Back-ups',
    do_backup => 'Do Backup',
    backup_successful => 'Database back up was successful.',
    no_backups => 'No backups in the system',
    db_explanation => 'To create a new backup of your Geeklog system, hit the button below',
    not_found => "Incorrect path or mysqldump utility not executable.<br>Check <strong>\$_DB_mysqldump_path</strong> definition in config.php.<br>Variable currently defined as: <var>{$_DB_mysqldump_path}</var>",
    zero_size => 'Backup Failed: Filesize was 0 bytes',
    path_not_found => "{$_CONF['backup_path']} does not exist or is not a directory",
    no_access => "ERROR: Directory {$_CONF['backup_path']} is not accessible.",
    backup_file => 'Backup file',
    size => 'Size',
    bytes => 'Bytes',
    total_number => 'Total number of backups: %d'
);

$LANG_BUTTONS = array(
    1 => "דף הבית", # "Home",
    2 => "צור קשר", # "Contact",
    3 => "כתיבת הודעה/מאמר", # "Get Published",
    4 => "קישורים", # "Links",
    5 => "סקרים", # "Polls",
    6 => "יומן", # "Calendar",
    7 => "סטטיסטיקה", # "Site Stats",
    8 => "התאמה אישית", # "Personalize",
    9 => "חיפוש", # "Search",
    10 => "חיפוש מתקדם", # "advanced search"
);

$LANG_404 = array(
    1 => "404 Error",
    2 => "Gee, I've looked everywhere but I can not find <b>%s</b>.",
    3 => "<p>We're sorry, but the file you have requested does not exist. Please feel free to check the <a href=\"{$_CONF['site_url']}\">main page</a> or the <a href=\"{$_CONF['site_url']}/search.php\">search page</a> to see if you can find what you lost."
);

$LANG_LOGIN = array (
    1 => 'כדי לבצע פעולה זו הנך נדרש להתחבר', # 'Login required',
    2 => 'כדי להיכנס לאזור זה, הנך נדרש/ת להתחבר כמשתמש', # Sorry, to access this area you need to be logged in as a user.',
    3 => 'כניסה', # 'Login',
    4 =>  'משתמש חדש', #'New User'
);

?>
