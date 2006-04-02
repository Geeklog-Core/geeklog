<?php

###############################################################################
# japanese.php
# This is the Japanese language page for the Geeklog Polls Plug-in!
#
# Copyright (C) 2001 Tony Bibbs
# tony@tonybibbs.com
# Copyright (C) 2005 Trinity Bays
# trinity93@gmail.com
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


$LANG_POLLS = array(
    'polls'     => '���󥱡���',
    'results'   => '���',
    'pollresults'   => '��ɼ���',
    'votes'     => '��ɼ',
    'vote'      => '��ɼ����',
    'pastpolls' => '���󥱡��Ȥΰ���',
    'savedvotetitle'    => '��ɼ����Ͽ����ޤ���',
    'savedvotemsg'  => '������ɼ����Ͽ����ޤ���',
    'pollstitle'    => '�罸��Υ��󥱡���',
    'pollquestions' => '¾�Υ��󥱡��Ȥ򸫤�'
);

###############################################################################
# admin/plugins/polls/index.php

$LANG25 = array(
    1 => '�⡼��',
    2 => '����Ⱥ����Ĥ����������Ϥ��Ƥ�������',
    3 => '��������',
    4 => "���󥱡��ȡ� %s �ˤ���¸����ޤ���",
    5 => '���󥱡��Ȥ��Խ�',
    6 => '���󥱡��Ȥ� ID',
    7 => '(���ڡ�����ޤޤʤ�����)',
    8 => '�ۡ���ڡ�����ɽ������',
    9 => '���䤹�뤳��',
    10 => '���� �� ��ɼ��',
    11 => "���󥱡���( %s )�ˤ����������˥��顼������ޤ���",
    12 => "���󥱡���( %s )�ˤ����������ܤ˥��顼������ޤ���",
    13 => '���󥱡��Ȥκ���',
    14 => '��¸',
    15 => '���',
    16 => '���',
    17 => '��ɼID�����Ϥ��Ƥ�������',
    18 => '���󥱡��Ȱ���',
    19 => '���󥱡��Ȥ������Խ����뤿��ˤϡ������ȥ뺸�Υ�������򥯥�å����Ƥ��������������˺���������ϡ��ֿ��������פ򥯥�å����Ƥ��������������ȥ�򥯥�å�����ȥ��󥱡��Ȥ�����Ǥ��ޤ���',
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
    30 => 'ɽ�����'

);

$PLG_polls_MESSAGE19 = '���󥱡��Ȥ���Ͽ����ޤ�����';
$PLG_polls_MESSAGE20 = 'Your poll has been successfully deleted.';

?>
