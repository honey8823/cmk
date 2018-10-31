<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>{$smarty.const.SITE_NAME_FULL}</title>
  {include file='common/adminlte_css.tpl'}
  {include file='common/common_css.tpl'}
</head>

<body class="hold-transition skin-blue sidebar-mini">
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
          <div class="box">
            <div class="box-header">
              <h3 class="box-title">基本情報</h3>
            </div>
            <div class="box-body" id="area-setUser">
              <input type="hidden" class="form-id" value="{$user.id}">

              <div class="form-group">
                <label>ログインID（公開 / 必須）</label>
                <input type="text" name="login_id" class="form-control form-login_id" value="{$user.login_id}">
              </div>
              <div class="form-group">
                <label>ユーザー名（公開）</label>
                <input type="text" name="mail_name" class="form-control form-name" value="{$user.name}">
              </div>
              <div class="form-group">
                <label>ジャンル設定</label>
                <div>
                {foreach from=$genre_list key=k item=v_genre}
                {if isset($user.genre_list) && is_array($user.genre_list) && in_array($v_genre.id, array_column($user.genre_list, 'genre_id'))}
                  <span class="label tag-base tag-genre tag-selectable clickable" value="{$v_genre.id}">{$v_genre.title}</span>
                {else}
                  <span class="label tag-base tag-genre tag-selectable clickable tag-notselected" value="{$v_genre.id}">{$v_genre.title}</span>
                {/if}
                {/foreach}
                </div>
              </div>
              <div class="form-group">
                <div class="checkbox">
                  <label>
                    <input type="checkbox" name="is_r18" class="form-is_r18"{if $user.is_r18 == "1"} checked{/if}>
                    R18設定のコンテンツ表示を許可する
                  </label>
                </div>
              </div>
              <div class="form-group">
                <label>Twitter ID（公開）</label>
                <input type="text" name="mail_address" class="form-control form-twitter_id" value="{$user.twitter_id}">
              </div>
              <div class="form-group">
                <label>メールアドレス（非公開）</label>
                <span class="menu-tooltip">
                  <i class="fa fa-question-circle fa-fw" aria-hidden="true"></i>
                  <span class="menu-tooltiptext">{$config.tooltip.mail_address}</span>
                </span>
                <input type="text" name="mail_address" class="form-control form-mail_address" value="{$user.mail_address}">
              </div>
              <div class="form-group">
                <label>パスワード（非公開 / 変更する場合のみ）</label>
                <input type="password" name="password" class="form-control form-password">
              </div>
              <div class="form-group">
                <label>パスワード（非公開 / 変更する場合のみもう一度）</label>
                <input type="password" name="password_c" class="form-control form-password_c">
              </div>
            </div>
            <div class="box-body button-layout-right">
              <button type="button" class="btn btn-primary" onclick="setUser();">更新する</button>
            </div>
          </div>
        </div>

        <div class="col-md-12">
          <div class="box">
            <div class="box-header">
              <h3 class="box-title">このアカウントに対する操作</h3>
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
<script src="/js/lib/jquery.ui.touch-punch.min.js"></script>
<script src="/js/common.js"></script>
<script src="/js/sidebar.js"></script>
<script src="/js/user.js"></script>
<!-- JS end -->
</body>
</html>