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
 * @copyright      XOOPS Project (https://xoops.org)
 * @license        GNU GPL 2 or later (http://www.gnu.org/licenses/gpl-2.0.html)
 * @package        about
 * @since          1.0.0
 * @author         Mengjue Shao <magic.shao@gmail.com>
 * @author         Susheng Yang <ezskyyoung@gmail.com>
 */

use XoopsModules\About;

$moduleDirName = basename(__DIR__);
require_once __DIR__ . '/../../mainfile.php';

require_once __DIR__ . '/include/common.php';

//$helper = Xmf\Module\Helper::getHelper($moduleDirName);

xoops_load('constants', $moduleDirName);
$helper->loadLanguage('modinfo');

$xoBreadcrumbs = [
    ['title' => _YOURHOME, 'link' => XOOPS_URL],
    ['title' => $xoopsModule->getVar('name'), 'link' => XOOPS_URL . "/modules/{$moduleDirName}/"]
];
