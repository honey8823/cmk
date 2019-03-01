<?php
class Common
{
	protected $dsn = null;
	protected $pdo = null;

	protected $last_insert_id = null;

	// ------
	// 初期化
	// ------

	public function init()
	{
	}

	// ----------------
	// データベース関連
	// ----------------

	public function query($sql, $arg_list = array())
	{
		try
		{
			if ($this->dsn == null)
			{
				$this->dsn  = server_config['db']['type'] . ":";
				$this->dsn .= "host="    . server_config['db']['server']  . ";";
				$this->dsn .= "dbname="  . server_config['db']['dbname']  . ";";
				$this->dsn .= "charset=" . server_config['db']['charset'] . ";";
				$this->pdo = new PDO($this->dsn, server_config['db']['user'], server_config['db']['pass']);
			}

			// クエリ実行
			$sth = $this->pdo->prepare($sql);
			$sth->execute($arg_list);
			if ($sth->errorInfo()[2] != "")
			{
				// エラーがあった場合はthrow
				throw new Exception(var_export($sth->errorInfo(), true));
			}
			$ret = $sth->fetchAll();
			if (!is_array($ret))
			{
				// エラーではないが取得できなかった場合はfalseを返す
				return false;
			}

			// 不要データの削除（キーが数字のみのカラム）
			foreach ($ret as $rk => $rv)
			{
				foreach ($rv as $ck => $cv)
				{
					if (preg_match("/^[0-9]+$/", $ck))
					{
						unset ($ret[$rk][$ck]);
					}
				}
			}
			return $ret;
		}
		catch (Exception $e)
		{
			throw $e;
		}
	}

	public function getLastInsertId()
	{
		$res = $this->query("SELECT LAST_INSERT_ID() AS `last_insert_id` ");
		return $res[0]['last_insert_id'];
	}

	// ------
	// config
	// ------

	public function getConfig($name, $key)
	{
		$cfg = config[$name];
		$return_list = array();
		foreach ($cfg as $k => $v)
		{
			$return_list[$v[$key]] = $v;
		}
		return $return_list;
	}

	// ----------
	// エラー処理
	// ----------

	public function exception($e)
	{
		// ログに残す
		$log_text  = "";
		$log_text .= "///////////////////////////////////////////////////\n";
		$log_text .= date("Y-m-d H:i:s") . "\n";
		$log_text .= "-----------------------------\n";
		$log_text .= var_export($e, true);
		$log_text .= "\n\n";
		file_put_contents(PATH_LOGS . date("Ymd") . ".log", $log_text, FILE_APPEND);
	}

	// --------------
	// セッション関連
	// --------------

	public function getSession($key_list = array())
	{
		@session_start();
		header('Expires:-1');
		header('Cache-Control:');
		header('Pragma:');

		if (count($key_list) > 0)
		{
			$return_list = array();
			foreach ($key_list as $v)
			{
				if (isset($_SESSION[$v]))
				{
					$return_list[$v] = $_SESSION[$v];
				}
			}
			return $return_list;
		}
		else
		{
			return isset($_SESSION) ? $_SESSION : array('error_redirect' => "session");
		}
	}

	public function setSession($key, $params = array())
	{
		@session_start();
		header('Expires:-1');
		header('Cache-Control:');
		header('Pragma:');

		$_SESSION[$key] = $params;
	}

	public function delSession()
	{
		@session_start();
		header('Expires:-1');
		header('Cache-Control:');
		header('Pragma:');

		$_SESSION = array();
		session_destroy();
	}

	public function getLoginId($is_update_login_stamp = true)
	{
		// ユーザIDをセッションから取得
		$session_list = $this->getSession(array("user"));
		if (isset($session_list['user']['id']) && preg_match("/^[0-9]+$/", $session_list['user']['id']))
		{
			// ログイン日時更新
			if ($is_update_login_stamp == true)
			{
				$sql  = "UPDATE `user` SET `login_stamp` = NOW() WHERE `id` = ? ";
				$arg_list = array(
					$session_list['user']['id'],
				);
				$this->query($sql, $arg_list);
			}
			return $session_list['user']['id'];
		}
		else
		{
			return false;
		}
	}

	public function isAdmin()
	{
		$session_list = $this->getSession(array("user"));
		return isset($session_list['user']['is_admin']) ? $session_list['user']['is_admin'] : 0;
	}

	// ----------------
	// アップロード関連
	// ----------------

	public function getImageInfo($files, $post, $is_square, $default_h = 200, $default_w = 200)
	{
		if (isset($files['image']['error']) && $files['image']['error'] === UPLOAD_ERR_OK)
		{
			// アップロードできている
			$image_info_list = array();
			$image_info_list['tmp_file_name'] = $files['image']['tmp_name'];
			$image_info_list['x'] = isset($post['image_x']) ? $post['image_x'] : 0;
			$image_info_list['y'] = isset($post['image_y']) ? $post['image_y'] : 0;
			if ($is_square)
			{
				$image_info_list['size'] = isset($post['image_h']) ? $post['image_h'] : $default_h;
			}
			else
			{
				$image_info_list['h'] = isset($post['image_h']) ? $post['image_h'] : $default_h;
				$image_info_list['w'] = isset($post['image_w']) ? $post['image_w'] : $default_w;
			}

			return $image_info_list;
		}
		elseif (isset($files['image']['error']))
		{
			// アップロードに失敗している
			return $files['image']['error'];
		}
		else
		{
			// アップロードされていない
			return null;
		}
	}


	// --------------
	// その他汎用関数
	// --------------

	public function setArrayKey($l, $k)
	{
		$res = array();
		foreach ($l as $v)
		{
			$res[$v[$k]] = $v;
		}
		return $res;
	}

	public function omitUrl($url, $length = 20)
	{
		// 切り取り開始位置：「//」の後から
		$start = strpos($url, "//");
		if ($start === false)
		{
			return false;
		}
		$start += 2; // 「//」の文字数分、スタート位置を加算

		$url = mb_substr($url, $start, $length);
		if (mb_strlen($url) >= $length)
		{
			$url .= "...";
		}

		return $url;
	}
}
