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
            </div>
            <div class="box-body button-layout-right">
              <button type="button" class="btn btn-primary" onclick="setCharacter();">更新する</button>
            </div>
          </div>
        </div>

        <div class="col-md-12">
          <div class="box">
            <div class="box-header">
              <h3 class="box-title">このステージに対する操作</h3>
            </div>
            <div class="box-body">
{***
              <button type="button" class="btn btn-primary btn-block{if $stage.is_private == 1} hidden{/if}" onclick="window.open('/public/stage/detail.php?user={$stage.login_id}&id={$stage.id}');">公開用ページを見る</button>
***}
              <button type="button" class="btn btn-primary btn-block{if $character.is_private != 1} hidden{/if}" onclick="setCharacterIsPrivate(0);">公開する<small>(現在非公開です)</small></button>
              <button type="button" class="btn btn-primary btn-block{if $character.is_private == 1} hidden{/if}" onclick="setCharacterIsPrivate(1);">非公開にする<small>(現在公開中です)</small></button>
              <button type="button" class="btn btn-warning btn-block" onclick="delCharacter();">削除する</button>
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