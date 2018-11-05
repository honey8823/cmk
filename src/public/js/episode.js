// ラベルかどうかでフォームの表示切替
$("#modal-addEpisode").find(".form-is_label").on("click", function(){
	if ($(this).prop('checked')){
		$("#modal-addEpisode").find(".not_use_for_label").hide();
	}
	else{
		$("#modal-addEpisode").find(".not_use_for_label").show();
	}
});

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
function addEpisode(){
	var character = [];
	$("#modal-addEpisode").find(".badge.character-selectable:not(.character-notselected)").each(function(i, e){
		character.push($(e).attr("value"));
	});
	var params = {
			'stage_id'       : $("#modal-addEpisode").find(".form-stage_id").val(),
			'is_label'       : $("#modal-addEpisode").find(".form-is_label").prop("checked") ? "1" : "0",
			'category'       : $("#modal-addEpisode").find(".form-category:checked").val(),
			'title'          : $("#modal-addEpisode").find(".form-title").val(),
			'url'            : $("#modal-addEpisode").find(".form-url").val(),
			'free_text'      : $("#modal-addEpisode").find(".form-free_text").val(),
			'is_r18'         : $("#modal-addEpisode").find(".form-is_r18").prop("checked") ? "1" : "0",
			'is_private'     : $("#modal-addEpisode").find(".form-is_private:not(.hide)").data("is_private"),
			'character_list' : character,
		};
	var result = ajaxPost("episode", "add", params);
	result.done(function(){
		if (isAjaxResultErrorRedirect(result.return_value) === true) {return false;}  // 必要ならエラーページへリダイレクト
		if (isAjaxResultErrorMsg(result.return_value) === true ){return false;} // 必要ならエラーメッセージ表示

		// 正常な場合
		params['id'] = result.return_value.id;
		drawEpisodeList(params);
		$('#modal-addEpisode').modal('hide');
		$("#modal-addEpisode").find("input:not([type=hidden]):not([type=radio]):not([type=checkbox])").val("");
		$("#modal-addEpisode").find(".form-category").val(["1"]);
		$("#modal-addEpisode").find("input[type=checkbox]").prop("checked", false);
		$("#modal-addEpisode").find("textarea").val("");
		$("#modal-addEpisode").find(".character-selectable:not(.character-notselected)").addClass("character-notselected");
		$("#modal-addEpisode").find(".not_use_for_label").show();
		return true;
	});
}

/*
 * 更新
 */
function setEpisode(){
	var character = [];
	$("#modal-setEpisode").find(".badge.character-selectable:not(.character-notselected)").each(function(i, e){
		character.push($(e).attr("value"));
	});
	var params = {
			'id'             : $("#modal-setEpisode").find(".form-id").val(),
			'category'       : $("#modal-setEpisode").find(".form-category:checked").val(),
			'title'          : $("#modal-setEpisode").find(".form-title").val(),
			'url'            : $("#modal-setEpisode").find(".form-url").val(),
			'free_text'      : $("#modal-setEpisode").find(".form-free_text").val(),
			'is_r18'         : $("#modal-setEpisode").find(".form-is_r18").prop("checked") ? "1" : "0",
			'is_private'     : $("#modal-setEpisode").find(".form-is_private:not(.hide)").data("is_private"),
			'character_list' : character,
		};

	var result = ajaxPost("episode", "set", params);
	result.done(function(){
		if (isAjaxResultErrorRedirect(result.return_value) === true) {return false;}  // 必要ならエラーページへリダイレクト
		if (isAjaxResultErrorMsg(result.return_value) === true ){return false;} // 必要ならエラーメッセージ表示

		// 正常な場合
		drawEpisodeList(params, params['id']);
		$('#modal-setEpisode').modal('hide');
		return true;
	});
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
 * local::一覧描画
 */
function drawEpisodeList(dat, id){

	if (dat.is_label == 1){
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

		// データ貼り付け
		$(obj).data("id", dat.id);
		$(obj).attr("data-id", dat.id);
		$(obj).find(".is_private_icon.is_private_" + (dat.is_private == "1" ? "1" : "0")).removeClass("template-for-copy");
		$(obj).find(".is_private_icon.is_private_" + (dat.is_private == "1" ? "0" : "1")).addClass("template-for-copy");
		$(obj).find(".category_icon.category_" + dat.category).removeClass("template-for-copy");
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

//	// タグ
//	$(dat.tag_list).each(function(i_tag, e_tag){
//		var obj_tag_base = $(obj).find(".td-tag > .tag-base.template-for-copy")[0];
//		var obj_tag = $(obj_tag_base).clone().appendTo($(obj_tag_base).parent());
//
//		// タグ略称
//		obj_tag.addClass("tag-" + e_tag.category_key);
//		obj_tag.text(e_tag.name_short);
//
//		// テンプレート用クラスを外す
//		obj_tag.removeClass("template-for-copy");
//	});
//
//	// 公開/非公開
//	if (dat.is_private == 1){
//		$(obj).find(".stage_is_private_0").remove();
//	}
//	else {
//		$(obj).find(".stage_is_private_1").remove();
//	}
//
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
		$("#modal-setEpisode").find(".form-is_private:not([data-is_private='" + result.return_value['episode']['is_private'] + "'])").addClass("hide");
		$("#modal-setEpisode").find(".form-is_private[data-is_private='" + result.return_value['episode']['is_private'] + "']").removeClass("hide");
		$("#modal-setEpisode").find(".form-id").val(result.return_value['episode']['id']);
		$("#modal-setEpisode").find(".form-is_label").val(result.return_value['episode']['is_label']);
		$("#modal-setEpisode").find(".form-title").val(result.return_value['episode']['title']);
		$("#modal-setEpisode").find(".character-selectable").addClass("character-notselected");

		if (result.return_value['episode']['is_label'] == 1){
			$("#modal-setEpisode").find(".not_use_for_label").hide();
			$("#modal-setEpisode").find(".form-category").val([""]);
			$("#modal-setEpisode").find(".form-url").val("");
			$("#modal-setEpisode").find(".form-free_text").val("");
			$("#modal-setEpisode").find(".form-is_r18").prop("checked", false);
		}
		else{
			$("#modal-setEpisode").find(".not_use_for_label").show();
			$("#modal-setEpisode").find(".form-category").val([result.return_value['episode']['category']]);
			$("#modal-setEpisode").find(".form-url").val(result.return_value['episode']['url']);
			$("#modal-setEpisode").find(".form-free_text").val(result.return_value['episode']['free_text']);
			$("#modal-setEpisode").find(".form-is_r18").prop("checked", result.return_value['episode']['is_r18'] == "1" ? true : false);
			$(result.return_value['episode']['character_list']).each(function(i, e){
				$("#modal-setEpisode").find(".character-selectable[value='" + e.id + "']").removeClass("character-notselected");
			});
		}

		return true;
    });
});