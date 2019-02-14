<?php
// 必ず指定 //////////////////////////
require_once("../../../app/initialize.php");
$user_session = getUserSession();
//////////////////////////////////////

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

// --------------------
// テンプレート読み込み
// --------------------
display("user/notice/index", $smarty_param);