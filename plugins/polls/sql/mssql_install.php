<?php

/* Reminder: always indent with 4 spaces (no tabs). */
// +---------------------------------------------------------------------------+
// | Polls Plugin 2.1                                                          |
// +---------------------------------------------------------------------------+
// | mssql_install.php                                                         |
// +---------------------------------------------------------------------------+
// | Copyright (C) 2000-2010 by the following authors:                         |
// |                                                                           |
// | Authors: Tony Bibbs        - tony AT tonybibbs DOT com                    |
// |          Mark Limburg      - mlimburg AT users DOT sourceforge DOT net    |
// |          Jason Whittenburg - jwhitten AT securitygeeks DOT com            |
// |          Dirk Haun         - dirk AT haun-online DOT de                   |
// |          Trinity Bays      - trinity93 AT gmail DOT com                   |
// |          Randy Kolenko     - randy AT nextide DOT ca                      |
// +---------------------------------------------------------------------------+
// |                                                                           |
// | This program is licensed under the terms of the GNU General Public License|
// | as published by the Free Software Foundation; either version 2            |
// | of the License, or (at your option) any later version.                    |
// |                                                                           |
// | This program is distributed in the hope that it will be useful,           |
// | but WITHOUT ANY WARRANTY; without even the implied warranty of            |
// | MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.                      |
// | See the GNU General Public License for more details.                      |
// |                                                                           |
// | You should have received a copy of the GNU General Public License         |
// | along with this program; if not, write to the Free Software Foundation,   |
// | Inc., 59 Temple Place - Suite 330, Boston, MA  02111-1307, USA.           |
// |                                                                           |
// +---------------------------------------------------------------------------+

/**
* MS SQL install data and tables
*
* @package Polls
*/

$_SQL[] = "
CREATE TABLE [dbo].[{$_TABLES['pollanswers']}] (
    [pid] [varchar] (128) COLLATE SQL_Latin1_General_CP1_CI_AS NOT NULL ,
    [qid] [int] NOT NULL ,
    [aid] [tinyint] NOT NULL ,
    [answer] [varchar] (255) COLLATE SQL_Latin1_General_CP1_CI_AS NULL ,
    [votes] [numeric](8, 0) NULL ,
    [remark] [varchar] (255) COLLATE SQL_Latin1_General_CP1_CI_AS NULL
) ON [PRIMARY]
";

$_SQL[] = "
CREATE TABLE [dbo].[{$_TABLES['pollquestions']}] (
    [qid] [int] NOT NULL ,
    [pid] [varchar] (128) COLLATE SQL_Latin1_General_CP1_CI_AS NOT NULL ,
    [question] [varchar] (255) COLLATE SQL_Latin1_General_CP1_CI_AS NULL ,
) ON [PRIMARY]
";

$_SQL[] = "
CREATE TABLE [dbo].[{$_TABLES['polltopics']}] (
    [pid] [varchar] (128) COLLATE SQL_Latin1_General_CP1_CI_AS NOT NULL ,
    [topic] [varchar] (255) COLLATE SQL_Latin1_General_CP1_CI_AS NULL ,
    [meta_description] [varchar] (5000) COLLATE SQL_Latin1_General_CP1_CI_AS NOT NULL ,
    [meta_keywords] [varchar] (5000) COLLATE SQL_Latin1_General_CP1_CI_AS NOT NULL ,    
    [voters] [numeric](8, 0) NULL ,
    [questions] [int] NOT NULL ,
    [created] [datetime] NULL ,
    [modified] [datetime] NULL ,
    [display] [tinyint] NOT NULL ,
    [is_open] [tinyint] NOT NULL ,
    [hideresults] [tinyint] NOT NULL ,
    [commentcode] [smallint] NOT NULL ,
    [statuscode] [smallint] NOT NULL ,
    [owner_id] [numeric](8, 0) NOT NULL ,
    [group_id] [numeric](8, 0) NOT NULL ,
    [perm_owner] [tinyint] NOT NULL ,
    [perm_group] [tinyint] NOT NULL ,
    [perm_members] [tinyint] NOT NULL ,
    [perm_anon] [tinyint] NOT NULL
) ON [PRIMARY]
";

$_SQL[] = "
CREATE TABLE [dbo].[{$_TABLES['pollvoters']}] (
    [id] [numeric](10, 0) IDENTITY (1, 1) NOT NULL ,
    [pid] [varchar] (128) COLLATE SQL_Latin1_General_CP1_CI_AS NOT NULL ,
    [ipaddress] [varchar] (39) COLLATE SQL_Latin1_General_CP1_CI_AS NOT NULL ,
    [date] [numeric](10, 0) NULL
) ON [PRIMARY]
";

$_SQL[] = "ALTER TABLE [dbo].[{$_TABLES['pollanswers']}] ADD
    CONSTRAINT [PK_{$_TABLES['pollanswers']}] PRIMARY KEY  CLUSTERED
    (
        [qid],
        [aid]
    )  ON [PRIMARY]
";

$_SQL[] = "ALTER TABLE [dbo].[{$_TABLES['pollquestions']}] ADD
    CONSTRAINT [PK_{$_TABLES['pollquestions']}] PRIMARY KEY  CLUSTERED
    (
        [qid]
    )  ON [PRIMARY]
";

$_SQL[] = "ALTER TABLE [dbo].[{$_TABLES['polltopics']}] ADD
    CONSTRAINT [PK_{$_TABLES['polltopics']}] PRIMARY KEY  CLUSTERED
    (
        [pid]
    )  ON [PRIMARY]
";

$_SQL[] = "ALTER TABLE [dbo].[{$_TABLES['pollvoters']}] ADD
    CONSTRAINT [PK_{$_TABLES['pollvoters']}] PRIMARY KEY  CLUSTERED
    (
        [id]
    )  ON [PRIMARY]
";


// default poll

$DEFVALUES[] = "INSERT INTO {$_TABLES['polltopics']} (pid, topic, meta_description, meta_keywords, voters, questions, created, modified, display, is_open, hideresults, commentcode, statuscode, owner_id, group_id, perm_owner, perm_group, perm_members, perm_anon) VALUES ('geeklogfeaturepoll', 'Tell us your opinion about Geeklog', 'A poll about users opinions of Geeklog.', 'Poll, Geeklog, Opinion', 0, 2, NOW(), NOW(), 1, 1, 1, 0, 0, {$_USER['uid']}, #group#, 3, 2, 2, 2);";

$DEFVALUES[] = "INSERT INTO {$_TABLES['pollquestions']} (qid, pid, question) VALUES (0, 'geeklogfeaturepoll', 'What is the best new feature of Geeklog?');";
$DEFVALUES[] = "INSERT INTO {$_TABLES['pollquestions']} (qid, pid, question) VALUES (1, 'geeklogfeaturepoll', 'What is the all-time best feature of Geeklog?');";

$DEFVALUES[] = "INSERT INTO {$_TABLES['pollanswers']} (pid, qid, aid, answer, votes, remark) VALUES ('geeklogfeaturepoll', 0, 1, 'OAuth Login Support', 0, '');";
$DEFVALUES[] = "INSERT INTO {$_TABLES['pollanswers']} (pid, qid, aid, answer, votes, remark) VALUES ('geeklogfeaturepoll', 0, 2, 'New Configuration UI', 0, '');";
$DEFVALUES[] = "INSERT INTO {$_TABLES['pollanswers']} (pid, qid, aid, answer, votes, remark) VALUES ('geeklogfeaturepoll', 0, 3, 'Plugin Dependencies', 0, '');";
$DEFVALUES[] = "INSERT INTO {$_TABLES['pollanswers']} (pid, qid, aid, answer, votes, remark) VALUES ('geeklogfeaturepoll', 0, 4, 'Tooltips', 0, '');";
$DEFVALUES[] = "INSERT INTO {$_TABLES['pollanswers']} (pid, qid, aid, answer, votes, remark) VALUES ('geeklogfeaturepoll', 0, 5, 'Other', 0, '');";

$DEFVALUES[] = "INSERT INTO {$_TABLES['pollanswers']} (pid, qid, aid, answer, votes, remark) VALUES ('geeklogfeaturepoll', 1, 1, 'Permissions Handling', 0, '');";
$DEFVALUES[] = "INSERT INTO {$_TABLES['pollanswers']} (pid, qid, aid, answer, votes, remark) VALUES ('geeklogfeaturepoll', 1, 2, 'Spam Protection', 0, '');";
$DEFVALUES[] = "INSERT INTO {$_TABLES['pollanswers']} (pid, qid, aid, answer, votes, remark) VALUES ('geeklogfeaturepoll', 1, 3, 'Focus on Security', 0, '');";
$DEFVALUES[] = "INSERT INTO {$_TABLES['pollanswers']} (pid, qid, aid, answer, votes, remark) VALUES ('geeklogfeaturepoll', 1, 4, 'Plugin Availability', 0, '');";
$DEFVALUES[] = "INSERT INTO {$_TABLES['pollanswers']} (pid, qid, aid, answer, votes, remark) VALUES ('geeklogfeaturepoll', 1, 5, 'The Community', 0, '');";

?>
