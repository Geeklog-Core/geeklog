<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN">
<html>
<head><title>Geeklog Installation: Database Setup</title></head>
<body bgcolor="#ffffff">
    <h2>Geeklog Database Settings (Step 2 of 2)</h2>
    <P>Now we are ready to get your database status. We hope that at this point you have already backed-up your existing database (if you have one).  If you haven't then <b>do so <i>before</i> clicking the 'Next' button below</b>.  You've been warned. 
    <form action="install.php" method="post">
    <input type="hidden" name="upgrade" value="{upgrade}">
    <table cellpadding="3" cellspacing="0" border="0">
        {UPGRADE_OPTIONS}
    </table>
    <input type="hidden" name="page" value="2">
    <input type="hidden" name="geeklog_path" value="{geeklog_path}">
    <center><input type="submit" name="action" value="<< Previous">&nbsp;<input type="submit" name="action" value="Next >>"></center>
    </form>
</body>
</html>
