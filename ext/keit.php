<!doctype html>
<?php
	SESSION_START();
?>
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

<body style="background-image:url(img/1378344035y2IBII.jpg); background-repeat:no-repeat; background-size:cover">
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
	$cid=$_GET['new'];
	$_SESSION['cid']= $cid;
	$sql = "SELECT * FROM `course` WHERE cid='$cid'";
	$sql2 = "SELECT * FROM `plan` WHERE cid='$cid'";
	$result=mysqli_query($conn,$sql);
	$result1=mysqli_query($conn,$sql2);
	$row=mysqli_fetch_assoc($result);
	$row1=mysqli_fetch_assoc($result1);
	?>
<nav class="nav navbar-default" role="navigation">
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
   	  <div class="container-fluid" style="background-color:#000">
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
    </nav>
    <div></div>
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
	<div class="container-fluid" style="float:left">
    	<div class="row">
        	<div class="panel panel-default" style="float:left; margin-top:40px; width:100%;" >
   				<div class="panel-body">
      			<?php echo $row['course_name'] ?><br>
            <?php echo $row['course_desc'] ?><br>
            学习次数：<?php  echo $row['learner_count'] ?><br>
            课程提供者简介:<?php echo $row['teacher_desc'] ?>
   				</div>
   				 <video src="video/111.mp4" width="500" height="400" controls style="margin-left:400px;"></video>
			</div>
            
        </div>
      <div class="container-fluid">
      <div class="col-lg-12">
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
	$sql = "SELECT * FROM `notes` WHERE cid='$cid'";
	$result=mysqli_query($conn,$sql);
	$count="SELECT count(*) FROM `notes` WHERE cid=$cid";
	 //获得记录总数
	$result1=mysqli_query($conn, $count);
	$rs=mysqli_fetch_array($result1); 
	$perNumber=5;
	if(isset($_GET['page']) && !empty($_GET['page'])){
		$page=$_GET['page'];
	}else{
		$page=1;
		}
	$totalNumber=$rs[0];
	$totalPage=ceil($totalNumber/$perNumber); //计算出总页数
	if (!isset($page)) {
	 $page=1;
	} //如果没有值,则赋值1
	$startCount = ($page-1)*$perNumber;
	$sql2="SELECT * FROM `notes` LIMIT $startCount,$perNumber";
	 //每页显示的记录数
	 //获得当前的页面值
	
	 //分页开始,根据此方法计算出开始的记录
	$result2=mysqli_query($conn,$sql2);
	?>
        	<table class="table" style="width:100%;">
            	<caption>笔记信息</caption>
                <thead>
                	<tr>
         				<th style="width:50%;"><font style="color:#FFF">用户名</font></th>
         				<th style="width:50%;"><font style="color:#FFF">笔记</font></th>
     				</tr>
                </thead>
              <?php	while($row=mysqli_fetch_assoc($result2))
			  { 
			  ?>
              <tbody>
              	<tr>
         		<td style="width:50%;"><a href="./keit.php?new=<?php echo $cid;?>"><font style="color:#FFF"><?php echo $row['user_name'] ?></font></a></td>
         		<td style="width:50%;"><font style="color:#FFF"><?php echo $row['content'] ?></font></td>
      			</tr>
              </tbody>
              <?php } ?>
            </table>
            <ul class="pager">
         <?php if ($page != 1) { //页数不等于1
?>
 			<li class="previous"><a href="keit.php?new=<?php echo $cid; ?>?page=<?php echo $page - 1;?>">&larr; Older</a></li>
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
  			<li class="next"><a href="keit2.php?p=2">Newer &rarr;</a></li>
             <?php
} 
?>
		</ul>
        </div>
    </div>
    </div>
    
	
    <div class="contain-fluid">
    	<div class="row">
        	<div class="panel panel-defau">
            	<div class="panel-body">
                课程目录
                <div id="convert"></div>
                <script type="text/javascript">
                  var __oldOnload = window.onload || function(){};
                  window.onload = function (){
                    __oldOnload();
                    var convert=document.getElementById('convert');
                    var json = <?php echo $row1['course_plan']; ?>;
                    var tpl = [];
                    tpl.push('<ul class="list-group">');
                    for (var attr in json) {
                      var item = json[attr];
                      var items = item.toString().split(',');
                      items.forEach(function (it) {
                          tpl.push('<li class="list-group-item">' + it + '</li>');
                      });
                      
                    }
                    tpl.push('</ul>');
                    convert.innerHTML = tpl.join('');
                  };
                </script>
                </div>
            </div>
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
