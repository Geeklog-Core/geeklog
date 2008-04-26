<?php

###############################################################################
# spanish_utf-8.php
# This is the spanish language file for the Geeklog Links Plugin
#
# Copyright (C) 2007 JoséR. Valverde
# jrvalverde AT cnb DOT uam DOT es
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
# $Id: spanish.php,v 1.1 2008/04/26 20:35:26 dhaun Exp $

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
    10 => 'Envíos',
    14 => 'Enlaces',
    84 => 'ENLACES',
    88 => 'No hay enlaces recientes',
    114 => 'Enlaces',
    116 => 'Añadir un enlace'
);

###############################################################################
# for stats
/**
* the link plugin's lang stats array
* 
* @global array $LANG_LINKS_STATS
*/
$LANG_LINKS_STATS = array(
    'links' => 'Enlaces (Clicks) en el Sistema',
    'stats_headline' => '10 enlaces mejores',
    'stats_page_title' => 'Enlaces',
    'stats_hits' => 'Hits',
    'stats_no_hits' => 'Parece que no hay enlaces o nadie ha visitado uno antes.',
);

###############################################################################
# for the search
/**
* the link plugin's lang search array
* 
* @global array $LANG_LINKS_SEARCH 
*/
$LANG_LINKS_SEARCH = array(
 'results' => 'Resultados de enlaces',
 'title' => 'Título',
 'date' => 'Fecha de adición',
 'author' => 'Enviado por',
 'hits' => 'Clicks'
);

###############################################################################
# for the submission form
/**
* the link plugin's lang submit form array
* 
* @global array $LANG_LINKS_SUBMIT 
*/
$LANG_LINKS_SUBMIT = array(
    1 => 'Enviar enlace',
    2 => 'Enlace',
    3 => 'Categoría',
    4 => 'Otra',
    5 => 'Si otra, por favor especifique',
    6 => 'Error: Categoría inexistente',
    7 => 'Al elegir "Otra" proporcione también un nombre de categoría, por favor',
    8 => 'Título',
    9 => 'URL',
    10 => 'Categoría',
    11 => 'Enlaces enviados'
);

###############################################################################
# Messages for COM_showMessage the submission form

$PLG_links_MESSAGE1 = "Gracias por enviar un enlace a {$_CONF['site_name']}.  Lo hemos reenviado a nuestros administradores paara que lo aprueben. Si es aprobado apareceerá en la sección de <a href={$_CONF['site_url']}/links/index.php>enlaces</a>.";
$PLG_links_MESSAGE2 = 'Tu enlace se ha guardado satisfactoriamente.';
$PLG_links_MESSAGE3 = 'El enlace ha sido borrado satisfactoriamente.';
$PLG_links_MESSAGE4 = "Grac ias por enviar un enlace a {$_CONF['site_name']}.  Puedes verlo en la sección de <a href={$_CONF['site_url']}/links/index.php>enlaces</a>.";

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
    1 => 'Editor de enlaces',
    2 => 'ID del enlace',
    3 => 'Título del enlace',
    4 => 'URL del enlace',
    5 => 'Categoría',
    6 => '(incluir http://)',
    7 => 'Otra',
    8 => 'Visitas',
    9 => 'Descripción del enlace',
    10 => 'Necesita proporcionar un título, URL y descripción para el enlace.',
    11 => 'Gestor de enlaces',
    12 => 'Para modificar o borrar un enlace, pulse en el botón de edición. Para crear un enlace nuevo pulse en "Crear nuevo".',
    14 => 'Categoría del enlace',
    16 => 'Acceso denegado',
    17 => "Estás intentando acceder a un enlace al que no tienes derecho. Este intento ha sido anotado. Por favor, <a href=\"{$_CONF['site_admin_url']}/plugins/links/index.php\">vuelve a la pantalla de administración de enlaces</a>.",
    20 => 'Si Otra, especificar',
    21 => 'guardar',
    22 => 'cancelar',
    23 => 'borrar'
);

?>
