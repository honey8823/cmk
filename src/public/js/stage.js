/*
 * 登録
 */
function addStage(){
	var tag = [];
	$("#modal-addStage").find(".label.tag-selectable:not(.tag-notselected)").each(function(i, e){
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
		if (isAjaxResultErrorMsg(result.return_value) === true ){return false;} // 必要ならエラーメッセージ表示

		// 正常な場合
		$('#modal-addStage').modal('hide');
		$("#modal-addStage").find("input").val("");
		$("#modal-addStage").find("textarea").text("");
		$("#modal-addStage").find(".label.tag-series.tag-selectable:not(.tag-notselected)").addClass("tag-notselected");
		location.reload();
		return true;
    });
}

/*
 * 更新
 */
function setStage(){
	var tag = [];
	$("#area-setStage").find(".label.tag-selectable:not(.tag-notselected)").each(function(i, e){
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
		if (isAjaxResultErrorMsg(result.return_value) === true ){return false;} // 必要ならエラーメッセージ表示

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
		if (isAjaxResultErrorMsg(result.return_value) === true ){return false;} // 必要ならエラーメッセージ表示

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
		if (isAjaxResultErrorMsg(result.return_value) === true ){return false;} // 必要ならエラーメッセージ表示

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
				if (isAjaxResultErrorMsg(result.return_value) === true ){return false;} // 必要ならエラーメッセージ表示

				// 正常な場合
				// 何もしない
				return true;
			});
		}
	});
	return true;
}
