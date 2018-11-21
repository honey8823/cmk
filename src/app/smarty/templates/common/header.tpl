  <!-- Main Header start -->
  <header class="main-header" id="page_top">

    <!-- Logo -->
    <a href="/" class="logo">
      <span class="logo-mini">{$smarty.const.SITE_NAME_SHORT}</span>
      <span class="logo-lg">{$smarty.const.SITE_NAME_FULL}</span>
    </a>

    <!-- Header Navbar -->
    <nav class="navbar navbar-static-top" role="navigation">

      <!-- Sidebar toggle button-->
      <a href="#" class="sidebar-toggle" data-toggle="push-menu" role="button">
        <span class="sr-only">Toggle</span>
      </a>

      <div class="navbar-custom-menu">

        <ul class="nav navbar-nav">
          <li class="dropdown notifications-menu">
            <a href="/user/notice/">
            {if isset($user_session.unread_count) && $user_session.unread_count > 0}
              <i class="fa fa-bell"></i>
              <span class="label label-danger">{$user_session.unread_count}</span>
            {else}
              <i class="fa fa-bell-o"></i>
            {/if}
            </a>
          </li>
        </ul>
{***
        <!-- search form (Optional) -->
        <form action="#" method="get" class="navbar-form">
          <div class="input-group">
            <input type="text" name="q" class="form-control" placeholder="検索（β版実装）">
            <span class="input-group-btn">
              <button type="submit" name="search" id="search-btn" class="btn btn-flat"><i class="fa fa-search"></i></button>
            </span>
          </div>
        </form>
        <!-- /.search form -->
***}
      </div>

    </nav>

  </header>
  <!-- Main Header end -->