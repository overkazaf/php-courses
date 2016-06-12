<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>评价平台</title>
<link href="bootstrap-3.3.5-dist/css/bootstrap.min.css" rel="stylesheet" type="text/css">
<script src="bootstrap-3.3.5-dist/js/jquery-2.2.2.min.js"></script>
<script src="bootstrap-3.3.5-dist/js/bootstrap.min.js"></script>

</head>

<body style="background-image:url(img/1378344035y2IBII.jpg); background-repeat:no-repeat; background-size:cover;">
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
   <div class="navbar-form navbar-right">
         	     <form id="searchForm" action="kecheng.php" target="_self" method="GET">
                 <input type="text" id="kw" name="kw" class="form-control" placeholder="课程名称/讲师/用户ID" value="<?php echo isset($_GET['kw'])?$_GET['kw']:"" ?>"/>
               </form>
              <button class="btn btn-primary" id="search">搜 索</button>
         		</div>
   <div class="collapse navbar-collapse" id="example-navbar-collapse">
      <ul class="nav navbar-nav">
         <li><a  href="./kecheng.php">课程列表</a></li>
         <li class="active"><a href="./paihang.php">多样排行</a></li>
         <li ><a href="./jianping.php">平台简评</a></li>
      </ul>
   </div>
</nav>
	<div class="container-fluid" style="style="float:left" >
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
	$sql = "SELECT * FROM `course`";
	$result=mysqli_query($conn,$sql);
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
	$totalNumber=$rs[0];
	$totalPage=ceil($totalNumber/$perNumber); //计算出总页数
	if (!isset($page)) {
	 $page=1;
	} //如果没有值,则赋值1
	$startCount = ($page-1)*$perNumber;
	
  $sql2="SELECT * FROM `course` LIMIT $startCount,$perNumber";

  $kw = '';
  if (isset($_GET['kw']) && !empty($_GET['kw'])) {
    $kw = $_GET['kw'];
    $sql2="SELECT * FROM `course` WHERE `course_name` LIKE '%". $_GET['kw'] ."%' LIMIT $startCount,$perNumber";
  }
  echo $sql2;

	 //每页显示的记录数
	 //获得当前的页面值
	
	 //分页开始,根据此方法计算出开始的记录
	$result2=mysqli_query($conn,$sql2);
	?>
	<table class="table" style="color:#FFF">
   <caption style="color:#FFF">课程列表</caption>
   		<thead>
      		<tr>
         		<th>名称</th>
         		<th>课程简介</th>
     		</tr>
   		</thead>
<?php while($row=mysqli_fetch_assoc($result2))
	{
		$cid=$row['cid'];
?> 	
        <tbody> 
      		<tr>
         		<td><a href="<?php echo "./ke1.php?new=".$cid ?>" style="color:#FFF"><?php echo $row['course_name'] ?></a></td>
         		<td><?php echo $row['course_desc'] ?></td>
      		</tr>
   		</tbody>
<?php } ?>
	</table>
       	<ul class="pager">
         <?php if ($page != 1) { //页数不等于1
?>
 			<li class="previous"><a href="kecheng.php?kw=<?=$kw ?>&page=<?php echo $page - 1;?>">&larr; Older</a></li>
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
  			<li class="next"><a href="kecheng.php?kw=<?=$kw ?>&page=<?php echo $page + 1;?>">Newer &rarr;</a></li>
             <?php
} 
?>
		</ul>
        </div>
        </row>
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
<script type="text/javascript">
  $(function () {
    var $searchBtn = $('#search');
    var $keyword = $('#keyword');
    var $searchForm = $('#searchForm');

    $searchBtn.on('click', function () {
      var keyword = $.trim($keyword.val());
      if (keyword != '') {
        $keyword.val(keyword);
      }
      $searchForm.submit();
    });
  });

</script>
</body>
</html>
