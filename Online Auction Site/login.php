<?php
require("config.php");

$fname = $email = $user_type = "";
$fname_err = $email_err = $user_type_err = $password_err = "";

if (isset($_POST["login_submit"])) {

    function test_input($form_data)
    {
        $form_data = stripslashes($form_data);
        $form_data = htmlspecialchars($form_data);
        return $form_data;
    }

    if ($_SERVER["REQUEST_METHOD"] == "POST") {

        //User type 
        if (empty($_POST["user_type"])) {
            $user_type_err = "User Type is required*";
        } else {
            $user_type = test_input($_POST["user_type"]);
        }

        //Email
        if (empty($_POST["email"])) {
            $email_err = "Email is required*";
        } else {
            $email = test_input($_POST["email"]);
            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $email_err = "Invalid email";
            }
        }

        //Password
        if (empty($_POST["password"])) {
            $password_err = "Password is required";
        } else {
            $password = test_input($_POST["password"]);
        }

        if ($email && $user_type && $password) {
            if ($user_type == "buyer") {

                $sql = "SELECT buyer_id , b_fname, b_lname, b_email, b_user_type , b_password FROM  auc_sys_buyer  WHERE b_email = '$email'";
                $password_db = "b_password";
                $user_type_db = "b_user_type";
            } elseif ($user_type == "seller") {

                $sql = "SELECT seller_id , s_fname, s_lname, s_email, s_user_type , s_password FROM  auc_sys_seller  WHERE s_email = '$email'";
                $password_db = "s_password";
                $user_type_db = "s_user_type";
            }

            $login_result = $conn->query($sql);

            if ($login_result->num_rows > 0) {
                while ($login_result_row = $login_result->fetch_assoc()) {
                    if (password_verify($password,  $login_result_row[$password_db])) {

                        if ($login_result_row[$user_type_db] == "seller") {

                            session_start();
                            $_SESSION["loggedin"] = true;
                            $_SESSION["id"] = $login_result_row["seller_id"];
                            $_SESSION["fname"] =  $login_result_row["s_fname"];
                            $_SESSION["email"] =  $login_result_row["s_email"];
                            $_SESSION["user_type"] =  $login_result_row["s_user_type"];

                            header("Location:seller_dashboard.php");
                        } elseif ($login_result_row[$user_type_db] == "buyer") {

                            session_start();
                            $_SESSION["loggedin"] = true;
                            $_SESSION["id"] = $login_result_row["buyer_id"];
                            $_SESSION["fname"] =  $login_result_row["b_fname"];
                            $_SESSION["email"] =  $login_result_row["b_email"];
                            $_SESSION["user_type"] =  $login_result_row["b_user_type"];

                            header("Location:buyer_dashboard.php");
                        }
                    } else {
                        $password_err = "Inocrrect password. PLease try again";
                    }
                }
            } else {
                $password_err = "User does not exist";
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
    <link rel="stylesheet" href="styles/login.css">
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
                    <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">

                        <h1 class="title">Login</h1>
                        <p class="title-tag">If you already have an account please login to proceed</p>
                        <hr class="hr-styles">

                        <div>
                            <div class="div-row">
                                <label class="input-label">E-mail:</label>
                                <input class="input-field" type="text" name="email" value="<?php echo $email; ?>">
                                <p class="error"><?php echo $email_err ?> </p>
                            </div>

                            <div class="div-row">
                                <label class="input-label">Password</label>
                                <input class="input-field" type="password" name="password">
                                <p class="error"><?php echo  $password_err ?> </p>
                            </div>

                            <div class="div-row-bottom">
                                <label class="input-label"> User Type</label>
                                <input class="radio-input" type="radio" name="user_type" value="buyer" <?php if (isset($user_type) && $user_type == "buyer") echo "checked"; ?>>Buyer
                                <input class="radio-input" type="radio" name="user_type" value="seller" <?php if (isset($user_type) && $user_type == "seller") echo "checked"; ?>>Seller
                                <p class="error"><?php echo $user_type_err ?> </p>
                            </div>

                            <div class="submit-btn-outer-div">
                                <div class="btn-div-login">
                                    <input class="btn btn-radius-2 btn-blue" type="submit" value="submit" name="login_submit">
                                </div>

                                <p class="tag-bottom-text"><a class="text-dec-rm" href="registration.php">Create new account</a></p>
                                <p class="tag-bottom-text"><a class="text-dec-rm" href="admin_login.php">Admin Login</a></p>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div>

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