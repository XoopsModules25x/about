<?php
defined('XOOPS_ROOT_PATH') || exit('Restricted access');

/**
 *
 * Prepares system prior to attempting to install module
 *
 * @param XoopsModule $module
 *
 * @return bool true if ready to install, false if not
 */
function xoops_module_pre_install_about(XoopsModule $module)
{
    $utilsClass = ucfirst($module->dirname()) . "Utilities";
    if (!class_exists($utilsClass)) {
        xoops_load('utilities', $module->dirname());
    }

    $xoopsSuccess = $utilsClass::checkXoopsVer($module);
    $phpSuccess   = $utilsClass::checkPHPVer($module);
    return $xoopsSuccess && $phpSuccess;
}

/**
 * @param  XoopsObject $module
 * @return bool
 */
function xoops_module_install_about(XoopsModule $module)
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
    $oldFiles = array(XOOPS_ROOT_PATH . "/modules/" . $module->dirname() . "/include/xoopsformloader.php",
                      XOOPS_ROOT_PATH . "/modules/" . $module->dirname() . "/include/blockform.php"
    );
    foreach($oldFiles as $file) {
        if (is_file($file)) {
            $delOk = unlink($file);
            if (false === $delOk) {
                $module->setErrors(sprintf(_AM_ABOUT_ERROR_BAD_REMOVE, $file));
            } else {
                $module->setErrors(sprintf("%s deleted", $file));
            }
            $success = $success && $delOk;
        }
    }
    return $success;
}

/**
 *
 * Prepares system prior to attempting to install module
 *
 * @param XoopsModule $module
 *
 * @return bool true if ready to install, false if not
 */
function xoops_module_pre_update_about(XoopsModule $module)
{
    $utilsClass = ucfirst($module->dirname()) . "Utilities";
    if (!class_exists($utilsClass)) {
        xoops_load('utilities', $module->dirname());
    }

    $xoopsSuccess = $utilsClass::checkXoopsVer($module);
    $phpSuccess   = $utilsClass::checkPHPVer($module);
    return $xoopsSuccess && $phpSuccess;
}


/**
 * @param  XoopsModule $module
 * @param  null        $prev_version
 * @return bool
 */
function xoops_module_update_about(XoopsModule $module, $prev_version = null)
{
    $success = true;
    // Delete files from previous version (if they exist)
    $oldFiles = array(XOOPS_ROOT_PATH . "/modules/" . $module->dirname() . "/include/xoopsformloader.php",
                      XOOPS_ROOT_PATH . "/modules/" . $module->dirname() . "/include/blockform.php"
    );
    foreach($oldFiles as $file) {
        if (is_file($file)) {
            if (false === ($delOk = unlink($file))) {
                $module->setErrors(sprintf(_AM_ABOUT_ERROR_BAD_REMOVE, $file));
            }
            $success = $success && $delOk;
        }
    }

    // Delete files from previous version (if they exist)
    // this is only executed if this version copied over old version without running module update
    $oldFiles = array(XOOPS_PATH . "/modules/" . $module->dirname() . "/include/xoopsformloader.php",
        XOOPS_PATH . "/modules/" . $module->dirname() . "/include/blockform.php"
    );
    foreach($oldFiles as $file) {
        if (is_file($file)) {
            if (false === ($delOk = unlink($file))) {
                $module->setErrors(sprintf(_AM_ABOUT_ERROR_BAD_REMOVE, $file));
            }
            $success = $success && $delOk;
        }
    }
    return $success;
}

/**
 *
 * Function to complete upon module uninstall
 *
 * @param XoopsModule $module
 *
 * @return bool true if successfully executed uninstall of module, false if not
 */
function xoops_module_uninstall_about(XoopsModule $module)
{
    $moduleDirName = $module->dirname();
    $aboutHelper = \Xmf\Module\Helper::getHelper($moduleDirName);
    $utilsClass = ucfirst($moduleDirName) . 'Utilities';
    if (!class_exists($utilsClass)) {
        xoops_load('utilities', $moduleDirName);
    }

    $success = true;
    $aboutHelper->loadLanguage('admin');

    //------------------------------------------------------------------
    // Remove module uploads folder (and all subfolders) if they exist
    //------------------------------------------------------------------

    $old_directories = array(XOOPS_UPLOAD_PATH . "/{$moduleDirName}");
    foreach ($old_directories as $old_dir) {
        $dirInfo = new SplFileInfo($old_dir);
        if ($dirInfo->isDir()) {
            // The directory exists so delete it
            if (false === $utilsClass::rrmdir($old_dir)) {
                $module->setErrors(sprintf(_AM_ABOUT_ERROR_BAD_DEL_PATH, $old_dir));
                $success = false;
            }
        }
        unset($dirInfo);
    }
    return $success;
}
