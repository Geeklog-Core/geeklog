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
	37 => "",
	38 => "",
	39 => "Refresh",
	40 => "",
	41 => "",
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
	59 => "Don't have an account yet?  Sign up as a <a href={$CONF["base"]}/users.php?mode=new>New User</a>",
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
	89 => "There are no upcoming events"
);

###############################################################################
# calendar.php

$LANG02 = array(
	1 => "Calendar of Events",
	2 => "I'm Sorry, there are no events to display.",
	3 => "When:",
	4 => "Where:",
	5 => "Description:",
	6 => "Add A Event",
	7 => "Upcoming Events",
	8 => "By adding this event to your calendar you can quickly view only the events you are interested in by clicking \"My calendar\" from the Members Only area.",
	9 => "Add to My Calendar",
	10 => "Remove from My Calendar"
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
	8 => " seconds ago.  This site requires at least {$CONF["speedlimit2"]} seconds between comments",
	9 => "Comment",
	10 => "<b>Important Stuff</b><li>Please try to keep posts on topic.<li>Try to reply to other people comments instead of starting new threads.<li>Read other people's messages before posting your own to avoid simply duplicating what has already been said.<li>Use a clear subject that describes what your message is about.<li>Your email address will NOT be made public.",
	11 => "Submit Comment",
	12 => "Please fill in the Name, Email, Title and Comment fields, as they are necessary for your submission of a comment.",
	13 => "Your Information",
	14 => "Preview",
	15 => "",
	16 => "Title",
	17 => "Error"
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
	15 => "Your {$CONF["sitename"]} account has been created successfully. To be able to use it, you must login using the information below. Please save this mail for further reference.",
	16 => "Your Account Information",
	17 => "Account does not exist",
	18 => "The email address provided does not appear to be a valid email address",
	19 => "The username or email address provided already exists",
	20 => "The email address provided does not appear to be a valid email address",
	21 => "Error",
	22 => "Create a User Account",
	23 => "Creating a user account will allow you to post comments and submit items as yourself. If you don't have an account, you will only be able to post as Anonymous.",
	24 => "Your password will be sent to the email address you enter.",
	25 => "Did You Forget Your Password?",
	26 => "Enter your username and click Email Password and a new password will be mailed to the email address on record.",
	27 => "Create New User",
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
	52 => "The default is 10",
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
	63 => "Your password has been emailed to you and should arrive momentarily. Please follow the directions in the message and we thank-you for using " . $CONF["sitename"],
	64 => "Comment Preferences for",
	65 => "Try Logging in Again",
	66 => "You may have mistyped your login credentials.  If so, you may try logging in again below. If you can't remember your password you can have a new one sent to by filling out the password form at the bottom of this page."
);

###############################################################################
# index.php

$LANG05 = array(
	1 => "No News to Display",
	2 => "There are no news stories to display.  There may be no news for this topic or your user preferences may be too restrictive.",
	3 => "for topic $topic",
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
	3 => "Vote"
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
	23 => "This email was sent to you by $from at $fromemail because they thought you might be interested it this article from {$CONF["base"]}.  This is not SPAM and the email addresses involved in this transaction were not saved to a list or stored for later use.",
	24 => "Comment on this story at",
	25 => "You must be logged in to user this feature.  By having you log in, it helps us prevent misuse of the system",
	26 => "This form will allow you to send an email to the selected user.  All fields are required.",
	27 => "Short message",
	28 => "$from wrote: $shortmsg"
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
	13 => "Story Search Result: No matches",
	14 => "There were no matches for your search on",
	15 => "Please try again.",
	16 => "Title",
	17 => "Date",
	18 => "Author",
	19 => "Search the entire {$CONF["sitename"]} database of current and past news stories",
	20 => "Date",
	21 => "to",
	22 => "(Date Format MM-DD-YYYY)",
	23 => "Hits"
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
	21 => "It appears that there are no links on this site or no one has ever clicked on one."
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
	31 => " seconds ago.  This site requires at least {$CONF["speedlimit"]} seconds between submissions",
	32 => "Preview",
	33 => "Story Preview",
	34 => "Log Out",
	35 => "HTML tags are not allowed",
	36 => "Post Mode",
	37 => "Submitting an event to {$CONF["sitename"]} will put your event on the master calendar where users can optionally add your event to their personal calendar. This feature is <b>NOT</b> meant to store your personal events such as birthdays and anniversaries.<br><br>Once you submit your event it will be sent to our administrators and if approved, your event will appear on the master calendar."
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
	26 => "Layout Block"
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
	10 => "You need to fill in all fields in this form!",
	11 => "Event Manager",
	12 => "To modify or delete a event, click on that event below.  To create a new event click on new event above.",
	13 => "Event Title",
	14 => "Start Date",
	15 => "End Date"
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
	15 => "Link URL"
);

###############################################################################
# story.php

$LANG24 = array(
	1 => "Previous Stories",
	2 => "Next Stories",
	3 => "Mode",
	4 => "Post Mode",
	5 => "Story Editor",
	6 => "",
	7 => "Author",
	8 => "",
	9 => "",
	10 => "",
	11 => "",
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
	38 => "More from"
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
	14 => "",
	15 => "",
	16 => "",
	17 => "",
	18 => "Poll List",
	19 => "To modify or delete a poll, click on that poll.  To create a new poll click on new poll above.",
	20 => "Voters"
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
	9 => "To modify or delete a topic, click on that topic.  To create a new topic click the new topic button to the left.",
	10=> "Sort Order",
	11 => "Stories/Page"
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
	12 => "To modify or delete a user, click on that user below.  To create a new user click the new user button to the left.",
	13 => "SecLev"
);


###############################################################################
# moderation.php

$LANG29 = array(
	1 => "Approve",
	2 => "Delete",
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
	12 => "My Calendar"
);

###############################################################################
# admin/mail.php
$LANG31 = array(
 	1 => "Mail",
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
	17 => "<a href=" . $CONF["base"] . "/admin/mail.php>Send another message</a>"
);


###############################################################################
# confirmation and error messages

$MESSAGE = array (
	1 => "Your password has been emailed to you and should arrive momentarily. Please follow the directions in the message and we thank-you for using " . $CONF["sitename"],
	2 => "Thank-you for submitting your story to {$CONF["sitename"]}.  It has been submitted to our staff for approval. If approved, your story will be available for others to read on our site.",
	3 => "Thank-you for submitting a link to {$CONF["sitename"]}.  It has been submitted to our staff for approval.  If approved, your link will be seen in the <a href={$CONF["base"]}/links.php>links</a> section.",
	4 => "Thank-you for submitting an event to {$CONF["sitename"]}.  It has been submitted to our staff for approval.  If approved, your event will be seen in our <a href={$CONF["base"]}/calendar.php>calendar</a> section.",
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
	28 => "The plug-in has been successfully saved"
);

#for plugins.php

$LANG32 = array (
	1 => "<br>Installing plugins could possibly cause damage to your Geeklog installation and, possibly, to your system.  It is important that you only install plugins downloaded from the <a href=http://www.geeklog.org>Geeklog Homepage</a> as we thoroughly test all plugins submitted to our site on a variety of operating systems.  It is important that you understand that the plugin installation process will require the execution of a few filesystem commands which could lead to security problems particularly if you use plugins from third party sites.  Even with this warning you are getting, we do not gaurantee the success of any installation nor are we liable for damage caused by installing a Geeklog plugin.  In other words, install at your own risk.  For the wary, directions on how to manually install a plugin is included with each plugin package.<br><br>",
	2 => "Plug-in Installation Disclaimer",
	3 => "Plug-in Installation Form",
	4 => "Plug-in File",
	5 => "Plug-in List",
	6 => "Warning: Plug-in Already Installed!",
	7 => "The plug-in you are trying to install already exists.  Please delete the plugin before re-installing it",
	8 => "Plugin Compatibility Check Failed",
	9 => "This plugin requires a newer version of Geeklog. Either upgrade your copy of <a href=http://www.geeklog.org>Geeklog</a> or get a newer version of the plug-in.",
	10 => "<br><b>There are no plugins currently installed.</b><br><br>",
	11 => "To modify or delete a plug-in, click on that plug-in's number below. To learn more about a plug-in, click the plug-in name and you will be directed to that plug-in's website. To install or upgrade a plug-in click on new plug-in above."
);

?>
