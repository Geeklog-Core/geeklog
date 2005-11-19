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

$LANG_CHARSET = 'iso-8859-2';

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
    2 => '<b>��st cel�</b>',
    3 => 'koment���',
    4 => 'Editovat',
    5 => 'Anketa',
    6 => 'V�sledky',
    7 => 'V�sledky ankety',
    8 => 'hlas�',
    9 => 'Administr�torsk� funkce:',
    10 => 'P��sp�vky',
    11 => '�l�nky',
    12 => 'Bloky',
    13 => 'Sekce',
    14 => 'Odkazy',
    15 => 'Ud�losti',
    16 => 'Ankety',
    17 => 'U�ivatel�',
    18 => 'SQL dotaz',
    19 => '<b>Odhl�sit</b>',
    20 => 'Informace o u�ivateli:',
    21 => 'U�ivatel',
    22 => 'U�ivatel�v ID',
    23 => '�rove� pr�v',
    24 => 'Anonymn� host',
    25 => 'Odpov��',
    26 => ' N�sleduj�c� koment��e jsou n�zorem jejich vkladatele. <br>Weblog neru�� za to co je zde naps�no.',
    27 => 'Naposledy p�id�no',
    28 => 'Smazat',
    29 => 'Nejsou ��dn� koment��e.',
    30 => 'Star�� �l�nky',
    31 => 'HTML tagy povoleny:',
    32 => 'Chyba, neplatn� u�ivatelsk� jm�no',
    33 => 'Chyba, nepovolen� z�pis do log fajlu',
    34 => 'Chyba',
    35 => 'Odhl�sit',
    36 => ' - ',
    37 => 'Bez �l�nk�',
    38 => 'Content Syndication',
    39 => 'Obnovit',
    40 => 'You have <tt>register_globals = Off</tt> in your <tt>php.ini</tt>. However, Geeklog requires <tt>register_globals</tt> to be <strong>on</strong>. Before you continue, please set it to <strong>on</strong> and restart your web server.',
    41 => 'Host�',
    42 => 'Publikov�no:',
    43 => 'Odpov�d�t na toto',
    44 => 'Nad�azen�',
    45 => 'MySQL Error Number',
    46 => 'MySQL Error Message',
    47 => 'U�ivatelsk� menu',
    48 => 'Informace o ��tu',
    49 => 'Vlastn� nastaven�',
    50 => 'Error with SQL statement',
    51 => 'help',
    52 => 'Nov�',
    53 => 'Administrace',
    54 => 'Nelze otev��t soubor.',
    55 => 'Nastala chyba - ',
    56 => 'Hlasovat',
    57 => 'Heslo',
    58 => 'P�ihl�sit',
    59 => "Nem�te zat�m ��et?  P�ihla�te se jako <a href=\"{$_CONF['site_url']}/users.php?mode=new\"><b>Nov�&nbsp;u�ivatel</b></a>",
    60 => 'Okomentovat',
    61 => 'Nov� u�ivatel',
    62 => 'slov',
    63 => 'Nastaven� koment���',
    64 => 'Poslat emailem',
    65 => 'Verze pro tisk�rnu',
    66 => 'Osobn� kalend��',
    67 => 'V�tejte na ',
    68 => 'home',
    69 => 'kontakt',
    70 => 'hledat',
    71 => 'p��sp�vky',
    72 => 'odkazy',
    73 => 'ankety',
    74 => 'kalend��',
    75 => 'roz���en� hled�n�',
    76 => 'statistika',
    77 => 'Pluginy',
    78 => 'Bl��c� se ud�losti',
    79 => 'Co je nov�ho',
    80 => '�l�nk� za posledn�ch',
    81 => '�l�nek za posledn�ch',
    82 => 'hodin',
    83 => 'KOMENT��E',
    84 => 'ODKAZY',
    85 => 'za posledn�ch 48 hodin',
    86 => 'Nejsou nov� koment��e',
    87 => 'za posledn� 2 t�dny',
    88 => 'Nejsou nov� odkazy',
    89 => 'Nejsou ��dn� bl��c� se ud�losti',
    90 => 'Homepage',
    91 => 'Str�nka vytvo�ena za',
    92 => 'sekund&nbsp;',
    93 => 'Copyright',
    94 => 'V�echna pr�va a ochrann� zn�mky na t�chto str�nk�ch pat�� jejich vlastn�k�m.',
    95 => 'Pou��v�me',
    96 => 'Skupiny',
    97 => 'Word List',
    98 => 'Pluginy',
    99 => '�L�NKY',
    100 => 'Nejsou nov� �l�nky',
    101 => 'Osobn� ud�losti',
    102 => 'Ud�losti weblogu',
    103 => 'DB z�lohy',
    104 => '-',
    105 => 'Emailov� d�mon',
    106 => 'Zhl�dnuto',
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
    1 => 'Kalend��',
    2 => 'Nejsou ��dn� ud�losti k zobrazen�.',
    3 => 'Kdy',
    4 => 'Kde',
    5 => 'Popis',
    6 => 'P�idat ud�lost',
    7 => 'Bl��c� se ud�losti',
    8 => 'Kdy� toto p�id�te do Osobn�ho kalend��e, uvid�te je jen Vy ve sv�m Osobn�m kalend��i v U�ivatelsk�ch funkc�ch.',
    9 => 'P�idat do osobn�ho kalend��e',
    10 => 'Odebrat z osobn�ho kalend��e',
    11 => "P�id�n� ud�losti do kalend��e {$_USER['username']}'",
    12 => 'Ud�lost',
    13 => 'Za��n�',
    14 => 'Kon��',
    15 => 'Zp�t na kalend��'
);

###############################################################################
# comment.php

$LANG03 = array(
    1 => 'Vlo�it koment��',
    2 => 'Typ koment��e',
    3 => 'Odhl�sit',
    4 => 'Vytvo�it ��et',
    5 => 'U�ivatel',
    6 => 'Tato str�nka vy�aduje p�ihl�en� pro vlo�en� koment��e, pros�m p�ihla�te se.  Pokud nem�te ��et - m��ete si ho vytvo�it.',
    7 => 'V� posledn� koment�� vlo�en p�ed ',
    8 => " sekundami.  Tato str�nka vy�aduje prodlevu {$_CONF['commentspeedlimit']} sekund mezi koment��i.",
    9 => 'Koment��',
    10 => 'Send Report',
    11 => 'Vlo�it koment��',
    12 => 'Pros�m vypl�te Titulek a Koment��, jinak nelze vlo�it.',
    13 => 'Va�e info',
    14 => 'N�hled',
    15 => 'Report this post',
    16 => 'Titulek',
    17 => 'Chyba',
    18 => 'D�le�it�',
    19 => 'Pros�m vkl�dejte koment��e do spr�vn� sekce.',
    20 => 'Koment��e vkl�dejte pokud mo�no ve spr�vn�m po�ad�.',
    21 => 'P�e�t�te si pros�m nejd��ve koment��e ostatn�ch u�ivatel�, aby nedoch�zelo k duplicit�.',
    22 => 'Pou�ijte titulek, kter� vlo�il syst�m.',
    23 => 'V� email nebude publikov�n!',
    24 => 'Anonymn� host',
    25 => 'Are you sure you want to report this post to the site admin?',
    26 => '%s reported the following abusive comment post:',
    27 => 'Abuse report'
);

###############################################################################
# users.php

$LANG04 = array(
    1 => 'U�ivatelsk� profil:',
    2 => 'P�ihla�ovac� jm�no',
    3 => 'Jm�no',
    4 => 'Heslo',
    5 => 'Email',
    6 => 'Homepage',
    7 => 'O v�s',
    8 => 'PGP kl��',
    9 => 'Ulo�it zm�ny',
    10 => 'Posledn�ch 10 coment��� u�ivatele',
    11 => 'Bez koment��� u�ivatele',
    12 => 'U�ivatelsk� nastaven�:',
    13 => 'Pos�lat na konci ka�d�ho dne v�tah z weblogu emailem',
    14 => 'Toto heslo bylo n�hodn� vygenerov�no syst�mem. Doporu�uje se zm�nit co nejd��ve. Pro zm�nu hesla se p�ihla�te a zm�nte si ho pot� v menu Informace o ��tu v U�ivatelsk�m rozhran�.',
    15 => "V� {$_CONF['site_name']} ��et byl vytvo�en. M��ete se p�ihl�sit, n�e jsou Va�e p�ihla�ovac� data. Pros�m uschovejt si tento email pro budouc� reference.",
    16 => 'Informace o ��tu',
    17 => '��et neexistuje',
    18 => 'Email se zd� b�t v nespr�vn�m form�tu',
    19 => 'U�ivatel nebo email ji� existuje',
    20 => 'Email se zd� b�t v nespr�vn�m form�tu',
    21 => 'Chyba',
    22 => "Registrace na {$_CONF['site_name']}!",
    23 => "Anonymn� u�ivatel� - Host� nemohou nap��klad komentovat �i p�id�vat �l�nky.<br>Vytvo�en� ��tu V�m umo�n� vyu��vat v�ech funkc� na {$_CONF['site_name']}. <br>Va�e emailov� adresa nebude <b><i>nikdy a nikde</i></b> zve�ejn�na na t�chto str�nk�ch.",
    24 => 'Va�e heslo bude posl�no na v�mi zadanou emailovou adresu.',
    25 => 'Zapomenut� heslo?',
    26 => 'Vlo�te Va�e p�ihla�ovac� jm�no a klepn�te na Poslat-heslo a nov� heslo V�m bude zasl�no na V�mi zadanou emailovou adresu.',
    27 => 'Registrovat nyn�!',
    28 => 'Poslat-heslo',
    29 => 'odhl�en od',
    30 => 'p�ihl�en od',
    31 => 'Tato funkce vy�aduje p�ihl�en�',
    32 => 'Podpis',
    33 => 'Nezobraz� se ve�ejn�',
    34 => 'Toto je va�e prav� jm�no',
    35 => 'Jen pro zm�nu hesla',
    36 => 'Na za��tku s http://',
    37 => 'Bude pou�it v koment���ch',
    38 => 'Toto je o V�s! Kdokoli si to m��e p�e��st',
    39 => 'V� ve�ejn� PGP kl��',
    40 => 'Bez ikon Sekc�',
    41 => 'Chci b�t Moder�torem sekce',
    42 => 'Form�t data',
    43 => 'Maxim�ln� po�et �l�nk�',
    44 => 'Bez blok�',
    45 => 'Vlastn� nastaven� pro',
    46 => 'Bez t�chto polo�ek pro',
    47 => 'Nastaven� blok� pro',
    48 => 'Sekce',
    49 => 'Nezobrazovat ikony',
    50 => 'Od�krtn�te pokud v�s nezaj�m�',
    51 => 'Jen novinky',
    52 => 'Syst�mov� nastaven� - ',
    53 => 'Dost�vat �l�nky na konci dne emailem',
    54 => 'Za�krtn�te to co nechcete zobrazovat.',
    55 => 'Pokud nech�te od�krtl�, bude pou�ito p�vodn� nastaven� - to co je tu�n� bude zobrazov�no.  Pro vlastn� nastaven� za�krtn�te jen to co chcete zobrazovat.',
    56 => 'Auto�i',
    57 => 'Nastaven� zobrazov�n� polo�ek pro',
    58 => '�azen�',
    59 => 'Maxim�ln� po�et koment���',
    60 => 'Jak chcete zobrazovat koment��e?',
    61 => 'Nejnov�j�� nebo nejstar�� nejd��ve?',
    62 => 'Syst�mov� nastaven� - 100',
    63 => "Va�e heslo bude posl�no na v�mi zadanou emailovou adresu. Postupujte podle zaslan�ch instrukc� pro p�ihl�en� do {$_CONF['site_name']}",
    64 => 'Nastaven� koment��� pro',
    65 => 'Zkuste se p�ihl�sit znovu',
    66 => "Spletl jste se v zad�n�.  Pros�m zkuste to znovu. Nebo jste  <a href=\"{$_CONF['site_url']}/users.php?mode=new\"><b>nov� u�ivatel</b></a>?",
    67 => 'U�ivatelem od',
    68 => 'Pamatovat si mne',
    69 => 'Jak dlouho si V�s syst�m bude pamatovat.',
    70 => "P�izp�soben� vzhledu a obsahu {$_CONF['site_name']}",
    71 => "P�izp�soben� vzhledu na {$_CONF['site_name']} v�m umo�n� nastavit si vlastn� vzhled a �azen� polo�ek nez�visle na nastaven� pro hosty.  Pro tato nastaven� se mus�te <a href=\"{$_CONF['site_url']}/users.php?mode=new\">p�ihl�sit</a> na {$_CONF['site_name']}. <br> Jste u�ivatelem?  Pak pou�ijte p�ihla�ovac� formul�� vlevo!",
    72 => 'Grafick� t�ma',
    73 => 'Jazyk',
    74 => 'Vyberte jak m� weblog vypadat',
    75 => 'Zas�l�n� sekc�',
    76 => 'Tyto sekce v�m budou zas�l�na emailem koncem ka�d�ho dne. Pros�m vyb�rejte jen sekce, kter� v�s zaj�maj�!',
    77 => 'Foto',
    78 => 'P�id� Va�e foto (do velikosti 96x96px)!',
    79 => 'Za�krtnout pro smaz�n� fota',
    80 => 'P�ihl�sit',
    81 => 'Zaslat email',
    82 => 'Posledn�ch 10 �l�nk� u�ivatele',
    83 => 'Publika�n� statistika u�ivatele',
    84 => 'Celkov� publikac�:',
    85 => 'Celkov� koment���:',
    86 => 'Naj�t v�e od',
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
    1 => 'Nic nov�ho k zobrazen�',
    2 => '��dn� nov� �l�nky k zobrazen�.  Mo�n� nejsou ��dn� novinky, nebo jste zadali �patn� podm�nky filtrov�n�',
    3 => ' pro sekci %s',
    4 => 'Nejnov�j�� �l�nek',
    5 => 'Dal��',
    6 => 'P�ede�l�',
    7 => 'First',
    8 => 'Last'
);

###############################################################################
# profiles.php

$LANG08 = array(
    1 => 'Nastala chyba p�i odes�l�n� emailu, zkuste to pros�m znovu.',
    2 => 'Zpr�va �sp�n� odesl�na.',
    3 => 'Zkontrolujte si pros�m spr�vnost emailov� adresy.',
    4 => 'Pros�m vypl�te v�echna pole formul��e.',
    5 => 'Chyba: neexistuj�c� u�ivatel.',
    6 => 'Vznikla chyba.',
    7 => 'U�ivatelsk� profil ',
    8 => 'Jm�no',
    9 => 'URL str�nek u�ivatele',
    10 => 'Poslat email u�ivateli ',
    11 => 'Va�e jm�no:',
    12 => 'Poslat na:',
    13 => 'Hlavi�ka:',
    14 => 'Zpr�va:',
    15 => 'Pou�it� HTML tagy nebudou zm�n�ny.<br>',
    16 => 'Poslat zpr�vu',
    17 => 'Poslat �l�nek mailem',
    18 => 'Komu',
    19 => 'Kam',
    20 => 'Od koho',
    21 => 'Email odesilatele',
    22 => 'Pros�m vypl�te v�echna pole formul��e.',
    23 => "Tento email V�m byl posl�n %s z %s proto�e si tento u�ivatel mysl�, �e by V�s mohl zaujmut.  Bylo publikov�no na {$_CONF['site_url']}.   Toto NEN� SPAM a Va�e emailov� adresa nebyla nikde ulo�ena a nebude tud� pou�ita k jak�mkoli ��el�m.",
    24 => 'Koment�� k �l�nku na',
    25 => 'Mus�te b�t p�ihl�en jako u�ivatel pro pou�it� t�to funkce weblogu.<br>  Touto restrikc� se p�edch�z� zneu�it� syst�mu k spammingu!',
    26 => 'Tento formul�� umo��uje zaslat email vybran�mu u�ivateli.  Vypl�te pros�m v�echna pole.',
    27 => 'Kr�tk� zpr�va',
    28 => '%s naps�no: ',
    29 => "Toto jsou denn� novinky z {$_CONF['site_name']} pro ",
    30 => ' Denn� novinky pro ',
    31 => 'Titulek',
    32 => 'Datum',
    33 => 'Cel� �l�nek si m��ete p�e��st na ',
    34 => 'Konec zpr�vy',
    35 => 'Sorry, this user prefers not to receive any emails.'
);

###############################################################################
# search.php

$LANG09 = array(
    1 => 'roz���en� hled�n�',
    2 => 'Kl��ov� slova',
    3 => 'Sekce',
    4 => 'V�e',
    5 => 'Typ',
    6 => '�l�nky',
    7 => 'Koment��e',
    8 => 'Auto�i',
    9 => 'V�e',
    10 => 'Hled�n�',
    11 => 'V�sledky hled�n�',
    12 => 'odpov�daj�c� filtru',
    13 => 'V�sledky hled�n�: nic neodpov�d� zadan�mu filtru',
    14 => '��dn� v�sledky neodpov�daj� zadan�mu filtru',
    15 => 'Pros�m zkuste znovu.',
    16 => 'Titulek',
    17 => 'Datum',
    18 => 'Autor',
    19 => "Prohledat celou datab�zi nov�ch i archivn�ch polo�ek na {$_CONF['site_name']}",
    20 => 'Datum',
    21 => 'do',
    22 => '(Form�t data RRRR-MM-DD)',
    23 => 'Zhl�dnuto',
    24 => 'Nalezeno',
    25 => 'filtru odpov�daj�c�ch z celkem ',
    26 => 'polo�ek b�hem',
    27 => 'sekund',
    28 => '��dn� �l�nek nebo koment�� neodpov�d� zadan�mu filtru',
    29 => 'V�sledky vyhled�v�n� �l�nk� a koment���',
    30 => '��dn� v�sledky neodpov�daj� zadan�mu filtru',
    31 => 'This plug-in returned no matches',
    32 => 'Ud�lost',
    33 => 'URL',
    34 => 'Um�st�n�',
    35 => 'Cel� den',
    36 => '��dn� ud�losti neodpov�daj� zadan�mu filtru',
    37 => 'V�sledky hled�n�',
    38 => 'V�sledky hled�n� odkaz�',
    39 => 'Odkazy',
    40 => 'Ud�losti',
    41 => 'Alespo� 3 znaky v poli vyhled�v�n�.',
    42 => 'Pros�m zad�vejte datum v tomto form�tu: RRRR-MM-DD (rok-m�s�c-den).',
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
    1 => 'Celkov� statistika str�nek',
    2 => 'Souhrn po�adavk� na syst�m',
    3 => '�l�nky(koment��e) v syst�mu',
    4 => 'Anket(odpov�d�) v syst�mu',
    5 => 'Odkazy(jejich n�sledov�n�) v syst�mu',
    6 => 'Ud�losti v syst�mu',
    7 => 'Top Ten �l�nky',
    8 => 'Titulek �l�nku',
    9 => 'Zhl�dnuto',
    10 => '��dn� �l�nky zde nejsou.',
    11 => 'Top Ten komentovan�ch �l�nk�',
    12 => 'Koment��e',
    13 => '��dn� komentovan� �l�nky zde nejsou.',
    14 => 'Top Ten anket',
    15 => 'Anketn� ot�zka',
    16 => 'Hlas�',
    17 => '��dn� ankety zde nejsou.',
    18 => 'Top Ten okaz�',
    19 => 'Odkazy',
    20 => 'Zhl�dnuto',
    21 => '��dn� odkazy na kter� se klickalo zde nejsou.',
    22 => 'Top Ten emailem zaslan�ch �l�nk�',
    23 => 'Zasl�no emailem',
    24 => '��dn� emailem poslan� �l�nky zde nejsou.',
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
    1 => 'Souvisej�c�',
    2 => 'Poslat mailem',
    3 => 'Verze pro tisk�rnu',
    4 => 'Volby �l�nku',
    5 => 'PDF Story Format'
);

###############################################################################
# submit.php

$LANG12 = array(
    1 => 'Pro tento %s mus�te b�t p�ihl�en jako u�ivatel.',
    2 => 'P�ihl�sit',
    3 => 'Nov� u�ivatel',
    4 => 'P�id�n�',
    5 => 'P�idat odkaz',
    6 => 'Publikovat �l�nek',
    7 => 'Vy�adov�no p�ihl�en�',
    8 => 'Publikov�n�',
    9 => 'Pro publikov�n� na t�chto str�nk�ch n�sledujte pros�m tato prost� doporu�en�: <ul><li>Vypl�te v�echna povinn� pole<li>Zad�vejte kompletn� a p�esn� informace<li>Dvakr�t si zkontrolujte URL</ul>',
    10 => 'Titulek',
    11 => 'Odkaz',
    12 => 'Datum za��tku',
    13 => 'Datum konce&nbsp;&nbsp;&nbsp;',
    14 => 'Um�st�n�',
    15 => 'Popis',
    16 => 'Pokud je Jin�, specifikujte pros�m',
    17 => 'Kategorie',
    18 => 'Jin�',
    19 => 'P�e�t�te si',
    20 => 'Chyba: Chyb� Kategorie',
    21 => 'Pokud vybr�no "Jin�" vyberte pros�m i kategorii',
    22 => 'Chyba: nevypln�n� pole',
    23 => 'Pros�m vypl�te v�echna pole. V�e je povinn�.',
    24 => 'Publikace provedena',
    25 => 'Va�e %s publikace byla provedena.',
    26 => 'Omezen� rychlosti publikov�n�',
    27 => 'U�ivatel',
    28 => 'Sekce',
    29 => '�l�nek',
    30 => 'Posledn� publikace byla p�ed ',
    31 => " sekundami.  Tato str�nka vy�aduje {$_CONF['speedlimit']} sekund mezi publikacemi",
    32 => 'N�hled',
    33 => 'N�hled �l�nku',
    34 => 'Odhl�sit',
    35 => 'HTML tagy nejsou podporov�ny',
    36 => 'Typ publikace',
    37 => "P�id�n� ud�losti - {$_CONF['site_name']} p�id� tuto do Ve�ejn�ho kalend��e pokud si nevyberete jen p�id�n� do Osobn�ho kaend��e.<br><br>Pokud p�id�te ud�lost do Ve�ejn�ho kalend��e bude tato po kontrole administr�torem za�azena do Ve�ejn�ho kalend��e.",
    38 => 'P�idat ud�lost do',
    39 => 'Ve�ejn� kalend��',
    40 => 'Osobn� kalend��',
    41 => '�as konce&nbsp;&nbsp;&nbsp;',
    42 => '�as za��tku',
    43 => 'Ka�dodenn�',
    44 => 'Adresa 1',
    45 => 'Adresa 2',
    46 => 'M�sto',
    47 => 'Zem�',
    48 => 'Sm�rov� ��slo',
    49 => 'Typ ud�losti',
    50 => 'Ediovat typ ud�losti',
    51 => 'Um�st�n�',
    52 => 'Smazat',
    53 => 'Vytvo�it ��et'
);

###############################################################################
# ADMIN PHRASES - These are file phrases used in admin scripts
###############################################################################

###############################################################################
# admin/auth.inc.php

$LANG20 = array(
    1 => 'Autentikace vy�adov�na',
    2 => 'P��stup odep�en! Nespr�vn� p�ihla�ovac� �daje',
    3 => 'Neplatn� heslo pro u�ivatele',
    4 => 'U�ivatel:',
    5 => 'Heslo:',
    6 => 'Ka�d� p��stup do administr�torsk� ��sti str�nek je zapisov�n do log_file a je tam tak� kontrolov�n.<br>Tato str�nka je jen pro autorizovan� u�ivatele s administr�torsk�mi pr�vy.',
    7 => 'P�ihl�sit'
);

###############################################################################
# admin/block.php

$LANG21 = array(
    1 => 'Nedostate�n� administr�torsk� pr�va',
    2 => 'Nem�te povolen p��stup k t�to ��sti administrace.',
    3 => 'Editor blok�',
    4 => 'There was a problem reading this feed (see error.log for details).',
    5 => 'Titulek bloku',
    6 => 'Sekce',
    7 => 'V�e',
    8 => '�rove� pr�v bloku',
    9 => 'Po�ad� bloku',
    10 => 'Typ bloku',
    11 => 'Blok Port�lu',
    12 => 'Norm�ln� blok',
    13 => 'Volby Bloku Port�lu',
    14 => 'RDF URL',
    15 => 'Last RDF Update',
    16 => 'Volby bloku',
    17 => 'Obsah bloku',
    18 => 'Pros�m vypl�te Titulek bloku, �rove� pr�v a Obsah',
    19 => 'Mana�er blok�',
    20 => 'Titulek bloku',
    21 => '�rove� pr�v bloku',
    22 => 'Typ bloku',
    23 => 'Po�ad� bloku',
    24 => 'Sekce bloku',
    25 => 'Pro smaz�n� a editaci bloku, klepn�te na blok n�e.  Pro vytvo�en� nov�ho bloku klepn�te na Nov� blok v��e.',
    26 => 'Vzhled bloku',
    27 => 'PHP Blok',
    28 => 'Volby PHP Bloku',
    29 => 'Funkce bloku',
    30 => 'If you would like to have one of your blocks use PHP code, enter the name of the function above.  Your function name must start with the prefix "phpblock_" (e.g. phpblock_getweather).  If it does not have this prefix, your function will NOT be called.  We do this to keep people who may have hacked your Geeklog installation from putting arbitrary function calls that may be harmful to your system.  Be sure not to put empty parenthisis "()" after your function name.  Finally, it is recommended that you put all your PHP Block code in /path/to/geeklog/system/lib-custom.php.  That will allow the code to stay with you even when you upgrade to a newer version of Geeklog.',
    31 => 'Chyba v PHP Bloku.  Funkce, %s, neexistuje.',
    32 => 'Chyba - neexistuj�c� pole',
    33 => 'You must enter the URL to the .rdf file for portal blocks',
    34 => 'You must enter the title and the function for PHP blocks',
    35 => 'You must enter the title and the content for normal blocks',
    36 => 'You must enter the content for layout blocks',
    37 => '�patn� jm�no funkce PHP bloku',
    38 => 'Functions for PHP Bloky must have the prefix \'phpblock_\' (e.g. phpblock_getweather).  The \'phpblock_\' prefix is required for security reasons to prevent the execution of arbitrary code.',
    39 => 'Strana',
    40 => 'Vlevo',
    41 => 'Vpravo',
    42 => 'You must enter the blockorder and security level for Geeklog default blocks',
    43 => 'Jen na Homepage',
    44 => 'P��stup odep�en',
    45 => "You are trying to access a block that you don't have rights to.  This attempt has been logged. Please <a href=\"{$_CONF['site_admin_url']}/block.php\">go back to the block administration screen</a>.",
    46 => 'Nov� blok',
    47 => 'Administrace',
    48 => 'Jm�no bloku',
    49 => ' (bez mezer, mus� b�t unik�tn�)',
    50 => ' URL Help souboru',
    51 => 'v�etn� http://',
    52 => 'Pokud nech�te pr�zdn� - ikona helpu se nebude zobrazovat.',
    53 => 'Povolit',
    54 => 'ulo�it',
    55 => 'zru�it akci',
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
    1 => 'Editor ud�lost�',
    2 => 'Error',
    3 => 'Titulek ud�losti',
    4 => 'URL ud�losti',
    5 => 'Datum za��tku',
    6 => 'Datum konce&nbsp;&nbsp;&nbsp;',
    7 => 'Um�st�n� ud�losti',
    8 => 'Popis ud�losti',
    9 => '(v�etn� http://)',
    10 => 'Mus�te zadat datum/�as, popis a um�st�n� ud�losti!',
    11 => 'Mana�er ud�lost�',
    12 => 'Pro zm�nu a smaz�n� ud�losti, klepn�te na tuto n�e.  Pro vytvo�en� nov� ud�losti klepn�te na Nov� ud�lost v��e.',
    13 => 'Titulek ud�losti',
    14 => 'Datum za��tku',
    15 => 'Datum konce&nbsp;&nbsp;&nbsp;',
    16 => 'P��stup odep�en',
    17 => "Pokou��te se editovat ud�lost na n� nem�te dostate�n� pr�va.  Tento pokus byl zaznamen�n. Pros�m <a href=\"{$_CONF['site_admin_url']}/event.php\">vra�te se na administraci ud�lost�</a>.",
    18 => 'Nov� ud�lost',
    19 => 'Administrace',
    20 => 'ulo�it',
    21 => 'zru�it akci',
    22 => 'smazat',
    23 => 'Bad start date.',
    24 => 'Bad end date.',
    25 => 'End date is before start date.'
);

###############################################################################
# admin/story.php

$LANG24 = array(
    1 => 'P�ede�l� �l�nky',
    2 => 'Dal�� �l�nky',
    3 => 'Re�im',
    4 => 'Publika�n� re�im',
    5 => 'Editor �l�nk�',
    6 => 'Nejsou zde �l�nky',
    7 => 'Autor',
    8 => 'ulo�it',
    9 => 'n�hled',
    10 => 'zru�it akci',
    11 => 'smazat',
    12 => 'ID',
    13 => 'Titulek',
    14 => 'Sekce',
    15 => 'Datum publikace',
    16 => 'Intro Text',
    17 => 'Text',
    18 => 'Zhl�dnuto',
    19 => 'Koment��e',
    20 => 'Ping',
    21 => 'Send Ping',
    22 => 'Seznam �l�nk�',
    23 => 'Pro editaci nebo smaz�n� �l�nku klepn�te na jeho ��slo n�e. Pro zobrazen�,klepn�te na titulek �l�nku, kter� chcete vid�t. Pro vytvo�en� nov�ho �l�nku klepn�te na Nov� �l�nek v��e.',
    24 => 'The ID you chose for this story is already in use. Please use another ID.',
    25 => 'Error when saving story',
    26 => 'N�hled',
    27 => 'If you use [unscaledX] instead of [imageX], the image will be inserted at its original dimensions.',
    28 => '<p><b>PREVIEWING</b>: Previewing a story with images attached is best done by saving the article as a draft INSTEAD OF hitting the preview button.  Use the preview button only when images are not attached.',
    29 => 'Trackbacks',
    30 => 'File Upload Errors',
    31 => 'Pros�m vypln�e Autor, Titulek a Intro Text',
    32 => 'Zv�raznit',
    33 => 'V syt�mu m��e b�t jen jeden zv�razn�n� �l�nek (ten se bude zobrazovat v�dy jako prvn�)',
    34 => 'Verze pro tisk�rnu',
    35 => 'Ano',
    36 => 'Ne',
    37 => 'V�ce od',
    38 => 'V�ce z',
    39 => 'Posl�no emailem',
    40 => 'P��stup odep�en',
    41 => "Pokou��te se editovat odkaz na n�j� nem�te dostate�n� pr�va.  Tento pokus byl zaznamen�n.  M��ete si jen prohl�dnout �l�nky n�e. Pros�m <a href=\"{$_CONF['site_admin_url']}/story.php\">vra�te se na administraci �l�nk�</a> kdy� skon��te.",
    42 => "Pokou��te se editovat odkaz na n�j� nem�te dostate�n� pr�va.  Tento pokus byl zaznamen�n.  Pros�m <a href=\"{$_CONF['site_admin_url']}/story.php\">vra�te se na administraci �l�nk�</a>.",
    43 => 'Nov� �l�nek',
    44 => 'Administrace',
    45 => 'P��stup',
    46 => '<b>PAMATUJTE:</b> pokud zad�te datum v budoucnosti, tento �l�nek nebude publikov�n do tohoto data.  To znamen�, �e �l�nek nebude vid�t ani nebude zahrnut do vyhled�v�n� a do statistiky str�nek p�ed t�mto datem.',
    47 => 'Upload obr�zk�',
    48 => 'obr�zek',
    49 => 'vpravo',
    50 => 'vlevo',
    51 => 'k p�id�n� obr�zk� (max. velikost 200x200px) do �l�nku mus�te vlo�it speci�ln� form�tovan� text.<br>Tento text vypad� takto: [imageX](syst�m um�st� s�m), [imageX_right](syst�m um�st� vpravo od textu) nebo [imageX_left](syst�m um�st� vlevo od textu) - kde X je ��slo obr�zku je� je p�id�v�n.<br>PAMATUJTE: mus�te pou��t obr�zky je� jsou p�id�v�ny.  V opa�n�m p��pad� nebude mo�no publikovat �l�nek.<BR><P><B>N�HLED</B>: Pro n�hled �l�nku s obr�zky je nejl�pe pou��t n�hled Verze pro tisk�rnu.  Tla��tko <i>n�hled</i> pros�m pou��vejte jen pro prohl�en� �l�nk� bez obr�zk�.',
    52 => 'Smazat',
    53 => ' nepou�ito.  P�ed ulo�en�m zm�n mus�te vlo�it obr�zek do Intro textu nebo textu.',
    54 => 'P�idan� obr�zek nepou�it',
    55 => 'N�sleduj�c� chyby se vyskytly p�i publikaci va�eho �l�nku.  Pros�m opravte tyto chyby p�ed kone�nou publikac�.',
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
    75 => 'Full Featured'
);

###############################################################################
# admin/topic.php

$LANG27 = array(
    1 => 'Editor sekc�',
    2 => 'ID sekce',
    3 => 'Jm�no sekce',
    4 => 'Ikona sekce',
    5 => '(bez mezer)',
    6 => 'Smaz�n� sekce zp�sob� smaz�n� �l�nk� a koment��� k nim i jej� ikony!',
    7 => 'Pros�m vypl�te ID sekce a Jm�no sekce',
    8 => 'Mana�er sekc�',
    9 => 'Pro �pravu a smaz�n� sekce klepn�te na jej� jm�no n�e.  Pro vytvo�en� nov� sekce klepn�te na Nov� sekce v��e.',
    10 => 'po�ad�',
    11 => '�l�nk�/str�nku',
    12 => 'P��stup odep�en',
    13 => "Pokou��te se editovat sekci na n� nem�te dostate�n� pr�va.  Tento pokus byl zaznamen�n. Pros�m <a href=\"{$_CONF['site_admin_url']}/topic.php\">vra�te se na administraci sekc�</a>.",
    14 => 'typ �azen�',
    15 => 'abecedn�',
    16 => 'nastaveno',
    17 => 'Nov� sekce',
    18 => 'Administrace',
    19 => 'ulo�it',
    20 => 'zru�it akci',
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
    1 => 'Editor u�ivatel�',
    2 => 'ID u�ivatele',
    3 => 'U�ivatel',
    4 => 'Jm�no u�ivatele',
    5 => 'Heslo',
    6 => '�rove� pr�v',
    7 => 'Emailov� adresa',
    8 => 'Homepage',
    9 => '(bez mezer)',
    10 => 'Please fill in the U�ivatel, Full name, Security Level and Email Address fields',
    11 => 'Mana�er u�ivatel�',
    12 => 'To modify or smazat a user, click on that user below.  To create a new user click the new user button to the left. You can do simple searches by entering parts of a U�ivatel,email address or fullname (e.g.*son* or *.edu) in the form below.',
    13 => '�rove� pr�v',
    14 => 'Datum registrace',
    15 => 'Nov� u�ivatel',
    16 => 'Administrace',
    17 => 'zm�na hesla',
    18 => 'zru�it akci',
    19 => 'smazat',
    20 => 'ulo�it',
    21 => 'U�ivatel ji� existuje.',
    22 => 'Chyba',
    23 => 'Hromadn� p�id�n�',
    24 => 'Hromadn� p�id�n� u�ivatel�',
    25 => 'You can import a batch of users into Geeklog.  The import file must a tab-delimited text file and must have the fields in the following order: full name, U�ivatel, email address.  Each user you import will be emailed with a random Heslo.  You must have one user entered per line.  Failure to follow these instructions will cause problems that may require manual work so double check your entries!',
    26 => 'Hledat',
    27 => 'Omezit na',
    28 => 'Za�krtnout pro smaz�n� obr�zku',
    29 => 'Cesta',
    30 => 'Import',
    31 => 'Nov� u�ivatel�',
    32 => 'HOTOVO. Importov�no %d a vyskytlo se %d chyb.',
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
    11 => 'Datum za��tku',
    12 => 'URL',
    13 => 'Kategorie',
    14 => 'Datum',
    15 => 'Sekce',
    16 => 'Jm�no u�ivatele',
    17 => 'Cel� jm�no u�ivatele',
    18 => 'Email',
    34 => 'Administrace weblogu',
    35 => 'P�id�n� �l�nku',
    36 => 'P�id�n� odkazu',
    37 => 'P�id�n� ud�losti',
    38 => 'P�idat',
    39 => 'Nyn� zde nen� nic k moderov�n�',
    40 => 'Publikace u�ivatele'
);

###############################################################################
# calendar.php

$LANG30 = array(
    1 => 'ned�le',
    2 => 'pond�l�',
    3 => '�ter�',
    4 => 'st�eda',
    5 => '�tvrtek',
    6 => 'p�tek',
    7 => 'sobota',
    8 => 'P�idat ud�lost',
    9 => 'Ud�losti weblogu',
    10 => 'Ud�losti u�ivatele',
    11 => 'Ve�ejn� kalend��',
    12 => 'Osobn� kalend��',
    13 => 'leden',
    14 => '�nor',
    15 => 'b�ezen',
    16 => 'duben',
    17 => 'kv�ten',
    18 => '�erven',
    19 => '�ervenec',
    20 => 'srpen',
    21 => 'z���',
    22 => '��jen',
    23 => 'listopad',
    24 => 'prosinec',
    25 => 'Zp�t na ',
    26 => 'Ka�d� den',
    27 => 'T�den',
    28 => 'Osobn� kalend�� pro',
    29 => 'Ve�ejn� kalend��',
    30 => 'smazat ud�lost',
    31 => 'P�idat ud�lost',
    32 => 'Ud�lost',
    33 => 'Datum',
    34 => '�as',
    35 => 'Rychl� p�id�n�',
    36 => 'Potvrdit',
    37 => 'Promi�te, Osobn� kalend�� nen� na t�chto str�nk�ch podporov�n',
    38 => 'Editor osobn�ch ud�lost�',
    39 => 'Den',
    40 => 'T�den',
    41 => 'M�s�c'
);

###############################################################################
# admin/mail.php

$LANG31 = array(
    1 => "{$_CONF['site_name']} - zas�l�n� email�",
    2 => 'Od',
    3 => 'Zp�tn�  adresa',
    4 => 'Hlavi�ka',
    5 => 'Zpr�va',
    6 => 'Poslat:',
    7 => 'V�em u�ivatel�m',
    8 => 'Admin',
    9 => 'Mo�nosti',
    10 => 'HTML',
    11 => 'Urgentn� zpr�va!',
    12 => 'Poslat',
    13 => 'Smazat',
    14 => 'Ignorovat u�iv. nastaven�',
    15 => 'Chyba p�i zas�l�n�: ',
    16 => 'Zasl�no: ',
    17 => "<a href={$_CONF['site_admin_url']}/mail.php>Poslat dal�� zpr�vu</a>",
    18 => 'Pro',
    19 => 'POZOR: chcete-li zaslat zpr�vu v�em u�ivatel�m, vyberte Logged-in Users skupinu z roletov� nab�dky.',
    20 => "Odesl�no <successcount> zpr�v a nezasl�no <failcount> zpr�v.  Detaily jsou n�e u ka�d�ho pokusu o zasl�n� zvlṻ.  M��ete se pokusit znovu <a href=\"{$_CONF['site_admin_url']}/mail.php\">zaslat zpr�vu</a> nebo <a href=\"{$_CONF['site_admin_url']}/moderation.php\">se vr�tit na str�nku administrace</a>.",
    21 => 'Chyby',
    22 => '�sp�n�',
    23 => 'Bez chyb',
    24 => 'Ne�sp�n�',
    25 => '- Vybrat skupinu -',
    26 => 'Pros�m vypl�te v�echna pole ve formul��i a vyberte skupinu u�ivatel� z roletov� nab�dky.'
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
    23 => 'ulo�it',
    24 => 'zru�it akci',
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
    1 => "Va�e p�ihla�ovac� heslo V�m bylo zasl�no na zadanou adresu. Pros�m n�sledujte prost� instrukce v po�t�. D�kujeme V�m za ��ast na {$_CONF['site_name']}",
    2 => "D�kujeme za p�id�n� �l�nku na {$_CONF['site_name']}..",
    3 => "D�kujeme za p�id�n� odkazu na {$_CONF['site_name']}..",
    4 => "D�kujeme za p�id�n� ud�losti na  {$_CONF['site_name']}..",
    5 => 'Va�e informace o ��tu byly ulo�eny.',
    6 => 'Va�e vlastn� nastaven� bylo ulo�eno.',
    7 => 'Va�e nastaven� koment��� bylo ulo�eno.',
    8 => 'Byl jste �sp�n� odhl�en.',
    9 => '�l�nek byl ulo�en.',
    10 => '�l�nek byl vymaz�n.',
    11 => 'Bloky byly ulo�eny.',
    12 => 'Blok byl odstran�n.',
    13 => 'Sekce byla ulo�ena.',
    14 => 'Sekce a �l�nky s koment��i v n� byla smaz�na.',
    15 => 'Odkaz byl ulo�en.',
    16 => 'Odkaz byl odstran�n.',
    17 => 'Ud�lost byla ulo�ena.',
    18 => 'Ud�lost byla odstran�na.',
    19 => 'Anketa byla ulo�ena.',
    20 => 'Anketa byla odstran�na.',
    21 => 'U�ivatel byl p�id�n/zm�n�n.',
    22 => 'U�ivatel byl odstran�n.',
    23 => 'Chyba v p�id�v�n� ud�losti do Osobn�ho kalend��e. Neexistuj�ci ID ud�losti.',
    24 => 'Ud�lost bylo vlo�ena do va�eho kalend��e',
    25 => 'Pro otev�en� osobn�ho kalend��e mus�te b�t p�ihl�en',
    26 => 'Ud�lost byla vymaz�na z va�eho kalend��e',
    27 => 'Vzkaz posl�n.',
    28 => 'The plug-in has been successfully saved',
    29 => 'Promi�te, Osobn� kalend�� nen� na t�chto str�nk�ch podporov�n',
    30 => 'P��stup odep�en',
    31 => 'Nem�te pr�va p��stupu k administraci �l�nk�.  V�echny neopr�vn�n� po�adavky a p��stupy jsou zaznamen�v�ny',
    32 => 'Nem�te pr�va p��stupu k administraci sekc�.  V�echny neopr�vn�n� po�adavky a p��stupy jsou zaznamen�v�ny',
    33 => 'Nem�te pr�va p��stupu k administraci blok�.  V�echny neopr�vn�n� po�adavky a p��stupy jsou zaznamen�v�ny',
    34 => 'Nem�te pr�va p��stupu k administraci odkaz�.  V�echny neopr�vn�n� po�adavky a p��stupy jsou zaznamen�v�ny',
    35 => 'Nem�te pr�va p��stupu k administraci ud�lost�.  V�echny neopr�vn�n� po�adavky a p��stupy jsou zaznamen�v�ny',
    36 => 'Nem�te pr�va p��stupu k administraci anket.  V�echny neopr�vn�n� po�adavky a p��stupy jsou zaznamen�v�ny',
    37 => 'Nem�te pr�va p��stupu k administraci u�ivatel�.  V�echny neopr�vn�n� po�adavky a p��stupy jsou zaznamen�v�ny',
    38 => 'Nem�te pr�va p��stupu k administraci plugin�.  V�echny neopr�vn�n� po�adavky a p��stupy jsou zaznamen�v�ny',
    39 => 'Nem�te pr�va p��stupu k administraci enailov�ch u�ivatel�.  V�echny neopr�vn�n� po�adavky a p��stupy jsou zaznamen�v�ny',
    40 => 'Syst�mov� zpr�vy',
    41 => 'Nem�te pr�va p��stupu k administraci slov.  V�echny neopr�vn�n� po�adavky a p��stupy jsou zaznamen�v�ny',
    42 => 'Va�e slovo bylo ulo�eno.',
    43 => 'Slovo bylo smaz�no.',
    44 => 'The plug-in was successfully installed!',
    45 => 'The plug-in was successfully deleted.',
    46 => 'Nem�te pr�va p��stupu k database backup utilit�.  V�echny neopr�vn�n� po�adavky a p��stupy jsou zaznamen�v�ny',
    47 => 'This functionality only works under *nix.  If you are running *nix as your operating system then your cache has been successfully cleared. If you are on Windows, you will need to search for files name adodb_*.php and remove them manually.',
    48 => "D�kujeme za registraci na {$_CONF['site_name']}.  Va�e heslo pro p��stup do syst�mu V�m bylo zasl�no na email, kter� jste zadali.",
    49 => 'Skupina byla �sp�n� ulo�ena.',
    50 => 'Skupina byla �sp�n� smaz�na.',
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
    'access' => 'Pr�va',
    'ownerroot' => 'Vlastn�k-Root',
    'group' => 'Skupina',
    'readonly' => 'Jen pro �ten�',
    'accessrights' => 'P��stupov� pr�va',
    'owner' => 'Vlastn�k',
    'grantgrouplabel' => 'Zaru�uje pr�va vy��� ne� pr�va skupiny pro editaci',
    'permmsg' => 'PAMATUJTE: <i>u�ivatel�</i> jsou p�ihl�en� u�ivatel� weblogu a <i>host�</i> jsou v�ichni, kdo si prohl�ej� weblog bez p�ihl�en�.',
    'securitygroups' => 'Skupiny/�rove� pr�v',
    'editrootmsg' => "Even though you are a User Administrator, you can't edit a root user without first being a root user yourself.  You can edit all other users except root users. Please note that all attempts to illegally edit root users are logged.  Please go back to the <a href=\"{$_CONF['site_admin_url']}/user.php\">User Administration page</a>.",
    'securitygroupsmsg' => 'Select the checkboxes for the groups you want the user to belong to.',
    'groupeditor' => 'Editor skupin u�ivatel�',
    'description' => 'Popis',
    'name' => 'Jm�no',
    'rights' => 'Pr�va',
    'missingfields' => 'Chyb�j�c� pole',
    'missingfieldsmsg' => 'You must supply the name and a description for a group',
    'groupmanager' => 'Mana�er skupin u�ivatel�',
    'newgroupmsg' => 'To modify or delete a group, click on that group below. To create a new group click new group above. Please note that core groups cannot be deleted because they are used v syst�mu.',
    'groupname' => 'Jm�no skupiny u�ivatel�',
    'coregroup' => 'Hlavn� skupina',
    'yes' => 'Ano',
    'no' => 'Ne',
    'corerightsdescr' => "This group is a core {$_CONF['site_name']} Group.  Therefore the rights for this group cannot be edited.  Below is a read-only list of the rights this group has access to.",
    'groupmsg' => 'Security Groups on this site are hierarchical.  By adding this group to any of the groups below you will giving this group the same rights that those groups have.  Where possible it is encouraged you use the groups below to give rights to a group.  If you need this group to have custom rights then you can select the rights to various site features in the section below called \'Rights\'.  To add this group to any of the ones below simply check the box next to the group(s) that you want.',
    'coregroupmsg' => "This group is a core {$_CONF['site_name']} Group.  Therefore the groups that this groups belongs to cannot be edited.  Below is a read-only list of the groups this group belongs to.",
    'rightsdescr' => 'A groups access to a certain right below can be given directly to the group OR to a different group that this group is a part of.  The ones you see below without a checkbox are the rights that have been given to this group because it belongs to another group with that right.  The rights with checkboxes below are rights that can be given directly to this group.',
    'lock' => 'Uzam�eno',
    'members' => 'U�ivatel�',
    'anonymous' => 'Host�',
    'permissions' => 'P�id�len� opr�vn�n�',
    'permissionskey' => 'R = �ten�, E = editace, edita�n� pr�va v sob� zahrnuj� i pr�vo ��st!',
    'edit' => 'Editace',
    'none' => 'Nen�',
    'accessdenied' => 'P��stup odep�en',
    'storydenialmsg' => "You do not have access to view this story.  This could be because you aren't a member of {$_CONF['site_name']}.  Please <a href=users.php?mode=new> become a member</a> of {$_CONF['site_name']} to receive full membership access!",
    'eventdenialmsg' => "You do not have access to view this event.  This could be because you aren't a member of {$_CONF['site_name']}.  Please <a href=users.php?mode=new> become a member</a> of {$_CONF['site_name']} to receive full membership access!",
    'nogroupsforcoregroup' => 'This group doesn\'t belong to any of the other groups',
    'grouphasnorights' => 'This group doesn\'t have access to any of the administrative features of this site',
    'newgroup' => 'Nov� skupina u�ivatel�',
    'adminhome' => 'Administrace',
    'save' => 'ulo�it',
    'cancel' => 'zru�it akci',
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
    6 => 'Kalend��',
    7 => 'Statistika',
    8 => 'Vlastn� nastaven�',
    9 => 'Hled�n�',
    10 => 'roz���en� hled�n�',
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
    1 => 'Je nutn� se p�ihl�sit',
    2 => 'Promi�te, pro p��stup je nutn� b�t p�ihl�en jako u�ivatel.',
    3 => 'P�ihl�sit',
    4 => 'Nov� u�ivatel'
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