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
      <!-- <h1>sandbox</h1> -->
    </section>

    <!-- Main content -->
    <section class="content container-fluid">
      <div class="callout callout-info">
        <h4>管理用ページ</h4>
        <p><small>IPアドレス：{$ip_address}</small></p>
      </div>

        <div class="col-md-12">
          <div class="nav-tabs-custom">
            <ul class="nav nav-tabs">
              <li class="active"><a href="#tab-content-contact" data-toggle="tab" aria-expanded="false">匿名フォーム</a></li>
              <li class=""><a href="#tab-content-user" data-toggle="tab" aria-expanded="true">ユーザー</a></li>
              <li class=""><a href="#tab-content-stage" data-toggle="tab" aria-expanded="true">ステージ</a></li>
              <li class=""><a href="#tab-content-character" data-toggle="tab" aria-expanded="true">キャラクター</a></li>
            </ul>
            <div class="tab-content">

              <div class="tab-pane active" id="tab-content-contact">
                <ul class="nav nav-stacked">
                {foreach from=$contact_list key=k item=contact}
                  <li>
                    <a>
                      [{$contact.id}]{$contact.create_stamp} {$contact.content|escape:'html'}
                    </a>
                  </li>
                {/foreach}
                </ul>
              </div>

              <div class="tab-pane" id="tab-content-user">
                <ul class="nav nav-stacked">
                {foreach from=$user_list key=k item=user}
                  <li>
                    <a>
                      [{$user.id}]{$user.login_stamp} {$user.name|escape:'html'}
                    </a>
                  </li>
                {/foreach}
                </ul>
              </div>

              <div class="tab-pane" id="tab-content-stage">
                <ul class="nav nav-stacked">
                {foreach from=$stage_list key=k item=stage}
                  <li>
                    <a>
                      [{$stage.id}]{$stage.name|escape:'html'} {$stage.remarks|escape:'html'}
                    </a>
                  </li>
                {/foreach}
                </ul>
              </div>

              <div class="tab-pane" id="tab-content-character">
                <ul class="nav nav-stacked">
                {foreach from=$character_list key=k item=character}
                  <li>
                    <a>
                      [{$character.id}]{$character.name|escape:'html'} {$character.remarks|escape:'html'}
                    </a>
                  </li>
                {/foreach}
                </ul>
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
<script src="/js/contact.js"></script>
<!-- JS end -->
</body>
</html>
