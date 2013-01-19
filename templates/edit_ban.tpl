{if $action == "unban"}
    <table class="table table-bordered">
        <tr>
            <td><strong>{'_BANDETAILS'|lang}</strong></td>
        </tr>
        <tr>
            <td>{'_PLAYER'|lang}</td>
            <td>{$ban_info.player_name}</td>
        </tr>
        <tr>
            <td>SteamID</td>
            <td>{$ban_info.player_id}</td>
        </tr>
        <tr>
            <td>{'_IP'|lang}</td>
            <td>{$ban_info.player_ip}</td>
        </tr>
        <tr>
            <td>{'_INVOKED'|lang}</td>
            <td>{$ban_info.ban_start}</td>
          </tr>
          <tr>
            <td>{'_BANLENGTH'|lang}</td>
            <td>{$ban_info.ban_duration}</td>
          </tr>
          <tr>
            <td>{'_EXPIRES'|lang}</td>
            <td>{$ban_info.ban_end}</td>
          </tr>
          <tr>
            <td>{'_BANTYPE'|lang}</td>
            <td>{$ban_info.ban_type}</td>
          </tr>
          <tr>
            <td>{'_REASON'|lang}</td>
            <td>{$ban_info.ban_reason}</td>
          </tr>
          <tr>
            <td>{'_BANBY'|lang}</td>
            <td>{$ban_info.admin_name}</td>
          </tr>
          <tr>
            <td>{'_BANON'|lang}</td>
            <td>{$ban_info.server_name}</td>
          </tr>
          <form name="unban" method="get" action="{$this}">
          <input type="hidden" name="bid" value="{$bid}">
          <input type="hidden" name="action" value="unban_perm">
          <tr>
            <td>{'_REASONUNBAN'|lang}</td>
            <td><input type="text" name="unban_reason"></td>
          </tr>
          <tr>
            <td colspan="2"><input type="submit" name="submit" value="{'_UNBAN'|lang}"></td>
          </tr>
					</form>
        </table>
				{elseif $action == "edit"}
				<table class="table table-bordered">
          <form name='edit' method='get' action='{$this}'>
          <input type='hidden' name='bid' value='{$bid}'>
          <input type='hidden' name='action' value='apply'>
          <tr>
            <td height='16' colspan='2' class='listtable_top'><b>{"_EDIT"|lang}</b></td>
          </tr>
          <tr>
            <td>{"_PLAYER"|lang}</td>
            <td><input type='text' name='player_nick' value='{$ban_info.player_name}'></td>
          </tr>
          <tr>
            <td>{"_BANTYPE"|lang}</td>
            <td>

						<select name='ban_type'>
						<option value='S' {if $ban_info.ban_type == "S"}selected{/if}>SteamID</a>
						<option value='SI' {if $ban_info.ban_type == "SI"}selected{/if}>{"_STEAMID&IP"|lang}</a>
						</select

						</td>
          </tr>
          <tr>
            <td>SteamID</td>
            <td><input type='text' name='player_id' value='{$ban_info.player_id}'></td>
          </tr>
          <tr>
            <td>{"_IP"|lang}</td>
            <td><input type='text' name='player_ip' value='{$ban_info.player_ip}'></td>
          </tr>
          <tr>
            <td>{"_BANLENGHT"|lang}</td>
            <td><input type='text' name='ban_length' value='{$ban_info.ban_duration}'></td>
          </tr>
          <tr>
            <td>{"_REASON"|lang}</td>
            <td><input type='text' name='ban_reason' value='{$ban_info.ban_reason}'></td>
          </tr>
          <tr>
            <td height='16' width='100%' colspan='2' class='listtable_1' align='right'><input type='submit' name='apply' value='{"_APPLY"|lang}' style='font-family: verdana, tahoma, arial; font-size: 10px;'></td>
          </tr>
					</form>
        </table>
				{/if}