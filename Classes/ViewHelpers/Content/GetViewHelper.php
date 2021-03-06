<?php
namespace FluidTYPO3\Vhs\ViewHelpers\Content;

/*
 * This file is part of the FluidTYPO3/Vhs project under GPLv2 or later.
 *
 * For the full copyright and license information, please read the
 * LICENSE.md file that was distributed with this source code.
 */

/**
 * ViewHelper used to render content elements in Fluid page templates
 *
 * @author Claus Due <claus@namelesscoder.net>
 * @author Dominique Feyer, <dfeyer@ttree.ch>
 * @author Daniel Schöne, <daniel@schoene.it>
 * @author Björn Fromme, <fromme@dreipunktnull.com>, dreipunktnull
 * @package Vhs
 * @subpackage ViewHelpers\Content
 */
class GetViewHelper extends AbstractContentViewHelper {

	/**
	 * Render method
	 *
	 * @return mixed
	 */
	public function render() {
		if ('BE' === TYPO3_MODE) {
			return '';
		}
		$contentRecords = $this->getContentRecords();
		return $contentRecords;
	}

}
