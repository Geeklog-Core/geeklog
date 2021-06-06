<?php

/* Reminder: always indent with 4 spaces (no tabs). */
// +---------------------------------------------------------------------------+
// | Geeklog 2.2                                                               |
// +---------------------------------------------------------------------------+
// | configuration_validation.php                                              |
// |                                                                           |
// | List of validation rules for Core configurations                          |
// +---------------------------------------------------------------------------+
// | Copyright (C) 2007-2021 by the following authors:                         |
// |                                                                           |
// | Authors: Akeda Bagus       - admin AT gedex DOT web DOT id                |
// |          Tom Homer         - tomhomer AT gmail DOT com                    |
// +---------------------------------------------------------------------------+
// |                                                                           |
// | This program is free software; you can redistribute it and/or             |
// | modify it under the terms of the GNU General Public License               |
// | as published by the Free Software Foundation; either version 2            |
// | of the License, or (at your option) any later version.                    |
// |                                                                           |
// | This program is distributed in the hope that it will be useful,           |
// | but WITHOUT ANY WARRANTY; without even the implied warranty of            |
// | MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the             |
// | GNU General Public License for more details.                              |
// |                                                                           |
// | You should have received a copy of the GNU General Public License         |
// | along with this program; if not, write to the Free Software Foundation,   |
// | Inc., 59 Temple Place - Suite 330, Boston, MA  02111-1307, USA.           |
// |                                                                           |
// +---------------------------------------------------------------------------+

if (stripos($_SERVER['PHP_SELF'], 'configuration_validation.php') !== false) {
    die('This file can not be used on its own!');
}

global $_CONF_VALIDATE;

// Subgroup Site, Tab Site
$_CONF_VALIDATE['Core']['site_url'] = ['rule' => 'url'];
$_CONF_VALIDATE['Core']['site_admin_url'] = ['rule' => 'url'];
$_CONF_VALIDATE['Core']['site_name'] = ['rule' => 'notEmpty'];
$_CONF_VALIDATE['Core']['site_slogan'] = ['rule' => 'stringOrEmpty'];
$_CONF_VALIDATE['Core']['path_site_logo'] = ['rule' => 'stringOrEmpty'];
$_CONF_VALIDATE['Core']['owner_name'] = ['rule' => 'stringOrEmpty'];
$_CONF_VALIDATE['Core']['microsummary_short'] = ['rule' => 'stringOrEmpty'];
$_CONF_VALIDATE['Core']['site_disabled_msg'] = [
    'sanitize' => 'approvedTags',
    'rule'     => 'stringOrEmpty',
];
$_CONF_VALIDATE['Core']['copyrightyear'] = [
    'rule'    => 'copyrightyear',
    'message' => isset($LANG_VALIDATION['yearOrRange']) ? $LANG_VALIDATION['yearOrRange'] : $LANG_VALIDATION['default'],
];
$_CONF_VALIDATE['Core']['url_rewrite'] = ['rule' => 'boolean'];
$_CONF_VALIDATE['Core']['url_routing'] = ['rule' => ['inList', [0, 1, 2], false]];
$_CONF_VALIDATE['Core']['cdn_hosted'] = ['rule' => 'boolean'];
$_CONF_VALIDATE['Core']['meta_tags'] = ['rule' => ['inList', [0, 1, 2], false]];
$_CONF_VALIDATE['Core']['meta_description'] = ['rule' => 'stringOrEmpty'];
$_CONF_VALIDATE['Core']['meta_keywords'] = ['rule' => 'stringOrEmpty'];
$_CONF_VALIDATE['Core']['cookie_consent'] = ['rule' => 'boolean'];
$_CONF_VALIDATE['Core']['terms_of_use_link'] = ['rule' => 'stringOrEmpty'];
$_CONF_VALIDATE['Core']['privacy_policy_link'] = ['rule' => 'stringOrEmpty'];
$_CONF_VALIDATE['Core']['about_cookies_link'] = ['rule' => 'stringOrEmpty'];
$_CONF_VALIDATE['Core']['ip_anonymization'] = ['rule' => ['range', -1, 31536000]];  // Max 1 year

// Subgroup Site, Tab Mail
$_CONF_VALIDATE['Core']['site_mail'] = ['rule' => 'email'];
$_CONF_VALIDATE['Core']['noreply_mail'] = ['rule' => 'email'];
$_CONF_VALIDATE['Core']['mail_settings[backend]'] = [
    'rule'    => ['inList', ['smtp', 'smtps', 'sendmail', 'mail']],
    'message' => isset($LANG_VALIDATION['mail_settings_backend']) ?
        $LANG_VALIDATION['mail_settings_backend'] : $LANG_VALIDATION['default'],
];
$_CONF_VALIDATE['Core']['mail_settings[sendmail_path]'] = [
    'rule'    => 'mail_settings_sendmail_path',
    'message' => isset($LANG_VALIDATION['mail_settings_sendmail_path']) ?
        $LANG_VALIDATION['mail_settings_sendmail_path'] : $LANG_VALIDATION['default'],
];
$_CONF_VALIDATE['Core']['mail_settings[host]'] = [
    'rule'    => 'url',
    'message' => isset($LANG_VALIDATION['mail_settings_host']) ?
        $LANG_VALIDATION['mail_settings_host'] : $LANG_VALIDATION['default'],
];
$_CONF_VALIDATE['Core']['mail_settings[port]'] = [
    'rule'    => ['range', 0, 65535],
    'message' => isset($LANG_VALIDATION['mail_settings_port']) ?
        $LANG_VALIDATION['mail_settings_port'] : $LANG_VALIDATION['default'],
];
$_CONF_VALIDATE['Core']['mail_settings[auth]'] = ['rule' => 'boolean'];
$_CONF_VALIDATE['Core']['mail_settings[username]'] = ['rule' => 'notEmpty'];
$_CONF_VALIDATE['Core']['mail_settings[password]'] = ['rule' => 'notEmpty'];
$_CONF_VALIDATE['Core']['cc_enabled'] = ['rule' => 'boolean'];
$_CONF_VALIDATE['Core']['cc_default'] = ['rule' => 'boolean'];
$_CONF_VALIDATE['Core']['mail_charset'] = ['rule' => 'stringOrEmpty'];

// Subgroup Site, Tab Syndication
$_CONF_VALIDATE['Core']['backend'] = ['rule' => 'boolean'];
$_CONF_VALIDATE['Core']['rdf_file'] = ['rule' => 'notEmpty'];
$_CONF_VALIDATE['Core']['rdf_limit'] = [
    'rule'    => 'rdf_limit',
    'message' => isset($LANG_VALIDATION['rdf_limit']) ?
        $LANG_VALIDATION['rdf_limit'] : $LANG_VALIDATION['default'],
];
$_CONF_VALIDATE['Core']['rdf_storytext'] = ['rule' => 'numeric'];
$_CONF_VALIDATE['Core']['rdf_language'] = ['rule' => 'notEmpty'];
$_CONF_VALIDATE['Core']['syndication_max_headlines'] = ['rule' => 'numeric'];
$_CONF_VALIDATE['Core']['comment_feeds_article_tag'] = [
    'sanitize' => 'approvedTags',
    'rule'     => 'notEmpty',
];
$_CONF_VALIDATE['Core']['comment_feeds_article_tag_position'] = [
    'rule' => ['inList', ['start', 'end', 'none'], true],
];
$_CONF_VALIDATE['Core']['comment_feeds_article_author_tag'] = [
    'sanitize' => 'approvedTags',
    'rule'     => 'stringOrEmpty',
];
$_CONF_VALIDATE['Core']['comment_feeds_comment_author_tag'] = [
    'sanitize' => 'approvedTags',
    'rule'     => 'stringOrEmpty',
];

// Subgroup Site, Tab Paths (All path values are readonly in Configuration since Geeklog 2.2.2)
$_CONF_VALIDATE['Core']['path_html'] = [
    'rule'     => 'path',
    'readonly' => true,
    'message'  => isset($LANG_VALIDATION['path']) ?
        $LANG_VALIDATION['path'] : $LANG_VALIDATION['default'],
];
$_CONF_VALIDATE['Core']['path_log'] = [
    'rule'     => 'path',
    'readonly' => true,
    'message'  => isset($LANG_VALIDATION['path']) ?
        $LANG_VALIDATION['path'] : $LANG_VALIDATION['default'],
];
$_CONF_VALIDATE['Core']['path_language'] = [
    'rule'     => 'path',
    'readonly' => true,
    'message'  => isset($LANG_VALIDATION['path']) ?
        $LANG_VALIDATION['path'] : $LANG_VALIDATION['default'],
];
$_CONF_VALIDATE['Core']['backup_path'] = [
    'rule'     => 'path',
    'readonly' => true,
    'message'  => isset($LANG_VALIDATION['path']) ?
        $LANG_VALIDATION['path'] : $LANG_VALIDATION['default'],
];
$_CONF_VALIDATE['Core']['path_data'] = [
    'rule'     => 'path',
    'readonly' => true,
    'message'  => isset($LANG_VALIDATION['path']) ?
        $LANG_VALIDATION['path'] : $LANG_VALIDATION['default'],
];
$_CONF_VALIDATE['Core']['path_images'] = [
    'rule'     => 'path',
    'readonly' => true,
    'message'  => isset($LANG_VALIDATION['path']) ?
        $LANG_VALIDATION['path'] : $LANG_VALIDATION['default'],
];
$_CONF_VALIDATE['Core']['path_editors'] = [
    'rule'     => 'path',
    'readonly' => true,
    'message'  => isset($LANG_VALIDATION['path']) ?
        $LANG_VALIDATION['path'] : $LANG_VALIDATION['default'],
];

// Subgroup Site, Tab Database
$_CONF_VALIDATE['Core']['dbdump_filename_prefix'] = ['rule' => 'stringOrEmpty'];
$_CONF_VALIDATE['Core']['dbdump_tables_only'] = ['rule' => 'boolean'];
$_CONF_VALIDATE['Core']['dbdump_gzip'] = ['rule' => 'boolean'];
$_CONF_VALIDATE['Core']['dbdump_max_files'] = ['rule' => 'numeric'];

// Subgroup Site, Tab Search
$_CONF_VALIDATE['Core']['search_style'] = ['rule' => ['inList', ['google', 'table'], true]];
$_CONF_VALIDATE['Core']['search_limits'] = [
    'rule'    => 'search_limits',
    'message' => isset($LANG_VALIDATION['search_limits']) ?
        $LANG_VALIDATION['search_limits'] : $LANG_VALIDATION['default'],
];
$_CONF_VALIDATE['Core']['num_search_results'] = [
    'rule'    => 'num_search_results',
    'message' => isset($LANG_VALIDATION['num_search_results']) ?
        $LANG_VALIDATION['num_search_results'] : $LANG_VALIDATION['default'],
];
$_CONF_VALIDATE['Core']['search_show_limit'] = ['rule' => 'boolean'];
$_CONF_VALIDATE['Core']['search_show_sort'] = ['rule' => 'boolean'];
$_CONF_VALIDATE['Core']['search_show_num'] = ['rule' => 'boolean'];
$_CONF_VALIDATE['Core']['search_show_type'] = ['rule' => 'boolean'];
$_CONF_VALIDATE['Core']['search_separator'] = [
    'sanitize' => 'approvedTags',
    'rule'     => 'string',
];
$_CONF_VALIDATE['Core']['search_def_keytype'] = [
    'rule' => ['inList', ['all', 'any', 'phrase'], true],
];
$_CONF_VALIDATE['Core']['search_def_sort'] = [
    'rule' => ['inList', [
        'uid|asc', 'uid|desc', 'date|asc', 'date|desc', 'hits|asc',
        'hits|desc', 'title|asc', 'title|desc',
    ], true],
];
$_CONF_VALIDATE['Core']['search_use_topic'] = ['rule' => 'boolean'];

// Subgroup Stories and Trackback, Tab Story
$_CONF_VALIDATE['Core']['maximagesperarticle'] = ['rule' => 'numeric'];
$_CONF_VALIDATE['Core']['limitnews'] = ['rule' => 'numeric'];
$_CONF_VALIDATE['Core']['minnews'] = ['rule' => 'numeric'];
$_CONF_VALIDATE['Core']['contributedbyline'] = ['rule' => 'boolean'];
$_CONF_VALIDATE['Core']['hideviewscount'] = ['rule' => 'boolean'];
$_CONF_VALIDATE['Core']['hideemailicon'] = ['rule' => 'boolean'];
$_CONF_VALIDATE['Core']['hideprintericon'] = ['rule' => 'boolean'];
$_CONF_VALIDATE['Core']['allow_page_breaks'] = ['rule' => 'boolean'];
$_CONF_VALIDATE['Core']['page_break_comments'] = [
    'rule' => ['inList', ['all', 'first', 'last'], true],
];
$_CONF_VALIDATE['Core']['article_image_align'] = [
    'rule' => ['inList', ['left', 'right'], true],
];
$_CONF_VALIDATE['Core']['show_topic_icon'] = ['rule' => 'boolean'];
$_CONF_VALIDATE['Core']['structured_data_type_default'] = [
    'rule' => ['inList', ['', 'core-webpage', 'core-article', 'core-newsarticle', 'core-blogposting'], true],
];
$_CONF_VALIDATE['Core']['structured_data_article_topic'] = [
    'rule' => ['inList', [0, 1]],
];
$_CONF_VALIDATE['Core']['draft_flag'] = ['rule' => 'boolean'];
$_CONF_VALIDATE['Core']['frontpage'] = ['rule' => 'boolean'];
$_CONF_VALIDATE['Core']['hide_no_news_msg'] = ['rule' => 'boolean'];
$_CONF_VALIDATE['Core']['hide_main_page_navigation'] = [
    'rule' => ['inList', ['false', 'frontpage', 'frontpage_topics'], true],
];
$_CONF_VALIDATE['Core']['onlyrootfeatures'] = ['rule' => 'boolean'];
$_CONF_VALIDATE['Core']['aftersave_story'] = [
    'rule' => ['inList', ['admin', 'home', 'list', 'item'], true],
];
$_CONF_VALIDATE['Core']['related_topics'] = [
    'rule' => ['inList', [0, 1, 2], false],
];
$_CONF_VALIDATE['Core']['related_topics_max'] = ['rule' => 'numeric'];
$_CONF_VALIDATE['Core']['whats_related'] = [
    'rule' => ['inList', [0, 1, 2, 3], false],
];
$_CONF_VALIDATE['Core']['whats_related_max'] = ['rule' => 'numeric'];
$_CONF_VALIDATE['Core']['whats_related_trim'] = ['rule' => 'numeric'];
$_CONF_VALIDATE['Core']['default_cache_time_article'] = ['rule' => 'numeric'];
$_CONF_VALIDATE['Core']['blocks_article_topic_list_repeat_after'] = ['rule' => 'numeric'];

// Subgroup Stories and Trackback, Tab Trackback
$_CONF_VALIDATE['Core']['trackback_enabled'] = ['rule' => 'boolean'];
$_CONF_VALIDATE['Core']['trackback_code'] = [
    'rule' => ['inList', [-1, 0], false],
];
$_CONF_VALIDATE['Core']['trackbackspeedlimit'] = ['rule' => 'numeric'];
$_CONF_VALIDATE['Core']['check_trackback_link'] = [
    'rule' => ['inList', [0, 1, 2, 3, 4, 5, 6, 7], false],
];
$_CONF_VALIDATE['Core']['multiple_trackbacks'] = [
    'rule' => ['inList', [0, 1, 2], false],
];

// Subgroup Stories and Trackback, Tab Pingback
$_CONF_VALIDATE['Core']['pingback_enabled'] = ['rule' => 'boolean'];
$_CONF_VALIDATE['Core']['pingback_excerpt'] = ['rule' => 'boolean'];
$_CONF_VALIDATE['Core']['pingback_self'] = [
    'rule' => ['inList', [0, 1, 2], false],
];
$_CONF_VALIDATE['Core']['ping_enabled'] = ['rule' => 'boolean'];

// Subgroup Theme, Tab Theme
$_CONF_VALIDATE['Core']['theme'] = [
    'rule'    => 'theme',
    'message' => isset($LANG_VALIDATION['theme']) ?
        $LANG_VALIDATION['theme'] : $LANG_VALIDATION['default'],
];
$_CONF_VALIDATE['Core']['doctype'] = [
    'rule' => ['inList', [
        'html401strict', 'html401transitional', 'xhtml10strict', 'xhtml10transitional', 'html5', 'xhtml5',
    ], true],
];
$_CONF_VALIDATE['Core']['path_themes'] = [
    'rule'     => 'path_themes',
    'readonly' => true,
    'message'  => isset($LANG_VALIDATION['path_themes']) ?
        $LANG_VALIDATION['path_themes'] : $LANG_VALIDATION['default'],
];
$_CONF_VALIDATE['Core']['cache_templates'] = ['rule' => 'boolean'];
$_CONF_VALIDATE['Core']['cache_mobile'] = ['rule' => 'boolean'];
$_CONF_VALIDATE['Core']['cache_resource'] = ['rule' => 'boolean'];

// Subgroup Theme, Tab Advanced Settings
$_CONF_VALIDATE['Core']['show_right_blocks'] = ['rule' => 'boolean'];
$_CONF_VALIDATE['Core']['showfirstasfeatured'] = ['rule' => 'boolean'];
$_CONF_VALIDATE['Core']['template_comments'] = ['rule' => 'boolean'];

// Subgroup Blocks, Tab Admin Block
$_CONF_VALIDATE['Core']['sort_admin'] = ['rule' => 'boolean'];
$_CONF_VALIDATE['Core']['link_documentation'] = ['rule' => 'boolean'];
$_CONF_VALIDATE['Core']['link_versionchecker'] = ['rule' => 'boolean'];

// Subgroup Blocks, Tab Topics Block
$_CONF_VALIDATE['Core']['sortmethod'] = ['rule' => ['inList', ['alpha', 'sortnum'], true]];
$_CONF_VALIDATE['Core']['showstorycount'] = ['rule' => 'boolean'];
$_CONF_VALIDATE['Core']['showsubmissioncount'] = ['rule' => 'boolean'];
$_CONF_VALIDATE['Core']['hide_home_link'] = ['rule' => 'boolean'];

// Subgroup Blocks, Tab Who's Online Block
$_CONF_VALIDATE['Core']['whosonline_threshold'] = ['rule' => 'numeric'];
$_CONF_VALIDATE['Core']['whosonline_anonymous'] = ['rule' => 'boolean'];
$_CONF_VALIDATE['Core']['whosonline_photo'] = ['rule' => 'boolean'];

// Subgroup Blocks, Tab What's New Block
$_CONF_VALIDATE['Core']['newstoriesinterval'] = ['rule' => 'numeric'];
$_CONF_VALIDATE['Core']['newcommentsinterval'] = ['rule' => 'numeric'];
$_CONF_VALIDATE['Core']['newtrackbackinterval'] = ['rule' => 'numeric'];
$_CONF_VALIDATE['Core']['hidenewstories'] = ['rule' => 'boolean'];
$_CONF_VALIDATE['Core']['hidenewcomments'] = ['rule' => 'boolean'];
$_CONF_VALIDATE['Core']['hidenewtrackbacks'] = ['rule' => 'boolean'];
$_CONF_VALIDATE['Core']['hidenewplugins'] = ['rule' => 'boolean'];
$_CONF_VALIDATE['Core']['title_trim_length'] = ['rule' => 'numeric'];
$_CONF_VALIDATE['Core']['whatsnew_cache_time'] = ['rule' => 'numeric'];

// Subgroup Users and Submissions, Tab Users
$_CONF_VALIDATE['Core']['disable_new_user_registration'] = ['rule' => 'boolean'];
$_CONF_VALIDATE['Core']['allow_user_themes'] = ['rule' => 'boolean'];
$_CONF_VALIDATE['Core']['allow_user_photo'] = ['rule' => 'boolean'];
$_CONF_VALIDATE['Core']['allow_username_change'] = ['rule' => 'boolean'];
$_CONF_VALIDATE['Core']['allow_account_delete'] = ['rule' => 'boolean'];
$_CONF_VALIDATE['Core']['hide_author_exclusion'] = ['rule' => 'boolean'];
$_CONF_VALIDATE['Core']['show_fullname'] = ['rule' => 'boolean'];
$_CONF_VALIDATE['Core']['show_servicename'] = ['rule' => 'boolean'];
$_CONF_VALIDATE['Core']['require_user_email'] = ['rule' => 'boolean'];
$_CONF_VALIDATE['Core']['custom_registration'] = ['rule' => 'boolean'];
$_CONF_VALIDATE['Core']['user_login_method[standard]'] = ['rule' => 'boolean'];
$_CONF_VALIDATE['Core']['user_login_method[openid]'] = ['rule' => 'boolean'];
$_CONF_VALIDATE['Core']['user_login_method[3rdparty]'] = ['rule' => 'boolean'];
$_CONF_VALIDATE['Core']['user_login_method[oauth]'] = ['rule' => 'boolean'];
$_CONF_VALIDATE['Core']['facebook_login'] = ['rule' => 'boolean'];
$_CONF_VALIDATE['Core']['facebook_consumer_key'] = ['rule' => 'stringOrEmpty'];
$_CONF_VALIDATE['Core']['facebook_consumer_secret'] = ['rule' => 'stringOrEmpty'];
$_CONF_VALIDATE['Core']['linkedin_login'] = ['rule' => 'boolean'];
$_CONF_VALIDATE['Core']['linkedin_consumer_key'] = ['rule' => 'stringOrEmpty'];
$_CONF_VALIDATE['Core']['linkedin_consumer_secret'] = ['rule' => 'stringOrEmpty'];
$_CONF_VALIDATE['Core']['twitter_login'] = ['rule' => 'boolean'];
$_CONF_VALIDATE['Core']['twitter_consumer_key'] = ['rule' => 'stringOrEmpty'];
$_CONF_VALIDATE['Core']['twitter_consumer_secret'] = ['rule' => 'stringOrEmpty'];
$_CONF_VALIDATE['Core']['google_login'] = ['rule' => 'boolean'];
$_CONF_VALIDATE['Core']['google_consumer_key'] = ['rule' => 'stringOrEmpty'];
$_CONF_VALIDATE['Core']['google_consumer_secret'] = ['rule' => 'stringOrEmpty'];
$_CONF_VALIDATE['Core']['microsoft_login'] = ['rule' => 'boolean'];
$_CONF_VALIDATE['Core']['microsoft_consumer_key'] = ['rule' => 'stringOrEmpty'];
$_CONF_VALIDATE['Core']['microsoft_consumer_secret'] = ['rule' => 'stringOrEmpty'];
$_CONF_VALIDATE['Core']['yahoo_login'] = ['rule' => 'boolean'];
$_CONF_VALIDATE['Core']['yahoo_consumer_key'] = ['rule' => 'stringOrEmpty'];
$_CONF_VALIDATE['Core']['yahoo_consumer_secret'] = ['rule' => 'stringOrEmpty'];
$_CONF_VALIDATE['Core']['github_login'] = ['rule' => 'boolean'];
$_CONF_VALIDATE['Core']['github_consumer_key'] = ['rule' => 'stringOrEmpty'];
$_CONF_VALIDATE['Core']['github_consumer_secret'] = ['rule' => 'stringOrEmpty'];

$_CONF_VALIDATE['Core']['aftersave_user'] = [
    'rule' => ['inList', ['admin', 'home', 'list', 'item'], true],
];

// Subgroup Users and Submissions, Tab Spam-X
$_CONF_VALIDATE['Core']['spamx'] = ['rule' => 'numeric'];

// Subgroup Users and Submissions, Tab Login Settings
$_CONF_VALIDATE['Core']['lastlogin'] = ['rule' => 'boolean'];
$_CONF_VALIDATE['Core']['loginrequired'] = ['rule' => 'boolean'];
$_CONF_VALIDATE['Core']['submitloginrequired'] = ['rule' => 'boolean'];
$_CONF_VALIDATE['Core']['commentsloginrequired'] = ['rule' => 'boolean'];
$_CONF_VALIDATE['Core']['statsloginrequired'] = ['rule' => 'boolean'];
$_CONF_VALIDATE['Core']['searchloginrequired'] = [
    'rule' => ['inList', [0, 1, 2], false],
];
$_CONF_VALIDATE['Core']['profileloginrequired'] = ['rule' => 'boolean'];
$_CONF_VALIDATE['Core']['emailuserloginrequired'] = ['rule' => 'boolean'];
$_CONF_VALIDATE['Core']['emailstoryloginrequired'] = ['rule' => 'boolean'];
$_CONF_VALIDATE['Core']['directoryloginrequired'] = ['rule' => 'boolean'];
$_CONF_VALIDATE['Core']['passwordspeedlimit'] = ['rule' => 'numeric'];
$_CONF_VALIDATE['Core']['login_attempts'] = ['rule' => 'numeric'];
$_CONF_VALIDATE['Core']['login_speedlimit'] = ['rule' => 'numeric'];
$_CONF_VALIDATE['Core']['invalidloginattempts'] = ['rule' => 'numeric'];
$_CONF_VALIDATE['Core']['invalidloginmaxtime'] = ['rule' => 'numeric'];
$_CONF_VALIDATE['Core']['enable_twofactorauth'] = ['rule' => 'boolean'];

// Subgroup User and Submissions, Tab Login Settings, Fieldset Password
$_CONF_VALIDATE['Core']['pass_alg'] = [
    'rule'    => 'hash_function',
    'message' => isset($LANG_VALIDATION['hash']) ?
        $LANG_VALIDATION['hash'] : $LANG_VALIDATION['default'],
];
$_CONF_VALIDATE['Core']['pass_stretch'] = ['rule' => ['comparison', '>', 0]];


// Subgroup Users and Submissions, Tab User Submission
$_CONF_VALIDATE['Core']['usersubmission'] = ['rule' => 'boolean'];

// Subgroup Users and Submissions, Tab User Submission Settings
$_CONF_VALIDATE['Core']['storysubmission'] = ['rule' => 'boolean'];
$_CONF_VALIDATE['Core']['listdraftstories'] = ['rule' => 'boolean'];
$_CONF_VALIDATE['Core']['postmode'] = [
    'rule' => ['inList', ['html', 'plaintext', 'wikitext'], true],
];
$_CONF_VALIDATE['Core']['speedlimit'] = ['rule' => 'numeric'];
$_CONF_VALIDATE['Core']['skip_preview'] = ['rule' => 'boolean'];
$_CONF_VALIDATE['Core']['advanced_editor'] = ['rule' => 'boolean'];
$_CONF_VALIDATE['Core']['advanced_editor_name'] = ['rule' => 'notEmpty'];
$_CONF_VALIDATE['Core']['wikitext_editor'] = ['rule' => 'boolean'];

// Subgroup Users and Submissions, Tab Comments
$_CONF_VALIDATE['Core']['commentspeedlimit'] = ['rule' => 'numeric'];
$_CONF_VALIDATE['Core']['comment_limit'] = ['rule' => 'numeric'];
$_CONF_VALIDATE['Core']['comment_mode'] = [
    'rule' => ['inList', ['flat', 'nested', 'nocomment', 'threaded'], true],
];
$_CONF_VALIDATE['Core']['comment_order'] = [
    'rule' => ['inList', ['DESC', 'ASC'], true],
];
$_CONF_VALIDATE['Core']['comment_code'] = [
    'rule' => ['inList', [0, -1], false],
];
$_CONF_VALIDATE['Core']['comment_edit'] = ['rule' => 'boolean'];
$_CONF_VALIDATE['Core']['commentsubmission'] = ['rule' => 'boolean'];
$_CONF_VALIDATE['Core']['comment_edittime'] = ['rule' => 'numeric'];
$_CONF_VALIDATE['Core']['article_comment_close_enabled'] = ['rule' => 'boolean'];
$_CONF_VALIDATE['Core']['article_comment_close_days'] = ['rule' => 'numeric'];
$_CONF_VALIDATE['Core']['comment_close_rec_stories'] = ['rule' => 'numeric'];
$_CONF_VALIDATE['Core']['allow_reply_notifications'] = ['rule' => 'boolean'];
$_CONF_VALIDATE['Core']['comment_on_same_page'] = ['rule' => 'boolean'];
$_CONF_VALIDATE['Core']['show_comments_at_replying'] = ['rule' => 'boolean'];

// Subgroup Users and Submissions, Tab Likes
$_CONF_VALIDATE['Core']['likes_enabled'] = [
    'rule' => ['inList', [0, 1, 2], false],
];
$_CONF_VALIDATE['Core']['likes_articles'] = [
    'rule' => ['inList', [0, 1, 2], false],
];
$_CONF_VALIDATE['Core']['likes_comments'] = [
    'rule' => ['inList', [0, 1, 2], false],
];
$_CONF_VALIDATE['Core']['likes_speedlimit'] = ['rule' => 'numeric'];

// Subgroup Images, Tab Image Library
$_CONF_VALIDATE['Core']['image_lib'] = [
    'rule' => ['inList', ['', 'gdlib', 'imagemagick', 'netpbm'], true],
];
$_CONF_VALIDATE['Core']['path_to_mogrify'] = [
    'rule'    => 'path_to_mogrify',
    'message' => isset($LANG_VALIDATION['path_to_mogrify']) ?
        $LANG_VALIDATION['path_to_mogrify'] : $LANG_VALIDATION['default'],
];
$_CONF_VALIDATE['Core']['path_to_netpbm'] = [
    'rule'    => 'path_to_netpbm',
    'message' => isset($LANG_VALIDATION['path_to_netpbm']) ?
        $LANG_VALIDATION['path_to_netpbm'] : $LANG_VALIDATION['default'],
];

// Subgroup Images, Tab Upload
$_CONF_VALIDATE['Core']['keep_unscaled_image'] = ['rule' => 'boolean'];
$_CONF_VALIDATE['Core']['allow_user_scaling'] = ['rule' => 'boolean'];
$_CONF_VALIDATE['Core']['jpeg_quality'] = ['rule' => ['range', 0, 100]];
$_CONF_VALIDATE['Core']['debug_image_upload'] = ['rule' => 'boolean'];

// Subgroup Images, Tab Images in Articles
$_CONF_VALIDATE['Core']['max_image_width'] = ['rule' => 'numeric'];
$_CONF_VALIDATE['Core']['max_image_height'] = ['rule' => 'numeric'];
$_CONF_VALIDATE['Core']['max_image_size'] = ['rule' => 'numeric'];

// Subgroup Images, Tab Topic Icons
$_CONF_VALIDATE['Core']['max_topicicon_width'] = ['rule' => 'numeric'];
$_CONF_VALIDATE['Core']['max_topicicon_height'] = ['rule' => 'numeric'];
$_CONF_VALIDATE['Core']['max_topicicon_size'] = ['rule' => 'numeric'];

// Subgroup Images, Tab Photos
$_CONF_VALIDATE['Core']['max_photo_width'] = ['rule' => 'numeric'];
$_CONF_VALIDATE['Core']['max_photo_height'] = ['rule' => 'numeric'];
$_CONF_VALIDATE['Core']['max_photo_size'] = ['rule' => 'numeric'];
$_CONF_VALIDATE['Core']['force_photo_width'] = ['rule' => 'numeric'];
$_CONF_VALIDATE['Core']['default_photo'] = ['rule' => 'url'];

// Subgroup Images, Tab Gravatar
$_CONF_VALIDATE['Core']['use_gravatar'] = ['rule' => 'boolean'];
$_CONF_VALIDATE['Core']['gravatar_rating'] = [
    'rule' => ['inList', ['G', 'PG', 'R', 'X'], true],
];
$_CONF_VALIDATE['Core']['gravatar_identicon'] = [
    'rule' => ['inList', ['mm', 'identicon', 'monsterid', 'wavatar', 'retro'], true],
];

// Subgroup Language, Tab Language
$_CONF_VALIDATE['Core']['language'] = [
    'rule'    => 'language',
    'message' => isset($LANG_VALIDATION['language']) ?
        $LANG_VALIDATION['language'] : $LANG_VALIDATION['default'],
];
$_CONF_VALIDATE['Core']['allow_user_language'] = ['rule' => 'boolean'];
$_CONF_VALIDATE['Core']['switchlang_homepage'] = ['rule' => 'boolean'];
$_CONF_VALIDATE['Core']['new_item_set_current_lang'] = ['rule' => 'boolean'];

// Subgroup Language, Tab Locale
$_CONF_VALIDATE['Core']['locale'] = ['rule' => 'stringOrEmpty'];
$_CONF_VALIDATE['Core']['date'] = ['rule' => 'stringOrEmpty'];
$_CONF_VALIDATE['Core']['daytime'] = ['rule' => 'stringOrEmpty'];
$_CONF_VALIDATE['Core']['shortdate'] = ['rule' => 'stringOrEmpty'];
$_CONF_VALIDATE['Core']['dateonly'] = ['rule' => 'stringOrEmpty'];
$_CONF_VALIDATE['Core']['timeonly'] = ['rule' => 'stringOrEmpty'];
$_CONF_VALIDATE['Core']['week_start'] = [
    'rule' => ['inList', ['Mon', 'Sun'], true],
];
$_CONF_VALIDATE['Core']['hour_mode'] = [
    'rule' => ['inList', [12, 24], false],
];
$_CONF_VALIDATE['Core']['thousand_separator'] = [
    'rule'    => 'single_char',
    'message' => isset($LANG_VALIDATION['single_char']) ?
        $LANG_VALIDATION['single_char'] : $LANG_VALIDATION['default'],
];
$_CONF_VALIDATE['Core']['decimal_separator'] = [
    'rule'    => 'single_char',
    'message' => isset($LANG_VALIDATION['single_char']) ?
        $LANG_VALIDATION['single_char'] : $LANG_VALIDATION['default'],
];
$_CONF_VALIDATE['Core']['decimal_count'] = ['rule' => 'numeric'];
$_CONF_VALIDATE['Core']['timezone'] = [
    'rule'    => 'timezone',
    'message' => isset($LANG_VALIDATION['timezone']) ?
        $LANG_VALIDATION['timezone'] : $LANG_VALIDATION['default'],
];

// Subgroup Misc, Tab Cookies
$_CONF_VALIDATE['Core']['cookie_session'] = ['rule' => 'notEmpty'];
$_CONF_VALIDATE['Core']['cookie_name'] = ['rule' => 'notEmpty'];
$_CONF_VALIDATE['Core']['cookie_password'] = ['rule' => 'notEmpty'];
$_CONF_VALIDATE['Core']['cookie_theme'] = ['rule' => 'notEmpty'];
$_CONF_VALIDATE['Core']['cookie_language'] = ['rule' => 'notEmpty'];
$_CONF_VALIDATE['Core']['cookie_tzid'] = ['rule' => 'notEmpty'];
$_CONF_VALIDATE['Core']['cookie_anon_name'] = ['rule' => 'notEmpty'];
$_CONF_VALIDATE['Core']['cookie_ip'] = ['rule' => 'boolean'];
$_CONF_VALIDATE['Core']['default_perm_cookie_timeout'] = [
    'rule' => ['inList', [0, 3600, 7200, 10800, 28800, 86400, 604800, 2678400], false],
];
$_CONF_VALIDATE['Core']['session_cookie_timeout'] = ['rule' => ['range', 299, 86401]]; // 5 Mins to 1 day range in seconds
$_CONF_VALIDATE['Core']['cookiesecure'] = ['rule' => 'boolean'];

// Subgroup Misc, Tab Misc
$_CONF_VALIDATE['Core']['cron_schedule_interval'] = ['rule' => 'numeric'];
$_CONF_VALIDATE['Core']['disable_autolinks'] = ['rule' => 'boolean'];
$_CONF_VALIDATE['Core']['clickable_links'] = ['rule' => 'boolean'];
$_CONF_VALIDATE['Core']['linktext_maxlen'] = ['rule' => 'numeric'];
$_CONF_VALIDATE['Core']['compressed_output'] = ['rule' => 'boolean'];
$_CONF_VALIDATE['Core']['frame_options'] = [
    'rule' => ['inList', ['', 'SAMEORIGIN', 'DENY'], true],
];
$_CONF_VALIDATE['Core']['page_navigation_max_pages'] = [
    'rule'    => ['range', 2, 21],
    'message' => isset($LANG_VALIDATION['page_navigation_max_pages']) ?
        $LANG_VALIDATION['page_navigation_max_pages'] : $LANG_VALIDATION['default'],
];
$_CONF_VALIDATE['Core']['page_navigation_mobile_max_pages'] = [
    'rule'    => ['range', 2, 21],
    'message' => isset($LANG_VALIDATION['page_navigation_mobile_max_pages']) ?
        $LANG_VALIDATION['page_navigation_mobile_max_pages'] : $LANG_VALIDATION['default'],
];
$_CONF_VALIDATE['Core']['default_cache_time_block'] = ['rule' => 'numeric'];
$_CONF_VALIDATE['Core']['titletoid'] = ['rule' => 'boolean'];
$_CONF_VALIDATE['Core']['404_log'] = ['rule' => 'boolean'];

// Subgroup Misc, Tab Debug
$_CONF_VALIDATE['Core']['rootdebug'] = ['rule' => 'boolean'];

// Subgroup Misc, Tab Daily Digest
$_CONF_VALIDATE['Core']['emailstories'] = ['rule' => 'boolean'];
$_CONF_VALIDATE['Core']['emailstorieslength'] = ['rule' => 'numeric'];
$_CONF_VALIDATE['Core']['emailstoriesperdefault'] = ['rule' => 'boolean'];

// Subgroup Misc, Tab HTML Filtering
$_CONF_VALIDATE['Core']['skip_html_filter_for_root'] = ['rule' => 'boolean'];

// Subgroup Misc, Tab Censoring
$_CONF_VALIDATE['Core']['censormode'] = [
    'rule' => ['inList', [0, 1, 2, 3], false],
];
$_CONF_VALIDATE['Core']['censorreplace'] = ['rule' => 'stringOrEmpty'];

// Subgroup Misc, Tab Permissions
$_CONF_VALIDATE['Core']['default_permissions_story[0]'] = [
    'rule' => ['inList', [0, 2, 3], true],
];
$_CONF_VALIDATE['Core']['default_permissions_story[1]'] = [
    'rule' => ['inList', [0, 2, 3], true],
];
$_CONF_VALIDATE['Core']['default_permissions_story[2]'] = [
    'rule' => ['inList', [0, 2, 3], true],
];
$_CONF_VALIDATE['Core']['default_permissions_story[3]'] = [
    'rule' => ['inList', [0, 2, 3], true],
];

// Subgroup Misc, Tab Permissions
$_CONF_VALIDATE['Core']['default_permissions_block[0]'] = [
    'rule' => ['inList', [0, 2, 3], true],
];
$_CONF_VALIDATE['Core']['default_permissions_block[1]'] = [
    'rule' => ['inList', [0, 2, 3], true],
];
$_CONF_VALIDATE['Core']['default_permissions_block[2]'] = [
    'rule' => ['inList', [0, 2, 3], true],
];
$_CONF_VALIDATE['Core']['default_permissions_block[3]'] = [
    'rule' => ['inList', [0, 2, 3], true],
];

// Subgroup Misc, Tab Permissions
$_CONF_VALIDATE['Core']['default_permissions_topic[0]'] = [
    'rule' => ['inList', [0, 2, 3], true],
];
$_CONF_VALIDATE['Core']['default_permissions_topic[1]'] = [
    'rule' => ['inList', [0, 2, 3], true],
];
$_CONF_VALIDATE['Core']['default_permissions_topic[2]'] = [
    'rule' => ['inList', [0, 2, 3], true],
];
$_CONF_VALIDATE['Core']['default_permissions_topic[3]'] = [
    'rule' => ['inList', [0, 2, 3], true],
];

// Subgroup Misc, Tab Permissions
$_CONF_VALIDATE['Core']['autotag_permissions_story[0]'] = [
    'rule' => ['inList', [0, 2], true],
];
$_CONF_VALIDATE['Core']['autotag_permissions_story[1]'] = [
    'rule' => ['inList', [0, 2], true],
];
$_CONF_VALIDATE['Core']['autotag_permissions_story[2]'] = [
    'rule' => ['inList', [0, 2], true],
];
$_CONF_VALIDATE['Core']['autotag_permissions_story[3]'] = [
    'rule' => ['inList', [0, 2], true],
];

$_CONF_VALIDATE['Core']['autotag_permissions_user[0]'] = [
    'rule' => ['inList', [0, 2], true],
];
$_CONF_VALIDATE['Core']['autotag_permissions_user[1]'] = [
    'rule' => ['inList', [0, 2], true],
];
$_CONF_VALIDATE['Core']['autotag_permissions_user[2]'] = [
    'rule' => ['inList', [0, 2], true],
];
$_CONF_VALIDATE['Core']['autotag_permissions_user[3]'] = [
    'rule' => ['inList', [0, 2], true],
];

$_CONF_VALIDATE['Core']['autotag_permissions_topic[0]'] = [
    'rule' => ['inList', [0, 2], true],
];
$_CONF_VALIDATE['Core']['autotag_permissions_topic[1]'] = [
    'rule' => ['inList', [0, 2], true],
];
$_CONF_VALIDATE['Core']['autotag_permissions_topic[2]'] = [
    'rule' => ['inList', [0, 2], true],
];
$_CONF_VALIDATE['Core']['autotag_permissions_topic[3]'] = [
    'rule' => ['inList', [0, 2], true],
];

$_CONF_VALIDATE['Core']['autotag_permissions_related_topics[0]'] = [
    'rule' => ['inList', [0, 2], true],
];
$_CONF_VALIDATE['Core']['autotag_permissions_related_topics[1]'] = [
    'rule' => ['inList', [0, 2], true],
];
$_CONF_VALIDATE['Core']['autotag_permissions_related_topics[2]'] = [
    'rule' => ['inList', [0, 2], true],
];
$_CONF_VALIDATE['Core']['autotag_permissions_related_topics[3]'] = [
    'rule' => ['inList', [0, 2], true],
];

$_CONF_VALIDATE['Core']['autotag_permissions_related_items[0]'] = [
    'rule' => ['inList', [0, 2], true],
];
$_CONF_VALIDATE['Core']['autotag_permissions_related_items[1]'] = [
    'rule' => ['inList', [0, 2], true],
];
$_CONF_VALIDATE['Core']['autotag_permissions_related_items[2]'] = [
    'rule' => ['inList', [0, 2], true],
];
$_CONF_VALIDATE['Core']['autotag_permissions_related_items[3]'] = [
    'rule' => ['inList', [0, 2], true],
];

$_CONF_VALIDATE['Core']['autotag_permissions_block[0]'] = [
    'rule' => ['inList', [0, 2], true],
];
$_CONF_VALIDATE['Core']['autotag_permissions_block[1]'] = [
    'rule' => ['inList', [0, 2], true],
];
$_CONF_VALIDATE['Core']['autotag_permissions_block[2]'] = [
    'rule' => ['inList', [0, 2], true],
];
$_CONF_VALIDATE['Core']['autotag_permissions_block[3]'] = [
    'rule' => ['inList', [0, 2], true],
];

// Subgroup Misc, Tab Story Webservices
$_CONF_VALIDATE['Core']['disable_webservices'] = ['rule' => 'boolean'];
$_CONF_VALIDATE['Core']['restrict_webservices'] = ['rule' => 'boolean'];
$_CONF_VALIDATE['Core']['atom_max_stories'] = ['rule' => 'numeric'];

// Subgroup Misc, Tab Topics
$_CONF_VALIDATE['Core']['multiple_breadcrumbs'] = ['rule' => 'boolean'];
$_CONF_VALIDATE['Core']['disable_breadcrumbs_topics'] = ['rule' => 'boolean'];
$_CONF_VALIDATE['Core']['disable_breadcrumbs_articles'] = ['rule' => 'boolean'];
$_CONF_VALIDATE['Core']['disable_breadcrumbs_plugins'] = ['rule' => 'boolean'];
$_CONF_VALIDATE['Core']['breadcrumb_root_site_name'] = ['rule' => 'boolean'];

// Subgroup Filemanager, Tab General Settings
$_CONF_VALIDATE['Core']['filemanager_disabled'] = ['rule' => 'boolean'];
$_CONF_VALIDATE['Core']['filemanager_browse_only'] = ['rule' => 'boolean'];
$_CONF_VALIDATE['Core']['filemanager_default_view_mode'] = [
    'rule' => ['inList', ['grid', 'list'], true],
];
$_CONF_VALIDATE['Core']['filemanager_show_confirmation'] = ['rule' => 'boolean'];
$_CONF_VALIDATE['Core']['filemanager_search_box'] = ['rule' => 'boolean'];
$_CONF_VALIDATE['Core']['filemanager_file_sorting'] = [
    'rule' => [
        'inList', [
            'default', 'NAME_ASC', 'NAME_DESC', 'TYPE_ASC', 'TYPE_DESC',
            'MODIFIED_ASC', 'MODIFIED_DESC',
        ], true,
    ],
];
$_CONF_VALIDATE['Core']['filemanager_chars_only_latin'] = ['rule' => 'boolean'];
$_CONF_VALIDATE['Core']['filemanager_date_format'] = ['rule' => 'notEmpty'];
$_CONF_VALIDATE['Core']['filemanager_logger'] = ['rule' => 'boolean'];
$_CONF_VALIDATE['Core']['filemanager_show_thumbs'] = ['rule' => 'boolean'];
$_CONF_VALIDATE['Core']['filemanager_generate_thumbnails'] = ['rule' => 'boolean'];

// Subgroup Filemanager, Tab Upload
//$_CONF_VALIDATE['Core']['filemanager_upload_restrictions'] = array('rule' => 'boolean');
$_CONF_VALIDATE['Core']['filemanager_upload_overwrite'] = ['rule' => 'boolean'];
$_CONF_VALIDATE['Core']['filemanager_upload_images_only'] = ['rule' => 'boolean'];
$_CONF_VALIDATE['Core']['filemanager_upload_file_size_limit'] = ['rule' => 'numeric'];
//$_CONF_VALIDATE['Core']['filemanager_unallowed_files'] = array('rule' => 'boolean');
//$_CONF_VALIDATE['Core']['filemanager_unallowed_dirs'] = array('rule' => 'boolean');
$_CONF_VALIDATE['Core']['filemanager_unallowed_files_regexp'] = ['rule' => 'stringOrEmpty'];
$_CONF_VALIDATE['Core']['filemanager_unallowed_dirs_regexp'] = ['rule' => 'stringOrEmpty'];

// Subgroup Filemanager, Tab Images
//$_CONF_VALIDATE['Core']['filemanager_images_ext'] = array('rule' => 'boolean');

// Subgroup Filemanager, Tab Videos
$_CONF_VALIDATE['Core']['filemanager_show_video_player'] = ['rule' => 'boolean'];
//$_CONF_VALIDATE['Core']['filemanager_videos_ext'] = array('rule' => 'boolean');
$_CONF_VALIDATE['Core']['filemanager_videos_player_width'] = ['rule' => 'numeric'];
$_CONF_VALIDATE['Core']['filemanager_videos_player_height'] = ['rule' => 'numeric'];

// Subgroup Filemanager, Tab Audios
$_CONF_VALIDATE['Core']['filemanager_show_audio_player'] = ['rule' => 'boolean'];
//$_CONF_VALIDATE['Core']['filemanager_audios_ext'] = array('rule' => 'boolean');
