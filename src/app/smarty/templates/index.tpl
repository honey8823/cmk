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
      <h1>sandbox</h1>
    </section>

    <!-- Main content -->
    <section class="content container-fluid">
      <div class="callout callout-info">
        <h4>なにこれ</h4>
        <p>
          説明
        </p>
        <h4>募集中</h4>
        <ul>
          <li>サイト名</li>
          <li>デザインできる方(モックアップまで)</li>
        </ul>
      </div>
      <div class="callout callout-warning">
        <h4>ご注意</h4>
        <p>
          とりあえず作ってみたα版です。<br>
          ご自由にご利用いただいて構いませんが、開発中のためデータの整合性は保証しません。<br>
          （β版へ移行する際は極力維持するよう努めます）<br>
          実装するかもしれない機能は<a href="//github.com/honey8823/cmk/labels/実装するかも" target="_blank">こちら</a>。<br>
          現在確認している不具合は<a href="//github.com/honey8823/cmk/labels/不具合" target="_blank">こちら</a>。<br>
          上記以外の不具合やご要望は<a href="//twitter.com/smtk_tks/" target="_blank">こちら</a>までリプライorDMください。<br>
          ただしあくまで個人の趣味で作っているサイトですので対応しきれない場合はご了承ください。<br>
          当方デザイナーではなくプログラマーなので、見た目が二の次になっているのもご了承ください…。
        </p>
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