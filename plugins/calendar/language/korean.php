<?php

###############################################################################
# korean.php
# This is the Korean language page for the Geeklog Calendar Plug-in!
#
# Copyright (C) 2001 Tony Bibbs
# tony@tonybibbs.com
# Copyright (C) 2005 Trinity Bays
# trinity93@gmail.com
# Translated by IvySOHO Ivy(KOMMA Tetsuko/Kim Younghie)
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
    1 => ' �̺�Ʈ��ĳ��',
    2 => '-',
    3 => '�Ͻ�',
    4 => '���',
    5 => '����',
    6 => '�̺�Ʈ�� �߰�',
    7 => '�������� �̺�Ʈ',
    8 => '���ν�ĳ�ٿ� �� �̺�Ʈ�� �߰��ϸ�, �����ν�ĳ�١��� ����� �����޴����� �����Ͽ� �ս��� �� �� �ֽ��ϴ١�',
    9 => '���ν�ĳ�ٿ� �߰�',
    10 => '���ν�ĳ�ٿ��� ����',
    11 => '�� �̺�Ʈ�� %s���� ���ν�ĳ�ٿ� �߰�',
    12 => '�̺�Ʈ',
    13 => '����',
    14 => '����',
    15 => '��ĳ�ٷ� ���ư���',
    16 => '��ĳ��',
    17 => '������',
    18 => '������',
    19 => '�̺�Ʈ�� ��Ͻ�û',
    20 => '����',
    21 => '������',
    22 => 'URL',
    23 => '���� �̺�Ʈ',
    24 => '����Ʈ�� �̺�Ʈ',
    25 => '-',
    26 => '�̺�Ʈ�� ���۾���',
    27 => "{$_CONF['site_name']} �� �̺�Ʈ�� �����ϸ飬����Ʈ ��ü��ĳ�ٿ� ��ϵ˴ϴ١�<br" . XHTML . ">��ü��ĳ���� �̺�Ʈ�� �� ����ڰ� �ʿ信 ���� ���ν�ĳ�ٿ� ��� �� �� �ֽ��ϴ١�",
    28 => '����',
    29 => '�����Ͻ�',
    30 => '�����Ͻ�',
    31 => '�Ϸ������� �̺�Ʈ',
    32 => '�ּ�1',
    33 => '�ּ�2',
    34 => '�����̸�',
    35 => '���ñ���',
    36 => '�����ȣ',
    37 => '�̺�Ʈ�� ����',
    38 => '�̺�Ʈ�� ������ ����',
    39 => '���',
    40 => '�̺�Ʈ�� �߰���',
    41 => '��ü��ĳ��',
    42 => '���ν�ĳ��',
    43 => '��ũ',
    44 => 'HTML�±״� ����� �� �����ϴ�',
    45 => '����',
    46 => '�ý����� �̺�Ʈ',
    47 => '�̺�Ʈ�� ���� 10��',
    48 => '�˻���',
    49 => '�� ����Ʈ���� �̺�Ʈ�� ���ų�, �ƹ��� �̺�Ʈ�� Ŭ���� �� ���ų� ��� ���� ������ �����˴ϴ١�',
    50 => '�̺�Ʈ',
    51 => '����',
    'autotag_desc_event' => '[event: id alternate title] - Displays a link to an Event Link from the Calendar using the Event Title as the title. An alternate title may be specified but is not required.'
);

$_LANG_CAL_SEARCH = array(
    'results' => '�̺�Ʈ������ �˻����',
    'title' => '����',
    'date_time' => '�Ͻ�',
    'location' => '���',
    'description' => '�ڼ��� ����'
);

###############################################################################
# calendar.php ($LANG30)

$LANG_CAL_2 = array(
    8 => '�����̺�Ʈ�� �߰� ',
    9 => '%s �� �̺�Ʈ',
    10 => '�̺�Ʈ��',
    11 => '��ü��ĳ��',
    12 => '���ν�ĳ��',
    25 => '���ư��⣺',
    26 => '�Ϸ�����',
    27 => '��',
    28 => '���ν�ĳ�٣�',
    29 => '��ü��ĳ��',
    30 => '�̺�Ʈ �߰�',
    31 => '�߰�',
    32 => '�̺�Ʈ',
    33 => '��¥',
    34 => '�ð�',
    35 => '�����߰�',
    36 => '����',
    37 => '�� ����Ʈ���� ���ν�ĳ���� ��ȿ���� �ʽ��ϴ١�',
    38 => '�����̺�Ʈ ������',
    39 => '��',
    40 => '��',
    41 => '��',
    42 => '��ü�̺�Ʈ �߰�',
    43 => '�̺�Ʈ ����'
);

###############################################################################
# admin/plugins/calendar/index.php, formerly admin/event.php ($LANG22)

$LANG_CAL_ADMIN = array(
    1 => '�̺�Ʈ������',
    2 => '����',
    3 => '���۸��',
    4 => '�̺�ƮURL',
    5 => '�̺�Ʈ �����Ͻ�',
    6 => '�̺�Ʈ �����Ͻ�',
    7 => '�̺�Ʈ ���',
    8 => '�̺�Ʈ�� ���� ����',
    9 => '(http://���� �����Ͻñ� �ٶ��ϴ�)',
    10 => '�̺�Ʈ ��¥?�ð������񣬼����� �Է��Ͻñ� �ٶ��ϴ١�',
    11 => '��ĳ�� ����',
    12 => '�̺�Ʈ�� ����?�����£������� �̺�Ʈ ������������ Ŭ�� �Ͻñ� �ٶ��ϴ١� ���ο� �̺�Ʈ�� �ۼ��� ���, ���� ���ű��̺�Ʈ���� Ŭ�� �Ͻñ� �ٶ��ϴ١�',
    13 => '�۾���',
    14 => '�����Ͻ�',
    15 => '�����Ͻ�',
    16 => '',
    17 => "���������� ���� �̺�Ʈ�� �����Ϸ��� �ϼ̽��ϴ١� �� ������ ��� �˴ϴ�. <a href=\"{$_CONF['site_admin_url']}/plugins/calendar/index.php\"> �̺�Ʈ ����ȭ��</a>���� ���ư��ñ� �ٶ��ϴ�.��",
    18 => '',
    19 => '',
    20 => '����',
    21 => '���',
    22 => '����',
    23 => '�����Ͻø� ��Ȯ�ϰ� �Է��� �ֽñ� �ٶ��ϴ١�',
    24 => '�����Ͻø� ��Ȯ�ϰ� �Է��� �ֽñ� �ٶ��ϴ١�',
    25 => '�����Ͻø� ��Ȯ�ϰ� �Է��� �ֽñ� �ٶ��ϴ١�',
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
    'save' => '�̺�Ʈ�� ���� �Ǿ����ϴ١�',
    'delete' => '�̺�Ʈ�� ���� �Ǿ����ϴ١�',
    'private' => '�̺�Ʈ�� ���ν�ĳ�ٿ� ���� �Ǿ����ϴ١�',
    'login' => '���ν�ĳ���� �������£����� �α��� �� �ֽñ� �ٶ��ϴ١�',
    'removed' => '���ν�ĳ�ٿ��� �̺�Ʈ�� ���� �Ǿ����ϴ١�',
    'noprivate' => '�˼��մϴٸ����� ����Ʈ�����£����ν�ĳ���� ��ȿ�մϴ١�',
    'unauth' => '�˼��մϴٸ����̺�Ʈ ������������ ������ ������ �����ϴ١� �� ������ ��� �ȴٴ� ���� ������ �ֽñ� �ٶ��ϴ�.'
);

$PLG_calendar_MESSAGE4 = "{$_CONF['site_name']} �� �̺�Ʈ�� ������ �ּż� ����� �����մϴ١����ǿ��� ���������������� ��ٸ��� �ִ� �����Դϴ١� ������ �Ǹ� �� ����Ʈ�� <a href=\"{$_CONF['site_url']}/calendar/index.php\">��ĳ��</a> �ι��� ǥ�� �˴ϴ١�";
$PLG_calendar_MESSAGE17 = '�̺�Ʈ�� ���� �Ǿ����ϴ١�';
$PLG_calendar_MESSAGE18 = '�̺�Ʈ�� ���� �Ǿ����ϴ١�';
$PLG_calendar_MESSAGE24 = '�̺�Ʈ�� ���ν�ĳ�ٿ� ���� �Ǿ����ϴ١�';
$PLG_calendar_MESSAGE26 = '�̺�Ʈ�� ���� �Ǿ����ϴ١�';

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
    'default_permissions' => 'Event Default Permissions',
    'autotag_permissions_event' => '[event: ] Permissions',
    'block_enable' => 'Enabled',
    'block_isleft' => 'Display Block on Left',
    'block_order' => 'Block Order',
    'block_topic_option' => 'Topic Options',
    'block_topic' => 'Topic',
    'block_group_id' => 'Group',
    'block_permissions' => 'Permissions'
);

$LANG_configsubgroups['calendar'] = array(
    'sg_main' => 'Main Settings'
);

$LANG_tab['calendar'] = array(
    'tab_main' => 'General Calendar Settings',
    'tab_permissions' => 'Default Permissions',
    'tab_autotag_permissions' => 'Autotag Usage Permissions',
    'tab_events_block' => 'Events Block'
);

$LANG_fs['calendar'] = array(
    'fs_main' => 'General Calendar Settings',
    'fs_permissions' => 'Default Permissions',
    'fs_autotag_permissions' => 'Autotag Usage Permissions',
    'fs_block_settings' => 'Block Settings',
    'fs_block_permissions' => 'Block Permissions'
);

// Note: entries 0, 1, 6, 9, 12 are the same as in $LANG_configselects['Core']
$LANG_configselects['calendar'] = array(
    0 => array('True' => 1, 'False' => 0),
    1 => array('True' => true, 'False' => false),
    6 => array('12' => 12, '24' => 24),
    9 => array('Forward to Event' => 'item', 'Display Admin List' => 'list', 'Display Calendar' => 'plugin', 'Display Home' => 'home', 'Display Admin' => 'admin'),
    12 => array('No access' => 0, 'Read-Only' => 2, 'Read-Write' => 3),
    13 => array('No access' => 0, 'Use' => 2),
    14 => array('No access' => 0, 'Read-Only' => 2),
    15 => array('All' => TOPIC_ALL_OPTION, 'Homepage Only' => TOPIC_HOMEONLY_OPTION, 'Select Topics' => TOPIC_SELECTED_OPTION)
);

?>
