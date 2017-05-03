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
 * @package
 * @since
 * @author       XOOPS Development Team
 */

include_once __DIR__ . '/admin_header.php';
// Display Admin header
xoops_cp_header();

$moduleAdmin  = \Xmf\Module\Admin::getInstance();

// Get number of pages, grouped by status
$page_handler = $abtHelper->getHandler('page');
$criteria = new CriteriaCompo();
$criteria->add(new Criteria('page_type', AboutConstants::PAGE_TYPE_PAGE));
$criteria->setGroupBy('page_status');
$page_results = $page_handler->getCount($criteria);

$page_results[AboutConstants::PUBLISHED]     = array_key_exists(AboutConstants::PUBLISHED, $page_results) ? $page_results[AboutConstants::PUBLISHED] : 0;
$page_results[AboutConstants::NOT_PUBLISHED] = array_key_exists(AboutConstants::NOT_PUBLISHED, $page_results) ? $page_results[AboutConstants::NOT_PUBLISHED] : 0;

// Get number of links, grouped by status
$criteria = new CriteriaCompo();
$criteria->add(new Criteria('page_type', AboutConstants::PAGE_TYPE_LINK));
$criteria->setGroupBy('page_status');
$link_results = $page_handler->getCount($criteria);
$link_results[AboutConstants::PUBLISHED]     = array_key_exists(AboutConstants::PUBLISHED, $link_results) ? $link_results[AboutConstants::PUBLISHED] : 0;
$link_results[AboutConstants::NOT_PUBLISHED] = array_key_exists(AboutConstants::NOT_PUBLISHED, $link_results) ? $link_results[AboutConstants::NOT_PUBLISHED] : 0;

// Display totals
$moduleAdmin->addInfoBox(_MD_ABOUT_DASHBOARD);
$moduleAdmin->addInfoBoxLine(sprintf("<span class='infolabel'>" . _MD_ABOUT_TOTAL_PAGES_PUBLISHED . "</span>", "<span class='infotext green bold'>" . $page_results[AboutConstants::PUBLISHED] . "</span>"));
$moduleAdmin->AddInfoBoxLine(sprintf("<span class='infolabel'>" . _MD_ABOUT_TOTAL_PAGES_DRAFT . "</span>", "<span class='infotext red bold'>" . $page_results[AboutConstants::NOT_PUBLISHED] . "</span>"));
$moduleAdmin->addInfoBoxLine(sprintf("<span class='infolabel'>" . _MD_ABOUT_TOTAL_LINKS_PUBLISHED . "</span>", "<span class='infotext green bold'>" . $link_results[AboutConstants::PUBLISHED] . "</span>"));
$moduleAdmin->AddInfoBoxLine(sprintf("<span class='infolabel'>" . _MD_ABOUT_TOTAL_LINKS_DRAFT . "</span>", "<span class='infotext red bold'>" . $link_results[AboutConstants::NOT_PUBLISHED] . "</span>"));

$moduleAdmin->displayNavigation(basename(__FILE__));
$moduleAdmin->displayIndex();

include_once __DIR__ . '/admin_footer.php';
