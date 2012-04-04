<?php

###############################################################################
# slovenian.php - version 1.4.1
# This is the slovenian language page for the Geeklog Polls Plug-in!
# language file for geeklog version 1.4.1 beta by mb
# gape@gape.org ; za pripombe, predloge ipd ... piši na email
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
    'voters' => 'voters',
    'vote' => 'Glasuj',
    'pastpolls' => 'Pretekle ankete',
    'savedvotetitle' => 'Glas shranjen',
    'savedvotemsg' => 'Tvoj glas je shranjen za anketo.',
    'pollstitle' => 'Ankete v sistemu',
    'polltopics' => 'Druge ankete',
    'stats_top10' => 'Najboljših 10 anket',
    'stats_topics' => 'Rubrika ankete',
    'stats_votes' => 'Glasovi',
    'stats_none' => 'Izgleda, da na tem mestu ni anket ali pa še nikoli ni nihèe glasoval.',
    'stats_summary' => 'Ankete (odgovori) v sistemu',
    'open_poll' => 'Odprto za glasovanje',
    'answer_all' => 'Prosim, odgovori na vsa preostala vprašanja',
    'not_saved' => 'Rezultat ni shranjen',
    'upgrade1' => 'Namestil si novo razlièico vtiènika za ankete. Prosim',
    'upgrade2' => 'nadgradi',
    'editinstructions' => 'Prosim, izpolni ID ankete, vsaj eno vprašanje in dva odovora zanj.',
    'pollclosed' => 'Ta anketa je zaprta za glasovanje.',
    'pollhidden' => 'Si že glasoval/a. Rezultati te ankete bodo prikazani šele, ko bo glasovanja konec.',
    'start_poll' => 'Zaèni anketo',
    'no_new_polls' => 'Ni novih anket',
    'autotag_desc_poll' => '[poll: id alternate title] - Displays a link to a poll using the Poll Topic as the title. An alternate title may be specified but is not required.',
    'autotag_desc_poll_vote' => '[poll_vote: id class:poll-autotag showall:1] - Displays a poll for voting. Class and showall not required. Class specifies the css class and Showall if set to 1, shows all questions',
    'autotag_desc_poll_result' => '[poll_result: id class:poll-autotag] - Displays the poll results. Class not required. Class specifies the css class.',
    'deny_msg' => 'Dostop do te ankete je zavrnjen. Ali je bila anketa premaknjena/odstranjena ali pa nimaš zadostnih pravic.'
);

###############################################################################
# admin/plugins/polls/index.php

$LANG25 = array(
    1 => 'Naèin',
    2 => 'Vnesi prosim temo, vsaj eno vprašanje in vsaj en odgovor zanj.',
    3 => 'Anketa ustvarjena',
    4 => 'Anketa %s shranjena',
    5 => 'Uredi anketo',
    6 => 'ID ankete',
    7 => '(ne uporabljaj presledkov)',
    8 => 'Prikaže se v anketnem bloku',
    9 => 'Tema',
    10 => 'Odgovori / Glasovi / Opombe',
    11 => 'Med pridobivanjem podatkov o odgovoru pri anketi %s je prišlo do napake',
    12 => 'Med pridobivanjem podatkov o vprašanju pri anketi %s je prišlo do napake',
    13 => 'Ustvari anketo',
    14 => 'shrani',
    15 => 'preklièi',
    16 => 'izbriši',
    17 => 'Vnesi prosim ID ankete',
    18 => 'Seznam anket',
    19 => 'Za spremembo ali izbris ankete klikni na ikono za urejanje ankete. Za ustvarjenje nove ankete klikni na "Ustvari novo" zgoraj.',
    20 => 'Glasovalci',
    21 => 'Dostop zavrnjen',
    22 => "Poskušaš dostopiti do ankete, za katero nimaš pravic. Ta poskus je bil zabeležen. Prosim, <a href=\"{$_CONF['site_admin_url']}/poll.php\">pojdi nazaj na zaslon za skrbništvo anket</a>.",
    23 => 'Nova anketa',
    24 => 'Skrbnikova vstopna stran',
    25 => 'Da',
    26 => 'Ne',
    27 => 'Uredi',
    28 => 'Pošlji',
    29 => 'Išèi',
    30 => 'Omeji rezultate',
    31 => 'Vprašanje',
    32 => 'To vprašanje odstraniš iz ankete tako, da odstraniš njegovo besedilo',
    33 => 'Odprto za glasovanje',
    34 => 'Tema ankete:',
    35 => 'Ta anketa ima',
    36 => 'veè vprašanj.',
    37 => 'Skrij rezultate, ko je anketa odprta',
    38 => 'Ko je anketa odprta, lahko vidita rezultate le lastnik in tisti z dostopom do korena (root)',
    39 => 'Tema bo prikazana le, èe ima anketa veè kot eno vprašanje.',
    40 => 'Poglej vse odgovore'
);

$PLG_polls_MESSAGE15 = 'Tvoj komentar je odposlan v pregled in bo objavljen, ko ga odobri urednik.';
$PLG_polls_MESSAGE19 = 'Tvoja anketa je uspešno shranjena.';
$PLG_polls_MESSAGE20 = 'Tvoja anketa je uspešno izbrisana.';

// Messages for the plugin upgrade
$PLG_polls_MESSAGE3001 = 'Nadgradnja vtiènika ni podprta.';
$PLG_polls_MESSAGE3002 = $LANG32[9];

// Localization of the Admin Configuration UI
$LANG_configsections['polls'] = array(
    'label' => 'Ankete',
    'title' => 'Konfiguracija anket'
);

$LANG_confignames['polls'] = array(
    'pollsloginrequired' => 'Za ankete zahtevana prijava?',
    'hidepollsmenu' => 'Skrij napis Ankete v meniju?',
    'maxquestions' => 'Najveè vprašanj na anketo',
    'maxanswers' => 'Najveè možnosti na vprašanje',
    'answerorder' => 'Razvrsti rezultate ...',
    'pollcookietime' => 'Piškotek glasovalca velja',
    'polladdresstime' => 'IP-naslov glasovalca velja',
    'delete_polls' => 'Izbriši ankete skupaj z lastnikom?',
    'aftersave' => 'Po shranitvi ankete',
    'default_permissions' => 'Prednastavljene pravice ankete',
    'autotag_permissions_poll' => '[poll: ] Permissions',
    'autotag_permissions_poll_vote' => '[poll_vote: ] Permissions',
    'autotag_permissions_poll_result' => '[poll_result: ] Permissions',
    'newpollsinterval' => 'Interval za nove ankete',
    'hidenewpolls' => 'Nove ankete',
    'title_trim_length' => 'Krajšanje dolžine naslova',
    'meta_tags' => 'Omogoèi Meta Tags'
);

$LANG_configsubgroups['polls'] = array(
    'sg_main' => 'Glavne nastavitve'
);

$LANG_tab['polls'] = array(
    'tab_main' => 'General Polls Settings',
    'tab_whatsnew' => 'What\'s New Block',
    'tab_permissions' => 'Default Permissions',
    'tab_autotag_permissions' => 'Autotag Usage Permissions'
);

$LANG_fs['polls'] = array(
    'fs_main' => 'Splošne nastavitve anket',
    'fs_whatsnew' => 'Blok Kaj je novega',
    'fs_permissions' => 'Prednastavljene pravice',
    'fs_autotag_permissions' => 'Autotag Usage Permissions'
);

// Note: entries 0, 1, and 12 are the same as in $LANG_configselects['Core']
$LANG_configselects['polls'] = array(
    0 => array('Da' => 1, 'Ne' => 0),
    1 => array('Da' => 'velja', 'Ne' => 'ne velja'),
    2 => array('Kot odposlano' => 'submitorder', 'Po glasovih' => 'voteorder'),
    5 => array('Skrij' => 'hide', 'Prikaži - uporabi spremenjeni datum' => 'modified', 'Prikaži - uporabi ustvarjeni datum' => 'created'),
    9 => array('Naprej na anketo' => 'item', 'Prikaži skrbnikov seznam' => 'list', 'Prikaži javno stran' => 'plugin', 'Prikaži vstopno stran' => 'home', 'Prikaži skrbnikovo stran' => 'admin'),
    12 => array('Ni dostopa' => 0, 'Samo za branje' => 2, 'Branje-pisanje' => 3),
    13 => array('No access' => 0, 'Use' => 2)
);

?>
