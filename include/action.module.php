<?php

use XoopsModules\About;

defined('XOOPS_ROOT_PATH') || die('Restricted access');

/**
 *
 * Prepares system prior to attempting to install module
 *
 * @param XoopsModule $module
 *
 * @return bool       true if ready to install, false if not
 */
function xoops_module_pre_install_about(\XoopsModule $module)
{
    include __DIR__ . '/../preloads/autoloader.php';
    /** @var About\Utility $utility */
    $utility = new About\Utility();
    $xoopsSuccess = $utility::checkVerXoops($module);
    $phpSuccess   = $utility::checkVerPhp($module);

    if (false !== $xoopsSuccess && false !==  $phpSuccess) {
        $moduleTables =& $module->getInfo('tables');
        foreach ($moduleTables as $table) {
            $GLOBALS['xoopsDB']->queryF('DROP TABLE IF EXISTS ' . $GLOBALS['xoopsDB']->prefix($table) . ';');
        }
    }

    return $xoopsSuccess && $phpSuccess;
}

/**
 * @param  XoopsModule $module
 * @return bool        true if install successful, false if not
 */
function xoops_module_install_about(\XoopsModule $module)
{
    $success = true;
    $data_file = XOOPS_ROOT_PATH . '/modules/about/sql/mysql.about.sql';
    $GLOBALS['xoopsDB']->queryF('SET NAMES utf8');
    if (!$GLOBALS['xoopsDB']->queryFromFile($data_file)) {
        $module->setErrors('Pre-set data was not installed');
        // preset info not set, but don't 'fail' install because of this
        //$success = false;
    }

    // Delete files from previous version (if they exist)
    // this is only executed if this version copied over old version without running module update
    $oldFiles = [
        XOOPS_ROOT_PATH . '/modules/' . $module->dirname() . '/include/xoopsformloader.php',
                      XOOPS_ROOT_PATH . '/modules/' . $module->dirname() . '/include/blockform.php',
                      XOOPS_ROOT_PATH . '/modules/' . $module->dirname() . '/class/utilities.php',
    ];
    foreach ($oldFiles as $file) {
        if (is_file($file)) {
            $delOk = unlink($file);
            if (false === $delOk) {
                $module->setErrors(sprintf(_AM_ABOUT_ERROR_BAD_REMOVE, $file));
            } else {
                $module->setErrors(sprintf(_AM_ABOUT_DELETED, $file));
            }
            $success = $success && $delOk;
        }
    }
    // Create uploads folder
    $dirOk = mkdir(XOOPS_UPLOAD_PATH . '/' . $module->dirname());
    if (false === $dirOk) {
        $module->setErrors(_AM_ABOUT_ERROR_BAD_UPLOAD_DIR);
    }

    return $dirOk && $success;
}

/**
 *
 * Prepares system prior to attempting to install module
 *
 * @param XoopsModule $module
 *
 * @return bool       true if ready to install, false if not
 */
function xoops_module_pre_update_about(\XoopsModule $module)
{
    /** @var About\Helper $helper */
    /** @var About\Utility $utility */
    $moduleDirName = basename(dirname(__DIR__));
    $helper       = About\Helper::getInstance();
    $utility      = new About\Utility();

    $xoopsSuccess = $utility::checkVerXoops($module);
    $phpSuccess   = $utility::checkVerPhp($module);
    return $xoopsSuccess && $phpSuccess;
}


/**
 * @param  XoopsModule $module
 * @param  null        $prev_version
 * @return bool        true if update successful, false if not
 */
function xoops_module_update_about(\XoopsModule $module, $prev_version = null)
{
    $success = true;
    // Delete files from previous version (if they exist)
    $oldFiles = [
        XOOPS_ROOT_PATH . '/modules/' . $module->dirname() . '/include/xoopsformloader.php',
                      XOOPS_ROOT_PATH . '/modules/' . $module->dirname() . '/include/blockform.php',
                      XOOPS_ROOT_PATH . '/modules/' . $module->dirname() . '/class/utilities.php'
    ];
    foreach ($oldFiles as $file) {
        if (is_file($file)) {
            if (false === ($delOk = unlink($file))) {
                $module->setErrors(sprintf(_AM_ABOUT_ERROR_BAD_REMOVE, $file));
            }
            $success = $success && $delOk;
        }
    }

    // Delete files from previous version (if they exist)
    // this is only executed if this version copied over old version without running module update
    $oldFiles = [
        XOOPS_PATH . '/modules/' . $module->dirname() . '/include/xoopsformloader.php',
                      XOOPS_PATH . '/modules/' . $module->dirname() . '/include/blockform.php'
    ];
    foreach ($oldFiles as $file) {
        if (is_file($file)) {
            if (false === ($delOk = unlink($file))) {
                $module->setErrors(sprintf(_AM_ABOUT_ERROR_BAD_REMOVE, $file));
            }
            $success = $success && $delOk;
        }
    }

    // Create uploads folder if it doesn't exist
    $dirOk = true;
    if (false === file_exists(XOOPS_UPLOAD_PATH . '/' . $module->dirname())) {
        // File doesn't exist so try and create it
        $dirOk = mkdir(XOOPS_UPLOAD_PATH . '/' . $module->dirname());
        if (false === $dirOk) {
            $module->setErrors(_AM_ABOUT_ERROR_BAD_UPLOAD_DIR);
        }
    }

    return $dirOk && $success;
}

/**
 *
 * Function to complete upon module uninstall
 *
 * @param XoopsModule $module
 *
 * @return bool       true if successfully executed uninstall of module, false if not
 */
function xoops_module_uninstall_about(\XoopsModule $module)
{
    $moduleDirName = $module->dirname();
//    $aboutHelper = Xmf\Module\Helper::getHelper($moduleDirName);
    $utilityClass = ucfirst($moduleDirName) . 'Utility';
    if (!class_exists($utilityClass)) {
        xoops_load('utility', $moduleDirName);
    }

    $success = true;
    $helper->loadLanguage('admin');

    //------------------------------------------------------------------
    // Remove module uploads folder (and all subfolders) if they exist
    //------------------------------------------------------------------

    $old_directories = [XOOPS_UPLOAD_PATH . "/{$moduleDirName}"];
    foreach ($old_directories as $old_dir) {
        $dirInfo = new \SplFileInfo($old_dir);
        if ($dirInfo->isDir()) {
            // The directory exists so delete it
            if (false === $utilityClass::rrmdir($old_dir)) {
                $module->setErrors(sprintf(_AM_ABOUT_ERROR_BAD_DEL_PATH, $old_dir));
                $success = false;
            }
        }
        unset($dirInfo);
    }
    return $success;
}
