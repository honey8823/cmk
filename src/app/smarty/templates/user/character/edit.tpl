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
      <h1>キャラクター管理</h1>
      <ol class="breadcrumb">
        <li><a href="/">トップ</a></li>
        <li><a href="/user/character/">キャラクター管理</a></li>
        <li class="active">編集</li>
      </ol>
    </section>

<p class="hint-box">
  UIを大きく変更しました。<br>
  編集や削除を行いたい場合は「内容を編集する」をクリックしてください。<br>
  キャラクターの公開/非公開を切り替えたいときはタイトル横の鍵マークをクリックしてください。<br>
  （鍵が閉まっている黄色いアイコンは「非公開」、鍵が開いているグレーのアイコンは「公開」を表します）<br>
  {* 公開状態の場合のみ「公開用ページを見る」のリンク先は他人からも閲覧可能です。 *}
</p>

    <!-- Main content -->
    <section class="content">
      <div class="row">

        <div class="col-md-12">
          <div class="box">
            <div class="box-header">
              <h3 class="box-title">基本情報</h3>
            </div>
            <div class="box-body" id="area-viewCharacter">
              <div>
                <span class="is_private_icon is_private_{$character.is_private}" onclick="setCharacterIsPrivate({if $character.is_private == 1}0{else}1{/if});">
                  <i class="fa {if $character.is_private == 1}fa-lock{else}fa-unlock{/if} fa-fw"></i>
                </span>
                <span><big>{$character.name|escape:'html'}</big></span>
              </div>
              <div class="private-character-stage">
                {foreach from=$stage_list key=k item=v_stage}
                {if isset($character.stage_list) && is_array($character.stage_list) && in_array($v_stage.id, array_column($character.stage_list, 'id'))}
                  <span class="badge stage" value="{$v_stage.id}">{$v_stage.name}</span>
                {/if}
                {/foreach}
              </div>
              <div class="private-character-remarks"><small>{$character.remarks|escape:'html'|nl2br}</small></div>
              <div class="box-body button-layout-right">
{***
              {if $character.is_private != 1}
                <button type="button" class="btn btn-primary" onclick="window.open('/public/character/detail.php?user={$stage.login_id}&id={$character.id}');">公開用ページを見る</button>
              {/if}
***}
                <button type="button" class="btn btn-primary" onclick="$('#area-viewCharacter').hide();$('#area-setCharacter').show();">内容を編集する</button>
              </div>
            </div>
            <div class="box-body" id="area-setCharacter" style="display:none;">
              <input type="hidden" class="form-id" value="{$character.id}">
              <div class="form-group">
                <label>キャラクター名</label>
                <span class="menu-tooltip">
                  <i class="fa fa-question-circle fa-fw" aria-hidden="true"></i>
                  <span class="menu-tooltiptext">{$config.tooltip.character_name}</span>
                </span>
                <input type="text" name="name" class="form-control form-name" value="{$character.name}">
              </div>
              <div class="form-group">
                <label>属するステージ（複数選択可）</label>
                <div>
                {foreach from=$stage_list key=k item=v_stage}
                {if isset($character.stage_list) && is_array($character.stage_list) && in_array($v_stage.id, array_column($character.stage_list, 'id'))}
                  <span class="badge stage stage-selectable" value="{$v_stage.id}">{$v_stage.name}</span>
                {else}
                  <span class="badge stage stage-notselected stage-selectable" value="{$v_stage.id}">{$v_stage.name}</span>
                {/if}
                {/foreach}
                </div>
              </div>
              <div class="form-group">
                <label>備考</label>
                <textarea name="remarks" class="form-control form-remarks">{$character.remarks}</textarea>
              </div>
              <div class="box-body button-layout-right">
                <button type="button" class="btn btn-default pull-left" onclick="$('#area-setCharacter').hide();$('#area-viewCharacter').show();">キャンセル</button>
                <button type="button" class="btn btn-warning" onclick="delCharacter();">削除する</button>
                <button type="button" class="btn btn-primary" onclick="setCharacter();">更新する</button>
              </div>
            </div>
          </div>
        </div>

        <div class="col-md-12">
          <div class="nav-tabs-custom">
            <ul class="nav nav-tabs">
              <li class="active"><a href="#tab-content-timeline" data-toggle="tab" aria-expanded="true">タイムライン</a></li>
<!--
              <li class=""><a href="#tab-content-stage" data-toggle="tab" aria-expanded="false">ステージ</a></li>
-->
            </ul>
            <div class="tab-content">
              <div class="tab-pane active" id="tab-content-timeline">
<!--
                <button type="button" class="btn btn-primary pull-right">このキャラクターにエピソードを追加する</button>
-->
                <ul class="timeline" id="timeline_for_stage_template">
                {foreach from=$timeline key=k_tl item=v_tl}
                  <li class="time-label timeline-stage_name" data-id="{$v_tl.id}">
                    <span class="{if $v_tl.is_private == 1}bg-gray{else}bg-blue{/if} timeline-title">
                      <span>{$v_tl.name}</span>
                    </span>
                  </li>
                {if isset($v_tl.episode_list) && is_array($v_tl.episode_list)}
                {foreach from=$v_tl.episode_list key=k_episode item=v_episode}
                {if $v_episode.is_label == 1}
                  <li class="time-label timeline-label timeline-label_title" data-id="{$v_episode.id}">
                    <span class="{if $v_episode.is_private == 1}bg-gray{else}bg-red{/if} timeline-title">
                      <span>{$v_episode.title}</span>
                    </span>
                  </li>
                {else}
                  <li class="timeline-content" data-id="{$v_episode.id}">
                    {if $v_episode.category == "1"}<i class="fa fa-book {if $v_episode.is_private == 1}bg-gray{else}bg-green{/if}"></i>{/if}
                    {if $v_episode.category == "2"}<i class="fa fa-users {if $v_episode.is_private == 1}bg-gray{else}bg-orange{/if}"></i>{/if}
                    {if $v_episode.category == "3"}<i class="fa fa-user {if $v_episode.is_private == 1}bg-gray{else}bg-yellow{/if}"></i>{/if}
                    <div class="timeline-item">
                    {if $v_episode.title != ""}
                      <h3 class="timeline-header timeline-title no-border">{$v_episode.title}</h3>
                    {/if}
                    {if $v_episode.free_text != "" || $v_episode.url != ""}
                      <div class="timeline-body">
                        <small>
                        {if $v_episode.free_text != ""}
                          <p class="timeline-free_text">{$v_episode.free_text|nl2br}</p>
                        {/if}
                        {if $v_episode.url != ""}
                          <p class="timeline-url"><a href="{$v_episode.url}" target="_blank">{$v_episode.url_view}</a></p>
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

{*** コピペ用
                  <li class="time-label timeline-editable timeline-label template-for-copy" data-id="" data-toggle="modal" data-target="#modal-setEpisode"><span class="bg-red timeline-title"></span></li>
                  <li class="timeline-content timeline-editable template-for-copy" data-id="" data-toggle="modal" data-target="#modal-setEpisode">
                    <i class="fa fa-arrow-right bg-blue"></i>
                    <div class="timeline-item">
                      <h3 class="timeline-header timeline-title no-border"></h3>
                      <div class="timeline-body">
                        <small>
                          <p class="timeline-free_text"></p>
                          <p class="timeline-url"><a href="" target="_blank"></a></p>
                        </small>
                      </div>
                    </div>
                  </li>
***}
                </ul>
              </div>
<!--
              <div class="tab-pane" id="tab-content-stage">
                <button type="button" class="btn btn-primary pull-right">このキャラクターにエピソードを追加する</button>
                <ul>
              {foreach from=$character.stage_list key=k item=v_stage}
                <li><a href="/user/stage/edit.php?id={$v_stage.id}">{$v_stage.name}</a></li>
              {/foreach}
                </ul>
              </div>
-->
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
<script src="/js/character.js"></script>
<script src="/js/episode.js"></script>
<!-- JS end -->
</body>
</html>