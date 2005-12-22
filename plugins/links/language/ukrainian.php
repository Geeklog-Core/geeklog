<?php

###############################################################################
# ukrainian.php
# This is the ukrainian language page for the Geeklog Links Plug-in!
#
# Copyright (C) 2005 Vitaliy Biliyenko
# v.lokki@gmail.com
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
# $Id: ukrainian.php,v 1.1 2005/12/22 11:56:37 dhaun Exp $

###############################################################################
# Array Format:
# $LANGXX[YY]:	$LANG - variable name
#		  	XX - file id number
#			YY - phrase id number
###############################################################################


$LANG_LINKS= array(
    10 => '��������',
    14 => '���������',
    84 => '���������',
    88 => '���� ����� ��������',
    114 => '��� �������',
    116 => '������ ���������'
);

###############################################################################
# for stats

$LANG_LINKS_STATS = array(
    'links' => '˳��� (����) � ������',
    'stats_headline' => '10 �������������� ����',
    'stats_page_title' => '���������',
    'stats_hits' => 'ճ��',
    'stats_no_hits' => '�� ����� ���� ���� ��������, ��� �� ���� ���� �� ������������.',
);

###############################################################################
# for the search

$LANG_LINKS_SEARCH = array(
 'results' => '���������� � ��������',
 'title' => '���������',
 'date' => '������',
 'author' => '�����',
 'hits' => '����'
);
###############################################################################
# for the submission form

$LANG_LINKS_SUBMIT = array(
    1 => '�������� ���������',
    2 => '���������',
    3 => '��������',
    4 => '����',
    5 => '���� ����, ��������',
    6 => '�������: ³������ ��������',
    7 => '�������� "����", ����-�����, ������ ����� �������',
    8 => '���������',
    9 => 'URL',
    10 => '��������',
    11 => '������� ���������'
);

###############################################################################
# Messages for COM_showMessage the submission form

$PLG_links_MESSAGE1 = "������ �� �������� �� {$_CONF['site_name']} ���������.  ���� �������� ������ ��������� ��� ���������.  � ��� ��������� ���� ���� ������ �� ������ <a href={$_CONF['site_url']}/links/index.php>��� �������</a>.";
$PLG_links_MESSAGE2 = '���� ��������� ������ ���������.';
$PLG_links_MESSAGE3 = '��������� ������ ��������.';
$PLG_links_MESSAGE4 = "������ �� �������� �� {$_CONF['site_name']} ���������.  ���� ������ �� ������ <a href={$_CONF['site_url']}/links/index.php>��� �������</a>.";

###############################################################################
# admin/link.php

$LANG_LINKS_ADMIN = array(
    1 => '�������� ��������',
    2 => 'ID ���������',
    3 => '���������',
    4 => 'URL',
    5 => '��������',
    6 => '(��������� http://)',
    7 => '����',
    8 => 'ճ�� ���������',
    9 => '����',
    10 => '�� ������ ������� ���������, URL �� ����.',
    11 => '�������� ��������',
    12 => '��� ������ �� �������� ���������, �������� ���� ������ ����������� �����.  ��� �������� ���� ���������, ������ "�������� ����" ����.',
    14 => '�������� ���������',
    16 => '������ ����������',
    17 => "�� ���������� �������� ������ �� ���������, �� ����� � ��� ���� ����.  �� ������ ��������. ����-�����, <a href=\"{$_CONF['site_admin_url']}/plugins/links/index.php\">���������� �� �������������</a>.",
    20 => '���� ����, ��������',
    21 => '��������',
    22 => '���������',
    23 => '��������'
);

?>
