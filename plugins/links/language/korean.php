<?php

###############################################################################
# korean.php
# This is the Japanese language page for the Geeklog links Plug-in!
#
# Copyright (C) 2001 Tony Bibbs
# tony@tonybibbs.com
# Copyright (C) 2005 Trinity Bays
# trinity93@gmail.com
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
# $Id: korean.php,v 1.3 2008/04/13 11:59:08 dhaun Exp $
# Last Update 2007/01/30 by Ivy (Geeklog Japanese)

global $LANG32;

###############################################################################
# Array Format: 
# $LANGXX[YY]:	$LANG - variable name
#		  	XX - file id number
#			YY - phrase id number
###############################################################################

$LANG_LINKS = array(
    10 => '����',
    14 => '��ũ',
    84 => '��ũ',
    88 => '-',
    114 => '��ũ',
    116 => '��ũ �߰�'
);

###############################################################################
# for stats

$LANG_LINKS_STATS = array(
    'links' => '��ϵ� ��ũ(��ũ��)',
    'stats_headline' => '��ũ(���� 10��)',
    'stats_page_title' => '��ũ',
    'stats_hits' => '��Ʈ',
    'stats_no_hits' => '�� ����Ʈ���� ��ũ�� ���ų�, Ŭ���� ����� ���ų� ��� ���� ���Դϴ١�',
); 
 
###############################################################################
# for the search
 
$LANG_LINKS_SEARCH = array(
 'results' => '��ũ �˻����',
 'title' => '����',
 'date' => '�߰��� �Ͻ�',
 'author' => '�۾���',
 'hits' => '��ũ��'
);
###############################################################################
# for the submission form

$LANG_LINKS_SUBMIT = array(
    1 => '��ũ�� ���',
    2 => '��ũ',
    3 => 'ī�װ�',
    4 => '�� ��',
    5 => '���ο� ī�װ� �̸�',
    6 => '������ī�װ��� �����ϱ�� �ٶ��ϴ�',
    7 => '���� �ܡ��� ������ ��� ���ο� ī�װ� �̸��� �����ֽñ� �ٶ��ϴ١�',
    8 => '����',
    9 => 'URL',
    10 => 'ī�װ�',
    11 => '��ũ�� ��Ͻ�û'
);

###############################################################################
# Messages for COM_showMessage the submission form

$PLG_links_MESSAGE1 = "{$_CONF['site_name']} �� ��ũ�� ����� �ּż� �����մϴ١� ������ ������ Ȯ���ϰ� �ֽ��ϴ١� ������ �Ǹ� <a 
href={$_CONF['site_url']}/links/index.php> ��ũ</a> �ι��� ǥ�õ˴ϴ١�";
$PLG_links_MESSAGE2 = '��ũ�� ������ ��� �Ǿ����ϴ١�';
$PLG_links_MESSAGE3 = '��ũ�� ������ �Ϸ� �Ǿ����ϴ١�';
$PLG_links_MESSAGE4 = "{$_CONF['site_name']} �� ��ũ�� ����� �ּż� �����մϴ١�<a href={$_CONF['site_url']}/links/index.php>��ũ</a>���� Ȯ�� �Ͻñ� �ٶ��ϴ١�";

// Messages for the plugin upgrade
$PLG_links_MESSAGE3001 = 'Plugin upgrade not supported.';
$PLG_links_MESSAGE3002 = $LANG32[9];

###############################################################################
# admin/link.php

$LANG_LINKS_ADMIN = array(
    1 => '��ũ�� ����',
    2 => 'ID',
    3 => '����',
    4 => 'URL',
    5 => 'ī�װ�',
    6 => '(http://�� �־��ֽñ� �ٶ��ϴ�)',
    7 => '�� ��',
    8 => '��ũ�� ����',
    9 => '����',
    10 => '����URL�������� �ʿ��մϴ�',
    11 => '��ũ�� ����',
    12 => '��ũ�� ���������� �� ��쿡�� �� ��ũ�� ���������������� Ŭ�� �Ͻñ� �ٶ��ϴ١��ű��ۼ��� ���ǡ��űԡ��� Ŭ���Ͻñ� �ٶ��ϴ١�',
    14 => 'ī�װ�',
    16 => '���ӿ� �����߽��ϴ�',
    17 => "������ ���� ��ũ�� �����Ϸ��� �ϼ̱� ������ �α׿� ��� �Ǿ����ϴ�.<aref=\"{$_CONF['site_admin_url']}/plugins/links/index.php\"> ��ũ�� ����ȭ������ ���ư��ñ�</a>�ٶ��ϴ١�",
    20 => '�� �ܸ� ����',
    21 => '����',
    22 => '���',
    23 => '����'
);

?>
