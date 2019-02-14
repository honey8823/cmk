<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>{$smarty.const.SITE_NAME_FULL}</title>
  <link rel="stylesheet" href="{$path_adminlte}bower_components/select2/dist/css/select2.min.css">
  {include file='common/adminlte_css.tpl'}
  {include file='common/common_private_css.tpl'}
  <link href="/js/lib/cropper.css" rel="stylesheet">
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

        {* post結果のエラーメッセージエリア *}
        {if isset($error_message) && $error_message != ""}
          <div class="div-error callout callout-danger">{$error_message}</div>
        {/if}

        {if $character.is_private != 1}
          <div class="url-info">
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
             <div class="row">
                <div class="col-sm-2">
                {if !isset($character.image) || $character.image == ""}
                  <img src="/img/icon_noimage.png" class="img-rounded character-image-view">
                {else}
                  <img src="data:image/png;base64,{$character.image}" class="img-rounded character-image-view">
                {/if}
                  <div class="text-align-center clickable" data-toggle="modal" data-target="#modal-setCharacterImage">
                    <small><a>画像の変更</a></small>
                  </div>
                </div>
                <div class="col-sm-10">
                  <div>
                    <span class="is_private_icon is_private_{$character.is_private} clickable" onclick="setCharacterIsPrivate({if $character.is_private == 1}0{else}1{/if});">
                      <i class="fa {if $character.is_private == 1}fa-lock{else}fa-unlock{/if} fa-fw"></i>
                    </span>
                   <span><big>{$character.name|escape:'html'}</big></span>
                  </div>
                  <div class="margin1">
                  {foreach from=$stage_list key=k item=v_stage}
                  {if isset($character.stage_list) && is_array($character.stage_list) && in_array($v_stage.id, array_column($character.stage_list, 'id'))}
                    <span class="badge stage" value="{$v_stage.id}">{$v_stage.name|escape:'html'}</span>
                  {/if}
                  {/foreach}
                  </div>
                  <div class="remarks-area"><small>{if $character.remarks != ""}{$character.remarks|escape:'html'|nl2br}{else}（備考は登録されていません）{/if}</small></div>
                  <div class="box-body text-align-right">
                    <button type="button" class="btn btn-primary" onclick="$('#area-viewCharacter').hide();$('#area-setCharacter').show();">内容を編集する</button>
                  </div>
                </div>
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
                  <span class="badge stage selectable clickable" value="{$v_stage.id}">{$v_stage.name|escape:'html'}</span>
                {else}
                  <span class="badge stage notselected selectable clickable" value="{$v_stage.id}">{$v_stage.name|escape:'html'}</span>
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
              <li class=""><a href="#tab-content-relation" data-toggle="tab" aria-expanded="true">相関図</a></li>
              <li class=""><a href="#tab-content-timeline" data-toggle="tab" aria-expanded="true">タイムライン</a></li>
            </ul>

            <div class="tab-content">
              <div class="tab-pane active" id="tab-content-profile">
                <button type="button" class="btn btn-block btn-primary sort_mode_off" onclick="readyCharacterProfileSort(1);">並べ替えモードにする</button>
                <button type="button" class="btn btn-block btn-warning sort_mode_on" onclick="readyCharacterProfileSort(0);">並べ替えモードを終了</button>
                <p class="hint-box sort_mode_on">並べ替えモード中：ドラッグ＆ドロップで並べ替えができます。</p>

                <p class="hint-box">ステージごとに異なる項目や時間の経過で変わる項目は<br>「ステージ」内で別途設定することができます。</p>
                <ul class="nav nav-stacked ul-character_profile character_profile character-profile-sort-area" id="character_profile">
                {foreach from=$character.profile_list key=k item=v_profile}
                  <li class="li-character_profile" data-q="{$v_profile.question}">
                    <a>
                    {* 表示モード *}
                      <span class="view_mode">
                      {* 右上アイコン *}
                        <div class="character_profile_button_area sort_mode_off pull-right">
                          <i class="fa fa-fw fa-pencil-square-o clickable character_profile_edit_icon" aria-hidden="true"></i>
                          <i class="fa fa-fw fa-trash-o clickable character_profile_delete_icon" aria-hidden="true"></i>
                        </div>
                      {* 項目名 *}
                        <div class="character_profile_q">{$v_profile.question_title}</div>
                      {* 内容 *}
                        <div class="character_profile_a sort_mode_off not_override">
                          <div class="profile_main">{$v_profile.answer|escape:'html'|nl2br}</div>
                        </div>
                      </span>
                    {* 編集モード *}
                      <span class="edit_mode hidden">
                      {* 右上アイコン *}
                        <div class="character_profile_button_area sort_mode_off pull-right">
                          <i class="fa fa-fw fa-floppy-o clickable character_profile_save_icon" aria-hidden="true"></i>
                          <i class="fa fa-fw fa-times clickable character_profile_clear_icon" aria-hidden="true"></i>
                        </div>
                      {* 項目名 *}
                        <div class="character_profile_q set_mode">{$v_profile.question_title}</div>
                      {* 内容 *}
                        <div class="character_profile_a sort_mode_off">
                          <textarea class="form-control" rows="3">{$v_profile.answer}</textarea>
                        </div>
                      </span>
                    </a>
                  </li>
                {/foreach}

                  <li class="li-character_profile template-for-copy">
                    <a>
                    {* 表示モード *}
                      <span class="view_mode hidden">
                      {* 右上アイコン *}
                        <div class="character_profile_button_area sort_mode_off pull-right">
                          <i class="fa fa-fw fa-pencil-square-o clickable character_profile_edit_icon" aria-hidden="true"></i>
                          <i class="fa fa-fw fa-trash-o clickable character_profile_delete_icon" aria-hidden="true"></i>
                        </div>
                      {* 項目名 *}
                        <div class="character_profile_q"></div>
                      {* 内容 *}
                        <div class="character_profile_a sort_mode_off not_override">
                          <div class="profile_main"></div>
                        </div>
                      </span>

                    {* 編集モード *}
                      <span class="edit_mode">
                      {* 右上アイコン *}
                        <div class="character_profile_button_area sort_mode_off pull-right">
                          <i class="fa fa-fw fa-floppy-o clickable character_profile_save_icon" aria-hidden="true"></i>
                          <i class="fa fa-fw fa-times clickable character_profile_clear_icon" aria-hidden="true"></i>
                        </div>
                      {* 項目名 *}
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
                        <div class="character_profile_q set_mode hidden"></div>
                      {* 内容 *}
                        <div class="character_profile_a sort_mode_off">
                          <textarea class="form-control" rows="3"></textarea>
                        </div>
                      </span>
                    </a>
                  </li>

                </ul>
                <div class="text-align-right">
                  <small>
                    <p>
                      <a href="#" data-toggle="modal" data-target="#modal-profile_import">
                        <i class="fa fa-fw fa-arrow-circle-right" aria-hidden="true"></i>他キャラクターから項目をインポートする（α版）
                      </a>
                    </p>
                    <p>
                      <a href="#" data-toggle="modal" data-target="#modal-request" onclick="setRequestCategory('character_profile');">
                        <i class="fa fa-fw fa-arrow-circle-right" aria-hidden="true"></i>欲しい項目がない！
                      </a>
                    </p>
                  </small>
                </div>
              </div>

              <div class="tab-pane" id="tab-content-relation">
{*
                <p class="hint-box">ステージごとや時間の経過で変わる内容は<br>「ステージ」内で別途設定することができます。</p>
*}
                <ul class="nav nav-stacked ul-character_relation character_relation" id="character_relation">
                {foreach from=$character.relation_list key=k item=v_relation}
                  <li class="li-character_relation" data-character_id_to="{$v_relation.character_id}">
                    <a href="#" data-toggle="modal" data-target="#modal-upsertCharacterRelation" onclick="setRelationModal({$v_relation.character_id});">
                    {* 表示モード *}
                      <div class="view_mode relation_view_panel">
                        <div class="character_relation-self character_relation_character">
                          <p>
                          {if !isset($character.image) || $character.image == ""}
                            <img src="/img/icon_noimage.png" class="img-rounded character-image-relation">
                          {else}
                            <img src="data:image/png;base64,{$character.image}" class="img-rounded character-image-relation">
                          {/if}
                          </p>
                          <p>{$character.name|escape:'html'}</p>
                        </div>
                        <div class="character_relation-free_text_a character_relation_free_text"><span class="{if $v_relation.free_text_a == ""}hidden{/if}">{$v_relation.free_text_a|escape:'html'|nl2br}</span></div>
                        <div class="character_relation-arrow">
                          <div class="relation-arrow_bar relation-arrow_right{if $v_relation.is_arrow_a != "1" || $v_relation.is_arrow_c == "1"} hidden{/if}">
                            <span>{$v_relation.title_a|escape:'html'}</span>
                          </div>
                          <div class="relation-arrow_bar relation-arrow_left{if $v_relation.is_arrow_b != "1" || $v_relation.is_arrow_c == "1"} hidden{/if}">
                            <span>{$v_relation.title_b|escape:'html'}</span>
                          </div>
                          <div class="relation-arrow_bar relation-arrow_right relation-arrow_left{if $v_relation.is_arrow_c != "1"} hidden{/if}">
                            <span>{$v_relation.title_c|escape:'html'}</span>
                          </div>
                          <div class="undefined{if $v_relation.is_arrow_a == "1" || $v_relation.is_arrow_b == "1" || $v_relation.is_arrow_c == "1"} hidden{/if}">（未設定）</div>
                        </div>
                        <div class="character_relation-free_text_b character_relation_free_text"><span class="{if $v_relation.free_text_b == ""}hidden{/if}">{$v_relation.free_text_b|escape:'html'|nl2br}</span></div>
                        <div class="character_relation-another character_relation_character">
                          <p>
                          {if !isset($v_relation.character_image) || $v_relation.character_image == ""}
                            <img src="/img/icon_noimage.png" class="img-rounded character-image-relation">
                          {else}
                            <img src="data:image/png;base64,{$v_relation.character_image}" class="img-rounded character-image-relation">
                          {/if}
                          </p>
                          <p>{$v_relation.character_name|escape:'html'}</p>
                        </div>
                      </div>
                    </a>
                  </li>
                {/foreach}
                </ul>
              </div>

              <div class="tab-pane" id="tab-content-timeline">
              {if !isset($timeline) || !is_array($timeline) || count($timeline) == 0}
                <p class="hint-box">このキャラクターはステージに関連付けられていません。</p>
              {else}
                <ul class="timeline" id="timeline_for_stage_template">
                {foreach from=$timeline key=k_tl item=v_tl}
                  <li class="time-label timeline-stage_name clickable" data-id="{$v_tl.id}">
                    <span class="bg-blue timeline-title">
                      <a href="/user/stage/edit.php?id={$v_tl.id}">
                      {if $v_tl.is_private == 1}
                        <span class="is_private_icon is_private_1"><i class="fa fa-lock fa-fw"></i></span>
                      {else}
                        <span class="is_private_icon is_private_0"><i class="fa fa-unlock fa-fw"></i></span>
                      {/if}
                        <span>{$v_tl.name|escape:'html'}</span>
                      </a>
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
                          <p class="timeline-url"><a href="{$v_episode.url}" target="_blank"><i class="fa fa-fw fa-external-link" aria-hidden="true"></i> <span>{$v_episode.url_view}</span></a></p>
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
                </ul>
              {/if}
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>
    <!-- ///////////////////////////////////////////////////// -->
  </div>
  <!-- Main content end -->

  {* 画像アップロードmodal *}
  <div class="modal fade" id="modal-setCharacterImage">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span></button>
          <h4 class="modal-title">アイコン画像の変更</h4>
        </div>
        <div class="modal-body">
          <div id="area-setCharacterImage">
            <form method="POST" enctype="multipart/form-data" action="/user/character/edit.php">
              <div class="form-group">
                <input type="file" id="input-character_image" name="image">
                <img id="select-image" style="max-width:100%; max-height: 50vh;">
                <input type="hidden" id="upload-character_id" name="character_id" value="{$character.id}">
                <input type="hidden" id="upload-image-x" name="image_x" value="0">
                <input type="hidden" id="upload-image-y" name="image_y" value="0">
                <input type="hidden" id="upload-image-w" name="image_w" value="0">
                <input type="hidden" id="upload-image-h" name="image_h" value="0">
              </div>
              <input type="submit" class="btn btn-primary pull-right hidden" value="更新する">
            </form>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default pull-left" data-dismiss="modal">キャンセル</button>
          <button type="button" class="btn btn-primary" onclick="setCharacterImageClear();">削除する</button>
          <button type="button" class="btn btn-primary" onclick="$('#area-setCharacterImage .btn').trigger('click');">更新する</button>
        </div>
      </div>
    </div>
  </div>

  {* プロフィール項目インポートmodal *}
  <div class="modal fade" id="modal-profile_import">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span></button>
          <h4 class="modal-title">他キャラクターから項目をコピーする</h4>
        </div>
        <div class="modal-body">
          <div class="callout callout-success">
            <small>
              プロフィール項目を、他キャラクターからこのキャラクターへコピーする機能です。<br>
              以下のような挙動となりますので、充分ご注意の上ご利用ください。<br>
              ・コピー元のキャラクターに存在し、このキャラクターに存在しない項目<br>
              　　→追加される<br>
              ・コピー元のキャラクターに存在せず、このキャラクターに存在する項目<br>
              　　→削除されず残る<br>
              ・コピー元のキャラクターにもこのキャラクターにも存在する項目の内容<br>
              　　→「内容もコピーする」を選択した場合は上書きされる<br>
              　　　「内容もコピーする」を選択していない場合は上書きされない
            </small>
          </div>
          <div class="form-group">
            <label>コピー元キャラクター</label>
            <select class="form-control character_id">
              <option value="">-- 選択してください --</option>
            {foreach from=$character.relation_list key=k item=v_relation}
              <option value="{$v_relation.character_id}">{$v_relation.character_name}</option>
            {/foreach}
            </select>
          </div>
          <div class="checkbox">
            <label><input type="checkbox" class="is_copy_answer"> 内容もコピーする</label>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default pull-left" data-dismiss="modal">キャンセル</button>
          <button type="button" class="btn btn-primary" onclick="copyCharacterProfile();">コピーする</button>
        </div>
      </div>
    </div>
  </div>

  {* 相関図編集modal *}
  <div class="modal fade" id="modal-upsertCharacterRelation">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span></button>
          <h4 class="modal-title">相関図の編集</h4>
        </div>
        <div class="modal-body">
          <div id="area-upsertCharacterRelation">
            <input type="hidden" class="form-id" value="{$character.id}">
            <input type="hidden" class="form-another_id" value="">

            <div id="upsert_forms-oneway">
              <div class="form-group">
                <button type="button" class="forms-switch btn btn-lg btn-block btn-success btn-form_both" data-target_forms_id="both"><i class="fa fa-fw fa-arrows-h" aria-hidden="true"></i>矢印を双方向にする</button>
              </div>
              <div class="character_relation-title"><span>{$character.name}</span><i class="fa fa-fw fa-arrow-right" aria-hidden="true"></i><span class="character_name"></span></div>
              <div class="character_relation-form form-group">
                <label>タイトル（矢印に重ねて表示されます）</label>
                <input class="form-control character_relation-title_a" type="text">
              </div>
              <div class="character_relation-form form-group">
                <label>フリーテキスト</label>
                <textarea class="form-control character_relation-free_text_a" rows="3" placeholder=""></textarea>
              </div>

              <div class="character_relation-title"><span class="character_name"></span><i class="fa fa-fw fa-arrow-right" aria-hidden="true"></i><span>{$character.name}</span></div>
              <div class="character_relation-form form-group">
                <label>タイトル（矢印に重ねて表示されます）</label>
                <input class="form-control character_relation-title_b" type="text">
              </div>
              <div class="character_relation-form form-group">
                <label>フリーテキスト</label>
                <textarea class="form-control character_relation-free_text_b" rows="3" placeholder=""></textarea>
              </div>
            </div>

            <div id="upsert_forms-both" class="hidden">
              <div class="form-group">
                <button type="button" class="forms-switch btn btn-lg btn-block btn-success btn-form_oneway" data-target_forms_id="oneway"><span class="fa-stack fa-fw" style="margin: -0.5em 0;"><i class="fa fa-long-arrow-right fa-stack-1x" style="top:-0.2em;"></i><i class="fa fa-long-arrow-left fa-stack-1x" style="top:0.2em;"></i></span>矢印を片方ずつにする</button>
              </div>
              <div class="character_relation-form form-group">
                <label>タイトル（矢印に重ねて表示されます）</label>
                <input class="form-control character_relation-title_a" type="text">
              </div>
              <div class="character_relation-form form-group">
                <label>フリーテキスト（<span>{$character.name}</span><i class="fa fa-fw fa-arrow-right" aria-hidden="true"></i><span class="character_name"></span>）</label>
                <textarea class="form-control character_relation-free_text_a" rows="3" placeholder=""></textarea>
              </div>
              <div class="character_relation-form form-group">
                <label>フリーテキスト（<span class="character_name"></span><i class="fa fa-fw fa-arrow-right" aria-hidden="true"></i><span>{$character.name}</span>）</label>
                <textarea class="form-control character_relation-free_text_b" rows="3" placeholder=""></textarea>
              </div>
            </div>

          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default pull-left" data-dismiss="modal">キャンセル</button>
          <button type="button" class="btn btn-primary" onclick="upsertCharacterRelation();">更新する</button>
        </div>
      </div>
    </div>
  </div>

  {include file='common/footer.tpl'}

</div>
<!-- ./wrapper -->

<!-- JS start -->
{include file='common/adminlte_js.tpl'}
<script src="{$path_adminlte}bower_components/select2/dist/js/select2.full.min.js"></script>
{include file='common/common_js.tpl'}
<script src="/js/character.js"></script>
<script src="/js/character-profile.js"></script>
<script src="/js/character-relation.js"></script>
<script src="/js/timeline.js"></script>
<script src="/js/episode.js"></script>
<script src="/js/lib/cropper.js"></script>
<script>
$(function(){
	// プロフィールのフォーム表示用
	copyCharacterProfileForm("#tab-content-profile .li-character_profile.template-for-copy");
});

$(function(){
	// 初期設定
	var options = {
		aspectRatio: 1 / 1,
		viewMode: 1,
		crop: function(e) {
			cropData = $('#select-image').cropper("getData");
			$("#upload-image-x").val(Math.floor(cropData.x));
			$("#upload-image-y").val(Math.floor(cropData.y));
			$("#upload-image-w").val(Math.floor(cropData.width));
			$("#upload-image-h").val(Math.floor(cropData.height));
		},
		zoomable: true,
		minCropBoxWidth: 100,
		minCropBoxHeight: 100
	}

	// 初期設定をセットする
	$('#select-image').cropper(options);
	$("#input-character_image").change(function(){
		// ファイル選択変更時に、選択した画像をCropperに設定する
		$('#select-image').cropper('replace', URL.createObjectURL(this.files[0]));
	});
});
</script>
<!-- JS end -->
</body>
</html>
