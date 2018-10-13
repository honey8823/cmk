<?php
class TagController extends Common
{
	public function table($param_list = array())
	{
		try
		{
			// 引数
			$category_list = isset($param_list['category_list']) ? $param_list['category_list'] : array();

			$arg_list = array();
			$sql  = "SELECT   `id`, `category`, `name`, `name_short` ";
			$sql .= "FROM     `tag` ";
			$sql .= "WHERE    1=1 ";
			if (count($category_list) > 0)
			{
				$sql .= "AND  `category` IN (" . implode(",", array_fill(0, count($category_list), "?")) . ") ";
				$arg_list = array_merge($arg_list, $category_list);
			}
			$sql .= "ORDER BY `category` ASC, `sort` ASC ";
			$tag_list = $this->query($sql, $arg_list);

			return $tag_list;

		}
		catch (Exception $e)
		{
			// todo::エラー処理
		}
	}
}
