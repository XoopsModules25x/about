<?php

if (!defined("XOOPS_ROOT_PATH")) {
    exit();
}

/**
 * @param      $dir
 * @param int  $mode
 * @param bool $recursive
 * @return bool
 */
function Aboutmkdirs($dir, $mode = 0777, $recursive = true)
{
    if (is_null($dir) || $dir === "") {
        return $dir;
    }
    if (is_dir($dir) || $dir === "/") {
        return $dir;
    }
    if (Aboutmkdirs(dirname($dir), $mode, $recursive)) {
        return mkdir($dir, $mode);
    }

    return $dir;
}
