<?php

###############################################################################
# slovenian.php - version 1.4.1
# This is the slovenian language file for the Geeklog Links Plugin
# language file for geeklog version 1.4.1 beta by mb
# gape@gape.org ; za pripombe, predloge ipd ... piši na email
#
# Copyright (C) 2001 Tony Bibbs
# tony AT tonybibbs DOT com
# Copyright (C) 2005 Trinity Bays
# trinity93 AT gmail DOT com
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
# $Id: slovenian.php,v 1.3 2008/03/17 21:12:54 dhaun Exp $

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
 * @author Trinity Bays <trinity93 AT steubentech DOT com>
 * @author Tony Bibbs <tony AT tonybibbs DOT com>
 * @author Tom Willett <twillett AT users DOT sourceforge DOT net>
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
    10 => 'Èakajoèa vsebina',
    14 => 'Povezave',
    84 => 'POVEZAVE',
    88 => 'Ni nedavnih novih povezav',
    114 => 'Povezave',
    116 => 'Dodaj povezavo'
);

###############################################################################
# for stats
/**
* the link plugin's lang stats array
* 
* @global array $LANG_LINKS_STATS
*/
$LANG_LINKS_STATS = array(
    'links' => 'Links (Clicks) in the System',
    'stats_headline' => 'Top Ten Links',
    'stats_page_title' => 'Links',
    'stats_hits' => 'Hits',
    'stats_no_hits' => 'Izgleda, da na tem mestu ni povezav ali pa še nikoli ni nihèe kliknil na nobeno.',
);

###############################################################################
# for the search
/**
* the link plugin's lang search array
* 
* @global array $LANG_LINKS_SEARCH 
*/
$LANG_LINKS_SEARCH = array(
 'results' => 'Rezultati povezav',
 'title' => 'Naslov',
 'date' => 'Dodani datum',
 'author' => 'Odposlal:',
 'hits' => 'Kliki'
);

###############################################################################
# for the submission form
/**
* the link plugin's lang submit form array
* 
* @global array $LANG_LINKS_SUBMIT 
*/
$LANG_LINKS_SUBMIT = array(
    1 => 'Oddaj povezavo',
    2 => 'Povezava',
    3 => 'Kategorija',
    4 => 'Drugo',
    5 => 'Èe drugo, prosim navedi',
    6 => 'Napaka: Manjka kategorija',
    7 => 'Kadar izbereš "Drugo", prosim navedi tudi ime kategorije',
    8 => 'Naslov',
    9 => 'URL',
    10 => 'Kategorija',
    11 => 'Povezave'
);

###############################################################################
# Messages for COM_showMessage the submission form

$PLG_links_MESSAGE1 = "Hvala, da si povezavo oddal/a na spletno mesto {$_CONF['site_name']}. Pred objavo ga bo pregledal eden od urednikov. Èe bo odobren, bo objavljen in dan na razpolago bralcem te spletne strani v razdelku <a href={$_CONF['site_url']}/links/index.php>povezave</a>.";
$PLG_links_MESSAGE2 = 'Tvoja povezava je uspešno shranjena.';
$PLG_links_MESSAGE3 = 'Povezava je uspešno izbrisana.';
$PLG_links_MESSAGE4 = "Hvala, da si povezavo oddal/a na spletno mesto {$_CONF['site_name']}.  Sedaj jo lahko vidiš v razdelku <a href={$_CONF['site_url']}/links/index.php>povezave</a>.";

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
    1 => 'Urejevalnik povezav',
    2 => 'ID povezave',
    3 => 'Naslov povezave',
    4 => 'URL povezave',
    5 => 'Kategorija',
    6 => '(vkljuèi http://)',
    7 => 'Drugo',
    8 => 'Zadetki povezav',
    9 => 'Opis povezav',
    10 => 'Doloèiti moraš  naslov povezave, URL in opis.',
    11 => 'Upravljalnik povezav',
    12 => 'Za spreminjanje ali izbris povezave klikni na njeno ikono za urejanje spodaj.  Za ustvarjenje nove povezave klikni na "Ustvari novo" zgoraj.',
    14 => 'kategorija povezave',
    16 => 'Dostop zavrnjen',
    17 => "Poskušaš dostopiti do povezave, za katero nimaš pravic. Ta poskus je bil zabeležen. Prosim <a href=\"{$_CONF['site_admin_url']}/plugins/links/index.php\">pojdi nazaj na zaslon za upravljanje povezav</a>.",
    20 => 'Èe drugo, navedi',
    21 => 'shrani',
    22 => 'preklièi',
    23 => 'izbriši'
);

?>
