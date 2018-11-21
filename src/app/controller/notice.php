<?php
class NoticeController extends Common
{
	public function table($param_list = array())
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
			$limit   = isset($param_list['limit'])  && preg_match("/^[0-9]+$/", $param_list['limit'])  ? $param_list['limit']  : 1;
			$offset  = isset($param_list['offset']) && preg_match("/^[0-9]+$/", $param_list['offset']) ? $param_list['offset'] : 0;

			$return_list = array();

			// 取得
			// 次を取得できるかどうかを調べるため、「limit+1」件取得している
			$sql  = "SELECT   `id`, `content`, `uri`, `read_stamp`, `create_stamp` ";
			$sql .= "FROM     `notice` ";
			$sql .= "WHERE    `user_id` = ? ";
			$sql .= "ORDER BY `id` DESC ";
			$sql .= "LIMIT    " . $offset . ", " . ($limit + 1) . " ";
			$arg_list = array($user_id);
			$notice_list = $this->query($sql, $arg_list);
			if (count($notice_list) == ($limit + 1))
			{
				// 次を取得可
				// 確認用に取得した最後の1件を配列から除く
				$return_list['is_more'] = 1;
				unset($notice_list[$limit]);
			}
			else
			{
				// 次を取得不可
				$return_list['is_more'] = 0;
			}

			// 整形（表示用日付）
			foreach ($notice_list as $k => $v)
			{
				$notice_list[$k]['date'] = date("Y-m-d H:i", strtotime($v['create_stamp']));
			}

			// 取得した内容を既読にする
			$arg_list = array();
			$sql  = "UPDATE `notice` ";
			$sql .= "SET    `read_stamp` = NOW() ";
			$sql .= "WHERE  `id` IN (" . implode(",", array_fill(0, count($notice_list), "?")) . ") ";
			$sql .= "AND    `read_stamp` IS NULL ";
			foreach ($notice_list as $v)
			{
				$arg_list[] = $v['id'];
			}
			$this->query($sql, $arg_list);

			// 現在の未読件数をセッションにセット
			$this->setSessionNoticeUnread($user_id);

			// 戻り値
			$return_list['notice_list'] = $notice_list;
			return $return_list;
		}
		catch (Exception $e)
		{
			$this->exception($e);
		}
	}
}
