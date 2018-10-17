// ドラッグ＆ドロップでソート可能にする
$(function() {
    $(".ul-character.sortable").sortable({
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
					// 何もしない
					return true;
				}
			});
		}
    });
});

/*
 * 一覧取得
 */
function tableCharacter(){

	var limit = 50; // 1回あたりの件数

	var offset = $("#list-character").find("input.offset").val();
	if (offset == ""){
		// offsetが空の場合は何もしない
		$("#list-character").find(".btn-more").addClass("disabled");
		return false;
	}

	var params = {
			'sort_column' : "",
			'sort_order'  : "",
			'limit'       : limit,
			'offset'      : offset,
		};
	var result = ajaxPost("character", "table", params);
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

    		// もっとみるボタン
    		if (result.return_value['is_more'] == 1){
    			$("#list-character").find(".btn-more").removeClass("disabled");
    			$("#list-character").find("input.offset").val(parseInt(offset) + parseInt(limit));
    		}
    		else{
    			$("#list-character").find(".btn-more").addClass("disabled");
    			$("#list-character").find("input.offset").val("");
    		}

    		// テーブルに描画
    		if (result.return_value['character_list'].length > 0){
    			$(result.return_value['character_list']).each(function(i, e){
    				drawCharacterList(e);
    			});
    		}

    		return true;
    	}
    });
}

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
    		$('#modal-addCharacter').modal('hide');
    		$("#modal-addCharacter").find("input").val("");
    		$("#modal-addCharacter").find(".badge.stage-selectable:not(.stage-notselected)").addClass("stage-notselected");
    		location.reload();
    		return true;
    	}
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
			'stage_list' : stage,
		};
	var result = ajaxPost("character", "set", params);
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
function setCharacterIsPrivate(is_private){
	var params = {
			'id'         : $("#area-setCharacter").find(".form-id").val(),
			'is_private' : is_private,
		};
	var result = ajaxPost("character", "setIsPrivate", params);
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
function delCharacter(){
    if (!confirm("本当にこのキャラクターを削除してよろしいですか？\n（このキャラクターに属するエピソードは削除されません）")){
        return false;
    }
	var params = {
			'id' : $("#area-setCharacter").find(".form-id").val(),
		};
	var result = ajaxPost("character", "del", params);
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
    		location.href = "/user/character/";
    		return true;
    	}
    });
}

/*
 * local::一覧描画
 */
function drawCharacterList(dat){
	// 行をコピー
	var obj_base = $("#list-character").find(".character_list.template-for-copy")[0];
	var obj = $(obj_base).clone().appendTo($(obj_base).parent());

	// キャラクターID
	$(obj).data("id", dat.id);

	// キャラクター名
	$(obj).find(".character_name").text(dat.name);

	// リンク先
	var params = {id: dat.id};
	$(obj).find(".character_id").attr("href", $(obj).find(".character_id").attr("href") + $.param(params));

	// ステージ
	$(dat.stage_list).each(function(i, e){
		var obj_stage_base = $(obj).find(".stage > .stage.template-for-copy")[0];
		var obj_stage = $(obj_stage_base).clone().appendTo($(obj_stage_base).parent());

		// ステージ名
		obj_stage.text(e.name);

		// テンプレート用クラスを外す
		obj_stage.removeClass("template-for-copy");
	});

	// 公開/非公開
	if (dat.is_private == 1){
		$(obj).find(".character_is_private_0").remove();
	}
	else {
		$(obj).find(".character_is_private_1").remove();
	}

	// テンプレート用クラスを外す
	obj.removeClass("template-for-copy");
}