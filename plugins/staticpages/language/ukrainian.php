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
# $LANGXX[YY]:  $LANG - variable name
#               XX    - file id number
#               YY    - phrase id number
###############################################################################

$LANG_STATIC = array(
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
    'php_not_activated' => "������������ PHP � ��������� �������� �� ����������. ���� �����, ��������� � <a href=\"{$_CONF['site_url']}/docs/staticpages.html#php\">������������</a> ���� �������.",
    'printable_format' => '������ ��� �����',
    'copy' => '��������',
    'limit_results' => '�������� ����������',
    'search' => '�����',
    'submit' => '³������'
);

$PLG_staticpages_MESSAGE19 = 'Your page has been successfully saved.';
$PLG_staticpages_MESSAGE20 = 'Your page has been successfully deleted.';

// Messages for the plugin upgrade
$PLG_staticpages_MESSAGE3001 = 'Plugin upgrade not supported.';
$PLG_staticpages_MESSAGE3002 = $LANG32[9];

// Localization of the Admin Configuration UI
$LANG_configsections['staticpages'] = array(
    'label' => 'Static Pages',
    'title' => 'Static Pages Configuration'
);

$LANG_confignames['staticpages'] = array(
    'allow_php' => 'Allow PHP?',
    'sort_by' => 'Sort Centerblocks by',
    'sort_menu_by' => 'Sort Menu Entries by',
    'delete_pages' => 'Delete Pages with Owner?',
    'in_block' => 'Wrap Pages in Block?',
    'show_hits' => 'Show Hits?',
    'show_date' => 'Show Date?',
    'filter_html' => 'Filter HTML?',
    'censor' => 'Censor Content?',
    'default_permissions' => 'Page Default Permissions',
    'aftersave' => 'After Saving Page',
    'atom_max_items' => 'Max. Pages in Webservices Feed'
);

$LANG_configsubgroups['staticpages'] = array(
    'sg_main' => 'Main Settings'
);

$LANG_fs['staticpages'] = array(
    'fs_main' => 'Static Pages Main Settings',
    'fs_permissions' => 'Default Permissions'
);

// Note: entries 0, 1, 9, and 12 are the same as in $LANG_configselects['Core']
$LANG_configselects['staticpages'] = array(
    0 => array('True' => 1, 'False' => 0),
    1 => array('True' => true, 'False' => false),
    2 => array('Date' => 'date', 'Page ID' => 'id', 'Title' => 'title'),
    3 => array('Date' => 'date', 'Page ID' => 'id', 'Title' => 'title', 'Label' => 'label'),
    9 => array('Forward to page' => 'item', 'Display List' => 'list', 'Display Home' => 'home', 'Display Admin' => 'admin'),
    12 => array('No access' => 0, 'Read-Only' => 2, 'Read-Write' => 3)
);

?>