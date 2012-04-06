<?php

/**
 * File: estonian_utf-8.php
 * This is the Estonian language file for the Geeklog Spam-X plugin
 * 
 * Copyright (C) 2004-2008 by the following authors:
 * Author        Tom Willett        tomw AT pigstye DOT net
 *  Estonian translation by Artur Räpp <rtr AT planet DOT ee>
 * 
 * Licensed under GNU General Public License
 *
 * $Id: estonian_utf-8.php,v 1.3 2008/09/13 14:27:58 dhaun Exp $
 */

global $LANG32;

$LANG_SX00 = array(
    'inst1' => '<p>Kui sa teed nii, saavad ',
    'inst2' => 'teised vaadata sinu isiklikku blacklisti ja seda importida ja nii saame me luua   efektiivsema  ',
    'inst3' => 'jagatud andmebaasi.</p><p>Kui sa   sisestasid oma veebilehe ja pärast seda otsustasid, et soovid oma lehe antud loetelust eemaldada,  ',
    'inst4' => 'saada E-kiri aadressil <a href="mailto:spamx@pigstye.net">spamx@pigstye.net</a> ja anna oma soovist teada. ',
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
    'add3' => ' blacklist.',
    'adminc' => 'Administreerimiskäsud:',
    'mblack' => 'Minu blacklist:',
    'rlinks' => 'Seotud lingid:',
    'e3' => 'Geeklogi tsensuuriloetelust sõnade lisamiseks vajuta nuppu:',
    'addcen' => 'Lisa Tsensuuriloetelu',
    'addentry' => 'Lisa kanne',
    'e1' => 'Kande kustutamiseks klõpsa sellel',
    'e2' => 'Kande lisamiseks kirjuta uus kanne kirjutamisväljale ja klõpsa Lisa nuppu. Kannetes saab kasutada täiemahulisi Perli regulaaravaldisi.',
    'pblack' => 'Spam-X isikli blacklist',
    'sfseblack' => 'Spam-X SFS Email Blacklist',
    'conmod' => 'Häälesta Spam-X Mooduli kasutamist',
    'acmod' => 'Spam-X toimingute  Moodulid',
    'exmod' => 'Spam-X kontrollimoodulid',
    'actmod' => 'Aktiivsed moodulid',
    'avmod' => 'Saadaolevad moodulid',
    'coninst' => '<hr' . XHTML . '>Aktiivse mooduli eemaldamiseks kliki sellel, saadaoleva mooduli lisamiseks, et seda lisada.<br' . XHTML . '>Moodulid käivitatakse käesolevas järjekorras.',
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
    'note1' => '<p>Märkus: Masskustutamine on mõeldud juhuks kui  lehte on tabanud ',
    'note2' => ' spamkommentaarid ja  Spam-X ei saa nendega hakkama.</p><ul><li>Algul  leia ling(id) või teised ',
    'note3' => "spamkommentaaride tunnused  ja lisa need isiklikku blacklisti.\n    </li><li>Seejärel ",
    'note4' => 'tule siia tagasi ja lase Spam-X-l viimaseid kommentaare kontrollida .</li></ul><p>Kommentaare ',
    'note5' => 'kontrollitakse alates uuematest. Suurema arvu kommentaaride kontrollimine ',
    'note6' => 'nõuab kontrollimiselt rohkem aega.</p>',
    'masshead' => '<hr' . XHTML . '><h1 align="center">Masskustuta spamkommentaare</h1>',
    'masstb' => '<hr' . XHTML . '><h1 align="center">Masskustuta trackback spam</h1>',
    'comdel' => ' kommentaari kustutatud.',
    'initial_Pimport' => '<p>Isikliku blacklisti importimine"',
    'initial_import' => 'Algne MT-Blacklisti importimine',
    'import_success' => '<p>%d blacklisti kannet on edukalt imporditud.',
    'import_failure' => '<p><strong>Viga:</strong> Kandeid ei leitud.',
    'allow_url_fopen' => '<p>Kahjuks veebiserveri häälestus  ei luba   lugeda faile teistest serveritest. (<code>allow_url_fopen</code> on off). Palun lae blacklist alla järgnevalt URL-lt ja pane see Geeklog-i "data" kausta, <tt>%s</tt>, enne kui proovid uuesti:',
    'documentation' => 'Spam-X Plugina Dokumentatsioon',
    'emailmsg' => "Lehel \"%s\" on postitatud uus spampostitus\nKasutaja UID: \"%s\"\n\nSisu:\"%s\"",
    'emailsubject' => 'Spampostitus - %s',
    'ipblack' => 'Spam-X IP Blacklist',
    'ipofurlblack' => 'Spam-X IP of URL Blacklist',
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
    'invalid_email_or_ip' => 'Invalid e-mail address or IP address has been blocked.',
    'email_ip_spam' => '%s or %s attempted to register but was considered a spammer.',
    'edit_personal_blacklist' => 'Edit Personal Blacklist',
    'mass_delete_spam_comments' => 'Mass Delete Spam Comments',
    'mass_delete_trackback_spam' => 'Mass Delete Trackback Spam',
    'edit_http_header_blacklist' => 'Edit HTTP Header Blacklist',
    'edit_ip_blacklist' => 'Edit IP Blacklist',
    'edit_ip_url_blacklist' => 'Edit IP of URL Blacklist',
    'edit_sfs_blacklist' => 'Edit SFS Email Blacklist',
    'edit_slv_whitelist' => 'Edit SLV Whitelist',
    'plugin_name' => 'Spam-X',
    'slvwhitelist' => 'SLV Whitelist'
);

// Define Messages that are shown when Spam-X module action is taken
$PLG_spamx_MESSAGE128 = 'Tuvastati spam. Postitus kustutati.';
$PLG_spamx_MESSAGE8 = 'Tuvastati spam. Administraatorile saadeti E-kiri';

// Messages for the plugin upgrade
$PLG_spamx_MESSAGE3001 = 'Plugina uuendamine pole toetatud';
$PLG_spamx_MESSAGE3002 = $LANG32[9];

// Localization of the Admin Configuration UI
$LANG_configsections['spamx'] = array(
    'label' => 'Spam-X',
    'title' => 'Spam-X haldur'
);

$LANG_confignames['spamx'] = array(
    'spamx_action' => 'Spam-X Actions',
    'notification_email' => 'Teavituskiri',
    'logging' => 'Luba logimine',
    'timeout' => 'Ajapiir',
    'sfs_enabled' => 'Enable SFS',
    'snl_enabled' => 'Enable SNL',
    'snl_num_links' => 'Number of links'
);

$LANG_configsubgroups['spamx'] = array(
    'sg_main' => 'Peahäälestused'
);

$LANG_tab['spamx'] = array(
    'tab_main' => 'Spam-X Main Settings',
    'tab_modules' => 'Modules'
);

$LANG_fs['spamx'] = array(
    'fs_main' => 'Spam-X peahäälestused',
    'fs_sfs' => 'Stop Forum Spam (SFS)',
    'fs_snl' => 'Spam Number of Links (SNL)'
);

// Note: entries 0, 1, 9, and 12 are the same as in $LANG_configselects['Core']
$LANG_configselects['spamx'] = array(
    0 => array('Jah' => 1, 'Ei' => 0),
    1 => array('Jah' => true, 'Ei' => false)
);

?>
