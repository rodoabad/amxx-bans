
        <table class="table table-bordered">
          <tr>
            <td colspan="2"><b>{"_ACCESSLOG"|lang}</b></td>
          </tr>
          <form name="searchdate" method="post" action="{$this}">
          <tr>
            <td>{"_DATE"|lang}</td>
            <td><input type='text' name='date' value='{if !isset($date)}{$smarty.now|date_format:"%d-%m-%Y"}{else}{if $date != "%"}{$date}{/if}{/if}' style='font-family: verdana, tahoma, arial; font-size: 10px; width: 250px'>&nbsp;<script language="JavaScript" src="calendar1.js"></script><a href="javascript:cal1.popup();"><img src="{$dir}/images/cal.gif" width="16" height="16" border="0" alt="Pick a date"></a></td>
					</tr>
					<script language="JavaScript">
						<!--
							var cal1 = new calendar1(document.forms['searchdate'].elements['date']);
							cal1.year_scroll = true;
							cal1.time_comp = false;
						-->
					</script>
          </tr>
          <tr>
            <td>{'_ADMIN'|lang}</td>
            <td>

							<select name='admin'>
								<option value='all'>{"_ALL"|lang}</option>
								{foreach from=$admins item=admins}
								<option value='{$admins}' {if $admins == $admin}selected{/if}>{$admins}</option>
								{/foreach}
							</select>

            </td>
          </tr>
          <tr>
            <td>{"_ACTION"|lang}</td>
            <td>

							<select name='action' style='font-family: verdana, tahoma, arial; font-size: 10px; width: 250px'>
								<option value='all'>{"_ALL"|lang}</option>
								{foreach from=$actions item=actions}
								<option value='{$actions}' {if $actions == $action}selected{/if}>{$actions}</option>
								{/foreach}
							</select>

            </td>
          </tr>
          <tr>
			<td colspan="2">
			    <button class="btn btn-block" type="submit">Search</button>
			</td>
		</tr>
					</form>
        </table>

				<br>

        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>{'_DATE'|lang}</th>
                    <th>{'_ADMIN'|lang}</th>
                    <th>{'_IP'|lang}</th>
                    <th>{'_ACTION'|lang}</th>
                    <th>{'_REMARKS'|lang}</th>
                </tr>
            </thead>
            <tbody>

            {foreach from=$logs item=logs}
            <tr>
                <td>{$logs.date}</td>
                <td>{$logs.username}</td>
                <td>{$logs.ip}</td>
                <td>
                    {if $logs.action == 'add ban' || $logs.action == 'unban ban' || $logs.action == 'delete ban' || $logs.action == 'edit ban'}
                        <span class="label label-info">{$logs.action}</span>
                    {elseif $logs.action == 'admin logins'}
                        <span class="label label-important">{$logs.action}</span>
                        {elseif $logs.action == 'serveradmins' || $logs.action == 'server management' || $logs.action == 'amxadmins management'
                        || $logs.action == 'lvl management' || $logs.action == 'webadmins management'}
                        <span class="label label-warning">{$logs.action}</span>
                    {elseif $logs.action == 'AMXBans config' || $logs.action == 'prune bans'}
                        <span class="label label-success">{$logs.action}</span>
                    {else}
                        {$logs.action}
                    {/if}
                    
                </td>
                <td>{$logs.remarks}</td>
            </tr>
            {foreachelse}
                <tr>
                    <td colspan="6">
                        {'_NOLOGFOUND'|lang}
                    </td>
                </tr>
            {/foreach}
            </tbody>
        </table>
 				