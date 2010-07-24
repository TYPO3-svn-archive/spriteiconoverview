<?php
if (!defined('TYPO3_MODE')) {
	die ('Access denied.');
}

if (TYPO3_MODE == 'BE') {

	t3lib_extMgm::insertModuleFunction(
		'tools_txextdevevalM1',
		'tx_spriteiconoverview_extdeveval',
		t3lib_extMgm::extPath($_EXTKEY).'class.tx_spriteiconoverview_extdeveval.php',
		'Sprite icon overview'
	);
}
?>