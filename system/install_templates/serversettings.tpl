<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN">
<html>
    <head>
        <meta http-equiv="content-type" content="text/html;charset=iso-8859-1">
        <title>GeekLog Server Settings</title>
    </head>
    <body bgcolor="white">
        <h2>Geeklog Server Settings (Step 2 of 3)</h2>
        <P>Below you will configure your Geeklog server settings.  This information will be stored in {path}/config.php where you can
        manually change the settings later. For quick installation pay special attention to the labels in <font color="#FF0000">red</font>.
        <form action="install.php" method="post">
        <table cellpadding="3" cellspacing="0" border="0">
            <tr align="left" valign="middle">
                <td colspan="2" align="left" valign="middle" bgcolor="#ffffcc"><b>
                    <hr noshade size="2">
                    <font color="black">Unless you performing a non-standard install, you should not have to change any of the following fields:</font></b></td>
            </tr>
            <tr>
                <td align="right" bgcolor="#ffffcc"><font color="#3333ff"><b>Geeklog Path:</b></font></td>
                <td bgcolor="#ffffcc">{path}<input type="hidden" name="geeklog_path" value="{path}"> <input type="hidden" name="upgrade" value="{upgrade}"></td>
            </tr>
            <tr>
                <td align="right" bgcolor="#ffffcc"><font color="#3333ff"><b>Path to system directory:</b></font></td>
                <td bgcolor="#ffffcc">{path_system}<input type="hidden" name="path_system" value="{path_system}"></td>
            </tr>
            <tr>
                <td align="right" bgcolor="#ffffcc"><font color="#3333ff"><b>Path to HTML directory:</b></font></td>
                <td bgcolor="#ffffcc"><input type="text" name="path_html" value="{path_html}" size="70"></td>
            </tr>
            <tr>
                <td align="right" bgcolor="#ffffcc"><font color="#3333ff"><b>Path to log directory:</b></font></td>
                <td bgcolor="#ffffcc"><input type="text" name="path_log" value="{path_log}" size="70"></td>
            </tr>
            <tr>
                <td align="right" bgcolor="#ffffcc"><font color="#3333ff"><b>RDF File:</b></font></td>
                <td bgcolor="#ffffcc"><input type="text" name="rdf_file" value="{rdf_file}" size="70"></td>
            </tr>
            <tr align="left">
                <td align="right" bgcolor="#ffffcc"><font color="#3333ff"><b>Path to language directory:</b></font></td>
                <td align="left" bgcolor="#ffffcc">{path_language}<input type="hidden" name="path_language" value="{path_language}"></td>
            </tr>
            <tr align="left">
                <td align="right" bgcolor="#ffffcc"><font color="#3333ff"><b>Cookie Path:</b></font></td>
                <td align="left" bgcolor="#ffffcc"><input type="text" name="cookie_path" value="{cookie_path}" size="70"></td>
            </tr>
            <tr align="left">
                <td colspan="2" align="left" bgcolor="#ffffcc"><b>
                    <hr noshade size="2">
                    </b></td>
            </tr>
            <tr align="left">
                <td colspan="2" align="left"><b><br>
                    The following fields can be customized for your particular site:</b></td>
            </tr>
            <tr valign="top">
                <td align="right" valign="top"><font color="#ff0000"><b>Site Name:</b></font></td>
                <td><input type="text" name="site_name" value="{site_name}" size="70"><font color="#66cccc"><br>
                    </font><font size="2" color="#666699"><i>This name will appear in the title bar of all windows (ex: &quot;CoolTechToys.com&quot;)</i></font><font color="#666699"><br>
                    </font><br>
                </td>
            </tr>
            <tr>
                <td align="right" valign="top"><font color="#ff0000"><b>Site Slogan:</b></font></td>
                <td><input type="text" name="site_slogan" value="{site_slogan}" size="70"><font color="#669999"><br>
                    </font><font size="2" color="#666699"><i>The slogan appears after the site name (ex: &quot;Where Toys Rule!&quot;)<br>
                    </i><br>
                    </font></td>
            </tr>
            <tr>
                <td align="right" valign="top"><font color="#ff0000"><b>Site Email:</b></font></td>
                <td><input type="text" name="site_mail" value="{site_email}" size="70"><br>
                    <font size="2" color="#666699"><i>The email address you wish to use when someone clicks an email link. (ex: tools@cooltechtoys.com)<br>
                    </i></font><font size="2" color="#3333ff"><i><br>
                    </i></font></td>
            </tr>
            <tr>
                <td align="right" valign="top"><font color="#ff0000"><b>Site URL:</b></font></td>
                <td><input type="text" name="site_url" value="{site_url}" size="70"><br>
                    <font size="2" color="#666699"><i>Your sire's URL (ex: http://www.CoolTechToys.com)<br>
                    <br>
                    </i></font></td>
            </tr>
            <tr>
                <td align="right" valign="top"><font color="#ff0000"><b>Locale:<b></font></td>
                <td><input type="text" name="locale" size="35" value="{locale}"><br>
                    <font size="2" color="#ff3300"><i>Explanation needed!</i></font></td>
            </tr>
            <tr></td>
                <td align="right" valign="top"><font color="#3333ff"><b>Default Theme:</b></font></td>
                <td><input type="hidden" name="layout_url" value="{layout_url}"><input type="hidden" name="path_themes" value="{path_themes}"><input type="text" name="theme" value="{theme}" size="70"><br>
                    <font size="2" color="#666666"><i>The theme a new user will see when they connect to the site. Standard choices are Classic, Digital_Monochrome, or Yahoo.<br>
                    <br>
                    </i></font></td>
            </tr>
            <tr>
                <td align="right" valign="top"><font color="#3333ff"><b>Allow User-Defined Themes:</b></font></td>
                <td><input type="checkbox" name="allow_user_themes" {userthemes_checked}><br>
                    <font size="2" color="#666666"><i>If you check this box, users can replace your site's theme with others installed on your site.<br>
                    <br>
                    </i></font></td>
            </tr>
            <tr>
                <td align="right" valign="top"><font color="#3333ff"><b>Language File:</b></font></td>
                <td><select name="language" size="1">
                        {language_options}
                    </select><font size="2" color="#3333ff"><i><br>
                    </i></font><font size="2" color="#666666"><i>Choose a default language for your site from the pop-up menu.<br>
                    <br>
                    </i></font></td>
            </tr>
            <tr>
                <td align="right" valign="top"><font color="black"><b><spacer type="horizontal" size="32"></b></font></td>
                <td>
                    <hr noshade size="5" width="50%" align="left">
                    <b><font color="black">Date Formats:</font></b><br>
                    Below you can specify the date formats used in your Geeklog system. Click <a href="dateformatkey.html" target="_blank">here</a> for a key on how to format your dates.<br>
                    <br>
                </td>
            </tr>
            <tr>
                <td align="right" valign="top"><font color="#3333ff"><b>Default Date Format:</b></font></td>
                <td><input type="text" name="date" value="{date}" size="70"><br>
                    <font color="#666666" size="2"><i>Shown in the header bar of each page; can be overridden by the user in their display settings. (the default format produces this output:Wednesday, December 05 2001 @ 02:07 PM PST)<br>
                    <br>
                    </i></font></td>
            </tr>
            <tr>
                <td align="right" valign="top"><font color="#3333ff"><b>Day/Time Format:</b></font></td>
                <td><input type="text" name="daytime" value="{daytime}" size="70"><font color="#3333ff"><i><br>
                    </i></font><font color="#666666" size="2"><i>Used for the 'most recent post' entry on each article; can't be overridden by the users (the default format produces this output: 12/05 02:10PM)<br>
                    <br>
                    </i></font></td>
            </tr>
            <tr>
                <td align="right" valign="top"><font color="#3333ff"><b>Short Date:</b></font></td>
                <td><input type="text" name="shortdate" value="{shortdate}" size="70"><font size="2" color="#3333ff"><i><br>
                    </i></font><font size="2" color="#666666"><i>Used in places such as the search results page; can't be overridden by users
(the default format produces this output: 12/05/01)<br>
                    </i></font>
                    <hr noshade size="5" width="50%" align="left">
                </td>
            </tr>
            <tr>
                <td align="right" valign="top"><font color="#3333ff"><b>IP-based Sessions ID's:</b></font></td>
                <td><input type="checkbox" name="cookie_ip" {cookieip_checked}><br>
                    <font size="2" color="#666666"><i>When checked, this will store a combination of the user's IP number and a rondom number
in the cookie. However, if enabled, dial-up users will most likely have to login every time they connect to the site.</i></font><br>
                </td>
            </tr>
            <tr>
                <td align="right" valign="top"><font color="#ff0000"><b>Long-Term Cookie Timeout:</b></font></td>
                <td><select name="default_perm_cookie_timeout" size="1">
                        <option value="">Don't Use</option>
                        {longterm_options}
                    </select><br>
                    <font color="#666666" size="2"><i>How long should your site remember the user in between visits? If you don't use this feature then long-term cookies are disabled and session cookies are only used.</i></font><br>
                    <br>
                </td>
            </tr>
            <tr>
                <td align="right" valign="top"><font color="#3333ff"><b>Long-Term Cookie Name:</b></font></td>
                <td><input type="text" name="cookie_name" value="{cookie_name}" size="70"><br>
                    <font color="#666666" size="2"><i>The name of the cookie which will be stored on the user's local machine to represent the long-term cookie.</i></font><br>
                    <br>
                </td>
            </tr>
            <tr>
                <td align="right" valign="top"><font color="#3333ff"><b>Session Timeout:</b></font></td>
                <td><select name="session_cookie_timeout" size="1">
                        {session_options}
                    </select><br>
                    <font color="#666666" size="2"><i>How long should your site remember the user during any particular visit? Only useful if
long-term cookies are disabled.</i></font><br>
                    <br>
                </td>
            </tr>
            <tr>
                <td align="right" valign="top"><font color="#3333ff"><b>Session Cookie Name:</b></font></td>
                <td><input type="text" name="cookie_session" value="{cookie_session}" size="70"><br>
                    <font color="#666666" size="2"><i>The name of the session cookie which will be stored on the user's local machine to represent the session cookie. </i></font><br>
                    <br>
                </td>
            </tr>
            <tr>
                <td align="right" valign="top"><font color="#ff0000"><b>Uncompress Command:</b></font></td>
                <td><input type="text" name="unzipcommand" value="{unzipcommand}" size="70"><br>
                    <font size="2" color="#ff3300"><i><b>NOTE:</b> This setting is very important to get right if you want to be able to use the web-based administration pages to remotely install plugins.</i><br><b>*nix-based systems:</b> /bin/tar -C /path/to/geeklog/plugins/ -xzf<br><b>Windows-based systems:</b> filzip.exe -e -r /path/to/geeklog/plugins/</font><br>
                    <br>
                </td>
            </tr>
            <tr>
                <td align="right" valign="top"><font color="#ff0000"><b>Remove Command:</b></font></td>
                <td><input type="text" name="rmcommand" value="{rmcommand}" size="70"><br>
                    <font size="2" color="#ff3300"><i><b>NOTE:</b> This setting is very important to get right if you want to be able to use the web-based administration pages to remotely remove plugins.</i><br><b>*nix-based system:</b> /bin/rm -Rf<br><b>Windows-based systems:</b> rmdir /S /Q</font><br>
                    <br>
                    </i></font></td>
            </tr>
            <tr>
                <td align="right" valign="top"><font color="#3333ff"><b>Login Required:</b></font></td>
                <td><input type="checkbox" name="loginrequired" {loginrequired_checked}>
                    <font size="2" color="#666666"><i>Check this if you want to force users to be logged in before submitting anything.</i></font><br>
                    <br>
                </td>
            </tr>
            <tr>
                <td align="right" valign="top"><font color="#3333ff"><b>Default Post-Mode:</b></font></td>
                <td><select name="postmode" size="1">
                        <option value="plaintext" {plaintext_selected}>Plain Text
                        <option value="html" {html_selected}>HTML
                    </select><br>
                    <font color="#666666" size="2"><i>When user's submit a story, will the default format be HTML or plain text? </i></font><font size="2" color="#ff3300"><i>TRUE FOR ADMIN, TOO?<br>
                    <br>
                    </i></font></td>
            </tr>
            <tr>
                <td align="right" valign="top"><font color="#3333ff"><b>Speed Limit:</b></font></td>
                <td><input type="text" name="speedlimit" value="{speedlimit}" size="24"><br>
                    <font color="#666666" size="2"><i>The interval, in seconds, between allowed posts. 300 seconds = 5 minutes. This prevents
easy flooding of the site by one user.</i></font></td>
            </tr>
            <tr>
                <td align="right" valign="top"><font color="#3333ff"><b>Topic Sort Method:</b></font></td>
                <td><select name="sortmethod" size="1">
                        <option value="sortnum" {sortnum_checked}>Sort Number
                        <option value="alpha" {alpha_checked}>Alphabetically
                    </select><br>
                    <font color="#666666" size="2"><i>The topics list can be sorted by the numeric perfix of each topic (the default behavior), or by the spelling of each topic name by changing this setting.</i></font><br>
                    <br>
                </td>
            </tr>
            <tr>
                <td align="right" valign="top"><font color="#3333ff"><b>Show Story Count:</b></font></td>
                <td><input type="checkbox" name="showstorycount" {showstorycount_checked}><br>
                    <font color="#666666" size="2"><i>If checked, users will see the number of articles in each section of the site in the Sections box.<br>
                    <br>
                    </i></font></td>
            </tr>
            <tr>
                <td align="right" valign="top"><font color="#3333ff"><b>Show Submission Count:</b></font></td>
                <td><input type="checkbox" name="showsubmissioncount" {showsubmissioncount_checked}><br>
                    <font color="#666666" size="2"><i>If checked, admins will see the number of submissions in each section of the site in the Sections box.<br>
                    <br>
                    </i></font></td>
            </tr>
            <tr>
                <td align="right" valign="top"><font color="#3333ff"><b>Show What's New Block:</b></font></td>
                <td><input type="checkbox" name="whatsnewbox" {whatsnewbox_checked}><br>
                    <font color="#666666" size="2"><i>If checked, admins will see a &quot;What's New&quot; box, displaying a summary of recent articles, comments, and links.<br>
                    <br>
                    </i></font></td>
            </tr>
            <tr>
                <td align="right" valign="top"><font color="#3333ff"><b>New Stories Interval:</b></font></td>
                <td><select name="newstoriesinterval" size="1">
                        {newstoriesinterval_options}
                    </select><br>
                    <font color="#666666" size="2"><i>Determines how far backwards in time to count to determine the number of &quot;New&quot; articles in the What's New box.<br>
                    <br>
                    </i></font></td>
            </tr>
            <tr>
                <td align="right" valign="top"><font color="#3333ff"><b>New Comments Interval:</b></font></td>
                <td><select name="newcommentsinterval" size="1">
                        {newcommentsinterval_options}
                    </select><br>
                    <font color="#666666" size="2"><i>Determines how far backwards in time to count to select &quot;New&quot; comments for the What's New box<br>
                    <br>
                    </i></font></td>
            </tr>
            <tr>
                <td align="right" valign="top"><font color="#3333ff"><b>New Links Interval:</b></font></td>
                <td><select name="newlinksinterval" size="1">
                        {newlinksinterval_options}
                    </select><br>
                    <font color="#666666" size="2"><i>Determines how far backwards in time to count to select &quot;New&quot; links for the What's New box<br>
                    <br>
                    </i></font></td>
            </tr>
<!-- Not implemented yet
            <tr>
                <td align="right" valign="top">Use Email Digests:</td>
                <td><input type="checkbox" name="emailstories" {emailstories_checked}>
                    <font color="#666666" size="2"><i>Allows users to have stories emailed to them. Note that this requires 'cron' access on the host and the use of PHP as a shell script.<br>
                    <br>
                    </i></font></td>
            </tr>
-->
            <tr>
                <td align="right" valign="top"><font color="#3333ff"><b>Allow Personal Calendars:</b></font></td>
                <td><input type="checkbox" name="personalcalendars" {personalcalendars_checked}>
                    <font size="2" color="#666666"><i>If checked users will be able to add personal events to their own private calendar!</i></font><br>
                    <br>
                </td>
            </tr>
            <tr>
                <td align="right" valign="top"><font color="#3333ff"><b>Calendar Event Types:</b></font></td>
                <td><textarea name="event_types" wrap="virtual" cols="80" rows="3">{event_types}</textarea> (comma seperated list)<br>
                    <font size="2" color="#666666"><i>These are the type of events that can be assigned to events in the calendar!</i></font><br>
                    <br>
                </td>
            </tr>
            <tr>
                <td align="right" valign="top"><font color="#3333ff"><b>Show Upcoming Events Block:</b></font></td>
                <td><input type="checkbox" name="showupcomingevents" {showupcomingevents_checked}>
                    <font color="#666666" size="2"><i>When checked, upcoming events are displayed in a box.</i></font><br>
                    <br>
                </td>
             </tr>
            <tr>
                <td align="right" valign="top"><font color="#3333ff"><b>Publish RDF Headline Feed:</b></font></td>
                <td><input type="checkbox" name="backend" {backend_checked}><br>
                    <font color="#666666" size="2"><i>When checked, your site's headlines will be available to sites and programs capable of reading RDF files. NOTE: Make sure the 'backend' directory has 777 permissions set.</i></font><br>
                    <br>
                </td>
            </tr>
            <tr>
                <td align="right" valign="top"><font color="#3333ff"><b>Default # News Items:</b></font></td>
                <td><input type="text" name="limitnews" value="{limitnews}" size="24"><br>
                    <font color="#666666" size="2"><i>What is the default number of news articles that a new user will see?</i></font><br>
                    <br>
                </td>
            </tr>
            <tr>
                <td align="right" valign="top"><font color="#3333ff"><b>Min. # News Items:</b></font></td>
                <td><input type="text" name="minnews" value="{minnews}" size="24"><br>
                    <font color="#666666" size="2"><i>The minimum number of articles that a user may set in their preferences.</i></font><br>
                    <br>
                </td>
            </tr>
            <tr>
                <td align="right" valign="top"><font color="#3333ff"><b>Show Older Stories Block:</b></font></td>
                <td><input type="checkbox" name="olderstuff" {olderstuff_checked}><br>
                    <font color="#666666" size="2"><i>When checked, users will see a block detailing older stories on the site.<br>
                    <br>
                    </i></font></td>
            </tr>
            <tr>
                <td align="right" valign="top"><font color="#3333ff"><b>Show Contributed-by Line:</b></font></td>
                <td><input type="checkbox" name="contributedbyline" {contributedbyline_checked}><br>
                    <font color="#666666" size="2"><i>When checked, users will see the name of the story contributor in the article summary.<br>
                    <br>
                    </i></font></td>
            </tr>
            <tr>
                <td align="right" valign="top"><font color="#3333ff"><b>Article Image Align:</b></font></td>
                <td><select name="article_image_align" size="1">
                        <option value="left" {left_checked}>Left
                        <option value="right" {right_checked}>Right
                    </select><br>
                    <font color="#666666" size="2"><i>Where should the topic icons that accompany each article be aligned in the story?<br>
                    <br>
                    </i></font></td>
            </tr>
            <tr>
                <td align="right" valign="top"><font color="#3333ff"><b>Login Required For Comments:</b></font></td>
                <td><input type="checkbox" name="commentsloginrequired" {commentsloginrequired_checked}><br>
                    <font color="#666666" size="2"><i>If checked, users must be logged in to post comments<br>
                    <br>
                    </i></font></td>
            </tr>
            <tr>
                <td align="right" valign="top"><font color="#3333ff"><b>Comment Speed Limit:</b></font></td>
                <td><input type="text" size="35" name="commentspeedlimit" value="{commentspeedlimit}"><br>
                    <font color="#666666" size="2"><i>How man seconds users must wait in between posting comments (this is a spam guard feature)<br>
                    <br>
                    </i></font></td>
            </tr>
            <tr>
                <td align="right" valign="top"><font color="#3333ff"><b>Comment Limit:</b></font></td>
                <td><input type="text" name="comment_limit" value="{comment_limit}" size="24"><br>
                    <font color="#666666" size="2"><i>How many comments may be posted with any given story?<br>
                    <br>
                    </i></font></td>
            </tr>
            <tr>
                <td align="right" valign="top"><font color="#3333ff"><b>Default Comment Mode:</b></font></td>
                <td><select name="comment_mode" size="1">
                        <option value="flat" {flat_selected}>Flat</option>
                        <option value="nested" {nested_selected}>Nested</option>
                        <option value="nocomments" {nocomments_selected}>No Comments</option>
                        <option value="threaded" {threaded_selected}>Threaded</option>
                    </select><br>
                    <font color="#666666" size="2"><i>What format will comments be displayed in for a new user? Flat = all comments displayed
in date order; Nested = comments displayed in hierarchy order fully expanded; Threaded = comments displayed in hierarchy order with only top-level comments expanded; No Comments = Comments not displayed.<br>
                    <br>
                    </i></font></td>
            </tr>
            <tr>
                <td align="right" valign="top"><font color="#3333ff"><b>Max. Poll Answers:</b></font></td>
                <td><input type="text" name="maxanswers" value="{maxanswers}" size="24"><br>
                    <font color="#666666" size="2"><i>What is the maximum number of questions possible in a survey.<br>
                    <br>
                    </i></font></td>
            </tr>
            <tr>
                <td align="right" valign="top"><font color="#3333ff"><b>Poll Cookie Timeout:</b></font></td>
                <td><select name="pollcookietime" size="1">
                        {pollcookietime_options}
                    </select><br>
                    <font size="2" color="#ff3300"><i>Explanation needed!</i></font><br>
                    <br>
                </td>
            </tr>
            <tr>
                <td align="right" valign="top"><font color="#3333ff"><b>Poll Address Timeout:</b></font></td>
                <td><select name="polladdresstime" size="1">
                        {polladdresstime_options}
                    </select><br>
                    <font size="2" color="#ff3300"><i>Explanation needed!</i></font><br>
                    <br>
                </td>
            </tr>
            <tr>
                <td align="right" valign="top"><font color="#3333ff"><b>Allowable HTML:</b></font></td>
                <td><textarea name="allowablehtml" wrap="virtual" cols="80" rows="10">{allowablehtml}</textarea><br>
                    <font color="#666666" size="2"><i>Enter the HTML codes that users will be allowed to use when entering stories.</i></font></td>
            </tr>
            <tr>
                <td align="right" valign="top"><font color="#3333ff"><b>Censor Mode:</b></font></td>
                <td><input type="checkbox" name="censormode" {censormode_checked}><br>
                    <font size="2" color="#666666"><i>If you want to censor out inappropriate words or phrases check this!</i></font><br>
                    <br>
                </td>
            </tr>
            <tr>
                <td align="right" valign="top"><font color="#3333ff"><b>Censor Replacement:</b></font></td>
                <td><input type="text" size="50" name="censorreplace" value="{censorreplace}"><br>
                    <font color="#666666" size="2"><i>What word or symbols show up to replace a censored word.</i></font></td>
            </tr>
            <tr>
                <td align="right" valign="top"><font color="#3333ff"><b>Censor Word List:</b></font></td>
                <td><input type="text" size="70" name="censorlist" value="{censorlist}"><br>
                    <font color="#666666" size="2"><i>A listing of all censored words.</i></font></td>
            </tr>
            <tr>
                <td colspan="2" align="center"><input type="hidden" name="page" value="2"><input type="submit" name="action" value="&lt;&lt; Previous"> <input type="submit" name="action" value="Next &gt;&gt;"></td>
            </tr>
        </table>
        </form>
    </body>
</html>
