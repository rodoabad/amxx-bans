
        <table cellspacing='1' class='listtable' width='100%'>
          <tr>
            <td height='16' colspan='3' class='listtable_top'><b>{"_IMPORT"|lang}</b></td>
          </tr>
          <form name='import' enctype='multipart/form-data' method='post' action='{$this}'>
          <input type='hidden' name='submitted' value='true'>
          <tr bgcolor="#D3D8DC">
          	<td height='16' width='30%' class='listtable_1'>{"_BANFILE"|lang}</td>
            <td height='16' width='65%' class='listtable_1'><input name='{$filename}' type='file' style='font-family: verdana, tahoma, arial; font-size: 10px; width: 250px'></td>
          </tr>
          <tr bgcolor="#D3D8DC">
          	<td height='16' width='30%' class='listtable_1'>{"_REASON"|lang}</td>
            <td height='16' width='70%' class='listtable_1'><input type='text' name='ban_reason' style='font-family: verdana, tahoma, arial; font-size: 10px; width: 250px'></td>
					</tr>
          <tr bgcolor="#D3D8DC">
            <td height='16' width='30%' class='listtable_1'>{"_BANLENGHT"|lang}</td>
						<td height='16' width='70%' class='listtable_1'><input type='text' name='ban_length' style='font-family: verdana, tahoma, arial; font-size: 10px; width: 250px'></td>
          </tr>
          <tr bgcolor="#D3D8DC">
            <td height='16' width='100%' class='listtable_1' align='right' colspan='2'>{$submit}</td>
          </tr>
          </form>
        </table>

				{if ($submitted == "true")}
				<br>
        <table cellspacing='1' class='listtable' width='100%'>
          <tr>
          	<td height='16' width='2%'  class='listtable_top'>&nbsp;</td>
            <td height='16' width='15%' class='listtable_top'><b>SteamID / IP</b></td>
            <td height='16' width='33%' class='listtable_top'><b>{"_RESULT"|lang}</b></td>
          </tr>

					{foreach from=$import item=import}
          <tr bgcolor='#D3D8DC'>
            <td height='16' width='2%'  class='listtable_1' align='center'>{$import.counter}</td>
            <td height='16' width='15%' class='listtable_1'>{$import.id}</td>
            <td height='16' width='33%' class='listtable_1'>{if $import.result == 0}<font color='#cc0000'>{"_NOTIMPORTED"|lang}</font>{else}<font color='#00cc00'>{"_IMPORTED"|lang}</font>{/if}</td>
          </tr>
          {foreachelse}
          <tr bgcolor="#D3D8DC">
            <td height='16' colspan='3' class='listtable_1'>{"_NOFOUNDIMPORT"|lang}</td>
          </tr>
          {/foreach}
				</table>
				{/if}