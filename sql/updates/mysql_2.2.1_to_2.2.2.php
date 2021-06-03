<?php

// *************************************
// New 'ip_addresses' table
$_SQL[] = "
CREATE TABLE {$_TABLES['ip_addresses']} (
  seq INT NOT NULL AUTO_INCREMENT,
  ipaddress VARCHAR(39) NOT NULL DEFAULT '0.0.0.0',
  created_at INT NOT NULL DEFAULT 0,
  is_anonymized INT NOT NULL default 0,
  PRIMARY KEY (seq)
) ENGINE=MyISAM
";

/**
 * Add/Edit/Delete config options for new version
 */
function update_ConfValuesFor222()
{
    global $_CONF, $_TABLES;

    require_once $_CONF['path_system'] . 'classes/config.class.php';

    $c = config::get_instance();
    $me = 'Core';

    // Add IP anonymization policy
    $c->add('ip_anonymization', \Geeklog\IP::POLICY_NEVER_ANONYMIZE, 'text', 0, 0, null, 2070, true, $me, 0);

    return true;
}

/**
 * Move IP addresses to the new 'ip_addresses' table
 *
 * @return bool
 */
function update_TablesContainingIPAddresses222()
{
    global $_TABLES;

    $data = [
        'comments'          => ['cid', 'ipaddress'],
        'commentsumissions' => ['cid', 'ipaddress'],
//        'likes'             => ['lid', 'ipaddress'],
        'sessions'          => ['sess_id', 'remote_ip'],
        'speedlimit'        => ['id', 'ipaddress'],
        'trackback'         => ['cid', 'ipaddress'],
    ];

    foreach ($data as $table => $pair) {
        $primaryKeyColumn = $pair[0];
        $ipColumn = $pair[1];

        // Add 'seq' column
        DB_query("ALTER TABLE $_TABLES[$table] ADD COLUMN seq INT NOT NULL DEFAULT 0");

        // Collect primary key values and IP addresses
        $result = DB_query("SELECT $primaryKeyColumn, $ipColumn FROM $_TABLES[$table]");
        $rows = [];

        while (($A = DB_fetchArray($result, false)) != false) {
            $rows[] = $A;
        }

        \Geeklog\IP::init($_TABLES['ip_addresses'], \Geeklog\IP::POLICY_NEVER_ANONYMIZE);

        foreach ($rows as $row) {
            $primaryKeyValue = $row[$primaryKeyColumn];
            $ipAddress = $row[$ipColumn];

            // Move IP addresses to 'ip_addresses' table
            $seq = \Geeklog\IP::getSeq($ipAddress);

            // Update 'seq' column
            if ($table === 'sessions') {
                DB_query("UPDATE $_TABLES[$table] SET seq = $seq WHERE $primaryKeyColumn = $primaryKeyValue");
            } else {
                $primaryKeyValue = DB_escapeString($primaryKeyValue);
                DB_query("UPDATE $_TABLES[$table] SET seq = $seq WHERE $primaryKeyColumn = '$primaryKeyValue'");
            }
        }

        // Drop key related to IP addresses
        if ($table === 'speedlimit') {
            DB_query("ALTER TABLE $_TABLES[$table] DROP KEY type_ipaddress");
        }

        // Drop column 'ipaddress'
        DB_query("ALTER TABLE $_TABLES[$table] DROP COLUMN $ipColumn");
    }

    return true;
}
