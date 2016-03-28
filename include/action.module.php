<?php
defined('XOOPS_ROOT_PATH') || exit('XOOPS root path not defined');

/**
 * @param $module
 * @return bool
 */
function xoops_module_install_about(&$module)
{
    $data_file = XOOPS_ROOT_PATH . '/modules/about/sql/mysql.about.sql';
    $GLOBALS['xoopsDB']->queryF('SET NAMES utf8');
    if (!$GLOBALS['xoopsDB']->queryFromFile($data_file)) {
        $module->setErrors('Pre-set data were not installed');

        return true;
    }

    return true;
}

/**
 * @param       $module
 * @param  null $prev_version
 * @return bool
 */
function xoops_module_update_about(&$module, $prev_version = null)
{
    return true;
}
