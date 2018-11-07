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
      <h1>ステージ管理</h1>
      <ol class="breadcrumb">
        <li><a href="/">トップ</a></li>
        <li><a href="/user/stage/">ステージ管理</a></li>
        <li class="active">[{$stage.name|escape:'html'}]編集</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="row">

        <div class="col-md-12">
        {if $stage.is_private != 1}
          <div class="private-url">
            <small>
              「{$stage.name|escape:'html'}」の公開ページは以下のURLです。<br>
              <a href="/public/stage/detail.php?user={$stage.login_id}&id={$stage.id}">http://{$smarty.server.SERVER_NAME}/public/user/detail.php?user={$stage.login_id}&id={$stage.id}</a>
            </small>
          </div>
        {/if}

          <div class="box">
            <div class="box-header with-border">
              <h3 class="box-title">基本情報</h3>
            </div>
            <div class="box-body" id="area-viewStage">
              <div>
                <span class="is_private_icon clickable is_private_{$stage.is_private}" onclick="setStageIsPrivate({if $stage.is_private == 1}0{else}1{/if});">
                  <i class="fa {if $stage.is_private == 1}fa-lock{else}fa-unlock{/if} fa-fw"></i>
                </span>
                <span><big>{$stage.name|escape:'html'}</big></span>
              </div>
              <div class="private-stage-tag">
                {if isset($stage.tag_list) && is_array($stage.tag_list)}
                {foreach from=$stage.tag_list key=k item=v_tag}
                  <span class="label tag-base tag-series" value="{$v_tag.id}">{$v_tag.name|escape:'html'}</span>
                {/foreach}
                {/if}
              </div>
              <div class="private-stage-remarks"><small>{if $stage.remarks != ""}{$stage.remarks|escape:'html'|nl2br}{else}（説明文は登録されていません）{/if}</small></div>
              <div class="box-body text-align-right">
                <button type="button" class="btn btn-primary" onclick="$('#area-viewStage').hide();$('#area-setStage').show();">内容を編集する</button>
              </div>
            </div>
            <div class="box-body" id="area-setStage" style="display:none;">
              <input type="hidden" class="form-id" value="{$stage.id}">
              <div class="form-group">
                <label>ステージ名</label>
                <input type="text" name="name" class="form-control form-name" value="{$stage.name}" placeholder="※必須">
              </div>
              <div class="form-group">
                <label>関連するシリーズ（複数選択可）</label>
              {if !isset($series_list) || !is_array($series_list) || count($series_list) == 0}
                <p class="hint-box">アカウント管理から「ジャンル」設定を行うことで選択できるようになります。<br>のちほど選択することも可能なので、気が向いたらお試しください。</p>
              {/if}
                <div>
                {foreach from=$series_list key=k item=v_series}
                {if isset($stage.tag_list) && is_array($stage.tag_list) && in_array($v_series.id, array_column($stage.tag_list, 'id'))}
                  <span class="label tag-base tag-series tag-selectable clickable" value="{$v_series.id}">{$v_series.name|escape:'html'}</span>
                {else}
                  <span class="label tag-base tag-series tag-notselected tag-selectable clickable" value="{$v_series.id}">{$v_series.name|escape:'html'}</span>
                {/if}
                {/foreach}
                </div>
              </div>
              <div class="form-group">
                <label>説明文</label>
                <span class="menu-tooltip">
                  <i class="fa fa-question-circle fa-fw" aria-hidden="true"></i>
                  <span class="menu-tooltiptext">{$config.tooltip.stage_remarks}</span>
                </span>
                <textarea class="form-control form-remarks" rows="3" name="remarks">{$stage.remarks}</textarea>
              </div>
              <div class="box-body text-align-right">
                <button type="button" class="btn btn-default pull-left" onclick="$('#area-setStage').hide();$('#area-viewStage').show();">キャンセル</button>
                <button type="button" class="btn btn-warning" onclick="delStage();">削除する</button>
                <button type="button" class="btn btn-primary" onclick="setStage();">更新する</button>
              </div>
            </div>
          </div>
        </div>

        <div class="col-md-12">
          <div class="nav-tabs-custom">
            <ul class="nav nav-tabs">
              <li class="active"><a href="#tab-content-timeline" data-toggle="tab" aria-expanded="true">タイムライン</a></li>
              <li class=""><a href="#tab-content-character" data-toggle="tab" aria-expanded="false">キャラクター</a></li>
            </ul>
            <div class="tab-content">
              <div class="tab-pane active" id="tab-content-timeline">
                <div class="box-body">
                  <button type="button" class="btn btn-primary btn-block" data-toggle="modal" data-target="#modal-addEpisode"><i class="fa fa-fw fa-plus" aria-hidden="true"></i>タイムラインにエピソードを追加</button>
                  <button type="button" class="btn btn-primary btn-block sort_mode_off" onclick="readyEpisodeSort(1);"><i class="fa fa-fw fa-sort" aria-hidden="true"></i>並べ替えモードにする</button>
                  <button type="button" class="btn btn-warning btn-block sort_mode_on" onclick="readyEpisodeSort(0);"><i class="fa fa-fw fa-sort" aria-hidden="true"></i>並べ替えモード中（クリックで終了）</button>
                </div>
                <p class="hint-box sort_mode_on">並べ替えモード中：ドラッグ＆ドロップで並べ替えができます。</p>
                <ul class="timeline template-for-copy" id="timeline_for_stage_template">
                  <li class="time-label timeline-editable timeline-label clickable template-for-copy" data-id="" data-toggle="modal" data-target="#modal-setEpisode">
                    <span class="timeline-label-title bg-red">
                      <span class="is_private_icon is_private_0 clickable et_episode-is_private template-for-copy"><i class="fa fa-unlock fa-fw"></i></span>
                      <span class="is_private_icon is_private_1 clickable set_episode-is_private template-for-copy"><i class="fa fa-lock fa-fw"></i></span>
                      <span class="timeline-title"></span>
                    </span>
                  </li>
                  <li class="timeline-editable timeline-content clickable template-for-copy" data-id="" data-toggle="modal" data-target="#modal-setEpisode">
                    <span class="is_private_icon is_private_0 clickable set_episode-is_private template-for-copy"><i class="fa fa-unlock fa-fw"></i></span>
                    <span class="is_private_icon is_private_1 clickable set_episode-is_private template-for-copy"><i class="fa fa-lock fa-fw"></i></span>
                    <i class="fa fa-arrow-right bg-blue template-for-copy"></i>
                    <i class="fa fa-book bg-green category_icon category_1 template-for-copy"></i>
                    <i class="fa fa-users bg-orange category_icon category_2 template-for-copy"></i>
                    <i class="fa fa-user bg-yellow category_icon category_3 template-for-copy"></i>
                    <div class="timeline-item">
                      <h3 class="timeline-header timeline-title no-border template-for-copy"></h3>
                      <div class="timeline-body">
                        <small>
                          <p class="timeline-free_text template-for-copy"></p>
                          <p class="timeline-url template-for-copy"><a href="" target="_blank"></a></p>
                        </small>
                      </div>
                    </div>
                  </li>
                </ul>
                <ul class="timeline timeline-sort-area timeline-stage" id="timeline_for_stage"></ul>
                <div class="float-button-area">
                  <p class="clickable" data-toggle="modal" data-target="#modal-addEpisode"><i class="fa fa-fw fa-plus" aria-hidden="true"></i></p>
                  <p class="clickable sort_mode_off" onclick="readyEpisodeSort(1);"><i class="fa fa-fw fa-sort" aria-hidden="true"></i></p>
                  <p class="clickable sort_mode_on" onclick="readyEpisodeSort(0);"><i class="fa fa-fw fa-check" aria-hidden="true"></i></p>
                </div>
              </div>
              <div class="tab-pane" id="tab-content-character">
                <div class="box-body">
                  <button type="button" class="btn btn-primary btn-block" data-toggle="modal" data-target="#modal-upsertStageCharacter">このステージに属するキャラクターの割り当てを変更する</button>
                {if count($stage.character_list) > 1}
                  <button type="button" class="btn btn-block btn-primary sort_mode_off" onclick="readyStageCharacterSort(1);">並べ替えモードにする</button>
                  <button type="button" class="btn btn-block btn-warning sort_mode_on" onclick="readyStageCharacterSort(0);">並べ替えモードを終了</button>
                  <p class="hint-box sort_mode_on">並べ替えモード中：ドラッグ＆ドロップで並べ替えができます。<br>また、これはこのステージ内での並べ替えであり、キャラクター一覧ページ等には影響しません。</p>
                {/if}
                </div>
                <div id="list-character" class="box">
                  <div class="box-body no-padding">
                    <ul class="nav nav-stacked ul-character stage-character-sort-area">
                      <li class="character_list template-for-copy" data-id="">
                        <a href="/user/character/edit.php?" class="character_id">
                        <span class="is_private">
                          <span class="is_private_icon is_private_0 hide"><i class="fa fa-unlock fa-fw"></i></span>
                          <span class="is_private_icon is_private_1 hide"><i class="fa fa-lock fa-fw"></i></span>
                        </span>
                        <span class="name"><span class="character_name"></span></span>
                        </a>
                      </li>
                    {foreach from=$stage.character_list key=k item=v_character}
                      <li class="character_list" data-id="{$v_character.id}">
                        <a href="/user/character/edit.php?id={$v_character.id}" class="character_id">
                        <span class="is_private"><span class="is_private_icon is_private_{$v_character.is_private}"><i class="fa {if $v_character.is_private == 1}fa-lock{else}fa-unlock{/if} fa-fw"></i></span></span>
                        <span class="name"><span class="character_name">{$v_character.name|escape:'html'}</span></span>
                        </a>
                      </li>
                    {/foreach}
                    </ul>
                  </div>
                </div>
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
  {include file='common/episode_set_modal.tpl'}

    <!-- キャラクター割り当てmodal -->
  <div class="modal fade" id="modal-upsertStageCharacter">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span></button>
          <h4 class="modal-title">キャラクター割り当て</h4>
        </div>
        <div class="modal-body">
          <div class="form-group">
            <div>
            {foreach from=$character_list key=k item=v_character}
            {if isset($stage.character_list) && is_array($stage.character_list) && in_array($v_character.id, array_column($stage.character_list, 'id'))}
              <span class="badge character character-selectable clickable" value="{$v_character.id}">{$v_character.name|escape:'html'}</span>
            {else}
              <span class="badge character character-selectable character-notselected clickable" value="{$v_character.id}">{$v_character.name|escape:'html'}</span>
            {/if}
            {/foreach}
            </div>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default pull-left" data-dismiss="modal">キャンセル</button>
          <button type="button" class="btn btn-primary" onclick="upsertStageCharacter();">保存</button>
        </div>
      </div>
    </div>
  </div>


{*** 試作メモ
  <!-- エピソード登録modal -->
  <div class="modal fade" id="modal-menuEdit">
    <div style="position: absolute; top: 50%; left: 50%; transform: translate(-50%, -50%); color: white;">
      <p><i class="fa fa-fw fa-toggle-on" aria-hidden="true" style="width: 2em; height: 2em; font-size: 2em; text-align: center; border-radius: 50%; color: white;"></i> 公開/非公開の切り替え</p>
      <p><i class="fa fa-fw fa-pencil" aria-hidden="true" style="width: 2em; height: 2em; font-size: 2em; text-align: center; border-radius: 50%; color: white;"></i> 編集する</p>
    </div>
  </div>
***}

  {include file='common/footer.tpl'}

</div>
<!-- ./wrapper -->

<!-- JS start -->
{include file='common/adminlte_js.tpl'}
<script src="/js/lib/jquery.ui.touch-punch.min.js"></script>
<script src="/js/common.js"></script>
<script src="/js/sidebar.js"></script>
<script src="/js/stage.js"></script>
<script src="/js/stage-character.js"></script>
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