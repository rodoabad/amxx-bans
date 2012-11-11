{if ($smarty.session.bans_add == "yes")}
        <table class="table table-bordered">
          <tr>
            <td colspan="3"><b>{"_ADD"|lang}</b></td>
          </tr>
					<form name="addban" method="post" action="{$this}">
					<input type='hidden' name='action' value='insert'>
          <tr>
            <td height='16' width='30%' class='listtable_1'>{"_NICKNAME"|lang}</td>
            <td height='16' width='70%' class='listtable_1'><input type='text' name='player_nick' value='{if isset($post.player_nick)}{$post.player_nick}{/if}' style='font-family: verdana, tahoma, arial; font-size: 10px; width: 250px'></td>
          </tr>
          <tr>
            <td height='16' width='30%' class='listtable_1'>{"_BANTYPE"|lang}</td>
            <td height='16' width='70%' class='listtable_1'>
						<select name='ban_type' style='font-family: verdana, tahoma, arial; font-size: 10px; width: 250px'>
						<option value='S'>SteamID</option>
						<option value='SI'>{"_STEAMID&IP"|lang}</option>
						</select>
            </td>
          </tr>
          <tr>
            <td height='16' width='30%' class='listtable_1'>SteamID</td>
            <td height='16' width='70%' class='listtable_1'><input type='text' name='player_id' value='{if isset($post.player_id)}{$post.player_id}{/if}'style='font-family: verdana, tahoma, arial; font-size: 10px; width: 250px'> &nbsp; (e.g. STEAM_0:1:4548)</td>
          </tr>
          <tr>
            <td height='16' width='30%' class='listtable_1'>{"_IP"|lang}</td>
            <td height='16' width='70%' class='listtable_1'><input type='text' name='player_ip' value='{if isset($post.player_ip)}{$post.player_ip}{/if}'style='font-family: verdana, tahoma, arial; font-size: 10px; width: 250px'></td>
          </tr>
          <tr>
            <td height='16' width='30%' class='listtable_1'>{"_BANLENGHT"|lang}</td>
            <td height='16' width='70%' class='listtable_1'>

						<select name='ban_length' style='font-family: verdana, tahoma, arial; font-size: 10px; width: 250px'' {if $players.is_admin == 1}disabled{/if}>
						<option value='0'>{"_PERMANENT"|lang}</option>
						<optgroup label="{"_MINS"|lang}">
						<option value='1'>1 {"_MIN"|lang}</option>
						<option value='5'>5 {"_MINS"|lang}</option>
						<option value='10'>10 {"_MINS"|lang}</option>
						<option value='15'>15 {"_MINS"|lang}</option>
						<option value='30'>30 {"_MINS"|lang}</option>
						<option value='45'>45 {"_MINS"|lang}</option>
						<optgroup label="{"_HOURS"|lang}">
						<option value='60'>1 {"_HOUR"|lang}</option>
						<option value='120'>2 {"_HOURS"|lang}</option>
						<option value='180'>3 {"_HOURS"|lang}</option>
						<option value='240'>4 {"_HOURS"|lang}</option>
						<option value='480'>8 {"_HOURS"|lang}</option>
						<option value='720'>12 {"_HOURS"|lang}</option>

						<optgroup label="{"_DAYS"|lang}">
						<option value='1440'>1 {"_DAY"|lang}</option>
						<option value='2880'>2 {"_DAYS"|lang}</option>
						<option value='4320'>3 {"_DAYS"|lang}</option>
						<option value='5760'>4 {"_DAYS"|lang}</option>
						<option value='7200'>5 {"_DAYS"|lang}</option>
						<option value='8640'>6 {"_DAYS"|lang}</option>
						<optgroup label="{"_WEEKS"|lang}">
						<option value='10080'>1 {"_WEEK"|lang}</option>
						<option value='20160'>2 {"_WEEKS"|lang}</option>
						<option value='30240'>3 {"_WEEKS"|lang}</option>
						<optgroup label="{"_MONTHS"|lang}">
						<option value='40320'>1 {"_MONTH"|lang}</option>
						<option value='80640'>2 {"_MONTHS"|lang}</option>
						<option value='120960'>3 {"_MONTHS"|lang}</option>
						<option value='241920'>6 {"_MONTHS"|lang}</option>
						<option value='483840'>12 {"_MONTHS"|lang}</option>
						</select>

            </td>
          </tr>
          <tr>
            <td>{"_REASON"|lang}</td>
            <td><input type='text' name='ban_reason'></td>
          </tr>
					<tr>
						<td colspan="2">
						    <button class="btn btn-warning btn-block" type="submit">Ban User</button>
						</td>
          </tr>
          </form>
        </table>
{else}
<h1>YOU NEED TO LOGIN!!!</h1>   
{/if}