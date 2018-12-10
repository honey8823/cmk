<?php

define("PATH_ROOT"      , realpath(dirname(__FILE__) . "/../")   . "/");
define("PATH_CONTROLLER", realpath(PATH_ROOT . "/app/controller") . "/");
define("PATH_PUBLIC"    , realpath(PATH_ROOT . "/public")         . "/");
define("PATH_TEMPLATE"  , realpath(PATH_ROOT . "/app/smarty")     . "/");
define("PATH_LIBS"      , realpath(PATH_ROOT . "/app/libs")       . "/");
define("PATH_LOGS"      , realpath(PATH_ROOT . "/app/logs")       . "/");
define("PATH_IMAGES"    , realpath(PATH_ROOT . "/public/img")     . "/");

define("SITE_NAME_FULL" , "うちのこタイムライン");
define("SITE_NAME_SHORT", "UTL");

define("DOMAIN", $_SERVER['SERVER_NAME']);

const config = array(

	// タグカテゴリ
	'tag_category' => array(
		array('value' => 1, 'key' => "series"  , 'name' => "シリーズ"),
		array('value' => 2, 'key' => "caution" , 'name' => "閲覧注意喚起"),
	),

	// エピソード区分
	'episode_type' => array(
		array('value' => 1, 'key' => "common"   , 'name' => "通常エピソード"),
		array('value' => 2, 'key' => "label"    , 'name' => "ラベル"),
		array('value' => 3, 'key' => "override" , 'name' => "オーバーライド"),
	),

	// お気に入りタイプ
	'favorite_type' => array(
		array('value' => 1, 'key' => "user"      , 'name' => "ユーザー"),
		array('value' => 2, 'key' => "stage"     , 'name' => "ステージ"),
		array('value' => 3, 'key' => "character" , 'name' => "キャラクター"),
	),

	// ツールチップ
	'tooltip' => array(
		'stage_remarks'     => "このステージの簡単な説明です。<br>具体的なストーリーはタイムライン機能での追加をお勧めします。",
		'character_name'    => "一覧などで表示します。<br>普段の呼び名などをお勧めします。",
		'is_private'        => "チェックが入っていると他のユーザーに見えません。<br>編集後にチェックを外すことをお勧めします。",
		'episode_url'       => "外部サイトへのリンクを張りたい場合にご利用ください。<br>pixivなどに投稿した作品や、twitterに散らばった内容をまとめることができます。",
		'episode_free_text' => "フリーエリアです。（HTMLタグ不可）<br>SSやちょっとした会話ネタ、URL先についての補足など。",
		'episode_is_r18'    => "内容がアダルトコンテンツになる場合はチェックを入れてください。<br>ご協力お願いいたします。",
		'episode_character' => "選択すると、そのキャラクターの<br>タイムラインにも表示されるようになります。",
	),

	// 相関図タイプ
	'relation_type' => array(
		array('value' => 1, 'key' => "none" , 'name' => "指定なし"),
		array('value' => 2, 'key' => "like" , 'name' => "好感"),
		array('value' => 3, 'key' => "hate" , 'name' => "反感"),
		array('value' => 4, 'key' => "love" , 'name' => "恋愛"),
	),

	// 詳細プロフィール項目
	// 1**：生まれについて
	// 2**：名前、呼び方、所属、肩書きなど
	// 3**：外見や身体的特徴など
	// 4**：衣食住、好み、習慣、信条
	// 9**：メタ的な情報
	'character_profile_q' => array(
		array('value' =>  101, 'title' => "本名・フルネーム"),
		array('value' =>  102, 'title' => "性別"),
		array('value' =>  103, 'title' => "誕生日"),
		array('value' =>  104, 'title' => "年齢"),
		array('value' =>  105, 'title' => "出身地"),
		array('value' =>  106, 'title' => "種族"),
		array('value' =>  107, 'title' => "血液型"),
		// 108～199

		array('value' =>  301, 'title' => "外見"),
		array('value' =>  302, 'title' => "体格"),
		array('value' =>  303, 'title' => "髪"),
		array('value' =>  304, 'title' => "目"),
		array('value' =>  305, 'title' => "肌"),
		array('value' =>  306, 'title' => "声"),
		array('value' =>  307, 'title' => "利き手"),
		array('value' =>  308, 'title' => "体質"),
		array('value' =>  309, 'title' => "病気"),
		array('value' =>  310, 'title' => "怪我"),
		array('value' =>  311, 'title' => "運動神経"),
		array('value' =>  312, 'title' => "体力"),
		// 313～399

		array('value' =>  201, 'title' => "通称・ニックネーム"),
		array('value' =>  202, 'title' => "称号・二つ名"),
		array('value' =>  203, 'title' => "自称・偽名"),
		array('value' =>  204, 'title' => "一人称"),
		array('value' =>  205, 'title' => "二人称"),
		array('value' =>  206, 'title' => "三人称"),
		array('value' =>  207, 'title' => "他人の呼び方"),
		// 208～250

		array('value' =>  251, 'title' => "職業"),
		array('value' =>  252, 'title' => "所属組織"),
		array('value' =>  253, 'title' => "階級・地位・肩書き"),
		array('value' =>  254, 'title' => "経歴"),
		// 255～299

		array('value' =>  400, 'title' => "性格"),
		array('value' =>  401, 'title' => "趣味"),
		array('value' =>  402, 'title' => "特技"),
		array('value' =>  403, 'title' => "服装"),
		array('value' =>  404, 'title' => "食事"),
		array('value' =>  405, 'title' => "料理"),
		array('value' =>  406, 'title' => "好きな食べ物"),
		array('value' =>  407, 'title' => "嫌いな食べ物"),
		array('value' =>  408, 'title' => "寝つき・寝起き"),
		array('value' =>  409, 'title' => "飲酒"),
		array('value' =>  410, 'title' => "煙草"),
		array('value' =>  415, 'title' => "自己評価"),
		array('value' =>  416, 'title' => "他人との接し方"),
		array('value' =>  411, 'title' => "人あたりのよさ"),
		array('value' =>  412, 'title' => "苦手なもの"),
		array('value' =>  413, 'title' => "トラウマ"),
		array('value' =>  414, 'title' => "悩み"),
		array('value' =>  415, 'title' => "頭の良さ"),
		// 416～430

		array('value' =>  431, 'title' => "戦い方"),
		array('value' =>  432, 'title' => "武器"),
		// 433～450

		array('value' =>  451, 'title' => "目的・目標"),
		array('value' =>  452, 'title' => "戦う理由"),
		array('value' =>  453, 'title' => "座右の銘"),
		// 454～499

		array('value' =>  901, 'title' => "[メタ]外見"),
		array('value' =>  902, 'title' => "[メタ]クラス・職業"),
		array('value' =>  903, 'title' => "[メタ]CV・脳内CV"),
		// 904～910

		array('value' =>  911, 'title' => "[メタ]スキル構成"),
		array('value' =>  912, 'title' => "[メタ]属性"),
		array('value' =>  913, 'title' => "[メタ]パラメータ"),
		array('value' =>  914, 'title' => "[メタ]武器"),
		// 915～950

		array('value' =>  951, 'title' => "[メタ]名前の由来"),
		array('value' =>  952, 'title' => "[メタ]イメージソング"),
		// 953～
	),
);
