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
      <h1>ステージ管理</h1>
      <ol class="breadcrumb">
        <li><a href="/">トップ</a></li>
        <li class="active">ステージ管理</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="row">
        <div class="col-md-12">
          <p class="hint-box">
            「ステージ」は物語や世界観の単位です。<br>
            二次創作のジャンルごとに1つ作る、パラレルや分岐ルートで細かく分ける、などお好みでご利用ください。
          </p>
          <div class="box-body">
            <div>
              <button type="button" class="btn btn-block btn-primary" data-toggle="modal" data-target="#modal-addStage">ステージを追加</button>
            {if count($stage_list) > 1}
              <button type="button" class="btn btn-primary btn-block sort_mode_off" onclick="readyStageSort(1);">並べ替えモードにする</button>
              <button type="button" class="btn btn-warning btn-block sort_mode_on" onclick="readyStageSort(0);">並べ替えモードを終了</button>
              <p class="hint-box sort_mode_on">並べ替えモード中：ドラッグ＆ドロップで並べ替えができます。</p>
            {/if}
            </div>
          </div>
          <div id="list-stage" class="box">
            <div class="box-body no-padding">
              <ul class="nav nav-stacked ul-stage stage-sort-area">
              {foreach from=$stage_list key=k item=v_stage}

                <li class="stage_list" data-id="{$v_stage.id}">
                  <a href="/user/stage/edit.php?id={$v_stage.id}" class="stage_id">
                    <span class="is_private"><span class="is_private_icon is_private_{$v_stage.is_private}"><i class="fa {if $v_stage.is_private == 1}fa-lock{else}fa-unlock{/if} fa-fw"></i></span></span>
                    <span class="name"><span class="stage_name">{$v_stage.name|escape:'html'}</span></span>
                    <span class="tag">
                    {if isset($v_stage.tag_list) && is_array($v_stage.tag_list)}
                    {foreach from=$v_stage.tag_list key=k item=v_tag}
                      <span class="label tag-base tag-{$v_tag.category_key}">{$v_tag.name_short|escape:'html'}</span>
                    {/foreach}
                    {/if}
                    </span>
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

  <!-- ステージ登録modal -->
  <div class="modal fade" id="modal-addStage">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span></button>
          <h4 class="modal-title">ステージ登録</h4>
        </div>
        <div class="modal-body">
          <div class="form-group">
            <label>ステージ名</label>
            <input type="text" name="name" class="form-control form-name" placeholder="※必須">
          </div>
          <div class="form-group">
            <label>説明文</label>
            <span class="menu-tooltip">
              <i class="fa fa-question-circle fa-fw" aria-hidden="true"></i>
              <span class="menu-tooltiptext">{$config.tooltip.stage_remarks}</span>
            </span>
            <textarea class="form-control form-remarks" rows="3" name="remarks"></textarea>
          </div>
          <div class="form-group">
            <label>タグ</label>
          {if !isset($tag_category_list.series.tag_list) || !is_array($tag_category_list.series.tag_list) || count($tag_category_list.series.tag_list) == 0}
            <p class="hint-box">アカウント管理から「ジャンル」設定を行うことで、関連するタグを選択できるようになります。<br>のちほど選択することも可能なので、気が向いたらお試しください。</p>
          {/if}
          {foreach from=$tag_category_list key=category_key item=v_tag_category}
            <div class="tag_category">
              <p>{$v_tag_category.name}系</p>
            {foreach from=$v_tag_category.tag_list key=k item=v_tag}
              <span class="label tag-base tag-{$category_key} tag-notselected tag-selectable clickable" value="{$v_tag.id}">{$v_tag.name}</span>
            {/foreach}
            </div>
          {/foreach}
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default pull-left" data-dismiss="modal">キャンセル</button>
          <button type="button" class="btn btn-primary" onclick="addStage();">登録</button>
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
<script src="/js/common.js"></script>
<script src="/js/sidebar.js"></script>
<script src="/js/stage.js"></script>
<!-- JS end -->
</body>
</html>