<?php

/**
 * File: # slovenian.php - version 1.4.1
 * This is the slovenian language file for the Geeklog Spam-X plugin
 * language file for geeklog version 1.4.1 beta by mb
 * gape@gape.org ; za pripombe, predloge ipd ... piši na email

 * 
 * Copyright (C) 2004-2006 by the following authors:
 * Author        Tom Willett        tomw AT pigstye DOT net
 * 
 * Licensed under GNU General Public License
 *
 * $Id: slovenian.php,v 1.4 2008/05/02 15:08:10 dhaun Exp $
 */

global $LANG32;

$LANG_SX00 = array(
    'inst1' => '<p>Èe storiš to, potem si bodo drugi ',
    'inst2' => ' lahko ogledali in uvozili tvojo èrno listo, in lahko bomo ustvarili bolj uèinkovito ',
    'inst3' => 'razvršèeno podatkovno bazo.</p><p>Èe si oddal/a svojo spletno stran in se odloèil/a, da ne želiš, da tvoja spletna stran ostane na listi ',
    'inst4' => 'to sporoèi prek e-pošte na naslov <a href="mailto:spamx@pigstye.net">spamx@pigstye.net</a>. ',
    'inst5' => 'Vse zahteve bodo spoštovane.',
    'submit' => 'Oddaj',
    'subthis' => 'this info to Spam-X Central Database',
    'secbut' => 'Ta drugi gumb ustvari združeno vsebino v zapisu rdf, da lahko drugi uvozijo tvojo listo.',
    'sitename' => 'Ime strani: ',
    'URL' => 'URL v seznam Spam-X : ',
    'RDF' => 'RDF url: ',
    'impinst1a' => 'Before you use the Spam-X comment Spam blocker facility to view and import personal Blacklists from other',
    'impinst1b' => ' sites, I ask that you press the following two buttons. (You have to press the last one.)',
    'impinst2' => 'This first submits your website to the Gplugs/Spam-X site so that it can be added to the master list of ',
    'impinst2a' => 'sites sharing their blacklists. (Note: if you have multiple sites you might want to designate one as the ',
    'impinst2b' => 'master and only submit its name. This will allow you to update your sites easily and keep the list smaller.) ',
    'impinst2c' => 'After you press the Submit button, press [back] on your browser to return here.',
    'impinst3' => 'The Following values will be sent: (you can edit them if they are wrong).',
    'availb' => 'Razpoložljive èrne liste',
    'clickv' => 'Klikni za ogled èrne liste',
    'clicki' => 'Klikni za uvoz èrne liste',
    'ok' => 'V redu',
    'rsscreated' => 'Ustvarjena združena vsebina RSS',
    'add1' => 'Dodani ',
    'add2' => ' vpisi s èrne liste uporabnika ',
    'add3' => '.',
    'adminc' => 'Upravniški ukazi:',
    'mblack' => 'Moja èrna lista:',
    'rlinks' => 'Sorodne povezave:',
    'e3' => ' Za dodajanje besed iz Geeklogovega cenzurnega seznama pritisni gumb:',
    'addcen' => 'Dodaj cenzurni seznam',
    'addentry' => 'Dodaj vpis',
    'e1' => 'Da izbrišeš vpis, ga klikni.',
    'e2' => 'Da dodaš vpis, ga vnesi v okence in klikni Dodaj. Vnosi lahko uporabljajo  full Perl Regular Expressions.',
    'pblack' => 'Osebna èrna lista Spam-X',
    'conmod' => 'Konfiguriraj Spam-X Module Usage',
    'acmod' => 'Akcijski moduli Spam-X ',
    'exmod' => 'Preiskovalni moduli Spam-X ',
    'actmod' => 'Aktivni moduli',
    'avmod' => 'Razpoložljivi moduli',
    'coninst' => '<hr' . XHTML . '>Klikni na aktivni modul, da ga odstraniš, klikni na Razpoložljivi modul, da ga dodaš.<br' . XHTML . '>Moduli are executed in order presented.',
    'fsc' => 'Found Spam Post matching ',
    'fsc1' => ' objavil uporabnik ',
    'fsc2' => ' z IP-ja ',
    'uMTlist' => 'Posodobi èrno listo MT',
    'uMTlist2' => ': Dodani ',
    'uMTlist3' => ' vpisi in izbrisani ',
    'entries' => ' vpisi.',
    'uPlist' => 'Posodobi osebno èrno listo',
    'entriesadded' => 'Vpisi dodani',
    'entriesdeleted' => 'Vpisi izbrisani',
    'viewlog' => 'Oglej si Spam-X Log',
    'clearlog' => 'Poèisti datoteko Log',
    'logcleared' => '- Datoteka Spam-X Log poèišèena',
    'plugin' => 'Vtiènik',
    'access_denied' => 'Dostop zavrnjen',
    'access_denied_msg' => 'Dostop do te strani imajo samo korenski uporabniki.  Tvoje uporabniško ime in IP sta zapisana.',
    'admin' => 'Upravljanje vtiènikov',
    'install_header' => 'Namesti/deinstaliraj vtiènik',
    'installed' => 'Vtiènik je namešèen',
    'uninstalled' => 'Vtiènik ni namešèen',
    'install_success' => 'Namestitev uspešna',
    'install_failed' => 'Namestitev ni uspela -- See your error log to find out why.',
    'uninstall_msg' => 'Plugin Successfully Uninstalled',
    'install' => 'Install',
    'uninstall' => 'UnInstall',
    'warning' => 'Warning! Plugin is still Enabled',
    'enabled' => 'Disable plugin before uninstalling.',
    'readme' => 'STOP! Before you press install please read the ',
    'installdoc' => 'Install Document.',
    'spamdeleted' => 'Deleted Spam Post',
    'foundspam' => 'Found Spam Post matching ',
    'foundspam2' => ' posted by user ',
    'foundspam3' => ' from IP ',
    'deletespam' => 'Delete Spam',
    'numtocheck' => 'Number of Comments to check',
    'note1' => '<p>Note: Mass Delete is intended to help you when you are hit by',
    'note2' => ' comment spam and Spam-X does not catch it.  <ul><li>First find the link(s) or other ',
    'note3' => 'identifiers of this spam comment and add it to your personal blacklist.</li><li>Then ',
    'note4' => 'come back here and have Spam-X check the latest comments for spam.</li></ul><p>Comments ',
    'note5' => 'are checked from newest comment to oldest -- checking more comments ',
    'note6' => 'requires more time for the check.</p>',
    'masshead' => '<hr' . XHTML . '><h1 align="center">Mass Delete Spam Comments</h1>',
    'masstb' => '<hr' . XHTML . '><h1 align="center">Mass Delete Trackback Spam</h1>',
    'comdel' => ' comments deleted.',
    'initial_Pimport' => '<p>Personal Blacklist Import"',
    'initial_import' => 'Initial MT-Blacklist Import',
    'import_success' => '<p>Successfully imported %d blacklist entries.',
    'import_failure' => '<p><strong>Error:</strong> No entries found.',
    'allow_url_fopen' => '<p>Sorry, your webserver configuration does not allow reading of remote files (<code>allow_url_fopen</code> is off). Please download the blacklist from the following URL and upload it into Geeklog\'s "data" directory, <tt>%s</tt>, before trying again:',
    'documentation' => 'Spam-X Plugin Documentation',
    'emailmsg' => "A new spam post has been submitted at \"%s\"\nUser UID: \"%s\"\n\nContent:\"%s\"",
    'emailsubject' => 'Spam post at %s',
    'ipblack' => 'Spam-X IP Blacklist',
    'ipofurlblack' => 'Spam-X IP of URL Blacklist',
    'headerblack' => 'Spam-X HTTP Header Blacklist',
    'headers' => 'Request headers:',
    'stats_headline' => 'Spam-X Statistics',
    'stats_page_title' => 'Blacklist',
    'stats_entries' => 'Entries',
    'stats_mtblacklist' => 'MT-Blacklist',
    'stats_pblacklist' => 'Personal Blacklist',
    'stats_ip' => 'Blocked IPs',
    'stats_ipofurl' => 'Blocked by IP of URL',
    'stats_header' => 'HTTP headers',
    'stats_deleted' => 'Posts deleted as spam',
    'plugin_name' => 'Spam-X',
    'slvwhitelist' => 'SLV Whitelist'
);

// Define Messages that are shown when Spam-X module action is taken
$PLG_spamx_MESSAGE128 = 'Spam detected. Post was deleted.';
$PLG_spamx_MESSAGE8 = 'Spam detected. Email sent to admin.';

// Messages for the plugin upgrade
$PLG_spamx_MESSAGE3001 = 'Plugin upgrade not supported.';
$PLG_spamx_MESSAGE3002 = $LANG32[9];

// Localization of the Admin Configuration UI
$LANG_configsections['spamx'] = array(
    'label' => 'Spam-X',
    'title' => 'Spam-X Configuration'
);

$LANG_confignames['spamx'] = array(
    'action' => 'Spam-X Actions',
    'notification_email' => 'Notification Email',
    'logging' => 'Enable Logging',
    'timeout' => 'Timeout'
);

$LANG_configsubgroups['spamx'] = array(
    'sg_main' => 'Main Settings'
);

$LANG_fs['spamx'] = array(
    'fs_main' => 'Spam-X Main Settings'
);

// Note: entries 0, 1, 9, and 12 are the same as in $LANG_configselects['Core']
$LANG_configselects['spamx'] = array(
    0 => array('True' => 1, 'False' => 0),
    1 => array('True' => true, 'False' => false)
);

?>
