<?php

###############################################################################
# slovak.php
# This is the Slovak language file for the Geeklog Calendar plugin
#
# Copyright (C) 2010 Miroslav Fikar
# miroslav.fikar+geeklog@gmail.com
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
    1 => 'Kalend�r akci�',
    2 => 'Nie s� �iadne akcie na zobrazenie.',
    3 => 'Kedy',
    4 => 'Kde',
    5 => 'Opis',
    6 => 'Prida� akciu',
    7 => 'Nast�vaj�ce akcie',
    8 => 'By adding this event to your calendar you can quickly view only the events you are interested in by clicking "My Calendar" from the User Functions area.',
    9 => 'Prida� do osobn�ho kalend�ra.',
    10 => 'Odobra� z m�jho kalend�ra',
    11 => 'Prida� akciu do osobn�ho kalend�ra u��vate�a %s',
    12 => 'Akcia',
    13 => 'Za�iatok',
    14 => 'Koniec',
    15 => 'Sp� na kalend�r',
    16 => 'Kalend�r',
    17 => 'Za�iato�n� d�tum',
    18 => 'Koncov� d�tum',
    19 => 'Po�iadavky kalend�ra',
    20 => 'Nadpis',
    21 => 'Za�iato�n� d�tum',
    22 => 'URL',
    23 => 'Tvoje akcie',
    24 => 'Pl�novan� akcie',
    25 => '�iadne bl�iace sa akcie',
    26 => 'Posla� akciu',
    27 => "Odoslan�m akcie pre {$_CONF['site_name']} prid�te va�u akciu do hlavn�ho kalend�ra. Po odoslan� bude akcia post�pen� na schv�lenie a potom bude publikovan� v hlavnom kalend�ri.",
    28 => 'Nadpis',
    29 => '�as konca',
    30 => '�as za�iatku',
    31 => 'V�etky akcie d�a',
    32 => 'Adresa 1',
    33 => 'Adresa 2',
    34 => 'Mesto',
    35 => '�t�t',
    36 => 'PS�',
    37 => 'Typ akcie',
    38 => 'Upravi� typy akci�',
    39 => 'Umiestenie',
    40 => 'Prida� akciu do',
    41 => 'Hlavn� kalend�r',
    42 => 'Osobn� kalend�r',
    43 => 'Odkaz',
    44 => 'HTML tagy nie s� povolen�',
    45 => 'Odosla�',
    46 => 'Akcie v syst�me',
    47 => 'Top Ten akci�',
    48 => 'Kliknutie',
    49 => '�iadne akcie.',
    50 => 'Akcie',
    51 => 'Vymaza�'
);

$_LANG_CAL_SEARCH = array(
    'results' => 'V�sledky kalend�ra',
    'title' => 'Nadpis',
    'date_time' => 'D�tum & �as',
    'location' => 'Umiestenie',
    'description' => 'Opis'
);

###############################################################################
# calendar.php ($LANG30)

$LANG_CAL_2 = array(
    8 => 'Prida� osobn� akciu',
    9 => '%s akci�',
    10 => 'Akcie pre',
    11 => 'Hlavn� kalend�r',
    12 => 'M�j kalend�r',
    25 => 'Sp� na ',
    26 => 'Cel� de�',
    27 => 'T��de�',
    28 => 'Osobn� kalend�r pre',
    29 => 'Verejn� kalend�r',
    30 => 'Vymaza� akciu',
    31 => 'Prida�',
    32 => 'Akcia',
    33 => 'D�tum',
    34 => '�as',
    35 => 'R�chle prida�',
    36 => 'Odosla�',
    37 => 'Bohu�ia�, pou�itie osobn�ho kalend�ra nie je povolen�',
    38 => 'Osobn� editor akci�',
    39 => 'De�',
    40 => 'T��de�',
    41 => 'Mesiac',
    42 => 'Prida� hlavn� akciu',
    43 => 'Po�iadavky akci�'
);

###############################################################################
# admin/plugins/calendar/index.php, formerly admin/event.php ($LANG22)

$LANG_CAL_ADMIN = array(
    1 => 'Editor akci�',
    2 => 'Chyba',
    3 => 'Post Mode',
    4 => 'URL akcie',
    5 => 'D�tum za�iatku',
    6 => 'D�tum konca',
    7 => 'Umiestenie akcie',
    8 => 'Opis akcie',
    9 => '(vr�tane http://)',
    10 => 'Mus�te zada� d�tum/�as, nadpis a opis',
    11 => 'Spr�vca kalend�ra',
    12 => 'Pre zmenu alebo vymazanie akcie, kliknite na ikonu akcie.  Pre vytvorenie novej akcie, kliknite na "Vytvori� nov�". Kliknut�m na ikonu k�pie vytvor�te k�piu akcie.',
    13 => 'Autor',
    14 => 'D�tum za�iatku',
    15 => 'D�tum konca',
    16 => '',
    17 => "Pristupujete k akcie, na ktor� nem�te dostate�n� pr�va. Tento pokus byl zalogov�n. Pros�m, <a href=\"{$_CONF['site_admin_url']}/plugins/calendar/index.php\">vr�te sa sp� na administr�ciu akci�</a>.",
    18 => '',
    19 => '',
    20 => 'ulo�i�',
    21 => 'zru�i�',
    22 => 'vymaza�',
    23 => 'Chybn� d�tum za�iatku.',
    24 => 'Chybn� d�tum konca.',
    25 => 'Koncov� d�tum je pred d�tumom za�iatku.',
    26 => 'Delete old entries',
    27 => 'These are the events that are older than ',
    28 => ' months. Please click on the trashcan Icon on the bottom to delete them, or select a different timespan:<br' . XHTML . '>Find all entries that are older than ',
    29 => ' months.',
    30 => 'Update List',
    31 => 'Are You sure you want to permanently delete ALL selected users?',
    32 => 'List all',
    33 => 'No events selected for deletion',
    34 => 'Event ID',
    35 => 'could not be deleted',
    36 => 'Sucessfully deleted'
);

$LANG_CAL_MESSAGE = array(
    'save' => 'Akcia bola �spe�ne ulo�en�.',
    'delete' => 'Akcia bola �spe�ne vymazan�.',
    'private' => 'Akcia bola ulo�en� do v�ho osobn�ho kalend�ra',
    'login' => 'Nem��em otvori� v� osobn� kalend�r pokia� sa neprihl�site',
    'removed' => 'Akcia bola odstr�nen� z v�ho osobn�ho kalend�ra',
    'noprivate' => 'Bohu�ia�, osobn� kalend�re tento server nepodporuje',
    'unauth' => 'Bohu�ia�, nem�te administr�torsk� pr�stup. Tento v� pokus bol zalogovan�'
);

$PLG_calendar_MESSAGE4 = "�akujeme za odoslanie akcie pre {$_CONF['site_name']}.  Teraz o�ak�va potvrdenie.  Akon�hle bude potvrden�, n�jdete ju v <a href=\"{$_CONF['site_url']}/calendar/index.php\">kalend�ri</a>.";
$PLG_calendar_MESSAGE17 = 'Akcia bola �spe�ne ulo�en�.';
$PLG_calendar_MESSAGE18 = 'Akcia bola �spe�ne vymazan�.';
$PLG_calendar_MESSAGE24 = 'Akcia bola ulo�en� do kalend�ra.';
$PLG_calendar_MESSAGE26 = 'Akcia bola vymazan�.';

// Messages for the plugin upgrade
$PLG_calendar_MESSAGE3001 = 'Plugin upgrade not supported.';
$PLG_calendar_MESSAGE3002 = $LANG32[9];

// Localization of the Admin Configuration UI
$LANG_configsections['calendar'] = array(
    'label' => 'Calendar',
    'title' => 'Calendar Configuration'
);

$LANG_confignames['calendar'] = array(
    'calendarloginrequired' => 'Calendar Login Required?',
    'hidecalendarmenu' => 'Hide Calendar Menu Entry?',
    'personalcalendars' => 'Enable Personal Calendars?',
    'eventsubmission' => 'Enable Submission Queue?',
    'showupcomingevents' => 'Show upcoming Events?',
    'upcomingeventsrange' => 'Upcoming Events Range',
    'event_types' => 'Event Types',
    'hour_mode' => 'Hour Mode',
    'notification' => 'Notification Email?',
    'delete_event' => 'Delete Events with Owner?',
    'aftersave' => 'After Saving Event',
    'default_permissions' => 'Event Default Permissions'
);

$LANG_configsubgroups['calendar'] = array(
    'sg_main' => 'Main Settings'
);

$LANG_fs['calendar'] = array(
    'fs_main' => 'General Calendar Settings',
    'fs_permissions' => 'Default Permissions'
);

// Note: entries 0, 1, 6, 9, 12 are the same as in $LANG_configselects['Core']
$LANG_configselects['calendar'] = array(
    0 => array('True' => 1, 'False' => 0),
    1 => array('True' => true, 'False' => false),
    6 => array('12' => 12, '24' => 24),
    9 => array('Forward to Event' => 'item', 'Display Admin List' => 'list', 'Display Calendar' => 'plugin', 'Display Home' => 'home', 'Display Admin' => 'admin'),
    12 => array('No access' => 0, 'Read-Only' => 2, 'Read-Write' => 3)
);

?>
