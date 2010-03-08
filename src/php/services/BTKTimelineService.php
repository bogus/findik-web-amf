<?php
include_once('beans/VOTimeline.php');
include_once('db.php');

class BTKTimelineService {

	/**
	* Retrieve all the records from the table
	* @return an array of VOTimeline
	*/
	public function getData($searchKey=null) {
	     //connect to the database.
	     $DB = connect_db(false);
	     //retrieve all rows
	     $rs = $DB->Execute("SELECT * FROM service_status ORDER BY id");
	     $ret = array();
	     while (!$rs->EOF) {
		     $tmp = new VOTimeline();
		     $tmp->id = $rs->fields["id"];
		     $tmp->startDate = $rs->fields["start_date"]; 
		     $tmp->endDate = $rs->fields["end_date"];
		     $tmp->status = $rs->fields["status"];
		     $tmp->label = $rs->fields["status"]; 
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