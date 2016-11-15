<?php
session_start();
?>
<!doctype html>
<html>
<head>

<title>ManGO</title>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>

<style>
	@import "global-order.css";
</style>
</head>
<body>
<div id="container">
	<h5><img src="images/logo2.gif" class="logo2"></h5>
	<div id="head">

    <div class="progress">
				<div class="progress-bar progress-bar-success progress-bar-striped" role="progressbar" aria-valuenow="40" aria-valuemin="0" aria-valuemax="100" style="width:40%">
			     40% Complete (success)
		    </div>
    </div>
		<br>
	
	 </div>
	<div id="content">
		<br><br><br><br><br><br>
	</div>
	<div id="bottom">
		<button id="index">&laquo; ย้อนกลับ</button>
		<button id="next">ถัดไป &raquo;</button>
	</div>
</div>
</body>
</html>
