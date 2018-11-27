<?php 
 $upload_dir = 'uploads/..';
	//session_start();
	$db = mysqli_connect('localhost', 'root', '', 'register');

	// initialize variables
	$name = "";
	$address = "";
	$id = 0;
	$update = false;
	$edit_state = false;
	


	if (isset($_POST['save'])) {
		$name = $_POST['name'];
		$address = $_POST['address'];
		$imgName = $_FILES['file']['name'];
		$imgTmp = $_FILES['file']['tmp_name'];
		$imgSize = $_FILES['file']['size'];
		$imgSize = $_FILES['file']['size'];
		
		
if(empty($name)){
			$errorMsg = 'Please input name';
		}elseif(empty($address)){
			$errorMsg = 'Please input address';
		}elseif(empty($imgName)){
			$errorMsg = 'Please select file';
		}else{
			//get image extension
			$imgExt = strtolower(pathinfo($imgName, PATHINFO_EXTENSION));
			//allow extenstion
			$allowExt  = array('jpeg', 'jpg', 'png', 'gif');
			//random new name for photo
			$userPic = time().'_'.rand(1000,9999).'.'.$imgExt;
			//check a valid image
			if(in_array($imgExt, $allowExt)){
				//check image size less than 5MB
				if($imgSize < 5000000){
					move_uploaded_file($imgTmp ,$upload_dir.$userPic);
				}else{
					$errorMsg = 'Image too large';
				}
			}else{
				$errorMsg = 'Please select a valid image';
			}
		}

		//check upload file not error than insert data to database
		if(!isset($errorMsg)){
			$sql = "insert into info(name, address, image)
					values('".$name."', '".$address."', '".$userPic."')";
			$result = mysqli_query($db, $sql);
			if($result){
				$successMsg = 'New record added successfully';
				header('location:home.php');
			}else{
				$errorMsg = 'Error '.mysqli_error($db);
			}
		}

	}

    // update records
	if (isset($_POST['update'])) {
	$id = $_POST['id'];
	$name = $_POST['name'];
	$address = $_POST['address'];
	$imgName = $_FILES['file']['name'];
	$imgTmp = $_FILES['file']['tmp_name'];
	$imgSize = $_FILES['file']['size'];

		if(empty($name)){
			$errorMsg = 'Please input name';
		}elseif(empty($address)){
			$errorMsg = 'Please input address';
		}

		//udate image if user select new image
		if($imgName){
			//get image extension
			$imgExt = strtolower(pathinfo($imgName, PATHINFO_EXTENSION));
			//allow extenstion
			$allowExt  = array('jpeg', 'jpg', 'png', 'gif');
			//random new name for photo
			$userPic = time().'_'.rand(1000,9999).'.'.$imgExt;
			//check a valid image
			if(in_array($imgExt, $allowExt)){
				//check image size less than 5MB
				if($imgSize < 5000000){
					//delete old image
					unlink($upload_dir.$row['image']);
					move_uploaded_file($imgTmp ,$upload_dir.$userPic);
				}else{
					$errorMsg = 'Image too large';
				}
			}else{
				$errorMsg = 'Please select a valid image';
			}
		}else{
			//if not select new image - use old image name
			$userPic = $row['image'];
		}

		//check upload file not error than insert data to database
		if(!isset($errorMsg)){
			$sql = "update info
									set name = '".$name."',
										address = '".$address."',
										image = '".$userPic."'
					where id=".$id;
			$result = mysqli_query($db, $sql);
			if($result){
				$successMsg = 'New record updated successfully';
				header('location:home.php');
			}else{
				$errorMsg = 'Error '.mysqli_error($db);
			}
		}

	}
    if (isset($_GET['del'])) {
	$id = $_GET['del'];
	mysqli_query($db, "DELETE FROM info WHERE id=$id");
	$_SESSION['message'] = "Address deleted!"; 
	header('location: home.php');
}

?>   