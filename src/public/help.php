<?php
// 必ず指定 //////////////////////////
require_once("../app/initialize.php");
//////////////////////////////////////

// --------------
// テンプレート名
// --------------
$template_name = "help";

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

// ステージ
$help_list = $hc->table();

$smarty_param['help_list'] = $help_list['help_list'];

// 必ず指定 //////////////////////////////
// Smartyデバッグ用
//$smarty->debugging = true;

// Smartyテンプレート呼び出し
foreach ($smarty_param as $key => $val)
{
	$smarty->assign($key, $val);
}
$smarty->display($template_name . ".tpl");
//////////////////////////////////////////
