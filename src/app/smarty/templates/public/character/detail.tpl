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
    {if isset($character.tag_list) && is_array($character.tag_list)}
      <div class="detail-tag">
      {foreach from=$character.tag_list key=k item=v_tag}
        <span class="label tag tag-series" value="{$v_tag.id}">{$v_tag.name}</span>
      {/foreach}
      </div>
    {/if}
      <h1>{$character.name|escape:'html'}</h1>
      <ol class="breadcrumb">
        <li><a href="/">トップ</a></li>
        <li><a href="/public/user/detail.php?u={$character.user_login_id}">{if $character.user_name != ""}{$character.user_name|escape:'html'} {/if}@{$character.user_login_id}さんのキャラクター</a></li>
        <li class="active">「{$character.name|escape:'html'}」</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="row">

        <div class="col-md-12">
          <div class="box box-no-border">
            <div class="box-body">
            <div class="row">
              <div class="col-sm-2">
              {if !isset($character.image) || $character.image == ""}
                <img src="/img/icon_noimage.png" class="img-rounded character-image-view">
              {else}
                <img src="data:image/png;base64,{$character.image}" class="img-rounded character-image-view">
              {/if}
              </div>
              <div class="col-sm-10">
              {if $character.remarks != ""}
                <div>{$character.remarks|escape:'html'|nl2br}</div>
              {/if}
              </div>
            </div>
            {if $is_login == "1"}
              <div class="text-align-right">
                <i class="fa fa-fw fa-heart-o is_favorite_icon clickable is_favorite_0 {if $is_favorite == "1"}hidden{/if}" aria-hidden="true" data-favorite_type_key="character" data-id="{$character.id}"></i>
                <i class="fa fa-fw fa-heart is_favorite_icon clickable is_favorite_1 {if $is_favorite != "1"}hidden{/if}" aria-hidden="true" data-favorite_type_key="character" data-id="{$character.id}"></i>
              </div>
            {else}
              <p class="hint-box">ログインするとお気に入り機能がご利用いただけます。</p>
            {/if}
            </div>
          </div>
        </div>

        <div class="col-md-12">
          <div class="nav-tabs-custom">
            <ul class="nav nav-tabs">
              <li class="active"><a href="#tab-content-profile" data-toggle="tab" aria-expanded="false">プロフィール</a></li>
              <li class=""><a href="#tab-content-timeline" data-toggle="tab" aria-expanded="true">タイムライン</a></li>
            </ul>
            <div class="tab-content">

              <div class="tab-pane active" id="tab-content-profile">
              {if isset($character.profile_list) && is_array($character.profile_list) && count($character.profile_list) > 0}
                <ul class="nav nav-stacked ul-character_profile character_profile">
                {foreach from=$character.profile_list key=k item=v_profile}
                  <li class="li-character_profile" data-q="{$v_profile.question}">
                    <span class="view_mode">
                      <div class="character_profile_q">{$v_profile.question_title}</div>
                      <div class="character_profile_a">{$v_profile.answer|escape:'html'|nl2br}</div>
                    </span>
                  </li>
                {/foreach}
                </ul>
              {else}
                <p class="hint-box">まだ公開されているプロフィールがありません。</p>
              {/if}
              </div>

              <div class="tab-pane" id="tab-content-timeline">
              {if count($character.stage_list) > 0}
                <ul class="timeline">
                {foreach from=$character.stage_list key=k_stage item=v_stage}
                  <li class="time-label timeline-stage_name clickable">
                    <span class="bg-blue timeline-title">
                      <a href="/public/stage/detail.php?user={$character.user_login_id}&id={$v_stage.id}">
                        <span>{$v_stage.name|escape:'html'}</span>
                      </a>
                    </span>
                  </li>
                {if isset($v_stage.episode_list) && is_array($v_stage.episode_list)}
                {foreach from=$v_stage.episode_list key=k_episode item=v_episode}
                {if $v_episode.type_key == "label"}
                  <li class="time-label timeline-label timeline-label_title">
                    <span class="bg-red timeline-title">
                      <span>{$v_episode.title|escape:'html'}</span>
                    </span>
                  </li>
                {else}
                  <li class="timeline-content" data-id="{$v_episode.id}">
                    {if $v_episode.type_key == "common"}<i class="fa fa-book bg-green"></i>{/if}
                    {*{if $v_episode.type_key == ""}<i class="fa fa-users bg-orange"></i>{/if}*}
                    {if $v_episode.type_key == "override"}<i class="fa fa-user bg-yellow"></i>{/if}
                    <div class="timeline-item">
                    {if $v_episode.title != ""}
                      <h3 class="timeline-header timeline-title no-border">{$v_episode.title|escape:'html'}</h3>
                    {/if}
                    {if $v_episode.free_text != "" || $v_episode.url != ""}
                      <div class="timeline-body">
                        <small>
                        {if $v_episode.free_text != ""}
                          <p class="timeline-free_text">{$v_episode.free_text|escape:'html'|nl2br}</p>
                        {/if}
                        {if $v_episode.url != ""}
                          <p class="timeline-url"><a href="{$v_episode.url}" target="_blank"><i class="fa fa-fw fa-external-link" aria-hidden="true"></i> <span>{$v_episode.url_view|escape:'html'}</span></a></p>
                        {/if}
                        </small>
                      </div>
                    {/if}
                    </div>
                  </li>
                {/if}
                {/foreach}
                {/if}
                {/foreach}
                </ul>
              {else}
                <p class="hint-box">まだ公開されているエピソードがありません。</p>
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
<script src="/js/timeline.js"></script>
<script src="/js/favorite.js"></script>
<!-- JS end -->
</body>
</html>
