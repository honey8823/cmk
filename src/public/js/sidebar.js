/*
 * サイドバーの折り畳みをセッションに保存
 */
$(document).on("click", ".sidebar-toggle", function(){
	ajaxPost("user", "setSessionUserIsSidebarClose");
});

/*
 * ログインフォーム内のEnter押下でログインボタンクリックしたことにする
 */
$(document).on("keyup", "#modal-login input", function(e){
	if (e.keyCode == 13){
		$("#modal-login .btn-login").trigger("click");
	}
});

/*
 * ログイン処理
 */
function login(){
	var params = {
			'login_id' : $("#modal-login").find(".form-login_id").val(),
			'password' : $("#modal-login").find(".form-password").val(),
			'cookie'   : $("#modal-login").find(".form-cookie").prop("checked") == true ? "1" : "0",
		};
	var result = ajaxPost("user", "login", params);
    result.done(function(){
		if (isAjaxResultErrorMsg(result.return_value) === true){return false;} // 必要ならエラーメッセージ表示

		// 正常な場合
		$('#modal-login').modal('hide');
		$("#modal-login").find("input").val("");
		if (location.pathname.match(/^\/err\//)){
			// エラーページにいた場合のみトップへリダイレクト
			location.href = "/";
		}
		else{
			// エラーページではないところにいた場合はリロード
			location.reload();
		}

		return true;
    });
}

/*
 * ログアウト処理
 */
function logout(){
	if (confirm("ログアウトしてトップページへ戻ります。よろしいですか？")){
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
		if (isAjaxResultErrorMsg(result.return_value) === true){return false;} // 必要ならエラーメッセージ表示

		// 正常な場合
		alert("会員登録が完了しました。入力いただいた情報でログインしてください。");
		$('#modal-addUser').modal('hide');
		$("#modal-addUser").find("input").val("");
		return true;
    });
}

/*
 * リクエストボックス
 */
function addContactRequest(){
	var category = $("#modal-request .form-category").val();
	var content  = $("#modal-request .form-free_text").val();

	if (content == ""){
		return false;
	}

	var params = {
			'content' : "【" + category + "】\n" + content,
		};
	var result = ajaxPost("contact", "add", params);
    result.done(function(){
		if (isAjaxResultErrorRedirect(result.return_value) === true) {return false;}  // 必要ならエラーページへリダイレクト
		if (isAjaxResultErrorMsg(result.return_value) === true){return false;} // 必要ならエラーメッセージ表示

		// 正常な場合
		$('#modal-request').modal("hide");
		$("#modal-request .form-free_text").val("");
		return true;
    });
}
/*
 * リクエストボックスにデフォルトカテゴリ設定
 */
function setRequestCategory(c){
	$("#modal-request .form-category").val(c);
}