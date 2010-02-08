<?php
require_once('beans/VOACLFilterParam.php');
require_once('db.php');

class ACLFilterParamService {

	public function getData($filterKey, $ruleId) {
	     //connect to the database.
	     $DB = connect_db(false); 
	     //retrieve all rows
	     $sql = "";
	     if($filterKey == "content") {
		     $sql = "SELECT afp.id as id, afp.rule_id as ruleId, afp.filter_key as filterKey, "; 
		     $sql .= "afp.param as param, c.name as name "; 
		     $sql .= "from acl_filter_param afp, category c ";
		     $sql .= " WHERE afp.param = c.id and afp.filter_key = '".$filterKey."' and afp.rule_id =".$ruleId;
	     } else if($filterKey == "filetype") {
	         $sql = "SELECT afp.id as id, afp.rule_id as ruleId, afp.filter_key as filterKey, "; 
		     $sql .= "afp.param as param, m.name as name "; 
		     $sql .= "from acl_filter_param afp, mime_type_group m ";
		     $sql .= " WHERE afp.param = m.id and afp.filter_key = '".$filterKey."' and afp.rule_id =".$ruleId;
	     } else if($filterKey == "iptable") {
	     	 $sql = "SELECT afp.id as id, afp.rule_id as ruleId, 'iptable' as filterKey, "; 
		     $sql .= "afp.acl_id as param, i.name as name "; 
		     $sql .= "from acl_ip_cross afp, ip_table i ";
		     $sql .= " WHERE afp.acl_id = i.id and afp.rule_id =".$ruleId;
	     } else if($filterKey == "timetable") {
	     	 $sql = "SELECT afp.id as id, afp.rule_id as ruleId, 'timetable' as filterKey, "; 
		     $sql .= "afp.acl_id as param, t.name as name "; 
		     $sql .= "from acl_time_cross afp, time_table t ";
		     $sql .= " WHERE afp.acl_id = t.id and afp.rule_id =".$ruleId;
	     }
	     $rs = $DB->Execute($sql);
	     $ret = array();
	     while (!$rs->EOF) {
		     $tmp = new VOACLFilterParam();
		     $tmp->id = $rs->fields["id"];
		     $tmp->name = $rs->fields["name"];
		     $tmp->ruleId = $rs->fields["ruleId"];
		     $tmp->filterKey = $rs->fields["filterKey"];
		     $tmp->param = $rs->fields["param"]; 
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
	     if($obj->filterKey == 'content' || $obj->filterKey == 'filetype') {
		     $sql = "insert into acl_filter_param values ('',?,?,?)"; 
		     $DB->execute($sql, array($obj->ruleId,$obj->filterKey,$obj->param));
	     } else if($obj->filterKey == 'iptable') {
	     	$sql = "insert into acl_ip_cross values ('',?,?)";
	     	$DB->execute($sql, array($obj->ruleId,$obj->param));
	     } else if($obj->filterKey == 'timetable') {
	     	$sql = "insert into acl_time_cross values ('',?,?)";
	     	$DB->execute($sql, array($obj->ruleId,$obj->param));
	     }
	     return NULL;
	}
	
	public function deleteData($obj) {
		if ($obj == NULL)
		     return NULL;
	     //connect to the database.
	     $DB = connect_db(false);
	     //save changes
	     $sql = "";
	     if($obj->filterKey == 'content' || $obj->filterKey == 'filetype') {
		    $sql = "DELETE FROM acl_filter_param WHERE id=?";
	     } else if($obj->filterKey == 'iptable') {
	     	$sql = "DELETE FROM acl_ip_cross WHERE id=?";
	     } else if($obj->filterKey == 'timetable') {
	     	$sql = "DELETE FROM acl_time_cross WHERE id=?";
	     }
	     $DB->execute($sql, array($obj->id));
	     close_db($DB);
	     return NULL;
	}
	
	public function getSearchCount($searchKey) {
	}
}
?>
