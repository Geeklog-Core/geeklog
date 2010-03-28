<?php

###############################################################################
# spanish.php
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

global $LANG32;

###############################################################################
# Array Format:
# $LANGXX[YY]:  $LANG - variable name
#               XX    - file id number
#               YY    - phrase id number
###############################################################################

$LANG_STATIC = array(
    'newpage' => 'Nueva Página',
    'adminhome' => 'Administración',
    'staticpages' => 'Páginas Estáticas',
    'staticpageeditor' => 'Editor de páginas estáticas',
    'writtenby' => 'Escrito por',
    'date' => 'Última edición',
    'title' => 'Título',
    'page_title' => 'Page Title',
    'content' => 'Contenido',
    'hits' => 'Hits',
    'staticpagelist' => 'Lista de Páginas Estáticas',
    'url' => 'URL',
    'edit' => 'Editar',
    'lastupdated' => 'Última Edición',
    'pageformat' => 'Formato de Página',
    'leftrightblocks' => 'Cajas a Derecha e Izquierda',
    'blankpage' => 'Página en blanco',
    'noblocks' => 'Sin Cajas',
    'leftblocks' => 'Cajas a Izquierda',
    'addtomenu' => 'Añadir al menú',
    'label' => 'Etiqueta',
    'nopages' => 'Todavía no hay páginas estáticas',
    'save' => 'guardar',
    'preview' => 'vista previa',
    'delete' => 'eliminar',
    'cancel' => 'cancelar',
    'access_denied' => 'Acceso Denegado',
    'access_denied_msg' => 'Estás intentando acceder a una página de administración de Páginas Estáticas. Ten en cuenta que cualquier acceso a esta página se registra',
    'all_html_allowed' => 'Se permite cualquier etiqueta HTML',
    'results' => 'Resultado de Páginas Estáticas',
    'author' => 'Autor',
    'no_title_or_content' => 'You must at least fill in the <b>Title</b> and <b>Content</b> fields.',
    'no_such_page_anon' => 'Please log in..',
    'no_page_access_msg' => "This could be because you're not logged in, or not a member of {$_CONF['site_name']}. Please <a href=\"{$_CONF['site_url']}/users.php?mode=new\"> become a member</a> of {$_CONF['site_name']} to receive full membership access",
    'php_msg' => 'PHP: ',
    'php_warn' => 'Warning: PHP code in your page will be evaluated if you enable this option. Use with caution !!',
    'exit_msg' => 'Exit Type: ',
    'exit_info' => 'Enable for Login Required Message.  Leave unchecked for normal security check and message.',
    'deny_msg' => 'Access to this page is denied.  Either the page has been moved/removed or you do not have sufficient permissions.',
    'stats_headline' => 'Top Ten Static Pages',
    'stats_page_title' => 'Page Title',
    'stats_hits' => 'Hits',
    'stats_no_hits' => 'It appears that there are no static pages on this site or no one has ever viewed them.',
    'id' => 'ID',
    'duplicate_id' => 'The ID you chose for this static page is already in use. Please select another ID.',
    'instructions' => 'To modify or delete a static page, click on that page\'s number below. To view a static page, click on the title of the page you wish to view. To create a new static page click on new page above. Click on [C] to create a copy of an existing page.',
    'centerblock' => 'Centerblock: ',
    'centerblock_msg' => 'When checked, this Static Page will be displayed as a center block on the index page.',
    'topic' => 'Topic: ',
    'position' => 'Position: ',
    'all_topics' => 'All',
    'no_topic' => 'Homepage Only',
    'position_top' => 'Top Of Page',
    'position_feat' => 'After Featured Story',
    'position_bottom' => 'Bottom Of Page',
    'position_entire' => 'Entire Page',
    'head_centerblock' => 'Centerblock',
    'centerblock_no' => 'No',
    'centerblock_top' => 'Top',
    'centerblock_feat' => 'Feat. Story',
    'centerblock_bottom' => 'Bottom',
    'centerblock_entire' => 'Entire Page',
    'inblock_msg' => 'In a block: ',
    'inblock_info' => 'Wrap Static Page in a block.',
    'title_edit' => 'Edit page',
    'title_copy' => 'Make a copy of this page',
    'title_display' => 'Display page',
    'select_php_none' => 'do not execute PHP',
    'select_php_return' => 'execute PHP (return)',
    'select_php_free' => 'execute PHP',
    'php_not_activated' => "The use of PHP in static pages is not activated. Please see the <a href=\"{$_CONF['site_url']}/docs/english/staticpages.html#php\">documentation</a> for details.",
    'printable_format' => 'Printable Format',
    'copy' => 'Copy',
    'limit_results' => 'Limit Results',
    'search' => 'Search',
    'submit' => 'Submit',
    'no_new_pages' => 'No new pages',
    'pages' => 'Pages',
    'comments' => 'Comments',
    'draft' => 'Draft',
    'draft_yes' => 'Yes',
    'draft_no' => 'No'
);

$PLG_staticpages_MESSAGE15 = 'Your comment has been submitted for review and will be published when approved by a moderator.';
$PLG_staticpages_MESSAGE19 = 'Your page has been successfully saved.';
$PLG_staticpages_MESSAGE20 = 'Your page has been successfully deleted.';
$PLG_staticpages_MESSAGE21 = 'This page does not exist yet. To create the page, please fill in the form below. If you are here by mistake, click the Cancel button.';

// Messages for the plugin upgrade
$PLG_staticpages_MESSAGE3001 = 'Plugin upgrade not supported.';
$PLG_staticpages_MESSAGE3002 = $LANG32[9];

// Localization of the Admin Configuration UI
$LANG_configsections['staticpages'] = array(
    'label' => 'Static Pages',
    'title' => 'Static Pages Configuration'
);

$LANG_confignames['staticpages'] = array(
    'allow_php' => 'Allow PHP?',
    'sort_by' => 'Sort Centerblocks by',
    'sort_menu_by' => 'Sort Menu Entries by',
    'sort_list_by' => 'Sort Admin List by',
    'delete_pages' => 'Delete Pages with Owner?',
    'in_block' => 'Wrap Pages in Block?',
    'show_hits' => 'Show Hits?',
    'show_date' => 'Show Date?',
    'filter_html' => 'Filter HTML?',
    'censor' => 'Censor Content?',
    'default_permissions' => 'Page Default Permissions',
    'aftersave' => 'After Saving Page',
    'atom_max_items' => 'Max. Pages in Webservices Feed',
    'meta_tags' => 'Enable Meta Tags',
    'comment_code' => 'Comment Default',
    'draft_flag' => 'Draft Flag Default',
    'newstaticpagesinterval' => 'New Static Page Interval',
    'hidenewstaticpages' => 'Hide New Static Pages',
    'title_trim_length' => 'Title Trim Length',
    'includecenterblocks' => 'Include Center Block Static Pages',
    'includephp' => 'Include Static Pages with PHP',
    'includesearch' => 'Enable Static Pages in Search',
    'includesearchcenterblocks' => 'Include Center Block Static Pages',
    'includesearchphp' => 'Include Static Pages with PHP'
);

$LANG_configsubgroups['staticpages'] = array(
    'sg_main' => 'Main Settings'
);

$LANG_fs['staticpages'] = array(
    'fs_main' => 'Static Pages Main Settings',
    'fs_whatsnew' => 'What\'s New Block',
    'fs_search' => 'Search Results',
    'fs_permissions' => 'Default Permissions'
);

// Note: entries 0, 1, 9, 12, 17 are the same as in $LANG_configselects['Core']
$LANG_configselects['staticpages'] = array(
    0 => array('True' => 1, 'False' => 0),
    1 => array('True' => true, 'False' => false),
    2 => array('Date' => 'date', 'Page ID' => 'id', 'Title' => 'title'),
    3 => array('Date' => 'date', 'Page ID' => 'id', 'Title' => 'title', 'Label' => 'label'),
    4 => array('Date' => 'date', 'Page ID' => 'id', 'Title' => 'title', 'Author' => 'author'),
    5 => array('Hide' => 'hide', 'Show - Use Modified Date' => 'modified', 'Show - Use Created Date' => 'created'),
    9 => array('Forward to page' => 'item', 'Display List' => 'list', 'Display Home' => 'home', 'Display Admin' => 'admin'),
    12 => array('No access' => 0, 'Read-Only' => 2, 'Read-Write' => 3),
    17 => array('Comments Enabled' => 0, 'Comments Disabled' => -1)
);

?>
