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
# $Id: polish_utf-8.php,v 1.1 2008/04/26 20:35:26 dhaun Exp $

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
 * @author Trinity Bays <trinity93@gmail.com>
 * @author Tony Bibbs <tony@tonybibbs.com>
 * @author Tom Willett <twillett@users.sourceforge.net>
 * @author Blaine Lang <langmail@sympatico.ca>
 * @author Dirk Haun <dirk@haun-online.de>
 * 
 */

global $LANG32;

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
$LANG_LINKS = array(
    10 => 'Przesłane Linki',
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
    'links' => 'Liczba Linków (Kliknięć) w Serwisie',
    'stats_headline' => '10 Najpopularniejszych Linków',
    'stats_page_title' => 'Linki',
    'stats_hits' => 'Odsłon',
    'stats_no_hits' => 'Wygląda na to, że nie ma żadnych linków albo nikt jeszcze nie kliknął na żaden link.',
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
 'title' => 'Tytuł',
 'date' => 'Dodano',
 'author' => 'Przesłany przez',
 'hits' => 'Kliknięć'
);
###############################################################################
# for the submission form
/**
* the link plugin's lang submit form array
* 
* @global array $LANG_LINKS_SUBMIT 
*/
$LANG_LINKS_SUBMIT = array(
    1 => 'Prześlij Link',
    2 => 'Link',
    3 => 'Kategoria',
    4 => 'Inne',
    5 => 'Jeśli Inne, proszę sprecyzować jaka',
    6 => 'Błą: Brak Kategorii',
    7 => 'Podczas wyboru "Inne" proszę podać nazwę kategorii',
    8 => 'Tytuł',
    9 => 'URL',
    10 => 'Kategoria',
    11 => 'Prześlij Link'
);

###############################################################################
# Messages for COM_showMessage the submission form

$PLG_links_MESSAGE1 = "Dziękuję za przesłanie linka.  Po zatwierdzeniu link pojawi się w sekcji <a href={$_CONF['site_url']}/links/index.php>linki</a>.";
$PLG_links_MESSAGE2 = 'Link został zapisany.';
$PLG_links_MESSAGE3 = 'Link został wykasowany.';
$PLG_links_MESSAGE4 = "Dziękuję za przesłanie linka.  Link jest dostępny w sekcji <a href={$_CONF['site_url']}/links/index.php>linki</a>.";

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
    3 => 'Tytuł Linka',
    4 => 'URL Link',
    5 => 'Kategoria',
    6 => '(włącznie z http://)',
    7 => 'Inne',
    8 => 'Odsłon',
    9 => 'Opis Linka',
    10 => 'Musisz podać Tytuł, URL, i Opis.',
    11 => 'Menadżer Linków',
    12 => 'Aby zmodyfikować lub wykasować link, kliknij na ikonę edycji poniżej.  Aby stworzyć nowy link, kliknij na "Nowy Link" powyżej.',
    14 => 'Kategoria Linka',
    16 => 'Odmowa Dostępu',
    17 => "Nie masz uprawnień do tego linka.  Twoja próba wejścia została zarejestrowana w logu. Proszę <a href=\"{$_CONF['site_admin_url']}/plugins/links/index.php\">do ekranu zarządzania linkami</a>.",
    20 => 'Jeśli inna, podaj jaka',
    21 => 'zapisz',
    22 => 'anuluj',
    23 => 'kasuj'
);

?>
