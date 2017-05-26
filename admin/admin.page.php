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
 * Process and Display the Main Administration page
 *
 * @package    module\about\admin
 * @copyright  The XOOPS Co.Ltd. http://www.xoops.com.cn
 * @copyright  Copyright (c) 2001-2017 {@link http://xoops.org XOOPS Project}
 * @license    GNU GPL 2 or later (http://www.gnu.org/licenses/gpl-2.0.html)
 * @author     Mengjue Shao <magic.shao@gmail.com>
 * @author     Susheng Yang <ezskyyoung@gmail.com>
 * @since      1.0.0
 */

require __DIR__ . '/admin_header.php';
xoops_cp_header();

$adminObject = Xmf\Module\Admin::getInstance();
$adminObject->displayNavigation(basename(__FILE__));

$op      = Xmf\Request::getCmd('op', null);
$op      = (null !== $op) ? $op : (isset($_REQUEST['id']) ? 'edit' : 'list');
$page_id = Xmf\Request::getInt('id', null);

$page_handler = xoops_getModuleHandler('page', 'about');

switch ($op) {
    default:
    case 'list':
        // Page order
        if (isset($_POST['page_order'])) {
            $page_order = Xmf\Request::getArray('page_order', array(), 'POST'); //$_POST['page_order'];
            foreach ($page_order as $page_id => $order) {
                $page_obj = $page_handler->get($page_id);
                if ($page_order[$page_id] != $page_obj->getVar('page_order')) {
                    $page_obj->setVar('page_order', $page_order[$page_id]);
                    $page_handler->insert($page_obj);
                }
                unset($page_obj);
            }
        }
        // Set index
        if (isset($_POST['page_index'])) {
            $page_index = Xmf\Request::getInt('page_index', AboutConstants::NOT_INDEX, 'POST');
            $page_obj = $page_handler->get($page_index);
            if ($page_index != $page_obj->getVar('page_index')) {
                $page_obj = $page_handler->get($page_index);
                if (!$page_obj->getVar('page_title')) {
                    $abtHelper->redirect('admin/admin.page.php', AboutConstants::REDIRECT_DELAY_MEDIUM, _AM_ABOUT_PAGE_ORDER_ERROR);
                }
                $page_handler->updateAll('page_index', AboutConstants::NOT_INDEX, null);
                unset($criteria);
                $page_obj->setVar('page_index', AboutConstants::DEFAULT_INDEX);
                $page_handler->insert($page_obj);
            }
            unset($page_obj);
        }
        $fields = array(
            'page_id',
            'page_pid',
            'page_menu_title',
            'page_author',
            'page_pushtime',
            'page_blank',
            'page_menu_status',
            'page_type',
            'page_status',
            'page_order',
            'page_index',
            'page_tpl'
        );

        $criteria = new CriteriaCompo();
        $criteria->setSort('page_order');
        $criteria->order = 'ASC';
        $pages           = $page_handler->getTrees(0, '--', $fields);
        $member_handler  = xoops_getHandler('member');

        foreach ($pages as $k => $v) {
            $pages[$k]['page_menu_title'] = $v['prefix'] . $v['page_menu_title'];
            $pages[$k]['page_pushtime']   = formatTimestamp($v['page_pushtime'], _DATESTRING);
            $thisuser                     = $member_handler->getUser($v['page_author']);
            $pages[$k]['page_author']     = $thisuser->getVar('uname');
            unset($thisuser);
        }

        $xoopsTpl->assign('pages', $pages);
        $xoopsTpl->display('db:about_admin_page.tpl');
        break;

    case 'new':
        $GLOBALS['xoTheme']->addStylesheet("modules/{$moduleDirName}/assets/css/admin_style.css");
        $page_obj = $page_handler->create();
        $form     = include $abtHelper->path("include/form.page.php");
        $form->display();
        break;

    case 'edit':
        $GLOBALS['xoTheme']->addStylesheet("modules/{$moduleDirName}/assets/css/admin_style.css");
        $page_obj = $page_handler->get($page_id);
        $form     = include $abtHelper->path("include/form.page.php");
        $form->display();
        break;

    case 'save':
        if (!$GLOBALS['xoopsSecurity']->check()) {
            $abtHelper->redirect('admin/admin.page.php', AboutConstants::REDIRECT_DELAY_MEDIUM, implode(',', $GLOBALS['xoopsSecurity']->getErrors()));
        }
        $page_obj = $page_handler->get($page_id); // will get page_obj if $page_id is valid, create one if not

        // Assign value to elements of objects
        foreach (array_keys($page_obj->vars) as $key) {
            if (isset($_POST[$key]) && $_POST[$key] != $page_obj->getVar($key)) {
                $page_obj->setVar($key, $_POST[$key]);
            }
        }
        // Assign menu title
        if (empty($_POST['page_menu_title'])) {
            $page_obj->setVar('page_menu_title', Xmf\Request::getString('page_title', ''));
        }
        // Set index
        if (!$page_handler->getCount()) {
            $page_obj->setVar('page_index', AboutConstants::DEFAULT_INDEX);
        }

        // Set submitter
        global $xoopsUser;
        $page_obj->setVar('page_author', $xoopsUser->getVar('uid'));
        $page_obj->setVar('page_pushtime', time());

        /* removed - this is now done during module install/update
        include_once $abtHelper->path("include/functions.php");
        if (Aboutmkdirs(XOOPS_UPLOAD_PATH . "/{$moduleDirName}")) {
            $upload_path = XOOPS_UPLOAD_PATH . "/{$moduleDirName}";
        }
        */

        // Upload image
        if (!empty($_FILES['userfile']['name'])) {
            include_once XOOPS_ROOT_PATH . '/class/uploader.php';
            $allowed_mimetypes = array('image/gif', 'image/jpeg', 'image/jpg', 'image/png', 'image/x-png');
            $maxfilesize       = 500000;
            $maxfilewidth      = 1200;
            $maxfileheight     = 1200;
            $uploader          = new XoopsMediaUploader($upload_path, $allowed_mimetypes, $maxfilesize, $maxfilewidth, $maxfileheight);
            if ($uploader->fetchMedia($_POST['xoops_upload_file'][0])) {
                $uploader->setPrefix('attch_');
                if (!$uploader->upload()) {
                    $error_upload = $uploader->getErrors();
                } elseif (file_exists($uploader->getSavedDestination())) {
                    if ($page_obj->getVar('page_image')) {
                        @unlink($upload_path . '/' . $page_obj->getVar('page_image'));
                    }
                    $page_obj->setVar('page_image', $uploader->getSavedFileName());
                }
            }
        }

        // Delete image
        if (isset($_POST['delete_image']) && empty($_FILES['userfile']['name'])) {
            @unlink($upload_path . '/' . $page_obj->getVar('page_image'));
            $page_obj->setVar('page_image', '');
        }

        // Insert object
        if ($page_handler->insert($page_obj)) {
            $abtHelper->redirect('admin/admin.page.php', AboutConstants::REDIRECT_DELAY_MEDIUM, sprintf(_AM_ABOUT_SAVEDSUCCESS, _AM_ABOUT_PAGE_INSERT));
        }

        echo $page_obj->getHtmlErrors();
        $format = 'p';
        $form   = include $abtHelper->path("include/form.page.php");
        $form->display();
        break;

    case 'delete':
        $page_obj = $page_handler->get($page_id);
        $image    = XOOPS_UPLOAD_PATH . "/{$moduleDirName}/" . $page_obj->getVar('page_image');
        if (isset($_REQUEST['ok']) && AboutConstants::CONFIRM_OK == $_REQUEST['ok']) {
            if ($page_handler->delete($page_obj)) {
                if (file_exists($image)) {
                    @unlink($image);
                }
                $abtHelper->redirect('admin/admin.page.php', AboutConstants::REDIRECT_DELAY_MEDIUM, _AM_ABOUT_DELETESUCCESS);
            } else {
                echo $page_obj->getHtmlErrors();
            }
        } else {
            xoops_confirm(array('ok' => AboutConstants::CONFIRM_OK, 'id' => $page_obj->getVar('page_id'), 'op' => 'delete'), $_SERVER['REQUEST_URI'], sprintf(_AM_ABOUT_RUSUREDEL, $page_obj->getVar('page_menu_title')));
        }
        break;
}
include __DIR__ . "/admin_footer.php";
