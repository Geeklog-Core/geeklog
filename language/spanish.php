<?php

###############################################################################
# This is the spanish language page for GeekLog!
#
# Copyright (C) 2000 Jason Whittenburg
# jwhitten@securitygeeks.com
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

$LANG_CHARSET = 'iso-8859-1';

###############################################################################
# Array Format:
# $LANGXX[YY]:  $LANG - variable name
#               XX    - file id number
#               YY    - phrase id number
###############################################################################

###############################################################################
# USER PHRASES - These are file phrases used in end user scripts
###############################################################################

###############################################################################
# lib-common.php

$LANG01 = array(
    1 => 'Autor:',
    2 => 'leer art�culo completo',
    3 => 'comentarios',
    4 => 'Editar',
    5 => 'Votar',
    6 => 'Resultados',
    7 => 'Resultados de la encuesta',
    8 => 'votos',
    9 => 'Funciones del(a) Administrador(a):',
    10 => 'Propuestas',
    11 => 'Noticias',
    12 => 'Bloques',
    13 => 'Secciones',
    14 => 'Enlaces',
    15 => 'Eventos',
    16 => 'Encuestas',
    17 => 'Usuarios(as)',
    18 => 'B�squeda SQL',
    19 => 'Salir',
    20 => 'Informaci�n del(a) usuario(a):',
    21 => 'Nombre del(a) usuario(a)',
    22 => 'Identidad (ID) del(a) usuario(a)',
    23 => 'Nivel de Seguridad',
    24 => 'An�nimo',
    25 => 'Responder',
    26 => 'Los siguientes comentarios son de la persona que los haya enviado. Este sitio no se hace responsable de las opiniones expresadas por los participantes en los foros y secciones de comentarios, y el hecho de publicar las mismas no significa que est� de acuerdo con ellas.',
    27 => 'Comentario m�s reciente',
    28 => 'Borrar',
    29 => 'No hay comentarios de los usuarios.',
    30 => 'Noticias anteriores',
    31 => 'Etiquetas de HTML permitidas:',
    32 => 'Error, usuario inv�lido',
    33 => 'Error, no fue posible escribir el registro',
    34 => 'Error',
    35 => 'Salir',
    36 => 'sobre',
    37 => 'No hay noticias del(a) usuario(a)',
    38 => 'Content Syndication',
    39 => 'Actualizar',
    40 => 'You have <tt>register_globals = Off</tt> in your <tt>php.ini</tt>. However, Geeklog requires <tt>register_globals</tt> to be <strong>on</strong>. Before you continue, please set it to <strong>on</strong> and restart your web server.',
    41 => 'Usuarios Invitados',
    42 => 'Escrito por:',
    43 => 'Responder a',
    44 => 'Retornar',
    45 => 'N�mero de Error MySQL',
    46 => 'Mensaje de Error MySQL',
    47 => 'Funciones del(a) usuario(a)',
    48 => 'Mi cuenta',
    49 => 'Mis Preferencias',
    50 => 'Error en una sentencia SQL',
    51 => 'ayuda',
    52 => 'Nuevo',
    53 => 'Secci�n de Administraci�n',
    54 => 'No se ha podido abrir el archivo.',
    55 => 'Error en',
    56 => 'Votar',
    57 => 'Contrase�a',
    58 => 'Identificaci�n',
    59 => "�No tienes una cuenta todav�a? <a href=\"{$_CONF['site_url']}/users.php?mode=new\">Inscr�bete</a>",
    60 => 'Agregar un comentario',
    61 => 'Crear una Nueva Cuenta',
    62 => 'palabras',
    63 => 'Preferencias de Noticias',
    64 => 'Enviar a un(a) amigo(a)',
    65 => 'Ver la versi�n para imprimir',
    66 => 'Mi Calendario',
    67 => 'Bienvenido(a) a ',
    68 => 'P�gina Inicial',
    69 => 'contacto',
    70 => 'buscar',
    71 => 'enviar noticia',
    72 => 'enlaces a otras webs',
    73 => 'encuestas anteriores',
    74 => 'calendario',
    75 => 'b�squeda avanzada',
    76 => 'estad�sticas del sitio',
    77 => 'Plugins',
    78 => 'Pr�ximos Eventos',
    79 => 'Novedades',
    80 => 'noticias',
    81 => 'noticia',
    82 => 'horas',
    83 => 'COMENTARIOS',
    84 => 'ENLACES',
    85 => '�ltimas 48 horas',
    86 => 'No hay nuevos comentarios',
    87 => '�ltimas 2 semanas',
    88 => 'No hay nuevos enlaces',
    89 => 'No hay pr�ximos eventos',
    90 => 'P�gina Inicial',
    91 => 'Esta p�gina fue creada en',
    92 => 'segundos',
    93 => 'Derechos de autor',
    94 => 'Todas las marcas y derechos en esta p�gina son de sus respectivos due�os.',
    95 => 'Otra web montada con',
    96 => 'Grupos',
    97 => 'Lista de Palabras',
    98 => 'Plug-ins',
    99 => 'NOTICIAS',
    100 => 'No hay noticias nuevas',
    101 => 'Mis Eventos',
    102 => 'Eventos del sitio',
    103 => 'Copias de seguridad de la Base de Datos',
    104 => 'por',
    105 => 'Usuarios del Correo',
    106 => 'Vistas',
    107 => 'Comprobaci�n de la versi�n de GL',
    108 => 'Limpiar copia de visitas (Cach�)'
);

###############################################################################
# calendar.php

$LANG02 = array(
    1 => 'Calendario de Eventos',
    2 => 'Disculpa, no hay eventos para mostrar.',
    3 => 'Cuando',
    4 => 'Donde',
    5 => 'Descripci�n',
    6 => 'Agregar un Evento',
    7 => 'Pr�ximos Eventos',
    8 => 'Al agregar este evento a tu calendario podr�s ver r�pidamente los eventos que te interesen. Para ello elije "Mi Calendario" en el �rea de Funciones del(a) usuario(a).',
    9 => 'Agregar a Mi Calendario',
    10 => 'Sacar de Mi Calendario',
    11 => "Agregando el Evento al Calendario de {$_USER['username']}",
    12 => 'Evento',
    13 => 'Empieza',
    14 => 'Termina',
    15 => 'Volver al Calendario'
);

###############################################################################
# comment.php

$LANG03 = array(
    1 => 'Agregar un Comentario',
    2 => 'Tipo de envio',
    3 => 'Salir',
    4 => 'Crear una Cuenta',
    5 => 'Nombre del(a) usuario(a)',
    6 => 'Este sitio requiere que tengas una cuenta para enviar un comentario. Si ya la tienes, ingresa el nombre de usuario y la contrase�a. Si no tienes una cuenta, puedes crear una nueva en el formulario de abajo',
    7 => 'Tu �ltimo comentario fue hace ',
    8 => " segundos. Este sitio requiere al menos {$_CONF['commentspeedlimit']} segundos entre comentarios",
    9 => 'Comentario',
    10 => '',
    11 => 'Enviar el Comentario',
    12 => 'Por favor completa el T�tulo y Comentario, ya que son datos necesarios para enviar un comentario.',
    13 => 'Tu Informaci�n',
    14 => 'Vista Previa',
    15 => '',
    16 => 'T�tulo',
    17 => 'Error',
    18 => 'Cosas Importantes',
    19 => 'Por favor intenta mantener el tema de la noticia.',
    20 => 'Intenta responder a los comentarios de los dem�s en lugar de comenzar una nueva discusi�n.',
    21 => 'Lee los comentarios enviados para evitar comentarios duplicados.',
    22 => 'Utiliza un t�tulo claro que describa el contenido de tu mensaje.',
    23 => 'Tu direcci�n de correo electr�nico NO ser� divulgada.',
    24 => 'Usuario An�nimo'
);

###############################################################################
# users.php

$LANG04 = array(
    1 => 'Perfil del(a) usuario(a) para',
    2 => 'Nombre del(a) usuario(a)',
    3 => 'Nombre Completo',
    4 => 'Contrase�a',
    5 => 'Correo electr�nico',
    6 => 'P�gina personal',
    7 => 'Biograf�a',
    8 => 'Clave PGP',
    9 => 'Guardar la Informaci�n',
    10 => '�ltimos 10 comentarios',
    11 => 'No hay comentarios',
    12 => 'Preferencias del(a) usuario(a) para',
    13 => 'Enviar un resumen cada noche por correo electr�nico',
    14 => 'Esta contrase�a se genera al azar. Se recomienda que cambies la contrase�a cuanto antes. Para cambiar la contrase�a conecta al sitio con tu nombre de usuario.',
    15 => "Tu cuenta en {$_CONF['site_name']} se ha creado satisfactoriamente. Para poder utilizarla tienes que ingresar utilizando los datos dados m�s abajo. Guarda este mensaje para futuras referencias.",
    16 => 'Informaci�n de tu cuenta',
    17 => 'La cuenta no existe',
    18 => 'La direcci�n de correo electr�nico ingresada no parece ser v�lida.',
    19 => 'el(la) usuario(a) y la direcci�n de correo electr�nico ingresados ya existen',
    20 => 'La direcci�n de correo electr�nico ingresada no parece ser v�lida.',
    21 => 'Error',
    22 => "Inscr�bete en {$_CONF['site_name']}!",
    23 => "Crear una cuenta te dar� los beneficios de los usuarios de {$_CONF['site_name']} y te permitir� enviar noticias, comentarios, etc. Si no tienes una cuenta s�lo lo podr�s hacer an�nimamente. Queremos remarcar que tu direcci�n de correo electr�nico <b><i>nunca</i></b> ser� publicada en este sitio.",
    24 => 'Tu Contrase�a se enviar� a la direcci�n de correo electr�nico que ingreses.',
    25 => '�Olvidaste tu contrase�a?',
    26 => 'Ingresa <em>o</em> tu nombre de usuario <em>o</em> la direcci�n de correo electr�nico que utilizaste para inscribirte y pulsa Enviar Contrase�a. Te llegar�n por correo electr�nico las instrucciones para crear una contrase�a nueva a la direcci�n que figura en el archivo,.',
    27 => '�Inscr�bete ahora!',
    28 => 'Enviar la contrase�a por correo electr�nico',
    29 => 'desconectado(a) de',
    30 => 'conectado(a) a',
    31 => 'La funci�n que has elegido requiere que est�s conectado(a)',
    32 => 'Firma',
    33 => 'No se mostrar� p�blicamente',
    34 => 'Este es tu nombre de verdad',
    35 => 'Ingresa la contrase�a para cambiarla',
    36 => 'Comienza con http://',
    37 => 'Se aplica a tus comentarios',
    38 => '�Todo sobre Ti! Todos van a poder leer esto.',
    39 => 'Tu clave p�blica de PGP para compartir',
    40 => 'Sin iconos de secciones',
    41 => 'Intenci�n de moderar',
    42 => 'Formato de fecha',
    43 => 'Cantidad m�xima de noticias',
    44 => 'Sin recuadros',
    45 => 'Mostrar las preferencias de',
    46 => 'Elementos exclu�dos de',
    47 => 'Configuraci�n de Noticias para',
    48 => 'Secciones',
    49 => 'Sin iconos en las noticias',
    50 => 'No selecciones esto si no est�s interesado',
    51 => 'S�lo las noticias nuevas',
    52 => 'El valor por defecto es',
    53 => 'Recibir cada noche las noticias del d�a',
    54 => 'Selecciona las Secciones y Autores que no quieres ver.',
    55 => 'Si no seleccionas ninguna significa que quieres la selecci�n por defecto. De seleccionar, selecciona todas las de tu inter�s ya que las opciones por defecto ya no ser�n tomadas en cuenta. Las opciones por defecto se muestran resaltadas.',
    56 => 'Autores',
    57 => 'Modo de Presentaci�n',
    58 => 'Orden de clasificaci�n',
    59 => 'L�mite por Comentario',
    60 => '�C�mo quieres ver los comentarios?',
    61 => '�Primero los m�s antiguos o los m�s recientes?',
    62 => 'El valor por defecto es 100',
    63 => "Gracias por utilizar {$_CONF['site_name']}. Te hemos enviado tu contrase�a por correo electr�nico y llegar� en unos instantes. Por favor sigue las instrucciones del mensaje.",
    64 => 'Preferencias para los comentarios de',
    65 => 'Intenta reconectarte otra vez',
    66 => "Los datos ingresados no son v�lidos. Intenta reconectar abajo. �Eres un <a href=\"{$_CONF['site_url']}/users.php?mode=new\">usuario(a) nuevo(a)</a>?",
    67 => 'Miembro desde',
    68 => 'Recu�rdame durante',
    69 => '�Cu�nto tiempo tenemos que mantener tu nombre de usuario(a) en activo despu�s de conectar?',
    70 => "Personaliza la apariencia y el contenido de {$_CONF['site_name']}",
    71 => "Una de las grandes virtudes de {$_CONF['site_name']} es que puedes personalizar el contenido que recibes y la apariencia del sitio. Para poder lograr esto tienes primero que <a href=\"{$_CONF['site_url']}/users.php?mode=new\"> inscribirte</a> en {$_CONF['site_name']}. Si ya eres miembro, utiliza el formulario de la izquierda para conectarte.",
    72 => 'Tema',
    73 => 'Idioma',
    74 => '�Cambia la apariencia de esta p�gina!',
    75 => 'Secciones enviadas por correo electr�nico a',
    76 => 'Si seleccionas una o m�s Secciones de la lista de abajo, todas las noticias nuevas de esas Secciones te ser�n enviadas por correo electr�nico al finalizar el d�a.',
    77 => 'Foto',
    78 => '�A�ade una foto tuya!',
    79 => 'Activa esto para borrar esta imagen',
    80 => 'Identificaci�n',
    81 => 'Enviar correo electr�nico',
    82 => '�ltimas 10 noticias para el(la) usuario(a)',
    83 => 'Estad�sticas de noticias para el(la) usuario(a)',
    84 => 'N�mero total de art�culos:',
    85 => 'N�mero total de comentarios:',
    86 => 'Buscar todos los comentarios de',
    87 => 'Tu nombre de acceso',
    88 => "Alguien (posiblemente t� mismo(a)) ha solicitado una contrase�a nueva para tu cuenta  \"%s\" en {$_CONF['site_name']}, <{$_CONF['site_url']}>.\n\nSi quieres de verdad que se lleve a cabo esta acci�n, por favor pulsa en el enlace siguiente:\n\n",
    89 => "si no quieres que se lleve a cabo esta acci�n, simplemente ignora este mensaje y la petici�n sera desatendida (tu contrase�a no se modificar�).\n\n",
    90 => 'Puedes ingresar abajo una contrase�a nueva para tu cuenta. Por favor, toma nota que la contrase�a antigua seguir� siendo v�lida hasta que envies este formulario.',
    91 => 'Crear Contrase�a Nueva',
    92 => 'Ingresar Contrase�a Nueva',
    93 => 'Tu �ltima petici�n de una contrase�a nueva fue hace %d segundos. Este sitio requiere como m�nimo %d segundos entre peticiones de contrase�as.',
    94 => 'Borrar la cuenta "%s"',
    95 => 'Pulsar abajo el bot�n "borrar la cuenta" para retirar tu cuenta de nuestra base de datos. Por favor, toma nota que cualquier noticia o comentario que hayas contribu�do bajo esta cuenta <strong>no</strong> se borrar�, sino que aparecer� como "An�nimo".',
    96 => 'borrar la cuenta',
    97 => 'Confirmar el borrado de la Cuenta',
    98 => '�Est�s seguro(a) que quieres borrar tu cuenta? Al hacerlo as�, no podr�s acceder a este sitio otra vez (a no ser que crees una cuenta nueva). Si est�s seguro(a), pulsa "borrar cuenta" de nuevo en el formulario de abajo.',
    99 => 'Opciones de privacidad para',
    100 => 'Correo del(a) Administrador(a)',
    101 => 'Permitir correo de los(as) Administradores(as) del sitio',
    102 => 'Correo de los usuarios',
    103 => 'Permitir correo de otros usuarios',
    104 => 'Mostrar el estado de quien est� conectado(a)',
    105 => 'Mostrar en el bloque Who\'s Online (usuarios conectados)'
);

###############################################################################
# index.php

$LANG05 = array(
    1 => 'No hay novedades para mostrar',
    2 => 'No hay nuevas noticias para mostrar. Puede que no haya novedades para esta Secci�n o que tus preferencias sean muy restrictivas.',
    3 => "para la Secci�n %s",
    4 => 'Noticia del D�a',
    5 => 'Siguiente',
    6 => 'Anterior'
);

###############################################################################
# links.php

$LANG06 = array(
    1 => 'Enlaces',
    2 => 'No hay enlaces para mostrar.',
    3 => 'Agregar un enlace'
);

###############################################################################
# pollbooth.php

$LANG07 = array(
    1 => 'Voto guardado',
    2 => 'Tu voto se ha computado para la encuesta',
    3 => 'Vota',
    4 => 'Encuestas en el sistema',
    5 => 'Votos',
    6 => 'Ver las otras preguntas de la encuesta'
);

###############################################################################
# profiles.php

$LANG08 = array(
    1 => 'Hubo un error al enviar tu mensaje. Int�ntalo de nuevo por favor.',
    2 => 'El mensaje fue enviado satisfactoriamente.',
    3 => 'Por favor aseg�rate de ingresar una direcci�n de correo electr�nico v�lida en el campo \'Responder a\'.',
    4 => 'Por favor completa los campos Remitente, Responder a, T�tulo y Mensaje',
    5 => 'Error: No existe el(la) usuario(a).',
    6 => 'Hubo un error.',
    7 => 'Perfil de usuario(a) de',
    8 => 'Nombre del(a) usuario(a)',
    9 => 'URL del(a) usuario(a)',
    10 => 'Enviar mensaje a',
    11 => 'Remitente:',
    12 => 'Responder a:',
    13 => 'T�tulo:',
    14 => 'Mensaje:',
    15 => 'No se traducir� el c�digo HTML.',
    16 => 'Enviar el mensaje',
    17 => 'Enviar a un(a) amigo(a)',
    18 => 'Destinatario(a)',
    19 => 'Direcci�n de correo electr�nico de destino',
    20 => 'Remitente',
    21 => 'Responder a',
    22 => 'Es necesario rellenar todos los campos',
    23 => "Este correo electr�nico te lo envi� %s en %s porque pens� que podr�a interesarte esta noticia en  {$_CONF['site_url']}. Esto no es SPAM (correo basura) y las direcciones de correo electr�nico involucradas en este env�o no se han guardado para su uso posterior.",
    24 => 'Comentario sobre esta noticia en',
    25 => 'Tienes que conectarte para utilizar esta herramienta. Este control se realiza para evitar el mal uso del sistema.',
    26 => 'Este formulario te permitir� enviar un correo electr�nico al usuario seleccionado. Todos los campos son necesarios.',
    27 => 'Mensaje corto',
    28 => "%s escribi�: ",
    29 => "Este es el res�men diario de {$_CONF['site_name']} para ",
    30 => ' Noticias diarias para ',
    31 => 'T�tulo',
    32 => 'Fecha',
    33 => 'Lee la Noticia completa en',
    34 => 'Fin del mensaje',
    35 => 'Lo siento, este usuario prefiere no recibir mensajes.'
);

###############################################################################
# search.php

$LANG09 = array(
    1 => 'B�squeda Avanzada',
    2 => 'Palabras Clave',
    3 => 'Secci�n',
    4 => 'Todo',
    5 => 'Tipo',
    6 => 'noticias',
    7 => 'Comentarios',
    8 => 'Autores',
    9 => 'Todo',
    10 => 'Buscar',
    11 => 'Resultados de la b�squeda',
    12 => 'resultados',
    13 => 'B�squeda de noticias: No hubo coincidencias',
    14 => 'No se encontraron coincidencias al buscar: ',
    15 => 'Por favor int�ntalo de nuevo.',
    16 => 'T�tulo',
    17 => 'Fecha',
    18 => 'Autor',
    19 => "Buscar en toda la base de datos de <B>{$_CONF['site_name']}</B>",
    20 => 'Fecha',
    21 => 'a',
    22 => '(Formato de fecha DD-MM-YYYY)',
    23 => 'Vistas',
    24 => 'Encontrados %d elementos',
    25 => 'coincidencias con',
    26 => 'elementos en ',
    27 => 'segundos',
    28 => 'No se encontraron coincidencias en Noticias y Comentarios',
    29 => 'Resultados de las Noticias y Comentarios',
    30 => 'Ning�n enlace coincide con tu b�squeda',
    31 => 'Este plug-in no ha dado resultados',
    32 => 'Evento',
    33 => 'URL',
    34 => 'Ubicaci�n',
    35 => 'Todo el dia',
    36 => 'Ning�n evento coincidi� con tu b�squeda',
    37 => 'Resultados de Eventos',
    38 => 'Resultados de Enlaces',
    39 => 'Enlaces',
    40 => 'Eventos',
    41 => 'Tu b�squeda  tiene que tener al menos 3 letras.',
    42 => 'Por favor utiliza una fecha formateada como YYYY-MM-DD (a�o-mes-d�a).',
    43 => 'frase exacta',
    44 => 'todas estas palabras',
    45 => 'cualquiera de estas palabras',
    46 => 'Siguiente',
    47 => 'Anterior',
    48 => 'Autor(a)',
    49 => 'Fecha',
    50 => 'Vistas',
    51 => 'Enlace',
    52 => 'Ubicaci�n',
    53 => 'Resultados de la noticia',
    54 => 'Resultados de Comentario',
    55 => 'la frase',
    56 => 'Y',
    57 => 'O'
);

###############################################################################
# stats.php

$LANG10 = array(
    1 => 'Estad�sticas del sitio',
    2 => 'Total de accesos al sistema',
    3 => 'Noticias(Comentarios) en el sistema',
    4 => 'Encuestas(Respuestas) en el sistema',
    5 => 'Enlaces(Visitados) en el sistema',
    6 => 'Eventos en el sistema',
    7 => 'Las 10 Noticias m�s vistas',
    8 => 'T�tulo de la Noticia',
    9 => 'Accesos',
    10 => 'Parece que no hay noticias en este sitio o que nadie las ha visto todav�a.',
    11 => 'Las 10 noticias m�s comentadas',
    12 => 'Comentarios',
    13 => 'Parece que no hay noticias en este sitio o que nadie ha escrito un comentario sobre ellas.',
    14 => 'Las 10 Encuestas con m�s votos',
    15 => 'Pregunta',
    16 => 'Votos',
    17 => 'Parece que no hay encuestas en este sitio o que nadie ha votado.',
    18 => 'Los 10 Enlaces m�s visitados',
    19 => 'Enlaces',
    20 => 'Visitas',
    21 => 'Parece que en este sitio no hay Enlaces o que nadie los ha visitado.',
    22 => 'Las 10 Noticias m�s enviadas por correo electr�nico',
    23 => 'mensajes por correo electr�nico',
    24 => 'Parece que nadie ha enviado una noticia por correo electr�nic en este sitio.'
);

###############################################################################
# article.php

$LANG11 = array(
    1 => 'Relacionado con esto...',
    2 => 'Enviar a un(a) amigo(a)',
    3 => 'Versi�n para imprimir',
    4 => 'Opciones de la Noticia'
);

###############################################################################
# submit.php

$LANG12 = array(
    1 => "Para enviar %s tienes que estar conectado(a) como usuario(a).",
    2 => 'Ingresar',
    3 => 'Usuario(a) Nuevo(a)',
    4 => 'Agregar un Evento',
    5 => 'Agregar un Enlace',
    6 => 'Agregar una noticia',
    7 => 'Tienes que conectarte',
    8 => 'Enviar colaboraciones',
    9 => 'Cuando envias informaci�n a este sitio te pedimos que tomes en cuenta los siguientes consejos: <ul><li>Completa todos los campos requeridos<li>Comprueba bien los URL\'s<li>Facilita informaci�n completa y precisa</ul>',
    10 => 'T�tulo',
    11 => 'Enlace',
    12 => 'Fecha de inicio',
    13 => 'Fecha de finalizaci�n',
    14 => 'Lugar',
    15 => 'Descripci�n',
    16 => 'Si es otra, especifica',
    17 => 'Categor�a',
    18 => 'Otra',
    19 => 'Leer antes',
    20 => 'Error: Falta la Categor�a',
    21 => 'Por favor, cuando selecciones \'Otra\' completa el nombre de la categor�a',
    22 => 'Error: Faltan Campos',
    23 => 'Por favor completa todo los campos del formulario. Es necesario rellenar todos los campos.',
    24 => 'Colaboraci�n guardada',
    25 => 'Tus colaboraciones se han guardado satisfactoriamente.',
    26 => 'L�mite de Velocidad',
    27 => 'Nombre del(a) usuario(a)',
    28 => 'Secci�n',
    29 => 'Noticia',
    30 => 'Tu �ltima colaboraci�n fue hace ',
    31 => " segundos.  Este sitio requiere como m�nimo {$_CONF['speedlimit']} segundos entre env�os",
    32 => 'Vista Previa',
    33 => 'Vista previa de la noticia',
    34 => 'Salir',
    35 => 'No se permiten etiquetas de HTML',
    36 => 'Formato del texto',
    37 => "Los Eventos enviados a {$_CONF['site_name']} se agregan al Calendario P�blico, donde el resto de los usuarios pueden agregarlo a su Calendario Personal. Esta funci�n <b>NO</b> est� pensada para que guardes tus eventos personales como cumplea�os, citas, etc.<br><br>Una vez enviado, el evento ser� evaluado por los Administradores. De ser aprobado, se mostrar� en el Calendario P�blico",
    38 => 'Agregar un Evento a',
    39 => 'Calendario P�blico',
    40 => 'Calendario Personal',
    41 => 'Hora de Finalizaci�n',
    42 => 'Hora de Inicio',
    43 => 'Evento que dura todo el d�a',
    44 => 'Direcci�n, l�nea 1',
    45 => 'Direcci�n, l�nea 2',
    46 => 'Ciudad/Localidad',
    47 => 'Provincia/Estado',
    48 => 'C�digo Postal',
    49 => 'Tipo de Evento',
    50 => 'Editar los Tipos de Eventos',
    51 => 'Lugar',
    52 => 'Borrar',
    53 => 'Crear una Cuenta'
);

###############################################################################
# ADMIN PHRASES - These are file phrases used in admin scripts
###############################################################################

###############################################################################
# admin/auth.inc.php

$LANG20 = array(
    1 => 'Se requiere verificaci�n',
    2 => '�Acceso denegado! La informaci�n de ingreso es incorrecta',
    3 => 'La contrase�a ingresada es inv�lida',
    4 => 'Usuario(a):',
    5 => 'Contrase�a:',
    6 => 'Todo acceso a las partes administrativas queda registrado y revisado.<br>Esta p�gina es para uso exclusivo del personal autorizado.',
    7 => 'Identificaci�n'
);

###############################################################################
# admin/block.php

$LANG21 = array(
    1 => 'No tienes derechos de Administrador(a)',
    2 => 'No tienes los derechos suficientes para editar este bloque.',
    3 => 'Editor de Bloques',
    4 => 'There was a problem reading this feed (see error.log for details).',
    5 => 'T�tulo del Bloque',
    6 => 'Secci�n',
    7 => 'Todo',
    8 => 'Nivel de seguridad del bloque',
    9 => 'Orden del Bloque',
    10 => 'Tipo de bloque',
    11 => 'Bloque del Sistema',
    12 => 'Bloque Normal',
    13 => 'Opciones para el Bloque del Sistema',
    14 => 'RDF(Resource Description Framework)URL',
    15 => '�ltima actualizaci�n del RDF',
    16 => 'Opciones para el Bloque Normal',
    17 => 'Contenido del Bloque',
    18 => 'Por favor completa los campos T�tulo, Nivel de Seguridad y Contenido del bloque',
    19 => 'Administrador',
    20 => 'T�tulo',
    21 => 'Nivel de Seguridad',
    22 => 'Tipo',
    23 => 'N�mero de Orden',
    24 => 'Secci�n',
    25 => 'Para modificar o borrar un bloque, selecci�nalo m�s abajo. Para crear uno nuevo, selecciona \'Nuevo Bloque\' arriba.',
    26 => 'Bloque de maquetaci�n',
    27 => 'Bloque de PHP',
    28 => 'Opciones del Bloque PHP',
    29 => 'Funciones del Bloque',
    30 => 'Si quieres que tu bloque utilice c�digo PHP, ingresa aqu� el nombre de la funci�n. La funci�n tiene que tener el prefijo "phpblock_" (ej. phpblock_getweather). De no tenerlo NO ser� invocada. Aseg�rate de no incluir los par�ntesis, "()", al final del nombre. Por �ltimo, se recomienda que guardes todo c�digo PHP en /path/to/geeklog/system/lib-custom.php. Esto te permitir� que tu c�digo se mantenga a�n entre cambios de versiones del sistema.',
    31 => 'Error en un Bloque PHP.  La funci�n, %s, no existe.',
    32 => 'Error, Faltan Campos',
    33 => 'Tienes que ingresar el URL del archivo .rdf para los Bloques del Sistema',
    34 => 'Tienes que ingresar el T�tulo y la Funci�n en los Bloques PHP',
    35 => 'Tienes que ingresar el T�tulo y el Contenido para los Bloques Normales',
    36 => 'Tienes que ingresar el contenido para los Bloques de Maquetaci�n',
    37 => 'El nombre de la funci�n en el Bloque PHP es inv�lido',
    38 => 'Las funciones para los Bloques PHP tienen que tener el prefijo \'phpblock_\' (ej. phpblock_getweather). Se requiere el prefijo por cuestiones de seguridad, para evitar que se ejecute c�digo no deseado.',
    39 => 'Ubicaci�n',
    40 => 'Izquierda',
    41 => 'Derecha',
    42 => 'Tienes que ingresar el n�mero de orden y el nivel de seguridad para los bloques por defecto',
    43 => 'S�lo en la P�gina de Inicio',
    44 => 'Acceso Denegado',
    45 => "Est�s intentando acceder a un bloque al que no tienes derechos de acceso.  Este intento se ha registrado. Por favor <a href=\"{$_CONF['site_admin_url']}/block.php\">regresa a la pantalla de administraci�n de bloques</a>.",
    46 => 'Nuevo Bloque',
    47 => 'P�gina de Inicio - Administrador',
    48 => 'Nombre del Bloque',
    49 => ' (sin espacios y tiene que ser �nico)',
    50 => 'URL del archivo de ayuda',
    51 => 'incluir http://',
    52 => 'Si dejas este campo en blanco no se mostrar� el �cono de ayuda',
    53 => 'Habilitado',
    54 => 'guardar',
    55 => 'cancelar',
    56 => 'borrar',
    57 => 'Move Block Down',
    58 => 'Move Block Up',
    59 => 'Move block to the right side',
    60 => 'Move block to the left side'
);

###############################################################################
# admin/event.php

$LANG22 = array(
    1 => 'Editor de Eventos',
    2 => '',
    3 => 'T�tulo',
    4 => 'URL',
    5 => 'Fecha de Inicio',
    6 => 'Fecha de Finalizaci�n',
    7 => 'Lugar',
    8 => 'Descripci�n',
    9 => '(incluir http://)',
    10 => 'Tienes que completar todos los campos de este formulario.',
    11 => 'Administrador del Evento',
    12 => 'Para modificar o borrar un evento, pulsa en ese evento abajo. Para crear un Nuevo Evento pulsa sobre Evento Nuevo arriba. Pulsa sobre [C] para crear una copia de un evento ya existente.',
    13 => 'T�tulo',
    14 => 'Fecha de Inicio',
    15 => 'Fecha de Finalizaci�n',
    16 => 'Acceso Denegado',
    17 => "No tienes permiso para acceder a este Evento. Todo intento de acceso ser� registrado. Por favor, vuelve a <a href=\"{$_CONF['site_admin_url']}/event.php\">la p�gina de Administraci�n de Eventos</a>.",
    18 => 'Nuevo Evento',
    19 => 'P�gina de Inicio - Administrador',
    20 => 'guardar',
    21 => 'cancelar',
    22 => 'borrar'
);

###############################################################################
# admin/link.php

$LANG23 = array(
    1 => 'Editor de Enlaces',
    2 => '',
    3 => 'T�tulo',
    4 => 'URL',
    5 => 'Categoria',
    6 => '(incluir http://)',
    7 => 'Otro',
    8 => 'Cantidad de accesos',
    9 => 'Descripci�n',
    10 => 'Tienes que completar los campos T�tulo, URL y Descripci�n.',
    11 => 'Administrador',
    12 => 'Para modificar o borrar un Enlace selecci�nalo m�s abajo. Para crear uno nuevo selecciona \'Nuevo Enlace\' m�s arriba.',
    13 => 'T�tulo',
    14 => 'Categor�a',
    15 => 'URL',
    16 => 'Acceso Denegado',
    17 => "No tienes permiso para acceder a este Enlace. Todo intento de acceso ser� registrado. Por favor, vuelve a <a href=\"{$_CONF['site_admin_url']}/link.php\">la p�gina de Administraci�n de Enlaces</a>.",
    18 => 'Nuevo Enlace',
    19 => 'P�gina de Inicio - Administrador',
    20 => 'Si es otra/o, especifica',
    21 => 'guardar',
    22 => 'cancelar',
    23 => 'borrar'
);

###############################################################################
# admin/story.php

$LANG24 = array(
    1 => 'Noticias Anteriores',
    2 => 'Noticias Siguientes',
    3 => 'Modo',
    4 => 'Modo de envio',
    5 => 'Editor de Noticias',
    6 => 'No hay Noticias en el sistema',
    7 => 'Autor',
    8 => 'guardar',
    9 => 'vista previa',
    10 => 'cancelar',
    11 => 'borrar',
    12 => '',
    13 => 'T�tulo',
    14 => 'Secci�n',
    15 => 'Fecha',
    16 => 'Introducci�n',
    17 => 'Texto',
    18 => 'Accesos',
    19 => 'Comentarios',
    20 => '',
    21 => '',
    22 => 'Listado de Noticias',
    23 => 'Para modificar o borrar una Noticia selecciona el n�mero de Noticia m�s abajo. Para ver la Noticia selecciona el t�tulo de la misma. Para crear una nueva Noticia selecciona \'Enviar Noticia\' m�s arriba.',
    24 => '',
    25 => '',
    26 => 'Vista Previa',
    27 => '',
    28 => '',
    29 => '',
    30 => 'Errores al Subir Archivos',
    31 => 'Por favor rellena los campos de Autor, T�tulo y Texto',
    32 => 'Destacada',
    33 => 'S�lo puede haber una Noticia destacada',
    34 => 'Borrador',
    35 => 'S�',
    36 => 'No',
    37 => 'M�s de',
    38 => 'M�s en',
    39 => 'correos electr�nicos',
    40 => 'Acceso Denegado',
    41 => "Est�s intentando acceder a una Noticia a la que no tienes derechos de acceso, por lo que podr�s ver la Noticia pero no editarla. Por favor vuelve a la <a href=\"{$_CONF['site_admin_url']}/story.php\">p�gina de administraci�n</a> cuando hayas terminado.",
    42 => "Est�s intentando acceder a una Noticia a la que no tienes derechos de acceso. Por favor vuelve a la <a href=\"{$_CONF['site_admin_url']}/story.php\">p�gina de administraci�n</a>.",
    43 => 'Nueva Noticia',
    44 => 'P�gina de Inicio - Administrador',
    45 => 'Acceso',
    46 => '<b>NOTA:</b> si modificas esta fecha por una futura, la Noticia no se publicar� hasta esa fecha. Esto tambi�n incluye el envi� de titulares RDF(Resource Description Framework), la b�squeda y las estad�sticas del sitio.',
    47 => 'Im�genes',
    48 => 'imagen',
    49 => 'der',
    50 => 'izq',
    51 => 'Para insertar una imagen en la Noticia tienes que incluir un texto con el formato [imagenX], [imagenX_der] o [imagenX_izq], donde X es el n�mero de imagen dentro de la lista. NOTA: s�lo puedes utilizar las im�genes de la lista, si no la Noticia no se podr� guardar',
    52 => 'Borrar',
    53 => 'no se ha utilizado.  Tienes que incluir esta imagen en la Introducci�n o el Texto para poder guardar los cambios',
    54 => 'Im�genes no utilizadas',
    55 => 'Los siguientes errores ocurrieron al querer guardar tu Noticia. Por favor corrije los errores antes de guardar.',
    56 => 'Mostrar icono de Tema',
    57 => 'Ver imagen sin proporci�n'
);

###############################################################################
# admin/poll.php

$LANG25 = array(
    1 => 'Modo',
    2 => 'Por favor teclea una pregunta y como m�nimo una respuesta.',
    3 => 'Fecha de creaci�n',
    4 => "Encuesta %s guardada",
    5 => 'Editar la Encuesta',
    6 => 'Identificaci�n',
    7 => '(no utilices espacios)',
    8 => 'Aparece en la Portada',
    9 => 'Pregunta',
    10 => 'Respuestas / Votos',
    11 => "Hubo un error al buscar los datos para las respuesta de la Encuesta %s",
    12 => "Hubo un error al buscar los datos para la pregunta de la Encuesta %s",
    13 => 'Crear Encuesta',
    14 => 'guardar',
    15 => 'cancelar',
    16 => 'borrar',
    17 => 'Por favor teclea un nombre de identificaci�n (ID) de la encuesta',
    18 => 'Listado de Encuestas',
    19 => 'Para modificar o borrar una Encuesta el�jela en la lista de abajo. Para crear una nueva, selecciona \'Nueva Encuesta\' m�s arriba.',
    20 => 'Votantes',
    21 => 'Acceso Denegado',
    22 => "Est�s intentando acceder a una Encuesta a la que no tienes derechos de acceso. Por favor vuelve a la <a href=\"{$_CONF['site_admin_url']}/poll.php\">p�gina de administraci�n.",
    23 => 'Nueva Encuesta',
    24 => 'P�gina de Inicio - Administrador',
    25 => 'S�',
    26 => 'No'
);

###############################################################################
# admin/topic.php

$LANG27 = array(
    1 => 'Editor de Secciones',
    2 => 'Identificaci�n (ID)',
    3 => 'Nombre',
    4 => 'Imagen',
    5 => '(no utilices espacios)',
    6 => 'Al borrar una Secci�n se borrar�n todas tus Noticias y Bloques asociados',
    7 => 'Por favor completa los campos ID y Nombre',
    8 => 'Administrador de Secciones',
    9 => 'Para modificar o borrar un tema, pulsa sobre ese tema. Para crear un tema nuevo, pulsa el bot�n de Nuevo Tema en la izquierda. Encontrar�s tu nivel de acceso para tema en par�ntesis. El asterisco(*) denota el tema  por defecto.',
    10 => 'N�mero de Orden',
    11 => 'Noticias/P�gina',
    12 => 'Acceso Denegado',
    13 => "Est�s intentando acceder a una Secci�n a la que no tienes derechos de acceso. Por favor vuelve a la <a href=\"{$_CONF['site_admin_url']}/topic.php\">p�gina de administraci�n.",
    14 => 'M�todo de Ordenamiento',
    15 => 'alfab�tico',
    16 => 'por defecto es',
    17 => 'Nueva Secci�n',
    18 => 'P�gina de Inicio - Administrador',
    19 => 'guardar',
    20 => 'cancelar',
    21 => 'borrar',
    22 => 'Por defecto',
    23 => 'convertir en el tema por defecto para nuevas colaboraciones',
    24 => '(*)'
);

###############################################################################
# admin/user.php

$LANG28 = array(
    1 => 'Editor de Usuarios',
    2 => 'ID',
    3 => 'Nombre de Usuario(a)',
    4 => 'Nombre Completo',
    5 => 'Contrase�a',
    6 => 'Nivel de Seguridad',
    7 => 'Direcci�n de correo electr�nico',
    8 => 'P�gina de Inicio',
    9 => '(no utilices espacios)',
    10 => ' Por favor, rellena los campos de Nombre de Usuario(a) y direcci�n de correo electr�nico',
    11 => 'Administrador de Usuarios',
    12 => 'Para modificar o borrar a un(a) usuario(a), pulsa sobre ese(a) usuario(a) abajo.  Para crear un(a) usuario(a) nuevo(a) pulsa el bot�n de Nuevo Usuario en la izquierda. Puedes hacer b�squedas sencillas al teclear partes del nombre de usuario, direcci�n de correo electr�nico o nombre completo (por ejemplo *son* o *.edu) en el formulario de abajo..',
    13 => 'Nivel de seguridad',
    14 => 'Fecha de Inscripci�n',
    15 => 'Nuevo Usuario',
    16 => 'P�gina de Inicio - Administrador',
    17 => 'Cambiar-Contrase�a',
    18 => 'Cancelar',
    19 => 'Borrar',
    20 => 'Guardar',
    21 => 'El Nombre de Usuario(a) propuesto ya existe.',
    22 => 'Error',
    23 => 'Importaci�n Masiva',
    24 => 'Importaci�n masiva de Usuarios',
    25 => "Puedes importar una lista de Usuarios(as) a {$_CONF['site_name']}. El archivo con la lista de usuarios(as) tiene que tener un registro por l�nea y los campos separados por TAB (tabulador). Los campos tienen que estar en el siguiente orden: Nombre Completo, Nombre de Usuario, Direcci�n de Correo electr�nico. A cada usuario a�adido se le enviar� por correo electr�nico una contrase�a generada al azar, que podr�n cambiar al ingresar al sitio. Por favor, ccomprueba bien el archivo de importaci�n ya que los errores encontrados pueden llegar a requerir arreglos manuales.",
    26 => 'Buscar',
    27 => 'Limitar los resultados',
    28 => 'Marcar la casilla para borrar esta imagen',
    29 => 'Ruta',
    30 => 'Importar',
    31 => 'Nuevos Usuarios',
    32 => 'Proceso finalizado. Se importaron %d y hubieron %d fallos',
    33 => 'enviar',
    34 => 'Error: Tienes que especificar el archivo que quieres subir.',
    35 => 'Ultimo acceso',
    36 => '(nunca)'
);

###############################################################################
# admin/moderation.php

$LANG29 = array(
    1 => 'Aprobar',
    2 => 'Borrar',
    3 => 'Editar',
    4 => 'Perfil',
    10 => 'T�tulo',
    11 => 'Fecha de Inicio',
    12 => 'URL',
    13 => 'Categor�a',
    14 => 'Fecha',
    15 => 'Tema',
    16 => 'Nombre del(a) usuario(a)',
    17 => 'Nombre completo',
    18 => 'correo electr�nico',
    34 => 'P�gina de administraci�n',
    35 => 'Env�os de Noticias',
    36 => 'Env�os de Enlaces',
    37 => 'Env�os de Eventos',
    38 => 'Enviar',
    39 => 'No hay env�os para moderar en este momento',
    40 => 'Envios del(a) usuario(a)'
);

###############################################################################
# calendar.php

$LANG30 = array(
    1 => 'Domingo',
    2 => 'Lunes',
    3 => 'Martes',
    4 => 'Mi�rcoles',
    5 => 'Jueves',
    6 => 'Viernes',
    7 => 'S�bado',
    8 => 'Agregar un Evento',
    9 => 'Evento de %s',
    10 => 'Eventos para',
    11 => 'Calendario Maestro',
    12 => 'Mi Calendario',
    13 => 'Enero',
    14 => 'Febrero',
    15 => 'Marzo',
    16 => 'Abril',
    17 => 'Mayo',
    18 => 'Junio',
    19 => 'Julio',
    20 => 'Agosto',
    21 => 'Septiembre',
    22 => 'Octubre',
    23 => 'Noviembre',
    24 => 'Diciembre',
    25 => 'Volver a ',
    26 => 'Todo el d�a',
    27 => 'Semana',
    28 => 'Calendario Personal para',
    29 => 'Calendario P�blico',
    30 => 'borrar evento',
    31 => 'Agregar',
    32 => 'Evento',
    33 => 'Fecha',
    34 => 'Hora',
    35 => 'Agregado r�pido',
    36 => 'Enviar',
    37 => 'Disculpa, la opci�n de calendario personal no se encuentra habilitada en este sitio',
    38 => 'Editor Personal de Eventos',
    39 => 'D�a',
    40 => 'Semana',
    41 => 'Mes'
);

###############################################################################
# admin/mail.php

$LANG31 = array(
    1 => "{$_CONF['site_name']}Utilidad de correo electr�nico",
    2 => 'De',
    3 => 'Responder a',
    4 => 'T�tulo',
    5 => 'Mensaje',
    6 => 'Enviar a:',
    7 => 'Todos los usuarios',
    8 => 'Administrador',
    9 => 'Opciones',
    10 => 'HTML',
    11 => '�Mensaje Urgente!',
    12 => 'Enviar',
    13 => 'Reiniciar',
    14 => 'Ignorar las preferencias del(a) usuario(a)',
    15 => 'Error al mandar a: ',
    16 => 'Se ha enviado satisfactoriamente a: ',
    17 => "<a href={$_CONF['site_admin_url']}/mail.php>Enviar otro mensaje</a>",
    18 => 'Para',
    19 => 'NOTA: si quieres enviar un mensaje a todos los miembros del sitio, selecciona el grupo Logged-In Users en la lista.',
    20 => "Se han enviado <successcount> mensajes satisfactoriamente y <failcount> han fallado.  Si quieres, los detalles de cada env�o figuran abajo. Tambien puedes <a href=\"{$_CONF['site_admin_url']}/mail.php\">enviar otro mensaje</a> o volver a <a href=\"{$_CONF['site_admin_url']}/moderation.php\">la p�gina de administraci�n</a>.",
    21 => 'Fallidos',
    22 => 'Exitosos',
    23 => 'No ha habido env�os fallidos',
    24 => 'No ha habido env�os satisfactorios',
    25 => '-- Selecciona Grupo --',
    26 => 'Por favor, rellena todos los campos del formulario y selecciona un grupo de usuarios de la lista desplegable.'
);

###############################################################################
# admin/plugins.php

$LANG32 = array(
    1 => 'Instalar Plug-in(s) puede da�ar tu instalaci�n de Geeklog y, posiblemente, tu sistema. Es importante que s�lo instales Plug-in(s) obtenidos de <a href="http://www.geeklog.net" target="_blank">Geeklog</a> ya que han sido comprobados en varios entornos. Es tambi�n importante que entiendas que la instalaci�n del Plug-in requiere la ejecuci�n de instrucciones del sistema que pueden traer problemas de seguridad. A�n con esta advertencia, no garantizamos el �xito de la instalaci�n del Plug-in ni nos hacemos responsables por cualquier da�o causado durante la instalaci�n (o posterior a la misma). En otras palabras, instala el Plug-in a tu propio riesgo. Las instrucciones particulares de instalaci�n vienen dentro de cada Plug-in.',
    2 => 'Advertencia de la Instalaci�n del Plug-in',
    3 => 'Formulario de instalaci�n del Plug-in',
    4 => 'Archivo del Plug-in',
    5 => 'Listado de(los) Plug-in(s)',
    6 => 'Advertencia: �El Plug-in ya est� instalado!',
    7 => 'El Plug-in que intentas instalar ya existe. Por favor borra el Plug-in antes de reinstalarlo.',
    8 => 'Fall� la comprobaci�n de compatibilidad del Plug-in',
    9 => 'Este Plug-in requiere una versi�n m�s nueva de Geeklog. Puedes obtener una copia actualizada de <a href=http://www.geeklog.net>Geeklog</a> o instalar otra versi�n del Plug-in.',
    10 => '<br><b>No hay Plug-in(s) instalados.</b><br><br>',
    11 => 'Para modificar o borrar un Plug-in selecciona el n�mero a la izquierda del mismo. Para acceder a la p�gina de sus creadores seleccione en el t�tulo del Plug-in. Para instalar un nuevo Plug-in selecciona \'Nuevo Plug-in\' m�s arriba.',
    12 => 'no se ha dado un nombre de plugin a la funci�n plugineditor()',
    13 => 'Editor de Plugins',
    14 => 'Nuevo Plug-in',
    15 => 'P�gina de Inicio - Administrador',
    16 => 'Plug-in Name',
    17 => 'Versi�n',
    18 => 'Versi�n de Geeklog',
    19 => 'Habilitado',
    20 => 'S�',
    21 => 'No',
    22 => 'Instalar',
    23 => 'Guardar',
    24 => 'Cancelar',
    25 => 'Borrar',
    26 => 'Nombre',
    27 => 'Portada',
    28 => 'Versi�n',
    29 => 'Versi�n de Geeklog',
    30 => 'Borrar el Plug-in?',
    31 => '�Est�s seguro(a) que quieres borrar este Plug-in? Al hacerlo borrar�s todos los archivos, estructuras y datos asociados. Si est�s seguro/a selecciona "Borrar" en el formulario de abajo.'
);

###############################################################################
# admin/syndication.php

$LANG33 = array(
    1 => 'create feed',
    2 => 'save',
    3 => 'delete',
    4 => 'cancel',
    10 => 'Content Syndication',
    11 => 'New Feed',
    12 => 'Admin Home',
    13 => 'To modify or delete a feed, click on the feed\'s title below. To create a new feed, click on New Feed above.',
    14 => 'Title',
    15 => 'Type',
    16 => 'Filename',
    17 => 'Format',
    18 => 'last updated',
    19 => 'Enabled',
    20 => 'Yes',
    21 => 'No',
    22 => '<i>(no feeds)</i>',
    23 => 'all Stories',
    24 => 'Feed Editor',
    25 => 'Feed Title',
    26 => 'Limit',
    27 => 'Length of entries',
    28 => '(0 = no text, 1 = full text, other = limit to that number of chars.)',
    29 => 'Description',
    30 => 'Last Update',
    31 => 'Character Set',
    32 => 'Language',
    33 => 'Contents',
    34 => 'Entries',
    35 => 'Hours',
    36 => 'Select type of feed',
    37 => 'You have at least one plugin installed that supports content syndication. Below you will need to select whether you want to create a Geeklog feed or a feed from one of the plugins.',
    38 => 'Error: Missing Fields',
    39 => 'Please fill in the Feed Title, Description, and Filename.',
    40 => 'Please enter a  number of entries or number of hours.',
    41 => 'Links',
    42 => 'Events'
);

###############################################################################
# confirmation and error messages

$MESSAGE = array(
    1 => "Tu contrase�a se ha enviado por correo electr�nico y llegar� en unos instantes. Por favor sigue las indicaciones del mensaje. Gracias por utilizar {$_CONF['site_name']}",
    2 => "Gracias por enviar tu Noticia a {$_CONF['site_name']}. La Noticia se encuentra en proceso de aprobaci�n. De ser aprobada, podr� ser leida por todos los visitantes del sitio.",
    3 => "Gracias por enviar tu Enlace a {$_CONF['site_name']}. El Enlace se encuentra en proceso de aprobaci�n. De ser aprobado, podr� ser visto por todos los visitantes del sitio.",
    4 => "Gracias por enviar tu Evento a {$_CONF['site_name']}. El Evento se encuentra en proceso de aprobaci�n. De ser aprobado, podr� ser visto por todos los visitantes del sitio.",
    5 => 'La informaci�n de tu cuenta se ha guardado satisfactoriamente.',
    6 => 'Tus preferencias se han guardado satisfactoriamente.',
    7 => 'Tus preferencias para Comentarios han sido guardadas satisfactoriamente.',
    8 => 'Te has desconectado satisfactoriamente.',
    9 => 'Tu Noticia se ha guardado satisfactoriamente.',
    10 => 'La Noticia se ha borrado satisfactoriamente.',
    11 => 'Tu Bloque se ha guardado satisfactoriamente.',
    12 => 'El Bloque se ha borrado satisfactoriamente.',
    13 => 'Tu Secci�n se ha guardado satisfactoriamente.',
    14 => 'La Secci�n junto con todas tus Noticias y Bloques se han borrado satisfactoriamente.',
    15 => 'Tu enlace se ha guardado satisfactoriamente.',
    16 => 'El enlace se ha borrado satisfactoriamente.',
    17 => 'Tu Evento se ha guardado satisfactoriamente.',
    18 => 'El Evento se ha borrado satisfactoriamente.',
    19 => 'Tu Encuesta se ha guardado satisfactoriamente.',
    20 => 'La Encuesta se ha borrado satisfactoriamente.',
    21 => 'El Nuevo Usuario se ha guardado satisfactoriamente.',
    22 => 'El Usuario se ha borrado satisfactoriamente',
    23 => 'Error al guardar el Evento en tu Calendario. No fue procesado el ID.',
    24 => 'El Evento se ha guardado en tu Calendario',
    25 => 'No puedes acceder a tu Calendario Personal antes de conectarte como usuario',
    26 => 'El Evento se ha borrado de tu Calendario Personal',
    27 => 'Mensaje enviado satisfactoriamente.',
    28 => 'El Plug-in se ha guardado satisfactoriamente',
    29 => 'Disculpa, los Calendarios Personales no est�n habilitados en este sitio',
    30 => 'Acceso Denegado',
    31 => 'Disculpa, no tienes acceso a la p�gina de administraci�n de Noticias. Aclaramos que todo acceso sin autorizaci�n queda registrado en el servidor.',
    32 => 'Disculpa, no tienes acceso a la p�gina de administraci�n de Secciones. Aclaramos que todo acceso sin autorizaci�n queda registrado en el servidor.',
    33 => 'Disculpa, no tienes acceso a la p�gina de administraci�n de Bloques. Aclaramos que todo acceso sin autorizaci�n queda registrado en el servidor.',
    34 => 'Disculpa, no tienes acceso a la p�gina de administraci�n de Enlaces. Aclaramos que todo acceso sin autorizaci�n queda registrado en el servidor.',
    35 => 'Disculpa, no tienes acceso a la p�gina de administraci�n de Eventos. Aclaramos que todo acceso sin autorizaci�n queda registrado en el servidor.',
    36 => 'Disculpa, no tienes acceso a la p�gina de administraci�n de Encuestas. Aclaramos que todo acceso sin autorizaci�n queda registrado en el servidor.',
    37 => 'Disculpa, no tienes acceso a la p�gina de administraci�n de Usuarios. Aclaramos que todo acceso sin autorizaci�n queda registrado en el servidor.',
    38 => 'Disculpa, no tienes acceso a la p�gina de administraci�n de Plug-in(s). Aclaramos que todo acceso sin autorizaci�n queda registrado en el servidor.',
    39 => 'Disculpa, no tienes acceso a la p�gina de administraci�n de Correo electr�nico. Aclaramos que todo acceso sin autorizaci�n queda registrado en el servidor.',
    40 => 'Mensaje del Sistema',
    41 => 'Disculpa, no tienes acceso a la p�gina de Reemplazo de Palabras. Aclaramos que todo acceso sin autorizaci�n queda registrado en el servidor.',
    42 => 'La Palabra fue guardada satisfactoriamente.',
    43 => 'La Palabra fue borrada satisfactoriamente.',
    44 => 'El Plug-In fue instalado satisfactoriamente.',
    45 => 'El Plug-In fue borrado satisfactoriamente.',
    46 => 'Disculpa, no tienes acceso a la herramienta de copia de seguridad de la base de datos. Aclaramos que todo acceso sin autorizaci�n queda registrado en el servidor.',
    47 => 'Esta funci�n est� disponible bajo *nix. Si est�s utilizando *nix como tu sistema operativo, entonces tu copia de visitas (cache) se ha limpiado satisfactoriamente. Si est�s bajo Windows, tienes que buscar los archivos adodb_*.php y borrarlos manualmente.',
    48 => "Gracias por registrarte como miembro en {$_CONF['site_name']}. Nuestro equipo comprobar� tu solicitud. Si es aprobada, te ser� enviada tu Contrase�a a la direcci�n correo electr�nico que has indicado.",
    49 => 'Tu grupo se ha guardado satisfactoriamente.',
    50 => 'El grupo se ha borrado satisfactoriamente.',
    51 => 'Este nombre de usuario(a) ya est� en uso. Por favor, elige otro.',
    52 => 'La direcci�n facilitada no parece una direcci�n v�lida de correo electr�nico.',
    53 => 'Tu contrase�a nueva se ha aceptada. Por favor, utiliza la contrase�a nueva que parece abajo para ingresar de nuevo.',
    54 => 'Tu petici�n de contrase�a nueva ha caducado. Por favor, vuelve a intentarlo abajo.',
    55 => 'El sistema te han enviado un correo electr�nico y te llegar� en breve. Por favor, sigue las instrucciones del mensaje para crear una contrase�a nueva para tu cuenta.',
    56 => 'La direcci�n de correo electr�nico facilitada ya est� en uso en otra cuenta.',
    57 => 'Tu cuenta se ha borrado satisfactoriamente.',
    58 => 'Your feed has been successfully saved.',
    59 => 'The feed has been successfully deleted.'
);

###############################################################################

$LANG_ACCESS = array(
    'access' => 'Acceso',
    'ownerroot' => 'Propietario/Ra�z',
    'group' => 'Grupo',
    'readonly' => 'S�lo-Lectura',
    'accessrights' => 'Derechos de acceso',
    'owner' => 'Propietario',
    'grantgrouplabel' => 'Establecer los derechos del Grupo',
    'permmsg' => 'NOTA: miembros son todos los miembros conectados y los usuarios an�nimos que est�n en el sitio.',
    'securitygroups' => 'Grupos de Seguridad',
    'editrootmsg' => "Aunque seas un(a) Administrador(a) de Usuarios(as), no puedes editar a un usuario de ra�z sin que te hayas dado de alta antes como usuario de ra�z.  Puedes editar a todos los dem�s usuarios excepto los usuarios de ra�z. Por favor, toma nota que cualquier intento de editar ilegalmente a los usuarios de ra�z quedar� registrado.  Por favor vuelve a <a href=\"{$_CONF['site_admin_url']}/users.php\">la p�gina de Administraci�n de usuarios</a>.",
    'securitygroupsmsg' => 'Selecciona las casillas para los grupos a los que quieres que pertenezca el usuario.',
    'groupeditor' => 'Editor de Grupo',
    'description' => 'Descripci�n',
    'name' => 'Nombre',
    'rights' => 'Derechos',
    'missingfields' => 'Campos que faltan',
    'missingfieldsmsg' => 'Tienes que ingresar un nombre y una descripci�n para el Grupo.',
    'groupmanager' => 'Administrador de Grupos',
    'newgroupmsg' => 'Para modificar o borrar un grupo selecciona el grupo aqu� abajo. Para crear un grupo selecciona \'Nuevo Grupo\' aqu� arriba. Ten en cuenta que los Grupos del Sistema no se pueden borrar.',
    'groupname' => 'Nombre del Grupo',
    'coregroup' => 'Grupo del Sistema? ',
    'yes' => 'S�',
    'no' => 'No',
    'corerightsdescr' => "Este grupo es un Grupo de Sistema de {$_CONF['site_name']}, y por lo tanto sus derechos no se pueden editar. A continuaci�n se muestra una lista no editable de los derechos de acceso de este grupo.",
    'groupmsg' => 'Los Grupos de Seguridad en este sitio son jer�rquicos. Al agregar este grupo a cualquiera de los de abajo le estar� dando los mismos derechos que esos grupos posean. De ser posible, se recomienda utilizar los grupos ya creados para dar los derechos a un nuevo grupo. Si tienes que modificar los derechos del grupo, puedes seleccionarlos en la secci�n llamada \'Derechos\'. Para agregar este grupo a cualquiera de los de abajo simplemente marca los grupos que quieras.',
    'coregroupmsg' => "Este grupo es un Grupo de Sistema de {$_CONF['site_name']}, y por ello los grupos que pertenezcan a este grupo no podr�n ser editados. A continuaci�n se muestra una lista (no editable) de los grupos a los cuales pertenece este grupo.",
    'rightsdescr' => 'El derecho de acceso de un grupo a alguno de los derechos que se especifican abajo se pueden dar directamente al grupo O a un grupo diferente del que forma parte este grupo.  Los que ves abajo sin la casilla marcada son los derechos que se han otorgado a este grupo porque pertenece a otro con ese derecho.  Los derechos con las casillas abajo son los derechos que se pueden otorgar directamente a este grupo.',
    'lock' => 'Bloqueo',
    'members' => 'Miembros',
    'anonymous' => 'An�nimo',
    'permissions' => 'Permisos',
    'permissionskey' => 'R = lectura, E = edici�n, los permisos de edici�n implican permisos de lectura',
    'edit' => 'Editar',
    'none' => 'Ninguno',
    'accessdenied' => 'Acceso Denegado',
    'storydenialmsg' => "No tienes acceso para ver esta Noticia. Esto puede ser porque no eres miembro de {$_CONF['site_name']}. Por favor <a href=users.php?mode=new>convi�rtete en un miembro</a> de {$_CONF['site_name']} para tener acceso.",
    'eventdenialmsg' => "No tienes acceso para ver este Evento. Esto puede ser porque no eres miembro de {$_CONF['site_name']}. Por favor <a href=users.php?mode=new>convi�rtete en un miembro</a> de {$_CONF['site_name']} para tener acceso.",
    'nogroupsforcoregroup' => 'Este grupo no pertenece a ninguno de los otros grupos',
    'grouphasnorights' => 'Este grupo no tiene acceso a las funciones de administraci�n',
    'newgroup' => 'Nuevo Grupo',
    'adminhome' => 'P�gina de Administraci�n',
    'save' => 'Guardar',
    'cancel' => 'Cancelar',
    'delete' => 'borrar',
    'canteditroot' => 'Has intentado editar el grupo Root (Ra�z) pero no perteneces al grupo Root por lo que se te ha denegado el acceso.  Por favor, contacta con el(la) administrador(a) del sistema si crees que se trata de un errror',
    'listusers' => 'Listado de Usuarios',
    'listthem' => 'listado',
    'usersingroup' => 'Usuarios en el grupo %s',
    'usergroupadmin' => 'User Group Administration',
    'add' => 'Add',
    'remove' => 'Remove',
    'availmembers' => 'Available Members',
    'groupmembers' => 'Group Members',
    'canteditgroup' => 'To edit this group, you have to be a member of the group. Please contact the system administrator if you feel this is an error.'
);

###############################################################################
# admin/database.php

$LANG_DB_BACKUP = array(
    'last_ten_backups' => '�ltimas 10 copias de seguridad',
    'do_backup' => 'Hacer una copia de seguridad',
    'backup_successful' => 'La copia de seguridad de la base de datos se ha realizado satisfactoriamente.',
    'no_backups' => 'No hay copias de seguridad en el sistema',
    'db_explanation' => 'Para crear una copia de seguridad del sistema utiliza el bot�n de abajo',
    'not_found' => "Ruta incorrecta o la utilidad mysqldump no se puede ejecutar.<br>Comprueba la definici�n de <strong>\$_DB_mysqldump_path</strong> en config.php.<br>La variable est� definida actualmente como: <var>{$_DB_mysqldump_path}</var>",
    'zero_size' => 'Fallo de la copia de seguridad: El tama�o era de 0 bytes',
    'path_not_found' => "{$_CONF['backup_path']} no existe o no es una ruta",
    'no_access' => "ERROR: No se puede acceder al directorio {$_CONF['backup_path']}.",
    'backup_file' => 'Archivo de copias de seguridad',
    'size' => 'Tama�o',
    'bytes' => 'Bytes',
    'total_number' => 'N�mero total de copias de seguridad: %d'
);

###############################################################################

$LANG_BUTTONS = array(
    1 => 'Portada',
    2 => 'Contacto',
    3 => 'Colaboraciones',
    4 => 'Enlaces',
    5 => 'Encuestas',
    6 => 'Calendario',
    7 => 'Estad�sticas',
    8 => 'Personalizar',
    9 => 'Buscar',
    10 => 'b�squeda avanzada'
);

###############################################################################
# 404.php

$LANG_404 = array(
    1 => 'Error 404',
    2 => 'Vaya, he buscado por todos los sitios, pero no puedo encontrar <b>%s</b>.',
    3 => "<p>Lo sentimos, pero el fichero que pides no existe. Por favor, consulta la <a href=\"{$_CONF['site_url']}\">p�gina principal</a> o la <a href=\"{$_CONF['site_url']}/search.php\">p�gina de b�squeda</a> para ver si puedes encontrar lo que has perdido."
);

###############################################################################

$LANG_LOGIN = array(
    1 => 'se requiere ingresar',
    2 => 'Lo siento, para acceder a esta �rea tienes que estar verificado(a) como usuario(a).',
    3 => 'ingresar',
    4 => 'Nuevo(a) Usuario(a)'
);

?>
