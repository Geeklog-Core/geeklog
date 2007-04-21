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
# $Id: czech.php,v 1.1 2007/04/21 19:30:32 dhaun Exp $

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
# $LANGXX[YY]:	$LANG - variable name
#		  	XX - file id number
#			YY - phrase id number
###############################################################################
/**
* the link plugin's lang array
* 
* @global array $LANG_LINKS 
*/
$LANG_LINKS= array(
    10 => 'Po�adavky',
    14 => 'Odkazy',
    84 => 'ODKAZY',
    88 => '��dn� nov� odkazy',
    114 => 'Odkazy',
    116 => 'P�idat odkaz'
);

###############################################################################
# for stats
/**
* the link plugin's lang stats array
* 
* @global array $LANG_LINKS_STATS
*/
$LANG_LINKS_STATS = array(
    'links' => 'Odkazy (Kliknut�) v syst�mu',
    'stats_headline' => 'Top Ten odkaz�',
    'stats_page_title' => 'Odkazy',
    'stats_hits' => 'Pou�ito',
    'stats_no_hits' => 'Vypad� to, �e nejsou ��dn� odkazy nebo odkaz nikdo je�t� nepou�il.',
);

###############################################################################
# for the search
/**
* the link plugin's lang search array
* 
* @global array $LANG_LINKS_SEARCH 
*/
$LANG_LINKS_SEARCH = array(
 'results' => 'V�sledky - odkazy',
 'title' => 'Titulek',
 'date' => 'Datum p�id�n�',
 'author' => 'P�idal ',
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
    4 => 'Jin�',
    5 => 'Pokud jin�, tak specifikuj',
    6 => 'Chyba: chyb� kategorie',
    7 => 'Pokud vybere� "Jin�", dopi� jm�no kategorie',
    8 => 'Titulek',
    9 => 'URL',
    10 => 'Kategorie',
    11 => 'Po�adavky odkaz�'
);

###############################################################################
# Messages for COM_showMessage the submission form

$PLG_links_MESSAGE1 = "D�kujeme za odesl�n� odkazu na {$_CONF['site_name']}.  Nyn� o�ek�v� odsouhlasen�.  Po odouhlasen� bude V� odkaz v sekci <a href={$_CONF['site_url']}/links/index.php>odkaz�</a>.";
$PLG_links_MESSAGE2 = 'V� odkaz byl �sp�n� p�id�n.';
$PLG_links_MESSAGE3 = 'Odkaz byl �sp�n� vymaz�n.';
$PLG_links_MESSAGE4 = "D�kujeme za odesl�n� odkazu {$_CONF['site_name']}.  M��ete ho nal�zt v <a href={$_CONF['site_url']}/links/index.php>odkazech</a>.";

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
    1 => 'Editor odkaz�',
    2 => 'ID odkazu',
    3 => 'Titulek odkazu',
    4 => 'URL odkazu',
    5 => 'Kategorie',
    6 => '(v�etn� http://)',
    7 => 'Jin�',
    8 => 'Pou�it� odkazu',
    9 => 'Popis odkazu',
    10 => 'Mus�te zadat titulek, URL a popis.',
    11 => 'Spr�vce odkaz�',
    12 => 'Pro zm�nu nebo vymaz�n� odkazu, klikn�te na ikonu editace.  Pro vytvo�en� nov�ho odkazu, klikn�te na "Create New".',
    14 => 'Kategorie odkazu',
    16 => 'P��stup byl zak�z�n',
    17 => "Pokoou��te se pou��t odkaz, na kter� nem�te dostate�n� pr�va. V� pokus byl zalogov�n. Pros�m, <a href=\"{$_CONF['site_admin_url']}/plugins/links/index.php\">na str�nku pro administraci</a>.",
    20 => 'Pokud jin�, specifikuj',
    21 => 'ulo�it',
    22 => 'storno',
    23 => 'vymazat'
);

?>
