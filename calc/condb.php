<?php
define('DBHOST', 'localhost'); 
define('DBNAME', 'karkas'); 
define('DBUSER', 'karkas'); 
define('DBPASS', 'QCqgSBs2'); 
$dbcnx = @mysql_connect(DBHOST,DBUSER,DBPASS);
mysql_query("SET NAMES 'cp1251'");
mysql_query("/*!40101 SET NAMES 'cp1251' */") or die("Error: " . mysql_error());
if (!$dbcnx){
echo "<p> Нет соединения с Базой Данных</p>";
exit();
}
if (!@mysql_select_db(DBNAME, $dbcnx)){
echo"<p> все нормально </p>";
exit();
}

define('PREFIX', 'calc_');
?>