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
      <!-- <h1>sandbox</h1> -->
    </section>

    <!-- Main content -->
    <section class="content container-fluid">
      <div class="callout callout-info">
        <h4>なにこれ</h4>
        <p><small>
          キャラメイクゲーやTRPGで作ったキャラクターやストーリーをまとめるツールです。（β版）<br>
          一次創作二次創作問わず、ご自由にご利用ください。<br>
          <br>
          不具合やご要望は<a href="//twitter.com/smtk_tks/" target="_blank">こちら</a>までリプライorDMください。<br>
          もしくは、ページ下部のフォームから匿名でお送りいただいてもOKです。<br>
          ただしあくまで個人の趣味で作っているサイトですので対応しきれない場合はご了承ください。
        </small></p>
      </div>

      <a href="/tutorial.php">
        <div class="callout callout-success">
          <h4><i class="fa fa-fw fa-arrow-right" aria-hidden="true"></i>はじめての方はこちら＜チュートリアル＞</h4>
        </div>
      </a>

      <div class="callout callout-info">
        <h4>お知らせ</h4>
      {foreach from=$information_list key=k item=v_inforamtion}
        <p>
          {$v_inforamtion.create_stamp|date_format:"%Y-%m-%d"}<br>
          <small>
            {$v_inforamtion.content|nl2br}
          </small>
        </p>
      {/foreach}
      </div>

      <div>
        <div class="form-group">
          <label>ご要望・不具合報告・ご質問はこちらへ</label>
          <textarea id="contact_content" class="form-control" rows="1" placeholder="（匿名なので個別返信はできませんが、内容によってはトップページ等で告知します）"></textarea>
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
