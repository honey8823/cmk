<?php
// 必ず指定 //////////////////////////
require_once("../../../app/initialize.php");
//////////////////////////////////////

// ----------------------------------
// テンプレートに表示するデータの取得
// その他必要な処理
// ----------------------------------
getUserSession();
$smarty_param = array();

// コントローラ読み込み
$pc = new PublicController();

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

// --------------------
// テンプレート読み込み
// --------------------
display("public/character/override", $smarty_param);
