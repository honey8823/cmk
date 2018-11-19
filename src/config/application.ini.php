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
		'episode_character_override' => "一人だけ選択できます。",
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

		array('value' =>  301, 'title' => "外見"),
		array('value' =>  302, 'title' => "体格"),
		array('value' =>  303, 'title' => "髪"),
		array('value' =>  304, 'title' => "目"),
		array('value' =>  305, 'title' => "肌"),
		array('value' =>  306, 'title' => "声"),
		array('value' =>  307, 'title' => "利き手"),
		array('value' =>  308, 'title' => "体質"),

		array('value' =>  201, 'title' => "通称・ニックネーム"),
		array('value' =>  202, 'title' => "称号・二つ名"),
		array('value' =>  203, 'title' => "自称・偽名"),
		array('value' =>  204, 'title' => "一人称"),
		array('value' =>  205, 'title' => "二人称"),
		array('value' =>  206, 'title' => "三人称"),
		array('value' =>  207, 'title' => "他人の呼び方"),

		array('value' =>  251, 'title' => "職業"),
		array('value' =>  252, 'title' => "所属組織"),
		array('value' =>  253, 'title' => "階級・地位・肩書き"),
		array('value' =>  254, 'title' => "経歴"),

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
		array('value' =>  411, 'title' => "人あたりのよさ"),
		array('value' =>  412, 'title' => "苦手なもの"),

		array('value' =>  431, 'title' => "戦い方"),
		array('value' =>  432, 'title' => "武器"),

		array('value' =>  451, 'title' => "目的・目標"),
		array('value' =>  452, 'title' => "戦う理由"),

		array('value' =>  901, 'title' => "[メタ]外見"),
		array('value' =>  902, 'title' => "[メタ]クラス・職業"),
		array('value' =>  903, 'title' => "[メタ]CV・脳内CV"),

		array('value' =>  911, 'title' => "[メタ]スキル構成"),
		array('value' =>  912, 'title' => "[メタ]属性"),
		array('value' =>  913, 'title' => "[メタ]パラメータ"),
		array('value' =>  914, 'title' => "[メタ]武器"),

		array('value' =>  951, 'title' => "[メタ]名前の由来"),
		array('value' =>  952, 'title' => "[メタ]イメージソング"),
	),
);
