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
      <h1>{$stage.name|escape:'html'}</h1>
      <small><a href="/public/user/detail.php?u={$stage.user_login_id}">by {$stage.user_name|escape:'html'}@{$stage.user_login_id}</a></small>
      <ol class="breadcrumb">
        <li><a href="/">トップ</a></li>
        <li><a href="/public/user/detail.php?u={$stage.user_login_id}">{if $stage.user_name != ""}{$stage.user_name|escape:'html'}{else} - {/if}さんのステージ</a></li>
        <li class="active">「{$stage.name|escape:'html'}」</li>
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
            <div class="box-header with-border">
              <h3 class="box-title">基本情報</h3>
              <div class="pull-right">
              {if $is_login == "1"}
                <i class="fa fa-fw fa-heart-o is_favorite_icon clickable is_favorite_0 {if $is_favorite == "1"}hidden{/if}" aria-hidden="true" data-favorite_type_key="stage" data-id="{$stage.id}"></i>
                <i class="fa fa-fw fa-heart is_favorite_icon clickable is_favorite_1 {if $is_favorite != "1"}hidden{/if}" aria-hidden="true" data-favorite_type_key="stage" data-id="{$stage.id}"></i>
              {/if}
              </div>
            </div>
          {if isset($stage.tag_list) && is_array($stage.tag_list)}
            <div class="box-body">
              <div class="detail-tag">
              {foreach from=$stage.tag_list key=k item=v_tag}
                <span class="label tag-base tag-{$v_tag.category_key}" value="{$v_tag.id}">{$v_tag.name|escape:'html'}</span>
              {/foreach}
              </div>
            </div>
          {/if}
            <div class="box-body public-stage-remarks">
            {if $stage.remarks != ""}
              {$stage.remarks|escape:'html'|nl2br}
            {else}
              (説明文は登録されていません)
            {/if}
            </div>
            <div class="public-info-box text-align-right" style="padding: 1em;">
              <p>登録日：{strtotime($stage.create_stamp)|date_format:"%Y-%m-%d %H:%M"}</p>
            </div>
          </div>
        </div>

        <div class="col-md-12">
          <div class="nav-tabs-custom">
            <ul class="nav nav-tabs">
              <li class="active"><a href="#tab-content-timeline" data-toggle="tab" aria-expanded="true">タイムライン</a></li>
              <li class=""><a href="#tab-content-character" data-toggle="tab" aria-expanded="false">キャラクター</a></li>
            </ul>
            <div class="tab-content">

              <div class="tab-pane active" id="tab-content-timeline">
              {if count($stage.episode_list) == 0}
                <p class="hint-box">まだ公開されているエピソードがありません。</p>
              {else}
                <ul class="timeline timeline-stage">
                {foreach from=$stage.episode_list key=k item=v_episode}
                {if $v_episode.type_key == "label"}
                  <li class="time-label timeline-label"><span class="bg-red timeline-title">{$v_episode.title}</span></li>
                {else}
                  <li class="timeline-content">
                  {if $v_episode.type_key == "common"}<i class="fa fa-book bg-green"></i>{/if}
                  {*{if $v_episode.type_key == ""}<i class="fa fa-users bg-orange"></i>{/if}*}
                  {if $v_episode.type_key == "override"}<i class="fa fa-user bg-yellow"></i>{/if}
                    <div class="timeline-item">
                      {if $v_episode.title != ""}<h3 class="timeline-header timeline-title no-border">{$v_episode.title|escape:'html'}</h3>{/if}
                    {if $v_episode.url != "" || $v_episode.free_text != ""}
                      <div class="timeline-body">
                        <small>
                        {if $v_episode.free_text != ""}
                          <p class="timeline-free_text">{$v_episode.free_text|escape:'html'|nl2br}</p>
                        {/if}
                        {if $v_episode.free_text_full != ""}
                          <p class="timeline-free_text_full hidden">{$v_episode.free_text_full|escape:'html'|nl2br}</p>
                          <div style="padding: 0.7em;">
                            <a class="timeline-free_text_show clickable"><i class="fa fa-fw fa-caret-right" aria-hidden="true"></i>クリックで全文を表示</a>
                            <a class="timeline-free_text_hide clickable hidden"><i class="fa fa-fw fa-caret-up" aria-hidden="true"></i>クリックで折り畳む</a>
                          </div>
                        {/if}
                        {if $v_episode.url != ""}
                          <p class="timeline-url"><a href="{$v_episode.url}" target="_blank"><i class="fa fa-fw fa-external-link" aria-hidden="true"></i> <span>{$v_episode.url_view|escape:'html'}</span></a></p>
                        {/if}
                        </small>
                      </div>
                    {/if}
                    {if $v_episode.type_key == "override"}
                      <div class="timeline-body">
                        <small>
                        {$is_link = false}
                        {if is_array($v_episode.character_id_list) && count($v_episode.character_id_list) > 0}
                        {foreach from=$stage.character_list key=k item=v_character}
                        {if in_array($v_character.id, $v_episode.character_id_list)}
                          {$is_link = true}
                          <p><a href="/public/character/override.php?user={$stage.user_login_id}&id={$v_character.id}&s={$stage.id}&e={$v_episode.id}">
                            <i class="fa fa-fw fa-user" aria-hidden="true"></i>
                            この時点の「{$v_character.name|escape:'html'}」のプロフィール
                          </a></p>
                        {/if}
                        {/foreach}
                        {/if}
                        {if $is_link == false}
                          <p>[未設定]</p>
                        {/if}
                        </small>
                      </div>
                    {/if}
                    </div>
                  </li>
                {/if}
                {/foreach}
                </ul>
              {/if}
              </div>

              <div class="tab-pane" id="tab-content-character">
                <div class="box-body no-padding">
                {if count($stage.character_list) == 0}
                  <p class="hint-box">まだ公開されているキャラクターがいません。</p>
                {else}
                  <ul class="nav nav-stacked ul-character">
                  {foreach from=$stage.character_list key=k item=v_character}
                    <li class="character_list" data-id="{$v_character.id}">
                      {* <a href="/public/character/detail.php?user={$stage.user_login_id}&id={$v_character.id}" class="character_id"> *}
                      <a href="/public/character/override.php?user={$stage.user_login_id}&id={$v_character.id}&s={$stage.id}" class="character_id">
                        <span class="character_name">{$v_character.name|escape:'html'}</span>
                      </a>
                    </li>
                  {/foreach}
                  </ul>
                {/if}
                </div>
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
