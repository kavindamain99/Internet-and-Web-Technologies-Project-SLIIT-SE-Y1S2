<?php
require("config.php");
session_start();

if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true) {
    header("location: login.php");
    exit;
}

$buyer_id = $_SESSION["id"];

$sql = "SELECT * FROM auc_sys_bids WHERE buyer_id_fk='$buyer_id'";
$bids_array = $conn->query($sql);

if (isset($_POST["bid_val_update"])) {

    $_SESSION["update_bid_id"] = $_POST["bid_id_update"];
    header("Location:update_my_bid.php");

}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>

    <link rel="stylesheet" href="styles/main_styles.css">
    <link rel="stylesheet" href="styles/my-bids-buyer.css">
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



    <div>
        <h1>My Bids</h1>
        <p>Current bids that are placed</p>
        <hr>
        <?php while ($row = $bids_array->fetch_assoc()) { ?>

            <?php
            $item_id = $row["item_id_fk"];
            $sql = "SELECT * FROM auc_sys_item WHERE item_id = ' $item_id'";
            $items = $conn->query($sql);
            $item_arr = $items->fetch_assoc()
            ?>

            <div>
                <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
                    <div>

                        <input type="hidden" name="bid_id_update" value="<?php echo $row["bid_id"]; ?>">

                        <div class="item-name">
                            <p><?php echo $item_arr["item_name"]; ?> </p>
                        </div>

                        <div class="bid-price">
                            <p>$ <?php echo $row["bid_price"]; ?> </p>
                        </div>

                        <div class="bid-update-btn">
                            <input type="submit" value="Update" name="bid_val_update" />
                        </div>
                    </div>
                </form>
            </div>

        <?php } ?>

        <a href="buyer_dashboard.php">Back to Dashboard</a>

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