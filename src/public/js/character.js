$("#modal-addCharacter").find(".label.tag-series.tag-selectable").on("click", function(){
	$(this).toggleClass("tag-notselected");
});

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
    		return true;
    	}
    });
}

/*
 * キャラクター更新処理
 */
function setCharacter(){

}