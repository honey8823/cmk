<?php
// 必ず指定 //////////////////////////
require_once("../../app/initialize.php");
$user_session = getUserSession();
//////////////////////////////////////

// --------------------
// コントローラ読み込み
// --------------------
$fc = new FavoriteController();
$fc->init();

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

// お気に入り
$smarty_param['favorite_type_list'] = $fc->table()['favorite_type_list'];

// --------------------
// テンプレート読み込み
// --------------------
display("user/favorite", $smarty_param);