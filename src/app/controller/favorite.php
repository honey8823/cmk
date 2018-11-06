<?php
class FavoriteController extends Common
{
	public function table($param_list = array())
	{
		try
		{
			// ユーザID
			$id  = $this->getLoginId();
			if ($id === false)
			{
				return array('error_redirect' => "session");
			}

			// お気に入りタイプ
			$favorite_type_list = $this->getConfig("favorite_type", "value");

			// 取得（お気に入り）
			$sql  = "SELECT   `favorite`.`type` ";
			$sql .= "        ,`favorite`.`id` ";
			$sql .= "        ,`favorite`.`create_stamp` ";
			$sql .= "FROM     `favorite` ";
			$sql .= "WHERE    `favorite`.`user_id` = ? ";
			$sql .= "ORDER BY `favorite`.`create_stamp` DESC ";
			$arg_list = array($id);
			foreach ($this->query($sql, $arg_list) as $v)
			{
				$favorite_type_list[$v['type']]['favorite_list'][$v['id']] = array(
					'id'           => $v['id'],
					'create_stamp' => $v['create_stamp'],
				);
			}

			// 取得（タイトルなど）
			foreach ($favorite_type_list as $k => $v)
			{
				if (!isset($v['favorite_list']) || count($v['favorite_list']) == 0)
				{
					continue;
				}

				if ($v['key'] == "stage")
				{
					$sql  = "SELECT    `stage`.`id` ";
					$sql .= "         ,`stage`.`name` ";
					$sql .= "         ,'' AS `login_id` ";
					$sql .= "         ,`user`.`name` AS `user_name` ";
					$sql .= "         ,`user`.`login_id` AS `user_login_id` ";
					$sql .= "         ,`user`.`is_delete` AS `user_is_delete` ";
					$sql .= "         ,`stage`.`is_private` ";
					$sql .= "         ,`stage`.`is_delete` ";
					$sql .= "FROM      `stage` ";
					$sql .= "LEFT JOIN `user` ON `stage`.`user_id` = `user`.`id` ";
					$sql .= "WHERE     `stage`.`id` IN (" . implode(",", array_fill(0, count($v['favorite_list']), "?")) . ") ";
					$arg_list = array_column($v['favorite_list'], "id");
				}
				elseif ($v['key'] == "character")
				{
					$sql  = "SELECT    `character`.`id` ";
					$sql .= "         ,`character`.`name` ";
					$sql .= "         ,'' AS `login_id` ";
					$sql .= "         ,`user`.`name` AS `user_name` ";
					$sql .= "         ,`user`.`login_id` AS `user_login_id` ";
					$sql .= "         ,`user`.`is_delete` AS `user_is_delete` ";
					$sql .= "         ,`character`.`is_private` ";
					$sql .= "         ,`character`.`is_delete` ";
					$sql .= "FROM      `character` ";
					$sql .= "LEFT JOIN `user` ON `character`.`user_id` = `user`.`id` ";
					$sql .= "WHERE     `character`.`id` IN (" . implode(",", array_fill(0, count($v['favorite_list']), "?")) . ") ";
					$arg_list = array_column($v['favorite_list'], "id");
				}
				elseif ($v['key'] == "user")
				{
					$sql  = "SELECT    `user`.`id` ";
					$sql .= "         ,`user`.`name` ";
					$sql .= "         ,`user`.`login_id` ";
					$sql .= "         ,'' AS `user_name` ";
					$sql .= "         ,'' AS `user_login_id` ";
					$sql .= "         ,'' AS `user_is_delete` ";
					$sql .= "         ,'' AS `is_private` ";
					$sql .= "         ,`user`.`is_delete` ";
					$sql .= "FROM      `user` ";
					$sql .= "WHERE     `user`.`id` IN (" . implode(",", array_fill(0, count($v['favorite_list']), "?")) . ") ";
					$arg_list = array_column($v['favorite_list'], "id");
				}
				foreach ($this->query($sql, $arg_list) as $v_fav)
				{
					$favorite_type_list[$k]['favorite_list'][$v_fav['id']]['name']           = $v_fav['name'];
					$favorite_type_list[$k]['favorite_list'][$v_fav['id']]['login_id']       = $v_fav['login_id'];
					$favorite_type_list[$k]['favorite_list'][$v_fav['id']]['user_name']      = $v_fav['user_name'];
					$favorite_type_list[$k]['favorite_list'][$v_fav['id']]['user_login_id']  = $v_fav['user_login_id'];
					$favorite_type_list[$k]['favorite_list'][$v_fav['id']]['user_is_delete'] = $v_fav['user_is_delete'];
					$favorite_type_list[$k]['favorite_list'][$v_fav['id']]['is_private']     = $v_fav['is_private'];
					$favorite_type_list[$k]['favorite_list'][$v_fav['id']]['is_delete']      = $v_fav['is_delete'];
				}
			}

			// 戻り値
			return array('favorite_type_list' => $favorite_type_list);
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
			// ユーザID
			$user_id = $this->getLoginId();
			if ($user_id === false)
			{
				return array('error_redirect' => "session");
			}

			// 引数
			$type_key = trim($param_list['type_key']);
			$id       = trim($param_list['id']);

			// お気に入りタイプ
			$favorite_type_list = $this->getConfig("favorite_type", "key");

			// 登録
			if (isset($favorite_type_list[$type_key]['value']) && preg_match("/^[0-9]+$/", $id))
			{
				$arg_list = array();
				$sql  = "INSERT INTO `favorite`(`user_id`, `type`, `id`) ";
				$sql .= "VALUES                (?        , ?     , ?   ) ";
				$sql .= "ON DUPLICATE KEY UPDATE `id` = `id` "; // 重複する場合何もしない
				$arg_list[] = $user_id;
				$arg_list[] = $favorite_type_list[$type_key]['value'];
				$arg_list[] = $id;
				$this->query($sql, $arg_list);

			}

			// 戻り値
			$return_list = array($arg_list);
			return $return_list;
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
			$user_id = $this->getLoginId();
			if ($user_id === false)
			{
				return array('error_redirect' => "session");
			}

			// 引数
			$type_key = trim($param_list['type_key']);
			$id       = trim($param_list['id']);

			// お気に入りタイプ
			$favorite_type_list = $this->getConfig("favorite_type", "key");

			// 登録
			if (isset($favorite_type_list[$type_key]['value']) && preg_match("/^[0-9]+$/", $id))
			{
				$arg_list = array();
				$sql  = "DELETE FROM `favorite` ";
				$sql .= "WHERE       `user_id` = ? ";
				$sql .= "AND         `type`    = ? ";
				$sql .= "AND         `id`      = ? ";
				$arg_list[] = $user_id;
				$arg_list[] = $favorite_type_list[$type_key]['value'];
				$arg_list[] = $id;
				$this->query($sql, $arg_list);
			}

			// 戻り値
			$return_list = array();
			return $return_list;
		}
		catch (Exception $e)
		{
			$this->exception($e);
		}
	}
}
