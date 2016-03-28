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
 * @version        $Id: index.php 1 2010-2-9 ezsky$
 */

include_once __DIR__ . '/header.php';
include_once __DIR__ . '/include/functions.render.php';

$page_id      = isset($_REQUEST['page_id']) ? $_REQUEST['page_id'] : '';
$page_handler = xoops_getModuleHandler('page', 'about');

// Menu
$menu_criteria = new CriteriaCompo();
$menu_criteria->add(new Criteria('page_status', 1), 'AND');
$menu_criteria->add(new Criteria('page_menu_status', 1), 'AND');
$menu_criteria->setSort('page_order');
$menu_criteria->setOrder('ASC');
$fields = array(
    'page_id',
    'page_pid',
    'page_menu_title',
    'page_blank',
    'page_menu_status',
    'page_status',
    'page_text');
$menu   = $page_handler->getAll($menu_criteria, $fields, false);
foreach ($menu as $k => $v) {
    $menu[$k]['page_text'] = trim($v['page_text']) === 'http://' ? true : false;
}
$page_menu = $page_handler->MenuTree($menu);

// Display
$display = $xoopsModuleConfig['display'];
if ($display == 1 || !empty($page_id)) {

    // Fun menu display
    $criteria = new CriteriaCompo();
    if (!empty($page_id)) {
        $criteria->add(new Criteria('page_id', $page_id));
    } else {
        $criteria->add(new Criteria('page_index', 1));
    }
    $criteria->add(new Criteria('page_status', 1));

    $criteria->setSort('page_order');
    $criteria->setOrder('ASC');
    $page = current($page_handler->getObjects($criteria, null, false, false));

    $xoopsOption['xoops_pagetitle'] = $page['page_title'] . ' - ' . $xoopsModule->getVar('name');
    $xoopsOption['template_main']   = about_getTemplate('page', $page['page_tpl']);
    include XOOPS_ROOT_PATH . '/header.php';

    if (!empty($page)) {
        $myts              = MyTextSanitizer::getInstance();
        $page['page_text'] = $myts->undoHtmlSpecialChars($page['page_text']);
        if ($page['page_type'] == 2) {
            header('location: ' . $page['page_text']);
        }
        $xoTheme->addMeta('meta', 'description', $page['page_menu_title']);
        $xoopsTpl->assign('pagemenu', $page_menu);
        $xoopsTpl->assign('page', $page);
    }
} else {

    // Fun list display
    $xoopsOption['xoops_pagetitle'] = $xoopsModule->getVar('name');
    $xoopsOption['template_main']   = 'about_list.tpl';
    include XOOPS_ROOT_PATH . '/header.php';

    $criteria = new CriteriaCompo();
    $criteria->add(new Criteria('page_status', 1));
    $criteria->setSort('page_order');
    $criteria->setOrder('ASC');
    $list = $page_handler->getAll($criteria, null, false);

    $myts = MyTextSanitizer::getInstance();
    foreach ($list as $k => $v) {
        $text                      = strip_tags($myts->undoHtmlSpecialChars($v['page_text']));
        $list[$k]['page_text']     = xoops_substr($text, '', $xoopsModuleConfig['str_ereg']);
        $list[$k]['page_pushtime'] = formatTimestamp($v['page_pushtime'], 'Y-m-d');
    }
    $xoopsTpl->assign('list', $list);
}

// get bread
$beand = array_reverse($page_handler->getBread($menu, $page_id), true);
if (!empty($beand)) {
    foreach ($beand as $k => $v) {
        if ($k != $page_id) {
            $xoBreadcrumbs[] = array('title' => $v, 'link' => XOOPS_URL . '/modules/about/index.php?page_id=' . $k);
        } else {
            $xoBreadcrumbs[] = array('title' => $v);
        }
        $tree_open[$k] = $k;
    }
    $xoopsTpl->assign('tree_open', $tree_open);
}
$xoopsTpl->assign('page_id', $page_id);

include_once __DIR__ . '/footer.php';
