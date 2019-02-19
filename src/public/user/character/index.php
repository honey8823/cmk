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

// ステージ一覧
$smarty_param['stage_list'] = $sc->table()['stage_list'];

// キャラクター一覧
$smarty_param['character_list'] = $cc->table()['character_list'];

// --------------------
// テンプレート読み込み
// --------------------
display("user/character/index", $smarty_param);