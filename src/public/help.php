<?php
// 必ず指定 //////////////////////////
require_once("../app/initialize.php");
getUserSession();
//////////////////////////////////////

// --------------------
// コントローラ読み込み
// --------------------
$hc = new HelpController();
$hc->init();

// ----------------------------------
// テンプレートに表示するデータの取得
// その他必要な処理
// ----------------------------------
$smarty_param = array();

// ヘルプ
$smarty_param['help_list'] = $hc->table()['help_list'];

// --------------------
// テンプレート読み込み
// --------------------
display("help", $smarty_param);

