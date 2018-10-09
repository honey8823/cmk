<?php
class UserController extends Common
{
	public function get($param_list = array())
	{
		//$sort_mode = $param_list['sort_mode'];

		try
		{
			$return_list = array();

			$sql = "SELECT * FROM `user` WHERE `id` = ? ";
			$arg_list = array(2);
			$return_list = $this->query($sql, $arg_list);

			return $return_list;

		}
		catch (Exception $e)
		{
			// todo::エラー処理
		}
	}

	public function login()
	{
		$login_id = $param_list['login_id'];
		$password = $param_list['password'];

		$test = $this->query("SELECT * FROM `user` WHERE `login_id` = '1' AND `password` = '2'");var_dump($test);


		//var_dump(PATH_LIBS . "twitteroauth/TwitterOAuth.php");
		//TwitterOAuthのインスタンスを生成し、Twitterからリクエストトークンを取得する
// 		$twitter_connect = new TwitterOAuth(TWITTER_API_KEY, TWITTER_API_SECRET);
// 		$request_token = $twitter_connect->oauth('oauth/request_token', array('oauth_callback' => CALLBACK_URL));

// 		//リクエストトークンはcallback.phpでも利用するのでセッションに保存する
// 		$_SESSION['oauth_token'] = $request_token['oauth_token'];
// 		$_SESSION['oauth_token_secret'] = $request_token['oauth_token_secret'];

// 		//Twitterの認証画面へリダイレクト
// 		$url = $twitter_connect->url('oauth/authorize', array('oauth_token' => $request_token['oauth_token']));
// 		header('Location: '.$url);
		exit();
	}

	public function add($param_list = array())
	{
		try
		{
			// 引数
			$login_id   = trim($param_list['login_id']);
			$password   = trim($param_list['password']);
			$password_c = trim($param_list['password_c']);

			// バリデート
			$err_list = array();
			if (mb_strlen($login_id) == 0) {
				$err_list[] = "ログインIDを入力してください。";
			}
			elseif (mb_strlen($login_id) > 256) {
				$err_list[] = "ログインIDは256文字以内で入力してください。";
			}
			if (strlen($password) == 0) {
				$err_list[] = "パスワードを入力してください。";
			}
			elseif (!preg_match("/^[a-zA-Z0-9_.-]*$/", $password)) {
				$err_list[] = "パスワードに使用できるのは、半角の英字、数字、ハイフン、ドット、アンダースコアのみです。";
			}
			elseif (strlen($password) < 4 || strlen($password) > 32) {
				$err_list[] = "パスワードは4～32文字の範囲で入力してください。";
			}
			if ($password != $password_c) {
				$err_list[] = "入力された二つのパスワードが一致しません。";
			}
			if (count($err_list) > 0)
			{
				return array('error_message_list' => $err_list);
			}

			// 登録
			$sql  = "INSERT INTO `user`(`login_id`, `password`) ";
			$sql .= "VALUES            (?         , ?         ) ";
			$arg_list[] = $login_id;
			$arg_list[] = $password;
			$this->query($sql, $arg_list);


			$return_list = array($login_id, $password, $password_c);

			return $return_list;

		}
		catch (Exception $e)
		{
			// todo::エラー処理
		}


	}
}
