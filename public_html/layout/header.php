<?php
     $mtime = microtime();
     $mtime = explode(" ",$mtime);
     $mtime = $mtime[1] + $mtime[0];
     $starttime = $mtime;
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN">
<html>
<head>
<?php
$window_title = $CONF["site_name"];
if (!empty($CONF["pagetitle"])) {
        $window_title = $window_title . " - " . $CONF["pagetitle"];
} else {
        $window_title = $window_title . " - " . $CONF["site_slogan"];
}
?>
<title><?php echo $window_title ?></title>
<?php include("{$CONF["path_html"]}layout/smartstyle.css"); ?>
</head>
<body background="<?php echo $CONF["site_url"]; ?>/images/bg.gif" link="#333366" vlink="#333366" alink="#333366">

<table border=0 cellspacing=0 cellpadding=0 width="100%">
<tr align=right valign=middle><td height=18 colspan=2><a href=<?php echo $CONF["site_url"]; ?>><?php print $LANG01[68];?></a>
 / <a href=mailto:<?php echo $CONF["site_mail"]; ?>><?php print $LANG01[69];?></a>&nbsp;</td></tr>
<tr valign=bottom><td>&nbsp;<a href=<?php echo $CONF["site_url"]; ?>><img src=<?php echo $CONF["site_url"]; ?>/images/logo.gif width=350 height=84 border=0 alt=<?php echo $CONF["site_name"] ?>></a></td>
<td align=right><form action="<?php echo $CONF["site_url"]; ?>/search.php" method=get><?php print $LANG01[70]?><input type=text size=15 name="query">&nbsp;<input type=hidden name=type value=all><input type=hidden name=mode value=search></form></td></tr>
<tr><td bgcolor=000000 colspan=2><img src=<?php echo $CONF["site_url"]; ?>/images/speck.gif width=1 height=1></td></tr>
<tr><td bgcolor=AAAAAA colspan=2><img src=<?php echo $CONF["site_url"]; ?>/images/speck.gif width=1 height=6></td></tr>
<tr><td bgcolor=FFFFFF colspan=2><img src=<?php echo $CONF["site_url"]; ?>/images/speck.gif width=1 height=1></td></tr>
</table>

<table border=0 cellspacing=0 cellpadding=0 width="100%">
<tr align=center valign=middle bgcolor=DDDDDD><td height=20>
<a href=<?php echo $CONF["site_url"]; ?>/submit.php?type=story><?php print $LANG01[71];?></a>
&#149; <a href=<?php echo $CONF["site_url"]; ?>/links.php><?php print $LANG01[72];?></a>
&#149; <a href=<?php echo $CONF["site_url"]; ?>/pollbooth.php><?php print $LANG01[73];?></a>
&#149; <a href=<?php echo $CONF["site_url"]; ?>/calendar.php><?php print $LANG01[74];?></a>
<?php PrintPluginHeaderMenuItems(); ?>
&#149; <a href=<?php echo $CONF["site_url"]; ?>/search.php><?php print $LANG01[75];?></a>
&#149; <a href=<?php echo $CONF["site_url"]; ?>/stats.php><?php print $LANG01[76];?></a></td></tr>
<tr><td bgcolor=AAAAAA><img src=<?php echo $CONF["site_url"]; ?>/images/speck.gif width=1 height=1></td></tr>
<tr><td bgcolor=EEEEEE><img src=<?php echo $CONF["site_url"]; ?>/images/speck.gif width=1 height=10></td></tr>
</table>

<table border=0 cellspacing=0 cellpadding=0 width="100%">
<tr><td bgcolor=FFFFFF colspan=2><img src=<?php echo $CONF["site_url"]; ?>/images/speck.gif width=1 height=1></td></tr>
<tr bgcolor=DDDDDD><td height=20>&nbsp;<b><?php print $LANG01[67] . $CONF["site_name"]; ?>
<?php if (!empty($USER["username"])) echo " {$USER["username"]}"; ?>!</b></td><td align=right><b><?php echo date("D M j"); ?></b>&nbsp;</td></tr>
<tr><td bgcolor=AAAAAA colspan=2><img src=<?php echo $CONF["site_url"]; ?>/images/speck.gif width=1 height=1></td></tr>
<tr><td bgcolor=FFFFFF colspan=2><img src=<?php echo $CONF["site_url"]; ?>/images/speck.gif width=1 height=15></td></tr>
</table>

<!-- feature block -->
<table bgcolor=ffffff border=0 cellspacing=0 cellpadding=5 width="100%">
<tr><td class=featureblock valign=top width=150 rowspan=2>
<?php

startblock("Sections");
showtopics($topic);
endblock();

?>
<?php usermenu();printupcomingevents();?>
<?php whatsnewblock();?>
<IMG SRC=<?php echo $CONF["site_url"]; ?>/images/speck.gif width=150 height=1></td>

<!-- spacer block -->
<td width=1><IMG SRC=<?php echo $CONF["site_url"]; ?>/images/speck.gif width=1 height=1></td>

<!-- story block -->
<td width="100%" valign=top>
