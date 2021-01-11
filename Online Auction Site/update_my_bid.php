<?php
require("config.php");

session_start();

$bid_err = "";
$bid_id_update = $_SESSION["update_bid_id"];


$sql = "SELECT * FROM auc_sys_bids WHERE bid_id='$bid_id_update'";
$bids = $conn->query($sql);

while ($bids_arr = $bids->fetch_assoc()) {

    $update_item_id =  $bids_arr["item_id_fk"];

    $sql = "SELECT * FROM auc_sys_item WHERE item_id='$update_item_id'";
    $item_price_update = $conn->query($sql);
    while ($items_arr_update = $item_price_update->fetch_assoc()) {
        $current_item_price =  $items_arr_update["item_price"];
        $update_item_name =  $items_arr_update["item_name"];
    }
}

if (isset($_POST["bid_update_btn"])) {

    $item_price = floatval($current_item_price);
    $bid_price = floatval($_POST["updating_bid_price"]);

    if ($item_price > $bid_price) {
        $bid_err = "Bid price should be higher than the item price";
    } else {

        $buyer_id = $_SESSION["id"];
        $bid_price_str = sprintf("%.2f", $bid_price);

        $sql = "UPDATE auc_sys_bids SET bid_price='$bid_price_str' WHERE bid_id = '$bid_id_update'";

        if ($conn->query($sql) === TRUE) {
            $bid_err = "Bid Updated successfully..!";
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="styles/main_styles.css">
    <link rel="stylesheet" href="styles/add_item.css">
    <link rel="stylesheet" href="styles/header.css">
    <!-- <link rel="stylesheet" href="styles/registration.css"> -->
</head>
    

<header>

    <div id="header_bg" >
    <h1 id="header" style="color:red">BIDMI&nbsp;&nbsp;
     <a href="seller_dashboard.php" id="header">Seller Dashboard</a>&nbsp;&nbsp;
        <a href="buyer_dashboard.php" id="header"> Buyer Dashboard</a></h1>
    	   
        
    </div>
    
    
    
</header>    
    
<body>
    <h1>Bid Update</h1>
    <hr>
    <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">

        <p>Item name : <?php echo $update_item_name; ?></p>
        <p>Current price of the item is : $ <?php echo $current_item_price; ?></p>
        Enter your new bid value: $ <input type="text" value="" name="updating_bid_price" /> &nbsp;
        
        <input type="submit" value="Submit" name="bid_update_btn" />
        <p> <?php echo $bid_err; ?> </p>
    </form>

    <a href="buyer_dashboard.php"a>Back to Dashboard</a>

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