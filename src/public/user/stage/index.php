<?php
// 必ず指定 //////////////////////////
require_once("../../../app/initialize.php");
//////////////////////////////////////

// --------------
// テンプレート名
// --------------
$template_name = "user/stage/index";

// --------------------
// コントローラ読み込み
// --------------------

$uc = new UserController();
$uc->init();

$tc = new TagController();
$tc->init();

$sc = new StageController();
$sc->init();

// ----------------------------------
// テンプレートに表示するデータの取得
// その他必要な処理
// ----------------------------------
$smarty_param = array();

// 未ログインの場合はエラー
$user_id = $uc->getLoginId();
if ($user_id === false)
{
	if (isset($_COOKIE['token']))
	{
		// 自動ログイン
		$user_session = $uc->loginAuto(array('token' => $_COOKIE['token']));
	}
	if (isset($user_session['id']))
	{
		$user_id = $user_session['id'];
	}
	else
	{
		header("Location: /err/session.php");
		exit();
	}
}

// タグ一覧
$smarty_param['tag_category_list'] = $tc->table(array('user_id' => $user_id, 'is_category_tree' => "1"));

// ステージ一覧
$smarty_param['stage_list'] = $sc->table()['stage_list'];

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
