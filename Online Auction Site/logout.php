<?php

session_start();

if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true) {
    header("location: login.php");
    exit;
}

session_unset();
session_destroy();

?>

<!DOCTYPE html>
<html lang="en">


<header>

    <div id="header_bg" >
    <h1 id="header" style="color:red">BIDMI&nbsp;&nbsp;
     <a href="seller_dashboard.php" id="header">Seller Dashboard</a>&nbsp;&nbsp;
        <a href="buyer_dashboard.php" id="header"> Buyer Dashboard</a></h1>
    </div>
    
    
    
</header>    
    
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="styles/main_styles.css">
    <link rel="stylesheet" href="styles/add_item.css">
    <link rel="stylesheet" href="styles/header.css">
    <style>
        .outer_div {
            text-align: center;
            width: 50%;
            padding: 100px;
            margin:auto;
        }

        .top-text{
            padding-bottom: 30px;
            color: #877fb1;;
        }

        .para-text{
            padding-bottom: 10px;
        }

    </style>
</head>
<body>
    <div class="outer_div">
        <h1 class="top-text">You Have been Logged out...!</h1>
        <p class="para-text">Thank you for using Online Auction System</p>
        <a href="login.php">Login again</a>
    </div>
</body>
    
    <footer id="footer">
  <div id="list">  
<ul>
    <li><a href="#">&#169 2020 |</a></li>  
    <li><a href="#">Register For Free |</a></li>
    <li><a href="#">Privacy Policy |</a></li>
    <li><a href="#">Terms of Use |</a></li>
    <form>
    <input type="email" name="notification" placeholder="Your Email adress">
    <input type="submit" value="Connect" style="background-color:greenyellow">        
    <label for="notification" style="color:white">Connect us ! Be the First to Know Premier items delivered to your inbox.</label>
    
    </form>

 
</ul>    
</div>    
    
</footer>  
</html>