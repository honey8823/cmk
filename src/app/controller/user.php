<?php
class UserController extends Common
{
	public function get($param_list = array())
	{
		try
		{
			// ユーザID
			$id  = $this->getLoginId();
			if ($id === false)
			{
				return array('error_redirect' => "session");
			}

			// 取得（ユーザ）
			$sql  = "SELECT `name` ";
			$sql .= "      ,`login_id` ";
			$sql .= "      ,`twitter_id` ";
			$sql .= "      ,`pixiv_id` ";
			$sql .= "      ,`remarks` ";
			$sql .= "      ,`mail_address` ";
			$sql .= "      ,`is_r18` ";
			$sql .= "FROM   `user` ";
			$sql .= "WHERE  `id` = ? ";
			$sql .= "AND    `is_delete` <> 1 ";
			$arg_list = array($id);
			$user_list = $this->query($sql, $arg_list);
			if (count($user_list) != 1)
			{
				return array('error_redirect' => "session");
			}

			// 取得（ジャンル）
			$sql  = "SELECT `genre_id` ";
			$sql .= "FROM   `user_genre` ";
			$sql .= "WHERE  `user_id` = ? ";
			$arg_list = array($id);
			$user_list[0]['genre_list'] = $this->query($sql, $arg_list);

			// 戻り値
			return array('user' => $user_list[0]);
		}
		catch (Exception $e)
		{
			$this->exception($e);
		}
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
			if (strlen($login_id) == 0)
			{
				$err_list[] = "ご希望のログインIDを入力してください。";
			}
			elseif (!preg_match("/^[a-zA-Z0-9_.-]*$/", $login_id))
			{
				$err_list[] = "ログインIDに使用できるのは、半角の英字、数字、ハイフン、ドット、アンダースコアのみです。";
			}
			elseif (strlen($login_id) < 4 || strlen($login_id) > 32)
			{
				$err_list[] = "ログインIDは4～32文字の範囲で入力してください。";
			}
			else
			{
				// 既に存在するIDでないかチェック
				$sql = "SELECT `id` FROM `user` WHERE `login_id` = ? ";
				$arg_list = array($login_id);
				$user_list = $this->query($sql, $arg_list);
				if (count($user_list) > 0)
				{
					$err_list[] = "既に使われているログインIDです。";
				}
			}
			if (strlen($password) == 0)
			{
				$err_list[] = "パスワードを入力してください。";
			}
			elseif (!preg_match("/^[a-zA-Z0-9_.-]*$/", $password))
			{
				$err_list[] = "パスワードに使用できるのは、半角の英字、数字、ハイフン、ドット、アンダースコアのみです。";
			}
			elseif (strlen($password) < 4 || strlen($password) > 32)
			{
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
			$arg_list = array();
			$sql  = "INSERT INTO `user`(`login_id`, `password`) ";
			$sql .= "VALUES            (?         , ?         ) ";
			$arg_list[] = $login_id;
			$arg_list[] = $password;
			$this->query($sql, $arg_list);

			// 戻り値
			$return_list = array(
				'login_id' => $login_id,
			);
			return $return_list;
		}
		catch (Exception $e)
		{
			$this->exception($e);
		}


	}

	public function setProfile($param_list = array())
	{
		try
		{
			// 引数
			$name         = trim($param_list['name']);
			$twitter_id   = trim($param_list['twitter_id']);
			$pixiv_id     = trim($param_list['pixiv_id']);
			$remarks      = trim($param_list['remarks']);
			$genre_list   = isset($param_list['genre_list']) && is_array($param_list['genre_list']) ? $param_list['genre_list'] : array();

			// ユーザID
			$id = $this->getLoginId();
			if ($id === false)
			{
				return array('error_redirect' => "session");
			}

			// バリデート
			$err_list = array();
			if (mb_strlen($name) > 32)
			{
				$err_list[] = "ユーザー名は32文字以内で入力してください。";
			}
			if (!preg_match("/^[0-9a-zA-Z_]{0,15}$/", $twitter_id))
			{
				$err_list[] = "TwitterIDが不正です。";
			}
			if (!preg_match("/^[0-9a-z_-]{0,32}$/", $pixiv_id))
			{
				$err_list[] = "PixivIDが不正です。";
			}
			if (mb_strlen($remarks) > 10000)
			{
				$err_list[] = "コメントは10,000文字以内で入力してください。";
			}
			if (count($err_list) > 0)
			{
				return array('error_message_list' => $err_list);
			}

			// 更新
			$arg_list = array();
			$sql  = "UPDATE `user` ";
			$sql .= "SET ";
			$sql .= "  `name` = ? ";
			$arg_list[] = $name == "" ? null : $name;
			$sql .= " ,`twitter_id` = ? ";
			$arg_list[] = $twitter_id == "" ? null : $twitter_id;
			$sql .= " ,`pixiv_id` = ? ";
			$arg_list[] = $pixiv_id == "" ? null : $pixiv_id;
			$sql .= " ,`remarks` = ? ";
			$arg_list[] = $remarks == "" ? null : $remarks;
			$sql .= "WHERE ";
			$sql .= "  `id` = ? ";
			$arg_list[] = $id;
			$this->query($sql, $arg_list);

			// ジャンル登録
			// 一度全削除して再登録
			$sql  = "DELETE FROM `user_genre` ";
			$sql .= "WHERE `user_id` = ? ";
			$arg_list = array($id);
			$this->query($sql, $arg_list);
			$genre_list = array_filter($genre_list, function($v){return(preg_match("/^[0-9]+$/", $v));});
			if (count($genre_list) > 0)
			{
				$arg_list = array();
				$sql  = "INSERT INTO `user_genre` (`user_id`, `genre_id`) ";
				$sql .= "VALUES " . implode(",", array_fill(0, count($genre_list), "(?, ?)"));
				foreach ($genre_list as $v)
				{
					$arg_list[] = $id;
					$arg_list[] = $v;
				}
				$this->query($sql, $arg_list);
			}

			// セッションにセット
			$user = $this->getSession(array("user"))['user'];
			$user['name']       = $name;
			$user['twitter_id'] = $twitter_id;
			$user['pixiv_id']   = $pixiv_id;
			$this->setSession("user", $user);

			// 戻り値
			return $user;
		}
		catch (Exception $e)
		{
			$this->exception($e);
		}
	}

	public function setAccount($param_list = array())
	{
		try
		{
			// 引数
			$login_id     = trim($param_list['login_id']);
			$is_r18       = trim($param_list['is_r18']);
			$mail_address = trim($param_list['mail_address']);

			// ユーザID
			$id = $this->getLoginId();
			if ($id === false)
			{
				return array('error_redirect' => "session");
			}

			// バリデート
			$err_list = array();
			if (strlen($login_id) == 0)
			{
				$err_list[] = "ご希望のログインIDを入力してください。";
			}
			elseif (!preg_match("/^[a-zA-Z0-9_.-]*$/", $login_id))
			{
				$err_list[] = "ログインIDに使用できるのは、半角の英字、数字、ハイフン、ドット、アンダースコアのみです。";
			}
			elseif (strlen($login_id) < 4 || strlen($login_id) > 32)
			{
				$err_list[] = "ログインIDは4～32文字の範囲で入力してください。";
			}
			else
			{
				// 既に存在するIDでないかチェック
				$sql = "SELECT `id` FROM `user` WHERE `login_id` = ? AND `id` <> ? ";
				$arg_list = array(
					$login_id,
					$id,
				);
				$user_list = $this->query($sql, $arg_list);
				if (count($user_list) > 0)
				{
					$err_list[] = "既に使われているログインIDです。";
				}
			}
			if ($mail_address != "" && !preg_match("/^.*@.*$/", $mail_address))
			{
				$err_list[] = "メールアドレスが不正です。";
			}
			if (count($err_list) > 0)
			{
				return array('error_message_list' => $err_list);
			}

			// 更新
			$arg_list = array();
			$sql  = "UPDATE `user` ";
			$sql .= "SET ";
			$sql .= "  `login_id` = ? ";
			$arg_list[] = $login_id;
			$sql .= " ,`is_r18` = ? ";
			$arg_list[] = $is_r18 == "1" ? "1" : "0";
			$sql .= " ,`mail_address` = ? ";
			$arg_list[] = $mail_address == "" ? null : $mail_address;
			$sql .= "WHERE ";
			$sql .= "  `id` = ? ";
			$arg_list[] = $id;
			$this->query($sql, $arg_list);

			// セッションにセット
			$user = $this->getSession(array("user"))['user'];
			$user['login_id']     = $login_id;
			$user['is_r18']       = $is_r18;
			$user['mail_address'] = $mail_address;
			$this->setSession("user", $user);

			// 戻り値
			return $user;
		}
		catch (Exception $e)
		{
			$this->exception($e);
		}
	}

	public function setPassword($param_list = array())
	{
		try
		{
			// 引数
			$password_o = trim($param_list['password_o']);
			$password   = trim($param_list['password']);
			$password_c = trim($param_list['password_c']);

			// ユーザID
			$id  = $this->getLoginId();
			if ($id === false)
			{
				return array('error_redirect' => "session");
			}

			// バリデート
			$err_list = array();
			if ($password == "")
			{
				$err_list[] = "現在のパスワードを入力してください。";
			}
			else
			{
				// 現在のパスワードが合っているかチェック
				$sql = "SELECT `id` FROM `user` WHERE `id` = ? AND `password` = ? ";
				$arg_list = array(
					$id,
					$password,
				);
				$user_list = $this->query($sql, $arg_list);
				if (count($user_list) != 1)
				{
					$err_list[] = "現在のパスワードが誤っています。";
				}
			}
			if (!preg_match("/^[a-zA-Z0-9_.-]*$/", $password))
			{
				$err_list[] = "パスワードに使用できるのは、半角の英字、数字、ハイフン、ドット、アンダースコアのみです。";
			}
			elseif (strlen($password) < 4 || strlen($password) > 32)
			{
				$err_list[] = "パスワードは4～32文字の範囲で入力してください。";
			}
			if ($password != $password_c)
			{
				$err_list[] = "入力された二つの新パスワードが一致しません。";
			}
			if (count($err_list) > 0)
			{
				return array('error_message_list' => $err_list);
			}

			// 更新
			$arg_list = array();
			$sql  = "UPDATE `user` ";
			$sql .= "SET ";
			$sql .= "  `password` = ? ";
			$arg_list[] = $password;
			$sql .= "WHERE ";
			$sql .= "  `id` = ? ";
			$arg_list[] = $id;
			$this->query($sql, $arg_list);

			// 戻り値
			return array();
		}
		catch (Exception $e)
		{
			$this->exception($e);
		}
	}

	public function del($param_list = array())
	{
		try
		{
			// ユーザID
			$id = $this->getLoginId();
			if ($id === false)
			{
				return array('error_redirect' => "session");
			}

			// 論理削除
			$sql  = "UPDATE `user` ";
			$sql .= "SET    `is_delete` = 1 ";
			$sql .= "WHERE  `id` = ? ";
			$arg_list = array($id);
			$this->query($sql, $arg_list);

			// セッション削除
			$this->delSession();

			// 戻り値
			return array();
		}
		catch (Exception $e)
		{
			$this->exception($e);
		}
	}

	public function login($param_list = array())
	{
		try
		{
			$login_id = $param_list['login_id'];
			$password = $param_list['password'];

			// バリデート
			$err_list = array();
			if (strlen($login_id) == 0)
			{
				$err_list[] = "ログインIDを入力してください。";
			}
			elseif (strlen($password) == 0)
			{
				$err_list[] = "パスワードを入力してください。";
			}
			else
			{
				// 既に存在するIDでないかチェック＆ユーザ情報取得
				$sql  = "SELECT `id`, `name`, `login_id` ";
				$sql .= "FROM   `user` ";
				$sql .= "WHERE  `login_id` = ? AND `password` = ? AND `is_delete` <> 1 ";
				$arg_list = array(
					$login_id,
					$password,
				);
				$user_list = $this->query($sql, $arg_list);
				if (count($user_list) != 1)
				{
					$err_list[] = "ログインに失敗しました。";
				}
			}
			if (count($err_list) > 0)
			{
				return array('error_message_list' => $err_list);
			}

			// セッションにセット
			$this->setSession("user", $user_list[0]);

			// 最終ログイン日時更新
			$sql  = "UPDATE `user` SET `login_stamp` = NOW() WHERE `id` = ? ";
			$arg_list = array(
				$user_list[0]['id'],
			);
			$this->query($sql, $arg_list);

			return $user_list[0];
		}
		catch (Exception $e)
		{
			$this->exception($e);
		}
	}

	public function logout($param_list = array())
	{
		$this->delSession();
	}

	public function isLogin($param_list = array())
	{
		$session_list = $this->getSession(array("user"));
		return isset($session_list['user']['id']) && preg_match("/^[0-9]+$/", $session_list['user']['id']);
	}
}
