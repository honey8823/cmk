$(document).on("click", ".is_favorite_icon.clickable", function(event){
	// aタグによる遷移無効化
	event.preventDefault();

	if ($(this).hasClass("is_favorite_1")){
		// お気に入り解除
		$(this).addClass("hidden");
		$(this).parent().find(".is_favorite_0").removeClass("hidden");

		var params = {
				'type_key' : $(this).data("favorite_type_key"),
				'id'       : $(this).data("id"),
			};
		var result = ajaxPost("favorite", "del", params);
	    result.done(function(){
			// 正常な場合
			return true;
	    });
	}
	else{
		// お気に入りに追加
		$(this).addClass("hidden");
		$(this).parent().find(".is_favorite_1").removeClass("hidden");

		var params = {
				'type_key' : $(this).data("favorite_type_key"),
				'id'       : $(this).data("id"),
			};
		var result = ajaxPost("favorite", "add", params);
	    result.done(function(){
			// 正常な場合
			return true;
	    });
	}
});