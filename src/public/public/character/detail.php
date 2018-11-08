<?php
// 必ず指定 //////////////////////////
require_once("../../../app/initialize.php");
//////////////////////////////////////

// --------------
// テンプレート名
// --------------
$template_name = "public/character/detail";

// --------------------
// コントローラ読み込み
// --------------------

$uc = new UserController();
$uc->init();

// $tc = new TagController();
// $tc->init();

$pc = new PublicController();
$pc->init();

// ----------------------------------
// テンプレートに表示するデータの取得
// その他必要な処理
// ----------------------------------
$smarty_param = array();

// キャラクター
$id   = isset($_GET['id'])   ? $_GET['id'] : "";
$user = isset($_GET['user']) ? $_GET['user'] : "";
$character = $pc->getCharacter(array('id' => $id, 'login_id' => $user));

if (isset($character['error_redirect']) && $character['error_redirect'] != "")
{
	header("Location: /err/" . $character['error_redirect'] . ".php");
	exit();
}

$smarty_param['character']   = $character['character'];
$smarty_param['is_login']    = $character['is_login'];
$smarty_param['is_favorite'] = $character['is_favorite'];

// 必ず指定 //////////////////////////////
// Smartyデバッグ用
// $smarty->debugging = true;

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
