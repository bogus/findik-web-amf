<?php
require_once('beans/VOContentDomain.php');
require_once('beans/VOContentSearch.php');
require_once('db.php');

class ContentDomainService {

	public function getData($catid, $start, $count, $searchKey = null) {
	     //connect to the database.
	     $DB = connect_db(false);
	     //retrieve all rows
	     $sql = "";
	     $rs;
	     if($searchKey == null) {
	     	$sql = "SELECT * FROM domain WHERE catid=? LIMIT ".$start.",".$count;
	     	$rs = $DB->Execute($sql, array($catid));
	     }
	     else {
	     	$sql = "SELECT * FROM domain WHERE domain LIKE '%".$searchKey."%' ";
	     	if($catid != 0)
	     		$sql .=" and catid=".$catid;
	     	$sql .=" LIMIT ".$start.",".$count;
	     	$rs = $DB->Execute($sql);
	     }
	     $ret = array();
	     while (!$rs->EOF) {
		     $tmp = new VOContentDomain();
		     $tmp->id = $rs->fields["id"];
		     $tmp->domain = $rs->fields["domain"]; 
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
	     $sql = "UPDATE domain SET domain=? WHERE id =?";
	     $DB->execute($sql, array($obj->domain,$obj->id));
	     close_db($DB);
	     return NULL;
	}
	public function insertData($obj) {
		if ($obj == NULL)
		     return NULL;
	     //connect to the database.
	     $DB = connect_db(false);
	     //save changes
	     $sql = "insert into domain values ('',?,?)"; 
	     $DB->execute($sql, array($obj->domain,$obj->catId));
	     return NULL;
	}

	public function deleteData($obj) {
		if ($obj == NULL)
		     return NULL;
	     //connect to the database.
	     $DB = connect_db(false);
	     //save changes
	     $sql = "DELETE FROM domain WHERE id=?";
	     $DB->execute($sql, array($obj->id));
	     close_db($DB);
	     return NULL;
	}
	
	public function getSearchCount($searchKey, $catId) {
		if ($searchKey == NULL)
			return 0;
		$DB = connect_db(false);
	     //save changes
	    $sql = "SELECT COUNT(*) as searchCount FROM domain WHERE domain LIKE '%".$searchKey."%' ";
     	if($catid != 0)
     		$sql .=" and catid=".$catid;
		$rs = $DB->execute($sql);
		return $rs->fields["searchCount"];
	}
}
?>
