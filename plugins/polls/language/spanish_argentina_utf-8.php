<?php

###############################################################################
# spanish_argentina_utf-8.php
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

global $LANG32;

###############################################################################
# Array Format:
# $LANGXX[YY]:  $LANG - variable name
#               XX    - file id number
#               YY    - phrase id number
###############################################################################

$LANG_POLLS = array(
    'polls' => 'Encuestas',
    'poll' => 'Encuesta',
    'results' => 'Resultados',
    'pollresults' => 'Resultados de la encuesta',
    'votes' => 'votos',
    'voters' => 'votantes',
    'vote' => 'Voto',
    'pastpolls' => 'Encuestas anteriores',
    'savedvotetitle' => 'Voto guardado',
    'savedvotemsg' => 'Se ha guardado tu voto para la encuesta',
    'pollstitle' => 'Encuestas disponibles',
    'polltopics' => 'Otras encuestas',
    'stats_top10' => '10 encuestas principales',
    'stats_topics' => 'Tema de la encuesta',
    'stats_votes' => 'Votos',
    'stats_none' => 'Parece no haber encuestas o que nadie ha votado.',
    'stats_summary' => 'Encuestas (Respuestas) en el sistema',
    'open_poll' => 'Abierto para votar',
    'answer_all' => 'Responda todas las preguntas restantes',
    'not_saved' => 'Resultado no guardado',
    'upgrade1' => 'Ha instalado una nueva versión del plugin Polls. Por favor',
    'upgrade2' => 'actualice',
    'editinstructions' => 'Indique el ID de la encuesta, al menos una pregunta y dos respuestas.',
    'pollclosed' => 'Esta encuesta está cerrada para votar.',
    'pollhidden' => 'Ya ha votado. Los resultados se mostrarán cuando finalice la votación.',
    'start_poll' => 'Iniciar encuesta',
    'no_new_polls' => 'No hay encuestas nuevas',
    'autotag_desc_poll' => '[poll: id título alternativo] - Muestra un enlace a una encuesta usando su tema como título. El título alternativo es opcional.',
    'autotag_desc_poll_vote' => '[poll_vote: id class:poll-autotag showall:1] - Muestra una encuesta para votar. class y showall son opcionales. class define la clase CSS y showall:1 muestra todas las preguntas.',
    'autotag_desc_poll_result' => '[poll_result: id class:poll-autotag] - Muestra los resultados de la encuesta. class es opcional y define la clase CSS.',
    'deny_msg' => 'Acceso denegado a esta encuesta. Puede haber sido movida o eliminada, o no dispone de permisos suficientes.'
);

###############################################################################
# admin/plugins/polls/index.php

$LANG25 = array(
    1 => 'Modo',
    2 => 'Introduzca un tema, al menos una pregunta y una respuesta.',
    3 => 'Encuesta creada',
    4 => 'Encuesta %s guardada',
    5 => 'Editar encuesta',
    6 => 'ID de encuesta',
    7 => '(no use espacios)',
    8 => 'Aparece en el bloque de encuestas',
    9 => 'Tema',
    10 => 'Respuestas / Votos / Observación',
    11 => 'Se produjo un error al obtener los datos de respuestas de la encuesta %s',
    12 => 'Se produjo un error al obtener los datos de preguntas de la encuesta %s',
    13 => 'Crear encuesta',
    14 => 'guardar',
    15 => 'cancelar',
    16 => 'eliminar',
    17 => 'Introduzca un ID de encuesta',
    18 => 'Lista de encuestas',
    19 => 'Para modificar o eliminar una encuesta, haga clic en su icono de edición. Para crear una encuesta nueva, haga clic en «Crear nueva».',
    20 => 'Votantes',
    21 => 'Acceso denegado',
    22 => "Está intentando acceder a una encuesta para la que no tiene permisos. Este intento ha sido registrado. <a href=\"{$_CONF['site_admin_url']}/poll.php\">Vuelva a la administración de encuestas</a>.",
    23 => 'Nueva encuesta',
    24 => 'Inicio de administración',
    25 => 'Sí',
    26 => 'No',
    27 => 'Editar',
    28 => 'Enviar',
    29 => 'Buscar',
    30 => 'Limitar resultados',
    31 => 'Pregunta',
    32 => 'Para eliminar esta pregunta de la encuesta, borre su texto',
    33 => 'Abierta para votar',
    34 => 'Tema de la encuesta:',
    35 => 'Esta encuesta tiene',
    36 => 'más preguntas.',
    37 => 'Ocultar resultados mientras la encuesta esté abierta',
    38 => 'Mientras la encuesta esté abierta, solo el propietario y root pueden ver los resultados',
    39 => 'El tema solo se mostrará si hay más de una pregunta.',
    40 => 'Ver todas las respuestas de esta encuesta',
    1001 => 'Permitir varias respuestas',
    1002 => 'Descripción',
    1003 => 'Descripción'
);

$PLG_polls_MESSAGE15 = 'Su comentario se ha enviado para revisión y se publicará cuando lo apruebe un moderador.';
$PLG_polls_MESSAGE19 = 'Tu encuesta se guardó satisfactoriamente.';
$PLG_polls_MESSAGE20 = 'Tu encuesta se ha borrado satisfactoriamente.';

// Messages for the plugin upgrade
$PLG_polls_MESSAGE3001 = 'La actualización del plugin no está soportada.';
$PLG_polls_MESSAGE3002 = $LANG32[9];

// Localization of the Admin Configuration UI
$LANG_configsections['polls'] = array(
    'label' => 'Polls',
    'title' => 'Polls Configuration'
);

$LANG_confignames['polls'] = array(
    'pollsloginrequired' => 'Polls Login Required?',
    'hidepollsmenu' => 'Hide Polls Menu Entry?',
    'maxquestions' => 'Max. Questions per Poll',
    'maxanswers' => 'Max. Options per Question',
    'answerorder' => 'Sort Results ...',
    'pollcookietime' => 'Voter Cookie valid for',
    'polladdresstime' => 'Voter IP Address valid for',
    'delete_polls' => 'Delete Polls with Owner?',
    'aftersave' => 'After Saving Poll',
    'default_permissions' => 'Poll Default Permissions',
    'autotag_permissions_poll' => '[poll: ] Permissions',
    'autotag_permissions_poll_vote' => '[poll_vote: ] Permissions',
    'autotag_permissions_poll_result' => '[poll_result: ] Permissions',
    'newpollsinterval' => 'New Polls Interval',
    'hidenewpolls' => 'New Polls',
    'title_trim_length' => 'Title Trim Length',
    'meta_tags' => 'Enable Meta Tags',
    'likes_polls' => 'Poll Likes',
    'block_enable' => 'Enabled',
    'block_isleft' => 'Display Block on Left',
    'block_order' => 'Block Order',
    'block_topic_option' => 'Topic Options',
    'block_topic' => 'Tema',
    'block_group_id' => 'Group',
    'block_permissions' => 'Permissions'
);

$LANG_configsubgroups['polls'] = array(
    'sg_main' => 'Main Settings'
);

$LANG_tab['polls'] = array(
    'tab_main' => 'General Polls Settings',
    'tab_whatsnew' => 'What\'s New Block',
    'tab_permissions' => 'Default Permissions',
    'tab_autotag_permissions' => 'Autotag Usage Permissions',
    'tab_poll_block' => 'Poll Block'
);

$LANG_fs['polls'] = array(
    'fs_main' => 'General Polls Settings',
    'fs_whatsnew' => 'What\'s New Block',
    'fs_permissions' => 'Default Permissions',
    'fs_autotag_permissions' => 'Autotag Usage Permissions',
    'fs_block_settings' => 'Block Settings',
    'fs_block_permissions' => 'Block Permissions'
);

// Note: entries 0, 1, and 12 are the same as in $LANG_configselects['Core']
$LANG_configselects['polls'] = array(
    0 => array('True' => 1, 'False' => 0),
    1 => array('True' => true, 'False' => false),
    2 => array('As Submitted' => 'submitorder', 'By Votes' => 'voteorder'),
    5 => array('Hide' => 'hide', 'Show - Use Modified Date' => 'modified', 'Show - Use Created Date' => 'created'),
    9 => array('Forward to Poll' => 'item', 'Display Admin List' => 'list', 'Display Public List' => 'plugin', 'Display Home' => 'home', 'Display Admin' => 'admin'),
    12 => array('No access' => 0, 'Read-Only' => 2, 'Read-Write' => 3),
    13 => array('No access' => 0, 'Use' => 2),
    14 => array('No access' => 0, 'Read-Only' => 2),
    15 => array('All' => 'all', 'Homepage Only' => 'homeonly', 'Select Topics' => 'selectedtopics'),
    41 => array('False' => 0, 'Likes and Dislikes' => 1, 'Likes Only' => 2)
);
