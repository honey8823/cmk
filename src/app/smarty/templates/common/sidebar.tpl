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
          <p><i class="fa fa-bell-o fa-fw" aria-hidden="true"></i><span>0</span></p>
        </div>
      </div>

      <!-- Sidebar Menu -->
      <ul class="sidebar-menu logged-in" data-widget="tree">
        <li>
          <a href="/user/list.php">
            <i class="fa fa-file-text" aria-hidden="true"></i> <span>キャラクター管理</span>
          </a>
        </li>
        <li>
          <a href="/user/stage.php">
            <i class="fa fa-file-text" aria-hidden="true"></i> <span>ステージ管理</span>
          </a>
        </li>
        <li>
          <a href="#" data-toggle="modal" data-target="#modal-setUser" onclick="setUserForm();">
            <i class="fa fa-user-circle" aria-hidden="true"></i> <span>アカウント管理</span>
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
          <a href="#">
            <i class="fa fa-question-circle" aria-hidden="true"></i> <span>このサイトについて</span>
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

  <!-- アカウント管理modal -->
  <div class="modal fade" id="modal-setUser">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span></button>
          <h4 class="modal-title">アカウント管理</h4>
        </div>
        <div class="modal-body">
          <div>
            <label>ログインID（公開 / 必須）</label>
            <input type="text" name="login_id" class="form-login_id">
          </div>
          <div>
            <label>ユーザー名（公開）</label>
            <input type="text" name="mail_name" class="form-name">
          </div>
          <div>
            <label>Twitter ID（公開）</label>
            <input type="text" name="mail_address" class="form-twitter_id">
          </div>
          <div>
            <label>メールアドレス（非公開）</label>
            <input type="text" name="mail_address" class="form-mail_address">
          </div>
          <div>
            <label>パスワード（非公開 / 変更する場合のみ）</label>
            <input type="password" name="password" class="form-password">
          </div>
          <div>
            <label>パスワード（非公開 / 変更する場合のみもう一度）</label>
            <input type="password" name="password_c" class="form-password_c">
          </div>
          <div>
            ※メールアドレスをご入力いただいた場合は以下の対応が可能になります。
            <ul>
              <li>パスワードを忘れた場合の照会</li>
              <li>退会後のデータ復旧</li>
            </ul>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default pull-left" data-dismiss="modal">キャンセル</button>
          <button type="button" class="btn btn-warning" onclick="delUser();">退会</button>
          <button type="button" class="btn btn-primary" onclick="setUser();">変更</button>
        </div>
      </div>
    </div>
  </div>