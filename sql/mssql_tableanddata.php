<?php
$_SQL = array();



$_SQL[] = "begin tran";

$_SQL[] = "
CREATE TABLE [dbo].[dateCommandCrossReference] (
    [id] [int] IDENTITY (1, 1) NOT NULL ,
    [mysqlCommand] [varchar] (50) COLLATE SQL_Latin1_General_CP1_CI_AS NOT NULL ,
    [sqlServerCommand] [varchar] (50) COLLATE SQL_Latin1_General_CP1_CI_AS NULL ,
    [isDateName] [bit] NOT NULL ,
    [isDatePart] [bit] NOT NULL
) ON [PRIMARY]
";



$_SQL[] = "ALTER TABLE [dbo].[dateCommandCrossReference] ADD
    CONSTRAINT [DF_commandCrossReference_isDateName] DEFAULT (0) FOR [isDateName],
    CONSTRAINT [DF_commandCrossReference_isDatePart] DEFAULT (1) FOR [isDatePart],
    CONSTRAINT [PK_commandCrossReference] PRIMARY KEY  CLUSTERED
    (
        [id]
    )  ON [PRIMARY]
";


$_SQL[] = "
CREATE TABLE [dbo].[{$_TABLES['access']}] (
    [acc_ft_id] [int] NOT NULL ,
    [acc_grp_id] [int] NOT NULL
) ON [PRIMARY]
";

$_SQL[] = "
CREATE TABLE [dbo].[{$_TABLES['article_images']}] (
    [ai_sid] [varchar] (40) COLLATE SQL_Latin1_General_CP1_CI_AS NOT NULL ,
    [ai_img_num] [tinyint] NOT NULL ,
    [ai_filename] [varchar] (128) COLLATE SQL_Latin1_General_CP1_CI_AS NOT NULL
) ON [PRIMARY]
";



$_SQL[] = "
CREATE TABLE [dbo].[{$_TABLES['blocks']}] (
    [bid] [numeric](5, 0) IDENTITY (1, 1) NOT NULL ,
    [is_enabled] [tinyint] NOT NULL ,
    [name] [varchar] (48) COLLATE SQL_Latin1_General_CP1_CI_AS NOT NULL ,
    [type] [varchar] (20) COLLATE SQL_Latin1_General_CP1_CI_AS NOT NULL ,
    [title] [varchar] (48) COLLATE SQL_Latin1_General_CP1_CI_AS NULL ,
    [tid] [varchar] (20) COLLATE SQL_Latin1_General_CP1_CI_AS NOT NULL ,
    [blockorder] [numeric](5, 0) NOT NULL ,
    [content] [varchar] (5000) COLLATE SQL_Latin1_General_CP1_CI_AS NULL ,
    [rdfurl] [varchar] (255) COLLATE SQL_Latin1_General_CP1_CI_AS NULL ,
    [rdfupdated] [varchar] (50) COLLATE SQL_Latin1_General_CP1_CI_AS NULL ,
    [rdflimit] [numeric](5, 0) NULL ,
    [onleft] [tinyint] NULL ,
    [phpblockfn] [varchar] (64) COLLATE SQL_Latin1_General_CP1_CI_AS NULL ,
    [help] [varchar] (256) COLLATE SQL_Latin1_General_CP1_CI_AS NULL ,
    [owner_id] [numeric](8, 0) NOT NULL ,
    [group_id] [numeric](8, 0) NOT NULL ,
    [perm_owner] [tinyint] NOT NULL ,
    [perm_group] [tinyint] NOT NULL ,
    [perm_members] [tinyint] NOT NULL ,
    [perm_anon] [tinyint] NOT NULL ,
    [allow_autotags] [tinyint] NOT NULL ,
) ON [PRIMARY] 
";

$_SQL[] = "
CREATE TABLE [dbo].[{$_TABLES['commentcodes']}] (
    [code] [smallint] NOT NULL ,
    [name] [varchar] (32) COLLATE SQL_Latin1_General_CP1_CI_AS NULL
) ON [PRIMARY]
";

$_SQL[] = "
CREATE TABLE [dbo].[{$_TABLES['commentmodes']}] (
    [mode] [varchar] (10) COLLATE SQL_Latin1_General_CP1_CI_AS NOT NULL ,
    [name] [varchar] (32) COLLATE SQL_Latin1_General_CP1_CI_AS NULL
) ON [PRIMARY]
";


$_SQL[] = "
CREATE TABLE [dbo].[{$_TABLES['comments']}] (
    [cid] [numeric](10, 0) IDENTITY (1, 1) NOT NULL ,
    [type] [varchar] (30) COLLATE SQL_Latin1_General_CP1_CI_AS NOT NULL ,
    [sid] [varchar] (40) COLLATE SQL_Latin1_General_CP1_CI_AS NOT NULL ,
    [date] [datetime] NULL ,
    [title] [varchar] (128) COLLATE SQL_Latin1_General_CP1_CI_AS NULL ,
    [comment] [varchar] (5000) COLLATE SQL_Latin1_General_CP1_CI_AS NULL ,
    [score] [smallint] NULL ,
    [reason] [smallint] NULL ,
    [pid] [numeric](10, 0) NULL ,
    [lft] [numeric](10, 0) NULL ,
    [rht] [numeric](10, 0) NULL ,
    [indent] [numeric](10, 0) NULL ,
    [uid] [int] NULL ,
    [ipaddress] [varchar] (15) COLLATE SQL_Latin1_General_CP1_CI_AS NULL
) ON [PRIMARY] 
";

$_SQL[] = "
CREATE TABLE [dbo].[{$_TABLES['cookiecodes']}] (
    [cc_value] [numeric](8, 0) NOT NULL ,
    [cc_descr] [varchar] (20) COLLATE SQL_Latin1_General_CP1_CI_AS NOT NULL
) ON [PRIMARY]
";

$_SQL[] = "
CREATE TABLE [dbo].[{$_TABLES['dateformats']}] (
    [dfid] [smallint] NOT NULL ,
    [format] [varchar] (32) COLLATE SQL_Latin1_General_CP1_CI_AS NULL ,
    [description] [varchar] (64) COLLATE SQL_Latin1_General_CP1_CI_AS NULL
) ON [PRIMARY]
";

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
    [state] [char] (2) COLLATE SQL_Latin1_General_CP1_CI_AS NULL ,
    [zipcode] [varchar] (5) COLLATE SQL_Latin1_General_CP1_CI_AS NULL ,
    [allday] [smallint] NULL ,
    [event_type] [varchar] (40) COLLATE SQL_Latin1_General_CP1_CI_AS NULL ,
    [location] [varchar] (128) COLLATE SQL_Latin1_General_CP1_CI_AS NULL ,
    [timestart] [varchar] (50) COLLATE SQL_Latin1_General_CP1_CI_AS NULL ,
    [timeend] [varchar] (50) COLLATE SQL_Latin1_General_CP1_CI_AS NULL
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
    [state] [char] (2) COLLATE SQL_Latin1_General_CP1_CI_AS NULL ,
    [city] [varchar] (60) COLLATE SQL_Latin1_General_CP1_CI_AS NULL ,
    [address2] [varchar] (40) COLLATE SQL_Latin1_General_CP1_CI_AS NULL ,
    [address1] [varchar] (40) COLLATE SQL_Latin1_General_CP1_CI_AS NULL ,
    [event_type] [varchar] (40) COLLATE SQL_Latin1_General_CP1_CI_AS NOT NULL ,
    [timestart] [smalldatetime] NULL ,
    [timeend] [smalldatetime] NULL
) ON [PRIMARY] 
";

$_SQL[] = "
CREATE TABLE [dbo].[{$_TABLES['featurecodes']}] (
    [code] [smallint] NOT NULL ,
    [name] [varchar] (32) COLLATE SQL_Latin1_General_CP1_CI_AS NULL
) ON [PRIMARY]
";

$_SQL[] = "
CREATE TABLE [dbo].[{$_TABLES['features']}] (
    [ft_id] [int] IDENTITY (1, 1) NOT NULL ,
    [ft_name] [varchar] (20) COLLATE SQL_Latin1_General_CP1_CI_AS NOT NULL ,
    [ft_descr] [varchar] (255) COLLATE SQL_Latin1_General_CP1_CI_AS NOT NULL ,
    [ft_gl_core] [smallint] NOT NULL
) ON [PRIMARY]
";

$_SQL[] = "
CREATE TABLE [dbo].[{$_TABLES['frontpagecodes']}] (
    [code] [smallint] NOT NULL ,
    [name] [varchar] (32) COLLATE SQL_Latin1_General_CP1_CI_AS NULL
) ON [PRIMARY]
";


$_SQL[] = "
CREATE TABLE [dbo].[{$_TABLES['group_assignments']}] (
    [ug_main_grp_id] [int] NOT NULL ,
    [ug_uid] [numeric](8, 0) NULL ,
    [ug_grp_id] [numeric](8, 0) NULL
) ON [PRIMARY]
";


$_SQL[] = "
CREATE TABLE [dbo].[{$_TABLES['groups']}] (
    [grp_id] [int] IDENTITY (1, 1) NOT NULL ,
    [grp_name] [varchar] (50) COLLATE SQL_Latin1_General_CP1_CI_AS NOT NULL ,
    [grp_descr] [varchar] (255) COLLATE SQL_Latin1_General_CP1_CI_AS NOT NULL ,
    [grp_gl_core] [tinyint] NOT NULL
) ON [PRIMARY]
";




$_SQL[] = "
CREATE TABLE [dbo].[{$_TABLES['links']}] (
    [lid] [varchar] (40) COLLATE SQL_Latin1_General_CP1_CI_AS NOT NULL ,
    [category] [varchar] (32) COLLATE SQL_Latin1_General_CP1_CI_AS NULL ,
    [url] [varchar] (255) COLLATE SQL_Latin1_General_CP1_CI_AS NULL ,
    [description] [varchar] (5000) COLLATE SQL_Latin1_General_CP1_CI_AS NULL ,
    [title] [varchar] (96) COLLATE SQL_Latin1_General_CP1_CI_AS NULL ,
    [hits] [int] NOT NULL ,
    [date] [datetime] NULL ,
    [owner_id] [numeric](8, 0) NOT NULL ,
    [group_id] [numeric](8, 0) NOT NULL ,
    [perm_owner] [tinyint] NOT NULL ,
    [perm_group] [tinyint] NOT NULL ,
    [perm_members] [tinyint] NOT NULL ,
    [perm_anon] [tinyint] NOT NULL
) ON [PRIMARY] 
";


$_SQL[] = "
CREATE TABLE [dbo].[{$_TABLES['linksubmission']}] (
    [lid] [varchar] (40) COLLATE SQL_Latin1_General_CP1_CI_AS NOT NULL ,
    [category] [varchar] (32) COLLATE SQL_Latin1_General_CP1_CI_AS NULL ,
    [url] [varchar] (255) COLLATE SQL_Latin1_General_CP1_CI_AS NULL ,
    [description] [varchar] (5000) COLLATE SQL_Latin1_General_CP1_CI_AS NULL ,
    [title] [varchar] (96) COLLATE SQL_Latin1_General_CP1_CI_AS NULL ,
    [hits] [int] NULL ,
    [date] [datetime] NULL
) ON [PRIMARY] 
";


$_SQL[] = "
CREATE TABLE [dbo].[{$_TABLES['maillist']}] (
    [code] [int] NOT NULL ,
    [name] [char] (32) COLLATE SQL_Latin1_General_CP1_CI_AS NULL
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
    [state] [char] (2) COLLATE SQL_Latin1_General_CP1_CI_AS NULL ,
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


$_SQL[] = "
CREATE TABLE [dbo].[{$_TABLES['pingservice']}] (
    [pid] [numeric](5, 0) IDENTITY (1, 1) NOT NULL ,
    [name] [varchar] (128) COLLATE SQL_Latin1_General_CP1_CI_AS NULL ,
    [ping_url] [varchar] (255) COLLATE SQL_Latin1_General_CP1_CI_AS NULL ,
    [site_url] [varchar] (255) COLLATE SQL_Latin1_General_CP1_CI_AS NULL ,
    [method] [varchar] (80) COLLATE SQL_Latin1_General_CP1_CI_AS NULL ,
    [is_enabled] [tinyint] NOT NULL
) ON [PRIMARY]
";


$_SQL[] = "
CREATE TABLE [dbo].[{$_TABLES['plugins']}] (
    [pi_name] [varchar] (30) COLLATE SQL_Latin1_General_CP1_CI_AS NOT NULL ,
    [pi_version] [varchar] (20) COLLATE SQL_Latin1_General_CP1_CI_AS NOT NULL ,
    [pi_gl_version] [varchar] (20) COLLATE SQL_Latin1_General_CP1_CI_AS NOT NULL ,
    [pi_enabled] [tinyint] NOT NULL ,
    [pi_homepage] [varchar] (128) COLLATE SQL_Latin1_General_CP1_CI_AS NOT NULL
) ON [PRIMARY]
";


$_SQL[] = "
CREATE TABLE [dbo].[{$_TABLES['pollanswers']}] (
    [qid] [varchar] (20) COLLATE SQL_Latin1_General_CP1_CI_AS NOT NULL ,
    [aid] [tinyint] NOT NULL ,
    [answer] [varchar] (255) COLLATE SQL_Latin1_General_CP1_CI_AS NULL ,
    [votes] [numeric](8, 0) NULL ,
    [remark] [varchar] (255) COLLATE SQL_Latin1_General_CP1_CI_AS NULL ,
) ON [PRIMARY]
";


$_SQL[] = "
CREATE TABLE [dbo].[{$_TABLES['pollquestions']}] (
    [qid] [varchar] (20) COLLATE SQL_Latin1_General_CP1_CI_AS NOT NULL ,
    [question] [varchar] (255) COLLATE SQL_Latin1_General_CP1_CI_AS NULL ,
    [voters] [numeric](8, 0) NULL ,
    [date] [datetime] NULL ,
    [display] [smallint] NOT NULL ,
    [commentcode] [smallint] NOT NULL ,
    [statuscode] [smallint] NOT NULL ,
    [owner_id] [numeric](8, 0) NOT NULL ,
    [group_id] [numeric](8, 0) NOT NULL ,
    [perm_owner] [tinyint] NOT NULL ,
    [perm_group] [tinyint] NOT NULL ,
    [perm_members] [tinyint]  NULL ,
    [perm_anon] [tinyint]  NULL
) ON [PRIMARY]
";


$_SQL[] = "
CREATE TABLE [dbo].[{$_TABLES['pollvoters']}] (
    [id] [numeric](10, 0) IDENTITY (1, 1) NOT NULL ,
    [qid] [varchar] (20) COLLATE SQL_Latin1_General_CP1_CI_AS NOT NULL ,
    [ipaddress] [varchar] (15) COLLATE SQL_Latin1_General_CP1_CI_AS NOT NULL ,
    [date] [numeric](10, 0) NULL
) ON [PRIMARY]
";


$_SQL[] = "
CREATE TABLE [dbo].[{$_TABLES['postmodes']}] (
    [code] [varchar] (10) COLLATE SQL_Latin1_General_CP1_CI_AS NOT NULL ,
    [name] [varchar] (32) COLLATE SQL_Latin1_General_CP1_CI_AS NULL
) ON [PRIMARY]
";


$_SQL[] = "
CREATE TABLE [dbo].[{$_TABLES['sessions']}] (
    [sess_id] [numeric](10, 0) NOT NULL ,
    [start_time] [numeric](10, 0) NOT NULL ,
    [remote_ip] [varchar] (15) COLLATE SQL_Latin1_General_CP1_CI_AS NOT NULL ,
    [uid] [int] NOT NULL ,
    [md5_sess_id] [varchar] (128) COLLATE SQL_Latin1_General_CP1_CI_AS NULL
) ON [PRIMARY]
";


$_SQL[] = "
CREATE TABLE [dbo].[{$_TABLES['sortcodes']}] (
    [code] [char] (4) COLLATE SQL_Latin1_General_CP1_CI_AS NOT NULL ,
    [name] [char] (32) COLLATE SQL_Latin1_General_CP1_CI_AS NULL
) ON [PRIMARY]
";


$_SQL[] = "
CREATE TABLE [dbo].[{$_TABLES['spamx']}] (
    [name] [varchar] (20) COLLATE SQL_Latin1_General_CP1_CI_AS NOT NULL ,
    [value] [varchar] (255) COLLATE SQL_Latin1_General_CP1_CI_AS NOT NULL
) ON [PRIMARY]
";


$_SQL[] = "
CREATE TABLE [dbo].[{$_TABLES['speedlimit']}] (
    [id] [numeric](10, 0) IDENTITY (1, 1) NOT NULL ,
    [ipaddress] [varchar] (15) COLLATE SQL_Latin1_General_CP1_CI_AS NOT NULL ,
    [date] [numeric](10, 0) NULL ,
    [type] [varchar] (30) COLLATE SQL_Latin1_General_CP1_CI_AS NOT NULL
) ON [PRIMARY]
";


$_SQL[] = "
CREATE TABLE [dbo].[{$_TABLES['staticpage']}] (
    [sp_id] [varchar] (40) COLLATE SQL_Latin1_General_CP1_CI_AS NOT NULL ,
    [sp_uid] [int] NOT NULL ,
    [sp_title] [varchar] (128) COLLATE SQL_Latin1_General_CP1_CI_AS NOT NULL ,
    [sp_content] [varchar] (5000) COLLATE SQL_Latin1_General_CP1_CI_AS NOT NULL ,
    [sp_hits] [numeric](8, 0) NOT NULL ,
    [sp_date] [datetime] NOT NULL ,
    [sp_format] [varchar] (20) COLLATE SQL_Latin1_General_CP1_CI_AS NOT NULL ,
    [sp_onmenu] [tinyint] NOT NULL ,
    [sp_label] [varchar] (64) COLLATE SQL_Latin1_General_CP1_CI_AS NULL ,
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


$_SQL[] = "
CREATE TABLE [dbo].[{$_TABLES['statuscodes']}] (
    [code] [int] NOT NULL ,
    [name] [char] (32) COLLATE SQL_Latin1_General_CP1_CI_AS NULL
) ON [PRIMARY]
";


$_SQL[] = "
CREATE TABLE [dbo].[{$_TABLES['stories']}] (
    [sid] [varchar] (40) COLLATE SQL_Latin1_General_CP1_CI_AS NOT NULL ,
    [uid] [int] NOT NULL ,
    [draft_flag] [tinyint] NULL ,
    [tid] [varchar] (20) COLLATE SQL_Latin1_General_CP1_CI_AS NOT NULL ,
    [date] [datetime] NULL ,
    [title] [varchar] (128) COLLATE SQL_Latin1_General_CP1_CI_AS NULL ,
    [introtext] [varchar] (5000) COLLATE SQL_Latin1_General_CP1_CI_AS NULL ,
    [bodytext] [varchar] (5000) COLLATE SQL_Latin1_General_CP1_CI_AS NULL ,
    [hits] [numeric](8, 0) NOT NULL ,
    [numemails] [numeric](8, 0) NOT NULL ,
    [comments] [numeric](8, 0) NOT NULL ,
    [trackbacks] [numeric](8, 0) NOT NULL ,
    [related] [varchar] (5000) COLLATE SQL_Latin1_General_CP1_CI_AS NULL ,
    [featured] [tinyint] NOT NULL ,
    [show_topic_icon] [tinyint] NOT NULL ,
    [commentcode] [smallint] NOT NULL ,
    [trackbackcode] [smallint] NOT NULL ,
    [statuscode] [smallint] NOT NULL ,
    [expire] [datetime] NULL ,
    [postmode] [varchar] (10) COLLATE SQL_Latin1_General_CP1_CI_AS NOT NULL ,
    [frontpage] [tinyint] NULL ,
    [in_transit] [tinyint] NULL ,
    [owner_id] [int] NOT NULL ,
    [group_id] [int] NOT NULL ,
    [perm_owner] [tinyint] NOT NULL ,
    [perm_group] [tinyint] NOT NULL ,
    [perm_members] [tinyint] NOT NULL ,
    [perm_anon] [tinyint] NOT NULL ,
    [advanced_editor_mode] [tinyint] NOT NULL ,
) ON [PRIMARY] 
";

$_SQL[] = "
CREATE TABLE [dbo].[{$_TABLES['storysubmission']}] (
    [sid] [varchar] (20) COLLATE SQL_Latin1_General_CP1_CI_AS NOT NULL ,
    [uid] [int] NOT NULL ,
    [tid] [varchar] (20) COLLATE SQL_Latin1_General_CP1_CI_AS NOT NULL ,
    [title] [varchar] (128) COLLATE SQL_Latin1_General_CP1_CI_AS NULL ,
    [introtext] [varchar] (5000) COLLATE SQL_Latin1_General_CP1_CI_AS NULL ,
    [date] [datetime] NULL ,
    [postmode] [varchar] (10) COLLATE SQL_Latin1_General_CP1_CI_AS NOT NULL
) ON [PRIMARY] 
";


$_SQL[] = "
CREATE TABLE [dbo].[{$_TABLES['syndication']}] (
    [fid] [numeric](10, 0) IDENTITY (1, 1) NOT NULL ,
    [type] [varchar] (30) COLLATE SQL_Latin1_General_CP1_CI_AS NOT NULL ,
    [topic] [varchar] (48) COLLATE SQL_Latin1_General_CP1_CI_AS NOT NULL ,
    [header_tid] [varchar] (48) COLLATE SQL_Latin1_General_CP1_CI_AS NOT NULL ,
    [format] [varchar] (20) COLLATE SQL_Latin1_General_CP1_CI_AS NOT NULL ,
    [limits] [varchar] (5) COLLATE SQL_Latin1_General_CP1_CI_AS NOT NULL ,
    [content_length] [numeric](5, 0) NOT NULL ,
    [title] [varchar] (40) COLLATE SQL_Latin1_General_CP1_CI_AS NOT NULL ,
    [description] [varchar] (5000) COLLATE SQL_Latin1_General_CP1_CI_AS NULL ,
    [feedlogo] [varchar] (255) COLLATE SQL_Latin1_General_CP1_CI_AS NULL ,
    [filename] [varchar] (40) COLLATE SQL_Latin1_General_CP1_CI_AS NOT NULL ,
    [charset] [varchar] (20) COLLATE SQL_Latin1_General_CP1_CI_AS NOT NULL ,
    [language] [varchar] (20) COLLATE SQL_Latin1_General_CP1_CI_AS NOT NULL ,
    [is_enabled] [tinyint] NOT NULL ,
    [updated] [datetime] NULL ,
    [update_info] [varchar] (5000) COLLATE SQL_Latin1_General_CP1_CI_AS NULL
) ON [PRIMARY] 
";


$_SQL[] = "
CREATE TABLE [dbo].[{$_TABLES['topics']}] (
    [tid] [varchar] (20) COLLATE SQL_Latin1_General_CP1_CI_AS NOT NULL ,
    [topic] [varchar] (48) COLLATE SQL_Latin1_General_CP1_CI_AS NULL ,
    [imageurl] [varchar] (255) COLLATE SQL_Latin1_General_CP1_CI_AS NULL ,
    [sortnum] [smallint] NULL ,
    [limitnews] [smallint] NULL ,
    [is_default] [tinyint] NOT NULL ,
    [archive_flag] [tinyint]  NULL ,
    [owner_id] [numeric](8, 0) NOT NULL ,
    [group_id] [numeric](8, 0) NOT NULL ,
    [perm_owner] [tinyint] NOT NULL ,
    [perm_group] [tinyint] NOT NULL ,
    [perm_members] [tinyint] NOT NULL ,
    [perm_anon] [tinyint] NOT NULL
) ON [PRIMARY]
";


$_SQL[] = "
CREATE TABLE [dbo].[{$_TABLES['trackback']}] (
    [cid] [numeric](10, 0) IDENTITY (1, 1) NOT NULL ,
    [sid] [varchar] (40) COLLATE SQL_Latin1_General_CP1_CI_AS NOT NULL ,
    [url] [varchar] (255) COLLATE SQL_Latin1_General_CP1_CI_AS NULL ,
    [title] [varchar] (128) COLLATE SQL_Latin1_General_CP1_CI_AS NULL ,
    [blog] [varchar] (80) COLLATE SQL_Latin1_General_CP1_CI_AS NULL ,
    [excerpt] [varchar] (5000) COLLATE SQL_Latin1_General_CP1_CI_AS NULL ,
    [date] [datetime] NULL ,
    [type] [varchar] (30) COLLATE SQL_Latin1_General_CP1_CI_AS NOT NULL ,
    [ipaddress] [varchar] (15) COLLATE SQL_Latin1_General_CP1_CI_AS NOT NULL
) ON [PRIMARY] 
";


$_SQL[] = "
CREATE TABLE [dbo].[{$_TABLES['trackbackcodes']}] (
    [code] [smallint] NOT NULL ,
    [name] [varchar] (32) COLLATE SQL_Latin1_General_CP1_CI_AS NULL
) ON [PRIMARY]
";


$_SQL[] = "
CREATE TABLE [dbo].[{$_TABLES['tzcodes']}] (
    [tz] [char] (3) COLLATE SQL_Latin1_General_CP1_CI_AS NOT NULL ,
    [offset] [int] NULL ,
    [description] [varchar] (64) COLLATE SQL_Latin1_General_CP1_CI_AS NULL
) ON [PRIMARY]
";


$_SQL[] = "
CREATE TABLE [dbo].[{$_TABLES['usercomment']}] (
    [uid] [int] NOT NULL ,
    [commentmode] [varchar] (10) COLLATE SQL_Latin1_General_CP1_CI_AS NULL ,
    [commentorder] [varchar] (4) COLLATE SQL_Latin1_General_CP1_CI_AS NULL ,
    [commentlimit] [numeric](8, 0) NULL
) ON [PRIMARY]
";


$_SQL[] = "
CREATE TABLE [dbo].[{$_TABLES['userindex']}] (
    [uid] [int] NOT NULL ,
    [tids] [varchar] (255) COLLATE SQL_Latin1_General_CP1_CI_AS NOT NULL ,
    [etids] [varchar] (5000) COLLATE SQL_Latin1_General_CP1_CI_AS NOT NULL ,
    [aids] [varchar] (255) COLLATE SQL_Latin1_General_CP1_CI_AS NOT NULL ,
    [boxes] [varchar] (255) COLLATE SQL_Latin1_General_CP1_CI_AS NOT NULL ,
    [noboxes] [smallint] NOT NULL ,
    [maxstories] [smallint] NULL
) ON [PRIMARY] 
";


$_SQL[] = "
CREATE TABLE [dbo].[{$_TABLES['userinfo']}] (
    [uid] [int] NOT NULL ,
    [about] [varchar] (5000) COLLATE SQL_Latin1_General_CP1_CI_AS NULL ,
    [location] [varchar] (96) COLLATE SQL_Latin1_General_CP1_CI_AS NULL ,
    [pgpkey] [varchar] (5000) COLLATE SQL_Latin1_General_CP1_CI_AS NULL ,
    [userspace] [varchar] (255) COLLATE SQL_Latin1_General_CP1_CI_AS NULL ,
    [tokens] [tinyint] NULL ,
    [totalcomments] [int] NULL ,
    [lastgranted] [numeric](10, 0) NULL ,
    [lastlogin] [varchar] (100) COLLATE SQL_Latin1_General_CP1_CI_AS NULL
) ON [PRIMARY] 
";


$_SQL[] = "
CREATE TABLE [dbo].[{$_TABLES['userprefs']}] (
    [uid] [int] NOT NULL ,
    [noicons] [tinyint] NULL ,
    [willing] [tinyint] NULL ,
    [dfid] [tinyint] NULL ,
    [tzid] [char] (3) COLLATE SQL_Latin1_General_CP1_CI_AS NULL ,
    [emailstories] [smallint] NULL ,
    [emailfromadmin] [smallint] NULL ,
    [emailfromuser] [smallint] NULL ,
    [showonline] [smallint] NULL
) ON [PRIMARY]
";


$_SQL[] = "
CREATE TABLE [dbo].[{$_TABLES['users']}] (
    [uid] [int] IDENTITY (1, 1) NOT NULL ,
    [username] [varchar] (16) COLLATE SQL_Latin1_General_CP1_CI_AS NOT NULL ,
    [remoteusername] [varchar] (60) COLLATE SQL_Latin1_General_CP1_CI_AS NULL ,
    [remoteservice] [varchar] (60) COLLATE SQL_Latin1_General_CP1_CI_AS NULL ,
    [fullname] [varchar] (80) COLLATE SQL_Latin1_General_CP1_CI_AS NULL ,
    [passwd] [varchar] (32) COLLATE SQL_Latin1_General_CP1_CI_AS NULL ,
    [email] [varchar] (96) COLLATE SQL_Latin1_General_CP1_CI_AS NULL ,
    [homepage] [varchar] (96) COLLATE SQL_Latin1_General_CP1_CI_AS NULL ,
    [sig] [varchar] (160) COLLATE SQL_Latin1_General_CP1_CI_AS NULL ,
    [regdate] [datetime] NULL ,
    [photo] [varchar] (128) COLLATE SQL_Latin1_General_CP1_CI_AS NULL ,
    [cookietimeout] [numeric](8, 0) NULL ,
    [theme] [varchar] (64) COLLATE SQL_Latin1_General_CP1_CI_AS NULL ,
    [language] [varchar] (64) COLLATE SQL_Latin1_General_CP1_CI_AS NULL ,
    [pwrequestid] [varchar] (16) COLLATE SQL_Latin1_General_CP1_CI_AS NULL ,
    [status] [varchar] (10) COLLATE SQL_Latin1_General_CP1_CI_AS NULL
) ON [PRIMARY]
";



$_SQL[] = "
CREATE TABLE [dbo].[{$_TABLES['vars']}] (
    [name] [varchar] (20) COLLATE SQL_Latin1_General_CP1_CI_AS NOT NULL ,
    [value] [varchar] (128) COLLATE SQL_Latin1_General_CP1_CI_AS NULL
) ON [PRIMARY]
";



$_SQL[] = "ALTER TABLE [dbo].[{$_TABLES['access']}] ADD
    CONSTRAINT [PK_gl_access] PRIMARY KEY  CLUSTERED
    (
        [acc_ft_id],
        [acc_grp_id]
    )  ON [PRIMARY]
";



$_SQL[] = "ALTER TABLE [dbo].[{$_TABLES['article_images']}] ADD
    CONSTRAINT [PK_gl_article_images] PRIMARY KEY  CLUSTERED
    (
        [ai_sid],
        [ai_img_num]
    )  ON [PRIMARY]
";



$_SQL[] = "ALTER TABLE [dbo].[{$_TABLES['blocks']}] ADD
    CONSTRAINT [DF_gl_blocks_type] DEFAULT ('normal') FOR [type],
    CONSTRAINT [DF_gl_blocks_tid] DEFAULT ('All') FOR [tid],
    CONSTRAINT [DF_gl_blocks_blockorder] DEFAULT (1) FOR [blockorder],
    CONSTRAINT [DF_gl_blocks_content] DEFAULT (null) FOR [content],
    CONSTRAINT [DF_gl_blocks_rdfupdated] DEFAULT (getdate()) FOR [rdfupdated],
    CONSTRAINT [DF_gl_blocks_rdflimit] DEFAULT (0) FOR [rdflimit],
    CONSTRAINT [DF_gl_blocks_onleft] DEFAULT (1) FOR [onleft],
    CONSTRAINT [DF_gl_blocks_owner_id] DEFAULT (1) FOR [owner_id],
    CONSTRAINT [DF_gl_blocks_group_id] DEFAULT (1) FOR [group_id],
    CONSTRAINT [DF_gl_blocks_perm_owner] DEFAULT (3) FOR [perm_owner],
    CONSTRAINT [DF_gl_blocks_perm_group] DEFAULT (3) FOR [perm_group],
    CONSTRAINT [DF_gl_blocks_perm_members] DEFAULT (2) FOR [perm_members],
    CONSTRAINT [DF_gl_blocks_perm_anon] DEFAULT (2) FOR [perm_anon],
    CONSTRAINT [DF_gl_blocks_allow_autotags] DEFAULT (0) FOR [allow_autotags],
    CONSTRAINT [PK_gl_blocks] PRIMARY KEY  CLUSTERED
    (
        [bid]
    )  ON [PRIMARY]
";

$_SQL[] = "ALTER TABLE [dbo].[{$_TABLES['commentcodes']}] ADD
    CONSTRAINT [PK_gl_commentcodes] PRIMARY KEY  CLUSTERED
    (
        [code]
    )  ON [PRIMARY]
";

$_SQL[] = "ALTER TABLE [dbo].[{$_TABLES['commentmodes']}] ADD
    CONSTRAINT [PK_gl_commentmodes] PRIMARY KEY  CLUSTERED
    (
        [mode]
    )  ON [PRIMARY]
";

$_SQL[] = "ALTER TABLE [dbo].[{$_TABLES['comments']}] ADD
    CONSTRAINT [PK_gl_comments] PRIMARY KEY  CLUSTERED
    (
        [cid]
    )  ON [PRIMARY]
";

$_SQL[] = "ALTER TABLE [dbo].[{$_TABLES['cookiecodes']}] ADD
    CONSTRAINT [PK_gl_cookiecodes] PRIMARY KEY  CLUSTERED
    (
        [cc_value]
    )  ON [PRIMARY]
";

$_SQL[] = "ALTER TABLE [dbo].[{$_TABLES['dateformats']}] ADD
    CONSTRAINT [PK_gl_dateformats] PRIMARY KEY  CLUSTERED
    (
        [dfid]
    )  ON [PRIMARY]
";

$_SQL[] = "ALTER TABLE [dbo].[{$_TABLES['events']}] ADD
    CONSTRAINT [PK_gl_events] PRIMARY KEY  CLUSTERED
    (
        [eid]
    )  ON [PRIMARY]
";

$_SQL[] = "ALTER TABLE [dbo].[{$_TABLES['eventsubmission']}] ADD
    CONSTRAINT [PK_gl_eventsubmission] PRIMARY KEY  CLUSTERED
    (
        [eid]
    )  ON [PRIMARY]
";

$_SQL[] = "ALTER TABLE [dbo].[{$_TABLES['featurecodes']}] ADD
    CONSTRAINT [PK_gl_featurecodes] PRIMARY KEY  CLUSTERED
    (
        [code]
    )  ON [PRIMARY]
";

$_SQL[] = "ALTER TABLE [dbo].[{$_TABLES['features']}] ADD
    CONSTRAINT [DF_gl_features_ft_gl_core] DEFAULT (0) FOR [ft_gl_core],
    CONSTRAINT [PK_gl_features] PRIMARY KEY  CLUSTERED
    (
        [ft_id]
    )  ON [PRIMARY]
";

$_SQL[] = "ALTER TABLE [dbo].[{$_TABLES['frontpagecodes']}] ADD
    CONSTRAINT [PK_gl_frontpagecodes] PRIMARY KEY  CLUSTERED
    (
        [code]
    )  ON [PRIMARY]
";

$_SQL[] = "ALTER TABLE [dbo].[{$_TABLES['groups']}] ADD
    CONSTRAINT [DF_gl_groups_grp_gl_core] DEFAULT (0) FOR [grp_gl_core],
    CONSTRAINT [PK_gl_groups] PRIMARY KEY  CLUSTERED
    (
        [grp_id]
    )  ON [PRIMARY]
";


$_SQL[] = "ALTER TABLE [dbo].[{$_TABLES['links']}] ADD
    CONSTRAINT [DF_gl_links_perm_group] DEFAULT (3) FOR [perm_group],
    CONSTRAINT [DF_gl_links_perm_anon] DEFAULT (2) FOR [perm_anon],
    CONSTRAINT [DF_gl_links_perm_members] DEFAULT (2) FOR [perm_members],
    CONSTRAINT [DF_gl_links_perm_owner] DEFAULT (3) FOR [perm_owner],
    CONSTRAINT [DF_gl_links_hits] DEFAULT (0) FOR [hits],
    CONSTRAINT [PK_gl_links] PRIMARY KEY  CLUSTERED
    (
        [lid]
    )  ON [PRIMARY]
";

$_SQL[] = "ALTER TABLE [dbo].[{$_TABLES['linksubmission']}] ADD
    CONSTRAINT [PK_gl_linksubmission] PRIMARY KEY  CLUSTERED
    (
        [lid]
    )  ON [PRIMARY]
";

$_SQL[] = "ALTER TABLE [dbo].[{$_TABLES['maillist']}] ADD
    CONSTRAINT [PK_gl_maillist] PRIMARY KEY  CLUSTERED
    (
        [code]
    )  ON [PRIMARY]
";

$_SQL[] = "ALTER TABLE [dbo].[{$_TABLES['personal_events']}] ADD
    CONSTRAINT [PK_gl_personal_events] PRIMARY KEY  CLUSTERED
    (
        [eid],
        [uid]
    )  ON [PRIMARY]
";

$_SQL[] = "ALTER TABLE [dbo].[{$_TABLES['pingservice']}] ADD
    CONSTRAINT [PK_gl_pingservice] PRIMARY KEY  CLUSTERED
    (
        [pid]
    )  ON [PRIMARY]
";

$_SQL[] = "ALTER TABLE [dbo].[{$_TABLES['plugins']}] ADD
    CONSTRAINT [PK_gl_plugins] PRIMARY KEY  CLUSTERED
    (
        [pi_name]
    )  ON [PRIMARY]
";

$_SQL[] = "ALTER TABLE [dbo].[{$_TABLES['pollanswers']}] ADD
    CONSTRAINT [PK_gl_pollanswers] PRIMARY KEY  CLUSTERED
    (
        [qid],
        [aid]
    )  ON [PRIMARY]
";

$_SQL[] = "ALTER TABLE [dbo].[{$_TABLES['pollquestions']}] ADD
    CONSTRAINT [PK_gl_pollquestions] PRIMARY KEY  CLUSTERED
    (
        [qid]
    )  ON [PRIMARY]
";

$_SQL[] = "ALTER TABLE [dbo].[{$_TABLES['pollvoters']}] ADD
    CONSTRAINT [PK_gl_pollvoters] PRIMARY KEY  CLUSTERED
    (
        [id]
    )  ON [PRIMARY]
";

$_SQL[] = "ALTER TABLE [dbo].[{$_TABLES['postmodes']}] ADD
    CONSTRAINT [PK_gl_postmodes] PRIMARY KEY  CLUSTERED
    (
        [code]
    )  ON [PRIMARY]
";

$_SQL[] = "ALTER TABLE [dbo].[{$_TABLES['sessions']}] ADD
    CONSTRAINT [PK_gl_sessions] PRIMARY KEY  CLUSTERED
    (
        [sess_id]
    )  ON [PRIMARY]
";

$_SQL[] = "ALTER TABLE [dbo].[{$_TABLES['speedlimit']}] ADD
    CONSTRAINT [PK_gl_speedlimit] PRIMARY KEY  CLUSTERED
    (
        [id]
    )  ON [PRIMARY]
";

$_SQL[] = "ALTER TABLE [dbo].[{$_TABLES['staticpage']}] ADD
    CONSTRAINT [DF_gl_staticpage] DEFAULT ('html') FOR [postmode],
    CONSTRAINT [PK_gl_staticpage] PRIMARY KEY  CLUSTERED
    (
        [sp_id]
    )  ON [PRIMARY]
";

$_SQL[] = "ALTER TABLE [dbo].[{$_TABLES['statuscodes']}] ADD
    CONSTRAINT [PK_gl_statuscodes] PRIMARY KEY  CLUSTERED
    (
        [code]
    )  ON [PRIMARY]
";

$_SQL[] = "ALTER TABLE [dbo].[{$_TABLES['stories']}] ADD
    CONSTRAINT [DF_gl_stories_uid] DEFAULT (1) FOR [uid],
    CONSTRAINT [DF_gl_stories_draft_flag] DEFAULT (0) FOR [draft_flag],
    CONSTRAINT [DF_gl_stories_tid] DEFAULT ('General') FOR [tid],
    CONSTRAINT [DF_gl_stories_hits] DEFAULT (0) FOR [hits],
    CONSTRAINT [DF_gl_stories_comments] DEFAULT (0) FOR [comments],
    CONSTRAINT [DF_gl_stories_trackbacks] DEFAULT (0) FOR [trackbacks],
    CONSTRAINT [DF_gl_stories_featured] DEFAULT (0) FOR [featured],
    CONSTRAINT [DF_gl_stories_show_topic_icon] DEFAULT (1) FOR [show_topic_icon],
    CONSTRAINT [DF_gl_stories_commentcode] DEFAULT (0) FOR [commentcode],
    CONSTRAINT [DF_gl_stories_trackbackcode] DEFAULT (0) FOR [trackbackcode],
    CONSTRAINT [DF_gl_stories_statuscode] DEFAULT (0) FOR [statuscode],
    CONSTRAINT [DF_gl_stories_expire] DEFAULT (getdate()) FOR [expire],
    CONSTRAINT [DF_gl_stories_postmode] DEFAULT ('html') FOR [postmode],
    CONSTRAINT [DF_gl_stories_owner_id] DEFAULT (1) FOR [owner_id],
    CONSTRAINT [DF_gl_stories_group_id] DEFAULT (2) FOR [group_id],
    CONSTRAINT [DF_gl_stories_perm_owner] DEFAULT (3) FOR [perm_owner],
    CONSTRAINT [DF_gl_stories_perm_group] DEFAULT (3) FOR [perm_group],
    CONSTRAINT [DF_gl_stories_perm_members] DEFAULT (2) FOR [perm_members],
    CONSTRAINT [DF_gl_stories_perm_anon] DEFAULT (2) FOR [perm_anon],
    CONSTRAINT [DF_gl_stories_advanced_editor_mode] DEFAULT (0) FOR [advanced_editor_mode],
    CONSTRAINT [PK_gl_stories] PRIMARY KEY  CLUSTERED
    (
        [sid]
    )  ON [PRIMARY]
";

$_SQL[] = "ALTER TABLE [dbo].[{$_TABLES['storysubmission']}] ADD
    CONSTRAINT [PK_gl_storysubmission] PRIMARY KEY  CLUSTERED
    (
        [sid]
    )  ON [PRIMARY]
";

$_SQL[] = "ALTER TABLE [dbo].[{$_TABLES['syndication']}] ADD
    CONSTRAINT [PK_gl_syndication] PRIMARY KEY  CLUSTERED
    (
        [fid]
    )  ON [PRIMARY]
";

$_SQL[] = "ALTER TABLE [dbo].[{$_TABLES['topics']}] ADD
    CONSTRAINT [DF_gl_topics_is_default] DEFAULT (0) FOR [is_default],
    CONSTRAINT [PK_gl_topics] PRIMARY KEY  CLUSTERED
    (
        [tid]
    )  ON [PRIMARY]
";

$_SQL[] = "ALTER TABLE [dbo].[{$_TABLES['trackback']}] ADD
    CONSTRAINT [PK_gl_trackback] PRIMARY KEY  CLUSTERED
    (
        [cid]
    )  ON [PRIMARY]
";

$_SQL[] = "ALTER TABLE [dbo].[{$_TABLES['trackbackcodes']}] ADD
    CONSTRAINT [PK_gl_trackbackcodes] PRIMARY KEY  CLUSTERED
    (
        [code]
    )  ON [PRIMARY]
";

$_SQL[] = "ALTER TABLE [dbo].[{$_TABLES['tzcodes']}] ADD
    CONSTRAINT [PK_gl_tzcodes] PRIMARY KEY  CLUSTERED
    (
        [tz]
    )  ON [PRIMARY]
";

$_SQL[] = "ALTER TABLE [dbo].[{$_TABLES['usercomment']}] ADD
    CONSTRAINT [PK_gl_usercomment] PRIMARY KEY  CLUSTERED
    (
        [uid]
    )  ON [PRIMARY]
";

$_SQL[] = "ALTER TABLE [dbo].[{$_TABLES['userindex']}] ADD
    CONSTRAINT [DF_gl_userindex_boxes] DEFAULT (0) FOR [boxes],
    CONSTRAINT [DF_gl_userindex_noboxes] DEFAULT (0) FOR [noboxes],
    CONSTRAINT [DF_gl_userindex_tids] DEFAULT ('0') FOR [tids],
    CONSTRAINT [DF_gl_userindex_etids] DEFAULT ('0') FOR [etids],
    CONSTRAINT [DF_gl_userindex_aids] DEFAULT ('0') FOR [aids],
    CONSTRAINT [PK_gl_userindex] PRIMARY KEY  CLUSTERED
    (
        [uid]
    )  ON [PRIMARY]
";

$_SQL[] = "ALTER TABLE [dbo].[{$_TABLES['userinfo']}] ADD
    CONSTRAINT [PK_gl_userinfo] PRIMARY KEY  CLUSTERED
    (
        [uid]
    )  ON [PRIMARY]
";

$_SQL[] = "ALTER TABLE [dbo].[{$_TABLES['userprefs']}] ADD
    CONSTRAINT [DF_gl_userprefs_noicons] DEFAULT (0) FOR [noicons],
    CONSTRAINT [DF_gl_userprefs_willing] DEFAULT (0) FOR [willing],
    CONSTRAINT [DF_gl_userprefs_dfid] DEFAULT (0) FOR [dfid],
    CONSTRAINT [DF_gl_userprefs_emailstories] DEFAULT (0) FOR [emailstories],
    CONSTRAINT [DF_gl_userprefs_emailfromadmin] DEFAULT (0) FOR [emailfromadmin],
    CONSTRAINT [DF_gl_userprefs_emailfromuser] DEFAULT (0) FOR [emailfromuser],
    CONSTRAINT [DF_gl_userprefs_showonline] DEFAULT (0) FOR [showonline],
    CONSTRAINT [PK_gl_userprefs] PRIMARY KEY  CLUSTERED
    (
        [uid]
    )  ON [PRIMARY]
";


$_SQL[] = "ALTER TABLE [dbo].[{$_TABLES['users']}] ADD
    CONSTRAINT [DF_gl_users_status] DEFAULT ('1') FOR [status],
    CONSTRAINT [PK_gl_users] PRIMARY KEY  CLUSTERED
    (
        [username]
    )  ON [PRIMARY]
";


$_SQL[] = "ALTER TABLE [dbo].[{$_TABLES['vars']}] ADD
    CONSTRAINT [PK_gl_vars] PRIMARY KEY  CLUSTERED
    (
        [name]
    )  ON [PRIMARY]
";









$_SQL[] = "CREATE VIEW dbo.getPrimaryKey
AS

SELECT  SC.name as colName,  SO.name as tableName,
    case when sc.status=128 then '1' else '0' end as isIdentity
FROM    sysobjects SO,
        sysobjects SPK,
        sysindexes SI,
        sysindexkeys SIK,
        syscolumns SC
WHERE

SO.xtype = 'U'
AND     SO.id = SPK.parent_obj
AND     SPK.xtype = 'PK'
AND     SO.id = SI.id
AND     SPK.name = SI.name
AND     SO.id = SIK.id
AND     SI.indid = SIK.indid
AND     SO.id = SC.id
AND     SIK.colid = SC.colid





";


$_SQL[] = "CREATE VIEW dbo.getdateView
AS
SELECT     GETUTCDATE() AS getdate

";










$_SQL[] = "CREATE function DATE_FORMAT(@d as varchar(100)='', @f as varchar(100))
returns varchar(1000)

BEGIN
declare
@tempVar as         varchar(100),
@workingString as   varchar(100),
@mysqlCommand       varchar(10),
@sqlCommand     varchar(10),
@isDateName     bit,
@isDatePart     bit,
@retval         varchar(100),
@sql            varchar(1000),
@currentChar        char(1),
@nextChar       char(1),
@procOutput     varchar(100),
@counter        int,
@mode           int,
@count          int


if @d='' or @d is null      --date is null/empty.. fill it in for this poor person..
    begin
        select @d=getdate from getDateView
    end

set @workingString=@f

--workingString now holds the desired date format
--we have to loop thru that string, detecting % followed by a command
--anything that is not a % sign or %% will be represented as a literal and
--returned to the output string

--if it is a command, due to limitations in UDFs we're going to pass the sql command
--to a stored proc for conversion..


-------------------------------------------------------------------------------------
set @retval = ''
set @mode=0
set @counter=1
while @counter<=len(@workingString)
begin
    select @currentChar=substring(@workingString,@counter,1)

    if @currentChar='%'--we may have a command here
     begin
        select @nextChar=substring(@workingString,@counter+1,1)
        set @mysqlCommand=@currentChar + @nextChar
        select @count=count(*) from dateCommandCrossReference where mysqlCommand=@mysqlCommand  COLLATE Latin1_General_CS_AS

        if @count>0  -- there most certainly is a command here.. do the conversion now...
         begin

            select @retval = @retval + (case @mysqlCommand COLLATE Latin1_General_CS_AS
                when '%a' then  datename(weekday,@d)
                when '%b' then  datename(month,@d)
                when '%c' then  cast(datepart(mm,@d) as varchar(25))
                when '%D' then  cast(datepart(d,@d) as varchar(25))
                when '%d' then  cast(datepart(d,@d) as varchar(25))
                when '%e' then  cast(datepart(d,@d) as varchar(25))
                when '%f' then  cast(datepart(ms,@d) as varchar(25))
                when '%H' then  cast(datepart(hh,@d) as varchar(25))
                when '%h' then  cast(datepart(hh,@d) as varchar(25))
                when '%I' then  cast(datepart(mi,@d) as varchar(25))
                when '%i' then  cast(datepart(mi,@d) as varchar(25))
                when '%j' then  cast(datename(dayofyear,@d) as varchar(25))
                when '%k' then  cast(datepart(hh,@d) as varchar(25))
                when '%l' then  cast(datepart(hh,@d) as varchar(25))
                when '%M' then  cast(datename(month,@d) as varchar(25))
                when '%m' then  cast(datepart(mm,@d) as varchar(25))
                when '%p' then  ''
                when '%r' then  ''
                when '%S' then  cast(datepart(s,@d) as varchar(25))
                when '%s' then  cast(datepart(s,@d) as varchar(25))
                when '%T' then  ''
                when '%U' then  cast(datepart(week,@d) as varchar(25))
                when '%u' then  cast(datepart(week,@d) as varchar(25))
                when '%V' then  cast(datepart(week,@d) as varchar(25))
                when '%v' then  cast(datepart(week,@d) as varchar(25))
                when '%W' then  cast(datename(dw,@d) as varchar(25))
                when '%w' then  cast(datepart(dw,@d) as varchar(25))
                when '%X' then  cast(datepart(year,@d) as varchar(25))
                when '%x' then  cast(datepart(year,@d) as varchar(25))
                when '%Y' then  cast(datepart(year,@d) as varchar(25))
                when '%y' then  cast(datepart(year,@d) as varchar(25))

                when '%%' then  '%'


            end)
            set @counter=@counter+1
         end
        else
         begin

            select @retval = @retval + @currentChar
         end



     end
    else --no command here..
     begin

        select @retval=@retval + @currentChar
     end
    set @counter=@counter+1
end





return @retval
END


";





$_SQL[] = "CREATE function DESCRIBE(@d as varchar(100)='')
RETURNS table AS

RETURN
(select top 1000 a.name as Field, c.name +'(' + cast(a.prec as varchar) + ')' as Type,
case when a.status=(0x08) then 'NULL' else '' end as [Null],
' ' as [Key],
' ' as [Default],
' ' as [Extra]
from syscolumns a
join sysobjects b on a.id=b.id
join systypes c on a.xtype=c.xtype
where b.name = @d
order by colorder asc)







";




$_SQL[] = "CREATE function FROM_UNIXTIME(@d as varchar(100)='')
RETURNS varchar(100) AS
BEGIN
declare
@retval varchar(100),
@testDate   varchar(100)



if @d is Null or @d=''
    begin
        SELECT @retval=''

    end
else
    begin


        SELECT @retval=cast(year(dateadd(SECOND, cast( @d as bigint) ,'19700101') ) as varchar(10)) + '-'



    select @testDate=cast( month(dateadd(SECOND, cast( @d as bigint) ,'19700101') ) as varchar(10))
    if len(@testDate)<2
        begin
        select @testDate='0' + @testDate
        end
    select @retval = @retval + @testDate + '-'

    select @testDate=cast( day(dateadd(SECOND, cast( @d as bigint) ,'19700101') ) as varchar(10))
    if len(@testDate)<2
        begin
        select @testDate='0' + @testDate
        end
    select @retval = @retval + @testDate + ' '



    select @testDate=cast( DATEPART(hour, dateadd(SECOND, cast( @d as bigint) ,'19700101'))   as varchar(10))
    if len(@testDate)<2
        begin
        select @testDate='0' + @testDate
        end
    select @retval = @retval + @testDate + ':'


    select @testDate=cast( DATEPART(mi, dateadd(SECOND, cast( @d as bigint) ,'19700101'))   as varchar(10))
    if len(@testDate)<2
        begin
        select @testDate='0' + @testDate
        end
    select @retval = @retval + @testDate + ':'


    select @testDate=cast( DATEPART(s, dateadd(SECOND, cast( @d as bigint) ,'19700101'))   as varchar(10))
    if len(@testDate)<2
        begin
        select @testDate='0' + @testDate
        end
    select @retval = @retval + @testDate

    end


return @retval
END


";



$_SQL[] = "CREATE function TO_DAYS(@d as varchar(100)='')
RETURNS int AS
BEGIN
declare
@retval varchar(100),
@testDate   varchar(100)


if @d is Null or @d=''
    begin
        SELECT @retval=NULL

    end
else
    begin
        SELECT @retval=DATEDIFF(day, '19700101', @d)
    end


return cast(@retval as integer)
END

";


$_SQL[] = "CREATE function UNIX_TIMESTAMP(@d as varchar(100)='')
RETURNS varchar(100) AS
BEGIN
declare
@retval varchar(100),
@testDate   dateTime


if @d is Null or @d=''
    begin
        select @testDate=[getdate] from getdateView
        SELECT @retval=DATEDIFF(s, '1970-01-01 00:00:00.000', @testDate)

    end
else
    begin
        SELECT @retval=DATEDIFF(SECOND, '1970-01-01 00:00:00.000', @d)
    end


return @retval
END

";





$_SQL[] = "CREATE    PROCEDURE dbo.doIndexInsert

@table      varchar(256),
@cols       varchar(5000),
@vals       varchar(8000)

AS
begin

declare
@isIdentity     int,
@sql            varchar(8000),
@isIdentityListed   int,
@tempCols       varchar(8000)

select @tempCols=replace(@cols,',', ''',''')
set @sql='select colName from getPrimaryKey where tableName=''' + @table + ''' and colname in (''' + @tempCols + ''')'
exec (@sql)
set  @isIdentityListed=@@ROWCOUNT



select @isIdentity=isIdentity
from getPrimaryKey
where tableName=@table
select @vals=replace(@vals,'\\\"', '''''')
select @vals=replace(@vals,'\"', '''')

if @isIdentity=1
    begin
        --this is an identity insert
        if @isIdentityListed>0
            begin
                set @sql='set IDENTITY_INSERT ' + @table + ' ON; INSERT INTO ' + @table + ' (' + @cols + ') values (' + @vals + ')'
            end
        else
            begin
                set @sql='INSERT INTO ' + @table + ' (' + @cols + ') values (' + @vals + ')'
            end

    end
else
    begin
        set @sql='INSERT INTO ' + @table + ' (' + @cols + ') values (' + @vals + ')'
    end

print @sql

exec (@sql)


end






";


$_SQL[] = "CREATE TRIGGER FixBoxes ON [dbo].[{$_TABLES['userindex']}]
FOR INSERT, UPDATE
AS
update gl_userindex
set boxes='0' where boxes=''


update gl_userindex
set noboxes='0' where noboxes=''

update gl_userindex
set aids='0' where aids=''

update gl_userindex
set tids='0' where tids=''

";



$_SQL[] = "CREATE TRIGGER fixContext ON [dbo].[{$_TABLES['blocks']}]
FOR INSERT, UPDATE
AS

update {$_TABLES['blocks']}
set content=NULL
where content like''
";



$_SQL[] = "CREATE TRIGGER fixPhoto ON dbo.gl_users
FOR INSERT, UPDATE
AS

update gl_users
set photo=null
where photo=''

";




$_SQL[] = "INSERT INTO {$_TABLES['access']} (acc_ft_id, acc_grp_id) VALUES (1,3)";
$_SQL[] = "INSERT INTO {$_TABLES['access']} (acc_ft_id, acc_grp_id) VALUES (2,3)";
$_SQL[] = "INSERT INTO {$_TABLES['access']} (acc_ft_id, acc_grp_id) VALUES (3,5)";
$_SQL[] = "INSERT INTO {$_TABLES['access']} (acc_ft_id, acc_grp_id) VALUES (4,5)";
$_SQL[] = "INSERT INTO {$_TABLES['access']} (acc_ft_id, acc_grp_id) VALUES (5,9)";
$_SQL[] = "INSERT INTO {$_TABLES['access']} (acc_ft_id, acc_grp_id) VALUES (5,11)";
$_SQL[] = "INSERT INTO {$_TABLES['access']} (acc_ft_id, acc_grp_id) VALUES (6,9)";
$_SQL[] = "INSERT INTO {$_TABLES['access']} (acc_ft_id, acc_grp_id) VALUES (6,11)";
$_SQL[] = "INSERT INTO {$_TABLES['access']} (acc_ft_id, acc_grp_id) VALUES(7,12)";
$_SQL[] = "INSERT INTO {$_TABLES['access']} (acc_ft_id, acc_grp_id) VALUES (8,7)";
$_SQL[] = "INSERT INTO {$_TABLES['access']} (acc_ft_id, acc_grp_id) VALUES (9,7)";
$_SQL[] = "INSERT INTO {$_TABLES['access']} (acc_ft_id, acc_grp_id) VALUES (10,4)";
$_SQL[] = "INSERT INTO {$_TABLES['access']} (acc_ft_id, acc_grp_id) VALUES (11,6)";
$_SQL[] = "INSERT INTO {$_TABLES['access']} (acc_ft_id, acc_grp_id) VALUES (12,8)";
$_SQL[] = "INSERT INTO {$_TABLES['access']} (acc_ft_id, acc_grp_id) VALUES (13,10)";
$_SQL[] = "INSERT INTO {$_TABLES['access']} (acc_ft_id, acc_grp_id) VALUES (14,11)";
$_SQL[] = "INSERT INTO {$_TABLES['access']} (acc_ft_id, acc_grp_id) VALUES (15,11)";
$_SQL[] = "INSERT INTO {$_TABLES['access']} (acc_ft_id, acc_grp_id) VALUES (16,4)";
$_SQL[] = "INSERT INTO {$_TABLES['access']} (acc_ft_id, acc_grp_id) VALUES (17,14)";
$_SQL[] = "INSERT INTO {$_TABLES['access']} (acc_ft_id, acc_grp_id) VALUES (18,14)";
$_SQL[] = "INSERT INTO {$_TABLES['access']} (acc_ft_id, acc_grp_id) VALUES (23,15)";
$_SQL[] = "INSERT INTO {$_TABLES['access']} (acc_ft_id, acc_grp_id) VALUES (24,3)";
$_SQL[] = "INSERT INTO {$_TABLES['access']} (acc_ft_id, acc_grp_id) VALUES (25,17)";

$_SQL[] = "
set identity_insert {$_TABLES['blocks']} on


INSERT INTO {$_TABLES['blocks']} (bid, is_enabled, name, type, title, tid, blockorder, content, rdfurl, rdfupdated, onleft, phpblockfn, group_id, owner_id, perm_owner, perm_group, perm_members, perm_anon) VALUES (1,1,'user_block','gldefault','User Functions','all',2,'','',getdate(),1,'',4,2,3,3,2,2)
INSERT INTO {$_TABLES['blocks']} (bid, is_enabled, name, type, title, tid, blockorder, content, rdfurl, rdfupdated, onleft, phpblockfn, group_id, owner_id, perm_owner, perm_group, perm_members, perm_anon) VALUES (2,1,'admin_block','gldefault','Admins Only','all',1,'','',getdate(),1,'',4,2,3,3,2,2)
INSERT INTO {$_TABLES['blocks']} (bid, is_enabled, name, type, title, tid, blockorder, content, rdfurl, rdfupdated, onleft, phpblockfn, group_id, owner_id, perm_owner, perm_group, perm_members, perm_anon) VALUES (3,1,'section_block','gldefault','Topics','all',0,'','',getdate(),1,'',4,2,3,3,2,2)
INSERT INTO {$_TABLES['blocks']} (bid, is_enabled, name, type, title, tid, blockorder, content, rdfurl, rdfupdated, onleft, phpblockfn, group_id, owner_id, perm_owner, perm_group, perm_members, perm_anon) VALUES (4,1,'polls_block','phpblock','Poll','all',2,'','',getdate(),0,'phpblock_polls',4,2,3,3,2,2)
INSERT INTO {$_TABLES['blocks']} (bid, is_enabled, name, type, title, tid, blockorder, content, rdfurl, rdfupdated, onleft, phpblockfn, group_id, owner_id, perm_owner, perm_group, perm_members, perm_anon) VALUES (5,1,'events_block','phpblock','Events','all',4,'','',getdate(),1,'phpblock_calendar',1,2,3,3,2,2)
INSERT INTO {$_TABLES['blocks']} (bid, is_enabled, name, type, title, tid, blockorder, content, rdfurl, rdfupdated, onleft, phpblockfn, group_id, owner_id, perm_owner, perm_group, perm_members, perm_anon) VALUES (6,1,'whats_new_block','gldefault','What''s New','all',3,'','',getdate(),0,'',4,2,3,3,2,2)
INSERT INTO {$_TABLES['blocks']} (bid, is_enabled, name, type, title, tid, blockorder, content, rdfurl, rdfupdated, onleft, phpblockfn, group_id, owner_id, perm_owner, perm_group, perm_members, perm_anon) VALUES (7,1,'first_block','normal','About GeekLog','homeonly',1,'<p><b>Welcome to GeekLog!</b><p>If you''re already familiar with GeekLog - and especially if you''re not: There have been many improvements to GeekLog since earlier versions that you might want to read up on. Please read the <a href=\"docs/changes.html\">release notes</a>. If you need help, please see the <a href=\"docs/support.html\">support options</a>.','',getdate(),0,'',4,2,3,3,2,2)
INSERT INTO {$_TABLES['blocks']} (bid, is_enabled, name, type, title, tid, blockorder, content, rdfurl, rdfupdated, onleft, phpblockfn, group_id, owner_id, perm_owner, perm_group, perm_members, perm_anon) VALUES (8,1,'whosonline_block','phpblock','Who''s Online','all',0,'','',getdate(),0,'phpblock_whosonline',4,2,3,3,2,2)
INSERT INTO {$_TABLES['blocks']} (bid, is_enabled, name, type, title, tid, blockorder, content, rdfurl, rdfupdated, onleft, phpblockfn, group_id, owner_id, perm_owner, perm_group, perm_members, perm_anon) VALUES (9,1,'older_stories','gldefault','Older Stories','all',5,'','',getdate(),1,'',4,2,3,3,2,2)


set identity_insert {$_TABLES['blocks']} off
";


$_SQL[] = "INSERT INTO {$_TABLES['commentcodes']} (code, name) VALUES (0,'Comments Enabled')";
$_SQL[] = "INSERT INTO {$_TABLES['commentcodes']} (code, name) VALUES (-1,'Comments Disabled')";

$_SQL[] = "INSERT INTO {$_TABLES['commentmodes']} (mode, name) VALUES ('flat','Flat')";
$_SQL[] = "INSERT INTO {$_TABLES['commentmodes']} (mode, name) VALUES ('nested','Nested')";
$_SQL[] = "INSERT INTO {$_TABLES['commentmodes']} (mode, name) VALUES ('threaded','Threaded')";
$_SQL[] = "INSERT INTO {$_TABLES['commentmodes']} (mode, name) VALUES ('nocomment','No Comments')";

$_SQL[] = "INSERT INTO {$_TABLES['cookiecodes']} (cc_value, cc_descr) VALUES (0,'(don''t)')";
$_SQL[] = "INSERT INTO {$_TABLES['cookiecodes']} (cc_value, cc_descr) VALUES (3600,'1 Hour')";
$_SQL[] = "INSERT INTO {$_TABLES['cookiecodes']} (cc_value, cc_descr) VALUES (7200,'2 Hours')";
$_SQL[] = "INSERT INTO {$_TABLES['cookiecodes']} (cc_value, cc_descr) VALUES (10800,'3 Hours')";
$_SQL[] = "INSERT INTO {$_TABLES['cookiecodes']} (cc_value, cc_descr) VALUES (28800,'8 Hours')";
$_SQL[] = "INSERT INTO {$_TABLES['cookiecodes']} (cc_value, cc_descr) VALUES (86400,'1 Day')";
$_SQL[] = "INSERT INTO {$_TABLES['cookiecodes']} (cc_value, cc_descr) VALUES (604800,'1 Week')";
$_SQL[] = "INSERT INTO {$_TABLES['cookiecodes']} (cc_value, cc_descr) VALUES (2678400,'1 Month')";

$_SQL[] = "INSERT INTO {$_TABLES['dateformats']} (dfid, format, description) VALUES (0,'','System Default')";
$_SQL[] = "INSERT INTO {$_TABLES['dateformats']} (dfid, format, description) VALUES (1,'%A %B %d, %Y @%I:%M%p','Sunday March 21, 1999 @10:00PM')";
$_SQL[] = "INSERT INTO {$_TABLES['dateformats']} (dfid, format, description) VALUES (2,'%A %b %d, %Y @%H:%M','Sunday March 21, 1999 @22:00')";
$_SQL[] = "INSERT INTO {$_TABLES['dateformats']} (dfid, format, description) VALUES (4,'%A %b %d @%H:%M','Sunday March 21 @22:00')";
$_SQL[] = "INSERT INTO {$_TABLES['dateformats']} (dfid, format, description) VALUES (5,'%H:%M %d %B %Y','22:00 21 March 1999')";
$_SQL[] = "INSERT INTO {$_TABLES['dateformats']} (dfid, format, description) VALUES (6,'%H:%M %A %d %B %Y','22:00 Sunday 21 March 1999')";
$_SQL[] = "INSERT INTO {$_TABLES['dateformats']} (dfid, format, description) VALUES (7,'%I:%M%p - %A %B %d %Y','10:00PM -- Sunday March 21 1999')";
$_SQL[] = "INSERT INTO {$_TABLES['dateformats']} (dfid, format, description) VALUES (8,'%a %B %d, %I:%M%p','Sun March 21, 10:00PM')";
$_SQL[] = "INSERT INTO {$_TABLES['dateformats']} (dfid, format, description) VALUES (9,'%a %B %d, %H:%M','Sun March 21, 22:00')";
$_SQL[] = "INSERT INTO {$_TABLES['dateformats']} (dfid, format, description) VALUES (10,'%m-%d-%y %H:%M','3-21-99 22:00')";
$_SQL[] = "INSERT INTO {$_TABLES['dateformats']} (dfid, format, description) VALUES (11,'%d-%m-%y %H:%M','21-3-99 22:00')";
$_SQL[] = "INSERT INTO {$_TABLES['dateformats']} (dfid, format, description) VALUES (12,'%m-%d-%y %I:%M%p','3-21-99 10:00PM')";
$_SQL[] = "INSERT INTO {$_TABLES['dateformats']} (dfid, format, description) VALUES (13,'%I:%M%p  %B %D, %Y','10:00PM  March 21st, 1999')";
$_SQL[] = "INSERT INTO {$_TABLES['dateformats']} (dfid, format, description) VALUES (14,'%a %b %d, ''%y %I:%M%p','Sun Mar 21, ''99 10:00PM')";
$_SQL[] = "INSERT INTO {$_TABLES['dateformats']} (dfid, format, description) VALUES (15,'Day %j, %I ish','Day 80, 10 ish')";
$_SQL[] = "INSERT INTO {$_TABLES['dateformats']} (dfid, format, description) VALUES (16,'%y-%m-%d %I:%M','99-03-21 10:00')";
$_SQL[] = "INSERT INTO {$_TABLES['dateformats']} (dfid, format, description) VALUES (17,'%d/%m/%y %H:%M','21/03/99 22:00')";
$_SQL[] = "INSERT INTO {$_TABLES['dateformats']} (dfid, format, description) VALUES (18,'%a %d %b %I:%M%p','Sun 21 Mar 10:00PM')";

$_SQL[] = "INSERT INTO {$_TABLES['eventsubmission']} (eid, title, description, location, datestart, dateend, url, allday, zipcode, state, city, address2, address1, event_type, timestart, timeend) VALUES ('2005100114064662','Geeklog installed','Today, you successfully installed this Geeklog site.','Your webserver',getdate(),getdate(),'http://www.geeklog.net/',1,NULL,NULL,NULL,NULL,NULL,'',NULL,NULL)";

$_SQL[] = "INSERT INTO {$_TABLES['featurecodes']} (code, name) VALUES (0,'Not Featured')";
$_SQL[] = "INSERT INTO {$_TABLES['featurecodes']} (code, name) VALUES (1,'Featured')";




$_SQL[] = "
set identity_insert {$_TABLES['features']} on


INSERT INTO {$_TABLES['features']} (ft_id, ft_name, ft_descr, ft_gl_core) VALUES (1,'story.edit','Access to story editor',1)
INSERT INTO {$_TABLES['features']} (ft_id, ft_name, ft_descr, ft_gl_core) VALUES (2,'story.moderate','Ability to moderate pending stories',1)
INSERT INTO {$_TABLES['features']} (ft_id, ft_name, ft_descr, ft_gl_core) VALUES (5,'user.edit','Access to user editor',1)
INSERT INTO {$_TABLES['features']} (ft_id, ft_name, ft_descr, ft_gl_core) VALUES (6,'user.delete','Ability to delete a user',1)
INSERT INTO {$_TABLES['features']} (ft_id, ft_name, ft_descr, ft_gl_core) VALUES (7,'user.mail','Ability to send email to members',1)
INSERT INTO {$_TABLES['features']} (ft_id, ft_name, ft_descr, ft_gl_core) VALUES (8,'calendar.moderate','Ability to moderate pending events',1)
INSERT INTO {$_TABLES['features']} (ft_id, ft_name, ft_descr, ft_gl_core) VALUES (9,'calendar.edit','Access to event editor',1)
INSERT INTO {$_TABLES['features']} (ft_id, ft_name, ft_descr, ft_gl_core) VALUES (10,'block.edit','Access to block editor',1)
INSERT INTO {$_TABLES['features']} (ft_id, ft_name, ft_descr, ft_gl_core) VALUES (11,'topic.edit','Access to topic editor',1)
INSERT INTO {$_TABLES['features']} (ft_id, ft_name, ft_descr, ft_gl_core) VALUES (13,'plugin.edit','Access to plugin editor',1)
INSERT INTO {$_TABLES['features']} (ft_id, ft_name, ft_descr, ft_gl_core) VALUES (14,'group.edit','Ability to edit groups',1)
INSERT INTO {$_TABLES['features']} (ft_id, ft_name, ft_descr, ft_gl_core) VALUES (15,'group.delete','Ability to delete groups',1)
INSERT INTO {$_TABLES['features']} (ft_id, ft_name, ft_descr, ft_gl_core) VALUES (16,'block.delete','Ability to delete a block',1)
INSERT INTO {$_TABLES['features']} (ft_id, ft_name, ft_descr, ft_gl_core) VALUES (17,'staticpages.edit','Ability to edit a static page',0)
INSERT INTO {$_TABLES['features']} (ft_id, ft_name, ft_descr, ft_gl_core) VALUES (18,'staticpages.delete','Ability to delete static pages',0)
INSERT INTO {$_TABLES['features']} (ft_id, ft_name, ft_descr, ft_gl_core) VALUES (19,'story.submit','May skip the story submission queue',1)
INSERT INTO {$_TABLES['features']} (ft_id, ft_name, ft_descr, ft_gl_core) VALUES (21,'calendar.submit','May skip the event submission queue',1)
INSERT INTO {$_TABLES['features']} (ft_id, ft_name, ft_descr, ft_gl_core) VALUES (22,'staticpages.PHP','Ability use PHP in static pages',0)
INSERT INTO {$_TABLES['features']} (ft_id, ft_name, ft_descr, ft_gl_core) VALUES (23,'spamx.admin', 'Full access to Spam-X plugin', 0)
INSERT INTO {$_TABLES['features']} (ft_id, ft_name, ft_descr, ft_gl_core) VALUES (24,'story.ping', 'Ability to send pings, pingbacks, or trackbacks for stories', 1)
INSERT INTO {$_TABLES['features']} (ft_id, ft_name, ft_descr, ft_gl_core) VALUES (3,'links.moderate','Ability to moderate pending links',0)
INSERT INTO {$_TABLES['features']} (ft_id, ft_name, ft_descr, ft_gl_core) VALUES (4,'links.edit','Access to links editor',0)
INSERT INTO {$_TABLES['features']} (ft_id, ft_name, ft_descr, ft_gl_core) VALUES (20,'links.submit','May skip the links submission queue',0)
INSERT INTO {$_TABLES['features']} (ft_id, ft_name, ft_descr, ft_gl_core) VALUES (12,'polls.edit','Access to polls editor',0)
INSERT INTO {$_TABLES['features']} (ft_id, ft_name, ft_descr, ft_gl_core) VALUES (25,'syndication.edit', 'Access to Content Syndication', 1)

set identity_insert {$_TABLES['features']} off
";



$_SQL[] = "INSERT INTO {$_TABLES['frontpagecodes']} (code, name) VALUES (0,'Show Only in Topic')";
$_SQL[] = "INSERT INTO {$_TABLES['frontpagecodes']} (code, name) VALUES (1,'Show on Front Page')";

$_SQL[] = "INSERT INTO {$_TABLES['group_assignments']} (ug_main_grp_id, ug_uid, ug_grp_id) VALUES (2,1,NULL)";
$_SQL[] = "INSERT INTO {$_TABLES['group_assignments']} (ug_main_grp_id, ug_uid, ug_grp_id) VALUES (2,NULL,1)";
$_SQL[] = "INSERT INTO {$_TABLES['group_assignments']} (ug_main_grp_id, ug_uid, ug_grp_id) VALUES (3,NULL,1)";
$_SQL[] = "INSERT INTO {$_TABLES['group_assignments']} (ug_main_grp_id, ug_uid, ug_grp_id) VALUES (4,NULL,1)";
$_SQL[] = "INSERT INTO {$_TABLES['group_assignments']} (ug_main_grp_id, ug_uid, ug_grp_id) VALUES (5,NULL,1)";
$_SQL[] = "INSERT INTO {$_TABLES['group_assignments']} (ug_main_grp_id, ug_uid, ug_grp_id) VALUES (6,NULL,1)";
$_SQL[] = "INSERT INTO {$_TABLES['group_assignments']} (ug_main_grp_id, ug_uid, ug_grp_id) VALUES (7,NULL,1)";
$_SQL[] = "INSERT INTO {$_TABLES['group_assignments']} (ug_main_grp_id, ug_uid, ug_grp_id) VALUES (8,NULL,1)";
$_SQL[] = "INSERT INTO {$_TABLES['group_assignments']} (ug_main_grp_id, ug_uid, ug_grp_id) VALUES (9,NULL,1)";
$_SQL[] = "INSERT INTO {$_TABLES['group_assignments']} (ug_main_grp_id, ug_uid, ug_grp_id) VALUES (10,NULL,1)";
$_SQL[] = "INSERT INTO {$_TABLES['group_assignments']} (ug_main_grp_id, ug_uid, ug_grp_id) VALUES (11,NULL,1)";
$_SQL[] = "INSERT INTO {$_TABLES['group_assignments']} (ug_main_grp_id, ug_uid, ug_grp_id) VALUES (13,2,NULL)";
$_SQL[] = "INSERT INTO {$_TABLES['group_assignments']} (ug_main_grp_id, ug_uid, ug_grp_id) VALUES (12,2,NULL)";
$_SQL[] = "INSERT INTO {$_TABLES['group_assignments']} (ug_main_grp_id, ug_uid, ug_grp_id) VALUES (11,2,NULL)";
$_SQL[] = "INSERT INTO {$_TABLES['group_assignments']} (ug_main_grp_id, ug_uid, ug_grp_id) VALUES (2,NULL,12)";
$_SQL[] = "INSERT INTO {$_TABLES['group_assignments']} (ug_main_grp_id, ug_uid, ug_grp_id) VALUES (2,NULL,10)";
$_SQL[] = "INSERT INTO {$_TABLES['group_assignments']} (ug_main_grp_id, ug_uid, ug_grp_id) VALUES (2,NULL,9)";
$_SQL[] = "INSERT INTO {$_TABLES['group_assignments']} (ug_main_grp_id, ug_uid, ug_grp_id) VALUES (2,NULL,8)";
$_SQL[] = "INSERT INTO {$_TABLES['group_assignments']} (ug_main_grp_id, ug_uid, ug_grp_id) VALUES (2,NULL,7)";
$_SQL[] = "INSERT INTO {$_TABLES['group_assignments']} (ug_main_grp_id, ug_uid, ug_grp_id) VALUES (2,NULL,6)";
$_SQL[] = "INSERT INTO {$_TABLES['group_assignments']} (ug_main_grp_id, ug_uid, ug_grp_id) VALUES (2,NULL,5)";
$_SQL[] = "INSERT INTO {$_TABLES['group_assignments']} (ug_main_grp_id, ug_uid, ug_grp_id) VALUES (2,NULL,4)";
$_SQL[] = "INSERT INTO {$_TABLES['group_assignments']} (ug_main_grp_id, ug_uid, ug_grp_id) VALUES (2,NULL,3)";
$_SQL[] = "INSERT INTO {$_TABLES['group_assignments']} (ug_main_grp_id, ug_uid, ug_grp_id) VALUES (12,NULL,1)";
$_SQL[] = "INSERT INTO {$_TABLES['group_assignments']} (ug_main_grp_id, ug_uid, ug_grp_id) VALUES (9,NULL,11)";
$_SQL[] = "INSERT INTO {$_TABLES['group_assignments']} (ug_main_grp_id, ug_uid, ug_grp_id) VALUES (2,NULL,11)";
$_SQL[] = "INSERT INTO {$_TABLES['group_assignments']} (ug_main_grp_id, ug_uid, ug_grp_id) VALUES (10,2,NULL)";
$_SQL[] = "INSERT INTO {$_TABLES['group_assignments']} (ug_main_grp_id, ug_uid, ug_grp_id) VALUES (9,2,NULL)";
$_SQL[] = "INSERT INTO {$_TABLES['group_assignments']} (ug_main_grp_id, ug_uid, ug_grp_id) VALUES (8,2,NULL)";
$_SQL[] = "INSERT INTO {$_TABLES['group_assignments']} (ug_main_grp_id, ug_uid, ug_grp_id) VALUES (7,2,NULL)";
$_SQL[] = "INSERT INTO {$_TABLES['group_assignments']} (ug_main_grp_id, ug_uid, ug_grp_id) VALUES (6,2,NULL)";
$_SQL[] = "INSERT INTO {$_TABLES['group_assignments']} (ug_main_grp_id, ug_uid, ug_grp_id) VALUES (5,2,NULL)";
$_SQL[] = "INSERT INTO {$_TABLES['group_assignments']} (ug_main_grp_id, ug_uid, ug_grp_id) VALUES (4,2,NULL)";
$_SQL[] = "INSERT INTO {$_TABLES['group_assignments']} (ug_main_grp_id, ug_uid, ug_grp_id) VALUES (3,2,NULL)";
$_SQL[] = "INSERT INTO {$_TABLES['group_assignments']} (ug_main_grp_id, ug_uid, ug_grp_id) VALUES (2,2,NULL)";
$_SQL[] = "INSERT INTO {$_TABLES['group_assignments']} (ug_main_grp_id, ug_uid, ug_grp_id) VALUES (1,2,NULL)";
$_SQL[] = "INSERT INTO {$_TABLES['group_assignments']} (ug_main_grp_id, ug_uid, ug_grp_id) VALUES (14,NULL,1)";
$_SQL[] = "INSERT INTO {$_TABLES['group_assignments']} (ug_main_grp_id, ug_uid, ug_grp_id) VALUES (15,NULL,1)";
$_SQL[] = "INSERT INTO {$_TABLES['group_assignments']} (ug_main_grp_id, ug_uid, ug_grp_id) VALUES (17,NULL,1)";


$_SQL[] = "
set identity_insert {$_TABLES['groups']} on

INSERT INTO {$_TABLES['groups']} (grp_id, grp_name, grp_descr, grp_gl_core) VALUES (1,'Root','Has full access to the site',1)
INSERT INTO {$_TABLES['groups']} (grp_id, grp_name, grp_descr, grp_gl_core) VALUES (2,'All Users','Group that a typical user is added to',1)
INSERT INTO {$_TABLES['groups']} (grp_id, grp_name, grp_descr, grp_gl_core) VALUES (3,'Story Admin','Has full access to story features',1)
INSERT INTO {$_TABLES['groups']} (grp_id, grp_name, grp_descr, grp_gl_core) VALUES (4,'Block Admin','Has full access to block features',1)
INSERT INTO {$_TABLES['groups']} (grp_id, grp_name, grp_descr, grp_gl_core) VALUES (5,'Links Admin','Has full access to links features',0)
INSERT INTO {$_TABLES['groups']} (grp_id, grp_name, grp_descr, grp_gl_core) VALUES (6,'Topic Admin','Has full access to topic features',1)
INSERT INTO {$_TABLES['groups']} (grp_id, grp_name, grp_descr, grp_gl_core) VALUES (7,'Calendar Admin','Has full access to calendar features',1)
INSERT INTO {$_TABLES['groups']} (grp_id, grp_name, grp_descr, grp_gl_core) VALUES (8,'Polls Admin','Has full access to polls features',0)
INSERT INTO {$_TABLES['groups']} (grp_id, grp_name, grp_descr, grp_gl_core) VALUES (9,'User Admin','Has full access to user features',1)
INSERT INTO {$_TABLES['groups']} (grp_id, grp_name, grp_descr, grp_gl_core) VALUES (10,'Plugin Admin','Has full access to plugin features',1)
INSERT INTO {$_TABLES['groups']} (grp_id, grp_name, grp_descr, grp_gl_core) VALUES (11,'Group Admin','Is a User Admin with access to groups, too',1)
INSERT INTO {$_TABLES['groups']} (grp_id, grp_name, grp_descr, grp_gl_core) VALUES (12,'Mail Admin','Can use Mail Utility',1)
INSERT INTO {$_TABLES['groups']} (grp_id, grp_name, grp_descr, grp_gl_core) VALUES (13,'Logged-in Users','All registered members',1)
INSERT INTO {$_TABLES['groups']} (grp_id, grp_name, grp_descr, grp_gl_core) VALUES (14,'Static Page Admin','Can administer static pages',0)
INSERT INTO {$_TABLES['groups']} (grp_id, grp_name, grp_descr, grp_gl_core) VALUES (15,'spamx Admin', 'Users in this group can administer the Spam-X plugin',0)
INSERT INTO {$_TABLES['groups']} (grp_id, grp_name, grp_descr, grp_gl_core) VALUES (16,'Remote Users', 'Users in this group can have authenticated against a remote server.',1)
INSERT INTO {$_TABLES['groups']} (grp_id, grp_name, grp_descr, grp_gl_core) VALUES (17,'Syndication Admin', 'Can create and modify web feeds for the site',1)

set identity_insert {$_TABLES['groups']} off
";


$_SQL[] = "INSERT INTO {$_TABLES['links']} (lid, category, url, description, title, date, owner_id, group_id) VALUES ('geeklog.net','Geeklog Sites','http://www.geeklog.net/','Visit the Geeklog homepage for support, FAQs, updates, add-ons, and a great community.','Geeklog Project Homepage',getdate(),1,5)";

$_SQL[] = "INSERT INTO {$_TABLES['maillist']} (code, name) VALUES (0,'Don''t Email')";
$_SQL[] = "INSERT INTO {$_TABLES['maillist']} (code, name) VALUES (1,'Email Headlines Each Night')";


$_SQL[] = "
set identity_insert {$_TABLES['pingservice']} on

INSERT INTO {$_TABLES['pingservice']} (pid, name, site_url, ping_url, method, is_enabled) VALUES (1, 'Ping-O-Matic', 'http://pingomatic.com/', 'http://rpc.pingomatic.com/', 'weblogUpdates.ping', 1)

set identity_insert {$_TABLES['pingservice']} off
";



$_SQL[] = "INSERT INTO {$_TABLES['plugins']} (pi_name, pi_version, pi_gl_version, pi_enabled, pi_homepage) VALUES ('staticpages', '1.4.3','1.4.1',1,'http://www.geeklog.net/')";
$_SQL[] = "INSERT INTO {$_TABLES['plugins']} (pi_name, pi_version, pi_gl_version, pi_enabled, pi_homepage) VALUES ('spamx', '1.1.0','1.4.1',1,'http://www.pigstye.net/gplugs/staticpages/index.php/spamx')";
$_SQL[] = "INSERT INTO {$_TABLES['plugins']} (pi_name, pi_version, pi_gl_version, pi_enabled, pi_homepage) VALUES ('links', '1.0.1', '1.4.1', 1, 'http://www.geeklog.net/')";
$_SQL[] = "INSERT INTO {$_TABLES['plugins']} (pi_name, pi_version, pi_gl_version, pi_enabled, pi_homepage) VALUES ('polls', '1.1.0', '1.4.1', '1', 'http://www.geeklog.net/')";
$_SQL[] = "INSERT INTO {$_TABLES['plugins']} (pi_name, pi_version, pi_gl_version, pi_enabled, pi_homepage) VALUES ('calendar', '1.0.0', '1.4.1', '1', 'http://www.geeklog.net/')";

$_SQL[] = "INSERT INTO {$_TABLES['pollanswers']} (qid, aid, answer, votes) VALUES ('geeklogfeaturepoll',1,'Trackbacks',0)";
$_SQL[] = "INSERT INTO {$_TABLES['pollanswers']} (qid, aid, answer, votes) VALUES ('geeklogfeaturepoll',2,'Links and Polls plugins',0)";
$_SQL[] = "INSERT INTO {$_TABLES['pollanswers']} (qid, aid, answer, votes) VALUES ('geeklogfeaturepoll',3,'Revamped admin areas',0)";
$_SQL[] = "INSERT INTO {$_TABLES['pollanswers']} (qid, aid, answer, votes) VALUES ('geeklogfeaturepoll',4,'FCKeditor included',0)";
$_SQL[] = "INSERT INTO {$_TABLES['pollanswers']} (qid, aid, answer, votes) VALUES ('geeklogfeaturepoll',5,'Remote user authentication',0)";
$_SQL[] = "INSERT INTO {$_TABLES['pollanswers']} (qid, aid, answer, votes) VALUES ('geeklogfeaturepoll',6,'Other',0)";

$_SQL[] = "INSERT INTO {$_TABLES['pollquestions']} (qid, question, voters, date, display, commentcode, statuscode, owner_id, group_id, perm_owner, perm_group) VALUES ('geeklogfeaturepoll','What is the best new feature of Geeklog?',0,getdate(),1,0,0,2,8,3,3)";

$_SQL[] = "INSERT INTO {$_TABLES['postmodes']} (code, name) VALUES ('plaintext','Plain Old Text')";
$_SQL[] = "INSERT INTO {$_TABLES['postmodes']} (code, name) VALUES ('html','HTML Formatted')";

$_SQL[] = "INSERT INTO {$_TABLES['sortcodes']} (code, name) VALUES ('ASC','Oldest First')";
$_SQL[] = "INSERT INTO {$_TABLES['sortcodes']} (code, name) VALUES ('DESC','Newest First')";

$_SQL[] = "INSERT INTO {$_TABLES['statuscodes']} (code, name) VALUES (1,'Refreshing')";
$_SQL[] = "INSERT INTO {$_TABLES['statuscodes']} (code, name) VALUES (0,'Normal')";
$_SQL[] = "INSERT INTO {$_TABLES['statuscodes']} (code, name) VALUES (10,'Archive')";

$_SQL[] = "INSERT INTO {$_TABLES['stories']} (sid, uid, draft_flag, tid, date, title, introtext, bodytext, hits, numemails, comments, related, featured, commentcode, statuscode, postmode, frontpage, owner_id, group_id, perm_owner, perm_group, perm_members, perm_anon) VALUES ('welcome',2,0,'GeekLog',getdate(),'Welcome to Geeklog!','<p>Welcome and let me be the first to congratulate you on installing GeekLog. Please take the time to read everything in the <a href=\"docs/index.html\">docs directory</a>. Geeklog now has enhanced, user-based security.  You should thoroughly understand how these work before you run a production Geeklog Site.\r\r<p>To log into your new GeekLog site, please use this account:\r<p>Username: <b>Admin</b><br>\rPassword: <b>password</b>','<p><b>And don''t forget to change your password after logging in!</b>',100,1,0,'',1,0,0,'html',1,2,3,3,2,2,2)";

$_SQL[] = "INSERT INTO {$_TABLES['storysubmission']} (sid, uid, tid, title, introtext, date, postmode) VALUES ('security-reminder',2,'GeekLog','Are you secure?','<p>This is a reminder to secure your site once you have Geeklog up and running. What you should do:</p>\r\r<ol>\r<li>Change the default password for the Admin account.</li>\r<li>Remove the install directory (you won''t need it any more).</li>\r</ol>',getdate(),'html')";

$_SQL[] = "INSERT INTO {$_TABLES['syndication']} (type, topic, header_tid, format, limits, content_length, title, description, filename, charset, language, is_enabled, updated, update_info) VALUES ('geeklog', '::all', 'all', 'RSS-2.0', 10, 1, 'Geeklog Site', 'Another Nifty Geeklog Site', 'geeklog.rss', 'UTF-8', 'en-gb', 1, getdate(), NULL)";

$_SQL[] = "INSERT INTO {$_TABLES['topics']} (tid, topic, imageurl, sortnum, limitnews, group_id, owner_id, perm_owner, perm_group, perm_members, perm_anon) VALUES ('General','General News','/images/topics/topic_news.gif',1,10,6,2,3,2,2,2)";
$_SQL[] = "INSERT INTO {$_TABLES['topics']} (tid, topic, imageurl, sortnum, limitnews, group_id, owner_id, perm_owner, perm_group, perm_members, perm_anon) VALUES ('GeekLog','GeekLog','/images/topics/topic_gl.gif',2,10,6,2,3,2,2,2)";

$_SQL[] = "INSERT INTO {$_TABLES['tzcodes']} (tz, offset, description) VALUES ('ndt',-9000,'Newfoundland Daylight')";
$_SQL[] = "INSERT INTO {$_TABLES['tzcodes']} (tz, offset, description) VALUES ('adt',-10800,'Atlantic Daylight')";
$_SQL[] = "INSERT INTO {$_TABLES['tzcodes']} (tz, offset, description) VALUES ('edt',-14400,'Eastern Daylight')";
$_SQL[] = "INSERT INTO {$_TABLES['tzcodes']} (tz, offset, description) VALUES ('cdt',-18000,'Central Daylight')";
$_SQL[] = "INSERT INTO {$_TABLES['tzcodes']} (tz, offset, description) VALUES ('mdt',-21600,'Mountain Daylight')";
$_SQL[] = "INSERT INTO {$_TABLES['tzcodes']} (tz, offset, description) VALUES ('pdt',-25200,'Pacific Daylight')";
$_SQL[] = "INSERT INTO {$_TABLES['tzcodes']} (tz, offset, description) VALUES ('ydt',-28800,'Yukon Daylight')";
$_SQL[] = "INSERT INTO {$_TABLES['tzcodes']} (tz, offset, description) VALUES ('hdt',-32400,'Hawaii Daylight')";
$_SQL[] = "INSERT INTO {$_TABLES['tzcodes']} (tz, offset, description) VALUES ('bst',3600,'British Summer')";
$_SQL[] = "INSERT INTO {$_TABLES['tzcodes']} (tz, offset, description) VALUES ('mes',7200,'Middle European Summer')";
$_SQL[] = "INSERT INTO {$_TABLES['tzcodes']} (tz, offset, description) VALUES ('sst',7200,'Swedish Summer')";
$_SQL[] = "INSERT INTO {$_TABLES['tzcodes']} (tz, offset, description) VALUES ('fst',7200,'French Summer')";
$_SQL[] = "INSERT INTO {$_TABLES['tzcodes']} (tz, offset, description) VALUES ('wad',28800,'West Australian Daylight')";
$_SQL[] = "INSERT INTO {$_TABLES['tzcodes']} (tz, offset, description) VALUES ('cad',37800,'Central Australian Daylight')";
$_SQL[] = "INSERT INTO {$_TABLES['tzcodes']} (tz, offset, description) VALUES ('ead',39600,'Eastern Australian Daylight')";
$_SQL[] = "INSERT INTO {$_TABLES['tzcodes']} (tz, offset, description) VALUES ('nzd',46800,'New Zealand Daylight')";
$_SQL[] = "INSERT INTO {$_TABLES['tzcodes']} (tz, offset, description) VALUES ('gmt',0,'Greenwich Mean')";
$_SQL[] = "INSERT INTO {$_TABLES['tzcodes']} (tz, offset, description) VALUES ('utc',0,'Universal (Coordinated)')";
$_SQL[] = "INSERT INTO {$_TABLES['tzcodes']} (tz, offset, description) VALUES ('wet',0,'Western European')";
$_SQL[] = "INSERT INTO {$_TABLES['tzcodes']} (tz, offset, description) VALUES ('wat',-3600,'West Africa')";
$_SQL[] = "INSERT INTO {$_TABLES['tzcodes']} (tz, offset, description) VALUES ('at',-7200,'Azores')";
$_SQL[] = "INSERT INTO {$_TABLES['tzcodes']} (tz, offset, description) VALUES ('gst',-10800,'Greenland Standard')";
$_SQL[] = "INSERT INTO {$_TABLES['tzcodes']} (tz, offset, description) VALUES ('nft',-12600,'Newfoundland')";
$_SQL[] = "INSERT INTO {$_TABLES['tzcodes']} (tz, offset, description) VALUES ('nst',-12600,'Newfoundland Standard')";
$_SQL[] = "INSERT INTO {$_TABLES['tzcodes']} (tz, offset, description) VALUES ('ast',-14400,'Atlantic Standard')";
$_SQL[] = "INSERT INTO {$_TABLES['tzcodes']} (tz, offset, description) VALUES ('est',-18000,'Eastern Standard')";
$_SQL[] = "INSERT INTO {$_TABLES['tzcodes']} (tz, offset, description) VALUES ('cst',-21600,'Central Standard')";
$_SQL[] = "INSERT INTO {$_TABLES['tzcodes']} (tz, offset, description) VALUES ('mst',-25200,'Mountain Standard')";
$_SQL[] = "INSERT INTO {$_TABLES['tzcodes']} (tz, offset, description) VALUES ('pst',-28800,'Pacific Standard')";
$_SQL[] = "INSERT INTO {$_TABLES['tzcodes']} (tz, offset, description) VALUES ('yst',-32400,'Yukon Standard')";
$_SQL[] = "INSERT INTO {$_TABLES['tzcodes']} (tz, offset, description) VALUES ('hst',-36000,'Hawaii Standard')";
$_SQL[] = "INSERT INTO {$_TABLES['tzcodes']} (tz, offset, description) VALUES ('cat',-36000,'Central Alaska')";
$_SQL[] = "INSERT INTO {$_TABLES['tzcodes']} (tz, offset, description) VALUES ('ahs',-36000,'Alaska-Hawaii Standard')";
$_SQL[] = "INSERT INTO {$_TABLES['tzcodes']} (tz, offset, description) VALUES ('nt',-39600,'Nome')";
$_SQL[] = "INSERT INTO {$_TABLES['tzcodes']} (tz, offset, description) VALUES ('idl',-43200,'International Date Line West')";
$_SQL[] = "INSERT INTO {$_TABLES['tzcodes']} (tz, offset, description) VALUES ('cet',3600,'Central European')";
$_SQL[] = "INSERT INTO {$_TABLES['tzcodes']} (tz, offset, description) VALUES ('met',3600,'Middle European')";
$_SQL[] = "INSERT INTO {$_TABLES['tzcodes']} (tz, offset, description) VALUES ('mew',3600,'Middle European Winter')";
$_SQL[] = "INSERT INTO {$_TABLES['tzcodes']} (tz, offset, description) VALUES ('swt',3600,'Swedish Winter')";
$_SQL[] = "INSERT INTO {$_TABLES['tzcodes']} (tz, offset, description) VALUES ('fwt',3600,'French Winter')";
$_SQL[] = "INSERT INTO {$_TABLES['tzcodes']} (tz, offset, description) VALUES ('eet',7200,'Eastern Europe, USSR Zone 1')";
$_SQL[] = "INSERT INTO {$_TABLES['tzcodes']} (tz, offset, description) VALUES ('bt',10800,'Baghdad, USSR Zone 2')";
$_SQL[] = "INSERT INTO {$_TABLES['tzcodes']} (tz, offset, description) VALUES ('it',12600,'Iran')";
$_SQL[] = "INSERT INTO {$_TABLES['tzcodes']} (tz, offset, description) VALUES ('zp4',14400,'USSR Zone 3')";
$_SQL[] = "INSERT INTO {$_TABLES['tzcodes']} (tz, offset, description) VALUES ('zp5',18000,'USSR Zone 4')";
$_SQL[] = "INSERT INTO {$_TABLES['tzcodes']} (tz, offset, description) VALUES ('ist',19800,'Indian Standard')";
$_SQL[] = "INSERT INTO {$_TABLES['tzcodes']} (tz, offset, description) VALUES ('zp6',21600,'USSR Zone 5')";
$_SQL[] = "INSERT INTO {$_TABLES['tzcodes']} (tz, offset, description) VALUES ('was',25200,'West Australian Standard')";
$_SQL[] = "INSERT INTO {$_TABLES['tzcodes']} (tz, offset, description) VALUES ('jt',27000,'Java (3pm in Cronusland!)')";
$_SQL[] = "INSERT INTO {$_TABLES['tzcodes']} (tz, offset, description) VALUES ('cct',28800,'China Coast, USSR Zone 7')";
$_SQL[] = "INSERT INTO {$_TABLES['tzcodes']} (tz, offset, description) VALUES ('jst',32400,'Japan Standard, USSR Zone 8')";
$_SQL[] = "INSERT INTO {$_TABLES['tzcodes']} (tz, offset, description) VALUES ('cas',34200,'Central Australian Standard')";
$_SQL[] = "INSERT INTO {$_TABLES['tzcodes']} (tz, offset, description) VALUES ('eas',36000,'Eastern Australian Standard')";
$_SQL[] = "INSERT INTO {$_TABLES['tzcodes']} (tz, offset, description) VALUES ('nzt',43200,'New Zealand')";
$_SQL[] = "INSERT INTO {$_TABLES['tzcodes']} (tz, offset, description) VALUES ('nzs',43200,'New Zealand Standard')";
$_SQL[] = "INSERT INTO {$_TABLES['tzcodes']} (tz, offset, description) VALUES ('id2',43200,'International Date Line East')";
$_SQL[] = "INSERT INTO {$_TABLES['tzcodes']} (tz, offset, description) VALUES ('idt',10800,'Israel Daylight')";
$_SQL[] = "INSERT INTO {$_TABLES['tzcodes']} (tz, offset, description) VALUES ('iss',7200,'Israel Standard')";

$_SQL[] = "INSERT INTO {$_TABLES['usercomment']} (uid, commentmode, commentorder, commentlimit) VALUES (1,'nested','ASC',100)";
$_SQL[] = "INSERT INTO {$_TABLES['usercomment']} (uid, commentmode, commentorder, commentlimit) VALUES (2,'threaded','ASC',100)";

$_SQL[] = "INSERT INTO {$_TABLES['userindex']} (uid, tids, etids, aids, boxes, noboxes, maxstories) VALUES (1,'','-','','',0,NULL)";
$_SQL[] = "INSERT INTO {$_TABLES['userindex']} (uid, tids, etids, aids, boxes, noboxes, maxstories) VALUES (2,'','','','',0,NULL)";

$_SQL[] = "INSERT INTO {$_TABLES['userinfo']} (uid, about, pgpkey, userspace, tokens, totalcomments, lastgranted) VALUES (1,NULL,NULL,'',0,0,0)";
$_SQL[] = "INSERT INTO {$_TABLES['userinfo']} (uid, about, pgpkey, userspace, tokens, totalcomments, lastgranted) VALUES (2,NULL,NULL,'',0,0,0)";

$_SQL[] = "INSERT INTO {$_TABLES['userprefs']} (uid, noicons, willing, dfid, tzid, emailstories) VALUES (1,0,0,0,'',0)";
$_SQL[] = "INSERT INTO {$_TABLES['userprefs']} (uid, noicons, willing, dfid, tzid, emailstories) VALUES (2,0,1,0,'edt',1)";

$_SQL[] = "
set identity_insert {$_TABLES['users']} on

INSERT INTO {$_TABLES['users']} (uid, username, fullname, passwd, email, homepage, sig, regdate, cookietimeout, theme, status) VALUES (1,'Anonymous','Anonymous','',NULL,NULL,'',getdate(),0,NULL,3)
INSERT INTO {$_TABLES['users']} (uid, username, fullname, passwd, email, homepage, sig, regdate, cookietimeout, theme, status) VALUES (2,'Admin','Geeklog SuperUser','5f4dcc3b5aa765d61d8327deb882cf99','root@localhost','http://www.geeklog.net/','',getdate(),28800,NULL,3)

set identity_insert {$_TABLES['users']} off
";


$_SQL[] = "INSERT INTO {$_TABLES['vars']} (name, value) VALUES ('totalhits','0')";
$_SQL[] = "INSERT INTO {$_TABLES['vars']} (name, value) VALUES ('lastemailedstories','')";
$_SQL[] = "INSERT INTO {$_TABLES['vars']} (name, value) VALUES ('last_scheduled_run','')";
$_SQL[] = "INSERT INTO {$_TABLES['vars']} (name, value) VALUES ('spamx.counter','0')";

$_SQL[] = "INSERT INTO {$_TABLES['trackbackcodes']} (code, name) VALUES (0,'Trackback Enabled')";
$_SQL[] = "INSERT INTO {$_TABLES['trackbackcodes']} (code, name) VALUES (-1,'Trackback Disabled')";





$_SQL[] = "INSERT INTO dateCommandCrossReference (mysqlCommand, sqlServerCommand,isDateName,isDatePart) values ('%a','weekday','1','0')";
$_SQL[] = "INSERT INTO dateCommandCrossReference (mysqlCommand, sqlServerCommand,isDateName,isDatePart) values ('%b','month','1','0')";
$_SQL[] = "INSERT INTO dateCommandCrossReference (mysqlCommand, sqlServerCommand,isDateName,isDatePart) values ('%c','mm','0','1')";
$_SQL[] = "INSERT INTO dateCommandCrossReference (mysqlCommand, sqlServerCommand,isDateName,isDatePart) values ('%D','d','0','1')";
$_SQL[] = "INSERT INTO dateCommandCrossReference (mysqlCommand, sqlServerCommand,isDateName,isDatePart) values ('%d','d','0','1')";
$_SQL[] = "INSERT INTO dateCommandCrossReference (mysqlCommand, sqlServerCommand,isDateName,isDatePart) values ('%e','d','0','1')";
$_SQL[] = "INSERT INTO dateCommandCrossReference (mysqlCommand, sqlServerCommand,isDateName,isDatePart) values ('%f','ms','0','1')";
$_SQL[] = "INSERT INTO dateCommandCrossReference (mysqlCommand, sqlServerCommand,isDateName,isDatePart) values ('%H','hh','0','1')";
$_SQL[] = "INSERT INTO dateCommandCrossReference (mysqlCommand, sqlServerCommand,isDateName,isDatePart) values ('%h','hh','0','1')";
$_SQL[] = "INSERT INTO dateCommandCrossReference (mysqlCommand, sqlServerCommand,isDateName,isDatePart) values ('%I','mi','0','1')";
$_SQL[] = "INSERT INTO dateCommandCrossReference (mysqlCommand, sqlServerCommand,isDateName,isDatePart) values ('%i','mi','0','1')";
$_SQL[] = "INSERT INTO dateCommandCrossReference (mysqlCommand, sqlServerCommand,isDateName,isDatePart) values ('%j','dayofyear','1','1')";
$_SQL[] = "INSERT INTO dateCommandCrossReference (mysqlCommand, sqlServerCommand,isDateName,isDatePart) values ('%k','hh','0','1')";
$_SQL[] = "INSERT INTO dateCommandCrossReference (mysqlCommand, sqlServerCommand,isDateName,isDatePart) values ('%l','hh','0','1')";
$_SQL[] = "INSERT INTO dateCommandCrossReference (mysqlCommand, sqlServerCommand,isDateName,isDatePart) values ('%M','month','1','1')";
$_SQL[] = "INSERT INTO dateCommandCrossReference (mysqlCommand, sqlServerCommand,isDateName,isDatePart) values ('%m','mm','0','1')";
$_SQL[] = "INSERT INTO dateCommandCrossReference (mysqlCommand, sqlServerCommand,isDateName,isDatePart) values ('%p','','0','0')";
$_SQL[] = "INSERT INTO dateCommandCrossReference (mysqlCommand, sqlServerCommand,isDateName,isDatePart) values ('%r','','0','0')";
$_SQL[] = "INSERT INTO dateCommandCrossReference (mysqlCommand, sqlServerCommand,isDateName,isDatePart) values ('%S','seconds','0','1')";
$_SQL[] = "INSERT INTO dateCommandCrossReference (mysqlCommand, sqlServerCommand,isDateName,isDatePart) values ('%s','seconds','0','1')";
$_SQL[] = "INSERT INTO dateCommandCrossReference (mysqlCommand, sqlServerCommand,isDateName,isDatePart) values ('%T','','0','1')";
$_SQL[] = "INSERT INTO dateCommandCrossReference (mysqlCommand, sqlServerCommand,isDateName,isDatePart) values ('%U','week','0','1')";
$_SQL[] = "INSERT INTO dateCommandCrossReference (mysqlCommand, sqlServerCommand,isDateName,isDatePart) values ('%u','week','0','1')";
$_SQL[] = "INSERT INTO dateCommandCrossReference (mysqlCommand, sqlServerCommand,isDateName,isDatePart) values ('%V','week','0','1')";
$_SQL[] = "INSERT INTO dateCommandCrossReference (mysqlCommand, sqlServerCommand,isDateName,isDatePart) values ('%v','week','0','1')";
$_SQL[] = "INSERT INTO dateCommandCrossReference (mysqlCommand, sqlServerCommand,isDateName,isDatePart) values ('%W','dw','1','0')";
$_SQL[] = "INSERT INTO dateCommandCrossReference (mysqlCommand, sqlServerCommand,isDateName,isDatePart) values ('%w','dw','0','1')";
$_SQL[] = "INSERT INTO dateCommandCrossReference (mysqlCommand, sqlServerCommand,isDateName,isDatePart) values ('%X','year','0','1')";
$_SQL[] = "INSERT INTO dateCommandCrossReference (mysqlCommand, sqlServerCommand,isDateName,isDatePart) values ('%x','year','0','1')";
$_SQL[] = "INSERT INTO dateCommandCrossReference (mysqlCommand, sqlServerCommand,isDateName,isDatePart) values ('%Y','year','0','1')";
$_SQL[] = "INSERT INTO dateCommandCrossReference (mysqlCommand, sqlServerCommand,isDateName,isDatePart) values ('%y','year','0','1')";
$_SQL[] = "INSERT INTO dateCommandCrossReference (mysqlCommand, sqlServerCommand,isDateName,isDatePart) values ('%%','','0','1')";






$_SQL[] = "
if @@error=0
begin
    commit tran
end

else
begin
    rollback tran
end

";



$_DATA = array();


?>
