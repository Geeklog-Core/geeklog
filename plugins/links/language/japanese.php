<?php

###############################################################################
# japanese.php
# This is the Japanese language page for the Geeklog links Plug-in!
#
# Copyright (C) 2001 Tony Bibbs
# tony@tonybibbs.com
# Copyright (C) 2005 Trinity Bays
# trinity93@gmail.com
# Tranlated by Geeklog Japanese group
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

global $LANG32;

###############################################################################
# Array Format:
# $LANGXX[YY]:  $LANG - variable name
#               XX    - file id number
#               YY    - phrase id number
###############################################################################

$LANG_LINKS = array(
    10 => '���',
    14 => '���',
    84 => '���',
    88 => '��������󥯤Ϥ���ޤ���',
    114 => '���',
    116 => '��󥯤��ɲ�',
    117 => '���줿��󥯤����',
    118 => '���줿��󥯤Υ�ݡ���',
    119 => '�ʲ��Υ�󥯤�����Ƥ��ޤ�: ',
    120 => '��󥯤��Խ�����ˤϤ����򥯥�å�: ',
    121 => '���줿��󥯤�����: ',
    122 => '���줿��󥯤���𤷤Ƥ������������꤬�Ȥ��������ޤ��������ԤϤǤ�������᤯�����ľ���Ǥ��礦��',
    123 => '���꤬�Ȥ��������ޤ�',
    124 => '��ư',
    125 => '���ƥ���',
    126 => '���߰���:',
    'root' => '�롼��'
);

###############################################################################
# for stats

$LANG_LINKS_STATS = array(
    'links' => '��Ͽ����Ƥ����󥯡ʥ���å�����',
    'stats_headline' => '���(���10��)',
    'stats_page_title' => '���',
    'stats_hits' => '�ҥå�',
    'stats_no_hits' => '���Υ����Ȥˤϥ�󥯤��ʤ���������å������ͤ����ʤ����Τɤ��餫�Τ褦�Ǥ���'
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
$PLG_links_MESSAGE5 = '���Υ��ƥ���򸫤뽽ʬ�ʥ���������������ޤ���';
$PLG_links_MESSAGE6 = '���Υ��ƥ�����Խ����뽽ʬ�ʥ���������������ޤ���';
$PLG_links_MESSAGE7 = '���ƥ����̾�������������Ϥ��Ʋ�������';
$PLG_links_MESSAGE10 = '���ƥ������¸���������ޤ�����';
$PLG_links_MESSAGE11 = '���ƥ����ID��"site"��"user"�Ȥ��뤳�Ȥϵ��Ĥ���Ƥ��ޤ��󡣤�����̾��������Ū�ʻ��ѤΤ����ͽ�󤵤�Ƥ��ޤ���';
$PLG_links_MESSAGE12 = '�ƤΥ��ƥ���򡢥��ƥ��꼫�ȤΥ��֥��ƥ���ˤ��褦�Ȥ��ޤ���������Ϥޤ����Υ��ƥ����������Ƥ��ޤ��ޤ��Τǡ��ޤ��ǽ�˻ҤΥ��ƥ�����ư���뤫������̤Υ��ƥ��꤫��ƥ��ƥ��������ǲ�������';
$PLG_links_MESSAGE13 = '���ƥ���κ�����������ޤ�����';
$PLG_links_MESSAGE14 = '���ƥ���ϥ�󥯤�ϥ��ƥ����ޤ�Ǥ��ޤ����ޤ��������������Ʋ�������';
$PLG_links_MESSAGE15 = '���Υ��ƥ������������Τ˽�ʬ�ʥ���������������ޤ���';
$PLG_links_MESSAGE16 = '���Τ褦�ʥ��ƥ����¸�ߤ��ޤ���';

// Messages for the plugin upgrade
$PLG_links_MESSAGE3001 = '�ץ饰����Υ��åץ��졼�ɤϥ��ݡ��Ȥ���Ƥ��ޤ���';
$PLG_links_MESSAGE3002 = $LANG32[9];

###############################################################################
# admin/plugins/links/index.php

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
    23 => '���',
    24 => '��󥯤����Ĥ���ޤ���',
    25 => '�Խ����褦�����򤵤줿��󥯤ϸ��Ĥ���ޤ���Ǥ�����',
    26 => '��󥯤򸡾�',
    27 => 'HTML�ξ���',
    28 => '���ƥ�����Խ�',
    29 => '�ʲ��ξܺ٤����Ϥޤ����Խ����Ʋ�������',
    30 => '���ƥ���',
    31 => '����',
    32 => '���ƥ���ID',
    33 => '����',
    34 => '��',
    35 => '���ƥ����ID��"site"��"user"�Ȥ��뤳�Ȥϵ��Ĥ���Ƥ��ޤ��󡣤�����̾��������Ū�ʻ��ѤΤ����ͽ�󤵤�Ƥ��ޤ���',
    40 => '���Υ��ƥ�����Խ�',
    41 => '�ҤΥ��ƥ�������',
    42 => '���Υ��ƥ������',
    43 => 'Site���ƥ���',
    44 => '�Ҥ��ɲ�',
    46 => '�桼�� %s ��������������������ʤ����ƥ���������褦�Ȥ��ޤ�����',
    50 => '���ƥ���Υꥹ��',
    51 => '���������',
    52 => '���������ƥ���',
    53 => '��󥯤Υꥹ��',
    54 => '���ƥ��ꡦ�ޥ͡�����',
    55 => '���Υ��ƥ�����Խ����Ʋ�������¾�Υ��ƥ�����󥯤�ޤ�Ǥ��륫�ƥ���Ϻ���Ǥ��ʤ����Ȥ���դ��Ʋ����������Τ褦�ʥ��ƥ����������ˤϡ���˴ޤޤ�Ƥ����Τ������뤫��¾�Υ��ƥ���˰�ư����ɬ�פ�����ޤ���',
    56 => '���ƥ��ꡦ���ǥ���',
    57 => '̤����',
    58 => '����������',
    59 => '<p>ɽ������Ƥ��뤹�٤ƤΥ�󥯤򸡾ڤ���ˤϡ����Ρֺ��������ڡפΥ�󥯤򥯥�å����Ƥ�����������󥯤θ��ڤˤϡ�ɽ������Ƥ����󥯤ο��ˤ�äơ��������٤λ��֤��ݤ��뤳�Ȥ���դ��Ʋ�������</p>',
    60 => '�桼�� %s �����ƥ��� %s ���������Խ����褦�Ȥ��ޤ�����'
);


$LANG_LINKS_STATUS = array(
    100 => 'Continue',
    101 => 'Switching Protocols',
    200 => 'OK',
    201 => 'Created',
    202 => 'Accepted',
    203 => 'Non-Authoritative Information',
    204 => 'No Content',
    205 => 'Reset Content',
    206 => 'Partial Content',
    300 => 'Multiple Choices',
    301 => 'Moved Permanently',
    302 => 'Found',
    303 => 'See Other',
    304 => 'Not Modified',
    305 => 'Use Proxy',
    307 => 'Temporary Redirect',
    400 => 'Bad Request',
    401 => 'Unauthorized',
    402 => 'Payment Required',
    403 => 'Forbidden',
    404 => 'Not Found',
    405 => 'Method Not Allowed',
    406 => 'Not Acceptable',
    407 => 'Proxy Authentication Required',
    408 => 'Request Timeout',
    409 => 'Conflict',
    410 => 'Gone',
    411 => 'Length Required',
    412 => 'Precondition Failed',
    413 => 'Request Entity Too Large',
    414 => 'Request-URI Too Long',
    415 => 'Unsupported Media Type',
    416 => 'Requested Range Not Satisfiable',
    417 => 'Expectation Failed',
    500 => 'Internal Server Error',
    501 => 'Not Implemented',
    502 => 'Bad Gateway',
    503 => 'Service Unavailable',
    504 => 'Gateway Timeout',
    505 => 'HTTP Version Not Supported',
    999 => 'Connection Timed out'
);

// Localization of the Admin Configuration UI
$LANG_configsections['links'] = array(
    'label' => '���',
    'title' => '��󥯤�����'
);

$LANG_confignames['links'] = array(
    'linksloginrequired' => '��󥯤˥�����ɬ��?',
    'linksubmission' => '��󥯤ο������ߥ��塼��ͭ��?',
    'newlinksinterval' => '��������󥯺����δֳ�',
    'hidenewlinks' => '��������󥯤򱣤�?',
    'hidelinksmenu' => '��󥯤Υ�˥塼���ܤ򱣤�?',
    'linkcols' => '����Υ��ƥ����',
    'linksperpage' => '�ڡ�����Υ�󥯤ο�',
    'show_top10' => '���10�Υ�󥯤�ɽ��?',
    'notification' => '�Żҥ᡼�������?',
    'delete_links' => '��ͭ�Ԥȶ��˥�󥯤���?',
    'aftersave' => '��󥯤���¸��',
    'show_category_descriptions' => '���ƥ����������ɽ��?',
    'root' => '�롼�ȤΥ��ƥ����ID',
    'default_permissions' => '��󥯤Υǥե���ȤΥѡ��ߥå����'
);

$LANG_configsubgroups['links'] = array(
    'sg_main' => '�������'
);

$LANG_fs['links'] = array(
    'fs_public' => '�������줿��󥯤Υꥹ�Ȥ�����',
    'fs_admin' => '��󥯤δ�������',
    'fs_permissions' => '�ǥե���ȤΥѡ��ߥå����'
);

// Note: entries 0, 1, and 12 are the same as in $LANG_configselects['Core']
$LANG_configselects['links'] = array(
    0 => array('�Ϥ�' => 1, '������' => 0),
    1 => array('�Ϥ�' => true, '������' => false),
    9 => array('��󥯤��줿�����Ȥ˿ʤ�' => 'item', '�����ꥹ�Ȥ�ɽ��' => 'list', '�������줿�ꥹ�Ȥ�ɽ��' => 'plugin', 'HOME�ڡ�����ɽ��' => 'home', '�������̤�ɽ��' => 'admin'),
    12 => array('���������Բ�' => 0, '�񤭹��߶ػ�' => 2, '�ɤ߽񤭲�ǽ' => 3)
);

?>