<?php
class TagController extends Common
{
	public function table($param_list = array())
	{
		try
		{
			// 引数
			$category_list = isset($param_list['category_list']) ? $param_list['category_list'] : array();
			$user_id       = isset($param_list['user_id'])       ? $param_list['user_id']       : null;

			$arg_list = array();
			$sql  = "SELECT   `id`, `category`, `genre_id`, `name`, `name_short` ";
			$sql .= "FROM     `tag` ";
			$sql .= "WHERE    1=1 ";
			if (count($category_list) > 0)
			{
				$sql .= "AND  `category` IN (" . implode(",", array_fill(0, count($category_list), "?")) . ") ";
				$arg_list = array_merge($arg_list, $category_list);
			}
			if ($user_id != "")
			{
				$sql .= "AND  `genre_id` IN (SELECT `genre_id` FROM `user_genre` WHERE `user_id` = ?) ";
				$arg_list[] = $user_id;
			}
			$sql .= "ORDER BY `category` ASC, `genre_id` ASC, `sort` ASC ";
			$tag_list = $this->query($sql, $arg_list);

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
