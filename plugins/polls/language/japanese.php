<?php

###############################################################################
# japanese.php
#
# This is the Japanese language file for the Geeklog Polls plugin
#
# Copyright (C) 2001 Tony Bibbs
# tony AT tonybibbs DOT com
# Copyright (C) 2005 Trinity Bays
# trinity93 AT gmail DOT com
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

$LANG_POLLS = array(
    'polls'             => '���󥱡���',
    'results'           => '���',
    'pollresults'       => '��ɼ���',
    'votes'             => '��ɼ',
    'vote'              => '��ɼ����',
    'pastpolls'         => '���󥱡��Ȥΰ���',
    'savedvotetitle'    => '��ɼ���꤬�Ȥ��������ޤ���',
    'savedvotemsg'      => '�ơ��ޡ�',
    'pollstitle'        => '������Υ��󥱡���',
    'polltopics'        => '¾�Υ��󥱡��Ȥ򸫤�',
    'stats_top10'       => '���󥱡��ȡʾ��10���',
    'stats_topics'      => '���󥱡��Ȥμ���',
    'stats_votes'       => '��ɼ',
    'stats_none'        => '���Υ����Ȥˤϥ��󥱡��Ȥ��ʤ������ޤ�ï����ɼ���Ƥ��ʤ��褦�Ǥ���',
    'stats_summary'     => '���󥱡��ȿ�(��ɼ��)',
    'open_poll'         => '��ɼ����',
    'answer_all'        => '�Ĥ�Τ��٤Ƥμ���ˤ�������������',
    'not_saved'         => '��̤���¸����ޤ���Ǥ���',
    'upgrade1'          => '���󥱡��ȥץ饰����ο������С�����󤬥��󥹥ȡ��뤵��ޤ�����',
    'upgrade2'          => '���åץ��졼�ɤ��Ƥ���������',
    'editinstructions'  => '���󥱡���ID�����Ϥ��Ƥ������������ʤ��Ȥ�1�Ĥμ����2�Ĥβ������Ѱդ��Ƥ���������'
);

###############################################################################
# admin/plugins/polls/index.php

$LANG25 = array(
    1 => '�⡼��',
    2 => '�ơ��ޤȼ���Ⱦ��ʤ��Ȥ�1�Ĥβ��������Ϥ��Ƥ���������',
    3 => '��������',
    4 => "���󥱡��ȡ� %s �ˤ���¸����ޤ���",
    5 => '���󥱡��Ȥ��Խ�',
    6 => '���󥱡���ID',
    7 => '(���ڡ�����ޤޤʤ�����)',
    8 => '�ۡ���ڡ�����ɽ������',
    9 => '�ơ���',
    10 => '���� / ��ɼ��',
    11 => "���󥱡���( %s )�������˥��顼������ޤ���",
    12 => "���󥱡���( %s )�μ�����ܤ˥��顼������ޤ���",
    13 => '���󥱡��Ȥκ���',
    14 => '��¸',
    15 => '���',
    16 => '���',
    17 => '���󥱡���ID�����Ϥ��Ƥ�������',
    18 => '���󥱡��Ȱ���',
    19 => '���󥱡��Ȥκ�����Խ��ϥ����ȥ뺸�Υ�������򥯥�å��������˺���������ϡֿ��������פ򥯥�å����Ƥ��������������ȥ�򥯥�å�����ȥ��󥱡��Ȥ�����Ǥ��ޤ���',
    20 => '��ɼ��',
    21 => '�������������ݤ���ޤ���',
    22 => "�������¤Τʤ����󥱡��Ȥ��Խ����褦�Ȥ��ޤ��������ι԰٤ϵ�Ͽ����ޤ���<a href=\"{$_CONF['site_admin_url']}/poll.php\">��ɼ�δ�������</a>����äƤ���������",
    23 => '�������󥱡���',
    24 => '��������',
    25 => '�Ϥ�',
    26 => '������',
    27 => '�Խ�',
    28 => '����',
    29 => '�������',
    30 => 'ɽ�����',
    31 => '����',
    32 => '����Υƥ����Ȥ�������ȡ����󥱡��Ȥ�����䤬�������ޤ���',
    33 => '��ɼ��ǽ',
    34 => '�ơ���:',
    35 => '���Υ��󥱡��ȤˤϤ���ˤ⤦',
    36 => '����䤬����ޤ���',
    37 => '��ɼ���Ϸ�������',
    38 => '���󥱡��ȼ»���ϡ������ʡ��ȥ롼�ȴ����Ԥ�������̤򸫤뤳�Ȥ��Ǥ��ޤ���',
    39 => '�ơ��ޤ�1�İʾ�μ��䤬�������ɽ������ޤ���',
    40 => '���󥱡��Ȥη�̤򸫤�'
);

$PLG_polls_MESSAGE19 = '���󥱡��Ȥ���Ͽ����ޤ�����';
$PLG_polls_MESSAGE20 = '���󥱡��ȤϺ������ޤ�����';

// Messages for the plugin upgrade
$PLG_polls_MESSAGE3001 = '�ץ饰����Υ��åץ��졼�ɤϥ��ݡ��Ȥ���Ƥ��ޤ���';
$PLG_polls_MESSAGE3002 = $LANG32[9];


// Localization of the Admin Configuration UI
$LANG_configsections['polls'] = array(
    'label' => '���󥱡���',
    'title' => '���󥱡��Ȥ�����'
);  

$LANG_confignames['polls'] = array(
    'pollsloginrequired' => '��������׵᤹��',
    'hidepollsmenu' => '��˥塼��ɽ�����ʤ�',
    'maxquestions' => '���󥱡�����μ���κ����',
    'maxanswers' => '������������κ����',
    'answerorder' => '���󥱡��ȷ�̤�ɽ����',
    'pollcookietime' => '��ɼ�ԤΥ��å�����ͭ������',
    'polladdresstime' => '��ɼ�Ԥ�IP���ɥ쥹��ͭ������',
    'delete_polls' => '��ͭ�Ԥκ���ȶ��˺������',
    'aftersave' => '���󥱡�����¸��β�������',
    'default_permissions' => '�ѡ��ߥå����'
);

$LANG_configsubgroups['polls'] = array(
    'sg_main' => '�ᥤ��'
);

$LANG_fs['polls'] = array(
    'fs_main' => '���󥱡��ȤΥᥤ������',
    'fs_permissions' => '���󥱡��ȤΥǥե���ȥѡ��ߥå�����[0]��ͭ�� [1]���롼�� [2]���С� [3]�����ȡ�'
);

// Note: entries 0, 1, and 12 are the same as in $LANG_configselects['Core']
$LANG_configselects['polls'] = array(
    0 => array('�Ϥ�' => 1, '������' => 0),
    1 => array('�Ϥ�' => TRUE, '������' => FALSE),
    2 => array('��Ͽ��' => 'submitorder', '��ɼ��' => 'voteorder'),
    9 => array('�����������󥱡��Ȥ�ɽ������' => 'item', '���󥱡��Ȱ�����ɽ������' => 'list', '������Υ��󥱡��Ȱ�����ɽ������' => 'plugin', 'Home��ɽ������' => 'home', '��������TOP��ɽ������' => 'admin'),
    12 => array('���������Բ�' => 0, 'ɽ��' => 2, 'ɽ�����Խ�' => 3)
);

?>