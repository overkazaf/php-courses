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
  $sql .= 'u.course_name,';
  $sql .= 'u.learner_count';
  $sql .= ' FROM update_log AS u';
  $sql .= ' WHERE id IN (SELECT max(id) FROM update_log GROUP BY course_name)';
  $sql .= ' ORDER BY';
  $sql .= ' u.learner_count';
  $sql .= ' DESC';
  $sql .= ' LIMIT';
  $sql .= ' 5';

  $ret = mysql_query($sql);

  $retArray = array();
  while ($row = mysql_fetch_array($ret, MYSQL_ASSOC)) {
      array_push($retArray, $row);
  }

  print json_encode($retArray);

  mysql_close($con);
?>
