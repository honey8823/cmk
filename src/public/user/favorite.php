<?php
// 必ず指定 //////////////////////////
require_once("../../app/initialize.php");
//////////////////////////////////////

// ----------------------------------
// テンプレートに表示するデータの取得
// その他必要な処理
// ----------------------------------
getUserSession(true);
$smarty_param = array();

// コントローラ読み込み
$fc = new FavoriteController();

// お気に入り
$smarty_param['favorite_type_list'] = $fc->table()['favorite_type_list'];

// --------------------
// テンプレート読み込み
// --------------------
display("user/favorite", $smarty_param);