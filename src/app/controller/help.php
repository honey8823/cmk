<?php
class HelpController extends Common
{
	public function table($param_list = array())
	{
		try
		{
			$return_list = array();

			// 取得
			$sql  = "SELECT   `id`, `title`, `content`, `update_stamp` ";
			$sql .= "FROM     `help` ";
			$sql .= "ORDER BY `sort` ASC ";
			$help_list = $this->query($sql);

			// 戻り値
			$return_list['help_list'] = $help_list;
			return $return_list;
		}
		catch (Exception $e)
		{
			$this->exception($e);
		}
	}
}
