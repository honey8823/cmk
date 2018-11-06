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

			// 取得（エピソード）・整形
			$sql  = "SELECT     `episode`.`id` ";
			$sql .= "          ,`episode`.`is_label` ";
			$sql .= "          ,`episode`.`category` ";
			$sql .= "          ,`episode`.`title` ";
			$sql .= "          ,`episode`.`url` ";
			$sql .= "          ,`episode`.`free_text` ";
			$sql .= "          ,`episode`.`is_r18` ";
			$sql .= "          ,`episode`.`create_stamp` ";
			$sql .= "          ,`episode`.`update_stamp` ";
			$sql .= "FROM       `episode` ";
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
				}
				$stage_list[0]['episode_list'] = $episode_list;
			}

			// 取得（キャラクター）・整形
			$arg_list = array();
			$sql  = "SELECT     `character`.`id` ";
			$sql .= "          ,`character`.`name` ";
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
					$stage_list[0]['character_list'][] = array(
						'id'    => $v['id'],
						'name'  => $v['name'],
					);
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
			$id = trim($param_list['id']);
			$login_id = trim($param_list['login_id']);

			$return_list = array();

			// ログイン中のユーザ情報
			// （R18の許可情報・お気に入りの取得用）
			$login_user_list = $this->getLoginUser("character", $id);

			// 取得（キャラクター）
			$sql  = "SELECT     `character`.`id` ";
			$sql .= "          ,`character`.`name` ";
			$sql .= "          ,`character`.`remarks` ";
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
				// 取得（タグ）
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
				$sql .= "INNER JOIN      `genre` ";
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

				// 取得（エピソード）
				// 対象ステージのラベルはすべて取得、ラベルでないものは該当キャラクターのもののみ取得
				$arg_list = array();
				$sql  = "SELECT   `episode`.`id` ";
				$sql .= "        ,`episode`.`stage_id` ";
				$sql .= "        ,`episode`.`is_label` ";
				$sql .= "        ,`episode`.`category` ";
				$sql .= "        ,`episode`.`title` ";
				$sql .= "        ,`episode`.`url` ";
				$sql .= "        ,`episode`.`free_text` ";
				$sql .= "FROM     `episode` ";
				$sql .= "WHERE    (`episode`.`id` IN (SELECT `episode_id` FROM `episode_character` WHERE `character_id` = ?) OR `episode`.`is_label` = 1) ";
				$arg_list[] = $id;
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
				foreach ($episode_list as $k => $v)
				{
					$v['url_view'] = $this->omitUrl($v['url']);
					$character_list[0]['stage_list'][$v['stage_id']]['episode_list'][] = $v;
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
				$sql .= "WHERE      `stage_tag`.`stage_id` IN (" . implode(",", array_fill(0, count($stage_list), "?")) . ") ";
				$sql .= "ORDER BY   `stage_tag`.`stage_id` ASC ";
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
