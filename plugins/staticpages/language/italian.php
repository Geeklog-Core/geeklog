<?php

###############################################################################
# lang.php
# This is the english language page for the Geeklog Static Page Plug-in!
#
# Copyright (C) 2001 Tony Bibbs
# tony@tonybibbs.com
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

###############################################################################
# Array Format: 
# $LANGXX[YY]:	$LANG - variable name
#		  	XX - file id number
#			YY - phrase id number
###############################################################################


$LANG_STATIC= array(
    newpage => 'Nuova Pagina',
    adminhome => 'Home Amministrazione',
    staticpages => 'Pagine Statiche',
    staticpageeditor => 'Editor Pagine Statiche',
    writtenby => 'Scritto da',
    date => 'Ultimo Agg.',
    title => 'Titolo',
    content => 'Contenuto',
    hits => 'Visite',
    staticpagelist => 'Lista Pagine Statiche',
    url => 'URL',
    edit => 'Modifica',
    lastupdated => 'Ultimo Agg.',
    pageformat => 'Formato Pag.',
    leftrightblocks => 'Blocchi a Sinistra & Destra',
    blankpage => 'Pagina Vuota',
    noblocks => 'Nessun Blocco',
    leftblocks => 'Blocchi a Sinistra',
    addtomenu => 'Agg. al Menu',
    label => 'Etichetta',
    nopages => 'Nessuna pagina statica al momento nel sistema',
    save => 'Salva',
    preview => 'Anteprima',
    delete => 'Cancella',
    cancel => 'Elimina',
    access_denied => 'Accesso Negato',
    access_denied_msg => 'Stai tentando di accedere illegalmente all\'Amministrazione Pagine Statiche.  Prego nota che tutti i tentativi di accesso illegali sono registrati',
    all_html_allowed => 'Tutto l\'HTML permesso',
    results => 'Risultati Pagine Statiche',
    author => 'Autore',
    no_title_or_content => 'Devi almeno compilare i campi <b>Titolo</b> e <b>Contenuto</b>.',
    no_such_page_logged_in => 'Spiacenti '.$_USER['username'].'..',
    no_such_page_anon => 'Prego entra nel sito..',
    no_page_access_msg => "Questo potrebbe indicare che tu non sei entrato nel sito, o non sei un membro di {$_CONF["site_name"]}. Prego <a href=\"{$_CONF['site_url']}/users.php?mode=new\"> diventa un membro</a> di {$_CONF["site_name"]} per ricevere pieno accesso al sito",
    php_msg => 'PHP: ',
    php_warn => 'Attenzione: il codice PHP della tua pagina sar&agrave; valutato se abiliti questa opzione. <br><strong>Usare con cautela !!</strong>',
    exit_msg => 'Tipo Uscita: ',
    exit_info => 'Abilita per Richiesta Messaggio di Login.  Lascia deselezionato per il normale controllo di sicurezza e messaggio.',
    deny_msg => 'Accesso a questa pagina negato.  Pu&ograve; essere che questa pagina &egrave; stata spostata/rimossa o che non hai i permessi sufficiente per visulaizzarla.',
    stats_headline => 'Top 10 Pagine Statiche',
    stats_page_title => 'Titolo Pagina',
    stats_hits => 'Visite',
    stats_no_hits => 'Sembra che non ci siano pagine statiche in questo sito o che nessuno ne ha ancora visualizzata una.',
    id => 'ID',
    duplicate_id => 'L\'ID che hai selezionato per questa pagina statica &egrave; gi&agrave; in uso. Prego seleziona un\'altro ID.',
    instructions => 'Per modificare o eliminare una pagina statica, clicca sul numero della pagina sotto. Per visualizzare una pagina statica, clicca sul titolo della pagina che desideri vedere. Per creare una nuova pagina statica clicca su [ Nuova Pagina ] sopra. Clicca su [C] per creare una copia di una pagina esistente.',
    centerblock => 'BloccoCentrale: ',
    centerblock_msg => 'Quando selezionato, questa Pagina Statica sar&agrave; visualizzata come un blocco centrale nella pagina index.',
    topic => 'Argomento: ',
    position => 'Posizione: ',
    all_topics => 'Tutte',
    no_topic => 'Solo Homepage',
    position_top => 'Capo Pagina',
    position_feat => 'Dopo Articolo Evidenziato',
    position_bottom => 'Fine Pagina',
    position_entire => 'Pagina Intera',
    head_centerblock => 'BloccoCentrale',
    centerblock_no => 'No',
    centerblock_top => 'Capo Pag.',
    centerblock_feat => 'Art. Evidenz.',
    centerblock_bottom => 'Fine Pag.',
    centerblock_entire => 'Intera Pagina'
);

?>
