<?php
// config
$app_path = dirname(__FILE__);
require_once($app_path . "/../../../config/server.ini.php");
require_once($app_path . "/../../../config/application.ini.php");

// コントローラ名とアクション名を得る
$classname  = isset($_GET['c']) ? strtolower($_GET['c']) : null;
$actionname = isset($_GET['a']) ? $_GET['a'] : null;
$controller = ucfirst($classname) . "Controller";

// controller
require_once(PATH_CONTROLLER . "common.php");
if (!is_file(PATH_CONTROLLER . $classname . ".php"))
{
	// 存在しないファイルの場合はエラー出力して終了
	echo "API \"" . $classname . " / " . $actionname . "\" Not Found";
	exit();
}
require_once(PATH_CONTROLLER . $classname . ".php");
if (!class_exists($controller))
{
	// 存在しないコントローラの場合はエラー出力して終了
	echo "API \"" . $classname . " / " . $actionname . "\" Not Found";
	exit();
}

// action
$c = new $controller;
if (!is_callable(array($c, $actionname)))
{
	// 存在しないアクションの場合はエラー出力して終了
	echo "API \"" . $classname . " / " . $actionname . "\" Not Found";
	exit();
}

// params
$params = isset($_POST['params']) ? $_POST['params'] : array();

// session(user_id)
if (!isset($params['login_user_id']))
{
	@session_start();
	header('Expires:-1');
	header('Cache-Control:');
	header('Pragma:');
	$params['login_user_id'] = isset($_SESSION['user']['id']) ? $_SESSION['user']['id'] : null;
}

// 実行し、結果をjson化して表示
echo json_encode($c->$actionname($params));
exit();