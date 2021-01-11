<?php

require("config.php");

session_start();


if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true) {
    header("location: login.php");
    exit;
}


$seller_id = $_SESSION["id"];
$item_del_err = "";

$sql = "SELECT * FROM auc_sys_item WHERE seller_id_fk = '$seller_id'";
$all_items = $conn->query($sql);

if (isset($_POST["delete_item"])) {

    $del_item_id = $_POST["del_item_by_id"];

    $sql = "SELECT * FROM auc_sys_bids WHERE item_id_fk = '$del_item_id'";
    $items_in_bid = $conn->query($sql);

    if ($items_in_bid->num_rows > 0) {
        $item_del_err = "This item has bids, Cannot be deleted..!";
    } else {

        $sql = "DELETE FROM auc_sys_item WHERE item_id = '$del_item_id'";

        if ($conn->query($sql) === TRUE) {
            $fname = $lname = $email = $user_type = $password = $conf_pass = "";
            $item_del_err = "Item Deleted Successfully";
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
    <link rel="stylesheet" href="styles/delete_item.css">
    <link rel="stylesheet" href="styles/add_item.css">
    <link rel="stylesheet" href="styles/header.css">
</head>


<header>

    <div id="header_bg" >
    <h1 id="header" style="color:red">BIDMI&nbsp;&nbsp;
     <a href="seller_dashboard.php" id="header">Seller Dashboard</a>&nbsp;&nbsp;
        <a href="buyer_dashboard.php" id="header"> Buyer Dashboard</a></h1>
        		<?php echo  "<div style='font-size:30px;color:white;float:right;padding-right:20px'> Welcome "."{$_SESSION["fname"]} !</div>";
    
    ?>
        
    </div>
    
    
    
</header>    
    
<body>
    <div class="outer-div-div">
        <div>
            <h1 class="title">Manage Items</h1>
            <p class="title-tag"> View your items and manage them here</p>
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
                <th>Due Date</th>
                <th>Manage</th>
            </tr>

            <?php while ($all_items_array = $all_items->fetch_assoc()) { ?>
                <tr>
                    <td>
                        <form class="store-form" method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
                            <input type="hidden" name="del_item_by_id" value="<?php echo $all_items_array["item_id"]; ?>">
                            <?php echo $all_items_array["item_id"]; ?>
                    </td>
                    <td>
                        <?php echo $all_items_array["item_name"]; ?>
                    </td>
                    <td>
                        $<?php echo $all_items_array["item_price"]; ?>
                    </td>
                    <td>
                        <?php echo $all_items_array["due_date"]; ?>
                    </td>
                    <td>
                        <input class="delete_btn" type="submit" value="Delete" name="delete_item" />
                    </td>
                </tr>
                </form>
            <?php } ?>
        </table>

        <div class="outer-bottom">
            <a class="dashboard-btn" href="seller_dashboard.php">Back to Dashboard</a>
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