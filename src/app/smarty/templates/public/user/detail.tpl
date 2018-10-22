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
      <h1>{$user.name}@{$user.login_id}</h1>
      <ol class="breadcrumb">
        <li><a href="/">トップ</a></li>
        <li class="active">{$user.name}@{$user.login_id}</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="row">

        <div class="col-md-12">
          <div class="box">
            <div class="box-body">
              <div><label>ジャンル</label><span></span></div>
              <div><label>Twitter</label><span><a href="//twitter.com/{$user.twitter_id}" target="_blank">@{$user.twitter_id}</a></span></div>
              {*** <div><label>最終ログイン</label><span></span></div> ***}
            </div>
          </div>
        </div>

        <div class="col-md-12">
          <div class="nav-tabs-custom">
            <ul class="nav nav-tabs">
              <li class="active"><a href="#tab-content-stage" data-toggle="tab" aria-expanded="true">ステージ</a></li>
              <li class=""><a href="#tab-content-character" data-toggle="tab" aria-expanded="false">キャラクター</a></li>
            </ul>
            <div class="tab-content">
              <div class="tab-pane active" id="tab-content-stage">
                <ul>
                {foreach from=$stage_list key=k item=v_stage}
                  <li>
                    {$v_stage.id} {$v_stage.name} {$v_stage.remarks}
                  </li>
                {/foreach}
                </ul>
              </div>
              <div class="tab-pane" id="tab-content-character">
                <ul>
                {foreach from=$character_list key=k item=v_character}
                  <li>
                    {$v_character.id} {$v_character.name}
                  </li>
                {/foreach}
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
<script src="/js/lib/jquery.ui.touch-punch.min.js"></script>
<script src="/js/common.js"></script>
<script src="/js/sidebar.js"></script>
<!-- JS end -->
</body>
</html>