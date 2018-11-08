<?php
// 必ず指定 //////////////////////////
require_once("../../../app/initialize.php");
//////////////////////////////////////

// --------------
// テンプレート名
// --------------
$template_name = "public/stage/detail";

// --------------------
// コントローラ読み込み
// --------------------

$uc = new UserController();
$uc->init();

$tc = new TagController();
$tc->init();

$pc = new PublicController();
$pc->init();

// ----------------------------------
// テンプレートに表示するデータの取得
// その他必要な処理
// ----------------------------------
$smarty_param = array();

// ステージ
$id   = isset($_GET['id'])   ? $_GET['id'] : "";
$user = isset($_GET['user']) ? $_GET['user'] : "";
$stage = $pc->getStage(array('id' => $id, 'login_id' => $user));

if (isset($stage['error_redirect']) && $stage['error_redirect'] != "")
{
	header("Location: /err/" . $stage['error_redirect'] . ".php");
	exit();
}

$smarty_param['stage']       = $stage['stage'];
$smarty_param['is_login']    = $stage['is_login'];
$smarty_param['is_favorite'] = $stage['is_favorite'];

// シリーズタグ一覧
$tag_catgory_list = $tc->getConfig("tag_category", "key");
$smarty_param['series_list'] = $tc->table(array('category_list' => array($tag_catgory_list['series']['value'])));

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
