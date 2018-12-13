<?php
class CharacterController extends Common
{
	const IMAGE_SIZE = 200;

	public function table($param_list = array())
	{
		try
		{
			// ユーザID
			// ログイン状態でない場合はエラー
			$user_id    = $this->getLoginId();
			if ($user_id === false)
			{
				return array('error_redirect' => "session");
			}

			// 引数
			$mode_simple = trim(isset($param_list['mode_simple']) ? $param_list['mode_simple'] : "");

			$return_list = array();

			// 取得（キャラクター）
			$arg_list = array();
			$sql  = "SELECT   `id` ";
			$sql .= "        ,`name` ";
			if ($mode_simple != 1)
			{
				$sql .= "    ,`image` ";
			}
			$sql .= "        ,`is_private` ";
			$sql .= "FROM     `character` ";
			$sql .= "WHERE    `user_id` = ? ";
			$arg_list[] = $user_id;
			$sql .= "AND      `is_delete` <> 1 ";
			$sql .= "ORDER BY `sort` = 0 ASC ";
			$sql .= "        ,`sort` ASC ";
			$sql .= "        ,`id` ASC ";
			$character_list = $this->query($sql, $arg_list);

			// 取得（ステージ）・整形
			if ($mode_simple != 1 && count($character_list) > 0)
			{
				$character_list = $this->setArrayKey($character_list, "id");

				$arg_list = array();
				$sql  = "SELECT     `stage_character`.`character_id` ";
				$sql .= "          ,`stage`.`id` ";
				$sql .= "          ,`stage`.`name` ";
				$sql .= "FROM       `stage_character` ";
				$sql .= "INNER JOIN `stage` ";
				$sql .= "  ON       `stage_character`.`stage_id` = `stage`.`id` ";
				$sql .= "WHERE      `stage_character`.`character_id` IN (" . implode(",", array_fill(0, count($character_list), "?")) . ") ";
				$sql .= "AND        `stage`.`user_id` = ? ";
				$sql .= "AND        `stage`.`is_delete` <> 1 ";
				$sql .= "ORDER BY   `stage_character`.`character_id` ASC ";
				$sql .= "          ,`stage`.`sort` = 0 ASC ";
				$sql .= "          ,`stage`.`sort` ASC ";
				foreach ($character_list as $v)
				{
					$arg_list[] = $v['id'];
				}
				$arg_list[] = $user_id;
				$stage_list = $this->query($sql, $arg_list);

				if (count($stage_list) > 0)
				{
					foreach ($stage_list as $v)
					{
						$character_list[$v['character_id']]['stage_list'][] = array(
							'id'   => $v['id'],
							'name' => $v['name'],
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
			$this->exception($e);
		}


	}

	public function get($param_list = array())
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
			$id = trim($param_list['id']);

			$return_list = array();

			// 取得（キャラクター）
			$arg_list = array();
			$sql  = "SELECT   `id`, `name`, `remarks`, `image`, `is_private` ";
			$sql .= "FROM     `character` ";
			$sql .= "WHERE    `id` = ? ";
			$arg_list[] = $id;
			$sql .= "AND      `user_id` = ? ";
			$arg_list[] = $user_id;
			$sql .= "AND      `is_delete` <> 1 ";
			$character_list = $this->query($sql, $arg_list);

			if(count($character_list) != 1)
			{
				return array('error_redirect' => "notfound");
			}

			// 取得（ユーザのログインID：URL生成用）
			$sql  = "SELECT `login_id` FROM `user` WHERE `id` = ? ";
			$arg_list = array($user_id);
			$user_list = $this->query($sql, $arg_list);
			$character_list[0]['login_id'] = $user_list[0]['login_id'];

			// 取得（ステージ）・整形
			$sql  = "SELECT     `stage`.`id` ";
			$sql .= "          ,`stage`.`name` ";
			$sql .= "FROM       `stage_character` ";
			$sql .= "INNER JOIN `stage` ";
			$sql .= "  ON       `stage_character`.`stage_id` = `stage`.`id` ";
			$sql .= "WHERE      `stage_character`.`character_id` = ? ";
			$sql .= "AND        `stage`.`is_delete` <> 1 ";
			$sql .= "AND        `stage`.`user_id` = ? ";
			$sql .= "ORDER BY   `stage`.`sort` = 0 ASC ";
			$sql .= "          ,`stage`.`sort` ASC ";
			$arg_list = array($id, $user_id);
			$stage_list = $this->query($sql, $arg_list);
			$character_list[0]['stage_list'] = array();
			if (count($stage_list) > 0)
			{
				foreach ($stage_list as $v)
				{
					$character_list[0]['stage_list'][] = array(
						'id'            => $v['id'],
						'name'          => $v['name'],
					);
				}
			}

			// 取得（詳細プロフィール）・整形
			$q_list = $this->getConfig("character_profile_q", "value");
			$sql  = "SELECT     `character_profile`.`question` ";
			$sql .= "          ,`character_profile`.`answer` ";
			$sql .= "FROM       `character_profile` ";
			$sql .= "WHERE      `character_profile`.`character_id` = ? ";
			$sql .= "ORDER BY   `character_profile`.`sort` = 0 ASC ";
			$sql .= "          ,`character_profile`.`sort` ASC ";
			$sql .= "          ,`character_profile`.`create_stamp` ASC ";
			$arg_list = array($id);
			$profile_list = $this->query($sql, $arg_list);
			$character_list[0]['profile_list'] = array();
			if (count($profile_list) > 0)
			{
				foreach ($profile_list as $v)
				{
					$character_list[0]['profile_list'][] = array(
						'question'       => $v['question'],
						'question_title' => $q_list[$v['question']]['title'],
						'answer'         => $v['answer'],
					);
				}
			}

			// 取得（相関図：他キャラクター）・整形
			$sql  = "SELECT     `character`.`id` AS `character_id` ";
			$sql .= "          ,`character`.`name` AS `character_name` ";
			$sql .= "FROM       `character` ";
			$sql .= "WHERE      `character`.`user_id` = ? ";
			$sql .= "AND        `character`.`is_delete` <> 1 ";
			$sql .= "AND        `character`.`id` <> ? ";
			$sql .= "ORDER BY   `character`.`sort` = 0 ASC ";
			$sql .= "          ,`character`.`sort` ASC ";
			$sql .= "          ,`character`.`id` ASC ";
			$arg_list = array($user_id, $id);
			$character_list[0]['relation_list'] = $this->setArrayKey($this->query($sql, $arg_list), "character_id");
			foreach ($character_list[0]['relation_list'] as $k => $v)
			{
				$character_list[0]['relation_list'][$k]['title_a']     = "";
				$character_list[0]['relation_list'][$k]['free_text_a'] = "";
				$character_list[0]['relation_list'][$k]['is_arrow_a']  = "0";
				$character_list[0]['relation_list'][$k]['title_b']     = "";
				$character_list[0]['relation_list'][$k]['free_text_b'] = "";
				$character_list[0]['relation_list'][$k]['is_arrow_b']  = "0";
				$character_list[0]['relation_list'][$k]['title_c']     = "";
				$character_list[0]['relation_list'][$k]['free_text_c'] = "";
				$character_list[0]['relation_list'][$k]['is_arrow_c']  = "0";
			}

			// 取得（相関図：内容）・整形
			if (count($character_list[0]['relation_list']) > 0)
			{
				$sql  = "SELECT     `character_relation`.`character_id_from` ";
				$sql .= "          ,`character_relation`.`character_id_to` ";
				$sql .= "          ,`character_relation`.`is_both` ";
				$sql .= "          ,`character_relation`.`title` ";
				$sql .= "          ,`character_relation`.`free_text` ";
				$sql .= "FROM       `character_relation` ";
				$sql .= "WHERE      `character_relation`.`character_id_from` = ? ";
				$sql .= "OR         `character_relation`.`character_id_to`   = ? ";
				$arg_list = array(
					$id,
					$id,
				);
				$tmp_relation_list = $this->query($sql, $arg_list);
				foreach ($tmp_relation_list as $v)
				{
					if ($v['character_id_from'] == $id)
					{
						$character_list[0]['relation_list'][$v['character_id_to']]['title_a']        = $v['title'];
						$character_list[0]['relation_list'][$v['character_id_to']]['free_text_a']    = $v['free_text'];
						$character_list[0]['relation_list'][$v['character_id_to']]['is_arrow_c']    |= $v['is_both'];
						if ($v['title'] != "" || $v['free_text'] != "")
						{
							$character_list[0]['relation_list'][$v['character_id_to']]['is_arrow_a'] = "1";
						}
						if ($character_list[0]['relation_list'][$v['character_id_to']]['title_c'] == "")
						{
							$character_list[0]['relation_list'][$v['character_id_to']]['title_c'] = $v['title'];
						}
					}
					else
					{
						$character_list[0]['relation_list'][$v['character_id_from']]['title_b']      = $v['title'];
						$character_list[0]['relation_list'][$v['character_id_from']]['free_text_b']  = $v['free_text'];
						$character_list[0]['relation_list'][$v['character_id_from']]['is_arrow_c']  |= $v['is_both'];
						if ($v['title'] != "" || $v['free_text'] != "")
						{
							$character_list[0]['relation_list'][$v['character_id_from']]['is_arrow_b'] = "1";
						}
						if ($character_list[0]['relation_list'][$v['character_id_from']]['title_c'] == "")
						{
							$character_list[0]['relation_list'][$v['character_id_from']]['title_c'] = $v['title'];
						}
					}
				}
			}

			// 戻り値
			$return_list['character'] = $character_list[0];
			return $return_list;
		}
		catch (Exception $e)
		{
			$this->exception($e);
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
			$stage_list = isset($param_list['stage_list']) && is_array($param_list['stage_list']) ? $param_list['stage_list'] : array();

			// バリデート
			$err_list = array();
			if (mb_strlen($name) == 0)
			{
				$err_list[] = "キャラクター名を入力してください。";
			}
			elseif (mb_strlen($name) > 64)
			{
				$err_list[] = "キャラクター名は64文字以内で入力してください。";
			}
			if (count($err_list) > 0)
			{
				return array('error_message_list' => $err_list);
			}

			// 登録
			$arg_list = array();
			$sql  = "INSERT INTO `character` (`user_id`, `name`) ";
			$sql .= "VALUES                  (?        ,?      ) ";
			$arg_list[] = $user_id;
			$arg_list[] = $name;
			$this->query($sql, $arg_list);
			$id = $this->getLastInsertId();

			// ステージ登録
			$stage_list = array_filter($stage_list, function($v){return(preg_match("/^[0-9]+$/", $v));});
			if (count($stage_list) > 0)
			{
				$arg_list = array();
				$sql  = "INSERT INTO `stage_character` (`stage_id`, `character_id`) ";
				$sql .= "VALUES " . implode(",", array_fill(0, count($stage_list), "(?, ?)"));
				foreach ($stage_list as $v)
				{
					$arg_list[] = $v;
					$arg_list[] = $id;
				}
				$this->query($sql, $arg_list);
			}

			// 戻り値
			$return_list = array(
				'id'         => $id,
				'name'       => $name,
				'stage_list' => $stage_list,
			);
			return $return_list;
		}
		catch (Exception $e)
		{
			$this->exception($e);
		}
	}

	public function set($param_list = array())
	{
		try
		{
			// ユーザID
			$user_id = $this->getLoginId();
			if ($user_id === false)
			{
				return array('error_redirect' => "session");
			}

			// 引数
			$id         = trim($param_list['id']);
			$name       = trim($param_list['name']);
			$remarks    = trim($param_list['remarks']);
			$stage_list = isset($param_list['stage_list']) && is_array($param_list['stage_list']) ? $param_list['stage_list'] : array();

			// バリデート
			$err_list = array();
			if (!preg_match("/^[0-9]+$/", $id))
			{
				$err_list[] = "エラーが発生しました。一旦画面をリロードしてやり直してください。";
				return array('error_message_list' => $err_list);
			}
			else
			{
				$sql  = "SELECT `id` FROM `character` WHERE `id` = ? AND `user_id` = ? AND `is_delete` <> 1 ";
				$arg_list = array($id, $user_id);
				$r = $this->query($sql, $arg_list);
				if (count($r) != 1)
				{
					$err_list[] = "エラーが発生しました。一旦画面をリロードしてやり直してください。";
					return array('error_message_list' => $err_list);
				}
			}
			if (mb_strlen($name) == 0)
			{
				$err_list[] = "キャラクター名を入力してください。";
			}
			elseif (mb_strlen($name) > 64)
			{
				$err_list[] = "キャラクター名は64文字以内で入力してください。";
			}
			if (mb_strlen($remarks) > 10000)
			{
				$err_list[] = "備考は1万字以内で入力してください。";
			}
			if (count($err_list) > 0)
			{
				return array('error_message_list' => $err_list);
			}

			// 更新
			$arg_list = array();
			$sql  = "UPDATE `character` ";
			$sql .= "SET    `name`    = ? ";
			$sql .= "      ,`remarks` = ? ";
			$sql .= "WHERE  `id`      = ? ";
			$arg_list[] = $name;
			$arg_list[] = $remarks == "" ? null : $remarks;
			$arg_list[] = $id;
			$this->query($sql, $arg_list);

			// ステージ登録

			// 変更後のデータを取得
			$stage_list = array_filter($stage_list, function($v){return(preg_match("/^[0-9]+$/", $v));});
			$new_stage_list = array();
			$after_stage_list = array();
			if (count($stage_list) > 0)
			{
				// 登録できないデータ（削除済み・本人のデータでないもの）を省く
				$sql  = "SELECT `id` FROM `stage` WHERE `id` IN (" . implode(",", array_fill(0, count($stage_list), "?")) . ") AND `user_id` = ? AND `is_delete` <> 1 ";
				$arg_list = $stage_list;
				$arg_list[] = $user_id;
				$new_stage_list = $this->query($sql, $arg_list);
				$after_stage_list = array_column($new_stage_list, "id");
				$new_stage_list = $this->setArrayKey($new_stage_list, "id");
			}

			// 変更前のデータを取得
			$sql  = "SELECT `stage_id` ";
			$sql .= "FROM   `stage_character` ";
			$sql .= "WHERE  `character_id` = ? ";
			$arg_list = array($id);
			$before_stage_list = array_column($this->query($sql, $arg_list), "stage_id");

			// 削除対象
			$del_stage_list = array_diff($before_stage_list, $after_stage_list);

			// 追加対象
			$add_stage_list = array_diff($after_stage_list, $before_stage_list);

			// 不要なものを削除
			if (count($del_stage_list) > 0)
			{
				$arg_list = array();
				$sql  = "DELETE FROM `stage_character` ";
				$sql .= "WHERE `character_id` = ? ";
				$sql .= "AND   `stage_id` IN (" . implode(",", array_fill(0, count($del_stage_list), "?")) . ") ";
				$arg_list[] = $id;
				$arg_list = array_merge($arg_list, $del_stage_list);
				$this->query($sql, $arg_list);
			}

			// 必要なものを追加
			if (count($add_stage_list) > 0)
			{
				$arg_list = array();
				$sql  = "INSERT INTO `stage_character` (`stage_id`, `character_id`) ";
				$sql .= "VALUES " . implode(",", array_fill(0, count($add_stage_list), "(?, ?)"));
				foreach ($add_stage_list as $v)
				{
					$arg_list[] = $v;
					$arg_list[] = $id;
				}
				$this->query($sql, $arg_list);
			}

			// 戻り値
			$return_list = array(
				'id'         => $id,
				'name'       => $name,
				'stage_list' => $stage_list,
			);
			return $return_list;
		}
		catch (Exception $e)
		{
			$this->exception($e);
		}
	}
	public function setImage($param_list = array())
	{
		try
		{
			// ユーザID
			$user_id = $this->getLoginId();
			if ($user_id === false)
			{
				return array('error_redirect' => "session");
			}

			// 引数
			$id            = trim($param_list['id']);
			$tmp_file_name = trim($param_list['tmp_file_name']);
			$tmp_file_type = trim($param_list['tmp_file_type']);
			$x             = trim($param_list['x']);
			$y             = trim($param_list['y']);
			$size          = trim($param_list['size']);

			// 一時ファイルのパス
			$tmp_filename = PATH_IMAGES . date("YmdHis") . "_" . mt_rand() . ".png";

			// 元ファイルを読み込む
			if ($tmp_file_type == "image/png")
			{
				$base_img = imagecreatefrompng($tmp_file_name);
			}
			elseif ($tmp_file_type == "image/jpeg")
			{
				$base_img = imagecreatefromjpeg($tmp_file_name);
			}
			elseif ($tmp_file_type == "image/gif")
			{
				$base_img = imagecreatefromgif($tmp_file_name);
			}
			else
			{
				// 対応していないフォーマット：無視して終了
				return array('error_message' => "対応していないファイルタイプです。JPEG, GIF, PNGのいずれかでお試しください。");
			}

			// 新しいキャンバスを作成する
			$new_img = imagecreatetruecolor(self::IMAGE_SIZE, self::IMAGE_SIZE);

			// 画像を縮小・トリミングする
			imagecopyresampled($new_img, $base_img, 0, 0, $x, $y, self::IMAGE_SIZE, self::IMAGE_SIZE, $size, $size);

			// 画像をpng化する
			imagepng($new_img, $tmp_filename);

			// base64化する
			$img_base64 = base64_encode(file_get_contents($tmp_filename));

			// 画像を削除する
			unlink($tmp_filename);

			// base64化に失敗した場合は無視して終了
			if ($img_base64 === false)
			{
				return array('error_message' => "画像の保存に失敗しました。別のファイルでお試しください。");
			}

			// 更新
			$arg_list = array();
			$sql  = "UPDATE `character` ";
			$sql .= "SET    `image` = ? ";
			$arg_list[] = $img_base64;
			$sql .= "WHERE  `id` = ? ";
			$sql .= "AND    `user_id` = ? ";
			$arg_list[] = $id;
			$arg_list[] = $user_id;
			$this->query($sql, $arg_list);

			// 戻り値
			$return_list = array(
// 				'image' => $img_base64,
			);
			return $return_list;
		}
		catch (Exception $e)
		{
			$this->exception($e);
		}
	}
	public function setImageClear($param_list = array())
	{
		try
		{
			// ユーザID
			$user_id = $this->getLoginId();
			if ($user_id === false)
			{
				return array('error_redirect' => "session");
			}

			// 引数
			$id = trim($param_list['id']);

			// 更新
			$arg_list = array();
			$sql  = "UPDATE `character` ";
			$sql .= "SET    `image` = NULL ";
			$sql .= "WHERE  `id` = ? ";
			$sql .= "AND    `user_id` = ? ";
			$arg_list[] = $id;
			$arg_list[] = $user_id;
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

	public function setIsPrivate($param_list = array())
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
			$id         = trim($param_list['id']);
			$is_private = trim($param_list['is_private']) == "0" ? "0" : "1";

			// バリデート
			$err_list = array();
			if (!preg_match("/^[0-9]+$/", $id))
			{
				$err_list[] = "エラーが発生しました。一旦画面をリロードしてやり直してください。";
				return array('error_message_list' => $err_list);
			}
			else
			{
				$sql  = "SELECT `id` FROM `character` WHERE `id` = ? AND `user_id` = ? AND `is_delete` <> 1 ";
				$arg_list = array($id, $user_id);
				$r = $this->query($sql, $arg_list);
				if (count($r) != 1)
				{
					$err_list[] = "エラーが発生しました。一旦画面をリロードしてやり直してください。";
					return array('error_message_list' => $err_list);
				}
			}
			if (count($err_list) > 0)
			{
				return array('error_message_list' => $err_list);
			}

			// 更新
			$arg_list = array();
			$sql  = "UPDATE `character` ";
			$sql .= "SET    `is_private` = ? ";
			$sql .= "WHERE  `id` = ? ";
			$arg_list[] = $is_private;
			$arg_list[] = $id;
			$this->query($sql, $arg_list);

			// 戻り値
			$return_list = array(
				'id'         => $id,
				'is_private' => $is_private,
			);
			return $return_list;
		}
		catch (Exception $e)
		{
			$this->exception($e);
		}
	}

	public function setSort($param_list = array())
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
			$id_list = isset($param_list['id_list']) && is_array($param_list['id_list']) ? $param_list['id_list'] : array();

			// 更新
			$sql  = "UPDATE `character` ";
			$sql .= "SET    `sort` = ? ";
			$sql .= "WHERE  `id` = ? ";
			$sql .= "AND    `user_id` = ? ";
			foreach ($id_list as $sort => $id)
			{
				$arg_list = array(
					$sort + 1,
					$id,
					$user_id,
				);
				$this->query($sql, $arg_list);
			}

			// 戻り値
			$return_list = array($id_list);
			return $return_list;
		}
		catch (Exception $e)
		{
			$this->exception($e);
		}
	}

	public function del($param_list = array())
	{
		try
		{
			// ユーザID
			$user_id = $this->getLoginId();
			if ($user_id === false)
			{
				return array('error_redirect' => "session");
			}

			// 引数
			$id = trim($param_list['id']);

			// バリデート
			$err_list = array();
			if (!preg_match("/^[0-9]+$/", $id))
			{
				$err_list[] = "エラーが発生しました。一旦画面をリロードしてやり直してください。";
				return array('error_message_list' => $err_list);
			}
			else
			{
				$sql  = "SELECT `id` FROM `character` WHERE `id` = ? AND `user_id` = ? AND `is_delete` <> 1 ";
				$arg_list = array($id, $user_id);
				$r = $this->query($sql, $arg_list);
				if (count($r) != 1)
				{
					$err_list[] = "エラーが発生しました。一旦画面をリロードしてやり直してください。";
					return array('error_message_list' => $err_list);
				}
			}
			if (count($err_list) > 0)
			{
				return array('error_message_list' => $err_list);
			}

			// 更新
			$arg_list = array();
			$sql  = "UPDATE `character` ";
			$sql .= "SET    `is_delete` = 1 ";
			$sql .= "WHERE  `id` = ? ";
			$arg_list[] = $id;
			$this->query($sql, $arg_list);

			// 戻り値
			$return_list = array(
				'id' => $id,
			);
			return $return_list;
		}
		catch (Exception $e)
		{
			$this->exception($e);
		}
	}

	public function addProfile($param_list = array())
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
			$character_id = trim($param_list['character_id']);
			$question     = trim($param_list['question']);
			$answer       = trim($param_list['answer']);

			// キャラクタープロフィール項目
			$q_list = $this->getConfig("character_profile_q", "value");

			// バリデート
			$err_list = array();
			if (!preg_match("/^[0-9]+$/", $character_id))
			{
				$err_list[] = "エラーが発生しました。一旦画面をリロードしてやり直してください。";
				return array('error_message_list' => $err_list);
			}
			else
			{
				$sql  = "SELECT `id` FROM `character` WHERE `id` = ? AND `user_id` = ? AND `is_delete` <> 1 ";
				$arg_list = array($character_id, $user_id);
				$r = $this->query($sql, $arg_list);
				if (count($r) != 1)
				{
					$err_list[] = "エラーが発生しました。一旦画面をリロードしてやり直してください。";
					return array('error_message_list' => $err_list);
				}
			}
			if (!isset($q_list[$question]))
			{
				$err_list[] = "エラーが発生しました。一旦画面をリロードしてやり直してください。";
				return array('error_message_list' => $err_list);
			}
			if (mb_strlen($answer) == 0)
			{
				$err_list[] = "内容を入力してください。";
			}
			elseif (mb_strlen($answer) > 1000)
			{
				$err_list[] = "内容は1000文字以内で入力してください。";
			}
			if (count($err_list) > 0)
			{
				return array('error_message_list' => $err_list);
			}

			// 登録
			$arg_list = array();
			$sql  = "INSERT INTO `character_profile` (`character_id`, `question`, `answer`) ";
			$sql .= "VALUES                          (?             , ?         , ?       ) ";
			$arg_list[] = $character_id;
			$arg_list[] = $question;
			$arg_list[] = $answer;
			$this->query($sql, $arg_list);

			// 戻り値
			$return_list = array(
				'question'       => $question,
				'question_title' => $q_list[$question]['title'],
				'answer'         => $answer,
			);
			return $return_list;
		}
		catch (Exception $e)
		{
			$this->exception($e);
		}
	}

	public function setProfile($param_list = array())
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
			$character_id = trim($param_list['character_id']);
			$question     = trim($param_list['question']);
			$answer       = trim($param_list['answer']);

			// キャラクタープロフィール項目
			$q_list = $this->getConfig("character_profile_q", "value");

			// バリデート
			$err_list = array();
			if (!preg_match("/^[0-9]+$/", $character_id))
			{
				$err_list[] = "エラーが発生しました。一旦画面をリロードしてやり直してください。";
				return array('error_message_list' => $err_list);
			}
			else
			{
				$sql  = "SELECT `id` FROM `character` WHERE `id` = ? AND `user_id` = ? AND `is_delete` <> 1 ";
				$arg_list = array($character_id, $user_id);
				$r = $this->query($sql, $arg_list);
				if (count($r) != 1)
				{
					$err_list[] = "エラーが発生しました。一旦画面をリロードしてやり直してください。";
					return array('error_message_list' => $err_list);
				}
			}
			if (!isset($q_list[$question]))
			{
				$err_list[] = "エラーが発生しました。一旦画面をリロードしてやり直してください。";
				return array('error_message_list' => $err_list);
			}
			if (mb_strlen($answer) == 0)
			{
				$err_list[] = "内容を入力してください。";
			}
			elseif (mb_strlen($answer) > 1000)
			{
				$err_list[] = "内容は1000文字以内で入力してください。";
			}
			if (count($err_list) > 0)
			{
				return array('error_message_list' => $err_list);
			}

			// 登録
			$arg_list = array();
			$sql  = "UPDATE `character_profile` ";
			$sql .= "SET    `answer` = ? ";
			$sql .= "WHERE  `character_id` = ? ";
			$sql .= "AND    `question` = ? ";
			$arg_list[] = $answer;
			$arg_list[] = $character_id;
			$arg_list[] = $question;
			$this->query($sql, $arg_list);

			// 戻り値
			$return_list = array(
				'answer'         => $answer,
			);
			return $return_list;
		}
		catch (Exception $e)
		{
			$this->exception($e);
		}
	}

	public function delProfile($param_list = array())
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
			$character_id = trim($param_list['character_id']);
			$question     = trim($param_list['question']);

			// キャラクタープロフィール項目
			$q_list = $this->getConfig("character_profile_q", "value");

			// バリデート
			$err_list = array();
			if (!preg_match("/^[0-9]+$/", $character_id))
			{
				$err_list[] = "エラーが発生しました。一旦画面をリロードしてやり直してください。";
				return array('error_message_list' => $err_list);
			}
			else
			{
				$sql  = "SELECT `id` FROM `character` WHERE `id` = ? AND `user_id` = ? AND `is_delete` <> 1 ";
				$arg_list = array($character_id, $user_id);
				$r = $this->query($sql, $arg_list);
				if (count($r) != 1)
				{
					$err_list[] = "エラーが発生しました。一旦画面をリロードしてやり直してください。";
					return array('error_message_list' => $err_list);
				}
			}
			if (!isset($q_list[$question]))
			{
				$err_list[] = "エラーが発生しました。一旦画面をリロードしてやり直してください。";
				return array('error_message_list' => $err_list);
			}
			if (count($err_list) > 0)
			{
				return array('error_message_list' => $err_list);
			}

			// 登録
			$arg_list = array();
			$sql  = "DELETE FROM `character_profile` ";
			$sql .= "WHERE       `character_id` = ? ";
			$sql .= "AND         `question` = ? ";
			$arg_list[] = $character_id;
			$arg_list[] = $question;
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

	public function getProfileStage($param_list = array())
	{
		try
		{
			// ユーザID
			// ログイン状態でない場合はエラー
			$user_id    = $this->getLoginId();
			if ($user_id === false)
			{
				return array('error_redirect' => "session");
			}

			// 引数
			$character_id = trim($param_list['character_id']);
			$stage_id     = trim($param_list['stage_id']);

			$return_list = array();

			if (!preg_match("/^[0-9]+$/", $character_id) || !preg_match("/^[0-9]+$/", $stage_id))
			{
				return array('error_message_list' => array("エラーが発生しました。一旦画面をリロードしてやり直してください。"));
			}

			// 取得（キャラクター・ステージ）
			$sql  = "SELECT     `character`.`name` AS `character_name` ";
			$sql .= "          ,`stage`.`name`     AS `stage_name` ";
			$sql .= "FROM       `character` ";
			$sql .= "INNER JOIN `stage_character` ON  `character`.`id` = `stage_character`.`character_id` ";
			$sql .= "INNER JOIN `stage`           ON  `stage_character`.`stage_id` = `stage`.`id` ";
			$sql .= "                             AND `stage`.`id` = ? ";
			$sql .= "                             AND `stage`.`user_id` = ? ";
			$sql .= "                             AND `stage`.`is_delete` <> 1 ";
			$sql .= "WHERE      `character`.`id` = ? ";
			$sql .= "AND        `character`.`user_id` = ? ";
			$sql .= "AND        `character`.`is_delete` <> 1 ";
			$arg_list = array(
				$stage_id,
				$user_id,
				$character_id,
				$user_id,
			);
			$r = $this->query($sql, $arg_list);
			if (count($r) != 1)
			{
				return array('error_message_list' => array("エラーが発生しました。一旦画面をリロードしてやり直してください。"));
			}
			$return_list['character_id']   = $character_id;
			$return_list['character_name'] = $r[0]['character_name'];
			$return_list['stage_id']       = $stage_id;
			$return_list['stage_name']     = $r[0]['stage_name'];

			// 取得（プロフィール：基本）
			$sql  = "SELECT     `character_profile`.`question` ";
			$sql .= "          ,`character_profile`.`answer` AS `answer_base` ";
			$sql .= "FROM       `character_profile` ";
			$sql .= "WHERE      `character_profile`.`character_id` = ? ";
			$sql .= "ORDER BY   `character_profile`.`sort` = 0 ASC ";
			$sql .= "          ,`character_profile`.`sort` ASC ";
			$sql .= "          ,`character_profile`.`create_stamp` ASC ";
			$arg_list = array($character_id);
			$profile_list = $this->setArrayKey($this->query($sql, $arg_list), "question");

			// 取得（プロフィール：オーバーライド：ステージ）
			$sql  = "SELECT     `character_profile_stage`.`question` ";
			$sql .= "          ,`character_profile_stage`.`answer` ";
			$sql .= "FROM       `character_profile_stage` ";
			$sql .= "WHERE      `character_profile_stage`.`character_id` = ? ";
			$sql .= "AND        `character_profile_stage`.`stage_id` = ? ";
			$sql .= "ORDER BY   `character_profile_stage`.`sort` = 0 ASC ";
			$sql .= "          ,`character_profile_stage`.`sort` ASC ";
			$sql .= "          ,`character_profile_stage`.`create_stamp` ASC ";
			$arg_list = array($character_id, $stage_id);
			$profile_stage_list = $this->query($sql, $arg_list);

			// プロフィールの整形（基本とステージのマージ）
			foreach ($profile_stage_list as $v)
			{
				$profile_list[$v['question']]['question'] = $v['question'];
				$profile_list[$v['question']]['answer']   = $v['answer'];
			}

			// プロフィールの整形
			$q_list = $this->getConfig("character_profile_q", "value");
			foreach ($profile_list as $k => $v)
			{
				$profile_list[$k]['question_title'] = $q_list[$k]['title'];
			}

			// キーの削除
			$return_list['character_profile_stage_list'] = array_values($profile_list);

			// 戻り値
			return $return_list;
		}
		catch (Exception $e)
		{
			$this->exception($e);
		}
	}

	public function addProfileStage($param_list = array())
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
			$character_id = trim($param_list['character_id']);
			$stage_id     = trim($param_list['stage_id']);
			$question     = trim($param_list['question']);
			$answer       = trim($param_list['answer']);

			// キャラクタープロフィール項目
			$q_list = $this->getConfig("character_profile_q", "value");

			// バリデート
			$err_list = array();
			if (!preg_match("/^[0-9]+$/", $character_id))
			{
				$err_list[] = "エラーが発生しました。一旦画面をリロードしてやり直してください。";
				return array('error_message_list' => $err_list);
			}
			elseif (!preg_match("/^[0-9]+$/", $stage_id))
			{
				$err_list[] = "エラーが発生しました。一旦画面をリロードしてやり直してください。";
				return array('error_message_list' => $err_list);
			}
			else
			{
				$sql  = "SELECT     `character`.`id` ";
				$sql .= "FROM       `character` ";
				$sql .= "INNER JOIN `stage_character` ON  `character`.`id` = `stage_character`.`character_id` ";
				$sql .= "INNER JOIN `stage`           ON  `stage_character`.`stage_id` = `stage`.`id` ";
				$sql .= "                             AND `stage`.`id` = ? ";
				$sql .= "                             AND `stage`.`user_id` = ? ";
				$sql .= "                             AND `stage`.`is_delete` <> 1 ";
				$sql .= "WHERE      `character`.`id` = ? ";
				$sql .= "AND        `character`.`user_id` = ? ";
				$sql .= "AND        `character`.`is_delete` <> 1 ";
				$arg_list = array(
					$stage_id,
					$user_id,
					$character_id,
					$user_id,
				);
				$r = $this->query($sql, $arg_list);
				if (count($r) != 1)
				{
					$err_list[] = "エラーが発生しました。一旦画面をリロードしてやり直してください。";
					return array('error_message_list' => $err_list);
				}
			}
			if (!isset($q_list[$question]))
			{
				$err_list[] = "エラーが発生しました。一旦画面をリロードしてやり直してください。";
				return array('error_message_list' => $err_list);
			}
			if (mb_strlen($answer) == 0)
			{
				$err_list[] = "内容を入力してください。";
			}
			elseif (mb_strlen($answer) > 1000)
			{
				$err_list[] = "内容は1000文字以内で入力してください。";
			}
			if (count($err_list) > 0)
			{
				return array('error_message_list' => $err_list);
			}

			// 登録
			$arg_list = array();
			$sql  = "INSERT INTO `character_profile_stage` (`character_id`, `stage_id`, `question`, `answer`) ";
			$sql .= "VALUES                                (?             , ?         , ?         , ?       ) ";
			$arg_list[] = $character_id;
			$arg_list[] = $stage_id;
			$arg_list[] = $question;
			$arg_list[] = $answer;
			$this->query($sql, $arg_list);

			// 戻り値
			$return_list = array(
				'question'       => $question,
				'question_title' => $q_list[$question]['title'],
				'answer'         => $answer,
			);
			return $return_list;
		}
		catch (Exception $e)
		{
			$this->exception($e);
		}
	}

	public function setProfileStage($param_list = array())
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
			$character_id = trim($param_list['character_id']);
			$stage_id     = trim($param_list['stage_id']);
			$question     = trim($param_list['question']);
			$answer       = trim($param_list['answer']);

			// キャラクタープロフィール項目
			$q_list = $this->getConfig("character_profile_q", "value");

			// バリデート
			$err_list = array();
			if (!preg_match("/^[0-9]+$/", $character_id))
			{
				$err_list[] = "エラーが発生しました。一旦画面をリロードしてやり直してください。";
				return array('error_message_list' => $err_list);
			}
			elseif (!preg_match("/^[0-9]+$/", $stage_id))
			{
				$err_list[] = "エラーが発生しました。一旦画面をリロードしてやり直してください。";
				return array('error_message_list' => $err_list);
			}
			else
			{
				$sql  = "SELECT     `character`.`id` ";
				$sql .= "FROM       `character` ";
				$sql .= "INNER JOIN `stage_character` ON  `character`.`id` = `stage_character`.`character_id` ";
				$sql .= "INNER JOIN `stage`           ON  `stage_character`.`stage_id` = `stage`.`id` ";
				$sql .= "                             AND `stage`.`id` = ? ";
				$sql .= "                             AND `stage`.`user_id` = ? ";
				$sql .= "                             AND `stage`.`is_delete` <> 1 ";
				$sql .= "WHERE      `character`.`id` = ? ";
				$sql .= "AND        `character`.`user_id` = ? ";
				$sql .= "AND        `character`.`is_delete` <> 1 ";
				$arg_list = array(
					$stage_id,
					$user_id,
					$character_id,
					$user_id,
				);
				$r = $this->query($sql, $arg_list);
				if (count($r) != 1)
				{
					$err_list[] = "エラーが発生しました。一旦画面をリロードしてやり直してください。";
					return array('error_message_list' => $err_list);
				}
			}
			if (!isset($q_list[$question]))
			{
				$err_list[] = "エラーが発生しました。一旦画面をリロードしてやり直してください。";
				return array('error_message_list' => $err_list);
			}
			if (mb_strlen($answer) == 0)
			{
				$err_list[] = "内容を入力してください。";
			}
			elseif (mb_strlen($answer) > 1000)
			{
				$err_list[] = "内容は1000文字以内で入力してください。";
			}
			if (count($err_list) > 0)
			{
				return array('error_message_list' => $err_list);
			}

			// 登録
			$arg_list = array();
			$sql  = "UPDATE `character_profile_stage` ";
			$sql .= "SET    `answer` = ? ";
			$sql .= "WHERE  `character_id` = ? ";
			$sql .= "AND    `stage_id` = ? ";
			$sql .= "AND    `question` = ? ";
			$arg_list[] = $answer;
			$arg_list[] = $character_id;
			$arg_list[] = $stage_id;
			$arg_list[] = $question;
			$this->query($sql, $arg_list);

			// 戻り値
			$return_list = array(
				'answer'         => $answer,
			);
			return $return_list;
		}
		catch (Exception $e)
		{
			$this->exception($e);
		}
	}

	public function delProfileStage($param_list = array())
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
			$character_id = trim($param_list['character_id']);
			$stage_id     = trim($param_list['stage_id']);
			$question     = trim($param_list['question']);

			// キャラクタープロフィール項目
			$q_list = $this->getConfig("character_profile_q", "value");

			// バリデート
			$err_list = array();
			if (!preg_match("/^[0-9]+$/", $character_id))
			{
				$err_list[] = "エラーが発生しました。一旦画面をリロードしてやり直してください。";
				return array('error_message_list' => $err_list);
			}
			else
			{
				$sql  = "SELECT     `character`.`id` ";
				$sql .= "FROM       `character` ";
				$sql .= "INNER JOIN `stage_character` ON  `character`.`id` = `stage_character`.`character_id` ";
				$sql .= "INNER JOIN `stage`           ON  `stage_character`.`stage_id` = `stage`.`id` ";
				$sql .= "                             AND `stage`.`id` = ? ";
				$sql .= "                             AND `stage`.`user_id` = ? ";
				$sql .= "                             AND `stage`.`is_delete` <> 1 ";
				$sql .= "WHERE      `character`.`id` = ? ";
				$sql .= "AND        `character`.`user_id` = ? ";
				$sql .= "AND        `character`.`is_delete` <> 1 ";
				$arg_list = array(
					$stage_id,
					$user_id,
					$character_id,
					$user_id,
				);
				$r = $this->query($sql, $arg_list);
				if (count($r) != 1)
				{
					$err_list[] = "エラーが発生しました。一旦画面をリロードしてやり直してください。";
					return array('error_message_list' => $err_list);
				}
			}
			if (!isset($q_list[$question]))
			{
				$err_list[] = "エラーが発生しました。一旦画面をリロードしてやり直してください。";
				return array('error_message_list' => $err_list);
			}
			if (count($err_list) > 0)
			{
				return array('error_message_list' => $err_list);
			}

			// 登録
			$arg_list = array();
			$sql  = "DELETE FROM `character_profile_stage` ";
			$sql .= "WHERE       `character_id` = ? ";
			$sql .= "AND         `stage_id` = ? ";
			$sql .= "AND         `question` = ? ";
			$arg_list[] = $character_id;
			$arg_list[] = $stage_id;
			$arg_list[] = $question;
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

	public function getProfileEpisode($param_list = array())
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
			$episode_id     = trim($param_list['episode_id']);

			$return_list = array();

			if (!preg_match("/^[0-9]+$/", $episode_id))
			{
				return array('error_message_list' => array("エラーが発生しました。一旦画面をリロードしてやり直してください。"));
			}

			// 取得（エピソード：本人の有効なステージに紐づいている場合のみ）
			$type_list = $this->getConfig("episode_type", "key");
			$sql  = "SELECT     `episode`.`id` ";
			$sql .= "          ,`episode`.`stage_id` ";
			$sql .= "FROM       `episode` ";
			$sql .= "INNER JOIN `stage` ON  `episode`.`stage_id` = `stage`.`id` ";
			$sql .= "                   AND `stage`.`user_id` = ? ";
			$sql .= "                   AND `stage`.`is_delete` <> 1 ";
			$sql .= "WHERE      `episode`.`id` = ? ";
			$sql .= "AND        `episode`.`type` = ? ";
			$sql .= "AND        `episode`.`is_delete` <> 1 ";
			$arg_list = array(
				$user_id,
				$episode_id,
				$type_list['override']['value'],
			);
			$r = $this->query($sql, $arg_list);
			if (count($r) != 1)
			{
				return array('error_message_list' => array("エラーが発生しました。一旦画面をリロードしてやり直してください。"));
			}
			$stage_id = $r[0]['stage_id'];

			// 戻り値の形をつくる
			$return_list['character_list'] = array();

			// 取得（キャラクター）
			$sql  = "SELECT     `character`.`id` ";
			$sql .= "          ,`character`.`name` ";
			$sql .= "          ,`character`.`is_private` ";
			$sql .= "FROM       `character` ";
			$sql .= "INNER JOIN `stage_character` ON  `character`.`id` = `stage_character`.`character_id` ";
			$sql .= "                             AND `stage_character`.`stage_id` = ? ";
			$sql .= "AND        `character`.`is_delete` <> 1 ";
			$sql .= "AND        `character`.`user_id` = ? ";
			$sql .= "ORDER BY   `stage_character`.`sort` = 0 ASC ";
			$sql .= "          ,`stage_character`.`sort` ASC ";
			$sql .= "          ,`stage_character`.`character_id` ASC ";
			$arg_list = array(
				$stage_id,
				$user_id,
			);
			$character_list = $this->query($sql, $arg_list);
			if (count($character_list) == 0)
			{
				// キャラクターが0人の場合は空配列を返して終了
				return $return_list;
			}
			foreach ($character_list as $v)
			{
				$return_list['character_list'][$v['id']] = array(
					'id'                   => $v['id'],
					'name'                 => $v['name'],
					'is_private'           => $v['is_private'],
					'profile_episode_list' => array(),

				);
			}

			// 取得（ステージ内の他エピソード）
			$sql  = "SELECT   `episode`.`id` ";
			$sql .= "FROM     `episode` ";
			$sql .= "WHERE    `episode`.`stage_id` = ? ";
			$sql .= "AND      `episode`.`type` = ? ";
			$sql .= "AND      `episode`.`is_delete` <> 1 ";
			$sql .= "ORDER BY `episode`.`sort` = 0 ASC ";
			$sql .= "        ,`episode`.`sort` ASC ";
			$sql .= "        ,`episode`.`id` ASC ";
			$arg_list = array(
				$stage_id,
				$type_list['override']['value'],
			);
			$episode_list = $this->query($sql, $arg_list);
			$prev_episode_list = array();
			$next_episode_list = array();
			$is_prev = true;
			foreach ($episode_list as $k => $v)
			{
				if ($v['id'] == $episode_id)
				{
					$is_prev = false;
				}
				elseif ($is_prev == true)
				{
					$prev_episode_list[$v['id']] = array(
						'id'     => $v['id'],
						'answer' => null,
					);
				}
				else
				{
					$next_episode_list[$v['id']] = array(
						'id'     => $v['id'],
						'answer' => null,
					);
				}
			}

			// 項目名
			$q_list = $this->getConfig("character_profile_q", "value");

			// 取得（プロフィール：基本）
			$arg_list = array();
			$sql  = "SELECT     `character_profile`.`character_id` ";
			$sql .= "          ,`character_profile`.`question` ";
			$sql .= "          ,`character_profile`.`answer` ";
			$sql .= "FROM       `character_profile` ";
			$sql .= "WHERE      `character_profile`.`character_id` IN (" . implode(",", array_fill(0, count($return_list['character_list']), "?")) . ") ";
			$sql .= "ORDER BY   `character_profile`.`sort` = 0 ASC ";
			$sql .= "          ,`character_profile`.`sort` ASC ";
			$sql .= "          ,`character_profile`.`create_stamp` ASC ";
			foreach ($return_list['character_list'] as $k => $v)
			{
				$arg_list[] = $v['id'];
			}
			$profile_list = $this->query($sql, $arg_list);
			foreach ($profile_list as $k => $v)
			{
				$return_list['character_list'][$v['character_id']]['profile_episode_list'][$v['question']] = array(
					'question'                 => $v['question'],
					'question_title'           => $q_list[$v['question']]['title'],
					'answer_base'              => $v['answer'],
					'answer_stage'             => null,
					'answer_episode'           => null,
					'answer_prev_episode_list' => $prev_episode_list,
					'answer_next_episode_list' => $next_episode_list,
				);
			}

			// 取得（プロフィール：オーバーライド：ステージ）
			$arg_list = array();
			$sql  = "SELECT     `character_profile_stage`.`character_id` ";
			$sql .= "          ,`character_profile_stage`.`question` ";
			$sql .= "          ,`character_profile_stage`.`answer` ";
			$sql .= "FROM       `character_profile_stage` ";
			$sql .= "WHERE      `character_profile_stage`.`character_id` IN (" . implode(",", array_fill(0, count($return_list['character_list']), "?")) . ") ";
			$sql .= "AND        `character_profile_stage`.`stage_id` = ? ";
			$sql .= "ORDER BY   `character_profile_stage`.`sort` = 0 ASC ";
			$sql .= "          ,`character_profile_stage`.`sort` ASC ";
			$sql .= "          ,`character_profile_stage`.`create_stamp` ASC ";
			foreach ($return_list['character_list'] as $k => $v)
			{
				$arg_list[] = $v['id'];
			}
			$arg_list[] = $stage_id;
			$profile_stage_list = $this->query($sql, $arg_list);
			foreach ($profile_stage_list as $k => $v)
			{
				if (!isset($return_list['character_list'][$v['character_id']]['profile_episode_list'][$v['question']]))
				{
					$return_list['character_list'][$v['character_id']]['profile_episode_list'][$v['question']] = array(
						'question'                 => $v['question'],
						'question_title'           => $q_list[$v['question']]['title'],
						'answer_base'              => null,
						'answer_stage'             => $v['answer'],
						'answer_episode'           => null,
						'answer_prev_episode_list' => $prev_episode_list,
						'answer_next_episode_list' => $next_episode_list,
					);
				}
				else
				{
					$return_list['character_list'][$v['character_id']]['profile_episode_list'][$v['question']]['answer_stage'] = $v['answer'];
				}
			}

			// 取得（プロフィール：オーバーライド：エピソード）
			$arg_list = array();
			$sql  = "SELECT     `character_profile_episode`.`character_id` ";
			$sql .= "          ,`character_profile_episode`.`episode_id` ";
			$sql .= "          ,`character_profile_episode`.`question` ";
			$sql .= "          ,`character_profile_episode`.`answer` ";
			$sql .= "FROM       `character_profile_episode` ";
			$sql .= "WHERE      `character_profile_episode`.`character_id` IN (" . implode(",", array_fill(0, count($return_list['character_list']), "?")) . ") ";
			$sql .= "AND        `character_profile_episode`.`episode_id` IN (" . implode(",", array_fill(0, count($episode_list), "?")) . ") ";
			$sql .= "ORDER BY   `character_profile_episode`.`sort` = 0 ASC ";
			$sql .= "          ,`character_profile_episode`.`sort` ASC ";
			$sql .= "          ,`character_profile_episode`.`create_stamp` ASC ";
			foreach ($return_list['character_list'] as $k => $v)
			{
				$arg_list[] = $v['id'];
			}
			foreach ($episode_list as $k => $v)
			{
				$arg_list[] = $v['id'];
			}
			$profile_episode_list = $this->query($sql, $arg_list);
			foreach ($profile_episode_list as $k => $v)
			{
				if (!isset($return_list['character_list'][$v['character_id']]['profile_episode_list'][$v['question']]))
				{
					$return_list['character_list'][$v['character_id']]['profile_episode_list'][$v['question']] = array(
						'question'                 => $v['question'],
						'question_title'           => $q_list[$v['question']]['title'],
						'answer_base'              => null,
						'answer_stage'             => null,
						'answer_episode'           => null,
						'answer_prev_episode_list' => $prev_episode_list,
						'answer_next_episode_list' => $next_episode_list,
					);
				}
				if ($v['episode_id'] == $episode_id)
				{
					$return_list['character_list'][$v['character_id']]['profile_episode_list'][$v['question']]['answer'] = $v['answer'];
				}
				elseif (isset($prev_episode_list[$v['episode_id']]))
				{
					$return_list['character_list'][$v['character_id']]['profile_episode_list'][$v['question']]['answer_prev_episode_list'][$v['episode_id']]['answer'] = $v['answer'];
				}
				elseif (isset($next_episode_list[$v['episode_id']]))
				{
					$return_list['character_list'][$v['character_id']]['profile_episode_list'][$v['question']]['answer_next_episode_list'][$v['episode_id']]['answer'] = $v['answer'];
				}
			}

			// 前後のエピソードが空の場合枠ごと削除
			// 配列のキーを削除
			foreach ($return_list['character_list'] as $k_character => $v_character)
			{
				foreach ($v_character['profile_episode_list'] as $k_question => $v_question)
				{
					foreach ($return_list['character_list'][$k_character]['profile_episode_list'][$k_question]['answer_prev_episode_list'] as $k_prev => $v_prev)
					{
						if ($v_prev['answer'] == "")
						{
							unset($return_list['character_list'][$k_character]['profile_episode_list'][$k_question]['answer_prev_episode_list'][$k_prev]);
						}
					}
					foreach ($return_list['character_list'][$k_character]['profile_episode_list'][$k_question]['answer_next_episode_list'] as $k_next => $v_next)
					{
						if ($v_next['answer'] == "")
						{
							unset($return_list['character_list'][$k_character]['profile_episode_list'][$k_question]['answer_next_episode_list'][$k_next]);
						}
					}
					$return_list['character_list'][$k_character]['profile_episode_list'][$k_question]['answer_prev_episode_list'] = array_values($return_list['character_list'][$k_character]['profile_episode_list'][$k_question]['answer_prev_episode_list']);
					$return_list['character_list'][$k_character]['profile_episode_list'][$k_question]['answer_next_episode_list'] = array_values($return_list['character_list'][$k_character]['profile_episode_list'][$k_question]['answer_next_episode_list']);
				}
				$return_list['character_list'][$k_character]['profile_episode_list'] = array_values($return_list['character_list'][$k_character]['profile_episode_list']);
			}
			$return_list['character_list'] = array_values($return_list['character_list']);

			// 戻り値
			return $return_list;
		}
		catch (Exception $e)
		{
			$this->exception($e);
		}
	}

	public function addProfileEpisode($param_list = array())
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
			$character_id = trim($param_list['character_id']);
			$episode_id   = trim($param_list['episode_id']);
			$question     = trim($param_list['question']);
			$answer       = trim($param_list['answer']);

			// キャラクタープロフィール項目
			$q_list = $this->getConfig("character_profile_q", "value");

			// バリデート
			$err_list = array();
			if (!preg_match("/^[0-9]+$/", $character_id))
			{
				$err_list[] = "エラーが発生しました。一旦画面をリロードしてやり直してください。";
				return array('error_message_list' => $err_list);
			}
			elseif (!preg_match("/^[0-9]+$/", $episode_id))
			{
				$err_list[] = "エラーが発生しました。一旦画面をリロードしてやり直してください。";
				return array('error_message_list' => $err_list);
			}
			else
			{
				$type_list = $this->getConfig("episode_type", "key");
				$sql  = "SELECT     `episode`.`id` ";
				$sql .= "          ,`episode`.`stage_id` ";
				$sql .= "FROM       `episode` ";
				$sql .= "INNER JOIN `stage` ON  `episode`.`stage_id` = `stage`.`id` ";
				$sql .= "                   AND `stage`.`user_id` = ? ";
				$sql .= "                   AND `stage`.`is_delete` <> 1 ";
				$sql .= "WHERE      `episode`.`id` = ? ";
				$sql .= "AND        `episode`.`type` = ? ";
				$sql .= "AND        `episode`.`is_delete` <> 1 ";
				$arg_list = array(
					$user_id,
					$episode_id,
					$type_list['override']['value'],
				);
				$r = $this->query($sql, $arg_list);
				if (count($r) != 1)
				{
					return array('error_message_list' => array("エラーが発生しました。一旦画面をリロードしてやり直してください。"));
				}
			}
			if (!isset($q_list[$question]))
			{
				$err_list[] = "エラーが発生しました。一旦画面をリロードしてやり直してください。";
				return array('error_message_list' => $err_list);
			}
			if (mb_strlen($answer) == 0)
			{
				$err_list[] = "内容を入力してください。";
			}
			elseif (mb_strlen($answer) > 1000)
			{
				$err_list[] = "内容は1000文字以内で入力してください。";
			}
			if (count($err_list) > 0)
			{
				return array('error_message_list' => $err_list);
			}

			// 登録
			$arg_list = array();
			$sql  = "INSERT INTO `character_profile_episode` (`character_id`, `episode_id`, `question`, `answer`) ";
			$sql .= "VALUES                                  (?             , ?           , ?         , ?       ) ";
			$arg_list[] = $character_id;
			$arg_list[] = $episode_id;
			$arg_list[] = $question;
			$arg_list[] = $answer;
			$this->query($sql, $arg_list);

			// 戻り値
			$return_list = array(
				'question'       => $question,
				'question_title' => $q_list[$question]['title'],
				'answer'         => $answer,
			);
			return $return_list;
		}
		catch (Exception $e)
		{
			$this->exception($e);
		}
	}

	public function setProfileEpisode($param_list = array())
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
			$character_id = trim($param_list['character_id']);
			$episode_id   = trim($param_list['episode_id']);
			$question     = trim($param_list['question']);
			$answer       = trim($param_list['answer']);

			// キャラクタープロフィール項目
			$q_list = $this->getConfig("character_profile_q", "value");

			// バリデート
			$err_list = array();
			if (!preg_match("/^[0-9]+$/", $character_id))
			{
				$err_list[] = "エラーが発生しました。一旦画面をリロードしてやり直してください。";
				return array('error_message_list' => $err_list);
			}
			elseif (!preg_match("/^[0-9]+$/", $episode_id))
			{
				$err_list[] = "エラーが発生しました。一旦画面をリロードしてやり直してください。";
				return array('error_message_list' => $err_list);
			}
			else
			{
				$type_list = $this->getConfig("episode_type", "key");
				$sql  = "SELECT     `episode`.`id` ";
				$sql .= "          ,`episode`.`stage_id` ";
				$sql .= "FROM       `episode` ";
				$sql .= "INNER JOIN `stage` ON  `episode`.`stage_id` = `stage`.`id` ";
				$sql .= "                   AND `stage`.`user_id` = ? ";
				$sql .= "                   AND `stage`.`is_delete` <> 1 ";
				$sql .= "WHERE      `episode`.`id` = ? ";
				$sql .= "AND        `episode`.`type` = ? ";
				$sql .= "AND        `episode`.`is_delete` <> 1 ";
				$arg_list = array(
					$user_id,
					$episode_id,
					$type_list['override']['value'],
				);
				$r = $this->query($sql, $arg_list);
				if (count($r) != 1)
				{
					return array('error_message_list' => array("エラーが発生しました。一旦画面をリロードしてやり直してください。"));
				}
			}
			if (!isset($q_list[$question]))
			{
				$err_list[] = "エラーが発生しました。一旦画面をリロードしてやり直してください。";
				return array('error_message_list' => $err_list);
			}
			if (mb_strlen($answer) == 0)
			{
				$err_list[] = "内容を入力してください。";
			}
			elseif (mb_strlen($answer) > 1000)
			{
				$err_list[] = "内容は1000文字以内で入力してください。";
			}
			if (count($err_list) > 0)
			{
				return array('error_message_list' => $err_list);
			}

			// 登録
			$arg_list = array();
			$sql  = "UPDATE `character_profile_episode` ";
			$sql .= "SET    `answer` = ? ";
			$sql .= "WHERE  `character_id` = ? ";
			$sql .= "AND    `episode_id` = ? ";
			$sql .= "AND    `question` = ? ";
			$arg_list[] = $answer;
			$arg_list[] = $character_id;
			$arg_list[] = $episode_id;
			$arg_list[] = $question;
			$this->query($sql, $arg_list);

			// 戻り値
			$return_list = array(
				'answer' => $answer,
			);
			return $return_list;
		}
		catch (Exception $e)
		{
			$this->exception($e);
		}
	}

	public function delProfileEpisode($param_list = array())
	{
		try
		{
			// ユーザID
			$user_id = $this->getLoginId();
			if ($user_id === false)
			{
				return array('error_redirect' => "session");
			}

			// 引数
			$character_id = trim($param_list['character_id']);
			$episode_id   = trim($param_list['episode_id']);
			$question     = trim($param_list['question']);

			// キャラクタープロフィール項目
			$q_list = $this->getConfig("character_profile_q", "value");

			// バリデート
			$err_list = array();
			if (!preg_match("/^[0-9]+$/", $character_id))
			{
				$err_list[] = "エラーが発生しました。一旦画面をリロードしてやり直してください。";
				return array('error_message_list' => $err_list);
			}
			else
			{
				$type_list = $this->getConfig("episode_type", "key");
				$sql  = "SELECT     `episode`.`id` ";
				$sql .= "          ,`episode`.`stage_id` ";
				$sql .= "FROM       `episode` ";
				$sql .= "INNER JOIN `stage` ON  `episode`.`stage_id` = `stage`.`id` ";
				$sql .= "                   AND `stage`.`user_id` = ? ";
				$sql .= "                   AND `stage`.`is_delete` <> 1 ";
				$sql .= "WHERE      `episode`.`id` = ? ";
				$sql .= "AND        `episode`.`type` = ? ";
				$sql .= "AND        `episode`.`is_delete` <> 1 ";
				$arg_list = array(
					$user_id,
					$episode_id,
					$type_list['override']['value'],
				);
				$r = $this->query($sql, $arg_list);
				if (count($r) != 1)
				{
					return array('error_message_list' => array("エラーが発生しました。一旦画面をリロードしてやり直してください。"));
				}
			}
			if (!isset($q_list[$question]))
			{
				$err_list[] = "エラーが発生しました。一旦画面をリロードしてやり直してください。";
				return array('error_message_list' => $err_list);
			}
			if (count($err_list) > 0)
			{
				return array('error_message_list' => $err_list);
			}

			// 登録
			$arg_list = array();
			$sql  = "DELETE FROM `character_profile_episode` ";
			$sql .= "WHERE       `character_id` = ? ";
			$sql .= "AND         `episode_id` = ? ";
			$sql .= "AND         `question` = ? ";
			$arg_list[] = $character_id;
			$arg_list[] = $episode_id;
			$arg_list[] = $question;
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

	public function getRelation($param_list = array())
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
			$id         = trim($param_list['id']);
			$another_id = trim($param_list['another_id']);

			$return_list = array();

			if (!preg_match("/^[0-9]+$/", $id) || !preg_match("/^[0-9]+$/", $another_id))
			{
				return array('error_message_list' => array("エラーが発生しました。一旦画面をリロードしてやり直してください。"));
			}

			// キャラクター情報取得
			// （本人の有効なキャラクターのみ抽出）
			$sql  = "SELECT `id`, `name` FROM `character` WHERE `id` IN (?, ?) AND `user_id` = ? AND `is_delete` <> 1 ";
			$arg_list = array($id, $another_id, $user_id);
			$character_list = $this->query($sql, $arg_list);
			if (count($character_list) != 2)
			{
				return array('error_message_list' => array("エラーが発生しました。一旦画面をリロードしてやり直してください。"));
			}
			$character_list = $this->setArrayKey($character_list, "id");

			// 取得（相関図：本人の有効なキャラクターに紐づいている場合のみ）
			$sql  = "SELECT     `character_relation`.`character_id_from` ";
			$sql .= "          ,`character_relation`.`character_id_to` ";
			$sql .= "          ,`character_relation`.`is_both` ";
			$sql .= "          ,`character_relation`.`title` ";
			$sql .= "          ,`character_relation`.`free_text` ";
			$sql .= "FROM       `character_relation` ";
			$sql .= "WHERE      (`character_relation`.`character_id_from` = ? AND `character_relation`.`character_id_to` = ?) ";
			$sql .= "OR         (`character_relation`.`character_id_from` = ? AND `character_relation`.`character_id_to` = ?) ";
			$arg_list = array(
				$id,
				$another_id,
				$another_id,
				$id,
			);
			$relation_list = $this->query($sql, $arg_list);

			// 戻り値の形をつくる
			$return_list['character_id']   = $another_id;
			$return_list['character_name'] = $character_list[$another_id]['name'];
			$return_list['is_both']        = 0;
			$return_list['title_a']        = "";
			$return_list['free_text_a']    = "";
			$return_list['title_b']        = "";
			$return_list['free_text_b']    = "";
			foreach ($relation_list as $v)
			{
				$return_list['is_both'] = $return_list['is_both'] || $v['is_both'];
				if ($v['character_id_from'] == $id)
				{
					$return_list['title_a']     = $v['title'];
					$return_list['free_text_a'] = $v['free_text'];
				}
				else
				{
					$return_list['title_b']     = $v['title'];
					$return_list['free_text_b'] = $v['free_text'];
				}
			}

			// 戻り値
			return $return_list;
		}
		catch (Exception $e)
		{
			$this->exception($e);
		}
	}

	public function upsertRelation($param_list = array())
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
			$character_id_from = trim($param_list['character_id']);
			$character_id_to   = trim($param_list['character_another_id']);
			$is_both           = trim($param_list['is_both']) == "1" ? "1" : "0";
			$title_a           = trim($param_list['title_a']);
			$title_b           = trim($param_list['title_b']);
			$free_text_a       = trim($param_list['free_text_a']);
			$free_text_b       = trim($param_list['free_text_b']);

			// バリデート
			$err_list = array();
			if (!preg_match("/^[0-9]+$/", $character_id_from) || !preg_match("/^[0-9]+$/", $character_id_to))
			{
				$err_list[] = "エラーが発生しました。一旦画面をリロードしてやり直してください。";
				return array('error_message_list' => $err_list);
			}
			else
			{
				$sql = "SELECT `id`, `name` FROM `character` WHERE `id` IN (?, ?) AND `user_id` = ? AND `is_delete` <> 1 ";
				$arg_list = array($character_id_from, $character_id_to, $user_id);
				$character_list = $this->setArrayKey($this->query($sql, $arg_list), "id");
				if (count($character_list) != 2)
				{
					$err_list[] = "エラーが発生しました。一旦画面をリロードしてやり直してください。";
					return array('error_message_list' => $err_list);
				}
			}
			if ($is_both == "1" && mb_strlen($title_a) > 32)
			{
				$err_list[] = "タイトルは32文字以内で入力してください。";
			}
			elseif (mb_strlen($title_a) > 32)
			{
				$err_list[] = "タイトル（" . $character_list[$character_id_from]['name'] . "→" . $character_list[$character_id_to]['name'] . "）は32文字以内で入力してください。";
			}
			if (mb_strlen($title_b) > 32)
			{
				$err_list[] = "タイトル（" . $character_list[$character_id_to]['name'] . "→" . $character_list[$character_id_from]['name'] . "）は32文字以内で入力してください。";
			}
			if (mb_strlen($free_text_a) > 1000)
			{
				$err_list[] = "フリーテキスト（" . $character_list[$character_id_from]['name'] . "→" . $character_list[$character_id_to]['name'] . "）は1000文字以内で入力してください。";
			}
			if (mb_strlen($free_text_b) > 1000)
			{
				$err_list[] = "フリーテキスト（" . $character_list[$character_id_to]['name'] . "→" . $character_list[$character_id_from]['name'] . "）は1000文字以内で入力してください。";
			}
			if (count($err_list) > 0)
			{
				return array('error_message_list' => $err_list);
			}

			// 既存データを一旦削除
			$arg_list = array();
			$sql  = "DELETE FROM `character_relation` ";
			$sql .= "WHERE       (`character_id_from` = ? AND `character_id_to` = ?) ";
			$sql .= "OR          (`character_id_from` = ? AND `character_id_to` = ?) ";
			$arg_list[] = $character_id_from;
			$arg_list[] = $character_id_to;
			$arg_list[] = $character_id_to;
			$arg_list[] = $character_id_from;
			$this->query($sql, $arg_list);

			// 登録
			if ($is_both == 1)
			{
				if ($title_a != "" || $free_text_a != "" || $free_text_b != "")
				{
					$arg_list = array();
					$sql  = "INSERT INTO `character_relation` (`character_id_from`, `character_id_to`, `is_both`, `title`, `free_text`) ";
					$sql .= "VALUES                           (?                  , ?                , ?        , ?      , ?          ) ";
					$sql .= "                                ,(?                  , ?                , ?        , ?      , ?          ) ";
					$arg_list[] = $character_id_from;
					$arg_list[] = $character_id_to;
					$arg_list[] = $is_both;
					$arg_list[] = $title_a     == "" ? null : $title_a;
					$arg_list[] = $free_text_a == "" ? null : $free_text_a;
					$arg_list[] = $character_id_to;
					$arg_list[] = $character_id_from;
					$arg_list[] = $is_both;
					$arg_list[] = $title_b     == "" ? null : $title_b;
					$arg_list[] = $free_text_b == "" ? null : $free_text_b;
					$this->query($sql, $arg_list);
				}
			}
			else
			{
				if ($title_a != "" || $free_text_a != "")
				{
					$arg_list = array();
					$sql  = "INSERT INTO `character_relation` (`character_id_from`, `character_id_to`, `is_both`, `title`, `free_text`) ";
					$sql .= "VALUES                           (?                  , ?                , ?        , ?      , ?          ) ";
					$arg_list[] = $character_id_from;
					$arg_list[] = $character_id_to;
					$arg_list[] = $is_both;
					$arg_list[] = $title_a     == "" ? null : $title_a;
					$arg_list[] = $free_text_a == "" ? null : $free_text_a;
					$this->query($sql, $arg_list);
				}
				if ($title_b != "" || $free_text_b != "")
				{
					$arg_list = array();
					$sql  = "INSERT INTO `character_relation` (`character_id_from`, `character_id_to`, `is_both`, `title`, `free_text`) ";
					$sql .= "VALUES                           (?                  , ?                , ?        , ?      , ?          ) ";
					$arg_list[] = $character_id_to;
					$arg_list[] = $character_id_from;
					$arg_list[] = $is_both;
					$arg_list[] = $title_b     == "" ? null : $title_b;
					$arg_list[] = $free_text_b == "" ? null : $free_text_b;
					$this->query($sql, $arg_list);
				}
			}

			// 戻り値
			return array(
				'is_both'     => $is_both,
				'title_a'     => $title_a,
				'title_b'     => $title_b,
				'free_text_a' => $free_text_a,
				'free_text_b' => $free_text_b,
			);
		}
		catch (Exception $e)
		{
			$this->exception($e);
		}
	}
}
