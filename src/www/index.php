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
$ic = new InformationController();

// 最新お知らせ1件
$smarty_param['information_list'] = $ic->table()['information_list'];

// --------------------
// テンプレート読み込み
// --------------------
display("index", $smarty_param);