function login(){
	var id = $("#modal-login").find("");
}

function regist(){
	var params = {
			'login_id'   : $("#modal-regist").find(".form-login_id").val(),
			'password'   : $("#modal-regist").find(".form-password").val(),
			'password_c' : $("#modal-regist").find(".form-password_c").val(),
		};
	var result = ajaxPost("user", "add", params);
    result.done(function(){
    	 console.log(result.return_value);
    	if (result.return_value['error_message_list'] !== undefined){
    		// エラーがある場合
    		alert(result.return_value['error_message_list'].join("\nまた、"));
    		return false;
    	}
    	else {
    		alert("ok");
    		return true;
    	}
        console.log(result.return_value);
    });
}


/*
 * ajax通信
 */
function ajaxPost(c, a, params){
	var deferred = new $.Deferred();
	$.ajax({
		type   : 'POST',
		url    : "/ajax.php?c=" + c + "&a=" + a,
		data   : { params },
		async  : true,
		success: function(data)
		{
			if(data.indexOf("<html") != -1)
			{ // システムエラー
		        deferred.return_value = false;
		        deferred.resolve();
			}
			else
			{ // 成功
				deferred.return_value = (data);
		        //deferred.return_value = $.parseJSON(data);
		        deferred.resolve();
			}
		}
	});
	return deferred;
}

