<?php

###############################################################################
# estonian.php
# This is the estonian language page for the Geeklog links Plug-in
#
# Copyright (C) 2001 Tony Bibbs
# tony@tonybibbs.com
# Copyright (C) 2005 Trinity Bays
# trinity93@gmail.com
#
# Estonian translation by Artur R‰pp <rtr AT planet DOT ee>
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
# $Id: estonian.php,v 1.2 2007/08/28 07:33:30 ospiess Exp $

/** 
 * This is the estonian language page for the Geeklog links Plug-in! 
 * 
 * @package Links
 * @subpackage Language
 * @filesource
 * @version 1.0
 * @since GL 1.4.0
 * @copyright Copyright &copy; 2005-2006
 * @license http://opensource.org/licenses/gpl-license.php GNU Public License 
 * @author Trinity Bays <trinity93@steubentech.com>
 * @author Tony Bibbs <tony@tonybibbs.com>
 * @author Tom Willett <twillett@users.sourceforge.net>
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
    10 => 'Sisestatud',
    14 => 'Linke',
    84 => 'LINKE',
    88 => 'Pole uusi linke',
    114 => 'Linke',
    116 => 'Lisa link'
);

###############################################################################
# for stats
/**
* the link plugin's lang stats array
* 
* @global array $LANG_LINKS_STATS
*/
$LANG_LINKS_STATS = array(
    'links' => 'Linke (klikke) lehtedel',
    'stats_headline' => 'Top 10 linki',
    'stats_page_title' => 'Lingid',
    'stats_hits' => 'Klikke',
    'stats_no_hits' => 'N‰ib, et lehel pole linke vıi keegi pole neil klıpsanud.',
);

###############################################################################
# for the search
/**
* the link plugin's lang search array
* 
* @global array $LANG_LINKS_SEARCH 
*/
$LANG_LINKS_SEARCH = array(
 'results' => 'Linkide tulemus',
 'title' => 'Tiitel',
 'date' => 'Lisamisaeg',
 'author' => 'Lisaja',
 'hits' => 'Klikke'
);

###############################################################################
# for the submission form
/**
* the link plugin's lang submit form array
* 
* @global array $LANG_LINKS_SUBMIT 
*/
$LANG_LINKS_SUBMIT = array(
    1 => 'Saada link',
    2 => 'Link',
    3 => 'Kategooria',
    4 => 'Muu',
    5 => 'Kui muu, siis m‰‰ratle',
    6 => 'Viga: puudub kategooria',
    7 => 'Kui valid "Muu", m‰‰ratle ka kategooria nimi',
    8 => 'Tiitel',
    9 => 'URL',
    10 => 'Kategooria',
    11 => 'Sisestatud lingid'
);

###############################################################################
# Messages for COM_showMessage the submission form

$PLG_links_MESSAGE1 = "T‰name sind {$_CONF['site_name']} lehele lingi sisestamise eest. See on saadetud meie meeskonnale kinnitamiseks. Kui meeskond kinnitab selle lingi, ilmub see <a href=\"{$_CONF['site_url']}/links/\">Linkide osas.</a>";
$PLG_links_MESSAGE2 = 'Sinu link on edukalt salvestatud.';
$PLG_links_MESSAGE3 = 'Link on edukalt kustutatud';
$PLG_links_MESSAGE4 = "T‰name sind {$_CONF['site_name']}  lehele lingi lisamise eest. Sa vıid seda linki juba n‰ha <a href=\"{$_CONF['site_url']}/links/\">linkide osas.</a>";

// Messages for the plugin upgrade
$PLG_links_MESSAGE3002 = $LANG32[9];

###############################################################################
# admin/link.php
/**
* the link plugin's lang admin array
* 
* @global array $LANG_LINKS_ADMIN 
*/
$LANG_LINKS_ADMIN = array(
    1 => 'Lingi toimetaja',
    2 => 'Lingi ID',
    3 => 'Lingi tiitel',
    4 => 'Lingi URL',
    5 => 'Kategooria',
    6 => '(koos http://)',
    7 => 'Muu',
    8 => 'Klikke lingil',
    9 => 'Lingi kirjeldus',
    10 => 'Sa pead m‰‰rama lingi URL-i, tiitli ja kirjelduse.',
    11 => 'Lingi haldur',
    12 => 'Lingi toimetamiseks vıi kustutamiseks klıpsa allpool vastava lingi juures oleval toimetamisikoonil. Uue lingi loomiseks klıpsa "Tee uus" ¸lal.',
    14 => 'Lingi kategooria',
    16 => 'Ligip‰‰s tıkestatud',
    17 => "Sa proovisid ligi p‰‰seda lingile, milleks pole sul ıigust. See katse on logitud. Palun <a href=\"{$_CONF['site_admin_url']}/plugins/links/\"> mine tagasi linkide administreerimislehele.</a>",
    20 => 'Kui muu, siis m‰‰ratle',
    21 => 'salvesta',
    22 => 't¸hista',
    23 => 'kustuta'
);

?>
