<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>{$smarty.const.SITE_NAME_FULL}</title>
  {include file='common/adminlte_css.tpl'}
  {include file='common/common_private_css.tpl'}
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
        <li class="active">キャラクター管理</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="row">
        <div class="col-md-12">
          <div class="box-body">
            <div>
              <button type="button" class="btn btn-block btn-primary" data-toggle="modal" data-target="#modal-addCharacter">キャラクターを追加</button>
            {if count($character_list) > 1}
              <button type="button" class="btn btn-block btn-primary sort_mode_off" onclick="readyCharacterSort(1);">並べ替えモードにする</button>
              <button type="button" class="btn btn-block btn-warning sort_mode_on" onclick="readyCharacterSort(0);">並べ替えモードを終了</button>
              <p class="hint-box sort_mode_on">並べ替えモード中：ドラッグ＆ドロップで並べ替えができます。</p>
            {/if}
            </div>
          </div>
        {if count($character_list) > 0}
          <div id="list-character" class="box box-no-border">
            <div class="box-body no-padding">
              <ul class="nav nav-stacked ul-character ul-list character-sort-area">
              {foreach from=$character_list key=k item=v_character}
                <li class="character_list" data-id="{$v_character.id}">
                  <a href="/user/character/edit.php?id={$v_character.id}" class="character_id">
                    <div class="row">
                      <div class="col-sm-5">
                        <span class="is_private"><span class="is_private_icon is_private_{$v_character.is_private}"><i class="fa {if $v_character.is_private == 1}fa-lock{else}fa-unlock{/if} fa-fw"></i></span></span>
                        <span>
                        {if !isset($v_character.image) || $v_character.image == ""}
                          <img src="/img/icon_noimage.png" class="img-rounded character-image-list">
                        {else}
                          <img src="data:image/png;base64,{$v_character.image}" class="img-rounded character-image-list">
                        {/if}
                        </span>
                        <span class="name"><span class="character_name">{$v_character.name|escape:'html'}</span></span>
                      </div>
                      <div class="col-sm-7">
                        <span class="stage">
                        {if isset($v_character.stage_list) && is_array($v_character.stage_list)}
                        {foreach from=$v_character.stage_list key=k item=v_stage}
                          <span class="badge stage">{$v_stage.name|escape:'html'}</span>
                        {/foreach}
                        {/if}
                        </span>
                      </div>
                    </div>
                  </a>
                </li>
              {/foreach}
              </ul>
            </div>
          </div>
        {/if}
        </div>
      </div>
    </section>
    <!-- ///////////////////////////////////////////////////// -->
  </div>
  <!-- Main content end -->

  <!-- キャラ登録modal -->
  <div class="modal fade" id="modal-addCharacter">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span></button>
          <h4 class="modal-title">キャラクター登録</h4>
        </div>
        <div class="modal-body">
          <div class="form-group">
            <label>キャラクター名</label>
            <span class="hint-box-toggle">
              <i class="fa fa-question-circle fa-fw" aria-hidden="true"></i>
              <p class="hint-box hidden">一覧などで表示します。普段の呼び名などでの登録をおすすめします。</p>
            </span>
            <input type="text" name="name" class="form-control form-name">
          </div>
          <div class="form-group">
            <label>属するステージ（複数選択可）</label>
            <div>
            {if !isset($stage_list) || !is_array($stage_list) || count($stage_list) == 0}
            <p class="hint-box">ステージ管理から「ステージ」を追加することで選択できるようになります。<br>のちほど選択することも可能なので、気が向いたらお試しください。</p>
            {else}
            {foreach from=$stage_list key=k item=v_stage}
              <span class="badge stage notselected selectable clickable" value="{$v_stage.id}">{$v_stage.name}</span>
            {/foreach}
            {/if}
            </div>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default pull-left" data-dismiss="modal">キャンセル</button>
          <button type="button" class="btn btn-primary" onclick="addCharacter();">登録</button>
        </div>
      </div>
    </div>
  </div>

  {include file='common/footer.tpl'}

</div>
<!-- ./wrapper -->

<!-- JS start -->
{include file='common/adminlte_js.tpl'}
<script src="/js/lib/jquery.ui.touch-punch.min.js"></script>
{include file='common/common_js.tpl'}
<script src="/js/character.js"></script>
<!-- JS end -->
</body>
</html>
