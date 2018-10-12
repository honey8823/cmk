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
      <!-- <h1>キャラクター管理</h1> -->
      <ol class="breadcrumb">
        <li><a href="/">トップ</a></li>
        <li class="active">キャラクター管理</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="row">
        <div class="col-md-6">
          <div>
            <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#modal-addCharacter">キャラクターを追加</button>
          </div>
          <div>
            <small>
              ※タグの表記についてはこちら
            </small>
          </div>
          <div>
            <small>
              ※キャラクター登録に関するガイドラインはこちら
            </small>
          </div>
          <div id="list-character" class="box">
            <div class="box-body no-padding">
              <table class="table table-hover table-character">
                <!-- テーブルテンプレート -->
                <tr class="character_list template-for-copy">
                  <td class="td-name"><a href="/user/character/edit.php?" class="character_id"><span class="character_name"></span></a></td>
                  <td class="td-tag"><span class="template-for-copy label tag-base"></span></td>
                  <td class="td-is_private"><span class="character_is_private_0">公開</span><span class="character_is_private_1">非公開</span></td>
                </tr>
              </table>
            </div>
            <div class="box-body no-padding">
              <button type="button" class="btn btn-default btn-block btn-more disabled" onclick="tableCharacterForPrivate();">もっとみる</button>
              <input type="hidden" class="offset" value="0">
            </div>
          </div>
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
          <small>詳細なプロフィールは登録後の編集となります。</small>
        </div>
        <div class="modal-body">
          <div>
            <label>キャラクター名（一覧などで表示：普段の呼び名を推奨）</label>
            <input type="text" name="name" class="form-name">
          </div>
          <div>
            <label>登場シリーズ（複数選択可）</label>
          {foreach from=$series_list key=k item=series}
            <span class="label tag-base tag-series tag-notselected tag-selectable" value="{$series.id}">{$series.name}</span>
          {/foreach}
          </div>
          <div>
            <label>非公開にする（プロフィール編集後の公開を推奨）</label>
            <input type="checkbox" name="is_private" class="form-is_private" checked>
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
<script src="/js/common.js"></script>
<script src="/js/sidebar.js"></script>
<script src="/js/character.js"></script>
<script>
// 読み込み完了時の処理
$(function(){
	// データ読み込み
	$("#list-character").find("input.offset").val(0);
	tableCharacterForPrivate();
});
</script>
<!-- JS end -->
</body>
</html>