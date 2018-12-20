<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>{$smarty.const.SITE_NAME_FULL}</title>
  {include file='common/adminlte_css.tpl'}
  {include file='common/common_public_css.tpl'}
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
      <h1>検索</h1>
      <ol class="breadcrumb">
        <li><a href="/">トップ</a></li>
        <li class="active">検索</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="row">

        <div class="col-md-12">
          <div class="nav-tabs-custom">
            <ul class="nav nav-tabs">
              <li class="active"><a href="#tab-content-stage" data-toggle="tab" aria-expanded="true">ステージ</a></li>
              <li class=""><a href="#tab-content-character" data-toggle="tab" aria-expanded="false">キャラクター</a></li>
              <li class=""><a href="#tab-content-user" data-toggle="tab" aria-expanded="false">ユーザー</a></li>
            </ul>
            <div class="tab-content">
              <div class="tab-pane active" id="tab-content-stage">
                <ul class="nav nav-stacked">
                  <li>
                    <a href="/public/stage/detail.php?user=◆◆◆&id=◆◆◆">
                      <span class="name">◆◆◆◆</span>
                      <small><span class="name">by ◆◆◆◆</span></small>
                      <span class="tag">
                        <span class="label tag tag-series">◆◆◆</span>
                        <span class="label tag tag-caution">◆◆◆</span>
                      </span>
                    </a>
                  </li>
                </ul>
              </div>
              <div class="tab-pane" id="tab-content-character">
                <ul class="nav nav-stacked">
                  <li>
                    <a href="/public/character/detail.php?user=◆◆◆◆&id=◆◆◆◆">
                      <div class="character-list-grid">
                        <p class="character-list-grid-image">
                          <img src="/img/icon_noimage.png" class="img-rounded character-image-list">
                        </p>
                        <p class="character-list-grid-name">◆◆◆◆<small><span class="name">by ◆◆◆◆</span></small></p>
                        <p class="character-list-grid-remarks"><span class="badge stage">◆◆◆◆</span>◆◆◆◆</p>
                      </div>
                    </a>
                  </li>
                </ul>
              </div>
              <div class="tab-pane" id="tab-content-user">
                <ul class="nav nav-stacked">
                  <li>
                    <a href="/public/user/detail.php?u=◆◆◆◆">
                      <div class="character-list-grid">
                        <p class="character-list-grid-image">
                          <img src="/img/icon_noimage.png" class="img-circle character-image-list">
                        </p>
                        <p class="character-list-grid-name">◆◆◆◆</p>
                        <p class="character-list-grid-remarks"><span class="label-genre">◆◆◆◆</span></p>
                      </div>
                    </a>
                  </li>
                </ul>
              </div>
            </div>
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
