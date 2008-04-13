<?php

###############################################################################
# ukrainian.php
# This is the ukrainian language page for the Geeklog Static Page Plug-in!
#
# Copyright (C) 2006 Vitaliy Biliyenko
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

global $LANG32;

###############################################################################
# Array Format: 
# $LANGXX[YY]:	$LANG - variable name
#		  	XX - file id number
#			YY - phrase id number
###############################################################################


$LANG_STATIC= array(
    'newpage' => '���� �������',
    'adminhome' => '�������������',
    'staticpages' => '������� �������',
    'staticpageeditor' => '�������� ��������� �������',
    'writtenby' => '�����',
    'date' => '������� ��������',
    'title' => '���������',
    'content' => '����',
    'hits' => 'ճ��',
    'staticpagelist' => '������ ��������� �������',
    'url' => 'URL',
    'edit' => '����������',
    'lastupdated' => '������� ��������',
    'pageformat' => '������ �������',
    'leftrightblocks' => '˳��� �� ������ �����',
    'blankpage' => '������� �������',
    'noblocks' => '��� �����',
    'leftblocks' => '˳� �����',
    'addtomenu' => '������ �� ����',
    'label' => '̳���',
    'nopages' => '� ������ �� ���� ��������� �������',
    'save' => '��������',
    'preview' => '��������',
    'delete' => '��������',
    'cancel' => '�������',
    'access_denied' => '������ ����������',
    'access_denied_msg' => '�� ���������� ���������� �������� ������ �� ������ � ������ ������������� ��������� �������.  ���� �����, ������, �� �� ������ ������������ ������� �� ���� ������� ������� �� ���������',
    'all_html_allowed' => '���� HTML ���������',
    'results' => '���������� ����� ��������� �������',
    'author' => '�����',
    'no_title_or_content' => '��� ��������� �������� ��������� ���� <b>���������</b> �� <b>����</b>.',
    'no_such_page_anon' => '���� �����, ������ ..',
    'no_page_access_msg' => "�������, �� ��������� ����, �� �� �� ������, ��� �� � ������ {$_CONF['site_name']}. ���� �����, <a href=\"{$_CONF['site_url']}/users.php?mode=new\"> ������������� </a>�� {$_CONF['site_name']} ��� ��������� ������� �������",
    'php_msg' => 'PHP: ',
    'php_warn' => '������������: PHP ��� ���� ������� ���� �������� ���� �� �������� �� �����. ������ �������!!',
    'exit_msg' => '��� ������: ',
    'exit_info' => '������������� ������������ ��� �����.  ������� ���������� ��� ���������� �������� ������� �� ����������.',
    'deny_msg' => '������ �� ���� ������� ����������. ������� ��� ���� ���������/��������, ��� � ��� ���� ���������� �������.',
    'stats_headline' => '10 �������������� ��������� �������',
    'stats_page_title' => '��������� �������',
    'stats_hits' => 'ճ��',
    'stats_no_hits' => '�� ����� ���� ���� ��������� ������� ��� ���� �� �� ��������.',
    'id' => 'ID',
    'duplicate_id' => '������� ���� ID ��� ���� ������� ��� ���������������. ���� �����, ������� ����� ID.',
    'instructions' => '��� ������ �� �������� �������� �������, �������� �� �� ������ ����������� �����. ��� ����������� �������, �������� �� �� ���������. ��� �������� ���� �������� �������, ������ �������� ���� ����. �������� ������ ��ﳿ, ��� ��������� ������� �������.',
    'centerblock' => '����������� ����: ',
    'centerblock_msg' => '���� �� �������, �� �������� ������� ���� ���������� �� ����������� ���� �� ������� �������.',
    'topic' => '����: ',
    'position' => '���������: ',
    'all_topics' => '��',
    'no_topic' => '���� ������� �������',
    'position_top' => '���� �������',
    'position_feat' => 'ϳ��� �������� �����',
    'position_bottom' => '����� �������',
    'position_entire' => '�� ��� �������',
    'head_centerblock' => '����������� ����',
    'centerblock_no' => 'ͳ',
    'centerblock_top' => '����',
    'centerblock_feat' => '����. ������',
    'centerblock_bottom' => '���',
    'centerblock_entire' => '��� �������',
    'inblock_msg' => '� �����: ',
    'inblock_info' => '�������� �������� ������� � ����.',
    'title_edit' => '���������� �������',
    'title_copy' => '�������� �������',
    'title_display' => '����������� �������',
    'select_php_none' => '�� ���������� PHP',
    'select_php_return' => '���������� PHP (return)',
    'select_php_free' => '���������� PHP',
    'php_not_activated' => '������������ PHP � ��������� �������� �� ����������. ���� �����, ��������� � <a href="' . $_CONF['site_url'] . '/docs/staticpages.html#php">������������</a> ���� �������.',
    'printable_format' => '������ ��� �����',
	'edit' => '����������',
    'copy' => '��������',
    'limit_results' => '�������� ����������',
    'search' => '�����',
    'submit' => '³������'
);

// Messages for the plugin upgrade
$PLG_staticpages_MESSAGE3001 = 'Plugin upgrade not supported.';
$PLG_staticpages_MESSAGE3002 = $LANG32[9];

?>
