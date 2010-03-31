<?php
include_once('beans/VOBTKDbUpdate.php');
include_once('db.php');

class BTKDbUpdateService {

	/**
	* Retrieve all the records from the table
	* @return an array of VOTimeline
	*/
	public function getData($searchKey=null) {
	     //connect to the database.
	     $DB = connect_db(false);
	     //retrieve all rows
	     $rs = $DB->Execute("SELECT * FROM btk_db_update ORDER BY id desc");
	     $ret = array();
	     while (!$rs->EOF) {
		     $tmp = new VOBTKDbUpdate();
		     $tmp->id = $rs->fields["id"];
		     $tmp->updateId = $rs->fields["update_id"]; 
		     $tmp->updateDate = $rs->fields["update_date"];
		     $tmp->newRecordCount = $rs->fields["new_record_count"];
		     $tmp->deletedRecordCount = $rs->fields["deleted_record_count"]; 
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
	public function updateData($user) {
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