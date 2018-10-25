<?php
class InformationController extends Common
{
	public function table($param_list = array())
	{
		try
		{
			$limit  = isset($param_list['limit'])  && preg_match("/^[0-9]+$/", $param_list['limit'])  ? $param_list['limit']  : 1;
			$offset = isset($param_list['offset']) && preg_match("/^[0-9]+$/", $param_list['offset']) ? $param_list['offset'] : 0;

			$return_list = array();

			// 取得
			// 次を取得できるかどうかを調べるため、「limit+1」件取得している
			$sql  = "SELECT   `id`, `content`, `create_stamp`, `update_stamp` ";
			$sql .= "FROM     `information` ";
			$sql .= "ORDER BY `id` DESC ";
			$sql .= "LIMIT    " . $offset . ", " . ($limit + 1) . " ";
			$information_list = $this->query($sql);
			if (count($information_list) == ($limit + 1))
			{
				// 次を取得可
				// 確認用に取得した最後の1件を配列から除く
				$return_list['is_more'] = 1;
				unset($information_list[$limit]);
			}
			else
			{
				// 次を取得不可
				$return_list['is_more'] = 0;
			}

			// 整形（表示用日付）
			foreach ($information_list as $k => $v)
			{
				$information_list[$k]['date'] = date("Y-m-d", strtotime($v['create_stamp']));
			}

			// 戻り値
			$return_list['information_list'] = $information_list;
			return $return_list;
		}
		catch (Exception $e)
		{
			// todo::エラー処理
		}
	}
}
