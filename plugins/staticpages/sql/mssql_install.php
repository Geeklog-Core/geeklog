<?php

/* Reminder: always indent with 4 spaces (no tabs). */
// +---------------------------------------------------------------------------+
// | Static Pages Plugin 1.6                                                   |
// +---------------------------------------------------------------------------+
// | Installation SQL                                                          |
// +---------------------------------------------------------------------------+
// | Copyright (C) 2000-2010 by the following authors:                         |
// |                                                                           |
// | Authors: Tony Bibbs       - tony AT tonybibbs DOT com                     |
// |          Tom Willett      - twillett AT users DOT sourceforge DOT net     |
// |          Blaine Lang      - langmail AT sympatico DOT ca                  |
// |          Dirk Haun        - dirk AT haun-online DOT de                    |
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
* MS SQL install
*
* @package StaticPages
*/

$_SQL[] = "
CREATE TABLE [dbo].[{$_TABLES['staticpage']}] (
    [sp_id] [varchar] (40) COLLATE SQL_Latin1_General_CP1_CI_AS NOT NULL ,
    [sp_title] [varchar] (128) COLLATE SQL_Latin1_General_CP1_CI_AS NOT NULL ,
    [sp_page_title] [varchar] (128) COLLATE SQL_Latin1_General_CP1_CI_AS NOT NULL ,
    [sp_content] [varchar] (5000) COLLATE SQL_Latin1_General_CP1_CI_AS NOT NULL ,
    [sp_hits] [numeric](8, 0) NOT NULL ,
    [created] [datetime] NOT NULL ,
    [modified] [datetime] NOT NULL ,
    [sp_format] [varchar] (20) COLLATE SQL_Latin1_General_CP1_CI_AS NOT NULL ,
    [sp_onmenu] [tinyint] NOT NULL ,
    [sp_label] [varchar] (64) COLLATE SQL_Latin1_General_CP1_CI_AS NULL ,
    [commentcode] [numeric](4, 0) NOT NULL,
    [meta_description] [varchar] (5000) COLLATE SQL_Latin1_General_CP1_CI_AS NOT NULL ,
    [meta_keywords] [varchar] (5000) COLLATE SQL_Latin1_General_CP1_CI_AS NOT NULL ,
    [draft_flag] [tinyint] NULL ,
    [owner_id] [numeric](8, 0) NOT NULL ,
    [group_id] [numeric](8, 0) NOT NULL ,
    [perm_owner] [tinyint] NOT NULL ,
    [perm_group] [tinyint] NOT NULL ,
    [perm_members] [tinyint] NOT NULL ,
    [perm_anon] [tinyint] NOT NULL ,
    [sp_centerblock] [tinyint] NOT NULL ,
    [sp_help] [varchar] (256) COLLATE SQL_Latin1_General_CP1_CI_AS NULL ,
    [sp_tid] [varchar] (20) COLLATE SQL_Latin1_General_CP1_CI_AS NOT NULL ,
    [sp_where] [tinyint] NOT NULL ,
    [sp_php] [tinyint] NOT NULL ,
    [sp_nf] [tinyint] NULL ,
    [sp_inblock] [tinyint] NULL  ,
    [postmode] [varchar] (16) COLLATE SQL_Latin1_General_CP1_CI_AS NOT NULL ,
) ON [PRIMARY] 
";

$_SQL[] = "ALTER TABLE [dbo].[{$_TABLES['staticpage']}] ADD
    CONSTRAINT [DF_{$_TABLES['staticpage']}] DEFAULT ('html') FOR [postmode],
	CONSTRAINT [PK_{$_TABLES['staticpage']}] PRIMARY KEY  CLUSTERED
	(
		[sp_id]
	)  ON [PRIMARY]
";

?>
