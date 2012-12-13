{if $new_version == 1}
<table cellspacing='1' class='listtable' width='100%'>
  <tr>
  	<td height='16' class='listtable_top'><b>New AMX Frontend available!</b></td>
  </tr>
  <tr>
	<td height='32' width='100%' class='listtable_1' colspan='5' align='center'><br><br>A new version of the AMXBans frontend is available. You can download it at:<br><font color='#ff0000'><a href='{$update_url}' class='alert'  target="_blank">{$update_url}</a></font><br><br></td>
  </tr>
</table>
<br>
{/if}
<ul class="breadcrumb">
  <li>Home <span class="divider">/</span></li>
  <li class="active">Ban List</li>
</ul>

<table id="ban-list" class="table table-bordered table-hover">
	<thead>
		<tr>
		    <th>{'_LENGTH'|lang}</th>
			<th class="hidden-phone">Game</th>
			<!-- <th class="hidden-phone"></th> -->
			<th class="hidden-phone">{'_DATE'|lang}</th>
			<th class="hidden-phone">{'_PLAYER'|lang}</th>
			<th>Steam ID</th>
			<th class="hidden-phone">{'_ADMIN'|lang}</th>
			{if $display_reason == 'enabled'}
				<th class="hidden-phone">{'_REASON'|lang}</th>
			{/if}
			<th>{'_DETAILS'|lang}</th>
		</tr>
	</thead>
	<tbody>
	{foreach from=$bans item=bans}
		<tr id="ban-{$bans.bid}" class="ban-summary">
            <td>
                {if $bans.duration == 'Permanent'}
                    <span class="label label-important">{$bans.duration}</span>
                {else}
                    <span class="label label-warning">{$bans.duration}</span>
                {/if}
            </td>
            <td class="hidden-phone"><span class="label label-info">{$bans.gametype}</span></td>
            <!--
            <td class="hidden-phone">
            	{if $geoip == 'enabled'}
            		{if $bans.cc != ''}
	            		<img src="{$dir}/images/flags/{$bans.cc|lower}.png" alt="{$bans.cn}" title="{$bans.cn}"/>
	            	{else}
	            		<img src='{$dir}/images/spacer.gif' width='18' height='12' />
	            	{/if}
	            {/if}
            </td>
            -->
            <td class="hidden-phone">{$bans.date}</td>
            <td class="hidden-phone">
                <!-- 
                {if $geoip == 'enabled'}
                    {if $bans.cc != ''}
                        <img style="vertical-align:baseline" src="{$dir}/images/flags/{$bans.cc|lower}.png" alt="{$bans.cn}" title="{$bans.cn}"/>
                    {else}
                        <img src='{$dir}/images/spacer.gif' width='18' height='12' />
                    {/if}
                {/if}
                -->
                <a href="{$dir}/ban_details.php?bid={$bans.bid}"><i class="icon-user"></i></a> {$bans.player}
            </td>
            <td>{$bans.player_id}</td>
            <td class="hidden-phone">
            	{if ($display_admin == "enabled") || ($smarty.session.bans_add == "yes")}
            		{$bans.admin}
            	{else}
            		{"_HIDDEN"|lang}
            	{/if}
            </td>
            {if $display_reason == "enabled"}
            	<td class="hidden-phone">{$bans.ban_reason}</td>
            {/if}

            <td>
                <button id="ban-details-button-{$bans.bid}" class="btn btn-small hidden-phone">Details</button>
                <a class="btn btn-small visible-phone" href="{$dir}/ban_details.php?bid={$bans.bid}">Details</a>
                <div id="ban-details-{$bans.bid}" class="modal hide fade">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                        <h3>{"_BANDETAILS"|lang}</h3>
                    </div>
                    <div class="modal-body">
                        <table class="table table-bordered">
                            <tr>
                                <th>{'_PLAYER'|lang}</th>
                                <td>{$bans.player}</td>
                            </tr>
                            <tr>
                                <th>{'_BANTYPE'|lang}</th>
                                <td>{$bans.ban_type}</td>
                            </tr>
                            <tr>
                                <th>{'_STEAMID'|lang}</th>
                                <td>{if $bans.player_id == '&nbsp;'}
                                        {'_NOSTEAMID'|lang}
                                    {else}
                                        {$bans.player_id}
                                    {/if}
                                </td>
                            </tr>
                            <tr>
                                <th>{'_IP'|lang}</th>
                                <td>{$bans.player_ip}</td> 
                            </tr>
                            <tr>
                                <th>{'_INVOKED'|lang}</th>
                                <td>{$bans.ban_start}</td>
                            </tr>
                            <tr>
                                <th>{'_BANLENGTH'|lang}</th>
                                <td>{$bans.ban_duration}</td>
                            </tr>
                            <tr>
                                <th>{'_EXPIRES'|lang}</th>
                                <td>{$bans.ban_end}</td>
                            </tr>
                            <tr>
                                <th>{'_REASON'|lang}</th>
                                <td>{$bans.ban_reason}</td>
                            </tr>
                            <tr>
                                <th>{'_BANBY'|lang}</th>
                                <td>
                                    {if $display_admin == 'enabled' || ($smarty.session.bans_add == 'yes')}
                                        {$bans.admin} ({$bans.webadmin})
                                    {else}
                                        {'_HIDDEN'|lang}
                                    {/if}
                                </td>
                            </tr>
                            <tr>
                                <th>Game Type</th>
                                <td>{$bans.gametype}</td>
                            </tr>
                            <tr>
                                <th>{'_BANON'|lang}</th>
                                <td>{$bans.server_name}</td>
                            </tr>
                            <tr>
                                <th>{'_PREVOFF'|lang}</th>
                                <td>{$bans.bancount}</td>
                            </tr>
                        </table>
                        
                    </div>
                    <div class="modal-footer">
                        <!--
                        {if (($smarty.session.bans_edit == "yes") || (($smarty.session.bans_edit == "own") && ($smarty.session.uid == $bans.webadmin)))}
                            <form class="form-inline" name="delete" method="post" action="{$dir}/admin/edit_ban.php">
                                <input type="hidden" name="action" value="edit">
                                <input type="hidden" name="bid" value="{$bans.bid}">
                                <button class="btn" type="submit" name="edit">{"_EDIT"|lang}</button>
                            </form>
                        {/if}
                        
                        {if (($smarty.session.bans_unban == "yes") || (($smarty.session.bans_unban == "own") && ($smarty.session.uid == $bans.webadmin)))}
                            <form class="form-inline" name="unban" method="post" action="{$dir}/admin/edit_ban.php">
                                <input type="hidden" name="action" value="unban">
                                <input type="hidden" name="bid" value="{$bans.bid}">
                                <button class="btn btn-warning" type="submit" name="unban">{"_UNBAN"|lang}</button>
                            </form>
                        {/if}
                        
                        {if (($smarty.session.bans_delete == 'yes') || (($smarty.session.bans_delete == 'own') && ($smarty.session.uid == $bans.webadmin)))}
                            <form class="form-inline" name="unban" method="post" action="{$dir}/admin/edit_ban.php">
                                <input type="hidden" name="action" value="delete">
                                <input type="hidden" name="bid" value="{$bans.bid}">
                                <button class="btn btn-warning del-ban" type="submit" name="delete" onclick="javascript:return confirm('{"_WANTTOREMOVE"|lang} ban_id {$bans.bid}?')">{"_DELETE"|lang}</button>
                            </form>
                        {/if}
                        -->
                        <a href="javascript:void(0)" class="btn">Close</a>
                        <a href="{$dir}/ban_details.php?bid={$bans.bid}">
                            <button class="btn btn-info">{'_BANPAGE'|lang}</button>
                        </a>
                    </div>
                </div>
         <script type="text/javascript">
            $(function() {ldelim}
                $('#ban-details-button-{$bans.bid}').on('click', function() {ldelim}
                    $('#ban-details-{$bans.bid}').modal();
                {rdelim});
                $('#ban-details-{$bans.bid} .modal-footer .btn').on('click', function() {ldelim}
                    $('#ban-details-{$bans.bid}').modal('hide');
                {rdelim});
                /*
                function initialize() {ldelim}
                    var myLatlng = new google.maps.LatLng({$bans.ctlat} , {$bans.ctlong} );
                    var mapOptions = {ldelim}
                        zoom: 10,
                        center: myLatlng,
                        mapTypeId: google.maps.MapTypeId.ROADMAP
                    {rdelim};
                    var map = new google.maps.Map(document.getElementById('map-canvas-{$bans.bid}'), mapOptions);
                    
                    var marker = new google.maps.Marker({ldelim}
                        position: myLatlng,
                        map: map,
                        title: 'Hello world!' 
                    {rdelim});
                {rdelim}
            
                google.maps.event.addDomListener(window, 'load', initialize);
                */
            {rdelim});
        </script>
            </td>
     	</tr>
{foreachelse}
          <tr>
            <td colspan="{if $fancy_layers != 'enabled'}5{else}6{/if}">{'_NOBANSFOUND'|lang}</td>
          </tr>
{/foreach}
</tbody>        
</table>
<div style="text-align:center">{$pages_results}</div>
    <ul class="pager">
        <li class="previous">
            {$previous_button}
        </li>
        <li class="next">
            {$next_button}
        </li>
          
    </ul>
<script>    

</script>