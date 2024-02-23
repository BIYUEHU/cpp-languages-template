<!DOCTYPE html>
<html lang="zh-cn">

<head>
	<meta http-equiv="charset" content="utf-8">
	<meta http-equiv="content-type" content="text/html;charset=utf-8" />
	<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
	<title>查看贴吧用户动态与资料</title>
	<link href="//cdn.bootcss.com/bootstrap/3.3.5/css/bootstrap.min.css" rel="stylesheet">
	<script src="//cdn.bootcss.com/jquery/1.11.3/jquery.min.js"></script>
	<script src="//cdn.bootcss.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>
	<style>
		body {
			font-family: "微软雅黑", "Microsoft YaHei";
			word-wrap: break-word;
			word-break: break-all;
		}

		a {
			text-decoration: none;
		}

		a:hover,
		a:focus {
			text-decoration: none;
			text-shadow: 0 1px 1px #555;
		}

		a:active {
			text-decoration: none;
		}
	</style>
</head>

<body>
	<div class="container">
		<div class="row">
			<div class="col-xs-12 col-sm-10 col-lg-8 center-block" style="float: none;">
				<h2>查看贴吧用户动态与资料</h2>
				<div class="form-inline-block">
					<div class="input-group">
						<input id="sears" type="text" placeholder="请输入百度ID" onkeydown="if(event.keyCode==13){$('#search').click()}" class="form-control input-lg">
						<span class="input-group-btn">
							<button id="search" class="btn btn-primary btn-lg" type="button">
								查看动态
							</button>
							<button id="userinfo" class="btn btn-info btn-lg" type="button">
								查看资料
							</button>
						</span>
					</div>
				</div>
				<div id="page"></div>
			</div>
		</div>
	</div>
	<script type="text/javascript">
		$(document).ready(function() {
			$("#search").click(function() {
				showresult($("#sears").val(), 1)
			});
			$("#userinfo").click(function() {
				showuserinfo($("#sears").val())
			});
		});

		function showresult(word, page) {
			$('#page').html('<div id="lodding" style="text-align:center;"><img src="load.gif"></div>');
			$.ajax({
				type: "GET",
				url: "search.php?word=" + word + "&page=" + page,
				dataType: 'html',
				success: function(result) {
					$('#page').html(result);
				}
			});
		}

		function showuserinfo(user) {
			$('#page').html('<div id="lodding" style="text-align:center;"><img src="load.gif"></div>');
			$.ajax({
				type: "GET",
				url: "userinfo.php?user=" + user,
				dataType: 'html',
				success: function(result) {
					$('#page').html(result);
				}
			});
		}
	</script>
</body>

</html>