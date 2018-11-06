<?php
// 必ず指定 //////////////////////////
require_once("../../app/initialize.php");
//////////////////////////////////////

// --------------
// テンプレート名
// --------------
$template_name = "user/favorite";

// --------------------
// コントローラ読み込み
// --------------------

$uc = new UserController();
$uc->init();

$fc = new FavoriteController();
$fc->init();

// ----------------------------------
// テンプレートに表示するデータの取得
// その他必要な処理
// ----------------------------------
$smarty_param = array();

// 未ログインの場合はエラー
$user_id = $uc->getLoginId();
if ($user_id === false)
{
	header("Location: /err/session.php");
	exit();
}

// お気に入り
$smarty_param['favorite_type_list'] = $fc->table()['favorite_type_list'];

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
