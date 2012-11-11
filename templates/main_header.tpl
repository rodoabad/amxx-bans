{php}
    CheckFrontEndState();
    
    if(isset($_COOKIE["amxbans"])) {
    	ReadSessionFromCookie();
    }
{/php}
<!DOCTYPE html>
<html lang="en">
    <head>
        <title>{$title}</title>
        <meta http-equiv="pragma" content="no-cache" />
        <meta http-equiv="cache-control" content="no-cache" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
			
		<link rel="stylesheet" type="text/css" href="{$dir}/css/normalize.css" />
		<link rel="stylesheet" type="text/css" href="{$dir}/css/bootstrap.css" />
		<link rel="stylesheet" type="text/css" href="{$dir}/css/bootstrap-responsive.css" />
		<link rel="stylesheet" type="text/css" href="{$dir}/css/amxbans.css" />
		
		<script src="//maps.googleapis.com/maps/api/js?sensor=false"></script>	
		<script src="//cdnjs.cloudflare.com/ajax/libs/jquery/1.7.2/jquery.min.js"></script>
		<script src="{$dir}/js/bootstrap.js"></script>
		<script src="{$dir}/js/amxxbans.js"></script>
			
		<script src="{$dir}/layer.js"></script>
	
	</head>

<body>
   

<div class="container">
    <div class="navbar">
        <div class="navbar-inner">
            <div class="container">
                <a class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse">
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </a>
                
                <a class="brand" href="javascript:void(0)">AMXX Bans (Beta)</a>
                <div class="nav-collapse">
                    <ul class="nav">
                        <li class="divider-vertical"></li>
                        <li class="{if $section == 'banlist'}active{/if}"><a href="{$dir}/ban_list.php">Ban List</a></li>
                        {if $display_search == 'enabled' || ($smarty.session.bans_add == 'yes')}
                            <li class="{if $section == 'search'}active{/if}"><a href="{$dir}/ban_search.php">Search</a></li>
                        {/if}
                        {if isset($smarty.session.uid)}
                            <li class="dropdown">
                                <a href="javascript:void(0)" class="dropdown-toggle" data-toggle="dropdown">
                                    Manage Bans
                                    <b class="caret"></b>
                                </a>
                                <ul class="dropdown-menu">
                                    {if ($smarty.session.bans_add == "yes")}
                                        <li class="{if $section == 'addban'}active{/if}"><a href="{$dir}/admin/add_ban.php">{'_ADDBAN'|lang}</a></li>
                                        <li class="{if $section == 'addliveban'}active{/if}"><a href="{$dir}/admin/add_live_ban.php">{'_ADDLIVEBAN'|lang}</a></li>
                                    {/if}
                                    {if ($smarty.session.bans_import == 'yes')}
                                        <li class="{if $section == 'import'}active{/if}"><a href="{$dir}/admin/import_bans.php">{'_IMPORT'|lang}</a></li>
                                    {/if}
                                    {if ($smarty.session.bans_export == 'yes')}
                                        <li class="{if $section == 'export'}active{/if}"><a href="{$dir}/export_bans.php">{'_EXPORT'|lang}</a></li>
                                    {/if}
                                </ul>
                            </li>
                            <li class="dropdown">
                                <a href="javascript:void(0)" class="dropdown-toggle" data-toggle="dropdown">
                                    Servers &amp; Admins
                                    <b class="caret"></b>
                                </a>
                                <ul class="dropdown-menu">
                                    {if ($smarty.session.amxadmins_edit == 'yes' || $smarty.session.webadmins_edit == 'yes' || $smarty.session.permissions_edit == 'yes')}
                                        <li class="{if $section == 'admins_levels'}active{/if}"><a href="{$dir}/admin/admins_levels.php" >{'_ADMINSLEVELS'|lang}</a></li>
                                    {/if}
                                    {if ($smarty.session.amxadmins_edit == 'yes' && $smarty.session.permissions_edit == 'yes')}
                                        <li class="{if $section == 'server_admins'}active{/if}"><a href="{$dir}/admin/server_admins.php" >{'_SERVERADMINS'|lang}</a></li>
                                    {/if}
                                    {if ($smarty.session.servers_edit == 'yes')}
                                        <li class="{if $section == 'servers'}active{/if}"><a href="{$dir}/admin/servers.php">{'_SERVERS'|lang}</a></li>
                                    {/if}
                                </ul>
                            </li>
                            <li class="dropdown">
                                <a href="javascript:void(0)" class="dropdown-toggle" data-toggle="dropdown">
                                    Administrator
                                    <b class="caret"></b>
                                </a>
                                <ul class="dropdown-menu">
                                    {if ($smarty.session.prune_db == 'yes')}
                                        <li class="{if $section == 'prune'}active{/if}"><a href="{$dir}/admin/prune_db.php">{'_PRUNEDB'|lang}</a></li>
                                    {/if}
                                    {if ($smarty.session.bans_add == 'yes' && $smarty.session.bans_import == 'yes' && $smarty.session.bans_export == 'yes' && $smarty.session.webadmins_edit == 'yes' && $smarty.session.prune_db == 'yes' && $smarty.session.amxadmins_edit == 'yes' && $smarty.session.permissions_edit == 'yes')}
                                        <li class="{if $section == 'config'}active{/if}"><a href="{$dir}/admin/cfg.php">{'_CONFIG'|lang}</a></li>
                                        <li class="{if $section == 'logs'}active{/if}"><a href="{$dir}/admin/log_search.php">{'_ACCESSLOG'|lang}</a></li>
                                    {/if}
                        
                                </ul>
                            </li>
                        {/if}
                    </ul>
                    <ul class="nav pull-right">
                        <li class="divider-vertical"></li>
                        <li class="">
                            {if isset($smarty.session.uid)}
                                <a href="{$dir}/logout.php">{'_LOGOUT'|lang}</a>
                            {else}
                                <a href="{$dir}/login.php">{'_LOGIN'|lang}</a>
                            {/if}
                        </li>
                       
                    </ul>
               </div>
            </div>
        </div>
    </div>
    
    {php}
        global $config;
        if($config->disable_frontend == 'true') {
            echo '<div class="alert alert-error">';
            echo '<button type="button" class="close" data-dismiss="alert">×</button>';
            echo '<strong>Oh snap!</strong> AMXX Bans is currently disabled. Contact your system administrator for more information.';
            echo '</div>';
        }
    {/php}

    {if isset($smarty.session.uid)}
    <!-- 
        <div class="alert alert-success">
            <button type="button" class="close" data-dismiss="alert">×</button>
            <strong>Well done!</strong> {'_LOGGED'|lang } {$smarty.session.uid}
        </div>
    -->
    {else}
        <div class="alert">
            <button type="button" class="close" data-dismiss="alert">×</button>
            <strong>Warning!</strong> {'_NOTLOGGED'|lang}.
        </div>
    {/if}