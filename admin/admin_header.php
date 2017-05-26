<?php
/*
 * You may not change or alter any portion of this comment or credits of
 * supporting developers from this source code or any supporting source code
 * which is considered copyrighted (c) material of the original comment or
 * credit authors.
 *
 * This program is distributed in the hope that it will be useful, but WITHOUT
 * ANY WARRANTY; without even the implied warranty of MERCHANTABILITY or
 * FITNESS FOR A PARTICULAR PURPOSE.
 */
/**
 * Create and display the Administration Header for pages
 *
 * @package    module\about\admin
 * @copyright  http://xoops.org 2001-2017 XOOPS Project
 * @license    GNU GPL 2 or later (http://www.gnu.org/licenses/gpl-2.0.html)
 * @author     XOOPS Module Development Team
 */

$moduleDirName = basename(dirname(__DIR__));
require_once $GLOBALS['xoops']->path('include/cp_header.php');
xoops_load('xoopsformloader');
xoops_load('constants', $moduleDirName);

$abtHelper = Xmf\Module\Helper::getHelper($moduleDirName);
$myts      = MyTextSanitizer::getInstance();

if (!isset($GLOBALS['xoopsTpl']) || !($GLOBALS['xoopsTpl'] instanceof XoopsTpl)) {
    include_once $GLOBALS['xoops']->path('class/template.php');
    $xoopsTpl = new XoopsTpl();
}

// Load language files
$abtHelper->loadLanguage('modinfo');
$abtHelper->loadLanguage('main');
