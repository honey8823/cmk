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

// ユーザー
$login_id = isset($_GET['u']) ? $_GET['u'] : "";
$user = $pc->getUser(array('login_id' => $login_id));

if (isset($user['error_redirect']) && $user['error_redirect'] != "")
{
	header("Location: /err/" . $user['error_redirect'] . ".php");
	exit();
}

$smarty_param['user']           = $user['user'];
$smarty_param['genre_list']     = $user['genre_list'];
$smarty_param['stage_list']     = $user['stage_list'];
$smarty_param['character_list'] = $user['character_list'];
$smarty_param['is_login']       = $user['is_login'];
$smarty_param['is_favorite']    = $user['is_favorite'];

// --------------------
// テンプレート読み込み
// --------------------
display("public/user/detail", $smarty_param);