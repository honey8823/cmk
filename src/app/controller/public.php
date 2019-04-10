<?php
class PublicController extends Common
{
	public function getStage($param_list = array())
	{
		try
		{
			// 引数
			$id = trim($param_list['id']);
			$login_id = trim($param_list['login_id']);

			$return_list = array();

			// ログイン中のユーザ情報
			// （R18の許可情報・お気に入りの取得用）
			$login_user_list = $this->getLoginUser("stage", $id);

			// 取得（ステージ）
			$sql  = "SELECT     `stage`.`id` ";
			$sql .= "          ,`stage`.`name` ";
			$sql .= "          ,`stage`.`remarks` ";
			$sql .= "          ,`stage`.`create_stamp` ";
			$sql .= "          ,`stage`.`update_stamp` ";
			$sql .= "          ,`user`.`id` AS `user_id` ";
			$sql .= "          ,`user`.`name` AS `user_name` ";
			$sql .= "          ,`user`.`login_id` AS `user_login_id` ";
			$sql .= "FROM       `stage` ";
			$sql .= "INNER JOIN `user` ON  `stage`.`user_id` = `user`.`id` ";
			$sql .= "                  AND `user`.`login_id` = ? ";
			$sql .= "                  AND `user`.`is_delete` <> 1 ";
			$sql .= "WHERE     `stage`.`id` = ? ";
			$sql .= "AND       `stage`.`is_private` <> 1 ";
			$sql .= "AND       `stage`.`is_delete` <> 1 ";
			$arg_list = array(
				$login_id,
				$id,
			);
			$stage_list = $this->query($sql, $arg_list);
			if(count($stage_list) != 1)
			{
				return array('error_redirect' => "notfound");
			}

			// 取得（タグ）・整形
			$tc = new TagController();
			$stage_list[0]['tag_list'] = $tc->table(array('stage_id' => $id));

			// 取得（エピソード）・整形
			$sql  = "SELECT     `episode`.`id` ";
			$sql .= "          ,`episode`.`type` ";
			$sql .= "          ,`episode`.`title` ";
			$sql .= "          ,`episode`.`url` ";
			$sql .= "          ,`episode`.`free_text` ";
			$sql .= "          ,`episode`.`is_r18` ";
			$sql .= "          ,`episode`.`create_stamp` ";
			$sql .= "          ,`episode`.`update_stamp` ";
			$sql .= "          ,`character_episode`.`character_id_list` ";
			$sql .= "FROM       `episode` ";
			$sql .= "LEFT JOIN  ( SELECT   `character_profile_episode`.`episode_id`, GROUP_CONCAT(`character_profile_episode`.`character_id`) AS `character_id_list` ";
			$sql .= "             FROM     `character_profile_episode` ";
			$sql .= "             GROUP BY `episode_id` ";
			$sql .= "           ) AS `character_episode` ON `episode`.`id` = `character_episode`.`episode_id` ";
			$sql .= "WHERE      `episode`.`stage_id` = ? ";
			$sql .= "AND        `episode`.`is_delete` <> 1 ";
			$sql .= "AND        `episode`.`is_private` <> 1 ";
			if ($login_user_list['is_r18'] != 1)
			{
				$sql .= "AND        `episode`.`is_r18` <> 1 ";
			}
			$sql .= "ORDER BY   `episode`.`sort` = 0 ASC ";
			$sql .= "          ,`episode`.`sort` ASC ";
			$arg_list = array($id);
			$episode_list = $this->query($sql, $arg_list);

			// 整形
			$category_list = $this->getConfig("episode_type", "value");
			$stage_list[0]['episode_list'] = array();
			if (count($episode_list) > 0)
			{
				foreach ($episode_list as $k => $v)
				{
					// 長文省略整形
					$episode_list[$k]['free_text_full'] = "";
					$cursor = mb_strpos($v['free_text'], "=====");
					if ($cursor !== false)
					{
						$episode_list[$k]['free_text_full'] = str_replace("=====", "", $v['free_text']);
						$episode_list[$k]['free_text']      = mb_substr($v['free_text'], 0, $cursor);
					}

					// URL省略整形
					$episode_list[$k]['url_view'] = $this->omitUrl($v['url']);
					$episode_list[$k]['type_key'] = $category_list[$v['type']]['key'];

					// オーバーライドされているキャラクター
					$episode_list[$k]['character_id_list'] = array_unique(explode(",", $v['character_id_list']));
				}
				$stage_list[0]['episode_list'] = $episode_list;
			}

			// 取得（キャラクター）・整形
			$arg_list = array();
			$sql  = "SELECT     `character`.`id` ";
			$sql .= "          ,`character`.`name` ";
			$sql .= "          ,`character`.`remarks` ";
			$sql .= "          ,`character`.`image` ";
			$sql .= "FROM       `stage_character` ";
			$sql .= "INNER JOIN `character` ";
			$sql .= "  ON       `stage_character`.`character_id` = `character`.`id` ";
			$sql .= "WHERE      `stage_character`.`stage_id` = ? ";
			$sql .= "AND        `character`.`is_delete` <> 1 ";
			$sql .= "AND        `character`.`is_private` <> 1 ";
			$sql .= "ORDER BY   `stage_character`.`sort` = 0 ASC ";
			$sql .= "          ,`stage_character`.`sort` ASC ";
			$arg_list = array($id);
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
			$stage_list[0]['relation_list'] = array();
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
						if ($v2['is_arrow_a'] == "1" || $v2['is_arrow_b'] == "1" || $v2['is_arrow_c'] == "1")
						{
							$stage_list[0]['relation_list'][] = $v2;
						}
					}
				}
			}

			// 戻り値
			$return_list['stage'] = $stage_list[0];
			$return_list['is_login']    = $login_user_list['is_login'];
			$return_list['is_favorite'] = $login_user_list['is_favorite'];

			return $return_list;
		}
		catch (Exception $e)
		{
			$this->exception($e);
		}
	}

	public function getCharacter($param_list = array())
	{
		try
		{
			// 引数
			$id       = trim($param_list['id']);
			$login_id = trim($param_list['login_id']);

			$return_list = array();

			// ログイン中のユーザ情報
			// （R18の許可情報・お気に入りの取得用）
			$login_user_list = $this->getLoginUser("character", $id);

			// 取得（キャラクターとユーザーID）
			$sql  = "SELECT     `character`.`id` ";
			$sql .= "          ,`character`.`name` ";
			$sql .= "          ,`character`.`remarks` ";
			$sql .= "          ,`character`.`image` ";
			$sql .= "          ,`character`.`create_stamp` ";
			$sql .= "          ,`character`.`update_stamp` ";
			$sql .= "          ,`user`.`id` AS `user_id` ";
			$sql .= "          ,`user`.`name` AS `user_name` ";
			$sql .= "          ,`user`.`login_id` AS `user_login_id` ";
			$sql .= "FROM       `character` ";
			$sql .= "INNER JOIN `user` ON  `character`.`user_id` = `user`.`id` ";
			$sql .= "                  AND `user`.`login_id` = ? ";
			$sql .= "                  AND `user`.`is_delete` <> 1 ";
			$sql .= "WHERE     `character`.`id` = ? ";
			$sql .= "AND       `character`.`is_private` <> 1 ";
			$sql .= "AND       `character`.`is_delete` <> 1 ";
			$arg_list = array(
				$login_id,
				$id,
			);
			$character_list = $this->query($sql, $arg_list);
			if(count($character_list) != 1)
			{
				return array('error_redirect' => "notfound");
			}

			// 取得（プロフィール）
			$q_list = $this->getConfig("character_profile_q", "value");
			$sql  = "SELECT     `character_profile`.`question` ";
			$sql .= "          ,`character_profile`.`answer` ";
			$sql .= "FROM       `character_profile` ";
			$sql .= "WHERE      `character_profile`.`character_id` = ? ";
			$sql .= "AND        `character_profile`.`answer` <> '' ";
			$sql .= "ORDER BY   `character_profile`.`sort` = 0 ASC ";
			$sql .= "          ,`character_profile`.`sort` ASC ";
			$sql .= "          ,`character_profile`.`create_stamp` ASC ";
			$arg_list = array($id);
			$profile_list = $this->query($sql, $arg_list);
			$character_list[0]['profile_list'] = array();
			if (count($profile_list) > 0)
			{
				foreach ($profile_list as $v)
				{
					$character_list[0]['profile_list'][] = array(
						'question'       => $v['question'],
						'question_title' => $q_list[$v['question']]['title'],
						'answer'         => $v['answer'],
					);
				}
			}

			// 取得（ステージ）
			$sql  = "SELECT     `stage`.`id` ";
			$sql .= "          ,`stage`.`name` ";
			$sql .= "          ,`stage`.`create_stamp` ";
			$sql .= "          ,`stage`.`update_stamp` ";
			$sql .= "FROM       `stage` ";
			$sql .= "INNER JOIN `stage_character` ON  `stage`.`id` = `stage_character`.`stage_id` ";
			$sql .= "WHERE      `stage_character`.`character_id` = ? ";
			$sql .= "AND        `stage`.`is_private` <> 1 ";
			$sql .= "AND        `stage`.`is_delete` <> 1 ";
			$sql .= "ORDER BY   `stage`.`sort` = 0 ASC ";
			$sql .= "          ,`stage`.`sort` ASC ";
			$arg_list = array(
				$id,
			);
			$character_list[0]['stage_list'] = $this->setArrayKey($this->query($sql, $arg_list), "id");

			$character_list[0]['tag_list'] = array();
			if (count($character_list[0]['stage_list']) > 0)
			{
				// 取得（ステージのタグ）
				$arg_list = array();
				$sql  = "SELECT          `tag`.`id` ";
				$sql .= "               ,`tag`.`category` ";
				$sql .= "               ,`genre`.`id` AS `genre_id` ";
				$sql .= "               ,`genre`.`title` AS `genre_title` ";
				$sql .= "               ,`tag`.`name` ";
				$sql .= "               ,`tag`.`name_short` ";
				$sql .= "FROM            `stage_tag` ";
				$sql .= "INNER JOIN      `tag` ";
				$sql .= "  ON            `stage_tag`.`tag_id` = `tag`.`id` ";
				$sql .= "LEFT JOIN       `genre` ";
				$sql .= "  ON            `tag`.`genre_id` = `genre`.`id` ";
				$sql .= "WHERE           `stage_tag`.`stage_id` IN (" . implode(",", array_fill(0, count($character_list[0]['stage_list']), "?")) . ") ";
				$sql .= "ORDER BY        `tag`.`category` ASC ";
				$sql .= "               ,`genre`.`sort` ASC ";
				$sql .= "               ,`tag`.`sort` ASC ";
				$arg_list = array_column($character_list[0]['stage_list'], "id");
				$tag_list = array_unique($this->query($sql, $arg_list), SORT_REGULAR);
				if (count($tag_list) > 0)
				{
					$category_list = $this->getConfig("tag_category", "value");
					foreach ($tag_list as $v)
					{
						if ($category_list[$v['category']]['key'] == "series")
						{
							// シリーズタグのみ使用する
							$character_list[0]['tag_list'][] = array(
								'id'            => $v['id'],
								'category'      => $v['category'],
								'category_key'  => $category_list[$v['category']]['key'],
								'category_name' => $category_list[$v['category']]['name'],
								'genre_id'      => $v['genre_id'],
								'genre_title'   => $v['genre_title'],
								'name'          => $v['name'],
								'name_short'    => $v['name_short'],
							);
						}
					}
				}

				// 取得（エピソード）
				// 対象ステージのラベルはすべて取得、ラベルでないものは該当キャラクターのもののみ取得
				$category_list = $this->getConfig("episode_type", "key");
				$arg_list = array();
				$sql  = "SELECT   `episode`.`id` ";
				$sql .= "        ,`episode`.`stage_id` ";
				$sql .= "        ,`episode`.`type` ";
				$sql .= "        ,`episode`.`title` ";
				$sql .= "        ,`episode`.`url` ";
				$sql .= "        ,`episode`.`free_text` ";
				$sql .= "FROM     `episode` ";
				$sql .= "WHERE    (`episode`.`id` IN (SELECT `episode_id` FROM `episode_character` WHERE `character_id` = ?) OR `episode`.`type` = ?) ";
				$arg_list[] = $id;
				$arg_list[] = $category_list['label']['value'];
				$sql .= "AND      `episode`.`is_delete` <> 1 ";
				$sql .= "AND      `episode`.`is_private` <> 1 ";
				if ($login_user_list['is_r18'] != 1)
				{
					$sql .= "AND  `episode`.`is_r18` <> 1 ";
				}
				$sql .= "AND      `episode`.`stage_id` IN (" . implode(",", array_fill(0, count($character_list[0]['stage_list']), "?")) . ") ";
				$arg_list = array_merge($arg_list, array_column($character_list[0]['stage_list'], "id"));
				$sql .= "ORDER BY `episode`.`stage_id` ASC ";
				$sql .= "        ,`episode`.`sort` = 0 ASC ";
				$sql .= "        ,`episode`.`sort` ASC ";
				$sql .= "        ,`episode`.`id` ASC ";
				$episode_list = $this->query($sql, $arg_list);

				// 整形
				$category_list = $this->getConfig("episode_type", "value");
				foreach ($episode_list as $k => $v)
				{
					$v['url_view'] = $this->omitUrl($v['url']);
					$v['type_key'] = $category_list[$v['type']]['key'];
					$character_list[0]['stage_list'][$v['stage_id']]['episode_list'][] = $v;
				}
			}

			// 取得（相関図：他キャラクター）・整形
			$sql  = "SELECT     `character`.`id` AS `character_id` ";
			$sql .= "          ,`character`.`name` AS `character_name` ";
			$sql .= "          ,`character`.`image` AS `character_image` ";
			$sql .= "FROM       `character` ";
			$sql .= "WHERE      `character`.`user_id` = ? ";
			$sql .= "AND        `character`.`is_delete` <> 1 ";
			$sql .= "AND        `character`.`is_private` <> 1 ";
			$sql .= "AND        `character`.`id` <> ? ";
			$sql .= "ORDER BY   `character`.`sort` = 0 ASC ";
			$sql .= "          ,`character`.`sort` ASC ";
			$sql .= "          ,`character`.`id` ASC ";
			$arg_list = array($character_list[0]['user_id'], $id);
			$character_list[0]['relation_list'] = $this->setArrayKey($this->query($sql, $arg_list), "character_id");
			foreach ($character_list[0]['relation_list'] as $k => $v)
			{
				$character_list[0]['relation_list'][$k]['title_a']     = "";
				$character_list[0]['relation_list'][$k]['free_text_a'] = "";
				$character_list[0]['relation_list'][$k]['is_arrow_a']  = "0";
				$character_list[0]['relation_list'][$k]['title_b']     = "";
				$character_list[0]['relation_list'][$k]['free_text_b'] = "";
				$character_list[0]['relation_list'][$k]['is_arrow_b']  = "0";
				$character_list[0]['relation_list'][$k]['title_c']     = "";
				$character_list[0]['relation_list'][$k]['free_text_c'] = "";
				$character_list[0]['relation_list'][$k]['is_arrow_c']  = "0";
			}

			// 取得（相関図：内容）・整形
			if (count($character_list[0]['relation_list']) > 0)
			{
				$sql  = "SELECT     `character_relation`.`character_id_from` ";
				$sql .= "          ,`character_relation`.`character_id_to` ";
				$sql .= "          ,`character_relation`.`is_both` ";
				$sql .= "          ,`character_relation`.`title` ";
				$sql .= "          ,`character_relation`.`free_text` ";
				$sql .= "FROM       `character_relation` ";
				$sql .= "WHERE      `character_relation`.`character_id_from` = ? ";
				$sql .= "OR         `character_relation`.`character_id_to`   = ? ";
				$arg_list = array(
					$id,
					$id,
				);
				$tmp_relation_list = $this->query($sql, $arg_list);
				foreach ($tmp_relation_list as $v)
				{
					if ($v['character_id_from'] == $id)
					{
						if (!isset($character_list[0]['relation_list'][$v['character_id_to']]))
						{
							continue;
						}
						$character_list[0]['relation_list'][$v['character_id_to']]['title_a']        = $v['title'];
						$character_list[0]['relation_list'][$v['character_id_to']]['free_text_a']    = $v['free_text'];
						$character_list[0]['relation_list'][$v['character_id_to']]['is_arrow_c']    |= $v['is_both'];
						if ($v['title'] != "" || $v['free_text'] != "")
						{
							$character_list[0]['relation_list'][$v['character_id_to']]['is_arrow_a'] = "1";
						}
						if ($character_list[0]['relation_list'][$v['character_id_to']]['title_c'] == "")
						{
							$character_list[0]['relation_list'][$v['character_id_to']]['title_c'] = $v['title'];
						}
					}
					else
					{
						if (!isset($character_list[0]['relation_list'][$v['character_id_from']]))
						{
							continue;
						}
						$character_list[0]['relation_list'][$v['character_id_from']]['title_b']      = $v['title'];
						$character_list[0]['relation_list'][$v['character_id_from']]['free_text_b']  = $v['free_text'];
						$character_list[0]['relation_list'][$v['character_id_from']]['is_arrow_c']  |= $v['is_both'];
						if ($v['title'] != "" || $v['free_text'] != "")
						{
							$character_list[0]['relation_list'][$v['character_id_from']]['is_arrow_b'] = "1";
						}
						if ($character_list[0]['relation_list'][$v['character_id_from']]['title_c'] == "")
						{
							$character_list[0]['relation_list'][$v['character_id_from']]['title_c'] = $v['title'];
						}
					}
				}
				// 未設定のキャラクターは省く
				foreach ($character_list[0]['relation_list'] as $k => $v)
				{
					if ($v['is_arrow_a'] != "1" && $v['is_arrow_b'] != "1" && $v['is_arrow_c'] != "1")
					{
						unset($character_list[0]['relation_list'][$k]);
					}
				}
			}

			// 戻り値
			$return_list['character'] = $character_list[0];
			$return_list['is_login']    = $login_user_list['is_login'];
			$return_list['is_favorite'] = $login_user_list['is_favorite'];

			return $return_list;
		}
		catch (Exception $e)
		{
			$this->exception($e);
		}
	}

	public function getCharacterOverride($param_list = array())
	{
		try
		{
			// 引数
			$id         = trim($param_list['id']);
			$login_id   = trim($param_list['login_id']);
			$stage_id   = trim($param_list['stage']);
			$episode_id = trim($param_list['episode']);

			if (!preg_match("/^[0-9]+$/", $stage_id))
			{
				return array('error_redirect' => "notfound");
			}

			$return_list = array();

			// 取得（キャラクター）
			$sql  = "SELECT     `character`.`id` ";
			$sql .= "          ,`character`.`name` ";
			$sql .= "          ,`character`.`remarks` ";
			$sql .= "          ,`character`.`image` ";
			$sql .= "          ,`character`.`create_stamp` ";
			$sql .= "          ,`character`.`update_stamp` ";
			$sql .= "          ,`user`.`id` AS `user_id` ";
			$sql .= "          ,`user`.`name` AS `user_name` ";
			$sql .= "          ,`user`.`login_id` AS `user_login_id` ";
			$sql .= "FROM       `character` ";
			$sql .= "INNER JOIN `user` ON  `character`.`user_id` = `user`.`id` ";
			$sql .= "                  AND `user`.`login_id` = ? ";
			$sql .= "                  AND `user`.`is_delete` <> 1 ";
			$sql .= "WHERE     `character`.`id` = ? ";
			$sql .= "AND       `character`.`is_private` <> 1 ";
			$sql .= "AND       `character`.`is_delete` <> 1 ";
			$arg_list = array(
				$login_id,
				$id,
			);
			$character_list = $this->query($sql, $arg_list);
			if(count($character_list) != 1)
			{
				return array('error_redirect' => "notfound");
			}

			// 取得（ステージ）
			$sql  = "SELECT     `stage`.`id` ";
			$sql .= "          ,`stage`.`name` ";
			$sql .= "          ,`stage`.`create_stamp` ";
			$sql .= "          ,`stage`.`update_stamp` ";
			$sql .= "FROM       `stage` ";
			$sql .= "INNER JOIN `stage_character` ON  `stage`.`id` = `stage_character`.`stage_id` ";
			$sql .= "                             AND `stage_character`.`character_id` = ? ";
			$sql .= "WHERE      `stage`.`id` = ? ";
			$sql .= "AND        `stage`.`is_private` <> 1 ";
			$sql .= "AND        `stage`.`is_delete` <> 1 ";
			$arg_list = array(
				$id,
				$stage_id,
			);
			$stage_list = $this->query($sql, $arg_list);
			if (count($stage_list) != 1)
			{
				return array('error_redirect' => "notfound");
			}

			// 取得（プロフィール：基本）
			$sql  = "SELECT     `character_profile`.`question` ";
			$sql .= "          ,`character_profile`.`answer` ";
			$sql .= "FROM       `character_profile` ";
			$sql .= "WHERE      `character_profile`.`character_id` = ? ";
			$sql .= "ORDER BY   `character_profile`.`sort` = 0 ASC ";
			$sql .= "          ,`character_profile`.`sort` ASC ";
			$sql .= "          ,`character_profile`.`create_stamp` ASC ";
			$arg_list = array($id);
			$profile_list = $this->setArrayKey($this->query($sql, $arg_list), "question");

			// 取得（プロフィール：オーバーライド：ステージ）・マージ
			$sql  = "SELECT     `character_profile_stage`.`question` ";
			$sql .= "          ,`character_profile_stage`.`answer` ";
			$sql .= "FROM       `character_profile_stage` ";
			$sql .= "WHERE      `character_profile_stage`.`character_id` = ? ";
			$sql .= "AND        `character_profile_stage`.`stage_id` = ? ";
			$sql .= "ORDER BY   `character_profile_stage`.`sort` = 0 ASC ";
			$sql .= "          ,`character_profile_stage`.`sort` ASC ";
			$sql .= "          ,`character_profile_stage`.`create_stamp` ASC ";
			$arg_list = array($id, $stage_id);
			$profile_stage_list = $this->query($sql, $arg_list);
			foreach ($profile_stage_list as $v)
			{
				$profile_list[$v['question']]['question'] = $v['question'];
				$profile_list[$v['question']]['answer']   = $v['answer'];
			}

			// エピソードIDの指定がある場合はさらに取得・マージ
			if (preg_match("/^[0-9]+$/", $episode_id))
			{
				$sql  = "SELECT   `episode`.`id` ";
				$sql .= "        ,`episode`.`type` ";
				$sql .= "        ,`episode`.`title` ";
				$sql .= "FROM     `episode` ";
				$sql .= "WHERE    `episode`.`stage_id` = ? ";
				$sql .= "AND      `episode`.`is_delete` <> 1 ";
				$sql .= "AND      `episode`.`is_private` <> 1 ";
				$sql .= "ORDER BY `episode`.`sort` = 0 ASC ";
				$sql .= "        ,`episode`.`sort` ASC ";
				$sql .= "        ,`episode`.`id` ASC ";
				$arg_list = array(
					$stage_id,
				);
				$episode_list = $this->query($sql, $arg_list);

				// 指定ID以前の時系列、かつオーバーライド区分であるエピソードのIDのみに絞り込む
				$type_list = $this->getConfig("episode_type", "key");
				$is_found = false;
				$episode_id_list = array();
				foreach ($episode_list as $k => $v)
				{
					if ($is_found != true && $v['type'] == $type_list['override']['value'])
					{
						$episode_id_list[] = $v['id'];
					}
					if ($v['id'] == $episode_id)
					{
						$is_found = true;
						$stage_list[0]['episode_id']    = $episode_id;
						$stage_list[0]['episode_title'] = $v['title'];
					}
				}

				// 指定IDが正しく指定されていた場合のみ、対象エピソードのプロフィールを取得・マージ
				if ($is_found == true && count($episode_id_list) > 0)
				{
					// エピソードIDの並び順の配列をつくる
					$episode_layer_list = array_combine($episode_id_list, array_fill(0, count($episode_id_list), array()));

					// 取得（プロフィール：オーバーライド：エピソード）
					$arg_list = array();
					$sql  = "SELECT     `character_profile_episode`.`episode_id` ";
					$sql .= "          ,`character_profile_episode`.`question` ";
					$sql .= "          ,`character_profile_episode`.`answer` ";
					$sql .= "FROM       `character_profile_episode` ";
					$sql .= "WHERE      `character_profile_episode`.`character_id` = ? ";
					$sql .= "AND        `character_profile_episode`.`episode_id` IN (" . implode(",", array_fill(0, count($episode_id_list), "?")) . ") ";
					$sql .= "ORDER BY   `character_profile_episode`.`sort` = 0 ASC ";
					$sql .= "          ,`character_profile_episode`.`sort` ASC ";
					$sql .= "          ,`character_profile_episode`.`create_stamp` ASC ";
					$arg_list[] = $id;
					$arg_list = array_merge($arg_list, $episode_id_list);

					// エピソード順に整理
					// 時系列順で最新のものをマージしたいため
					$profile_episode_list = $this->query($sql, $arg_list);
					foreach ($profile_episode_list as $v)
					{
						$episode_layer_list[$v['episode_id']][] = array(
							'question' => $v['question'],
							'answer'   => $v['answer'],
						);
					}

					// マージ
					foreach ($episode_layer_list as $episode)
					{
						foreach ($episode as $v)
						{
							$profile_list[$v['question']]['question'] = $v['question'];
							$profile_list[$v['question']]['answer']   = $v['answer'];
						}
					}
				}
			}

			// プロフィールの整形
			$q_list = $this->getConfig("character_profile_q", "value");
			foreach ($profile_list as $k => $v)
			{
				$profile_list[$k]['question_title'] = $q_list[$k]['title'];
			}

			// キーの削除
			$profile_list = array_values($profile_list);

			// 戻り値
			$return_list['character']    = $character_list[0];
			$return_list['stage']        = $stage_list[0];
			$return_list['profile_list'] = $profile_list;

			return $return_list;
		}
		catch (Exception $e)
		{
			$this->exception($e);
		}
	}

	public function tableUser($param_list = array())
	{
		try
		{
			$return_list = array();

			// 取得（ユーザー）
			$sql  = "SELECT   `user`.`id`  ";
			$sql .= "        ,`user`.`name` ";
			$sql .= "        ,`user`.`login_id` ";
			$sql .= "        ,`user`.`twitter_id` ";
			$sql .= "        ,`user`.`pixiv_id` ";
			$sql .= "        ,`user`.`remarks` ";
			$sql .= "        ,`user`.`image` ";
			$sql .= "        ,`user`.`login_stamp` ";
			$sql .= "FROM     `user` ";
			$sql .= "WHERE    `user`.`is_delete` <> 1 ";
			$sql .= "ORDER BY `user`.`login_stamp` DESC ";
			$user_list = common::setArrayKey($this->query($sql), "id");

			// 取得（ジャンル）
			if (count($user_list) > 0)
			{
				$sql  = "SELECT     `user_genre`.`user_id` ";
				$sql .= "          ,`genre`.`id` ";
				$sql .= "          ,`genre`.`title` ";
				$sql .= "FROM       `user_genre` ";
				$sql .= "INNER JOIN `genre` ON `user_genre`.`genre_id` = `genre`.`id` ";
				$sql .= "WHERE      `user_genre`.`user_id` IN (" . implode(",", array_fill(0, count($user_list), "?")) . ") ";
				$sql .= "ORDER BY   `genre`.`sort` ASC ";
				$arg_list = array_column($user_list, "id");
				$genre_list = $this->query($sql, $arg_list);
				foreach ($genre_list as $v)
				{
					$user_list[$v['user_id']]['genre_list'][] = array(
						'id'    => $v['id'],
						'title' => $v['title'],
					);
				}
			}

			$return_list['user_list'] = $user_list;

			return $return_list;
		}
		catch (Exception $e)
		{
			$this->exception($e);
		}
	}

	public function getUser($param_list = array())
	{
		try
		{
			// 引数
			$login_id = trim($param_list['login_id']);

			$return_list = array();

			// 取得（ユーザー）
			$sql  = "SELECT `user`.`id`  ";
			$sql .= "      ,`user`.`name` ";
			$sql .= "      ,`user`.`login_id` ";
			$sql .= "      ,`user`.`twitter_id` ";
			$sql .= "      ,`user`.`pixiv_id` ";
			$sql .= "      ,`user`.`remarks` ";
			$sql .= "      ,`user`.`image` ";
			$sql .= "      ,`user`.`login_stamp` ";
			$sql .= "FROM   `user` ";
			$sql .= "WHERE `user`.`login_id` = ? ";
			$sql .= "AND   `user`.`is_delete` <> 1 ";
			$arg_list = array(
				$login_id,
			);
			$user_list = $this->query($sql, $arg_list);
			if(count($user_list) != 1)
			{
				return array('error_redirect' => "notfound");
			}

			$id = $user_list[0]['id'];

			// ログイン中のユーザ情報
			// （R18の許可情報・お気に入りの取得用）
			$login_user_list = $this->getLoginUser("user", $id);

			// 取得（ジャンル）
			$sql  = "SELECT     `genre`.`id` ";
			$sql .= "          ,`genre`.`title` ";
			$sql .= "FROM       `user_genre` ";
			$sql .= "INNER JOIN `genre` ON `user_genre`.`genre_id` = `genre`.`id` ";
			$sql .= "WHERE      `user_genre`.`user_id` = ? ";
			$sql .= "ORDER BY   `genre`.`sort` ASC ";
			$arg_list = array($id);
			$genre_list = $this->query($sql, $arg_list);

			// 取得（ステージ）
			$sql  = "SELECT   `stage`.`id` ";
			$sql .= "        ,`stage`.`name` ";
			$sql .= "        ,`stage`.`remarks` ";
			$sql .= "FROM     `stage` ";
			$sql .= "WHERE    `stage`.`user_id` = ? ";
			$sql .= "AND      `stage`.`is_private` <> 1 ";
			$sql .= "AND      `stage`.`is_delete` <> 1 ";
			$sql .= "ORDER BY `stage`.`sort` = 0 ASC ";
			$sql .= "        ,`stage`.`sort` ASC ";
			$arg_list = array($id);
			$stage_list = $this->query($sql, $arg_list);

			// 取得（キャラクター）・整形
			$sql  = "SELECT     `character`.`id` ";
			$sql .= "          ,`character`.`name` ";
			$sql .= "          ,`character`.`remarks` ";
			$sql .= "          ,`character`.`image` ";
			$sql .= "FROM       `character` ";
			$sql .= "WHERE      `character`.`user_id` = ? ";
			$sql .= "AND        `character`.`is_delete` <> 1 ";
			$sql .= "AND        `character`.`is_private` <> 1 ";
			$sql .= "ORDER BY   `character`.`sort` = 0 ASC ";
			$sql .= "          ,`character`.`sort` ASC ";
			$arg_list = array($id);
			$character_list = $this->query($sql, $arg_list);

			// 取得（ステージタグ）
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
			$return_list['user']           = $user_list[0];
			$return_list['genre_list']     = $genre_list;
			$return_list['stage_list']     = $stage_list;
			$return_list['character_list'] = $character_list;
			$return_list['is_login']       = $login_user_list['is_login'];
			$return_list['is_favorite']    = $login_user_list['is_favorite'];

			return $return_list;
		}
		catch (Exception $e)
		{
			$this->exception($e);
		}
	}

	/*
	 * ログイン中ユーザの情報取得
	 * @param $favorite_type_key  お気に入りかどうかをチェックしたいデータの区分（user, stage, character のいずれか）
	 * @param $favorite_target_id お気に入りかどうかをチェックしたいデータのID（user.id, stage.id, character.id）
	 */
	private function getLoginUser($favorite_type_key = "", $favorite_target_id = "")
	{
		$return_list = array(
			'is_login'    => 0,
			'is_r18'      => 0,
			'is_favorite' => 0,
		);

		$user_id = $this->getLoginId();
		if ($user_id != false)
		{
			// お気に入りタイプ
			$favorite_type_list = $this->getConfig("favorite_type", "key");

			$sql  = "SELECT    `user`.`is_r18` ";
			$sql .= "         ,`favorite`.`id` ";
			$sql .= "FROM      `user` ";
			$sql .= "LEFT JOIN `favorite` ON  `user`.`id` = `favorite`.`user_id` ";
			$sql .= "                     AND `favorite`.`type` = ? ";
			$sql .= "                     AND `favorite`.`id` = ? ";
			$sql .= "WHERE     `user`.`id` = ? ";
			$arg_list = array(
				$favorite_type_list[$favorite_type_key]['value'],
				$favorite_target_id,
				$user_id,
			);
			$user_list = $this->query($sql, $arg_list);
			if (count($user_list) == 1)
			{
				$return_list['is_login'] = 1;
				if ($user_list[0]['is_r18'] == 1)
				{
					$return_list['is_r18'] = 1;
				}
				if ($user_list[0]['id'] != "")
				{
					$return_list['is_favorite'] = 1;
				}
			}
		}

		return $return_list;
	}
}
