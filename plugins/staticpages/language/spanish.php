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
    'newpage' => 'Nueva P�gina',
    'adminhome' => 'Administraci�n',
    'staticpages' => 'P�ginas Est�ticas',
    'staticpageeditor' => 'Editor de p�ginas est�ticas',
    'writtenby' => 'Escrito por',
    'date' => '�ltima edici�n',
    'title' => 'T�tulo',
    'page_title' => 'Page Title',
    'content' => 'Contenido',
    'hits' => 'Hits',
    'staticpagelist' => 'Lista de P�ginas Est�ticas',
    'url' => 'URL',
    'edit' => 'Editar',
    'lastupdated' => '�ltima Edici�n',
    'pageformat' => 'Formato de P�gina',
    'leftrightblocks' => 'Cajas a Derecha e Izquierda',
    'blankpage' => 'P�gina en blanco',
    'noblocks' => 'Sin Cajas',
    'leftblocks' => 'Cajas a Izquierda',
    'addtomenu' => 'A�adir al men�',
    'label' => 'Etiqueta',
    'nopages' => 'Todav�a no hay p�ginas est�ticas',
    'save' => 'guardar',
    'preview' => 'vista previa',
    'delete' => 'eliminar',
    'cancel' => 'cancelar',
    'access_denied' => 'Acceso Denegado',
    'access_denied_msg' => 'Est�s intentando acceder a una p�gina de administraci�n de P�ginas Est�ticas. Ten en cuenta que cualquier acceso a esta p�gina se registra',
    'all_html_allowed' => 'Se permite cualquier etiqueta HTML',
    'results' => 'Resultado de P�ginas Est�ticas',
    'author' => 'Autor',
    'no_title_or_content' => 'Debes rellenar al menos los campos <b>T�tulo</b> y <b>Contenido</b>.',
    'title_error_saving' => 'Error Saving Page',
    'template_xml_error' => 'You have an <em>error in your XML markup</em>. This page is set to use another page as a template and therefore requires template variables to be defined using XML markup. Please see our <a href="http://wiki.geeklog.net/Static_Pages_Plugin#Template_Static_Pages" target="_blank">Geeklog Wiki</a> for more information on how to do this as it must be corrected before the page can be saved.',
    'no_such_page_anon' => 'Por favor, reg�strate..',
    'no_page_access_msg' => "Esto puede ser porque no te has registrado o no eres un miembro de {$_CONF['site_name']}. Por favor, <a href=\"{$_CONF['site_url']}/users.php?mode=new\">reg�strate</a> en {$_CONF['site_name']} para obtener acceso completo",
    'php_msg' => 'PHP: ',
    'php_warn' => 'Aviso: Si activas esta opci�n se interpretar� el c�digo PHP en tu p�gina. ��Usar con cuidado!!',
    'exit_msg' => 'Tipo de salida: ',
    'exit_info' => 'Activar para Mensaje de Acceso Preciso. No marcar para verificaciones de seguridad  y mensaje normales.',
    'deny_msg' => 'Acceso denegado a esta p�gina. O bien ha sido movida/renombrada o no tienes permiso suficiente.',
    'stats_headline' => '10 p�ginas est�ticas principales',
    'stats_page_title' => 'T�tulo de la p�gina',
    'stats_hits' => 'Hits',
    'stats_no_hits' => 'Parece que no hay p�ginas est�ticas o que nadie las ha visto nunca.',
    'id' => 'ID',
    'duplicate_id' => 'La ID elegida ya est� en uso. Por favor, elige otra.',
    'instructions' => 'Para modificar o borrar una p�gina est�tica, pulsa en el n�mero correspondiente. Para ver una p�gina est�tica pulsa en su t�tulo. Para cerar una p�gina nueva pulsa en "P�gina nueva". Pulsa en [C] para crear una copia de una p�gina existente.',
    'centerblock' => 'Bloque central: ',
    'centerblock_msg' => 'Cuando se selecciona esta opci�n la p�gina est�tica aparecer� como un bloque central en la p�gina principal.',
    'topic' => 'T�pico: ',
    'position' => 'Posici�n: ',
    'all_topics' => 'Todos',
    'no_topic' => 'Solo p�gina principal',
    'position_top' => 'Arriba de la p�gina',
    'position_feat' => 'Tras la noticia destacada',
    'position_bottom' => 'Abajo de la p�gina',
    'position_entire' => 'Toda la p�gina',
    'head_centerblock' => 'Bloque central',
    'centerblock_no' => 'No',
    'centerblock_top' => 'Arriba',
    'centerblock_feat' => 'Noticia destacada',
    'centerblock_bottom' => 'Abajo',
    'centerblock_entire' => 'Toda la p�gina',
    'inblock_msg' => 'In a block: ',
    'inblock_info' => 'Wrap Static Page in a block.',
    'title_edit' => 'Edit page',
    'title_copy' => 'Make a copy of this page',
    'title_display' => 'Display page',
    'select_php_none' => 'no ejecutar PHP',
    'select_php_return' => 'ejecutar PHP (volver)',
    'select_php_free' => 'ejecutar PHP',
    'php_not_activated' => "Es uso de PHP en p�ginas est�ticas no est� activado. Por favor, v�ase la <a href=\"{$_CONF['site_url']}/docs/english/staticpages.html#php\">documentaci�n</a> para m�s informaci�n.",
    'printable_format' => 'Listo para imprimir',
    'copy' => 'Copy',
    'limit_results' => 'Limit Results',
    'search' => 'Search',
    'submit' => 'Submit',
    'no_new_pages' => 'No new pages',
    'pages' => 'Pages',
    'comments' => 'Comments',
    'template' => 'Template',
    'use_template' => 'Use Template',
    'template_msg' => 'When checked, this Static Page will be marked as a template.',
    'none' => 'None',
    'use_template_msg' => 'If this Static Page is not a template, you can assign it to use a template. If a selection is made then remember that the content of this page must follow the proper XML format.',
    'draft' => 'Draft',
    'draft_yes' => 'Yes',
    'draft_no' => 'No',
    'show_on_page' => 'Show on Page',
    'show_on_page_disabled' => 'Note: This is currently disabled for all pages in the Staticpage Configuration.',
    'cache_time' => 'Cache Time',
    'cache_time_desc' => 'This staticpage content will be cached for no longer than this many seconds. If 0 caching is disabled (3600 = 1 hour,  86400 = 1 day). Staticpages with PHP enabled or are a template will not be cached.',
    'autotag_desc_staticpage' => '[staticpage: id alternate title] - Displays a link to a static page using the static page title as the title. An alternate title may be specified but is not required.',
    'autotag_desc_staticpage_content' => '[staticpage_content: id alternate title] - Displays the contents of a staticpage.',
    'autotag_desc_page' => '[page: id alternate title] - Displays a link to a page (from the Static Page plugin) using the page title as the title. An alternate title may be specified but is not required.',
    'autotag_desc_page_content' => '[page_content: id] - Displays the contents of a page. (from Static Page plugin)',
    'yes' => 'Yes',
    'used_by' => 'This template is assigned to %s page(s). It is possible this template is used more than specified here if the template is being retrieved via an autotag in another template.',
    'prev_page' => 'Previous page',
    'next_page' => 'Next page',
    'parent_page' => 'Parent page',
    'page_desc' => 'Setting a previous and/or next page will add HTML link elements rel="next" and rel="prev" to the header to indicate the relationship between pages in a paginated series. Actual page navigation links are not added to the page. You have to add these yourself. NOTE: Parent page is currently not being used.',
    'num_pages' => '%s Page(s)'
);

$PLG_staticpages_MESSAGE15 = 'Your comment has been submitted for review and will be published when approved by a moderator.';
$PLG_staticpages_MESSAGE19 = 'Your page has been successfully saved.';
$PLG_staticpages_MESSAGE20 = 'Your page has been successfully deleted.';
$PLG_staticpages_MESSAGE21 = 'This page does not exist yet. To create the page, please fill in the form below. If you are here by mistake, click the Cancel button.';
$PLG_staticpages_MESSAGE22 = 'You could not delete the page. It is a template staticpage and it is currently assigned to 1 or more staticpages.';

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
    'autotag_permissions_staticpage' => '[staticpage: ] Permissions',
    'autotag_permissions_staticpage_content' => '[staticpage_content: ] Permissions',
    'aftersave' => 'After Saving Page',
    'atom_max_items' => 'Max. Pages in Webservices Feed',
    'meta_tags' => 'Enable Meta Tags',
    'comment_code' => 'Comment Default',
    'structured_data_type_default' => 'Structured Data Type Default',
    'draft_flag' => 'Draft Flag Default',
    'disable_breadcrumbs_staticpages' => 'Disable Breadcrumbs',
    'default_cache_time' => 'Default Cache Time',
    'newstaticpagesinterval' => 'New Static Page Interval',
    'hidenewstaticpages' => 'Hide New Static Pages',
    'title_trim_length' => 'Title Trim Length',
    'includecenterblocks' => 'Include Center Block Static Pages',
    'includephp' => 'Include Static Pages with PHP',
    'includesearch' => 'Enable Static Pages in Search',
    'includesearchcenterblocks' => 'Include Center Block Static Pages',
    'includesearchphp' => 'Include Static Pages with PHP',
    'includesearchtemplate' => 'Include Template Static Pages'
);

$LANG_configsubgroups['staticpages'] = array(
    'sg_main' => 'Main Settings'
);

$LANG_tab['staticpages'] = array(
    'tab_main' => 'Static Pages Main Settings',
    'tab_whatsnew' => 'What\'s New Block',
    'tab_search' => 'Search Results',
    'tab_permissions' => 'Default Permissions',
    'tab_autotag_permissions' => 'Autotag Usage Permissions'
);

$LANG_fs['staticpages'] = array(
    'fs_main' => 'Static Pages Main Settings',
    'fs_whatsnew' => 'What\'s New Block',
    'fs_search' => 'Search Results',
    'fs_permissions' => 'Default Permissions',
    'fs_autotag_permissions' => 'Autotag Usage Permissions'
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
    13 => array('No access' => 0, 'Use' => 2),
    17 => array('Comments Enabled' => 0, 'Comments Disabled' => -1),
    39 => array('None' => '', 'WebPage' => 'core-webpage', 'Article' => 'core-article', 'NewsArticle' => 'core-newsarticle', 'BlogPosting' => 'core-blogposting')
);
