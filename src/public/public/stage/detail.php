<?php
// 必ず指定 //////////////////////////
require_once("../../../app/initialize.php");
getUserSession();
//////////////////////////////////////

// --------------------
// コントローラ読み込み
// --------------------
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

// --------------------
// テンプレート読み込み
// --------------------
display("public/stage/detail", $smarty_param);