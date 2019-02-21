/*
 * 一覧取得
 */
function tableNotice(){
	var limit = 20; // 1回あたりの件数

	var offset = $("#list-notice").find("input.offset").val();
	if (offset == ""){
		// offsetが空の場合は何もしない
		$("#list-notice").find(".btn-more").addClass("disabled");
		return false;
	}

	var params = {
			'limit'  : limit,
			'offset' : offset,
		};
	var result = ajaxPost("notice", "table", params);
    result.done(function(){
		if (isSystemError(result.return_value) === true) {return false;} // システムエラー（メッセージ表示して終了）
		if (isAjaxResultErrorRedirect(result.return_value) === true) {return false;}  // 必要ならエラーページへリダイレクト
		if (isAjaxResultErrorMsg(result.return_value) === true){return false;} // 必要ならエラーメッセージ表示

		// 正常な場合
		// もっとみるボタン
		if (result.return_value['is_more'] == 1){
			$("#list-notice").find(".btn-more").removeClass("disabled");
			$("#list-notice").find("input.offset").val(parseInt(offset) + parseInt(limit));
		}
		else{
			$("#list-notice").find(".btn-more").addClass("disabled");
			$("#list-notice").find("input.offset").val("");
		}

		// テーブルに描画
		if (result.return_value['notice_list'].length > 0){
			$(result.return_value['notice_list']).each(function(i, e){
				drawNoticeList(e);
			});
		}

		return true;
    });
}

/*
 * local::一覧描画
 */
function drawNoticeList(dat){
	// 行をコピー
	var obj_base = $("#list-notice").find(".notice_list.template-for-copy")[0];
	var obj = $(obj_base).clone().appendTo($(obj_base).parent());

	// 未読既読アイコン
	if (dat.read_stamp == null){
		$(obj).find(".notice-icon.unread").removeClass("hidden");
		$(obj).find(".notice-icon.read").addClass("hidden");
	}
	else{
		$(obj).find(".notice-icon.unread").addClass("hidden");
		$(obj).find(".notice-icon.read").removeClass("hidden");
	}

	// 日付
	$(obj).find(".notice-date").text(dat.date);

	// 本文
	$(obj).find(".notice-content").html(strToText(dat.content));

	// 誘導先
	if (dat.uri != ""){
		$(obj).find("a").attr("href", dat.uri);
	}
	else{
		$(obj).find("a").removeAttr("href");
	}

	// テンプレート用クラスを外す
	obj.removeClass("template-for-copy");
}