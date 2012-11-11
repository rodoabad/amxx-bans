
{if $any_outdated == true}
<table cellspacing='1' class='listtable' width='100%'>
  <tr>
  	<td height='16' class='listtable_top'><b>New AMX Plugin available!</b></td>
  </tr>
  <tr bgcolor="#D3D8DC">
	<td height='32' width='100%' class='listtable_1' colspan='5' align='center'><br><br>A new version of the AMXBans Plugin is available for one (or more) of your servers listed below. You can download it at:<br><font color='#ff0000'><a href='{$update_url}' class='alert'  target="_blank">{$update_url}</a></font><br><br></td>
  </tr>
</table>
<br>
{/if}

<table class="table table-bordered">
    <thead>
        <tr>
            <th></th>
            <th>{'_HOSTNAME'|lang}</th>
            <th>{'_ADDRESS'|lang}</th>
            <th>{'_LASTSEEN'|lang}</th>
            <th>{'_VERSION'|lang}</th>
            <th>{'_BANMENU'|lang}</th>
            <th>{'_ACTION'|lang}</th>
        </tr>
    </thead>
    <tbody>
        {foreach from=$servers item=servers}
            <tr>
                <td><img src='{$dir}/images/{if $servers.gametype == ""}huh{else}{$servers.gametype}{/if}.gif' alt='modification: {if $servers.gametype == ""}{"_UNKNOWN"|lang}{else}{$servers.gametype}{/if}'></td>
                <td>{$servers.hostname}</td>
                <td>
                    <a href="steam://connect/{$servers.address}">{$servers.address}</a>
                </td>
    	        <td>{$servers.timestamp|date_format:"%d-%m-%y %H:%M"}</td>
                <td>{$servers.version} ({$servers.plugin})</td>
                <form name='editserver' method='post' action='{$this}'>
                    <td>
                        {if $servers.amxban_menu != 0}
                            <button class="btn btn-info" type="submit" name="list_reasons" value="{'_SHOWREASONS'|lang}"><i class="icon-tasks icon-white"></i> {'_SHOWREASONS'|lang}</button>
                        {/if}
                    </td>
                    <td>
                        {if ($smarty.session.servers_edit == "yes")}
                            <input type='hidden' name='id' value='{$servers.id}'>
                            <input type='hidden' name='hostname' value='{$servers.hostname}'>
                            <input type='hidden' name='address' value='{$servers.address}'>
                            <input type='hidden' name='rcon' value='{$servers.rcon}'>
                            <input type='hidden' name='gametype' value='{$servers.gametype}'>
                            <input type='hidden' name='amxban_motd' value='{$servers.amxban_motd}'>
                            <input type='hidden' name='motd_delay' value='{$servers.motd_delay}'>
                            <button class="btn btn-warning" type="submit" name="edit" value="'{'_EDIT'|lang}"><i class="icon-pencil icon-white"></i> {'_EDIT'|lang}</button>
                            <button class="btn btn-danger" type="submit" name="remove" value="{'_REMOVE'|lang}" {if ($smarty.session.servers_edit != "yes")}disabled{/if}onclick="javascript:return confirm('{"_DELSERVER"|lang}')"><i class="icon-trash icon-white"></i> {'_REMOVE'|lang}</button>
                        {/if}
                    </td>
    	        </form>
            </tr>
        {foreachelse}
            <tr>
                <td>{"_NOSERVERS"|lang}</td>
            </tr>
        {/foreach}
    </tbody>
</table>


{if isset($edit)}
<br>
<table cellspacing='1' class='listtable' width='100%'>
          <form name='applyserver' method='post' action='{$this}'>
          <input type='hidden' name='id' value='{$id}'>
          <tr>
            <td height='16' colspan='2' class='listtable_top'><b>{"_SERVERDETAILS"|lang} {$hostname} ({$address})</b></td>
          </tr>
          <tr bgcolor="#D3D8DC">
            <td height='16' width='30%' class='listtable_1'>{"_MODIFICATION"|lang}</td>
            <td height='16' width='70%' class='listtable_1'>
		<select name='mod' style='font-family: verdana, tahoma, arial; font-size: 10px; width: 350px'>
			<option value='huh' {if $gametype == "huh"}selected{/if}>{"_SELMODIFICATION"|lang}</option>
			<option value='cstrike' {if $gametype == "cstrike"}selected{/if}>Counter-Strike</option>
			<option value='czero' {if $gametype == "czero"}selected{/if}>Condition Zero</option>
			<option value='dod' {if $gametype == "dod"}selected{/if}>Day of Defeat</option>
			<option value='ns' {if $gametype == "ns"}selected{/if}>Natural Selection</option>
			<option value='tfc' {if $gametype == "tfc"}selected{/if}>Team Fortress Classic</option>
			<option value='ts' {if $gametype == "ts"}selected{/if}>The Specialists</option>
			
		</select>
	    </td>
          </tr>
          <tr bgcolor="#D3D8DC">
            <td height='16' width='30%' class='listtable_1'>RCON</td>
            <td height='16' width='70%' class='listtable_1'><input type='text' name='rcon' value='{$rcon}' style='font-family: verdana, tahoma, arial; font-size: 10px; width: 350px'></td>
          </tr>
          <tr bgcolor="#D3D8DC">
            <td height='16' width='30%' class='listtable_1'>{"_AMXBANSMOTDURL"|lang}</td>
            <td height='16' width='70%' class='listtable_1'><input type='text' name='amxban_motd' value='{$amxban_motd}' style='font-family: verdana, tahoma, arial; font-size: 10px; width: 350px'></td>
          </tr>
          <tr bgcolor="#D3D8DC">
            <td height='16' width='30%' class='listtable_1'>{"_AMXBANSMOTDURLDELAY"|lang}</td>
            <td height='16' width='70%' class='listtable_1'>
		<select name='motd_delay' style='font-family: verdana, tahoma, arial; font-size: 10px; width: 350px'>
			<option value='0' {if $motd_delay == 0}selected{/if}>0</option>
			<option value='1' {if $motd_delay == 1}selected{/if}>1</option>
			<option value='5' {if $motd_delay == 5}selected{/if}>5</option>
			<option value='10' {if $motd_delay == 10}selected{/if}>10</option>
			<option value='30' {if $motd_delay == 30}selected{/if}>30</option>
			<option value='60' {if $motd_delay == 60}selected{/if}>60</option>
		</select>
	    </td>
          </tr>
          <tr bgcolor="#D3D8DC">
            <td height='16' width='100%' class='listtable_1' colspan='2' align='right'><input type='submit' name='apply' value='{"_APPLY"|lang}' style='font-family: verdana, tahoma, arial; font-size: 10px;'></td>
          </tr>
          </form>
</table>
{/if}


<br>
{if isset($list_reasons)}
        
<table cellspacing='1' class='listtable' width='100%'>

          <input type='hidden' name='id' value='{$id}'>
          <tr>
            <td height='16' colspan='3' class='listtable_top'><b>{"_BANREASONSFOR"|lang} {$hostname} ({$address})</b></td>
          </tr>
	{foreach from=$reasons name=reasons item=reasons}
          <form name='applyreasons' method='post' action='{$this}'><input type='hidden' name='address' value='{$address}'>
          <input type='hidden' name='list_reasons' value='whatever'>
          <tr bgcolor="#D3D8DC">
            <td height='16' width='30%' class='listtable_1'><input type='hidden' name='id' value='{$reasons.id}'>{"_BANREASON"|lang} {$smarty.foreach.reasons.iteration}</td>
            <td height='16' width='50%' class='listtable_1'><input type='text' name='reason' value='{$reasons.reason}' style='font-family: verdana, tahoma, arial; font-size: 10px; width: 350px'></td>
	    <td heigth='16' width='20%' class='listtable_1' align='right'><input type='submit' name='action' value='{"_EDIT"|lang}' style='font-family: verdana, tahoma, arial; font-size: 10px;'> <input type='submit' name='action' value='{"_REMOVE"|lang}' style='font-family: verdana, tahoma, arial; font-size: 10px;' onclick="javascript:return confirm('{"_DELBANREASON"|lang}')"></td>
          </tr>
          </form>
          {/foreach}
	{if $action == lang("_ADD")}
          <form name='applyreasons' method='post' action='{$this}'>
          <input type='hidden' name='address' value='{$address}'>
          <tr bgcolor="#D3D8DC">
            <td height='16' width='30%' class='listtable_1'>{"_BANREASON"|lang}</td>
            <td height='16' width='50%' class='listtable_1'><input type='hidden' name='list_reasons' value='whatever'><input type='text' name='reason' style='font-family: verdana, tahoma, arial; font-size: 10px; width: 350px'></td>
	    <td heigth='16' width='20%' class='listtable_1' align='right'><input type='submit' name='action' value='{"_APPLY"|lang}' style='font-family: verdana, tahoma, arial; font-size: 10px;'></td>
          </tr>
          </form>
	{/if}
		<form name='applyreasons' method='post' action='{$this}'>
		<input type='hidden' name='list_reasons' value='whatever'><input type='hidden' name='address' value='{$address}'>
          <tr bgcolor="#D3D8DC">
            <td height='16' width='100%' class='listtable_1' colspan='3' align='right'>{if $smarty.foreach.reasons.total < 7}<input type='submit' name='action' value='{"_ADD"|lang}' style='font-family: verdana, tahoma, arial; font-size: 10px;'>{else}&nbsp;{/if}</td>
          </tr>
          </form>
</table>
{/if}
