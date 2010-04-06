<?php
/*
  Copyright (C) 2009 Burak Oguz (barfan) <findikmail@gmail.com>

  This program is free software; you can redistribute it and/or modify
  it under the terms of the GNU General Public License as published by
  the Free Software Foundation; either version 2 of the License, or
  (at your option) any later version.

  This program is distributed in the hope that it will be useful,
  but WITHOUT ANY WARRANTY; without even the implied warranty of
  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
  GNU General Public License for more details.

  You should have received a copy of the GNU General Public License
  along with this program; if not, write to the Free Software
  Foundation, Inc., 675 Mass Ave, Cambridge, MA 02139, USA.
*/
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
		     $tmp->updateUrl = $rs->fields["update_url"]; 
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