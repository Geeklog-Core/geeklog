<?php

###############################################################################
# korean_utf-8.php
# This is the english language page for the Geeklog Static Page Plug-in!
#
# Copyright (C) 2001 Tony Bibbs
# tony@tonybibbs.com
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

global $LANG32;

###############################################################################
# Array Format:
# $LANGXX[YY]:  $LANG - variable name
#               XX    - file id number
#               YY    - phrase id number
###############################################################################

$LANG_STATIC = array(
    'newpage' => '�ű�������',
    'adminhome' => '����ȭ��',
    'staticpages' => '���� ������',
    'staticpageeditor' => '���� �������� ����',
    'writtenby' => '������',
    'date' => '����������',
    'title' => '����',
    'content' => '����',
    'hits' => '��ȸ�Ǽ�',
    'staticpagelist' => '���� ������ ����',
    'url' => 'URL',
    'edit' => '����',
    'lastupdated' => '����������',
    'pageformat' => '������ ����',
    'leftrightblocks' => '�¿��α� �ֽ��ϴ�',
    'blankpage' => '��ü ȭ��ǥ��',
    'noblocks' => '��α� �����ϴ�',
    'leftblocks' => '�����α� �ֽ��ϴ�(�������α״� �����ϴ�)',
    'addtomenu' => '�����α� �޴��� �߰�',
    'label' => '�޴��̸�',
    'nopages' => '���� �������� �����ϴ�',
    'save' => '����',
    'preview' => '�̸�����',
    'delete' => '����',
    'cancel' => '���',
    'access_denied' => '�˼��մϴٸ�, ���� �α��� �Ͻñ� �ٶ��ϴ�',
    'access_denied_msg' => 'üũ�� �ϸ� ���ӱ����� ���� ���, ȭ���� �α��� ȭ������ �ڵ������� ǥ�õ˴ϴ�.  üũ�� ���� �ʴ� ��쿡�� ������������ �����ϴ١���� �޼����� ǥ�� �˴ϴ�',
    'all_html_allowed' => '��� HTML �� �̿� �� �� �ֽ��ϴ�',
    'results' => '���� ������ �˻����',
    'author' => '������',
    'no_title_or_content' => ' <b> ����</b> ��  <b> ����</b> �� �����ֽñ� �ٶ��ϴ�.',
    'no_such_page_anon' => '�α��� �Ͻñ� �ٶ��ϴ�.',
    'no_page_access_msg' => "�� ������ ���� �α��� ���� �ʾҰų� �Ƹ��� �� ����Ʈ {$_CONF['site_name']} �� ȸ���� �ƴϱ� ������ ������ �������ϴ�.  {$_CONF['site_name']} �� <a href=\"{$_CONF['site_url']}/users.php?mode=new\"> ȸ�����</a>�� �Ͻðų�, ������ ���ӱ��� �����ڷ� ���� ����Ͻñ� �ٶ��ϴ�",
    'php_msg' => 'PHP: ',
    'php_warn' => '<br' . XHTML . '>����: �� �ɼ��� ��ȿ�ϱ� �Ǹ� ����� �������� ����ִ� PHP �ڵ尡 ����˴ϴ�.  ���� �������� �̿��ϴ� ��쿡�� �ٽ��ѹ� ����ȭ�� ���׷�:Static Page Admin������ ���ѡ�Staticpages. PHP�� �� üũ�Ͻñ� �ٶ��ϴ�.  PHP�� ����ϴ� ��� ���(return) ���� �״�� ��PHP �����ϱ⡹ ��忡�� �̿��� �� �ֽ��ϴ�.  �̿뿡�� ������ ���Ǹ� ����̽ñ� �ٶ��ϴ� !!',
    'exit_msg' => '��ȸ������ ���� ���: ',
    'exit_info' => 'üũ�� �ϸ� ��ȸ������ ���� ���, �α��� �䱸ȭ���� ǥ�õ˴ϴ�. üũ�� ���� �ʴ� ��쿡�� �������� �����ϴ١� ��� �޼����� ǥ�õ˴ϴ�.',
    'deny_msg' => '������ ���ӿ� ���� �Ͽ����ϴ�.  �������� �̵� Ȥ�� �����ǰų�, �ƴϸ� ������ ���ų� ��� �� ���� ���Դϴ�.',
    'stats_headline' => '���� ������ �� 10',
    'stats_page_title' => '����',
    'stats_hits' => '��ȸ�Ǽ�',
    'stats_no_hits' => '���� �������� ���ų�, ��ȸ�ڰ� ���ų� ��� ���� ���Դϴ�.',
    'id' => 'ID',
    'duplicate_id' => '������ ID �� �̹� ��� �ǰ� �ֽ��ϴ�. �ٸ� ID�� ����Ͻñ� �ٶ��ϴ�.',
    'instructions' => '�������� ����, ������ �� ������ �Ӹ��κ��� ������������ Ŭ��.  ������ ��ȸ�� ������ Ŭ��, ���ο� �������� �ۼ� �� ��쿡�� ���ű��ۼ�����ũ�� Ŭ��. ������ ����� ��C���� Ŭ�� �Ͻñ� �ٶ��ϴ�.',
    'centerblock' => '�߽ɿ��� ǥ��: ',
    'centerblock_msg' => 'üũ�� �ϸ� ó�������� Ȥ�� ȭ���� �Ӹ� ������ �߽ɿ����� ǥ�õ˴ϴ�. ǥ�ô� ID�� �з� �˴ϴ�.',
    'topic' => '����: ',
    'position' => 'ǥ�����: ',
    'all_topics' => '����',
    'no_topic' => 'Ȩ��������',
    'position_top' => '������ �Ӹ��κ�',
    'position_feat' => '�ָ��� �Ʒ��κ�',
    'position_bottom' => '������ �Ʒ�',
    'position_entire' => '������ ��ü',
    'head_centerblock' => '�Ӹ� ǥ��',
    'centerblock_no' => '�ƴϿ�',
    'centerblock_top' => '�Ӹ�',
    'centerblock_feat' => '�ָ���',
    'centerblock_bottom' => '�Ʒ��κ�',
    'centerblock_entire' => '������ ��ü',
    'inblock_msg' => '��α׷� �ѷ�����: ',
    'inblock_info' => 'üũ�� �ϸ� ������ ǥ�õǸ�, ������ ���ھȿ� ������ϴ�.',
    'title_edit' => '����',
    'title_copy' => '���縦 �ۼ�',
    'title_display' => '������ ǥ��',
    'select_php_none' => 'PHP�� �������� �ʽ��ϴ�',
    'select_php_return' => 'PHP�� �����մϴ� (return)',
    'select_php_free' => ' PHP�� �����մϴ�',
    'php_not_activated' => "���� ����������  PHP�� ������� �ʴ� �������� �Ǿ� �ֽ��ϴ�.  �ڼ��� ����  <a href=\"{$_CONF['site_url']}/docs/english/staticpages.html#php\"> ���� ��ť��Ʈ </a> �� ���ñ� �ٶ��ϴ�.",
    'printable_format' => '�μ�� ����',
    'copy' => '����',
    'limit_results' => '�������� �˻�',
    'search' => '�˻�',
    'submit' => '���'
);

$PLG_staticpages_MESSAGE15 = 'Your comment has been submitted for review and will be published when approved by a moderator.';
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