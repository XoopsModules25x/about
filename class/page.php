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
 * @version        $Id: page.php 1 2010-2-9 ezsky$
 */

defined('XOOPS_ROOT_PATH') || exit('XOOPS root path not defined');

/**
 * Class AboutPage
 */
class AboutPage extends XoopsObject
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

/**
 * Class AboutPageHandler
 */
class AboutPageHandler extends XoopsPersistableObjectHandler
{
    /**
     * AboutPageHandler constructor.
     * @param null|object|XoopsDatabase $db
     */
    public function __construct(XoopsDatabase $db)
    {
        parent::__construct($db, 'about_page', 'AboutPage', 'page_id', 'page_title');
    }

    /**
     * @param  int    $pid
     * @param  string $prefix
     * @param  array  $tags
     * @return array
     */
    public function &getTrees($pid = 0, $prefix = '--', $tags = array())
    {
        $pid = (int)$pid;
        if (!is_array($tags) || count($tags) == 0) {
            $tags = array('page_id', 'page_pid', 'page_title', 'page_title', 'page_menu_title', 'page_status', 'page_order');
        }
        $criteria = new CriteriaCompo();
        $criteria->setSort('page_order');
        $criteria->setOrder('ASC');
        $page_tree =& $this->getAll($criteria, $tags);
        require_once __DIR__ . '/tree.php';
        $tree       = new aboutTree($page_tree);
        $page_array =& $tree->makeTree($prefix, $pid, $tags);

        return $page_array;
    }

    /**
     * @param  array $pages
     * @param  int   $key
     * @param  int   $level
     * @return array|bool
     */
    public function &MenuTree($pages = array(), $key = 0, $level = 1)
    {
        if (!is_array($pages) || 0 === count($pages)) {
            return false;
        }
        $menu = array();

        foreach ($pages as $k => $v) {
            if ($v['page_pid'] == $key) {
                $menu[$k]          = $v;
                $menu[$k]['level'] = $level;
                $child             =& $this->MenuTree($pages, $k, $level + 1);
                if (!empty($child)) {
                    $menu[$k]['child'] = $child;
                }
            }
        }

        return $menu;
    }

    /**
     * @param  array $pages
     * @param  int   $key
     * @return array|bool
     */
    public function getBread($pages = array(), $key = 0)
    {
        if (!is_array($pages) || 0 === count($pages)) {
            return false;
        }
        $bread = array();

        if (isset($pages[$key])) {
            $current = $pages[$key];
            $bread   = array($current['page_id'] => $current['page_menu_title']);
            if ($current['page_pid'] > 0) {
                $p_brend = $this->getBread($pages, $current['page_pid']);
                if (!empty($p_brend)) {
                    foreach ($p_brend as $k => $v) {
                        $bread[$k] = $v;
                    }
                }
            }
        }

        return $bread;
    }

    /*
    function insert()
    {
    }

    function delete()
    {
    }

    function getAll()
    {
    }
    */
}
