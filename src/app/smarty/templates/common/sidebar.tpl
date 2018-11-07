  <!-- Left side column start -->

  <aside class="main-sidebar">
    <section class="sidebar">
      <!-- Sidebar user panel (optional) -->
      <div class="user-panel logged-in">
        <div class="pull-left image">
          <img src="/img/icon_noimage.png" class="img-circle" alt="User Image">
        </div>
        <div class="pull-left info">
          <p class="textdata-user-name"></p>
          <p><a href="/user/notifications/"><i class="fa fa-bell-o fa-fw" aria-hidden="true"></i><span>0</span></a></p>
        </div>
      </div>

      <!-- Sidebar Menu -->
      <ul class="sidebar-menu logged-in" data-widget="tree">
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
        <li class="header">よそのこタイムライン</li>
        <li>
          <a href="/user/favorite.php">
            <i class="fa fa-fw fa-heart" aria-hidden="true"></i><span>お気に入り</span>
          </a>
        </li>
        <li class="header">その他</li>
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
      </ul>
      <ul class="sidebar-menu logged-out" data-widget="tree">
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
          <a href="#" data-toggle="modal" data-target="#modal-login">
            <i class="fa fa-fw fa-sign-in" aria-hidden="true"></i><span>ログイン</span>
          </a>
        </li>
        <li>
          <a href="#" data-toggle="modal" data-target="#modal-addUser">
            <i class="fa fa-fw fa-user-plus" aria-hidden="true"></i><span>新規登録</span>
          </a>
        </li>
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
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default pull-left" data-dismiss="modal">キャンセル</button>
          <button type="button" class="btn btn-primary" onclick="login();">ログイン</button>
        </div>
      </div>
    </div>
  </div>

  <!-- リクエストmodal -->
  <div class="modal fade" id="modal-request">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span></button>
          <h4 class="modal-title">リクエストボックス</h4>
        </div>
        <div class="modal-body">
          <p class="hint-box">欲しいものをお気軽にリクエストしていってください。</p>
          <div class="form-group">
            <label>カテゴリ</label>
            <select class="form-control form-category" name="category">
              <option value="none">未選択（下記に記載ください）</option>
              <option value="genre">ジャンル</option>
              <option value="tag-series">作品タグ</option>
              <option value="character_profile">プロフィール項目</option>
              <option value="system">機能・バグ修正</option>
            </select>
          </div>
          <div class="form-group">
            <label>ほしいもの</label>
            <textarea class="form-control form-free_text" rows="3" name="form-control free_text"></textarea>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default pull-left" data-dismiss="modal">キャンセル</button>
          <button type="button" class="btn btn-primary" onclick="addContactRequest();">リクエストする</button>
        </div>
      </div>
    </div>
  </div>