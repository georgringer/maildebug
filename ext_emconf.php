<?php

$EM_CONF[$_EXTKEY] = array(
    'title' => 'maildebug',
    'description' => 'debug mails',
    'category' => 'backend',
    'author' => 'Georg Ringer',
    'author_email' => '',
    'author_company' => 'ringer.it',
    'state' => 'stable',
    'uploadfolder' => FALSE,
    'createDirs' => '',
    'clearCacheOnLoad' => TRUE,
    'version' => '1.0.0',
    'constraints' =>
        array(
            'depends' =>
                array(
                    'typo3' => '7.6.0-9.0.99',
                ),
        ),
);
