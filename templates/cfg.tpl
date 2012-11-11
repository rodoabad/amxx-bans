<h1>{'_AMXBANSCONFIG'|lang}</h1>

<div class="row-fluid">
	<form name="section" method="post" action="{$this}">

        <div class="span4">
    		<h2>{'_MAINSWITCH'|lang}</h2>
    		<label>{'_DISABLEAMXBANS'|lang}</label>
    		<select name="disable_frontend">
    			<option value="true" {if $cfg->disable_frontend == 'true'}selected{/if}>{'_YES'|lang}</option>
    			<option value="false" {if $cfg->disable_frontend == 'false'}selected{/if}>{'_NO'|lang}</option>
    		</select>
    
    		<h2>{'_DIRECTORIES'|lang}</h2>
    
    		<label>{'_DOCROOT'|lang}</label>
    		<input type="text" name="document_root" value="{$cfg->document_root}">
    		{if $post.dir == lang('_CHECKDIRS')}
    			{if $doc_root_is_dir != 1}
    				<font color="#ff0000">Directory does not appear to be the document root.</font>
    			{else}
    				<font color="#00b266">OK.</font>
    			{/if}
    		{/if}
    		
    		<label>{'_PATH'|lang}</label>
    		<input type="text" name="path_root" value="{$cfg->path_root}">
    		{if $post.dir == lang('_CHECKDIRS')}
    			{if $path_root_is_dir != 1}
    				<font color="#ff0000">Directory does not exist or is invalid.</font>
    			{else}
    				<font color="#00b266">OK.</font>
    			{/if}
    		{/if}
    
    		<label>{'_IMPORTDIR'|lang}</label>
    		<input type="text" name="import_dir" value="{$cfg->importdir}">
    		{if $post.dir == lang('_CHECKDIRS')}
    			{if $dir_import_is_dir != 1}
    				<font color="#ff0000">Directory does not exist or is invalid.</font>
    			{else}
    				<font color="#00b266">OK.</font>
    			{/if}
    		{/if}
    
    		<label>{'_TEMPLATEDIR'|lang}</label>
    		<input type="text" name="template_dir" value="{$cfg->templatedir}">
    		{if $post.dir == lang('_CHECKDIRS')}
    			{if $dir_template_is_dir != 1}
    				<font color="#ff0000">Directory does not exist or is invalid.</font>
    			{else}
    				<font color="#00b266">OK.</font>
    			{/if}
    		{/if}
    		
    		<h2>{'_DATABASE'|lang}</h2>
    
    		<label>{'_DATABASESERVER'|lang}</label>
    		<input type="text" name="db_host" value="{if isset($post.db_host)}{$post.db_host}{else}{$cfg->db_host}{/if}">
    	
    		<label>{'_DBNAME'|lang}</label>
    		<input type="text" name="db_name" value="{if isset($post.db_name)}{$post.db_name}{else}{$cfg->db_name}{/if}">
    	
    	
    		<label>{'_DBUSER'|lang}</label>
    		<input type="text" name="db_user" value="{if isset($post.db_user)}{$post.db_user}{else}{$cfg->db_user}{/if}">
    	
    	
    		<label>{'_DBPASS'|lang}</label>
    		<input type="password" name="db_pass" value="{if isset($post.db_pass)}{$post.db_pass}{else}{$cfg->db_pass}{/if}">
    		
    		{if $dblogin == 0}
    			<font color="#ff0000">Please fill in all required fields.</font>
    		{elseif $dblogin == 1}
    			<font color="#ff0000">Can't connect to server.</font>
    		{elseif $dblogin == 2}
    			<font color="#ff0000">Can't switch to Database.</font>
    		{elseif $dblogin == 3}
    			<font color="#00b266">DB details OK.</font>
    		{/if}
		</div>
		
		<div class="span4">
    		<h2>{'_DBTBLS'|lang}</h2>
    	
    	
    		<label>{'_BANSTBL'|lang}</label>
    		<input type="text" name="tbl_bans" value="{$cfg->bans}">
    	
    		<label>{'_BANHISTBL'|lang}</label>
    		<input type="text" name="tbl_banhistory" value="{$cfg->ban_history}">
    	
    		<label>{'_WEBADMINSTBL'|lang}</label>
    		<input type="text" name="tbl_webadmins" value="{$cfg->webadmins}">
    	
    		<label>{'_AMXADMINSTBL'|lang}</label>
    		<input type="text" name="tbl_amxadmins" value="{$cfg->amxadmins}">
    	
    		<label>{'_LEVELSTBL'|lang}</label>
    		<input type="text" name="tbl_levels" value="{$cfg->levels}">
    	
    		<label>{'_ADMINSSERVTBL'|lang}</label>
    		<input type="text" name="tbl_admins_servers" value="{$cfg->admins_servers}">
    	
    		<label>{'_SERVTBL'|lang}</label>
    		<input type="text" name="tbl_servers" value="{$cfg->servers}">
    	
    		<label>{'_LOGSTBL'|lang}</label>
    		<input type="text" name="tbl_logs" value="{$cfg->logs}">
    	
    		<label>{'_REASONSTBL'|lang}</label>
    		<input type="text" name="tbl_reasons" value="{$cfg->reasons}">
    	
    		<h2>{'_ADMININFO'|lang}</h2>
    	
    		<label>{'_MAINADMINNICK'|lang}</label>
    		<input type="text" name="admin_nick" value="{$cfg->admin_nickname}">
    	
    		<label>{'_MAINADMINMAIL'|lang}</label>
    		<input type="text" name="admin_email" value="{$cfg->admin_email}">
    	
    		<h2>{'_CUSTOMERRORHANDLER'|lang}</h2>
    	
    		<label>{'_ERRORHANDLER'|lang}</label>
    		<select name="error_handler">
    			<option value="enabled" {if $cfg->error_handler == 'enabled'}selected{/if}>{'_YES'|lang}</option>
    			<option value="disabled" {if $cfg->error_handler == 'disabled'}selected{/if}>{'_NO'|lang}</option>
    		</select>
    
    		<label>{'_CUSTOMERRORHANDLER'|lang}</label>
    		<input type="text" name="error_handler_path" value="{$cfg->error_handler_path}">
	    </div>
	    <div class="span4">
		<h2>{'_INFOPTIONS'|lang}</h2>
	
	
		<label>{'_DEFAULTLANG'|lang}</label>
		
		{assign var='lang' value=$true|getlanguage}

		<select name="default_lang">
			{foreach from=$lang item='lang'}
				<option value="{$lang|escape}" {if $cfg->default_lang == $lang}selected{/if}>{$lang|escape}</option>
			{/foreach}
		</select>


		<label>{'_USEAMXMAN'|lang}</label>
		<select name="admin_management">
			<option value="enabled" {if $cfg->admin_management == 'enabled'}selected{/if}>{'_YES'|lang}</option>
			<option value="disabled" {if $cfg->admin_management == 'disabled'}selected{/if}>{'_NO'|lang}</option>
		</select>

		<label>{'_FANCYLAYERS'|lang}</label>
		<select name="fancy_layers">
			<option value="enabled" {if $cfg->fancy_layers == 'enabled'}selected{/if}>{'_YES'|lang}</option>
			<option value="disabled" {if $cfg->fancy_layers == 'disabled'}selected{/if}>{'_NO'|lang}</option>
		</select>

		<label>{'_VERSIONCHECK'|lang}</label>
		<select name="version_checking">
			<option value="enabled" {if $cfg->version_checking == 'enabled'}selected{/if}>{'_YES'|lang}</option>
			<option value="disabled" {if $cfg->version_checking == 'disabled'}selected{/if}>{'_NO'|lang}</option>
		</select>

		<label>{'_HOURSONSERVER'|lang}</label>
		
		<select name="timezone_fix">
			<option value="0" {if $cfg->timezone_fix == '0'}selected{/if}>0</option>
			<option value="1" {if $cfg->timezone_fix == '1'}selected{/if}>1</option>
			<option value="2" {if $cfg->timezone_fix == '2'}selected{/if}>2</option>
			<option value="3" {if $cfg->timezone_fix == '3'}selected{/if}>3</option>
			<option value="4" {if $cfg->timezone_fix == '4'}selected{/if}>4</option>
			<option value="5" {if $cfg->timezone_fix == '5'}selected{/if}>5</option>
			<option value="6" {if $cfg->timezone_fix == '6'}selected{/if}>6</option>
			<option value="7" {if $cfg->timezone_fix == '7'}selected{/if}>7</option>
			<option value="8" {if $cfg->timezone_fix == '8'}selected{/if}>8</option>
			<option value="9" {if $cfg->timezone_fix == '9'}selected{/if}>9</option>
			<option value="10" {if $cfg->timezone_fix == '10'}selected{/if}>10</option>
			<option value="11" {if $cfg->timezone_fix == '11'}selected{/if}>11</option>
			<option value="12" {if $cfg->timezone_fix == '12'}selected{/if}>12</option>
			<option value="-1" {if $cfg->timezone_fix == '-1'}selected{/if}>-1</option>
			<option value="-2" {if $cfg->timezone_fix == '-2'}selected{/if}>-2</option>
			<option value="-3" {if $cfg->timezone_fix == '-3'}selected{/if}>-3</option>
			<option value="-4" {if $cfg->timezone_fix == '-4'}selected{/if}>-4</option>
			<option value="-5" {if $cfg->timezone_fix == '-5'}selected{/if}>-5</option>
			<option value="-6" {if $cfg->timezone_fix == '-6'}selected{/if}>-6</option>
			<option value="-7" {if $cfg->timezone_fix == '-7'}selected{/if}>-7</option>
			<option value="-8" {if $cfg->timezone_fix == '-8'}selected{/if}>-8</option>
			<option value="-9" {if $cfg->timezone_fix == '-9'}selected{/if}>-9</option>
			<option value="-10" {if $cfg->timezone_fix == '-10'}selected{/if}>-10</option>
			<option value="-11" {if $cfg->timezone_fix == '-11'}selected{/if}>-11</option>
			<option value="-12" {if $cfg->timezone_fix == '-12'}selected{/if}>-12</option>
		</select>
	
		<label>{'_PUBLICSEARCH'|lang}</label>
		<select name="display_search">
			<option value="enabled" {if $cfg->display_search == 'enabled'}selected{/if}>{'_YES'|lang}</option>
			<option value="disabled" {if $cfg->display_search == 'disabled'}selected{/if}>{'_NO'|lang}</option>
		</select>

		<label>{'_DISPLAYADMIN'|lang}</label>
		<select name="display_admin">
			<option value="enabled" {if $cfg->display_admin == 'enabled'}selected{/if}>{'_YES'|lang}</option>
			<option value="disabled" {if $cfg->display_admin == 'disabled'}selected{/if}>{'_NO'|lang}</option>
		</select>

		<label>{'_DISPLAYREASON'|lang}</label>
		<select name="display_reason">
			<option value="enabled" {if $cfg->display_reason == 'enabled'}selected{/if}>{'_YES'|lang}</option>
			<option value="disabled" {if $cfg->display_reason == 'disabled'}selected{/if}>{'_NO'|lang}</option>
		</select>

		<label>{'_GEOIP'|lang}</label>
		<select name="geoip">
			<option value="enabled" {if $cfg->geoip == 'enabled'}selected{/if}>{'_YES'|lang}</option>
			<option value="disabled" {if $cfg->geoip == 'disabled'}selected{/if}>{'_NO'|lang}</option>
		</select>

		<label>{'_MAXOFFENCES'|lang}</label>
		<select name="autopermban_count">
			<option value="disabled" {if $config->autopermban_count == 'disabled' }selected{/if}>Disabled</option>
			<option value="1" {if $cfg->autopermban_count == '1'}selected{/if}>1</option>
			<option value="2" {if $cfg->autopermban_count == '2'}selected{/if}>2</option>
			<option value="3" {if $cfg->autopermban_count == '3'}selected{/if}>3</option>
			<option value="4" {if $cfg->autopermban_count == '4'}selected{/if}>4</option>
			<option value="5" {if $cfg->autopermban_count == '5'}selected{/if}>5</option>
			<option value="6" {if $cfg->autopermban_count == '6'}selected{/if}>6</option>
			<option value="7" {if $cfg->autopermban_count == '7'}selected{/if}>7</option>
			<option value="8" {if $cfg->autopermban_count == '8'}selected{/if}>8</option>
			<option value="9" {if $cfg->autopermban_count == '9'}selected{/if}>9</option>
		</select>

		<label>{'_BANPERPAGE'|lang}</label>
		<select name="bans_per_page">
			<option value="10" {if $cfg->bans_per_page == '10'}selected{/if}>10</option>
			<option value="25" {if $cfg->bans_per_page == '25'}selected{/if}>20</option>
			<option value="50" {if $cfg->bans_per_page == '50'}selected{/if}>50</option>
			<option value="75" {if $cfg->bans_per_page == '75'}selected{/if}>70</option>
			<option value="100" {if $cfg->bans_per_page == '100'}selected{/if}>100</option>
		</select>

		<label>{'_RCONCLASS'|lang}</label>
		<select name="rcon_class">
			<option value="two" {if $cfg->rcon_class == 'two'}selected{/if}>PHPrcon (http://server.counter-strike.net/phprcon/development.php)</option>
			<option value="one" {if $cfg->rcon_class == 'one'}selected{/if}>[Game]Server_Infos (http://gsi.probal.fr/index_en.php)</option>
		</select>
        </div>
        
		<div class="clearfix"></div>

		<button class="btn btn-info" type="submit" name="dir" value="{'_CHECKDIRS'|lang}">{'_CHECKDIRS'|lang}</button>
		<button class="btn btn-info" type="submit" name="db" value="{'_CHECKCONNECT'|lang}">{'_CHECKCONNECT'|lang}</button>
		<button class="btn btn-primary" type="submit" name="action" value="{'_APPLY'|lang}" onclick="javascript:return confirm('{'_SURETOSAVE'|lang}')">{'_APPLY'|lang}</button>
	   
	</form>
</div>