<?php

###############################################################################
# polish.php
#
# This is the Polish language file for the Geeklog Links plugin
#
# Copyright (C) 2006 Robert Stadnik
# geeklog_pl AT geeklog DOT now DOT pl
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
# $Id: polish.php,v 1.4 2008/03/17 21:12:54 dhaun Exp $

/** 
 * This is the english language page for the Geeklog links Plug-in! 
 * 
 * @package Links
 * @subpackage Language
 * @filesource
 * @version 1.0
 * @since GL 1.4.0
 * @copyright Copyright &copy; 2005
 * @license http://opensource.org/licenses/gpl-license.php GNU Public License 
 * @author Trinity Bays <trinity93@steubentech.com>
 * @author Tony Bibbs <tony@tonybibbs.com>
 * @author Tom Willett <twillett@users.sourceforge.net>
 * @author Blaine Lang <langmail@sympatico.ca>
 * @author Dirk Haun <dirk@haun-online.de>
 * 
 */


###############################################################################
# Array Format:
# $LANGXX[YY]:    $LANG - variable name
#              XX - file id number
#            YY - phrase id number
###############################################################################
/**
* the link plugin's lang array
* 
* @global array $LANG_LINKS 
*/
$LANG_LINKS= array(
    10 => 'Przes³ane Linki',
    14 => 'Linki',
    84 => 'LINKI',
    88 => 'Brak nowych linków',
    114 => 'Linki',
    116 => 'Dodaj Link'
);

###############################################################################
# for stats
/**
* the link plugin's lang stats array
* 
* @global array $LANG_LINKS_STATS
*/
$LANG_LINKS_STATS = array(
    'links' => 'Liczba Linków (Klikniêæ) w Serwisie',
    'stats_headline' => '10 Najpopularniejszych Linków',
    'stats_page_title' => 'Linki',
    'stats_hits' => 'Ods³on',
    'stats_no_hits' => 'Wygl±da na to, ¿e nie ma ¿adnych linków albo nikt jeszcze nie klikn±³ na ¿aden link.',
);

###############################################################################
# for the search
/**
* the link plugin's lang search array
* 
* @global array $LANG_LINKS_SEARCH 
*/
$LANG_LINKS_SEARCH = array(
 'results' => 'Linki - Wyniki',
 'title' => 'Tytu³',
 'date' => 'Dodano',
 'author' => 'Przes³any przez',
 'hits' => 'Klikniêæ'
);
###############################################################################
# for the submission form
/**
* the link plugin's lang submit form array
* 
* @global array $LANG_LINKS_SUBMIT 
*/
$LANG_LINKS_SUBMIT = array(
    1 => 'Prze¶lij Link',
    2 => 'Link',
    3 => 'Kategoria',
    4 => 'Inne',
    5 => 'Je¶li Inne, proszê sprecyzowaæ jaka',
    6 => 'B³±: Brak Kategorii',
    7 => 'Podczas wyboru "Inne" proszê podaæ nazwê kategorii',
    8 => 'Tytu³',
    9 => 'URL',
    10 => 'Kategoria',
    11 => 'Prze¶lij Link'
);

###############################################################################
# Messages for COM_showMessage the submission form

$PLG_links_MESSAGE1 = "Dziêkujê za przes³anie linka.  Po zatwierdzeniu link pojawi siê w sekcji <a href={$_CONF['site_url']}/links/index.php>linki</a>.";
$PLG_links_MESSAGE2 = 'Link zosta³ zapisany.';
$PLG_links_MESSAGE3 = 'Link zosta³ wykasowany.';
$PLG_links_MESSAGE4 = "Dziêkujê za przes³anie linka.  Link jest dostêpny w sekcji <a href={$_CONF['site_url']}/links/index.php>linki</a>.";

// Messages for the plugin upgrade
$PLG_links_MESSAGE3001 = 'Plugin upgrade not supported.';
$PLG_links_MESSAGE3002 = $LANG32[9];

###############################################################################
# admin/link.php
/**
* the link plugin's lang admin array
* 
* @global array $LANG_LINKS_ADMIN 
*/
$LANG_LINKS_ADMIN = array(
    1 => 'Edytor Linków',
    2 => 'ID Linka',
    3 => 'Tytu³ Linka',
    4 => 'URL Link',
    5 => 'Kategoria',
    6 => '(w³±cznie z http://)',
    7 => 'Inne',
    8 => 'Ods³on',
    9 => 'Opis Linka',
    10 => 'Musisz podaæ Tytu³, URL, i Opis.',
    11 => 'Menad¿er Linków',
    12 => 'Aby zmodyfikowaæ lub wykasowaæ link, kliknij na ikonê edycji poni¿ej.  Aby stworzyæ nowy link, kliknij na "Nowy Link" powy¿ej.',
    14 => 'Kategoria Linka',
    16 => 'Odmowa Dostêpu',
    17 => "Nie masz uprawnieñ do tego linka.  Twoja próba wej¶cia zosta³a zarejestrowana w logu. Proszê <a href=\"{$_CONF['site_admin_url']}/plugins/links/index.php\">do ekranu zarz±dzania linkami</a>.",
    20 => 'Je¶li inna, podaj jaka',
    21 => 'zapisz',
    22 => 'anuluj',
    23 => 'kasuj'
);

?>
