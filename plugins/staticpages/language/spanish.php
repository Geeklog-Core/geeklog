<?php

###############################################################################
# lang.php
# This is the spanish language page for the Geeklog Static Page Plug-in!
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
    newpage => "Nueva P�gina",
    adminhome => "Administraci�n",
    staticpages => "P�ginas Est�ticas",
    staticpageeditor => "Editor de p�ginas est�ticas",
    writtenby => "Escrito por",
    date => "�ltima edici�n",
    title => "T�tulo",
    content => "Contenido",
    hits => "Hits",
    staticpagelist => "Lista de P�ginas Est�ticas",
    usealtheader => "Usar cabecera alternativa",
    url => "URL",
    edit => "Editar",
    lastupdated => "�ltima Edici�n",
    pageformat => "Formato de P�gina",
    leftrightblocks => "Cajas a Derecha e Izquierda",
    blankpage => "P�gina en blanco",
    noblocks => "Sin Cajas",
    leftblocks => "Cajas a Izquierda",
    addtomenu => 'A�adir al men�',
    label => 'Etiqueta',
    nopages => 'Todav�a no hay p�ginas est�ticas',
    save => 'guardar',
    preview => 'vista previa',
    delete => 'eliminar',
    cancel => 'cancelar',
    access_denied => 'Acceso Denegado',
    access_denied_msg => 'Est�s intentando acceder a una p�gina de administraci�n de P�ginas Est�ticas. Ten en cuenta que cualquier acceso a esta p�gina se registra',
    all_html_allowed => 'Se permite cualquier etiqueta HTML',
    results => 'Resultado de P�ginas Est�ticas',
    author => 'Autor',
    no_title_or_content => 'You must at least fill in the <b>Title</b> and <b>Content</b> fields.',
    no_such_page_logged_in => 'Sorry '.$_USER['username'].'..',
    no_such_page_anon => 'Please log in..',
    no_page_access_msg => "This could be because you're not logged in, or not a member of {$_CONF["site_name"]}. Please <a href=\"{$_CONF['site_url']}/users.php?mode=new\"> become a member</a> of {$_CONF["site_name"]} to receive full membership access",
    php_msg => 'PHP: ',
    php_warn => 'Warning: PHP code in your page will be evaluated if you enable this option. Use with caution !!',
    exit_msg => 'Exit Type: ',
    exit_info => 'Enable for Login Required Message.  Leave unchecked for normal security check and message.',    
    deny_msg => 'Access to this page is denied.  Either the page has been moved/removed or you do not have sufficient permissions.',
    stats_headline => 'Top Ten Static Pages',
    stats_page_title => 'Page Title',
    stats_hits => 'Hits',
    stats_no_hits => 'It appears that there are no static pages on this site or no one has ever viewed them.',
    id => 'ID',
    duplicate_id => 'The ID you chose for this static page is already in use. Please select another ID.',
    instructions => "To modify or delete a static page, click on that page's number below. To view a static page, click on the title of the page you wish to view. To create a new static page click on new page above. Click on [C] to create a copy of an existing page."
);

?>
