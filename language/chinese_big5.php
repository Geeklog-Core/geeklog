<?php

###############################################################################
# chinese_big5.php
#
# Last Modified:20021023
# Version: 0.91
#
# This is the Chinese (big5) language page for GeekLog!
#
# Copyright (C) 2002 Jacky Chan
# jacky@netosoft.com
#
# Note: This is the first release. If you want to rephrase sentences, please 
#       drop me an email.
#
# Chinese punctuation used in this file
# �F�J�B�I�A�C�H
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

$LANG_CHARSET = 'big5';

###############################################################################
# Array Format:
# $LANGXX[YY]:  $LANG - variable name
#               XX    - file id number
#               YY    - phrase id number
###############################################################################

###############################################################################
# USER PHRASES - These are file phrases used in end user scripts
###############################################################################

###############################################################################
# lib-common.php

$LANG01 = array(
    1 => '�^�m�̡J',
    2 => 'Ū�h��',
    3 => '�ӷN��',
    4 => '�s��',
    5 => '�벼',
    6 => '���G',
    7 => '�벼���G',
    8 => '�벼',
    9 => '�޲z�̥\\��J',
    10 => '���檫',
    11 => '�G��',
    12 => '�ե�',
    13 => '�D�D',
    14 => '�s��',
    15 => '�ƥ�',
    16 => '�벼',
    17 => '�Τ�',
    18 => 'SQL Query',
    19 => '�n�X',
    20 => '�Τ��T�J',
    21 => '�Τ�W',
    22 => '�Τ��ѧO��',
    23 => '�w������',
    24 => '�ΦW',
    25 => '�^�_',
    26 => '�H�U�N���u�ݱi�K�̭ӤH�[�I�C',
    27 => '�̪�o��',
    28 => '�R��',
    29 => '�S���N���C',
    30 => '�ª��G��',
    31 => '���\�� HTML �аO:',
    32 => '���~�A�L�Ī��Τ�W',
    33 => '���~�A����g�t�Τ�x;',
    34 => '���~',
    35 => '�n�X',
    36 => '�_',
    37 => '�S���G��',
    38 => 'Content Syndication',
    39 => '�Ϸs',
    40 => 'You have <tt>register_globals = Off</tt> in your <tt>php.ini</tt>. However, Geeklog requires <tt>register_globals</tt> to be <strong>on</strong>. Before you continue, please set it to <strong>on</strong> and restart your web server.',
    41 => '�ȤH',
    42 => '�@��:',
    43 => '�^�_�o��',
    44 => '����',
    45 => 'MySQL ���~���X',
    46 => 'MySQL ���~��T',
    47 => '�Τ�\\��',
    48 => '�b���T',
    49 => '�e���]�w',
    50 => '���~�� SQL statement',
    51 => '���U',
    52 => '�s',
    53 => '�޲z�̭���',
    54 => '���ॴ�}���C',
    55 => '���B',
    56 => '�벼',
    57 => '�K�X',
    58 => '�n�J',
    59 => "�S���b��H<a href=\"{$_CONF['site_url']}/users.php?mode=new\">�b���n�O</a>",
    60 => '�o��N��',
    61 => '�s�W�b��',
    62 => '�r',
    63 => '�N���]�w',
    64 => '��峹�q�l���B��',
    65 => '�[�ݥi�C�L������',
    66 => '�ڪ����',
    67 => '�w��Ө�',
    68 => '����',
    69 => '�p��',
    70 => '�j�M',
    71 => '�^�m',
    72 => '�U�����귽',
    73 => '�벼����',
    74 => '���',
    75 => '�i���j��',
    76 => '�����έp�ƾ�',
    77 => 'Plugins',
    78 => '�Y�N�o�ͪ���',
    79 => '�s�A���F��',
    80 => '�ӷs�G��(',
    81 => '�s���G��(',
    82 => ' �p�ɤ�)',
    83 => '�N��',
    84 => '�s��',
    85 => '�̪�|�Q�K�p��',
    86 => '�S���s���N��',
    87 => '�̪��ӬP��',
    88 => '�S���s���s��',
    89 => '�S���Ƶo��',
    90 => '����',
    91 => '�s�@�o���ΤF',
    92 => '��',
    93 => '���v',
    94 => 'All trademarks and copyrights on this page are owned by their respective owners.',
    95 => 'Powered By',
    96 => '�p��',
    97 => '�r����',
    98 => 'Plug-ins',
    99 => '�G��',
    100 => '�S���s���G��',
    101 => '�A���ƥ�',
    102 => '�������ƥ�',
    103 => '��Ʈw�ƥ�',
    104 => '��',
    105 => '�H���Τ�',
    106 => '�[��',
    107 => 'GL ��������',
    108 => '�M���w�ĶJ�s��'
);

###############################################################################
# calendar.php

$LANG02 = array(
    1 => '�ƥ���',
    2 => '��p�A�S���ƥ�C',
    3 => '��',
    4 => '�a',
    5 => '��',
    6 => '�s�W�ƥ�',
    7 => '�Y�N�o�ͪ���',
    8 => '�b�N�o�ƥ[�i�A����䤧��A�A�i�I�� "�ڪ����" ���[��',
    9 => '�[�i�ڪ����',
    10 => '�q�ڪ���䤤�h��',
    11 => "��o�ƥ[�i {$_USER['username']} �����",
    12 => '�ƥ�',
    13 => '�}�l',
    14 => '����',
    15 => '�^����'
);

###############################################################################
# comment.php

$LANG03 = array(
    1 => '�o��N��',
    2 => '�o��覡',
    3 => '�n�X',
    4 => '�s�W�b��',
    5 => '�Τ�W',
    6 => '�����ݭn�n�J�~�i�o��N���A�еn�J�C�p�G�A�S���b��A�ШϥΤU�������n�O�C',
    7 => '�A�̫�o���N���O�b ',
    8 => " ���e�C�������w�ܤ� {$_CONF['commentspeedlimit']} ���~�i�A�o��N��",
    9 => '�N��',
    10 => '',
    11 => '�o��N��',
    12 => '�ж�g���D���N����',
    13 => '�ѧA�Ѧ�',
    14 => '�w��',
    15 => '',
    16 => '���D',
    17 => '���~',
    18 => '���n���F��',
    19 => '�кɶq���n���D�C',
    20 => '�ɥi��^�_�O�H���N���A�Ӥ��O�}�s���N���C',
    21 => '���קK���ơA�o��N�����e�Х�Ū�O�H�Ҽg���C',
    22 => '�кɶq��²�䪺���D�C',
    23 => '�ڭ̤��|���}�A���q�l�a�}�C',
    24 => '�ΦW�Τ�'
);

###############################################################################
# users.php

$LANG04 = array(
    1 => '�Τᷧ�p',
    2 => '�Τ�W',
    3 => '���W',
    4 => '�K�X',
    5 => '�q�l�l��',
    6 => '����',
    7 => '�p��',
    8 => 'PGP �_��',
    9 => '�x�s��T',
    10 => '���Τ᪺�̫�Q�ӷN��',
    11 => '�S���N��',
    12 => '�Τ�]�w',
    13 => '�C�]�q�l��K',
    14 => '�o�O���H�����K�X�A�кɧ֧��C�n���K�X�Х��n�J�t�ΡA�M���I���b���T�C',
    15 => "�A�b {$_CONF['site_name']} ���b��w�إߤF�C�ШϥΥH�U��T�n�J�t�ΨëO�d�o�l��@���ѦҡC",
    16 => '�A���b���T',
    17 => '�b��ä��s�b',
    18 => '�A���Ѫ����O�@�Ӧ��Ī����q�l',
    19 => '�Τ�W�ιq�l�w�g�s�b',
    20 => '���Ѫ����O�@�Ӧ��Ī����q�l',
    21 => '���~',
    22 => "�n�O�� {$_CONF['site_name']} �I",
    23 => "�b {$_CONF['site_name']} �n�O���Τ�i�ɦ����|���n�B�C�L�̥i�H�Φۤv���W�r�o��N���M�s���������귽�C�Ъ`�N����<b><i>�����|</i></b>���}�Τ᪺�q�l�C",
    24 => '�A���K�X�N�Q�e��A��J���q�l�H�c',
    25 => '�ѰO�F�A���K�X�ܡH',
    26 => '�ЧA��J���Τ�W�M�I���q�l�K�X�A�ڭ̷|�o�e�@�ӷs���K�X��A���q�l�H�c�C',
    27 => '�{�b�N�n�O�I',
    28 => '�q�l�K�X',
    29 => 'logout at',
    30 => 'login at',
    31 => '�ݭn�n�J�~�i��',
    32 => '�p�W',
    33 => '�����|���}',
    34 => '�o�O�A���u�W',
    35 => '�n���ܽп�J�K�X',
    36 => '�}�l�O http://',
    37 => '�N�|���[�b�A�o���N���W',
    38 => '�A��²��',
    39 => '�A�����@ PGP �_��',
    40 => '�S���D�D�ϥ�',
    41 => '�@�N�D��',
    42 => '����榡',
    43 => '�G�ƭ���',
    44 => '�S���ե�',
    45 => '��ܳ]�w',
    46 => '���]�A��',
    47 => '�s�ե�t�m��',
    48 => '�D�D',
    49 => '�G�Ƹ̨S���Ϲ�',
    50 => '���n���_�p�G�A���P����',
    51 => '�u�O�s�G��',
    52 => '�w�]�ȬO',
    53 => '�C�߱�����骺�G��',
    54 => '���_�p�G�A���ݳo�ǥD�D�Χ@�̡C',
    55 => '�p�G�A�S����ܡA�o�N���A�n�ιw�]���ե�C�p�G�A��ܲե�A�Ҧ��w�]���c�N�Q�����C�w�]���F��|�βʵ��e��ܡC',
    56 => '�@��',
    57 => '��ܤ覡',
    58 => '�ƧǤ覡',
    59 => '�N������(��)',
    60 => '�i��ܧA���N���ܡH',
    61 => '�̷s�γ��ª����H',
    62 => '�w�]�O100',
    63 => '�K�X�w�Q�o�e�A�A�|�ܧ֦��쪺�C',
    64 => '�N���]�w',
    65 => '�й��զA�n�J',
    66 => "�A�i�ॴ���F�A�й��զA�n�J�C�A�O�_<a href=\"{$_CONF['site_url']}/users.php?mode=new\">�s�Τ�</a>�H",
    67 => '������',
    68 => '�O��ڬ�',
    69 => '�b�n�J�H��A�ڭ����ӰO��A�h�[�H',
    70 => "�w�� {$_CONF['site_name']} ���G���M���e",
    71 => "�@�� {$_CONF['site_name']} ���D�n�S�I�O�A�i�H�w���ۤv���G���M���e�A���O�A�����O�������|���C<a href=\"{$_CONF['site_url']}/users.php?mode=new\">�b���n�O</a>�C�p�G�A�w�g�O�n�O�A�ШϥΥ��䪺�ϰ�n�J�C",
    72 => '�D��',
    73 => '�y��',
    74 => '���ܥ����~��',
    75 => '�D�D�w�q�l��',
    76 => '�Хu��ܧA�P���쪺�D�D�A�]���Ҧ����s�i�K���G�ƱN�|�q�l��A���H�c�C',
    77 => '�ۤ�',
    78 => '�A�ۤv���Ϥ�',
    79 => '�n�R���Ϥ��A�b�o�̥��_',
    80 => '�n�J',
    81 => '�o�e�q�l�l��',
    82 => '�Τ�̪�o���Q�ӬG�Ƭ�',
    83 => '�Τ�o��έp',
    84 => '�峹�`�ơJ',
    85 => '�N���`�ơJ',
    86 => '�M��Ҧ��o��L���峹�J',
    87 => 'Your login name',
    88 => "Someone (possibly you) has requested a new password for your account \"%s\" on {$_CONF['site_name']}, <{$_CONF['site_url']}>.\n\nIf you really want this action to be taken, please click on the following link:\n\n",
    89 => 'If you do not want this action to be taken, simply ignore this message and the request will be disregarded (your password will remain unchanged).\n\n',
    90 => 'You can enter a new password for your account below. Please note that your old password is still valid until you submit this form.',
    91 => 'Set New Password',
    92 => 'Enter New Password',
    93 => 'Your last request for a new password was %d seconds ago. This site requires at least %d seconds between password requests.',
    94 => 'Delete Account "%s"',
    95 => 'Click the "delete account" button below to remove your account from our database. Please note that any stories and comments you posted under this account will <strong>not</strong> be deleted but show up as being posted by "Anonymous".',
    96 => 'delete account',
    97 => 'Confirm Account Deletion',
    98 => 'Are you sure you want to delete your account? By doing so, you will not be able to log into this site again (unless you create a new account). If you are sure, click "delete account" again on the form below.',
    99 => 'Privacy Options for',
    100 => 'Email from Admin',
    101 => 'Allow email from Site Admins',
    102 => 'Email from Users',
    103 => 'Allow email from other users',
    104 => 'Show Online Status',
    105 => 'Show up in Who\'s Online block'
);

###############################################################################
# index.php

$LANG05 = array(
    1 => '�S���s�D�i���',
    2 => '�S���s�G�ƥi��ܡC',
    3 => "�o�]�\�O�u���S���s�D�D�άO�A�� {$topic} �]�w�o�ӹL����ʡC",
    4 => '�����Y��',
    5 => '�U�@��',
    6 => '�e�@��'
);

###############################################################################
# links.php

$LANG06 = array(
    1 => '�U�����귽',
    2 => '�S���귽�i���',
    3 => '�[�@�s��'
);

###############################################################################
# pollbooth.php

$LANG07 = array(
    1 => '�벼�x�s�F',
    2 => '�A���벼�w�Q�x�s�F',
    3 => '�벼',
    4 => '�t�Τ����벼',
    5 => '�벼',
    6 => 'View other poll questions'
);

###############################################################################
# profiles.php

$LANG08 = array(
    1 => '�o�e�q�l�l��ɵo�Ϳ��~�C�ЦA���աC',
    2 => '�q�l�w�e�X�C',
    3 => '�нT�w�A�b�^�_�榳�@�ӥi�Ϊ��q�l�l��a�}�C',
    4 => '�ж�g�A���W�r�B�^�_��B�D�D�M���e',
    5 => '���~�G�S���o�Τ�C',
    6 => '�o�Ϳ��~�C',
    7 => '�Τ���',
    8 => '�Τ�W',
    9 => '�Τ�W�� URL',
    10 => '�o�e�l���',
    11 => '�A���W�r�G',
    12 => '�^�_��G',
    13 => '�D�D�G',
    14 => '���e�G',
    15 => 'HTML ���|�Q½Ķ�C',
    16 => '�o�e�l��',
    17 => '��G�ƹq�l���B��',
    18 => '����H�W�r',
    19 => '����H�q�l',
    20 => '�H��H�W�r',
    21 => '�H��H�q�l',
    22 => '�Ҧ��泣�n��g',
    23 => "�o�q�l�l��O�� {$from} ({$fromemail}) �H���A���A�L�{���A�]�\��o�g�b {$_CONF['site_url']} ���峹�P����C�o���O�U���l��(SPAM)�A�A���q�l�a�}�]���|�Q�����C",
    24 => '����o�ӬG�ƪ��N���b',
    25 => '�����U�ڭ̨���t�γQ�ݥΡA�A�����n�J�C',
    26 => '�o�Ӫ�椹�\�A�e�q�l�l���A��ܪ��Τᤤ�C�ж�g�Ҧ������C',
    27 => '�u�H',
    28 => "{$from} �g�D�G{$shortmsg}",
    29 => "�Ӧ۩� {$_CONF['site_name']} ���C���K�A�����G",
    30 => ' �C�骺�ɨƳq�T�A�����G',
    31 => '���D',
    32 => '���',
    33 => '���㪺�峹�b�G',
    34 => '�q�l����',
    35 => 'Sorry, this user prefers not to receive any emails.'
);

###############################################################################
# search.php

$LANG09 = array(
    1 => '�i���j�M',
    2 => '�����',
    3 => '�D�D',
    4 => '�Ҧ�',
    5 => '����',
    6 => '�G��',
    7 => '�N��',
    8 => '�@��',
    9 => '�Ҧ�',
    10 => '�j�M',
    11 => '�j�M���G',
    12 => '�۰t',
    13 => '�j�M���G�G�S���۰t��',
    14 => '�S���A�M�䪺�F��J',
    15 => '�ЦA����',
    16 => '�D�D',
    17 => '���',
    18 => '�@��',
    19 => "�j�M��� {$_CONF['site_name']} ���s�¬G�Ƹ�Ʈw",
    20 => '���',
    21 => '��',
    22 => '(����榡 YYYY-MM-DD)',
    23 => '���˼�',
    24 => '���',
    25 => '�Ӭ۰t�b',
    26 => '�Ӷ��ؤ��A�@�ΤF',
    27 => '��',
    28 => '�S���A�ҴM�䪺�G�ƩηN��',
    29 => '�G�ƩM�N�������G',
    30 => '�S���A�ҴM�䪺�s��',
    31 => '�S���A�ҴM�䪺 plug-in',
    32 => '�ƥ�',
    33 => 'URL',
    34 => '�a�I',
    35 => '�Ҧ���l',
    36 => '�S���A�ҴM�䪺�ƥ�',
    37 => '�ƥ󪺵��G',
    38 => '�s�������G',
    39 => '�s��',
    40 => '�ƥ�',
    41 => '�j�M��������̤֭n���T�Ӧr�C',
    42 => '�Шϥ� YYYY-MM-DD (�~-��-��) ����榡�C',
    43 => 'exact phrase',
    44 => 'all of these words',
    45 => 'any of these words',
    46 => 'Next',
    47 => 'Previous',
    48 => 'Author',
    49 => 'Date',
    50 => 'Hits',
    51 => 'Link',
    52 => 'Location',
    53 => 'Story Results',
    54 => 'Comment Results',
    55 => 'the phrase',
    56 => 'AND',
    57 => 'OR'
);

###############################################################################
# stats.php

$LANG10 = array(
    1 => '�����έp�ƾ�',
    2 => '�t���I���`��',
    3 => '�G��(�N��)�`��',
    4 => '�벼(��o�벼)�`��',
    5 => '�s��(�I��)�`��',
    6 => '�ƥ��`��',
    7 => '�̦h�[�ݪ��Q�ӬG��',
    8 => '�G�Ƽ��D',
    9 => '�[��',
    10 => '�ݨӥ����S���G�ƩάO�S�H�[�ݹL�������G�ơC',
    11 => '�̦h�N�����Q�ӬG��',
    12 => '�N��',
    13 => '�ݨӥ����S���G�ƩάO�S�H�N���L�������G�ơC',
    14 => '�̦h�H�벼���Q�ӿ��|',
    15 => '�벼���D',
    16 => '�벼',
    17 => '�ݨӥ����S���벼�άO�S�H��L���C',
    18 => '�̦h�H�I�����Q�ӳs��',
    19 => '�s��',
    20 => '�I��',
    21 => '�ݨӥ����S���s���άO�S�H�I���L�������s���C',
    22 => '�̦h�H�H�X���Q�ӬG��',
    23 => '�q�l',
    24 => '�ݨӨS�H�H�X�L�������G��'
);

###############################################################################
# article.php

$LANG11 = array(
    1 => '������O������',
    2 => '�H�G�Ƶ��B��',
    3 => '�i�L���G�Ʈ榡',
    4 => '�G�ƿﶵ'
);

###############################################################################
# submit.php

$LANG12 = array(
    1 => "�A�ݭn�n�J�~�i�o�� {$type} ",
    2 => '�n�J',
    3 => '�s�Τ�',
    4 => '�o��@���',
    5 => '�o��@�ӳs��',
    6 => '�o��@�ӬG��',
    7 => '�A�ݭn�n�J',
    8 => '�o��',
    9 => '�b�����o��F��ɽи��H�H�U��ĳ...<ul><li>��g�Ҧ�����<li>���ѧ����M�ǽT����T<li>�A�T�ˬd���� URLs</ul>',
    10 => '���D',
    11 => '�s��',
    12 => '�}�l���',
    13 => '�������',
    14 => '�a�I',
    15 => '�y�z',
    16 => '�p�G�O��L�A�Ы��w',
    17 => '���O',
    18 => '��L',
    19 => 'Ū�o��',
    20 => '���~�G�ʤ����O',
    21 => '����"��L"�д��Ѥ@�����O�W',
    22 => '���~�G�ʤ����',
    23 => '�ж�g�Ҧ������',
    24 => '�A�o���w�Q�x�s�F',
    25 => "�A�� {$type} �w�Q�x�s�F",
    26 => '���t',
    27 => '�Τ�W',
    28 => '�D�D',
    29 => '�G��',
    30 => '�A�̫�o���O',
    31 => " ���e�C�������w�ܤ� {$_CONF['speedlimit']} ���~�i�A�o��",
    32 => '�w��',
    33 => '�G�� �w��',
    34 => '�n�X',
    35 => '����\ HTML �аO',
    36 => '�o��Ҧ�',
    37 => "�[�ƥ�� {$_CONF['site_name']} �|�N�A���ƥ�[��D��䤤�A��L���Τ�i�H�N�a�⥦�[�i�ۤv���ӤH���C��<b>���n</b>��A���ӤH�ƥ�Ĵ�p�ͤ�M�g�~�����[�i�h�C<br><br>�u�n�޲z�����A���ƥ󥦱N�X�{�b�D���W�C",
    38 => '�[�ƥ��',
    39 => '�D���',
    40 => '�ӤH���',
    41 => '�����ɶ�',
    42 => '�}�l�ɶ�',
    43 => '��骺�ƥ�',
    44 => '�a�} 1',
    45 => '�a�} 2',
    46 => '����/����',
    47 => '�{',
    48 => '�l�F�s�X',
    49 => '�ƥ�����',
    50 => '�s��ƥ�����',
    51 => '�a�I',
    52 => '�R��',
    53 => '�s�[�b��'
);

###############################################################################
# ADMIN PHRASES - These are file phrases used in admin scripts
###############################################################################

###############################################################################
# admin/auth.inc.php

$LANG20 = array(
    1 => '�n�D�{��',
    2 => '�ڵ��I�����T���n�J���',
    3 => '�L�Ī��K�X',
    4 => '�Τ�W�G',
    5 => '�K�X�G',
    6 => '�o���u�ѱ��v�H���ϥΡC<br>�Ҧ��s���N�Q�O���M�ˬd�C',
    7 => '�n�J'
);

###############################################################################
# admin/block.php

$LANG21 = array(
    1 => '�v�O����',
    2 => '�A�S���v�h�s��o�Ӳե�C',
    3 => '�ե�s�边',
    4 => 'There was a problem reading this feed (see error.log for details).',
    5 => '�ե���D',
    6 => '�D�D',
    7 => '�Ҧ�',
    8 => '�ե�w������',
    9 => '�ե󦸧�',
    10 => '�ե�����',
    11 => '�J�f�ե�',
    12 => '���`�ե�',
    13 => '�J�f�ե�ﶵ',
    14 => 'RDF URL',
    15 => '�̫᪺ RDF ��s',
    16 => '���`�ե�ﶵ',
    17 => '�ե󤺮e',
    18 => '�ж�g�ե󪺼��D�B�w�������M���e�C',
    19 => '�ե�޲z��',
    20 => '�ե���D',
    21 => '�ե�w������',
    22 => '�ե�����',
    23 => '�ե󦸧�',
    24 => '�ե�D�D',
    25 => '�I���U�����ե�i�ק�ΧR�����A�I���W�����s�ե�i�гy�@�ӷs���C',
    26 => '�����ե�',
    27 => 'PHP �ե�',
    28 => 'PHP �ե�ﶵ',
    29 => '�ե���',
    30 => '�p�G�A�Q�Φۤv�� PHP ��Ʋե�A�Цb�W����J��ƪ��W�r�C�����������ʪ��s�X�APHP �ե��ƦW�����H "phpblock_" �@�}�l (e.g. phpblock_getweather)�C�Ф��n��Ū���A�� "()" ��b��ƫ�C�̫�A��ĳ�A��Ҧ��� PHP �ե��b /path/to/geeklog/system/lib-custom.php �̥H��K�t�ΤɯšC',
    31 => 'PHP �ե���~�J���  �ä��s�b�C',
    32 => '���~�J�ʤ����C',
    33 => '�b�J�f�ե�A������ URL ��J�� .rdf �ɮ�',
    34 => '�b PHP �ե�A������J�D�D�M���',
    35 => '�b���`�ե�A������J�D�D�M���e',
    36 => '�b�����ե�A������J���e',
    37 => '���A�� PHP �ե��ƦW',
    38 => '�����������ʪ��s�X�APHP �ե��ƦW�����H "phpblock_" �@�}�l (e.g. phpblock_getweather)�C',
    39 => '��b����',
    40 => '��',
    41 => '�k',
    42 => '�b Geeklog �w�]�ե�A������J�ե󦸧ǩM�w������',
    43 => '�u�i�O����',
    44 => '�s���Q�ڵ�',
    45 => "���Ϧs�������\���ե�w�Q�O���C��<a href=\"{$_CONF['site_admin_url']}/block.php\">�Ϧ^�ե�޲z���ޭ�</a>�C",
    46 => '�s�ե�',
    47 => '�޲z������',
    48 => '�ե�W',
    49 => ' (���i���Źj�M�����O�ߤ@��)',
    50 => '�D�U��� URL',
    51 => '�]�A http://',
    52 => '�p�G�o�̯d�աA�ե󪺨D�U���ϥܱN���Q���',
    53 => '�Ϧ���',
    54 => '�x�s',
    55 => '����',
    56 => '�R��',
    57 => 'Move Block Down',
    58 => 'Move Block Up',
    59 => 'Move block to the right side',
    60 => 'Move block to the left side'
);

###############################################################################
# admin/event.php

$LANG22 = array(
    1 => '�ƥ�s�边',
    2 => '',
    3 => '�ƥ���D',
    4 => '�ƥ� URL',
    5 => '�ƥ�}�l���',
    6 => '�ƥ󵲧����',
    7 => '�ƥ�a�I',
    8 => '�ƥ�y�z',
    9 => '(�]�A http://)',
    10 => '�A�������Ѥ���ήɶ��B�y�z�M�ƥ�a�I�I',
    11 => '�ƥ�޲z��',
    12 => '�I���U�����ƥ�i�ק�ΧR�����A�I���W�����s�ƥ�i�гy�@�ӷs���C',
    13 => '�ƥ���D',
    14 => '�}�l���',
    15 => '�������',
    16 => '�s���Q�ڵ�',
    17 => "���Ϧs�������\���ƥ�w�Q�O���C��<a href=\"{$_CONF['site_admin_url']}/event.php\">�Ϧ^�ƥ�޲z���ޭ�</a>�C",
    18 => '�s�ƥ�',
    19 => '�޲z������',
    20 => '�x�s',
    21 => '����',
    22 => '�R��'
);

###############################################################################
# admin/link.php

$LANG23 = array(
    1 => '�s���s�边',
    2 => '',
    3 => '�s�����D',
    4 => '�s�� URL',
    5 => '���O',
    6 => '(�]�A http://)',
    7 => '��L',
    8 => '�s���Q������',
    9 => '�s���y�z',
    10 => '�A�ݭn���ѳs�����D�B URL �M�y�z�I',
    11 => '�s���޲z��',
    12 => '�I���U�����s���i�ק�ΧR�����A�I���W�����s�s���i�гy�@�ӷs���C',
    13 => '�s�����D',
    14 => '�s�����O',
    15 => '�s�� URL',
    16 => '�s���Q�ڵ�',
    17 => "���Ϧs�������\���s���w�Q�O���C��<a href=\"{$_CONF['site_admin_url']}/link.php\">�Ϧ^�s���޲z���ޭ�</a>�C",
    18 => '�s�s��',
    19 => '�޲z������',
    20 => '�p�G�O��L�A�Ы��w',
    21 => '�x�s',
    22 => '����',
    23 => '�R��'
);

###############################################################################
# admin/story.php

$LANG24 = array(
    1 => '�W�@�ӬG��',
    2 => '�U�@�ӬG��',
    3 => '�Ҧ�',
    4 => '�o��Ҧ�',
    5 => '�G�ƽs�边',
    6 => '�S���G��',
    7 => '�@��',
    8 => '�x�s',
    9 => '�w��',
    10 => '����',
    11 => '�R��',
    12 => '',
    13 => '���D',
    14 => '�D�D',
    15 => '���',
    16 => '�G��²��',
    17 => '�G�Ƥ��e',
    18 => '�I������',
    19 => '�N��',
    20 => '',
    21 => '',
    22 => '�G�ƲM��',
    23 => '�I���U�����G�ƽs���i�ק�ΧR�����A�I���U�����G�Ƽ��D�i�[�ݥ��A�I���W�����s�G�ƥi�гy�@�ӷs���C',
    24 => '',
    25 => '',
    26 => '�G�ƹw��',
    27 => '',
    28 => '',
    29 => '',
    30 => 'File Upload Errors',
    31 => '�A�ݭn���ѧ@�̡B���D�M�G��²���I',
    32 => '�Y����',
    33 => '�u�i���@���Y���G��',
    34 => '��Z',
    35 => '�O',
    36 => '�_',
    37 => '��h�Ӧ۩�',
    38 => '��h�o���',
    39 => '�q�l',
    40 => '�s���Q�ڵ�',
    41 => "���Ϧs�������\���G�Ƥw�Q�O���C�A�i�H�H��Ū�Ҧ��[�ݤU���峹�C�ݧ����<a href=\"{$_CONF['site_admin_url']}/story.php\">�Ϧ^�G�ƺ޲z���ޭ�</a>�C",
    42 => "���Ϧs�������\���G�Ƥw�Q�O���C��<a href=\"{$_CONF['site_admin_url']}/story.php\">�Ϧ^�G�ƺ޲z���ޭ�</a>�C",
    43 => '�s�G��',
    44 => '�޲z������',
    45 => '�s���v',
    46 => '<b>�`�N�J</b>�p�G�A�����令�N�ӡA�b���Ӥ���e�o�g�峹�N���|�Q�o��C�åB �N���۳o�g�G�Ƥ��|�]�A�b�A�� RDF ���D���A�b�j�M�M�έp�����|�Q�����C',
    47 => '�Ϲ�',
    48 => 'image',
    49 => 'right',
    50 => 'left',
    51 => '�ХίS�O�榡����r([imageX]�B[imageX_right] �� [imageX_left])�Ӵ��J�Ϲ��A X �O�A���[�Ϲ����s���C�`�N�J�A�u�i�ϥΧA���[���Ϲ��_�h�A�N�L�k�x�s�A���G�ơC<BR><P><B>�w��</B>�J�̨ιw���G�ƪ���k�O��G���x�s����Z�Ӥ��O�����w�����s�C�u���S�����[�Ϲ��ɤ~�ιw�����s�C',
    52 => '�R��',
    53 => '�S���Q�ϥΡC�x�s�e�A�A������o�ӹϹ��]�t�b�G��²���άG�Ƥ��e���C',
    54 => '���[�Ϲ����Q�ϥ�',
    55 => '�x�s�A���G�Ʈɵo�ͥH�U���~�C�Ч勵�o�ǿ��~�A�x�s',
    56 => '��ܥD�D�ϥ�',
    57 => 'View unscaled image'
);

###############################################################################
# admin/poll.php

$LANG25 = array(
    1 => '�Ҧ�',
    2 => 'Please enter a question and at least one answer.',
    3 => '�벼�o�_��',
    4 => "�벼 {$qid} �Q�x�s�F",
    5 => '�s��벼',
    6 => '�벼�s��',
    7 => '(���i���Źj)',
    8 => '�X�{�b�����W',
    9 => '���D',
    10 => '���� / �벼',
    11 => "���o�벼 ({$qid}) ���׮ɵo�Ϳ��~�C",
    12 => "���o�벼 ({$qid}) ���D�ɵo�Ϳ��~�C",
    13 => '�s�[�벼',
    14 => '�x�s',
    15 => '����',
    16 => '�R��',
    17 => 'Please enter a Poll ID',
    18 => '�벼�M��',
    19 => '�I���U�����벼�i�ק�ΧR�����A�I���W�����s�벼�i�гy�@�ӷs���C',
    20 => '�벼��',
    21 => '�s���Q�ڵ�',
    22 => "���Ϧs�������\���벼�w�Q�O���C��<a href=\"{$_CONF['site_admin_url']}/poll.php\">�Ϧ^�벼�޲z���ޭ�</a>�C",
    23 => '�s�벼',
    24 => '�޲z������',
    25 => '�O',
    26 => '�_'
);

###############################################################################
# admin/topic.php

$LANG27 = array(
    1 => '�D�D�s�边',
    2 => '�D�D�s��',
    3 => '�D�D�W',
    4 => '�D�D�Ϲ�',
    5 => '(���i���Źj)',
    6 => '�R���D�D�|�P�ɧR���Ҧ��������G�ƩM�ե�I',
    7 => '�A�ݭn���ѥD�D�s���M�D�D�W�I',
    8 => '�D�D�޲z��',
    9 => '�I���U�����D�D�i�ק�ΧR�����A�I���W�����s�D�D�i�гy�@�ӷs���C�b�A���̧A�N�o�{�A���s���ŧO�C',
    10 => '�ƧǦ���',
    11 => '�G�� / ��',
    12 => '�s���Q�ڵ�',
    13 => "���Ϧs�������\���D�D�w�Q�O���C��<a href=\"{$_CONF['site_admin_url']}/topic.php\">�Ϧ^�D�D�޲z���ޭ�</a>.",
    14 => '�ƧǤ�k',
    15 => '���r���Ƨ�',
    16 => '�w�]�O',
    17 => '�s�D�D',
    18 => '�޲z������',
    19 => '�x�s',
    20 => '����',
    21 => '�R��',
    22 => 'Default',
    23 => 'make this the default topic for new story submissions',
    24 => '(*)'
);

###############################################################################
# admin/user.php

$LANG28 = array(
    1 => '�Τ�s�边',
    2 => '�Τ�s��',
    3 => '�Τ�W',
    4 => '���W',
    5 => '�K�X',
    6 => '�w���ŧO',
    7 => '�q�l�a�}',
    8 => '����',
    9 => '(���i���Źj)',
    10 => '�A�ݭn���ѥΤ�W�B���W�B�w���ŧO�M�q�l�a�}�C',
    11 => '�Τ�޲z��',
    12 => '�I���U�����Τ�i�ק�ΧR�����A�I���W�����s�Τ�i�гy�@�ӷs���C�b�U������椤��J�������Τ�W�B�q�l�a�}�Υ��W (e.g.*son* or *.edu) �A�i��²�檺�M��C',
    13 => '�w���ŧO',
    14 => '�n�O��',
    15 => '�s�Τ�',
    16 => '�޲z������',
    17 => '��K�X',
    18 => '����',
    19 => '�R��',
    20 => '�x�s',
    21 => '�Τ�W�w�g�s�b',
    22 => '���~',
    23 => '�j�q�W�[',
    24 => '�j�q��J�Τ�',
    25 => '�A�i�@���L��J�j�q���Τ�� Geeklog �C��J�ɮץ����O�@�ӥ� tab ���j����r�ɮסA��쪺���ǬO�J���W�B�Τ�W�B�q�l�a�}�C�C�@�ӳQ��J���Τ�N�|����@�ӥH�q�l�l��o�e���H���K�X�C�ɮפ��C�@��O�@�ӥΤ�C�S��u�o�ǭn�D�N�y�����D�A�]�\�ݭn��ʧ@�~�A�ЦA�T�ˬd�A�ɮסI',
    26 => '�M��',
    27 => '���G�d��',
    28 => '�b�o�̥��_�i�R���o�i�Ϥ�',
    29 => '���|',
    30 => '��J',
    31 => '�s�Τ�',
    32 => "�B�z�����C��J�F {$successes} �ӡF{$failures} �ӥ���",
    33 => '����',
    34 => '���~�J�A�������w�W���ɮסC',
    35 => 'Last Login',
    36 => '(never)'
);

###############################################################################
# admin/moderation.php

$LANG29 = array(
    1 => '���',
    2 => '�R��',
    3 => '�s��',
    4 => '²�n�y�z',
    10 => '���D',
    11 => '�}�l���',
    12 => 'URL',
    13 => '���O',
    14 => '���',
    15 => '�D�D',
    16 => '�Τ�W',
    17 => '���W',
    18 => '�q�l�l��',
    34 => '�R�O�M����',
    35 => '�w���檺�G��',
    36 => '�w���檺�s��',
    37 => '�w���檺�ƥ�',
    38 => '����',
    39 => '���ɨS�����檺�F��',
    40 => '�ӽЪ��Τ�'
);

###############################################################################
# calendar.php

$LANG30 = array(
    1 => '��',
    2 => '�@',
    3 => '�G',
    4 => '�T',
    5 => '�|',
    6 => '��',
    7 => '��',
    8 => '�s�W�ƥ�',
    9 => 'Geeklog �ƥ�',
    10 => '�ƥ�',
    11 => '�D���',
    12 => '�ڪ����',
    13 => '�@��',
    14 => '�G��',
    15 => '�T��',
    16 => '�|��',
    17 => '����',
    18 => '����',
    19 => '�C��',
    20 => '�K��',
    21 => '�E��',
    22 => '�Q��',
    23 => '�Q�@��',
    24 => '�Q�G��',
    25 => '�^��',
    26 => '���',
    27 => '�P��',
    28 => '�ӤH���J',
    29 => '�������',
    30 => '�R���ƥ�',
    31 => '�s�W',
    32 => '�ƥ�',
    33 => '�P��',
    34 => '�ɶ�',
    35 => '���t�W�[',
    36 => '����',
    37 => '��p�A�����ä����ѭӤH���C',
    38 => '�ӤH�ƥ�s�边',
    39 => '��',
    40 => '�P',
    41 => '��'
);

###############################################################################
# admin/mail.php

$LANG31 = array(
    1 => "{$_CONF['site_name']} �l��{��",
    2 => '�H��H',
    3 => '�^�_��',
    4 => '�D�D',
    5 => '���e',
    6 => '����H�J',
    7 => '�Ҧ��Τ�',
    8 => '�޲z��',
    9 => '�ﶵ',
    10 => 'HTML',
    11 => '�������T���I',
    12 => '�o�e',
    13 => '���]',
    14 => '�����Τ�]�w',
    15 => '���~�A��o�e��J',
    16 => '�T���w�o�e��J',
    17 => "<a href={$_CONF['site_admin_url']}/mail.php>�o�e�䥦�H��</a>",
    18 => '����H',
    19 => '�`�N�J�p�G�A�Ʊ�o�e�T���쥻���Ҧ��������A�Цb�p�տ����줤��� Logged-in Users group�C',
    20 => "�w�o�e <successcount> �ӰT���A�� <failcount> �Ӥ���o�e�C�o�e���Ӹ`�b�U���C�p���Q�ݲӸ`�A�A�i<a href=\"{$_CONF['site_admin_url']}/mail.php\">�o�e�䥦�T��</a> �� <a href=\"{$_CONF['site_admin_url']}/moderation.php\">�Ϧ^�޲z������</a>�C",
    21 => '����',
    22 => '���\\ ',
    23 => '�������\\ ',
    24 => '��������',
    25 => '-- �п�p�� --',
    26 => '�ж�g�Ҧ����W�����M��ܤ@�Ӥp�աC'
);

###############################################################################
# admin/plugins.php

$LANG32 = array(
    1 => 'Installing plugins could possibly cause damage to your Geeklog installation and, possibly, to your system. It is important that you only install plugins downloaded from the <a href="http://www.geeklog.net" target="_blank">Geeklog Homepage</a> as we thoroughly test all plugins submitted to our site on a variety of operating systems. It is important that you understand that the plugin installation process will require the execution of a few filesystem commands which could lead to security problems particularly if you use plugins from third party sites. Even with this warning you are getting, we do not gaurantee the success of any installation nor are we liable for damage caused by installing a Geeklog plugin. In other words, install at your own risk.  For the wary, directions on how to manually install a plugin is included with each plugin package.',
    2 => 'Plug-in �w���n��',
    3 => 'Plug-in �w�˪��',
    4 => 'Plug-in �ɮ�',
    5 => 'Plug-in �M��',
    6 => 'ĵ�i�JPlug-in �w�g�Q�w�˹L�I',
    7 => '�A�Q�w�˪� plug-in �w�g�s�b�A�Х��⥦�R���A�w�ˡC',
    8 => 'Plugin ����q�L�ݮe�ʮ���C',
    9 => '�o plugin �n�D�@�ӧ�s������ Geeklog. �A�i�H�ɯŧA��<a href="http://www.geeklog.net">Geeklog</a>�άO�t��@�ӾA�X�������C',
    10 => '<br><b>�S���w�˪� plugin �C</b><br><br>',
    11 => '�I���U�� plugin ���s���i�ק�ΧR�����A�I�� plugin ���W�r�|�a�A�쨺 plugin �������C�n�w�˩Τɯ� plugin �Ыt�ߥ��O���C',
    12 => 'plugineditor() �䤣�� plugin �W',
    13 => 'Plugin �s�边',
    14 => '�s Plug-in',
    15 => '�޲z������',
    16 => 'Plug-in �W�r',
    17 => 'Plug-in ����',
    18 => 'Geeklog ����',
    19 => '�Ϧ���',
    20 => '�O',
    21 => '�_',
    22 => '�w��',
    23 => '�x�s',
    24 => '����',
    25 => '�R��',
    26 => 'Plug-in �W�r',
    27 => 'Plug-in ����',
    28 => 'Plug-in ����',
    29 => 'Geeklog ����',
    30 => '�R�� Plug-in�H',
    31 => '�A�֩w�n�R���o�� Plug-in �ܡH�o��|�R���Ҧ������o Plug-in �����B��ƩM��Ƶ��c�C�p�G�A�֩w���A�ЦA�I���U����椤���R���s�C'
);

###############################################################################
# admin/syndication.php

$LANG33 = array(
    1 => 'create feed',
    2 => 'save',
    3 => 'delete',
    4 => 'cancel',
    10 => 'Content Syndication',
    11 => 'New Feed',
    12 => 'Admin Home',
    13 => 'To modify or delete a feed, click on the feed\'s title below. To create a new feed, click on New Feed above.',
    14 => 'Title',
    15 => 'Type',
    16 => 'Filename',
    17 => 'Format',
    18 => 'last updated',
    19 => 'Enabled',
    20 => 'Yes',
    21 => 'No',
    22 => '<i>(no feeds)</i>',
    23 => 'all Stories',
    24 => 'Feed Editor',
    25 => 'Feed Title',
    26 => 'Limit',
    27 => 'Length of entries',
    28 => '(0 = no text, 1 = full text, other = limit to that number of chars.)',
    29 => 'Description',
    30 => 'Last Update',
    31 => 'Character Set',
    32 => 'Language',
    33 => 'Contents',
    34 => 'Entries',
    35 => 'Hours',
    36 => 'Select type of feed',
    37 => 'You have at least one plugin installed that supports content syndication. Below you will need to select whether you want to create a Geeklog feed or a feed from one of the plugins.',
    38 => 'Error: Missing Fields',
    39 => 'Please fill in the Feed Title, Description, and Filename.',
    40 => 'Please enter a  number of entries or number of hours.',
    41 => 'Links',
    42 => 'Events'
);

###############################################################################
# confirmation and error messages

$MESSAGE = array(
    1 => "�ڭ̤w�q�l�F�A���K�X��A���q�l�H�c�A�и��H�l�󤤪����ܡC�h�¨ϥ� {$_CONF['site_name']}",
    2 => "�h�»���A���G�ƨ� {$_CONF['site_name']} �C�u�n�g�L�ڭ̭��u���ֹ�A�A���G�ƱN�X�{�b�ڭ̪������W�C",
    3 => "�h�»���s���� {$_CONF['site_name']} �C�u�n�g�L�ڭ̭��u���ֹ�A�A���s���N�X�{�b�ڭ̪������W�C",
    4 => "�h�»���ƥ�� {$_CONF['site_name']} �C�u�n�g�L�ڭ̭��u���ֹ�A�A���ƥ�N�X�{�b�ڭ̪�<a href={$_CONF['site_url']}/calendar.php>���</a>�W�C",
    5 => '�A���b���T�w�Q�x�s�F�C',
    6 => '�A���e���]�w�w�Q�x�s�F�C',
    7 => '�A���N���]�w�w�Q�x�s�F�C',
    8 => '�A�w�n�X�C',
    9 => '�A���G�Ƥw�Q�x�s�F�C',
    10 => '�A���G�Ƥw�Q�R���F�C',
    11 => '�A���ե�w�Q�x�s�F�C',
    12 => '�A���ե�w�Q�R���F�C',
    13 => '�A���D�D�w�Q�x�s�F�C',
    14 => '�A���D�D�M�Ҧ��������G�Ƥw�Q�R���F�C',
    15 => '�A���s���w�Q�x�s�F�C',
    16 => '�A���s���w�Q�R���F�C',
    17 => '�A���ƥ�w�Q�x�s�F�C',
    18 => '�A���ƥ�w�Q�R���F�C',
    19 => '�A���벼�w�Q�x�s�F�C',
    20 => '�A���벼�w�Q�R���F�C',
    21 => '�s�Τ�w�Q�x�s�F�C',
    22 => '�Τ�w�Q�R���F�C',
    23 => '�W�[�ƥ��A�����ɵo�Ϳ��~�A�ʤ֤F�ƥ�s���C',
    24 => '�ƥ�w�W�[��A����䤤�C',
    25 => '�A�n�n�J�~�i�}�ҧA���ӤH���C',
    26 => '�ƥ�w�q�A����䤤�����C',
    27 => '�H���w�o�e�C',
    28 => 'Plug-in �w�Q�x�s�F�C',
    29 => '��p�A�����ä����ѭӤH���C',
    30 => '�s���Q�ڵ�',
    31 => '��p�A�A����i�J�G�ƺ޲z�������C�Ъ`�N�A�����Ϥw�Q�O���C',
    32 => '��p�A�A����i�J�D�D�޲z�������C�Ъ`�N�A�����Ϥw�Q�O���C',
    33 => '��p�A�A����i�J�ե�޲z�������C�Ъ`�N�A�����Ϥw�Q�O���C',
    34 => '��p�A�A����i�J�s���޲z�������C�Ъ`�N�A�����Ϥw�Q�O���C',
    35 => '��p�A�A����i�J�ƥ�޲z�������C�Ъ`�N�A�����Ϥw�Q�O���C',
    36 => '��p�A�A����i�J�벼�޲z�������C�Ъ`�N�A�����Ϥw�Q�O���C',
    37 => '��p�A�A����i�J�Τ�޲z�������C�Ъ`�N�A�����Ϥw�Q�O���C',
    38 => '��p�A�A����i�J Plug-in �޲z�������C�Ъ`�N�A�����Ϥw�Q�O���C',
    39 => '��p�A�A����i�J�q�l�޲z�������C�Ъ`�N�A�����Ϥw�Q�O���C',
    40 => '�t�ΰT��',
    41 => '��p�A�A����i�J�r�������������C�Ъ`�N�A�����Ϥw�Q�O���C',
    42 => '�A���r���w�Q�x�s�F�C',
    43 => '�A���r���w�Q�R���F�C',
    44 => 'Plug-in �w�Q�w�ˤF�C',
    45 => 'Plug-in �w�Q�R���F�C',
    46 => '��p�A�A����i�J��Ʈw�ƥ��{���C�Ъ`�N�A�����Ϥw�Q�O���C',
    47 => '�o�u�A�Ω� *nix �p�G�A���@�~�t�άO *nix�A����A���w�R���w�Q�M���F�C�p�G�A���@�~�t�άO Windows�A�A�n��ʴM����R�W�� adodb _ *.php ���ɮרç⥦�̰��h�C',
    48 => "�P�§A�ӽЦ��� {$_CONF['site_name']} ���|���C�u�n�g�L�ڭ̭��u���ֹ�A�ڭ̷|��K�X�H��A�ҵn�O���q�l���C",
    49 => '�A���p�դw�Q�x�s�F�C',
    50 => '�p�դw�Q�R���F�C',
    51 => 'This username is already in use. Please choose another one.',
    52 => 'The email address provided does not appear to be a valid email address.',
    53 => 'Your new password has been accepted. Please use your new password below to log in now.',
    54 => 'Your request for a new password has expired. Please try again below.',
    55 => 'An email has been sent to you and should arrive momentarily. Please follow the directions in the message to set a new password for your account.',
    56 => 'The email address provided is already in use for another account.',
    57 => 'Your account has been successfully deleted.',
    58 => 'Your feed has been successfully saved.',
    59 => 'The feed has been successfully deleted.'
);

###############################################################################

$LANG_ACCESS = array(
    'access' => '�s��',
    'ownerroot' => '�Ҧ���/Root',
    'group' => '�p��',
    'readonly' => '��Ū',
    'accessrights' => '�s���v',
    'owner' => '�Ҧ���',
    'grantgrouplabel' => '�������W�p�սs���v�Q',
    'permmsg' => '�`�N�J�|���O���Ҧ����U�M�n�J���Τ�F�ӰΦW�O���Ҧ��D���U���s���̩ΨS���n�J���Τ�C',
    'securitygroups' => '�w���p��',
    'editrootmsg' => "�Y�ϧA�O�Τ�޲z���F���A����s�� root �Τ�C�A��s��Ҧ����Τᰣ�F root �Τ�C�Ъ`�N�Ҧ����ϫD�k�a�s�� root �Τ᪺�ʧ@�w�Q�O���C�Ц^��<a href=\"{$_CONF['site_admin_url']}/user.php\">�Τ�޲z��</a>�h�C",
    'securitygroupsmsg' => '��ܳo��Τ��ݩ󪺤p�աC',
    'groupeditor' => '�p�սs�边',
    'description' => '�y�z',
    'name' => '�W�r',
    'rights' => '�v��',
    'missingfields' => '�ʤ����',
    'missingfieldsmsg' => '�A�������Ѥp�ժ��W�r�M�y�z',
    'groupmanager' => '�p�պ޲z��',
    'newgroupmsg' => '�I���U�����p�եi�ק�ΧR�����A�I���W�����s�p�եi�гy�@�ӷs���C�Ъ`�N�Ү֤ߤp�դ���Q�R���C',
    'groupname' => '�զW',
    'coregroup' => '�֤ߤp��',
    'yes' => '�O',
    'no' => '�_',
    'corerightsdescr' => "�o�Ӥp�ժ��v������Q�s��A�]���o�O�� {$_CONF['site_name']} ���֤ߤp�աC�H�U�O�o�p�ժ��v���M��(��Ū��)�C",
    'groupmsg' => '�w���p�զb�o�����O�����Ũ�ת��C��W�[�o�Ӥp�ը�t�@�էO�A�o�Ӥp�ձN�o�쨺�էO���v���C�о��i��p�ե[�U�C���էO�h�C�p�G�o�p�ջݭn�S�O���v���A�A�i�H�b�H�U��"�v�Q"�ϰ줤�D��C�n��p�ե[��էO�h�A�A�u�ݭn�b�էO���䪺�D�ﲰ���_�C',
    'coregroupmsg' => "�]���o�O�� {$_CONF['site_name']} ���֤ߤp�աA�o�Ӥp�ժ��v������Q�s��C�H�U�O�o�p�ժ��էO�M��(��Ū��)�C",
    'rightsdescr' => '�p�ժ��v���i�H�O�Ӧ۩�p�ե����άO�o�p�թ��ݪ��էO�C�H�U���v�����p�S�����粰�Y�N��o�v���O�Ӧ۩�p�թ��ݪ��էO�F�p�����粰�Y�N��A�i�H�������v�������o�p�աC',
    'lock' => '���',
    'members' => '����',
    'anonymous' => '�ΦW',
    'permissions' => '�v��',
    'permissionskey' => 'R = ��Ū�A E = �s��A���s���v�Y����Ū�v',
    'edit' => '�s��',
    'none' => '�S��',
    'accessdenied' => '�s���Q�ڵ�',
    'storydenialmsg' => "�]���Q���A�A���i�H�[�ݳo�ӬG�ơC�o�O�i��O�]���A�ä��O {$_CONF['site_name']} ���|���C��<a href=users.php?mode=new>�����|��</a>�C",
    'eventdenialmsg' => "�]���Q���A�A���i�H�[�ݳo�Өƥ�C�o�O�i��O�]���A�ä��O {$_CONF['site_name']} ���|���C��<a href=users.php?mode=new>�����|��</a>�C",
    'nogroupsforcoregroup' => '�o�p�դ��ݩ����䥦���p��',
    'grouphasnorights' => ' �o�p�ըS���޲z�v�C',
    'newgroup' => '�s�p��',
    'adminhome' => '�޲z������',
    'save' => '�x�s',
    'cancel' => '����',
    'delete' => '�R��',
    'canteditroot' => '�]���A���ݤ_ Root �p�աA�ҥH�A�� Root �p�ժ��ק�Q�ڵ��F�C�p�����D�лP�t�κ޲z���pô�C',
    'listusers' => 'List Users',
    'listthem' => 'list',
    'usersingroup' => 'Users in group "%s"',
    'usergroupadmin' => 'User Group Administration',
    'add' => 'Add',
    'remove' => 'Remove',
    'availmembers' => 'Available Members',
    'groupmembers' => 'Group Members',
    'canteditgroup' => 'To edit this group, you have to be a member of the group. Please contact the system administrator if you feel this is an error.'
);

###############################################################################
# admin/database.php

$LANG_DB_BACKUP = array(
    'last_ten_backups' => '�̫�Q�ӳƥ�',
    'do_backup' => '���ƥ�',
    'backup_successful' => '��Ʈw�ƥ������C',
    'no_backups' => '�S���ƥ�',
    'db_explanation' => '�n���s�� Geeklog �ƥ��A�I���H�U�����s',
    'not_found' => "�����T�����|�� mysqldump �{�����i����C<br>�ˬd<strong>\$_DB_mysqldump_path</strong>�w�q�b config.php.<br>�ܼƲ{�b�Q�w�q���J<var>{$_DB_mysqldump_path}</var>",
    'zero_size' => '�ƥ����ѡJ�ɮ׬O 0 �j�p',
    'path_not_found' => "{$_CONF['backup_path']} ���s�b�Τ��O�ؿ�",
    'no_access' => "���~�J�ؿ� {$_CONF['backup_path']} �A����s���C",
    'backup_file' => '�ƥ��ɮ�',
    'size' => '�j�p',
    'bytes' => '�줸��',
    'total_number' => 'Total number of backups: %d'
);

###############################################################################

$LANG_BUTTONS = array(
    1 => '����',
    2 => '�p��',
    3 => '�X��',
    4 => '�s��',
    5 => '�벼',
    6 => '���',
    7 => '�����έp�ƾ�',
    8 => '�ӤH��',
    9 => '�j�M',
    10 => '�i���j�M'
);

###############################################################################
# 404.php

$LANG_404 = array(
    1 => '404 ���~',
    2 => '�x�A�ڨ�B���ݹL�F���䤣��<b>%s</b>.',
    3 => "<p>�ܩ�p�A���A�n�D����󤣦s�b�C���ˬd<a href=\"{$_CONF['site_url']}\">�D��</a>��<a href=\"{$_CONF['site_url']}/search.php\">�j�M��</a>�ݬݯ�o�{����C"
);

###############################################################################

$LANG_LOGIN = array(
    1 => '�n�D�n�J',
    2 => '��p�A�n�D�n�J�~�i�s���o�Ӱϰ�C',
    3 => '�n�J',
    4 => '�s�Τ�'
);

?>