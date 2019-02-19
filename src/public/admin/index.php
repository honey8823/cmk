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
$ac = new AdminController();

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

// --------------------
// テンプレート読み込み
// --------------------
display("admin/index", $smarty_param);