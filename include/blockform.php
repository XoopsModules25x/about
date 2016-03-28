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
 * @package        about
 * @since          1.0.0
 * @author         Susheng Yang <ezskyyoung@gmail.com>
 * @version        $Id: blockform.php 1 2010-1-22 ezsky$
 */

defined('XOOPS_ROOT_PATH') || exit('XOOPS root path not defined');

include_once XOOPS_ROOT_PATH . '/class/xoopsform/form.php';

/**
 * Class XoopsBlockForm
 */
class XoopsBlockForm extends XoopsForm
{
    /**
     * XoopsBlockForm constructor.
     */
    public function __construct()
    {
    }

    /**
     * create HTML to output the form as a table
     *
     * @return string
     */
    public function render()
    {
        $ele_name = $this->getName();
        $ret      = '<div>';
        $hidden   = '';
        foreach ($this->getElements() as $ele) {
            if (!is_object($ele)) {
                $ret .= $ele;
            } elseif (!$ele->isHidden()) {
                if (($caption = $ele->getCaption()) != '') {
                    $ret .= "<div class='xoops-form-element-caption" . ($ele->isRequired() ? '-required' : '') . "'>" . "<span class='caption-text'><strong>{$caption}</strong></span>" . "<span class='caption-marker'>*</span>" . '</div>';
                }

                $ret .= "<div style='margin:5px 0 8px 0; '>" . $ele->render() . "</div>\n";
            } else {
                $hidden .= $ele->render();
            }
        }
        $ret .= '</div>';
        $ret .= $this->renderValidationJS(true);

        return $ret;
    }
}
