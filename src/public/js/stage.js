/*
 * 一覧取得
 */
function tableStage(){
	var params = {};
	var result = ajaxPost("stage", "table", params);
    result.done(function(){
    	if (result.return_value['error_redirect'] !== undefined && result.return_value['error_redirect'] != ""){
    		// エラーページへリダイレクト
    		location.href = "/err/" + result.return_value['error_redirect'] + ".php";
    		return false;
    	}
    	else if (result.return_value['error_message_list'] !== undefined){
    		// エラーがある場合
    		alertMsg(result.return_value['error_message_list']);
    		return false;
    	}
    	else {
    		// 正常な場合
    		// テーブルに描画
    		if (result.return_value['stage_list'].length > 0){
    			$(result.return_value['stage_list']).each(function(i, e){
    				drawStageList(e);
    			});
    		}

    		return true;
    	}
    });
}

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
    	if (result.return_value['error_redirect'] !== undefined && result.return_value['error_redirect'] != ""){
    		// エラーページへリダイレクト
    		location.href = "/err/" + result.return_value['error_redirect'] + ".php";
    		return false;
    	}
    	else if (result.return_value['error_message_list'] !== undefined){
    		// エラーがある場合
    		alertMsg(result.return_value['error_message_list']);
    		return false;
    	}
    	else {
    		// 正常な場合
    		$('#modal-addStage').modal('hide');
    		$("#modal-addStage").find("input").val("");
    		$("#modal-addStage").find("textarea").text("");
    		$("#modal-addStage").find(".label.tag-series.tag-selectable:not(.tag-notselected)").addClass("tag-notselected");
    		location.reload();
    		return true;
    	}
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
    	if (result.return_value['error_redirect'] !== undefined && result.return_value['error_redirect'] != ""){
    		// エラーページへリダイレクト
    		location.href = "/err/" + result.return_value['error_redirect'] + ".php";
    		return false;
    	}
    	else if (result.return_value['error_message_list'] !== undefined){
    		// エラーがある場合
    		alertMsg(result.return_value['error_message_list']);
    		return false;
    	}
    	else {
    		// 正常な場合
    		location.reload();
    		return true;
    	}
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
    	if (result.return_value['error_redirect'] !== undefined && result.return_value['error_redirect'] != ""){
    		// エラーページへリダイレクト
    		location.href = "/err/" + result.return_value['error_redirect'] + ".php";
    		return false;
    	}
    	else if (result.return_value['error_message_list'] !== undefined){
    		// エラーがある場合
    		alertMsg(result.return_value['error_message_list']);
    		return false;
    	}
    	else {
    		// 正常な場合
    		location.reload();
    		return true;
    	}
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
    	if (result.return_value['error_redirect'] !== undefined && result.return_value['error_redirect'] != ""){
    		// エラーページへリダイレクト
    		location.href = "/err/" + result.return_value['error_redirect'] + ".php";
    		return false;
    	}
    	else if (result.return_value['error_message_list'] !== undefined){
    		// エラーがある場合
    		alertMsg(result.return_value['error_message_list']);
    		return false;
    	}
    	else {
    		// 正常な場合
    		location.href = "/user/stage/";
    		return true;
    	}
    });
}

/*
 * local::一覧描画
 */
function drawStageList(dat){
	// 行をコピー
	var obj_base = $("#list-stage").find(".stage_list.template-for-copy")[0];
	var obj = $(obj_base).clone().appendTo($(obj_base).parent());

	// キャラクター名
	$(obj).find(".stage_name").text(dat.name);

	// リンク先
	var params = {id: dat.id};
	$(obj).find(".stage_id").attr("href", $(obj).find(".stage_id").attr("href") + $.param(params));

	// タグ
	$(dat.tag_list).each(function(i_tag, e_tag){
		var obj_tag_base = $(obj).find(".td-tag > .tag-base.template-for-copy")[0];
		var obj_tag = $(obj_tag_base).clone().appendTo($(obj_tag_base).parent());

		// タグ略称
		obj_tag.addClass("tag-" + e_tag.category_key);
		obj_tag.text(e_tag.name_short);

		// テンプレート用クラスを外す
		obj_tag.removeClass("template-for-copy");
	});

	// 公開/非公開
	if (dat.is_private == 1){
		$(obj).find(".stage_is_private_0").remove();
	}
	else {
		$(obj).find(".stage_is_private_1").remove();
	}

	// テンプレート用クラスを外す
	obj.removeClass("template-for-copy");
}