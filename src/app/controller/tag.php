<?php
class TagController extends Common
{
	public function table($param_list = array())
	{
		try
		{
			// 引数
			$is_category_tree = isset($param_list['is_category_tree']) ? $param_list['is_category_tree'] : "0";
			$category_list    = isset($param_list['category_list'])    ? $param_list['category_list']    : array();
			$user_id          = isset($param_list['user_id'])          ? $param_list['user_id']          : null;
			$stage_id         = isset($param_list['stage_id'])         ? $param_list['stage_id']         : null;

			// 取得
			$arg_list = array();
			$sql  = "SELECT     `tag`.`id` ";
			$sql .= "          ,`tag`.`category` ";
			$sql .= "          ,`tag`.`genre_id` ";
			$sql .= "          ,`genre`.`title` AS `genre_title` ";
			$sql .= "          ,`tag`.`name` ";
			$sql .= "          ,`tag`.`name_short` ";
			$sql .= "FROM       `tag` ";
			$sql .= "LEFT JOIN  `genre` ";
			$sql .= "  ON       `tag`.`genre_id` = `genre`.`id` ";
			$sql .= "WHERE      1=1 ";
			if (count($category_list) > 0)
			{
				$sql .= "AND  `tag`.`category` IN (" . implode(",", array_fill(0, count($category_list), "?")) . ") ";
				$arg_list = array_merge($arg_list, $category_list);
			}
			if ($user_id != "")
			{
				$sql .= "AND  (`tag`.`genre_id` IS NULL OR `tag`.`genre_id` IN (SELECT `genre_id` FROM `user_genre` WHERE `user_id` = ?)) ";
				$arg_list[] = $user_id;
			}
			if ($stage_id != "")
			{
				$sql .= "AND  `tag`.`id` IN (SELECT `tag_id` FROM `stage_tag` WHERE `stage_id` = ?) ";
				$arg_list[] = $stage_id;
			}
			$sql .= "ORDER BY   `tag`.`category` ASC ";
			$sql .= "          ,`genre`.`sort` ASC ";
			$sql .= "          ,`tag`.`sort` ASC ";
			$tmp_tag_list = $this->query($sql, $arg_list);

			// 整形
			$tag_list = array();
			if (count($tmp_tag_list) > 0)
			{
				$category_list = $this->getConfig("tag_category", "value");
				// カテゴリ階層に分ける場合
				if ($is_category_tree == "1")
				{
					foreach ($tmp_tag_list as $v)
					{
						$category_key = $category_list[$v['category']]['key'];
						$tag_list[$category_key]['value'] = $v['category'];
						$tag_list[$category_key]['key']   = $category_key;
						$tag_list[$category_key]['name']  = $category_list[$v['category']]['name'];

						$tag_list[$category_key]['tag_list'][] = array(
							'id'         => $v['id'],
							'name'       => $v['name'],
							'name_short' => $v['name_short'],
						);
					}
				}
				// カテゴリ階層に分けない場合
				else
				{
					foreach ($tmp_tag_list as $v)
					{
						$tag_list[] = array(
							'id'            => $v['id'],
							'category'      => $v['category'],
							'category_key'  => $category_list[$v['category']]['key'],
							'category_name' => $category_list[$v['category']]['name'],
							'name'          => $v['name'],
							'name_short'    => $v['name_short'],
						);
					}
				}
			}

			return $tag_list;
		}
		catch (Exception $e)
		{
			$this->exception($e);
		}
	}

	public function tableGenre($param_list = array())
	{
		try
		{
			$arg_list = array();
			$sql  = "SELECT   `id`, `title`, `remarks` ";
			$sql .= "FROM     `genre` ";
			$sql .= "ORDER BY `sort` ASC ";
			$genre_list = $this->query($sql, $arg_list);

			return array('genre_list' => $genre_list);
		}
		catch (Exception $e)
		{
			$this->exception($e);
		}
	}
}
