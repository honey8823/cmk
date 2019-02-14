<?php
// 必ず指定 //////////////////////////
require_once("../../../app/initialize.php");
$user_session = getUserSession();
//////////////////////////////////////

// --------------------
// コントローラ読み込み
// --------------------
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
if (!isset($user_session['id']))
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

// タグ一覧
$smarty_param['tag_category_list'] = $tc->table(array('user_id' => $user_session['id'], 'is_category_tree' => "1"));

// キャラクター一覧
$smarty_param['character_list'] = $cc->table()['character_list'];

// --------------------
// テンプレート読み込み
// --------------------
display("user/stage/edit", $smarty_param);