<?php
// 必ず指定 //////////////////////////
require_once("../app/initialize.php");
getUserSession();
//////////////////////////////////////

// --------------------
// コントローラ読み込み
// --------------------
$ic = new InformationController();
$ic->init();

// ----------------------------------
// テンプレートに表示するデータの取得
// その他必要な処理
// ----------------------------------
$smarty_param = array();

// 最新お知らせ1件
$smarty_param['information_list'] = $ic->table()['information_list'];

// --------------------
// テンプレート読み込み
// --------------------
display("index", $smarty_param);
