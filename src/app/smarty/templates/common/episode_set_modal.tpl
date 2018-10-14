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
{***
          // todo::ステージ選択のセレクトボックス
***}
          <div class="not_use_for_label">
            <label>カテゴリ</label>
            <span class="menu-tooltip">
              <i class="fa fa-question-circle fa-fw" aria-hidden="true"></i>
              <span class="menu-tooltiptext">{$config.tooltip.episode_category}</span>
            </span>
          {foreach from=$config.episode_category key=k item=v_category}
            <input type="radio" name="category" class="form-category" value="{$v_category.value}">{$v_category.name}
          {/foreach}
          </div>
          <div>
            <label>タイトル</label>
            <input type="text" name="title" class="form-title">
          </div>
          <div class="not_use_for_label">
            <label>外部サイトURL</label>
            <span class="menu-tooltip">
              <i class="fa fa-question-circle fa-fw" aria-hidden="true"></i>
              <span class="menu-tooltiptext">{$config.tooltip.episode_url}</span>
            </span>
            <input type="text" name="url" class="form-url">
          </div>
          <div class="not_use_for_label">
            <label>フリーテキスト</label>
            <span class="menu-tooltip">
              <i class="fa fa-question-circle fa-fw" aria-hidden="true"></i>
              <span class="menu-tooltiptext">{$config.tooltip.episode_free_text}</span>
            </span>
            <textarea class="form-control form-free_text" rows="3" name="free_text"></textarea>
          </div>
          <div class="not_use_for_label">
            <label>R18</label>
            <span class="menu-tooltip">
              <i class="fa fa-question-circle fa-fw" aria-hidden="true"></i>
              <span class="menu-tooltiptext">{$config.tooltip.episode_is_r18}</span>
            </span>
            <input type="checkbox" name="is_r18" class="form-is_r18">
          </div>
          <div class="not_use_for_label">
            <label>このエピソードに関連するキャラクターを設定する</label>
            <span class="menu-tooltip">
              <i class="fa fa-question-circle fa-fw" aria-hidden="true"></i>
              <span class="menu-tooltiptext">{$config.tooltip.episode_character}</span>
            </span>
          {foreach from=$stage.character_list key=k item=v_character}
            <span class="badge character character-selectable character-notselected" value="{$v_character.id}">{$v_character.name}</span>
          {/foreach}
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default pull-left" data-dismiss="modal">キャンセル</button>
          <button type="button" class="btn btn-warning" onclick="delEpisode();">このエピソードを削除</button>
          <button type="button" class="btn btn-primary" onclick="setEpisode(1);">登録</button>
<!--
          <button type="button" class="btn btn-primary" onclick="setEpisode(0);">登録（公開する）</button>
          <button type="button" class="btn btn-primary" onclick="setEpisode(1);">登録（非公開）</button>
          <div style="text-align: right;">※現在は <u><span class="is_public">公開中</span><span class="is_private">非公開</span></u> です。</div>
-->
        </div>
      </div>
    </div>
  </div>
