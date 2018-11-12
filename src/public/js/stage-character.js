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
/* オーバーライド前の情報の表示/非表示切り替え */
$(document).on("click", ".character_profile_override_icon.clickable", function(){
	$(this).parents("li").find(".character_profile_a").toggleClass("hidden");
});

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

/*
 * キャラクター割り当て
 */
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
			var obj = $(obj_base).clone(true).appendTo($(".ul-character"));
			//var obj = $(".ul-character").append($(obj_base).clone(true));

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

/*
 * オーバーライド(ステージ)モーダルへの値セット
 */
function setOverrideStageModal(id){
	// now loading 表示
	$("#modal-overrideStage .loading-complete").hide();
	$("#modal-overrideStage .loading-now").show();

	// 不要な項目の削除
	$(".ul-character_profile > .li-character_profile:not(.template-for-copy)").remove();

	var params = {
			'character_id' : id,
			'stage_id'     : $("#area-setStage .form-id").val(),
		};
	var result = ajaxPost("character", "getProfileStage", params);
	result.done(function(){

		if (isAjaxResultErrorRedirect(result.return_value) === true) {return false;}  // 必要ならエラーページへリダイレクト
		if (isAjaxResultErrorMsg(result.return_value) === true ){return false;} // 必要ならエラーメッセージ表示

		// 正常な場合

		// リンク先URL書き換え
		$("#modal-overrideStage").find("a.character_id").attr("href", $("#modal-overrideStage").find("a.character_id").attr("href") + $.param({id: result.return_value.character_id}));

		// キャラクターID書き換え
		$("#character_id").val(result.return_value.character_id);

		// キャラクター名書き換え
		$("#modal-overrideStage").find("span.character_name").text(result.return_value.character_name);

		// 登録済みのプロフィール表示
		$(result.return_value.character_profile_stage_list).each(function(i, e){
			// テンプレートをコピー
			var obj_base = $(".ul-character_profile > .li-character_profile.template-for-copy")[0];
			var obj = $(obj_base).clone().appendTo($(".ul-character_profile"));

			// データ書き換え

			// 項目ID
			$(obj).data("q", e.question);
			$(obj).attr("data-q", e.question);

			// 項目名
			$(obj).find(".view_mode .character_profile_q").text(e.question_title);
			$(obj).find(".edit_mode .character_profile_q.set_mode").text(e.question_title);
			$(obj).find(".edit_mode .character_profile_q.set_mode").removeClass("hidden");
			$(obj).find(".edit_mode .character_profile_q.add_mode").remove();

			// 内容・フラグ類
			if (e.answer !== undefined && e.answer != ""){
				// 基本プロフィールが存在する場合

				$(obj).data("q_is_original", "1");
				$(obj).attr("data-is_original", "1");

				$(obj).find(".view_mode .character_profile_a").html(strToText(e.answer));
				$(obj).find(".edit_mode .character_profile_a textarea").val(e.answer);
			}
			if (e.answer_stage !== undefined && e.answer_stage != ""){
				// ステージプロフィールが存在する場合

				$(obj).data("q_is_stage", "1");
				$(obj).attr("data-is_stage", "1");

				$(obj).find(".view_mode .character_profile_stage_a").html(strToText(e.answer_stage));
				$(obj).find(".edit_mode .character_profile_a textarea").val(e.answer_stage);

				$(obj).find(".view_mode .character_profile_a").addClass("hidden");
				$(obj).find(".view_mode .character_profile_stage_a").removeClass("hidden");

				$(obj).find(".character_profile_original_icon").addClass("hidden");
				$(obj).find(".character_profile_override_icon").removeClass("hidden");
			}
			else{
				// ステージプロフィールが存在しない場合

				$(obj).find(".view_mode .character_profile_a").removeClass("hidden");
				$(obj).find(".view_mode .character_profile_stage_a").addClass("hidden");

				$(obj).find(".character_profile_override_icon").addClass("hidden");
				$(obj).find(".character_profile_original_icon").removeClass("hidden");
			}

			// 表示モードに切り替え
			$(obj).find(".edit_mode").addClass("hidden");
			$(obj).find(".view_mode").removeClass("hidden");

			// 表示する
			$(obj).removeClass("template-for-copy");

			// セレクトボックスから削除
			$(".character_profile_q select > option[value='" + e.question + "']").remove();
		});

		// 次の入力フォームを増やす
		copyCharacterProfileForm();

		// now loading 表示解除
		$("#modal-overrideStage .loading-now").hide();
		$("#modal-overrideStage .loading-complete").show();
		return;
	});
}
