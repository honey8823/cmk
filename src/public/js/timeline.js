// 「続きを読む」の切り替え
$(".timeline-free_text_show").on("click", function(){
	$(this).parents("li").find
	$(this).parents("li").find(".timeline-free_text").addClass("hidden");
	$(this).parents("li").find(".timeline-free_text_show").addClass("hidden");
	$(this).parents("li").find(".timeline-free_text_full").removeClass("hidden");
	$(this).parents("li").find(".timeline-free_text_hide").removeClass("hidden");
});
$(".timeline-free_text_hide").on("click", function(){
	$(this).parents("li").find(".timeline-free_text_full").addClass("hidden");
	$(this).parents("li").find(".timeline-free_text_hide").addClass("hidden");
	$(this).parents("li").find(".timeline-free_text").removeClass("hidden");
	$(this).parents("li").find(".timeline-free_text_show").removeClass("hidden");
});

/*
 * 一覧取得
 */
function timeline(params){
	if (params == undefined)
	{
		//todo:: パラメータ未定義の場合
		var params = {};
	}

	var result = ajaxPost("episode", "timeline", params);
	result.done(function(){
		if (isAjaxResultErrorRedirect(result.return_value) === true) {return false;}  // 必要ならエラーページへリダイレクト
		if (isAjaxResultErrorMsg(result.return_value) === true){return false;} // 必要ならエラーメッセージ表示

		// 正常な場合
		// テーブルに描画
		if (result.return_value['episode_list'].length > 0){
			$(result.return_value['episode_list']).each(function(i, e){
				drawEpisodeList(e);
			});
		}

		return true;
    });
}

/*
 * local::一覧描画
 */
function drawEpisodeList(dat, id){
	if (dat.type_key == "label"){
		if (id == undefined){
			// 新規：行をコピー
			var obj_base = $("#timeline_for_stage_template").find(".timeline-label")[0];
			var obj = $(obj_base).clone().appendTo($("#timeline_for_stage"));
		}
		else{
			// 更新：対象の行を取得
			var obj = $("#timeline_for_stage > li[data-id='" + id + "']");
		}

		// データ貼り付け
		$(obj).data("id", dat.id);
		$(obj).attr("data-id", dat.id);
		$(obj).find(".timeline-title").text(dat.title);
		$(obj).find(".is_private_icon.is_private_" + (dat.is_private == "1" ? "1" : "0")).removeClass("template-for-copy");
		$(obj).find(".timeline-label").removeClass("template-for-copy");
	}
	else{
		if (id == undefined){
			// 新規：行をコピー
			var obj_base = $("#timeline_for_stage_template").find(".timeline-content")[0];
			var obj = $(obj_base).clone().appendTo($("#timeline_for_stage"));
		}
		else{
			// 更新：対象の行を取得
			var obj = $("#timeline_for_stage > li[data-id='" + id + "']");
		}

		// オーバーライド時のテキスト生成
		if (dat.type_key == "override"){
			if (dat.title == undefined || dat.title == null || dat.title == ""){
				dat.free_text = "[タイトルなし]";
			}
		}

		// データ貼り付け
		$(obj).data("id", dat.id);
		$(obj).attr("data-id", dat.id);
		$(obj).find(".is_private_icon.is_private_" + (dat.is_private == "1" ? "1" : "0")).removeClass("template-for-copy");
		$(obj).find(".is_private_icon.is_private_" + (dat.is_private == "1" ? "0" : "1")).addClass("template-for-copy");
		$(obj).find(".type_icon.episode_type_" + dat.type_key).removeClass("template-for-copy");
		if (dat.title != undefined && dat.title != ""){
			$(obj).find(".timeline-title").text(dat.title);
			$(obj).find(".timeline-title").removeClass("template-for-copy");
		}
		else{
			$(obj).find(".timeline-title").text("");
			$(obj).find(".timeline-title").addClass("template-for-copy");
		}
		if (dat.url != undefined && dat.url != ""){
			$(obj).find(".timeline-url > a").attr("href", dat.url);
			$(obj).find(".timeline-url > a > span").text(dat.url_view);
			$(obj).find(".timeline-url").removeClass("template-for-copy");
		}
		else{
			$(obj).find(".timeline-url").text("");
			$(obj).find(".timeline-url").addClass("template-for-copy");
		}
		if (dat.free_text != undefined && dat.free_text != ""){
			$(obj).find(".timeline-free_text").html(strToText(dat.free_text));
			$(obj).find(".timeline-free_text").removeClass("template-for-copy");
		}
		else{
			$(obj).find(".timeline-free_text").text("");
			$(obj).find(".timeline-free_text").addClass("template-for-copy");
		}
		$(obj).find(".timeline-content").removeClass("template-for-copy");
	}

	// テンプレート用クラスを外す
	obj.removeClass("template-for-copy");
}
