<?php
// 必ず指定 //////////////////////////
require_once("../../app/initialize.php");
//////////////////////////////////////

// --------------------
// コントローラ読み込み
// --------------------
$uc = new UserController();
$uc->init();

// ----------------------------------
// テンプレートに表示するデータの取得
// その他必要な処理
// ----------------------------------
$smarty_param = array();

$uc->logout();

$smarty_param['error_title'] = "ログイン期限が切れています";
$smarty_param['error_message'] = "再度ログインを行ってください。";

// --------------------
// テンプレート読み込み
// --------------------
display("error", $smarty_param);