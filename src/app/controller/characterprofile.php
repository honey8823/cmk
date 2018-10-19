<?php
class CharacterprofileController extends Common
{
	public function table($param_list = array())
	{
		try
		{
// 			// 引数
// 			$sort_column = isset($param_list['sort_column']) ? trim($param_list['sort_column']) : "";
// 			$sort_order  = isset($param_list['sort_order'])  ? trim($param_list['sort_order'])  : "";
// 			$limit       = isset($param_list['limit'])       ? trim($param_list['limit'])       : "20";
// 			$offset      = isset($param_list['offset'])      ? trim($param_list['offset'])      : "0";

// 			// ユーザID
// 			// ログイン状態でない場合はエラー
// 			$user_id    = $this->getLoginId();
// 			if ($user_id === false)
// 			{
// 				return array('error_redirect' => "session");
// 			}

			$return_list = array();

// 			// 取得（キャラクター）
// 			// 次を取得できるかどうかを調べるため、「limit+1」件取得している
// 			$arg_list = array();
// 			$sql  = "SELECT   `id`, `name`, `is_private` ";
// 			$sql .= "FROM     `character` ";
// 			$sql .= "WHERE    `user_id` = ? ";
// 			$arg_list[] = $user_id;
// 			$sql .= "AND      `is_delete` <> 1 ";
// 			if ($sort_column == "")
// 			{
// 				$sql .= "ORDER BY `sort` = 0 ASC ";
// 				$sql .= "        ,`sort` ASC ";
// 			}
// 			else
// 			{
// 				$sql .= "ORDER BY `" . $sort_column . "` " . $sort_order . " ";
// 			}
// 			$sql .= "LIMIT    " . $offset . ", " . ($limit + 1) . " ";
// 			$character_list = $this->query($sql, $arg_list);

// 			if (count($character_list) == ($limit + 1))
// 			{
// 				// 次を取得可
// 				// 確認用に取得した最後の1件を配列から除く
// 				$return_list['is_more'] = 1;
// 				unset($character_list[$limit]);
// 			}
// 			else
// 			{
// 				// 次を取得不可
// 				$return_list['is_more'] = 0;
// 			}

// 			// 取得（ステージ）・整形
// 			if (count($character_list) > 0)
// 			{
// 				$character_list = $this->setArrayKey($character_list, "id");

// 				$arg_list = array();
// 				$sql  = "SELECT     `character_stage`.`character_id` ";
// 				$sql .= "          ,`stage`.`id` ";
// 				$sql .= "          ,`stage`.`name` ";
// 				$sql .= "FROM       `character_stage` ";
// 				$sql .= "INNER JOIN `stage` ";
// 				$sql .= "  ON       `character_stage`.`stage_id` = `stage`.`id` ";
// 				$sql .= "WHERE      `character_stage`.`character_id` IN (" . implode(",", array_fill(0, count($character_list), "?")) . ") ";
//                                 $sql .= "AND        `stage`.`is_delete` <> 1 ";
// 				$sql .= "ORDER BY   `character_stage`.`character_id` DESC ";
// 				$sql .= "          ,`stage`.`sort` ASC ";
// 				foreach ($character_list as $v)
// 				{
// 					$arg_list[] = $v['id'];
// 				}
// 				$stage_list = $this->query($sql, $arg_list);

// 				if (count($stage_list) > 0)
// 				{
// 					foreach ($stage_list as $v)
// 					{
// 						$character_list[$v['character_id']]['stage_list'][] = array(
// 							'id'   => $v['id'],
// 							'name' => $v['name'],
// 						);
// 					}
// 				}

// 				// 配列のキーをリセット
// 				$character_list = array_values($character_list);
// 			}

// 			// 戻り値
// 			$return_list['character_list'] = $character_list;
			return $return_list;
		}
		catch (Exception $e)
		{
			// todo::エラー処理
		}


	}

	public function get($param_list = array())
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
			$character_id = trim($param_list['character_id']);
			$stage_id     = trim($param_list['stage_id']);
			$episode_id   = trim($param_list['episode_id']);

			// バリデート
			if (!preg_match("/^[0-9]+$/", $character_id))
			{
				$err_list[] = "無効なデータです。一度画面を更新してやり直してください。";
			}
			else
			{
				$sql  = "SELECT `id`, `name` FROM `character` WHERE `is_delete` <> 1 AND `user_id` = ? AND `id` = ? ";
				$arg_list = array($user_id, $character_id);
				$character_list = $this->query($sql, $arg_list);
				if (count($character_list) != 1)
				{
					$err_list[] = "無効なデータです。一度画面を更新してやり直してください。";
				}
			}

			// 通常・ステージ用・エピソード用の判定
			$mode = "default";
			if (preg_match("/^[0-9]+$/", $episode_id))
			{
				$mode = "episode";
			}
			elseif (preg_match("/^[0-9]+$/", $stage_id))
			{
				$mode = "stage";
			}

			$return_list = array();
















			// 取得（キャラクター）
			$arg_list = array();
			$sql  = "SELECT    `character`.`id` ";
			$sql .= "         ,`character`.`name` ";
			$sql .= "FROM      `character` ";
			$sql .= "LEFT JOIN `character_profile` ON `character`.`id` =  ";
			if ($mode == "stage")
			{

			}

			$sql .= "WHERE    `id` = ? ";
// 			$arg_list[] = $id;
// 			$sql .= "AND      `user_id` = ? ";
// 			$arg_list[] = $user_id;
// 			$sql .= "AND      `is_delete` <> 1 ";
// 			$character_list = $this->query($sql, $arg_list);

// 			if(count($character_list) != 1)
// 			{
// 				return array('error_redirect' => "notfound");
// 			}

// 			// 取得（ステージ）・整形
// 			$sql  = "SELECT     `stage`.`id` ";
// 			$sql .= "          ,`stage`.`name` ";
// 			$sql .= "FROM       `character_stage` ";
// 			$sql .= "INNER JOIN `stage` ";
// 			$sql .= "  ON       `character_stage`.`stage_id` = `stage`.`id` ";
// 			$sql .= "WHERE      `character_stage`.`character_id` = ? ";
//                         $sql .= "AND        `stage`.`is_delete` <> 1 ";
// 			$sql .= "ORDER BY   `stage`.`sort` ASC ";
//                         $arg_list = array($id);
// 			$stage_list = $this->query($sql, $arg_list);
//                         $character_list[0]['stage_list'] = array();
// 			if (count($stage_list) > 0)
// 			{
// 				foreach ($stage_list as $v)
// 				{
// 					$character_list[0]['stage_list'][] = array(
// 						'id'            => $v['id'],
// 						'name'          => $v['name'],
// 					);
// 				}
// 			}

// 			// 戻り値
// 			$return_list['character'] = $character_list[0];
			return $return_list;
		}
		catch (Exception $e)
		{
			// todo::エラー処理
		}
	}

	public function upsert($param_list = array())
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
			$character_id = trim($param_list['character_id']);
			$stage_id     = trim($param_list['stage_id']);
			$episode_id   = trim($param_list['episode_id']);
			$headline_id  = trim($param_list['headline_id']);
			$content      = trim($param_list['content']);

			// 通常・ステージ用・エピソード用の判定
			$mode = "default";
			if (preg_match("/^[0-9]+$/", $episode_id))
			{
				$mode = "episode";
			}
			elseif (preg_match("/^[0-9]+$/", $stage_id))
			{
				$mode = "stage";
			}

			// バリデート1
			$err_list = array();
			if (!preg_match("/^[0-9]+$/", $character_id))
			{
				$err_list[] = "無効なデータです。一度画面を更新してやり直してください。";
			}
			else
			{
				// 対象データがすべてログインユーザのものかどうか・存在するかどうか
				$arg_list = array();
				$sql  = "SELECT `user`.`id` FROM `user` ";
				$sql .= "INNER JOIN `character` ON  `user`.`id` = `character`.`user_id` ";
				$sql .= "                       AND `character`.`is_delete` <> 1 ";
				$sql .= "                       AND `character`.`user_id` = ? ";
				$arg_list[] = $user_id;
				if ($mode == "stage")
				{
					$sql .= "INNER JOIN `stage` ON  `user`.`id` = `stage`.`user_id` ";
					$sql .= "                   AND `stage`.`id` = ? ";
					$sql .= "                   AND `stage`.`user_id` = ? ";
					$sql .= "                   AND `stage`.`is_delete` <> 1 ";
					$arg_list[] = $stage_id;
					$arg_list[] = $user_id;
				}
				elseif ($mode == "episode")
				{
					$sql .= "INNER JOIN ( SELECT     `stage`.`user_id` ";
					$sql .= "             FROM       `episode` ";
					$sql .= "             INNER JOIN `stage` ON `episode`.`stage_id` = `stage`.`id` ";
					$sql .= "             WHERE      `episode`.`id` = ? ";
					$sql .= "               AND      `episode`.`is_delete` <> 1 ";
					$sql .= "               AND      `stage`.`user_id` = ? ";
					$sql .= "               AND      `episode`.`is_delete` <> 1 ";
					$sql .= "            ) AS `episode` ON `user`.`id` = `episode`.`user_id` ";
					$arg_list[] = $episode_id;
					$arg_list[] = $user_id;
				}
				$sql .= "WHERE `user`.`id` = ? ";
				$arg_list[] = $user_id;
				$r = $this->query($sql, $arg_list);
				if (count($r) != 1)
				{
					$err_list[] = "無効なデータです。一度画面を更新してやり直してください。";
				}
			}
			if (count($err_list) > 0)
			{
				return array('error_message_list' => $err_list);
			}

			// バリデート2
			if (!preg_match("/^[0-9]+$/", $headline_id) || $headline_id == "0")
			{
				$err_list[] = "項目を選択してください。";
			}
			if ($content == "")
			{
				$err_list[] = "内容を入力してください。";
			}
			elseif (strlen($content) > 1000)
			{
				$err_list[] = "内容は1000文字以内で入力してください。";
			}
			if (count($err_list) > 0)
			{
				return array('error_message_list' => $err_list);
			}

			// 登録
			$arg_list = array();
			$sql  = "INSERT INTO ";
			if ($mode == "default")
			{
				$sql  = "  `character_profile` (`character_id`, `headline_id`, `content`) ";
				$sql .= "VALUES (?, ?, ?) ";
				$arg_list[] = $character_id;
			}
			elseif ($mode == "stage")
			{
				$sql  = "  `character_profile_stage` (`character_id`, `stage_id`, `headline_id`, `content`) ";
				$sql .= "VALUES (?, ?, ?, ?) ";
				$arg_list[] = $character_id;
				$arg_list[] = $stage_id;
			}
			elseif ($mode == "episode")
			{
				$sql  = "  `character_profile_episode` (`character_id`, `episode_id`, `headline_id`, `content`) ";
				$sql .= "VALUES (?, ?, ?, ?) ";
				$arg_list[] = $character_id;
				$arg_list[] = $episode_id;
			}
			$arg_list[] = $headline_id;
			$arg_list[] = $content;
			$sql .= "ON DUPLICATE KEY UPDATE `headline_id`  = VALUES(`headline_id`) ";
			$sql .= "                       ,`content`      = VALUES(`content`) ";
			$this->query($sql, $arg_list);

			// 戻り値
			$return_list = array();
			return $return_list;
		}
		catch (Exception $e)
		{
			// todo::エラー処理
		}
	}

	public function setSort($param_list = array())
	{
		try
		{
// 			// ユーザID
// 			$user_id    = $this->getLoginId();
// 			if ($user_id === false)
// 			{
// 				return array('error_redirect' => "session");
// 			}

// 			// 引数
// 			$id_list = isset($param_list['id_list']) && is_array($param_list['id_list']) ? $param_list['id_list'] : array();

// 			// 更新
// 			$sql  = "UPDATE `character` ";
// 			$sql .= "SET    `sort` = ? ";
// 			$sql .= "WHERE  `id` = ? ";
// 			$sql .= "AND    `user_id` = ? ";
// 			foreach ($id_list as $sort => $id)
// 			{
// 				$arg_list = array(
// 					$sort + 1,
// 					$id,
// 					$user_id,
// 				);
// 				$this->query($sql, $arg_list);
// 			}

// 			// 戻り値
// 			$return_list = array($id_list);
// 			return $return_list;
		}
		catch (Exception $e)
		{
			// todo::エラー処理
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
			// todo::エラー処理
		}
	}
}
