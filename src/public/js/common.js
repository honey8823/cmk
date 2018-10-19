// タグ選択/選択解除
$(".label.tag-selectable").on("click", function(){
	$(this).toggleClass("tag-notselected");
});

// ステージ選択/選択解除
$(".badge.stage-selectable").on("click", function(){
	$(this).toggleClass("stage-notselected");
});

// キャラクター選択/選択解除
$(".badge.character-selectable").on("click", function(){
	$(this).toggleClass("character-notselected");
});

/*
 * メッセージのアラート
 */
function alertMsg(msg_list){
	alert(msg_list.join("\nまた、"));
}

/*
 * ajax通信
 */
function ajaxPost(c, a, params){
console.log("【ajaxPost:param(" + c + "/" + a + ")】", params);
	var deferred = new $.Deferred();
	$.ajax({
		type   : 'POST',
		url    : "/ajax.php?c=" + c + "&a=" + a,
		data   : { params },
		async  : true,
		success: function(data)
		{
console.log("【ajaxPost:result(" + c + "/" + a + ")】", data);
			if(data.indexOf("<html") != -1)
			{ // システムエラー
		        deferred.return_value = false;
		        deferred.resolve();
			}
			else
			{ // 成功
		        deferred.return_value = $.parseJSON(data);
		        deferred.resolve();
			}
		}
	});
	return deferred;
}

/*
 * ajaxのエラー処理
 * error_redirect が定義されている場合はそのエラーページにリダイレクト
 */
function isAjaxResultErrorRedirect(res){

	if (res['error_redirect'] !== undefined && res['error_redirect'] != ""){
		location.href = "/err/" + res['error_redirect'] + ".php";
		return true;
	}
	return false;
}

/*
 * ajaxのエラー処理
 * error_message_list が定義されている場合はメッセージのアラート
 */
function isAjaxResultErrorMsg(res){
	if (res['error_message_list'] !== undefined && res['error_message_list'].length > 0){
		alertMsg(res['error_message_list']);
		return true;
	}
	return false;
}

/*
 * ajaxのエラー処理
 * 指定されたデータが存在しない(未定義または空)場合はエラー
 */
function isAjaxResultNoData(val){
	if (val === undefined || val == ""){
		alertMsg(["データの取得に失敗しました。お手数ですが最初からやり直してください。"]);
		return true;
	}
	return false;
}

/*
 * 文字列を切り出す
 */
function strcut(str, start, end){
    var sidx = 0;
    var eidx = str.length;
    if (start != ""){
        sidx = str.indexOf(start) + start.length;
    }
    if (end != ""){
        eidx = str.indexOf(end);
    }
    if (sidx > eidx){
        return "";
    }
    return str.substring(sidx, eidx);
}

