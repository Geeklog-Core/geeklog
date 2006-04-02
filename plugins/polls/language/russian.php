<?php

###############################################################################
# russian.php
# This is the russian language page for the Geeklog Polls Plug-in!
#
# Copyright (C) 2006 Volodymyr V. Prokurashko
# vvprok@ukr.net
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

###############################################################################
# Array Format: 
# $LANGXX[YY]:	$LANG - variable name
#		  	XX - file id number
#			YY - phrase id number
###############################################################################


$LANG_POLLS = array(
    'polls'             => '������',
    'results'           => '����������',
    'pollresults'       => '���������� ������',
    'votes'             => '�������',
    'vote'              => '����������',
    'pastpolls'         => '������� ������',
    'savedvotetitle'    => '����� ���������',
    'savedvotemsg'      => '��� ����� � ������ ��� ����',
    'pollstitle'        => '������',
    'pollquestions'     => '������� � ������ �������',
    'stats_top10'       => '10 ������������� �������',
    'stats_questions'   => '�������',
    'stats_votes'       => '�������',
    'stats_none'        => '�� ���� ����� ��� �������, ��� ��� ����� � ��� �� ���������.',
    'stats_summary'     => '������� (�������) � �������',
    'open_poll'         => '�������� ��� �����������'
);

###############################################################################
# admin/plugins/polls/index.php

$LANG25 = array(
    1 => '�����',
    2 => '����������, ������� ������ � ���� �� ���� �����.',
    3 => '����� ������',
    4 => "����� %s ���������",
    5 => '������������� �����',
    6 => 'ID ������',
    7 => '(�� ������������ �������)',
    8 => '���������� �� ������� ��������',
    9 => '������',
    10 => '������ / ������',
    11 => "�� ����� ������� � ������ �� ������� ������ %s ��������� ������",
    12 => "�� ����� ������� � ������ � ������� ������ %s ��������� ������",
    13 => '������� �����',
    14 => '���������',
    15 => '��������',
    16 => '�������',
    17 => '����������, ������� ID ������',
    18 => '������ �������',
    19 => '��� �� �������� ��� ������� �����, ������� ��� ������ ��������������, ������� ���������� ����.  ��� �� ������� ����� �����, �������� "������� �����" ����.',
    20 => '�������������',
    21 => '������ ��������',
    22 => "�� ��������� �������� ������ � ������ � ������������� ������� �������.  ��� ������� ��������. ����������, <a href=\"{$_CONF['site_admin_url']}/poll.php\">��������� � �����������������a>.",
    23 => '����� �����',
    24 => '�����������������',
    25 => '��',
    26 => '���',
    27 => '�������������',
    28 => '�������',
    29 => '�����',
    30 => '���������� ����������',
);

$PLG_polls_MESSAGE19 = '��� ����� ������� �������.';
$PLG_polls_MESSAGE20 = 'Your poll has been successfully deleted.';

?>
