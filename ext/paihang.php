<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>评价平台</title>
<!-- <link href="bootstrap-3.3.5-dist/css/bootstrap.min.css" rel="stylesheet" type="text/css">
<script src="bootstrap-3.3.5-dist/js/jquery-2.2.2.min.js"></script>
<script src="bootstrap-3.3.5-dist/js/bootstrap.min.js"></script> -->
<link href="../node_modules/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet" type="text/css">
<script src="../node_modules/jquery/dist/jquery.min.js"></script>
<script src="../node_modules/bootstrap/dist/js/bootstrap.min.js"></script>

</head>

<body style=" background-image:url(img/338856.jpg); background-color:#222;background-repeat:no-repeat; background-size:cover">
<nav class="nav navbar-default" role="navigation" style="background-color:#000">
      <div class="container-fluid">
         <div class="navbar-header">
            <button class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
            <span class="icon-bar"></span>
              <span class="icon-bar"></span>
              <span class="icon-bar"></span>
          </button>
         </div>
           <div class="collapse navbar-collapse">
             <nav class="nav navbar-default" role="navigation">
      <div class="container-fluid">
        <div class="collapse navbar-collapse">
          <form class="form-horizontal">
          <div class="form-group">
                      <li class="dropdown" style="width:180px;float:left">
                        <a href="./pingjia.php">首页</a>
                        </li>
                        <li class="dropdown" style="width:180px;float:left">
                        <a href="#">联系我们</a>
                        </li>
                        <li class="dropdown" style="width:180px;float:left">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown">平台简评</a>
                        <ul class="dropdown-menu" >
                              <li><a href="#">12312asdade12e</a></li>
                         </ul>
                         </li>
            </div>
        </form>
        </div>  
    </div>
    </nav>
            <div class="navbar-form navbar-right">
               <input type="text" class="form-control" placeholder="课程名称/讲师/用户ID"/>
                 <button class="btn btn-primary">搜 索</button>
            </div>
          </div>
        </div>
 </nav>
   <nav class="navbar navbar-default" role="navigation">
   <div class="navbar-header">
      <button type="button" class="navbar-toggle" data-toggle="collapse" 
         data-target="#example-navbar-collapse">
         <span class="sr-only">切换导航</span>
         <span class="icon-bar"></span>
         <span class="icon-bar"></span>
         <span class="icon-bar"></span>
      </button>
      
   </div>
   <div class="collapse navbar-collapse" id="example-navbar-collapse">
      <ul class="nav navbar-nav">
         <li><a  href="./kecheng.php">课程列表</a></li>
         <li class="active"><a href="./paihang.php">多样排行</a></li>
         <li ><a href="./jianping.php">平台简评</a></li>
      </ul>
   </div>
</nav>
  <div class="container-fluid">
          <div class="navbar-form navbar-right">
               <input type="text" class="form-control" placeholder="点击量/评论数/评价值"/>
                 <button class="btn btn-primary" style="">搜 索</button>
            </div>
    </div>
  <div class="container-fluid" style="margin-left:120px;">
        <div class="row">
        <?php
  $host='localhost';
  $user='root';
  $pass='testing';
  $db='test';
  $conn=mysqli_connect($host,$user,$pass);
  if(!$conn){ echo lianjieshibai; exit;}
  mysqli_select_db($conn,$db);
  $sql1="set names utf8";
  mysqli_query($conn,$sql1);
  //$sql8="DELETE FROM `comments_count`";
  //mysqli_query($conn,$sql8);
  //$sql7="INSERT INTO `comments_count`(`cid`, `course_name`, `comments_count`) SELECT `cid`,`course_name`,count(*) FROM `comments` GROUP BY `cid`,`course_name`";
  //mysqli_query($conn,$sql7);
  $sql = "SELECT * FROM `course` ORDER BY learner_count DESC";
  $sql2 = "SELECT * FROM `comments_count` ORDER BY comments_count DESC";
  $result=mysqli_query($conn,$sql);
  $result1=mysqli_query($conn,$sql2);
  $count="SELECT count(*) FROM `course`";
   //获得记录总数
  $result1=mysqli_query($conn,$count);
  $rs=mysqli_fetch_array($result1); 
  $perNumber=5;
  if(isset($_GET['page']) && !empty($_GET['page'])){
    $page=$_GET['page'];
  }else{
    $page=1;
    }
  if(isset($_GET['page1']) && !empty($_GET['page1'])){
    $page1=$_GET['page1'];
  }else{
    $page1=1;
    }
    if(isset($_GET['page2']) && !empty($_GET['page2'])){
    $page2=$_GET['page2'];
  }else{
    $page2=1;
    }
  $count1=($page-1)*5+1;
  $count2=($page1-1)*5+1;
  $count3=($page2-1)*5+1;
  $totalNumber=$rs[0];
  $totalPage=ceil($totalNumber/$perNumber); //计算出总页数
  if (!isset($page)) {
   $page=1;
  } //如果没有值,则赋值1
  $startCount = ($page-1)*$perNumber;
  $startCount1 = ($page1-1)*$perNumber;
  $startCount2= ($page2-1)*$perNumber;
  $sql3="SELECT * FROM `course` ORDER BY learner_count DESC LIMIT $startCount,$perNumber";
  $sql4="SELECT * FROM `comments_count` ORDER BY comments_count DESC LIMIT $startCount1,$perNumber";
  $sql5="SELECT cc.level_2_id, c.level_2_name, SUM(comments_count) AS comments_count FROM comments_count cc LEFT JOIN (SELECT c.level_2_id, c.level_2_name FROM status c) as c ON cc.level_2_id = c.level_2_id WHERE cc.level_2_id IS NOT NULL GROUP BY level_2_id, level_2_name ORDER BY comments_count DESC LIMIT $startCount2,$perNumber";
  
  
  
   //每页显示的记录数
   //获得当前的页面值
  
   //分页开始,根据此方法计算出开始的记录
  $result2=mysqli_query($conn,$sql3);
  $result3=mysqli_query($conn,$sql4);
  $result4=mysqli_query($conn,$sql5); 
  ?>
          <div class="col-lg-6" style="float:left">
              <table class="table table-hover">
         <caption><font color="#FF0000">点击量排行</font></caption>
           <thead>
             <tr>
                <th><font color="#FFF">课程名</font></th>
                <th><font color="#FFF">点击量</font></th>
                <th><font color="#FFF">排名</font></th>
              </tr>
          </thead>
                <?php while($row=mysqli_fetch_assoc($result2))
  {
?>  
          <tbody>
              <tr>
                <td><font color="#FFF"><?php echo $row['course_name'] ?></font></td>
                <td><font color="#FFF"><?php echo $row['learner_count']?></font></td>
                <td><font color="#FFF"><?php echo $count1?></font></td>
              </tr>
              
          </tbody>
<?php 
    $count1++;
}?>
        </table>
               <ul class="pager">
                <?php if ($page != 1) { //页数不等于1
?>
           <li><a href="paihang.php?page1=<?php echo $page - 1;?>">Previous</a></li>
                      <?php
}
  for ($i=1;$i<=$totalPage;$i++) {  
  //循环显示出页面
?>
<?php
}
?>
  <?php
if ($page<$totalPage) { //如果page小于总页数,显示下一页链接
?>
           <li><a href="paihang.php?page=<?php echo $page + 1;?>">Next</a></li>
                       <?php
} 
?>
         </ul>
            </div>
               
            <div class="col-lg-6" style="float:left">
              <table class="table table-hover">
         <caption><font color="#FF0000">评论数排行</font></caption>
           <thead>
             <tr>
                <th><font color="#FFF">课程名</font></th>
                <th><font color="#FFF">评论数</font></th>
                <th><font color="#FFF">排名</font></th>
              </tr>
          </thead>
            <?php while($row1=mysqli_fetch_assoc($result3))
    {
  ?>
          <tbody>
              <tr>
                <td><font color="#FFF"><?php echo $row1['course_name'] ?></font></td>
                <td><font color="#FFF"><?php echo $row1['comments_count'] ?></font></td>
                <td><font color="#FFF"><?php echo $count2 ?></font></td>
              </tr>
          </tbody>
<?php 
  $count2++;    
}?>
         </table>
                <ul class="pager">
                <?php if ($page1 != 1) { //页数不等于1
?>
           <li><a href="paihang.php?page1=<?php echo $page1 - 1;?>">Previous</a></li>
                     <?php
}
  for ($i=1;$i<=$totalPage;$i++) {  
  //循环显示出页面
?>
<?php
}
?>
  <?php
if ($page1<$totalPage) { //如果page小于总页数,显示下一页链接
?>
           <li><a href="paihang.php?page1=<?php echo $page1 + 1;?>">Next</a></li>
                      <?php
} 
?>
         </ul>
        </div>
         <div class="col-lg-6" style="float:left;height:500px;">
              <table class="table table-hover">
         <caption><font color="#FF0000">分类排行</font></caption>
           <thead>
             <tr>
                <th><font color="#FFF">类名</font></th>
                <th><font color="#FFF">评论数</font></th>
                <th><font color="#FFF">排名</font></th>
              </tr>
          </thead>
                    <?php while($row2=mysqli_fetch_assoc($result4))
    {
  ?>
          <tbody>
              <tr>
                <td><font color="#FFF"><?php echo $row2['level_2_name'] ?></font></td>
                <td><font color="#FFF"><?php echo $row2['comments_count'] ?></font></td>
                <td><font color="#FFF"><?php echo $count3 ?></font></td>
              </tr>
          </tbody>
<?php 
  $count3++;    
}?>
         </table>
                <ul class="pager">
           <?php if ($page2 != 1) { //页数不等于1
?>
           <li><a href="paihang.php?page1=<?=$page1 ?>&page2=<?php echo $page2 - 1;?>">Previous</a></li>
                     <?php
}
  for ($i=1;$i<=$totalPage;$i++) {  
  //循环显示出页面
?>
<?php
}
?>
  <?php
if ($page2<$totalPage) { //如果page小于总页数,显示下一页链接
?>
           <li><a href="paihang.php?page1=<?=$page1 ?>&page2=<?php echo $page2 + 1;?>">Next</a></li>
                      <?php
} 
?>
         </ul>
            </div>   
    </div>
<nav class="nav navbar-default navbar-fixed-bottom" role="navigation">
  <div class="container-fluid">
      <div class="collapse navbar-collapse">
          <ul class="nav navbar-nav">
              <li><a href="#">首页</a></li>
              <li style="margin-left:60px;"><a href="#">联系我们</a></li>
              <li style="margin-left:60px;"><a href="#">系统简介</a></li>
                <li style="margin-left:60px;"><a href="#">邮箱地址</a></li>
            </ul>
        </div>
    </div>
</nav>
</body>
</html>
