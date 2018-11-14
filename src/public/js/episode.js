// URLクリック時は編集modalを開かない
$(document).on("click", ".timeline-url", function(){
	javascript_die(); // 強制終了
});

// 鍵アイコンクリック時は公開/非公開を切り替え
// また、編集modalを開かない
$(document).on("click", ".set_episode-is_private", function(){
	setEpisodeIsPrivate($(this).parents(".timeline-editable").data("id"), $(this).hasClass("is_private_0") == true ? 1 : 0);
	javascript_die(); // 強制終了
});

// カーソル位置に「続きを読む」マーカーを挿入
$(document).on("click", ".insert-read-more", function(){
	// テキストエリアのオブジェクト
	var obj_ta = $(this).parent().find("textarea");
	// 挿入位置
	var cursor = obj_ta.get(0).selectionStart;
	// 本文
	var str_before = obj_ta.val();

	// 本文に「=====」を挿入
	obj_ta.val(str_before.slice(0, cursor) + "=====" + str_before.slice(cursor));

	// カーソルを元の位置＋5文字の位置に置く
	obj_ta.get(0).focus();
	obj_ta.get(0).selectionStart = cursor + 5;
	obj_ta.get(0).selectionEnd = cursor + 5;
});

//
$(document).on("click", "#add_forms-override .character-selectable", function(){
	$("#add_forms-override .character-selectable").removeClass("selected");
	$(this).addClass("selected");
});

// 登録フォームの切り替え
$(document).on("click", ".forms-switch", function(){
	$("#add_forms-common").addClass("hidden");
	$("#add_forms-label").addClass("hidden");
	$("#add_forms-override").addClass("hidden");
	$("#add_forms-" + $(this).data("target_forms_id")).removeClass("hidden");

	$(".btn-form_common").removeClass("active");
	$(".btn-form_label").removeClass("active");
	$(".btn-form_override").removeClass("active");
	$(this).addClass("active");

	$(".btn-add_common").addClass("hidden");
	$(".btn-add_label").addClass("hidden");
	$(".btn-add_override").addClass("hidden");
	$(".btn-add_" + $(this).data("target_forms_id")).removeClass("hidden");
});

// 「続きを読む」の切り替え
$(".timeline-free_text_show").on("click", function(){
	$(".timeline-free_text").addClass("hidden");
	$(".timeline-free_text_show").addClass("hidden");
	$(".timeline-free_text_full").removeClass("hidden");
	$(".timeline-free_text_hide").removeClass("hidden");
});
$(".timeline-free_text_hide").on("click", function(){
	$(".timeline-free_text_full").addClass("hidden");
	$(".timeline-free_text_hide").addClass("hidden");
	$(".timeline-free_text").removeClass("hidden");
	$(".timeline-free_text_show").removeClass("hidden");
});

/*
 * 一覧取得
 */
function timeline(params){
	if (params == undefined)
	{
		//todo:: パラメータ未定義の場合
		var params = {};
	}

	var result = ajaxPost("episode", "timeline", params);
	result.done(function(){
		if (isAjaxResultErrorRedirect(result.return_value) === true) {return false;}  // 必要ならエラーページへリダイレクト
		if (isAjaxResultErrorMsg(result.return_value) === true ){return false;} // 必要ならエラーメッセージ表示

		// 正常な場合
		// テーブルに描画
		if (result.return_value['episode_list'].length > 0){
			$(result.return_value['episode_list']).each(function(i, e){
				drawEpisodeList(e);
			});
		}

		return true;
    });
}

/*
 * 登録
 */
function addEpisodeCommon(){
	var character = [];
	$("#add_forms-common").find(".badge.character-selectable:not(.character-notselected)").each(function(i, e){
		character.push($(e).attr("value"));
	});
	var params = {
			'stage_id'       : $("#modal-addEpisode").find(".form-stage_id").val(),
			'is_private'     : $("#modal-addEpisode .form-is_private:not(.hide)").data("is_private"),
			'title'          : $("#add_forms-common .form-title").val(),
			'url'            : $("#add_forms-common .form-url").val(),
			'free_text'      : $("#add_forms-common .form-free_text").val(),
			'is_r18'         : $("#add_forms-common .form-is_r18").prop("checked") ? "1" : "0",
			'character_list' : character,
			'type_key'       : "common",
		};
	var result = ajaxPost("episode", "addCommon", params);
	result.done(function(){
		if (isAjaxResultErrorRedirect(result.return_value) === true) {return false;}  // 必要ならエラーページへリダイレクト
		if (isAjaxResultErrorMsg(result.return_value) === true ){return false;} // 必要ならエラーメッセージ表示

		// 正常な場合

		// 描画
		params['id'] = result.return_value.id;
		params['url_view'] = result.return_value.url_view;
		drawEpisodeList(params);

		// モーダルを閉じる
		$('#modal-addEpisode').modal('hide');

		// モーダルを初期化
		initAddEpisodeModal();
		return true;
	});
}
function addEpisodeLabel(){
	var params = {
			'stage_id'       : $("#modal-addEpisode").find(".form-stage_id").val(),
			'is_private'     : $("#modal-addEpisode .form-is_private:not(.hide)").data("is_private"),
			'title'          : $("#add_forms-label .form-title").val(),
			'type_key'       : "label",
		};
	var result = ajaxPost("episode", "addLabel", params);
	result.done(function(){
		if (isAjaxResultErrorRedirect(result.return_value) === true) {return false;}  // 必要ならエラーページへリダイレクト
		if (isAjaxResultErrorMsg(result.return_value) === true ){return false;} // 必要ならエラーメッセージ表示

		// 正常な場合

		// 描画
		params['id'] = result.return_value.id;
		drawEpisodeList(params);

		// モーダルを閉じる
		$('#modal-addEpisode').modal('hide');

		// モーダルを初期化
		initAddEpisodeModal();
		return true;
	});
}
function addEpisodeOverride(){
	var params = {
			'stage_id'     : $("#modal-addEpisode").find(".form-stage_id").val(),
			'is_private'   : $("#modal-addEpisode .form-is_private:not(.hide)").data("is_private"),
			'title'        : $("#add_forms-override .form-title").val(),
			'type_key'     : "override",
		};
	var result = ajaxPost("episode", "addOverride", params);
	result.done(function(){
		if (isAjaxResultErrorRedirect(result.return_value) === true) {return false;}  // 必要ならエラーページへリダイレクト
		if (isAjaxResultErrorMsg(result.return_value) === true ){return false;} // 必要ならエラーメッセージ表示

		// 正常な場合

		// 描画
		params['id'] = result.return_value.id;
		drawEpisodeList(params);

		// モーダルを閉じる
		$('#modal-addEpisode').modal('hide');

		// モーダルを初期化
		initAddEpisodeModal();

		// 編集モーダルを開く
		$('li.timeline-editable.clickable[data-id=' + params['id'] + ']').trigger("click");

		return true;
	});
}

/*
 * 更新
 */
function setEpisodeCommon(){
	var character = [];
	$("#set_forms-common").find(".badge.character-selectable:not(.character-notselected)").each(function(i, e){
		character.push($(e).attr("value"));
	});
	var params = {
			'id'             : $("#modal-setEpisode").find(".form-id").val(),
			'is_private'     : $("#modal-setEpisode").find(".form-is_private:not(.hide)").data("is_private"),
			'title'          : $("#set_forms-common").find(".form-title").val(),
			'url'            : $("#set_forms-common").find(".form-url").val(),
			'free_text'      : $("#set_forms-common").find(".form-free_text").val(),
			'is_r18'         : $("#set_forms-common").find(".form-is_r18").prop("checked") ? "1" : "0",
			'character_list' : character,
		};

	var result = ajaxPost("episode", "setCommon", params);
	result.done(function(){
		if (isAjaxResultErrorRedirect(result.return_value) === true) {return false;}  // 必要ならエラーページへリダイレクト
		if (isAjaxResultErrorMsg(result.return_value) === true ){return false;} // 必要ならエラーメッセージ表示

		// 正常な場合

		// 描画
		drawEpisodeList(params, params['id']);

		// モーダルを閉じる
		$('#modal-setEpisode').modal('hide');

		// モーダルを初期化
		initSetEpisodeModal();
	});
}
function setEpisodeLabel(){
	var params = {
			'id'         : $("#modal-setEpisode").find(".form-id").val(),
			'is_private' : $("#modal-setEpisode").find(".form-is_private:not(.hide)").data("is_private"),
			'title'      : $("#set_forms-label").find(".form-title").val(),
		};

	var result = ajaxPost("episode", "setLabel", params);
	result.done(function(){
		if (isAjaxResultErrorRedirect(result.return_value) === true) {return false;}  // 必要ならエラーページへリダイレクト
		if (isAjaxResultErrorMsg(result.return_value) === true ){return false;} // 必要ならエラーメッセージ表示

		// 正常な場合

		// 描画
		drawEpisodeList(params, params['id']);

		// モーダルを閉じる
		$('#modal-setEpisode').modal('hide');

		// モーダルを初期化
		initSetEpisodeModal();
	});
}
function setEpisodeOverride(){
	console.log("setEpisodeOverride");
}

/*
 * 更新（公開/非公開）
 */
function setEpisodeIsPrivate(id, is_private){
	var params = {
			'id'         : id,
			'is_private' : is_private,
		};
	var result = ajaxPost("episode", "setIsPrivate", params);
    result.done(function(){
		if (isAjaxResultErrorRedirect(result.return_value) === true) {return false;}  // 必要ならエラーページへリダイレクト
		if (isAjaxResultErrorMsg(result.return_value) === true ){return false;} // 必要ならエラーメッセージ表示

		// 正常な場合
		$(".timeline-editable[data-id='" + id + "']").find(".is_private_icon.is_private_" + (is_private == "1" ? "0" : "1")).addClass("template-for-copy");
		$(".timeline-editable[data-id='" + id + "']").find(".is_private_icon.is_private_" + is_private).removeClass("template-for-copy");
		return true;
	});
}

/*
 * 削除
 */
function delEpisode(){
    if (!confirm("本当にこのエピソードを削除してよろしいですか？")){
        return false;
    }
    var id = $("#modal-setEpisode").find(".form-id").val();
	var params = {
			'id' : id,
		};
	var result = ajaxPost("episode", "del", params);
    result.done(function(){
		if (isAjaxResultErrorRedirect(result.return_value) === true) {return false;}  // 必要ならエラーページへリダイレクト
		if (isAjaxResultErrorMsg(result.return_value) === true ){return false;} // 必要ならエラーメッセージ表示

		// 正常な場合
		$("#timeline_for_stage > li[data-id='" + id + "']").remove();
		$('#modal-setEpisode').modal('hide');
		return true;
    });
}

/*
 * ソートモード切替
 */
function readyEpisodeSort(mode){
	if (mode == 1){
		// ONにする場合
		$(".sort_mode_off").hide();
		$(".sort_mode_on").show();
		$(".timeline-sort-area").addClass("sortable");
		sortableTimeline(mode);
	}
	else{
		// OFFにする場合
		$(".sort_mode_on").hide();
		$(".sort_mode_off").show();
		sortableTimeline(mode);
		$(".timeline-sort-area").removeClass("sortable");
	}
	return;
}

/*
 * local::モーダルの初期化
 */
function initAddEpisodeModal(){
	// タイプごとの切り替え
	$("#add_forms-common").removeClass("hidden");
	$("#add_forms-label").addClass("hidden");
	$("#add_forms-override").addClass("hidden");

	// ボタンのアクティブ状態
	$("#modal-addEpisode").find(".btn-form_common").addClass("active");
	$("#modal-addEpisode").find(".btn-form_label").removeClass("active");
	$("#modal-addEpisode").find(".btn-form_override").removeClass("active");

	// 登録ボタンの切り替え
	$(".btn-add_common").removeClass("hidden");
	$(".btn-add_label").addClass("hidden");
	$(".btn-add_override").addClass("hidden");

	// フォームの中身をクリア
	$("#modal-addEpisode").find("input[type=text]").val("");
	$("#modal-addEpisode").find("textarea").val("");
	$("#modal-addEpisode").find("input[type=checkbox]").prop("checked", false);
	$("#modal-addEpisode").find(".character-selectable:not(.character-notselected)").addClass("character-notselected");
	$("#modal-addEpisode").find(".form-is_private[data-is_private=0]").addClass("hide");
	$("#modal-addEpisode").find(".form-is_private[data-is_private=1]").removeClass("hide");
}
function initSetEpisodeModal(){
	// タイプごとの切り替え
	$("#set_forms-common").addClass("hidden");
	$("#set_forms-label").addClass("hidden");
	$("#set_forms-override").addClass("hidden");

	// 登録ボタンの切り替え
	$(".btn-set_common").addClass("hidden");
	$(".btn-set_label").addClass("hidden");
	$(".btn-set_override").addClass("hidden");

	// フォームの中身をクリア
	$("#modal-setEpisode").find("input[type=text]").val("");
	$("#modal-setEpisode").find("textarea").val("");
	$("#modal-setEpisode").find("input[type=checkbox]").prop("checked", false);
	$("#modal-setEpisode").find(".character-selectable:not(.character-notselected)").addClass("character-notselected");
	$("#modal-setEpisode").find(".form-is_private[data-is_private=0]").addClass("hide");
	$("#modal-setEpisode").find(".form-is_private[data-is_private=1]").removeClass("hide");
}

/*
 * local::一覧描画
 */
function drawEpisodeList(dat, id){
	if (dat.type_key == "label"){
		if (id == undefined){
			// 新規：行をコピー
			var obj_base = $("#timeline_for_stage_template").find(".timeline-label")[0];
			var obj = $(obj_base).clone().appendTo($("#timeline_for_stage"));
		}
		else{
			// 更新：対象の行を取得
			var obj = $("#timeline_for_stage > li[data-id='" + id + "']");
		}

		// データ貼り付け
		$(obj).data("id", dat.id);
		$(obj).attr("data-id", dat.id);
		$(obj).find(".timeline-title").text(dat.title);
		$(obj).find(".is_private_icon.is_private_" + (dat.is_private == "1" ? "1" : "0")).removeClass("template-for-copy");
		$(obj).find(".timeline-label").removeClass("template-for-copy");
	}
	else{
		if (id == undefined){
			// 新規：行をコピー
			var obj_base = $("#timeline_for_stage_template").find(".timeline-content")[0];
			var obj = $(obj_base).clone().appendTo($("#timeline_for_stage"));
		}
		else{
			// 更新：対象の行を取得
			var obj = $("#timeline_for_stage > li[data-id='" + id + "']");
		}

		// オーバーライド時のテキスト生成
		if (dat.type_key == "override"){
			if (dat.override_character_list == undefined){
				dat.free_text = "[未設定]";
			}
			else{
				if (dat.override_character_list.length > 3){
					dat.free_text = "A,B,C 他 n 人のオーバーライド"; // todo::
				}
				else{
					dat.free_text = "A,B のオーバーライド"; // todo::
				}
			}
		}

		// データ貼り付け
		$(obj).data("id", dat.id);
		$(obj).attr("data-id", dat.id);
		$(obj).find(".is_private_icon.is_private_" + (dat.is_private == "1" ? "1" : "0")).removeClass("template-for-copy");
		$(obj).find(".is_private_icon.is_private_" + (dat.is_private == "1" ? "0" : "1")).addClass("template-for-copy");
		$(obj).find(".type_icon.episode_type_" + dat.type_key).removeClass("template-for-copy");
		if (dat.title != undefined && dat.title != ""){
			$(obj).find(".timeline-title").text(dat.title);
			$(obj).find(".timeline-title").removeClass("template-for-copy");
		}
		else{
			$(obj).find(".timeline-title").text("");
			$(obj).find(".timeline-title").addClass("template-for-copy");
		}
		if (dat.url != undefined && dat.url != ""){
			$(obj).find(".timeline-url > a").attr("href", dat.url);
			$(obj).find(".timeline-url > a").text(dat.url_view);
			$(obj).find(".timeline-url").removeClass("template-for-copy");
		}
		else{
			$(obj).find(".timeline-url").text("");
			$(obj).find(".timeline-url").addClass("template-for-copy");
		}
		if (dat.free_text != undefined && dat.free_text != ""){
			$(obj).find(".timeline-free_text").html(strToText(dat.free_text));
			$(obj).find(".timeline-free_text").removeClass("template-for-copy");
		}
		else{
			$(obj).find(".timeline-free_text").text("");
			$(obj).find(".timeline-free_text").addClass("template-for-copy");
		}
		$(obj).find(".timeline-content").removeClass("template-for-copy");
	}

	// テンプレート用クラスを外す
	obj.removeClass("template-for-copy");
}

/*
 * local::ドラッグ＆ドロップでソート可能にする
 */
function sortableTimeline(mode) {
	if (mode != 1){
		$(".timeline-sort-area.sortable").sortable("destroy");
		return true;
	}

	$(".timeline-sort-area.sortable").sortable({
		update: function(){
			var ids = [];
			$("#timeline_for_stage").find("li").each(function(i, e){
				ids.push($(e).data("id"));
			});
			var params = {
				id_list : ids,
			};

			var result = ajaxPost("episode", "setSort", params);
			result.done(function(){
				if (isAjaxResultErrorRedirect(result.return_value) === true) {return false;}  // 必要ならエラーページへリダイレクト
				if (isAjaxResultErrorMsg(result.return_value) === true ){return false;} // 必要ならエラーメッセージ表示

				// 正常な場合
				return true;
			});
		}
	});
	return true;
}

/*
 * エピソード更新フォームに値をセット
 */
$(document).on("click", "li.timeline-editable", function(){
	var id = $(this).data("id");

	var result = ajaxPost("episode", "get", {id: id});
    result.done(function(){
		if (isAjaxResultErrorRedirect(result.return_value) === true) {return false;}  // 必要ならエラーページへリダイレクト
		if (isAjaxResultErrorMsg(result.return_value) === true ){return false;} // 必要ならエラーメッセージ表示
		if (isAjaxResultNoData(result.return_value['episode']['id']) === true ){return false;} // データがない場合はエラー表示

		// 正常な場合

		// タイプごとの切り替え
		$("#set_forms-common").addClass("hidden");
		$("#set_forms-label").addClass("hidden");
		$("#set_forms-override").addClass("hidden");
		$("#set_forms-" + result.return_value['episode']['type_key']).removeClass("hidden");

		// ボタンのアクティブ状態
		$("#modal-setEpisode").find(".btn-form_common").removeClass("active");
		$("#modal-setEpisode").find(".btn-form_label").removeClass("active");
		$("#modal-setEpisode").find(".btn-form_override").removeClass("active");
		$("#modal-setEpisode").find(".btn-form_" + result.return_value['episode']['type_key']).addClass("active");

		// 登録ボタンの切り替え
		$(".btn-set_common").addClass("hidden");
		$(".btn-set_label").addClass("hidden");
		$(".btn-set_override").addClass("hidden");
		$(".btn-set_" + result.return_value['episode']['type_key']).removeClass("hidden");

		// 取得したデータをセット
		$("#modal-setEpisode").find(".form-id").val(result.return_value['episode']['id']);
		if (result.return_value['episode']['is_private'] == "0"){
			$("#modal-setEpisode").find(".form-is_private[data-is_private=0]").removeClass("hide");
			$("#modal-setEpisode").find(".form-is_private[data-is_private=1]").addClass("hide");
		}
		else{
			$("#modal-setEpisode").find(".form-is_private[data-is_private=1]").removeClass("hide");
			$("#modal-setEpisode").find(".form-is_private[data-is_private=0]").addClass("hide");
		}
		$("#modal-setEpisode").find(".form-title").val(result.return_value['episode']['title']);
		$("#modal-setEpisode").find(".form-url").val(result.return_value['episode']['url']);
		$("#modal-setEpisode").find(".form-free_text").val(result.return_value['episode']['free_text']);
		$("#modal-setEpisode").find(".form-is_r18").prop("checked", result.return_value['episode']['is_r18'] == "1" ? true : false);
		$(result.return_value['episode']['character_list']).each(function(i, e){
			$("#modal-setEpisode").find(".character-selectable[value='" + e.id + "']").removeClass("character-notselected");
		});

		return true;
    });
});