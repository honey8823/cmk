// タグ選択/選択解除
$(".label.tag-selectable").on("click", function(){
	$(this).toggleClass("tag-notselected");
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
	var deferred = new $.Deferred();
	$.ajax({
		type   : 'POST',
		url    : "/ajax.php?c=" + c + "&a=" + a,
		data   : { params },
		async  : true,
		success: function(data)
		{
console.log("【ajaxPost】", data);
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

