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

// --------------------
// テンプレート読み込み
// --------------------
display("tutorial", $smarty_param);