<?php

###############################################################################
# romanian.php 
# This is the romanian language page for GeekLog!
#
# Copyright (C) 2003 dan gheorghitza
# dangk12@yahoo.com
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

$LANG_CHARSET = "iso-8859-2";

###############################################################################
# Array Format:
# $LANGXX[YY]:        $LANG - variable name
#                          XX - file id number
#                        YY - phrase id number
###############################################################################

###############################################################################
# USER PHRASES - These are file phrases used in end user scripts
###############################################################################

###############################################################################
# common.php

$LANG01 = array(
        1 => "Scris de:",
        2 => "Citeste mai multe ...",
        3 => "comentarii",
        4 => "Editeaza",
        5 => "Sondaj",
        6 => "Rezultate",
        7 => "Rezultate Sondaj",
        8 => "voturi",
        9 => "Admin:",
        10 => "Trimiteri",
        11 => "Stiri",
        12 => "Block-uri",
        13 => "Sectiuni",
        14 => "Link-uri",
        15 => "Evenimente",
        16 => "Sondaje",
        17 => "Membri",
        18 => "Interogare SQL",
        19 => "Iesire/Deconectare",
        20 => "Membru Info:",
        21 => "Nume",
        22 => "Membru ID",
        23 => "Nivel Securitate",
        24 => "Anonim",
        25 => "Raspunde",
        26 => "Urmatoarele comentarii apartin celor care le-au trimis pe sit. Acest sit nu raspunde pentru continutul acestora.",
        27 => "Cel mai recent",
        28 => "Sterge",
        29 => "Nu sunt comentarii.",
        30 => "Stiri Vechi",
        31 => "Tag-uri HTML permise:",
        32 => "Eroare, nume Membru/username invalid",
        33 => "Eroare, nu se poate scrie in fisierul de log",
        34 => "Eroare",
        35 => "Iesire/Deconectare",
        36 => "pe",
        37 => "Nu sunt stiri ale vizitatorilor",
        38 => "",
        39 => "Actualizeaza",
        40 => "",
        41 => "Vizitatori",
        42 => "Scris de:",
        43 => "Raspunde la",
        44 => "Parinte",
        45 => "MySQL Eroare Numar",
        46 => "MySQL Eroare Mesaj",
        47 => "Membru Info",
        48 => "Informatii Cont",
        49 => "Preferinte",
        50 => "Eroare in codul SQL",
        51 => "ajutor",
        52 => "Nou",
        53 => "Admin Home",
        54 => "Nu se poate deschide fisierul.",
        55 => "Eroare la",
        56 => "Voteaza",
        57 => "Parola",
        58 => "Intra/Login",
        59 => "Nu ai un cont inca? Inregistreaza-te ca <a href=\"{$_CONF['site_url']}/users.php?mode=new\">Nou Membru</a>",
        60 => "Adauga un comentariu",
        61 => "Creaza Nou Cont",
        62 => "cuvinte",
        63 => "Preferinte Comentarii",
        64 => "Trimite stirea unui prieten",
        65 => "Vezi Versiunea pentru Imprimanta",
        66 => "Calendarul meu",
        67 => "Bine ati venit ",
        68 => "home",
        69 => "contact",
        70 => "cauta",
        71 => "contribuie",
        72 => "resurse web",
        73 => "sondaje vechi",
        74 => "calendar",
        75 => "cautare avansata",
        76 => "statistici sit",
        77 => "Plugin-uri",
        78 => "Evenimente recente",
        79 => "Ce mai e Nou",
        80 => "stiri in ultimele",
        81 => "stire in ultimele",
        82 => "ore",
        83 => "COMENTARII",
        84 => "LINK-URI",
        85 => "ultimele 48 ore",
        86 => "Nu sunt comentarii noi",
        87 => "ultimele 2 saptamani",
        88 => "Nu sunt link-uri recente",
        89 => "Nu sunt evenimente recente",
        90 => "Home",
        91 => "Pagina creata in",
        92 => "secunde",
        93 => "Copyright",
        94 => "",
        95 => "Powered By",
        96 => "Grupuri",
              97 => "Lista Cuvinte",
        98 => "Plugin-uri",
        99 => "STIRI",
    100 => "Nu sunt stiri noi",
    101 => 'Evenimente tale',
    102 => 'Evenimente in site',
    103 => 'DB Backup',
    104 => 'de',
    105 => 'Mail Membri',
    106 => 'Vizualizari',
    107 => 'GL Version Test',
    108 => 'Sterge Cache'
);

###############################################################################
# calendar.php

$LANG02 = array(
        1 => "Calendar de Evenimente",
        2 => "Ne pare rau, nu sunt evenimente de vizualizat.",
        3 => "Cand",
        4 => "Unde",
        5 => "Descriere",
        6 => "Trimite Eveniment",
        7 => "Evenimente recente",
        8 => 'Adaugand acest eveniment la calendaarul tau se pot accesa rapid evenimentele care te intereseaza cu un click pe "Calendarul meu" din sectiunea Membru Info',
        9 => "Adauga la Calendarul meu",
        10 => "Sterge din Calendarul meu",
        11 => "Se adauga Eveniment in Calendarul lui {$_USER['username']}",
        12 => "Eveniment",
        13 => "Incepe",
        14 => "Se termina",
        15 => "Inapoi la Calendar"
);

###############################################################################
# comment.php

$LANG03 = array(
        1 => "Trimite un Comentariu",
        2 => "Mod trimitere",
        3 => "Iesire",
        4 => "Inregistrare",
        5 => "Membru",
        6 => "Intrati ca membru/utilizator inregistrat pentru a trimite comentarii. Pentru inregistrare completati miniformularul de mai jos.",
        7 => "Ultimul tau comentariu a fost acum",
        8 => " secunde in urma.  Asteptati cel putin {$_CONF["commentspeedlimit"]} secunde pentru a introduce un nou comentariu",
        9 => "Comentariu",
        10 => '',
        11 => "Trimite Comentariu",
        12 => "E necesar sa completati in Titlu si Comentariu pentru a putea trimite comentariul.",
        13 => "Informatia ta",
        14 => "Previzualizeaza",
        15 => "",
        16 => "Titlu",
        17 => "Eroare",
        18 => 'Material Important',
        19 => 'Va rugam sa continuati a trimite pe acest subiect.',
        20 => 'Incearca sa raspunzi la comentariile altora in loc de a introduce comentarii noi.',
        21 => 'Citeste mesajele altora inainte de a trimite pentru a evita dublarea unui mesaj',
        22 => 'Alege sectiunea potrivita pentru mesajul tau.',
        23 => 'Adresa ta email nu va fi facuta publica.',
        24 => 'Vizitator Anonim'
);

###############################################################################
# users.php

$LANG04 = array(
        1 => "Profil Membru pentru",
        2 => "Nume membru",
        3 => "Nume",
        4 => "Parola",
        5 => "Email",
        6 => "Pagina web",
        7 => "Bio",
        8 => "Cheie PGP",
        9 => "Salveaza modificarile",
        10 => "Ultimele 10 comentarii pentru utilizatorul",
        11 => "Nu sunt comentarii",
        12 => "Preferinte membru pentru",
        13 => "Email Nightly Digest",
        14 => "Aceasta parola este generata aleatoriu. Este recomandat sa schimbi parola imediat. Pentru aceasta va logati si dati clic pe Informatii Cont din meniul Membru Info",
        15 => "Contul tau {$_CONF["site_name"]} a fost creat cu succes. Pentru a-l utiliza e necesar sa va logati utilizand informatiile de mai jos.  Este indicat sa va salvati acest mail.",
        16 => "Informatii Cont",
        17 => "Contul nu exista",
        18 => "Adresa email introdusa nu pare a vi valida (nume@server.com)",
        19 => "Nume Membru sau adresa email introduse exista deja.",
        20 => "Adresa email introdusa nu pare a vi valida (nume@server.com)",
        21 => "Eroare",
        22 => "Inregistrare la {$_CONF['site_name']}!",
        23 => "Crearea unui cont membru prin inregistrare va ofera toate beneficiile unui membru la {$_CONF['site_name']} si va permite sa trimiteti comentarii sau stiri/texte cu numele ales. Daca nu aveti un cont creat, puteti trimite texte doar ca anonim. Va reamintim ca adresa email nu va fi disponibila <b><i>niciodata</i></b> spre vizualizare publica.",
        24 => "Parola ta va fi trimisa la adresa de email introdusa.",
        25 => "Ati uitat parola?",
        26 => "Introduceti numele de utilizator/membru si dati clic pe Trimite Parola si o parola generata aleatoriu va fi trimisa la adresa de email introdusa.",
        27 => "Inregistrati-va!",
        28 => "Trimite Parola",
        29 => "iesit din",
        30 => "intrat din",
        31 => "Optiunea aleasa cere sa intrati ca membru/utilizator inregistrat",
        32 => "Semnatura",
        33 => "Niciodata disponibil spre vizualizare publica",
        34 => "Acesta este numele tau adevarat",
        35 => "Introduceti parola pentru modificare",
        36 => "Incepe cu http://",
        37 => "Aplicat la comentariile tale",
        38 => "Este despre tine! Oricine poate citi aceasta",
        39 => "Cheia publica PGP pentru date private",
        40 => "Nu exista iconite pentru subiecte",
        41 => "Moderati!",
        42 => "Format Data",
        43 => "Maxim stiri",
        44 => "Fara casute",
        45 => "Arata preferinte pentru",
        46 => "Exclude obiecte pentru",
        47 => "Configurare Casuta stiri pentru",
        48 => "Subiecte",
        49 => "Nu sunt iconite in stiri",
        50 => "Deselecteaza aceasta daca nu sunteti interesat",
        51 => "Doar stiri",
        52 => "Implicit este",
        53 => "Primiti inainte stirile zilei urmatoare",
        54 => "Selectati casutele pentru subiectele si autorii pe care nu-i vreti.",
        55 => "Daca nu selectati nimic, inseamna ca sunteti de acord cu selectarea implicita (optiunile ingrosate). Sau selectati doar optiunile dorite si selectarea implicita va fi ignorata.",
        56 => "Autori",
        57 => "Mod vizualizare",
        58 => "Ordine Sortare",
        59 => "Limita Comentariu",
        60 => "Cum doriti sa fie vizualizate comentariile?",
        61 => "Primul - cel mai nou sau cel mai vechi?",
        62 => "Implicit este 100",
        63 => "Parola a fost trimisa prin e-mail si trebuie sa o primiti imediat. Va rugam sa urmati indicatiile din mesaj si va multumim pentru utilizarea " . $_CONF["site_name"],
        64 => "Preferinte Comentarii pentru",
        65 => "Intrare/Login din nou ca membru ",
        66 => "Probabil ati introdus gresit datele. Va rugam sa le reintroduceti din nou mai jos. Sunteti un <a href=\"{$_CONF['site_url']}/users.php?mode=new\">nou utilizator</a>?",
        67 => "Membru din",
        68 => "Salvati-mi datele pentru",
        69 => "Pentru cat timp doriti sa fie salvate datele personale dupa intrare/login?",
        70 => "Personalizati design-ul si continutul {$_CONF['site_name']}",
        71 => "Una din optiunile paginii {$_CONF['site_name']} este este ca puteti sa va alegeti ce va contine cum va arata pagina aceasta.  Pentru a beneficia de acestea e necesar, mai intai, sa va <a href=\"{$_CONF['site_url']}/users.php?mode=new\">inregistrati</a> with {$_CONF['site_name']}.  Sunteti deja membru/utilizator inregistrat? Atunci folositi modulul din stanga pentru a va loga/intra ca membru!",
    72 => "Model pagina",
    73 => "Limba",
    74 => "Schimba modelul paginii dupa preferinte!",
    75 => "Subiect de trimis prin email pentru",
    76 => "Daca selectati un subiect din lista de mai jos veti primi fiecare stire/text cu subiectul respectiv la sfarsitul fiecarei zile. Alegeti doar subiectele ce va intereseaza!",
    77 => "Poza",
    78 => "Adauga o poza personala!",
    79 => "Sterge imaginea",
    80 => "Intra",
    81 => "Trimite Email",
    82 => 'Ultimele 10 stiri pentru utilizatorul',
    83 => 'Statistici texte trimise de utilizatorul',
    84 => 'Total numar de articole:',
    85 => 'Total numar de comentarii:',
    86 => 'Cauta toate textele trimise de'
);

###############################################################################
# index.php

$LANG05 = array(
        1 => "Nu sunt stiri de vizualizat.",
        2 => "Nu sunt stiri de vizualizat. Pentru ca nu exista stiri noi sau preferintele tale sunt prea restrictive.",
        3 => " pentru sectiunea $topic",
        4 => "Stirea zilei",
        5 => "Inainte",
        6 => "Inapoi"
);

###############################################################################
# links.php

$LANG06 = array(
        1 => "Resurse web",
        2 => "Nu exista resurse de vizualizat.",
        3 => "Propune un Link"
);

###############################################################################
# pollbooth.php

$LANG07 = array(
        1 => "Vot salvat",
        2 => "Votul dvs. pentru sondaj a fost salvat. Va multumim!",
        3 => "Voteaza",
        4 => "Sondaje",
        5 => "Voturi"
);

###############################################################################
# profiles.php

$LANG08 = array(
        1 => "A fost o eroare la trimiterea mesajului. Va rugam sa incercati din nou.",
        2 => "Mesajul a fost trimis cu succes.",
        3 => "Verificati daca adresa de email introdusa in campul Raspunde este valida.",
        4 => "Va rugam sa introduceti datele pentru campurile Numele tau, Raspunde, Subiect si Mesaj.",
        5 => "Eroare. Nu exista utilizatorul respectiv.",
        6 => "A fost o eroare.",
        7 => "Profil membru pentru",
        8 => "Nume membru",
        9 => "Membru URL/adresa web",
        10 => "Trimite email la",
        11 => "Numele tau:",
        12 => "Raspunde:",
        13 => "Subiect:",
        14 => "Mesaj:",
        15 => "HTML nu va fi interpretat.",
        16 => "Trimite Mesaj",
        17 => "Trimite unui prieten",
        18 => "Nume prieten",
        19 => "Adresa Email prieten",
        20 => "Numele tau",
        21 => "Adresa ta de Email",
        22 => "Toate campurile sunt obligatorii",
        23 => "Acest mesaj a fost trimis de $from la $fromemail deoarece a crezut ca ai putea fi interesat de acest text de la {$_CONF["site_url"]}.  Acesta nu este SPAM si adresa dvs. de email nu a fost salvata sau stocata pentru folosire ulterioara.",
        24 => "Comentariu pentru aceasta stire la",
        25 => "Trebuie sa fiti membru/utilizator inregistrat pentru a folosi aceasta facilitate.  E nevoie de inregistrare pentru a preveni o folosire incorecta a sistemului",
        26 => "Acest formular va permite sa trimiteti un email unui membru selectat.   Toate campurile trebuie completate.",
        27 => "Mesaj scurt",
        28 => "$from a scris: $shortmsg",
    29 => "Acesta este sumarul zilnic de la {$_CONF['site_name']} pentru ",
    30 => " Buletin informativ zilnic pentru ",
    31 => "Titlu",
    32 => "Data",
    33 => "Citeste tot textul la",
    34 => "Final mesaj"
);

###############################################################################
# search.php

$LANG09 = array(
        1 => "Cautare avansata",
        2 => "Cuvinte cheie",
        3 => "Subiect",
        4 => "Toate",
        5 => "Tip",
        6 => "stiri",
        7 => "comentarii",
        8 => "Autori",
        9 => "Toate",
        10 => "Cauta",
        11 => "Rezultat cautare",
        12 => "rezultate",
        13 => "Rezultate cautare: Niciun rezultat",
        14 => "Niciun rezultat pentru cautarea ta dupa",
        15 => "Incercati din nou.",
        16 => "Titlu",
        17 => "Data",
        18 => "Autor",
        19 => "Cauta in toata baza de date a {$_CONF["site_name"]} prin stirile curente sau vechi",
        20 => "Data",
        21 => "la",
        22 => "(Format pentru Data AAAA-LL-ZZ)",
        23 => "Accesari",
        24 => "Gasit",
        25 => "rezultate pentru",
        26 => "subiecte/items in",
        27 => "secunde",
    28 => 'Nici o stire sau comentariu rezultate in urma cautarii',
    29 => 'Rezultat Stiri si Comentarii',
    30 => 'Nici un link rezultat in urma cautarii',
    31 => 'Acest plug-in nu are rezultate',
    32 => 'Eveniment',
    33 => 'URL',
    34 => 'Loc',
    35 => 'Fiecare zi',
    36 => 'Nici un Eveniment rezultat in urma cautarii',
    37 => 'Rezultate Evenimente',
    38 => 'Rezultate Link-uri',
    39 => 'Link-uri',
    40 => 'Evenimente',
    41 => 'Cuvantul cautat trebuia sa aiba cel putin 3 litere.',
    42 => 'Va rugam folositi un format pentru data de tipul AAAA-LL-ZZ (an-luna-zi).'
);

###############################################################################
# stats.php

$LANG10 = array(
        1 => "Statistici Site",
        2 => "Total Accesari Sistem",
        3 => "Stiri(comentarii) in Sistem",
        4 => "Sondaje(Raspunsuri) in Sistem",
        5 => "Link-uri(Clicks) in Sistem",
        6 => "Evenimente in Sistem",
        7 => "Top 10 Stiri vizualizate",
        8 => "Stire Titlu",
        9 => "Vizualizari",
        10 => "Nu sunt siri pe sit sau nu au fost vizualizate.",
        11 => "Top 10 stiri comentate",
        12 => "comentarii",
        13 => "Nu sunt siri pe sit sau nu exista comentarii trimise pentru acestea.",
        14 => "Top 10 Sondaje",
        15 => "Intrebare Sondaj",
        16 => "Voturi",
        17 => "Nu sunt sondaje pe sit sau nu exista inca voturi pentru acestea.",
        18 => "Top 10 Link-uri",
        19 => "Link-uri",
        20 => "Accesari",
        21 => "Nu sunt link-uri pe sit sau nu au fost inca accesate.",
        22 => "Top 10 stiri trimise altora prin email",
        23 => "Adrese Email",
        24 => "Nu sunt stiri trimise altora prin email."
);

###############################################################################
# article.php

$LANG11 = array(
        1 => "Link-uri inrudite",
        2 => "Trimite unui prieten",
        3 => "Pagina in format pentru imprimanta",
        4 => "Optiuni Stire"
);

###############################################################################
# submit.php

$LANG12 = array(
        1 => "Pentru a trimite o $type e necesar sa intri ca membru/utilizator inregistrat.",
        2 => "Intra/Login",
        3 => "Nou membru",
        4 => "Anunta un Eveniment",
        5 => "Trimite un Link",
        6 => "Trimite o stire",
        7 => "Inregistrarea e necesara",
        8 => "Trimite",
        9 => "Cand trimiteti un text pentru a fi introdus in aceasta pagina web, va rugam sa urmati sugestiile de mai jos: <ul><li>Completati toate campurile care sunt obligatorii<li>Introduceti informatii complete si corecte<li>Verificati adresele web/URL</ul>",
        10 => "Titlu",
        11 => "Link",
        12 => "Data incepere",
        13 => "Data terminare",
        14 => "Loc",
        15 => "Descriere",
        16 => "Pentru altele, specificati care",
        17 => "Categorie",
        18 => "Alta",
        19 => "Citeste mai inainte",
        20 => "Eroare: Categoria inexistenta",
        21 => "Cand selectati \"Alta\" varugam sa introduceti si un nume",
        22 => "Eroare: Date necompletate",
        23 => "Va rugam sa completati toate datele in formular. Sunt necesare toate.",
        24 => "Datele au fost salvate",
        25 => "$type de inregistrare a fost salvat cu succes.",
        26 => "Limita Viteza",
        27 => "Membru",
        28 => "Subiect",
        29 => "Stire",
        30 => "Ultima trimitere a fost acum ",
        31 => " secunde.  Asteptati {$_CONF["speedlimit"]} secunde pentru a trimite iar.",
        32 => "Previzualizeaza",
        33 => "Previzualizare Stire",
        34 => "Iesire/Logout",
        35 => "Tag-uri HTML nu sunt permise",
        36 => "Mod trimitere",
        37 => "Anuntand un eveniment la {$_CONF["site_name"]}, evenimentul va fi introdus in Calendarul Master de unde alti membri il pot adauga in calendarul lor propriu. Aceasta facilitate <b>NOT</b> este pentru a stoca evenimente personale precum ziua de nastere si aniversari.<br><br>Odata introdus un eveniment, acesta va fi verificat si daca va fi aprobat, va aparea in Calendar Master.",
    38 => "Adauga Eveniment la",
    39 => "Calendar Master",
    40 => "Calendar Personal",
    41 => "Ora terminare",
    42 => "Ora incepere",
    43 => "Eveniment zilnic",
    44 => 'Adresa 1',
    45 => 'Adresa 2',
    46 => 'Oras',
    47 => 'Stat',
    48 => 'Zip Cod',
    49 => 'Eveniment Tip',
    50 => 'Modifica Tipuri de Evenimente',
    51 => 'Locul',
    52 => 'Sterge',
    53 => 'Inregistrare'
);


###############################################################################
# ADMIN PHRASES - These are file phrases used in end admin scripts
###############################################################################

###############################################################################
# auth.inc.php

$LANG20 = array(
        1 => "Autenficarea necesara",
        2 => "Acces refuzat! Informatii introduse incorect",
        3 => "Parola gresita pentru utilizator",
        4 => "Membru:",
        5 => "Parola:",
        6 => "Accesul la zona de administrare a sit-ului este inregistrat si verificat periodic.<br>Aceasta zona este doar pentru persoanele autorizate.",
        7 => "intra/login"
);

###############################################################################
# block.php

$LANG21 = array(
        1 => "Insufficient Admin Rights",
        2 => "You do not have the necessary rights to edit this block.",
        3 => "Block Editor",
        4 => "",
        5 => "Block Titlu",
        6 => "Topic",
        7 => "Toate",
        8 => "Block Security Level",
        9 => "Block Order",
        10 => "Block Tip",
        11 => "Portal Block",
        12 => "Normal Block",
        13 => "Portal Block Options",
        14 => "RDF URL",
        15 => "Ultimul RDF Update",
        16 => "Normal Block Options",
        17 => "Block Content",
        18 => "Please fill in the Block Titlu, Security Level and Content fields",
        19 => "Block Manager",
        20 => "Block Titlu",
        21 => "Block SecLev",
        22 => "Block Tip",
        23 => "Block Order",
        24 => "Block Topic",
        25 => "To modify or sterge a block, click on that block below.  To create a new block click on new block above.",
        26 => "Layout Block",
        27 => "PHP Block",
    28 => "PHP Block Options",
    29 => "Block Function",
    30 => "If you would like to have one of your blocks use PHP code, enter the name of the function above.  Your function name must start with the prefix \"phpblock_\" (e.g. phpblock_getweather).  If it does not have this prefix, your function will NOT be called.  We do this to keep people who may have hacked your Geeklog installation from putting arbitrary function calls that may be harmful to your system.  Be sure not to put empty parenthisis \"()\" after your function name.  Finally, it is recommended that you put all your PHP Block code in /path/to/geeklog/system/lib-custom.php.  That will allow the code to stay with you even when you upgrade to a newer version of Geeklog.",
    31 => 'Error in PHP Block.  Function, $function, does not exist.',
    32 => "Error Missing Field(s)",
    33 => "You must enter the URL to the .rdf file for portal blocks",
    34 => "You must enter the Titlu and the function for PHP blocks",
    35 => "You must enter the Titlu and the content for normal blocks",
    36 => "You must enter the content for layout blocks",
    37 => "Bad PHP block function name",
    38 => "Functions for PHP Blocks must have the prefix 'phpblock_' (e.g. phpblock_getweather).  The 'phpblock_' prefix is required for security reasons to prevent the execution of arbitrary code.",
        39 => "Side",
        40 => "Stanga",
        41 => "Dreapta",
        42 => "You must enter the blockorder and security level for Geeklog default blocks",
        43 => "Homepage Only",
        44 => "Access Denied",
        45 => "You are trying to access a block that you don't have rights to.  This attempt has been logged. Please <a href=\"{$_CONF["site_admin_url"]}/block.php\">go back to the block administration screen</a>.",
        46 => 'Bloc nou',
        47 => 'Admin Home',
    48 => 'Nume Bloc',
    49 => ' (no spaces and must be unique)',
    50 => 'Help File URL',
    51 => 'include http://',
    52 => 'If you leave this blank the help icon for this block will not be displayed',
    53 => 'Enabled',
    54 => 'salveaza',
    55 => 'anuleaza',
    56 => 'sterge'
);

###############################################################################
# event.php

$LANG22 = array(
        1 => "Editor Evenimente",
        2 => "",
        3 => "Titlu Eveniment",
        4 => "Eveniment URL",
        5 => "Eveniment Start Date",
        6 => "Eveniment End Date",
        7 => "Eveniment Location",
        8 => "Eveniment Descriere",
        9 => "(include http://)",
        10 => "You must provide the dates/times, descriere and Eveniment location!",
        11 => "Eveniment Manager",
        12 => "To modify or sterge a Eveniment, click on that Eveniment below.  To create a new Eveniment click on new Eveniment above.",
        13 => "Eveniment Titlu",
        14 => "Start Date",
        15 => "End Date",
        16 => "Access Denied",
        17 => "You are trying to access an Eveniment that you don't have rights to.  This attempt has been logged. Please <a href=\"{$_CONF["site_admin_url"]}/event.php\">go back to the Eveniment administration screen</a>.",
        18 => 'Nou Eveniment',
        19 => 'Admin Home',
    20 => 'salveaza',
    21 => 'anuleaza',
    22 => 'sterge'
);

###############################################################################
# link.php

$LANG23 = array(
        1 => "Link Editor",
        2 => "",
        3 => "Titlu Link",
        4 => "Link URL",
        5 => "Categorie",
        6 => "(include http://)",
        7 => "Altele",
        8 => "Accesari Link",
        9 => "Descriere Link",
        10 => "E necesar sa introduceti un Titlu pentru link, Adresa/URL si Descriere.",
        11 => "Administrare Link-uri",
        12 => "Pentru a modifica sau sterge un link dati clic pe butonul de mai jos.  Pentru a crea un nou link dati clic pe butonul Link Nou de mai sus.",
        13 => "Titlu Link",
        14 => "Categorie Link",
        15 => "Adresa web/URL Link ",
        16 => "Acces interzis",
        17 => "You are trying to access a link that you don't have rights to.  This attempt has been logged. Please <a href=\"{$_CONF["site_admin_url"]}/link.php\">go back to the link administration screen</a>.",
        18 => 'Link Nou',
        19 => 'Admin Home',
        20 => 'Pentru altele, specificati',
    21 => 'salveaza',
    22 => 'anuleaza',
    23 => 'sterge'
);

###############################################################################
# story.php

$LANG24 = array(
        1 => "Stiri precedente",
        2 => "Stiri urmatoare",
        3 => "Mod",
        4 => "Mod trimitere",
        5 => "Editor Stiri",
        6 => "Nu sunt stiri in sistem",
        7 => "Autor",
        8 => "salveaza",
        9 => "previzualizeaza",
        10 => "anuleaza",
        11 => "sterge",
        12 => "",
        13 => "Titlu",
        14 => "Subiect",
        15 => "Data",
        16 => "Intro Text",
        17 => "Body Text",
        18 => "Accesari",
        19 => "comentarii",
        20 => "",
        21 => "",
        22 => "Stire List",
        23 => "To modify or sterge o stire, click on that Stire's number below. To view o stire, click on the Titlu of the Stire you wish to view. To create a new Stire click on new Stire above.",
        24 => "",
        25 => "",
        26 => "Previzualizare Stire",
        27 => "",
        28 => "",
        29 => "",
        30 => "",
        31 => "Please fill in the Author, Titlu and Intro Text fields",
        32 => "Featured",
        33 => "There can only be one featured stire",
        34 => "Draft",
        35 => "Da",
        36 => "Nu",
        37 => "Scrise de",
        38 => "Mai mult despre",
        39 => "Emails",
        40 => "Acces interzis",
        41 => "You are trying to access o stire that you don't have rights to.  This attempt has been logged.  You may view the article in read-only below. Please <a href=\"{$_CONF["site_admin_url"]}/story.php\">go back to the stire administration screen</a> when you are done.",
        42 => "You are trying to access o stire that you don't have rights to.  This attempt has been logged.  Please <a href=\"{$_CONF["site_admin_url"]}/story.php\">go back to the stire administration screen</a>.",
        43 => 'New Stire',
        44 => 'Admin Home',
        45 => 'Access',
    46 => '<b>NOTE:</b> if you modify this date to be in the future, this article will not be published until that date.  That also means the stire will not be included in your RDF headline feed and it will be ignored by the search and statistics pages.',
    47 => 'Images',
    48 => 'image',
    49 => 'dreapta',
    50 => 'stanga',
    51 => 'To add one of the images you are attaching to this article you need to insert specially formatted text.  The specially formatted text is [imageX], [imageX_right] or [imageX_left] where X is the number of the image you have attached.  NOTE: You must use the images you attach.  If you do not you will be unable to save your stire.<BR><P><B>PREVIEWING</B>: Previewing o stire with images attached is best done by saving the article as a draft INSTEAD OF hitting the preview button.  Use the preview button only when images are not attached.',
    52 => 'Sterge',
    53 => 'was not used.  You must include this image in the intro or body before you can save your changes',
    54 => 'Attached Images Not Used',
    55 => 'The following errors occured while trying to save your stire.  Please correct these errors before saving',
    56 => 'Show Topic Icon'
);

###############################################################################
# poll.php

$LANG25 = array(
        1 => "Mod",
        2 => "",
        3 => "Sondaj Creat",
        4 => "Sondaj $qid salvat",
        5 => "Editare Sondaj",
        6 => "Sondaj ID",
        7 => "(do not use spaces)",
        8 => "Appears on Homepage",
        9 => "Intrebare",
        10 => "Raspunsuri / Voturi",
        11 => "There was an error getting Sondaj answer data about the Sondaj $qid",
        12 => "There was an error getting Sondaj intrebare data about the Sondaj $qid",
        13 => "Create Sondaj",
        14 => "salveaza",
        15 => "anuleaza",
        16 => "sterge",
        17 => "",
        18 => "Lista Sondaje",
        19 => "To modify or sterge a Sondaj, click on that Sondaj.  To create a new Sondaj click on new Sondaj above.",
        20 => "Voturi",
        21 => "Access Denied",
        22 => "You are trying to access a Sondaj that you don't have rights to.  This attempt has been logged. Please <a href=\"{$_CONF["site_admin_url"]}/poll.php\">go back to the Sondaj administration screen</a>.",
        23 => 'New Sondaj',
        24 => 'Admin Home',
        25 => 'Da',
        26 => 'Nu'
);

###############################################################################
# topic.php

$LANG27 = array(
        1 => "Topic Editor",
        2 => "Topic ID",
        3 => "Topic Name",
        4 => "Topic Image",
        5 => "(do not use spaces)",
        6 => "Deleting a topic sterges all stiri and blocks associated with it",
        7 => "Please fill in the Topic ID and Topic Name fields",
        8 => "Topic Manager",
        9 => "To modify or delete a topic, click on that topic.  To create a new topic click the new topic button to the left. You will find your access level for each topic in parenthesis",
        10=> "Sort Order",
        11 => "Stiri/Page",
        12 => "Access Denied",
        13 => "You are trying to access a topic that you don't have rights to.  This attempt has been logged. Please <a href=\"{$_CONF["site_admin_url"]}/topic.php\">go back to the topic administration screen</a>.",
        14 => "Sort Method",
        15 => "alphabetical",
        16 => "default is",
        17 => "New Topic",
        18 => "Admin Home",
    19 => 'save',
    20 => 'anuleaza',
    21 => 'sterge'
);

###############################################################################
# user.php

$LANG28 = array(
        1 => "Editor Utilizatori",
        2 => "Membru ID",
        3 => "Nume membru",
        4 => "Nume",
        5 => "Parola",
        6 => "Nivel Securitate",
        7 => "Adresa Email",
        8 => "Pagina principala",
        9 => "(nu utilizati spatii)",
        10 => "Va rugam, completati campurile Membru, Nume, Nivel Securitate si  Adresa Email",
        11 => "Administrare Ulilizatori",
        12 => "Pentru a modifica sau sterge un membru, dati clic pe un utilizator de mai jos.  Pentru a crea un nou utilizator dati clic pe butonul de creare nou utilizator din stanga. Puteti realiza cautari simple introducand utilizator, adresa de email sau nume (ex. *ion*, *.it sau *.ro) in formularul urmator.",
        13 => "SecLev",
        14 => "Reg. Data",
        15 => 'Membru Nou',
        16 => 'Admin Home',
        17 => 'Schimba parola',
        18 => 'anuleaza',
        19 => 'sterge',
        20 => 'salveaza',
        18 => 'anuleaza',
        19 => 'sterge',
        20 => 'salveaza',
    21 => 'Numele Membru ales exista deja.',
    22 => 'Eroare',
    23 => 'Batch Add',
    24 => 'Batch Import of Users',
    25 => 'You can import a batch of users into Geeklog.  The import file must a tab-delimited text file and must have the fields in the following order: full name, Membru, email address.  Each user you import will be emailed with a random password.  You must have one user entered per line.  Failure to follow these instructions will cause problems that may require manual work so double check your entries!',
    26 => 'Cauta',
    27 => 'Limita Rezultate',
    28 => 'Check here to sterge this picture',
    29 => 'Cale',
    30 => 'Importa',
    31 => 'Membri noi',
    32 => 'Done processing. Imported $successes and encountered $failures failures',
    33 => 'trimite',
    34 => 'Eroare: trebuie specificat un fisieer pentru incarcat pe server/upload.'
);


###############################################################################
# moderation.php

$LANG29 = array(
    1 => "Approve",
    2 => "sterge",
    3 => "Edit",
    4 => 'Profile',
    10 => "Titlu",
    11 => "Start Date",
    12 => "URL",
    13 => "Category",
    14 => "Date",
    15 => "Topic",
    16 => 'User name',
    17 => 'Full name',
    18 => 'Email',
    34 => "Command and Control",
    35 => "Stire Submissions",
    36 => "Link Submissions",
    37 => "Eveniment Submissions",
    38 => "Trimite",
    39 => "There are no submissions to moderate at this time",
    40 => "User Submissions"
);

###############################################################################
# calendar.php

$LANG30 = array(
        1 => "Duminica",
        2 => "Luni",
        3 => "Marti",
        4 => "Miercuri",
        5 => "Joi",
        6 => "Vineri",
        7 => "Sambata",
        8 => "Adauga Eveniment",
        9 => "Geeklog Eveniment",
        10 => "Evenimente pentru",
        11 => "Calendar Master",
        12 => "Calendarul meu",
        13 => "Ianuarie",
        14 => "Februarie",
        15 => "Martie",
        16 => "Aprilie",
        17 => "Mai",
        18 => "Iunie",
        19 => "Iulie",
        20 => "August",
        21 => "Septembrie",
        22 => "Octombrie",
        23 => "Noiembrie",
        24 => "Decembrie",
        25 => "Inapoi",
    26 => "Toata ziua",
    27 => "Saptamana",
    28 => "Calendar Personal pentru",
    29 => "Calendar Public",
    30 => "sterge eveniment",
    31 => "Adauga",
    32 => "Eveniment",
    33 => "Data",
    34 => "Ora",
    35 => "Adauga rapid",
    36 => "OK",
    37 => "Ne pare rau, facilitatea 'calendar personal' nu este activata",
    38 => "Editor Evenimente Personale",
    39 => 'Ziua',
    40 => 'Saptamana',
    41 => 'Luna'
);

###############################################################################
# admin/mail.php
$LANG31 = array(
         1 => $_CONF['site_name'] . " Mail Utility",
         2 => "From",
         3 => "Reply-to",
         4 => "Subject",
         5 => "Body",
         6 => "Send to:",
         7 => "All users",
         8 => "Admin",
        9 => "Options",
        10 => "HTML",
         11 => "Urgent message!",
         12 => "Send",
         13 => "Reset",
         14 => "Ignore user settings",
         15 => "Error when sending to: ",
        16 => "Successfully sent messages to: ",
        17 => "<a href=" . $_CONF["site_admin_url"] . "/mail.php>Send another message</a>",
    18 => "To",
    19 => "NOTE: if you wish to send a message to all site members, select the Logged-in Users group from the drop down.",
    20 => "Successfully sent <successcount> messages and unsuccessfully sent <failcount> messages.  If you need them, the details of each message attempts is below.  Otherwise you can <a href=\"" . $_CONF['site_admin_url'] . "/mail.php\">Send another message</a> or you can <a href=\"" . $_CONF['site_admin_url'] . "/moderation.php\">go back to the administration page</a>.",
    21 => 'Failures',
    22 => 'Successes',
    23 => 'No failures',
    24 => 'No successes',
    25 => '-- Select Group --',
    26 => "Please fill in all the fields on the form and select a group of users from the drop down."
);


###############################################################################
# confirmation and error messages

$MESSAGE = array (
        1 => "Parola a fost trimisa prin e-mail si trebuie sa o primiti imediat. Va rugam sa urmati indicatiile din mesaj si va multumim pentru utilizarea " . $_CONF["site_name"],
        2 => "Va multumim pentru stirea/textul trimis la {$_CONF["site_name"]}.  A fost trimisa pentru aprobare. Daca va fi aprobata, stirea dvs. va fi disponibila pe sit pentru vizualizare.",
        3 => "Va multumim pentru link-ul (adresa web)  propus(a) la {$_CONF["site_name"]}.  A fost trimisa pentru aprobare. Daca va fi aprobat, link-ul dvs. va fi introdus in sectiunea <a href={$_CONF["site_url"]}/links.php>link-uri</a>.",
        4 => "Va multumim pentru evenimentul trimis la {$_CONF["site_name"]}.  A fost trimisa pentru aprobare.  Daca va fi aprobat, evenimentul dvs. va fi introdus in sectiunea <a href={$_CONF["site_url"]}/calendar.php>calendar</a>.",
        5 => "Informatiile tale au fost salvate cu succes.",
        6 => "Preferintele tale au fost salvate cu succes.",
        7 => "Preferintele tale pentru comentarii au fost salvate cu succes.",
        8 => "Ai iesit cu succes din aria utilizatori inregistrati/membri.",
        9 => "Stirea a fost salvata cu succes.",
        10 => "Stirea a fost stearsa cu succes.",
        11 => "Blocul a fost salvat cu succes.",
        12 => "Blocul a fost sters cu succes.",
        13 => "Subiectul tau a fost salvat cu succes.",
        14 => "The topic and all it's stiri and blocks have been successfully sters.",
        15 => "Link-ul tau a fost salvat cu succes.",
        16 => "Link-ul tau a fost sters cu succes.",
        17 => "Evenimentul a fost salvat cu succes.",
        18 => "Evenimentul a fost sters cu succes.",
        19 => "Sondajul a fost salvat cu succes.",
        20 => "Sondajul a fost sters cu succes.",
        21 => "Noul membru a fost salvat cu succes.",
        22 => "Ulilizatorul a fost sters cu succes",
        23 => "Eroare la adaugarea unui Eveniment in calendarul tau. There was no Eveniment id passed.",
        24 => "Evenimentul a fost salvat in calendarul tau",
        25 => "Nu se poate vedea calendarul tau personal pana nu intri ca utilizator inregistrat (login).",
        26 => "Eveniment was successfully removed from your personal calendar",
        27 => "Mesaj trimis cu succes.",
        28 => "The plug-in has been successfully saved",
        29 => "Sorry, personal calendars are not enabled on this site",
        30 => "Access interzis",
        31 => "Sorry, you do not have access to the stire administration page.  Please note that all attempts to access unauthorized features are logged",
        32 => "Sorry, you do not have access to the topic administration page.  Please note that all attempts to access unauthorized features are logged",
        33 => "Sorry, you do not have access to the block administration page.  Please note that all attempts to access unauthorized features are logged",
        34 => "Sorry, you do not have access to the link administration page.  Please note that all attempts to access unauthorized features are logged",
        35 => "Sorry, you do not have access to the Eveniment administration page.  Please note that all attempts to access unauthorized features are logged",
        36 => "Sorry, you do not have access to the Sondaj administration page.  Please note that all attempts to access unauthorized features are logged",
        37 => "Sorry, you do not have access to the user administration page.  Please note that all attempts to access unauthorized features are logged",
        38 => "Sorry, you do not have access to the plugin administration page.  Please note that all attempts to access unauthorized features are logged",
        39 => "Sorry, you do not have access to the mail administration page.  Please note that all attempts to access unauthorized features are logged",
        40 => "Mesaj sistem",
    41 => "Sorry, you do not have access to the word replacement page.  Please note that all attempts to access unauthorized features are logged",
    42 => "Your word has been successfully saved.",
        43 => "The word has been successfully sters.",
    44 => 'The plug-in was successfully installed!',
    45 => 'The plug-in was successfully sters.',
    46 => "Sorry, you do not have access to the database backup utility.  Please note that all attempts to access unauthorized features are logged",
    47 => "This functionality only works under *nix.  If you are running *nix as your operating system then your cache has been successfully cleared. If you are on Windows, you will need to search for files name adodb_*.php and remove them manually.",
    48 => 'Va multumim pentru inregistrarea la ' . $_CONF['site_name'] . '. Vom revedea  inscrierea dvs. si daca va fi aprobata, parola dvs. va fi trimisa la adresa de e-mail pe care ati introdus-o.',
    49 => "Your group has been successfully saved.",
    50 => "The group has been successfully sters."
);

// for plugins.php

$LANG32 = array (
        1 => "Installing plugins could possibly cause damage to your Geeklog installation and, possibly, to your system.  It is important that you only install plugins downloaded from the <a href=\"http://www.geeklog.net\" target=\"_blank\">Geeklog Homepage</a> as we thoroughly test all plugins submitted to our site on a variety of operating systems.  It is important that you understand that the plugin installation process will require the execution of a few filesystem commands which could lead to security problems particularly if you use plugins from third party sites.  Even with this warning you are getting, we do not gaurantee the success of any installation nor are we liable for damage caused by installing a Geeklog plugin.  In other words, install at your own risk.  For the wary, directions on how to manually install a plugin is included with each plugin package.",
        2 => "Plug-in Installation Disclaimer",
        3 => "Plug-in Installation Form",
        4 => "Plug-in File",
        5 => "Plug-in List",
        6 => "Warning: Plug-in Already Installed!",
        7 => "The plug-in you are trying to install already exists.  Please sterge the plugin before re-installing it",
        8 => "Plugin Compatibility Check Failed",
        9 => "This plugin requires a newer version of Geeklog. Either upgrade your copy of <a href=\"http://www.geeklog.net\">Geeklog</a> or get a newer version of the plug-in.",
        10 => "<br><b>There are no plugins currently installed.</b><br><br>",
        11 => "To modify or sterge a plug-in, click on that plug-in's number below. To learn more about a plug-in, click the plug-in name and you will be directed to that plug-in's website. To install or upgrade a plug-in please consult it's documentation.",
        12 => 'no plugin name provided to plugineditor()',
        13 => 'Plugin Editor',
        14 => 'New Plug-in',
        15 => 'Admin Home',
        16 => 'Plug-in Name',
        17 => 'Plug-in Version',
        18 => 'Geeklog Version',
        19 => 'Enabled',
        20 => 'Yes',
        21 => 'No',
        22 => 'Install',
    23 => 'Salveaza',
    24 => 'anuleaza',
    25 => 'Sterge',
    26 => 'Plug-in Name',
    27 => 'Plug-in Homepage',
    28 => 'Plug-in Version',
    29 => 'Versiune Geeklog ',
    30 => 'Sterge Plug-in?',
    31 => 'Are you sure you want to sterge this plug-in?  By doing so you will remove all the data and data structures that this plug-in uses.  If you are sure, click sterge again on the form below.'
);

$LANG_ACCESS = array(
        access => "Access",
    ownerroot => "Owner/Root",
    group => "Group",
    readonly => "Read-Only",
        accessrights => "Access Rights",
        owner => "Owner",
        grantgrouplabel => "Grant Above Group Edit Rights",
        permmsg => "NOTE: members is all logged in members of the site and anonymous is all users browsing the site that aren't logged in.",
        securitygroups => "Security Groups",
        editrootmsg => "Even though you are a User Administrator, you can't edit a root user without first being a root user yourself.  You can edit all other users except root users. Please note that all attempts to illegally edit root users are logged.  Please go back to the <a href=\"{$_CONF["site_admin_url"]}/user.php\">User Administration page</a>.",
        securitygroupsmsg => "Select the checkboxes for the groups you want the user to belong to.",
        groupeditor => "Group Editor",
        description => "Descriere",
        name => "Name",
         rights => "Rights",
        missingfields => "Missing Fields",
        missingfieldsmsg => "You must supply the name and a descriere for a group",
        groupmanager => "Group Manager",
        newgroupmsg => "To modify or sterge a group, click on that group below. To create a new group click new group above. Please note that core groups cannot be sters because they are used in the system.",
        groupname => "Group Name",
        coregroup => "Core Group",
        yes => "Yes",
        no => "No",
        corerightsdescr => "This group is a core {$_CONF["site_name"]} Group.  Therefore the rights for this group cannot be edited.  Below is a read-only list of the rights this group has access to.",
        groupmsg => "Security Groups on this site are hierarchical.  By adding this group to any of the groups below you will giving this group the same rights that those groups have.  Where possible it is encouraged you use the groups below to give rights to a group.  If you need this group to have custom rights then you can select the rights to various site features in the section below called 'Rights'.  To add this group to any of the ones below simply check the box next to the group(s) that you want.",
        coregroupmsg => "This group is a core {$_CONF["site_name"]} Group.  Therefore the groups that this groups belongs to cannot be edited.  Below is a read-only list of the groups this group belongs to.",
        rightsdescr => "A groups access to a certain right below can be given directly to the group OR to a different group that this group is a part of.  The ones you see below without a checkbox are the rights that have been given to this group because it belongs to another group with that right.  The rights with checkboxes below are rights that can be given directly to this group.",
        lock => "Lock",
        members => "Members",
        anonymous => "Anonymous",
        permissions => "Permissions",
        permissionskey => "R = read, E = edit, edit rights assume read rights",
        edit => "Edit",
        none => "None",
        accessdenied => "Access Denied",
        storydenialmsg => "You do not have access to view this stire.  This could be because you aren't a member of {$_CONF["site_name"]}.  Please <a href=users.php?mode=new> become a member</a> of {$_CONF["site_name"]} to receive full membership access!",
        eventdenialmsg => "You do not have access to view this Eveniment.  This could be because you aren't a member of {$_CONF["site_name"]}.  Please <a href=users.php?mode=new> become a member</a> of {$_CONF["site_name"]} to receive full membership access!",
        nogroupsforcoregroup => "This group doesn't belong to any of the other groups",
        grouphasnorights => "This group doesn't have access to any of the administrative features of this site",
        newgroup => 'New Group',
        adminhome => 'Admin Home',
        save => 'save',
        cancel => 'anuleaza',
        delete => 'sterge',
        canteditroot => 'You have tried to edit the Root group but you are not in the Root group yourself therefore your access to this group is denied.  Please contact the system administrator if you feel this is an error'
);

#admin/word.php
$LANG_WORDS = array(
    editor => "Word Replacment editor",
    wordid => "Word ID",
    intro => "To modify or sterge a word, click on that word.  To create a new word replacement click the new word button to the left.",
    wordmanager => "Word Manager",
    word => "Word",
    replacmentword => "Replacment Word",
    newword => "New Word"
);

$LANG_DB_BACKUP = array(
    last_ten_backups => 'Ultimele 10 Backup-uri',
    do_backup => 'Backup',
    backup_successful => 'Database back up was successful.',
    no_backups => 'No backups in the system',
    db_explanation => 'To create a new backup of your Geeklog system, hit the button below',
    not_found => "Incorrect path or mysqldump utility not executable.<br>Check <strong>\$_DB_mysqldump_path</strong> definition in config.php.<br>Variable currently defined as: <var>{$_DB_mysqldump_path}</var>",
    zero_size => 'Backup Failed: Filesize was 0 bytes',
    path_not_found => "{$_CONF['backup_path']} does not exist or is not a directory",
    no_access => "ERROR: Directory {$_CONF['backup_path']} is not accessible.",
    backup_file => 'Backup file',
    size => 'Size',
    bytes => 'Bytes'
);

$LANG_BUTTONS = array(
    1 => "Home",
    2 => "Contact",
    3 => "Publica",
    4 => "Link-uri",
    5 => "Sondaje",
    6 => "Calendar",
    7 => "Statistici",
    8 => "Personalizeaza",
    9 => "Cauta",
    10 => "cautare avansata"
);

$LANG_404 = array(
    1 => "Eroare 404",
    2 => "Oh, nu! Ne-am uitat peste tot, dar n-am gasit <b>%s</b>.",
    3 => "<p>Ne pare rau, dar pagina care o cautati nu exista. Va rugam, verificati <a href=\"{$_CONF['site_url']}\">pagina principala</a> sau <a href=\"{$_CONF['site_url']}/search.php\">pagina de cautare</a> sa vedeti daca gasiti ceea ce cautati."
);

$LANG_LOGIN = array (
    1 => 'Inregistrare necesara',
    2 => 'Ne pare rau, pentru a avea acces la aceasta zona trebuie sa fiti membru/utilizator inregistrat.',
    3 => 'Inregistrare',
    4 => 'Membru Nou'
);

?>
