/*
 * 会員更新処理
 */
function setUserProfile(){
	var genre = [];
	$("#area-setUserProfile").find(".label.tag-genre.tag-selectable:not(.tag-notselected)").each(function(i, e){
		genre.push($(e).attr("value"));
	});
	var params = {
			'name'         : $("#area-setUserProfile").find(".form-name").val(),
			'twitter_id'   : $("#area-setUserProfile").find(".form-twitter_id").val(),
			'pixiv_id'     : $("#area-setUserProfile").find(".form-pixiv_id").val(),
			'remarks'      : $("#area-setUserProfile").find(".form-remarks").val(),
			'genre_list'   : genre,
		};

	var result = ajaxPost("user", "setProfile", params);
    result.done(function(){
		if (isAjaxResultErrorRedirect(result.return_value) === true) {return false;};  // 必要ならエラーページへリダイレクト
		if (isAjaxResultErrorMsg(result.return_value) === true ){return false;} // 必要ならエラーメッセージ表示

		// 正常な場合
		location.reload();
		return true;
    });
}
function setUserAccount(){
	var params = {
			'login_id'     : $("#area-setUserAccount").find(".form-login_id").val(),
			'is_r18'       : $("#area-setUserAccount").find(".form-is_r18").prop("checked") ? "1" : "0",
			'mail_address' : $("#area-setUserAccount").find(".form-mail_address").val(),
		};

	var result = ajaxPost("user", "setAccount", params);
    result.done(function(){
		if (isAjaxResultErrorRedirect(result.return_value) === true) {return false;};  // 必要ならエラーページへリダイレクト
		if (isAjaxResultErrorMsg(result.return_value) === true ){return false;} // 必要ならエラーメッセージ表示

		// 正常な場合
		location.reload();
		return true;
    });
}
function setUserPassword(){
	var params = {
			'password_o'   : $("#area-setUserPassword").find(".form-password_o").val(),
			'password'     : $("#area-setUserPassword").find(".form-password").val(),
			'password_c'   : $("#area-setUserPassword").find(".form-password_c").val(),
		};

	var result = ajaxPost("user", "setPassword", params);
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