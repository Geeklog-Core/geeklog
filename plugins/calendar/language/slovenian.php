<?php

###############################################################################
# slovenian.php - version 1.7
# This is the slovenian language page for the Geeklog Calendar Plug-in!
# language file for geeklog version 1.7 by Mateja B.
# gape@gape.org ; za pripombe, predloge ipd. piši na e-naslov
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
    7 => 'Prihajajoèi dogodki',
    8 => 'Ko bo novi dogodek dodan v tvoj osebni koledar, lahko s klikom na "Moj koledar" v meniju "Uporabniške funkcije" hitro pregledaš le tiste dogodke, ki te zanimajo.',
    9 => 'Dodaj v Moj koledar',
    10 => 'Odstrani iz Mojega koledarja',
    11 => 'Dodajanje dogodka v %s koledar',
    12 => 'Dogodek',
    13 => 'Zaèetek',
    14 => 'Konec',
    15 => 'Nazaj na Koledar',
    16 => 'Koledar',
    17 => 'Datum zaèetka',
    18 => 'Datum konca',
    19 => 'Èakajoèi dogodki',
    20 => 'Naslov',
    21 => 'Datum zaèetka',
    22 => 'URL',
    23 => 'Tvoji dogodki',
    24 => 'Dogodki te strani',
    25 => 'Ni prihajajoèih dogodkov',
    26 => 'Oddaj dogodek',
    27 => "Oddaja dogodka na spletnem mestu {$_CONF['site_name']} bo tvoj dogodek dodala na glavni koledar, od koder ga lahko uporabniki dodajo v svoje osebne koledarje. Ta funkcija <b>NI</b> namenjena shranjevanju osebnih dogodkov, kot so rojstni dnevi in obletnice.<br" . XHTML . "><br" . XHTML . ">Ko svoj dogodek oddaš, bo poslan skrbnikom strani, in èe bo odobren, se bo pojavil v glavnem koledarju.",
    28 => 'Naslov',
    29 => 'Konèni èas',
    30 => 'Zaèetni èas',
    31 => 'Celodnevni dogodek',
    32 => 'Naslov 1',
    33 => 'Naslov 2',
    34 => 'Mesto/Kraj',
    35 => 'Pokrajina',
    36 => 'Poštna številka',
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
    47 => 'Najboljših 10 dogodkov',
    48 => 'Zadetki',
    49 => 'Izgleda, da na tem mestu ni dogodkov ali pa še nikoli ni nihèe kliknil na nobenega.',
    50 => 'Dogodki',
    51 => 'Izbriši',
    'autotag_desc_event' => '[event: id alternate title] - Displays a link to an Event Link from the Calendar using the Event Title as the title. An alternate title may be specified but is not required.'
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
    30 => 'izbriši dogodek',
    31 => 'Dodaj',
    32 => 'Dogodek',
    33 => 'Datum',
    34 => 'Ura',
    35 => 'Hitro dodajanje',
    36 => 'Oddaj',
    37 => 'Funkcija osebnega koledarja na tej strani ni omogoèena',
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
    5 => 'Zaèetek dogodka',
    6 => 'Zakljuèek dogodka',
    7 => 'Kraj dogodka',
    8 => 'Opis dogodka',
    9 => '(vkljuèi http://)',
    10 => 'Doloèiti moraš datume/ure, naslov dogodka in opis',
    11 => 'Upravljalnik koledarja',
    12 => 'Za spreminjanje ali izbris dogodka klikni na njegovo ikono za urejanje spodaj. Za ustvarjenje novega dogodka klikni na "Ustvari novega" zgoraj. Za ustvarjenje kopije že obstojeèega dogodka klikni na ikono za kopiranje.',
    13 => 'Avtor',
    14 => 'Zaèetni datum',
    15 => 'Konèni datum',
    16 => '',
    17 => "Poskušaš dostopiti do dogodka, za katerega nimaš pravic. Ta poskus je bil zabeležen. Prosim, <a href=\"{$_CONF['site_admin_url']}/plugins/calendar/index.php\">pojdi nazaj na zaslon za upravljanje dogodkov</a>.",
    18 => '',
    19 => '',
    20 => 'shrani',
    21 => 'preklièi',
    22 => 'izbriši',
    23 => 'Napaèen zaèetni datum.',
    24 => 'Napaèen konèni datum.',
    25 => 'Konèni datum je pred zaèetnim datumom.',
    26 => 'Izbriši stare vnose',
    27 => 'To so dogodki, starejši kot ',
    28 => ' mesecev. Za izbris prosim klikni na ikono koša spodaj ali izberi drugaèen èasovni razpon:<br' . XHTML . '>Najdi vse vnose, starejše kot ',
    29 => ' mesecev.',
    30 => 'Posodobi seznam',
    31 => 'Si preprièan/a, da hoèeš res trajno izbrisati VSE izbrane uporabnike?',
    32 => 'Daj na seznam vse',
    33 => 'Noben dogodek ni izbran za brisanje',
    34 => 'ID dogodka',
    35 => 'se ni dalo izbrisati',
    36 => 'uspešno izbrisano'
);

$LANG_CAL_MESSAGE = array(
    'save' => 'Tvoj dogodek je uspešno shranjen.',
    'delete' => 'Dogodek je uspešno izbrisan.',
    'private' => 'Dogodek je shranjen v tvoj koledar.',
    'login' => 'Ne morem odpreti tvojega osebnega koledarja, dokler se ne prijaviš',
    'removed' => 'Dogodek je uspešno odstranjen iz tvojega osebnega koledarja',
    'noprivate' => 'Osebni koledarji na tem spletnem mestu niso omogoèeni',
    'unauth' => 'Nimaš dostopa do strani za upravljanje dogodkov. Vsi poskusi dostopa do nepooblašèenih funkcij se beležijo.'
);

$PLG_calendar_MESSAGE4 = "Hvala, da si dogodek oddal/a na spletno mesto {$_CONF['site_name']}. Pred objavo ga bo pregledal eden od urednikov. Èe bo odobren, bo objavljen in dan na razpolago bralcem te spletne strani v meniju <a href=\"{$_CONF['site_url']}/calendar/index.php\">Koledar</a>.";
$PLG_calendar_MESSAGE17 = 'Tvoj dogodek je uspešno shranjen.';
$PLG_calendar_MESSAGE18 = 'Dogodek je uspešno izbrisan.';
$PLG_calendar_MESSAGE24 = 'Dogodek je shranjen v tvoj koledar.';
$PLG_calendar_MESSAGE26 = 'Dogodek je uspešno izbrisan.';

// Messages for the plugin upgrade
$PLG_calendar_MESSAGE3001 = 'Nadgradnja vtiènika ni podprta.';
$PLG_calendar_MESSAGE3002 = $LANG32[9];

// Localization of the Admin Configuration UI
$LANG_configsections['calendar'] = array(
    'label' => 'Koledar',
    'title' => 'Konfiguracija koledarja'
);

$LANG_confignames['calendar'] = array(
    'calendarloginrequired' => 'Za koledar zahtevana prijava?',
    'hidecalendarmenu' => 'Skrij napis Koledar v meniju?',
    'personalcalendars' => 'Omogoèi osebne koledarje?',
    'eventsubmission' => 'Omogoèi èakalno vrsto?',
    'showupcomingevents' => 'Pokaži prihajajoèe dogodke?',
    'upcomingeventsrange' => 'Razpon prihajajoèih dogodkov',
    'event_types' => 'Vrste dogodkov',
    'hour_mode' => 'Naèin ure',
    'notification' => 'Obvestilo po e-pošti?',
    'delete_event' => 'Izbriši dogodke skupaj z lastnikom?',
    'aftersave' => 'Po shranitvi dogodka',
    'default_permissions' => 'Prednastavljene pravice dogodka',
    'autotag_permissions_event' => '[event: ] Permissions'
);

$LANG_configsubgroups['calendar'] = array(
    'sg_main' => 'Glavne nastavitve'
);

$LANG_tab['calendar'] = array(
    'tab_main' => 'General Calendar Settings',
    'tab_permissions' => 'Default Permissions',
    'tab_autotag_permissions' => 'Autotag Usage Permissions'
);

$LANG_fs['calendar'] = array(
    'fs_main' => 'Splošne nastavitve koledarja',
    'fs_permissions' => 'Prednastavljene pravice',
    'fs_autotag_permissions' => 'Autotag Usage Permissions'
);

// Note: entries 0, 1, 6, 9, 12 are the same as in $LANG_configselects['Core']
$LANG_configselects['calendar'] = array(
    0 => array('Da' => 1, 'Ne' => 0),
    1 => array('Da' => 'velja', 'Ne' => 'ne velja'),
    6 => array('12' => 12, '24' => 24),
    9 => array('Naprej na dogodek' => 'item', 'Prikaži skrbnikov seznam' => 'list', 'Prikaži koledar' => 'plugin', 'Prikaži vstopno stran' => 'home', 'Prikaži skrbnikovo stran' => 'admin'),
    12 => array('Ni dostopa' => 0, 'Samo za branje' => 2, 'Branje-pisanje' => 3),
    13 => array('No access' => 0, 'Use' => 2)
);

?>
