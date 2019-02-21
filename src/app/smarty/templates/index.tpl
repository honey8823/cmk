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
      <div class="row">

        <div class="col-md-9">

          <a href="/tutorial.php">
            <div class="callout callout-success">
              <h4><i class="fa fa-fw fa-arrow-right" aria-hidden="true"></i>チュートリアル</h4>
              <p>はじめての方、何をしていいかわからない方はこちらへどうぞ。</p>
            </div>
          </a>
          <a href="/information.php">
            <div class="callout callout-info">
              <h4>最新のお知らせ</h4>
              <div>
              {foreach from=$information_list key=k item=v_inforamtion}
                <p>
                  {$v_inforamtion.create_stamp|date_format:"%Y-%m-%d"}<br>
                  <small>{$v_inforamtion.content|nl2br}</small>
                </p>
              {/foreach}
              </div>
            </div>
          </a>
{*** todo::公開機能 box-body部分ともっと見るリンクを要調整
          <div class="box">
            <div class="box-header with-border">
              <h3 class="box-title">お気に入りユーザーの新着情報</h3>
              <div class="box-tools pull-right">
                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
                <div class="btn-group">
                  <button type="button" class="btn btn-box-tool" data-toggle="dropdown"><i class="fa fa-wrench"></i></button>
                </div>
                <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
              </div>
            </div>
            <div class="box-body">
              【ステージ/キャラクター名 byあああ@aaa】
            </div>
            <div class="box-footer text-align-right">
              <a>&gt;&gt;もっと見る</a>
            </div>
          </div>
          <div class="box">
            <div class="box-header with-border">
              <h3 class="box-title">あなたにおすすめの新着情報</h3>
              <div class="box-tools pull-right">
                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
                <div class="btn-group">
                  <button type="button" class="btn btn-box-tool" data-toggle="dropdown"><i class="fa fa-wrench"></i></button>
                </div>
                <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
              </div>
            </div>
            <div class="box-body">
             【ステージ/キャラクター名 byあああ@aaa】
            </div>
            <div class="box-footer text-align-right">
              <a>&gt;&gt;もっと見る</a>
            </div>
          </div>
***}
          <div class="form-group">
            <label>ご要望・不具合報告・ご質問はこちらへ</label>
            <p>
              <small>
                ※いただいた内容は<a href="/public/stage/detail.php?user=sample_account&id=185#timeline">こちら</a>で回答する場合もあります。<br>
                ※匿名のため個別のお返事はできません。必要な場合は<a href="//twitter.com/uchinoko_tl/" target="_blank">Twitter</a>へご連絡ください。
              </small>
            </p>
            <textarea id="contact_content" class="form-control" rows="1"></textarea>
            <button type="button" class="btn btn-primary btn-xs btn-block" onclick="addContact();">送信</button>
          </div>
        </div>

        <div class="col-md-3">
          <p class="pull-left"><label>公式Twitter</label></p>
          <p class="pull-right"><a href="https://twitter.com/uchinoko_tl?ref_src=twsrc%5Etfw" class="twitter-follow-button" data-show-screen-name="false" data-show-count="false">Follow @uchinoko_tl</a><script async src="https://platform.twitter.com/widgets.js" charset="utf-8"></script></p>
          <a class="twitter-timeline" data-width="100%" data-height="85vh" data-theme="dark" data-link-color="#2B7BB9" href="https://twitter.com/uchinoko_tl?ref_src=twsrc%5Etfw">Tweets by uchinoko_tl</a>
          <script async src="https://platform.twitter.com/widgets.js" charset="utf-8"></script>
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
