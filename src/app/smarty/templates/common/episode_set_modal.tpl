  <!-- エピソード更新modal -->
  <div class="modal fade" id="modal-setEpisode">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span></button>
          <h4 class="modal-title">エピソード更新</h4>
        </div>
        <div class="modal-body">
          <input type="hidden" name="id" class="form-id" value="">
          <div class="form-group clickable" onclick="$(this).children().toggleClass('hide');">
            <span class="form-is_private" data-is_private="1"><span class="is_private_icon clickable is_private_1"><i class="fa fa-lock fa-fw"></i></span>非公開<small>（クリックで公開に切り替え）</small></span>
            <span class="form-is_private" data-is_private="0"><span class="is_private_icon clickable is_private_0"><i class="fa fa-unlock fa-fw"></i></span>公開<small>（クリックで非公開に切り替え）</small></span>
          </div>

          {* 通常エピソード *}
          <div id="set_forms-common" class="hidden">
            <div class="form-group">
              <label>タイトル</label>
              <input type="text" name="title" class="form-control form-title">
            </div>
            <div class="form-group">
              <label>外部サイトURL</label>
              <span class="menu-tooltip">
                <i class="fa fa-question-circle fa-fw" aria-hidden="true"></i>
                <span class="menu-tooltiptext">{$config.tooltip.episode_url}</span>
              </span>
              <input type="text" name="url" class="form-control form-url">
            </div>
            <div class="form-group">
              <label>フリーテキスト</label>
              <span class="menu-tooltip">
                <i class="fa fa-question-circle fa-fw" aria-hidden="true"></i>
                <span class="menu-tooltiptext">{$config.tooltip.episode_free_text}</span>
              </span>
              <button type="button" class="btn btn-default btn-xs pull-right insert-read-more">「続きを読む」の挿入</button>
              <textarea class="form-control form-free_text" rows="3" name="form-control free_text"></textarea>
            </div>
            <div class="form-group">
              <div class="checkbox">
                <label>
                  <input type="checkbox" name="is_r18" class="form-is_r18">
                  R18
                </label>
                <span class="menu-tooltip">
                  <i class="fa fa-question-circle fa-fw" aria-hidden="true"></i>
                  <span class="menu-tooltiptext">{$config.tooltip.episode_is_r18}</span>
                </span>
              </div>
            </div>
            <div class="form-group">
              <label>このエピソードに関連するキャラクター</label>
              <span class="menu-tooltip">
                <i class="fa fa-question-circle fa-fw" aria-hidden="true"></i>
                <span class="menu-tooltiptext">{$config.tooltip.episode_character}</span>
              </span>
              <div>
              {if !isset($stage.character_list) || !is_array($stage.character_list) || count($stage.character_list) == 0}
                <p class="hint-box">
                  このステージにはキャラクターが割り当てられていません。<br>
                  このページの「キャラクター」タブ、もしくはキャラクター自身のページで設定できます。
                </p>
              {else}
              {foreach from=$stage.character_list key=k item=v_character}
                <span class="badge character character-selectable character-notselected clickable" value="{$v_character.id}">{$v_character.name|escape:'html'}</span>
              {/foreach}
              {/if}
              </div>
            </div>
          </div>

          {* ラベル *}
          <div id="set_forms-label" class="hidden">
            <div class="form-group">
              <label>タイトル</label>
              <input type="text" name="title" class="form-control form-title">
            </div>
          </div>

          {* オーバーライド *}
          <div id="set_forms-override" class="hidden">
            <div class="form-group">
              <label>タイトル</label>
              <input type="text" name="title" class="form-control form-title">
            </div>
            <div class="form-group">
              <label>オーバーライド</label>
              <div>
              {if !isset($stage.character_list) || !is_array($stage.character_list) || count($stage.character_list) == 0}
                <p class="hint-box">
                  このステージにはキャラクターが割り当てられていません。<br>
                  このページの「キャラクター」タブ、もしくはキャラクター自身のページで設定できます。
                </p>
              {else}
                <ul class="nav nav-stacked">
                {foreach from=$stage.character_list key=k item=v_character}
                  <li class="character-selectable clickable" data-id="{$v_character.id}">
                    <a>{$v_character.name|escape:'html'}</a>
                  </li>
                {/foreach}
                {foreach from=$stage.character_list key=k item=v_character}
                  <big><span class="badge character character-selectable character-notselected clickable" value="{$v_character.id}">{$v_character.name|escape:'html'}</span></big>
                {/foreach}
                </ul>
              {/if}
              </div>
            </div>
          </div>

        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default pull-left" data-dismiss="modal">キャンセル</button>
          <button type="button" class="btn btn-primary btn-set_common hidden" onclick="setEpisodeCommon();">登録</button>
          <button type="button" class="btn btn-primary btn-set_label hidden" onclick="setEpisodeLabel();">登録</button>
          <button type="button" class="btn btn-primary btn-set_override hidden" onclick="setEpisodeOverride();">登録</button>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-block btn-warning" onclick="delEpisode();">このエピソードを削除</button>
        </div>
      </div>
    </div>
  </div>
