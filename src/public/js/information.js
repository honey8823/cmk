/*
 * 一覧取得
 */
function tableInformation(){
	var limit = 20; // 1回あたりの件数

	var offset = $("#list-information").find("input.offset").val();
	if (offset == ""){
		// offsetが空の場合は何もしない
		$("#list-information").find(".btn-more").addClass("disabled");
		return false;
	}

	var params = {
			'limit'  : limit,
			'offset' : offset,
		};
	var result = ajaxPost("information", "table", params);
    result.done(function(){
		if (isAjaxResultErrorRedirect(result.return_value) === true) {return false;}  // 必要ならエラーページへリダイレクト
		if (isAjaxResultErrorMsg(result.return_value) === true){return false;} // 必要ならエラーメッセージ表示

		// 正常な場合
		// もっとみるボタン
		if (result.return_value['is_more'] == 1){
			$("#list-information").find(".btn-more").removeClass("disabled");
			$("#list-information").find("input.offset").val(parseInt(offset) + parseInt(limit));
		}
		else{
			$("#list-information").find(".btn-more").addClass("disabled");
			$("#list-information").find("input.offset").val("");
		}

		// テーブルに描画
		if (result.return_value['information_list'].length > 0){
			$(result.return_value['information_list']).each(function(i, e){
				drawInformationList(e);
			});
		}

		return true;
    });
}

/*
 * local::一覧描画
 */
function drawInformationList(dat){
	// 行をコピー
	var obj_base = $("#list-information").find(".information_list.template-for-copy")[0];
	var obj = $(obj_base).clone().appendTo($(obj_base).parent());

	// 日付
	$(obj).find(".information-date").text(dat.date);

	// 本文
	$(obj).find(".information-content").html(dat.content.replace(/\r?\n/g, "<br>"));

	// テンプレート用クラスを外す
	obj.removeClass("template-for-copy");
}