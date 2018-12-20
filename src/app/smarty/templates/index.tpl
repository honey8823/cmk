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

    <!-- Main content -->
    <section class="content container-fluid">

      <a href="/tutorial.php">
        <div class="callout callout-success">
          <h4><i class="fa fa-fw fa-arrow-right" aria-hidden="true"></i>チュートリアル</h4>
          <p>はじめての方、何をしていいかわからない方はこちらへどうぞ。</p>
        </div>
      </a>

      <a href="/information.php">
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
      </a>

      <div>
        <div class="form-group">
          <label>ご要望・不具合報告・ご質問はこちらへ</label>
          <small><a href="/public/stage/detail.php?user=sample_account&id=185#timeline">【ご要望への回答はこちら】</a></small>
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
