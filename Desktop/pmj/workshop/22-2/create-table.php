<?php
$link = @mysqli_connect("localhost", "root", "abc456")
 				or die(mysqli_connect_error());
				
//ถ้ายังไม่มีฐานข้อมูลให้สร้างขึ้นมาใหม่
$sql = "CREATE DATABASE IF NOT EXISTS pmj";
mysqli_query($link, $sql);
mysqli_select_db($link, "pmj");

//ถ้ายังไม่มีตารางให้สร้างขึ้นใหม่
$sql = "CREATE TABLE IF NOT EXISTS chitchat(
			date_post DATETIME,
			name  VARCHAR(50),
			message VARCHAR(250))";
			
mysqli_query($link, $sql);
			
mysqli_close($link);
?>