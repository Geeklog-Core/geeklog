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
    [allow_autotags] [tinyint] NOT NULL ,
    [rdfurl] [varchar] (255) COLLATE SQL_Latin1_General_CP1_CI_AS NULL ,
    [rdfupdated] [varchar] (50) COLLATE SQL_Latin1_General_CP1_CI_AS NULL ,
    [rdf_last_modified] [varchar] (40) COLLATE SQL_Latin1_General_CP1_CI_AS NULL ,
    [rdf_etag] [varchar] (40) COLLATE SQL_Latin1_General_CP1_CI_AS NULL ,
    [rdflimit] [numeric](5, 0) NULL ,
    [onleft] [tinyint] NULL ,
    [phpblockfn] [varchar] (128) COLLATE SQL_Latin1_General_CP1_CI_AS NULL ,
    [help] [varchar] (256) COLLATE SQL_Latin1_General_CP1_CI_AS NULL ,
    [owner_id] [numeric](8, 0) NOT NULL ,
    [group_id] [numeric](8, 0) NOT NULL ,
    [perm_owner] [tinyint] NOT NULL ,
    [perm_group] [tinyint] NOT NULL ,
    [perm_members] [tinyint] NOT NULL ,
    [perm_anon] [tinyint] NOT NULL
) ON [PRIMARY]
";

$_SQL[] = "
CREATE TABLE [dbo].[{$_TABLES['commentcodes']}] (
    [code] [smallint] NOT NULL ,
    [name] [varchar] (32) COLLATE SQL_Latin1_General_CP1_CI_AS NULL
) ON [PRIMARY]
";

$_SQL[] = "
CREATE TABLE [dbo].[{$_TABLES['commentedits']}] (
  [cid] [int] NOT NULL,
  [uid] [int] NOT NULL,
  [time] [datetime] NOT NULL,
) ON [PRIMARY]
";

$_SQL[] = "
ALTER TABLE [dbo].[{$_TABLES['commentedits']}] ADD CONSTRAINT
[PK_{$_TABLES['commentedits']}] PRIMARY KEY CLUSTERED ([cid]) ON [PRIMARY]
";

$_SQL[] = "
CREATE TABLE [dbo].[{$_TABLES['commentmodes']}] (
    [mode] [varchar] (10) COLLATE SQL_Latin1_General_CP1_CI_AS NOT NULL ,
    [name] [varchar] (32) COLLATE SQL_Latin1_General_CP1_CI_AS NULL
) ON [PRIMARY]
";

$_SQL[] = "
CREATE TABLE [dbo].[{$_TABLES['commentnotifications']}](
  [cid] [INT] NOT NULL,
  [uid] [INT] NOT NULL,
  [deletehash] [varchar] (32) COLLATE SQL_Latin1_General_CP1_CI_AS NOT NULL,
  [mid] [INT] DEFAULT NULL
) ON [PRIMARY]
";

$_SQL[] = "
ALTER TABLE [dbo].[{$_TABLES['commentnotifications']}] ADD CONSTRAINT
[PK_{$_TABLES['commentnotifications']}] PRIMARY KEY CLUSTERED ([cid]) ON [PRIMARY]
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
    [name] [varchar] (128) COLLATE SQL_Latin1_General_CP1_CI_AS NULL ,
    [uid] [int] NULL ,
    [ipaddress] [varchar] (39) COLLATE SQL_Latin1_General_CP1_CI_AS NULL
) ON [PRIMARY]
";

$_SQL[] = "
CREATE TABLE [dbo].[{$_TABLES['commentsubmissions']}] (
  [cid] [int] IDENTITY (1,1) NOT NULL,
  [type] [varchar] (30) NOT NULL default 'article',
  [sid] [varchar](40) NOT NULL,
  [date] [datetime] default NULL,
  [title] [varchar] (128) default NULL,
  [comment] [NTEXT],
  [uid] [INT] NOT NULL default '1',
  [name] [varchar] (32) default NULL,
  [pid] [INT] NOT NULL default '0',
  [ipaddress] [varchar](39) NOT NULL
) ON [PRIMARY]
";

$_SQL[] = "
ALTER TABLE [dbo].[{$_TABLES['commentsubmissions']}] ADD CONSTRAINT
[PK_{$_TABLES['commentsubmissions']}] PRIMARY KEY CLUSTERED ([cid]) ON [PRIMARY]
";

$_SQL[] = "
CREATE TABLE [dbo].[{$_TABLES['conf_values']}] (
  [name] [varchar] (50) NULL,
  [value] [text] NULL,
  [type] [varchar] (50) NULL,
  [group_name] [varchar] (50) NULL,
  [default_value] [text],
  [subgroup] [int] NULL,
  [selectionArray] [int] NULL,
  [sort_order] [int] NULL,
  [tab] [int] NULL,
  [fieldset] [int] NULL )
ON [PRIMARY]
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
CREATE TABLE [dbo].[{$_TABLES['featurecodes']}] (
    [code] [smallint] NOT NULL ,
    [name] [varchar] (32) COLLATE SQL_Latin1_General_CP1_CI_AS NULL
) ON [PRIMARY]
";

$_SQL[] = "
CREATE TABLE [dbo].[{$_TABLES['features']}] (
    [ft_id] [int] IDENTITY (1, 1) NOT NULL ,
    [ft_name] [varchar] (50) COLLATE SQL_Latin1_General_CP1_CI_AS NOT NULL ,
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
    [grp_gl_core] [tinyint] NOT NULL ,
    [grp_default] [tinyint] NOT NULL
) ON [PRIMARY]
";

$_SQL[] = "
CREATE TABLE [dbo].[{$_TABLES['maillist']}] (
    [code] [int] NOT NULL ,
    [name] [char] (32) COLLATE SQL_Latin1_General_CP1_CI_AS NULL
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
    [pi_homepage] [varchar] (128) COLLATE SQL_Latin1_General_CP1_CI_AS NOT NULL,
    [pi_load] [smallint] NOT NULL DEFAULT 10000
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
    [remote_ip] [varchar] (39) COLLATE SQL_Latin1_General_CP1_CI_AS NOT NULL ,
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
CREATE TABLE [dbo].[{$_TABLES['speedlimit']}] (
    [id] [numeric](10, 0) IDENTITY (1, 1) NOT NULL ,
    [ipaddress] [varchar] (39) COLLATE SQL_Latin1_General_CP1_CI_AS NOT NULL ,
    [date] [numeric](10, 0) NULL ,
    [type] [varchar] (30) COLLATE SQL_Latin1_General_CP1_CI_AS NOT NULL
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
    [page_title] [varchar] (128) COLLATE SQL_Latin1_General_CP1_CI_AS NULL ,
    [introtext] [varchar] (5000) COLLATE SQL_Latin1_General_CP1_CI_AS NULL ,
    [bodytext] [varchar] (5000) COLLATE SQL_Latin1_General_CP1_CI_AS NULL ,
    [hits] [numeric](8, 0) NOT NULL ,
    [numemails] [numeric](8, 0) NOT NULL ,
    [comments] [numeric](8, 0) NOT NULL ,
    [comment_expire] [datetime] NULL ,
    [trackbacks] [numeric](8, 0) NOT NULL ,
    [related] [varchar] (5000) COLLATE SQL_Latin1_General_CP1_CI_AS NULL ,
    [featured] [tinyint] NOT NULL ,
    [show_topic_icon] [tinyint] NOT NULL ,
    [commentcode] [smallint] NOT NULL ,
    [trackbackcode] [smallint] NOT NULL ,
    [statuscode] [smallint] NOT NULL ,
    [expire] [datetime] NULL ,
    [postmode] [varchar] (10) COLLATE SQL_Latin1_General_CP1_CI_AS NOT NULL ,
    [advanced_editor_mode] [tinyint] NOT NULL ,
    [frontpage] [tinyint] NULL ,
    [meta_description] [varchar] (5000) COLLATE SQL_Latin1_General_CP1_CI_AS NULL ,
    [meta_keywords] [varchar] (5000) COLLATE SQL_Latin1_General_CP1_CI_AS NULL ,
    [owner_id] [int] NOT NULL ,
    [group_id] [int] NOT NULL ,
    [perm_owner] [tinyint] NOT NULL ,
    [perm_group] [tinyint] NOT NULL ,
    [perm_members] [tinyint] NOT NULL ,
    [perm_anon] [tinyint] NOT NULL
) ON [PRIMARY]
";

$_SQL[] = "
CREATE TABLE [dbo].[{$_TABLES['storysubmission']}] (
    [sid] [varchar] (20) COLLATE SQL_Latin1_General_CP1_CI_AS NOT NULL ,
    [uid] [int] NOT NULL ,
    [tid] [varchar] (20) COLLATE SQL_Latin1_General_CP1_CI_AS NOT NULL ,
    [title] [varchar] (128) COLLATE SQL_Latin1_General_CP1_CI_AS NULL ,
    [introtext] [varchar] (5000) COLLATE SQL_Latin1_General_CP1_CI_AS NULL ,
    [bodytext] [varchar] (5000) COLLATE SQL_Latin1_General_CP1_CI_AS NULL ,
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
CREATE TABLE [dbo].[{$_TABLES['tokens']}] (
    [token] [varchar] (32) COLLATE SQL_Latin1_General_CP1_CI_AS NOT NULL,
    [created] [datetime] NOT NULL,
    [owner_id] [numeric] (8,0) NOT NULL,
    [urlfor] [varchar] (2000) COLLATE SQL_Latin1_General_CP1_CI_AS NOT NULL,
    [ttl] numeric(8,0) NOT NULL DEFAULT 1
) ON [PRIMARY]
";

$_SQL[] = "
CREATE TABLE [dbo].[{$_TABLES['topics']}] (
    [tid] [varchar] (20) COLLATE SQL_Latin1_General_CP1_CI_AS NOT NULL ,
    [topic] [varchar] (48) COLLATE SQL_Latin1_General_CP1_CI_AS NULL ,
    [imageurl] [varchar] (255) COLLATE SQL_Latin1_General_CP1_CI_AS NULL ,
    [meta_description] [varchar] (5000) COLLATE SQL_Latin1_General_CP1_CI_AS NULL ,
    [meta_keywords] [varchar] (5000) COLLATE SQL_Latin1_General_CP1_CI_AS NULL ,
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
    [ipaddress] [varchar] (39) COLLATE SQL_Latin1_General_CP1_CI_AS NOT NULL
) ON [PRIMARY]
";

$_SQL[] = "
CREATE TABLE [dbo].[{$_TABLES['trackbackcodes']}] (
    [code] [smallint] NOT NULL ,
    [name] [varchar] (32) COLLATE SQL_Latin1_General_CP1_CI_AS NULL
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
    [advanced_editor] [tinyint] NULL ,
    [tzid] [varchar] (125) COLLATE SQL_Latin1_General_CP1_CI_AS NULL ,
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
    [status] [varchar] (10) COLLATE SQL_Latin1_General_CP1_CI_AS NULL ,
    [num_reminders] [tinyint] NOT NULL
) ON [PRIMARY]
";

$_SQL[] = "
CREATE TABLE [dbo].[{$_TABLES['vars']}] (
    [name] [varchar] (20) COLLATE SQL_Latin1_General_CP1_CI_AS NOT NULL ,
    [value] [varchar] (128) COLLATE SQL_Latin1_General_CP1_CI_AS NULL
) ON [PRIMARY]
";


$_SQL[] = "ALTER TABLE [dbo].[{$_TABLES['access']}] ADD
    CONSTRAINT [PK_{$_TABLES['access']}] PRIMARY KEY  CLUSTERED
    (
        [acc_ft_id],
        [acc_grp_id]
    )  ON [PRIMARY]
";



$_SQL[] = "ALTER TABLE [dbo].[{$_TABLES['article_images']}] ADD
    CONSTRAINT [PK_{$_TABLES['article_images']}] PRIMARY KEY  CLUSTERED
    (
        [ai_sid],
        [ai_img_num]
    )  ON [PRIMARY]
";



$_SQL[] = "ALTER TABLE [dbo].[{$_TABLES['blocks']}] ADD
    CONSTRAINT [DF_{$_TABLES['blocks']}_type] DEFAULT ('normal') FOR [type],
    CONSTRAINT [DF_{$_TABLES['blocks']}_tid] DEFAULT ('All') FOR [tid],
    CONSTRAINT [DF_{$_TABLES['blocks']}_blockorder] DEFAULT (1) FOR [blockorder],
    CONSTRAINT [DF_{$_TABLES['blocks']}_content] DEFAULT (null) FOR [content],
    CONSTRAINT [DF_{$_TABLES['blocks']}_rdfupdated] DEFAULT (getdate()) FOR [rdfupdated],
    CONSTRAINT [DF_{$_TABLES['blocks']}_rdflimit] DEFAULT (0) FOR [rdflimit],
    CONSTRAINT [DF_{$_TABLES['blocks']}_onleft] DEFAULT (1) FOR [onleft],
    CONSTRAINT [DF_{$_TABLES['blocks']}_owner_id] DEFAULT (1) FOR [owner_id],
    CONSTRAINT [DF_{$_TABLES['blocks']}_group_id] DEFAULT (1) FOR [group_id],
    CONSTRAINT [DF_{$_TABLES['blocks']}s_perm_owner] DEFAULT (3) FOR [perm_owner],
    CONSTRAINT [DF_{$_TABLES['blocks']}_perm_group] DEFAULT (3) FOR [perm_group],
    CONSTRAINT [DF_{$_TABLES['blocks']}_perm_members] DEFAULT (2) FOR [perm_members],
    CONSTRAINT [DF_{$_TABLES['blocks']}_perm_anon] DEFAULT (2) FOR [perm_anon],
    CONSTRAINT [DF_{$_TABLES['blocks']}_allow_autotags] DEFAULT (0) FOR [allow_autotags],
    CONSTRAINT [PK_{$_TABLES['blocks']}] PRIMARY KEY  CLUSTERED
    (
        [bid]
    )  ON [PRIMARY]
";

$_SQL[] = "ALTER TABLE [dbo].[{$_TABLES['commentcodes']}] ADD
    CONSTRAINT [PK_{$_TABLES['commentcodes']}] PRIMARY KEY  CLUSTERED
    (
        [code]
    )  ON [PRIMARY]
";

$_SQL[] = "ALTER TABLE [dbo].[{$_TABLES['commentmodes']}] ADD
    CONSTRAINT [PK_{$_TABLES['commentmodes']}] PRIMARY KEY  CLUSTERED
    (
        [mode]
    )  ON [PRIMARY]
";

$_SQL[] = "ALTER TABLE [dbo].[{$_TABLES['comments']}] ADD
    CONSTRAINT [PK_{$_TABLES['comments']}] PRIMARY KEY  CLUSTERED
    (
        [cid]
    )  ON [PRIMARY]
";

$_SQL[] = "ALTER TABLE [dbo].[{$_TABLES['cookiecodes']}] ADD
    CONSTRAINT [PK_{$_TABLES['cookiecodes']}] PRIMARY KEY  CLUSTERED
    (
        [cc_value]
    )  ON [PRIMARY]
";

$_SQL[] = "ALTER TABLE [dbo].[{$_TABLES['dateformats']}] ADD
    CONSTRAINT [PK_{$_TABLES['dateformats']}] PRIMARY KEY  CLUSTERED
    (
        [dfid]
    )  ON [PRIMARY]
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

$_SQL[] = "ALTER TABLE [dbo].[{$_TABLES['featurecodes']}] ADD
    CONSTRAINT [PK_{$_TABLES['featurecodes']}] PRIMARY KEY  CLUSTERED
    (
        [code]
    )  ON [PRIMARY]
";

$_SQL[] = "ALTER TABLE [dbo].[{$_TABLES['features']}] ADD
    CONSTRAINT [DF_{$_TABLES['features']}_ft_gl_core] DEFAULT (0) FOR [ft_gl_core],
    CONSTRAINT [PK_{$_TABLES['features']}] PRIMARY KEY  CLUSTERED
    (
        [ft_id]
    )  ON [PRIMARY]
";

$_SQL[] = "ALTER TABLE [dbo].[{$_TABLES['frontpagecodes']}] ADD
    CONSTRAINT [PK_{$_TABLES['frontpagecodes']}] PRIMARY KEY  CLUSTERED
    (
        [code]
    )  ON [PRIMARY]
";

$_SQL[] = "ALTER TABLE [dbo].[{$_TABLES['groups']}] ADD
    CONSTRAINT [DF_{$_TABLES['groups']}_grp_gl_core] DEFAULT (0) FOR [grp_gl_core],
    CONSTRAINT [PK_{$_TABLES['groups']}] PRIMARY KEY  CLUSTERED
    (
        [grp_id]
    )  ON [PRIMARY]
";

$_SQL[] = "ALTER TABLE [dbo].[{$_TABLES['maillist']}] ADD
    CONSTRAINT [PK_{$_TABLES['maillist']}] PRIMARY KEY  CLUSTERED
    (
        [code]
    )  ON [PRIMARY]
";

$_SQL[] = "ALTER TABLE [dbo].[{$_TABLES['pingservice']}] ADD
    CONSTRAINT [PK_{$_TABLES['pingservice']}] PRIMARY KEY  CLUSTERED
    (
        [pid]
    )  ON [PRIMARY]
";

$_SQL[] = "ALTER TABLE [dbo].[{$_TABLES['plugins']}] ADD
    CONSTRAINT [PK_{$_TABLES['plugins']}] PRIMARY KEY  CLUSTERED
    (
        [pi_name]
    )  ON [PRIMARY]
";

$_SQL[] = "ALTER TABLE [dbo].[{$_TABLES['postmodes']}] ADD
    CONSTRAINT [PK_{$_TABLES['postmodes']}] PRIMARY KEY  CLUSTERED
    (
        [code]
    )  ON [PRIMARY]
";

$_SQL[] = "ALTER TABLE [dbo].[{$_TABLES['sessions']}] ADD
    CONSTRAINT [PK_{$_TABLES['sessions']}] PRIMARY KEY  CLUSTERED
    (
        [sess_id]
    )  ON [PRIMARY]
";

$_SQL[] = "ALTER TABLE [dbo].[{$_TABLES['speedlimit']}] ADD
    CONSTRAINT [PK_{$_TABLES['speedlimit']}] PRIMARY KEY  CLUSTERED
    (
        [id]
    )  ON [PRIMARY]
";

$_SQL[] = "ALTER TABLE [dbo].[{$_TABLES['statuscodes']}] ADD
    CONSTRAINT [PK_{$_TABLES['statuscodes']}] PRIMARY KEY  CLUSTERED
    (
        [code]
    )  ON [PRIMARY]
";

$_SQL[] = "ALTER TABLE [dbo].[{$_TABLES['stories']}] ADD
    CONSTRAINT [DF_{$_TABLES['stories']}_uid] DEFAULT (1) FOR [uid],
    CONSTRAINT [DF_{$_TABLES['stories']}_draft_flag] DEFAULT (0) FOR [draft_flag],
    CONSTRAINT [DF_{$_TABLES['stories']}_tid] DEFAULT ('General') FOR [tid],
    CONSTRAINT [DF_{$_TABLES['stories']}_hits] DEFAULT (0) FOR [hits],
    CONSTRAINT [DF_{$_TABLES['stories']}_comments] DEFAULT (0) FOR [comments],
    CONSTRAINT [DF_{$_TABLES['stories']}_trackbacks] DEFAULT (0) FOR [trackbacks],
    CONSTRAINT [DF_{$_TABLES['stories']}_featured] DEFAULT (0) FOR [featured],
    CONSTRAINT [DF_{$_TABLES['stories']}_show_topic_icon] DEFAULT (1) FOR [show_topic_icon],
    CONSTRAINT [DF_{$_TABLES['stories']}_commentcode] DEFAULT (0) FOR [commentcode],
    CONSTRAINT [DF_{$_TABLES['stories']}_trackbackcode] DEFAULT (0) FOR [trackbackcode],
    CONSTRAINT [DF_{$_TABLES['stories']}_statuscode] DEFAULT (0) FOR [statuscode],
    CONSTRAINT [DF_{$_TABLES['stories']}_expire] DEFAULT (getdate()) FOR [expire],
    CONSTRAINT [DF_{$_TABLES['stories']}_postmode] DEFAULT ('html') FOR [postmode],
    CONSTRAINT [DF_{$_TABLES['stories']}_owner_id] DEFAULT (1) FOR [owner_id],
    CONSTRAINT [DF_{$_TABLES['stories']}_group_id] DEFAULT (2) FOR [group_id],
    CONSTRAINT [DF_{$_TABLES['stories']}_perm_owner] DEFAULT (3) FOR [perm_owner],
    CONSTRAINT [DF_{$_TABLES['stories']}_perm_group] DEFAULT (3) FOR [perm_group],
    CONSTRAINT [DF_{$_TABLES['stories']}_perm_members] DEFAULT (2) FOR [perm_members],
    CONSTRAINT [DF_{$_TABLES['stories']}_perm_anon] DEFAULT (2) FOR [perm_anon],
    CONSTRAINT [DF_{$_TABLES['stories']}_advanced_editor_mode] DEFAULT (0) FOR [advanced_editor_mode],
    CONSTRAINT [PK_{$_TABLES['stories']}] PRIMARY KEY  CLUSTERED
    (
        [sid]
    )  ON [PRIMARY]
";

$_SQL[] = "ALTER TABLE [dbo].[{$_TABLES['storysubmission']}] ADD
    CONSTRAINT [PK_{$_TABLES['storysubmission']}] PRIMARY KEY  CLUSTERED
    (
        [sid]
    )  ON [PRIMARY]
";

$_SQL[] = "ALTER TABLE [dbo].[{$_TABLES['syndication']}] ADD
    CONSTRAINT [PK_{$_TABLES['syndication']}] PRIMARY KEY  CLUSTERED
    (
        [fid]
    )  ON [PRIMARY]
";

$_SQL[] = "ALTER TABLE [dbo].[{$_TABLES['tokens']}] ADD
    CONSTRAINT [PK_{$_TABLES['tokens']}] PRIMARY KEY  CLUSTERED
    (
        [token]
    )  ON [PRIMARY]
";

$_SQL[] = "ALTER TABLE [dbo].[{$_TABLES['topics']}] ADD
    CONSTRAINT [DF_{$_TABLES['topics']}_is_default] DEFAULT (0) FOR [is_default],
    CONSTRAINT [PK_{$_TABLES['topics']}] PRIMARY KEY  CLUSTERED
    (
        [tid]
    )  ON [PRIMARY]
";

$_SQL[] = "ALTER TABLE [dbo].[{$_TABLES['trackback']}] ADD
    CONSTRAINT [PK_{$_TABLES['trackback']}] PRIMARY KEY  CLUSTERED
    (
        [cid]
    )  ON [PRIMARY]
";

$_SQL[] = "ALTER TABLE [dbo].[{$_TABLES['trackbackcodes']}] ADD
    CONSTRAINT [PK_{$_TABLES['trackbackcodes']}] PRIMARY KEY  CLUSTERED
    (
        [code]
    )  ON [PRIMARY]
";


$_SQL[] = "ALTER TABLE [dbo].[{$_TABLES['usercomment']}] ADD
    CONSTRAINT [PK_{$_TABLES['usercomment']}] PRIMARY KEY  CLUSTERED
    (
        [uid]
    )  ON [PRIMARY]
";

$_SQL[] = "ALTER TABLE [dbo].[{$_TABLES['userindex']}] ADD
    CONSTRAINT [DF_{$_TABLES['userindex']}_boxes] DEFAULT (0) FOR [boxes],
    CONSTRAINT [DF_{$_TABLES['userindex']}_noboxes] DEFAULT (0) FOR [noboxes],
    CONSTRAINT [DF_{$_TABLES['userindex']}_tids] DEFAULT ('0') FOR [tids],
    CONSTRAINT [DF_{$_TABLES['userindex']}_etids] DEFAULT ('0') FOR [etids],
    CONSTRAINT [DF_{$_TABLES['userindex']}_aids] DEFAULT ('0') FOR [aids],
    CONSTRAINT [PK_{$_TABLES['userindex']}] PRIMARY KEY  CLUSTERED
    (
        [uid]
    )  ON [PRIMARY]
";

$_SQL[] = "ALTER TABLE [dbo].[{$_TABLES['userinfo']}] ADD
    CONSTRAINT [PK_{$_TABLES['userinfo']}] PRIMARY KEY  CLUSTERED
    (
        [uid]
    )  ON [PRIMARY]
";

$_SQL[] = "ALTER TABLE [dbo].[{$_TABLES['userprefs']}] ADD
    CONSTRAINT [DF_{$_TABLES['userprefs']}_noicons] DEFAULT (0) FOR [noicons],
    CONSTRAINT [DF_{$_TABLES['userprefs']}_willing] DEFAULT (0) FOR [willing],
    CONSTRAINT [DF_{$_TABLES['userprefs']}_dfid] DEFAULT (0) FOR [dfid],
    CONSTRAINT [DF_{$_TABLES['userprefs']}_emailstories] DEFAULT (0) FOR [emailstories],
    CONSTRAINT [DF_{$_TABLES['userprefs']}_emailfromadmin] DEFAULT (0) FOR [emailfromadmin],
    CONSTRAINT [DF_{$_TABLES['userprefs']}_emailfromuser] DEFAULT (0) FOR [emailfromuser],
    CONSTRAINT [DF_{$_TABLES['userprefs']}_showonline] DEFAULT (0) FOR [showonline],
    CONSTRAINT [DF_{$_TABLES['userprefs']}_tzid] DEFAULT ('') FOR [tzid],
    CONSTRAINT [PK_{$_TABLES['userprefs']}] PRIMARY KEY  CLUSTERED
    (
        [uid]
    )  ON [PRIMARY]
";


$_SQL[] = "ALTER TABLE [dbo].[{$_TABLES['users']}] ADD
    CONSTRAINT [DF_{$_TABLES['users']}_status] DEFAULT ('1') FOR [status],
    CONSTRAINT [PK_{$_TABLES['users']}] PRIMARY KEY  CLUSTERED
    (
        [username]
    )  ON [PRIMARY]
";


$_SQL[] = "ALTER TABLE [dbo].[{$_TABLES['vars']}] ADD
    CONSTRAINT [PK_{$_TABLES['vars']}] PRIMARY KEY  CLUSTERED
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
update {$_TABLES['userindex']}
set boxes='0' where boxes=''


update {$_TABLES['userindex']}
set noboxes='0' where noboxes=''

update {$_TABLES['userindex']}
set aids='0' where aids=''

update {$_TABLES['userindex']}
set tids='0' where tids=''

";



$_SQL[] = "CREATE TRIGGER fixContext ON [dbo].[{$_TABLES['blocks']}]
FOR INSERT, UPDATE
AS

update {$_TABLES['blocks']}
set content=NULL
where content like''
";



$_SQL[] = "CREATE TRIGGER fixPhoto ON dbo.{$_TABLES['users']}
FOR INSERT, UPDATE
AS

update {$_TABLES['users']}
set photo=null
where photo=''

";




$_SQL[] = "INSERT INTO {$_TABLES['access']} (acc_ft_id, acc_grp_id) VALUES (1,3)";
$_SQL[] = "INSERT INTO {$_TABLES['access']} (acc_ft_id, acc_grp_id) VALUES (2,3)";
$_SQL[] = "INSERT INTO {$_TABLES['access']} (acc_ft_id, acc_grp_id) VALUES (4,3)";
$_SQL[] = "INSERT INTO {$_TABLES['access']} (acc_ft_id, acc_grp_id) VALUES (5,9)";
$_SQL[] = "INSERT INTO {$_TABLES['access']} (acc_ft_id, acc_grp_id) VALUES (5,11)";
$_SQL[] = "INSERT INTO {$_TABLES['access']} (acc_ft_id, acc_grp_id) VALUES (6,9)";
$_SQL[] = "INSERT INTO {$_TABLES['access']} (acc_ft_id, acc_grp_id) VALUES (6,11)";
$_SQL[] = "INSERT INTO {$_TABLES['access']} (acc_ft_id, acc_grp_id) VALUES (7,12)";
$_SQL[] = "INSERT INTO {$_TABLES['access']} (acc_ft_id, acc_grp_id) VALUES (8,5)";
$_SQL[] = "INSERT INTO {$_TABLES['access']} (acc_ft_id, acc_grp_id) VALUES (9,8)";
$_SQL[] = "INSERT INTO {$_TABLES['access']} (acc_ft_id, acc_grp_id) VALUES (10,4)";
$_SQL[] = "INSERT INTO {$_TABLES['access']} (acc_ft_id, acc_grp_id) VALUES (11,6)";
$_SQL[] = "INSERT INTO {$_TABLES['access']} (acc_ft_id, acc_grp_id) VALUES (13,10)";
$_SQL[] = "INSERT INTO {$_TABLES['access']} (acc_ft_id, acc_grp_id) VALUES (14,11)";
$_SQL[] = "INSERT INTO {$_TABLES['access']} (acc_ft_id, acc_grp_id) VALUES (15,11)";
$_SQL[] = "INSERT INTO {$_TABLES['access']} (acc_ft_id, acc_grp_id) VALUES (16,4)";
$_SQL[] = "INSERT INTO {$_TABLES['access']} (acc_ft_id, acc_grp_id) VALUES (17,10)";
$_SQL[] = "INSERT INTO {$_TABLES['access']} (acc_ft_id, acc_grp_id) VALUES (18,10)";
$_SQL[] = "INSERT INTO {$_TABLES['access']} (acc_ft_id, acc_grp_id) VALUES (19,11)";
$_SQL[] = "INSERT INTO {$_TABLES['access']} (acc_ft_id, acc_grp_id) VALUES (20,14) ";
$_SQL[] = "INSERT INTO {$_TABLES['access']} (acc_ft_id, acc_grp_id) VALUES (21,15) ";
$_SQL[] = "INSERT INTO {$_TABLES['access']} (acc_ft_id, acc_grp_id) VALUES (23,16) ";
$_SQL[] = "INSERT INTO {$_TABLES['access']} (acc_ft_id, acc_grp_id) VALUES (24,16) ";
$_SQL[] = "INSERT INTO {$_TABLES['access']} (acc_ft_id, acc_grp_id) VALUES (25,16) ";
$_SQL[] = "INSERT INTO {$_TABLES['access']} (acc_ft_id, acc_grp_id) VALUES (26,16) ";
$_SQL[] = "INSERT INTO {$_TABLES['access']} (acc_ft_id, acc_grp_id) VALUES (27,16) ";
$_SQL[] = "INSERT INTO {$_TABLES['access']} (acc_ft_id, acc_grp_id) VALUES (28,16) ";
$_SQL[] = "INSERT INTO {$_TABLES['access']} (acc_ft_id, acc_grp_id) VALUES (29,16) ";
$_SQL[] = "INSERT INTO {$_TABLES['access']} (acc_ft_id, acc_grp_id) VALUES (30,16) ";
$_SQL[] = "INSERT INTO {$_TABLES['access']} (acc_ft_id, acc_grp_id) VALUES (31,16) ";
$_SQL[] = "INSERT INTO {$_TABLES['access']} (acc_ft_id, acc_grp_id) VALUES (32,16) ";
$_SQL[] = "INSERT INTO {$_TABLES['access']} (acc_ft_id, acc_grp_id) VALUES (33,16) ";
$_SQL[] = "INSERT INTO {$_TABLES['access']} (acc_ft_id, acc_grp_id) VALUES (34,16) ";
$_SQL[] = "INSERT INTO {$_TABLES['access']} (acc_ft_id, acc_grp_id) VALUES (35,16) ";
$_SQL[] = "INSERT INTO {$_TABLES['access']} (acc_ft_id, acc_grp_id) VALUES (36,16) ";
$_SQL[] = "INSERT INTO {$_TABLES['access']} (acc_ft_id, acc_grp_id) VALUES (37,16) ";
$_SQL[] = "INSERT INTO {$_TABLES['access']} (acc_ft_id, acc_grp_id) VALUES (38,16) ";
$_SQL[] = "INSERT INTO {$_TABLES['access']} (acc_ft_id, acc_grp_id) VALUES (39,16) ";
$_SQL[] = "INSERT INTO {$_TABLES['access']} (acc_ft_id, acc_grp_id) VALUES (40,16) ";
$_SQL[] = "INSERT INTO {$_TABLES['access']} (acc_ft_id, acc_grp_id) VALUES (41,16) ";
$_SQL[] = "INSERT INTO {$_TABLES['access']} (acc_ft_id, acc_grp_id) VALUES (42,16) ";
$_SQL[] = "INSERT INTO {$_TABLES['access']} (acc_ft_id, acc_grp_id) VALUES (43,16) ";
$_SQL[] = "INSERT INTO {$_TABLES['access']} (acc_ft_id, acc_grp_id) VALUES (44,16) ";
$_SQL[] = "INSERT INTO {$_TABLES['access']} (acc_ft_id, acc_grp_id) VALUES (45,16) ";
$_SQL[] = "INSERT INTO {$_TABLES['access']} (acc_ft_id, acc_grp_id) VALUES (46,16) ";
$_SQL[] = "INSERT INTO {$_TABLES['access']} (acc_ft_id, acc_grp_id) VALUES (47,16) ";
$_SQL[] = "INSERT INTO {$_TABLES['access']} (acc_ft_id, acc_grp_id) VALUES (48,16) ";
$_SQL[] = "INSERT INTO {$_TABLES['access']} (acc_ft_id, acc_grp_id) VALUES (49,16) ";
$_SQL[] = "INSERT INTO {$_TABLES['access']} (acc_ft_id, acc_grp_id) VALUES (50,16) ";
$_SQL[] = "INSERT INTO {$_TABLES['access']} (acc_ft_id, acc_grp_id) VALUES (51,16) ";
$_SQL[] = "INSERT INTO {$_TABLES['access']} (acc_ft_id, acc_grp_id) VALUES (52,16) ";
$_SQL[] = "INSERT INTO {$_TABLES['access']} (acc_ft_id, acc_grp_id) VALUES (53,16) ";
$_SQL[] = "INSERT INTO {$_TABLES['access']} (acc_ft_id, acc_grp_id) VALUES (54,16) ";
$_SQL[] = "INSERT INTO {$_TABLES['access']} (acc_ft_id, acc_grp_id) VALUES (55,16) ";
$_SQL[] = "INSERT INTO {$_TABLES['access']} (acc_ft_id, acc_grp_id) VALUES (56,16) ";
$_SQL[] = "INSERT INTO {$_TABLES['access']} (acc_ft_id, acc_grp_id) VALUES (57,16) ";
$_SQL[] = "INSERT INTO {$_TABLES['access']} (acc_ft_id, acc_grp_id) VALUES (58,16) ";
$_SQL[] = "INSERT INTO {$_TABLES['access']} (acc_ft_id, acc_grp_id) VALUES (59,16) ";
$_SQL[] = "INSERT INTO {$_TABLES['access']} (acc_ft_id, acc_grp_id) VALUES (60,16) ";
$_SQL[] = "INSERT INTO {$_TABLES['access']} (acc_ft_id, acc_grp_id) VALUES (61,16) ";


$_SQL[] = "
set identity_insert {$_TABLES['blocks']} on;


INSERT INTO {$_TABLES['blocks']} (bid, is_enabled, name, type, title, tid, blockorder, content, rdfurl, rdfupdated, onleft, phpblockfn, group_id, owner_id, perm_owner, perm_group, perm_members, perm_anon) VALUES (1,1,'user_block','gldefault','User Functions','all',30,'','',getdate(),1,'',4,2,3,3,2,2);
INSERT INTO {$_TABLES['blocks']} (bid, is_enabled, name, type, title, tid, blockorder, content, rdfurl, rdfupdated, onleft, phpblockfn, group_id, owner_id, perm_owner, perm_group, perm_members, perm_anon) VALUES (2,1,'admin_block','gldefault','Admins Only','all',20,'','',getdate(),1,'',4,2,3,3,2,2);
INSERT INTO {$_TABLES['blocks']} (bid, is_enabled, name, type, title, tid, blockorder, content, rdfurl, rdfupdated, onleft, phpblockfn, group_id, owner_id, perm_owner, perm_group, perm_members, perm_anon) VALUES (3,1,'section_block','gldefault','Topics','all',10,'','',getdate(),1,'',4,2,3,3,2,2);
INSERT INTO {$_TABLES['blocks']} (bid, is_enabled, name, type, title, tid, blockorder, content, rdfurl, rdfupdated, onleft, phpblockfn, group_id, owner_id, perm_owner, perm_group, perm_members, perm_anon) VALUES (4,1,'whats_new_block','gldefault','What''s New','all',30,'','',getdate(),0,'',4,2,3,3,2,2);
INSERT INTO {$_TABLES['blocks']} (bid, is_enabled, name, type, title, tid, blockorder, content, rdfurl, rdfupdated, onleft, phpblockfn, group_id, owner_id, perm_owner, perm_group, perm_members, perm_anon) VALUES (5,1,'first_block','normal','About Geeklog','homeonly',20,'<p><b>Welcome to Geeklog!</b></p><p>If you''re already familiar with Geeklog - and especially if you''re not: There have been many improvements to Geeklog since earlier versions that you might want to read up on. Please read the <a href=\"docs/english/changes.html\">release notes</a>. If you need help, please see the <a href=\"docs/english/support.html\">support options</a>.</p>','',getdate(),0,'',4,2,3,3,2,2);
INSERT INTO {$_TABLES['blocks']} (bid, is_enabled, name, type, title, tid, blockorder, content, rdfurl, rdfupdated, onleft, phpblockfn, group_id, owner_id, perm_owner, perm_group, perm_members, perm_anon) VALUES (6,1,'whosonline_block','phpblock','Who''s Online','all',10,'','',getdate(),0,'phpblock_whosonline',4,2,3,3,2,2);
INSERT INTO {$_TABLES['blocks']} (bid, is_enabled, name, type, title, tid, blockorder, content, rdfurl, rdfupdated, onleft, phpblockfn, group_id, owner_id, perm_owner, perm_group, perm_members, perm_anon) VALUES (7,1,'older_stories','gldefault','Older Stories','all',40,'','',getdate(),1,'',4,2,3,3,2,2);


set identity_insert {$_TABLES['blocks']} off;
";


$_SQL[] = "INSERT INTO {$_TABLES['commentcodes']} (code, name) VALUES (0,'Comments Enabled')";
$_SQL[] = "INSERT INTO {$_TABLES['commentcodes']} (code, name) VALUES (-1,'Comments Disabled')";
$_SQL[] = "INSERT INTO {$_TABLES['commentcodes']} (code, name) VALUES (1,'Comments Closed')";

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
$_SQL[] = "INSERT INTO {$_TABLES['dateformats']} (dfid, format, description) VALUES (13,'%I:%M%p  %B %e, %Y','10:00PM  March 21, 1999')";
$_SQL[] = "INSERT INTO {$_TABLES['dateformats']} (dfid, format, description) VALUES (14,'%a %b %d, ''%y %I:%M%p','Sun Mar 21, ''99 10:00PM')";
$_SQL[] = "INSERT INTO {$_TABLES['dateformats']} (dfid, format, description) VALUES (15,'Day %j, %I ish','Day 80, 10 ish')";
$_SQL[] = "INSERT INTO {$_TABLES['dateformats']} (dfid, format, description) VALUES (16,'%y-%m-%d %I:%M','99-03-21 10:00')";
$_SQL[] = "INSERT INTO {$_TABLES['dateformats']} (dfid, format, description) VALUES (17,'%d/%m/%y %H:%M','21/03/99 22:00')";
$_SQL[] = "INSERT INTO {$_TABLES['dateformats']} (dfid, format, description) VALUES (18,'%a %d %b %I:%M%p','Sun 21 Mar 10:00PM')";
$_SQL[] = "INSERT INTO {$_TABLES['dateformats']} (dfid, format, description) VALUES (19,'%Y-%m-%d %H:%M','1999-03-21 22:00')";

$_SQL[] = "INSERT INTO {$_TABLES['featurecodes']} (code, name) VALUES (0,'Not Featured')";
$_SQL[] = "INSERT INTO {$_TABLES['featurecodes']} (code, name) VALUES (1,'Featured')";




$_SQL[] = "
set identity_insert {$_TABLES['features']} on


INSERT INTO {$_TABLES['features']} (ft_id, ft_name, ft_descr, ft_gl_core) VALUES (1,'story.edit','Access to story editor',1)
INSERT INTO {$_TABLES['features']} (ft_id, ft_name, ft_descr, ft_gl_core) VALUES (2,'story.moderate','Ability to moderate pending stories',1)
INSERT INTO {$_TABLES['features']} (ft_id, ft_name, ft_descr, ft_gl_core) VALUES (3,'story.submit','May skip the story submission queue',1)
INSERT INTO {$_TABLES['features']} (ft_id, ft_name, ft_descr, ft_gl_core) VALUES (4,'story.ping', 'Ability to send pings, pingbacks, or trackbacks for stories', 1)
INSERT INTO {$_TABLES['features']} (ft_id, ft_name, ft_descr, ft_gl_core) VALUES (5,'user.edit','Access to user editor',1)
INSERT INTO {$_TABLES['features']} (ft_id, ft_name, ft_descr, ft_gl_core) VALUES (6,'user.delete','Ability to delete a user',1)
INSERT INTO {$_TABLES['features']} (ft_id, ft_name, ft_descr, ft_gl_core) VALUES (7,'user.mail','Ability to send email to members',1)
INSERT INTO {$_TABLES['features']} (ft_id, ft_name, ft_descr, ft_gl_core) VALUES (8,'syndication.edit', 'Access to Content Syndication', 1)
INSERT INTO {$_TABLES['features']} (ft_id, ft_name, ft_descr, ft_gl_core) VALUES (9,'webservices.atompub', 'May use Atompub Webservices (if restricted)', 1)
INSERT INTO {$_TABLES['features']} (ft_id, ft_name, ft_descr, ft_gl_core) VALUES (10,'block.edit','Access to block editor',1)
INSERT INTO {$_TABLES['features']} (ft_id, ft_name, ft_descr, ft_gl_core) VALUES (11,'topic.edit','Access to topic editor',1)
INSERT INTO {$_TABLES['features']} (ft_id, ft_name, ft_descr, ft_gl_core) VALUES (13,'plugin.edit','Can change plugin status',1)
INSERT INTO {$_TABLES['features']} (ft_id, ft_name, ft_descr, ft_gl_core) VALUES (14,'group.edit','Ability to edit groups',1)
INSERT INTO {$_TABLES['features']} (ft_id, ft_name, ft_descr, ft_gl_core) VALUES (15,'group.delete','Ability to delete groups',1)
INSERT INTO {$_TABLES['features']} (ft_id, ft_name, ft_descr, ft_gl_core) VALUES (16,'block.delete','Ability to delete a block',1)
INSERT INTO {$_TABLES['features']} (ft_id, ft_name, ft_descr, ft_gl_core) VALUES (17,'plugin.install','Can install/uninstall plugins',1)
INSERT INTO {$_TABLES['features']} (ft_id, ft_name, ft_descr, ft_gl_core) VALUES (18,'plugin.upload','Can upload new plugins',1)
INSERT INTO {$_TABLES['features']} (ft_id, ft_name, ft_descr, ft_gl_core) VALUES (19,'group.assign','Ability to assign users to groups',1)
INSERT INTO {$_TABLES['features']} (ft_id, ft_name, ft_descr, ft_gl_core) VALUES (20, 'comment.moderate', 'Ability to moderate comments', 1)
INSERT INTO {$_TABLES['features']} (ft_id, ft_name, ft_descr, ft_gl_core) VALUES (21, 'comment.submit', 'Comments are automatically published', 1)
INSERT INTO {$_TABLES['features']} (ft_id, ft_name, ft_descr, ft_gl_core) VALUES (22, 'htmlfilter.skip', 'Skip filtering posts for HTML', 1)
INSERT INTO {$_TABLES['features']} (ft_id, ft_name, ft_descr, ft_gl_core) VALUES (23, 'config.Core.tab_site', 'Access to configure site', 0)
INSERT INTO {$_TABLES['features']} (ft_id, ft_name, ft_descr, ft_gl_core) VALUES (24, 'config.Core.tab_mail', 'Access to configure mail', 0)
INSERT INTO {$_TABLES['features']} (ft_id, ft_name, ft_descr, ft_gl_core) VALUES (25, 'config.Core.tab_syndication', 'Access to configure syndication', 0)
INSERT INTO {$_TABLES['features']} (ft_id, ft_name, ft_descr, ft_gl_core) VALUES (26, 'config.Core.tab_paths', 'Access to configure paths', 0)
INSERT INTO {$_TABLES['features']} (ft_id, ft_name, ft_descr, ft_gl_core) VALUES (27, 'config.Core.tab_pear', 'Access to configure PEAR', 0)
INSERT INTO {$_TABLES['features']} (ft_id, ft_name, ft_descr, ft_gl_core) VALUES (28, 'config.Core.tab_mysql', 'Access to configure MySQL', 0)
INSERT INTO {$_TABLES['features']} (ft_id, ft_name, ft_descr, ft_gl_core) VALUES (29, 'config.Core.tab_search', 'Access to configure search', 0)
INSERT INTO {$_TABLES['features']} (ft_id, ft_name, ft_descr, ft_gl_core) VALUES (30, 'config.Core.tab_story', 'Access to configure story', 0)
INSERT INTO {$_TABLES['features']} (ft_id, ft_name, ft_descr, ft_gl_core) VALUES (31, 'config.Core.tab_trackback', 'Access to configure trackback', 0)
INSERT INTO {$_TABLES['features']} (ft_id, ft_name, ft_descr, ft_gl_core) VALUES (32, 'config.Core.tab_pingback', 'Access to configure pingback', 0)
INSERT INTO {$_TABLES['features']} (ft_id, ft_name, ft_descr, ft_gl_core) VALUES (33, 'config.Core.tab_theme', 'Access to configure theme', 0)
INSERT INTO {$_TABLES['features']} (ft_id, ft_name, ft_descr, ft_gl_core) VALUES (34, 'config.Core.tab_theme_advanced', 'Access to configure theme advanced settings', 0)
INSERT INTO {$_TABLES['features']} (ft_id, ft_name, ft_descr, ft_gl_core) VALUES (35, 'config.Core.tab_admin_block', 'Access to configure admin block', 0)
INSERT INTO {$_TABLES['features']} (ft_id, ft_name, ft_descr, ft_gl_core) VALUES (36, 'config.Core.tab_topics_block', 'Access to configure topics block', 0)
INSERT INTO {$_TABLES['features']} (ft_id, ft_name, ft_descr, ft_gl_core) VALUES (37, 'config.Core.tab_whosonline_block', 'Access to configure who''s online block', 0)
INSERT INTO {$_TABLES['features']} (ft_id, ft_name, ft_descr, ft_gl_core) VALUES (38, 'config.Core.tab_whatsnew_block', 'Access to configure what''s new block', 0)
INSERT INTO {$_TABLES['features']} (ft_id, ft_name, ft_descr, ft_gl_core) VALUES (39, 'config.Core.tab_users', 'Access to configure users', 0)
INSERT INTO {$_TABLES['features']} (ft_id, ft_name, ft_descr, ft_gl_core) VALUES (40, 'config.Core.tab_spamx', 'Access to configure Spam-x', 0)
INSERT INTO {$_TABLES['features']} (ft_id, ft_name, ft_descr, ft_gl_core) VALUES (41, 'config.Core.tab_login', 'Access to configure login settings', 0)
INSERT INTO {$_TABLES['features']} (ft_id, ft_name, ft_descr, ft_gl_core) VALUES (42, 'config.Core.tab_user_submission', 'Access to configure user submission', 0)
INSERT INTO {$_TABLES['features']} (ft_id, ft_name, ft_descr, ft_gl_core) VALUES (43, 'config.Core.tab_submission', 'Access to configure submission settings', 0)
INSERT INTO {$_TABLES['features']} (ft_id, ft_name, ft_descr, ft_gl_core) VALUES (44, 'config.Core.tab_comments', 'Access to configure comments', 0)
INSERT INTO {$_TABLES['features']} (ft_id, ft_name, ft_descr, ft_gl_core) VALUES (45, 'config.Core.tab_imagelib', 'Access to configure image library', 0)
INSERT INTO {$_TABLES['features']} (ft_id, ft_name, ft_descr, ft_gl_core) VALUES (46, 'config.Core.tab_upload', 'Access to configure upload', 0)
INSERT INTO {$_TABLES['features']} (ft_id, ft_name, ft_descr, ft_gl_core) VALUES (47, 'config.Core.tab_articleimg', 'Access to configure images in article', 0)
INSERT INTO {$_TABLES['features']} (ft_id, ft_name, ft_descr, ft_gl_core) VALUES (48, 'config.Core.tab_topicicon', 'Access to configure topic icons', 0)
INSERT INTO {$_TABLES['features']} (ft_id, ft_name, ft_descr, ft_gl_core) VALUES (49, 'config.Core.tab_userphoto', 'Access to configure photos', 0)
INSERT INTO {$_TABLES['features']} (ft_id, ft_name, ft_descr, ft_gl_core) VALUES (50, 'config.Core.tab_gravatar', 'Access to configure gravatar', 0)
INSERT INTO {$_TABLES['features']} (ft_id, ft_name, ft_descr, ft_gl_core) VALUES (51, 'config.Core.tab_language', 'Access to configure language', 0)
INSERT INTO {$_TABLES['features']} (ft_id, ft_name, ft_descr, ft_gl_core) VALUES (52, 'config.Core.tab_locale', 'Access to configure locale', 0)
INSERT INTO {$_TABLES['features']} (ft_id, ft_name, ft_descr, ft_gl_core) VALUES (53, 'config.Core.tab_cookies', 'Access to configure cookies', 0)
INSERT INTO {$_TABLES['features']} (ft_id, ft_name, ft_descr, ft_gl_core) VALUES (54, 'config.Core.tab_misc', 'Access to configure miscellaneous settings', 0)
INSERT INTO {$_TABLES['features']} (ft_id, ft_name, ft_descr, ft_gl_core) VALUES (55, 'config.Core.tab_debug', 'Access to configure debug', 0)
INSERT INTO {$_TABLES['features']} (ft_id, ft_name, ft_descr, ft_gl_core) VALUES (56, 'config.Core.tab_daily_digest', 'Access to configure daily digest', 0)
INSERT INTO {$_TABLES['features']} (ft_id, ft_name, ft_descr, ft_gl_core) VALUES (57, 'config.Core.tab_htmlfilter', 'Access to configure HTML filtering', 0)
INSERT INTO {$_TABLES['features']} (ft_id, ft_name, ft_descr, ft_gl_core) VALUES (58, 'config.Core.tab_censoring', 'Access to configure censoring', 0)
INSERT INTO {$_TABLES['features']} (ft_id, ft_name, ft_descr, ft_gl_core) VALUES (59, 'config.Core.tab_iplookup', 'Access to configure IP lookup', 0)
INSERT INTO {$_TABLES['features']} (ft_id, ft_name, ft_descr, ft_gl_core) VALUES (60, 'config.Core.tab_permissions', 'Access to configure default permissions for story, topic, block and autotags', 0)
INSERT INTO {$_TABLES['features']} (ft_id, ft_name, ft_descr, ft_gl_core) VALUES (61, 'config.Core.tab_webservices', 'Access to configure webservices', 0)

set identity_insert {$_TABLES['features']} off
";



$_SQL[] = "INSERT INTO {$_TABLES['frontpagecodes']} (code, name) VALUES (0,'Show Only in Topic')";
$_SQL[] = "INSERT INTO {$_TABLES['frontpagecodes']} (code, name) VALUES (1,'Show on Front Page')";

$_SQL[] = "INSERT INTO {$_TABLES['group_assignments']} (ug_main_grp_id, ug_uid, ug_grp_id) VALUES (2,1,NULL)";
$_SQL[] = "INSERT INTO {$_TABLES['group_assignments']} (ug_main_grp_id, ug_uid, ug_grp_id) VALUES (2,NULL,1)";
$_SQL[] = "INSERT INTO {$_TABLES['group_assignments']} (ug_main_grp_id, ug_uid, ug_grp_id) VALUES (3,NULL,1)";
$_SQL[] = "INSERT INTO {$_TABLES['group_assignments']} (ug_main_grp_id, ug_uid, ug_grp_id) VALUES (4,NULL,1)";
$_SQL[] = "INSERT INTO {$_TABLES['group_assignments']} (ug_main_grp_id, ug_uid, ug_grp_id) VALUES (6,NULL,1)";
$_SQL[] = "INSERT INTO {$_TABLES['group_assignments']} (ug_main_grp_id, ug_uid, ug_grp_id) VALUES (9,NULL,1)";
$_SQL[] = "INSERT INTO {$_TABLES['group_assignments']} (ug_main_grp_id, ug_uid, ug_grp_id) VALUES (10,NULL,1)";
$_SQL[] = "INSERT INTO {$_TABLES['group_assignments']} (ug_main_grp_id, ug_uid, ug_grp_id) VALUES (11,NULL,1)";
$_SQL[] = "INSERT INTO {$_TABLES['group_assignments']} (ug_main_grp_id, ug_uid, ug_grp_id) VALUES (13,2,NULL)";
$_SQL[] = "INSERT INTO {$_TABLES['group_assignments']} (ug_main_grp_id, ug_uid, ug_grp_id) VALUES (12,2,NULL)";
$_SQL[] = "INSERT INTO {$_TABLES['group_assignments']} (ug_main_grp_id, ug_uid, ug_grp_id) VALUES (11,2,NULL)";
$_SQL[] = "INSERT INTO {$_TABLES['group_assignments']} (ug_main_grp_id, ug_uid, ug_grp_id) VALUES (2,NULL,12)";
$_SQL[] = "INSERT INTO {$_TABLES['group_assignments']} (ug_main_grp_id, ug_uid, ug_grp_id) VALUES (2,NULL,10)";
$_SQL[] = "INSERT INTO {$_TABLES['group_assignments']} (ug_main_grp_id, ug_uid, ug_grp_id) VALUES (2,NULL,9)";
$_SQL[] = "INSERT INTO {$_TABLES['group_assignments']} (ug_main_grp_id, ug_uid, ug_grp_id) VALUES (2,NULL,6)";
$_SQL[] = "INSERT INTO {$_TABLES['group_assignments']} (ug_main_grp_id, ug_uid, ug_grp_id) VALUES (2,NULL,4)";
$_SQL[] = "INSERT INTO {$_TABLES['group_assignments']} (ug_main_grp_id, ug_uid, ug_grp_id) VALUES (2,NULL,3)";
$_SQL[] = "INSERT INTO {$_TABLES['group_assignments']} (ug_main_grp_id, ug_uid, ug_grp_id) VALUES (12,NULL,1)";
$_SQL[] = "INSERT INTO {$_TABLES['group_assignments']} (ug_main_grp_id, ug_uid, ug_grp_id) VALUES (9,NULL,11)";
$_SQL[] = "INSERT INTO {$_TABLES['group_assignments']} (ug_main_grp_id, ug_uid, ug_grp_id) VALUES (2,NULL,11)";
$_SQL[] = "INSERT INTO {$_TABLES['group_assignments']} (ug_main_grp_id, ug_uid, ug_grp_id) VALUES (10,2,NULL)";
$_SQL[] = "INSERT INTO {$_TABLES['group_assignments']} (ug_main_grp_id, ug_uid, ug_grp_id) VALUES (9,2,NULL)";
$_SQL[] = "INSERT INTO {$_TABLES['group_assignments']} (ug_main_grp_id, ug_uid, ug_grp_id) VALUES (6,2,NULL)";
$_SQL[] = "INSERT INTO {$_TABLES['group_assignments']} (ug_main_grp_id, ug_uid, ug_grp_id) VALUES (4,2,NULL)";
$_SQL[] = "INSERT INTO {$_TABLES['group_assignments']} (ug_main_grp_id, ug_uid, ug_grp_id) VALUES (3,2,NULL)";
$_SQL[] = "INSERT INTO {$_TABLES['group_assignments']} (ug_main_grp_id, ug_uid, ug_grp_id) VALUES (2,2,NULL)";
$_SQL[] = "INSERT INTO {$_TABLES['group_assignments']} (ug_main_grp_id, ug_uid, ug_grp_id) VALUES (1,2,NULL)";
$_SQL[] = "INSERT INTO {$_TABLES['group_assignments']} (ug_main_grp_id, ug_uid, ug_grp_id) VALUES (5,NULL,1)";
$_SQL[] = "INSERT INTO {$_TABLES['group_assignments']} (ug_main_grp_id, ug_uid, ug_grp_id) VALUES (8,NULL,1)";
$_SQL[] = "INSERT INTO {$_TABLES['group_assignments']} (ug_main_grp_id, ug_uid, ug_grp_id) VALUES (14,NULL,1)";
$_SQL[] = "INSERT INTO {$_TABLES['group_assignments']} (ug_main_grp_id, ug_uid, ug_grp_id) VALUES (15,NULL,1)";
$_SQL[] = "INSERT INTO {$_TABLES['group_assignments']} (ug_main_grp_id, ug_uid, ug_grp_id) VALUES (16,NULL,1)";

// Traditionally, grp_id 1 = Root, 2 = All Users, 13 = Logged-In Users
$_SQL[] = "
set identity_insert {$_TABLES['groups']} on

INSERT INTO {$_TABLES['groups']} (grp_id, grp_name, grp_descr, grp_gl_core) VALUES (1,'Root','Has full access to the site',1)
INSERT INTO {$_TABLES['groups']} (grp_id, grp_name, grp_descr, grp_gl_core) VALUES (2,'All Users','Group that a typical user is added to',1)
INSERT INTO {$_TABLES['groups']} (grp_id, grp_name, grp_descr, grp_gl_core) VALUES (3,'Story Admin','Has full access to story features',1)
INSERT INTO {$_TABLES['groups']} (grp_id, grp_name, grp_descr, grp_gl_core) VALUES (4,'Block Admin','Has full access to block features',1)
INSERT INTO {$_TABLES['groups']} (grp_id, grp_name, grp_descr, grp_gl_core) VALUES (5,'Syndication Admin', 'Can create and modify web feeds for the site',1)
INSERT INTO {$_TABLES['groups']} (grp_id, grp_name, grp_descr, grp_gl_core) VALUES (6,'Topic Admin','Has full access to topic features',1)
INSERT INTO {$_TABLES['groups']} (grp_id, grp_name, grp_descr, grp_gl_core) VALUES (7,'Remote Users', 'Users in this group can have authenticated against a remote server.',1)
INSERT INTO {$_TABLES['groups']} (grp_id, grp_name, grp_descr, grp_gl_core) VALUES (8,'Webservices Users', 'Can use the Webservices API (if restricted)',0)
INSERT INTO {$_TABLES['groups']} (grp_id, grp_name, grp_descr, grp_gl_core) VALUES (9,'User Admin','Has full access to user features',1)
INSERT INTO {$_TABLES['groups']} (grp_id, grp_name, grp_descr, grp_gl_core) VALUES (10,'Plugin Admin','Has full access to plugin features',1)
INSERT INTO {$_TABLES['groups']} (grp_id, grp_name, grp_descr, grp_gl_core) VALUES (11,'Group Admin','Is a User Admin with access to groups, too',1)
INSERT INTO {$_TABLES['groups']} (grp_id, grp_name, grp_descr, grp_gl_core) VALUES (12,'Mail Admin','Can use Mail Utility',1)
INSERT INTO {$_TABLES['groups']} (grp_id, grp_name, grp_descr, grp_gl_core) VALUES (13,'Logged-in Users','All registered members',1)
INSERT INTO {$_TABLES['groups']} (grp_id, grp_name, grp_descr, grp_gl_core) VALUES (14, 'Comment Admin', 'Can moderate comments', 1)
INSERT INTO {$_TABLES['groups']} (grp_id, grp_name, grp_descr, grp_gl_core) VALUES (15, 'Comment Submitters', 'Can submit comments', 0)
INSERT INTO {$_TABLES['groups']} (grp_id, grp_name, grp_descr, grp_gl_core) VALUES (16, 'Configuration Admin', 'Has full access to configuration', 1)

set identity_insert {$_TABLES['groups']} off
";


$_SQL[] = "INSERT INTO {$_TABLES['maillist']} (code, name) VALUES (0,'Don''t Email')";
$_SQL[] = "INSERT INTO {$_TABLES['maillist']} (code, name) VALUES (1,'Email Headlines Each Night')";


$_SQL[] = "
set identity_insert {$_TABLES['pingservice']} on

INSERT INTO {$_TABLES['pingservice']} (pid, name, site_url, ping_url, method, is_enabled) VALUES (1, 'Ping-O-Matic', 'http://pingomatic.com/', 'http://rpc.pingomatic.com/', 'weblogUpdates.ping', 1)

set identity_insert {$_TABLES['pingservice']} off
";



$_SQL[] = "INSERT INTO {$_TABLES['postmodes']} (code, name) VALUES ('plaintext','Plain Old Text')";
$_SQL[] = "INSERT INTO {$_TABLES['postmodes']} (code, name) VALUES ('html','HTML Formatted')";

$_SQL[] = "INSERT INTO {$_TABLES['sortcodes']} (code, name) VALUES ('ASC','Oldest First')";
$_SQL[] = "INSERT INTO {$_TABLES['sortcodes']} (code, name) VALUES ('DESC','Newest First')";

$_SQL[] = "INSERT INTO {$_TABLES['statuscodes']} (code, name) VALUES (1,'Refreshing')";
$_SQL[] = "INSERT INTO {$_TABLES['statuscodes']} (code, name) VALUES (0,'Normal')";
$_SQL[] = "INSERT INTO {$_TABLES['statuscodes']} (code, name) VALUES (10,'Archive')";

$_SQL[] = "INSERT INTO {$_TABLES['stories']} (sid, uid, draft_flag, tid, date, title, introtext, bodytext, hits, numemails, comments, related, featured, commentcode, statuscode, postmode, frontpage, owner_id, group_id, perm_owner, perm_group, perm_members, perm_anon) VALUES ('welcome',2,0,'Geeklog',getdate(),'Welcome to Geeklog!','<p>Welcome and let me be the first to congratulate you on installing Geeklog. Please take the time to read everything in the <a href=\"docs/english/index.html\">docs directory</a>. Geeklog now has enhanced, user-based security.  You should thoroughly understand how these work before you run a production Geeklog Site.\r\r<p>To log into your new Geeklog site, please use this account:\r<p>Username: <b>Admin</b><br>\rPassword: <b>password</b> <p><b>And don''t forget to <a href=\"usersettings.php\">change your password</a> after logging in!</b>','',100,1,0,'',1,0,0,'html',1,2,3,3,2,2,2)";

$_SQL[] = "INSERT INTO {$_TABLES['storysubmission']} (sid, uid, tid, title, introtext, date, postmode) VALUES ('security-reminder',2,'Geeklog','Are you secure?','<p>This is a reminder to secure your site once you have Geeklog up and running. What you should do:</p>\r\r<ol>\r<li>Change the default password for the Admin account.</li>\r<li>Remove the install directory (you won''t need it any more).</li>\r</ol>',getdate(),'html')";

$_SQL[] = "INSERT INTO {$_TABLES['syndication']} (type, topic, header_tid, format, limits, content_length, title, description, filename, charset, language, is_enabled, updated, update_info) VALUES ('article', '::all', 'all', 'RSS-2.0', 10, 1, 'Geeklog Site', 'Another Nifty Geeklog Site', 'geeklog.rss', 'iso-8859-1', 'en-gb', 1, getdate(), NULL)";

$_SQL[] = "INSERT INTO {$_TABLES['topics']} (tid, topic, imageurl, meta_description, meta_keywords, sortnum, limitnews, group_id, owner_id, perm_owner, perm_group, perm_members, perm_anon) VALUES ('General','General News','/images/topics/topic_news.png','A topic that contains general news related posts.','News, Post, Information',1,10,6,2,3,2,2,2)";
$_SQL[] = "INSERT INTO {$_TABLES['topics']} (tid, topic, imageurl, meta_description, meta_keywords, sortnum, limitnews, group_id, owner_id, perm_owner, perm_group, perm_members, perm_anon) VALUES ('Geeklog','Geeklog','/images/topics/topic_gl.png','A topic that contains posts about Geeklog.','Geeklog, Posts, Information',2,10,6,2,3,2,2,2)";

$_SQL[] = "INSERT INTO {$_TABLES['usercomment']} (uid, commentmode, commentorder, commentlimit) VALUES (1,'nested','ASC',100)";
$_SQL[] = "INSERT INTO {$_TABLES['usercomment']} (uid, commentmode, commentorder, commentlimit) VALUES (2,'nested','ASC',100)";

$_SQL[] = "INSERT INTO {$_TABLES['userindex']} (uid, tids, etids, aids, boxes, noboxes, maxstories) VALUES (1,'','-','','',0,NULL)";
$_SQL[] = "INSERT INTO {$_TABLES['userindex']} (uid, tids, etids, aids, boxes, noboxes, maxstories) VALUES (2,'','','','',0,NULL)";

$_SQL[] = "INSERT INTO {$_TABLES['userinfo']} (uid, about, pgpkey, userspace, tokens, totalcomments, lastgranted) VALUES (1,NULL,NULL,'',0,0,0)";
$_SQL[] = "INSERT INTO {$_TABLES['userinfo']} (uid, about, pgpkey, userspace, tokens, totalcomments, lastgranted) VALUES (2,NULL,NULL,'',0,0,0)";

$_SQL[] = "INSERT INTO {$_TABLES['userprefs']} (uid, noicons, willing, dfid, tzid, emailstories) VALUES (1,0,0,0,'',0)";
$_SQL[] = "INSERT INTO {$_TABLES['userprefs']} (uid, noicons, willing, dfid, tzid, emailstories) VALUES (2,0,1,0,'',1)";

$_SQL[] = "
set identity_insert {$_TABLES['users']} on

INSERT INTO {$_TABLES['users']} (uid, username, fullname, passwd, email, homepage, sig, regdate, cookietimeout, theme, status, num_reminders) VALUES (1,'Anonymous','Anonymous','',NULL,NULL,'',getdate(),0,NULL,3,0)
INSERT INTO {$_TABLES['users']} (uid, username, fullname, passwd, email, homepage, sig, regdate, cookietimeout, theme, status, num_reminders) VALUES (2,'Admin','Geeklog SuperUser','5f4dcc3b5aa765d61d8327deb882cf99','root@localhost','http://www.geeklog.net/','',getdate(),28800,NULL,3,0)

set identity_insert {$_TABLES['users']} off
";


$_SQL[] = "INSERT INTO {$_TABLES['vars']} (name, value) VALUES ('totalhits','0')";
$_SQL[] = "INSERT INTO {$_TABLES['vars']} (name, value) VALUES ('lastemailedstories','')";
$_SQL[] = "INSERT INTO {$_TABLES['vars']} (name, value) VALUES ('last_scheduled_run','')";
$_SQL[] = "INSERT INTO {$_TABLES['vars']} (name, value) VALUES ('database_version','0.0.0')";

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
