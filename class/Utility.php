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

require_once dirname(__DIR__) . '/include/vars.php';
define($GLOBALS['artdirname'] . '_FUNCTIONS_RENDER_LOADED', true);

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

    /**
     * Function to get template file of a specified style of a specified page
     *
     *
     * @param mixed      $page
     * @param null|mixed $style
     * @return string template file name, using default style if style is invalid
     */
    public static function getTemplate($page = 'index', $style = null)
    {
        global $xoops;

        $template_dir = $xoops->path("modules/{$GLOBALS['artdirname']}/templates/");
        $style        = null === $style ? '' : '_' . $style;
        $file_name    = "{$GLOBALS['artdirname']}_{$page}{$style}.tpl";
        if (file_exists($template_dir . $file_name)) {
            return $file_name;
        }
        // Couldn't find file, try to see if the "default" style for this page exists
        if (!empty($style)) {
            $style     = '';
            $file_name = "{$GLOBALS['artdirname']}_{$page}{$style}.tpl";
            if (file_exists($template_dir . $file_name)) {
                return $file_name;
            }
        }

        // Couldn't find a suitable template for this page
        return null;
    }

    /**
     * Function to get a list of template files of a page, indexed by file name
     *
     *
     * @param mixed     $page
     * @param bool $refresh recreate the data
     * @return array
     */
    public static function getTemplateList($page = 'index', $refresh = false)
    {
        $tplFiles = self::getTplPageList($page, $refresh);
        $template = [];
        if ($tplFiles && is_array($tplFiles)) {
            foreach (array_keys($tplFiles) as $temp) {
                $template[$temp] = $temp;
            }
        }

        return $template;
    }

    /**
     * Function to get CSS file URL of a style
     *
     * The hardcoded path is not desirable for theme switch, however, we have to keabout it before getting a good solution for cache
     *
     *
     * @param mixed $style
     * @return string file URL, false if not found
     */
    public static function getCss($style = 'default')
    {
        global $xoops;

        if (is_readable($xoops->path('modules/' . $GLOBALS['artdirname'] . '/assets/css/style_' . mb_strtolower($style) . '.css'))) {
            return $xoops->path('modules/' . $GLOBALS['artdirname'] . '/assets/css/style_' . mb_strtolower($style) . '.css', true);
        }

        return $xoops->path('modules/' . $GLOBALS['artdirname'] . '/assets/css/style.css', true);
    }

    /**
     * Function to module header for a page with specified style
     *
     *
     * @param mixed $style
     * @return string
     */
    public static function getModuleHeader($style = 'default')
    {
        $xoops_module_header = '<link rel="stylesheet" type="text/css" href="' . self::getCss($style) . '">';

        return $xoops_module_header;
    }

    /**
     * Function to get a list of template files of a page, indexed by style
     *
     *
     * @param mixed $page
     * @param bool  $refresh
     * @return array
     */
    public static function &getTplPageList($page = '', $refresh = true)
    {
        $list = null;

        $cache_file = empty($page) ? 'template-list' : 'template-page';
        /*
        load_functions("cache");
        $list = mod_loadCacheFile($cache_file, $GLOBALS["artdirname"]);
        */

        xoops_load('xoopscache');
        $key  = $GLOBALS['artdirname'] . "_{$cache_file}";
        $list = \XoopsCache::read($key);

        if (!is_array($list) || $refresh) {
            $list = self::template_lookup(!empty($page));
        }

        $ret = empty($page) ? $list : @$list[$page];

        return $ret;
    }

    /**
     * @param bool $index_by_page
     * @return array
     */
    public static function &template_lookup($index_by_page = false)
    {
        require_once XOOPS_ROOT_PATH . '/class/xoopslists.php';

        $files = \XoopsLists::getHtmlListAsArray(XOOPS_ROOT_PATH . '/modules/' . $GLOBALS['artdirname'] . '/templates/');
        $list  = [];
        foreach ($files as $file => $name) {
            // The valid file name must be: art_article_mytpl.html OR art_category-1_your-trial.html
            if (preg_match('/^' . $GLOBALS['artdirname'] . "_([^_]*)(_(.*))?\.(tpl|xotpl)$/i", $name, $matches)) {
                if (empty($matches[1])) {
                    continue;
                }
                if (empty($matches[3])) {
                    $matches[3] = 'default';
                }
                if (empty($index_by_page)) {
                    $list[] = ['file' => $name, 'description' => $matches[3]];
                } else {
                    $list[$matches[1]][$matches[3]] = $name;
                }
            }
        }

        $cache_file = empty($index_by_page) ? 'template-list' : 'template-page';
        xoops_load('xoopscache');
        $key = $GLOBALS['artdirname'] . "_{$cache_file}";
        \XoopsCache::write($key, $list);

        //load_functions("cache");
        //mod_createCacheFile($list, $cache_file, $GLOBALS["artdirname"]);
        return $list;
    }

}
