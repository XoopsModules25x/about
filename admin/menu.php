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
 * @version        $Id: menu.php 1 2010-2-9 ezsky$
 */

$moduleDirName = basename(dirname(__DIR__));

$moduleHandler = xoops_gethandler('module');
$module         = $moduleHandler->getByDirname($moduleDirName);
$pathIcon32     = '../../' . $module->getInfo('sysicons32');
$pathModIcon32 = './' . $module->getInfo('modicons32');
xoops_loadLanguage('modinfo', $module->dirname());

$xoopsModuleAdminPath = XOOPS_ROOT_PATH . '/' . $module->getInfo('dirmoduleadmin');
if (!file_exists($fileinc = $xoopsModuleAdminPath . '/language/' . $GLOBALS['xoopsConfig']['language'] . '/' . 'main.php')) {
    $fileinc = $xoopsModuleAdminPath . '/language/english/main.php';
}
include_once $fileinc;

$adminmenu[] = array(
    'title' => _AM_MODULEADMIN_HOME,
    'link'  => 'admin/index.php',
    'icon'  => $pathIcon32 . '/home.png');

$adminmenu[] = array(
    'title' => _MI_ABOUT_PAGE,
    'link'  => 'admin/admin.page.php',
    'icon'  => $pathIcon32 . '/manage.png');

$adminmenu[] = array(
    'title' => _AM_MODULEADMIN_ABOUT,
    'link'  => 'admin/about.php',
    'icon'  => $pathIcon32 . '/about.png');
