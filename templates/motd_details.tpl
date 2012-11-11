<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
<head>
<title>AMXBans - {$title}</title>

<meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-1" />
<meta name="Keywords" content="" />
<meta name="Description" content="" />
<meta http-equiv="pragma" content="no-cache" />
<meta http-equiv="cache-control" content="no-cache" />
{$meta}
<link rel="stylesheet" type="text/css" href="{$dir}/include/amxbans.css" />
<script type="text/javascript" language="JavaScript" src="/layer.js"></script>
</head>

<body>

<table border='0' cellpadding='0' cellspacing='0' width='100%'>
  <tr>
    <td width='100%' valign='top' style='padding: 20px'>
    <table border='0' cellpadding='0' cellspacing='0' width='100%'>
      <tr>
        <td>

        <table cellspacing='1' class='listtable' width='100%'>
          <tr>
            <td height='16' colspan='2' class='listtable_top'><b>Bandetails</b></td>
          </tr>
          <tr bgcolor="#D3D8DC">
            <td height='16' width='30%' class='listtable_1'>Player</td>
            <td height='16' width='70%' class='listtable_1'>{$ban_info.player_name}</td>
          </tr>
          <tr bgcolor="#D3D8DC">
            <td height='16' width='30%' class='listtable_1'>Bantype</td>
            <td height='16' width='70%' class='listtable_1'>{$ban_info.ban_type}</td>
          </tr>
          <tr bgcolor="#D3D8DC">
            <td height='16' width='30%' class='listtable_1'>SteamID</td>
            <td height='16' width='70%' class='listtable_1'>{$ban_info.player_id}</td>
          </tr>
          <tr bgcolor="#D3D8DC">
            <td height='16' width='30%' class='listtable_1'>Banlength</td>
            <td height='16' width='70%' class='listtable_1'>{$ban_info.ban_duration}</td>
          </tr>
          <tr bgcolor="#D3D8DC">
            <td height='16' width='30%' class='listtable_1'>Expires on</td>
            <td height='16' width='70%' class='listtable_1'>{$ban_info.ban_end}</td>
          </tr>
          <tr bgcolor="#D3D8DC">
            <td height='16' width='30%' class='listtable_1'>Banned by</td>
            <td height='16' width='70%' class='listtable_1'>{$ban_info.ban_type}</td>
          </tr>
          <tr bgcolor="#D3D8DC">
            <td height='16' width='30%' class='listtable_1'>Reason</td>
            <td height='16' width='70%' class='listtable_1'>{$ban_info.ban_reason}</td>
          </tr>
          <tr bgcolor="#D3D8DC">
            <td height='16' width='30%' class='listtable_1'>Banned by</td>
            <td height='16' width='70%' class='listtable_1'>{if ($display_admin == "enabled")}{$ban_info.admin_name}{else}hidden{/if}</td>
          </tr>
 
  	    {if $history == "TRUE"}
          {foreach from=$bhans item=bhans name=bhans}
          <tr bgcolor="#D3D8DC">
            <td height='16' width='30%' class='listtable_1'>Previous bans</td>
            <td height='16' width='70%' class='listtable_1'>{$smarty.foreach.bhans.total} (3 bans means a permanent ban!)</td>
          </tr>
          {foreachelse}
          <tr bgcolor="#D3D8DC">
            <td height='16' width='30%' class='listtable_1'>Previous bans</td>
            <td height='16' width='70%' class='listtable_1'>None found</td>
          </tr>
          {/foreach}          
        </table>
	      {else}
	      </table>
	      {/if}

				<table cellspacing='1' width='100%'>
					<tr>
						<td align='right'>AMXBans 5.0 by YoMama/LuX & lantz69</td>
					</tr>
				</table>
				</td>
			</tr>
		</table>
		</td>
	</tr>
</table>

</body>

</html>