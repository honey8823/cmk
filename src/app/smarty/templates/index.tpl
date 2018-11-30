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
        <h4>「うちのこタイムライン」とは？</h4>
        <p><small>
          キャラメイクゲーやTRPGで作ったキャラクターやストーリーをまとめるツールです。（β版）<br>
          一次創作二次創作問わず、ご自由にご利用ください。
        </small></p>
      </div>

      <div class="callout callout-info">
        <h4>最新のお知らせ</h4>
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
          <h4><i class="fa fa-fw fa-arrow-right" aria-hidden="true"></i>チュートリアル</h4>
          <p>はじめての方、何をしていいかわからない方はこちらへどうぞ。</p>
          <p><i class="fa fa-fw fa-lightbulb-o" aria-hidden="true"></i><small>2018-11-29　β版の内容に対応しました！</small></p>
        </div>
      </a>

      <div>
        <div class="form-group">
          <label>ご要望・不具合報告・ご質問はこちらへ</label>
          <textarea id="contact_content" class="form-control" rows="1"></textarea>
          <button type="button" class="btn btn-primary btn-xs btn-block" onclick="addContact();">送信</button>
          <p>
            <small>
              ※匿名のため個別のお返事はできません。必要な場合は<a href="//twitter.com/smtk_tks/" target="_blank">Twitter@smtk_tks</a>までご連絡ください。
            </small>
          </p>
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
<script src="/js/contact.js"></script>
<!-- JS end -->
</body>
</html>
