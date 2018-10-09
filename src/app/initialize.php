<?php
// config
require_once(dirname(__FILE__) . "/../config/application.ini.php");

// libs
require_once(dirname(__FILE__) . '/libs/smarty-3.1.32/libs/Smarty.class.php');

// controller
foreach (glob(PATH_CONTROLLER . '*.php', GLOB_BRACE) as $file)
{
	if (is_file($file))
	{
		require_once($file);
	}
}

// smarty path
$smarty = new Smarty();
$smarty->template_dir = PATH_TEMPLATE . 'templates/';
$smarty->compile_dir  = PATH_TEMPLATE . 'templates_c/';
$smarty->config_dir   = PATH_TEMPLATE . 'configs/';
$smarty->cache_dir    = PATH_TEMPLATE . 'cache/';