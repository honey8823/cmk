<?php
require_once("../app/initialize.php");

// コントローラ名とアクション名を得る
$classname  = isset($_GET['c']) ? $_GET['c'] : null;
$actionname = isset($_GET['a']) ? $_GET['a'] : null;
$controller = ucfirst(strtolower($classname)) . "Controller";

// 存在しないコントローラの場合は失敗
if (!class_exists($controller))
{
	return false;
}

// 存在しないアクションの場合は失敗
$c = new $controller;
if (!is_callable(array($c, $actionname)))
{
	return false;
}

// 実行し、結果をjson化して表示
$c->init();
echo json_encode($c->$actionname(isset($_POST['params']) ? $_POST['params'] : null));