<?php
// 必ず指定 //////////////////////////
require_once("../../../app/initialize.php");
//////////////////////////////////////

// --------------
// テンプレート名
// --------------
$template_name = "user/stage/edit";

// --------------------
// コントローラ読み込み
// --------------------

$uc = new UserController();
$uc->init();

$tc = new TagController();
$tc->init();

$sc = new StageController();
$sc->init();

// ----------------------------------
// テンプレートに表示するデータの取得
// その他必要な処理
// ----------------------------------
$smarty_param = array();

// 未ログインの場合はエラー
if ($uc->getLoginId() === false)
{
	header("Location: /err/session.php");
	exit();
}

// ステージ
$id = $_GET['id'];
$smarty_param['stage'] = $sc->get(array('id' => $id))['stage'];

// シリーズタグ一覧
$tag_catgory_list = $tc->getConfig("tag_category", "key");
$smarty_param['series_list'] = $tc->table(array('category_list' => array($tag_catgory_list['series']['value'])));

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
