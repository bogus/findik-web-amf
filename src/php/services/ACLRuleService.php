<?php
require_once('beans/VOACLRule.php');
require_once('db.php');

class ACLRuleService {

	public function getData($searchKey = null) {
	     //connect to the database.
	     $DB = connect_db(false); 
	     //retrieve all rows
	     $sql = "SELECT ar.*,afp.param as av from acl_rule ar, acl_filter_param afp where ";
	     $sql .= " afp.rule_id = ar.id and  afp.filter_key = 'av'";
	     $sql .= " ORDER BY rank";
	     $rs = $DB->Execute($sql);
	     $ret = array();
	     while (!$rs->EOF) {
		     $tmp = new VOACLRule();
		     $tmp->id = $rs->fields["id"];
		     $tmp->name = $rs->fields["name"];
		     $tmp->desc = $rs->fields["desc"];
		     $tmp->rank = $rs->fields["rank"];
		     $tmp->deny = $rs->fields["deny"]; 
		     $tmp->av = $rs->fields["av"];
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
	     $sql = "UPDATE acl_rule SET name=?,`desc`=?,rank=?,deny=? WHERE id =?";
	     $DB->execute($sql, array($obj->name,$obj->desc,$obj->rank,$obj->deny,$obj->id));
	     $sql = "UPDATE acl_filter_param SET param=? WHERE rule_id =? and filter_key='av'";
	     $DB->execute($sql, array($obj->av,$obj->id));
	     close_db($DB);
	     return NULL;
	}
	
	public function insertData($obj) {
		if ($obj == NULL)
		     return NULL;
	     //connect to the database.
	     $DB = connect_db(false);
	     //save changes
	     $DB->execute("update acl_rule set rank = rank + 1");
	     $sql = "insert into acl_rule values ('',?,?,?,?)"; 
	     $DB->execute($sql, array($obj->rank,$obj->deny,$obj->name,$obj->desc));
		 $sql = "select id from acl_rule where name = '".$obj->name."' and rank=".$obj->rank;
		 $rs = $DB->Execute($sql);
	     $sql = "insert into acl_filter_param values ('',?,?,?)";
	     $DB->execute($sql, array($rs->fields["id"],"av",0));
	     return NULL;
	}
	
	public function deleteData($obj) {
		if ($obj == NULL)
		     return NULL;
	     //connect to the database.
	     $DB = connect_db(false);
	     //save changes
	     $sql = "DELETE FROM acl_rule WHERE id=?";
	     $DB->execute($sql, array($obj->id));
	     $sql = "DELETE FROM acl_filter_param WHERE rule_id=?";
	     $DB->execute($sql, array($obj->id));
	     $sql = "update acl_rule set rank = rank - 1 where rank > ?";
	     $DB->execute($sql, array($obj->rank));
	     close_db($DB);
	     return NULL;
	}
	
	public function getSearchCount($searchKey) {
	}
	
	public function updateRank($obj, $rank) {
		if ($obj == NULL)
		     return NULL;
	     //connect to the database.
	     $DB = connect_db(false);
	     if($rank > $obj->rank) {
	     	$sql = "update acl_rule set rank = rank - 1 where rank > ? and rank <= ?";
	     	$DB->execute($sql, array($obj->rank, $rank));
	     } else {
	     	$sql = "update acl_rule set rank = rank + 1 where rank >= ? and rank < ?";
	     	$DB->execute($sql, array($rank, $obj->rank));
	     }
	     
	     $sql = "update acl_rule set rank = ? where id = ?";
	     $DB->execute($sql, array($rank, $obj->id));
	     close_db($DB);
	}
}
?>
