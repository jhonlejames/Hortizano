<?php
// including the database connection file
include_once("config.php");

if(isset($_POST['update']))
{	
	$id = $_POST['id'];
	$name = $_POST['name'];
	$disc = $_POST['disc'];
	$price = $_POST['price'];
	$quan = $_POST['quan'];	
	
	// checking empty fields
	if(empty($name) || empty($disc) || empty($price) || empty($quan)) {	
			
		if(empty($name)) {
			echo "<font color='red'>Name field is empty.</font><br/>";
		}
		
		if(empty($disc)) {
			echo "<font color='red'>Description field is empty.</font><br/>";
		}
		if(empty($price)) {
			echo "<font color='red'>Price field is empty.</font><br/>";
		}
		if(empty($quan)) {
			echo "<font color='red'>Quantity field is empty.</font><br/>";
		}
	} else {	
		//updating the table
		$sql = "UPDATE users SET name=:name, disc=:disc, price=:price, quan=:quan WHERE id=:id";
		$query = $dbConn->prepare($sql);
				
		$query->bindparam(':id', $id);
		$query->bindparam(':name', $name);
		$query->bindparam(':disc', $disc);
		$query->bindparam(':price', $price);
		$query->bindparam(':quan', $quan);
		$query->execute();
		
		// Alternative to above bindparam and execute
		// $query->execute(array(':id' => $id, ':name' => $name, ':email' => $email, ':age' => $age));
				
		//redirectig to the display page. In our case, it is index.php
		header("Location: index.php");
	}
}
?>
<?php
//getting id from url
$id = $_GET['id'];

//selecting data associated with this particular id
$sql = "SELECT * FROM users WHERE id=:id";
$query = $dbConn->prepare($sql);
$query->execute(array(':id' => $id));

while($row = $query->fetch(PDO::FETCH_ASSOC))
{
	$name = $row['name'];
	$disc = $row['disc'];
	$price = $row['price'];
	$quan = $row['quan'];
}
?>
<html>
<head>	
	<title>Edit Data</title>
</head>

<body>
	<a href="index.php">Home</a>
	<br/><br/>
	
	<form name="form1" method="post" action="edit.php">
		<table border="0">
			<tr> 
				<td>Name</td>
				<td><input type="text" name="name" value="<?php echo $name;?>"></td>
			</tr>
			<tr> 
				<td>Description</td>
				<td><input type="text" name="disc" value="<?php echo $disc;?>"></td>
			</tr>
			<tr> 
				<td>Price</td>
				<td><input type="text" name="price" value="<?php echo $price;?>"></td>
			</tr>
			<tr> 
				<td>Quantity</td>
				<td><input type="text" name="quan" value="<?php echo $quan;?>"></td>
			</tr>
			<tr>
				<td><input type="hidden" name="id" value=<?php echo $_GET['id'];?>></td>
				<td><input type="submit" name="update" value="Update"></td>
			</tr>
		</table>
	</form>
</body>
</html>
