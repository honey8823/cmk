<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>{$smarty.const.SITE_NAME_FULL}</title>
  <link rel="stylesheet" href="/js/adminlte_2.4.5/bower_components/select2/dist/css/select2.min.css">
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
      <h1>キャラクター管理</h1>
      <ol class="breadcrumb">
        <li><a href="/">トップ</a></li>
        <li><a href="/user/character/">キャラクター管理</a></li>
        <li class="active">[{$character.name|escape:'html'}]編集</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="row">

        <div class="col-md-12">
        {if $character.is_private != 1}
          <div class="private-url">
            <small>
              「{$character.name|escape:'html'}」の公開ページは以下のURLです。<br>
              <a href="/public/character/detail.php?user={$character.login_id}&id={$character.id}">http://{$smarty.server.SERVER_NAME}/public/character/detail.php?user={$character.login_id}&id={$character.id}</a>
            </small>
          </div>
        {else}
          <p class="hint-box">このキャラクターを他人に公開したい場合は、名前の横の鍵マークをクリックしてください。</p>
        {/if}

          <div class="box">
            <div class="box-header with-border">
              <h3 class="box-title">基本情報</h3>
            </div>
            <div class="box-body" id="area-viewCharacter">
              <div>
                <span class="is_private_icon is_private_{$character.is_private} clickable" onclick="setCharacterIsPrivate({if $character.is_private == 1}0{else}1{/if});">
                  <i class="fa {if $character.is_private == 1}fa-lock{else}fa-unlock{/if} fa-fw"></i>
                </span>
                <span><big>{$character.name|escape:'html'}</big></span>
              </div>
              <div class="private-character-stage">
                {foreach from=$stage_list key=k item=v_stage}
                {if isset($character.stage_list) && is_array($character.stage_list) && in_array($v_stage.id, array_column($character.stage_list, 'id'))}
                  <span class="badge stage" value="{$v_stage.id}">{$v_stage.name|escape:'html'}</span>
                {/if}
                {/foreach}
              </div>
              <div class="private-character-remarks"><small>{if $character.remarks != ""}{$character.remarks|escape:'html'|nl2br}{else}（備考は登録されていません）{/if}</small></div>
              <div class="box-body text-align-right">
                <button type="button" class="btn btn-primary" onclick="$('#area-viewCharacter').hide();$('#area-setCharacter').show();">内容を編集する</button>
              </div>
            </div>
            <div class="box-body" id="area-setCharacter" style="display:none;">
              <input type="hidden" class="form-id hidden-character_id" value="{$character.id}">
              <div class="form-group">
                <label>キャラクター名</label>
                <span class="menu-tooltip">
                  <i class="fa fa-question-circle fa-fw" aria-hidden="true"></i>
                  <span class="menu-tooltiptext">{$config.tooltip.character_name}</span>
                </span>
                <input type="text" name="name" class="form-control form-name" value="{$character.name}">
              </div>
              <div class="form-group">
                <label>属するステージ（複数選択可）</label>
                <div>
                {foreach from=$stage_list key=k item=v_stage}
                {if isset($character.stage_list) && is_array($character.stage_list) && in_array($v_stage.id, array_column($character.stage_list, 'id'))}
                  <span class="badge stage stage-selectable clickable" value="{$v_stage.id}">{$v_stage.name|escape:'html'}</span>
                {else}
                  <span class="badge stage stage-notselected stage-selectable clickable" value="{$v_stage.id}">{$v_stage.name|escape:'html'}</span>
                {/if}
                {/foreach}
                </div>
              </div>
              <div class="form-group">
                <label>備考</label>
                <textarea name="remarks" class="form-control form-remarks">{$character.remarks}</textarea>
              </div>
              <div class="box-body text-align-right">
                <button type="button" class="btn btn-default pull-left" onclick="$('#area-setCharacter').hide();$('#area-viewCharacter').show();">キャンセル</button>
                <button type="button" class="btn btn-warning" onclick="delCharacter();">削除する</button>
                <button type="button" class="btn btn-primary" onclick="setCharacter();">更新する</button>
              </div>
            </div>
          </div>
        </div>

        <div class="col-md-12">
          <div class="nav-tabs-custom">
            <ul class="nav nav-tabs">
              <li class="active"><a href="#tab-content-profile" data-toggle="tab" aria-expanded="false">詳細プロフィール</a></li>
              <li class=""><a href="#tab-content-timeline" data-toggle="tab" aria-expanded="true">タイムライン</a></li>
            </ul>

            <div class="tab-content">
              <div class="tab-pane active" id="tab-content-profile">
                <p class="hint-box">ステージごとに異なる項目や時間の経過で変わる項目は<br>「ステージ」内で別途設定することができます。</p>
                <ul class="nav nav-stacked ul-character_profile character_profile" id="character_profile">

                {foreach from=$character.profile_list key=k item=v_profile}
                  <li class="li-character_profile" data-q="{$v_profile.question}">
                    <a>

                      <!-- 表示モード -->
                      <span class="view_mode">
                        <div class="character_profile_button_area pull-right">
                          <i class="fa fa-fw fa-pencil-square-o clickable character_profile_edit_icon" aria-hidden="true"></i>
                          <i class="fa fa-fw fa-trash-o clickable character_profile_delete_icon" aria-hidden="true"></i>
                        </div>
                        <div class="character_profile_q">{$v_profile.question_title}</div>
                        <div class="character_profile_a profile_base">{$v_profile.answer|escape:'html'|nl2br}</div>
                      </span>

                      <!-- 編集モード -->
                      <span class="edit_mode hidden">
                        <div class="character_profile_button_area pull-right">
                          <i class="fa fa-fw fa-floppy-o clickable character_profile_save_icon" aria-hidden="true"></i>
                          <i class="fa fa-fw fa-times clickable character_profile_clear_icon" aria-hidden="true"></i>
                        </div>
                        <div class="character_profile_q set_mode">{$v_profile.question_title}</div>
                        <div class="character_profile_a profile_base">
                          <textarea class="form-control" rows="3">{$v_profile.answer}</textarea>
                        </div>
                      </span>

                    </a>
                  </li>
                {/foreach}

                  <li class="li-character_profile template-for-copy">
                    <a>

                      <!-- 表示モード -->
                      <span class="view_mode hidden">
                        <div class="character_profile_button_area pull-right">
                          <i class="fa fa-fw fa-pencil-square-o clickable character_profile_edit_icon" aria-hidden="true"></i>
                          <i class="fa fa-fw fa-trash-o clickable character_profile_delete_icon" aria-hidden="true"></i>
                        </div>
                        <div class="character_profile_q"></div>
                        <div class="character_profile_a profile_base"></div>
                      </span>

                      <!-- 編集モード -->
                      <span class="edit_mode">
                        <div class="character_profile_button_area pull-right">
                          <i class="fa fa-fw fa-floppy-o clickable character_profile_save_icon" aria-hidden="true"></i>
                          <i class="fa fa-fw fa-times clickable character_profile_clear_icon" aria-hidden="true"></i>
                        </div>

                        <div class="character_profile_q add_mode">
                          <div>項目を新規追加</div>
                          <select class="form-control select2 select2-hidden-accessible" style="width: 100%;" tabindex="-1" aria-hidden="true">
                          {foreach from=$config.character_profile_q key=k item=v_q}
                          {if !in_array($v_q.value, array_column($character.profile_list, "question"))}
                            <option value="{$v_q.value}">{$v_q.title}</option>
                          {/if}
                          {/foreach}
                          </select>
                        </div>
                        <div class="character_profile_q set_mode hidden"><span></span></div>
                        <div class="character_profile_a profile_base">
                          <textarea class="form-control" rows="3"></textarea>
                        </div>
                      </span>

                    </a>
                  </li>

                </ul>
                <div class="text-align-right">
                  <a href="#" data-toggle="modal" data-target="#modal-request" onclick="setRequestCategory('character_profile');">
                    <small><i class="fa fa-fw fa-arrow-circle-right" aria-hidden="true"></i>欲しい項目がない！</small>
                  </a>
                </div>
              </div>

              <div class="tab-pane" id="tab-content-timeline">
{*
                <button type="button" class="btn btn-primary pull-right">このキャラクターにエピソードを追加する</button>
*}
                <ul class="timeline timeline-character" id="timeline_for_stage_template">
                {foreach from=$timeline key=k_tl item=v_tl}
                  <li class="time-label timeline-stage_name clickable" data-id="{$v_tl.id}" onclick="location.href='/user/stage/edit.php?id={$v_tl.id}';">
                    <span class="bg-blue timeline-title">
                    {if $v_tl.is_private == 1}
                      <span class="is_private_icon is_private_1"><i class="fa fa-lock fa-fw"></i></span>
                    {else}
                      <span class="is_private_icon is_private_0"><i class="fa fa-unlock fa-fw"></i></span>
                    {/if}
                      <span>{$v_tl.name|escape:'html'}</span>
                    </span>
                  </li>
                {if isset($v_tl.episode_list) && is_array($v_tl.episode_list)}
                {foreach from=$v_tl.episode_list key=k_episode item=v_episode}
                {if $v_episode.type_key == "label"}
                  <li class="time-label timeline-label timeline-label_title" data-id="{$v_episode.id}">
                    <span class="bg-red timeline-title">
                    {if $v_episode.is_private == 1}
                      <span class="is_private_icon is_private_1"><i class="fa fa-lock fa-fw"></i></span>
                    {else}
                      <span class="is_private_icon is_private_0"><i class="fa fa-unlock fa-fw"></i></span>
                    {/if}
                      <span>{$v_episode.title|escape:'html'}</span>
                    </span>
                  </li>
                {else}
                  <li class="timeline-content timeline-editable" data-id="{$v_episode.id}">
                    {if $v_episode.is_private == 1}
                      <span class="is_private_icon is_private_1"><i class="fa fa-lock fa-fw"></i></span>
                    {else}
                      <span class="is_private_icon is_private_0"><i class="fa fa-unlock fa-fw"></i></span>
                    {/if}
                    {if $v_episode.type_key == "common"}<i class="fa fa-book bg-green"></i>{/if}
                    {* {if $v_episode.type_key == ""}<i class="fa fa-users bg-orange"></i>{/if} *}
                    {if $v_episode.type_key == "override"}<i class="fa fa-user bg-yellow"></i>{/if}
                    <div class="timeline-item">
                    {if $v_episode.title != ""}
                      <h3 class="timeline-header timeline-title no-border">{$v_episode.title|escape:'html'}</h3>
                    {/if}
                    {if $v_episode.free_text != "" || $v_episode.url != ""}
                      <div class="timeline-body">
                        <small>
                        {if $v_episode.free_text != ""}
                          <p class="timeline-free_text">{$v_episode.free_text|escape:'html'|nl2br}</p>
                        {/if}
                        {if $v_episode.url != ""}
                          <p class="timeline-url"><a href="{$v_episode.url}" target="_blank">{$v_episode.url_view}</a></p>
                        {/if}
                        </small>
                      </div>
                    {/if}
                    </div>
                  </li>
                {/if}
                {/foreach}
                {/if}
                {/foreach}

{*** コピペ用
                  <li class="time-label timeline-editable timeline-label clickable template-for-copy" data-id="" data-toggle="modal" data-target="#modal-setEpisode"><span class="bg-red timeline-title"></span></li>
                  <li class="timeline-content timeline-editable clickable template-for-copy" data-id="" data-toggle="modal" data-target="#modal-setEpisode">
                    <i class="fa fa-arrow-right bg-blue"></i>
                    <div class="timeline-item">
                      <h3 class="timeline-header timeline-title no-border"></h3>
                      <div class="timeline-body">
                        <small>
                          <p class="timeline-free_text"></p>
                          <p class="timeline-url"><a href="" target="_blank"></a></p>
                        </small>
                      </div>
                    </div>
                  </li>
***}
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
<script src="/js/adminlte_2.4.5/bower_components/select2/dist/js/select2.full.min.js"></script>
{include file='common/common_js.tpl'}
<script src="/js/character.js"></script>
<script src="/js/character-profile.js"></script>
<script src="/js/timeline.js"></script>
<script src="/js/episode.js"></script>
<script>
$(function(){
	// プロフィールのフォーム表示用
	copyCharacterProfileForm("#tab-content-profile .li-character_profile.template-for-copy");
});
</script>
<!-- JS end -->
</body>
</html>