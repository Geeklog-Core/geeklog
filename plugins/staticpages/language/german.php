<?php

###############################################################################
# lang.php
# This is the german language file for the Geeklog Static Page Plug-in!
#
# Copyright (C) 2001 Tony Bibbs
# tony@tonybibbs.com
#
# German tranlation by Dirk Haun <dirk@haun-online.de>
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
    newpage => "Neue Seite",
    adminhome => "Admin Home",
    staticpages => "Statische Seiten",
    staticpageeditor => "Editor für Statische Seiten",
    writtenby => "Autor",
    date => "Letztes Update",
    title => "Titel",
    content => "Inhalt",
    hits => "Treffer",
    staticpagelist => "Liste der Statischen Seiten",
    usealtheader => "Alt. Header verwenden",
    url => "URL",
    edit => "Ändern",
    lastupdated => "Letztes Update",
    pageformat => "Seitenformat",
    leftrightblocks => "Blöcke links &amp; rechts",
    blankpage => "Leere Seite",
    noblocks => "Keine Blöcke",
    leftblocks => "Blöcke links",
    addtomenu => 'Ins Menü aufnehmen',
    label => 'Label',
    nopages => 'Es sind keine statischen Seiten vorhanden.',
    save => 'Speichern',
    preview => 'Vorschau',
    delete => 'Löschen',
    cancel => 'Abbruch',
    access_denied => 'Zugriff verweigert',
    access_denied_msg => 'Du hast unerlaubter Weise versucht, auf eine der Admin-Seiten für Statische Seiten zuzugreifen. Hinweis: Alle derartigen Versuche werden protokolliert',
    all_html_allowed => 'Alle HTML-Tags sind erlaubt',
    results => 'Gefundene Statische Seiten',
    author => 'Autor',
    no_title_or_content => 'Bitte mindestens die Felder <b>Titel</b> und <b>Inhalt</b> ausfüllen.',
    no_such_page_logged_in => 'Sorry, ' . $_USER['username'] . ' ...',
    no_such_page_anon => 'Bitte einloggen.',
    no_page_access_msg => "This could be because you're not logged in, or not a member of {$_CONF["site_name"]}. Please <a href=\"{$_CONF['site_url']}/users.php?mode=new\"> become a member</a> of {$_CONF["site_name"]} to receive full membership access.",
    php_msg => 'PHP: ',
    php_warn => 'Hinweis: Wenn dieser Schalter aktiviert ist, wird in der Seite enthaltener PHP-Code ausgeführt. <em>Bitte mit Bedacht verwenden!</em>',
    exit_msg => 'Hinweistext: ',
    exit_info => 'Art des Hinweistextes, wenn kein Zugriff auf die Seite erlaubt ist: Aktiviert = "Anmeldung erforderlich", nicht aktiviert = "Zugriff verweigert".',
    deny_msg => 'Zugriff auf diese Seite ist nicht möglich. Die Seite wurde entweder umbenannt oder gelöscht oder Du hast nicht die nötigen Zugriffsrechte.',
    stats_headline => 'Top Ten der Statischen Seiten',
    stats_page_title => 'Titel',
    stats_hits => 'Angezeigt',
    stats_no_hits => 'Es gibt keine Statischen Seiten oder sie wurden von niemandem gelesen.',
    id => 'ID',
    duplicate_id => 'Diese ID wird bereits für eine andere Statische Seite benutzt. Bitte wähle eine andere ID.',
    instructions => 'Auf die Nummer klicken, um eine Statische Seite zu ändern oder zu löschen. Um eine Statische Seite anzusehen, auf deren Titel klicken. Auf Neue Seite (s.o.) klicken, um einen neue Statische Seite anzulegen. Auf das [C] klicken, um eine Kopie einer vorhandenen Seite zu erhalten.'
);

?>
