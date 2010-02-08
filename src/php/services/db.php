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
set_include_path(get_include_path() . PATH_SEPARATOR . getcwd());
include('adodb5/adodb.inc.php');
include('config.php.inc');
session_start();

function connect_db($check_session) {

	if($check_session == true) {
		if(isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] == "true") {
			$DB = NewADOConnection('mysql');
			$DB->Connect($DB_HOST, $DB_USER, $DB_PASSWORD, $DB_DBNAME);
			$_SESSION["db_conn"] = $DB;
			return $DB;
		}
	} else {
		$DB = NewADOConnection('mysql');
		$DB->Connect($GLOBALS['DB_HOST'], $GLOBALS['DB_USER'], $GLOBALS['DB_PASSWORD'], $GLOBALS['DB_DBNAME']);
		return $DB;
	}
	
	return null;
}

function close_db($DB) {
	$DB->Disconnect();
}

function close_all() {
	session_unset(); 
	session_destroy();	
}
 
?>