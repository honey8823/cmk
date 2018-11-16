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

//エピソード更新フォームに値をセット
$(document).on("click", "li.timeline-editable", function(){
	setEpisodeModal($(this).data("id"));
});

// オーバーライド(エピソード)部分のキャラクター折り畳み
$(document).on("click", "#set_forms-override .character-folder.clickable", function(){
	$(this).parents(".character_block").find(".ul-character_profile").toggleClass("hidden");
	$(this).find(".folder-close-icon").toggleClass("hidden");
	$(this).find(".folder-open-icon").toggleClass("hidden");
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
		if (isAjaxResultErrorMsg(result.return_value) === true){return false;} // 必要ならエラーメッセージ表示

		// 正常な場合

		// 描画(drawEpisodeList関数：timeline.js内に定義)
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
		if (isAjaxResultErrorMsg(result.return_value) === true){return false;} // 必要ならエラーメッセージ表示

		// 正常な場合

		// 描画(drawEpisodeList関数：timeline.js内に定義)
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
		if (isAjaxResultErrorMsg(result.return_value) === true){return false;} // 必要ならエラーメッセージ表示

		// 正常な場合

		// 描画(drawEpisodeList関数：timeline.js内に定義)
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
		if (isAjaxResultErrorMsg(result.return_value) === true){return false;} // 必要ならエラーメッセージ表示

		// 正常な場合

		// 描画(drawEpisodeList関数：timeline.js内に定義)
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
		if (isAjaxResultErrorMsg(result.return_value) === true){return false;} // 必要ならエラーメッセージ表示

		// 正常な場合

		// 描画(drawEpisodeList関数：timeline.js内に定義)
		drawEpisodeList(params, params['id']);

		// モーダルを閉じる
		$('#modal-setEpisode').modal('hide');

		// モーダルを初期化
		initSetEpisodeModal();
	});
}
function setEpisodeOverride(){
	var params = {
			'id'         : $("#modal-setEpisode").find(".form-id").val(),
			'is_private' : $("#modal-setEpisode").find(".form-is_private:not(.hide)").data("is_private"),
			'title'      : $("#set_forms-override").find(".form-title").val(),
			'type_key'     : "override",
		};

	var result = ajaxPost("episode", "setOverride", params);
	result.done(function(){
		if (isAjaxResultErrorRedirect(result.return_value) === true) {return false;}  // 必要ならエラーページへリダイレクト
		if (isAjaxResultErrorMsg(result.return_value) === true){return false;} // 必要ならエラーメッセージ表示

		// 正常な場合

		// 描画(drawEpisodeList関数：timeline.js内に定義)
		drawEpisodeList(params, params['id']);

		// モーダルを閉じる
		$('#modal-setEpisode').modal('hide');

		// モーダルを初期化
		initSetEpisodeModal();
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
		if (isAjaxResultErrorMsg(result.return_value) === true){return false;} // 必要ならエラーメッセージ表示

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
		if (isAjaxResultErrorMsg(result.return_value) === true){return false;} // 必要ならエラーメッセージ表示

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
				if (isAjaxResultErrorMsg(result.return_value) === true){return false;} // 必要ならエラーメッセージ表示

				// 正常な場合
				return true;
			});
		}
	});
	return true;
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

	// オーバーライドの中身をクリア
	$("#set_forms-override ul.ul-character_profile li:not(.template-for-copy)").empty();
	console.log("clear");
}

/*
 * local::エピソード更新モーダルに値をセット
 */
function setEpisodeModal(id){
	var result = ajaxPost("episode", "get", {id: id});
    result.done(function(){
		if (isAjaxResultErrorRedirect(result.return_value) === true) {return false;}  // 必要ならエラーページへリダイレクト
		if (isAjaxResultErrorMsg(result.return_value) === true){return false;} // 必要ならエラーメッセージ表示
		if (isAjaxResultNoData(result.return_value['episode']['id']) === true){return false;} // データがない場合はエラー表示

		// 正常な場合

		// 一度リセットする
		initSetEpisodeModal();

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

		// 取得したデータをセット（共通）
		$("#modal-setEpisode").find(".form-id").val(result.return_value['episode']['id']);
		if (result.return_value['episode']['is_private'] == "0"){
			$("#modal-setEpisode").find(".form-is_private[data-is_private=0]").removeClass("hide");
			$("#modal-setEpisode").find(".form-is_private[data-is_private=1]").addClass("hide");
		}
		else{
			$("#modal-setEpisode").find(".form-is_private[data-is_private=1]").removeClass("hide");
			$("#modal-setEpisode").find(".form-is_private[data-is_private=0]").addClass("hide");
		}

		// 取得したデータをセット（区分によって分岐）
		if (result.return_value['episode']['type_key'] == "common"){
			$("#set_forms-common").find(".form-title").val(result.return_value['episode']['title']);
			$("#set_forms-common").find(".form-url").val(result.return_value['episode']['url']);
			$("#set_forms-common").find(".form-free_text").val(result.return_value['episode']['free_text']);
			$("#set_forms-common").find(".form-is_r18").prop("checked", result.return_value['episode']['is_r18'] == "1" ? true : false);
			$(result.return_value['episode']['character_list']).each(function(i, e){
				$("#set_forms-common").find(".character-selectable[value='" + e.id + "']").removeClass("character-notselected");
			});
		}
		else if (result.return_value['episode']['type_key'] == "label"){
			$("#set_forms-label").find(".form-title").val(result.return_value['episode']['title']);
		}
		else if (result.return_value['episode']['type_key'] == "override"){
			$("#set_forms-override").find(".form-title").val(result.return_value['episode']['title']);
			setEpisodeModalOverride(id);
		}

		return true;
    });
}
function setEpisodeModalOverride(id){

	var character = [];
	$("#set_forms-override div.character_block").each(function(i, e){
		character.push($(e).data("id"));
	});

	var params = {
			'character_list' : character,
			'episode_id'     : id,
		};
	var result = ajaxPost("character", "getProfileEpisode", params);
	result.done(function(){

		if (isAjaxResultErrorRedirect(result.return_value) === true) {return false;}  // 必要ならエラーページへリダイレクト
		if (isAjaxResultErrorMsg(result.return_value) === true){return false;} // 必要ならエラーメッセージ表示

		// 正常な場合
		$(result.return_value.character_list).each(function(i_character, e_character){
			$(e_character.profile_episode_list).each(function(i_episode, e_episode){

				// テンプレートをコピー
				var obj_base = $("#set_forms-override .character_block[data-id=" + e_character.id + "] .ul-character_profile > .li-character_profile.template-for-copy")[0];
				var obj = $(obj_base).clone().appendTo($("#set_forms-override .character_block[data-id=" + e_character.id + "] .ul-character_profile"));

				// データ書き換え

				// 項目ID
				$(obj).data("q", e_episode.question);
				$(obj).attr("data-q", e_episode.question);

				// 項目名
				$(obj).find(".view_mode .character_profile_q").text(e_episode.question_title);
				$(obj).find(".edit_mode .character_profile_q.set_mode").text(e_episode.question_title);
				$(obj).find(".edit_mode .character_profile_q.set_mode").removeClass("hidden");
				$(obj).find(".edit_mode .character_profile_q.add_mode").remove();

				// 内容・フラグ類・表示制御
				var is_override = false;
				if (e_episode.answer !== undefined && e_episode.answer != null && e_episode.answer != ""){
					// 基本プロフィールが存在する場合

					$(obj).find(".view_mode .character_profile_a.profile_base").html(strToText(e_episode.answer));

					$(obj).find(".view_mode .character_profile_a.profile_base").removeClass("hidden");
					$(obj).find(".view_mode .character_profile_a.profile_base").addClass("pre_current");
				}
				if (e_episode.answer_stage !== undefined && e_episode.answer_stage != null && e_episode.answer_stage != ""){
					// ステージプロフィールが存在する場合
					is_override = true;

					$(obj).find(".view_mode .character_profile_a.profile_stage").html(strToText(e_episode.answer_stage));

					$(obj).find(".view_mode .character_profile_a.profile_base").addClass("hidden");
					$(obj).find(".view_mode .character_profile_a.profile_stage").addClass("pre_current");
					$(obj).find(".view_mode .character_profile_a.profile_stage").addClass("current");
					$(obj).find(".view_mode .character_profile_a.profile_stage").removeClass("hidden");
				}
//				$(e_episode.answer_next_episode_list).each(function(i_next, e_next){
//					// 未来のエピソードプロフィールが存在する場合
//					if (e_next.answer != null && e_next.answer != ""){
//						// todo::未来用の枠をコピーして埋める
//
//						$(obj).find(".view_mode .character_profile_a.profile_base").addClass("hidden");
//						$(obj).find(".view_mode .character_profile_a.profile_stage").addClass("hidden");
//						// todo::未来のエピソード部分をすべて非表示　addClass("hidden");
//					}
//				});
//				$(e_episode.answer_prev_episode_list).each(function(i_prev, e_prev){
//					// 過去のエピソードプロフィールが存在する場合
//					if (e_prev.answer != null && e_prev.answer != ""){
//						// todo::過去用の枠をコピーして埋める
//
//						$(obj).find(".view_mode .character_profile_a").addClass("hidden");
//						$(obj).find(".view_mode .character_profile_stage_a").addClass("hidden");
//						// todo::過去のエピソード部分を一旦すべて非表示　addClass("hidden");
//						// todo::今回のエピソードを表示　removeClass("hidden");
//					}
//				});
				if (e_episode.answer_episode !== undefined && e_episode.answer_episode != null && e_episode.answer_episode != ""){
					// エピソードプロフィールが存在する場合
					is_override = true;

					$(obj).find(".view_mode .character_profile_a.profile_episode").html(strToText(e_episode.answer_episode));
					$(obj).find(".edit_mode .character_profile_a textarea").val(e_episode.answer_episode);

					$(obj).find(".view_mode .character_profile_a.profile_base").addClass("hidden");
					$(obj).find(".view_mode .character_profile_a.profile_stage").removeClass("current");
					$(obj).find(".view_mode .character_profile_a.profile_stage").addClass("hidden");
					$(obj).find(".view_mode .character_profile_a.profile_episode").removeClass("hidden");
				}

				if (is_override == true){
					$(obj).find(".character_profile_original_icon").addClass("hidden");
					$(obj).find(".character_profile_override_icon").removeClass("hidden");
				}
				else{
					$(obj).find(".character_profile_override_icon").addClass("hidden");
					$(obj).find(".character_profile_original_icon").removeClass("hidden");
				}

				// 表示モードに切り替え
				$(obj).find(".edit_mode").addClass("hidden");
				$(obj).find(".view_mode").removeClass("hidden");

				// 表示する
				$(obj).removeClass("template-for-copy");

				// セレクトボックスから削除
				$("#set_forms-override .character_profile_q select.character_" + e_character.id + " > option[value='" + e_episode.question + "']").remove();
			});

			// 次の入力フォームを増やす(copyCharacterProfileForm関数：character-profile.js内に定義)
			copyCharacterProfileForm("#set_forms-override .character_block[data-id=" + e_character.id + "] .ul-character_profile > .li-character_profile.template-for-copy");
		});

		return;
	});
}