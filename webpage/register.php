<!DOCTYPE html>
<html>
<head>
    <link href='https://fonts.googleapis.com/css?family=Armata' rel='stylesheet'>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Sign Up</title>
    <style>
        header{
        background-color: #ff8000;
        padding: 25px;
        font-family: 'Armata';
        font-weight: bold;
        text-align: center;
        font-size: 35px;
        color: white;
        }
        ul{
        list-style-type: none;
        margin: 0;
        padding: 0;
        overflow: hidden;
        background-color: #009999;
        font-family: 'Armata';
        font-weight: bold;
        font-size: 20px;
        }

        li{
        float: left;
        }

        li a{
        display: block;
        color: white;
        text-align: center;
        padding: 14px 16px;
        text-decoration: none;
        }

        li a:hover:not(.active) {
        background-color: #005757;
        }
        .active {
        background-color: #ff8000;
        }

        input{
        border: none;
        width:25%;
        height:20px;
        padding:10px 12px;
        border-bottom: 2px solid #009999;
        }

        button{
        background-color: #009999;
        border: none;
        color: white;
        font-weight: bold;
        font-size: 20px;
        padding: 16px 32px;
        text-decoration: none;
        margin: 1px 1px;
        cursor: pointer;
        width:25%;
        }

        section:after {
        content: "";
        display: table;
        clear: both;
        height: 13px;
        }

        footer {
        background-color: #ff8000;
        padding: 10px;
        text-align: center;
        color: white;
        height: 10px;
        }
    </style>

</head>
<body>
<?php

if(isset($_POST['submit'])){

	$data_missing = array();

	if(empty($_POST['first_name'])){
		$data_missing[] = 'FIRST NAME';
	}else{
		$first_name = trim($_POST['first_name']);
	}

	if(empty($_POST['last_name'])){
		$data_missing[] = 'LAST NAME';
	}else{
		$last_name = trim($_POST['last_name']);
	}

	if(empty($_POST['vehicle_no'])){
		$data_missing[] = 'VEHICLE NUMBER';
	}else{
		$vehicle_no = trim($_POST['vehicle_no']);
	}

	if(empty($_POST['license_no'])){
		$data_missing[] = 'LICENSE NUMBER';
	}else{
		$license_no = trim($_POST['license_no']);
	}

	if(empty($_POST['phone_no'])){
		$data_missing[] = 'PHONE NUMBER';
	}else{
		$phone_no = trim($_POST['phone_no']);
	}

	if(empty($_POST['email'])){
		$data_missing[] = 'EMAIL';
	}else{
		$email = trim($_POST['email']);
	}

	if(empty($_POST['password'])){
		$data_missing[] = 'PASSWORD';
	}else{
		$password = trim($_POST['password']);
	}



	if(empty($data_missing)){
		require_once('connect.php');

		$query = "INSERT INTO basic (first_name, last_name, vehicle_no, license_no, phone_no, email, password, personID) VALUES (?,?,?,?,?,?,?,NULL)";
		
		
		$stmt = mysqli_prepare($dbc, $query);
		

		
		mysqli_stmt_bind_param($stmt, "ssssiss", $first_name, $last_name, $vehicle_no, $license_no, $phone_no, $email, $password);
		

        mysqli_stmt_execute($stmt);
		

		$affected_rows = mysqli_stmt_affected_rows($stmt);
		

		if($affected_rows == 1)
		{
			

			mysqli_stmt_close($stmt);
			
            mysqli_close($dbc);
			
		}
		else
		{
			echo "Error has occured";
			echo mysqli_error();

            mysqli_stmt_close($stmt);

            mysqli_close($dbc);
		}
        


	}

	else{
		echo "You need to enter the following data";
		foreach ($data_missing as $missing) {
			echo "$missing<br />";
			# code...
		}
	}
}

?>

 <center>
        <header>
            SIGN UP
        </header>
        <ul>
        <li><a  href="contact.html">Contact us</a></li>
        <li><a href="login.php">Sign into your accout</a></li>
        <li><a class="active" href="register.php">Create your account</a></li>
    </ul>
        <section>
        <br><br>

        <form action="register.php" method="post">
            <input type="text" name="first_name" placeholder="First Name">
            <br>
            <br>
            <input type="text" name="last_name" placeholder="Last Name">
            <br>
            <br>
            <input type="text" name="vehicle_no" placeholder="Vehicle number">
            <br>
            <br>
            <input type="text" name="license_no" placeholder="License number">
            <br>
            <br>
            <input type="text" name="phone_no" placeholder="Phone number">
            <br>
            <br>
            <input type="text" name="email" placeholder="Email">
            <br>
            <br>
            <input type="password" name="password" placeholder="Password">
            <br>
            <br>
            <button type="submit" name="submit">SIGN UP</button>
        </form>
        </section>
        <footer>
            
        </footer>
    </center>
</body>
</html>