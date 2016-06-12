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

  $sql  = 'SELECT';
  $sql .= ' SUM(value) sum, emotion, far.cid, course_name, s.level_2_id, s.level_2_name';
  $sql .= ' FROM';
  $sql .= ' recomm_analyzer_result AS far';
  $sql .= ' LEFT JOIN';
  $sql .= ' (SELECT level_2_id, cid, course_name FROM course) AS c';
  $sql .= ' ON c.cid = far.cid';
  $sql .= ' LEFT JOIN';
  $sql .= ' (SELECT level_2_id, level_2_name FROM status) AS s';
  $sql .= ' ON s.level_2_id = c.c.level_2_id';
  $sql .= ' GROUP BY emotion, far.cid, course_name, level_2_id, level_2_name';
  $sql .= ' ORDER BY cid ASC,';
  $sql .= ' level_2_id ASC;';

  $ret = mysql_query($sql);
  $retArray = array();
  while ($row = mysql_fetch_array($ret, MYSQL_ASSOC)) {
      array_push($retArray, $row);
  }

  print json_encode($retArray);

  mysql_close($con);
?>
