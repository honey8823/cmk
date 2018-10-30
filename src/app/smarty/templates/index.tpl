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
      <!-- <h1>sandbox</h1> -->
    </section>

    <!-- Main content -->
    <section class="content container-fluid">
      <div class="callout callout-info">
        <h4>なにこれ</h4>
        <p><small>
          キャラメイクゲーやTRPGで作ったキャラクターやストーリーをまとめるツールです。<br>
          2018年10月14日にα版として公開しております。<br>
          セブンスドラゴンシリーズを前提として開発中ですが、<br>
          他ゲーム・一次創作などにも利用いただいても構いません。<br>
          サイト名の案を募集中。
        </small></p>
      </div>

      <div class="callout callout-info">
        <h4>お知らせ＆最近のアップデート</h4>
      {foreach from=$information_list key=k item=v_inforamtion}
        <p>
          {$v_inforamtion.create_stamp|date_format:"%Y-%m-%d"}<br>
          <small>
            {$v_inforamtion.content|nl2br}
          </small>
        </p>
      {/foreach}
      </div>

      <a href="/tutorial.php">
      <div class="callout callout-success">
        <h4><i class="fa fa-fw fa-arrow-right" aria-hidden="true"></i>はじめての方はこちら＜チュートリアル＞</h4>
      </div>
      </a>

      <div class="callout callout-warning">
        <h4>ご注意</h4>
        <p><small>
          とりあえず作ってみたα版です。<br>
          ご自由にご利用いただいて構いませんが、<br>開発中のため、データの公開状態や内容の維持は保証しません。<br>
          不具合やご要望は<a href="//twitter.com/smtk_tks/" target="_blank">こちら</a>までリプライorDMください。<br>
          もしくは、下記のフォームから匿名でお送りいただいてもOKです。<br>
          ただしあくまで個人の趣味で作っているサイトですので対応しきれない場合はご了承ください。<br>
          当方デザイナーではなくプログラマーなので、見た目が二の次になっているのもご了承ください…。
        </small></p>
      </div>
      <div>
        <div class="form-group">
          <label>ご要望・不具合報告・ご質問はこちらへ</label>
          <textarea id="contact_content" class="form-control" rows="1" placeholder="（匿名なのでこちらからの返信はできませんが、場合によってはトップページ等でお知らせします）"></textarea>
          <button type="button" class="btn btn-primary btn-xs btn-block" onclick="addContact();">送信</button>
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
<script src="/js/contact.js"></script>
<!-- JS end -->
</body>
</html>
