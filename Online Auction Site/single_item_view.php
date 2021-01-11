<?php
require("config.php");

session_start();

if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true) {
    header("location: login.php");
    exit;
}

$bid_err = "";

$item_id = $_SESSION["show_item_by_id"];
$sql = "SELECT * FROM auc_sys_item WHERE item_id = '$item_id'";
$item = $conn->query($sql);

if (isset($_POST["bid_btn"])) {

    $item_price = floatval($_POST["item_price"]);
    $bid_price = floatval($_POST["bid_price"]);

    if ($item_price > $bid_price) {
        $bid_err = "Bid price should be higher";
    } else {

        $buyer_id = $_SESSION["id"];
        $bid_price_str = sprintf("%.2f", $bid_price);

        $sql = "INSERT INTO auc_sys_bids(bid_price, buyer_id_fk, item_id_fk) VALUES( $bid_price_str, $buyer_id, $item_id)";

        if ($conn->query($sql) === TRUE) {
            $bid_err = "Bid successfull..!";
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
    <link rel="stylesheet" href="styles/single_item.css">
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

    <?php
    while ($row = $item->fetch_assoc()) {
        $seller_id_fk = $row["seller_id_fk"];
    ?>
        <div">
            <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">

                <input type="hidden" name="show_item_by_id" value="<?php echo $row["item_id"]; ?>">

                <?php $imageURL = 'uploads/' . $row["img_name"]; ?>
                <img  class="item-image"  src="<?php echo $imageURL; ?>" alt="image" alt="Item-Image">

                <p>Item Name : <?php echo $row["item_name"]; ?> </p>
                <p>Starting Price : <?php echo $row["item_price"]; ?> </p>

                <input type="hidden" name="item_price" value="<?php echo $row["item_price"]; ?>">

                <p>Auction Time left : <?php echo $row["due_time"]; ?> </p>

                Enter Your Bid Value: $ <input type="text" value="" name="bid_price" /> &nbsp;

                <input type="submit" value="Submit" name="bid_btn" />

                <p> <?php echo $bid_err; ?> </p>

            </form>
            </div>
        <?php } ?>

        <?php
        $sql = "SELECT * FROM auc_sys_seller WHERE seller_id = '$seller_id_fk'";
        $seller_data = $conn->query($sql);
        while ($seller_row = $seller_data->fetch_assoc()) {
        ?>
            <div>
                <h2>Seller Details</h2>
                <p>First Name: <?php echo $seller_row["s_fname"]; ?> </p>
                <p>Last Name: <?php echo $seller_row["s_lname"]; ?> </p>
                <p>Email Address: <?php echo $seller_row["s_email"]; ?> </p>
            </div>

        <?php } ?>

        <a href="store.php">Back to Store</a>
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