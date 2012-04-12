<?php if (!defined('TL_ROOT')) die('You can not access this file directly!');

/**
 * Avisota newsletter and mailing system
 * Copyright (C) 2012 Tristan Lins
 *
 * Extension for:
 * Contao Open Source CMS
 * Copyright (C) 2005-2010 Leo Feyer
 *
 * Formerly known as TYPOlight Open Source CMS.
 *
 * This program is free software: you can redistribute it and/or
 * modify it under the terms of the GNU Lesser General Public
 * License as published by the Free Software Foundation, either
 * version 3 of the License, or (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the GNU
 * Lesser General Public License for more details.
 *
 * You should have received a copy of the GNU Lesser General Public
 * License along with this program. If not, please visit the Free
 * Software Foundation website at <http://www.gnu.org/licenses/>.
 *
 * PHP version 5
 * @copyright  InfinitySoft 2012
 * @author     Tristan Lins <tristan.lins@infinitysoft.de>
 * @package    lazyResize
 * @license    LGPL
 * @filesource
 */


/**
 * Enable lazy resize
 */
if (!isset($GLOBALS['lazyResize'])) {
	$GLOBALS['lazyResize'] = true;
}

/**
 * Settings
 */
$GLOBALS['TL_CONFIG']['lazyResizeAdaptiveResolution'] = true;
$GLOBALS['TL_CONFIG']['lazyResizeResolutionCookie']   = 'lazyResizeResolution';
$GLOBALS['TL_CONFIG']['lazyResizeAdaptivePixelRatio'] = true;
$GLOBALS['TL_CONFIG']['lazyResizePixelRatioCookie']   = 'lazyResizePixelRatio';

/**
 * Maintenance
 */
$pos = array_search('PurgeData', $GLOBALS['TL_MAINTENANCE']);
if ($pos === false) {
	$GLOBALS['TL_MAINTENANCE'][] = 'PurgeImages';
}
else {
	$GLOBALS['TL_MAINTENANCE'] = array_merge(
		array_slice($GLOBALS['TL_MAINTENANCE'], 0, $pos + 1),
		array('PurgeImages'),
		array_slice($GLOBALS['TL_MAINTENANCE'], $pos + 1)
	);
}

/**
 * HOOKs
 */
if (is_array($GLOBALS['TL_HOOKS']['getImage'])) {
	array_unshift($GLOBALS['TL_HOOKS']['getImage'], array('LazyResize', 'hookGetImage'));
}
else {
	$GLOBALS['TL_HOOKS']['getImage'] = array(array('LazyResize', 'hookGetImage'));
}
$GLOBALS['TL_HOOKS']['generatePage'][] = array('LazyResize', 'hookGeneratePage');
