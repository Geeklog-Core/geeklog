<?php
$_SQL[] = "INSERT INTO {$_TABLES['blocks']} (name, type, title, tid, blockorder, content, rdfurl, rdfupdated, onleft, phpblockfn, group_id, owner_id, perm_owner, perm_group, perm_members, perm_anon) VALUES ('whosonline_block','phpblock','Who\'s Online','all',0,'','','0000-00-00 00:00:00',0,'phpblock_whosonline',4,2,3,3,2,2) ";
$_SQL[] = "CREATE INDEX stories_tid ON {$_TABLES['stories']}(tid)";
$_SQL[] = "CREATE INDEX group_assignments_ug_grp_id ON {$_TABLES['group_assignments']}(ug_grp_id)"; 
$_SQL[] = "ALTER TABLE {$_TABLES['blocks']} ADD help varchar(96) default NULL";
?>
