<!-- begin footer.inc -->
</td>
</tr>
</table>

<table border=0 cellspacing=0 cellpadding=0 width="100%">
<tr><td bgcolor=000000 colspan=2><img src=<?php echo $CONF["base"]; ?>/images/speck.gif width=1 height=1></td></tr>
<tr><td bgcolor=AAAAAA colspan=2><img src=<?php echo $CONF["base"]; ?>/images/speck.gif width=1 height=6></td></tr>
<tr><td bgcolor=EEEEEE colspan=2><img src=<?php echo $CONF["base"]; ?>/images/speck.gif width=1 height=1></td></tr>
<tr bgcolor=DDDDDD valign=top><td height=20 class=footer>&nbsp;Copyright &copy; 2000 <?php echo $CONF["sitename"];?><br>
&nbsp;All trademarks and copyrights on this page are owned by their respective owners.</td>
<td align=right class=footer>Powered By: <a href=http://www.geeklog.org>GeekLog v<?php echo $VERSION;?></a>
<?php
     	$mtime = microtime();
     	$mtime = explode(" ",$mtime);
     	$mtime = $mtime[1] + $mtime[0];
    	$endtime = $mtime;
	$totaltime = sprintf("%.2f",$endtime - $starttime);
     	$howfast = $LANG01[91] . ' ' . $totaltime . ' ' . $LANG01[92];
	print '<br>' . $howfast;
?>
</td></tr>
<tr><td bgcolor=AAAAAA colspan=2><img src=<?php echo $CONF["base"]; ?>/images/speck.gif width=1 height=1></td></tr>
</table>

<?php hit() ?>

</body>
</html>
