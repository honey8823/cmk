<?php
class CharacterController extends Common
{
	public function table($param_list = array())
	{
		try
		{
			// ユーザID
			// ログイン状態でない場合はエラー
			$user_id    = $this->getLoginId();
			if ($user_id === false)
			{
				return array('error_redirect' => "session");
			}

			$return_list = array();

			// 取得（キャラクター）
			$arg_list = array();
			$sql  = "SELECT   `id`, `name`, `is_private` ";
			$sql .= "FROM     `character` ";
			$sql .= "WHERE    `user_id` = ? ";
			$arg_list[] = $user_id;
			$sql .= "AND      `is_delete` <> 1 ";
			$sql .= "ORDER BY `sort` = 0 ASC ";
			$sql .= "        ,`sort` ASC ";
			$character_list = $this->query($sql, $arg_list);

			// 取得（ステージ）・整形
			if (count($character_list) > 0)
			{
				$character_list = $this->setArrayKey($character_list, "id");

				$arg_list = array();
				$sql  = "SELECT     `stage_character`.`character_id` ";
				$sql .= "          ,`stage`.`id` ";
				$sql .= "          ,`stage`.`name` ";
				$sql .= "FROM       `stage_character` ";
				$sql .= "INNER JOIN `stage` ";
				$sql .= "  ON       `stage_character`.`stage_id` = `stage`.`id` ";
				$sql .= "WHERE      `stage_character`.`character_id` IN (" . implode(",", array_fill(0, count($character_list), "?")) . ") ";
				$sql .= "AND        `stage`.`user_id` = ? ";
				$sql .= "AND        `stage`.`is_delete` <> 1 ";
				$sql .= "ORDER BY   `stage_character`.`character_id` ASC ";
				$sql .= "          ,`stage`.`sort` = 0 ASC ";
				$sql .= "          ,`stage`.`sort` ASC ";
				foreach ($character_list as $v)
				{
					$arg_list[] = $v['id'];
				}
				$arg_list[] = $user_id;
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

			// 取得（ユーザのログインID：URL生成用）
			$sql  = "SELECT `login_id` FROM `user` WHERE `id` = ? ";
			$arg_list = array($user_id);
			$user_list = $this->query($sql, $arg_list);
			$character_list[0]['login_id'] = $user_list[0]['login_id'];

			// 取得（ステージ）・整形
			$sql  = "SELECT     `stage`.`id` ";
			$sql .= "          ,`stage`.`name` ";
			$sql .= "FROM       `stage_character` ";
			$sql .= "INNER JOIN `stage` ";
			$sql .= "  ON       `stage_character`.`stage_id` = `stage`.`id` ";
			$sql .= "WHERE      `stage_character`.`character_id` = ? ";
			$sql .= "AND        `stage`.`is_delete` <> 1 ";
			$sql .= "AND        `stage`.`user_id` = ? ";
			$sql .= "ORDER BY   `stage`.`sort` = 0 ASC ";
			$sql .= "          ,`stage`.`sort` ASC ";
			$arg_list = array($id, $user_id);
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
				$sql  = "INSERT INTO `stage_character` (`stage_id`, `character_id`) ";
				$sql .= "VALUES " . implode(",", array_fill(0, count($stage_list), "(?, ?)"));
				foreach ($stage_list as $v)
				{
					$arg_list[] = $v;
					$arg_list[] = $id;
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

			// 変更後のデータを取得
			$stage_list = array_filter($stage_list, function($v){return(preg_match("/^[0-9]+$/", $v));});
			$new_stage_list = array();
			$after_stage_list = array();
			if (count($stage_list) > 0)
			{
				// 登録できないデータ（削除済み・本人のデータでないもの）を省く
				$sql  = "SELECT `id` FROM `stage` WHERE `id` IN (" . implode(",", array_fill(0, count($stage_list), "?")) . ") AND `user_id` = ? AND `is_delete` <> 1 ";
				$arg_list = $stage_list;
				$arg_list[] = $user_id;
				$new_stage_list = $this->query($sql, $arg_list);
				$after_stage_list = array_column($new_stage_list, "id");
				$new_stage_list = $this->setArrayKey($new_stage_list, "id");
			}

			// 変更前のデータを取得
			$sql  = "SELECT `stage_id` ";
			$sql .= "FROM   `stage_character` ";
			$sql .= "WHERE  `character_id` = ? ";
			$arg_list = array($id);
			$before_stage_list = array_column($this->query($sql, $arg_list), "stage_id");

			// 削除対象
			$del_stage_list = array_diff($before_stage_list, $after_stage_list);

			// 追加対象
			$add_stage_list = array_diff($after_stage_list, $before_stage_list);

			// 不要なものを削除
			if (count($del_stage_list) > 0)
			{
				$arg_list = array();
				$sql  = "DELETE FROM `stage_character` ";
				$sql .= "WHERE `character_id` = ? ";
				$sql .= "AND   `stage_id` IN (" . implode(",", array_fill(0, count($del_stage_list), "?")) . ") ";
				$arg_list[] = $id;
				$arg_list = array_merge($arg_list, $del_stage_list);
				$this->query($sql, $arg_list);
			}

			// 必要なものを追加
			if (count($add_stage_list) > 0)
			{
				$arg_list = array();
				$sql  = "INSERT INTO `stage_character` (`stage_id`, `character_id`) ";
				$sql .= "VALUES " . implode(",", array_fill(0, count($add_stage_list), "(?, ?)"));
				foreach ($add_stage_list as $v)
				{
					$arg_list[] = $v;
					$arg_list[] = $id;
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
