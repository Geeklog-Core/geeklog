<?php

/**
 * File: # slovenian.php - version 1.7
 * This is the slovenian language file for the Geeklog Spam-X plugin
 * language file for geeklog version 1.7 by Mateja B.
 * gape@gape.org ; za pripombe, predloge ipd. pi�i na e-naslov

 * 
 * Copyright (C) 2004-2006 by the following authors:
 * Author        Tom Willett        tomw AT pigstye DOT net
 * 
 * Licensed under GNU General Public License
 *
 */

global $LANG32;

$LANG_SX00 = array(
    'inst1' => '<p>�e stori� to, potem si bodo drugi ',
    'inst2' => ' lahko ogledali in uvozili tvojo �rno listo, in lahko bomo ustvarili u�inkovitej�o ',
    'inst3' => 'razvr��eno podatkovno bazo.</p><p>�e si oddal/a svojo spletno stran in no�e�, da tvoja spletna stran ostane na listi, ',
    'inst4' => 'to sporo�i prek e-po�te na naslov <a href="mailto:spamx@pigstye.net">spamx@pigstye.net</a>. ',
    'inst5' => 'Vse zahteve bodo spo�tovane.',
    'submit' => 'Oddaj',
    'subthis' => 'te informacije v centralno podatkovno bazo Spam-X',
    'secbut' => 'Ta, drugi gumb ustvari zdru�eno vsebino v zapisu rdf, da lahko drugi uvozijo tvojo listo.',
    'sitename' => 'Ime strani: ',
    'URL' => 'URL v seznam Spam-X : ',
    'RDF' => 'RDF url: ',
    'impinst1a' => 'Preden uporabi� pripomo�ek Spam-X comment Spam blocker, da pogleda� in uvozi� osebne �rne list z drugih',
    'impinst1b' => ' strani, prosim klikni naslednja dva gumba. (Klikniti mora� zadnjega.)',
    'impinst2' => 'To najprej odda tvojo spletno stran na stran Gplugs/Spam-X, da bo lahko dodana na glavno listo ',
    'impinst2a' => 'strani, ki si delijo �rne liste. (Opomba: �e ima� ve� strani, ho�e� morda eno dolo�iti kot ',
    'impinst2b' => 'glavno in oddati samo njeno ime. To ti bo omogo�ilo preprosto posodobitev svojih strani in ohraniti kraj�o listo.) ',
    'impinst2c' => 'Po kliku na gumb Oddaj se z gumbom Nazaj v brskalniku vrni spet sem.',
    'impinst3' => 'Poslane bodo naslednje vrednosti: (�e so napa�ne, jih uredi).',
    'availb' => 'Razpolo�ljive �rne liste',
    'clickv' => 'Klikni za ogled �rne liste',
    'clicki' => 'Klikni za uvoz �rne liste',
    'ok' => 'V redu',
    'rsscreated' => 'Ustvarjena zdru�ena vsebina RSS',
    'add1' => 'Dodani ',
    'add2' => ' vpisi s �rne liste uporabnika ',
    'add3' => '.',
    'adminc' => 'Skrbni�ki ukazi:',
    'mblack' => 'Moja �rna lista:',
    'rlinks' => 'Sorodne povezave:',
    'e3' => ' Za dodajanje besed iz Geeklogovega cenzurnega seznama pritisni gumb:',
    'addcen' => 'Dodaj cenzurni seznam',
    'addentry' => 'Dodaj vpis',
    'e1' => 'Da vpis izbri�e�, ga klikni.',
    'e2' => 'Da vpis doda�, ga vnesi v okence in klikni Dodaj. Vnosi lahko uporabljajo polne izraze Perl Regular.',
    'pblack' => 'Osebna �rna lista Spam-X',
    'sfseblack' => 'Spam-X SFS Email Blacklist',
    'conmod' => 'Konfiguriraj Spam-X Module Usage',
    'acmod' => 'Akcijski moduli Spam-X ',
    'exmod' => 'Preiskovalni moduli Spam-X ',
    'actmod' => 'Aktivni moduli',
    'avmod' => 'Razpolo�ljivi moduli',
    'coninst' => '<hr' . XHTML . '>Klikni na aktivni modul, da ga odstrani�, klikni na Razpolo�ljivi modul, da ga doda�.<br' . XHTML . '>Moduli se izvajajo v predlo�enem vrstnem redu.',
    'fsc' => 'Najden Spam Post, ki se ujema z ',
    'fsc1' => ' objavil uporabnik ',
    'fsc2' => ' z IP-ja ',
    'uMTlist' => 'Posodobi �rno listo MT',
    'uMTlist2' => ': Dodani ',
    'uMTlist3' => ' vpisi in izbrisani ',
    'entries' => ' vpisi.',
    'uPlist' => 'Posodobi osebno �rno listo',
    'entriesadded' => 'Vpisi dodani',
    'entriesdeleted' => 'Vpisi izbrisani',
    'viewlog' => 'Oglej si Spam-X Log',
    'clearlog' => 'Po�isti datoteko Log',
    'logcleared' => '- Datoteka Spam-X Log po�i��ena',
    'plugin' => 'Vti�nik',
    'action' => 'Action',
    'access_denied' => 'Dostop zavrnjen',
    'access_denied_msg' => 'Dostop do te strani imajo samo korenski (root) uporabniki. Tvoje uporabni�ko ime in IP sta zapisana.',
    'admin' => 'Upravljanje vti�nikov',
    'install_header' => 'Namesti/deinstaliraj vti�nik',
    'installed' => 'Vti�nik je name��en',
    'uninstalled' => 'Vti�nik ni name��en',
    'install_success' => 'Namestitev uspe�na',
    'install_failed' => 'Namestitev ni uspela -- Za razloge poglej error log.',
    'uninstall_msg' => 'Vti�nik uspe�no odstranjen',
    'install' => 'Namesti',
    'uninstall' => 'Odstrani',
    'warning' => 'Opozorilo! Vti�nik je �e vedno omogo�en',
    'enabled' => 'Pred odstranitvijo vti�nik onemogo�i.',
    'readme' => 'STOP! Preden za�ene� namestitev, prosim preberi ',
    'installdoc' => 'Install Document.',
    'spamdeleted' => 'Izbrisan Spam Post',
    'foundspam' => 'Najden Spam Post, ki se ujema z ',
    'foundspam2' => ' objavil uporabnik ',
    'foundspam3' => ' z IP ',
    'deletespam' => 'Izbri�i Spam',
    'numtocheck' => '�tevilo komentarjev za preverbo',
    'note1' => '<p>Opomba: Masovni izbris je namenjen kot pomo� v primeru, ko te doleti',
    'note2' => ' spam komenratjev in ga Spam-X ne ujame.  <ul><li>najprej najdi povezavo/povezave ali druge ',
    'note3' => 'identifikatorje tega spama komentarjev in jo/jih dodaj na osebno �rno listo.</li><li>Nato ',
    'note4' => 'se vrni sem in s Spam-X preveri zadnje komentarje za morebiten spam.</li></ul><p>Komentarji ',
    'note5' => 'so preverjeni od najnovej�ega do najstarej�ega -- preveritev ve� komentarjev ',
    'note6' => 'zahteva dalj�i �as preverjanja.</p>',
    'masshead' => '<hr' . XHTML . '><h1 align="center">Masovni izbris spam komentarjev</h1>',
    'masstb' => '<hr' . XHTML . '><h1 align="center">Masovni izbris spam trackbackov</h1>',
    'comdel' => ' komentarjev izbrisanih.',
    'initial_Pimport' => '<p>Uvoz osebne �rne liste"',
    'initial_import' => 'Za�etni uvoz MT-�rne liste',
    'import_success' => '<p>�tevilo uspe�no uvo�enih vnosov �rne liste: %d .',
    'import_failure' => '<p><strong>Error:</strong> Ni najdenih vnosov.',
    'allow_url_fopen' => '<p>�al konfiguracija tvojega spletnega stre�nika ne dopu��a branja oddaljenih datotek (<code>allow_url_fopen</code> je izklju�en). Prenesi prosim �rno listo s slede�ega URL in jo nalo�i v Geeklogov "podatkovni" direktorij, <tt>%s</tt>, preden poskusi� ponovno:',
    'documentation' => 'Dokumentacija vti�nika Spam-X',
    'emailmsg' => "Nova spam objava je bila oddana pri \"%s\"\nUser UID: \"%s\"\n\nContent:\"%s\"",
    'emailsubject' => 'Spam objava pri %s',
    'ipblack' => 'Spam-X IP Blacklist',
    'ipofurlblack' => 'Spam-X IP of URL Blacklist',
    'headerblack' => 'Spam-X HTTP Header Blacklist',
    'headers' => 'Zahtevaj glave:',
    'edit' => 'Edit',
    'view' => 'View',
    'value' => 'Value',
    'counter' => 'Counter',
    'stats_headline' => 'Spam-X statistika',
    'stats_page_title' => '�rna lista',
    'stats_entries' => 'Vnosi',
    'stats_mtblacklist' => 'MT-�rna lista',
    'stats_pblacklist' => 'Osebna �rna lista',
    'stats_ip' => 'Blokirani IP-ji',
    'stats_ipofurl' => 'Blokirano z IP URL-ja',
    'stats_header' => 'HTTP glave',
    'stats_deleted' => 'Objave, izbrisane kot spam',
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
    'slvwhitelist' => 'SLV bela lista'
);

// Define Messages that are shown when Spam-X module action is taken
$PLG_spamx_MESSAGE128 = 'Odkrit spam. Objava je bila izbrisana.';
$PLG_spamx_MESSAGE8 = 'Odkrit spam. E-po�ta poslana skrbniku.';

// Messages for the plugin upgrade
$PLG_spamx_MESSAGE3001 = 'Nadgradnja vti�nika ni podprta.';
$PLG_spamx_MESSAGE3002 = $LANG32[9];

// Localization of the Admin Configuration UI
$LANG_configsections['spamx'] = array(
    'label' => 'Spam-X',
    'title' => 'Konfiguracija Spam-X'
);

$LANG_confignames['spamx'] = array(
    'spamx_action' => 'Spam-X Actions',
    'notification_email' => 'Obvestilna e-po�ta',
    'logging' => 'Omogo�i shranjevanje v log',
    'timeout' => 'Timeout',
    'max_age' => 'Max Age of Records',
    'records_delete' => 'Record Types to Delete',
    'sfs_enabled' => 'Enable SFS',
    'sfs_confidence' => 'Confidence Threshold',
    'snl_enabled' => 'Enable SNL',
    'snl_num_links' => 'Number of links'
);

$LANG_configsubgroups['spamx'] = array(
    'sg_main' => 'Glavne nastavitve'
);

$LANG_tab['spamx'] = array(
    'tab_main' => 'Spam-X Main Settings',
    'tab_modules' => 'Modules'
);

$LANG_fs['spamx'] = array(
    'fs_main' => 'Glavne nastavitve Spam-X',
    'fs_sfs' => 'Stop Forum Spam (SFS)',
    'fs_snl' => 'Spam Number of Links (SNL)'
);

// Note: entries 0, 1, 9, and 12 are the same as in $LANG_configselects['Core']
$LANG_configselects['spamx'] = array(
    0 => array('Da' => 1, 'Ne' => 0),
    1 => array('Da' => 'velja', 'Ne' => 'ne velja')
);

?>
