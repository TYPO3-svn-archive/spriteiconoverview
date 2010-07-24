<?php
/***************************************************************
*  Copyright notice
*
*  (c) 2010 Tolleiv Nietsch <info@tolleiv.de>
*  All rights reserved
*
*  This script is part of the TYPO3 project. The TYPO3 project is
*  free software; you can redistribute it and/or modify
*  it under the terms of the GNU General Public License as published by
*  the Free Software Foundation; either version 2 of the License, or
*  (at your option) any later version.
*
*  The GNU General Public License can be found at
*  http://www.gnu.org/copyleft/gpl.html.
*
*  This script is distributed in the hope that it will be useful,
*  but WITHOUT ANY WARRANTY; without even the implied warranty of
*  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
*  GNU General Public License for more details.
*
*  This copyright notice MUST APPEAR in all copies of the script!
***************************************************************/

class tx_spriteiconoverview_extdeveval {

	/**
	 * Initialization (none needed)
	 *
	 * @return	void
	 */
	function init()	{
		$this->func = t3lib_div::intInRange(t3lib_div::_GP('func'), 1, 3, 1);
	}

	/**
	 * The main function in the class
	 *
	 * @return	string		HTML content
	 */
	function main()	{
	
		$output = $this->renderFunctionMenu();
		$output.= '<style type="text/css">.iconItem { float:left;display:block;min-width:350px; } </style>';
		switch($this->func)    {
			case 1:
				$iconsAvailable = $GLOBALS['TBE_STYLES']['spriteIconApi']['iconsAvailable'];
				foreach($iconsAvailable as $icon) {
					$output .=  '<div class="iconItem">' . t3lib_iconWorks::getSpriteIcon($icon) . ' ' . $icon . '</div>';
				}
				$output .= '<br style="clear:both" />';
				$output .= '<hr />';
				$output .= $GLOBALS['LANG']->sL('LLL:EXT:spriteiconoverview/locallang.xml:function1_example1') . '<br />';
				$example = 't3lib_iconWorks::getSpriteIcon($icon);';							
				$output .= highlight_string($example, true);
				$output .= '<hr />';
				$output .= $GLOBALS['LANG']->sL('LLL:EXT:spriteiconoverview/locallang.xml:function1_example2') . '<br />';			
				$example = '
// ext_tables.php:
$icons = array(\'extensions-myextension-icon1\', \'extensions-myextension-icon2\');
t3lib_SpriteManager::addIconSprite($icons,t3lib_extMgm::siteRelPath(\'myextension\') . \'myextension_sprite.css\');							

// myextension_sprite.css:
.t3-icon-extensions-myextension {
	background-image:url(../../typo3conf/ext/myextension/myextension_sprite.gif);
}
.t3-icon-extensions-myextension-icon1 {	background-position: 0px 0px; }
.t3-icon-extensions-myextension-icon2 {	background-position: 0px -16px; }
				';							
				$output .= highlight_string($example, true);
			break;
			case 2:
				$singleIcons = $GLOBALS['TBE_STYLES']['spritemanager']['singleIcons'];
				foreach($singleIcons as $name=>$icon) {
					$output .=  '<div class="iconItem">' . t3lib_iconWorks::getSpriteIcon($name) . ' ' . $name . '</div>';
				}
				$output .= '<br style="clear:both" />';
				$output .= '<hr />';
				$output .= $GLOBALS['LANG']->sL('LLL:EXT:spriteiconoverview/locallang.xml:function2_example') . '<br />';
				
				$example = 'if(version_compare(TYPO3_version,\'4.4\',\'>\')) {
$icons = array(
	\'myicon\' => t3lib_extMgm::extRelPath($_EXTKEY) . \'myicon.gif\',
);
t3lib_SpriteManager::addSingleIcons($icons, $_EXTKEY);
}';
				
				$output .= highlight_string($example, true);
			break;
			case 3:
				$overlays = $GLOBALS['TBE_STYLES']['spriteIconApi']['spriteIconRecordOverlayNames'];
				$overlayOptions = array(
					'class' => 't3-icon-overlay'
				);
				foreach($overlays as $overlay) {
					$output .=  '<div class="iconItem">' . t3lib_iconWorks::getSpriteIcon('mimetypes-other-other',array(), array($overlay=>array())) . ' ' . $overlay . '</div>';
				}
				$output .= '<br style="clear:both" />';
				$output .= '<hr />';
				$output .= $GLOBALS['LANG']->sL('LLL:EXT:spriteiconoverview/locallang.xml:function3_example') . '<br />';			
				$example = 't3lib_iconWorks::getSpriteIcon(\'mimetypes-other-other\',array(), array(\'overlayname\'=>array()))';
				
				$output .= highlight_string($example, true);
			
			break;
		}

		return $output;
	}

	function renderFunctionMenu()	{

		$content = '
			<p><strong>Select function:</strong></p>
			<select onchange="'.htmlspecialchars('document.location = \'index.php?func=\'+this.options[this.selectedIndex].value').'">
				<option value="1"'.($this->func==1?' selected="selected"':'').'>'.htmlspecialchars($GLOBALS['LANG']->sL('LLL:EXT:spriteiconoverview/locallang.xml:function1')).'</option>
				<option value="2"'.($this->func==2?' selected="selected"':'').'>'.htmlspecialchars($GLOBALS['LANG']->sL('LLL:EXT:spriteiconoverview/locallang.xml:function2')).'</option>
				<option value="3"'.($this->func==3?' selected="selected"':'').'>'.htmlspecialchars($GLOBALS['LANG']->sL('LLL:EXT:spriteiconoverview/locallang.xml:function3')).'</option>
			</select>
			<hr />
			';

			// Return selector box menu:
		return $content;
	}
}


if (defined('TYPO3_MODE') && $TYPO3_CONF_VARS[TYPO3_MODE]['XCLASS']['ext/templavoila/class.tx_templavoila_extdeveval.php'])	{
	include_once($TYPO3_CONF_VARS[TYPO3_MODE]['XCLASS']['ext/templavoila/class.tx_templavoila_extdeveval.php']);
}
?>