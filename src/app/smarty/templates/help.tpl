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
      <h1>ヘルプ</h1>
    </section>

    <!-- Main content -->
    <section class="content container-fluid">

      <a href="/tutorial.php">
      <div class="callout callout-success">
        <h4><i class="fa fa-fw fa-arrow-right" aria-hidden="true"></i>はじめての方はこちら＜チュートリアル＞</h4>
      </div>
      </a>

    {foreach from=$help_list key=k item=v_help}
      <div class="box box-primary collapsed-box">
        <span class="help-update_stamp">最終更新日：{strtotime($v_help.update_stamp)|date_format:"%Y-%m-%d"}</span>
        <div class="box-header with-border clickable" data-widget="collapse"><h3 class="box-title">{$v_help.title}</h3></div>
        <div class="box-body"><small>{$v_help.content}</small></div>
      </div>
    {/foreach}

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