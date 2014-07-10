<?php

/* Reminder: always indent with 4 spaces (no tabs). */
// +---------------------------------------------------------------------------+
// | Geeklog 1.7                                                               |
// +---------------------------------------------------------------------------+
// | configuration_validation.php                                              |
// |                                                                           |
// | List of validation rules for Core configurations                          |
// +---------------------------------------------------------------------------+
// | Copyright (C) 2007-2010 by the following authors:                         |
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

if (strpos(strtolower($_SERVER['PHP_SELF']), 'configuration_validation.php') !== false) {
    die('This file can not be used on its own!');
}

/* Subgroup Site, Tab Site */
$_CONF_VALIDATE['Core']['site_url'] = array('rule' => 'url');
$_CONF_VALIDATE['Core']['site_admin_url'] = array('rule' => 'url');
$_CONF_VALIDATE['Core']['site_name'] = array('rule' => 'notEmpty');
$_CONF_VALIDATE['Core']['site_slogan'] = array('rule' => 'stringOrEmpty');
$_CONF_VALIDATE['Core']['owner_name'] = array('rule' => 'stringOrEmpty');
$_CONF_VALIDATE['Core']['microsummary_short'] = array('rule' => 'stringOrEmpty');
$_CONF_VALIDATE['Core']['site_disabled_msg'] = array('rule' => 'stringOrEmpty');
$_CONF_VALIDATE['Core']['copyrightyear'] = array(
    'rule' => 'copyrightyear',
    'message' => isset($LANG_VALIDATION['yearOrRange']) ? $LANG_VALIDATION['yearOrRange'] : $LANG_VALIDATION['default']
);
$_CONF_VALIDATE['Core']['url_rewrite'] = array('rule' => 'boolean');
$_CONF_VALIDATE['Core']['cdn_hosted'] = array('rule' => 'boolean');
$_CONF_VALIDATE['Core']['meta_tags'] = array('rule' => array('inList', array(0, 1, 2), false));
$_CONF_VALIDATE['Core']['meta_description'] = array('rule' => 'stringOrEmpty');
$_CONF_VALIDATE['Core']['meta_keywords'] = array('rule' => 'stringOrEmpty');

/* Subgroup Site, Tab Mail */
$_CONF_VALIDATE['Core']['site_mail'] = array('rule' => 'email');
$_CONF_VALIDATE['Core']['noreply_mail'] = array('rule' => 'email');
$_CONF_VALIDATE['Core']['mail_settings[backend]'] = array(
    'rule' => array('inList', array('smtp', 'sendmail', 'mail')),
    'message' => isset($LANG_VALIDATION['mail_settings_backend']) ? 
                 $LANG_VALIDATION['mail_settings_backend'] : $LANG_VALIDATION['default']
);
$_CONF_VALIDATE['Core']['mail_settings[sendmail_path]'] = array(
    'rule' => 'mail_settings_sendmail_path',
    'message' => isset($LANG_VALIDATION['mail_settings_sendmail_path']) ? 
                 $LANG_VALIDATION['mail_settings_sendmail_path'] : $LANG_VALIDATION['default']
);
$_CONF_VALIDATE['Core']['mail_settings[host]'] = array(
    'rule' => 'url',
    'message' => isset($LANG_VALIDATION['mail_settings_host']) ? 
                 $LANG_VALIDATION['mail_settings_host'] : $LANG_VALIDATION['default']
);
$_CONF_VALIDATE['Core']['mail_settings[port]'] = array(
    'rule' => array('range', 0, 65535),
    'message' => isset($LANG_VALIDATION['mail_settings_port']) ? 
                 $LANG_VALIDATION['mail_settings_port'] : $LANG_VALIDATION['default']
);
$_CONF_VALIDATE['Core']['mail_settings[auth]'] = array('rule' => 'boolean');
$_CONF_VALIDATE['Core']['mail_settings[username]'] = array('rule' => 'notEmpty');
$_CONF_VALIDATE['Core']['mail_settings[password]'] = array('rule' => 'notEmpty');
$_CONF_VALIDATE['Core']['cc_enabled'] = array('rule' => 'boolean');
$_CONF_VALIDATE['Core']['cc_default'] = array('rule' => 'boolean');

/* Subgroup Site, Tab Syndication */
$_CONF_VALIDATE['Core']['backend'] = array('rule' => 'boolean');
$_CONF_VALIDATE['Core']['rdf_file'] = array('rule' => 'notEmpty');
$_CONF_VALIDATE['Core']['rdf_limit'] = array(
    'rule' => 'rdf_limit',
    'message' => isset($LANG_VALIDATION['rdf_limit']) ? 
                 $LANG_VALIDATION['rdf_limit'] : $LANG_VALIDATION['default']
);
$_CONF_VALIDATE['Core']['rdf_storytext'] = array('rule' => 'numeric');
$_CONF_VALIDATE['Core']['rdf_language'] = array('rule' => 'notEmpty');
$_CONF_VALIDATE['Core']['syndication_max_headlines'] = array('rule' => 'numeric');
$_CONF_VALIDATE['Core']['comment_feeds_article_tag'] = array('rule' => 'notEmpty');
$_CONF_VALIDATE['Core']['comment_feeds_article_tag_position'] = array(
    'rule' => array('inList', array('start', 'end', 'none'), true)
);
$_CONF_VALIDATE['Core']['comment_feeds_article_author_tag'] = array('rule' => 'stringOrEmpty');
$_CONF_VALIDATE['Core']['comment_feeds_comment_author_tag'] = array('rule' => 'stringOrEmpty');

/* Subgroup Site, Tab Paths */
$_CONF_VALIDATE['Core']['path_html'] = array(
    'rule' => 'path',
    'message' => isset($LANG_VALIDATION['path']) ? 
                 $LANG_VALIDATION['path'] : $LANG_VALIDATION['default']
);
$_CONF_VALIDATE['Core']['path_log'] = array(
    'rule' => 'path',
    'message' => isset($LANG_VALIDATION['path']) ? 
                 $LANG_VALIDATION['path'] : $LANG_VALIDATION['default']
);
$_CONF_VALIDATE['Core']['path_language'] = array(
    'rule' => 'path',
    'message' => isset($LANG_VALIDATION['path']) ? 
                 $LANG_VALIDATION['path'] : $LANG_VALIDATION['default']
);
$_CONF_VALIDATE['Core']['backup_path'] = array(
    'rule' => 'path',
    'message' => isset($LANG_VALIDATION['path']) ? 
                 $LANG_VALIDATION['path'] : $LANG_VALIDATION['default']
);
$_CONF_VALIDATE['Core']['path_data'] = array(
    'rule' => 'path',
    'message' => isset($LANG_VALIDATION['path']) ? 
                 $LANG_VALIDATION['path'] : $LANG_VALIDATION['default']
);
$_CONF_VALIDATE['Core']['path_images'] = array(
    'rule' => 'path',
    'message' => isset($LANG_VALIDATION['path']) ? 
                 $LANG_VALIDATION['path'] : $LANG_VALIDATION['default']
);
$_CONF_VALIDATE['Core']['path_editors'] = array(
    'rule' => 'path',
    'message' => isset($LANG_VALIDATION['path']) ? 
                 $LANG_VALIDATION['path'] : $LANG_VALIDATION['default']
);

/* Subgroup Site, Tab Pear */
$_CONF_VALIDATE['Core']['have_pear'] = array('rule' => 'boolean');
$_CONF_VALIDATE['Core']['path_pear'] = array(
    'rule' => 'path',
    'message' => isset($LANG_VALIDATION['path']) ? 
                 $LANG_VALIDATION['path'] : $LANG_VALIDATION['default']
);

/* Subgroup Site, Tab MySQL */
$_CONF_VALIDATE['Core']['allow_mysqldump'] = array('rule' => 'boolean');
$_CONF_VALIDATE['Core']['mysqldump_path'] = array(
    'rule' => 'file',
    'message' => isset($LANG_VALIDATION['file']) ? 
                 $LANG_VALIDATION['file'] : $LANG_VALIDATION['default']
);
$_CONF_VALIDATE['Core']['mysqldump_filename_mask'] = array('rule' => 'notEmpty');

/* Subgroup Site, Tab Search */
$_CONF_VALIDATE['Core']['search_style'] = array('rule' => array('inList', array('google', 'table'), true));
$_CONF_VALIDATE['Core']['search_limits'] = array(
    'rule' => 'search_limits',
    'message' => isset($LANG_VALIDATION['search_limits']) ? 
                 $LANG_VALIDATION['search_limits'] : $LANG_VALIDATION['default']
);
$_CONF_VALIDATE['Core']['num_search_results'] = array(
    'rule' => 'num_search_results',
    'message' => isset($LANG_VALIDATION['num_search_results']) ? 
                 $LANG_VALIDATION['num_search_results'] : $LANG_VALIDATION['default']
);
$_CONF_VALIDATE['Core']['search_show_limit'] = array('rule' => 'boolean');
$_CONF_VALIDATE['Core']['search_show_sort'] = array('rule' => 'boolean');
$_CONF_VALIDATE['Core']['search_show_num'] = array('rule' => 'boolean');
$_CONF_VALIDATE['Core']['search_show_type'] = array('rule' => 'boolean');
$_CONF_VALIDATE['Core']['search_separator'] = array('rule' => 'string');
$_CONF_VALIDATE['Core']['search_def_keytype'] = array(
    'rule' => array('inList', array('all', 'any', 'phrase'), true)
);
$_CONF_VALIDATE['Core']['search_def_sort'] = array(
    'rule' => array('inList', array(
        'uid|asc', 'uid|desc', 'date|asc', 'date|desc', 'hits|asc',
        'hits|desc', 'title|asc', 'title|desc'
    ), true)
);

/* Subgroup Stories and Trackback, Tab Story */
$_CONF_VALIDATE['Core']['maximagesperarticle'] = array('rule' => 'numeric');
$_CONF_VALIDATE['Core']['limitnews'] = array('rule' => 'numeric');
$_CONF_VALIDATE['Core']['minnews'] = array('rule' => 'numeric');
$_CONF_VALIDATE['Core']['contributedbyline'] = array('rule' => 'boolean');
$_CONF_VALIDATE['Core']['hideviewscount'] = array('rule' => 'boolean');
$_CONF_VALIDATE['Core']['hideemailicon'] = array('rule' => 'boolean');
$_CONF_VALIDATE['Core']['hideprintericon'] = array('rule' => 'boolean');
$_CONF_VALIDATE['Core']['allow_page_breaks'] = array('rule' => 'boolean');
$_CONF_VALIDATE['Core']['page_break_comments'] = array(
    'rule' => array('inList', array('all', 'first', 'last'), true)
);
$_CONF_VALIDATE['Core']['article_image_align'] = array(
    'rule' => array('inList', array('left', 'right'), true)
);
$_CONF_VALIDATE['Core']['show_topic_icon'] = array('rule' => 'boolean');
$_CONF_VALIDATE['Core']['draft_flag'] = array('rule' => 'boolean');
$_CONF_VALIDATE['Core']['frontpage'] = array('rule' => 'boolean');
$_CONF_VALIDATE['Core']['hide_no_news_msg'] = array('rule' => 'boolean');
$_CONF_VALIDATE['Core']['hide_main_page_navigation'] = array('rule' => 'boolean');
$_CONF_VALIDATE['Core']['onlyrootfeatures'] = array('rule' => 'boolean');
$_CONF_VALIDATE['Core']['aftersave_story'] = array(
    'rule' => array('inList', array('admin', 'home', 'list', 'item'), true)
);
$_CONF_VALIDATE['Core']['related_topics'] = array(
    'rule' => array('inList', array(0, 1, 2), false)
);
$_CONF_VALIDATE['Core']['related_topics_max'] = array('rule' => 'numeric');
$_CONF_VALIDATE['Core']['whats_related'] = array(
    'rule' => array('inList', array(0, 1, 2, 3), false)
);    
$_CONF_VALIDATE['Core']['whats_related_max'] = array('rule' => 'numeric');
$_CONF_VALIDATE['Core']['whats_related_trim'] = array('rule' => 'numeric');
$_CONF_VALIDATE['Core']['default_cache_time_article'] = array('rule' => 'numeric');

/* Subgroup Stories and Trackback, Tab Trackback */
$_CONF_VALIDATE['Core']['trackback_enabled'] = array('rule' => 'boolean');
$_CONF_VALIDATE['Core']['trackback_code'] = array(
    'rule' => array('inList', array(-1, 0), false)
);
$_CONF_VALIDATE['Core']['trackbackspeedlimit'] = array('rule' => 'numeric');
$_CONF_VALIDATE['Core']['check_trackback_link'] = array(
    'rule' => array('inList', array(0, 1, 2, 3, 4, 5, 6, 7), false)
);
$_CONF_VALIDATE['Core']['multiple_trackbacks'] = array(
    'rule' => array('inList', array(0, 1, 2), false)
);

/* Subgroup Stories and Trackback, Tab Pingback */
$_CONF_VALIDATE['Core']['pingback_enabled'] = array('rule' => 'boolean');
$_CONF_VALIDATE['Core']['pingback_excerpt'] = array('rule' => 'boolean');
$_CONF_VALIDATE['Core']['pingback_self'] = array(
    'rule' => array('inList', array(0, 1, 2), false)
);
$_CONF_VALIDATE['Core']['ping_enabled'] = array('rule' => 'boolean');

/* Subgroup Theme, Tab Theme */
$_CONF_VALIDATE['Core']['theme'] = array(
    'rule' => 'theme',
    'message' => isset($LANG_VALIDATION['theme']) ? 
                 $LANG_VALIDATION['theme'] : $LANG_VALIDATION['default']
);
$_CONF_VALIDATE['Core']['doctype'] = array(
    'rule' => array('inList', array(
        'html401strict', 'html401transitional', 'xhtml10strict', 'xhtml10transitional', 'html5', 'xhtml5'
    ), true)
);
$_CONF_VALIDATE['Core']['path_themes'] = array(
    'rule' => 'path_themes',
    'message' => isset($LANG_VALIDATION['path_themes']) ? 
                 $LANG_VALIDATION['path_themes'] : $LANG_VALIDATION['default']
);
$_CONF_VALIDATE['Core']['cache_templates'] = array('rule' => 'boolean');

/* Subgroup Theme, Tab Advanced Settings */
$_CONF_VALIDATE['Core']['show_right_blocks'] = array('rule' => 'boolean');
$_CONF_VALIDATE['Core']['showfirstasfeatured'] = array('rule' => 'boolean');
$_CONF_VALIDATE['Core']['template_comments'] = array('rule' => 'boolean');

/* Subgroup Blocks, Tab Admin Block */
$_CONF_VALIDATE['Core']['sort_admin'] = array('rule' => 'boolean');
$_CONF_VALIDATE['Core']['link_documentation'] = array('rule' => 'boolean');
$_CONF_VALIDATE['Core']['link_versionchecker'] = array('rule' => 'boolean');

/* Subgroup Blocks, Tab Topics Block */
$_CONF_VALIDATE['Core']['sortmethod'] = array('rule' => array('inList', array('alpha', 'sortnum'), true));
$_CONF_VALIDATE['Core']['showstorycount'] = array('rule' => 'boolean');
$_CONF_VALIDATE['Core']['showsubmissioncount'] = array('rule' => 'boolean');
$_CONF_VALIDATE['Core']['hide_home_link'] = array('rule' => 'boolean');

/* Subgroup Blocks, Tab Who's Online Block */
$_CONF_VALIDATE['Core']['whosonline_threshold'] = array('rule' => 'numeric');
$_CONF_VALIDATE['Core']['whosonline_anonymous'] = array('rule' => 'boolean');
$_CONF_VALIDATE['Core']['whosonline_photo'] = array('rule' => 'boolean');

/* Subgroup Blocks, Tab What's New Block */
$_CONF_VALIDATE['Core']['newstoriesinterval'] = array('rule' => 'numeric');
$_CONF_VALIDATE['Core']['newcommentsinterval'] = array('rule' => 'numeric');
$_CONF_VALIDATE['Core']['newtrackbackinterval'] = array('rule' => 'numeric');
$_CONF_VALIDATE['Core']['hidenewstories'] = array('rule' => 'boolean');
$_CONF_VALIDATE['Core']['hidenewcomments'] = array('rule' => 'boolean');
$_CONF_VALIDATE['Core']['hidenewtrackbacks'] = array('rule' => 'boolean');
$_CONF_VALIDATE['Core']['hidenewplugins'] = array('rule' => 'boolean');
$_CONF_VALIDATE['Core']['title_trim_length'] = array('rule' => 'numeric');
$_CONF_VALIDATE['Core']['whatsnew_cache_time'] = array('rule' => 'numeric');

/* Subgroup Users and Submissions, Tab Users */
$_CONF_VALIDATE['Core']['disable_new_user_registration'] = array('rule' => 'boolean');
$_CONF_VALIDATE['Core']['allow_user_themes'] = array('rule' => 'boolean');
$_CONF_VALIDATE['Core']['allow_user_photo'] = array('rule' => 'boolean');
$_CONF_VALIDATE['Core']['allow_username_change'] = array('rule' => 'boolean');
$_CONF_VALIDATE['Core']['allow_account_delete'] = array('rule' => 'boolean');
$_CONF_VALIDATE['Core']['hide_author_exclusion'] = array('rule' => 'boolean');
$_CONF_VALIDATE['Core']['show_fullname'] = array('rule' => 'boolean');
$_CONF_VALIDATE['Core']['show_servicename'] = array('rule' => 'boolean');
$_CONF_VALIDATE['Core']['custom_registration'] = array('rule' => 'boolean');
$_CONF_VALIDATE['Core']['user_login_method[standard]'] = array('rule' => 'boolean');
$_CONF_VALIDATE['Core']['user_login_method[openid]'] = array('rule' => 'boolean');
$_CONF_VALIDATE['Core']['user_login_method[3rdparty]'] = array('rule' => 'boolean');
$_CONF_VALIDATE['Core']['user_login_method[oauth]'] = array('rule' => 'boolean');
$_CONF_VALIDATE['Core']['facebook_login'] = array('rule' => 'boolean');
$_CONF_VALIDATE['Core']['facebook_consumer_key'] = array('rule' => 'stringOrEmpty');
$_CONF_VALIDATE['Core']['facebook_consumer_secret'] = array('rule' => 'stringOrEmpty');
$_CONF_VALIDATE['Core']['linkedin_login'] = array('rule' => 'boolean');
$_CONF_VALIDATE['Core']['linkedin_consumer_key'] = array('rule' => 'stringOrEmpty');
$_CONF_VALIDATE['Core']['linkedin_consumer_secret'] = array('rule' => 'stringOrEmpty');
$_CONF_VALIDATE['Core']['twitter_login'] = array('rule' => 'boolean');
$_CONF_VALIDATE['Core']['twitter_consumer_key'] = array('rule' => 'stringOrEmpty');
$_CONF_VALIDATE['Core']['twitter_consumer_secret'] = array('rule' => 'stringOrEmpty');
$_CONF_VALIDATE['Core']['google_login'] = array('rule' => 'boolean');
$_CONF_VALIDATE['Core']['google_consumer_key'] = array('rule' => 'stringOrEmpty');
$_CONF_VALIDATE['Core']['google_consumer_secret'] = array('rule' => 'stringOrEmpty');
$_CONF_VALIDATE['Core']['microsoft_login'] = array('rule' => 'boolean');
$_CONF_VALIDATE['Core']['microsoft_consumer_key'] = array('rule' => 'stringOrEmpty');
$_CONF_VALIDATE['Core']['microsoft_consumer_secret'] = array('rule' => 'stringOrEmpty');
$_CONF_VALIDATE['Core']['yahoo_login'] = array('rule' => 'boolean');
$_CONF_VALIDATE['Core']['yahoo_consumer_key'] = array('rule' => 'stringOrEmpty');
$_CONF_VALIDATE['Core']['yahoo_consumer_secret'] = array('rule' => 'stringOrEmpty');

$_CONF_VALIDATE['Core']['aftersave_user'] = array(
    'rule' => array('inList', array('admin', 'home', 'list', 'item'), true)
);

/* Subgroup Users and Submissions, Tab Spam-X */
$_CONF_VALIDATE['Core']['spamx'] = array('rule' => 'numeric');

/* Subgroup Users and Submissions, Tab Login Settings */
$_CONF_VALIDATE['Core']['lastlogin'] = array('rule' => 'boolean');
$_CONF_VALIDATE['Core']['loginrequired'] = array('rule' => 'boolean');
$_CONF_VALIDATE['Core']['submitloginrequired'] = array('rule' => 'boolean');
$_CONF_VALIDATE['Core']['commentsloginrequired'] = array('rule' => 'boolean');
$_CONF_VALIDATE['Core']['statsloginrequired'] = array('rule' => 'boolean');
$_CONF_VALIDATE['Core']['searchloginrequired'] = array(
    'rule' => array('inList', array(0, 1, 2), false)
);
$_CONF_VALIDATE['Core']['profileloginrequired'] = array('rule' => 'boolean');
$_CONF_VALIDATE['Core']['emailuserloginrequired'] = array('rule' => 'boolean');
$_CONF_VALIDATE['Core']['emailstoryloginrequired'] = array('rule' => 'boolean');
$_CONF_VALIDATE['Core']['directoryloginrequired'] = array('rule' => 'boolean');
$_CONF_VALIDATE['Core']['passwordspeedlimit'] = array('rule' => 'numeric');
$_CONF_VALIDATE['Core']['login_attempts'] = array('rule' => 'numeric');
$_CONF_VALIDATE['Core']['login_speedlimit'] = array('rule' => 'numeric');

/* Subgroup User and Submissions, Tab Login Settings, Fieldset Password */
$_CONF_VALIDATE['Core']['pass_alg'] = array(
    'rule' => 'hash_function',
    'message' => isset($LANG_VALIDATION['hash']) ? 
                 $LANG_VALIDATION['hash'] : $LANG_VALIDATION['default']
);
$_CONF_VALIDATE['Core']['pass_stretch'] = array('rule' => array('comparison', '>', 0));


/* Subgroup Users and Submissions, Tab User Submission */
$_CONF_VALIDATE['Core']['usersubmission'] = array('rule' => 'boolean');

/* Subgroup Users and Submissions, Tab User Submission Settings */
$_CONF_VALIDATE['Core']['storysubmission'] = array('rule' => 'boolean');
$_CONF_VALIDATE['Core']['listdraftstories'] = array('rule' => 'boolean');
$_CONF_VALIDATE['Core']['postmode'] = array(
    'rule' => array('inList', array('html', 'plaintext', 'wikitext'), true)
);
$_CONF_VALIDATE['Core']['speedlimit'] = array('rule' => 'numeric');
$_CONF_VALIDATE['Core']['skip_preview'] = array('rule' => 'boolean');
$_CONF_VALIDATE['Core']['advanced_editor'] = array('rule' => 'boolean');
$_CONF_VALIDATE['Core']['advanced_editor_name'] = array('rule' => 'notEmpty');
$_CONF_VALIDATE['Core']['wikitext_editor'] = array('rule' => 'boolean');

/* Subgroup Users and Submissions, Tab Comments */
$_CONF_VALIDATE['Core']['commentspeedlimit'] = array('rule' => 'numeric');
$_CONF_VALIDATE['Core']['comment_limit'] = array('rule' => 'numeric');
$_CONF_VALIDATE['Core']['comment_mode'] = array(
    'rule' => array('inList', array('flat', 'nested', 'nocomment', 'threaded'), true)
);
$_CONF_VALIDATE['Core']['comment_order'] = array(
    'rule' => array('inList', array('DESC', 'ASC'), true)
);
$_CONF_VALIDATE['Core']['comment_code'] = array(
    'rule' => array('inList', array(0, -1), false)
);
$_CONF_VALIDATE['Core']['comment_edit'] = array('rule' => 'boolean');
$_CONF_VALIDATE['Core']['commentsubmission'] = array('rule' => 'boolean');
$_CONF_VALIDATE['Core']['comment_edittime'] = array('rule' => 'numeric');
$_CONF_VALIDATE['Core']['article_comment_close_enabled'] = array('rule' => 'boolean');
$_CONF_VALIDATE['Core']['article_comment_close_days'] = array('rule' => 'numeric');
$_CONF_VALIDATE['Core']['comment_close_rec_stories'] = array('rule' => 'numeric');
$_CONF_VALIDATE['Core']['allow_reply_notifications'] = array('rule' => 'boolean');
$_CONF_VALIDATE['Core']['comment_on_same_page'] = array('rule' => 'boolean');
$_CONF_VALIDATE['Core']['show_comments_at_replying'] = array('rule' => 'boolean');

/* Subgroup Images, Tab Image Library */
$_CONF_VALIDATE['Core']['image_lib'] = array(
    'rule' => array('inList', array('', 'gdlib', 'imagemagick', 'netpbm'), true)
);
$_CONF_VALIDATE['Core']['path_to_mogrify'] = array(
    'rule' => 'path_to_mogrify',
    'message' => isset($LANG_VALIDATION['path_to_mogrify']) ? 
                 $LANG_VALIDATION['path_to_mogrify'] : $LANG_VALIDATION['default']
);
$_CONF_VALIDATE['Core']['path_to_netpbm'] = array(
    'rule' => 'path_to_netpbm',
    'message' => isset($LANG_VALIDATION['path_to_netpbm']) ? 
                 $LANG_VALIDATION['path_to_netpbm'] : $LANG_VALIDATION['default']
);

/* Subgroup Images, Tab Upload */
$_CONF_VALIDATE['Core']['keep_unscaled_image'] = array('rule' => 'boolean');
$_CONF_VALIDATE['Core']['allow_user_scaling'] = array('rule' => 'boolean');
$_CONF_VALIDATE['Core']['jpeg_quality'] = array('rule' => array('range', 0, 100));
$_CONF_VALIDATE['Core']['debug_image_upload'] = array('rule' => 'boolean');

/* Subgroup Images, Tab Images in Articles */
$_CONF_VALIDATE['Core']['max_image_width'] = array('rule' => 'numeric');
$_CONF_VALIDATE['Core']['max_image_height'] = array('rule' => 'numeric');
$_CONF_VALIDATE['Core']['max_image_size'] = array('rule' => 'numeric');

/* Subgroup Images, Tab Topic Icons */
$_CONF_VALIDATE['Core']['max_topicicon_width'] = array('rule' => 'numeric');
$_CONF_VALIDATE['Core']['max_topicicon_height'] = array('rule' => 'numeric');
$_CONF_VALIDATE['Core']['max_topicicon_size'] = array('rule' => 'numeric');

/* Subgroup Images, Tab Photos */
$_CONF_VALIDATE['Core']['max_photo_width'] = array('rule' => 'numeric');
$_CONF_VALIDATE['Core']['max_photo_height'] = array('rule' => 'numeric');
$_CONF_VALIDATE['Core']['max_photo_size'] = array('rule' => 'numeric');
$_CONF_VALIDATE['Core']['force_photo_width'] = array('rule' => 'numeric');
$_CONF_VALIDATE['Core']['default_photo'] = array('rule' => 'url');

/* Subgroup Images, Tab Gravatar */
$_CONF_VALIDATE['Core']['use_gravatar'] = array('rule' => 'boolean');
$_CONF_VALIDATE['Core']['gravatar_rating'] = array(
    'rule' => array('inList', array('G', 'PG', 'R', 'X'), true)
);

/* Subgroup Language, Tab Language */
$_CONF_VALIDATE['Core']['language'] = array(
    'rule' => 'language',
    'message' => isset($LANG_VALIDATION['language']) ? 
                 $LANG_VALIDATION['language'] : $LANG_VALIDATION['default']
);
$_CONF_VALIDATE['Core']['allow_user_language'] = array('rule' => 'boolean');

/* Subgroup Language, Tab Locale */
$_CONF_VALIDATE['Core']['locale']     = array('rule' => 'stringOrEmpty');
$_CONF_VALIDATE['Core']['date']       = array('rule' => 'stringOrEmpty');
$_CONF_VALIDATE['Core']['daytime']    = array('rule' => 'stringOrEmpty');
$_CONF_VALIDATE['Core']['shortdate']  = array('rule' => 'stringOrEmpty');
$_CONF_VALIDATE['Core']['dateonly']   = array('rule' => 'stringOrEmpty');
$_CONF_VALIDATE['Core']['timeonly']   = array('rule' => 'stringOrEmpty');
$_CONF_VALIDATE['Core']['week_start'] = array(
    'rule' => array('inList', array('Mon', 'Sun'), true)
);
$_CONF_VALIDATE['Core']['hour_mode'] = array(
    'rule' => array('inList', array(12, 24), false)
);
$_CONF_VALIDATE['Core']['thousand_separator'] = array(
    'rule' => 'single_char',
    'message' => isset($LANG_VALIDATION['single_char']) ? 
                 $LANG_VALIDATION['single_char'] : $LANG_VALIDATION['default']
);
$_CONF_VALIDATE['Core']['decimal_separator'] = array(
    'rule' => 'single_char',
    'message' => isset($LANG_VALIDATION['single_char']) ? 
                 $LANG_VALIDATION['single_char'] : $LANG_VALIDATION['default']
);
$_CONF_VALIDATE['Core']['decimal_count'] = array('rule' => 'numeric');
$_CONF_VALIDATE['Core']['timezone'] = array(
    'rule' => 'timezone',
    'message' => isset($LANG_VALIDATION['timezone']) ? 
                 $LANG_VALIDATION['timezone'] : $LANG_VALIDATION['default']
);

/* Subgroup Misc, Tab Cookies */
$_CONF_VALIDATE['Core']['cookie_session'] = array('rule' => 'notEmpty');
$_CONF_VALIDATE['Core']['cookie_name'] = array('rule' => 'notEmpty');
$_CONF_VALIDATE['Core']['cookie_password'] = array('rule' => 'notEmpty');
$_CONF_VALIDATE['Core']['cookie_theme'] = array('rule' => 'notEmpty');
$_CONF_VALIDATE['Core']['cookie_language'] = array('rule' => 'notEmpty');
$_CONF_VALIDATE['Core']['cookie_tzid'] = array('rule' => 'notEmpty');
$_CONF_VALIDATE['Core']['cookie_anon_name'] = array('rule' => 'notEmpty');
$_CONF_VALIDATE['Core']['cookie_ip'] = array('rule' => 'boolean');
$_CONF_VALIDATE['Core']['default_perm_cookie_timeout'] = array(
    'rule' => array('inList', array(0, 3600, 7200, 10800, 28800, 86400, 604800, 2678400), false)
);
$_CONF_VALIDATE['Core']['session_cookie_timeout'] = array('rule' => 'numeric');
$_CONF_VALIDATE['Core']['cookiesecure'] = array('rule' => 'boolean');

/* Subgroup Misc, Tab Misc */
$_CONF_VALIDATE['Core']['cron_schedule_interval'] = array('rule' => 'numeric');
$_CONF_VALIDATE['Core']['disable_autolinks'] = array('rule' => 'boolean');
$_CONF_VALIDATE['Core']['clickable_links'] = array('rule' => 'boolean');
$_CONF_VALIDATE['Core']['linktext_maxlen'] = array('rule' => 'numeric');
$_CONF_VALIDATE['Core']['compressed_output'] = array('rule' => 'boolean');
$_CONF_VALIDATE['Core']['frame_options'] = array(
    'rule' => array('inList', array('', 'SAMEORIGIN', 'DENY'), true)
);
$_CONF_VALIDATE['Core']['page_navigation_max_pages'] = array(
    'rule' => array('range', 2, 21),
    'message' => isset($LANG_VALIDATION['page_navigation_max_pages']) ? 
                 $LANG_VALIDATION['page_navigation_max_pages'] : $LANG_VALIDATION['default']
);
$_CONF_VALIDATE['Core']['default_cache_time_block'] = array('rule' => 'numeric');
$_CONF_VALIDATE['Core']['titletoid'] = array('rule' => 'boolean');

/* Subgroup Misc, Tab Debug */
$_CONF_VALIDATE['Core']['rootdebug'] = array('rule' => 'boolean');

/* Subgroup Misc, Tab Daily Digest */
$_CONF_VALIDATE['Core']['emailstories'] = array('rule' => 'boolean');
$_CONF_VALIDATE['Core']['emailstorieslength'] = array('rule' => 'numeric');
$_CONF_VALIDATE['Core']['emailstoriesperdefault'] = array('rule' => 'boolean');

/* Subgroup Misc, Tab HTML Filtering */
$_CONF_VALIDATE['Core']['skip_html_filter_for_root'] = array('rule' => 'boolean');

/* Subgroup Misc, Tab Censoring */
$_CONF_VALIDATE['Core']['censormode'] = array(
    'rule' => array('inList', array(0, 1, 2, 3), false)
);
$_CONF_VALIDATE['Core']['censorreplace'] = array('rule' => 'stringOrEmpty');

/* Subgroup Misc, Tab Permissions */
$_CONF_VALIDATE['Core']['default_permissions_story[0]'] = array(
    'rule' => array('inList', array(0, 2, 3), true)
);
$_CONF_VALIDATE['Core']['default_permissions_story[1]'] = array(
    'rule' => array('inList', array(0, 2, 3), true)
);
$_CONF_VALIDATE['Core']['default_permissions_story[2]'] = array(
    'rule' => array('inList', array(0, 2, 3), true)
);
$_CONF_VALIDATE['Core']['default_permissions_story[3]'] = array(
    'rule' => array('inList', array(0, 2, 3), true)
);

/* Subgroup Misc, Tab Permissions */
$_CONF_VALIDATE['Core']['default_permissions_block[0]'] = array(
    'rule' => array('inList', array(0, 2, 3), true)
);
$_CONF_VALIDATE['Core']['default_permissions_block[1]'] = array(
    'rule' => array('inList', array(0, 2, 3), true)
);
$_CONF_VALIDATE['Core']['default_permissions_block[2]'] = array(
    'rule' => array('inList', array(0, 2, 3), true)
);
$_CONF_VALIDATE['Core']['default_permissions_block[3]'] = array(
    'rule' => array('inList', array(0, 2, 3), true)
);

/* Subgroup Misc, Tab Permissions */
$_CONF_VALIDATE['Core']['default_permissions_topic[0]'] = array(
    'rule' => array('inList', array(0, 2, 3), true)
);
$_CONF_VALIDATE['Core']['default_permissions_topic[1]'] = array(
    'rule' => array('inList', array(0, 2, 3), true)
);
$_CONF_VALIDATE['Core']['default_permissions_topic[2]'] = array(
    'rule' => array('inList', array(0, 2, 3), true)
);
$_CONF_VALIDATE['Core']['default_permissions_topic[3]'] = array(
    'rule' => array('inList', array(0, 2, 3), true)
);

/* Subgroup Misc, Tab Permissions */
$_CONF_VALIDATE['Core']['autotag_permissions_story[0]'] = array(
    'rule' => array('inList', array(0, 2), true)
);
$_CONF_VALIDATE['Core']['autotag_permissions_story[1]'] = array(
    'rule' => array('inList', array(0, 2), true)
);
$_CONF_VALIDATE['Core']['autotag_permissions_story[2]'] = array(
    'rule' => array('inList', array(0, 2), true)
);
$_CONF_VALIDATE['Core']['autotag_permissions_story[3]'] = array(
    'rule' => array('inList', array(0, 2), true)
);

$_CONF_VALIDATE['Core']['autotag_permissions_user[0]'] = array(
    'rule' => array('inList', array(0, 2), true)
);
$_CONF_VALIDATE['Core']['autotag_permissions_user[1]'] = array(
    'rule' => array('inList', array(0, 2), true)
);
$_CONF_VALIDATE['Core']['autotag_permissions_user[2]'] = array(
    'rule' => array('inList', array(0, 2), true)
);
$_CONF_VALIDATE['Core']['autotag_permissions_user[3]'] = array(
    'rule' => array('inList', array(0, 2), true)
);

/* Subgroup Misc, Tab Story Webservices */
$_CONF_VALIDATE['Core']['disable_webservices'] = array('rule' => 'boolean');
$_CONF_VALIDATE['Core']['restrict_webservices'] = array('rule' => 'boolean');
$_CONF_VALIDATE['Core']['atom_max_stories'] = array('rule' => 'numeric');

/* Subgroup Misc, Tab Topics */
$_CONF_VALIDATE['Core']['multiple_breadcrumbs']         = array('rule' => 'boolean');
$_CONF_VALIDATE['Core']['disable_breadcrumbs_topics']   = array('rule' => 'boolean');
$_CONF_VALIDATE['Core']['disable_breadcrumbs_articles'] = array('rule' => 'boolean');
$_CONF_VALIDATE['Core']['disable_breadcrumbs_plugins']  = array('rule' => 'boolean');
$_CONF_VALIDATE['Core']['breadcrumb_root_site_name']    = array('rule' => 'boolean');

// Subgroup Filemanager, Tab General Settings
$_CONF_VALIDATE['Core']['filemanager_disabled']            = array('rule' => 'boolean');
$_CONF_VALIDATE['Core']['filemanager_browse_only']         = array('rule' => 'boolean');
$_CONF_VALIDATE['Core']['filemanager_default_view_mode']   = array(
    'rule' => array('inList', array('grid', 'list'), true)
);
$_CONF_VALIDATE['Core']['filemanager_show_confirmation']   = array('rule' => 'boolean');
$_CONF_VALIDATE['Core']['filemanager_search_box']          = array('rule' => 'boolean');
$_CONF_VALIDATE['Core']['filemanager_file_sorting']        = array(
    'inList',
    array(
        'default', 'NAME_ASC', 'NAME_DESC', 'TYPE_ASC', 'TYPE_DESC',
        'MODIFIED_ASC', 'MODIFIED_DESC'
    ),
    true
);
$_CONF_VALIDATE['Core']['filemanager_chars_only_latin']    = array('rule' => 'boolean');
$_CONF_VALIDATE['Core']['filemanager_date_format']         = array('rule' => 'notEmpty');
$_CONF_VALIDATE['Core']['filemanager_logger']              = array('rule' => 'boolean');
$_CONF_VALIDATE['Core']['filemanager_show_thumbs']         = array('rule' => 'boolean');
$_CONF_VALIDATE['Core']['filemanager_generate_thumbnails'] = array('rule' => 'boolean');

// Subgroup Filemanager, Tab Upload
//$_CONF_VALIDATE['Core']['filemanager_upload_restrictions'] = array('rule' => 'boolean');
$_CONF_VALIDATE['Core']['filemanager_upload_overwrite']       = array('rule' => 'boolean');
$_CONF_VALIDATE['Core']['filemanager_upload_images_only']     = array('rule' => 'boolean');
$_CONF_VALIDATE['Core']['filemanager_upload_file_size_limit'] = array('rule' => 'numeric');
//$_CONF_VALIDATE['Core']['filemanager_unallowed_files'] = array('rule' => 'boolean');
//$_CONF_VALIDATE['Core']['filemanager_unallowed_dirs'] = array('rule' => 'boolean');
$_CONF_VALIDATE['Core']['filemanager_unallowed_files_regexp'] = array('rule' => 'stringOrEmpty');
$_CONF_VALIDATE['Core']['filemanager_unallowed_dirs_regexp']  = array('rule' => 'stringOrEmpty');

// Subgroup Filemanager, Tab Images
//$_CONF_VALIDATE['Core']['filemanager_images_ext'] = array('rule' => 'boolean');

// Subgroup Filemanager, Tab Videos
$_CONF_VALIDATE['Core']['filemanager_show_video_player']    = array('rule' => 'boolean');
//$_CONF_VALIDATE['Core']['filemanager_videos_ext'] = array('rule' => 'boolean');
$_CONF_VALIDATE['Core']['filemanager_videos_player_width']  = array('rule' => 'numeric');
$_CONF_VALIDATE['Core']['filemanager_videos_player_height'] = array('rule' => 'numeric');

// Subgroup Filemanager, Tab Audios
$_CONF_VALIDATE['Core']['filemanager_show_audio_player'] = array('rule' => 'boolean');
//$_CONF_VALIDATE['Core']['filemanager_audios_ext'] = array('rule' => 'boolean');

?>
