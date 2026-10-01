<?php

###############################################################################
# german_utf-8.php
#
# This is the German language file for the Geeklog Static Pages plugin
#
# Copyright (C) 2001 Tony Bibbs
# tony AT tonybibbs DOT com
#
# German translation by Dirk Haun <dirk AT haun-online DOT de>
# and Markus Wollschläger
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

###############################################################################
# Array Format:
# $LANGXX[YY]:  $LANG - variable name
#               XX    - file id number
#               YY    - phrase id number
###############################################################################

$LANG_STATIC = array(
    'newpage' => 'Neue Seite',
    'adminhome' => 'Schaltzentrale',
    'staticpages' => 'Statische Seiten',
    'staticpageeditor' => 'Editor für Statische Seiten',
    'writtenby' => 'Autor',
    'date' => 'Letzte Änderung',
    'title' => 'Titel',
    'page_title' => 'Seitentitel',
    'content' => 'Inhalt',
    'hits' => 'Angezeigt',
    'staticpagelist' => 'Liste der Statischen Seiten',
    'url' => 'URL',
    'edit' => 'Ändern',
    'lastupdated' => 'Letzte Änderung',
    'pageformat' => 'Seitenformat',
    'leftrightblocks' => 'Blöcke links &amp; rechts',
    'blankpage' => 'Leere Seite',
    'noblocks' => 'Keine Blöcke',
    'leftblocks' => 'Blöcke links',
    'addtomenu' => 'Ins Menü aufnehmen',
    'label' => 'Label',
    'nopages' => 'Es sind keine statischen Seiten vorhanden.',
    'save' => 'Speichern',
    'preview' => 'Vorschau',
    'delete' => 'Löschen',
    'cancel' => 'Abbruch',
    'access_denied' => 'Zugriff verweigert',
    'access_denied_msg' => 'Unerlaubter Zugriff, auf eine der Admin-Seiten für Statische Seiten. Hinweis: Alle derartigen Versuche werden protokolliert',
    'all_html_allowed' => 'Alle HTML-Tags sind erlaubt',
    'results' => 'Gefundene Statische Seiten',
    'author' => 'Autor',
    'no_title_or_content' => 'Bitte mindestens die Felder <b>Titel</b> und <b>Inhalt</b> ausfüllen.',
    'title_error_saving' => 'Fehler beim Speichern der Seite',
    'template_xml_error' => 'Die XML-Auszeichnung enthält einen <em>Fehler</em>. Diese Seite verwendet eine andere Seite als Vorlage und benötigt daher Vorlagenvariablen im XML-Format. Weitere Informationen finden Sie im <a href="http://wiki.geeklog.net/Static_Pages_Plugin#Template_Static_Pages" target="_blank">Geeklog-Wiki</a>. Der Fehler muss behoben werden, bevor die Seite gespeichert werden kann.',
    'no_such_page_anon' => 'Bitte einloggen.',
    'no_page_access_msg' => "Dies könnte passiert sein, weil Du nicht eingeloggt bist, oder kein Mitglied bist von  {$_CONF['site_name']}. Bitte <a href=\"{$_CONF['site_url']}/users.php?mode=new\"> Mitglied werden</a> bei {$_CONF['site_name']}, um vollen Zugriff zu erhalten.",
    'php_msg' => 'PHP: ',
    'php_warn' => 'Hinweis: Wenn diese Option aktiviert ist, wird in der Seite enthaltener PHP-Code ausgeführt. <em>Bitte mit Bedacht verwenden!</em>',
    'exit_msg' => 'Hinweistext: ',
    'exit_info' => 'Art des Hinweistextes, wenn kein Zugriff auf die Seite erlaubt ist: Aktiviert = "Anmeldung erforderlich", nicht aktiviert = "Zugriff verweigert".',
    'deny_msg' => 'Zugriff auf diese Seite ist nicht möglich. Die Seite wurde entweder umbenannt oder gelöscht oder Du hast nicht die nötigen Zugriffsrechte.',
    'stats_headline' => 'Top Ten der Statischen Seiten',
    'stats_page_title' => 'Titel',
    'stats_hits' => 'Angezeigt',
    'stats_no_hits' => 'Es gibt keine Statischen Seiten oder sie wurden von niemandem gelesen.',
    'id' => 'ID',
    'duplicate_id' => 'Diese ID wird bereits für eine andere Statische Seite benutzt. Bitte andere ID wählen.',
    'instructions' => 'Um eine Statische Seite zu ändern oder zu löschen, auf das Ändern-Symbol klicken. Um eine Statische Seite anzusehen, auf deren Titel klicken. Auf Neu anlegen (s.o.) klicken, um einen neue Statische Seite anzulegen. Auf das Kopie-Symbol klicken, um eine Kopie einer vorhandenen Seite zu erhalten.',
    'centerblock' => 'Centerblock: ',
    'centerblock_msg' => 'Wenn angekreuzt wird diese Seite als Block auf der Index-Seite angezeigt.',
    'topic' => 'Kategorie: ',
    'position' => 'Position: ',
    'all_topics' => 'Alle',
    'no_topic' => 'Nur auf der Startseite',
    'position_top' => 'Seitenanfang',
    'position_feat' => 'Nach Hauptartikel',
    'position_bottom' => 'Seitenende',
    'position_entire' => 'Ganze Seite',
    'head_centerblock' => 'Centerblock',
    'centerblock_no' => 'Nein',
    'centerblock_top' => 'oben',
    'centerblock_feat' => 'Hauptartikel',
    'centerblock_bottom' => 'unten',
    'centerblock_entire' => 'Ganze Seite',
    'inblock_msg' => 'Im Block: ',
    'inblock_info' => 'Block-Templates für diese Seite verwenden.',
    'title_edit' => 'Seite ändern',
    'title_copy' => 'Seite kopieren',
    'title_display' => 'Seite anzeigen',
    'select_php_none' => 'PHP nicht ausführen',
    'select_php_return' => 'PHP ausführen (mit return)',
    'select_php_free' => 'PHP ausführen',
    'php_not_activated' => "Das Verwenden von PHP in statischen Seiten ist nicht aktiviert. Hinweise zur Aktivierung finden sich in der <a href=\"{$_CONF['site_url']}/docs/english/staticpages.html#php\">Dokumentation</a>.",
    'printable_format' => 'Druckfähige Version',
    'copy' => 'Kopieren',
    'limit_results' => 'Ergebnisse einschränken',
    'search' => 'Suchen',
    'likes' => 'Gefällt-mir-Angaben',
    'submit' => 'Absenden',
    'no_new_pages' => 'Keine neuen Seiten',
    'pages' => 'SEITEN',
    'comments' => 'Kommentare',
    'template' => 'Vorlage',
    'use_template' => 'Vorlage verwenden',
    'template_msg' => 'Wenn angekreuzt kann diese Seite als Vorlage verwendet werden.',
    'none' => 'Keine',
    'use_template_msg' => 'Wenn diese Seite nicht selbst eine Vorlage ist, kann hier eine Vorlage zugewiesen werden. Bitte darauf achten, dass das korrekte XML-Format eingehalten wird.',
    'draft' => 'Entwurf',
    'draft_yes' => 'Ja',
    'draft_no' => 'Nein',
    'show_on_page' => 'Auf Seite anzeigen',
    'show_on_page_disabled' => 'Hinweis: Diese Option ist derzeit in der Konfiguration der statischen Seiten für alle Seiten deaktiviert.',
    'cache_time' => 'Cache-Dauer',
    'cache_time_desc' => 'This staticpage content will be cached for no longer than this many seconds. If 0 caching is disabled (3600 = 1 hour,  86400 = 1 day). Staticpages with PHP enabled or are a template will not be cached.',
    'autotag_desc_staticpage' => '[staticpage: id alternativer Titel] - Zeigt einen Link zu einer statischen Seite an und verwendet deren Seitentitel. Ein alternativer Titel kann optional angegeben werden.',
    'autotag_desc_staticpage_content' => '[staticpage_content: id alternate title] - Displays the contents of a staticpage.',
    'autotag_desc_page' => '[page: id alternativer Titel] - Zeigt einen Link zu einer Seite des Plugins Statische Seiten an und verwendet deren Seitentitel. Ein alternativer Titel kann optional angegeben werden.',
    'autotag_desc_page_content' => '[page_content: id] - Zeigt den Inhalt einer Seite des Plugins Statische Seiten an.',
    'yes' => 'Ja',
    'used_by' => 'Diese Vorlage ist %s Seite(n) zugewiesen. Sie kann von weiteren Seiten verwendet werden, wenn sie über ein Autotag in einer anderen Vorlage geladen wird.',
    'prev_page' => 'Vorherige Seite',
    'next_page' => 'Nächste Seite',
    'parent_page' => 'Übergeordnete Seite',
    'page_desc' => 'Setting a previous and/or next page will add HTML link elements rel=”next” and rel=”prev” to the header to indicate the relationship between pages in a paginated series. Actual page navigation links are not added to the page. You have to add these yourself. NOTE: Parent page is currently not being used.',
    'num_pages' => '%s Seite(n)',
    'search_desc' => 'Control if page appears in search. Default depends on setting in Configuration and depends on page type (if it is a Center Block, Uses a Template, or Uses PHP).',
    'likes_desc' => 'Legt fest, ob und wie die Gefällt-mir-Steuerung auf der Seite angezeigt wird. Der Standardwert hängt von der Plugin-Konfiguration ab. Seiten, die als Centerblock angezeigt werden, zeigen diese Steuerung nicht. Vorlagen verwenden diese Einstellung nicht.'
);

$LANG_staticpages_search = array(
    0  => 'Ausgeschlossen',
    1  => 'Standard verwenden',
    2  => 'Eingeschlossen'
);

$LANG_staticpages_likes = array(
    -1 => 'Standard verwenden',
    0  => 'Deaktiviert',
    1  => 'Gefällt mir und Gefällt mir nicht',
    2  => 'Nur Gefällt mir',
);

$PLG_staticpages_MESSAGE15 = 'Der Kommentar wurde gespeichert, muss aber noch von einem Moderator freigegeben werden.';
$PLG_staticpages_MESSAGE19 = 'Seite wurde gespeichert.';
$PLG_staticpages_MESSAGE20 = 'Seite wurde gelöscht';
$PLG_staticpages_MESSAGE21 = 'Diese Seite existiert noch nicht. Um eine Seite zu erstellen bitte das Formular unten ausfüllen. Durch ein Versehen hier? Einfach den Abbrechen-Knopf drücken.';
$PLG_staticpages_MESSAGE22 = 'You could not delete the page. It is a template staticpage and it is currently assigned to 1 or more staticpages.';

// Messages for the plugin upgrade
$PLG_staticpages_MESSAGE3001 = 'Plugin upgrade not supported.';
$PLG_staticpages_MESSAGE3002 = $LANG32[9];

// Localization of the Admin Configuration UI
$LANG_configsections['staticpages'] = array(
    'label' => 'Statische Seiten',
    'title' => 'Konfiguration Statische Seiten'
);

$LANG_confignames['staticpages'] = array(
    'allow_php' => 'PHP erlauben?',
    'enable_eval_php_save' => 'PHP beim Speichern der Seite auswerten',
    'sort_by' => 'Centerblocks sortieren nach',
    'sort_menu_by' => 'Menüeinträge sortieren nach',
    'sort_list_by' => 'Adminliste sortieren nach',
    'delete_pages' => 'Seiten mit Benutzer löschen?',
    'in_block' => 'Block-Template verwenden?',
    'show_hits' => 'Anzeigezähler einblenden?',
    'show_date' => 'Datum anzeigen?',
    'filter_html' => 'HTML filtern?',
    'censor' => 'Inhalt zensieren?',
    'default_permissions' => 'Grundeinstellungen Statische Seiten',
    'autotag_permissions_staticpage' => 'Berechtigungen für [staticpage: ]',
    'autotag_permissions_staticpage_content' => 'Berechtigungen für [staticpage_content: ]',
    'aftersave' => 'Nach dem Speichern der Seiten',
    'atom_max_items' => 'Max. Seiten in Webservices Newsfeed',
    'meta_tags' => 'Meta-Tags verwenden',
    'likes_pages' => 'Gefällt mir für Seiten',
    'comment_code' => 'Kommentar Grundeinstellung',
    'structured_data_type_default' => 'Standardtyp für strukturierte Daten',
    'draft_flag' => 'Als Grundeinstellung auf Entwurf',
    'disable_breadcrumbs_staticpages' => 'Breadcrumbs deaktivieren',
    'default_cache_time' => 'Standard-Cachezeit',
    'newstaticpagesinterval' => 'Zeitabstand für neue Seiten',
    'hidenewstaticpages' => 'Neue Seiten ausblenden',
    'title_trim_length' => 'Titel abschneiden nach',
    'includecenterblocks' => 'Centerblock-Seiten berücksichtigen',
    'includephp' => 'Seiten mit PHP berücksichtigen',
    'includesearch' => 'Statische Seiten durchsuchen',
    'includesearchcenterblocks' => 'Centerblock-Seiten berücksichtigen',
    'includesearchphp' => 'Seiten mit PHP berücksichtigen',
    'includesearchtemplate' => 'Vorlagen-Seiten einbeziehen'
);

$LANG_configsubgroups['staticpages'] = array(
    'sg_main' => 'Haupteinstellungen'
);

$LANG_tab['staticpages'] = array(
    'tab_main' => 'Haupteinstellungen für statische Seiten',
    'tab_whatsnew' => 'Was-ist-neu-Block',
    'tab_search' => 'Suchergebnisse',
    'tab_permissions' => 'Standardberechtigungen',
    'tab_autotag_permissions' => 'Autotag-Rechte'
);

$LANG_fs['staticpages'] = array(
    'fs_main' => 'Statische Seiten Haupteinstellungen',
    'fs_whatsnew' => 'Was-ist-neu-Block',
    'fs_search' => 'Suchergebnisse',
    'fs_permissions' => 'Grundeinstellungen Rechte',
    'fs_autotag_permissions' => 'Autotag-Rechte'
);

// Note: entries 0, 1, 9, 12, 17 are the same as in $LANG_configselects['Core']
$LANG_configselects['staticpages'] = array(
    0 => array('Wahr' => 1, 'Falsch' => 0),
    1 => array('Wahr' => TRUE, 'Falsch' => FALSE),
    2 => array('Datum' => 'date', 'Seiten-ID' => 'id', 'Titel' => 'title'),
    3 => array('Datum' => 'date', 'Seiten-ID' => 'id', 'Titel' => 'title', 'Bezeichnung' => 'label'),
    4 => array('Datum' => 'date', 'Seiten-ID' => 'id', 'Titel' => 'title', 'Autor' => 'author'),
    5 => array('Ausblenden' => 'hide', 'Anzeigen - Änderungsdatum verwenden' => 'modified', 'Anzeigen - Erstellungsdatum verwenden' => 'created'),
    9 => array('Zur Seite weiterleiten' => 'item', 'Liste anzeigen' => 'list', 'Startseite anzeigen' => 'home', 'Administration anzeigen' => 'admin'),
    12 => array('Kein Zugriff' => 0, 'Nur lesen' => 2, 'Lesen und schreiben' => 3),
    13 => array('Kein Zugriff' => 0, 'Verwenden' => 2),
    17 => array('Kommentare aktiviert' => 0, 'Kommentare deaktiviert' => -1),
    39 => array('Keine' => '', 'WebPage' => 'core-webpage', 'Article' => 'core-article', 'NewsArticle' => 'core-newsarticle', 'BlogPosting' => 'core-blogposting'),
    41 => array('Falsch' => 0, 'Gefällt mir und Gefällt mir nicht' => 1, 'Nur Gefällt mir' => 2)
);
