<?php
// 必ず指定 //////////////////////////
require_once("../../app/initialize.php");
//////////////////////////////////////

// --------------
// テンプレート名
// --------------
$template_name = "error";

// --------------------
// コントローラ読み込み
// --------------------

// ----------------------------------
// テンプレートに表示するデータの取得
// その他必要な処理
// ----------------------------------
$smarty_param = array();

$smarty_param['error_title'] = "お探しのページは見つかりませんでした";
$smarty_param['error_message'] = "お手数ですが、初めからやり直してください。";

// 必ず指定 //////////////////////////////
// Smartyデバッグ用
//$smarty->debugging = true;

// config
$smarty_param['config'] = config;

// ユーザーセッション情報
$smarty_param['user_session'] = $user_session;

// Smartyテンプレート呼び出し
foreach ($smarty_param as $key => $val)
{
	$smarty->assign($key, $val);
}
$smarty->display($template_name . ".tpl");
//////////////////////////////////////////
