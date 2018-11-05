/*
 * ソートモード切替
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
 * local::ドラッグ＆ドロップでソート可能にする
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
				if (isAjaxResultErrorMsg(result.return_value) === true ){return false;} // 必要ならエラーメッセージ表示

				// 正常な場合
				// 何もしない
				return true;
			});
		}
	});
	return true;
}

function upsertStageCharacter(){
	var character = [];
	$("#modal-upsertStageCharacter").find(".badge.character-selectable:not(.character-notselected)").each(function(i, e){
		character.push($(e).attr("value"));
	});
	var params = {
			'stage_id'       : $("#modal-addEpisode").find(".form-stage_id").val(),
			'character_list' : character,
		};
	var result = ajaxPost("stage", "upsertCharacter", params);
	result.done(function(){
		if (isAjaxResultErrorRedirect(result.return_value) === true) {return false;}  // 必要ならエラーページへリダイレクト
		if (isAjaxResultErrorMsg(result.return_value) === true ){return false;} // 必要ならエラーメッセージ表示

		// 正常な場合

		// 削除
		$(result.return_value.del_character_list).each(function(i, e){
			$(".ul-character > .character_list[data-id=" + e + "]").remove();
		});

		// 追加
		$(result.return_value.add_character_list).each(function(i, e){
			var obj_base = $(".ul-character > .character_list.template-for-copy")[0];
			var obj = $(obj_base).clone().appendTo($(".ul-character"));

			$(obj).data("id", e);
			$(obj).attr("data-id", e);
			$(obj).find(".is_private_" + result.return_value.character_list[e].is_private).removeClass("hide");
			$(obj).find("a.character_id").attr("href", $(obj).find("a.character_id").attr("href") + $.param({id: e}));
			$(obj).find(".character_name").text(result.return_value.character_list[e].name);

			$(obj).removeClass("template-for-copy");
		});

		$('#modal-upsertStageCharacter').modal('hide');
		return;
	});
}