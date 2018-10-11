<?php
// 必ず指定 //////////////////////////
require_once("../../app/initialize.php");
//////////////////////////////////////

// --------------
// テンプレート名
// --------------
$template_name = "user/edit";

// --------------------
// コントローラ読み込み
// --------------------

$uc = new UserController();
$uc->init();

$tc = new TagController();
$tc->init();

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

// シリーズ一覧
$tag_catgory_list = $tc->getConfig("tag_category", "key");
$tag_series_list = $tc->table(array('category_list' => array($tag_catgory_list['series']['value'])));
$smarty_param['series_list'] = $tag_series_list;

// 必ず指定 //////////////////////////////
// Smartyデバッグ用
//$smarty->debugging = true;

// Smartyテンプレート呼び出し
foreach ($smarty_param as $key => $val)
{
	$smarty->assign($key, $val);
}
$smarty->display($template_name . ".tpl");
//////////////////////////////////////////
