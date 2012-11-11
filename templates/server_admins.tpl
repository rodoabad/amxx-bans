<ul class="breadcrumb">
    <li><a href="{$dir}">Home</a> <span class="divider">/</span></li>
    <li>Admin <span class="divider">/</span></li>
    <li>{'_SERVERS'|lang}</li>
</ul>

    <table class="table table-bordered">
        <tbody>
		  
    					<tr>
    						<td>
    						    {'_SELECTSERVER'|lang}
    						</td>
    						<td>
    						    <form class="form-horizontal" name="server" method="get" action="{$this}">
    						    <input type='hidden' name'submitted' value='true'>
    							<select name='server_id' onChange="javascript:document.server.submit()">
    							<option value='xxx'>
    							    {"_SELECTSERVER"|lang}
    							</option>
    							{foreach from=$servers item=servers}
                                    <option value='{$servers.id}'{if $servers.id == $thisserver} selected{/if}>{$servers.hostname}</option>
    							{/foreach}
    							</select>
    							</form>
    						</td>
    					</tr>
					
					<form class="form-horizontal" name='admins' method='get' action='{$this}'>
					<input type='hidden' name='server_id' value='{$thisserver}'>
					<input type='hidden' name='action' value='apply'>
					<tr>
						<td>{"_SERVERADMINS"|lang}</td>
						<td>
						    <fieldset>
						{if isset($thisserver)}
						    <label class="checkbox"><input class="checkall" type="checkbox" /> Check/Uncheck All</label>
    						{foreach from=$all_admins item=admin}
        						<input type='hidden' name='{$admin.id}' class='filecheck' value='off'>
        						<label class="checkbox"><input type="checkbox" name="{$admin.id}" {if $admin.checked == 1}checked{/if}> {$admin.nickname} ({$admin.username})</label>
    						{/foreach}
						{/if}
						</fieldset>
            </td>
          </tr>
          <tr>
		      <td colspan='2'>
		          <button class="btn btn-warning btn-block" type='submit'>{'_CONFIRM'|lang}</button>
		      </td>
		  </tr>
					</form>
					</tbody>
        </table>
