/* キャラクターページへの移動 */
$(document).on("click", ".character_list .btn-character_edit", function(){
	var id = $(this).parents("li").data("id");
	location.href = "/user/character/edit.php?id=" + id;
});
/* オーバーライド(ステージ)モーダルへの値セット発火 */
$(document).on("click", ".character_list .btn-override", function(){
	var id = $(this).parents("li").data("id");
	setOverrideStageModal(id);
});
/* 公開用キャラクターページへの移動 */
$(document).on("click", ".character_list .btn-character_override", function(){
	var id = $(this).parents("li").data("id");
	var s = $("#stage_id").val();
	var user = $("#login_id").val();
	location.href = "/public/character/override.php?user=" + user + "&id=" + id + "&s=" + s;
});

/**********************/
/* ステージ本体の操作 */
/**********************/

/*
 * 登録
 */
function addStage(){
	var tag = [];
	$("#modal-addStage").find(".tag.selectable:not(.notselected)").each(function(i, e){
		tag.push($(e).attr("value"));
	});
	var params = {
			'name'       : $("#modal-addStage").find(".form-name").val(),
			'remarks'    : $("#modal-addStage").find(".form-remarks").val(),
			'tag_list'   : tag,
		};
	var result = ajaxPost("stage", "add", params);
    result.done(function(){
		if (isAjaxResultErrorRedirect(result.return_value) === true) {return false;}  // 必要ならエラーページへリダイレクト
		if (isAjaxResultErrorMsg(result.return_value) === true){return false;} // 必要ならエラーメッセージ表示

		// 正常な場合
		$('#modal-addStage').modal('hide');
		$("#modal-addStage").find("input").val("");
		$("#modal-addStage").find("textarea").text("");
		$("#modal-addStage").find(".tag.selectable:not(.notselected)").addClass("notselected");
		location.reload();
		return true;
    });
}

/*
 * 更新
 */
function setStage(){
	var tag = [];
	$("#area-setStage").find(".tag.selectable:not(.notselected)").each(function(i, e){
		tag.push($(e).attr("value"));
	});
	var params = {
			'id'         : $("#area-setStage").find(".form-id").val(),
			'name'       : $("#area-setStage").find(".form-name").val(),
			'remarks'    : $("#area-setStage").find(".form-remarks").val(),
			'tag_list'   : tag,
		};
	var result = ajaxPost("stage", "set", params);
    result.done(function(){
		if (isAjaxResultErrorRedirect(result.return_value) === true) {return false;}  // 必要ならエラーページへリダイレクト
		if (isAjaxResultErrorMsg(result.return_value) === true){return false;} // 必要ならエラーメッセージ表示

		// 正常な場合
		location.reload();
		return true;
	});
}

/*
 * 更新（公開/非公開）
 */
function setStageIsPrivate(is_private){
	var params = {
			'id'         : $("#area-setStage").find(".form-id").val(),
			'is_private' : is_private,
		};
	var result = ajaxPost("stage", "setIsPrivate", params);
    result.done(function(){
		if (isAjaxResultErrorRedirect(result.return_value) === true) {return false;}  // 必要ならエラーページへリダイレクト
		if (isAjaxResultErrorMsg(result.return_value) === true){return false;} // 必要ならエラーメッセージ表示

		// 正常な場合
		location.reload();
		return true;
	});
}

/*
 * 削除
 */
function delStage(){
    if (!confirm("本当にこのステージを削除してよろしいですか？\nこのステージに登録されているエピソードも削除されます。\n（このステージに属するキャラクターは削除されません）")){
        return false;
    }
	var params = {
			'id' : $("#area-setStage").find(".form-id").val(),
		};
	var result = ajaxPost("stage", "del", params);
    result.done(function(){
		if (isAjaxResultErrorRedirect(result.return_value) === true) {return false;}  // 必要ならエラーページへリダイレクト
		if (isAjaxResultErrorMsg(result.return_value) === true){return false;} // 必要ならエラーメッセージ表示

		// 正常な場合
		location.href = "/user/stage/";
		return true;
	});
}

/*
 * ソートモード切替
 */
function readyStageSort(mode){
	if (mode == 1){
		// ONにする場合
		$(".sort_mode_off").hide();
		$(".sort_mode_on").show();
		$(".stage-sort-area").addClass("sortable");
		$(".stage-sort-area > li").addClass("clickable");
		sortableStage(mode);
	}
	else{
		// OFFにする場合
		$(".sort_mode_on").hide();
		$(".sort_mode_off").show();
		sortableStage(mode);
		$(".stage-sort-area").removeClass("sortable");
		$(".stage-sort-area > li").removeClass("clickable");
	}
	return;
}

/*
 * local::ドラッグ＆ドロップでソート可能にする
 */
function sortableStage(mode) {
	if (mode != 1){
		$(".stage-sort-area.sortable").sortable("destroy");
		return true;
	}

	$(".stage-sort-area.sortable").sortable({
		update: function(){
			var ids = [];
			$(".ul-stage > li:not(.template-for-copy)").each(function(i, e){
				ids.push($(e).data("id"));
			});
			var params = {
				id_list : ids,
			};

			var result = ajaxPost("stage", "setSort", params);
			result.done(function(){
				if (isAjaxResultErrorRedirect(result.return_value) === true) {return false;}  // 必要ならエラーページへリダイレクト
				if (isAjaxResultErrorMsg(result.return_value) === true){return false;} // 必要ならエラーメッセージ表示

				// 正常な場合
				// 何もしない
				return true;
			});
		}
	});
	return true;
}

/********************************/
/* ステージ内キャラクターの操作 */
/********************************/

/*
 * ソートモード切替（ステージ内キャラクター）
 */
function readyStageCharacterSort(mode){
	if (mode == 1){
		// ONにする場合
		$(".sort_mode_off").hide();
		$(".sort_mode_on").show();
		$(".stage-character-sort-area").addClass("sortable");
		$(".stage-character-sort-area > li").addClass("clickable");
		sortableStageCharacter(mode);
	}
	else{
		// OFFにする場合
		$(".sort_mode_on").hide();
		$(".sort_mode_off").show();
		sortableStageCharacter(mode);
		$(".stage-character-sort-area").removeClass("sortable");
		$(".stage-character-sort-area > li").removeClass("clickable");
	}
	return;
}

/*
 * local::ドラッグ＆ドロップでソート可能にする（ステージ内キャラクター）
 */
function sortableStageCharacter(mode) {
	if (mode != 1){
		$(".stage-character-sort-area.sortable").sortable("destroy");
		return true;
	}

	$(".stage-character-sort-area.sortable").sortable({
		update: function(){
			var ids = [];
			$(".ul-character > li:not(.template-for-copy)").each(function(i, e){
				ids.push($(e).data("id"));
			});
			var params = {
				stage_id : $("#area-setStage").find(".form-id").val(),
				id_list  : ids,
			};

			var result = ajaxPost("stage", "setCharacterSort", params);
			result.done(function(){
				if (isAjaxResultErrorRedirect(result.return_value) === true) {return false;}  // 必要ならエラーページへリダイレクト
				if (isAjaxResultErrorMsg(result.return_value) === true){return false;} // 必要ならエラーメッセージ表示

				// 正常な場合
				// 何もしない
				return true;
			});
		}
	});
	return true;
}

/*
 * キャラクター割り当て
 */
function upsertStageCharacter(){
	var character = [];
	$("#modal-upsertStageCharacter").find(".character.selectable:not(.notselected)").each(function(i, e){
		character.push($(e).attr("value"));
	});
	var params = {
			'stage_id'       : $("#modal-addEpisode").find(".form-stage_id").val(),
			'character_list' : character,
		};
	var result = ajaxPost("stage", "upsertCharacter", params);
	result.done(function(){
		if (isAjaxResultErrorRedirect(result.return_value) === true) {return false;}  // 必要ならエラーページへリダイレクト
		if (isAjaxResultErrorMsg(result.return_value) === true){return false;} // 必要ならエラーメッセージ表示

		// 正常な場合

		// 削除
		$(result.return_value.del_character_list).each(function(i, e){
			$(".ul-character > .character_list[data-id=" + e + "]").remove();
		});

		// 追加
		$(result.return_value.add_character_list).each(function(i, e){
			var obj_base = $(".ul-character > .character_list.template-for-copy")[0];
			var obj = $(obj_base).clone(true).appendTo($(".ul-character"));

			$(obj).data("id", e);
			$(obj).attr("data-id", e);
			$(obj).find(".is_private_" + result.return_value.character_list[e].is_private).removeClass("hidden");
			$(obj).find("a.character_id").attr("href", $(obj).find("a.character_id").attr("href") + $.param({id: e}));
			$(obj).find(".character_name").text(result.return_value.character_list[e].name);
			if (result.return_value.character_list[e].image != null && result.return_value.character_list[e].image != ""){
				$(obj).find(".character_image").attr("src", "data:image/png;base64," + result.return_value.character_list[e].image);
			}
			if (result.return_value.character_list[e].is_private == 1){
				$(obj).find(".btn-character_override").addClass("hidden");
			}
			$(obj).removeClass("template-for-copy");
		});

		$('#modal-upsertStageCharacter').modal('hide');
		return;
	});
}

/*
 * オーバーライド(ステージ)モーダルへの値セット
 */
function setOverrideStageModal(id){
	// now loading 表示
	$("#modal-overrideStage .loading-complete").hide();
	$("#modal-overrideStage .loading-now").show();

	// 不要な項目の削除
	$("#modal-overrideStage .li-character_profile:not(.template-for-copy)").remove();

	var params = {
			'character_id' : id,
			'stage_id'     : $("#area-setStage .form-id").val(),
		};
	var result = ajaxPost("character", "getProfileStage", params);
	result.done(function(){

		if (isAjaxResultErrorRedirect(result.return_value) === true) {return false;}  // 必要ならエラーページへリダイレクト
		if (isAjaxResultErrorMsg(result.return_value) === true){return false;} // 必要ならエラーメッセージ表示

		// 正常な場合

		// キャラクターID書き換え
		$("#character_id").val(result.return_value.character_id);

		// キャラクター名書き換え
		$("#modal-overrideStage").find("span.character_name").text(result.return_value.character_name);

		// 登録済みのプロフィール表示
		$(result.return_value.character_profile_stage_list).each(function(i, e){
			drawCharacterProfile($($("#modal-overrideStage .li-character_profile.template-for-copy")[0]), "new", "stage", e);
		});

		// 次の入力フォームを増やす
		copyCharacterProfileForm("#modal-overrideStage .li-character_profile.template-for-copy");

		// now loading 表示解除
		$("#modal-overrideStage .loading-now").hide();
		$("#modal-overrideStage .loading-complete").show();
		return;
	});
}