<div class="hero-unit">
    <h1>Export Bans</h1>
    <p>This will export all the bans based on the options that you choose in HLDS format - ready to be added to your server. All you have to do is download the file </p>
    <form class="form form-inline" name="export" enctype="multipart/form-data" method="post" action="{$this}">
        <input type="hidden" name="submitted" value="true">
        <label>Game Type</label>
        <select name="gtype">
            <option value='all'>{"_ALLGAMETYPES"|lang}</option>
            {section name=mysec loop=$gametypes}
                {html_options values=$gametypes[mysec].gametype output=$gametypes[mysec].gametype}
             {/section}
         </select>
         <label>Ban Type</label>
         <select name="bantype">
            <option value="both">{'_ALLBANS'|lang}</option>
            <option value="perm">{'_PERMBANS'|lang}</option>
            <option value='temp'>{'_TEMPBANS'|lang}</option>
         </select>
         <label>Ban Reasons</label>
         <select name="include_reason">
             <option value="include">Include</option>
             <option value="exclude">Exclude</option>
         </select>
         <button class="btn btn-success" type="submit">Export My Bans</button>
    </form>
</div>

<table>
          <tr>
            <td colspan='3'><b>{"_EXPORT"|lang}</b></td>
          </tr>
          <form name='export' enctype='multipart/form-data' method='post' action='{$this}'>
          <input type='hidden' name='submitted' value='true'>
          <tr bgcolor="#D3D8DC">
          	<td height='16' width='30%' class='listtable_1'>{"_GAMETYPE"|lang}</td>
            <td height='16' width='65%' class='listtable_1'>

							<select name='gtype'>
							<option value='all'>{"_ALLGAMETYPES"|lang}</option>
							{section name=mysec loop=$gametypes}
								{html_options values=$gametypes[mysec].gametype output=$gametypes[mysec].gametype}
							{/section}
							</select>

            </td>
          </tr>
          <tr bgcolor="#D3D8DC">
          	<td height='16' width='30%' class='listtable_1'>{"_BANTYPE"|lang}</td>
            <td height='16' width='70%' class='listtable_1'>

							<select name='bantype' style='font-family: verdana, tahoma, arial; font-size: 10px; width: 150px'>
							<option value='both'>{"_ALLBANS"|lang}</option>
							<option value='perm'>{"_PERMBANS"|lang}</option>
							<option value='temp'>{"_TEMPBANS"|lang}</option>
							</select>

            </td>
					</tr>
          <tr bgcolor="#D3D8DC">
          	<td height='16' width='30%' class='listtable_1'>{"_INCREASON"|lang}</td>
            <td height='16' width='70%' class='listtable_1'><input type='checkbox' name='include_reason'></td>
					</tr>
          <tr bgcolor="#D3D8DC">
            <td height='16' width='10%' class='listtable_1' colspan='2' align='right'>
                <input type='submit' name='submit' value='{"_EXPORT"|lang}' style='font-family: verdana, tahoma, arial; font-size: 10px;'></td>
          </tr>
          </form>
        </table>

				{if ($submitted == "true")}
				<br>
        <table cellspacing='1' class='listtable' width='100%'>
					<tr>
            <td height='16' colspan='3' class='listtable_top'><b>{"_EXPORTRESULT"|lang}</b></td>
          </tr>
          <form name='dl' method='post' action='{$dir}/send_export.php'>
          <input type='hidden' name='download' value='true'>
          <tr bgcolor="#D3D8DC">
          	<td width='2%' class='listtable_1' align='center'><br>

<textarea name='blob' rows='5' cols='50' selected>
{if $include_reason == "on"}
{foreach from=$exported_bans item=exported_bans}
banid 0.0 {$exported_bans.steamid} // {$exported_bans.reason}
{foreachelse}
{"_SOMETHINGWRONG"|lang}
{/foreach}
{else}
{foreach from=$exported_bans item=exported_bans}
banid 0.0 {$exported_bans.steamid}
{foreachelse}
{"_SOMETHINGWRONG"|lang}
{/foreach}
{/if}
</textarea><br><br>

          	</td>
          </tr>

          <tr bgcolor="#D3D8DC">
            <td height='16' width='10%' class='listtable_1' align='right'><input type='submit' name='submit' value='{"_DOWNLOAD"|lang}' style='font-family: verdana, tahoma, arial; font-size: 10px;'></td>
          </tr>
          </form>
				</table>
				{/if}