<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>{$smarty.const.SITE_NAME_FULL}</title>
  {include file='common/adminlte_css.tpl'}
  {include file='common/common_public_css.tpl'}
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
      <h1>ユーザー</h1>
      <ol class="breadcrumb">
        <li><a href="/">トップ</a></li>
        <li class="active">ユーザー</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="row">
        <div class="col-md-12">
          <div class="box-body">
            （ジャンルでの絞り込み機能を実装予定です）
          </div>
        {if count($user_list) > 0}
          <div class="box box-no-border">
            <div class="box-body no-padding">
              <ul class="nav nav-stacked">
              {foreach from=$user_list key=k_user item=v_user}
                <li>
                  <a href="/public/user/detail.php?u={$v_user.login_id}">
                    <div class="row">
                      <div class="col-sm-5">
                      {if !isset($v_user.image) || $v_user.image == ""}
                        <img src="/img/icon_noimage.png" class="img-circle user-image-list">
                      {else}
                        <img src="data:image/png;base64,{$v_user.image}" class="img-circle user-image-list">
                      {/if}
                        <span>{if $v_user.name != ""}{$v_user.name|escape:'html'}{else}（ユーザー名未設定）{/if}</span>
                      </div>
                      <div class="col-sm-7">
                        {if isset($v_user.genre_list) && is_array($v_user.genre_list)}
                        {foreach from=$v_user.genre_list key=k_genre item=v_genre}
                          <span class="label-genre" value="{$v_genre.id}">{$v_genre.title}</span>
                        {/foreach}
                        {/if}
                      </div>
                    </div>
                  </a>
                </li>
              {/foreach}
              </ul>
            </div>
          </div>
        {/if}
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
<!-- JS end -->
</body>
</html>
