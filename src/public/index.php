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
// $rc = new RecipeController();
// $rc->init();

// $uc = new UserController();
// $uc->init();
// $uc->login();

// ----------------------------------
// テンプレートに表示するデータの取得
// その他必要な処理
// ----------------------------------
$smarty_param = array();

// // 新着
// $param = array('sort_mode' => "new");
// $smarty_param['new_recipe_list'] = $rc->get($param);

// // 人気
// $param = array('sort_mode' => "popularity");
// $smarty_param['popularity_recipe_list'] = $rc->get($param);


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
