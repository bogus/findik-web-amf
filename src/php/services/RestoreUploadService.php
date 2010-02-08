<?php
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