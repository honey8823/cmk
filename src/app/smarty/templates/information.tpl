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
      <h1>お知らせ</h1>
    </section>

    <!-- Main content -->
    <section class="content container-fluid">
      <div class="row" style="margin-top: 10px;">
        <div class="col-md-12" id="list-information">
          <div>

            <div class="box box-primary information_list template-for-copy">
              <div class="box-header"><h3 class="box-title information-date"></h3></div>
              <div class="box-body information-content"></div>
            </div>

          </div>
          <div class="box-body no-padding">
            <button type="button" class="btn btn-default btn-block btn-more disabled" onclick="tableInformation();">もっとみる</button>
            <input type="hidden" class="offset" value="0">
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
<script src="/js/information.js"></script>
<script>
// 読み込み完了時の処理
$(function(){
	// データ読み込み
	$("#list-information").find("input.offset").val(0);
	tableInformation();
});
</script>
<!-- JS end -->
</body>
</html>
