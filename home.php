<?php  
include("auth.php");
include('server.php'); 
$upload_dir = 'uploads/..';
 
?>
<?php 
	if(isset($_GET['id'])){
		$id = $_GET['id'];
		$sql = "select * from info where id=".$id;
		$result = mysqli_query($db, $sql);
		if(mysqli_num_rows($result) > 0){
			$row = mysqli_fetch_assoc($result);
		}else{
			$errorMsg = 'Could not select a record';
		}
	}
	if (isset($_GET['edit'])) {
		$id = $_GET['edit'];
		$update = true;
		$record = mysqli_query($db, "SELECT * FROM info WHERE id=$id");

		if (count($record) == 1 ) {
			$record = mysqli_fetch_array($record);
			$name = $record['name'];
			$address = $record['address'];
			$id = $record['id'];
			$image = $record['image'];
		}
	}
?>
<!DOCTYPE html>
<html>
<head>
	<title>CRUD: CReate, Update, Delete PHP MySQL</title>
	<link rel="stylesheet" type="text/css" href="styles.css">
	<style>
	    table,tr,th,td
	    {
	    	border: 1px solid black;
	    	
	    }
		
	</style>

</head>
<body>
<?php if (isset($_SESSION['msg'])): ?>
	<div class="msg">
		<?php 
			echo $_SESSION['msg']; 
			unset($_SESSION['msg']);
		?>
	</div>
<?php endif ?>
<?php $results = mysqli_query($db, "SELECT * FROM info"); ?>

<table>
	
		<tr>
			<th>Id</th>
			<th>Name</th>
			<th>Address</th>
			<th colspan="2">Action</th>
			<th>Image</th>
		
	    </tr>
	

	
	<?php while ($row = mysqli_fetch_array($results)) { ?>
		<tr>
			<td><?php echo $row['id']; ?></td>
			<td><?php echo $row['name']; ?></td>
			<td><?php echo $row['address']; ?></td>
			<td><a href="home.php?edit=<?php echo $row['id']; ?>" class="edit_btn" >Edit</a></td>
			<td><a href="server.php?del=<?php echo $row['id']; ?>" class="del_btn">Delete</a></td>
			<td><img src="<?php echo $upload_dir.$row['image'] ?>" height="40"></td>

		</tr>
	
	<?php } ?>
</table>
<form action="upload.php" method="post" enctype="multipart/form-data">
    Select Image File to Upload:
    <input type="file" name="file">
    <input type="submit" name="submit" value="Upload">
</form>

    <form action="" method="post" enctype="multipart/form-data">
		
    <input type="hidden" name="id" value="<?php echo $id; ?>">

		<div class="input-group">
			<label>Name</label>
			<input type="text" name="name" value="<?php echo $name; ?>">
		</div>
		<div class="input-group">
			<label>Address</label>
			<input type="text" name="address" value="<?php echo $address; ?>">
		</div>
		<div class="input-group">
			<label>Image</label>
			<input type="file" name="file">
           
    
        </div>


		<div class="input-group">
<?php if ($update == true): ?>
	<button class="btn" type="submit" name="update" style="background: #556B2F;" >update</button>
<?php else: ?>
	<button class="btn" type="submit" name="save" >Save</button>
<?php endif ?>
		</div>
	</form>
	 <a href="logout.php">Logout</a>

</body>
</html>
