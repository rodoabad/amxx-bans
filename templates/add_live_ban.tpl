
        <table cellspacing='1' class='listtable' width='100%'>
          <tr>
            <td height='16' colspan='4' class='listtable_top'><b>{"_SELECTSERVER"|lang}</b></td>
          </tr>
          <tr bgcolor="#D3D8DC">
          	<td height='16' width='2%' class='listtable_1'>&nbsp;</td>
            <td height='16' width='50%' class='listtable_1'><b>{"_HOSTNAME"|lang}</b></td>
            <td height='16' width='8%' class='listtable_1'><b>{"_PLAYERS"|lang}</b></td>
            <td height='16' width='40%' class='listtable_1'><b>{"_ADDRESS"|lang}</b></td>
          </tr>

          {foreach from=$servers item=servers}
          <form name='serverinfo' method='post' action='{$this}'>
          <tr {if $servers.maxplayers == ""}bgcolor="#FFEAEA"{elseif $servers.maxplayers == 0 || $servers.maxplayers == "-" || $servers.curplayers == "-"}bgcolor="#D3D8DC"{else}bgcolor="#D3D8DC" style="CURSOR:hand;" onClick="javascript:submit()" onMouseOver="this.style.backgroundColor='#C7CCD2'" onMouseOut="this.style.backgroundColor='#D3D8DC'"{/if}>
            <td height='16' class='listtable_1' align='center'><input type="hidden" name="live_player_ban" value="true"><input type="hidden" name="server_id" value="{$servers.server_id}"><img src='{$dir}/images/{if $servers.gametype == ""}huh{else}{$servers.gametype}{/if}.gif' alt='modification: {if $servers.gametype == ""}{"_UNKNOWN"|lang}{else}{$servers.gametype}{/if}'></td>
            <td height='16' class='listtable_1'>{$servers.hostname}</td>
            <td height='16' class='listtable_1' align='center'>{if $servers.maxplayers == ""}{"_DOWN"|lang}{elseif $servers.maxplayers == 0}{"_NONE"|lang}{else}{$servers.curplayers}/{$servers.maxplayers}{/if}</td>
            <td height='16' class='listtable_1'>

						<table border='0' width='100%' cellspacing='0' cellpadding='0'>
							<tr>
								<td>{$servers.address}</td>
								<td align='right'>{if $browser != "IE"}<input type='submit' name='submit' value='go' style='font-family: verdana, tahoma, arial; font-size: 10px;'{if $servers.maxplayers == "" || $servers.maxplayers == 0}disabled{/if}>{else}&nbsp;{/if}</td>
							</tr>
						</table>
            
            </td>
					</tr>
					</form>
          {foreachelse}
          <tr bgcolor='#D3D8DC'>
            <td height='16' colspan='4' class='listtable_1'>{"_NOSERVFOUND"|lang}</td>
          </tr>
          {/foreach}          
        </table>

				{if $live_player_ban == "true"}
				<br>
        <table cellspacing='1' class='listtable' width='100%'>
          <tr>
            <td height='16' colspan='7' class='listtable_top'><b>{"_SELECTPLAYER"|lang}</b></td>
          </tr>

          <tr bgcolor="#D3D8DC">
          	<td height='16' width='30%' class='listtable_1'><b>{"_NICKNAME"|lang}</b></td>
            <td height='16' width='10%' class='listtable_1'><b>SteamID</b></td>
            <td height='16' width='10%' class='listtable_1'><b>{"_IP"|lang}</b></td>
            <td height='16' width='10%' class='listtable_1'><b>{"_BANTYPE"|lang}</b></td>
            <td height='16' width='10%' class='listtable_1'><b>{"_BANLENGHT"|lang}</b></td>
            <td height='16' width='10%' class='listtable_1'><b>{"_REASON"|lang}</b></td>
            <td height='16' width='20%' class='listtable_1'><b>{"_ACTION"|lang}</b></td>
          </tr>

					{if isset($empty_result)}
          <tr bgcolor="#D3D8DC">
            <td height='16' class='listtable_1' colspan='7'>{"_COMMNORESPONSE"|lang}</td>
					</tr>
				</table>
					{else}
          {foreach from=$players item=players}
          <form name='playerinfo' method='post' action='{$this}'>
          <tr {if $players.is_admin == 1 || $players.steamid == "BOT"}bgcolor="#C7CCD2"{else}bgcolor="#D3D8DC"{/if}>
            
            <td height='16' class='listtable_1'>
            	<input type="hidden" name="server_id" value="{$post.server_id}">
            	<input type="hidden" name="player_nick" value="{$players.nick}">
            	<input type="hidden" name="player_id" value="{$players.steamid}">
            	<input type="hidden" name="player_ip" value="{$players.ip}">
            {if $geoip == "enabled" && ($players.steamid != "BOT") && ($players.cc|lower != "")}
            	<img src='{$dir}/images/flags/{$players.cc|lower}.gif' alt='{$players.cn}'>
            {else}
            	<img src='{$dir}/images/spacer.gif' width='18' height='12'>
            {/if}{$players.nick}</td>
            
            <td height='16' class='listtable_1'>{$players.steamid}</td>
            <td height='16' class='listtable_1'>{$players.ip}</td>
            <td height='16' class='listtable_1'>
            
            <select name='ban_type' style='font-family: verdana, tahoma, arial; font-size: 10px;' {if $players.is_admin == 1 || $players.steamid == "BOT"}disabled{/if}>
						<option value='S'>SteamID</option>
						<option value='SI'>{"_STEAMID&IP"|lang}</option>
						</select>
            
            </td>
						<td height='16' class='listtable_1'>

						<select name='ban_length' style='font-family: verdana, tahoma, arial; font-size: 10px;' {if $players.is_admin == 1 || $players.steamid == "BOT"}disabled{/if}>
						<option value='0'>Permanent</option>
						<optgroup label="minutes">
						<option value='1'>1 min</option>
						<option value='5'>5 mins</option>
						<option value='10'>10 mins</option>
						<option value='15'>15 mins</option>
						<option value='30'>30 mins</option>
						<option value='45'>45 mins</option>
						<optgroup label="hours">
						<option value='60'>1 hour</option>
						<option value='120'>2 hours</option>
						<option value='180'>3 hours</option>
						<option value='240'>4 hours</option>
						<option value='480'>8 hours</option>
						<option value='720'>12 hours</option>

						<optgroup label="days">
						<option value='1440'>1 day</option>
						<option value='2880'>2 days</option>
						<option value='4320'>3 days</option>
						<option value='5760'>4 days</option>
						<option value='7200'>5 days</option>
						<option value='8640'>6 days</option>
						<optgroup label="Weeks">
						<option value='10080'>1 week</option>
						<option value='20160'>2 weeks</option>
						<option value='30240'>3 weeks</option>
						<optgroup label="Months">
						<option value='40320'>1 month</option>
						<option value='80640'>2 months</option>
						<option value='120960'>3 months</option>
						<option value='241920'>6 months</option>
						<option value='483840'>12 months</option>
						</select>
						</td>

            <td height='16' class='listtable_1'><input type='text' name='ban_reason' style='font-family: verdana, tahoma, arial; font-size: 10px; width: 150px' {if $players.is_admin == 1 || $players.steamid == "BOT"}disabled{/if}></td>
						<td height='16' class='listtable_1' align='right'><input type='submit' name='submit' value='{"_KICKBAN"|lang}' style='font-family: verdana, tahoma, arial; font-size: 10px;' {if $players.is_admin == 1 || $players.steamid == "BOT"}disabled{/if}></td>
					</tr>
					</form>
          {foreachelse}
          <tr bgcolor='#D3D8DC'>
            <td height='16' colspan='7' class='listtable_1' align='center'><br>{"_NOPLAYERORWRONGRCON"|lang}<br><br></td>
          </tr>
          {/foreach}          
        </table>
				{/if}
				{/if}



