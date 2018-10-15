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
      <h1>ヘルプ</h1>
    </section>

    <!-- Main content -->
    <section class="content container-fluid">

      <div class="callout callout-info">
        <h4>なにこれ？</h4>
        <p><small>
          キャラメイクゲーやTRPGで作ったキャラクターやストーリーをまとめるツールです。<br>
          2018年10月14日にα版として公開しております。<br>
          セブンスドラゴンシリーズを前提として開発中ですが、<br>
          他ゲーム・一次創作などにも利用いただいても構いません。
        </small></p>
      </div>

      <div class="callout callout-info">
        <h4>どうやって使うの？</h4>
        <ul><small>
          <li>ユーザー登録する</li>
          <li>ログインする</li>
          <li>「ステージ」をつくる</li>
          <li>「キャラクター」をつくって「ステージ」に紐づける</li>
          <li>つくった「ステージ」に「エピソード」を登録する</li>
          <li>登録した「エピソード」を適宜並べ替える（ドラッグ＆ドロップ）</li>
        </small></ul>
      </div>

      <div class="callout callout-info">
        <h4>ステージって何？</h4>
        <p><small>
          物語や世界観の単位として扱うことを想定して開発していますが、<br>
          （「ハッピーエンド版、バッドエンド版」「分岐ルート」「パラレル」「現パロ」など）<br>
          他の用途で使っていただいてもOKです。<br>
          （イラストまとめにする、小説のプロットを作るためのツールにする…など）
        </small></p>
      </div>

      <div class="callout callout-info">
        <h4>エピソードって何？</h4>
        <p><small>
          ひとつのできごと、ちょっとした会話、作品へのリンクなどの単位を想定しています。<br>
          タイトル・URL・フリーテキストが指定できます。<br>
          画像のアップロードには対応していません（対応する予定もありません）ので、<br>
          twitterやpixivなどへリンクするようにしてください。
        </small></p>
      </div>

      <div class="callout callout-info">
        <h4>他人に見せたいんだけど…</h4>
        <p><small>
          申し訳ありませんが、α版公開現在、他人からは見えない状態になっています。<br>
          （スクリーンショットの公開などはご自由にしていただいて構いません）<br>
          α版のアップデートとして、「URLを知っている人のみ見られる機能」を、<br>
          β版から「誰でも見られて検索などもできる機能」を搭載する予定です。
        </small></p>
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