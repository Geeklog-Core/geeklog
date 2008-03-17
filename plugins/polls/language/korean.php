<?php

###############################################################################
# korean_utf-8.php
# This is the english language page for the Geeklog Polls Plug-in!
#
# Copyright (C) 2001 Tony Bibbs
# tony@tonybibbs.com
# Copyright (C) 2005 Trinity Bays
# trinity93@gmail.com
# Tranlated by IvySOHO Ivy(KOMMA Tetsuko/Kim Younghie)
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
# Last Update 2007/02/12 by Ivy (Geeklog Japanese)

###############################################################################
# Array Format: 
# $LANGXX[YY]:	$LANG - variable name
#		  	XX - file id number
#			YY - phrase id number
###############################################################################


$LANG_POLLS = array(
    'polls'             => '������Ʈ',
    'results'           => '���',
    'pollresults'       => '������Ʈ ���',
    'votes'             => '��ǥ',
    'vote'              => '��ǥ�ϱ�',
    'pastpolls'         => '������Ʈ ��ü����',
    'savedvotetitle'    => '��ǥ�� ��� �Ǿ����ϴ�',
    'savedvotemsg'      => '������ ��ǥ�� ��� �Ǿ����ϴ�',
    'pollstitle'        => '���� ���� ������Ʈ',
    'pollquestions'     => '�ٸ� ������Ʈ ����',
    'stats_top10'       => '������Ʈ �� 10',
    'stats_questions'   => '������Ʈ ����',
    'stats_votes'       => '��ǥ',
    'stats_none'        => '�� ����Ʈ���� ������Ʈ�� ���ų� ������Ʈ�� Ŭ���� ����� ���ų� ��� ���� ���Դϴ�.',
    'stats_summary'     => 'Polls (Answers) in the system',
    'open_poll'         => '���� ������Ʈ'
);

###############################################################################
# admin/plugins/polls/index.php

$LANG25 = array(
    1 => '���',
    2 => '������ ��� �Ѱ��� �ֿ伱���� �Է��Ͻñ� �ٶ��ϴ�.',
    3 => '�ۼ��Ͻ�',
    4 => "������Ʈ %s �� ���� �Ǿ����ϴ�",
    5 => '������Ʈ�� ����',
    6 => '������ƮID',
    7 => '(�����̽� ���� �ʵ���)',
    8 => 'Ȩ�������� ǥ���ϱ�',
    9 => '�����ϱ�',
    10 => '���� / ��ǥ�� / Ȯ��',
    11 => "������Ʈ(%s)�� �ֿ伱�ÿ� ������ �־����ϴ� ",
    12 => "������Ʈ(%s)�� �����׸� ������ �־����ϴ�",
    13 => '������Ʈ �ۼ�',
    14 => '����',
    15 => '����',
    16 => '����',
    17 => '������ƮID�� �Է��Ͻñ� �ٶ��ϴ�',
    18 => '������Ʈ ��ü����',
    19 => '������Ʈ�� ����, ������ ������ ���� �������� Ŭ��, �ű��ۼ��� ���� ���ű��ۼ����� Ŭ�� �Ͻñ� �ٶ��ϴ�. ������ Ŭ���Ͻø� ������Ʈ ���Ⱑ �����մϴ�.',
    20 => '�۾���',
    21 => '���ӿ� ���� �Ͽ����ϴ�',
    22 => "���������� ���� ������Ʈ�� �����Ϸ��� �ϼ̽��ϴ�.  �� ������ ��� �˴ϴ�.  <a 
href=\"{$_CONF['site_admin_url']}/poll.php\"> ������ ����ȭ������ </a>���� ���ư��ñ� �ٶ��ϴ�.",
    23 => '�ű� ������Ʈ',
    24 => '����ȭ��',
    25 => '��',
    26 => '�ƴϿ�',
    27 => '����',
    28 => '�˻�',
    29 => '�˻�����',
    30 => 'ǥ�ðǼ�',
);

$PLG_polls_MESSAGE19 = '������Ʈ�� ��� �Ǿ����ϴ�.';
$PLG_polls_MESSAGE20 = '������Ʈ�� ���� �Ǿ����ϴ�.';

// Messages for the plugin upgrade
$PLG_polls_MESSAGE3001 = 'Plugin upgrade not supported.';
$PLG_polls_MESSAGE3002 = $LANG32[9];

?>
