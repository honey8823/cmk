/*
 * 登録
 */
function addContact(){
	var content = $("#contact_content").val();
	if (content == ""){
		return false;
	}

	var params = {
			'content' : content,
		};
	var result = ajaxPost("contact", "add", params);
    result.done(function(){
    	if (result.return_value['error_redirect'] !== undefined && result.return_value['error_redirect'] != ""){
    		// エラーページへリダイレクト
    		location.href = "/err/" + result.return_value['error_redirect'] + ".php";
    		return false;
    	}
    	else if (result.return_value['error_message_list'] !== undefined){
    		// エラーがある場合
    		return false
    	}
    	else {
    		// 正常な場合
    		alert("送信しました。");
    		$("#contact_content").val("");
    		return true;
    	}
    });
}