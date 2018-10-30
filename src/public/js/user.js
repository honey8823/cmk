/*
 * 会員更新処理
 */
function setUser(){
	var genre = [];
	$("#area-setUser").find(".label.tag-genre.tag-selectable:not(.tag-notselected)").each(function(i, e){
		genre.push($(e).attr("value"));
	});
	var params = {
			'login_id'     : $("#area-setUser").find(".form-login_id").val(),
			'name'         : $("#area-setUser").find(".form-name").val(),
			'twitter_id'   : $("#area-setUser").find(".form-twitter_id").val(),
			'is_r18'       : $("#area-setUser").find(".form-is_r18").prop("checked") ? "1" : "0",
			'mail_address' : $("#area-setUser").find(".form-mail_address").val(),
			'password'     : $("#area-setUser").find(".form-password").val(),
			'password_c'   : $("#area-setUser").find(".form-password_c").val(),
			'genre_list'   : genre,
		};

	var result = ajaxPost("user", "set", params);
    result.done(function(){
		if (isAjaxResultErrorRedirect(result.return_value) === true) {return false;};  // 必要ならエラーページへリダイレクト
		if (isAjaxResultErrorMsg(result.return_value) === true ){return false;} // 必要ならエラーメッセージ表示

		// 正常な場合
		location.reload();
		return true;
    });
}

/*
 * 退会処理
 */
function delUser(){
    if (!confirm("本当に退会処理を行ってよろしいですか？\n登録されている全データが削除されます。")){
        return false;
    }
    if (!confirm("それでは退会処理を行います。本当によろしいですね？")){
        return false;
    }

	var result = ajaxPost("user", "del", []);
    result.done(function(){
		if (isAjaxResultErrorRedirect(result.return_value) === true) {return false;};  // 必要ならエラーページへリダイレクト
		if (isAjaxResultErrorMsg(result.return_value) === true ){return false;} // 必要ならエラーメッセージ表示

		// 正常な場合
		alert("ご利用ありがとうございました。");
		location.href = "/";
		return true;
	});
}