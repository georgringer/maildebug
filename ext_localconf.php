<?php

if (!defined('TYPO3_MODE')) {
    die('Access denied.');
}

$defaultSetting = $GLOBALS['TYPO3_CONF_VARS']['MAIL']['transport'];
$GLOBALS['TYPO3_CONF_VARS']['MAIL']['transport'] = \GeorgRinger\Maildebug\Transport\DatabaseTransport::class;
$GLOBALS['TYPO3_CONF_VARS']['MAIL']['defaultTransport'] = $defaultSetting;
