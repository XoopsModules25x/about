<?php namespace XoopsModules\About;

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

defined('XOOPS_ROOT_PATH') || die('Restricted access');

/**
 * Class AboutPage
 */
class AboutPage extends \XoopsObject
{
    /**
     * AboutPage constructor.
     */
    public function __construct()
    {
        $this->initVar('page_id', XOBJ_DTYPE_INT, null, false);
        $this->initVar('page_pid', XOBJ_DTYPE_INT, 0);
        $this->initVar('page_title', XOBJ_DTYPE_TXTBOX, '');
        $this->initVar('page_menu_title', XOBJ_DTYPE_TXTBOX, '');
        $this->initVar('page_image', XOBJ_DTYPE_TXTBOX, '');
        $this->initVar('page_text', XOBJ_DTYPE_TXTBOX, '');
        $this->initVar('page_author', XOBJ_DTYPE_TXTBOX, '');
        $this->initVar('page_pushtime', XOBJ_DTYPE_INT);
        $this->initVar('page_blank', XOBJ_DTYPE_INT, 0);
        $this->initVar('page_menu_status', XOBJ_DTYPE_INT, 0);
        $this->initVar('page_type', XOBJ_DTYPE_INT, 0);
        $this->initVar('page_status', XOBJ_DTYPE_INT, 0);
        $this->initVar('page_order', XOBJ_DTYPE_INT, 0);
        //$this->initVar('page_url', XOBJ_DTYPE_TXTBOX,"");
        $this->initVar('page_index', XOBJ_DTYPE_INT, 0);
        $this->initVar('page_tpl', XOBJ_DTYPE_TXTBOX, '');
        $this->initVar('dohtml', XOBJ_DTYPE_INT, 1);
        $this->initVar('dosmiley', XOBJ_DTYPE_INT, 0);
        $this->initVar('doxcode', XOBJ_DTYPE_INT, 0);
        $this->initVar('doimage', XOBJ_DTYPE_INT, 0);
        $this->initVar('dobr', XOBJ_DTYPE_INT, 0);
    }
}
