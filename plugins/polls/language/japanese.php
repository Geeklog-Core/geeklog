<?php

###############################################################################
# japanese.php
# This is the Japanese language page for the Geeklog Polls Plug-in!
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

$LANG_POLLS = array(
    'polls' => '���󥱡���',
    'results' => '���',
    'pollresults' => '��ɼ���',
    'votes' => '��ɼ',
    'vote' => '��ɼ����',
    'pastpolls' => '���󥱡��Ȥΰ���',
    'savedvotetitle' => '��ɼ����Ͽ����ޤ���',
    'savedvotemsg' => '������ɼ����Ͽ����ޤ���',
    'pollstitle' => '�罸��Υ��󥱡���',
    'polltopics' => '¾�Υ��󥱡���',
    'stats_top10' => '���10�Υ��󥱡���',
    'stats_topics' => '���󥱡��Ȥ�����',
    'stats_votes' => '��ɼ',
    'stats_none' => '���Υ����Ȥˤϥ��󥱡��Ȥ��ʤ�����ï����ɼ���Ƥ��ʤ��褦�Ǥ���',
    'stats_summary' => '���󥱡��� (����) in the system',
    'open_poll' => '��ɼ������դ���',
    'answer_all' => '�Ĥ�μ���ˤ��٤������Ƥ���������',
    'not_saved' => '��̤���¸����ޤ���Ǥ�����',
    'upgrade1' => '���������󥱡��ȤΥץ饰����򥤥󥹥ȡ��뤵�줨���ޤ����ɤ�����',
    'upgrade2' => '���åץ��졼�ɤ��Ʋ�������',
    'editinstructions' => '���󥱡��Ȥ�ID�Ⱦ��ʤ��Ȥ�1�Ĥμ��䡢���μ�����б�����2�Ĥβ�����ɬ�פǤ���',
);

###############################################################################
# admin/plugins/polls/index.php

$LANG25 = array(
    1 => '�⡼��',
    2 => '����Ⱦ��ʤ��Ȥ�1�Ĥμ��䡢���μ�����б�����2�Ĥβ��������Ϥ��Ʋ�������',
    3 => '������',
    4 => '���󥱡��� %s ����¸���ޤ���',
    5 => '���󥱡��Ȥ��Խ�',
    6 => '���󥱡��Ȥ�ID',
    7 => '(���ڡ�������Ѥ��ʤ��Ǥ�������)',
    8 => '���󥱡��ȡ��֥�å���ɽ��',
    9 => '����',
    10 => '���� / ��ɼ / ���',
    11 => '���󥱡���%s�β����Υǡ����μ����ǥ��顼��ȯ�����ޤ�����',
    12 => '���󥱡���%s�μ���Υǡ����μ����ǥ��顼��ȯ�����ޤ�����',
    13 => '���󥱡��Ȥ����',
    14 => '��¸',
    15 => '����󥻥�',
    16 => '���',
    17 => '���󥱡��Ȥ�ID�����Ϥ��Ʋ�����',
    18 => '|���󥱡��Ȥ�|�ꥹ��',
    19 => '���󥱡��Ȥ��Խ���������ˤϡ����󥱡��Ȥ��Խ���������򥯥�å����Ʋ����������������󥱡��Ȥ��������ˤϾ�Ρֿ��������פ򥯥�å����Ʋ�������',
    20 => '��ɼ��',
    21 => '������������ݤ���ޤ���',
    22 => "����������������ʤ����󥱡��Ȥ˥����������褦�Ȥ���ޤ��������λ�ߤϵ�Ͽ����Ƥ��ޤ����ɤ���<a href=\"{$_CONF['site_admin_url']}/poll.php\">���󥱡��Ȥδ����β��̤���äƲ�������</a>",
    23 => '���������󥱡���',
    24 => '����Home',
    25 => '�Ϥ�',
    26 => '������',
    27 => '�Խ�',
    28 => '��ɼ',
    29 => '����',
    30 => '��̤�����',
    31 => '����',
    32 => '����򥢥󥱡��Ȥ���������ˤϡ�����Υƥ����Ȥ���ˤ��Ƥ���������',
    33 => '��ɼ�����դ���',
    34 => '���󥱡��Ȥ�����:',
    35 => '���Υ��󥱡��Ȥϡ�����',
    36 => '�Ĥμ��䤬����ޤ���',
    37 => '�����դ���Ϸ�̤򱣤�',
    38 => '���󥱡��Ȥ������դ���δ֤ϡ���ͭ�Ԥ�root��������̤򸫤�ޤ���',
    39 => '�����1�İʾ�μ��䤬���������ɽ������ޤ���',
    40 => '���Υ��󥱡��ȤΤ��٤Ƥβ����򸫤롣'
);

$PLG_polls_MESSAGE19 = '���󥱡��Ȥ���Ͽ���ޤ�����';
$PLG_polls_MESSAGE20 = '���󥱡��Ȥ������ޤ�����';

// Messages for the plugin upgrade
$PLG_polls_MESSAGE3001 = '�ץ饰����Υ��åץ��졼�ɤϥ��ݡ��Ȥ���Ƥ��ޤ���';
$PLG_polls_MESSAGE3002 = $LANG32[9];

// Localization of the Admin Configuration UI
$LANG_configsections['polls'] = array(
    'label' => '���󥱡���',
    'title' => '���󥱡��Ȥ�����'
);

$LANG_confignames['polls'] = array(
    'pollsloginrequired' => '���󥱡��Ȥ˥�����ɬ��?',
    'hidepollsmenu' => '���󥱡��ȤΥ�˥塼���ܤ򱣤�?',
    'maxquestions' => '���󥱡��Ȥ����������κ����',
    'maxanswers' => '���䤢����β����κ����',
    'answerorder' => '���󥱡��Ȥη��...',
    'pollcookietime' => '���󥱡��Ȥ�Cookie��ͭ������',
    'polladdresstime' => '���󥱡��Ȥ�IP���ɥ쥹��ͭ������',
    'delete_polls' => '��ͭ�Ԥȶ��˥��󥱡��Ȥ���?',
    'aftersave' => '���󥱡��Ȥ���¸��',
    'default_permissions' => '���󥱡��ȤΥǥե���ȤΥѡ��ߥå����'
);

$LANG_configsubgroups['polls'] = array(
    'sg_main' => '�������'
);

$LANG_fs['polls'] = array(
    'fs_main' => '���󥱡��Ȥΰ���Ū������',
    'fs_permissions' => '�ǥե���ȤΥѡ��ߥå����'
);

// Note: entries 0, 1, and 12 are the same as in $LANG_configselects['Core']
$LANG_configselects['polls'] = array(
    0 => array('�Ϥ�' => 1, '������' => 0),
    1 => array('�Ϥ�' => true, '������' => false),
    2 => array('���󥱡��Ƚ�' => 'submitorder', '��ɼ��' => 'voteorder'),
    9 => array('���󥱡��Ȥ˿ʤ�' => 'item', '�����ꥹ�Ȥ�ɽ��' => 'list', '�������줿�ꥹ�Ȥ�ɽ��' => 'plugin', 'HOME�ڡ�����ɽ��' => 'home', '�������̤�ɽ��' => 'admin'),
    12 => array('���������Բ�' => 0, '�񤭹��߶ػ�' => 2, '�ɤ߽񤭲�ǽ' => 3)
);

?>