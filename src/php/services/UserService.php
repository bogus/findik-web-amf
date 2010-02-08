<?php
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