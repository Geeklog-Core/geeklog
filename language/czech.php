<?php

###############################################################################
# 
# This is the czech language page for GeekLog!
#
# Copyright (C) 2002 hermes_trismegistos
# hermes_trismegistos@post.cz
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
	1 => "Publikoval :",
	2 => "<b>Èíst celé</b>",
	3 => "komentáøù",
	4 => "Editovat",
	5 => "Anketa",
	6 => "Výsledky",
	7 => "Výsledky ankety",
	8 => "hlasù",
	9 => "Administrátorské funkce:",
	10 => "Pøíspìvky",
	11 => "Èlánky",
	12 => "Bloky",
	13 => "Sekce",
	14 => "Odkazy",
	15 => "Události",
	16 => "Ankety",
	17 => "U¾ivatelé",
	18 => "SQL dotaz",
	19 => "<b>Odhlásit</b>",
	20 => "Informace o u¾ivateli:",
	21 => "U¾ivatel",
	22 => "U¾ivatelùv ID",
	23 => "Úroveò práv",
	24 => "Anonymní host",
	25 => "Odpovìï",
	26 => " Následující komentáøe jsou názorem jejich vkladatele. <br>Weblog neruèí za to co je zde napsáno.",
	27 => "Naposledy pøidáno",
	28 => "Smazat",
	29 => "Nejsou ¾ádné komentáøe.",
	30 => "Star¹í èlánky",
	31 => "HTML tagy povoleny:",
	32 => "Chyba, neplatné u¾ivatelské jméno",
	33 => "Chyba, nepovolený zápis do log fajlu",
	34 => "Chyba",
	35 => "Odhlásit",
	36 => " - ",
	37 => "Bez èlánkù",
	38 => "",
	39 => "Obnovit",
	40 => "",
	41 => "Hosté",
	42 => "Publikováno:",
	43 => "Odpovìdìt na toto",
	44 => "Nadøazený",
	45 => "MySQL Error Number",
	46 => "MySQL Error Message",
	47 => "U¾ivatelské menu",
	48 => "Informace o úètu",
	49 => "Vlastní nastavení",
	50 => "Error with SQL statement",
	51 => "help",
	52 => "Nové",
	53 => "Administrace",
	54 => "Nelze otevøít soubor.",
	55 => "Nastala chyba - ",
	56 => "Hlasovat",
	57 => "Heslo",
	58 => "Pøihlásit",
	59 => "Nemáte zatím úèet?  Pøihla¹te se jako <a href=\"{$_CONF['site_url']}/users.php?mode=new\"><b>Nový&nbsp;u¾ivatel</b></a>",
	60 => "Okomentovat",
	61 => "Nový u¾ivatel",
	62 => "slov",
	63 => "Nastavení komentáøù",
	64 => "Poslat emailem",
	65 => "Verze pro tiskárnu",
	66 => "Osobní kalendáø",
	67 => "Vítejte na ",
	68 => "home",
	69 => "kontakt",
	70 => "hledat",
	71 => "pøíspìvky",
	72 => "odkazy",
	73 => "ankety",
	74 => "kalendáø",
	75 => "roz¹íøené hledání",
	76 => "statistika",
	77 => "Pluginy",
	78 => "Blí¾ící se události",
	79 => "Co je nového",
	80 => "èlánkù za posledních",
	81 => "èlánek za posledních",
	82 => "hodin",
	83 => "KOMENTÁØE",
	84 => "ODKAZY",
	85 => "za posledních 48 hodin",
	86 => "Nejsou nové komentáøe",
	87 => "za poslední 2 týdny",
	88 => "Nejsou nové odkazy",
	89 => "Nejsou ¾ádné blí¾ící se události",
	90 => "Homepage",
	91 => "Stránka vytvoøena za",
	92 => "sekund&nbsp;",
	93 => "Copyright",
	94 => "V¹echna práva a ochranné známky na tìchto stránkách patøí jejich vlastníkùm.",
	95 => "Pou¾íváme",
	96 => "Skupiny",
    97 => "Word List",
	98 => "Pluginy",
	99 => "ÈLÁNKY",
    100 => "Nejsou nové èlánky",
    101 => 'Osobní události',
    102 => 'Události weblogu',
    103 => 'DB zálohy',
    104 => '-',
    105 => 'Emailový démon',
    106 => 'Zhlédnuto',
    107 => 'Test Verze GL',
    108 => 'Smazat cache'
);

###############################################################################
# calendar.php

$LANG02 = array(
	1 => "Kalendáø",
	2 => "Nejsou ¾ádné události k zobrazení.",
	3 => "Kdy",
	4 => "Kde",
	5 => "Popis",
	6 => "Pøidat událost",
	7 => "Blí¾ící se události",
	8 => 'Kdy¾ toto pøidáte do Osobního kalendáøe, uvidíte je jen Vy ve svém Osobním kalendáøi v U¾ivatelských funkcích.',
	9 => "Pøidat do osobního kalendáøe",
	10 => "Odebrat z osobního kalendáøe",
	11 => "Pøidání události do kalendáøe {$_USER['username']}'",
	12 => "Událost",
	13 => "Zaèíná",
	14 => "Konèí",
  15 => "Zpìt na kalendáø"
);

###############################################################################
# comment.php

$LANG03 = array(
	1 => "Vlo¾it komentáø",
	2 => "Typ komentáøe",
	3 => "Odhlásit",
	4 => "Vytvoøit úèet",
	5 => "U¾ivatel",
	6 => "Tato stránka vy¾aduje pøihlá¹ení pro vlo¾ení komentáøe, prosím pøihla¹te se.  Pokud nemáte úèet - mù¾ete si ho vytvoøit.",
	7 => "Vá¹ poslední komentáø vlo¾en pøed ",
	8 => " sekundami.  Tato stránka vy¾aduje prodlevu {$_CONF["commentspeedlimit"]} sekund mezi komentáøi.",
	9 => "Komentáø",
	10 => '',
	11 => "Vlo¾it komentáø",
	12 => "Prosím vyplòte Titulek a Komentáø, jinak nelze vlo¾it.",
	13 => "Va¹e info",
	14 => "Náhled",
	15 => "",
	16 => "Titulek",
	17 => "Chyba",
	18 => 'Dùle¾ité',
	19 => 'Prosím vkládejte komentáøe do správné sekce.',
	20 => 'Komentáøe vkládejte pokud mo¾no ve správném poøadí.',
	21 => 'Pøeètìte si prosím nejdøíve komentáøe ostatních u¾ivatelù, aby nedocházelo k duplicitì.',
	22 => 'Pou¾ijte titulek, který vlo¾il systém.',
	23 => 'Vá¹ email nebude publikován!',
	24 => 'Anonymní host'
);

###############################################################################
# users.php

$LANG04 = array(
	1 => "U¾ivatelský profil:",
	2 => "Pøihla¹ovací jméno",
	3 => "Jméno",
	4 => "Heslo",
	5 => "Email",
	6 => "Homepage",
	7 => "O vás",
	8 => "PGP klíè",
	9 => "Ulo¾it zmìny",
	10 => "Posledních 10 comentáøù u¾ivatele",
	11 => "Bez komentáøù u¾ivatele",
	12 => "U¾ivatelské nastavení:",
	13 => "Posílat na konci ka¾dého dne výtah z weblogu emailem",
	14 => "Toto heslo bylo náhodnì vygenerováno systémem. Doporuèuje se zmìnit co nejdøíve. Pro zmìnu hesla se pøihla¹te a zmìnte si ho poté v menu Informace o úètu v U¾ivatelském rozhraní.",
	15 => "Vá¹ {$_CONF["site_name"]} úèet byl vytvoøen. Mù¾ete se pøihlásit, ní¾e jsou Va¹e pøihla¹ovací data. Prosím uschovejt si tento email pro budoucí reference.",
	16 => "Informace o úètu",
	17 => "Úèet neexistuje",
	18 => "Email se zdá být v nesprávném formátu",
	19 => "U¾ivatel nebo email ji¾ existuje",
	20 => "Email se zdá být v nesprávném formátu",
	21 => "Chyba",
	22 => "Registrace na {$_CONF['site_name']}!",
	23 => "Anonymní u¾ivatelé - Hosté nemohou napøíklad komentovat èi pøidávat èlánky.<br>Vytvoøení úètu Vám umo¾ní vyu¾ívat v¹ech funkcí na {$_CONF['site_name']}. <br>Va¹e emailová adresa nebude <b><i>nikdy a nikde</i></b> zveøejnìna na tìchto stránkách.",
	24 => "Va¹e heslo bude posláno na vámi zadanou emailovou adresu.",
	25 => "Zapomenuté heslo?",
	26 => "Vlo¾te Va¹e pøihla¹ovací jméno a klepnìte na Poslat-heslo a nové heslo Vám bude zasláno na Vámi zadanou emailovou adresu.",
	27 => "Registrovat nyní!",
	28 => "Poslat-heslo",
	29 => "odhlá¹en od",
	30 => "pøihlá¹en od",
	31 => "Tato funkce vy¾aduje pøihlá¹ení",
	32 => "Podpis",
	33 => "Nezobrazí se veøejnì",
	34 => "Toto je va¹e pravé jméno",
	35 => "Jen pro zmìnu hesla",
	36 => "Na zaèátku s http://",
	37 => "Bude pou¾it v komentáøích",
	38 => "Toto je o Vás! Kdokoli si to mù¾e pøeèíst",
	39 => "Vá¹ veøejný PGP klíè",
	40 => "Bez ikon Sekcí",
	41 => "Chci být Moderátorem sekce",
	42 => "Formát data",
	43 => "Maximální poèet èlánkù",
	44 => "Bez blokù",
	45 => "Vlastní nastavení pro",
	46 => "Bez tìchto polo¾ek pro",
	47 => "Nastavení blokù pro",
	48 => "Sekce",
	49 => "Nezobrazovat ikony",
	50 => "Od¹krtnìte pokud vás nezajímá",
	51 => "Jen novinky",
	52 => "Systémové nastavení - ",
	53 => "Dostávat èlánky na konci dne emailem",
	54 => "Za¹krtnìte to co nechcete zobrazovat.",
	55 => "Pokud necháte od¹krtlé, bude pou¾ito pùvodní nastavení - to co je tuènì bude zobrazováno.  Pro vlastní nastavení za¹krtnìte jen to co chcete zobrazovat.",
	56 => "Autoøi",
	57 => "Nastavení zobrazování polo¾ek pro",
	58 => "Øazení",
	59 => "Maximální poèet komentáøù",
	60 => "Jak chcete zobrazovat komentáøe?",
	61 => "Nejnovìj¹í nebo nejstar¹í nejdøíve?",
	62 => "Systémové nastavení - 100",
	63 => "Va¹e heslo bude posláno na vámi zadanou emailovou adresu. Postupujte podle zaslaných instrukcí pro pøihlá¹ení do " . $_CONF["site_name"],
	64 => "Nastavení komentáøù pro",
	65 => "Zkuste se pøihlásit znovu",
	66 => "Spletl jste se v zadání.  Prosím zkuste to znovu. Nebo jste  <a href=\"{$_CONF['site_url']}/users.php?mode=new\"><b>nový u¾ivatel</b></a>?",
	67 => "U¾ivatelem od",
	68 => "Pamatovat si mne",
	69 => "Jak dlouho si Vás systém bude pamatovat.",
	70 => "Pøizpùsobení vzhledu a obsahu {$_CONF['site_name']}",
	71 => "Pøizpùsobení vzhledu na {$_CONF['site_name']} vám umo¾ní nastavit si vlastní vzhled a øazení polo¾ek nezávisle na nastavení pro hosty.  Pro tato nastavení se musíte <a href=\"{$_CONF['site_url']}/users.php?mode=new\">pøihlásit</a> na {$_CONF['site_name']}. <br> Jste u¾ivatelem?  Pak pou¾ijte pøihla¹ovací formuláø vlevo!",
    72 => "Grafické téma",
    73 => "Jazyk",
    74 => "Vyberte jak má weblog vypadat",
    75 => "Zasílání sekcí",
    76 => "Tyto sekce vám budou zasílána emailem koncem ka¾dého dne. Prosím vybírejte jen sekce, které vás zajímají!",
    77 => "Foto",
    78 => "Pøidá Va¹e foto (do velikosti 96x96px)!",
    79 => "Za¹krtnout pro smazání fota",
    80 => "Pøihlásit",
    81 => "Zaslat email",
    82 => 'Posledních 10 èlánkù u¾ivatele',
    83 => 'Publikaèní statistika u¾ivatele',
    84 => 'Celkovì publikací:',
    85 => 'Celkovì komentáøù:',
    86 => 'Najít v¹e od'
);

###############################################################################
# index.php

$LANG05 = array(
	1 => "Nic nového k zobrazení",
	2 => "®ádné nové èlánky k zobrazení.  Mo¾ná nejsou ¾ádné novinky, nebo jste zadali ¹patné podmínky filtrování",
	3 => " pro sekci $topic",
	4 => "Nejnovìj¹í èlánek",
	5 => "Dal¹í",
	6 => "Pøede¹lé"
);

###############################################################################
# links.php

$LANG06 = array(
	1 => "Webový obsah",
	2 => "Nic nenalezeno.",
	3 => "Pøidat odkaz"
);

###############################################################################
# pollbooth.php

$LANG07 = array(
	1 => "Hlas ulo¾en",
	2 => "Vá¹ hlas v anketì byl ulo¾en",
	3 => "Hlas",
	4 => "Ankety v systému",
	5 => "Hlasy"
);

###############################################################################
# profiles.php

$LANG08 = array(
	1 => "Nastala chyba pøi odesílání emailu, zkuste to prosím znovu.",
	2 => "Zpráva úspì¹nì odeslána.",
	3 => "Zkontrolujte si prosím správnost emailové adresy.",
	4 => "Prosím vyplòte v¹echna pole formuláøe.",
	5 => "Chyba: neexistující u¾ivatel.",
	6 => "Vznikla chyba.",
	7 => "U¾ivatelský profil ",
	8 => "Jméno",
	9 => "URL stránek u¾ivatele",
	10 => "Poslat email u¾ivateli ",
	11 => "Va¹e jméno:",
	12 => "Poslat na:",
	13 => "Hlavièka:",
	14 => "Zpráva:",
	15 => "Pou¾ité HTML tagy nebudou zmìnìny.<br>",
	16 => "Poslat zprávu",
	17 => "Poslat èlánek mailem",
	18 => "Komu",
	19 => "Kam",
	20 => "Od koho",
	21 => "Email odesilatele",
	22 => "Prosím vyplòte v¹echna pole formuláøe.",
	23 => "Tento email Vám byl poslán $from z $fromemail proto¾e si tento u¾ivatel myslí, ¾e by Vás mohl zaujmut.  Bylo publikováno na {$_CONF["site_url"]}.   Toto NENÍ SPAM a Va¹e emailová adresa nebyla nikde ulo¾ena a nebude tudí¾ pou¾ita k jakýmkoli úèelùm.",
	24 => "Komentáø k èlánku na",
	25 => "Musíte být pøihlá¹en jako u¾ivatel pro pou¾ití této funkce weblogu.<br>  Touto restrikcí se pøedchází zneu¾ití systému k spammingu!",
	26 => "Tento formuláø umo¾òuje zaslat email vybranému u¾ivateli.  Vyplòte prosím v¹echna pole.",
	27 => "Krátká zpráva",
	28 => "$from napsáno: $shortmsg",
  29 => "Toto jsou denní novinky z {$_CONF['site_name']} pro ",
  30 => " Denní novinky pro ",
  31 => "Titulek",
  32 => "Datum",
  33 => "Celý èlánek si mù¾ete pøeèíst na ",
  34 => "Konec zprávy"
);

###############################################################################
# search.php

$LANG09 = array(
	1 => "roz¹íøené hledání",
	2 => "Klíèová slova",
	3 => "Sekce",
	4 => "V¹e",
	5 => "Typ",
	6 => "Èlánky",
	7 => "Komentáøe",
	8 => "Autoøi",
	9 => "V¹e",
	10 => "Hledání",
	11 => "Výsledky hledání",
	12 => "odpovídající filtru",
	13 => "Výsledky hledání: nic neodpovídá zadanému filtru",
	14 => "®ádné výsledky neodpovídají zadanému filtru",
	15 => "Prosím zkuste znovu.",
	16 => "Titulek",
	17 => "Datum",
	18 => "Autor",
	19 => "Prohledat celou databázi nových i archivních polo¾ek na {$_CONF["site_name"]}",
	20 => "Datum",
	21 => "do",
	22 => "(Formát data RRRR-MM-DD)",
	23 => "Zhlédnuto",
	24 => "Nalezeno",
	25 => "filtru odpovídajících z celkem ",
	26 => "polo¾ek bìhem",
	27 => "sekund",
    28 => '®ádný èlánek nebo komentáø neodpovídá zadanému filtru',
    29 => 'Výsledky vyhledávání èlánkù a komentáøù',
    30 => '®ádné výsledky neodpovídají zadanému filtru',
    31 => 'This plug-in returned no matches',
    32 => 'Událost',
    33 => 'URL',
    34 => 'Umístìní',
    35 => 'Celý den',
    36 => '®ádné události neodpovídají zadanému filtru',
    37 => 'Výsledky hledání',
    38 => 'Výsledky hledání odkazù',
    39 => 'Odkazy',
    40 => 'Události',
    41 => 'Alespoò 3 znaky v poli vyhledávání.',
    42 => 'Prosím zadávejte datum v tomto formátu: RRRR-MM-DD (rok-mìsíc-den).'
);

###############################################################################
# stats.php

$LANG10 = array(
	1 => "Celková statistika stránek",
	2 => "Souhrn po¾adavkù na systém",
	3 => "Èlánky(komentáøe) v systému",
	4 => "Anket(odpovìdí) v systému",
	5 => "Odkazy(jejich následování) v systému",
	6 => "Události v systému",
	7 => "Top Ten èlánky",
	8 => "Titulek èlánku",
	9 => "Zhlédnuto",
	10 => "®ádné èlánky zde nejsou.",
	11 => "Top Ten komentovaných èlánkù",
	12 => "Komentáøe",
	13 => "®ádné komentované èlánky zde nejsou.",
	14 => "Top Ten anket",
	15 => "Anketní otázka",
	16 => "Hlasù",
	17 => "®ádné ankety zde nejsou.",
	18 => "Top Ten okazù",
	19 => "Odkazy",
	20 => "Zhlédnuto",
	21 => "®ádné odkazy na které se klickalo zde nejsou.",
	22 => "Top Ten emailem zaslaných èlánkù",
	23 => "Zasláno emailem",
	24 => "®ádné emailem poslané èlánky zde nejsou."
);

###############################################################################
# article.php

$LANG11 = array(
	1 => "Související",
	2 => "Poslat mailem",
	3 => "Verze pro tiskárnu",
	4 => "Volby èlánku"
);

###############################################################################
# submit.php

$LANG12 = array(
	1 => "Pro tento $type musíte být pøihlá¹en jako u¾ivatel.",
	2 => "Pøihlásit",
	3 => "Nový u¾ivatel",
	4 => "Pøidání",
	5 => "Pøidat odkaz",
	6 => "Publikovat èlánek",
	7 => "Vy¾adováno pøihlá¹ení",
	8 => "Publikování",
	9 => "Pro publikování na tìchto stránkách následujte prosím tato prostá doporuèení: <ul><li>Vyplòte v¹echna povinná pole<li>Zadávejte kompletní a pøesné informace<li>Dvakrát si zkontrolujte URL</ul>",
	10 => "Titulek",
	11 => "Odkaz",
	12 => "Datum zaèátku",
	13 => "Datum konce&nbsp;&nbsp;&nbsp;",
	14 => "Umístìní",
	15 => "Popis",
	16 => "Pokud je Jiné, specifikujte prosím",
	17 => "Kategorie",
	18 => "Jiné",
	19 => "Pøeètìte si",
	20 => "Chyba: Chybí Kategorie",
	21 => "Pokud vybráno \"Jiné\" vyberte prosím i kategorii",
	22 => "Chyba: nevyplnìná pole",
	23 => "Prosím vyplòte v¹echna pole. V¹e je povinné.",
	24 => "Publikace provedena",
	25 => "Va¹e $type publikace byla provedena.",
	26 => "Omezení rychlosti publikování",
	27 => "U¾ivatel",
	28 => "Sekce",
	29 => "Èlánek",
	30 => "Poslední publikace byla pøed ",
	31 => " sekundami.  Tato stránka vy¾aduje {$_CONF["speedlimit"]} sekund mezi publikacemi",
	32 => "Náhled",
	33 => "Náhled èlánku",
	34 => "Odhlásit",
	35 => "HTML tagy nejsou podporovány",
	36 => "Typ publikace",
	37 => "Pøidání události - {$_CONF["site_name"]} pøidá tuto do Veøejného kalendáøe pokud si nevyberete jen pøidání do Osobního kaendáøe.<br><br>Pokud pøidáte událost do Veøejného kalendáøe bude tato po kontrole administrátorem zaøazena do Veøejného kalendáøe.",
    38 => "Pøidat událost do",
    39 => "Veøejný kalendáø",
    40 => "Osobní kalendáø",
    41 => "Èas konce&nbsp;&nbsp;&nbsp;",
    42 => "Èas zaèátku",
    43 => "Ka¾dodennì",
    44 => 'Adresa 1',
    45 => 'Adresa 2',
    46 => 'Mìsto',
    47 => 'Zemì',
    48 => 'Smìrové èíslo',
    49 => 'Typ události',
    50 => 'Ediovat typ události',
    51 => 'Umístìní',
    52 => 'Smazat',
    53 => 'Vytvoøit úèet'
);


###############################################################################
# ADMIN PHRASES - These are file phrases used in end admin scripts
###############################################################################

###############################################################################
# auth.inc.php

$LANG20 = array(
	1 => "Autentikace vy¾adována",
	2 => "Pøístup odepøen! Nesprávné pøihla¹ovací údaje",
	3 => "Neplatné heslo pro u¾ivatele",
	4 => "U¾ivatel:",
	5 => "Heslo:",
	6 => "Ka¾dý pøístup do administrátorské èásti stránek je zapisován do log_file a je tam také kontrolován.<br>Tato stránka je jen pro autorizované u¾ivatele s administrátorskými právy.",
	7 => "Pøihlásit"
);

###############################################################################
# block.php

$LANG21 = array(
	1 => "Nedostateèná administrátorská práva",
	2 => "Nemáte povolen pøístup k této èásti administrace.",
	3 => "Editor blokù",
	4 => "",
	5 => "Titulek bloku",
	6 => "Sekce",
	7 => "V¹e",
	8 => "Úroveò práv bloku",
	9 => "Poøadí bloku",
	10 => "Typ bloku",
	11 => "Blok Portálu",
	12 => "Normální blok",
	13 => "Volby Bloku Portálu",
	14 => "RDF URL",
	15 => "Last RDF Update",
	16 => "Volby bloku",
	17 => "Obsah bloku",
	18 => "Prosím vyplòte Titulek bloku, Úroveò práv a Obsah",
	19 => "Mana¾er blokù",
	20 => "Titulek bloku",
	21 => "Úroveò práv bloku",
	22 => "Typ bloku",
	23 => "Poøadí bloku",
	24 => "Sekce bloku",
	25 => "Pro smazání a editaci bloku, klepnìte na blok ní¾e.  Pro vytvoøení nového bloku klepnìte na Nový blok vý¹e.",
	26 => "Vzhled bloku",
	27 => "PHP Blok",
    28 => "Volby PHP Bloku",
    29 => "Funkce bloku",
    30 => "If you would like to have one of your blocks use PHP code, enter the name of the function above.  Your function name must start with the prefix \"phpblock_\" (e.g. phpblock_getweather).  If it does not have this prefix, your function will NOT be called.  We do this to keep people who may have hacked your Geeklog installation from putting arbitrary function calls that may be harmful to your system.  Be sure not to put empty parenthisis \"()\" after your function name.  Finally, it is recommended that you put all your PHP Block code in /path/to/geeklog/system/lib-custom.php.  That will allow the code to stay with you even when you upgrade to a newer version of Geeklog.",
    31 => 'Chyba v PHP Bloku.  Funkce, $function, neexistuje.',
    32 => "Chyba - neexistující pole",
    33 => "You must enter the URL to the .rdf file for portal blocks",
    34 => "You must enter the title and the function for PHP blocks",
    35 => "You must enter the title and the content for normal blocks",
    36 => "You must enter the content for layout blocks",
    37 => "©patné jméno funkce PHP bloku",
    38 => "Functions for PHP Bloky must have the prefix 'phpblock_' (e.g. phpblock_getweather).  The 'phpblock_' prefix is required for security reasons to prevent the execution of arbitrary code.",
	39 => "Strana",
	40 => "Vlevo",
	41 => "Vpravo",
	42 => "You must enter the blockorder and security level for Geeklog default blocks",
	43 => "Jen na Homepage",
	44 => "Pøístup odepøen",
	45 => "You are trying to access a block that you don't have rights to.  This attempt has been logged. Please <a href=\"{$_CONF["site_admin_url"]}/block.php\">go back to the block administration screen</a>.",
	46 => 'Nový blok',
	47 => 'Administrace',
    48 => 'Jméno bloku',
    49 => ' (bez mezer, musí být unikátní)',
    50 => ' URL Help souboru',
    51 => 'vèetnì http://',
    52 => 'Pokud necháte prázdné - ikona helpu se nebude zobrazovat.',
    53 => 'Povolit',
    54 => 'ulo¾it',
    55 => 'zru¹it akci',
    56 => 'smazat'
);

###############################################################################
# event.php

$LANG22 = array(
	1 => "Editor událostí",
	2 => "",
	3 => "Titulek události",
	4 => "URL události",
	5 => "Datum zaèátku",
	6 => "Datum konce&nbsp;&nbsp;&nbsp;",
	7 => "Umístìní události",
	8 => "Popis události",
	9 => "(vèetnì http://)",
	10 => "Musíte zadat datum/èas, popis a umístìní události!",
	11 => "Mana¾er událostí",
	12 => "Pro zmìnu a smazání události, klepnìte na tuto ní¾e.  Pro vytvoøení nové události klepnìte na Nová událost vý¹e.",
	13 => "Titulek události",
	14 => "Datum zaèátku",
	15 => "Datum konce&nbsp;&nbsp;&nbsp;",
	16 => "Pøístup odepøen",
	17 => "Pokou¹íte se editovat událost na ní¾ nemáte dostateèná práva.  Tento pokus byl zaznamenán. Prosím <a href=\"{$_CONF["site_admin_url"]}/event.php\">vra»te se na administraci událostí</a>.",
	18 => 'Nová událost',
	19 => 'Administrace',
    20 => 'ulo¾it',
    21 => 'zru¹it akci',
    22 => 'smazat'
);

###############################################################################
# link.php

$LANG23 = array(
	1 => "Editor odkazù",
	2 => "",
	3 => "Titulek odkazu",
	4 => "URL odkazu",
	5 => "Kategorie",
	6 => "(vèetnì http://)",
	7 => "Jiná",
	8 => "Klicknuto",
	9 => "Popis odkazu",
	10 => "Je potøeba zadat Titulek, URL a Popis odkazu.",
	11 => "Mana¾er odkazù",
	12 => "Pro úpravu odkazu, klepnìte na po¾adovaný odkaz ní¾e.  Pro vytvoøení nového odkazu klepnìte na Nový odkaz vý¹e.",
	13 => "Titulek odkazu",
	14 => "Kategorie",
	15 => "URL odkazu",
	16 => "Pøístup odepøen",
	17 => "Pokou¹íte se editovat odkaz na nìj¾ nemáte dostateèná práva.  Tento pokus byl zaznamenán. Prosím <a href=\"{$_CONF["site_admin_url"]}/link.php\">vra»te se na administraci odkazù</a>.",
	18 => 'Nový odkaz',
	19 => 'Administrace',
	20 => 'Pokud je jiná',
    21 => 'ulo¾it',
    22 => 'zru¹it akci',
    23 => 'smazat'
);

###############################################################################
# story.php

$LANG24 = array(
	1 => "Pøede¹lé èlánky",
	2 => "Dal¹í èlánky",
	3 => "Re¾im",
	4 => "Publikaèní re¾im",
	5 => "Editor èlánkù",
	6 => "Nejsou zde èlánky",
	7 => "Autor",
	8 => "ulo¾it",
	9 => "náhled",
	10 => "zru¹it akci",
	11 => "smazat",
	12 => "",
	13 => "Titulek",
	14 => "Sekce",
	15 => "Datum publikace",
	16 => "Intro Text",
	17 => "Text",
	18 => "Zhlédnuto",
	19 => "Komentáøe",
	20 => "",
	21 => "",
	22 => "Seznam èlánkù",
	23 => "Pro editaci nebo smazání èlánku klepnìte na jeho èíslo ní¾e. Pro zobrazení,klepnìte na titulek èlánku, který chcete vidìt. Pro vytvoøení nového èlánku klepnìte na Nový èlánek vý¹e.",
	24 => "",
	25 => "",
	26 => "Náhled",
	27 => "",
	28 => "",
	29 => "",
	30 => "",
	31 => "Prosím vypln»e Autor, Titulek a Intro Text",
	32 => "Zvýraznit",
	33 => "V sytému mù¾e být jen jeden zvýraznìný èlánek (ten se bude zobrazovat v¾dy jako první)",
	34 => "Verze pro tiskárnu",
	35 => "Ano",
	36 => "Ne",
	37 => "Více od",
	38 => "Více z",
	39 => "Posláno emailem",
	40 => "Pøístup odepøen",
	41 => "Pokou¹íte se editovat odkaz na nìj¾ nemáte dostateèná práva.  Tento pokus byl zaznamenán.  Mù¾ete si jen prohlédnout èlánky ní¾e. Prosím <a href=\"{$_CONF["site_admin_url"]}/story.php\">vra»te se na administraci èlánkù</a> kdy¾ skonèíte.",
	42 => "Pokou¹íte se editovat odkaz na nìj¾ nemáte dostateèná práva.  Tento pokus byl zaznamenán.  Prosím <a href=\"{$_CONF["site_admin_url"]}/story.php\">vra»te se na administraci èlánkù</a>.",
	43 => 'Nový èlánek',
	44 => 'Administrace',
	45 => 'Pøístup',
    46 => '<b>PAMATUJTE:</b> pokud zadáte datum v budoucnosti, tento èlánek nebude publikován do tohoto data.  To znamená, ¾e èlánek nebude vidìt ani nebude zahrnut do vyhledávání a do statistiky stránek pøed tímto datem.',
    47 => 'Upload obrázkù',
    48 => 'obrázek',
    49 => 'vpravo',
    50 => 'vlevo',
    51 => 'k pøidání obrázkù (max. velikost 200x200px) do èlánku musíte vlo¾it speciálnì formátovaný text.<br>Tento text vypadá takto: [obrázekX](systém umístí sám), [obrázekX_vpravo](systém umístí vpravo od textu) nebo [obrázekX_vlevo](systém umístí vlevo od textu) - kde X je èíslo obrázku je¾ je pøidáván.<br>PAMATUJTE: musíte pou¾ít obrázky je¾ jsou pøidávány.  V opaèném pøípadì nebude mo¾no publikovat èlánek.<BR><P><B>NÁHLED</B>: Pro náhled èlánku s obrázky je nejlépe pou¾ít náhled Verze pro tiskárnu.  Tlaèítko <i>náhled</i> prosím pou¾ívejte jen pro prohlí¾ení èlánkù bez obrázkù.',
    52 => 'Smazat',
    53 => ' nepou¾ito.  Pøed ulo¾ením zmìn musíte vlo¾it obrázek do Intro textu nebo textu.',
    54 => 'Pøidaný obrázek nepou¾it',
    55 => 'Následující chyby se vyskytly pøi publikaci va¹eho èlánku.  Prosím opravte tyto chyby pøed koneènou publikací.',
    56 => 'Ikona Sekce.'
);

###############################################################################
# poll.php

$LANG25 = array(
	1 => "Re¾im",
	2 => "",
	3 => "Anketa vytvoøena",
	4 => "Anketa $qid ulo¾ena",
	5 => "Editovat anketu",
	6 => "ID ankety",
	7 => "(bez mezer)",
	8 => "Zobrazit na Homepage",
	9 => "Otázka",
	10 => "Odpovìdí / Hlasujících",
	11 => "There was an Chyba getting poll answer data about the poll $qid",
	12 => "There was an Chyba getting poll question data about the poll $qid",
	13 => "Vytvoøit anketu",
	14 => "ulo¾it",
	15 => "zru¹it akci",
	16 => "smazat",
	17 => "",
	18 => "Ankety",
	19 => "Pro editaci nebo smazání ankety, klepnìte na anketu ní¾e.  Pro vytvoøení nové ankety klepnìte na Nová anketa vý¹e.",
	20 => "Hlasujících",
	21 => "Pøístup odepøen",
	22 => "You are trying to access a poll that you don't have rights to.  This attempt has been logged. Please <a href=\"{$_CONF["site_admin_url"]}/poll.php\">go back to the poll administration screen</a>.",
	23 => 'Nová anketa',
	24 => 'Administrace',
	25 => 'Ano',
	26 => 'Ne'
);

###############################################################################
# topic.php

$LANG27 = array(
	1 => "Editor sekcí",
	2 => "ID sekce",
	3 => "Jméno sekce",
	4 => "Ikona sekce",
	5 => "(bez mezer)",
	6 => "Smazání sekce zpùsobí smazání èlánkù a komentáøù k nim i její ikony!",
	7 => "Prosím vyplòte ID sekce a Jméno sekce",
	8 => "Mana¾er sekcí",
	9 => "Pro úpravu a smazání sekce klepnìte na její jméno ní¾e.  Pro vytvoøení nové sekce klepnìte na Nová sekce vý¹e.",
	10=> "poøadí",
	11 => "èlánkù/stránku",
	12 => "Pøístup odepøen",
	13 => "Pokou¹íte se editovat sekci na ní¾ nemáte dostateèná práva.  Tento pokus byl zaznamenán. Prosím <a href=\"{$_CONF["site_admin_url"]}/topic.php\">vra»te se na administraci sekcí</a>.",
	14 => "typ øazení",
	15 => "abecednì",
	16 => "nastaveno",
	17 => "Nová sekce",
	18 => "Administrace",
    19 => 'ulo¾it',
    20 => 'zru¹it akci',
    21 => 'smazat'
);

###############################################################################
# user.php

$LANG28 = array(
	1 => "Editor u¾ivatelù",
	2 => "ID u¾ivatele",
	3 => "U¾ivatel",
	4 => "Jméno u¾ivatele",
	5 => "Heslo",
	6 => "Úroveò práv",
	7 => "Emailová adresa",
	8 => "Homepage",
	9 => "(bez mezer)",
	10 => "Please fill in the U¾ivatel, Full name, Security Level and Email Address fields",
	11 => "Mana¾er u¾ivatelù",
	12 => "To modify or smazat a user, click on that user below.  To create a new user click the new user button to the left. You can do simple searches by entering parts of a U¾ivatel,email address or fullname (e.g.*son* or *.edu) in the form below.",
	13 => "Úroveò práv",
	14 => "Datum registrace",
	15 => 'Nový u¾ivatel',
	16 => 'Administrace',
	17 => 'zmìna hesla',
	18 => 'zru¹it akci',
	19 => 'smazat',
	20 => 'ulo¾it',
	18 => 'zru¹it akci',
	19 => 'smazat',
	20 => 'ulo¾it',
    21 => 'U¾ivatel ji¾ existuje.',
    22 => 'Chyba',
    23 => 'Hromadné pøidání',
    24 => 'Hromadné pøidání u¾ivatelù',
    25 => 'You can import a batch of users into Geeklog.  The import file must a tab-delimited text file and must have the fields in the following order: full name, U¾ivatel, email address.  Each user you import will be emailed with a random Heslo.  You must have one user entered per line.  Failure to follow these instructions will cause problems that may require manual work so double check your entries!',
    26 => 'Hledat',
    27 => 'Omezit na',
    28 => 'Za¹krtnout pro smazání obrázku',
    29 => 'Cesta',
    30 => 'Import',
    31 => 'Noví u¾ivatelé',
    32 => 'HOTOVO. Importováno $successes a vyskytlo se $failures chyb.',
    33 => 'Potvrdit',
    34 => 'Chyba: Specifikujte soubor.'
);


###############################################################################
# moderation.php

$LANG29 = array(
    1 => "Potvrdit",
    2 => "Smazat",
    3 => "Editovat",
    4 => 'Profil',
    10 => "Titulek",
    11 => "Datum zaèátku",
    12 => "URL",
    13 => "Kategorie",
    14 => "Datum",
    15 => "Sekce",
    16 => 'Jméno u¾ivatele',
    17 => 'Celé jméno u¾ivatele',
    18 => 'Email',
    34 => "Administrace weblogu",
    35 => "Pøidání èlánku",
    36 => "Pøidání odkazu",
    37 => "Pøidání události",
    38 => "Pøidat",
    39 => "Nyní zde není nic k moderování",
    40 => "Publikace u¾ivatele"
);

###############################################################################
# calendar.php

$LANG30 = array(
	1 => "nedìle",
	2 => "pondìlí",
	3 => "úterý",
	4 => "støeda",
	5 => "ètvrtek",
	6 => "pátek",
	7 => "sobota",
	8 => "Pøidat událost",
	9 => "Události weblogu",
	10 => "Události u¾ivatele",
	11 => "Veøejný kalendáø",
	12 => "Osobní kalendáø",
	13 => "leden",
	14 => "únor",
	15 => "bøezen",
	16 => "duben",
	17 => "kvìten",
	18 => "èerven",
	19 => "èervenec",
	20 => "srpen",
	21 => "záøí",
	22 => "øíjen",
	23 => "listopad",
	24 => "prosinec",
	25 => "Zpìt na ",
    26 => "Ka¾dý den",
    27 => "Týden",
    28 => "Osobní kalendáø pro",
    29 => "Veøejný kalendáø",
    30 => "smazat událost",
    31 => "Pøidat událost",
    32 => "Událost",
    33 => "Datum",
    34 => "Èas",
    35 => "Rychlé pøidání",
    36 => "Potvrdit",
    37 => "Promiòte, Osobní kalendáø není na t¹chto stránkách podporován",
    38 => "Editor osobních událostí",
    39 => 'Den',
    40 => 'Týden',
    41 => 'Mìsíc'
);

###############################################################################
# admin/mail.php
$LANG31 = array(
 	1 => $_CONF['site_name'] . " - zasílání emailù",
 	2 => "Od",
 	3 => "Zpìtná  adresa",
 	4 => "Hlavièka",
 	5 => "Zpráva",
 	6 => "Poslat:",
 	7 => "V¹em u¾ivatelùm",
 	8 => "Admin",
	9 => "Mo¾nosti",
	10 => "HTML",
 	11 => "Urgentní zpráva!",
 	12 => "Poslat",
 	13 => "Smazat",
 	14 => "Ignorovat u¾iv. nastavení",
 	15 => "Chyba pøi zasílání: ",
	16 => "Zasláno: ",
	17 => "<a href=" . $_CONF["site_admin_url"] . "/mail.php>Poslat dal¹í zprávu</a>",
    18 => "Pro",
    19 => "POZOR: chcete-li zaslat zprávu v¹em u¾ivatelùm, vyberte Logged-in Users skupinu z roletové nabídky.",
    20 => "Odesláno <successcount> zpráv a nezasláno <failcount> zpráv.  Detaily jsou ní¾e u ka¾dého pokusu o zaslání zvlá¹».  Mù¾ete se pokusit znovu <a href=\"" . $_CONF['site_admin_url'] . "/mail.php\">zaslat zprávu</a> nebo <a href=\"" . $_CONF['site_admin_url'] . "/moderation.php\">se vrátit na stránku administrace</a>.",
    21 => 'Chyby',
    22 => 'Úspì¹nì',
    23 => 'Bez chyb',
    24 => 'Neúspì¹nì',
    25 => '- Vybrat skupinu -',
    26 => "Prosím vyplòte v¹echna pole ve formuláøi a vyberte skupinu u¾ivatelù z roletové nabídky."
);


###############################################################################
# confirmation and error messages

$MESSAGE = array (
	1 => "Va¹e pøihla¹ovací heslo Vám bylo zasláno na zadanou adresu. Prosím následujte prosté instrukce v po¹tì. Dìkujeme Vám za úèast na " . $_CONF["site_name"],
	2 => "Dìkujeme za pøidání èlánku na {$_CONF["site_name"]}..",
	3 => "Dìkujeme za pøidání odkazu na {$_CONF["site_name"]}..",
	4 => "Dìkujeme za pøidání události na  {$_CONF["site_name"]}..",
	5 => "Va¹e informace o úètu byly ulo¾eny.",
	6 => "Va¹e vlastní nastavení bylo ulo¾eno.",
	7 => "Va¹e nastavení komentáøù bylo ulo¾eno.",
	8 => "Byl jste úspì¹nì odhlá¹en.",
	9 => "Èlánek byl ulo¾en.",
	10 => "Èlánek byl vymazán.",
	11 => "Bloky byly ulo¾eny.",
	12 => "Blok byl odstranìn.",
	13 => "Sekce byla ulo¾ena.",
	14 => "Sekce a èlánky s komentáøi v ní byla smazána.",
	15 => "Odkaz byl ulo¾en.",
	16 => "Odkaz byl odstranìn.",
	17 => "Událost byla ulo¾ena.",
	18 => "Událost byla odstranìna.",
	19 => "Anketa byla ulo¾ena.",
	20 => "Anketa byla odstranìna.",
	21 => "U¾ivatel byl pøidán/zmìnìn.",
	22 => "U¾ivatel byl odstranìn.",
	23 => "Chyba v pøidávání události do Osobního kalendáøe. Neexistujíci ID události.",
	24 => "Událost bylo vlo¾ena do va¹eho kalendáøe",
	25 => "Pro otevøení osobního kalendáøe musíte být pøihlá¹en",
	26 => "Událost byla vymazána z va¹eho kalendáøe",
	27 => "Vzkaz poslán.",
	28 => "The plug-in has been successfully saved",
	29 => "Promiòte, Osobní kalendáø není na t¹chto stránkách podporován",
	30 => "Pøístup odepøen",
	31 => "Nemáte práva pøístupu k administraci èlánkù.  V¹echny neoprávnìné po¾adavky a pøístupy jsou zaznamenávány",
	32 => "Nemáte práva pøístupu k administraci sekcí.  V¹echny neoprávnìné po¾adavky a pøístupy jsou zaznamenávány",
	33 => "Nemáte práva pøístupu k administraci blokù.  V¹echny neoprávnìné po¾adavky a pøístupy jsou zaznamenávány",
	34 => "Nemáte práva pøístupu k administraci odkazù.  V¹echny neoprávnìné po¾adavky a pøístupy jsou zaznamenávány",
	35 => "Nemáte práva pøístupu k administraci událostí.  V¹echny neoprávnìné po¾adavky a pøístupy jsou zaznamenávány",
	36 => "Nemáte práva pøístupu k administraci anket.  V¹echny neoprávnìné po¾adavky a pøístupy jsou zaznamenávány",
	37 => "Nemáte práva pøístupu k administraci u¾ivatelù.  V¹echny neoprávnìné po¾adavky a pøístupy jsou zaznamenávány",
	38 => "Nemáte práva pøístupu k administraci pluginù.  V¹echny neoprávnìné po¾adavky a pøístupy jsou zaznamenávány",
	39 => "Nemáte práva pøístupu k administraci enailových u¾ivatelù.  V¹echny neoprávnìné po¾adavky a pøístupy jsou zaznamenávány",
	40 => "Systémové zprávy",
    41 => "Nemáte práva pøístupu k administraci slov.  V¹echny neoprávnìné po¾adavky a pøístupy jsou zaznamenávány",
    42 => "Va¹e slovo bylo ulo¾eno.",
	43 => "Slovo bylo smazáno.",
    44 => 'The plug-in was successfully installed!',
    45 => 'The plug-in was successfully deleted.',
    46 => "Nemáte práva pøístupu k database backup utilitì.  V¹echny neoprávnìné po¾adavky a pøístupy jsou zaznamenávány",
    47 => "This functionality only works under *nix.  If you are running *nix as your operating system then your cache has been successfully cleared. If you are on Windows, you will need to search for files name adodb_*.php and remove them manually.",
    48 => 'Dìkujeme za registraci na ' . $_CONF['site_name'] . '.  Va¹e heslo pro pøístup do systému Vám bylo zasláno na email, který jste zadali.',
    49 => "Skupina byla úspì¹nì ulo¾ena.",
    50 => "Skupina byla úspì¹nì smazána."
);

// for plugins.php

$LANG32 = array (
	1 => "Installing plugins could possibly cause damage to your Geeklog installation and, possibly, to your system.  It is important that you only install plugins downloaded from the <a href=\"http://www.geeklog.net\" target=\"_blank\">Geeklog Homepage</a> as we thoroughly test all plugins submitted to our site on a variety of operating systems.  It is important that you understand that the plugin installation process will require the execution of a few filesystem commands which could lead to security problems particularly if you use plugins from third party sites.  Even with this warning you are getting, we do not gaurantee the success of any installation nor are we liable for damage caused by installing a Geeklog plugin.  In other words, install at your own risk.  For the wary, directions on how to manually install a plugin is included with each plugin package.",
	2 => "Plug-in Installation Disclaimer",
	3 => "Plug-in Installation Form",
	4 => "Plug-in File",
	5 => "Plug-in List",
	6 => "Warning: Plug-in Already Installed!",
	7 => "The plug-in you are trying to install already exists.  Please delete the plugin before re-installing it",
	8 => "Plugin Compatibility Check Failed",
	9 => "This plugin requires a newer version of Geeklog. Either upgrade your copy of <a href=\"http://www.geeklog.net\">Geeklog</a> or get a newer version of the plug-in.",
	10 => "<br><b>There are no plugins currently installed.</b><br><br>",
	11 => "To modify or delete a plug-in, click on that plug-in's number below. To learn more about a plug-in, click the plug-in name and you will be directed to that plug-in's website. To install or upgrade a plug-in please consult it's documentation.",
	12 => 'no plugin name provided to plugineditor()',
	13 => 'Plugin Editor',
	14 => 'New Plug-in',
	15 => 'Administrace',
	16 => 'Plug-in Name',
	17 => 'Plug-in Version',
	18 => 'Geeklog Version',
	19 => 'Enabled',
	20 => 'Yes',
	21 => 'No',
	22 => 'Install',
  23 => 'ulo¾it',
  24 => 'zru¹it akci',
  25 => 'smazat',
  26 => 'Plug-in Name',
  27 => 'Plug-in Homepage',
  28 => 'Plug-in Version',
  29 => 'Geeklog Version',
  30 => 'smazat Plug-in?',
  31 => 'Are you sure you want to delete this plug-in?  By doing so you will remove all the data and data structures that this plug-in uses.  If you are sure, click delete again on the form below.'
);

$LANG_ACCESS = array(
	access => "Práva",
    ownerroot => "Vlastník-Root",
    group => "Skupina",
    readonly => "Jen pro ètení",
	accessrights => "Pøístupová práva",
	owner => "Vlastník",
	grantgrouplabel => "Zaruèuje práva vy¹¹í ne¾ práva skupiny pro editaci",
	permmsg => "PAMATUJTE: <i>u¾ivatelé</i> jsou pøihlá¹ení u¾ivatelé weblogu a <i>hosté</i> jsou v¹ichni, kdo si prohlí¾ejí weblog bez pøihlá¹ení.",
	securitygroups => "Skupiny/Úroveò práv",
	editrootmsg => "Even though you are a User Administrator, you can't edit a root user without first being a root user yourself.  You can edit all other users except root users. Please note that all attempts to illegally edit root users are logged.  Please go back to the <a href=\"{$_CONF["site_admin_url"]}/user.php\">User Administration page</a>.",
	securitygroupsmsg => "Select the checkboxes for the groups you want the user to belong to.",
	groupeditor => "Editor skupin u¾ivatelù",
	description => "Popis",
	name => "Jméno",
 	rights => "Práva",
	missingfields => "Chybìjící pole",
	missingfieldsmsg => "You must supply the name and a description for a group",
	groupmanager => "Mana¾er skupin u¾ivatelù",
	newgroupmsg => "To modify or delete a group, click on that group below. To create a new group click new group above. Please note that core groups cannot be deleted because they are used v systému.",
	groupname => "Jméno skupiny u¾ivatelù",
	coregroup => "Hlavní skupina",
	yes => "Ano",
	no => "Ne",
	corerightsdescr => "This group is a core {$_CONF["site_name"]} Group.  Therefore the rights for this group cannot be edited.  Below is a read-only list of the rights this group has access to.",
	groupmsg => "Security Groups on this site are hierarchical.  By adding this group to any of the groups below you will giving this group the same rights that those groups have.  Where possible it is encouraged you use the groups below to give rights to a group.  If you need this group to have custom rights then you can select the rights to various site features in the section below called 'Rights'.  To add this group to any of the ones below simply check the box next to the group(s) that you want.",
	coregroupmsg => "This group is a core {$_CONF["site_name"]} Group.  Therefore the groups that this groups belongs to cannot be edited.  Below is a read-only list of the groups this group belongs to.",
	rightsdescr => "A groups access to a certain right below can be given directly to the group OR to a different group that this group is a part of.  The ones you see below without a checkbox are the rights that have been given to this group because it belongs to another group with that right.  The rights with checkboxes below are rights that can be given directly to this group.",
	lock => "Uzamèeno",
	members => "U¾ivatelé",
	anonymous => "Hosté",
	permissions => "Pøidìlení oprávnìní",
	permissionskey => "R = ètení, E = editace, editaèní práva v sobì zahrnují i právo èíst!",
	edit => "Editace",
	none => "Není",
	accessdenied => "Pøístup odepøen",
	storydenialmsg => "You do not have access to view this story.  This could be because you aren't a member of {$_CONF["site_name"]}.  Please <a href=users.php?mode=new> become a member</a> of {$_CONF["site_name"]} to receive full membership access!",
	eventdenialmsg => "You do not have access to view this event.  This could be because you aren't a member of {$_CONF["site_name"]}.  Please <a href=users.php?mode=new> become a member</a> of {$_CONF["site_name"]} to receive full membership access!",
	nogroupsforcoregroup => "This group doesn't belong to any of the other groups",
	grouphasnorights => "This group doesn't have access to any of the administrative features of this site",
	newgroup => 'Nová skupina u¾ivatelù',
	adminhome => 'Administrace',
	save => 'ulo¾it',
	cancel => 'zru¹it akci',
	delete => 'smazat',
	canteditroot => 'You have tried to edit the Root group but you are not in the Root group yourself therefore your access to this group is denied.  Please contact the system administrator if you feel this is Chyba'	
);

#admin/word.php
$LANG_WORDS = array(
    editor => "Word Replacment editor",
    wordid => "Word ID",
    intro => "To modify or delete a word, click on that word.  To create a new word replacement click the new word button to the left.",
    wordmanager => "Word Manager",
    word => "Word",
    replacmentword => "Replacment Word",
    newword => "New Word"
);

$LANG_DB_BACKUP = array(
    last_ten_backups => 'Last 10 Back-ups',
    do_backup => 'Do Backup',
    backup_successful => 'Database back up was successful.',
    no_backups => 'Nejsou ¾ádné zálohy systému',
    db_explanation => 'To create a new backup of your Geeklog system, hit the button below',
    not_found => "Incorrect path or mysqldump utility not executable.<br>Check <strong>\$_DB_mysqldump_path</strong> definition in config.php.<br>Variable currently defined as: <var>{$_DB_mysqldump_path}</var>",
    zero_size => 'Backup Failed: Filesize was 0 bytes',
    path_not_found => "{$_CONF['backup_path']} does not exist or is not a directory",
    no_access => "Chyba: Directory {$_CONF['backup_path']} is not accessible.",
    backup_file => 'Backup file',
    size => 'Size',
    bytes => 'Bytes'
);

$LANG_BUTTONS = array(
    1 => "Homepage",
    2 => "Kontakt",
    3 => "Publikovat",
    4 => "Odkazy",
    5 => "Ankety",
    6 => "Kalendáø",
    7 => "Statistika",
    8 => "Vlastní nastavení",
    9 => "Hledání",
    10 => "roz¹íøené hledání"
);

$LANG_404 = array(
    1 => "404 Error",
    2 => "Gee, I've looked everywhere but I can not find <b>%s</b>.",
    3 => "<p>We're sorry, but the file you have requested does not exist. Please feel free to check the <a href=\"{$_CONF['site_url']}\">main page</a> or the <a href=\"{$_CONF['site_url']}/search.php\">search page</a> to see if you can find what you lost."
);

$LANG_LOGIN = array (
    1 => 'Je nutné se pøihlásit',
    2 => 'Promiòte, pro pøístup je nutné být pøihlá¹en jako u¾ivatel.',
    3 => 'Pøihlásit',
    4 => 'Nový u¾ivatel'
);

?>
