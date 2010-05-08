<?php

###############################################################################
# slovenian.php - version 1.7
# This is the slovenian language page for the Geeklog Calendar Plug-in!
# language file for geeklog version 1.7 by Mateja B.
# gape@gape.org ; za pripombe, predloge ipd. pi�i na e-naslov
#
# Copyright (C) 2001 Tony Bibbs
# tony@tonybibbs.com
# Copyright (C) 2005 Trinity Bays
# trinity93@gmail.com
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
# $LANGXX[YY]:  $LANG - variable name
#               XX    - file id number
#               YY    - phrase id number
###############################################################################

# index.php
$LANG_CAL_1 = array(
    1 => 'Koledar dogodkov',
    2 => 'Trenutno ni v koledar vpisanega nobenega dogodka.',
    3 => 'Kdaj',
    4 => 'Kje',
    5 => 'Opis',
    6 => 'Dodaj dogodek',
    7 => 'Prihajajo�i dogodki',
    8 => 'Ko bo novi dogodek dodan v tvoj osebni koledar, lahko s klikom na "Moj koledar" v meniju "Uporabni�ke funkcije" hitro pregleda� le tiste dogodke, ki te zanimajo.',
    9 => 'Dodaj v Moj koledar',
    10 => 'Odstrani iz Mojega koledarja',
    11 => 'Dodajanje dogodka v %s koledar',
    12 => 'Dogodek',
    13 => 'Za�etek',
    14 => 'Konec',
    15 => 'Nazaj na Koledar',
    16 => 'Koledar',
    17 => 'Datum za�etka',
    18 => 'Datum konca',
    19 => '�akajo�i dogodki',
    20 => 'Naslov',
    21 => 'Datum za�etka',
    22 => 'URL',
    23 => 'Tvoji dogodki',
    24 => 'Dogodki te strani',
    25 => 'Ni prihajajo�ih dogodkov',
    26 => 'Oddaj dogodek',
    27 => "Oddaja dogodka na spletnem mestu {$_CONF['site_name']} bo tvoj dogodek dodala na glavni koledar, od koder ga lahko uporabniki dodajo v svoje osebne koledarje. Ta funkcija <b>NI</b> namenjena shranjevanju osebnih dogodkov, kot so rojstni dnevi in obletnice.<br" . XHTML . "><br" . XHTML . ">Ko svoj dogodek odda�, bo poslan skrbnikom strani, in �e bo odobren, se bo pojavil v glavnem koledarju.",
    28 => 'Naslov',
    29 => 'Kon�ni �as',
    30 => 'Za�etni �as',
    31 => 'Celodnevni dogodek',
    32 => 'Naslov 1',
    33 => 'Naslov 2',
    34 => 'Mesto/Kraj',
    35 => 'Pokrajina',
    36 => 'Po�tna �tevilka',
    37 => 'Vrsta dogodka',
    38 => 'Uredi vrste dogodkov',
    39 => 'Prostor dogodka',
    40 => 'Dodaj dogodek v',
    41 => 'Glavni koledar',
    42 => 'Osebni koledar',
    43 => 'Povezava',
    44 => 'Oblikovanje HTML ni dovoljeno',
    45 => 'Oddaj',
    46 => 'Dogodki v sistemu',
    47 => 'Najbolj�ih 10 dogodkov',
    48 => 'Zadetki',
    49 => 'Izgleda, da na tem mestu ni dogodkov ali pa �e nikoli ni nih�e kliknil na nobenega.',
    50 => 'Dogodki',
    51 => 'Izbri�i'
);

$_LANG_CAL_SEARCH = array(
    'results' => 'Rezultati koledarja',
    'title' => 'Naslov',
    'date_time' => 'Datum & ura',
    'location' => 'Kraj',
    'description' => 'Opis'
);

###############################################################################
# calendar.php ($LANG30)

$LANG_CAL_2 = array(
    8 => 'Dodaj osebni dogodek',
    9 => '%s dogodek',
    10 => 'Dogodki za',
    11 => 'Glavni koledar',
    12 => 'Moj koledar',
    25 => 'Nazaj na ',
    26 => 'Ves dan',
    27 => 'Teden',
    28 => 'Osebni koledar za',
    29 => 'Javni koledar',
    30 => 'izbri�i dogodek',
    31 => 'Dodaj',
    32 => 'Dogodek',
    33 => 'Datum',
    34 => 'Ura',
    35 => 'Hitro dodajanje',
    36 => 'Oddaj',
    37 => 'Funkcija osebnega koledarja na tej strani ni omogo�ena',
    38 => 'Urejevalnik osebnih dogodkov',
    39 => 'Dan',
    40 => 'Teden',
    41 => 'Mesec',
    42 => 'Dodaj dogodek',
    43 => 'Dogodki'
);

###############################################################################
# admin/plugins/calendar/index.php, formerly admin/event.php ($LANG22)

$LANG_CAL_ADMIN = array(
    1 => 'Urejevalnik dogodkov',
    2 => 'Napaka',
    3 => 'Oblikovanje',
    4 => 'URL dogodka',
    5 => 'Za�etek dogodka',
    6 => 'Zaklju�ek dogodka',
    7 => 'Kraj dogodka',
    8 => 'Opis dogodka',
    9 => '(vklju�i http://)',
    10 => 'Dolo�iti mora� datume/ure, naslov dogodka in opis',
    11 => 'Upravljalnik koledarja',
    12 => 'Za spreminjanje ali izbris dogodka klikni na njegovo ikono za urejanje spodaj. Za ustvarjenje novega dogodka klikni na "Ustvari novega" zgoraj. Za ustvarjenje kopije �e obstoje�ega dogodka klikni na ikono za kopiranje.',
    13 => 'Avtor',
    14 => 'Za�etni datum',
    15 => 'Kon�ni datum',
    16 => '',
    17 => "Posku�a� dostopiti do dogodka, za katerega nima� pravic. Ta poskus je bil zabele�en. Prosim, <a href=\"{$_CONF['site_admin_url']}/plugins/calendar/index.php\">pojdi nazaj na zaslon za upravljanje dogodkov</a>.",
    18 => '',
    19 => '',
    20 => 'shrani',
    21 => 'prekli�i',
    22 => 'izbri�i',
    23 => 'Napa�en za�etni datum.',
    24 => 'Napa�en kon�ni datum.',
    25 => 'Kon�ni datum je pred za�etnim datumom.',
    26 => 'Izbri�i stare vnose',
    27 => 'To so dogodki, starej�i kot ',
    28 => ' mesecev. Za izbris prosim klikni na ikono ko�a spodaj ali izberi druga�en �asovni razpon:<br' . XHTML . '>Najdi vse vnose, starej�e kot ',
    29 => ' mesecev.',
    30 => 'Posodobi seznam',
    31 => 'Si prepri�an/a, da ho�e� res trajno izbrisati VSE izbrane uporabnike?',
    32 => 'Daj na seznam vse',
    33 => 'Noben dogodek ni izbran za brisanje',
    34 => 'ID dogodka',
    35 => 'se ni dalo izbrisati',
    36 => 'uspe�no izbrisano'
);

$LANG_CAL_MESSAGE = array(
    'save' => 'Tvoj dogodek je uspe�no shranjen.',
    'delete' => 'Dogodek je uspe�no izbrisan.',
    'private' => 'Dogodek je shranjen v tvoj koledar.',
    'login' => 'Ne morem odpreti tvojega osebnega koledarja, dokler se ne prijavi�',
    'removed' => 'Dogodek je uspe�no odstranjen iz tvojega osebnega koledarja',
    'noprivate' => 'Osebni koledarji na tem spletnem mestu niso omogo�eni',
    'unauth' => 'Nima� dostopa do strani za upravljanje dogodkov. Vsi poskusi dostopa do nepoobla��enih funkcij se bele�ijo.'
);

$PLG_calendar_MESSAGE4 = "Hvala, da si dogodek oddal/a na spletno mesto {$_CONF['site_name']}. Pred objavo ga bo pregledal eden od urednikov. �e bo odobren, bo objavljen in dan na razpolago bralcem te spletne strani v meniju <a href=\"{$_CONF['site_url']}/calendar/index.php\">Koledar</a>.";
$PLG_calendar_MESSAGE17 = 'Tvoj dogodek je uspe�no shranjen.';
$PLG_calendar_MESSAGE18 = 'Dogodek je uspe�no izbrisan.';
$PLG_calendar_MESSAGE24 = 'Dogodek je shranjen v tvoj koledar.';
$PLG_calendar_MESSAGE26 = 'Dogodek je uspe�no izbrisan.';

// Messages for the plugin upgrade
$PLG_calendar_MESSAGE3001 = 'Nadgradnja vti�nika ni podprta.';
$PLG_calendar_MESSAGE3002 = $LANG32[9];

// Localization of the Admin Configuration UI
$LANG_configsections['calendar'] = array(
    'label' => 'Koledar',
    'title' => 'Konfiguracija koledarja'
);

$LANG_confignames['calendar'] = array(
    'calendarloginrequired' => 'Za koledar zahtevana prijava?',
    'hidecalendarmenu' => 'Skrij napis Koledar v meniju?',
    'personalcalendars' => 'Omogo�i osebne koledarje?',
    'eventsubmission' => 'Omogo�i �akalno vrsto?',
    'showupcomingevents' => 'Poka�i prihajajo�e dogodke?',
    'upcomingeventsrange' => 'Razpon prihajajo�ih dogodkov',
    'event_types' => 'Vrste dogodkov',
    'hour_mode' => 'Na�in ure',
    'notification' => 'Obvestilo po e-po�ti?',
    'delete_event' => 'Izbri�i dogodke skupaj z lastnikom?',
    'aftersave' => 'Po shranitvi dogodka',
    'default_permissions' => 'Prednastavljene pravice dogodka'
);

$LANG_configsubgroups['calendar'] = array(
    'sg_main' => 'Glavne nastavitve'
);

$LANG_fs['calendar'] = array(
    'fs_main' => 'Splo�ne nastavitve koledarja',
    'fs_permissions' => 'Prednastavljene pravice'
);

// Note: entries 0, 1, 6, 9, 12 are the same as in $LANG_configselects['Core']
$LANG_configselects['calendar'] = array(
    0 => array('Da' => 1, 'Ne' => 0),
    1 => array('Da' => 'velja', 'Ne' => 'ne velja'),
    6 => array('12' => 12, '24' => 24),
    9 => array('Naprej na dogodek' => 'item', 'Prika�i skrbnikov seznam' => 'list', 'Prika�i koledar' => 'plugin', 'Prika�i vstopno stran' => 'home', 'Prika�i skrbnikovo stran' => 'admin'),
    12 => array('Ni dostopa' => 0, 'Samo za branje' => 2, 'Branje-pisanje' => 3)
);

?>
