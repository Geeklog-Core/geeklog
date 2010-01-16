<?php

###############################################################################
# ukrainian.php
# This is the ukrainian language page for the Geeklog Calendar Plug-in!
#
# Copyright (C) 2006 Vitaliy Biliyenko
# v.lokki@gmail.com
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
    1 => '�������� ��Ħ�',
    2 => '�������, ����� ��Ħ� ��� צ����������.',
    3 => '����',
    4 => '��',
    5 => '����',
    6 => '������ ��Ħ�',
    7 => '������Φ ��Ħ�',
    8 => '������� �� ��Ħ� �� ����� ���������, �� ������ ������ ����������� ���� Ԧ ��Ħ�, �˦ ��� æ�������, ���������� "�� ��������" � ����æ�� �����������.',
    9 => '������ �� ���� ���������',
    10 => '�������� � ���� ���������',
    11 => '������� ��Ħ� �� ��������� %s',
    12 => '��Ħ�',
    13 => '�������',
    14 => '�����',
    15 => '����� �� ���������',
    16 => '��������',
    17 => '���� �������',
    18 => '���� ��˦������',
    19 => '���������� �� ���������',
    20 => '�����',
    21 => '���� �������',
    22 => 'URL',
    23 => '��ۦ ��Ħ�',
    24 => '������Φ ��Ħ�',
    25 => '����� ������Φ� ��Ħ�',
    26 => '��Ħ����� ��Ħ�',
    27 => "���� �� ��Ħ����� ��Ħ� �� {$_CONF['site_name']}, �� ���� ������ �� ��������� ���������, �� ���������ަ ������� �� �������� ������ �� �� ����� ������������� ���������. �� ����æ� <b>��</b> ��� ���Ҧ����� ����� ��������� ��Ħ�, ����� �� �Φ ���������� �� Ҧ���æ.<br" . XHTML . "><br" . XHTML . ">���� �� ��Ħ����� ��Ħ�, �� ���� ������ �� ������� ��ͦΦ���������, � � ��ڦ ��������� ���� ��Ħ� �'������� � ��������� �������Ҧ.",
    28 => '�����',
    29 => '��� �������',
    30 => '��� ��˦������',
    31 => '��Ħ� �� ����� ����',
    32 => '������, ������ �����',
    33 => '������, ������ �����',
    34 => '����/����',
    35 => '�������',
    36 => '������',
    37 => '��� ��Ħ�',
    38 => '���������� ���� ��Ħ�',
    39 => '������������',
    40 => '������ ��Ħ� ��',
    41 => '��������� ���������',
    42 => '���������� ���������',
    43 => '���������',
    44 => 'HTML ���� ����������',
    45 => '��Ħ�����',
    46 => '��Ħ� � �����ͦ',
    47 => '10 ����������Φ��� ��Ħ�',
    48 => '���������',
    49 => '�� ���Ԧ �� ����� ��Ħ�, ��� � Φ��� �� �� �� ����������.',
    50 => '��Ħ�',
    51 => '��������'
);

$_LANG_CAL_SEARCH = array(
    'results' => '���������� � ���������',
    'title' => '�����',
    'date_time' => '���� � ���',
    'location' => '������������',
    'description' => '����'
);

###############################################################################
# calendar.php ($LANG30)

$LANG_CAL_2 = array(
    8 => '������ �������� ��Ħ�',
    9 => '��Ħ� %s',
    10 => '��Ħ� ���',
    11 => '�������� ��������',
    12 => '�� ��������',
    25 => '����� �� ',
    26 => '����� ����',
    27 => '�������',
    28 => '��������� �������� ���',
    29 => '���̦���� ��������',
    30 => '�������� ��Ħ�',
    31 => '������',
    32 => '��Ħ�',
    33 => '����',
    34 => '���',
    35 => '������ ������',
    36 => '��Ħ�����',
    37 => '�������, ���������Φ �������Ҧ �� ����� ���Ԧ ��������Φ',
    38 => '�������� �������ϧ ��Ħ�',
    39 => '����',
    40 => '�������',
    41 => '�����',
    42 => '������ ������� ��Ħ�',
    43 => '��Ħ���Φ ��Ħ�'
);

###############################################################################
# admin/plugins/calendar/index.php, formerly admin/event.php ($LANG22)

$LANG_CAL_ADMIN = array(
    1 => '�������� ��Ħ�',
    2 => '�������',
    3 => '����� ���̦��æ�',
    4 => 'URL ��Ħ�',
    5 => '���� ������� ��Ħ�',
    6 => '���� ��˦������ ��Ħ�',
    7 => '������������ ��Ħ�',
    8 => '���� ��Ħ�',
    9 => '(��������� http://)',
    10 => '�� ����� ������ ����/���, ����� ��Ħ� �� ����',
    11 => '�������� ���������',
    12 => '��� �ͦ���� �� �������� ��Ħ�, �����Φ�� �� ������ ����������� �����.  ��� �������� ���� ��Ħ�, �����Φ�� "�������� ����" ���Ҧ. �����Φ�� ������ ��Ц������, ��� �������� ��Ц� ������ϧ ��Ħ�.',
    13 => '�����',
    14 => '���� �������',
    15 => '���� ��˦������',
    16 => '',
    17 => "�� ����������� �������� ������ �� ��Ħ�, �� ��ϧ � ��� ����� ����.  �� ������ ��������. ����-�����, <a href=\"{$_CONF['site_admin_url']}/plugins/calendar/index.php\">�����Φ���� �� ��ͦΦ��������� ��Ħ�</a>.",
    18 => '',
    19 => '',
    20 => '��������',
    21 => '���������',
    22 => '��������',
    23 => '����������� ���� �������.',
    24 => '����������� ���� ��˦������.',
    25 => '���� ��˦������ �����դ ��Ԧ �������.',
    26 => 'Delete old entries',
    27 => 'These are the events that are older than ',
    28 => ' months. Please click on the trashcan Icon on the bottom to delete them, or select a different timespan:<br' . XHTML . '>Find all entries that are older than ',
    29 => ' months.',
    30 => 'Update List',
    31 => 'Are You sure you want to permanently delete ALL selected users?',
    32 => 'List all',
    33 => 'No events selected for deletion',
    34 => 'Event ID',
    35 => 'could not be deleted',
    36 => 'Sucessfully deleted'
);

$LANG_CAL_MESSAGE = array(
    'save' => '���� ��Ħ� ��Ц��� ���������.',
    'delete' => '��Ħ� ��Ц��� ��������.',
    'private' => '��Ħ� ��Ц��� ��������� �� ������ ���������.',
    'login' => '��������� צ������ ��� ��������� ��������, ���� �� �� �צ����� �� �������',
    'removed' => '��Ħ� ��Ц��� �������� � ������ ���������� ���������',
    'noprivate' => '�������, ���������Φ �������Ҧ �� ����� ���Ԧ ��������Φ',
    'unauth' => '�������, ��� � ��� ����� ������� �� ���Ҧ��� ��ͦΦ��������� ��Ħ�. ����-�����, ��������, �� �Ӧ ������ ������æ��������� ������� �����������.'
);

$PLG_calendar_MESSAGE4 = "���դ�� �� ���������� ��Ħ� �� {$_CONF['site_name']}.  �� �������� �� ��������� ������ ���������.  � ��ڦ ���������, ���� ��Ħ� ����� ���� �������� ���, � ������ <a href=\"{$_CONF['site_url']}/calendar/index.php\">�������Ҧ</a>.";
$PLG_calendar_MESSAGE17 = '���� ��Ħ� ��Ц��� ���������.';
$PLG_calendar_MESSAGE18 = '��Ħ� ��Ц��� ��������.';
$PLG_calendar_MESSAGE24 = '��Ħ� ��Ц��� ��������� �� ������ ���������.';
$PLG_calendar_MESSAGE26 = '��Ħ� ��Ц��� ��������.';

// Messages for the plugin upgrade
$PLG_calendar_MESSAGE3001 = 'Plugin upgrade not supported.';
$PLG_calendar_MESSAGE3002 = $LANG32[9];

// Localization of the Admin Configuration UI
$LANG_configsections['calendar'] = array(
    'label' => 'Calendar',
    'title' => 'Calendar Configuration'
);

$LANG_confignames['calendar'] = array(
    'calendarloginrequired' => 'Calendar Login Required?',
    'hidecalendarmenu' => 'Hide Calendar Menu Entry?',
    'personalcalendars' => 'Enable Personal Calendars?',
    'eventsubmission' => 'Enable Submission Queue?',
    'showupcomingevents' => 'Show upcoming Events?',
    'upcomingeventsrange' => 'Upcoming Events Range',
    'event_types' => 'Event Types',
    'hour_mode' => 'Hour Mode',
    'notification' => 'Notification Email?',
    'delete_event' => 'Delete Events with Owner?',
    'aftersave' => 'After Saving Event',
    'default_permissions' => 'Event Default Permissions'
);

$LANG_configsubgroups['calendar'] = array(
    'sg_main' => 'Main Settings'
);

$LANG_fs['calendar'] = array(
    'fs_main' => 'General Calendar Settings',
    'fs_permissions' => 'Default Permissions'
);

// Note: entries 0, 1, 6, 9, 12 are the same as in $LANG_configselects['Core']
$LANG_configselects['calendar'] = array(
    0 => array('True' => 1, 'False' => 0),
    1 => array('True' => true, 'False' => false),
    6 => array('12' => 12, '24' => 24),
    9 => array('Forward to Event' => 'item', 'Display Admin List' => 'list', 'Display Calendar' => 'plugin', 'Display Home' => 'home', 'Display Admin' => 'admin'),
    12 => array('No access' => 0, 'Read-Only' => 2, 'Read-Write' => 3)
);

?>
