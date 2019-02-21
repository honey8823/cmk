  <!-- Left side column start -->

  <aside class="main-sidebar">
    <section class="sidebar">

    {* ユーザ情報 *}
    {if isset($user_session.id)}
      <div class="user-panel">
        <div class="pull-left image">
        {if !isset($user_session.image) || $user_session.image == ""}
          <img src="/img/icon_noimage.png" class="img-circle" alt="User Image">
        {else}
          <img src="data:image/png;base64,{$user_session.image}" class="img-circle" alt="User Image">
        {/if}
        </div>
        <div class="pull-left info">
          <p class="textdata-user-name"><a href="/public/user/detail.php?u={$user_session.login_id}">{if $user_session.name == ""}(ユーザー名未設定){else}{$user_session.name}{/if}</a></p>
        </div>
      </div>
    {/if}

    {* メニュー *}
      <ul class="sidebar-menu" data-widget="tree">

      {if isset($user_session.id)}
        <li class="header">うちのこタイムライン</li>
        <li>
          <a href="/user/stage/">
            <i class="fa fa-fw fa-globe" aria-hidden="true"></i><span>ステージ管理</span>
          </a>
        </li>
        <li>
          <a href="/user/character/">
            <i class="fa fa-fw fa-user" aria-hidden="true"></i><span>キャラクター管理</span>
          </a>
        </li>
      {/if}

        <li class="header">よそのこタイムライン</li>
      {if isset($user_session.id)}
        <li>
          <a href="/user/favorite.php">
            <i class="fa fa-fw fa-heart" aria-hidden="true"></i><span>お気に入り</span>
          </a>
        </li>
      {/if}
        <li>
          <a href="#">
            <i class="fa fa-fw fa-search" aria-hidden="true"></i><span>検索<small>＜そのうち実装＞</small></span>
          </a>
        </li>

        <li class="header">その他</li>
      {if isset($user_session.is_admin) && $user_session.is_admin == 1}
        <li>
          <a href="/admin/">
            <i class="fa fa-fw fa-cog" aria-hidden="true"></i><span>管理ページ</span>
          </a>
        </li>
      {/if}
        <li>
          <a href="/information.php">
            <i class="fa fa-fw fa-exclamation-circle" aria-hidden="true"></i><span>お知らせ</span>
          </a>
        </li>
        <li>
          <a href="/help.php">
            <i class="fa fa-fw fa-question-circle" aria-hidden="true"></i><span>ヘルプ</span>
          </a>
        </li>
        <li>
          <a href="#" data-toggle="modal" data-target="#modal-request">
            <i class="fa fa-fw fa-archive" aria-hidden="true"></i><span>リクエストボックス</span>
          </a>
        </li>
      {if isset($user_session.id)}
        <li>
          <a href="/user/account.php">
            <i class="fa fa-fw fa-user-circle" aria-hidden="true"></i><span>アカウント管理</span>
          </a>
        </li>
        <li>
          <a href="#" onclick="logout()";>
            <i class="fa fa-fw fa-sign-out" aria-hidden="true"></i><span>ログアウト</span>
          </a>
        </li>
      {else}
        <li>
          <a href="#" data-toggle="modal" data-target="#modal-login">
            <i class="fa fa-fw fa-sign-in" aria-hidden="true"></i><span>ログイン</span>
          </a>
        </li>
        <li>
          <a href="#" data-toggle="modal" data-target="#modal-addUser">
            <i class="fa fa-fw fa-user-plus" aria-hidden="true"></i><span>新規登録</span>
          </a>
        </li>
      {/if}
      </ul>
    </section>
  </aside>

  <!-- Left side column end -->

  <!-- 新規登録modal -->
  <div class="modal fade" id="modal-addUser">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span></button>
          <h4 class="modal-title">新規登録</h4>
        </div>
        <div class="modal-body">

          <div class="form-group">
            <label>希望のログインID(4～32文字、半角の英数と一部記号のみ使用可)</label>
            <input type="text" name="login_id" class="form-control form-login_id">
          </div>
          <div class="form-group">
            <label>パスワード(4～32文字、半角の英数と一部記号のみ使用可)</label>
            <input type="password" name="password" class="form-control form-password">
          </div>
          <div class="form-group">
            <label>パスワード(もう一度)</label>
            <input type="password" name="password_c" class="form-control form-password_c">
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default pull-left" data-dismiss="modal">キャンセル</button>
          <button type="button" class="btn btn-primary" onclick="addUser();">会員登録</button>
        </div>
      </div>
    </div>
  </div>

  <!-- ログインmodal -->
  <div class="modal fade" id="modal-login">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span></button>
          <h4 class="modal-title">ログイン</h4>
        </div>
        <div class="modal-body">
          <div class="form-group">
            <label>ログインID</label>
            <input type="text" name="login_id" class="form-control form-login_id">
          </div>
          <div class="form-group">
            <label>パスワード</label>
            <input type="password" name="password" class="form-control form-password">
          </div>
          <div class="checkbox">
            <label>
              <input type="checkbox" class="form-cookie"> 自動ログインを有効にする（α版）
            </label>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default pull-left" data-dismiss="modal">キャンセル</button>
          <button type="button" class="btn btn-primary btn-login" onclick="login();">ログイン</button>
        </div>
      </div>
    </div>
  </div>

  <!-- リクエストmodal -->
  <div class="modal fade" id="modal-request">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
          <h4 class="modal-title">リクエストボックス</h4>
        </div>
        <div class="modal-body">
          <p class="hint-box">
            欲しいものをお気軽にリクエストしていってください。
          </p>
          <div class="form-group">
            <label>カテゴリ</label>
            <select class="form-control form-category" name="category">
              <option value="none">未選択（下記に記載ください）</option>
              <option value="genre">ジャンル（対応するタグも併せてご指定いただけると助かります）</option>
              <option value="tag-series">作品タグ（属するジャンルも併せてご指定いただけると助かります）</option>
              <option value="character_profile">プロフィール項目</option>
              <option value="system">機能・バグ修正</option>
            </select>
          </div>
          <div class="form-group">
            <label>ほしいもの</label>
            <textarea class="form-control form-free_text" rows="3" name="form-control free_text"></textarea>
          </div>
          <div class="text-align-right"><small><a href="/public/stage/detail.php?user=sample_account&id=185#timeline">※ご要望への回答はこちら</a></small></div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default pull-left" data-dismiss="modal">キャンセル</button>
          <button type="button" class="btn btn-primary" onclick="addContactRequest();">リクエストする</button>
        </div>
      </div>
    </div>
  </div>
