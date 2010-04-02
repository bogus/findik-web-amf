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
require_once('beans/VOMimeType.php');
require_once('db.php');

class MimeTypeService {

	public function getData($searchKey = null) {
	     //connect to the database.
	     $DB = connect_db(false); 
	     //retrieve all rows
	     $sql = "SELECT * FROM mime_type ";
	     if($searchKey != null)
	     	$sql .= " WHERE file_ext LIKE '%".$searchKey."%' OR mime_type LIKE '%".$searchKey."%'";
	     $sql .= " ORDER BY file_ext";
	     $rs = $DB->Execute($sql);
	     $ret = array();
	     while (!$rs->EOF) {
		     $tmp = new VOMimeType();
		     $tmp->id = $rs->fields["id"];
		     $tmp->fileExt = $rs->fields["file_ext"];
		     $tmp->mimeType = $rs->fields["mime_type"]; 
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
	     $sql = "UPDATE mime_type SET file_ext=?, mime_type=? WHERE id =?";
	     $DB->execute($sql, array($obj->fileExt, $obj->mimeType, $obj->id));
	     close_db($DB);
	     return NULL;
	}
	public function insertData($obj) {
		if ($obj == NULL)
		     return NULL;
	     //connect to the database.
	     $DB = connect_db(false);
	     //save changes
	     $sql = "insert into mime_type values ('',?,?)"; 
	     $DB->execute($sql, array($obj->fileExt, $obj->mimeType));
	     return NULL;
	}
	public function deleteData($obj) {
		if ($obj == NULL)
		     return NULL;
	     //connect to the database.
	     $DB = connect_db(false);
	     //save changes
	     $sql = "DELETE FROM mime_type WHERE id=?";
	     $DB->execute($sql, array($obj->id));
	     $sql = "DELETE FROM mime_type_cross WHERE mime_type_id=?";
	     $DB->execute($sql, array($obj->id));
	     close_db($DB);
	     return NULL;
	}
	
	public function getSearchCount($searchKey) {
		if ($searchKey == NULL)
			return 0;
		$DB = connect_db(false);
	     //save changes
	    $sql = "SELECT COUNT(*) as searchCount FROM mime_type ";
	    $sql .=  " WHERE file_ext LIKE '%?%' OR mime_type LIKE '%?%'";
		$rs = $DB->execute($sql, array($searchKey));
		return $rs->fields["searchCount"];
	}
}
?>
