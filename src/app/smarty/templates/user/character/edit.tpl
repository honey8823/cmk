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
      <!-- <h1>キャラクター管理</h1> -->
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
                <input type="text" name="name" class="form-name">
              </div>
              <div>
                <label>登場シリーズ（複数選択可）</label>
              {foreach from=$series_list key=k item=series}
                <span class="label tag-base tag-series tag-notselected tag-selectable" value="{$series.id}">{$series.name}</span>
              {/foreach}
              </div>
              <div>
                <label>非公開にする</label>
                <span class="menu-tooltip">
                  <i class="fa fa-question-circle fa-fw" aria-hidden="true"></i>
                  <span class="menu-tooltiptext">{$config.tooltip.is_private}</span>
                </span>
                <input type="checkbox" name="is_private" class="form-is_private" checked>
              </div>
            </div>
            <div class="box-body">
              <button type="button" class="btn btn-primary">更新する</button>
              <button type="button" class="btn btn-warning pull-right">このキャラクターを削除</button>
            </div>
          </div>
        </div>

        <div class="col-md-6">
          <div class="nav-tabs-custom">
            <div class="box">
              <div class="box-header">
                <h3 class="box-title">ステージ</h3>
                <span class="menu-tooltip">
                  <i class="fa fa-question-circle fa-fw" aria-hidden="true"></i>
                  <span class="menu-tooltiptext">{$config.tooltip.stage}</span>
                </span>
              </div>
            </div>
            <ul class="nav nav-tabs">
              <li class="active"><a href="#c1" data-toggle="tab" aria-expanded="true">A</a></li>
              <li class=""><a href="#c2" data-toggle="tab" aria-expanded="false">B</a></li>
              <li class=""><a href="#c3" data-toggle="tab" aria-expanded="false">C</a></li>
              <li class=""><a href="#" onclick=""><i class="fa fa-plus-circle" aria-hidden="true"></i></a></li>
            </ul>
            <div class="tab-content">
              <div class="tab-pane active" id="c1">
                c1
              </div>
              <div class="tab-pane" id="c2">
                c2
              </div>
              <div class="tab-pane" id="c3">
                c3
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