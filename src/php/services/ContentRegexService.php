<?php
require_once('beans/VOContentCategory.php');
require_once('beans/VOContentDomain.php');
require_once('beans/VOContentRegex.php');
require_once('beans/VOContentURL.php');
require_once('beans/VOContentSearch.php');
require_once('db.php');

class ContentRegexService {

	public function getData($catid, $start, $count, $searchKey = null) {
	     //connect to the database.
	     $DB = connect_db(false);
	     //retrieve all rows
	     $sql = "";
	     $rs;
	     if($searchKey == null) {
	     	$sql = "SELECT * FROM content WHERE catid=? LIMIT ".$start.",".$count;
	     	$rs = $DB->Execute($sql, array($catid));
	     } else {
	     	$sql = "SELECT * FROM content WHERE content LIKE '%".$searchKey."%' ";
	     	if($catid != 0)
	     		$sql .=" and catid=".$catid;
	     	$sql .=" LIMIT ".$start.",".$count;
	     	$rs = $DB->Execute($sql);
	     }
	     $ret = array();
	     while (!$rs->EOF) {
		     $tmp = new VOContentRegex();
		     $tmp->id = $rs->fields["id"];
		     $tmp->regex = $rs->fields["content"]; 
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
	     $sql = "UPDATE content SET content=? WHERE id =?";
	     $DB->execute($sql, array($obj->content,$obj->id));
	     close_db($DB);
	     return NULL;
	}

	public function insertData($obj) {
		if ($obj == NULL)
		     return NULL;
	     //connect to the database.
	     $DB = connect_db(false);
	     //save changes
	     $sql = "insert into content values ('',?,?)"; 
	     $DB->execute($sql, array($obj->regex,$obj->catId));
	     return NULL;
	}
	
	public function deleteData($obj) {
		if ($obj == NULL)
		     return NULL;
	     //connect to the database.
	     $DB = connect_db(false);
	     //save changes
	     $sql = "DELETE FROM content WHERE id=?";
	     $DB->execute($sql, array($obj->id));
	     close_db($DB);
	     return NULL;
	}
	
	public function getSearchCount($searchKey, $catId) {
		if ($searchKey == NULL)
			return 0;
		$DB = connect_db(false);
	     //save changes
	    $sql = "SELECT COUNT(*) as searchCount FROM content WHERE content LIKE '%".$searchKey."%' ";
     	if($catid != 0)
     		$sql .=" and catid=".$catid;
		$rs = $DB->execute($sql);
		return $rs->fields["searchCount"];
		
	}
}
?>
