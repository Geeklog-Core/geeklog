<?php

###############################################################################
# spanish_argentina_utf-8.php
# This is the Argentine Spanish language page for the Geeklog Calendar Plug-in!
#
# Based on the Spanish translation by José R. Valverde
# Argentine Spanish variant maintained for Geeklog 2.2.2
# jrvalverde@cnb.uam.es
#
# Copyright (C) 2001 Tony Bibbs
# tony@tonybibbs.com
# Copyright (C) 2005 Trinity Bays
# trinity93@gmail.com
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

# index.php
$LANG_CAL_1 = array(
    1 => 'Calendario',
    2 => 'Lo siento, no hay eventos que mostrar.',
    3 => 'Cuándo',
    4 => 'Dónde',
    5 => 'Descripción',
    6 => 'Añadir un evento',
    7 => 'Próximos eventos',
    8 => 'Al añadir este evento a tu calendario puedes ver rápidamente solo los eventos que te interesen eligiendo "Mi Calendario" en el área de Utilidades.',
    9 => 'Añadir a Mi Calendario',
    10 => 'Eliminar de Mi Calendario',
    11 => 'Añadiendo evento al Calendario de %s',
    12 => 'Evento',
    13 => 'Comienzo',
    14 => 'Fín',
    15 => 'Volver al Calendario',
    16 => 'Calendario',
    17 => 'Fecha de inicio',
    18 => 'Fecha de terminación',
    19 => 'Envíos al Calendario',
    20 => 'Título',
    21 => 'Fecha de inicio',
    22 => 'URL',
    23 => 'Tus Eventos',
    24 => 'Eventos Comunes',
    25 => 'No hay eventos próximos',
    26 => 'Enviar un evento',
    27 => "Al enviar un evento a {$_CONF['site_name']} se incluirá en el calendario maestro desde el cual otros usuarios pueden añadirlo optativamente a su calendario personal. Este servicio <b>NO</b> debe usarse para eventos personales tales como cumpleaños y aniversarios.<br" . XHTML . "><br" . XHTML . ">Una vez enviado un evento éste será redirigido a nuestros administradores y, si ellos lo aprueban, aparecerá en el calendario maestro.",
    28 => 'Título',
    29 => 'Hora de terminación',
    30 => 'Hora de inicio',
    31 => 'Dura todo el día',
    32 => 'Dirección (línea 1)',
    33 => 'Dirección (línea 2)',
    34 => 'Ciudad/Pueblo',
    35 => 'Provincia',
    36 => 'Código Postal',
    37 => 'Tipo de evento',
    38 => 'Modificar tipos de eventos',
    39 => 'Localización',
    40 => 'Añadir evento a',
    41 => 'Calendario Maestro',
    42 => 'Calendario Personal',
    43 => 'Enlace',
    44 => 'HTML no permitido',
    45 => 'Enviar',
    46 => 'Eventos en el sistema',
    47 => '10 Eventos principales',
    48 => 'Visitas',
    49 => 'Parece no haber ningún evento o que nadie ha visitado uno nunca.',
    50 => 'Eventos',
    51 => 'Borrar',
    'autotag_desc_event' => '[event: id título alternativo] - Muestra un enlace a un evento del calendario usando el título del evento. Se puede especificar un título alternativo, pero no es obligatorio.'
);

$_LANG_CAL_SEARCH = array(
    'results' => 'Resultados del Calendario',
    'title' => 'Título',
    'date_time' => 'Fecha y Hora',
    'location' => 'Localización',
    'description' => 'Descripción'
);

###############################################################################
# calendar.php ($LANG30)

$LANG_CAL_2 = array(
    8 => 'Añadir evento personal',
    9 => '%s Evento',
    10 => 'Eventos para',
    11 => 'Calendario Maestro',
    12 => 'Mi Calendario',
    25 => 'Volver a ',
    26 => 'Todo el día',
    27 => 'Semana',
    28 => 'Calendario personal de',
    29 => 'Calendario Público',
    30 => 'borrar evento',
    31 => 'Añadir',
    32 => 'Evento',
    33 => 'Fecha',
    34 => 'Hora',
    35 => 'Adición rápida',
    36 => 'Enviar',
    37 => 'Lo sentimos, el calendario personal no está habilitado en este servidor.',
    38 => 'Editor de Eventos Personales',
    39 => 'Día',
    40 => 'Semana',
    41 => 'Mes',
    42 => 'Añadir Evento Maestro',
    43 => 'Eventos Enviados'
);

###############################################################################
# admin/plugins/calendar/index.php, formerly admin/event.php ($LANG22)

$LANG_CAL_ADMIN = array(
    1 => 'Editor de Eventos',
    2 => 'Error',
    3 => 'Modo de envío',
    4 => 'URL del Evento',
    5 => 'Fecha de inicio',
    6 => 'Fecha de terminación',
    7 => 'Localización',
    8 => 'Descripción',
    9 => '(incluir http://)',
    10 => 'Debe proporcionar las fechas/horas, título y descripción',
    11 => 'Gestor del Calendario',
    12 => 'Para modificar un evento, pulse en su icono de edición. Para crear un evento pulse en "Crear nuevo". Pulse en el icono de copiar para crear una copia de un evento existente.',
    13 => 'Autor',
    14 => 'Fecha de inicio',
    15 => 'Fecha de terminación',
    16 => '',
    17 => "Está intentando acceder a un evento al que no tiene derecho. Este intento ha sido anotado. Por favor, <a href=\"{$_CONF['site_admin_url']}/plugins/calendar/index.php\">la pantalla de administración de eventos</a>.",
    18 => '',
    19 => '',
    20 => 'guardar',
    21 => 'cancelar',
    22 => 'borrar',
    23 => 'Fecha de inicio errónea.',
    24 => 'Fecha de terminación errónea.',
    25 => 'La fecha de terminación antecede a la de inicio.',
    26 => 'Eliminar entradas antiguas',
    27 => 'Estos son los eventos con más de ',
    28 => ' meses. Pulse el icono de la papelera en la parte inferior para eliminarlos o seleccione otro período:<br' . XHTML . '>Buscar todas las entradas con más de ',
    29 => ' meses.',
    30 => 'Actualizar lista',
    31 => '¿Seguro que desea eliminar definitivamente TODOS los elementos seleccionados?',
    32 => 'Mostrar todos',
    33 => 'No hay eventos seleccionados para eliminar',
    34 => 'ID del evento',
    35 => 'no se pudo eliminar',
    36 => 'Eliminado correctamente',
    'num_events' => '%s evento(s)'
);

$LANG_CAL_MESSAGE = array(
    'save' => 'Tu evento se ha guardado correctamente.',
    'delete' => 'El evento se ha borrado correctamente.',
    'private' => 'El evento se ha guardado en tu calendario',
    'login' => 'No puedes abrir tu calendario personal hasta que te identifiques',
    'removed' => 'El evento se ha eliminado correctamente de tu calendario personal.',
    'noprivate' => 'Lo sentimos, pero los calendarios personales no están habilitados en este servidor.',
    'unauth' => 'Lo sentimos, pero no tienes acceso a la página de administración de eventos. Te avisamos de que todos los intentos de acceder a características no autorizadas se guardan.'
);

$PLG_calendar_MESSAGE4 = "Gracias por enviar un evento a {$_CONF['site_name']}.  Lo hemos redirigido a nuestros administradores para que lo aprueben. Si se aprueba aparecerá aqui, en nuestra sección de <a href=\"{$_CONF['site_url']}/calendar/index.php\">calendario</a>.";
$PLG_calendar_MESSAGE17 = 'Tu evento ha sido guardado correctamente.';
$PLG_calendar_MESSAGE18 = 'El evento ha sido borrado correctamente.';
$PLG_calendar_MESSAGE24 = 'El evento ha sido guardado en tu calendario.';
$PLG_calendar_MESSAGE26 = 'El evento ha sido borrado correctamente.';

// Messages for the plugin upgrade
$PLG_calendar_MESSAGE3001 = 'La actualización del plugin no está soportada.';
$PLG_calendar_MESSAGE3002 = $LANG32[9];

// Localization of the Admin Configuration UI
$LANG_configsections['calendar'] = array(
    'label' => 'Calendario',
    'title' => 'Configuración del calendario'
);

$LANG_confignames['calendar'] = array(
    'calendarloginrequired' => '¿Requerir inicio de sesión para el calendario?',
    'hidecalendarmenu' => '¿Ocultar el calendario del menú?',
    'personalcalendars' => '¿Activar calendarios personales?',
    'eventsubmission' => '¿Activar la cola de envíos?',
    'showupcomingevents' => '¿Mostrar próximos eventos?',
    'upcomingeventsrange' => 'Rango de próximos eventos',
    'event_types' => 'Tipos de evento',
    'hour_mode' => 'Formato horario',
    'notification' => '¿Notificación por correo electrónico?',
    'delete_event' => '¿Eliminar eventos con su propietario?',
    'aftersave' => 'Después de guardar el evento',
    'recaptcha' => 'reCAPTCHA',
    'recaptcha_score' => 'Puntuación reCAPTCHA',
    'default_permissions' => 'Permisos predeterminados de eventos',
    'autotag_permissions_event' => 'Permisos de [event: ]',
    'block_enable' => 'Activado',
    'block_isleft' => 'Mostrar el bloque a la izquierda',
    'block_order' => 'Orden del bloque',
    'block_topic_option' => 'Opciones de tema',
    'block_topic' => 'Tema',
    'block_group_id' => 'Grupo',
    'block_permissions' => 'Permisos del bloque'
);

$LANG_configsubgroups['calendar'] = array(
    'sg_main' => 'Configuración principal'
);

$LANG_tab['calendar'] = array(
    'tab_main' => 'Configuración general del calendario',
    'tab_permissions' => 'Permisos predeterminados',
    'tab_autotag_permissions' => 'Permisos de uso de autotags',
    'tab_events_block' => 'Bloque de eventos'
);

$LANG_fs['calendar'] = array(
    'fs_main' => 'Configuración general del calendario',
    'fs_permissions' => 'Permisos predeterminados',
    'fs_autotag_permissions' => 'Permisos de uso de autotags',
    'fs_block_settings' => 'Configuración del bloque',
    'fs_block_permissions' => 'Permisos del bloque'
);

// Note: entries 0, 1, 6, 9, 12 are the same as in $LANG_configselects['Core']
$LANG_configselects['calendar'] = array(
    0 => array('Sí' => 1, 'No' => 0),
    1 => array('Sí' => true, 'No' => false),
    6 => array('12' => 12, '24' => 24),
    9 => array('Ir al evento' => 'item', 'Mostrar lista de administración' => 'list', 'Mostrar calendario' => 'plugin', 'Mostrar inicio' => 'home', 'Mostrar administración' => 'admin'),
    12 => array('Sin acceso' => 0, 'Solo lectura' => 2, 'Lectura y escritura' => 3),
    13 => array('Sin acceso' => 0, 'Usar' => 2),
    14 => array('Sin acceso' => 0, 'Solo lectura' => 2),
    15 => array('Todos' => 'all', 'Solo página de inicio' => 'homeonly', 'Seleccionar temas' => 'selectedtopics'),
    16 => array('Desactivado' => 0, 'reCAPTCHA V2' => 1, 'reCAPTCHA V2 Invisible' => 2, 'reCAPTCHA V3' => 4)
);
