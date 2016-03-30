<?php
/**
 * About
 *
 * You may not change or alter any portion of this comment or credits
 * of supporting developers from this source code or any supporting source code
 * which is considered copyrighted (c) material of the original comment or credit authors.
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.
 *
 * @copyright      The XOOPS Co.Ltd. http://www.xoops.com.cn
 * @copyright      XOOPS Project (http://xoops.org)
 * @license        GNU GPL 2 or later (http://www.gnu.org/licenses/gpl-2.0.html)
 * @package        about
 * @since          1.0.0
 * @author         Mengjue Shao <magic.shao@gmail.com>
 * @author         Susheng Yang <ezskyyoung@gmail.com>
 * @version        $Id: modinfo.php 1 2010-2-9 ezsky$
 */

// _LANGCODE: zh-CN
// _CHARSET : utf-8
// Translator: ezsky, http://www.ezsky.org

//xoops_version  add   menu
define('_MI_ABOUT_NAME', 'About us');
define('_MI_ABOUT_DESC', "Extended 'About Us' webpage module for XOOPS");
define('_MI_ABOUT_PAGE', 'Page');
define('_MI_ABOUT_ABOUTUS', 'About Us');

define('_MI_ABOUT_CONFIG_LIST', 'Display');
define('_MI_ABOUT_CONFIG_LIST_CATEGORY', 'Category');
define('_MI_ABOUT_CONFIG_LIST_PAGE', 'Page');
define('_MI_ABOUT_CONFIG_STR_EREG', 'Article summary string limit');

define('_MI_ABOUT_DIRNAME', basename(dirname(dirname(__DIR__))));
define('_MI_ABOUT_HELP_HEADER', __DIR__ . '/help/helpheader.html');
define('_MI_ABOUT_BACK_2_ADMIN', 'Back to Administration of ');

//define('_MI_ABOUT_HELP_DIR', __DIR__);

//help
define('_MI_ABOUT_HELP_OVERVIEW', 'Overview');

define('_MI_ABOUT_EDITOR', 'Select Editor');
define('_MI_ABOUT_EDITOR_DESC', 'You can select here your Text Editor');
