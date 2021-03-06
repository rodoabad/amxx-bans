{if $display_search != "enabled" && ($smarty.session.bans_add != "yes")}
	{"_NOACCESS"|lang}
{else}

<ul class="breadcrumb">
  <li>Home <span class="divider">/</span></li>
  <li class="active">Search</li>
</ul>

    <h3>Search</h3>
	<form class="form-inline" method="get" action="{$this}">
    	<div class="control-group">
            <select name="type" class="span2">
                <option value="player">Player</option>
                <option value="steamid">Steam ID</option>
                <option value="ipaddress">IP Address</option>
                <option value="reason">Reason</option>
                <option value="datebanned">Date Banned</option>
                <option value="bancount">Ban Count</option>
                <option value="admin">Admin</option>
                <option value="server">Server</option>
            </select>
            <input class="span9" type="text" name="q" placeholder="What are you looking for?">
            <button class="btn btn-primary" type="submit">{'_SEARCH'|lang}</button>
        </div>
    </form>

	{if isset($nick) || isset($steamid) || isset($reason) || isset($date) || isset($timesbanned) || isset($admin) || isset($server)}

		<h3>{'_ACTIVEBANS'|lang}</h3>
		<table class="table table-bordered">
        	<tr>
            	<th>{'_LENGTH'|lang}</th>
            	<th class="hidden-phone">Game</th>
            	<th>{"_DATE"|lang}</th>
            	<th>{"_PLAYER"|lang}</th>
            	<th>{"_ADMIN"|lang}</th>
            	{if $display_reason == "enabled"}
	                <th>{'_REASON'|lang}</th>
            	{/if}

            	<th>Server</th>
            	<!-- <th>Options</th> -->
			</tr>

          	{foreach from=$bans item=bans}
          		<tr>
          		    <td>
          		        {if $bans.duration == 'Permanent'}
          		            <span class="label label-important">{$bans.duration}</span>
          		        {else}
                            <span class="label label-warning">{$bans.duration}</span>
                        {/if}
          		    </td>
            		<!-- <td><img src='{$dir}/images/{$bans.gametype}.gif'></td> -->
            		<td class="hidden-phone"><span class="label label-info">{$bans.gametype}</span></td>
            		<td>{$bans.date}</td>
            		<td>
            		  <a href="{$dir}/ban.php?bid={$bans.bid}"><i class="icon-user"></i></a> {$bans.player}
            		</td>
            		<td>{if $display_admin == "enabled" || ($smarty.session.bans_add == "yes")}{$bans.adminnick}{else}{"_HIDDEN"|lang}{/if}</td>
           			{if $display_reason == "enabled"}
           				<td>{$bans.reason}</td>
           			{/if}

            		<td>{$bans.servername} ({$bans.gametype})</td>
          			<!--
          			<td>
                		<table>
            				<tr>
                				{if (($smarty.session.bans_edit == "yes") || (($smarty.session.bans_edit == "own") && ($smarty.session.uid == $bans.webadmin)))}
                					<form name="delete" method="get" action="{$dir}/admin/edit_ban.php"><input type='hidden' name='action' value='edit'><input type='hidden' name='bid' value='{$bans.bid}'><td align='right' width='1%'><input type='image' SRC='{$dir}/images/edit.gif' name='action' ALT='{"_EDIT"|lang}'>&nbsp;&nbsp;</td></form>
                				{/if}
                				{if (($smarty.session.bans_unban == "yes") || (($smarty.session.bans_unban == "own") && ($smarty.session.uid == $bans.webadmin)))}
        							<form name="unban" method="get" action="{$dir}/admin/edit_ban.php"><input type='hidden' name='action' value='unban'><input type='hidden' name='bid' value='{$bans.bid}'><td align='right' width='1%'><input type='image' SRC='{$dir}/images/locked.gif' name='action' ALT='{"_UNBAN"|lang}'>&nbsp;</td></form>
        						{/if}
                				{if (($smarty.session.bans_delete == "yes") || (($smarty.session.bans_delete == "own") && ($smarty.session.uid == $bans.webadmin)))}
                					<form name="unban" method="get" action="{$dir}/admin/edit_ban.php"><input type='hidden' name='action' value='delete'><input type='hidden' name='bid' value='{$bans.bid}'><td align='right' width='1%'><input type='image' src='{$dir}/images/delete.gif' name='delete' alt='{"_DELETE"|lang}' onclick="javascript:return confirm('Are you sure you want to remove ban_id {$bans.bid}?')"></td></form>
                				{/if}
            				</tr>
        				</table>
            		</td>
            		-->
          		</tr>
			{/foreach}
			<tr>
				<td colspan="7">
					{if $bans.bancount}
						{'_TOTALACTBANS'|lang}: {$bans.bancount}
					{else}
						No active bans found.
					{/if}
				</td>
			</tr>
		</table>

		<h3>{'_EXPIREDBANS'|lang}</h3>

		<table>
		    <tr>
	            <td>&nbsp;</td>
	            <td><b>{"_DATE"|lang}</b></td>
	            <td><b>{"_PLAYER"|lang}</b></td>
	            <td><b>{"_ADMIN"|lang}</b></td>
	            {if $display_reason == "enabled"}<td height='16' width='25%' class='listtable_top'><b>{"_REASON"|lang}</b></td>{/if}
	            <td><b>{"_LENGHT"|lang}</b></td>
	            <td>&nbsp;</td>
	    	</tr>


   {foreach from=$exbans item=exbans}


         <tr bgcolor="#D3D8DC" style="CURSOR:hand;" onClick="document.location = '{$dir}/ban.php?bhid={$exbans.bhid}';" onMouseOver="this.style.backgroundColor='#C7CCD2'" onMouseOut="this.style.backgroundColor='#D3D8DC'">
            <td><img src='{$dir}/images/{$exbans.ex_gametype}.gif'></td>
            <td>{$exbans.ex_date}</td>
            <td>{$exbans.ex_player}</td>
            <td>{if $display_admin == "enabled" || ($smarty.session.bans_add == "yes")}{$exbans.ex_admin}{else}<i><font color='#677882'>{"_HIDDEN"|lang}</font></i>{/if}</td>
            {if $display_reason == "enabled"}<td height='16' width='25%' class='listtable_1'>{$exbans.ex_reason}</td>{/if}
            <td>{$exbans.ex_duration}</td>

            <td>
                <table>
            <tr>
                {if (($smarty.session.bans_edit == "yes") || (($smarty.session.bans_edit == "own") && ($smarty.session.uid == $bans.webadmin)))}
                <form name="delete" method="get" action="{$dir}/admin/edit_ban_ex.php"><input type='hidden' name='action' value='edit_ex'><input type='hidden' name='bhid' value='{$exbans.bhid}'><td align='right' width='1%'><input type='image' SRC='{$dir}/images/edit.gif' name='action' ALT='{"_EDIT"|lang}'>&nbsp;&nbsp;</td></form>
                {/if}
                {if (($smarty.session.bans_delete == "yes") || (($smarty.session.bans_delete == "own") && ($smarty.session.uid == $bans.webadmin)))}
                <form name="unban" method="get" action="{$dir}/admin/edit_ban_ex.php"><input type='hidden' name='action' value='delete_ex'><input type='hidden' name='bhid' value='{$exbans.bhid}'><td align='right' width='1%'><input type='image' src='{$dir}/images/delete.gif' name='delete' alt='{"_DELETE"|lang}' onclick="javascript:return confirm('Are you sure you want to remove ban_id {$exbans.bhid}?')"></td></form>
                {/if}
            </tr>
        </table>
            </td>
          </tr>

{foreachelse}
          <tr bgcolor="#D3D8DC">
            <td height='16' colspan='7' class='listtable_1'>No expired ban(s) found for that {if isset($steamid)}steamID{elseif isset($date)}date{elseif isset($admin)}admin{elseif isset($server)}server{/if}.</td>
          </tr>
{/foreach}
</table>
<table cellspacing='0' border='0' width='100%'>
    <tr>
        <td height='16' align='left'><b><font color='green' size='2'>{"_TOTALEXPBANS"|lang} ({$exbans.ex_bancount})</font></b></td>
        </tr>
</table>
{/if}

{/if}
