<?php if (!defined('TL_ROOT')) die('You cannot access this file directly!');

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
 * Class PurgeImages
 *
 * Maintenance module "purge lazy images".
 * @copyright  InfinitySoft 2012
 * @copyright  Leo Feyer 2005-2012
 * @author     Tristan Lins <tristan.lins@infinitysoft.de>
 * @author     Leo Feyer <http://www.contao.org>
 * @package    lazyResize
 */
class PurgeImages extends Backend implements executable
{

	/**
	 * Return true if the module is active
	 * @return boolean
	 */
	public function isActive()
	{
		return ($this->Input->post('FORM_SUBMIT') == 'tl_purge_images');
	}


	/**
	 * Generate the module
	 * @return string
	 */
	public function run()
	{
		$arrCacheTables = array();
		$objTemplate = new BackendTemplate('be_purge_images');
		$objTemplate->isActive = $this->isActive();

		// Confirmation message
		if ($_SESSION['CLEAR_IMAGES_CONFIRM'] != '')
		{
			$objTemplate->cacheMessage = sprintf('<p class="tl_confirm">%s</p>' . "\n", $_SESSION['CLEAR_IMAGES_CONFIRM']);
			$_SESSION['CLEAR_IMAGES_CONFIRM'] = '';
		}

		// Purge the resources
		if ($objTemplate->isActive)
		{
			$this->import('Files');

			if ($this->Input->post('purge_adaptive_images')) {
				$intCount = $this->purgeImagesFolder(true);
				$_SESSION['CLEAR_IMAGES_CONFIRM'] = sprintf($GLOBALS['TL_LANG']['tl_maintenance']['purgedAdaptiveImages'], $intCount);
			}
			else if ($this->Input->post('purge_all_images')) {
				$intCount = $this->purgeImagesFolder(false);
				$_SESSION['CLEAR_IMAGES_CONFIRM'] = sprintf($GLOBALS['TL_LANG']['tl_maintenance']['purgedAllImages'], $intCount);
			}


			$this->reload();
		}

		$objTemplate->action = ampersand($this->Environment->request);

		return $objTemplate->parse();
	}

	/**
	 * Purge the images directory
	 */
	public function purgeImagesFolder($blnOnlyAdaptive)
	{
		$arrFiles = scan(TL_ROOT . '/system/images', true);
		$intCount = 0;

		// Remove files
		if (is_array($arrFiles))
		{
			foreach ($arrFiles as $strFile)
			{
				if ($strFile != '.keep' &&
					!is_dir(TL_ROOT . '/system/images/' . $strFile) &&
					(!$blnOnlyAdaptive || preg_match('#^_(resolution\d+|pixelRatio\d+)#', $strFile)))
				{
					$this->Files->delete('system/images/' . $strFile);

					if (!preg_match('#\.meta$#', $strFile)) {
						$intCount++;
					}
				}
			}
		}

		// Add log entry
		$this->log('Purged the lazy images directory', 'PurgeImages purgeImagesFolder()', TL_CRON);

		return $intCount;
	}

}
