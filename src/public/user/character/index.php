<?php
// 必ず指定 //////////////////////////
require_once("../../../app/initialize.php");
$user_session = getUserSession();
//////////////////////////////////////

// --------------------
// コントローラ読み込み
// --------------------
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
if (!isset($user_session['id']))
{
	header("Location: /err/session.php");
	exit();
}

// ステージ一覧
$smarty_param['stage_list'] = $sc->table()['stage_list'];

// キャラクター一覧
$smarty_param['character_list'] = $cc->table()['character_list'];

// --------------------
// テンプレート読み込み
// --------------------
display("user/character/index", $smarty_param);