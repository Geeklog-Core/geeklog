<?php

// Optimize time-filtered Likes Block queries (issue #1177).
// This migration must be wired into the 2.2.3 installer upgrade sequence.
$_SQL[] = "ALTER TABLE {$_TABLES['likes']} ADD INDEX created (created)";
