<!--
<table width='100%' border='0' cellpadding='0' cellspacing='0'>
    <tr>




        {if $ban_info.id_type == "bhid"}

            {if (($smarty.session.bans_edit == "yes") || (($smarty.session.bans_edit == "own") && ($smarty.session.uid == $bans.webadmin)))}
                <form name="delete" method="post" action="{$dir}/admin/edit_ban_ex.php">
                <input type='hidden' name='action' value='edit_ex'>
                <input type='hidden' name='bhid' value='{$ban_info.bid}'>
        <td align='right' width='2%'>
                <input type='image' SRC='{$dir}/images/edit.gif' name='action' ALT='{"_EDIT"|lang}'><img src='{$dir}/images/spacer.gif' width='1px' height='1'></td></form>
            {/if}

        {if (($smarty.session.bans_delete == "yes") || (($smarty.session.bans_delete == "own") && ($smarty.session.uid == $bans.webadmin)))}
                <form name="unban" method="post" action="{$dir}/admin/edit_ban_ex.php">
                <input type='hidden' name='action' value='delete_ex'>
                <input type='hidden' name='bhid' value='{$ban_info.bid}'>
        <td align='right' valign='top' width='2%'>
                <input type='image' src='{$dir}/images/delete.gif' name='delete' alt='{"_DELETE"|lang}' onclick="javascript:return confirm('{"_WANTTOREMOVE"|lang} ban_id {$ban_info.bid}?')"></td></form>
            {/if}
        {/if}
    </tr>
    </table>
-->

<ul class="breadcrumb">
  <li>Home <span class="divider">/</span></li>
  <li>Bans <span class="divider">/</span></li>
  <li>{'_BANDETAILS'|lang} <span class="divider">/</span></li>
  <li class="active"><a href="{$dir}/ban_details.php?bid={$ban_info.bid}">{$ban_info.player_id}</a></li>
</ul>

    <div class="page-header">
        <h3>{'_BANDETAILS'|lang} For {$ban_info.player_id}</h3>
    </div>
    {$ban_info.cc}
    <div class="row-fluid">
        <div class="span12">
            <div id="map-canvas" style="margin-bottom: 20px"></div>
        </div>
    </div>
<!--
    <div display:none>
        {if $ban_info.id_type == "bid"}
            {if (($smarty.session.bans_edit == "yes") || (($smarty.session.bans_edit == "own") && ($smarty.session.uid == $bans.webadmin)))}
                <form name="delete" method="post" action="{$dir}/admin/edit_ban.php">
                    <input type='hidden' name='action' value='edit'>
                    <input type='hidden' name='bid' value='{$ban_info.bid}'>
                    <button class="btn btn-block" type="submit">{'_EDIT'|lang}</button>
                </form>
            {/if}
            {if (($smarty.session.bans_unban == "yes") || (($smarty.session.bans_unban == "own") && ($smarty.session.uid == $bans.webadmin)))}
                <form name="unban" method="post" action="{$dir}/admin/edit_ban.php">
                    <input type='hidden' name='action' value='unban'>
                    <input type='hidden' name='bid' value='{$ban_info.bid}'>
                    <button class="btn btn-warning btn-block" type="submit">{'_UNBAN'|lang}</button>
                </form>
            {/if}
            {if (($smarty.session.bans_delete == "yes") || (($smarty.session.bans_delete == "own") && ($smarty.session.uid == $bans.webadmin)))}
                    <form name="unban" method="post" action="{$dir}/admin/edit_ban.php">
                        <input type='hidden' name='action' value='delete'>
                        <input type='hidden' name='bid' value='{$ban_info.bid}'>
                        <button class="btn btn-danger btn-block" type="submit" onclick="javascript:return confirm('{"_WANTTOREMOVE"|lang} ban_id {$ban_info.bid}?')">{'_DELETE'|lang}</button>
                    </form>
            {/if}
        {/if}
</div>
-->

<table class="table table-bordered">
    <tbody>
        <tr>
            <th>{'_PLAYER'|lang}</th>
            <td>{$ban_info.player_name}</td>
        </tr>
        <tr>
            <th>{'_BANTYPE'|lang}</th>
            <td>{$ban_info.ban_type}</td>
        </tr>
        <tr>
            <th>{'_STEAMID'|lang}</th>
            <td>{$ban_info.player_id}</td>
        </tr>
        <tr>
            <th>{'_IP'|lang}</th>
            <td>{$ban_info.player_ip}</td>
        </tr>
        <tr>
            <th>{'_BANLENGTH'|lang}</th>
            <td>{$ban_info.ban_duration}</td>
        </tr>
        <tr>
            <th>{'_INVOKED'|lang}</th>
            <td>{$ban_info.ban_start}</td>
        </tr>
        <tr>
            <th>{'_EXPIRES'|lang}</th>
            <td>{$ban_info.ban_end}</td>
        </tr>
        <tr>
            <th>{'_REASON'|lang}</th>
            <td>{$ban_info.ban_reason}</td>
        </tr>
        <tr>
            <th>{'_BANBY'|lang}</th>
            <td>
                {if ($display_admin == 'enabled') || ($smarty.session.bans_add == 'yes')}
                    {$ban_info.admin_name}
                {else}
                    {'_HIDDEN'|lang}
                {/if}
            </td>
        </tr>
        <tr>
            <th>{'_BANON'|lang}</th>
            <td>
                {$ban_info.server_name} ({$ban_info.server_ip})
            </td>
        </tr>
        <tr>
            <th>{'_ORIGIN'|lang}</th>
            <td>
                {if $ban_info.ctname}
                    {$ban_info.ctname}, {$ban_info.cn} (LAT {$ban_info.ctlat}, LONG {$ban_info.ctlong})
                {else}
                    {$ban_info.cn} (LAT {$ban_info.ctlat}, LONG {$ban_info.ctlong})
                {/if}
            </td>
        </tr>
    </tbody>
</table>


{if $unban_info.verify == "TRUE"}
        <table cellspacing='1' class='listtable' width='100%'>
          <tr>
            <td height='16' colspan='2' class='listtable_top'><b>{"_UNBANDETAILS"|lang}</b></td>
          </tr>
          <tr>
            <td height='16' width='30%' class='listtable_1'>{"_BANREMOVED"|lang}</td>
            <td height='16' width='70%' class='listtable_1'>{$unban_info.unban_start}</td>
          </tr>
          <tr>
            <td height='16' width='30%' class='listtable_1'>{"_REASON"|lang}</td>
            <td height='16' width='70%' class='listtable_1'>{if ($display_admin == "enabled") || ($smarty.session.bans_add == "yes") || ($unban_info.unban_reason == "tempban expired") || ($unban_info.unban_reason == "tempban expired")}{$unban_info.unban_reason}{else}<i><font color='#677882'>{"_HIDDEN"|lang}</font></i>{/if}</td>
          </tr>
          <tr>
            <td height='16' width='30%' class='listtable_1'>{"_REMBY"|lang}</td>
            <td height='16' width='70%' class='listtable_1'>{if ($display_admin == "enabled") || ($smarty.session.bans_add == "yes") || ($unban_info.unban_reason == "tempban expired") || ($unban_info.unban_reason == "tempban expired")}{$unban_info.admin_name}{else}<i><font color='#677882'>{"_HIDDEN"|lang}</font></i>{/if}</td>
          </tr>
        </table>
{/if}

{if $history == "TRUE"}
    <table class="table table-bordered">
        <thead>
            <tr>
                <!-- <th>{"_BANHISTORY"|lang}</th> -->
                <th>Related Bans</th>
            </tr>
        </thead>
        <tbody>
            {foreach from=$bhans item=bhans}
                {if $bhans.player_id != $ban_info.player_id}
                <tr>
                    <td>{$bhans.date}</td>
                    <td><a href="{$dir}/ban_details.php?bid={$bhans.bid}">{$bhans.player}</a></td>
                    <!-- <td>{if ($display_admin == "enabled") || ($smarty.session.bans_add == "yes")}{$bhans.admin}{else}<i><font color='#677882'>{"_HIDDEN"|lang}</font></i>{/if}</td> -->
                    <td>{$bhans.player_id}</td>
                    <td>{$bhans.player_ip}</td>
                    {if $display_reason == "enabled"}<td>{$bhans.reason}</td>{/if}
                    <td>{$bhans.duration}</td>

                    <!--
                    <td height='16' width='4%' class='listtable_1'>
                        <table width='100%' border='0' cellpadding='0' cellspacing='0'>
                			<tr>
                				{if (($smarty.session.bans_edit == "yes") || (($smarty.session.bans_edit == "own") && ($smarty.session.uid == $bans.webadmin)))}
                				<form name="delete" method="post" action="{$dir}/admin/edit_ban_ex.php"><input type='hidden' name='action' value='edit_ex'><input type='hidden' name='bhid' value='{$bhans.bhid}'><td align='right' width='2%'><input type='image' SRC='{$dir}/images/edit.gif' name='action' ALT='{"_EDIT"|lang}'><img src='{$dir}/images/spacer.gif' width='1px' height='1'></td></form>
                				{/if}
                				{if (($smarty.session.bans_delete == "yes") || (($smarty.session.bans_delete == "own") && ($smarty.session.uid == $bans.webadmin)))}
                				<form name="unban" method="post" action="{$dir}/admin/edit_ban_ex.php"><input type='hidden' name='action' value='delete_ex'><input type='hidden' name='bhid' value='{$bhans.bhid}'><td align='right' valign='top' width='2%'><input type='image' src='{$dir}/images/delete.gif' name='delete' alt='{"_DELETE"|lang}' onclick="javascript:return confirm('{"_WANTTOREMOVE"|lang} ban_id {$bhans.bhid}?')"></td></form>
                				{/if}
                			</tr>
                        </table>
                    </td>
                -->
                </tr>
                {/if}
            {foreachelse}
                <tr class="info">
                    <td><i class="icon-info-sign"></i> {"_NOBANS"|lang}</td>
                </tr>
            {/foreach}
        </tbody>
    </table>
{/if}

<script>
                function initialize() {ldelim}
                    var myLatlng = new google.maps.LatLng({$ban_info.ctlat} , {$ban_info.ctlong} );
                    var mapOptions = {ldelim}
                        zoom: 5,
                        center: myLatlng,
                        zoomControl: true,
                        streetViewControl: false,
                        mapTypeControl: false,
                        scaleControl: false,
                        scrollwheel: false,
                        panControl: false,
                        draggable: false,
                        mapTypeId: google.maps.MapTypeId.ROADMAP
                    {rdelim};
                    var map = new google.maps.Map(document.getElementById('map-canvas'), mapOptions);

                    var marker = new google.maps.Marker({ldelim}
                        position: myLatlng,
                        map: map,
                    {rdelim});
                {rdelim}

                google.maps.event.addDomListener(window, 'load', initialize);
</script>