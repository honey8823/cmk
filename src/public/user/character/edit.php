<?php
// 必ず指定 //////////////////////////
require_once("../../../app/initialize.php");
//////////////////////////////////////

// ----------------------------------
// テンプレートに表示するデータの取得
// その他必要な処理
// ----------------------------------
getUserSession(true);
$smarty_param = array();

// コントローラ読み込み
$sc = new StageController();
$cc = new CharacterController();
$ec = new EpisodeController();

// ファイルがアップロードされている場合は更新を行う
$image_info = $cc->getImageInfo($_FILES, $_POST, true, 200);
if (is_array($image_info))
{
	// 正常にアップロードされている
	$image_info['id'] = $_POST['character_id'];
	$r = $cc->setImage($image_info);
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
elseif ($image_info !== null)
{
	// アップロードに失敗している
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

// --------------------
// テンプレート読み込み
// --------------------
display("user/character/edit", $smarty_param);
