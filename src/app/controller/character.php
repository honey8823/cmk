<?php
class CharacterController extends Common
{
	public function add($param_list = array())
	{
		try
		{
			// ユーザID
			$user_id    = $this->getLoginId();
			if ($user_id === false)
			{
				return array('error_redirect' => "session");
			}

			// 引数
			$name       = trim($param_list['name']);
			$is_private = trim($param_list['is_private']) == 1 ? 1 : 0;
			$tag_list   = $param_list['tag_list'];

			// バリデート
			$err_list = array();
			if (strlen($name) == 0)
			{
				$err_list[] = "キャラクター名を入力してください。";
			}
			elseif (strlen($name) > 64)
			{
				$err_list[] = "キャラクター名は64文字以内で入力してください。";
			}
			if (count($err_list) > 0)
			{
				return array('error_message_list' => $err_list);
			}

			// 登録
			$arg_list = array();
			$sql  = "INSERT INTO `character` (`user_id`, `name`, `is_private`) ";
			$sql .= "VALUES                  (?        ,?      , ?         ) ";
			$arg_list[] = $user_id;
			$arg_list[] = $name;
			$arg_list[] = $is_private;
			$this->query($sql, $arg_list);
			$character_id = $this->getLastInsertId();

			// タグ登録
			$tag_list = array_filter($tag_list, function($v){return(preg_match("/^[0-9]+$/", $v));});
			if (count($tag_list) > 0)
			{
				$arg_list = array();
				$sql  = "INSERT INTO `character_tag` (`character_id`, `tag_id`) ";
				$sql .= "VALUES " . implode(",", array_fill(0, count($tag_list), "(?, ?)"));
				foreach ($tag_list as $v)
				{
					$arg_list[] = $character_id;
					$arg_list[] = $v;
				}
				$this->query($sql, $arg_list);
			}

			// 戻り値
			$return_list = array(
				'character_id' => $character_id,
				'name'         => $name,
				'is_private'   => $is_private,
				'tag_list'     => $tag_list,
			);
			return $return_list;
		}
		catch (Exception $e)
		{
			// todo::エラー処理
		}


	}
}
