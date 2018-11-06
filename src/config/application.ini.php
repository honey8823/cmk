<?php

define("PATH_ROOT"      , realpath(dirname(__FILE__) . "/../")   . "/");
define("PATH_CONTROLLER", realpath(PATH_ROOT . "/app/controller") . "/");
define("PATH_PUBLIC"    , realpath(PATH_ROOT . "/public")         . "/");
define("PATH_TEMPLATE"  , realpath(PATH_ROOT . "/app/smarty")     . "/");
define("PATH_LIBS"      , realpath(PATH_ROOT . "/app/libs")       . "/");
define("PATH_LOGS"      , realpath(PATH_ROOT . "/app/logs")       . "/");

define("SITE_NAME_FULL" , "うちのこタイムライン");
define("SITE_NAME_SHORT", "UTL");

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

	// エピソードカテゴリ
	'episode_category' => array(
		array('value' => 1, 'key' => "event"    , 'name' => "できごと"),
		array('value' => 2, 'key' => "relation" , 'name' => "キャラクター同士の関係について"),
		array('value' => 3, 'key' => "profile"  , 'name' => "キャラクタープロフィールの変化"),
	),

	// ツールチップ
	'tooltip' => array(
		/* ユーザー情報系 */
		'mail_address'      => "※メールアドレスをご入力いただいた場合は以下の対応が可能になります。<br>・パスワードを忘れた場合の照会<br>・退会後のデータ復旧",
		/* まとめ系 */
		'stage'             => "ステージとは、一連の設定・ストーリーをまとめた単位です。<br>お好みの分け方でご使用ください。<br>例）<br>「正史とパラレルワールド」<br>「ハッピーエンド版とバッドエンド版」<br>「2020と2021」など",
		'stage_remarks'     => "このステージの簡単な説明です。<br>具体的なストーリーはタイムライン機能での追加をお勧めします。",
		'character_name'    => "一覧などで表示します。<br>普段の呼び名などをお勧めします。",
		'is_private'        => "チェックが入っていると他のユーザーに見えません。<br>編集後にチェックを外すことをお勧めします。",
		'episode_is_label'  => "エピソード群の区切り用にご利用ください。<br>（タイトルのみ設定できます）<br>例）<br>「本編開始前」「○章～○章」のような時期<br>「世界協定」「ルシェ解禁」のような重要イベント",
		'episode_category'  => "通常は「できごと」でOKです。<br>特にイベントを伴わないもの（この時点の人物相関図、など）は<br>該当するカテゴリを選択してください。",
		'episode_url'       => "外部サイトへのリンクを張りたい場合にご利用ください。<br>pixivなどに投稿した作品や、twitterに散らばった内容をまとめることができます。",
		'episode_free_text' => "フリーエリアです。（HTMLタグ不可）<br>SSやちょっとした会話ネタ、URL先についての補足など。",
		'episode_is_r18'    => "内容がアダルトコンテンツになる場合はチェックを入れてください。<br>ご協力お願いいたします。",
		'episode_character' => "選択すると、そのキャラクターの<br>タイムラインにも表示されるようになります。",
	),
);


