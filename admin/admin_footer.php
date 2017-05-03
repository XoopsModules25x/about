<?php
/*
 * You may not change or alter any portion of this comment or credits
 * of supporting developers from this source code or any supporting source code
 * which is considered copyrighted (c) material of the original comment or credit authors.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.
 */

/**
 * @copyright    XOOPS Project (http://xoops.org)
 * @license      GNU GPL 2 or later (http://www.gnu.org/licenses/gpl-2.0.html)
 * @author       XOOPS Development Team
 */

/*

global $xoopsModule;
//$pathIcon32      = '../' . $xoopsModule->getInfo('icons32');

echo "<div class='adminfooter'>\n" . "  <div style='text-align: center;'>\n" . "    <a href='http://www.xoops.org' rel='external'><img src='{$pathIcon32}/xoopsmicrobutton.gif' alt='XOOPS' title='XOOPS'></a>\n" . "  </div>\n" . '  ' . _AM_MODULEADMIN_ADMIN_FOOTER . "\n" . '</div>';
*/
echo "<div class='adminfooter'>\n"
   . "  <div class='txtcenter'>\n"
   . "    <a href='http://www.xoops.org' rel='external' target='_blank'><img src='" . \Xmf\Module\Admin::iconUrl('xoopsmicrobutton.gif', '32') . "' alt='XOOPS' title='XOOPS'></a>\n"
   . "  </div>\n"
   . "  " . _AM_MODULEADMIN_ADMIN_FOOTER . "\n"
   . "</div>\n";

xoops_cp_footer();
