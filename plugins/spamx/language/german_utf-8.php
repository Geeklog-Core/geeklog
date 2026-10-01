<?php

/**
 * File: german_utf-8.php
 * This is the German language file for the Geeklog Spam-X plugin
 *
 * Copyright (C) 2004-2017 by the following authors:
 * Author        Tom Willett        tomw AT pigstye DOT net
 *
 * Licensed under GNU General Public License
 */

global $LANG32;

$LANG_SX00 = array (
    'inst1' => '<p>Wenn Sie dies tun, können andere ',
    'inst2' => 'Ihre persönliche Blacklist anzeigen und importieren, und wir können eine effektivere ',
    'inst3' => 'verteilte Datenbank aufbauen.</p><p>Wenn Sie Ihre Website eingetragen haben und nicht möchten, dass sie in der Liste verbleiben soll ',
    'inst4' => 'senden Sie bitte eine E-Mail an <a href="mailto:spamx@pigstye.net">spamx@pigstye.net</a>. ',
    'inst5' => 'Alle Anfragen werden berücksichtigt.',
    'submit' => 'Absenden',
    'subthis' => 'diese Informationen an die zentrale Spam-X-Datenbank',
    'secbut' => 'Diese zweite Schaltfläche erstellt einen RDF-Feed, damit andere Ihre Liste importieren können.',
    'sitename' => 'Websitename: ',
    'URL' => 'URL zur Spam-X-Liste: ',
    'RDF' => 'RDF-URL: ',
    'impinst1a' => 'Bevor Sie die Spam-X-Funktion zum Anzeigen und Importieren persönlicher Blacklists anderer',
    'impinst1b' => ' Websites verwenden, klicken Sie bitte auf die folgenden beiden Schaltflächen. (Die letzte ist erforderlich.)',
    'impinst2' => 'Die erste übermittelt Ihre Website an Gplugs/Spam-X, damit sie zur Hauptliste der ',
    'impinst2a' => 'Websites hinzugefügt werden kann, die ihre Blacklists teilen. (Wenn Sie mehrere Websites betreiben, können Sie eine als ',
    'impinst2b' => 'Hauptwebsite festlegen und nur deren Namen übermitteln. So lassen sich Ihre Websites einfacher aktualisieren und die Liste bleibt kleiner.) ',
    'impinst2c' => 'Nachdem Sie auf Absenden geklickt haben, verwenden Sie [Zurück] im Browser, um hierher zurückzukehren.',
    'impinst3' => 'Die folgenden Werte werden gesendet (Sie können sie bei Bedarf ändern).',
    'availb' => 'Verfügbare Blacklists',
    'clickv' => 'Klicken, um die Blacklist anzuzeigen',
    'clicki' => 'Klicken, um die Blacklist zu importieren',
    'ok' => 'OK',
    'rsscreated' => 'RSS-Feed erstellt',
    'add1' => 'Hinzugefügt: ',
    'add2' => ' Einträge aus ',
    'add3' => "s Blacklist.",
    'adminc' => 'Spam-X-Pluginverwaltung.',
    'mblack' => 'Meine Blacklist:',
    'rlinks' => 'Verwandte Links:',
    'e3' => 'Um Wörter aus der Geeklog-Zensurliste zu übernehmen, klicken Sie auf:',
    'addcen' => 'Zensurliste hinzufügen',
    'addentry' => 'Eintrag hinzufügen',
    'e1' => 'Klicken Sie auf einen Eintrag, um ihn zu löschen.',
    'e2' => 'Um einen Eintrag hinzuzufügen, geben Sie ihn in das Feld ein und klicken Sie auf Hinzufügen. Perl-kompatible reguläre Ausdrücke sind zulässig.',
    'pblack' => 'Persönliche Spam-X-Blacklist',
    'sfseblack' => 'Spam-X-SFS-E-Mail-Blacklist',
    'conmod' => 'Verwendung der Spam-X-Module konfigurieren',
    'acmod' => 'Spam-X-Aktionsmodule',
    'exmod' => 'Spam-X-Prüfmodule',
    'actmod' => 'Aktive Module',
    'avmod' => 'Verfügbare Module',
    'coninst' => '<hr' . XHTML . '>Klicken Sie auf ein aktives Modul, um es zu entfernen, oder auf ein verfügbares Modul, um es hinzuzufügen.<br' . XHTML . '>Module werden in der angezeigten Reihenfolge ausgeführt.',
    'fsc' => 'Spam-Beitrag gefunden, passend zu ',
    'fsc1' => ' veröffentlicht von Benutzer ',
    'fsc2' => ' von IP ',
    'uMTlist' => 'MT-Blacklist aktualisieren',
    'uMTlist2' => ': Hinzugefügt ',
    'uMTlist3' => ' Einträge und gelöscht ',
    'entries' => ' Einträge.',
    'uPlist' => 'Persönliche Blacklist aktualisieren',
    'entriesadded' => 'Hinzugefügte Einträge',
    'entriesdeleted' => 'Gelöschte Einträge',
    'viewlog' => 'Spam-X-Protokoll anzeigen',
    'clearlog' => 'Protokolldatei leeren',
    'logcleared' => '- Spam-X-Protokolldatei geleert',
    'plugin' => 'Plugin',
    'action' => 'Aktion',
    'access_denied' => 'Zugriff verweigert',
    'access_denied_msg' => 'Nur Root-Benutzer haben Zugriff auf diese Seite. Benutzername und IP-Adresse wurden protokolliert.',
    'admin' => 'Plugin-Verwaltung',
    'install_header' => 'Plugin installieren/deinstallieren',
    'installed' => 'Das Plugin ist installiert',
    'uninstalled' => 'Das Plugin ist nicht installiert',
    'install_success' => 'Installation erfolgreich',
    'install_failed' => 'Installation fehlgeschlagen – Details finden Sie im Fehlerprotokoll.',
    'uninstall_msg' => 'Plugin erfolgreich deinstalliert',
    'install' => 'Installieren',
    'uninstall' => 'Deinstallieren',
    'warning' => 'Warnung! Das Plugin ist noch aktiviert',
    'enabled' => 'Deaktivieren Sie das Plugin vor der Deinstallation.',
    'readme' => 'STOPP! Lesen Sie vor der Installation bitte die ',
    'installdoc' => 'Installationsdokumentation.',
    'spamdeleted' => 'Spam-Beitrag gelöscht',
    'foundspam' => 'Spam-Beitrag gefunden, passend zu ',
    'foundspam2' => ' veröffentlicht von Benutzer ',
    'foundspam3' => ' von IP ',
    'deletespam' => 'Spam löschen',
    'numtocheck' => 'Anzahl zu prüfender Kommentare',
    'note1'     => '<p>Hinweis: Die Massenlöschung hilft, wenn Sie von',
    'note2'     => ' Kommentarspam betroffen sind und Spam-X ihn nicht erkennt.</p><ul><li>Suchen Sie zuerst Links oder andere ',
    'note3'     => 'Kennzeichen des Spam-Kommentars und fügen Sie sie Ihrer persönlichen Blacklist hinzu.</li><li>Danach ',
    'note4'     => 'kehren Sie hierher zurück und lassen Spam-X die neuesten Kommentare prüfen.</li></ul><p>Kommentare ',
    'note5'     => 'werden vom neuesten zum ältesten geprüft – mehr Kommentare zu prüfen ',
    'note6'     => 'benötigt mehr Zeit.</p>',
    'masshead'  => 'Spam-Kommentare massenweise löschen',
    'masstb' => 'Trackback-Spam massenweise löschen',
    'comdel'    => ' Kommentare gelöscht.',
    'initial_Pimport' => '<p>Persönliche Blacklist importieren"',
    'initial_import' => 'Erstimport der MT-Blacklist',
    'import_success' => '<p>%d Blacklist-Einträge erfolgreich importiert.',
    'import_failure' => '<p><strong>Fehler:</strong> Keine Einträge gefunden.',
    'allow_url_fopen' => '<p>Leider erlaubt Ihre Webserver-Konfiguration das Lesen entfernter Dateien nicht (<code>allow_url_fopen</code> ist deaktiviert). Laden Sie die Blacklist von der folgenden URL herunter und in Geeklogs Verzeichnis "data" hoch, <span style="font-family: monospace;">%s</span>, bevor Sie es erneut versuchen:',
    'documentation' => 'Spam-X-Plugin-Dokumentation',
    'emailmsg' => "Ein neuer Spam-Beitrag wurde auf \"%s\" eingereicht\nBenutzer-UID: \"%s\"\n\nInhalt:\"%s\"",
    'emailsubject' => 'Spam-Beitrag auf %s',
    'ipblack' => 'Spam-X-IP-Blacklist',
    'ipofurlblack' => 'Spam-X-Blacklist für URL-IP-Adressen',
    'headerblack' => 'Spam-X-HTTP-Header-Blacklist',
    'headers' => 'Anfrage-Header:',
    'edit' => 'Bearbeiten',
    'view' => 'Anzeigen',
    'value' => 'Wert',
    'counter' => 'Zähler',

    'stats_headline' => 'Spam-X-Statistik',
    'stats_page_title' => 'Sperrliste',
    'stats_entries' => 'Einträge',
    'stats_mtblacklist' => 'MT-Blacklist',
    'stats_pblacklist' => 'Persönliche Blacklist',
    'stats_ip' => 'Blockierte IP-Adressen',
    'stats_ipofurl' => 'Durch URL-IP blockiert',
    'stats_header' => 'HTTP-Header',
    'stats_deleted' => 'Als Spam gelöschte Beiträge',

    'invalid_email_or_ip'   => 'Eine ungültige E-Mail- oder IP-Adresse wurde blockiert.',
    'email_ip_spam' => '%s oder %s versuchte sich zu registrieren, wurde aber als Spammer eingestuft.',
    'edit_personal_blacklist' => 'Persönliche Blacklist bearbeiten',
    'mass_delete_spam_comments' => 'Spam-Kommentare massenweise löschen',
    'mass_delete_trackback_spam' => 'Trackback-Spam massenweise löschen',
    'edit_http_header_blacklist' => 'HTTP-Header-Blacklist bearbeiten',
    'edit_ip_blacklist' => 'IP-Blacklist bearbeiten',
    'edit_ip_url_blacklist' => 'URL-IP-Blacklist bearbeiten',
    'edit_sfs_blacklist' => 'SFS-E-Mail-Blacklist bearbeiten',
    'edit_slv_whitelist' => 'SLV-Whitelist bearbeiten',

    'plugin_name' => 'Spam-X'
);


/* Define Messages that are shown when Spam-X module action is taken */
$PLG_spamx_MESSAGE128 = 'Spam erkannt. Beitrag wurde gelöscht.';
$PLG_spamx_MESSAGE8   = 'Spam erkannt. E-Mail an den Administrator gesendet.';

// Messages for the plugin upgrade
$PLG_spamx_MESSAGE3001 = 'Plugin-Upgrade wird nicht unterstützt.';
$PLG_spamx_MESSAGE3002 = $LANG32[9];


// Localization of the Admin Configuration UI
$LANG_configsections['spamx'] = array(
    'label' => 'Spam-X',
    'title' => 'Spam-X-Konfiguration'
);

$LANG_confignames['spamx'] = array(
    'spamx_action' => 'Spam-X-Aktionen',
    'notification_email' => 'Benachrichtigungs-E-Mail',
    'logging' => 'Protokollierung aktivieren',
    'timeout' => 'Zeitüberschreitung',
    'max_age' => 'Maximales Alter der Datensätze',
    'records_delete' => 'Zu löschende Datensatztypen',
    'sfs_enabled' => 'SFS aktivieren',
    'sfs_confidence' => 'Vertrauensschwelle',
    'snl_enabled' => 'SNL aktivieren',
    'snl_num_links' => 'Anzahl der Links',
    'akismet_enabled' => 'Akismet aktivieren',
    'akismet_api_key' => 'API-Schlüssel',
);

$LANG_configsubgroups['spamx'] = array(
    'sg_main' => 'Haupteinstellungen'
);

$LANG_tab['spamx'] = array(
    'tab_main' => 'Spam-X-Haupteinstellungen',
    'tab_modules' => 'Module'
);

$LANG_fs['spamx'] = array(
    'fs_main' => 'Spam-X-Haupteinstellungen',
    'fs_sfs' => 'Stop Forum Spam (SFS)',
    'fs_snl' => 'Anzahl der Spam-Links (SNL)',
    'fs_akismet' => 'Akismet',
);

$LANG_configselects['spamx'] = array(
    0 => array('True' => 1, 'False' => 0),
    1 => array('True' => TRUE, 'False' => FALSE)
);
