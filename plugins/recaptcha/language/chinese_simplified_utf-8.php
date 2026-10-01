<?php

// +---------------------------------------------------------------------------+
// | reCAPTCHA Plugin for Geeklog - The Ultimate Weblog                        |
// +---------------------------------------------------------------------------+
// | geeklog/plugins/recaptcha/language/chinese_simplified_utf-8.php        |
// +---------------------------------------------------------------------------+
// | Copyright (C) 2014-2020 mystral-kk - geeklog AT mystral-kk DOT net        |
// |                                                                           |
// | Based on the CAPTCHA Plugin by Ben                                        |
// |                                                - ben AT geeklog DOT fr    |
// | Based on the original CAPTCHA Plugin by Mark R. Evans                     |
// |                                                - mark AT glfusion DOT org |
// | Constructed with the Universal Plugin                                     |
// +---------------------------------------------------------------------------|
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
// | along with this program; if not, write to the Free Software               |
// | Foundation, Inc., 59 Temple Place - Suite 330, Boston, MA  02111-1307, USA|
// |                                                                           |
// +---------------------------------------------------------------------------+

if (stripos($_SERVER['PHP_SELF'], basename(__FILE__)) !== false) {
    die('This file cannot be used on its own!');
}

$LANG_RECAPTCHA = [
    'plugin'      => 'reCAPTCHA',
    'admin'       => 'reCAPTCHA',
    'msg_error'   => '错误：reCAPTCHA 验证无效。',
    'entry_error' => '在 %1s 中输入了无效的 reCAPTCHA 字符串 - IP 地址：%2s - 错误代码：%3s',    // %1s = $type, %2s = $ip, %3s = $errorCode
];

// Localization of the Admin Configuration UI
$LANG_configsections['recaptcha'] = [
    'label' => 'reCAPTCHA',
    'title' => 'reCAPTCHA 配置',
];

$LANG_confignames['recaptcha'] = [
    'site_key'             => 'reCAPTCHA V2 站点密钥',
    'secret_key'           => 'reCAPTCHA V2 密钥',
    'invisible_site_key'   => '隐形 reCAPTCHA 站点密钥',
    'invisible_secret_key' => '隐形 reCAPTCHA 密钥',
    'site_key_v3'          => 'reCAPTCHA V3 站点密钥',
    'secret_key_v3'        => 'reCAPTCHA V3 密钥',
    'logging'              => '记录无效的 reCAPTCHA 尝试',
    'anonymous_only'       => '仅匿名用户',
    'remoteusers'          => '对所有远程用户强制使用 reCAPTCHA',
    'enable_comment'       => '启用评论支持',
    'enable_contact'       => '启用联系表单支持',
    'enable_emailstory'    => '启用文章邮件发送支持',
    'enable_registration'  => '启用注册支持',
    'enable_loginform'     => '启用登录表单支持',
    'enable_getpassword'   => '启用找回密码表单支持',
    'enable_story'         => '启用文章支持',
    'score_comment'        => '评论评分阈值',
    'score_contact'        => '联系表单评分阈值',
    'score_emailstory'     => '文章邮件发送评分阈值',
    'score_registration'   => '注册评分阈值',
    'score_loginform'      => '登录表单评分阈值',
    'score_getpassword'    => '找回密码表单评分阈值',
    'score_story'          => '文章评分阈值',
];

$LANG_configsubgroups['recaptcha'] = [
    'sg_main' => '主要设置',
];

$LANG_tab['recaptcha'] = [
    'tab_general'     => 'reCAPTCHA 设置',
    'tab_integration' => 'Geeklog 集成',
    'tab_score'       => '评分阈值',
];

$LANG_fs['recaptcha'] = [
    'fs_system'      => '系统',
    'fs_integration' => 'Geeklog 集成',
    'fs_score'       => '评分阈值',
];

// Note: entries 0, 1, 9, and 12 are the same as in $LANG_configselects['Core']
$LANG_configselects['recaptcha'] = [
    0 => ['是' => 1, '否' => 0],
    2 => ['已禁用' => 0, 'reCAPTCHA V2' => 1, 'reCAPTCHA V2 隐形' => 2, 'reCAPTCHA V3' => 4],
];
