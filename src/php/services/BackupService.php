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