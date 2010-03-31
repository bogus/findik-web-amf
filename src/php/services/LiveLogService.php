<?php
include_once('beans/VOLog.php');
include_once('tail.php');

class LiveLogService {

	/**
	* Retrieve last 100 lines of log from /var/findik/filter.log
	* @return an array of VOLog
	*/
	public function getData($searchKey=null) {
	     $lines = get_lines();
	     $ret = array();
	     foreach($lines as $line) {
		     $tmp = new VOLog();
		     $logInfo = explode(" ", $line);
		     if($logInfo[2] == "WARN") {
		     	 $tmp->date = $logInfo[0];
			     $tmp->time = $logInfo[1];
			     list($x, $tmp->result) = explode(":",$logInfo[5]);
			     list($x, $tmp->localAddr) = explode(":",$logInfo[6]);
			     list($x, $tmp->domain) = explode(":",$logInfo[7]);
			     list($x, $tmp->url) = explode(":",$logInfo[8],2);
			     list($x, $tmp->reqSize) = explode(":",$logInfo[9]);
			     list($x, $tmp->respSize) = explode(":",$logInfo[10]);
		     } else {
		     	 $tmp->date = $logInfo[0];
			     $tmp->time = $logInfo[1];
			     list($x, $tmp->result) = explode(":",$logInfo[4]);
			     list($x, $tmp->localAddr) = explode(":",$logInfo[5]);
			     list($x, $tmp->domain) = explode(":",$logInfo[6]);
			     list($x, $tmp->url) = explode(":",$logInfo[7],2);
			     list($x, $tmp->reqSize) = explode(":",$logInfo[8]);
			     list($x, $tmp->respSize) = explode(":",$logInfo[9]);
		     }
		     $ret[] = $tmp;
	     }
	     return array_reverse($ret);
	}
}
?>