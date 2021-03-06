<?php
namespace FluidTYPO3\Vhs\ViewHelpers\Page;

/*
 * This file is part of the FluidTYPO3/Vhs project under GPLv2 or later.
 *
 * For the full copyright and license information, please read the
 * LICENSE.md file that was distributed with this source code.
 */

use FluidTYPO3\Vhs\Service\PageSelectService;
use FluidTYPO3\Vhs\Utility\ViewHelperUtility;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Fluid\Core\ViewHelper\AbstractViewHelper;

/**
 * ViewHelper to access data of the current page record
 *
 * @author Björn Fromme <fromeme@dreipunktnull.com>, dreipunktnull
 * @author Danilo Bürger <danilo.buerger@hmspl.de>, Heimspiel GmbH
 * @package Vhs
 * @subpackage ViewHelpers\Page
 */
class InfoViewHelper extends AbstractViewHelper {

	/**
	 * @var PageSelectService
	 */
	protected $pageSelect;

	/**
	 * @param PageSelectService $pageSelect
	 * @return void
	 */
	public function injectPageSelectService(PageSelectService $pageSelect) {
		$this->pageSelect = $pageSelect;
	}

	/**
	 * @return void
	 */
	public function initializeArguments() {
		$this->registerArgument('pageUid', 'integer', 'If specified, this UID will be used to fetch page data instead of using the current page.', FALSE, 0);
		$this->registerArgument('as', 'string', 'If specified, a template variable with this name containing the requested data will be inserted instead of returning it.', FALSE, NULL);
		$this->registerArgument('field', 'string', 'If specified, only this field will be returned/assigned instead of the complete page record.', FALSE, NULL);
	}

	/**
	 * @return mixed
	 */
	public function render() {
		// Get page via pageUid argument or current id
		$pageUid = intval($this->arguments['pageUid']);
		if (0 === $pageUid) {
			$pageUid = $GLOBALS['TSFE']->id;
		}

		$page = $this->pageSelect->getPage($pageUid);

		// Add the page overlay
		$languageUid = intval($GLOBALS['TSFE']->sys_language_uid);
		if (0 !== $languageUid) {
			$pageOverlay = $this->pageSelect->getPageOverlay($pageUid, $languageUid);
			if (TRUE === is_array($pageOverlay)) {
				$page = GeneralUtility::array_merge_recursive_overrule($page, $pageOverlay, FALSE, FALSE);
			}
		}

		$content = NULL;

		// Check if field should be returned or assigned
		$field = $this->arguments['field'];
		if (TRUE === empty($field)) {
			$content = $page;
		} elseif (TRUE === isset($page[$field])) {
			$content = $page[$field];
		}

		// Return if no assign
		$as = $this->arguments['as'];
		if (TRUE === empty($as)) {
			return $content;
		}

		$variables = array($as => $content);
		$output = ViewHelperUtility::renderChildrenWithVariables($this, $this->templateVariableContainer, $variables);

		return $output;
	}

}
