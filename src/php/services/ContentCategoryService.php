<?php
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
