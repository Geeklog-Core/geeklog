<?php

###############################################################################
# japanese_utf.php
# This is the Japanese language page for the Geeklog links Plug-in!
#
# Copyright (C) 2001 Tony Bibbs
# tony@tonybibbs.com
# Copyright (C) 2005 Trinity Bays
# trinity93@gmail.com
# Tranlated by Geeklog Japanese group
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
# $Id: japanese.php,v 1.7 2006/12/11 16:58:01 dhaun Exp $
# Last Update 2006/12/12 by Ivy (Geeklog Japanese)

###############################################################################
# Array Format: 
# $LANGXX[YY]:	$LANG - variable name
#		  	XX - file id number
#			YY - phrase id number
###############################################################################

$LANG_LINKS= array(
    10 => '���',
    14 => '���',
    84 => '���',
    88 => '��������󥯤Ϥ���ޤ���',
    114 => '���',
    116 => '��󥯤��ɲ�'
);

###############################################################################
# for stats

$LANG_LINKS_STATS = array(
    'links' => '��Ͽ����Ƥ����󥯡ʥ���å�����',
    'stats_headline' => '���(���10��)',
    'stats_page_title' => '���',
    'stats_hits' => '�ҥå�',
    'stats_no_hits' => '���Υ����Ȥˤϥ�󥯤��ʤ���������å������ͤ����ʤ����Τɤ��餫�Τ褦�Ǥ���',
); 
 
###############################################################################
# for the search
 
$LANG_LINKS_SEARCH = array(
 'results' => '��󥯤θ������',
 'title' => '�����ȥ�',
 'date' => '�ɲä�������',
 'author' => '��Ƽ�',
 'hits' => '����å���'
);
###############################################################################
# for the submission form

$LANG_LINKS_SUBMIT = array(
    1 => '��󥯤���Ͽ',
    2 => '���',
    3 => '���ƥ���',
    4 => '����¾',
    5 => '���������ƥ���̾',
    6 => '���顼�����ƥ��������Ǥ�������',
    7 => '�֤���¾�פ����򤹤���ˤϿ��������ƥ���̾�������Ƥ���������',
    8 => '�����ȥ�',
    9 => 'URL',
    10 => '���ƥ���',
    11 => '��󥯤���Ͽ����'
);

###############################################################################
# Messages for COM_showMessage the submission form

$PLG_links_MESSAGE1 = "{$_CONF['site_name']}�˥����Ͽ���꤬�Ȥ��������ޤ��������åդ����Ƥ��ǧ���ޤ�����ǧ���줿��<a href={$_CONF['site_url']}/links/index.php>���</a>����������ɽ������ޤ���";
$PLG_links_MESSAGE2 = '��󥯤�̵����Ͽ����ޤ�����';
$PLG_links_MESSAGE3 = '��󥯤κ������λ���ޤ�����';
$PLG_links_MESSAGE4 = "{$_CONF['site_name']}�˥����Ͽ���꤬�Ȥ��������ޤ���<a href={$_CONF['site_url']}/links/index.php>���</a>�Ǥ���ǧ����������";

// Messages for the plugin upgrade
$PLG_links_MESSAGE3002 = $LANG32[9];

###############################################################################
# admin/link.php

$LANG_LINKS_ADMIN = array(
    1 => '��󥯤��Խ�',
    2 => 'ID',
    3 => '�����ȥ�',
    4 => 'URL',
    5 => '���ƥ���',
    6 => '(http://��ޤ�)',
    7 => '����¾',
    8 => '��󥯤λ���',
    9 => '����',
    10 => '�����ȥ롢URL��������ɬ�פǤ�',
    11 => '��󥯤δ���',
    12 => '��󥯤��������������ϳƥ�󥯤Ρ��Խ��ץ�������򥯥�å����Ƥ������������������Ͼ�Ρֿ����פ򥯥�å����Ƥ���������',
    14 => '���ƥ���',
    16 => '�������������ݤ���ޤ���',
    17 => "���¤Τʤ���󥯤˥����������褦�Ȥ��ޤ����Τǥ��˵�Ͽ���ޤ�����<a href=\"{$_CONF['site_admin_url']}/plugins/links/index.php\">��󥯤δ������̤���ä�</a>����������",
    20 => '����¾�����',
    21 => '��¸',
    22 => '����󥻥�',
    23 => '���'
);

?>