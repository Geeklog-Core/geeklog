<?php

###############################################################################
# english.php
# This is the english language page for GeekLog!
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

$LANG_CHARSET = "iso-8859-1";

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
	1 => "Contributed by:",
	2 => "read more",
	3 => "comments",
	4 => "Edit",
	5 => "Vote",
	6 => "Results",
	7 => "Poll Results",
	8 => "votes",
	9 => "Admin Functions:",
	10 => "Submissions",
	11 => "Stories",
	12 => "Blocks",
	13 => "Topics",
	14 => "Links",
	15 => "Events",
	16 => "Polls",
	17 => "Users",
	18 => "SQL Query",
	19 => "Log Out",
	20 => "User Information:",
	21 => "Username",
	22 => "User ID",
	23 => "Security Level",
	24 => "Anonymous",
	25 => "Reply",
	26 => "The following comments are owned by whoever posted them. This site is not responsible for what they say.",
	27 => "Most Recent Post",
	28 => "Delete",
	29 => "No user comments.",
	30 => "Older Stories",
	31 => "Allowed HTML Tags:",
	32 => "Error, invalid username",
	33 => "Error, could not write to the log file",
	34 => "Error",
	35 => "Logout",
	36 => "on",
	37 => "No user stories",
	38 => "",
	39 => "Refresh",
	40 => "",
	41 => "Guest Users",
	42 => "Authored by:",
	43 => "Reply to This",
	44 => "Parent",
	45 => "MySQL Error Number",
	46 => "MySQL Error Message",
	47 => "User Functions",
	48 => "Account Information",
	49 => "Display Preferences",
	50 => "Error with SQL statement",
	51 => "help",
	52 => "New",
	53 => "Admin Home",
	54 => "Could not open the file.",
	55 => "Error at",
	56 => "Vote",
	57 => "Password",
	58 => "Login",
	59 => "Don't have an account yet?  Sign up as a <a href=\"{$_CONF['site_url']}/users.php?mode=new\">New User</a>",
	60 => "Post a comment",
	61 => "Create New Account",
	62 => "words",
	63 => "Comment Preferences",
	64 => "Email Article To a Friend",
	65 => "View Printable Version",
	66 => "My Calendar",
	67 => "Welcome to ",
	68 => "home",
	69 => "contact",
	70 => "search",
	71 => "contribute",
	72 => "web resources",
	73 => "past polls",
	74 => "calendar",
	75 => "advanced search",
	76 => "site statistics",
	77 => "Plugins",
	78 => "Upcoming Events",
	79 => "What's New",
	80 => "stories in last",
	81 => "story in last",
	82 => "hours",
	83 => "COMMENTS",
	84 => "LINKS",
	85 => "last 48 hrs",
	86 => "No new comments",
	87 => "last 2 wks",
	88 => "No recent new links",
	89 => "There are no upcoming events",
	90 => "Home",
	91 => "Created this page in",
	92 => "seconds",
	93 => "Copyright",
	94 => "All trademarks and copyrights on this page are owned by their respective owners.",
	95 => "Powered By",
	96 => "Groups",
    97 => "Word List",
	98 => "Plug-ins",
	99 => "STORIES",
    100 => "No new stories",
    101 => 'Your Events',
    102 => 'Site Events',
    103 => 'DB Backups',
    104 => 'by',
    105 => 'Mail Users',
    106 => 'Views',
    107 => 'GL Version Test',
    108 => 'Clear Cache'
);

###############################################################################
# calendar.php

$LANG02 = array(
	1 => "Calendar of Events",
	2 => "I'm Sorry, there are no events to display.",
	3 => "When",
	4 => "Where",
	5 => "Description",
	6 => "Add A Event",
	7 => "Upcoming Events",
	8 => 'By adding this event to your calendar you can quickly view only the events you are interested in by clicking "My Calendar" from the User Functions area.',
	9 => "Add to My Calendar",
	10 => "Remove from My Calendar",
	11 => "Adding Event to {$_USER['username']}'s Calendar",
	12 => "Event",
	13 => "Starts",
	14 => "Ends",
        15 => "Back to Calendar"
);

###############################################################################
# comment.php

$LANG03 = array(
	1 => "Post a Comment",
	2 => "Post Mode",
	3 => "Logout",
	4 => "Create Account",
	5 => "Username",
	6 => "This site requires you to be logged in to post a comment, please log in.  If you do not have an account you can use the form below to create one.",
	7 => "Your last comment was ",
	8 => " seconds ago.  This site requires at least {$_CONF["commentspeedlimit"]} seconds between comments",
	9 => "Comment",
	10 => '',
	11 => "Submit Comment",
	12 => "Please fill in the Title and Comment fields, as they are necessary for your submission of a comment.",
	13 => "Your Information",
	14 => "Preview",
	15 => "",
	16 => "Title",
	17 => "Error",
	18 => 'Important Stuff',
	19 => 'Please try to keep posts on topic.',
	20 => 'Try to reply to other people comments instead of starting new threads.',
	21 => 'Read other people\'s messages before posting your own to avoid simply duplicating what has already been said.',
	22 => 'Use a clear subject that describes what your message is about.',
	23 => 'Your email address will NOT be made public.',
	24 => 'Anonymous User'
);

###############################################################################
# users.php

$LANG04 = array(
	1 => "User Profile for",
	2 => "User Name",
	3 => "Full Name",
	4 => "Password",
	5 => "Email",
	6 => "Homepage",
	7 => "Bio",
	8 => "PGP Key",
	9 => "Save Information",
	10 => "Last 10 comments for user",
	11 => "No User Comments",
	12 => "User Preferences for",
	13 => "Email Nightly Digest",
	14 => "This password is generated by a randomizer. It is recommended that you change this password immediately. To change your password, log in and then click Account Information from the User Functions menu.",
	15 => "Your {$_CONF["site_name"]} account has been created successfully. To be able to use it, you must login using the information below. Please save this mail for further reference.",
	16 => "Your Account Information",
	17 => "Account does not exist",
	18 => "The email address provided does not appear to be a valid email address",
	19 => "The username or email address provided already exists",
	20 => "The email address provided does not appear to be a valid email address",
	21 => "Error",
	22 => "Register with {$_CONF['site_name']}!",
	23 => "Creating a user account will give you all the benefits of {$_CONF['site_name']} membership and it will allow you to post comments and submit items as yourself. If you don't have an account, you will only be able to post anonymously. Please note that your email address will <b><i>never</i></b> be publicly displayed on this site.",
	24 => "Your password will be sent to the email address you enter.",
	25 => "Did You Forget Your Password?",
	26 => "Enter your username and click Email Password and a new password will be mailed to the email address on record.",
	27 => "Register Now!",
	28 => "Email Password",
	29 => "logged out from",
	30 => "logged in from",
	31 => "The function you have selected requires you to be logged in",
	32 => "Signature",
	33 => "Never publicly displayed",
	34 => "This is your real name",
	35 => "Enter password to change it",
	36 => "Begins with http://",
	37 => "Applied to your comments",
	38 => "It's all about you! Everyone can read this",
	39 => "Your public PGP key to share",
	40 => "No Topic Icons",
	41 => "Willing to Moderate",
	42 => "Date Format",
	43 => "Maximum Stories",
	44 => "No boxes",
	45 => "Display Preferences for",
	46 => "Excluded Items for",
	47 => "News box Configuration for",
	48 => "Topics",
	49 => "No icons in stories",
	50 => "Uncheck this if you aren't interested",
	51 => "Just the news stories",
	52 => "The default is",
	53 => "Receive the days stories every night",
	54 => "Check the boxes for the topics and authors you don't want to see.",
	55 => "If you leave these all unchecked, it means you want the default selection of boxes. If you start selecting boxes, remember to set all of them that you want because the default selection will be ignored. Default entries are displayed in bold.",
	56 => "Authors",
	57 => "Display Mode",
	58 => "Sort Order",
	59 => "Comment Limit",
	60 => "How do you like your comments displayed?",
	61 => "Newest or oldest first?",
	62 => "The default is 100",
	63 => "Your password has been emailed to you and should arrive momentarily. Please follow the directions in the message and we thank-you for using " . $_CONF["site_name"],
	64 => "Comment Preferences for",
	65 => "Try Logging in Again",
	66 => "You may have mistyped your login credentials.  Please try logging in again below. Are you a <a href=\"{$_CONF['site_url']}/users.php?mode=new\">new user</a>?",
	67 => "Member Since",
	68 => "Remember Me For",
	69 => "How long should we remember you after logging in?",
	70 => "Customize the layout and content of {$_CONF['site_name']}",
	71 => "One of the great features of {$_CONF['site_name']} is you can customize the content you get and you can change the overall layout of this site.  In order to take advantage of these great features you must first <a href=\"{$_CONF['site_url']}/users.php?mode=new\">register</a> with {$_CONF['site_name']}.  Are you already a member?  Then use the login form to the left to log in!",
    72 => "Theme",
    73 => "Language",
    74 => "Change what this site looks like!",
    75 => "Emailed Topics for",
    76 => "If you select a topic from the list below you will receive any new stories posted to that topic at the end of each day.  Choose only the topics that interest you!",
    77 => "Photo",
    78 => "Add a picture of yourself!",
    79 => "Check here to delete this picture",
    80 => "Login",
    81 => "Send Email",
    82 => 'Last 10 stories for user',
    83 => 'Posting statistics for user',
    84 => 'Total number of articles:',
    85 => 'Total number of comments:',
    86 => 'Find all postings by'
);

###############################################################################
# index.php

$LANG05 = array(
	1 => "No News to Display",
	2 => "There are no news stories to display.  There may be no news for this topic or your user preferences may be too restrictive",
	3 => " for topic $topic",
	4 => "Today's Featured Article",
	5 => "Next",
	6 => "Previous"
);

###############################################################################
# links.php

$LANG06 = array(
	1 => "Web Resources",
	2 => "There are no resources to display.",
	3 => "Add A Link"
);

###############################################################################
# pollbooth.php

$LANG07 = array(
	1 => "Vote Saved",
	2 => "Your vote was saved for the poll",
	3 => "Vote",
	4 => "Polls in System",
	5 => "Votes"
);

###############################################################################
# profiles.php

$LANG08 = array(
	1 => "There was an error sending your message. Please try again.",
	2 => "Message sent successfully.",
	3 => "Please make sure you use a valid email address in the Reply To field.",
	4 => "Please fill in the Your Name, Reply To, Subject and Message fields",
	5 => "Error: No such user.",
	6 => "There was an error.",
	7 => "User Profile for",
	8 => "User Name",
	9 => "User URL",
	10 => "Send mail to",
	11 => "Your Name:",
	12 => "Reply To:",
	13 => "Subject:",
	14 => "Message:",
	15 => "HTML will not be translated.",
	16 => "Send Message",
	17 => "Mail Story to a Friend",
	18 => "To Name",
	19 => "To Email Address",
	20 => "From Name",
	21 => "From Email Address",
	22 => "All fields are required",
	23 => "This email was sent to you by $from at $fromemail because they thought you might be interested it this article from {$_CONF["site_url"]}.  This is not SPAM and the email addresses involved in this transaction were not saved to a list or stored for later use.",
	24 => "Comment on this story at",
	25 => "You must be logged in to user this feature.  By having you log in, it helps us prevent misuse of the system",
	26 => "This form will allow you to send an email to the selected user.  All fields are required.",
	27 => "Short message",
	28 => "$from wrote: $shortmsg",
    29 => "This is the daily digest from {$_CONF['site_name']} for ",
    30 => " Daily Newsletter for ",
    31 => "Title",
    32 => "Date",
    33 => "Read the full article at",
    34 => "End of Message"
);

###############################################################################
# search.php

$LANG09 = array(
	1 => "Advanced Search",
	2 => "Key Words",
	3 => "Topic",
	4 => "All",
	5 => "Type",
	6 => "Stories",
	7 => "Comments",
	8 => "Authors",
	9 => "All",
	10 => "Search",
	11 => "Search Results",
	12 => "matches",
	13 => "Search Results: No matches",
	14 => "There were no matches for your search on",
	15 => "Please try again.",
	16 => "Title",
	17 => "Date",
	18 => "Author",
	19 => "Search the entire {$_CONF["site_name"]} database of current and past news stories",
	20 => "Date",
	21 => "to",
	22 => "(Date Format MM-DD-YYYY)",
	23 => "Hits",
	24 => "Found",
	25 => "matches for",
	26 => "items in",
	27 => "seconds",
    28 => 'No story or comment matches for your search',
    29 => 'Story and Comment Results',
    30 => 'No links matched your search',
    31 => 'This plug-in returned no matches',
    32 => 'Event',
    33 => 'URL',
    34 => 'Location',
    35 => 'All Day',
    36 => 'No events matched your search',
    37 => 'Event Results',
    38 => 'Link Results',
    39 => 'Links',
    40 => 'Events'
);

###############################################################################
# stats.php

$LANG10 = array(
	1 => "Site Statistics",
	2 => "Total Hits to the System",
	3 => "Stories(Comments) in the System",
	4 => "Polls(Answers) in the System",
	5 => "Links(Clicks) in the System",
	6 => "Events in the System",
	7 => "Top Ten Viewed Stories",
	8 => "Story Title",
	9 => "Views",
	10 => "It appears that there are no stories on this site or no one has ever viewed them.",
	11 => "Top Ten Commented Stories",
	12 => "Comments",
	13 => "It appears that there are no stories on this site or no one has ever posted a comment on them.",
	14 => "Top Ten Polls",
	15 => "Poll Question",
	16 => "Votes",
	17 => "It appears that there are no polls on this site or no one has ever voted.",
	18 => "Top Ten Links",
	19 => "Links",
	20 => "Hits",
	21 => "It appears that there are no links on this site or no one has ever clicked on one.",
	22 => "Top Ten Emailed Stories",
	23 => "Emails",
	24 => "It appears that no one has emailed a story on this site"
);

###############################################################################
# article.php

$LANG11 = array(
	1 => "What's Related",
	2 => "Mail Story to a Friend",
	3 => "Printable Story Format",
	4 => "Story Options"
);

###############################################################################
# submit.php

$LANG12 = array(
	1 => "To submit a $type you are required to be logged in as a user.",
	2 => "Login",
	3 => "New User",
	4 => "Submit a Event",
	5 => "Submit a Link",
	6 => "Submit a Story",
	7 => "Login is Required",
	8 => "Submit",
	9 => "When submitting information for use on this site we ask that you follow the following suggestions...<ul><li>Fill in all the fields, they're required<li>Provide complete and accurate information<li>Double check those URLs</ul>",
	10 => "Title",
	11 => "Link",
	12 => "Start Date",
	13 => "End Date",
	14 => "Location",
	15 => "Description",
	16 => "If other, please specify",
	17 => "Category",
	18 => "Other",
	19 => "Read First",
	20 => "Error: Missing Category",
	21 => "When selecting \"Other\" please also provide a category name",
	22 => "Error: Missing Fields",
	23 => "Please fill in all the fields on the form.  All fields are required.",
	24 => "Submission Saved",
	25 => "Yours $type submission has been saved successfully.",
	26 => "Speed Limit",
	27 => "Username",
	28 => "Topic",
	29 => "Story",
	30 => "Your last submission was ",
	31 => " seconds ago.  This site requires at least {$_CONF["speedlimit"]} seconds between submissions",
	32 => "Preview",
	33 => "Story Preview",
	34 => "Log Out",
	35 => "HTML tags are not allowed",
	36 => "Post Mode",
	37 => "Submitting an event to {$_CONF["site_name"]} will put your event on the master calendar where users can optionally add your event to their personal calendar. This feature is <b>NOT</b> meant to store your personal events such as birthdays and anniversaries.<br><br>Once you submit your event it will be sent to our administrators and if approved, your event will appear on the master calendar.",
    38 => "Add Event To",
    39 => "Master Calendar",
    40 => "Personal Calendar",
    41 => "End Time",
    42 => "Start Time",
    43 => "All Day Event",
    44 => 'Address Line 1',
    45 => 'Address Line 2',
    46 => 'City/Town',
    47 => 'State',
    48 => 'Zip Code',
    49 => 'Event Type',
    50 => 'Edit Event Types',
    51 => 'Location',
    52 => 'Delete',
    53 => 'Create Account'
);


###############################################################################
# ADMIN PHRASES - These are file phrases used in end admin scripts
###############################################################################

###############################################################################
# auth.inc.php

$LANG20 = array(
	1 => "Authentication Required",
	2 => "Denied! Incorrect Login Information",
	3 => "Invalid password for user",
	4 => "Username:",
	5 => "Password:",
	6 => "All access to administrative portions of this web site are logged and reviewed.<br>This page is for the use of authorized personnel only.",
	7 => "login"
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
	10 => "Block Type",
	11 => "Portal Block",
	12 => "Normal Block",
	13 => "Portal Block Options",
	14 => "RDF URL",
	15 => "Last RDF Update",
	16 => "Normal Block Options",
	17 => "Block Content",
	18 => "Please fill in the Block Title, Security Level and Content fields",
	19 => "Block Manager",
	20 => "Block Title",
	21 => "Block SecLev",
	22 => "Block Type",
	23 => "Block Order",
	24 => "Block Topic",
	25 => "To modify or delete a block, click on that block below.  To create a new block click on new block above.",
	26 => "Layout Block",
	27 => "PHP Block",
    28 => "PHP Block Options",
    29 => "Block Function",
    30 => "If you would like to have one of your blocks use PHP code, enter the name of the function above.  Your function name must start with the prefix \"phpblock_\" (e.g. phpblock_getweather).  If it does not have this prefix, your function will NOT be called.  We do this to keep people who may have hacked your Geeklog installation from putting arbitrary function calls that may be harmful to your system.  Be sure not to put empty parenthisis \"()\" after your function name.  Finally, it is recommended that you put all your PHP Block code in /path/to/geeklog/system/lib-custom.php.  That will allow the code to stay with you even when you upgrade to a newer version of Geeklog.",
    31 => "Error in PHP Block.  Function, $function, does not exist.",
    32 => "Error Missing Field(s)",
    33 => "You must enter the URL to the .rdf file for portal blocks",
    34 => "You must enter the title and the function for PHP blocks",
    35 => "You must enter the title and the content for normal blocks",
    36 => "You must enter the content for layout blocks",
    37 => "Bad PHP block function name",
    38 => "Functions for PHP Blocks must have the prefix 'phpblock_' (e.g. phpblock_getweather).  The 'phpblock_' prefix is required for security reasons to prevent the execution of arbitrary code.",
	39 => "Side",
	40 => "Left",
	41 => "Right",
	42 => "You must enter the blockorder and security level for Geeklog default blocks",
	43 => "Homepage Only",
	44 => "Access Denied",
	45 => "You are trying to access a block that you don't have rights to.  This attempt has been logged. Please <a href=\"{$_CONF["site_admin_url"]}/block.php\">go back to the block administration screen</a>.",
	46 => 'New Block',
	47 => 'Admin Home',
    48 => 'Block Name',
    49 => ' (no spaces and must be unique)',
    50 => 'Help File URL',
    51 => 'include http://',
    52 => 'If you leave this blank the help icon for this block will not be displayed',
    53 => 'Enabled',
    54 => 'save',
    55 => 'cancel',
    56 => 'delete'
);

###############################################################################
# event.php

$LANG22 = array(
	1 => "Event Editor",
	2 => "",
	3 => "Event Title",
	4 => "Event URL",
	5 => "Event Start Date",
	6 => "Event End Date",
	7 => "Event Location",
	8 => "Event Description",
	9 => "(include http://)",
	10 => "You must provide the dates/times, description and event location!",
	11 => "Event Manager",
	12 => "To modify or delete a event, click on that event below.  To create a new event click on new event above.",
	13 => "Event Title",
	14 => "Start Date",
	15 => "End Date",
	16 => "Access Denied",
	17 => "You are trying to access an event that you don't have rights to.  This attempt has been logged. Please <a href=\"{$_CONF["site_admin_url"]}/event.php\">go back to the event administration screen</a>.",
	18 => 'New Event',
	19 => 'Admin Home',
    20 => 'save',
    21 => 'cancel',
    22 => 'delete'
);

###############################################################################
# link.php

$LANG23 = array(
	1 => "Link Editor",
	2 => "",
	3 => "Link Title",
	4 => "Link URL",
	5 => "Category",
	6 => "(include http://)",
	7 => "Other",
	8 => "Link Hits",
	9 => "Link Description",
	10 => "You need to provide a link Title, URL and Description.",
	11 => "Link Manager",
	12 => "To modify or delete a link, click on that link below.  To create a new link click new link above.",
	13 => "Link Title",
	14 => "Link Category",
	15 => "Link URL",
	16 => "Access Denied",
	17 => "You are trying to access a link that you don't have rights to.  This attempt has been logged. Please <a href=\"{$_CONF["site_admin_url"]}/link.php\">go back to the link administration screen</a>.",
	18 => 'New Link',
	19 => 'Admin Home',
	20 => 'If other, specify',
    21 => 'save',
    22 => 'cancel',
    23 => 'delete'
);

###############################################################################
# story.php

$LANG24 = array(
	1 => "Previous Stories",
	2 => "Next Stories",
	3 => "Mode",
	4 => "Post Mode",
	5 => "Story Editor",
	6 => "There are no stories in the system",
	7 => "Author",
	8 => "save",
	9 => "preview",
	10 => "cancel",
	11 => "delete",
	12 => "",
	13 => "Title",
	14 => "Topic",
	15 => "Date",
	16 => "Intro Text",
	17 => "Body Text",
	18 => "Hits",
	19 => "Comments",
	20 => "",
	21 => "",
	22 => "Story List",
	23 => "To modify or delete a story, click on that story's number below. To view a story, click on the title of the story you wish to view. To create a new story click on new story above.",
	24 => "",
	25 => "",
	26 => "Story Preview",
	27 => "",
	28 => "",
	29 => "",
	30 => "",
	31 => "Please fill in the Author, Title and Intro Text fields",
	32 => "Featured",
	33 => "There can only be one featured story",
	34 => "Draft",
	35 => "Yes",
	36 => "No",
	37 => "More by",
	38 => "More from",
	39 => "Emails",
	40 => "Access Denied",
	41 => "You are trying to access a story that you don't have rights to.  This attempt has been logged.  You may view the article in read-only below. Please <a href=\"{$_CONF["site_admin_url"]}/story.php\">go back to the story administration screen</a> when you are done.",
	42 => "You are trying to access a story that you don't have rights to.  This attempt has been logged.  Please <a href=\"{$_CONF["site_admin_url"]}/story.php\">go back to the story administration screen</a>.",
	43 => 'New Story',
	44 => 'Admin Home',
	45 => 'Access',
    46 => '<b>NOTE:</b> if you modify this date to be in the future, this article will not be published until that date.  That also means the story will not be included in your RDF headline feed and it will be ignored by the search and statistics pages.',
    47 => 'Images',
    48 => 'image',
    49 => 'right',
    50 => 'left',
    51 => 'To add one of the images you are attaching to this article you need to insert specially formated text.  The specially formated text is [imageX], [imageX_right] or [imageX_left] where X is the number of the image you have attached.  NOTE: You must use the images you attach.  If you do not you will be unable to save your story.<BR><P><B>PREVIEWING</B>: Previewing a story with images attached is best done by saving the article as a draft INSTEAD OF hitting the preview button.  Use the preview button only when images are not attached.',
    52 => 'Delete',
    53 => 'was not used.  You must include this image in the intro or body before you can save your changes',
    54 => 'Attached Images Not Used',
    55 => 'The following errors occured while trying to save your story.  Please correct these errors before saving',
    56 => 'Show Topic Icon'
);

###############################################################################
# poll.php

$LANG25 = array(
	1 => "Mode",
	2 => "",
	3 => "Poll Created",
	4 => "Poll $qid saved",
	5 => "Edit Poll",
	6 => "Poll ID",
	7 => "(do not use spaces)",
	8 => "Appears on Homepage",
	9 => "Question",
	10 => "Answers / Votes",
	11 => "There was an error getting poll answer data about the poll $qid",
	12 => "There was an error getting poll question data about the poll $qid",
	13 => "Create Poll",
	14 => "save",
	15 => "cancel",
	16 => "delete",
	17 => "",
	18 => "Poll List",
	19 => "To modify or delete a poll, click on that poll.  To create a new poll click on new poll above.",
	20 => "Voters",
	21 => "Access Denied",
	22 => "You are trying to access a poll that you don't have rights to.  This attempt has been logged. Please <a href=\"{$_CONF["site_admin_url"]}/poll.php\">go back to the poll administration screen</a>.",
	23 => 'New Poll',
	24 => 'Admin Home',
	25 => 'Yes',
	26 => 'No'
);

###############################################################################
# topic.php

$LANG27 = array(
	1 => "Topic Editor",
	2 => "Topic ID",
	3 => "Topic Name",
	4 => "Topic Image",
	5 => "(do not use spaces)",
	6 => "Deleting a topic deletes all stories and blocks associated with it",
	7 => "Please fill in the Topic ID and Topic Name fields",
	8 => "Topic Manager",
	9 => "To modify or delete a topic, click on that topic.  To create a new topic click the new topic button to the left. You will find your access level for each topic in parenthesis",
	10=> "Sort Order",
	11 => "Stories/Page",
	12 => "Access Denied",
	13 => "You are trying to access a topic that you don't have rights to.  This attempt has been logged. Please <a href=\"{$_CONF["site_admin_url"]}/topic.php\">go back to the topic administration screen</a>.",
	14 => "Sort Method",
	15 => "alphabetical",
	16 => "default is",
	17 => "New Topic",
	18 => "Admin Home",
    19 => 'save',
    20 => 'cancel',
    21 => 'delete'
);

###############################################################################
# user.php

$LANG28 = array(
	1 => "User Editor",
	2 => "User ID",
	3 => "User Name",
	4 => "Full Name",
	5 => "Password",
	6 => "Security Level",
	7 => "Email Address",
	8 => "Homepage",
	9 => "(do not use spaces)",
	10 => "Please fill in the Username, Full name, Security Level and Email Address fields",
	11 => "User Manager",
	12 => "To modify or delete a user, click on that user below.  To create a new user click the new user button to the left. You can do simple searches by entering parts of a username,email address or fullname (e.g.*son* or *.edu) in the form below.",
	13 => "SecLev",
	14 => "Reg. Date",
	15 => 'New User',
	16 => 'Admin Home',
	17 => 'changepw',
	18 => 'cancel',
	19 => 'delete',
	20 => 'save',
	18 => 'cancel',
	19 => 'delete',
	20 => 'save',
    21 => 'The username you tried saving already exists.',
    22 => 'Error',
    23 => 'Batch Add',
    24 => 'Batch Import of Users',
    25 => 'You can import a batch of users into Geeklog.  The import file must a tab-delimited text file and must have the fields in the following order: full name, username, email address.  Each user you import will be emailed with a random password.  You must have one user entered per line.  Failure to follow these instructions will cause problems that may require manual work so double check your entries!',
    26 => 'Search',
    27 => 'Limit Results',
    28 => 'Check here to delete this picture',
    29 => 'Path',
    30 => 'Import',
    31 => 'New Users',
    32 => 'Done processing. Imported $successes and encountered $failures failures',
    33 => 'submit',
    34 => 'Error: You must specify a file to upload.'
);


###############################################################################
# moderation.php

$LANG29 = array(
	1 => "Approve",
	2 => "Delete",
	3 => "Edit",
  10 => "Title",
  11 => "Start Date",
  12 => "URL",
  13 => "Category",
  14 => "Date",
  15 => "Topic",
	34 => "Command and Control",
	35 => "Story Submissions",
	36 => "Link Submissions",
	37 => "Event Submissions",
	38 => "Submit",
	39 => "There are no submissions to moderate at this time"
);

###############################################################################
# calendar.php

$LANG30 = array(
	1 => "Sunday",
	2 => "Monday",
	3 => "Tuesday",
	4 => "Wednesday",
	5 => "Thursday",
	6 => "Friday",
	7 => "Saturday",
	8 => "Add Event",
	9 => "Geeklog Event",
	10 => "Events for",
	11 => "Master Calendar",
	12 => "My Calendar",
	13 => "January",
	14 => "February",
	15 => "March",
	16 => "April",
	17 => "May",
	18 => "June",
	19 => "July",
	20 => "August",
	21 => "September",
	22 => "October",
	23 => "November",
	24 => "December",
	25 => "Back to ",
    26 => "All Day",
    27 => "Week",
    28 => "Personal Calendar for",
    29 => "Public Calendar",
    30 => "delete event",
    31 => "Add",
    32 => "Event",
    33 => "Date",
    34 => "Time",
    35 => "Quick Add",
    36 => "Submit",
    37 => "Sorry, the personal calendar feature is not enabled on this site",
    38 => "Personal Event Editor",
    39 => 'Day',
    40 => 'Week',
    41 => 'Month'
);

###############################################################################
# admin/mail.php
$LANG31 = array(
 	1 => $_CONF['site_name'] . " Mail Utility",
 	2 => "From",
 	3 => "Reply-to",
 	4 => "Subject",
 	5 => "Body",
 	6 => "Send to:",
 	7 => "All users",
 	8 => "Admin",
	9 => "Options",
	10 => "HTML",
 	11 => "Urgent message!",
 	12 => "Send",
 	13 => "Reset",
 	14 => "Ignore user settings",
 	15 => "Error when sending to: ",
	16 => "Successfully sent messages to: ",
	17 => "<a href=" . $_CONF["site_admin_url"] . "/mail.php>Send another message</a>",
    18 => "To",
    19 => "NOTE: if you wish to send a message to all site members, select the Logged-in Users group from the drop down.",
    20 => "Successfully sent <successcount> messages and unsuccessfully sent <failcount> messages.  If you need them, the details of each message attempts is below.  Otherwise you can <a href=\"" . $_CONF['site_admin_url'] . "/mail.php\">Send another message</a> or you can <a href=\"" . $_CONF['site_admin_url'] . "/moderation.php\">go back to the administration page</a>.",
    21 => 'Failures',
    22 => 'Successes',
    23 => 'No failures',
    24 => 'No successes',
    25 => '-- Select Group --'
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
	8 => "You have been successfully logged out.",
	9 => "Your story has been successfully saved.",
	10 => "The story has been successfully deleted.",
	11 => "Your block has been successfully saved.",
	12 => "The block has been successfully deleted.",
	13 => "Your topic has been successfully saved.",
	14 => "The topic and all it's stories an blocks have been successfully deleted.",
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
	27 => "Message successfully sent.",
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
	40 => "System Message",
    41 => "Sorry, you do not have access to the word replacement page.  Please note that all attempts to access unauthorized features are logged",
    42 => "Your word has been successfully saved.",
	43 => "The word has been successfully deleted.",
    44 => 'The plug-in was successfully installed!',
    45 => 'The plug-in was successfully deleted.',
    46 => "Sorry, you do not have access to the database backup utility.  Please note that all attempts to access unauthorized features are logged",
    47 => "This functionality only works under *nix.  If you are running *nix as your operating system then your cache has been successfully cleared. If you are on Windows, you will need to search for files name adodb_*.php and remove them manually."
);

// for plugins.php

$LANG32 = array (
	1 => "Installing plugins could possibly cause damage to your Geeklog installation and, possibly, to your system.  It is important that you only install plugins downloaded from the <a href=\"http://geeklog.sourceforge.net\" target=\"_blank\">Geeklog Homepage</a> as we thoroughly test all plugins submitted to our site on a variety of operating systems.  It is important that you understand that the plugin installation process will require the execution of a few filesystem commands which could lead to security problems particularly if you use plugins from third party sites.  Even with this warning you are getting, we do not gaurantee the success of any installation nor are we liable for damage caused by installing a Geeklog plugin.  In other words, install at your own risk.  For the wary, directions on how to manually install a plugin is included with each plugin package.",
	2 => "Plug-in Installation Disclaimer",
	3 => "Plug-in Installation Form",
	4 => "Plug-in File",
	5 => "Plug-in List",
	6 => "Warning: Plug-in Already Installed!",
	7 => "The plug-in you are trying to install already exists.  Please delete the plugin before re-installing it",
	8 => "Plugin Compatibility Check Failed",
	9 => "This plugin requires a newer version of Geeklog. Either upgrade your copy of <a href=\"http://geeklog.sourceforge.net\">Geeklog</a> or get a newer version of the plug-in.",
	10 => "<br><b>There are no plugins currently installed.</b><br><br>",
	11 => "To modify or delete a plug-in, click on that plug-in's number below. To learn more about a plug-in, click the plug-in name and you will be directed to that plug-in's website. To install or upgrade a plug-in please consult it's documentation.",
	12 => 'no plugin name provided to plugineditor()',
	13 => 'Plugin Editor',
	14 => 'New Plug-in',
	15 => 'Admin Home',
	16 => 'Plug-in Name',
	17 => 'Plug-in Version',
	18 => 'Geeklog Version',
	19 => 'Enabled',
	20 => 'Yes',
	21 => 'No',
	22 => 'Install',
    23 => 'Save',
    24 => 'Cancel',
    25 => 'Delete',
    26 => 'Plug-in Name',
    27 => 'Plug-in Homepage',
    28 => 'Plug-in Version',
    29 => 'Geeklog Version',
    30 => 'Delete Plug-in?',
    31 => 'Are you sure you want to delete this plug-in?  By doing so you will remove all the files, data and data structures that this plug-in uses.  If you are sure, click delete again on the form below.'
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
	editrootmsg => "Even though you are a User Administrator, you can't edit a root user without first being a root user yourself.  You can edit all other users except root users. Please note that all attempts to illegally edit root users are logged.  Please go back to the <a href=\"{$_CONF["site_admin_url"]}/users.php\">User Administration page</a>.",
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
	lock => "Lock",
	members => "Members",
	anonymous => "Anonymous",
	permissions => "Permissions",
	permissionskey => "R = read, E = edit, edit rights assume read rights",
	edit => "Edit",
	none => "None",
	accessdenied => "Access Denied",
	storydenialmsg => "You do not have access to view this story.  This could be because you aren't a member of {$_CONF["site_name"]}.  Please <a href=users.php?mode=new> become a member</a> of {$_CONF["site_name"]} to receive full membership access!",
	eventdenialmsg => "You do not have access to view this event.  This could be because you aren't a member of {$_CONF["site_name"]}.  Please <a href=users.php?mode=new> become a member</a> of {$_CONF["site_name"]} to receive full membership access!",
	nogroupsforcoregroup => "This group doesn't belong to any of the other groups",
	grouphasnorights => "This group doesn't have access to any of the administrative features of this site",
	newgroup => 'New Group',
	adminhome => 'Admin Home',
	save => 'save',
	cancel => 'cancel',
	canteditroot => 'You have tried to edit the Root group but you are not in the Root group yourself therefore your access to this group is denied.  Please contact the system administrator if you feel this is an error'	
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
    not_found => "Error: {$_DB_mysqldump_path} could not be found."
);

$LANG_BUTTONS = array(
    1 => "Home",
    2 => "Contact",
    3 => "Get Published",
    4 => "Links",
    5 => "Polls",
    6 => "Calendar",
    7 => "Site Stats",
    8 => "Personalize",
    9 => "Search",
    10 => "advanced search"
);

$LANG_404 = array(
    1 => "404 Error",
    2 => "Gee, I've looked everywhere but I can not find <b>http://{$HTTP_SERVER_VARS["HTTP_HOST"]}{$HTTP_SERVER_VARS["REQUEST_URI"]}</b>.",
    3 => "<p>We're sorry, but the file you have requested does not exist. Please feel free to check the <a href=\"{$_CONF['site_url']}\">main page</a> or the <a href=\"{$_CONF['site_url']}/search.php\">search page</a> to see if you can find what you lost."
);

$LANG_LOGIN = array (
    1 => 'Login required',
    2 => 'Sorry, to access this area you need to be logged in as a user.',
    3 => 'Login',
    4 => 'New User'
);

?>
