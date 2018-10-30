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
      <h1>チュートリアル</h1>
    </section>

    <!-- Main content -->
    <section class="content container-fluid">

      <div class="box box-primary">
        <div class="box-header"><h3 class="box-title"><i class="fa fa-check fa-fw"></i>まずはシンプルなタイムラインを作ってみる</h3></div>
        <div class="box-body">
          <h4>【STEP1】ステージを追加する</h4>
          <small>
            「ステージ管理」から「ステージを追加」してみましょう。<br>
            とりあえずは適当な名前を指定して保存してみてください。<br>
            内容はあとから変更できます。<br>
            また、追加したステージはドラッグ＆ドロップで並べ替えが可能です。
          </small>
          <h4>【STEP2】ステージにエピソードを追加する</h4>
          <small>
            作ったステージを選んで「タイムラインにエピソードを追加」してみましょう。<br>
            タイトル・URL・テキストのいずれかは必須です。<br>
            （「ラベルにする」にチェックを入れるとタイトルのみ指定できるので、この場合はタイトルが必須です）<br>
            入力後、公開状態で登録した場合は他人から見ることができるようになり、<br>
            非公開で登録した場合は自分以外には見えない状態になります。<br>
            また、一度登録したエピソードを編集したい場合、エピソードをクリックすると編集画面になります。
          </small>
          <h4>【STEP3】必要に応じてエピソードを並べ替える</h4>
          <small>
            エピソードを複数登録したあと、「並べ替えモードにする」をクリックすると<br>
            ドラッグ＆ドロップで並べ替えができるようになります。<br>
            もう一度クリックすると並べ替えモードを終了します。
          </small>
          <h4>【STEP4】ステージを公開する？</h4>
          <small>
            ステージのページで「公開する」をクリックすると他人からも見える状態になります。<br>
            「公開用ページを見る」のリンク先が他人から見える内容で、<br>
            そのURLを知っている人なら誰でも見ることができます。
          </small>
        </div>
      </div>

      <div class="box box-primary">
        <div class="box-header"><h3 class="box-title"><i class="fa fa-check fa-fw"></i>ステージへ情報を追加する＜ジャンル編＞</h3></div>
        <div class="box-body">
          <h4>【STEP1】アカウント情報を変更する</h4>
          <small>
            アカウント情報から「ジャンル設定」が可能です。<br>
            このサイトで使うジャンルを選んで保存してください。<br>
            ※ジャンルの自由入力に対応する予定はありません。<br>
            　追加希望はいつでも受け付けていますので、<br>
            　トップページの匿名フォームや作者Twitterにてお気軽にお知らせください。
          </small>
          <h4>【STEP2】ステージに関連作品を設定する</h4>
          <small>
            ステージにて、STEP1で設定したジャンルに応じた関連作品を選ぶことができます。<br>
            自分の作ったステージに関連する作品を選んで設定してください。<br>
            ※関連作品の自由入力に対応する予定もありません。<br>
            　同じく追加希望はフォーム等からお気軽にお知らせください。
          </small>
        </div>
      </div>

      <div class="box box-primary">
        <div class="box-header"><h3 class="box-title"><i class="fa fa-check fa-fw"></i>ステージへ情報を追加する＜キャラクター編＞</h3></div>
        <div class="box-body">
          <u>※この肝心のキャラクター系機能はいろいろと未実装です…。今後拡張していく予定です。</u>
          <h4>【STEP1】キャラクターを追加する</h4>
          <small>
            「キャラクター管理」から「キャラクターを追加」してみましょう。<br>
            追加時は「名前」と「属するステージ」のみ設定できます。<br>
            詳しい内容は登録後に編集していく形<s>です</s>になる予定です。未実装。<br>
            また、追加したステージはドラッグ＆ドロップで並べ替えが可能です。
          </small>
          <h4>【STEP2】キャラクターを編集する</h4>
          <small>
            作ったキャラクターを選ぶと編集画面になります。<br>
            ここでは追加したキャラクターのプロフィール設定や公開/非公開の切り替えを行うことができます。<br>
            しつこいようですがいろいろと未実装で、今後機能を追加していく予定です。
          </small>
          <h4>【STEP3】エピソードとキャラクターを関連付ける</h4>
          <small>
            エピソードの追加・編集時、そのステージに属するキャラクターを選ぶことができます。<br>
            この設定をしておくと、キャラクターごとのタイムラインに反映されるようになります。
          </small>
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