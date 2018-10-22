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
        <h4>最近のアップデート</h4>
        <p>
          2018-10-21<br>
          <small>
            ・ステージのタイムライン公開機能を追加<br>
            　・公開用ページは、編集ページから確認することができます<br>
            　　（他人に共有する場合はそちらのURLをご利用ください）<br>
            　・ステージ/キャラクター/エピソードにそれぞれ公開・非公開の設定ができるよう対応<br>
            　　※キャラクター情報の公開機能は未実装のため、公開状態にしても影響はありません<br>
            　・ユーザーのアカウント情報から、R18コンテンツの表示を許可する設定ができるよう対応<br>
            　　これをONにしている場合のみ、他人のR18エピソードを閲覧可能<br>
            　・長文省略機能を実装<br>
            　　エピソードの本文内に「=====」と半角イコールを連続5文字入力すると<br>
            　　公開用ページではそれ以降が折りたたまれた状態で表示される<br>
            　　※今後「=====」を簡単に挿入できる機能を追加する予定です
          </small>
        </p>
      </div>
      <div class="callout callout-warning">
        <h4>ご注意</h4>
        <p><small>
          とりあえず作ってみたα版です。<br>
          ご自由にご利用いただいて構いませんが、<br>開発中のため、データの公開状態や内容の維持は保証しません。<br>
          β版にて実装予定の機能は<a href="//github.com/honey8823/cmk/labels/β版実装予定" target="_blank">こちら</a>。<br>
          現在確認している不具合は<a href="//github.com/honey8823/cmk/labels/不具合" target="_blank">こちら</a>。<br>
          上記以外の不具合やご要望は<a href="//twitter.com/smtk_tks/" target="_blank">こちら</a>までリプライorDMください。<br>
          もしくは、下記のフォームから匿名でお送りいただいてもOKです。<br>
          ただしあくまで個人の趣味で作っているサイトですので対応しきれない場合はご了承ください。<br>
          当方デザイナーではなくプログラマーなので、見た目が二の次になっているのもご了承ください…。
        </small></p>
      </div>
      <div>
        <div class="form-group">
          <label>ご要望・不具合報告・ご質問はこちらへ</label>
          <textarea id="contact_content" class="form-control" rows="1" placeholder="（匿名なのでこちらからの返信はできせん：場合によってはここでお知らせします）"></textarea>
          <button type="button" class="btn btn-primary btn-xs btn-block" onclick="addContact();">送信</button>
        </div>
      </div>

      <div class="callout callout-info">
        <h4>更新履歴</h4>
        <p>
          2018-10-21<br>
          <small>
            ・ステージのタイムライン公開機能を追加<br>
            　・公開用ページは、編集ページから確認することができます<br>
            　　（他人に共有する場合はそちらのURLをご利用ください）<br>
            　・ステージ/キャラクター/エピソードにそれぞれ公開・非公開の設定ができるよう対応<br>
            　　※キャラクター情報の公開機能は未実装のため、公開状態にしても影響はありません<br>
            　・ユーザーのアカウント情報から、R18コンテンツの表示を許可する設定ができるよう対応<br>
            　　これをONにしている場合のみ、他人のR18エピソードを閲覧可能<br>
            　・長文省略機能を実装<br>
            　　エピソードの本文内に「=====」と半角イコールを連続5文字入力すると<br>
            　　公開用ページではそれ以降が折りたたまれた状態で表示される<br>
            　　※今後「=====」を簡単に挿入できる機能を追加する予定です
          </small>
        </p>
        <p>
          2018-10-19<br>
          <small>
            ・ブラウザの幅によってはコンテンツが2列に表示されていましたが、<br>
            　常に1列になるよう変更しました<br>
            ・エピソード削除機能を改修しました<br>
            （削除時にページをリロードしないよう変更しました）<br>
            ・エピソード内URLのクリック時、編集ウインドウが表示されないようにしました
          </small>
        </p>
        <p>
          2018-10-18<br>
          <small>
            ・エピソード追加編集機能を改修しました<br>
            （完了時にページをリロードしないよう変更しました）
          </small>
        </p>
        <p>
          2018-10-16<br>
          <small>
            ・タイムライン並べ替え機能を改修しました<br>
            （「並べ替えモードにする」か右下の<i class="fa fa-fw fa-sort" aria-hidden="true"></i>をクリックすると<br>
            　ドラッグ＆ドロップで並べ替えられるようになりました）
          </small>
        </p>
        <p>
          2018-10-15<br>
          <small>
            ・ステージとキャラクターをドラッグ＆ドロップで並べ替えられるようになりました<br>
            ・ヘルプページを設置しました<br>
            ・匿名のご意見フォームをトップページに設置しました
          </small>
        </p>
        <p>
          2018-10-14<br>
          <small>・α版を見切り発車で公開開始</small>
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
<script src="/js/contact.js"></script>
<!-- JS end -->
</body>
</html>
