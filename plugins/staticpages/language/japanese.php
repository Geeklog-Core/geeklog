<?php

###############################################################################
# lang.php
# This is the english language page for the Geeklog Static Page Plug-in!
#
# Copyright (C) 2001 Tony Bibbs
# tony@tonybibbs.com
# Tranlated by SaY
# sakata@ecofirm.com
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
    newpage => '�����ڡ���',
    adminhome => '�����ڡ���',
    staticpages => '��Ū�ʸ���˥ڡ���',
    staticpageeditor => '��Ū�ڡ������Խ�',
    writtenby => '���ԡ�',
    date => '�ǽ���������',
    title => '�����ȥ�',
    content => '����',
    hits => '��α���',
    staticpagelist => '��Ū�ڡ�������',
    url => 'URL',
    edit => '�Խ�',
    lastupdated => '�ǽ���������',
    pageformat => '�ڡ����ե����ޥå�',
    leftrightblocks => '�����Υ֥�å��դ�',
    blankpage => '����ڡ���',
    noblocks => '�֥�å��ʤ�',
    leftblocks => '��¦�֥�å��Τ�',
    addtomenu => '��˥塼���ɲä���',
    label => '��٥�',
    nopages => '��Ū�ڡ����������ƥ�ˤ���ޤ���',
    save => '��¸',
    preview => '�ץ�ӥ塼',
    delete => '���',
    cancel => '����󥻥�',
    access_denied => '�������������ݤ���ޤ���',
    access_denied_msg => '��Ū�ڡ����δ����ڡ����˸��¤ʤ��ǥ����������褦�Ȥ��ޤ��������¤Τʤ����������Ϥ��٤Ƶ�Ͽ����ޤ��ΤǤ���դ���������',
    all_html_allowed => '���٤Ƥ�HTML�����ѤǤ��ޤ���',
    results => 'Static Pages Results',
    author => '���ԡ�',
    no_title_or_content => '���ʤ��Ȥ⡢<b>�����ȥ�</b>��<b>����</b>�ϵ������Ƥ���������',
    no_such_page_logged_in => $_USER['username'].'���󡢤����ʤ���',
    no_such_page_anon => '�ޤ������󤷤Ƥ���������',
    no_page_access_msg => "��������ϡ��ޤ������󤷤Ƥ��ʤ��������⤽�⤳�Υ����ȡ�{$_CONF["site_name"]}�ˤΥ��С��ǤϤʤ�������ȹͤ����ޤ���{$_CONF["site_name"]}��<a href=\"{$_CONF['site_url']}/users.php?mode=new\"> ���С���Ͽ</a>���뤫��Ŭ�ڤʥ���������������Ԥ���������Ƥ���������",
    php_msg => 'PHP: ',
    php_warn => '��ա����Υ��ץ�����ͭ���ˤ���ȡ����ʤ��Υڡ����˴ޤޤ��PHP�����ɤ��¹Ԥ���ޤ������ѤˤϺǿ�����դ�ʧ�äƤ���������',
    exit_msg => 'Exit Type: ',
    exit_info => '���ץ�����ס������å��򤷤ʤ����ˤ��̾�Υ������ƥ������å���Ŭ�Ѥ��졢��å�������ɽ������ޤ���',
    deny_msg => '�ڡ����ؤΥ��������ϵ��ݤ���ޤ������ڡ�������ư�ޤ��Ϻ�����줿�������¤��ʤ����Τ����줫�Ǥ���',
    stats_headline => '��Ū�ڡ����ʾ�̣�����',
    stats_page_title => '�����ȥ�',
    stats_hits => '��α���',
    stats_no_hits => '��Ū�ڡ������ʤ����������Ԥ����ʤ����Τɤ��餫�Ǥ���',
    id => 'ID�ʥڡ���̾��',
    duplicate_id => '���ꤷ��ID�Ϥ��Ǥ˻Ȥ��Ƥ��ޤ����̤�ID�򤴻��Ѥ���������',
    instructions => '�ڡ������Խ���������뤿��ˤϡ��ʲ��Υڡ����ֹ�򥯥�å����Ƥ����������ڡ��������������ϡ������ȥ�򥯥�å����Ƥ����������������ڡ��������������ˤϡ��ֿ����ץܥ���򲡤��Ƥ���������[C]�򲡤��ȡ���¸�Υڡ����Υ��ԡ�������Ǥ��ޤ���',
    centerblock => '���󥿡��֥�å�: ',
    centerblock_msg => '�����å�����ȡ��ȥåץڡ������濴��ʬ��ɽ������ޤ���',
    topic => '����: ',
    position => '��: ',
    all_topics => '���٤�',
    no_topic => '�ۡ���ڡ����Τ�',
    position_top => '�ڡ����κǾ���',
    position_feat => '���ܵ����β�',
    position_bottom => '�ڡ����β�',
    position_entire => '�ڡ�������',
    head_centerblock => '���󥿡��֥�å�',
    centerblock_no => '������',
    centerblock_top => '����',
    centerblock_feat => '���ܵ���',
    centerblock_bottom => '����',
    centerblock_entire => '�ڡ�������',
    'inblock_msg' => 'In a block: ',
    'inblock_info' => 'Wrap Static Page in a block.',
    'title_edit' => 'Edit page',
    'title_copy' => 'Make a copy of this page',
    'title_display' => 'Display page',
    'select_php_none' => 'do not execute PHP',
    'select_php_return' => 'execute PHP (return)',
    'select_php_free' => 'execute PHP',
    'php_not_activated' => 'The use of PHP in static pages is not activated. Please see the documentation for details.'
);

?>
