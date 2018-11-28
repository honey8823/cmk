/**********************/
/* 編集エリアの操作類 */
/**********************/

// 編集ボタン（編集フォームに切り替える）
$(document).on("click", ".character_profile_edit_icon.clickable", function(){
	$(this).parents(".li-character_profile").find(".view_mode").addClass("hidden");
	$(this).parents(".li-character_profile").find(".edit_mode").removeClass("hidden");
});

// 削除ボタン（削除関数をコール）
$(document).on("click", ".character_profile_delete_icon.clickable", function(){
	var obj = $(this).parents("ul");
	var q = $(this).parents(".li-character_profile").data("q");

	if (obj.hasClass("character_profile")){delCharacterProfile(q);}
	else if (obj.hasClass("character_profile_stage")){delCharacterProfileStage(q);}
	else if (obj.hasClass("character_profile_episode")){
		var character_id = $(this).parents(".character_block").data("id");
		delCharacterProfileEpisode(q, character_id);
	}
});

// クリアボタン
// ・完全新規ならテキストエリアをクリア
// ・編集なら表示モードに切り替える
$(document).on("click", ".character_profile_clear_icon.clickable", function(){
	var q = $(this).parents(".li-character_profile").data("q");
	if (q == "0"){
		$(this).parents(".edit_mode").find(".character_profile_a textarea").val("");
	}
	else{
		$(this).parents(".li-character_profile").find(".edit_mode").addClass("hidden");
		$(this).parents(".li-character_profile").find(".view_mode").removeClass("hidden");
	}
});

// 保存ボタン（新規登録or更新関数をコール）
$(document).on("click", ".character_profile_save_icon.clickable", function(){
	var obj = $(this).parents("ul");
	var q = $(this).parents(".li-character_profile").data("q");
	var a = $(this).parents(".edit_mode").find(".character_profile_a textarea").val();
	var new_q = $(this).parents(".edit_mode").find(".character_profile_q select").val();

	if (obj.hasClass("character_profile")){
		if (q == "0"){addCharacterProfile(new_q, a);}
		else{setCharacterProfile(q, a);}
	}
	else if (obj.hasClass("character_profile_stage")){
		if (q == "0"){addCharacterProfileStage(new_q, a);}
		else{
			if ($(this).parents("li").find(".view_mode .character_profile_a").hasClass("not_override")){addCharacterProfileStage(q, a);}
			else{setCharacterProfileStage(q, a);}
		}
	}
	else if (obj.hasClass("character_profile_episode")){
		var character_id = $(this).parents(".character_block").data("id");
		if (q == "0"){addCharacterProfileEpisode(new_q, a, character_id);}
		else{
			if ($(this).parents("li").find(".view_mode .character_profile_a").hasClass("not_override")){addCharacterProfileEpisode(q, a, character_id);}
			else{setCharacterProfileEpisode(q, a, character_id);}
		}
	}
});

// オーバーライド前の情報の表示/非表示切り替え
$(document).on("click", ".view_mode div.character_profile_a.clickable", function(){
	$(this).find(".profile_reference").toggleClass("hidden");
});

// キャラクタープロフィール項目入力欄を増やす
// 引数はセレクタ文字列（コピーするliにあたる部分）
function copyCharacterProfileForm(template_li_obj){
	var obj = $(template_li_obj).clone().appendTo($(template_li_obj).parents("ul"));
	$(obj).data("q", "0");
	$(obj).attr("data-q", "0");
	$(obj).removeClass("template-for-copy");

	// セレクトボックス用
	$(obj).find('.select2').select2();

	return $(obj);
}

function drawCharacterProfile(li_obj, mode, type, params){

	// 削除（削除ボタンを押下された場合の描画、li_objは削除対象、typeとparamは不要）
	if (mode == "del"){
		if (li_obj.find(".profile_sub").text() == ""){
			// 枠ごと削除
			li_obj.remove();
		}
		else {
			// サブのプロフィール表示に切り替える
			li_obj.find(".view_mode .character_profile_a .profile_main").text("");
			li_obj.find(".view_mode .character_profile_a .profile_main").addClass("hidden");
			li_obj.find(".view_mode .character_profile_a .profile_sub").removeClass("hidden");
			li_obj.find(".view_mode .character_profile_a").addClass("not_override");
			li_obj.find(".view_mode .character_profile_a").removeClass("override");

			// テキストエリア
			li_obj.find(".edit_mode .character_profile_a textarea").val("");

			// 削除アイコンを無効にする
			li_obj.find(".view_mode .character_profile_delete_icon").addClass("disabled");
			li_obj.find(".view_mode .character_profile_delete_icon").removeClass("clickable");
		}
		return true;
	}

	// 新規描画（テンプレートをコピーして描画、li_objはテンプレート）
	// 新規追加（新規フォームに入力された場合の描画、li_objは更新対象）
	// 更新（更新フォームに入力された場合の描画、li_objは更新対象）
	else if (mode == "new" || mode == "add" || mode == "set"){
		var q   = params['question'];
		var qt  = params['question_title'];
		var a   = params['answer'];
		var ab  = params['answer_base'];
		var as  = params['answer_stage'];
		var aep = params['answer_prev_episode_list'];
		var aen = params['answer_next_episode_list'];

		// 入力フォームを増やす
		if (mode == "new"){
			li_obj = copyCharacterProfileForm(li_obj.parents("ul").find("li.template-for-copy"));
		}

		// メイン内容があればセット
		if (a !== undefined && a != null && a != ""){
			// メインの内容
			li_obj.find(".view_mode .character_profile_a .profile_main").html(strToText(a));
			li_obj.find(".view_mode .character_profile_a .profile_main").removeClass("hidden");
			li_obj.find(".view_mode .character_profile_a .profile_sub").addClass("hidden");

			// テキストエリア
			li_obj.find(".edit_mode .character_profile_a textarea").val(a);

			// 削除アイコンを有効にする
			li_obj.find(".view_mode .character_profile_delete_icon").removeClass("disabled");
			li_obj.find(".view_mode .character_profile_delete_icon").addClass("clickable");

			if (type == "stage" || type == "episode"){
				// ステージ・エピソードの場合はオーバーライドされているということになる
				li_obj.find(".view_mode .character_profile_a").addClass("override");
				li_obj.find(".view_mode .character_profile_a").removeClass("not_override");
			}
			else{
				// 通常プロフィールの場合はオーバーライドではない
				li_obj.find(".view_mode .character_profile_a").removeClass("override");
				li_obj.find(".view_mode .character_profile_a").addClass("not_override");
			}
		}
		// メインの内容がない場合はサブを有効にする
		else{
			// メインの内容
			li_obj.find(".view_mode .character_profile_a .profile_main").text("");

			// テキストエリア
			li_obj.find(".edit_mode .character_profile_a textarea").val("");

			// 削除アイコンを無効にする
			li_obj.find(".view_mode .character_profile_delete_icon").addClass("disabled");
			li_obj.find(".view_mode .character_profile_delete_icon").removeClass("clickable");

			// メインを非表示、サブを表示
			li_obj.find(".view_mode .character_profile_a .profile_sub").removeClass("hidden");
			li_obj.find(".view_mode .character_profile_a .profile_main").addClass("hidden");

			// 必ずオーバーライドにはならない
			li_obj.find(".view_mode .character_profile_a").removeClass("override");
			li_obj.find(".view_mode .character_profile_a").addClass("not_override");
		}

		// 参考内容の表示非表示制御
		if (type == "stage"){
			li_obj.find(".profile_reference .profile_base").removeClass("hidden");
		}
		else if (type == "episode"){
			li_obj.find(".profile_reference .profile_base").removeClass("hidden");
			li_obj.find(".profile_reference .profile_stage").removeClass("hidden");
			li_obj.find(".profile_reference .profile_episode_prev").removeClass("hidden");
			li_obj.find(".profile_reference .profile_episode_next").removeClass("hidden");
		}

		// 通常以外かつ新規描画の場合のみ、サブ内容と参考内容を埋める
		// （通常プロフィールでは未使用、かつ追加更新では変更が発生しない）
		if (mode == "new" && type != "base"){
			// サブ
			var sub = "";
			if (aep != undefined && aep.length > 0){sub = aep[aep.length - 1]['answer'];}
			else if (as != undefined && as != null && as != ""){sub = as;}
			else if (ab != undefined && ab != null && ab != ""){sub = ab;}
			li_obj.find(".view_mode .character_profile_a .profile_sub").html(strToText(sub));

			// 参考
			if (ab !== undefined && ab != null && ab != ""){
				li_obj.find(".profile_base .profile_reference_content.is_fill").html(strToText(ab));
				li_obj.find(".profile_base .profile_reference_content.is_fill").removeClass("hidden");
				li_obj.find(".profile_base .profile_reference_content.is_empty").addClass("hidden");
			}
			if (as !== undefined && as != null && as != ""){
				li_obj.find(".profile_stage .profile_reference_content.is_fill").html(strToText(as));
				li_obj.find(".profile_stage .profile_reference_content.is_fill").removeClass("hidden");
				li_obj.find(".profile_stage .profile_reference_content.is_empty").addClass("hidden");
			}
			if (aep != undefined && aep.length > 0){
				var tmp_obj = li_obj.find(".profile_episode_prev .profile_reference_content.is_fill ul");
				$(aep).each(function(i, e){
					$(tmp_obj).append("<li>" + strToText(e.answer) + "</li>");
				});
				li_obj.find(".profile_episode_prev .profile_reference_content.is_fill").removeClass("hidden");
				li_obj.find(".profile_episode_prev .profile_reference_content.is_empty").addClass("hidden");
			}
			if (aen != undefined && aen.length > 0){
				var tmp_obj = li_obj.find(".profile_episode_next .profile_reference_content.is_fill ul");
				$(aen).each(function(i, e){
					$(tmp_obj).append("<li>" + strToText(e.answer) + "</li>");
				});
				li_obj.find(".profile_episode_next .profile_reference_content.is_fill").removeClass("hidden");
				li_obj.find(".profile_episode_next .profile_reference_content.is_empty").addClass("hidden");
			}
		}

		if (mode == "new" || mode == "add"){
			// 新規の登録時・描画時

			// 項目ID
			li_obj.attr("data-q", q);
			li_obj.data("q", q);

			// 項目名
			li_obj.find(".view_mode .character_profile_q").text(qt);
			li_obj.find(".edit_mode .character_profile_q.set_mode").text(qt);

			// 追加モード部分を削除、更新モード部分を可視化
			li_obj.find(".edit_mode .character_profile_q.add_mode").remove();
			li_obj.find(".edit_mode .character_profile_q.set_mode").removeClass("hidden");

			// 入力フォームから、今回登録した項目を削除する
			li_obj.parents("ul").find(".li-character_profile.template-for-copy .select2 option[value='" + q + "']").remove();
		}

		// 表示モードに切り替え
		li_obj.find(".edit_mode").addClass("hidden");
		li_obj.find(".view_mode").removeClass("hidden");
		li_obj.removeClass("template-for-copy");

		// 次の入力フォームを増やす
		if (mode == "add"){
			copyCharacterProfileForm(li_obj.parents("ul").find("li.template-for-copy"));
		}

		return true;
	}

	// 不明なモード
	else{
		console.log("[drawCharacterProfile]モード未指定エラー");
	}
}

/********/
/* 通常 */
/********/

/*
 * 登録
 */
function addCharacterProfile(q, a){
	var params = {
			'character_id' : $(".hidden-character_id").val(),
			'question'     : q,
			'answer'       : a,
		};
	var result = ajaxPost("character", "addProfile", params);
    result.done(function(){
		if (isAjaxResultErrorRedirect(result.return_value) === true) {return false;}  // 必要ならエラーページへリダイレクト
		if (isAjaxResultErrorMsg(result.return_value) === true){return false;} // 必要ならエラーメッセージ表示

		// 正常な場合

		// 表示モード部分に値をセット
		drawCharacterProfile($("#character_profile .li-character_profile[data-q='0']"), "add", "base", result.return_value);

		return true;
    });
}

/*
 * 更新
 */
function setCharacterProfile(q, a){
	var params = {
			'character_id' : $(".hidden-character_id").val(),
			'question'     : q,
			'answer'       : a,
		};
	var result = ajaxPost("character", "setProfile", params);
    result.done(function(){
		if (isAjaxResultErrorRedirect(result.return_value) === true) {return false;}  // 必要ならエラーページへリダイレクト
		if (isAjaxResultErrorMsg(result.return_value) === true){return false;} // 必要ならエラーメッセージ表示

		// 正常な場合

		// 表示モード部分に値をセット
		drawCharacterProfile($("#character_profile .li-character_profile[data-q='" + q + "']"), "set", "base", result.return_value);

		return true;
    });
}

/*
 * 削除
 */
function delCharacterProfile(q){
    if (!confirm("本当にこの項目を削除してよろしいですか？")){
        return false;
    }

	var params = {
			'character_id' : $(".hidden-character_id").val(),
			'question'     : q,
		};
	var result = ajaxPost("character", "delProfile", params);
    result.done(function(){
		if (isAjaxResultErrorRedirect(result.return_value) === true) {return false;}  // 必要ならエラーページへリダイレクト
		if (isAjaxResultErrorMsg(result.return_value) === true){return false;} // 必要ならエラーメッセージ表示

		// 正常な場合

		// 表示部分を削除
		drawCharacterProfile($("#character_profile .li-character_profile[data-q='" + q + "']"), "del");

		return true;
    });
}

/****************************/
/* オーバーライド：ステージ */
/****************************/

/*
 * 登録
 */
function addCharacterProfileStage(q, a){
	var params = {
			'character_id' : $("#character_id").val(),
			'stage_id'     : $("#stage_id").val(),
			'question'     : q,
			'answer'       : a,
		};
	var result = ajaxPost("character", "addProfileStage", params);
	result.done(function(){
		if (isAjaxResultErrorRedirect(result.return_value) === true) {return false;}  // 必要ならエラーページへリダイレクト
		if (isAjaxResultErrorMsg(result.return_value) === true){return false;} // 必要ならエラーメッセージ表示

		// 正常な場合
		if ($("#character_profile_stage .li-character_profile[data-q='" + q + "']").length == 1){
			drawCharacterProfile($("#character_profile_stage .li-character_profile[data-q='" + q + "']"), "set", "stage", result.return_value);
		}
		else{
			drawCharacterProfile($("#character_profile_stage .li-character_profile[data-q='0']"), "add", "stage", result.return_value);
		}

		return true;
	});
}

/*
 * 更新
 */
function setCharacterProfileStage(q, a){
	var params = {
			'character_id' : $("#character_id").val(),
			'stage_id'     : $("#stage_id").val(),
			'question'     : q,
			'answer'       : a,
		};
	var result = ajaxPost("character", "setProfileStage", params);
	result.done(function(){
		if (isAjaxResultErrorRedirect(result.return_value) === true) {return false;}  // 必要ならエラーページへリダイレクト
		if (isAjaxResultErrorMsg(result.return_value) === true){return false;} // 必要ならエラーメッセージ表示

		// 正常な場合
		drawCharacterProfile($("#character_profile_stage .li-character_profile[data-q='" + q + "']"), "set", "stage", result.return_value);

		return true;
	});
}

/*
 * 削除
 */
function delCharacterProfileStage(q){
	if (!confirm("本当にこの項目を削除してよろしいですか？")){
		return false;
	}

	var params = {
			'character_id' : $("#character_id").val(),
			'stage_id'     : $("#stage_id").val(),
			'question'     : q,
		};
	var result = ajaxPost("character", "delProfileStage", params);
	result.done(function(){
		if (isAjaxResultErrorRedirect(result.return_value) === true) {return false;}  // 必要ならエラーページへリダイレクト
		if (isAjaxResultErrorMsg(result.return_value) === true){return false;} // 必要ならエラーメッセージ表示

		// 正常な場合
		drawCharacterProfile($("#character_profile_stage .li-character_profile[data-q='" + q + "']"), "del", "stage", result.return_value);

		return true;
	});
}

/******************************/
/* オーバーライド：エピソード */
/******************************/

/*
 * 登録
 */
function addCharacterProfileEpisode(q, a, character_id){
	var params = {
			'character_id' : character_id,
			'episode_id'   : $("#modal-setEpisode .form-id").val(),
			'question'     : q,
			'answer'       : a,
		};
	var result = ajaxPost("character", "addProfileEpisode", params);
	result.done(function(){
		if (isAjaxResultErrorRedirect(result.return_value) === true) {return false;}  // 必要ならエラーページへリダイレクト
		if (isAjaxResultErrorMsg(result.return_value) === true){return false;} // 必要ならエラーメッセージ表示

		// 正常な場合
		if ($("#set_forms-override .character_block[data-id='" + character_id + "'] .li-character_profile[data-q='" + q + "']").length == 1){
			drawCharacterProfile($("#set_forms-override .character_block[data-id='" + character_id + "'] .li-character_profile[data-q='" + q + "']"), "set", "episode", result.return_value);
		}
		else{
			drawCharacterProfile($("#set_forms-override .character_block[data-id='" + character_id + "'] .li-character_profile[data-q='0']"), "add", "episode", result.return_value);
		}

		return true;
	});
}

/*
 * 更新
 */
function setCharacterProfileEpisode(q, a, character_id){
	var params = {
			'character_id' : character_id,
			'episode_id'   : $("#modal-setEpisode .form-id").val(),
			'question'     : q,
			'answer'       : a,
		};
	var result = ajaxPost("character", "setProfileEpisode", params);
	result.done(function(){
		if (isAjaxResultErrorRedirect(result.return_value) === true) {return false;}  // 必要ならエラーページへリダイレクト
		if (isAjaxResultErrorMsg(result.return_value) === true){return false;} // 必要ならエラーメッセージ表示

		// 正常な場合
		drawCharacterProfile($("#set_forms-override .character_block[data-id='" + character_id + "'] .li-character_profile[data-q='" + q + "']"), "set", "episode", result.return_value);

		return true;
	});
}

/*
 * 削除
 */
function delCharacterProfileEpisode(q, character_id){
	if (!confirm("本当にこの項目を削除してよろしいですか？")){
		return false;
	}
	var params = {
			'character_id' : character_id,
			'episode_id'   : $("#modal-setEpisode .form-id").val(),
			'question'     : q,
		};
	var result = ajaxPost("character", "delProfileEpisode", params);
	result.done(function(){
		if (isAjaxResultErrorRedirect(result.return_value) === true) {return false;}  // 必要ならエラーページへリダイレクト
		if (isAjaxResultErrorMsg(result.return_value) === true){return false;} // 必要ならエラーメッセージ表示

		// 正常な場合
		drawCharacterProfile($("#set_forms-override .character_block[data-id='" + character_id + "'] .li-character_profile[data-q='" + q + "']"), "del");

		return true;
	});
}
