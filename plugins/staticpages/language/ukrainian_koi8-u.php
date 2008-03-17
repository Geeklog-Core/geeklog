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

###############################################################################
# Array Format: 
# $LANGXX[YY]:	$LANG - variable name
#		  	XX - file id number
#			YY - phrase id number
###############################################################################


$LANG_STATIC= array(
    'newpage' => '���� ���Ҧ���',
    'adminhome' => '��ͦΦ���������',
    'staticpages' => '������Φ ���Ҧ���',
    'staticpageeditor' => '�������� ��������� ���Ҧ���',
    'writtenby' => '�����',
    'date' => '������Τ ��������',
    'title' => '���������',
    'content' => '�ͦ��',
    'hits' => '���',
    'staticpagelist' => '������ ��������� ���Ҧ���',
    'url' => 'URL',
    'edit' => '����������',
    'lastupdated' => '������Τ ��������',
    'pageformat' => '������ ���Ҧ���',
    'leftrightblocks' => '���� �� ������ �����',
    'blankpage' => '������� ���Ҧ���',
    'noblocks' => '��� ���˦�',
    'leftblocks' => '�צ �����',
    'addtomenu' => '������ �� ����',
    'label' => '����',
    'nopages' => '� �����ͦ �� ����� ��������� ���Ҧ���',
    'save' => '��������',
    'preview' => '��������',
    'delete' => '��������',
    'cancel' => 'צ�ͦ����',
    'access_denied' => '������ ����������',
    'access_denied_msg' => '�� ����������� ���������� �������� ������ �� ������ � ���Ħ̦� ��ͦΦ��������� ��������� ���Ҧ���.  ���� �����, ������, �� �Ӧ ������ ������������ ������� �� æ�� ���Ҧ��� ������� �� ���������',
    'all_html_allowed' => '���� HTML ���������',
    'results' => '���������� ����� ��������� ���Ҧ���',
    'author' => '�����',
    'no_title_or_content' => '��� ����Ȧ��� �������Φ ��������� ���� <b>���������</b> �� <b>�ͦ��</b>.',
    'no_such_page_anon' => '���� �����, �צ�Ħ�� ..',
    'no_page_access_msg' => "�������, �� ��������� ����, �� �� �� �צ����, ��� �� � ������ {$_CONF['site_name']}. ���� �����, <a href=\"{$_CONF['site_url']}/users.php?mode=new\"> ���Ť��������� </a>�� {$_CONF['site_name']} ��� ��������� ������� �������",
    'php_msg' => 'PHP: ',
    'php_warn' => '������������: PHP ��� ���ϧ ���Ҧ��� ���� �������� ���� �� �����դ�� �� ��æ�. ������ ������Φ!!',
    'exit_msg' => '��� ������: ',
    'exit_info' => '������������� ��צ��������� ��� �����.  ������� ��צ�ͦ����� ��� ���������� �������� ������� �� ��צ�������.',
    'deny_msg' => '������ �� æ�� ���Ҧ��� ����������. ���Ҧ��� ��� ���� ����ͦ����/��������, ��� � ��� ����� צ���צ����� �������.',
    'stats_headline' => '10 ����������Φ��� ��������� ���Ҧ���',
    'stats_page_title' => '��������� ���Ҧ���',
    'stats_hits' => '���',
    'stats_no_hits' => '�� ����� ���Ԧ ����� ��������� ���Ҧ��� ��� Φ��� �� �� צ�צ�����.',
    'id' => 'ID',
    'duplicate_id' => '������� ���� ID ��� æ�� ���Ҧ��� ��� ����������դ����. ���� �����, ����Ҧ�� ����� ID.',
    'instructions' => '��� �ͦ���� �� �������� �������� ���Ҧ���, �����Φ�� �� �� ������ ����������� �����. ��� ����������� ���Ҧ���, �����Φ�� �� �� ���������. ��� �������� ���� �������� ���Ҧ���, ���Ҧ�� �������� ���� ���Ҧ. �����Φ�� ������ ��Ц�, ��� ���Ц����� ������� ���Ҧ���.',
    'centerblock' => '����������� ����: ',
    'centerblock_msg' => '���� �� צ�ͦ����, �� �������� ���Ҧ��� ���� ���������� �� ����������� ���� �� �����Φ� ���Ҧ�æ.',
    'topic' => '����: ',
    'position' => '���ͦ�����: ',
    'all_topics' => '�Ӧ',
    'no_topic' => '���� ������� ���Ҧ���',
    'position_top' => '���Ҧ ���Ҧ���',
    'position_feat' => '���� �������ϧ ����Ԧ',
    'position_bottom' => '����� ���Ҧ���',
    'position_entire' => '�� ��� ���Ҧ���',
    'head_centerblock' => '����������� ����',
    'centerblock_no' => '�',
    'centerblock_top' => '����',
    'centerblock_feat' => '����. ������',
    'centerblock_bottom' => '���',
    'centerblock_entire' => '��� ���Ҧ���',
    'inblock_msg' => '� ���æ: ',
    'inblock_info' => '��ͦ����� �������� ���Ҧ��� � ����.',
    'title_edit' => '���������� ���Ҧ���',
    'title_copy' => '��Ц����� ���Ҧ���',
    'title_display' => '����������� ���Ҧ���',
    'select_php_none' => '�� ���������� PHP',
    'select_php_return' => '���������� PHP (return)',
    'select_php_free' => '���������� PHP',
    'php_not_activated' => '������������ PHP � ��������� ���Ҧ���� �� ����������. ���� �����, ����צ���� � <a href="' . $_CONF['site_url'] . '/docs/staticpages.html#php">���������æ�</a> ���� �������.',
    'printable_format' => '������ ��� �����',
	'edit' => '����������',
    'copy' => '��Ц�����',
    'limit_results' => '�������� ����������',
    'search' => '�����',
    'submit' => '��Ħ�����'
);

// Messages for the plugin upgrade
$PLG_staticpages_MESSAGE3001 = 'Plugin upgrade not supported.';
$PLG_staticpages_MESSAGE3002 = $LANG32[9];

?>
