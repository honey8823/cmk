<?php
// 必ず指定 //////////////////////////
require_once("../../../app/initialize.php");
//////////////////////////////////////

// --------------
// テンプレート名
// --------------
$template_name = "public/character/override";

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

// キャラクター（オーバーライド情報）
$id      = isset($_GET['id'])   ? $_GET['id'] : "";
$user    = isset($_GET['user']) ? $_GET['user'] : "";
$stage   = isset($_GET['s']) ? $_GET['s'] : "";
$episode = isset($_GET['e']) ? $_GET['e'] : "";
$character = $pc->getCharacterOverride(array('id' => $id, 'login_id' => $user, 'stage' => $stage, 'episode' => $episode));

if (isset($character['error_redirect']) && $character['error_redirect'] != "")
{
	header("Location: /err/" . $character['error_redirect'] . ".php");
	exit();
}

$smarty_param['character']    = $character['character'];
$smarty_param['stage']        = $character['stage'];
$smarty_param['profile_list'] = $character['profile_list'];

// 自動ログイン
if ($uc->getLoginId() === false && isset($_COOKIE['token']))
{
	$r = $uc->loginAuto(array('token' => $_COOKIE['token']));
}

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
