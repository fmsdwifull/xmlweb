<!DOCTYPE html>
<html lang="zh-CN">
<head>
	<meta charset="utf-8">
	<title>状态查看界面</title>
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link href="static/css/bootstrap.min.css" rel="stylesheet">
	<script src="static/js/jquery-1.10.2.js"></script>
	<script src="static/js/bootstrap.js"></script>
	<script src="static/Highcharts/highcharts.src.js"></script>
	<script src="static/Highcharts/modules/exporting.js"></script>
	<style>
		#content{display:none;}
		#no_content{display:none;}
	</style>
<body>
<div class="navbar navbar-inverse navbar-fixed-top">
      <div class="container">
        <div class="navbar-header">
          <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
          <a class="navbar-brand hidden-sm" href="#">组件组件</a>
        </div>
        <div class="navbar-collapse collapse">
          <ul class="nav navbar-nav">
            <li><a href="#">首页</a></li>
            <li class="dropdown">
              <a href="javascript:void(0)" class="dropdown-toggle" data-toggle="dropdown">组件组件<b class="caret"></b></a>
              <ul class="dropdown-menu">
                <li class="">
                  <a href="#">组件组件</a>
                </li>
                <li class="">
                  <a href="#">组件组件</a>
                </li>
                <li class="">
                  <a href="#">组件组件</a>
                </li>
                <li class="">
                  <a href="#">组件组件</a>
                </li>
                <li class="">
                  <a href="#">组件组件</a>
                </li>
                <li class="">
                  <a href="#">组件组件</a>
                </li>
              </ul>
            </li>
            <li class="dropdown">
              <a href="javascript:void(0)" class="dropdown-toggle" data-toggle="dropdown">组件组件<b class="caret"></b></a>
              <ul class="dropdown-menu">
                <li>
                  <a href="#">组件组件</a>
                </li>
                <li>
                  <a href="#">组件组件</a>
                </li>
                <li>
                  <a href="#">组件组件</a>
                </li>
                <li>
                  <a href="#">组件组件</a>
                </li>
                <li>
                  <a href="#">组件组件</a>
                </li>
              </ul>
            </li>
            <li><a href="#">组件组件</a></li>
            <li><a href="#">组件组件</a></li>
            <li><a href="#">关于</a></li>
			<a class="btn btn-lg btn-primary reloadLoadPage" href="javascript:void(0);" style="float:right;"> 手动加载 </a>
          </ul>
        </div>
      </div>
    </div>
	
	<!--<div class="container" style="margin-top:80px;">
		<p class="text-center">
			<a class="btn btn-lg btn-primary reloadLoadPage" href="javascript:void(0);"> 手动加载 </a>
		</p>
	</div>-->

	<div class="container" id="content" style="margin-top:20px;">
		<div class="page-header">
		  <h3 id="tables">MediaServer： （<span id="mediaserver_count"></span>）</h1>
		</div>
		<div class="container" id="mediaserver">
			<table class="table table-hover">
				<thead>
				  <tr>
					<th>#</th>
					<th>Ip</th>
					<th>状态</th>
				  </tr>
				</thead>
				<tbody>
				 
				</tbody>
			  </table>
		  </div>


		  <div class="page-header">
		  <h3 id="tables">LogServer： （<span id="logserver_count"></span>）</h1>
		</div>
		<div class="container" id="logserver">
			<table class="table table-hover">
				<thead>
				  <tr>
					<th>#</th>
					<th>Ip</th>
					<th>状态</th>
					<th>工作队列数</th>
				  </tr>
				</thead>
				<tbody>
				 
				</tbody>
			  </table>
		  </div>


		  <div class="page-header">
			  <h3 id="tables">最后一次上传时间：<span id="lastuploadtime"></span></h1>
		</div>


		<div class="page-header">
			  <h3 id="tables">最后一次处理完成时间：<span id="lastprocesstime"></span></h1>
		</div>
		
		<div class="page-header">
			  <h3 id="tables">下一次上传时间：<span id="nextuploadtime"></span></h1>
		</div>


		<div class="page-header">
			  <h3 id="tables">LogServer工作队列数柱状图</h1>
			  <div class="container" id="chart_column" style="min-height:300px;">
				
			  </div>
		</div>
		<div class="page-header">
			  <h3 id="tables">时间点</h1>
			  <div class="container" id="chart_column1" style="min-height:300px;">
				
			  </div>
		</div>
	</div>

	<div class="container" id="no_content">
		<div class="page-header">
			  <h3 id="tables">服务器未启动</h1>
		</div>
	</div>

	<div class="container" id="load">
		<div class="page-header" style="border:0px;">
			  <p class="text-center"><img src="load.gif"><p>
		</div>
	</div>

	<!--<div class="container">
		<p class="text-center">
			<a class="btn btn-lg btn-primary reloadLoadPage" href="javascript:void(0);"> 刷新该页面 </a>
		</p>
	</div>-->
	<div style="margin-top:100px;"></div>
	<script>
		function load_logServer_work(logserver_arr) {
			var categories = new Array();
			var seriesData = new Array();
			for (var i in logserver_arr)
			{	
				categories.push(logserver_arr[i].ip);
				seriesData.push(parseInt(logserver_arr[i].workqueue));
			}
			chart = new Highcharts.Chart({
				chart: {
					renderTo: 'chart_column',
					type: 'column',
					animation : false,
					zoomType: null
				},
				title: {
					text: 'LogServer工作队列数'
				},
				
				/*subtitle: {
					text: '数据来源：'
				},*/
				credits: {
					enabled: false   //右下角不显示LOGO
				},
				xAxis: [{
					categories: categories,
					labels: {
						rotation: -10,
						align: 'right'
					}
				}],
				yAxis: [{
					labels: {
						formatter: function() {
							return this.value + '%';
						},
						style: {
							color: '#89A54E'
						}
					},
					title: {
						text: ''
					},
					opposite: true

				},
				{ 
				gridLineWidth: 0,
				title: {
					text: ''
				},
				labels: {
					formatter: function() {
						return this.value + ' 个';
					},
					style: {
						color: '#4572A7'
					}
				}

				}],
				tooltip: {
					formatter: function() {
						
						return 'IP：' + this.x + '  工作队列数：' + this.y;
					}
				},
				legend: {
					layout: 'vertical',
					align: 'left',
					x: 120,
					verticalAlign: 'top',
					y: 40,
					floating: true,
					shadow: true,
					backgroundColor: '#FFFFFF'
				},
				
				exporting: {
					enabled: false
				},
				series: [{
					name: '工作队列数1',
					color: '#4572A7',
					yAxis: 1,
					data: seriesData

				}]
			});
		}

		function load_time_pointer(hourline) {
			categories = new Array();
			seriesData = new Array();
			for (var i in hourline)
			{	
				categories.push(hourline[i].id);
				seriesData.push(parseInt(hourline[i].value));
			}
			
			chart = new Highcharts.Chart({
				chart: {
					renderTo: 'chart_column1',
					type: 'line',
					animation : false,
					zoomType: null
				},
				title: {
					text: '时间点'
				},
				credits: {
					enabled: false
				},
				xAxis: [{
					categories: categories,
					labels: {
						rotation: -10,
						align: 'right'
					}
				}],
				yAxis: [{
					labels: {
						formatter: function() {
							return this.value;
						},
						style: {
							color: '#89A54E'
						}
					},
					title: {
						text: ''
					},
					opposite: true

				},
				{ 
				gridLineWidth: 0,
				title: {
					text: ''
				},
				labels: {
					formatter: function() {
						return this.value + ' 个';
					},
					style: {
						color: '#4572A7'
					}
				}

				}],
				tooltip: {
					formatter: function() {
						
						return 'ID：' + this.x + '  VALUE：' + this.y;
					}
				},
				legend: {
					layout: 'vertical',
					align: 'left',
					x: 120,
					verticalAlign: 'top',
					y: 40,
					floating: true,
					shadow: true,
					backgroundColor: '#FFFFFF'
				},
				
				exporting: {
					enabled: false
				},
				series: [{
					name: '时间点',
					color: '#4572A7',
					yAxis: 1,
					data: seriesData

				}]
			});
		}
	function load_page_data() {
		$.ajax({
			url : 'ajax.php',
			type : 'GET',
			timeout : 10000,
			async : false,
			data : {},
			dataType : 'json',
			error : function (XMLHttpRequest, textStatus, errorThrown) {
				alert('加载错误，请重新加载！');
			},
			success : function (data) {
				
				if (data.status == 1)
				{	
					$("#mediaserver_count").html((data.mediaserver).length);
					var mediaserver = data.mediaserver;
					mediaserver_html = '';
					var mIndex = 0;
					for (var m in mediaserver)
					{	
						mIndex++;
						var status_html = '<font color="green"><b>等待</b></font>';
						if (mediaserver[m].status == 1)
						{
							var status_html = '<font color="red"><b>正在上传</b></font>';
						}
						mediaserver_html += '<tr><td>'+mIndex+'</td><td>'+mediaserver[m].ip+'</td><td>'+status_html+'</td></tr>';
					}
					$("#mediaserver").find("tbody").html(mediaserver_html);

					$("#logserver_count").html((data.logserver).length);
					var logserver = data.logserver;
					logserver_html = '';
					var lIndex = 0;
					for (var l in logserver)
					{	
						lIndex++;
						var status_html = '<font color="green"><b>等待</b></font>';
						if (logserver[l].status == 1)
						{
							var status_html = '<font color="red"><b>工作中</b></font>';
						}
						logserver_html += '<tr><td>'+lIndex+'</td><td>'+logserver[l].ip+'</td><td>'+status_html+'</td><td>'+logserver[l].workqueue+'</td></tr>';
					}
					$("#logserver").find("tbody").html(logserver_html);

					$("#lastuploadtime").html(data.lastuploadtime);
					$("#lastprocesstime").html(data.lastprocesstime);
					$("#nextuploadtime").html(data.lastprocesstime);
					
					load_logServer_work(data.logserver);
					load_time_pointer(data.hourline.point);
					$("#content").show();
					$("#no_content").hide();
				} else {
					$("#content").hide();
					$("#no_content").show();
				}
				$("#load").hide();
			}
		});
	}

	$(function () {
		$(".reloadLoadPage").click(function () {
			$(this).attr('disabled', true);
			load_page_data();
			$(this).attr('disabled', false);
			alert('刷新成功！');
		});
		load_page_data();
		setInterval(load_page_data, 3000);
	});
	</script>
</html>