<?php
require_once('beans/VOBackupFile.php');
require_once('db.php');

class BackupService {

	public function getData() {
		$dir = getcwd().'/tmp/';
     	$ret = array();
		if($handle = opendir($dir)) {
     		while (false !== ($object = readdir($handle))) {
      			if(!in_array($object,array('.','..'))) {
     				$filename = $dir.$object;
				    $tmp = new VOBackupFile();
				    $tmp->filename = substr($filename, strlen($dir));
				    $tmp->size = filesize($filename);
				    $tmp->date = date("d.m.Y H:i:s", filemtime($filename));
     				$ret[] = $tmp;
     			}
     		}
			closedir($handle);
		}
     	return $ret;
	}

	public function insertData($obj) {
     	$backupFile = getcwd()."/tmp/findik-backup-".date("Y-m-d").".gz";
		$command = $GLOBALS['mysqldump']." --opt -h ".$GLOBALS['DB_HOST']." -u ".$GLOBALS['DB_USER'];
		$command .= " --databases ".$GLOBALS['DB_DBNAME']." --password=".$GLOBALS['DB_PASSWORD']." > ".$backupFile;
		system($command);
	}

	public function deleteData($obj) {
		$dir = getcwd().'/tmp/';
		unlink($dir.$obj->filename);
     	return NULL;
	}

	public function updateData($obj) {
     	return NULL;
	}
}
?>