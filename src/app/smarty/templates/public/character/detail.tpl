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
        <li><a href="/public/user/detail.php?u={$character.user_login_id}">{if $character.user_name != ""}{$character.user_name|escape:'html'}{else} - {/if}さんのキャラクター</a></li>
        <li class="active">「{$character.name|escape:'html'}」</li>
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
            <div class="box-body">
              <div class="text-align-right">
              {if $is_login == "1"}
                <i class="fa fa-fw fa-heart-o is_favorite_icon clickable is_favorite_0 {if $is_favorite == "1"}hidden{/if}" aria-hidden="true" data-favorite_type_key="character" data-id="{$character.id}"></i>
                <i class="fa fa-fw fa-heart is_favorite_icon clickable is_favorite_1 {if $is_favorite != "1"}hidden{/if}" aria-hidden="true" data-favorite_type_key="character" data-id="{$character.id}"></i>
              {/if}
              </div>
              <div class="detail-tag">
              {foreach from=$character.tag_list key=k item=v_tag}
                <span class="label tag-base tag-series" value="{$v_tag.id}">{$v_tag.name}</span>
              {/foreach}
              </div>
            </div>
          {if $character.remarks != ""}
            <div class="box-body public-character-remarks">
              {$character.remarks|escape:'html'|nl2br}
            </div>
          {/if}
            <div class="public-info-box text-align-right" style="padding: 1em;">
              <p>登録日：{strtotime($character.create_stamp)|date_format:"%Y-%m-%d %H:%M"}</p>
            </div>
          </div>
        </div>

        <div class="col-md-12">
          <div class="nav-tabs-custom">
            <ul class="nav nav-tabs">
              <li class="active"><a href="#tab-content-timeline" data-toggle="tab" aria-expanded="true">タイムライン</a></li>
{***
              <li class=""><a href="#tab-content-character" data-toggle="tab" aria-expanded="false">ステージ</a></li>
***}
            </ul>
            <div class="tab-content">

              <div class="tab-pane active" id="tab-content-timeline">
                <ul class="timeline">
                {foreach from=$character.stage_list key=k_stage item=v_stage}
                  <li class="time-label timeline-stage_name clickable" onclick="location.href='/public/stage/detail.php?user={$character.user_login_id}&id={$v_stage.id}';">
                    <span class="bg-blue timeline-title">
                      <span>{$v_stage.name|escape:'html'}</span>
                    </span>
                  </li>
                {if isset($v_stage.episode_list) && is_array($v_stage.episode_list)}
                {foreach from=$v_stage.episode_list key=k_episode item=v_episode}
                {if $v_episode.is_label == 1}
                  <li class="time-label timeline-label timeline-label_title">
                    <span class="bg-red timeline-title">
                      <span>{$v_episode.title|escape:'html'}</span>
                    </span>
                  </li>
                {else}
                  <li class="timeline-content" data-id="{$v_episode.id}">
                    {if $v_episode.category == "1"}<i class="fa fa-book bg-green"></i>{/if}
                    {if $v_episode.category == "2"}<i class="fa fa-users bg-orange"></i>{/if}
                    {if $v_episode.category == "3"}<i class="fa fa-user bg-yellow"></i>{/if}
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
                          <p class="timeline-url"><a href="{$v_episode.url}" target="_blank">{$v_episode.url_view|escape:'html'}</a></p>
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
              </div>
{***
              <div class="tab-pane" id="tab-content-character">
                <ul>
                {foreach from=$character.stage_list key=k item=v_stage}
                  <li><a href="/public/stage/detail.php?user={$character.user_login_id}&id={$v_stage.id}">{$v_stage.name|escape:'html'}</a></li>
                {/foreach}
                </ul>
              </div>
***}
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
<script src="/js/common.js"></script>
<script src="/js/sidebar.js"></script>
<script src="/js/episode.js"></script>
<script src="/js/favorite.js"></script>
<!-- JS end -->
</body>
</html>