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
          <input type="hidden" name="is_label" class="form-is_label" value="">
          <div class="form-group clickable" onclick="$(this).children().toggleClass('hide');">
            <span class="form-is_private" data-is_private="1"><span class="is_private_icon is_private_1"><i class="fa fa-lock fa-fw"></i></span>非公開<small>（クリックで公開に切り替え）</small></span>
            <span class="form-is_private" data-is_private="0"><span class="is_private_icon is_private_0"><i class="fa fa-unlock fa-fw"></i></span>公開<small>（クリックで非公開に切り替え）</small></span>
          </div>
          <div class="form-group not_use_for_label">
            <label>カテゴリ</label>
            <span class="menu-tooltip">
              <i class="fa fa-question-circle fa-fw" aria-hidden="true"></i>
              <span class="menu-tooltiptext">{$config.tooltip.episode_category}</span>
            </span>
          {foreach from=$config.episode_category key=k item=v_category}
            <div class="radio">
              <label>
                <input type="radio" name="category" class="form-category" value="{$v_category.value}">
                {$v_category.name}
              </label>
            </div>
          {/foreach}
          </div>
          <div class="form-group">
            <label>タイトル</label>
            <input type="text" name="title" class="form-control form-title">
          </div>
          <div class="form-group not_use_for_label">
            <label>外部サイトURL</label>
            <span class="menu-tooltip">
              <i class="fa fa-question-circle fa-fw" aria-hidden="true"></i>
              <span class="menu-tooltiptext">{$config.tooltip.episode_url}</span>
            </span>
            <input type="text" name="url" class="form-control form-url">
          </div>
          <div class="form-group not_use_for_label">
            <label>フリーテキスト</label>
            <span class="menu-tooltip">
              <i class="fa fa-question-circle fa-fw" aria-hidden="true"></i>
              <span class="menu-tooltiptext">{$config.tooltip.episode_free_text}</span>
            </span>
            <textarea class="form-control form-free_text" rows="3" name="form-control free_text"></textarea>
          </div>
          <div class="form-group not_use_for_label">
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
          <div class="form-group not_use_for_label">
            <label>このエピソードに関連するキャラクターを設定する</label>
            <span class="menu-tooltip">
              <i class="fa fa-question-circle fa-fw" aria-hidden="true"></i>
              <span class="menu-tooltiptext">{$config.tooltip.episode_character}</span>
            </span>
            <div>
            {foreach from=$stage.character_list key=k item=v_character}
              <span class="badge character character-selectable character-notselected clickable" value="{$v_character.id}">{$v_character.name}</span>
            {/foreach}
            </div>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default pull-left" data-dismiss="modal">キャンセル</button>
          <button type="button" class="btn btn-primary" onclick="setEpisode();">登録</button>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-block btn-warning" onclick="delEpisode();">このエピソードを削除</button>
        </div>
      </div>
    </div>
  </div>
