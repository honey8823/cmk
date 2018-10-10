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
    	if (result.return_value['error_redirect'] !== undefined && result.return_value['error_redirect'] != ""){
    		// エラーページへリダイレクト
    		location.href = "/err/" + result.return_value['error_redirect'] + ".php";
    		return false;
    	}
    	else if (result.return_value['user']['id'] == undefined){
    		// エラーがある場合
    		alertMsg(["会員情報の取得に失敗しました。再度ログインしてください。"]);
    		logout();
    		return false;
    	}
    	else {
    		// 正常な場合
    		$("#modal-setUser").find(".form-login_id").val(result.return_value['user']['login_id']);
    		$("#modal-setUser").find(".form-name").val(result.return_value['user']['name']);
    		$("#modal-setUser").find(".form-twitter_id").val(result.return_value['user']['twitter_id']);
    		$("#modal-setUser").find(".form-mail_address").val(result.return_value['user']['mail_address']);
    		$("#modal-setUser").find(".form-password").val("");
    		$("#modal-setUser").find(".form-password_c").val("");
    		return true;
    	}
    });
}

/*
 * 会員情報をHTMLにセット
 */
function setUserData(){
	var result = ajaxPost("user", "getSession", ["user"]);
    result.done(function(){
    	if (result.return_value['error_redirect'] !== undefined && result.return_value['error_redirect'] != ""){
    		// エラーページへリダイレクト
    		location.href = "/err/" + result.return_value['error_redirect'] + ".php";
    		return false;
    	}
    	else if (result.return_value['user']['id'] == undefined){
    		// 情報が取得できない場合
    		alertMsg(["会員情報の取得に失敗しました。再度ログインしてください。"]);
    		logout();
    		return false;
    	}
    	else {
    		// 正常な場合
    		$(".textdata-user-name").text(result.return_value['user']['name']);
    		return true;
    	}
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
    	if (result.return_value['error_message_list'] !== undefined){
    		// エラーがある場合
    		alertMsg(result.return_value['error_message_list']);
    		return false;
    	}
    	else {
    		// 正常な場合
    		$('#modal-login').modal('hide');
    		$("#modal-login").find("input").val("");
    		switchSidebar();
    		return true;
    	}
    });
}

/*
 * ログアウト処理
 */
function logout(){
	var result = ajaxPost("user", "logout", []);
    result.done(function(){
    	switchSidebar();
    });
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
    	if (result.return_value['error_message_list'] !== undefined){
    		// エラーがある場合
    		alertMsg(result.return_value['error_message_list']);
    		return false;
    	}
    	else {
    		// 正常な場合
    		alert("会員登録が完了しました。入力いただいた情報でログインしてください。");
    		$('#modal-addUser').modal('hide');
    		$("#modal-addUser").find("input").val("");
    		return true;
    	}
    });
}

/*
 * 会員更新処理
 */
function setUser(){
	var params = {
			'login_id'     : $("#modal-setUser").find(".form-login_id").val(),
			'name'         : $("#modal-setUser").find(".form-name").val(),
			'twitter_id'   : $("#modal-setUser").find(".form-twitter_id").val(),
			'mail_address' : $("#modal-setUser").find(".form-mail_address").val(),
			'password'     : $("#modal-setUser").find(".form-password").val(),
			'password_c'   : $("#modal-setUser").find(".form-password_c").val(),
		};

	var result = ajaxPost("user", "set", params);
    result.done(function(){
    	if (result.return_value['error_redirect'] !== undefined && result.return_value['error_redirect'] != ""){
    		// エラーページへリダイレクト
    		location.href = "/err/" + result.return_value['error_redirect'] + ".php";
    		return false;
    	}
    	if (result.return_value['error_message_list'] !== undefined){
    		// エラーがある場合
    		alertMsg(result.return_value['error_message_list']);
    		return false;
    	}
    	else {
    		// 正常な場合
    		setUserData();
    		$('#modal-setUser').modal('hide');
    		return true;
    	}
    });
}