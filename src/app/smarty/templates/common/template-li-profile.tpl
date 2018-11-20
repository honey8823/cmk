{* /user/character/edit.php はロード時のみsmartyで描画するため、変更時はそちらも要確認 *}

<li class="li-character_profile template-for-copy">
  <a>

  {* 表示モード *}
    <span class="view_mode hidden">
    {* 右上アイコン *}
      <div class="character_profile_button_area pull-right">
        <i class="fa fa-fw fa-pencil-square-o clickable character_profile_edit_icon" aria-hidden="true"></i>
        <i class="fa fa-fw fa-trash-o disabled character_profile_delete_icon" aria-hidden="true"></i>
      </div>
    {* 項目名 *}
      <div class="character_profile_q"></div>
    {* 内容 *}
      <div class="character_profile_a not_override">
        <div class="profile_main"></div>
        <div class="profile_sub hidden"></div>
        <div class="profile_reference hidden">
          <div class="profile_base hidden">
            <div class="profile_reference_title">基本プロフィール</div>
            <div class="profile_reference_content is_empty">-</div>
            <div class="profile_reference_content is_fill hidden"></div>
          </div>
          <div class="profile_stage hidden">
            <div class="profile_reference_title">このステージ内のオーバーライド</div>
            <div class="profile_reference_content is_empty">-</div>
            <div class="profile_reference_content is_fill hidden"></div>
          </div>
          <div class="profile_episode_prev hidden">
            <div class="profile_reference_title">このエピソードより前のオーバーライド</div>
            <div class="profile_reference_content is_empty">-</div>
            <div class="profile_reference_content is_fill hidden"><ul><li class="hidden"></li></ul></div>
          </div>
          <div class="profile_episode_next hidden">
            <div class="profile_reference_title">このエピソードより後のオーバーライド</div>
            <div class="profile_reference_content is_empty">-</div>
            <div class="profile_reference_content is_fill hidden"><ul><li class="hidden"></li></ul></div>
          </div>
        </div>
      </div>
    </span>

  {* 編集モード *}
    <span class="edit_mode">
    {* 右上アイコン *}
      <div class="character_profile_button_area pull-right">
        <i class="fa fa-fw fa-floppy-o clickable character_profile_save_icon" aria-hidden="true"></i>
        <i class="fa fa-fw fa-times clickable character_profile_clear_icon" aria-hidden="true"></i>
      </div>
    {* 項目名 *}
      <div class="character_profile_q add_mode">
        <div>項目を新規追加</div>
        <select class="form-control select2 select2-hidden-accessible" style="width: 100%;" tabindex="-1" aria-hidden="true">
        {foreach from=$config.character_profile_q key=k item=v_q}
          <option value="{$v_q.value}">{$v_q.title}</option>
        {/foreach}
        </select>
      </div>
      <div class="character_profile_q set_mode hidden"></div>
    {* 内容 *}
      <div class="character_profile_a">
        <textarea class="form-control" rows="3"></textarea>
      </div>
    </span>

  </a>
</li>
