
<table cellspacing='1' class='listtable' width='100%'>
          <form name='edit' method='post' action='{$this}'>
          <input type='hidden' name='bhid' value='{$bhid}'>
          <input type='hidden' name='action' value='apply_ex'>
          <tr>
            <td height='16' colspan='2' class='listtable_top'><b>Edit bandetails</b></td>
          </tr>
          <tr bgcolor="#D3D8DC">
            <td height='16' width='30%' class='listtable_1'>Player</td>
            <td height='16' width='70%' class='listtable_1'><input type='text' name='player_nick' value='{$ban_info.player_name}' style='font-family: verdana, tahoma, arial; font-size: 10px; width: 250px'></td>
          </tr>
          <tr bgcolor="#D3D8DC">
            <td height='16' width='30%' class='listtable_1'>bantype</td>
            <td height='16' width='70%' class='listtable_1'>

		<select name='ban_type' style='font-family: verdana, tahoma, arial; font-size: 10px; width: 250px'>
		<option value='S' {if $ban_info.ban_type == "S"}selected{/if}>SteamID</a>
		<option value='SI' {if $ban_info.ban_type == "SI"}selected{/if}>SteamID and/or IP address</a>
		</select

	    </td>
          </tr>
          <tr bgcolor="#D3D8DC">
            <td height='16' width='30%' class='listtable_1'>SteamID</td>
            <td height='16' width='70%' class='listtable_1'><input type='text' name='player_id' value='{$ban_info.player_id}' style='font-family: verdana, tahoma, arial; font-size: 10px; width: 250px'></td>
          </tr>
          <tr bgcolor="#D3D8DC">
            <td height='16' width='30%' class='listtable_1'>IP address</td>
            <td height='16' width='70%' class='listtable_1'><input type='text' name='player_ip' value='{$ban_info.player_ip}' style='font-family: verdana, tahoma, arial; font-size: 10px; width: 250px'></td>
          </tr>
          
          <tr bgcolor="#D3D8DC">
            <td height='16' width='30%' class='listtable_1'>BanStart</td>
            <td height='16' width='70%' class='listtable_1'>{$ban_info.ban_start}</td>
          </tr>
          
          <tr bgcolor="#D3D8DC">
            <td height='16' width='30%' class='listtable_1'>Banlength</td>
            <td height='16' width='70%' class='listtable_1'><input type='text' name='ban_length' value='{$ban_info.ban_duration}' style='font-family: verdana, tahoma, arial; font-size: 10px; width: 250px'></td>
          </tr>
          
          <tr bgcolor="#D3D8DC">
            <td height='16' width='30%' class='listtable_1'>Admin</td>
            <td height='16' width='70%' class='listtable_1'>{$ban_info.admin_name}</td>
          </tr>
          
          <tr bgcolor="#D3D8DC">
            <td height='16' width='30%' class='listtable_1'>Reason</td>
            <td height='16' width='70%' class='listtable_1'><input type='text' name='ban_reason' value='{$ban_info.ban_reason}' style='font-family: verdana, tahoma, arial; font-size: 10px; width: 250px'></td>
          </tr>
          <tr bgcolor="#D3D8DC">
            <td height='16' width='100%' colspan='2' class='listtable_1' align='right'><input type='submit' name='apply_ex' value=' apply ' style='font-family: verdana, tahoma, arial; font-size: 10px;'></td>
          </tr>
	</form>
</table>
