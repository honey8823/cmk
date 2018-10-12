<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>{$smarty.const.SITE_NAME_FULL}</title>
  {include file='common/adminlte_css.tpl'}
  <link rel="stylesheet" href="/css/common.css">
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

        <div class="col-md-6">
          <div class="box">
            <div class="box-header">
              <h3 class="box-title">基本情報</h3>
            </div>
            <div class="box-body">
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
              {foreach from=$stage_list key=k item=stage}
              {if isset($character.stage_list) && is_array($character.stage_list) && in_array($stage.id, array_column($character.stage_list, 'id'))}
                <span class="badge stage stage-selectable" value="{$stage.id}">{$stage.name}</span>
              {else}
                <span class="badge stage stage-notselected stage-selectable" value="{$stage.id}">{$stage.name}</span>
              {/if}
              {/foreach}
              </div>
            </div>

            <div class="box-body">
              <button type="button" class="btn btn-primary{if $character.is_private != 1} hidden{else}{/if}" onclick="setCharacterIsPrivate(0);">公開する<small>(現在非公開です)</small></button>
              <button type="button" class="btn btn-primary{if $character.is_private == 1} hidden{else}{/if}" onclick="setCharacterIsPrivate(1);">非公開にする<small>(現在公開中です)</small></button>
            </div>
            <div class="box-body">
              <button type="button" class="btn btn-warning pull-right">このキャラクターを削除</button>
              <button type="button" class="btn btn-primary pull-right" onclick="setCharacter();">更新する</button>
            </div>
          </div>
        </div>

        <div class="col-md-6">
          <div class="nav-tabs-custom">
            <ul class="nav nav-tabs">
              <li class="active"><a href="#tab-content-timeline" data-toggle="tab" aria-expanded="true">タイムライン</a></li>
              <li class=""><a href="#tab-content-stage" data-toggle="tab" aria-expanded="false">ステージ</a></li>
            </ul>
            <div class="tab-content">
              <div class="tab-pane active" id="tab-content-timeline">
                <ul>
                  <li>timeline1</li>
                  <li>timeline2</li>
                </ul>
              </div>
              <div class="tab-pane" id="tab-content-stage">
                <ul>
                  <li>stage1</li>
                  <li>stage2</li>
                </ul>
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
<script src="/js/common.js"></script>
<script src="/js/sidebar.js"></script>
<script src="/js/character.js"></script>
<!-- JS end -->
</body>
</html>