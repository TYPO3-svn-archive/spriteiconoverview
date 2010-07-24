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
/**
 * [CLASS/FUNCTION INDEX of SCRIPT]
 *
 * Hint: use extdeveval to insert/update function index above.
 */


$LANG->includeLLFile('EXT:spriteiconoverview/mod1/locallang.xml');
require_once(PATH_t3lib . 'class.t3lib_scbase.php');
$BE_USER->modAccess($MCONF,1);	// This checks permissions and exits if the users has no permission for entry.
	// DEFAULT initialization of a module [END]



/**
 * Module 'Sprite Icon overview' for the 'spriteiconoverview' extension.
 *
 * @author	Tolleiv Nietsch <info@tolleiv.de>
 * @package	TYPO3
 * @subpackage	tx_spriteiconoverview
 */
class  tx_spriteiconoverview_module1 extends t3lib_SCbase {
				var $pageinfo;

				/**
				 * Initializes the Module
				 * @return	void
				 */
				function init()	{
					global $BE_USER,$LANG,$BACK_PATH,$TCA_DESCR,$TCA,$CLIENT,$TYPO3_CONF_VARS;

					parent::init();

					/*
					if (t3lib_div::_GP('clear_all_cache'))	{
						$this->include_once[] = PATH_t3lib.'class.t3lib_tcemain.php';
					}
					*/
				}

				/**
				 * Adds items to the ->MOD_MENU array. Used for the function menu selector.
				 *
				 * @return	void
				 */
				function menuConfig()	{
					global $LANG;
					$this->MOD_MENU = Array (
                        'function' => Array (
                            '1' => $LANG->getLL('function1'),
                            '2' => $LANG->getLL('function2'),
                            '3' => $LANG->getLL('function3'),
                        )
					);
					parent::menuConfig();
				}

				/**
				 * Main function of the module. Write the content to $this->content
				 * If you chose "web" as main module, you will need to consider the $this->id parameter which will contain the uid-number of the page clicked in the page tree
				 *
				 * @return	[type]		...
				 */
				function main()	{
					global $BE_USER,$LANG,$BACK_PATH,$TCA_DESCR,$TCA,$CLIENT,$TYPO3_CONF_VARS;

					// Access check!
					// The page will show only if there is a valid page and if this page may be viewed by the user
					$this->pageinfo = t3lib_BEfunc::readPageAccess($this->id,$this->perms_clause);
					$access = is_array($this->pageinfo) ? 1 : 0;
				
						// initialize doc
					$this->doc = t3lib_div::makeInstance('template');
					$this->doc->setModuleTemplate(t3lib_extMgm::extPath('spriteiconoverview') . 'mod1//mod_template.html');
					$this->doc->backPath = $BACK_PATH;
					$docHeaderButtons = $this->getButtons();

					if (($this->id && $access) || ($BE_USER->user['admin'] && !$this->id))	{

						$this->doc->addStyleSheet('mod1.css',t3lib_extMgm::extRelPath('spriteiconoverview') . 'mod1/mod1.css');

							// Draw the form
						$this->doc->form = '<form action="" method="post" enctype="multipart/form-data">';

							// JavaScript
						$this->doc->JScode = '
							<script language="javascript" type="text/javascript">
								script_ended = 0;
								function jumpToUrl(URL)	{
									document.location = URL;
								}
							</script>
						';
						$this->doc->postCode='
							<script language="javascript" type="text/javascript">
								script_ended = 1;
								if (top.fsMod) top.fsMod.recentIds["web"] = 0;
							</script>
						';
							// Render content:
						$this->moduleContent();
					} else {
							// If no access or if ID == zero
						$docHeaderButtons['save'] = '';
						$this->content.=$this->doc->spacer(10);
					}

						// compile document
					$markers['FUNC_MENU'] = t3lib_BEfunc::getFuncMenu(0, 'SET[function]', $this->MOD_SETTINGS['function'], $this->MOD_MENU['function']);
					$markers['CONTENT'] = $this->content;

							// Build the <body> for the module
					$this->content = $this->doc->startPage($LANG->getLL('title'));
					$this->content.= $this->doc->moduleBody($this->pageinfo, $docHeaderButtons, $markers);
					$this->content.= $this->doc->endPage();
					$this->content = $this->doc->insertStylesAndJS($this->content);
				
				}

				/**
				 * Prints out the module HTML
				 *
				 * @return	void
				 */
				function printContent()	{

					$this->content.=$this->doc->endPage();
					echo $this->content;
				}

				/**
				 * Generates the module content
				 *
				 * @return	void
				 */
				function moduleContent()	{
					$this->content = '';
                    switch((string)$this->MOD_SETTINGS['function'])    {
                        case 1:
							$iconsAvailable = $GLOBALS['TBE_STYLES']['spriteIconApi']['iconsAvailable'];
							foreach($iconsAvailable as $icon) {
								$this->content .=  '<div class="iconItem">' . t3lib_iconWorks::getSpriteIcon($icon) . ' ' . $icon . '</div>';
							}
							$this->content .= '<br style="clear:both" />';
							$this->content .= $this->doc->spacer(10);
							$this->content .= $GLOBALS['LANG']->getLL('function1_example1') . '<br />';
							$this->content .= $this->doc->spacer(10);							
							$example = 't3lib_iconWorks::getSpriteIcon($icon);';							
							$this->content .= highlight_string($example, true);
							$this->content .= $this->doc->spacer(10);
							$this->content .= $GLOBALS['LANG']->getLL('function1_example2') . '<br />';
							$this->content .= $this->doc->spacer(10);							
							$example = '
		// ext_tables.php:
$icons = array(\'extensions-myextension-icon1\', \'extensions-myextension-icon2\');
t3lib_SpriteManager::addIconSprite($icons,t3lib_extMgm::siteRelPath(\'myextension\') . \'myextension_sprite.css\');							

	// myextension_sprite.css:
.t3-icon-extensions-myextension {	background-image:url(../../typo3conf/ext/myextension/myextension_sprite.gif);	}
.t3-icon-extensions-myextension-icon1 {	background-position: 0px 0px; }
.t3-icon-extensions-myextension-icon2 {	background-position: 0px -16px; }
							';							
							$this->content .= highlight_string($example, true);
                        break;
                        case 2:
							$singleIcons = $GLOBALS['TBE_STYLES']['spritemanager']['singleIcons'];
							foreach($singleIcons as $name=>$icon) {
								$this->content .=  '<div class="iconItem">' . t3lib_iconWorks::getSpriteIcon($name) . ' ' . $name . '</div>';
							}
							$this->content .= '<br style="clear:both" />';
							$this->content .= $this->doc->spacer(10);
							$this->content .= $GLOBALS['LANG']->getLL('function2_example') . '<br />';
							$this->content .= $this->doc->spacer(10);
							
							$example = 'if(version_compare(TYPO3_version,\'4.4\',\'>\')) {
	$icons = array(
		\'myicon\' => t3lib_extMgm::extRelPath($_EXTKEY) . \'myicon.gif\',
	);
	t3lib_SpriteManager::addSingleIcons($icons, $_EXTKEY);
}';
							
							$this->content .= highlight_string($example, true);
                        break;
                        case 3:
							$overlays = $GLOBALS['TBE_STYLES']['spriteIconApi']['spriteIconRecordOverlayNames'];
							$overlayOptions = array(
								'class' => 't3-icon-overlay'
							);
							foreach($overlays as $overlay) {
								$this->content .=  '<div class="iconItem">' . t3lib_iconWorks::getSpriteIcon('mimetypes-other-other',array(), array($overlay=>array())) . ' ' . $overlay . '</div>';
							}
							$this->content .= '<br style="clear:both" />';
							$this->content .= $this->doc->spacer(10);
							$this->content .= $GLOBALS['LANG']->getLL('function3_example') . '<br />';
							$this->content .= $this->doc->spacer(10);
							
							$example = 't3lib_iconWorks::getSpriteIcon(\'mimetypes-other-other\',array(), array(\'overlayname\'=>array()))';
							
							$this->content .= highlight_string($example, true);
						
						break;
                    }					
				}
				

				/**
				 * Create the panel of buttons for submitting the form or otherwise perform operations.
				 *
				 * @return	array	all available buttons as an assoc. array
				 */
				protected function getButtons()	{

					$buttons = array(
						'csh' => '',
						'shortcut' => '',
						'save' => ''
					);
						// CSH
					$buttons['csh'] = t3lib_BEfunc::cshItem('_MOD_web_func', '', $GLOBALS['BACK_PATH']);

						// Shortcut
					if ($GLOBALS['BE_USER']->mayMakeShortcut())	{
						$buttons['shortcut'] = $this->doc->makeShortcutIcon('', 'function', $this->MCONF['name']);
					}

					return $buttons;
				}
				
		}



if (defined('TYPO3_MODE') && $TYPO3_CONF_VARS[TYPO3_MODE]['XCLASS']['ext/spriteiconoverview/mod1/index.php'])	{
	include_once($TYPO3_CONF_VARS[TYPO3_MODE]['XCLASS']['ext/spriteiconoverview/mod1/index.php']);
}




// Make instance:
$SOBE = t3lib_div::makeInstance('tx_spriteiconoverview_module1');
$SOBE->init();

// Include files?
foreach($SOBE->include_once as $INC_FILE)	include_once($INC_FILE);

$SOBE->main();
$SOBE->printContent();

?>