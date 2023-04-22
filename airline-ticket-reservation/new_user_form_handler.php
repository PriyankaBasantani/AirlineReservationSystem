<html>
	<head>
		<title>Add New User</title>
	</head>
	<body>
		<?php
		 	
			
			if(isset($_POST['Submit']))
			{
				require_once('Database Connection file/mysqli_connect.php'); 

				$user_name=trim($_POST['username']);
				$password=$_POST['password'];
				$email_id=trim($_POST['email']);
				$name=$_POST['name'];
				$phone_no=trim($_POST['phone_no']);
				$address=$_POST['address'];
				

				$check_query="SELECT customer_id from Customer where customer_id = ?";
				$stmt = $dbc->prepare($check_query);
				$stmt->bind_param("s", $user_name);
				$stmt->execute();
				$result = $stmt->get_result();
				
				if($result->num_rows == 0)
				{
					$query="INSERT INTO Customer (customer_id,pwd,name,email,phone_no,address) VALUES (?,?,?,?,?,?)";
					$stmt=mysqli_prepare($dbc,$query);
					mysqli_stmt_bind_param($stmt,"ssssss",$user_name,$password,$name,$email_id,$phone_no,$address);
					mysqli_stmt_execute($stmt);
					$affected_rows=mysqli_stmt_affected_rows($stmt);
					mysqli_stmt_close($stmt);
					mysqli_close($dbc);
					
					if($affected_rows==1)
					{
						header('location:user_reg_success.php');
					}
					else
					{
						echo "Submit Error";
						echo mysqli_error();
					}
				}
				else
				{
					echo "<center><h1>Username already exists</h1></center>";
				}
			}
			else
			{
				header("Location: new_user.php");
				exit;
			}
			
		?>
	</body>
</html>