<?php
$root_path = dirname(__FILE__) . "/../";

// maintenance
if (false) // こちらが有効な場合、メンテナンス画面にならない
// if ($_SERVER['REMOTE_ADDR'] != "127.0.0.1") // こちらが有効な場合、指定IP以外はメンテナンス画面になる
// if ($_SERVER['REMOTE_ADDR'] == "127.0.0.1") // こちらが有効な場合、指定IPのみメンテナンス画面になる
{
	echo(file_get_contents($root_path . "public/err/maintenance.html"));
	exit();
}

// config
require_once($root_path . "config/server.ini.php");
require_once($root_path . "config/application.ini.php");

// controller
require_once(PATH_CONTROLLER . "common.php");
foreach (glob(PATH_CONTROLLER . "*.php", GLOB_BRACE) as $file)
{
	if (is_file($file))
	{
		require_once($file);
	}
}

/**
 * getUserSession
 * @param bool is_require_login ログイン状態である必要があるかどうか
 * @param bool is_auto_login セッションが切れているとき、cookieを利用した自動ログインを行うかどうか
 */
function getUserSession($is_require_login = false, $is_auto_login = true)
{
	$uc = new UserController();
	@session_start();
	header('Expires:-1');
	header('Cache-Control:');
	header('Pragma:');

	$user_session = array();
	if (isset($_SESSION['user']['id']))
	{
		// sessionが存在する場合
		$user_session = $_SESSION['user'];
	}
	elseif (isset($_COOKIE['token']) && $is_auto_login == true)
	{
		// sessionは切れているがcookieにtokenが残っており、かつ自動再ログインを行う場合
		$user_session = $uc->loginAuto(array('token' => $_COOKIE['token']));
	}

	if ($is_require_login == true && (!isset($user_session['id']) || !preg_match("/^[0-9]+$/", $user_session['id'])))
	{
		// ログインが必要だがログインできていない場合
		header("Location: /err/session.php");
		exit();
	}

	if (isset($user_session['id']) && preg_match("/^[0-9]+$/", $user_session['id']))
	{
		// ログイン済みの場合、通知の未読数を更新
		$nc = new NoticeController();
		$notice_unread_count = $nc->getUnreadCount($user_session['id']);
		$user_session['unread_count'] = $notice_unread_count;
		$uc->setSession("user", $user_session);
	}

	return $user_session;
}

/**
 * display
 * @param string template_name テンプレート名
 * @param array  smarty_param  テンプレートに渡す値の配列
 */
function display($template_name, $smarty_param)
{
	// smarty
	require_once(PATH_SMARTY . "/libs/Smarty.class.php");
	$smarty = new Smarty();
	$smarty->template_dir = PATH_TEMPLATE . "templates/";
	$smarty->compile_dir  = PATH_TEMPLATE . "templates_c/";
	$smarty->config_dir   = PATH_TEMPLATE . "configs/";
	$smarty->cache_dir    = PATH_TEMPLATE . "cache/";

	// Smartyデバッグ用（通常はコメントアウト）
	// $smarty->debugging = true;

	// config
	$smarty_param['config'] = config;

	// adminlte
	$smarty_param['path_adminlte'] = PUBLIC_PATH_ADMINLTE;

	// user session
	$smarty_param['user_session'] = getUserSession();

	// Smartyテンプレート呼び出し
	foreach ($smarty_param as $key => $val)
	{
		$smarty->assign($key, $val);
	}
	$smarty->display($template_name . ".tpl");

	return true;
}

/**
 * callWebAPI
 * @param string url WEBAPIのURL
 */
function callWebAPI($url)
{
	// cURLセッションを初期化
	$ch = curl_init();

	// オプションを設定
	curl_setopt($ch, CURLOPT_URL, $url); // 取得するURLを指定
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true); // 実行結果を文字列で返す
	curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false); // サーバー証明書の検証を行わない

	// URLの情報を取得
	$response =  curl_exec($ch);

	// セッションを終了
	curl_close($ch);

	// jsonデコードして返す
	return json_decode($response, true);
}