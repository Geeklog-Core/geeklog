<?php
	
	include('lib-common.php');
		
	$display .= site_header('');
	
	if ($mode == 'personal' && ($CONF['personalcalendars'] == 0)) {
		$display .= showmessage(29)
			.site_footer();
		echo $display;
		exit;
	}
	
	if (($mode == 'personal') && (empty($USER['uid']))) { 
		$display .= showmessage(25);
		$mode = '';
	}
	$currentday = date("j", time());
	$currentmonth = date("m", time());
	$currentyear = date("Y", time());
	$lastday = "01";
	
	if (strlen($currentday) == 1) {
		$currentday = '0'.$currentday;
	}
	
	if (strlen($currentmonth) == 1) {
		$currentmonth = '0'.$currentmonth;
	}
	if (!$month) {
		$month = date("m", time());
		$year = date("Y", time());
	}
	//mysql_select_db($mysql_database, $database);
	if ($msg > 0) {
		$display .= showmessage($msg);
	}
	
	$firstday = date('w',mktime(0,0,0,$month,1,$year));
	while (checkdate($month,$lastday,$year)) {
		$lastday++;
	}      
	
	$nextmonth = $month+1;
	$nextyear = $year;
	if ($nextmonth == 13) {
		$nextmonth = 1;
		$nextyear = $year + 1;
	}
	
	$lastmonth = $month-1;
	$lastyear = $year;
	if ($lastmonth == 0) {
		$lastmonth = 12;
		$lastyear = $year-1;
	}
	
	if (strlen($lastmonth) == 1) {
		$lastmonth = '0'.$lastmonth;
	}
	
	if (strlen($nextmonth) == 1) {
		$nextmonth = '0'.$nextmonth;
	}
	
	// Beginning of Monthly Display	
	
	$display .= '<table width="100%" cellpadding="5" cellspacing="0" border="2" class="cal_body">'.LB
		.'<tr align="center">'.LB
		.'<td colspan="7" class="cal_month"><table border="0" width="100%">'
		.'<tr>'.LB
		.'<td class="cal_month"><form method="post" action="calendar.php">'
		.'<input type="submit" value="<<" title="Previous Month">'
		.'<input type="hidden" name="month" value="'.$lastmonth.'">'
		.'<input type="hidden" name="year" value="'.$lastyear.'"></form></td>'.LB
		.'<td width="100%" class="cal_month" align="center">'.date('F',mktime(0,0,0,$month,1,$year)).' '.$year.'</td>'.LB
		.'<td class="cal_month"><form method="post" action="calendar.php"><input type="submit" value=">>" title="Next Month">'
		.'<input type="hidden" name="month" value="'.$nextmonth.'>'
		.'<input type="hidden" name="year" value="'.$nextyear.'"></form></td>'.LB
		.'</tr>'.LB
		.'</table></td>'.LB
		.'</tr>'.LB
		.'<tr>'.LB
		.'<td width="15%" class="cal_day">'.$LANG30[1].'</td>'.LB
		.'<td width="14%" class="cal_day">'.$LANG30[2].'</td>'.LB
		.'<td width="14%" class="cal_day">'.$LANG30[3].'</td>'.LB
		.'<td width="14%" class="cal_day">'.$LANG30[4].'</td>'.LB
		.'<td width="14%" class="cal_day">'.$LANG30[5].'</td>'.LB
		.'<td width="14%" class="cal_day">'.$LANG30[6].'</td>'.LB
		.'<td width="15%" class="cal_day">'.$LANG30[7].'</td>'.LB
		.'</tr>'.LB;
		
	for ($i=0; $i<7; $i++) {
		if ($i < $firstday) {
			// These are NULL calendar days, at the top of the month display
			$display .= '<td class="cal_nullday">&nbsp;</td>';
		} else {
			$thisday = ($i+1)-$firstday;
			if ($currentyear > $year) {
				$display .= '<td valign="top" class="cal_oldday">';
			} else if ($currentmonth > $month && $currentyear == $year) {
				$display .= '<td valign="top" class="cal_oldday">';
			} else if ($currentmonth == $month && $currentday > $thisday && $currentyear == $year) {
				$display .= '<td valign="top" class="cal_oldday">';
			} else {
				$display .= '<td valign="top" class="cal_newday">';
			}
			
			if (strlen($thisday) == 1) {
				$thisday = '0'.$thisday;
			}
			
			$display .= '<a href="calendar_event.php?day='.$thisday.'&month='.$month.'&year='.$year.'" class="cal_date">'.$thisday.'</a><hr>';
			
			if ($mode == 'personal') {
				$calsql = "SELECT {$CONF["db_prefix"]}events.* FROM {$CONF["db_prefix"]}events, {$CONF["db_prefix"]}userevent WHERE ({$CONF["db_prefix"]}events.eid = userevent.eid) AND (userevent.uid = {$USER["uid"]}) AND ((datestart >= \"$year-$month-$thisday 00:00:00\" AND datestart <= \"$year-$month-$thisday 23:59:59\") OR (dateend >= \"$year-$month-$thisday 00:00:00\" AND dateend <= \"$year-$month-$thisday 23:59:59\") OR (\"$year-$month-$thisday\" between datestart and dateend)) ORDER BY datestart";
			} else {
				$calsql = "SELECT * FROM {$CONF["db_prefix"]}events WHERE (datestart >= \"$year-$month-$thisday 00:00:00\" AND datestart <= \"$year-$month-$thisday 23:59:59\") OR (dateend >= \"$year-$month-$thisday 00:00:00\" AND dateend <= \"$year-$month-$thisday 23:59:59\") OR (\"$year-$month-$thisday\" between datestart and dateend) ORDER BY datestart";
			}
			
			$query2 = mysql_query($calsql);
			
			for ($j = 0; $j<mysql_num_rows($query2); $j++) {
				$results = mysql_fetch_array($query2);
				if (hasaccess($A['owner_id'],$A['group_id'],$A['perm_owner'],$A['perm_group'],$A['perm_members'],$A['perm_anon']) > 0) {
					if ($results['title']) {
						$display .= '<a href="calendar_event.php?&eid='.$results[eid].'" class="cal_event">'.$results[title].'</a><hr>';
					}
				} else {
					$display .= '<br>';
				}
			}
			if (mysql_num_rows($query2) < 4) {
				for ($j=0; $j<(4-mysql_num_rows($query2)); $j++) {
					$display .= '<br>';
				}
			}
			$display .= '</td>';
		}
	}
	$display .= '</tr>'.LB;
	
	$nextday = ($i+1)-$firstday;
	for ($j = 0; $j<5; $j++) {
		$display .= "<tr>";
		for ($k = 0; $k<7; $k++) {
			if ($nextday < $lastday) {
				if ($currentyear > $year) {       
					$display .= '<td valign="top" class="cal_oldday">';
				} else if ($currentmonth > $month && $currentyear == $year) {       
					$display .= '<td valign="top" class="cal_oldday">';
				} else if ($currentmonth == $month && $currentday > $nextday && $currentyear == $year) {
					$display .= '<td valign="top" class="cal_oldday">';
				} else {
					$display .= '<td valign="top" class="cal_newday">';
				}
				
				if (strlen($nextday) == 1) {
					$nextday = "0" . $nextday;
				}
				
				$display .= '<a href="calendar_event.php?day='.$nextday.'&month='.$month.'&year='.$year.'" class="cal_date">'.$nextday.'</a><hr>';
				if ($mode == 'personal') {
					$query3 = mysql_query("SELECT {$CONF["db_prefix"]}events.* FROM {$CONF["db_prefix"]}events,userevent WHERE ({$CONF["db_prefix"]}events.eid = userevent.eid) AND (userevent.uid = {$USER["uid"]}) AND ((datestart >= \"$year-$month-$nextday 00:00:00\" AND datestart <= \"$year-$month-$nextday 23:59:59\") OR (dateend >= \"$year-$month-$nextday 00:00:00\" AND dateend <= \"$year-$month-$nextday 23:59:59\") OR (\"$year-$month-$nextday\" between datestart and dateend)) ORDER BY datestart");
				} else {
					$query3 = mysql_query("SELECT * FROM {$CONF["db_prefix"]}events WHERE (datestart >= \"$year-$month-$nextday 00:00:00\" AND datestart <= \"$year-$month-$nextday 23:59:59\") OR (dateend >= \"$year-$month-$nextday 00:00:00\" AND dateend <= \"$year-$month-$nextday 23:59:59\") OR (\"$year-$month-$nextday\" between datestart and dateend) ORDER BY datestart");
				}
				
				for ($i = 0; $i<mysql_num_rows($query3)+4; $i++) {
					$results2 = mysql_fetch_array($query3);
					if (hasaccess($A["owner_id"],$A["group_id"],$A["perm_owner"],$A["perm_group"],$A["perm_members"],$A["perm_anon"]) > 0) {
						if ($results2["title"]) {
							$display .= '<a href="calendar_event.php?eid='.$results2[eid].'" class="cal_event">'.$results2[title].'</a><hr>';
						} else if ($i < 4) {
							$display .= '<br>';
						}
					} else {
						$display .= '<br>';
					}
				}
				$display .= '</td>';
				$nextday++;
			}
		}
		$display .= '</tr>'.LB;
	}
	$display .= '</table>'.LB;
	// Let's display that Menu Line again
	
	$display .= '<table align="center">'.LB
		.'<tr>'.LB
		.'<td><form method="post" action="calendar.php">'
		.'<input type="submit" value="<<">'
		.'<input type="hidden" name="month" value="'.$lastmonth.'">'
		.'<input type="hidden" name="year" value="'.$lastyear.'"></form></td>'.LB;
		
	if ($mode <> 'personal') {
		$display .= '<td><form method="post" action="submit.php?type=event">'
			.'<input type="submit" name="action" value="'.$LANG30[8].'">'
			.'<input type="hidden" name="month" value="'.$month.'">'
			.'<input type="hidden" name="year" value="'.$year.'"></form></td>'.LB;
			
		if (!empty($USER["uid"]) && ($CONF["personalcalendars"] == 1)) {
			$display .= '<td><form method="post" action="calendar.php?mode=personal">'
				.'<input type="submit" name="action" value="'.$LANG30[12].'"></form></td>'.LB;
		}
	} else {
		$display .= '<td><form method="post" action="calendar.php">'
			.'<input type="submit" name="action" value="'.$LANG30[11].'"></form></td>'.LB;
	}
	$display .= '<td><form method="post" action="calendar.php"><input type="submit" value=">>">'
		.'<input type="hidden" name="month" value="'.$nextmonth.'>'
		.'<input type="hidden" name="year" value="'.$nextyear.'"></form></td>'.LB
		.'</tr>'.LB
		.'</table>'.LB;
	$display .= site_footer();
	
	echo $display;
?>