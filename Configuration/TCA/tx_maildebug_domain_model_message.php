<?php
if (!defined('TYPO3_MODE')) {
    die ('Access denied.');
}

return [
    'ctrl' => [
        'title' => 'LLL:EXT:maildebug/Resources/Private/Language/locallang.xml:tx_maildebug_domain_model_message',
        'label' => 'subject',
        'tstamp' => 'tstamp',
        'crdate' => 'crdate',
        'default_sortby' => 'ORDER BY uid DESC',
//        'iconfile' => \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::extRelPath('maildebug') . 'ext_icon.png'
    ],
    'interface' => [
        'showRecordFieldList' => 'subject, date, tx_maildebug_from, tx_maildebug_to, cc, bcc, content_type, body',
    ],
    'types' => [
        '1' => ['showitem' => 'subject, date, tx_maildebug_from, tx_maildebug_to, cc, bcc, content_type, body'],
    ],
    'palettes' => [
        '1' => ['showitem' => ''],
    ],
    'columns' => [
        'subject' => [
            'label' => 'LLL:EXT:maildebug/Resources/Private/Language/locallang.xml:tx_maildebug_domain_model_message.subject',
            'config' => [
                'type' => 'input',
                'size' => 30,
                'eval' => 'trim'
            ],
        ],
        'date' => [
            'label' => 'LLL:EXT:maildebug/Resources/Private/Language/locallang.xml:tx_maildebug_domain_model_message.date',
            'config' => [
                'type' => 'input',
                'size' => 10,
                'eval' => 'datetime',
                'checkbox' => 1,
                'default' => time()
            ],
        ],
        'tx_maildebug_from' => [
            'label' => 'LLL:EXT:maildebug/Resources/Private/Language/locallang.xml:tx_maildebug_domain_model_message.tx_maildebug_from',
            'config' => [
                'type' => 'input',
                'size' => 30,
                'eval' => 'trim'
            ],
        ],
        'tx_maildebug_to' => [
            'label' => 'LLL:EXT:maildebug/Resources/Private/Language/locallang.xml:tx_maildebug_domain_model_message.tx_maildebug_to',
            'config' => [
                'type' => 'input',
                'size' => 30,
                'eval' => 'trim'
            ],
        ],
        'cc' => [
            'label' => 'LLL:EXT:maildebug/Resources/Private/Language/locallang.xml:tx_maildebug_domain_model_message.cc',
            'config' => [
                'type' => 'input',
                'size' => 30,
                'eval' => 'trim'
            ],
        ],
        'bcc' => [
            'label' => 'LLL:EXT:maildebug/Resources/Private/Language/locallang.xml:tx_maildebug_domain_model_message.bcc',
            'config' => [
                'type' => 'input',
                'size' => 30,
                'eval' => 'trim'
            ],
        ],
        'content_type' => [
            'label' => 'LLL:EXT:maildebug/Resources/Private/Language/locallang.xml:tx_maildebug_domain_model_message.content_type',
            'config' => [
                'type' => 'input',
                'size' => 30,
                'eval' => 'trim'
            ],
        ],
        'body' => [
            'label' => 'LLL:EXT:maildebug/Resources/Private/Language/locallang.xml:tx_maildebug_domain_model_message.body',
            'config' => [
                'type' => 'input',
                'size' => 30,
                'eval' => 'trim'
            ],
        ],
    ],
];
