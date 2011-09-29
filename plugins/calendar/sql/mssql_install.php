<?php

/* Reminder: always indent with 4 spaces (no tabs). */
// +---------------------------------------------------------------------------+
// | Calendar Plugin 1.1                                                       |
// +---------------------------------------------------------------------------+
// | mssql_install.php                                                         |
// +---------------------------------------------------------------------------+
// | Copyright (C) 2000-2009 by the following authors:                         |
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

$_SQL[] = "
CREATE TABLE [dbo].[{$_TABLES['events']}] (
    [eid] [varchar] (20) COLLATE SQL_Latin1_General_CP1_CI_AS NOT NULL ,
    [title] [varchar] (128) COLLATE SQL_Latin1_General_CP1_CI_AS NULL ,
    [description] [varchar] (5000) COLLATE SQL_Latin1_General_CP1_CI_AS NULL ,
    [postmode] [varchar] (10) COLLATE SQL_Latin1_General_CP1_CI_AS NULL ,
    [datestart] [varchar] (50) COLLATE SQL_Latin1_General_CP1_CI_AS NULL ,
    [dateend] [varchar] (50) COLLATE SQL_Latin1_General_CP1_CI_AS NULL ,
    [url] [varchar] (255) COLLATE SQL_Latin1_General_CP1_CI_AS NULL ,
    [hits] [numeric](8, 0) NULL ,
    [owner_id] [numeric](8, 0) NULL ,
    [group_id] [numeric](8, 0) NULL ,
    [perm_owner] [tinyint] NULL ,
    [perm_group] [tinyint] NULL ,
    [perm_members] [tinyint] NULL ,
    [perm_anon] [tinyint] NULL ,
    [address1] [varchar] (40) COLLATE SQL_Latin1_General_CP1_CI_AS NULL ,
    [address2] [varchar] (40) COLLATE SQL_Latin1_General_CP1_CI_AS NULL ,
    [city] [varchar] (60) COLLATE SQL_Latin1_General_CP1_CI_AS NULL ,
    [state] [varchar] (40) COLLATE SQL_Latin1_General_CP1_CI_AS NULL ,
    [zipcode] [varchar] (5) COLLATE SQL_Latin1_General_CP1_CI_AS NULL ,
    [allday] [smallint] NULL ,
    [event_type] [varchar] (40) COLLATE SQL_Latin1_General_CP1_CI_AS NULL ,
    [location] [varchar] (128) COLLATE SQL_Latin1_General_CP1_CI_AS NULL ,
    [timestart] [varchar] (50) COLLATE SQL_Latin1_General_CP1_CI_AS NULL ,
    [timeend] [varchar] (50) COLLATE SQL_Latin1_General_CP1_CI_AS NULL ,
) ON [PRIMARY]
";

$_SQL[] = "
CREATE TABLE [dbo].[{$_TABLES['eventsubmission']}] (
    [eid] [varchar] (20) COLLATE SQL_Latin1_General_CP1_CI_AS NOT NULL ,
    [title] [varchar] (128) COLLATE SQL_Latin1_General_CP1_CI_AS NULL ,
    [description] [varchar] (5000) COLLATE SQL_Latin1_General_CP1_CI_AS NULL ,
    [location] [varchar] (128) COLLATE SQL_Latin1_General_CP1_CI_AS NULL ,
    [datestart] [smalldatetime] NULL ,
    [dateend] [smalldatetime] NULL ,
    [url] [varchar] (255) COLLATE SQL_Latin1_General_CP1_CI_AS NULL ,
    [allday] [smallint] NOT NULL ,
    [zipcode] [varchar] (5) COLLATE SQL_Latin1_General_CP1_CI_AS NULL ,
    [state] [varchar] (40) COLLATE SQL_Latin1_General_CP1_CI_AS NULL ,
    [city] [varchar] (60) COLLATE SQL_Latin1_General_CP1_CI_AS NULL ,
    [address2] [varchar] (40) COLLATE SQL_Latin1_General_CP1_CI_AS NULL ,
    [address1] [varchar] (40) COLLATE SQL_Latin1_General_CP1_CI_AS NULL ,
    [event_type] [varchar] (40) COLLATE SQL_Latin1_General_CP1_CI_AS NOT NULL ,
    [timestart] [smalldatetime] NULL ,
    [timeend] [smalldatetime] NULL,
    [owner_id] [numeric](8, 0) NULL
) ON [PRIMARY] 
";

$_SQL[] = "
CREATE TABLE [dbo].[{$_TABLES['personal_events']}] (
    [eid] [varchar] (20) COLLATE SQL_Latin1_General_CP1_CI_AS NOT NULL ,
    [title] [varchar] (128) COLLATE SQL_Latin1_General_CP1_CI_AS NULL ,
    [event_type] [varchar] (40) COLLATE SQL_Latin1_General_CP1_CI_AS NOT NULL ,
    [datestart] [smalldatetime] NULL ,
    [dateend] [smalldatetime] NULL ,
    [address1] [varchar] (40) COLLATE SQL_Latin1_General_CP1_CI_AS NULL ,
    [address2] [varchar] (40) COLLATE SQL_Latin1_General_CP1_CI_AS NULL ,
    [city] [varchar] (60) COLLATE SQL_Latin1_General_CP1_CI_AS NULL ,
    [state] [varchar] (40) COLLATE SQL_Latin1_General_CP1_CI_AS NULL ,
    [zipcode] [varchar] (5) COLLATE SQL_Latin1_General_CP1_CI_AS NULL ,
    [allday] [smallint] NOT NULL ,
    [url] [varchar] (255) COLLATE SQL_Latin1_General_CP1_CI_AS NULL ,
    [description] [varchar] (5000) COLLATE SQL_Latin1_General_CP1_CI_AS NULL ,
    [postmode] [varchar] (10) COLLATE SQL_Latin1_General_CP1_CI_AS NOT NULL ,
    [owner_id] [numeric](8, 0) NOT NULL ,
    [group_id] [numeric](8, 0) NOT NULL ,
    [perm_owner] [tinyint] NOT NULL ,
    [perm_group] [tinyint] NOT NULL ,
    [perm_members] [tinyint] NOT NULL ,
    [perm_anon] [tinyint] NOT NULL ,
    [uid] [int] NOT NULL ,
    [location] [varchar] (128) COLLATE SQL_Latin1_General_CP1_CI_AS NULL ,
    [timestart] [smalldatetime] NULL ,
    [timeend] [smalldatetime] NULL
) ON [PRIMARY] 
";


$_SQL[] = "ALTER TABLE [dbo].[{$_TABLES['events']}] ADD
    CONSTRAINT [PK_{$_TABLES['events']}] PRIMARY KEY  CLUSTERED
    (
        [eid]
    )  ON [PRIMARY]
";

$_SQL[] = "ALTER TABLE [dbo].[{$_TABLES['eventsubmission']}] ADD
    CONSTRAINT [PK_{$_TABLES['eventsubmission']}] PRIMARY KEY  CLUSTERED
    (
        [eid]
    )  ON [PRIMARY]
";

$_SQL[] = "ALTER TABLE [dbo].[{$_TABLES['personal_events']}] ADD
    CONSTRAINT [PK_{$_TABLES['personal_events']}] PRIMARY KEY  CLUSTERED
    (
        [eid],
        [uid]
    )  ON [PRIMARY]
";

$_SQL[] = "INSERT INTO {$_TABLES['eventsubmission']} (eid, title, description, location, datestart, dateend, url, allday, zipcode, state, city, address2, address1, event_type, timestart, timeend, owner_id) VALUES ('2008050110130162','Installed the Calendar plugin','Today, you successfully installed the Calendar plugin.','Your webserver',getdate(),getdate(),'http://www.geeklog.net/',1,NULL,NULL,NULL,NULL,NULL,'',NULL,NULL,1)";

?>
