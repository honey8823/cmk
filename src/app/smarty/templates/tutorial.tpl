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
              <b>ある世界観の単位</b>、くらいに考えるのがいいんじゃないかな。
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
              こうやって、<b>ちょっとしたストーリーや外部サイトへのリンクをまとめることができる</b>んだ。<br>
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
              それだけでいいのね。……あ、タイムラインに出てきた。
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
              単純に長すぎて省略したいときや、警告を入れてワンクッション置きたいときなんかに使うといいよ。<br>
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
              ……ボク以外にも見えちゃうから、<b>不特定多数に見せたくない情報が載ったステージは公開しちゃダメ</b>だよ。<br>
              <br>
              さて、ステージを公開する前に、まずはエピソードを公開状態にしよう。<br>
              ステージとエピソードのそれぞれが「公開するかどうか」の情報を持っているから、<b>両方が公開されていないと他人からは見えない</b>よ。
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

      <div class="box box-primary collapsed-box">
        <div class="box-header with-border tutorial-title clickable" data-widget="collapse">
          <h3 class="box-title">
            <i class="fa fa-check fa-fw"></i>
            【基本編＋】ステージに「シリーズ別タグ」を設定できるようにする
          </h3>
        </div>
        <div class="box-body">

          <div class="tutorial-talk">
            <img class="icon-talk img-circle" src="/img/tutorial/selena_1.png">
            <span class="text-talk">
              さて、応用編に入る前に……<br>
              まずは、ここまでの使い方のうち、説明していなかったところから補足していこうか。
            </span>
          </div>
          <div class="tutorial-talk">
            <img class="icon-talk img-circle" src="/img/tutorial/elena_1.png">
            <span class="text-talk">
              うん、気になるところはいくつかあったし。<br>
              例えば、ステージに付けられるタグだけど……使えるタグはこれだけなの？
            </span>
          </div>
          <div class="tutorial-talk">
            <img class="icon-talk img-circle" src="/img/tutorial/selena_1.png">
            <span class="text-talk">
              ううん、そんなことはないよ。<br>
              使えるタグは、実はアカウントの設定によっても変わってくるんだ。
            </span>
          </div>
          <div class="tutorial-talk">
            <img class="icon-talk img-circle" src="/img/tutorial/yuki_1.png">
            <span class="text-talk">
              アカウントの設定？
            </span>
          </div>
          <div class="tutorial-talk">
            <img class="icon-talk img-circle" src="/img/tutorial/selena_1.png">
            <span class="text-talk">
              うん、「ステージ管理」や「キャラクター管理」より少し下に<br>
              「アカウント管理」があるから、それを押してみて。<br>
              アカウントの情報変更ができるページが出てくるから、「プロフィールを変更する」を選んで。
              こんな画面になると思うんだけど……<br><br>
              <img class="image-talk" src="/img/tutorial/content_6_1.png">
            </span>
          </div>
          <div class="tutorial-talk">
            <img class="icon-talk img-circle" src="/img/tutorial/yuki_1.png">
            <span class="text-talk">
              お、見れたぞ。<br>
              もしかして、この「ジャンル設定」が関係あるのか？
            </span>
          </div>
          <div class="tutorial-talk">
            <img class="icon-talk img-circle" src="/img/tutorial/selena_1.png">
            <span class="text-talk">
              そういうこと！<br>
              これを設定しておくと、関連するタグがステージにも設定できるようになるんだ。<br>
              複数設定できるから、使うジャンルは全部ONにしておくといいよ。
            </span>
          </div>
          <div class="tutorial-talk">
            <img class="icon-talk img-circle" src="/img/tutorial/elena_1.png">
            <span class="text-talk">
              なるほどね。じゃあまずは試しに「オリジナル」を設定して、っと。<br>
              それからステージを作成しようとすると……<br>
              あ、設定できるタグが増えたわ。<br><br>
              <img class="image-talk" src="/img/tutorial/content_6_2.png">
            </span>
          </div>
          <div class="tutorial-talk">
            <img class="icon-talk img-circle" src="/img/tutorial/selena_1.png">
            <span class="text-talk">
              これでシリーズ系タグが設定できるようになったね。<br>
              タグは自由に入力することはできない代わりに、<br>
              <b>欲しいジャンルやタグは気軽にリクエストしていいみたいだから、リクエストボックスから送ってみよう。</b>
            </span>
          </div>

        </div>
      </div>

      <div class="box box-primary collapsed-box">
        <div class="box-header with-border tutorial-title clickable" data-widget="collapse">
          <h3 class="box-title">
            <i class="fa fa-check fa-fw"></i>
            【基本編＋】ステージとキャラクターを関連付ける
          </h3>
        </div>
        <div class="box-body">

          <div class="tutorial-talk">
            <img class="icon-talk img-circle" src="/img/tutorial/selena_1.png">
            <span class="text-talk">
              あとは、ステージとキャラクターを関連付けておかないとね。
            </span>
          </div>
          <div class="tutorial-talk">
            <img class="icon-talk img-circle" src="/img/tutorial/elena_1.png">
            <span class="text-talk">
              あ、やっぱりそういう機能があるのね。
            </span>
          </div>
          <div class="tutorial-talk">
            <img class="icon-talk img-circle" src="/img/tutorial/selena_1.png">
            <span class="text-talk">
              もちろん、タイムラインとキャラクターを別々に使うこともできるよ。<br>
              シンプルに管理しやすいかもしれないし、そういう使い方もいいんじゃないかな。
            </span>
          </div>
          <div class="tutorial-talk">
            <img class="icon-talk img-circle" src="/img/tutorial/yuki_1.png">
            <span class="text-talk">
              関連付けると何かトクすることはあるのか？
            </span>
          </div>
          <div class="tutorial-talk">
            <img class="icon-talk img-circle" src="/img/tutorial/selena_1.png">
            <span class="text-talk">
              そうだね、メリットといえば……<br>
              ・そのステージにいるキャラクターが簡単に把握できる<br>
              ・キャラクターごとのタイムラインを作ることができる<br>
              ・「ステージごとのキャラクタープロフィール」や<br>
              　「タイムライン内のキャラクタープロフィールの変化」に対応できる<br>
              ってところかな。
            </span>
          </div>
          <div class="tutorial-talk">
            <img class="icon-talk img-circle" src="/img/tutorial/elena_1.png">
            <span class="text-talk">
              最初のは分かるけど……あとの二つはどういうこと？
            </span>
          </div>
          <div class="tutorial-talk">
            <img class="icon-talk img-circle" src="/img/tutorial/yuki_1.png">
            <span class="text-talk">
              キャラクターのタイムラインっていうのは、もしかして、<br>
              キャラクターページにあった「タイムライン」のタブか？
            </span>
          </div>
          <div class="tutorial-talk">
            <img class="icon-talk img-circle" src="/img/tutorial/selena_1.png">
            <span class="text-talk">
              そうそう。勘がいいじゃないか。<br>
              両方とも話せば長くなるから、後から応用編できちんと見せるよ。<br>
              まずは関連付ける方法だけ説明するね。<br>
              <br>
              関連付ける方法は、実は二つあるんだ。<br>
              どちらも同じ状態になるから、使いやすい方を使うといいよ。<br>
              まずは、キャラクターを作る時や情報を変更する時に設定する方法から。
            </span>
          </div>
          <div class="tutorial-talk">
            <img class="icon-talk img-circle" src="/img/tutorial/elena_1.png">
            <span class="text-talk">
              もしかして、さっきのコレかしら？<br><br>
              <img class="image-talk" src="/img/tutorial/content_5_2.png">
            </span>
          </div>
          <div class="tutorial-talk">
            <img class="icon-talk img-circle" src="/img/tutorial/selena_1.png">
            <span class="text-talk">
              そう、それそれ。<br>
              これは「キャラクター管理」の「キャラクターを追加」で出てくるフォームだね。<br>
              ステージを既に追加してある場合は、ここで選ぶことができるんだ。<br>
              関連付けたいステージを選ぶだけ、だから簡単でしょ。<br>
              既に追加されているキャラクターについて変更したいときは、キャラクターページの「内容を編集する」で同じように選べるよ。<br>
            </span>
          </div>
          <div class="tutorial-talk">
            <img class="icon-talk img-circle" src="/img/tutorial/yuki_1.png">
            <span class="text-talk">
              なるほどー。<br>
              もう一つの方法っていうのは？
            </span>
          </div>
          <div class="tutorial-talk">
            <img class="icon-talk img-circle" src="/img/tutorial/selena_1.png">
            <span class="text-talk">
              ステージの方からもキャラクターを選ぶことができるんだよ。<br>
              さっき作ったステージのページを開いて、「キャラクター」タブを押してみて。
            </span>
          </div>
          <div class="tutorial-talk">
            <img class="icon-talk img-circle" src="/img/tutorial/yuki_1.png">
            <span class="text-talk">
              こんなボタンが出てきたぞ。<br><br>
              <img class="image-talk" src="/img/tutorial/content_7_1.png">
            </span>
          </div>
          <div class="tutorial-talk">
            <img class="icon-talk img-circle" src="/img/tutorial/selena_1.png">
            <span class="text-talk">
              そう。それを押してみると、キャラクターを選ぶ画面が出てくるよ。
            </span>
          </div>
          <div class="tutorial-talk">
            <img class="icon-talk img-circle" src="/img/tutorial/elena_1.png">
            <span class="text-talk">
              あら、ホント。<br>
              これも、さっきの画面と同じような感じで、キャラクターを選んで保存すればいいのかしら？<br><br>
              <img class="image-talk" src="/img/tutorial/content_7_2.png">
            </span>
          </div>
          <div class="tutorial-talk">
            <img class="icon-talk img-circle" src="/img/tutorial/selena_1.png">
            <span class="text-talk">
              その通り。
            </span>
          </div>

        </div>
      </div>

      <div class="box box-primary collapsed-box">
        <div class="box-header with-border tutorial-title clickable" data-widget="collapse">
          <h3 class="box-title">
            <i class="fa fa-check fa-fw"></i>
            【基本編＋】エピソードとキャラクターを関連付ける
          </h3>
        </div>
        <div class="box-body">

          <div class="tutorial-talk">
            <img class="icon-talk img-circle" src="/img/tutorial/selena_1.png">
            <span class="text-talk">
              実は、エピソードとキャラクターを関連付けることもできるんだ。
            </span>
          </div>
          <div class="tutorial-talk">
            <img class="icon-talk img-circle" src="/img/tutorial/elena_1.png">
            <span class="text-talk">
              もしかして、<b>キャラクターに関連のあるエピソードだけを並べたのが、さっき言ってた「キャラクターのタイムライン」になる</b>ってこと？
            </span>
          </div>
          <div class="tutorial-talk">
            <img class="icon-talk img-circle" src="/img/tutorial/selena_1.png">
            <span class="text-talk">
              そう！ そういうこと。<br>
              さっき、ステージにキャラクターを関連付けてたよね？<br>
              そのステージを開いて、エピソードの追加画面を出してみて。
            </span>
          </div>
          <div class="tutorial-talk">
            <img class="icon-talk img-circle" src="/img/tutorial/yuki_1.png">
            <span class="text-talk">
              えーと、「ステージの管理」からステージを選んで、「タイムラインにエピソードを追加」……っと。<br>
              お、これだな。<br><br>
              <img class="image-talk" src="/img/tutorial/content_8_1.png">
            </span>
          </div>
          <div class="tutorial-talk">
            <img class="icon-talk img-circle" src="/img/tutorial/elena_1.png">
            <span class="text-talk">
              ステージに関連付けてあるキャラクターだけがエピソードにも関連付けることができるのかしら？
            </span>
          </div>
          <div class="tutorial-talk">
            <img class="icon-talk img-circle" src="/img/tutorial/selena_1.png">
            <span class="text-talk">
              そうそう。<br>
              内容は何でもいいから、選んで登録してみてよ。
            </span>
          </div>
          <div class="tutorial-talk">
            <img class="icon-talk img-circle" src="/img/tutorial/yuki_1.png">
            <span class="text-talk">
              じゃあとりあえずタイトルだけ埋めて、キャラクターを選んで、登録……っと。<br>
              ステージに出てくるタイムラインはいつも通りだな？
            </span>
          </div>
          <div class="tutorial-talk">
            <img class="icon-talk img-circle" src="/img/tutorial/selena_1.png">
            <span class="text-talk">
              うん、そこはキャラクターの設定に関係なく表示されるよ。<br>
              じゃあ、今度はそのキャラクターのページに移動してみて。
            </span>
          </div>
          <div class="tutorial-talk">
            <img class="icon-talk img-circle" src="/img/tutorial/yuki_1.png">
            <span class="text-talk">
              今度は「キャラクター管理」からキャラクターを選んで……この「タイムライン」タブを見ればいいんだな？<br>
              ……お、さっき登録したエピソードが出てきたぞ。<br><br>
              <img class="image-talk" src="/img/tutorial/content_8_2.png">
            </span>
          </div>
          <div class="tutorial-talk">
            <img class="icon-talk img-circle" src="/img/tutorial/selena_1.png">
            <span class="text-talk">
              何だよ、デザートって。ボクに買って来いって？<br>
              まあそれはいいとして、キャラクターと関連付いているエピソードがこうやってキャラクターページにも出てくるようになっているんだ。<br>
              ただし、赤い「ラベル」にはキャラクターが設定できず、見ての通り、必ず表示されるようになっているよ。
            </span>
          </div>
        </div>
      </div>

      <div class="box box-primary collapsed-box">
        <div class="box-header with-border tutorial-title clickable" data-widget="collapse">
          <h3 class="box-title">
            <i class="fa fa-check fa-fw"></i>
            【応用編】「めんどくさい」使い方のヒント
          </h3>
        </div>
        <div class="box-body">

          <div class="tutorial-talk">
            <img class="icon-talk img-circle" src="/img/tutorial/selena_1.png">
            <span class="text-talk">
              じゃ、今度こそ応用編だね。<br>
              もう一度言うけど、普通に使う分にはここまでの内容でも充分だよ。<br>
              ここから先は、めんどくさい設定……じゃないな、こじらせた人……でもなくって、ええと……複雑な設定を作る人向けかな。
            </span>
          </div>
          <div class="tutorial-talk">
            <img class="icon-talk img-circle" src="/img/tutorial/elena_1.png">
            <span class="text-talk">
              なかなか失礼な言い方するわね……<br>
              例えばどういう感じの使い方？
            </span>
          </div>
          <div class="tutorial-talk">
            <img class="icon-talk img-circle" src="/img/tutorial/selena_1.png">
            <span class="text-talk">
              例えばさ、マルチエンディングのゲームってやったことあるかい？
            </span>
          </div>
          <div class="tutorial-talk">
            <img class="icon-talk img-circle" src="/img/tutorial/elena_1.png">
            <span class="text-talk">
              マルチエンディング……？
            </span>
          </div>
          <div class="tutorial-talk">
            <img class="icon-talk img-circle" src="/img/tutorial/yuki_1.png">
            <span class="text-talk">
              わかるわかる。元々は一つのストーリーだけど、選択や進行具合によって複数のエンディングが用意されてるやつだろ？
            </span>
          </div>
          <div class="tutorial-talk">
            <img class="icon-talk img-circle" src="/img/tutorial/selena_1.png">
            <span class="text-talk">
              それそれ。<br>
              それってつまり、ある二つのエンディングを比べてみると、少なくとも途中からは異なるエピソードが起こってるってことだよね？
            </span>
          </div>
          <div class="tutorial-talk">
            <img class="icon-talk img-circle" src="/img/tutorial/elena_1.png">
            <span class="text-talk">
              まあ、そうなるわよね。
            </span>
          </div>
          <div class="tutorial-talk">
            <img class="icon-talk img-circle" src="/img/tutorial/selena_1.png">
            <span class="text-talk">
              そういう世界を表現したいとき、それぞれを独立したステージとして作ってしまえば、それぞれのタイムラインを作れるでしょ？
            </span>
          </div>
          <div class="tutorial-talk">
            <img class="icon-talk img-circle" src="/img/tutorial/elena_1.png">
            <span class="text-talk">
              ……なるほどね。わかってきたかも。<br>
              なんでステージとキャラクターはバラバラに作るようになってるんだろう、って思ってたけど……<br>
              <b>ある一人のキャラクターを複数のステージに関連付けて、それぞれでルートを作れるようになってる</b>ってことなのね……。
            </span>
          </div>
          <div class="tutorial-talk">
            <img class="icon-talk img-circle" src="/img/tutorial/selena_1.png">
            <span class="text-talk">
              その通り。<br>
              だって、複数のステージに同じキャラクターが出てくるとき、ステージ別にキャラクターを登録し直すのも大変でしょ？<br>
              もちろん、ラベルなんかを駆使して一つのステージで済ませることもできるから、作る人の匙加減だけどね。
            </span>
          </div>

        </div>
      </div>

      <div class="box box-primary collapsed-box">
        <div class="box-header with-border tutorial-title clickable" data-widget="collapse">
          <h3 class="box-title">
            <i class="fa fa-check fa-fw"></i>
            【応用編】キャラクタープロフィールの「オーバーライド」
          </h3>
        </div>
        <div class="box-body">

          <div class="tutorial-talk">
            <img class="icon-talk img-circle" src="/img/tutorial/selena_1.png">
            <span class="text-talk">
              じゃあ一番めんどくさいのやるけど、心の準備はいいかい？
            </span>
          </div>
          <div class="tutorial-talk">
            <img class="icon-talk img-circle" src="/img/tutorial/elena_1.png">
            <span class="text-talk">
              心の準備……
            </span>
          </div>
          <div class="tutorial-talk">
            <img class="icon-talk img-circle" src="/img/tutorial/selena_1.png">
            <span class="text-talk">
              キャラクタープロフィールの「オーバーライド」っていう機能があるんだ。<br>
              たとえばここに、普通のキャラクタープロフィールがあるでしょ。<br><br>
              <img class="image-talk" src="/img/tutorial/content_10_1.png">
            </span>
          </div>
          <div class="tutorial-talk">
            <img class="icon-talk img-circle" src="/img/tutorial/yuki_1.png">
            <span class="text-talk">
              ふむふむ。
            </span>
          </div>
          <div class="tutorial-talk">
            <img class="icon-talk img-circle" src="/img/tutorial/selena_1.png">
            <span class="text-talk">
              で、このキャラクターを関連付けしているステージでは、<br>
              「そのステージでしか使わないプロフィール」でこれを上書きすることができるんだ。
            </span>
          </div>
          <div class="tutorial-talk">
            <img class="icon-talk img-circle" src="/img/tutorial/elena_1.png">
            <span class="text-talk">
              どういうこと……？
            </span>
          </div>
          <div class="tutorial-talk">
            <img class="icon-talk img-circle" src="/img/tutorial/selena_1.png">
            <span class="text-talk">
              ステージのキャラクタータブに、そこに関連付けされているキャラクターの一覧が表示されるよね？<br>
              キャラクターの名前をクリックすると、メニューが出てくるはずだ。<br>
              そこから「プロフィールをオーバーライドする」を選ぶと、またプロフィールの設定画面が出てくる。<br><br>
              <img class="image-talk" src="/img/tutorial/content_10_2.png">
            </span>
          </div>
          <div class="tutorial-talk">
            <img class="icon-talk img-circle" src="/img/tutorial/elena_1.png">
            <span class="text-talk">
              うーんと、これね。<br><br>
              <img class="image-talk" src="/img/tutorial/content_10_3.png">
            </span>
          </div>
          <div class="tutorial-talk">
            <img class="icon-talk img-circle" src="/img/tutorial/selena_1.png">
            <span class="text-talk">
              うん。操作方法は普通のプロフィール設定と同じだけど、<b>ここで設定した項目は、このステージ内でのみ有効になる</b>んだ。<br>
              ここで設定されていない項目は、自動的に元のプロフィールが使われるようになっているよ。
            </span>
          </div>
          <div class="tutorial-talk">
            <img class="icon-talk img-circle" src="/img/tutorial/elena_1.png">
            <span class="text-talk">
              「ステージによってちょっと設定が違うキャラクター」なら、<b>共通してる項目を全部設定し直す必要がない</b>ってことね。
            </span>
          </div>
          <div class="tutorial-talk">
            <img class="icon-talk img-circle" src="/img/tutorial/yuki_1.png">
            <span class="text-talk">
              なるほどなあ。ほら、設定を追加してみたぞ。<br><br>
              <img class="image-talk" src="/img/tutorial/content_10_4.png">
            </span>
          </div>
          <div class="tutorial-talk">
            <img class="icon-talk img-circle" src="/img/tutorial/elena_1.png">
            <span class="text-talk">
              ちょっと！ アタシの設定で遊ばないでよ。
            </span>
          </div>
          <div class="tutorial-talk">
            <img class="icon-talk img-circle" src="/img/tutorial/selena_1.png">
            <span class="text-talk">
              背景が黒くなっている項目は「このステージでオーバーライドされている」というしるしだよ。<br>
              オーバーライドの操作はこれだけ。<br>
              <br>
              あ、キャラクターとステージの両方が「公開」設定になっている場合は、ステージの公開用ページのここから見てもらうことができるよ。<br>
              もちろんこの先のURLを直接誰かに教えてもいいし。<br><br>
              <img class="image-talk" src="/img/tutorial/content_10_5.png">
            </span>
          </div>
          <div class="tutorial-talk">
            <img class="icon-talk img-circle" src="/img/tutorial/elena_1.png">
            <span class="text-talk">
              え、これだけ？<br>
              てっきり、もっとめんどくさいものかと。
            </span>
          </div>
          <div class="tutorial-talk">
            <img class="icon-talk img-circle" src="/img/tutorial/selena_1.png">
            <span class="text-talk">
              めんどくさいのは操作じゃなくてオーバーライドの概念だから……。<br>
              <br>
              <b>ステージによってちょっと違う設定があるキャラクターについて、<br>
              全く別のプロフィールを用意したり書き換えるんじゃなくて、上に重ねる概念</b>だってことが分かってもらえればいいよ。<br>
              デジタルの絵を描く人なら「レイヤー」みたいなイメージだって言っても伝わるかな？
            </span>
          </div>
          <div class="tutorial-talk">
            <img class="icon-talk img-circle" src="/img/tutorial/yuki_1.png">
            <span class="text-talk">
              おう、わかった気がする。<br>
              ところでさっき、「タイムライン内のキャラクタープロフィールの変化に対応できる」って言ってなかったか？
            </span>
          </div>
          <div class="tutorial-talk">
            <img class="icon-talk img-circle" src="/img/tutorial/selena_1.png">
            <span class="text-talk">
              よく覚えてたね。そう、オーバーライドにはもう一つあるんだ。<br>
              そうだね、例えば……一番簡単なところだと、「年齢」ってもちろん時間の経過で変わるでしょ？
            </span>
          </div>
          <div class="tutorial-talk">
            <img class="icon-talk img-circle" src="/img/tutorial/yuki_1.png">
            <span class="text-talk">
              そりゃそうだな。<br>
              あ、さっき「17歳」って書いちまったな……
            </span>
          </div>
          <div class="tutorial-talk">
            <img class="icon-talk img-circle" src="/img/tutorial/selena_1.png">
            <span class="text-talk">
              そのステージのタイムラインが始まった時点を17歳とすればいいんだよ。<br>
              ということで、「2年後のある時点のプロフィール」を作ってみようか。<br>
              まずはエピソードの追加画面を開いてみて。
            </span>
          </div>
          <div class="tutorial-talk">
            <img class="icon-talk img-circle" src="/img/tutorial/elena_1.png">
            <span class="text-talk">
              開いたわよ。……あ、「キャラクターのオーバーライド」ってボタンがあるわね。
            </span>
          </div>
          <div class="tutorial-talk">
            <img class="icon-talk img-circle" src="/img/tutorial/selena_1.png">
            <span class="text-talk">
              そう。それを押すとこうなるでしょ。<br>
              タイトルは入れても入れなくてもいいから、次に進んでみて。<br><br>
              <img class="image-talk" src="/img/tutorial/content_10_6.png">
            </span>
          </div>
          <div class="tutorial-talk">
            <img class="icon-talk img-circle" src="/img/tutorial/yuki_1.png">
            <span class="text-talk">
              お、別の画面になった。<br>
              紫色のキャラクターの名前のところを押したら、またプロフィール設定ができそうなところが出てきたぞ。<br><br>
              <img class="image-talk" src="/img/tutorial/content_10_7.png">
            </span>
          </div>
          <div class="tutorial-talk">
            <img class="icon-talk img-circle" src="/img/tutorial/selena_1.png">
            <span class="text-talk">
              それそれ。<br>
              ここで設定したプロフィールは「この時点のプロフィール」として、ステージのオーバーライドに対して、さらにオーバーライドすることができるんだ。
            </span>
          </div>
          <div class="tutorial-talk">
            <img class="icon-talk img-circle" src="/img/tutorial/yuki_1.png">
            <span class="text-talk">
              よし、適当に設定を追加して、っと。<br>
              これを他の人に見せたいときはどうすればいいんだ？<br><br>
              <img class="image-talk" src="/img/tutorial/content_10_8.png">
            </span>
          </div>
          <div class="tutorial-talk">
            <img class="icon-talk img-circle" src="/img/tutorial/selena_1.png">
            <span class="text-talk">
              まず、この<b>ステージ・エピソード・キャラクターの全部が「公開」設定になっていないと他の人からは見えない</b>から注意してね。<br>
              ステージの公開ページ内のタイムラインで、こんな風に表示されるから、ここから見てもらうことができるよ。<br><br>
              <img class="image-talk" src="/img/tutorial/content_10_9.png">
            </span>
          </div>
          <div class="tutorial-talk">
            <img class="icon-talk img-circle" src="/img/tutorial/elena_1.png">
            <span class="text-talk">
              なるほど……って、そんなの公開しないでよ！
            </span>
          </div>

        </div>
      </div>

      <div class="box box-primary collapsed-box">
        <div class="box-header with-border tutorial-title clickable" data-widget="collapse">
          <h3 class="box-title">
            <i class="fa fa-check fa-fw"></i>
            最後に
          </h3>
        </div>
        <div class="box-body">

          <div class="tutorial-talk">
            <img class="icon-talk img-circle" src="/img/tutorial/selena_1.png">
            <span class="text-talk">
              ということで、チュートリアルはここまでだよ。<br>
              全部の機能を説明したわけじゃないから、もし分からないことがあれば、気軽に作者に聞いちゃってね。
              <p style="background: #999999; border-radius: 5px; padding: 10px; margin: 5px;">
                ◆個別にお返事が必要な場合<br>
                <small>　　Twitter <a href="http://twitter.com/smtk_tks/">@smtk_tks</a></small><br>
                ◆お返事が不要な場合・匿名にしたい場合<br>
                <small>　　トップページにあるフォーム または メニュー内の「リクエストボックス」</small><br>
                <br>
                あくまで、趣味で作った個人サイトです。応えきれない場合は申し訳ありませんがご了承ください。
              </p>
            </span>
          </div>

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
<!-- JS end -->
</body>
</html>
