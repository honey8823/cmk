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

    <!-- Main content -->
    <section class="content">
      <div class="row">

        <div class="col-md-12">
          <div class="box">
            <div class="box-header">
              <h3 class="box-title">基本情報</h3>
            </div>
            <div class="box-body" id="area-setCharacter">
              <input type="hidden" class="form-id" value="{$character.id}">
              <div>
                <label>キャラクター名</label>
                <span class="menu-tooltip">
                  <i class="fa fa-question-circle fa-fw" aria-hidden="true"></i>
                  <span class="menu-tooltiptext">{$config.tooltip.character_name}</span>
                </span>
                <input type="text" name="name" class="form-name" value="{$character.name}">
              </div>
              <div>
                <label>属するステージ（複数選択可）</label>
              {foreach from=$stage_list key=k item=v_stage}
              {if isset($character.stage_list) && is_array($character.stage_list) && in_array($v_stage.id, array_column($character.stage_list, 'id'))}
                <span class="badge stage stage-selectable" value="{$v_stage.id}">{$v_stage.name}</span>
              {else}
                <span class="badge stage stage-notselected stage-selectable" value="{$v_stage.id}">{$v_stage.name}</span>
              {/if}
              {/foreach}
              </div>
            </div>
<!--
            <div class="box-body">
              <button type="button" class="btn btn-primary{if $character.is_private != 1} hidden{else}{/if}" onclick="setCharacterIsPrivate(0);">公開する<small>(現在非公開です)</small></button>
              <button type="button" class="btn btn-primary{if $character.is_private == 1} hidden{else}{/if}" onclick="setCharacterIsPrivate(1);">非公開にする<small>(現在公開中です)</small></button>
            </div>
-->
            <div class="box-body button-layout-right">
              <button type="button" class="btn btn-warning" onclick="delCharacter()">このキャラクターを削除</button>
              <button type="button" class="btn btn-primary" onclick="setCharacter();">更新する</button>
            </div>
          </div>
        </div>

        <div class="col-md-12">
          <div class="nav-tabs-custom">
            <ul class="nav nav-tabs">
              <li class="active"><a href="#tab-content-profile" data-toggle="tab" aria-expanded="true">基本プロフィール</a></li>
              <li class=""><a href="#tab-content-timeline" data-toggle="tab" aria-expanded="false">タイムライン</a></li>
{***
              <li class=""><a href="#tab-content-stage" data-toggle="tab" aria-expanded="false">ステージ</a></li>
***}
            </ul>
            <div class="tab-content">
              <div class="tab-pane active" id="tab-content-profile">
{***
                <button type="button" class="btn btn-primary pull-right">このキャラクターにエピソードを追加する</button>
***}
                <ul>

                  <li class="character_profile_edit /*template-for-copy*/" style="display:inline-flex">
                    <select>
                      <option value="0" selected>--選択してください--</option>
                      <option value="1">本名・フルネームなど</option>
                      <option value="2">生年月日</option>
                      <option value="3">性別</option>
                      <option value="3">…とかいう</option>
                      <option value="3">項目って</option>
                      <option value="3">無限にあるよね</option>
                    </select>
                    <input type="text">
                    <a href="">削除</a>
                  </li>

                  <li class="character_profile_edit /*template-for-copy*/" style="display:inline-flex">
                    <select>
                      <option value="0" selected>--選択してください--</option>
                      <option value="1">本名・フルネームなど</option>
                      <option value="2">生年月日</option>
                      <option value="3">性別</option>
                      <option value="3">…とかいう</option>
                      <option value="3">項目って</option>
                      <option value="3">無限にあるよね</option>
                    </select>
                    <input type="text">
                    <a href="">削除</a>
                  </li>

                  <li class="character_profile_edit /*template-for-copy*/" style="display:inline-flex">
                    <select>
                      <option value="0" selected>--選択してください--</option>
                      <option value="1">本名・フルネームなど</option>
                      <option value="2">生年月日</option>
                      <option value="3">性別</option>
                      <option value="3">…とかいう</option>
                      <option value="3">項目って</option>
                      <option value="3">無限にあるよね</option>
                    </select>
                    <input type="text">
                    <a href="">削除</a>
                  </li>

                  <div><a href="">もっとふやす</a></div>
                </ul>
              </div>
              <div class="tab-pane" id="tab-content-timeline">
{***
                <button type="button" class="btn btn-primary pull-right">このキャラクターにエピソードを追加する</button>
***}
                <ul class="timeline template-for-copy" id="timeline_for_stage_template">
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
                </ul>
                <ul class="timeline timeline-sort-area timeline-stage" id="timeline_for_stage">
                </ul>
              </div>
{***
              <div class="tab-pane" id="tab-content-stage">
                <button type="button" class="btn btn-primary pull-right">このキャラクターにエピソードを追加する</button>
                <ul>
                {foreach from=$character.stage_list key=k item=v_stage}
                  <li><a href="/user/stage/edit.php?id={$v_stage.id}">{$v_stage.name}</a></li>
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
<script src="/js/character.js"></script>
<script src="/js/episode.js"></script>
<script>
// 読み込み完了時の処理
$(function(){
	// データ読み込み
	var param = {
		stage_id     : "",
        character_id : {$character.id},
	}
	timeline(param);
});
</script>
<!-- JS end -->
</body>
</html>