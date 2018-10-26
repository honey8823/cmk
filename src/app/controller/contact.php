<?php
class ContactController extends Common
{
	public function add($param_list = array())
	{
		try
		{
			// 引数
			$content = trim($param_list['content']);
			if ($content == "")
			{
				return array();
			}

			// 登録
			$sql  = "INSERT INTO `contact` (`content`) ";
			$sql .= "VALUES                (?        ) ";
			$arg_list = array($content);
			$this->query($sql, $arg_list);

			// 戻り値
			$return_list = array();
			return $return_list;
		}
		catch (Exception $e)
		{
			$this->exception($e);
		}
	}
}
