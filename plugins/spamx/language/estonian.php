<?php

/**
 * File: estonian.php
 * This is the Estonian language file for the Geeklog Spam-X plugin
 * 
 * Copyright (C) 2004-2008 by the following authors:
 * Author        Tom Willett        tomw AT pigstye DOT net
*  Estonian translation by Artur Räpp <rtr AT planet DOT ee>
  * 
 * Licensed under GNU General Public License
 *
 * $Id: estonian.php,v 1.1 2008/06/07 14:27:34 dhaun Exp $
 */

global $LANG32;

$LANG_SX00 = array (
    'inst1' => '<p>Kui sa teed nii, saavad ',
    'inst2' => 'teised vaadata sinu isiklikku blacklisti ja seda importida ja nii saame me luua   efektiivsema  ',
    'inst3' => 'jagatud andmebaasi.</p><p>Kui sa   sisestasid oma veebilehe ja pärast seda otsustasid, et soovid oma lehe antud loetelust eemaldada,  ',
    'inst4' => 'saada E-kiri aadressil <a href="mailto:spamx@pigstye.net">spamx@pigstye.net</a> telling me. ',
    'inst5' => 'Kõik taotlused võetakse arvesse.',
    'submit' => 'Sisesta',
    'subthis' => 'see info Spam-X keskandmebaasi',
    'secbut' => 'See teine nupp loob rdf lõime, et teised saaksid sinu  loetelu importida.',
    'sitename' => 'Lehe nimi: ',
    'URL' => 'Spam-X loetelu URL: ',
    'RDF' => 'RDF\'i url: ',
    'impinst1a' => 'Before you use the Spam-X comment Spam blocker facility to view and import personal Blacklists from other',
    'impinst1b' => ' sites, I ask that you press the following two buttons. (You have to press the last one.)',
    'impinst2' => 'This first submits your website to the Gplugs/Spam-X site so that it can be added to the master list of ',
    'impinst2a' => 'sites sharing their blacklists. (Note: if you have multiple sites you might want to designate one as the ',
    'impinst2b' => 'master and only submit its name. This will allow you to update your sites easily and keep the list smaller.) ',
    'impinst2c' => 'After you press the Submit button, press [back] on your browser to return here.',
    'impinst3' => 'The Following values will be sent: (you can edit them if they are wrong).',
    'availb' => 'Saadaolevad blacklistid',
    'clickv' => 'Kliki blacklisti vaatamiseks',
    'clicki' => 'Kliki blacklisti importimiseks',
    'ok' => 'OK',
    'rsscreated' => 'RSS lõim loodud',
    'add1' => 'Lisatud ',
    'add2' => ' kannet, allikas  ',
    'add3' => " blacklist.",
    'adminc' => 'Administreerimiskäsud:',
    'mblack' => 'Minu blacklist:',
    'rlinks' => 'Seotud lingid:',
    'e3' => 'Geeklogi tsensuuriloetelust sõnade lisamiseks vajuta nuppu:',
    'addcen' => 'Lisa Tsensuuriloetelu',
    'addentry' => 'Lisa kanne',
    'e1' => 'Kande kustutamiseks klõpsa sellel',
    'e2' => 'Kande lisamiseks kirjuta uus kanne kirjutamisväljale ja klõpsa Lisa nuppu. Kannetes saab kasutada täiemahulisi Perli regulaaravaldisi.', 
    'pblack' => 'Spam-X isikli blacklist',
    'conmod' => 'Häälesta Spam-X Mooduli kasutamist',
    'acmod' => 'Spam-X toimingute  Moodulid',
    'exmod' => 'Spam-X kontrollimoodulid',
    'actmod' => 'Aktiivsed moodulid',
    'avmod' => 'Saadaolevad moodulid',
    'coninst' => '<hr' . XHTML . '>Aktiivse mooduli eemaldamiseks kliki sellel, saadaoleva mooduli lisamiseks, et seda lisada.<br' . XHTML . '>Modules are executed in order presented.',
    'fsc' => 'Leitud spampostitus v, reegel ',
    'fsc1' => ' postitajaks kasutaja ',
    'fsc2' => ' IP-lt ',
    'uMTlist' => 'Uuenda MT-Blacklist',
    'uMTlist2' => ': lisatud ',
    'uMTlist3' => ' kannet ja kustutatud ',
    'entries' => ' kannet.',
    'uPlist' => 'uuenda isiklikku blacklisti',
    'entriesadded' => 'lisatud kanded ',
    'entriesdeleted' => 'Kustutatud kanded',
    'viewlog' => 'Vaata Spam-X Logi',
    'clearlog' => 'Tühjenda Logifail',
    'logcleared' => '- Spam-X Logifail tühjendatud',
    'plugin' => 'Plugin',
    'access_denied' => 'Ligipääs tõkestatud',
    'access_denied_msg' => 'Ainult root kasutajatel on  ligipääs sellele lehele.  Sinu kasutajanimi ja IP on salvestatud',
    'admin' => 'Plugina administreerimine',
    'install_header' => 'Installi/eemalda plugin',
    'installed' => 'Plugin on installeeritud',
    'uninstalled' => 'Plugin pole installeeritud',
    'install_success' => 'Installeerimine  edukas',
    'install_failed' => 'Installeerimine ebaõnnestus -- vaata  error log faili, et leida miks.',
    'uninstall_msg' => 'Plugin edukalt eemaldatud',
    'install' => 'Installeeri',
    'uninstall' => 'Eemalda',
    'warning' => 'Hoiatus! Plugin on jätkuvalt lubatud',
    'enabled' => 'Keela plugin enne selle eemaldamist.',
    'readme' => 'STOPP! Enne installil klikkimist,  loe palun ',
    'installdoc' => 'Installeerimisdokumenti.',
    'spamdeleted' => 'Kustutatud spampostitus',
    'foundspam' => 'Leitud spampostitus, reegel ',
    'foundspam2' => ' postitajaks kasutaja ',
    'foundspam3' => ' IP-lt ',
	'deletespam' => 'Kustuta Spam',
	'numtocheck' => 'kontrollitavate kommentaaride arv',
	'note1'		=> '<p>Märkus: Masskustutamine on mõeldud juhuks kui  lehte on tabanud ',
	'note2'		=> ' spamkommentaarid ja  Spam-X ei saa nendega hakkama.</p><ul><li>Algul  leia ling(id) või teised ',
	'note3'		=> 'spamkommentaaride tunnused  ja lisa need isiklikku blacklisti.</li><li>Seejärel ',
	'note4'		=> 'tule siia tagasi ja lase Spam-X-l viimaseid kommentaare kontrollida .</li></ul><p>Kommentaare ',
	'note5'		=> 'kontrollitakse alates uuematest. Suurema arvu kommentaaride kontrollimine ', 
	'note6'		=> 'nõuab kontrollimiselt rohkem aega.</p>',
	'masshead'	=> '<hr' . XHTML . '><h1 align="center">Masskustuta spamkommentaare</h1>',
	'masstb' => '<hr' . XHTML . '><h1 align="center">Masskustuta trackback spam</h1>',
	'comdel'	=> ' kommentaari kustutatud.',
    'initial_Pimport' => '<p>Isikliku blacklisti importimine"',
    'initial_import' => 'Algne MT-Blacklisti importimine',
    'import_success' => '<p>%d blacklisti kannet on edukalt imporditud.',
    'import_failure' => '<p><strong>Viga:</strong> Kandeid ei leitud.',
    'allow_url_fopen' => '<p>Sorry, your webserver configuration does not allow reading of remote files (<code>allow_url_fopen</code> is off). Please download the blacklist from the following URL and upload it into Geeklog\'s "data" directory, <tt>%s</tt>, before trying again:', // tõlkida
    'documentation' => 'Spam-X Plugina Dokumentatsioon',
    'emailmsg' => "Lehel \"%s\" on postitatud uus spampostitus\nKasutaja UID: \"%s\"\n\nSisu:\"%s\"",
    'emailsubject' => 'Spampostitus - %s',
    'ipblack' => 'Spam-X IP Blacklist',
    'ipofurlblack' => 'Spam-X IP of URL Blacklist', // tõlkida
    'headerblack' => 'Spam-X HTTP päiste blacklist',
    'headers' => 'Päringute päised:',

    'stats_headline' => 'Spam-X Statistika',
    'stats_page_title' => 'Blacklist',
    'stats_entries' => 'Kanded',
    'stats_mtblacklist' => 'MT-Blacklist',
    'stats_pblacklist' => 'Isiklik Blacklist',
    'stats_ip' => 'Blokeeritud IP-d',
    'stats_ipofurl' => 'Blocked by IP of URL',
    'stats_header' => 'HTTP päised',
    'stats_deleted' => 'Spammina kustutatud postitused',

    'plugin_name' => 'Spam-X',
    'slvwhitelist' => 'SLV Whitelist'
);


/* Define Messages that are shown when Spam-X module action is taken */
$PLG_spamx_MESSAGE128 = 'Tuvastati spam. Postitus kustutati.';
$PLG_spamx_MESSAGE8   = 'Tuvastati spam. Administraatorile saadeti E-kiri';

// Messages for the plugin upgrade
$PLG_spamx_MESSAGE3001 = 'Plugina uuendamine pole toetatud';
$PLG_spamx_MESSAGE3002 = $LANG32[9];


// Localization of the Admin Configuration UI
$LANG_configsections['spamx'] = array(
    'label' => 'Spam-X',
    'title' => 'Spam-X haldur'
);

$LANG_confignames['spamx'] = array(
    'action' => 'Spam-X tegevused',
    'notification_email' => 'Teavituskiri',
    'admin_override' => "Ära filtreeri administraatori postitusi",
    'logging' => 'Luba logimine',
    'timeout' => 'Ajapiir'
);

$LANG_configsubgroups['spamx'] = array(
    'sg_main' => 'Peahäälestused'
);

$LANG_fs['spamx'] = array(
    'fs_main' => 'Spam-X peahäälestused'
);

$LANG_configselects['spamx'] = array(
    0 => array('True' => 1, 'False' => 0),
    1 => array('True' => TRUE, 'False' => FALSE)
);

?>
