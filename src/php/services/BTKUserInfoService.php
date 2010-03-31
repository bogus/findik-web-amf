<?php
include_once('beans/VOBTKUserInfo.php');
include_once('db.php');

class BTKUserInfoService {

	/**
	* Retrieve all the records from the table
	* @return an array of VOTimeline
	*/
	public function getData($searchKey=null) {
	     //connect to the database.
	     $DB = connect_db(false);
	     //retrieve all rows
	     $rs = $DB->Execute("SELECT * FROM btk_user_info");
	     $ret = array();
	     while (!$rs->EOF) {
		     $tmp = new VOBTKUserInfo();
		     $tmp->tsUsername = $rs->fields["ts_username"];
		     $tmp->tsPassword = $rs->fields["ts_password"]; 
		     $tmp->regUsername = $rs->fields["reg_username"];
		     $tmp->regPassword = $rs->fields["reg_password"]; 
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
		if ($obj == NULL)
		     return NULL;
	     //connect to the database.
	     $DB = connect_db(false);
	     //save changes
	     $sql = "UPDATE btk_user_info SET ts_username='".$obj->tsUsername."', ts_password='".$obj->tsPassword."',reg_username='".$obj->regUsername."', reg_password='".$obj->regPassword."'";
	     $DB->execute($sql);
	     close_db($DB);
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
	
	public function testUserInfo($user) {
		return NULL;
	}
}
?>