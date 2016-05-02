<?php
class Database {


var $server   = "";
var $user     = "";
var $pass     = "";
var $database = "";
var $pre      = "";

var $error = "";
var $errno = 0;

var $affected_rows = 0;

var $link_id = 0;
var $query_id = 0;

function Database($server, $user, $pass, $database, $pre=''){
	$this->server=$server;
	$this->user=$user;
	$this->pass=$pass;
	$this->database=$database;
	$this->pre=$pre;
}

function connect($new_link=false) {
	$this->link_id=@mysql_connect($this->server,$this->user,$this->pass,$new_link);

	if (!$this->link_id) {
		$this->oops("Холболт амжилтгүй боллоо: <b>$this->server</b>.");
		}

	if(!@mysql_select_db($this->database, $this->link_id)) {
		$this->oops("Мэдээллийн сан алга байна: <b>$this->database</b>.");
		}

	$this->server='';
	$this->user='';
	$this->pass='';
	$this->database='';
	mysql_set_charset('utf8');
}

function close() {
	if(!@mysql_close($this->link_id)){
		$this->oops("Холболтыг устгаж чадсангүй.");
	}
}

function escape($string) {
	if(get_magic_quotes_runtime()) $string = stripslashes($string);
	return @mysql_real_escape_string($string,$this->link_id);
}

function query($sql) {
	$this->query_id = @mysql_query($sql, $this->link_id);

	if (!$this->query_id) {
		$this->oops("<b>MySQL Query амжилтгүй боллоо:</b> $sql");
		return 0;
	}
	
	$this->affected_rows = @mysql_affected_rows($this->link_id);

	return $this->query_id;
}

function fetch_array($query_id=-1) {
	if ($query_id!=-1) {
		$this->query_id=$query_id;
	}

	if (isset($this->query_id)) {
		$record = @mysql_fetch_assoc($this->query_id);
	}else{
		$this->oops("Query_id: <b>$this->query_id</b>. Мэдээлэл олдсонгүй.");
	}

	return $record;
}

function fetch_all_array($sql) {
	$query_id = $this->query($sql);
	$out = array();

	while ($row = $this->fetch_array($query_id)){
		$out[] = $row;
	}

	$this->free_result($query_id);
	return $out;
}

function free_result($query_id=-1) {
	if ($query_id!=-1) {
		$this->query_id=$query_id;
	}
	if($this->query_id!=0 && !@mysql_free_result($this->query_id)) {
		$this->oops("Result ID: <b>$this->query_id</b> устгагдсангүй.");
	}
}

function query_first($query_string) {
	$query_id = $this->query($query_string);
	$out = $this->fetch_array($query_id);
	$this->free_result($query_id);
	return $out;
}

function query_update($table, $data, $where='1') {
	$q="UPDATE `".$this->pre.$table."` SET ";

	foreach($data as $key=>$val) {
		if(strtolower($val)=='null') $q.= "`$key` = NULL, ";
		elseif(strtolower($val)=='now()') $q.= "`$key` = NOW(), ";
        elseif(preg_match("/^increment\((\-?\d+)\)$/i",$val,$m)) $q.= "`$key` = `$key` + $m[1], "; 
		else $q.= "`$key`='".$this->escape($val)."', ";
	}

	$q = rtrim($q, ', ') . ' WHERE '.$where.';';

	return $this->query($q);
}


function query_insert($table, $data) {
	$q="INSERT INTO `".$this->pre.$table."` ";
	$v=''; $n='';

	foreach($data as $key=>$val) {
		$n.="`$key`, ";
		if(strtolower($val)=='null') $v.="NULL, ";
		elseif(strtolower($val)=='now()') $v.="NOW(), ";
		else $v.= "'".$this->escape($val)."', ";
	}

	$q .= "(". rtrim($n, ', ') .") VALUES (". rtrim($v, ', ') .");";

	if($this->query($q)){
		return mysql_insert_id($this->link_id);
	}
	else return false;

}

function oops($msg='') {
	if($this->link_id>0){
		$this->error=mysql_error($this->link_id);
		$this->errno=mysql_errno($this->link_id);
	}
	else{
		$this->error=mysql_error();
		$this->errno=mysql_errno();
	}
	?>
		<table align="center" border="1" cellspacing="0" style="background:white;color:black;width:80%;">
		<tr><th colspan=2>Алдаа</th></tr>
		<tr><td align="right" valign="top">Тайлбар:</td><td><?php echo $msg; ?></td></tr>
		<?php if(!empty($this->error)) echo '<tr><td align="right" valign="top" nowrap>MySQL алдаа:</td><td>'.$this->error.'</td></tr>'; ?>
		<tr><td align="right">Date:</td><td><?php echo date("l, F j, Y \a\\t g:i:s A"); ?></td></tr>
		<?php if(!empty($_SERVER['REQUEST_URI'])) echo '<tr><td align="right">Script:</td><td><a href="'.$_SERVER['REQUEST_URI'].'">'.$_SERVER['REQUEST_URI'].'</a></td></tr>'; ?>
		<?php if(!empty($_SERVER['HTTP_REFERER'])) echo '<tr><td align="right">Referer:</td><td><a href="'.$_SERVER['HTTP_REFERER'].'">'.$_SERVER['HTTP_REFERER'].'</a></td></tr>'; ?>
		</table>
	<?php
}


}
?>