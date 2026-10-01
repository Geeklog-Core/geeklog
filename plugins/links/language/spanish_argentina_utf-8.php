<?php

###############################################################################
# spanish_argentina_utf-8.php
# Argentine Spanish language file for the Geeklog Links Plugin
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

global $LANG32;

###############################################################################
# Array Format:
# $LANGXX[YY]:  $LANG - variable name
#               XX    - file id number
#               YY    - phrase id number
###############################################################################

$LANG_LINKS = array(
    10 => 'Envíos',
    14 => 'Enlaces',
    84 => 'ENLACES',
    88 => 'No hay enlaces recientes',
    114 => 'Enlaces',
    116 => 'Añadir un enlace',
    117 => 'Informar de enlace roto',
    118 => 'Informe de enlace roto',
    119 => 'Se ha informado de que el siguiente enlace está roto: ',
    120 => 'Para editar el enlace, haga clic aquí: ',
    121 => 'El enlace roto fue informado por: ',
    122 => 'Gracias por informar de este enlace roto. El administrador corregirá el problema lo antes posible',
    123 => 'Gracias',
    124 => 'Ir',
    125 => 'Categorías',
    126 => 'Está aquí:',
    'autotag_desc_link' => '[link: id título alternativo] - Muestra un enlace del plugin Links usando el título del enlace. Se puede indicar un título alternativo, pero no es obligatorio.',
    'root' => 'Raíz'
);

###############################################################################
# for stats

$LANG_LINKS_STATS = array(
    'links' => 'Enlaces (Clicks) en el Sistema',
    'stats_headline' => '10 enlaces mejores',
    'stats_page_title' => 'Enlaces',
    'stats_hits' => 'Visitas',
    'stats_no_hits' => 'Parece que no hay enlaces o nadie ha visitado uno antes.'
);

###############################################################################
# for the search

$LANG_LINKS_SEARCH = array(
    'results' => 'Resultados de enlaces',
    'title' => 'Título',
    'date' => 'Fecha de adición',
    'author' => 'Enviado por',
    'hits' => 'Clics'
);

###############################################################################
# for the submission form

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
$PLG_links_MESSAGE5 = 'You do not have sufficient access rights to view this category.';
$PLG_links_MESSAGE6 = 'You do not have sufficient rights to edit this category.';
$PLG_links_MESSAGE7 = 'Please enter a Category Name and Description.';
$PLG_links_MESSAGE10 = 'Your category has been successfully saved.';
$PLG_links_MESSAGE11 = 'You are not allowed to set the id of a category to "site" or "user" - these are reserved for internal use.';
$PLG_links_MESSAGE12 = 'You are trying to make a parent category the child of it\'s own subcategory. This would create an orphan category, so please first move the child category or categories up to a higher level.';
$PLG_links_MESSAGE13 = 'The category has been successfully deleted.';
$PLG_links_MESSAGE14 = 'Category contains links and/or categories. Please remove these first.';
$PLG_links_MESSAGE15 = 'You do not have sufficient rights to delete this category.';
$PLG_links_MESSAGE16 = 'No such category exists.';
$PLG_links_MESSAGE17 = 'This category id is already in use.';

// Messages for the plugin upgrade
$PLG_links_MESSAGE3001 = 'Plugin upgrade not supported.';
$PLG_links_MESSAGE3002 = $LANG32[9];

###############################################################################
# admin/plugins/links/index.php

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
    12 => 'Para modificar o eliminar un enlace, haga clic en su icono de edición. Para crear un enlace o una categoría, use «Nuevo enlace» o «Nueva categoría». Para editar varias categorías, use «Lista de categorías».',
    14 => 'Categoría del enlace',
    16 => 'Acceso denegado',
    17 => "Estás intentando acceder a un enlace al que no tienes derecho. Este intento ha sido anotado. Por favor, <a href=\"{$_CONF['site_admin_url']}/plugins/links/index.php\">vuelve a la pantalla de administración de enlaces</a>.",
    20 => 'Si Otra, especificar',
    21 => 'guardar',
    22 => 'cancelar',
    23 => 'borrar',
    24 => 'Enlace no encontrado',
    25 => 'No se ha encontrado el enlace seleccionado para editar.',
    26 => 'Validar enlaces',
    27 => 'Estado HTTP',
    28 => 'Editar categoría',
    29 => 'Introduzca o edite los datos siguientes.',
    30 => 'Categoría',
    31 => 'Descripción',
    32 => 'ID de categoría',
    33 => 'Tema',
    34 => 'Principal',
    35 => 'Todos',
    40 => 'Editar esta categoría',
    41 => 'Crear subcategoría',
    42 => 'Eliminar esta categoría',
    43 => 'Categorías del sitio',
    44 => 'Añadir&nbsp;subcategoría',
    46 => 'El usuario %s intentó eliminar una categoría para la que no tiene permisos',
    50 => 'Lista de categorías',
    51 => 'Nuevo enlace',
    52 => 'Nueva categoría',
    53 => 'Lista de enlaces',
    54 => 'Gestor de categorías',
    55 => 'Edite las categorías a continuación. No puede eliminar una categoría que contenga otras categorías o enlaces; elimínelos primero o muévalos a otra categoría.',
    56 => 'Editor de categorías',
    57 => 'Aún no validado',
    58 => 'Validar ahora',
    59 => '<p>Para validar todos los enlaces mostrados, haga clic en «Validar ahora». El proceso puede tardar según la cantidad de enlaces.</p>',
    60 => 'El usuario %s intentó editar sin permiso la categoría %s.',
    61 => 'Enlaces de la categoría',
    'num_links' => '%s enlace(s)'
);


$LANG_LINKS_STATUS = array(
    100 => 'Continuar',
    101 => 'Cambio de protocolos',
    200 => 'OK',
    201 => 'Creado',
    202 => 'Aceptado',
    203 => 'Información no autoritativa',
    204 => 'Sin contenido',
    205 => 'Restablecer contenido',
    206 => 'Contenido parcial',
    300 => 'Múltiples opciones',
    301 => 'Movido permanentemente',
    302 => 'Encontrado',
    303 => 'Ver otro',
    304 => 'No modificado',
    305 => 'Usar proxy',
    307 => 'Redirección temporal',
    400 => 'Solicitud incorrecta',
    401 => 'No autorizado',
    402 => 'Pago requerido',
    403 => 'Prohibido',
    404 => 'No encontrado',
    405 => 'Método no permitido',
    406 => 'No aceptable',
    407 => 'Autenticación de proxy requerida',
    408 => 'Tiempo de espera de solicitud agotado',
    409 => 'Conflicto',
    410 => 'Ya no disponible',
    411 => 'Longitud requerida',
    412 => 'Precondición fallida',
    413 => 'Entidad de solicitud demasiado grande',
    414 => 'URI de solicitud demasiado larga',
    415 => 'Tipo de medio no compatible',
    416 => 'Rango solicitado no satisfacible',
    417 => 'Expectativa fallida',
    500 => 'Error interno del servidor',
    501 => 'No implementado',
    502 => 'Puerta de enlace incorrecta',
    503 => 'Servicio no disponible',
    504 => 'Tiempo de espera de puerta de enlace agotado',
    505 => 'Versión HTTP no compatible',
    999 => 'Tiempo de conexión agotado'
);

// Localization of the Admin Configuration UI
$LANG_configsections['links'] = array(
    'label' => 'Enlaces',
    'title' => 'Configuración de enlaces'
);

$LANG_confignames['links'] = array(
    'linksloginrequired' => '¿Se requiere inicio de sesión para los enlaces?',
    'linksubmission' => '¿Activar la cola de envíos?',
    'newlinksinterval' => 'Intervalo de enlaces nuevos',
    'hidenewlinks' => '¿Ocultar enlaces nuevos?',
    'hidelinksmenu' => '¿Ocultar la entrada Enlaces del menú?',
    'linkcols' => 'Categorías por columna',
    'linksperpage' => 'Enlaces por página',
    'show_top10' => '¿Mostrar los 10 enlaces principales?',
    'notification' => '¿Correo de notificación?',
    'delete_links' => '¿Eliminar enlaces con su propietario?',
    'aftersave' => 'Después de guardar el enlace',
    'show_category_descriptions' => '¿Mostrar la descripción de la categoría?',
    'new_window' => '¿Abrir enlaces externos en una ventana nueva?',
    'recaptcha' => 'reCAPTCHA',
    'recaptcha_score' => 'Puntuación de reCAPTCHA',
    'root' => 'ID de la categoría raíz',
    'default_permissions' => 'Permisos predeterminados de enlaces',
    'category_permissions' => 'Permisos predeterminados de categorías',
    'autotag_permissions_link' => 'Permisos de [link: ]'
);

$LANG_configsubgroups['links'] = array(
    'sg_main' => 'Configuración principal'
);

$LANG_tab['links'] = array(
    'tab_public' => 'Configuración de la lista pública de enlaces',
    'tab_admin' => 'Configuración de administración de enlaces',
    'tab_permissions' => 'Permisos de enlaces',
    'tab_cpermissions' => 'Permisos de categorías',
    'tab_autotag_permissions' => 'Permisos de uso de autotags'
);

$LANG_fs['links'] = array(
    'fs_public' => 'Configuración de la lista pública de enlaces',
    'fs_admin' => 'Configuración de administración de enlaces',
    'fs_permissions' => 'Permisos predeterminados',
    'fs_cpermissions' => 'Permisos de categorías',
    'fs_autotag_permissions' => 'Permisos de uso de autotags'
);

// Note: entries 0, 1, and 12 are the same as in $LANG_configselects['Core']
$LANG_configselects['links'] = array(
    0 => array('True' => 1, 'False' => 0),
    1 => array('True' => true, 'False' => false),
    9 => array('Forward to Linked Site' => 'item', 'Mostrar lista administrativa' => 'list', 'Mostrar lista pública' => 'plugin', 'Mostrar inicio' => 'home', 'Mostrar administración' => 'admin'),
    12 => array('No access' => 0, 'Read-Only' => 2, 'Read-Write' => 3),
    13 => array('No access' => 0, 'Use' => 2),
    14 => array('Disabled' => 0, 'reCAPTCHA V2' => 1, 'reCAPTCHA V2 Invisible' => 2, 'reCAPTCHA V3' => 4)
);
