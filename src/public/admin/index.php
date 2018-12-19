<?php
// 必ず指定 //////////////////////////
require_once("../../app/initialize.php");
//////////////////////////////////////

// --------------
// テンプレート名
// --------------
$template_name = "admin/index";

// --------------------
// コントローラ読み込み
// --------------------

$uc = new UserController();
$uc->init();

$ac = new AdminController();
$ac->init();

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

// 管理者でない場合はトップページへリダイレクト
if ($uc->isAdmin() != 1)
{
	header("Location: /");
	exit();
}

// 匿名フォーム
$smarty_param['contact_list'] = $ac->tableContact()['contact_list'];

// ユーザー
$smarty_param['user_list'] = $ac->tableUser()['user_list'];

// ステージ
$smarty_param['stage_list'] = $ac->tableStage()['stage_list'];

// キャラクター
$smarty_param['character_list'] = $ac->tableCharacter()['character_list'];

// // ユーザ
// $smarty_param['user'] = $uc->get()['user'];

// // ジャンル一覧
// $smarty_param['genre_list'] = $tc->tableGenre()['genre_list'];

// 必ず指定 //////////////////////////////
// Smartyデバッグ用
// $smarty->debugging = true;

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
