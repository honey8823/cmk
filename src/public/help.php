<?php
// 必ず指定 //////////////////////////
require_once("../app/initialize.php");
//////////////////////////////////////

// --------------
// テンプレート名
// --------------
$template_name = "help";

// --------------------
// コントローラ読み込み
// --------------------

$hc = new HelpController();
$hc->init();

$uc = new UserController();
$uc->init();

// ----------------------------------
// テンプレートに表示するデータの取得
// その他必要な処理
// ----------------------------------
$smarty_param = array();

// ヘルプ
$help_list = $hc->table();
$smarty_param['help_list'] = $help_list['help_list'];

// 自動ログイン
if ($uc->getLoginId() === false && isset($_COOKIE['token']))
{
	$user_session = $uc->loginAuto(array('token' => $_COOKIE['token']));
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
