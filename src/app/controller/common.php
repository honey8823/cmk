<?php
class Common
{
    protected $dsn = null;
    protected $pdo = null;

    protected $last_insert_id = null;

    public function init()
    {
        // db
        $this->dsn  = config['db']['type'] . ":";
        $this->dsn .= "host="    . config['db']['server']  . ";";
        $this->dsn .= "dbname="  . config['db']['dbname']  . ";";
        $this->dsn .= "charset=" . config['db']['charset'] . ";";
        $this->pdo = new PDO($this->dsn, config['db']['user'], config['db']['pass']);
    }

    public function query($sql, $arg_list = array())
    {
    	// クエリ実行
    	$sth = $this->pdo->prepare($sql);
    	$sth->execute($arg_list);
    	$ret = $sth->fetchAll();
    	if (!is_array($ret))
    	{
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

    public function exception($e)
    {
        // todo::エラー処理
        // ログに残したりする
        echo '捕捉した例外: ',  $e->getMessage(), "\n";
    }

    public function getSession($key_list = array())
    {
    	@session_start();
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
    	$_SESSION[$key] = $params;
    }

    public function delSession()
    {
    	@session_start();
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
}


