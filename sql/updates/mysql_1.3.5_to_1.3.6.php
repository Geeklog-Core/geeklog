<?php

$_SQL[] = "DELETE FROM {$_TABLES['commentcodes']} WHERE code = 1";

$_SQL[] = "INSERT INTO {$_TABLES['features']} (ft_name, ft_descr, ft_gl_core) VALUES ('story.submit', 'May skip the story submission queue', 1)";
$_SQL[] = "INSERT INTO {$_TABLES['features']} (ft_name, ft_descr, ft_gl_core) VALUES ('link.submit', 'May skip the link submission queue', 1)";
$_SQL[] = "INSERT INTO {$_TABLES['features']} (ft_name, ft_descr, ft_gl_core) VALUES ('event.submit', 'May skip the event submission queue', 1)";

?>
