<?php

if (!defined('TYPO3_MODE')) {
    die('Access denied.');
}

if (TYPO3_MODE === 'BE') {
    \TYPO3\CMS\Extbase\Utility\ExtensionUtility::registerModule(
        'GeorgRinger.maildebug',
        'tools',
        'maildebug',
        '',
        [
            'Message' => 'list,show',
        ],
        [
            'access' => 'user,group',
            'icon'   => 'EXT:'.$_EXTKEY.'/Resources/Public/Icons/module.png',
            'labels' => 'LLL:EXT:'.$_EXTKEY.'/Resources/Private/Language/locallang_maildebug.xml',
        ]
    );
}
