/*
 * 登録
 */
function addCharacter(){

	var stage = [];
	$("#modal-addCharacter").find(".badge.stage-selectable:not(.stage-notselected)").each(function(i, e){
		stage.push($(e).attr("value"));
	});
	var params = {
			'name'       : $("#modal-addCharacter").find(".form-name").val(),
			'stage_list' : stage,
		};
	var result = ajaxPost("character", "add", params);
    result.done(function(){
		if (isAjaxResultErrorRedirect(result.return_value) === true) {return false;}  // 必要ならエラーページへリダイレクト
		if (isAjaxResultErrorMsg(result.return_value) === true){return false;} // 必要ならエラーメッセージ表示

		// 正常な場合
		$('#modal-addCharacter').modal('hide');
		$("#modal-addCharacter").find("input").val("");
		$("#modal-addCharacter").find(".badge.stage-selectable:not(.stage-notselected)").addClass("stage-notselected");
		location.reload();

		return true;
    });
}

/*
 * 更新
 */
function setCharacter(){
	var stage = [];
	$("#area-setCharacter").find(".badge.stage-selectable:not(.stage-notselected)").each(function(i, e){
		stage.push($(e).attr("value"));
	});
	var params = {
			'id'         : $("#area-setCharacter").find(".form-id").val(),
			'name'       : $("#area-setCharacter").find(".form-name").val(),
			'remarks'    : $("#area-setCharacter").find(".form-remarks").val(),
			'stage_list' : stage,
		};
	var result = ajaxPost("character", "set", params);
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
function setCharacterIsPrivate(is_private){
	var params = {
			'id'         : $("#area-setCharacter").find(".form-id").val(),
			'is_private' : is_private,
		};
	var result = ajaxPost("character", "setIsPrivate", params);
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
function delCharacter(){
    if (!confirm("本当にこのキャラクターを削除してよろしいですか？\n（このキャラクターに属するエピソードは削除されません）")){
        return false;
    }
	var params = {
			'id' : $("#area-setCharacter").find(".form-id").val(),
		};
	var result = ajaxPost("character", "del", params);
    result.done(function(){
		if (isAjaxResultErrorRedirect(result.return_value) === true) {return false;}  // 必要ならエラーページへリダイレクト
		if (isAjaxResultErrorMsg(result.return_value) === true){return false;} // 必要ならエラーメッセージ表示

		// 正常な場合
		location.href = "/user/character/";
		return true;
    });
}

/*
 * ソートモード切替
 */
function readyCharacterSort(mode){
	if (mode == 1){
		// ONにする場合
		$(".sort_mode_off").hide();
		$(".sort_mode_on").show();
		$(".character-sort-area").addClass("sortable");
		$(".character-sort-area > li").addClass("clickable");
		sortableCharacter(mode);
	}
	else{
		// OFFにする場合
		$(".sort_mode_on").hide();
		$(".sort_mode_off").show();
		sortableCharacter(mode);
		$(".character-sort-area").removeClass("sortable");
		$(".character-sort-area > li").removeClass("clickable");
	}
	return;
}

/*
 * local::ドラッグ＆ドロップでソート可能にする
 */
function sortableCharacter(mode) {
	if (mode != 1){
		$(".character-sort-area.sortable").sortable("destroy");
		return true;
	}

	$(".character-sort-area.sortable").sortable({
		update: function(){
			var ids = [];
			$(".ul-character > li:not(.template-for-copy)").each(function(i, e){
				ids.push($(e).data("id"));
			});
			var params = {
				id_list : ids,
			};

			var result = ajaxPost("character", "setSort", params);
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
