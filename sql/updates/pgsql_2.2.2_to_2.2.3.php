<?php

// Optimize time-filtered Likes Block queries (issue #1177).
// This migration must be wired into the 2.2.3 installer upgrade sequence.
$_SQL[] = "CREATE INDEX {$_TABLES['likes']}_created ON {$_TABLES['likes']} (created)";
