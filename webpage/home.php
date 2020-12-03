<!DOCTYPE html>

<?php

    session_start();
 

    if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true)
    {
        header("location: login.php");
        exit;
    }

    if(isset($_POST['pay'])){
     require_once ("connect.php");
     
    $sql = "UPDATE basic SET fine = 0 WHERE personID = ?";
            
    if($stmt = mysqli_prepare($dbc, $sql))
    {
        
        $param_id = $_SESSION["personID"];

        mysqli_stmt_bind_param($stmt, "i", $param_id);
                
        if(mysqli_stmt_execute($stmt))
        {       
            session_destroy();
            header("location: login.php");
            exit();
        } 
        else
        {
            echo "Oops! Something went wrong. Please try again later.";
        }

                // Close statement
        mysqli_stmt_close($stmt);
        // Close connection
        mysqli_close($dbc);
    }
    }
?>


<html>
<head>
    <link href='https://fonts.googleapis.com/css?family=Armata' rel='stylesheet'>
    <link href='https://fonts.googleapis.com/css?family=Aleo' rel='stylesheet'>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
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

        h1{
        font-family: 'Armata';
        color: #009999;
        font-size: 50px;
        font-weight: bolder;
        }

        p{
        font-family: 'Aleo';
        font-weight: bold;
        font-size: 30px;
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
        height: 45px;
        }
        a{
        font-family: 'Armata';
        color: white;
        font-weight: bold;
        font-size: 20px;
        }

        footer {
        background-color: #ff8000;
        padding: 10px;
        text-align: center;
        color: white;
        height: 35px;
        }
    </style>

	<title>HOME</title>
</head>
<body>
    <header>
        HOME PAGE
    </header>
    <center>
        <h1>
            <?php echo htmlspecialchars($_SESSION["vehicle_no"]); ?>
        </h1>
        <form action="home.php" method="post">
            <p>
                NAME : <?php echo htmlspecialchars($_SESSION["first_name"]);?> <?php echo htmlspecialchars($_SESSION["last_name"]); ?>
            </p>
            <p>
                EMAIL : <?php echo htmlspecialchars($_SESSION["email"]);?>
            </p>
            <p>
                PHONE : <?php echo htmlspecialchars($_SESSION["phone_no"]); ?>
            </p>
            <p>
                FINE : <?php echo htmlspecialchars($_SESSION["fine"]); ?>
            </p>
            
            <br>
            <button type="summit" name="pay">PAY FINE</button>
        </form>
    </center>
    <br><br><br><br><br>
    <footer>
        <a href="logout.php">LOGOUT</a>
    </footer>


</body>
</html>