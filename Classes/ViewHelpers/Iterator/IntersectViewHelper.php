<?php
namespace FluidTYPO3\Vhs\ViewHelpers\Iterator;

/*
 * This file is part of the FluidTYPO3/Vhs project under GPLv2 or later.
 *
 * For the full copyright and license information, please read the
 * LICENSE.md file that was distributed with this source code.
 */

use FluidTYPO3\Vhs\Utility\ViewHelperUtility;
use TYPO3\CMS\Fluid\Core\ViewHelper\AbstractViewHelper;

/**
 * Intersects arrays/Traversables $a and $b into an array
 *
 * @author Danilo Bürger <danilo.buerger@hmspl.de>, Heimspiel GmbH
 * @package Vhs
 * @subpackage ViewHelpers\Iterator
 */
class IntersectViewHelper extends AbstractViewHelper {

	/**
	 * Initialize
	 *
	 * @return void
	 */
	public function initializeArguments() {
		parent::initializeArguments();

		$this->registerArgument('a', 'mixed', 'First Array/Traversable/CSV', FALSE, NULL);
		$this->registerArgument('b', 'mixed', 'Second Array/Traversable/CSV', TRUE);
	}

	/**
	 * @return array
	 */
	public function render() {
		$a = $this->arguments['a'];
		if (NULL === $a) {
			$a = $this->renderChildren();
		}

		$a = ViewHelperUtility::arrayFromArrayOrTraversableOrCSV($a);
		$b = ViewHelperUtility::arrayFromArrayOrTraversableOrCSV($this->arguments['b']);

		return array_intersect($a, $b);
	}

}
