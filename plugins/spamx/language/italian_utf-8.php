<?php

###############################################################################
# italian_utf-8.php
#
# This is the Italian language file for the Geeklog Spam-X Plugin
#
#  Copyright (C) 2004 Tom Willett         tomw AT pigstye DOT net
#  Copyright (C) 2005 magomarcelo         magomarcelo AT gmail DOT com
#                                         magomarcelo.blogspot.com
#  Copyright (C) 2011 Rouslan Placella    rouslan {at} placella {dot} com
#
# This program is free software; you can redistribute it and/or
# modify it under the terms of the GNU General Public License
# as published by the Free Software Foundation; either version 2
# of the License, or (at your option) any later version.
#
# This program is distributed in the hope that it will be useful,
# but WITHOUT ANY WARRANTY; without even the implied warranty of
# MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
# GNU General Public License for more details.
#
# You should have received a copy of the GNU General Public License
# along with this program; if not, write to the Free Software
# Foundation, Inc., 59 Temple Place - Suite 330, Boston, MA  02111-1307, USA.
#
###############################################################################

global $LANG32;

$LANG_SX00 = array(
    'inst1' => '<p>Cosí facendo, poi altri ',
    'inst2' => 'saranno in grado di visualizzare ed importare la tua blacklist personale e noi possiamo creare un piú efficace ',
    'inst3' => 'database distribuito.</p><p>Se hai iscritto il tuo sito web e decidi che non desideri piú che esso rimanga nella lista ',
    'inst4' => 'invia una e-mail a <a href="mailto:spamx@pigstye.net">spamx@pigstye.net</a> per dirmelo. ',
    'inst5' => 'Saranno onorate tutte le richieste.',
    'submit' => 'Invia',
    'subthis' => 'questa informazione al Database Centrale Spam-X',
    'secbut' => 'Questo secondo bottone crea un feed rdf in modo che altri possano importare la tua lista.',
    'sitename' => 'Nome Sito: ',
    'URL' => 'URL Lista Spam-X: ',
    'RDF' => 'URL RDF: ',
    'impinst1a' => 'Prima di utilizzare la funzionalitá di blocco commenti Spam di Spam-X per visualizzare ed importare le Blacklist personali da altri',
    'impinst1b' => ' siti, ti chiedo di premere sui due seguenti bottoni. (Devi premerne almeno uno.)',
    'impinst2' => 'Il primo registra il tuo sito web sul sito Gplugs/Spam-X in modo che possa essere aggiunto alla lista principale dei ',
    'impinst2a' => 'siti che condividono le proprie blacklist. (Nota: se hai piú di un sito potresti volerne indicare uno solo come il ',
    'impinst2b' => 'principale e registrare solo il suo nome. Ció ti permetterá di aggiornare i tuoi siti facilmente e mantenere la lista piú piccola.) ',
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
    'sfseblack' => 'Spam-X SFS Email Blacklist',
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
    'plugin' => 'Estensione',
    'access_denied' => 'Accesso Negato',
    'access_denied_msg' => 'Solo gli Utenti Root possono Accedere a questa Pagina. Il Tuo nome utente ed IP sono stati registrati.',
    'admin' => 'Amministrazione dell\'Estensione',
    'install_header' => 'Installa/Disinstalla Estensione',
    'installed' => 'L\'Estensione é Installata',
    'uninstalled' => 'L\'Estensione non é Installata',
    'install_success' => 'Installazione Completata con Successo',
    'install_failed' => 'Installazione Fallita -- Controlla l\'error log per scoprire il perché.',
    'uninstall_msg' => 'Estensione Disinstallata con Successo',
    'install' => 'Installa',
    'uninstall' => 'Disinstalla',
    'warning' => 'Attenzione! L\'estensione é ancora Attiva',
    'enabled' => 'Disattiva l\'estensione prima di disinstallarla.',
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
    'note5' => 'vengono controllati dal piú recente al meno recente -- controllare piú commenti ',
    'note6' => 'richiede piú tempo per il controllo</p>',
    'masshead' => '<hr' . XHTML . '><h1 align="center">Eliminazione in Blocco Commenti Spam</h1>',
    'masstb' => '<hr' . XHTML . '><h1 align="center">Mass Delete Trackback Spam</h1>',
    'comdel' => ' commenti eliminati.',
    'initial_Pimport' => '<p>Importazione Blacklist Personale"',
    'initial_import' => 'Importazione Iniziale MT-Blacklist',
    'import_success' => '<p>Importati con successo %d elementi della blacklist.',
    'import_failure' => '<p><strong>Errore:</strong> Nessun elemento trovato.',
    'allow_url_fopen' => '<p>Spiacente, la configurazione del tuo webserver non permette la lettura di file remoti (<code>allow_url_fopen</code> é off). Please download the blacklist from the following URL and upload it into Geeklog\'s "data" directory, <tt>%s</tt>, before trying again:',
    'documentation' => 'Documentazione di Spam-X',
    'emailmsg' => "Un nuovo commento spam é stato inviato su \"%s\"\nUID utente:\"%s\"\n\nContenuto:\"%s\"",
    'emailsubject' => 'Commento Spam, %s',
    'ipblack' => 'Blacklist degli IP di Spam-X',
    'ipofurlblack' => 'Blacklist degli IP di indirizzi',
    'headerblack' => 'Blacklist degli header HTTP',
    'headers' => 'Headers delle Richieste:',
    'stats_headline' => 'Statistiche di Spam-X',
    'stats_page_title' => 'Blacklist',
    'stats_entries' => 'Totale',
    'stats_mtblacklist' => 'MT-Blacklist',
    'stats_pblacklist' => 'Blacklist Personale',
    'stats_ip' => 'IP Bloccati',
    'stats_ipofurl' => 'Bloccati con IP di indirizzi',
    'stats_header' => 'Header HTTP',
    'stats_deleted' => 'Inserimenti Rimossi (Spam)',
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
$PLG_spamx_MESSAGE128 = 'Spam identificato ed il Commento o Messaggio é stato eliminato.';
$PLG_spamx_MESSAGE8 = 'Spam identificato. E-mail inviata all\'amministratore.';

// Messages for the plugin upgrade
$PLG_spamx_MESSAGE3001 = 'L\'aggiornamento di Estensioni non é supportato.';
$PLG_spamx_MESSAGE3002 = $LANG32[9];

// Localization of the Admin Configuration UI
$LANG_configsections['spamx'] = array(
    'label' => 'Spam-X',
    'title' => 'Configurazione di Spam-X'
);

$LANG_confignames['spamx'] = array(
    'spamx_action' => 'Spam-X Actions',
    'notification_email' => 'Notifica via Email',
    'logging' => 'Registrazione dell\'utilizzo e degli errori abilitata',
    'timeout' => 'Timeout',
    'sfs_enabled' => 'Enable SFS',
    'snl_enabled' => 'Enable SNL',
    'snl_num_links' => 'Number of links'
);

$LANG_configsubgroups['spamx'] = array(
    'sg_main' => 'Impostazioni Principali'
);

$LANG_tab['spamx'] = array(
    'tab_main' => 'Spam-X Main Settings',
    'tab_modules' => 'Modules'
);

$LANG_fs['spamx'] = array(
    'fs_main' => 'Impostazioni Principali di Spam-X',
    'fs_sfs' => 'Stop Forum Spam (SFS)',
    'fs_snl' => 'Spam Number of Links (SNL)'
);

// Note: entries 0, 1, 9, and 12 are the same as in $LANG_configselects['Core']
$LANG_configselects['spamx'] = array(
    0 => array('Vero' => 1, 'Falso' => 0),
    1 => array('Vero' => true, 'Falso' => false)
);

?>
