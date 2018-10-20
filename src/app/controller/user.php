<?php
class UserController extends Common
{
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
			// todo::エラー処理
		}


	}

	public function set($param_list = array())
	{
		try
		{
			// 引数
			$login_id     = trim($param_list['login_id']);
			$name         = trim($param_list['name']);
			$twitter_id   = trim($param_list['twitter_id']);
			$is_r18       = trim($param_list['is_r18']);
			$mail_address = trim($param_list['mail_address']);
			$password     = trim($param_list['password']);
			$password_c   = trim($param_list['password_c']);

			// ユーザID
			$id  = $this->getLoginId();
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
			if (mb_strlen($name) > 32)
			{
				$err_list[] = "ユーザー名は32文字以内で入力してください。";
			}
			if (!preg_match("/^[0-9a-zA-Z_]{0,15}$/", $twitter_id))
			{
				$err_list[] = "TwitterIDが不正です。";
			}
			if ($mail_address != "" && !preg_match("/^.*@.*$/", $mail_address))
			{
				$err_list[] = "メールアドレスが不正です。";
			}
			if (strlen($password) > 0)
			{
				if (!preg_match("/^[a-zA-Z0-9_.-]*$/", $password))
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
			$sql .= " ,`name` = ? ";
			$arg_list[] = $name == "" ? null : $name;
			$sql .= " ,`twitter_id` = ? ";
			$arg_list[] = $twitter_id == "" ? null : $twitter_id;
			$sql .= " ,`is_r18` = ? ";
			$arg_list[] = $is_r18 == "1" ? "1" : "0";
			$sql .= " ,`mail_address` = ? ";
			$arg_list[] = $mail_address == "" ? null : $mail_address;
			if ($password != "")
			{
				$sql .= " ,`password` = ? ";
				$arg_list[] = $password;
			}
			$sql .= "WHERE ";
			$sql .= "  `id` = ? ";
			$arg_list[] = $id;
			$this->query($sql, $arg_list);

			// セッションにセット
			$user_list = array(
				'id'           => $id,
				'name'         => $name,
				'login_id'     => $login_id,
				'twitter_id'   => $twitter_id,
				'is_r18'       => $is_r18,
				'mail_address' => $mail_address,
			);
			$this->setSession("user", $user_list);

			// 戻り値
			return $user_list;
		}
		catch (Exception $e)
		{
			// todo::エラー処理
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
				$sql  = "SELECT `id`, `name`, `login_id`, `twitter_id`, `mail_address` ";
				$sql .= "FROM   `user` ";
				$sql .= "WHERE  `login_id` = ? AND `password` = ? AND `is_delete` <> 1 ";
				$arg_list = array(
					$login_id,
					$password,
				);
				$user_list = $this->query($sql, $arg_list);
				if (count($user_list) != 1)
				{
					$err_list[] = "ログインに失敗しました。" . count($user_list);
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
			// todo::エラー処理
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
