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
			$sql .= "ORDER BY `sort` = 0 ASC ";
			$sql .= "        ,`sort` ASC ";
			$stage_list = $this->query($sql, $arg_list);

			// 取得（タグ）・整形
			if (count($stage_list) > 0)
			{
				$stage_list = $this->setArrayKey($stage_list, "id");

				$arg_list = array();
				$sql  = "SELECT     `stage_tag`.`stage_id` ";
				$sql .= "          ,`tag`.`id` ";
				$sql .= "          ,`tag`.`category` ";
				$sql .= "          ,`tag`.`name` ";
				$sql .= "          ,`tag`.`name_short` ";
				$sql .= "FROM       `stage_tag` ";
				$sql .= "INNER JOIN `tag` ";
				$sql .= "  ON       `stage_tag`.`tag_id` = `tag`.`id` ";
				$sql .= "LEFT JOIN  `genre` ";
				$sql .= "  ON       `tag`.`genre_id` = `genre`.`id` ";
				$sql .= "WHERE      `stage_tag`.`stage_id` IN (" . implode(",", array_fill(0, count($stage_list), "?")) . ") ";
				$sql .= "ORDER BY   `stage_tag`.`stage_id` ASC ";
				$sql .= "          ,`tag`.`category` ASC ";
				$sql .= "          ,`genre`.`sort` ASC ";
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
			$tc = new TagController();
			$tc->init();
			$stage_list[0]['tag_list'] = $tc->table(array('stage_id' => $id));

			// 取得（キャラクター）・整形
			$arg_list = array();
			$sql  = "SELECT     `character`.`id` ";
			$sql .= "          ,`character`.`name` ";
			$sql .= "          ,`character`.`image` ";
			$sql .= "          ,`character`.`is_private` ";
			$sql .= "FROM       `stage_character` ";
			$sql .= "INNER JOIN `character` ";
			$sql .= "  ON       `stage_character`.`character_id` = `character`.`id` ";
			$sql .= "WHERE      `stage_character`.`stage_id` = ? ";
			$sql .= "AND        `character`.`user_id` = ? ";
			$sql .= "AND        `character`.`is_delete` <> 1 ";
			$sql .= "ORDER BY   `stage_character`.`sort` = 0 ASC ";
			$sql .= "          ,`stage_character`.`sort` ASC ";
			$sql .= "          ,`stage_character`.`character_id` ASC ";
			$arg_list = array($id, $user_id);
			$character_list = $this->query($sql, $arg_list);
			$stage_list[0]['character_list'] = array();
			if (count($character_list) > 0)
			{
				foreach ($character_list as $v)
				{
					$stage_list[0]['character_list'][] = $v;
				}
			}

			// 取得（相関図）・整形
			$relation_list = array();
			if (count($character_list) > 0)
			{
				// 相関図の全体を生成
				foreach ($character_list as $k1 => $v1)
				{
					foreach ($character_list as $k2 => $v2)
					{
						if ($k1 < $k2)
						{
							$relation_list[$v1['id']][$v2['id']] = array(
								'character_id_a'    => $v1['id'],
								'character_name_a'  => $v1['name'],
								'character_image_a' => $v1['image'],
								'character_id_b'    => $v2['id'],
								'character_name_b'  => $v2['name'],
								'character_image_b' => $v2['image'],
								'title_a'     => "",
								'free_text_a' => "",
								'is_arrow_a'  => "0",
								'title_b'     => "",
								'free_text_b' => "",
								'is_arrow_b'  => "0",
								'title_c'     => "",
								'free_text_c' => "",
								'is_arrow_c'  => "0",
							);
						}
					}
				}

				// 取得（基本）
				$arg_list = array();
				$sql  = "SELECT `character_relation`.`character_id_from` ";
				$sql .= "      ,`character_relation`.`character_id_to` ";
				$sql .= "      ,`character_relation`.`is_both` ";
				$sql .= "      ,`character_relation`.`title` ";
				$sql .= "      ,`character_relation`.`free_text` ";
				$sql .= "FROM   `character_relation` ";
				$sql .= "WHERE  `character_relation`.`character_id_from` IN (" . implode(",", array_fill(0, count($character_list), "?")) . ") ";
				$sql .= "AND    `character_relation`.`character_id_to`   IN (" . implode(",", array_fill(0, count($character_list), "?")) . ") ";
				$arg_list = array_merge($arg_list, array_column($character_list, "id"));
				$arg_list = array_merge($arg_list, array_column($character_list, "id"));
				$tmp_relation_list = $this->query($sql, $arg_list);

				foreach ($tmp_relation_list as $v)
				{
					if (isset($relation_list[$v['character_id_from']][$v['character_id_to']]))
					{
						$relation_list[$v['character_id_from']][$v['character_id_to']]['title_a']     = $v['title'];
						$relation_list[$v['character_id_from']][$v['character_id_to']]['free_text_a'] = $v['free_text'];
						$relation_list[$v['character_id_from']][$v['character_id_to']]['is_arrow_c'] |= $v['is_both'];
						if ($v['title'] != "" || $v['free_text'] != "")
						{
							$relation_list[$v['character_id_from']][$v['character_id_to']]['is_arrow_a'] = "1";
						}
						if ($relation_list[$v['character_id_from']][$v['character_id_to']]['title_c'] == "")
						{
							$relation_list[$v['character_id_from']][$v['character_id_to']]['title_c'] = $v['title'];
						}
					}
					elseif (isset($relation_list[$v['character_id_to']][$v['character_id_from']]))
					{
						$relation_list[$v['character_id_to']][$v['character_id_from']]['title_b']     = $v['title'];
						$relation_list[$v['character_id_to']][$v['character_id_from']]['free_text_b'] = $v['free_text'];
						$relation_list[$v['character_id_to']][$v['character_id_from']]['is_arrow_c'] |= $v['is_both'];
						if ($v['title'] != "" || $v['free_text'] != "")
						{
							$relation_list[$v['character_id_to']][$v['character_id_from']]['is_arrow_b'] = "1";
						}
						if ($relation_list[$v['character_id_to']][$v['character_id_from']]['title_c'] == "")
						{
							$relation_list[$v['character_id_to']][$v['character_id_from']]['title_c'] = $v['title'];
						}
					}
				}
				foreach ($relation_list as $k1 => $v1)
				{
					foreach ($v1 as $k2 => $v2)
					{
						$stage_list[0]['relation_list'][] = $v2;
					}
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
			$user_id = $this->getLoginId();
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
				$err_list[] = "エラーが発生しました。一旦画面をリロードしてやり直してください。";
				return array('error_message_list' => $err_list);
			}
			else
			{
				$sql  = "SELECT `id` FROM `stage` WHERE `id` = ? AND `user_id` = ? AND `is_delete` <> 1 ";
				$arg_list = array($id, $user_id);
				$r = $this->query($sql, $arg_list);
				if (count($r) != 1)
				{
					$err_list[] = "エラーが発生しました。一旦画面をリロードしてやり直してください。";
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
			// 一度全削除して再登録（sortがないため問題なし）
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
				$err_list[] = "エラーが発生しました。一旦画面をリロードしてやり直してください。";
				return array('error_message_list' => $err_list);
			}
			else
			{
				$sql  = "SELECT `id` FROM `stage` WHERE `id` = ? AND `user_id` = ? AND `is_delete` <> 1 ";
				$arg_list = array($id, $user_id);
				$r = $this->query($sql, $arg_list);
				if (count($r) != 1)
				{
					$err_list[] = "エラーが発生しました。一旦画面をリロードしてやり直してください。";
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
			$user_id = $this->getLoginId();
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

	public function setCharacterSort($param_list = array())
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
			$stage_id = $param_list['stage_id'];
			$id_list  = isset($param_list['id_list']) && is_array($param_list['id_list']) ? $param_list['id_list'] : array();

			// 更新
			$sql  = "UPDATE `stage_character` ";
			$sql .= "SET    `sort` = ? ";
			$sql .= "WHERE  `character_id` = ? ";
			$sql .= "AND    `stage_id` IN (SELECT `id` FROM `stage` WHERE `stage_id` = ? AND `user_id` = ?) ";
			foreach ($id_list as $sort => $id)
			{
				$arg_list = array(
					$sort + 1,
					$id,
					$stage_id,
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

	public function upsertCharacter($param_list = array())
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
			$stage_id       = $param_list['stage_id'];
			$character_list = isset($param_list['character_list']) && is_array($param_list['character_list']) ? $param_list['character_list'] : array();

			// バリデート
			$err_list = array();
			if (!preg_match("/^[0-9]+$/", $stage_id))
			{
				$err_list[] = "エラーが発生しました。一旦画面をリロードしてやり直してください。";
				return array('error_message_list' => $err_list);
			}
			else
			{
				$sql  = "SELECT `id` FROM `stage` WHERE `id` = ? AND `user_id` = ? AND `is_delete` <> 1 ";
				$arg_list = array($stage_id, $user_id);
				$r = $this->query($sql, $arg_list);
				if (count($r) != 1)
				{
					$err_list[] = "エラーが発生しました。一旦画面をリロードしてやり直してください。";
					return array('error_message_list' => $err_list);
				}
			}

			// 変更後のデータを取得
			$character_list = array_filter($character_list, function($v){return(preg_match("/^[0-9]+$/", $v));});
			$new_character_list = array();
			$after_character_list = array();
			if (count($character_list) > 0)
			{
				// 登録できないデータ（削除済み・本人のデータでないもの）を省く
				$sql  = "SELECT `id`, `name`, `is_private`, `image` ";
				$sql .= "FROM   `character` ";
				$sql .= "WHERE  `id` IN (" . implode(",", array_fill(0, count($character_list), "?")) . ") ";
				$sql .= "AND    `user_id` = ? ";
				$sql .= "AND    `is_delete` <> 1 ";
				$arg_list = $character_list;
				$arg_list[] = $user_id;
				$new_character_list = $this->query($sql, $arg_list);
				$after_character_list = array_column($new_character_list, "id");
				$new_character_list = $this->setArrayKey($new_character_list, "id");
			}

			// 変更前のデータを取得
			$sql  = "SELECT `character_id` ";
			$sql .= "FROM   `stage_character` ";
			$sql .= "WHERE  `stage_id` = ? ";
			$arg_list = array($stage_id);
			$before_character_list = array_column($this->query($sql, $arg_list), "character_id");

			// 削除対象
			$del_character_list = array_diff($before_character_list, $after_character_list);

			// 追加対象
			$add_character_list = array_diff($after_character_list, $before_character_list);

			// 不要なものを削除
			if (count($del_character_list) > 0)
			{
				$arg_list = array();
				$sql  = "DELETE FROM `stage_character` ";
				$sql .= "WHERE `stage_id` = ? ";
				$sql .= "AND   `character_id` IN (" . implode(",", array_fill(0, count($del_character_list), "?")) . ") ";
				$arg_list[] = $stage_id;
				$arg_list = array_merge($arg_list, $del_character_list);
				$this->query($sql, $arg_list);
			}

			// 必要なものを追加
			if (count($add_character_list) > 0)
			{
				$arg_list = array();
				$sql  = "INSERT INTO `stage_character` (`stage_id`, `character_id`) ";
				$sql .= "VALUES " . implode(",", array_fill(0, count($add_character_list), "(?, ?)"));
				foreach ($add_character_list as $v)
				{
					$arg_list[] = $stage_id;
					$arg_list[] = $v;
				}
				$this->query($sql, $arg_list);
			}

			// 戻り値
			$return_list = array(
				'character_list'     => $new_character_list,
				'del_character_list' => array_values($del_character_list),
				'add_character_list' => array_values($add_character_list),
			);
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
				$err_list[] = "エラーが発生しました。一旦画面をリロードしてやり直してください。";
				return array('error_message_list' => $err_list);
			}
			else
			{
				$sql  = "SELECT `id` FROM `stage` WHERE `id` = ? AND `user_id` = ? AND `is_delete` <> 1 ";
				$arg_list = array($id, $user_id);
				$r = $this->query($sql, $arg_list);
				if (count($r) != 1)
				{
					$err_list[] = "エラーが発生しました。一旦画面をリロードしてやり直してください。";
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
