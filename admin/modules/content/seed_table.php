<?php
require_once("../../../include/initialize.php");
global $mydb;
$mydb->setQuery("CREATE TABLE IF NOT EXISTS tblcontent (
  ContentID INT AUTO_INCREMENT PRIMARY KEY,
  Title VARCHAR(255) NOT NULL,
  Topic VARCHAR(255) DEFAULT '',
  Body MEDIUMTEXT NOT NULL,
  CreatedAt DATETIME NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4");
$ok = $mydb->executeQuery();
echo $ok ? 'OK' : 'FAIL';
?>


