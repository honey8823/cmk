  <!-- エピソード登録modal -->
  <div class="modal fade" id="modal-addEpisode">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span></button>
          <h4 class="modal-title">エピソード登録</h4>
        </div>
        <div class="modal-body">
          <input type="hidden" name="stage_id" class="form-stage_id" value={$stage.id}>
          <div class="form-group clickable" onclick="$(this).children().toggleClass('hidden');">
            <span class="form-is_private" data-is_private="1"><span class="is_private_icon clickable is_private_1"><i class="fa fa-lock fa-fw"></i></span>非公開<small>（クリックで公開に切り替え）</small></span>
            <span class="form-is_private hidden" data-is_private="0"><span class="is_private_icon clickable is_private_0"><i class="fa fa-unlock fa-fw"></i></span>公開<small>（クリックで非公開に切り替え）</small></span>
          </div>
          <div class="form-group">
            <button type="button" class="forms-switch btn btn-block btn-lg btn-success btn-form_common active" data-target_forms_id="common">通常エピソード</button>
            <button type="button" class="forms-switch btn btn-block btn-xs btn-success btn-form_label" data-target_forms_id="label">ラベル</button>
          {if !isset($stage.character_list) || !is_array($stage.character_list) || count($stage.character_list) == 0}
            {*<button type="button" class="btn btn-block btn-xs btn-success btn-form_override disabled" data-target_forms_id="override">キャラクターのオーバーライド</button>*}
          {else}
            <button type="button" class="forms-switch btn btn-block btn-xs btn-success btn-form_override" data-target_forms_id="override">キャラクターのオーバーライド</button>
          {/if}
          </div>

          {* 通常エピソード *}
          <div id="add_forms-common">
            <p class="hint-box">
              ふつうは「通常エピソード」のままでOKです。（できごと・会話メモ・SS・外部サイトへのリンクなど）
            </p>
            <div class="form-group">
              <label>タイトル</label>
              <input type="text" name="title" class="form-control form-title">
            </div>
            <div class="form-group">
              <label>外部サイトURL</label>
              <input type="text" name="url" class="form-control form-url">
            </div>
            <div class="form-group">
              <label>フリーテキスト</label>
              <button type="button" class="btn btn-default btn-xs pull-right insert-read-more">「続きを読む」の挿入</button>
              <textarea class="form-control form-free_text" rows="3" name="form-control free_text"></textarea>
            </div>
            <div class="form-group">
              <div class="checkbox">
                <label>
                  <input type="checkbox" name="is_r18" class="form-is_r18">
                  R18
                </label>
                <span class="hint-box-toggle">
                  <i class="fa fa-question-circle fa-fw" aria-hidden="true"></i>
                  <p class="hint-box hidden">内容がアダルトコンテンツになる場合はチェックを入れてください。<br>ご協力をお願いいたします。</p>
                </span>
              </div>
            </div>
            <div class="form-group">
              <label>このエピソードに関連するキャラクター</label>
              <span class="hint-box-toggle">
                <i class="fa fa-question-circle fa-fw" aria-hidden="true"></i>
                <p class="hint-box hidden">選択すると、そのキャラクターのタイムラインにも表示されるようになります。</p>
              </span>
              <div>
              {if !isset($stage.character_list) || !is_array($stage.character_list) || count($stage.character_list) == 0}
                <p class="hint-box">
                  このステージにはキャラクターが割り当てられていません。<br>
                  このページの「キャラクター」タブ、もしくはキャラクター自身のページで設定できます。
                </p>
              {else}
              {foreach from=$stage.character_list key=k item=v_character}
                <span class="badge character selectable notselected clickable" value="{$v_character.id}">{$v_character.name|escape:'html'}</span>
              {/foreach}
              {/if}
              </div>
            </div>
          </div>

          {* ラベル *}
          <div id="add_forms-label" class="hidden">
            <p class="hint-box">
              「ラベル」はエピソード群の区切り用としてご利用ください。
            </p>
            <div class="form-group">
              <label>タイトル</label>
              <input type="text" name="title" class="form-control form-title">
            </div>
          </div>

          {* オーバーライド *}
          <div id="add_forms-override" class="hidden">
            <p class="hint-box">
              「キャラクターのオーバーライド」では、基本的なキャラプロフィールを変更することなく<br>
              このステージのここからこういう変化があった、という表現ができます。<br>
              ここではタイトルだけを登録し（必須ではありません）、次の画面で詳しい編集ができます。
            </p>
            <div class="form-group">
              <label>タイトル</label>
              <input type="text" name="title" class="form-control form-title">
            </div>
          </div>

        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default pull-left" data-dismiss="modal">キャンセル</button>
          <button type="button" class="btn btn-primary btn-add_common" onclick="addEpisodeCommon();">登録</button>
          <button type="button" class="btn btn-primary btn-add_label hidden" onclick="addEpisodeLabel();">登録</button>
          <button type="button" class="btn btn-primary btn-add_override hidden" onclick="addEpisodeOverride();">次へ</button>
        </div>
      </div>
    </div>
  </div>
