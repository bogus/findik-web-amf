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
include('db.php');
include('../config.php.inc');

$DB = connect_db(false);
error_log($_FILES['Filedata']['tmp_name']);
error_log("../tmp/".$_FILES['Filedata']['name']);
if ($_FILES['Filedata']['size'] > 0)
{
    move_uploaded_file($_FILES['Filedata']['tmp_name'], "../tmp/".$_FILES['Filedata']['name']);
}

close_db($DB);

?>