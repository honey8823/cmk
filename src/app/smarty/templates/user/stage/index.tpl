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
      <h1>ステージ管理</h1>
      <ol class="breadcrumb">
        <li><a href="/">トップ</a></li>
        <li class="active">ステージ管理</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="row">
        <div class="col-md-6">
          <div class="box-body">
            <div class="pull-right">
              <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#modal-addStage">ステージを追加</button>
            </div>
            <div>
              <small>
                <!-- ※使い方やガイドラインなど、総合ヘルプはこちら -->
              </small>
            </div>
          </div>
          <div id="list-stage" class="box">
            <div class="box-body no-padding">

              <ul class="ul-stage sortable">
                <li class="stage_list template-for-copy" data-id="">
                  <span class="is_private"><span class="stage_is_private_0"><i class="fa fa-unlock fa-fw"></i></span><span class="stage_is_private_1"><i class="fa fa-lock fa-fw"></i></span></span>
                  <span class="name"><a href="/user/stage/edit.php?" class="stage_id"><span class="stage_name"></span></a></span>
                  <span class="tag"><span class="template-for-copy label tag-base"></span></span>
                </li>
              </ul>

            </div>
          </div>
        </div>
      </div>
    </section>
    <!-- ///////////////////////////////////////////////////// -->
  </div>
  <!-- Main content end -->

  <!-- ステージ登録modal -->
  <div class="modal fade" id="modal-addStage">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span></button>
          <h4 class="modal-title">ステージ登録</h4>
{***          <small>登録直後は非公開設定になっています。編集後に公開するようにしてください。</small>***}
        </div>
        <div class="modal-body">
          <div>
            <label>ステージ名</label><small>※必須</small>
            <input type="text" name="name" class="form-name">
          </div>
          <div>
            <label>説明文</label>
            <span class="menu-tooltip">
              <i class="fa fa-question-circle fa-fw" aria-hidden="true"></i>
              <span class="menu-tooltiptext">{$config.tooltip.stage_remarks}</span>
            </span>
            <textarea class="form-control form-remarks" rows="3" name="remarks"></textarea>
          </div>
          <div>
            <label>関連するシリーズ（複数選択可）</label>
          {foreach from=$series_list key=k item=v_series}
            <span class="label tag-base tag-series tag-notselected tag-selectable" value="{$v_series.id}">{$v_series.name}</span>
          {/foreach}
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default pull-left" data-dismiss="modal">キャンセル</button>
          <button type="button" class="btn btn-primary" onclick="addStage();">登録</button>
        </div>
      </div>
    </div>
  </div>

  {include file='common/footer.tpl'}

</div>
<!-- ./wrapper -->

<!-- JS start -->
{include file='common/adminlte_js.tpl'}
<script src="/js/lib/jquery.ui.touch-punch.min.js"></script>
<script src="/js/common.js"></script>
<script src="/js/sidebar.js"></script>
<script src="/js/stage.js"></script>
<script>
// 読み込み完了時の処理
$(function(){
	// データ読み込み
	tableStage();
});
</script>
<!-- JS end -->
</body>
</html>