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
		// db
		$this->dsn  = server_config['db']['type'] . ":";
		$this->dsn .= "host="    . server_config['db']['server']  . ";";
		$this->dsn .= "dbname="  . server_config['db']['dbname']  . ";";
		$this->dsn .= "charset=" . server_config['db']['charset'] . ";";
		$this->pdo = new PDO($this->dsn, server_config['db']['user'], server_config['db']['pass']);

		// ログイン中の場合の処理
		$user_id = $this->getLoginId();
		if ($user_id !== false)
		{
			// 通知の未読数を更新
			$this->setSessionNoticeUnread($user_id);
		}
	}

	// ----------------
	// データベース関連
	// ----------------

	public function query($sql, $arg_list = array())
	{
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

	public function getLoginId()
	{
		// ユーザIDをセッションから取得
		$session_list = $this->getSession(array("user"));
		if (isset($session_list['user']['id']) && preg_match("/^[0-9]+$/", $session_list['user']['id']))
		{
			return $session_list['user']['id'];
		}
		else
		{
			return false;
		}
	}

	public function setSessionNoticeUnread($user_id)
	{
		$sql  = "SELECT COUNT(*) AS `unread_count` FROM `notice` WHERE `user_id` = ? AND `read_stamp` IS NULL ";
		$r = $this->query($sql, array($user_id));
		$user_session = $this->getSession(array("user"));
		$user_session['user']['unread_count'] = $r[0]['unread_count'];
		$this->setSession("user", $user_session['user']);
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
