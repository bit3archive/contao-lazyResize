<?php if (!defined('TL_ROOT')) die('You cannot access this file directly!');

/**
 * Contao Open Source CMS
 * Copyright (C) 2005-2012 Leo Feyer
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
 * @copyright  Leo Feyer 2005-2012
 * @author     Leo Feyer <http://www.contao.org>
 * @package    Backend
 * @license    LGPL
 * @filesource
 */


/**
 * System configuration
 */
$GLOBALS['TL_DCA']['tl_settings']['palettes']['__selector__'][] = 'lazyResizeAdaptiveResolution';
$GLOBALS['TL_DCA']['tl_settings']['palettes']['__selector__'][] = 'lazyResizeAdaptivePixelRatio';
MetaPalettes::appendTo('tl_settings', array(
	'lazyResize' => array('lazyResizeAdaptiveResolution', 'lazyResizeAdaptivePixelRatio', 'lazyResizeAdaptiveNoAutoDetect')
));
$GLOBALS['TL_DCA']['tl_settings']['subpalettes']['lazyResizeAdaptiveResolution'] = 'lazyResizeResolutionCookie';
$GLOBALS['TL_DCA']['tl_settings']['subpalettes']['lazyResizeAdaptivePixelRatio'] = 'lazyResizePixelRatioCookie';

$GLOBALS['TL_DCA']['tl_settings']['fields']['lazyResizeAdaptiveResolution'] = array
(
	'label'                   => &$GLOBALS['TL_LANG']['tl_settings']['lazyResizeAdaptiveResolution'],
	'inputType'               => 'checkbox',
	'eval'                    => array('tl_class'      => 'm12 w50 clr',
	                                   'submitOnChange'=> true)
);

$GLOBALS['TL_DCA']['tl_settings']['fields']['lazyResizeResolutionCookie'] = array
(
	'label'                   => &$GLOBALS['TL_LANG']['tl_settings']['lazyResizeResolutionCookie'],
	'inputType'               => 'text',
	'eval'                    => array('mandatory'=> true,
	                                   'tl_class' => 'w50')
);

$GLOBALS['TL_DCA']['tl_settings']['fields']['lazyResizeAdaptivePixelRatio'] = array
(
	'label'                   => &$GLOBALS['TL_LANG']['tl_settings']['lazyResizeAdaptivePixelRatio'],
	'inputType'               => 'checkbox',
	'eval'                    => array('tl_class'      => 'm12 w50 clr',
	                                   'submitOnChange'=> true)
);

$GLOBALS['TL_DCA']['tl_settings']['fields']['lazyResizePixelRatioCookie'] = array
(
	'label'                   => &$GLOBALS['TL_LANG']['tl_settings']['lazyResizePixelRatioCookie'],
	'inputType'               => 'text',
	'eval'                    => array('mandatory'=> true,
	                                   'tl_class' => 'w50')
);

$GLOBALS['TL_DCA']['tl_settings']['fields']['lazyResizeAdaptiveNoAutoDetect'] = array
(
	'label'                   => &$GLOBALS['TL_LANG']['tl_settings']['lazyResizeAdaptiveNoAutoDetect'],
	'inputType'               => 'checkbox',
	'eval'                    => array('tl_class'      => 'm12 w50 clr',
	                                   'submitOnChange'=> true)
);
