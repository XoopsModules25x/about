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
 * @since          1.0.0
 * @author         Mengjue Shao <magic.shao@gmail.com>
 * @author         Susheng Yang <ezskyyoung@gmail.com>
 * @version        $Id: admin.page.php 1 2010-2-9 ezsky$
 */

include __DIR__ . '/admin_header.php';

xoops_cp_header();
//loadModuleAdminMenu(1);
$myModuleAdmin = new ModuleAdmin();
echo $myModuleAdmin->addNavigation(basename(__FILE__));

$op      = isset($_REQUEST['op']) ? $_REQUEST['op'] : (isset($_REQUEST['id']) ? 'edit' : 'list');
$page_id = isset($_REQUEST['id']) ? $_REQUEST['id'] : '';

$page_handler = xoops_getModuleHandler('page', 'about');

switch ($op) {
    default:
    case 'list':
        //page order
        if (isset($_POST['page_order'])) {
            $page_order = $_POST['page_order'];
            foreach ($page_order as $page_id => $order) {
                $page_obj = $page_handler->get($page_id);
                if ($page_order[$page_id] != $page_obj->getVar('page_order')) {
                    $page_obj->setVar('page_order', $page_order[$page_id]);
                    $page_handler->insert($page_obj);
                }
                unset($page_obj);
            }
        }
        //set index
        if (isset($_POST['page_index'])) {
            $page_obj = $page_handler->get((int)$_POST['page_index']);
            if ((int)$_POST['page_index'] != $page_obj->getVar('page_index')) {
                $page_obj = $page_handler->get($_POST['page_index']);
                if (!$page_obj->getVar('page_title')) {
                    redirect_header('admin.page.php', 3, _AM_ABOUT_PAGE_ORDER_ERROR);
                }
                $page_handler->updateAll('page_index', 0, null);
                unset($criteria);
                $page_obj->setVar('page_index', 1);
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
            'page_tpl');

        $criteria = new CriteriaCompo();
        $criteria->setSort('page_order');
        $criteria->setOrder('ASC');
        $pages          = $page_handler->getTrees(0, '--', $fields);
        $member_handler = xoops_getHandler('member');

        foreach ($pages as $k => $v) {
            $pages[$k]['page_menu_title'] = $v['prefix'] . $v['page_menu_title'];
            $pages[$k]['page_pushtime']   = formatTimestamp($v['page_pushtime'], 'Y-m-d h:i:s');
            $thisuser                     = $member_handler->getUser($v['page_author']);
            $pages[$k]['page_author']     = $thisuser->getVar('uname');
            unset($thisuser);
        }

        $xoopsTpl->assign('pages', $pages);
        $xoopsTpl->display('db:about_admin_page.tpl');
        break;

    case 'new':
        $page_obj = $page_handler->create();
        $form     = include dirname(__DIR__) . '/include/form.page.php';
        $form->display();
        break;

    case 'edit':
        $page_obj = $page_handler->get($page_id);
        $form     = include dirname(__DIR__) . '/include/form.page.php';
        $form->display();
        break;

    case 'save':
        if (!$GLOBALS['xoopsSecurity']->check()) {
            redirect_header('admin.page.php', 3, implode(',', $GLOBALS['xoopsSecurity']->getErrors()));
        }
        if (isset($page_id)) {
            $page_obj = $page_handler->get($page_id);
        } else {
            $page_obj = $page_handler->create();
        }
        //assign value to elements of objects
        foreach (array_keys($page_obj->vars) as $key) {
            if (isset($_POST[$key]) && $_POST[$key] != $page_obj->getVar($key)) {
                $page_obj->setVar($key, $_POST[$key]);
            }
        }
        //assign menu title
        if (empty($_POST['page_menu_title'])) {
            $page_obj->setVar('page_menu_title', $_POST['page_title']);
        }
        //set index
        if (!$page_handler->getCount()) {
            $page_obj->setVar('page_index', 1);
        }

        //set submiter
        global $xoopsUser, $xoopsModule;
        $page_obj->setVar('page_author', $xoopsUser->getVar('uid'));
        $page_obj->setVar('page_pushtime', time());

        include_once dirname(__DIR__) . '/include/functions.php';
        if (Aboutmkdirs(XOOPS_UPLOAD_PATH . '/' . $xoopsModule->dirname())) {
            $upload_path = XOOPS_UPLOAD_PATH . '/' . $xoopsModule->dirname();
        }

        // upload image
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

        // delete iamge
        if (isset($_POST['delete_image']) && empty($_FILES['userfile']['name'])) {
            @unlink($upload_path . '/' . $page_obj->getVar('page_image'));
            $page_obj->setVar('page_image', '');
        }

        // insert object
        if ($page_handler->insert($page_obj)) {
            redirect_header('admin.page.php', 3, sprintf(_AM_ABOUT_SAVEDSUCCESS, _AM_ABOUT_PAGE_INSERT));
        }

        echo $page_obj->getHtmlErrors();
        $format = 'p';
        $form   = include dirname(__DIR__) . '/include/form.page.php';
        $form->display();

        break;

    case 'delete':
        $page_obj = $page_handler->get($page_id);
        $image    = XOOPS_UPLOAD_PATH . '/' . $xoopsModule->dirname() . '/' . $page_obj->getVar('page_image');
        if (isset($_REQUEST['ok']) && $_REQUEST['ok'] == 1) {
            if ($page_handler->delete($page_obj)) {
                if (file_exists($image)) {
                    @unlink($image);
                }
                redirect_header('admin.page.php', 3, '保存成功');
            } else {
                echo $page_obj->getHtmlErrors();
            }
        } else {
            xoops_confirm(array('ok' => 1, 'id' => $page_obj->getVar('page_id'), 'op' => 'delete'), $_SERVER['REQUEST_URI'], sprintf(_AM_ABOUT_RUSUREDEL, $page_obj->getVar('page_menu_title')));
        }
        break;
}

xoops_cp_footer();
