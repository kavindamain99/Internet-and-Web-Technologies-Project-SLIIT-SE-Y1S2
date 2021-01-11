<?php

require("config.php");
session_start();


if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true) {
    header("location: login.php");
    exit;
}

$buyer_id = $_SESSION["id"];
$item_del_err = "";

$sql = "SELECT * FROM auc_sys_rm_items WHERE bid_winner_id = '$buyer_id' AND purchase_status = 'cart' ";
$cart_items = $conn->query($sql);


if (isset($_POST["purchase_item"])) {

   
}


?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>

    <link rel="stylesheet" href="styles/main_styles.css">
    <link rel="stylesheet" href="styles/delete_item.css">
    <link rel="stylesheet" href="styles/add_item.css">
    <link rel="stylesheet" href="styles/header.css">
</head>
    

<header>

    <div id="header_bg" >
    <h1 id="header" style="color:red">BIDMI&nbsp;&nbsp;
     <a href="seller_dashboard.php" id="header">Seller Dashboard</a>&nbsp;&nbsp;
        <a href="buyer_dashboard.php" id="header"> Buyer Dashboard</a></h1>
    </div>
    
    
    
</header>    

    
<body>
    <div class="outer-div-div">
        <div>
            <h1 class="title">Cart </h1>
            <p class="title-tag"> View your items won by bids and purchase them here</p>
            <hr class="hr-styles">
            <div class="outer-sub-class">
                <p class="error"><?php echo $item_del_err; ?></p>

            </div>
        </div>

        <table class="view-items">
            <tr>
                <th>Item ID</th>
                <th>Item Name</th>
                <th>Item Price</th>
                <th>Buy</th>
            </tr>

            <?php while ($cart_items_arr = $cart_items -> fetch_assoc()) { ?>
                <tr>
                    <td>
                        <form class="store-form" method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
                            <input type="hidden" name="" value="<?php echo $cart_items_arr["rm_id"]; ?>">
                            <?php echo $cart_items_arr["rm_id"]; ?>
                    </td>
                    <td>
                        <?php echo $cart_items_arr["item_name"]; ?>
                    </td>
                    <td>
                        $<?php echo $cart_items_arr["max_price"]; ?>
                    </td>
                    <td>
                        <input class="purchase_btn" type="submit" value="purchase" name="purchase_item" />
                    </td>
                </tr>
                </form>
            <?php } ?>
        </table>

        <div class="outer-bottom">
            <a class="dashboard-btn" href="buyer_dashboard.php">Back to Dashboard</a>
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