<?php

###############################################################################
# spanish_utf-8.php
# This is the spanish language page for the Geeklog Static Page Plug-in!
#
# Copyright (C) 2007 José R. Valverde (Terminado)
# jrvalverde@cnb.uam.es
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
    'page_title' => 'Título de página',
    'content' => 'Contenido',
    'hits' => 'Visitas',
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
    'no_title_or_content' => 'Debes rellenar al menos los campos <b>Título</b> y <b>Contenido</b>.',
    'title_error_saving' => 'Error al guardar la página',
    'template_xml_error' => 'Hay un <em>error en el marcado XML</em>. Esta página está configurada para usar otra página como plantilla y, por tanto, las variables de la plantilla deben definirse mediante marcado XML. Consulte el <a href="http://wiki.geeklog.net/Static_Pages_Plugin#Template_Static_Pages" target="_blank">Wiki de Geeklog</a> para obtener más información. El error debe corregirse antes de guardar la página.',
    'no_such_page_anon' => 'Por favor, regístrate..',
    'no_page_access_msg' => "Esto puede ser porque no te has registrado o no eres un miembro de {$_CONF['site_name']}. Por favor, <a href=\"{$_CONF['site_url']}/users.php?mode=new\">regístrate</a> en {$_CONF['site_name']} para obtener acceso completo",
    'php_msg' => 'PHP: ',
    'php_warn' => 'Aviso: Si activas esta opción se interpretará el código PHP en tu página. ¡¡Usar con cuidado!!',
    'exit_msg' => 'Tipo de salida: ',
    'exit_info' => 'Activar para Mensaje de Acceso Preciso. No marcar para verificaciones de seguridad  y mensaje normales.',
    'deny_msg' => 'Acceso denegado a esta página. O bien ha sido movida/renombrada o no tienes permiso suficiente.',
    'stats_headline' => '10 páginas estáticas principales',
    'stats_page_title' => 'Título de la página',
    'stats_hits' => 'Visitas',
    'stats_no_hits' => 'Parece que no hay páginas estáticas o que nadie las ha visto nunca.',
    'id' => 'ID',
    'duplicate_id' => 'La ID elegida ya está en uso. Por favor, elige otra.',
    'instructions' => 'Para modificar o borrar una página estática, pulsa en el número correspondiente. Para ver una página estática pulsa en su título. Para cerar una página nueva pulsa en "Página nueva". Pulsa en [C] para crear una copia de una página existente.',
    'centerblock' => 'Bloque central: ',
    'centerblock_msg' => 'Cuando se selecciona esta opción la página estática aparecerá como un bloque central en la página principal.',
    'topic' => 'Tópico: ',
    'position' => 'Posición: ',
    'all_topics' => 'Todos',
    'no_topic' => 'Solo página principal',
    'position_top' => 'Arriba de la página',
    'position_feat' => 'Tras la noticia destacada',
    'position_bottom' => 'Abajo de la página',
    'position_entire' => 'Toda la página',
    'head_centerblock' => 'Bloque central',
    'centerblock_no' => 'No',
    'centerblock_top' => 'Arriba',
    'centerblock_feat' => 'Noticia destacada',
    'centerblock_bottom' => 'Abajo',
    'centerblock_entire' => 'Toda la página',
    'inblock_msg' => 'En un bloque: ',
    'inblock_info' => 'Mostrar la página estática dentro de un bloque.',
    'title_edit' => 'Editar página',
    'title_copy' => 'Crear una copia de esta página',
    'title_display' => 'Mostrar página',
    'select_php_none' => 'no ejecutar PHP',
    'select_php_return' => 'ejecutar PHP (volver)',
    'select_php_free' => 'ejecutar PHP',
    'php_not_activated' => "Es uso de PHP en páginas estáticas no está activado. Por favor, véase la <a href=\"{$_CONF['site_url']}/docs/english/staticpages.html#php\">documentación</a> para más información.",
    'printable_format' => 'Listo para imprimir',
    'copy' => 'Copiar',
    'limit_results' => 'Limitar resultados',
    'search' => 'Buscar',
    'likes' => 'Me gusta',
    'submit' => 'Enviar',
    'no_new_pages' => 'No hay páginas nuevas',
    'pages' => 'Páginas',
    'comments' => 'Comentarios',
    'template' => 'Plantilla',
    'use_template' => 'Usar plantilla',
    'template_msg' => 'Al marcar esta opción, la página estática se definirá como plantilla.',
    'none' => 'Ninguno',
    'use_template_msg' => 'If this Static Page is not a template, you can assign it to use a template. If a selection is made then remember that the content of this page must follow the proper XML format.',
    'draft' => 'Borrador',
    'draft_yes' => 'Sí',
    'draft_no' => 'No',
    'show_on_page' => 'Mostrar en la página',
    'show_on_page_disabled' => 'Nota: esta opción está desactivada actualmente para todas las páginas en la configuración de Páginas estáticas.',
    'cache_time' => 'Tiempo de caché',
    'cache_time_desc' => 'This staticpage content will be cached for no longer than this many seconds. If 0 caching is disabled (3600 = 1 hour,  86400 = 1 day). Staticpages with PHP enabled or are a template will not be cached.',
    'autotag_desc_staticpage' => '[staticpage: id título alternativo] - Muestra un enlace a una página estática usando como título el título de la página. Puede indicarse un título alternativo, pero no es obligatorio.',
    'autotag_desc_staticpage_content' => '[staticpage_content: id alternate title] - Displays the contents of a staticpage.',
    'autotag_desc_page' => '[page: id título alternativo] - Muestra un enlace a una página del plugin Páginas estáticas usando como título el título de la página. Puede indicarse un título alternativo, pero no es obligatorio.',
    'autotag_desc_page_content' => '[page_content: id] - Muestra el contenido de una página del plugin Páginas estáticas.',
    'yes' => 'Sí',
    'used_by' => 'Esta plantilla está asignada a %s página(s). Es posible que la utilicen más páginas de las indicadas si se recupera mediante un autotag desde otra plantilla.',
    'prev_page' => 'Página anterior',
    'next_page' => 'Página siguiente',
    'parent_page' => 'Página principal',
    'page_desc' => 'Setting a previous and/or next page will add HTML link elements rel=”next” and rel=”prev” to the header to indicate the relationship between pages in a paginated series. Actual page navigation links are not added to the page. You have to add these yourself. NOTE: Parent page is currently not being used.',
    'num_pages' => '%s página(s)',
    'search_desc' => 'Control if page appears in search. Default depends on setting in Configuration and depends on page type (if it is a Center Block, Uses a Template, or Uses PHP).',
    'likes_desc' => 'Determina si se muestra el control de Me gusta en la página y de qué forma. El valor predeterminado depende de la configuración del plugin. Las páginas mostradas como bloques centrales no mostrarán este control. Las páginas que son plantillas no usan esta opción.'
);

$LANG_staticpages_search = array(
    0  => 'Excluida',
    1  => 'Usar valor predeterminado',
    2  => 'Incluida'
);

$LANG_staticpages_likes = array(
    -1 => 'Usar valor predeterminado',
    0  => 'Desactivado',
    1  => 'Me gusta y No me gusta',
    2  => 'Solo Me gusta',
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
    'allow_php' => '¿Permitir PHP?',
    'enable_eval_php_save' => 'Analizar PHP al guardar la página',
    'sort_by' => 'Ordenar bloques centrales por',
    'sort_menu_by' => 'Ordenar entradas del menú por',
    'sort_list_by' => 'Ordenar lista de administración por',
    'delete_pages' => '¿Eliminar páginas con el propietario?',
    'in_block' => '¿Mostrar páginas dentro de un bloque?',
    'show_hits' => '¿Mostrar visitas?',
    'show_date' => '¿Mostrar fecha?',
    'filter_html' => '¿Filtrar HTML?',
    'censor' => '¿Censurar contenido?',
    'default_permissions' => 'Permisos predeterminados de página',
    'autotag_permissions_staticpage' => 'Permisos de [staticpage: ]',
    'autotag_permissions_staticpage_content' => 'Permisos de [staticpage_content: ]',
    'aftersave' => 'Después de guardar la página',
    'atom_max_items' => 'Máximo de páginas en el feed de servicios web',
    'meta_tags' => 'Activar metaetiquetas',
    'likes_pages' => 'Me gusta de páginas',
    'comment_code' => 'Comentarios predeterminados',
    'structured_data_type_default' => 'Tipo predeterminado de datos estructurados',
    'draft_flag' => 'Borrador predeterminado',
    'disable_breadcrumbs_staticpages' => 'Desactivar migas de pan',
    'default_cache_time' => 'Tiempo de caché predeterminado',
    'newstaticpagesinterval' => 'Intervalo de páginas estáticas nuevas',
    'hidenewstaticpages' => 'Hide New Static Pages',
    'title_trim_length' => 'Longitud máxima del título',
    'includecenterblocks' => 'Incluir páginas estáticas como bloque central',
    'includephp' => 'Incluir páginas estáticas con PHP',
    'includesearch' => 'Activar páginas estáticas en la búsqueda',
    'includesearchcenterblocks' => 'Incluir páginas estáticas como bloque central',
    'includesearchphp' => 'Incluir páginas estáticas con PHP',
    'includesearchtemplate' => 'Incluir páginas estáticas usadas como plantilla'
);

$LANG_configsubgroups['staticpages'] = array(
    'sg_main' => 'Configuración principal'
);

$LANG_tab['staticpages'] = array(
    'tab_main' => 'Configuración principal de páginas estáticas',
    'tab_whatsnew' => 'Bloque Novedades',
    'tab_search' => 'Resultados de búsqueda',
    'tab_permissions' => 'Permisos predeterminados',
    'tab_autotag_permissions' => 'Permisos de uso de autotags'
);

$LANG_fs['staticpages'] = array(
    'fs_main' => 'Configuración principal de páginas estáticas',
    'fs_whatsnew' => 'Bloque Novedades',
    'fs_search' => 'Resultados de búsqueda',
    'fs_permissions' => 'Permisos predeterminados',
    'fs_autotag_permissions' => 'Permisos de uso de autotags'
);

// Note: entries 0, 1, 9, 12, 17 are the same as in $LANG_configselects['Core']
$LANG_configselects['staticpages'] = array(
    0 => array('Verdadero' => 1, 'Falso' => 0),
    1 => array('Verdadero' => TRUE, 'Falso' => FALSE),
    2 => array('Fecha' => 'date', 'ID de página' => 'id', 'Título' => 'title'),
    3 => array('Fecha' => 'date', 'ID de página' => 'id', 'Título' => 'title', 'Etiqueta' => 'label'),
    4 => array('Fecha' => 'date', 'ID de página' => 'id', 'Título' => 'title', 'Autor' => 'author'),
    5 => array('Ocultar' => 'hide', 'Mostrar - usar fecha de modificación' => 'modified', 'Mostrar - usar fecha de creación' => 'created'),
    9 => array('Ir a la página' => 'item', 'Mostrar lista' => 'list', 'Mostrar inicio' => 'home', 'Mostrar administración' => 'admin'),
    12 => array('Sin acceso' => 0, 'Solo lectura' => 2, 'Lectura y escritura' => 3),
    13 => array('Sin acceso' => 0, 'Usar' => 2),
    17 => array('Comentarios activados' => 0, 'Comentarios desactivados' => -1),
    39 => array('Ninguno' => '', 'WebPage' => 'core-webpage', 'Article' => 'core-article', 'NewsArticle' => 'core-newsarticle', 'BlogPosting' => 'core-blogposting'),
    41 => array('Falso' => 0, 'Me gusta y No me gusta' => 1, 'Solo Me gusta' => 2)
);
