<?php
require_once('beans/VOIPTable.php');
require_once('db.php');

class IPTableService {

	/**
	* Retrieve all the records from the table
	* @return an array of VOIPTable
	*/
	public function getData($searchKey=null) {
	     //connect to the database.
	     $DB = connect_db(false);
	     //retrieve all rows
	     $rs = $DB->Execute("SELECT * FROM ip_table ORDER BY id");
	     $ret = array();
	     while (!$rs->EOF) {
		     $tmp = new VOIPTable();
		     $tmp->id = $rs->fields["id"];
		     $tmp->name = $rs->fields["name"]; 
		     $tmp->localIp = long2ip($rs->fields["local_ip"]);
		     $tmp->localMask = long2ip($rs->fields["local_mask"]); 
		     $ret[] = $tmp;
		     $rs->MoveNext();
	     }
	     close_db($DB);
	     return $ret;
	}
	
	/**
	* Update one item in the table
	* @param VOIPTable to be updated 
	* @return NULL
	*/
	public function updateData($obj) {
		if ($obj == NULL)
		     return NULL;
	     //connect to the database.
	     $DB = connect_db(false);
	     //save changes
	     $sql = "UPDATE ip_table SET name='".$obj->name."' WHERE id =".$obj->id;
	     $DB->execute($sql);
	     close_db($DB);
	     return NULL;
	}
	
	/**
	* Insert one item in the table
	* @param VOIPTable to be inserted 
	* @return NULL
	*/
	public function insertData($obj) {
		if ($obj == NULL)
		     return NULL;
	     //connect to the database.
	     $DB = connect_db(false);
	     $unsigned_ip = (substr($obj->localIp, 0, 3) > 127) ? ((ip2long($obj->localIp) & 0x7FFFFFFF) + 0x80000000) : ip2long($obj->localIp);
	 	 $unsigned_netmask = (substr($obj->localMask, 0, 3) > 127) ? ((ip2long($obj->localMask) & 0x7FFFFFFF) + 0x80000000) : ip2long($obj->localMask);
	 	 $unsigned_mask = (substr(long2ip($unsigned_ip & $unsigned_netmask), 0, 3) > 127) ? ($unsigned_ip & $unsigned_netmask & 0x7FFFFFFF) + 0x80000000 : ($unsigned_ip & $unsigned_netmask);
	     //save changes
	     $sql = "insert into ip_table values ('',?,?,?,?)";
	     $DB->execute($sql, array($obj->name, $unsigned_ip, $unsigned_netmask, $unsigned_mask));
	     return NULL;
	}
	
	/**
	* Insert one item in the table
	* @param VOIPTable to be updated 
	* @return NULL
	*/
	public function deleteData($obj) {
		if ($obj == NULL)
		     return NULL;
	     //connect to the database.
	     $DB = connect_db(false);
	     //save changes
	     $sql = "DELETE FROM ip_table WHERE id=?";
	     $DB->execute($sql, array($obj->id));
	     close_db($DB);
	     return NULL;
	}
}
?>