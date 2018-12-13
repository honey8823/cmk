/**********************/
/* 編集エリアの操作類 */
/**********************/

// 登録フォームの切り替え
$(document).on("click", "#modal-upsertCharacterRelation .forms-switch", function(){
	// 片方ずつ→双方向に変更する際のエラー
	if ($(this).hasClass("btn-form_both")
		&& $("#upsert_forms-oneway .character_relation-title_a").val() != ""
		&& $("#upsert_forms-oneway .character_relation-title_b").val() != ""
		&& $("#upsert_forms-oneway .character_relation-title_a").val() != $("#upsert_forms-oneway .character_relation-title_b").val()){
		alert("タイトルのいずれかを空にするか、同じ内容にする必要があります。");
		return false;
	}

	// フォームの中身をもう一方に移す
	if ($(this).hasClass("btn-form_both")){
		// 片方ずつ→双方向
		var title_a = $("#upsert_forms-oneway .character_relation-title_a").val();
		title_a = (title_a != "") ? title_a : $("#upsert_forms-oneway .character_relation-title_b").val();
		$("#upsert_forms-both .character_relation-title_a").val(title_a);
		$("#upsert_forms-both .character_relation-free_text_a").val($("#upsert_forms-oneway .character_relation-free_text_a").val());
		$("#upsert_forms-both .character_relation-free_text_b").val($("#upsert_forms-oneway .character_relation-free_text_b").val());
	}
	else{
		// 双方向→片方ずつ
		$("#upsert_forms-oneway .character_relation-title_a").val($("#upsert_forms-both .character_relation-title_a").val());
		$("#upsert_forms-oneway .character_relation-title_b").val($("#upsert_forms-both .character_relation-title_a").val());
		$("#upsert_forms-oneway .character_relation-free_text_a").val($("#upsert_forms-both .character_relation-free_text_a").val());
		$("#upsert_forms-oneway .character_relation-free_text_b").val($("#upsert_forms-both .character_relation-free_text_b").val());
	}

	// フォーム切り替え
	$("#upsert_forms-oneway").addClass("hidden");
	$("#upsert_forms-both").addClass("hidden");
	$("#upsert_forms-" + $(this).data("target_forms_id")).removeClass("hidden");
});

// オーバーライド前の情報の表示/非表示切り替え
$(document).on("click", ".view_mode div.character_relation_a.clickable", function(){
	$(this).find(".relation_reference").toggleClass("hidden");
});

function drawCharacterRelation(li_obj, type, params){
	var is_both     = params['is_both'];
	var title_a     = params['title_a'];
	var title_b     = params['title_b'];
	var free_text_a = params['free_text_a'];
	var free_text_b = params['free_text_b'];

	// 矢印とタイトルの出し分け
	li_obj.find(".character_relation-arrow .undefined").addClass("hidden");
	li_obj.find(".relation-arrow_right:not(.relation-arrow_left)").addClass("hidden");
	li_obj.find(".relation-arrow_left:not(.relation-arrow_right)").addClass("hidden");
	li_obj.find(".relation-arrow_right.relation-arrow_left").addClass("hidden");
	if (is_both == "1"){
		// 双方向
		li_obj.find(".relation-arrow_right.relation-arrow_left").removeClass("hidden");
		li_obj.find(".relation-arrow_right.relation-arrow_left > span").html(strToText(title_a));
	}
	else if(title_a != "" || free_text_a != "" || title_b != "" || free_text_b != ""){
		// 片方ずつ
		if (title_a != "" || free_text_a != ""){
			li_obj.find(".relation-arrow_right:not(.relation-arrow_left)").removeClass("hidden");
			li_obj.find(".relation-arrow_right:not(.relation-arrow_left) > span").html(strToText(title_a));
		}
		if (title_b != "" || free_text_b != ""){
			li_obj.find(".relation-arrow_left:not(.relation-arrow_right)").removeClass("hidden");
			li_obj.find(".relation-arrow_left:not(.relation-arrow_right) > span").html(strToText(title_b));
		}
	}
	else{
		// 未定義
		li_obj.find(".character_relation-arrow.undefined").removeClass("hidden");
	}

	// フリーテキスト
	li_obj.find(".character_relation-free_text_a > span").addClass("hidden");
	li_obj.find(".character_relation-free_text_b > span").addClass("hidden");
	if (free_text_a != ""){
		li_obj.find(".character_relation-free_text_a > span").removeClass("hidden");
		li_obj.find(".character_relation-free_text_a > span").html(strToText(free_text_a));
	}
	if (free_text_b != ""){
		li_obj.find(".character_relation-free_text_b > span").removeClass("hidden");
		li_obj.find(".character_relation-free_text_b > span").html(strToText(free_text_b));
	}

	return true;
}

function setRelationModal(another_id){
	var result = ajaxPost("character", "getRelation", {'id': $("#area-upsertCharacterRelation .form-id").val(), 'another_id': another_id});
    result.done(function(){
		if (isAjaxResultErrorRedirect(result.return_value) === true) {return false;}  // 必要ならエラーページへリダイレクト
		if (isAjaxResultErrorMsg(result.return_value) === true){return false;} // 必要ならエラーメッセージ表示

		// 正常な場合

		// フォームの中身をクリア
		$("#modal-upsertCharacterRelation").find("input[type=text]").val("");
		$("#modal-upsertCharacterRelation").find("textarea").val("");
		if (result.return_value['is_both'] == "1"){
			$("#upsert_forms-oneway").addClass("hidden");
			$("#upsert_forms-both").removeClass("hidden");
		}
		else {
			$("#upsert_forms-oneway").removeClass("hidden");
			$("#upsert_forms-both").addClass("hidden");
		}

		// フォームにセット
		$("#modal-upsertCharacterRelation .form-another_id").val(result.return_value['character_id']);
		$("#area-upsertCharacterRelation .character_name").text(result.return_value['character_name']);
		$("#area-upsertCharacterRelation .character_relation-title_a").val(result.return_value['title_a']);
		$("#area-upsertCharacterRelation .character_relation-free_text_a").val(result.return_value['free_text_a']);
		$("#area-upsertCharacterRelation .character_relation-title_b").val(result.return_value['title_b']);
		$("#area-upsertCharacterRelation .character_relation-free_text_b").val(result.return_value['free_text_b']);

		return true;
    });
}

/********/
/* 通常 */
/********/
/*
 * 更新
 */
function upsertCharacterRelation(q, a){
	var id = $("#area-upsertCharacterRelation .form-id").val();
	var another_id = $("#modal-upsertCharacterRelation .form-another_id").val();
	if (!$("#upsert_forms-oneway").hasClass("hidden")){
		// 片方ずつ
		var params = {
				'character_id'         : id,
				'character_another_id' : another_id,
				'is_both'              : 0,
				'title_a'              : $("#upsert_forms-oneway .character_relation-title_a").val(),
				'title_b'              : $("#upsert_forms-oneway .character_relation-title_b").val(),
				'free_text_a'          : $("#upsert_forms-oneway .character_relation-free_text_a").val(),
				'free_text_b'          : $("#upsert_forms-oneway .character_relation-free_text_b").val(),
			};
	}
	else {
		// 双方向
		var params = {
				'character_id'         : id,
				'character_another_id' : another_id,
				'is_both'              : 1,
				'title_a'              : $("#upsert_forms-both .character_relation-title_a").val(),
				'title_b'              : $("#upsert_forms-both .character_relation-title_a").val(),
				'free_text_a'          : $("#upsert_forms-both .character_relation-free_text_a").val(),
				'free_text_b'          : $("#upsert_forms-both .character_relation-free_text_b").val(),
			};
	}

	var result = ajaxPost("character", "upsertRelation", params);
    result.done(function(){
		if (isAjaxResultErrorRedirect(result.return_value) === true) {return false;}  // 必要ならエラーページへリダイレクト
		if (isAjaxResultErrorMsg(result.return_value) === true){return false;} // 必要ならエラーメッセージ表示

		// 正常な場合

		// 表示モード部分に値をセット
		drawCharacterRelation($("#character_relation .li-character_relation[data-character_id_to='" + another_id + "']"), "base", result.return_value);

		$('#modal-upsertCharacterRelation').modal('hide');

		return true;
    });
}

/****************************/
/* オーバーライド：ステージ */
/****************************/

/*
 * 更新
 */
function setCharacterRelationStage(q, a){
	var params = {
			'character_id' : $("#character_id").val(),
			'stage_id'     : $("#stage_id").val(),
			'question'     : q,
			'answer'       : a,
		};
	var result = ajaxPost("character", "setRelationStage", params);
	result.done(function(){
		if (isAjaxResultErrorRedirect(result.return_value) === true) {return false;}  // 必要ならエラーページへリダイレクト
		if (isAjaxResultErrorMsg(result.return_value) === true){return false;} // 必要ならエラーメッセージ表示

		// 正常な場合
		drawCharacterRelation($("#character_relation_stage .li-character_relation[data-q='" + q + "']"), "set", "stage", result.return_value);

		return true;
	});
}

/******************************/
/* オーバーライド：エピソード */
/******************************/

/*
 * 更新
 */
function setCharacterRelationEpisode(q, a, character_id){
	var params = {
			'character_id' : character_id,
			'episode_id'   : $("#modal-setEpisode .form-id").val(),
			'question'     : q,
			'answer'       : a,
		};
	var result = ajaxPost("character", "setRelationEpisode", params);
	result.done(function(){
		if (isAjaxResultErrorRedirect(result.return_value) === true) {return false;}  // 必要ならエラーページへリダイレクト
		if (isAjaxResultErrorMsg(result.return_value) === true){return false;} // 必要ならエラーメッセージ表示

		// 正常な場合
		drawCharacterRelation($("#set_forms-override .character_block[data-id='" + character_id + "'] .li-character_relation[data-q='" + q + "']"), "set", "episode", result.return_value);

		return true;
	});
}
