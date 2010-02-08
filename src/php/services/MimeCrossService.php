<?php
require_once('beans/VOMimeCross.php');
require_once('db.php');

class MimeCrossService {

	public function getData($groupid, $searchKey=null) {
	     //connect to the database.
	     $DB = connect_db(false);
	     //retrieve all rows
	     $sql = "SELECT mc.*,(SELECT m.file_ext FROM mime_type m WHERE m.id = mc.mime_type_id) as file_ext, ";
	     $sql .= " (SELECT m.mime_type FROM mime_type m WHERE m.id = mc.mime_type_id) as mime_type "; 
	     $sql .= " FROM mime_type_cross mc";
	     $sql .= " WHERE mime_group_id=?";
	     $rs = $DB->Execute($sql, array($groupid));
	     $ret = array();
	     while (!$rs->EOF) {
		     $tmp = new VOMimeCross();
		     $tmp->id = $rs->fields["id"];
		     $tmp->fileExt = $rs->fields["file_ext"]; 
		     $tmp->mimeType = $rs->fields["mime_type"];
		     $tmp->mimeTypeId = $rs->fields["mime_type_id"];  
		     $tmp->groupId = $rs->fields["mime_group_id"];
		     $ret[] = $tmp;
		     $rs->MoveNext();
	     }
	     close_db($DB);
	     return $ret;
	}
	
	public function updateData($obj) {
	}

	public function insertData($obj) {
		if ($obj == NULL)
		     return NULL;
	     //connect to the database.
	     $DB = connect_db(false);
	     //save changes
	     $sql = "insert into mime_type_cross values ('',?,?)"; 
	     $DB->execute($sql, array($obj->groupId,$obj->mimeTypeId));
	     return NULL;
	}

	public function deleteData($obj) {
		if ($obj == NULL)
		     return NULL;
	     //connect to the database.
	     $DB = connect_db(false);
	     //save changes
	     $sql = "DELETE FROM mime_type_cross WHERE id=?";
	     $DB->execute($sql, array($obj->id));
	     close_db($DB);
	     return NULL;
	}
	
	public function getSearchCount($searchKey, $catId) {
		
	}
}
?>
