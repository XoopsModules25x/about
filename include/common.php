<?php
/*
 * You may not change or alter any portion of this comment or credits
 * of supporting developers from this source code or any supporting source code
 * which is considered copyrighted (c) material of the original comment or credit authors.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.
 */

/**
 * @copyright    XOOPS Project https://xoops.org/
 * @license      GNU GPL 2 or later (http://www.gnu.org/licenses/gpl-2.0.html)
 * @package
 * @since
 * @author     XOOPS Development Team
 */

use Xoopsmodules\about;

defined('XOOPS_ROOT_PATH') || die('XOOPS root path not defined');

include __DIR__ . '/../preloads/autoloader.php';

$moduleDirName = basename(dirname(__DIR__));

require_once __DIR__ . '/../class/Helper.php';
require_once __DIR__ . '/../class/Utility.php';


if (!defined('ABOUT_MODULE_PATH')) {
    define('ABOUT_DIRNAME', basename(dirname(__DIR__)));
    define('ABOUT_URL', XOOPS_URL . '/modules/' . ABOUT_DIRNAME);
    define('ABOUT_IMAGE_URL', ABOUT_URL . '/assets/images/');
    define('ABOUT_ROOT_PATH', XOOPS_ROOT_PATH . '/modules/' . ABOUT_DIRNAME);
    define('ABOUT_IMAGE_PATH', ABOUT_ROOT_PATH . '/assets/images');
    define('ABOUT_ADMIN_URL', ABOUT_URL . '/admin/');
    define('ABOUT_UPLOAD_URL', XOOPS_UPLOAD_URL . '/' . ABOUT_DIRNAME);
    define('ABOUT_UPLOAD_PATH', XOOPS_UPLOAD_PATH . '/' . ABOUT_DIRNAME);
}
xoops_loadLanguage('common', ABOUT_DIRNAME);

require_once ABOUT_ROOT_PATH . '/include/functions.php';
//require_once ABOUT_ROOT_PATH . '/include/constants.php';
//require_once ABOUT_ROOT_PATH . '/include/seo_functions.php';
//require_once ABOUT_ROOT_PATH . '/class/metagen.php';
//require_once ABOUT_ROOT_PATH . '/class/session.php';
//require_once ABOUT_ROOT_PATH . '/class/xoalbum.php';
//require_once ABOUT_ROOT_PATH . '/class/request.php';


/** @var \XoopsDatabase $db */
/** @var wfdownloads\Helper $helper */
/** @var wfdownloads\Utility $utility */
$db           = \XoopsDatabaseFactory::getDatabase();
$helper       = about\Helper::getInstance();
$utility      = new about\Utility();
$configurator = new about\Configurator();

$pageHandler     = new about\AboutPageHandler($db);

$pathIcon16    = Xmf\Module\Admin::iconUrl('', 16);
$pathIcon32    = Xmf\Module\Admin::iconUrl('', 32);
$pathModIcon16 = $helper->getModule()->getInfo('modicons16');
$pathModIcon32 = $helper->getModule()->getInfo('modicons32');

$icons = [
    'edit'    => "<img src='" . $pathIcon16 . "/edit.png'  alt=" . _EDIT . "' align='middle'>",
    'delete'  => "<img src='" . $pathIcon16 . "/delete.png' alt='" . _DELETE . "' align='middle'>",
    'clone'   => "<img src='" . $pathIcon16 . "/editcopy.png' alt='" . _CLONE . "' align='middle'>",
    'preview' => "<img src='" . $pathIcon16 . "/view.png' alt='" . _PREVIEW . "' align='middle'>",
    'print'   => "<img src='" . $pathIcon16 . "/printer.png' alt='" . _CLONE . "' align='middle'>",
    'pdf'     => "<img src='" . $pathIcon16 . "/pdf.png' alt='" . _CLONE . "' align='middle'>",
    'add'     => "<img src='" . $pathIcon16 . "/add.png' alt='" . _ADD . "' align='middle'>",
    '0'       => "<img src='" . $pathIcon16 . "/0.png' alt='" . _ADD . "' align='middle'>",
    '1'       => "<img src='" . $pathIcon16 . "/1.png' alt='" . _ADD . "' align='middle'>",
];

// MyTextSanitizer object
$myts = \MyTextSanitizer::getInstance();

$debug = false;

$debug = false;

