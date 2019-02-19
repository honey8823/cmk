<?php
// 必ず指定 //////////////////////////
require_once("../../../app/initialize.php");
//////////////////////////////////////

// ----------------------------------
// テンプレートに表示するデータの取得
// その他必要な処理
// ----------------------------------
$user_session = getUserSession(true);
$smarty_param = array();

// コントローラ読み込み
$tc = new TagController();
$sc = new StageController();

// タグ一覧
$smarty_param['tag_category_list'] = $tc->table(array('user_id' => $user_session['id'], 'is_category_tree' => "1"));

// ステージ一覧
$smarty_param['stage_list'] = $sc->table()['stage_list'];

// --------------------
// テンプレート読み込み
// --------------------
display("user/stage/index", $smarty_param);
