<?php

###############################################################################
# japanese.php
# This is the Japanese language page for the Geeklog Polls Plug-in!
#
# Copyright (C) 2001 Tony Bibbs
# tony@tonybibbs.com
# Copyright (C) 2005 Trinity Bays
# trinity93@gmail.com
# Tranlated by Geeklog Japanese group SaY and Ivy
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
# Last Update 2007/01/30 by Ivy (Geeklog Japanese)

global $LANG32;

$LANG_POLLS = array(
    'polls'             => '���󥱡���',
    'results'           => '���',
    'pollresults'       => '��ɼ���',
    'votes'             => '��ɼ',
    'vote'              => '��ɼ����',
    'pastpolls'         => '���󥱡��Ȥΰ���',
    'savedvotetitle'    => '��ɼ����Ͽ����ޤ���',
    'savedvotemsg'      => '������ɼ����Ͽ����ޤ���',
    'pollstitle'        => '�罸��Υ��󥱡���',
    'polltopics'        => 'Other polls',
    'stats_top10'       => 'Top Ten Polls',
    'stats_topics'      => 'Poll Topic',
    'stats_votes'       => 'Votes',
    'stats_none'        => 'It appears that there are no polls on this site or no one has ever voted.',
    'stats_summary'     => 'Polls (Answers) in the system',
    'open_poll'         => 'Open for Voting',
    'answer_all'        => 'Please answer all remaining questions',
    'not_saved'         => 'Result not saved',
    'upgrade1'          => 'You installed a new version of the Polls plugin. Please',
    'upgrade2'          => 'upgrade',
    'editinstructions'  => 'Please fill in the Poll ID, at least one question and two answers for it.'
);

###############################################################################
# admin/plugins/polls/index.php

$LANG25 = array(
    1 => '�⡼��',
    2 => '����Ⱦ��ʤ��Ȥ��Ĥ����������Ϥ��Ƥ�������',
    3 => '��������',
    4 => "���󥱡��ȡ� %s �ˤ���¸����ޤ���",
    5 => '���󥱡��Ȥ��Խ�',
    6 => '���󥱡���ID',
    7 => '(���ڡ�����ޤޤʤ�����)',
    8 => '�ۡ���ڡ�����ɽ������',
    9 => '���䤹�뤳��',
    10 => '���� �� ��ɼ��',
    11 => "���󥱡���( %s )�������˥��顼������ޤ���",
    12 => "���󥱡���( %s )�μ�����ܤ˥��顼������ޤ���",
    13 => '���󥱡��Ȥκ���',
    14 => '��¸',
    15 => '���',
    16 => '���',
    17 => '���󥱡���ID�����Ϥ��Ƥ�������',
    18 => '���󥱡��Ȱ���',
    19 => '���󥱡��Ȥκ�����Խ��ϥ����ȥ뺸�Υ�������򥯥�å��������˺���������ϡֿ��������פ򥯥�å����Ƥ��������������ȥ�򥯥�å�����ȥ��󥱡��Ȥ�����Ǥ��ޤ���',
    20 => '��ɼ��',
    21 => '�������������ݤ���ޤ���',
    22 => "�������¤Τʤ����󥱡��Ȥ��Խ����褦�Ȥ��ޤ��������ι԰٤ϵ�Ͽ����ޤ���<a href=\"{$_CONF['site_admin_url']}/poll.php\">��ɼ�δ�������</a>����äƤ���������",
    23 => '�������󥱡���',
    24 => '��������',
    25 => '�Ϥ�',
    26 => '������',
    27 => '�Խ�',
    28 => '����',
    29 => '�������',
    30 => 'ɽ�����',
    31 => 'Question',
    32 => 'To remove this question from the poll, remove its question text',
    33 => 'Open for voting',
    34 => 'Poll Topic:',
    35 => 'This poll has',
    36 => 'more questions.',
    37 => 'Hide results while poll is open',
    38 => 'While the poll is open, only the owner &amp; root can see the results',
    39 => 'The topic will be only displayed if there are more than 1 questions.',
    40 => 'See all answers to this poll'
);

$PLG_polls_MESSAGE19 = '���󥱡��Ȥ���Ͽ����ޤ�����';
$PLG_polls_MESSAGE20 = '���󥱡��ȤϺ������ޤ�����';

// Messages for the plugin upgrade
$PLG_polls_MESSAGE3001 = 'Plugin upgrade not supported.';
$PLG_polls_MESSAGE3002 = $LANG32[9];

?>
