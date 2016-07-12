<?php
  header("Access-Control-Allow-Origin: *");

  $host = 'localhost';
  $user = 'root';
  $pass = 'testing';
  $dbName = 'test';


  $con = mysql_connect($host, $user, $pass);
  if (!$con) {
	die('Could not connect: ' . mysql_error());
  }

  mysql_select_db($dbName, $con);
  mysql_query("SET NAMES UTF8");

  $sql  = 'SELECT ';
  $sql .= 'id, course_name, learner_count';
  $sql .= ' FROM course';
  $sql .= ' WHERE id IN (207,208,209,253, 254)';

  $ret = mysql_query($sql);

  $retArray = array();
  while ($row = mysql_fetch_array($ret, MYSQL_ASSOC)) {
      array_push($retArray, $row);
  }

  print json_encode($retArray);

  mysql_close($con);
?>
