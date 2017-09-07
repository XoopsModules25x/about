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
 * @copyright    XOOPS Project (https://xoops.org)
 * @license      GNU GPL 2 or later (http://www.gnu.org/licenses/gpl-2.0.html)
 * @author     XOOPS Module Development Team
 */
echo "<div class='adminfooter'>\n"
   . "  <div class='txtcenter'>\n"
   . "    <a href='https://xoops.org' rel='external' target='_blank'><img src='" . Xmf\Module\Admin::iconUrl('xoopsmicrobutton.gif', '32') . "' alt='XOOPS' title='XOOPS'></a>\n"
     . "  </div>\n"
     . '  ' . _AM_MODULEADMIN_ADMIN_FOOTER . "\n"
   . "</div>\n";

xoops_cp_footer();
