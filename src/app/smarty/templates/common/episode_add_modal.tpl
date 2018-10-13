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
          <div>
            <label>ラベルにする</label>
            <span class="menu-tooltip">
              <i class="fa fa-question-circle fa-fw" aria-hidden="true"></i>
              <span class="menu-tooltiptext">{$config.tooltip.episode_is_label}</span>
            </span>
            <input type="checkbox" name="is_label" class="form-is_label">
          </div>
          <div>
            <label>カテゴリ</label>
            <span class="menu-tooltip">
              <i class="fa fa-question-circle fa-fw" aria-hidden="true"></i>
              <span class="menu-tooltiptext">{$config.tooltip.episode_category}</span>
            </span>
          {foreach from=$config.episode_category key=k item=category}
            <input type="radio" name="category" class="form-category" value="{$category.value}"{if $category.value == 1} checked{/if}>{$category.name}
          {/foreach}
          </div>
          <div>
            <label>タイトル</label>
            <input type="text" name="title" class="form-title">
          </div>
          <div>
            <label>外部サイトURL</label>
            <span class="menu-tooltip">
              <i class="fa fa-question-circle fa-fw" aria-hidden="true"></i>
              <span class="menu-tooltiptext">{$config.tooltip.episode_url}</span>
            </span>
            <input type="text" name="url" class="form-url">
          </div>
          <div>
            <label>フリーテキスト</label>
            <span class="menu-tooltip">
              <i class="fa fa-question-circle fa-fw" aria-hidden="true"></i>
              <span class="menu-tooltiptext">{$config.tooltip.episode_free_text}</span>
            </span>
            <textarea class="form-control form-free_text" rows="3" name="free_text"></textarea>
          </div>
          <div>
            <label>R18</label>
            <span class="menu-tooltip">
              <i class="fa fa-question-circle fa-fw" aria-hidden="true"></i>
              <span class="menu-tooltiptext">{$config.tooltip.episode_is_r18}</span>
            </span>
            <input type="checkbox" name="is_r18" class="form-is_r18">
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default pull-left" data-dismiss="modal">キャンセル</button>
          <button type="button" class="btn btn-primary" onclick="addStage();">登録（公開する）</button>
          <button type="button" class="btn btn-primary" onclick="addStage();">登録（非公開）</button>
        </div>
      </div>
    </div>
  </div>
