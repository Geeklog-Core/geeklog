<?php

###############################################################################
# This is the spanish language page for GeekLog!
# 
# Copyright (C) 2000 Jason Whittenburg
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
# $LANGXX[YY]:	$LANG - variable name
#		  	XX - file id number
#			YY - phrase id number
###############################################################################

###############################################################################
# USER PHRASES - These are file phrases used in end user scripts
###############################################################################

###############################################################################
# common.php

$LANG01 = array(
	1 => "Contribuido por:",
	2 => "ver más",
	3 => "comentarios",
	4 => "Editar",
	5 => "Encuesta",
	6 => "Resultados",
	7 => "Resultados de la encuesta",
	8 => "votos",
	9 => "Funciones del Administrador:",
	10 => "Propuestas",
	11 => "Notas",
	12 => "Bloques",
	13 => "Secciones",
	14 => "Links",
	15 => "Eventos",
	16 => "Encuestas",
	17 => "Usuarios",
	18 => "Búsqueda SQL",
	19 => "Salir",
	20 => "Información del Usuario:",
	21 => "Nombre del Usuario",
	22 => "ID del Usuario",
	23 => "Nivel de Seguridad",
	24 => "Anónimo",
	25 => "Responder",
	26 => "Los siguientes comentarios son de quien sea que los haya enviado. Este sitio no es responsable por lo que dicen.",
	27 => "Envio más reciente",
	28 => "Borrar",
	29 => "No hay comentarios de usuarios.",
	30 => "Artículos anteriores",
	31 => "Tags HTML permitidos:",
	32 => "Error, usuario inválido",
	33 => "Error, no fue posible escribir el log",
	34 => "Error",
	35 => "Salir",
	36 => "sobre",
	37 => "No hay noticias del usuario",
	38 => "",
	39 => "Actualizar",
	40 => "",
	41 => "Usuarios Inviados",
	42 => "Escrito por:",
	43 => "Responder a",
	44 => "Retornar",
	45 => "Nro de Error MySQL",
	46 => "Mensaje de Error MySQL",
	47 => "Funciones de Usuario",
	48 => "Mi cuenta",
	49 => "Mis Preferencias",
	50 => "Error en una sentencia SQL",
	51 => "ayuda",
	52 => "Nuevo",
	53 => "Sección de Administración",
	54 => "No fue posible abrir el archivo.",
	55 => "Error en",
	56 => "Vote",
	57 => "Password",
	58 => "Ingresar",
	59 => "¿No tiene una cuenta todavía? <a href=\"{$_CONF['site_url']}/users.php?mode=new\">Inscríbase</a>",
	60 => "Agregar un comentario",
	61 => "Crear una Nueva Cuenta",
	62 => "palabras",
	63 => "Mis preferencias de comentarios",
	64 => "Enviar la Nota a un Amigo",
	65 => "Ver la versión para imprimir",
	66 => "Mi Calendario",
	67 => "Bienvenido a ",
	68 => "Página Inicial",
	69 => "contacto",
	70 => "buscar",
	71 => "contribuir",
	72 => "recursos en la web",
	73 => "encuestas pasadas",
	74 => "calendario",
	75 => "búsqueda avanzada",
	76 => "estadísticas del sitio",
	77 => "Plugins",
	78 => "Próximos Eventos",
	79 => "Novedades",
	80 => "Notas",
	81 => "Nota",
	82 => "horas",
	83 => "COMENTARIOS",
	84 => "LINKS",
	85 => "últimas 48 hs",
	86 => "No hay nuevos comentarios",
	87 => "últimas 2 semanas",
	88 => "No hay nuevos links",
	89 => "No hay próximos eventos",
	90 => "Página Inicial",
	91 => "Esta página fue creada en",
	92 => "segundos",
	93 => "Derechos de autor",
	94 => "Todas las marcas y derechos en esta página son de sus respectivos dueños.",
	95 => "Powered By",
	96 => "Grupos",
        97 => "List de Palabras",
	98 => "Plug-ins",
	99 => "NOTAS",
    100 => "No hay nuevas notas",
    101 => 'Mis Eventos',
    102 => 'Eventos del sitio',
    103 => 'DB Backups',
    104 => 'por',
    105 => 'Envair Mails',
    106 => 'Vistas',
    107 => 'Comprobación GL',
    108 => 'Limpiar Caché'
);

###############################################################################
# calendar.php

$LANG02 = array(
	1 => "Calendario de Eventos",
	2 => "Disculpe, no hay eventos para mostrar.",
	3 => "Cuando",
	4 => "Donde",
	5 => "Descripción",
	6 => "Agregar un Evento",
	7 => "Próximos Eventos",
	8 => 'Al agregar este evento en su calendario usted podrá ver rápidamente los eventos que le interesan. Para ello elija "Mi Calendario" en el área de Funciones del usuario.',
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
	5 => "Nombre del Usuario",
	6 => "Este sitio requiere que tenga una cuenta para enviar un comentario. Si ya la tiene ingrese el usuario y el password. Si no tiene una cuenta puede crear una nueva en el formulario de abajo.",
	7 => "Su último comentario fue hace ",
	8 => " segundos. Este sitio requiere al menos {$_CONF["commentspeedlimit"]} segundos entre comentarios",  
	9 => "Comentario",
	10 => '',
	11 => "Enviar el Comentario",
	12 => "Por favor complete el Nombre, Email, Título y Comentario, ya que son datos necesarios para el envío.",
	13 => "Su Información",
	14 => "Vista Previa",
	15 => "",
	16 => "Título",
	17 => "Error",
	18 => 'Cosas Importantes',
	19 => 'Por favor intente mantener el tema de la nota.',
	20 => 'Intente responder a los commentarios de los demás en lugar de comenzar una nueva discución.',
	21 => 'Lea los comentarios enviados para evitar comentarios duplicados.',
	22 => 'Use un título claro que describa el contenido del mensaje.',
	23 => 'Su dirección de email NO será divulgada.',
	24 => 'Usuario Anónimo'
);

###############################################################################
# users.php

$LANG04 = array(
	1 => "Perfil del Usuario para",
	2 => "Nombre del Usuario",
	3 => "Nombre Completo",
	4 => "Password",
	5 => "Email",
	6 => "Homepage",
	7 => "Biografía",
	8 => "Clave PGP",
	9 => "Guardar",
	10 => "Ultimos 10 comentarios",
	11 => "No hay comentarios",
	12 => "Preferencias del Usuario para",
	13 => "Enviar un resumen cada noche por Email",
	14 => "Este password es generado al azar. Se recomienda que cambie el password cuanto antes. Para cambiar el password conectese al sitio con su usuario.",
	15 => "Su cuenta en {$_CONF["site_name"]} fue creada exitosamente. Para poder usarla debe ingresar utilizando los datos dados más abajo. Guarde este mensaje para futuras referencias.",
	16 => "Información de su cuenta",
	17 => "La cuenta no existe",
	18 => "El email ingresado no parece ser válido.",
	19 => "El usuario y el email ingresados ya existen",
	20 => "El email ingresado no parece ser válido.",
	21 => "Error",
	22 => "Registrese en {$_CONF['site_name']}!",
	23 => "Crear una cuenta le dará los beneficios de los usuarios de {$_CONF['site_name']} y le permitirá enviar notas, comentarios, etc. Si no tiene una cuenta sólo lo podrá hacer anónimamente. Queremos remarcar que su email <b><i>nunca</i></b> será publicado en este sitio.",
	24 => "Su password será enviado a la dirección de email que ingrese.",
	25 => "Olvidó su Password?",
	26 => "Ingrese su nombre de usuario y elija 'Enviar el Password por email' y su nuevo password será enviado por email a su dirección",
	27 => "¡Regístrate ahora!",
	28 => "Enviar el password por email",
	29 => "desconectado de",
	30 => "conectado a",
	31 => "La función que eligió requiere que esté conectado",
	32 => "Firma",
	33 => "Nunca mostrado publicamente",
	34 => "Este es tu nombre real",
	35 => "Ingrese el password para cambiarlo",
	36 => "Comienza con http://",
	37 => "Aplicado a tus comentarios",
	38 => "¡Todo sobre Ud.! Todos van a poder leer esto.",
	39 => "Su clave pública de PGP para compartir",
	40 => "No hay íconos en Secciones",
	41 => "Deseando moderar",
	42 => "Formato de fecha",
	43 => "Cantidad máxima de Notas",
	44 => "Sin recuadros",
	45 => "Mostrar las preferencias de",
	46 => "Items excluidos para",
	47 => "Configuración de Noticias para",
	48 => "Secciones",
	49 => "Sin íconos en las notas",
	50 => "No seleccione esto si no está interesado",
	51 => "Sólo las notas nuevas",
	52 => "El valor por defecto es",
	53 => "Recibir cada noche las notas del día",
	54 => "Seleccione las Secciones y Autores que no desea ver.",
	55 => "Si no selecciona ninguna significa que desea la selección por defecto. De seleccionar, seleccione todas las de su interés ya que las opciones por defecto ya no serán tomadas en cuenta. Las opciones por defecto se muestran resaltadas.",
	56 => "Autores",
	57 => "Modo de Presentación",
	58 => "Orden",
	59 => "Limite por Comentario",
	60 => "¿Cómo desea ver los comentarios?",
	61 => "¿Primero los más antiguos o los más recientes?",
	62 => "El valor por defecto es 100",
	63 => "Gracias por usar {$_CONF['site_name']}. Su password a sido enviado por email y estará llegando en unos instantes. Por favor siga las instrucciones en el mensaje.",
	64 => "Preferencias para los Comentarios de",
	65 => "Intente reconectarse otra vez",
	66 => "Los datos ingresados no son válidos. Intente volver a conectarse aquí. ¿Es usted un <a href=\"{$_CONF['site_url']}/users.php?mode=new\">usuario nuevo</a>?",
	67 => "Miembro desde",
	68 => "Recuérdeme para",
	69 => "¿Cuánto tiempo debemos mantenerlo activo luego que se conectó?",
	70 => "Personalize la apariencia y el contenido de {$_CONF['site_name']}",
	71 => "Una de las grandes virtudes de {$_CONF['site_name']} es que puede personalizar el contenido que recibe y la apariencia del sitio. Para poder lograr esto debe primero <a href=\"{$_CONF['site_url']}/users.php?mode=new\">registrarse</a> en {$_CONF['site_name']}. Si ya es un miembro utilice el formulario de la izquierda para conectarse.",
	72 => "Theme",
    	73 => "Idioma",
	74 => "¡Cambie la apariencia de esta página!",
	75 => "Secciones enviadas por email a",
	76 => "Si selecciona una o más Secciones de la lista de abajo, todas las Notas nuevas de esas Secciones le serán enviadas por mail al finalizar el día.",
        77 => "Foto",
        78 => "Añadir una imagen tuya!",
        79 => "Tildar el checkbox para borrar tu foto",
        80 => "Identificación",
        81 => "Enviar Email",
        82 => 'Ultimas 10 noticias para el usuario',
        83 => 'Estadísticas de noticias para el usuario',
        84 => 'Número total de artículos:',
        85 => 'Número total de comentarios:',
        86 => 'Encontrar todas las noticias de'
);

###############################################################################
# index.php

$LANG05 = array(
	1 => "No hay novedades para mostrar",
	2 => "No hay nuevas notas para mostrar. Puede que no haya novedades para esta Sección o que sus preferencias sean muy restrictivas.",
	3 => "para la Sección $topic",
	4 => "Nota del Día",
	5 => "Siguiente",
	6 => "Anterior"
);

###############################################################################
# links.php

$LANG06 = array(
	1 => "Links",
	2 => "No hay Links para mostrar.",
	3 => "Agregue un Link"
);

###############################################################################
# pollbooth.php

$LANG07 = array(
	1 => "Voto Grabado",
	2 => "Su voto fue computado para la encuesta",
	3 => "Vote",
	4 => "Encuestas en el sistema",
	5 => "Votos"
);

###############################################################################
# profiles.php

$LANG08 = array(
	1 => "Hubo un error al enviar su mensaje. Intente nuevamente por favor.",
	2 => "El mensaje fue enviado con éxito.",
	3 => "Por favor asegúrese de ingresar una dirección de email válida en el campo 'Responder a'.",
	4 => "Por favor complete los campos Remitente, Responder a, Título y Mensaje",
	5 => "Error: No existe el usuario.",
	6 => "Hubo un error.",
	7 => "Perfil de usuario de",
	8 => "Nombre del Usuario",
	9 => "URL del Usuario",
	10 => "Enviar mensaje a",
	11 => "Remitente:",
	12 => "Responder a:",
	13 => "Título:",
	14 => "Mensaje:",
	15 => "El código HTML no será traducido.",
	16 => "Enviar el mensaje",
	17 => "Enviar la Nota a un Amigo",
	18 => "Destinatario",
	19 => "Dirección de email destino",
	20 => "Remitente",
	21 => "Responder a",
	22 => "Todos los campos son requeridos",
	23 => "Este email fue enviado a Ud por $from en $fromemail porque pensó que podría interesarle esta Nota en  {$_CONF["site_url"]}. Esto no es SPAM y los emails involucrados en este envío no fueron guardados para ningún uso posterior.",
	24 => "Comentario sobre esta nota en",
	25 => "Debe conectarse para utilizar esta herramienta. Este control se realiza para evitar el mal uso del sistema.",
	26 => "Este form le permitirá enviar un email al usuario seleccionado. Todos los campos son necesarios.",
	27 => "Mensaje corto",
	28 => "$from escribió: $shortmsg",
    29 => "Este es el resúmen diario de {$_CONF['site_name']} para ",
    30 => " Diario para ",
    31 => "Título",
    32 => "Fecha",
    33 => "Lea la Nota completa en",
    34 => "Fin del Mensaje"
    
);

###############################################################################
# search.php

$LANG09 = array(
	1 => "Búsqueda Avanzada",
	2 => "Palabras Clave",
	3 => "Sección",
	4 => "Todo",
	5 => "Tipo",
	6 => "Notas",
	7 => "Comentarios",
	8 => "Autores",
	9 => "Todo",
	10 => "Buscar",
	11 => "Resultados de la búsqueda",
	12 => "resultados",
	13 => "Búsqueda de Notas: No hubo coincidencias",
	14 => "No se encontraron coincidencias búscando: ",
	15 => "Por favor intente nuevamente.",
	16 => "Título",
	17 => "Fecha",
	18 => "Autor",
	19 => "Buscar en toda la base de datos de <B>{$_CONF["site_name"]}</B>",
	20 => "Fecha",
	21 => "a",
	22 => "(Formato de fecha DD-MM-YYYY)",
	23 => "Accesos",
	24 => "Se encontraron",
	25 => "coincidencias para",
	26 => "items en",
	27 => "segundos",
    28 => 'No se encontraron coincidencias en Notas y Comentarios',
    29 => 'Resultados para Notas y Comentarios',
    30 => 'Ningún link coincide con la búsqueda',
    31 => 'Este plug-in no devolvió resultados',
    32 => 'Evento',
    33 => 'URL',
    34 => 'Ubicación',
    35 => 'Todo el dia',
    36 => 'Ningún evento coincidió con la búsqueda',
    37 => 'Resultados de Eventos',
    38 => 'Resultados de Links',
    39 => 'Links',
    40 => 'Eventos',
    41 => 'Tu búsqueda  debe tener al menos 3 letras.',
    42 => 'Por favor utiliza un formato de fecha como este DD-MM-YYYY (día-mes-año).'
);

###############################################################################
# stats.php

$LANG10 = array(
	1 => "Estadísticas del sitio",
	2 => "Total de accesos al sistema",
	3 => "Notas(Comentarios) en el sistema",
	4 => "Encuestas(Respuestas) en el sistema",
	5 => "Links(Visitados) en el sistema",
	6 => "Eventos en el sistema",
	7 => "Las 10 Notas más vistas",
	8 => "Título de la Nota",
	9 => "Accesos",
	10 => "Parecería que no hay Notas en este sitio o que nadie jamás las vió.",
	11 => "Las 10 Notas más comentadas",
	12 => "Comentarios",
	13 => "Parecería que no hay Notas en este sitio o que nadie jamás escribió un comentario sobre ellas.",
	14 => "Las 10 Encuestas con más votos",
	15 => "Pregunta",
	16 => "Votos",
	17 => "Parecería que no hay Encuestas en este sitio o que nadie jamás votó.",
	18 => "Los 10 Links más visitados",
	19 => "Links",
	20 => "Visitas",
	21 => "Parecería que en este sitio no hay Links o que nadie nuca los visita.",
	22 => "Las 10 Notas más enviadas por email",
	23 => "Emails",
	24 => "Parecería que nadie mandó una nota por email en este sitio."
);

###############################################################################
# article.php

$LANG11 = array(
	1 => "Relacionado con esto...",
	2 => "Enviar la Nota a un amigo",
	3 => "Versión para imprimir",
	4 => "Opciones de la Nota"
);

###############################################################################
# submit.php

$LANG12 = array(
	1 => "Para enviar $type debe estar conectado con su usuario.",
	2 => "Ingresar",
	3 => "Nuevo usuario",
	4 => "Enviar un Evento",
	5 => "Enviar un Link",
	6 => "Enviar una nota",
	7 => "Debe conectarse",
	8 => "Enviar",
	9 => "Cuando envia información a este sitio le pedimos que tome en cuenta los siguientes consejos: <ul><li>Complete todos los campos requeridos<li>Chequee bien los URL's<li>Brinde información completa y precisa</ul>",
	10 => "Título",
	11 => "Link",
	12 => "Fecha de inicio",
	13 => "Fecha de finalización",
	14 => "Locación",
	15 => "Descripción",
	16 => "Si otra, especifique",
	17 => "Categoria",
	18 => "Otra",
	19 => "Lea antes",
	20 => "Error: Falta la Categoría",
	21 => "Por favor, cuando seleccione 'Otra' complete el nombre de la categoría",
	22 => "Error: Faltan Campos",
	23 => "Por favor complete todo los campos del formulario. Todos los campos son requeridos.",
	24 => "Envío Guardado",
	25 => "Sus envíos fueron grabados con éxito.",
	26 => "Límite de Velocidad",
	27 => "Nombre del Usuario",
	28 => "Sección",
	29 => "Nota",
	30 => "Su último envío fue hace ",
	31 => " segundos.  Este sitio requiere al menos {$_CONF["speedlimit"]} segundos entre envíos",
	32 => "Vista Previa",
	33 => "Prever la Nota",
	34 => "Salir",
	35 => "Los tags de HTML no son permitidos",
	36 => "Formato del texto",
	37 => "Los Eventos enviados a {$_CONF["site_name"]} se agregan al Calendario Público, donde el resto de los usuarios pueden agregarlo a su Calendario Personal. Esta funcionalidad <b>NO</b> está pensada para que guarde sus eventos personales como cumpleaños, citas, etc.<br><br>Una vez enviado el evento será evaluado por los Administradores, de ser aprobado se mostrará en el Calendrio Público", 
  	38 => "Agregar un Evento a",
  	39 => "Calendario Público",
  	40 => "Calendario Personal",
  	41 => "Hora de Finalización",
  	42 => "Hora de Inicio",
  	43 => "Evento de todo el día",
  	44 => 'Dirección',
  	45 => 'Dirección',
  	46 => 'Ciudad/Localidad',
  	47 => 'Provincia',
  	48 => 'Código Postal',
  	49 => 'Tipo de Evento',
  	50 => 'Editar los Tipos de Eventos',
  	51 => 'Locación',
  	52 => 'Borrar',
        53 => 'Crear Cuenta'
);


###############################################################################
# ADMIN PHRASES - These are file phrases used in end admin scripts
###############################################################################

###############################################################################
# auth.inc.php

$LANG20 = array(
	1 => "Autentificación Requerida",
	2 => "¡Denegado! Incorrect Login Information",
	3 => "El password ingresado es inválido",
	4 => "Usuario:",
	5 => "Password:",
	6 => "Todo acceso a las partes administrativas es registrado y revisado.<br>Esta página es para uso exclusivo del personal autorizado.",
	7 => "Ingresar"
);

###############################################################################
# block.php

$LANG21 = array(
	1 => "No tiene derechos de Administrador",
	2 => "No tiene los derechos suficiente spara editar este bloque.",
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
	15 => "ültima actualización RDF",
	16 => "Opciones para el Bloque Normal",
	17 => "Contenido del Bloque",
	18 => "Por favor complete los campos Título, Nivel de Seguridad y Contenido",
	19 => "Administrador",
	20 => "Título",
	21 => "Nivel de Seguridad",
	22 => "Tipo",
	23 => "Nro. de Orden",
	24 => "Sección",
	25 => "Para modificar o borrar un bloque seleccionelo más abajo. Para crear uno nuevo Seleccione 'Nuevo Bloque' arriba.",
	26 => "Bloque de Layout",
	27 => "Bloque PHP",
        28 => "Opciones del Bloque PHP",
        29 => "Funciones de Bloque",
        30 => "Si desea que su bloque utilice código PHP, ingrese aqui el nombre de la función. La función debe tener el prefijo \"phpblock_\" (ej. phpblock_getweather). De no tenerlo NO será invocada. Asegúrese de no incluir los paréntesis, \"()\", al final del nombre. Por último, se recomienda que guarde todo código PHP en /path/to/geeklog/system/lib-custom.php. Esto le permitirá que su código se mantenga aún entre cambios de versiones del sistema.",
        31 => 'Error en un Bloque PHP.  La función, $function, no existe.',
        32 => "Error, Faltan Campos",
        33 => "Debe ingresar el URL del archivo .rdf para los Bloques del Sistema",
        34 => "debe ingresar el Título y la Función en los Bloques PHP",
        35 => "Debe ingresar el Título y el Contenido para los Bloques Normales",
        36 => "Debe ingresar el contenido para los Bloques de Layout",
        37 => "El nombre de la función en el Bloque PHP es inválido",
        38 => "Las funciones para los Bloques PHP deben tener el prefijo 'phpblock_' (ej. phpblock_getweather). El prefijo es requerido por cuestiones de seguridad, para evitar que se ejecute código no deseado.",
	39 => "Ubicación",
	40 => "Izquierda",
	41 => "Derecha",
	42 => "Deber ingresar el nro. de orden y el nivel de seguridad para los bloques default",
	43 => "Sólo en la Página de Inicio",
	44 => "Acceso Denegado",
	45 => "Usted esta tratando de acceder a un bloque en el cual usted no tiene los permisos requeridos.  Este intento ha sido registrado. Por favor  <a href=\"{$_CONF["site_admin_url"]}/block.php\">vuelva a la pantalla de administración de bloques</a>.",
	46 => 'Nuevo Bloque',
	47 => 'Página de Inicio - Administrador',
  	48 => 'Nombre del Bloque',
  	49 => ' (sin espacios y debe ser único)',
  	50 => 'URL del archivo de ayuda',
  	51 => 'incluir http://',
  	52 => 'Si deja este campo en blanco no se mostrará el ícono de ayuda',
	53 => 'Habilitado',
        54 => 'grabar',
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
	10 => "Necesita completar todos los campos de este formulario.",
	11 => "Administrador del Evento",
	12 => "Para modificar o borrar el evento seleccionarlo más abajo. Para crear uno nuevo seleccionar 'Nuevo Evento' más arriba.",
	13 => "Título",
	14 => "Fecha de Inicio",
	15 => "Fecha de Finalización",
	16 => "Acceso Denegado",
	17 => "No tiene permiso para acceder a este Evento. Todo intento de acceso será registrado. Por favor, vuelva a <a href=\"{$_CONF["site_admin_url"]}/event.php\">la página de Administración de Eventos</a>.",
	18 => 'Nuevo Evento',
	19 => 'Página de Inicio - Administrador',
        20 => 'grabar',
        21 => 'cancelar',
        22 => 'borrar'
);

###############################################################################
# link.php

$LANG23 = array(
	1 => "Editor de Links",
	2 => "",
	3 => "Título",
	4 => "URL",
	5 => "Categoria",
	6 => "(incluir http://)",
	7 => "Otro",
	8 => "Cantidad de accesos",
	9 => "Descripción",
	10 => "Necesita completar los campos Título, URL y Descripción.",
	11 => "Administrador",
	12 => "Para modificar o borrar un Link selecciónelo más abajo. Para crear uno nuevo seleccione 'Nuevo Link' más arriba.",
	13 => "Título",
	14 => "Categoria",
	15 => "URL",
	16 => "Acceso Denegado",
	17 => "No tiene permiso para acceder a este Link. Todo intento de acceso será registrado. Por favor, vuelva a <a href=\"{$_CONF["site_admin_url"]}/link.php\">la página de Administración de Links</a>.",
	18 => 'Nuevo Link',
	19 => 'Página de Inicio - Administrador',
	20 => 'Si otra/o, especifique',
        21 => 'grabar',
        22 => 'cancelar',
        23 => 'borrar'
);

###############################################################################
# story.php

$LANG24 = array(
	1 => "Notas Anteriores",
	2 => "Notas Siguientes",
	3 => "Modo",
	4 => "Modo de envio",
	5 => "Editor de Notas",
        6 => "No hay Noticias en el sistema",
	7 => "Autor",
        8 => "grabar",
        9 => "prever",
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
	22 => "Listado de Notas",
	23 => "Para modificar o borrar una Nota seleccione el número de nota más abajo. Para ver la Nota seleccione el título de la misma. Para crear una nueva Nota seleccione 'Nueva Nota' más arriba.",
	24 => "",
	25 => "",
	26 => "Vista Previa",
	27 => "",
	28 => "",
	29 => "",
	30 => "",
	31 => "Por favor complete los campos Autor, Introducción y Texto",
	32 => "Destacado",
	33 => "Sólo puede haber una Nota destacada",
	34 => "Borrador",
	35 => "Sí",
	36 => "No",
	37 => "Más de",
	38 => "Más en",
	39 => "Emails",
	40 => "Acceso Denegado",
	41 => "Esta intentando acceder a una Nota para la cual no tiene derechos de acceso, por lo que podrá ver la Nota pero no editarla. Por favor vuelva a la <a href=\"{$_CONF["site_admin_url"]}/story.php\">página de administración</a> cuando haya terminado.",
	42 => "Esta intentando acceder a una Nota para la cual no tiene derechos de acceso. Por favor vuelva a la <a href=\"{$_CONF["site_admin_url"]}/story.php\">página de administración</a>.",
	43 => 'Nueva Nota',
	44 => 'Página de Inicio - Administrador',
	45 => 'Acceso',
        46 => '<b>NOTA:</b> si modifica esta fecha por una futura, la Nota no será publicada hasta esa fecha. Esto también incluye el envió de titulares RDF(Resource Description Framework), la búsqueda y las estadísticas del sitio.',
        47 => 'Imágenes',
        48 => 'imagen',
        49 => 'der',
        50 => 'izq',
        51 => 'Para insertar una imagen en la Nota debe incluir un texto con el formato [imagenX], [imagenX_der] o [imageX_izq], donde X es el número de imagen dentro de la lista. NOTA: sólo puede utilizar las imágenes de la lista, sino la Nota no podrá ser grabada',
        52 => 'Borrar',
        53 => 'no fue usada.  Debe incluir esta imagen en la Introducción o el Texto para poder grabar los cambios',
        54 => 'Imágenes no utilizadas',
        55 => 'Los siguientes errores ocurriron al querer grabar su Nota. Por favor corrija los errores antes de grabar.',
        56 => 'Mostrar Icono de Tema'
);

###############################################################################
# poll.php

$LANG25 = array(
	1 => "Modo",
	2 => "",
	3 => "Fecha de creación",
	4 => "Encuesta $qid grabada",
	5 => "Editar la Encuesta",
	6 => "ID",
	7 => "(no use espacios)",
	8 => "Aparece en la Portada",
	9 => "Pregunta",
	10 => "Respuestas / Votos",
	11 => "Hubo un error buscando los datos para las respuesta de la Encuesta $qid",
	12 => "Hubo un error buscando los datos para la pregunta de la Encuesta $qid",
	13 => "Crear Encuesta",
        14 => "grabar",
        15 => "cancelar",
        16 => "borrar",
	17 => "",
	18 => "Listado de Encuestas",
	19 => "Para modificar o borrar una Encuesta elíjala en la lista de abajo. Para crear una nueva selecione 'Nueva Encuesta' más arriba.",
	20 => "Votantes",
	21 => "Acceso Denegado",
	22 => "Esta intentando acceder a una Encuesta para la cual no tiene derechos de acceso. Por favor vuelva a la <a href=\"{$_CONF["site_admin_url"]}/poll.php\">página de administración</a>.",
	23 => 'Nueva Encuesta',
	24 => 'Página de Inicio - Administrador',
	25 => 'Sí',
	26 => 'No'
);

###############################################################################
# topic.php

$LANG27 = array(
	1 => "Editor de Secciones",
	2 => "ID",
	3 => "Nombre",
	4 => "Imagen",
	5 => "(no use espacios)",
	6 => "Al borrar una Sección se borrarán todas sus Notas y Bloques asociados",
	7 => "Por favor complete los campos ID y Nombre",
	8 => "Administrador de Secciones",
	9 => "Para modificar o borrar una Sección elíjala en la lista de abajo. Para crear una nueva selecione 'Nueva Sección' más arriba. Entre paréntesis figura el nivel de acceso que posee.",
	10=> "Nro. de Orden",
	11 => "Notas/Página",
	12 => "Acceso Denegado",
	13 => "Esta intentando acceder a una Sección para la cual no tiene derechos de acceso. Por favor vuelva a la <a href=\"{$_CONF["site_admin_url"]}/topic.php\">página de administración</a>.",
	14 => "Ordenamiento",
	15 => "alfabético",
	16 => "por defecto es",
	17 => "Nueva Sección",
	18 => "Página de Inicio - Administrador",
        19 => 'grabar',
        20 => 'cancelar',
        21 => 'borrar'
);

###############################################################################
# user.php

$LANG28 = array(
	1 => "Editor de Usuarios",
	2 => "ID",
	3 => "Nombre de Usuario",
	4 => "Nombre Completo",
	5 => "Password",
	6 => "Nivel de Seguridad",
	7 => "Dirección de Email",
	8 => "Págia de Inicio",
	9 => "(no use espacios)",
	10 => "Por favor complete los campos Nombre de Usuario, Nombre Completo, Nivel de Seguridad y Dirección de Email",
	11 => "Administrador de Usuarios",
	12 => "Para modificar o borrar un Usuario elíjalo en la lista de abajo. Para crear uno nuevo selecione 'Nuevo Usuario' más arriba.",
	13 => "Nivel de seguridad",
	14 => "Fecha de Registro",
	15 => 'Nuevo Usuario',
	16 => 'Página de Inicio - Administrador',
	17 => 'Cambiar-Password',
	18 => 'Cancelar',
	19 => 'Borrar',
	20 => 'Grabar',
	18 => 'Cancelar',
	19 => 'Borrar',
	20 => 'Grabar',
    21 => 'El Nombre de Uusario propuesto ya existe.',
    22 => 'Error',
    23 => 'Importación Masiva',
    24 => 'Importación masiva de Usuarios',
    25 => 'Puede importar una lista de Usuarios a '.$_CONF["site_name"].'. El archivo con la lista de usuarios debe tener un registro por línea y los campos separados por TAB. Los campos deben estar en el siguiente orden: Nombre Completo, Nombre de Usuario, Dirección de Mail. A cada usuario agregado se le enviará por email un password generado al azar, que podrán cambiar al ingresar al sitio. Por favor, chequee bien el archivo de importación ya que los errores encontrados pueden llegar a necesaitar arreglos manuales.',
    26 => 'Buscar',
    27 => 'Limitar los resultados',
    28 => 'Tildar el checkbox para borrar esta imagen',
    29 => 'Ruta',
    30 => 'Importar',
    31 => 'Nuevos Usuarios',
    32 => 'Proceso finalizado. Se importaron $successes y hubieron $failures fallos',
    33 => 'enviar',
    34 => 'Error: Debes especificar un archivo a enviar.'
);

###############################################################################
# moderation.php

$LANG29 = array(
	1 => "Aprobar",
	2 => "Borrar",
	3 => "Editar",
    4 => 'Perfil',
    10 => "Título",
    11 => "Fecha Inicio",
    12 => "URL",
    13 => "Categoría",
    14 => "Fecha",
    15 => "Tema",
    16 => 'Nombre del usuario',
    17 => 'Nombre completo',
    18 => 'Email',
	34 => "Página de administración",
	35 => "Envios de Notas",
	36 => "Envios de Links",
	37 => "Envios de Eventos",
	38 => "Enviar",
	39 => "No hay envios para moderar en este momento",
   40 => "Envios del Usuario"

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
	9 => "Evento de Argos",
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
	24 => "Deciembre",
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
    37 => "Disculpe, la opción de calendario personal no se encuentra habilitada en este sitio",
    38 => "Editor Personal de Eventos",
    39 => 'Día',
    40 => 'Semana',
    41 => 'Mes'
);

###############################################################################
# admin/mail.php
$LANG31 = array(
 	1 => $_CONF['site_name'] . "  Mail Utility",
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
 	14 => "Ignorar las preferencias del usuario",
 	15 => "Error al mandar a: ",
	16 => "Se ha enviado con éxito a: ",
	17 => "<a href=" . $_CONF["site_admin_url"] . "/mail.php>Enviar otro mensaje</a>",
        18 => "Para",
        19 => "NOTA: si desea enviar un mensaje a todos los miembros del sitio, seleccione el grupo Logged-In Users en la lista.",
        20 => "Se han enviado <successcount> mensajes con éxito y <failcount> han fallado.  Si desea, los detalles de cada envío figuran abajo. Tambien puede <a href=\"" . $_CONF['site_admin_url'] . "/mail.php\">enviar otro mensaje</a> o volver a <a href=\"" . $_CONF['site_admin_url'] . "/moderation.php\">la página de administración</a>.",
        21 => 'Fallidos',
        22 => 'Exitosos',
        23 => 'No hubo envíos fallidos',
        24 => 'No hubo envíos exitosos'	,
    25 => '-- Selecciona Grupo --',
    26 => "Por favor, rellena todos los campos del formulario y selecciona un grupo de usuarios de la lista desplegable."
);

###############################################################################
# confirmation and error messages

$MESSAGE = array (
	1 => "Su password a sido enviado por mail y debe llegar en unos instantes. Por favor siga las indicaciones del mensaje. Gracias por usar " . $_CONF["site_name"],
	2 => "Gracias por enviar su Nota a {$_CONF["site_name"]}. La Nota se encuentra en proceso de aprobación. De ser aprobada podrá ser leida por todos los visitantes del sitio.",
	3 => "Gracias por enviar su Link a {$_CONF["site_name"]}. El Link se encuentra en proceso de aprobación. De ser aprobado podrá ser visto por todos los visitantes del sitio.",
	4 => "Gracias por enviar su Evento a {$_CONF["site_name"]}. El Evento se encuentra en proceso de aprobación. De ser aprobado podrá ser visto por todos los visitantes del sitio.",
	5 => "La información de su cuenta ha sido grabada con éxito.",
	6 => "Sus preferencias han sido grabadas con éxito.",
	7 => "Sus preferencias para Comentarios han sido grabadas con éxito.",
	8 => "Se ha descontectado con éxito.",
	9 => "Su Nota ha sido grabada con éxito.",
	10 => "La Nota ha sido borrada con éxito.",
	11 => "Su Bloque ha sido grabado con éxito.",
	12 => "El Bloque ha sido borrado con éxito.",
	13 => "Su Sección ha sido borrada con éxito.",
	14 => "La Sección junto con todas sus Notas y Bloques han sido borrado con éxito.",
	15 => "Su link fue grabado con éxito.",
	16 => "El link fue borrado con éxito.",
	17 => "Su Evento fue grabado con éxito.",
	18 => "El Evento fue borrado con éxito.",
	19 => "Su Encuesta fue grabada con éxito.",
	20 => "La encuesta fue borrada con éxito.",
	21 => "El nuevo Usuario fue grabado con éxito.",
	22 => "El Usuario fue borrado con éxito",
	23 => "Error al grabar el Evento en su Calendario. No fue pasado el ID.",
	24 => "El Evento fue grabado en su Calendario",
	25 => "No puede acceder a su Calendario Personal antes de conectarse con su usuario",
	26 => "El Evento fue borrado de su Calendario Personal",
	27 => "Mensaje enviado con éxito.",
	28 => "El Plug-In fue grabado con éxito",
	29 => "Disculpe, los Calendarios Personales no están habilitados en este sitio",
	30 => "Acceso Denegado",
	31 => "Disculpe, no tiene acceso a la página de administración de Notas. Aclaramos que todo acceso sin autorización queda registrado en el servidor.",
	32 => "Disculpe, no tiene acceso a la página de administración de Secciones. Aclaramos que todo acceso sin autorización queda registrado en el servidor.",
	33 => "Disculpe, no tiene acceso a la página de administración de Bloques. Aclaramos que todo acceso sin autorización queda registrado en el servidor.",
	34 => "Disculpe, no tiene acceso a la página de administración de Links. Aclaramos que todo acceso sin autorización queda registrado en el servidor.",
	35 => "Disculpe, no tiene acceso a la página de administración de Eventos. Aclaramos que todo acceso sin autorización queda registrado en el servidor.",
	36 => "Disculpe, no tiene acceso a la página de administración de Encuestas. Aclaramos que todo acceso sin autorización queda registrado en el servidor.",
	37 => "Disculpe, no tiene acceso a la página de administración de Usuarios. Aclaramos que todo acceso sin autorización queda registrado en el servidor.",
	38 => "Disculpe, no tiene acceso a la página de administración de Plug-ins. Aclaramos que todo acceso sin autorización queda registrado en el servidor.",
	39 => "Disculpe, no tiene acceso a la página de administración de Mail. Aclaramos que todo acceso sin autorización queda registrado en el servidor.",
	40 => "Mensaje del Sistema",
        41 => "Disculpe, no tiene acceso a la página de Reemplazo de Palabras. Aclaramos que todo acceso sin autorización queda registrado en el servidor.",
        42 => "La Palabra fue grabada con éxito.",
	43 => "La Palabra fue borrada con éxito.",
        44 => 'El Plug-In fue instalado con éxito.',
        45 => 'El Plug-In fue borrado con éxito.',
        46 => "Disculpe, no tiene acceso a la herramienta de Backup de la base de datos. Aclaramos que todo acceso sin autorización queda registrado en el servidor.",
    47 => "Esta función está disponible bajo *nix. Si estás usando *nix como tu sistema operativo, entonces tu caché ha sido limpiado con éxito. Si estás bajo Windows, necesitas buscar ficheros adodb_*.php y borrarlos manualmente.",

   48 => 'Gracias por registrarte como miembro en ' . $_CONF['site_name'] . '. Nuestro equipo comprobará tu solicitud. Si es aprobada, te será enviado tu password a la dirección email que has indicado.',
    49 => "Tu grupo ha sido grabado con éxito.",
    50 => "El grupo ha sido borrado con éxito."



);

// for plugins.php

$LANG32 = array (
	1 => "Instalar plugins puede dañar su instalación de Geeklog y, posiblemente, su sistema. Es importante que sólo instale plugins obtenidos de <a href=\"http://www.geeklog.net\" target=\"_blank\">Geeklog</a> ya que han sido testeados en varios entornos. Es también importante que entienda que la instalación del plugin requiere la ejecución de comandos del sistema que pueden traer problemas de seguridad. Aún con esta advertencia, no garantizamos el éxito de la instalación del plugin ni nos hacemos responsables por cualquier daño causado durante la instalación (o posterior a la misma). En otras palabras, instale el plugin a su propio riesgo. Las instrucciones particulares de instalación vienen dentro de cada plugin.", 
	2 => "Advertencia de la Instalación del Plug-in",
	3 => "Formulario de instalación del Plug-in",
	4 => "Archivo del Plug-in",
	5 => "Listado de Plug-ins",
	6 => "Advertencia: ¡El Plug-in ya está instalado!",
	7 => "El plugin que intenta instalar ya existe. Por favor borre el plugin antes de reinstalarlo.",
	8 => "Falló el chequeo de compatibilidad del Plugin",
	9 => "Este Plug-in requiere una versión más nueva de Geeklog. Puede obtener una copia actualizada de <a href=http://www.geeklog.net>Geeklog</a> o instalar otra versión del Plug-in.",
	10 => "<br><b>No hay Plugins instalados.</b><br><br>",
	11 => "Para modificar o borrar un plugin seleccione el número a la izquierda del mismo. Para acceder a la página de sus creadores seleccione en el título del plugin. Para instalar un nuevo plugin seleccione 'Nuevo Plugin' más arriba.",
	12 => 'no fue dado un nombre de plugin a la función plugineditor()',
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
    27 => 'Homepage',
    28 => 'Versión',
    29 => 'Versión de Geeklog',
    30 => 'Borrar el Plug-in?',
    31 => '¿Está seguro/a que desea borrar este Plug-in? Al hacerlo borrará todos los archivos, estructuras y datos asociados. Si está seguro/a seleccione "Borrar" en el formulario de abajo.' 
);

$LANG_ACCESS = array(
	access => "Acceso",
    ownerroot => "Propietario/Root",
    group => "Grupo",
    readonly => "Sólo-Lectura",
	accessrights => "Derechos de acceso",
	owner => "Propietario",
	grantgrouplabel => "Establecer los derechos del Grupo",
	permmsg => "NOTA: miembros son todos los miembros conectados y los usuarios anónimos en el sitio.",
	securitygroups => "Grupos de Seguridad",
        editrootmsg => "Aunque usted sea un usuario con privilegios de administrator, usted no puede editar a un usuario <b>root</b> sin primeramente ser usted mismo un usuario <b>root</b>. Usted puede editar todo tipo de usuarios menos usuarios <b>root</b>. Note que todo inento ilegal de editar a un usuario <b>root</b> queda registrado por el server. Por favor vuelva atras a <a href=\"{$_CONF["site_admin_url"]}/user.php\">La pagina de Administración de Usuarios</a>.",
	securitygroupsmsg => "Seleccione los checkboxes para los grupos que a usted quiere que el usuario pertenezca.",
	groupeditor => "Editor de Grupo",
	description => "Descripción",
	name => "Nombre",
 	rights => "Derechos",
	missingfields => "Campos faltantes",
	missingfieldsmsg => "Debe ingresar un nombre y una descripción para el Grupo.",
	groupmanager => "Administrador de Grupos",
	newgroupmsg => "Para modificar o borrar un grupo seleccione el grupo aquí abajo. Para crear un grupo seleccione 'Nuevo Grupo' aquí arriba. Tenga en cuenta que los Grupos del Sistema no pueden ser borrados.",
	groupname => "Nombre del Grupo",
	coregroup => "Grupo del Sistema? ",
	yes => "Sí",
	no => "No",
	
	corerightsdescr => "Este grupo es un Grupo de Sistema de {$_CONF["site_name"]}, y por ende sus derechos no pueden ser editados. A continuación se muestra una lista no editable de los derechos de acceso de este grupo.",
	
	groupmsg => "Los Grupos de Seguridad en este sitio son jerárquicos. Al agregar este grupo a cualquiera de los de abajo le estará dando los mismos derechos que esos grupos posean. De ser posible, se recomienda utilizar los grupos ya creados para dar los derechos a un nuevo grupo. Si necesita modificar los derechos del grupo, puede seleccionarlos en la sección llamada 'Derechos'. Para agregar este grupo a cualquiera de los de abajo simplemente marque los grupos que quiera.",
	
	coregroupmsg => "Este grupo es un Grupo de Sistema de {$_CONF["site_name"]}, y por ende los grupos que pertenezcan a este grupo no podrán ser editados. A continuación se muestar una lista (no editable) de los grupos a los cuales este grupo pertenece.",
	
	rightsdescr => "El acceso de un grupo a ciertos privilegios puede ser dado directamente al grupo o a un grupo diferente al cual este grupo pertenezca. Los privilegios que usted vea debajo sin checkbox son los privilegios que fueron dados a este grupo porque ya pertenecia a otro grupo con ese privilegio. Los privilegios que veas debajo con checkbox son los derechos que pueden ser asignados directametne a este grupo.",

	lock => "Bloqueo",
	members => "Miembros",
	anonymous => "Anónimo",
	permissions => "Permisos",
	permissionskey => "R = lectura, E = edición, los permisos de edición suponen permisos de lectura",
	edit => "Editar",
	none => "Ninguno",
	accessdenied => "Acceso Denegado",
	storydenialmsg => "No tiene acceso para ver esta Nota. Esto puede ser porque no es miembro de {$_CONF["site_name"]}. Por favor <a href=users.php?mode=new>conviértase en un miembro</a> de {$_CONF["site_name"]} para tener acceso.", 
	eventdenialmsg => "No tiene acceso para ver este Evento. Esto puede ser porque no es miembro de {$_CONF["site_name"]}. Por favor <a href=users.php?mode=new>conviértase en un miembro</a> de {$_CONF["site_name"]} para tener acceso.", 
	nogroupsforcoregroup => "Este grupo no pertenece a ninguno de los otros grupos",
	grouphasnorights => "Este grupo no tiene acceso a las funciones de administración",
	newgroup => 'Nuevo Grupo',
	adminhome => 'Página de Administración',
	save => 'Grabar',
	cancel => 'Cancelar',
	delete => 'borrar',
	canteditroot => 'Ha intentado editar el Grupo Root. Como no es miembro del grupo no tiene acceso al mismo. Si cree que esto ha sido un error por favor contacte al administrador del sistema.'
);

#################################################################################################################################3

#admin/word.php
$LANG_WORDS = array(
    editor => "Editor de Palabras de Reemplazo",
    wordid => "ID de la Palabra",
    intro => "Para modificar o borrar una palabra selecciónela. Para agregar una palabra utilice el botón 'Nueva Palabra', a la izquierda.",
    wordmanager => "Administrador de Palabras",
    word => "Palabra",
    replacmentword => "Palabra de Reemplazo",
    newword => "Nueva Palabra"
);

$LANG_DB_BACKUP = array(
    last_ten_backups => 'Últimos 10 Back-ups',
    do_backup => 'Hacer un Backup',
    backup_successful => 'El back up de la base se ha realizado con éxito.',
    no_backups => 'No hay backups en el sistema',
    db_explanation => 'Para crear un backup del sistema utilice el botón de abajo',

     not_found => "Ruta incorrecta o la utilidad mysqldump no se puede ejecutar.<br>Comprueba la definición de <strong>\$_DB_mysqldump_path</strong> en config.php.<br>La variable está definida actualmente como: <var>{$_DB_mysqldump_path}</var>",
    zero_size => 'Fallo de Backup: El tamaño era de 0 bytes',
    path_not_found => "{$_CONF['backup_path']} no existe o no es una carpeta",
    no_access => "ERROR: La carpeta {$_CONF['backup_path']} no es accesible.",
    backup_file => 'Archivo de backup',
    size => 'Tamaño',
    bytes => 'Bytes'


);


$LANG_BUTTONS = array(

    1 => "Inicio",
    2 => "Contacto",
    3 => "Publícate",
    4 => "Links",
    5 => "Encuentas",
    6 => "Calendario",
    7 => "Estadísticas",
    8 => "Personalizar",
    9 => "Buscar",
    10 => "búsqueda avanzada"
);


$LANG_404 = array(
    1 => "Error 404",
    2 => "Buah, he mirado en todos los lados pero no puedo encontrar <b>%s</b>.",
    3 => "<p>Lo sentimos, pero el archivo que pides no existe. Por favor, consulta la <a href=\"{$_CONF['site_url']}\">página principal</a> o la <a href=\"{$_CONF['site_url']}/search.php\">página de búsqueda</a> para ver si puedes encontrar lo que has perdido."
);



$LANG_LOGIN = array (

    1 => 'Se requiere ingresar',
    2 => 'Lo siento, para acceder a esta área tienes que estar autentificado como usuario.',
    3 => 'Ingresar',
    4 => 'Nuevo Usuario'
);



?>
