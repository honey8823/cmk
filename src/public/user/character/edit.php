<?php
// 必ず指定 //////////////////////////
require_once("../../../app/initialize.php");
//////////////////////////////////////

// --------------
// テンプレート名
// --------------
$template_name = "user/character/edit";

// --------------------
// コントローラ読み込み
// --------------------

$uc = new UserController();
$uc->init();

$sc = new StageController();
$sc->init();

$cc = new CharacterController();
$cc->init();

$ec = new EpisodeController();
$ec->init();

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
		$r = $uc->loginAuto(array('token' => $_COOKIE['token']));
	}
	if (isset($r['id']))
	{
		$user_id = $r['id'];
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
		'id'   => $_POST['character_id'],
		'tmp_file_name' => $_FILES['image']['tmp_name'],
		'tmp_file_type' => $_FILES['image']['type'],
		'x'    => isset($_POST['image_x']) ? $_POST['image_x'] : 0,
		'y'    => isset($_POST['image_y']) ? $_POST['image_y'] : 0,
		'size' => isset($_POST['image_w']) ? $_POST['image_w'] : 200,
	);
	$r = $cc->setImage($param_list);
	if (isset($r['error_message']) && $r['error_message'] != "")
	{
		$smarty_param['error_message'] = $r['error_message'];
	}
	else
	{
		header('Location: /user/character/edit.php?id=' . $_POST['character_id']);
		exit();
	}
}
elseif (isset($_FILES['image']['error']))
{
	$smarty_param['error_message'] = "画像のアップロードに失敗しました。ファイルサイズが大きすぎるかもしれません。";
}

// キャラクター
$id = isset($_GET['id']) ? $_GET['id'] : (isset($_POST['character_id']) ? $_POST['character_id'] : "");
$smarty_param['character'] = $cc->get(array('id' => $id))['character'];

// キャラクターが存在しない場合は一覧にリダイレクト
if (!isset($smarty_param['character']['id']))
{
	header("Location: /user/character/");
	exit();
}

// ステージ一覧
$smarty_param['stage_list'] = $sc->table()['stage_list'];

// キャラクタータイムライン
$smarty_param['timeline'] = $ec->timelineCharacter(array('character_id' => $id))['stage_list'];

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
