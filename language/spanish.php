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

###############################################################################
# Array Format:
# $LANGXX[YY]:  $LANG - variable name
#                       XX - file id number
#                       YY - phrase id number
###############################################################################

###############################################################################
# USER PHRASES - These are file phrases used in end user scripts
###############################################################################


###############################################################################

# common.php



$LANG01 = array(

	1 => "Autor:",
	2 => "leer artículo completo",
	3 => "comentarios",
	4 => "Editar",
	5 => "Votar",
	6 => "Resultados",
	7 => "Resultados de la encuesta",
	8 => "votos",
	9 => "Funciones del(a) Administrador(a):",
	10 => "Propuestas",
	11 => "Noticias",
	12 => "Bloques",
	13 => "Secciones",
	14 => "Enlaces",
	15 => "Eventos",
	16 => "Encuestas",
	17 => "Usuarios(as)",
	18 => "Búsqueda SQL",
	19 => "Salir",
	20 => "Información del(a) usuario(a):",
	21 => "Nombre del(a) usuario(a)",
	22 => "Identidad (ID) del(a) usuario(a)",
	23 => "Nivel de Seguridad",
	24 => "Anónimo",
	25 => "Responder",
	26 => "Los siguientes comentarios son de la persona que los haya enviado. Este sitio no se hace responsable de las opiniones expresadas por los participantes en los foros y secciones de comentarios, y el hecho de publicar las mismas no significa que esté de acuerdo con ellas.",
	27 => "Comentario más reciente",
	28 => "Borrar",
	29 => "No hay comentarios de los usuarios.",
	30 => "Noticias anteriores",
	31 => "Etiquetas de HTML permitidas:",
	32 => "Error, usuario inválido",
	33 => "Error, no fue posible escribir el registro",
	34 => "Error",
	35 => "Salir",
	36 => "sobre",
	37 => "No hay noticias del(a) usuario(a)",
	38 => "",
	39 => "Actualizar",
	40 => "",
	41 => "Usuarios Invitados",
	42 => "Escrito por:",
	43 => "Responder a",
	44 => "Retornar",
	45 => "Número de Error MySQL",
	46 => "Mensaje de Error MySQL",
	47 => "Funciones del(a) usuario(a)",
	48 => "Mi cuenta",
 	49 => "Mis Preferencias",
	50 => "Error en una sentencia SQL",
	51 => "ayuda",
	52 => "Nuevo",
	53 => "Sección de Administración",
	54 => "No se ha podido abrir el archivo.",
	55 => "Error en",
	56 => "Votar",
	57 => "Contraseña",
	58 => "Identificación",
	59 => "¿No tienes una cuenta todavía? <a href=\"{$_CONF['site_url']}/users.php?mode=new\">Inscríbete</a>",
	60 => "Agregar un comentario",
	61 => "Crear una Nueva Cuenta",
	62 => "palabras",
	63 => "Preferencias de Noticias",
	64 => "Enviar a un(a) amigo(a)",
	65 => "Ver la versión para imprimir",
	66 => "Mi Calendario",
	67 => "Bienvenido(a) a ",
	68 => "Página Inicial",
	69 => "contacto",
	70 => "buscar",
	71 => "enviar noticia",
	72 => "enlaces a otras webs",
	73 => "encuestas anteriores",
	74 => "calendario",
	75 => "búsqueda avanzada",
	76 => "estadísticas del sitio",
	77 => "Plugins",
	78 => "Próximos Eventos",
	79 => "Novedades",
	80 => "noticias",
	81 => "noticia",
	82 => "horas",
	83 => "COMENTARIOS",
	84 => "ENLACES",
	85 => "últimas 48 horas",
	86 => "No hay nuevos comentarios",
	87 => "últimas 2 semanas",
	88 => "No hay nuevos enlaces",
	89 => "No hay próximos eventos",
	90 => "Página Inicial",
	91 => "Esta página fue creada en",
	92 => "segundos",
	93 => "Derechos de autor",
	94 => "Todas las marcas y derechos en esta página son de sus respectivos dueños.",
	95 => "Otra web montada con",
	96 => "Grupos",
        97 => "Lista de Palabras",
	98 => "Plug-ins",
	99 => "NOTICIAS",
       100 => "No hay noticias nuevas",
       101 => 'Mis Eventos',
       102 => 'Eventos del sitio',
       103 => 'Copias de seguridad de la Base de Datos',
       104 => 'por',
       105 => 'Usuarios del Correo',
       106 => 'Vistas',
       107 => 'Comprobación de la versión de GL',
       108 => 'Limpiar copia de visitas (Caché)'
);


###############################################################################
# calendar.php

$LANG02 = array(
	1 => "Calendario de Eventos",
	2 => "Disculpa, no hay eventos para mostrar.",
	3 => "Cuando",
	4 => "Donde",
	5 => "Descripción",
	6 => "Agregar un Evento",
	7 => "Próximos Eventos",
	8 => 'Al agregar este evento a tu calendario podrás ver rápidamente los eventos que te interesen. Para ello elije "Mi Calendario" en el área de Funciones del(a) usuario(a).',
	9 => "Agregar a Mi Calendario",
	10 => "Sacar de Mi Calendario",
	11 => "Agregando el Evento al Calendario de {$_USER['username']}",
	12 => "Evento",
	13 => "Empieza",
	14 => "Termina",
	15 => "Volver al Calendario"

);

###############################################################################
# comment.php

$LANG03 = array(
	1 => "Agregar un Comentario",
	2 => "Tipo de envio",
	3 => "Salir",
	4 => "Crear una Cuenta",
	5 => "Nombre del(a) usuario(a)",
	6 => "Este sitio requiere que tengas una cuenta para enviar un comentario. Si ya la tienes, ingresa el nombre de usuario y la contraseña. Si no tienes una cuenta, puedes crear una nueva en el formulario de abajo",
	7 => "Tu último comentario fue hace ",
	8 => " segundos. Este sitio requiere al menos {$_CONF["commentspeedlimit"]} segundos entre comentarios",
	9 => "Comentario",
	10 => '',
	11 => "Enviar el Comentario",
	12 => "Por favor completa el Título y Comentario, ya que son datos necesarios para enviar un comentario.",
	13 => "Tu Información",
	14 => "Vista Previa",
	15 => "",
	16 => "Título",
	17 => "Error",
	18 => 'Cosas Importantes',
	19 => 'Por favor intenta mantener el tema de la noticia.',
	20 => 'Intenta responder a los comentarios de los demás en lugar de comenzar una nueva discusión.',
	21 => 'Lee los comentarios enviados para evitar comentarios duplicados.',
	22 => 'Utiliza un título claro que describa el contenido de tu mensaje.',
	23 => 'Tu dirección de correo electrónico NO será divulgada.',
	24 => 'Usuario Anónimo'
);

###############################################################################
# users.php

$LANG04 = array(
	1 => "Perfil del(a) usuario(a) para",
	2 => "Nombre del(a) usuario(a)",
	3 => "Nombre Completo",
	4 => "Contraseña",
	5 => "Correo electrónico",
	6 => "Página personal",
	7 => "Biografía",
	8 => "Clave PGP",
	9 => "Guardar la Información",
	10 => "Últimos 10 comentarios",
	11 => "No hay comentarios",
	12 => "Preferencias del(a) usuario(a) para",
	13 => "Enviar un resumen cada noche por correo electrónico",
	14 => "Esta contraseña se genera al azar. Se recomienda que cambies la contraseña cuanto antes. Para cambiar la contraseña conecta al sitio con tu nombre de usuario.",
	15 => "Tu cuenta en {$_CONF["site_name"]} se ha creado satisfactoriamente. Para poder utilizarla tienes que ingresar utilizando los datos dados más abajo. Guarda este mensaje para futuras referencias.",
	16 => "Información de tu cuenta",
	17 => "La cuenta no existe",
	18 => "La dirección de correo electrónico ingresada no parece ser válida.",
	19 => "el(la) usuario(a) y la dirección de correo electrónico ingresados ya existen",
	20 => "La dirección de correo electrónico ingresada no parece ser válida.",
	21 => "Error",
	22 => "Inscríbete en {$_CONF['site_name']}!",
	23 => "Crear una cuenta te dará los beneficios de los usuarios de {$_CONF['site_name']} y te permitirá enviar noticias, comentarios, etc. Si no tienes una cuenta sólo lo podrás hacer anónimamente. Queremos remarcar que tu dirección de correo electrónico <b><i>nunca</i></b> será publicada en este sitio.",
	24 => "Tu Contraseña se enviará a la dirección de correo electrónico que ingreses.",
	25 => "¿Olvidaste tu contraseña?",
 	26 => "Ingresa <em>o</em> tu nombre de usuario <em>o</em> la dirección de correo electrónico que utilizaste para inscribirte y pulsa Enviar Contraseña. Te llegarán por correo electrónico las instrucciones para crear una contraseña nueva a la dirección que figura en el archivo,.",
	27 => "¡Inscríbete ahora!",
	28 => "Enviar la contraseña por correo electrónico",
	29 => "desconectado(a) de",
	30 => "conectado(a) a",
	31 => "La función que has elegido requiere que estés conectado(a)",
	32 => "Firma",
	33 => "No se mostrará públicamente",
	34 => "Este es tu nombre de verdad",
	35 => "Ingresa la contraseña para cambiarla",
	36 => "Comienza con http://",
	37 => "Se aplica a tus comentarios",
	38 => "¡Todo sobre Ti! Todos van a poder leer esto.",
	39 => "Tu clave pública de PGP para compartir",
	40 => "Sin iconos de secciones",
	41 => "Intención de moderar",
	42 => "Formato de fecha",
	43 => "Cantidad máxima de noticias",
	44 => "Sin recuadros",
	45 => "Mostrar las preferencias de",
	46 => "Elementos excluídos de",
	47 => "Configuración de Noticias para",
	48 => "Secciones",
	49 => "Sin iconos en las noticias",
	50 => "No selecciones esto si no estás interesado",
	51 => "Sólo las noticias nuevas",
	52 => "El valor por defecto es",
	53 => "Recibir cada noche las noticias del día",
	54 => "Selecciona las Secciones y Autores que no quieres ver.",
	55 => "Si no seleccionas ninguna significa que quieres la selección por defecto. De seleccionar, selecciona todas las de tu interés ya que las opciones por defecto ya no serán tomadas en cuenta. Las opciones por defecto se muestran resaltadas.",
	56 => "Autores",
	57 => "Modo de Presentación",
	58 => "Orden de clasificación",
	59 => "Límite por Comentario",
	60 => "¿Cómo quieres ver los comentarios?",
	61 => "¿Primero los más antiguos o los más recientes?",
	62 => "El valor por defecto es 100",
	63 => "Gracias por utilizar {$_CONF['site_name']}. Te hemos enviado tu contraseña por correo electrónico y llegará en unos instantes. Por favor sigue las instrucciones del mensaje.",
	64 => "Preferencias para los comentarios de",
	65 => "Intenta reconectarte otra vez",
	66 => "Los datos ingresados no son válidos. Intenta reconectar abajo. ¿Eres un <a href=\"{$_CONF['site_url']}/users.php?mode=new\">usuario(a) nuevo(a)</a>?",
	67 => "Miembro desde",
	68 => "Recuérdame durante",
	69 => "¿Cuánto tiempo tenemos que mantener tu nombre de usuario(a) en activo después de conectar?",
	70 => "Personaliza la apariencia y el contenido de {$_CONF['site_name']}",
	71 => "Una de las grandes virtudes de {$_CONF['site_name']} es que puedes personalizar el contenido que recibes y la apariencia del sitio. Para poder lograr esto tienes primero que <a href=\"{$_CONF['site_url']}/users.php?mode=new\"> inscribirte</a> en {$_CONF['site_name']}. Si ya eres miembro, utiliza el formulario de la izquierda para conectarte.",
	72 => "Tema",
    	73 => "Idioma",
	74 => "¡Cambia la apariencia de esta página!",
	75 => "Secciones enviadas por correo electrónico a",
	76 => "Si seleccionas una o más Secciones de la lista de abajo, todas las noticias nuevas de esas Secciones te serán enviadas por correo electrónico al finalizar el día.",
    77 => "Foto",
    78 => "¡Añade una foto tuya!",
    79 => "Activa esto para borrar esta imagen",
    80 => "Identificación",
    81 => "Enviar correo electrónico",
    82 => 'Últimas 10 noticias para el(la) usuario(a)',
    83 => 'Estadísticas de noticias para el(la) usuario(a)',
    84 => 'Número total de artículos:',
    85 => 'Número total de comentarios:',
     86 => 'Buscar todos los comentarios de',
     87 => 'Tu nombre de acceso',
     88 => 'Alguien (posiblemente tú mismo(a)) ha solicitado una contraseña nueva para tu cuenta  "%s" en ' . $_CONF['site_name'] . ', <' . $_CONF['site_url'] . ">.\n\nSi quieres de verdad que se lleve a cabo esta acción, por favor pulsa en el enlace siguiente:\n\n",
     89 => "si no quieres que se lleve a cabo esta acción, simplemente ignora este mensaje y la petición sera desatendida (tu contraseña no se modificará).\n\n",
     90 => 'Puedes ingresar abajo una contraseña nueva para tu cuenta. Por favor, toma nota que la contraseña antigua seguirá siendo válida hasta que envies este formulario.',
     91 => 'Crear Contraseña Nueva',
     92 => 'Ingresar Contraseña Nueva',
     93 => 'Tu última petición de una contraseña nueva fue hace %d segundos. Este sitio requiere como mínimo %d segundos entre peticiones de contraseñas.',
     94 => 'Borrar la cuenta "%s"',
     95 => 'Pulsar abajo el botón "borrar la cuenta" para retirar tu cuenta de nuestra base de datos. Por favor, toma nota que cualquier noticia o comentario que hayas contribuído bajo esta cuenta <strong>no</strong> se borrará, sino que aparecerá como "Anónimo".',
     96 => 'borrar la cuenta',
     97 => 'Confirmar el borrado de la Cuenta',
     98 => '¿Estás seguro(a) que quieres borrar tu cuenta? Al hacerlo así, no podrás acceder a este sitio otra vez (a no ser que crees una cuenta nueva). Si estás seguro(a), pulsa "borrar cuenta" de nuevo en el formulario de abajo.',
     99 => 'Opciones de privacidad para',
     100 => 'Correo del(a) Administrador(a)',
     101 => 'Permitir correo de los(as) Administradores(as) del sitio',
     102 => 'Correo de los usuarios',
     103 => 'Permitir correo de otros usuarios',
     104 => 'Mostrar el estado de quien está conectado(a)',
     105 => 'Mostrar en el bloque Who\'s Online (usuarios conectados)'
);


###############################################################################
# index.php

$LANG05 = array(
	1 => "No hay novedades para mostrar",
	2 => "No hay nuevas noticias para mostrar. Puede que no haya novedades para esta Sección o que tus preferencias sean muy restrictivas.",
	3 => "para la Sección $topic",
	4 => "Noticia del Día",
	5 => "Siguiente",
	6 => "Anterior"
);

###############################################################################
# links.php

$LANG06 = array(
	1 => "Enlaces",
	2 => "No hay enlaces para mostrar.",
	3 => "Agregar un enlace"
);

###############################################################################
# pollbooth.php

$LANG07 = array(
	1 => "Voto guardado",
	2 => "Tu voto se ha computado para la encuesta",
	3 => "Vota",
	4 => "Encuestas en el sistema",
 	5 => "Votos",
 	6 => "Ver las otras preguntas de la encuesta"
);

###############################################################################
# profiles.php

$LANG08 = array(
	1 => "Hubo un error al enviar tu mensaje. Inténtalo de nuevo por favor.",
	2 => "El mensaje fue enviado satisfactoriamente.",
	3 => "Por favor asegúrate de ingresar una dirección de correo electrónico válida en el campo 'Responder a'.",
	4 => "Por favor completa los campos Remitente, Responder a, Título y Mensaje",
        5 => "Error: No existe el(la) usuario(a).",
	6 => "Hubo un error.",
	7 => "Perfil de usuario(a) de",
	8 => "Nombre del(a) usuario(a)",
	9 => "URL del(a) usuario(a)",
	10 => "Enviar mensaje a",
	11 => "Remitente:",
	12 => "Responder a:",
	13 => "Título:",
	14 => "Mensaje:",
	15 => "No se traducirá el código HTML.",
	16 => "Enviar el mensaje",
	17 => "Enviar a un(a) amigo(a)",
	18 => "Destinatario(a)",
	19 => "Dirección de correo electrónico de destino",
	20 => "Remitente",
	21 => "Responder a",
	22 => "Es necesario rellenar todos los campos",
	23 => "Este correo electrónico te lo envió $from en $fromemail porque pensó que podría interesarte esta noticia en  {$_CONF["site_url"]}. Esto no es SPAM (correo basura) y las direcciones de correo electrónico involucradas en este envío no se han guardado para su uso posterior.",
	24 => "Comentario sobre esta noticia en",
	25 => "Tienes que conectarte para utilizar esta herramienta. Este control se realiza para evitar el mal uso del sistema.",
	26 => "Este formulario te permitirá enviar un correo electrónico al usuario seleccionado. Todos los campos son necesarios.",
	27 => "Mensaje corto",
	28 => "$from escribió: $shortmsg",
    29 => "Este es el resúmen diario de {$_CONF['site_name']} para ",
    30 => " Noticias diarias para ",
    31 => "Título",
    32 => "Fecha",
    33 => "Lee la Noticia completa en",
    34 => "Fin del mensaje",
    35 => 'Lo siento, este usuario prefiere no recibir mensajes.'
);

###############################################################################
# search.php

$LANG09 = array(
	1 => "Búsqueda Avanzada",
	2 => "Palabras Clave",
	3 => "Sección",
	4 => "Todo",
	5 => "Tipo",
	6 => "noticias",
	7 => "Comentarios",
	8 => "Autores",
	9 => "Todo",
	10 => "Buscar",
	11 => "Resultados de la búsqueda",
	12 => "resultados",
	13 => "Búsqueda de noticias: No hubo coincidencias",
	14 => "No se encontraron coincidencias al buscar: ",
	15 => "Por favor inténtalo de nuevo.",
	16 => "Título",
	17 => "Fecha",
	18 => "Autor",
	19 => "Buscar en toda la base de datos de <B>{$_CONF["site_name"]}</B>",
	20 => "Fecha",
	21 => "a",
	22 => "(Formato de fecha DD-MM-YYYY)",
 	23 => "Vistas",
 	24 => "Encontrados %d elementos",
 	25 => "coincidencias con",
 	26 => "elementos en ",
	27 => "segundos",
    28 => 'No se encontraron coincidencias en Noticias y Comentarios',
    29 => 'Resultados de las Noticias y Comentarios',
    30 => 'Ningún enlace coincide con tu búsqueda',
    31 => 'Este plug-in no ha dado resultados',
    32 => 'Evento',
    33 => 'URL',
    34 => 'Ubicación',
    35 => 'Todo el dia',
    36 => 'Ningún evento coincidió con tu búsqueda',
    37 => 'Resultados de Eventos',
    38 => 'Resultados de Enlaces',
    39 => 'Enlaces',
    40 => 'Eventos',
    41 => 'Tu búsqueda  tiene que tener al menos 3 letras.',
     42 => 'Por favor utiliza una fecha formateada como YYYY-MM-DD (año-mes-día).',
     43 => 'frase exacta',
     44 => 'todas estas palabras',
     45 => 'cualquiera de estas palabras',
     46 => 'Siguiente',
     47 => 'Anterior',
     48 => 'Autor(a)',
     49 => 'Fecha',
     50 => 'Vistas',
     51 => 'Enlace',
     52 => 'Ubicación',
     53 => 'Resultados de la noticia',
     54 => 'Resultados de Comentario',
     55 => 'la frase',
     56 => 'Y',
     57 => 'O'
);

###############################################################################
# stats.php

$LANG10 = array(
	1 => "Estadísticas del sitio",
	2 => "Total de accesos al sistema",
	3 => "Noticias(Comentarios) en el sistema",
	4 => "Encuestas(Respuestas) en el sistema",
	5 => "Enlaces(Visitados) en el sistema",
	6 => "Eventos en el sistema",
	7 => "Las 10 Noticias más vistas",
	8 => "Título de la Noticia",
	9 => "Accesos",
	10 => "Parece que no hay noticias en este sitio o que nadie las ha visto todavía.",
	11 => "Las 10 noticias más comentadas",
	12 => "Comentarios",
	13 => "Parece que no hay noticias en este sitio o que nadie ha escrito un comentario sobre ellas.",
	14 => "Las 10 Encuestas con más votos",
	15 => "Pregunta",
	16 => "Votos",
	17 => "Parece que no hay encuestas en este sitio o que nadie ha votado.",
	18 => "Los 10 Enlaces más visitados",
	19 => "Enlaces",
	20 => "Visitas",
	21 => "Parece que en este sitio no hay Enlaces o que nadie los ha visitado.",
	22 => "Las 10 Noticias más enviadas por correo electrónico",
	23 => "mensajes por correo electrónico",
	24 => "Parece que nadie ha enviado una noticia por correo electrónic en este sitio."
);

###############################################################################
# article.php

$LANG11 = array(
	1 => "Relacionado con esto...",
	2 => "Enviar a un(a) amigo(a)",
	3 => "Versión para imprimir",
	4 => "Opciones de la Noticia"
);

###############################################################################
# submit.php

$LANG12 = array(
	1 => "Para enviar $type tienes que estar conectado(a) como usuario(a).",
	2 => "Ingresar",
	3 => "Usuario(a) Nuevo(a)",
	4 => "Agregar un Evento",
	5 => "Agregar un Enlace",
	6 => "Agregar una noticia",
	7 => "Tienes que conectarte",
	8 => "Enviar colaboraciones",
	9 => "Cuando envias información a este sitio te pedimos que tomes en cuenta los siguientes consejos: <ul><li>Completa todos los campos requeridos<li>Comprueba bien los URL's<li>Facilita información completa y precisa</ul>",
	10 => "Título",
	11 => "Enlace",
	12 => "Fecha de inicio",
	13 => "Fecha de finalización",
	14 => "Lugar",
	15 => "Descripción",
	16 => "Si es otra, especifica",
	17 => "Categoría",
	18 => "Otra",
        19 => "Leer antes",
	20 => "Error: Falta la Categoría",
	21 => "Por favor, cuando selecciones 'Otra' completa el nombre de la categoría",
	22 => "Error: Faltan Campos",
	23 => "Por favor completa todo los campos del formulario. Es necesario rellenar todos los campos.",
	24 => "Colaboración guardada",
	25 => "Tus colaboraciones se han guardado satisfactoriamente.",
	26 => "Límite de Velocidad",
	27 => "Nombre del(a) usuario(a)",
	28 => "Sección",
	29 => "Noticia",
	30 => "Tu última colaboración fue hace ",
	31 => " segundos.  Este sitio requiere como mínimo {$_CONF["speedlimit"]} segundos entre envíos",
	32 => "Vista Previa",
	33 => "Vista previa de la noticia",
	34 => "Salir",
	35 => "No se permiten etiquetas de HTML",
	36 => "Formato del texto",
	37 => "Los Eventos enviados a {$_CONF["site_name"]} se agregan al Calendario Público, donde el resto de los usuarios pueden agregarlo a su Calendario Personal. Esta función <b>NO</b> está pensada para que guardes tus eventos personales como cumpleaños, citas, etc.<br><br>Una vez enviado, el evento será evaluado por los Administradores. De ser aprobado, se mostrará en el Calendario Público",
  	38 => "Agregar un Evento a",
  	39 => "Calendario Público",
  	40 => "Calendario Personal",
  	41 => "Hora de Finalización",
  	42 => "Hora de Inicio",
  	43 => "Evento que dura todo el día",
  	44 => 'Dirección, línea 1',
  	45 => 'Dirección, línea 2',
  	46 => 'Ciudad/Localidad',
  	47 => 'Provincia/Estado',
  	48 => 'Código Postal',
  	49 => 'Tipo de Evento',
  	50 => 'Editar los Tipos de Eventos',
  	51 => 'Lugar',
  	52 => 'Borrar',
    53 => 'Crear una Cuenta'

);

###############################################################################

# ADMIN PHRASES - These are file phrases used in end admin scripts

###############################################################################

###############################################################################
# auth.inc.php

$LANG20 = array(
	1 => "Se requiere verificación",
	2 => "¡Acceso denegado! La información de ingreso es incorrecta",
	3 => "La contraseña ingresada es inválida",
	4 => "Usuario(a):",
	5 => "Contraseña:",
	6 => "Todo acceso a las partes administrativas queda registrado y revisado.<br>Esta página es para uso exclusivo del personal autorizado.",
	7 => "Identificación"
);

###############################################################################
# block.php

$LANG21 = array(
	1 => "No tienes derechos de Administrador(a)",
	2 => "No tienes los derechos suficientes para editar este bloque.",
	3 => "Editor de Bloques",
	4 => "",
	5 => "Título del Bloque",
	6 => "Sección",
	7 => "Todo",
	8 => "Nivel de seguridad del bloque",
	9 => "Orden del Bloque",
	10 => "Tipo de bloque",
	11 => "Bloque del Sistema",
	12 => "Bloque Normal",
	13 => "Opciones para el Bloque del Sistema",
	14 => "RDF(Resource Description Framework)URL",
	15 => "última actualización del RDF",
	16 => "Opciones para el Bloque Normal",
	17 => "Contenido del Bloque",
	18 => "Por favor completa los campos Título, Nivel de Seguridad y Contenido del bloque",
	19 => "Administrador",
	20 => "Título",
	21 => "Nivel de Seguridad",
	22 => "Tipo",
	23 => "Número de Orden",
	24 => "Sección",
	25 => "Para modificar o borrar un bloque, selecciónalo más abajo. Para crear uno nuevo, selecciona 'Nuevo Bloque' arriba.",
	26 => "Bloque de maquetación",
	27 => "Bloque de PHP",
        28 => "Opciones del Bloque PHP",
        29 => "Funciones del Bloque",
        30 => "Si quieres que tu bloque utilice código PHP, ingresa aquí el nombre de la función. La función tiene que tener el prefijo \"phpblock_\" (ej. phpblock_getweather). De no tenerlo NO será invocada. Asegúrate de no incluir los paréntesis, \"()\", al final del nombre. Por último, se recomienda que guardes todo código PHP en /path/to/geeklog/system/lib-custom.php. Esto te permitirá que tu código se mantenga aún entre cambios de versiones del sistema.",
        31 => 'Error en un Bloque PHP.  La función, $function, no existe.',
        32 => "Error, Faltan Campos",
        33 => "Tienes que ingresar el URL del archivo .rdf para los Bloques del Sistema",
        34 => "Tienes que ingresar el Título y la Función en los Bloques PHP",
        35 => "Tienes que ingresar el Título y el Contenido para los Bloques Normales",
        36 => "Tienes que ingresar el contenido para los Bloques de Maquetación",
        37 => "El nombre de la función en el Bloque PHP es inválido",
        38 => "Las funciones para los Bloques PHP tienen que tener el prefijo 'phpblock_' (ej. phpblock_getweather). Se requiere el prefijo por cuestiones de seguridad, para evitar que se ejecute código no deseado.",
	39 => "Ubicación",
	40 => "Izquierda",
	41 => "Derecha",
        42 => "Tienes que ingresar el número de orden y el nivel de seguridad para los bloques por defecto",
	43 => "Sólo en la Página de Inicio",
	44 => "Acceso Denegado",
	45 => "Estás intentando acceder a un bloque al que no tienes derechos de acceso.  Este intento se ha registrado. Por favor <a href=\"{$_CONF["site_admin_url"]}/block.php\">regresa a la pantalla de administración de bloques</a>.",
	46 => 'Nuevo Bloque',
	47 => 'Página de Inicio - Administrador',
  	48 => 'Nombre del Bloque',
  	49 => ' (sin espacios y tiene que ser único)',
  	50 => 'URL del archivo de ayuda',
  	51 => 'incluir http://',
  	52 => 'Si dejas este campo en blanco no se mostrará el ícono de ayuda',
	53 => 'Habilitado',
        54 => 'guardar',
        55 => 'cancelar',
        56 => 'borrar'
);

###############################################################################
# event.php

$LANG22 = array(
	1 => "Editor de Eventos",
	2 => "",
	3 => "Título",
	4 => "URL",
	5 => "Fecha de Inicio",
	6 => "Fecha de Finalización",
	7 => "Lugar",
	8 => "Descripción",
	9 => "(incluir http://)",
	10 => "Tienes que completar todos los campos de este formulario.",
	11 => "Administrador del Evento",
 	12 => "Para modificar o borrar un evento, pulsa en ese evento abajo. Para crear un Nuevo Evento pulsa sobre Evento Nuevo arriba. Pulsa sobre [C] para crear una copia de un evento ya existente.",
	13 => "Título",
	14 => "Fecha de Inicio",
	15 => "Fecha de Finalización",
	16 => "Acceso Denegado",
	17 => "No tienes permiso para acceder a este Evento. Todo intento de acceso será registrado. Por favor, vuelve a <a href=\"{$_CONF["site_admin_url"]}/event.php\">la página de Administración de Eventos</a>.",
	18 => 'Nuevo Evento',
	19 => 'Página de Inicio - Administrador',
        20 => 'guardar',
        21 => 'cancelar',
        22 => 'borrar'
);

###############################################################################
# link.php

$LANG23 = array(
	1 => "Editor de Enlaces",
	2 => "",
	3 => "Título",
	4 => "URL",
	5 => "Categoria",
	6 => "(incluir http://)",
	7 => "Otro",
	8 => "Cantidad de accesos",
	9 => "Descripción",
	10 => "Tienes que completar los campos Título, URL y Descripción.",
	11 => "Administrador",
	12 => "Para modificar o borrar un Enlace selecciónalo más abajo. Para crear uno nuevo selecciona 'Nuevo Enlace' más arriba.",
	13 => "Título",
	14 => "Categoría",
	15 => "URL",
	16 => "Acceso Denegado",
	17 => "No tienes permiso para acceder a este Enlace. Todo intento de acceso será registrado. Por favor, vuelve a <a href=\"{$_CONF["site_admin_url"]}/link.php\">la página de Administración de Enlaces</a>.",
	18 => 'Nuevo Enlace',
	19 => 'Página de Inicio - Administrador',
	20 => 'Si es otra/o, especifica',
    21 => 'guardar',
    22 => 'cancelar',
    23 => 'borrar'
);

###############################################################################

# story.php

$LANG24 = array(
	1 => "Noticias Anteriores",
	2 => "Noticias Siguientes",
	3 => "Modo",
	4 => "Modo de envio",
	5 => "Editor de Noticias",
	6 => "No hay Noticias en el sistema",
	7 => "Autor",
	8 => "guardar",
	9 => "vista previa",
	10 => "cancelar",
	11 => "borrar",
	12 => "",
	13 => "Título",
	14 => "Sección",
	15 => "Fecha",
	16 => "Introducción",
	17 => "Texto",
	18 => "Accesos",
	19 => "Comentarios",
	20 => "",
	21 => "",
	22 => "Listado de Noticias",
	23 => "Para modificar o borrar una Noticia selecciona el número de Noticia más abajo. Para ver la Noticia selecciona el título de la misma. Para crear una nueva Noticia selecciona 'Enviar Noticia' más arriba.",
	24 => "",
	25 => "",
	26 => "Vista Previa",
	27 => "",
	28 => "",
	29 => "",
 	30 => 'Errores al Subir Archivos',
 	31 => "Por favor rellena los campos de Autor, Título y Texto",
	32 => "Destacada",
	33 => "Sólo puede haber una Noticia destacada",
	34 => "Borrador",
	35 => "Sí",
	36 => "No",
	37 => "Más de",
	38 => "Más en",
	39 => "correos electrónicos",
	40 => "Acceso Denegado",
	41 => "Estás intentando acceder a una Noticia a la que no tienes derechos de acceso, por lo que podrás ver la Noticia pero no editarla. Por favor vuelve a la <a href=\"{$_CONF["site_admin_url"]}/story.php\">página de administración</a> cuando hayas terminado.",
        42 => "Estás intentando acceder a una Noticia a la que no tienes derechos de acceso. Por favor vuelve a la <a href=\"{$_CONF["site_admin_url"]}/story.php\">página de administración</a>.",
        43 => 'Nueva Noticia',
	44 => 'Página de Inicio - Administrador',
	45 => 'Acceso',
        46 => '<b>NOTA:</b> si modificas esta fecha por una futura, la Noticia no se publicará hasta esa fecha. Esto también incluye el envió de titulares RDF(Resource Description Framework), la búsqueda y las estadísticas del sitio.',
        47 => 'Imágenes',
        48 => 'imagen',
        49 => 'der',
        50 => 'izq',
        51 => 'Para insertar una imagen en la Noticia tienes que incluir un texto con el formato [imagenX], [imagenX_der] o [imagenX_izq], donde X es el número de imagen dentro de la lista. NOTA: sólo puedes utilizar las imágenes de la lista, si no la Noticia no se podrá guardar',
        52 => 'Borrar',
        53 => 'no se ha utilizado.  Tienes que incluir esta imagen en la Introducción o el Texto para poder guardar los cambios',
        54 => 'Imágenes no utilizadas',
        55 => 'Los siguientes errores ocurrieron al querer guardar tu Noticia. Por favor corrije los errores antes de guardar.',
     56 => 'Mostrar icono de Tema',
     57 => 'Ver imagen sin proporción'
);

###############################################################################
# poll.php

$LANG25 = array(
	1 => "Modo",
 	2 => 'Por favor teclea una pregunta y como mínimo una respuesta.',
	3 => "Fecha de creación",
	4 => "Encuesta $qid guardada",
	5 => "Editar la Encuesta",
	6 => "Identificación",
	7 => "(no utilices espacios)",
	8 => "Aparece en la Portada",
	9 => "Pregunta",
	10 => "Respuestas / Votos",
	11 => "Hubo un error al buscar los datos para las respuesta de la Encuesta $qid",
	12 => "Hubo un error al buscar los datos para la pregunta de la Encuesta $qid",
	13 => "Crear Encuesta",
	14 => "guardar",
	15 => "cancelar",
	16 => "borrar",
 	17 => 'Por favor teclea un nombre de identificación (ID) de la encuesta',
	18 => "Listado de Encuestas",
	19 => "Para modificar o borrar una Encuesta elíjela en la lista de abajo. Para crear una nueva, selecciona 'Nueva Encuesta' más arriba.",
	20 => "Votantes",
	21 => "Acceso Denegado",
	22 => "Estás intentando acceder a una Encuesta a la que no tienes derechos de acceso. Por favor vuelve a la <a href=\"{$_CONF["site_admin_url"]}/poll.php\">página de administración.",
	23 => 'Nueva Encuesta',
	24 => 'Página de Inicio - Administrador',
        25 => 'Sí',
	26 => 'No'
);

###############################################################################
# topic.php

$LANG27 = array(
	1 => "Editor de Secciones",
	2 => "Identificación (ID)",
	3 => "Nombre",
	4 => "Imagen",
	5 => "(no utilices espacios)",
	6 => "Al borrar una Sección se borrarán todas tus Noticias y Bloques asociados",
	7 => "Por favor completa los campos ID y Nombre",
        8 => "Administrador de Secciones",
 	9 => "Para modificar o borrar un tema, pulsa sobre ese tema. Para crear un tema nuevo, pulsa el botón de Nuevo Tema en la izquierda. Encontrarás tu nivel de acceso para tema en paréntesis. El asterisco(*) denota el tema  por defecto.",
	10=> "Número de Orden",
	11 => "Noticias/Página",
	12 => "Acceso Denegado",
	13 => "Estás intentando acceder a una Sección a la que no tienes derechos de acceso. Por favor vuelve a la <a href=\"{$_CONF["site_admin_url"]}/topic.php\">página de administración.",
	14 => "Método de Ordenamiento",
	15 => "alfabético",
	16 => "por defecto es",
	17 => "Nueva Sección",
	18 => "Página de Inicio - Administrador",
        19 => 'guardar',
        20 => 'cancelar',
     21 => 'borrar',
     22 => 'Por defecto',
     23 => 'convertir en el tema por defecto para nuevas colaboraciones',
     24 => '(*)'
);

###############################################################################
# user.php

$LANG28 = array(
	1 => "Editor de Usuarios",
	2 => "ID",
	3 => "Nombre de Usuario(a)",
	4 => "Nombre Completo",
	5 => "Contraseña",
	6 => "Nivel de Seguridad",
	7 => "Dirección de correo electrónico",
	8 => "Página de Inicio",
	9 => "(no utilices espacios)",
 	10 => " Por favor, rellena los campos de Nombre de Usuario(a) y dirección de correo electrónico",
	11 => "Administrador de Usuarios",
 	12 => "Para modificar o borrar a un(a) usuario(a), pulsa sobre ese(a) usuario(a) abajo.  Para crear un(a) usuario(a) nuevo(a) pulsa el botón de Nuevo Usuario en la izquierda. Puedes hacer búsquedas sencillas al teclear partes del nombre de usuario, dirección de correo electrónico o nombre completo (por ejemplo *son* o *.edu) en el formulario de abajo..",
	13 => "Nivel de seguridad",
        14 => "Fecha de Inscripción",
	15 => 'Nuevo Usuario',
	16 => 'Página de Inicio - Administrador',
	17 => 'Cambiar-Contraseña',
	18 => 'Cancelar',
	19 => 'Borrar',
	20 => 'Guardar',
    21 => 'El Nombre de Usuario(a) propuesto ya existe.',
    22 => 'Error',
    23 => 'Importación Masiva',
    24 => 'Importación masiva de Usuarios',
    25 => 'Puedes importar una lista de Usuarios(as) a '.$_CONF["site_name"].'. El archivo con la lista de usuarios(as) tiene que tener un registro por línea y los campos separados por TAB (tabulador). Los campos tienen que estar en el siguiente orden: Nombre Completo, Nombre de Usuario, Dirección de Correo electrónico. A cada usuario añadido se le enviará por correo electrónico una contraseña generada al azar, que podrán cambiar al ingresar al sitio. Por favor, ccomprueba bien el archivo de importación ya que los errores encontrados pueden llegar a requerir arreglos manuales.',
    26 => 'Buscar',
    27 => 'Limitar los resultados',
    28 => 'Marcar la casilla para borrar esta imagen',
    29 => 'Ruta',
    30 => 'Importar',
    31 => 'Nuevos Usuarios',
    32 => 'Proceso finalizado. Se importaron $successes y hubieron $failures fallos',
    33 => 'enviar',
    34 => 'Error: Tienes que especificar el archivo que quieres subir.',
    35 => 'Ultimo acceso',
    36 => '(nunca)'
);

###############################################################################
# moderation.php

$LANG29 = array(
	1 => "Aprobar",
	2 => "Borrar",
	3 => "Editar",
    4 => 'Perfil',
    10 => "Título",
    11 => "Fecha de Inicio",
    12 => "URL",
    13 => "Categoría",
    14 => "Fecha",
    15 => "Tema",
    16 => 'Nombre del(a) usuario(a)',
    17 => 'Nombre completo',
    18 => 'correo electrónico',
	34 => "Página de administración",
	35 => "Envíos de Noticias",
	36 => "Envíos de Enlaces",
	37 => "Envíos de Eventos",
	38 => "Enviar",
	39 => "No hay envíos para moderar en este momento",
    40 => "Envios del(a) usuario(a)"
);

###############################################################################
# calendar.php

$LANG30 = array(
	1 => "Domingo",
	2 => "Lunes",
	3 => "Martes",
	4 => "Miércoles",
	5 => "Jueves",
	6 => "Viernes",
	7 => "Sábado",
	8 => "Agregar un Evento",
 	9 => 'Evento de %s',
	10 => "Eventos para",
	11 => "Calendario Maestro",
	12 => "Mi Calendario",
	13 => "Enero",
	14 => "Febrero",
	15 => "Marzo",
	16 => "Abril",
	17 => "Mayo",
	18 => "Junio",
	19 => "Julio",
	20 => "Agosto",
	21 => "Septiembre",
	22 => "Octubre",
	23 => "Noviembre",
	24 => "Diciembre",
	25 => "Volver a ",
    26 => "Todo el día",
    27 => "Semana",
    28 => "Calendario Personal para",
    29 => "Calendario Público",
    30 => "borrar evento",
    31 => "Agregar",
    32 => "Evento",
    33 => "Fecha",
    34 => "Hora",
    35 => "Agregado rápido",
    36 => "Enviar",
    37 => "Disculpa, la opción de calendario personal no se encuentra habilitada en este sitio",
    38 => "Editor Personal de Eventos",
    39 => 'Día',
    40 => 'Semana',
    41 => 'Mes'
);

###############################################################################
# admin/mail.php

$LANG31 = array(
        1 => $_CONF['site_name'] . "Utilidad de correo electrónico",
 	2 => "De",
 	3 => "Responder a",
 	4 => "Título",
 	5 => "Mensaje",
 	6 => "Enviar a:",
 	7 => "Todos los usuarios",
 	8 => "Administrador",
	9 => "Opciones",
	10 => "HTML",
 	11 => "¡Mensaje Urgente!",
 	12 => "Enviar",
 	13 => "Reiniciar",
 	14 => "Ignorar las preferencias del(a) usuario(a)",
 	15 => "Error al mandar a: ",
	16 => "Se ha enviado satisfactoriamente a: ",
	17 => "<a href=" . $_CONF["site_admin_url"] . "/mail.php>Enviar otro mensaje</a>",
        18 => "Para",
        19 => "NOTA: si quieres enviar un mensaje a todos los miembros del sitio, selecciona el grupo Logged-In Users en la lista.",
        20 => "Se han enviado <successcount> mensajes satisfactoriamente y <failcount> han fallado.  Si quieres, los detalles de cada envío figuran abajo. Tambien puedes <a href=\"" . $_CONF['site_admin_url'] . "/mail.php\">enviar otro mensaje</a> o volver a <a href=\"" . $_CONF['site_admin_url'] . "/moderation.php\">la página de administración</a>.",
        21 => 'Fallidos',
        22 => 'Exitosos',
        23 => 'No ha habido envíos fallidos',
        24 => 'No ha habido envíos satisfactorios',
    25 => '-- Selecciona Grupo --',
    26 => "Por favor, rellena todos los campos del formulario y selecciona un grupo de usuarios de la lista desplegable."
);

###############################################################################
# confirmation and error messages

$MESSAGE = array (
	1 => "Tu contraseña se ha enviado por correo electrónico y llegará en unos instantes. Por favor sigue las indicaciones del mensaje. Gracias por utilizar " . $_CONF["site_name"],
	2 => "Gracias por enviar tu Noticia a {$_CONF["site_name"]}. La Noticia se encuentra en proceso de aprobación. De ser aprobada, podrá ser leida por todos los visitantes del sitio.",
	3 => "Gracias por enviar tu Enlace a {$_CONF["site_name"]}. El Enlace se encuentra en proceso de aprobación. De ser aprobado, podrá ser visto por todos los visitantes del sitio.",
	4 => "Gracias por enviar tu Evento a {$_CONF["site_name"]}. El Evento se encuentra en proceso de aprobación. De ser aprobado, podrá ser visto por todos los visitantes del sitio.",
	5 => "La información de tu cuenta se ha guardado satisfactoriamente.",
	6 => "Tus preferencias se han guardado satisfactoriamente.",
	7 => "Tus preferencias para Comentarios han sido guardadas satisfactoriamente.",
	8 => "Te has desconectado satisfactoriamente.",
	9 => "Tu Noticia se ha guardado satisfactoriamente.",
	10 => "La Noticia se ha borrado satisfactoriamente.",
	11 => "Tu Bloque se ha guardado satisfactoriamente.",
	12 => "El Bloque se ha borrado satisfactoriamente.",
	13 => "Tu Sección se ha guardado satisfactoriamente.",
	14 => "La Sección junto con todas tus Noticias y Bloques se han borrado satisfactoriamente.",
	15 => "Tu enlace se ha guardado satisfactoriamente.",
	16 => "El enlace se ha borrado satisfactoriamente.",
	17 => "Tu Evento se ha guardado satisfactoriamente.",
	18 => "El Evento se ha borrado satisfactoriamente.",
	19 => "Tu Encuesta se ha guardado satisfactoriamente.",
	20 => "La Encuesta se ha borrado satisfactoriamente.",
	21 => "El Nuevo Usuario se ha guardado satisfactoriamente.",
	22 => "El Usuario se ha borrado satisfactoriamente",
	23 => "Error al guardar el Evento en tu Calendario. No fue procesado el ID.",
	24 => "El Evento se ha guardado en tu Calendario",
25 => "No puedes acceder a tu Calendario Personal antes de conectarte como usuario",
	26 => "El Evento se ha borrado de tu Calendario Personal",
	27 => "Mensaje enviado satisfactoriamente.",
	28 => "El Plug-in se ha guardado satisfactoriamente",
	29 => "Disculpa, los Calendarios Personales no están habilitados en este sitio",
	30 => "Acceso Denegado",
	31 => "Disculpa, no tienes acceso a la página de administración de Noticias. Aclaramos que todo acceso sin autorización queda registrado en el servidor.",
	32 => "Disculpa, no tienes acceso a la página de administración de Secciones. Aclaramos que todo acceso sin autorización queda registrado en el servidor.",
	33 => "Disculpa, no tienes acceso a la página de administración de Bloques. Aclaramos que todo acceso sin autorización queda registrado en el servidor.",
	34 => "Disculpa, no tienes acceso a la página de administración de Enlaces. Aclaramos que todo acceso sin autorización queda registrado en el servidor.",
	35 => "Disculpa, no tienes acceso a la página de administración de Eventos. Aclaramos que todo acceso sin autorización queda registrado en el servidor.",
	36 => "Disculpa, no tienes acceso a la página de administración de Encuestas. Aclaramos que todo acceso sin autorización queda registrado en el servidor.",
	37 => "Disculpa, no tienes acceso a la página de administración de Usuarios. Aclaramos que todo acceso sin autorización queda registrado en el servidor.",
	38 => "Disculpa, no tienes acceso a la página de administración de Plug-in(s). Aclaramos que todo acceso sin autorización queda registrado en el servidor.",
	39 => "Disculpa, no tienes acceso a la página de administración de Correo electrónico. Aclaramos que todo acceso sin autorización queda registrado en el servidor.",
	40 => "Mensaje del Sistema",
        41 => "Disculpa, no tienes acceso a la página de Reemplazo de Palabras. Aclaramos que todo acceso sin autorización queda registrado en el servidor.",
        42 => "La Palabra fue guardada satisfactoriamente.",
	43 => "La Palabra fue borrada satisfactoriamente.",
        44 => 'El Plug-In fue instalado satisfactoriamente.',
        45 => 'El Plug-In fue borrado satisfactoriamente.',
        46 => "Disculpa, no tienes acceso a la herramienta de copia de seguridad de la base de datos. Aclaramos que todo acceso sin autorización queda registrado en el servidor.",
    47 => "Esta función está disponible bajo *nix. Si estás utilizando *nix como tu sistema operativo, entonces tu copia de visitas (cache) se ha limpiado satisfactoriamente. Si estás bajo Windows, tienes que buscar los archivos adodb_*.php y borrarlos manualmente.",
   48 => 'Gracias por registrarte como miembro en ' . $_CONF['site_name'] . '. Nuestro equipo comprobará tu solicitud. Si es aprobada, te será enviada tu Contraseña a la dirección correo electrónico que has indicado.',
    49 => "Tu grupo se ha guardado satisfactoriamente.",
    50 => "El grupo se ha borrado satisfactoriamente.",
    51 => 'Este nombre de usuario(a) ya está en uso. Por favor, elige otro.',
    52 => 'La dirección facilitada no parece una dirección válida de correo electrónico.',
    53 => 'Tu contraseña nueva se ha aceptada. Por favor, utiliza la contraseña nueva que parece abajo para ingresar de nuevo.',
    54 => 'Tu petición de contraseña nueva ha caducado. Por favor, vuelve a intentarlo abajo.',
    55 => 'El sistema te han enviado un correo electrónico y te llegará en breve. Por favor, sigue las instrucciones del mensaje para crear una contraseña nueva para tu cuenta.',
    56 => 'La dirección de correo electrónico facilitada ya está en uso en otra cuenta.',
    57 => 'Tu cuenta se ha borrado satisfactoriamente.'
);


// for plugins.php



$LANG32 = array (

	1 => "Instalar Plug-in(s) puede dañar tu instalación de Geeklog y, posiblemente, tu sistema. Es importante que sólo instales Plug-in(s) obtenidos de <a href=\"http://www.geeklog.net\" target=\"_blank\">Geeklog</a> ya que han sido comprobados en varios entornos. Es también importante que entiendas que la instalación del Plug-in requiere la ejecución de instrucciones del sistema que pueden traer problemas de seguridad. Aún con esta advertencia, no garantizamos el éxito de la instalación del Plug-in ni nos hacemos responsables por cualquier daño causado durante la instalación (o posterior a la misma). En otras palabras, instala el Plug-in a tu propio riesgo. Las instrucciones particulares de instalación vienen dentro de cada Plug-in.",
	2 => "Advertencia de la Instalación del Plug-in",
	3 => "Formulario de instalación del Plug-in",
	4 => "Archivo del Plug-in",
	5 => "Listado de(los) Plug-in(s)",
	6 => "Advertencia: ¡El Plug-in ya está instalado!",
	7 => "El Plug-in que intentas instalar ya existe. Por favor borra el Plug-in antes de reinstalarlo.",
	8 => "Falló la comprobación de compatibilidad del Plug-in",
	9 => "Este Plug-in requiere una versión más nueva de Geeklog. Puedes obtener una copia actualizada de <a href=http://www.geeklog.net>Geeklog</a> o instalar otra versión del Plug-in.",
	10 => "<br><b>No hay Plug-in(s) instalados.</b><br><br>",
	11 => "Para modificar o borrar un Plug-in selecciona el número a la izquierda del mismo. Para acceder a la página de sus creadores seleccione en el título del Plug-in. Para instalar un nuevo Plug-in selecciona 'Nuevo Plug-in' más arriba.",
	12 => 'no se ha dado un nombre de plugin a la función plugineditor()',
	13 => 'Editor de Plugins',
	14 => 'Nuevo Plug-in',
	15 => 'Página de Inicio - Administrador',
	16 => 'Plug-in Name',
	17 => 'Versión',
	18 => 'Versión de Geeklog',
	19 => 'Habilitado',
	20 => 'Sí',
	21 => 'No',
	22 => 'Instalar',
    23 => 'Guardar',
    24 => 'Cancelar',
    25 => 'Borrar',
    26 => 'Nombre',
    27 => 'Portada',
    28 => 'Versión',
    29 => 'Versión de Geeklog',
    30 => 'Borrar el Plug-in?',
    31 => '¿Estás seguro(a) que quieres borrar este Plug-in? Al hacerlo borrarás todos los archivos, estructuras y datos asociados. Si estás seguro/a selecciona "Borrar" en el formulario de abajo.'
);

$LANG_ACCESS = array(
	access => "Acceso",
    ownerroot => "Propietario/Raíz",
    group => "Grupo",
    readonly => "Sólo-Lectura",
	accessrights => "Derechos de acceso",
	owner => "Propietario",
	grantgrouplabel => "Establecer los derechos del Grupo",
	permmsg => "NOTA: miembros son todos los miembros conectados y los usuarios anónimos que están en el sitio.",
	securitygroups => "Grupos de Seguridad",
        editrootmsg => "Aunque seas un(a) Administrador(a) de Usuarios(as), no puedes editar a un usuario de raíz sin que te hayas dado de alta antes como usuario de raíz.  Puedes editar a todos los demás usuarios excepto los usuarios de raíz. Por favor, toma nota que cualquier intento de editar ilegalmente a los usuarios de raíz quedará registrado.  Por favor vuelve a <a href=\"{$_CONF["site_admin_url"]}/users.php\">la página de Administración de usuarios</a>.",
        securitygroupsmsg => "Selecciona las casillas para los grupos a los que quieres que pertenezca el usuario.",
	groupeditor => "Editor de Grupo",
	description => "Descripción",
	name => "Nombre",
 	rights => "Derechos",
	missingfields => "Campos que faltan",
	missingfieldsmsg => "Tienes que ingresar un nombre y una descripción para el Grupo.",
	groupmanager => "Administrador de Grupos",
	newgroupmsg => "Para modificar o borrar un grupo selecciona el grupo aquí abajo. Para crear un grupo selecciona 'Nuevo Grupo' aquí arriba. Ten en cuenta que los Grupos del Sistema no se pueden borrar.",
	groupname => "Nombre del Grupo",
	coregroup => "Grupo del Sistema? ",
	yes => "Sí",
	no => "No",
	corerightsdescr => "Este grupo es un Grupo de Sistema de {$_CONF["site_name"]}, y por lo tanto sus derechos no se pueden editar. A continuación se muestra una lista no editable de los derechos de acceso de este grupo.",
	groupmsg => "Los Grupos de Seguridad en este sitio son jerárquicos. Al agregar este grupo a cualquiera de los de abajo le estará dando los mismos derechos que esos grupos posean. De ser posible, se recomienda utilizar los grupos ya creados para dar los derechos a un nuevo grupo. Si tienes que modificar los derechos del grupo, puedes seleccionarlos en la sección llamada 'Derechos'. Para agregar este grupo a cualquiera de los de abajo simplemente marca los grupos que quieras.",
	coregroupmsg => "Este grupo es un Grupo de Sistema de {$_CONF["site_name"]}, y por ello los grupos que pertenezcan a este grupo no podrán ser editados. A continuación se muestra una lista (no editable) de los grupos a los cuales pertenece este grupo.",
	rightsdescr => "El derecho de acceso de un grupo a alguno de los derechos que se especifican abajo se pueden dar directamente al grupo O a un grupo diferente del que forma parte este grupo.  Los que ves abajo sin la casilla marcada son los derechos que se han otorgado a este grupo porque pertenece a otro con ese derecho.  Los derechos con las casillas abajo son los derechos que se pueden otorgar directamente a este grupo.",
	lock => "Bloqueo",
	members => "Miembros",
	anonymous => "Anónimo",
	permissions => "Permisos",
	permissionskey => "R = lectura, E = edición, los permisos de edición implican permisos de lectura",
	edit => "Editar",
	none => "Ninguno",
	accessdenied => "Acceso Denegado",
	storydenialmsg => "No tienes acceso para ver esta Noticia. Esto puede ser porque no eres miembro de {$_CONF["site_name"]}. Por favor <a href=users.php?mode=new>conviértete en un miembro</a> de {$_CONF["site_name"]} para tener acceso.",
	eventdenialmsg => "No tienes acceso para ver este Evento. Esto puede ser porque no eres miembro de {$_CONF["site_name"]}. Por favor <a href=users.php?mode=new>conviértete en un miembro</a> de {$_CONF["site_name"]} para tener acceso.",
	nogroupsforcoregroup => "Este grupo no pertenece a ninguno de los otros grupos",
	grouphasnorights => "Este grupo no tiene acceso a las funciones de administración",
	newgroup => 'Nuevo Grupo',
	adminhome => 'Página de Administración',
	save => 'Guardar',
	cancel => 'Cancelar',
      delete => 'borrar',
 	canteditroot => 'Has intentado editar el grupo Root (Raíz) pero no perteneces al grupo Root por lo que se te ha denegado el acceso.  Por favor, contacta con el(la) administrador(a) del sistema si crees que se trata de un errror',
     listusers => 'Listado de Usuarios',
     listthem => 'listado',
     usersingroup => 'Usuarios en el grupo %s'
);

#####################################################################################

$LANG_DB_BACKUP = array(
    last_ten_backups => 'Últimas 10 copias de seguridad',
    do_backup => 'Hacer una copia de seguridad',
    backup_successful => 'La copia de seguridad de la base de datos se ha realizado satisfactoriamente.',
    no_backups => 'No hay copias de seguridad en el sistema',
    db_explanation => 'Para crear una copia de seguridad del sistema utiliza el botón de abajo',
    not_found => "Ruta incorrecta o la utilidad mysqldump no se puede ejecutar.<br>Comprueba la definición de <strong>\$_DB_mysqldump_path</strong> en config.php.<br>La variable está definida actualmente como: <var>{$_DB_mysqldump_path}</var>",
    zero_size => 'Fallo de la copia de seguridad: El tamaño era de 0 bytes',
    path_not_found => "{$_CONF['backup_path']} no existe o no es una ruta",
    no_access => "ERROR: No se puede acceder al directorio {$_CONF['backup_path']}.",
    backup_file => 'Archivo de copias de seguridad',
    size => 'Tamaño',
    bytes => 'Bytes',
    total_number => 'Número total de copias de seguridad: %d'
);



$LANG_BUTTONS = array(

    1 => "Portada",
    2 => "Contacto",
    3 => "Colaboraciones",
    4 => "Enlaces",
    5 => "Encuestas",
    6 => "Calendario",
    7 => "Estadísticas",
    8 => "Personalizar",
    9 => "Buscar",
    10 => "búsqueda avanzada"
);


$LANG_404 = array(
    1 => "Error 404",
    2 => "Vaya, he buscado por todos los sitios, pero no puedo encontrar <b>%s</b>.",
    3 => "<p>Lo sentimos, pero el fichero que pides no existe. Por favor, consulta la <a href=\"{$_CONF['site_url']}\">página principal</a> o la <a href=\"{$_CONF['site_url']}/search.php\">página de búsqueda</a> para ver si puedes encontrar lo que has perdido."
);



$LANG_LOGIN = array (

    1 => 'se requiere ingresar',
    2 => 'Lo siento, para acceder a esta área tienes que estar verificado(a) como usuario(a).',
    3 => 'ingresar',
    4 => 'Nuevo(a) Usuario(a)'
);



?>
