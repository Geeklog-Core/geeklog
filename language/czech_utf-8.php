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

$LANG_CHARSET = 'UTF-8';

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
    1 => 'Publikoval :',
    2 => '<b>Číst celé</b>',
    3 => 'komentářů',
    4 => 'Editovat',
    5 => 'Anketa',
    6 => 'Výsledky',
    7 => 'Výsledky ankety',
    8 => 'hlasů',
    9 => 'Administrátorské funkce:',
    10 => 'Příspěvky',
    11 => 'Články',
    12 => 'Bloky',
    13 => 'Sekce',
    14 => 'Odkazy',
    15 => 'Události',
    16 => 'Ankety',
    17 => 'Uživatelé',
    18 => 'SQL dotaz',
    19 => '<b>Odhlásit</b>',
    20 => 'Informace o uživateli:',
    21 => 'Uživatel',
    22 => 'Uživatelův ID',
    23 => 'Úroveň práv',
    24 => 'Anonymní host',
    25 => 'Odpověď',
    26 => ' Následující komentáře jsou názorem jejich vkladatele. <br>Weblog neručí za to co je zde napsáno.',
    27 => 'Naposledy přidáno',
    28 => 'Smazat',
    29 => 'Nejsou žádné komentáře.',
    30 => 'Starší články',
    31 => 'HTML tagy povoleny:',
    32 => 'Chyba, neplatné uživatelské jméno',
    33 => 'Chyba, nepovolený zápis do log fajlu',
    34 => 'Chyba',
    35 => 'Odhlásit',
    36 => ' - ',
    37 => 'Bez článků',
    38 => 'Content Syndication',
    39 => 'Obnovit',
    40 => 'You have <tt>register_globals = Off</tt> in your <tt>php.ini</tt>. However, Geeklog requires <tt>register_globals</tt> to be <strong>on</strong>. Before you continue, please set it to <strong>on</strong> and restart your web server.',
    41 => 'Hosté',
    42 => 'Publikováno:',
    43 => 'Odpovědět na toto',
    44 => 'Nadřazený',
    45 => 'MySQL Error Number',
    46 => 'MySQL Error Message',
    47 => 'Uživatelské menu',
    48 => 'Informace o účtu',
    49 => 'Vlastní nastavení',
    50 => 'Error with SQL statement',
    51 => 'help',
    52 => 'Nové',
    53 => 'Administrace',
    54 => 'Nelze otevřít soubor.',
    55 => 'Nastala chyba - ',
    56 => 'Hlasovat',
    57 => 'Heslo',
    58 => 'Přihlásit',
    59 => "Nemáte zatím účet?  Přihlašte se jako <a href=\"{$_CONF['site_url']}/users.php?mode=new\"><b>Nový&nbsp;uživatel</b></a>",
    60 => 'Okomentovat',
    61 => 'Nový uživatel',
    62 => 'slov',
    63 => 'Nastavení komentářů',
    64 => 'Poslat emailem',
    65 => 'Verze pro tiskárnu',
    66 => 'Osobní kalendář',
    67 => 'Vítejte na ',
    68 => 'home',
    69 => 'kontakt',
    70 => 'hledat',
    71 => 'příspěvky',
    72 => 'odkazy',
    73 => 'ankety',
    74 => 'kalendář',
    75 => 'rozšířené hledání',
    76 => 'statistika',
    77 => 'Pluginy',
    78 => 'Blížící se události',
    79 => 'Co je nového',
    80 => 'článků za posledních',
    81 => 'článek za posledních',
    82 => 'hodin',
    83 => 'KOMENTÁŘE',
    84 => 'ODKAZY',
    85 => 'za posledních 48 hodin',
    86 => 'Nejsou nové komentáře',
    87 => 'za poslední 2 týdny',
    88 => 'Nejsou nové odkazy',
    89 => 'Nejsou žádné blížící se události',
    90 => 'Homepage',
    91 => 'Stránka vytvořena za',
    92 => 'sekund&nbsp;',
    93 => 'Copyright',
    94 => 'Všechna práva a ochranné známky na těchto stránkách patří jejich vlastníkům.',
    95 => 'Používáme',
    96 => 'Skupiny',
    97 => 'Word List',
    98 => 'Pluginy',
    99 => 'ČLÁNKY',
    100 => 'Nejsou nové články',
    101 => 'Osobní události',
    102 => 'Události weblogu',
    103 => 'DB zálohy',
    104 => '-',
    105 => 'Emailový démon',
    106 => 'Zhlédnuto',
    107 => 'Test Verze GL',
    108 => 'Smazat cache',
    109 => 'Report abuse',
    110 => 'Report this post to the site admin',
    111 => 'View PDF Version',
    112 => 'Registered Users',
    113 => 'Documentation',
    114 => 'TRACKBACKS',
    115 => 'No new trackback comments',
    116 => 'Trackback',
    117 => 'Directory',
    118 => 'Please continue reading on the next page:',
    119 => "Lost your <a href=\"{$_CONF['site_url']}/users.php?mode=getpassword\">password</a>?",
    120 => 'Permanent link to this comment',
    121 => 'Comments (%d)',
    122 => 'Trackbacks (%d)',
    123 => 'All HTML is allowed'
);

###############################################################################
# calendar.php

$LANG02 = array(
    1 => 'Kalendář',
    2 => 'Nejsou žádné události k zobrazení.',
    3 => 'Kdy',
    4 => 'Kde',
    5 => 'Popis',
    6 => 'Přidat událost',
    7 => 'Blížící se události',
    8 => 'Když toto přidáte do Osobního kalendáře, uvidíte je jen Vy ve svém Osobním kalendáři v Uživatelských funkcích.',
    9 => 'Přidat do osobního kalendáře',
    10 => 'Odebrat z osobního kalendáře',
    11 => "Přidání události do kalendáře {$_USER['username']}'",
    12 => 'Událost',
    13 => 'Začíná',
    14 => 'Končí',
    15 => 'Zpět na kalendář'
);

###############################################################################
# comment.php

$LANG03 = array(
    1 => 'Vložit komentář',
    2 => 'Typ komentáře',
    3 => 'Odhlásit',
    4 => 'Vytvořit účet',
    5 => 'Uživatel',
    6 => 'Tato stránka vyžaduje přihlášení pro vložení komentáře, prosím přihlašte se.  Pokud nemáte účet - můžete si ho vytvořit.',
    7 => 'Váš poslední komentář vložen před ',
    8 => " sekundami.  Tato stránka vyžaduje prodlevu {$_CONF['commentspeedlimit']} sekund mezi komentáři.",
    9 => 'Komentář',
    10 => 'Send Report',
    11 => 'Vložit komentář',
    12 => 'Prosím vyplňte Titulek a Komentář, jinak nelze vložit.',
    13 => 'Vaše info',
    14 => 'Náhled',
    15 => 'Report this post',
    16 => 'Titulek',
    17 => 'Chyba',
    18 => 'Důležité',
    19 => 'Prosím vkládejte komentáře do správné sekce.',
    20 => 'Komentáře vkládejte pokud možno ve správném pořadí.',
    21 => 'Přečtěte si prosím nejdříve komentáře ostatních uživatelů, aby nedocházelo k duplicitě.',
    22 => 'Použijte titulek, který vložil systém.',
    23 => 'Váš email nebude publikován!',
    24 => 'Anonymní host',
    25 => 'Are you sure you want to report this post to the site admin?',
    26 => '%s reported the following abusive comment post:',
    27 => 'Abuse report'
);

###############################################################################
# users.php

$LANG04 = array(
    1 => 'Uživatelský profil:',
    2 => 'Přihlašovací jméno',
    3 => 'Jméno',
    4 => 'Heslo',
    5 => 'Email',
    6 => 'Homepage',
    7 => 'O vás',
    8 => 'PGP klíč',
    9 => 'Uložit změny',
    10 => 'Posledních 10 comentářů uživatele',
    11 => 'Bez komentářů uživatele',
    12 => 'Uživatelské nastavení:',
    13 => 'Posílat na konci každého dne výtah z weblogu emailem',
    14 => 'Toto heslo bylo náhodně vygenerováno systémem. Doporučuje se změnit co nejdříve. Pro změnu hesla se přihlašte a změnte si ho poté v menu Informace o účtu v Uživatelském rozhraní.',
    15 => "Váš {$_CONF['site_name']} účet byl vytvořen. Můžete se přihlásit, níže jsou Vaše přihlašovací data. Prosím uschovejt si tento email pro budoucí reference.",
    16 => 'Informace o účtu',
    17 => 'Účet neexistuje',
    18 => 'Email se zdá být v nesprávném formátu',
    19 => 'Uživatel nebo email již existuje',
    20 => 'Email se zdá být v nesprávném formátu',
    21 => 'Chyba',
    22 => "Registrace na {$_CONF['site_name']}!",
    23 => "Anonymní uživatelé - Hosté nemohou například komentovat či přidávat články.<br>Vytvoření účtu Vám umožní využívat všech funkcí na {$_CONF['site_name']}. <br>Vaše emailová adresa nebude <b><i>nikdy a nikde</i></b> zveřejněna na těchto stránkách.",
    24 => 'Vaše heslo bude posláno na vámi zadanou emailovou adresu.',
    25 => 'Zapomenuté heslo?',
    26 => 'Vložte Vaše přihlašovací jméno a klepněte na Poslat-heslo a nové heslo Vám bude zasláno na Vámi zadanou emailovou adresu.',
    27 => 'Registrovat nyní!',
    28 => 'Poslat-heslo',
    29 => 'odhlášen od',
    30 => 'přihlášen od',
    31 => 'Tato funkce vyžaduje přihlášení',
    32 => 'Podpis',
    33 => 'Nezobrazí se veřejně',
    34 => 'Toto je vaše pravé jméno',
    35 => 'Jen pro změnu hesla',
    36 => 'Na začátku s http://',
    37 => 'Bude použit v komentářích',
    38 => 'Toto je o Vás! Kdokoli si to může přečíst',
    39 => 'Váš veřejný PGP klíč',
    40 => 'Bez ikon Sekcí',
    41 => 'Chci být Moderátorem sekce',
    42 => 'Formát data',
    43 => 'Maximální počet článků',
    44 => 'Bez bloků',
    45 => 'Vlastní nastavení pro',
    46 => 'Bez těchto položek pro',
    47 => 'Nastavení bloků pro',
    48 => 'Sekce',
    49 => 'Nezobrazovat ikony',
    50 => 'Odškrtněte pokud vás nezajímá',
    51 => 'Jen novinky',
    52 => 'Systémové nastavení - ',
    53 => 'Dostávat články na konci dne emailem',
    54 => 'Zaškrtněte to co nechcete zobrazovat.',
    55 => 'Pokud necháte odškrtlé, bude použito původní nastavení - to co je tučně bude zobrazováno.  Pro vlastní nastavení zaškrtněte jen to co chcete zobrazovat.',
    56 => 'Autoři',
    57 => 'Nastavení zobrazování položek pro',
    58 => 'Řazení',
    59 => 'Maximální počet komentářů',
    60 => 'Jak chcete zobrazovat komentáře?',
    61 => 'Nejnovější nebo nejstarší nejdříve?',
    62 => 'Systémové nastavení - 100',
    63 => "Vaše heslo bude posláno na vámi zadanou emailovou adresu. Postupujte podle zaslaných instrukcí pro přihlášení do {$_CONF['site_name']}",
    64 => 'Nastavení komentářů pro',
    65 => 'Zkuste se přihlásit znovu',
    66 => "Spletl jste se v zadání.  Prosím zkuste to znovu. Nebo jste  <a href=\"{$_CONF['site_url']}/users.php?mode=new\"><b>nový uživatel</b></a>?",
    67 => 'Uživatelem od',
    68 => 'Pamatovat si mne',
    69 => 'Jak dlouho si Vás systém bude pamatovat.',
    70 => "Přizpůsobení vzhledu a obsahu {$_CONF['site_name']}",
    71 => "Přizpůsobení vzhledu na {$_CONF['site_name']} vám umožní nastavit si vlastní vzhled a řazení položek nezávisle na nastavení pro hosty.  Pro tato nastavení se musíte <a href=\"{$_CONF['site_url']}/users.php?mode=new\">přihlásit</a> na {$_CONF['site_name']}. <br> Jste uživatelem?  Pak použijte přihlašovací formulář vlevo!",
    72 => 'Grafické téma',
    73 => 'Jazyk',
    74 => 'Vyberte jak má weblog vypadat',
    75 => 'Zasílání sekcí',
    76 => 'Tyto sekce vám budou zasílána emailem koncem každého dne. Prosím vybírejte jen sekce, které vás zajímají!',
    77 => 'Foto',
    78 => 'Přidá Vaše foto (do velikosti 96x96px)!',
    79 => 'Zaškrtnout pro smazání fota',
    80 => 'Přihlásit',
    81 => 'Zaslat email',
    82 => 'Posledních 10 článků uživatele',
    83 => 'Publikační statistika uživatele',
    84 => 'Celkově publikací:',
    85 => 'Celkově komentářů:',
    86 => 'Najít vše od',
    87 => 'Your login name',
    88 => "Someone (possibly you) has requested a new password for your account \"%s\" on {$_CONF['site_name']}, <{$_CONF['site_url']}>.\n\nIf you really want this action to be taken, please click on the following link:\n\n",
    89 => "If you do not want this action to be taken, simply ignore this message and the request will be disregarded (your password will remain unchanged).\n\n",
    90 => 'You can enter a new password for your account below. Please note that your old password is still valid until you submit this form.',
    91 => 'Set New Password',
    92 => 'Enter New Password',
    93 => 'Your last request for a new password was %d seconds ago. This site requires at least %d seconds between password requests.',
    94 => 'Delete Account "%s"',
    95 => 'Click the "delete account" button below to remove your account from our database. Please note that any stories and comments you posted under this account will <strong>not</strong> be deleted but show up as being posted by "Anonymous".',
    96 => 'delete account',
    97 => 'Confirm Account Deletion',
    98 => 'Are you sure you want to delete your account? By doing so, you will not be able to log into this site again (unless you create a new account). If you are sure, click "delete account" again on the form below.',
    99 => 'Privacy Options for',
    100 => 'Email from Admin',
    101 => 'Allow email from Site Admins',
    102 => 'Email from Users',
    103 => 'Allow email from other users',
    104 => 'Show Online Status',
    105 => 'Show up in Who\'s Online block',
    106 => 'Location',
    107 => 'Shown in your public profile',
    108 => 'Confirm new password',
    109 => 'Enter the New password again here',
    110 => 'Current Password',
    111 => 'Please enter your Current password',
    112 => 'You have exceeded the number of allowed login attempts.  Please try again later.',
    113 => 'Login Attempt Failed',
    114 => 'Account Disabled',
    115 => 'Your account has been disabled, you may not login. Please contact an Administrator.',
    116 => 'Account Awaiting Activation',
    117 => 'Your account is currently awaiting activation by an administrator. You will not be able to login until your account has been approved.',
    118 => "Your {$_CONF['site_name']} account has now been activated by an administrator. You may now login to the site at the url below using your username (<username>) and password as previously emailed to you.",
    119 => 'If you have forgotten your password, you may request a new one at this url:',
    120 => 'Account Activated',
    121 => 'Service',
    122 => 'Sorry, new user registration is disabled',
    123 => "Are you a <a href=\"{$_CONF['site_url']}/users.php?mode=new\">new user</a>?"
);

###############################################################################
# index.php

$LANG05 = array(
    1 => 'Nic nového k zobrazení',
    2 => 'Žádné nové články k zobrazení.  Možná nejsou žádné novinky, nebo jste zadali špatné podmínky filtrování',
    3 => ' pro sekci %s',
    4 => 'Nejnovější článek',
    5 => 'Další',
    6 => 'Předešlé',
    7 => 'First',
    8 => 'Last'
);

###############################################################################
# profiles.php

$LANG08 = array(
    1 => 'Nastala chyba při odesílání emailu, zkuste to prosím znovu.',
    2 => 'Zpráva úspěšně odeslána.',
    3 => 'Zkontrolujte si prosím správnost emailové adresy.',
    4 => 'Prosím vyplňte všechna pole formuláře.',
    5 => 'Chyba: neexistující uživatel.',
    6 => 'Vznikla chyba.',
    7 => 'Uživatelský profil ',
    8 => 'Jméno',
    9 => 'URL stránek uživatele',
    10 => 'Poslat email uživateli ',
    11 => 'Vaše jméno:',
    12 => 'Poslat na:',
    13 => 'Hlavička:',
    14 => 'Zpráva:',
    15 => 'Použité HTML tagy nebudou změněny.<br>',
    16 => 'Poslat zprávu',
    17 => 'Poslat článek mailem',
    18 => 'Komu',
    19 => 'Kam',
    20 => 'Od koho',
    21 => 'Email odesilatele',
    22 => 'Prosím vyplňte všechna pole formuláře.',
    23 => "Tento email Vám byl poslán %s z %s protože si tento uživatel myslí, že by Vás mohl zaujmut.  Bylo publikováno na {$_CONF['site_url']}.   Toto NENÍ SPAM a Vaše emailová adresa nebyla nikde uložena a nebude tudíž použita k jakýmkoli účelům.",
    24 => 'Komentář k článku na',
    25 => 'Musíte být přihlášen jako uživatel pro použití této funkce weblogu.<br>  Touto restrikcí se předchází zneužití systému k spammingu!',
    26 => 'Tento formulář umožňuje zaslat email vybranému uživateli.  Vyplňte prosím všechna pole.',
    27 => 'Krátká zpráva',
    28 => '%s napsáno: ',
    29 => "Toto jsou denní novinky z {$_CONF['site_name']} pro ",
    30 => ' Denní novinky pro ',
    31 => 'Titulek',
    32 => 'Datum',
    33 => 'Celý článek si můžete přečíst na ',
    34 => 'Konec zprávy',
    35 => 'Sorry, this user prefers not to receive any emails.'
);

###############################################################################
# search.php

$LANG09 = array(
    1 => 'rozšířené hledání',
    2 => 'Klíčová slova',
    3 => 'Sekce',
    4 => 'Vše',
    5 => 'Typ',
    6 => 'Články',
    7 => 'Komentáře',
    8 => 'Autoři',
    9 => 'Vše',
    10 => 'Hledání',
    11 => 'Výsledky hledání',
    12 => 'odpovídající filtru',
    13 => 'Výsledky hledání: nic neodpovídá zadanému filtru',
    14 => 'Žádné výsledky neodpovídají zadanému filtru',
    15 => 'Prosím zkuste znovu.',
    16 => 'Titulek',
    17 => 'Datum',
    18 => 'Autor',
    19 => "Prohledat celou databázi nových i archivních položek na {$_CONF['site_name']}",
    20 => 'Datum',
    21 => 'do',
    22 => '(Formát data RRRR-MM-DD)',
    23 => 'Zhlédnuto',
    24 => 'Nalezeno',
    25 => 'filtru odpovídajících z celkem ',
    26 => 'položek během',
    27 => 'sekund',
    28 => 'Žádný článek nebo komentář neodpovídá zadanému filtru',
    29 => 'Výsledky vyhledávání článků a komentářů',
    30 => 'Žádné výsledky neodpovídají zadanému filtru',
    31 => 'This plug-in returned no matches',
    32 => 'Událost',
    33 => 'URL',
    34 => 'Umístění',
    35 => 'Celý den',
    36 => 'Žádné události neodpovídají zadanému filtru',
    37 => 'Výsledky hledání',
    38 => 'Výsledky hledání odkazů',
    39 => 'Odkazy',
    40 => 'Události',
    41 => 'Alespoň 3 znaky v poli vyhledávání.',
    42 => 'Prosím zadávejte datum v tomto formátu: RRRR-MM-DD (rok-měsíc-den).',
    43 => 'exact phrase',
    44 => 'all of these words',
    45 => 'any of these words',
    46 => 'Next',
    47 => 'Previous',
    48 => 'Author',
    49 => 'Date',
    50 => 'Hits',
    51 => 'Link',
    52 => 'Location',
    53 => 'Story Results',
    54 => 'Comment Results',
    55 => 'the phrase',
    56 => 'AND',
    57 => 'OR',
    58 => 'More results &gt;&gt;',
    59 => 'Results',
    60 => 'per page',
    61 => 'Refine search'
);

###############################################################################
# stats.php

$LANG10 = array(
    1 => 'Celková statistika stránek',
    2 => 'Souhrn požadavků na systém',
    3 => 'Články(komentáře) v systému',
    4 => 'Anket(odpovědí) v systému',
    5 => 'Odkazy(jejich následování) v systému',
    6 => 'Události v systému',
    7 => 'Top Ten články',
    8 => 'Titulek článku',
    9 => 'Zhlédnuto',
    10 => 'Žádné články zde nejsou.',
    11 => 'Top Ten komentovaných článků',
    12 => 'Komentáře',
    13 => 'Žádné komentované články zde nejsou.',
    14 => 'Top Ten anket',
    15 => 'Anketní otázka',
    16 => 'Hlasů',
    17 => 'Žádné ankety zde nejsou.',
    18 => 'Top Ten okazů',
    19 => 'Odkazy',
    20 => 'Zhlédnuto',
    21 => 'Žádné odkazy na které se klickalo zde nejsou.',
    22 => 'Top Ten emailem zaslaných článků',
    23 => 'Zasláno emailem',
    24 => 'Žádné emailem poslané články zde nejsou.',
    25 => 'Top Ten Trackback Commented Stories',
    26 => 'No trackback comments found.',
    27 => 'Number of active users',
    28 => 'Top Ten Events',
    29 => 'Event',
    30 => 'Hits',
    31 => 'It appears that there are no events on this site or no one has ever clicked on one.'
);

###############################################################################
# article.php

$LANG11 = array(
    1 => 'Související',
    2 => 'Poslat mailem',
    3 => 'Verze pro tiskárnu',
    4 => 'Volby článku',
    5 => 'PDF Story Format'
);

###############################################################################
# submit.php

$LANG12 = array(
    1 => 'Pro tento %s musíte být přihlášen jako uživatel.',
    2 => 'Přihlásit',
    3 => 'Nový uživatel',
    4 => 'Přidání',
    5 => 'Přidat odkaz',
    6 => 'Publikovat článek',
    7 => 'Vyžadováno přihlášení',
    8 => 'Publikování',
    9 => 'Pro publikování na těchto stránkách následujte prosím tato prostá doporučení: <ul><li>Vyplňte všechna povinná pole<li>Zadávejte kompletní a přesné informace<li>Dvakrát si zkontrolujte URL</ul>',
    10 => 'Titulek',
    11 => 'Odkaz',
    12 => 'Datum začátku',
    13 => 'Datum konce&nbsp;&nbsp;&nbsp;',
    14 => 'Umístění',
    15 => 'Popis',
    16 => 'Pokud je Jiné, specifikujte prosím',
    17 => 'Kategorie',
    18 => 'Jiné',
    19 => 'Přečtěte si',
    20 => 'Chyba: Chybí Kategorie',
    21 => 'Pokud vybráno "Jiné" vyberte prosím i kategorii',
    22 => 'Chyba: nevyplněná pole',
    23 => 'Prosím vyplňte všechna pole. Vše je povinné.',
    24 => 'Publikace provedena',
    25 => 'Vaše %s publikace byla provedena.',
    26 => 'Omezení rychlosti publikování',
    27 => 'Uživatel',
    28 => 'Sekce',
    29 => 'Článek',
    30 => 'Poslední publikace byla před ',
    31 => " sekundami.  Tato stránka vyžaduje {$_CONF['speedlimit']} sekund mezi publikacemi",
    32 => 'Náhled',
    33 => 'Náhled článku',
    34 => 'Odhlásit',
    35 => 'HTML tagy nejsou podporovány',
    36 => 'Typ publikace',
    37 => "Přidání události - {$_CONF['site_name']} přidá tuto do Veřejného kalendáře pokud si nevyberete jen přidání do Osobního kaendáře.<br><br>Pokud přidáte událost do Veřejného kalendáře bude tato po kontrole administrátorem zařazena do Veřejného kalendáře.",
    38 => 'Přidat událost do',
    39 => 'Veřejný kalendář',
    40 => 'Osobní kalendář',
    41 => 'Čas konce&nbsp;&nbsp;&nbsp;',
    42 => 'Čas začátku',
    43 => 'Každodenně',
    44 => 'Adresa 1',
    45 => 'Adresa 2',
    46 => 'Město',
    47 => 'Země',
    48 => 'Směrové číslo',
    49 => 'Typ události',
    50 => 'Ediovat typ události',
    51 => 'Umístění',
    52 => 'Smazat',
    53 => 'Vytvořit účet'
);

###############################################################################
# ADMIN PHRASES - These are file phrases used in admin scripts
###############################################################################

###############################################################################
# admin/auth.inc.php

$LANG20 = array(
    1 => 'Autentikace vyžadována',
    2 => 'Přístup odepřen! Nesprávné přihlašovací údaje',
    3 => 'Neplatné heslo pro uživatele',
    4 => 'Uživatel:',
    5 => 'Heslo:',
    6 => 'Každý přístup do administrátorské části stránek je zapisován do log_file a je tam také kontrolován.<br>Tato stránka je jen pro autorizované uživatele s administrátorskými právy.',
    7 => 'Přihlásit'
);

###############################################################################
# admin/block.php

$LANG21 = array(
    1 => 'Nedostatečná administrátorská práva',
    2 => 'Nemáte povolen přístup k této části administrace.',
    3 => 'Editor bloků',
    4 => 'There was a problem reading this feed (see error.log for details).',
    5 => 'Titulek bloku',
    6 => 'Sekce',
    7 => 'Vše',
    8 => 'Úroveň práv bloku',
    9 => 'Pořadí bloku',
    10 => 'Typ bloku',
    11 => 'Blok Portálu',
    12 => 'Normální blok',
    13 => 'Volby Bloku Portálu',
    14 => 'RDF URL',
    15 => 'Last RDF Update',
    16 => 'Volby bloku',
    17 => 'Obsah bloku',
    18 => 'Prosím vyplňte Titulek bloku, Úroveň práv a Obsah',
    19 => 'Manažer bloků',
    20 => 'Titulek bloku',
    21 => 'Úroveň práv bloku',
    22 => 'Typ bloku',
    23 => 'Pořadí bloku',
    24 => 'Sekce bloku',
    25 => 'Pro smazání a editaci bloku, klepněte na blok níže.  Pro vytvoření nového bloku klepněte na Nový blok výše.',
    26 => 'Vzhled bloku',
    27 => 'PHP Blok',
    28 => 'Volby PHP Bloku',
    29 => 'Funkce bloku',
    30 => 'If you would like to have one of your blocks use PHP code, enter the name of the function above.  Your function name must start with the prefix "phpblock_" (e.g. phpblock_getweather).  If it does not have this prefix, your function will NOT be called.  We do this to keep people who may have hacked your Geeklog installation from putting arbitrary function calls that may be harmful to your system.  Be sure not to put empty parenthisis "()" after your function name.  Finally, it is recommended that you put all your PHP Block code in /path/to/geeklog/system/lib-custom.php.  That will allow the code to stay with you even when you upgrade to a newer version of Geeklog.',
    31 => 'Chyba v PHP Bloku.  Funkce, %s, neexistuje.',
    32 => 'Chyba - neexistující pole',
    33 => 'You must enter the URL to the .rdf file for portal blocks',
    34 => 'You must enter the title and the function for PHP blocks',
    35 => 'You must enter the title and the content for normal blocks',
    36 => 'You must enter the content for layout blocks',
    37 => 'Špatné jméno funkce PHP bloku',
    38 => 'Functions for PHP Bloky must have the prefix \'phpblock_\' (e.g. phpblock_getweather).  The \'phpblock_\' prefix is required for security reasons to prevent the execution of arbitrary code.',
    39 => 'Strana',
    40 => 'Vlevo',
    41 => 'Vpravo',
    42 => 'You must enter the blockorder and security level for Geeklog default blocks',
    43 => 'Jen na Homepage',
    44 => 'Přístup odepřen',
    45 => "You are trying to access a block that you don't have rights to.  This attempt has been logged. Please <a href=\"{$_CONF['site_admin_url']}/block.php\">go back to the block administration screen</a>.",
    46 => 'Nový blok',
    47 => 'Administrace',
    48 => 'Jméno bloku',
    49 => ' (bez mezer, musí být unikátní)',
    50 => ' URL Help souboru',
    51 => 'včetně http://',
    52 => 'Pokud necháte prázdné - ikona helpu se nebude zobrazovat.',
    53 => 'Povolit',
    54 => 'uložit',
    55 => 'zrušit akci',
    56 => 'smazat',
    57 => 'Move Block Down',
    58 => 'Move Block Up',
    59 => 'Move block to the right side',
    60 => 'Move block to the left side',
    61 => 'No Title',
    62 => 'Article Limit',
    63 => 'Bad Block Title',
    64 => 'Your Title must not be empty and cannot contain HTML!',
    65 => 'Order'
);

###############################################################################
# admin/event.php

$LANG22 = array(
    1 => 'Editor událostí',
    2 => 'Error',
    3 => 'Titulek události',
    4 => 'URL události',
    5 => 'Datum začátku',
    6 => 'Datum konce&nbsp;&nbsp;&nbsp;',
    7 => 'Umístění události',
    8 => 'Popis události',
    9 => '(včetně http://)',
    10 => 'Musíte zadat datum/čas, popis a umístění události!',
    11 => 'Manažer událostí',
    12 => 'Pro změnu a smazání události, klepněte na tuto níže.  Pro vytvoření nové události klepněte na Nová událost výše.',
    13 => 'Titulek události',
    14 => 'Datum začátku',
    15 => 'Datum konce&nbsp;&nbsp;&nbsp;',
    16 => 'Přístup odepřen',
    17 => "Pokoušíte se editovat událost na níž nemáte dostatečná práva.  Tento pokus byl zaznamenán. Prosím <a href=\"{$_CONF['site_admin_url']}/event.php\">vraťte se na administraci událostí</a>.",
    18 => 'Nová událost',
    19 => 'Administrace',
    20 => 'uložit',
    21 => 'zrušit akci',
    22 => 'smazat',
    23 => 'Bad start date.',
    24 => 'Bad end date.',
    25 => 'End date is before start date.'
);

###############################################################################
# admin/story.php

$LANG24 = array(
    1 => 'Předešlé články',
    2 => 'Další články',
    3 => 'Režim',
    4 => 'Publikační režim',
    5 => 'Editor článků',
    6 => 'Nejsou zde články',
    7 => 'Autor',
    8 => 'uložit',
    9 => 'náhled',
    10 => 'zrušit akci',
    11 => 'smazat',
    12 => 'ID',
    13 => 'Titulek',
    14 => 'Sekce',
    15 => 'Datum publikace',
    16 => 'Intro Text',
    17 => 'Text',
    18 => 'Zhlédnuto',
    19 => 'Komentáře',
    20 => 'Ping',
    21 => 'Send Ping',
    22 => 'Seznam článků',
    23 => 'Pro editaci nebo smazání článku klepněte na jeho číslo níže. Pro zobrazení,klepněte na titulek článku, který chcete vidět. Pro vytvoření nového článku klepněte na Nový článek výše.',
    24 => 'The ID you chose for this story is already in use. Please use another ID.',
    25 => 'Error when saving story',
    26 => 'Náhled',
    27 => 'If you use [unscaledX] instead of [imageX], the image will be inserted at its original dimensions.',
    28 => '<p><b>PREVIEWING</b>: Previewing a story with images attached is best done by saving the article as a draft INSTEAD OF hitting the preview button.  Use the preview button only when images are not attached.',
    29 => 'Trackbacks',
    30 => 'File Upload Errors',
    31 => 'Prosím vyplnťe Autor, Titulek a Intro Text',
    32 => 'Zvýraznit',
    33 => 'V sytému může být jen jeden zvýrazněný článek (ten se bude zobrazovat vždy jako první)',
    34 => 'Verze pro tiskárnu',
    35 => 'Ano',
    36 => 'Ne',
    37 => 'Více od',
    38 => 'Více z',
    39 => 'Posláno emailem',
    40 => 'Přístup odepřen',
    41 => "Pokoušíte se editovat odkaz na nějž nemáte dostatečná práva.  Tento pokus byl zaznamenán.  Můžete si jen prohlédnout články níže. Prosím <a href=\"{$_CONF['site_admin_url']}/story.php\">vraťte se na administraci článků</a> když skončíte.",
    42 => "Pokoušíte se editovat odkaz na nějž nemáte dostatečná práva.  Tento pokus byl zaznamenán.  Prosím <a href=\"{$_CONF['site_admin_url']}/story.php\">vraťte se na administraci článků</a>.",
    43 => 'Nový článek',
    44 => 'Administrace',
    45 => 'Přístup',
    46 => '<b>PAMATUJTE:</b> pokud zadáte datum v budoucnosti, tento článek nebude publikován do tohoto data.  To znamená, že článek nebude vidět ani nebude zahrnut do vyhledávání a do statistiky stránek před tímto datem.',
    47 => 'Upload obrázků',
    48 => 'obrázek',
    49 => 'vpravo',
    50 => 'vlevo',
    51 => 'k přidání obrázků (max. velikost 200x200px) do článku musíte vložit speciálně formátovaný text.<br>Tento text vypadá takto: [imageX](systém umístí sám), [imageX_right](systém umístí vpravo od textu) nebo [imageX_left](systém umístí vlevo od textu) - kde X je číslo obrázku jež je přidáván.<br>PAMATUJTE: musíte použít obrázky jež jsou přidávány.  V opačném případě nebude možno publikovat článek.<BR><P><B>NÁHLED</B>: Pro náhled článku s obrázky je nejlépe použít náhled Verze pro tiskárnu.  Tlačítko <i>náhled</i> prosím používejte jen pro prohlížení článků bez obrázků.',
    52 => 'Smazat',
    53 => ' nepoužito.  Před uložením změn musíte vložit obrázek do Intro textu nebo textu.',
    54 => 'Přidaný obrázek nepoužit',
    55 => 'Následující chyby se vyskytly při publikaci vašeho článku.  Prosím opravte tyto chyby před konečnou publikací.',
    56 => 'Ikona Sekce.',
    57 => 'View unscaled image',
    58 => 'Story Management',
    59 => 'Option',
    60 => 'Enabled',
    61 => 'Auto Archive',
    62 => 'Auto Delete',
    63 => '',
    64 => '',
    65 => '',
    66 => '',
    67 => 'Expand the Content Edit Area size',
    68 => 'Reduce the Content Edit Area size',
    69 => 'Publish Story Date',
    70 => 'Toolbar Selection',
    71 => 'Basic Toolbar',
    72 => 'Common Toolbar',
    73 => 'Advanced Toolbar',
    74 => 'Advanced II Toolbar',
    75 => 'Full Featured',
    76 => 'Publish Options',
    77 => 'Javascript needs to be enabled for Advanced Editor. Option can be disabled in the main site config.php',
    78 => 'Click <a href="%s/story.php?mode=edit&amp;sid=%s&amp;editopt=default">here</a> to use default editor',
    79 => 'Preview',
    80 => 'Editor',
    81 => 'Publish Options',
    82 => 'Images',
    83 => 'Archive Options',
    84 => 'Permissions',
    85 => 'Show All'
);

###############################################################################
# admin/topic.php

$LANG27 = array(
    1 => 'Editor sekcí',
    2 => 'ID sekce',
    3 => 'Jméno sekce',
    4 => 'Ikona sekce',
    5 => '(bez mezer)',
    6 => 'Smazání sekce způsobí smazání článků a komentářů k nim i její ikony!',
    7 => 'Prosím vyplňte ID sekce a Jméno sekce',
    8 => 'Manažer sekcí',
    9 => 'Pro úpravu a smazání sekce klepněte na její jméno níže.  Pro vytvoření nové sekce klepněte na Nová sekce výše.',
    10 => 'pořadí',
    11 => 'článků/stránku',
    12 => 'Přístup odepřen',
    13 => "Pokoušíte se editovat sekci na níž nemáte dostatečná práva.  Tento pokus byl zaznamenán. Prosím <a href=\"{$_CONF['site_admin_url']}/topic.php\">vraťte se na administraci sekcí</a>.",
    14 => 'typ řazení',
    15 => 'abecedně',
    16 => 'nastaveno',
    17 => 'Nová sekce',
    18 => 'Administrace',
    19 => 'uložit',
    20 => 'zrušit akci',
    21 => 'smazat',
    22 => 'Default',
    23 => 'make this the default topic for new story submissions',
    24 => '(*)',
    25 => 'Archive Topic',
    26 => 'make this the default topic for archived stories. Only one topic allowed.',
    27 => 'Or Upload Topic Icon',
    28 => 'Maximum',
    29 => 'File Upload Errors'
);

###############################################################################
# admin/user.php

$LANG28 = array(
    1 => 'Editor uživatelů',
    2 => 'ID uživatele',
    3 => 'Uživatel',
    4 => 'Jméno uživatele',
    5 => 'Heslo',
    6 => 'Úroveň práv',
    7 => 'Emailová adresa',
    8 => 'Homepage',
    9 => '(bez mezer)',
    10 => 'Please fill in the Uživatel, Full name, Security Level and Email Address fields',
    11 => 'Manažer uživatelů',
    12 => 'To modify or smazat a user, click on that user below.  To create a new user click the new user button to the left. You can do simple searches by entering parts of a Uživatel,email address or fullname (e.g.*son* or *.edu) in the form below.',
    13 => 'Úroveň práv',
    14 => 'Datum registrace',
    15 => 'Nový uživatel',
    16 => 'Administrace',
    17 => 'změna hesla',
    18 => 'zrušit akci',
    19 => 'smazat',
    20 => 'uložit',
    21 => 'Uživatel již existuje.',
    22 => 'Chyba',
    23 => 'Hromadné přidání',
    24 => 'Hromadné přidání uživatelů',
    25 => 'You can import a batch of users into Geeklog.  The import file must a tab-delimited text file and must have the fields in the following order: full name, Uživatel, email address.  Each user you import will be emailed with a random Heslo.  You must have one user entered per line.  Failure to follow these instructions will cause problems that may require manual work so double check your entries!',
    26 => 'Hledat',
    27 => 'Omezit na',
    28 => 'Zaškrtnout pro smazání obrázku',
    29 => 'Cesta',
    30 => 'Import',
    31 => 'Noví uživatelé',
    32 => 'HOTOVO. Importováno %d a vyskytlo se %d chyb.',
    33 => 'Potvrdit',
    34 => 'Chyba: Specifikujte soubor.',
    35 => 'Last Login',
    36 => '(never)',
    37 => 'UID',
    38 => 'Group Listing',
    39 => 'Password (again)',
    40 => 'Registration Date',
    41 => 'Last login Date',
    42 => 'Banned',
    43 => 'Awaiting Activation',
    44 => 'Awaiting Authorization',
    45 => 'Active',
    46 => 'User Status',
    47 => 'Edit'
);

###############################################################################
# admin/moderation.php

$LANG29 = array(
    1 => 'Potvrdit',
    2 => 'Smazat',
    3 => 'Editovat',
    4 => 'Profil',
    10 => 'Titulek',
    11 => 'Datum začátku',
    12 => 'URL',
    13 => 'Kategorie',
    14 => 'Datum',
    15 => 'Sekce',
    16 => 'Jméno uživatele',
    17 => 'Celé jméno uživatele',
    18 => 'Email',
    34 => 'Administrace weblogu',
    35 => 'Přidání článku',
    36 => 'Přidání odkazu',
    37 => 'Přidání události',
    38 => 'Přidat',
    39 => 'Nyní zde není nic k moderování',
    40 => 'Publikace uživatele'
);

###############################################################################
# calendar.php

$LANG30 = array(
    1 => 'neděle',
    2 => 'pondělí',
    3 => 'úterý',
    4 => 'středa',
    5 => 'čtvrtek',
    6 => 'pátek',
    7 => 'sobota',
    8 => 'Přidat událost',
    9 => 'Události weblogu',
    10 => 'Události uživatele',
    11 => 'Veřejný kalendář',
    12 => 'Osobní kalendář',
    13 => 'leden',
    14 => 'únor',
    15 => 'březen',
    16 => 'duben',
    17 => 'květen',
    18 => 'červen',
    19 => 'červenec',
    20 => 'srpen',
    21 => 'září',
    22 => 'říjen',
    23 => 'listopad',
    24 => 'prosinec',
    25 => 'Zpět na ',
    26 => 'Každý den',
    27 => 'Týden',
    28 => 'Osobní kalendář pro',
    29 => 'Veřejný kalendář',
    30 => 'smazat událost',
    31 => 'Přidat událost',
    32 => 'Událost',
    33 => 'Datum',
    34 => 'Čas',
    35 => 'Rychlé přidání',
    36 => 'Potvrdit',
    37 => 'Promiňte, Osobní kalendář není na tšchto stránkách podporován',
    38 => 'Editor osobních událostí',
    39 => 'Den',
    40 => 'Týden',
    41 => 'Měsíc'
);

###############################################################################
# admin/mail.php

$LANG31 = array(
    1 => "{$_CONF['site_name']} - zasílání emailů",
    2 => 'Od',
    3 => 'Zpětná  adresa',
    4 => 'Hlavička',
    5 => 'Zpráva',
    6 => 'Poslat:',
    7 => 'Všem uživatelům',
    8 => 'Admin',
    9 => 'Možnosti',
    10 => 'HTML',
    11 => 'Urgentní zpráva!',
    12 => 'Poslat',
    13 => 'Smazat',
    14 => 'Ignorovat uživ. nastavení',
    15 => 'Chyba při zasílání: ',
    16 => 'Zasláno: ',
    17 => "<a href={$_CONF['site_admin_url']}/mail.php>Poslat další zprávu</a>",
    18 => 'Pro',
    19 => 'POZOR: chcete-li zaslat zprávu všem uživatelům, vyberte Logged-in Users skupinu z roletové nabídky.',
    20 => "Odesláno <successcount> zpráv a nezasláno <failcount> zpráv.  Detaily jsou níže u každého pokusu o zaslání zvlášť.  Můžete se pokusit znovu <a href=\"{$_CONF['site_admin_url']}/mail.php\">zaslat zprávu</a> nebo <a href=\"{$_CONF['site_admin_url']}/moderation.php\">se vrátit na stránku administrace</a>.",
    21 => 'Chyby',
    22 => 'Úspěšně',
    23 => 'Bez chyb',
    24 => 'Neúspěšně',
    25 => '- Vybrat skupinu -',
    26 => 'Prosím vyplňte všechna pole ve formuláři a vyberte skupinu uživatelů z roletové nabídky.'
);

###############################################################################
# admin/plugins.php

$LANG32 = array(
    1 => 'Installing plugins could possibly cause damage to your Geeklog installation and, possibly, to your system.  It is important that you only install plugins downloaded from the <a href="http://www.geeklog.net" target="_blank">Geeklog Homepage</a> as we thoroughly test all plugins submitted to our site on a variety of operating systems.  It is important that you understand that the plugin installation process will require the execution of a few filesystem commands which could lead to security problems particularly if you use plugins from third party sites.  Even with this warning you are getting, we do not gaurantee the success of any installation nor are we liable for damage caused by installing a Geeklog plugin.  In other words, install at your own risk.  For the wary, directions on how to manually install a plugin is included with each plugin package.',
    2 => 'Plug-in Installation Disclaimer',
    3 => 'Plug-in Installation Form',
    4 => 'Plug-in File',
    5 => 'Plug-in List',
    6 => 'Warning: Plug-in Already Installed!',
    7 => 'The plug-in you are trying to install already exists.  Please delete the plugin before re-installing it',
    8 => 'Plugin Compatibility Check Failed',
    9 => 'This plugin requires a newer version of Geeklog. Either upgrade your copy of <a href="http://www.geeklog.net">Geeklog</a> or get a newer version of the plug-in.',
    10 => '<br><b>There are no plugins currently installed.</b><br><br>',
    11 => 'To modify or delete a plug-in, click on that plug-in\'s number below. To learn more about a plug-in, click the plug-in name and you will be directed to that plug-in\'s website. To install or upgrade a plug-in please consult it\'s documentation.',
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
    23 => 'uložit',
    24 => 'zrušit akci',
    25 => 'smazat',
    26 => 'Plug-in Name',
    27 => 'Plug-in Homepage',
    28 => 'Plug-in Version',
    29 => 'Geeklog Version',
    30 => 'smazat Plug-in?',
    31 => 'Are you sure you want to delete this plug-in?  By doing so you will remove all the data and data structures that this plug-in uses.  If you are sure, click delete again on the form below.',
    32 => '<p><b>Error AutoLink tag not correct format</b></p>',
    33 => 'Code Version',
    34 => 'Update',
    35 => 'Edit',
    36 => 'Code',
    37 => 'Data',
    38 => 'Update!'
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
    42 => 'Events',
    43 => 'All',
    44 => 'None',
    45 => 'Header-link in topic',
    46 => 'Limit Results',
    47 => 'Search',
    48 => 'Edit',
    49 => 'Feed Logo',
    50 => "Relative to site url ({$_CONF['site_url']})"
);

###############################################################################
# confirmation and error messages

$MESSAGE = array(
    1 => "Vaše přihlašovací heslo Vám bylo zasláno na zadanou adresu. Prosím následujte prosté instrukce v poště. Děkujeme Vám za účast na {$_CONF['site_name']}",
    2 => "Děkujeme za přidání článku na {$_CONF['site_name']}..",
    3 => "Děkujeme za přidání odkazu na {$_CONF['site_name']}..",
    4 => "Děkujeme za přidání události na  {$_CONF['site_name']}..",
    5 => 'Vaše informace o účtu byly uloženy.',
    6 => 'Vaše vlastní nastavení bylo uloženo.',
    7 => 'Vaše nastavení komentářů bylo uloženo.',
    8 => 'Byl jste úspěšně odhlášen.',
    9 => 'Článek byl uložen.',
    10 => 'Článek byl vymazán.',
    11 => 'Bloky byly uloženy.',
    12 => 'Blok byl odstraněn.',
    13 => 'Sekce byla uložena.',
    14 => 'Sekce a články s komentáři v ní byla smazána.',
    15 => 'Odkaz byl uložen.',
    16 => 'Odkaz byl odstraněn.',
    17 => 'Událost byla uložena.',
    18 => 'Událost byla odstraněna.',
    19 => 'Anketa byla uložena.',
    20 => 'Anketa byla odstraněna.',
    21 => 'Uživatel byl přidán/změněn.',
    22 => 'Uživatel byl odstraněn.',
    23 => 'Chyba v přidávání události do Osobního kalendáře. Neexistujíci ID události.',
    24 => 'Událost bylo vložena do vašeho kalendáře',
    25 => 'Pro otevření osobního kalendáře musíte být přihlášen',
    26 => 'Událost byla vymazána z vašeho kalendáře',
    27 => 'Vzkaz poslán.',
    28 => 'The plug-in has been successfully saved',
    29 => 'Promiňte, Osobní kalendář není na tšchto stránkách podporován',
    30 => 'Přístup odepřen',
    31 => 'Nemáte práva přístupu k administraci článků.  Všechny neoprávněné požadavky a přístupy jsou zaznamenávány',
    32 => 'Nemáte práva přístupu k administraci sekcí.  Všechny neoprávněné požadavky a přístupy jsou zaznamenávány',
    33 => 'Nemáte práva přístupu k administraci bloků.  Všechny neoprávněné požadavky a přístupy jsou zaznamenávány',
    34 => 'Nemáte práva přístupu k administraci odkazů.  Všechny neoprávněné požadavky a přístupy jsou zaznamenávány',
    35 => 'Nemáte práva přístupu k administraci událostí.  Všechny neoprávněné požadavky a přístupy jsou zaznamenávány',
    36 => 'Nemáte práva přístupu k administraci anket.  Všechny neoprávněné požadavky a přístupy jsou zaznamenávány',
    37 => 'Nemáte práva přístupu k administraci uživatelů.  Všechny neoprávněné požadavky a přístupy jsou zaznamenávány',
    38 => 'Nemáte práva přístupu k administraci pluginů.  Všechny neoprávněné požadavky a přístupy jsou zaznamenávány',
    39 => 'Nemáte práva přístupu k administraci enailových uživatelů.  Všechny neoprávněné požadavky a přístupy jsou zaznamenávány',
    40 => 'Systémové zprávy',
    41 => 'Nemáte práva přístupu k administraci slov.  Všechny neoprávněné požadavky a přístupy jsou zaznamenávány',
    42 => 'Vaše slovo bylo uloženo.',
    43 => 'Slovo bylo smazáno.',
    44 => 'The plug-in was successfully installed!',
    45 => 'The plug-in was successfully deleted.',
    46 => 'Nemáte práva přístupu k database backup utilitě.  Všechny neoprávněné požadavky a přístupy jsou zaznamenávány',
    47 => 'This functionality only works under *nix.  If you are running *nix as your operating system then your cache has been successfully cleared. If you are on Windows, you will need to search for files name adodb_*.php and remove them manually.',
    48 => "Děkujeme za registraci na {$_CONF['site_name']}.  Vaše heslo pro přístup do systému Vám bylo zasláno na email, který jste zadali.",
    49 => 'Skupina byla úspěšně uložena.',
    50 => 'Skupina byla úspěšně smazána.',
    51 => 'This username is already in use. Please choose another one.',
    52 => 'The email address provided does not appear to be a valid email address.',
    53 => 'Your new password has been accepted. Please use your new password below to log in now.',
    54 => 'Your request for a new password has expired. Please try again below.',
    55 => 'An email has been sent to you and should arrive momentarily. Please follow the directions in the message to set a new password for your account.',
    56 => 'The email address provided is already in use for another account.',
    57 => 'Your account has been successfully deleted.',
    58 => 'Your feed has been successfully saved.',
    59 => 'The feed has been successfully deleted.',
    60 => 'The plugin was successfully updated',
    61 => 'Plugin %s: Unknown message placeholder',
    62 => 'The trackback comment has been deleted.',
    63 => 'An error occurred when deleting the trackback comment.',
    64 => 'Your trackback comment has been successfully sent.',
    65 => 'Weblog directory service successfully saved.',
    66 => 'The weblog directory service has been deleted.',
    67 => 'The new password does not match the confirmation password!',
    68 => 'You have to enter the correct current password.',
    69 => 'Your account has been blocked!',
    70 => 'Your account is awaiting administrator approval.',
    71 => 'Your account has now been confirmed and is awaiting administrator approval.',
    72 => 'An error occured while attempting to install the plugin. See error.log for details.',
    73 => 'An error occured while attempting to uninstall the plugin. See error.log for details.',
    74 => 'The pingback has been successfully sent.',
    75 => 'Trackbacks must be sent using a POST request.'
);

###############################################################################

$LANG_ACCESS = array(
    'access' => 'Práva',
    'ownerroot' => 'Vlastník-Root',
    'group' => 'Skupina',
    'readonly' => 'Jen pro čtení',
    'accessrights' => 'Přístupová práva',
    'owner' => 'Vlastník',
    'grantgrouplabel' => 'Zaručuje práva vyšší než práva skupiny pro editaci',
    'permmsg' => 'PAMATUJTE: <i>uživatelé</i> jsou přihlášení uživatelé weblogu a <i>hosté</i> jsou všichni, kdo si prohlížejí weblog bez přihlášení.',
    'securitygroups' => 'Skupiny/Úroveň práv',
    'editrootmsg' => "Even though you are a User Administrator, you can't edit a root user without first being a root user yourself.  You can edit all other users except root users. Please note that all attempts to illegally edit root users are logged.  Please go back to the <a href=\"{$_CONF['site_admin_url']}/user.php\">User Administration page</a>.",
    'securitygroupsmsg' => 'Select the checkboxes for the groups you want the user to belong to.',
    'groupeditor' => 'Editor skupin uživatelů',
    'description' => 'Popis',
    'name' => 'Jméno',
    'rights' => 'Práva',
    'missingfields' => 'Chybějící pole',
    'missingfieldsmsg' => 'You must supply the name and a description for a group',
    'groupmanager' => 'Manažer skupin uživatelů',
    'newgroupmsg' => 'To modify or delete a group, click on that group below. To create a new group click new group above. Please note that core groups cannot be deleted because they are used v systému.',
    'groupname' => 'Jméno skupiny uživatelů',
    'coregroup' => 'Hlavní skupina',
    'yes' => 'Ano',
    'no' => 'Ne',
    'corerightsdescr' => "This group is a core {$_CONF['site_name']} Group.  Therefore the rights for this group cannot be edited.  Below is a read-only list of the rights this group has access to.",
    'groupmsg' => 'Security Groups on this site are hierarchical.  By adding this group to any of the groups below you will giving this group the same rights that those groups have.  Where possible it is encouraged you use the groups below to give rights to a group.  If you need this group to have custom rights then you can select the rights to various site features in the section below called \'Rights\'.  To add this group to any of the ones below simply check the box next to the group(s) that you want.',
    'coregroupmsg' => "This group is a core {$_CONF['site_name']} Group.  Therefore the groups that this group belongs to cannot be edited.  Below is a read-only list of the groups this group belongs to.",
    'rightsdescr' => 'A groups access to a certain right below can be given directly to the group OR to a different group that this group is a part of.  The ones you see below without a checkbox are the rights that have been given to this group because it belongs to another group with that right.  The rights with checkboxes below are rights that can be given directly to this group.',
    'lock' => 'Uzamčeno',
    'members' => 'Uživatelé',
    'anonymous' => 'Hosté',
    'permissions' => 'Přidělení oprávnění',
    'permissionskey' => 'R = čtení, E = editace, editační práva v sobě zahrnují i právo číst!',
    'edit' => 'Editace',
    'none' => 'Není',
    'accessdenied' => 'Přístup odepřen',
    'storydenialmsg' => "You do not have access to view this story.  This could be because you aren't a member of {$_CONF['site_name']}.  Please <a href=users.php?mode=new> become a member</a> of {$_CONF['site_name']} to receive full membership access!",
    'eventdenialmsg' => "You do not have access to view this event.  This could be because you aren't a member of {$_CONF['site_name']}.  Please <a href=users.php?mode=new> become a member</a> of {$_CONF['site_name']} to receive full membership access!",
    'nogroupsforcoregroup' => 'This group doesn\'t belong to any of the other groups',
    'grouphasnorights' => 'This group doesn\'t have access to any of the administrative features of this site',
    'newgroup' => 'Nová skupina uživatelů',
    'adminhome' => 'Administrace',
    'save' => 'uložit',
    'cancel' => 'zrušit akci',
    'delete' => 'smazat',
    'canteditroot' => 'You have tried to edit the Root group but you are not in the Root group yourself therefore your access to this group is denied.  Please contact the system administrator if you feel this is Chyba',
    'listusers' => 'List Users',
    'listthem' => 'list',
    'usersingroup' => 'Users in group "%s"',
    'usergroupadmin' => 'User Group Administration',
    'add' => 'Add',
    'remove' => 'Remove',
    'availmembers' => 'Available Members',
    'groupmembers' => 'Group Members',
    'canteditgroup' => 'To edit this group, you have to be a member of the group. Please contact the system administrator if you feel this is an error.',
    'cantlistgroup' => 'To see the members of this group, you have to be a member yourself. Please contact the system administrator if you feel this is an error.',
    'editgroupmsg' => 'To modify the group membership, click on the member names(s) and use the add or remove buttons. If the member is a member of the group, their name will appear on the right side only. Once you are complete - press <b>Save</b> to update the group and return to the main group admin page.',
    'listgroupmsg' => 'Listing of all current members in the group: <b>%s</b>',
    'search' => 'Search',
    'submit' => 'Submit',
    'limitresults' => 'Limit Results',
    'group_id' => 'Group ID',
    'plugin_access_denied_msg' => 'You are illegally trying access a plugin administration page.  Please note that all attempts to illegally access this page are logged.',
    'groupexists' => 'Group name already exists',
    'groupexistsmsg' => 'There is already a group with this name. Group names must be unique.'
);

###############################################################################
# admin/database.php

$LANG_DB_BACKUP = array(
    'last_ten_backups' => 'Last 10 Back-ups',
    'do_backup' => 'Do Backup',
    'backup_successful' => 'Database back up was successful.',
    'db_explanation' => 'To create a new backup of your Geeklog system, hit the button below',
    'not_found' => "Incorrect path or mysqldump utility not executable.<br>Check <strong>\$_DB_mysqldump_path</strong> definition in config.php.<br>Variable currently defined as: <var>{$_DB_mysqldump_path}</var>",
    'zero_size' => 'Backup Failed: Filesize was 0 bytes',
    'path_not_found' => "{$_CONF['backup_path']} does not exist or is not a directory",
    'no_access' => "Chyba: Directory {$_CONF['backup_path']} is not accessible.",
    'backup_file' => 'Backup file',
    'size' => 'Size',
    'bytes' => 'Bytes',
    'total_number' => 'Total number of backups: %d'
);

###############################################################################

$LANG_BUTTONS = array(
    1 => 'Homepage',
    2 => 'Kontakt',
    3 => 'Publikovat',
    4 => 'Odkazy',
    5 => 'Ankety',
    6 => 'Kalendář',
    7 => 'Statistika',
    8 => 'Vlastní nastavení',
    9 => 'Hledání',
    10 => 'rozšířené hledání',
    11 => 'Directory'
);

###############################################################################
# 404.php

$LANG_404 = array(
    1 => '404 Error',
    2 => 'Gee, I\'ve looked everywhere but I can not find <b>%s</b>.',
    3 => "<p>We're sorry, but the file you have requested does not exist. Please feel free to check the <a href=\"{$_CONF['site_url']}\">main page</a> or the <a href=\"{$_CONF['site_url']}/search.php\">search page</a> to see if you can find what you lost."
);

###############################################################################
# login form

$LANG_LOGIN = array(
    1 => 'Je nutné se přihlásit',
    2 => 'Promiňte, pro přístup je nutné být přihlášen jako uživatel.',
    3 => 'Přihlásit',
    4 => 'Nový uživatel'
);

###############################################################################
# pdfgenerator.php

$LANG_PDF = array(
    1 => 'The PDF feature has been disabled',
    2 => 'The document provided was not rendered. The document was received but could not be processed.  Please make sure to submit only html formatted documents that have been written to the xHTML standard. Please note that overly complex html documents may not render correctly or at all.The document resulting from your attempt was 0 bytes in length, and has been deleted. If you\'re sure that your document should render fine, please re-submit it.',
    3 => 'Unknown error during PDF generation',
    4 => "No page data was given or you want to use the ad-hoc PDF generation tool below.  If you think you are getting this page\n          in error then please contact the system administrator.  Otherwise, you may use the form below to generate PDF's in an ad-hoc fashion.",
    5 => 'Loading your document.',
    6 => 'Please wait while your document is loaded.',
    7 => 'You may right click the button below and choose \'save target...\' or \'save link location...\' to save a copy of your document.',
    8 => "The path given in the configuration file to the HTMLDoc binary is invalid or this system cannot execute it.  Please contact the site administrator if this problem\n          persists.",
    9 => 'PDF Generator',
    10 => "This is the Ad-hoc PDF Generation tool. It will attempt to convert any URL you give into a PDF.  Please note that some web pages will not render properly with this feature.  This\n           is a limitation of the HTMLDoc PDF generation tool and such errors should not be reported to the administrators of this site",
    11 => 'URL',
    12 => 'Generate PDF!',
    13 => 'The PHP configuration on this server does not allow URLs to be used with the fopen() command.  The system administrator must edit the php.ini file and set allow_url_fopen to On',
    14 => 'The PDF you requested either does not exist or you tried to illegally access a file.'
);

###############################################################################
# trackback.php

$LANG_TRB = array(
    'trackback' => 'Trackback',
    'from' => 'from',
    'tracked_on' => 'Tracked on',
    'read_more' => '[read more]',
    'intro_text' => 'Here\'s what others have to say about \'%s\':',
    'no_comments' => 'No trackback comments for this entry.',
    'this_trackback_url' => 'Trackback URL for this entry:',
    'num_comments' => '%d trackback comments',
    'send_trackback' => 'Send Pings',
    'preview' => 'Preview',
    'editor_title' => 'Send trackback comment',
    'trackback_url' => 'Trackback URL',
    'entry_url' => 'Entry URL',
    'entry_title' => 'Entry Title',
    'blog_name' => 'Site Name',
    'excerpt' => 'Excerpt',
    'truncate_warning' => 'Note: The receiving site may truncate your excerpt',
    'button_send' => 'Send',
    'button_preview' => 'Preview',
    'send_error' => 'Error',
    'send_error_details' => 'Error when sending trackback comment:',
    'url_missing' => 'No Entry URL',
    'url_required' => 'Please enter at least a URL for the entry.',
    'target_missing' => 'No Trackback URL',
    'target_required' => 'Please enter a trackback URL',
    'error_socket' => 'Could not open socket.',
    'error_response' => 'Response not understood.',
    'error_unspecified' => 'Unspecified error.',
    'select_url' => 'Select Trackback URL',
    'not_found' => 'Trackback URL not found',
    'autodetect_failed' => 'Geeklog could not detect the Trackback URL for the post you want to send your comment to. Please enter it manually below.',
    'trackback_explain' => 'From the links below, please select the URL you want to send your Trackback comment to. Geeklog will then try to determine the correct Trackback URL for that post. Or you can <a href="%s">enter it manually</a> if you know it already.',
    'no_links_trackback' => 'No links found. You can not send a Trackback comment for this entry.',
    'pingback' => 'Pingback',
    'pingback_results' => 'Pingback results',
    'send_pings' => 'Send Pings',
    'send_pings_for' => 'Send Pings for "%s"',
    'no_links_pingback' => 'No links found. No Pingbacks were sent for this entry.',
    'pingback_success' => 'Pingback sent.',
    'no_pingback_url' => 'No pingback URL found.',
    'resend' => 'Resend',
    'ping_all_explain' => 'You can now notify the sites you linked to (<a href="http://en.wikipedia.org/wiki/Pingback">Pingback</a>), advertise that your site has been updated by pinging weblog directory services, or send a <a href="http://en.wikipedia.org/wiki/Trackback">Trackback</a> comment in case you wrote about a post on someone else\'s site.',
    'pingback_button' => 'Send Pingback',
    'pingback_short' => 'Send Pingbacks to all sites linked from this entry.',
    'pingback_disabled' => '(Pingback disabled)',
    'ping_button' => 'Send Ping',
    'ping_short' => 'Ping weblog directory services.',
    'ping_disabled' => '(Ping disabled)',
    'trackback_button' => 'Send Trackback',
    'trackback_short' => 'Send a Trackback comment.',
    'trackback_disabled' => '(Trackback disabled)',
    'may_take_a_while' => 'Please note that sending Pingbacks and Pings may take a while.',
    'ping_results' => 'Ping results',
    'unknown_method' => 'Unknown ping method',
    'ping_success' => 'Ping sent.',
    'error_site_name' => 'Please enter the site\'s name.',
    'error_site_url' => 'Please enter the site\'s URL.',
    'error_ping_url' => 'Please enter a valid Ping URL.',
    'no_services' => 'No weblog directory services configured.',
    'services_headline' => 'Weblog Directory Services',
    'service_explain' => 'To modify or delete a weblog directory service, click on the edit icon of that service below. To add a new weblog directory service, click on "Create New" above.',
    'service' => 'Service',
    'ping_method' => 'Ping method',
    'service_website' => 'Website',
    'service_ping_url' => 'URL to ping',
    'ping_standard' => 'Standard Ping',
    'ping_extended' => 'Extended Ping',
    'ping_unknown' => '(unknown method)',
    'edit_service' => 'Edit Weblog Directory Service',
    'trackbacks' => 'Trackbacks',
    'editor_intro' => 'Prepare your trackback comment for <a href="%s">%s</a>.',
    'editor_intro_none' => 'Prepare your trackback comment.',
    'trackback_note' => 'To send a trackback comment for a story, go to the list of stories and click on "Send Ping" for the story. To send a trackback that is not related to a story, <a href="%s">click here</a>.',
    'pingback_explain' => 'Enter a URL to send the Pingback to. The pingback will point to your site\'s homepage.',
    'pingback_url' => 'Pingback URL',
    'site_url' => 'This site\'s URL',
    'pingback_note' => 'To send a pingback for a story, go to the list of stories and click on "Send Ping" for the story. To send a pingback that is not related to a story, <a href="%s">click here</a>.',
    'pbtarget_missing' => 'No Pingback URL',
    'pbtarget_required' => 'Please enter a pingback URL',
    'pb_error_details' => 'Error when sending the pingback:'
);

###############################################################################
# directory.php

$LANG_DIR = array(
    'title' => 'Article Directory',
    'title_year' => 'Article Directory for %d',
    'title_month_year' => 'Article Directory for %s %d',
    'nav_top' => 'Back to Article Directory',
    'no_articles' => 'No articles.'
);

###############################################################################
# "What's New" Time Strings
# 
# For the first two strings, you can use the following placeholders.
# Order them so it makes sense in your language:
# %i    item, "Stories"
# %n    amount, "2", "20" etc.
# %t    time, "2" (weeks)
# %s    scale, "hrs", "weeks"

$LANG_WHATSNEW = array(
    'new_string' => '%n new %i in the last %t %s',
    'new_last' => 'last %t %s',
    'minutes' => 'minutes',
    'hours' => 'hours',
    'days' => 'days',
    'weeks' => 'weeks',
    'months' => 'months',
    'minute' => 'minute',
    'hour' => 'hour',
    'day' => 'day',
    'week' => 'week',
    'month' => 'month'
);

###############################################################################
# Admin - Strings
# 
# These are some standard strings used by core functions as well as plugins to
# display administration lists and edit pages

$LANG_ADMIN = array(
    'search' => 'Search',
    'limit_results' => 'Limit Results',
    'submit' => 'Submit',
    'edit' => 'Edit',
    'admin_home' => 'Admin Home',
    'create_new' => 'Create New',
    'enabled' => 'Enabled',
    'title' => 'Title',
    'type' => 'Type',
    'topic' => 'Topic',
    'help_url' => 'Help File URL',
    'save' => 'Save',
    'cancel' => 'Cancel',
    'delete' => 'Delete',
    'copy' => 'Copy',
    'no_results' => '- No entries found -',
    'data_error' => 'There was an error processing the subscription data. Please check the data source.'
);

###############################################################################
# Localisation of the texts for the various drop-down menus that are actually
# stored in the database. If these exist, they override the texts from the
# database.

$LANG_commentcodes = array(
    0 => 'Comments Enabled',
    -1 => 'Comments Disabled'
);


$LANG_commentmodes = array(
    'flat' => 'Flat',
    'nested' => 'Nested',
    'threaded' => 'Threaded',
    'nocomment' => 'No Comments'
);

$LANG_cookiecodes = array(
    0 => '(don\'t)',
    3600 => '1 Hour',
    7200 => '2 Hours',
    10800 => '3 Hours',
    28800 => '8 Hours',
    86400 => '1 Day',
    604800 => '1 Week',
    2678400 => '1 Month'
);

$LANG_dateformats = array(
    0 => 'System Default'
);

$LANG_featurecodes = array(
    0 => 'Not Featured',
    1 => 'Featured'
);

$LANG_frontpagecodes = array(
    0 => 'Show Only in Topic',
    1 => 'Show on Front Page'
);

$LANG_postmodes = array(
    'plaintext' => 'Plain Old Text',
    'html' => 'HTML Formatted'
);

$LANG_sortcodes = array(
    'ASC' => 'Oldest First',
    'DESC' => 'Newest First'
);

$LANG_trackbackcodes = array(
    0 => 'Trackback Enabled',
    -1 => 'Trackback Disabled'
);

?>
