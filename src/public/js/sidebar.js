// 読み込み完了時の処理
$(function(){
	// サイドバーをログイン状態によって切り替え
	switchSidebar();
});

/*
 * サイドバーをログイン状態によって切り替え
 */
function switchSidebar(){
	var result = ajaxPost("user", "isLogin", []);
    result.done(function(){
    	if (result.return_value == true) {
    		// ログイン済み
    		setUserData();
    		$(".logged-out").hide();
    		$(".logged-in").show();
    	}
    	else {
    		// 未ログイン
    		$(".logged-in").hide();
    		$(".logged-out").show();
    	}
    });
}

/*
 * 会員更新フォームに値をセット
 */
function setUserForm(){
	var result = ajaxPost("user", "getSession", ["user"]);
    result.done(function(){
		if (isAjaxResultErrorRedirect(result.return_value) === true) {return false;}  // 必要ならエラーページへリダイレクト
		if (isAjaxResultNoData(result.return_value['user']['id']) === true ){logout();return false;} // 必要ならエラーメッセージ表示

		var result2 = ajaxPost("tag", "tableGenre", []);
		result2.done(function(){
			// 正常な場合
			$("#modal-setUser").find(".tag-genre:not(.template-for-copy)").remove();
			$(result2.return_value['genre_list']).each(function(i, e){
				var obj_base = $("#modal-setUser").find(".tag-genre.template-for-copy")[0];
				var obj = $(obj_base).clone().appendTo($(obj_base).parent());

				// データ貼り付け
				$(obj).val(e.id);
				$(obj).text(e.title);
				$(obj).removeClass("template-for-copy");
				if ($.inArray(e.id, result.return_value['user']['genre_list']) != -1){
					$(obj).removeClass("tag-notselected");
				}
			});
	    });

		// 正常な場合
		$("#modal-setUser").find(".form-login_id").val(result.return_value['user']['login_id']);
		$("#modal-setUser").find(".form-name").val(result.return_value['user']['name']);
		$("#modal-setUser").find(".form-twitter_id").val(result.return_value['user']['twitter_id']);
		$("#modal-setUser").find(".form-is_r18").prop("checked", result.return_value['user']['is_r18'] == 1 ? true : false);
		$("#modal-setUser").find(".form-mail_address").val(result.return_value['user']['mail_address']);
		$("#modal-setUser").find(".form-password").val("");
		$("#modal-setUser").find(".form-password_c").val("");
		return true;
	});
}

/*
 * 会員情報をHTMLにセット
 */
function setUserData(){
	var result = ajaxPost("user", "getSession", ["user"]);
    result.done(function(){
		if (isAjaxResultErrorRedirect(result.return_value) === true) {return false;}  // 必要ならエラーページへリダイレクト
		if (isAjaxResultErrorMsg(result.return_value) === true ){return false;} // 必要ならエラーメッセージ表示
		if (isAjaxResultNoData(result.return_value['user']['id']) === true ){logout();return false;} // データがない場合はエラー表示

    	// 正常な場合
    	$(".textdata-user-name").text(result.return_value['user']['name']);
    	return true;
    });
}

/*
 * ログイン処理
 */
function login(){
	var params = {
			'login_id' : $("#modal-login").find(".form-login_id").val(),
			'password' : $("#modal-login").find(".form-password").val(),
		};
	var result = ajaxPost("user", "login", params);
    result.done(function(){
		if (isAjaxResultErrorMsg(result.return_value) === true ){return false;} // 必要ならエラーメッセージ表示

		// 正常な場合
		$('#modal-login').modal('hide');
		$("#modal-login").find("input").val("");
		location.href = "/";
		return true;
    });
}

/*
 * ログアウト処理
 */
function logout(){
	if (confirm("ログアウトしてよろしいですか？")){
		var result = ajaxPost("user", "logout", []);
		result.done(function(){
			location.href = "/";
			return true;
	    });
	}
}

/*
 * 会員登録処理
 */
function addUser(){
	var params = {
			'login_id'   : $("#modal-addUser").find(".form-login_id").val(),
			'password'   : $("#modal-addUser").find(".form-password").val(),
			'password_c' : $("#modal-addUser").find(".form-password_c").val(),
		};
	var result = ajaxPost("user", "add", params);
    result.done(function(){
		if (isAjaxResultErrorMsg(result.return_value) === true ){return false;} // 必要ならエラーメッセージ表示

		// 正常な場合
		alert("会員登録が完了しました。入力いただいた情報でログインしてください。");
		$('#modal-addUser').modal('hide');
		$("#modal-addUser").find("input").val("");
		return true;
    });
}
