<?php
class EpisodeController extends Common
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
			// todo::エラー処理
		}
	}

	public function timeline($param_list = array())
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
			$stage_id     = isset($param_list['stage_id'])     ? trim($param_list['stage_id'])     : "";
			$character_id = isset($param_list['character_id']) ? trim($param_list['character_id']) : "";

			$return_list = array();

			// 取得（エピソード）
			$arg_list = array();
			$sql  = "SELECT     `episode`.`id` ";
			$sql .= "          ,`episode`.`stage_id` ";
			$sql .= "          ,`stage`.`name` ";
			$sql .= "          ,`episode`.`is_label` ";
			$sql .= "          ,`episode`.`category` ";
			$sql .= "          ,`episode`.`title` ";
			$sql .= "          ,`episode`.`url` ";
			$sql .= "          ,`episode`.`free_text` ";
			$sql .= "          ,`episode`.`is_r18` ";
			$sql .= "          ,`episode`.`is_private` ";
			$sql .= "FROM       `episode` ";
			$sql .= "INNER JOIN `stage` ON  `episode`.`stage_id` = `stage`.`id` ";
			$sql .= "                   AND `stage`.`user_id` = ? ";
			$sql .= "                   AND `stage`.`is_delete` <> 1 ";
			$arg_list[] = $user_id;
			$sql .= "WHERE      `episode`.`is_delete` <> 1 ";
			if ($stage_id != "")
			{
				$sql .= "AND `episode`.`stage_id` = ? ";
				$arg_list[] = $stage_id;
			}
			if ($character_id != "")
			{
				$sql .= "AND `episode`.`id` IN (SELECT `episode_id` FROM `episode_character` WHERE `character_id` = ?) ";
				$arg_list[] = $character_id;
			}
			$sql .= "ORDER BY `stage`.`sort` ASC ";
			$sql .= "        ,`episode`.`sort` = 0 ASC ";
			$sql .= "        ,`episode`.`sort` ASC ";
			$sql .= "        ,`episode`.`id` ASC ";
			$episode_list = $this->query($sql, $arg_list);

			// 取得（関連キャラクター）・整形
			if (count($episode_list) > 0)
			{
				$episode_list = $this->setArrayKey($episode_list, "id");

				$arg_list = array();
				$sql  = "SELECT    `episode_character`.`episode_id` ";
				$sql .= "         ,`character`.`id` ";
				$sql .= "         ,`character`.`name` ";
				$sql .= "FROM      `episode_character` ";
				$sql .= "INNER JOIN `character` ON  `episode_character`.`character_id` = `character`.`id` ";
				$sql .= "                       AND `character`.`is_delete` <> 1 ";
				$sql .= "WHERE      `episode_character`.`episode_id` IN (" . implode(",", array_fill(0, count($episode_list), "?")) . ") ";
				$sql .= "ORDER BY   `episode_character`.`episode_id` ASC ";
				$sql .= "          ,`character`.`sort` ASC ";
				foreach ($episode_list as $v)
				{
					$arg_list[] = $v['id'];
				}
				$character_list = $this->query($sql, $arg_list);

				if (count($character_list) > 0)
				{
					foreach ($character_list as $v)
					{
						$episode_list[$v['episode_id']]['character_list'][] = array(
							'id'   => $v['id'],
							'name' => $v['name'],
						);
					}
				}

				// 配列のキーをリセット
				$episode_list = array_values($episode_list);
			}

			// 戻り値
			$return_list['episode_list'] = $episode_list;
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
			// ログイン状態でない場合はエラー
			$user_id = $this->getLoginId();
			if ($user_id === false)
			{
				return array('error_redirect' => "session");
			}

			// 引数
			$id = trim($param_list['id']);

			$return_list = array();

			// 取得（エピソード）
			$arg_list = array();
			$sql  = "SELECT   `id` ";
			$sql .= "        ,`is_label` ";
			$sql .= "        ,`category` ";
			$sql .= "        ,`title` ";
			$sql .= "        ,`url` ";
			$sql .= "        ,`free_text` ";
			$sql .= "        ,`is_private` ";
			$sql .= "        ,`is_r18` ";
			$sql .= "FROM     `episode` ";
			$sql .= "WHERE    `id` = ? ";
			$arg_list[] = $id;
			$sql .= "AND      `stage_id` IN (SELECT `id` FROM `stage` WHERE `user_id` = ?) ";
			$arg_list[] = $user_id;
			$sql .= "AND      `is_delete` <> 1 ";
			$episode_list = $this->query($sql, $arg_list);
			if(count($episode_list) != 1)
			{
				return array('error_redirect' => "notfound");
			}

			// 取得（キャラクター）・整形
			$arg_list = array();
			$sql  = "SELECT     `character`.`id` ";
			$sql .= "          ,`character`.`name` ";
			$sql .= "FROM       `episode_character` ";
			$sql .= "INNER JOIN `character` ON  `episode_character`.`character_id` = `character`.`id` ";
			$sql .= "                       AND `character`.`is_delete` <> 1 ";
			$sql .= "WHERE      `episode_character`.`episode_id` = ? ";
			$sql .= "ORDER BY   `character`.`sort` ASC ";
			$arg_list = array($id);
			$character_list = $this->query($sql, $arg_list);
			$episode_list[0]['character_list'] = array();
			if (count($character_list) > 0)
			{
				foreach ($character_list as $v)
				{
					$episode_list[0]['character_list'][] = array(
						'id'    => $v['id'],
						'name'  => $v['name'],
					);
				}
			}

			// 戻り値
			$return_list['episode'] = $episode_list[0];
			return $return_list;
		}
		catch (Exception $e)
		{
			// todo::エラー処理
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
			$stage_id       = trim($param_list['stage_id']);
			$is_label       = trim($param_list['is_label']);
			$category       = trim($param_list['category']);
			$title          = trim($param_list['title']);
			$url            = trim($param_list['url']);
			$free_text      = trim($param_list['free_text']);
			$is_r18         = trim($param_list['is_r18']);
			$is_private     = trim($param_list['is_private']);
			$character_list = isset($param_list['character_list']) && is_array($param_list['character_list']) ? $param_list['character_list'] : array();

			// バリデート
			$err_list = array();
			if (!preg_match("/^[0-9]+$/", $stage_id))
			{
				$err_list[] = "エピソードの登録先ステージが選択されていません。";
				return array('error_message_list' => $err_list);
			}
			else
			{
				$sql  = "SELECT `id` FROM `stage` WHERE `id` = ? AND `user_id` = ? AND `is_delete` <> 1 ";
				$arg_list = array($stage_id, $user_id);
				$r = $this->query($sql, $arg_list);
				if (count($r) != 1)
				{
					$err_list[] = "無効なデータです。最初からやり直してください。";
					return array('error_message_list' => $err_list);
				}
			}
			if ($is_label == 1 && mb_strlen($title) == 0)
			{
				$err_list[] = "ラベルとして登録する場合、タイトルは必須です。";
			}
			if (mb_strlen($title) == 0 && mb_strlen($url) == 0 && mb_strlen($free_text) == 0)
			{
				$err_list[] = "タイトル・URL・フリーテキストのいずれか一つは必須です。";
			}
			if (mb_strlen($title) > 32)
			{
				$err_list[] = "タイトルは32文字以内で入力してください。";
			}
			if ($url != "")
			{
				if (!(strpos($url, "http://") === 0 || strpos($url, "https://") === 0 || strpos($url, "//") === 0))
				{
					$err_list[] = "URLは、「http://」「https://」「//」のいずれかから開始してください。";
				}
			}
			if (mb_strlen($url) > 256)
			{
				$err_list[] = "URLは256文字以内で入力してください。";
			}
			if (mb_strlen($free_text) > 10000)
			{
				$err_list[] = "フリーテキストは10,000文字以内で入力してください。";
			}
			if (count($err_list) > 0)
			{
				return array('error_message_list' => $err_list);
			}

			// 登録
			$arg_list = array();
			$sql  = "INSERT INTO `episode` (`stage_id`, `is_label`, `category`, `title`, `url`, `free_text`, `is_r18`, `is_private`) ";
			$sql .= "VALUES                (?         , ?         , ?         , ?      , ?    , ?          ,  ?      ,  ?          ) ";
			$arg_list[] = $stage_id;
			$arg_list[] = $is_label   == 1  ? 1 : 0;
			$arg_list[] = $category   == "" ? 0 : $category;
			$arg_list[] = $title      == "" ? null : $title;
			$arg_list[] = $url        == "" ? null : $url;
			$arg_list[] = $free_text  == "" ? null : $free_text;
			$arg_list[] = $is_r18     == 1  ? 1 : 0;
			$arg_list[] = $is_private == 0  ? 0 : 1;
			$this->query($sql, $arg_list);
			$episode_id = $this->getLastInsertId();

			// キャラクター登録
			$character_list = array_filter($character_list, function($v){return(preg_match("/^[0-9]+$/", $v));});
			if (count($character_list) > 0)
			{
				$arg_list = array();
				$sql  = "INSERT INTO `episode_character` (`episode_id`, `character_id`) ";
				$sql .= "VALUES " . implode(",", array_fill(0, count($character_list), "(?, ?)"));
				foreach ($character_list as $v)
				{
					$arg_list[] = $episode_id;
					$arg_list[] = $v;
				}
				$this->query($sql, $arg_list);
			}

			// 戻り値
			$return_list = array(
//				'stage_id'   => $stage_id,
//				'name'       => $name,
//				'remarks'    => $remarks,
//				'tag_list'   => $tag_list,
			);
			return $return_list;
		}
		catch (Exception $e)
		{
			// todo::エラー処理
		}
	}

	public function set($param_list = array())
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
			$id             = trim($param_list['id']);
			$category       = isset($param_list['category']) ? trim($param_list['category']) : "0";
			$title          = trim($param_list['title']);
			$url            = trim($param_list['url']);
			$free_text      = trim($param_list['free_text']);
			$is_r18         = trim($param_list['is_r18']);
			$is_private     = trim($param_list['is_private']);
			$character_list = isset($param_list['character_list']) && is_array($param_list['character_list']) ? $param_list['character_list'] : array();

			// バリデート
			$err_list = array();
			if (!preg_match("/^[0-9]+$/", $id))
			{
				$err_list[] = "無効なデータです。最初からやり直してください。";
				return array('error_message_list' => $err_list);
			}
			else
			{
				$sql  = "SELECT `id`, `is_label` FROM `episode` WHERE `id` = ? AND `is_delete` <> 1 AND `stage_id` IN (SELECT `id` FROM `stage` WHERE `user_id` = ? ) ";
				$arg_list = array($id, $user_id);
				$r = $this->query($sql, $arg_list);
				if (count($r) != 1)
				{
					$err_list[] = "無効なデータです。最初からやり直してください。";
					return array('error_message_list' => $err_list);
				}
			}
			$is_label = $r[0]['is_label'];
			if ($r[0]['is_label'] == 1)
			{
				if (mb_strlen($title) == 0)
				{
					$err_list[] = "タイトルは必須です。";
				}
			}
			else
			{
				if (mb_strlen($title) == 0 && mb_strlen($url) == 0 && mb_strlen($free_text) == 0)
				{
					$err_list[] = "タイトル・URL・フリーテキストのいずれか一つは必須です。";
				}
				if (mb_strlen($title) > 32)
				{
					$err_list[] = "タイトルは32文字以内で入力してください。";
				}
				if ($url != "")
				{
					if (!(strpos($url, "http://") === 0 || strpos($url, "https://") === 0 || strpos($url, "//") === 0))
					{
						$err_list[] = "URLは、「http://」「https://」「//」のいずれかから開始してください。";
					}
				}
				if (mb_strlen($url) > 256)
				{
					$err_list[] = "URLは256文字以内で入力してください。";
				}
				if (mb_strlen($free_text) > 10000)
				{
					$err_list[] = "フリーテキストは10,000文字以内で入力してください。";
				}
			}
			if (count($err_list) > 0)
			{
				return array('error_message_list' => $err_list);
			}

			// 登録
			$arg_list = array();
			$sql  = "UPDATE `episode` ";
			$sql .= "SET `category`   = ?";
			$sql .= "   ,`title`      = ?";
			$sql .= "   ,`url`        = ?";
			$sql .= "   ,`free_text`  = ?";
			$sql .= "   ,`is_r18`     = ?";
			$sql .= "   ,`is_private` = ?";
			$sql .= "WHERE `id` = ? ";
			$arg_list[] = $category   == "" ? 0    : $category;
			$arg_list[] = $title      == "" ? null : $title;
			$arg_list[] = $url        == "" ? null : $url;
			$arg_list[] = $free_text  == "" ? null : $free_text;
			$arg_list[] = $is_r18     == 1  ? 1 : 0;
			$arg_list[] = $is_private == 0  ? 0 : 1;
			$arg_list[] = $id;
			$this->query($sql, $arg_list);

			// キャラクター登録
			// 一度全削除して再登録
			$sql  = "DELETE FROM `episode_character` ";
			$sql .= "WHERE `episode_id` = ? ";
			$arg_list = array($id);
			$this->query($sql, $arg_list);
			$character_list = array_filter($character_list, function($v){return(preg_match("/^[0-9]+$/", $v));});
			if (count($character_list) > 0)
			{
				$arg_list = array();
				$sql  = "INSERT INTO `episode_character` (`episode_id`, `character_id`) ";
				$sql .= "VALUES " . implode(",", array_fill(0, count($character_list), "(?, ?)"));
				foreach ($character_list as $v)
				{
					$arg_list[] = $id;
					$arg_list[] = $v;
				}
				$this->query($sql, $arg_list);
			}

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
			// ユーザID
			$user_id    = $this->getLoginId();
			if ($user_id === false)
			{
				return array('error_redirect' => "session");
			}

			// 引数
			$id_list = isset($param_list['id_list']) && is_array($param_list['id_list']) ? $param_list['id_list'] : array();

			// 更新
			$sql  = "UPDATE `episode` ";
			$sql .= "SET    `sort` = ? ";
			$sql .= "WHERE  `id` = ? ";
			$sql .= "AND    `stage_id` IN (SELECT `id` FROM `stage` WHERE `user_id` = ?) ";
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
			$return_list = array();
			return $return_list;
		}
		catch (Exception $e)
		{
			// todo::エラー処理
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
			// todo::エラー処理
		}
	}

	public function del($param_list = array())
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
			$id = trim($param_list['id']);

			// バリデート
			$err_list = array();
			if (!preg_match("/^[0-9]+$/", $id))
			{
				$err_list[] = "存在しないデータです。最初からやり直してください。1";
				return array('error_message_list' => $err_list);
			}
			else
			{
				$sql  = "SELECT `id` FROM `episode` WHERE `id` = ? AND `is_delete` <> 1 AND `stage_id` IN (SELECT `id` FROM `stage` WHERE `user_id` = ?) ";
				$arg_list = array($id, $user_id);
				$r = $this->query($sql, $arg_list);
				if (count($r) != 1)
				{
					$err_list[] = "存在しないデータです。最初からやり直してください。2";
					return array('error_message_list' => $err_list);
				}
			}
			if (count($err_list) > 0)
			{
				return array('error_message_list' => $err_list);
			}

			// 更新
			$arg_list = array();
			$sql  = "UPDATE `episode` ";
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
