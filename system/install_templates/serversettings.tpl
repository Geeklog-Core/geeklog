<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN">
<html>

	<head>
		<meta http-equiv="content-type" content="text/html;charset=iso-8859-1">
		<title>GeekLog Server Settings</title>
	</head>

	<body bgcolor="white">
		<form action="install.php" method="post">
		<table cellpadding="3" cellspacing="0" border="0">
			<tr align="left" valign="middle">
				<td colspan="2" align="center" valign="middle">
					<table border="1" cellpadding="4" cellspacing="2" width="90%">
						<tr>
							<td align="center" valign="top" bgcolor="#ccffcc"><b>GEEKLOG SITE INSTALLATION TOOL - INTRODUCTION</b></td>
						</tr>
						<tr>
							<td align="left">Below you will configure your Geeklog server settings. This information will be stored in {path}/config.php where you can manually change the settings later. For a quick and successful installation, pay close attention to the <font color="blue"><b>bold fields in blue</b></font>.</td>
						</tr>
					</table>
				</td>
			</tr>
			<tr align="left">
				<td width="100" align="left"><br>
				</td>
				<td align="left"></td>
			</tr>
			<tr align="left">
				<td colspan="2" align="center" valign="top">
					<table border="1" cellpadding="1" cellspacing="2" width="90%">
						<tr>
							<td align="center" valign="top" bgcolor="#ffcc00"><b>SYSTEM PATH SETTINGS - USE CAUTION WHEN MODIFYING **</b></td>
						</tr>
						<tr>
							<td bgcolor="#ffffcc">
								<table border="0" cellpadding="2" cellspacing="2">
									<tr>
										<td align="left" valign="top" nowrap><font color="black">Geeklog Path</font></td>
										<td width="11"><spacer type="horizontal" size="15"></td>
										<td>{path}<input type="hidden" name="geeklog_path" value="{path}"> <input type="hidden" name="upgrade" value="{upgrade}"></td>
									</tr>
									<tr>
										<td align="left" valign="top" nowrap><font color="black">Path to system directory</font></td>
										<td width="11"><spacer type="horizontal" size="15"></td>
										<td>{path_system}<input type="hidden" name="path_system" value="{path_system}"></td>
									</tr>
									<tr>
										<td align="left" valign="top" nowrap><font color="black">Path to language directory</font></td>
										<td width="11"></td>
										<td>{path_language}<input type="hidden" name="path_language" value="{path_language}"></td>
									</tr>
									<tr>
										<td align="left" valign="top" nowrap><font color="black">Path to HTML directory</font></td>
										<td width="11"><spacer type="horizontal" size="15"></td>
										<td><input type="text" name="path_html" value="{path_html}" size="70"></td>
									</tr>
									<tr>
										<td align="left" valign="top" nowrap><font color="black">Path to log directory</font></td>
										<td width="11"><spacer type="horizontal" size="15"></td>
										<td><input type="text" name="path_log" value="{path_log}" size="70"></td>
									</tr>
									<tr>
										<td align="left" valign="top" nowrap>Path to cookie file</td>
										<td width="11"><spacer type="horizontal" size="15"></td>
										<td><input type="text" name="cookie_path" value="{cookie_path}" size="70"></td>
									</tr>
									<tr>
										<td align="left" valign="top" nowrap><font color="black">RDF File</font></td>
										<td width="11"><spacer type="horizontal" size="15"></td>
										<td><input type="text" name="rdf_file" value="{rdf_file}" size="70"></td>
									</tr>
                                    <tr>
                                        <td align="left" valign="top" nowrap><font color="black">Allow MySQL backups</font></td>
                                        <td width="11"><spacer type="horizontal" size="15"></td>
                                        <td><input type="checkbox" name="allow_mysqldump" {allow_mysqldump_checked}></td>
                                    </tr>
                                    <tr>
                                        <td align="left" valign="top" nowrap><font color="black">Database Backup Directory</font></td>
                                        <td width="11"><spacer type="horizontal" size="15"></td>
                                        <td><input type="text" name="backup_path" value="{backup_path}" size="50"></td>
                                    </tr>
								</table>
								<br>
								** If you followed the instructions in the INSTALL document, the above settings do not need to be changed. Only change them if you're certain you know what you're doing.</td>
						</tr>
					</table>
				</td>
			</tr>
			<tr align="left">
				<td colspan="2" align="left"><b><br>
					<br>
					</b></td>
			</tr>
			<tr valign="top">
				<td align="center" valign="top" colspan="2">
					<table border="1" cellpadding="1" cellspacing="2" width="90%">
						<tr>
							<td align="center" valign="top" bgcolor="#66cccc"><b>NAME, EMAIL, LOCATION AND THEME SETTINGS</b></td>
						</tr>
						<tr>
							<td>
								<table border="0" cellpadding="2" cellspacing="2">
									<tr>
										<td align="right" valign="top" nowrap><font color="#3333ff"><b>Site Name:</b></font></td>
										<td align="left" valign="top"><input type="text" name="site_name" value="{site_name}" size="70"></td>
									</tr>
									<tr>
										<td align="right" valign="top" nowrap><font color="#3333ff"><b>Site Slogan:</b></font></td>
										<td align="left" valign="top"><input type="text" name="site_slogan" value="{site_slogan}" size="70"><br>
											<font size="2" color="#666699"><i>The site name and slogan appear together in the title of site windows (eas shown, Geeklog Site - Another Nifty Geelog Site)<br>
											<br>
											</i></font></td>
									</tr>
									<tr>
										<td align="right" valign="top" nowrap><font color="#3333ff"><b>Site Email:</b></font></td>
										<td align="left" valign="top"><input type="text" name="site_mail" value="{site_email}" size="70"><br>
											<font size="2" color="#666699"><i>The email address you wish to use when someone clicks an email link on your site.<br>
											<br>
											</i></font></td>
									</tr>
									<tr>
										<td align="right" valign="top" nowrap><font color="#3333ff"><b>Site URL:</b></font></td>
										<td align="left" valign="top"><input type="text" name="site_url" value="{site_url}" size="70"><br>
											<font size="2" color="#666699"><i>Your site's URL (including the http:// prefix)<br>
											<br>
											</i></font></td>
									</tr>
									<tr>
										<td align="right" valign="top" nowrap><font color="#3333ff"><b>Locale:</b></font></td>
										<td align="left" valign="top"><input type="text" name="locale" size="35" value="{locale}"><br>
											<font size="2" color="#ff3300"><i>Explanation needed!<br>
											<br>
											</i></font></td>
									</tr>
									<tr>
										<td align="right" valign="top" nowrap><font color="black">Language File:</font></td>
										<td align="left" valign="top"><select name="language" size="1">
												{language_options} 
											</select><font size="2" color="#3333ff"><i><br>
											</i></font><font size="2" color="#666699"><i>Choose a default language for your site from the pop-up menu.<br>
											</i></font><font size="2" color="#666666"><i><br>
											</i></font></td>
									</tr>
									<tr>
										<td align="right" valign="top" nowrap><font color="black">Default Theme:</font></td>
										<td align="left" valign="top"><input type="hidden" name="layout_url" value="{layout_url}"><input type="hidden" name="path_themes" value="{path_themes}"><input type="text" name="theme" value="{theme}" size="70"><br>
											<font size="2" color="#666699"><i>The theme a new user will see when they connect to the site. Standard choices are <b>Classic</b>, <b>Digital_Monochrome</b>, or <b>Yahoo</b>.<br>
											</i></font><font size="2" color="#666666"><i><br>
											</i></font></td>
									</tr>
									<tr>
										<td align="right" valign="top" nowrap><font color="black">Allow User-Defined Themes:</font></td>
										<td align="left" valign="top"><input type="checkbox" name="allow_user_themes" {userthemes_checked}><font size="2" color="#666699"><i>If you check this box, users can replace your site's theme with others installed on your site.<br>
											<br>
											</i></font></td>
									</tr>
								</table>
							</td>
						</tr>
					</table>
				</td>
			</tr>
			<tr>
				<td align="right" valign="top" width="100"></td>
				<td><br>
					<font size="2" color="#666699"><i><br>
					</i></font></td>
			</tr>
			</td>
			<tr>
				<td align="center" valign="top" colspan="2">
					<table border="1" cellpadding="1" cellspacing="2" width="90%">
						<tr>
							<td align="center" valign="top" bgcolor="#66cccc"><b>DATE FORMATTING OPTIONS - [<a href="../../../Library/WebServer/Documents/geeklog/system/install_templates/dateformatkey.html">Formatting Explained</a>]</b></td>
						</tr>
						<tr>
							<td>
								<table border="0" cellpadding="2" cellspacing="2">
									<tr>
										<td align="right" valign="top" nowrap><font color="black">Default Date Format:</font></td>
										<td align="left" valign="top"><input type="text" name="date" value="{date}" size="70"><br>
											<font color="#666699" size="2"><i>Shown in the header bar of each page; can be overridden by the user in their display settings. (the default format produces this output:Wednesday, December 05 2001 @ 02:07 PM PST)<br>
											<br>
											</i></font></td>
									</tr>
									<tr>
										<td align="right" valign="top" nowrap><font color="black">Day/Time Format:</font></td>
										<td align="left" valign="top"><input type="text" name="daytime" value="{daytime}" size="70"><font color="#3333ff"><i><br>
											</i></font><font color="#666699" size="2"><i>Used for the 'most recent post' entry on each article; can't be overridden by the users (the default format produces this output: 12/05 02:10PM)<br>
											<br>
											</i></font></td>
									</tr>
									<tr>
										<td align="right" valign="top" nowrap><font color="black">Short Date:</font></td>
										<td align="left" valign="top"><input type="text" name="shortdate" value="{shortdate}" size="70"><font size="2" color="#3333ff"><i><br>
											</i></font><font size="2" color="#666699"><i>Used in places such as the search results page; can't be overridden by users (the default format produces this output: 12/05/01)<br>
											</i></font></td>
									</tr>
								</table>
							</td>
						</tr>
					</table>
				</td>
			</tr>
			<tr>
				<td align="right" valign="top" width="100"><font color="#3333ff"><br>
					<br>
					</font></td>
				<td align="center"></td>
			</tr>
			<tr>
				<td align="center" valign="top" colspan="2">
					<table border="1" cellpadding="1" cellspacing="2" width="90%">
						<tr>
							<td align="center" valign="top" bgcolor="#66cccc"><b>COOKIE HANDLING</b></td>
						</tr>
						<tr>
							<td>
								<table border="0" cellpadding="2" cellspacing="2">
									<tr>
										<td align="right" valign="top" nowrap><font color="black">IP-based Sessions ID's:</font></td>
										<td align="left" valign="top"><input type="checkbox" name="cookie_ip" {cookieip_checked}><br>
											<font size="2" color="#666699"><i>When checked, this will store a combination of the user's IP number and a random number in the cookie. However, if enabled, dial-up users will most likely have to login every time they connect to the site.</i></font><font color="#666699"><br>
											</font></td>
									</tr>
									<tr>
										<td align="right" valign="top" nowrap><font color="#3333ff"><b>Long-Term Cookie Timeout</b></font></td>
										<td align="left" valign="top"><select name="default_perm_cookie_timeout" size="1">
												{longterm_options} 
											</select><font color="#666699" size="2"><i><br>
											How long should your site remember the user in between visits? If you don't use this feature then long-term cookies are disabled and session cookies are only used.<br>
											<br>
											</i></font></td>
									</tr>
									<tr>
										<td align="right" valign="top" nowrap><font color="black">Long-Term Cookie Name:</font></td>
										<td align="left" valign="top"><input type="text" name="cookie_name" value="{cookie_name}" size="70"><br>
											<font color="#666699" size="2"><i>The name of the cookie which will be stored on the user's local machine to represent the long-term cookie.<br>
											<br>
											</i></font></td>
									</tr>
									<tr>
										<td align="right" valign="top" nowrap><font color="black">Session Timeout:</font></td>
										<td align="left" valign="top"><select name="session_cookie_timeout" size="1">
												{session_options} 
											</select><br>
											<font color="#666699" size="2"><i>How long should your site remember the user during any particular visit? Only useful if long-term cookies are disabled.<br>
											<br>
											</i></font></td>
									</tr>
									<tr>
										<td align="right" valign="top" nowrap><font color="black">Session Cookie Name:</font></td>
										<td align="left" valign="top"><input type="text" name="cookie_session" value="{cookie_session}" size="70"><br>
											<font color="#666699" size="2"><i>The name of the session cookie which will be stored on the user's local machine to represent the session cookie.<br>
											<br>
											</i></font></td>
									</tr>
									<tr>
										<td align="right" valign="top">Poll Cookie Timeout:</td>
										<td align="left" valign="top"><select name="pollcookietime" size="1">
												{pollcookietime_options} 
											</select><br>
											<font size="2" color="#ff3300"><i>Explanation needed!</i></font><br>
											<br>
										</td>
									</tr>
									<tr>
										<td align="right" valign="top">Poll Address Timeout:</td>
										<td align="left" valign="top"><select name="polladdresstime" size="1">
												{polladdresstime_options} 
											</select><br>
											<font size="2" color="#ff3300"><i>Explanation needed!</i></font><br>
											<br>
										</td>
									</tr>
								</table>
							</td>
						</tr>
					</table>
				</td>
			</tr>
			<tr>
				<td align="right" valign="top" width="100"></td>
				<td><br>
					<br>
				</td>
			</tr>
			<tr>
				<td align="center" valign="top" colspan="2">
					<table border="1" cellpadding="1" cellspacing="2" width="90%">
						<tr>
							<td align="center" valign="top" bgcolor="#66cccc"><b>SYSTEM UTILITIES PATHS</b></td>
						</tr>
						<tr>
							<td>
								<table border="0" cellpadding="2" cellspacing="2">
									<tr>
										<td align="right" valign="top" nowrap><font color="blue"><b>Uncompress Command:</b></font></td>
										<td align="left" valign="top"><input type="text" name="unzipcommand" value="{unzipcommand}" size="70"><br>
											<font color="red" size="2"><i>NOTE: This setting is very important to get right</i></font><font color="#666699" size="2"><i> if you want to be able to use the web-based administration pages to remotely install plugins.<br>
											<b>*nix-based systems:</b> /bin/tar -C /path/to/geeklog/plugins/ -xzf<br>
											<b>Windows-based systems:</b> filzip.exe -e -r /path/to/geeklog/plugins/<br>
											</i></font><i><br>
											</i></td>
									</tr>
									<tr>
										<td align="right" valign="top" nowrap><font color="blue"><b>Remove Command:</b></font></td>
										<td align="left" valign="top"><input type="text" name="rmcommand" value="{rmcommand}" size="70"><br>
											<font color="red" size="2"><i>NOTE: This setting is very important to get right</i></font><font color="#666699" size="2"><i> if you want to be able to use the web-based administration pages to remotely remove plugins.<br>
											<b>*nix-based systems:</b> /bin/rm -Rf<br>
											<b>Windows-based systems:</b> rmdir /S /Q<br>
											<br>
											</i></font></td>
									</tr>
								</table>
							</td>
						</tr>
					</table>
				</td>
			</tr>
			<tr>
				<td align="right" valign="top" width="100"></td>
				<td><br>
					<font size="2" color="#ff3300"><i><br>
					</i></font></td>
			</tr>
			<tr>
				<td align="center" valign="top" colspan="2"><font color="#666699">
					<table border="1" cellpadding="1" cellspacing="2" width="90%">
						<tr>
							<td align="center" valign="top" bgcolor="#66cccc"><b>SITE DEFAULT SETTINGS</b></td>
						</tr>
						<tr>
							<td>
								<table border="0" cellpadding="2" cellspacing="2">
									<tr>
										<td align="right" valign="top" nowrap>Login Required:</td>
										<td align="left" valign="top"><input type="checkbox" name="loginrequired" {loginrequired_checked}><font size="2" color="#666699"><i>Check this if you want to force users to be logged in before submitting anything.<br>
											<br>
											</i></font></td>
									</tr>
									<tr>
										<td align="right" valign="top" nowrap>Comment Login Required:</td>
										<td align="left" valign="top"><input type="checkbox" name="commentsloginrequired" {commentsloginrequired_checked}><font size="2" color="#666699"><i>Check this if you want to force users to be logged in before submitting comments.<br>
											<br>
											</i></font></td>
									</tr>
									<tr>
										<td align="right" valign="top" nowrap>Default Post-Mode:</td>
										<td align="left" valign="top"><select name="postmode" size="1">
												<option value="plaintext" {plaintext_selected}>Plain Text
												<option value="html" {html_selected}>HTML
											</select> <font color="#666699" size="2"><i>When user's submit a story, will the default format be HTML or plain text?<br>
											</i></font><font size="2" color="#ff3300"><i><br>
											</i></font></td>
									</tr>
									<tr>
										<td align="right" valign="top" nowrap>Topic Sort Method:</td>
										<td align="left" valign="top"><select name="sortmethod" size="1">
												<option value="sortnum" {sortnum_checked}>Sort Number
												<option value="alpha" {alpha_checked}>Alphabetically
											</select><br>
											<font color="#666699" size="2"><i>The topics list can be sorted by the numeric perfix of each topic (the default behavior), or by the spelling of each topic name by changing this setting.</i></font><font color="#666699"><br>
											<br>
											</font></td>
									</tr>
									<tr>
										<td align="right" valign="top" nowrap>Show Story Count:</td>
										<td align="left" valign="top"><input type="checkbox" name="showstorycount" {showstorycount_checked}> <font color="#666699" size="2"><i>If checked, users will see the number of articles in each section of the site in the Sections box.<br>
											<br>
											</i></font></td>
									</tr>
									<tr>
										<td align="right" valign="top" nowrap>Show Submission Count:</td>
										<td align="left" valign="top"><input type="checkbox" name="showsubmissioncount" {showsubmissioncount_checked}> <font color="#666699" size="2"><i>If checked, admins will see the number of submissions in each section of the site in the Sections box.<br>
											<br>
											</i></font></td>
									</tr>
									<tr>
										<td align="right" valign="top" nowrap>Show What's New Block:</td>
										<td align="left" valign="top"><input type="checkbox" name="whatsnewbox" {whatsnewbox_checked}> <font color="#666699" size="2"><i>If checked, admins will see a &quot;What's New&quot; box, displaying a summary of recent articles, comments, and links.<br>
											<br>
											</i></font></td>
									</tr>
									<tr>
										<td align="right" valign="top" nowrap>Show Who's Online Block:</td>
										<td align="left" valign="top"><input type="checkbox" name="whosonline" {whosonline_checked}> <font color="#666699" size="2"><i>If checked, users will see a &quot;Who's Online&quot; box, displaying a list of logged in users and the number of guest (anonymous) users.<br>
											<br>
											</i></font></td>
									</tr>
                                    <tr>
                                        <td align="right" valign="top" nowrap>Who's Online Threshold:</td>
                                        <td align="left" valign="top"><input type="text" size="5" name="whosonline_threshold" value="{whosonline_threshold}"><br><font color="#666699" size="2"><i>This is how man seconds guest (anonymous) sessions are good for.  For example a value of 300 would show all guest users who visited a page on your site within the last 5 minutes.  This only pertains to guest (anonymous) accounts.<br>
                                            <br></i></font></td>
                                    </tr>
									<tr>
										<td align="right" valign="top" nowrap>New Stories Interval:</td>
										<td align="left" valign="top"><select name="newstoriesinterval" size="1">
												{newstoriesinterval_options} 
											</select><br>
											<font color="#666699" size="2"><i>Determines how far backwards in time to count to determine the number of &quot;New&quot; articles in the What's New box.<br>
											<br>
											</i></font></td>
									</tr>
									<tr>
										<td align="right" valign="top" nowrap>New Comments Interval:</td>
										<td align="left" valign="top"><select name="newcommentsinterval" size="1">
												{newcommentsinterval_options} 
											</select><br>
											<font color="#666699" size="2"><i>Determines how far backwards in time to count to select &quot;New&quot; comments for the What's New box<br>
											<br>
											</i></font></td>
									</tr>
									<tr>
										<td align="right" valign="top" nowrap>New Links Interval:</td>
										<td align="left" valign="top"><select name="newlinksinterval" size="1">
												{newlinksinterval_options} 
											</select><br>
											<font color="#666699" size="2"><i>Determines how far backwards in time to count to select &quot;New&quot; links for the What's New box<br>
											<br>
											</i></font></td>
									</tr>
									<!-- Not implemented yet
									<tr>
										<td align="right" valign="top" nowrap>Use Email Digests:</td>
										<td align="left" valign="top"><input type="checkbox" name="emailstories" {emailstories_checked}><br>
											<font color="#666699" size="2"><i>Allows users to have stories emailed to them. Note that this requires 'cron' access on the host and the use of PHP as a shell script.<br>
											<br>
											</i></font></td>
									</tr>
									-->
									<tr>
										<td align="right" valign="top" nowrap>Allow Personal Calendars:</td>
										<td align="left" valign="top"><input type="checkbox" name="personalcalendars" {personalcalendars_checked}><font color="#666699"> </font><font size="2" color="#666699"><i>If checked users will be able to add personal events to their own private calendar!<br>
											</i></font><font size="2" color="#ff3300"><i><br>
											</i></font></td>
									</tr>
									<tr>
										<td align="right" valign="top" nowrap>Calendar Event Types:</td>
										<td align="left" valign="top"><textarea name="event_types" wrap="virtual" cols="80" rows="5">{event_types}</textarea><br>
											<font size="2" color="#666699"><i>A comma-separated list of event types that can be assigned to events in the calendar.</i></font><font color="#666699"><br>
											<br>
											</font></td>
									</tr>
									<tr>
										<td align="right" valign="top" nowrap>Show Upcoming Events Block:</td>
										<td align="left" valign="top"><input type="checkbox" name="showupcomingevents" {showupcomingevents_checked}> <font color="#666699" size="2"><i>When checked, upcoming events are displayed in a box.<br>
											<br>
											</i></font></td>
									</tr>
									<tr>
										<td align="right" valign="top" nowrap>Default News Items:</td>
										<td align="left" valign="top"><input type="text" name="limitnews" value="{limitnews}" size="24"><br>
											<font color="#666699" size="2"><i>Sets is the default number of news articles that a new user will see<br>
											<br>
											</i></font></td>
									</tr>
									<tr>
										<td align="right" valign="top" nowrap>Minimum News Items:</td>
										<td align="left" valign="top"><input type="text" name="minnews" value="{minnews}" size="24"><br>
											<font size="2" color="#666699"><i>The minimum number of articles that a user may set in their preferences?<br>
											<br>
											</i></font></td>
									</tr>
									<tr>
										<td align="right" valign="top" nowrap>Show Older Stories Block:</td>
										<td align="left" valign="top"><input type="checkbox" name="olderstuff" {olderstuff_checked}> <font color="#666699" size="2"><i>When checked, users will see a block detailing older stories on the site.<br>
											<br>
											</i></font></td>
									</tr>
									<tr>
										<td align="right" valign="top" nowrap>Default Comment Mode:</td>
										<td align="left" valign="top"><select name="comment_mode" size="1">
												<option value="flat" {flat_selected}>Flat
												<option value="nested" {nested_selected}>Nested
												<option value="nocomments" {nocomments_selected}>No Comments
												<option value="threaded" {threaded_selected}>Threaded
											</select><br>
											<font color="#666699" size="2"><i>What format will comments be displayed in for a new user? <b>Flat</b> = all comments displayed in date order; <b>Nested</b> = comments displayed in hierarchy order fully expanded; <b>Threaded</b> = comments displayed in hierarchy order with only top-level comments expanded; <b>No Comments</b> = Comments not displayed.<br>
											<br>
											</i></font></td>
									</tr>
								</table>
							</td>
						</tr>
					</table>
					</font></td>
			</tr>
			<tr>
				<td align="right" valign="top" width="100"></td>
				<td><br>
					<br>
				</td>
			</tr>
			<tr>
				<td align="center" valign="top" colspan="2">
					<table border="1" cellpadding="1" cellspacing="2" width="90%">
						<tr>
							<td align="center" valign="top" bgcolor="#66cccc"><b>PUBLISHING PREFERENCES</b></td>
						</tr>
						<tr>
							<td>
								<table border="0" cellpadding="2" cellspacing="2">
									<tr>
										<td align="right" valign="top" nowrap width="100">Show Contributed-by Line:</td>
										<td align="left" valign="top"><input type="checkbox" name="contributedbyline" {contributedbyline_checked}> <font color="#666699" size="2"><i>When checked, users will see the name of the story contributor in the article summary.<br>
											</i></font><font color="#666666" size="2"><i><br>
											</i></font></td>
									</tr>
									<tr>
										<td align="right" valign="top" nowrap width="100">Speed Limit:</td>
										<td align="left" valign="top"><input type="text" name="speedlimit" value="{speedlimit}" size="24"><br>
											<font color="#666699" size="2"><i>The interval, in seconds, between allowed posts. 300 seconds = 5 minutes. This prevents easy flooding of the site by one user.<br>
											<br>
											</i></font></td>
									</tr>
									<tr>
										<td align="right" valign="top" nowrap width="100">Comment Speed Limit</td>
										<td align="left" valign="top"><input type="text" name="commentspeedlimit" value="{commentspeedlimit}" size="24"><br>
											<font color="#666699" size="2"><i>The interval, in seconds, between allowed comments. This prevents easy flooding of the site by one user.<br>
											<br>
											</i></font></td>
									</tr>
									<tr>
										<td align="right" valign="top" nowrap width="100">Article Image Align:</td>
										<td align="left" valign="top"><select name="article_image_align" size="1">
												<option value="left" {left_checked}>Left
												<option value="right" {right_checked}>Right
											</select><br>
											<font color="#666699" size="2"><i>Where should the topic icons that accompany each article be aligned in the story?<br>
											<br>
											</i></font></td>
									</tr>
									<tr>
										<td align="right" valign="top" nowrap width="100">Comment Limit:</td>
										<td align="left" valign="top"><input type="text" name="comment_limit" value="{comment_limit}" size="24"><br>
											<font color="#666699" size="2"><i>How many comments may be posted with any given story?<br>
											<br>
											</i></font></td>
									</tr>
									<tr>
										<td align="right" valign="top" nowrap width="100">Max. Poll Questions:</td>
										<td align="left" valign="top"><input type="text" name="maxanswers" value="{maxanswers}" size="24"><br>
											<font color="#666699" size="2"><i>What is the maximum number of questions possible in a survey.<br>
											<br>
											</i></font></td>
									</tr>
									<tr>
										<td align="right" valign="top" nowrap width="100">Censor Mode:</td>
										<td align="left" valign="top"><input type="checkbox" name="censormode" {censormode_checked}> <font size="2" color="#666699"><i>If you want to censor out inappropriate words or phrases check this!<br>
											<br>
											</i></font></td>
									</tr>
									<tr>
										<td align="right" valign="top" nowrap width="100">Censor Replacement:</td>
										<td align="left" valign="top"><input type="text" size="50" name="censorreplace" value="{censorreplace}"><br>
											<font color="#666699" size="2"><i>What word or symbols show up to replace a censored word.<br>
											<br>
											</i></font></td>
									</tr>
									<tr>
										<td align="right" valign="top" nowrap width="100">Censor Word List:</td>
										<td align="left" valign="top"><input type="text" size="70" name="censorlist" value="{censorlist}"><br>
											<font color="#666699" size="2"><i>A listing of all censored words.<br>
											<br>
											</i></font></td>
									</tr>
									<tr>
										<td align="right" valign="top" width="100">Allowable HTML:</td>
										<td><textarea name="allowablehtml" wrap="virtual" cols="80" rows="10">{allowablehtml}</textarea><br>
											<font color="#666699" size="2"><i>Enter the HTML codes that users will be allowed to use when entering stories.  Separate entries with a comma.<br>
											<br>
											</i></font></td>
									</tr>
									<tr>
										<td align="right" valign="top" nowrap width="100">Publish RDF Headline Feed:</td>
										<td align="left" valign="top"><input type="checkbox" name="backend" {backend_checked}> <font color="#666699" size="2"><i>When checked, your site's headlines will be available to sites and programs capable of reading RDF files. NOTE: Make sure the 'backend' directory has 777 permissions set.<br>
											<br>
											</i></font></td>
									</tr>
								</table>
							</td>
						</tr>
					</table>
				</td>
			</tr>
			<tr>
				<td colspan="2" align="center"><input type="hidden" name="page" value="2"><input type="submit" name="action" value="&lt;&lt; Previous"> <input type="submit" name="action" value="Next &gt;&gt;"></td>
			</tr>
		</table>
		</form>
	</body>

</html>
