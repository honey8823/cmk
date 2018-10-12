<?php

define("PATH_ROOT"      , realpath(dirname(__FILE__) . "/../")   . "/");
define("PATH_CONTROLLER", realpath(PATH_ROOT . "/app/controller") . "/");
define("PATH_PUBLIC"    , realpath(PATH_ROOT . "/public")         . "/");
define("PATH_TEMPLATE"  , realpath(PATH_ROOT . "/app/smarty")     . "/");
define("PATH_LIBS"      , realpath(PATH_ROOT . "/app/libs")       . "/");

define("SITE_NAME_FULL" , "うちのこまとめ");
define("SITE_NAME_SHORT", "うま");

define("DOMAIN", $_SERVER['SERVER_NAME']);

const config = array(

	// database
	'db' => array(
		"dbname"  => "drg_dev",
		"server"  => "localhost",
		"user"    => "app",
		"pass"    => "kakukorokorokoro",
		"charset" => "utf8mb4",
		"type"    => "mysql",
	),

	// タグカテゴリ
	'tag_category' => array(
		array('value' => 1, 'key' => "series", 'name' => "シリーズ"),
		array('value' => 2, 'key' => "test"  , 'name' => "テストカテゴリ"),
	),

	// ツールチップ
	'tooltip' => array(
		'stage'          => "ステージとは、一連の設定・ストーリーをまとめた単位です。<br>お好みの分け方でご使用ください。<br>例）<br>「正史とパラレルワールド」<br>「ハッピーエンド版とバッドエンド版」<br>「2020と2021」など",
		'character_name' => "一覧などで表示します。<br>普段の呼び名などをお勧めします。",
		'is_private'     => "チェックが入っていると他のユーザーに見えません。<br>編集後にチェックを外すことをお勧めします。",
		'stage_remarks'  => "このステージの簡単な説明です。<br>具体的なストーリーはタイムライン機能での追加をお勧めします。"
	),
);