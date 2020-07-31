<?php
/**
 * Crawfish - проект, предназначенный для разработки среды, с которой можно
 * легко начать разработку небольшого сайта.
 *
 * @license https://github.com/CyberWeel/crawfish/blob/master/LICENSE MIT License
 */

# session_start();

date_default_timezone_set('Asia/Yekaterinburg');

require_once $_SERVER['DOCUMENT_ROOT'].'/core/showerrors.php';
require_once $_SERVER['DOCUMENT_ROOT'].'/core/constants.php';
require_once CORE.'/functions.php';
