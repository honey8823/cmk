<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>{$smarty.const.SITE_NAME_FULL}</title>
  {include file='common/adminlte_css.tpl'}
  {include file='common/common_private_css.tpl'}
  <link href="/js/lib/cropper.css" rel="stylesheet">
</head>

{include file='common/body.tpl'}
<div class="wrapper">

  {include file='common/header.tpl'}
  {include file='common/sidebar.tpl'}

  <!-- Main content start -->
  <div class="content-wrapper">
    <!-- ///////////////////////////////////////////////////// -->

    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>アカウント管理</h1>
      <ol class="breadcrumb">
        <li><a href="/">トップ</a></li>
        <li class="active">アカウント管理</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="row">
        <div class="col-md-12">

        {* post結果のエラーメッセージエリア *}
        {if isset($error_message) && $error_message != ""}
          <div class="div-error callout callout-danger">{$error_message}</div>
        {/if}

          <div class="url-info">
            <small>
              {if $user.name == ""}-&nbsp;{else}{$user.name|escape:'html'}{/if}さんの公開ページは以下のURLです。<br>
              <a href="/public/user/detail.php?u={$user.login_id}">http://{$smarty.server.SERVER_NAME}/public/user/detail.php?u={$user.login_id}</a>
            </small>
          </div>

          <div class="box box-primary collapsed-box">
            <div class="box-header with-border clickable" data-widget="collapse">
              <h3 class="box-title">プロフィールを変更する</h3>

            </div>
            <div class="box-body" id="area-setUserProfile">
              <input type="hidden" class="form-id" value="{$user.id}">
              <div class="form-group">
                <label>ユーザー名</label>
                <input type="text" name="mail_name" class="form-control form-name" value="{$user.name}">
              </div>
              <div class="form-group">
                <label>ジャンル設定</label>
                <div>
                {foreach from=$genre_list key=k item=v_genre}
                {if isset($user.genre_list) && is_array($user.genre_list) && in_array($v_genre.id, array_column($user.genre_list, 'genre_id'))}
                  <span class="label-genre selectable clickable" value="{$v_genre.id}">{$v_genre.title}</span>
                {else}
                  <span class="label-genre selectable clickable notselected" value="{$v_genre.id}">{$v_genre.title}</span>
                {/if}
                {/foreach}
                </div>
                <div class="text-align-right">
                  <a href="#" data-toggle="modal" data-target="#modal-request" onclick="setRequestCategory('genre');">
                    <small><i class="fa fa-fw fa-arrow-circle-right" aria-hidden="true"></i>欲しいジャンルがない！</small>
                  </a>
                </div>
              </div>
              <div class="form-group">
                <label>コメント</label>
                <textarea class="form-control form-remarks" rows="3" name="remarks">{$user.remarks}</textarea>
              </div>
              <div class="form-group">
                <label>Twitter ID</label>
                <input type="text" name="twitter_id" class="form-control form-twitter_id" value="{$user.twitter_id}">
              </div>
              <div class="form-group">
                <label>Pixiv ID</label>
                <input type="text" name="pixiv_id" class="form-control form-pixiv_id" value="{$user.pixiv_id}">
              </div>
            </div>
            <div class="box-body text-align-right">
              <button type="button" class="btn btn-primary" onclick="setUserProfile();">更新する</button>
            </div>
          </div>

          <div class="box box-primary collapsed-box">
            <div class="box-header with-border clickable" data-widget="collapse">
              <h3 class="box-title">ユーザーアイコンをアップロードする</h3>
            </div>
            <div class="box-body" id="area-setUserProfile">
              <form method="POST" enctype="multipart/form-data" action="/user/account.php">
                <div style="margin: 1em; padding: 1em;">
                {if !isset($user_session.image) || $user_session.image == ""}
                  <img src="/img/icon_noimage.png" class="img-circle user-image-view">
                {else}
                  <img src="data:image/png;base64,{$user_session.image}" class="img-circle user-image-view">
                {/if}
                </div>
                <div class="form-group">
                  <input type="file" id="input-user_image" name="image">
                  <img id="select-image" style="max-width:100%; max-height: 50vh;">
                  <input type="hidden" id="upload-image-x" name="image_x" value="0">
                  <input type="hidden" id="upload-image-y" name="image_y" value="0">
                  <input type="hidden" id="upload-image-w" name="image_w" value="0">
                  <input type="hidden" id="upload-image-h" name="image_h" value="0">
                </div>
                <input type="submit" class="btn btn-primary pull-right" value="更新する">
              </form>
            </div>
          </div>

          <div class="box box-primary collapsed-box">
            <div class="box-header with-border clickable" data-widget="collapse">
              <h3 class="box-title">アカウント情報を変更する</h3>
            </div>
            <div class="box-body" id="area-setUserAccount">
              <div class="form-group">
                <label>ログインID</label>
                <input type="text" name="login_id" class="form-control form-login_id" value="{$user.login_id}" placeholder="※必須">
              </div>
              <div class="form-group">
                <label>メールアドレス（他のユーザーには公開されません）</label>
                <p class="hint-box">メールアドレスを入力いただいた場合、ログイン情報をお忘れの場合などに対応が可能となります。</p>
                <input type="text" name="mail_address" class="form-control form-mail_address" value="{$user.mail_address}">
              </div>
              <div class="form-group">
                <label>その他の設定</label>
                <div class="checkbox">
                  <label>
                    <input type="checkbox" name="is_r18" class="form-is_r18"{if $user.is_r18 == "1"} checked{/if}>
                    R18設定のコンテンツ表示を許可する
                  </label>
                  <p class="hint-box">ここにチェックが入っている場合のみ、R18設定されたコンテンツが表示されます。<br>18歳未満の方はチェックされないようご協力をお願いいたします。</p>
                </div>
                <div class="checkbox">
                  <label>
                    <input type="checkbox" name="is_hint_hidden" class="form-is_hint_hidden"{if $user.is_hint_hidden == "1"} checked{/if}>
                    ヒントコメントを表示しない
                  </label>
                  <p class="hint-box">これをオンにすると、このようなコメントが表示されなくなります。</p>
                </div>
              </div>
            </div>
            <div class="box-body text-align-right">
              <button type="button" class="btn btn-primary" onclick="setUserAccount();">更新する</button>
            </div>
          </div>

          <div class="box box-primary collapsed-box">
            <div class="box-header with-border clickable" data-widget="collapse">
              <h3 class="box-title">パスワードを変更する</h3>
            </div>
            <div class="box-body" id="area-setUserPassword">
              <div class="form-group">
                <label>現在のパスワード</label>
                <input type="password_o" name="password_o" class="form-control form-password_o">
              </div>
              <div class="form-group">
                <label>新しいパスワード</label>
                <input type="password" name="password" class="form-control form-password">
              </div>
              <div class="form-group">
                <label>新しいパスワード（もう一度）</label>
                <input type="password" name="password_c" class="form-control form-password_c">
              </div>
            </div>
            <div class="box-body text-align-right">
              <button type="button" class="btn btn-primary" onclick="setUserPassword();">更新する</button>
            </div>
          </div>

          <div class="box box-primary collapsed-box"">
            <div class="box-header with-border clickable" data-widget="collapse">
              <h3 class="box-title">退会する</h3>
            </div>
            <div class="box-body">
              <button type="button" class="btn btn-warning btn-block" onclick="delUser();">退会する</button>
            </div>
          </div>
        </div>

      </div>
    </section>
    <!-- ///////////////////////////////////////////////////// -->
  </div>
  <!-- Main content end -->

  {include file='common/footer.tpl'}

</div>
<!-- ./wrapper -->

<!-- JS start -->
{include file='common/adminlte_js.tpl'}
{include file='common/common_js.tpl'}
<script src="/js/user.js"></script>
<script src="/js/lib/cropper.js"></script>
<script>
$(function(){
	// 初期設定
	var options = {
		aspectRatio: 1 / 1,
		viewMode: 1,
		crop: function(e) {
			cropData = $('#select-image').cropper("getData");
			$("#upload-image-x").val(Math.floor(cropData.x));
			$("#upload-image-y").val(Math.floor(cropData.y));
			$("#upload-image-w").val(Math.floor(cropData.width));
			$("#upload-image-h").val(Math.floor(cropData.height));
		},
		zoomable: true,
		minCropBoxWidth: 100,
		minCropBoxHeight: 100
	}

	// 初期設定をセットする
	$('#select-image').cropper(options);
	$("#input-user_image").change(function(){
		// ファイル選択変更時に、選択した画像をCropperに設定する
		$('#select-image').cropper('replace', URL.createObjectURL(this.files[0]));
	});
});
</script>
<!-- JS end -->
</body>
</html>
