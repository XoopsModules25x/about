<?php

if (!defined('XOOPS_ROOT_PATH')) {
    exit();
}

/**
 * @param       $dir
 * @param  int  $mode
 * @param  bool $recursive
 * @return bool
 */
function Aboutmkdirs($dir, $mode = 0777, $recursive = true)
{
    if ('' === $dir || is_null($dir)) {
        return $dir;
    }
    if ('/' === $dir || is_dir($dir)) {
        return $dir;
    }
    if (Aboutmkdirs(dirname($dir), $mode, $recursive)) {
        return mkdir($dir, $mode);
    }

    return $dir;
}
