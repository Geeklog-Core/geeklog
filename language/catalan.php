<?php

###############################################################################
# This is the Spanish language page for GeekLog!
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
    2 => 'lectura de l\'artícle complet',
    3 => 'comentaris',
    4 => 'Edició',
    5 => 'Vota',
    6 => 'Resultats',
    7 => 'Resultats de l\'enquesta',
    8 => 'vots',
    9 => 'Funcions de l\'Administrador/a:',
    10 => 'Propostes',
    11 => 'Notícies',
    12 => 'Blocs',
    13 => 'Seccions',
    14 => 'Enllaços',
    15 => 'Esdeveniments',
    16 => 'Enquestes',
    17 => 'Usuaris/es',
    18 => 'Cerca SQL',
    19 => 'Sortida',
    20 => 'Informació de l\'usuari/a:',
    21 => 'Nom de l\'usuari/a',
    22 => 'Identitat (ID) de l\'usuari/a',
    23 => 'Nivell de Seguretat',
    24 => 'Anònim',
    25 => 'Respondre',
    26 => 'Els següents comentaris són de la persona que els hagi enviat. Aquest lloc no es fa responsable de les opinions expresades pels participants dels fòrums i seccions de comentaris, i el fet de publicar les mateixes no significa que s\'estigui d\'acord amb elles.',
    27 => 'Comentari més recent',
    28 => 'Borrar',
    29 => 'No hi ha comentaris dels usuaris.',
    30 => 'Noticies anteriors',
    31 => 'Etiquetes HTML permeses:',
    32 => 'Error, usuari invàlid',
    33 => 'Error, no ha sigut possible escriure el registre',
    34 => 'Error',
    35 => 'Sortir',
    36 => 'sobre',
    37 => 'No hi ha noticies de l\'usuari/a',
    38 => 'Sindicació del contingut',
    39 => 'Actualització',
    40 => 'Tens <tt>register_globals = Off</tt> al teu <tt>php.ini</tt>. No obstant, Geeklog requereix que <tt>register_globals</tt> estigui <strong>on</strong>. Abans de continuar, siusplau cambia-ho a <strong>on</strong> i reengega el teu servidor web.',
    41 => 'Usuaris invitats',
    42 => 'Escrit per:',
    43 => 'Respondre a',
    44 => 'Torna',
    45 => 'Número d\'Error MySQL',
    46 => 'Missatge d\'Error MySQL',
    47 => 'Funcions de l\'usuari/a',
    48 => 'La meva conta',
    49 => 'Les meves Preferències',
    50 => 'Error en una frase SQL',
    51 => 'ajuda',
    52 => 'Nuevo',
    53 => 'Secció d\'Administració',
    54 => 'No s\'ha pogut obrir l\'arxiu.',
    55 => 'Error en',
    56 => 'Vota',
    57 => 'Contrassenya',
    58 => 'Identificació',
    59 => "¿Encara no tens una conta? <a href=\"{$_CONF['site_url']}/users.php?mode=new\">Inscríu-te</a>",
    60 => 'Afegeix un comentari',
    61 => 'Crea una conta nova',
    62 => 'paraules',
    63 => 'Preferències de Notícies',
    64 => 'Envia-la a un amic o amiga',
    65 => 'Veure la versió per imprimir',
    66 => 'El meu Calendari',
    67 => 'Benvingut/da a ',
    68 => 'Pàgina Inicial',
    69 => 'contacte',
    70 => 'cercar',
    71 => 'envia la notícia',
    72 => 'enllaços a altres webs',
    73 => 'enquestes anteriors',
    74 => 'calendari',
    75 => 'cerca avançada',
    76 => 'estadístiques del lloc',
    77 => 'Plugins',
    78 => 'Propers Esdeveniments',
    79 => 'Novetats',
    80 => 'noticies',
    81 => 'noticia',
    82 => 'hores',
    83 => 'COMENTARIS',
    84 => 'ENLLAÇOS',
    85 => 'últimes 48 hores',
    86 => 'No hi ha comentaris nous',
    87 => 'últimes 2 setmanes',
    88 => 'No hi ha enllaços nous',
    89 => 'No hi ha propers esdeveniments',
    90 => 'Pàgina Inicial',
    91 => 'Aquesta plana va ser creada en',
    92 => 'segons',
    93 => 'Drets d\'autor',
    94 => 'Totos les marques i drets en aquesta plana són dels seus respectius propietaris.',
    95 => 'Una altra web feta amb',
    96 => 'Grups',
    97 => 'Llista de Paraules',
    98 => 'Plug-ins',
    99 => 'NOTICIES',
    100 => 'No hi ha noticies noves',
    101 => 'Els meus Esdeveniments',
    102 => 'Esdeveniments del lloc',
    103 => 'Copies de seguretat de la base de dades',
    104 => 'per',
    105 => 'Usuaris del Correu',
    106 => 'Lectures',
    107 => 'Comprobació de la versió de GL',
    108 => 'Neteja la còpia de visites (Caché)',
    109 => 'Denúncia els abusos',
    110 => 'Denúncia aquest missatge a l\'administrador d\'aquest lloc',
    111 => 'Veure la versió PDF',
    112 => 'Usuaris inscrits',
    113 => 'Documentació'
);

###############################################################################
# calendar.php

$LANG02 = array(
    1 => 'Calendari d\'Esdeveniments',
    2 => 'Disculpa, no hi ha esdeveniments a mostrar.',
    3 => 'Quan',
    4 => 'On',
    5 => 'Descripció',
    6 => 'Afegeix un esdeveniment',
    7 => 'Pròxims esdeveniments',
    8 => 'A l\'afegir aquest esdeveniment al calendari podràs veure rapidament els esdeveniments que t\'interessin. Per fer-ho escull "El meu Calendari" a l\'àrea de Funcions de l\'usuari/a.',
    9 => 'Afegir a "El meu Calendari"',
    10 => 'Treure de "El meu Calendari"',
    11 => "Afegint l\'Esdeveniment al calendari de {$_USER['username']}",
    12 => 'Esdeveniment',
    13 => 'Comença',
    14 => 'Acaba',
    15 => 'Tornar al Calendari'
);

###############################################################################
# comment.php

$LANG03 = array(
    1 => 'Afegeix un Comentari',
    2 => 'Tipo d\'enviament',
    3 => 'Sortida',
    4 => 'Crea una conta',
    5 => 'Nom de l\'usuari/a',
    6 => 'Aquest lloc requereix que tinguis una conta per a poder enviar un comentari. Si ja la tens, introdueix el nom d\'usuari i la contrassenya. Si no tens una conta, pots crear-ne una de nova al formulari de sota',
    7 => 'El teu últim comentari va ser fa ',
    8 => " segons. Aquest lloc requereix com a mínim {$_CONF['commentspeedlimit']} segons entre comentari i comentari",
    9 => 'Comentari',
    10 => 'Envia la denúncia',
    11 => 'Envia el comentari',
    12 => 'Siusplau completa el Títol i Comentari, ja que són dades necessaries per enviar un comentari.',
    13 => 'La teva Informació',
    14 => 'Lectura Prèvia',
    15 => 'Denúncia aquest missatge',
    16 => 'Títol',
    17 => 'Error',
    18 => 'Coses Importants',
    19 => 'Siusplau, intenta mantindre el tema de la noticia.',
    20 => 'Intenta respondre als comentaris dels demés en lloc de començar una nova discussió.',
    21 => 'Llegeix els comentaris enviats per evitar comentaris duplicats.',
    22 => 'Utilitza un títol clar que descrigui el contingut del teu missatge.',
    23 => 'La teva direcció de correu electrònic NO serà divulgada.',
    24 => 'Usuari Anònim',
    25 => '¿Estas segur/a de que vols denunciar aquest missatge a l\'administrador del lloc?',
    26 => '%s ha denunciat el següent comentari abusiu:',
    27 => 'Denúncia d\'abús'
);

###############################################################################
# users.php

$LANG04 = array(
    1 => 'Perfil de l\'usuari/a per',
    2 => 'Nom de l\'usuari/a',
    3 => 'Nom Complet',
    4 => 'Contrassenya',
    5 => 'Correu electrònic',
    6 => 'Pàgina personal',
    7 => 'Biografía',
    8 => 'Clau PGP',
    9 => 'Guardar la Informació',
    10 => 'Últims 10 comentaris',
    11 => 'No hi ha comentaris',
    12 => 'Preferències de l\'usuari/a per',
    13 => 'Enviar un resum cada nit per correu electrònic',
    14 => 'Aquesta contrassenya es genera a l\'atzar. Es recomana cambiar la contrassenya el més aviat possible. Per cambiar la contrassenya conecta al lloc amb el teu nom d\'usuari.',
    15 => "La teva conta a {$_CONF['site_name']} s\'ha creat satisfactoriament. Per poder utilitzar-la tens que ingressar utilizant les dades donades més aball. Guarda aquest missatge per futures referències.",
    16 => 'Informació de la teva conta',
    17 => 'La conta no existeix',
    18 => 'La direcció de correu electrònic ingressada no sembla ser vàlida.',
    19 => 'l\'usuari/a i la direcció de correu electrònic ja existeixen',
    20 => 'La direcció de correu electrònic ingressada no sembla ser vàlida.',
    21 => 'Error',
    22 => "Inscríu-te a {$_CONF['site_name']}!",
    23 => "La creació d\'una conta et donarà les ventatges dels usuaris de {$_CONF['site_name']} i et permetrà enviar noticies, comentaris, etc. Si no tens una conta només ho podràs fer anònimament. Volem remarcar que la teva direcció de correu electrònic <b><i>mai</i></b> serà publicada en aquest lloc.",
    24 => 'La Contrassenya s\'enviarà a la direcció de correu electrònic que ingressis.',
    25 => '¿No recordes la teva contrassenya?',
    26 => 'Ingressa <em>o</em> el teu nom d\'usuari <em>o</em> la direcció de correu electrònic que vas utilitzar per inscriure\'t i clica Enviar Contrassenya. T\'arrivaran per correu electrònic les instruccions per crear una nova contrassenya a la direcció que figura a l\'arxiu,.',
    27 => '¡Inscriu-te ara!',
    28 => 'Enviar la contrassenya per correu electrònic',
    29 => 'desconectat/da de',
    30 => 'conectat/da a',
    31 => 'La funció que has escollit requereix que estiguis connectat/da',
    32 => 'Firma',
    33 => 'No es mostrarà publicament',
    34 => 'Aquest es el teu nom de veritat',
    35 => 'Ingressa la nova contrassenya per cambiar-la',
    36 => 'Comença amb http://',
    37 => 'S\'aplica als teus comentaris',
    38 => '¡Tot sobre Tu! Tothomm podrà llegir això.',
    39 => 'La teva clau pública de PGP per compartir',
    40 => 'Sense icones de seccions',
    41 => 'Intenció de moderar',
    42 => 'Format de la data',
    43 => 'Quantitat màxima de noticies',
    44 => 'Sense requadres',
    45 => 'Mostrar las preferencies de',
    46 => 'Elements exclosos de',
    47 => 'Configuració de Noticies per',
    48 => 'Seccions',
    49 => 'Sense icones en les noticies',
    50 => 'No seleccionis això si no estàs interessat',
    51 => 'Només les noticies noves',
    52 => 'El valor per defecte es',
    53 => 'Recepció cada nit les noticies del dia',
    54 => 'Selecciona les Seccions i Autors que no vols veure.',
    55 => 'Si no en selecciones cap significa que vols la sel·lecció per defecte. De seleccionar-ne alguna, selecciona totes les del teu interès ja que les opcions per defecte ja no seràn tingudes en compte. Les opcions per defecte es mostren resaltades.',
    56 => 'Autors',
    57 => 'Mode de Presentació',
    58 => 'Ordre de classificació',
    59 => 'Límit per Comentari',
    60 => 'Com vols veure els comentaris?',
    61 => 'Primer els més antics o els més recents?',
    62 => 'El valor per defecte es 100',
    63 => "Gracies per utilitzar {$_CONF['site_name']}. T\'hem enviat la teva contrassenya per correu electrònic i arribarà en uns moments. Siusplau segueix les instruccions del missatge.",
    64 => 'Preferències pels comentaris de',
    65 => 'Intenta reconectar-te una altre vegada',
    66 => "Les dades ingressades no son vàlides. Intenta reconectar a sota. ¿Ets un <a href=\"{$_CONF['site_url']}/users.php?mode=new\">usuari/a nou/va</a>?",
    67 => 'Membre desde',
    68 => 'Recorda\'m durant',
    69 => '¿Quanta estona hem de mantenir el teu nom d\'usuari/a en actiu després de conectar?',
    70 => "Personalitza l\'aparença i el contingut de {$_CONF['site_name']}",
    71 => "Una de les grans virtuts de {$_CONF['site_name']} es que pots personalitzar el contingut que reps i l\'aparença del lloc. Per poder fer-ho, primer has d\'<a href=\"{$_CONF['site_url']}/users.php?mode=new\">inscriure\'t</a> a {$_CONF['site_name']}. Si ja ets membre, utilitza el formulari de l\'esquerra per conectar-te.",
    72 => 'Tema',
    73 => 'Idioma',
    74 => '¡Cambia l\'apariença d\'aquesta pàgina!',
    75 => 'Seccions enviades per correu electrònic a',
    76 => 'Si selecciones una o més Seccions de la llista de sota, totes les noticies noves d\'aquestes Seccions et seran enviades per correu electrònic al finalitzar el dia.',
    77 => 'Foto',
    78 => '¡Afegeix una foto teva!',
    79 => 'Activa això per borrar aquesta imatge',
    80 => 'Identificació',
    81 => 'Envia per correu electrònic',
    82 => 'Últimes 10 noticies per l\'usuari/a',
    83 => 'Estadístiques de noticies per l\'usuari/a',
    84 => 'Nombre total d\'articles:',
    85 => 'Nombre total de comentaris:',
    86 => 'Buscar tots els comentaris de',
    87 => 'El teu nom d\'accés',
    88 => "Algú (possiblement tu mateix/a) ha solicitat una contrassenya nova per la teva conta  \"%s\" a {$_CONF['site_name']}, <{$_CONF['site_url']}>.\n\nSi de veritat vols que es porti a terme aquesta acció, siusplau apreta a l\'enllaç següent:\n\n",
    89 => "si no vols que es porti a terme aquesta acció, simplement ignora aquest missatge i la petició serà desatinguda (la teva contrassenya no es modificarà).\n\n",
    90 => 'Pots ingressar a sota una contrassenya nova per la teva conta. Siusplau, tingues en compte que la contrassenya antiga seguira sent vàlida fins que enviis aquest formulari.',
    91 => 'Crea una contrassenya nova',
    92 => 'Ingressa una contrassenya nova',
    93 => 'La teva ultima petició d\'una nova contrassenya va ser fa %d segons. Aquest lloc requereix com a mínim %d segons entre peticions de contrassenyes.',
    94 => 'Borra la conta "%s"',
    95 => 'Apreta a sota el botó "borrar la conta" per retirar la teva conta de la nostra base de dades. Siusplau, tingues en compte que qualsevol noticia o comentari que hagis publicat amb aquesta conta <strong>no</strong> es borrara, sino que apareixera com "Anònim".',
    96 => 'Borra la conta',
    97 => 'Confirma el borrat de la Conta',
    98 => 'Estàs segur/a de que vols borrar la teva conta? Al fer-ho, no podras accedir a aquest lloc una altre vegada (a no ser que creis una conta nova). Si estàs segur/a, apreta "borrar conta" de nou en el formulari de sota.',
    99 => 'Opcions de privacitat per',
    100 => 'Correu de l\'Administrador/a',
    101 => 'Permet el correu dels Administradors/es del lloc',
    102 => 'Correu dels usuaris',
    103 => 'Permet el correu d\'altres usuaris',
    104 => 'Mostra l\'estat de qui està conectat/da',
    105 => 'Mostra al bloc Who\'s Online (usuaris conectats)',
    106 => 'Ubicació',
    107 => 'Mostrat en el teu perfil public'
);

###############################################################################
# index.php

$LANG05 = array(
    1 => 'No hi ha novetats a mostrar',
    2 => 'No hi ha noves noticies a mostrar. Pot ser que no hi hagi novetats en aquest Secció o que les teves preferències siguin molt restrictives.',
    3 => 'per la Secció %s',
    4 => 'Notícia del Dia',
    5 => 'Següent',
    6 => 'Anterior',
    7 => 'Primer',
    8 => 'Últim'
);

###############################################################################
# links.php

$LANG06 = array(
    1 => 'Enllaços',
    2 => 'No hi ha enllaços per mostrar.',
    3 => 'Afegeix un enllaç'
);

###############################################################################
# pollbooth.php

$LANG07 = array(
    1 => 'Vot guardat',
    2 => 'El teu vot s\'ha computat per l\'enquesta',
    3 => 'Vota',
    4 => 'Enquestes al sistema',
    5 => 'Vots',
    6 => 'Veure les altres preguntes de l\'enquesta'
);

###############################################################################
# profiles.php

$LANG08 = array(
    1 => 'Hi ha hagut un error a l\'enviar el teu missatge. Prova-ho de nou siusplau.',
    2 => 'El missatge s\'ha enviat satisfactoriament.',
    3 => 'Siusplau assegura\'t d\'ingressar una direcció de correu electrònic vàlida al camp \'Respondre a\'.',
    4 => 'Siusplau completa els camps Remitent, Respondre a, Títol i Missatge',
    5 => 'Error: No existeix l\'usuari/a.',
    6 => 'Hi ha hagut un error.',
    7 => 'Perfil d\'usuari/a de',
    8 => 'Nom de l\'usuari/a',
    9 => 'URL de l\'usuari/a',
    10 => 'Envia un missatge a',
    11 => 'Remitent:',
    12 => 'Respondre a:',
    13 => 'Títol:',
    14 => 'Missatge:',
    15 => 'No es traduirà el codi HTML.',
    16 => 'Envia el missatge',
    17 => 'Enviar a un amic o amiga',
    18 => 'Destinatari/a',
    19 => 'Direcció de correu electrònic de destí',
    20 => 'Remitent',
    21 => 'Respondre a',
    22 => 'Es necessari omplir tots els camps',
    23 => "Aquest correu electrònic te l\'ha enviat %s en %s perque va pensar que podria interessar-te aquesta notícia a  {$_CONF['site_url']}. Això no és SPAM (correu escombraria) i les direccions de correu electrònic involucrades en aquest enviament no s\'han guardat pel seu ús posterior.",
    24 => 'Comentari sobre aquesta notícia a',
    25 => 'Has de conectar-te per utilitzar aquesta eina. Aquest control es realitza per prevenir del mal ús del sistema.',
    26 => 'Aquest formulari et permetrà enviar un correu electrònic a l\'usuari seleccionat. Tots els camps són necessaris.',
    27 => 'Missatge curt',
    28 => '%s va escriure: ',
    29 => "Aquest és el resum diari de {$_CONF['site_name']} per ",
    30 => ' Noticies diaries per ',
    31 => 'Títol',
    32 => 'Data',
    33 => 'Llegeix la Notícia completa a',
    34 => 'Fi del missatge',
    35 => 'Ho sento, aquest usuari prefereix no rebre missatges.'
);

###############################################################################
# search.php

$LANG09 = array(
    1 => 'Cerca Avançada',
    2 => 'Paraules Clau',
    3 => 'Secció',
    4 => 'Tot',
    5 => 'Tipo',
    6 => 'noticies',
    7 => 'Comentaris',
    8 => 'Autors',
    9 => 'Tot',
    10 => 'Cerca',
    11 => 'Resultats de la cerca',
    12 => 'resultats',
    13 => 'Cerca de noticies: No hi ha hagut coincidencies',
    14 => 'No s\'han trobat coincidencies al buscar: ',
    15 => 'Siusplau torna-ho a provar.',
    16 => 'Títol',
    17 => 'Data',
    18 => 'Autor',
    19 => "Cerca en tota la base de dades de <B>{$_CONF['site_name']}</B>",
    20 => 'Data',
    21 => 'a',
    22 => '(Format de data DD-MM-YYYY)',
    23 => 'Lectures',
    24 => 'Trobats %d elements',
    25 => 'coincidencies amb',
    26 => 'elements en ',
    27 => 'segons',
    28 => 'No s\'han trobat coincidencies en Noticies i Comentaris',
    29 => 'Resultats de les Noticies i Comentaris',
    30 => 'Cap enllaçe coincideix amb la teva cerca',
    31 => 'Aquest plug-in no ha donat resultats',
    32 => 'Esdeveniment',
    33 => 'URL',
    34 => 'Ubicació',
    35 => 'Tot el dia',
    36 => 'Cap esdeveniment ha coincidit amb la teva cerca',
    37 => 'Resultats d\'Esdeveniments',
    38 => 'Resultats d\'Enllaços',
    39 => 'Enllaços',
    40 => 'Esdeveniments',
    41 => 'La paraula a cercar ha de tenir com a mínim 3 lletres.',
    42 => 'Siusplau utilitza una data en el següent format: YYYY-MM-DD (any-mes-dia).',
    43 => 'frase exacta',
    44 => 'totes aquestes paraules',
    45 => 'qualsevol d\'aquestes paraules',
    46 => 'Següent',
    47 => 'Anterior',
    48 => 'Autor/a',
    49 => 'Data',
    50 => 'Lectures',
    51 => 'Enllaç',
    52 => 'Ubicació',
    53 => 'Resultats de la notícia',
    54 => 'Resultats de Comentari',
    55 => 'la frase',
    56 => 'I',
    57 => 'O'
);

###############################################################################
# stats.php

$LANG10 = array(
    1 => 'Estadístiques del lloc',
    2 => 'Total d\'accessos al sistema',
    3 => 'Noticies(Comentaris) en el sistema',
    4 => 'Enquestes(Respostes) en el sistema',
    5 => 'Enllaços(Visitats) en el sistema',
    6 => 'Esdeveniments en el sistema',
    7 => 'Les 10 Noticies més llegides',
    8 => 'Títol de la Noticia',
    9 => 'Accessos',
    10 => 'Sembla que no hi ha notícies en aquest lloc o que ningú les ha vist encara.',
    11 => 'Les 10 noticies més comentades',
    12 => 'Comentaris',
    13 => 'Sembla que no hi ha noticies en aquest lloc o que ningú ha escrit un comentari sobre elles.',
    14 => 'Les 10 Enquestes amb més vots',
    15 => 'Pregunta',
    16 => 'Vots',
    17 => 'Sembla que no hi ha enquestes en aquest lloc o que ningú ha votat encara.',
    18 => 'Els 10 Enllaços més visitats',
    19 => 'Enllaços',
    20 => 'Visites',
    21 => 'Sembla que en aquest lloc no hi ha enllaços o que ningú els ha visitat.',
    22 => 'Les 10 Noticies més enviades per correu electrònic',
    23 => 'missatges per correu electrònic',
    24 => 'Sembla que ningú ha enviat una notícia per correu electrònic en aquest lloc.'
);

###############################################################################
# article.php

$LANG11 = array(
    1 => 'Relacionat amb això...',
    2 => 'Envía-ho a un amic',
    3 => 'Versió per imprimir',
    4 => 'Opcions de la Notícia',
    5 => 'Format de notícia en PDF'
);

###############################################################################
# submit.php

$LANG12 = array(
    1 => 'Per enviar %s has d\'estar conectat com usuari/a.',
    2 => 'Ingressa',
    3 => 'Nou Usuari/a',
    4 => 'Afegeix un Esdeveniment',
    5 => 'Afegeix un Enllaç',
    6 => 'Afegeix una notícia',
    7 => 'Has de conectar-te',
    8 => 'Enviament de col·laboracions',
    9 => 'Quan envíes informació a aquest lloc et demanem que tinguis en compte els següents consells: <ul><li>Completa tots els camps requerits<li>Comprova bé les URL\'s<li>Facilita informació completa i precisa</ul>',
    10 => 'Títol',
    11 => 'Enllaç',
    12 => 'Data d\'inici',
    13 => 'Data de finalització',
    14 => 'Lloc',
    15 => 'Descripció',
    16 => 'Si es un altre, especifica',
    17 => 'Categoría',
    18 => 'Un altre',
    19 => 'Llegeix abans',
    20 => 'Error: Falta la Categoría',
    21 => 'Siusplau, quan seleccionis \'Un altre\' completa el nom de la categoría',
    22 => 'Error: Falten Camps',
    23 => 'Siusplau completa tots els camps del formulari. Es necessari omplir tots els camps.',
    24 => 'Colaboració guardada',
    25 => 'Les teves col·laboracions s\'han guardat satisfactoriament.',
    26 => 'Límit de Velocitat',
    27 => 'Nom de l\'usuari/a',
    28 => 'Secció',
    29 => 'Notícia',
    30 => 'La teva darrera col·laboració va ser fa ',
    31 => " segons.  Aquest lloc requereix com a mínim {$_CONF['speedlimit']} segons entre enviaments",
    32 => 'Lectura Previa',
    33 => 'Lectura previa de la noticia',
    34 => 'Sortida',
    35 => 'No es permeten etiquetes d\'HTML',
    36 => 'Format del text',
    37 => "Els esdeveniments enviats a {$_CONF['site_name']} s\'afegeixen al Calendari Públic, on la resta d\'usuaris poden afegir-lo al seu Calendari Personal. Aquesta funció <b>NO</b> està pensada per guardar els teus esdeveniments personals com ara aniversaris, cites, etc.<br><br>Una vegada enviat, l\'esdeveniment serà evaluat pels Administradors. De ser aprobat, es mostrarà al Calendari Públic",
    38 => 'Afegeix un esdeveniment a',
    39 => 'Calendari Públic',
    40 => 'Calendari Personal',
    41 => 'Hora de finalització',
    42 => 'Hora d\'inici',
    43 => 'Esdeveniment que dura tot el dia',
    44 => 'Direcció, linia 1',
    45 => 'Direcció, linia 2',
    46 => 'Ciutat/Localitat',
    47 => 'Província/Estat',
    48 => 'Còdig Postal',
    49 => 'Tipo d\'Esdeveniment',
    50 => 'Edita els tipus d\'esdeveniments',
    51 => 'Lloc',
    52 => 'Borrar',
    53 => 'Crea una conta'
);

###############################################################################
# ADMIN PHRASES - These are file phrases used in admin scripts
###############################################################################

###############################################################################
# admin/auth.inc.php

$LANG20 = array(
    1 => 'Es demana verificació',
    2 => 'Accés denegat! La informació d\'ingrés és incorrecta',
    3 => 'La contrassenya ingressada es invàlida',
    4 => 'Usuari/a:',
    5 => 'Contrassenya:',
    6 => 'Tot accés a les parts administratives queda registrat i revisat.<br>Aquesta pàgina és per l\'ús exclusiu del personal autoritzat.',
    7 => 'Identificació'
);

###############################################################################
# admin/block.php

$LANG21 = array(
    1 => 'No tens drets d\'Administrador/a',
    2 => 'No tens els drets suficients per editar aquest bloc.',
    3 => 'Editor de Blocs',
    4 => 'Hi ha hagut un problema amb la lectura d\'aquesta transmissió (veure error.log per més detalls).',
    5 => 'Títol del Bloc',
    6 => 'Secció',
    7 => 'Tot',
    8 => 'Nivell de seguretat del bloc',
    9 => 'Ordre del Bloc',
    10 => 'Tipus de bloc',
    11 => 'Bloc del Sistema',
    12 => 'Bloc Normal',
    13 => 'Opcions per el Bloc del Sistema',
    14 => 'RDF(Resource Description Framework)URL',
    15 => 'última actualització del RDF',
    16 => 'Opcions per el Bloc Normal',
    17 => 'Contingut del Bloc',
    18 => 'Siusplau completa els camps Títol, Nivell de Seguretat i Contingut del bloc',
    19 => 'Administrador',
    20 => 'Títol',
    21 => 'Nivell de Seguretat',
    22 => 'Tipus',
    23 => 'Nombre d\'Ordre',
    24 => 'Secció',
    25 => 'Per modificar o borrar un bloc, seleccióna\'l més avall. Per crear-ne un de nou, selecciona \'Nou Bloc\' a dalt.',
    26 => 'Bloc de maquetació',
    27 => 'Bloc de PHP',
    28 => 'Opcions del Bloc PHP',
    29 => 'Funcions del Bloc',
    30 => 'Si vols que el teu bloc utilitzi codi PHP, ingressa aqui el nom de la funció. La funció ha de tenir el prefixe "phpblock_" (ex. phpblock_getweather). De no ser així NO sera invocada. Assegura\'t de no incluir els parèntesis, "()", al final del nom. Per últim, es recomana que guardis tot códi PHP a /path/to/geeklog/system/lib-custom.php. Això et permetrà que el teu codi es mantingui als canvis de versio del sistema.',
    31 => 'Error en un Bloc PHP.  La funció, %s, no existeix.',
    32 => 'Error, Falten Camps',
    33 => 'Has d\'ingressar la URL de l\'archivo .rdf pels Blocs del Sistema',
    34 => 'Has d\'ingressar el Títol i la Funció als Blocs PHP',
    35 => 'Has d\'ingressar el Título i el Contingut pels Blocs Normals',
    36 => 'Has d\'ingressar el contingut pels Blocs de Maquetació',
    37 => 'El nom de la funció en el Bloc PHP es invàlid',
    38 => 'Les funcions pels Blocs PHP han de tenir el prefixe \'phpblock_\' (ex. phpblock_getweather). Es demana el prefixe per qüestions de seguretat, per evitar que s\'executi codi no desitjat.',
    39 => 'Ubicació',
    40 => 'Esquerra',
    41 => 'Dreta',
    42 => 'Has d\'ingressar el nombre d\'ordre i el nivell de seguretat pels blocs per defecte',
    43 => 'Només a la Pàgina d\'Inici',
    44 => 'Accés Denegat',
    45 => "Estàs intentant accedir a un bloc al que no tens drets d\'accés. Aquest intent s\'ha registrat. Siusplau <a href=\"{$_CONF['site_admin_url']}/block.php\">torna a la pantalla d\'administració de blocs</a>.",
    46 => 'Nou Bloc',
    47 => 'Pàgina d\'Inici - Administrador',
    48 => 'Nom del Bloc',
    49 => ' (sense espais i ha de ser únic)',
    50 => 'URL de l\'archiu d\'ajuda',
    51 => 'inclou http://',
    52 => 'Si deixes aquest camp en blanc no es mostrarà l\'icona d\'ajuda',
    53 => 'Habilitat',
    54 => 'guardar',
    55 => 'cancelar',
    56 => 'borrar',
    57 => 'Mou el bloc aball',
    58 => 'Mou el bloc amunt',
    59 => 'Mou el bloc a la dreta',
    60 => 'Mou el bloc a l\'esquerra'
);

###############################################################################
# admin/event.php

$LANG22 = array(
    1 => 'Editor d\'Esdeveniments',
    2 => 'Error',
    3 => 'Títol',
    4 => 'URL',
    5 => 'Data d\'Inici',
    6 => 'Data de Finalització',
    7 => 'Lloc',
    8 => 'Descripció',
    9 => '(inclou http://)',
    10 => 'Has de completar tots els camps d\'aquest formulari.',
    11 => 'Administrador de l\'Esdeveniment',
    12 => 'Per modificar o borrar un esdeveniment, clica sobre ell a sota. Per crear un Nou Esdeveniment clica sobre Nou Esdeveniment a dalt. Clica sobre [C] per crear una còpia d\'un esdeveniment ja existent.',
    13 => 'Títol',
    14 => 'Data d\'Inici',
    15 => 'Data de Finalització',
    16 => 'Accés Denegat',
    17 => "No tens permís per accedir a aquest Esdeveniment. Tot intent d\'accés serà registrat. Siusplau, torna a <a href=\"{$_CONF['site_admin_url']}/event.php\">la pàgina d\'Administració d\'Esdeveniments</a>.",
    18 => 'Nou Esdeveniment',
    19 => 'Pàgina d\'Inici - Administrador',
    20 => 'guardar',
    21 => 'cancelar',
    22 => 'borrar',
    23 => 'Data d\'inici incorrecta.',
    24 => 'Data de finalització incorrecta.',
    25 => 'La data de finalització es anterior a la d\'inici.'
);

###############################################################################
# admin/link.php

$LANG23 = array(
    1 => 'Editor d\'Enllaços',
    2 => '',
    3 => 'Títol',
    4 => 'URL',
    5 => 'Categoria',
    6 => '(incluir http://)',
    7 => 'Un altre',
    8 => 'Quantitat d\'accessos',
    9 => 'Descripció',
    10 => 'Has de completar els camps Títol, URL i Descripció.',
    11 => 'Administrador',
    12 => 'Per modificar o borrar un Enllaç selecciona\'l més avall. Per crear-ne un de nou selecciona \'Nou Enllaç\' més amunt.',
    13 => 'Títol',
    14 => 'Categoría',
    15 => 'URL',
    16 => 'Accés Denegat',
    17 => "No tens permís per accedir a aquest Enllaç. Tot intent d\'accés serà registrat. Siusplau, torna a <a href=\"{$_CONF['site_admin_url']}/link.php\">la pàgina d\'Administració d\'Enllaços</a>.",
    18 => 'Nou Enllaç',
    19 => 'Pàgina d\'Inici - Administrador',
    20 => 'Si es una altre, especifica',
    21 => 'guardar',
    22 => 'cancelar',
    23 => 'borrar'
);

###############################################################################
# admin/story.php

$LANG24 = array(
    1 => 'Noticies Anteriors',
    2 => 'Noticies Següents',
    3 => 'Modo',
    4 => 'Modo d\'enviament',
    5 => 'Editor de Noticies',
    6 => 'No hi ha Noticies en el sistema',
    7 => 'Autor',
    8 => 'guardar',
    9 => 'Lectura previa',
    10 => 'cancelar',
    11 => 'borrar',
    12 => 'ID',
    13 => 'Títol',
    14 => 'Secció',
    15 => 'Data',
    16 => 'Introducció',
    17 => 'Text',
    18 => 'Accessos',
    19 => 'Comentaris',
    20 => '',
    21 => '',
    22 => 'Llista de Noticies',
    23 => 'Per modificar o borrar una Notícia selecciona el numero de Notícia mes avall. Per veure la Notícia selecciona el títol de la mateixa. Per crear una nova Notícia selecciona \'Enviar Notícia\' més amunt.',
    24 => 'L\'ID que has escollit per aquest tema ja està sent utilitzada. Siusplau, utilitza un altre ID.',
    25 => '',
    26 => 'Lectura Previa',
    27 => '',
    28 => '',
    29 => '',
    30 => 'Errors al Pujar Arxius',
    31 => 'Siusplau omple els camps d\'Autor, Títol i Text',
    32 => 'Destacada',
    33 => 'Només hi pot haver una Notícia destacada',
    34 => 'Borrador',
    35 => 'Si',
    36 => 'No',
    37 => 'Més de',
    38 => 'Més en',
    39 => 'correus electrònics',
    40 => 'Accés Denegat',
    41 => "Estàs intentant accedir a una Notícia a la que no tens drets d\'accés, per tant, podràs veure la Notícia però no editar-la. Siusplau torna a la <a href=\"{$_CONF['site_admin_url']}/story.php\">pàgina d\'administració</a> quan hagis acabat.",
    42 => "Estàs intentant accedir a una Notícia a la que no tens drets d\'accés. Siusplau torna a la <a href=\"{$_CONF['site_admin_url']}/story.php\">pàgina d\'administració</a>.",
    43 => 'Nova Notícia',
    44 => 'Pàgina d\'Inici - Administrador',
    45 => 'Accés',
    46 => '<b>NOTA:</b> si modifiques aquesta data per una de futura, la Notícia no es publicarà dins aquella data. Això també inclou l\'enviament de titulars RDF(Resource Description Framework), la cerca i les estadistiques del lloc.',
    47 => 'Imatges',
    48 => 'imatge',
    49 => 'dre',
    50 => 'esq',
    51 => 'Per insertar una imatge a la Notícia has d\'incloure un text amb el format [imageX], [imageX_left] o [imageX_right], on X es el nombre de la imatge dints de la llista. NOTA: només pots utilitzar les imatges de la llista, si no la Notícia no es podrà guardar',
    52 => 'Borrar',
    53 => 'no s\'ha utilitzat.  Has d\'incloure aquesta imatge a la Introducció o el Text per poder guardar els canvis',
    54 => 'Imatges no utilitzades',
    55 => 'Hi ha hagut els següents errors a l\'intentar guardar la teva Notícia. Siusplau, corregeix els errors abans de guardar.',
    56 => 'Mostrar icona de Tema',
    57 => 'Veure imatge sense proporció',
    58 => 'Gestió de les noticies',
    59 => 'Opció',
    60 => 'Habilitat',
    61 => 'Auto arxiu',
    62 => 'Auto borrat'
);

###############################################################################
# admin/poll.php

$LANG25 = array(
    1 => 'Mode',
    2 => 'Siusplau tecleja una pregunta i com a mínim una resposta.',
    3 => 'Data de creació',
    4 => 'Enquesta %s guardada',
    5 => 'Editar l\'Enquesta',
    6 => 'Identificació',
    7 => '(no utilitzis espais)',
    8 => 'Apareix a la Portada',
    9 => 'Pregunta',
    10 => 'Respostes / Vots',
    11 => 'Hi ha hagut un error al buscar les dades per la resposta de l\'Enquesta %s',
    12 => 'Hi ha hagut un error al buscar les dades per la pregunta de l\'Enquesta %s',
    13 => 'Crear Enquesta',
    14 => 'guardar',
    15 => 'cancelar',
    16 => 'borrar',
    17 => 'Siusplau tecleja un nom d\'identificació (ID) de l\'enquesta',
    18 => 'Llistat d\'Enquestes',
    19 => 'Per modificar o borrar una Enquesta triala a la lista de sota. Per crear-ne una de nova, selecciona \'Nova Enquesta\' més amunt.',
    20 => 'Votants',
    21 => 'Accés Denegat',
    22 => "Estàs intentant accedir a una Enquesta a la que no tens drets d\'accés. Siusplau torna a la <a href=\"{$_CONF['site_admin_url']}/poll.php\">pàgina d\'administració.",
    23 => 'Nova Enquesta',
    24 => 'Pàgina d\'Inici - Administrador',
    25 => 'Si',
    26 => 'No'
);

###############################################################################
# admin/topic.php

$LANG27 = array(
    1 => 'Editor de Seccions',
    2 => 'Identificació (ID)',
    3 => 'Nom',
    4 => 'Imatge',
    5 => '(no utilitzis espais)',
    6 => 'Al borrar una Secció es borraran totes les teves Noticies i Blocs associats',
    7 => 'Siusplau completa els camps ID i Nom',
    8 => 'Administrador de Seccions',
    9 => 'Per modificar o borrar un tema, apreta sobre el tema. Per crear un tema nou, apreta el botó de Nou Tema a l\'esquerra. Trobaràsel teu nivell d\'accés pel tema entre parèntesis. L\'asterisc(*) denota el tema  per defecte.',
    10 => 'Nombre d\'Ordre',
    11 => 'Notícies/Pàgina',
    12 => 'Accés Denegat',
    13 => "Estàs intentant accedir a una Secció a la que no tens drets d\'accés. Siusplau torna a la <a href=\"{$_CONF['site_admin_url']}/topic.php\">pàgina d\'administració.",
    14 => 'Mètode d\'Ordenament',
    15 => 'alfabètic',
    16 => 'per defecte és',
    17 => 'Nova Secció',
    18 => 'Pàgina d\'Inici - Administrador',
    19 => 'guardar',
    20 => 'cancelar',
    21 => 'borrar',
    22 => 'Per defecte',
    23 => 'converteix-lo en el tema per defecte per a noves col·laboracions',
    24 => '(*)',
    25 => 'Arxiva el tema',
    26 => 'converteix-lo en el tema per defecte per a notícies arxivades. Només es permet un tema.'
);

###############################################################################
# admin/user.php

$LANG28 = array(
    1 => 'Editor d\'Usuaris',
    2 => 'ID',
    3 => 'Nom d\'Usuari/a',
    4 => 'Nom Complet',
    5 => 'Contrassenya',
    6 => 'Nivell de Seguretat',
    7 => 'Direcció de correu electrònic',
    8 => 'Pàgina d\'Inici',
    9 => '(no utilitzis espais)',
    10 => ' Siusplau, omple els camps de Nom d\'Usuari/a i direcció de correu electrònic',
    11 => 'Administrador d\'Usuaris',
    12 => 'Per modificar o borrar a un/a usuari/a, apreta sobre l\'usuari/a a sota.  Per crear un/a usuari/a nou apreta el botó de Nou Usuari a l\'esquerra. Pots fer cerques senzilles al teclejar parts del nom d\'usuari, direcció de correu electrònic o nom complet (per exemple *son* o *.edu) al formulari de sota..',
    13 => 'Nivell de seguretat',
    14 => 'Data d\'Inscripció',
    15 => 'Nou Usuari',
    16 => 'Pàgina d\'Inici - Administrador',
    17 => 'Canvia la contrassenya',
    18 => 'Cancelar',
    19 => 'Borrar',
    20 => 'Guardar',
    21 => 'El Nom d\'Usuari/a proposat ja existeix.',
    22 => 'Error',
    23 => 'Importació Massiva',
    24 => 'Importació massiva d\'Usuaris',
    25 => "Pots importar una llista d\'Usuaris/es a {$_CONF['site_name']}. L\'arxiu amb la llista d\'usuaris/es ha de tenir un registre per linea i els camps separats per TAB (tabulador). Els camps han d\'estar en el següent ordre: Nom Complet, Nom d\'Usuari, Direcció de Correu electrònic. A cada usuari afegit se li enviarà per correu electrònic una contrassenya generada a l\'atzar, que podràn canviar a l\'ingressar al lloc. Siusplau, comprova bé l\'arxiu d\'importació ja que els errors trovats poden arrivar a necessitar arranjaments manuals.",
    26 => 'Cerca',
    27 => 'Limita els resultats',
    28 => 'Marca la casella per borrar aquesta imatge',
    29 => 'Ruta',
    30 => 'Importació',
    31 => 'Nous Usuaris',
    32 => 'Procés finalitzat. S\'han importat %d i hi ha hagut %d errors',
    33 => 'enviar',
    34 => 'Error: Has d\'especificar l\'arxiu que vols pujar.',
    35 => 'Últim accés',
    36 => '(mai)'
);

###############################################################################
# admin/moderation.php

$LANG29 = array(
    1 => 'Aprovar',
    2 => 'Borrar',
    3 => 'Editar',
    4 => 'Perfil',
    10 => 'Títol',
    11 => 'Data d\'Inici',
    12 => 'URL',
    13 => 'Categoria',
    14 => 'Data',
    15 => 'Tema',
    16 => 'Nom de l\'usuari/a',
    17 => 'Nom complet',
    18 => 'correu electrònic',
    34 => 'Pàgina d\'administració',
    35 => 'Enviaments de Noticies',
    36 => 'Enviaments d\'Enllaços',
    37 => 'Enviaments d\'Esdeveniments',
    38 => 'Enviar',
    39 => 'No hi ha enviaments a moderar en aquest moment',
    40 => 'Enviaments de l\'usuari/a'
);

###############################################################################
# calendar.php

$LANG30 = array(
    1 => 'Diumenge',
    2 => 'Dilluns',
    3 => 'Dimarts',
    4 => 'Dimecres',
    5 => 'Dijous',
    6 => 'Divendres',
    7 => 'Dissabte',
    8 => 'Afegeix un esdeveniment',
    9 => 'Esdeveniment de %s',
    10 => 'Esdeveniments per',
    11 => 'Calendari Mestre',
    12 => 'El meu Calendari',
    13 => 'Gener',
    14 => 'Febrer',
    15 => 'Març',
    16 => 'Abril',
    17 => 'Maig',
    18 => 'Juny',
    19 => 'Juliol',
    20 => 'Agost',
    21 => 'Setembre',
    22 => 'Octubre',
    23 => 'Novembre',
    24 => 'Desembre',
    25 => 'Tornar a ',
    26 => 'Tot el dia',
    27 => 'Setmana',
    28 => 'Calendari Personal per',
    29 => 'Calendari Públic',
    30 => 'borra l\'esdeveniment',
    31 => 'Afegeix',
    32 => 'Esdeveniment',
    33 => 'Data',
    34 => 'Hora',
    35 => 'Afegit ràpid',
    36 => 'Envía',
    37 => 'Disculpa, l\'opció de calendari personal no es troba habilitada en aquest lloc',
    38 => 'Editor Personal d\'Esdeveniments',
    39 => 'Dia',
    40 => 'Setmana',
    41 => 'Mes'
);

###############################################################################
# admin/mail.php

$LANG31 = array(
    1 => "{$_CONF['site_name']}Utilidad de correo electrónico",
    2 => 'De',
    3 => 'Respondre a',
    4 => 'Títol',
    5 => 'Missatge',
    6 => 'Enviar a:',
    7 => 'Tots els usuaris',
    8 => 'Administrador',
    9 => 'Opcions',
    10 => 'HTML',
    11 => 'Missatge Urgent!',
    12 => 'Enviament',
    13 => 'Reinici',
    14 => 'Ignorar les preferencies de l\'usuari/a',
    15 => 'Error a l\'enviar a: ',
    16 => 'S\'ha enviat satisfactoriament a: ',
    17 => "<a href={$_CONF['site_admin_url']}/mail.php>Enviar un altre missatge</a>",
    18 => 'Per',
    19 => 'NOTA: si vols enviar un missatge a tots els membres del lloc, selecciona el grup Logged-In Users a la llista.',
    20 => "S\'han enviat <successcount> missatges satisfactoriament i <failcount> han fallat.  Si vols, els detalls de cada enviament figuren a sota. També pots <a href=\"{$_CONF['site_admin_url']}/mail.php\">enviar un altre missatge</a> o tornar a <a href=\"{$_CONF['site_admin_url']}/moderation.php\">la pàgina d\'administració</a>.",
    21 => 'Fallats',
    22 => 'Exitosos',
    23 => 'No hi ha hagut enviaments fallits',
    24 => 'No hi ha hagut enviaments satisfactoris',
    25 => '-- Selecciona el Grup --',
    26 => 'Siusplau, omple tots els camps del formulari i selecciona un grup d\'usuaris de la llista desplegable.'
);

###############################################################################
# admin/plugins.php

$LANG32 = array(
    1 => 'La instal·lació de Plug-in(s) pot malmetre la teva instal·lació de Geeklog i, possiblement, el teu sistema. Es important que només instalis Plug-in(s) obtinguts de <a href="http://www.geeklog.net" target="_blank">Geeklog</a> ja que han sigut comprobats en varis entorns. Es també important que entenguis que la instal·lació del Plug-in necessita la execució d\'instruccions del sistema que poden portar problemes de seguretat. Tot i aquesta advertencia, no garantitzem l\'èxit de la instal·lació del Plug-in ni ens fem responsables per qualsevol dany causat durant la instal·lació (o posterior a la mateixa). En altres paraules, instal·la el Plug-in sota la teca responsabilitat. Les instruccions particulars d\'instal·lació venen dints de cada Plug-in.',
    2 => 'Advertència de la instal·lació del Plug-in',
    3 => 'Formulari d\'instalació del Plug-in',
    4 => 'Arxiu del Plug-in',
    5 => 'Llistat de Plug-in(s)',
    6 => 'Advertencia: El Plug-in ja està instal·lat!',
    7 => 'El Plug-in que intentes instal·lar ja existeix. Siusplau borra el Plug-in abans de reinstalar-lo.',
    8 => 'Ha fallat la comprobació de compatibilitat del Plug-in',
    9 => 'Aquest Plug-in requereix una versió més nova de Geeklog. Pots obtenir una còpia actualitzada de <a href=http://www.geeklog.net>Geeklog</a> o instal·lar una altre versió del Plug-in.',
    10 => '<br><b>No hi ha Plug-in(s) instal·lats.</b><br><br>',
    11 => 'Per modificar o borrar un Plug-in selecciona el numero a l\'esquerra del mateix. Per accedir a la pàgina dels seus creadors seleccioni en el títol del Plug-in. Per instal·lar un nou Plug-in selecciona \'Nou Plug-in\' més amunt.',
    12 => 'no s\'ha donat un nom de plugin a la funció plugineditor()',
    13 => 'Editor de Plugins',
    14 => 'Nou Plug-in',
    15 => 'Pàgina d\'Inici - Administrador',
    16 => 'Nom del Plug-in',
    17 => 'Versió',
    18 => 'Versió de Geeklog',
    19 => 'Habilitat',
    20 => 'Si',
    21 => 'No',
    22 => 'Instal·lació',
    23 => 'Guardar',
    24 => 'Cancelar',
    25 => 'Borrar',
    26 => 'Nom',
    27 => 'Portada',
    28 => 'Versió',
    29 => 'Versió de Geeklog',
    30 => 'Vols borrar el Plug-in?',
    31 => 'Estàs segur/a de que vols esborrar aquest Plug-in? Al fer-ho borraràs tots els arxius, estructures i dades associades. Si estàs segur/a selecciona "Borrar" al formulari de sota.',
    32 => '<p><b>Error, l\'etiqueta AutoLink no té el format correcte</b></p>',
    33 => 'Versió del codi',
    34 => 'Actualització'
);

###############################################################################
# admin/syndication.php

$LANG33 = array(
    1 => 'Creació de la transmissió',
    2 => 'guardar',
    3 => 'borrar',
    4 => 'cancelar',
    10 => 'Sindicació del contingut',
    11 => 'Transmissió nova',
    12 => 'Seu de l\'Administrador',
    13 => 'Per modificar o borrar una transmissió, apreta sobre el títol de la transmissió a sota. Per crear una transmissió nova, apreta sobre Transmissió nova a dalt.',
    14 => 'Títol',
    15 => 'Tecleja',
    16 => 'Nom de l\'arxiu',
    17 => 'Format',
    18 => 'última actualització',
    19 => 'Habilitat',
    20 => 'Si',
    21 => 'No',
    22 => '<i>(no hi ha transmissions)</i>',
    23 => 'tots els Temes',
    24 => 'Editor de transmissions',
    25 => 'Títol de la transmissió',
    26 => 'Límit',
    27 => 'Duració de les noticies',
    28 => '(0 = sense text, 1 = text complet, altres = limita a aquest nombre de caràcters.)',
    29 => 'Descripció',
    30 => 'Actualització més recent',
    31 => 'Conjunt de caràcters',
    32 => 'Idioma',
    33 => 'Continguts',
    34 => 'Entrades',
    35 => 'Hores',
    36 => 'Selecciona el tipus de transmissió',
    37 => 'Tens com a mínim un plugin instal·lat que afavoreix la sindicació de contingut. A sota hauràs de seleccionar si vols una transmissió de Geeklog o una transmissió d\'un dels plugins.',
    38 => 'Error: Falten camps',
    39 => 'Siusplau, omple el Títol, Descripció i Nom de l\'arxiu de la transmissió.',
    40 => 'Siusplau inclueix el nombre d\'entrades o nombre d\'hores.',
    41 => 'Enllaços',
    42 => 'Esdeveniments'
);

###############################################################################
# confirmation and error messages

$MESSAGE = array(
    1 => "La teva contrassenya s\'ha enviat per correu electrònic i arribarà d\'aquí un moment. Siusplau segueix les indicacions del missatge. Gracies per utilitzar {$_CONF['site_name']}",
    2 => "Gracies per enviar la teva Notícia a {$_CONF['site_name']}. La Notícia es troba en procés d\'aprovació. De ser aprovada, podrà ser llegida per tots els visitants del lloc.",
    3 => "Gracies per enviar el teu Enllaç a {$_CONF['site_name']}. L\'Enllaç es troba en procés d\'aprovació. De ser aprovat, podrà ser vist per tots els visitants del lloc.",
    4 => "Gracies per enviar el teu Esdeveniment a {$_CONF['site_name']}. L\'Esdeveniment es troba en procés d\'aprovació. De ser aprovat, podrà ser vist per tots els visitants del lloc.",
    5 => 'La informació de la teva conta s\'ha guardat satisfactoriament.',
    6 => 'Les teves preferencies s\'han guardat satisfactoriament.',
    7 => 'Les teves preferencies per a Comentaris han sigut guardades satisfactoriament.',
    8 => 'T\'has desconectat satisfactoriament.',
    9 => 'La teva Notícia s\'ha guardat satisfactoriament.',
    10 => 'La Notícia s\'ha borrat satisfactoriament.',
    11 => 'El teu Bloc s\'ha guardat satisfactoriament.',
    12 => 'El Bloc s\'ha borrat satisfactoriament.',
    13 => 'La teva Secció s\'ha guardat satisfactoriament.',
    14 => 'La Secció juntament amb totes les teves Noticies i Blocs s\'han borrat satisfactoriament.',
    15 => 'El teu enllaç s\'ha guardat satisfactoriament.',
    16 => 'L\'enllaç s\'ha borrat satisfactoriament.',
    17 => 'El teu Esdeveniment s\'ha guardat satisfactoriament.',
    18 => 'L\'Esdeveniment s\'ha borrat satisfactoriament.',
    19 => 'La teva Enquesta s\'ha guardat satisfactoriament.',
    20 => 'L\'Enquesta s\'ha borrat satisfactoriament.',
    21 => 'El Nou Usuari s\'ha guardat satisfactoriament.',
    22 => 'L\'Usuari s\'ha borrat satisfactoriament',
    23 => 'Error al guardar l\'Esdeveniment al teu Calendari. No ha sigut processat l\'ID.',
    24 => 'L\'Esdeveniment s\'ha guardat al teu Calendari',
    25 => 'No pots accedir al teu Calendari Personal abans de conectar-te com a usuari',
    26 => 'L\'Esdeveniment s\'ha borrat del teu Calendari Personal',
    27 => 'Missatge enviat satisfactoriament.',
    28 => 'El Plug-in s\'ha guardat satisfactoriament',
    29 => 'Disculpa, els Calendaris Personals no estan habilitats en aquest lloc',
    30 => 'Accés Denegat',
    31 => 'Disculpa, no tens accés a la pàgina d\'administració de Noticies. Aclarem que tot accés sense autorització queda registrat al servidor.',
    32 => 'Disculpa, no tens accés a la pàgina d\'administració de Seccions. Aclarem que tot accés sense autorització queda registrat al servidor.',
    33 => 'Disculpa, no tens accés a la pàgina d\'administració de Blocs. Aclarem que tot accés sense autorització queda registrat al servidor.',
    34 => 'Disculpa, no tens accés a la pàgina d\'administració d\'Enllaços. Aclarem que tot accés sense autorització queda registrat al servidor.',
    35 => 'Disculpa, no tens accés a la pàgina d\'administració d\'Esdeveniments. Aclarem que tot accés sense autorització queda registrat al servidor.',
    36 => 'Disculpa, no tens accés a la pàgina d\'administració d\'Enquestes. Aclarem que tot accés sense autorització queda registrat al servidor.',
    37 => 'Disculpa, no tens accés a la pàgina d\'administració d\'Usuaris. Aclarem que tot accés sense autorització queda registrat al servidor.',
    38 => 'Disculpa, no tens accés a la pàgina d\'administració de Plug-in(s). Aclarem que tot accés sense autorització queda registrat al servidor.',
    39 => 'Disculpa, no tens accés a la pàgina d\'administració de Correu electrònic. Aclarem que tot accés sense autorització queda registrat al servidor.',
    40 => 'Missatge del Sistema',
    41 => 'Disculpa, no tens accés a la pàgina de Substitució de Paraules. Aclarem que tot accés sense autorització queda registrat al servidor.',
    42 => 'La Paraula s\'ha guardat satisfactoriament.',
    43 => 'La Paraula s\'ha borrat satisfactoriament.',
    44 => 'El Plug-In s\'ha instalat satisfactoriament.',
    45 => 'El Plug-In s\'ha borrat satisfactoriament.',
    46 => 'Disculpa, no tens accés a l\'eina de còpia de seguretat de la base de dades. Aclarem que tot accés sense autorització queda registrat al servidor.',
    47 => 'Aquesta funció està disponible sota *nix. Si estàs utilitzant *nix com a sistema operatiu, la teva còpia de visites (cache) s\'ha netejat satisfactoriament. Si estàs sota Windows, hauràs de cercar els arxius adodb_*.php i borrar-los manualment.',
    48 => "Gracies per registrar-te com a membre a {$_CONF['site_name']}. El nostre equip comprobarà la teva solicitut. Si es aprovada, se t\'enviarà la teva Contrassenya a la direcció correu electrònico que ens has proporcionat.",
    49 => 'El teu grup s\'ha guardat satisfactoriament.',
    50 => 'El grup s\'ha borrat satisfactoriament.',
    51 => 'Aquest nom d\'usuari/a ja està en ús. Siusplau, escolleix-ne un altre.',
    52 => 'La direcció facilitada no sembla una direcció vàlida de correu electrònic.',
    53 => 'La teva nova contrassenya s\'ha acceptat. Siusplau, utilitza la nova contrassenya que apareix a sota per ingressar de nou.',
    54 => 'La teva petició de nova contrassenya ha caducat. Siusplau, torna a provar-ho a sota.',
    55 => 'El sistema t\'ha enviat un correu electrònic i t\'arrivarà en breu. Siusplau, segueix les instruccions del missatge per crear una nova contrassenya per la teva conta.',
    56 => 'La direcció de correu electrònic facilitada ja està en ús en una altre conta.',
    57 => 'La teva conta s\'ha borrat satisfactoriament.',
    58 => 'La teva transmissió s\'ha guardat satisfactoriament.',
    59 => 'La teva transmissió s\'ha borrat satisfactoriament.',
    60 => 'El plugin s\'ha actualitzat satisfactoriament',
    61 => 'Plugin %s: marcador de missatge desconegut'
);

###############################################################################

$LANG_ACCESS = array(
    'access' => 'Accés',
    'ownerroot' => 'Propietari/Arrel',
    'group' => 'Grup',
    'readonly' => 'Només-Lectura',
    'accessrights' => 'Drets d\'accés',
    'owner' => 'Propietari',
    'grantgrouplabel' => 'Estableix els drets del Grup',
    'permmsg' => 'NOTA: membres són tots els membres conectats i els usuaris anònims que estiguin al lloc.',
    'securitygroups' => 'Grups de Seguretat',
    'editrootmsg' => "Encara que siguis un/a Administrador/a d\'Usuaris/es, no pots editar un usuari d\'arrel sense abans haber-te donat d\'alta com usuari d\'arrel.  Pots editar a tots els demés usuaris excepte els usuaris d\'arrel. Siusplau, pren nota que qualsevol intent d\'editar il·legalment als usuaris d\'arrel quedarà registrat. Siusplau torna a <a href=\"{$_CONF['site_admin_url']}/users.php\">la pàgina d\'Administració d\'usuaris</a>.",
    'securitygroupsmsg' => 'Marca les caselles dels grups als que vols que pertanyi l\'usuari.',
    'groupeditor' => 'Editor de Grup',
    'description' => 'Descripció',
    'name' => 'Nom',
    'rights' => 'Drets',
    'missingfields' => 'Camps que falten',
    'missingfieldsmsg' => 'Has d\'ingressar un nom i una descripció pel Grup.',
    'groupmanager' => 'Administrador de Grups',
    'newgroupmsg' => 'Per modificar o borrar un grupo selecciona el grup aquí sota. Per crear un grup selecciona \'Nou Grup\' aquí dalt. Pensa que els Grups del Sistema no es poden borrar.',
    'groupname' => 'Nom del Grup',
    'coregroup' => 'Grup del Sistema? ',
    'yes' => 'Si',
    'no' => 'No',
    'corerightsdescr' => "Aquest grup es un Grup de Sistema de {$_CONF['site_name']}, i per tant els seus drts no es poden editar. A continuació es mostra una llista no editable dels drets d\'accés d\'aquest grup.",
    'groupmsg' => 'Els Grups de Segurtat d\'aquest lloc són jeràrquics. A l\'afegir aquest grup a qualsevol dels de sota li estarà donant els mateixos drets que tinguin aquests grups. De ser possible, es recomana utilitzar els grups existents per donar els drets a un nou grup. Si thas de modificar els drets del grup, pots seleccionar-los a la secció anomenada \'Drets\'. Per afegir aquest grup a qualsevol dels de sota simplement marca els grups que vulguis.',
    'coregroupmsg' => "Aquest grup es un Grup de Sistema de {$_CONF['site_name']}, per això els grups que pertanyin a aquest grup no podràn ser editats. A continuació es mostra un llistat (no editable) dels grups als quals pertany aquest grup.",
    'rightsdescr' => 'El dret d\'accés d\'un grupo a algun dels drets que s\'especifiquen a sota es poden donar directament al grup O a un grup diferent del que forma part aquest grup.  Els que veus a sota sense la casella marcada son els drets que s\'han otorgat a aquest grup perque pertany a un altre amb aquest dret. Els drets amb les caselles a sota son els drets que es poden otorgar directament a aquest grup.',
    'lock' => 'Bloqueig',
    'members' => 'Membres',
    'anonymous' => 'Anònim',
    'permissions' => 'Permisos',
    'permissionskey' => 'R = lectura, E = edició, els permisos d\'edició impliquen permisos de lectura',
    'edit' => 'Editar',
    'none' => 'Cap',
    'accessdenied' => 'Accés Denegat',
    'storydenialmsg' => "No tens accés per veure aquesta Notícia. Això pot ser perquè no ets membre de {$_CONF['site_name']}. Siusplau <a href=users.php?mode=new>entra entra com a membre</a> de {$_CONF['site_name']} per tenir accés.",
    'eventdenialmsg' => "No tens accés per veure aquest Esdeveniment. Això pot ser perquè no ets membre de {$_CONF['site_name']}. Siusplau <a href=users.php?mode=new>entra com a membre</a> de {$_CONF['site_name']} per tenir accés.",
    'nogroupsforcoregroup' => 'Aquest grup no pertany a cap dels altres grups',
    'grouphasnorights' => 'Aquest grup no té accés a les funcions d\'administració',
    'newgroup' => 'Nou Grupo',
    'adminhome' => 'Pàgina d\'Administració',
    'save' => 'Guardar',
    'cancel' => 'Cancelar',
    'delete' => 'Borrar',
    'canteditroot' => 'Has intentat editar el grup Root (Arrel) però no pertanys al grup Root, per tant se t\'ha denegat l\'accés.  Siusplau, contacta amb l\'administrador/a del sistema si creus que es tracta d\'un error',
    'listusers' => 'Llistat d\'Usuaris',
    'listthem' => 'llistat',
    'usersingroup' => 'Usuaris al grup %s',
    'usergroupadmin' => 'Administració del grup d\'usuaris',
    'add' => 'Afegir',
    'remove' => 'Borrar',
    'availmembers' => 'Membres disponibles',
    'groupmembers' => 'Membres del grup',
    'canteditgroup' => 'Per editar aquest grup, has de ser un membre del grup. Siusplau, contacta amb l\'administrador del sistema si creus que això es un error.',
    'cantlistgroup' => 'Per veure els membres d\'aquest grup, n\'has de ser membre. Siusplau contacta amb l\'administrador del sistema si creus que això es un error.'
);

###############################################################################
# admin/database.php

$LANG_DB_BACKUP = array(
    'last_ten_backups' => 'Últimes 10 còpies de seguretat',
    'do_backup' => 'Fer una còpia de seguretat',
    'backup_successful' => 'La còpia de seguretat de la base de dades s\'ha realitzat satisfactoriament.',
    'no_backups' => 'No hi ha còpies de seguretat al sistema',
    'db_explanation' => 'Per crear una còpia de seguretat del sistema utilitza el botó de sota',
    'not_found' => "Ruta incorrecta o la utilitat mysqldump no es pot executar.<br>Comprova la definició de <strong>\$_DB_mysqldump_path</strong> al config.php.<br>La variable està definida actualment com: <var>{$_DB_mysqldump_path}</var>",
    'zero_size' => 'Error de la còpia de seguretat: La grandària era de 0 bytes',
    'path_not_found' => "{$_CONF['backup_path']} no existeix o no es una ruta",
    'no_access' => "ERROR: No es pot accedir al directori {$_CONF['backup_path']}.",
    'backup_file' => 'Arcxiu de copies de seguretat',
    'size' => 'Grandària',
    'bytes' => 'Bytes',
    'total_number' => 'Nombre total de copies de seguretat: %d'
);

###############################################################################

$LANG_BUTTONS = array(
    1 => 'Portada',
    2 => 'Contacte',
    3 => 'Col·laboracions',
    4 => 'Enllaços',
    5 => 'Enquestes',
    6 => 'Calendari',
    7 => 'Estadístiques',
    8 => 'Personalització',
    9 => 'Cerca',
    10 => 'Cerca avançada'
);

###############################################################################
# 404.php

$LANG_404 = array(
    1 => 'Error 404',
    2 => 'Vaja, he buscat per tot arreu, però no puc trobar <b>%s</b>.',
    3 => "<p>Ho sentim, però el fitxer que demanes no existeix. Siusplau, consulta la <a href=\"{$_CONF['site_url']}\">pàgina principal</a> o la <a href=\"{$_CONF['site_url']}/search.php\">pàgina de cerca</a> per verure si pots trobar el que has perdut."
);

###############################################################################
# login form

$LANG_LOGIN = array(
    1 => 'es necessita ingressar',
    2 => 'Ho sento, per accedir a aquesta àrea has d\'estar verificat/da com usuari/a.',
    3 => 'ingressa',
    4 => 'Usuari/a nou/va'
);

###############################################################################
# pdfgenerator.php

$LANG_PDF = array(
    1 => 'La funció PDF està inhabilitada',
    2 => 'El document facilitat no s\'ha reproduit. S\'ha rebut el document però no s\'ha processat. Siusplau, assegura\'t de que només s\'enviin documents en format html amb l\'estàndar xHTML. Siusplau, pensa que els documents molt complexes en html és possible que no es reprodueixin correctament o que no apareguin. El document resultant del teu intent té 0 bytes d\'extensió, i ha sigut borrat. Si no estàs segur/a de que el teu document es reprodueixi bé, siusplau, torna a enviar-lo.',
    3 => 'Error desconegut durant la generació de PDF',
    4 => "No has donat dades de la pàgina o vols utilitzar l\'eina de generació ad-hoc de PDF. Si creus que estàs rebent aquesta pàgina per error, contacta amb l\'administrador del sistema. Sinó, pots utilitzar el formulari que hi ha a sota per generar PDFs.",
    5 => 'Cargant el teu document.',
    6 => 'Siusplau, espera mentres es carrega el teu document.',
    7 => 'Pots apretar el botó dret del ratolí sobre el botó de sota i escollir \'save target...\' o \'save link location...\' per guardar una còpia del teu document.',
    8 => "La ruta donada per l\'arxiu de configuració a l\'HTMLDoc binari no és vàlida o aquest sistema no el pot executar.  Siusplau contacta amb l\'administrador del sistema si aquest problema continua.",
    9 => 'Creador de PDF',
    10 => "Aquesta es l\'eina ad-hoc de creació de PDF. Intentarà convertir qualsevol URL que li donguis en un PDF.  Siusplau, pensa que algunes pàgines de la xarxa (Web) no es generaràn correctament amb aquesta funció.  Això és una limitació de l\'eina generadora d\'HTMLDoc PDF i aquests errors no haurien de ser enviats a l\'administrador d\'aquest lloc",
    11 => 'URL',
    12 => 'Crea un PDF!',
    13 => 'La configuració PHP en aquest servidor no permet que les URL s\'utilitzin amb la instrucció fopen.  L\'administrador del sistema ha d\'editar l\'arxiu php.ini i que estigui conectat allow_url_fopen',
    14 => 'El PDF que has solicitat o no existeix o has intentat accedir a un arxiu ilegalment.'
);

?>
