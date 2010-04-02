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

class ContentCategoryService {

	public function getData($searchKey = null) {
	     //connect to the database.
	     $DB = connect_db(false); 
	     //retrieve all rows
	     $sql = "SELECT c.id as id, c.name as name, cc.domain_count as domain_count, ";
	     $sql .= "cc.url_count as url_count, cc.content_count as content_count ";
	     $sql .= "FROM category c, category_count cc WHERE c.id = cc.id ";
	     if($searchKey != null)
	     	$sql .= " and c.name LIKE '%".$searchKey."%' ";
	     $sql .= "ORDER BY c.name";
	     $rs = $DB->Execute($sql);
	     $ret = array();
	     while (!$rs->EOF) {
		     $tmp = new VOContentCategory();
		     $tmp->id = $rs->fields["id"];
		     $tmp->name = $rs->fields["name"];
		     $tmp->domainCount = $rs->fields["domain_count"];
		     $tmp->urlCount = $rs->fields["url_count"];
		     $tmp->regexCount = $rs->fields["content_count"]; 
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
	     $sql = "UPDATE category SET name=? WHERE id =?";
	     $DB->execute($sql, array($obj->name,$obj->id));
	     close_db($DB);
	     return NULL;
	}
	public function insertData($obj) {
		if ($obj == NULL)
		     return NULL;
	     //connect to the database.
	     $DB = connect_db(false);
	     //save changes
	     $sql = "insert into category values ('',?)"; 
	     $DB->execute($sql, array($obj->name));
	     return NULL;
	}
	public function deleteData($obj) {
		if ($obj == NULL)
		     return NULL;
	     //connect to the database.
	     $DB = connect_db(false);
	     //save changes
	     $sql = "DELETE FROM category WHERE id=?";
	     $DB->execute($sql, array($obj->id));
	     close_db($DB);
	     return NULL;
	}
	
	public function getSearchCount($searchKey) {
		if ($searchKey == NULL)
			return 0;
		$DB = connect_db(false);
	     //save changes
	    $sql = "SELECT COUNT(*) as searchCount FROM category WHERE name LIKE '%?%' ";
		$rs = $DB->execute($sql, array($searchKey));
		return $rs->fields["searchCount"];
	}
}
?>
