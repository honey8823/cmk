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

$help_list = callWebAPI(DOMAIN . "/api/v0/?c=help&a=table");
$smarty_param['help_list'] = isset($help_list['help_list']) ? $help_list['help_list'] : array();
// --------------------
// テンプレート読み込み
// --------------------
display("help", $smarty_param);