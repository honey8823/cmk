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
      <h1>お気に入り</h1>
      <ol class="breadcrumb">
        <li><a href="/">トップ</a></li>
        <li class="active">お気に入り</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="row">
        <div class="col-md-12">

        {foreach from=$favorite_type_list key=k_type item=v_type}
          <div class="box box-danger">
            <div class="box-header with-border clickable" data-widget="collapse">
              <h3 class="box-title">{$v_type.name|escape:'html'}</h3>
            </div>
            <div class="box-body no-padding">
              <ul class="nav nav-stacked ul-favorite">
              {if isset($v_type.favorite_list) && is_array($v_type.favorite_list) && count($v_type.favorite_list) > 0}
              {foreach from=$v_type.favorite_list key=k_favorite item=v_favorite}
              {if $v_favorite.is_private == 1 || $v_favorite.is_delete == 1 || $v_favorite.user_is_delete == 1}
                <li class="notlink">
                  <a>
                    <i class="fa fa-fw fa-heart-o is_favorite_icon clickable is_favorite_0 pull-right hidden" aria-hidden="true" data-favorite_type_key="{$v_type.key}" data-id="{$v_favorite.id}"></i>
                    <i class="fa fa-fw fa-heart is_favorite_icon clickable is_favorite_1 pull-right" aria-hidden="true" data-favorite_type_key="{$v_type.key}" data-id="{$v_favorite.id}"></i>
                    <span>削除された、もしくは非公開になった{$v_type.name|escape:'html'}です</span>
                  </a>
                </li>
              {else}
                <li>
                {if $v_type.key == "user"}
                  <a href="/public/user/detail.php?u={$v_favorite.login_id}">
                {else}
                  <a href="/public/{$v_type.key}/detail.php?user={$v_favorite.user_login_id}&id={$v_favorite.id}">
                {/if}
                    <i class="fa fa-fw fa-heart-o is_favorite_icon clickable is_favorite_0 pull-right hidden" aria-hidden="true" data-favorite_type_key="{$v_type.key}" data-id="{$v_favorite.id}"></i>
                    <i class="fa fa-fw fa-heart is_favorite_icon clickable is_favorite_1 pull-right" aria-hidden="true" data-favorite_type_key="{$v_type.key}" data-id="{$v_favorite.id}"></i>
                    <span>{$v_favorite.name|escape:'html'}{if $v_favorite.login_id != ""}<small> @{$v_favorite.login_id}</small>{/if}</span>
                  {if $v_favorite.user_name != "" || $v_favorite.user_login_id != ""}
                    <span class="author">by {$v_favorite.user_name} @{$v_favorite.user_login_id}</span>
                  {/if}
                  </a>
                </li>
              {/if}
              {/foreach}
              {else}
                <li class="notlink"><a><span>（お気に入り{$v_type.name|escape:'html'}はありません）</span></a></li>
              {/if}
              </ul>
            </div>
          </div>
        {/foreach}

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
<script src="/js/common.js"></script>
<script src="/js/sidebar.js"></script>
<script src="/js/favorite.js"></script>
<!-- JS end -->
</body>
</html>