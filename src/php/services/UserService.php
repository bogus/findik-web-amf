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
include_once('beans/VOUser.php');
include_once('db.php');

class UserService {

	/**
	* Retrieve all the records from the table
	* @return an array of VOUser
	*/
	public function getData($searchKey=null) {
	     //connect to the database.
	     $DB = connect_db(false);
	     //retrieve all rows
	     $rs = $DB->Execute("SELECT * FROM users ORDER BY username");
	     $ret = array();
	     while (!$rs->EOF) {
		     $tmp = new VOUser();
		     $tmp->id = $rs->fields["id"];
		     $tmp->username = $rs->fields["username"]; 
		     $tmp->password = $rs->fields["password"]; 
		     $ret[] = $tmp;
		     $rs->MoveNext();
	     }
	     return $ret;
	     close_db($DB);
	}
	
	/**
	* Update one item in the table
	* @param VOUser to be updated 
	* @return NULL
	*/
	public function updateData($user) {
		if ($user == NULL)
		     return NULL;
	     //connect to the database.
	     $DB = connect_db(false);
	     //save changes
	     $DB->execute("UPDATE users SET username='".$user->username."', password='".$user->password."' WHERE id = ".  $user->id);
	     return NULL;
	}
	
	/**
	* Insert one item in the table
	* @param VOUser to be updated 
	* @return NULL
	*/
	public function insertData($user) {
		if ($user == NULL)
		     return NULL;
	     //connect to the database.
	     $DB = connect_db(false);
	     //save changes
	     $DB->execute("INSERT INTO users VALUES ('','".$user->username."', '".sha1($user->password)."')");
	     return NULL;
	}
	
	/**
	* Insert one item in the table
	* @param VOUser to be updated 
	* @return NULL
	*/
	public function deleteData($user) {
		if ($user == NULL)
		     return NULL;
	     //connect to the database.
	     $DB = connect_db(false);
	     //save changes
	     $DB->execute("DELETE FROM users WHERE id='".$user->id."'");
	     return NULL;
	}

	public function checkLogin($username,$password) {
	     if ($username == NULL || $password == NULL)
		     return -1;
	     //connect to the database.
	     $DB = connect_db(false);
	     //save changes
	     $rs = $DB->execute("select id from users where username='".$username."' and password='".$password."' ");
	     while (!$rs->EOF) {
			return $rs->fields["id"];
	     }
	     return -1;
	}
}
?>