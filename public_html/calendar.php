<?
	
	include ("common.php");
	include ("custom_code.php");
	include ("layout/alt_header.php");
	if (($mode == "personal") && (empty($USER["uid"]))) { 
		showmessage(25);
		$mode = "";
	}

	$currentday = date("j", time());
	$currentmonth = date("m", time());
	$currentyear = date("Y", time());
	$lastday = "01";
	if (strlen($currentday) == 1) $currentday = "0" . $currentday;
	if (strlen($currentmonth) == 1) $currentmonth = "0" . $currentmonth;

	if (!$month)
	{
		$month = date("m", time());
		$year = date("Y", time());
	}

	//mysql_select_db($mysql_database, $database);
	if ($msg > 0)
		showmessage($msg);
	echo "<center>";
/*<font face=Arial size=5><b>";
	echo date('F', mktime(0,0,0,$month,1,$year));
	echo " $year<p><font size=3></b><p>"; */

	$firstday = date( 'w', mktime(0,0,0,$month,1,$year));
	while (checkdate($month,$lastday,$year))
	{
	        $lastday++;
	}      
	
	$nextmonth = $month+1;
	$nextyear = $year;
	if ($nextmonth == 13)
	{
		$nextmonth = 1;
		$nextyear = $year + 1;
	}
	$lastmonth = $month-1;
	$lastyear = $year;
	if ($lastmonth == 0)
	{
		$lastmonth = 12;
		$lastyear = $year-1;
	}
	if (strlen($lastmonth) == 1) $lastmonth = "0" . $lastmonth;
	if (strlen($nextmonth) == 1) $nextmonth = "0" . $nextmonth;
	echo "<table><tr>";     
        echo "<td><form method=post action=calendar.php><input type=submit value='<<'>
                <input type=hidden name=month value=$lastmonth>
                <input type=hidden name=year value=$lastyear></form></td>";
        //echo "<td><form method=post action=operate.php3>        
	if ($mode <> "personal") {
		echo "<td><form method=post action=submit.php?type=event>
                	<input type=submit name=action value=\"$LANG30[8]\">
                	<input type=hidden name=month value=$month>
                	<input type=hidden name=year value=$year></form></td>";
		if (!empty($USER["uid"])) {
			echo "<td><form method=post action=calendar.php?mode=personal>
		      	      <input type=submit name=action value=\"$LANG30[12]\">
		      	      </form></td>";
		}
	} else {
		echo "<td><form method=post action=calendar.php>
		      <input type=submit name=action value=\"$LANG30[11]\">
		      </form></td>";
	}

        echo "<td><form method=post action=calendar.php><input type=submit value='>>'>
                <input type=hidden name=month value=$nextmonth> 
                <input type=hidden name=year value=$nextyear></form></td></tr></table>";

	echo "<table width=100% cellpadding=5 cellspacing=5 border=1>";
	echo "<tr><td align=center colspan=7 bgcolor={$CONF["headingbgcolor"]}><b><font color={$CONF["headingtextcolor"]}>";
	echo date('F', mktime(0,0,0,$month,1,$year));
	echo " $year</font></b></td></tr>";
	echo "<tr><td width=14% bgcolor={$CONF["headingbgcolor"]}><font color={$CONF["headingtextcolor"]}><b>{$LANG30[1]}</b></font></td>
		  <td width=14% bgcolor={$CONF["headingbgcolor"]}><font color={$CONF["headingtextcolor"]}><b>{$LANG30[2]}</b></font></td>
		  <td width=14% bgcolor={$CONF["headingbgcolor"]}><font color={$CONF["headingtextcolor"]}><b>{$LANG30[3]}</b></font></td>
                  <td width=14% bgcolor={$CONF["headingbgcolor"]}><font color={$CONF["headingtextcolor"]}><b>{$LANG30[4]}</b></font></td>
		  <td width=14% bgcolor={$CONF["headingbgcolor"]}><font color={$CONF["headingtextcolor"]}><b>{$LANG30[5]}</b></font></td>
		  <td width=16% bgcolor={$CONF["headingbgcolor"]}><font color={$CONF["headingtextcolor"]}><b>{$LANG30[6]}</b></font></td>
		  <td width=14% bgcolor={$CONF["headingbgcolor"]}><font color={$CONF["headingtextcolor"]}><b>{$LANG30[7]}</b></font></td></tr>";

	for ($i=0; $i<7; $i++)
	{
		if ($i < $firstday)
		{
			echo "<td></td>";
		}
		else
		{
			$thisday = ($i+1)-$firstday;

			if ($currentyear > $year)
			{
				echo "<td valign=top bgcolor=dddddd>";
			}
			else if ($currentmonth > $month && $currentyear == $year)
			{
				echo "<td valign=top bgcolor=dddddd>";
			}
			else if ($currentmonth == $month && $currentday > $thisday && $currentyear == $year)
			{
				echo "<td valign=top bgcolor=dddddd>";
			}
			else
			{
				echo "<td valign=top bgcolor=white>";
			}
			if (strlen($thisday) == 1) $thisday = "0" . $thisday;
			echo "<a href=calendar_event.php?day=$thisday&month=$month&year=$year>$thisday</a><br><hr>
				<font size=2>";
			//if ($thisday < 10) $thisday = "0" . $thisday;
			if ($mode == "personal") {
				$calsql = "SELECT events.title,userevent.eid FROM events,userevent WHERE (events.eid = userevent.eid) AND (userevent.uid = {$USER["uid"]}) AND ((datestart >= \"$year-$month-$thisday 00:00:00\" AND datestart <= \"$year-$month-$thisday 23:59:59\") OR (dateend >= \"$year-$month-$thisday 00:00:00\" AND dateend <= \"$year-$month-$thisday 23:59:59\") OR (\"$year-$month-$thisday\" between datestart and dateend)) ORDER BY datestart";
			} else {
				$calsql = "SELECT title,eid FROM events WHERE (datestart >= \"$year-$month-$thisday 00:00:00\" AND datestart <= \"$year-$month-$thisday 23:59:59\") OR (dateend >= \"$year-$month-$thisday 00:00:00\" AND dateend <= \"$year-$month-$thisday 23:59:59\") OR (\"$year-$month-$thisday\" between datestart and dateend) ORDER BY datestart";
			}
			$query2 = mysql_query($calsql);
			for ($j = 0; $j<mysql_num_rows($query2); $j++)
			{
				$results = mysql_fetch_array($query2);
				if ($results["title"])
				{
					echo "<a href=calendar_event.php?&eid=$results[eid]>$results[title]</a><br><hr>";
				}
			}
			if (mysql_num_rows($query2) < 4)
			{
				for ($j=0; $j<(4-mysql_num_rows($query2)); $j++)
					echo "<br>";
			}
			echo "</td>";
		}
	}

	echo "</tr>\n";
	$nextday = ($i+1)-$firstday;

	for ($j = 0; $j<5; $j++)
	{
		echo "<tr>";
		for ($k = 0; $k<7; $k++)
		{
			if ($nextday < $lastday)
			{
				if ($currentyear > $year)
                                {       
                                        echo "<td valign=top bgcolor=dddddd>";
                                }
				else if ($currentmonth > $month && $currentyear == $year)
                        	{       
                               		echo "<td valign=top bgcolor=dddddd>";
                        	}               
                        	else if ($currentmonth == $month && $currentday > $nextday && $currentyear == $year)
                        	{
                                	echo "<td valign=top bgcolor=dddddd>";
                        	}
                        	else    
                        	{
                               		echo "<td valign=top bgcolor=white>";
                        	}
				if (strlen($nextday) == 1) $nextday = "0" . $nextday;
				echo "<a href=calendar_event.php?day=$nextday&month=$month&year=$year>$nextday</a><br><hr>
					<font size=2>";
				if ($mode == "personal") {
					$query3 = mysql_query("SELECT events.title,userevent.eid FROM events,userevent WHERE (events.eid = userevent.eid) AND (userevent.uid = {$USER["uid"]}) AND ((datestart >= \"$year-$month-$nextday 00:00:00\" AND datestart <= \"$year-$month-$nextday 23:59:59\") OR (dateend >= \"$year-$month-$nextday 00:00:00\" AND dateend <= \"$year-$month-$nextday 23:59:59\") OR (\"$year-$month-$nextday\" between datestart and dateend)) ORDER BY datestart");
				} else {
					$query3 = mysql_query("SELECT title,eid FROM events WHERE (datestart >= \"$year-$month-$nextday 00:00:00\" AND datestart <= \"$year-$month-$nextday 23:59:59\") OR (dateend >= \"$year-$month-$nextday 00:00:00\" AND dateend <= \"$year-$month-$nextday 23:59:59\") OR (\"$year-$month-$nextday\" between datestart and dateend) ORDER BY datestart");
				}
				for ($i = 0; $i<mysql_num_rows($query3)+4; $i++)
				{
					$results2 = mysql_fetch_array($query3);
					if ($results2["title"])
					{
						echo "<a href=calendar_event.php?eid=$results2[eid]>$results2[title]</a><br><hr>";
					}
					else if ($i < 4)
					{
						echo "<br>";
					}
				}
				echo "</td>";
				$nextday++;
			}
		}
		echo "</tr>\n";
	}

	echo "</table><font size=3>";


	echo "<table><tr>";
	echo "<td><form method=post action=calendar.php><input type=submit value='<<'>
		<input type=hidden name=month value=$lastmonth>
		<input type=hidden name=year value=$lastyear></form></td>";
	//echo "<td><form method=post action=operate.php3>
	if ($mode <> "personal") {
		echo "<td><form method=post action=submit.php?type=event>
                	<input type=submit name=action value=\"$LANG30[8]\">
                	<input type=hidden name=month value=$month>
                	<input type=hidden name=year value=$year></form></td>";
		if (!empty($USER["uid"])) {
			echo "<td><form method=post action=calendar.php?mode=personal>
		              <input type=submit name=action value=\"$LANG30[12]\">
		              </form></td>";
		}
	} else {
		echo "<td><form method=post action=calendar.php>
		      <input type=submit name=action value=\"$LANG30[11]\">
		      </form></td>";
	}

	echo "<td><form method=post action=calendar.php><input type=submit value='>>'>
		<input type=hidden name=month value=$nextmonth>
		<input type=hidden name=year value=$nextyear></form></td></tr></table>";

	include ("layout/footer.php");
?>
