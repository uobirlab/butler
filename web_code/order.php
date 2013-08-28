<html>
<head>
<title>Order a Drink</title>
</head>
<body>
<?php 
$lock = fopen("data/lock","w+");
if (flock($lock, LOCK_EX)) {
	$station=$_POST["station_id"];
	$drinks=$_POST["drinks"];
	$name=$_POST["name"];

	$order_number=intval(file_get_contents("data/last.txt"))+1;

	file_put_contents("data/last.txt",$order_number);

	// Open orders file
	if (!$file = fopen("data/orders.txt", 'a')) { 
		print "Oh No! Err Code=1"; 
		exit; 
	} 

	if (!fwrite($file, "".$order_number." ".$station." ".$drinks." ".$name."\n" )) { 
		print "Oh No! Ordering problem...";
		exit; 
	} 
	fclose($file);
	flock($lock, LOCK_UN);	
} else {
	echo "Error 42.";	
}

echo "<h1>Great, see you soon $name!</h1>";

echo "<p> Your order has been placed, and will be with you shortly. </p>";

echo "<p> Can't wait? Watch the queue <a href='monitor.php?id=$order_number'>here</a></p>";
?>
</body>
</html>
