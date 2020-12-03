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
        height: 55px;
        }
    </style>

</head>
<body>
<?php

    session_start();
 

    if(isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true)
    {
        header("location: home.php");
        exit;
    }
 

    require_once "connect.php";
 

    $vehicle_no = $password = "";
    $vehicle_no_err = $password_err = "";
 
    if($_SERVER["REQUEST_METHOD"] == "POST")
    {
 

        if(empty(trim($_POST["vehicle_no"])))
        {
            $vehicle_no_err = "Please enter vehicle_no.";
        } 
        else
        {
            $vehicle_no = trim($_POST["vehicle_no"]);
        }   
    
    
        if(empty(trim($_POST["password"])))
        {
            $password_err = "Please enter your password.";
        } 
        else
        {
            $password = trim($_POST["password"]);
        }
    
    
        if(empty($vehicle_no_err) && empty($password_err))
        {
       
            $sql = "SELECT  vehicle_no, password, first_name, last_name, email, phone_no, fine, personID FROM basic WHERE vehicle_no = ?";
        
            if($stmt = mysqli_prepare($dbc, $sql))
            {
            
                mysqli_stmt_bind_param($stmt, "s", $param_username);
            
            
                $param_username = $vehicle_no;
            
           
                if(mysqli_stmt_execute($stmt))
                {
                
                    mysqli_stmt_store_result($stmt);
                
                
                    if(mysqli_stmt_num_rows($stmt) == 1)
                    {                    
                    
                        mysqli_stmt_bind_result($stmt, $vehicle_no, $password, $first_name, $last_name, $email, $phone_no, $fine, $personID);
                        if(mysqli_stmt_fetch($stmt))
                        {
                       
                           
                            session_start();
                            
                            
                            $_SESSION["loggedin"] = true;
                            $_SESSION["personID"] = $personID;
                            $_SESSION["vehicle_no"] = $vehicle_no; 
                            $_SESSION["first_name"] = $first_name;
                            $_SESSION["last_name"] = $last_name;
                            $_SESSION["email"] = $email;
                            $_SESSION["phone_no"] = $phone_no;
                            $_SESSION["fine"] = $fine;                           
                            
                            
                            header("location: home.php");
                        } 
                        else
                        {
                            
                            $password_err = "The password you entered was not valid.";
                        }
                    
                    } 
                    else
                    {
                        echo "Oops! Something went wrong. Please try again later.";
                    }
                    mysqli_stmt_close($stmt);
                }
                else
                {
                    echo "eoor";
                }
            }
            else 
            {
                echo "eror";
            }
        
    
            mysqli_close($dbc);
        }
        else
        {
            echo "enter vechicle no and password";
        } 
    }
    else
    {
       
    }  

?>


 <center>
        <header>
            SIGN IN
        </header>
        <ul>
        <li><a  href="contact.html">Contact us</a></li>
        <li><a class="active" href="login.php">Sign into your accout</a></li>
        <li><a href="register.php">Create your account</a></li>
    </ul>
        <section>
        <br><br>

        <form action="login.php" method="post">
            <input type="text" name="vehicle_no" placeholder="Vehicle number">
            <br>
            <br>
            <input type="password" name="password" placeholder="Password">
            <br>
            <br>
            <button type="submit" name="submit">SIGN IN</button>
        </form>
        </section>

        <br>
        <br>
        <br>
        <br>
        <br>
        <br>
        <br>
        <br>
        <br>
        <br>
        <br>
        <br>
                
        <footer>
           
        </footer>
    </center>
</body>
</html>