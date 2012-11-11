<!--
<table cellspacing='1' class='listtable' width='100%'>
	<tr>
		<td height='16' colspan='2' class='listtable_top'><b>{"_ADMINSLEVELS"|lang}</b></td>
	</tr>
	<form name="subsection" method="get" action="{$this}">
	<tr bgcolor="#D3D8DC">
		<td height='16' width='30%' class='listtable_1'>{"_SELECTACTION"|lang}</td>
		<td height='16' width='70%' class='listtable_1'>

			<select name='subsection' onChange="javascript:document.subsection.submit()">
			<option value='xxx' {if $subsection == "xxx"}selected{/if}>...</option>
			{if $smarty.session.permissions_edit == "yes"}<option value='levels' {if $subsection == "levels"}selected{/if}>{"_MANAGELEVEL"|lang}</option>{/if}
			{if $smarty.session.webadmins_edit == "yes"}<option value='webadmins' {if $subsection == "webadmins"}selected{/if}>{"_MANAGEWEBADMINS"|lang}</option>{/if}
			{if $smarty.session.amxadmins_edit == "yes"}<option value='amxadmins' {if $subsection == "amxadmins"}selected{/if}>{"_MANAGEAMXADMINS"|lang}</option>{/if}
			</select>

		</td>
	</tr>
	</form>
</table>
-->

<ul class="nav nav-tabs">
    <li class="{if $subsection == 'levels'}active{/if}"><a href="#access-levels" data-toggle="tab">{'_MANAGEACCESSLEVELS'|lang}</a></li>
    <li class="{if $subsection == 'webadmins'}active{/if}"><a href="#web-admins" data-toggle="tab">{'_MANAGEWEBADMINS'|lang}</a></li>
    <li class="{if $subsection == 'amxadmins'}active{/if}"><a href="#server-admins" data-toggle="tab">{'_MANAGEAMXADMINS'|lang}</a></li>
</ul>

<div class="tab-content">
    <div id="access-levels" class="tab-pane {if $subsection == 'levels'}active{/if}">
        <table class="table table-bordered">
            <thead>
            
            <tr>
                <th></th>
                <th colspan="6">Ban Access</th>
                <th>AMX</th>
                <th>Web</th>
                <th>{'_SERVERS'|lang}</th>
                <th colspan="3">{'_OTHER'|lang}</th>
            </tr>
            <tr>
                <th>{"_LVL"|lang}</th>
                <th>{"_ADD"|lang}</th>
                <th>{"_EDIT"|lang}</th>
                <th>{"_DELETE"|lang}</th>
                <th>{"_UNBAN"|lang}</th>
                <th>{"_IMPORT"|lang}</th>
                <th>{"_EXPORT"|lang}</th>
                <th>{"_EDIT"|lang}</th>
                <th>{"_EDIT"|lang}</th>
                <th>{"_EDIT"|lang}</th>
                <th>{"_EDIT"|lang}</th>
                <th>Prune DB</th>
                <th>{"_VIEWIP"|lang}</th>
            </tr>
            </thead>
            <tbody>
                <form class="form" name="admins" method="get" action="{$this}">
                    {foreach from=$level item=level}
                        <tr>
                            <td class="info">
                                <input type="hidden" name="subsection" value="levels">{$level.level}
                            </td>
                            <td class="{if $level.bans_add == 'yes'}success{else}error{/if}">
                                <input type='checkbox' name='{$level.level}-bans_add' {if $level.bans_add == 'yes'}checked="checked"{/if}>
                            </td>
                            <td class="{if $level.bans_edit == 'yes'}success{else}error{/if}">
                                <input type='checkbox' name='{$level.level}-bans_edit' {if $level.bans_edit == 'yes'}checked="checked"{/if}>
                            </td>
                            <td class="{if $level.bans_delete == 'yes'}success{else}error{/if}">
                                <input type='checkbox' name='{$level.level}-bans_delete' {if $level.bans_delete == 'yes'}checked="checked"{/if}>
                            </td>
                            <td class="{if $level.bans_unban == 'yes'}success{else}error{/if}">
                                <input type='checkbox' name='{$level.level}-bans_unban' {if $level.bans_unban == 'yes'}checked="checked"{/if}>
                            </td>
                            <td class="{if $level.bans_import == 'yes'}success{else}error{/if}">
                                <input type="checkbox" name="{$level.level}-bans_import" {if $level.bans_import == 'yes'}checked="checked"{/if}>
                            </td>
                            <td class="{if $level.bans_export == 'yes'}success{else}error{/if}">
                                <input type="checkbox" name="{$level.level}-bans_export" {if $level.bans_export == 'yes'}checked="checked"{/if}>
                            </td>
                            <td class="{if $level.amxadmins_edit == 'yes'}success{else}error{/if}">
                                <input type="checkbox" name="{$level.level}-amxadmins_edit" {if $level.amxadmins_edit == 'yes'}checked="checked"{/if}>
                            </td>
                            <td class="{if $level.webadmins_edit == 'yes'}success{else}error{/if}">
                                <input type="checkbox" name="{$level.level}-webadmins_edit" {if $level.webadmins_edit == 'yes'}checked="checked"{/if}>
                            </td>
                            <td class="{if $level.servers_edit == 'yes'}success{else}error{/if}">
                                <input type="checkbox" name="{$level.level}-servers_edit" {if $level.servers_edit == 'yes'}checked="checked"{/if}>
                            </td>
                            <td class="{if $level.permissions_edit == 'yes'}success{else}error{/if}">
                                <input type="checkbox" name='{$level.level}-permissions_edit' {if $level.permissions_edit == 'yes'}checked="checked"{/if}>
                            </td>
                            <td class="{if $level.prune_db == 'yes'}success{else}error{/if}">
                                <input type="checkbox" name="{$level.level}-prune_db" {if $level.prune_db == 'yes'}checked="checked"{/if}>
                            </td>
                            <td class="{if $level.ip_view == 'yes'}success{else}error{/if}">
                                <input type="checkbox" name="{$level.level}-ip_view" {if $level.ip_view == 'yes'}checked="checked"{/if}>
                            </td>
                        </tr>
                    {/foreach}
                <tr>
                    <td colspan="13">
                        <select name="new_lvl">
                            {foreach from=$available_levels item=available_levels}
                                <option value="{$available_levels}">{$available_levels}</option>
                            {/foreach}
                        </select>
                
                        <button class="btn" type="submit" name="action" value="{'_ADD'|lang}">{'_ADDLEVEL'|lang}</button>
                    </td>
                </tr>
                <tr>
                    <td colspan="13">
                    <select name="ex_lvl">
                        {foreach from=$existing_levels item=existing_levels}
                            {if $smarty.foreach.evisting_levels.last}
                                <option value="{$existing_levels}" selected="selected">{$existing_levels}</option>
                            {else}
                                <option value="{$existing_levels}">{$existing_levels}</option>
                            {/if}
                        {/foreach}
                    </select>
                    <button class="btn" type="submit" name="action" value="{'_REMOVE'|lang}">{'_REMOVELEVEL'|lang} </button>
                        
                    </td>
                </tr>
                <tr>
                    <td colspan='13'>
                        <button class="btn btn-warning btn-block" type="submit" name="action" value="{'_APPLY'|lang}">{'_APPLYCHANGES'|lang}</button>
                    </td>
                </tr>
                </form>
            </tbody>
        </table>
    </div>
    <div id="web-admins" class="tab-pane {if $subsection == 'webadmins'}active{/if}">
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>{'_USERNAME'|lang}</th>
                    <th>{'_PASSWORD'|lang}</th>
                    <th>{'_LEVEL'|lang}</th>
                    <th>{'_ACTION'|lang}</th>
                </tr>
            </thead>
            <tbody>
            {foreach from=$webadmin item=webadmin}
                <form name='admins' method='get' action='{$this}'>
                    <tr>
                        <td>
                            <input type="hidden" name="subsection" value="webadmins">
                            <input type="hidden" name="id" value="{$webadmin.id}">
                            <input type="text" name="username" value="{$webadmin.username}" placeholder="Username">
                        </td>
                        <td>
                            <input type="text" name="password" placeholder="Password">
                        </td>
                        <td>
                            {assign var=temp value=$webadmin.existing_lvls}
                            <select name="level">
                                {foreach item=item from=$temp}
                                    <option value="{$item}" {if $item == $webadmin.level}selected="selected"{/if}>{$item}</option>
                                {/foreach}
                            </select>
                        </td>
                        <td>
                            <button class="btn btn-warning" type="submit" name="action" value="{'_APPLY'|lang}">Modify</button>
                            <button class="btn btn-danger" type='submit' name="action" value="{'_REMOVE'|lang}" onclick="javascript:return confirm('{"_DELADMIN"|lang}')">Remove</button>
                        </td>
                    </tr>
                </form>
            {/foreach}
        
            {* if $action == lang("_ADDWEBADMINS") *}
            <form name='admins' method='get' action='{$this}'>
                <tr>
                    <td>
                        <input type="hidden" name="subsection" value="webadmins">
                        <input type='hidden' name='subsection' value='webadmins'>
                        <input type='text' name="username">
                    </td>
                    <td>
                        <input type="password" name="password" placeholder="Password">
                    </td>
                    <td>
                        {assign var=temp value=$webadmin.existing_lvls}
                            <select name="level">
                        {foreach item=item from=$temp}
                            <option value="{$item}">{$item}</option>
                        {/foreach}
                        </select>
                    </td>
                    <td>
                        <button class="btn btn-success" type="submit" name="action" value="{'_INSERT'|lang}">Add New Web Admin</button>
                    </td>
                </tr>
            </form>
            {* /if *}
            <!--
            <form name="admins" method="get" action="{$this}">
                <tr>
                    <td colspan="12">
                        <input type="hidden" name="subsection" value="webadmins">
                        <button class="btn btn-success btn-block" type="submit" name="action" value="{'_ADDWEBADMINS'|lang}">{'_ADDWEBADMINS'|lang}</button>
                    </td>
                </tr>
            </form>
            -->
            </tbody>
        </table>
    </div>
    <div id="server-admins" class="tab-pane {if $subsection == 'amxadmins'}active{/if}">
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>{'_NICKNAME'|lang}</th>
                    <th>{'_STEAMID'|lang}</th>
                    <!-- <td>{"_PASSWORD"|lang}</td> -->
                    <th>{'_ACCESS'|lang}</th>
                    <th>{'_FLAGS'|lang}</th>
                    <!-- <td>{"_STEAMID"|lang}</td> -->
                    <th>{'_ACTION'|lang}</th>
                </tr>
            </thead>
            {foreach from=$amxadmin item=amxadmin}
            <form name="admins" method="get" action="{$this}">
                <tr>
                    <td>
                        <input type='hidden' name='subsection' value='amxadmins'>
                        <input type='hidden' name='id' value='{$amxadmin.id}'>
                        <input class="input-medium" type="text" name="nickname" value="{$amxadmin.nickname}">
                    </td>
                    <td>
                        <input class="input-medium" type='text' name='username' value='{$amxadmin.username}'>
                    </td>
                    <!--
                    <td>
                        <input class="input-mini" type='text' name='password' value='{$amxadmin.password}'>
                    </td>
                    -->
                    <td>
                        <input class="input-medium" type='text' name='access' value='{$amxadmin.access}'>
                    </td>
                    <td>
                        <input class="input-mini" type='text' name='flags' value='{$amxadmin.flags}'>
                    </td>
                    <!-- <td><input type='text' name='steamid' value='{$amxadmin.steamid}'></td> -->
                    
                    <td>
                        <button class="btn btn-warning" type="submit" name="action" value="{'_APPLY'|lang}">{'_APPLY'|lang}</button>
                        <button class="btn btn-danger" type="submit" name="action" value="{'_REMOVE'|lang}">{'_REMOVE'|lang}</button
                    </td>
                </tr>
            </form>
            {/foreach}
            {* if $action == lang("_ADDAMXADMINS") *}
            <form name='admins' method='get' action='{$this}'>
            <tr>
                <td>
                    <input type="hidden" name="subsection" value="amxadmins">
                    <input class="input-medium" type="text" name="nickname">
                </td>
                <td>
                    <input class="input-medium" type="text" name="username">
                </td>
                <!-- <td><input class="input-medium" type='text' name='password'></td> -->
                <td>
                    <input class="input-medium" type="text" name="access">
                </td>
                <td>
                    <input class="input-mini" type="text" name="flags">
                </td>
                <!-- <td><input type='text' name='steamid'></td> -->
                <td>
                    <button class="btn btn-success" type="submit" name="action" value="{'_INSERT'|lang}">Add New Server Admin</button>
                </td>
            </tr>
            </form>
            {* /if *}
            <!--
            <form name="admins" method="get" action="{$this}">
                <tr>
                    <td colspan="12">
                        <input type="hidden" name="subsection" value="amxadmins">
                        <button class="btn btn-primary btn-block" type="submit" name="action" value="{'_ADDAMXADMINS'|lang}">{'_ADDAMXADMINS'|lang}</button>
                    </td>
                </tr>
            </form>
            -->
        </table>
    </div>
</div>