<?php

require("config.php");
session_start();

if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true) {
    header("location: login.php");
    exit;
}
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="styles/main_styles.css">
     <link rel="stylesheet" href="styles/header.css">
    <link rel="stylesheet" href="styles/add_item.css">
    <link rel="stylesheet" href="styles/header.css">
    <style>
        .outer-div {
            background-color: #3e3c3c03;
            width: 700px;
            margin: auto;
            padding: 10px;
            margin-top: 100px;
            height: 600px;
            text-align: center;
            border-radius: 25px;
            border: 1px solid;
            padding: 10px;
            box-shadow: 5px 10px 18px #888888;
        }

        .inner-div {
            margin: 40px;
        }

        .button {
            background-color: #1c87c9b3;
            border: none;
            color: white;
            padding: 20px 34px;
            text-align: center;
            text-decoration: none;
            display: inline-block;
            font-size: 20px;
            margin: 4px 2px;
            cursor: pointer;
            width: 200px;
            border-radius: 20px;
        }

        .button:hover {
            background-color: #555;
        }

        .inner-inner-div {
            margin-top: 30px;
        }
    </style>
    
    
    
</head>


    
<body>

<header>

    <div id="header_bg" >
    <h1 id="header" style="color:red">BIDMI&nbsp;&nbsp;
     <a href="seller_dashboard.php" id="header">Seller Dashboard</a>&nbsp;&nbsp;
        <a href="buyer_dashboard.php" id="header"> Buyer Dashboard</a></h1>
        
        
        
		<?php echo  "<div style='font-size:30px;color:white;float:right;padding-right:20px'> Welcome "."{$_SESSION["fname"]} !</div>";
    
    ?>
        
        
    </div>
    
    
    
</header>

<div class="outer-div">
        <div class="inner-div">
            <h2>Welcome to Seller Dashboard</h2>
            <div class="inner-inner-div">
                <a class="button" href="add_item.php">Add Items</a><br>
                <a class="button" href="view_my_items.php">update my items</a><br>
                <a class="button" href=" delete_item.php">delete my items</a><br>
                <a class="button" href="logout.php">Logout</a><br>
            </div>
        </div>
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