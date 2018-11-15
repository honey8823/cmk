/**********************/
/* 編集エリアの操作類 */
/**********************/

// 編集ボタン（編集フォームに切り替える）
$(document).on("click", ".character_profile_edit_icon.clickable", function(){
	$(this).parents(".li-character_profile").find(".view_mode").addClass("hidden");
	$(this).parents(".li-character_profile").find(".edit_mode").removeClass("hidden");
});

// 削除ボタン（削除する）
$(document).on("click", ".character_profile_delete_icon.clickable", function(){
	var obj = $(this).parents("ul");
	var q = $(this).parents(".li-character_profile").data("q");

	if (obj.hasClass("character_profile")){
		// 通常
		delCharacterProfile(q);
	}
	else if (obj.hasClass("character_profile_stage")){
		// オーバーライド(ステージ)
		delCharacterProfileStage(q);
	}
	else if (obj.hasClass("character_profile_episode")){
		// オーバーライド(エピソード)
alert("未実装です");
		//delCharacterProfileEpisode(q);
	}
});

// 保存ボタン（新規登録or更新する）
$(document).on("click", ".character_profile_save_icon.clickable", function(){
	var obj = $(this).parents("ul");
	var q = $(this).parents(".li-character_profile").data("q");
	var a = $(this).parents(".edit_mode").find(".character_profile_a textarea").val();

	if (obj.hasClass("character_profile")){
		// 通常
		if (q == "0"){
			q = $(this).parents(".edit_mode").find(".character_profile_q select").val();
			addCharacterProfile(q, a);
		}
		else{
			setCharacterProfile(q, a);
		}
	}
	else if (obj.hasClass("character_profile_stage")){
		// オーバーライド(ステージ)
		if (q == "0"){
			q = $(this).parents(".edit_mode").find(".character_profile_q select").val();
			addCharacterProfileStage(q, a);
		}
		else{
			if ($(this).parents(".li-character_profile").data("is_stage") != "1"){
				addCharacterProfileStage(q, a);
			}
			else{
				setCharacterProfileStage(q, a);
			}
		}
	}
	else if (obj.hasClass("character_profile_episode")){
		// オーバーライド(エピソード)
alert("未実装です");
//		if (q == "0"){
//			q = $(this).parents(".edit_mode").find(".character_profile_q select").val();
//			addCharacterProfileEpisode(q, a);
//		}
//		else{
//			if ($(this).parents(".li-character_profile").data("is_episode") != "1"){
//				addCharacterProfileEpisode(q, a);
//			}
//			else{
//				setCharacterProfileEpisode(q, a);
//			}
//		}
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
		if (isAjaxResultErrorMsg(result.return_value) === true ){return false;} // 必要ならエラーメッセージ表示

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
		if (isAjaxResultErrorMsg(result.return_value) === true ){return false;} // 必要ならエラーメッセージ表示

		// 正常な場合

		// 表示モード部分に値をセット
		var obj = $(".li-character_profile[data-q='" + q + "']");
		obj.find(".view_mode .character_profile_a.profile_base").text(result.return_value['answer']);

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
		if (isAjaxResultErrorMsg(result.return_value) === true ){return false;} // 必要ならエラーメッセージ表示

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
		if (isAjaxResultErrorMsg(result.return_value) === true ){return false;} // 必要ならエラーメッセージ表示

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
		if (isAjaxResultErrorMsg(result.return_value) === true ){return false;} // 必要ならエラーメッセージ表示

		// 正常な場合
		var obj = $(".li-character_profile[data-q='" + q + "']");

		// 表示モード部分に値をセット
		obj.find(".view_mode .character_profile_a.profile_stage").text(result.return_value['answer']);

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
		if (isAjaxResultErrorMsg(result.return_value) === true ){return false;} // 必要ならエラーメッセージ表示

		// 正常な場合
		var obj = $(".li-character_profile[data-q='" + q + "']");

		// 基本プロフィールが存在する場合は切り替え
		if (obj.data("is_base") == "1"){

			// ステージフラグを消す
			obj.data("is_stage", "0");
			obj.attr("data-is_stage", "0");

			// 編集用テキストエリアに基本プロフィールの値を入れる
			obj.find(".edit_mode .character_profile_a textarea").val(obj.find(".view_mode .character_profile_a").text());

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
