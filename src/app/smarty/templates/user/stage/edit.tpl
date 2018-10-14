<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>{$smarty.const.SITE_NAME_FULL}</title>
  {include file='common/adminlte_css.tpl'}
  <link rel="stylesheet" href="/css/common.css">
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
      <h1>ステージ管理</h1>
      <ol class="breadcrumb">
        <li><a href="/">トップ</a></li>
        <li><a href="/user/stage/">ステージ管理</a></li>
        <li class="active">編集</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="row">

        <div class="col-md-6">
          <div class="box">
            <div class="box-header">
              <h3 class="box-title">基本情報</h3>
            </div>
            <div class="box-body" id="area-setStage">
              <input type="hidden" class="form-id" value="{$stage.id}">
              <div>
                <label>ステージ名</label><small>※必須</small>
                <input type="text" name="name" class="form-name" value="{$stage.name}">
              </div>
              <div>
                <label>説明文</label>
                <span class="menu-tooltip">
                  <i class="fa fa-question-circle fa-fw" aria-hidden="true"></i>
                  <span class="menu-tooltiptext">{$config.tooltip.stage_remarks}</span>
                </span>
                <textarea class="form-control form-remarks" rows="3" name="remarks">{$stage.remarks}</textarea>
              </div>
              <div>
                <label>関連するシリーズ（複数選択可）</label>
              {foreach from=$series_list key=k item=v_series}
              {if isset($stage.tag_list) && is_array($stage.tag_list) && in_array($v_series.id, array_column($stage.tag_list, 'id'))}
                <span class="label tag-base tag-series tag-selectable" value="{$v_series.id}">{$v_series.name}</span>
              {else}
                <span class="label tag-base tag-series tag-notselected tag-selectable" value="{$v_series.id}">{$v_series.name}</span>
              {/if}
              {/foreach}
              </div>
            </div>
            <div class="box-body">
              <button type="button" class="btn btn-primary{if $stage.is_private != 1} hidden{else}{/if}" onclick="setStageIsPrivate(0);">公開する<small>(現在非公開です)</small></button>
              <button type="button" class="btn btn-primary{if $stage.is_private == 1} hidden{else}{/if}" onclick="setStageIsPrivate(1);">非公開にする<small>(現在公開中です)</small></button>
            </div>
            <div class="box-body">
              <button type="button" class="btn btn-warning pull-right" onclick="delStage();">このステージを削除</button>
              <button type="button" class="btn btn-primary pull-right" onclick="setStage();">更新する</button>
            </div>
          </div>
        </div>

        <div class="col-md-6">
          <div class="nav-tabs-custom">
            <ul class="nav nav-tabs">
              <li class="active"><a href="#tab-content-timeline" data-toggle="tab" aria-expanded="true">タイムライン</a></li>
              <li class=""><a href="#tab-content-character" data-toggle="tab" aria-expanded="false">キャラクター</a></li>
            </ul>
            <div class="tab-content">
              <div class="tab-pane active" id="tab-content-timeline">
                <button type="button" class="btn btn-primary btn-block" data-toggle="modal" data-target="#modal-addEpisode">このステージのタイムラインにエピソードを追加する</button>
                <ul class="timeline template-for-copy" id="timeline_for_stage_template">
                  <li class="time-label timeline-label template-for-copy"><span class="bg-red timeline-title"></span></li>
                  <li class="timeline-content template-for-copy">
                    <i class="fa fa-arrow-right bg-blue"></i>
                    <div class="timeline-item">
                      <h3 class="timeline-header timeline-title no-border"></h3>
                      <div class="timeline-body">
                        <p class="timeline-url"><a href="" target="_blank"></a></p>
                        <p class="timeline-free_text"></p>
                      </div>
                    </div>
                  </li>
                </ul>
                <ul class="timeline timeline-stage" id="timeline_for_stage">

                  
{**********************
                  {foreach from=$episode_list key=k item=v_episode}
                {if $v_episode.is_label == 1}
                  <li class="time-label"><span class="bg-red">{$v_episode.title}</span></li>
                {else}
                  <li>
                    {if $v_episode.category == 2}<i class="fa fa-arrow-right bg-green"></i>
                    {elseif $v_episode.category == 3}<i class="fa fa-arrow-right bg-red"></i>
                    {else}<i class="fa fa-arrow-right bg-blue"></i>{/if}
                    <div class="timeline-item">
                      <h3 class="timeline-header no-border">{$v_episode.title}</h3>
                      <div class="timeline-body">
                        {if $v_episode.url != ""}<a href="{$v_episode.url}" target="_blank">{$v_episode.url}</a>{/if}
                        {$v_episode.free_text}
                      </div>
                    </div>
                  </li>
                {/if}
                {/foreach}
**********************}
                </ul>

                
<ul class="timeline timeline-stage">
            <!-- timeline time label -->
            <li class="time-label">
                  <span class="bg-red">
                    ドラゴン襲来前
                  </span>
            </li>

            <li>
              <i class="fa fa-arrow-right bg-blue"></i>
              <div class="timeline-item">
                <h3 class="timeline-header no-border">aaaとbbbが出会ったときの話のメモ</h3>
                <div class="timeline-body">
                  aaaとbbbは元々同じ中学校だったがなんとかかんとか... 
                  <p><small><a href="#">全文を表示</a></small></p>
                </div>
              </div>
            </li>

            <li>
              <i class="fa fa-arrow-right bg-blue"></i>
              <div class="timeline-item">
                <h3 class="timeline-header no-border">ムラクモ選抜試験直前のおはなし</h3>
                <div class="timeline-body">
                  <a href="#">http://twitter.com/...</a>
                  twitterに上げた漫画です。<br>
                  補足として、aaaとbbbは幼馴染だったので二人で組み、cccが合流する形になっています。
                </div>
              </div>
            </li>

            <li class="time-label">
                  <span class="bg-red">
                    ～2020の3章
                  </span>
            </li>

                        <li>
              <i class="fa fa-arrow-right bg-blue"></i>
              <div class="timeline-item">
                <h3 class="timeline-header no-border">dddが13班に加入</h3>
              </div>
            </li>
            
            <li>
              <i class="fa fa-arrow-right bg-blue"></i>
              <div class="timeline-item">
                <h3 class="timeline-header no-border">ここでルート分岐</h3>
                <div class="timeline-body">
                  bbbが失踪するパターン・メタルぽんぽこの代わりにaaaがなんやかんやで犠牲になるパターン
                </div>
              </div>
            </li>

          </ul>
                
                
                
                
                
                
                
              </div>
              <div class="tab-pane" id="tab-content-character">
                <button type="button" class="btn btn-primary btn-block">作成済みのキャラクターをこのステージに割り当てる</button>
                <ul>
                {foreach from=$stage.character_list key=k item=v_character}
                  <li><a href="/user/character/edit.php?id={$v_character.id}">{$v_character.name}</a></li>
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

  {include file='common/episode_add_modal.tpl'}
  
  {include file='common/footer.tpl'}

</div>
<!-- ./wrapper -->

<!-- JS start -->
{include file='common/adminlte_js.tpl'}
<script src="/js/common.js"></script>
<script src="/js/sidebar.js"></script>
<script src="/js/stage.js"></script>
<script src="/js/episode.js"></script>

<script>
// 読み込み完了時の処理
$(function(){
	// データ読み込み
	var param = {
		stage_id     : {$stage.id},
        character_id : "",
	}
	timeline(param);
});
</script>
<!-- JS end -->
</body>
</html>