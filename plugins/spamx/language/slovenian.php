<?php

/**
 * File: # slovenian.php - version 1.7
 * This is the slovenian language file for the Geeklog Spam-X plugin
 * language file for geeklog version 1.7 by Mateja B.
 * gape@gape.org ; za pripombe, predloge ipd. piši na e-naslov

 * 
 * Copyright (C) 2004-2006 by the following authors:
 * Author        Tom Willett        tomw AT pigstye DOT net
 * 
 * Licensed under GNU General Public License
 *
 */

global $LANG32;

$LANG_SX00 = array(
    'inst1' => '<p>Èe storiš to, potem si bodo drugi ',
    'inst2' => ' lahko ogledali in uvozili tvojo èrno listo, in lahko bomo ustvarili uèinkovitejšo ',
    'inst3' => 'razvršèeno podatkovno bazo.</p><p>Èe si oddal/a svojo spletno stran in noèeš, da tvoja spletna stran ostane na listi, ',
    'inst4' => 'to sporoèi prek e-pošte na naslov <a href="mailto:spamx@pigstye.net">spamx@pigstye.net</a>. ',
    'inst5' => 'Vse zahteve bodo spoštovane.',
    'submit' => 'Oddaj',
    'subthis' => 'te informacije v centralno podatkovno bazo Spam-X',
    'secbut' => 'Ta, drugi gumb ustvari združeno vsebino v zapisu rdf, da lahko drugi uvozijo tvojo listo.',
    'sitename' => 'Ime strani: ',
    'URL' => 'URL v seznam Spam-X : ',
    'RDF' => 'RDF url: ',
    'impinst1a' => 'Preden uporabiš pripomoèek Spam-X comment Spam blocker, da pogledaš in uvoziš osebne èrne list z drugih',
    'impinst1b' => ' strani, prosim klikni naslednja dva gumba. (Klikniti moraš zadnjega.)',
    'impinst2' => 'To najprej odda tvojo spletno stran na stran Gplugs/Spam-X, da bo lahko dodana na glavno listo ',
    'impinst2a' => 'strani, ki si delijo èrne liste. (Opomba: Èe imaš veè strani, hoèeš morda eno doloèiti kot ',
    'impinst2b' => 'glavno in oddati samo njeno ime. To ti bo omogoèilo preprosto posodobitev svojih strani in ohraniti krajšo listo.) ',
    'impinst2c' => 'Po kliku na gumb Oddaj se z gumbom Nazaj v brskalniku vrni spet sem.',
    'impinst3' => 'Poslane bodo naslednje vrednosti: (èe so napaène, jih uredi).',
    'availb' => 'Razpoložljive èrne liste',
    'clickv' => 'Klikni za ogled èrne liste',
    'clicki' => 'Klikni za uvoz èrne liste',
    'ok' => 'V redu',
    'rsscreated' => 'Ustvarjena združena vsebina RSS',
    'add1' => 'Dodani ',
    'add2' => ' vpisi s èrne liste uporabnika ',
    'add3' => '.',
    'adminc' => 'Skrbniški ukazi:',
    'mblack' => 'Moja èrna lista:',
    'rlinks' => 'Sorodne povezave:',
    'e3' => ' Za dodajanje besed iz Geeklogovega cenzurnega seznama pritisni gumb:',
    'addcen' => 'Dodaj cenzurni seznam',
    'addentry' => 'Dodaj vpis',
    'e1' => 'Da vpis izbrišeš, ga klikni.',
    'e2' => 'Da vpis dodaš, ga vnesi v okence in klikni Dodaj. Vnosi lahko uporabljajo polne izraze Perl Regular.',
    'pblack' => 'Osebna èrna lista Spam-X',
    'conmod' => 'Konfiguriraj Spam-X Module Usage',
    'acmod' => 'Akcijski moduli Spam-X ',
    'exmod' => 'Preiskovalni moduli Spam-X ',
    'actmod' => 'Aktivni moduli',
    'avmod' => 'Razpoložljivi moduli',
    'coninst' => '<hr' . XHTML . '>Klikni na aktivni modul, da ga odstraniš, klikni na Razpoložljivi modul, da ga dodaš.<br' . XHTML . '>Moduli se izvajajo v predloženem vrstnem redu.',
    'fsc' => 'Najden Spam Post, ki se ujema z ',
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
    'access_denied_msg' => 'Dostop do te strani imajo samo korenski (root) uporabniki. Tvoje uporabniško ime in IP sta zapisana.',
    'admin' => 'Upravljanje vtiènikov',
    'install_header' => 'Namesti/deinstaliraj vtiènik',
    'installed' => 'Vtiènik je namešèen',
    'uninstalled' => 'Vtiènik ni namešèen',
    'install_success' => 'Namestitev uspešna',
    'install_failed' => 'Namestitev ni uspela -- Za razloge poglej error log.',
    'uninstall_msg' => 'Vtiènik uspešno odstranjen',
    'install' => 'Namesti',
    'uninstall' => 'Odstrani',
    'warning' => 'Opozorilo! Vtiènik je še vedno omogoèen',
    'enabled' => 'Pred odstranitvijo vtiènik onemogoèi.',
    'readme' => 'STOP! Preden zaèeneš namestitev, prosim preberi ',
    'installdoc' => 'Install Document.',
    'spamdeleted' => 'Izbrisan Spam Post',
    'foundspam' => 'Najden Spam Post, ki se ujema z ',
    'foundspam2' => ' objavil uporabnik ',
    'foundspam3' => ' z IP ',
    'deletespam' => 'Izbriši Spam',
    'numtocheck' => 'Število komentarjev za preverbo',
    'note1' => '<p>Opomba: Masovni izbris je namenjen kot pomoè v primeru, ko te doleti',
    'note2' => ' spam komenratjev in ga Spam-X ne ujame.  <ul><li>najprej najdi povezavo/povezave ali druge ',
    'note3' => 'identifikatorje tega spama komentarjev in jo/jih dodaj na osebno èrno listo.</li><li>Nato ',
    'note4' => 'se vrni sem in s Spam-X preveri zadnje komentarje za morebiten spam.</li></ul><p>Komentarji ',
    'note5' => 'so preverjeni od najnovejšega do najstarejšega -- preveritev veè komentarjev ',
    'note6' => 'zahteva daljši èas preverjanja.</p>',
    'masshead' => '<hr' . XHTML . '><h1 align="center">Masovni izbris spam komentarjev</h1>',
    'masstb' => '<hr' . XHTML . '><h1 align="center">Masovni izbris spam trackbackov</h1>',
    'comdel' => ' komentarjev izbrisanih.',
    'initial_Pimport' => '<p>Uvoz osebne èrne liste"',
    'initial_import' => 'Zaèetni uvoz MT-èrne liste',
    'import_success' => '<p>Število uspešno uvoženih vnosov èrne liste: %d .',
    'import_failure' => '<p><strong>Error:</strong> Ni najdenih vnosov.',
    'allow_url_fopen' => '<p>Žal konfiguracija tvojega spletnega strežnika ne dopušèa branja oddaljenih datotek (<code>allow_url_fopen</code> je izkljuèen). Prenesi prosim èrno listo s sledeèega URL in jo naloži v Geeklogov "podatkovni" direktorij, <tt>%s</tt>, preden poskusiš ponovno:',
    'documentation' => 'Dokumentacija vtiènika Spam-X',
    'emailmsg' => "Nova spam objava je bila oddana pri \"%s\"\nUser UID: \"%s\"\n\nContent:\"%s\"",
    'emailsubject' => 'Spam objava pri %s',
    'ipblack' => 'Spam-X IP Blacklist',
    'ipofurlblack' => 'Spam-X IP of URL Blacklist',
    'headerblack' => 'Spam-X HTTP Header Blacklist',
    'headers' => 'Zahtevaj glave:',
    'stats_headline' => 'Spam-X statistika',
    'stats_page_title' => 'Èrna lista',
    'stats_entries' => 'Vnosi',
    'stats_mtblacklist' => 'MT-èrna lista',
    'stats_pblacklist' => 'Osebna èrna lista',
    'stats_ip' => 'Blokirani IP-ji',
    'stats_ipofurl' => 'Blokirano z IP URL-ja',
    'stats_header' => 'HTTP glave',
    'stats_deleted' => 'Objave, izbrisane kot spam',
    'plugin_name' => 'Spam-X',
    'slvwhitelist' => 'SLV bela lista'
);

// Define Messages that are shown when Spam-X module action is taken
$PLG_spamx_MESSAGE128 = 'Odkrit spam. Objava je bila izbrisana.';
$PLG_spamx_MESSAGE8 = 'Odkrit spam. E-pošta poslana skrbniku.';

// Messages for the plugin upgrade
$PLG_spamx_MESSAGE3001 = 'Nadgradnja vtiènika ni podprta.';
$PLG_spamx_MESSAGE3002 = $LANG32[9];

// Localization of the Admin Configuration UI
$LANG_configsections['spamx'] = array(
    'label' => 'Spam-X',
    'title' => 'Konfiguracija Spam-X'
);

$LANG_confignames['spamx'] = array(
    'action' => 'Spam-X dejanja',
    'notification_email' => 'Obvestilna e-pošta',
    'logging' => 'Omogoèi shranjevanje v log',
    'timeout' => 'Timeout'
);

$LANG_configsubgroups['spamx'] = array(
    'sg_main' => 'Glavne nastavitve'
);

$LANG_fs['spamx'] = array(
    'fs_main' => 'Glavne nastavitve Spam-X'
);

// Note: entries 0, 1, 9, and 12 are the same as in $LANG_configselects['Core']
$LANG_configselects['spamx'] = array(
    0 => array('Da' => 1, 'Ne' => 0),
    1 => array('Da' => 'velja', 'Ne' => 'ne velja')
);

?>
