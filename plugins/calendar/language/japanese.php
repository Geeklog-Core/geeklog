<?php

###############################################################################
# japanese.php
# This is the Japanese EUC language page for the Geeklog Calendar Plug-in!
#
# Copyright (C) 2001 Tony Bibbs
# tony@tonybibbs.com
# Copyright (C) 2005 Trinity Bays
# trinity93@gmail.com
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

global $LANG32;

###############################################################################
# Array Format:
# $LANGXX[YY]:  $LANG - variable name
#               XX    - file id number
#               YY    - phrase id number
###############################################################################

# index.php
$LANG_CAL_1 = array(
    1 => '���٥�ȥ�����',
    2 => '-',
    3 => '����',
    4 => '���',
    5 => '�ܺ�',
    6 => '���٥�Ȥ��ɲ�',
    7 => '���줫��Υ��٥��',
    8 => '�Ŀͥ������ˤ��Υ��٥�Ȥ��ɲä���ȡ��ָĿͥ������פ�桼��������˥塼�������򤹤뤳�ȤǸ��뤳�Ȥ��Ǥ��ޤ���',
    9 => '�Ŀͥ��������ɲ�',
    10 => '�Ŀͥ�����������',
    11 => '���Υ��٥�Ȥ� %s�θĿͥ��������ɲ�',
    12 => '���٥��',
    13 => '����',
    14 => '��λ',
    15 => '�����������',
    16 => '������',
    17 => '����',
    18 => '��λ',
    19 => '���٥�Ȥ���Ͽ����',
    20 => '�����ȥ�',
    21 => '����',
    22 => 'URL',
    23 => '�ĿͤΥ��٥��',
    24 => '�����ȤΥ��٥��',
    25 => '-',
    26 => '���٥�Ȥ����',
    27 => "{$_CONF['site_name']}�˥��٥�Ȥ���Ƥ���ȡ����������ΤΥ���������Ͽ����ޤ���<br" . XHTML . ">���Υ������Υ��٥�Ȥϡ��ƥ桼����ɬ�פ˱����ƸĿͥ���������Ͽ�Ǥ��ޤ���",
    28 => '�����ȥ�',
    29 => '����',
    30 => '����',
    31 => '����',
    32 => '����1',
    33 => '����2',
    34 => '��Į¼̾',
    35 => '��ƻ�ܸ�',
    36 => '͹���ֹ�',
    37 => '����',
    38 => '���٥�Ȥμ�����Խ�',
    39 => '���',
    40 => '���٥�Ȥ��ɲá�',
    41 => '���Υ�����',
    42 => '�Ŀͥ�����',
    43 => '���',
    44 => 'HTML�����ϻ��ѤǤ��ޤ���',
    45 => '���',
    46 => '�����ƥ�Υ��٥��',
    47 => '���٥�Ⱦ��10��',
    48 => '������',
    49 => '���Υ����Ȥˤϥ��٥�Ȥ��ʤ�����ï�⥤�٥�Ȥ򥯥�å����Ƥ��ʤ����ɤ��餫�Τ褦�Ǥ���',
    50 => '���٥��',
    51 => '���'
);

$_LANG_CAL_SEARCH = array(
    'results' => '���٥�Ⱦ���θ������',
    'title' => '�����ȥ�',
    'date_time' => '����',
    'location' => '���',
    'description' => '�ܺ�'
);

###############################################################################
# calendar.php ($LANG30)

$LANG_CAL_2 = array(
    8 => '�ĿͤΥ��٥�Ȥ��ɲ�',
    9 => '%s ���٥��',
    10 => '���٥�ȡ�',
    11 => '���Υ�����',
    12 => '�Ŀͥ�����',
    25 => '��롧',
    26 => '����',
    27 => '��',
    28 => '�Ŀͥ�������',
    29 => '���Υ�����',
    30 => '���٥�Ȥ���',
    31 => '�ɲ�',
    32 => '���٥��',
    33 => '����',
    34 => '����',
    35 => '��ñ�ɲ�',
    36 => '���',
    37 => '���Υ����ȤǤϡ��Ŀͥ�������ͭ���ˤ��Ƥ��ޤ���',
    38 => '�Ŀͥ��٥�ȥ��ǥ���',
    39 => '��',
    40 => '��',
    41 => '��',
    42 => '���Υ��٥�Ȥ��ɲ�',
    43 => '���٥�����'
);

###############################################################################
# admin/plugins/calendar/index.php, formerly admin/event.php ($LANG22)

$LANG_CAL_ADMIN = array(
    1 => '���٥�ȥ��ǥ���',
    2 => '���顼',
    3 => '��ƥ⡼��',
    4 => 'URL',
    5 => '����',
    6 => '��λ',
    7 => '���',
    8 => '�ܺ�',
    9 => '(http://����Ϥ�Ƥ�������)',
    10 => '���٥�Ȥ����ա����֡������ȥ롤�ܺ٤����Ϥ��Ƥ���������',
    11 => '����������',
    12 => '���٥�Ȥ��Խ�������ϡ����Υ��٥�Ȥ��Խ���������򥯥�å����Ƥ������������������٥�Ȥ����硤��Ρֿ������٥�ȡפ򥯥�å����Ƥ������������ԡ�������ϴ�¸���٥�ȤΥ��ԡ���������򥯥�å����Ƥ���������',
    13 => '��Ƽ�',
    14 => '����',
    15 => '����',
    16 => '',
    17 => "�������¤Τʤ����٥�Ȥ��Խ����褦�Ȥ��ޤ��������ι԰٤ϵ�Ͽ����ޤ�����<a href=\"{$_CONF['site_admin_url']}/plugins/calendar/index.php\">���٥���Խ�����</a>����äƤ���������",
    18 => '',
    19 => '',
    20 => '��¸',
    21 => '����󥻥�',
    22 => '���',
    23 => '�������������������Ϥ��Ƥ���������',
    24 => '��λ���������������Ϥ��Ƥ���������',
    25 => '��λ���������������Ϥ��Ƥ���������',
    26 => '�Ť�����ȥ����',
    27 => '������',
    28 => ' ����ʾ��Ť����٥�ȤǤ����������ˤϰ��ֲ��Υ���Ȣ�Υ�������򥯥�å����Ʋ��������ޤ��ϡ��ۤʤ����:<br' . XHTML . '>',
    29 => ' ����ʾ�Ť����٤ƤΥ���ȥ��õ����',
    30 => '�ꥹ�Ȥ򹹿�',
    31 => '�����ˤ��٤Ƥ����򤷤��桼�������˺�����ޤ���?',
    32 => '���٤ƥꥹ��',
    33 => '������륤�٥�Ȥ����򤷤Ƥ��ޤ���',
    34 => '���٥��ID',
    35 => '����Ǥ��ޤ���Ǥ���',
    36 => '������������ޤ���'
);

$LANG_CAL_MESSAGE = array(
    'save' => '���٥�Ȥ���¸����ޤ�����',
    'delete' => '���٥�Ȥ��������ޤ�����',
    'private' => '���٥�Ȥ��Ŀͥ���������¸����ޤ�����',
    'login' => '�Ŀͥ������򳫤��ˤϡ��ǽ�˥����󤷤Ƥ���������',
    'removed' => '�Ŀͥ��������饤�٥�Ȥ��������ޤ�����',
    'noprivate' => '����������ޤ��󤬡����Υ����ȤǤϡ��Ŀͥ�������̵���Ǥ���',
    'unauth' => '����������ޤ��󤬡����٥�ȴ����ڡ����˥����������븢�¤�����ޤ��󡣤��Υ��������ϵ�Ͽ�����Ƥ��������ޤ����ΤǤ�λ������������'
);

$PLG_calendar_MESSAGE4 = "{$_CONF['site_name']}�˥��٥�Ȥ���Ƥ��Ƥ������������꤬�Ȥ��������ޤ��������åդ��������졤��ǧ�Ԥ��ξ��֤ˤʤ�ޤ�������ǧ���줿��硤���Υ����Ȥ�<a href=\"{$_CONF['site_url']}/calendar/index.php\">������</a>����������ɽ������ޤ���";
$PLG_calendar_MESSAGE17 = '���٥�Ȥ���¸����ޤ�����';
$PLG_calendar_MESSAGE18 = '���٥�Ȥ��������ޤ�����';
$PLG_calendar_MESSAGE24 = '���٥�Ȥ��Ŀͥ���������¸����ޤ�����';
$PLG_calendar_MESSAGE26 = '���٥�Ȥ��������ޤ�����';

// Messages for the plugin upgrade
$PLG_calendar_MESSAGE3001 = '�ץ饰����Υ��åץ��졼�ɤϥ��ݡ��Ȥ���Ƥ��ޤ���';
$PLG_calendar_MESSAGE3002 = $LANG32[9];

// Localization of the Admin Configuration UI
$LANG_configsections['calendar'] = array(
    'label' => '��������',
    'title' => '��������������'
);

$LANG_confignames['calendar'] = array(
    'calendarloginrequired' => '���������λ��Ѥ˥�����ɬ��?',
    'hidecalendarmenu' => '���������Υ�˥塼�ι��ܤ򱣤�?',
    'personalcalendars' => '�ĿͤΥ���������ͭ��?',
    'eventsubmission' => '���٥�Ȥο������ߥ��塼��ͭ��?',
    'showupcomingevents' => '���դ������٥�Ȥ�ɽ��?',
    'upcomingeventsrange' => '���դ������٥�Ȥ��ϰ�',
    'event_types' => '���٥�ȤΥ�����',
    'hour_mode' => '����ɽ��',
    'notification' => '�Żҥ᡼�������?',
    'delete_event' => '��ͭ�Ԥȶ��˥��٥�Ȥ���?',
    'aftersave' => '���٥�Ȥ���¸��',
    'default_permissions' => '���٥�ȤΥǥե���ȤΥѡ��ߥå����'
);

$LANG_configsubgroups['calendar'] = array(
    'sg_main' => '�������'
);

$LANG_fs['calendar'] = array(
    'fs_main' => '����Ū�ʥ�������������',
    'fs_permissions' => '�ǥե���ȤΥѡ��ߥå����'
);

// Note: entries 0, 1, 6, 9, 12 are the same as in $LANG_configselects['Core']
$LANG_configselects['calendar'] = array(
    0 => array('�Ϥ�' => 1, '������' => 0),
    1 => array('�Ϥ�' => true, '������' => false),
    6 => array('12' => 12, '24' => 24),
    9 => array('���٥�Ȥ˿ʤ�' => 'item', '�����ꥹ�Ȥ�ɽ��' => 'list', '����������ɽ��' => 'plugin', 'HOME�ڡ�����ɽ��' => 'home', '�������̤�ɽ��' => 'admin'),
    12 => array('���������Բ�' => 0, '�񤭹��߶ػ�' => 2, '�ɤ߽񤭲�ǽ' => 3)
);

?>