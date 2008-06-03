<?php

###############################################################################
# japanese.php
# This is the Japanese language file for the Geeklog Static Page plugin!
#
# Copyright (C) 2001 Tony Bibbs
# tony@tonybibbs.com
# Tranlated by Geeklog Japanese group SaY and Ivy
# Copyright (C) 2008 Takahiro Kambe
# Additional translation to Japanese by taca AT back-street DOT net
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
# Last Update 2008/06/02 by Geeklog.jp group  - info AT geeklog DOT jp

global $LANG32;

###############################################################################
# Array Format:
# $LANGXX[YY]:	$LANG - variable name
#		  	XX - file id number
#			YY - phrase id number
###############################################################################

$LANG_STATIC = array(
    'newpage' => '�����ڡ���',
    'adminhome' => '��������',
    'staticpages' => '��Ū�ڡ���',
    'staticpageeditor' => '��Ū�ڡ������Խ�',
    'writtenby' => '��ͭ��',
    'date' => '�ǽ�������',
    'title' => '�����ȥ�',
    'content' => '����',
    'hits' => '�������',
    'staticpagelist' => '��Ū�ڡ�������',
    'url' => 'URL',
    'edit' => '�Խ�',
    'lastupdated' => '�ǽ���������',
    'pageformat' => '�쥤������',
    'leftrightblocks' => '�إå����եå��������֥�å�����',
    'blankpage' => '������ɽ���ʥإå����եå����֥�å��ʤ���',
    'noblocks' => '�إå����եå�����ʥ֥�å��ʤ���',
    'leftblocks' => '�إå����եå������֥�å�����ʱ��֥�å��ʤ���',
    'addtomenu' => '�إå���˥塼',
    'label' => '��˥塼̾',
    'nopages' => '��Ū�ڡ���������ޤ���',
    'save' => '��¸',
    'preview' => '�ץ�ӥ塼',
    'delete' => '���',
    'cancel' => '����󥻥�',
    'access_denied' => '����������ޤ��󤬡���˥����󤷤Ƥ���������',
    'access_denied_msg' => '�����å�����ȥ����������¤��ʤ����˲��̤���ưŪ�����ܤ��ƥ�������̤�ɽ������ޤ��������å��򤷤ʤ����ˤϡָ��¤��ʤ��פȤ�����å�������ɽ������ޤ���',
    'all_html_allowed' => '���٤Ƥ�HTML�����ѤǤ��ޤ���',
    'results' => '��Ū�ڡ����������',
    'author' => '��ͭ��',
    'no_title_or_content' => '<b>�����ȥ�</b>��<b>����</b>�������Ƥ���������',
    'no_such_page_anon' => '�����󤷤Ƥ���������',
    'no_page_access_msg' => "��������ϡ��ޤ������󤷤Ƥ��ʤ��������⤽�⤳�Υ����ȡ�{$_CONF["site_name"]}�ˤΥ��С��ǤϤʤ�������ȹͤ����ޤ���{$_CONF["site_name"]}��<a href=\"{$_CONF['site_url']}/users.php?mode=new\"> ���С���Ͽ</a>���뤫��Ŭ�ڤʥ���������������Ԥ���������Ƥ���������",
    'php_msg' => 'PHP: ',
    'php_warn' => '<br' . XHTML . '>��ա����Υ��ץ�����ͭ���ˤ���ȡ����ʤ��Υڡ����˴ޤޤ��PHP�����ɤ��¹Ԥ���ޤ�����Ū�ڡ���PHP�����Ѥ�����ˤϡ����餫����������̡֥��롼��:Static Page Admin�פǡ����¡�staticpages.PHP�פ˥����å����Ƥ���������PHP��Ȥ���硤�̾�(return)�ʤ��Ρ�PHP��¹Ԥ���ץ⡼�ɤ����Ѥ��ޤ������ѤˤϺٿ�����դ�ʧ�äƤ���������',
    'exit_msg' => '�������׵�: ',
    'exit_info' => '�����å�����ȡ��������¤��ʤ����˥������׵���̤�ɽ������ޤ���<br' . XHTML . '>�����������å��򤷤ʤ����ˤϡָ��¤��ʤ��פȤ�����å�������ɽ������ޤ���',
    'deny_msg' => '�ڡ����ؤΥ��������ϵ��ݤ���ޤ������ڡ�������ư�ޤ��Ϻ�����줿�������¤��ʤ����Τ����줫�Ǥ���',
    'stats_headline' => '��Ū�ڡ����ʾ��10���',
    'stats_page_title' => '�����ȥ�',
    'stats_hits' => '������',
    'stats_no_hits' => '��Ū�ڡ������ʤ����������Ԥ����ʤ����Τɤ��餫�Ǥ���',
    'id' => 'ID',
    'duplicate_id' => '���ꤷ��ID�Ϥ��Ǥ˻Ȥ��Ƥ��ޤ����̤�ID�򤴻��Ѥ���������',
    'instructions' => '��Ū�ڡ������Խ������������ϳƥڡ�������Ƭ���Խ���������򥯥�å����Ƥ�����������Ū�ڡ��������������ϡ������������ڡ����Υ����ȥ�򥯥�å����Ƥ�����������������Ū�ڡ��������������ϡֿ��������פ򥯥�å����Ƥ�����������Ū�ڡ����Υ��ԡ���[C]�򥯥�å����Ƥ���������',
    'centerblock' => '���󥿡����ꥢ: ',
    'centerblock_msg' => '�����å�����ȡ��ȥåץڡ����ޤ�������Υȥåץڡ����Υ��󥿡����ꥢ��ɽ������ޤ���ɽ����ID�ǥ����Ȥ���ޤ���',
    'topic' => '����: ',
    'position' => 'ɽ�����ꥢ: ',
    'all_topics' => '���٤�',
    'no_topic' => '�ۡ���ڡ����Τ�',
    'position_top' => '�ڡ����κǾ���',
    'position_feat' => '���ܵ����β�',
    'position_bottom' => '�ڡ����β�',
    'position_entire' => '�ڡ�������',
    'head_centerblock' => '�ȥå�ɽ��',
    'centerblock_no' => '������',
    'centerblock_top' => '����',
    'centerblock_feat' => '���ܵ���',
    'centerblock_bottom' => '����',
    'centerblock_entire' => '�ڡ�������',
    'inblock_msg' => '�֥�å��ǰϤ�: ',
    'inblock_info' => '�����ȥ뤬ɽ�����졤����ƥ�Ĥ��֥�å��ǰϤޤ�ޤ���',
    'title_edit' => '�Խ�',
    'title_copy' => '���ԡ������',
    'title_display' => '�ڡ�����ɽ������',
    'select_php_none' => 'PHP��¹Ԥ��ʤ�',
    'select_php_return' => 'PHP��¹Ԥ��� (return)',
    'select_php_free' => 'PHP��¹Ԥ���',
    'php_not_activated' => '��Ū�ڡ�����PHP�ϻ��Ѥ��ʤ�����ˤʤäƤ��ޤ����ܺ٤ˤĤ��Ƥ� <a href="' . $_CONF['site_url'] . '/docs/staticpages.html#php">��Ϣ�ɥ������</a> ������������',
    'printable_format' => '�����ѥե����ޥå�',
    'edit' => '�Խ�',
    'copy' => '���ԡ�',
    'limit_results' => '�ʹ�����',
    'search' => '����',
    'submit' => '��Ͽ'
);


// Messages for the plugin upgrade
$PLG_staticpages_MESSAGE3001 = '�ץ饰����Υ��åץ��졼�ɤϥ��ݡ��Ȥ���Ƥ��ޤ���';
$PLG_staticpages_MESSAGE3002 = $LANG32[9];


// Localization of the Admin Configuration UI
$LANG_configsections['staticpages'] = array(
    'label' => '��Ū�ڡ���',
    'title' => '��Ū�ڡ���������'
);

$LANG_confignames['staticpages'] = array(
    'allow_php' => 'PHP����Ĥ���',
    'sort_by' => '���󥿡��֥�å��ǤΥ����ȹ���',
    'sort_menu_by' => '��˥塼�ǤΥ����ȹ���',
    'delete_pages' => '��ͭ�Ԥκ���ȶ��˺������',
    'in_block' => '�ڡ�����֥�å��ǰϤ�',
    'show_hits' => '�ҥåȿ���ɽ������',
    'show_date' => '���դ�ɽ������',
    'filter_html' => 'HTML��ե��륿������',
    'censor' => '���Ƥ򸡱ܤ���',
    'default_permissions' => '�ѡ��ߥå����',
    'aftersave' => '�ڡ�����¸��β�������',
    'atom_max_items' => '�ե����ɤ˻��Ѥ���ڡ����κ����'
);

$LANG_configsubgroups['staticpages'] = array(
    'sg_main' => '�ᥤ��'
);

$LANG_fs['staticpages'] = array(
    'fs_main' => '��Ū�ڡ����Υᥤ������',
    'fs_permissions' => '��Ū�ڡ����Υǥե���ȥѡ��ߥå�����[0]��ͭ�� [1]���롼�� [2]���С� [3]�����ȡ�'
);

// Note: entries 0, 1, 9, and 12 are the same as in $LANG_configselects['Core']
$LANG_configselects['staticpages'] = array(
    0 => array('�Ϥ�' => 1, '������' => 0),
    1 => array('�Ϥ�' => TRUE, '������' => FALSE),
    2 => array('����' => 'date', '�ڡ���ID' => 'id', '�����ȥ�' => 'title'),
    3 => array('����' => 'date', '�ڡ���ID' => 'id', '�����ȥ�' => 'title', '��٥�' => 'label'),
    9 => array('����������Ū�ڡ�����ɽ������' => 'item', '��Ū�ڡ���������ɽ������' => 'list', 'Home��ɽ������' => 'home', '��������TOP��ɽ������' => 'admin'),
    12 => array('���������Բ�' => 0, 'ɽ��' => 2, 'ɽ�����Խ�' => 3)
);

?>