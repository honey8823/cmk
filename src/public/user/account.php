<?php
// 必ず指定 //////////////////////////
require_once("../../app/initialize.php");
//////////////////////////////////////

// --------------
// テンプレート名
// --------------
$template_name = "user/account";

// --------------------
// コントローラ読み込み
// --------------------

$uc = new UserController();
$uc->init();

$tc = new TagController();
$tc->init();

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

// ファイルがアップロードされている場合は更新を行う
if (isset($_FILES['image']['error']) && $_FILES['image']['error'] === UPLOAD_ERR_OK)
{
	$param_list = array(
		'tmp_file_name' => $_FILES['image']['tmp_name'],
		'tmp_file_type' => $_FILES['image']['type'],
		'x'    => isset($_POST['image_x']) ? $_POST['image_x'] : 0,
		'y'    => isset($_POST['image_y']) ? $_POST['image_y'] : 0,
		'size' => isset($_POST['image_w']) ? $_POST['image_w'] : 200,
	);
	$r = $uc->setImage($param_list);
	if (isset($r['error_message']) && $r['error_message'] != "")
	{
		$smarty_param['error_message'] = $r['error_message'];
	}
	else
	{
		header('Location: /user/account.php');
		exit();
	}
}
elseif (isset($_FILES['image']['error']))
{
	$smarty_param['error_message'] = "画像のアップロードに失敗しました。ファイルサイズが大きすぎるかもしれません。";
}

// ユーザ
$smarty_param['user'] = $uc->get()['user'];

// ジャンル一覧
$smarty_param['genre_list'] = $tc->tableGenre()['genre_list'];

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
