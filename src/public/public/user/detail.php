<?php
// 必ず指定 //////////////////////////
require_once("../../../app/initialize.php");
//////////////////////////////////////

// --------------
// テンプレート名
// --------------
$template_name = "public/user/detail";

// --------------------
// コントローラ読み込み
// --------------------

$uc = new UserController();
$uc->init();

$pc = new PublicController();
$pc->init();

// ----------------------------------
// テンプレートに表示するデータの取得
// その他必要な処理
// ----------------------------------
$smarty_param = array();

// ユーザー
$login_id = isset($_GET['u']) ? $_GET['u'] : "";
$user = $pc->getUser(array('login_id' => $login_id));

if (isset($user['error_redirect']) && $user['error_redirect'] != "")
{
	header("Location: /err/" . $user['error_redirect'] . ".php");
	exit();
}

$smarty_param['user']           = $user['user'];
$smarty_param['genre_list']     = $user['genre_list'];
$smarty_param['stage_list']     = $user['stage_list'];
$smarty_param['character_list'] = $user['character_list'];
$smarty_param['is_login']       = $user['is_login'];
$smarty_param['is_favorite']    = $user['is_favorite'];

// 必ず指定 //////////////////////////////
// Smartyデバッグ用
// $smarty->debugging = true;

// config
$smarty_param['config'] = config;

// Smartyテンプレート呼び出し
foreach ($smarty_param as $key => $val)
{
	$smarty->assign($key, $val);
}
$smarty->display($template_name . ".tpl");
//////////////////////////////////////////
