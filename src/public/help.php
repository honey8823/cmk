<?php
// 必ず指定 //////////////////////////
require_once("../app/initialize.php");
//////////////////////////////////////

// ----------------------------------
// テンプレートに表示するデータの取得
// その他必要な処理
// ----------------------------------
getUserSession();
$smarty_param = array();

// コントローラ読み込み
$hc = new HelpController();

// ヘルプ
$smarty_param['help_list'] = $hc->table()['help_list'];

// --------------------
// テンプレート読み込み
// --------------------
display("help", $smarty_param);