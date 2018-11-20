<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>{$smarty.const.SITE_NAME_FULL}</title>
  {include file='common/adminlte_css.tpl'}
  {include file='common/common_css.tpl'}
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
      <h1>{$user.name|escape:'html'}<small>@{$user.login_id}</small></h1>
      <ol class="breadcrumb">
        <li><a href="/">トップ</a></li>
        <li class="active">{if $user.name != ""}{$user.name|escape:'html'}{else} - {/if}さん</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="row">

        <div class="col-md-12">
        {if $is_login != "1"}
          <p class="hint-box">ログインするとお気に入り機能がご利用いただけます。</p>
        {/if}
          <div class="box">
            <div class="box-body public-user-panel">
              <div class="text-align-right">
              {if $is_login == "1"}
                <i class="fa fa-fw fa-heart-o is_favorite_icon clickable is_favorite_0 {if $is_favorite == "1"}hidden{/if}" aria-hidden="true" data-favorite_type_key="user" data-id="{$user.id}"></i>
                <i class="fa fa-fw fa-heart is_favorite_icon clickable is_favorite_1 {if $is_favorite != "1"}hidden{/if}" aria-hidden="true" data-favorite_type_key="user" data-id="{$user.id}"></i>
              {/if}
              </div>
              <div class="col-md-2 text-align-center">
                <img src="/img/icon_noimage.png" class="img-circle img-user" alt="User Image">
              </div>
              <div class="col-md-10">
                <div>
                  <h4>{if $user.name != ""}{$user.name|escape:'html'}{else}(ユーザー名未設定){/if}</h4>
                </div>
                <div>
                {foreach from=$genre_list key=k item=v_genre}
                  <span class="label tag-base tag-genre" value="{$v_genre.id}">{$v_genre.title}</span>
                {/foreach}
                </div>
                <div class="public-user-remarks">
                  {if $user.remarks != ""}{$user.remarks|escape:'html'|nl2br}{else}(コメント未設定){/if}
                </div>
                <div>
                  <label>Twitter</label>
                {if $user.twitter_id != ""}
                  <span><a href="//twitter.com/{$user.twitter_id}" target="_blank">@{$user.twitter_id}</a></span>
                {else}
                  <span>-</span>
                {/if}
                </div>
                <div>
                  <label>Pixiv</label>
                {if $user.pixiv_id != ""}
                  <span><a href="//pixiv.me/{$user.pixiv_id}" target="_blank">@{$user.pixiv_id}</a></span>
                {else}
                  <span>-</span>
                {/if}
                </div>
              </div>
            </div>
          </div>
        </div>

        <div class="col-md-12">
          <div class="nav-tabs-custom">
            <ul class="nav nav-tabs">
              <li class="active"><a href="#tab-content-stage" data-toggle="tab" aria-expanded="true">ステージ</a></li>
              <li class=""><a href="#tab-content-character" data-toggle="tab" aria-expanded="false">キャラクター</a></li>
            </ul>
            <div class="tab-content">
              <div class="tab-pane active" id="tab-content-stage">
              {if count($stage_list) == 0}
                <p class="hint-box">まだ公開されているステージがありません。</p>
              {else}
                <ul class="nav nav-stacked stage_list">
                {foreach from=$stage_list key=k item=v_stage}
                  <li>
                    <a href="/public/stage/detail.php?user={$user.login_id}&id={$v_stage.id}">
                      <span class="name">{$v_stage.name|escape:'html'}</span>
                      <span class="tag">
                      {foreach from=$v_stage.tag_list key=k item=v_tag}
                        <span class="label tag-base tag-{$v_tag.category_key}">{$v_tag.name_short|escape:'html'}</span>
                      {/foreach}
                      </span>
                    </a>
                  </li>
                {/foreach}
                </ul>
              {/if}
              </div>
              <div class="tab-pane" id="tab-content-character">
              {if count($stage_list) == 0}
                <p class="hint-box">まだ公開されているキャラクターがいません。</p>
              {else}
                <ul class="nav nav-stacked character_list">
                {foreach from=$character_list key=k item=v_character}
                  <li>
                    <a href="/public/character/detail.php?user={$user.login_id}&id={$v_character.id}">{$v_character.name|escape:'html'}</a>
                  </li>
                {/foreach}
                </ul>
              {/if}
              </div>
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
<script src="/js/favorite.js"></script>
<!-- JS end -->
</body>
</html>
