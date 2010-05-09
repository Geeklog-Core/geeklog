<?php

###############################################################################
# slovenian.php - version 1.4.1
# This is the slovenian language page for the Geeklog Polls Plug-in!
# language file for geeklog version 1.4.1 beta by mb
# gape@gape.org ; za pripombe, predloge ipd ... pi�i na email
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

$LANG_POLLS = array(
    'polls' => 'Ankete',
    'results' => 'Rezultati',
    'pollresults' => 'Rezultati anket',
    'votes' => 'glasov',
    'vote' => 'Glasuj',
    'pastpolls' => 'Pretekle ankete',
    'savedvotetitle' => 'Glas shranjen',
    'savedvotemsg' => 'Tvoj glas je shranjen za anketo.',
    'pollstitle' => 'Ankete v sistemu',
    'polltopics' => 'Druge ankete',
    'stats_top10' => 'Najbolj�ih 10 anket',
    'stats_topics' => 'Rubrika ankete',
    'stats_votes' => 'Glasovi',
    'stats_none' => 'Izgleda, da na tem mestu ni anket ali pa �e nikoli ni nih�e glasoval.',
    'stats_summary' => 'Ankete (odgovori) v sistemu',
    'open_poll' => 'Odprto za glasovanje',
    'answer_all' => 'Prosim, odgovori na vsa preostala vpra�anja',
    'not_saved' => 'Rezultat ni shranjen',
    'upgrade1' => 'Namestil si novo razli�ico vti�nika za ankete. Prosim',
    'upgrade2' => 'nadgradi',
    'editinstructions' => 'Prosim, izpolni ID ankete, vsaj eno vpra�anje in dva odovora zanj.',
    'pollclosed' => 'Ta anketa je zaprta za glasovanje.',
    'pollhidden' => 'Si �e glasoval/a. Rezultati te ankete bodo prikazani �ele, ko bo glasovanja konec.',
    'start_poll' => 'Za�ni anketo',
    'no_new_polls' => 'Ni novih anket',
    'deny_msg' => 'Dostop do te ankete je zavrnjen. Ali je bila anketa premaknjena/odstranjena ali pa nima� zadostnih pravic.'
);

###############################################################################
# admin/plugins/polls/index.php

$LANG25 = array(
    1 => 'Na�in',
    2 => 'Vnesi prosim temo, vsaj eno vpra�anje in vsaj en odgovor zanj.',
    3 => 'Anketa ustvarjena',
    4 => 'Anketa %s shranjena',
    5 => 'Uredi anketo',
    6 => 'ID ankete',
    7 => '(ne uporabljaj presledkov)',
    8 => 'Prika�e se v anketnem bloku',
    9 => 'Tema',
    10 => 'Odgovori / Glasovi / Opombe',
    11 => 'Med pridobivanjem podatkov o odgovoru pri anketi %s je pri�lo do napake',
    12 => 'Med pridobivanjem podatkov o vpra�anju pri anketi %s je pri�lo do napake',
    13 => 'Ustvari anketo',
    14 => 'shrani',
    15 => 'prekli�i',
    16 => 'izbri�i',
    17 => 'Vnesi prosim ID ankete',
    18 => 'Seznam anket',
    19 => 'Za spremembo ali izbris ankete klikni na ikono za urejanje ankete. Za ustvarjenje nove ankete klikni na "Ustvari novo" zgoraj.',
    20 => 'Glasovalci',
    21 => 'Dostop zavrnjen',
    22 => "Posku�a� dostopiti do ankete, za katero nima� pravic. Ta poskus je bil zabele�en. Prosim, <a href=\"{$_CONF['site_admin_url']}/poll.php\">pojdi nazaj na zaslon za skrbni�tvo anket</a>.",
    23 => 'Nova anketa',
    24 => 'Skrbnikova vstopna stran',
    25 => 'Da',
    26 => 'Ne',
    27 => 'Uredi',
    28 => 'Po�lji',
    29 => 'I��i',
    30 => 'Omeji rezultate',
    31 => 'Vpra�anje',
    32 => 'To vpra�anje odstrani� iz ankete tako, da odstrani� njegovo besedilo',
    33 => 'Odprto za glasovanje',
    34 => 'Tema ankete:',
    35 => 'Ta anketa ima',
    36 => 've� vpra�anj.',
    37 => 'Skrij rezultate, ko je anketa odprta',
    38 => 'Ko je anketa odprta, lahko vidita rezultate le lastnik in tisti z dostopom do korena (root)',
    39 => 'Tema bo prikazana le, �e ima anketa ve� kot eno vpra�anje.',
    40 => 'Poglej vse odgovore'
);

$PLG_polls_MESSAGE15 = 'Tvoj komentar je odposlan v pregled in bo objavljen, ko ga odobri urednik.';
$PLG_polls_MESSAGE19 = 'Tvoja anketa je uspe�no shranjena.';
$PLG_polls_MESSAGE20 = 'Tvoja anketa je uspe�no izbrisana.';

// Messages for the plugin upgrade
$PLG_polls_MESSAGE3001 = 'Nadgradnja vti�nika ni podprta.';
$PLG_polls_MESSAGE3002 = $LANG32[9];

// Localization of the Admin Configuration UI
$LANG_configsections['polls'] = array(
    'label' => 'Ankete',
    'title' => 'Konfiguracija anket'
);

$LANG_confignames['polls'] = array(
    'pollsloginrequired' => 'Za ankete zahtevana prijava?',
    'hidepollsmenu' => 'Skrij napis Ankete v meniju?',
    'maxquestions' => 'Najve� vpra�anj na anketo',
    'maxanswers' => 'Najve� mo�nosti na vpra�anje',
    'answerorder' => 'Razvrsti rezultate ...',
    'pollcookietime' => 'Pi�kotek glasovalca velja',
    'polladdresstime' => 'IP-naslov glasovalca velja',
    'delete_polls' => 'Izbri�i ankete skupaj z lastnikom?',
    'aftersave' => 'Po shranitvi ankete',
    'default_permissions' => 'Prednastavljene pravice ankete',
    'newpollsinterval' => 'Interval za nove ankete',
    'hidenewpolls' => 'Nove ankete',
    'title_trim_length' => 'Kraj�anje dol�ine naslova',
    'meta_tags' => 'Omogo�i Meta Tags'
);

$LANG_configsubgroups['polls'] = array(
    'sg_main' => 'Glavne nastavitve'
);

$LANG_fs['polls'] = array(
    'fs_main' => 'Splo�ne nastavitve anket',
    'fs_whatsnew' => 'Blok Kaj je novega',
    'fs_permissions' => 'Prednastavljene pravice'
);

// Note: entries 0, 1, and 12 are the same as in $LANG_configselects['Core']
$LANG_configselects['polls'] = array(
    0 => array('Da' => 1, 'Ne' => 0),
    1 => array('Da' => 'velja', 'Ne' => 'ne velja'),
    2 => array('Kot odposlano' => 'submitorder', 'Po glasovih' => 'voteorder'),
    5 => array('Skrij' => 'hide', 'Prika�i - uporabi spremenjeni datum' => 'modified', 'Prika�i - uporabi ustvarjeni datum' => 'created'),
    9 => array('Naprej na anketo' => 'item', 'Prika�i skrbnikov seznam' => 'list', 'Prika�i javno stran' => 'plugin', 'Prika�i vstopno stran' => 'home', 'Prika�i skrbnikovo stran' => 'admin'),
    12 => array('Ni dostopa' => 0, 'Samo za branje' => 2, 'Branje-pisanje' => 3)
);

?>
