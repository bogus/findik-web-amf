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
	include('adodb5/adodb.inc.php');
	require_once('Zend/Amf/Server.php');
	require_once('services/db.php');
	require_once('services/UserService.php');
	require_once('services/IPTableService.php');
	require_once('services/TimeTableService.php');
	require_once('services/ContentCategoryService.php');
	require_once('services/ContentDomainService.php'); 
	require_once('services/ContentURLService.php');
	require_once('services/ContentRegexService.php');
	require_once('services/MimeTypeService.php');
	require_once('services/MimeTypeGroupService.php');
	require_once('services/MimeCrossService.php');
	require_once('services/ACLRuleService.php');
	require_once('services/ACLFilterParamService.php');
	require_once('services/BackupService.php');
	require_once('services/LiveLogService.php');
	require_once('services/BTKTimelineService.php');
	require_once('services/BTKDbUpdateService.php');
	require_once('services/BTKTimestampHistoryService.php');
	require_once('services/BTKUserInfoService.php');
	require_once('services/BTKGeneralInfoService.php');

	$server = new Zend_Amf_Server();
	
	//adding our class to Zend AMF Server
	$server->setClass("UserService")
			->setClass("IPTableService")
			->setClass("TimeTableService")
			->setClass("ContentCategoryService")
			->setClass("ContentDomainService")
			->setClass("ContentURLService")
			->setClass("ContentRegexService")
			->setClass("MimeTypeService")
			->setClass("MimeTypeGroupService")
			->setClass("MimeCrossService")
			->setClass("ACLRuleService")
			->setClass("ACLFilterParamService")
			->setClass("BackupService")
			->setClass("LiveLogService")
			->setClass("BTKTimelineService")
			->setClass("BTKDbUpdateService")
			->setClass("BTKTimestampHistoryService")
			->setClass("BTKUserInfoService")
			->setClass("BTKGeneralInfoService");
			
	//Mapping the ActionScript VO to the PHP VO
	//you don't have to add the package name
	$server->setClassMap("VOUser", "VOUser");
	$server->setClassMap("VOIPTable", "VOIPTable");
	$server->setClassMap("VOTimeTable", "VOTimeTable");
	$server->setClassMap("VOContentCategory", "VOContentCategory");
	$server->setClassMap("VOContentDomain", "VOContentDomain");
	$server->setClassMap("VOContentURL", "VOContentURL");
	$server->setClassMap("VOContentRegex", "VOContentRegex");
	$server->setClassMap("VOACLRule", "VOACLRule");
	
	echo($server -> handle());
?>
