<?php
// 必ず指定 //////////////////////////
require_once("../../../app/initialize.php");
//////////////////////////////////////

// --------------
// テンプレート名
// --------------
$template_name = "user/character/edit";

// --------------------
// コントローラ読み込み
// --------------------

$uc = new UserController();
$uc->init();

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

// キャラクター
$id = $_GET['id'];
$smarty_param['character'] = $cc->get(array('id' => $id))['character'];

// ステージが存在しない場合は一覧にリダイレクト
if (!isset($smarty_param['character']['id']))
{
	header("Location: /user/character/");
	exit();
}

// ステージ一覧
$smarty_param['stage_list'] = $sc->table()['stage_list'];

// 必ず指定 //////////////////////////////
// Smartyデバッグ用
//$smarty->debugging = true;

// config
$smarty_param['config'] = config;

// Smartyテンプレート呼び出し
foreach ($smarty_param as $key => $val)
{
	$smarty->assign($key, $val);
}
$smarty->display($template_name . ".tpl");
//////////////////////////////////////////