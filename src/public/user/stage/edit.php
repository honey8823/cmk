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

$cc = new CharacterController();
$cc->init();

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

// ステージ
$id = isset($_GET['id']) ? $_GET['id'] : "";
$smarty_param['stage'] = $sc->get(array('id' => $id))['stage'];

// ステージが存在しない場合は一覧にリダイレクト
if (!isset($smarty_param['stage']['id']))
{
	header("Location: /user/stage/");
	exit();
}

// シリーズタグ一覧
$tag_catgory_list = $tc->getConfig("tag_category", "key");
$smarty_param['series_list'] = $tc->table(array('category_list' => array($tag_catgory_list['series']['value']), 'user_id' => $user_id));

// キャラクター一覧
$smarty_param['character_list'] = $cc->table()['character_list'];

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
