<?php
  // 这一接口负责取每个课程子分类下的观看人数前五的课程信息， 以json格式向前台返回

  // 允许跨域
  header("Access-Control-Allow-Origin: *");


  $host = 'localhost'; //mysql主机
  $user = 'root'; // mysql用户名
  $pass = 'testing'; // mysql密码
  $dbName = 'test'; // mysql的schema名（当前数据库名）


  $con = mysql_connect($host, $user, $pass);
  if (!$con) {
	    die('Could not connect: ' . mysql_error());
  }

  // 连接数据库指定的schema
  mysql_select_db($dbName, $con);
  mysql_query("SET NAMES UTF8");

  $sql  = 'SELECT ';
  $sql .= 's.level_1_id,';
  $sql .= 's.level_1_name,';
  $sql .= 'main.level_2_id,';
  $sql .= 's.level_2_name,';
  $sql .= 'main.course_name,';
  $sql .= 'main.learner_count';
  $sql .= ' FROM course AS main';
  $sql .= ' LEFT JOIN';
  $sql .= ' (SELECT level_1_id, level_1_name, level_2_id, level_2_name FROM status) AS s';
  $sql .= ' ON main.level_2_id = s.level_2_id';
  $sql .= ' WHERE (SELECT COUNT(1) FROM course AS sub WHERE main.level_2_id =
		  sub.level_2_id AND main.learner_count < sub.learner_count) < 5';
  $sql .= ' ORDER BY level_2_id ASC, learner_count DESC;';

  // 执行sql语句
  $ret = mysql_query($sql);

  // 最终的结果是一个数组
  $retArray = array();
  while ($row = mysql_fetch_array($ret, MYSQL_ASSOC)) {
      // 向结果数组中追加这一数据行
      array_push($retArray, $row);
  }

  // 输出json格式的数据
  print json_encode($retArray);

  mysql_close($con);
?>
