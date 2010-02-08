<?php
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
