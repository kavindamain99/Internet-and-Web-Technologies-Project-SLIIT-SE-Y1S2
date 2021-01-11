<?php
require("config.php");

session_start();

if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true) {
    header("location: login.php");
    exit;
}
$sql = "SELECT * FROM auc_sys_item ORDER BY item_id ASC";

$product_array = $conn->query($sql);

if (isset($_POST["view_item"])) {

    // echo $_POST["show_item_by_id"];

    $_SESSION["show_item_by_id"] = $_POST["show_item_by_id"];

    header("Location:single_item_view.php");
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>

    <link rel="stylesheet" href="styles/main_styles.css">
    <link rel="stylesheet" href="styles/store.css">
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

    <h1 class="store-heading">Live Auction</h1>
    <div class="main-div">
        <?php while ($row = $product_array->fetch_assoc()) { ?>
            <div class="product-item">
                <form class="store-form" method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
                    <input type="hidden" name="show_item_by_id" value="<?php echo $row["item_id"]; ?>">

                    <?php $imageURL = 'uploads/' . $row["img_name"]; ?>
                    <img class="item-image" src="<?php echo $imageURL; ?>" alt="Item-image">

                    <p class="item-name-style"> <?php echo $row["item_name"]; ?> </p>
                    <p class="item-price-style">$ <?php echo $row["item_price"]; ?> </p>
                    <p class="end-time-style">End Time : <?php echo $row["due_time"]; ?> </p>

                    <input class="bid-now-btn" type="submit" value="Bid Now" name="view_item" />
                </form>
            </div>
        <?php } ?>

        <a class="button" href="buyer_dashboard.php">Back to Dashboard</a>
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