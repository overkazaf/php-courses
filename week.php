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

  $sqlFetchIds = 'SELECT level_2_id FROM status';
  $result1 = mysql_query($sqlFetchIds);

  $ids = array();

  while ($row = mysql_fetch_assoc($result1)) {
    array_push($ids, $row['level_2_id']);
  }

  shuffle($ids);
  $tmp = array_slice($ids, 0, 6);
  $array_str = join(",", $tmp);

  $sql  = 'SELECT';
  $sql .= ' level_2_id, course_name, learner_count, last_modified';
  $sql .= ' FROM week_base';
  $sql .= ' WHERE level_2_id IN ('. $array_str .')';
  $sql .= ' LIMIT';
  $sql .= ' 200';
  // $sql  = 'SELECT';
  // $sql .= ' level_2_id, course_name, learner_count, last_modified';
  // $sql .= ' FROM update_log main';
  // $sql .= ' WHERE (SELECT count(1) FROM update_log AS sub';
  // $sql .= ' WHERE sub.level_2_id = main.level_2_id';
  // $sql .= ' AND main.learner_count < sub.learner_count) < 7';
  // $sql .= ' AND DATE_SUB(CURDATE(), INTERVAL 7 DAY) <= DATE(last_modified)';
  // $sql .= ' AND level_2_id IN ('.$array_str.')';
  // $sql .= ' ORDER BY level_2_id ASC,';
  // $sql .= ' learner_count DESC,';
  // $sql .= ' last_modified DESC';
  // $sql .= ' LIMIT 100';

  $ret = mysql_query($sql);

  $retArray = array();
  while ($row = mysql_fetch_array($ret, MYSQL_ASSOC)) {
      array_push($retArray, $row);
  }

  print json_encode($retArray);

  mysql_close($con);
?>
