<?php
// 必ず指定 //////////////////////////
require_once("../app/initialize.php");
//////////////////////////////////////

// --------------
// テンプレート名
// --------------
$template_name = "index";

// --------------------
// コントローラ読み込み
// --------------------
// $cc = new CharacterController();
// $cc->init();

// ----------------------------------
// テンプレートに表示するデータの取得
// その他必要な処理
// ----------------------------------
$smarty_param = array();

// // 新着
// $param = array('sort_mode' => "new");
// $smarty_param['new_character_list'] = $rc->get($param);

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
