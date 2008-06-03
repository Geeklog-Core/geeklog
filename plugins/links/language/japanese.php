<?php

###############################################################################
# japanese.php
#
# This is the Japanese language file for the Geeklog Links Plugin
#
# Copyright (C) 2001 Tony Bibbs
# tony AT tonybibbs DOT com
# Copyright (C) 2005 Trinity Bays
# trinity93 AT gmail DOT com
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
# $Id: japanese.php,v 1.16 2008/06/03 19:28:46 dhaun Exp $
# Last Update 2008/06/02 by Geeklog.jp group  - info AT geeklog DOT jp

/**
 * This is the english language page for the Geeklog links Plug-in!
 *
 * @package Links
 * @subpackage Language
 * @filesource
 * @version 2.0
 * @since GL 1.4.0
 * @copyright Copyright &copy; 2005-2007
 * @license http://opensource.org/licenses/gpl-license.php GNU Public License
 * @author Trinity Bays <trinity93 AT gmail DOT com>
 * @author Tony Bibbs <tony AT tonybibbs DOT com>
 * @author Tom Willett <twillett AT users DOT sourceforge DOT net>
 *
 */

global $LANG32;

###############################################################################
# Array Format:
# $LANGXX[YY]:    $LANG - variable name
#                 XX - file id number
#                 YY - phrase id number
###############################################################################

/**
* the link plugin's lang array
*
* @global array $LANG_LINKS
*/
$LANG_LINKS = array(
    10 => '���',
    14 => '���',
    84 => '���',
    88 => '��������󥯤Ϥ���ޤ���',
    114 => '���',
    116 => '������',
    117 => '����ڤ����𤯤�������',
    118 => '����ڤ�����',
    119 => '���Υ�󥯤��ڤ�Ƥ������𤵤�ޤ����� ',
    120 => '��󥯤��Խ��ϡ������򥯥�å��� ',
    121 => '����ڤ�����ԡ� ',
    122 => '����ڤ����𤤤��������꤬�Ȥ��������ޤ����Ǥ������®�䤫�˽����������ޤ���',
    123 => '���꤬�Ȥ��������ޤ���',
    124 => 'ɽ��',
    125 => '���ƥ���',
    126 => '���ߤΰ��֡�',
    'root' => '�ȥå�' // title used for top level category
);

###############################################################################
# for stats
/**
* the link plugin's lang stats array
*
* @global array $LANG_LINKS_STATS
*/
$LANG_LINKS_STATS = array(
    'links' => '��󥯿��ʥ���å�����',
    'stats_headline' => '���(���10��)',
    'stats_page_title' => '���',
    'stats_hits' => '�ҥå�',
    'stats_no_hits' => '���Υ����Ȥˤϥ�󥯤��ʤ���������å������ͤ����ʤ����Τɤ��餫�Τ褦�Ǥ���',
);

###############################################################################
# for the search
/**
* the link plugin's lang search array
*
* @global array $LANG_LINKS_SEARCH
*/
$LANG_LINKS_SEARCH = array(
 'results' => '��󥯤θ������',
 'title' => '�����ȥ�',
 'date' => '��Ƥ�������',
 'author' => '��Ƽ�',
 'hits' => '����å���'
);

###############################################################################
# for the submission form
/**
* the link plugin's lang submit form array
*
* @global array $LANG_LINKS_SUBMIT
*/
$LANG_LINKS_SUBMIT = array(
    1 => '��󥯤���Ƥ���',
    2 => '���',
    3 => '���ƥ���',
    4 => '����¾',
    5 => '���������ƥ���̾',
    6 => '���顼�����ƥ��������Ǥ�������',
    7 => '�֤���¾�פ����򤹤���ˤϿ��������ƥ���̾�������Ƥ���������',
    8 => '�����ȥ�',
    9 => 'URL',
    10 => '���ƥ���',
    11 => '��󥯤���ƿ���'
);

###############################################################################
# Messages for COM_showMessage the submission form

$PLG_links_MESSAGE1 = "{$_CONF['site_name']}�˥�󥯤���Ͽ���Ƥ������������꤬�Ȥ��������ޤ������Υ�󥯤Ͼ�ǧ�Τ���˥����åդ������ޤ�������ǧ����ޤ��ȡ����ʤ��Υ�󥯤�<a href={$_CONF['site_url']}/links/index.php>��󥯥��������</a>��ɽ������ޤ���";
$PLG_links_MESSAGE2 = '��󥯤���¸����ޤ�����';
$PLG_links_MESSAGE3 = '��󥯤Ϻ������ޤ�����';
$PLG_links_MESSAGE4 = "{$_CONF['site_name']}�˥�󥯤���Ͽ���Ƥ������������꤬�Ȥ��������ޤ���<a href={$_CONF['site_url']}/links/index.php>���</a>���������Ǥ������������ޤ���";
$PLG_links_MESSAGE5 = "���ʤ��ˤϡ����Υ��ƥ���򸫤뤿��ν�ʬ�ʥ���������������ޤ���";
$PLG_links_MESSAGE6 = '���ʤ��ˤϡ����Υ��ƥ�����Խ����뽽ʬ�ʸ���������ޤ���';
$PLG_links_MESSAGE7 = '���ƥ����̾�������������Ϥ��Ƥ���������';

$PLG_links_MESSAGE10 = '���ƥ������¸����ޤ�����';
$PLG_links_MESSAGE11 = '���ƥ��� ID���site�פޤ��ϡ�user�פ����ꤹ�뤳�ȤϤǤ��ޤ��󡣤����������ǻ��Ѥ��뤿���ͽ�󤵤�Ƥ��ޤ���';
$PLG_links_MESSAGE12 = '���ʤ��ϡ��Խ���Υ��ƥ��꼫�ȤΥ��֥��ƥ���򡢿ƥ��ƥ�������ꤷ�褦�Ȥ��Ƥ��ޤ�������ϸ�Ω���륫�ƥ����������뤳�Ȥˤʤ�ޤ��Τǡ���˻ҥ��ƥ���ޤ��ϥ��ƥ���򡢤��⤤��٥�ذ�ư�����Ƥ���������';
$PLG_links_MESSAGE13 = '���ƥ���Ϻ������ޤ�����';
$PLG_links_MESSAGE14 = '���ƥ���ϥ�󥯤䥫�ƥ����ޤ�Ǥ��ޤ�����ˤ�����������Ƥ���������';
$PLG_links_MESSAGE15 = '���ʤ��ˤϡ����Υ��ƥ���������뽽ʬ�ʸ���������ޤ���';
$PLG_links_MESSAGE16 = '���Τ褦�ʥ��ƥ����¸�ߤ��ޤ���';

// Messages for the plugin upgrade
$PLG_links_MESSAGE3001 = '�ץ饰����Υ��åץ��졼�ɤϥ��ݡ��Ȥ���Ƥ��ޤ���';
$PLG_links_MESSAGE3002 = $LANG32[9];

###############################################################################
# admin/link.php
/**
* the link plugin's lang admin array
*
* @global array $LANG_LINKS_ADMIN
*/
$LANG_LINKS_ADMIN = array(
    1 => '��󥯤��Խ�',
    2 => '���ID',
    3 => '�����ȥ�',
    4 => 'URL',
    5 => '���ƥ���',
    6 => '(http://��ޤ�)',
    7 => '����¾',
    8 => '�ҥåȿ�',
    9 => '����',
    10 => '�����ȥ롤URL�����������Ϥ�ɬ�פǤ�',
    11 => '��󥯴���',
    12 => '��󥯤��������������ϳƥ�󥯤Ρ��Խ��ץ�������򥯥�å����Ƥ�����������󥯤ޤ��ϥ��ƥ�������������ϡ���Ρ֥�󥯤κ����פޤ��ϡ֥��ƥ���κ����פ򥯥�å����Ƥ����������ޥ�����ƥ�����Խ�������ϡ���Ρ֥��ƥ�����Խ��פ򥯥�å����Ƥ���������',
    14 => '���ƥ���',
    16 => '�������������ݤ���ޤ���',
    17 => "���¤Τʤ���󥯤˥����������褦�Ȥ��ޤ����Τǥ��˵�Ͽ���ޤ�����<a href=\"{$_CONF['site_admin_url']}/plugins/links/index.php\">��󥯤δ������̤���ä�</a>����������",
    20 => '����¾�����',
    21 => '��¸',
    22 => '����󥻥�',
    23 => '���',
    24 => '����褬���Ĥ���ޤ���',
    25 => '�Խ��оݤΥ�󥯤����Ĥ���ޤ���Ǥ���.',
    26 => '��󥯤γ�ǧ',
    27 => 'HTML���ơ�����',
    28 => '���ƥ�����Խ�',
    29 => '�ʲ��ι��ܤ����Ϥޤ����Խ����Ƥ���������',
    30 => '���ƥ���',
    31 => '����',
    32 => '���ƥ���ID',
    33 => '����',
    34 => '�ƥ��ƥ���',
    35 => '���٤�',
    40 => '���Υ��ƥ�����Խ�����',
    41 => '�ҥ��ƥ�����������',
    42 => '���Υ��ƥ����������',
    43 => '�����ȥ��ƥ���',
    44 => '�ҥ��ƥ�����ɲ�',
    46 => '�桼�� %s �ϡ������������¤��ʤ����ƥ���������褦�Ȥ��ޤ�����',
    50 => '���ƥ���Υꥹ��',
    51 => '��󥯤κ���',
    52 => '���ƥ���κ���',
    53 => '��󥯤Υꥹ��',
    54 => '���ƥ���δ���',
    55 => '�ʲ��Υ��ƥ�����Խ����Ƥ��������� ��󥯤䥫�ƥ����ޤ५�ƥ���Ϻ���Ǥ��ޤ�����ˤ����������뤫���ۤ��Υ��ƥ���˰ܤ�ɬ�פ�����ޤ���',
    56 => '���ƥ�����Խ�',
    57 => '�ޤ���ǧ����Ƥ��ޤ���',
    58 => '��󥯤γ�ǧ',
    59 => '<p>ɽ������Ƥ������ƤΥ�󥯤��ǧ������ϡ����Ρ֥�󥯤γ�ǧ�פ򥯥�å����Ƥ������������ν����ϥ�󥯤ο��˱����Ƥ��ʤ�λ��֤������뤫�⤷��ޤ���</p>',
    60 => '�桼�� %s �ϸ��¤ʤ��˥��ƥ��� %s ���Խ����褦�Ȥ��ޤ�����'
);

$LANG_LINKS_STATUS = array(
    100 => "Continue",
    101 => "Switching Protocols",
    200 => "OK",
    201 => "Created",
    202 => "Accepted",
    203 => "Non-Authoritative Information",
    204 => "No Content",
    205 => "Reset Content",
    206 => "Partial Content",
    300 => "Multiple Choices",
    301 => "Moved Permanently",
    302 => "Found",
    303 => "See Other",
    304 => "Not Modified",
    305 => "Use Proxy",
    307 => "Temporary Redirect",
    400 => "Bad Request",
    401 => "Unauthorized",
    402 => "Payment Required",
    403 => "Forbidden",
    404 => "Not Found",
    405 => "Method Not Allowed",
    406 => "Not Acceptable",
    407 => "Proxy Authentication Required",
    408 => "Request Timeout",
    409 => "Conflict",
    410 => "Gone",
    411 => "Length Required",
    412 => "Precondition Failed",
    413 => "Request Entity Too Large",
    414 => "Request-URI Too Long",
    415 => "Unsupported Media Type",
    416 => "Requested Range Not Satisfiable",
    417 => "Expectation Failed",
    500 => "Internal Server Error",
    501 => "Not Implemented",
    502 => "Bad Gateway",
    503 => "Service Unavailable",
    504 => "Gateway Timeout",
    505 => "HTTP Version Not Supported",
    999 => "Connection Timed out"
);


// Localization of the Admin Configuration UI
$LANG_configsections['links'] = array(
    'label' => '���',
    'title' => '��󥯤�����'
);

$LANG_confignames['links'] = array(
    'linksloginrequired' => '��������׵᤹��',
    'linksubmission' => '��󥯤���Ƥ�����Ԥ���ǧ����',
    'newlinksinterval' => '��󥯺����δֳ�',
    'hidenewlinks' => '�����ƥܥ���򱣤�',
    'hidelinksmenu' => '��˥塼��ɽ�����ʤ�',
    'linkcols' => '���ƥ����ɽ��������',
    'linksperpage' => '�ڡ���������Υ�󥯿�',
    'show_top10' => '��󥯤Υȥå�10��ɽ������',
    'notification' => '�᡼������Τ���',
    'delete_links' => '��ͭ�Ԥκ���ȶ��˺������',
    'aftersave' => '�����¸��β�������',
    'show_category_descriptions' => '���ƥ����������ɽ������',
    'root' => '�ȥåץ��ƥ����ID',
    'default_permissions' => '�ѡ��ߥå����'
);

$LANG_configsubgroups['links'] = array(
    'sg_main' => '�ᥤ��'
);

$LANG_fs['links'] = array(
    'fs_public' => '��󥯤�ɽ��',
    'fs_admin' => '��󥯤δ���',
    'fs_permissions' => '��󥯤Υǥե���ȥѡ��ߥå�����[0]��ͭ�� [1]���롼�� [2]���С� [3]�����ȡ�'
);

// Note: entries 0, 1, and 12 are the same as in $LANG_configselects['Core']
$LANG_configselects['links'] = array(
    0 => array('�Ϥ�' => 1, '������' => 0),
    1 => array('�Ϥ�' => TRUE, '������' => FALSE),
    9 => array('����襵���Ȥ�ɽ������' => 'item', '��󥯴�����ɽ������' => 'list', '������󥯥ꥹ�Ȥ�ɽ������' => 'plugin', 'Home��ɽ������' => 'home', '��������TOP��ɽ������' => 'admin'),
    12 => array('���������Բ�' => 0, 'ɽ��' => 2, 'ɽ�����Խ�' => 3)
);

?>