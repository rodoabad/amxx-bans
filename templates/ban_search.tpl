
{if $display_search != "enabled" && ($smarty.session.bans_add != "yes")}
<table cellspacing='0' border='0' width='100%'>
    <tr>
        <td height='100' align='center'><b><font color='red' size='3'>{"_NOACCESS"|lang}</font></b></td>
         </tr>
</table> 
{else}
            <form class="form-horizontal" name="searchnick" method="get" action="{$this}">
                <div class="control-group">
                    <legend>Search</legend>
                    <input class="input-xlarge" type="text" name="q" value="{$nick}" placeholder="What are you looking for?">
                    <select name="type">
                        <option value="playername">Player Name</option>
                        <option value="steamid">Steam ID</option>
                        <option value="ipaddress">IP Address</option>
                        <option value="reason">Reason</option>
                        <option value="datebanned">Date Banned</option>
                        <option value="bancount">Ban Count</option>
                        <option value="admin">Admin</option>
                        <option value="server">Server</option>                    
                    </select>
                    <button class="btn btn-primary" type="submit">{'_SEARCH'|lang}</button>
                    <span class="btn btn-info">Advanced Options</span>
                </div>
            </form>
<table class="table table-bordered">

    <tbody>

          <tr>
            <form name="searchreason" method="get" action="{$this}">
            <td>{"_REASON"|lang}</td>
            <td><input type='text' name='reason' value='{$reason}'></td>
            <td><input type='submit' name='submit' value='{"_SEARCH"|lang}'></td>
            <select name='reason'>
                {section name=mysec loop=$reasons}
                {html_options values=$reasons[mysec].reasons output=$reasons[mysec].reasons}
                {/section}
            </select>
            </form>
          </tr>
    
    <tr>
          <form name="searchdate" method="get" action="{$this}">
            <td>{"_DATE"|lang}</td>
            <td>
                <input type='text' name='date' value='{$smarty.now|date_format:"%d-%m-%Y"}'>
                <script language="JavaScript" src="calendar1.js"></script>
                <a href="javascript:cal1.popup();"><img src="{$dir}/images/cal.gif" width="16" height="16" border="0" alt="Pick a date"></a>
            </td>
            <td>
                <input type='submit' name='submit' value='{"_SEARCH"|lang}'>
            </td>
      </form>
<script>

    var cal1 = new calendar1(document.forms['searchdate'].elements['date']);
    cal1.year_scroll = true;
    cal1.time_comp = false;

</script>
          </tr>
          
          {if $display_admin == "enabled" || ($smarty.session.bans_add == "yes")}
          <tr>
            <form name="searchadmin" method="get" action="{$this}">
            <td>{"_ADMIN"|lang}</td>
            <td>
                <select name='admin'>
                    {section name=mysec loop=$admins}
                        {html_options values=$admins[mysec].steamid output=$admins[mysec].nickname}
                    {/section}
                </select>
            </td>
            <td>
                <input type='submit' name='submit' value='{"_SEARCH"|lang}'>
            </td>
            </form>
          </tr>
          {/if}
        <tr>
          <form name="searchserver" method="get" action="{$this}">
            <td>{"_SERVER"|lang}</td>
            <td>

        <select name="server">
            {section name=mysec2 loop=$servers}
                {html_options values=$servers[mysec2].address output=$servers[mysec2].hostname}
            {/section}
            <option value=''>website</option>
        </select>

            </td>
            <td height='16' width='5%' class='listtable_1'><input type='submit' name='submit' value='{"_SEARCH"|lang}' style='font-family: verdana, tahoma, arial; font-size: 10px;'></td>
          </form>
        </tr>
    </tbody>
</table>

{if isset($nick) || isset($steamid) || isset($reason) || isset($date) || isset($timesbanned) || isset($admin) || isset($server)}
<br>

<table class="table table-bordered">
    <tr>
        <td>{"_ACTIVEBANS"|lang}</td>
    </tr>
</table>

<table class="table table-bordered">
          <tr>
            <th></th>
            <th>{"_DATE"|lang}</th>
            <th>{"_PLAYER"|lang}</th>
            <th>{"_ADMIN"|lang}</th>
            {if $display_reason == "enabled"}
                <th>{'_REASON'|lang}</th>
            {/if}
            <th>{'_LENGTH'|lang}</th>
            <th>Server</th>
            <th>Options</th>
            
          </tr>
          {foreach from=$bans item=bans}
          <tr>
            <td><img src='{$dir}/images/{$bans.gametype}.gif'></td>
            <td>{$bans.date}</td>
            <td>{$bans.playernick}</td>
            <td>{if $display_admin == "enabled" || ($smarty.session.bans_add == "yes")}{$bans.adminnick}{else}{"_HIDDEN"|lang}{/if}</td>
           {if $display_reason == "enabled"}<td>{$bans.reason}</td>{/if}
            <td>{$bans.duration}</td>
            <td>{$bans.servername} ({$bans.gametype})</td>
          <td height='16' width='2%' class='listtable_1'>
                <table width='100%' border='0' cellpadding='0' cellspacing='0'>
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
          
          </tr>






{foreachelse}
          <tr bgcolor="#D3D8DC">
            <td height='16' colspan='7' class='listtable_1'>No active ban(s) found for that {if isset($nick)}(part of) nickname{elseif isset($steamid)}steamID{elseif isset($date)}date{elseif isset($admin)}admin{elseif isset($server)}server{/if}.</td>
          </tr>
{/foreach}
</table>
<table cellspacing='0' border='0' width='100%'>
    <tr>
        <td height='16' align='left'><b><font color='red' size='2'>{"_TOTALACTBANS"|lang} ({$bans.bancount})</font></b></td>
        </tr>
</table>


<br><br>



<table cellspacing='0' border='0' width='100%'>
    <tr>
        <td height='16' align='left'><b><font color='green' size='3'>{"_EXPIREDBANS"|lang}</font></b></td>
        </tr>
</table>

<table cellspacing='1' class='listtable' width='100%'>
    <tr>
            <td height='16' width='2%'  class='listtable_top'>&nbsp;</td>
            <td height='16' width='{if $display_reason == "enabled"}10%{else}15%{/if}' class='listtable_top'><b>{"_DATE"|lang}</b></td>
            <td height='16' width='{if $display_reason == "enabled"}23%{else}33%{/if}' class='listtable_top'><b>{"_PLAYER"|lang}</b></td>
            <td height='16' width='{if $display_reason == "enabled"}20%{else}30%{/if}' class='listtable_top'><b>{"_ADMIN"|lang}</b></td>
            {if $display_reason == "enabled"}<td height='16' width='25%' class='listtable_top'><b>{"_REASON"|lang}</b></td>{/if}
            <td height='16' width='16%' class='listtable_top'><b>{"_LENGHT"|lang}</b></td>
            <td height='16' width='2%' class='listtable_top'>&nbsp;</td>
         </tr>
          
    
   {foreach from=$exbans item=exbans}
          
          
         <tr bgcolor="#D3D8DC" style="CURSOR:hand;" onClick="document.location = '{$dir}/ban_details.php?bhid={$exbans.bhid}';" onMouseOver="this.style.backgroundColor='#C7CCD2'" onMouseOut="this.style.backgroundColor='#D3D8DC'">
            <td height='16' width='2%'  class='listtable_1' align='center'><img src='{$dir}/images/{$exbans.ex_gametype}.gif'></td>
            <td height='16' width='{if $display_reason == "enabled"}10%{else}15%{/if}%' class='listtable_1'>{$exbans.ex_date}</td>
            <td height='16' width='{if $display_reason == "enabled"}23%{else}33%{/if}' class='listtable_1'>{$exbans.ex_player}</td>
            <td height='16' width='{if $display_reason == "enabled"}20%{else}30%{/if}' class='listtable_1'>{if $display_admin == "enabled" || ($smarty.session.bans_add == "yes")}{$exbans.ex_admin}{else}<i><font color='#677882'>{"_HIDDEN"|lang}</font></i>{/if}</td>
            {if $display_reason == "enabled"}<td height='16' width='25%' class='listtable_1'>{$exbans.ex_reason}</td>{/if}
            <td height='16' width='16%' class='listtable_1'>{$exbans.ex_duration}</td>
            
            <td height='16' width='2%' class='listtable_1'>
                <table width='100%' border='0' cellpadding='0' cellspacing='0'>
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
