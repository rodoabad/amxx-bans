
{if $action == "unban"}
        <table class="table table-bordered">
          <tr>
            <td><b>{"_BANDETAILS"|lang}</b></td>
          </tr>
          <tr>
            <td>{"_PLAYER"|lang}</td>
            <td>{$ban_info.player_name}</td>
          </tr>
          <tr>
            <td>SteamID</td>
            <td>{$ban_info.player_id}</td>
          </tr>
          <tr bgcolor="#D3D8DC">
            <td>{"_IP"|lang}</td>
            <td>{$ban_info.player_ip}</td>
          </tr>
          <tr bgcolor="#D3D8DC">
            <td height='16' width='30%' class='listtable_1'>{"_INVOKED"|lang}</td>
            <td height='16' width='70%' class='listtable_1'>{$ban_info.ban_start}</td>
          </tr>
          <tr bgcolor="#D3D8DC">
            <td height='16' width='30%' class='listtable_1'>{"_BANLENGHT"|lang}</td>
            <td height='16' width='70%' class='listtable_1'>{$ban_info.ban_duration}</td>
          </tr>
          <tr bgcolor="#D3D8DC">
            <td height='16' width='30%' class='listtable_1'>{"_EXPIRES"|lang}</td>
            <td height='16' width='70%' class='listtable_1'>{$ban_info.ban_end}</td>
          </tr>
          <tr bgcolor="#D3D8DC">
            <td height='16' width='30%' class='listtable_1'>{"_BANTYPE"|lang}</td>
            <td height='16' width='70%' class='listtable_1'>{$ban_info.ban_type}</td>
          </tr>
          <tr bgcolor="#D3D8DC">
            <td height='16' width='30%' class='listtable_1'>{"_REASON"|lang}</td>
            <td height='16' width='70%' class='listtable_1'>{$ban_info.ban_reason}</td>
          </tr>
          <tr bgcolor="#D3D8DC">
            <td height='16' width='30%' class='listtable_1'>{"_BANBY"|lang}</td>
            <td height='16' width='70%' class='listtable_1'>{$ban_info.admin_name}</td>
          </tr>
          <tr bgcolor="#D3D8DC">
            <td height='16' width='30%' class='listtable_1'>{"_BANON"|lang}</td>
            <td height='16' width='70%' class='listtable_1'>{$ban_info.server_name}</td>
          </tr>
          <form name='unban' method='post' action='{$this}'>
          <input type='hidden' name='bid' value='{$bid}'>
          <input type='hidden' name='action' value='unban_perm'>
          <tr bgcolor="#D3D8DC">
            <td height='16' width='30%' class='listtable_1'>{"_REASONUNBAN"|lang}</td>
            <td height='16' width='70%' class='listtable_1'><input type='text' name='unban_reason' style='font-family: verdana, tahoma, arial; font-size: 10px; width: 250px'></td>
          </tr>
          <tr bgcolor="#D3D8DC">
            <td height='16' width='100%' colspan='2' class='listtable_1' align='right'><input type='submit' name='submit' value='{"_UNBAN"|lang}' style='font-family: verdana, tahoma, arial; font-size: 10px;'></td>
          </tr>
					</form>
        </table>
				{elseif $action == "edit"}
				<table cellspacing='1' class='listtable' width='100%'>
          <form name='edit' method='post' action='{$this}'>
          <input type='hidden' name='bid' value='{$bid}'>
          <input type='hidden' name='action' value='apply'>
          <tr>
            <td height='16' colspan='2' class='listtable_top'><b>{"_EDIT"|lang}</b></td>
          </tr>
          <tr bgcolor="#D3D8DC">
            <td height='16' width='30%' class='listtable_1'>{"_PLAYER"|lang}</td>
            <td height='16' width='70%' class='listtable_1'><input type='text' name='player_nick' value='{$ban_info.player_name}' style='font-family: verdana, tahoma, arial; font-size: 10px; width: 250px'></td>
          </tr>
          <tr bgcolor="#D3D8DC">
            <td height='16' width='30%' class='listtable_1'>{"_BANTYPE"|lang}</td>
            <td height='16' width='70%' class='listtable_1'>

						<select name='ban_type' style='font-family: verdana, tahoma, arial; font-size: 10px; width: 250px'>
						<option value='S' {if $ban_info.ban_type == "S"}selected{/if}>SteamID</a>
						<option value='SI' {if $ban_info.ban_type == "SI"}selected{/if}>{"_STEAMID&IP"|lang}</a>
						</select

						</td>
          </tr>
          <tr bgcolor="#D3D8DC">
            <td height='16' width='30%' class='listtable_1'>SteamID</td>
            <td height='16' width='70%' class='listtable_1'><input type='text' name='player_id' value='{$ban_info.player_id}' style='font-family: verdana, tahoma, arial; font-size: 10px; width: 250px'></td>
          </tr>
          <tr bgcolor="#D3D8DC">
            <td height='16' width='30%' class='listtable_1'>{"_IP"|lang}</td>
            <td height='16' width='70%' class='listtable_1'><input type='text' name='player_ip' value='{$ban_info.player_ip}' style='font-family: verdana, tahoma, arial; font-size: 10px; width: 250px'></td>
          </tr>
          <tr bgcolor="#D3D8DC">
            <td height='16' width='30%' class='listtable_1'>{"_BANLENGHT"|lang}</td>
            <td height='16' width='70%' class='listtable_1'><input type='text' name='ban_length' value='{$ban_info.ban_duration}' style='font-family: verdana, tahoma, arial; font-size: 10px; width: 250px'></td>
          </tr>
          <tr bgcolor="#D3D8DC">
            <td height='16' width='30%' class='listtable_1'>{"_REASON"|lang}</td>
            <td height='16' width='70%' class='listtable_1'><input type='text' name='ban_reason' value='{$ban_info.ban_reason}' style='font-family: verdana, tahoma, arial; font-size: 10px; width: 250px'></td>
          </tr>
          <tr bgcolor="#D3D8DC">
            <td height='16' width='100%' colspan='2' class='listtable_1' align='right'><input type='submit' name='apply' value='{"_APPLY"|lang}' style='font-family: verdana, tahoma, arial; font-size: 10px;'></td>
          </tr>
					</form>
        </table>
				{/if}