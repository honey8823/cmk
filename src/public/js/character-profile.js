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
			if ($(this).parents("li").find(".override").hasClass("hidden")){addCharacterProfileStage(q, a);}
			else{setCharacterProfileStage(q, a);}
		}
	}
	else if (obj.hasClass("character_profile_episode")){
		var character_id = $(this).parents(".character_block").data("id");
		if (q == "0"){addCharacterProfileEpisode(new_q, a, character_id);}
		else{
			if ($(this).parents("li").find(".override").hasClass("hidden")){addCharacterProfileEpisode(q, a, character_id);}
			else{setCharacterProfileEpisode(q, a, character_id);}
		}
	}
});

// オーバーライド前の情報の表示/非表示切り替え
$(document).on("click", ".character_profile_override_icon.clickable", function(){
	$(this).parents("li").find(".character_profile_a.not_override:not(.current)").toggleClass("hidden");
});

// キャラクタープロフィール項目入力欄を増やす
// 引数はセレクタ文字列（コピーするliにあたる部分）
function copyCharacterProfileForm(template_selector){
	var obj_base = $(template_selector)[0];
	var obj = $(obj_base).clone().appendTo($(template_selector).parents("ul"));
	$(obj).data("q", "0");
	$(obj).attr("data-q", "0");
	$(obj).removeClass("template-for-copy");

	// セレクトボックス用
	$(obj).find('.select2').select2();
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
		var obj = $(".li-character_profile[data-q='0']");
		obj.data("q", result.return_value['question']);
		obj.attr("data-q", result.return_value['question']);
		obj.find(".view_mode .character_profile_q").text(result.return_value['question_title']);
		obj.find(".view_mode .character_profile_a.profile_base").html(strToText(result.return_value['answer']));
		obj.find(".edit_mode .character_profile_q.set_mode").text(result.return_value['question_title']);
		obj.find(".edit_mode .character_profile_q.add_mode").remove();
		obj.find(".edit_mode .character_profile_q.set_mode").removeClass("hidden");

		// 表示モードに切り替え
		obj.find(".edit_mode").addClass("hidden");
		obj.find(".view_mode").removeClass("hidden");

		// 入力フォームから、今回登録した項目を削除する
		$(".li-character_profile.template-for-copy .select2 option[value='" + q + "']").remove();

		// 次の入力フォームを増やす
		copyCharacterProfileForm("#tab-content-profile .li-character_profile.template-for-copy");

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
		var obj = $(".li-character_profile[data-q='" + q + "']");
		obj.find(".view_mode .character_profile_a.profile_base").html(strToText(result.return_value['answer']));

		// 表示モードに切り替え
		obj.find(".edit_mode").addClass("hidden");
		obj.find(".view_mode").removeClass("hidden");

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
		$(".li-character_profile[data-q='" + q + "']").remove();

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
		var is_form_update = 0;
		if ($("#character_profile_stage .li-character_profile[data-q='" + q + "']").length == 1){
			var obj = $(".li-character_profile[data-q='" + q + "']");
			is_form_update = 1;
		}
		else{
			var obj = $("#character_profile_stage .li-character_profile[data-q='0']");
		}
		obj.data("q", result.return_value['question']);
		obj.attr("data-q", result.return_value['question']);
		obj.data("is_stage", "1");
		obj.attr("data-is_stage", "1");
		obj.find(".character_profile_original_icon").addClass("hidden");
		obj.find(".character_profile_override_icon").removeClass("hidden");

		// 表示モード部分に値をセット
		obj.find(".view_mode .character_profile_q").text(result.return_value['question_title']);
		obj.find(".view_mode .character_profile_a.profile_stage").html(strToText(result.return_value['answer']));
		obj.find(".view_mode .character_profile_a.profile_base").addClass("hidden");
		obj.find(".view_mode .character_profile_a.profile_stage").removeClass("hidden");

		// 編集モード部分に値をセット
		obj.find(".edit_mode .character_profile_q.set_mode").text(result.return_value['question_title']);
		obj.find(".edit_mode .character_profile_q.set_mode").removeClass("hidden");
		obj.find(".edit_mode .character_profile_q.add_mode").remove();

		// 表示モードに切り替え
		obj.find(".edit_mode").addClass("hidden");
		obj.find(".view_mode").removeClass("hidden");

		// 入力フォームから、今回登録した項目を削除する
		$("#character_profile_stage .li-character_profile.template-for-copy .select2 option[value='" + q + "']").remove();

		// 次の入力フォームを増やす
		if (is_form_update != 1){
			copyCharacterProfileForm("#character_profile_stage .li-character_profile.template-for-copy");
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
		var obj = $("#character_profile_stage .li-character_profile[data-q='" + q + "']");

		// 表示モード部分に値をセット
		obj.find(".view_mode .character_profile_a.profile_stage").html(strToText(result.return_value['answer']));

		// 表示モードに切り替え
		obj.find(".edit_mode").addClass("hidden");
		obj.find(".view_mode").removeClass("hidden");

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
		var obj = $(".li-character_profile[data-q='" + q + "']");

		// 基本プロフィールが存在する場合は切り替え
		if (obj.data("is_base") == "1"){

			// ステージフラグを消す
			obj.data("is_stage", "0");
			obj.attr("data-is_stage", "0");

			// 編集用テキストエリアをクリア
			obj.find(".edit_mode .character_profile_a textarea").val("");

			// ステージの値を消す
			$(obj).find(".view_mode .character_profile_a.profile_stage").html("");

			// 表示/非表示の切り替え
			$(obj).find(".view_mode .character_profile_a.profile_base").removeClass("hidden");
			$(obj).find(".view_mode .character_profile_a.profile_stage").addClass("hidden");
			$(obj).find(".character_profile_override_icon").addClass("hidden");
			$(obj).find(".character_profile_original_icon").removeClass("hidden");
		}
		// 基本プロフィールが存在しない場合は削除
		else{
			obj.remove();
		}

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
		var obj_character_selector = "#set_forms-override .character_block[data-id='" + character_id + "']";
		if ($(obj_character_selector).length != 1){
			return false;
		}

		var is_form_update = 0;
		if ($(obj_character_selector + " .li-character_profile[data-q='" + q + "']").length == 1){
			var obj = $(obj_character_selector + " .li-character_profile[data-q='" + q + "']");
			is_form_update = 1;
		}
		else{
			var obj = $(obj_character_selector + " .li-character_profile[data-q='0']");
		}

		obj.data("q", result.return_value['question']);
		obj.attr("data-q", result.return_value['question']);
		obj.find(".character_profile_original_icon").addClass("hidden");
		obj.find(".character_profile_override_icon").removeClass("hidden");

		// 表示モード部分に値をセット
		obj.find(".view_mode .character_profile_q").text(result.return_value['question_title']);
		obj.find(".view_mode .character_profile_a.profile_episode").html(strToText(result.return_value['answer']));
		obj.find(".view_mode .character_profile_a:not(.profile_episode)").addClass("hidden");
		obj.find(".view_mode .character_profile_a.profile_episode").removeClass("hidden");
		obj.find(".view_mode .current").removeClass("current");

		// 編集モード部分に値をセット
		obj.find(".edit_mode .character_profile_q.set_mode").text(result.return_value['question_title']);
		obj.find(".edit_mode .character_profile_q.set_mode").removeClass("hidden");
		obj.find(".edit_mode .character_profile_q.add_mode").remove();

		// 表示モードに切り替え
		obj.find(".edit_mode").addClass("hidden");
		obj.find(".view_mode").removeClass("hidden");

		// 入力フォームから、今回登録した項目を削除する
		$(obj_character_selector + " .li-character_profile.template-for-copy .select2 option[value='" + q + "']").remove();

		// 次の入力フォームを増やす
		if (is_form_update != 1){
			copyCharacterProfileForm(obj_character_selector + " .li-character_profile.template-for-copy");
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
		var obj = $("#set_forms-override .character_block[data-id='" + character_id + "'] .li-character_profile[data-q='" + q + "']");

		// 表示モード部分に値をセット
		obj.find(".view_mode .character_profile_a.profile_episode").html(strToText(result.return_value['answer']));

		// 表示モードに切り替え
		obj.find(".edit_mode").addClass("hidden");
		obj.find(".view_mode").removeClass("hidden");

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
		var obj = $("#set_forms-override .character_block[data-id='" + character_id + "'] .li-character_profile[data-q='" + q + "']");

		// 基本プロフィールが存在する場合は切り替え
		if (obj.find(".view_mode .character_profile_a.pre_current").length == 1){

			// 編集用テキストエリアをクリア
			obj.find(".edit_mode .character_profile_a textarea").val("");

			// オーバーライドの値を消す
			obj.find(".view_mode .character_profile_a.profile_episode").html("");

			// 表示/非表示の切り替え
			if (obj.find(".view_mode .character_profile_a.pre_current").hasClass("profile_base")){}
			else{obj.find(".view_mode .character_profile_a.pre_current").addClass("current");}
			obj.find(".view_mode .character_profile_a.pre_current").removeClass("hidden");
			obj.find(".view_mode .character_profile_a.profile_episode").addClass("hidden");

			// todo::ステージ等でオーバーライドしてる場合を考慮する必要あり
			obj.find(".character_profile_override_icon").addClass("hidden");
			obj.find(".character_profile_original_icon").removeClass("hidden");
		}
		// 基本プロフィールが存在しない場合は削除
		else{
			obj.remove();
		}

		return true;
	});
}
