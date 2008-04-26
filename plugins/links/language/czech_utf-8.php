<?php

###############################################################################
# czech.php
# This is the czech (ISO 8859-2) language file for the Geeklog Links Plugin
#
# Copyright (C) 2007 Ondrej Rusek
# rusek@gybon.cz
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
# $Id: czech_utf-8.php,v 1.1 2008/04/26 20:35:26 dhaun Exp $

/** 
 * This is the english language page for the Geeklog links Plug-in! 
 * 
 * @package Links
 * @subpackage Language
 * @filesource
 * @version 1.0
 * @since GL 1.4.0
 * @copyright Copyright &copy; 2005-2006
 * @license http://opensource.org/licenses/gpl-license.php GNU Public License 
 * @author Trinity Bays <trinity93 AT gmail DOT com>
 * @author Tony Bibbs <tony AT tonybibbs DOT com>
 * @author Tom Willett <twillett AT users DOT sourceforge DOT net>
 * 
 */

global $LANG32;

###############################################################################
# Array Format:
# $LANGXX[YY]:	$LANG - variable name
#		  	XX - file id number
#			YY - phrase id number
###############################################################################

/**
* the link plugin's lang array
* 
* @global array $LANG_LINKS 
*/
$LANG_LINKS = array(
    10 => 'Požadavky',
    14 => 'Odkazy',
    84 => 'ODKAZY',
    88 => 'Žádné nové odkazy',
    114 => 'Odkazy',
    116 => 'Přidat odkaz'
);

###############################################################################
# for stats
/**
* the link plugin's lang stats array
* 
* @global array $LANG_LINKS_STATS
*/
$LANG_LINKS_STATS = array(
    'links' => 'Odkazy (Kliknutí) v systému',
    'stats_headline' => 'Top Ten odkazů',
    'stats_page_title' => 'Odkazy',
    'stats_hits' => 'Použito',
    'stats_no_hits' => 'Vypadá to, že nejsou žádné odkazy nebo odkaz nikdo ještě nepoužil.',
);

###############################################################################
# for the search
/**
* the link plugin's lang search array
* 
* @global array $LANG_LINKS_SEARCH 
*/
$LANG_LINKS_SEARCH = array(
 'results' => 'Výsledky - odkazy',
 'title' => 'Titulek',
 'date' => 'Datum přidání',
 'author' => 'Přidal ',
 'hits' => 'Kliknuto'
);

###############################################################################
# for the submission form
/**
* the link plugin's lang submit form array
* 
* @global array $LANG_LINKS_SUBMIT 
*/
$LANG_LINKS_SUBMIT = array(
    1 => 'Poslat odkaz',
    2 => 'Odkaz',
    3 => 'Kategorie',
    4 => 'Jiná',
    5 => 'Pokud jiná, tak specifikuj',
    6 => 'Chyba: chybí kategorie',
    7 => 'Pokud vybereš "Jiná", dopiš jméno kategorie',
    8 => 'Titulek',
    9 => 'URL',
    10 => 'Kategorie',
    11 => 'Požadavky odkazů'
);

###############################################################################
# Messages for COM_showMessage the submission form

$PLG_links_MESSAGE1 = "Děkujeme za odeslání odkazu na {$_CONF['site_name']}.  Nyní očekává odsouhlasení.  Po odouhlasení bude Váš odkaz v sekci <a href={$_CONF['site_url']}/links/index.php>odkazů</a>.";
$PLG_links_MESSAGE2 = 'Váš odkaz byl úspěšně přidán.';
$PLG_links_MESSAGE3 = 'Odkaz byl úspěšně vymazán.';
$PLG_links_MESSAGE4 = "Děkujeme za odeslání odkazu {$_CONF['site_name']}.  Můžete ho nalézt v <a href={$_CONF['site_url']}/links/index.php>odkazech</a>.";

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
    1 => 'Editor odkazů',
    2 => 'ID odkazu',
    3 => 'Titulek odkazu',
    4 => 'URL odkazu',
    5 => 'Kategorie',
    6 => '(včetně http://)',
    7 => 'Jiná',
    8 => 'Použití odkazu',
    9 => 'Popis odkazu',
    10 => 'Musíte zadat titulek, URL a popis.',
    11 => 'Správce odkazů',
    12 => 'Pro změnu nebo vymazání odkazu, klikněte na ikonu editace.  Pro vytvoření nového odkazu, klikněte na "Create New".',
    14 => 'Kategorie odkazu',
    16 => 'Přístup byl zakázán',
    17 => "Pokooušíte se použít odkaz, na který nemáte dostatečná práva. Váš pokus byl zalogován. Prosím, <a href=\"{$_CONF['site_admin_url']}/plugins/links/index.php\">na stránku pro administraci</a>.",
    20 => 'Pokud jiná, specifikuj',
    21 => 'uložit',
    22 => 'storno',
    23 => 'vymazat'
);

?>
