<?php
// 必ず指定 //////////////////////////
require_once("../../app/initialize.php");
//////////////////////////////////////

// ----------------------------------
// テンプレートに表示するデータの取得
// その他必要な処理
// ----------------------------------
$smarty_param = array();

$smarty_param['error_title'] = "お探しのページは見つかりませんでした";
$smarty_param['error_message'] = "お手数ですが、初めからやり直してください。";

// --------------------
// テンプレート読み込み
// --------------------
display("error", $smarty_param);