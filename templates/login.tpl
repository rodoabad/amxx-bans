<!DOCTYPE html>
<html lang="en">
	<head>
		<title>{$title}</title>
		<meta http-equiv="pragma" content="no-cache" />
		<meta http-equiv="cache-control" content="no-cache" />
			
		<link rel="stylesheet" type="text/css" href="{$dir}/css/reset.css" />
		<link rel="stylesheet" type="text/css" href="{$dir}/css/bootstrap.css" />
		<link rel="stylesheet" type="text/css" href="{$dir}/css/amxbans.css" />
			
		<script src="//cdnjs.cloudflare.com/ajax/libs/jquery/1.7.2/jquery.min.js"></script>
		<script src="//cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/2.0.3/bootstrap.min.js"></script>
	
	</head>

	<body>
		<div class="container pad20-v">
			<div class="block6 block-center">
				
				<form class="well content-center" name="login" method="post" action="{$this}">
					<div class="block-header">
						<h1>{"_LOGIN"|lang}</h1>
					</div>
					
					<input type="hidden" name="remember" value="on">
					<input type="text" placeholder="{'_USERNAME'|lang}" name="uid">		    
					<input type="password" placeholder="{'_PASSWORD'|lang}" name="pwd">
					
					<div class="clearfix"></div>
					
					<button class="btn btn-large btn-primary" type="submit" name="login" value="{'_LOGIN'|lang}">Log In</button>
				</form>
			</div>
		</div>
	</body>

</html>