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
        <li class="header">自分のまとめを管理する</li>
        <li>
          <a href="/user/stage/">
            <i class="fa fa-file-text" aria-hidden="true"></i> <span>ステージ管理</span>
          </a>
        </li>
        <li>
          <a href="/user/character/">
            <i class="fa fa-file-text" aria-hidden="true"></i> <span>キャラクター管理</span>
          </a>
        </li>
        <li class="header">他人のまとめを見る</li>
        <li>
          <a href="#">
            <i class="fa fa-file-text" aria-hidden="true"></i> <span>フォロー</span><small>＜β版実装＞</small>
          </a>
        </li>
        <li>
          <a href="#">
            <i class="fa fa-file-text" aria-hidden="true"></i> <span>お気に入り</span><small>＜β版実装＞</small>
          </a>
        </li>
        <li class="header">アカウント・その他</li>
        <li>
          <a href="/help.php">
            <i class="fa fa-question-circle" aria-hidden="true"></i> <span>ヘルプ</span>
          </a>
        </li>
        <li>
          <a href="/user/account.php">
            <i class="fa fa-user-circle" aria-hidden="true"></i> <span>アカウント情報</span>
          </a>
        </li>
        <li>
          <a href="#" onclick="logout()";>
            <i class="fa fa-sign-out" aria-hidden="true"></i> <span>ログアウト</span>
          </a>
        </li>
      </ul>
      <ul class="sidebar-menu logged-out" data-widget="tree">
        <li>
          <a href="/help.php">
            <i class="fa fa-question-circle" aria-hidden="true"></i> <span>ヘルプ</span>
          </a>
        </li>
        <li>
          <a href="#" data-toggle="modal" data-target="#modal-login">
            <i class="fa fa-sign-in" aria-hidden="true"></i> <span>ログイン</span>
          </a>
        </li>
        <li>
          <a href="#" data-toggle="modal" data-target="#modal-addUser">
            <i class="fa fa-user-plus" aria-hidden="true"></i> <span>新規登録</span>
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
          <div>
            <label>希望のログインID(4～32文字、半角の英数と一部記号のみ使用可)</label>
            <input type="text" name="login_id" class="form-login_id">
          </div>
          <div>
            <label>パスワード(4～32文字、半角の英数と一部記号のみ使用可)</label>
            <input type="password" name="password" class="form-password">
          </div>
          <div>
            <label>パスワード(もう一度)</label>
            <input type="password" name="password_c" class="form-password_c">
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
          <div>
            <label>ログインID</label>
            <input type="text" name="login_id" class="form-login_id">
          </div>
          <div>
            <label>パスワード</label>
            <input type="password" name="password" class="form-password">
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default pull-left" data-dismiss="modal">キャンセル</button>
          <button type="button" class="btn btn-primary" onclick="login();">ログイン</button>
        </div>
      </div>
    </div>
  </div>