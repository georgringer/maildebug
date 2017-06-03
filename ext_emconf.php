<?php

$EM_CONF[$_EXTKEY] = [
    'title'            => 'maildebug',
    'description'      => 'debug mails',
    'category'         => 'backend',
    'author'           => 'Georg Ringer',
    'author_email'     => '',
    'author_company'   => 'ringer.it',
    'state'            => 'stable',
    'uploadfolder'     => false,
    'createDirs'       => '',
    'clearCacheOnLoad' => true,
    'version'          => '2.0-dev',
    'constraints'      => [
            'depends' => [
                    'typo3' => '7.6.0-9.0.99',
                ],
        ],
];
