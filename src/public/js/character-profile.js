// 詳細プロフィール：編集ボタン押下時（編集フォームに切り替える）
$(document).on("click", ".character_profile_edit_icon.clickable", function(){
	var q = $(this).parents(".li-character_profile").data("q");
	showCharacterProfileForm(q);
});

// 詳細プロフィール：削除ボタン押下時（削除する）
$(document).on("click", ".character_profile_delete_icon.clickable", function(){
	var q = $(this).parents(".li-character_profile").data("q");
	delCharacterProfile(q);
});

// 詳細プロフィール：保存ボタン押下時（新規登録or更新する）
$(document).on("click", ".character_profile_save_icon.clickable", function(){
	var q = $(this).parents(".li-character_profile").data("q");
	var a = $(this).parents(".edit_mode").find(".character_profile_a textarea").val();

	if (q == "0"){
		q = $(this).parents(".edit_mode").find(".character_profile_q select").val();
		addCharacterProfile(q, a);
	}
	else{
		setCharacterProfile(q, a);
	}
});

/*
 * キャラクタープロフィール項目入力欄を増やす
 */
function copyCharacterProfileForm(){
	var obj_base = $(".li-character_profile.template-for-copy")[0];
	var obj = $(obj_base).clone().appendTo($(".ul-character_profile"));
	$(obj).data("q", "0");
	$(obj).attr("data-q", "0");
	$(obj).removeClass("template-for-copy");

	// セレクトボックス用
	$(obj).find('.select2').select2();
}

/*
 * 通常表示からキャラクタープロフィール項目入力欄に切り替える
 */
function showCharacterProfileForm(q){
	var obj = $(".li-character_profile[data-q='" + q + "']");
	obj.find(".view_mode").addClass("hidden");
	obj.find(".edit_mode").removeClass("hidden");
}

/*
 * 登録（キャラクタープロフィール項目）
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
		obj.find(".view_mode .character_profile_a").html(strToText(result.return_value['answer']));
		obj.find(".edit_mode .character_profile_q.set_mode").text(result.return_value['question_title']);
		obj.find(".edit_mode .character_profile_q.add_mode").remove();
		obj.find(".edit_mode .character_profile_q.set_mode").removeClass("hidden");

		// 表示モードに切り替え
		obj.find(".edit_mode").addClass("hidden");
		obj.find(".view_mode").removeClass("hidden");

		// 入力フォームから、今回登録した項目を削除する
		$(".li-character_profile.template-for-copy .select2 option[value='" + q + "']").remove();

		// 次の入力フォームを増やす
		copyCharacterProfileForm();

		return true;
    });
}

/*
 * 更新（キャラクタープロフィール項目）
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
		obj.find(".view_mode .character_profile_a").text(result.return_value['answer']);

		// 表示モードに切り替え
		obj.find(".edit_mode").addClass("hidden");
		obj.find(".view_mode").removeClass("hidden");

		return true;
    });
}

/*
 * 削除（キャラクタープロフィール項目）
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