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
require_once('beans/VOTimeTable.php');
require_once('db.php');

class TimeTableService {

	/**
	* Retrieve all the records from the table
	* @return an array of VOTimeTable
	*/
	public function getData($searchKey=null) {
	     //connect to the database.
	     $DB = connect_db(false);
	     //retrieve all rows
	     $rs = $DB->Execute("SELECT * FROM time_table ORDER BY id");
	     $ret = array();
	     while (!$rs->EOF) {
		     $tmp = new VOTimeTable();
		     $tmp->id = $rs->fields["id"];
		     $tmp->name = $rs->fields["name"]; 
		     $tmp->startTime = $rs->fields["start_time"];
		     $tmp->endTime = $rs->fields["end_time"]; 
		     $tmp->dayOfWeek = $rs->fields["day_of_week"];
		     $ret[] = $tmp;
		     $rs->MoveNext();
	     }
	     close_db($DB);
	     return $ret;
	}
	
	/**
	* Update one item in the table
	* @param VOTimeTable to be updated 
	* @return NULL
	*/
	public function updateData($obj) {
		if ($obj == NULL)
		     return NULL;
	     //connect to the database.
	     $DB = connect_db(false);
	     //save changes
	     $sql = "UPDATE time_table SET name='".$obj->name."' WHERE id =".$obj->id;
	     $DB->execute($sql);
	     close_db($DB);
	     return NULL;
	}
	
	/**
	* Insert one item in the table
	* @param VOTimeTable to be inserted 
	* @return NULL
	*/
	public function insertData($obj) {
		if ($obj == NULL)
		     return NULL;
	     //connect to the database.
	     $DB = connect_db(false);
	     //save changes
	     $sql = "insert into time_table values ('',?,?,?,?)"; 
	     $DB->execute($sql, array($obj->name, $obj->startTime, $obj->endTime, $obj->dayOfWeek));
	     return NULL;
	}
	
	/**
	* Insert one item in the table
	* @param VOTimeTable to be updated 
	* @return NULL
	*/
	public function deleteData($obj) {
		if ($obj == NULL)
		     return NULL;
	     //connect to the database.
	     $DB = connect_db(false);
	     //save changes
	     $sql = "DELETE FROM time_table WHERE id=?";
	     $DB->execute($sql, array($obj->id));
	     close_db($DB);
	     return NULL;
	}
}
?>