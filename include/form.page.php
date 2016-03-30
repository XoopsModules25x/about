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
 * @version        $Id: form.page.php 1 2010-2-9 ezsky$
 */

if (!defined('XOOPS_ROOT_PATH')) {
    exit();
}

include_once __DIR__ . '/functions.render.php';
include_once XOOPS_ROOT_PATH . '/class/xoopsformloader.php';
$page_handler = xoops_getModuleHandler('page', 'about');

$pageType = isset($_REQUEST['type']) ? $_REQUEST['type'] : $page_obj->getVar('page_type');
$format   = empty($format) ? 'e' : $format;

$menu_status = $page_obj->isNew() ? 1 : $page_obj->getVar('page_menu_status');
$list_status = $page_obj->isNew() ? 1 : $page_obj->getVar('page_status');
$page_blank  = $page_obj->isNew() ? 0 : $page_obj->getVar('page_blank');

$title = $page_obj->isNew() ? _AM_ABOUT_PAGE_INSERT : _AM_ABOUT_EDIT;

$form = new XoopsThemeForm($title, 'form', 'admin.page.php', 'post', true);
$form->setExtra("enctype=\"multipart/form-data\"");
if ($pageType == 1) {
    $form->addElement(new XoopsFormText(_AM_ABOUT_PAGE_TITLE, 'page_title', 60, 255, $page_obj->getVar('page_title', $format)), true);
    $menu = new XoopsFormElementTray(_AM_ABOUT_PAGE_MENU_LIST);

    $menu->addElement(new XoopsFormRadioYN('', 'page_menu_status', $menu_status));
    $menu->addElement(new XoopsFormText(_AM_ABOUT_PAGE_MENU_TITLE . ':', 'page_menu_title', 30, 255, $page_obj->getVar('page_menu_title', $format)));
    $menu->addElement(new XoopsFormLabel('', _AM_ABOUT_PAGE_LINK_MENU));
    $form->addElement($menu, true);

    $editorTray = new XoopsFormElementTray(_AM_ABOUT_PAGE_TEXT, '<br />');
    if (class_exists('XoopsFormEditor')) {
        $options['name']   = 'page_text';
        $options['value']  = $page_obj->getVar('page_text');
        $options['rows']   = 25;
        $options['cols']   = '100%';
        $options['width']  = '100%';
        $options['height'] = '400px';
        $pageEditor        = new XoopsFormEditor('', $xoopsModuleConfig['editorAdmin'], $options, $nohtml = false, $onfailure = 'textarea');
        $editorTray->addElement($pageEditor);
    } else {
        $pageEditor = new XoopsFormDhtmlTextArea('', 'page_text', $page_obj->getVar('page_text'), '100%', '100%');
        $editorTray->addElement($pageEditor);
    }
    $form->addElement($editorTray);

    // Template set
    $templates =& about_getTemplateList('page');
    if (count($templates) > 0) {
        $template_select = new XoopsFormSelect(_AM_ABOUT_TEMPLATE_SELECT, 'page_tpl', $page_obj->getVar('page_tpl'));
        $template_select->addOptionArray($templates);
        $form->addElement($template_select);
    }
} else {
    $form->addElement(new XoopsFormText(_AM_ABOUT_PAGE_MENU_TITLE . ':', 'page_menu_title', 60, 255, $page_obj->getVar('page_menu_title', $format)));
    $form->addElement(new XoopsFormHidden('page_menu_status', $menu_status));
    $form->addElement(new XoopsFormText(_AM_ABOUT_PAGE_LINK_TEXT, 'page_text', 60, 255, $page_obj->isNew() ? 'http://' . $page_obj->getVar('page_text', $format) : $page_obj->getVar('page_text', $format)), true);
}

$page_list    = $page_handler->getTrees(0, '--');
$page_options = array();
if ($page_list) {
    foreach ($page_list as $id => $page) {
        $page_options[$id] = $page['prefix'] . $page['page_menu_title'];
    }
}
$page_select = new XoopsFormSelect(_AM_ABOUT_PAGE_HIGHER, 'page_pid', $page_obj->getVar('page_pid'));
$page_select->addOption(0, _NONE);
$page_select->addOptionArray($page_options);
$form->addElement($page_select);

$image_tray     = new XoopsFormElementTray(_AM_ABOUT_PAGE_IMAGE);
$image_uploader = new XoopsFormFile('', 'userfile', 500000);
$image_tray->addElement($image_uploader);
$page_image = $page_obj->getVar('page_image');
if (!empty($page_image) && file_exists(XOOPS_ROOT_PATH . '/uploads/' . $xoopsModule->dirname() . '/' . $page_image)) {
    $image_tray->addElement(new XoopsFormLabel('', "<div style=\"padding: 8px;\"><img src=\"" . XOOPS_URL . '/uploads/' . $xoopsModule->dirname() . '/' . $page_image . "\" /></div>"));
    $delete_check = new XoopsFormCheckBox('', 'delete_image');
    $delete_check->addOption(1, _DELETE);
    $image_tray->addElement($delete_check);
}
$form->addElement($image_tray);
$form->addElement(new XoopsFormRadioYN(_AM_ABOUT_PAGE_LINK_BLANK, 'page_blank', $page_blank));
$form->addElement(new XoopsFormRadioYN(_AM_ABOUT_PAGE_STATUS, 'page_status', $list_status, $yes = _AM_ABOUT_PAGE_SUB, $no = _AM_ABOUT_PAGE_DARFT));

$form->addElement(new XoopsFormHidden('id', $page_obj->getVar('page_id')));
$form->addElement(new XoopsFormHidden('page_type', $pageType));
$form->addElement(new XoopsFormHidden('op', 'save'));
$form->addElement(new XoopsFormButton('', 'submit', _SUBMIT, 'submit'));

return $form;
