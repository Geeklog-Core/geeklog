<?php

/**
 * File: dutch.php
 * This is the Dutch language file for the Geeklog Spam-X plugin
 * 
 * Copyright (C) 2004-2008 by the following authors:
 * Author        Zippohontas        Zippohontas AT gmail DOT com
 * 
 * Licensed under GNU General Public License
 */

global $LANG32;

$LANG_SX00 = array (
    'inst1' => '<p>Als je dit doet, dan anderen ',
    'inst2' => 'kunnen dan je persoonlijke zwarte lijst zien en importeren zodat een meer effectieve database ',

    'inst3' => 'gemaakt kan worden.</p><p>Als je jouw website hebt ingestuurd en je besluit om niet meer op de lijst te willen staan ',

    'inst4' => 'stuur een email naar <a href="mailto:spamx@pigstye.net">spamx@pigstye.net</a> en zeg het mij. ',

    'inst5' => 'Alle verzoeken zullen ingewilligd worden.',
    'submit' => 'Verstuur',
    'subthis' => 'deze info naar Spam-X Centrale Database',
    'secbut' => 'Deze tweede knop maakt een rdf feed zodat anderen jouw lijst kunnen importeren.',

    'sitename' => 'Site Naam: ',
    'URL' => 'URL naar Spam-X List: ',
    'RDF' => 'RDF url: ',
    'impinst1a' => 'Voordat je de Spam-X commentaar Spam blokker kunt zien en Zwarte lijsten van anderen kunt importeren,',

    'impinst1b' => ' vraag ik je om de volgende twee knoppen in te drukken. (Je moet de laatste drukken.)',

    'impinst2' => 'De eerste verstuurd jouw website naar de Gplugs/Spam-X site zodat het kan toegevoegd worden aan de hoofdlijst van ',

    'impinst2a' => 'sites die hun zwarte lijst delen. (Note: Als je meerdere sites hebt, wil je misschien 1 site als master toewijzen ',

    'impinst2b' => 'en verstuur alleen zijn naam. Dit zorgt ervoor dat je jouw sites makkelijker kunt updaten en de lijst klein te houden.) ',

    'impinst2c' => 'Nadat je de verstuur knop hebt ingedrukt, gebruik de terug knop in je browser om hier terug te keren.',

    'impinst3' => 'De volgende waardes worden versuurd: (Je kunt ze wijzigen wanneer ze verkeerd zijn).',

    'availb' => 'Beschikbare Zwarte lijsten',
    'clickv' => 'Klik om de Zwarte lijst te bekijken',
    'clicki' => 'Klik om de Zwarte lijst te importeren',
    'ok' => 'OK',
    'rsscreated' => 'RSS Feed gemaakt',
    'add1' => 'Toegevoegd ',
    'add2' => ' invoer van ',
    'add3' => "'s Zwarte Lijst.",
    'adminc' => 'Administratie Commandos:',
    'mblack' => 'Mijn Zwarte Lijst:',
    'rlinks' => 'Gerelateerde Links:',
    'e3' => 'Om woorden toe te voegen aan de Geeklogs CensuurLijst Druk op de knop:',

    'addcen' => 'Voeg Censuur Lijst toe',
    'addentry' => 'Voeg een toe',
    'e1' => 'Om er een te wissen, klik hem.',
    'e2' => 'Om er een toe te voegen, voer hem in het vak en klik Toevoegen.  Invoer kan vollegige Perl Normale Expressies bevatten.',

    'pblack' => 'Spam-X Persoonlijke Zwarte Lijst',
    'conmod' => 'Configureer Spam-X Module gebruik',
    'acmod' => 'Spam-X Actie Modules',
    'exmod' => 'Spam-X Onderzoek Modules',
    'actmod' => 'Actieve Modules',
    'avmod' => 'Beschikbare Modules',
    'coninst' => '<hr' . XHTML . '>klik op een Actieve module om hem te verwijderewn, klik op een Beschikbare module om hem toe te voegen.<br' . XHTML . '>Modules worden uitgevoerd in lijst volgorde.',

    'fsc' => 'Spam bericht gevonden ',
    'fsc1' => ' geplaatst door gebruiker ',
    'fsc2' => ' van IP ',
    'uMTlist' => 'Update MT-Zwarte Lijst',
    'uMTlist2' => ': Toegevoegd ',
    'uMTlist3' => ' invoer en verwijderd ',
    'entries' => ' invoer.',
    'uPlist' => 'Update Persoonlijke Zwarte Lijst',
    'entriesadded' => 'Invoer toegevoegd',
    'entriesdeleted' => 'Invoer verwijderd',
    'viewlog' => 'Toon Spam-X Log',
    'clearlog' => 'Leeg Log bestand',
    'logcleared' => '- Spam-X Log bestand geleegd',
    'plugin' => 'Plugin',
    'access_denied' => 'Toegang geweigerd',
    'access_denied_msg' => 'Alleen Hoofd Gebruikers hebben toegang tot deze Pagina.  Je gebruikersnaam en IP zijn opgeslagen.',

    'admin' => 'Plugin Administratie',
    'install_header' => 'Installeer/De-installeer Plugin',
    'installed' => 'De Plugin is geïnstalleerd',
    'uninstalled' => 'De Plugin is Niet geïnstalleerd',
    'install_success' => 'Installatie Succesvol',
    'install_failed' => 'Installatie gefaald -- See jouw fout log om te zien waarom.',

    'uninstall_msg' => 'Plugin Succesvol gedeinstalleerd',
    'install' => 'Installeer',
    'uninstall' => 'Deïnstalleren',
    'warning' => 'Waarschuwing! Plugin is nog steeds Actief',
    'enabled' => 'Schakel plugin uit VOOR deïnstalleren.',
    'readme' => 'STOP! Voordat je Installeerd lees de ',
    'installdoc' => 'Installatie Documentatie.',
    'spamdeleted' => 'verwijderd Spam bericht',
    'foundspam' => 'Spam Bericht gevonden ',
    'foundspam2' => ' geplaatst door gebruiker ',
    'foundspam3' => ' van IP ',
    'deletespam' => 'Verwijder Spam',
    'numtocheck' => 'Aantal Commentaren om te controleren',
    'note1'        => '<p>Note: Massa verwijdering is bedoeld om te wanneer je getroffen wordt door',

    'note2'        => ' commentaar spam en Spam-X vangen het niet.</p><ul><li>Allereerst vind de link(s) of andere ',

    'note3'        => 'identificatie van deze spam commentaar en voeg het toe aan je Persoonlijke Zwarte Lijst.</li><li>Dan ',

    'note4'        => 'kom terug hier en laat spam-X laatste commentaren voor spam controleren.</li></ul><p>Commentaren ',

    'note5'        => 'worden gecontroleerd van het nieuwste naar het oudste -- controleren van meer commentaren ',

    'note6'        => 'vragen meer tijd voor de controle.</p>',
    'masshead'    => '<hr' . XHTML . '><h1 align="center">Massa verwijdering Spam Commentaren</h1>',

    'masstb' => '<hr' . XHTML . '><h1 align="center">Massa verwijdering Trackback Spam</h1>',

    'comdel'    => ' commentaren verwijderd.',
    'initial_Pimport' => '<p>Persoonlijke Zwarte Lijst Importeren"',
    'initial_import' => 'Initiële MT-Zwarte Lijst Importeren',
    'import_success' => '<p>Succesvol %d Zwarte Lijst data geïmporteerd.',
    'import_failure' => '<p><strong>Fout:</strong> Niets gevonden.',
    'allow_url_fopen' => '<p>Sorry, jouw webserver configuratie laat geen lezen van bestanden op afstand toe (<code>allow_url_fopen</code> staat uit). Download de Zwarte Lijst van de volgende URL en upload hem in Geeklog\'s "data" directory, <tt>%s</tt>, voor opnieuw te proberen:',

    'documentation' => 'Spam-X Plugin Documentatie',
    'emailmsg' => "Een nieuw spam bericht is verstuurd: \"%s\"\nGebruiker UID: \"%s\"\n\nInhoud:\"%s\"",

    'emailsubject' => 'Spam bericht bij %s',
    'ipblack' => 'Spam-X IP Zwarte Lijst',
    'ipofurlblack' => 'Spam-X IP of URL Zwarte Lijst',
    'headerblack' => 'Spam-X HTTP Header Zwarte Lijst',
    'headers' => 'Verzoek koppen:',

    'stats_headline' => 'Spam-X Statistieken',
    'stats_page_title' => 'Zwarte Lijst',
    'stats_entries' => 'Invoer',
    'stats_mtblacklist' => 'MT-Zwarte Lijst',
    'stats_pblacklist' => 'Persoonlijke Zwarte Lijst',
    'stats_ip' => 'Geblokkeerde IPs',
    'stats_ipofurl' => 'Geblokkeerd IP of URL',
    'stats_header' => 'HTTP koppen',
    'stats_deleted' => 'Berichten verwijderd als spam',

    'plugin_name' => 'Spam-X',
    'slvwhitelist' => 'SLV Witte Lijst'
);


/* Define Messages that are shown when Spam-X module action is taken */
$PLG_spamx_MESSAGE128 = 'Spam gedetecteerd. Bericht was verwijderd.';
$PLG_spamx_MESSAGE8   = 'Spam gedetecteerd. Email verstuurd aan admin.';

// Messages for the plugin upgrade
$PLG_spamx_MESSAGE3001 = 'Plugin upgrade niet ondersteund.';
$PLG_spamx_MESSAGE3002 = $LANG32[9];


// Localization of the Admin Configuration UI
$LANG_configsections['spamx'] = array(
    'label' => 'Spam-X',
    'title' => 'Spam-X Configuratiie'
);

$LANG_confignames['spamx'] = array(
    'spamx_action' => 'Spam-X Acties',
    'notification_email' => 'Notificatie Email',
    'logging' => 'Log Aan',
    'timeout' => 'Timeout'
);

$LANG_configsubgroups['spamx'] = array(
    'sg_main' => 'Hoofd Instellingen'
);

$LANG_tab['spamx'] = array(
    'tab_main' => 'Spam-X Hoofd Instellingen'
);

$LANG_fs['spamx'] = array(
    'fs_main' => 'Spam-X Hoofd Instellingen'
);

$LANG_configselects['spamx'] = array(
    0 => array('Waar' => 1, 'Fout' => 0),
    1 => array('Waar' => TRUE, 'Fout' => FALSE)
);

?>
