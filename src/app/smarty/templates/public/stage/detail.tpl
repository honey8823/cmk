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
      <h1>{$stage.name}</h1>
      <small>{$stage.user_name}@{$stage.user_login_id}</small>
      <ol class="breadcrumb">
        <li><a href="/">トップ</a></li>
        <li><a href="#">{$stage.user_name}@{$stage.user_login_id}</a></li> {*** todo:: /public/stage/?user=** にリンク ***}
        <li class="active">{$stage.name}</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="row">

        <div class="col-md-12">
          <div class="box">
            <div class="box-body">
            {foreach from=$series_list key=k item=v_series}
            {if isset($stage.tag_list) && is_array($stage.tag_list) && in_array($v_series.id, array_column($stage.tag_list, 'id'))}
              <span class="label tag-base tag-series" value="{$v_series.id}">{$v_series.name}</span>
            {/if}
            {/foreach}
            </div>
            <div class="box-body public-stage-remarks">
              {$stage.remarks|nl2br}
            </div>
          </div>
        </div>

        <div class="col-md-12">
          <div class="nav-tabs-custom">
            <ul class="nav nav-tabs">
              <li class="active"><a href="#tab-content-timeline" data-toggle="tab" aria-expanded="true">タイムライン</a></li>
              {*** <li class=""><a href="#tab-content-character" data-toggle="tab" aria-expanded="false">キャラクター</a></li> ***}
            </ul>
            <div class="tab-content">

              <div class="tab-pane active" id="tab-content-timeline">
                <ul class="timeline timeline-stage">
                {foreach from=$stage.episode_list key=k item=v_episode}
                {if $v_episode.is_label == "1"}
                  <li class="time-label timeline-label"><span class="bg-red timeline-title">{$v_episode.title}</span></li>
                {else}
                  <li class="timeline-content">
                    <i class="fa fa-arrow-right bg-blue"></i>
                    <div class="timeline-item">
                      {if $v_episode.title != ""}<h3 class="timeline-header timeline-title no-border">{$v_episode.title}</h3>{/if}
                    {if $v_episode.url != "" || $v_episode.free_text != ""}
                      <div class="timeline-body">
                        <small>
                          {if $v_episode.free_text != ""}<p class="timeline-free_text">{$v_episode.free_text|nl2br}</p>{/if}
                          {if $v_episode.url != ""}<p class="timeline-url"><a href="" target="_blank">{$v_episode.url}</a></p>{/if}
                        </small>
                      </div>
                    {/if}
                    </div>
                  </li>
                {/if}
                {/foreach}
                </ul>
              </div>
{***
              <div class="tab-pane" id="tab-content-character">
                {foreach from=$stage.character_list key=k item=v_character}
                  <li><a href="/user/character/edit.php?id={$v_character.id}">{$v_character.name}</a></li>
                {/foreach}
                </ul>
              </div>
***}
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