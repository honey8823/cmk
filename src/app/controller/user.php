<?php
class UserController extends Common
{
	const IMAGE_SIZE = 200;
	const COOKIE_AVAILABLE = 31536000; // 1年間（60 * 60 * 60 * 24 * 365）

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
			$sql .= "      ,`is_hint_hidden` ";
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

	public function setImage($param_list = array())
	{
		try
		{
			// ユーザID
			$id = $this->getLoginId();
			if ($id === false)
			{
				return array('error_redirect' => "session");
			}

			// 引数
			$tmp_file_name = trim($param_list['tmp_file_name']);
			$x             = trim($param_list['x']);
			$y             = trim($param_list['y']);
			$size          = trim($param_list['size']);

			// 一時ファイルのパス
			$tmp_filename = PATH_IMAGES . date("YmdHis") . "_" . mt_rand() . ".png";

			// 元ファイルを読み込む
			if (exif_imagetype($tmp_file_name) == IMAGETYPE_PNG)
			{
				$base_img = imagecreatefrompng($tmp_file_name);
			}
			elseif (exif_imagetype($tmp_file_name) == IMAGETYPE_JPEG)
			{
				$base_img = imagecreatefromjpeg($tmp_file_name);
			}
			elseif (exif_imagetype($tmp_file_name) == IMAGETYPE_GIF)
			{
				$base_img = imagecreatefromgif($tmp_file_name);
			}
			else
			{
				// 対応していないフォーマット：無視して終了
				return array('error_message' => "対応していないファイルタイプです。JPEG, GIF, PNGのいずれかでお試しください。");
			}

			// 新しいキャンバスを作成する
			$new_img = imagecreatetruecolor(self::IMAGE_SIZE, self::IMAGE_SIZE);

			// 画像を縮小・トリミングする
			imagecopyresampled($new_img, $base_img, 0, 0, $x, $y, self::IMAGE_SIZE, self::IMAGE_SIZE, $size, $size);

			// 画像をpng化する
			imagepng($new_img, $tmp_filename);

			// base64化する
			$img_base64 = base64_encode(file_get_contents($tmp_filename));

			// 画像を削除する
			unlink($tmp_filename);

			// base64化に失敗した場合は無視して終了
			if ($img_base64 === false)
			{
				return array('error_message' => "画像の保存に失敗しました。別のファイルでお試しください。");
			}

			// 更新
			$arg_list = array();
			$sql  = "UPDATE `user` ";
			$sql .= "SET    `image` = ? ";
			$arg_list[] = $img_base64;
			$sql .= "WHERE  `id` = ? ";
			$arg_list[] = $id;
			$this->query($sql, $arg_list);

			// セッションにセット
			$user = $this->getSession(array("user"))['user'];
			$user['image'] = $img_base64;
			$this->setSession("user", $user);

			// 戻り値
			$return_list = array(
				'image' => $img_base64,
			);
			return $return_list;
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
			$login_id       = trim($param_list['login_id']);
			$is_r18         = trim($param_list['is_r18']);
			$is_hint_hidden = trim($param_list['is_hint_hidden']);
			$mail_address   = trim($param_list['mail_address']);

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
			$sql .= " ,`is_hint_hidden` = ? ";
			$arg_list[] = $is_hint_hidden == "1" ? "1" : "0";
			$sql .= " ,`mail_address` = ? ";
			$arg_list[] = $mail_address == "" ? null : $mail_address;
			$sql .= "WHERE ";
			$sql .= "  `id` = ? ";
			$arg_list[] = $id;
			$this->query($sql, $arg_list);

			// セッションにセット
			$user = $this->getSession(array("user"))['user'];
			$user['login_id']       = $login_id;
			$user['is_r18']         = $is_r18;
			$user['is_hint_hidden'] = $is_hint_hidden;
			$user['mail_address']   = $mail_address;
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
			$cookie   = $param_list['cookie'];

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
				// ユーザ情報取得
				$sql  = "SELECT    `user`.`id`, `user`.`name`, `user`.`login_id`, `user`.`image`, `user`.`is_r18`, `user`.`is_hint_hidden`, `user`.`is_admin`, `notice`.`unread_count` ";
				$sql .= "FROM      `user` ";
				$sql .= "LEFT JOIN ( SELECT   `user_id`, COUNT(*) AS `unread_count` ";
				$sql .= "            FROM     `notice` ";
				$sql .= "            WHERE    `read_stamp` IS NULL ";
				$sql .= "            GROUP BY `user_id` ";
				$sql .= "          ) AS `notice` ON `user`.`id` = `notice`.`user_id` ";
				$sql .= "WHERE     `user`.`login_id` = ? AND `user`.`password` = ? AND `user`.`is_delete` <> 1 ";
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

			// 自動ログイン用
			$token = "";
			if ($cookie == "1")
			{
				$token = $this->makeLoginToken();
				setCookie("token", $token, time() + self::COOKIE_AVAILABLE, "/");
			}
			else
			{
				setCookie("token", "", -1, "/");
			}

			// 最終ログイン日時更新
			$sql  = "UPDATE `user` SET `token` = ?, `login_stamp` = NOW() WHERE `id` = ? ";
			$arg_list = array(
				$token == "" ? null : $token,
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
	public function loginAuto($param_list = array())
	{
		try
		{
			$token = $param_list['token'];

			// バリデート
			if (strlen(trim($token)) == 0)
			{
				setCookie("token", "", -1, "/");
				return array('error_redirect' => "session");
			}
			else
			{
				// ユーザ情報取得
				$sql  = "SELECT    `user`.`id`, `user`.`name`, `user`.`login_id`, `user`.`image`, `user`.`is_r18`, `user`.`is_hint_hidden`, `user`.`is_admin`, `notice`.`unread_count` ";
				$sql .= "FROM      `user` ";
				$sql .= "LEFT JOIN ( SELECT   `user_id`, COUNT(*) AS `unread_count` ";
				$sql .= "            FROM     `notice` ";
				$sql .= "            WHERE    `read_stamp` IS NULL ";
				$sql .= "            GROUP BY `user_id` ";
				$sql .= "          ) AS `notice` ON `user`.`id` = `notice`.`user_id` ";
				$sql .= "WHERE     `user`.`token` = ? AND `user`.`is_delete` <> 1 ";
				$arg_list = array(
					$token,
				);
				$user_list = $this->query($sql, $arg_list);
				if (count($user_list) != 1)
				{
					setCookie("token", "", -1, "/");
					return array('error_redirect' => "session");
				}
			}

			// セッションにセット
			$this->setSession("user", $user_list[0]);

			// 自動ログイン用
			$token = $this->makeLoginToken();
			setCookie("token", $token, time() + self::COOKIE_AVAILABLE, "/");

			// 最終ログイン日時更新
			$sql  = "UPDATE `user` SET `token` = ?, `login_stamp` = NOW() WHERE `id` = ? ";
			$arg_list = array(
				$token == "" ? null : $token,
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
	private function makeLoginToken() {
		return bin2hex(openssl_random_pseudo_bytes(16));
	}

	public function logout($param_list = array())
	{
		setCookie("token", "", -1, "/");
		$this->delSession();
	}

	public function isLogin($param_list = array())
	{
		$session_list = $this->getSession(array("user"));
		return isset($session_list['user']['id']) && preg_match("/^[0-9]+$/", $session_list['user']['id']);
	}

	public function setSessionUserIsSidebarClose($param_list = array())
	{
		$user_session = $this->getSession(array("user"));
		if (isset($user_session['user']['is_sidebar_close']) && $user_session['user']['is_sidebar_close'] == 1)
		{
			$user_session['user']['is_sidebar_close'] = 0;
		}
		else
		{
			$user_session['user']['is_sidebar_close'] = 1;
		}
		$this->setSession("user", $user_session['user']);

		return true;
	}

	public function setLoginStamp($param_list = array())
	{
		try
		{
			$id = isset($param_list['id']) ? $param_list['id'] : null;
			if (!preg_match("/^[0-9]+$/", $id))
			{
				return false;
			}

			// 最終ログイン日時更新
			$sql  = "UPDATE `user` SET `login_stamp` = NOW() WHERE `id` = ? ";
			$arg_list = array(
				$id,
			);
			$this->query($sql, $arg_list);

			return true;
		}
		catch (Exception $e)
		{
			$this->exception($e);
			return false;
		}
	}
}
