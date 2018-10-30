<?php
class CharacterController extends Common
{
	public function table($param_list = array())
	{
		try
		{
			// 引数
			$sort_column = isset($param_list['sort_column']) ? trim($param_list['sort_column']) : "";
			$sort_order  = isset($param_list['sort_order'])  ? trim($param_list['sort_order'])  : "";
			$limit       = isset($param_list['limit'])       ? trim($param_list['limit'])       : "20";
			$offset      = isset($param_list['offset'])      ? trim($param_list['offset'])      : "0";

			// ユーザID
			// ログイン状態でない場合はエラー
			$user_id    = $this->getLoginId();
			if ($user_id === false)
			{
				return array('error_redirect' => "session");
			}

			$return_list = array();

			// 取得（キャラクター）
			// 次を取得できるかどうかを調べるため、「limit+1」件取得している
			$arg_list = array();
			$sql  = "SELECT   `id`, `name`, `is_private` ";
			$sql .= "FROM     `character` ";
			$sql .= "WHERE    `user_id` = ? ";
			$arg_list[] = $user_id;
			$sql .= "AND      `is_delete` <> 1 ";
			if ($sort_column == "")
			{
				$sql .= "ORDER BY `sort` = 0 ASC ";
				$sql .= "        ,`sort` ASC ";
			}
			else
			{
				$sql .= "ORDER BY `" . $sort_column . "` " . $sort_order . " ";
			}
			$sql .= "LIMIT    " . $offset . ", " . ($limit + 1) . " ";
			$character_list = $this->query($sql, $arg_list);

			if (count($character_list) == ($limit + 1))
			{
				// 次を取得可
				// 確認用に取得した最後の1件を配列から除く
				$return_list['is_more'] = 1;
				unset($character_list[$limit]);
			}
			else
			{
				// 次を取得不可
				$return_list['is_more'] = 0;
			}

			// 取得（ステージ）・整形
			if (count($character_list) > 0)
			{
				$character_list = $this->setArrayKey($character_list, "id");

				$arg_list = array();
				$sql  = "SELECT     `character_stage`.`character_id` ";
				$sql .= "          ,`stage`.`id` ";
				$sql .= "          ,`stage`.`name` ";
				$sql .= "FROM       `character_stage` ";
				$sql .= "INNER JOIN `stage` ";
				$sql .= "  ON       `character_stage`.`stage_id` = `stage`.`id` ";
				$sql .= "WHERE      `character_stage`.`character_id` IN (" . implode(",", array_fill(0, count($character_list), "?")) . ") ";
                                $sql .= "AND        `stage`.`is_delete` <> 1 ";
				$sql .= "ORDER BY   `character_stage`.`character_id` DESC ";
				$sql .= "          ,`stage`.`sort` ASC ";
				foreach ($character_list as $v)
				{
					$arg_list[] = $v['id'];
				}
				$stage_list = $this->query($sql, $arg_list);

				if (count($stage_list) > 0)
				{
					foreach ($stage_list as $v)
					{
						$character_list[$v['character_id']]['stage_list'][] = array(
							'id'   => $v['id'],
							'name' => $v['name'],
						);
					}
				}

				// 配列のキーをリセット
				$character_list = array_values($character_list);
			}

			// 戻り値
			$return_list['character_list'] = $character_list;
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

			// 取得（キャラクター）
			$arg_list = array();
			$sql  = "SELECT   `id`, `name`, `remarks`, `is_private` ";
			$sql .= "FROM     `character` ";
			$sql .= "WHERE    `id` = ? ";
			$arg_list[] = $id;
			$sql .= "AND      `user_id` = ? ";
			$arg_list[] = $user_id;
			$sql .= "AND      `is_delete` <> 1 ";
			$character_list = $this->query($sql, $arg_list);

			if(count($character_list) != 1)
			{
				return array('error_redirect' => "notfound");
			}

			// 取得（ステージ）・整形
			$sql  = "SELECT     `stage`.`id` ";
			$sql .= "          ,`stage`.`name` ";
			$sql .= "FROM       `character_stage` ";
			$sql .= "INNER JOIN `stage` ";
			$sql .= "  ON       `character_stage`.`stage_id` = `stage`.`id` ";
			$sql .= "WHERE      `character_stage`.`character_id` = ? ";
                        $sql .= "AND        `stage`.`is_delete` <> 1 ";
			$sql .= "ORDER BY   `stage`.`sort` ASC ";
                        $arg_list = array($id);
			$stage_list = $this->query($sql, $arg_list);
                        $character_list[0]['stage_list'] = array();
			if (count($stage_list) > 0)
			{
				foreach ($stage_list as $v)
				{
					$character_list[0]['stage_list'][] = array(
						'id'            => $v['id'],
						'name'          => $v['name'],
					);
				}
			}

			// 戻り値
			$return_list['character'] = $character_list[0];
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
			$name       = trim($param_list['name']);
			$stage_list = isset($param_list['stage_list']) && is_array($param_list['stage_list']) ? $param_list['stage_list'] : array();

			// バリデート
			$err_list = array();
			if (mb_strlen($name) == 0)
			{
				$err_list[] = "キャラクター名を入力してください。";
			}
			elseif (mb_strlen($name) > 64)
			{
				$err_list[] = "キャラクター名は64文字以内で入力してください。";
			}
			if (count($err_list) > 0)
			{
				return array('error_message_list' => $err_list);
			}

			// 登録
			$arg_list = array();
			$sql  = "INSERT INTO `character` (`user_id`, `name`) ";
			$sql .= "VALUES                  (?        ,?      ) ";
			$arg_list[] = $user_id;
			$arg_list[] = $name;
			$this->query($sql, $arg_list);
			$id = $this->getLastInsertId();

			// ステージ登録
			$stage_list = array_filter($stage_list, function($v){return(preg_match("/^[0-9]+$/", $v));});
			if (count($stage_list) > 0)
			{
				$arg_list = array();
				$sql  = "INSERT INTO `character_stage` (`character_id`, `stage_id`) ";
				$sql .= "VALUES " . implode(",", array_fill(0, count($stage_list), "(?, ?)"));
				foreach ($stage_list as $v)
				{
					$arg_list[] = $id;
					$arg_list[] = $v;
				}
				$this->query($sql, $arg_list);
			}

			// 戻り値
			$return_list = array(
				'id'         => $id,
				'name'       => $name,
				'stage_list' => $stage_list,
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
			$id         = trim($param_list['id']);
			$name       = trim($param_list['name']);
			$remarks    = trim($param_list['remarks']);
			$stage_list = isset($param_list['stage_list']) && is_array($param_list['stage_list']) ? $param_list['stage_list'] : array();

			// バリデート
			$err_list = array();
			if (!preg_match("/^[0-9]+$/", $id))
			{
				$err_list[] = "存在しないデータです。最初からやり直してください。";
				return array('error_message_list' => $err_list);
			}
			else
			{
				$sql  = "SELECT `id` FROM `character` WHERE `id` = ? AND `user_id` = ? AND `is_delete` <> 1 ";
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
				$err_list[] = "キャラクター名を入力してください。";
			}
			elseif (mb_strlen($name) > 64)
			{
				$err_list[] = "キャラクター名は64文字以内で入力してください。";
			}
			if (mb_strlen($remarks) > 10000)
			{
				$err_list[] = "備考は1万字以内で入力してください。";
			}
			if (count($err_list) > 0)
			{
				return array('error_message_list' => $err_list);
			}

			// 更新
			$arg_list = array();
			$sql  = "UPDATE `character` ";
			$sql .= "SET    `name`    = ? ";
			$sql .= "      ,`remarks` = ? ";
			$sql .= "WHERE  `id`      = ? ";
			$arg_list[] = $name;
			$arg_list[] = $remarks == "" ? null : $remarks;
			$arg_list[] = $id;
			$this->query($sql, $arg_list);

			// ステージ登録
			// 一度全削除して再登録
			$sql  = "DELETE FROM `character_stage` ";
			$sql .= "WHERE `character_id` = ? ";
			$arg_list = array($id);
			$this->query($sql, $arg_list);
			$stage_list = array_filter($stage_list, function($v){return(preg_match("/^[0-9]+$/", $v));});
			if (count($stage_list) > 0)
			{
				$arg_list = array();
				$sql  = "INSERT INTO `character_stage` (`character_id`, `stage_id`) ";
				$sql .= "VALUES " . implode(",", array_fill(0, count($stage_list), "(?, ?)"));
				foreach ($stage_list as $v)
				{
					$arg_list[] = $id;
					$arg_list[] = $v;
				}
				$this->query($sql, $arg_list);
			}

			// 戻り値
			$return_list = array(
				'id'         => $id,
				'name'       => $name,
				'stage_list' => $stage_list,
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
			$user_id    = $this->getLoginId();
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
				$sql  = "SELECT `id` FROM `character` WHERE `id` = ? AND `user_id` = ? AND `is_delete` <> 1 ";
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
			$sql  = "UPDATE `character` ";
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
			$sql  = "UPDATE `character` ";
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
				$sql  = "SELECT `id` FROM `character` WHERE `id` = ? AND `user_id` = ? AND `is_delete` <> 1 ";
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
			$sql  = "UPDATE `character` ";
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
