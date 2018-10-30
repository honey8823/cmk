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
		if (isAjaxResultErrorRedirect(result.return_value) === true) {return false;}  // 必要ならエラーページへリダイレクト
		if (isAjaxResultErrorMsg(result.return_value) === true ){return false;} // 必要ならエラーメッセージ表示

		// 正常な場合
		alert("送信しました。");
		$("#contact_content").val("");
		return true;
    });
}