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
 * Display the Administration About page
 *
 * @package    module\About\admin
 * @copyright  The XOOPS Co.Ltd. http://www.xoops.com.cn
 * @copyright  https://xoops.org 2001-2017 XOOPS Project
 * @license    GNU GPL 2 or later (http://www.gnu.org/licenses/gpl-2.0.html)
 * @since      1.0.0
 * @author     Mengjue Shao <magic.shao@gmail.com>
 * @author     Susheng Yang <ezskyyoung@gmail.com>
 */

use XoopsModules\About;

require_once __DIR__ . '/../include/common.php';

$helper = About\Helper::getInstance();

$pathIcon32 = \Xmf\Module\Admin::menuIconPath('');
$pathModIcon32 = $helper->getModule()->getInfo('modicons32');

$adminmenu = [
    [
        'title' => _MI_ABOUT_HOME,
        'link'  => 'admin/index.php',
        'icon'  => Xmf\Module\Admin::menuIconPath('home.png')
    ],
    [
        'title' => _MI_ABOUT_PAGE,
        'link'  => 'admin/admin.page.php',
        'icon'  => Xmf\Module\Admin::menuIconPath('manage.png')
    ],
    [
        'title' => _MI_ABOUT_ABOUT,
        'link'  => 'admin/about.php',
        'icon'  => Xmf\Module\Admin::menuIconPath('about.png')
    ],
];
