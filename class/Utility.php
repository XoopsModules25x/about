<?php

namespace XoopsModules\About;

/*
 About Utility Class Definition

 You may not change or alter any portion of this comment or credits of
 supporting developers from this source code or any supporting source code
 which is considered copyrighted (c) material of the original comment or credit
 authors.

 This program is distributed in the hope that it will be useful, but
 WITHOUT ANY WARRANTY; without even the implied warranty of
 MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.
 */

/**
 * Module:  About
 *
 * @package      ::    \module\About\class
 * @license      http://www.fsf.org/copyleft/gpl.html GNU public license
 * @copyright    https://xoops.org 2001-2017 &copy; XOOPS Project
 * @author       ZySpec <zyspec@yahoo.com>
 * @author       Mamba <mambax7@gmail.com>
 * @since        ::      File available since version 1.54
 */

use XoopsModules\About;
use XoopsModules\About\Common;
use XoopsModules\About\Constants;

/**
 * Class Utility
 */
class Utility extends Common\SysUtility
{
    //--------------- Custom module methods -----------------------------

    /**
     * @param       $dir
     * @param int   $mode
     * @param bool  $recursive
     * @return bool
     */
    public static function aboutmkdirs($dir, $mode = 0777, $recursive = true)
    {
        if ('' === $dir || null === $dir) {
            return $dir;
        }
        if ('/' === $dir || \is_dir($dir)) {
            return $dir;
        }
        if (static::aboutmkdirs(\dirname($dir), $mode, $recursive)) {
            return \mkdir($dir, $mode);
        }

        return $dir;
    }
}
