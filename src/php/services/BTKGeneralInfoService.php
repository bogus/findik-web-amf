<?php
include_once('beans/VOBTKGeneralInfo.php');
include_once('db.php');

class BTKGeneralInfoService {

	/**
	* Retrieve all the records from the table
	* @return an array of VOTimeline
	*/
	public function getData($searchKey=null) {
	     //connect to the database.
	     $DB = connect_db(false);
	     //retrieve all rows
	     $rs = $DB->Execute("SELECT * FROM btk_db_update ORDER BY update_date DESC LIMIT 1");
	     $ret = array();
	     while (!$rs->EOF) {
		     $tmp = new VOBTKGeneralInfo();
		     $tmp->updateName = $rs->fields["update_id"]; 
		     $tmp->updateDate = $rs->fields["update_date"];
		     $tmp->currentClient = 10;
		     $ret[] = $tmp;
		     $rs->MoveNext();
	     }
	     return $ret;
	     close_db($DB);
	}
	
	/**
	* Update one item in the table
	* @param VOTimeline to be updated 
	* @return NULL
	*/
	public function updateData($obj) {
	     return NULL;
	}
	
	/**
	* Insert one item in the table
	* @param VOTimeline to be updated 
	* @return NULL
	*/
	public function insertData($user) {
		return NULL;
	}
	
	/**
	* Insert one item in the table
	* @param VOTimeline to be updated 
	* @return NULL
	*/
	public function deleteData($user) {
		return NULL;
	}
}
?>