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
      <h1>{$character.name|escape:'html'}</h1>
      <small><a href="/public/user/detail.php?u={$character.user_login_id}">by {$character.user_name|escape:'html'}@{$character.user_login_id}</a></small>
      <ol class="breadcrumb">
        <li><a href="/">トップ</a></li>
        <li><a href="/public/user/detail.php?u={$character.user_login_id}">{if $character.user_name != ""}{$character.user_name|escape:'html'}{else} - {/if}さん</a></li>
        <li><a href="/public/stage/detail.php?user={$character.user_login_id}&id={$stage.id}">「{$stage.name|escape:'html'}」</a></li>
        <li class="active">「{$character.name|escape:'html'}」</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="row">

        <div class="col-md-12">
          <div class="box">
            <div class="box-header with-border">
              <h3 class="box-title">「{$stage.name|escape:'html'}」の「{$character.name|escape:'html'}」</h3>
            </div>
{*
          {if $character.remarks != ""}
            <div class="box-body public-character-remarks">
              {$character.remarks|escape:'html'|nl2br}
            </div>
          {/if}
*}
            <div class="box-body text-align-right">
              <p><a href="/public/stage/detail.php?user={$character.user_login_id}&id={$stage.id}">ステージ「{$stage.name|escape:'html'}」のタイムラインを見る</a></p>
              <p><a href="/public/character/detail.php?user={$character.user_login_id}&id={$character.id}">キャラクター「{$character.name|escape:'html'}」の基本プロフィールを見る</a></p>
            </div>
          </div>
        </div>

        <div class="col-md-12">
          <div class="nav-tabs-custom">
            <ul class="nav nav-tabs">
              <li class="active"><a href="#tab-content-profile" data-toggle="tab" aria-expanded="false">プロフィール</a></li>
{*
              <li class=""><a href="#tab-content-etc" data-toggle="tab" aria-expanded="true">お題機能？</a></li>
*}
            </ul>

            <div class="tab-content">

              <div class="tab-pane active" id="tab-content-profile">
                <ul class="nav nav-stacked ul-character_profile character_profile">
                {foreach from=$profile_list key=k item=v_profile}
                  <li class="li-character_profile public" data-q="{$v_profile.question}">
                    <span class="view_mode">
                      <div class="character_profile_q">{$v_profile.question_title}</div>
                      <div class="character_profile_a">{$v_profile.answer|escape:'html'|nl2br}</div>
                    </span>
                  </li>
                {/foreach}
                </ul>
              </div>
{*
              <div class="tab-pane" id="tab-content-etc">
              </div>
*}
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
<script src="/js/timeline.js"></script>
<!-- JS end -->
</body>
</html>