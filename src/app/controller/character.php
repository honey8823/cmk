<?php
class CharacterController extends Common
{
	public function tableForPrivate($param_list = array())
	{
		try
		{
			// 引数
			$sort_column = isset($param_list['sort_column']) ? trim($param_list['sort_column']) : "id";
			$sort_order  = isset($param_list['sort_order'])  ? trim($param_list['sort_order'])  : "desc";
			$limit       = isset($param_list['limit'])       ? trim($param_list['limit'])       : "20";
			$offset      = isset($param_list['offset'])      ? trim($param_list['offset'])      : "0";

			// ユーザID
			// ログイン状態でない場合はエラー
			$user_id    = $this->getLoginId();
			if ($user_id === false)
			{
				return array('error_redirect' => "session");
			}

			$return_list = array();

			// 取得（キャラクター）
			// 次を取得できるかどうかを調べるため、「limit+1」件取得している
			$arg_list = array();
			$sql  = "SELECT   `id`, `name`, `is_private` ";
			$sql .= "FROM     `character` ";
			$sql .= "WHERE    `user_id` = ? ";
			$arg_list[] = $user_id;
			$sql .= "ORDER BY `" . $sort_column . "` " . $sort_order . " ";
			$sql .= "LIMIT    " . $offset . ", " . ($limit + 1) . " ";
			$character_list = $this->query($sql, $arg_list);

			if (count($character_list) == ($limit + 1))
			{
				// 次を取得可
				// 確認用に取得した最後の1件を配列から除く
				$return_list['is_more'] = 1;
				unset($character_list[$limit]);
			}
			else
			{
				// 次を取得不可
				$return_list['is_more'] = 0;
			}

			// 取得（タグ）・整形
			if (count($character_list) > 0)
			{
				$character_list = $this->setArrayKey($character_list, "id");

				$arg_list = array();
				$sql  = "SELECT    `character_tag`.`character_id` ";
				$sql .= "         ,`tag`.`id` ";
				$sql .= "         ,`tag`.`category` ";
				$sql .= "         ,`tag`.`name` ";
				$sql .= "         ,`tag`.`name_short` ";
				$sql .= "FROM      `character_tag` ";
				$sql .= "INNER JOIN `tag` ";
				$sql .= "  ON       `character_tag`.`tag_id` = `tag`.`id` ";
				$sql .= "WHERE      `character_tag`.`character_id` IN (" . implode(",", array_fill(0, count($character_list), "?")) . ") ";
				$sql .= "ORDER BY   `character_tag`.`character_id` DESC ";
				$sql .= "          ,`tag`.`category` ASC ";
				$sql .= "          ,`tag`.`sort` ASC ";
				foreach ($character_list as $v)
				{
					$arg_list[] = $v['id'];
				}
				$tag_list = $this->query($sql, $arg_list);

				if (count($tag_list) > 0)
				{
					$category_list = $this->getConfig("tag_category", "value");
					foreach ($tag_list as $v)
					{
						$character_list[$v['character_id']]['tag_list'][] = array(
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
				$character_list = array_values($character_list);
			}

			// 戻り値
			$return_list['character_list'] = $character_list;
			return $return_list;
		}
		catch (Exception $e)
		{
			// todo::エラー処理
		}


	}

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
