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
      <h1>チュートリアル</h1>
    </section>

    <!-- Main content -->
    <section class="content container-fluid">

      <div class="box box-primary collapsed-box">
        <div class="box-header with-border tutorial-title-img clickable" data-widget="collapse" style="background-image: url(/img/tutorial/title_1.png);">
          <h3 class="box-title">
            <i class="fa fa-check fa-fw"></i>
            どんな使い方ができるの？
          </h3>
        </div>
        <div class="box-body">

          <div class="tutorial-talk">
            <img class="icon-talk img-circle" src="/img/tutorial/selena_1.png">
            <span class="text-talk">
              はじめまして！　ボクはセレナ。<br>
              ここではこのサイトの使い方を案内するよ。<br>
              で、こっちは妹のエレナ。
            </span>
          </div>
          <div class="tutorial-talk">
            <img class="icon-talk img-circle" src="/img/tutorial/elena_1.png">
            <span class="text-talk">
              よろしく。<br>
              さっそくだけど、これは何ができるところなの？
            </span>
          </div>
          <div class="tutorial-talk">
            <img class="icon-talk img-circle" src="/img/tutorial/selena_1.png">
            <span class="text-talk">
              じゃあまずは使い方の例をひとつ挙げようか。<br><br>
              <img class="image-talk" src="/img/tutorial/content_1_1.png">
            </span>
          </div>
          <div class="tutorial-talk">
            <img class="icon-talk img-circle" src="/img/tutorial/elena_1.png">
            <span class="text-talk">
              ……何これ？
            </span>
          </div>
          <div class="tutorial-talk">
            <img class="icon-talk img-circle" src="/img/tutorial/selena_1.png">
            <span class="text-talk">
              これは「ステージ」。<br>
              これが何かと言われると使い方によって変わってくるんだけど、<br>
              ある世界観の単位、くらいに考えるのがいいんじゃないかな。<br>
              ひとつの話を「ifルート」「バッドエンド版」みたいに分割してもいいと思うよ。
            </span>
          </div>
          <div class="tutorial-talk">
            <img class="icon-talk img-circle" src="/img/tutorial/elena_1.png">
            <span class="text-talk">
              いや、内容の方が気になるんだけど……
            </span>
          </div>
          <div class="tutorial-talk">
            <img class="icon-talk img-circle" src="/img/tutorial/selena_1.png">
            <span class="text-talk">
              これは今ボクが考えた話。<br>
              この画像の下半分は「タイムライン」機能といって、<br>
              こうやって、ちょっとしたストーリーや外部サイトへのリンクをまとめることができるんだ。<br>
              タイムラインという名前のとおり時系列に並べておいてもいいし、<br>
              赤い「ラベル」を使って何かのカテゴリごとに分けるのもいいと思うよ。
            </span>
          </div>
          <div class="tutorial-talk">
            <img class="icon-talk img-circle" src="/img/tutorial/elena_1.png">
            <span class="text-talk">
              ふーん。<br>
              創作のストーリーをまとめる場ってことでいいの？
            </span>
          </div>
          <div class="tutorial-talk">
            <img class="icon-talk img-circle" src="/img/tutorial/selena_1.png">
            <span class="text-talk">
              まあ、そんな感じ。<br>
              小説やマンガをきっちり書いていかなくても、思いついたときにメモして並べておけばいいし、きっちり書くためのプロット作りの場にしてもいいんだよ。<br>
              あとは、pixivやtwitterなんかにちょっとずつ投稿して散らばっちゃったものをここからリンクしておけば、他の投稿で流れてしまうこともないし、他人にも紹介しやすいよね。
            </span>
          </div>
          <div class="tutorial-talk">
            <img class="icon-talk img-circle" src="/img/tutorial/elena_1.png">
            <span class="text-talk">
              え、他の人からも見られるの？<br>
              これ恥ずかしいから見せてほしくないんだけど。
            </span>
          </div>
          <div class="tutorial-talk">
            <img class="icon-talk img-circle" src="/img/tutorial/selena_1.png">
            <span class="text-talk">
              見せることも見せないこともできるよ。<br>
              まずは作ってからだから、後で説明するね。
            </span>
          </div>
          <div class="tutorial-talk">
            <img class="icon-talk img-circle" src="/img/tutorial/elena_1.png">
            <span class="text-talk">
              他にも使い方はあるの？
            </span>
          </div>
          <div class="tutorial-talk">
            <img class="icon-talk img-circle" src="/img/tutorial/selena_1.png">
            <span class="text-talk">
              他にもあるというか、別に創作に使う必要もないんだよね。<br>
              ブックマークだろうが買い物メモだろうが工夫次第で好きに使えるよ。<br>
              <a href="/public/stage/detail.php?user=sample_account&id=11" target="_blank"><i class="fa fa-fw fa-external-link" aria-hidden="true"></i>例えばこれはToDoリストだね。</a>
            </span>
          </div>
          <div class="tutorial-talk">
            <img class="icon-talk img-circle" src="/img/tutorial/elena_1.png">
            <span class="text-talk">
              なるほどね……。<br>
              話は戻るけど、登場するキャラクターの設定もここに書けばいいの？
            </span>
          </div>
          <div class="tutorial-talk">
            <img class="icon-talk img-circle" src="/img/tutorial/selena_1.png">
            <span class="text-talk">
              ううん、キャラクター設定がまとめられる機能はちゃんと用意されているよ。<br>
              こんな感じだね。<br><br>
              <img class="image-talk" src="/img/tutorial/content_1_2.png">
            </span>
          </div>
          <div class="tutorial-talk">
            <img class="icon-talk img-circle" src="/img/tutorial/elena_1.png">
            <span class="text-talk">
              ふむふむ……。
            </span>
          </div>
          <div class="tutorial-talk">
            <img class="icon-talk img-circle" src="/img/tutorial/selena_1.png">
            <span class="text-talk">
              このサイトの主な用途はこんなところかな。<br>
              じゃあ、次からは詳しい使い方を見ていこうか。
            </span>
          </div>

        </div>
      </div>

      <div class="box box-primary collapsed-box">
        <div class="box-header with-border tutorial-title clickable" data-widget="collapse">
          <h3 class="box-title">
            <i class="fa fa-check fa-fw"></i>
            【基本編】ステージを作ってみる
          </h3>
        </div>
        <div class="box-body">

          <div class="tutorial-talk">
            <img class="icon-talk img-circle" src="/img/tutorial/selena_1.png">
            <span class="text-talk">
              ということで、まずはステージを作ってみようか。
            </span>
          </div>
          <div class="tutorial-talk">
            <img class="icon-talk img-circle" src="/img/tutorial/elena_1.png">
            <span class="text-talk">
              めんどくさそう……
            </span>
          </div>
          <div class="tutorial-talk">
            <img class="icon-talk img-circle" src="/img/tutorial/selena_1.png">
            <span class="text-talk">
              そうでもないよ。<br>
              はい、まずは左側のメニューから「ステージ管理」へ。<br><br>
              <img class="image-talk" src="/img/tutorial/content_2_1.png">
            </span>
          </div>
          <div class="tutorial-talk">
            <img class="icon-talk img-circle" src="/img/tutorial/elena_1.png">
            <span class="text-talk">
              スマートフォンみたいな幅の狭い端末だと、左上の「<i class="fa fa-fw fa-bars" aria-hidden="true"></i>」をタップすれば出てくるわね。
            </span>
          </div>
          <div class="tutorial-talk">
            <img class="icon-talk img-circle" src="/img/tutorial/selena_1.png">
            <span class="text-talk">
              そうそう。<br>
              すると「ステージを追加」ボタンがあるよね。それを押す。
            </span>
          </div>
          <div class="tutorial-talk">
            <img class="icon-talk img-circle" src="/img/tutorial/elena_1.png">
            <span class="text-talk">
              ふむふむ。<br>
              こんなのが出てきたけど。<br><br>
              <img class="image-talk" src="/img/tutorial/content_2_2.png">
            </span>
          </div>
          <div class="tutorial-talk">
            <img class="icon-talk img-circle" src="/img/tutorial/selena_1.png">
            <span class="text-talk">
              オーケー。じゃあとりあえず、「ステージ名」に適当な名前を入れて「登録」を押そう。
            </span>
          </div>
          <div class="tutorial-talk">
            <img class="icon-talk img-circle" src="/img/tutorial/elena_1.png">
            <span class="text-talk">
              えっ、他の項目は？
            </span>
          </div>
          <div class="tutorial-talk">
            <img class="icon-talk img-circle" src="/img/tutorial/selena_1.png">
            <span class="text-talk">
              ステージ名以外は入力しなくても大丈夫。<br>
              後から直すこともできるし、登録した時点では他の人からは見えないしね。<br>
              ちなみに、「説明文」は名前のとおりそのステージについての説明で、「タグ」は該当するものを選べばいいだけだよ。
            </span>
          </div>
          <div class="tutorial-talk">
            <img class="icon-talk img-circle" src="/img/tutorial/elena_1.png">
            <span class="text-talk">
              じゃあ、名前を入れて、っと……。<br>
              あ、さっきのページに出てきたわね。<br><br>
              <img class="image-talk" src="/img/tutorial/content_2_3.png">
            </span>
          </div>
          <div class="tutorial-talk">
            <img class="icon-talk img-circle" src="/img/tutorial/selena_1.png">
            <span class="text-talk">
              無事に登録されたね。じゃあそれを押して。<br>
              ……すきやき？
            </span>
          </div>
          <div class="tutorial-talk">
            <img class="icon-talk img-circle" src="/img/tutorial/elena_1.png">
            <span class="text-talk">
              とりあえず試しに、買い物メモを作ろうと思って。<br>
              えっと、これを押すと……あ、これは最初に見せてくれたページね。
            </span>
          </div>
          <div class="tutorial-talk">
            <img class="icon-talk img-circle" src="/img/tutorial/selena_1.png">
            <span class="text-talk">
              そういうこと。
            </span>
          </div>
        </div>
      </div>
      <div class="box box-primary collapsed-box">
        <div class="box-header with-border tutorial-title clickable" data-widget="collapse">
          <h3 class="box-title">
            <i class="fa fa-check fa-fw"></i>
            【基本編】ステージにエピソードを追加してみる
          </h3>
        </div>
        <div class="box-body">

          <div class="tutorial-talk">
            <img class="icon-talk img-circle" src="/img/tutorial/selena_1.png">
            <span class="text-talk">
              じゃあ買い物メモを作るということで、何を買うかを登録していこうか。<br>
              「タイムラインにエピソードを追加」か、右下の「<i class="fa fa-fw fa-plus" aria-hidden="true"></i>」を押してみて。
            </span>
          </div>
          <div class="tutorial-talk">
            <img class="icon-talk img-circle" src="/img/tutorial/elena_1.png">
            <span class="text-talk">
              じゃあ、名前を入れて、っと……。<br>
              うわ、ちょっとめんどくさそうなのが出てきた。<br><br>
              <img class="image-talk" src="/img/tutorial/content_3_1.png">
            </span>
          </div>
          <div class="tutorial-talk">
            <img class="icon-talk img-circle" src="/img/tutorial/selena_1.png">
            <span class="text-talk">
              これは「エピソード」の登録フォームだね。<br>
              「エピソード」を並べたものが「タイムライン」になるんだ。<br>
              今回は緑のボタンは触らなくていいから、タイトルに「牛肉」と入力して「登録」を押して。
            </span>
          </div>
          <div class="tutorial-talk">
            <img class="icon-talk img-circle" src="/img/tutorial/elena_1.png">
            <span class="text-talk">
              ふむふむ。……あ、タイムラインに出てきた。
            </span>
          </div>
          <div class="tutorial-talk">
            <img class="icon-talk img-circle" src="/img/tutorial/selena_1.png">
            <span class="text-talk">
              登録できたね。その調子で買うものをいくつか入れてみよう。
            </span>
          </div>
          <div class="tutorial-talk">
            <img class="icon-talk img-circle" src="/img/tutorial/elena_1.png">
            <span class="text-talk">
              オッケー。ちょっと待ってて。
            </span>
          </div>
          <div class="tutorial-talk">
            <img class="icon-talk img-circle" src="/img/tutorial/selena_1.png">
            <span class="text-talk">
              じゃあその間に詳しい説明を。<br><br>
              「外部サイトURL」にURLを入力すると、リンクを張ることができるよ。<br>
              「フリーテキスト」は「タイトル」と違って改行ができるから、長文を書くのに向いてるね。<br>
              「タイトル」「外部サイトURL」「フリーテキスト」はどれかひとつ入力すればOKだから、例えばURLのみ登録ということもできるよ。<br>
              あと、フリーテキスト内に「=====」と半角イコールを5個続けて入力すると、他人から見たときにそこから先が省略されて、「クリックすると続きを見る」ことができるようになる。<br>
              単純に長すぎて省略したいときや、ワンクッション置きたいときに使うといいよ。<br>
              <small>
                ※注意<br>
                フォーム右上のボタンからも「=====」を挿入することができますが、それより前の編集について「元に戻す(Ctrl+z など)」が効かなくなってしまいますのでご注意ください。<br>
                また、公開用ページではなく編集用ページでは省略表示されません。今後改善する予定です。
              </small>
            </span>
          </div>
          <div class="tutorial-talk">
            <img class="icon-talk img-circle" src="/img/tutorial/elena_1.png">
            <span class="text-talk">
              ……はい、お待たせ。こんな感じ？<br><br>
              <img class="image-talk" src="/img/tutorial/content_3_2.png">
            </span>
          </div>
          <div class="tutorial-talk">
            <img class="icon-talk img-circle" src="/img/tutorial/selena_1.png">
            <span class="text-talk">
              バッチリ。<br>
              ……ところで、これ全部同じお店で買うの？
            </span>
          </div>
          <div class="tutorial-talk">
            <img class="icon-talk img-circle" src="/img/tutorial/elena_1.png">
            <span class="text-talk">
              ううん、ほとんどスーパーで買うけど、ねぎだけ近くの八百屋さんで……あっ、中途半端なところに入れちゃったなあ。<br>
              これ、並べ替えられるんだっけ？
            </span>
          </div>
          <div class="tutorial-talk">
            <img class="icon-talk img-circle" src="/img/tutorial/selena_1.png">
            <span class="text-talk">
              並べ替えもできるし、せっかくだからラベルをつけてみようか。<br>
              もう一度エピソードの登録フォームを開いて、今度は緑のボタンの「ラベル」を押してみて。
            </span>
          </div>
          <div class="tutorial-talk">
            <img class="icon-talk img-circle" src="/img/tutorial/elena_1.png">
            <span class="text-talk">
              ずいぶん簡単なフォームになったわね。<br><br>
              <img class="image-talk" src="/img/tutorial/content_3_3.png">
            </span>
          </div>
          <div class="tutorial-talk">
            <img class="icon-talk img-circle" src="/img/tutorial/selena_1.png">
            <span class="text-talk">
              この場合はタイトルだけが付けられるよ。<br>
              これで「スーパー」と「八百屋」を登録してみようか。
            </span>
          </div>
          <div class="tutorial-talk">
            <img class="icon-talk img-circle" src="/img/tutorial/elena_1.png">
            <span class="text-talk">
              こうね。<br><br>
              <img class="image-talk" src="/img/tutorial/content_3_4.png">
            </span>
          </div>
          <div class="tutorial-talk">
            <img class="icon-talk img-circle" src="/img/tutorial/selena_1.png">
            <span class="text-talk">
              うん、それから並べ替えだね。<br>
              「並べ替えモードにする」か、右下の「<i class="fa fa-fw fa-sort" aria-hidden="true"></i>」を押せば、ドラッグ＆ドロップで並べ替えられるようになるよ。
            </span>
          </div>
          <div class="tutorial-talk">
            <img class="icon-talk img-circle" src="/img/tutorial/elena_1.png">
            <span class="text-talk">
              できたわ。これはもう保存されてるの？<br><br>
              <img class="image-talk" src="/img/tutorial/content_3_5.png">
            </span>
          </div>
          <div class="tutorial-talk">
            <img class="icon-talk img-circle" src="/img/tutorial/selena_1.png">
            <span class="text-talk">
              並べ替えた時点で保存されてるから大丈夫だよ。<br>
              スマートフォンだとスクロールするときに誤操作しやすいから、きちんと「並べ替えモード」は終了した方が安全だけどね。
            </span>
          </div>
          <div class="tutorial-talk">
            <img class="icon-talk img-circle" src="/img/tutorial/elena_1.png">
            <span class="text-talk">
              じゃあ、これで買い物メモは完成ね。
            </span>
          </div>

        </div>
      </div>

      <div class="box box-primary collapsed-box">
        <div class="box-header with-border tutorial-title clickable" data-widget="collapse">
          <h3 class="box-title">
            <i class="fa fa-check fa-fw"></i>
            【基本編】ステージを公開してみる
          </h3>
        </div>
        <div class="box-body">

          <div class="tutorial-talk">
            <img class="icon-talk img-circle" src="/img/tutorial/elena_1.png">
            <span class="text-talk">
              作ったステージは公開できるんでしょ？<br>
              たとえばこのページのアドレスをセレナに送って「この買い物よろしく！」ってしたければ、どうすればいいの？
            </span>
          </div>
          <div class="tutorial-talk">
            <img class="icon-talk img-circle" src="/img/tutorial/selena_1.png">
            <span class="text-talk">
              ……ボク以外にも見えちゃうから、不特定多数に見せたくない情報が載ったステージは公開しちゃダメだよ。<br>
              <br>
              さて、ステージを公開する前に、まずはエピソードを公開状態にしよう。<br>
              ステージとエピソードのそれぞれが「公開するかどうか」の情報を持っているから、両方が公開されていないと他人からは見えないよ。
            </span>
          </div>
          <div class="tutorial-talk">
            <img class="icon-talk img-circle" src="/img/tutorial/elena_1.png">
            <span class="text-talk">
              えっ、めんどくさい……。
            </span>
          </div>
          <div class="tutorial-talk">
            <img class="icon-talk img-circle" src="/img/tutorial/selena_1.png">
            <span class="text-talk">
              そこは否定できない……。<br>
              でも、例えば公開中のステージであってもエピソード単位では見せたくないものや下書き中のものもあるから勘弁してほしいかな……。<br>
              <br>
              それはさておいて、エピソードを公開設定にするのは簡単。<br>
              タイムライン上の鍵マークを押すだけだよ。<br>
            </span>
          </div>
          <div class="tutorial-talk">
            <img class="icon-talk img-circle" src="/img/tutorial/elena_1.png">
            <span class="text-talk">
              こうね。<br>
              鍵の開いてるグレーの状態が「公開」、鍵の閉まってる黄色い状態が「非公開」よね？<br><br>
              <img class="image-talk" src="/img/tutorial/content_4_1.png">
            </span>
          </div>
          <div class="tutorial-talk">
            <img class="icon-talk img-circle" src="/img/tutorial/selena_1.png">
            <span class="text-talk">
              そうそう。<br>
              この画像の状態だと、「スーパー」～「糸こんにゃく」だけ公開されるってこと。
            </span>
          </div>
          <div class="tutorial-talk">
            <img class="icon-talk img-circle" src="/img/tutorial/elena_1.png">
            <span class="text-talk">
              じゃあ全部鍵を開けて、っと。<br>
              あとは「ステージ」を公開設定にすればオッケーね。<br>
              もしかしてコレを押せばいいの？<br><br>
              <img class="image-talk" src="/img/tutorial/content_4_2.png">
            </span>
          </div>
          <div class="tutorial-talk">
            <img class="icon-talk img-circle" src="/img/tutorial/selena_1.png">
            <span class="text-talk">
              そう。押してみると、公開用ページのURLが出てくるよ。<br><br>
              <img class="image-talk" src="/img/tutorial/content_4_3.png">
            </span>
          </div>
          <div class="tutorial-talk">
            <img class="icon-talk img-circle" src="/img/tutorial/elena_1.png">
            <span class="text-talk">
              あ、ホント。これを押してみると……できてる！<br>
              このページのアドレスをセレナに送ればいいのね。<br><br>
              <img class="image-talk" src="/img/tutorial/content_4_4.png">
            </span>
          </div>
          <div class="tutorial-talk">
            <img class="icon-talk img-circle" src="/img/tutorial/selena_1.png">
            <span class="text-talk">
              ……あれ、もしかしてほんとにボクが買い物してくる流れになってる？
            </span>
          </div>

        </div>
      </div>

      <div class="box box-primary collapsed-box">
        <div class="box-header with-border tutorial-title clickable" data-widget="collapse">
          <h3 class="box-title">
            <i class="fa fa-check fa-fw"></i>
            【基本編】キャラクターを作ってみる
          </h3>
        </div>
        <div class="box-body">

          <div class="tutorial-talk">
            <img class="icon-talk img-circle" src="/img/tutorial/yuki_1.png">
            <span class="text-talk">
              よお、エレナ！
            </span>
          </div>
          <div class="tutorial-talk">
            <img class="icon-talk img-circle" src="/img/tutorial/elena_1.png">
            <span class="text-talk">
              うわ、なんか来た。<br>
              何しにきたのよ、ユウキ？
            </span>
          </div>
          <div class="tutorial-talk">
            <img class="icon-talk img-circle" src="/img/tutorial/yuki_1.png">
            <span class="text-talk">
              ヒマだなーと思って。あと腹減ったし。<br>
              で、それ、何だ？
            </span>
          </div>
          <div class="tutorial-talk">
            <img class="icon-talk img-circle" src="/img/tutorial/elena_1.png">
            <span class="text-talk">
              人んちのごはん食べる気で来ないでよ。<br><br>
              で、これはかくかくしかじかで……
            </span>
          </div>
          <div class="tutorial-talk">
            <img class="icon-talk img-circle" src="/img/tutorial/yuki_1.png">
            <span class="text-talk">
              なるほどー。<br>
              じゃあセレナが買い物行ってる間に、「キャラクター」の登録とやらをやってみるか。たぶんコレだろ？<br><br>
              <img class="image-talk" src="/img/tutorial/content_5_1.png">
            </span>
          </div>
          <div class="tutorial-talk">
            <img class="icon-talk img-circle" src="/img/tutorial/elena_1.png">
            <span class="text-talk">
              「キャラクターを追加」ってボタンが出てきたわね。<br>
              これを押してみると……？<br><br>
              <img class="image-talk" src="/img/tutorial/content_5_2.png">
            </span>
          </div>
          <div class="tutorial-talk">
            <img class="icon-talk img-circle" src="/img/tutorial/yuki_1.png">
            <span class="text-talk">
              じゃあ名前は、セレナ、っと……。<br>
              この「属するステージ」ってなんだろな？
            </span>
          </div>
          <div class="tutorial-talk">
            <img class="icon-talk img-circle" src="/img/tutorial/elena_1.png">
            <span class="text-talk">
              登録してあるステージが出てくるみたいね。<br>
              ステージとキャラクターを関連付けることができるのかも。
            </span>
          </div>
          <div class="tutorial-talk">
            <img class="icon-talk img-circle" src="/img/tutorial/yuki_1.png">
            <span class="text-talk">
              ふーん。選ばなくてもいいみたいだから、とりあえず名前だけで登録してみるか。
            </span>
          </div>
          <div class="tutorial-talk">
            <img class="icon-talk img-circle" src="/img/tutorial/elena_1.png">
            <span class="text-talk">
              あ、一覧に出てきた。<br>
              ステージと同じく、これを押せば詳しい設定のページに行けそうね。<br><br>
              <img class="image-talk" src="/img/tutorial/content_5_3.png">
            </span>
          </div>
          <div class="tutorial-talk">
            <img class="icon-talk img-circle" src="/img/tutorial/yuki_1.png">
            <span class="text-talk">
              おおー。<br>
              この「詳細プロフィール」ってところでいろんな設定が追加できそうだな。
            </span>
          </div>
          <div class="tutorial-talk">
            <img class="icon-talk img-circle" src="/img/tutorial/elena_1.png">
            <span class="text-talk">
              なるほどね。<br>
              じゃあ試しに選んで、適当に入力して、この保存アイコンを押してみると……<br>
              あ、登録されたみたいね。<br><br>
              <img class="image-talk" src="/img/tutorial/content_5_4.png">
            </span>
          </div>
          <div class="tutorial-talk">
            <img class="icon-talk img-circle" src="/img/tutorial/yuki_1.png">
            <span class="text-talk">
              えーと、<i class="fa fa-fw fa-floppy-o" aria-hidden="true"></i>を押すと保存されて、<br>
              <i class="fa fa-fw fa-times" aria-hidden="true"></i>を押すとキャンセルで、<br>
              <i class="fa fa-fw fa-pencil-square-o" aria-hidden="true"></i>を押すと登録したやつを編集できて、<br>
              <i class="fa fa-fw fa-trash-o" aria-hidden="true"></i>は登録したやつを削除……だな。<br>
            </span>
          </div>
          <div class="tutorial-talk">
            <img class="icon-talk img-circle" src="/img/tutorial/elena_1.png">
            <span class="text-talk">
              ふむふむ、これで好きなだけ好きな項目を登録していけばいいってワケね。<br>
              公開したいときはステージと同じく、鍵マークを押せば大丈夫そうだし。<br>
              ……ところでこの「タイムライン」タブって何かしら？<br>
              ステージと違ってエピソードの追加はできないみたいだけど、何も表示されないわね。
            </span>
          </div>
          <div class="tutorial-talk">
            <img class="icon-talk img-circle" src="/img/tutorial/yuki_1.png">
            <span class="text-talk">
              うーん、まだ使いこなせてない気がするよな。<br>
              でも、キャラクターのプロフィールとしてはこんなもんかな？
            </span>
          </div>
          <div class="tutorial-talk">
            <img class="icon-talk img-circle" src="/img/tutorial/selena_1.png">
            <span class="text-talk">
              ただいまー。……あれ、ユウキが来てる。
            </span>
          </div>
          <div class="tutorial-talk">
            <img class="icon-talk img-circle" src="/img/tutorial/yuki_1.png">
            <span class="text-talk">
              おう、今日はすきやきだって聞いて。
            </span>
          </div>
          <div class="tutorial-talk">
            <img class="icon-talk img-circle" src="/img/tutorial/elena_1.png">
            <span class="text-talk">
              アンタねえ……。
            </span>
          </div>
          <div class="tutorial-talk">
            <img class="icon-talk img-circle" src="/img/tutorial/selena_1.png">
            <span class="text-talk">
              あはは、別にいいけど。<br>
              あ、キャラクターの登録もやってみたんだね。<br>
              じゃあこれで基本的な使い方はだいたい分かったんじゃないかな？
            </span>
          </div>
          <div class="tutorial-talk">
            <img class="icon-talk img-circle" src="/img/tutorial/elena_1.png">
            <span class="text-talk">
              そうなの？　まだ使いこなせてないよねって話してたとこなんだけど。
            </span>
          </div>
          <div class="tutorial-talk">
            <img class="icon-talk img-circle" src="/img/tutorial/selena_1.png">
            <span class="text-talk">
              基本的なところは本当にこんなもんだよ。<br>
              普通に使う分には充分だと思う。<br>
              けどまあ、せっかくだから後で応用編もやろうか。
            </span>
          </div>

        </div>
      </div>

      <div>
        <p class="hint-box">
          応用編は後日掲載予定です。<br>
          しばらくお待ちください。
        </p>
      </div>
{*
      <div class="box box-primary collapsed-box">
        <div class="box-header with-border tutorial-title clickable" data-widget="collapse">
          <h3 class="box-title">
            <i class="fa fa-check fa-fw"></i>
            【応用編】もっと詳しい設定をしてみる
          </h3>
        </div>
        <div class="box-body">

          <div class="tutorial-talk">
            <img class="icon-talk img-circle" src="/img/tutorial/selena_1.png">
            <span class="text-talk">
              じゃ、さっそくだけど応用編だね。<br>
              まずは、ここまでの使い方のうち、説明していなかったところから補足していこうか。
            </span>
          </div>


        </div>
      </div>

*}
{*
ステージとキャラクターの並べ替え
アカウントとステージタグ
ステージとキャラクターの関連付け（ステージ側から設定・キャラクター側から設定）
エピソードにキャラクターを紐付け（キャラクタータイムライン）
*}

{*
      <div class="box box-primary collapsed-box">
        <div class="box-header with-border tutorial-title clickable" data-widget="collapse">
          <h3 class="box-title">
            <i class="fa fa-check fa-fw"></i>
            【応用編】もっと詳しい設定をしてみる
          </h3>
        </div>
        <div class="box-body">

          <div class="tutorial-talk">
            <img class="icon-talk img-circle" src="/img/tutorial/selena_1.png">
            <span class="text-talk">
              もう一度言うけど、普通に使う分にはここまでの内容で充分だよ。<br>
              ここから先は、めんどくさい設定……じゃないな、こじらせた人……でもなくって、ええと……複雑な設定を作る人向けだね。
            </span>
          </div>
          <div class="tutorial-talk">
            <img class="icon-talk img-circle" src="/img/tutorial/elena_1.png">
            <span class="text-talk">
              なかなか失礼な言い方するわね……<br>
              例えばどういう感じの使い方？
            </span>
          </div>

        </div>
      </div>
*}

{*
ステージオーバーライド
エピソードオーバーライド
*}

{*
      <div class="box box-primary">
        <div class="box-header with-border"><h3 class="box-title"><i class="fa fa-check fa-fw"></i>ステージへ情報を追加する＜ジャンル編＞</h3></div>
        <div class="box-body">
          <h4>【STEP1】アカウント情報を変更する</h4>
          <small>
            アカウント情報から「ジャンル設定」が可能です。<br>
            このサイトで使うジャンルを選んで保存してください。<br>
            ※ジャンルの自由入力に対応する予定はありません。<br>
            　追加希望はいつでも受け付けていますので、<br>
            　<a href="/">トップページの匿名フォーム</a>や<a href="https://twitter.com/smtk_tks">作者Twitter</a>にてお気軽にお知らせください。
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
*}

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
<!-- JS end -->
</body>
</html>
