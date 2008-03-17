<?php

###############################################################################
# spanish_utf-8.php
# This is the spanish language page for the Geeklog Polls Plug-in!
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

###############################################################################
# Array Format: 
# $LANGXX[YY]:	$LANG - variable name
#		  	XX - file id number
#			YY - phrase id number
###############################################################################


$LANG_POLLS = array(
    'polls'             => 'Encuestas',
    'results'           => 'Resultados',
    'pollresults'       => 'Resultados de la encuesta',
    'votes'             => 'votos',
    'vote'              => 'Voto',
    'pastpolls'         => 'Encuestas anteriores',
    'savedvotetitle'    => 'Voto guardado',
    'savedvotemsg'      => 'Se ha guardado tu voto para la encuesta',
    'pollstitle'        => 'Encuestas disponibles',
    'pollquestions'     => 'Ver otras preguntas encuestadas',
    'stats_top10'       => '10 encuestas principales',
    'stats_questions'   => 'Pregunta de la encuesta',
    'stats_votes'       => 'Votos',
    'stats_none'        => 'Parece no haber encuestas o que nadie ha votado.',
    'stats_summary'     => 'Encuestas (Respuestas) en el sistema',
    'open_poll'         => 'Abierto para votar'
);

###############################################################################
# admin/plugins/polls/index.php

$LANG25 = array(
    1 => 'Modo',
    2 => 'Por favor, introduce una pregunta y al menos una respuesta.',
    3 => 'Encuesta creada',
    4 => "Encuesta %s guardada",
    5 => 'Modificar encuesta',
    6 => 'ID de la encuesta',
    7 => '(no usar espacios)',
    8 => 'Aparece en la Página Principal',
    9 => 'Pregunta',
    10 => 'Respuesta / Votos / Aclaración',
    11 => "Ha habido un error intentando obtener los resultados de la encuesta %s",
    12 => "Hubo un error intentando consultar los resultados de la encuesta %s",
    13 => 'Crear encuesta',
    14 => 'guardar',
    15 => 'cancelar',
    16 => 'borrar',
    17 => 'Por favor, introduzca una ID para la encuesta',
    18 => 'Lista de encuestas',
    19 => 'Para modificar o borrar una encuesta, pulse en el botón de edición. Para crear una encuesta nueva, pulse en "Crear nueva".',
    20 => 'Votantes',
    21 => 'Acceso denegado',
    22 => "Está intentando acceder a una encuesta a la que no tiene derecho. Este intento ha sido guardado. Por favor <a href=\"{$_CONF['site_admin_url']}/poll.php\">regrese a la pantalla de gestión de encuestas</a>.",
    23 => 'Nueva encuesta',
    24 => 'Administración',
    25 => 'Si',
    26 => 'No',
    27 => 'Editar',
    28 => 'Enviar',
    29 => 'Buscar',
    30 => 'Limitar Resultados',
);

$PLG_polls_MESSAGE19 = 'Tu encuesta se guardó satisfactoriamente.';
$PLG_polls_MESSAGE20 = 'Tu encuesta se ha borrado satisfactoriamente.';

// Messages for the plugin upgrade
$PLG_polls_MESSAGE3001 = 'Plugin upgrade not supported.';
$PLG_polls_MESSAGE3002 = $LANG32[9];

?>
