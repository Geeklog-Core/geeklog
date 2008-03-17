<?php

###############################################################################
# japanese.php
# This is the Japanese language page for the Geeklog Static Page Plug-in!
#
# Copyright (C) 2001 Tony Bibbs
# tony@tonybibbs.com
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

###############################################################################
# Array Format: 
# $LANGXX[YY]:	$LANG - variable name
#		  	XX - file id number
#			YY - phrase id number
###############################################################################


$LANG_STATIC= array(
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
    'pageformat' => '�ڡ����쥤������',
    'leftrightblocks' => '�إå����եå��������֥�å�����',
    'blankpage' => '������ɽ���ʥإå����եå����֥�å��ʤ���',
    'noblocks' => '�إå����եå�����ʥ֥�å��ʤ���',
    'leftblocks' => '�إå����եå�����¦�֥�å�����ʱ�¦�֥�å��ʤ���',
    'addtomenu' => '�إå���˥塼���ɲ�',
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
    'php_warn' => '<br>��ա����Υ��ץ�����ͭ���ˤ���ȡ����ʤ��Υڡ����˴ޤޤ��PHP�����ɤ��¹Ԥ���ޤ�����Ū�ڡ���PHP�����Ѥ�����ˤϡ����餫����������̡֥��롼��:Static Page Admin�פǡ����¡�staticpages.PHP�פ˥����å����Ƥ���������PHP��Ȥ���硤�̾�(return)�ʤ��Ρ�PHP��¹Ԥ���ץ⡼�ɤ����Ѥ��ޤ������ѤˤϺٿ�����դ�ʧ�äƤ���������',
    'exit_msg' => '�������¤��ʤ����: ',
    'exit_info' => '�����å�����ȡ��������¤��ʤ����˥������׵���̤�ɽ������ޤ���<br>�����������å��򤷤ʤ����ˤϡָ��¤��ʤ��פȤ�����å�������ɽ������ޤ���',
    'deny_msg' => '�ڡ����ؤΥ��������ϵ��ݤ���ޤ������ڡ�������ư�ޤ��Ϻ�����줿�������¤��ʤ����Τ����줫�Ǥ���',
    'stats_headline' => '��Ū�ڡ����ʾ��10���',
    'stats_page_title' => '�����ȥ�',
    'stats_hits' => '������',
    'stats_no_hits' => '��Ū�ڡ������ʤ����������Ԥ����ʤ����Τɤ��餫�Ǥ���',
    'id' => 'ID',
    'duplicate_id' => '���ꤷ��ID�Ϥ��Ǥ˻Ȥ��Ƥ��ޤ����̤�ID�򤴻��Ѥ���������',
    'instructions' => '�ڡ������Խ�������ϡ��ƥڡ�������Ƭ���Խ���������򥯥�å����ڡ����α����ϡ������ȥ�򥯥�å����������ڡ��������������ϡֿ��������ץ�󥯤򥯥�å����ڡ����Υ��ԡ���[C]�򥯥�å����Ƥ���������',
    'centerblock' => '���󥿡����ꥢɽ��: ',
    'centerblock_msg' => '�����å�����ȡ��ȥåץڡ����ޤ�������Υȥåץڡ����Υ��󥿡����ꥢ��ɽ������ޤ���ɽ����ID�ǥ����Ȥ���ޤ���',
    'topic' => '����: ',
    'position' => 'ɽ�����: ',
    'all_topics' => '���٤�',
    'no_topic' => '�ۡ���ڡ����Τ�',
    'position_top' => '�ڡ����κǾ���',
    'position_second' => '�����ξ�',
    'position_feat' => '���ܵ����β�',
    'position_bottom' => '�ڡ����β�',
    'position_entire' => '�ڡ�������',
    'position_menutab' => '�إå�',
    'position_footer' => '�եå�',
    'head_centerblock' => '�ȥå�ɽ��',
    'centerblock_no' => '������',
    'centerblock_top' => '����',
    'centerblock_second' => '�����ξ�',
    'centerblock_feat' => '���ܵ���',
    'centerblock_bottom' => '����',
    'centerblock_menutab' => '�إå�',
    'centerblock_footer' => '�եå�',
    'centerblock_entire' => '�ڡ�������',
    'inblock_msg' => '�֥�å��ǰϤ�: ',
    'inblock_info' => '�����å�����ȡ������ȥ뤬ɽ�����졤����ƥ�Ĥ��֥�å��ǰϤޤ�ޤ���',
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
$PLG_staticpages_MESSAGE3001 = 'Plugin upgrade not supported.';
$PLG_staticpages_MESSAGE3002 = $LANG32[9];

?>
