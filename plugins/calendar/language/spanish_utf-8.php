<?php

###############################################################################
# spanish_utf-8.php
# This is the spanish language page for the Geeklog Calendar Plug-in!
#
# Copyright (C) 2007 José R. Valverde
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
    48 => 'Hits',
    49 => 'Parece no haber ningún evento o que nadie ha visitado uno nunca.',
    50 => 'Eventos',
    51 => 'Borrar'
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
    26 => 'Delete old entries',
    27 => 'These are the events that are older than ',
    28 => ' months. Please click on the trashcan Icon on the bottom to delete them, or select a different timespan:<br' . XHTML . '>Find all entries that are older than ',
    29 => ' months.',
    30 => 'Update List',
    31 => 'Are You sure you want to permanently delete ALL selected users?',
    32 => 'List all',
    33 => 'No events selected for deletion',
    34 => 'Event ID',
    35 => 'could not be deleted',
    36 => 'Sucessfully deleted'
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
$PLG_calendar_MESSAGE3001 = 'Plugin upgrade not supported.';
$PLG_calendar_MESSAGE3002 = $LANG32[9];

// Localization of the Admin Configuration UI
$LANG_configsections['calendar'] = array(
    'label' => 'Calendar',
    'title' => 'Calendar Configuration'
);

$LANG_confignames['calendar'] = array(
    'calendarloginrequired' => 'Calendar Login Required?',
    'hidecalendarmenu' => 'Hide Calendar Menu Entry?',
    'personalcalendars' => 'Enable Personal Calendars?',
    'eventsubmission' => 'Enable Submission Queue?',
    'showupcomingevents' => 'Show upcoming Events?',
    'upcomingeventsrange' => 'Upcoming Events Range',
    'event_types' => 'Event Types',
    'hour_mode' => 'Hour Mode',
    'notification' => 'Notification Email?',
    'delete_event' => 'Delete Events with Owner?',
    'aftersave' => 'After Saving Event',
    'default_permissions' => 'Event Default Permissions'
);

$LANG_configsubgroups['calendar'] = array(
    'sg_main' => 'Main Settings'
);

$LANG_fs['calendar'] = array(
    'fs_main' => 'General Calendar Settings',
    'fs_permissions' => 'Default Permissions'
);

// Note: entries 0, 1, 6, 9, 12 are the same as in $LANG_configselects['Core']
$LANG_configselects['calendar'] = array(
    0 => array('True' => 1, 'False' => 0),
    1 => array('True' => true, 'False' => false),
    6 => array('12' => 12, '24' => 24),
    9 => array('Forward to Event' => 'item', 'Display Admin List' => 'list', 'Display Calendar' => 'plugin', 'Display Home' => 'home', 'Display Admin' => 'admin'),
    12 => array('No access' => 0, 'Read-Only' => 2, 'Read-Write' => 3)
);

?>
