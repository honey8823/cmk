<?php
class StageController extends Common
{
	public function table($param_list = array())
	{
		try
		{
			// ユーザID
			// ログイン状態でない場合はエラー
			$user_id = $this->getLoginId();
			if ($user_id === false)
			{
				return array('error_redirect' => "session");
			}

			$return_list = array();

			// 取得（ステージ）
			$arg_list = array();
			$sql  = "SELECT   `id`, `name`, `sort`, `is_private` ";
			$sql .= "FROM     `stage` ";
			$sql .= "WHERE    `user_id` = ? ";
			$arg_list[] = $user_id;
			$sql .= "AND      `is_delete` <> 1 ";
			$sql .= "ORDER BY `sort` ASC ";
			$stage_list = $this->query($sql, $arg_list);

			// 取得（タグ）・整形
			if (count($stage_list) > 0)
			{
				$stage_list = $this->setArrayKey($stage_list, "id");

				$arg_list = array();
				$sql  = "SELECT    `stage_tag`.`stage_id` ";
				$sql .= "         ,`tag`.`id` ";
				$sql .= "         ,`tag`.`category` ";
				$sql .= "         ,`tag`.`name` ";
				$sql .= "         ,`tag`.`name_short` ";
				$sql .= "FROM      `stage_tag` ";
				$sql .= "INNER JOIN `tag` ";
				$sql .= "  ON       `stage_tag`.`tag_id` = `tag`.`id` ";
				$sql .= "WHERE      `stage_tag`.`stage_id` IN (" . implode(",", array_fill(0, count($stage_list), "?")) . ") ";
				$sql .= "ORDER BY   `stage_tag`.`stage_id` DESC ";
				$sql .= "          ,`tag`.`category` ASC ";
				$sql .= "          ,`tag`.`sort` ASC ";
				foreach ($stage_list as $v)
				{
					$arg_list[] = $v['id'];
				}
				$tag_list = $this->query($sql, $arg_list);

				if (count($tag_list) > 0)
				{
					$category_list = $this->getConfig("tag_category", "value");
					foreach ($tag_list as $v)
					{
						$stage_list[$v['stage_id']]['tag_list'][] = array(
							'id'            => $v['id'],
							'category'      => $v['category'],
							'category_key'  => $category_list[$v['category']]['key'],
							'category_name' => $category_list[$v['category']]['name'],
							'name'          => $v['name'],
							'name_short'    => $v['name_short'],
						);
					}
				}

				// 配列のキーをリセット
				$stage_list = array_values($stage_list);
			}

			// 戻り値
			$return_list['stage_list'] = $stage_list;
			return $return_list;
		}
		catch (Exception $e)
		{
			$this->exception($e);
		}
	}

	public function get($param_list = array())
	{
		try
		{
			// ユーザID
			// ログイン状態でない場合はエラー
			$user_id = $this->getLoginId();
			if ($user_id === false)
			{
				return array('error_redirect' => "session");
			}

			// 引数
			$id = trim($param_list['id']);

			$return_list = array();

			// 取得（ステージ）
			$arg_list = array();
			$sql  = "SELECT   `id`, `name`, `remarks`, `sort`, `is_private` ";
			$sql .= "FROM     `stage` ";
			$sql .= "WHERE    `id` = ? ";
			$arg_list[] = $id;
			$sql .= "AND      `user_id` = ? ";
			$arg_list[] = $user_id;
			$sql .= "AND      `is_delete` <> 1 ";
			$stage_list = $this->query($sql, $arg_list);
			if(count($stage_list) != 1)
			{
				return array('error_redirect' => "notfound");
			}

			// 取得（ユーザのログインID：URL生成用）
			$sql  = "SELECT `login_id` FROM `user` WHERE `id` = ? ";
			$arg_list = array($user_id);
			$user_list = $this->query($sql, $arg_list);
			$stage_list[0]['login_id'] = $user_list[0]['login_id'];

			// 取得（タグ）・整形
			$arg_list = array();
			$sql  = "SELECT     `tag`.`id` ";
			$sql .= "          ,`tag`.`category` ";
			$sql .= "          ,`tag`.`name` ";
			$sql .= "          ,`tag`.`name_short` ";
			$sql .= "FROM       `stage_tag` ";
			$sql .= "INNER JOIN `tag` ";
			$sql .= "  ON       `stage_tag`.`tag_id` = `tag`.`id` ";
			$sql .= "WHERE      `stage_tag`.`stage_id` = ? ";
			$sql .= "ORDER BY   `tag`.`category` ASC ";
			$sql .= "          ,`tag`.`sort` ASC ";
			$arg_list = array($id);
			$tag_list = $this->query($sql, $arg_list);
			if (count($tag_list) > 0)
			{
				$category_list = $this->getConfig("tag_category", "value");
				foreach ($tag_list as $v)
				{
					$stage_list[0]['tag_list'][] = array(
						'id'            => $v['id'],
						'category'      => $v['category'],
						'category_key'  => $category_list[$v['category']]['key'],
						'category_name' => $category_list[$v['category']]['name'],
						'name'          => $v['name'],
						'name_short'    => $v['name_short'],
					);
				}
			}

			// 取得（キャラクター）・整形
			$arg_list = array();
			$sql  = "SELECT     `character`.`id` ";
			$sql .= "          ,`character`.`name` ";
			$sql .= "FROM       `character_stage` ";
			$sql .= "INNER JOIN `character` ";
			$sql .= "  ON       `character_stage`.`character_id` = `character`.`id` ";
			$sql .= "WHERE      `character_stage`.`stage_id` = ? ";
			$sql .= "AND        `character`.`is_delete` <> 1 ";
			$sql .= "ORDER BY   `character_stage`.`sort` ASC ";
			$arg_list = array($id);
			$character_list = $this->query($sql, $arg_list);
			$stage_list[0]['character_list'] = array();
			if (count($character_list) > 0)
			{
				foreach ($character_list as $v)
				{
					$stage_list[0]['character_list'][] = array(
						'id'    => $v['id'],
						'name'  => $v['name'],
					);
				}
			}

			// 戻り値
			$return_list['stage'] = $stage_list[0];
			return $return_list;
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
			$user_id    = $this->getLoginId();
			if ($user_id === false)
			{
				return array('error_redirect' => "session");
			}

			// 引数
			$name     = trim($param_list['name']);
			$remarks  = trim($param_list['remarks']);
			$tag_list = isset($param_list['tag_list']) && is_array($param_list['tag_list']) ? $param_list['tag_list'] : array();

			// バリデート
			$err_list = array();
			if (mb_strlen($name) == 0)
			{
				$err_list[] = "ステージ名を入力してください。";
			}
			elseif (mb_strlen($name) > 16)
			{
				$err_list[] = "ステージ名は16文字以内で入力してください。";
			}
			if (mb_strlen($remarks) > 300)
			{
				$err_list[] = "説明文は300文字以内で入力してください。";
			}
			if (count($err_list) > 0)
			{
				return array('error_message_list' => $err_list);
			}

			// 登録
			$arg_list = array();
			$sql  = "INSERT INTO `stage` (`user_id`, `name`, `remarks`) ";
			$sql .= "VALUES              (?        ,?      , ?        ) ";
			$arg_list[] = $user_id;
			$arg_list[] = $name;
			$arg_list[] = $remarks == "" ? null : $remarks;
			$this->query($sql, $arg_list);
			$stage_id = $this->getLastInsertId();

			// タグ登録
			$tag_list = array_filter($tag_list, function($v){return(preg_match("/^[0-9]+$/", $v));});
			if (count($tag_list) > 0)
			{
				$arg_list = array();
				$sql  = "INSERT INTO `stage_tag` (`stage_id`, `tag_id`) ";
				$sql .= "VALUES " . implode(",", array_fill(0, count($tag_list), "(?, ?)"));
				foreach ($tag_list as $v)
				{
					$arg_list[] = $stage_id;
					$arg_list[] = $v;
				}
				$this->query($sql, $arg_list);
			}

			// 戻り値
			$return_list = array(
				'stage_id'   => $stage_id,
				'name'       => $name,
				'remarks'    => $remarks,
				'tag_list'   => $tag_list,
			);
			return $return_list;
		}
		catch (Exception $e)
		{
			$this->exception($e);
		}
	}

	public function set($param_list = array())
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
			$id       = trim($param_list['id']);
			$name     = trim($param_list['name']);
			$remarks  = trim($param_list['remarks']);
			$tag_list = isset($param_list['tag_list']) && is_array($param_list['tag_list']) ? $param_list['tag_list'] : array();

			// バリデート
			$err_list = array();
			if (!preg_match("/^[0-9]+$/", $id))
			{
				$err_list[] = "存在しないデータです。最初からやり直してください。";
				return array('error_message_list' => $err_list);
			}
			else
			{
				$sql  = "SELECT `id` FROM `stage` WHERE `id` = ? AND `user_id` = ? AND `is_delete` <> 1 ";
				$arg_list = array($id, $user_id);
				$r = $this->query($sql, $arg_list);
				if (count($r) != 1)
				{
					$err_list[] = "存在しないデータです。最初からやり直してください。";
					return array('error_message_list' => $err_list);
				}
			}
			if (mb_strlen($name) == 0)
			{
				$err_list[] = "ステージ名を入力してください。";
			}
			elseif (mb_strlen($name) > 16)
			{
				$err_list[] = "ステージ名は16文字以内で入力してください。";
			}
			if (mb_strlen($remarks) > 300)
			{
				$err_list[] = "説明文は300文字以内で入力してください。";
			}
			if (count($err_list) > 0)
			{
				return array('error_message_list' => $err_list);
			}

			// 更新
			$arg_list = array();
			$sql  = "UPDATE `stage` ";
			$sql .= "SET    `name`    = ? ";
			$sql .= "      ,`remarks` = ? ";
			$sql .= "WHERE  `id`      = ? ";
			$arg_list[] = $name;
			$arg_list[] = $remarks == "" ? null : $remarks;
			$arg_list[] = $id;
			$this->query($sql, $arg_list);

			// タグ登録
			// 一度全削除して再登録
			$sql  = "DELETE FROM `stage_tag` ";
			$sql .= "WHERE `stage_id` = ? ";
			$arg_list = array($id);
			$this->query($sql, $arg_list);
			$tag_list = array_filter($tag_list, function($v){return(preg_match("/^[0-9]+$/", $v));});
			if (count($tag_list) > 0)
			{
				$arg_list = array();
				$sql  = "INSERT INTO `stage_tag` (`stage_id`, `tag_id`) ";
				$sql .= "VALUES " . implode(",", array_fill(0, count($tag_list), "(?, ?)"));
				foreach ($tag_list as $v)
				{
					$arg_list[] = $id;
					$arg_list[] = $v;
				}
				$this->query($sql, $arg_list);
			}

			// 戻り値
			$return_list = array(
				'stage_id'   => $id,
				'name'       => $name,
				'remarks'    => $remarks,
				'tag_list'   => $tag_list,
			);
			return $return_list;
		}
		catch (Exception $e)
		{
			$this->exception($e);
		}
	}

	public function setIsPrivate($param_list = array())
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
			$id         = trim($param_list['id']);
			$is_private = trim($param_list['is_private']) == "0" ? "0" : "1";

			// バリデート
			$err_list = array();
			if (!preg_match("/^[0-9]+$/", $id))
			{
				$err_list[] = "存在しないデータです。最初からやり直してください。";
				return array('error_message_list' => $err_list);
			}
			else
			{
				$sql  = "SELECT `id` FROM `stage` WHERE `id` = ? AND `user_id` = ? AND `is_delete` <> 1 ";
				$arg_list = array($id, $user_id);
				$r = $this->query($sql, $arg_list);
				if (count($r) != 1)
				{
					$err_list[] = "存在しないデータです。最初からやり直してください。";
					return array('error_message_list' => $err_list);
				}
			}
			if (count($err_list) > 0)
			{
				return array('error_message_list' => $err_list);
			}

			// 更新
			$arg_list = array();
			$sql  = "UPDATE `stage` ";
			$sql .= "SET    `is_private` = ? ";
			$sql .= "WHERE  `id` = ? ";
			$arg_list[] = $is_private;
			$arg_list[] = $id;
			$this->query($sql, $arg_list);

			// 戻り値
			$return_list = array(
				'id'         => $id,
				'is_private' => $is_private,
			);
			return $return_list;
		}
		catch (Exception $e)
		{
			$this->exception($e);
		}
	}

	public function setSort($param_list = array())
	{
		try
		{
			// ユーザID
			$user_id    = $this->getLoginId();
			if ($user_id === false)
			{
				return array('error_redirect' => "session");
			}

			// 引数
			$id_list = isset($param_list['id_list']) && is_array($param_list['id_list']) ? $param_list['id_list'] : array();

			// 更新
			$sql  = "UPDATE `stage` ";
			$sql .= "SET    `sort` = ? ";
			$sql .= "WHERE  `id` = ? ";
			$sql .= "AND    `user_id` = ? ";
			foreach ($id_list as $sort => $id)
			{
				$arg_list = array(
					$sort + 1,
					$id,
					$user_id,
				);
				$this->query($sql, $arg_list);
			}

			// 戻り値
			$return_list = array($id_list);
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
			$id = trim($param_list['id']);

			// バリデート
			$err_list = array();
			if (!preg_match("/^[0-9]+$/", $id))
			{
				$err_list[] = "存在しないデータです。最初からやり直してください。";
				return array('error_message_list' => $err_list);
			}
			else
			{
				$sql  = "SELECT `id` FROM `stage` WHERE `id` = ? AND `user_id` = ? AND `is_delete` <> 1 ";
				$arg_list = array($id, $user_id);
				$r = $this->query($sql, $arg_list);
				if (count($r) != 1)
				{
					$err_list[] = "存在しないデータです。最初からやり直してください。";
					return array('error_message_list' => $err_list);
				}
			}
			if (count($err_list) > 0)
			{
				return array('error_message_list' => $err_list);
			}

			// 更新
			$arg_list = array();
			$sql  = "UPDATE `stage` ";
			$sql .= "SET    `is_delete` = 1 ";
			$sql .= "WHERE  `id` = ? ";
			$arg_list[] = $id;
			$this->query($sql, $arg_list);

			// 戻り値
			$return_list = array(
				'id' => $id,
			);
			return $return_list;
		}
		catch (Exception $e)
		{
			$this->exception($e);
		}
	}
}
