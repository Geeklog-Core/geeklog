<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN">
<html>
<head><title>Geeklog Installation: Database Settings</title></head>
<body bgcolor="#ffffff">
    <h2>Geeklog Database Settings (Step 3 of 3)</h2>
    <P>Now we are ready to get your database settings.  In the case you are upgrading an existing Geeklog installation we will prepopulate the form with your current settings.  <b>NOTE:</b> If you are upgrading from Geeklog 1.3 or later AND you are using the non-default table names (e.g. gl_users instead of users) you will want to edit your old lib-database.php and remove everything after the line that says "DO NOT TOUCH ANYTHING BELOW HERE".  That's because after you hit "next" we are going to include that file so we have tables names from your last installation.  If you used the same prefix for ALL tables (which is preferred) and that was the only change you made you can, instead, supply that prefix below and we make the changes for you.
    <P>For fresh installations you will be able to modify the tables names that geeklog uses so that you can easily integrate Geeklog with other applications.  If you are upgrading you will not have this option.<P> We hope that at this point you have already backed-up your existing database (if you have one).  If you haven't then <b>do so <i>before</i> clicking the 'Next' button below</b>.  You've been warned. 
    <form action="install.php" method="post">
    <input type="hidden" name="upgrade" value="{upgrade}">
    <table cellpadding="3" cellspacing="0" border="0">
<!--
        <tr>
            <td align="right"><font color="#3333ff"><b>DBMS:</b></font></td>
            <td><input type="text" size="50" name="dbms" value="{dbms}"></td>
        </tr>
-->
        <input type="hidden" name="dbms" value="mysql">
        <tr>
            <td align="right"><font color="#3333ff"><b>Database Host:</b></font></td>
            <td><input type="text" size="50" name="dbhost" value="{dbhost}"></td>
        </tr>
        <tr>
            <td align="right"><font color="#3333ff"><b>Database Name:</b></font></td>
            <td><input type="text" size="50" name="dbname" value="{dbname}"></td>
        </tr>
        <tr>
            <td align="right"><font color="#3333ff"><b>DB User Name:</b></font></td>
            <td><input type="text" size="50" name="dbuser" value="{dbuser}"></td>
        </tr>
        <tr>
            <td align="right"><font color="#3333ff"><b>DB Password:</b></font></td>
            <td><input type="password" size="50" name="dbpass" value="{dbpass}"></td>
        </tr>   
        <tr>
            <td align="right"><font color="#3333ff"><b>Table Prefix (optional):</b></font></td>
            <td><input type="text" size="30" name="prefix" value=""></td>
        </tr>   
        <tr>
            <td align="right"><font color="#3333ff"><b>Path to mysqldump (optional):</b></font></td>
            <td><input type="text" size="50" name="dbmysqldump" value=""></td>
        </tr>
        {UPGRADE_OPTIONS}
    </table>
    {DB_TABLE_OPTIONS}
    <input type="hidden" name="page" value="3">
    <input type="hidden" name="geeklog_path" value="{geeklog_path}">
    <center><input type="submit" name="action" value="<< Previous">&nbsp;<input type="submit" name="action" value="Next >>"></center>
    </form>
</body>
</html>
