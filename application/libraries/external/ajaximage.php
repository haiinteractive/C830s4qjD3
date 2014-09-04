<?php
	
	include_once 'db.php';
	
	$path = "../../../files/ugc/uploads/";

	$valid_formats = array("jpg", "png", "gif", "bmp");
	
	$user_id = $_REQUEST['user_id'];
	
	if(isset($_POST) and $_SERVER['REQUEST_METHOD'] == "POST")
		{
			$name = $_FILES['photoimg']['name'];
			$size = $_FILES['photoimg']['size'];
			
			if(strlen($name))
				{
					list($txt, $ext) = explode(".", $name);
					if(in_array($ext,$valid_formats))
					{
					if( $size < (1024*1024) )
						{
							$actual_image_name = time().substr(str_replace(" ", "_", $txt), 5).".".$ext;
							$tmp = $_FILES['photoimg']['tmp_name'];
							
							if(move_uploaded_file($tmp, $path.$actual_image_name))
								{
									
									$query = "UPDATE tb_users SET user_avatar='$actual_image_name' WHERE user_id='$user_id'";
									
									$response = mysql_query($query);
									
									echo "<img src='/right/files/ugc/uploads/".$actual_image_name."'  class='preview' height='150px' width='120px;'>";
								}
							else
								echo $_FILES['photoimg']['error'];
								die;
						}
						else
						echo "Image file size max 1 MB";					
						}
						else
						echo "Invalid file format..";	
				}
				
			else
				echo "Please select image..!";
				
			exit;
		}
?>