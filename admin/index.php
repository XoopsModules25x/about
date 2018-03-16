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
 * @package
 * @since
 * @author       XOOPS Development Team
 */

use XoopsModules\About\Constants;

// Display Admin header
require_once __DIR__ . '/admin_header.php';
xoops_cp_header();

$adminObject  = Xmf\Module\Admin::getInstance();

// Get number of pages, grouped by status
//$pageHandler = $helper->getHandler('page');
$criteria = new \CriteriaCompo();
$criteria->add(new \Criteria('page_type', Constants::PAGE_TYPE_PAGE));
$criteria->setGroupBy('page_status');
$pageResults = $pageHandler->getCount($criteria);

$pageResults[Constants::PUBLISHED]     = array_key_exists(Constants::PUBLISHED, $pageResults) ? $pageResults[Constants::PUBLISHED] : 0;
$pageResults[Constants::NOT_PUBLISHED] = array_key_exists(Constants::NOT_PUBLISHED, $pageResults) ? $pageResults[Constants::NOT_PUBLISHED] : 0;

// Get number of links, grouped by status
$criteria = new \CriteriaCompo();
$criteria->add(new \Criteria('page_type', Constants::PAGE_TYPE_LINK));
$criteria->setGroupBy('page_status');
$linkResults = $pageHandler->getCount($criteria);
$linkResults[Constants::PUBLISHED]     = array_key_exists(Constants::PUBLISHED, $linkResults) ? $linkResults[Constants::PUBLISHED] : 0;
$linkResults[Constants::NOT_PUBLISHED] = array_key_exists(Constants::NOT_PUBLISHED, $linkResults) ? $linkResults[Constants::NOT_PUBLISHED] : 0;

// Display totals
$adminObject->addInfoBox(_MD_ABOUT_DASHBOARD);
$adminObject->addInfoBoxLine(sprintf("<span class='infolabel'>" . _MD_ABOUT_TOTAL_PAGES_PUBLISHED . '</span>', "<span class='infotext green bold'>" . $pageResults[Constants::PUBLISHED] . '</span>'));
$adminObject->AddInfoBoxLine(sprintf("<span class='infolabel'>" . _MD_ABOUT_TOTAL_PAGES_DRAFT . '</span>', "<span class='infotext red bold'>" . $pageResults[Constants::NOT_PUBLISHED] . '</span>'));
$adminObject->addInfoBoxLine(sprintf("<span class='infolabel'>" . _MD_ABOUT_TOTAL_LINKS_PUBLISHED . '</span>', "<span class='infotext green bold'>" . $linkResults[Constants::PUBLISHED] . '</span>'));
$adminObject->AddInfoBoxLine(sprintf("<span class='infolabel'>" . _MD_ABOUT_TOTAL_LINKS_DRAFT . '</span>', "<span class='infotext red bold'>" . $linkResults[Constants::NOT_PUBLISHED] . '</span>'));

$adminObject->displayNavigation(basename(__FILE__));
$adminObject->displayIndex();

echo $utility::getServerStats();


require_once __DIR__ . '/admin_footer.php';
