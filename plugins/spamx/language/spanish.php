<?php

/**
 * File: spanish.php
 * This is the Spanish language page for the Geeklog Spam-X Plug-in!
 * 
 * Copyright (C) 2004-2005 by the following authors:
 * Author        Tom Willett        tomw AT pigstye DOT net
 * 
 * Licensed under GNU General Public License
 *
 * $Id: spanish.php,v 1.9 2008/05/02 15:08:10 dhaun Exp $
 */

global $LANG32;

$LANG_SX00 = array(
    'inst1' => '<p>Si haces esto, los demás ',
    'inst2' => 'podrán ver e importar tu lista negra personal y nosotros podemos crear una base de datos ',
    'inst3' => 'distribuida más eficaz.</p><p>Si has registrado tu sitio web y decides que no deseas permanecer en la lista ',
    'inst4' => 'envía un correo electrónico a <a href="mailto:spamx@pigstye.net">spamx@pigstye.net</a> para comunicármelo. ',
    'inst5' => 'Todas las peticiones serán respetadas.',
    'submit' => 'Enviar',
    'subthis' => 'esta información a la base de datos de Spam-X Central Database',
    'secbut' => 'Este botón segundo crea una fuente rdf para que otras personas puedan importar tu lista.',
    'sitename' => 'Nombre del Sitio: ',
    'URL' => 'URL a la lista de Spam-X: ',
    'RDF' => 'RDF url: ',
    'impinst1a' => 'Antes de usar la característica de bloqueo de Spam con el comentario de Spam-X para ver e importar Listas negras personales de otros ',
    'impinst1b' => ' sitios, te pido que pulses sobre los siguientes dos botones. (Tienes que pulsar sobre el último.)',
    'impinst2' => 'Este primero envía tu sitio web al sitio Gplugs/Spam-X para que pueda añadirse al listado principal de ',
    'impinst2a' => 'sitios que comparten sus listas negras. (Nota: Si tienes varios sitios puede que te interese designar uno de ellos como el ',
    'impinst2b' => 'principal y sólo  incluir su nombre. Esto te permitirá actualizar tus sitios con facilidad y mantener una lista más pequeña.) ',
    'impinst2c' => 'Después de pulsar sobre el botón de Enviar, pulsa sobre [atrás]en tu navegador para volver aquí.',
    'impinst3' => 'Se enviarán los siguientes valores: (puedes editarlos si están equivocados).',
    'availb' => 'Listas Negras Disponibles',
    'clickv' => 'Cliquea para ver la Lista Negra',
    'clicki' => 'Cliquea para Importar la Lista Negra',
    'ok' => 'OK',
    'rsscreated' => 'Se creó la fuente RSS',
    'add1' => 'Se han Añadido ',
    'add2' => ' datos desde ',
    'add3' => 'la lista negra de  .',
    'adminc' => 'Comandos de Administración:',
    'mblack' => 'Mi Lista Negra:',
    'rlinks' => 'Enlaces Relacionados:',
    'e3' => 'Para añadir las palabras desde la lista de palabras censuradas de Geeklogs CensorList Pulsa el Botón:',
    'addcen' => 'Añadir Lista de Palabras Censuradas',
    'addentry' => 'Añadir dato',
    'e1' => 'Para Borrar el dato cliquéalo.',
    'e2' => 'Para Añadir un dato, introdúcelo en la caja y pulsa sobre Añadir.  Los datos pueden presentarse con Expresiones Normales de Perl.',
    'pblack' => 'Lista Negra Personal de Spam-X',
    'conmod' => 'Configurar el uso del módulo de Spam-X',
    'acmod' => 'Módulos de Acción de Spam-X',
    'exmod' => 'Módulos de Examen de Spam-X',
    'actmod' => 'Módulos Activos',
    'avmod' => 'Módulos Disponibles',
    'coninst' => '<hr' . XHTML . '>Cliquea sobre un Módulo Activo para borrarlo, cliquea sobre un módulo Disponible para añadirlo.<br' . XHTML . '>Los módulos se ejecutan en el orden en que han sido presentados.',
    'fsc' => 'Encontrado un comentario de Spam coincidente',
    'fsc1' => ' enviado por el usuario ',
    'fsc2' => ' desde el IP ',
    'uMTlist' => 'Actualizar la Lista Negra-MT',
    'uMTlist2' => ': Añadidas ',
    'uMTlist3' => ' entradas y borradas ',
    'entries' => ' entradas.',
    'uPlist' => 'Actualizar la Lista Negra Personal',
    'entriesadded' => 'Entradas Añadidas',
    'entriesdeleted' => 'Entradas Borradas',
    'viewlog' => 'Ver el registro de Spam-X',
    'clearlog' => 'Limpiar el fichero de Registros',
    'logcleared' => '- Fichero de Registros limpiado',
    'plugin' => 'Plugin',
    'access_denied' => 'Acceso Denegado',
    'access_denied_msg' => 'Sólo los Usuarios Raíz tiene Acceso a esta página.  Tu nombre de usuario y dirección IP han sido registrados.',
    'admin' => 'Plugin de Administración',
    'install_header' => 'Plugin de Instalar/Desinstalar ',
    'installed' => 'Se ha instalado el Plugin',
    'uninstalled' => 'No se ha instalado el Plugin',
    'install_success' => 'Se ha instalado con éxito',
    'install_failed' => 'Instalación Fallida -- Lee tu registro de errores para averiguar por qué.',
    'uninstall_msg' => 'Se ha desinstalado el Plugin con éxito',
    'install' => 'Instalar',
    'uninstall' => 'Desinstalar',
    'warning' => 'Aviso! El Plugin está aún habilitado',
    'enabled' => 'Deshabilite el plugin antes de desinstalar.',
    'readme' => 'DETENTE! Antes de pulsar sobre instalar, por favor lee el ',
    'installdoc' => 'Documento de Instalación.',
    'spamdeleted' => 'Comentario de Spam borrado',
    'foundspam' => 'Encontrado comentario de Spam coincidente ',
    'foundspam2' => ' enviado por el usuario ',
    'foundspam3' => ' desde el IP ',
    'deletespam' => 'Borrar Spam',
    'numtocheck' => 'Número de Comentarios a comprobar',
    'note1' => '<p>Nota: Borrado masivo está para ayudarte cuando te avasalla ',
    'note2' => ' comentarios de spam y Spam-X no lo pilla.  <ul><li>Primero, encuentra el/los enlace/s u otros ',
    'note3' => 'identificadores de este comentario de Spam y lo añades a tu lista negra personal.</li><li>Después ',
    'note4' => 'vuelve aquí y haz que Spam-X compruebe los últimos comentarios de spam.</li></ul><p>Los comentarios ',
    'note5' => 'se comprueban desde los más nuevos hasta los más antiguos -- La comprobación de más comentarios ',
    'note6' => 'requiere más tiempo para llevarse a cabo</p>',
    'masshead' => '<hr' . XHTML . '><center><h1>Borrado Masivo de Comentarios Spam</h1></center>',
    'masstb' => '<hr' . XHTML . '><h1 align="center">Mass Delete Trackback Spam</h1>',
    'comdel' => ' comentarios borrados.',
    'initial_Pimport' => '<p>Importar la Lista Negra Personal"',
    'initial_import' => 'Importar la lista Negra-MT inicial',
    'import_success' => '<p>Se ha importado con éxito los datos de la Lista Negra de %d.',
    'import_failure' => '<p><strong>Error:</strong> No se han encontrado datos.',
    'allow_url_fopen' => '<p>Lo sentimos, la configuración de tu servidor de web no permite la lectura de ficheros remotos (<code>allow_url_fopen</code> is off). Por favor, descarga la Lista Negra desde el siguiente URL y súbelo al directorio de "datos" de Geeklog\'s, <tt>%s</tt>, antes de intentarlo de nuevo:',
    'documentation' => 'Documentación del Plugin de Spam-X',
    'emailmsg' => "Un nuevo comentario de spam ha sido enviado en/desde \"%s\"\nUser UID:\"%s\"\n\nContent:\"%s\"",
    'emailsubject' => 'Spam post at %s',
    'ipblack' => 'Spam-X IP Blacklist',
    'ipofurlblack' => 'Spam-X IP of URL Blacklist',
    'headerblack' => 'Spam-X HTTP Header Blacklist',
    'headers' => 'Request headers:',
    'stats_headline' => 'Spam-X Statistics',
    'stats_page_title' => 'Blacklist',
    'stats_entries' => 'Entries',
    'stats_mtblacklist' => 'MT-Blacklist',
    'stats_pblacklist' => 'Personal Blacklist',
    'stats_ip' => 'Blocked IPs',
    'stats_ipofurl' => 'Blocked by IP of URL',
    'stats_header' => 'HTTP headers',
    'stats_deleted' => 'Posts deleted as spam',
    'plugin_name' => 'Spam-X',
    'slvwhitelist' => 'SLV Whitelist'
);

// Define Messages that are shown when Spam-X module action is taken
$PLG_spamx_MESSAGE128 = 'Se ha detectado spam y se ha borrado el Comentario o el Mensaje.';
$PLG_spamx_MESSAGE8 = 'Se ha detectado spam. Se ha enviado un correo al administrador.';

// Messages for the plugin upgrade
$PLG_spamx_MESSAGE3001 = 'Plugin upgrade not supported.';
$PLG_spamx_MESSAGE3002 = $LANG32[9];

// Localization of the Admin Configuration UI
$LANG_configsections['spamx'] = array(
    'label' => 'Spam-X',
    'title' => 'Spam-X Configuration'
);

$LANG_confignames['spamx'] = array(
    'action' => 'Spam-X Actions',
    'notification_email' => 'Notification Email',
    'logging' => 'Enable Logging',
    'timeout' => 'Timeout'
);

$LANG_configsubgroups['spamx'] = array(
    'sg_main' => 'Main Settings'
);

$LANG_fs['spamx'] = array(
    'fs_main' => 'Spam-X Main Settings'
);

// Note: entries 0, 1, 9, and 12 are the same as in $LANG_configselects['Core']
$LANG_configselects['spamx'] = array(
    0 => array('True' => 1, 'False' => 0),
    1 => array('True' => true, 'False' => false)
);

?>
