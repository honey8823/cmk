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
              {foreach from=$stage.character_list key=k item=v_character}
                <div class="character_block" data-id="{$v_character.id}">
                  <p class="character-folder clickable">
                    <big><i class="fa fa-fw fa-caret-right folder-close-icon" aria-hidden="true"></i></big>
                    <big><i class="fa fa-fw fa-caret-down folder-open-icon hidden" aria-hidden="true"></i></big>
                    <span>{$v_character.name|escape:'html'}</span>
                  </p>
                  <ul class="nav nav-stacked ul-character_profile character_profile_episode hidden" style="margin: 1.5em;">


{* サンプルここから *}
                    <li class="li-character_profile">
                      <a>
                      {* 表示モード *}
                        <span class="view_mode">
                          <div class="character_profile_button_area pull-right">
                            <i class="fa fa-fw fa-pencil-square-o clickable character_profile_edit_icon" aria-hidden="true"></i>
                            <i class="fa fa-fw fa-trash-o clickable character_profile_delete_icon" aria-hidden="true"></i>
                          </div>
                          <div class="pull-left">
                            <i class="fa fa-fw fa-sticky-note clickable character_profile_override_icon" aria-hidden="true"></i>
                          </div>
                          <div class="character_profile_q">項目名</div>
                          <div class="character_profile_a profile_base not_override hidden"><small>（基本プロフィールで設定されていない項目です）</small></div>
                          <div class="character_profile_a profile_stage not_override profile_indent_1 hidden"><small>（ステージ内でオーバーライドしていない項目です）</small></div>
                          <div>
                            <div class="character_profile_a profile_prev_episode not_override profile_indent_2 hidden">prev_1</div>
                            <div class="character_profile_a profile_prev_episode not_override profile_indent_2 hidden">prev_2</div>
                          </div>
                          <div class="character_profile_a profile_episode override">今回のオーバーライド</div>
                          <div>
                            <div class="character_profile_a profile_prev_episode not_override profile_indent_2 hidden">next_1</div>
                            <div class="character_profile_a profile_prev_episode not_override profile_indent_2 hidden">next_2</div>
                          </div>
                        </span>
                      </a>
                    </li>

                    <li class="li-character_profile">
                      <a>
                      {* 表示モード *}
                        <span class="view_mode">
                          <div class="character_profile_button_area pull-right">
                            <i class="fa fa-fw fa-pencil-square-o clickable character_profile_edit_icon" aria-hidden="true"></i>
                            <i class="fa fa-fw fa-trash-o clickable character_profile_delete_icon" aria-hidden="true"></i>
                          </div>
                          <div class="pull-left">
                            <i class="fa fa-fw fa-sticky-note clickable character_profile_override_icon" aria-hidden="true"></i>
                          </div>
                          <div class="character_profile_q">項目名</div>
                          <div class="character_profile_a profile_base not_override hidden"><small>（基本プロフィールで設定されていない項目です）</small></div>
                          <div class="character_profile_a profile_stage not_override profile_indent_1 hidden"><small>（ステージ内でオーバーライドしていない項目です）</small></div>
                          <div>
                            <div class="character_profile_a profile_prev_episode not_override profile_indent_2 hidden">prev_1</div>
                            <div class="character_profile_a profile_prev_episode not_override profile_indent_2 current">prev_2</div>
                          </div>
                          <div class="character_profile_a profile_episode override hidden"></div>
                          <div>
                            <div class="character_profile_a profile_prev_episode not_override profile_indent_2 hidden">next_1</div>
                            <div class="character_profile_a profile_prev_episode not_override profile_indent_2 hidden">next_2</div>
                          </div>
                        </span>
                      </a>
                    </li>
{* サンプルここまで *}

                  {* コピー用 *}
                    <li class="li-character_profile template-for-copy">
                      <a>
                      {* 表示モード *}
                        <span class="view_mode hidden">
                          <div class="character_profile_button_area pull-right">
                            <i class="fa fa-fw fa-pencil-square-o clickable character_profile_edit_icon" aria-hidden="true"></i>
                            <i class="fa fa-fw fa-trash-o clickable character_profile_delete_icon" aria-hidden="true"></i>
                          </div>
                          <div class="pull-left">
                            <i class="fa fa-fw fa-sticky-note clickable character_profile_override_icon" aria-hidden="true"></i>
                            <i class="fa fa-fw fa-sticky-note-o character_profile_original_icon" aria-hidden="true"></i>
                          </div>
                          <div class="character_profile_q"></div>
                          <div class="character_profile_a profile_base not_override hidden"><small>（基本プロフィールで設定されていない項目です）</small></div>
                          <div class="character_profile_a profile_stage not_override profile_indent_1 hidden"><small>（ステージ内でオーバーライドしていない項目です）</small></div>
                          <div>
                            <div class="character_profile_a profile_prev_episode not_override profile_indent_2 hidden template-for-copy"></div>
                          </div>
                          <div class="character_profile_a profile_episode override hidden"></div>
                          <div>
                            <div class="character_profile_a profile_prev_episode not_override profile_indent_2 hidden template-for-copy"></div>
                          </div>
                        </span>
                      {* 編集モード *}
                        <span class="edit_mode">
                          <div class="character_profile_button_area pull-right">
                            <i class="fa fa-fw fa-floppy-o clickable character_profile_save_icon" aria-hidden="true"></i>
                          </div>
                          <div class="pull-left">
                            <i class="fa fa-fw fa-sticky-note character_profile_override_icon" aria-hidden="true"></i>
                          </div>
                          <div class="character_profile_q add_mode">
                            <div>項目を新規追加</div>
                            <select class="form-control select2 select2-hidden-accessible character_{$v_character.id}" style="width: 100%;" tabindex="-1" aria-hidden="true">
                            {foreach from=$config.character_profile_q key=k item=v_q}
                              <option value="{$v_q.value}">{$v_q.title}</option>
                            {/foreach}
                            </select>
                          </div>
                          <div class="character_profile_q set_mode hidden"></div>
                          <div class="character_profile_a">
                            <textarea class="form-control" rows="3"></textarea>
                          </div>
                        </span>
                      </a>
                    </li>

                  </ul>
                </div>
              {/foreach}
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
