<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>{$smarty.const.SITE_NAME_FULL}</title>
  {include file='common/adminlte_css.tpl'}
  {include file='common/common_private_css.tpl'}
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
      <h1>通知</h1>
      <ol class="breadcrumb">
        <li><a href="/">トップ</a></li>
        <li class="active">通知</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content container-fluid">
      <div class="row" style="margin-top: 10px;">
        <div class="col-md-12" id="list-notice">
          <div>

            <div class="box box-primary notice_list template-for-copy">
              <a href="#">
                <div class="box-body">
                  <i class="fa fa-fw fa-exclamation-circle notice-icon unread" aria-hidden="true"></i>
                  <i class="fa fa-fw fa-exclamation-circle notice-icon read hidden" aria-hidden="true"></i>
                  <span class="notice-date"></span>
                </div>
                <div class="box-body notice-content"></div>
              </a>
            </div>

          </div>
          <div class="box-body no-padding">
            <button type="button" class="btn btn-default btn-block btn-more disabled" onclick="tableNotice();">もっとみる</button>
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
{include file='common/common_js.tpl'}
<script src="/js/notice.js"></script>
<script>
// 読み込み完了時の処理
$(function(){
	// データ読み込み
	$("#list-notice").find("input.offset").val(0);
	tableNotice();
});
</script>
<!-- JS end -->
</body>
</html>