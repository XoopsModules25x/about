<?php

use XoopsModules\About;

defined('XOOPS_ROOT_PATH') || die('Restricted access');

/**
 * @param       $dir
 * @param  int  $mode
 * @param  bool $recursive
 * @return bool
 */
function aboutmkdirs($dir, $mode = 0777, $recursive = true)
{
    if ('' === $dir || null === $dir) {
        return $dir;
    }
    if ('/' === $dir || is_dir($dir)) {
        return $dir;
    }
    if (aboutmkdirs(dirname($dir), $mode, $recursive)) {
        return mkdir($dir, $mode);
    }

    return $dir;
}
