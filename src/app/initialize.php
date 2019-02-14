<?php
// config
$app_path = dirname(__FILE__);
require_once($app_path . "/../config/server.ini.php");
require_once($app_path . "/../config/application.ini.php");

// controller
require_once(PATH_CONTROLLER . "common.php");
foreach (glob(PATH_CONTROLLER . "*.php", GLOB_BRACE) as $file)
{
	if (is_file($file))
	{
		require_once($file);
	}
}


function getUserSession($is_auto_login = true)
{
	$uc = new UserController();
	$uc->init();
	@session_start();
	header('Expires:-1');
	header('Cache-Control:');
	header('Pragma:');

	$user_session = array();
	if (isset($_SESSION['user']['id']))
	{
		// sessionが存在する場合
		$user_session = $_SESSION['user'];
	}
	elseif (isset($_COOKIE['token']) && $is_auto_login == true)
	{
		// sessionは切れているがcookieにtokenが残っており、かつ自動再ログインを行う場合
		$user_session = $uc->loginAuto(array('token' => $_COOKIE['token']));
	}

	return $user_session;
}

function display($template_name, $smarty_param)
{
	// smarty
	require_once(PATH_SMARTY . "/libs/Smarty.class.php");
	$smarty = new Smarty();
	$smarty->template_dir = PATH_TEMPLATE . "templates/";
	$smarty->compile_dir  = PATH_TEMPLATE . "templates_c/";
	$smarty->config_dir   = PATH_TEMPLATE . "configs/";
	$smarty->cache_dir    = PATH_TEMPLATE . "cache/";

	// Smartyデバッグ用（通常はコメントアウト）
	// $smarty->debugging = true;

	// config
	$smarty_param['config'] = config;

	// adminlte
	$smarty_param['path_adminlte'] = PUBLIC_PATH_ADMINLTE;

	// user session
	$smarty_param['user_session'] = getUserSession();

	// Smartyテンプレート呼び出し
	foreach ($smarty_param as $key => $val)
	{
		$smarty->assign($key, $val);
	}
	$smarty->display($template_name . ".tpl");
}