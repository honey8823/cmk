// タグ選択/選択解除
$(".label.tag-series.tag-selectable").on("click", function(){
	$(this).toggleClass("tag-notselected");
});

/*
 * 一覧取得
 */
function tableCharacterForPrivate(){

	var limit = 20; // 1回あたりの件数

	var offset = $("#list-character").find("input.offset").val();
	if (offset == ""){
		// offsetが空の場合は何もしない
		$("#list-character").find(".btn-more").addClass("disabled");
		return false;
	}

	var params = {
			'sort_column' : "id",
			'sort_order'  : "desc",
			'limit'       : limit,
			'offset'      : offset,
		};
	var result = ajaxPost("character", "tableForPrivate", params);
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
 * キャラクター登録処理
 */
function addCharacter(){

	var tag = [];
	$("#modal-addCharacter").find(".label.tag-series.tag-selectable:not(.tag-notselected)").each(function(i, e){
		tag.push($(e).attr("value"));
	});
	var params = {
			'name'       : $("#modal-addCharacter").find(".form-name").val(),
			'is_private' : $("#modal-addCharacter").find(".form-is_private").prop("checked") == true ? 1 : 0,
			'tag_list'   : tag,
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
    		alert("キャラクター登録が完了しました。");
    		$('#modal-addCharacter').modal('hide');
    		$("#modal-addCharacter").find("input").val("");
    		$("#modal-addCharacter").find(".label.tag-series.tag-selectable:not(.tag-notselected)").addClass("tag-notselected");
    		$("#modal-addCharacter").find(".form-is_private").prop("checked", true);
    		location.reload();
    		return true;
    	}
    });
}

/*
 * キャラクター更新処理
 */
function setCharacter(){
	location.reload();
}

function drawCharacterList(dat){
	// 行をコピー
	var obj_base = $("#list-character").find(".character_list.template-for-copy")[0];
	var obj = $(obj_base).clone().appendTo($(obj_base).parent());

	// キャラクター名
	$(obj).find(".character_name").text(dat.name);

	// リンク先
	var params = {id: dat.id};
	$(obj).find(".character_id").attr("href", $(obj).find(".character_id").attr("href") + $.param(params));

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
		$(obj).find(".character_is_private_0").remove();
	}
	else {
		$(obj).find(".character_is_private_1").remove();
	}

	// テンプレート用クラスを外す
	obj.removeClass("template-for-copy");
}