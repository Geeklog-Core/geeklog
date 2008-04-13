<?php

###############################################################################
# czech.php
# This is the czech language (ISO 8859-2) page for the Geeklog Calendar Plug-in!
#
# Copyright (C) 2007 Ondrej Rusek
# rusek@gybon.cz
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
# $LANGXX[YY]:	$LANG - variable name
#		  	XX - file id number
#			YY - phrase id number
###############################################################################

# index.php
$LANG_CAL_1 = array(
    1 => 'Kalend�� ud�lost�',
    2 => 'Bohu�el. ��dn� ud�losti k zobrazen�.',
    3 => 'Kdy',
    4 => 'Kde',
    5 => 'Popis',
    6 => 'P�idat ud�lost',
    7 => 'Bl��c� se ud�losti',
    8 => 'By adding this event to your calendar you can quickly view only the events you are interested in by clicking "My Calendar" from the User Functions area.',
    9 => 'P�idat do osobn�ho kalend��e.',
    10 => 'Odebrat z m�ho kalend��e',
    11 => "P�idat ud�lost do osobn�ho kalend��e u�ivatele %s",
    12 => 'Ud�lost',
    13 => 'Za��tek',
    14 => 'Konec',
    15 => 'Zp�t na kalend��',
    16 => 'Kalend��',
    17 => 'Po��te�n� datum',
    18 => 'Koncov� datum',
    19 => 'Po�adavky kalend��e',
    20 => 'Titulek',
    21 => 'Po��te�n� datum',
    22 => 'URL',
    23 => 'Tvoje ud�losti',
    24 => 'Ud�losti webu',
    25 => '��dn� bl��c� se ud�losti',
    26 => 'Poslat ud�lost',
    27 => "Odesl�n�m ud�losti pro {$_CONF['site_name']} p�id�te va�i ud�lost do hlavn�ho kalend��e. Po odesl�n� bude ud�lost podrobena schv�len� a pot� bude publikov�na v hlavn�m kalend��i.",
    28 => 'Titulek',
    29 => '�as konce',
    30 => '�as za��tku',
    31 => 'V�echny ud�losti dne',
    32 => 'Adresa 1',
    33 => 'Adresa 2',
    34 => 'M�sto',
    35 => 'St�t',
    36 => 'PS�',
    37 => 'Typ ud�losti',
    38 => 'Editovat typy ud�lost�',
    39 => 'Um�st�n�',
    40 => 'P�idat ud�lost do',
    41 => 'Hlavn� kalend��',
    42 => 'Osobn� kalend��',
    43 => 'Odkaz',
    44 => 'HTML tagy nejsou povoleny',
    45 => 'Odeslat',
    46 => 'Ud�losti v syst�mu',
    47 => 'Top Ten ud�lost�',
    48 => 'Kliknut�',
    49 => '��dn� ud�losti.',
    50 => 'Ud�losti',
    51 => 'Vymazat'
);

$_LANG_CAL_SEARCH = array(
    'results' => 'V�sledky kalend��e',
    'title' => 'Titulek',
    'date_time' => 'Datum & �as',
    'location' => 'Um�st�n�',
    'description' => 'Popis'

);

###############################################################################
# calendar.php ($LANG30)

$LANG_CAL_2 = array(
    8 => 'P�idat osobn� ud�lost',
    9 => '%s ud�lost',
    10 => 'Ud�losti pro',
    11 => 'Hlavn� kalend��',
    12 => 'M�j kalend��',
    25 => 'Zp�t do ',
    26 => 'Cel� den',
    27 => 'T�den',
    28 => 'Osobn� kalend�� pro',
    29 => 'Ve�ejn� kalend��',
    30 => 'vymazat ud�lost',
    31 => 'P�idat',
    32 => 'Ud�lost',
    33 => 'Datum',
    34 => '�as',
    35 => 'Rychle p�idat',
    36 => 'Odeslat',
    37 => 'Bohu�el, pou�it� osobn�ho kalend��e nen� povoleno',
    38 => 'Osobn� editor ud�lost�',
    39 => 'Den',
    40 => 'T�den',
    41 => 'M�s�c',
    42 => 'P�idat hlavn� ud�lost',
    43 => 'Po�adavky ud�lost�',
);

###############################################################################
# admin/plugins/calendar/index.php, formerly admin/event.php ($LANG22)

$LANG_CAL_ADMIN = array(
    1 => 'Editor ud�lost�',
    2 => 'Chyba',
    3 => 'Post Mode',
    4 => 'URL ud�losti',
    5 => 'Datum za��tku',
    6 => 'Datum konce',
    7 => 'Um�st�n� ud�losti',
    8 => 'Popis ud�losti',
    9 => '(v�etn� http://)',
    10 => 'Mus�te zadata datum/�as, titulek a popis',
    11 => 'Spr�vce kalend��e',
    12 => 'Pro zm�nu nebo vymaz�n� ud�losti, klikn�te na ikonu ud�losti.  Pro vytvo�en� nov� ud�losti, klikn�te na "Vytvo�it novou". Kliknut�m na ikonu kopie vytvo��te kopii ud�losti.',
    13 => 'Autor',
    14 => 'Datum za��tku',
    15 => 'Datum konce',
    16 => '',
    17 => "P�istupujete k ud�losti, na kterou nem�te dostate�n� pr�va. Tento pokus byl zalogov�n. Pros�m, <a href=\"{$_CONF['site_admin_url']}/plugins/calendar/index.php\">vra�e ze zp�t na administraci ud�lost�</a>.",
    18 => '',
    19 => '',
    20 => 'ulo�it',
    21 => 'cancel',
    22 => 'vymazat',
    23 => 'Chybn� datum za��tku.',
    24 => 'Chybn� datum konce.',
    25 => 'Koncov� datum je p�ed datem za��tku.'
);

$LANG_CAL_MESSAGE = array(
    'save'      => 'Ud�lost byla �sp�n� ulo�ena.',
    'delete'    => 'Ud�lost byla �sp�n� vymaz�na.',
    'private'   => 'Ud�lost byla ulo�ena do va�eho osobn�ho kalend��e',
    'login'     => 'Nemohu otev��t v� osobn� kalend�� dokud se nep�ihl�s�te',
    'removed'   => 'Ud�lost byla odstran�na z va�eho osobn�ho kalend��e',
    'noprivate' => 'Bohu�el, osobn� kalend��e tento server nepodporuje',
    'unauth'    => 'Bohu�el, nem�te administr�torsk� p��stup. Tento v� pokus byl zalogov�n',
);

$PLG_calendar_MESSAGE4  = "D�kujeme za odesl�n� ud�losti pro {$_CONF['site_name']}.  Nyn� o�ek�v� potvrzen�.  Jakmile bude potvrzena, naleznete ji v <a href=\"{$_CONF['site_url']}/calendar/index.php\">kalend��i</a>.";
$PLG_calendar_MESSAGE17 = 'Ud�lost byla �sp�n� ulo�ena.';
$PLG_calendar_MESSAGE18 = 'Ud�lost byla �sp�n� vymaz�na.';
$PLG_calendar_MESSAGE24 = 'Ud�lost byla ulo�ena do kalend��e.';
$PLG_calendar_MESSAGE26 = 'Ud�lost byla vymaz�na.';

// Messages for the plugin upgrade
$PLG_calendar_MESSAGE3001 = 'Plugin upgrade not supported.';
$PLG_calendar_MESSAGE3002 = $LANG32[9];

?>
