<?
// -------------------------------------------------
//	FILE  : display HL game server infos
//	author : Conrad
//
//	last modif :03/19/03 00:30
//
// -------------------------------------------------
// v2.0
// ----------------------------
// by Conrad
// lordconrad@ifrance.com
// http://conradworld.free.fr/gsi/
//
// see help_hl.html


// functions to sort players & rules
function name_desc($a, $b) {   
	if (ord(strtolower($a[0])) == ord(strtolower($b[0]))) return 0;
	return (ord(strtolower($a[0])) > ord(strtolower($b[0]))) ? -1 : 1;
}
function name_asc($a, $b) {   
	if (ord(strtolower($a[0])) == ord(strtolower($b[0]))) return 0;
	return (ord(strtolower($a[0])) < ord(strtolower($b[0]))) ? -1 : 1;
}
function frag_desc ($a, $b) {   
	if ($a[1] == $b[1]) return 0;
	return ($a[1] > $b[1]) ? -1 : 1;
}	
function frag_asc($a, $b) {   
	if ($a[1] == $b[1]) return 0;
	return ($a[1] < $b[1]) ? -1 : 1;
}


/* ----------------------------------------------------------------------------------------------------------
                                                   HLSERVER_INFOS
---------------------------------------------------------------------------------------------------------- */
class HLSERVER_INFOS {

  // class infos
  var $author = 'Conrad';
  var $ver = '2.0';
  
  // gameserver params
  var $serv_host;
  var $serv_port;
  
  // default
  var $serv_port_default = '27015';
  
  // players options
  var $player_dohtmlspecialchars = true;
  var $player_timeformat = 'i:s';
  
  // server commands
  var $serv_requestcommand_infos = "\xFF\xFF\xFF\xFFTSource Engine Query\0\x00";
  var $serv_requestcommand_rules = "\xFF\xFF\xFF\xFFV\x00";
  var $serv_requestcommand_players  = "\xFF\xFF\xFF\xFFU\x00";
  var $serv_rconcommand1 = "\xFF\xFF\xFF\xFFchallenge rcon\x00";
  var $serv_rconcommand2 = "\xFF\xFF\xFF\xFFrcon";
  
  // gameserver data
  var $serv_infos = array();
  var $serv_infos2 = array();
  var $serv_rules = array();
  var $serv_rules2 = array();
  var $serv_players = array();
  
  var $serv_players_nb = '0';
  
  var $serv_rcon_response = '';
  
  // brut
  var $serv_infos_brut;
  var $serv_rules_brut;
  var $serv_players_brut;
  
  // error control
  var $s_errno = '';
  var $s_errstr = '';
  
  var $error = '';

  // misc
  var $timeout = 2;
  var $win32 = false;
  
  var $connected = false;
  var $socket;

// ----------------------------------------------------------------------------------------------------------------
//						PRIVATE METHODS
// ----------------------------------------------------------------------------------------------------------------


// --------------------------------------
//	send a command to the server & get returns
// --------------------------------------

function command($command,&$data) {

	// verify we are connected
	if (!$this->connected) { return false; }

	// send command
	fwrite($this->socket,$command);

	// server return
	$data = fread ($this->socket, 1);
	$status = socket_get_status($this->socket);
        
        // Sander's fix :)
        if ($status["unread_bytes"] > 0) {
           $data .= fread($this->socket, $status["unread_bytes"]);
        }
	

	// more rules ?
	if(substr($data, 0, 4) == "\xfe\xff\xff\xff")
	{
		// server return
		$tempdata = fread ($this->socket, 1);
		$status = socket_get_status($this->socket);
		$temprules .= fread($this->socket, $status["unread_bytes"]);

		// position control of returns
		if(strlen($data) > strlen($tempdata)) { $data = substr($data, 14) . substr($tempdata, 9); }
		else { $data = substr($tempdata, 14) . substr($data, 9); }
	}

return true;

}


// ----------------------------------------------------------------------------------------------------------------
//						PUBLIC METHODS
// ----------------------------------------------------------------------------------------------------------------


// -------------------------------------
//	set vars on class' init
// -------------------------------------
function hlserver_infos($host='',$port='') {

	if ( $host != '') { $this->connect($host,$port); }
}


// ----------------------------------------
//	retrieve an infos or rules
// ----------------------------------------
function get_info($info,$default='') {

	if ($this->serv_infos2[$info] != '') { return $this->serv_infos2[$info]; }
	else { return $default; }
}
function get_rule($rule,$default='') {
	
	if ($this->serv_rules2[$rule] != '') { return $this->serv_rules2[$rule]; }
	else { return $default; }
}


// -------------------------------------
//	connect
// -------------------------------------
function connect($host='',$port='') {

	// deconnect from server
	if ($this->connected) { fclose($this->socket); }
	$this->connected = false;

	// params ?
	if ($host != '') {

			if (strpos($host,':')) { $this->serv_host = substr($host,0,strpos($host,':')); $this->serv_port = substr($host,(strpos($host,':') + 1)); }
			else {
					$this->serv_host = $host;
					if ($port != '') { $this->serv_port = $port; }
					else { $this->serv_port = $this->serv_port_default; }
			}
	}
	// verifs
	if ($this->serv_host == '') { $this->error = 'no host given'; return false; }
	if (($this->serv_port == '') and ($port != '')) { $this->serv_port = $port; }
	elseif ($this->serv_port == '')  { $this->serv_port = $this->serv_port_default; }

	// open socket
	$fp = fsockopen(('udp://' . $this->serv_host),$this->serv_port, &$this->s_errno, &$this->s_errstr, 2);
        stream_set_timeout($fp, 2);
	// error control
	if (!$fp) {
			$this->error = 'socket error';
			fclose($fp);
			$this->connected = false;
			return false;
	}
	else {
			// blocking mode
			socket_set_blocking ($fp, 1);
			// timeout
			if ($this->win32 == false) { socket_set_timeout($fp, $this->timeout); }
	
		// assign socket
		$this->socket = $fp;
		$this->connected = true;
	}

return true;
}


// -------------------------------------
//	rcon
// -------------------------------------
function rcon($password,$rcon_cmd) {

	if ($password == '') { $this->error = 'Password empty';	return false; }
	elseif ($rcon_cmd == '') { $this->error = 'Rcon command empty'; return false; }
	// elseif (strlen($rcon_cmd) > 240) { $this->error = 'Command is too long (240 max)'; return false; }
	
		$this->serv_rcon_response = '';
		$serv_rcon_number = '';
		$serv_rcon_temp = '';

		// retrieve rcon number from server
		$this->command($this->serv_rconcommand1,$serv_rcon_temp);

		$serv_rcon_number = substr($serv_rcon_temp,19);
		$serv_rcon_number = trim($serv_rcon_number);

		// send rcon command
		$serv_rcon_temp = '';
		$this->command($this->serv_rconcommand2 . ' ' . $serv_rcon_number . ' "' . $password . '" ' . $rcon_cmd,$serv_rcon_temp);

		$serv_rcon_temp = substr($serv_rcon_temp,6);
		if ($serv_rcon_temp == '') { $this->serv_rcon_response = ''; return true; }
		$this->serv_rcon_response = $serv_rcon_temp;
		$this->serv_rcon_response = trim($this->serv_rcon_response);

		return true;
}


// --------------------------------------
//	get & parse server's infos
// --------------------------------------

// return true/false if error, assign var $serv_infos : multi-array -----> [x][0][1][2]  --> [x] = array id  |  [0] = "name=value"  |  [1] = name  |  [2] = value
// and $serv_infos2 : associative array [infos] = value
function get_infos() {

	// command
	if (!$this->command($this->serv_requestcommand_infos,$this->serv_infos_brut)) { return false; }
	
	// assign field name
	$this->serv_infos[0][1] = 'address';
	$this->serv_infos[1][1] = 'name';
	$this->serv_infos[2][1] = 'map';
	$this->serv_infos[3][1] = 'game';	
	$this->serv_infos[4][1] = 'game_desc';
	$this->serv_infos[5][1] = 'players';
	$this->serv_infos[6][1] = 'maxplayers';
	$this->serv_infos[7][1] = 'protocol';

	// explode server return by line (strings)
	$infos = explode(chr(0), substr($this->serv_infos_brut,5,strlen($this->serv_infos_brut) - 9));

	// treat string rules
	while(List($key,$value) = each($infos))
	{
		$this->serv_infos[$key][0] = $this->serv_infos[$key][1] . '=' . $value;
		$this->serv_infos[$key][2] = $value;
		$this->serv_infos2[$this->serv_infos[$key][1]] = $value;
	}

	// treat byte rules
	for ($i=1;$i<4;$i++) {

		$this->serv_infos[4+$i][2] = ord($this->serv_infos_brut[strlen(substr($this->serv_infos_brut,5,strlen($this->serv_infos_brut) - 9))+5+$i]);
		$this->serv_infos[4+$i][0] = $this->serv_infos[4+$i][1] . '=' . $this->serv_infos[4+$i][2];
		$this->serv_infos2[$this->serv_infos[4+$i][1]] = $this->serv_infos[4+$i][2];
	}

	// assign number of players (alias)
	$this->serv_players_nb = $this->serv_infos2['players'];

return true;

}


// --------------------------------------
//	get & parse server's rules
// --------------------------------------

// return true/false if error, assign var $serv_rules : multi-array -----> [x][0][1][2]  --> [x] = array id  |  [0] = "name=value"  |  [1] = name  |  [2] = value
// and $serv_rules2 : associative array [infos] = value
function get_rules($rules_sorting='name_asc') {

	// command
	if (!$this->command($this->serv_requestcommand_rules,$this->serv_rules_brut)) { return false; }

	// explode server return by line (strings)
	$rules = explode(chr(0), substr($this->serv_rules_brut,7));
	if ($rules[count($rules) - 2] == '') { array_splice($rules,count($rules)-2,2); }
	elseif ($rules[count($rules) - 1] == '') { array_splice($rules,count($rules)-1,1); }

	// treat rules
	$counter = 0;
	while(List($key,$value) = each($rules))
	{
		// this is the name of the rule
		if (($key%2)==0) {
			$this->serv_rules[$counter][0] = $value;
			$this->serv_rules[$counter][1] = $value;
		}
		// this is the value of the rule
		else {
			if ($value == '') { $value = $key . '-' . count($rules) . "&nbsp;"; }
			$this->serv_rules2[$this->serv_rules[$counter][0]] = $value;

			$this->serv_rules[$counter][0] = $this->serv_rules[$counter][0] . '=' . $value;
			$this->serv_rules[$counter][2] = $value;
				
			$counter++;
		}	
	}

usort($this->serv_rules,$rules_sorting);
return true;

}


// -------------------------------------
//	get & parse players' infos
// -------------------------------------

function get_players($player_sorting='frag_desc') {

	// command
	if (!$this->command($this->serv_requestcommand_players,$this->serv_players_brut)) { return false; }

	// clear header
	$players = substr($this->serv_players_brut,5);
	// re-get&set nb of players (useful if parsing infos is off)
	$this->serv_players_nb = ord($players);
	$players = substr($players,2);

	for ($i=0;$i<($this->serv_players_nb);$i++)
	{
		// $this->serv_players[$i][0] = ord($players[0]);
		//nick
		$this->serv_players[$i][0] = substr($players,0,strpos($players,chr(0)));
			$players = substr($players,strlen($this->serv_players[$i][0])+1);
		if ($this->player_dohtmlspecialchars) { $this->serv_players[$i][0] = htmlspecialchars($this->serv_players[$i][0]); }

		// frag
		$this->serv_players[$i][1] = ord($players[0]) + (ord($players[1])<<8) + (ord($players[2])<<16) + (ord($players[3])<<24);
			$players = substr($players,4);
		// playingtime
		$tmptime = @unpack('ftime', substr($players,0, 4));
		$this->serv_players[$i][2] = date($this->player_timeformat, round($tmptime['time'], 0) + 82800);
			$players = substr($players,5);
	}

	usort($this->serv_players,$player_sorting);
	return true;
}


// -------------------------------------
//	get & parse (redirect)
// -------------------------------------

function parse($do_infos=true,$do_rules=true,$do_players=true,$rules_sorting='name_asc',$player_sorting='frag_desc') {

		// parse ?
		if ($do_infos == true) { $this->get_infos(); }
		if ($do_rules == true) { $this->get_rules($rules_sorting); usort($this->serv_rules,$rules_sorting); }
		if ($do_players == true) { $this->get_players($player_sorting);  usort($this->serv_players,$player_sorting);}

return true;
}

// redirect for connect and parse
function connectandparse($host='',$port='',$do_infos=true,$do_rules=true,$do_players=true,$rules_sorting='name_asc',$player_sorting='frag_desc') {

	if (!$this->connect($host,$port)) { return false; }
	else { $this->parse($do_infos,$do_rules,$do_players,$rules_sorting,$player_sorting); }
}
} // end of class
?>
