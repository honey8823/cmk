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
			// （R18の許可情報の取得用）
			$is_r18 = 0;
			$user_id = $this->getLoginId();
			if ($user_id != false)
			{
				$sql  = "SELECT `is_r18` FROM `user` WHERE `id` = ? ";
				$arg_list = array($user_id);
				$user_list = $this->query($sql, $arg_list);
				if (count($user_list) == 1 && $user_list[0]['is_r18'] == 1)
				{
					$is_r18 = 1;
				}
			}
			
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
			if ($is_r18 != 1)
			{
				$sql .= "AND        `episode`.`is_r18` <> 1 ";
			}
			$sql .= "ORDER BY   `episode`.`sort` = 0 ASC ";
			$sql .= "          ,`episode`.`sort` ASC ";
			$arg_list = array($id);
			$episode_list = $this->query($sql, $arg_list);
			$stage_list[0]['episode_list'] = array();
			if (count($episode_list) > 0)
			{
				// 長文省略整形
				foreach ($episode_list as $k => $v)
				{
					$episode_list[$k]['free_text_full'] = "";
					$cursor = mb_strpos($v['free_text'], "=====");
					if ($cursor !== false)
					{
						$episode_list[$k]['free_text_full'] = str_replace("=====", "", $v['free_text']);
						$episode_list[$k]['free_text']      = mb_substr($v['free_text'], 0, $cursor);
					}
				}
				$stage_list[0]['episode_list'] = $episode_list;
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
			$sql .= "AND        `character`.`is_private` <> 1 ";
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
			// todo::エラー処理
		}
	}
}
