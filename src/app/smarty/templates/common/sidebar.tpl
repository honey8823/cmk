  <!-- Left side column start -->

  <aside class="main-sidebar">
    <section class="sidebar">

      <!-- Sidebar user panel (optional) -->
      <div class="user-panel">
        <div class="pull-left image">
          <img src="/js/adminlte_2.4.5/dist/img/user2-160x160.jpg" class="img-circle" alt="User Image">
        </div>
        <div class="pull-left info">
          <p>テストユーザ</p>
          <i class="fa fa-star" aria-hidden="true"></i>&nbsp;10
        </div>
      </div>

      <!-- Sidebar Menu -->
      <ul class="sidebar-menu" data-widget="tree">
        <li>
          <a href="#">
            <i class="fa fa-plus-circle" aria-hidden="true"></i> <span>レシピ登録</span>
          </a>
        </li>
        <li>
          <a href="#">
            <i class="fa fa-file-text" aria-hidden="true"></i> <span>レシピ管理</span>
          </a>
        </li>
        <li>
          <a href="#">
            <i class="fa fa-star" aria-hidden="true"></i> <span>お気に入りレシピ</span>
          </a>
        </li>
        <li>
          <a href="#">
            <i class="fa fa-user-circle" aria-hidden="true"></i> <span>プロフィール管理</span>
          </a>
        </li>
        <li>
          <a href="#">
            <i class="fa fa-sign-out" aria-hidden="true"></i> <span>ログアウト</span>
          </a>
        </li>
      </ul>

    </section>
    <section>

              <button type="button" class="btn btn-default" data-toggle="modal" data-target="#modal-regist">
                会員登録
              </button>
              <button type="button" class="btn btn-default" data-toggle="modal" data-target="#modal-login">
                ログイン
              </button>

    </section>
  </aside>

  <!-- Left side column end -->


  <!-- 新規登録modal -->
  <div class="modal fade" id="modal-regist">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span></button>
          <h4 class="modal-title">新規登録</h4>
        </div>
        <div class="modal-body">
          <div>
            <label>希望のログインID(256文字まで)</label>
            <input type="text" name="login_id" class="form-login_id">
            <p>メールアドレスをご入力いただいた場合、重要なお知らせをお送りする可能性があります。</p>
          </div>
          <div>
            <label>パスワード(4～32文字、半角の英数と一部記号のみ使用可)</label>
            <input type="text" name="password" class="form-password">
          </div>
          <div>
            <label>パスワード(確認用)</label>
            <input type="text" name="password_c" class="form-password_c">
          </div>
        </div>
        <div>
          <p>ログインIDについて</p>
          <p>
            ログインIDはお好きな文字列をご登録いただけます。<br>
            メールアドレスを登録いただいた場合、「パスワードを忘れた際の通知」「重要なお知らせ」をお送りいたします。
          </p>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default pull-left" data-dismiss="modal">キャンセル</button>
          <button type="button" class="btn btn-primary" onclick="regist();">会員登録</button>
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
            <input type="text" name="password" class="form-password">
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default pull-left" data-dismiss="modal">キャンセル</button>
          <button type="button" class="btn btn-primary" onclick="login();">ログイン</button>
        </div>
      </div>
    </div>
  </div>