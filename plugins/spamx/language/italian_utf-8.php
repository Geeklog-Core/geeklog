<?php

/**
 * File: italian.php
 * This is the Italian language page for the Geeklog Spam-X Plug-in!
 * 
 * Copyright (C) 2004 by the following authors:
 * Author        Tom Willett        tomw AT pigstye DOT net
 * Copyright (C) 2005 magomarcelo   magomarcelo AT gmail DOT com
 *                                  magomarcelo.blogspot.com
 *
 * Licensed under GNU General Public License
 *
 * $Id: italian_utf-8.php,v 1.2 2008/05/02 15:08:10 dhaun Exp $
 */

global $LANG32;

$LANG_SX00 = array(
    'inst1' => '<p>Cos&igrave; facendo, poi altri ',
    'inst2' => 'saranno in grado di visualizzare ed importare la tua blacklist personale e noi possiamo creare un pi&ugrave; efficace ',
    'inst3' => 'database distribuito.</p><p>Se hai iscritto il tuo sito web e decidi che non desideri pi&ugrave; che esso rimanga nella lista ',
    'inst4' => 'invia una e-mail a <a href="mailto:spamx@pigstye.net">spamx@pigstye.net</a> per dirmelo. ',
    'inst5' => 'Saranno onorate tutte le richieste.',
    'submit' => 'Invia',
    'subthis' => 'questa informazione al Database Centrale Spam-X',
    'secbut' => 'Questo secondo bottone crea un feed rdf in modo che altri possano importare la tua lista.',
    'sitename' => 'Nome Sito: ',
    'URL' => 'URL Lista Spam-X: ',
    'RDF' => 'URL RDF: ',
    'impinst1a' => 'Prima di utilizzare la funzionalit&agrave; di blocco commenti Spam di Spam-X per visualizzare ed importare le Blacklist personali da altri',
    'impinst1b' => ' siti, ti chiedo di premere sui due seguenti bottoni. (Devi premerne almeno uno.)',
    'impinst2' => 'Il primo registra il tuo sito web sul sito Gplugs/Spam-X in modo che possa essere aggiunto alla lista principale dei ',
    'impinst2a' => 'siti che condividono le proprie blacklist. (Nota: se hai pi&ugrave; di un sito potresti volerne indicare uno solo come il ',
    'impinst2b' => 'principale e registrare solo il suo nome. Ci&ograve; ti permetter&agrave; di aggiornare i tuoi siti facilmente e mantenere la lista pi&ugrave; piccola.) ',
    'impinst2c' => 'Dope aver premuto il bottone Invia, premi [back] sul tuo browser per tornare qui.',
    'impinst3' => 'Saranno inviati i seguenti valori: (puoi modificarli se sono errati).',
    'availb' => 'Blacklist Disponibili',
    'clickv' => 'Fai Clic per Visualizzare la Blacklist',
    'clicki' => 'Fai Clic per Importare la Blacklist',
    'ok' => 'OK',
    'rsscreated' => 'Feed RSS Creato',
    'add1' => 'Aggiunti ',
    'add2' => ' elementi dalla blacklist di ',
    'add3' => '.',
    'adminc' => 'Comandi di Amministrazione:',
    'mblack' => 'La Mia Blacklist:',
    'rlinks' => 'Collegamenti Correlati:',
    'e3' => 'Per Aggiungere le parole presenti nella Censor List di Geeklog Premi il Bottone:',
    'addcen' => 'Aggiungi Censor List',
    'addentry' => 'Aggiungi Elemento',
    'e1' => 'Per Eliminare un elemento fai clic su di esso.',
    'e2' => 'Per Aggiungere un elemento, inseriscilo nel box e fai clic su Aggiungi. Gli elementi possono utilizzare tutti i tipi di Espressioni Regolari Perl.',
    'pblack' => 'Blacklist Personale Spam-X',
    'conmod' => 'Configura Utilizzo Modulo Spam-X',
    'acmod' => 'Moduli Azione Spam-X',
    'exmod' => 'Moduli Analisi Spam-X',
    'actmod' => 'Moduli Attivi',
    'avmod' => 'Moduli Disponibili',
    'coninst' => '<hr' . XHTML . '>Fai clic su un modulo Attivo per eliminarlo, fai clic su un modulo Disponibile per aggiungerlo.<br' . XHTML . '>I moduli vengono eseguiti nell\'ordine visualizzato.',
    'fsc' => 'Trovato Commento Spam corrispondente a ',
    'fsc1' => ' inviato dall\'utente ',
    'fsc2' => ' from IP ',
    'uMTlist' => 'Aggiorna MT-Blacklist',
    'uMTlist2' => ': Aggiunti ',
    'uMTlist3' => ' elementi ed eliminati ',
    'entries' => ' elementi.',
    'uPlist' => 'Aggiorna Blacklist Personale',
    'entriesadded' => 'Elementi Aggiunti',
    'entriesdeleted' => 'Elementi Elminati',
    'viewlog' => 'Visualizza Log Spam-X',
    'clearlog' => 'Cancella File di Log',
    'logcleared' => '- File di Log di Spam-X Cancellato',
    'plugin' => 'Plugin',
    'access_denied' => 'Accesso Negato',
    'access_denied_msg' => 'Solo gli Utenti Root possono Accedere a questa Pagina. Il Tuo nome utente ed IP sono stati registrati.',
    'admin' => 'Amministrazione Plugin',
    'install_header' => 'Installa/Disinstalla Plugin',
    'installed' => 'Il Plugin &egrave; Installato',
    'uninstalled' => 'Il Plugin Non &egrave; Installato',
    'install_success' => 'Installation Successful',
    'install_failed' => 'Installazione Fallita -- Controlla l\'error log per scoprire il perch&egrave;.',
    'uninstall_msg' => 'Plugin Disinstallato con Successo',
    'install' => 'Installa',
    'uninstall' => 'Disinstalla',
    'warning' => 'Attenzione! Il plugin &egrave; ancora Attivo',
    'enabled' => 'Disattiva il plugin prima di disinstallarlo.',
    'readme' => 'STOP! Prima di premere prego leggi il ',
    'installdoc' => 'Installa Documento.',
    'spamdeleted' => 'Commento Spam Eliminato',
    'foundspam' => 'Trovato Commento Spam corrispondente a ',
    'foundspam2' => ' inviato dall\'utente ',
    'foundspam3' => ' dall\'IP ',
    'deletespam' => 'Elimina Spam',
    'numtocheck' => 'Numero Commenti da controllare',
    'note1' => '<p>Nota: L\'Eliminazione in Blocco serve ad aiutarti quando sei colpito da',
    'note2' => ' commenti spam e Spam-X non riesce a bloccarli. <ul><li>Prima cerca il o i link o altri ',
    'note3' => 'identificatori di questo commento Spam ed aggiungilo alla tua blacklist personale.</li><li>Poi ',
    'note4' => 'torna qui a fai controllare a Spam-X se gli ultimi commenti sono spam.</li></ul><p>I commenti ',
    'note5' => 'vengono controllati dal pi&ugrave; recente al meno recente -- controllare pi&ugrave; commenti ',
    'note6' => 'richiede pi&ugrave; tempo per il controllo</p>',
    'masshead' => '<hr' . XHTML . '><h1 align="center">Eliminazione in Blocco Commenti Spam</h1>',
    'masstb' => '<hr' . XHTML . '><h1 align="center">Mass Delete Trackback Spam</h1>',
    'comdel' => ' commenti eliminati.',
    'initial_Pimport' => '<p>Importazione Blacklist Personale"',
    'initial_import' => 'Importazione Iniziale MT-Blacklist',
    'import_success' => '<p>Importati con successo %d elementi della blacklist.',
    'import_failure' => '<p><strong>Errore:</strong> Nessun elemento trovato.',
    'allow_url_fopen' => '<p>Spiacente, la configurazione del tuo webserver non permette la lettura di file remoti (<code>allow_url_fopen</code> &egrave; off). Please download the blacklist from the following URL and upload it into Geeklog\'s "data" directory, <tt>%s</tt>, before trying again:',
    'documentation' => 'Documentazione Plugin Spam-X',
    'emailmsg' => "Un nuovo commento spam &egrave; stato inviato su \"%s\"\nUID utente:\"%s\"\n\nContenuto:\"%s\"",
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
$PLG_spamx_MESSAGE128 = 'Spam identificato ed il Commento o Messaggio &egrave; stato eliminato.';
$PLG_spamx_MESSAGE8 = 'Spam identificato. E-mail inviata all\'amministratore.';

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
    'admin_override' => 'Don\'t Filter Admin Posts',
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
