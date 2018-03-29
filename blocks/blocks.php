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

use XoopsModules\About\Constants;

defined('XOOPS_ROOT_PATH') || die('Restricted access');
/**
 * @return mixed
 */
function about_block_menu_show()
{
    $moduleDirName = basename(dirname(__DIR__));
    xoops_load('constants', $moduleDirName);

    $helper     = Xmf\Module\Helper::getHelper($moduleDirName);
    $pageHandler  = $helper->getHandler('page');
    $menu_criteria = new \CriteriaCompo();
    $menu_criteria->add(new \Criteria('page_status', Constants::PUBLISHED), 'AND');
    $menu_criteria->add(new \Criteria('page_menu_status', Constants::IN_MENU));
    $menu_criteria->setSort('page_order');
    $menu_criteria->order = 'ASC';
    $fields    = [
        'page_id',
        'page_menu_title',
        'page_blank',
        'page_menu_status',
        'page_status'
    ];
    $page_menu = $pageHandler->getAll($menu_criteria, $fields, false);
    foreach ($page_menu as $k => $v) {
        $page_menu[$k]['links'] = $helper->url("index.php?page_id={$v['page_id']}");
    }

    return $page_menu;
}

/**
 * @param $options
 * @return array|bool
 */
function about_block_page_show($options)
{
    if (empty($options[0])) {
        return false;
    }
    $moduleDirName = basename(dirname(__DIR__));
    $helper     = Xmf\Module\Helper::getHelper($moduleDirName);

    $myts        = \MyTextSanitizer::getInstance();
    $block       = [];
    $pageHandler = $helper->getHandler('page');
    $page        = $pageHandler->get($options[0]);
    if (!is_object($page)) {
        return false;
    }
    $page_text = strip_tags($page->getVar('page_text', 'n'));
    if ($options[1] > 0) {
        $url        = $helper->url("index.php?page_id={$options[0]}");
        $trimmarker = <<<EOF
<a href="{$url}" class="more">{$options[2]}</a>
EOF;
        $page_text  = xoops_substr($page_text, 0, $options[1]) . $trimmarker;
    }

    $block['page_text']  = $myts->nl2br($page_text);
    $block['page_image'] = 1 == $options[3] ? $helper->url($page->getVar('page_image', 's')) : '';

    return $block;
}

/**
 * @param $options
 * @return string
 */
function about_block_page_edit($options)
{
    $moduleDirName = basename(dirname(__DIR__));
    $helper     = Xmf\Module\Helper::getHelper($moduleDirName);
    xoops_load('constants', $moduleDirName);

    $helper->loadLanguage('blocks');
    $pageHandler = $helper->getHandler('page');
    $criteria    = new \CriteriaCompo();
    $criteria->add(new \Criteria('page_status', Constants::PUBLISHED), 'AND');
    $criteria->add(new \Criteria('page_type', Constants::PAGE_TYPE_PAGE));
    $criteria->setSort('page_order');
    $criteria->order = 'ASC';
    $fields     = ['page_id', 'page_title', 'page_image'];
    $pages      = $pageHandler->getAll($criteria, $fields, false);
    $page_title = '';
    foreach ($pages as $k => $v) {
        $page_title       = '<a href="' . $helper->url("index.php?page_id={$k}") . '" target="_blank">' . $v['page_title'] . '</a>';
        $options_page[$k] = empty($v['page_image']) ? $page_title : $page_title . '<img src="' . $helper->url('assets/images/picture.png') . '">';
    }
//    require_once dirname(__DIR__) . '/include/xoopsformloader.php';
    xoops_load('blockform', $moduleDirName);
    $form        = new AboutBlockForm();
    $page_select = new \XoopsFormRadio(_MB_ABOUT_BLOCKPAGE, 'options[0]', $options[0], '<br>');
    $page_select->addOptionArray($options_page);
    $form->addElement($page_select);
    $form->addElement(new \XoopsFormText(_MB_ABOUT_TEXT_LENGTH, 'options[1]', 5, 5, $options[1]));
    $form->addElement(new \XoopsFormText(_MB_ABOUT_VIEW_MORELINKTEXT, 'options[2]', 30, 50, $options[2]));
    $form->addElement(new \XoopsFormRadioYN(_MB_ABOUT_DOTITLEIMAGE, 'options[3]', $options[3]));

    return $form->render();
}
