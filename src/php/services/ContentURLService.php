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
require_once('beans/VOContentCategory.php');
require_once('beans/VOContentDomain.php');
require_once('beans/VOContentRegex.php');
require_once('beans/VOContentURL.php');
require_once('beans/VOContentSearch.php');
require_once('db.php');

class ContentURLService {

	public function getData($catid, $start, $count, $searchKey = null) {
	     //connect to the database.
	     $DB = connect_db(false);
	     $sql = "";
	     $rs;
	     if($searchKey == null) {
	     	$sql = "SELECT * FROM url WHERE catid=? LIMIT ".$start.",".$count;
	     	$rs = $DB->Execute($sql, array($catid));	
	     } else {
	     	$sql = "SELECT * FROM url WHERE url LIKE '%".$searchKey."%' ";
	     	if($catid != 0)
	     		$sql .=" and catid=".$catid;
	     	$sql .=" LIMIT ".$start.",".$count;
	     	$rs = $DB->Execute($sql);
	     }	    
	     $ret = array();
	     while (!$rs->EOF) {
		     $tmp = new VOContentURL();
		     $tmp->id = $rs->fields["id"];
		     $tmp->url = $rs->fields["url"]; 
		     $tmp->catId = $rs->fields["catid"]; 
		     $ret[] = $tmp;
		     $rs->MoveNext();
	     }
	     close_db($DB);
	     return $ret;	
	}

	public function updateData($obj) {
		if ($obj == NULL)
		     return NULL;
	     //connect to the database.
	     $DB = connect_db(false);
	     //save changes
	     $sql = "UPDATE url SET url=? WHERE id =?";
	     $DB->execute($sql, array($obj->url,$obj->id));
	     close_db($DB);
	     return NULL;
	}

	public function insertData($obj) {
		if ($obj == NULL)
		     return NULL;
	     //connect to the database.
	     $DB = connect_db(false);
	     //save changes
	     $sql = "insert into url values ('',?,?)"; 
	     $DB->execute($sql, array($obj->url,$obj->catId));
	     return NULL;
	}

	public function deleteData($obj) {
		if ($obj == NULL)
		     return NULL;
	     //connect to the database.
	     $DB = connect_db(false);
	     //save changes
	     $sql = "DELETE FROM url WHERE id=?";
	     $DB->execute($sql, array($obj->id));
	     close_db($DB);
	     return NULL;
	}
	
	public function getSearchCount($searchKey, $catId) {
		if ($searchKey == NULL)
			return 0;
		$DB = connect_db(false);
	     //save changes
	    $sql = "SELECT COUNT(*) as searchCount FROM url WHERE url LIKE '%".$searchKey."%' ";
     	if($catid != 0)
     		$sql .=" and catid=".$catid;
		$rs = $DB->execute($sql);
		return $rs->fields["searchCount"];
		
	}
}
?>
