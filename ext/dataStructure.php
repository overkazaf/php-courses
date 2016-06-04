<!doctype html>
<html>
<head>
<meta charset="utf-8">

  <meta http-equiv="X-UA-Compatible" content="IE=Edge, Chrome=1">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="renderer" content="webkit">
    <meta name="author" content="overkazaf">

  <link rel="stylesheet" type="text/css" href="node_modules/bootstrap/dist/css/bootstrap.min.css">
<title>评价平台</title>
<link href="bootstrap-3.3.5-dist/css/bootstrap.min.css" rel="stylesheet" type="text/css">
<script src="bootstrap-3.3.5-dist/js/jquery-2.2.2.min.js"></script>
<script src="bootstrap-3.3.5-dist/js/bootstrap.min.js"></script>
</head>

<body style="background-image:url(img/u=2025633508,102050162&fm=21&gp=0.jpg); background-repeat:no-repeat; background-size:cover">
<?php
	$host='localhost';
	$user='root';
	$pass='';
	$db='163study';
	$conn=mysqli_connect($host,$user,$pass);
	if(!$conn){ echo lianjieshibai; exit;}
	mysqli_select_db($conn,$db);
	$sql = "SELECT * FROM `comments` WHERE mark=5";
	$result=mysqli_query($conn,$sql);
	$row = mysqli_num_rows($result);
	$sql1 = "SELECT * FROM `comments_count`";
	$result1 = mysqli_query($conn,$sql1);
?>
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
	<div class="container-fluid" style="margin-left:120px;">
    		<div class="panel panel-primary">
  				 <div class="panel-heading">
                 <div class="panel-body">
      				平台使用近况
   				</div>
     					<div class="col-lg-12" align="center">
                    	<input value="查看近期使用情况" type="button" onClick="window.open('jianping2.php')">
                    </div>
  				 </div>
   				 <div class="panel-body">
      			     <div class="col-md-10 col-md-offset-1">
    <h1 class="txt-center">课程信息图表详情展示</h1>
    <hr>
  </div>
  <style type="text/css">
    #main {
      height: 620px;
      background: #e5e5e5;
    }
    .maxHeight {
      max-height: 620px;
      overflow-y: auto;
      background: #e5e5e5;
      border-radius: 5px;
    }

    #navContainer li:hover {
      background: #ffff00 !important;
    }
  </style>
  <script type="text/javascript" src="node_modules/jquery/dist/jquery.min.js"></script>
  <script type="text/javascript" src="node_modules/echarts/dist/echarts.min.js"></script>
  <script type="text/javascript" src="node_modules/bootstrap/dist/js/bootstrap.min.js"></script>
  <script type="text/javascript">
    $(function () {

      var APP = {
        URL : 'http://localhost/index.php', // 对应的接口名称
        cache : [],// 缓存数据
        CANVAS_ID : "#main", // 画布id
        chartEl : null, // echarts实例
        NAV_ID : "#navContainer", // 左侧的导航菜单容器ID
        init : function () {
          // 初始化echarts图表
          this.initChart();

          // 构建导航菜单
          this.buildNavs(function () {

            // 为每一个导航项绑定导航事件
            $(APP.NAV_ID).on('click', 'li', function (){
              // 点击左侧导航项后会重绘图表
              var cache = APP.cache;
              var filtered = [];

              // 得到当前的课程level_2_id,并到缓存中查询，找到对应的数据
              var currentId = $(this).attr('data-id');
              cache.forEach(function (item, index) {
                if (item['level_2_id'] == currentId) {
                  filtered.push(item);
                }
              });

              setTimeout(function () {
                // 出于性能考虑，延迟0.5秒绘制图表
                APP.renderChart(filtered);
              }, 500)
              
            });

            // 初始化时，模拟每一个导航项的点击事件
            $(APP.NAV_ID).find('li:first').trigger('click');
          });
        },
        initChart : function () {
          APP.chartEl = echarts.init($(APP.CANVAS_ID)[0]);
        },
        getChartOption (data) {
          var xData = [];
          var seriesData = [];

          for (var i = 0, l = data.length; i < l; i++) {
            var item = data[i];
            // x轴的变量值
            xData.push(item.course_name);

            // 对应的柱状图数据
            seriesData.push(item.learner_count);
          }

          // 最终生成的图表配置项
          var option = {
            title : {
              text : data[0].level_1_name,
              left : "center"
            },
              tooltip : {
                  trigger: 'axis',
                  axisPointer : {            // 坐标轴指示器，坐标轴触发有效
                      type : 'shadow'        // 默认为直线，可选为：'line' | 'shadow'
                  }
              },
              toolbox: {
                  feature: {
                      dataView: {readOnly: false},
                      restore: {},
                      saveAsImage: {}
                  }
              },
              grid: {
                  left: '3%',
                  right: '4%',
                  bottom: '3%',
                  containLabel: true
              },
              xAxis : [
                  {
                      type : 'category',
                      axisLabel : {
                        inteval : 0
                      },
                      data : xData
                  }
              ],
              yAxis : [
                  {
                      type : 'value'
                  }
              ],
              series : [
                  {
                      name:data[0].level_1_name,
                      type:'bar',
                      data:seriesData
                  }
              ]
          };

          return option;
        },
        renderChart : function (data) {
          // 1. 生成图表配置项
          var option = APP.getChartOption(data);

          // 2. 绘制echarts图表
          APP.chartEl.setOption(option);
        },
        buildNavs : function (callback) {
          // 构建导航项分为两步，
          // 第一步取相应接口的json数据，
          // 每二步根据数据，构建dom结构，并渲染左侧导航菜单
          // callback是在图表渲染完成后的回调函数，一般可以在渲染完成后进行事件的绑定
          $.ajax({
            url : APP.URL,
            type : "GET",
            dataType : "JSON",
            success : function (json) {
              APP.cache = json;
              var navNames = pickLevel2Names(json);
              var $nav = $(APP.NAV_ID);
              var tpl = [];
              for (var i = 0, l = navNames.length; i < l; i++) {
                var newTpl = dropdownTpl();
                newTpl = newTpl.replace('{{TEXT}}', navNames[i].nav);
                newTpl = newTpl.replace('{{DATA}}', navNames[i].top);
                newTpl = newTpl.replace('{{ID}}', navNames[i].id);
                tpl.push(newTpl);
              }

              $nav.html(tpl.join(''));

              callback && callback();
            }
          });
        }
      };

      /**
       * [pickLevel2Names 为导航栏挑选出子类课程名称]
       * @param  {[type]} json [所有满足条件的课程数据(每个子类最多五项数据， 见index.php里的sql语句实现)]
       * @return {[type]}      [description]
       */
      function pickLevel2Names (json) {
        var ret = [];
        var cache = {};
        for (var i=0, l = json.length; i < l ; i++) {
          var item = json[i];
          if (!(item['level_2_name'] in cache)) {
            cache[item['level_2_name']] = true;
            ret.push({
              nav : item['level_2_name'],
              id : item['level_2_id']
            });
          }
        }

        return ret;
      }

      /**
       * [dropdownTpl 每个导航项的模板字符串， 这儿是为了在批量生成导航项时提高效率]
       * @return {[type]} [description]
       */
      function dropdownTpl () {
        return '<li role="presentation" class="active" data-id="{{ID}}"><a href="javascript:void(0)">{{TEXT}}</a></li>';
      }

      //应用程序初始化
      APP.init();
    });
  </script>
  <div class="col-md-10 col-md-offset-1" style="float:left">
    <div class="col-md-2 maxHeight">
      <ul class="nav nav-stacked" id="navContainer">
        
      </ul>
    </div>
    <div class="col-md-8">
      <div id="main"></div>
    </div>
  </div>
  			     </div>
			</div>
			<div class="panel panel-success">
  				 <div class="panel-heading">
     				 <h3 class="panel-title"></h3>
   				</div>
  				<div class="panel-body">
            <style type="text/css">
    #top5 {
      height: 620px;
      background: #e5e5e5;
    }
  </style>
              <div class="col-md-8 col-md-offset-2">
    <h1>热门课程</h1>
    <hr>
  </div><script type="text/javascript" src="node_modules/jquery/dist/jquery.min.js"></script>
  <script type="text/javascript" src="node_modules/echarts/dist/echarts.min.js"></script>
  <script type="text/javascript" src="node_modules/bootstrap/dist/js/bootstrap.min.js"></script>
  <script type="text/javascript">
    $(function () {

      var APP = {
        URL : 'http://localhost/top5.php', // 相应的接口地址，这儿是取课程的观看数前5的数据，见top5.php里的实现
        TITLE : "图表标题",
        SUB_TITLE : "图表副标题",
        CANVAS_ID : "#top5",
        chartEl : null,
        init : function () {
          var that = this;

          this.initChart();

          // 获取数据后，渲染图表
          getData(APP.URL, function (data){
            that.renderChart(data);
          });
        },
        initChart : function () {
          APP.chartEl = echarts.init($(APP.CANVAS_ID)[0]);
        },
        getChartOption (data) {
          var xData = [];
          var seriesData = [];

          for (var i = 0, l = data.length; i < l; i++) {
            var item = data[i];
            xData.push(item.course_name);
            seriesData.push({
              name : item.course_name,
              value : item.learner_count
            });
          }

          var option = {
              title : {
                  text: APP.TITLE,
                  subtext: APP.SUB_TITLE,
                  x:'center'
              },
              tooltip : {
                  trigger: 'item',
                  formatter: "{a} <br/>{b} : {c}人 ({d}%)"
              },
              toolbox: {
                  feature: {
                      dataView: {readOnly: false},
                      restore: {},
                      saveAsImage: {}
                  }
              },
              legend: {
                  orient: 'vertical',
                  left: 'left',
                  data: xData
              },
              series : [
                  {
                      name: '课程观看数',
                      type: 'pie',
                      radius : '55%',
                      center: ['50%', '60%'],
                      data:seriesData,
                      itemStyle: {
                          emphasis: {
                              shadowBlur: 10,
                              shadowOffsetX: 0,
                              shadowColor: 'rgba(0, 0, 0, 0.5)'
                          }
                      }
                  }
              ]
          };


          return option;
        },
        renderChart : function (data) {
          var option = APP.getChartOption(data);
          APP.chartEl.setOption(option);
        }
      };

      function getData(url, callback) {
        $.ajax({
          url : url,
          type : 'get',
          dataType : 'JSON',
          success : function (data) {
            callback && callback(data);
          }
        });
      }

      APP.init();
    });
  </script>
   				</div>
     					<div id="top5" style="width:600px; height:400px;">                
        </div>

           
             
	<div class="container-fluid">
    <style type="text/css">
		#data {
			height: 620px;
			background: #e5e5e5;
		}
	</style>
    <div class="col-md-8 col-md-offset-2">
		<h1>数据结构课程对比    <button class="btn btn-primary" id="switch">切换图表</button></h1>
		<hr>
	</div>
	<div class="col-md-8 col-md-offset-2">
		<div id="data"></div>
	</div>
    <script type="text/javascript" src="node_modules/jquery/dist/jquery.min.js"></script>
	<script type="text/javascript" src="node_modules/echarts/dist/echarts.min.js"></script>
	<script type="text/javascript" src="node_modules/bootstrap/dist/js/bootstrap.min.js"></script>
	<script type="text/javascript">
		$(function () {

			var OptionGroup = {
				"line" : function (data) {
					var xData = [];
					var seriesData = [];

					for (var i = 0, l = data.length; i < l; i++) {
						var item = data[i];
						xData.push(item.course_name);
						seriesData.push({
							name : item.course_name,
							value : item.learner_count
						});
					}

					var option = {
					    title: {
					        text: APP.TITLE
					    },
					    tooltip : {
					        trigger: 'axis'
					    },
					    legend: {
					        data:xData
					    },
					    toolbox: {
					        feature: {
					            dataView: {readOnly: false},
					            restore: {},
					            saveAsImage: {}
					        }
					    },
					    grid: {
					        left: '3%',
					        right: '4%',
					        bottom: '3%',
					        containLabel: true
					    },
					    xAxis : [
					        {
					            type : 'category',
					            boundaryGap : false,
					            data : xData
					        }
					    ],
					    yAxis : [
					        {
					            type : 'value'
					        }
					    ],
					    series : [
					        {
					            name:'观看数详情',
					            type:'line',
					            stack: '总量',
					            areaStyle: {normal: {}},
					            data:seriesData
					        }
					    ]
					};

					return option;

				},
				"bar" : function (data) {
					var xData = [];
					var seriesData = [];

					for (var i = 0, l = data.length; i < l; i++) {
						var item = data[i];
						xData.push(item.course_name);
						seriesData.push({
							name : item.course_name,
							value : item.learner_count
						});
					}

					var option = {
						title: {
					        text: APP.TITLE
					    },
					    tooltip : {
					        trigger: 'axis',
					        axisPointer : {            // 坐标轴指示器，坐标轴触发有效
					            type : 'shadow'        // 默认为直线，可选为：'line' | 'shadow'
					        }
					    },
					    legend: {
					        data:xData
					    },
					    grid: {
					        left: '3%',
					        right: '4%',
					        bottom: '3%',
					        containLabel: true
					    },
					    xAxis : [
					        {
					            type : 'category',
					            data : xData
					        }
					    ],
					    yAxis : [
					        {
					            type : 'value'
					        }
					    ],
					    series : [
					        {
					            name:'观看数详情',
					            type:'bar',
					            data:seriesData
					        }
					    ]
					};

					return option;
				}
			};
			var APP = {
				URL : 'http://localhost:8088/dataStructure.php',
				TITLE : "图表标题",
				SUB_TITLE : "图表副标题",
				CANVAS_ID : "#main",
				chartEl : null,
				cache : {},
				init : function () {
					var that = this;
					var status = true;

					this.initChart();

					getData(APP.URL, function (data){
						that.renderChart(data);
					});


					$('#switch').on('click', function () {
						status = !status;
						var type = status ? 'line' : 'bar';

						APP.renderChart(APP.cache, type);
					});
				},
				initChart : function () {
					APP.chartEl = echarts.init($(APP.CANVAS_ID)[0]);
				},
				getChartOption (data, type) {
					var type = type || 'line';
					return OptionGroup[type](data);
				},
				renderChart : function (data, type) {
					var option = APP.getChartOption(data, type);
					APP.chartEl.setOption(option);
				}
			};

			function getData(url, callback) {
				$.ajax({
					url : url,
					type : 'get',
					dataType : 'JSON',
					success : function (data) {
						APP.cache = data;
						callback && callback(data);
					}
				});
			}


			APP.init();
		});
	</script>
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
