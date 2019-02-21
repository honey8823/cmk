<?php
// 必ず指定 //////////////////////////
require_once("../../app/initialize.php");
//////////////////////////////////////

// ----------------------------------
// テンプレートに表示するデータの取得
// その他必要な処理
// ----------------------------------
getUserSession(true);
$smarty_param = array();

// コントローラ読み込み
$uc = new UserController();
$tc = new TagController();

// ファイルがアップロードされている場合は更新を行う
$image_info = $uc->getImageInfo($_FILES, $_POST, true, 200);
if (is_array($image_info))
{
	// 正常にアップロードされている
	$r = $uc->setImage($image_info);
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
elseif ($image_info !== null)
{
	// アップロードに失敗している
	$smarty_param['error_message'] = "画像のアップロードに失敗しました。ファイルサイズが大きすぎるかもしれません。";
}

// ユーザ
$smarty_param['user'] = $uc->get()['user'];

// ジャンル一覧
$smarty_param['genre_list'] = $tc->tableGenre()['genre_list'];

// --------------------
// テンプレート読み込み
// --------------------
display("user/account", $smarty_param);
