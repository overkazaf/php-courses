(function ($, echarts){

	// var person = {
	// 	data : [
	// 		{
	// 			category:2,
	// 			id:"0",
	// 			name:"人物名称:1",
	// 			symbolSize:51.3061675138636,
	// 			value:118.153553259293
	// 		}
	// 	],
	// 	links : [
	// 		{
	// 			id:"0",
	// 			source:20,
	// 			target:1
	// 		}
	// 	]
	// };


	$(function () {
		var MAX_LEVEL = 3; // 最大分类（层数）
		var LINKS_LIMIT = 20; // 每个节点的最大链接数
		var TOTAL_DATA_COUNT = 20; // 数据总数

		// 生成随机数
		var rnd = function (max) {
			if (arguments.length === 1) {
				return Math.random() * max;
			} else {
				var args = arguments;
				var min = args[0];
				var max = args[1];
				var diff = max - min;
				return min + Math.random() * diff;
			}
		};

		var rndData = function (limit) {
			var ret = [];
			for (var i = 0; i < limit; i++) {
				var val = rnd(40, 100);
				ret.push({
					id : '' + i,
					name : '人物' + (i+1),
					category : round(MAX_LEVEL),
					value : val,
					symbolSize : val / 2
				});
			}
			return ret;
		};

		var round = function (limit) {
			return Math.round(Math.random() * limit);
		};
		var rndLinks = function (limit) {
			var ret = [];
			for (var i = 0; i < limit; i++) {
				var currentLimit = round(limit);
				var tmp = {};
				var nextLink = function () {

					var src = round(TOTAL_DATA_COUNT);
					var dist;
					var cnt = 0;

					while ((dist = round(TOTAL_DATA_COUNT)) == src && cnt++ < 400);

					var a = [src, dist].sort().join('->');
					if (!tmp[a]) {
						tmp[a] = {
							src : src,
							dist : dist
						}

						return tmp[a];
					} else {
						return undefined;
					}

					

				};
				for (var j = 0; j < currentLimit; j++) {
					var link = nextLink();

					if (!!link) {
						ret.push({
							id : '' + i,
							source : link.src,
							target : link.dist 
						});
					}
				}
			}

			console.log('links', ret);

			return ret;
		};


		// demo参数及数据
		var DEFAULT = {
			TITLE : '图标题',
			SUB_TITLE : '图副标题',
			REPULSION : 1000,
			GRAVITY : 0.1,
			WIDTH : 1200, // 画布宽
			HEIGHT: 700, // 画布高
			DATA : {
				data : rndData(TOTAL_DATA_COUNT),
				links : rndLinks(LINKS_LIMIT)
			}
		};

		// console.log('DEFAULT', DEFAULT.DATA);

		/**
		 * [OptionGroup 配置项生成策略]
		 * @type {Object}
		 */
		var OptionGroup = {
			'default' : function (data) {
				var categories = [];
				for (var i = 0; i < MAX_LEVEL; i++) {
					categories.push({
						name : i
					});
				}

				console.log('categories', categories);
				var option = {
			        title: {
			            text: DEFAULT.TITLE,
			            subtext: DEFAULT.SUB_TITLE,
			            top: 'top',
			            left: 'center'
			        },
			        tooltip: {},
			        
			        animation: false,
			        series : [
			            {
			                name: DEFAULT.TITLE,
			                type: 'graph',
			                layout: 'force',
			                data: data.data,
			                links: data.links,
			                categories: categories,
			                roam: true,
			                hoverAnimation : 'force',
			                lineStyle : {
			                	normal : {
			                		color : 'source',
			                		curveness : 0.9
			                	}
			                },
			                nodeScaleRatio : 1,
			                animationDuration: 4500,
        					animationEasingUpdate: 'quinticInOut',
			                symbol : 'circle',
			                 label: {
			                    normal: {
			                    	show : true,
			                        position: 'inside',
			                        textStyle : {
			                        	color : '#fff'
			                        },
			                        formatter: '{b}'
			                    },
			                    emphasis : {
			                    	show : true,
			                    	textStyle : {
			                        	color : '#ff0'
			                        },
			                    }
			                },
			                markPoint : {
			                	normal : {}
			                },
			                force: {
			                	initLayout : 'circular',
			                    repulsion: DEFAULT.REPULSION,
			                    gravity: DEFAULT.GRAVITY
			                }
			            }
			        ]
			    };

			    return option;
			}
		};


		var APP = {
			URL : 'http://localhost:8088/chartData.php', // 实现使用时使用对应的接口地址
			cache : {},// 缓存数据
			CANVAS_ID : "#main", // 画布id
			chartEl : null, // echarts实例,
			isDemo : true,
			RESIZE : true,
			filePrefix : '',
			init : function () {
				var __this = this;

				// 初始化echarts图表
				this.initChart();

				this.loading.show();

				this.fetch(APP.filename, function (data) {
					__this.loading.hide();

					APP.renderChart({
						strategy : 'default',
						data : data
					});
				});
			},
			initChart : function () {
				var $canvas = $(APP.CANVAS_ID);
				if (APP.RESIZE) {
					$canvas.css({
						width : DEFAULT.WIDTH + 'px',
						height : DEFAULT.HEIGHT + 'px'
					});
				}
				APP.chartEl = echarts.init($canvas[0]);
			},
			loading : {
				hide : function () {
					!!APP.chartEl && APP.chartEl.hideLoading();
				},
				show : function () {
					!!APP.chartEl && APP.chartEl.showLoading();
				}
			},
			fetch : function (filename, callback) {
				if (APP.cache[filename]) {
					return callback(APP.cache[filename]);
				} else {
					if (APP.isDemo) {
						return callback(DEFAULT.DATA);
					} else {
						return APP.getJson(filename, callback);
					}
				}
			},
			getJson : function (filename, callback) {
				var targetFile = APP.filePrefix + filename;
				$.getJSON(targetFile, function (data){
					APP.cache[filename] = data;
					callback(data);
				});
			},
			getChartOption (data, strategy) {
				return OptionGroup[strategy](data);
			},
			renderChart : function (opt) {
				// 1. 生成图表配置项
				var option = APP.getChartOption(opt.data, opt.strategy);

				// 2. 绘制echarts图表
				APP.chartEl.setOption(option);
			}
		};


		//应用程序初始化
		APP.init();
	});

})(jQuery, echarts);