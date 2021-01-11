<?php
require("config.php");

session_start();

if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true) {
    header("location: login.php");
    exit;
}

$fname_err = $lname_err = $email_err = "";

$id = $_SESSION["id"];
$sql = "SELECT * FROM auc_sys_buyer WHERE buyer_id = '$id'";
$user = $conn->query($sql);

if (isset($_POST["update_btn"])) {

    function test_input($form_data)
    {
        $form_data = stripslashes($form_data);
        $form_data = htmlspecialchars($form_data);
        return $form_data;
    }

    if ($_SERVER["REQUEST_METHOD"] == "POST") {

        //First name
        if (empty($_POST["fname"])) {
            $fname_err = "First name is required";
        } else {
            $fname = test_input($_POST["fname"]);
        }

        //Last name
        if (empty($_POST["lname"])) {
            $lname_err = "Last name is required";
        } else {
            $lname = test_input($_POST["lname"]);
        }

        //Email
        if (empty($_POST["email"])) {
            $email_err = "Email is required";
        } else {
            $email = test_input($_POST["email"]);
            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $email_err = "Invalid email";
            } else {

                $sql = "UPDATE auc_sys_buyer SET b_fname='$fname', b_lname='$lname', b_email='$email' WHERE buyer_id = '$id'";

                if ($conn->query($sql)) {
                    echo "Updated successfully";
                    header("refresh:2; url=buyer_dashboard.php");
                } else {
                    echo "Error updating record: " . mysqli_error($conn);
                }
            }
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
    <link rel="stylesheet" href="styles/update_buyer.css">
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
    <div class="outer-wrapper">
        <div class="card-wrapper">
            <div class="card-body">
                <div class="reg-form-div">
                    <?php while ($row = $user->fetch_assoc()) { ?>

                        <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
                            First Name: <input type="text" name="fname" value="<?php echo $row["b_fname"]; ?>"><br>
                            <p><?php echo  $fname_err ?> </p>

                            Last Name: <input type="text" name="lname" value="<?php echo $row["b_lname"]; ?>"><br>
                            <p><?php echo $lname_err ?> </p>

                            E-mail: <input type="text" name="email" value="<?php echo $row["b_email"]; ?>"><br>
                            <p><?php echo $email_err ?> </p>

                            <input type="submit" value="Update" name="update_btn">
                        </form>

                        <a href="buyer_dashboard.php">Back to dashboard</a>

                    <?php } ?>
                </div>
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