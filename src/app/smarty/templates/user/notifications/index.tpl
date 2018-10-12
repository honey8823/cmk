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
      <h1>通知</h1>
      <ol class="breadcrumb">
        <li><a href="/">トップ</a></li>
        <li class="active">通知</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="row">
        <div class="col-md-6">
          <div id="list-stage" class="box">
            <div class="box-body no-padding">
              <table class="table table-hover table-stage">
                <tr>
                  <td>通知はありません<small>（β版実装）</small></td>
                </tr>
                <!-- テーブルテンプレート -->
                <tr class="stage_list template-for-copy">
                  <td class="td-name"><a href="/user/stage/edit.php?" class="stage_id"><span class="stage_name"></span></a></td>
                  <td class="td-tag"><span class="template-for-copy label tag-base"></span></td>
                  <td class="td-is_private"><span class="stage_is_private_0">公開</span><span class="stage_is_private_1">非公開</span></td>
                </tr>
              </table>
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
<!-- JS end -->
</body>
</html>