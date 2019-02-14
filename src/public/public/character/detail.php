<?php
// 必ず指定 //////////////////////////
require_once("../../../app/initialize.php");
getUserSession();
//////////////////////////////////////

// --------------------
// コントローラ読み込み
// --------------------
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

// --------------------
// テンプレート読み込み
// --------------------
display("public/character/detail", $smarty_param);