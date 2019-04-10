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

// ステージ一覧
$smarty_param['user_list'] = $pc->tableUser()['user_list'];

// --------------------
// テンプレート読み込み
// --------------------
display("public/user/index", $smarty_param);