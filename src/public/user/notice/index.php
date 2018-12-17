<?php
// 必ず指定 //////////////////////////
require_once("../../../app/initialize.php");
//////////////////////////////////////

// --------------
// テンプレート名
// --------------
$template_name = "user/notice/index";

// --------------------
// コントローラ読み込み
// --------------------

$uc = new UserController();
$uc->init();

// ----------------------------------
// テンプレートに表示するデータの取得
// その他必要な処理
// ----------------------------------
$smarty_param = array();

// 未ログインの場合はエラー
$user_id = $uc->getLoginId();
if ($user_id === false)
{
	if (isset($_COOKIE['token']))
	{
		// 自動ログイン
		$r = $uc->loginAuto(array('token' => $_COOKIE['token']));
	}
	if (isset($r['id']))
	{
		$user_id = $r['id'];
	}
	else
	{
		header("Location: /err/session.php");
		exit();
	}
}

// 必ず指定 //////////////////////////////
// Smartyデバッグ用
//$smarty->debugging = true;

// config
$smarty_param['config'] = config;

// ユーザーセッション情報
$smarty_param['user_session'] = $user_session;

// Smartyテンプレート呼び出し
foreach ($smarty_param as $key => $val)
{
	$smarty->assign($key, $val);
}
$smarty->display($template_name . ".tpl");
//////////////////////////////////////////
