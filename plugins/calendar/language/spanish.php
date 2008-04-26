<?php

###############################################################################
# spanish_utf-8.php
# This is the spanish language page for the Geeklog Calendar Plug-in!
#
# Copyright (C) 2007 Jos� R. Valverde
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
# $LANGXX[YY]:	$LANG - variable name
#		  	XX - file id number
#			YY - phrase id number
###############################################################################

# index.php
$LANG_CAL_1 = array(
    1 => 'Calendario',
    2 => 'Lo siento, no hay eventos que mostrar.',
    3 => 'Cu�ndo',
    4 => 'D�nde',
    5 => 'Descripci�n',
    6 => 'A�adir un evento',
    7 => 'Pr�ximos eventos',
    8 => 'Al a�adir este evento a tu calendario puedes ver r�pidamente solo los eventos que te interesen eligiendo "Mi Calendario" en el �rea de Utilidades.',
    9 => 'A�adir a Mi Calendario',
    10 => 'Eliminar de Mi Calendario',
    11 => "A�adiendo evento al Calendario de %s",
    12 => 'Evento',
    13 => 'Comienzo',
    14 => 'F�n',
    15 => 'Volver al Calendario',
    16 => 'Calendario',
    17 => 'Fecha de inicio',
    18 => 'Fecha de terminaci�n',
    19 => 'Env�os al Calendario',
    20 => 'T�tulo',
    21 => 'Fecha de inicio',
    22 => 'URL',
    23 => 'Tus Eventos',
    24 => 'Eventos Comunes',
    25 => 'No hay eventos pr�ximos',
    26 => 'Enviar un evento',
    27 => "Al enviar un evento a {$_CONF['site_name']} se incluir� en el calendario maestro desde el cual otros usuarios pueden a�adirlo optativamente a su calendario personal. Este servicio <b>NO</b> debe usarse para eventos personales tales como cumplea�os y aniversarios.<br /><br />Una vez enviado un evento �ste ser� redirigido a nuestros administradores y, si ellos lo aprueban, aparecer� en el calendario maestro.",
    28 => 'T�tulo',
    29 => 'Hora de terminaci�n',
    30 => 'Hora de inicio',
    31 => 'Dura todo el d�a',
    32 => 'Direcci�n (l�nea 1)',
    33 => 'Direcci�n (l�nea 2)',
    34 => 'Ciudad/Pueblo',
    35 => 'Provincia',
    36 => 'C�digo Postal',
    37 => 'Tipo de evento',
    38 => 'Modificar tipos de eventos',
    39 => 'Localizaci�n',
    40 => 'A�adir evento a',
    41 => 'Calendario Maestro',
    42 => 'Calendario Personal',
    43 => 'Enlace',
    44 => 'HTML no permitido',
    45 => 'Enviar',
    46 => 'Eventos en el sistema',
    47 => '10 Eventos principales',
    48 => 'Hits',
    49 => 'Parece no haber ning�n evento o que nadie ha visitado uno nunca.',
    50 => 'Eventos',
    51 => 'Borrar'
);

$_LANG_CAL_SEARCH = array(
    'results' => 'Resultados del Calendario',
    'title' => 'T�tulo',
    'date_time' => 'Fecha y Hora',
    'location' => 'Localizaci�n',
    'description' => 'Descripci�n'

);

###############################################################################
# calendar.php ($LANG30)

$LANG_CAL_2 = array(
    8 => 'A�adir evento personal',
    9 => '%s Evento',
    10 => 'Eventos para',
    11 => 'Calendario Maestro',
    12 => 'Mi Calendario',
    25 => 'Volver a ',
    26 => 'Todo el d�a',
    27 => 'Semana',
    28 => 'Calendario personal de',
    29 => 'Calendario P�blico',
    30 => 'borrar evento',
    31 => 'A�adir',
    32 => 'Evento',
    33 => 'Fecha',
    34 => 'Hora',
    35 => 'Adici�n r�pida',
    36 => 'Enviar',
    37 => 'Lo sentimos, el calendario personal no est� habilitado en este servidor.',
    38 => 'Editor de Eventos Personales',
    39 => 'D�a',
    40 => 'Semana',
    41 => 'Mes',
    42 => 'A�adir Evento Maestro',
    43 => 'Eventos Enviados',
);

###############################################################################
# admin/plugins/calendar/index.php, formerly admin/event.php ($LANG22)

$LANG_CAL_ADMIN = array(
    1 => 'Editor de Eventos',
    2 => 'Error',
    3 => 'Modo de env�o',
    4 => 'URL del Evento',
    5 => 'Fecha de inicio',
    6 => 'Fecha de terminaci�n',
    7 => 'Localizaci�n',
    8 => 'Descripci�n',
    9 => '(incluir http://)',
    10 => 'Debe proporcionar las fechas/horas, t�tulo y descripci�n',
    11 => 'Gestor del Calendario',
    12 => 'Para modificar un evento, pulse en su icono de edici�n. Para crear un evento pulse en "Crear nuevo". Pulse en el icono de copiar para crear una copia de un evento existente.',
    13 => 'Autor',
    14 => 'Fecha de inicio',
    15 => 'Fecha de terminaci�n',
    16 => '',
    17 => "Est� intentando acceder a un evento al que no tiene derecho. Este intento ha sido anotado. Por favor, <a href=\"{$_CONF['site_admin_url']}/plugins/calendar/index.php\">la pantalla de administraci�n de eventos</a>.",
    18 => '',
    19 => '',
    20 => 'guardar',
    21 => 'cancelar',
    22 => 'borrar',
    23 => 'Fecha de inicio err�nea.',
    24 => 'Fecha de terminaci�n err�nea.',
    25 => 'La fecha de terminaci�n antecede a la de inicio.'
);

$LANG_CAL_MESSAGE = array(
    'save'      => 'Tu evento se ha guardado correctamente.',
    'delete'    => 'El evento se ha borrado correctamente.',
    'private'   => 'El evento se ha guardado en tu calendario',
    'login'     => 'No puedes abrir tu calendario personal hasta que te identifiques',
    'removed'   => 'El evento se ha eliminado correctamente de tu calendario personal.',
    'noprivate' => 'Lo sentimos, pero los calendarios personales no est�n habilitados en este servidor.',
    'unauth'    => 'Lo sentimos, pero no tienes acceso a la p�gina de administraci�n de eventos. Te avisamos de que todos los intentos de acceder a caracter�sticas no autorizadas se guardan.',
);

$PLG_calendar_MESSAGE4  = "Gracias por enviar un evento a {$_CONF['site_name']}.  Lo hemos redirigido a nuestros administradores para que lo aprueben. Si se aprueba aparecer� aqui, en nuestra secci�n de <a href=\"{$_CONF['site_url']}/calendar/index.php\">calendario</a>.";
$PLG_calendar_MESSAGE17 = 'Tu evento ha sido guardado correctamente.';
$PLG_calendar_MESSAGE18 = 'El evento ha sido borrado correctamente.';
$PLG_calendar_MESSAGE24 = 'El evento ha sido guardado en tu calendario.';
$PLG_calendar_MESSAGE26 = 'El evento ha sido borrado correctamente.';

// Messages for the plugin upgrade
$PLG_calendar_MESSAGE3001 = 'Plugin upgrade not supported.';
$PLG_calendar_MESSAGE3002 = $LANG32[9];

?>
