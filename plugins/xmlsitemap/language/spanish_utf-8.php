<?php

/* Reminder: always indent with 4 spaces (no tabs). */
// +---------------------------------------------------------------------------+
// | XMLSitemap Plugin 2.0                                                     |
// +---------------------------------------------------------------------------+
// | spanish_utf-8.php                                                         |
// +---------------------------------------------------------------------------+
// | Copyright (C) 2009-2020 by the following authors:                         |
// |                                                                           |
// | Authors: Kenji ITO         - geeklog AT mystral-kk DOT net                |
// |          Dirk Haun         - dirk AT haun-online DOT de                   |
// +---------------------------------------------------------------------------|
// | This program is free software; you can redistribute it and/or             |
// | modify it under the terms of the GNU General Public License               |
// | as published by the Free Software Foundation; either version 2            |
// | of the License, or (at your option) any later version.                    |
// |                                                                           |
// | This program is distributed in the hope that it will be useful,           |
// | but WITHOUT ANY WARRANTY; without even the implied warranty of            |
// | MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the             |
// | GNU General Public License for more details.                              |
// |                                                                           |
// | You should have received a copy of the GNU General Public License         |
// | along with this program; if not, write to the Free Software               |
// | Foundation, Inc., 59 Temple Place - Suite 330, Boston, MA  02111-1307, USA|
// |                                                                           |
// +---------------------------------------------------------------------------+

if (stripos($_SERVER['PHP_SELF'], basename(__FILE__)) !== false) {
    die('This file can not be used on its own.');
}

global $LANG32;

$LANG_XMLSMAP = array(
    'plugin' => 'XMLSitemap',
    'admin' => 'Administración de XMLSitemap',
    'description' => 'Normalmente, todos los archivos sitemap se actualizan automáticamente cuando se añade, modifica o elimina un elemento. Si algo falla, actualice manualmente los archivos sitemap con el botón de abajo.',
    'filename' => 'Nombre del archivo',
    'updated' => 'Actualizado',
    'not_saved' => 'No guardado',
    'update_now' => '¡Actualizar ahora todos los archivos sitemap!',
    'update_success' => 'Todos los archivos sitemap se actualizaron correctamente.',
    'update_fail' => 'No se pudieron actualizar los archivos sitemap. Consulte "error.log" para obtener más detalles.',
);

$LANG_configsections['xmlsitemap'] = array('label' => 'XMLSitemap', 'title' => 'Configuración de XMLSitemap');

$LANG_confignames['xmlsitemap'] = array(
    'sitemap_file' => 'Nombre del archivo sitemap',
    'mobile_sitemap_file' => 'Nombre del archivo sitemap móvil',
    'include_homepage' => 'Página de inicio en el sitemap',
    'types' => 'Contenido del sitemap',
    'lastmod' => 'Tipos de contenido que incluyen el elemento lastmod',
    'priorities' => 'Prioridad',
    'frequencies' => 'Frecuencia',
    'ping_google' => 'Enviar ping a Google',
    'indexnow' => 'Activar IndexNow',
    'indexnow_key' => 'Clave de IndexNow',
    'indexnow_key_location' => 'Ubicación de la clave de IndexNow',
    'news_sitemap_file' => 'Nombre del archivo sitemap de noticias',
    'news_sitemap_topics' => 'Incluir artículos de estos temas',
    'news_sitemap_age' => 'Antigüedad máxima de los artículos',
);

$LANG_configsubgroups['xmlsitemap'] = array('sg_main' => 'Configuración principal');

$LANG_tab['xmlsitemap'] = array(
    'tab_main' => 'Configuración principal de XMLSitemap',
    'tab_pri' => 'Prioridad',
    'tab_freq' => 'Frecuencia de actualización',
    'tab_ping' => 'Ping',
    'tab_news' => 'Sitemap de noticias',
);

$LANG_fs['xmlsitemap'] = array(
    'fs_main' => 'Configuración principal de XMLSitemap',
    'fs_pri' => 'Prioridad (predeterminado = 0,5, mínimo = 0,0, máximo = 1,0)',
    'fs_freq' => 'Frecuencia de actualización',
    'fs_ping' => 'Enviar ping al cambiar',
    'fs_news' => 'Configuración del sitemap de noticias',
);

$LANG_configselects['xmlsitemap'] = array(
    0 => array('Sí' => 1, 'No' => 0),
    1 => array('Sí' => TRUE, 'No' => FALSE),
    9 => array('Redirigir a la página' => 'item', 'Mostrar lista' => 'list', 'Mostrar inicio' => 'home', 'Mostrar administración' => 'admin'),
    12 => array('Sin acceso' => 0, 'Solo lectura' => 2, 'Lectura y escritura' => 3),
    20 => array('siempre' => 'always', 'cada hora' => 'hourly', 'diariamente' => 'daily', 'semanalmente' => 'weekly', 'mensualmente' => 'monthly', 'anualmente' => 'yearly', 'nunca' => 'never', 'oculto' => 'hidden'),
);
