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
 */

defined('XOOPS_ROOT_PATH') || exit('Restricted access');

$adminmenu = array(array('title' => _MI_ABOUT_HOME,
                          'link' => "admin/index.php",
                          'icon' => \Xmf\Module\Admin::menuIconPath('home.png', '32')
                      ),
                   array('title' => _MI_ABOUT_PAGE,
                          'link' => "admin/admin.page.php",
                         'icon'  => \Xmf\Module\Admin::menuIconPath('manage.png', '32')
                   ),
                   array('title' => _MI_ABOUT_ABOUT,
                          'link' => "admin/about.php",
                          'icon' => \Xmf\Module\Admin::menuIconPath('about.png', '32')
                   ),
);
