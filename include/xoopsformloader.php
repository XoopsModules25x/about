<?php
/**
 * Links
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
 * @package        links
 * @since          1.0.0
 * @author         Mengjue Shao <magic.shao@gmail.com>
 * @version        $Id: xoopsformloader.php 1 2010-1-22 ezsky$
 */

defined('XOOPS_ROOT_PATH') || exit('XOOPS root path not defined');

include_once XOOPS_ROOT_PATH . '/class/xoopsform/formelement.php';
include_once XOOPS_ROOT_PATH . '/class/xoopsform/form.php';
include_once XOOPS_ROOT_PATH . '/class/xoopsform/formlabel.php';
include_once XOOPS_ROOT_PATH . '/class/xoopsform/formselect.php';
include_once XOOPS_ROOT_PATH . '/class/xoopsform/formpassword.php';
include_once XOOPS_ROOT_PATH . '/class/xoopsform/formbutton.php';
include_once XOOPS_ROOT_PATH . '/class/xoopsform/formcheckbox.php';
include_once XOOPS_ROOT_PATH . '/class/xoopsform/formhidden.php';
include_once XOOPS_ROOT_PATH . '/class/xoopsform/formfile.php';
include_once XOOPS_ROOT_PATH . '/class/xoopsform/formradio.php';
include_once XOOPS_ROOT_PATH . '/class/xoopsform/formradioyn.php';
//include_once XOOPS_ROOT_PATH."/class/xoopsform/formselectavatar.php";
include_once XOOPS_ROOT_PATH . '/class/xoopsform/formselectcountry.php';
include_once XOOPS_ROOT_PATH . '/class/xoopsform/formselecttimezone.php';
include_once XOOPS_ROOT_PATH . '/class/xoopsform/formselectlang.php';
include_once XOOPS_ROOT_PATH . '/class/xoopsform/formselectgroup.php';
// RMV-NOTIFY
include_once XOOPS_ROOT_PATH . '/class/xoopsform/formselectuser.php';
include_once XOOPS_ROOT_PATH . '/class/xoopsform/formselecttheme.php';
include_once XOOPS_ROOT_PATH . '/class/xoopsform/formselectmatchoption.php';
include_once XOOPS_ROOT_PATH . '/class/xoopsform/formtext.php';
include_once XOOPS_ROOT_PATH . '/class/xoopsform/formtextarea.php';
include_once XOOPS_ROOT_PATH . '/class/xoopsform/formdhtmltextarea.php';
include_once XOOPS_ROOT_PATH . '/class/xoopsform/formelementtray.php';
include_once XOOPS_ROOT_PATH . '/class/xoopsform/themeform.php';
include_once XOOPS_ROOT_PATH . '/class/xoopsform/simpleform.php';
include_once XOOPS_ROOT_PATH . '/class/xoopsform/formtextdateselect.php';
include_once XOOPS_ROOT_PATH . '/class/xoopsform/formdatetime.php';
include_once XOOPS_ROOT_PATH . '/class/xoopsform/formhiddentoken.php';
//include_once XOOPS_ROOT_PATH."/class/xoopsform/grouppermform.php";
include_once XOOPS_ROOT_PATH . '/class/xoopsform/formcolorpicker.php';

include_once XOOPS_ROOT_PATH . '/class/xoopsform/formcaptcha.php';
include_once XOOPS_ROOT_PATH . '/class/xoopsform/formeditor.php';
include_once XOOPS_ROOT_PATH . '/class/xoopsform/formselecteditor.php';

//ezsky hack
include_once __DIR__ . '/blockform.php';
