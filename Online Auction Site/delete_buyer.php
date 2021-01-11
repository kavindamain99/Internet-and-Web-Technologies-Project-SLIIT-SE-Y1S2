<?php
require("config.php");

session_start();

if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true) {
    header("location: login.php");
    exit;
}

session_start();
$fname = $_SESSION["fname"];
if (isset($_POST["del_submit"])) {

    $id = $_SESSION["id"];
    $sql = "DELETE FROM auc_sys_buyer WHERE buyer_id='$id'";
    $user = $conn->query($sql);

    if ($conn->query($sql) === TRUE) {
        echo "Record deleted successfully";
        header("refresh:2; url=logout.php");
    } else {
        echo "Error deleting record: " . $conn->error;
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
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

    <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
        <p>Hello, <?php echo $fname ?> </p>
        <p>Are you sure you want to delete your account ? </p>
        <p>(Kinldy consider that this action cannot be undone..!)</p>
        <input type="submit" value="Yes" name="del_submit">
    </form>

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